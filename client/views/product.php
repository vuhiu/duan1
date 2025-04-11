<!-- filepath: c:\xampp\htdocs\duan1\client\views\product.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Danh sách sản phẩm</title>

    <!-- Google font -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">

    <!-- Bootstrap -->
    <link type="text/css" rel="stylesheet" href="/duan1/css/bootstrap.min.css" />

    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="/duan1/css/font-awesome.min.css">

    <!-- Custom stylesheet -->
    <link type="text/css" rel="stylesheet" href="/duan1/css/style.css" />
</head>

<body>
    <div class="container">
        <h2 class="text-center my-4">Danh sách sản phẩm</h2>
        <div class="row">
            <?php foreach ($products as $product): ?>
            <div class="col-md-4">
                <div class="product">
                    <div class="product-img">
                        <img src="/duan1/upload/<?= htmlspecialchars($product['product_image']) ?>" alt="Ảnh sản phẩm"
                            style="width: 100%; height: 250px; object-fit: cover;">
                    </div>
                    <div class="product-body">
                        <p class="product-category"><?= htmlspecialchars($product['category_name']) ?></p>
                        <h3 class="product-name">
                            <a href="/duan1/index.php?act=product&product_id=<?= $product['product_id'] ?>">
                                <?= htmlspecialchars($product['product_name']) ?>
                            </a>
                        </h3>
                        <h4 class="product-price">
                            <?= number_format($product['product_sale_price'], 0, ',', '.') ?>₫
                            <?php if ($product['product_sale_price'] < $product['product_price']): ?>
                            <del class="product-old-price"><?= number_format($product['product_price'], 0, ',', '.') ?>₫</del>
                            <?php endif; ?>
                        </h4>
                        <ul>
                            <?php foreach ($product['variants'] as $variant): ?>
                            <li>
                                Màu: <?= htmlspecialchars($variant['product_variant_color'] ?? 'Không xác định') ?>,
                                Kích thước: <?= htmlspecialchars($variant['product_variant_size'] ?? 'Không xác định') ?>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- jQuery Plugins -->
    <script src="/duan1/js/jquery.min.js"></script>
    <script src="/duan1/js/bootstrap.min.js"></script>
</body>

</html>