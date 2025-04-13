<!-- filepath: c:\xampp\htdocs\duan1\client\views\home.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Electro - HTML Ecommerce Template</title>

    <!-- Google font -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">

    <!-- Bootstrap -->
    <link type="text/css" rel="stylesheet" href="/duan1/css/bootstrap.min.css" />

    <!-- Slick -->
    <link type="text/css" rel="stylesheet" href="/duan1/css/slick.css" />
    <link type="text/css" rel="stylesheet" href="/duan1/css/slick-theme.css" />

    <!-- nouislider -->
    <link type="text/css" rel="stylesheet" href="/duan1/css/nouislider.min.css" />

    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="/duan1/css/font-awesome.min.css">

    <!-- Custom stylesheet -->
    <link type="text/css" rel="stylesheet" href="/duan1/css/style.css" />
</head>

<body>

    <!-- SECTION: New Products -->
    <div class="section">
        <div class="container">
            <div class="row">
                <!-- Section Title -->
                <div class="col-md-12">
                    <div class="section-title">
                        <h3 class="title">Sản phẩm mới</h3>
                        <!-- <div class="section-nav">
                            <ul class="section-tab-nav tab-nav">
                                <li class="active"><a data-toggle="tab" href="#tab1">Laptop</a></li>
                                <li><a data-toggle="tab" href="#tab1">Điện thoại</a></li>
                                <li><a data-toggle="tab" href="#tab1">Máy ảnh</a></li>
                                <li><a data-toggle="tab" href="#tab1">Phụ kiện</a></li>
                            </ul>
                        </div> -->
                    </div>
                </div>
                <!-- /Section Title -->

                <!-- Product List -->
                <div class="col-md-12">
                    <div class="row">
                        <div class="products-tabs">
                            <div id="tab1" class="tab-pane active">
                                <div class="products-slick" data-nav="#slick-nav-1">
                                    <?php foreach ($products as $product): ?>
                                    <div class="col-md-3">
                                        <div class="product-item"
                                            style="border: 1px solid #eee; border-radius: 12px; padding: 15px; margin-bottom: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); transition: 0.3s;">
                                            <div class="product-img" style="text-align: center; height: 180px;">
                                                <img src="/duan1/upload/<?= htmlspecialchars($product['product_image']) ?>"
                                                    alt="Ảnh sản phẩm" style="max-height: 100%; object-fit: contain;">
                                            </div>
                                            <div class="product-body" style="padding-top: 10px;">
                                                <p class="product-category"
                                                    style="font-size: 13px; color: #888; text-transform: uppercase;">
                                                    <?= htmlspecialchars($product['category_name']) ?></p>
                                                <h3 class="product-name"
                                                    style="font-size: 16px; font-weight: bold; min-height: 48px;">
                                                    <a href="/duan1/index.php?act=product&product_id=<?= $product['product_id'] ?>"
                                                        style="color: #333;">
                                                        <?= htmlspecialchars($product['product_name']) ?>
                                                    </a>
                                                </h3>
                                                <h4 class="product-price" style="margin-top: 5px; margin-bottom: 10px;">
                                                    <?php if (!empty($product['product_sale_price'])): ?>
                                                    <span
                                                        style="color: red; font-weight: bold;"><?= number_format($product['product_sale_price'], 0, ',', '.') ?>₫</span>
                                                    <del
                                                        style="margin-left: 5px; color: #888;"><?= number_format($product['product_price'], 0, ',', '.') ?>₫</del>
                                                    <?php else: ?>
                                                    <span
                                                        style="font-weight: bold;"><?= number_format($product['product_price'], 0, ',', '.') ?>₫</span>
                                                    <?php endif; ?>
                                                </h4>

                                                <!-- Hiển thị biến thể sản phẩm -->
                                                <?php
                                                    $colors = [];
                                                    $sizes = [];
                                                    foreach ($product['variants'] as $variant) {
                                                        // Lấy mã màu và tên màu
                                                        $colorId = $variant['variant_color_id'] ?? null;
                                                        $colorCode = $variant['color_code'] ?? null;
                                                        if ($colorId && $colorCode && !isset($colors[$colorId])) {
                                                            $colors[$colorId] = $colorCode;
                                                        }

                                                        // Lấy kích thước
                                                        $sizeId = $variant['variant_size_id'] ?? null;
                                                        $sizeName = $variant['size_name'] ?? null;
                                                        if ($sizeId && $sizeName && !isset($sizes[$sizeId])) {
                                                            $sizes[$sizeId] = $sizeName;
                                                        }
                                                    }
                                                ?>
                                                <div>
                                                    <strong>Chọn màu:</strong><br>
                                                    <div>
                                                        <?php foreach ($colors as $colorId => $colorCode): ?>
                                                        <div class="color-circle color-btn mb-2"
                                                            data-color-id="<?= htmlspecialchars($colorId) ?>"
                                                            style="background-color: <?= htmlspecialchars($colorCode) ?>;">
                                                        </div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>

                                                <div>
                                                    <strong>Chọn kích thước:</strong><br>
                                                    <?php foreach ($sizes as $sizeId => $sizeName): ?>
                                                    <button class="btn btn-outline-secondary size-btn mb-2"
                                                        data-size-id="<?= htmlspecialchars($sizeId) ?>"><?= htmlspecialchars($sizeName) ?></button>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                                <div id="slick-nav-1" class="products-slick-nav"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Product List -->
            </div>
        </div>
    </div>
    <!-- /SECTION: New Products -->

    <!-- SECTION: Hot Deals -->
    <div id="hot-deal" class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="hot-deal">
                        <ul class="hot-deal-countdown">
                            <li>
                                <div>
                                    <h3>02</h3>
                                    <span>Ngày</span>
                                </div>
                            </li>
                            <li>
                                <div>
                                    <h3>10</h3>
                                    <span>Giờ</span>
                                </div>
                            </li>
                            <li>
                                <div>
                                    <h3>34</h3>
                                    <span>Phút</span>
                                </div>
                            </li>
                            <li>
                                <div>
                                    <h3>60</h3>
                                    <span>Giây</span>
                                </div>
                            </li>
                        </ul>
                        <h2 class="text-uppercase">Khuyến mãi hot tuần này</h2>
                        <p>Bộ sưu tập mới giảm đến 50%</p>
                        <a class="primary-btn cta-btn" href="#">Mua ngay</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /SECTION: Hot Deals -->

    <!-- Newsletter -->
    <div id="newsletter" class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="newsletter">
                        <p>Đăng ký để nhận <strong>BẢN TIN</strong></p>
                        <form>
                            <input class="input" type="email" placeholder="Nhập email của bạn">
                            <button class="newsletter-btn"><i class="fa fa-envelope"></i> Đăng ký</button>
                        </form>
                        <ul class="newsletter-follow">
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                            <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Newsletter -->

    <!-- jQuery Plugins -->
    <script src="/duan1/js/jquery.min.js"></script>
    <script src="/duan1/js/bootstrap.min.js"></script>
    <script src="/duan1/js/slick.min.js"></script>
    <script src="/duan1/js/nouislider.min.js"></script>
    <script src="/duan1/js/jquery.zoom.min.js"></script>
    <script src="/duan1/js/main.js"></script>
</body>

</html>
<!-- JavaScript -->
<script>
const colorButtons = document.querySelectorAll('.color-btn');
const sizeButtons = document.querySelectorAll('.size-btn');

// Xử lý chọn màu
colorButtons.forEach(btn => {
    btn.addEventListener('click', () => {
        colorButtons.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
    });
});

// Xử lý chọn kích thước
sizeButtons.forEach(btn => {
    btn.addEventListener('click', () => {
        sizeButtons.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
    });
});
</script>

<!-- CSS -->
<style>
.color-circle {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    display: inline-block;
    margin-right: 5px;
    border: 2px solid #ccc;
    cursor: pointer;
    transition: border 0.3s ease;
}

.color-circle.active {
    border: 3px solid #007bff;
}

.size-btn.active {
    border: 2px solid #007bff;
    background-color: #e0f0ff;
    font-weight: bold;
}
</style>