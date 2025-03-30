<h2 class="mt-3">Tạo mã giảm giá</h2>
<form method="POST" action="?act=coupon&page=add">
    <div class="mb-3">
        <label for="name" class="form-label">Tên mã giảm giá</label>
        <input type="text" class="form-control" id="name" name="name" required>
    </div>
    <div class="mb-3">
        <label for="coupon_type" class="form-label">Loại</label>
        <select class="form-select" id="coupon_type" name="coupon_type" required>
            <option value="percentage">Phần trăm</option>
            <option value="fixed amount">Số tiền cố định</option>
            <option value="free shipping">Miễn phí vận chuyển</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="coupon_code" class="form-label">Mã</label>
        <input type="text" class="form-control" id="coupon_code" name="coupon_code" required>
    </div>
    <div class="mb-3">
        <label for="start_date" class="form-label">Ngày bắt đầu</label>
        <input type="date" class="form-control" id="start_date" name="start_date" required>
    </div>
    <div class="mb-3">
        <label for="end_date" class="form-label">Ngày kết thúc</label>
        <input type="date" class="form-control" id="end_date" name="end_date" required>
    </div>
    <div class="mb-3">
        <label for="quantity" class="form-label">Số lượng</label>
        <input type="number" class="form-control" id="quantity" name="quantity" required>
    </div>
    <div class="mb-3">
        <label for="status" class="form-label">Trạng thái</label>
        <select class="form-select" id="status" name="status" required>
            <option value="active">Hoạt động</option>
            <option value="hidden">Ẩn</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="coupon_value" class="form-label">Giá trị</label>
        <input type="number" class="form-control" id="coupon_value" name="coupon_value" required>
    </div>
    <button type="submit" class="btn btn-primary">Tạo</button>
</form>