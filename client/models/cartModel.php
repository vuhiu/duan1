<?php
namespace Client\Models;

require_once __DIR__ . '/../../commons/connect.php';

class Cart {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    // Thêm sản phẩm vào giỏ hàng
    public function addItem($user_id, $product_id, $variant_id, $quantity) {
        // Lấy giá từ bảng product_variants
        $stmt = $this->conn->prepare("SELECT price, sale_price FROM product_variants WHERE product_variant_id = ?");
        $stmt->execute([$variant_id]);
        $variant = $stmt->fetch(\PDO::FETCH_ASSOC);
    
        if (!$variant) {
            throw new \Exception("❌ Lỗi: Biến thể sản phẩm không tồn tại.");
        }
    
        // Lấy giá từ biến thể (ưu tiên giá khuyến mãi nếu có)
        $price = $variant['sale_price'] ?? $variant['price'];
    
        // Kiểm tra giỏ hàng của người dùng
        $stmt = $this->conn->prepare("SELECT id FROM carts WHERE user_id = ?");
        $stmt->execute([$user_id]);
        $cart = $stmt->fetch(\PDO::FETCH_ASSOC);
    
        if (!$cart) {
            // Tạo giỏ hàng mới nếu chưa tồn tại
            $stmt = $this->conn->prepare("INSERT INTO carts (user_id) VALUES (?)");
            $stmt->execute([$user_id]);
            $cart_id = $this->conn->lastInsertId();
        } else {
            $cart_id = $cart['id'];
        }
    
        // Kiểm tra sản phẩm đã tồn tại trong giỏ hàng chưa
        $stmt = $this->conn->prepare("SELECT id FROM cart_items WHERE cart_id = ? AND product_id = ? AND variant_id = ?");
        $stmt->execute([$cart_id, $product_id, $variant_id]);
        $cart_item = $stmt->fetch(\PDO::FETCH_ASSOC);
    
        if ($cart_item) {
            // Cập nhật số lượng nếu sản phẩm đã tồn tại
            $stmt = $this->conn->prepare("UPDATE cart_items SET quantity = quantity + ? WHERE id = ?");
            $stmt->execute([$quantity, $cart_item['id']]);
        } else {
            // Thêm sản phẩm mới vào giỏ hàng với giá từ biến thể
            $stmt = $this->conn->prepare("INSERT INTO cart_items (cart_id, product_id, variant_id, quantity, price) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$cart_id, $product_id, $variant_id, $quantity, $price]);
        }
    }

    // Lấy tất cả sản phẩm trong giỏ hàng của người dùng
    public function getAllCartItems($user_id) {
        $stmt = $this->conn->prepare("
            SELECT ci.id AS cart_item_id, ci.product_id, ci.variant_id, ci.quantity, 
                   p.name AS product_name, p.image AS product_image, 
                   pv.price AS variant_price, pv.sale_price AS variant_sale_price,
                   vc.color_name AS product_variant_color, vs.size_name AS product_variant_size
            FROM cart_items ci
            JOIN carts c ON ci.cart_id = c.id
            JOIN products p ON ci.product_id = p.product_id
            JOIN product_variants pv ON ci.variant_id = pv.product_variant_id
            LEFT JOIN variant_colors vc ON pv.variant_color_id = vc.variant_color_id
            LEFT JOIN variant_size vs ON pv.variant_size_id = vs.variant_size_id
            WHERE c.user_id = ?
        ");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Cập nhật số lượng sản phẩm trong giỏ hàng
    public function updateItem($cart_item_id, $quantity) {
        $stmt = $this->conn->prepare("UPDATE cart_items SET quantity = ? WHERE id = ?");
        $stmt->execute([$quantity, $cart_item_id]);
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function deleteItem($cart_item_id) {
        $stmt = $this->conn->prepare("DELETE FROM cart_items WHERE id = ?");
        $stmt->execute([$cart_item_id]);
    }
}
?>