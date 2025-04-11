<!-- filepath: c:\xampp\htdocs\duan1\client\views\product\product_detail.php -->
<h2 style="text-align: center;">Chi tiết sản phẩm</h2>

<div class="product-detail"
    style="display: flex; justify-content: center; align-items: center; gap: 40px; flex-wrap: wrap; text-align: left;">
    <!-- Thông tin sản phẩm -->
    <div class="product-info" style="max-width: 500px;">
        <h1><?= htmlspecialchars($product['product_name']) ?></h1>
        <h4 id="product-price">
            <?php if (!empty($product['product_sale_price'])): ?>
            <del><?= number_format($product['product_price'], 0, ',', '.') ?> đ</del>
            <span><?= number_format($product['product_sale_price'], 0, ',', '.') ?> đ</span>
            <?php else: ?>
            <?= number_format($product['product_price'], 0, ',', '.') ?> đ
            <?php endif; ?>
        </h4>
        <p><?= htmlspecialchars($product['product_description']) ?></p>

        <?php if (!empty($product['variants'])): ?>
        <h5>Chọn biến thể:</h5>
        <select id="variant-selector" class="form-control mb-3">
            <?php foreach ($product['variants'] as $variant): ?>
            <option value="<?= $variant['product_variant_id'] ?>" 
                    data-price="<?= $variant['price'] ?>" 
                    data-sale-price="<?= $variant['sale_price'] ?>">
                Màu: <?= htmlspecialchars($variant['product_variant_color'] ?? 'Không xác định') ?>, 
                Kích thước: <?= htmlspecialchars($variant['product_variant_size'] ?? 'Không xác định') ?>
            </option>
            <?php endforeach; ?>
        </select>
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
                <input type="hidden" id="variant-id" name="variant_id" value="<?= $product['variants'][0]['product_variant_id'] ?>">

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

<script>
    // JavaScript để thay đổi giá khi chọn biến thể
    document.getElementById('variant-selector').addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const price = selectedOption.getAttribute('data-price');
        const salePrice = selectedOption.getAttribute('data-sale-price');
        const variantId = selectedOption.value;

        // Cập nhật giá hiển thị
        const priceElement = document.getElementById('product-price');
        if (salePrice && salePrice !== 'null') {
            priceElement.innerHTML = `<del>${new Intl.NumberFormat('vi-VN').format(price)} đ</del> 
                                      <span>${new Intl.NumberFormat('vi-VN').format(salePrice)} đ</span>`;
        } else {
            priceElement.innerHTML = `${new Intl.NumberFormat('vi-VN').format(price)} đ`;
        }

        // Cập nhật giá trị của input hidden variant_id
        document.getElementById('variant-id').value = variantId;
    });
</script>