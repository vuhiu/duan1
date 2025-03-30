<?php
require_once __DIR__ . '/../../commons/env.php'; // Đường dẫn chính xác đến tệp env.php
require_once __DIR__ . '/../../commons/connect.php'; // Nếu cần nạp connect.php
require_once __DIR__ . '/../controllers/productController.php';
require_once __DIR__ . '/../controllers/categoryController.php';
require_once __DIR__ . '/../controllers/cartController.php';
require_once __DIR__ . '/../controllers/OrderAdminController.php'; // Thêm OrderController
// require_once __DIR__ . '/../../client/controllers/OrderController.php';
require_once __DIR__ . '/../models/product.php';
require_once __DIR__ . '/../models/category.php';
require_once __DIR__ . '/../models/cart.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$act = $_GET['act'] ?? '';
$page = $_GET['page'] ?? '';
$id = $_GET['id'] ?? '';

$productController = new ProductController();
$categoryController = new CategoryController();
$cartController = new CartController();
$orderController = new OrderAdminController(); // Sử dụng OrderAdminController

switch ($act) {
    case 'sanpham': // Quản lý sản phẩm
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
                $productController->delete();
                break;

            default:
                echo "Không tìm thấy trang!";
                break;
        }
        break;

    case 'danhmuc': // Quản lý danh mục
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

    case 'cart': // Quản lý giỏ hàng
        switch ($page) {
            case 'list':
                $user_id = $_SESSION['user_id'] ?? 0; // Lấy user_id từ session
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

    case 'order': // Quản lý đơn hàng
        switch ($page) {
            case 'list': // Hiển thị danh sách đơn hàng
                $orderController->getList();
                break;

            case 'edit': // Hiển thị form chỉnh sửa đơn hàng
                $orderController->editOrder();
                break;

            case 'update': // Cập nhật trạng thái đơn hàng và thanh toán
                $orderController->updateOrder();
                break;
            case 'history': // Lịch sử đơn hàng
                $userId = $_SESSION['user_id'] ?? 0; // Lấy user_id từ session
                $orderController->getHistory($userId);
                break;
    
            case 'status': // Trạng thái đơn hàng
                $orderId = $_GET['order_id'] ?? 0;
                $orderController->getOrderStatus($orderId);
                break;

            default:
                echo "Không tìm thấy trang!";
                break;
        }
        break;

    default:
        echo "Module không hợp lệ";
        break;
}
?>