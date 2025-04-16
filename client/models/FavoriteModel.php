<?php

require_once __DIR__ . '/../../commons/connect.php';

class Favorite {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    // Thêm sản phẩm vào danh sách yêu thích
    public function addToFavorite($user_id, $product_id) {
        try {
            $sql = "INSERT INTO favorites (user_id, product_id, quantity, created_at) VALUES (?, ?, 1, NOW())";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([$user_id, $product_id]);
        } catch (Exception $e) {
            error_log("Error adding to favorites: " . $e->getMessage());
            return false;
        }
    }

    // Xóa sản phẩm khỏi danh sách yêu thích
    public function removeFromFavorite($user_id, $product_id) {
        try {
            $sql = "DELETE FROM favorites WHERE user_id = ? AND product_id = ?";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([$user_id, $product_id]);
        } catch (Exception $e) {
            error_log("Error removing from favorites: " . $e->getMessage());
            return false;
        }
    }

    // Lấy danh sách sản phẩm yêu thích của người dùng
    public function getFavorites($user_id) {
        try {
            $sql = "SELECT f.*, p.name, p.image, p.price, p.sale_price 
                    FROM favorites f 
                    JOIN products p ON f.product_id = p.product_id 
                    WHERE f.user_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$user_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error getting favorites: " . $e->getMessage());
            return [];
        }
    }

    // Kiểm tra sản phẩm có trong danh sách yêu thích không
    public function isFavorite($user_id, $product_id) {
        try {
            $sql = "SELECT favorite_id FROM favorites WHERE user_id = ? AND product_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$user_id, $product_id]);
            return $stmt->fetch() ? true : false;
        } catch (Exception $e) {
            error_log("Error checking favorite status: " . $e->getMessage());
            return false;
        }
    }
} 