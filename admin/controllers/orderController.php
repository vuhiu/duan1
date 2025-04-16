<?php
require_once __DIR__ . '/../models/order.php';

class OrderController {
    private $orderModel;

    public function __construct() {
        $this->orderModel = new Order();
    }

    // Hiển thị danh sách đơn hàng
    public function index() {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 10;
        
        $orders = $this->orderModel->getOrders($page, $limit);
        $totalOrders = $this->orderModel->getTotalOrders();
        $totalPages = ceil($totalOrders / $limit);

        require_once __DIR__ . '/../views/order/index.php';
    }

    // Hiển thị chi tiết đơn hàng
    public function detail() {
        if (!isset($_GET['id'])) {
            $_SESSION['error'] = "ID đơn hàng không hợp lệ";
            header("Location: index.php?act=donhang");
            exit;
        }

        $order_id = $_GET['id'];
        $order = $this->orderModel->getOrderDetail($order_id);

        if (!$order) {
            $_SESSION['error'] = "Không tìm thấy đơn hàng";
            header("Location: index.php?act=donhang");
            exit;
        }

        require_once __DIR__ . '/../views/order/detail.php';
    }

    // Cập nhật trạng thái đơn hàng
    public function updateStatus() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error'] = "Phương thức không hợp lệ";
            header("Location: index.php?act=donhang");
            exit;
        }

        $order_id = $_POST['order_id'];
        $status = $_POST['status'];

        if ($this->orderModel->updateStatus($order_id, $status)) {
            $_SESSION['success'] = "Cập nhật trạng thái đơn hàng thành công";
        } else {
            $_SESSION['error'] = "Cập nhật trạng thái đơn hàng thất bại";
        }

        header("Location: index.php?act=donhang&id=" . $order_id);
        exit;
    }
}
?> 