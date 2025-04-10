<?php
ob_start(); // Bật bộ đệm đầu ra

// Kiểm tra và khởi tạo session nếu chưa được khởi tạo
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    header('Location: /duan1/client/views/auth/form-login.php');
    exit();
}

require_once __DIR__ . '/../../controllers/cartController.php';

use Client\Controllers\CartController; // Sử dụng namespace đúng

$cartController = new CartController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $product_id = $_POST['product_id'] ?? null;
    $variant_id = $_POST['variant_id'] ?? null;
    $quantity = $_POST['quantity'] ?? 1;

    // Kiểm tra dữ liệu đầu vào
    if (!$product_id || !$variant_id) {
        die("❌ Lỗi: Thiếu thông tin cần thiết để thêm vào giỏ hàng.");
    }

    try {
        // Gọi phương thức thêm sản phẩm vào giỏ hàng
        $cartController->addToCart($user_id, $product_id, $variant_id, $quantity);

        // Chuyển hướng về trang danh sách giỏ hàng
        header('Location: /duan1/index.php?act=cart&page=list');
        exit();
    } catch (Exception $e) {
        die("❌ Lỗi: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thêm sản phẩm vào giỏ hàng</title>
    <link type="text/css" rel="stylesheet" href="/duan1/css/bootstrap.min.css" />
</head>

<body>
    <div class="container mt-5">
        <h1>Thêm sản phẩm vào giỏ hàng</h1>
        <!-- filepath: c:\xampp\htdocs\duan1\client\views\cart\addTocart.php -->
        <form method="POST" action="/duan1/index.php?act=cart&page=add">
            <div class="mb-3">
                <label for="product_id" class="form-label">ID Sản phẩm:</label>
                <input type="number" id="product_id" name="product_id" class="form-control" value="3" required>
            </div>
            <div class="mb-3">
                <label for="variant_id" class="form-label">ID Biến thể:</label>
                <input type="number" id="variant_id" name="variant_id" class="form-control" value="1" required>
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Số lượng:</label>
                <input type="number" id="quantity" name="quantity" class="form-control" value="1" required>
            </div>
            <button type="submit" class="btn btn-primary">Thêm vào giỏ hàng</button>
        </form>
        <a href="/duan1/client/views/cart/list.php" class="btn btn-secondary mt-3">Quay lại giỏ hàng</a>
    </div>
</body>

</html>