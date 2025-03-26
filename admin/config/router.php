<?php
require_once __DIR__ . '/../commons/env.php';
require_once __DIR__ . '/../commons/connect.php';
require_once __DIR__ . '/../controllers/productController.php';
require_once __DIR__ . '/../models/product.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$act = $_GET['act'] ?? '';
$page = $_GET['page'] ?? '';
$id = $_GET['id'] ?? '';

$productController = new ProductController();

switch ($act) {
    case 'sanpham':
        switch ($page) {
            case 'list':
                $productController->getList();
                break;

            case 'them':
                $productController->addProduct();
                break;

            case 'sua': // Cập nhật route để hiển thị trang chỉnh sửa
               
                    $productController->edit();
                
                break;

            case 'update': // Cập nhật route để xử lý cập nhật sản phẩm
               
                    $productController->update();
                
                break;

            case 'xoa':
               
                    $productController->delete();
                
                break;

            default:
                echo "Không tìm thấy trang!";
                break;
        }
        break;

    case 'danhmuc':
        switch ($page) {
            case 'list':
                require_once __DIR__ . '/../views/category/listCategory.php';
                break;

            case 'them':
                require_once __DIR__ . '/../views/category/addCategory.php';
                break;

            case 'sua':
                if (!empty($id)) {
                    require_once empty($_POST) ? __DIR__ . '/../views/category/editCategory.php' : __DIR__ . '/../views/category/listCategory.php';
                } else {
                    echo "Thiếu ID danh mục cần sửa!";
                }
                break;

            case 'xoa':
                if (!empty($id)) {
                    require_once __DIR__ . '/../views/category/deleteCategory.php';
                } else {
                    echo "Thiếu ID danh mục cần xóa!";
                }
                break;

            default:
                require_once __DIR__ . '/../views/category/listCategory.php';
                break;
        }
        break;

    default:
        echo "Module không hợp lệ!";
        break;
}
?>
