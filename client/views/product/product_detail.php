<!-- filepath: c:\laragon\www\duan1\client\views\product\product_detail.php -->
<div class="container mt-5 mb-5">
    <div class="row">
        <!-- Ảnh sản phẩm -->
        <div class="col-md-6 text-center">
        <!-- Kiểm tra giá trị trước khi gọi htmlspecialchars() -->
            <img src="/duan1/upload/<?= htmlspecialchars($product['product_image'] ?? 'default.jpg') ?>"
                alt="<?= htmlspecialchars($product['product_name'] ?? 'Sản phẩm không có tên') ?>"
                class="img-fluid rounded border shadow-sm" style="max-height: 500px; object-fit: contain;">
        </div>

        <!-- Thông tin sản phẩm -->
        <div class="col-md-6">
            <h2 class="mb-3"><?= htmlspecialchars($product['product_name']) ?></h2>

            <div class="mb-3" id="product-price">
                <?php if (!empty($product['variants'][0]['sale_price'])): ?>
                <h4 class="text-danger">
                    <del class="text-muted"><?= number_format($product['variants'][0]['price'], 0, ',', '.') ?>đ</del>
                    <?= number_format($product['variants'][0]['sale_price'], 0, ',', '.') ?>đ
                </h4>
                <?php else: ?>
                <h4><?= number_format($product['variants'][0]['price'], 0, ',', '.') ?>đ</h4>
                <?php endif; ?>
            </div>

            <p class="text-muted mb-4"><?= htmlspecialchars($product['product_description']) ?></p>

            <!-- Chọn biến thể -->
            <?php
                $colors = [];
                $sizes = [];
                foreach ($product['variants'] as $variant) {
                    // Lấy mã màu và tên màu
                    $colorId = $variant['variant_color_id'] ?? null;
                    $colorCode = $variant['color_code'] ?? null;
                    if ($colorId && $colorCode) {
                        $colors[$colorId] = $colorCode;
                    }
                
                    // Lấy kích thước
                    $sizeId = $variant['variant_size_id'] ?? null;
                    $sizeName = $variant['size_name'] ?? null;
                    if ($sizeId && $sizeName) {
                        $sizes[$sizeId] = $sizeName;
                    }
                }
                $colors = array_unique($colors);
                $sizes = array_unique($sizes);
                // Debug giá trị màu
                // echo '<pre>'; print_r($colors); echo '</pre>';
            ?>

            <!-- Hiển thị danh sách màu sắc: -->
            <div class="mb-3">
                <label><strong>Chọn màu:</strong></label><br>
                <div>
                    <?php foreach ($colors as $colorId => $colorCode): ?>
                    <div class="color-circle color-btn mb-2" data-color-id="<?= htmlspecialchars($colorId) ?>"
                        style="background-color: <?= htmlspecialchars($colorCode) ?>;">
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Hiển thị danh sách kích thước:-->
            <div class="mb-3">
                <label><strong>Chọn kích thước:</strong></label><br>
                <?php foreach ($sizes as $sizeId => $sizeName): ?>
                <button type="button" class="btn btn-outline-secondary size-btn mb-2"
                    data-size-id="<?= htmlspecialchars($sizeId) ?>"><?= htmlspecialchars($sizeName) ?></button>
                <?php endforeach; ?>
            </div>

            <!-- Form thêm vào giỏ hàng -->
            <div class="d-flex gap-3">
                <form id="add-to-cart-form" class="add-to-cart-form">
                    <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                    <input type="hidden" id="variant-id" name="variant_id" value="<?= $product['variants'][0]['product_variant_id'] ?>">
                    <div class="quantity-selector mb-3">
                        <label><strong>Số lượng:</strong></label>
                        <div class="input-group" style="width: 150px;">
                            <button type="button" class="btn btn-outline-secondary" onclick="updateQuantity(-1)">-</button>
                            <input type="number" class="form-control text-center" id="quantity" name="quantity" value="1" min="1" max="10">
                            <button type="button" class="btn btn-outline-secondary" onclick="updateQuantity(1)">+</button>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fa fa-shopping-cart"></i> Thêm vào giỏ hàng
                    </button>
                </form>
                <a href="/duan1/index.php?act=checkout&product_id=<?= $product['product_id'] ?>" class="btn btn-danger px-4">
                    <i class="fa fa-bolt"></i> Mua ngay
                </a>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
