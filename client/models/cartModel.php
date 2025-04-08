<?php
require_once __DIR__ . '/../../commons/connect.php';

class Cart {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    public function addItem($user_id, $product_id, $variant_id, $quantity) {
        // Validate variant_id
        if (empty($variant_id)) {
            throw new Exception("Biến thể sản phẩm không hợp lệ.");
        }

        // Check if the cart exists for the user
        $stmt = $this->conn->prepare("SELECT id FROM carts WHERE user_id = ?");
        $stmt->execute([$user_id]);
        $cart = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$cart) {
            // Create a new cart if it doesn't exist
            $stmt = $this->conn->prepare("INSERT INTO carts (user_id) VALUES (?)");
            $stmt->execute([$user_id]);
            $cart_id = $this->conn->lastInsertId();
        } else {
            $cart_id = $cart['id'];
        }

        // Check if the product already exists in the cart
        $stmt = $this->conn->prepare("SELECT id FROM cart_items WHERE cart_id = ? AND product_id = ? AND variant_id = ?");
        $stmt->execute([$cart_id, $product_id, $variant_id]);
        $cart_item = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($cart_item) {
            // Update quantity if the product already exists
            $stmt = $this->conn->prepare("UPDATE cart_items SET quantity = quantity + ? WHERE id = ?");
            $stmt->execute([$quantity, $cart_item['id']]);
        } else {
            // Insert a new product into the cart
            $stmt = $this->conn->prepare("INSERT INTO cart_items (cart_id, product_id, variant_id, quantity) VALUES (?, ?, ?, ?)");
            $stmt->execute([$cart_id, $product_id, $variant_id, $quantity]);
        }
    }

    public function getAllCartItems($user_id) {
        $stmt = $this->conn->prepare("
            SELECT ci.id AS cart_item_id, ci.product_id, ci.variant_id, ci.quantity,
                   p.name AS product_name, p.price, pv.quantity AS stock_quantity
            FROM cart_items ci
            JOIN carts c ON ci.cart_id = c.id
            JOIN products p ON ci.product_id = p.product_id
            JOIN product_variants pv ON ci.variant_id = pv.product_variant_id
            WHERE c.user_id = ?
        ");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteItem($cart_item_id) {
        $stmt = $this->conn->prepare("DELETE FROM cart_items WHERE id = ?");
        $stmt->execute([$cart_item_id]);
    }
}
?>