<!-- filepath: c:\laragon\www\duan1\client\views\orders.php -->
<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['user']['user_id'])) {
    header("Location: form-login.php");
    exit();
}

$userId = $_SESSION['user']['user_id'];
$sql = "SELECT o.order_id, od.name, od.amount, od.status, od.payment_status, od.created_at 
        FROM orders o
        JOIN order_details od ON o.order_detail_id = od.order_detail_id
        WHERE o.user_id = ?
        ORDER BY od.created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->execute([$userId]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Đơn hàng của bạn</h2>
<?php if ($orders): ?>
    <ul>
        <?php foreach ($orders as $order): ?>
            <li>
                Mã đơn: <?= $order['order_id'] ?> |
                Tên: <?= htmlspecialchars($order['name']) ?> |
                Tổng: <?= number_format($order['amount'], 0, ',', '.') ?>đ |
                Trạng thái: <?= $order['status'] ?> |
                Thanh toán: <?= $order['payment_status'] ?> |
                Ngày: <?= $order['created_at'] ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Chưa có đơn hàng nào.</p>
<?php endif; ?>