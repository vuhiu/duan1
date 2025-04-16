<?php
require_once __DIR__ . '/../../commons/env.php'; // Đường dẫn chính xác đến tệp env.php
// require_once __DIR__ . '/../../commons/connect.php'; // Nếu cần nạp connect.php
// require_once __DIR__ . '/../controllers/productController.php';
// require_once __DIR__ . '/../controllers/categoryController.php';
// require_once __DIR__ . '/../controllers/OrderAdminController.php';// Thêm OrderController
// require_once __DIR__ . '/../controllers/couponController.php';
// require_once __DIR__ . '/../controllers/CustomerAdminController.php'; // Thêm CustomerAdminController
// require_once __DIR__ . '/../../client/controllers/ClientProductController.php';
// require_once __DIR__ . '/../../client/models/ProductModel.php'; // Nạp file ProductModel.php
// require_once __DIR__ . '/../../client/controllers/CartController.php';
// require_once __DIR__ . '/../../client/controllers/OrderController.php';

require_once __DIR__ . '/../../commons/connect.php'; // Nạp kết nối cơ sở dữ liệu
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

use Client\Models\ClientProduct;
use Client\Controllers\ClientProductController;

// require_once __DIR__ . '/../../client/models/cart.php'

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get parameters from the URL
$act = $_GET['act'] ?? '';
$page = $_GET['page'] ?? '';
$id = $_GET['id'] ?? '';

// $productController = new ProductController();
// $categoryController = new CategoryController();
// $CartController = new CartController($conn);
// $orderController = new OrderAdminController(); // Sử dụng OrderAdminController
// $couponController = new CouponController();
// $customerController = new CustomerAdminController(); // Sử dụng CustomerAdminController
// $clientProductController = new ClientProductController();
// $productModel = new ProductModel($conn); // Khởi tạo đối tượng ProductModel với $conn
// $clientProductController = new ClientProductController($productModel); // Truyền $productModel vào ClientProductController
// Khởi tạo các đối tượng
$productModel = new ClientProduct($conn); // Truyền $conn vào ProductModel
$clientProductController = new ClientProductController($productModel); // Truyền $productModel vào ClientProductController
$productController = new ProductController();
$categoryController = new CategoryController();
$orderController = new OrderAdminController();
$couponController = new CouponController();
$customerController = new CustomerAdminController();
$dashboardController = new DashboardController($conn);

switch ($act) {
    case '':
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
                break;
            default:
                $couponController->getList();
                break;
        }
        break;

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
