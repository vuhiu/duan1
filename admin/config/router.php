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
require_once __DIR__ . '/../../client/controllers/ClientProductController.php';
require_once __DIR__ . '/../../client/models/ProductModel.php';
require_once __DIR__ . '/../models/product.php';
require_once __DIR__ . '/../models/category.php';
require_once __DIR__ . '/../../client/models/cart.php';

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
$productModel = new ProductModel($conn); // Truyền $conn vào ProductModel
$clientProductController = new ClientProductController($productModel); // Truyền $productModel vào ClientProductController
$productController = new ProductController();
$categoryController = new CategoryController();
$orderController = new OrderAdminController();
$couponController = new CouponController();
$customerController = new CustomerAdminController();

switch ($act) {
    case 'product_detail': // Xem chi tiết sản phẩm
        $productController->productDetail();
        break;
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
            case 'add_cart': // Thêm sản phẩm vào giỏ hàng
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $cartController->addToCart();
                } else {
                    echo "❌ Phương thức không hợp lệ!";
                }
                break;
            case 'update_cart': // Cập nhật số lượng sản phẩm
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $cartController->updateCartItem();
                } else {
                    echo "❌ Phương thức không hợp lệ!";
                }
                break;
            case 'delete_cart': // Xóa sản phẩm khỏi giỏ hàng
                if (isset($_GET['cart_item_id'])) {
                    $cartController->deleteCartItem();
                } else {
                    echo "❌ Không tìm thấy sản phẩm để xóa!";
                }
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
        case 'customer': // Quản lý khách hàng
            switch ($page) {
                case 'list': // Hiển thị danh sách khách hàng
                    $customerController->index();
                    break;
    
                case 'detail': // Hiển thị chi tiết khách hàng
                    $user_id = $_GET['user_id'] ?? 0;
                    $customerController->detail($user_id);
                    break;
    
                case 'edit': // Hiển thị form sửa thông tin khách hàng
                    $user_id = $_GET['user_id'] ?? 0;
                    $customerController->edit($user_id);
                    break;
    
                case 'update': // Cập nhật thông tin khách hàng
                    $user_id = $_GET['user_id'] ?? 0;
                    $customerController->update($user_id);
                    break;
    
                default:
                    echo "Không tìm thấy trang!";
                    break;
            }
            break;
}
?>