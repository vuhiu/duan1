<!-- filepath: c:\laragon\www\duan1\client\views\product\category.php -->
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh mục sản phẩm</title>
    <link type="text/css" rel="stylesheet" href="/duan1/css/bootstrap.min.css" />
    <link type="text/css" rel="stylesheet" href="/duan1/css/style.css" />
</head>

<body>
    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title">
                        <h3 class="title">Danh mục: <?= htmlspecialchars($products[0]['category_name'] ?? 'Không xác định') ?></h3>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <?php if (!empty($products)): ?>
                            <?php foreach ($products as $product): ?>
                                <div class="col-md-4">
                                    <div class="product">
                                        <div class="product-img">
                                            <img src="/duan1/upload/<?= htmlspecialchars($product['product_image']) ?>" alt="<?= htmlspecialchars($product['product_name']) ?>">
                                        </div>
                                        <div class="product-body">
                                            <h3 class="product-name"><?= htmlspecialchars($product['product_name']) ?></h3>
                                            <h4 class="product-price">
                                                <?php if (!empty($product['product_sale_price'])): ?>
                                                    <del><?= number_format($product['product_price'], 0, ',', '.') ?> đ</del>
                                                    <span><?= number_format($product['product_sale_price'], 0, ',', '.') ?> đ</span>
                                                <?php else: ?>
                                                    <?= number_format($product['product_price'], 0, ',', '.') ?> đ
                                                <?php endif; ?>
                                            </h4>
                                            <a href="/duan1/index.php?act=product&product_id=<?= $product['product_id'] ?>" class="btn btn-primary">Xem chi tiết</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>Không có sản phẩm nào trong danh mục này.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>