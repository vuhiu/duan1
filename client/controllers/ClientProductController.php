<?php
namespace Client\Controllers;

use Client\Models\ClientProduct;
require_once __DIR__ . '/../../client/models/ProductModel.php';

class ClientProductController
{
    private $productModel;

    public function __construct(ClientProduct $productModel)
    {
        $this->productModel = $productModel;
    }

    // Get all products
    public function getAllProducts()
    {
        $products = $this->productModel->getAllProductWithVariants();
        require_once __DIR__ . '/../views/home.php';
    }

    // Search products
    public function search()
    {
        if (isset($_GET['keyword'])) {
            $keyword = trim($_GET['keyword']);
            $products = $this->productModel->searchProducts($keyword);
            require_once __DIR__ . '/../views/search/search_result.php';
        } else {
            echo "Vui lòng nhập từ khóa tìm kiếm.";
        }
    }

    // Get product detail
    public function getProductDetail()
    {
        if (isset($_GET['product_id']) && is_numeric($_GET['product_id'])) {
            $product_id = $_GET['product_id'];
            $product = $this->productModel->getProductById($product_id);

            if ($product) {
                require_once __DIR__ . '/../views/product/product_detail.php';
            } else {
                echo "Sản phẩm không tồn tại.";
            }
        } else {
            echo "ID sản phẩm không hợp lệ.";
        }
    }

    // Get products by category
    public function getProductsByCategory($category_id)
    {
        $products = $this->productModel->getProductsByCategory($category_id);
        require_once __DIR__ . '/../views/product/category.php';
    }
}
