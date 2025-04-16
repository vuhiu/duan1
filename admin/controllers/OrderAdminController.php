<?php
require_once __DIR__ . '/../models/OrderModel.php';
require_once __DIR__ . '/BaseController.php';

class OrderAdminController extends BaseController
{
    private $orderModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
    }

    // Lấy danh sách đơn hàng
    public function getList()
    {
        try {
            // Lấy thống kê đơn hàng
            $totalOrders = $this->orderModel->getTotalOrders();
            $pendingOrders = $this->orderModel->getPendingOrders();
            $completedOrders = $this->orderModel->getCompletedOrders();
            $cancelledOrders = $this->orderModel->getCancelledOrders();
            $unknownStatusOrders = $this->orderModel->getUnknownStatusOrders();

            // Lấy danh sách đơn hàng
            $orders = $this->orderModel->getAllOrders();
            require_once __DIR__ . '/../views/order/list.php';
        } catch (Exception $e) {
            die("❌ Lỗi: " . $e->getMessage());
        }
    }

    // Hiển thị chi tiết đơn hàng
    public function getOrderDetail($orderId)
    {
        try {
            $order = $this->orderModel->getById($orderId);
            if (!$order) {
                $_SESSION['error'] = "❌ Không tìm thấy đơn hàng!";
                header("Location: index.php?act=order&page=list");
                exit();
            }

            // Lấy thông tin chi tiết đơn hàng
            $order['items'] = $this->orderModel->getOrderItems($orderId);

            // Load view với dữ liệu đơn hàng
            require_once __DIR__ . '/../views/order/detail.php';
        } catch (Exception $e) {
            $_SESSION['error'] = "❌ Lỗi: " . $e->getMessage();
            header("Location: index.php?act=order&page=list");
            exit();
        }
    }

    // Hiển thị chi tiết đơn hàng để chỉnh sửa
    public function editOrder()
    {
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
    public function updateOrder()
    {
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

    public function updateOrderStatus($orderId, $status)
    {
        try {
            // Luôn cập nhật trạng thái thành 'delivered' khi xác nhận đơn hàng
            if ($status === 'confirmed') {
                $status = 'delivered';
            }

            $this->orderModel->updateStatus($orderId, $status);

            // Cập nhật trạng thái thanh toán thành 'paid' khi đơn hàng được giao
            if ($status === 'delivered') {
                $this->orderModel->updatePaymentStatus($orderId, 'paid');
            }

            $_SESSION['success'] = "✅ Cập nhật trạng thái đơn hàng thành công!";
        } catch (Exception $e) {
            $_SESSION['error'] = "❌ Lỗi: " . $e->getMessage();
        }
        header("Location: index.php?act=order&page=detail&id=" . $orderId);
        exit();
    }

    public function updatePaymentStatus($orderId, $paymentStatus)
    {
        try {
            $this->orderModel->updatePaymentStatus($orderId, $paymentStatus);
            $_SESSION['success'] = "✅ Cập nhật trạng thái thanh toán thành công!";
        } catch (Exception $e) {
            $_SESSION['error'] = "❌ Lỗi: " . $e->getMessage();
        }
        header("Location: index.php?act=order&page=detail&id=" . $orderId);
        exit();
    }

    public function cancelOrder($orderId)
    {
        try {
            $this->orderModel->updateStatus($orderId, 'cancelled');
            $_SESSION['success'] = "✅ Hủy đơn hàng thành công!";
        } catch (Exception $e) {
            $_SESSION['error'] = "❌ Lỗi: " . $e->getMessage();
        }
        header("Location: " . BASE_URL . "admin/?act=order&page=detail&id=" . $orderId);
        exit();
    }
}
