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
        $couponType = trim(strtolower($coupon['coupon_type']));
        $couponValue = floatval($coupon['coupon_value']);

        switch ($couponType) {
            case 'fixed amount':
                // Giảm giá trực tiếp theo số tiền
                $discount = $couponValue;
                break;

            case 'percentage':
                // Giảm giá theo phần trăm
                $discount = ($totalAmount * $couponValue) / 100;
                // Nếu có giới hạn giảm giá tối đa
                if (isset($coupon['max_discount']) && $coupon['max_discount'] > 0) {
                    $discount = min($discount, floatval($coupon['max_discount']));
                }
                break;

            case 'free shipping':
                $discount = isset($coupon['shipping_discount']) ? floatval($coupon['shipping_discount']) : 0;
                break;

            default:
                return [
                    'discount' => 0,
                    'error' => 'Loại mã giảm giá không hợp lệ'
                ];
        }

        // Đảm bảo số tiền giảm giá không vượt quá tổng đơn hàng
        $discount = min($discount, $totalAmount);

        return [
            'discount' => $discount,
            'error' => null
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
