<!-- filepath: c:\xampp\htdocs\duan1\index.php -->
<?php
// Kết nối database & Load cấu hình
require __DIR__ . '/commons/connect.php';
require __DIR__ . '/commons/env.php';
require __DIR__ . '/client/controllers/ProductController.php';
require __DIR__ . '/client/controllers/CartController.php';

// Kiểm tra & nạp file header
$headerPath = __DIR__ . '/client/views/layout/header.php';
if (file_exists($headerPath)) {
    include $headerPath;
} else {
    die("Lỗi: Không tìm thấy file header.php");
}

// Xử lý router
$act = isset($_GET['act']) ? $_GET['act'] : '';
$page = isset($_GET['page']) ? $_GET['page'] : '';

$productController = new ProductController();
$cartController = new CartController();

switch ($act) {
    case "":
        // Gọi trang chủ
        $productController->getAllProducts();
        break;

    case 'product':
        // Gọi trang chi tiết sản phẩm
        $productController->getProductDetail();
        break;

    case 'cart':
        // Điều hướng các hành động liên quan đến giỏ hàng
        switch ($page) {
            case 'list':
                $cartController->getCart(1); // Pass user_id (e.g., 1 for testing)
                break;

            case 'add':
                $cartController->addToCart();
                break;

            case 'delete':
                $cartController->deleteFromCart();
                break;

            default:
                echo "Lỗi: Không tìm thấy trang giỏ hàng.";
                break;
        }
        break;

    default:
        echo "Router không hợp lệ";
        break;
}

// Kiểm tra & nạp file footer
$footerPath = __DIR__ . '/client/views/layout/footer.php';
if (file_exists($footerPath)) {
    include $footerPath;
} else {
    die("Lỗi: Không tìm thấy file footer.php");
}
?>