<?php
require_once __DIR__ . '/../models/customer.php';

class CustomerAdminController
{
    private $customerModel;

    public function __construct()
    {
        $this->customerModel = new Customer();
    }

    // Hiển thị danh sách khách hàng
    public function index()
    {
        $customers = $this->customerModel->getAllCustomers();
        // var_dump($customers);
        // die();
        require_once __DIR__ . '/../views/customer/list.php';
    }

    // Hiển thị chi tiết khách hàng
    public function detail($user_id)
    {
        if (!$user_id) {
            die("ID khách hàng không hợp lệ.");
        }

        $customer = $this->customerModel->getCustomerById($user_id);

        if (!$customer) {
            die("Không tìm thấy khách hàng.");
        }

        require_once __DIR__ . '/../views/customer/detail.php';
    }

    // Hiển thị form sửa thông tin khách hàng
    public function edit($user_id)
    {
        if (!$user_id) {
            die("ID khách hàng không hợp lệ.");
        }

        $customer = $this->customerModel->getCustomerById($user_id);

        if (!$customer) {
            die("Không tìm thấy khách hàng.");
        }

        require_once __DIR__ . '/../views/customer/edit.php';
    }

    // Cập nhật thông tin khách hàng
    public function update($data)
    {
        try {
            if (empty($data['user_id'])) {
                throw new Exception("ID khách hàng không hợp lệ");
            }

            $user_id = $data['user_id'];
            $name = $data['name'] ?? '';
            $email = $data['email'] ?? '';
            $phone = $data['phone'] ?? '';
            $address = $data['address'] ?? '';

            // Validate input
            if (empty($name)) {
                throw new Exception("Tên không được để trống");
            }
            if (empty($email)) {
                throw new Exception("Email không được để trống");
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception("Email không hợp lệ");
            }
            if (!empty($phone) && !preg_match("/^[0-9]{10}$/", $phone)) {
                throw new Exception("Số điện thoại không hợp lệ");
            }

            // Update customer
            $result = $this->customerModel->updateCustomer($user_id, $name, $email, $phone, $address);

            if ($result) {
                $_SESSION['success'] = "Cập nhật thông tin khách hàng thành công";
            } else {
                throw new Exception("Không thể cập nhật thông tin khách hàng");
            }

            header('Location: index.php?act=customer&page=list');
            exit();
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header('Location: index.php?act=customer&page=edit&id=' . $user_id);
            exit();
        }
    }
}
