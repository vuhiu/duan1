<?php
if (!isset($orders)) {
    die("❌ Lỗi: Không có dữ liệu đơn hàng!");
}
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Quản lý đơn hàng</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Mã đơn hàng</th>
                                    <th>Ngày đặt</th>
                                    <th>Tổng tiền</th>
                                    <th>Trạng thái</th>
                                    <th>Thanh toán</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orders as $order): ?>
                                    <tr>
                                        <td>#<?= htmlspecialchars($order['order_detail_id'] ?? '') ?></td>
                                        <td><?= htmlspecialchars($order['created_at'] ?? '') ?></td>
                                        <td><?= number_format($order['amount'] ?? 0, 0, ',', '.') ?> đ</td>
                                        <td>
                                            <span class="badge <?= ($order['status'] ?? '') === 'pending' ? 'bg-warning' : (($order['status'] ?? '') === 'completed' ? 'bg-success' : (($order['status'] ?? '') === 'cancelled' ? 'bg-danger' : 'bg-info')) ?>">
                                                <?= htmlspecialchars($order['status'] ?? 'Không xác định') ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge <?= ($order['payment_status'] ?? '') === 'paid' ? 'bg-success' : 'bg-warning' ?>">
                                                <?= htmlspecialchars($order['payment_status'] ?? 'Chưa thanh toán') ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="?page=order&act=detail&id=<?= $order['order_detail_id'] ?? '' ?>" class="btn btn-primary btn-sm">
                                                <i class="fas fa-eye"></i> Xem chi tiết
                                            </a>
                                            <?php if (($order['status'] ?? '') === 'pending'): ?>
                                                <a href="?page=order&act=edit&id=<?= $order['order_detail_id'] ?? '' ?>" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i> Sửa
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>