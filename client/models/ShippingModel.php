<?php

require_once __DIR__ . '/../../commons/connect.php';

class Ship
{
    private $conn;

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    public function getAllShip()
    {
        $sql = 'select * from ships';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy thông tin phí vận chuyển theo id
    public function getShipById($ship_id)
    {
        $sql = 'select * from ships where id = ?';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$ship_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Lấy danh sách phương thức vận chuyển
    public function getAllShippingMethods()
    {
        try {
            $stmt = $this->conn->prepare("
                SELECT 
                    ship_id,
                    shipping_name,
                    shipping_prices
                FROM ships
            ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting shipping methods: " . $e->getMessage());
            return [];
        }
    }

    // Lấy thông tin phương thức vận chuyển theo ID
    public function getShippingMethodById($id)
    {
        try {
            $stmt = $this->conn->prepare("
                SELECT 
                    ship_id,
                    shipping_name,
                    shipping_prices
                FROM ships 
                WHERE ship_id = ?
            ");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting shipping method: " . $e->getMessage());
            return false;
        }
    }
}
