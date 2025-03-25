<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Siêu Thị Trực Tuyến</title>
    <link rel="stylesheet" href="asset/style.css"> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<!-- HEADER -->
<header class="top-header bg-dark text-white py-2">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="logo">
            <h2 class="fw-bold">ElectroShop<span style="color: red;">.</span></h2>
        </div>
        <div class="search-bar d-flex">
            <select class="form-select me-2">
                <option>Trang chủ</option>
                <option>Giới thiệu</option>
                <option>Góp ý</option>
                <option>Hỏi đáp</option>
            </select>
            <input type="text" class="form-control me-2" placeholder="Tìm kiếm sản phẩm">
            <button class="btn btn-danger">Tìm kiếm</button>
        </div>
        <div class="user-cart">
            <a href="#" class="text-white me-3">Yêu thích</a>
            <a href="#" class="text-white">Giỏ hàng</a>
        </div>
    </div>
</header>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link fw-bold" href="#">Ưu đãi hot</a></li>
                <li class="nav-item"><a class="nav-link fw-bold" href="#">Máy tính bảng</a></li>
                <li class="nav-item"><a class="nav-link fw-bold" href="#">Laptops</a></li>
                <li class="nav-item"><a class="nav-link fw-bold" href="#">Điện thoại</a></li>
                <li class="nav-item"><a class="nav-link fw-bold" href="#">Máy ảnh</a></li>
                <li class="nav-item"><a class="nav-link fw-bold" href="#">Phụ kiện</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- BANNER -->
<section class="banner mt-3">
    <div class="container d-flex justify-content-between">
        <div class="banner-item position-relative">
            <img src="assets/laptop-banner.jpg" class="img-fluid" alt="Bộ Sưu Tập Laptop">
            <div class="banner-text">
                <h4>Bộ Sưu Tập Laptop</h4>
                <a href="#" class="btn btn-danger">Mua ngay</a>
            </div>
        </div>
        <div class="banner-item position-relative">
            <img src="assets/accessories-banner.jpg" class="img-fluid" alt="Bộ sưu tập Phụ kiện">
            <div class="banner-text">
                <h4>Bộ sưu tập Phụ kiện</h4>
                <a href="#" class="btn btn-danger">Mua ngay</a>
            </div>
        </div>
        <div class="banner-item position-relative">
            <img src="assets/camera-banner.jpg" class="img-fluid" alt="Bộ sưu tập Máy ảnh">
            <div class="banner-text">
                <h4>Bộ sưu tập Máy ảnh </h4>
                <a href="#" class="btn btn-danger"> Mua ngay</a>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>