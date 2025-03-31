<!-- filepath: c:\xampp\htdocs\duan1\index.php -->
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
$page = isset($_GET['page']) ? $_GET['page'] : '';

switch ($act) {
    case "":
        // Gọi trang chủ
        $homePath = __DIR__ . '/client/views/home.php';
        if (file_exists($homePath)) {
            include $homePath;
        } else {
            echo "Lỗi: Không tìm thấy file home.php";
        }
        break;

    case 'products':
        // Gọi trang sản phẩm
        $productPath = __DIR__ . '/client/views/product.php';
        if (file_exists($productPath)) {
            include $productPath;
        } else {
            echo "Lỗi: Không tìm thấy file product.php";
        }
        break;

    case 'cart':
        // Điều hướng các hành động liên quan đến giỏ hàng
        switch ($page) {
            case 'list':
                $cartPath = __DIR__ . '/client/views/cart.php';
                if (file_exists($cartPath)) {
                    include $cartPath;
                } else {
                    echo "Lỗi: Không tìm thấy file cart.php";
                }
                break;

            case 'add':
                $addToCartPath = __DIR__ . '/client/views/addToCart.php';
                if (file_exists($addToCartPath)) {
                    include $addToCartPath;
                } else {
                    echo "Lỗi: Không tìm thấy file addToCart.php";
                }
                break;

            default:
                echo "Lỗi: Không tìm thấy trang giỏ hàng.";
                break;
        }
        break;

    case 'store':
        // Gọi cửa hàng
        $storePath = __DIR__ . '/client/views/store.php';
        if (file_exists($storePath)) {
            include $storePath;
        } else {
            echo "Lỗi: Không tìm thấy file store.php";
        }
        break;

    case 'checkout':
        // Gọi trang thanh toán
        $checkoutPath = __DIR__ . '/client/views/checkout.php';
        if (file_exists($checkoutPath)) {
            include $checkoutPath;
        } else {
            echo "Lỗi: Không tìm thấy file checkout.php";
        }
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