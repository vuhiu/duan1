<h2 style="text-align: center;">Chi tiết sản phẩm</h2>

<div class="product-detail"
    style="display: flex; justify-content: center; align-items: center; gap: 40px; flex-wrap: wrap; text-align: left;">
    <!-- Thông tin sản phẩm -->
    <div class="product-info" style="max-width: 500px;">
        <h1><?= htmlspecialchars($product['product_name']) ?></h1>
        <h4>
            <?php if (!empty($product['product_sale_price'])): ?>
            <del><?= number_format($product['product_price'], 0, ',', '.') ?> đ</del>
            <span><?= number_format($product['product_sale_price'], 0, ',', '.') ?> đ</span>
            <?php else: ?>
            <?= number_format($product['product_price'], 0, ',', '.') ?> đ
            <?php endif; ?>
        </h4>
        <p><?= htmlspecialchars($product['product_description']) ?></p>

        <?php if (!empty($product['variants'])): ?>
        <h5>Biến thể:</h5>
        <ul>
            <?php foreach ($product['variants'] as $variant): ?>
            <li>
                Màu: <?= htmlspecialchars($variant['product_variant_color'] ?? 'Không xác định') ?>,
                Kích thước: <?= htmlspecialchars($variant['product_variant_size'] ?? 'Không xác định') ?>,
                Giá: <?= number_format($variant['price'], 0, ',', '.') ?> đ
            </li>
            <?php endforeach; ?>
        </ul>
        <?php else: ?>
        <p>Không có biến thể cho sản phẩm này.</p>
        <?php endif; ?>

        <h5>Đánh giá:</h5>
        <div class="product-rating">
            <span>⭐⭐⭐⭐☆</span>
            <p>(12 đánh giá)</p>
        </div>
        <!-- form gửi dữ liệu sản phẩm vào giỏ hàng khi nhấn nút "Thêm vào giỏ hàng". -->
        <div class="product-actions">
            <form action="/duan1/index.php?act=cart&page=add" method="POST">
                <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                <input type="hidden" name="variant_id" value="1"> <!-- Thay đổi nếu có biến thể -->
                <input type="number" name="quantity" value="1" min="1" class="form-control mb-2" style="width: 100px;">
                <button type="submit" class="btn btn-primary">Thêm vào giỏ hàng</button>
            </form>
            <a href="/duan1/index.php?act=checkout&product_id=<?= $product['product_id'] ?>" class="btn btn-success">Mua
                ngay</a>
        </div>
    </div>

    <!-- Hình ảnh sản phẩm -->
    <div class="product-img">
        <img src="/duan1/upload/<?= htmlspecialchars($product['product_image']) ?>"
            alt="<?= htmlspecialchars($product['product_name']) ?>"
            style="height: 400px; object-fit: cover; border-radius: 8px;">
    </div>
</div>