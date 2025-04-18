<?php
require_once __DIR__ . '/../../commons/connect.php';

class ProductAdminController
{
    private $conn;

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    // Hiển thị danh sách sản phẩm
    public function index()
    {
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.category_id 
                ORDER BY p.created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        include_once __DIR__ . '/../views/product/list.php';
    }

    // Kiểm tra sản phẩm tồn tại
    private function checkProductExists($name, $excludeId = null)
    {
        if ($excludeId) {
            $sql = "SELECT COUNT(*) FROM products WHERE LOWER(TRIM(name)) = LOWER(TRIM(?)) AND product_id != ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([trim($name), $excludeId]);
        } else {
            $sql = "SELECT COUNT(*) FROM products WHERE LOWER(TRIM(name)) = LOWER(TRIM(?))";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([trim($name)]);
        }
        return $stmt->fetchColumn() > 0;
    }

    // Thêm sản phẩm mới
    public function create($data)
    {
        try {
            // Validate dữ liệu
            if (empty($data['name'])) {
                $_SESSION['error'] = 'Tên sản phẩm không được để trống!';
                header('Location: index.php?act=sanpham&page=add');
                exit();
            }

            // Kiểm tra tên sản phẩm đã tồn tại chưa (không phân biệt hoa thường và khoảng trắng)
            if ($this->checkProductExists($data['name'])) {
                $_SESSION['error'] = 'Sản phẩm với tên này đã tồn tại! Vui lòng chọn tên khác.';
                header('Location: index.php?act=sanpham&page=add');
                exit();
            }

            $sql = "INSERT INTO products (name, price, sale_price, image, description, slug, category_id, status) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $this->conn->prepare($sql);
            $result = $stmt->execute([
                trim($data['name']), // Loại bỏ khoảng trắng thừa
                $data['price'],
                $data['sale_price'],
                $data['image'],
                $data['description'],
                $data['slug'],
                $data['category_id'],
                $data['status'] ?? 1
            ]);

            if ($result) {
                $_SESSION['success'] = 'Thêm sản phẩm thành công!';
                header('Location: index.php?act=sanpham&page=list');
            } else {
                $_SESSION['error'] = 'Thêm sản phẩm thất bại!';
                header('Location: index.php?act=sanpham&page=add');
            }
        } catch (PDOException $e) {
            $_SESSION['error'] = 'Lỗi thêm sản phẩm: ' . $e->getMessage();
            header('Location: index.php?act=sanpham&page=add');
        }
        exit();
    }

    // Hiển thị form thêm sản phẩm
    public function add()
    {
        // Lấy danh sách danh mục để hiển thị trong form
        $sql = "SELECT * FROM categories WHERE status = 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        include_once __DIR__ . '/../views/product/add.php';
    }

    // Hiển thị chi tiết sản phẩm
    public function detail($id)
    {
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.category_id 
                WHERE p.product_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$product) {
            $_SESSION['error'] = 'Không tìm thấy sản phẩm!';
            header('Location: index.php?act=sanpham&page=list');
            exit();
        }

        include_once __DIR__ . '/../views/product/detail.php';
    }

    // Hiển thị form sửa sản phẩm
    public function edit($id)
    {
        // Lấy thông tin sản phẩm
        $sql = "SELECT * FROM products WHERE product_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$product) {
            $_SESSION['error'] = 'Không tìm thấy sản phẩm!';
            header('Location: index.php?act=sanpham&page=list');
            exit();
        }

        // Lấy danh sách danh mục
        $sql = "SELECT * FROM categories WHERE status = 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        include_once __DIR__ . '/../views/product/edit.php';
    }

    // Cập nhật sản phẩm
    public function update($id, $data)
    {
        try {
            // Validate dữ liệu
            if (empty($data['name'])) {
                $_SESSION['error'] = 'Tên sản phẩm không được để trống!';
                header('Location: index.php?act=sanpham&page=edit&id=' . $id);
                exit();
            }

            // Kiểm tra xem tên mới có trùng với sản phẩm khác không
            if ($this->checkProductExists($data['name'], $id)) {
                $_SESSION['error'] = 'Sản phẩm với tên này đã tồn tại! Vui lòng chọn tên khác.';
                header('Location: index.php?act=sanpham&page=edit&id=' . $id);
                exit();
            }

            $sql = "UPDATE products 
                    SET name = ?, price = ?, sale_price = ?, image = ?, 
                        description = ?, slug = ?, category_id = ?, status = ? 
                    WHERE product_id = ?";

            $stmt = $this->conn->prepare($sql);
            $result = $stmt->execute([
                trim($data['name']), // Loại bỏ khoảng trắng thừa
                $data['price'],
                $data['sale_price'],
                $data['image'],
                $data['description'],
                $data['slug'],
                $data['category_id'],
                $data['status'] ?? 1,
                $id
            ]);

            if ($result) {
                $_SESSION['success'] = 'Cập nhật sản phẩm thành công!';
            } else {
                $_SESSION['error'] = 'Cập nhật sản phẩm thất bại!';
            }
        } catch (PDOException $e) {
            $_SESSION['error'] = 'Lỗi cập nhật: ' . $e->getMessage();
        }

        header('Location: index.php?act=sanpham&page=list');
        exit();
    }

    // Xóa sản phẩm
    public function delete($id)
    {
        try {
            $sql = "DELETE FROM products WHERE product_id = ?";
            $stmt = $this->conn->prepare($sql);
            $result = $stmt->execute([$id]);

            if ($result) {
                $_SESSION['success'] = 'Xóa sản phẩm thành công!';
            } else {
                $_SESSION['error'] = 'Xóa sản phẩm thất bại!';
            }
        } catch (PDOException $e) {
            $_SESSION['error'] = 'Lỗi xóa sản phẩm: ' . $e->getMessage();
        }

        header('Location: index.php?act=sanpham&page=list');
        exit();
    }
}
