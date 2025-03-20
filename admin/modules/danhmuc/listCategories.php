<?php
require '../commons/connect.php'; 

error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = connectDB();
if (!$conn) {
    die("Lỗi kết nối CSDL");
}

// Hiển thị danh sách danh mục
$sql = "SELECT * FROM categories ORDER BY category_id DESC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$categories = $stmt->fetchAll();
?>

<h2>Danh sách danh mục</h2>

<table class="table">
  <thead>
    <tr>
      <th scope="col">STT</th>
      <th scope="col">Tên danh mục</th>
      <th scope="col">Ảnh</th>
      <th scope="col">Trạng thái</th>
      <th scope="col">Mô tả</th>
      <th scope="col">Hành động</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($categories as $index => $category): ?>
      <tr>
        <th scope="row"><?= $index + 1 ?></th>
        <td><?= htmlspecialchars($category['name']) ?></td>
        <td>
          <img src="<?= htmlspecialchars($category['image']) ?>" alt="Ảnh danh mục" width="50">
        </td>
        <td>
          <?= $category['status'] == 'active' ? '<span class="badge bg-success">Hoạt động</span>' : '<span class="badge bg-secondary">Ẩn</span>' ?>
        </td>
        <td><?= htmlspecialchars($category['description']) ?></td>
        <td>
          <a href="?act=danhmuc&page=sua&id=<?= $category['category_id'] ?>" class="btn btn-warning btn-sm">Sửa</a>
          <a href="modules/danhmuc/delete.php?id=<?= $category['category_id'] ?>" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa không?');">Xóa</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
