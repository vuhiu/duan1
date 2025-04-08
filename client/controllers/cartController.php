<?php
require_once __DIR__ . '/../models/CartModel.php';

class CartController {
    public $cartModel;

    public function __construct() {
        $this->cartModel = new Cart();
    }

    public function getCart($user_id) {
        // Retrieve all cart items for the user
        $cartItems = $this->cartModel->getAllCartItems($user_id);

        // Pass the cart items to the cart view
        require_once __DIR__ . '/../views/cart.php';
    }

    public function addToCart() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_POST['user_id'];
            $product_id = $_POST['product_id'];
            $variant_id = $_POST['variant_id'];
            $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : null;

            // Validate required fields
            if (empty($variant_id)) {
                die("❌ Lỗi: Biến thể sản phẩm không hợp lệ.");
            }
            if (empty($quantity) || $quantity <= 0) {
                die("❌ Lỗi: Số lượng sản phẩm không hợp lệ.");
            }

            $this->cartModel->addItem($user_id, $product_id, $variant_id, $quantity);

            // Redirect to the cart page
            header('Location: /duan1/index.php?act=cart&page=list');
            exit();
        }
    }

    public function deleteFromCart() {
        if (isset($_GET['cart_item_id'])) {
            $cart_item_id = $_GET['cart_item_id'];

            $this->cartModel->deleteItem($cart_item_id);

            // Redirect to the cart page
            header('Location: /duan1/index.php?act=cart&page=list');
            exit();
        }
    }
}
?>