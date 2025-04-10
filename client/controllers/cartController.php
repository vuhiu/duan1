<?php
namespace Client\Controllers;

require_once __DIR__ . '/../models/cartModel.php';
use Client\Models\Cart; // Sử dụng namespace để phân biệt lớp

class CartController
{
    public function getCart($user_id) {
        //kiểm tra xem user_id được truyền vào có đúng không.
        if (!$user_id) {
            echo "User ID không tồn tại.";
            exit();
        } else {
            echo "User ID: " . $user_id;
        }

        require_once __DIR__ . '/../models/cartModel.php';
        $cartModel = new Cart(); // Khởi tạo đối tượng CartModel

        // Lấy tất cả sản phẩm trong giỏ hàng của người dùng
        $cartItems = $cartModel->getAllCartItems($user_id); 
    
        // Truyền dữ liệu vào view
        require_once __DIR__ . '/../views/cart/list.php';
    }

    // Thêm sản phẩm vào giỏ hàng
    public function addToCart($user_id, $product_id, $variant_id, $quantity) {
        if (!$user_id || !$product_id || !$variant_id || !$quantity) {
            die("❌ Lỗi: Thiếu thông tin cần thiết để thêm vào giỏ hàng.");
        }
    
        $cartModel = new Cart();
        $cartModel->addItem($user_id, $product_id, $variant_id, $quantity);
    
        // Chuyển hướng đến trang giỏ hàng
        header('Location: /duan1/index.php?act=cart&page=list');
        exit();
    }
    // Cập nhật sản phẩm trong giỏ hàng
    // Cập nhật số lượng sản phẩm trong giỏ hàng
    public function updateCartItem() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cart_item_id = $_POST['cart_item_id'] ?? null;
            $quantity = $_POST['quantity'] ?? null;
    
            if (!$cart_item_id || !$quantity || $quantity <= 0) {
                die("❌ Lỗi: Thiếu thông tin hoặc số lượng không hợp lệ.");
            }
    
            $cartModel = new Cart();
            $cartModel->updateItem($cart_item_id, $quantity);
    
            // Chuyển hướng lại trang giỏ hàng
            header('Location: /duan1/index.php?act=cart&page=list');
            exit();
        }
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function deleteCartItem() {
        if (isset($_GET['cart_item_id'])) {
            $cart_item_id = $_GET['cart_item_id'];
    
            $cartModel = new Cart();
            $cartModel->deleteItem($cart_item_id);
    
            // Chuyển hướng lại trang giỏ hàng
            header('Location: /duan1/index.php?act=cart&page=list');
            exit();
        } else {
            die("❌ Lỗi: Không tìm thấy sản phẩm để xóa.");
        }
    }
    // getAllCartItems trả về danh sách sản phẩm trong giỏ hàng
    public function getAllCartItems($user_id) {
        $stmt = $this->conn->prepare("
            SELECT ci.id AS cart_item_id, ci.product_id, ci.variant_id, ci.quantity, 
                   p.name AS product_name, p.price, pv.sale_price, pv.quantity AS stock_quantity
            FROM cart_items ci
            JOIN carts c ON ci.cart_id = c.id
            JOIN products p ON ci.product_id = p.product_id
            JOIN product_variants pv ON ci.variant_id = pv.product_variant_id
            WHERE c.user_id = ?
        ");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}