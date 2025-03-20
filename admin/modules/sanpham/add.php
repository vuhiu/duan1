<?php
require '../commons/connect.php'; // Kết nối CSDL
$conn = connectDB(); // Hàm kết nối

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Kiểm tra kết nối
if (!$conn) {
    die("Lỗi kết nối CSDL");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'] ?? '';
    $category_id = $_POST['category_id'] ?? '';
    $description = $_POST['description'] ?? '';
    $price = $_POST['price'] ?? '';
    $sale_price = $_POST['sale_price'] ?? '';
    $image = $_FILES['image']['name'];

    // Kiểm tra xem category_id có tồn tại không
    $category_check = $conn->prepare("SELECT category_id FROM categories WHERE category_id = :category_id");
    $category_check->bindParam(':category_id', $category_id, PDO::PARAM_INT);
    $category_check->execute();

    if ($category_check->rowCount() == 0) {
        echo "<p style='color: red;'>Lỗi: Danh mục không tồn tại!</p>";
        exit();
    }

    // Xử lý upload ảnh
    if (!empty($image)) {
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($image);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
    } else {
        $image = "default.jpg"; // Ảnh mặc định nếu không có ảnh tải lên
    }

    // Thêm sản phẩm vào CSDL
    $sql = "INSERT INTO products (name, image, price, sale_price, description, category_id) 
            VALUES (:name, :image, :price, :sale_price, :description, :category_id)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':image', $image);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':sale_price', $sale_price);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':category_id', $category_id);

    if ($stmt->execute()) {
        echo "<p style='color: green;'>Thêm sản phẩm thành công!</p>";
        header("Location: product_list.php"); // Chuyển hướng về danh sách sản phẩm
        exit();
    } else {
        echo "<p style='color: red;'>Lỗi khi thêm sản phẩm!</p>";
    }
}
?>

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
