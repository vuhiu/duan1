<?php
namespace Client\Controllers;

use Client\Models\CategoryModel;

class CategoryController {
    private $model;

    public function __construct($conn) {
        $this->model = new CategoryModel($conn);
    }

    public function index() {
        $category_id = $_GET['category_id'] ?? null;

        if (!$category_id || !is_numeric($category_id)) {
            die("❌ Lỗi: Danh mục không hợp lệ.");
        }

        // Lấy danh sách sản phẩm theo danh mục
        $products = $this->model->getProductsByCategory($category_id);

        // Gọi view và truyền dữ liệu
        include_once __DIR__ . '/../views/product/category.php';
    }
}