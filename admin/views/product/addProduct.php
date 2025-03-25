<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm sản phẩm</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h2>Thêm sản phẩm</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Tên sản phẩm</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Mô tả</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Giá gốc</label>
            <input type="number" name="price" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Giá khuyến mãi</label>
            <input type="number" name="sale_price" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Danh mục sản phẩm</label>
            <select name="category_id" class="form-control" required>
                <?php
                $categories = $conn->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC);
                foreach ($categories as $category) {
                    echo "<option value='{$category['category_id']}'>{$category['name']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Ảnh sản phẩm</label>
            <input type="file" name="image" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Thêm</button>
    </form>
</div>
</body>
</html>
