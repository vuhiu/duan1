<?php
$pageTitle = "Thống kê";
$currentDate = date('d/m/Y');
$thirtyDaysAgo = date('d/m/Y', strtotime('-30 days'));
?>

<div class="container-fluid">
    <!-- Tổng quan -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">TỔNG QUAN BÁO CÁO</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Thời gian -->
                        <div class="col-12 mb-4">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-calendar-alt me-2"></i>
                                <select class="form-select" style="width: auto;">
                                    <option>30 ngày qua (<?= $thirtyDaysAgo ?> - <?= $currentDate ?>)</option>
                                </select>
                            </div>
                        </div>

                        <!-- Thống kê -->
                        <div class="row">
                            <!-- Tổng doanh thu -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-primary shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Tổng doanh thu</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    <?= number_format($totalRevenue, 0, ',', '.') ?> đ
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tổng đơn hàng -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                    Tổng đơn hàng</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    <?= number_format($totalOrders, 0, ',', '.') ?>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tổng sản phẩm -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-info shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                    Tổng sản phẩm
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    <?= number_format($totalProducts, 0, ',', '.') ?>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tổng khách hàng -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-warning shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                    Tổng khách hàng</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    <?= number_format($totalCustomers, 0, ',', '.') ?>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-users fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Biểu đồ và Top sản phẩm -->
                        <div class="row mt-4">
                            <div class="col-md-8">
                                <div class="card border">
                                    <div class="card-body">
                                        <h6 class="card-subtitle mb-2 text-muted d-flex align-items-center">
                                            Biểu đồ doanh thu
                                            <i class="fas fa-info-circle ms-2" data-bs-toggle="tooltip" title="Biểu đồ doanh thu theo thời gian"></i>
                                        </h6>
                                        <canvas id="revenueChart" height="200"></canvas>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card border">
                                    <div class="card-body">
                                        <h6 class="card-subtitle mb-2 text-muted d-flex align-items-center">
                                            Top sản phẩm bán chạy
                                            <i class="fas fa-info-circle ms-2" data-bs-toggle="tooltip" title="Sản phẩm bán chạy nhất"></i>
                                        </h6>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Sản phẩm</th>
                                                        <th>Số đơn</th>
                                                        <th>Doanh số</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($topProducts as $product): ?>
                                                    <tr>
                                                        <td><?= htmlspecialchars($product['name']) ?></td>
                                                        <td><?= number_format($product['order_count']) ?></td>
                                                        <td><?= number_format($product['revenue'], 0, ',', '.') ?>đ</td>
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
                </div>
            </div>
        </div>
    </div>

    <!-- Đơn hàng gần đây -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Đơn hàng gần đây</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Mã đơn</th>
                            <th>Khách hàng</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Ngày đặt</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentOrders as $order): ?>
                        <tr>
                            <td>#<?= $order['order_detail_id'] ?></td>
                            <td><?= htmlspecialchars($order['customer_name']) ?></td>
                            <td><?= number_format($order['amount'], 0, ',', '.') ?> đ</td>
                            <td>
                                <span class="badge badge-<?= $this->getStatusColor($order['status']) ?>">
                                    <?= $this->getStatusText($order['status']) ?>
                                </span>
                            </td>
                            <td><?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Khởi tạo biểu đồ doanh thu
const revenueChart = new Chart(document.getElementById('revenueChart'), {
    type: 'line',
    data: {
        labels: <?= json_encode($chartLabels) ?>,
        datasets: [{
            label: 'Doanh thu',
            data: <?= json_encode($revenueData) ?>,
            borderColor: '#0d6efd',
            tension: 0.1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return value.toLocaleString('vi-VN') + ' đ';
                    }
                }
            }
        }
    }
});

// Khởi tạo tooltips
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
});
</script>

<style>
.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}
.card-subtitle {
    font-size: 0.875rem;
}
.table td {
    vertical-align: middle;
}
.fas.fa-info-circle {
    color: #6c757d;
    cursor: help;
}
</style> 