const colorButtons = document.querySelectorAll('.color-btn');
const sizeButtons = document.querySelectorAll('.size-btn');
const variantIdInput = document.getElementById('variant-id');
const priceEl = document.getElementById('product-price');
const variants = <?= json_encode($product['variants']) ?>; //truyền dữ liệu biến thể từ PHP sang JavaScript
//json_encode($product['variants']): Chuyển mảng PHP $product['variants'] thành JSON để sử dụng trong JavaScript.
let selectedColor = null;
let selectedSize = null;

// Xử lý chọn màu
colorButtons.forEach(btn => {
    btn.addEventListener('click', () => {
        colorButtons.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        selectedColor = btn.dataset.colorId;
        updateVariantSelection();
    });
});

// Xử lý chọn kích thước
sizeButtons.forEach(btn => {
    btn.addEventListener('click', () => {
        sizeButtons.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        selectedSize = btn.dataset.sizeId;
        updateVariantSelection();
    });
});

// Cập nhật biến thể và giá
function updateVariantSelection() {
    if (!selectedColor || !selectedSize) return;

    const variant = variants.find(v =>
        v.variant_color_id == selectedColor &&
        v.variant_size_id == selectedSize
    );

    if (variant) {
        // Cập nhật ID biến thể
        variantIdInput.value = variant.product_variant_id;

        // Cập nhật giá
        if (variant.sale_price && variant.sale_price !== 'null') {
            priceEl.innerHTML = `<h4 class="text-danger">
                    <del class="text-muted">${Number(variant.price).toLocaleString()}đ</del>
                    ${Number(variant.sale_price).toLocaleString()}đ
                </h4>`;
        } else {
            priceEl.innerHTML = `<h4>${Number(variant.price).toLocaleString()}đ</h4>`;
        }
    } else {
        // Nếu không tìm thấy biến thể phù hợp
        priceEl.innerHTML = `<h4 class="text-muted">Không có biến thể phù hợp</h4>`;
    }
}

// Hàm cập nhật số lượng
function updateQuantity(change) {
    const quantityInput = document.getElementById('quantity');
    let newValue = parseInt(quantityInput.value) + change;
    
    // Giới hạn giá trị từ 1 đến 10
    newValue = Math.max(1, Math.min(10, newValue));
    quantityInput.value = newValue;
}

// Xử lý form thêm vào giỏ hàng
document.getElementById('add-to-cart-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    // Kiểm tra đã chọn biến thể chưa
    if (!selectedColor || !selectedSize) {
        alert('Vui lòng chọn màu sắc và kích thước');
        return;
    }
    
    // Gửi request thêm vào giỏ hàng
    fetch('/duan1/index.php?act=cart&page=add', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (response.ok) {
            // Cập nhật số lượng giỏ hàng
            if (window.updateCartCount) {
                window.updateCartCount();
            }
            // Hiển thị thông báo thành công
            alert('Đã thêm sản phẩm vào giỏ hàng!');
        } else if (response.status === 401) {
            // Chưa đăng nhập
            window.location.href = '/duan1/client/views/auth/form-login.php';
        } else {
            throw new Error('Có lỗi xảy ra');
        }
    })
    .catch(error => {
        alert('Có lỗi xảy ra khi thêm vào giỏ hàng. Vui lòng thử lại!');
        console.error('Error:', error);
    });
});
</script>

<!-- CSS -->
<style>
.color-circle {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: inline-block;
    margin-right: 10px;
    border: 2px solid #ccc;
    cursor: pointer;
    transition: border 0.3s ease;
}

.color-circle.active {
    border: 3px solid #007bff;
}

.size-btn.active {
    border: 2px solid #007bff;
    background-color: #e0f0ff;
    font-weight: bold;
}

.quantity-selector {
    margin-top: 15px;
}

.quantity-selector input {
    width: 60px;
    text-align: center;
}

.btn-primary {
    background-color: #D21737;
    border-color: #D21737;
}

.btn-primary:hover {
    background-color: rgb(134, 4, 25);
    border-color: rgb(134, 4, 25);
}

.btn-danger {
    background-color: #ff4d4d;
    border-color: #ff4d4d;
}

.btn-danger:hover {
    background-color: #ff1a1a;
    border-color: #ff1a1a;
}
</style>