<?php
$current_page = $_GET['act'] ?? 'dashboard';
?>
<div class="sidebar">
    <div class="sidebar-header">
        <h3>Admin Panel</h3>
    </div>
    
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link <?= $current_page == 'dashboard' ? 'active' : '' ?>" href="index.php?act=dashboard">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link <?= $current_page == 'sanpham' ? 'active' : '' ?>" href="index.php?act=sanpham">
                <i class="fas fa-box"></i>
                <span>Sản phẩm</span>
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link <?= $current_page == 'danhmuc' ? 'active' : '' ?>" href="index.php?act=danhmuc">
                <i class="fas fa-list"></i>
                <span>Danh mục</span>
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link <?= $current_page == 'donhang' ? 'active' : '' ?>" href="index.php?act=donhang">
                <i class="fas fa-shopping-cart"></i>
                <span>Đơn hàng</span>
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link <?= $current_page == 'magiamgia' ? 'active' : '' ?>" href="index.php?act=magiamgia">
                <i class="fas fa-ticket-alt"></i>
                <span>Mã giảm giá</span>
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link <?= $current_page == 'khachhang' ? 'active' : '' ?>" href="index.php?act=khachhang">
                <i class="fas fa-users"></i>
                <span>Khách hàng</span>
            </a>
        </li>
    </ul>
</div>

<style>
.sidebar {
    min-height: 100vh;
    background: #2B3A4A;
    color: #fff;
    width: 250px;
    transition: all 0.3s;
}

.sidebar-header {
    padding: 20px;
    background: #1F2937;
}

.sidebar-header h3 {
    color: #fff;
    font-size: 1.2rem;
    margin: 0;
}

.nav-link {
    color: #fff;
    padding: 15px 20px;
    display: flex;
    align-items: center;
    transition: all 0.3s;
}

.nav-link:hover {
    background: #1F2937;
    color: #fff;
}

.nav-link.active {
    background: #1F2937;
    border-left: 4px solid #D10024;
}

.nav-link i {
    margin-right: 10px;
    width: 20px;
    text-align: center;
}

.nav-link span {
    font-size: 0.9rem;
}
</style> 