<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm vào giỏ hàng</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h1>Thêm vào giỏ hàng</h1>
        <form method="POST" action="?act=cart&page=add">
            <div class="mb-3">
                <label for="user_id" class="form-label">ID Người dùng:</label>
                <input type="number" id="user_id" name="user_id" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="product_id" class="form-label">ID Sản phẩm:</label>
                <input type="number" id="product_id" name="product_id" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Số lượng:</label>
                <input type="number" id="quantity" name="quantity" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Thêm</button>
        </form>
    </div>
</body>
</html>