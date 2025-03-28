<!-- filepath: c:\xampp\htdocs\duan1\admin\index.php -->
<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: /duan1/admin/views/form-login.php");
    exit;
}

echo "Xin chào, " . $_SESSION['admin']['name'] . " (Admin)";
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