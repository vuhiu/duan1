<?php
require_once __DIR__ . '/../../commons/connect.php';

class Order {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    // Lấy tất cả đơn hàng
    public function getAllOrders() {
        $stmt = $this->conn->query("
            SELECT o.order_id, o.user_id, o.product_id, o.quantity, od.status, od.payment_status, od.payment_method
            FROM orders o
            JOIN order_details od ON o.order_detail_id = od.order_detail_id
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy đơn hàng theo ID
    public function getById($orderId) {
        $stmt = $this->conn->prepare("
            SELECT o.order_id, o.user_id, o.product_id, o.quantity, od.status, od.payment_status, od.payment_method
            FROM orders o
            JOIN order_details od ON o.order_detail_id = od.order_detail_id
            WHERE o.order_id = ?
        ");
        $stmt->execute([$orderId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Cập nhật trạng thái đơn hàng
    public function updateStatus($orderId, $status) {
        $stmt = $this->conn->prepare("
            UPDATE order_details 
            SET status = ? 
            WHERE order_detail_id = (SELECT order_detail_id FROM orders WHERE order_id = ?)
        ");
        return $stmt->execute([$status, $orderId]);
    }

    // Cập nhật trạng thái thanh toán
    public function updatePaymentStatus($orderId, $paymentStatus) {
        $stmt = $this->conn->prepare("
            UPDATE order_details 
            SET payment_status = ? 
            WHERE order_detail_id = (SELECT order_detail_id FROM orders WHERE order_id = ?)
        ");
        return $stmt->execute([$paymentStatus, $orderId]);
    }
}