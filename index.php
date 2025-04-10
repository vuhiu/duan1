<?php
ob_start(); // Bật bộ đệm đầu ra
session_start(); // Khởi tạo session

// Kiểm tra session trước khi xử lý router
if (!isset($_SESSION['user_id'])) {
    header('Location: /duan1/client/views/auth/form-login.php');
    exit();
}


// Kết nối database & Load cấu hình
require __DIR__ . '/commons/connect.php';
require __DIR__ . '/commons/env.php';
require_once __DIR__ . '/client/controllers/ClientProductController.php';
require_once __DIR__ . '/client/controllers/cartController.php';
require_once __DIR__ . '/client/controllers/authenController.php';

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
use Client\Controllers\CartController;
use Client\Controllers\AuthenController;

$controller = new ClientProductController($conn); // Truyền kết nối $conn
$cartController = new CartController();

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
                $user_id = $_SESSION['user_id'] ?? 0; // Lấy user_id từ session
                $cartController->getCart($user_id);
                break;

            case 'add':
                $addToCartPath = __DIR__ . '/client/views/cart/addTocart.php';
                if (file_exists($addToCartPath)) {
                    include $addToCartPath;
                } else {
                    echo "Lỗi: Không tìm thấy file addTocart.php";
                }
                break;

            default:
                echo "Lỗi: Không tìm thấy trang giỏ hàng.";
                break;
        }
        break;

    case 'auth': // Xử lý đăng nhập, đăng ký, đăng xuất
        $authController = new AuthenController();
        $action = $_GET['action'] ?? '';
        switch ($action) {
            case 'login':
                $email = $_POST['email'] ?? '';
                $password = $_POST['password'] ?? '';
                $authController->login($email, $password);
                break;

            case 'register':
                $name = $_POST['name'] ?? '';
                $email = $_POST['email'] ?? '';
                $password = $_POST['password'] ?? '';
                $authController->register($name, $email, $password);
                break;

            case 'logout':
                $authController->logout();
                break;

            default:
                header('Location: /duan1/client/views/auth/form-login.php');
                exit();
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