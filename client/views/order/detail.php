<?php
$ROOT_URL = "/duan1";
$CONTENT_URL = "$ROOT_URL/content";
$ADMIN_URL = "$ROOT_URL/admin";
$CLIENT_URL = "$ROOT_URL/client";

if (!isset($order) || !isset($orderItems)) {
    die("Không tìm thấy thông tin đơn hàng.");
}

$title = "Chi tiết đơn hàng #" . $order['order_id'];
require_once __DIR__ . '/../layout/header.php';
?>

<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Chi tiết đơn hàng #<?= $order['order_id'] ?></h1>
                <a href="/orders" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success"><?= $_SESSION['success'] ?></div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="card-title">Thông tin đơn hàng</h5>
                            <table class="table">
                                <tr>
                                    <th>Mã đơn:</th>
                                    <td>#<?= $order['order_id'] ?></td>
                                </tr>
                                <tr>
                                    <th>Ngày đặt:</th>
                                    <td><?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></td>
                                </tr>
                                <tr>
                                    <th>Trạng thái:</th>
                                    <td>
                                        <span class="badge bg-<?= $this->getStatusColor($order['status']) ?>">
                                            <?= $this->getStatusText($order['status']) ?>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tổng tiền:</th>
                                    <td class="fw-bold"><?= number_format($order['total_amount'], 0, ',', '.') ?>đ</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5 class="card-title">Thông tin giao hàng</h5>
                            <table class="table">
                                <tr>
                                    <th>Họ tên:</th>
                                    <td><?= htmlspecialchars($order['shipping_name']) ?></td>
                                </tr>
                                <tr>
                                    <th>Điện thoại:</th>
                                    <td><?= htmlspecialchars($order['shipping_phone']) ?></td>
                                </tr>
                                <tr>
                                    <th>Địa chỉ:</th>
                                    <td><?= htmlspecialchars($order['shipping_address']) ?></td>
                                </tr>
                                <tr>
                                    <th>Ghi chú:</th>
                                    <td><?= htmlspecialchars($order['note'] ?? 'Không có ghi chú') ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Chi tiết sản phẩm</h5>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Màu sắc</th>
                                    <th>Kích thước</th>
                                    <th>Đơn giá</th>
                                    <th>Số lượng</th>
                                    <th>Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($order['items'] as $item): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="/upload/<?= $item['image'] ?>" 
                                                     alt="<?= htmlspecialchars($item['product_name']) ?>" 
                                                     class="img-thumbnail me-2" 
                                                     style="width: 50px; height: 50px; object-fit: cover;">
                                                <div>
                                                    <?= htmlspecialchars($item['product_name']) ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?= htmlspecialchars($item['color_name']) ?></td>
                                        <td><?= htmlspecialchars($item['size_name']) ?></td>
                                        <td><?= number_format($item['price'], 0, ',', '.') ?>đ</td>
                                        <td><?= $item['quantity'] ?></td>
                                        <td><?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?>đ</td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="text-end fw-bold">Tổng tiền:</td>
                                    <td class="fw-bold"><?= number_format($order['total_amount'], 0, ',', '.') ?>đ</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <?php if ($order['status'] == 'pending'): ?>
                <div class="text-end mt-4">
                    <button type="button" 
                            class="btn btn-danger" 
                            data-bs-toggle="modal" 
                            data-bs-target="#cancelModal">
                        <i class="fas fa-times"></i> Hủy đơn hàng
                    </button>
                </div>

                <!-- Modal xác nhận hủy đơn -->
                <div class="modal fade" id="cancelModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Xác nhận hủy đơn hàng</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <p>Bạn có chắc chắn muốn hủy đơn hàng #<?= $order['order_id'] ?>?</p>
                            </div>
                            <div class="modal-footer">
                                <form method="POST" action="/orders/cancel">
                                    <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                    <button type="submit" class="btn btn-danger">Xác nhận hủy</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>

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