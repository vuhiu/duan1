<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container py-5">
    <h2 class="mb-4">Danh sách yêu thích</h2>
    
    <?php if (empty($favorites)): ?>
        <div class="text-center py-5">
            <i class="fas fa-heart text-muted" style="font-size: 48px;"></i>
            <p class="mt-3">Danh sách yêu thích trống</p>
            <a href="/duan1/index.php" class="btn btn-primary">Tiếp tục mua sắm</a>
        </div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($favorites as $item): ?>
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <img src="/duan1/upload/<?= $item['image'] ?>" class="card-img-top" alt="<?= $item['name'] ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= $item['name'] ?></h5>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <?php if ($item['sale_price'] > 0): ?>
                                        <span class="text-danger"><?= number_format($item['sale_price']) ?>đ</span>
                                        <small class="text-muted text-decoration-line-through"><?= number_format($item['price']) ?>đ</small>
                                    <?php else: ?>
                                        <span class="text-danger"><?= number_format($item['price']) ?>đ</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-outline-danger btn-sm remove-favorite" data-product-id="<?= $item['product_id'] ?>">
                                    <i class="fas fa-trash"></i> Xóa
                                </button>
                                <a href="/duan1/index.php?act=product&page=detail&id=<?= $item['product_id'] ?>" class="btn btn-primary btn-sm">
                                    <i class="fas fa-shopping-cart"></i> Mua ngay
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<script>
$(document).ready(function() {
    // Xử lý xóa sản phẩm khỏi yêu thích
    $('.remove-favorite').click(function() {
        const productId = $(this).data('product-id');
        const card = $(this).closest('.col-md-3');
        
        $.ajax({
            url: '/duan1/index.php?act=favorite&action=remove',
            method: 'POST',
            data: { product_id: productId },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    card.fadeOut(300, function() {
                        $(this).remove();
                        if ($('.card').length === 0) {
                            location.reload();
                        }
                    });
                    toastr.success(response.message);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function() {
                toastr.error('Đã xảy ra lỗi. Vui lòng thử lại.');
            }
        });
    });
});
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?> 