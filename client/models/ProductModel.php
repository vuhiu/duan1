<?php
require_once __DIR__ . '/../../commons/connect.php';

class Product {
    private $conn;

    public function __construct() {
        global $conn;
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
        return $stmt->fetch(PDO::FETCH_ASSOC);
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
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>