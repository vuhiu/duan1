<?php

require_once __DIR__ . '/../../commons/connect.php';

class Cart
{
    private $conn;

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    // Thêm sản phẩm vào giỏ hàng
    public function addItem($user_id, $product_id, $variant_id, $quantity)
    {
        // Kiểm tra giỏ hàng tồn tại
        $cart_id = $this->getOrCreateCart($user_id);

        // Kiểm tra sản phẩm đã có trong giỏ hàng chưa
        $sql = "SELECT id, quantity FROM cart_items 
                WHERE cart_id = ? AND product_id = ? AND variant_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$cart_id, $product_id, $variant_id]);
        $item = $stmt->fetch();

        // Lấy giá sản phẩm từ product_variants
        $sql = "SELECT price, sale_price FROM product_variants WHERE product_variant_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$variant_id]);
        $variant = $stmt->fetch();
        
        // Sử dụng sale_price nếu có, ngược lại sử dụng price
        $price = $variant['sale_price'] > 0 ? $variant['sale_price'] : $variant['price'];

        if ($item) {
            // Cập nhật số lượng nếu sản phẩm đã tồn tại
            $new_quantity = $item['quantity'] + $quantity;
            $sql = "UPDATE cart_items SET quantity = ? WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([$new_quantity, $item['id']]);
        } else {
            // Thêm sản phẩm mới vào giỏ hàng
            $sql = "INSERT INTO cart_items (cart_id, product_id, variant_id, quantity, price) 
                    VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([$cart_id, $product_id, $variant_id, $quantity, $price]);
        }
    }

    // Lấy tất cả sản phẩm trong giỏ hàng của người dùng
    public function getAllCartItems($user_id)
    {
        $sql = "SELECT 
                ci.id as cart_item_id,
                ci.product_id,
                ci.variant_id,
                ci.quantity,
                p.name,
                p.image,
                pv.price as variant_price,
                pv.sale_price as variant_sale_price,
                vc.color_name,
                vs.size_name
                FROM carts c
                JOIN cart_items ci ON c.id = ci.cart_id
                JOIN products p ON ci.product_id = p.product_id
                JOIN product_variants pv ON ci.variant_id = pv.product_variant_id
                LEFT JOIN variant_colors vc ON pv.variant_color_id = vc.variant_color_id
                LEFT JOIN variant_size vs ON pv.variant_size_id = vs.variant_size_id
                WHERE c.user_id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Cập nhật số lượng sản phẩm trong giỏ hàng
    public function updateItem($cart_item_id, $quantity)
    {
        $sql = "UPDATE cart_items SET quantity = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$quantity, $cart_item_id]);
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function deleteItem($cart_item_id)
    {
        $sql = "DELETE FROM cart_items WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$cart_item_id]);
    }

    // Xóa toàn bộ giỏ hàng của người dùng
    public function clearCart($user_id)
    {
        $sql = "DELETE ci FROM cart_items ci 
                JOIN carts c ON ci.cart_id = c.id 
                WHERE c.user_id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$user_id]);
    }

    // Tạo đơn hàng mới
    public function createOrder($user_id, $total_amount, $shipping_cost, $discount, $final_amount, $coupon_id, $shipping_method_id, $cartItems)
    {
        try {
            $this->conn->beginTransaction();

            // Lấy thông tin người dùng
            $sql = "SELECT name, email, phone, address FROM users WHERE user_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$user_id]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Chuẩn bị câu lệnh SQL để tạo order_details
            $sql = "INSERT INTO order_details (
                    user_id, 
                    name,
                    email,
                    phone,
                    address,
                    amount,
                    shipping_id,
                    coupon_id,
                    note,
                    payment_method,
                    status,
                    payment_status
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending', 'unpaid')";

            // Nếu có mã giảm giá, kiểm tra tính hợp lệ
            if ($coupon_id) {
                $checkCoupon = "SELECT coupon_id FROM coupons WHERE coupon_id = ?";
                $stmt = $this->conn->prepare($checkCoupon);
                $stmt->execute([$coupon_id]);
                if (!$stmt->fetch()) {
                    throw new Exception("Mã giảm giá không hợp lệ!");
                }
            }

            // Thực thi câu lệnh tạo order_details
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                $user_id,
                $user['name'],
                $user['email'],
                $user['phone'],
                $user['address'],
                $final_amount,
                $shipping_method_id,
                $coupon_id ? $coupon_id : 0,
                isset($_POST['note']) ? $_POST['note'] : '',
                isset($_POST['payment_method']) ? $_POST['payment_method'] : 'cod'
            ]);

            $order_detail_id = $this->conn->lastInsertId();

            // Tạo các order items
            foreach ($cartItems as $item) {
                $sql = "INSERT INTO orders (user_id, product_id, variant_id, order_detail_id, quantity) 
                        VALUES (?, ?, ?, ?, ?)";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([
                    $user_id,
                    $item['product_id'],
                    $item['variant_id'],
                    $order_detail_id,
                    $item['quantity']
                ]);
            }

            // Nếu có coupon hợp lệ, giảm số lượng coupon
            if ($coupon_id) {
                $sql = "UPDATE coupons SET quantity = quantity - 1 WHERE coupon_id = ? AND quantity > 0";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$coupon_id]);
            }

            // Xóa giỏ hàng sau khi đặt hàng thành công
            $this->clearCart($user_id);

            $this->conn->commit();
            return $order_detail_id;
        } catch (Exception $e) {
            $this->conn->rollBack();
            throw $e;
        }
    }

    private function getOrCreateCart($user_id)
    {
        // Kiểm tra giỏ hàng tồn tại
        $sql = "SELECT id FROM carts WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$user_id]);
        $cart = $stmt->fetch();

        if ($cart) {
            return $cart['id'];
        }

        // Tạo giỏ hàng mới nếu chưa tồn tại
        $sql = "INSERT INTO carts (user_id) VALUES (?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$user_id]);
        return $this->conn->lastInsertId();
    }

    // Lấy thông tin giỏ hàng cho dropdown
    public function getCartItems($user_id)
    {
        $sql = "SELECT 
                ci.id as cart_item_id,
                ci.product_id,
                ci.variant_id,
                ci.quantity,
                p.name as product_name,
                p.image as product_image,
                pv.price,
                pv.sale_price
                FROM carts c
                JOIN cart_items ci ON c.id = ci.cart_id
                JOIN products p ON ci.product_id = p.product_id
                JOIN product_variants pv ON ci.variant_id = pv.product_variant_id
                WHERE c.user_id = ?
                ORDER BY ci.id DESC
                LIMIT 5";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
