<?php
require_once __DIR__ . '/../../commons/env.php';
require_once __DIR__ . '/../../commons/connect.php';
require_once __DIR__ . '/../controllers/productController.php';
require_once __DIR__ . '/../controllers/categoryController.php';
require_once __DIR__ . '/../controllers/OrderAdminController.php';
require_once __DIR__ . '/../controllers/couponController.php';
require_once __DIR__ . '/../controllers/CustomerAdminController.php';
require_once __DIR__ . '/../../client/models/ProductModel.php';
require_once __DIR__ . '/../models/product.php';
require_once __DIR__ . '/../models/category.php';
require_once __DIR__ . '/../../client/controllers/ClientProductController.php';

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

switch ($act) {
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
                $categoryController->getList();
                break;
        }
        break;

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
                break;

            default:
                $customerController->index();
                break;
        }
        break;

    default:
        $orderController->getList();
        break;
}

ob_end_flush();
