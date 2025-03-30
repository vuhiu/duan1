<h2 class="mt-3">Danh sách mã giảm giá</h2>

<?php if (!empty($coupons)): ?>
<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Tên</th>
            <th>Loại</th>
            <th>Mã</th>
            <th>Ngày bắt đầu</th>
            <th>Ngày kết thúc</th>
            <th>Số lượng</th>
            <th>Trạng thái</th>
            <th>Giá trị</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($coupons as $coupon): ?>
        <tr>
            <td><?= $coupon['coupon_id'] ?></td>
            <td><?= $coupon['name'] ?></td>
            <td><?= $coupon['coupon_type'] ?></td>
            <td><?= $coupon['coupon_code'] ?></td>
            <td><?= $coupon['start_date'] ?></td>
            <td><?= $coupon['end_date'] ?></td>
            <td><?= $coupon['quantity'] ?></td>
            <td><?= $coupon['status'] === 'active' ? 'Hoạt động' : 'Ẩn' ?></td>
            <td><?= $coupon['coupon_value'] ?></td>
            <td>
                <a href="?act=coupon&page=edit&coupon_id=<?= $coupon['coupon_id'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                <a href="?act=coupon&page=delete&coupon_id=<?= $coupon['coupon_id'] ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa?')" class="btn btn-danger btn-sm">Xóa</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?>
<p>Không có mã giảm giá nào.</p>
<?php endif; ?>