<!-- filepath: c:\laragon\www\duan1\admin\views\customer\edit.php -->
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa thông tin khách hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h3 class="text-center">Sửa thông tin khách hàng</h3>
        <form method="POST" action="/duan1/admin/?act=customer&page=update&user_id=<?php echo $customer['user_id']; ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Tên:</label>
                <input type="text" id="name" name="name" class="form-control" value="<?php echo $customer['name']; ?>"
                    required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" id="email" name="email" class="form-control"
                    value="<?php echo $customer['email']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Số điện thoại:</label>
                <input type="text" id="phone" name="phone" class="form-control"
                    value="<?php echo $customer['phone']; ?>">
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Địa chỉ:</label>
                <textarea id="address" name="address"
                    class="form-control"><?php echo $customer['address']; ?></textarea>
            </div>
            <button type="submit" class="btn btn-success w-100">Cập nhật</button>
        </form>
    </div>
</body>

</html>