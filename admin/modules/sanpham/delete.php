<?php
require_once __DIR__ . '/../../../commons/connect.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = connectDB();

$id = $_GET['id'] ?? '';

if (!empty($id)) {
    try {
        // Kiểm tra sản phẩm có tồn tại không
        $stmt = $conn->prepare("SELECT image FROM products WHERE product_id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$product) {
            header("Location: http://localhost/duan1/admin/?act=sanpham&error=notfound");
            exit;
        }

        // Xóa ảnh nếu tồn tại (trừ ảnh mặc định)
        $image_path = __DIR__ . "/../../../uploads/" . $product['image'];
        if (!empty($product['image']) && file_exists($image_path) && $product['image'] !== "default.jpg") {
            unlink($image_path);
        }

        // Xóa sản phẩm
        $sql = "DELETE FROM products WHERE product_id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header("Location: http://localhost/duan1/admin/?act=sanpham&status=deleted");
            exit;
        } else {
            header("Location: http://localhost/duan1/admin/?act=sanpham&error=failed");
            exit;
        }
    } catch (PDOException $e) {
        error_log("Lỗi xóa sản phẩm: " . $e->getMessage()); // Ghi log lỗi
        header("Location: http://localhost/duan1/admin/?act=sanpham&error=exception");
        exit;
    }
} else {
    header("Location: http://localhost/duan1/admin/?act=sanpham&error=invalid");
    exit;
}
?>
