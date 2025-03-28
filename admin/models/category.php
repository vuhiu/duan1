<?php
require_once __DIR__ . '/../../commons/connect.php'; 

class Category {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    public function getAllCategories() {
        $stmt = $this->conn->query("SELECT category_id, name, description, status, image FROM categories");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($name, $description, $status, $image) {
        $stmt = $this->conn->prepare("INSERT INTO categories (name, description, status, image) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $description, $status, $image]);
    }

    public function getById($category_id) {
        $stmt = $this->conn->prepare("SELECT * FROM categories WHERE category_id = ?");
        $stmt->execute([$category_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($category_id, $name, $description, $status, $image) {
        $stmt = $this->conn->prepare("UPDATE categories SET name = ?, description = ?, status = ?, image = ? WHERE category_id = ?");
        $stmt->execute([$name, $description, $status, $image, $category_id]);
    }

    public function delete($category_id) {
        $stmt = $this->conn->prepare("DELETE FROM categories WHERE category_id = ?");
        $stmt->execute([$category_id]);
    }
}
?>