<?php

require_once __DIR__ . '/../models/cartModel.php';
require_once __DIR__ . '/../models/couponModel.php';
require_once __DIR__ . '/../models/UserClient.php';
require_once __DIR__ . '/../models/ShippingModel.php';

class CartController
{
    private $cartModel;
    private $userModel;
    private $shippingModel;
    private $couponModel;

    public function __construct()
    {
        $this->cartModel = new Cart();
        $this->userModel = new UserClient();
        $this->shippingModel = new Ship();
        $this->couponModel = new CouponModel();
    }

    public function getCart($user_id)
    {
        if (!$user_id) {
            die("❌ Lỗi: Người dùng không hợp lệ.");
        }

        // Lấy tất cả sản phẩm trong giỏ hàng của người dùng
        $cartItems = $this->cartModel->getAllCartItems($user_id);

        // Tính tổng tiền
        $totalPrice = 0;
        foreach ($cartItems as $item) {
            $price = $item['variant_sale_price'] ?? $item['variant_price'];
            $totalPrice += $price * $item['quantity'];
        }

        // Truyền dữ liệu vào view
        require_once __DIR__ . '/../views/cart/list.php';
    }

    public function addToCart($user_id, $product_id, $variant_id, $quantity)
    {
        if (!$user_id || !$product_id || !$variant_id || $quantity < 1) {
            die("❌ Lỗi: Dữ liệu không hợp lệ.");
        }

        try {
            $this->cartModel->addItem($user_id, $product_id, $variant_id, $quantity);
        } catch (Exception $e) {
            die("❌ Lỗi khi thêm sản phẩm vào giỏ hàng: " . $e->getMessage());
        }
    }

    public function updateCartItem()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cart_item_id = $_POST['cart_item_id'] ?? null;
            $quantity = $_POST['quantity'] ?? null;

            if (!$cart_item_id || !$quantity || $quantity < 1) {
                die("❌ Lỗi: Dữ liệu không hợp lệ.");
            }

