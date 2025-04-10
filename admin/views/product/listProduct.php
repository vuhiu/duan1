<!-- filepath: c:\xampp\htdocs\duan1\admin\views\product\listProduct.php -->
<h2 class="mt-3 text-center">Danh sách sản phẩm</h2>

<div class="table-responsive">
    <table class="table table-bordered table-hover align-middle">
        <thead class="table-dark text-center">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Tên sản phẩm</th>
                <th scope="col">Ảnh</th>
                <th scope="col">Giá gốc</th>
                <th scope="col">Giá khuyến mãi</th>
                <th scope="col">Slug</th>
                <th scope="col">Mô tả</th>
                <th scope="col">Trạng thái</th>
                <th scope="col">Danh mục</th>
                <th scope="col">Biến thể</th>
                <th scope="col">Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($listProduct as $product): ?>
            <tr>
                <td class="text-center"><?= htmlspecialchars($product['product_id']) ?></td>
                <td><?= htmlspecialchars($product['product_name']) ?></td>
                <td class="text-center">
                    <img src="/duan1/upload/<?= htmlspecialchars($product['product_image']) ?>" alt="Ảnh sản phẩm"
                        class="img-thumbnail" width="180">
                </td>
                <td class="text-end"><?= number_format($product['product_price'], 0, ',', '.') ?> đ</td>
                <td class="text-end"><?= number_format($product['product_sale_price'], 0, ',', '.') ?> đ</td>
                <td><?= htmlspecialchars($product['product_slug']) ?></td>
                <td><?= htmlspecialchars($product['description'] ?? 'Không có mô tả') ?></td>
                <td class="text-center">
                    <?= $product['product_status'] == 1 ? '<span class="badge bg-success">Hiển thị</span>' : '<span class="badge bg-danger">Ẩn</span>' ?>
                </td>
                <td><?= htmlspecialchars($product['category_name']) ?></td>
                <td>
                    <?php if (!empty($product['variants'])): ?>
                    <ul class="list-unstyled mb-0">
                        <?php foreach ($product['variants'] as $variant): ?>
                        <li>
                            <strong>Màu:</strong>
                            <?= htmlspecialchars($variant['product_variant_color'] ?? 'Không xác định') ?>,
                            <strong>Kích thước:</strong>
                            <?= htmlspecialchars($variant['product_variant_size'] ?? 'Không xác định') ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php else: ?>
                    <span class="text-muted">Không có biến thể</span>
                    <?php endif; ?>
                </td>
                <td class="text-center">
                    <div class="d-flex justify-content-center gap-2">
                        <a href="?act=sanpham&page=sua&product_id=<?= $product['product_id'] ?>"
                            class="btn btn-warning btn-sm">Sửa</a>
                        <a href="?act=sanpham&page=xoa&product_id=<?= $product['product_id'] ?>"
                            class="btn btn-danger btn-sm"
                            onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">Xóa</a>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>