<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa thông tin người dùng</title>
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
                <h2>Chỉnh sửa thông tin cá nhân</h2>
            </div>
            <form method="POST" action="/duan1/client/controllers/authenController.php?action=update_profile">
                <div class="mb-3">
                    <label for="name" class="form-label">Tên người dùng:</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($_SESSION['user_name']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($_SESSION['user_email']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Số điện thoại:</label>
                    <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($_SESSION['user_phone']); ?>" pattern="[0-9]{10}" title="Vui lòng nhập số điện thoại 10 số" required>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Địa chỉ:</label>
                    <input type="text" class="form-control" id="address" name="address" value="<?php echo htmlspecialchars($_SESSION['user_address']); ?>" required>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Cập nhật thông tin</button>
                    <a href="/duan1/client/views/auth/user-profile.php" class="btn btn-secondary">Quay lại</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>