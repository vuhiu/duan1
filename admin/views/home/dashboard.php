<?php
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Bảng điều khiển</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Thống kê đơn hàng -->
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3><?php echo isset($totalOrders) ? $totalOrders : 0; ?></h3>
                                    <p>Đơn hàng mới</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <a href="?act=order&page=list" class="small-box-footer">
                                    Chi tiết <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Thống kê sản phẩm -->
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3><?php echo isset($totalProducts) ? $totalProducts : 0; ?></h3>
                                    <p>Sản phẩm</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-box"></i>
                                </div>
                                <a href="?act=sanpham&page=list" class="small-box-footer">
                                    Chi tiết <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Thống kê khách hàng -->
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3><?php echo isset($totalCustomers) ? $totalCustomers : 0; ?></h3>
                                    <p>Khách hàng</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <a href="?act=customer&page=list" class="small-box-footer">
                                    Chi tiết <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Thống kê doanh thu -->
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3><?php echo isset($totalRevenue) ? number_format($totalRevenue, 0, ',', '.') : 0; ?>đ</h3>
                                    <p>Doanh thu</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <a href="?act=order&page=list" class="small-box-footer">
                                    Chi tiết <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Đơn hàng gần đây -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Đơn hàng gần đây</h3>
                                </div>
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-hover text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Khách hàng</th>
                                                <th>Tổng tiền</th>
                                                <th>Trạng thái</th>
                                                <th>Ngày đặt</th>
                                                <th>Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (isset($recentOrders) && !empty($recentOrders)): ?>
                                                <?php foreach ($recentOrders as $order): ?>
                                                    <tr>
                                                        <td>#<?php echo $order['order_detail_id']; ?></td>
                                                        <td><?php echo htmlspecialchars($order['name'] ?? ''); ?></td>
                                                        <td><?php echo number_format($order['amount'], 0, ',', '.'); ?>đ</td>
                                                        <td>
                                                            <span class="badge <?php
                                                                                switch ($order['status']) {
                                                                                    case 'pending':
                                                                                        echo 'bg-warning';
                                                                                        break;
                                                                                    case 'confirmed':
                                                                                        echo 'bg-info';
                                                                                        break;
                                                                                    case 'shipping':
                                                                                        echo 'bg-primary';
                                                                                        break;
                                                                                    case 'delivered':
                                                                                        echo 'bg-success';
                                                                                        break;
                                                                                    case 'cancelled':
                                                                                        echo 'bg-danger';
                                                                                        break;
                                                                                    default:
                                                                                        echo 'bg-secondary';
                                                                                }
                                                                                ?>">
                                                                <?php echo htmlspecialchars($order['status'] ?? 'Không xác định'); ?>
                                                            </span>
                                                        </td>
                                                        <td><?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></td>
                                                        <td>
                                                            <a href="?act=order&page=detail&id=<?php echo $order['order_detail_id']; ?>"
                                                                class="btn btn-info btn-sm">
                                                                <i class="fas fa-eye"></i> Xem chi tiết
                                                            </a>
                                                            <?php if ($order['status'] === 'pending'): ?>
                                                                <a href="?act=order&page=edit&id=<?php echo $order['order_detail_id']; ?>"
                                                                    class="btn btn-warning btn-sm">
                                                                    <i class="fas fa-edit"></i> Sửa
                                                                </a>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
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
            </div>
        </div>
    </div>
</div>