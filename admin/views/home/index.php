<?php
$title = "Trang chủ";
require_once "layouts/header.php";
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Thống kê -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?= $totalOrders ?? 0 ?></h3>
                            <p>Đơn hàng mới</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <a href="index.php?act=order&page=list" class="small-box-footer">
                            Xem chi tiết <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?= $totalProducts ?? 0 ?></h3>
                            <p>Sản phẩm</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-box"></i>
                        </div>
                        <a href="index.php?act=product&page=list" class="small-box-footer">
                            Xem chi tiết <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?= $totalCustomers ?? 0 ?></h3>
                            <p>Khách hàng</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <a href="index.php?act=customer&page=list" class="small-box-footer">
                            Xem chi tiết <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?= number_format($totalRevenue ?? 0) ?>đ</h3>
                            <p>Doanh thu</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <a href="index.php?act=order&page=list" class="small-box-footer">
                            Xem chi tiết <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Đơn hàng gần đây -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Đơn hàng gần đây</h3>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Mã ĐH</th>
                                        <th>Khách hàng</th>
                                        <th>Tổng tiền</th>
                                        <th>Trạng thái</th>
                                        <th>Ngày đặt</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($recentOrders)) : ?>
                                        <?php foreach ($recentOrders as $order) : ?>
                                            <tr>
                                                <td>#<?= $order['order_detail_id'] ?></td>
                                                <td>
                                                    <?= htmlspecialchars($order['name']) ?><br>
                                                    <small class="text-muted"><?= htmlspecialchars($order['email']) ?></small>
                                                </td>
                                                <td><?= number_format($order['amount']) ?>đ</td>
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
                                                        default:
                                                            echo '<span class="badge badge-secondary">Không xác định</span>';
                                                    }
                                                    ?>
                                                </td>
                                                <td><?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></td>
                                                <td>
                                                    <a href="index.php?act=order&page=detail&id=<?= $order['order_detail_id'] ?>" class="btn btn-info btn-sm">
                                                        <i class="fas fa-eye"></i> Xem
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="6" class="text-center">Không có đơn hàng nào</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php require_once "layouts/footer.php"; ?>