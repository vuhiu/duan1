<?php

// $act = $_GET['act'] ?? '';

// echo $act;

// if (!empty($act)) {
//     switch ($act) {
//         case "sanpham":
//             $page = $_GET['page'] ?? '';
//             $id = $_GET['id'] ?? '';
//             if (!empty($page) && $page === 'them') {
//                 require 'modules/sanpham/add.php';
//             } else if (!empty($page) && $page === 'sua') {
//                 echo "load giao dien sua sp";
//                 if(sizeof($_POST) === 0){
//                 require 'modules/sanpham/add.php';
//                 }else{
//                 require 'modules/sanpham/list.php';
//                 }
//             } else if (!empty($page) && $page === 'xoa' && !empty($id)) {
//                 echo "load giao dien xoa sp";
//             }else{
//                 require 'modules/sanpham/list.php';
//             }
//             break;
//         case "baiviet":

//             break;
//         case "donhang":

//             break;
//         case "danhmuc":
//             $page = $_GET['page'] ?? '';
//             $id = $_GET['id'] ?? '';
//             if (!empty($page) && $page === 'addcate') {
//                 require 'modules/danhmuc/createcate.php';
//             } else if (!empty($page) && $page === 'updateCategory') {
//                 echo "load giao dien sua sp";
//                 if(sizeof($_POST) === 0){
//                 require 'modules/danhmuc/add.php';
//                 }else{
//                 require 'modules/danhmuc/list.php';
//                 }
//             } else if (!empty($page) && $page === 'xoa' && !empty($id)) {
//                 echo "load giao dien xoa sp";
//             }else{
//                 require 'modules/danhmuc/list.php';
//             }
//             break;
//         case "nguoidung":

//             break;
//         default:

//             break;
//     }
// } else {
// }
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
                        echo "Load giao diện xóa danh mục";
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
