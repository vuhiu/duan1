<?php
require_once __DIR__ . '/../../commons/connect.php';

class Order {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    // Lấy danh sách đơn hàng
    public function getOrders($page = 1, $limit = 10) {
        $offset = ($page - 1) * $limit;
        
        $sql = "SELECT o.*, u.fullname as customer_name 
                FROM orders o 
                LEFT JOIN users u ON o.user_id = u.user_id 
                ORDER BY o.created_at DESC 
                LIMIT :limit OFFSET :offset";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy tổng số đơn hàng
    public function getTotalOrders() {
        $sql = "SELECT COUNT(*) FROM orders";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    // Lấy chi tiết đơn hàng
    public function getOrderDetail($order_id) {
        // Lấy thông tin đơn hàng
        $sql = "SELECT o.*, u.fullname as customer_name, u.email, u.phone, u.address
                FROM orders o 
                LEFT JOIN users u ON o.user_id = u.user_id 
                WHERE o.order_id = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$order_id]);
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

    // Cập nhật trạng thái đơn hàng
    public function updateStatus($order_id, $status) {
        $sql = "UPDATE orders SET status = ? WHERE order_id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$status, $order_id]);
    }
}