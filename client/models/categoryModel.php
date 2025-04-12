<?php
namespace Client\Models;

class CategoryModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Lấy danh sách sản phẩm theo danh mục
    public function getProductsByCategory($category_id) {
        $stmt = $this->conn->prepare("
            SELECT p.product_id, p.name, p.image AS product_image, p.price AS product_price, 
                   p.sale_price AS product_sale_price, c.name AS category_name
            FROM products p
            JOIN categories c ON p.category_id = c.category_id
            WHERE p.category_id = ?
        ");
        $stmt->execute([$category_id]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}