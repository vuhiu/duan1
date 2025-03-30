<?php
require_once __DIR__ . '/../models/cart.php';

class CartController {
    public $cartModel;

    public function __construct() {
        $this->cartModel = new Cart();
    }

    // Hiển thị giỏ hàng
    public function getCart($user_id) {
        $cartItems = $this->cartModel->getAllCartItems($user_id);
        require_once __DIR__ . '/../views/cart/listCart.php';
    }

    // Thêm sản phẩm vào giỏ hàng
    public function addToCart() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Kiểm tra xem người dùng đã đăng nhập chưa
            if (!isset($_SESSION['user_id'])) {
                echo "Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng!";
                exit;
            }
    
            $user_id = $_SESSION['user_id'];
            $product_id = $_POST['product_id'];
            $variant_id = $_POST['variant_id'];
            $quantity = $_POST['quantity'];
    
            $this->cartModel->addItem($user_id, $product_id, $variant_id, $quantity);
    
            header('Location: /duan1/admin/index.php?act=cart&page=list');
            exit();
        } else {
            require_once __DIR__ . '/../views/cart/addToCart.php';
        }
    }

    // Cập nhật số lượng sản phẩm trong giỏ hàng
    public function updateCart() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cart_item_id = $_POST['cart_item_id'];
            $quantity = $_POST['quantity'];

            $this->cartModel->updateItem($cart_item_id, $quantity);

            header('Location: /duan1/admin/index.php?act=cart&page=list');
            exit();
        }
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function deleteFromCart() {
        if (isset($_GET['cart_item_id'])) {
            $cart_item_id = $_GET['cart_item_id'];

            $this->cartModel->deleteItem($cart_item_id);

            header('Location: /duan1/admin/index.php?act=cart&page=list');
            exit();
        }
    }
}
?>