<?php
    // Kết nối database & Load cấu hình
    require __DIR__ . '/commons/connect.php';
    require __DIR__ . '/commons/env.php';

    // Kiểm tra & nạp file header
    $headerPath = __DIR__ . '/client/views/layout/header.php';
    if (file_exists($headerPath)) {
        include $headerPath;
    } else {
        die("Lỗi: Không tìm thấy file header.php");
    }

    // Xử lý router
    $act = isset($_GET['act']) ? $_GET['act'] : '';

    switch ($act) {
        case '':
            echo "Home";
            break;
        case 'products':
            echo "Products";
            break;
        case '123':
            echo "12345";
            break;
        case '333':
            echo "12345";
            break;
        default:
            echo "Router không hợp lệ";
            break;
    }

    // Kiểm tra & nạp file footer
    $footerPath = __DIR__ . '/client/views/layout/footer.php';
    if (file_exists($footerPath)) {
        include $footerPath;
    } else {
        die("Lỗi: Không tìm thấy file footer.php");
    }
?>
