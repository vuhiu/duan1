<!-- filepath: c:\laragon\www\duan1\client\views\auth\form-register.php -->
<?php
session_start();
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center bg-primary text-white">
                        <h3>Đăng ký tài khoản</h3>
                    </div>
                    <div class="card-body">
                        <?php if (isset($_GET['success']) && $_GET['success'] == 'registered'): ?>
                            <div class="alert alert-success">
                                Đăng ký thành công! Vui lòng đăng nhập để tiếp tục.
                            </div>
                        <?php endif; ?>

                        <?php if (isset($_GET['error'])): ?>
                            <div class="alert alert-danger">
                                <?php
                                switch ($_GET['error']) {
                                    case 'email_exists':
                                        echo 'Email này đã được đăng ký!';
                                        break;
                                    case 'failed':
                                        echo 'Đăng ký thất bại, vui lòng thử lại!';
                                        break;
                                    default:
                                        echo 'Có lỗi xảy ra, vui lòng thử lại!';
                                }
                                ?>
                            </div>
                        <?php endif; ?>

                        <form action="../../controllers/authenController.php?action=register" method="POST">
                            <div class="mb-3">
                                <label for="name" class="form-label">Họ và tên</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">Số điện thoại</label>
                                <input type="tel" class="form-control" id="phone" name="phone" pattern="[0-9]{10}" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Địa chỉ</label>
                                <input type="text" class="form-control" id="address" name="address" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Mật khẩu</label>
                                <input type="password" class="form-control" id="password" name="password" minlength="6" required>
                            </div>

                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Xác nhận mật khẩu</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                                <label class="form-check-label" for="terms">
                                    Tôi đồng ý với điều khoản sử dụng
                                </label>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Đăng ký</button>
                                <a href="/duan1/index.php" class="btn btn-secondary">Về trang chủ</a>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <p>Đã có tài khoản? <a href="form-login.php">Đăng nhập ngay!</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Kiểm tra mật khẩu khớp nhau
        document.querySelector('form').onsubmit = function(e) {
            var password = document.getElementById('password');
            var confirm = document.getElementById('confirm_password');

            if (password.value !== confirm.value) {
                e.preventDefault();
                alert('Mật khẩu xác nhận không khớp!');
                confirm.focus();
            }
        };
    </script>
</body>

</html>