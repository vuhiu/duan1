<h2 class="mt-3">Danh sách danh mục</h2>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<!-- <link type="text/css" rel="stylesheet" href="/duan1/css/bootstrap.min.css" /> -->
<link rel="stylesheet" href="/duan1/client/public/css/style.css">


<?php if (!empty($categories)): ?>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Mô tả</th>
                <th>Trạng thái</th>
                <th>Hình ảnh</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $category): ?>
                <tr>
                    <td><?php echo isset($category['category_id']) ? $category['category_id'] : 'N/A'; ?></td>
                    <td><?php echo isset($category['name']) ? $category['name'] : 'N/A'; ?></td>
                    <td><?php echo isset($category['description']) ? $category['description'] : 'N/A'; ?></td>
                    <td><?php echo isset($category['status']) ? ($category['status'] == 'active' ? 'Hoạt động' : 'Không hoạt động') : 'N/A'; ?>
                    </td>
                    <td>
                        <?php if (!empty($category['image'])): ?>
                            <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/duan1/admin/upload/' . $category['image'])): ?>
                                <!-- Nếu tệp tồn tại trong thư mục upload -->
                                <img src="/duan1/admin/upload/<?= $category['image'] ?>" alt="Image" width="50">
                            <?php else: ?>
                                <!-- Nếu tệp không tồn tại -->
                                Không có hình ảnh
                            <?php endif; ?>
                        <?php else: ?>
                            <!-- Nếu cột image trong cơ sở dữ liệu trống -->
                            Không có hình ảnh
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="?act=danhmuc&page=sua&id=<?php echo $category['category_id']; ?>"
                            class="btn btn-warning btn-sm">Sửa</a>
                        <a href="?act=danhmuc&page=xoa&id=<?php echo $category['category_id']; ?>"
                            onclick="return confirm('Bạn có chắc chắn muốn xóa?')" class="btn btn-danger btn-sm">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Không có danh mục nào.</p>
<?php endif; ?>