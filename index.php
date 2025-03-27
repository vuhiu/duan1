<?php
    // Kết nối database & Load cấu hình
    require __DIR__ . '/commons/connect.php';
    require __DIR__ . '/commons/env.php';
    // require_once __DIR__ . '/admin/config/router.php';

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
        case 'danhmuc':
            // Gọi router của admin nếu act là 'danhmuc'
            require_once __DIR__ . '/admin/config/router.php';
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
