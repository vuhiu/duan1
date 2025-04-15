<!-- filepath: c:\laragon\www\duan1\client\views\product\category.php -->
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh mục sản phẩm</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="/duan1/css/bootstrap.min.css" />
    <link type="text/css" rel="stylesheet" href="/duan1/css/style.css" />
    <link rel="stylesheet" href="/duan1/css/font-awesome.min.css">
    <style>
    body {
        font-family: 'Montserrat', sans-serif;
        background-color: #f8f9fa;
    }

    /* Sidebar styles */
    .sidebar {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        margin-bottom: 30px;
    }

    .filter-box {
        border-bottom: 1px solid #eee;
        padding: 20px;
    }

    .filter-box:last-child {
        border-bottom: none;
    }

    .filter-box h4 {
        color: #2B2D42;
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 15px;
        position: relative;
        cursor: pointer;
    }

    .filter-box h4:after {
        content: '\f107';
        font-family: FontAwesome;
        position: absolute;
        right: 0;
        color: #D10024;
    }

    .filter-box ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .filter-box ul li {
        margin-bottom: 10px;
    }

    .filter-box ul li a {
        color: #2B2D42;
        text-decoration: none;
        transition: all 0.3s;
        display: block;
        padding: 5px 0;
    }

    .filter-box ul li a:hover {
        color: #D10024;
        padding-left: 5px;
    }

    .filter-box label {
        display: block;
        margin-bottom: 10px;
        color: #2B2D42;
        cursor: pointer;
    }

    .filter-box input[type="radio"],
    .filter-box input[type="checkbox"] {
        margin-right: 10px;
    }

    .btn-filter {
        background: #D10024;
        color: #fff;
        border: none;
        padding: 8px 15px;
        border-radius: 4px;
        font-weight: 500;
        transition: all 0.3s;
        width: 100%;
        margin-top: 10px;
    }

    .btn-filter:hover {
        background: #A70017;
        transform: translateY(-2px);
    }

    /* Product styles */
    .product {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        margin-bottom: 30px;
        transition: all 0.3s;
        position: relative;
        overflow: hidden;
    }

    .product:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }

    .product-img {
        position: relative;
        padding-top: 100%;
        overflow: hidden;
    }

    .product-img img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: all 0.3s;
    }

    .product:hover .product-img img {
        transform: scale(1.1);
    }

    .product-label {
        position: absolute;
        top: 15px;
        left: 15px;
        z-index: 1;
    }

    .product-label span {
        display: inline-block;
        padding: 5px 10px;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        color: #FFF;
        border-radius: 15px;
        margin-bottom: 5px;
    }

    .product-label .sale {
        background-color: #D10024;
    }

    .product-label .new {
        background-color: #00C853;
    }

    .product-body {
        padding: 20px;
    }

    .product-name {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 10px;
        line-height: 1.4;
        height: 44px;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .product-name a {
        color: #2B2D42;
        text-decoration: none;
        transition: all 0.3s;
    }

    .product-name a:hover {
        color: #D10024;
    }

    .product-price {
        margin-bottom: 15px;
    }

    .product-price del {
        font-size: 14px;
        color: #8D99AE;
        margin-right: 10px;
    }

    .product-price span {
        font-size: 18px;
        color: #D10024;
        font-weight: 700;
    }

    /* Product variant styles */
    .product-variant {
        font-size: 13px;
        color: #8D99AE;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .variant-colors {
        display: flex;
        gap: 5px;
    }

    .color-dot {
        width: 15px;
        height: 15px;
        border-radius: 50%;
        display: inline-block;
        border: 1px solid #ddd;
    }

    .color-black { background-color: #000; }
    .color-white { background-color: #fff; }
    .color-pink { background-color: #FFC0CB; }
    .color-gold { background-color: #FFD700; }
    .color-silver { background-color: #C0C0C0; }
    .color-gray { background-color: #808080; }
    .color-blue { background-color: #0000FF; }
    .color-red { background-color: #FF0000; }
    .color-green { background-color: #008000; }
    .color-purple { background-color: #800080; }

    .btn-view {
        display: block;
        width: 100%;
        padding: 10px;
        background: #2B2D42;
        color: #fff;
        text-align: center;
        border: none;
        border-radius: 4px;
        font-weight: 500;
        text-transform: uppercase;
        transition: all 0.3s;
    }

    .btn-view:hover {
        background: #D10024;
        color: #fff;
        text-decoration: none;
    }

    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .empty-state i {
        font-size: 48px;
        color: #8D99AE;
        margin-bottom: 15px;
    }

    .empty-state p {
        color: #2B2D42;
        font-size: 16px;
        margin: 0;
    }

    /* Breadcrumb */
    .breadcrumb {
        background: none;
        padding: 0;
        margin-bottom: 30px;
    }

    .breadcrumb-item a {
        color: #8D99AE;
        text-decoration: none;
    }

    .breadcrumb-item.active {
        color: #2B2D42;
    }

    .breadcrumb-item + .breadcrumb-item::before {
        content: '\f105';
        font-family: FontAwesome;
        color: #8D99AE;
    }
    </style>
</head>

<body>
    <div class="section">
        <div class="container">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/duan1/index.php">Trang chủ</a></li>
                    <li class="breadcrumb-item active">Danh mục sản phẩm</li>
                </ol>
            </nav>

            <div class="row">
                <!-- Sidebar Filter -->
                <div class="col-md-3">
                    <div class="sidebar">
                        <div class="filter-box">
                            <h4>Danh mục sản phẩm</h4>
                            <ul>
                                <?php foreach ($categories as $category): ?>
                                <li>
                                    <a href="/duan1/index.php?act=category&category_id=<?= htmlspecialchars($category['category_id'] ?? '') ?>">
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
                                <input type="hidden" name="category_id" value="<?= htmlspecialchars($_GET['category_id'] ?? '') ?>">
                                <?php if (isset($_GET['brand'])): ?>
                                <?php foreach ($_GET['brand'] as $brand): ?>
                                <input type="hidden" name="brand[]" value="<?= htmlspecialchars($brand ?? '') ?>">
                                <?php endforeach; ?>
                                <?php endif; ?>
                                <label><input type="radio" name="price_range" value="0-1000000" <?= isset($_GET['price_range']) && $_GET['price_range'] === '0-1000000' ? 'checked' : '' ?>>
                                    Dưới 1 triệu</label>
                                <label><input type="radio" name="price_range" value="1000000-5000000" <?= isset($_GET['price_range']) && $_GET['price_range'] === '1000000-5000000' ? 'checked' : '' ?>>
                                    1 - 5 triệu</label>
                                <label><input type="radio" name="price_range" value="5000000-10000000" <?= isset($_GET['price_range']) && $_GET['price_range'] === '5000000-10000000' ? 'checked' : '' ?>>
                                    5 - 10 triệu</label>
                                <label><input type="radio" name="price_range" value="10000000-20000000" <?= isset($_GET['price_range']) && $_GET['price_range'] === '10000000-20000000' ? 'checked' : '' ?>>
                                    10 - 20 triệu</label>
                                <label><input type="radio" name="price_range" value="20000000-30000000" <?= isset($_GET['price_range']) && $_GET['price_range'] === '20000000-30000000' ? 'checked' : '' ?>>
                                    20 - 30 triệu</label>
                                <button type="submit" class="btn-filter">Áp dụng</button>
                            </form>
                        </div>

                        <div class="filter-box">
                            <h4>Dung lượng</h4>
                            <form method="GET" action="/duan1/index.php">
                                <input type="hidden" name="act" value="category">
                                <input type="hidden" name="category_id" value="<?= htmlspecialchars($_GET['category_id'] ?? '') ?>">
                                <?php if (isset($_GET['price_range'])): ?>
                                <input type="hidden" name="price_range" value="<?= htmlspecialchars($_GET['price_range'] ?? '') ?>">
                                <?php endif; ?>
                                <label><input type="checkbox" name="size[]" value="128GB" <?= isset($_GET['size']) && in_array('128GB', $_GET['size']) ? 'checked' : '' ?>>
                                    128GB</label>
                                <label><input type="checkbox" name="size[]" value="256GB" <?= isset($_GET['size']) && in_array('256GB', $_GET['size']) ? 'checked' : '' ?>>
                                    256GB</label>
                                <label><input type="checkbox" name="size[]" value="512GB" <?= isset($_GET['size']) && in_array('512GB', $_GET['size']) ? 'checked' : '' ?>>
                                    512GB</label>
                                <label><input type="checkbox" name="size[]" value="1TB" <?= isset($_GET['size']) && in_array('1TB', $_GET['size']) ? 'checked' : '' ?>>
                                    1TB</label>
                                <button type="submit" class="btn-filter">Áp dụng</button>
                            </form>
                        </div>

                        <div class="filter-box">
                            <h4>Màu sắc</h4>
                            <form method="GET" action="/duan1/index.php">
                                <input type="hidden" name="act" value="category">
                                <input type="hidden" name="category_id" value="<?= htmlspecialchars($_GET['category_id'] ?? '') ?>">
                                <?php if (isset($_GET['price_range'])): ?>
                                <input type="hidden" name="price_range" value="<?= htmlspecialchars($_GET['price_range'] ?? '') ?>">
                                <?php endif; ?>
                                <?php if (isset($_GET['size'])): ?>
                                <?php foreach ($_GET['size'] as $size): ?>
                                <input type="hidden" name="size[]" value="<?= htmlspecialchars($size ?? '') ?>">
                                <?php endforeach; ?>
                                <?php endif; ?>
                                <label><input type="checkbox" name="color[]" value="Đen" <?= isset($_GET['color']) && in_array('Đen', $_GET['color']) ? 'checked' : '' ?>>
                                    Đen</label>
                                <label><input type="checkbox" name="color[]" value="Trắng" <?= isset($_GET['color']) && in_array('Trắng', $_GET['color']) ? 'checked' : '' ?>>
                                    Trắng</label>
                                <label><input type="checkbox" name="color[]" value="Hồng" <?= isset($_GET['color']) && in_array('Hồng', $_GET['color']) ? 'checked' : '' ?>>
                                    Hồng</label>
                                <button type="submit" class="btn-filter">Áp dụng</button>
                            </form>
                        </div>
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
                                        alt="<?= htmlspecialchars($product['product_name'] ?? 'Sản phẩm không có tên') ?>">
                                    <div class="product-label">
                                        <?php if (!empty($product['product_sale_price'])): ?>
                                        <span class="sale">-<?= round((($product['product_price'] - $product['product_sale_price']) / $product['product_price']) * 100) ?>%</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="product-body">
                                    <h3 class="product-name">
                                        <a href="/duan1/index.php?act=product&product_id=<?= htmlspecialchars($product['product_id'] ?? '0') ?>">
                                            <?= htmlspecialchars($product['product_name'] ?? 'Sản phẩm không có tên') ?>
                                        </a>
                                    </h3>
                                    <h4 class="product-price">
                                        <?php if (!empty($product['product_sale_price'])): ?>
                                        <del><?= number_format($product['product_price'], 0, ',', '.') ?>₫</del>
                                        <span><?= number_format($product['product_sale_price'], 0, ',', '.') ?>₫</span>
                                        <?php else: ?>
                                        <span><?= number_format($product['product_price'], 0, ',', '.') ?>₫</span>
                                        <?php endif; ?>
                                    </h4>
                                    <div class="product-variant">
                                        <div class="variant-colors">
                                            <?php
                                            $colorMap = [
                                                'Đen' => 'black',
                                                'Trắng' => 'white',
                                                'Hồng' => 'pink',
                                                'Vàng' => 'gold',
                                                'Bạc' => 'silver',
                                                'Xám' => 'gray',
                                                'Xanh' => 'blue',
                                                'Đỏ' => 'red',
                                                'Xanh lá' => 'green',
                                                'Tím' => 'purple'
                                            ];
                                            
                                            $colors = explode(',', $product['product_variant_color'] ?? '');
                                            foreach ($colors as $color) {
                                                $color = trim($color);
                                                $englishColor = $colorMap[$color] ?? 'black'; // Mặc định là đen nếu không tìm thấy
                                                echo '<span class="color-dot color-' . $englishColor . '" title="' . htmlspecialchars($color) . '"></span>';
                                            }
                                            ?>
                                        </div>
                                        <span><?= htmlspecialchars($product['product_variant_size'] ?? 'Không có') ?></span>
                                    </div>
                                    <a href="/duan1/index.php?act=product&product_id=<?= htmlspecialchars($product['product_id'] ?? '0') ?>"
                                        class="btn-view">Xem chi tiết</a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <div class="col-md-12">
                            <div class="empty-state">
                                <i class="fa fa-shopping-bag"></i>
                                <p>Không có sản phẩm nào trong danh mục này.</p>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- /Product List -->
            </div>
        </div>
    </div>

    <script src="/duan1/js/jquery.min.js"></script>
    <script src="/duan1/js/bootstrap.min.js"></script>
    <script>
    $(document).ready(function() {
        // Toggle filter content
        $('.filter-box h4').click(function() {
            $(this).parent().find('form, ul').slideToggle();
            $(this).toggleClass('active');
        });
    });
    </script>
</body>

</html>