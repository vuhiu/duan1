<?php
require_once __DIR__ . '/../../commons/connect.php';

class Category
{
    private $conn;

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    public function getAllCategories()
    {
        $stmt = $this->conn->query("SELECT category_id, name, description, status, image FROM categories");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($name, $description, $status, $image)
    {
        $stmt = $this->conn->prepare("INSERT INTO categories (name, description, status, image) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $description, $status, $image]);
    }

    public function getById($category_id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM categories WHERE category_id = ?");
        $stmt->execute([$category_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($category_id, $name, $description, $status, $image)
    {
        $stmt = $this->conn->prepare("UPDATE categories SET name = ?, description = ?, status = ?, image = ? WHERE category_id = ?");
        $stmt->execute([$name, $description, $status, $image, $category_id]);
    }

    public function delete($category_id)
    {
        try {
            $this->conn->beginTransaction();

            // 1. Kiểm tra xem danh mục có sản phẩm không
            $stmt = $this->conn->prepare("SELECT COUNT(*) FROM products WHERE category_id = ?");
            $stmt->execute([$category_id]);
            if ($stmt->fetchColumn() > 0) {
                throw new Exception("Không thể xóa danh mục vì còn sản phẩm thuộc danh mục này!");
            }

            // 2. Xóa danh mục
            $stmt = $this->conn->prepare("DELETE FROM categories WHERE category_id = ?");
            $result = $stmt->execute([$category_id]);

            $this->conn->commit();
            return $result;
        } catch (PDOException $e) {
            $this->conn->rollBack();
            throw new Exception("Lỗi khi xóa danh mục: " . $e->getMessage());
        }
    }
}
