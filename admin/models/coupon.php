<?php
require_once __DIR__ . '/../../commons/connect.php';

class Coupon {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    // Lấy tất cả mã giảm giá
    public function getAllCoupons() {
        $stmt = $this->conn->query("SELECT * FROM coupons");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Tạo mã giảm giá mới
    public function create($name, $coupon_type, $coupon_code, $start_date, $end_date, $quantity, $status, $coupon_value) {
        $stmt = $this->conn->prepare("
            INSERT INTO coupons (name, coupon_type, coupon_code, start_date, end_date, quantity, status, coupon_value)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([$name, $coupon_type, $coupon_code, $start_date, $end_date, $quantity, $status, $coupon_value]);
    }

    // Lấy mã giảm giá theo ID
    public function getById($coupon_id) {
        $stmt = $this->conn->prepare("SELECT * FROM coupons WHERE coupon_id = ?");
        $stmt->execute([$coupon_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Cập nhật mã giảm giá
    public function update($coupon_id, $name, $coupon_type, $coupon_code, $start_date, $end_date, $quantity, $status, $coupon_value) {
        $stmt = $this->conn->prepare("
            UPDATE coupons 
            SET name = ?, coupon_type = ?, coupon_code = ?, start_date = ?, end_date = ?, quantity = ?, status = ?, coupon_value = ?
            WHERE coupon_id = ?
        ");
        $stmt->execute([$name, $coupon_type, $coupon_code, $start_date, $end_date, $quantity, $status, $coupon_value, $coupon_id]);
    }

    // Xóa mã giảm giá
    public function delete($coupon_id) {
        $stmt = $this->conn->prepare("DELETE FROM coupons WHERE coupon_id = ?");
        $stmt->execute([$coupon_id]);
    }
}
?>