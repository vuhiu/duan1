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
    <!-- SECTION -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- Product main img -->
                <div class="col-md-5 col-md-push-2">
                    <div id="product-main-img">
                        <div class="product-preview">
                            <img src="./img/product01.png" alt="">
                        </div>

                        <div class="product-preview">
                            <img src="./img/product03.png" alt="">
                        </div>

                        <div class="product-preview">
                            <img src="./img/product06.png" alt="">
                        </div>

                        <div class="product-preview">
                            <img src="./img/product08.png" alt="">
                        </div>
                    </div>
                </div>
                <!-- /Product main img -->

                <!-- Product thumb imgs -->
                <div class="col-md-2  col-md-pull-5">
                    <div id="product-imgs">
                        <div class="product-preview">
                            <img src="./img/product01.png" alt="">
                        </div>

                        <div class="product-preview">
                            <img src="./img/product03.png" alt="">
                        </div>

                        <div class="product-preview">
                            <img src="./img/product06.png" alt="">
                        </div>

                        <div class="product-preview">
                            <img src="./img/product08.png" alt="">
                        </div>
                    </div>
                </div>
                <!-- /Product thumb imgs -->

                <!-- Product details -->
                <div class="col-md-5">
                    <div class="product-details">
                        <h2 class="product-name">Tên sản phẩm sẽ hiển thị tại đây</h2>
                        <div>
                            <div class="product-rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star-o"></i>
                            </div>
                            <a class="review-link" href="#">10 Đánh giá | Thêm đánh giá của bạn</a>
                        </div>
                        <div>
                            <h3 class="product-price">980.000₫ <del class="product-old-price">990.000₫</del></h3>
                            <span class="product-available">Còn hàng</span>
                        </div>
                        <p>Mô tả sản phẩm ngắn gọn. Bạn có thể thay thế đoạn này bằng thông tin thật của sản phẩm.</p>
                        <div class="product-options">
                            <label>
                                Kích cỡ
                                <select class="input-select">
                                    <option value="0">X</option>
                                </select>
                            </label>
                            <label>
                                Màu sắc
                                <select class="input-select">
                                    <option value="0">Đỏ</option>
                                </select>
                            </label>
                        </div>

                        <div class="add-to-cart">
                            <div class="qty-label">
                                Số lượng
                                <div class="input-number">
                                    <input type="number">
                                    <span class="qty-up">+</span>
                                    <span class="qty-down">-</span>
                                </div>
                            </div>
                            <button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> Thêm vào giỏ</button>
                        </div>

                        <ul class="product-btns">
                            <li><a href="#"><i class="fa fa-heart-o"></i> Yêu thích</a></li>
                            <li><a href="#"><i class="fa fa-exchange"></i> So sánh</a></li>
                        </ul>

                        <ul class="product-links">
                            <li>Danh mục:</li>
                            <li><a href="#">Tai nghe</a></li>
                            <li><a href="#">Phụ kiện</a></li>
                        </ul>

                        <ul class="product-links">
                            <li>Chia sẻ:</li>
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                            <li><a href="#"><i class="fa fa-envelope"></i></a></li>
                        </ul>

                    </div>
                </div>
                <!-- /Product details -->

                <!-- Product tab -->
                <div class="col-md-12">
                    <div id="product-tab">
                        <!-- product tab nav -->
                        <ul class="tab-nav">
                            <li class="active"><a data-toggle="tab" href="#tab1">Mô tả</a></li>
                            <li><a data-toggle="tab" href="#tab2">Chi tiết</a></li>
                            <li><a data-toggle="tab" href="#tab3">Đánh giá (3)</a></li>
                        </ul>
                        <!-- /product tab nav -->

                        <!-- Nội dung tab sản phẩm -->
                        <div class="tab-content">
                            <!-- Thông tin sản phẩm -->
                            <div id="tab1" class="tab-pane fade in active">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p>Chi tiết sản phẩm sẽ được hiển thị tại đây. Bạn có thể thêm mô tả về chất liệu, kích thước, công dụng, bảo hành,...</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Thông số kỹ thuật -->
                            <div id="tab2" class="tab-pane fade in">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p>Thông số kỹ thuật chi tiết của sản phẩm, bao gồm kích thước, trọng lượng, vật liệu, màu sắc, công suất,...</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Đánh giá & Nhận xét -->
                            <div id="tab3" class="tab-pane fade in">
                                <div class="row">
                                    <!-- Đánh giá -->
                                    <div class="col-md-3">
                                        <div id="rating">
                                            <div class="rating-avg">
                                                <span>4.5</span>
                                                <div class="rating-stars">
                                                    <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i>
                                                </div>
                                            </div>
                                            <ul class="rating">
                                                <li>
                                                    <div class="rating-stars"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>
                                                    <div class="rating-progress">
                                                        <div style="width: 80%;"></div>
                                                    </div>
                                                    <span class="sum">3</span>
                                                </li>
                                                <li>
                                                    <div class="rating-stars"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i></div>
                                                    <div class="rating-progress">
                                                        <div style="width: 60%;"></div>
                                                    </div>
                                                    <span class="sum">2</span>
                                                </li>
                                                <!-- Các mức khác -->
                                            </ul>
                                        </div>
                                    </div>

                                    <!-- Nhận xét -->
                                    <div class="col-md-6">
                                        <div id="reviews">
                                            <ul class="reviews">
                                                <li>
                                                    <div class="review-heading">
                                                        <h5 class="name">Nguyễn Văn A</h5>
                                                        <p class="date">27 Tháng 12, 2018 - 8:00 PM</p>
                                                        <div class="review-rating">
                                                            <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o empty"></i>
                                                        </div>
                                                    </div>
                                                    <div class="review-body">
                                                        <p>Sản phẩm rất đẹp và chắc chắn, giao hàng nhanh, đóng gói cẩn thận.</p>
                                                    </div>
                                                </li>
                                                <!-- Thêm nhận xét khác tại đây -->
                                            </ul>
                                            <ul class="reviews-pagination">
                                                <li class="active">1</li>
                                                <li><a href="#">2</a></li>
                                                <li><a href="#">3</a></li>
                                                <li><a href="#"><i class="fa fa-angle-right"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>

                                    <!-- Form gửi nhận xét -->
                                    <div class="col-md-3">
                                        <div id="review-form">
                                            <form class="review-form">
                                                <input class="input" type="text" placeholder="Tên của bạn">
                                                <input class="input" type="email" placeholder="Email của bạn">
                                                <textarea class="input" placeholder="Nội dung nhận xét"></textarea>
                                                <div class="input-rating">
                                                    <span>Đánh giá của bạn: </span>
                                                    <div class="stars">
                                                        <input id="star5" name="rating" value="5" type="radio"><label for="star5"></label>
                                                        <input id="star4" name="rating" value="4" type="radio"><label for="star4"></label>
                                                        <input id="star3" name="rating" value="3" type="radio"><label for="star3"></label>
                                                        <input id="star2" name="rating" value="2" type="radio"><label for="star2"></label>
                                                        <input id="star1" name="rating" value="1" type="radio"><label for="star1"></label>
                                                    </div>
                                                </div>
                                                <button class="primary-btn">Gửi nhận xét</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sản phẩm liên quan -->
                        <div class="section">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="section-title text-center">
                                            <h3 class="title">Sản phẩm liên quan</h3>
                                        </div>
                                    </div>

                                    <!-- Sản phẩm mẫu -->
                                    <div class="col-md-3 col-xs-6">
                                        <div class="product">
                                            <div class="product-img">
                                                <img src="./img/product01.png" alt="">
                                                <div class="product-label"><span class="sale">-30%</span></div>
                                            </div>
                                            <div class="product-body">
                                                <p class="product-category">Danh mục</p>
                                                <h3 class="product-name"><a href="#">Tên sản phẩm</a></h3>
                                                <h4 class="product-price">980.000₫ <del class="product-old-price">990.000₫</del></h4>
                                                <div class="product-rating"></div>
                                                <div class="product-btns">
                                                    <button class="add-to-wishlist"><i class="fa fa-heart-o"></i><span class="tooltipp">Yêu thích</span></button>
                                                    <button class="add-to-compare"><i class="fa fa-exchange"></i><span class="tooltipp">So sánh</span></button>
                                                    <button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">Xem nhanh</span></button>
                                                </div>
                                            </div>
                                            <div class="add-to-cart">
                                                <button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> Thêm vào giỏ</button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Sản phẩm mẫu -->

                                    <!-- Sản phẩm 2 -->
                                    <div class="col-md-3 col-xs-6">
                                        <div class="product">
                                            <div class="product-img">
                                                <img src="./img/product02.png" alt="">
                                                <div class="product-label">
                                                    <span class="new">MỚI</span>
                                                </div>
                                            </div>
                                            <div class="product-body">
                                                <p class="product-category">Danh mục</p>
                                                <h3 class="product-name"><a href="#">Tên sản phẩm 2</a></h3>
                                                <h4 class="product-price">980.000₫ <del class="product-old-price">990.000₫</del></h4>
                                                <div class="product-rating">
                                                    <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                                                </div>
                                                <div class="product-btns">
                                                    <button class="add-to-wishlist"><i class="fa fa-heart-o"></i><span class="tooltipp">Yêu thích</span></button>
                                                    <button class="add-to-compare"><i class="fa fa-exchange"></i><span class="tooltipp">So sánh</span></button>
                                                    <button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">Xem nhanh</span></button>
                                                </div>
                                            </div>
                                            <div class="add-to-cart">
                                                <button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> Thêm vào giỏ</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="clearfix visible-sm visible-xs"></div>

                                    <!-- Sản phẩm 3 -->
                                    <div class="col-md-3 col-xs-6">
                                        <div class="product">
                                            <div class="product-img">
                                                <img src="./img/product03.png" alt="">
                                            </div>
                                            <div class="product-body">
                                                <p class="product-category">Danh mục</p>
                                                <h3 class="product-name"><a href="#">Tên sản phẩm 3</a></h3>
                                                <h4 class="product-price">980.000₫ <del class="product-old-price">990.000₫</del></h4>
                                                <div class="product-rating">
                                                    <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i>
                                                </div>
                                                <div class="product-btns">
                                                    <button class="add-to-wishlist"><i class="fa fa-heart-o"></i><span class="tooltipp">Yêu thích</span></button>
                                                    <button class="add-to-compare"><i class="fa fa-exchange"></i><span class="tooltipp">So sánh</span></button>
                                                    <button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">Xem nhanh</span></button>
                                                </div>
                                            </div>
                                            <div class="add-to-cart">
                                                <button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> Thêm vào giỏ</button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Sản phẩm 4 -->
                                    <div class="col-md-3 col-xs-6">
                                        <div class="product">
                                            <div class="product-img">
                                                <img src="./img/product04.png" alt="">
                                            </div>
                                            <div class="product-body">
                                                <p class="product-category">Danh mục</p>
                                                <h3 class="product-name"><a href="#">Tên sản phẩm 4</a></h3>
                                                <h4 class="product-price">980.000₫ <del class="product-old-price">990.000₫</del></h4>
                                                <div class="product-rating"></div>
                                                <div class="product-btns">
                                                    <button class="add-to-wishlist"><i class="fa fa-heart-o"></i><span class="tooltipp">Yêu thích</span></button>
                                                    <button class="add-to-compare"><i class="fa fa-exchange"></i><span class="tooltipp">So sánh</span></button>
                                                    <button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">Xem nhanh</span></button>
                                                </div>
                                            </div>
                                            <div class="add-to-cart">
                                                <button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> Thêm vào giỏ</button>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>

                        <!-- Bản tin -->
                        <div id="newsletter" class="section">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="newsletter">
                                            <p>Đăng ký nhận <strong>BẢN TIN</strong></p>
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
                        <!-- jQuery Plugins -->
                        <script src="js/jquery.min.js"></script>
                        <script src="js/bootstrap.min.js"></script>
                        <script src="js/slick.min.js"></script>
                        <script src="js/nouislider.min.js"></script>
                        <script src="js/jquery.zoom.min.js"></script>
                        <script src="js/main.js"></script>
</body>

</html>