<?php
require_once 'models/ProductModel.php';

class ProductController {
    private $productModel;

    public function __construct($db) {
        $this->productModel = new ProductModel($db);
    }

    // Danh sách sản phẩm
    public function listProducts() {
        $products = $this->productModel->getProducts();
        require 'admin/modules/sanpham/list.php';
    }

    // Thêm sản phẩm mới
    public function addProduct() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $price = $_POST['price'];
            $sale_price = $_POST['sale_price'];
            $image = $_FILES['image']['name'];

            move_uploaded_file($_FILES['image']['tmp_name'], "asset/images/" . $image);

            $this->productModel->addProduct($name, $price, $sale_price, $image);
            header("Location: index.php?act=sanpham");
        } else {
            require 'admin/modules/sanpham/add.php';
        }
    }
}
?>
