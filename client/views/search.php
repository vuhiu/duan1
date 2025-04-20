<!-- filepath: c:\laragon\www\duan1\client\views\search.php -->
<?php
// Nhận dữ liệu từ form
$keyword = $_GET['keyword'] ?? '';

// Kết nối cơ sở dữ liệu
require_once '../../config/database.php';

// Truy vấn sản phẩm dựa trên từ khóa
$sql = "SELECT * FROM products WHERE name LIKE ?";
$stmt = $conn->prepare($sql);
$stmt->execute(["%$keyword%"]);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kết quả tìm kiếm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h3>Kết quả tìm kiếm cho: "<?php echo htmlspecialchars($keyword); ?>"</h3>
        <div class="row">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <img src="/duan1/upload/<?php echo $product['image']; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($product['name']); ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                                <p class="card-text">Giá: <?php echo number_format($product['price'], 0, ',', '.'); ?> VNĐ</p>
                                <p class="card-text"><?php echo htmlspecialchars($product['description'] ?? 'Không có mô tả'); ?></p>
                                <a href="/duan1/index.php?act=product&product_id=<?php echo $product['id']; ?>" class="btn btn-primary">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Không tìm thấy sản phẩm nào phù hợp.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>