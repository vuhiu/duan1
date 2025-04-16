<?php
require_once __DIR__ . '/../../commons/connect.php';

class Order {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    // Lấy danh sách đơn hàng của user
    public function getUserOrders($user_id, $page = 1, $limit = 10) {
        $offset = ($page - 1) * $limit;
        
        $sql = "SELECT o.* 
                FROM orders o 
                WHERE o.user_id = :user_id 
                ORDER BY o.created_at DESC 
                LIMIT :limit OFFSET :offset";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy tổng số đơn hàng của user
    public function getUserTotalOrders($user_id) {
        $sql = "SELECT COUNT(*) FROM orders WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->fetchColumn();
    }

    // Lấy chi tiết đơn hàng của user
    public function getUserOrderDetail($order_id, $user_id) {
        // Lấy thông tin đơn hàng
        $sql = "SELECT o.* 
                FROM orders o 
                WHERE o.order_id = ? AND o.user_id = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$order_id, $user_id]);
        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$order) {
            return null;
        }

        // Lấy chi tiết sản phẩm trong đơn hàng
        $sql = "SELECT od.*, p.name as product_name, p.image, 
                       vc.color_name, vs.size_name
                FROM order_details od
                LEFT JOIN product_variants pv ON od.variant_id = pv.product_variant_id
                LEFT JOIN products p ON pv.product_id = p.product_id
                LEFT JOIN variant_colors vc ON pv.variant_color_id = vc.variant_color_id
                LEFT JOIN variant_size vs ON pv.variant_size_id = vs.variant_size_id
                WHERE od.order_id = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$order_id]);
        $order['items'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $order;
    }

    // Hủy đơn hàng
    public function cancelOrder($order_id, $user_id) {
        $sql = "UPDATE orders SET status = 'cancelled' 
                WHERE order_id = ? AND user_id = ? AND status = 'pending'";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$order_id, $user_id]);
    }
}
?>