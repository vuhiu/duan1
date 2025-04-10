<?php
ob_start();
require_once __DIR__ . '/../models/product.php';
require_once __DIR__ . '/../models/category.php';
require_once __DIR__ . '/../../commons/connect.php';

class ProductController
{
    public $productModel;
    public $categoryModel;

    public function __construct()
    {
        $this->productModel = new Product();
        $this->categoryModel = new Category();
    }

    // List all products
    public function getList()
    {
        $listProduct = $this->productModel->listProduct();
        require_once __DIR__ . '/../views/product/listProduct.php';
    }

    // Add a new product
    public function addProduct()
    {
        $categories = $this->categoryModel->getAllCategories();
        $colors = $this->productModel->getAllColor();
        $sizes = $this->productModel->getAllSize();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $sale_price = $_POST['sale_price'];
            $slug = $_POST['slug'];
            $status = $_POST['status'];
            $category_id = $_POST['category_id'];
            $image = null;

            // Handle image upload
            if (!empty($_FILES['image']['name'])) {
                $upload_dir = __DIR__ . '/../../upload/';
                $image = uniqid() . '-' . basename($_FILES['image']['name']);
                $target_file = $upload_dir . $image;

                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }

                if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                    die("Lỗi: Không thể tải ảnh lên.");
                }
            }

            // Save product and get the product_id
            $product_id = $this->productModel->save($name, $image, $price, $sale_price, $slug, $description, $status, $category_id);

            // Save variants
            if (isset($_POST['colors']) && isset($_POST['sizes'])) {
                foreach ($_POST['colors'] as $color_id) {
                    foreach ($_POST['sizes'] as $size_id) {
                        $this->productModel->saveVariant($product_id, $color_id, $size_id);
                    }
                }
            }

            // Redirect to product list
            header('Location: /duan1/admin/index.php?act=sanpham&page=list');
            exit();
        }

        require_once __DIR__ . '/../views/product/addProduct.php';
    }

    // Edit a product
    public function editProduct()
    {
        if (!isset($_GET['product_id']) || !is_numeric($_GET['product_id'])) {
            die("❌ Lỗi: ID sản phẩm không hợp lệ!");
        }

        $id = $_GET['product_id'];
        $product = $this->productModel->getProductById($id);

        if (!$product) {
            die("❌ Lỗi: Sản phẩm không tồn tại.");
        }

        $categories = $this->categoryModel->getAllCategories();
        $colors = $this->productModel->getAllColor();
        $sizes = $this->productModel->getAllSize();
        $variants = $this->productModel->getProductVariant($id);

        require_once __DIR__ . '/../views/product/editProduct.php';
    }
    // Update a product
    public function updateProduct() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['product_id'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $sale_price = $_POST['sale_price'];
            $slug = $_POST['slug'];
            $status = $_POST['status'];
            $category_id = $_POST['category_id'];
            $image = $_POST['current_image'];
    
            // Handle image upload
            if (!empty($_FILES['image']['name'])) {
                $upload_dir = __DIR__ . '/../../upload/';
                $image = uniqid() . '-' . basename($_FILES['image']['name']);
                $target_file = $upload_dir . $image;
    
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
    
                if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                    die("Lỗi: Không thể tải ảnh lên.");
                }
            }
    
            // Update product
            $this->productModel->update($id, $name, $description, $status, $image, $price, $sale_price, $slug, $category_id);
    
            // Lấy danh sách biến thể hiện tại
            $currentVariants = $this->productModel->getProductVariant($id);
    
            // Tạo danh sách biến thể mới từ form
            $newVariants = [];
            if (isset($_POST['colors']) && isset($_POST['sizes'])) {
                foreach ($_POST['colors'] as $color_id) {
                    foreach ($_POST['sizes'] as $size_id) {
                        $newVariants[] = ['color_id' => $color_id, 'size_id' => $size_id];
                    }
                }
            }
    
            // Xóa các biến thể không còn được chọn
            foreach ($currentVariants as $variant) {
                $existsInNew = false;
                foreach ($newVariants as $newVariant) {
                    if ($variant['variant_color_id'] == $newVariant['color_id'] &&
                        $variant['variant_size_id'] == $newVariant['size_id']) {
                        $existsInNew = true;
                        break;
                    }
                }
    
                if (!$existsInNew) {
                    $this->productModel->deleteVariant($variant['product_variant_id']);
                }
            }
    
            // Thêm các biến thể mới
            foreach ($newVariants as $newVariant) {
                $existsInCurrent = false;
                foreach ($currentVariants as $variant) {
                    if ($variant['variant_color_id'] == $newVariant['color_id'] &&
                        $variant['variant_size_id'] == $newVariant['size_id']) {
                        $existsInCurrent = true;
                        break;
                    }
                }
    
                if (!$existsInCurrent) {
                    $this->productModel->saveVariant($id, $newVariant['color_id'], $newVariant['size_id']);
                }
            }
    
            // Redirect to product list
            header('Location: /duan1/admin/index.php?act=sanpham&page=list');
            exit();
        }
    }

    //Thêm phương thức variantExists kiểm tra xem biến thể đã tồn tại hay chưa trước khi thêm mới.
    public function variantExists($product_id, $color_id, $size_id)
    {
        $sql = "SELECT COUNT(*) FROM product_variants 
                WHERE product_id = ? AND variant_color_id = ? AND variant_size_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$product_id, $color_id, $size_id]);
        return $stmt->fetchColumn() > 0;
    }

    // Delete a product
    public function deleteProduct() {
        if (!isset($_GET['product_id']) || !is_numeric($_GET['product_id'])) {
            die("❌ Lỗi: ID sản phẩm không hợp lệ!");
        }
    
        $id = $_GET['product_id'];
        $product = $this->productModel->getProductById($id);
    
        if (!$product) {
            die("❌ Lỗi: Sản phẩm không tồn tại.");
        }
    
        try {
            // Xóa các biến thể và dữ liệu liên quan
            $this->productModel->deleteVariants($id);
    
            // Xóa sản phẩm
            $this->productModel->delete($id);
    
            // Redirect to the product list with a success message
            $_SESSION['success'] = "Xóa sản phẩm thành công.";
            header('Location: /duan1/admin/index.php?act=sanpham&page=list');
            exit();
        } catch (Exception $e) {
            die("❌ Lỗi: " . $e->getMessage());
        }
    }

}
