<h2 class="mt-3">Lịch sử đơn hàng</h2>

<?php if (!empty($orders)): ?>
<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Sản phẩm</th>
            <th>Số lượng</th>
            <th>Trạng thái</th>
            <th>Thanh toán</th>
            <th>Ngày đặt hàng</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($orders as $order): ?>
        <tr>
            <td><?= $order['order_id'] ?></td>
            <td><?= $order['product_id'] ?></td>
            <td><?= $order['quantity'] ?></td>
            <td><?= $order['status'] ?></td>
            <td><?= $order['payment_status'] ?></td>
            <td><?= $order['created_at'] ?></td>
            <td>
                <a href="?act=order&page=status&order_id=<?= $order['order_id'] ?>" class="btn btn-info btn-sm">Xem trạng thái</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?>
<p>Không có đơn hàng nào.</p>
<?php endif; ?>