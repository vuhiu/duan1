<?php
require_once __DIR__ . '/../../commons/BaseModel.php';

class OrderModel extends BaseModel
{
    public function createOrder($userId, $orderData)
    {
        try {
            $this->conn->beginTransaction();
<<<<<<< HEAD
    
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
=======

            // Tạo order_details trước
            $stmt = $this->conn->prepare("
                INSERT INTO order_details (
                    name, email, phone, address,
                    amount, note, user_id, coupon_id,
                    shipping_id, payment_method, status,
                    payment_status, created_at
                ) VALUES (
                    :name, :email, :phone, :address,
                    :amount, :note, :user_id, :coupon_id,
                    :shipping_id, :payment_method, 'pending',
                    'unpaid', NOW()
                )
            ");

            $result = $stmt->execute([
                'name' => $orderData['name'],
                'email' => $orderData['email'],
                'phone' => $orderData['phone'],
                'address' => $orderData['address'],
                'amount' => $orderData['total_amount'],
                'note' => $orderData['note'] ?? '',
                'user_id' => $userId,
                'coupon_id' => $orderData['coupon_id'] ?? 0,
                'shipping_id' => $orderData['shipping_id'],
                'payment_method' => $orderData['payment_method']
            ]);

            if (!$result) {
                throw new Exception("Không thể tạo chi tiết đơn hàng");
            }

            $orderDetailId = $this->conn->lastInsertId();

            // Thêm các sản phẩm vào bảng orders
            $stmt = $this->conn->prepare("
                INSERT INTO orders (
                    user_id, product_id, variant_id,
                    order_detail_id, quantity, created_at
                ) VALUES (
                    :user_id, :product_id, :variant_id,
                    :order_detail_id, :quantity, NOW()
                )
            ");

            foreach ($orderData['items'] as $item) {
                $result = $stmt->execute([
>>>>>>> 426fad3974964d4c2adffc4060d861697f252430
                    'user_id' => $userId,
                    'product_id' => $item['product_id'],
                    'variant_id' => $item['variant_id'],
                    'order_detail_id' => $orderDetailId,
                    'quantity' => $item['quantity']
                ]);
<<<<<<< HEAD
    
=======

                if (!$result) {
                    throw new Exception("Không thể thêm sản phẩm vào đơn hàng");
                }

>>>>>>> 426fad3974964d4c2adffc4060d861697f252430
                // Cập nhật số lượng sản phẩm
                if (!$this->updateProductQuantity($item['variant_id'], $item['quantity'])) {
                    throw new Exception("Không thể cập nhật số lượng sản phẩm");
                }
            }
<<<<<<< HEAD
    
=======

            // Xóa giỏ hàng sau khi đặt hàng thành công
            $this->clearCart($userId);

>>>>>>> 426fad3974964d4c2adffc4060d861697f252430
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
        try {
            // Lấy cart_id của user
            $stmt = $this->conn->prepare("SELECT id FROM carts WHERE user_id = :user_id");
            $stmt->execute(['user_id' => $userId]);
            $cart = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($cart) {
                // Xóa cart_items trước
                $stmt = $this->conn->prepare("DELETE FROM cart_items WHERE cart_id = :cart_id");
                $stmt->execute(['cart_id' => $cart['id']]);

                // Sau đó xóa cart
                $stmt = $this->conn->prepare("DELETE FROM carts WHERE id = :cart_id");
                $stmt->execute(['cart_id' => $cart['id']]);
            }

            return true;
        } catch (Exception $e) {
            error_log("Error clearing cart: " . $e->getMessage());
            return false;
        }
    }

    public function getOrdersByUserId($user_id)
    {
<<<<<<< HEAD
        $sql = "SELECT o.*, od.name, od.phone, od.address, od.amount, od.note, od.status, od.payment_status, od.created_at
                FROM orders o
                LEFT JOIN order_details od ON o.order_detail_id = od.order_detail_id
                WHERE o.user_id = :user_id
                ORDER BY od.created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['user_id' => $user_id]);
=======
        $stmt = $this->conn->prepare("
            SELECT DISTINCT od.*
            FROM order_details od
            WHERE od.user_id = :user_id 
            ORDER BY od.created_at DESC
        ");
        $stmt->execute(['user_id' => $userId]);
>>>>>>> 426fad3974964d4c2adffc4060d861697f252430
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrderById($orderId, $userId = null)
    {
        $sql = "SELECT od.*, u.name as user_name, u.email as user_email, u.phone as user_phone,
                       c.coupon_code, c.coupon_value, c.coupon_type,
                       s.shipping_name, s.shipping_prices
                FROM order_details od
                LEFT JOIN users u ON od.user_id = u.user_id
                LEFT JOIN coupons c ON od.coupon_id = c.coupon_id
                LEFT JOIN ships s ON od.shipping_id = s.ship_id
                WHERE od.order_detail_id = ?";

        if ($userId) {
            $sql .= " AND od.user_id = ?";
            return $this->getOne($sql, [$orderId, $userId]);
        }

        return $this->getOne($sql, [$orderId]);
    }

    public function getOrderItems($orderId)
    {
        $sql = "SELECT o.*, 
                       p.name as product_name, 
                       p.image as product_image,
                       pv.price, pv.sale_price,
                       vc.color_name, vs.size_name,
                       CASE 
                           WHEN pv.sale_price > 0 THEN pv.sale_price * o.quantity
                           ELSE pv.price * o.quantity
                       END as total_amount
                FROM orders o
                JOIN products p ON o.product_id = p.product_id
                LEFT JOIN product_variants pv ON o.variant_id = pv.product_variant_id
                LEFT JOIN variant_colors vc ON pv.variant_color_id = vc.variant_color_id
                LEFT JOIN variant_size vs ON pv.variant_size_id = vs.variant_size_id
                WHERE o.order_detail_id = ?";
        return $this->getAll($sql, [$orderId]);
    }

    public function cancelOrder($orderId, $userId)
    {
        try {
            error_log("Starting cancelOrder in model - orderId: $orderId, userId: $userId");

            $this->conn->beginTransaction();
            error_log("Transaction started");

            // Kiểm tra đơn hàng
            $order = $this->getOrderById($orderId, $userId);
            error_log("Order found: " . json_encode($order));

            if (!$order) {
                error_log("Order not found");
                throw new Exception("Không tìm thấy đơn hàng.");
            }

            if ($order['status'] !== 'pending') {
                error_log("Invalid order status: " . $order['status']);
                throw new Exception("Chỉ có thể hủy đơn hàng ở trạng thái chờ xác nhận.");
            }

            // Lấy danh sách sản phẩm trong đơn hàng
            $orderItems = $this->getOrderItems($orderId);
            error_log("Order items found: " . json_encode($orderItems));

            // Cập nhật trạng thái đơn hàng
            $stmt = $this->conn->prepare("
                UPDATE order_details 
                SET status = 'cancelled',
                    updated_at = NOW()
                WHERE order_detail_id = :order_id 
                AND user_id = :user_id
                AND status = 'pending'
            ");

            $params = [
                'order_id' => $orderId,
                'user_id' => $userId
            ];
            error_log("Executing update with params: " . json_encode($params));

            $stmt->execute($params);
            $updatedRows = $stmt->rowCount();
            error_log("Updated rows: $updatedRows");

            if ($updatedRows === 0) {
                error_log("No rows updated in order_details");
                throw new Exception("Không thể cập nhật trạng thái đơn hàng.");
            }

            // Hoàn lại số lượng sản phẩm
            foreach ($orderItems as $item) {
                error_log("Processing item: " . json_encode($item));

                // Kiểm tra số lượng hiện tại
                $checkStmt = $this->conn->prepare("
                    SELECT quantity 
                    FROM product_variants 
                    WHERE product_variant_id = :variant_id
                ");
                $checkStmt->execute(['variant_id' => $item['variant_id']]);
                $currentQuantity = $checkStmt->fetchColumn();
                error_log("Current quantity for variant {$item['variant_id']}: $currentQuantity");

                $stmt = $this->conn->prepare("
                    UPDATE product_variants 
                    SET quantity = quantity + :quantity,
                        updated_at = NOW()
                    WHERE product_variant_id = :variant_id
                ");

                $params = [
                    'variant_id' => $item['variant_id'],
                    'quantity' => $item['quantity']
                ];
                error_log("Updating product quantity with params: " . json_encode($params));

                $stmt->execute($params);
                $updatedRows = $stmt->rowCount();
                error_log("Updated rows for variant {$item['variant_id']}: $updatedRows");

                if ($updatedRows === 0) {
                    error_log("Failed to update quantity for variant {$item['variant_id']}");
                    throw new Exception("Không thể hoàn lại số lượng sản phẩm.");
                }
            }

            error_log("All updates successful, committing transaction");
            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            error_log("Error in cancelOrder: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            $this->conn->rollBack();
            throw $e;
        }
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

    public function deleteOrder($orderId, $userId)
    {
        try {
            $this->conn->beginTransaction();

            // Kiểm tra đơn hàng tồn tại và đã bị hủy
            $order = $this->getOrderById($orderId, $userId);
            if (!$order || $order['status'] !== 'cancelled') {
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
