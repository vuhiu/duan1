<?php
require '../commons/connect.php'; // Kết nối CSDL


error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = connectDB();
if(!$conn){
    die("Lỗi kết nối CSDL");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    $image = 'https://cdn-icons-png.flaticon.com/512/5957/5957265.png'; // Tạm thời dùng chuỗi mặc định
    $status = $_POST['status'] ?? 'Hidden';

    if (!empty($name)) {
        $sql = "INSERT INTO categories (name, description, image, status) 
                VALUES (:name, :description, :image, :status)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':status', $status);

        if ($stmt->execute()) {
            echo "<p style='color: green;'>Thêm danh mục thành công!</p>";
            
        } else {
            echo "<p style='color: red;'>Lỗi khi thêm danh mục!</p>";
        }
    } else {
        echo "<p style='color: red;'>Tên danh mục không được để trống!</p>";
    }
    
}
?>

<h2>Thêm danh mục</h2>
<form method="POST">
  <div class="mb-3">
    <label class="form-label">Tên danh mục</label>
    <input type="text" class="form-control" name="name" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Mô tả danh mục</label>
    <input type="text" class="form-control" name="description">
  </div>
  <div class="mb-3">
    <label class="form-label">Hình ảnh</label>
    <input type="text" class="form-control" name="image" value="https://cdn-icons-png.flaticon.com/512/5957/5957265.png" readonly>
  </div>
  <div class="mb-3">
    <label class="form-label">Trạng thái</label>
    <select class="form-select" name="status">
        <option value="Hidden">Hidden</option>
        <option value="Active">Active</option>
    </select>
  </div>
  <button type="submit" class="btn btn-primary">Thêm</button>
</form>
