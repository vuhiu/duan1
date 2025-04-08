<?php
require_once __DIR__ . '/../../client/models/ProductModel.php';

class ClientProductController {
    private $productModel;

    public function __construct($productModel)
    {
        $this->productModel = $productModel;
    }

    // Danh sách sản phẩm
    public function listProducts() {
        $products = $this->productModel->getProducts();
        require 'admin/modules/sanpham/list.php';
    }

    

public function addProduct() {
    global $conn;
    $categories = $conn->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC);

    if (isset($_POST['them'])) {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $sale_price = $_POST['sale_price'];
        $slug = $_POST['slug'];
        $status = $_POST['status'];
        $category_id = $_POST['category_id'];
        $image = null;

        if (!empty($_FILES['image']['name'])) {
            // Sử dụng đường dẫn tuyệt đối để lưu ảnh
            $upload_dir = __DIR__ . '/../../upload/';
            $image = basename($_FILES['image']['name']);
            $target_file = $upload_dir . $image;

            // Kiểm tra thư mục có tồn tại không, nếu chưa thì tạo mới
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            // Kiểm tra và di chuyển file
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                die("Lỗi: Không thể tải ảnh lên.");
            }
        }

        $this->productModel->save($name, $image, $price, $sale_price, $slug, $description, $status, $category_id);

        // Đảm bảo không có output trước khi chuyển hướng
        ob_clean();
        header('Location: ?act=sanpham&page=list');
        exit();
    }

    require_once __DIR__ . '/../views/product/addProduct.php';
}
public function editProduct() {
    if (!isset($_GET['product_id']) || !is_numeric($_GET['product_id'])) {
        die("❌ Lỗi: ID sản phẩm không hợp lệ!");
    }

    $id = $_GET['product_id'];
    $product = $this->productModel->getProductById($id);

    if (!$product) {
        die("❌ Lỗi: Sản phẩm không tồn tại.");
    }

    $categories = $this->categoryModel->getAllCategories();

    // Pass the product and categories data to the view
    require_once __DIR__ . '/../views/product/editProduct.php';
}
    
public function updateProduct() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['product_id'];
        $name = trim($_POST['name']);
        $description = trim($_POST['description']);
        $price = trim($_POST['price']);
        $sale_price = trim($_POST['sale_price']);
        $slug = trim($_POST['slug']);
        $status = trim($_POST['status']);
        $image = $_POST['current_image'];

        if (!empty($_FILES['image']['name'])) {
            $file = $_FILES['image'];
            $image = basename($file['name']);
            $from = $file['tmp_name'];
            $upload_dir = __DIR__ . '/../../upload/';

            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $to = $upload_dir . $image;

            if (!move_uploaded_file($from, $to)) {
                die("Lỗi khi tải lên hình ảnh.");
            }
        }

        // Gọi phương thức update trong model
        $this->productModel->update($id, $name, $description, $status, $image, $price, $sale_price, $slug);

        // Chuyển hướng về danh sách sản phẩm
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
