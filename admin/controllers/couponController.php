<?php
require_once __DIR__ . '/../models/coupon.php';

class CouponController {
    private $couponModel;

    public function __construct() {
        $this->couponModel = new Coupon();
    }

    // Hiển thị danh sách mã giảm giá
    public function getList() {
        $coupons = $this->couponModel->getAllCoupons();
        require_once __DIR__ . '/../views/coupon/listCoupon.php';
    }

    // Thêm mã giảm giá mới
    public function addCoupon() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $coupon_type = $_POST['coupon_type'];
            $coupon_code = $_POST['coupon_code'];
            $start_date = $_POST['start_date'];
            $end_date = $_POST['end_date'];
            $quantity = $_POST['quantity'];
            $status = $_POST['status'];
            $coupon_value = $_POST['coupon_value'];

            $this->couponModel->create($name, $coupon_type, $coupon_code, $start_date, $end_date, $quantity, $status, $coupon_value);

            header('Location: ?act=coupon&page=list');
            exit();
        }

        require_once __DIR__ . '/../views/coupon/createCoupon.php';
    }

    // Sửa mã giảm giá
    public function editCoupon() {
        if (!isset($_GET['coupon_id']) || !is_numeric($_GET['coupon_id'])) {
            die("❌ Lỗi: ID mã giảm giá không hợp lệ!");
        }

        $coupon_id = $_GET['coupon_id'];
        $coupon = $this->couponModel->getById($coupon_id);

        if (!$coupon) {
            die("❌ Lỗi: Mã giảm giá không tồn tại!");
        }

        require_once __DIR__ . '/../views/coupon/editCoupon.php';
    }

    // Cập nhật mã giảm giá
    public function updateCoupon() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $coupon_id = $_POST['coupon_id'];
            $name = $_POST['name'];
            $coupon_type = $_POST['coupon_type'];
            $coupon_code = $_POST['coupon_code'];
            $start_date = $_POST['start_date'];
            $end_date = $_POST['end_date'];
            $quantity = $_POST['quantity'];
            $status = $_POST['status'];
            $coupon_value = $_POST['coupon_value'];

            $this->couponModel->update($coupon_id, $name, $coupon_type, $coupon_code, $start_date, $end_date, $quantity, $status, $coupon_value);

            header('Location: ?act=coupon&page=list');
            exit();
        }
    }

    // Xóa mã giảm giá
    public function deleteCoupon() {
        if (!isset($_GET['coupon_id']) || !is_numeric($_GET['coupon_id'])) {
            die("❌ Lỗi: ID mã giảm giá không hợp lệ!");
        }

        $coupon_id = $_GET['coupon_id'];
        $this->couponModel->delete($coupon_id);

        header('Location: ?act=coupon&page=list');
        exit();
    }
}
?>