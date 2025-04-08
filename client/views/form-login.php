<!-- filepath: c:\laragon\www\duan1\client\views\form-login.php -->
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center mb-4">Đăng nhập</h2>

                <!-- Hiển thị thông báo -->
                <?php if (isset($_GET['error']) && $_GET['error'] === 'invalid'): ?>
                    <div class="alert alert-danger text-center">
                        Email hoặc mật khẩu không đúng. Vui lòng thử lại.
                    </div>
                <?php elseif (isset($_GET['success']) && $_GET['success'] === 'registered'): ?>
                    <div class="alert alert-success text-center">
                        Đăng ký thành công! Vui lòng đăng nhập.
                    </div>
                <?php endif; ?>

                <!-- Form đăng nhập -->
                <form action="/duan1/client/controllers/AuthController.php?action=login" method="POST" class="p-4 border rounded">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mật khẩu:</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
                </form>
                <p class="text-center mt-3">Chưa có tài khoản? <a href="/duan1/client/views/form-register.php">Đăng ký</a></p>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>