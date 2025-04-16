<!-- filepath: c:\xampp\htdocs\duan1\admin\index.php -->
<?php
session_start();
require_once __DIR__ . '/../commons/BaseModel.php';

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
        <div class="row align-items-center">
            
            <div class="col-md-4 text-end">
                <a href="/duan1/admin/controllers/authenController.php?action=logout" class="btn btn-danger">Đăng xuất</a>
            </div>
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