<?php
require_once __DIR__ . '/../../../commons/connect.php';
?>

<h2>Kết quả tìm kiếm</h2>
<div class="row">
    <?php if (!empty($products)): ?>
        <?php foreach ($products as $product): ?>
            <div class="col-md-4 col-sm-6">
                <div class="product">
                    <div class="product-img">
                        <img src="/duan1/upload/<?= htmlspecialchars($product['product_image']) ?>" 
                             alt="<?= htmlspecialchars($product['product_name']) ?>" 
                             style="width: 100%; height: auto; object-fit: cover;">
                    </div>
                    <div class="product-body">
                        <h3 class="product-name"><?= htmlspecialchars($product['product_name']) ?></h3>
                        <h4 class="product-price">
                            <?php if (!empty($product['product_sale_price'])): ?>
                                <del><?= number_format($product['product_price'], 0, ',', '.') ?> đ</del>
                                <span><?= number_format($product['product_sale_price'], 0, ',', '.') ?> đ</span>
                            <?php else: ?>
                                <?= number_format($product['product_price'], 0, ',', '.') ?> đ
                            <?php endif; ?>
                        </h4>
                        <p class="product-description"><?= htmlspecialchars($product['product_description']) ?></p>
                        <a href="/duan1/index.php?act=product&product_id=<?= $product['product_id'] ?>" class="btn btn-primary">Xem chi tiết</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Không tìm thấy sản phẩm nào phù hợp với từ khóa "<?= htmlspecialchars($keyword) ?>".</p>
    <?php endif; ?>
</div>