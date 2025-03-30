<h2 class="mt-3">Danh sách đơn hàng</h2>

<?php if (!empty($orders)): ?>
<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Người dùng</th>
            <th>Sản phẩm</th>
            <th>Số lượng</th>
            <th>Trạng thái</th>
            <th>Thanh toán</th>
            <th>Phương thức</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($orders as $order): ?>
            <tr>
            <td><?= $order['order_id'] ?></td>
            <td><?= $order['user_id'] ?></td>
            <td><?= $order['product_id'] ?></td>
            <td><?= $order['quantity'] ?></td>
            <td><?= $order['status'] ?></td>
            <td><?= $order['payment_status'] ?></td>
            <td><?= $order['payment_method'] ?></td>
            <td>
                <a href="?act=order&page=edit&order_id=<?= $order['order_id'] ?>" class="btn btn-warning btn-sm">Sửa</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?>
<p>Không có đơn hàng nào.</p>
<?php endif; ?>