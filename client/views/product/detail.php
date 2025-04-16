<?php
// Kiểm tra trạng thái yêu thích
$isFavorite = false;
if (isset($_SESSION['user_id'])) {
    require_once __DIR__ . '/../../models/FavoriteModel.php';
    $favoriteModel = new Favorite();
    $isFavorite = $favoriteModel->isFavorite($_SESSION['user_id'], $product['product_id']);
}
?>

<div class="product-actions mt-4">
    <div class="d-flex gap-2">
        <button type="button" class="btn <?= $isFavorite ? 'btn-danger' : 'btn-outline-danger' ?> favorite-btn" data-product-id="<?= $product['product_id'] ?>">
            <i class="fas fa-heart"></i> <?= $isFavorite ? 'Đã yêu thích' : 'Yêu thích' ?>
        </button>
        <button type="button" class="btn btn-primary buy-now-btn">
            <i class="fas fa-bolt"></i> Mua ngay
        </button>
        <button type="button" class="btn btn-success add-to-cart-btn">
            <i class="fas fa-shopping-cart"></i> Thêm vào giỏ
        </button>
    </div>
</div>

<script>
$(document).ready(function() {
    // Xử lý thêm/xóa yêu thích
    $('.favorite-btn').click(function() {
        <?php if (!isset($_SESSION['user_id'])): ?>
            window.location.href = '/duan1/client/views/auth/form-login.php';
            return;
        <?php endif; ?>

        const $btn = $(this);
        const productId = $btn.data('product-id');
        const isCurrentlyFavorite = $btn.hasClass('btn-danger');
        const action = isCurrentlyFavorite ? 'remove' : 'add';
        
        $.ajax({
            url: '/duan1/index.php?act=favorite&action=' + action,
            method: 'POST',
            data: { product_id: productId },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    if (action === 'add') {
                        $btn.removeClass('btn-outline-danger').addClass('btn-danger');
                        $btn.html('<i class="fas fa-heart"></i> Đã yêu thích');
                    } else {
                        $btn.removeClass('btn-danger').addClass('btn-outline-danger');
                        $btn.html('<i class="fas fa-heart"></i> Yêu thích');
                    }
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

    // Xử lý mua ngay
    $('.buy-now-btn').click(function() {
        <?php if (!isset($_SESSION['user_id'])): ?>
            window.location.href = '/duan1/client/views/auth/form-login.php';
            return;
        <?php endif; ?>

        const productId = <?= $product['product_id'] ?>;
        const variantId = $('input[name="variant_id"]:checked').val();
        const quantity = $('#quantity').val() || 1;

        if (!variantId) {
            toastr.error('Vui lòng chọn phiên bản sản phẩm');
            return;
        }

        // Thêm vào giỏ hàng và chuyển đến trang thanh toán
        $.ajax({
            url: '/duan1/index.php?act=cart&page=add',
            method: 'POST',
            data: {
                product_id: productId,
                variant_id: variantId,
                quantity: quantity
            },
            success: function() {
                window.location.href = '/duan1/index.php?act=cart&page=checkout';
            },
            error: function() {
                toastr.error('Đã xảy ra lỗi. Vui lòng thử lại.');
            }
        });
    });
});
</script> 