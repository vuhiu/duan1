<?php
ob_start();
require_once __DIR__ . '/../models/product.php';
require_once __DIR__ . '/../models/category.php';
require_once __DIR__ . '/../../commons/connect.php';

class ProductController
{
    public $productModel;
    public $categoryModel;
    public $conn;

    public function __construct()
    {
        $this->productModel = new Product();
        $this->categoryModel = new Category();
        $this->conn = $this->productModel->getConnection();
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
            try {
                $name = $_POST['name'];
                $description = $_POST['description'];
                if (!isset($_POST['price']) || $_POST['price'] === '') {
                    throw new Exception("Giá sản phẩm không được để trống.");
                }

                if (!isset($_POST['sale_price']) || $_POST['sale_price'] === '') {
                    $_POST['sale_price'] = 0;
                }

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
                        throw new Exception("Không thể tải ảnh lên.");
                    }
                }

                // Save product and get the product_id
                $product_id = $this->productModel->save($name, $image, $price, $sale_price, $slug, $description, $status, $category_id);

                // Save variants
                if (isset($_POST['colors']) && isset($_POST['sizes'])) {
                    foreach ($_POST['colors'] as $color_id) {
                        foreach ($_POST['sizes'] as $size_id) {
                            if (!$this->variantExists($product_id, $color_id, $size_id)) {
                                $this->productModel->saveVariant(
                                    $product_id,
                                    $color_id,
                                    $size_id,
                                    $price,
                                    $sale_price,
                                    $_POST['quantity']
                                );
                            }
                        }
                    }
                }

                $_SESSION['success'] = "Thêm sản phẩm thành công!";
                header('Location: /duan1/admin/index.php?act=sanpham&page=list');
                exit();
            } catch (Exception $e) {
                $_SESSION['error'] = "Lỗi: " . $e->getMessage();
                header('Location: /duan1/admin/index.php?act=sanpham&page=them');
                exit();
            }
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
    public function updateProduct()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $this->conn->beginTransaction();

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
                        throw new Exception("Lỗi: Không thể tải ảnh lên.");
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
                            $newVariants[] = [
                                'color_id' => $color_id,
                                'size_id' => $size_id,
                                'quantity' => $_POST['variant_quantities'][$color_id][$size_id] ?? 0
                            ];
                        }
                    }
                }

                // Kiểm tra và xử lý các biến thể
                foreach ($currentVariants as $variant) {
                    $existsInNew = false;
                    foreach ($newVariants as $newVariant) {
                        if (
                            $variant['variant_color_id'] == $newVariant['color_id'] &&
                            $variant['variant_size_id'] == $newVariant['size_id']
                        ) {
                            $existsInNew = true;
                            // Cập nhật số lượng cho biến thể đã tồn tại
                            $this->productModel->updateVariantQuantity(
                                $id,
                                $newVariant['color_id'],
                                $newVariant['size_id'],
                                $newVariant['quantity']
                            );
                            break;
                        }
                    }

                    // Chỉ xóa biến thể nếu nó không tồn tại trong đơn hàng nào
                    if (!$existsInNew) {
                        if (!$this->productModel->isVariantInOrder($variant['product_variant_id'])) {
                            $this->productModel->deleteVariant($variant['product_variant_id']);
                        }
                    }
                }

                // Thêm các biến thể mới
                foreach ($newVariants as $newVariant) {
                    if (!$this->variantExists($id, $newVariant['color_id'], $newVariant['size_id'])) {
                        $this->productModel->saveVariant(
                            $id,
                            $newVariant['color_id'],
                            $newVariant['size_id'],
                            $price,
                            $sale_price,
                            $newVariant['quantity']
                        );
                    }
                }

                $this->conn->commit();
                $_SESSION['success'] = "Cập nhật sản phẩm thành công";

                // Redirect to product list
                header('Location: /duan1/admin/index.php?act=sanpham&page=list');
                exit();
            } catch (Exception $e) {
                $this->conn->rollBack();
                $_SESSION['error'] = $e->getMessage();
                header('Location: /duan1/admin/index.php?act=sanpham&page=edit&product_id=' . $id);
                exit();
            }
        }
    }

    //Thêm phương thức variantExists kiểm tra xem biến thể đã tồn tại hay chưa trước khi thêm mới.
    public function variantExists($product_id, $color_id, $size_id)
    {
        $sql = "SELECT COUNT(*) FROM product_variants 
                WHERE product_id = ? AND variant_color_id = ? AND variant_size_id = ?";
        $stmt = $this->productModel->getConnection()->prepare($sql);
        $stmt->execute([$product_id, $color_id, $size_id]);
        $count = $stmt->fetchColumn();

        return $count > 0;
    }
    // Save a product variant
    public function saveVariant($product_id, $color_id, $size_id, $price, $sale_price, $quantity)
    {
        if ($price === null || $sale_price === null) {
            die("❌ Lỗi: Giá hoặc giá khuyến mãi không hợp lệ.");
        }

        $this->productModel->saveVariant($product_id, $color_id, $size_id, $price, $sale_price, $quantity);
    }

    // Delete a product
    public function deleteProduct()
    {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception("ID sản phẩm không hợp lệ");
            }

            $product_id = $_GET['id'];

            // Kiểm tra sản phẩm tồn tại
            $product = $this->productModel->getProductById($product_id);
            if (!$product) {
                throw new Exception("Không tìm thấy sản phẩm");
            }

            // Thực hiện xóa sản phẩm
            if ($this->productModel->delete($product_id)) {
                $_SESSION['success'] = "Xóa sản phẩm thành công";
            }
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        // Redirect về trang danh sách
        header("Location: index.php?act=sanpham&page=list");
        exit;
    }
}
