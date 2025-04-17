<?php
require_once __DIR__ . '/../models/orderModel.php';

class OrderController
{
    private $orderModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
    }

    // Lấy danh sách đơn hàng của người dùng
    public function getOrders($userId)
    {
        try {
            $orders = $this->orderModel->getOrdersByUserId($userId);
            require_once __DIR__ . '/../views/order/list.php';
        } catch (Exception $e) {
            $_SESSION['error'] = "Lỗi khi lấy danh sách đơn hàng: " . $e->getMessage();
            header('Location: /duan1/index.php');
            exit();
        }
    }

    // Xem chi tiết đơn hàng
    public function getOrderDetail($order_id, $user_id)
    {
        if (!$order_id || !$user_id) {
            $_SESSION['error'] = "Dữ liệu không hợp lệ.";
            header('Location: /duan1/index.php?act=order&page=list');
            exit();
        }

        try {
            $orderModel = new OrderModel();
            $order = $orderModel->getOrderById($order_id, $user_id);

            if (!$order) {
                $_SESSION['error'] = "Không tìm thấy đơn hàng.";
                header('Location: /duan1/index.php?act=order&page=list');
                exit();
            }

            include __DIR__ . '/../views/order/detail.php';
        } catch (Exception $e) {
            $_SESSION['error'] = "Có lỗi xảy ra: " . $e->getMessage();
            header('Location: /duan1/index.php?act=order&page=list');
            exit();
        }
    }

    // Hủy đơn hàng
    public function cancel()
    {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = "Vui lòng đăng nhập để thực hiện chức năng này.";
            header('Location: /duan1/client/views/auth/form-login.php');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error'] = "Phương thức không hợp lệ";
            header('Location: /duan1/index.php?act=order&page=list');
            exit();
        }

        if (!isset($_POST['order_id'])) {
            $_SESSION['error'] = "Không tìm thấy mã đơn hàng.";
            header('Location: /duan1/index.php?act=order&page=list');
            exit();
        }

        $orderId = (int)$_POST['order_id'];
        $userId = $_SESSION['user_id'];

        try {
            if ($this->orderModel->cancelOrder($orderId, $userId)) {
                $_SESSION['success'] = "Hủy đơn hàng thành công.";
            } else {
                $_SESSION['error'] = "Không thể hủy đơn hàng.";
            }
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        // Redirect back to the order detail page if we came from there
        if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'page=detail') !== false) {
            header('Location: /duan1/index.php?act=order&page=detail&id=' . $orderId);
        } else {
            header('Location: /duan1/index.php?act=order&page=list');
        }
        exit();
    }

    // Hiển thị danh sách đơn hàng
    public function index()
    {
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
    public function detail()
    {
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

    // Lấy lịch sử đơn hàng của người dùng
    public function getHistory($userId)
    {
        try {
            $orders = $this->orderModel->getOrdersByUserId($userId);
            require_once __DIR__ . '/../views/order/history.php';
        } catch (Exception $e) {
            die("❌ Lỗi khi lấy lịch sử đơn hàng: " . $e->getMessage());
        }
    }

    // Theo dõi trạng thái đơn hàng
    public function getOrderStatus($orderId)
    {
        try {
            $orderStatus = $this->orderModel->getOrderStatus($orderId);
            require_once __DIR__ . '/../views/order/status.php';
        } catch (Exception $e) {
            die("❌ Lỗi khi lấy trạng thái đơn hàng: " . $e->getMessage());
        }
    }

    public function deleteOrder()
    {
        try {
            if (!isset($_SESSION['user_id'])) {
                throw new Exception("Bạn cần đăng nhập để thực hiện chức năng này!");
            }

            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception("Phương thức không hợp lệ!");
            }

            if (!isset($_POST['order_id'])) {
                throw new Exception("Thiếu thông tin đơn hàng!");
            }

            $orderId = $_POST['order_id'];
            $userId = $_SESSION['user_id'];

            if ($this->orderModel->deleteOrder($orderId, $userId)) {
                $_SESSION['success'] = "Xóa đơn hàng thành công!";
            } else {
                throw new Exception("Không thể xóa đơn hàng!");
            }
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        header('Location: /duan1/index.php?act=order&page=list');
        exit();
    }
}
