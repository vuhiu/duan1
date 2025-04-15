<?php
require_once __DIR__ . '/../../../commons/helper.php';

if (!isset($order) || !isset($orderItems)) {
    redirect('index.php');
}
?>

<div class="container py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="?act=order">Đơn hàng của tôi</a></li>
            <li class="breadcrumb-item active">Chi tiết đơn hàng #<?= htmlspecialchars($order['order_detail_id']) ?></li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Chi tiết đơn hàng #<?= htmlspecialchars($order['order_detail_id']) ?></h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6>Thông tin người nhận</h6>
                    <p><strong>Họ tên:</strong> <?= htmlspecialchars($order['name']) ?></p>
                    <p><strong>Số điện thoại:</strong> <?= '0' . htmlspecialchars($order['phone']) ?></p>
                    <p><strong>Địa chỉ:</strong> <?= htmlspecialchars($order['address']) ?></p>
                </div>
                <div class="col-md-6">
                    <h6>Thông tin đơn hàng</h6>
                    <p><strong>Ngày đặt:</strong> <?= htmlspecialchars($order['created_at']) ?></p>
                    <p><strong>Phương thức thanh toán:</strong> <?= htmlspecialchars($order['payment_method']) ?></p>
                    <p><strong>Trạng thái thanh toán:</strong>
                        <span class="badge <?= $order['payment_status'] === 'paid' ? 'bg-success' : 'bg-warning' ?>">
                            <?= htmlspecialchars($order['payment_status']) ?>
                        </span>
                    </p>
                </div>
            </div>

            <div class="table-responsive mt-4">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Màu sắc</th>
                            <th>Kích thước</th>
                            <th>Số lượng</th>
                            <th>Đơn giá</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orderItems as $item): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="/duan1/upload/<?= htmlspecialchars($item['product_image']) ?>"
                                            alt="<?= htmlspecialchars($item['product_name']) ?>"
                                            class="img-thumbnail me-2"
                                            style="width: 50px; height: 50px; object-fit: cover;">
                                        <span><?= htmlspecialchars($item['product_name']) ?></span>
                                    </div>
                                </td>
                                <td><?= htmlspecialchars($item['color_name']) ?></td>
                                <td><?= htmlspecialchars($item['size_name']) ?></td>
                                <td><?= htmlspecialchars($item['quantity']) ?></td>
                                <td><?= number_format($item['sale_price'] > 0 ? $item['sale_price'] : $item['price'], 0, ',', '.') ?> đ</td>
                                <td><?= number_format($item['total_amount'], 0, ',', '.') ?> đ</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5" class="text-end"><strong>Tổng tiền:</strong></td>
                            <td><strong><?= number_format($order['amount'], 0, ',', '.') ?> đ</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="mt-4">
                <a href="?act=order" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại danh sách
                </a>
                <?php if ($order['status'] === 'pending'): ?>
                    <button type="button" class="btn btn-danger" onclick="confirmCancel(<?= $order['order_detail_id'] ?>)">
                        <i class="fas fa-times"></i> Hủy đơn hàng
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmCancel(orderId) {
        if (confirm('Bạn có chắc chắn muốn hủy đơn hàng này?')) {
            window.location.href = `?act=order&page=cancel&id=${orderId}`;
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
            return 'Không xác định';
    }
}
?>