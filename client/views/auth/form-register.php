<!-- filepath: c:\laragon\www\duan1\client\views\auth\form-register.php -->
<?php
session_start();
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký Client</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-header bg-primary text-white text-center py-4">
                        <h3 class="mb-0">Đăng ký tài khoản</h3>
                    </div>
                    <div class="card-body p-4">
                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger">
                                <?= $_SESSION['error'] ?>
                                <?php unset($_SESSION['error']); ?>
                            </div>
                        <?php endif; ?>

                        <form action="/duan1/client/controllers/authenController.php?action=register" method="POST">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="fullname" name="fullname" type="text" placeholder="Họ và tên" required />
                                        <label for="fullname">Họ và tên</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="phone" name="phone" type="tel" pattern="[0-9]{10}" title="Vui lòng nhập số điện thoại 10 số" placeholder="Số điện thoại" required />
                                        <label for="phone">Số điện thoại</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-floating mb-3">
                                <input class="form-control" id="email" name="email" type="email" placeholder="name@example.com" required />
                                <label for="email">Email</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input class="form-control" id="address" name="address" type="text" placeholder="Địa chỉ" required />
                                <label for="address">Địa chỉ</label>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="password" name="password" type="password" minlength="6" placeholder="Mật khẩu" required />
                                        <label for="password">Mật khẩu</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="confirm_password" name="confirm_password" type="password" minlength="6" placeholder="Xác nhận mật khẩu" required />
                                        <label for="confirm_password">Xác nhận mật khẩu</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input" id="terms" name="terms" type="checkbox" required />
                                <label class="form-check-label" for="terms">
                                    Tôi đồng ý với <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">điều khoản sử dụng</a>
                                </label>
                            </div>

                            <div class="d-grid">
                                <button class="btn btn-primary btn-lg" type="submit" name="register">Đăng ký</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center py-3 bg-light">
                        <div class="small">Đã có tài khoản? <a href="/duan1/client/views/auth/form-login.php">Đăng nhập ngay!</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Điều khoản -->
    <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="termsModalLabel">Điều khoản sử dụng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6>1. Điều khoản sử dụng</h6>
                    <p>Bằng cách đăng ký tài khoản, bạn đồng ý với các điều khoản sau:</p>
                    <ul>
                        <li>Cung cấp thông tin chính xác và đầy đủ</li>
                        <li>Không sử dụng tài khoản cho mục đích bất hợp pháp</li>
                        <li>Bảo mật thông tin tài khoản</li>
                        <li>Chịu trách nhiệm về mọi hoạt động của tài khoản</li>
                    </ul>
                    
                    <h6>2. Chính sách bảo mật</h6>
                    <p>Chúng tôi cam kết bảo vệ thông tin cá nhân của bạn:</p>
                    <ul>
                        <li>Không chia sẻ thông tin với bên thứ ba</li>
                        <li>Bảo mật thông tin thanh toán</li>
                        <li>Chỉ sử dụng thông tin cho mục đích cung cấp dịch vụ</li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Validation Script -->
    <script>
    document.querySelector('form').addEventListener('submit', function(e) {
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('confirm_password');
        
        if (password.value !== confirmPassword.value) {
            e.preventDefault();
            alert('Mật khẩu xác nhận không khớp!');
            confirmPassword.focus();
        }
    });
    </script>

    <style>
    .card {
        border: none;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }

    .card-header {
        border-bottom: none;
        background: linear-gradient(to right, #0062cc, #0096ff);
    }

    .btn-primary {
        background: linear-gradient(to right, #0062cc, #0096ff);
        border: none;
        padding: 12px;
    }

    .btn-primary:hover {
        background: linear-gradient(to right, #0056b3, #007bff);
    }

    .form-floating > .form-control:focus ~ label,
    .form-floating > .form-control:not(:placeholder-shown) ~ label {
        color: #0062cc;
    }

    .form-control:focus {
        border-color: #0062cc;
        box-shadow: 0 0 0 0.25rem rgba(0, 98, 204, 0.25);
    }

    a {
        color: #0062cc;
        text-decoration: none;
    }

    a:hover {
        color: #0056b3;
        text-decoration: underline;
    }

    .modal-header {
        background: linear-gradient(to right, #0062cc, #0096ff);
        color: white;
    }

    .btn-close {
        filter: brightness(0) invert(1);
    }
    </style>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>