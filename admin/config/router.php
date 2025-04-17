<?php
require_once __DIR__ . '/../../commons/env.php';
require_once __DIR__ . '/../../commons/connect.php';
require_once __DIR__ . '/../controllers/productController.php';
require_once __DIR__ . '/../controllers/categoryController.php';
require_once __DIR__ . '/../controllers/OrderAdminController.php';
require_once __DIR__ . '/../controllers/couponController.php';
require_once __DIR__ . '/../controllers/CustomerAdminController.php';
require_once __DIR__ . '/../controllers/DashboardController.php';
require_once __DIR__ . '/../models/product.php';
require_once __DIR__ . '/../models/category.php';

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

// Initialize controllers
$productController = new ProductController();
$categoryController = new CategoryController();
$orderController = new OrderAdminController();
$couponController = new CouponController();
$customerController = new CustomerAdminController();
$dashboardController = new DashboardController($conn);

switch ($act) {
    case 'dashboard':
        $dashboardController->index();
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

    case 'order':
        switch ($page) {
            case 'list':
                $orderController->getList();
                break;
            case 'detail':
                if (isset($_GET['id'])) {
                    $orderController->getOrderDetail($_GET['id']);
                } else {
                    header('Location: index.php?act=order&page=list');
                    exit();
                }
                break;
            case 'update_status':
                if (isset($_GET['id']) && isset($_GET['status'])) {
                    $orderController->updateOrderStatus($_GET['id'], $_GET['status']);
                } else {
                    header('Location: index.php?act=order&page=list');
                    exit();
                }
                break;
            case 'cancel':
                if (isset($_GET['id'])) {
                    $orderController->updateOrderStatus($_GET['id'], 'cancelled');
                } else {
                    header('Location: index.php?act=order&page=list');
                    exit();
                }
                break;
            case 'confirm':
                if (isset($_GET['id'])) {
                    $orderController->updateOrderStatus($_GET['id'], 'delivered');
                } else {
                    header('Location: index.php?act=order&page=list');
                    exit();
                }
                break;
            default:
                $orderController->getList();
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
            case 'delete':
                $couponController->deleteCoupon();
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
                if (isset($_GET['id'])) {
                    $customerController->detail($_GET['id']);
                } else {
                    header('Location: index.php?act=customer&page=list');
                    exit();
                }
                break;
            case 'edit':
                if (isset($_GET['id'])) {
                    $customerController->edit($_GET['id']);
                } else {
                    header('Location: index.php?act=customer&page=list');
                    exit();
                }
                break;
            case 'update':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $customerController->update($_POST);
                } else {
                    header('Location: index.php?act=customer&page=list');
                    exit();
                }
                break;
            default:
                $customerController->index();
                break;
        }
        break;

    default:
        $dashboardController->index();
        break;
}

ob_end_flush();
