<?php


error_reporting(E_ALL);
ini_set('display_errors', 1);

$act = $_GET['act'] ?? '';
$page = $_GET['page'] ?? '';
$id = $_GET['id'] ?? '';

switch ($act) {
    case 'sanpham':

        switch ($page) {
            case 'them':
                require 'modules/sanpham/add.php';
                break;
            
            case 'sua':
                echo "Load giao diện sửa sản phẩm";
                require empty($_POST) ? 'modules/sanpham/add.php' : 'modules/sanpham/list.php';
                break;
            
            case 'xoa':
                if (!empty($id)) {
                    echo "Load giao diện xóa sản phẩm";
                } else {
                    require 'modules/sanpham/list.php';
                }
                break;
            
            default:
                require 'modules/sanpham/list.php';
                break;
        }
        break;
    
        case 'danhmuc':
            $page = $_GET['page'] ?? '';
            $id = $_GET['id'] ?? '';
            
            switch ($page) {
                case 'them':
                    require 'modules/danhmuc/createCategory.php';
                    break;
                
                case 'sua':
                    echo "Load giao diện sửa danh mục";
                    require empty($_POST) ? 'modules/danhmuc/updateCategory.php' : 'modules/danhmuc/listCategories.php';
                    break;
                
                case 'xoa':
                    if (!empty($id)) {
                        // echo "Load giao diện xóa danh mục";
                        require 'modules/danhmuc/delete.php';

                    } else {
                        require 'modules/danhmuc/listCategories.php';
                    }
                    break;
                
                default:
                    require 'modules/danhmuc/listCategories.php';
                    break;
            }
            break;
    
    case 'baiviet':
        echo "Chức năng bài viết chưa được triển khai.";
        break;
    
    case 'donhang':
        echo "Chức năng đơn hàng chưa được triển khai.";
        break;
    
    case 'nguoidung':
        echo "Chức năng người dùng chưa được triển khai.";
        break;
    
    default:
        echo "Module không hợp lệ";
        break;
}






// include "modules/sanpham/index.php";
