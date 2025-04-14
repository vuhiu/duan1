<?php

require_once __DIR__ . '/../models/categoryModel.php';

class CategoryController
{
    private $model;

    public function __construct($conn)
    {
        $this->model = new CategoryModel($conn);
    }

    public function index()
    {
        $category_id = $_GET['category_id'] ?? 1; // Mặc định là danh mục có ID = 1

        // Kiểm tra xem category_id có hợp lệ không
        if (!$category_id || !is_numeric($category_id)) {
            die("❌ Lỗi: Danh mục không hợp lệ.");
        }
        // Lấy danh sách danh mục
        $categories = $this->model->getAllCategories();

        // Lấy danh sách sản phẩm theo danh mục và bộ lọc
        $price_range = $_GET['price_range'] ?? null; // Ví dụ: "1000000-5000000"
        $brand = $_GET['brand'] ?? null; // Ví dụ: "Samsung"
        $color = $_GET['color'] ?? null; // Ví dụ: "red"
        $size = $_GET['size'] ?? null; // Ví dụ: "64GB"
        $sort = $_GET['sort'] ?? null; // Ví dụ: "price-asc"

        // Lấy danh sách sản phẩm theo danh mục và bộ lọc
        $products = $this->model->getFilteredProducts($category_id, $price_range, $brand, $color, $size, $sort);
        // Gọi view và truyền dữ liệu
        $this->render('product/category', [
            'categories' => $categories,
            'products' => $products
        ]);
    }

    private function render($view, $data = [])
    {
        extract($data); // Biến $products sẽ có sẵn trong view
        include_once __DIR__ . "/../views/$view.php";
    }
}
