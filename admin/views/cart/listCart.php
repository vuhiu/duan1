<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Giỏ hàng</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h1>Giỏ hàng</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cartItems as $item): ?>
                <tr>
                    <td><?= $item['cart_id'] ?></td>
                    <td><?= $item['product_id'] ?></td>
                    <td><?= $item['quantity'] ?></td>
                    <td>
                        <form method="POST" action="?act=cart&page=update" class="d-inline">
                            <input type="hidden" name="cart_id" value="<?= $item['cart_id'] ?>">
                            <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1" class="form-control d-inline w-50">
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                        </form>
                        <a href="?act=cart&page=delete&cart_id=<?= $item['cart_id'] ?>" class="btn btn-danger">Xóa</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>