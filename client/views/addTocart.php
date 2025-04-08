<!-- filepath: c:\xampp\htdocs\duan1\client\views\addToCart.php -->
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm sản phẩm vào giỏ hàng</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Thêm sản phẩm vào giỏ hàng</h1>
        <form method="POST" action="/duan1/index.php?act=cart&page=add">
            <input type="hidden" name="user_id" value="1"> <!-- Replace with dynamic user_id -->
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