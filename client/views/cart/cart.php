<!-- filepath: c:\xampp\htdocs\duan1\client\views\cart.php -->
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Giỏ hàng</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1>Giỏ hàng</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tên sản phẩm</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($cartItems) && is_array($cartItems)): ?>
                <?php foreach ($cartItems as $item): ?>
                <div class="cart-item">
                    <p>Sản phẩm: <?= htmlspecialchars($item['product_name']) ?></p>
                    <p>Số lượng: <?= htmlspecialchars($item['quantity']) ?></p>
                    <p>Giá: <?= number_format($item['price'], 0, ',', '.') ?> đ</p>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <p>Giỏ hàng của bạn đang trống.</p>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>

</html>