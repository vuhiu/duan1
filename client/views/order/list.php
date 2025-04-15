<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="section-title">
                <h4 class="title">Đơn hàng của tôi</h4>
                <a href="/duan1/index.php" class="primary-btn">
                    <i class="fas fa-shopping-cart"></i> Tiếp tục mua sắm
                </a>
            </div>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= $_SESSION['success'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= $_SESSION['error'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <?php if (empty($orders)): ?>
                <div class="text-center py-4">
                    <p>Bạn chưa có đơn hàng nào.</p>
                    <a href="/duan1/index.php" class="primary-btn">Mua sắm ngay</a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table">
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
                                <tr data-status="<?= $order['status'] ?? '' ?>">
                                    <td>#<?= $order['order_detail_id'] ?? '?' ?></td>
                                    <td>
                                        <?php if (!empty($order['created_at'])): ?>
                                            <?= date('d/m/Y H:i', strtotime($order['created_at'])) ?>
                                        <?php else: ?>
                                            Chưa cập nhật
                                        <?php endif; ?>
                                    </td>
                                    <td><?= number_format($order['amount'] ?? 0, 0, ',', '.') ?> đ</td>
                                    <td>
                                        <span class="badge <?= getOrderStatusClass($order['status'] ?? '') ?>">
                                            <?= getOrderStatusText($order['status'] ?? '') ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge <?= ($order['payment_status'] ?? '') === 'paid' ? 'bg-success' : 'bg-warning' ?>">
                                            <?= ($order['payment_status'] ?? '') === 'paid' ? 'Đã thanh toán' : 'Chưa thanh toán' ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="/duan1/index.php?act=order&page=detail&id=<?= $order['order_detail_id'] ?>"
                                                class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i> Chi tiết
                                            </a>
                                            <?php if ($order['status'] === 'pending'): ?>
                                                <form action="/duan1/index.php?act=order&page=cancel" method="POST" style="display: inline;">
                                                    <input type="hidden" name="order_id" value="<?= $order['order_detail_id'] ?>">
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này không?');">
                                                        <i class="fas fa-times"></i> Hủy
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                            <?php if ($order['status'] === 'cancelled' || $order['status'] === 'Đã hủy'): ?>
                                                <form action="/duan1/index.php?act=order&page=delete" method="POST" style="display: inline;">
                                                    <input type="hidden" name="order_id" value="<?= $order['order_detail_id'] ?>">
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này không?');">
                                                        <i class="fas fa-trash"></i> Xóa
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                            <!-- Debug: <?php var_dump($order['status']); ?> -->
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    .section-title {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding: 15px 0;
        border-bottom: 1px solid #ddd;
    }

    .section-title .title {
        margin: 0;
        font-size: 20px;
        font-weight: 600;
    }

    .table {
        margin-bottom: 0;
    }

    .table th {
        font-weight: 600;
        background-color: #f8f9fa;
    }

    .badge {
        padding: 6px 12px;
        font-weight: 500;
    }

    .btn-group .btn {
        padding: 6px 12px;
        margin: 0 2px;
        font-size: 13px;
        white-space: nowrap;
    }

    .btn-group .btn i {
        margin-right: 4px;
    }

    .btn-info {
        background-color: #17a2b8;
        border-color: #17a2b8;
        color: #fff !important;
    }

    .btn-info:hover {
        background-color: #138496;
        border-color: #117a8b;
        color: #fff !important;
        opacity: 0.9;
    }

    .btn-danger {
        background-color: #D10024;
        border-color: #D10024;
        color: #fff !important;
    }

    .btn-danger:hover {
        background-color: #ff1a1a;
        border-color: #ff1a1a;
        color: #fff !important;
        opacity: 0.9;
    }

    .primary-btn {
        display: inline-block;
        padding: 8px 20px;
        background-color: #D10024;
        color: #fff;
        border-radius: 0;
        text-decoration: none;
        transition: all 0.3s;
    }

    .primary-btn:hover {
        background-color: #ff1a1a;
        color: #fff;
        text-decoration: none;
    }

    .alert {
        border-radius: 0;
        margin-bottom: 20px;
        padding: 1rem;
        position: relative;
    }

    .alert-success {
        color: #155724;
        background-color: #d4edda;
        border-color: #c3e6cb;
    }

    .alert-danger {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
    }

    .alert .btn-close {
        position: absolute;
        top: 50%;
        right: 1rem;
        transform: translateY(-50%);
        padding: 0.5rem;
    }
</style>

<script>
    function confirmCancel(orderId) {
        if (confirm('Bạn có chắc chắn muốn hủy đơn hàng này không?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/duan1/index.php?act=order&page=cancel';

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'order_id';
            input.value = orderId;

            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        }
    }

    function confirmDelete(orderId) {
        if (confirm('Bạn có chắc chắn muốn xóa đơn hàng này không?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/duan1/index.php?act=order&page=delete';

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'order_id';
            input.value = orderId;

            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        }
    }
</script>

<?php
function getOrderStatusClass($status)
{
    switch ($status) {
        case 'pending':
            return 'bg-warning';
        case 'confirmed':
            return 'bg-info';
        case 'shipping':
            return 'bg-primary';
        case 'delivered':
            return 'bg-success';
        case 'cancelled':
            return 'bg-danger';
        default:
            return 'bg-secondary';
    }
}

function getOrderStatusText($status)
{
    switch ($status) {
        case 'pending':
            return 'Chờ xác nhận';
        case 'confirmed':
            return 'Đã xác nhận';
        case 'shipping':
            return 'Đang giao hàng';
        case 'delivered':
            return 'Đã giao hàng';
        case 'cancelled':
            return 'Đã hủy';
        default:
            return 'Đơn đã bị hủy';
    }
}
?>