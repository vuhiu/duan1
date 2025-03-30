<h2 class="mt-3">Trạng thái đơn hàng</h2>

<?php if (!empty($orderStatus)): ?>
<table class="table table-bordered">
    <tr>
        <th>Trạng thái đơn hàng</th>
        <td><?= $orderStatus['status'] ?></td>
    </tr>
    <tr>
        <th>Trạng thái thanh toán</th>
        <td><?= $orderStatus['payment_status'] ?></td>
    </tr>
    <tr>
        <th>Phương thức thanh toán</th>
        <td><?= $orderStatus['payment_method'] ?></td>
    </tr>
</table>
<a href="?act=order&page=history" class="btn btn-primary">Quay lại lịch sử đơn hàng</a>
<?php else: ?>
<p>Không tìm thấy trạng thái đơn hàng.</p>
<?php endif; ?>