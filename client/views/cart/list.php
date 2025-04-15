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

$ROOT_URL = "/duan1";
$CONTENT_URL = "$ROOT_URL/content";
$ADMIN_URL = "$ROOT_URL/admin";
$CLIENT_URL = "$ROOT_URL/client";
?>

<!-- BREADCRUMB -->
<div id="breadcrumb" class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 class="breadcrumb-header">Giỏ hàng</h3>
                <ul class="breadcrumb-tree">
                    <li><a href="/duan1/index.php">Trang chủ</a></li>
                    <li class="active">Giỏ hàng</li>
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
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Giỏ hàng của tôi</h4>
                        <div class="header-actions">
                            <a href="/duan1/index.php?act=order&page=list" class="cart-btn outline-btn">
                                <i class="fas fa-history"></i> Lịch sử đơn hàng
                            </a>
                            <a href="/duan1/index.php" class="cart-btn primary-btn">
                                <i class="fas fa-shopping-cart"></i> Tiếp tục mua sắm
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if (empty($cartItems)): ?>
                            <div class="text-center py-4">
                                <p>Giỏ hàng của bạn đang trống.</p>
                                <a href="/duan1/index.php" class="cart-btn primary-btn">Mua sắm ngay</a>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Sản phẩm</th>
                                            <th>Màu sắc</th>
                                            <th>Kích thước</th>
                                            <th class="text-center">Số lượng</th>
                                            <th class="text-end">Đơn giá</th>
                                            <th class="text-end">Thành tiền</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($cartItems as $item): ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="/duan1/upload/<?= $item['image'] ?>"
                                                            alt="<?= htmlspecialchars($item['name']) ?>"
                                                            class="me-2" style="width: 50px; height: 50px; object-fit: cover;">
                                                        <div>
                                                            <div class="fw-bold"><?= htmlspecialchars($item['name']) ?></div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><?= htmlspecialchars($item['color_name'] ?? 'N/A') ?></td>
                                                <td><?= htmlspecialchars($item['size_name'] ?? 'N/A') ?></td>
                                                <td class="text-center">
                                                    <form action="/duan1/index.php?act=cart&page=update_cart" method="POST" class="quantity-form">
                                                        <input type="hidden" name="cart_item_id" value="<?= $item['cart_item_id'] ?>">
                                                        <div class="quantity-group">
                                                            <button type="button" class="quantity-btn minus">-</button>
                                                            <input type="number" name="quantity" value="<?= $item['quantity'] ?>"
                                                                class="quantity-input" min="1" max="99">
                                                            <button type="button" class="quantity-btn plus">+</button>
                                                        </div>
                                                    </form>
                                                </td>
                                                <td class="text-end">
                                                    <?php if ($item['variant_sale_price']): ?>
                                                        <div class="sale-price">
                                                            <?= number_format($item['variant_sale_price'], 0, ',', '.') ?> đ
                                                        </div>
                                                        <div class="original-price">
                                                            <?= number_format($item['variant_price'], 0, ',', '.') ?> đ
                                                        </div>
                                                    <?php else: ?>
                                                        <div class="sale-price">
                                                            <?= number_format($item['variant_price'], 0, ',', '.') ?> đ
                                                        </div>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-end">
                                                    <div class="sale-price">
                                                        <?php
                                                        $itemTotal = ($item['variant_sale_price'] ?? $item['variant_price']) * $item['quantity'];
                                                        echo number_format($itemTotal, 0, ',', '.') . ' đ';
                                                        ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="/duan1/index.php?act=cart&page=delete_cart&cart_item_id=<?= $item['cart_item_id'] ?>"
                                                        class="cart-btn delete-btn"
                                                        onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?');">
                                                        <i class="fas fa-trash"></i> Xóa
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="5" class="text-end"><strong>Tổng tiền:</strong></td>
                                            <td class="text-end">
                                                <div class="total-amount">
                                                    <?= number_format($totalPrice, 0, ',', '.') ?> đ
                                                </div>
                                            </td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <a href="/duan1/index.php?act=cart&page=checkout" class="cart-btn primary-btn">
                                    <i class="fas fa-shopping-bag"></i> Thanh toán
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /SECTION -->

