<?php
class OrderModel
{
    private $conn;

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    public function createOrder($userId, $orderData)
    {
        try {
            $this->conn->beginTransaction();

            // Tạo đơn hàng mới
            $stmt = $this->conn->prepare("
                INSERT INTO orders (
                    user_id, shipping_name, shipping_phone, shipping_address,
                    payment_method, payment_status, order_status, subtotal,
                    shipping_fee, discount, total_amount, created_at
                ) VALUES (
                    :user_id, :shipping_name, :shipping_phone, :shipping_address,
                    :payment_method, 'pending', 'pending', :subtotal,
                    :shipping_fee, :discount, :total_amount, NOW()
                )
            ");

            $result = $stmt->execute([
                'user_id' => $userId,
                'shipping_name' => $orderData['shipping_name'],
                'shipping_phone' => $orderData['shipping_phone'],
                'shipping_address' => $orderData['shipping_address'],
                'payment_method' => $orderData['payment_method'],
                'subtotal' => $orderData['subtotal'],
                'shipping_fee' => $orderData['shipping_fee'],
                'discount' => $orderData['discount'],
                'total_amount' => $orderData['total_amount']
            ]);

            if (!$result) {
                throw new Exception("Không thể tạo đơn hàng");
            }

            $orderId = $this->conn->lastInsertId();

            // Thêm chi tiết đơn hàng
            $stmt = $this->conn->prepare("
                INSERT INTO order_items (
                    order_id, product_id, variant_id, quantity,
                    price, color_name, size_name
                ) VALUES (
                    :order_id, :product_id, :variant_id, :quantity,
                    :price, :color_name, :size_name
                )
            ");

            foreach ($orderData['items'] as $item) {
                $result = $stmt->execute([
                    'order_id' => $orderId,
                    'product_id' => $item['product_id'],
                    'variant_id' => $item['variant_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'color_name' => $item['color_name'],
                    'size_name' => $item['size_name']
                ]);

                if (!$result) {
                    throw new Exception("Không thể thêm chi tiết đơn hàng");
                }

                // Cập nhật số lượng sản phẩm
                if (!$this->updateProductQuantity($item['variant_id'], $item['quantity'])) {
                    throw new Exception("Không thể cập nhật số lượng sản phẩm");
                }
            }

            $this->conn->commit();
            return $orderId;
        } catch (Exception $e) {
            $this->conn->rollBack();
            error_log("Error creating order: " . $e->getMessage());
            throw $e;
        }
    }

    private function updateProductQuantity($variantId, $quantity)
    {
        try {
            $stmt = $this->conn->prepare("
                UPDATE product_variants 
                SET quantity = quantity - :quantity 
                WHERE variant_id = :variant_id 
                AND quantity >= :check_quantity
            ");

            $result = $stmt->execute([
                'variant_id' => $variantId,
                'quantity' => $quantity,
                'check_quantity' => $quantity
            ]);

            if ($stmt->rowCount() === 0) {
                throw new Exception("Sản phẩm không đủ số lượng trong kho");
            }

            return true;
        } catch (Exception $e) {
            error_log("Error updating product quantity: " . $e->getMessage());
            throw $e;
        }
    }

    private function clearCart($userId)
    {
        $stmt = $this->conn->prepare("DELETE FROM cart WHERE user_id = :user_id");
        return $stmt->execute(['user_id' => $userId]);
    }

    public function getOrdersByUserId($userId)
    {
        $stmt = $this->conn->prepare("
            SELECT * FROM orders 
            WHERE user_id = :user_id 
            ORDER BY order_date DESC
        ");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrderById($orderId, $userId = null)
    {
        $sql = "SELECT * FROM orders WHERE order_id = :order_id";
        if ($userId) {
            $sql .= " AND user_id = :user_id";
        }

        $stmt = $this->conn->prepare($sql);
        $params = ['order_id' => $orderId];
        if ($userId) {
            $params['user_id'] = $userId;
        }

        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getOrderItems($orderId)
    {
        $stmt = $this->conn->prepare("
            SELECT oi.*, p.name, p.image
            FROM order_items oi
            JOIN products p ON oi.product_id = p.product_id
            WHERE oi.order_id = :order_id
        ");
        $stmt->execute(['order_id' => $orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function cancelOrder($orderId, $userId)
    {
        try {
            $this->conn->beginTransaction();

            // Kiểm tra đơn hàng
            $order = $this->getOrderById($orderId, $userId);
            if (!$order || $order['status'] !== 'pending') {
                throw new Exception("Không thể hủy đơn hàng này.");
            }

            // Cập nhật trạng thái đơn hàng
            $stmt = $this->conn->prepare("
                UPDATE orders 
                SET status = 'cancelled', 
                    updated_at = NOW() 
                WHERE order_id = :order_id 
                AND user_id = :user_id
            ");
            $stmt->execute([
                'order_id' => $orderId,
                'user_id' => $userId
            ]);

            // Hoàn lại số lượng sản phẩm
            $orderItems = $this->getOrderItems($orderId);
            foreach ($orderItems as $item) {
                $stmt = $this->conn->prepare("
                    UPDATE product_variants 
                    SET quantity = quantity + :quantity 
                    WHERE variant_id = :variant_id
                ");
                $stmt->execute([
                    'variant_id' => $item['variant_id'],
                    'quantity' => $item['quantity']
                ]);
            }

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            error_log("Error cancelling order: " . $e->getMessage());
            return false;
        }
    }
}
