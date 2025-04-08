<?php
require_once __DIR__ . '/../../commons/connect.php';

class Product {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    // Get all colors
    public function getAllColor() {
        $sql = "SELECT * FROM variant_colors";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get all sizes
    public function getAllSize() {
        $sql = "SELECT * FROM variant_size";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get all categories
    public function getAllCategory() {
        $sql = "SELECT * FROM categories";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Add a new product
    public function save($name, $image, $price, $sale_price, $slug, $description, $status, $category_id) {
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
    
        // Return the ID of the newly inserted product
        return $this->conn->lastInsertId();
    }

    // Update a product
    public function update($id, $name, $description, $status, $image, $price, $sale_price, $slug, $category_id) {
        $sql = "UPDATE products SET name = ?, description = ?, status = ?, image = ?, price = ?, sale_price = ?, slug = ?, category_id = ? WHERE product_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$name, $description, $status, $image, $price, $sale_price, $slug, $category_id, $id]);
    }

    // Delete a product
    public function delete($id) {
        // Delete product variants first
        $this->deleteVariants($id);
    
        // Delete the product
        $sql = "DELETE FROM products WHERE product_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
    }

    // Get a product by ID

    public function getProductById($product_id) {
        $sql = "SELECT 
                    products.product_id,
                    products.name AS product_name,
                    products.price AS product_price,
                    products.sale_price AS product_sale_price,
                    products.image AS product_image,
                    products.status AS product_status,
                    products.slug AS product_slug,
                    products.description AS product_description,
                    categories.category_id,
                    categories.name AS category_name
                FROM products
                LEFT JOIN categories ON products.category_id = categories.category_id
                WHERE products.product_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$product_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get product variants by product ID
    public function getProductVariant($product_id) {
        $sql = "SELECT
                    product_variants.product_variant_id,
                    variant_colors.variant_color_id,
                    variant_size.variant_size_id,
                    variant_colors.color_name,
                    variant_size.size_name
                FROM product_variants
                LEFT JOIN variant_colors ON product_variants.variant_color_id = variant_colors.variant_color_id
                LEFT JOIN variant_size ON product_variants.variant_size_id = variant_size.variant_size_id
                WHERE product_variants.product_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$product_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Save a product variant
    public function saveVariant($product_id, $color_id, $size_id) {
        $sql = "INSERT INTO product_variants (product_id, variant_color_id, variant_size_id)
                VALUES (:product_id, :color_id, :size_id)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':product_id' => $product_id,
            ':color_id' => $color_id,
            ':size_id' => $size_id
        ]);
    }

    // Delete all variants for a product
    public function deleteVariants($product_id) {
        $sql = "DELETE FROM product_variants WHERE product_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$product_id]);
    }

    // List all products with variants and categories
    public function listProduct() {
        $sql = "SELECT 
                    products.product_id,
                    products.name AS product_name,
                    products.price AS product_price,
                    products.sale_price AS product_sale_price,
                    products.image AS product_image,
                    products.slug AS product_slug,
                    products.status AS product_status,
                    categories.category_id,
                    categories.name AS category_name,
                    product_variants.product_id AS product_variant_id,
                    variant_colors.color_name AS variant_color_name,
                    variant_size.size_name AS variant_size_name
                FROM products
                LEFT JOIN categories ON products.category_id = categories.category_id
                LEFT JOIN product_variants ON products.product_id = product_variants.product_id
                LEFT JOIN variant_colors ON product_variants.variant_color_id = variant_colors.variant_color_id
                LEFT JOIN variant_size ON product_variants.variant_size_id = variant_size.variant_size_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $listProduct = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $groupedProducts = [];
        foreach ($listProduct as $product) {
            if (!isset($groupedProducts[$product['product_id']])) {
                $groupedProducts[$product['product_id']] = $product;
                $groupedProducts[$product['product_id']]['variants'] = [];
            }
            $groupedProducts[$product['product_id']]['variants'][] = [
                'product_id' => $product['product_id'],
                'product_variant_color' => $product['variant_color_name'],
                'product_variant_size' => $product['variant_size_name']
            ];
        }
        return $groupedProducts;
    }

    // Add a product gallery image
    public function addGallery($product_id, $image) {
        $sql = "INSERT INTO product_galleries (product_id, image) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$product_id, $image]);
    }

    // Get product gallery by product ID
    public function getProductGalleryById($product_id) {
        $sql = "SELECT * FROM product_galleries WHERE product_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$product_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Delete a product gallery image
    public function removeGallery($gallery_id) {
        $sql = "DELETE FROM product_galleries WHERE product_gallery_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$gallery_id]);
    }
}
?>