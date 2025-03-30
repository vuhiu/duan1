<!-- filepath: c:\laragon\www\duan1\admin\views\coupon\editCoupon.php -->
<h2 class="mt-3">Chỉnh sửa mã giảm giá</h2>

<form method="POST" action="?act=coupon&page=update">
    <input type="hidden" name="coupon_id" value="<?= $coupon['coupon_id'] ?>">

    <div class="mb-3">
        <label for="name" class="form-label">Tên mã giảm giá</label>
        <input type="text" class="form-control" id="name" name="name" value="<?= $coupon['name'] ?>" required>
    </div>

    <div class="mb-3">
        <label for="coupon_type" class="form-label">Loại</label>
        <select class="form-select" id="coupon_type" name="coupon_type" required>
            <option value="percentage" <?= $coupon['coupon_type'] == 'percentage' ? 'selected' : '' ?>>Phần trăm</option>
            <option value="fixed amount" <?= $coupon['coupon_type'] == 'fixed amount' ? 'selected' : '' ?>>Số tiền cố định</option>
            <option value="free shipping" <?= $coupon['coupon_type'] == 'free shipping' ? 'selected' : '' ?>>Miễn phí vận chuyển</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="coupon_code" class="form-label">Mã</label>
        <input type="text" class="form-control" id="coupon_code" name="coupon_code" value="<?= $coupon['coupon_code'] ?>" required>
    </div>

    <div class="mb-3">
        <label for="start_date" class="form-label">Ngày bắt đầu</label>
        <input type="date" class="form-control" id="start_date" name="start_date" value="<?= $coupon['start_date'] ?>" required>
    </div>

    <div class="mb-3">
        <label for="end_date" class="form-label">Ngày kết thúc</label>
        <input type="date" class="form-control" id="end_date" name="end_date" value="<?= $coupon['end_date'] ?>" required>
    </div>

    <div class="mb-3">
        <label for="quantity" class="form-label">Số lượng</label>
        <input type="number" class="form-control" id="quantity" name="quantity" value="<?= $coupon['quantity'] ?>" required>
    </div>

    <div class="mb-3">
        <label for="status" class="form-label">Trạng thái</label>
        <select class="form-select" id="status" name="status" required>
            <option value="active" <?= $coupon['status'] == 'active' ? 'selected' : '' ?>>Hoạt động</option>
            <option value="hidden" <?= $coupon['status'] == 'hidden' ? 'selected' : '' ?>>Ẩn</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="coupon_value" class="form-label">Giá trị</label>
        <input type="number" class="form-control" id="coupon_value" name="coupon_value" value="<?= $coupon['coupon_value'] ?>" required>
    </div>

    <button type="submit" class="btn btn-primary">Cập nhật</button>
</form>