<!-- filepath: c:\xampp\htdocs\duan1\client\views\cart\list.php -->
<?php
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header('Location: /duan1/client/views/auth/form-login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$cartItems = $this->cartModel->getAllCartItems($user_id);
$totalPrice = 0;

foreach ($cartItems as $item) {
    $price = $item['variant_sale_price'] ?? $item['variant_price'];
    $totalPrice += $price * $item['quantity'];
}
?>

<!-- BREADCRUMB -->
<div id="breadcrumb" class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 class="breadcrumb-header">GIỎ HÀNG</h3>
                <ul class="breadcrumb-tree">
                    <li><a href="/duan1/index.php">TRANG CHỦ</a></li>
                    <li class="active">GIỎ HÀNG</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- /BREADCRUMB -->

<!-- SECTION -->
<div class="section">
    <div class="container">
        <div class="row">
            <?php if (empty($cartItems)): ?>
                <div class="col-md-12">
                    <div class="alert alert-warning">Giỏ hàng trống</div>
                    <a href="/duan1/index.php" class="primary-btn">Tiếp tục mua sắm</a>
                </div>
            <?php else: ?>
                <div class="col-md-8">
                    <div class="cart-list">
                        <?php foreach ($cartItems as $item): ?>
                            <div class="cart-item">
                                <div class="product-widget">
                                    <div class="product-img">
                                        <img src="/duan1/upload/<?= htmlspecialchars($item['image']) ?>" alt="">
                                    </div>
                                    <div class="product-body">
                                        <h3 class="product-name">
                                            <a href="/duan1/index.php?act=product&id=<?= $item['product_id'] ?>">
                                                <?= htmlspecialchars($item['name']) ?>
                                            </a>
                                        </h3>
                                        <div class="product-price">
                                            <?php if ($item['variant_sale_price']): ?>
                                                <span class="new-price">
                                                    <?= number_format($item['variant_sale_price'], 0, ',', '.') ?>đ
                                                </span>
                                                <span class="old-price">
                                                    <?= number_format($item['variant_price'], 0, ',', '.') ?>đ
                                                </span>
                                            <?php else: ?>
                                                <span class="new-price">
                                                    <?= number_format($item['variant_price'], 0, ',', '.') ?>đ
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        <p class="product-variant">
                                            Phiên bản: <?= htmlspecialchars($item['size_name']) ?> -
                                            Màu: <?= htmlspecialchars($item['color_name']) ?>
                                        </p>
                                    </div>
                                    <div class="product-actions">
                                        <div class="quantity-controls">
                                            <form action="/duan1/index.php?act=cart&page=update_cart" method="POST" class="update-cart-form">
                                                <input type="hidden" name="cart_item_id" value="<?= $item['cart_item_id'] ?>">
                                                <button type="button" class="qty-btn minus">
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                                <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1" max="100" readonly>
                                                <button type="button" class="qty-btn plus">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </form>
                                        </div>
                                        <button class="delete-btn" onclick="deleteCartItem(<?= $item['cart_item_id'] ?>)">
                                            <i class="fa fa-trash"></i>
                                            <span>Xóa</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="cart-summary">
                        <div class="section-title">
                            <h4 class="title">TỔNG GIỎ HÀNG</h4>
                        </div>
                        <div class="order-summary">
                            <div class="order-col">
                                <div>Tạm tính</div>
                                <div><?= number_format($totalPrice, 0, ',', '.') ?>đ</div>
                            </div>
                            <div class="order-col total">
                                <div>TỔNG CỘNG</div>
                                <div class="order-total"><?= number_format($totalPrice, 0, ',', '.') ?>đ</div>
                            </div>
                            <div class="cart-btns">
                                <a href="/duan1/index.php?act=cart&page=checkout" class="primary-btn order-submit">
                                    TIẾN HÀNH THANH TOÁN
                                </a>
                                <a href="/duan1/index.php" class="primary-btn continue-shopping">
                                    TIẾP TỤC MUA SẮM
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<!-- /SECTION -->

<style>
    .cart-list {
        background: #fff;
        padding: 20px;
        border-radius: 4px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .cart-item {
        padding: 15px 0;
        border-bottom: 1px solid #e4e7ed;
    }

    .cart-item:last-child {
        border-bottom: none;
    }

    .product-widget {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .product-img {
        width: 80px;
        flex-shrink: 0;
    }

    .product-img img {
        width: 100%;
        height: auto;
        object-fit: cover;
    }

    .product-body {
        flex: 1;
    }

    .product-name {
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .product-name a {
        color: #2B2D42;
        text-decoration: none;
    }

    .product-price {
        margin-bottom: 5px;
    }

    .new-price {
        color: #D10024;
        font-size: 16px;
        font-weight: 600;
    }

    .old-price {
        color: #8D99AE;
        font-size: 13px;
        text-decoration: line-through;
        margin-left: 5px;
    }

    .product-variant {
        font-size: 13px;
        color: #8D99AE;
        margin: 0;
    }

    .product-actions {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .quantity-controls {
        display: flex;
        align-items: center;
        background: #fff;
        border: 1px solid #E4E7ED;
        border-radius: 4px;
        overflow: hidden;
    }

    .quantity-controls form {
        display: flex;
        align-items: center;
    }

    .qty-btn {
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        background: #F6F7F8;
        color: #2B2D42;
        font-size: 12px;
        cursor: pointer;
        transition: all 0.3s;
    }

    .qty-btn:hover {
        background: #E4E7ED;
    }

    .qty-btn.minus {
        border-right: 1px solid #E4E7ED;
    }

    .qty-btn.plus {
        border-left: 1px solid #E4E7ED;
    }

    .quantity-controls input {
        width: 45px;
        height: 35px;
        border: none;
        text-align: center;
        font-size: 14px;
        font-weight: 600;
        color: #2B2D42;
        background: #fff;
    }

    .quantity-controls input::-webkit-outer-spin-button,
    .quantity-controls input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .quantity-controls input[type=number] {
        -moz-appearance: textfield;
    }

    .delete-btn {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 8px 12px;
        border: 1px solid #D10024;
        border-radius: 4px;
        background: #fff;
        color: #D10024;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }

    .delete-btn:hover {
        background: #D10024;
        color: #fff;
    }

    .delete-btn i {
        font-size: 14px;
    }

    .cart-summary {
        background: #fff;
        padding: 20px;
        border-radius: 4px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .section-title {
        margin-bottom: 20px;
    }

    .section-title .title {
        color: #2B2D42;
        font-size: 16px;
        font-weight: 700;
        margin: 0;
    }

    .order-col {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        font-size: 14px;
    }

    .order-col.total {
        margin-top: 10px;
        padding-top: 10px;
        border-top: 2px solid #E4E7ED;
        font-size: 16px;
        font-weight: 600;
    }

    .order-total {
        color: #D10024;
        font-weight: 700;
    }

    .cart-btns {
        margin-top: 20px;
    }

    .primary-btn {
        display: block;
        width: 100%;
        padding: 8px 15px;
        text-align: center;
        font-size: 13px;
        font-weight: 700;
        color: #fff;
        background: #D10024;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: 0.3s all;
        text-decoration: none;
        margin-bottom: 10px;
    }

    .primary-btn:hover {
        opacity: 0.9;
        color: #fff;
        text-decoration: none;
    }

    .continue-shopping {
        background: #2B2D42;
    }

    @media (max-width: 768px) {
        .product-widget {
            flex-direction: column;
            align-items: flex-start;
        }

        .product-actions {
            flex-wrap: wrap;
            gap: 10px;
        }

        .quantity-controls {
            width: 120px;
        }

        .delete-btn {
            flex: 1;
            justify-content: center;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const qtyForms = document.querySelectorAll('.update-cart-form');

        qtyForms.forEach(form => {
            const input = form.querySelector('input[name="quantity"]');
            const plusBtn = form.querySelector('.plus');
            const minusBtn = form.querySelector('.minus');

            plusBtn.addEventListener('click', function() {
                const currentValue = parseInt(input.value);
                if (currentValue < 100) {
                    input.value = currentValue + 1;
                    form.submit();
                }
            });

            minusBtn.addEventListener('click', function() {
                const currentValue = parseInt(input.value);
                if (currentValue > 1) {
                    input.value = currentValue - 1;
                    form.submit();
                }
            });
        });
    });

    function deleteCartItem(cartItemId) {
        if (confirm('Bạn có chắc muốn xóa sản phẩm này?')) {
            window.location.href = `/duan1/index.php?act=cart&page=delete_cart&cart_item_id=${cartItemId}`;
        }
    }
</script>