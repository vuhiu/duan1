<!-- filepath: c:\xampp\htdocs\duan1\admin\views\product\editProduct.php -->
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chỉnh sửa sản phẩm</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4" style="padding-bottom: 100px;">
        <h2>Chỉnh sửa sản phẩm</h2>
        <form action="?act=sanpham&page=update" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['product_id']) ?>">
            <input type="hidden" name="current_image" value="<?= htmlspecialchars($product['product_image']) ?>">

            <div class="mb-3">
                <label class="form-label">Tên sản phẩm</label>
                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($product['product_name']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Mô tả</label>
                <textarea name="description" class="form-control" required><?= htmlspecialchars($product['product_description']) ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Giá gốc</label>
                <input type="number" name="price" class="form-control" value="<?= htmlspecialchars($product['product_price']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Giá khuyến mãi</label>
                <input type="number" name="sale_price" class="form-control" value="<?= htmlspecialchars($product['product_sale_price']) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Slug</label>
                <input type="text" name="slug" class="form-control" value="<?= htmlspecialchars($product['product_slug']) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Trạng thái</label>
                <select class="form-control" name="status">
                    <option value="1" <?= ($product['product_status'] == 1) ? 'selected' : '' ?>>Hiển thị</option>
                    <option value="0" <?= ($product['product_status'] == 0) ? 'selected' : '' ?>>Ẩn</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Danh mục sản phẩm</label>
                <select class="form-control" name="category_id" required>
                    <option value="">-- Chọn danh mục --</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['category_id'] ?>" <?= ($product['category_id'] == $category['category_id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($category['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="colors">Màu sắc</label>
                <select name="colors[]" id="colors" class="form-control" multiple>
                    <?php foreach ($colors as $color): ?>
                        <option value="<?= $color['variant_color_id'] ?>" <?= in_array($color['variant_color_id'], array_column($variants, 'variant_color_id')) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($color['color_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="sizes">Kích thước</label>
                <select name="sizes[]" id="sizes" class="form-control" multiple>
                    <?php foreach ($sizes as $size): ?>
                        <option value="<?= $size['variant_size_id'] ?>" <?= in_array($size['variant_size_id'], array_column($variants, 'variant_size_id')) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($size['size_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Ảnh sản phẩm</label>
                <input type="file" name="image" class="form-control">
                <br>
                <?php if (!empty($product['product_image'])): ?>
                    <img src="/duan1/upload/<?= htmlspecialchars($product['product_image']) ?>" alt="Ảnh sản phẩm" width="150">
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-primary">Cập nhật</button>
        </form>
    </div>
</body>
</html>