<?php
namespace Client\Models; // Sử dụng namespace để phân biệt lớp
require_once __DIR__ . '/../../commons/connect.php';

class ClientProduct { // Đổi tên lớp từ Product thành ClientProduct
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Get product by ID
    public function getProductById($product_id) {
        $sql = "SELECT 
                    products.product_id,
                    products.name AS product_name,
                    products.price AS product_price,
                    products.sale_price AS product_sale_price,
                    products.image AS product_image,
                    products.description AS product_description,
                    products.status AS product_status,
                    categories.name AS category_name
                FROM products
                LEFT JOIN categories ON products.category_id = categories.category_id
                WHERE products.product_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$product_id]);
        $product = $stmt->fetch(\PDO::FETCH_ASSOC);
    
        // Lấy các biến thể của sản phẩm
        if ($product) {
            $product['variants'] = $this->getProductVariants($product_id);
        }
    
        return $product;
    }

    // Get all products with their variants
    public function getAllProductWithVariants() {
        $sql = "SELECT 
                    products.product_id,
                    products.name AS product_name,
                    products.price AS product_price,
                    products.sale_price AS product_sale_price,
                    products.image AS product_image,
                    products.description AS product_description,
                    categories.name AS category_name
                FROM products
                LEFT JOIN categories ON products.category_id = categories.category_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $products = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Fetch variants for each product
        foreach ($products as &$product) {
            $product['variants'] = $this->getProductVariants($product['product_id']);
        }

        return $products;
    }

    // Fetch product variants
    public function getProductVariants($product_id) {
        $sql = "SELECT 
                    variant_colors.color_name AS color,
                    variant_size.size_name AS size
                FROM product_variants
                LEFT JOIN variant_colors ON product_variants.variant_color_id = variant_colors.variant_color_id
                LEFT JOIN variant_size ON product_variants.variant_size_id = variant_size.variant_size_id
                WHERE product_variants.product_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$product_id]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    // search products by keyword
    public function searchProducts($keyword) {
        $sql = "SELECT 
                    product_id, 
                    name AS product_name, 
                    price AS product_price, 
                    sale_price AS product_sale_price, 
                    image AS product_image, 
                    description AS product_description 
                FROM products 
                WHERE name LIKE :keyword 
                   OR product_id LIKE :keyword 
                   OR description LIKE :keyword";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['keyword' => '%' . $keyword . '%']);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
}
?>