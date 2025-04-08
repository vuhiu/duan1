<?php
require_once '../models/UserClient.php';

class AuthController {
    private $userClient;

    public function __construct() {
        $this->userClient = new UserClient();
    }

    // Xử lý đăng ký
    public function register($name, $email, $password) {
        // Kiểm tra nếu email đã tồn tại
        if ($this->userClient->checkEmail($email)) {
            header('Location: /duan1/client/views/form-register.php?error=email_exists');
            exit();
        }

        // Đăng ký người dùng mới
        if ($this->userClient->register($name, $email, $password)) {
            header('Location: /duan1/client/views/form-login.php?success=registered');
            exit();
        }

        // Nếu đăng ký thất bại
        header('Location: /duan1/client/views/form-register.php?error=failed');
        exit();
    }

    // Xử lý đăng nhập
    public function login($email, $password) {
        $user = $this->userClient->login($email, $password);
        if ($user) {
            session_start();
            $_SESSION['user'] = $user;

            // Chuyển hướng đến trang chủ sau khi đăng nhập thành công
            header('Location: /duan1/');
            exit();
        }

        // Nếu đăng nhập thất bại, chuyển hướng lại trang đăng nhập với thông báo lỗi
        header('Location: /duan1/client/views/form-login.php?error=invalid');
        exit();
    }

    // Xử lý đăng xuất
    public function logout() {
        session_start();
        session_destroy(); // Hủy session
        header('Location: /duan1/client/views/form-login.php');
        exit();
    }
}

// Xử lý yêu cầu từ URL
if (isset($_GET['action'])) {
    $authController = new AuthController();

    switch ($_GET['action']) {
        case 'register':
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $authController->register($name, $email, $password);
            break;

        case 'login':
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $authController->login($email, $password);
            break;

        case 'logout':
            $authController->logout();
            break;

        default:
            header('Location: /duan1/client/views/form-login.php');
            exit();
    }
}