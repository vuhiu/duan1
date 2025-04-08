<!-- filepath: c:\laragon\www\duan1\admin\views\customer\detail.php -->
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết khách hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h3 class="text-center">Chi tiết khách hàng</h3>
        <?php if (!empty($customer)): ?>
        <table class="table table-bordered">
            <tr>
                <th>ID</th>
                <td><?php echo htmlspecialchars($customer['user_id']); ?></td>
            </tr>
            <tr>
                <th>Tên</th>
                <td><?php echo htmlspecialchars($customer['name']); ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?php echo htmlspecialchars($customer['email']); ?></td>
            </tr>
            <tr>
                <th>Số điện thoại</th>
                <td><?php echo htmlspecialchars($customer['phone']); ?></td>
            </tr>
            <tr>
                <th>Địa chỉ</th>
                <td><?php echo htmlspecialchars($customer['address']); ?></td>
            </tr>
        </table>
        <?php else: ?>
        <div class="alert alert-danger text-center">Không tìm thấy thông tin khách hàng.</div>
        <?php endif; ?>
        <a href="/duan1/admin/?act=customer&page=list" class="btn btn-primary">Quay lại</a>
    </div>
</body>
</html>