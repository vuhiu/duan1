<?php
ob_start();
require_once __DIR__ . '/../models/category.php';
require_once __DIR__ . '/../models/product.php';

class CategoryController {
    public $categoryModel;

    public function __construct() {
        $this->categoryModel = new Category();
    }

    public function getList() {
        $categories = $this->categoryModel->getAllCategories();
        require_once __DIR__ . '/../views/category/listCategory.php';
    }

    public function addCategory() {
        if (isset($_POST['them'])) {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $status = $_POST['status'];
            $image = null;
            // Kiểm tra nếu có hình ảnh được tải lên
            if (!empty($_FILES['image']['name'])) {
                $file = $_FILES['image'];
                $image = basename($file['name']);
                $from = $file['tmp_name'];
                $upload_dir = __DIR__ . '/../upload/';

                // Tạo thư mục nếu chưa tồn tại
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }

                $to = $upload_dir . $image;

                // Di chuyển tệp tải lên vào thư mục upload
                if (!move_uploaded_file($from, $to)) {
                    die("Lỗi khi tải lên hình ảnh.");
                }
            }

            // Gọi phương thức create trong model để lưu dữ liệu vào cơ sở dữ liệu
            $this->categoryModel->create($name, $description, $status, $image);

            ob_clean();
            header('Location:?act=danhmuc&page=list');
            exit();
        }

        require_once __DIR__ . '/../views/category/addCategory.php';
    }

    public function editCategory() {
        if (!isset($_GET['category_id']) || !is_numeric($_GET['category_id'])) {
            die("❌ Lỗi: ID danh mục không hợp lệ!");
        }

        $id = $_GET['category_id'];
        $category = $this->categoryModel->getById($id);

        if (!$category) {
            die("Danh mục không tồn tại.");
        }

        require_once __DIR__ . '/../views/category/editCategory.php';
    }

    public function updateCategory() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['category_id'];
            $name = trim($_POST['name']);
            $description = trim($_POST['description']);
            $status = trim($_POST['status']);
            $image = $_POST['current_image'];

            if (!empty($_FILES['image']['name'])) {
                $file = $_FILES['image'];
                $image = basename($file['name']);
                $from = $file['tmp_name'];
                $upload_dir = __DIR__ . '/../upload/';

                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }

                $to = $upload_dir . $image;

                if (!move_uploaded_file($from, $to)) {
                    die("Lỗi khi tải lên hình ảnh.");
                }
            } else {
                $image = $_POST['current_image']; // Giữ hình ảnh hiện tại nếu không tải lên hình ảnh mới
            }
            // Gọi phương thức update trong model
            $this->categoryModel->update($id, $name, $description, $status, $image);

            // Chuyển hướng về danh sách danh mục
            header("Location: ?act=danhmuc&page=list");
            exit();
        }
    }

    
    public function deleteCategory() {
        if (!isset($_GET['category_id']) || !is_numeric($_GET['category_id'])) {
            die("❌ Lỗi: Mã danh mục không hợp lệ!");
        }

        $id = (int)$_GET['category_id'];
        $category = $this->categoryModel->getById($id);

        if (!$category) {
            die("❌ Lỗi: Danh mục không tồn tại!");
        }

        // Kiểm tra xem danh mục có sản phẩm nào không
        $productModel = new Product();
        if ($productModel->hasProductsInCategory($id)) {
            die("❌ Lỗi: Không thể xóa danh mục vì vẫn còn sản phẩm thuộc danh mục này!");
        }

        $this->categoryModel->delete($id);

        // Xóa bộ đệm đầu ra trước khi chuyển hướng
        if (ob_get_length()) {
            ob_clean();
        }

        header('Location: ?act=danhmuc&page=list');
        exit();
    }
}
ob_end_flush();
?>