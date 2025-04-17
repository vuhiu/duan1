<!-- filepath: c:\laragon\www\duan1\admin\views\customer\detail.php -->
<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Chi tiết khách hàng</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table">
                                        <tr>
                                            <th style="width: 150px">ID:</th>
                                            <td><?= htmlspecialchars($customer['user_id']); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Tên:</th>
                                            <td><?= htmlspecialchars($customer['name']); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Email:</th>
                                            <td><?= htmlspecialchars($customer['email']); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Số điện thoại:</th>
                                            <td><?= htmlspecialchars($customer['phone']); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Địa chỉ:</th>
                                            <td><?= htmlspecialchars($customer['address']); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Ngày đăng ký:</th>
                                            <td><?= htmlspecialchars($customer['created_at']); ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="mt-3">
                                <a href="index.php?act=customer&page=edit&id=<?= $customer['user_id']; ?>"
                                    class="btn btn-warning">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                                <a href="index.php?act=customer&page=list"
                                    class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Quay lại
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>