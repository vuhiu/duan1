<?php
require_once __DIR__ . '/../models/order.php';

class OrderController {
    private $orderModel;

    public function __construct() {
        $this->orderModel = new Order();
    }

    // Lấy lịch sử đơn hàng của người dùng
    public function getHistory($userId) {
        try {
            $orders = $this->orderModel->getOrdersByUserId($userId);
            require_once __DIR__ . '/../views/order/history.php';
        } catch (Exception $e) {
            die("❌ Lỗi khi lấy lịch sử đơn hàng: " . $e->getMessage());
        }
    }

    // Theo dõi trạng thái đơn hàng
    public function getOrderStatus($orderId) {
        try {
            $orderStatus = $this->orderModel->getOrderStatus($orderId);
            require_once __DIR__ . '/../views/order/status.php';
        } catch (Exception $e) {
            die("❌ Lỗi khi lấy trạng thái đơn hàng: " . $e->getMessage());
        }
    }
}
?>