<?php
require_once __DIR__ . '/../../commons/connect.php';

class CategoryModel
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // Lấy danh sách sản phẩm theo danh mục và áp dụng các bộ lọc(khoảng giá, thương hiệu, màu sắc, dung lượng, sắp xếp).
    public function getFilteredProducts($category_id, $price_range, $brand, $color, $size, $sort)
    {
        $query = "
            SELECT 
                p.product_id, 
                p.name AS product_name, 
                p.image AS product_image, 
                p.price AS product_price, 
                p.sale_price AS product_sale_price,
                p.description AS product_description,
                vc.color_name AS product_variant_color,
                vs.size_name AS product_variant_size
            FROM products p
            LEFT JOIN product_variants pv ON p.product_id = pv.product_id
            LEFT JOIN variant_colors vc ON pv.variant_color_id = vc.variant_color_id
            LEFT JOIN variant_size vs ON pv.variant_size_id = vs.variant_size_id
            WHERE p.category_id = :category_id
        ";

        $params = ['category_id' => $category_id];

        // Lọc theo khoảng giá
        if ($price_range) {
            [$min_price, $max_price] = explode('-', $price_range);
            $query .= " AND p.price BETWEEN :min_price AND :max_price";
            $params['min_price'] = $min_price;
            $params['max_price'] = $max_price;
        }

        // Lọc theo thương hiệu
        if ($brand) {
            $placeholders = [];
            foreach ($brand as $index => $value) {
                $placeholder = ":brand_$index";
                $placeholders[] = $placeholder;
                $params[$placeholder] = $value;
            }
            $query .= " AND p.name IN (" . implode(',', $placeholders) . ")";
        }

        // Lọc theo màu sắc
        if ($color) {
            $placeholders = [];
            foreach ($color as $index => $value) {
                $placeholder = ":color_$index";
                $placeholders[] = $placeholder;
                $params[$placeholder] = $value;
            }
            $query .= " AND vc.color_name IN (" . implode(',', $placeholders) . ")";
        }

        // Lọc theo dung lượng
        if ($size) {
            $placeholders = [];
            foreach ($size as $index => $value) {
                $placeholder = ":size_$index";
                $placeholders[] = $placeholder;
                $params[$placeholder] = $value;
            }
            $query .= " AND vs.size_name IN (" . implode(',', $placeholders) . ")";
        }

        // Sắp xếp
        if ($sort) {
            if ($sort === 'price-asc') {
                $query .= " ORDER BY p.price ASC";
            } elseif ($sort === 'price-desc') {
                $query .= " ORDER BY p.price DESC";
            } elseif ($sort === 'newest') {
                $query .= " ORDER BY p.created_at DESC";
            }
        }

        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllCategories()
    {
        $stmt = $this->conn->prepare("SELECT category_id, name FROM categories");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
