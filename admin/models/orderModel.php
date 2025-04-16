<?php
require_once __DIR__ . '/../../commons/BaseModel.php';
require_once __DIR__ . '/../../commons/connect.php';

class OrderModel extends BaseModel
{
    public function getAllOrders()
    {
        $sql = "SELECT * FROM order_details ORDER BY created_at DESC";
        return $this->getAll($sql);
    }

    public function getById($orderId)
    {
        try {
            // Get order details directly from order_details table
            $sql = "SELECT * FROM order_details WHERE order_detail_id = ?";
            $order = $this->getOne($sql, [$orderId]);

            if ($order) {
                // Get order items
                $sql = "SELECT o.*, p.name as product_name, p.image as product_image,
                        vc.color_name, vs.size_name, pv.price, pv.sale_price
                        FROM orders o
                        LEFT JOIN products p ON o.product_id = p.product_id
                        LEFT JOIN product_variants pv ON o.variant_id = pv.product_variant_id
                        LEFT JOIN variant_colors vc ON pv.variant_color_id = vc.variant_color_id
                        LEFT JOIN variant_size vs ON pv.variant_size_id = vs.variant_size_id
                        WHERE o.order_detail_id = ?";
                $items = $this->getAll($sql, [$orderId]);

                foreach ($items as &$item) {
                    $item['price'] = $item['sale_price'] > 0 ? $item['sale_price'] : $item['price'];
                    $item['product_image'] = $item['product_image'] ?? 'default.jpg';
                }

                $order['items'] = $items;
            }

            return $order;
        } catch (Exception $e) {
            error_log("Error in OrderModel::getById: " . $e->getMessage());
            return null;
        }
    }

    public function getOrderItems($orderId)
    {
        $sql = "SELECT o.*, p.name as product_name, p.image as product_image,
                       vc.color_name, vs.size_name, pv.price
                FROM orders o
                LEFT JOIN products p ON o.product_id = p.product_id
                LEFT JOIN product_variants pv ON o.variant_id = pv.product_variant_id
                LEFT JOIN variant_colors vc ON pv.variant_color_id = vc.variant_color_id
                LEFT JOIN variant_size vs ON pv.variant_size_id = vs.variant_size_id
                WHERE o.order_detail_id = ?";
        return $this->getAll($sql, [$orderId]);
    }

    public function updateStatus($orderId, $status)
    {
        $sql = "UPDATE order_details SET status = ? WHERE order_detail_id = ?";
        return $this->update($sql, [$status, $orderId]);
    }

    public function updatePaymentStatus($orderId, $paymentStatus)
    {
        $sql = "UPDATE order_details SET payment_status = ? WHERE order_detail_id = ?";
        return $this->update($sql, [$paymentStatus, $orderId]);
    }

    public function getTotalOrders()
    {
        $sql = "SELECT COUNT(*) as total FROM order_details";
        $result = $this->getOne($sql);
        return $result['total'] ?? 0;
    }

    public function getPendingOrders()
    {
        $sql = "SELECT COUNT(*) as total FROM order_details WHERE status = 'pending'";
        $result = $this->getOne($sql);
        return $result['total'] ?? 0;
    }

    public function getCompletedOrders()
    {
        $sql = "SELECT COUNT(*) as total FROM order_details WHERE status = 'delivered'";
        $result = $this->getOne($sql);
        return $result['total'] ?? 0;
    }

    public function getCancelledOrders()
    {
        try {
            $sql = "SELECT COUNT(*) FROM order_details WHERE status = 'cancelled'";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            throw new Exception("Lỗi khi đếm đơn hàng đã hủy: " . $e->getMessage());
        }
    }

    public function getUnknownStatusOrders()
    {
        try {
            $sql = "SELECT COUNT(*) FROM order_details WHERE status NOT IN ('pending', 'confirmed', 'shipping', 'delivered', 'cancelled')";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            throw new Exception("Lỗi khi đếm đơn hàng không xác định: " . $e->getMessage());
        }
    }
}
