<?php
require_once __DIR__ . '/../models/ProductModel.php';

class ProductController {
    private $productModel;

    public function __construct() {
        $this->productModel = new Product();
    }

    // Get product details
    public function getProductDetail() {
        if (!isset($_GET['product_id']) || !is_numeric($_GET['product_id'])) {
            die("❌ Lỗi: ID sản phẩm không hợp lệ!");
        }

        $product_id = $_GET['product_id'];
        $product = $this->productModel->getProductById($product_id);
        $variants = $this->productModel->getProductVariants($product_id);

        if (!$product) {
            die("❌ Lỗi: Sản phẩm không tồn tại.");
        }

        require_once __DIR__ . '/../views/product.php';
    }

    // Get all products
    public function getAllProducts() {
        $products = $this->productModel->getAllProductWithVariants(); // Fetch products with variants
        require_once __DIR__ . '/../views/home.php'; // Pass $products to the view
    }
}
?>