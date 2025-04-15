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