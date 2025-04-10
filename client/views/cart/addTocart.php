<?php
//debug để kiểm tra xem output được tạo ra từ đâu.
if (headers_sent($file, $line)) {
    die("Headers đã được gửi tại file $file, dòng $line");
} 
ob_start(); // Bật bộ đệm đầu ra
// Kiểm tra và khởi tạo session nếu chưa được khởi tạo
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
//Đảm bảo rằng $_SESSION['user_id'] được kiểm tra trước khi thêm sản phẩm vào giỏ hàng.
if (!isset($_SESSION['user_id'])) {
    header('Location: /duan1/client/views/auth/form-login.php');
    exit();
}
require_once __DIR__ . '/../../controllers/cartController.php';

use Client\Controllers\CartController; // Sử dụng namespace đúng

$cartController = new CartController();
if (!isset($_SESSION['user_id'])) {
    header('Location: /duan1/client/views/auth/form-login.php');
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<pre>";
    print_r($_POST); // Kiểm tra dữ liệu gửi từ form
    echo "</pre>";

    $user_id = $_SESSION['user_id']; // Lấy user_id từ session
    $product_id = $_POST['product_id'] ?? null;
    $variant_id = $_POST['variant_id'] ?? null; 
    $quantity = $_POST['quantity'] ?? 1; // Mặc định số lượng là 1

    // Kiểm tra các giá trị bắt buộc
    if (!$product_id || !$variant_id) {
        die("❌ Lỗi: Thiếu thông tin cần thiết để thêm vào giỏ hàng.");
    }

    // Thêm sản phẩm vào giỏ hàng
    $cartController->addToCart($user_id, $product_id, $variant_id, $quantity);

    // Chuyển hướng đến trang giỏ hàng
    header('Location: /duan1/client/views/cart/cart.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thêm sản phẩm vào giỏ hàng</title>
</head>

<body>
    <div class="container mt-5">
        <h1>Thêm sản phẩm vào giỏ hàng</h1>
        <form method="POST" action="/duan1/client/views/cart/addTocart.php">
            <div class="mb-3">
                <label for="product_id" class="form-label">ID Sản phẩm:</label>
                <input type="number" id="product_id" name="product_id" class="form-control" value="1" required>
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
        <a href="/duan1/client/views/cart/cart.php" class="btn btn-secondary mt-3">Quay lại giỏ hàng</a>
    </div>
</body>

</html>