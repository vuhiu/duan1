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
    public function update($user_id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $address = $_POST['address'] ?? '';
    
            if (empty($name) || empty($email)) {
                die("Tên và email không được để trống.");
            }
    
            $this->customerModel->updateCustomer($user_id, $name, $email, $phone, $address);
            header('Location: /duan1/admin/?act=customer&page=list');
            exit;
        } else {
            die("Phương thức không hợp lệ.");
        }
    }
}