<!-- filepath: c:\xampp\htdocs\duan1\index.php -->
<?php
// Kết nối database & Load cấu hình
require __DIR__ . '/commons/connect.php';
require __DIR__ . '/commons/env.php';
require_once __DIR__ . '/client/controllers/ClientProductController.php';

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

use Client\Controllers\ClientProductController;
$controller = new ClientProductController($conn); // Truyền kết nối $conn

switch ($act) {
    case "":
        // Gọi trang chủ
        $controller->getAllProducts();
        break;

    case 'product':
        // Gọi trang chi tiết sản phẩm
        $controller->getProductDetail();
        break;

    case 'search': // Thêm case xử lý tìm kiếm
        $controller->search();
        break;

    case 'cart':
        // Điều hướng các hành động liên quan đến giỏ hàng
        switch ($page) {
            case 'list':
                $cartPath = __DIR__ . '/client/views/cart.php';
                if (file_exists($cartPath)) {
                    include $cartPath;
                } else {
                    echo "Lỗi: Không tìm thấy file cart.php";
                }
                break;

            case 'add':
                $addToCartPath = __DIR__ . '/client/views/addToCart.php';
                if (file_exists($addToCartPath)) {
                    include $addToCartPath;
                } else {
                    echo "Lỗi: Không tìm thấy file addToCart.php";
                }
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