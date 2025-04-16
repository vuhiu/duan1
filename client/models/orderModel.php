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
    
            // Tạo chi tiết đơn hàng trong bảng order_details
            $stmt = $this->conn->prepare("
                INSERT INTO order_details (
                    name, phone, address, amount, note, user_id, coupon_id, shipping_id,
                    payment_method, status, payment_status, created_at
                ) VALUES (
                    :name, :phone, :address, :amount, :note, :user_id, :coupon_id, :shipping_id,
                    :payment_method, 'pending', 'unpaid', NOW()
                )
            ");
    
            $stmt->execute([
                'name' => $orderData['shipping_name'],
                'phone' => $orderData['shipping_phone'],
                'address' => $orderData['shipping_address'],
                'amount' => $orderData['total_amount'],
                'note' => $orderData['note'],
                'user_id' => $userId,
                'coupon_id' => $orderData['coupon_id'],
                'shipping_id' => $orderData['shipping_id'],
                'payment_method' => $orderData['payment_method']
            ]);
    
            $orderDetailId = $this->conn->lastInsertId();
    
            // Tạo đơn hàng trong bảng orders
            $stmt = $this->conn->prepare("
                INSERT INTO orders (
                    user_id, product_id, variant_id, order_detail_id, quantity, created_at
                ) VALUES (
                    :user_id, :product_id, :variant_id, :order_detail_id, :quantity, NOW()
                )
            ");
    
            foreach ($orderData['items'] as $item) {
                $stmt->execute([
                    'user_id' => $userId,
                    'product_id' => $item['product_id'],
                    'variant_id' => $item['variant_id'],
                    'order_detail_id' => $orderDetailId,
                    'quantity' => $item['quantity']
                ]);
    
                // Cập nhật số lượng sản phẩm
                if (!$this->updateProductQuantity($item['variant_id'], $item['quantity'])) {
                    throw new Exception("Không thể cập nhật số lượng sản phẩm");
                }
            }
    
            $this->conn->commit();
            return $orderDetailId;
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

    public function getOrdersByUserId($user_id)
    {
        $sql = "SELECT o.*, od.name, od.phone, od.address, od.amount, od.note, od.status, od.payment_status, od.created_at
                FROM orders o
                LEFT JOIN order_details od ON o.order_detail_id = od.order_detail_id
                WHERE o.user_id = :user_id
                ORDER BY od.created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['user_id' => $user_id]);
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
