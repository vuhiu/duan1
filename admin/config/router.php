<?php

$act = $_GET['act'] ?? '';

echo $act;

if (!empty($act)) {
    switch ($act) {
        case "sanpham":
            $page = $_GET['page'] ?? '';
            $id = $_GET['id'] ?? '';
            if (!empty($page) && $page === 'them') {
                require 'modules/sanpham/add.php';
            } else if (!empty($page) && $page === 'sua') {
                echo "load giao dien sua sp";
                if(sizeof($_POST) === 0){
                require 'modules/sanpham/add.php';
                }else{
                require 'modules/sanpham/list.php';
                }
            } else if (!empty($page) && $page === 'xoa' && !empty($id)) {
                echo "load giao dien xoa sp";
            }else{
                require 'modules/sanpham/list.php';
            }
            break;
        case "baiviet":

            break;
        case "donhang":

            break;
        case "nguoidung":

            break;
        default:

            break;
    }
} else {
}

// include "modules/sanpham/index.php";
