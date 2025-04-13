<!-- filepath: c:\xampp\htdocs\duan1\client\views\cart\list.php -->
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Giỏ hàng</title>
    <link type="text/css" rel="stylesheet" href="/duan1/css/bootstrap.min.css" />
</head>

<body>
    <div class="container mt-5">
        <h1>Giỏ hàng</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Hình ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Biến thể</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <!-- filepath: c:\xampp\htdocs\duan1\client\views\cart\list.php -->
            <tbody>
                <?php
                $totalPrice = 0; // Biến lưu tổng tiền
                if (!empty($cartItems) && is_array($cartItems)): ?>
                    <?php foreach ($cartItems as $index => $item):
                        // Sử dụng giá khuyến mãi nếu có, ngược lại dùng giá gốc
                        $price = $item['variant_sale_price'] ?? $item['variant_price'];
                        $itemTotal = $price * $item['quantity']; // Thành tiền cho từng sản phẩm
                        $totalPrice += $itemTotal; // Cộng vào tổng tiền
                    ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td>
                                <img src="/duan1/upload/<?= htmlspecialchars($item['product_image'] ?? 'default.jpg') ?>"
                                    alt="Hình ảnh sản phẩm"
                                    style="width: 80px; height: 80px; object-fit: cover;">
                            </td>
                            <td><?= htmlspecialchars($item['name']) ?></td>
                            <td>
                                Màu: <?= htmlspecialchars($item['product_variant_color'] ?? 'Không xác định') ?>,
                                Kích thước: <?= htmlspecialchars($item['product_variant_size'] ?? 'Không xác định') ?>
                            </td>
                            <td>
                                <?php if (!empty($item['variant_sale_price'])): ?>
                                    <del><?= number_format($item['variant_price'], 0, ',', '.') ?> đ</del>
                                    <span><?= number_format($item['variant_sale_price'], 0, ',', '.') ?> đ</span>
                                <?php else: ?>
                                    <span><?= number_format($item['variant_price'], 0, ',', '.') ?> đ</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <form action="/duan1/index.php?act=cart&page=update_cart" method="POST" style="display: inline;">
                                    <input type="hidden" name="cart_item_id" value="<?= $item['cart_item_id'] ?>">
                                    <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1" style="width: 60px;">
                                    <button type="submit" class="btn btn-sm btn-primary">Cập nhật</button>
                                </form>
                            </td>
                            <td><?= number_format($itemTotal, 0, ',', '.') ?> đ</td>
                            <td>
                                <a href="/duan1/index.php?act=cart&page=delete_cart&cart_item_id=<?= $item['cart_item_id'] ?>"
                                    class="btn btn-sm btn-danger"
                                    onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center">Giỏ hàng của bạn đang trống.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Hiển thị tổng tiền -->
        <div class="text-end">
            <h4>Tổng tiền: <?= number_format($totalPrice, 0, ',', '.') ?> đ</h4>
        </div>

        <!-- Nút thanh toán -->
        <div class="text-end mt-3">
            <a href="/duan1/index.php?act=cart&page=checkout" class="btn btn-success">Thanh toán</a>
        </div>
    </div>
</body>

</html>