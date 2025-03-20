<?php
require '../commons/connect.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = connectDB();
if (!$conn) {
    die("Lỗi kết nối CSDL");
}

// Truy vấn danh sách sản phẩm
$sql = "SELECT p.*, c.name AS category_name 
        FROM products p 
        LEFT JOIN categories c ON p.category_id = c.category_id 
        ORDER BY p.created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2 class="mt-3">Danh sách sản phẩm</h2>

<a href="add_product.php" class="btn btn-success mb-3">Thêm sản phẩm</a>

<table class="table table-bordered">
  <thead class="table-dark">
    <tr>
      <th scope="col">STT</th>
      <th scope="col">Ảnh</th>
      <th scope="col">Tên sản phẩm</th>
      <th scope="col">Giá gốc</th>
      <th scope="col">Giá khuyến mãi</th>
      <th scope="col">Danh mục</th>
      <th scope="col">Hành động</th>
    </tr>
  </thead>
  <tbody>
    <?php if (!empty($products)): ?>
      <?php foreach ($products as $index => $product): ?>
        <tr>
          <th scope="row"><?= $index + 1 ?></th>
          <td>
            <?php if (!empty($product['image']) && file_exists("../uploads/" . $product['image'])): ?>
              <img src="<?= htmlspecialchars('../uploads/' . $product['image']) ?>" width="80" height="80" alt="<?= htmlspecialchars($product['name']) ?>">
            <?php else: ?>
              <span class="text-muted">Không có ảnh</span>
            <?php endif; ?>
          </td>
          <td><?= htmlspecialchars($product['name']) ?></td>
          <td><?= number_format($product['price']) ?>đ</td>
          <td><?= number_format($product['sale_price']) ?>đ</td>
          <td><?= htmlspecialchars($product['category_name']) ?></td>
          <td>
            <a href="edit_product.php?id=<?= $product['product_id'] ?>" class="btn btn-warning btn-sm">Sửa</a>
            <a href="delete_product.php?id=<?= $product['product_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa không?');">Xóa</a>
          </td>
        </tr>
      <?php endforeach; ?>
    <?php else: ?>
      <tr>
        <td colspan="7" class="text-center text-danger">Không có sản phẩm nào</td>
      </tr>
    <?php endif; ?>
  </tbody>
</table>
