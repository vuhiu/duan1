<?php
require_once __DIR__ . '/../../commons/connect.php';

class Order {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    // Lấy lịch sử đơn hàng của người dùng
    public function getOrdersByUserId($userId) {
        $stmt = $this->conn->prepare("
            SELECT o.order_id, o.product_id, o.quantity, od.status, od.payment_status, od.payment_method, o.created_at
            FROM orders o
            JOIN order_details od ON o.order_detail_id = od.order_detail_id
            WHERE o.user_id = ?
            ORDER BY o.created_at DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy trạng thái đơn hàng theo ID
    public function getOrderStatus($orderId) {
        $stmt = $this->conn->prepare("
            SELECT od.status, od.payment_status, od.payment_method
            FROM orders o
            JOIN order_details od ON o.order_detail_id = od.order_detail_id
            WHERE o.order_id = ?
        ");
        $stmt->execute([$orderId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>