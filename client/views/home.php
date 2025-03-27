<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>Electro - HTML Ecommerce Template</title>

    <!-- Google font -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">

    <!-- Bootstrap -->
    <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" />

    <!-- Slick -->
    <link type="text/css" rel="stylesheet" href="css/slick.css" />
    <link type="text/css" rel="stylesheet" href="css/slick-theme.css" />

    <!-- nouislider -->
    <link type="text/css" rel="stylesheet" href="css/nouislider.min.css" />

    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="css/font-awesome.min.css">

    <!-- Custom stlylesheet -->
    <link type="text/css" rel="stylesheet" href="css/style.css" />

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

</head>

<body>
    <!-- PHẦN -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- hàng -->
            <div class="row">

                <!-- tiêu đề phần -->
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
                <!-- /tiêu đề phần -->

                <!-- Tab sản phẩm & slick -->
                <div class="col-md-12">
                    <div class="row">
                        <div class="products-tabs">
                            <!-- tab -->
                            <div id="tab1" class="tab-pane active">
                                <div class="products-slick" data-nav="#slick-nav-1">
                                    <!-- sản phẩm -->
                                    <div class="product">
                                        <div class="product-img">
                                            <img src="./img/product01.png" alt="">
                                            <div class="product-label">
                                                <span class="sale">-30%</span>
                                                <span class="new">MỚI</span>
                                            </div>
                                        </div>
                                        <div class="product-body">
                                            <p class="product-category">Danh mục</p>
                                            <h3 class="product-name"><a href="#">Tên sản phẩm</a></h3>
                                            <h4 class="product-price">$980.00 <del class="product-old-price">$990.00</del></h4>
                                            <div class="product-rating">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </div>
                                            <div class="product-btns">
                                                <button class="add-to-wishlist"><i class="fa fa-heart-o"></i><span class="tooltipp">Thêm vào yêu thích</span></button>
                                                <button class="add-to-compare"><i class="fa fa-exchange"></i><span class="tooltipp">So sánh</span></button>
                                                <button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">Xem nhanh</span></button>
                                            </div>
                                        </div>
                                        <div class="add-to-cart">
                                            <button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> Thêm vào giỏ</button>
                                        </div>
                                    </div>
                                    <!-- /sản phẩm -->
                                </div>
                                <div id="slick-nav-1" class="products-slick-nav"></div>
                            </div>
                            <!-- /tab -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
                   <!-- SẢN PHẨM NỔI BẬT -->
    </div>
    <!-- /DÒNG -->
</div>
<!-- /CONTAINER -->
</div>
<!-- /PHẦN -->

<!-- PHẦN KHUYẾN MÃI HOT -->
<div id="hot-deal" class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
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
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /PHẦN KHUYẾN MÃI HOT -->

<!-- PHẦN -->
<div class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">

            <!-- tiêu đề phần -->
            <div class="col-md-12">
                <div class="section-title">
                    <h3 class="title">Bán chạy nhất</h3>
                    <div class="section-nav">
                        <ul class="section-tab-nav tab-nav">
                            <li class="active"><a data-toggle="tab" href="#tab2">Laptop</a></li>
                            <li><a data-toggle="tab" href="#tab2">Điện thoại</a></li>
                            <li><a data-toggle="tab" href="#tab2">Máy ảnh</a></li>
                            <li><a data-toggle="tab" href="#tab2">Phụ kiện</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /tiêu đề phần -->

            <!-- Tab sản phẩm & slick -->
            <div class="col-md-12">
                <div class="row">
                    <div class="products-tabs">
                        <!-- tab -->
                        <div id="tab2" class="tab-pane fade in active">
                            <div class="products-slick" data-nav="#slick-nav-2">
                                <!-- sản phẩm -->
                                <div class="product">
                                    <div class="product-img">
                                        <img src="./img/product06.png" alt="">
                                        <div class="product-label">
                                            <span class="sale">-30%</span>
                                            <span class="new">MỚI</span>
                                        </div>
                                    </div>
                                    <div class="product-body">
                                        <p class="product-category">Danh mục</p>
                                        <h3 class="product-name"><a href="#">Tên sản phẩm</a></h3>
                                        <h4 class="product-price">$980.00 <del class="product-old-price">$990.00</del></h4>
                                        <div class="product-rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                        <div class="product-btns">
                                            <button class="add-to-wishlist"><i class="fa fa-heart-o"></i><span class="tooltipp">Thêm vào yêu thích</span></button>
                                            <button class="add-to-compare"><i class="fa fa-exchange"></i><span class="tooltipp">Thêm vào so sánh</span></button>
                                            <button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">Xem nhanh</span></button>
                                        </div>
                                    </div>
                                    <div class="add-to-cart">
                                        <button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> Thêm vào giỏ hàng</button>
                                    </div>
                                </div>
                                <!-- /sản phẩm -->
                            </div>
                            <div id="slick-nav-2" class="products-slick-nav"></div>
                        </div>
                        <!-- /tab -->
                    </div>
                </div>
            </div>
            <!-- /Tab sản phẩm & slick -->
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
      <!-- PHẦN -->
      <div class="section">
        <!-- container -->
        <div class="container">
            <!-- hàng -->
            <div class="row">
                <div class="col-md-4 col-xs-6">
                    <div class="section-title">
                        <h4 class="title">Bán chạy nhất</h4>
                        <div class="section-nav">
                            <div id="slick-nav-3" class="products-slick-nav"></div>
                        </div>
                    </div>

                    <div class="products-widget-slick" data-nav="#slick-nav-3">
                        <div>
                            <!-- sản phẩm nhỏ -->
                            <div class="product-widget">
                                <div class="product-img">
                                    <img src="./img/product07.png" alt="">
                                </div>
                                <div class="product-body">
                                    <p class="product-category">Danh mục</p>
                                    <h3 class="product-name"><a href="#">Tên sản phẩm</a></h3>
                                    <h4 class="product-price">$980.00 <del class="product-old-price">$990.00</del></h4>
                                </div>
                            </div>
                            <!-- /sản phẩm nhỏ -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- /hàng -->
        </div>
        <!-- /container -->
    </div>
    <!-- /PHẦN -->

    <!-- BẢN TIN -->
    <div id="newsletter" class="section">
        <!-- container -->
        <div class="container">
            <!-- hàng -->
            <div class="row">
                <div class="col-md-12">
                    <div class="newsletter">
                        <p>Đăng ký để nhận <strong>BẢN TIN</strong></p>
                        <form>
                            <input class="input" type="email" placeholder="Nhập email của bạn">
                            <button class="newsletter-btn"><i class="fa fa-envelope"></i> Đăng ký</button>
                        </form>
                        <ul class="newsletter-follow">
                            <li>
                                <a href="#"><i class="fa fa-facebook"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-instagram"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-pinterest"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /hàng -->
        </div>
        <!-- /container -->
    </div>
    <!-- /BẢN TIN -->

    <!-- Các Plugin jQuery -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/slick.min.js"></script>
    <script src="js/nouislider.min.js"></script>
    <script src="js/jquery.zoom.min.js"></script>
    <script src="js/main.js"></script>

</body>
</html>
