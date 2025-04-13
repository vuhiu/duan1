<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin người dùng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .profile-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .profile-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .profile-info {
            margin-bottom: 20px;
        }

        .profile-info label {
            font-weight: bold;
        }
    </style>
</head>

<body class="bg-light">
    <?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['user_id'])) {
        header('Location: /duan1/client/views/auth/form-login.php');
        exit();
    }
    ?>
    <div class="container">
        <div class="profile-container">
            <div class="profile-header">
                <h2>Thông tin cá nhân</h2>
            </div>
            <?php if (isset($_GET['success']) && $_GET['success'] === 'updated'): ?>
                <div class="alert alert-success">Cập nhật thông tin thành công!</div>
            <?php endif; ?>
            <div class="profile-info">
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label>Tên người dùng:</label>
                    </div>
                    <div class="col-md-9">
                        <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label>Email:</label>
                    </div>
                    <div class="col-md-9">
                        <?php echo isset($_SESSION['user_email']) ? htmlspecialchars($_SESSION['user_email']) : 'Chưa cập nhật'; ?>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label>Số điện thoại:</label>
                    </div>
                    <div class="col-md-9">
                        <?php echo isset($_SESSION['user_phone']) ? htmlspecialchars($_SESSION['user_phone']) : 'Chưa cập nhật'; ?>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label>Địa chỉ:</label>
                    </div>
                    <div class="col-md-9">
                        <?php echo isset($_SESSION['user_address']) ? htmlspecialchars($_SESSION['user_address']) : 'Chưa cập nhật'; ?>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <a href="/duan1/index.php" class="btn btn-primary">Quay lại trang chủ</a>
                <a href="/duan1/client/views/auth/edit-profile.php" class="btn btn-warning">Chỉnh sửa thông tin</a>
            </div>
        </div>
    </div>
</body>

</html>