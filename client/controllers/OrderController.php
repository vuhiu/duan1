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

        $orderModel = new OrderModel();
        $order = $orderModel->getOrderById($order_id, $user_id);

        if (!$order) {
            $_SESSION['error'] = "Không tìm thấy đơn hàng.";
            header('Location: /duan1/index.php?act=order&page=list');
            exit();
        }

        $orderItems = $orderModel->getOrderItems($order_id);

        include __DIR__ . '/../views/order/detail.php';
    }

    // Hủy đơn hàng
    public function cancelOrder()
    {
        error_log("Start cancelOrder in OrderController");

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            error_log("Invalid request method: " . $_SERVER['REQUEST_METHOD']);
            header('Location: /duan1/index.php?act=order&page=list');
            exit();
        }

        if (!isset($_SESSION['user_id'])) {
            error_log("User not logged in");
            $_SESSION['error'] = "Vui lòng đăng nhập để thực hiện chức năng này.";
            header('Location: /duan1/client/views/auth/form-login.php');
            exit();
        }

        $orderId = isset($_POST['order_id']) ? (int)$_POST['order_id'] : 0;
        error_log("Received order_id: " . $orderId);

        if (!$orderId) {
            error_log("Invalid order_id");
            $_SESSION['error'] = "Không tìm thấy mã đơn hàng.";
            header('Location: /duan1/index.php?act=order&page=list');
            exit();
        }

        try {
            // Kiểm tra đơn hàng có tồn tại và thuộc về user không
            $order = $this->orderModel->getOrderById($orderId, $_SESSION['user_id']);
            error_log("Order found: " . json_encode($order));

            if (!$order) {
                error_log("Order not found or not owned by user");
                throw new Exception("Không tìm thấy đơn hàng hoặc bạn không có quyền hủy đơn hàng này.");
            }

            // Kiểm tra trạng thái đơn hàng
            if ($order['status'] !== 'pending') {
                error_log("Invalid order status: " . $order['status']);
                throw new Exception("Chỉ có thể hủy đơn hàng ở trạng thái chờ xác nhận.");
            }

            // Thực hiện hủy đơn hàng
            error_log("Attempting to cancel order");
            $result = $this->orderModel->cancelOrder($orderId, $_SESSION['user_id']);
            error_log("Cancel order result: " . ($result ? "success" : "failed"));

            if ($result) {
                $_SESSION['success'] = "Hủy đơn hàng thành công.";
            } else {
                throw new Exception("Không thể hủy đơn hàng.");
            }

            // Chuyển hướng về trang chi tiết nếu request từ trang chi tiết
            if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'page=detail') !== false) {
                header('Location: /duan1/index.php?act=order&page=detail&id=' . $orderId);
            } else {
                header('Location: /duan1/index.php?act=order&page=list');
            }
        } catch (Exception $e) {
            error_log("Error in cancelOrder: " . $e->getMessage());
            $_SESSION['error'] = $e->getMessage();
            header('Location: /duan1/index.php?act=order&page=list');
        }
        exit();
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
