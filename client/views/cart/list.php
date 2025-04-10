<!-- filepath: c:\xampp\htdocs\duan1\client\views\cart.php -->
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Giỏ hàng</title>
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"> -->
    <link type="text/css" rel="stylesheet" href="/duan1/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/duan1/client/public/css/style.css">
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
                <?php foreach ($cartItems as $index => $item): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= htmlspecialchars($item['product_name']) ?></td>
                    <td><?= number_format($item['price'], 0, ',', '.') ?> đ</td>
                    <td>
                        <form action="/duan1/index.php?act=cart&page=update_cart" method="POST"
                            style="display: inline;">
                            <input type="hidden" name="cart_item_id" value="<?= $item['cart_item_id'] ?>">
                            <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1"
                                style="width: 60px;">
                            <button type="submit" class="btn btn-sm btn-primary">Cập nhật</button>
                        </form>
                    </td>
                    <td><?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?> đ</td>
                    <td>
                        <a href="/duan1/index.php?act=cart&page=delete_cart&cart_item_id=<?= $item['cart_item_id'] ?>"
                            class="btn btn-sm btn-danger"
                            onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">Xóa</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">Giỏ hàng của bạn đang trống.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>

</html>