<?php
session_start();
require_once __DIR__ . '/../../commons/connect.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

class AuthenController {
    // Chức năng đăng ký
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Mã hóa mật khẩu

            try {
                global $conn;
                $stmt = $conn->prepare("INSERT INTO users (name, email, password, role_id) VALUES (?, ?, ?, 1)"); // role_id = 1 cho client
                $stmt->execute([$name, $email, $password]);
                echo "Đăng ký thành công! <a href='/duan1/client/views/form-login.php'>Đăng nhập</a>";
            } catch (PDOException $e) {
                echo "Lỗi: " . $e->getMessage();
            }
        }
    }

    // Chức năng đăng nhập
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            try {
                global $conn;
                $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND role_id = 1"); // Chỉ client
                $stmt->execute([$email]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($user && password_verify($password, $user['password'])) {
                    $_SESSION['client'] = [
                        'user_id' => $user['user_id'],
                        'name' => $user['name'],
                        'role_id' => $user['role_id']
                    ];
                    header("Location: /duan1/index.php");
                    exit;
                } else {
                    echo "Email hoặc mật khẩu không đúng!";
                }
            } catch (PDOException $e) {
                echo "Lỗi: " . $e->getMessage();
            }
        }
    }

    // Chức năng đăng xuất
    public function logout() {
        session_destroy();
        header("Location: /duan1/client/views/form-login.php");
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
?>