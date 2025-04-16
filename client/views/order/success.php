<?php
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['last_order'])) {
    header('Location: /duan1/index.php');
    exit();
}

require_once __DIR__ . '/../../models/orderModel.php';
$orderModel = new OrderModel();
$order = $orderModel->getOrderById($_SESSION['last_order'], $_SESSION['user_id']);

if (!$order) {
    header('Location: /duan1/index.php');
    exit();
}

// Đảm bảo các giá trị tồn tại
$orderId = $order['order_id'] ?? $_SESSION['last_order'];
$createdAt = $order['created_at'] ?? date('Y-m-d H:i:s');
$totalAmount = $order['amount'] ?? 0;
$orderStatus = $order['order_status'] ?? 'pending';
?>

<!-- Link to external CSS -->
<link rel="stylesheet" href="/duan1/client/assets/css/order-success.css">

<!-- SECTION -->
<div class="section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="breadcrumb-wrapper text-center mb-4">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a href="/duan1/index.php">Trang chủ</a></li>
                            <li class="breadcrumb-item"><a href="/duan1/index.php?act=cart&page=list">Giỏ hàng</a></li>
                            <li class="breadcrumb-item active">Đặt hàng thành công</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-md-8 col-lg-6">
                <div class="success-card">
                    <div class="card-body text-center p-5">
                        <div class="success-check mb-4">
                            <i class="fas fa-check-circle text-danger"></i>
                        </div>
                        <h2 class="mb-3">Đặt hàng thành công!</h2>
                        <p class="text-muted mb-4">Cảm ơn bạn đã đặt hàng. Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất.</p>

                        <div class="order-info mb-4">
                            <div class="info-container">
                                <div class="info-item">
                                    <label>Mã đơn hàng:</label>
                                    <span class="fw-bold">#<?= htmlspecialchars((string)$orderId) ?></span>
                                </div>
                                <div class="info-item">
                                    <label>Ngày đặt:</label>
                                    <span><?= date('d/m/Y H:i', strtotime($createdAt)) ?></span>
                                </div>
                                <div class="info-item">
                                    <label>Tổng tiền:</label>
                                    <span class="text-danger fw-bold"><?= number_format((float)$totalAmount, 0, ',', '.') ?> đ</span>
                                </div>
                                <div class="info-item">
                                    <label>Trạng thái:</label>
                                    <span class="badge bg-warning">Chờ xác nhận</span>
                                </div>
                            </div>
                        </div>

                        <div class="action-buttons">
                            <a href="/duan1/index.php?act=order&page=detail&id=<?= htmlspecialchars((string)$orderId) ?>" class="btn-custom primary-custom">
                                <i class="fas fa-eye"></i> Xem chi tiết đơn hàng
                            </a>
                            <a href="/duan1/index.php" class="btn-custom outline-custom">
                                <i class="fas fa-shopping-cart"></i> Tiếp tục mua sắm
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /SECTION -->