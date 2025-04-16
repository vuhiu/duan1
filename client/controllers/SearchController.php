<?php
class SearchController
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function index()
    {
        if (!isset($_GET['keyword']) || empty($_GET['keyword'])) {
            header('Location: /duan1/index.php');
            exit();
        }

        $keyword = $_GET['keyword'];
        $category_id = $_GET['category'] ?? 0;

        // Truy vấn sản phẩm
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.category_id 
                WHERE p.name LIKE :keyword 
                OR p.description LIKE :keyword";

        if ($category_id > 0) {
            $sql .= " AND p.category_id = :category_id";
        }

        $sql .= " ORDER BY p.created_at DESC";

        $stmt = $this->conn->prepare($sql);
        $params = [':keyword' => "%$keyword%"];
        if ($category_id > 0) {
            $params[':category_id'] = $category_id;
        }
        $stmt->execute($params);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Lấy danh mục
        $stmt = $this->conn->prepare("SELECT * FROM categories ORDER BY name");
        $stmt->execute();
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Hiển thị view
        include 'client/views/product/search.php';
    }
} 