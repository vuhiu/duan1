<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chỉnh sửa danh mục</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
    <h1>Chỉnh sửa danh mục</h1>
    <form method="POST" action="?act=danhmuc&page=update" enctype="multipart/form-data">
        <input type="hidden" name="category_id" value="<?php echo $category['category_id']; ?>">

        <label for="name">Tên danh mục:</label>
        <input type="text" id="name" name="name" value="<?php echo $category['name']; ?>" required><br>

        <label for="description">Mô tả:</label>
        <textarea id="description" name="description" required><?php echo $category['description']; ?></textarea><br>

        <label for="status">Trạng thái:</label>
        <select id="status" name="status" required>
            <option value="active" <?php echo $category['status'] == 'active' ? 'selected' : ''; ?>>Hoạt động</option>
            <option value="inactive" <?php echo $category['status'] == 'inactive' ? 'selected' : ''; ?>>Không hoạt động</option>
        </select><br>

        <label for="image">Hình ảnh:</label>
        <input type="file" id="image" name="image"><br>
        <input type="hidden" name="current_image" value="<?php echo $category['image']; ?>">

        <button type="submit" class="btn btn-primary mt-3">Cập nhật</button>
    </form>
    </div>
</body>
</html>