<style>
    .card {
        border: none;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        background-color: #fff;
        border-bottom: 1px solid #eee;
        padding: 15px;
    }

    .header-actions {
        display: flex;
        gap: 10px;
    }

    .cart-btn {
        display: inline-block;
        text-decoration: none;
        font-weight: 600;
        cursor: pointer;
        border: 1px solid transparent;
        padding: 8px 20px;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        user-select: none;
        line-height: 1.5;
        font-size: 14px;
    }

    .primary-btn {
        background-color: #D10024;
        color: #fff;
        border-color: #D10024;
    }

    .primary-btn:hover {
        background-color: #E4002B;
        color: #fff;
        text-decoration: none;
    }

    .outline-btn {
        background-color: transparent;
        color: #D10024;
        border-color: #D10024;
    }

    .outline-btn:hover {
        background-color: #D10024;
        color: #fff;
        text-decoration: none;
    }

    .delete-btn {
        background-color: #D10024;
        color: #fff;
        padding: 6px 15px;
        border: 1px solid #D10024;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 13px;
        border-radius: 3px;
        width: auto;
        height: auto;
    }

    .delete-btn:hover {
        background-color: #E4002B;
        color: #fff;
        text-decoration: none;
    }

    .delete-btn i {
        font-size: 12px;
    }

    .quantity-form {
        display: inline-block;
    }

    .quantity-group {
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #E4E7ED;
        border-radius: 3px;
        overflow: hidden;
    }

    .quantity-btn {
        width: 30px;
        height: 30px;
        background: #fff;
        border: none;
        color: #333;
        font-size: 14px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
    }

    .quantity-btn:hover {
        background-color: #E4E7ED;
    }

    .quantity-input {
        width: 40px;
        height: 30px;
        border: none;
        border-left: 1px solid #E4E7ED;
        border-right: 1px solid #E4E7ED;
        text-align: center;
        font-size: 14px;
        padding: 0;
        -moz-appearance: textfield;
    }

    .quantity-input::-webkit-outer-spin-button,
    .quantity-input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .sale-price {
        color: #D10024;
        font-weight: 600;
        font-size: 16px;
    }

    .original-price {
        color: #8D99AE;
        font-size: 14px;
        text-decoration: line-through;
    }

    .total-amount {
        color: #D10024;
        font-weight: 700;
        font-size: 18px;
    }

    .table th {
        background-color: #f8f9fa;
        font-weight: 600;
        border-bottom: 2px solid #D10024;
    }

    .table td {
        vertical-align: middle;
    }

    @media (max-width: 768px) {
        .card-header {
            flex-direction: column;
            align-items: stretch !important;
        }

        .header-actions {
            margin-top: 10px;
            flex-direction: column;
        }

        .cart-btn {
            width: 100%;
            margin-bottom: 5px;
        }

        .quantity-form {
            margin: 0 auto;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const forms = document.querySelectorAll('.quantity-form');

        forms.forEach(form => {
            const minusBtn = form.querySelector('.quantity-btn.minus');
            const plusBtn = form.querySelector('.quantity-btn.plus');
            const input = form.querySelector('.quantity-input');

            minusBtn.addEventListener('click', function() {
                let value = parseInt(input.value);
                if (value > 1) {
                    input.value = value - 1;
                    form.submit();
                }
            });

            plusBtn.addEventListener('click', function() {
                let value = parseInt(input.value);
                if (value < 99) {
                    input.value = value + 1;
                    form.submit();
                }
            });

            input.addEventListener('change', function() {
                let value = parseInt(this.value);
                if (value < 1) this.value = 1;
                if (value > 99) this.value = 99;
                form.submit();
            });
        });
    });
</script>