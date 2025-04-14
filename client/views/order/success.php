<?php
$ROOT_URL = "/duan1";
$CONTENT_URL = "$ROOT_URL/content";
$ADMIN_URL = "$ROOT_URL/admin";
$CLIENT_URL = "$ROOT_URL/client";

// Lấy thông tin đơn hàng từ session
$orderInfo = $_SESSION['last_order'] ?? null;
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt hàng thành công</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-success">
                    <div class="card-body text-center">
                        <div class="mb-4">
                            <i class="fas fa-check-circle text-success" style="font-size: 64px;"></i>
                        </div>
                        <h2 class="card-title text-success mb-4">Đặt hàng thành công!</h2>
                        <?php if ($orderInfo): ?>
                            <div class="text-start mb-4">
                                <h4>Thông tin đơn hàng #<?= $orderInfo['order_id'] ?></h4>
                                <p><strong>Ngày đặt:</strong> <?= date('d/m/Y H:i', strtotime($orderInfo['order_date'])) ?></p>
                                <p><strong>Tổng tiền:</strong> <?= number_format($orderInfo['total_amount'], 0, ',', '.') ?> đ</p>
                                <p><strong>Phương thức thanh toán:</strong> <?= $orderInfo['payment_method'] ?></p>
                            </div>
                        <?php endif; ?>
                        <div class="alert alert-info">
                            Chúng tôi sẽ sớm liên hệ với bạn để xác nhận đơn hàng.
                            Vui lòng kiểm tra email để biết thêm chi tiết.
                        </div>
                        <div class="mt-4">
                            <a href="/duan1/index.php?act=order&page=detail&id=<?= $orderInfo['order_id'] ?>"
                                class="btn btn-primary me-2">Xem chi tiết đơn hàng</a>
                            <a href="/duan1/index.php" class="btn btn-secondary">Tiếp tục mua sắm</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/your-code.js" crossorigin="anonymous"></script>
</body>

</html>