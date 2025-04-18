<?php
require_once __DIR__ . '/../../commons/connect.php';

class UserClient
{
    private $conn;

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    // Kiểm tra email đã tồn tại
    public function checkEmail($email)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Lấy thông tin người dùng theo ID
    public function getUserById($user_id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE user_id = ?");
        $stmt->execute([$user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Đăng ký người dùng mới
    public function register($name, $email, $password, $address, $phone)
    {
        $stmt = $this->conn->prepare("INSERT INTO users (name, email, password, address, phone, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
        return $stmt->execute([$name, $email, md5($password), $address, $phone]);
    }

    // Đăng nhập
    public function login($email, $password)
    {
        $stmt = $this->conn->prepare("SELECT user_id, name, email, password, address, phone FROM users WHERE email = ? AND password = ?");
        $stmt->execute([$email, md5($password)]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Đảm bảo tất cả các trường đều có giá trị
            $user['address'] = $user['address'] ?? '';
            $user['phone'] = $user['phone'] ?? '';
            return $user;
        }
        return false;
    }

    // Đăng xuất người dùng
    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
    }

    // Cập nhật thông tin người dùng
    public function updateProfile($user_id, $name, $email, $phone, $address)
    {
        $sql = "UPDATE users SET name = ?, email = ?, phone = ?, address = ? WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$name, $email, $phone, $address, $user_id]);
    }
}
