<?php
require_once __DIR__ . '/../../../commons/helper.php';

if (!isset($order) || !isset($orderItems)) {
    redirect('index.php');
}

$title = "Chi tiết đơn hàng #" . $order['order_id'];
require_once __DIR__ . '/../layout/header.php';
?>

<<<<<<< HEAD
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
=======
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
>>>>>>> 426fad3974964d4c2adffc4060d861697f252430
        </div>
    </div>
</div>

<<<<<<< HEAD
<?php require_once __DIR__ . '/../layout/footer.php'; ?>
=======
<script>
    function confirmCancel(orderId) {
        if (confirm('Bạn có chắc chắn muốn hủy đơn hàng này?')) {
            window.location.href = `?act=order&page=cancel&id=${orderId}`;
        }
    }
</script>
>>>>>>> 426fad3974964d4c2adffc4060d861697f252430

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