<!-- filepath: c:\laragon\www\duan1\client\views\favorites.php -->
<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['user']['user_id'])) {
    header("Location: form-login.php");
    exit();
}

$userId = $_SESSION['user']['user_id'];
$sql = "SELECT p.name, p.price 
        FROM favorites f
        JOIN products p ON f.product_id = p.product_id
        WHERE f.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$userId]);
$favorites = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Sản phẩm yêu thích</h2>
<?php if ($favorites): ?>
    <ul>
        <?php foreach ($favorites as $fav): ?>
            <li><?= htmlspecialchars($fav['name']) ?> - <?= number_format($fav['price'], 0, ',', '.') ?>đ</li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Chưa có sản phẩm yêu thích.</p>
<?php endif; ?>