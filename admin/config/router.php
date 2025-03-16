<?php

$act = $_GET['act'] ?? '';

echo $act;

if (!empty($act)){
    switch ($act) {
        case "sanpham":

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
?>