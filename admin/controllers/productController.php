<?php
ob_start();
require_once __DIR__ . '/../models/product.php';
require_once __DIR__ . '/../../commons/connect.php'; 

class ProductController {
    public $productModel;

    public function __construct() {
        $this->productModel = new Product();
    }

    public function getList() {
        $products = $this->productModel->getAllProduct();
        require_once __DIR__ . '/../views/product/listProduct.php';
    }

    public function addProduct() {
        global $conn;
        $categories = $conn->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC);
    
        if (isset($_POST['them'])) {
            $name = $_POST['name'];
            $price = $_POST['price'];
            $sale_price = $_POST['sale_price'];
            $slug = $_POST['slug'];
            $description = $_POST['description'];
            $status = $_POST['status'];
            $category_id = $_POST['category_id'];
            $image = null;
    
            if (!empty($_FILES['image']['name'])) {
                $file = $_FILES['image'];
                $image = basename($file['name']);
                $from = $file['tmp_name'];
    
                // Sử dụng đường dẫn tuyệt đối để lưu ảnh
                $upload_dir = __DIR__ . '/../upload/'; 
    
                // Kiểm tra thư mục có tồn tại không, nếu chưa thì tạo mới
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
    
                $to = $upload_dir . $image;
    
                // Kiểm tra và di chuyển file
                if (!move_uploaded_file($from, $to)) {
                    die("Lỗi: Không thể tải ảnh lên.");
                }
            }
    
            $this->productModel->save($name, $image, $price, $sale_price, $slug, $description, $status, $category_id);
            
            // Đảm bảo không có output trước khi chuyển hướng
            ob_clean();
            header('Location:?act=sanpham&page=list');
            exit();
        }
    
        require_once __DIR__ . '/../views/product/addProduct.php';
    }

    public function edit() {
        $product = $this->productModel->getProductById($id);
        
    
        if (!$product) {
            die("Sản phẩm không tồn tại.");
        }
    
        include __DIR__ . '/../views/product/edit.php';
    }
    
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => trim($_POST['name']),
                'description' => trim($_POST['description']),
                'price' => floatval($_POST['price']),
                'sale_price' => floatval($_POST['sale_price']),
                'slug' => trim($_POST['slug']),
                'status' => intval($_POST['status']),
                'category_id' => intval($_POST['category_id']),
                'image' => $_POST['current_image']
            ];
    
            // Xử lý upload ảnh mới
            if (!empty($_FILES['image']['name'])) {
                $target_dir = "uploads/";
                $data['image'] = basename($_FILES["image"]["name"]);
                move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir . $data['image']);
            }
    
            $this->productModel->update($id, $data);
            header("Location: ?act=sanpham&page=list");
            exit();
        }
    }
    

    public function delete() {
        if (!isset($_GET['product_id']) || !is_numeric($_GET['product_id'])) {
            die("❌ Lỗi: ID sản phẩm không hợp lệ!");
        }
    
        $id = $_GET['product_id'];
    
        // Kiểm tra xem sản phẩm có tồn tại không
        $product = $this->productModel->getProductById($id);
        if (!$product) {
            die("❌ Lỗi: Sản phẩm không tồn tại!");
        }
    
        // Xóa sản phẩm
        $this->productModel->delete($id);
    
        // Chắc chắn không có output trước khi chuyển hướng
        ob_clean();
        header('Location: ?act=sanpham&page=list');
        exit();
    }
    
    
    
}
ob_end_flush();
?>
