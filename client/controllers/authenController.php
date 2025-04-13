<?php
require_once __DIR__ . '/../models/UserClient.php';

class AuthenController
{
    private $userClient;

    public function __construct()
    {
        $this->userClient = new UserClient();
    }

    // Xử lý đăng ký
    public function register($name, $email, $password, $address, $phone)
    {
        // Kiểm tra nếu email đã tồn tại
        if ($this->userClient->checkEmail($email)) {
            header('Location: /duan1/client/views/auth/form-register.php?error=email_exists');
            exit();
        }

        // Đăng ký người dùng mới
        if ($this->userClient->register($name, $email, $password, $address, $phone)) {
            header('Location: /duan1/client/views/auth/form-login.php?success=registered');
            exit();
        }

        // Nếu đăng ký thất bại
        header('Location: /duan1/client/views/auth/form-register.php?error=failed');
        exit();
    }

    // Xử lý đăng nhập
    public function login($email, $password)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $user = $this->userClient->login($email, $password);
        if ($user) {
            // Lưu tất cả thông tin người dùng vào session
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_phone'] = $user['phone'] ?? ''; // Sử dụng toán tử null coalescing
            $_SESSION['user_address'] = $user['address'] ?? ''; // Sử dụng toán tử null coalescing

            header('Location: /duan1/index.php');
            exit();
        }

        header('Location: /duan1/client/views/auth/form-login.php?error=invalid');
        exit();
    }

    // Xử lý đăng xuất
    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        header('Location: /duan1/client/views/auth/form-login.php');
        exit();
    }

    // Xử lý cập nhật thông tin người dùng
    public function updateProfile($name, $email, $phone, $address)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            header('Location: /duan1/client/views/auth/form-login.php');
            exit();
        }

        $user_id = $_SESSION['user_id'];
        if ($this->userClient->updateProfile($user_id, $name, $email, $phone, $address)) {
            $_SESSION['user_name'] = $name;
            $_SESSION['user_email'] = $email;
            $_SESSION['user_phone'] = $phone;
            $_SESSION['user_address'] = $address;

            header('Location: /duan1/client/views/auth/user-profile.php?success=updated');
            exit();
        }

        header('Location: /duan1/client/views/auth/edit-profile.php?error=failed');
        exit();
    }
}

// Xử lý yêu cầu từ URL
if (isset($_GET['action'])) {
    $authController = new AuthenController();

    switch ($_GET['action']) {
        case 'register':
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $address = $_POST['address'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $authController->register($name, $email, $password, $address, $phone);
            break;

        case 'login':
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $authController->login($email, $password);
            break;

        case 'logout':
            $authController->logout();
            break;

        case 'update_profile':
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $address = $_POST['address'] ?? '';
            $authController->updateProfile($name, $email, $phone, $address);
            break;

        default:
            header('Location: /duan1/client/views/auth/form-login.php');
            exit();
    }
}
