<?php
require_once __DIR__ . '/../models/order.php';

class OrderController {
    private $orderModel;

    public function __construct() {
        $this->orderModel = new Order();
    }

    // Hiển thị danh sách đơn hàng
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }

        $user_id = $_SESSION['user_id'];
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 10;
        
        $orders = $this->orderModel->getUserOrders($user_id, $page, $limit);
        $totalOrders = $this->orderModel->getUserTotalOrders($user_id);
        $totalPages = ceil($totalOrders / $limit);

        require_once __DIR__ . '/../views/order/index.php';
    }

    // Hiển thị chi tiết đơn hàng
    public function detail() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }

        if (!isset($_GET['id'])) {
            $_SESSION['error'] = "ID đơn hàng không hợp lệ";
            header("Location: /orders");
            exit;
        }

        $user_id = $_SESSION['user_id'];
        $order_id = $_GET['id'];
        $order = $this->orderModel->getUserOrderDetail($order_id, $user_id);

        if (!$order) {
            $_SESSION['error'] = "Không tìm thấy đơn hàng";
            header("Location: /orders");
            exit;
        }

        require_once __DIR__ . '/../views/order/detail.php';
    }

    // Hủy đơn hàng
    public function cancel() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error'] = "Phương thức không hợp lệ";
            header("Location: /orders");
            exit;
        }

        $user_id = $_SESSION['user_id'];
        $order_id = $_POST['order_id'];

        if ($this->orderModel->cancelOrder($order_id, $user_id)) {
            $_SESSION['success'] = "Hủy đơn hàng thành công";
        } else {
            $_SESSION['error'] = "Không thể hủy đơn hàng";
        }

        header("Location: /orders");
        exit;
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