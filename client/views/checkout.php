<div class="container py-4">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/duan1/index.php">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="/duan1/index.php?act=cart">Giỏ hàng</a></li>
            <li class="breadcrumb-item active" aria-current="page">Thanh toán</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Thông tin thanh toán</h4>
                    <a href="/duan1/index.php?act=cart" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Quay lại giỏ hàng
                    </a>
                </div>
                <div class="card-body">
                     <form method="POST" id="checkoutForm">
                        <!-- Thông tin người nhận -->
                        <div class="mb-3">
                            <h5>Thông tin người nhận</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Họ tên</label>
                                    <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($user['name'] ?? '') ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Số điện thoại</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" value="<?= htmlspecialchars($user['phone'] ?? '') ?>" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Địa chỉ</label>
                                <textarea class="form-control" id="address" name="address" rows="3" required><?= htmlspecialchars($user['address'] ?? '') ?></textarea>
                            </div>
                        </div>

                        <!-- Phương thức thanh toán -->
                        <div class="mb-3">
                            <h5>Phương thức thanh toán</h5>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod" checked>
                                <label class="form-check-label" for="cod">
                                    Thanh toán khi nhận hàng (COD)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="bank" value="bank">
                                <label class="form-check-label" for="bank">
                                    Chuyển khoản ngân hàng
                                </label>
                            </div>
                        </div>

                        <!-- Nút thanh toán -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg" <?= empty($cartItems) ? 'disabled' : '' ?>>
                                Đặt hàng
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tóm tắt đơn hàng -->
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Tóm tắt đơn hàng</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tạm tính:</span>
                        <span><?= number_format($totalPrice, 0, ',', '.') ?> đ</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Phí vận chuyển:</span>
                        <span><?= number_format($shippingFee, 0, ',', '.') ?> đ</span>
                    </div>
                    <?php if (isset($discount) && $discount > 0): ?>
                        <div class="d-flex justify-content-between mb-2 text-success">
                            <span>Giảm giá:</span>
                        <span>-<?= number_format($discount, 0, ',', '.') ?> đ</span>
                    </div>
                    <?php endif; ?>                 <hr>
                    <div class="d-flex justify-content-betw>
                        <strong>Tổng cộng:</strong>
                        <strong><?= number_format($finalTotal, 0, ',', '.') ?> đ</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('checkoutForm').addEventListener('submit', function(e) {
    e.preventDefault();
    if (confirm('Bạn có chắắn muốn đặt hàng?')) {
        // Tạo form ẩn để submit
        const hiddenFormocument.createElement('form');
        hiddenForm.metho'POST';
        hiddenForm.an = '/d/index.php?act=cart&page=process_checkout';

        // Thêm các trường dữ liệu từ form gốc
        const formData = new FormData(this);
        for (let pair of formData.entries()) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = pair[0];
            input.value = pair[1];
            hiddenForm.appendChild(input);
        }

        // Thêm trường process_checkout
        const processCheckout = document.createElement('input');
        processCheckout.type = 'hidden';
        processCheckout.name = 'process_checkout';
        processCheckout.value = '1';
        hiddenForm.appendChild(processCheckout);

        // Submit form
        document.body.appendChild(hiddenForm);
        hiddenForm.submit();
    }
});
</script>