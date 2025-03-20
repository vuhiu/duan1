<?php
require_once 'commons/connect.php';

class ProductModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Lấy danh sách sản phẩm
    public function getProducts() {
        $sql = "SELECT * FROM products ORDER BY created_at DESC";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Thêm sản phẩm
    public function addProduct($name, $price, $sale_price, $image) {
        $sql = "INSERT INTO products (name, price, sale_price, image) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("siis", $name, $price, $sale_price, $image);
        return $stmt->execute();
    }
}
?>
