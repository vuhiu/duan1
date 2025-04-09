<h2>Chi tiết sản phẩm</h2>
<div class="product-detail">
    <div class="row">
        <!-- Hình ảnh sản phẩm -->
        <div class="col-md-6">
            <div class="product-img">
                <img src="/duan1/upload/<?= htmlspecialchars($product['product_image']) ?>" 
                     alt="<?= htmlspecialchars($product['product_name']) ?>" 
                     style="width: 100%; height: auto; object-fit: cover;">
            </div>
        </div>

        <!-- Thông tin sản phẩm -->
        <div class="col-md-6">
            <div class="product-info">
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

                <!-- Hiển thị biến thể -->
                <?php if (!empty($product['variants'])): ?>
                    <h5>Biến thể:</h5>
                    <ul>
                        <?php foreach ($product['variants'] as $variant): ?>
                            <li>Màu: <?= htmlspecialchars($variant['color']) ?>, Kích thước: <?= htmlspecialchars($variant['size']) ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>Không có biến thể cho sản phẩm này.</p>
                <?php endif; ?>

                <!-- Đánh giá -->
                <h5>Đánh giá:</h5>
                <div class="product-rating">
                    <span>⭐⭐⭐⭐☆</span> <!-- Hiển thị đánh giá tĩnh, bạn có thể thay bằng dữ liệu động -->
                    <p>(12 đánh giá)</p>
                </div>

                <!-- Nút giỏ hàng và mua ngay -->
                <div class="product-actions">
                    <form action="/duan1/index.php?act=cart&page=add" method="POST">
                        <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                        <button type="submit" class="btn btn-primary">Thêm vào giỏ hàng</button>
                    </form>
                    <a href="/duan1/index.php?act=checkout&product_id=<?= $product['product_id'] ?>" class="btn btn-success">Mua ngay</a>
                </div>
            </div>
        </div>
    </div>
</div>