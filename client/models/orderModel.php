<?php
require_once __DIR__ . '/../../commons/BaseModel.php';

class OrderModel extends BaseModel
{
    protected $conn;

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
                    name, phone, email, address, amount, note, user_id, coupon_id, shipping_id,
                    payment_method, status, payment_status, created_at
                ) VALUES (
                    :name, :phone, :email, :address, :amount, :note, :user_id, :coupon_id, :shipping_id,
                    :payment_method, 'pending', 'unpaid', NOW()
                )
            ");

            $stmt->execute([
                'name' => $orderData['shipping_name'],
                'phone' => $orderData['shipping_phone'],
                'email' => $orderData['shipping_email'],
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
                WHERE product_variant_id = :variant_id 
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
        $sql = "SELECT od.*, o.order_id, o.product_id, o.variant_id, o.quantity,
                       p.name as product_name, p.image as product_image,
                       vc.color_name, vs.size_name, pv.price, pv.sale_price
                FROM order_details od
                LEFT JOIN orders o ON od.order_detail_id = o.order_detail_id
                LEFT JOIN products p ON o.product_id = p.product_id
                LEFT JOIN product_variants pv ON o.variant_id = pv.product_variant_id
                LEFT JOIN variant_colors vc ON pv.variant_color_id = vc.variant_color_id
                LEFT JOIN variant_size vs ON pv.variant_size_id = vs.variant_size_id
                WHERE od.user_id = :user_id
                ORDER BY od.created_at DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrderById($orderId, $userId = null)
    {
        $sql = "SELECT od.*, o.order_id, o.product_id, o.variant_id, o.quantity,
                       p.name as product_name, p.image as product_image,
                       vc.color_name, vs.size_name, pv.price, pv.sale_price
                FROM order_details od
                LEFT JOIN orders o ON od.order_detail_id = o.order_detail_id
                LEFT JOIN products p ON o.product_id = p.product_id
                LEFT JOIN product_variants pv ON o.variant_id = pv.product_variant_id
                LEFT JOIN variant_colors vc ON pv.variant_color_id = vc.variant_color_id
                LEFT JOIN variant_size vs ON pv.variant_size_id = vs.variant_size_id
                WHERE od.order_detail_id = :order_id";

        if ($userId) {
            $sql .= " AND od.user_id = :user_id";
        }

        $stmt = $this->conn->prepare($sql);
        $params = ['order_id' => $orderId];
        if ($userId) {
            $params['user_id'] = $userId;
        }

        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrderItems($orderId)
    {
        $stmt = $this->conn->prepare("
            SELECT o.*, p.name as product_name, p.image as product_image,
                   vc.color_name, vs.size_name, pv.price, pv.sale_price
            FROM orders o
            LEFT JOIN products p ON o.product_id = p.product_id
            LEFT JOIN product_variants pv ON o.variant_id = pv.product_variant_id
            LEFT JOIN variant_colors vc ON pv.variant_color_id = vc.variant_color_id
            LEFT JOIN variant_size vs ON pv.variant_size_id = vs.variant_size_id
            WHERE o.order_detail_id = :order_id
        ");
        $stmt->execute(['order_id' => $orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserOrders($user_id, $page = 1, $limit = 10)
    {
        $offset = ($page - 1) * $limit;

        $sql = "SELECT od.*, o.order_id, o.product_id, o.variant_id, o.quantity,
                       p.name as product_name, p.image as product_image,
                       vc.color_name, vs.size_name, pv.price, pv.sale_price
                FROM order_details od
                LEFT JOIN orders o ON od.order_detail_id = o.order_detail_id
                LEFT JOIN products p ON o.product_id = p.product_id
                LEFT JOIN product_variants pv ON o.variant_id = pv.product_variant_id
                LEFT JOIN variant_colors vc ON pv.variant_color_id = vc.variant_color_id
                LEFT JOIN variant_size vs ON pv.variant_size_id = vs.variant_size_id
                WHERE od.user_id = :user_id
                ORDER BY od.created_at DESC
                LIMIT :limit OFFSET :offset";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserTotalOrders($user_id)
    {
        $sql = "SELECT COUNT(DISTINCT od.order_detail_id) as total 
                FROM order_details od 
                WHERE od.user_id = :user_id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['user_id' => $user_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['total'];
    }

    public function getUserOrderDetail($order_id, $user_id)
    {
        return $this->getOrderById($order_id, $user_id);
    }

    public function getOrderStatus($orderId)
    {
        $sql = "SELECT status FROM order_details WHERE order_detail_id = :order_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['order_id' => $orderId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['status'] : null;
    }

    public function updateStatus($orderId, $status)
    {
        $validStatuses = ['pending', 'confirmed', 'shipping', 'delivered', 'cancelled'];
        if (!in_array($status, $validStatuses)) {
            throw new Exception("Trạng thái đơn hàng không hợp lệ!");
        }

        $sql = "UPDATE order_details SET status = ? WHERE order_detail_id = ?";
        return $this->update($sql, [$status, $orderId]);
    }

    public function updatePaymentStatus($orderId, $paymentStatus)
    {
        $validStatuses = ['unpaid', 'paid'];
        if (!in_array($paymentStatus, $validStatuses)) {
            throw new Exception("Trạng thái thanh toán không hợp lệ!");
        }

        $sql = "UPDATE order_details SET payment_status = ? WHERE order_detail_id = ?";
        return $this->update($sql, [$paymentStatus, $orderId]);
    }

    public function cancelOrder($orderId, $userId)
    {
        try {
            $this->conn->beginTransaction();

            // Kiểm tra đơn hàng tồn tại và thuộc về user
            $stmt = $this->conn->prepare("
                SELECT status FROM order_details 
                WHERE order_detail_id = :order_id 
                AND user_id = :user_id
            ");
            $stmt->execute([
                'order_id' => $orderId,
                'user_id' => $userId
            ]);
            $order = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$order) {
                throw new Exception("Đơn hàng không tồn tại hoặc không thuộc về bạn");
            }

            if ($order['status'] !== 'pending') {
                throw new Exception("Chỉ có thể hủy đơn hàng ở trạng thái chờ xác nhận");
            }

            // Cập nhật trạng thái đơn hàng thành đã hủy
            $stmt = $this->conn->prepare("
                UPDATE order_details 
                SET status = 'cancelled', 
                    updated_at = NOW() 
                WHERE order_detail_id = :order_id 
                AND user_id = :user_id
            ");

            $result = $stmt->execute([
                'order_id' => $orderId,
                'user_id' => $userId
            ]);

            if (!$result) {
                throw new Exception("Không thể hủy đơn hàng");
            }

            // Hoàn lại số lượng sản phẩm
            $stmt = $this->conn->prepare("
                SELECT variant_id, quantity 
                FROM orders 
                WHERE order_detail_id = :order_id
            ");
            $stmt->execute(['order_id' => $orderId]);
            $orderItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($orderItems as $item) {
                $stmt = $this->conn->prepare("
                    UPDATE product_variants 
                    SET quantity = quantity + :quantity 
                    WHERE product_variant_id = :variant_id
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
            throw $e;
        }
    }

    public function deleteOrder($orderId, $userId)
    {
        try {
            $this->conn->beginTransaction();

            // Kiểm tra đơn hàng tồn tại và đã bị hủy
            $order = $this->getOrderById($orderId, $userId);
            if (!$order || $order[0]['status'] !== 'cancelled') {
                throw new Exception("Không thể xóa đơn hàng này.");
            }

            // Xóa các bản ghi trong bảng orders
            $stmt = $this->conn->prepare("DELETE FROM orders WHERE order_detail_id = ? AND user_id = ?");
            $stmt->execute([$orderId, $userId]);

            // Xóa bản ghi trong bảng order_details
            $stmt = $this->conn->prepare("DELETE FROM order_details WHERE order_detail_id = ? AND user_id = ?");
            $stmt->execute([$orderId, $userId]);

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            throw $e;
        }
    }
}
