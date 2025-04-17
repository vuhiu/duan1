<?php
class CouponModel
{
    private $conn;

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    public function validateCoupon($couponCode)
    {
        try {
            $stmt = $this->conn->prepare("
                SELECT * FROM coupons 
                WHERE coupon_code = :code 
                AND status = 'active'
                AND start_date <= CURRENT_DATE 
                AND end_date >= CURRENT_DATE 
                AND quantity > 0
            ");

            $stmt->bindParam(':code', $couponCode);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error validating coupon: " . $e->getMessage());
            return false;
        }
    }

    public function applyDiscount($coupon, $totalAmount)
    {
        if (!$coupon || $totalAmount <= 0) {
            return [
                'discount' => 0,
                'error' => 'Mã giảm giá không hợp lệ'
            ];
        }

        $discount = 0;
        $couponCode = strtoupper(trim($coupon['coupon_code']));
        $message = '';

        switch ($couponCode) {
            case 'VOUCHER10':
                // Giảm 10% tổng giá trị đơn hàng
                $discount = round($totalAmount * 0.1);
                $message = 'Giảm 10% tổng giá trị đơn hàng';
                break;

            case 'ST20':
                // Giảm 20% tổng giá trị đơn hàng
                $discount = round($totalAmount * 0.2);
                $message = 'Giảm 20% tổng giá trị đơn hàng';
                break;

            case 'ST100K':
                // Giảm trực tiếp 100.000đ
                $discount = 100000;
                $message = 'Giảm ' . number_format($discount, 0, ',', '.') . 'đ';
                break;

            default:
                return [
                    'discount' => 0,
                    'error' => 'Mã giảm giá không hợp lệ'
                ];
        }

        // Đảm bảo số tiền giảm giá không vượt quá tổng đơn hàng
        $discount = min($discount, $totalAmount);

        return [
            'discount' => $discount,
            'error' => null,
            'message' => $message
        ];
    }

    public function decreaseQuantity($couponId)
    {
        try {
            $stmt = $this->conn->prepare("
                UPDATE coupons 
                SET quantity = quantity - 1 
                WHERE coupon_id = :coupon_id 
                AND quantity > 0
            ");

            $stmt->bindParam(':coupon_id', $couponId);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error decreasing coupon quantity: " . $e->getMessage());
            return false;
        }
    }

    public function getCouponById($couponId)
    {
        try {
            $stmt = $this->conn->prepare("
                SELECT * FROM coupons 
                WHERE coupon_id = :coupon_id
            ");

            $stmt->bindParam(':coupon_id', $couponId);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting coupon: " . $e->getMessage());
            return false;
        }
    }
}
