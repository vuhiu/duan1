<?php
ob_start(); // Bật bộ đệm đầu ra
session_start();
require_once __DIR__ . '/../../commons/connect.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

class AuthenController {
    // Chức năng đăng ký
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $password = password_hash(trim($_POST['password']), PASSWORD_BCRYPT); // Mã hóa mật khẩu

            try {
                global $conn;
                $stmt = $conn->prepare("INSERT INTO users (name, email, password, role_id) VALUES (?, ?, ?, 2)"); // role_id = 2 cho admin
                $stmt->execute([$name, $email, $password]);
                echo "<script>alert('Đăng ký thành công!');</script>";
                header("Location: /duan1/admin/views/form-login.php");
                exit();
            } catch (PDOException $e) {
                if ($e->getCode() == 23000) { // Lỗi trùng email
                    echo "<script>alert('Email đã tồn tại!');</script>";
                } else {
                    echo "Lỗi: " . $e->getMessage();
                }
            }
        }
    }

    // Chức năng đăng nhập
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);

            try {
                global $conn;
                $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND role_id = 2"); // Chỉ admin
                $stmt->execute([$email]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($user && password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['user_id']; // Lưu ID người dùng vào session
                    $_SESSION['admin'] = ['name' => $user['name']]; // Lưu thông tin admin vào session

                    header("Location: /duan1/admin/index.php"); // Chuyển hướng đến trang quản trị
                    exit();
                } else {
                    echo "<script>alert('Email hoặc mật khẩu không đúng!');</script>";
                    header("Refresh: 2; URL=/duan1/admin/views/form-login.php");
                    exit();
                }
            } catch (PDOException $e) {
                echo "Lỗi: " . $e->getMessage();
            }
        }
    }

    // Chức năng đăng xuất
    public function logout() {
        session_destroy(); // Hủy toàn bộ session
        header("Location: /duan1/admin/views/form-login.php?logout=success"); // Chuyển hướng về trang đăng nhập
        exit;
    }
}

// Xử lý các hành động
$authenController = new AuthenController();
if (isset($_GET['action'])) {
    if ($_GET['action'] === 'register') {
        $authenController->register();
    } elseif ($_GET['action'] === 'logout') {
        $authenController->logout();
    }
} else {
    $authenController->login();
}
ob_end_flush(); // Xóa bộ đệm đầu ra
?>