<?php
$title = "Chi tiết đơn hàng #" . $order['order_detail_id'];
require_once "layouts/header.php";
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Chi tiết đơn hàng #<?= htmlspecialchars($order['order_detail_id'] ?? 'N/A') ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
                        <li class="breadcrumb-item"><a href="index.php?act=order&page=list">Đơn hàng</a></li>
                        <li class="breadcrumb-item active">Chi tiết đơn hàng</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <?php if (!isset($order) || empty($order)) : ?>
        <section class="content">
            <div class="container-fluid">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Lỗi!</h5>
                    Không tìm thấy thông tin đơn hàng
                </div>
            </div>
        </section>
    <?php else : ?>
        <section class="content">
            <div class="container-fluid">
                <?php if (isset($_SESSION['success'])) : ?>
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fas fa-check"></i> Thành công!</h5>
                        <?= $_SESSION['success'] ?>
                    </div>
                    <?php unset($_SESSION['success']); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['error'])) : ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fas fa-ban"></i> Lỗi!</h5>
                        <?= $_SESSION['error'] ?>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <div class="row">
                    <div class="col-md-6">
                        <!-- Thông tin khách hàng -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-user mr-1"></i>
                                    Thông tin khách hàng
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Tên khách hàng:</label>
                                            <p class="form-control-static"><?= htmlspecialchars($order['name']) ?></p>
                                        </div>
                                        <div class="form-group">
                                            <label>Số điện thoại:</label>
                                            <p class="form-control-static">0<?= htmlspecialchars($order['phone']) ?></p>
                                        </div>
                                        <div class="form-group">
                                            <label>Địa chỉ:</label>
                                            <p class="form-control-static"><?= htmlspecialchars($order['address']) ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <!-- Thông tin đơn hàng -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-shopping-cart mr-1"></i>
                                    Thông tin đơn hàng
                                </h3>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped">
                                    <tr>
                                        <th style="width: 160px">Mã đơn hàng:</th>
                                        <td>#<?= htmlspecialchars($order['order_detail_id'] ?? 'N/A') ?></td>
                                    </tr>
                                    <tr>
                                        <th>Ngày đặt:</th>
                                        <td><?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Trạng thái:</th>
                                        <td>
                                            <?php
                                            switch ($order['status']) {
                                                case 'pending':
                                                    echo '<span class="badge badge-warning">Chờ xử lý</span>';
                                                    break;
                                                case 'confirmed':
                                                    echo '<span class="badge badge-info">Đã xác nhận</span>';
                                                    break;
                                                case 'shipping':
                                                    echo '<span class="badge badge-primary">Đang giao</span>';
                                                    break;
                                                case 'delivered':
                                                    echo '<span class="badge badge-success">Đã giao</span>';
                                                    break;
                                                case 'cancelled':
                                                    echo '<span class="badge badge-danger">Đã hủy</span>';
                                                    break;
                                                default:
                                                    echo '<span class="badge badge-secondary">Không xác định</span>';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Thanh toán:</th>
                                        <td>
                                            <span class="badge badge-<?= $order['payment_status'] == 'paid' ? 'success' : 'warning' ?>">
                                                <?= $order['payment_status'] == 'paid' ? 'Đã thanh toán' : 'Chưa thanh toán' ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Phương thức:</th>
                                        <td><?= $order['payment_method'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Ghi chú:</th>
                                        <td><?= htmlspecialchars($order['note']) ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chi tiết sản phẩm -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-box mr-1"></i>
                            Chi tiết sản phẩm
                        </h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Phiên bản</th>
                                    <th>Giá</th>
                                    <th>Số lượng</th>
                                    <th>Tổng</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($order['items'] as $item) : ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="../upload/<?= htmlspecialchars($item['product_image']) ?>"
                                                    alt="<?= htmlspecialchars($item['product_name'] ?? '') ?>"
                                                    class="img-size-50 mr-3">
                                                <?= htmlspecialchars($item['product_name'] ?? '') ?>
                                            </div>
                                        </td>
                                        <td>
                                            <?= htmlspecialchars($item['color_name'] ?? '') ?> - <?= htmlspecialchars($item['size_name'] ?? '') ?>
                                        </td>
                                        <td><?= number_format($item['price']) ?>đ</td>
                                        <td><?= $item['quantity'] ?></td>
                                        <td><?= number_format($item['price'] * $item['quantity']) ?>đ</td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <td colspan="4" class="text-right"><strong>Tổng tiền:</strong></td>
                                    <td><strong><?= number_format($order['amount']) ?>đ</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Nút thao tác -->
                <div class="row">
                    <div class="col-12 mb-3">
                        <?php if ($order['status'] == 'pending') : ?>
                            <a href="index.php?act=order&page=update_status&id=<?= htmlspecialchars($order['order_detail_id']) ?>&status=confirmed"
                                class="btn btn-info">
                                <i class="fas fa-check"></i> Xác nhận đơn hàng
                            </a>
                        <?php endif; ?>

                        <?php if ($order['status'] == 'confirmed') : ?>
                            <a href="index.php?act=order&page=update_status&id=<?= htmlspecialchars($order['order_detail_id']) ?>&status=shipping"
                                class="btn btn-primary">
                                <i class="fas fa-truck"></i> Bắt đầu giao hàng
                            </a>
                        <?php endif; ?>

                        <?php if ($order['status'] == 'shipping') : ?>
                            <a href="index.php?act=order&page=update_status&id=<?= htmlspecialchars($order['order_detail_id']) ?>&status=delivered"
                                class="btn btn-success">
                                <i class="fas fa-check-circle"></i> Xác nhận đã giao
                            </a>
                        <?php endif; ?>

                        <?php if ($order['status'] != 'cancelled' && $order['status'] != 'delivered') : ?>
                            <a href="index.php?act=order&page=update_status&id=<?= htmlspecialchars($order['order_detail_id']) ?>&status=cancelled"
                                class="btn btn-danger"
                                onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này?')">
                                <i class="fas fa-times"></i> Hủy đơn hàng
                            </a>
                        <?php endif; ?>

                        <a href="index.php?act=order&page=list" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>
</div>

<?php require_once "layouts/footer.php"; ?>