<?php

require_once __DIR__ . '/../models/FavoriteModel.php';

class FavoriteController {
    private $favoriteModel;

    public function __construct() {
        $this->favoriteModel = new Favorite();
    }

    // Xử lý thêm sản phẩm vào yêu thích
    public function addToFavorite() {
        header('Content-Type: application/json');
        
        if (!isset($_SESSION['user_id'])) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Vui lòng đăng nhập để thêm sản phẩm vào yêu thích'
            ]);
            return;
        }

        $user_id = $_SESSION['user_id'];
        $product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : null;

        if (!$product_id) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Thiếu thông tin sản phẩm'
            ]);
            return;
        }

        // Kiểm tra xem sản phẩm đã có trong danh sách yêu thích chưa
        if ($this->favoriteModel->isFavorite($user_id, $product_id)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Sản phẩm đã có trong danh sách yêu thích'
            ]);
            return;
        }

        $result = $this->favoriteModel->addToFavorite($user_id, $product_id);
        if ($result) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Đã thêm vào danh sách yêu thích'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Không thể thêm sản phẩm vào yêu thích'
            ]);
        }
    }

    // Xử lý xóa sản phẩm khỏi yêu thích
    public function removeFromFavorite() {
        header('Content-Type: application/json');
        
        if (!isset($_SESSION['user_id'])) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Vui lòng đăng nhập'
            ]);
            return;
        }

        $user_id = $_SESSION['user_id'];
        $product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : null;

        if (!$product_id) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Thiếu thông tin sản phẩm'
            ]);
            return;
        }

        $result = $this->favoriteModel->removeFromFavorite($user_id, $product_id);
        if ($result) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Đã xóa khỏi danh sách yêu thích'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Không thể xóa sản phẩm'
            ]);
        }
    }

    // Hiển thị danh sách yêu thích
    public function showFavorites() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /duan1/client/views/auth/form-login.php');
            exit();
        }

        $user_id = $_SESSION['user_id'];
        $favorites = $this->favoriteModel->getFavorites($user_id);
        
        // Load view hiển thị danh sách yêu thích
        require_once __DIR__ . '/../views/favorite/list.php';
    }

    // Xử lý mua ngay
    public function buyNow() {
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['status' => 'error', 'message' => 'Vui lòng đăng nhập để mua hàng']);
            return;
        }

        $user_id = $_SESSION['user_id'];
        $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : null;
        $variant_id = isset($_POST['variant_id']) ? $_POST['variant_id'] : null;
        $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 1;

        if (!$product_id || !$variant_id) {
            echo json_encode(['status' => 'error', 'message' => 'Thiếu thông tin sản phẩm']);
            return;
        }

        // Thêm sản phẩm vào giỏ hàng
        require_once __DIR__ . '/cartController.php';
        $cartController = new CartController();
        $cartController->addToCart($user_id, $product_id, $variant_id, $quantity);

        // Chuyển hướng đến trang thanh toán
        echo json_encode([
            'status' => 'success',
            'message' => 'Đã thêm sản phẩm vào giỏ hàng',
            'redirect' => '/duan1/index.php?act=cart&page=checkout'
        ]);
    }
} 