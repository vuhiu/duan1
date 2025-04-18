<!-- filepath: c:\laragon\www\duan1\admin\views\customer\list.php -->

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Danh sách khách hàng</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php?act=dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active">Danh sách khách hàng</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Thông tin khách hàng</h3>
                        </div>
                        <div class="card-body">
                            <?php if (isset($_SESSION['success'])): ?>
                                <div class="alert alert-success alert-dismissible fade show">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <?= $_SESSION['success']; ?>
                                    <?php unset($_SESSION['success']); ?>
                                </div>
                            <?php endif; ?>

                            <?php if (isset($_SESSION['error'])): ?>
                                <div class="alert alert-danger alert-dismissible fade show">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <?= $_SESSION['error']; ?>
                                    <?php unset($_SESSION['error']); ?>
                                </div>
                            <?php endif; ?>

                            <div class="table-responsive">
                                <table id="customerTable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th width="5%">ID</th>
                                            <th width="20%">Tên</th>
                                            <th width="20%">Email</th>
                                            <th width="15%">Số điện thoại</th>
                                            <th width="20%">Địa chỉ</th>
                                            <th width="10%">Ngày đăng ký</th>
                                            <th width="10%">Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($customers)): ?>
                                            <?php foreach ($customers as $customer): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($customer['user_id'] ?? ''); ?></td>
                                                    <td><?= htmlspecialchars($customer['name'] ?? ''); ?></td>
                                                    <td><?= htmlspecialchars($customer['email'] ?? ''); ?></td>
                                                    <td><?= htmlspecialchars($customer['phone'] ?? ''); ?></td>
                                                    <td><?= htmlspecialchars($customer['address'] ?? ''); ?></td>
                                                    <td>
                                                        <?php
                                                        if (!empty($customer['created_at'])) {
                                                            echo date('d/m/Y', strtotime($customer['created_at']));
                                                        } else {
                                                            echo 'Chưa có dữ liệu';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="index.php?act=customer&page=detail&id=<?= $customer['user_id']; ?>"
                                                            class="btn btn-info btn-sm" title="Xem chi tiết">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="index.php?act=customer&page=edit&id=<?= $customer['user_id']; ?>"
                                                            class="btn btn-warning btn-sm" title="Chỉnh sửa">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="7" class="text-center">Không có dữ liệu</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>