            try {
                $this->cartModel->updateItem($cart_item_id, $quantity);
                header('Location: /duan1/index.php?act=cart&page=list');
                exit();
            } catch (Exception $e) {
                die("❌ Lỗi khi cập nhật giỏ hàng: " . $e->getMessage());
            }
        }
    }

    public function deleteCartItem()
    {
        if (isset($_GET['cart_item_id'])) {
            $cart_item_id = $_GET['cart_item_id'];
            try {
                $this->cartModel->deleteItem($cart_item_id);
                header('Location: /duan1/index.php?act=cart&page=list');
                exit();
            } catch (Exception $e) {
                die("❌ Lỗi khi xóa sản phẩm khỏi giỏ hàng: " . $e->getMessage());
            }
        }
    }

    public function validateCoupon()
    {
        if (!isset($_POST['coupon_code']) || empty($_POST['coupon_code'])) {
            $_SESSION['coupon_message'] = 'Vui lòng nhập mã giảm giá!';
            return;
        }

        $couponCode = trim($_POST['coupon_code']);
        $user_id = $_SESSION['user_id'];

        // Validate coupon
        $coupon = $this->couponModel->validateCoupon($couponCode);
        if (!$coupon) {
            $_SESSION['coupon_message'] = 'Mã giảm giá không hợp lệ hoặc đã hết hạn!';
            unset($_SESSION['applied_coupon']);
            unset($_SESSION['coupon_discount']);
            return;
        }

        // Tính tổng tiền giỏ hàng
        $cartItems = $this->cartModel->getAllCartItems($user_id);
        $totalAmount = 0;
        foreach ($cartItems as $item) {
            $price = $item['variant_sale_price'] ?? $item['variant_price'];
            $totalAmount += $price * $item['quantity'];
        }

        // Áp dụng giảm giá
        $discountResult = $this->couponModel->applyDiscount($coupon, $totalAmount);

        if ($discountResult['error']) {
            $_SESSION['coupon_message'] = $discountResult['error'];
            unset($_SESSION['applied_coupon']);
            unset($_SESSION['coupon_discount']);
            return;
        }

        // Lưu thông tin mã giảm giá vào session
        $_SESSION['applied_coupon'] = $coupon;
        $_SESSION['coupon_discount'] = $discountResult['discount'];
        $_SESSION['coupon_message'] = 'Áp dụng mã giảm giá thành công! ' . $discountResult['message'] .
            ' (-' . number_format($discountResult['discount'], 0, ',', '.') . 'đ)';
    }

    public function checkout()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /duan1/client/views/auth/form-login.php');
            exit();
        }

        $user_id = $_SESSION['user_id'];

        // Lấy thông tin người dùng
        $user = $this->userModel->getUserById($user_id);

        // Lấy thông tin giỏ hàng
        $cartItems = $this->cartModel->getAllCartItems($user_id);
        if (empty($cartItems)) {
            header('Location: /duan1/index.php?act=cart&page=list');
            exit();
        }

        // Tính tổng tiền
        $totalPrice = 0;
        foreach ($cartItems as $item) {
            $price = $item['variant_sale_price'] ?? $item['variant_price'];
            $totalPrice += $price * $item['quantity'];
        }

        // Lấy phương thức vận chuyển
        $shippingMethods = $this->shippingModel->getAllShippingMethods();

        // Xử lý POST request
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Xử lý cập nhật phí vận chuyển
            if (isset($_POST['update_shipping']) && isset($_POST['shipping_method'])) {
                $_SESSION['selected_shipping'] = $_POST['shipping_method'];
                header('Location: /duan1/index.php?act=cart&page=checkout');
                exit();
            }

            // Xử lý áp dụng mã giảm giá
            if (isset($_POST['apply_coupon'])) {
                $this->validateCoupon();
                header('Location: /duan1/index.php?act=cart&page=checkout');
                exit();
            }

            // Xử lý thanh toán
            if (isset($_POST['process_checkout'])) {
                $this->processCheckout();
                exit();
            }
        }

        // Truyền biến couponModel vào view
        $couponModel = $this->couponModel;

        // Include view
        include 'client/views/cart/checkout.php';
    }

    public function processCheckout()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /duan1/client/views/auth/form-login.php');
            exit();
        }

        $user_id = $_SESSION['user_id'];
        $cartItems = $this->cartModel->getAllCartItems($user_id);

        if (empty($cartItems)) {
            $_SESSION['error'] = "Giỏ hàng trống!";
            header('Location: /duan1/index.php?act=cart&page=list');
            exit();
        }

        // Kiểm tra dữ liệu form
        if (!isset($_POST['name']) || !isset($_POST['phone']) || !isset($_POST['address'])) {
            $_SESSION['error'] = "Vui lòng điền đầy đủ thông tin giao hàng!";
            header('Location: /duan1/index.php?act=cart&page=checkout');
            exit();
        }

        // Xử lý số điện thoại
        $phone = trim($_POST['phone']);
        // Đảm bảo số điện thoại bắt đầu bằng số 0
        if (!preg_match('/^0\d{9}$/', $phone)) {
            if (preg_match('/^\d{9}$/', $phone)) {
                $phone = '0' . $phone;
            } else {
                $_SESSION['error'] = "Số điện thoại không hợp lệ!";
                header('Location: /duan1/index.php?act=cart&page=checkout');
                exit();
            }
        }

        // Tính tổng tiền
        $totalAmount = 0;
        foreach ($cartItems as $item) {
            $price = $item['variant_sale_price'] > 0 ? $item['variant_sale_price'] : $item['variant_price'];
            $totalAmount += $price * $item['quantity'];
        }

        // Lấy thông tin giảm giá và phí vận chuyển
        $couponDiscount = $_SESSION['coupon_discount'] ?? 0;
        $selectedShippingId = $_SESSION['selected_shipping'] ?? null;

        // Lấy phí vận chuyển
        $shippingFee = 0;
        if ($selectedShippingId) {
            $shippingMethod = $this->shippingModel->getShippingMethodById($selectedShippingId);
            if ($shippingMethod) {
                $shippingFee = $shippingMethod['shipping_prices'];
            }
        }

        // Tính tổng tiền cuối cùng
        $finalAmount = $totalAmount + $shippingFee - $couponDiscount;
        if ($finalAmount < 0) $finalAmount = 0;

        try {
            // Tạo đơn hàng
            require_once __DIR__ . '/../models/orderModel.php';
            $orderModel = new OrderModel();

            // Lấy thông tin người dùng từ form
            $orderData = [
                'shipping_name' => trim($_POST['name']),
                'shipping_phone' => $phone,
                'shipping_address' => trim($_POST['address']),
                'total_amount' => $finalAmount,
                'payment_method' => $_POST['payment_method'] ?? 'cod',
                'shipping_id' => $selectedShippingId ?? 1,
                'coupon_id' => $_SESSION['applied_coupon']['coupon_id'] ?? null,
                'note' => $_POST['note'] ?? '',
                'items' => $cartItems
            ];

            // Tạo đơn hàng và lấy ID
            $orderId = $orderModel->createOrder($user_id, $orderData);

            if ($orderId) {
                // Xóa giỏ hàng
                $this->cartModel->clearCart($user_id);

                // Xóa các session không cần thiết
                unset($_SESSION['shipping_fee']);
                unset($_SESSION['coupon_discount']);
                unset($_SESSION['applied_coupon']);
                unset($_SESSION['coupon_message']);
                unset($_SESSION['selected_shipping']);

                $_SESSION['success'] = "Đặt hàng thành công!";
                header('Location: /duan1/index.php?act=order&page=detail&id=' . $orderId);
                exit();
            }
        } catch (Exception $e) {
            error_log("Error in processCheckout: " . $e->getMessage());
            $_SESSION['error'] = "Có lỗi xảy ra khi đặt hàng: " . $e->getMessage();
            header('Location: /duan1/index.php?act=cart&page=checkout');
            exit();
        }

        $_SESSION['error'] = "Có lỗi xảy ra khi đặt hàng. Vui lòng thử lại!";
        header('Location: /duan1/index.php?act=cart&page=checkout');
        exit();
    }

    public function getCartInfo($user_id) {
        // Đảm bảo không có output nào trước khi gửi JSON
        ob_clean();
        header('Content-Type: application/json');
        
        if (!$user_id) {
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }

        try {
            // Lấy thông tin giỏ hàng
            $cartItems = $this->cartModel->getCartItems($user_id);
            
            // Tính tổng số lượng và tổng tiền
            $totalQuantity = 0;
            $totalAmount = 0;

            foreach ($cartItems as $item) {
                $price = $item['sale_price'] > 0 ? $item['sale_price'] : $item['price'];
                $totalQuantity += $item['quantity'];
                $totalAmount += $price * $item['quantity'];
            }

            echo json_encode([
                'items' => $cartItems,
                'total' => $totalAmount,
                'count' => $totalQuantity
            ]);
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
        exit;
    }
}
