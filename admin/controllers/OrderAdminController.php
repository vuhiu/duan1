<?php
require_once __DIR__ . '/../models/order.php';

class OrderAdminController {
    private $orderModel;

    public function __construct() {
        $this->orderModel = new Order();
    }

    // Lấy danh sách đơn hàng
    public function getList() {
        try {
            $orders = $this->orderModel->getAllOrders();
            require_once __DIR__ . '/../views/order/listOrder.php';
        } catch (Exception $e) {
            die("❌ Lỗi khi lấy danh sách đơn hàng: " . $e->getMessage());
        }
    }

    // Hiển thị chi tiết đơn hàng để chỉnh sửa
    public function editOrder() {
        try {
            if (!isset($_GET['order_id']) || !is_numeric($_GET['order_id'])) {
                die("❌ Lỗi: ID đơn hàng không hợp lệ!");
            }

            $orderId = $_GET['order_id'];
            $order = $this->orderModel->getById($orderId);

            if (!$order) {
                die("❌ Lỗi: Đơn hàng không tồn tại!");
            }

            require_once __DIR__ . '/../views/order/editOrder.php';
        } catch (Exception $e) {
            die("❌ Lỗi khi hiển thị chi tiết đơn hàng: " . $e->getMessage());
        }
    }

    // Cập nhật trạng thái đơn hàng và thanh toán
    public function updateOrder() {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $orderId = $_POST['order_id'];
                $status = $_POST['status'];
                $paymentStatus = $_POST['payment_status'];

                $this->orderModel->updateStatus($orderId, $status);
                $this->orderModel->updatePaymentStatus($orderId, $paymentStatus);

                header('Location: ?act=order&page=list');
                exit();
            }
        } catch (Exception $e) {
            die("❌ Lỗi khi cập nhật đơn hàng: " . $e->getMessage());
        }
    }
}