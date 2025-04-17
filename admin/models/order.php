<?php
require_once __DIR__ . '/../../commons/connect.php';

class Order
{
    private $conn;

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    // Lấy tất cả đơn hàng
    public function getAllOrders()
    {
        $stmt = $this->conn->query("
            SELECT 
                od.*,
                u.name as user_name,
                u.email as user_email
            FROM order_details od
            LEFT JOIN users u ON od.user_id = u.user_id
            ORDER BY od.created_at DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy đơn hàng theo ID
    public function getById($orderId)
    {
        $stmt = $this->conn->prepare("
            SELECT 
                od.*,
                u.name as user_name,
                u.email as user_email,
                u.phone as user_phone,
                u.address as user_address,
                c.coupon_code,
                c.coupon_value,
                c.coupon_type,
                s.shipping_name,
                s.shipping_prices
            FROM order_details od
            LEFT JOIN users u ON od.user_id = u.user_id
            LEFT JOIN coupons c ON od.coupon_id = c.coupon_id
            LEFT JOIN ships s ON od.shipping_id = s.ship_id
            WHERE od.order_detail_id = ?
        ");
        $stmt->execute([$orderId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Lấy chi tiết các sản phẩm trong đơn hàng
    public function getOrderItems($orderId)
    {
        $stmt = $this->conn->prepare("
            SELECT 
                o.*,
                p.name as product_name,
                p.image as product_image,
                pv.price as variant_price,
                pv.sale_price as variant_sale_price,
                vc.color_name,
                vs.size_name,
                (o.quantity * COALESCE(pv.sale_price, pv.price)) as subtotal
            FROM orders o
            JOIN products p ON o.product_id = p.product_id
            LEFT JOIN product_variants pv ON o.variant_id = pv.product_variant_id
            LEFT JOIN variant_colors vc ON pv.variant_color_id = vc.variant_color_id
            LEFT JOIN variant_size vs ON pv.variant_size_id = vs.variant_size_id
            WHERE o.order_detail_id = ?
        ");
        $stmt->execute([$orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Cập nhật trạng thái đơn hàng
    public function updateStatus($orderId, $status)
    {
        try {
            $this->conn->beginTransaction();

            // Cập nhật trạng thái đơn hàng
            $stmt = $this->conn->prepare("
                UPDATE order_details 
                SET 
                    status = ?,
                    updated_at = NOW()
                WHERE order_detail_id = ?
            ");
            $stmt->execute([$status, $orderId]);

            // Nếu đơn hàng bị hủy, cập nhật lại số lượng sản phẩm
            if ($status === 'cancelled') {
                $items = $this->getOrderItems($orderId);
                foreach ($items as $item) {
                    $stmt = $this->conn->prepare("
                        UPDATE product_variants 
                        SET quantity = quantity + ?
                        WHERE product_variant_id = ?
                    ");
                    $stmt->execute([$item['quantity'], $item['variant_id']]);
                }
            }

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            error_log($e->getMessage());
            return false;
        }
    }

    // Cập nhật trạng thái thanh toán
    public function updatePaymentStatus($orderId, $paymentStatus)
    {
        $stmt = $this->conn->prepare("
            UPDATE order_details 
            SET 
                payment_status = ?,
                updated_at = NOW()
            WHERE order_detail_id = ?
        ");
        return $stmt->execute([$paymentStatus, $orderId]);
    }
}
