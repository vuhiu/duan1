<?php
require_once __DIR__ . '/../../commons/connect.php'; 

class Product {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    public function getAllProduct() {
        $sql = "SELECT * FROM products";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function save($name, $image, $price, $sale_price, $slug, $description, $status, $category_id) {
        try {
            $sql = "INSERT INTO products (name, image, price, sale_price, slug, description, status, category_id)
                    VALUES (:name, :image, :price, :sale_price, :slug, :description, :status, :category_id)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':name' => $name,
                ':image' => $image,
                ':price' => $price,
                ':sale_price' => $sale_price,
                ':slug' => $slug,
                ':description' => $description,
                ':status' => $status,
                ':category_id' => $category_id
            ]);
        } catch (PDOException $e) {
            die("Lỗi: " . $e->getMessage());
        }
    }
    public function getProductById($product_id) {
        $sql = "SELECT products.*, categories.name AS category_name 
                FROM products
                LEFT JOIN categories ON products.category_id = categories.category_id
                WHERE products.product_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$product_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $name, $description, $status, $image, $price, $sale_price, $slug) {
        $stmt = $this->conn->prepare("UPDATE products SET name = ?, description = ?, status = ?, image = ?, price = ?, sale_price = ?, slug = ? WHERE product_id = ?");
        $stmt->execute([$name, $description, $status, $image, $price, $sale_price, $slug, $id]);
    }
    
    
   public function delete($id) {
    try {
        $sql = "DELETE FROM products WHERE product_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);

        // Kiểm tra xem có dòng nào bị ảnh hưởng không
        if ($stmt->rowCount() === 0) {
            die("Lỗi: Không thể xóa sản phẩm hoặc sản phẩm không tồn tại.");
        }
    } catch (PDOException $e) {
        die("Lỗi khi xóa: " . $e->getMessage());
    }
}

}
?>
