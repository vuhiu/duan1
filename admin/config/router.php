<?php

$act = $_GET['act'] ?? '';

echo $act;

if (!empty($act)) {
    switch ($act) {
        case "sanpham":
            $page = $_GET['page'] ?? '';
            $id = $_GET['id'] ?? '';
            if (!empty($page) && $page === 'them') {
                require 'modules/sanpham/form.php';
            } else if (!empty($page) && $page === 'sua') {
                echo "load giao dien sua sp";
                if(sizeof($_POST) === 0){
                require 'modules/sanpham/form.php';
                }else{
                    // sua du lieu
                    // load database cai danh sach
                }
            } else if (!empty($page) && $page === 'xoa' && !empty($id)) {
                echo "load giao dien xoa sp";
            }else{
                echo "load danh sach ra";
            }
            break;
        case "baiviet":

            break;
        case "donhang":

            break;
        case "categories":
            echo"danh mục sản phẩm"
            break;
        case "nguoidung":

            break;
        default:

            break;
    }
} else {
}

// include "modules/sanpham/index.php";
