<<<<<<< HEAD
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
=======
class OrderController extends BaseController
{
private $orderModel;

public function __construct()
{
parent::__construct();
$this->orderModel = new OrderModel();
}

public function getList()
{
$orders = $this->orderModel->getAllOrders();
$this->loadView('order/list', ['orders' => $orders]);
}

public function getOrderDetail($orderId)
{
$order = $this->orderModel->getById($orderId);
if (!$order) {
die("❌ Lỗi: Không tìm thấy đơn hàng!");
}

$orderItems = $this->orderModel->getOrderItems($orderId);
$this->loadView('order/detail', [
'order' => $order,
'orderItems' => $orderItems
]);
}

public function updateOrderStatus($orderId, $status)
{
try {
$this->orderModel->updateStatus($orderId, $status);
$_SESSION['success'] = "✅ Cập nhật trạng thái đơn hàng thành công!";
} catch (Exception $e) {
$_SESSION['error'] = "❌ Lỗi: " . $e->getMessage();
}
header("Location: " . BASE_URL . "admin/?act=order&page=detail&id=" . $orderId);
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
header("Location: " . BASE_URL . "admin/?act=order&page=detail&id=" . $orderId);
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
>>>>>>> 426fad3974964d4c2adffc4060d861697f252430
