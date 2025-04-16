<?php
require_once __DIR__ . '/../../commons/env.php';
require_once __DIR__ . '/../../commons/connect.php';
require_once __DIR__ . '/../controllers/productController.php';
require_once __DIR__ . '/../controllers/categoryController.php';
require_once __DIR__ . '/../controllers/OrderAdminController.php';
require_once __DIR__ . '/../controllers/couponController.php';
require_once __DIR__ . '/../controllers/CustomerAdminController.php';
require_once __DIR__ . '/../controllers/DashboardController.php';
require_once __DIR__ . '/../../client/models/ProductModel.php';
require_once __DIR__ . '/../models/product.php';
require_once __DIR__ . '/../models/category.php';
require_once __DIR__ . '/../../client/controllers/ClientProductController.php';

<<<<<<< HEAD
use Client\Models\ClientProduct;
use Client\Controllers\ClientProductController;

// require_once __DIR__ . '/../../client/models/cart.php'

=======
>>>>>>> 426fad3974964d4c2adffc4060d861697f252430
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
ob_start();

// Kiểm tra đăng nhập
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

// Get parameters from the URL
$act = $_GET['act'] ?? '';
$page = $_GET['page'] ?? '';
$id = $_GET['id'] ?? '';

// Debug URL parameters
error_log("URL Parameters - act: $act, page: $page, id: $id");

// Initialize objects
$productModel = new ClientProduct($conn);
$clientProductController = new ClientProductController($conn);
$productController = new ProductController();
$categoryController = new CategoryController();
$orderController = new OrderAdminController();
$couponController = new CouponController();
$customerController = new CustomerAdminController();
$dashboardController = new DashboardController($conn);

switch ($act) {
<<<<<<< HEAD
    case '':
    case 'dashboard':
        $dashboardController->index();
=======
    case 'dashboard':
        include __DIR__ . '/../views/dashboard.php';
        break;

    case 'order':
        switch ($page) {
            case 'list':
                $orderController->getList();
                break;

            case 'detail':
                if (isset($_GET['id'])) {
                    $orderController->getOrderDetail($_GET['id']);
                }
                break;

            case 'update_status':
                if (isset($_GET['id']) && isset($_GET['status'])) {
                    $orderController->updateOrderStatus($_GET['id'], $_GET['status']);
                }
                break;

            case 'edit':
                if (isset($_GET['id'])) {
                    include __DIR__ . '/../views/order/edit.php';
                }
                break;

            default:
                $orderController->getList();
                break;
        }
>>>>>>> 426fad3974964d4c2adffc4060d861697f252430
        break;

    case 'sanpham':
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
                $productController->getList();
                break;
        }
        break;

    case 'danhmuc':
        switch ($page) {
            case 'list':
                $categoryController->getList();
                break;
            case 'them':
                $categoryController->addCategory();
                break;
            case 'sua':
                $categoryController->editCategory();
                break;
            case 'update':
                $categoryController->updateCategory();
                break;
            case 'xoa':
                $categoryController->deleteCategory();
                break;
            default:
                $categoryController->getList();
                break;
        }
        break;

<<<<<<< HEAD
    case 'donhang':
        switch ($page) {
            case 'list':
                $orderController->getList();
                break;
            case 'detail':
                $orderController->getDetail();
                break;
            case 'update':
                $orderController->updateStatus();
                break;
            default:
                $orderController->getList();
                break;
        }
        break;

    case 'magiamgia':
        switch ($page) {
            case 'list':
                $couponController->getList();
                break;
            case 'them':
                $couponController->addCoupon();
                break;
            case 'sua':
                $couponController->editCoupon();
                break;
            case 'update':
                $couponController->updateCoupon();
                break;
            case 'xoa':
                $couponController->deleteCoupon();
=======
    case 'coupon':
        switch ($page) {
            case 'list':
                $couponController->getList();
                break;

            case 'add':
                $couponController->addCoupon();
                break;

            case 'edit':
                $couponController->editCoupon();
                break;

            case 'update':
                $couponController->updateCoupon();
                break;

            default:
                $couponController->getList();
                break;
        }
        break;

    case 'customer':
        switch ($page) {
            case 'list':
                $customerController->index();
                break;

            case 'detail':
                if (isset($_GET['user_id'])) {
                    $customerController->detail($_GET['user_id']);
                }
                break;

            case 'edit':
                if (isset($_GET['user_id'])) {
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $customerController->update($_GET['user_id']);
                    } else {
                        $customerController->edit($_GET['user_id']);
                    }
                }
>>>>>>> 426fad3974964d4c2adffc4060d861697f252430
                break;
            default:
<<<<<<< HEAD
                $couponController->getList();
=======
                $customerController->index();
>>>>>>> 426fad3974964d4c2adffc4060d861697f252430
                break;
        }
        break;

<<<<<<< HEAD
    case 'khachhang':
        switch ($page) {
            case 'list':
                $customerController->index();
                break;
            case 'detail':
                $customerController->detail();
                break;
            default:
                $customerController->index();
                break;
        }
=======
    default:
        $orderController->getList();
>>>>>>> 426fad3974964d4c2adffc4060d861697f252430
        break;
    
        case 'orders':
            require_once __DIR__ . '/../controllers/orderController.php';
            $orderController = new OrderController();
            if (isset($_GET['id'])) {
                $orderController->detail();
            } else {
                $orderController->index();
            }
            break;
        case 'orders/cancel':
            require_once __DIR__ . '/../controllers/orderController.php';
            $orderController = new OrderController();
            $orderController->cancel();
            break;

    default:
        $dashboardController->index();
        break;
}

ob_end_flush();
