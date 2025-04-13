<!-- filepath: c:\laragon\www\duan1\client\views\product\category.php -->
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh mục sản phẩm</title>
    <link type="text/css" rel="stylesheet" href="/duan1/css/bootstrap.min.css" />
    <link type="text/css" rel="stylesheet" href="/duan1/css/style.css" />
    <style>
    .filter-box {
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-bottom: 20px;
        padding: 15px;
    }

    .filter-box h4 {
        color: red;
        cursor: pointer;
    }

    .product-label {
        position: absolute;
        top: 10px;
        right: 10px;
        background-color: red;
        color: white;
        padding: 3px 7px;
        font-size: 10px;
        border-radius: 3px;
    }

    .product-img {
        position: relative;
    }

    .truncate {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    </style>
</head>

<body>
    <div class="section">
        <div class="container">
            <div class="row">
                <!-- Sidebar Filter -->
                <div class="col-md-3">
                    <div class="filter-box">
                        <h4>Danh mục sản phẩm</h4>
                        <ul>
                            <?php foreach ($categories as $category): ?>
                            <li>
                                <a
                                    href="/duan1/index.php?act=category&category_id=<?= htmlspecialchars($category['category_id'] ?? '') ?>">
                                    <?= htmlspecialchars($category['name'] ?? 'Danh mục không xác định') ?>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <div class="filter-box">
                        <h4>Khoảng giá</h4>
                        <form method="GET" action="/duan1/index.php">
                            <input type="hidden" name="act" value="category">
                            <input type="hidden" name="category_id"
                                value="<?= htmlspecialchars($_GET['category_id'] ?? '') ?>">
                            <?php if (isset($_GET['brand'])): ?>
                            <?php foreach ($_GET['brand'] as $brand): ?>
                            <input type="hidden" name="brand[]" value="<?= htmlspecialchars($brand ?? '') ?>">
                            <?php endforeach; ?>
                            <?php endif; ?>
                            <label><input type="radio" name="price_range" value="0-1000000"
                                    <?= isset($_GET['price_range']) && $_GET['price_range'] === '0-1000000' ? 'checked' : '' ?>>
                                Dưới 1 triệu</label><br>
                            <label><input type="radio" name="price_range" value="1000000-5000000"
                                    <?= isset($_GET['price_range']) && $_GET['price_range'] === '1000000-5000000' ? 'checked' : '' ?>>
                                1 - 5 triệu</label><br>
                            <label><input type="radio" name="price_range" value="5000000-10000000"
                                    <?= isset($_GET['price_range']) && $_GET['price_range'] === '5000000-10000000' ? 'checked' : '' ?>>
                                5 - 10 triệu</label><br>
                            <label><input type="radio" name="price_range" value="10000000-20000000"
                                    <?= isset($_GET['price_range']) && $_GET['price_range'] === '10000000-20000000' ? 'checked' : '' ?>>
                                10 - 20 triệu</label><br>
                            <label><input type="radio" name="price_range" value="20000000-30000000"
                                    <?= isset($_GET['price_range']) && $_GET['price_range'] === '20000000-30000000' ? 'checked' : '' ?>>
                                20 - 30 triệu</label><br>
                                                     

                            <button type="submit" class="btn btn-primary btn-sm mt-2">Áp dụng</button>
                        </form>
                    </div>

                    <div class="filter-box">
                        <h4>Dung lượng</h4>
                        <form method="GET" action="/duan1/index.php">
                            <input type="hidden" name="act" value="category">
                            <input type="hidden" name="category_id"
                                value="<?= htmlspecialchars($_GET['category_id'] ?? '') ?>">
                            <?php if (isset($_GET['price_range'])): ?>
                            <input type="hidden" name="price_range"
                                value="<?= htmlspecialchars($_GET['price_range'] ?? '') ?>">
                            <?php endif; ?>
                            <label><input type="checkbox" name="size[]" value="128GB"
                                    <?= isset($_GET['size']) && in_array('128GB', $_GET['size']) ? 'checked' : '' ?>>
                                128GB</label><br>
                            <label><input type="checkbox" name="size[]" value="256GB"
                                    <?= isset($_GET['size']) && in_array('256GB', $_GET['size']) ? 'checked' : '' ?>>
                                256GB</label><br>
                            <label><input type="checkbox" name="size[]" value="512GB"
                                    <?= isset($_GET['size']) && in_array('512GB', $_GET['size']) ? 'checked' : '' ?>>
                                512GB</label><br>
                            <label><input type="checkbox" name="size[]" value="1TB"
                                    <?= isset($_GET['size']) && in_array('1TB', $_GET['size']) ? 'checked' : '' ?>>
                                1TB</label><br>
                            <button type="submit" class="btn btn-primary btn-sm mt-2">Áp dụng</button>
                        </form>
                    </div>
                    <div class="filter-box">
                        <h4>Màu sắc</h4>
                        <form method="GET" action="/duan1/index.php">
                            <input type="hidden" name="act" value="category">
                            <input type="hidden" name="category_id"
                                value="<?= htmlspecialchars($_GET['category_id'] ?? '') ?>">
                            <?php if (isset($_GET['price_range'])): ?>
                            <input type="hidden" name="price_range"
                                value="<?= htmlspecialchars($_GET['price_range'] ?? '') ?>">
                            <?php endif; ?>
                            <?php if (isset($_GET['size'])): ?>
                            <?php foreach ($_GET['size'] as $size): ?>
                            <input type="hidden" name="size[]" value="<?= htmlspecialchars($size ?? '') ?>">
                            <?php endforeach; ?>
                            <?php endif; ?>
                            <label><input type="checkbox" name="color[]" value="Đen"
                                    <?= isset($_GET['color']) && in_array('Đen', $_GET['color']) ? 'checked' : '' ?>>
                                Đen</label><br>
                            <label><input type="checkbox" name="color[]" value="Trắng"
                                    <?= isset($_GET['color']) && in_array('Trắng', $_GET['color']) ? 'checked' : '' ?>>
                                Trắng</label><br>
                            <label><input type="checkbox" name="color[]" value="Hồng"
                                    <?= isset($_GET['color']) && in_array('Hồng', $_GET['color']) ? 'checked' : '' ?>>
                                Hồng</label><br>
                        
                            <button type="submit" class="btn btn-primary btn-sm mt-2">Áp dụng</button>
                        </form>
</div>

                </div>
                <!-- /Sidebar Filter -->

                <!-- Product List -->
                <div class="col-md-9">
                    <div class="row">
                        <?php if (!empty($products)): ?>
                        <?php foreach ($products as $product): ?>
                        <div class="col-md-4">
                            <div class="product">
                                <div class="product-img">
                                    <img src="/duan1/upload/<?= htmlspecialchars($product['product_image'] ?? 'default.jpg') ?>"
                                        alt="<?= htmlspecialchars($product['product_name'] ?? 'Sản phẩm không có tên') ?>"
                                        style="width: 100%; height: 250px; object-fit: cover;">
                                </div>
                                <div class="product-body">
                                    <h3 class="product-name truncate">
                                        <?= htmlspecialchars($product['product_name'] ?? 'Sản phẩm không có tên') ?>
                                    </h3>
                                    <h4 class="product-price">
                                        <?php if (!empty($product['product_sale_price'])): ?>
                                        <del><?= number_format($product['product_price'], 0, ',', '.') ?> đ</del>
                                        <span><?= number_format($product['product_sale_price'], 0, ',', '.') ?> đ</span>
                                        <?php else: ?>
                                        <?= number_format($product['product_price'], 0, ',', '.') ?> đ
                                        <?php endif; ?>
                                    </h4>
                                    <p>Biến thể:
                                        <?= htmlspecialchars($product['product_variant_color'] ?? 'Không có') ?>,
                                        <?= htmlspecialchars($product['product_variant_size'] ?? 'Không có') ?></p>
                                    <a href="/duan1/index.php?act=product&product_id=<?= htmlspecialchars($product['product_id'] ?? '0') ?>"
                                        class="btn btn-primary">Xem chi tiết</a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <p>Không có sản phẩm nào trong danh mục này.</p>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- /Product List -->
            </div>
        </div>
    </div>

    <script src="/duan1/js/jquery.min.js"></script>
    <script src="/duan1/js/bootstrap.min.js"></script>
</body>

</html>