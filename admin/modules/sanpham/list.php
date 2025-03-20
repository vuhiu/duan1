<?php
// Kết nối database
$servername = "localhost";
$username = "root"; // Thay bằng username MySQL của bạn
$password = ""; // Thay bằng mật khẩu MySQL của bạn
$database = "duan1"; // Thay bằng tên database của bạn

$conn = new mysqli($servername, $username, $password, $database);
$conn->set_charset("utf8mb4");

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Truy vấn danh sách sản phẩm
$sql = "SELECT * FROM products ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sản phẩm</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h2 class="mb-4">Danh sách sản phẩm</h2>
    

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Ảnh</th>
                <th>Tên sản phẩm</th>
                <th>Giá gốc</th>
                <th>Giá khuyến mãi</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['product_id']}</td>";
                    echo "<td><img src='uploads/{$row['image']}' width='80' height='80' alt='{$row['name']}'></td>";
                    echo "<td>{$row['name']}</td>";
                    echo "<td>" . number_format($row['price']) . "đ</td>";
                    echo "<td>" . number_format($row['sale_price']) . "đ</td>";
                    echo "<td>" . ($row['status'] ? "<span class='text-success'>Hiển thị</span>" : "<span class='text-danger'>Ẩn</span>") . "</td>";
                    echo "<td>
                            <a href='edit_product.php?id={$row['product_id']}' class='btn btn-warning btn-sm'>Sửa</a>
                            <a href='delete_product.php?id={$row['product_id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Bạn có chắc muốn xóa?\");'>Xóa</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7' class='text-center'>Không có sản phẩm nào</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>

<?php
$conn->close();
?>
