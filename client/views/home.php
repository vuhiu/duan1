<!-- filepath: c:\xampp\htdocs\duan1\client\views\home.php -->
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Trang chủ</title>

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
    <style>
        .product-description {
            font-size: 14px;
            color: #666;
            margin: 10px 0;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            min-height: 40px;
        }
    </style>
</head>

<body>
    <!-- SECTION: Banner -->
    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="main-banner">
                        <div class="banner-slider">
                            <div class="banner-item">
                                <img src="/duan1/upload/banner1.avif" alt="Laptop Collection">
                                <div class="banner-content">
                                    <h2>Laptop Collection</h2>
                                    <p>MacBook, Laptop Gaming, Dell, Asus</p>
                                    <a href="/duan1/index.php?act=category&category_id=14" class="btn-shop">SHOP NOW</a>
                                </div>
                            </div>
                            <div class="banner-item">
                                <img src="/duan1/upload/banner2.jpg" alt="Accessories Collection">
                                <div class="banner-content">
                                    <h2>Phụ kiện</h2>
                                    <p>Sạc, Tai nghe, Cáp</p>
                                    <a href="/duan1/index.php?act=category&category_id=35" class="btn-shop">SHOP NOW</a>
                                </div>
                            </div>
                            <div class="banner-item">
                                <img src="/duan1/upload/banner3.jpg" alt="Cameras Collection">
                                <div class="banner-content">
                                    <h2>SamSung</h2>
                                    <p>Galaxy S24, Galaxy Z</p>
                                    <a href="/duan1/index.php?act=category&category_id=36" class="btn-shop">SHOP NOW</a>
                                </div>
                            </div>
                            <div class="banner-item">
                                <img src="/duan1/upload/banner4.jpg" alt="Cameras Collection">
                                <div class="banner-content">
                                    <h2>Apple</h2>
                                    <p>Iphone 15, Iphone 14, Iphone 13</p>
                                    <a href="/duan1/index.php?act=category&category_id=34" class="btn-shop">SHOP NOW</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /SECTION: Banner -->

    <!-- SECTION: Sản phẩm mới -->
    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title">
                        <h3 class="title">Sản phẩm mới</h3>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="products-tabs">
                            <div id="tab1" class="tab-pane active">
                                <div class="products-slick" data-nav="#slick-nav-1">
                                    <?php foreach ($products as $product): ?>
                                    <div class="col-md-3">
                                        <div class="product-item">
                                            <div class="product-img">
                                                <img src="/duan1/upload/<?= htmlspecialchars($product['product_image']) ?>"
                                                    alt="<?= htmlspecialchars($product['product_name']) ?>">
                                                <div class="product-label">
                                                    <?php if (!empty($product['product_sale_price'])): ?>
                                                    <span class="sale">-<?= round((($product['product_price'] - $product['product_sale_price']) / $product['product_price']) * 100) ?>%</span>
                                                    <?php endif; ?>
                                                    <span class="new">Mới</span>
                                                </div>
                                            </div>
                                            <div class="product-body">
                                                <p class="product-category"><?= htmlspecialchars($product['category_name']) ?></p>
                                                <h3 class="product-name">
                                                    <a href="/duan1/index.php?act=product&page=detail&product_id=<?= $product['product_id'] ?>">
                                                        <?= htmlspecialchars($product['product_name']) ?>
                                                    </a>
                                                </h3>
                                                <h4 class="product-price">
                                                    <?php if (!empty($product['product_sale_price'])): ?>
                                                    <span class="sale-price"><?= number_format($product['product_sale_price'], 0, ',', '.') ?>₫</span>
                                                    <del class="old-price"><?= number_format($product['product_price'], 0, ',', '.') ?>₫</del>
                                                    <?php else: ?>
                                                    <span class="price"><?= number_format($product['product_price'], 0, ',', '.') ?>₫</span>
                                                    <?php endif; ?>
                                                </h4>
                                                <p class="product-description"><?= htmlspecialchars($product['product_description'] ?? 'Không có mô tả') ?></p>
                                                <div class="product-btns">
                                                    <button class="add-to-wishlist"><i class="fa fa-heart-o"></i></button>
                                                    <button class="quick-view"><i class="fa fa-eye"></i></button>
                                                </div>
                                            </div>
                                            <div class="add-to-cart">
                                                <a href="/duan1/index.php?act=product&page=detail&product_id=<?= $product['product_id'] ?>" class="btn btn-primary view-detail-btn">
                                                    <i class="fa fa-eye"></i> Xem chi tiết
                                                </a>
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
            </div>
        </div>
    </div>
    <!-- /SECTION: Sản phẩm mới -->

    <!-- SECTION: Sản phẩm bán chạy -->
    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title">
                        <h3 class="title">Sản phẩm bán chạy</h3>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="products-tabs">
                            <div id="tab2" class="tab-pane active">
                                <div class="products-slick" data-nav="#slick-nav-2">
                                    <?php foreach ($products as $product): ?>
                                    <div class="col-md-3">
                                        <div class="product-item">
                                            <div class="product-img">
                                                <img src="/duan1/upload/<?= htmlspecialchars($product['product_image']) ?>"
                                                    alt="<?= htmlspecialchars($product['product_name']) ?>">
                                                <div class="product-label">
                                                    <span class="best-seller">Bán chạy</span>
                                                </div>
                                            </div>
                                            <div class="product-body">
                                                <p class="product-category"><?= htmlspecialchars($product['category_name']) ?></p>
                                                <h3 class="product-name">
                                                    <a href="/duan1/index.php?act=product&product_id=<?= $product['product_id'] ?>" data-id="<?= $product['product_id'] ?>">
                                                        <?= htmlspecialchars($product['product_name']) ?>
                                                    </a>
                                                </h3>
                                                <h4 class="product-price">
                                                    <?php if (!empty($product['product_sale_price'])): ?>
                                                    <span class="sale-price"><?= number_format($product['product_sale_price'], 0, ',', '.') ?>₫</span>
                                                    <del class="old-price"><?= number_format($product['product_price'], 0, ',', '.') ?>₫</del>
                                                    <?php else: ?>
                                                    <span class="price"><?= number_format($product['product_price'], 0, ',', '.') ?>₫</span>
                                                    <?php endif; ?>
                                                </h4>
                                                <p class="product-description"><?= htmlspecialchars($product['product_description'] ?? 'Không có mô tả') ?></p>
                                                <div class="product-btns">
                                                    <button class="add-to-wishlist"><i class="fa fa-heart-o"></i></button>
                                                    <button class="quick-view"><i class="fa fa-eye"></i></button>
                                                </div>
                                            </div>
                                            <div class="add-to-cart">
                                                <button class="add-to-cart-btn" data-id="<?= $product['product_id'] ?>">
                                                    <i class="fa fa-shopping-cart"></i> Thêm vào giỏ
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                                <div id="slick-nav-2" class="products-slick-nav"></div>
                                </div>
                                </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /SECTION: Sản phẩm bán chạy -->

    <!-- SECTION: Đăng ký nhận tin -->
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
    <!-- /SECTION: Đăng ký nhận tin -->

    <style>
    /* Custom styles */
    .product-item {
        border: 1px solid #eee;
        border-radius: 12px;
        padding: 15px;
        margin-bottom: 20px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        transition: 0.3s;
    }
    .product-item:hover {
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .product-img {
        text-align: center;
        height: 200px;
        position: relative;
    }
    .product-img img {
        max-height: 100%;
        object-fit: contain;
    }
    .product-label {
        position: absolute;
        top: 10px;
        right: 10px;
    }
    .product-label span {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 4px;
        color: #fff;
        font-size: 12px;
        margin-left: 5px;
    }
    .product-label .sale {
        background-color: #ff4d4d;
    }
    .product-label .new {
        background-color:rgb(233, 84, 20);
    }
    .product-label .best-seller {
        background-color: #ff9800;
    }
    .product-body {
        padding-top: 15px;
    }
    .product-category {
        font-size: 13px;
        color: #888;
        text-transform: uppercase;
    }
    .product-name {
        font-size: 16px;
        font-weight: bold;
        min-height: 48px;
    }
    .product-name a {
        color: #333;
        text-decoration: none;
    }
    .product-price {
        margin-top: 5px;
        margin-bottom: 10px;
    }
    .sale-price {
        color: #ff4d4d;
        font-weight: bold;
    }
    .old-price {
        margin-left: 5px;
        color: #888;
    }
    .product-btns {
        display: flex;
        justify-content: space-between;
        margin-top: 10px;
    }
    .product-btns button {
        background: none;
        border: none;
        color: #888;
        cursor: pointer;
    }
    .product-btns button:hover {
        color: #333;
    }
    .add-to-cart {
        margin-top: 15px;
    }
    .add-to-cart-btn {
        width: 100%;
        padding: 10px;
        background-color:#D21737;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    .add-to-cart-btn:hover {
        background-color:rgb(134, 4, 25);
    }

    /* Banner styles */
    .main-banner {
        margin-bottom: 30px;
    }
    .banner-slider {
        position: relative;
    }
    .banner-item {
        position: relative;
        height: 400px;
        overflow: hidden;
        border-radius: 12px;
    }
    .banner-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .banner-content {
        position: absolute;
        top: 50%;
        left: 50px;
        transform: translateY(-50%);
        color: #fff;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }
    .banner-content h2 {
        font-size: 48px;
        font-weight: bold;
        margin-bottom: 10px;
        text-transform: uppercase;
    }
    .banner-content p {
        font-size: 24px;
        margin-bottom: 20px;
        opacity: 0.9;
    }
    .btn-shop {
        display: inline-block;
        padding: 12px 30px;
        background-color: #D10024;
        color: #fff;
        text-decoration: none;
        border-radius: 25px;
        font-weight: bold;
        transition: 0.3s;
        text-transform: uppercase;
    }
    .btn-shop:hover {
        background-color: #A70017;
        color: #fff;
        transform: translateY(-2px);
    }

    /* Slick slider custom styles */
    .slick-dots {
        bottom: 20px;
    }
    .slick-dots li button:before {
        color: #fff;
        font-size: 12px;
    }
    .slick-dots li.slick-active button:before {
        color: #D10024;
    }
    .slick-prev, .slick-next {
        z-index: 1;
        width: 40px;
        height: 40px;
    }
    .slick-prev {
        left: 20px;
    }
    .slick-next {
        right: 20px;
    }
    .slick-prev:before, .slick-next:before {
        font-size: 40px;
    }
    .view-detail-btn {
        width: 100%;
        padding: 10px;
        background-color: #D21737;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        text-align: center;
        transition: background-color 0.3s;
    }

    .view-detail-btn:hover {
        background-color: rgb(134, 4, 25);
        color: #fff;
        text-decoration: none;
    }
    </style>

    <!-- jQuery Plugins -->
    <script src="/duan1/js/jquery.min.js"></script>
    <script src="/duan1/js/bootstrap.min.js"></script>
    <script src="/duan1/js/slick.min.js"></script>
    <script src="/duan1/js/nouislider.min.js"></script>
    <script src="/duan1/js/jquery.zoom.min.js"></script>
    <script src="/duan1/js/main.js"></script>

    <!-- Add Slick Slider initialization -->
    <script>
    $(document).ready(function(){
        $('.banner-slider').slick({
            autoplay: true,
            autoplaySpeed: 5000,
            dots: true,
            arrows: true,
            infinite: true,
            speed: 500,
            fade: true,
            cssEase: 'linear'
        });
    });
    </script>
</body>

</html>