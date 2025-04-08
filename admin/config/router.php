<?php
require_once __DIR__ . '/../../commons/env.php'; // Load environment variables
require_once __DIR__ . '/../../commons/connect.php'; // Database connection
require_once __DIR__ . '/../controllers/productController.php';
require_once __DIR__ . '/../controllers/categoryController.php';
require_once __DIR__ . '/../controllers/cartController.php';
require_once __DIR__ . '/../controllers/OrderAdminController.php';
require_once __DIR__ . '/../controllers/couponController.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get parameters from the URL
$act = $_GET['act'] ?? '';
$page = $_GET['page'] ?? '';
$id = $_GET['id'] ?? '';

// Initialize controllers
$productController = new ProductController();
$categoryController = new CategoryController();
$cartController = new CartController();
$orderController = new OrderAdminController();
$couponController = new CouponController();

switch ($act) {
    case 'sanpham': // Product management
        switch ($page) {
            case 'list':
                $productController->getList();
                break;

            case 'them':
                $productController->addProduct();
                break;

            case 'sua':
                $productController->editProduct();
                break;

            case 'update':
                $productController->updateProduct();
                break;

            case 'xoa':
                $productController->deleteProduct();
                break;

            default:
                echo "Không tìm thấy trang!";
                break;
        }
        break;

    case 'danhmuc': // Category management
        switch ($page) {
            case 'list':
                $categoryController->getList();
                break;

            case 'add':
                $categoryController->addCategory();
                break;

            case 'edit':
                $categoryController->editCategory();
                break;

            case 'update':
                $categoryController->updateCategory();
                break;

            case 'delete':
                $categoryController->deleteCategory();
                break;

            default:
                echo "Không tìm thấy trang!";
                break;
        }
        break;

    case 'cart': // Cart management
        switch ($page) {
            case 'list':
                $user_id = $_SESSION['user_id'] ?? 0; // Get user_id from session
                $cartController->getCart($user_id);
                break;

            case 'add':
                $cartController->addToCart();
                break;

            case 'update':
                $cartController->updateCart();
                break;

            case 'delete':
                $cartController->deleteFromCart();
                break;

            default:
                echo "Không tìm thấy trang!";
                break;
        }
        break;

    case 'order': // Order management
        switch ($page) {
            case 'list': // Display order list
                $orderController->getList();
                break;

            case 'edit': // Edit order
                $orderController->editOrder();
                break;

            case 'update': // Update order status
                $orderController->updateOrder();
                break;

            case 'history': // Order history
                $userId = $_SESSION['user_id'] ?? 0; // Get user_id from session
                $orderController->getHistory($userId);
                break;

            case 'status': // Order status
                $orderId = $_GET['order_id'] ?? 0;
                $orderController->getOrderStatus($orderId);
                break;

            default:
                echo "Không tìm thấy trang!";
                break;
        }
        break;

    case 'coupon': // Coupon management
        switch ($page) {
            case 'list': // Display coupon list
                $couponController->getList();
                break;

            case 'add': // Add a new coupon
                $couponController->addCoupon();
                break;

            case 'edit': // Edit a coupon
                $couponController->editCoupon();
                break;

            case 'update': // Update a coupon
                $couponController->updateCoupon();
                break;

            case 'delete': // Delete a coupon
                $couponController->deleteCoupon();
                break;

            default:
                echo "Không tìm thấy trang!";
                break;
        }
        break;

    default:
        echo "Module không hợp lệ!";
        break;
}
?>