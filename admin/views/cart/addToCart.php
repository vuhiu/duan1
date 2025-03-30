<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm sản phẩm vào giỏ hàng</title>
</head>
<body>
    <div class="container mt-5">
        <h1>Thêm sản phẩm vào giỏ hàng</h1>
        <form method="POST" action="/duan1/admin/index.php?act=cart&page=add">
            <div class="mb-3">
                <label for="product_id" class="form-label">ID Sản phẩm:</label>
                <input type="number" id="product_id" name="product_id" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="variant_id" class="form-label">ID Biến thể:</label>
                <input type="number" id="variant_id" name="variant_id" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Số lượng:</label>
                <input type="number" id="quantity" name="quantity" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Thêm vào giỏ hàng</button>
        </form>
    </div>
</body>
</html>