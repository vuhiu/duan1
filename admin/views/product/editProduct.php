<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chỉnh sửa sản phẩm</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Chỉnh sửa sản phẩm</h2>
        <form action="?act=sanpham&page=update&id=<?= $product['product_id'] ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="current_image" value="<?= $product['image'] ?>">

            <div class="mb-3">
                <label class="form-label">Tên sản phẩm</label>
                <input type="text" name="name" class="form-control" value="<?= $product['name'] ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Mô tả</label>
                <textarea name="description" class="form-control"><?= $product['description'] ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Giá gốc</label>
                <input type="number" name="price" class="form-control" value="<?= $product['price'] ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Giá khuyến mãi</label>
                <input type="number" name="sale_price" class="form-control" value="<?= $product['sale_price'] ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Slug</label>
                <input type="text" name="slug" class="form-control" value="<?= $product['slug'] ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Trạng thái</label>
                <select class="form-control" name="status">
                    <option value="1" <?= ($product['status'] == 1) ? 'selected' : '' ?>>Hiển thị</option>
                    <option value="0" <?= ($product['status'] == 0) ? 'selected' : '' ?>>Ẩn</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Danh mục sản phẩm</label>
                <select class="form-control" name="category_id" required>
                    <option value="">-- Chọn danh mục --</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['category_id'] ?>" <?= ($product['category_id'] == $category['category_id']) ? 'selected' : '' ?>>
                            <?= $category['name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Ảnh sản phẩm</label>
                <input type="file" name="image" class="form-control">
                <br>
                <?php if (!empty($product['image'])): ?>
                    <img src="uploads/<?= $product['image'] ?>" alt="Ảnh sản phẩm" width="150">
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-primary">Cập nhật</button>
        </form>
    </div>
</body>
</html>
