<!DOCTYPE html>
<html lang="vi">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Electro - Mẫu giao diện thương mại điện tử</title>

 		<!-- Google font -->
 		<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">
 		<!-- Bootstrap -->
 		<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css"/>
 		<!-- Slick -->
 		<link type="text/css" rel="stylesheet" href="css/slick.css"/>
 		<link type="text/css" rel="stylesheet" href="css/slick-theme.css"/>
 		<!-- nouislider -->
 		<link type="text/css" rel="stylesheet" href="css/nouislider.min.css"/>
 		<!-- Font Awesome Icon -->
 		<link rel="stylesheet" href="css/font-awesome.min.css">
 		<!-- Custom stlylesheet -->
 		<link type="text/css" rel="stylesheet" href="css/style.css"/>
	</head>
	<body>
		<!-- ĐƯỜNG DẪN -->
		<div id="breadcrumb" class="section">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<h3 class="breadcrumb-header">Thanh Toán</h3>
						<ul class="breadcrumb-tree">
							<li><a href="#">Trang Chủ</a></li>
							<li class="active">Thanh Toán</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!-- /ĐƯỜNG DẪN -->

		<!-- PHẦN THANH TOÁN -->
		<div class="section">
			<div class="container">
				<div class="row">
					<div class="col-md-7">
						<!-- Thông tin thanh toán -->
						<div class="billing-details">
							<div class="section-title">
								<h3 class="title">Địa chỉ thanh toán</h3>
							</div>
							<div class="form-group">
								<input class="input" type="text" name="first-name" placeholder="Họ">
							</div>
							<div class="form-group">
								<input class="input" type="text" name="last-name" placeholder="Tên">
							</div>
							<div class="form-group">
								<input class="input" type="email" name="email" placeholder="Email">
							</div>
							<div class="form-group">
								<input class="input" type="text" name="address" placeholder="Địa chỉ">
							</div>
							<div class="form-group">
								<input class="input" type="text" name="city" placeholder="Thành phố">
							</div>
							<div class="form-group">
								<input class="input" type="text" name="country" placeholder="Quốc gia">
							</div>
							<div class="form-group">
								<input class="input" type="text" name="zip-code" placeholder="Mã bưu điện">
							</div>
							<div class="form-group">
								<input class="input" type="tel" name="tel" placeholder="Số điện thoại">
							</div>
						</div>
						<!-- /Thông tin thanh toán -->
					</div>
					<!-- Chi tiết đơn hàng -->
					<div class="col-md-5 order-details">
						<div class="section-title text-center">
							<h3 class="title">Đơn Hàng Của Bạn</h3>
						</div>
						<div class="order-summary">
							<div class="order-col">
								<div><strong>SẢN PHẨM</strong></div>
								<div><strong>TỔNG</strong></div>
							</div>
							<div class="order-products">
								<div class="order-col">
									<div>1x Tên sản phẩm</div>
									<div>$980.00</div>
								</div>
							</div>
							<div class="order-col">
								<div>Giao hàng</div>
								<div><strong>MIỄN PHÍ</strong></div>
							</div>
							<div class="order-col">
								<div><strong>TỔNG CỘNG</strong></div>
								<div><strong class="order-total">$2940.00</strong></div>
							</div>
						</div>
						<a href="#" class="primary-btn order-submit">Đặt Hàng</a>
					</div>
					<!-- /Chi tiết đơn hàng -->
				</div>
			</div>
		</div>
		<!-- /PHẦN THANH TOÁN -->
	</body>
</html>
