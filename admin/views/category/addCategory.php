<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm danh mục</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h1>Thêm danh mục</h1>
        <form method="POST" action="?act=danhmuc&page=add" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Tên danh mục:</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Mô tả:</label>
                <textarea id="description" name="description" class="form-control" rows="4" required></textarea>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Trạng thái:</label>
                <select id="status" name="status" class="form-select" required>
                    <option value="active">Hoạt động</option>
                    <option value="inactive">Không hoạt động</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Hình ảnh:</label>
                <input type="file" id="image" name="image" class="form-control">
            </div>

            <button type="submit" name="them" class="btn btn-primary">Thêm</button>
        </form>
    </div>
</body>
</html>