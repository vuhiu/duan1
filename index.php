<?php
ob_start(); // Bật bộ đệm đầu ra
session_start(); // Khởi tạo session

// Kết nối database & Load cấu hình
require __DIR__ . '/commons/env.php';

try {
    $host = "localhost";
    $dbname = "du_an_1";
    $username = "root";
    $password = "";

    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Load controllers
require_once __DIR__ . '/client/controllers/ClientProductController.php';
require_once __DIR__ . '/client/controllers/cartController.php';
require_once __DIR__ . '/client/controllers/authenController.php';
require_once __DIR__ . '/client/controllers/categoryController.php';
require_once __DIR__ . '/client/controllers/FavoriteController.php';

// Load models
require_once __DIR__ . '/client/models/categoryModel.php';
require_once __DIR__ . '/client/models/cartModel.php';
require_once __DIR__ . '/client/models/couponModel.php';
require_once __DIR__ . '/client/models/UserClient.php';
require_once __DIR__ . '/client/models/ShippingModel.php';
require_once __DIR__ . '/client/models/ProductModel.php';

use Client\Controllers\ClientProductController;
use Client\Models\ClientProduct;

// Kiểm tra & nạp file header
$headerPath = __DIR__ . '/client/views/layout/header.php';
if (file_exists($headerPath)) {
    include $headerPath;
} else {
    die("Lỗi: Không tìm thấy file header.php");
}

// Xử lý router
$act = $_GET['act'] ?? '';
$page = $_GET['page'] ?? '';

// Khởi tạo các controller
$productModel = new ClientProduct($conn);
$productController = new ClientProductController($productModel);
$cartController = new CartController();
$categoryController = new CategoryController($conn);
$favoriteController = new FavoriteController();

switch ($act) {
    case "":
        // Gọi trang chủ
        $productController->getAllProducts();
        break;

    case 'product':
        // Gọi trang chi tiết sản phẩm
        $productController->getProductDetail();
        break;

    case 'search':
        $productController->search();
        break;

    case 'cart':
        switch ($page) {
            case 'list':
                if (!isset($_SESSION['user_id'])) {
                    header('Location: /duan1/client/views/auth/form-login.php');
                    exit();
                }
                $user_id = $_SESSION['user_id'];
                $cartController->getCart($user_id);
                break;

            case 'add':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    if (!isset($_SESSION['user_id'])) {
                        header('Location: /duan1/client/views/auth/form-login.php');
                        exit();
                    }
                    $user_id = $_SESSION['user_id'];
                    $product_id = $_POST['product_id'] ?? null;
                    $variant_id = $_POST['variant_id'] ?? null;
                    $quantity = $_POST['quantity'] ?? 1;

                    if (!$product_id || !$variant_id || $quantity < 1) {
                        echo json_encode([
                            'status' => 'error',
                            'message' => 'Dữ liệu không hợp lệ'
                        ]);
                        exit();
                    }

                    $cartController->addToCart($user_id, $product_id, $variant_id, $quantity);
                    header('Location: /duan1/index.php?act=cart&page=list');
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

            case 'checkout':
                if (!isset($_SESSION['user_id'])) {
                    header('Location: /duan1/index.php?act=login');
                    exit();
                }

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    if (isset($_POST['update_shipping'])) {
                        $_SESSION['selected_shipping'] = $_POST['shipping_method'] ?? null;
                        header('Location: /duan1/index.php?act=cart&page=checkout');
                        exit();
                    } elseif (isset($_POST['apply_coupon'])) {
                        $cartController->validateCoupon();
                        header('Location: /duan1/index.php?act=cart&page=checkout');
                        exit();
                    } elseif (isset($_POST['process_checkout'])) {
                        $order_id = $cartController->processCheckout();
                        if ($order_id) {
                            $_SESSION['last_order'] = $order_id;
                            header('Location: /duan1/index.php?act=cart&page=process_checkout');
                            exit();
                        } else {
                            $_SESSION['error'] = "Có lỗi xảy ra trong quá trình thanh toán!";
                            header('Location: /duan1/index.php?act=cart&page=checkout');
                            exit();
                        }
                    }
                }

                $user_id = $_SESSION['user_id'];
                $cartController->checkout();
                break;

            case 'process_checkout':
                if (!isset($_SESSION['last_order'])) {
                    header('Location: /duan1/index.php');
                    exit();
                }
                include 'client/views/order/success.php';
                break;

            default:
                echo "Lỗi: Không tìm thấy trang giỏ hàng.";
                break;
        }
        break;

    case 'category':
        if (isset($_GET['category_id']) && is_numeric($_GET['category_id'])) {
            $category_id = $_GET['category_id'];
            $categoryController->index();
        } else {
            echo "Danh mục không hợp lệ.";
        }
        break;

    case 'auth':
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

    case 'order':
        require_once __DIR__ . '/client/models/orderModel.php';
        $orderModel = new OrderModel();
        $user_id = $_SESSION['user_id'];

        switch ($page) {
            case 'success':
                if (!isset($_SESSION['last_order'])) {
                    header('Location: /duan1/index.php');
                    exit();
                }
                include 'client/views/order/success.php';
                break;

            case 'list':
                $orders = $orderModel->getOrdersByUserId($user_id);
                include 'client/views/order/list.php';
                break;

            case 'detail':
                $order_id = $_GET['id'] ?? 0;
                $order = $orderModel->getOrderById($order_id, $user_id);
                if (!$order) {
                    $_SESSION['error'] = "Không tìm thấy đơn hàng!";
                    header('Location: /duan1/index.php?act=order&page=list');
                    exit();
                }
                $orderItems = $orderModel->getOrderItems($order_id);
                include 'client/views/order/detail.php';
                break;

            case 'cancel':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $order_id = $_POST['order_id'] ?? 0;
                    if ($orderModel->cancelOrder($order_id, $user_id)) {
                        $_SESSION['success'] = "Hủy đơn hàng thành công!";
                    } else {
                        $_SESSION['error'] = "Không thể hủy đơn hàng này!";
                    }
                    header('Location: /duan1/index.php?act=order&page=list');
                    exit();
                }
                break;

            default:
                header('Location: /duan1/index.php?act=order&page=list');
                exit();
        }
        break;

    case 'favorite':
        if (isset($_GET['action'])) {
            switch ($_GET['action']) {
                case 'add':
                    header('Content-Type: application/json');
                    $favoriteController->addToFavorite();
                    break;
                case 'remove':
                    header('Content-Type: application/json');
                    $favoriteController->removeFromFavorite();
                    break;
                case 'list':
                    $favoriteController->showFavorites();
                    break;
                default:
                    $favoriteController->showFavorites();
                    break;
            }
        } else {
            $favoriteController->showFavorites();
        }
        break;

    case 'buy-now':
        $favoriteController->buyNow();
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
