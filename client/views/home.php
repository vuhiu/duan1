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
                        <div class="section-nav">
                            <ul class="section-tab-nav tab-nav">
                                <li class="active"><a data-toggle="tab" href="#tab1">Laptop</a></li>
                                <li><a data-toggle="tab" href="#tab1">Điện thoại</a></li>
                                <li><a data-toggle="tab" href="#tab1">Máy ảnh</a></li>
                                <li><a data-toggle="tab" href="#tab1">Phụ kiện</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Section Title -->

                <!-- Product List -->
                <div class="col-md-12">
                    <div class="row">
                        <div class="products-tabs">
                            <div id="tab1" class="tab-pane active">
                                <!-- filepath: c:\xampp\htdocs\duan1\client\views\home.php -->
                                <div class="products-slick" data-nav="#slick-nav-1">
                                    <?php foreach ($products as $product): ?>
                                        <div class="col-md-4">
                                            <div class="product">
                                                <div class="product-img">
                                                    <img src="/duan1/upload/<?= htmlspecialchars($product['product_image']) ?>" alt="Ảnh sản phẩm">
                                                </div>
                                                <div class="product-body">
                                                    <p class="product-category"><?= htmlspecialchars($product['category_name']) ?></p>
                                                    <h3 class="product-name">
                                                        <a href="/duan1/index.php?act=product&product_id=<?= $product['product_id'] ?>">
                                                            <?= htmlspecialchars($product['product_name']) ?>
                                                        </a>
                                                    </h3>
                                                    <!-- filepath: c:\xampp\htdocs\duan1\client\views\home.php -->
                                                    <h4 class="product-price">
                                                        <?php if (!empty($product['product_sale_price'])): ?>
                                                            <span><?= number_format($product['product_sale_price'], 0, ',', '.') ?>₫</span>
                                                            <del class="product-old-price"><?= number_format($product['product_price'], 0, ',', '.') ?>₫</del>
                                                        <?php else: ?>
                                                            <span><?= number_format($product['product_price'], 0, ',', '.') ?>₫</span>
                                                        <?php endif; ?>
                                                    </h4>
                                                    <ul>
                                                        <?php foreach ($product['variants'] as $variant): ?>
                                                            <li>
                                                                Màu: <?= htmlspecialchars($variant['product_variant_color']) ?>,
                                                                Kích thước: <?= htmlspecialchars($variant['product_variant_size']) ?>
                                                            </li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>

                                </div>
                                <div id="slick-nav-1" class="products-slick-nav"></div>
                            </div>
                        </div>
                        <!-- form gửi dữ liệu sp vào giỏ hàng khi nhấn nút "Thêm vào giỏ hàng" -->




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