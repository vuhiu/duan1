<?php
$title = "Quản lý đơn hàng";
require_once "layouts/header.php";
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Quản lý đơn hàng</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
                        <li class="breadcrumb-item active">Đơn hàng</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <!-- Thống kê nhanh -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?= isset($totalOrders) ? $totalOrders : 0 ?></h3>
                            <p>Tổng đơn hàng</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?= isset($pendingOrders) ? $pendingOrders : 0 ?></h3>
                            <p>Đơn chờ xử lý</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?= isset($completedOrders) ? $completedOrders : 0 ?></h3>
                            <p>Đơn đã giao</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?= isset($unknownStatusOrders) ? $unknownStatusOrders : 0 ?></h3>
                            <p>Đơn đã bị hủy</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-ban"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-list mr-1"></i>
                        Danh sách đơn hàng
                    </h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 250px;">
                            <input type="text" id="searchInput" class="form-control float-right" placeholder="Tìm kiếm đơn hàng...">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Mã ĐH</th>
                                <th>Khách hàng</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                                <th>Thanh toán</th>
                                <th>Ngày đặt</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($orders)) : ?>
                                <?php foreach ($orders as $order) : ?>
                                    <tr>
                                        <td>#<?= $order['order_detail_id'] ?></td>
                                        <td>
                                            <div>
                                                <strong><?= htmlspecialchars($order['name']) ?></strong><br>
                                                <small class="text-muted">
                                                    SĐT: 0<?= htmlspecialchars($order['phone']) ?><br>
                                                    <?php if (!empty($order['address'])): ?>
                                                        <i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($order['address']) ?>
                                                    <?php endif; ?>
                                                </small>
                                            </div>
                                        </td>
                                        <td class="text-success"><?= number_format($order['amount']) ?>đ</td>
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
                                                    echo '<span class="badge badge-danger">Đơn đã bị hủy</span>';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <span class="badge badge-<?= $order['payment_status'] == 'paid' ? 'success' : 'warning' ?>">
                                                <?= $order['payment_status'] == 'paid' ? 'Đã thanh toán' : 'Chưa thanh toán' ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php
                                            if (!empty($order['created_at'])) {
                                                echo date('d/m/Y H:i', strtotime($order['created_at']));
                                            } else {
                                                echo 'N/A';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <a href="index.php?act=order&page=detail&id=<?= $order['order_detail_id'] ?>" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i> Xem chi tiết
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="7" class="text-center py-3">
                                        Không có đơn hàng nào
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    $(document).ready(function() {
        // Tìm kiếm đơn hàng
        $("#searchInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("table tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>

<?php require_once "layouts/footer.php"; ?>