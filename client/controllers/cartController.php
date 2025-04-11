<?php
namespace Client\Controllers;

require_once __DIR__ . '/../models/cartModel.php';
use Client\Models\Cart; // Sử dụng namespace để phân biệt lớp

class CartController
{
    public function getCart($user_id) {
        if (!$user_id) {
            die("❌ Lỗi: Người dùng không hợp lệ.");
        }
    
        $cartModel = new Cart(); // Khởi tạo đối tượng CartModel
    
        // Lấy tất cả sản phẩm trong giỏ hàng của người dùng
        $cartItems = $cartModel->getAllCartItems($user_id);
    
        // Truyền dữ liệu vào view
        require_once __DIR__ . '/../views/cart/list.php';
    }

    public function addToCart($user_id, $product_id, $variant_id, $quantity) {
        if (!$user_id || !$product_id || !$variant_id || $quantity < 1) {
            die("❌ Lỗi: Dữ liệu không hợp lệ.");
        }
    
        $cartModel = new Cart();
    
        try {
            $cartModel->addItem($user_id, $product_id, $variant_id, $quantity);
        } catch (\Exception $e) {
            die("❌ Lỗi khi thêm sản phẩm vào giỏ hàng: " . $e->getMessage());
        }
    }

    public function updateCartItem() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cart_item_id = $_POST['cart_item_id'] ?? null;
            $quantity = $_POST['quantity'] ?? null;
    
            if (!$cart_item_id || !$quantity || $quantity < 1) {
                die("❌ Lỗi: Thiếu thông tin hoặc số lượng không hợp lệ.");
            }
    
            $cartModel = new Cart();
    
            try {
                // Cập nhật số lượng sản phẩm trong giỏ hàng
                $cartModel->updateItem($cart_item_id, $quantity);
    
                // Chuyển hướng về trang danh sách giỏ hàng
                header('Location: /duan1/index.php?act=cart&page=list');
                exit();
            } catch (\Exception $e) {
                die("❌ Lỗi khi cập nhật sản phẩm trong giỏ hàng: " . $e->getMessage());
            }
        }
    }

    public function deleteCartItem() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $cart_item_id = $_GET['cart_item_id'] ?? null;
    
            if (!$cart_item_id) {
                die("❌ Lỗi: Thiếu thông tin sản phẩm cần xóa.");
            }
    
            $cartModel = new Cart();
    
            try {
                // Xóa sản phẩm khỏi giỏ hàng
                $cartModel->deleteItem($cart_item_id);
    
                // Chuyển hướng về trang danh sách giỏ hàng
                header('Location: /duan1/index.php?act=cart&page=list');
                exit();
            } catch (\Exception $e) {
                die("❌ Lỗi khi xóa sản phẩm khỏi giỏ hàng: " . $e->getMessage());
            }
        }
    }
    // getAllCartItems trả về danh sách sản phẩm trong giỏ hàng
    public function getAllCartItems($user_id) {
        $stmt = $this->conn->prepare("
            SELECT ci.id AS cart_item_id, ci.product_id, ci.variant_id, ci.quantity, 
                   p.name AS product_name, p.price, pv.sale_price, pv.quantity AS stock_quantity,
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
}