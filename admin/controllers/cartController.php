<?php
ob_start();
require_once __DIR__ . '/../models/cart.php';

class CartController {
    public $cartModel;

    public function __construct() {
        $this->cartModel = new Cart();
    }

    public function getCart($user_id) {
        $cartItems = $this->cartModel->getAllCartItems($user_id);
        require_once __DIR__ . '/../views/cart/listCart.php';
    }

    public function addToCart() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_POST['user_id'];
            $product_id = $_POST['product_id'];
            $quantity = $_POST['quantity'];

            $this->cartModel->addItem($user_id, $product_id, $quantity);

            header('Location: ?act=cart&page=list');
            exit();
        }
    }

    public function updateCart() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cart_id = $_POST['cart_id'];
            $quantity = $_POST['quantity'];

            $this->cartModel->updateItem($cart_id, $quantity);

            header('Location: ?act=cart&page=list');
            exit();
        }
    }

    public function deleteFromCart() {
        if (isset($_GET['cart_id'])) {
            $cart_id = $_GET['cart_id'];

            $this->cartModel->deleteItem($cart_id);

            header('Location: ?act=cart&page=list');
            exit();
        }
    }
}
ob_end_flush();
?>