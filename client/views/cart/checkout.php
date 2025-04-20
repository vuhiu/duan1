<?php
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header('Location: /duan1/client/views/auth/form-login.php');
    exit();
}

$couponDiscount = $_SESSION['coupon_discount'] ?? 0;
$couponMessage = $_SESSION['coupon_message'] ?? '';
$appliedCoupon = $_SESSION['applied_coupon'] ?? null;
$selectedShippingId = $_SESSION['selected_shipping'] ?? null;

// Xử lý lỗi form
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['process_checkout'])) {
    $name = trim($_POST['name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $payment_method = $_POST['payment_method'] ?? '';

    if (empty($name)) {
        $errors['name'] = 'Vui lòng nhập họ tên';
    }
    if (empty($phone)) {
        $errors['phone'] = 'Vui lòng nhập số điện thoại';
    } elseif (!preg_match('/^[0-9]{10,11}$/', $phone)) {
        $errors['phone'] = 'Số điện thoại không hợp lệ';
    }
    if (empty($email)) {
        $errors['email'] = 'Vui lòng nhập email';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Email không hợp lệ';
    }
    if (empty($address)) {
        $errors['address'] = 'Vui lòng nhập địa chỉ';
    }
    if (empty($payment_method)) {
        $errors['payment_method'] = 'Vui lòng chọn phương thức thanh toán';
    }
    if (empty($selectedShippingId)) {
        $errors['shipping'] = 'Vui lòng chọn phương thức vận chuyển';
    }
    if (empty($cartItems)) {
        $errors['cart'] = 'Giỏ hàng trống';
    }

    if (empty($errors)) {
        header('Location: /duan1/index.php?act=cart&page=checkout&process=1');
        exit();
    }
}

if (isset($_SESSION['error'])) {
    echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
    unset($_SESSION['error']);
}
?>

<!-- BREADCRUMB -->
<div id="breadcrumb" class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 class="breadcrumb-header">Thanh toán</h3>
                <ul class="breadcrumb-tree">
                    <li><a href="/duan1/index.php">Trang chủ</a></li>
                    <li><a href="/duan1/index.php?act=cart&page=list">Giỏ hàng</a></li>
                    <li class="active">Thanh toán</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- /BREADCRUMB -->

<!-- SECTION -->
<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <!-- Thông tin người nhận -->
                <div class="billing-details">
                    <div class="section-title">
                        <h3 class="title">Thông tin người nhận</h3>
                    </div>
                    <form action="/duan1/index.php?act=cart&page=checkout" method="POST" id="checkoutForm">
                        <div class="form-group">
                            <input class="input <?= isset($errors['name']) ? 'is-invalid' : '' ?>" type="text"
                                name="name" placeholder="Họ tên"
                                value="<?= htmlspecialchars($_POST['name'] ?? $user['name'] ?? '') ?>">
                            <?php if (isset($errors['name'])): ?>
                                <div class="invalid-feedback"><?= $errors['name'] ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <input class="input <?= isset($errors['email']) ? 'is-invalid' : '' ?>" type="email"
                                name="email" placeholder="Email"
                                value="<?= htmlspecialchars($_POST['email'] ?? $user['email'] ?? '') ?>">
                            <?php if (isset($errors['email'])): ?>
                                <div class="invalid-feedback"><?= $errors['email'] ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <input class="input <?= isset($errors['phone']) ? 'is-invalid' : '' ?>" type="tel"
                                name="phone" placeholder="Số điện thoại"
                                value="<?= htmlspecialchars(isset($_POST['phone']) ? $_POST['phone'] : (isset($user['phone']) ? str_pad($user['phone'], 10, '0', STR_PAD_LEFT) : '')) ?>">
                            <?php if (isset($errors['phone'])): ?>
                                <div class="invalid-feedback"><?= $errors['phone'] ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <textarea class="input <?= isset($errors['address']) ? 'is-invalid' : '' ?>"
                                name="address" placeholder="Địa chỉ" rows="5"><?= htmlspecialchars($_POST['address'] ?? $user['address'] ?? '') ?></textarea>
                            <?php if (isset($errors['address'])): ?>
                                <div class="invalid-feedback"><?= $errors['address'] ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Phương thức thanh toán -->
                        <div class="section-title">
                            <h3 class="title">Phương thức thanh toán</h3>
                        </div>
                        <?php if (isset($errors['payment_method'])): ?>
                            <div class="text-danger mb-2"><?= $errors['payment_method'] ?></div>
                        <?php endif; ?>
                        <div class="input-radio">
                            <input type="radio" name="payment_method" id="cod" value="cod"
                                <?= ($_POST['payment_method'] ?? '') === 'cod' ? 'checked' : '' ?>>
                            <label for="cod">
                                <span></span>
                                Thanh toán khi nhận hàng (COD)
                            </label>
                            <div class="caption">
                                <p>Bạn sẽ thanh toán bằng tiền mặt khi nhận hàng.</p>
                            </div>
                        </div>

                        <div class="input-radio">
                            <input type="radio" name="payment_method" id="bank" value="bank"
                                <?= ($_POST['payment_method'] ?? '') === 'bank' ? 'checked' : '' ?>>
                            <label for="bank">
                                <span></span>
                                Chuyển khoản ngân hàng
                            </label>
                            <div class="caption">
                                <p>Thông tin tài khoản ngân hàng sẽ được gửi qua email sau khi đặt hàng.</p>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Danh sách sản phẩm -->
                <div class="order-details mt-30">
                    <div class="section-title">
                        <h3 class="title">Đơn hàng của bạn</h3>
                    </div>
                    <div class="order-summary">
                        <div class="order-products">
                            <?php if (empty($cartItems)): ?>
                                <div class="alert alert-warning">Giỏ hàng trống</div>
                            <?php else: ?>
                                <?php foreach ($cartItems as $item): ?>
                                    <div class="order-col">
                                        <div>
                                            <img src="/duan1/upload/<?= htmlspecialchars($item['image']) ?>"
                                                alt="<?= htmlspecialchars($item['name']) ?>"
                                                style="width: 50px; margin-right: 10px;">
                                            <?= htmlspecialchars($item['name']) ?>
                                            <strong>x <?= $item['quantity'] ?></strong>
                                        </div>
                                        <div>
                                            <?php if ($item['variant_sale_price']): ?>
                                                <strong class="text-danger">
                                                    <?= number_format($item['variant_sale_price'] * $item['quantity'], 0, ',', '.') ?>đ
                                                </strong>
                                                <br>
                                                <span class="text-decoration-line-through">
                                                    <?= number_format($item['variant_price'] * $item['quantity'], 0, ',', '.') ?>đ
                                                </span>
                                            <?php else: ?>
                                                <strong>
                                                    <?= number_format($item['variant_price'] * $item['quantity'], 0, ',', '.') ?>đ
                                                </strong>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <!-- Phương thức vận chuyển -->
                <div class="shipping-methods">
                    <div class="section-title">
                        <h4 class="title">Phương thức vận chuyển</h4>
                    </div>
                    <form action="/duan1/index.php?act=cart&page=checkout" method="POST">
                        <div class="shipping-options">
                            <?php foreach ($shippingMethods as $method): ?>
                                <div class="shipping-option">
                                    <div class="shipping-radio">
                                        <input type="radio" name="shipping_method"
                                            id="shipping_<?= $method['ship_id'] ?>"
                                            value="<?= $method['ship_id'] ?>"
                                            <?= $selectedShippingId == $method['ship_id'] ? 'checked' : '' ?>>
                                        <label for="shipping_<?= $method['ship_id'] ?>">
                                            <div class="shipping-info">
                                                <div class="shipping-name"><?= htmlspecialchars($method['shipping_name']) ?></div>
                                                <div class="shipping-price"><?= number_format($method['shipping_prices'], 0, ',', '.') ?> đ</div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="submit" name="update_shipping" class="primary-btn mt-3">
                            Cập nhật phương thức vận chuyển
                        </button>
                    </form>
                </div>

                <!-- Mã giảm giá -->
                <div class="coupon mt-30">
                    <div class="section-title">
                        <h4 class="title">Mã giảm giá</h4>
                    </div>
                    <form action="/duan1/index.php?act=cart&page=checkout" method="POST">
                        <input class="input" type="text" name="coupon_code" placeholder="Nhập mã giảm giá">
                        <button type="submit" name="apply_coupon" class="primary-btn">Áp dụng</button>
                    </form>
                    <?php if ($couponMessage): ?>
                        <div class="alert alert-info mt-2"><?= $couponMessage ?></div>
                    <?php endif; ?>
                    <?php if ($appliedCoupon): ?>
                        <div class="alert alert-success mt-2">
                            Mã giảm giá đã áp dụng: <?= htmlspecialchars($appliedCoupon['coupon_code'] ?? '') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Tổng tiền -->
                <div class="order-summary mt-30">
                    <div class="section-title">
                        <h4 class="title">Tổng tiền</h4>
                    </div>
                    <?php
                    // Tính toán các giá trị
                    $subtotal = $totalPrice;
                    $shippingFee = 0;
                    if ($selectedShippingId && isset($shippingMethods)) {
                        $shippingMethod = array_filter($shippingMethods, function ($method) use ($selectedShippingId) {
                            return $method['ship_id'] == $selectedShippingId;
                        });
                        $shippingMethod = reset($shippingMethod);
                        $shippingFee = $shippingMethod['shipping_prices'];
                    }

                    // Tính lại giảm giá nếu có mã giảm giá
                    if ($appliedCoupon) {
                        $discountResult = $couponModel->applyDiscount($appliedCoupon, $subtotal);
                        $couponDiscount = $discountResult['discount'];
                        $_SESSION['coupon_discount'] = $couponDiscount;
                    }

                    // Tính tổng cộng
                    $finalTotal = $subtotal + $shippingFee - $couponDiscount;
                    if ($finalTotal < 0) $finalTotal = 0;
                    ?>

                    <div class="order-col">
                        <div><strong>Tạm tính</strong></div>
                        <div><strong><?= number_format($subtotal, 0, ',', '.') ?>đ</strong></div>
                    </div>

                    <?php if ($shippingFee > 0): ?>
                        <div class="order-col">
                            <div><strong>Phí vận chuyển</strong></div>
                            <div><strong><?= number_format($shippingFee, 0, ',', '.') ?>đ</strong></div>
                        </div>
                    <?php endif; ?>

                    <?php if ($couponDiscount > 0): ?>
                        <div class="order-col">
                            <div>
                                <strong>Giảm giá</strong>
                                <?php if ($appliedCoupon): ?>
                                    <br>
                                    <small class="text-muted">
                                        Mã: <?= htmlspecialchars($appliedCoupon['coupon_code']) ?>
                                        <br>
                                        <?= $discountResult['message'] ?>
                                    </small>
                                <?php endif; ?>
                            </div>
                            <div>
                                <strong class="text-danger">-<?= number_format($couponDiscount, 0, ',', '.') ?>đ</strong>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="order-col total">
                        <div><strong>TỔNG CỘNG</strong></div>
                        <div>
                            <strong class="order-total"><?= number_format($finalTotal, 0, ',', '.') ?>đ</strong>
                        </div>
                    </div>

                    <button type="submit" form="checkoutForm" name="process_checkout"
                        class="primary-btn order-submit"
                        <?= empty($cartItems) ? 'disabled' : '' ?>>
                        Đặt hàng
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /SECTION -->

<style>
    .shipping-options {
        border: 1px solid #e4e7ed;
        border-radius: 4px;
        padding: 10px;
        margin-bottom: 15px;
    }

    .shipping-option {
        margin-bottom: 10px;
        padding: 10px;
        border-radius: 4px;
        transition: all 0.3s;
    }

    .shipping-option:last-child {
        margin-bottom: 0;
    }

    .shipping-option:hover {
        background-color: #f8f9fa;
    }

    .shipping-radio {
        display: flex;
        align-items: center;
    }

    .shipping-radio input[type="radio"] {
        margin-right: 10px;
    }

    .shipping-info {
        flex-grow: 1;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .shipping-name {
        font-weight: 500;
        color: #2B2D42;
    }

    .shipping-price {
        color: #D10024;
        font-weight: 500;
    }

    .shipping-radio input[type="radio"]:checked+label {
        color: #D10024;
    }

    .shipping-option.selected {
        background-color: #f8f9fa;
        border-color: #D10024;
    }

    .order-col.total {
        margin-top: 10px;
        padding-top: 10px;
        border-top: 2px solid #e4e7ed;
    }

    .order-total {
        color: #D10024;
        font-size: 18px;
    }

    .order-submit {
        margin-top: 15px;
        padding: 8px 20px;
        font-size: 13px;
    }

    .primary-btn {
        display: inline-block;
        min-width: 100px;
        text-align: center;
        padding: 8px 15px;
        font-size: 13px;
    }

    .text-decoration-line-through {
        text-decoration: line-through !important;
        color: #8D99AE !important;
    }

    /* Điều chỉnh kích thước nút trong form mã giảm giá */
    .coupon .primary-btn {
        padding: 8px 15px;
        margin-top: 10px;
    }

    .coupon .input {
        margin-bottom: 10px;
    }

    /* Điều chỉnh kích thước nút cập nhật phương thức vận chuyển */
    button[name="update_shipping"] {
        padding: 8px 15px;
        font-size: 13px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const shippingOptions = document.querySelectorAll('.shipping-option');

        shippingOptions.forEach(option => {
            const radio = option.querySelector('input[type="radio"]');

            if (radio.checked) {
                option.classList.add('selected');
            }

            radio.addEventListener('change', function() {
                shippingOptions.forEach(opt => opt.classList.remove('selected'));
                if (this.checked) {
                    option.classList.add('selected');
                }
            });
        });
    });
</script>