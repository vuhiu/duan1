<!-- filepath: c:\xampp\htdocs\duan1\admin\views\product\addProduct.php -->
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
            <div class="form-group">
                <label for="name">Tên sản phẩm</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="description">Mô tả</label>
                <textarea name="description" id="description" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label for="price">Giá</label>
                <input type="number" name="price" id="price" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="sale_price">Giá khuyến mãi</label>
                <input type="number" name="sale_price" id="sale_price" class="form-control">
            </div>
            <div class="form-group">
                <label for="slug">Slug</label>
                <input type="text" name="slug" id="slug" class="form-control">
            </div>
            <div class="form-group">
                <label for="status">Trạng thái</label>
                <select name="status" id="status" class="form-control">
                    <option value="1">Hiển thị</option>
                    <option value="0">Ẩn</option>
                </select>
            </div>
            <div class="form-group">
                <label for="category_id">Danh mục</label>
                <select name="category_id" id="category_id" class="form-control">
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['category_id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="image">Ảnh</label>
                <input type="file" name="image" id="image" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="colors">Màu sắc</label>
                <select name="colors[]" id="colors" class="form-control" multiple>
                    <?php foreach ($colors as $color): ?>
                        <option value="<?= $color['variant_color_id'] ?>"><?= htmlspecialchars($color['color_name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="sizes">Kích thước</label>
                <select name="sizes[]" id="sizes" class="form-control" multiple>
                    <?php foreach ($sizes as $size): ?>
                        <option value="<?= $size['variant_size_id'] ?>"><?= htmlspecialchars($size['size_name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
        </form>
    </div>
</body>

</html>