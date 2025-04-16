<?php
$title = "Chi tiết đơn hàng #" . $order['order_id'];
require_once __DIR__ . '/../layout/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Chi tiết đơn hàng #<?= $order['order_id'] ?></h3>
                </div>
                <div class="card-body">
                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success"><?= $_SESSION['success'] ?></div>
                        <?php unset($_SESSION['success']); ?>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
                        <?php unset($_SESSION['error']); ?>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-md-6">
                            <h4>Thông tin khách hàng</h4>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Họ tên:</th>
                                    <td><?= htmlspecialchars($order['customer_name']) ?></td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td><?= htmlspecialchars($order['email']) ?></td>
                                </tr>
                                <tr>
                                    <th>Điện thoại:</th>
                                    <td><?= htmlspecialchars($order['phone']) ?></td>
                                </tr>
                                <tr>
                                    <th>Địa chỉ:</th>
                                    <td><?= htmlspecialchars($order['address']) ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h4>Thông tin đơn hàng</h4>
                            <table class="table table-bordered">
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
                                        <form method="POST" action="index.php?act=donhang&action=updateStatus">
                                            <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
                                            <div class="input-group">
                                                <select name="status" class="form-select">
                                                    <option value="pending" <?= $order['status'] == 'pending' ? 'selected' : '' ?>>Chờ xử lý</option>
                                                    <option value="processing" <?= $order['status'] == 'processing' ? 'selected' : '' ?>>Đang xử lý</option>
                                                    <option value="shipped" <?= $order['status'] == 'shipped' ? 'selected' : '' ?>>Đang giao</option>
                                                    <option value="delivered" <?= $order['status'] == 'delivered' ? 'selected' : '' ?>>Đã giao</option>
                                                    <option value="cancelled" <?= $order['status'] == 'cancelled' ? 'selected' : '' ?>>Đã hủy</option>
                                                </select>
                                                <button type="submit" class="btn btn-primary">Cập nhật</button>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tổng tiền:</th>
                                    <td><?= number_format($order['total_amount'], 0, ',', '.') ?>đ</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <h4>Chi tiết sản phẩm</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Sản phẩm</th>
                                    <th>Màu sắc</th>
                                    <th>Kích thước</th>
                                    <th>Đơn giá</th>
                                    <th>Số lượng</th>
                                    <th>Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($order['items'] as $index => $item): ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="/upload/<?= $item['image'] ?>" 
                                                     alt="<?= htmlspecialchars($item['product_name']) ?>" 
                                                     class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                                                <div class="ms-2">
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
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?> 