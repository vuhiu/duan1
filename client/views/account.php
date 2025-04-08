<!-- filepath: c:\laragon\www\duan1\client\views\account.php -->
<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['user']['user_id'])) {
    header("Location: form-login.php");
    exit();
}

$userId = $_SESSION['user']['user_id'];
$sql = "SELECT name, email, phone, address FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<h2>Thông tin tài khoản</h2>
<p><strong>Họ tên:</strong> <?= htmlspecialchars($user['name']) ?></p>
<p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
<p><strong>Số điện thoại:</strong> <?= htmlspecialchars($user['phone']) ?></p>
<p><strong>Địa chỉ:</strong> <?= htmlspecialchars($user['address']) ?></p>