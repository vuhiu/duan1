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
        border: 1px solid #ddd;
        border-radius: 4px;
        overflow: hidden;
        width: fit-content;
        margin: 0 auto;
    }

    .quantity-btn {
        background: #f8f9fa;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
        font-size: 16px;
    }

    .quantity-btn:hover {
        background: #e9ecef;
    }

    .quantity-input {
        width: 50px;
        text-align: center;
        border: none;
        border-left: 1px solid #ddd;
        border-right: 1px solid #ddd;
        padding: 5px;
    }

    .quantity-input::-webkit-inner-spin-button,
    .quantity-input::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .sale-price {
        color: #D10024;
        font-weight: bold;
    }

    .original-price {
        text-decoration: line-through;
        color: #8D99AE;
        font-size: 0.9em;
    }

    .total-amount {
        font-size: 1.2em;
        font-weight: bold;
        color: #D10024;
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
        // Xử lý nút tăng/giảm số lượng
        document.querySelectorAll('.quantity-btn').forEach(button => {
            button.addEventListener('click', function() {
                const form = this.closest('.quantity-form');
                const input = form.querySelector('.quantity-input');
                const currentValue = parseInt(input.value);
                
                if (this.classList.contains('plus')) {
                    input.value = Math.min(currentValue + 1, 99);
                } else if (this.classList.contains('minus')) {
                    input.value = Math.max(currentValue - 1, 1);
                }
                
                // Tự động submit form khi thay đổi số lượng
                updateCartItem(form);
            });
        });

        // Xử lý input số lượng
        document.querySelectorAll('.quantity-input').forEach(input => {
            input.addEventListener('change', function() {
                const form = this.closest('.quantity-form');
                updateCartItem(form);
            });
        });

        // Hàm cập nhật số lượng sản phẩm
        function updateCartItem(form) {
            const formData = new FormData(form);
            
            fetch('/duan1/index.php?act=cart&page=update_cart', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(() => {
                // Cập nhật lại giỏ hàng
                location.reload();
                // Cập nhật số lượng trên header
                if (window.updateCartCount) {
                    window.updateCartCount();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra khi cập nhật giỏ hàng');
            });
        }

        // Xử lý xóa sản phẩm
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                if (confirm('Bạn có chắc muốn xóa sản phẩm này?')) {
                    window.location.href = this.getAttribute('href');
                }
            });
        });
    });
</script>