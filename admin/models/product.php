<?php
require_once __DIR__ . '/../../commons/connect.php';

class Product
{
    private $conn;

    public function __construct()
    {
        global $conn; // Sử dụng biến toàn cục $conn
        $this->conn = $conn;
    }

    // Getter để trả về kết nối cơ sở dữ liệu
    public function getConnection()
    {
        return $this->conn;
    }

    // Get all colors
    public function getAllColor()
    {
        $sql = "SELECT * FROM variant_colors";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get all sizes
    public function getAllSize()
    {
        $sql = "SELECT * FROM variant_size";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get all categories
    public function getAllCategory()
    {
        $sql = "SELECT * FROM categories";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Add a new product
    public function save($name, $image, $price, $sale_price, $slug, $description, $status, $category_id)
    {
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
    public function update($id, $name, $description, $status, $image, $price, $sale_price, $slug, $category_id)
    {
        $sql = "UPDATE products SET name = ?, description = ?, status = ?, image = ?, price = ?, sale_price = ?, slug = ?, category_id = ? WHERE product_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$name, $description, $status, $image, $price, $sale_price, $slug, $category_id, $id]);
    }


    // Delete a product
    public function delete($id)
    {
        try {
            $this->conn->beginTransaction();

            // 1. Kiểm tra xem sản phẩm có trong đơn hàng không
            $sql = "SELECT COUNT(*) FROM orders o 
                   INNER JOIN product_variants pv ON o.variant_id = pv.product_variant_id 
                   WHERE pv.product_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$id]);
            if ($stmt->fetchColumn() > 0) {
                throw new Exception("Không thể xóa sản phẩm vì đã có trong đơn hàng!");
            }

            // 2. Xóa các bản ghi trong cart_items
            $sql = "DELETE FROM cart_items WHERE variant_id IN (
                SELECT product_variant_id FROM product_variants WHERE product_id = ?
            )";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$id]);

            // 3. Xóa các biến thể
            $sql = "DELETE FROM product_variants WHERE product_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$id]);

            // 4. Xóa các ảnh trong gallery
            $sql = "DELETE FROM product_galleries WHERE product_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$id]);

            // 5. Cuối cùng xóa sản phẩm
            $sql = "DELETE FROM products WHERE product_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$id]);

            $this->conn->commit();
            return true;
        } catch (PDOException $e) {
            $this->conn->rollBack();
            throw new Exception("Không thể xóa sản phẩm: " . $e->getMessage());
        }
    }

    // Get a product by ID

    public function getProductById($product_id)
    {
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
    public function getProductVariant($product_id)
    {
        $sql = "SELECT
                    product_variants.product_variant_id,
                    product_variants.quantity,
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

    public function deleteVariants($product_id)
    {
        // Lấy danh sách tất cả các biến thể của sản phẩm
        $variants = $this->getProductVariant($product_id);

        // Xóa các bản ghi liên quan trong bảng cart_items
        foreach ($variants as $variant) {
            $sql = "DELETE FROM cart_items WHERE variant_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$variant['product_variant_id']]);
        }

        // Xóa tất cả các biến thể của sản phẩm
        $sql = "DELETE FROM product_variants WHERE product_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$product_id]);
    }

    // Save a product variant
    public function saveVariant($product_id, $color_id, $size_id, $price, $sale_price, $quantity = 0)
    {
        $sql = "INSERT INTO product_variants (product_id, variant_color_id, variant_size_id, price, sale_price, quantity)
                VALUES (:product_id, :color_id, :size_id, :price, :sale_price, :quantity)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':product_id' => $product_id,
            ':color_id' => $color_id,
            ':size_id' => $size_id,
            ':price' => $price,
            ':sale_price' => $sale_price,
            ':quantity' => $quantity
        ]);
    }

    // Delete all variants for a product
    public function deleteVariant($variant_id)
    {
        // Xóa các bản ghi liên quan trong bảng cart_items
        $sql = "DELETE FROM cart_items WHERE variant_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$variant_id]);

        // Xóa biến thể trong bảng product_variants
        $sql = "DELETE FROM product_variants WHERE product_variant_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$variant_id]);
    }


    // List all products with variants and categories
    public function listProduct()
    {
        $sql = "SELECT 
                    products.product_id,
                    products.name AS product_name,
                    products.price AS product_price,
                    products.sale_price AS product_sale_price,
                    products.image AS product_image,
                    products.slug AS product_slug,
                     products.description AS description,
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
    public function addGallery($product_id, $image)
    {
        $sql = "INSERT INTO product_galleries (product_id, image) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$product_id, $image]);
    }

    // Get product gallery by product ID
    public function getProductGalleryById($product_id)
    {
        $sql = "SELECT * FROM product_galleries WHERE product_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$product_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Delete a product gallery image
    public function removeGallery($gallery_id)
    {
        $sql = "DELETE FROM product_galleries WHERE product_gallery_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$gallery_id]);
    }

    // Kiểm tra xem danh mục có sản phẩm nào không
    public function hasProductsInCategory($category_id)
    {
        $sql = "SELECT COUNT(*) FROM products WHERE category_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$category_id]);
        $count = $stmt->fetchColumn();
        return $count > 0;
    }

    // Kiểm tra xem sản phẩm có trong đơn hàng nào không
    public function hasOrders($product_id)
    {
        $sql = "SELECT COUNT(*) FROM order_details od 
                INNER JOIN product_variants pv ON od.variant_id = pv.product_variant_id 
                WHERE pv.product_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$product_id]);
        return $stmt->fetchColumn() > 0;
    }

    // Kiểm tra xem biến thể có trong đơn hàng nào không
    public function isVariantInOrder($variant_id)
    {
        $sql = "SELECT COUNT(*) FROM orders WHERE variant_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$variant_id]);
        return $stmt->fetchColumn() > 0;
    }

    // Cập nhật số lượng cho biến thể sản phẩm
    public function updateVariantQuantity($product_id, $color_id, $size_id, $quantity)
    {
        try {
            $sql = "UPDATE product_variants 
                    SET quantity = :quantity 
                    WHERE product_id = :product_id 
                    AND variant_color_id = :color_id 
                    AND variant_size_id = :size_id";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':product_id' => $product_id,
                ':color_id' => $color_id,
                ':size_id' => $size_id,
                ':quantity' => $quantity
            ]);

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            throw new Exception("Lỗi cập nhật số lượng sản phẩm: " . $e->getMessage());
        }
    }
}
