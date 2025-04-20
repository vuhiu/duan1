<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>Electro - HTML Ecommerce Template</title>

    <!-- <base> sẽ giúp các đường dẫn tương đối được hiểu đúng dù bạn ở bất kỳ trang nào. -->
    <base href="http://localhost/duan1/" />
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

    <!-- Custom stlylesheet -->
    <link type="text/css" rel="stylesheet" href="/duan1/css/style.css" />

    <style>
        .cart-link {
            display: flex;
            align-items: center;
            color: #2B2D42;
            text-decoration: none;
            cursor: pointer;
        }

        .cart-link:hover {
            color: #D10024;
            text-decoration: none;
        }

        .cart-link i {
            font-size: 18px;
            margin-right: 5px;
        }

        .cart-link .qty {
            position: absolute;
            right: -8px;
            top: -10px;
            width: 20px;
            height: 20px;
            line-height: 20px;
            text-align: center;
            border-radius: 50%;
            font-size: 10px;
            color: #FFF;
            background-color: #D10024;
        }

        .dropdown:hover .cart-dropdown {
            opacity: 1;
            visibility: visible;
        }
    </style>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

</head>

<body>
    <!-- HEADER -->
    <header>
        <!-- TOP HEADER -->
        <div id="top-header">
            <div class="container">
                <ul class="header-links pull-left">
                    <li><a href="#"><i class="fa fa-phone"></i> +021-95-51-84</a></li>
                    <li><a href="#"><i class="fa fa-envelope-o"></i> email@email.com</a></li>
                    <li><a href="#"><i class="fa fa-map-marker"></i> Hà Nội, Việt Nam</a></li>
                </ul>
                <ul class="header-links pull-right">
                    
                    <?php
                    if (session_status() === PHP_SESSION_NONE) {
                        session_start();
                    }
                    if (isset($_SESSION['user_name'])) {
                        echo '<li><a href="/duan1/client/views/auth/user-profile.php"><i class="fa fa-user"></i> ' . htmlspecialchars($_SESSION['user_name']) . '</a></li>';
                        echo '<li><a href="/duan1/client/controllers/authenController.php?action=logout"><i class="fa fa-sign-out"></i> Đăng xuất</a></li>';
                    } else {
                        echo '<li><a href="/duan1/client/views/auth/form-login.php"><i class="fa fa-sign-in"></i> Đăng nhập</a></li>';
                        echo '<li><a href="/duan1/client/views/auth/form-register.php"><i class="fa fa-user-plus"></i> Đăng ký</a></li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
        <!-- /TOP HEADER -->

        <!-- MAIN HEADER -->
        <div id="header">
            <!-- container -->
            <div class="container">
                <!-- row -->
                <div class="row">
                    <!-- LOGO -->
                    <div class="col-md-3">
                        <div class="header-logo">
                            <a href="#" class="logo">
                                <img src="./img/logo.png" alt="">
                            </a>
                        </div>
                    </div>
                    <!-- /LOGO -->

                    <!-- SEARCH BAR -->
                    <div class="col-md-6">
                        <div class="header-search">
                            <form action="/duan1/index.php" method="GET">
                                <input type="hidden" name="act" value="search">
                                <select class="input-select">
                                    <option value="0">Danh mục</option>
                                    <option value="1"> iphone</option>
                                    <option value="2"> SamSung</option>
                                    <option value="3"> macbook</option>
                                    <option value="4"> phụ kiện </option>
                                </select>
                                <input class="input" placeholder="Tìm kiếm sản phẩm" name="keyword" required>
                                <button class="search-btn"> Tìm kiếm</button>
                            </form>
                        </div>
                    </div>
                    <!-- /SEARCH BAR -->

                    <!-- ACCOUNT -->
                    <div class="col-md-3 clearfix">
                        <div class="header-ctn">
                            <!-- Wishlist -->
                            <div>
                                <a href="#">
                                    <i class="fa fa-heart-o"></i>
                                    <span> Yêu thích</span>
                                    <div class="qty">2</div>
                                </a>
                            </div>
                            <!-- /Wishlist -->

                            <!-- Cart -->
                            <div class="dropdown">
                                <a href="/duan1/index.php?act=cart&page=list" class="cart-link">
                                    <i class="fa fa-shopping-cart"></i>
                                    <span>Giỏ hàng</span>
                                    <div class="qty" id="cart-count">0</div>
                                </a>
                                <div class="cart-dropdown">
                                    <div class="cart-list" id="cart-items">
                                        <!-- Cart items will be loaded here -->
                                    </div>
                                    <div class="cart-summary">
                                        <small>Giỏ hàng</small>
                                        <h5>Tổng tiền: <span id="cart-total">0₫</span></h5>
                                    </div>
                                    <div class="cart-btns">
                                        <a href="/duan1/index.php?act=cart&page=list">Xem giỏ hàng</a>
                                        <a href="/duan1/index.php?act=order&page=list">Xem đơn hàng</a>
                                    </div>
                                </div>
                            </div>
                            <!-- /Cart -->

                           

                            <!-- Menu Toogle -->
                            <div class="menu-toggle">
                                <a href="#">
                                    <i class="fa fa-bars"></i>
                                    <span> Menu</span>
                                </a>
                            </div>
                            <!-- /Menu Toogle -->
                        </div>
                    </div>
                    <!-- /ACCOUNT -->
                </div>
                <!-- row -->
            </div>
            <!-- container -->
        </div>
        <!-- /MAIN HEADER -->
    </header>
    <!-- /HEADER -->

    <!-- NAVIGATION -->
    <nav id="navigation">
        <!-- container -->
        <div class="container">
            <!-- responsive-nav -->
            <div id="responsive-nav">
                <!-- NAV -->
                <ul class="main-nav nav navbar-nav">
                    <li class="active"><a href="/duan1/index.php?act=category&category_id=14">Trang chủ</a></li>
                    <!-- <li><a href="#">Ưu đãi hot</a></li> -->
                    <!-- <li><a href="/duan1/index.php?act=category">Danh mục</a></li> -->
                    <li><a href="/duan1/index.php?act=category&category_id=14">Laptop</a></li>
                    <li><a href="/duan1/index.php?act=category&category_id=34">iPhone</a></li>
                    <li><a href="/duan1/index.php?act=category&category_id=36">Samsung</a></li>
                    <!-- Dropdown cho Điện thoại -->
                    <!-- <li class="dropdown">
                        <a href="/duan1/index.php?act=category&category_id=38" class="dropdown-toggle" data-toggle="dropdown">Điện thoại <span
                                class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="/duan1/index.php?act=category&category_id=34">iPhone</a></li>
                            <li><a href="/duan1/index.php?act=category&category_id=36">Samsung</a></li>
                        </ul>
                    </li> -->
                    <!-- <li><a href="#">Máy ảnh</a></li> -->
                    <li><a href="/duan1/index.php?act=category&category_id=35">Phụ kiện</a></li>
                </ul>
                <!-- /NAV -->
            </div>
            <!-- /responsive-nav -->
        </div>
        <!-- /container -->
    </nav>
    <!-- /NAVIGATION -->

    <!-- SECTION -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- shop -->
                <div class="col-md-4 col-xs-6">
                    <div class="shop">
                        <div class="shop-img">
                            <img src="./img/shop01.png" alt="">
                        </div>
                        <div class="shop-body">
                            <h3>Laptop<br>Collection</h3>
                            <a href="#" class="cta-btn">Shop now <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <!-- /shop -->

                <!-- shop -->
                <div class="col-md-4 col-xs-6">
                    <div class="shop">
                        <div class="shop-img">
                            <img src="./img/shop03.png" alt="">
                        </div>
                        <div class="shop-body">
                            <h3>Accessories<br>Collection</h3>
                            <a href="#" class="cta-btn">Shop now <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <!-- /shop -->

                <!-- shop -->
                <div class="col-md-4 col-xs-6">
                    <div class="shop">
                        <div class="shop-img">
                            <img src="./img/shop02.png" alt="">
                        </div>
                        <div class="shop-body">
                            <h3>Cameras<br>Collection</h3>
                            <a href="#" class="cta-btn">Shop now <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <!-- /shop -->
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /SECTION -->

    <!-- jQuery Plugins -->
    <script src="/duan1/js/jquery.min.js"></script>
    <script src="/duan1/js/bootstrap.min.js"></script>
    <script src="/duan1/js/slick.min.js"></script>
    <script src="/duan1/js/nouislider.min.js"></script>
    <script src="/duan1/js/jquery.zoom.min.js"></script>
    <script src="/duan1/js/main.js"></script>

    <!-- Add this before closing body tag -->
    <script>
    // Hàm cập nhật giỏ hàng
    function updateCart() {
        fetch('/duan1/index.php?act=cart&page=info')
            .then(response => {
                if (!response.ok) {
                    if (response.status === 401) {
                        updateEmptyCart();
                        return null;
                    }
                    throw new Error('Network response was not ok');
                }
                return response.text().then(text => {
                    try {
                        return JSON.parse(text);
                    } catch (e) {
                        console.error('Invalid JSON:', text);
                        throw new Error('Invalid JSON response');
                    }
                });
            })
            .then(data => {
                if (!data) return;
                if (data.error) {
                    console.error('Error:', data.error);
                    updateEmptyCart();
                    return;
                }

                // Cập nhật số lượng
                document.getElementById('cart-count').textContent = data.count || 0;

                // Cập nhật danh sách sản phẩm
                const cartItems = document.getElementById('cart-items');
                if (data.items && data.items.length > 0) {
                    cartItems.innerHTML = data.items.map(item => `
                        <div class="product-widget">
                            <div class="product-img">
                                <img src="/duan1/upload/${item.product_image}" alt="${item.product_name}">
                            </div>
                            <div class="product-body">
                                <h3 class="product-name">
                                    <a href="/duan1/index.php?act=product&page=detail&product_id=${item.product_id}">
                                        ${item.product_name}
                                    </a>
                                </h3>
                                <h4 class="product-price">
                                    <span class="qty">${item.quantity}x</span>
                                    ${Number(item.sale_price > 0 ? item.sale_price : item.price).toLocaleString()}₫
                                </h4>
                            </div>
                            <button class="delete" onclick="removeFromCart(${item.cart_item_id})">
                                <i class="fa fa-close"></i>
                            </button>
                        </div>
                    `).join('');
                } else {
                    cartItems.innerHTML = '<div class="empty-cart">Giỏ hàng trống</div>';
                }

                // Cập nhật tổng tiền
                document.getElementById('cart-total').textContent = 
                    Number(data.total || 0).toLocaleString() + '₫';
            })
            .catch(error => {
                console.error('Error:', error);
                updateEmptyCart();
            });
    }

    // Hàm cập nhật trạng thái giỏ hàng trống
    function updateEmptyCart() {
        document.getElementById('cart-count').textContent = '0';
        document.getElementById('cart-items').innerHTML = 
            '<div class="empty-cart">Giỏ hàng trống</div>';
        document.getElementById('cart-total').textContent = '0₫';
    }

    // Cập nhật giỏ hàng khi trang web load
    document.addEventListener('DOMContentLoaded', updateCart);

    // Thêm hàm này vào window để có thể gọi từ các trang khác
    window.updateCartCount = updateCart;

    // Thêm CSS cho trường hợp giỏ hàng trống
    const style = document.createElement('style');
    style.textContent = `
        .empty-cart {
            padding: 20px;
            text-align: center;
            color: #666;
        }
    `;
    document.head.appendChild(style);
    </script>
</body>

</html>