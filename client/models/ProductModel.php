<?php

namespace Client\Models;

require_once __DIR__ . '/../../commons/connect.php';

class ClientProduct
{
    private $pdo;

    public function __construct(\PDO $conn)
    {
        $this->pdo = $conn;
    }

    // Get product by ID
    public function getProductById($product_id)
    {
        $sql = "SELECT 
                    p.product_id, p.name AS product_name, p.image AS product_image, 
                    p.description AS product_description, p.price AS product_price, 
                    p.sale_price AS product_sale_price, 
                    pv.product_variant_id, pv.price, pv.sale_price, 
                    vc.color_name AS product_variant_color, 
                    vs.size_name AS product_variant_size
                FROM products p
                LEFT JOIN product_variants pv ON p.product_id = pv.product_id
                LEFT JOIN variant_colors vc ON pv.variant_color_id = vc.variant_color_id
                LEFT JOIN variant_size vs ON pv.variant_size_id = vs.variant_size_id
                WHERE p.product_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$product_id]);
        $product = $stmt->fetch(\PDO::FETCH_ASSOC);

        // Lấy danh sách biến thể
        if ($product) {
            $product['variants'] = $this->getProductVariants($product_id);
        }

        return $product;
    }

    // Get all products with their variants
    public function getAllProductWithVariants()
    {
        $sql = "SELECT 
                    products.product_id,
                    products.name AS product_name,
                    products.price AS product_price,
                    products.sale_price AS product_sale_price,
                    products.image AS product_image,
                    products.description AS product_description,
                    categories.name AS category_name
                FROM products
                LEFT JOIN categories ON products.category_id = categories.category_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $products = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Lấy biến thể cho từng sản phẩm
        foreach ($products as &$product) {
            $product['variants'] = $this->getProductVariants($product['product_id']);
        }

        return $products;
    }

    // Fetch product variants
    public function getProductVariants($productId)
    {
        $stmt = $this->pdo->prepare("
            SELECT 
                pv.product_variant_id, 
                pv.price, 
                pv.sale_price, 
                pv.quantity, 
                vc.variant_color_id, 
                vc.color_code, 
                vc.color_name, 
                vs.variant_size_id, 
                vs.size_name
            FROM product_variants pv
            LEFT JOIN variant_colors vc ON pv.variant_color_id = vc.variant_color_id
            LEFT JOIN variant_size vs ON pv.variant_size_id = vs.variant_size_id
            WHERE pv.product_id = ?
        ");
        $stmt->execute([$productId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    // search products by keyword
    public function searchProducts($keyword)
    {
        $sql = "SELECT 
                    product_id, 
                    name AS product_name, 
                    price AS product_price, 
                    sale_price AS product_sale_price, 
                    image AS product_image, 
                    description AS product_description 
                FROM products 
                WHERE name LIKE :keyword 
                   OR product_id LIKE :keyword 
                   OR description LIKE :keyword";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['keyword' => '%' . $keyword . '%']);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function deleteVariants($product_id)
    {
        // Kiểm tra xem có bản ghi liên quan trong bảng cart_items không
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM cart_items WHERE variant_id IN (
            SELECT product_variant_id FROM product_variants WHERE product_id = ?
        )");
        $stmt->execute([$product_id]);
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            throw new \Exception("Không thể xóa vì có sản phẩm trong giỏ hàng liên quan.");
        }

        // Xóa các bản ghi trong bảng product_variants
        $stmt = $this->pdo->prepare("DELETE FROM product_variants WHERE product_id = ?");
        $stmt->execute([$product_id]);
    }
    // lấy sản phẩm theo danh mục
    public function getProductsByCategory($category_id)
    {
        $sql = "SELECT 
                    products.product_id,
                    products.name AS product_name,
                    products.price AS product_price,
                    products.sale_price AS product_sale_price,
                    products.image AS product_image,
                    products.description AS product_description,
                    categories.name AS category_name
                FROM products
                LEFT JOIN categories ON products.category_id = categories.category_id
                WHERE categories.category_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$category_id]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Cập nhật số lượng biến thể sản phẩm
    public function updateVariantQuantity($variantId, $quantity)
    {
        try {
            $sql = "UPDATE product_variants 
                    SET quantity = quantity - :quantity 
                    WHERE product_variant_id = :variant_id 
                    AND quantity >= :quantity";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':variant_id' => $variantId,
                ':quantity' => $quantity
            ]);

            // Kiểm tra xem có bản ghi nào được cập nhật không
            if ($stmt->rowCount() === 0) {
                // Kiểm tra lý do không cập nhật được
                $checkSql = "SELECT quantity FROM product_variants WHERE product_variant_id = ?";
                $checkStmt = $this->pdo->prepare($checkSql);
                $checkStmt->execute([$variantId]);
                $currentQuantity = $checkStmt->fetchColumn();

                if ($currentQuantity < $quantity) {
                    throw new \Exception("Số lượng sản phẩm trong kho không đủ");
                }
                throw new \Exception("Không thể cập nhật số lượng sản phẩm");
            }

            return true;
        } catch (\PDOException $e) {
            throw new \Exception("Lỗi cập nhật số lượng sản phẩm: " . $e->getMessage());
        }
    }
}
