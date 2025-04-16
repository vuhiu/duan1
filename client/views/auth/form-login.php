<!-- filepath: c:\laragon\www\duan1\client\views\auth\form-login.php -->
<?php
session_start();
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập Client</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-header bg-primary text-white text-center py-4">
                        <h3 class="mb-0">Đăng nhập</h3>
                    </div>
                    <div class="card-body p-4">
                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger">
                                <?= $_SESSION['error'] ?>
                                <?php unset($_SESSION['error']); ?>
                            </div>
                        <?php endif; ?>

                        <form action="/duan1/client/controllers/authenController.php?action=login" method="POST">
                            <div class="form-floating mb-3">
                                <input class="form-control" id="email" name="email" type="email" placeholder="name@example.com" required />
                                <label for="email">Email</label>
                            </div>
                            
                            <div class="form-floating mb-3">
                                <input class="form-control" id="password" name="password" type="password" placeholder="Mật khẩu" required />
                                <label for="password">Mật khẩu</label>
                            </div>
                            
                            <div class="form-check mb-3">
                                <input class="form-check-input" id="remember" name="remember" type="checkbox" />
                                <label class="form-check-label" for="remember">Ghi nhớ đăng nhập</label>
                            </div>
                            
                            <div class="d-grid">
                                <button class="btn btn-primary btn-lg" type="submit" name="login">Đăng nhập</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center py-3 bg-light">
                        <div class="small mb-2"><a href="forgot-password.php">Quên mật khẩu?</a></div>
                        <div class="small">Chưa có tài khoản? <a href="/duan1/client/views/auth/form-register.php">Đăng ký ngay!</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
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
    </style>
</body>

</html>