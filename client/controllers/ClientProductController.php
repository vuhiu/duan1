<?php
namespace Client\Controllers;

require_once __DIR__ . '/../../client/models/ProductModel.php';
use Client\Models\ClientProduct; // Import lớp ClientProduct

class ClientProductController {
    private $productModel;

    public function __construct($conn) {
        $this->productModel = new ClientProduct($conn); // Sử dụng ClientProduct
    }

    // Get all products
    public function getAllProducts() {
        $products = $this->productModel->getAllProductWithVariants(); // Lấy sản phẩm cùng biến thể
        require_once __DIR__ . '/../views/home.php'; // Truyền dữ liệu vào view
    }

    // Search products
    public function search() {
        if (isset($_GET['keyword'])) {
            $keyword = trim($_GET['keyword']);
            $products = $this->productModel->searchProducts($keyword); // Gọi phương thức từ model
            require_once __DIR__ . '/../views/search/search_result.php'; // Truyền dữ liệu vào view
        } else {
            echo "Vui lòng nhập từ khóa tìm kiếm.";
        }
    }
    // Get product detail
    public function getProductDetail() {
        if (isset($_GET['product_id']) && is_numeric($_GET['product_id'])) {
            $product_id = $_GET['product_id'];
            $product = $this->productModel->getProductById($product_id); // Lấy chi tiết sản phẩm từ model
    
            if ($product) {
                require_once __DIR__ . '/../views/product/product_detail.php'; // Truyền dữ liệu vào view
            } else {
                echo "Sản phẩm không tồn tại.";
            }
        } else {
            echo "ID sản phẩm không hợp lệ.";
        }
    }
    // Get products by category
    public function getProductsByCategory($category_id) {
        $products = $this->productModel->getProductsByCategory($category_id); // Lấy sản phẩm theo danh mục
        require_once __DIR__ . '/../views/product/category.php'; // Truyền dữ liệu vào view
    }
}
?>