<?php
require_once __DIR__ . '/../../commons/connect.php';

class Cart {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    public function getAllCartItems($user_id) {
        $stmt = $this->conn->prepare("SELECT * FROM cart WHERE user_id = ?");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addItem($user_id, $product_id, $quantity) {
        $stmt = $this->conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
        $stmt->execute([$user_id, $product_id, $quantity]);
    }

    public function updateItem($cart_id, $quantity) {
        $stmt = $this->conn->prepare("UPDATE cart SET quantity = ? WHERE cart_id = ?");
        $stmt->execute([$quantity, $cart_id]);
    }

    public function deleteItem($cart_id) {
        $stmt = $this->conn->prepare("DELETE FROM cart WHERE cart_id = ?");
        $stmt->execute([$cart_id]);
    }
}
?>