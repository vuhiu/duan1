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
require_once __DIR__ . '/client/controllers/categoryController.php';
require_once __DIR__ . '/client/models/categoryModel.php';
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
use Client\Controllers\CategoryController;

// Khởi tạo các controller
$productController = new ClientProductController($conn); // Truyền kết nối $conn
$cartController = new CartController();
$categoryController = new CategoryController($conn); // Truyền kết nối $conn


switch ($act) {
    case "":
        // Gọi trang chủ
        $productController->getAllProducts();
        break;

    case 'product':
        // Gọi trang chi tiết sản phẩm
        $productController->getProductDetail();
        break;

    case 'search': // Thêm case xử lý tìm kiếm
        $productController->search();
        break;

    case 'cart':
        switch ($page) {
            case 'list':
                $user_id = $_SESSION['user_id'] ?? 0; // Lấy user_id từ session
                $cartController->getCart($user_id);
                break;

            case 'add':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $user_id = $_SESSION['user_id'];
                    $product_id = $_POST['product_id'] ?? null;
                    $variant_id = $_POST['variant_id'] ?? null;
                    $quantity = $_POST['quantity'] ?? 1;

                    if (!$product_id || !$variant_id || $quantity < 1) {
                        die("❌ Lỗi: Dữ liệu không hợp lệ.");
                    }

                    $cartController->addToCart($user_id, $product_id, $variant_id, $quantity);
                    header('Location: /duan1/index.php?act=cart&page=list'); // Chuyển hướng về trang giỏ hàng
                    exit();
                }
                break;

            case 'update_cart':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $cartController->updateCartItem();
                }
                break;

            case 'delete_cart':
                if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                    $cartController->deleteCartItem();
                }
                break;

            default:
                echo "Lỗi: Không tìm thấy trang giỏ hàng.";
                break;
        }
        break;

    case 'checkout':
        // Hiển thị trang thanh toán
        require_once __DIR__ . '/client/views/cart/checkout.php';
        break;

    // Xử lý danh mục sản phẩm
    case 'category':
        if (isset($_GET['category_id']) && is_numeric($_GET['category_id'])) {
            $category_id = $_GET['category_id'];
    
            // Khởi tạo CategoryController
            $categoryController = new \Client\Controllers\CategoryController($conn);
            $categoryController->index();
        } else {
            echo "Danh mục không hợp lệ.";
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
