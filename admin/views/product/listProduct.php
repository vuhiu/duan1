<h2 class="mt-3">Danh sách sản phẩm</h2>

<table class="table table-bordered">
  <thead class="table-dark">
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Tên sản phẩm</th>
      <th scope="col">Ảnh</th>
      <th scope="col">Giá gốc</th>
      <th scope="col">Giá khuyến mãi</th>
      <th scope="col">Slug</th>
      <th scope="col">Mô tả</th>
      <th scope="col">Trạng thái</th>
      <th scope="col">Danh mục</th>
      <th scope="col"></th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($products as $p) { ?>
        <tr>
            <td><?= ($p['product_id']) ?></td>
            <td><?= ($p['name']) ?></td>
            <td><img src="<?= ($p['image']) ?>" alt="Ảnh sản phẩm" width="50"></td>
            <td><?= number_format($p['price'], 0, ',', '.') ?> đ</td>
            <td><?= number_format($p['sale_price'], 0, ',', '.') ?> đ</td>
            <td><?= ($p['slug']) ?></td>
            <td><?= ($p['description']) ?></td>
            <td><?= ($p['status'] == 1) ? 'Hiển thị' : 'Ẩn' ?></td>
            <td><?= ($p['category_id']) ?></td>
            <td>
                <a href="?act=sanpham&page=sua&product_id=<?= $p['product_id'] ?>" class="btn btn-warning btn-sm">Sửa</a>
            </td>
            <td>
            <a href="?act=sanpham&page=xoa&product_id=<?= $p['product_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</a>
            </td>
        </tr>
    <?php } ?>
  </tbody>
</table>