<?php
require_once __DIR__ . '/../../../commons/helper.php';

if (!isset($order) || empty($order)) {
    redirect('index.php');
}

$title = "Chi tiết đơn hàng #" . $order[0]['order_detail_id'];
require_once __DIR__ . '/../layout/header.php';
?>

<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3">Chi tiết đơn hàng #<?= $order[0]['order_detail_id'] ?></h1>
                <a href="/duan1/index.php?act=order&page=list" class="btn btn-outline-secondary">
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
                                    <th style="width: 35%">Mã đơn:</th>
                                    <td>#<?= $order[0]['order_detail_id'] ?></td>
                                </tr>
                                <tr>
                                    <th>Ngày đặt:</th>
                                    <td><?= date('d/m/Y H:i', strtotime($order[0]['created_at'])) ?></td>
                                </tr>
                                <tr>
                                    <th>Trạng thái:</th>
                                    <td>
                                        <?php
                                        $statusClass = '';
                                        $statusText = '';
                                        $status = isset($order[0]['status']) ? strtolower(trim($order[0]['status'])) : '';

                                        switch ($status) {
                                            case 'pending':
                                                $statusClass = 'bg-warning';
                                                $statusText = 'Chờ xử lý';
                                                break;
                                            case 'confirmed':
                                                $statusClass = 'bg-info';
                                                $statusText = 'Đã xác nhận';
                                                break;
                                            case 'shipping':
                                                $statusClass = 'bg-primary';
                                                $statusText = 'Đang giao hàng';
                                                break;
                                            case 'delivered':
                                                $statusClass = 'bg-success';
                                                $statusText = 'Đã giao hàng';
                                                break;
                                            case 'cancelled':
                                                $statusClass = 'bg-secondary';
                                                $statusText = 'Đơn đã bị hủy';
                                                break;
                                            default:
                                                $statusClass = 'bg-secondary';
                                                $statusText = 'Đơn đã bị hủy';
                                                break;
                                        }
                                        ?>
                                        <span class="badge <?= $statusClass ?>"><?= $statusText ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Thanh toán:</th>
                                    <td>
                                        <span class="badge <?= $order[0]['payment_status'] == 'paid' ? 'bg-success' : 'bg-warning' ?>">
                                            <?= $order[0]['payment_status'] == 'paid' ? 'Đã thanh toán' : 'Chưa thanh toán' ?>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Phương thức:</th>
                                    <td><?= $order[0]['payment_method'] == 'cod' ? 'Thanh toán khi nhận hàng' : 'Chuyển khoản' ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5 class="card-title">Thông tin giao hàng</h5>
                            <table class="table">
                                <tr>
                                    <th style="width: 35%">Họ tên:</th>
                                    <td><?= htmlspecialchars($order[0]['name']) ?></td>
                                </tr>
                                <tr>
                                    <th>Điện thoại:</th>
                                    <td>0<?= htmlspecialchars($order[0]['phone']) ?></td>
                                </tr>
                                <tr>
                                    <th>Địa chỉ:</th>
                                    <td><?= htmlspecialchars($order[0]['address']) ?></td>
                                </tr>
                                <tr>
                                    <th>Ghi chú:</th>
                                    <td><?= htmlspecialchars($order[0]['note'] ?: 'Không có') ?></td>
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
                                    <th class="text-end">Đơn giá</th>
                                    <th class="text-center">Số lượng</th>
                                    <th class="text-end">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($order as $item): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="/duan1/upload/<?= $item['product_image'] ?>"
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
                                        <td class="text-end"><?= number_format($item['sale_price'] > 0 ? $item['sale_price'] : $item['price'], 0, ',', '.') ?>đ</td>
                                        <td class="text-center"><?= $item['quantity'] ?></td>
                                        <td class="text-end"><?= number_format(($item['sale_price'] > 0 ? $item['sale_price'] : $item['price']) * $item['quantity'], 0, ',', '.') ?>đ</td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="text-end fw-bold">Tổng tiền:</td>
                                    <td class="text-end fw-bold"><?= number_format($order[0]['amount'], 0, ',', '.') ?>đ</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div class="text-end mt-4">
                <a href="/duan1/index.php?act=order&page=list" class="btn btn-primary me-2">
                    <i class="fas fa-list"></i> Xem danh sách đơn hàng
                </a>
                <?php if ($order[0]['status'] !== 'cancelled' && $order[0]['status'] !== 'Đã hủy'): ?>
                    <form action="/duan1/index.php?act=order&page=cancel" method="POST" style="display: inline;">
                        <input type="hidden" name="order_id" value="<?= $order[0]['order_detail_id'] ?>">
                        <button type="submit" class="btn btn-danger"
                            onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này không?');">
                            <i class="fas fa-times"></i> Hủy đơn hàng
                        </button>
                    </form>
                <?php endif; ?>
            </div>


        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>