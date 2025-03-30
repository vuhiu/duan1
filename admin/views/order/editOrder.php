<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chỉnh sửa đơn hàng</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h1>Chỉnh sửa đơn hàng</h1>
        <form method="POST" action="?act=order&page=update">
            <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">

            <label for="status">Trạng thái đơn hàng:</label>
            <select id="status" name="status" class="form-select" required>
                <option value="pending" <?= $order['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                <option value="confirmed" <?= $order['status'] == 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
                <option value="shipping" <?= $order['status'] == 'shipping' ? 'selected' : '' ?>>Shipping</option>
                <option value="delivered" <?= $order['status'] == 'delivered' ? 'selected' : '' ?>>Delivered</option>
            </select>

            <label for="payment_status">Trạng thái thanh toán:</label>
            <select id="payment_status" name="payment_status" class="form-select" required>
                <option value="unpaid" <?= $order['payment_status'] == 'unpaid' ? 'selected' : '' ?>>Unpaid</option>
                <option value="paid" <?= $order['payment_status'] == 'paid' ? 'selected' : '' ?>>Paid</option>
            </select>

            <button type="submit" class="btn btn-primary mt-3">Cập nhật</button>
        </form>
    </div>
</body>
</html>