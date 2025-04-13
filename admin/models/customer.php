<?php
require_once __DIR__ . '/../../commons/connect.php';

class Customer
{
    private $conn;

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    // Lấy danh sách khách hàng
    public function getAllCustomers()
    {
        $sql = "SELECT * FROM users WHERE role = 'client' ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy thông tin khách hàng theo ID
    public function getCustomerById($user_id)
    {
        $sql = "SELECT * FROM users WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$user_id]);
        $customer = $stmt->fetch(PDO::FETCH_ASSOC);

        // Thêm giá trị mặc định nếu trường bị thiếu
        if ($customer) {
            $customer['name'] = $customer['name'] ?? 'Không có dữ liệu';
            $customer['email'] = $customer['email'] ?? 'Không có dữ liệu';
            $customer['phone'] = $customer['phone'] ?? 'Không có dữ liệu';
            $customer['address'] = $customer['address'] ?? 'Không có dữ liệu';
        }

        return $customer;
    }

    // Cập nhật thông tin khách hàng
    public function updateCustomer($user_id, $name, $email, $phone, $address)
    {
        $sql = "UPDATE users SET name = ?, email = ?, phone = ?, address = ? WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$name, $email, $phone, $address, $user_id]);
    }
}
