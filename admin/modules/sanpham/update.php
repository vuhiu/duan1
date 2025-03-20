<?php
require '../commons/connect.php'; // Kết nối CSDL
$conn = connectDB();

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Kiểm tra kết nối
if (!$conn) {
    die("Lỗi kết nối CSDL");
}

$product_id = $_GET['id'] ?? '';
if (!$product_id) {
    die("Lỗi: Không có ID sản phẩm!");
}

// Lấy thông tin sản phẩm
$stmt = $conn->prepare("SELECT * FROM products WHERE product_id = :id");
$stmt->bindParam(':id', $product_id, PDO::PARAM_INT);
$stmt->execute();
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("Lỗi: Sản phẩm không tồn tại!");
}

// Debug để kiểm tra dữ liệu
// print_r($product); exit;

// Xử lý cập nhật sản phẩm
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name'] ?? '');
    $category_id = $_POST['category_id'] ?? '';
    $description = htmlspecialchars($_POST['description'] ?? '');
    $price = $_POST['price'] ?? '';
    $sale_price = $_POST['sale_price'] ?? '';
    $image = $_FILES['image']['name'] ?? '';

    // Kiểm tra danh mục tồn tại không
    $category_check = $conn->prepare("SELECT category_id FROM categories WHERE category_id = :category_id");
    $category_check->bindParam(':category_id', $category_id, PDO::PARAM_INT);
    $category_check->execute();
    if ($category_check->rowCount() == 0) {
        echo "<p style='color: red;'>Lỗi: Danh mục không tồn tại!</p>";
        exit();
    }

    // Xử lý upload ảnh nếu có
    if (!empty($image)) {
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($image);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
    } else {
        $image = $product['image'];
    }

    // Cập nhật dữ liệu
    $sql = "UPDATE products SET name = :name, image = :image, price = :price, sale_price = :sale_price, description = :description, category_id = :category_id WHERE product_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':image', $image);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':sale_price', $sale_price);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':category_id', $category_id);
    $stmt->bindParam(':id', $product_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header("Location: list_products.php?message=update_success");
        exit();
    } else {
        echo "<p style='color: red;'>Lỗi khi cập nhật sản phẩm!</p>";
    }
}
?>
