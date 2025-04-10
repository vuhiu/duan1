<?php
require_once __DIR__ . '/../../commons/connect.php';

class UserClient {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    // Kiểm tra email đã tồn tại
    public function checkEmail($email) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Đăng ký người dùng mới
    public function register($name, $email, $password) {
        $stmt = $this->conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        return $stmt->execute([$name, $email, md5($password)]);
    }

    // Đăng nhập
    public function login($email, $password) {
        $stmt = $this->conn->prepare("SELECT user_id, name, email, password FROM users WHERE email = ? AND password = ?");
        $stmt->execute([$email, md5($password)]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // Trả về thông tin người dùng
    }

    // Đăng xuất người dùng
    public function logout() {
        session_start();
        session_unset();
        session_destroy();
    }
}
?>