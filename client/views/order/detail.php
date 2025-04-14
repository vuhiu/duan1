<?php
$ROOT_URL = "/duan1";
$CONTENT_URL = "$ROOT_URL/content";
$ADMIN_URL = "$ROOT_URL/admin";
$CLIENT_URL = "$ROOT_URL/client";

if (!isset($order) || !isset($orderItems)) {
    die("Không tìm thấy thông tin đơn hàng.");
}
?>

<div class="container py-4">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/duan1/index.php">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="/duan1/index.php?act=order&page=list">Đơn hàng của tôi</a></li>
            <li class="breadcrumb-item active" aria-current="page">Chi tiết đơn hàng #<?= $order['order_id'] ?></li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Chi tiết đơn hàng #<?= $order['order_id'] ?></h4>
                    <div>
                        <a href="/duan1/index.php?act=order&page=list" class="btn btn-secondary me-2">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                        <?php if ($order['status'] === 'completed'): ?>
                            <a href="/duan1/index.php" class="btn btn-primary">
                                <i class="fas fa-shopping-cart"></i> Mua sắm tiếp
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h5>Thông tin đơn hàng</h5>
                            <p><strong>Ngày đặt:</strong> <?= date('d/m/Y H:i', strtotime($order['order_date'])) ?></p>
                            <p><strong>Phương thức thanh toán:</strong> <?= $order['payment_method'] ?></p>
                            <p><strong>Trạng thái thanh toán:</strong> <?= $order['payment_status'] ?></p>
                        </div>
                        <div class="col-md-6">
                            <h5>Thông tin giao hàng</h5>
                            <p><strong>Người nhận:</strong> <?= htmlspecialchars($order['shipping_name']) ?></p>
                            <p><strong>Số điện thoại:</strong> <?= htmlspecialchars($order['shipping_phone']) ?></p>
                            <p><strong>Địa chỉ:</strong> <?= htmlspecialchars($order['shipping_address']) ?></p>
                        </div>
                    </div>

                    <h5>Sản phẩm</h5>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Màu sắc</th>
                                    <th>Dung lượng</th>
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
                                                <img src="/duan1/upload/<?= htmlspecialchars($item['image']) ?>"
                                                    alt="<?= htmlspecialchars($item['name']) ?>"
                                                    class="img-thumbnail me-2"
                                                    style="width: 50px; height: 50px; object-fit: cover;">
                                                <div>
                                                    <?= htmlspecialchars($item['name']) ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?= htmlspecialchars($item['color_name'] ?? 'N/A') ?></td>
                                        <td><?= htmlspecialchars($item['size_name'] ?? 'N/A') ?></td>
                                        <td><?= $item['quantity'] ?></td>
                                        <td><?= number_format($item['price'], 0, ',', '.') ?> đ</td>
                                        <td><?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?> đ</td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="row justify-content-end">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Tạm tính:</span>
                                        <span><?= number_format($order['subtotal'], 0, ',', '.') ?> đ</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Phí vận chuyển:</span>
                                        <span><?= number_format($order['shipping_fee'], 0, ',', '.') ?> đ</span>
                                    </div>
                                    <?php if ($order['discount'] > 0): ?>
                                        <div class="d-flex justify-content-between mb-2 text-success">
                                            <span>Giảm giá:</span>
                                            <span>-<?= number_format($order['discount'], 0, ',', '.') ?> đ</span>
                                        </div>
                                    <?php endif; ?>
                                    <hr>
                                    <div class="d-flex justify-content-between">
                                        <strong>Tổng cộng:</strong>
                                        <strong><?= number_format($order['total_amount'], 0, ',', '.') ?> đ</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if ($order['status'] === 'pending'): ?>
                        <div class="mt-4">
                            <form action="/duan1/index.php?act=order&page=cancel" method="POST"
                                onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này?');">
                                <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
                                <button type="submit" class="btn btn-danger">Hủy đơn hàng</button>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
function getOrderStatusClass($status)
{
    switch ($status) {
        case 'pending':
            return 'bg-warning';
        case 'processing':
            return 'bg-info';
        case 'shipping':
            return 'bg-primary';
        case 'completed':
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
        case 'processing':
            return 'Đang xử lý';
        case 'shipping':
            return 'Đang giao hàng';
        case 'completed':
            return 'Đã hoàn thành';
        case 'cancelled':
            return 'Đã hủy';
        default:
            return 'Không xác định';
    }
}
?>