<!-- filepath: c:\laragon\www\duan1\client\views\home.php -->
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
    <link rel="stylesheet" href="css/font-awesome.min.css">

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
                            <div class="products-slick" data-nav="#slick-nav-1">
                                <?php
                                // Include the ProductModel and fetch products
                                require_once __DIR__ . '/../models/ProductModel.php';
                                $productModel = new Product();
                                $products = $productModel->getAllProduct();

                                // Loop through the products and display them
                                foreach ($products as $product): 
                                    $image = htmlspecialchars($product['image'] ?? 'default.jpg');
                                    $categoryName = htmlspecialchars($product['category_name'] ?? 'Không xác định');
                                    $productName = htmlspecialchars($product['name'] ?? 'Không xác định');
                                    $salePrice = $product['sale_price'] ?? 0;
                                    $price = $product['price'] ?? 0;
                                ?>
                                    <div class="col-md-4">
                                        <div class="product">
                                            <div class="product-img">
                                                <img src="/duan1/upload/<?= $image ?>" alt="Ảnh sản phẩm">
                                                <div class="product-label">
                                                    <?php if ($salePrice < $price): ?>
                                                        <span class="sale">-<?= round((($price - $salePrice) / $price) * 100) ?>%</span>
                                                    <?php endif; ?>
                                                    <span class="new">MỚI</span>
                                                </div>
                                            </div>
                                            <div class="product-body">
                                                <p class="product-category"><?= $categoryName ?></p>
                                                <h3 class="product-name"><a href="#"><?= $productName ?></a></h3>
                                                <h4 class="product-price">
                                                    <?= number_format($salePrice, 0, ',', '.') ?>₫
                                                    <?php if ($salePrice < $price): ?>
                                                        <del class="product-old-price"><?= number_format($price, 0, ',', '.') ?>₫</del>
                                                    <?php endif; ?>
                                                </h4>
                                                <div class="product-rating">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star-o"></i>
                                                </div>
                                                <div class="product-btns">
                                                    <button class="add-to-wishlist"><i class="fa fa-heart-o"></i><span class="tooltipp">Thêm vào yêu thích</span></button>
                                                    <button class="add-to-compare"><i class="fa fa-exchange"></i><span class="tooltipp">So sánh</span></button>
                                                    <button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">Xem nhanh</span></button>
                                                </div>
                                            </div>
                                            <div class="add-to-cart">
                                                <form action="/duan1/client/views/addToCart.php" method="POST">
                                                    <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?? 1; ?>">
                                                    <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                                                    <input type="hidden" name="variant_id" value="<?= $product['variant_id'] ?? 0; ?>">
                                                    <input type="hidden" name="quantity" value="1">
                                                    <button type="submit" class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> Thêm vào giỏ</button>
                                                </form>
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