<?php
require_once __DIR__ . '/../../commons/connect.php';

class UserClient {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    // Đăng ký người dùng
    public function register($name, $email, $password) {
        try {
            $hash_password = password_hash($password, PASSWORD_DEFAULT); // Mã hóa mật khẩu
            $sql = 'INSERT INTO users(name, email, password, role_id, created_at) VALUES(?, ?, ?, 2, now())';
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([$name, $email, $hash_password]);
        } catch (PDOException $e) {
            error_log("Error in register: " . $e->getMessage());
            return false;
        }
    }

    // Kiểm tra email đã tồn tại
    public function checkEmail($email) {
        $sql = "SELECT COUNT(*) as count FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] > 0;
    }

    // Đăng nhập người dùng
    public function login($email, $password) {
        $sql = 'SELECT * FROM users WHERE email = ?';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    // Đăng xuất người dùng
    public function logout() {
        session_start();
        session_unset();
        session_destroy();
    }
}