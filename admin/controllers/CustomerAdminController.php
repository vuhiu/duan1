<?php
require_once __DIR__ . '/../../commons/connect.php';

class CustomerAdminController
{
    private $conn;

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    // Hiển thị danh sách khách hàng
    public function index()
    {
        // Lấy danh sách khách hàng
        $sql = "SELECT * FROM users ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Gán dữ liệu cho view
        include_once __DIR__ . '/../views/customer/list.php';
    }

    // Hiển thị chi tiết khách hàng
    public function detail($id)
    {
        // Lấy thông tin chi tiết khách hàng
        $sql = "SELECT * FROM users WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        $customer = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$customer) {
            $_SESSION['error'] = 'Không tìm thấy khách hàng';
            header('Location: index.php?act=customer&page=list');
            exit();
        }

        include_once __DIR__ . '/../views/customer/detail.php';
    }

    // Hiển thị form sửa thông tin khách hàng
    public function edit($id)
    {
        // Lấy thông tin khách hàng cần sửa
        $sql = "SELECT * FROM users WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        $customer = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$customer) {
            $_SESSION['error'] = 'Không tìm thấy khách hàng';
            header('Location: index.php?act=customer&page=list');
            exit();
        }

        include_once __DIR__ . '/../views/customer/edit.php';
    }

    // Cập nhật thông tin khách hàng
    public function update($id, $data)
    {
        try {
            $sql = "UPDATE users SET name = ?, email = ?, phone = ?, address = ? WHERE user_id = ?";
            $stmt = $this->conn->prepare($sql);
            $result = $stmt->execute([
                $data['name'],
                $data['email'],
                $data['phone'],
                $data['address'],
                $id
            ]);

            if ($result) {
                $_SESSION['success'] = 'Cập nhật thông tin khách hàng thành công';
            } else {
                $_SESSION['error'] = 'Cập nhật thông tin khách hàng thất bại';
            }
        } catch (PDOException $e) {
            $_SESSION['error'] = 'Lỗi cập nhật: ' . $e->getMessage();
        }

        header('Location: index.php?act=customer&page=list');
        exit();
    }
}
