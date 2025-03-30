<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: /duan1/admin/views/form-login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang quản trị</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-3">
        <div class="d-flex justify-content-between align-items-center">
            <h1>Chào mừng, <?= $_SESSION['admin']['name'] ?? 'Admin' ?>!</h1>
            <a href="/duan1/admin/controllers/authenController.php?action=logout" class="btn btn-danger">Đăng xuất</a>
        </div>
        <hr>
    </div>
<?php
ob_start(); // Bật bộ đệm đầu ra
ini_set('display_errors', '11');
ini_set('display_startup_errors', '11');
error_reporting(E_ALL);
include __DIR__ . "/layouts/header.php";
include __DIR__ . "/layouts/sidebar.php";
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="min-height: calc(100vh - 57px);"> <!-- Adjust min-height -->
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard v1</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <?php
            include __DIR__ . "/config/router.php";
            ?>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->

<?php
include __DIR__ . "/layouts/copyright.php";
include __DIR__ . "/layouts/footer.php";
?>