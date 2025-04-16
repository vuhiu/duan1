<?php
class DashboardController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function index() {
        // Lấy dữ liệu thống kê
        $totalRevenue = $this->getTotalRevenue();
        $totalOrders = $this->getTotalOrders();
        $totalProducts = $this->getTotalProducts();
        $totalCustomers = $this->getTotalCustomers();
        
        // Dữ liệu cho biểu đồ
        $chartData = $this->getChartData();
        $chartLabels = $chartData['labels'];
        $revenueData = $chartData['revenue'];
        
        // Top sản phẩm bán chạy
        $topProducts = $this->getTopProducts();
        
        // Đơn hàng gần đây
        $recentOrders = $this->getRecentOrders();

        // Load view
        require_once __DIR__ . '/../views/dashboard/index.php';
    }

    private function getTotalRevenue() {
        $stmt = $this->conn->query("
            SELECT SUM(amount) as total 
            FROM order_details 
            WHERE status != 'cancelled'
        ");
        return $stmt->fetch()['total'] ?? 0;
    }

    private function getTotalOrders() {
        $stmt = $this->conn->query("
            SELECT COUNT(*) as total 
            FROM order_details
        ");
        return $stmt->fetch()['total'] ?? 0;
    }

    private function getTotalProducts() {
        $stmt = $this->conn->query("
            SELECT COUNT(*) as total 
            FROM products
        ");
        return $stmt->fetch()['total'] ?? 0;
    }

    private function getTotalCustomers() {
        $stmt = $this->conn->query("
            SELECT COUNT(*) as total 
            FROM users 
            WHERE role_id = 1
        ");
        return $stmt->fetch()['total'] ?? 0;
    }

    private function getChartData() {
        // Lấy dữ liệu 30 ngày gần nhất
        $labels = [];
        $revenue = [];

        $stmt = $this->conn->query("
            SELECT DATE(created_at) as date,
                   SUM(amount) as daily_revenue
            FROM order_details
            WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
            AND status != 'cancelled'
            GROUP BY DATE(created_at)
            ORDER BY date ASC
        ");

        while ($row = $stmt->fetch()) {
            $labels[] = date('d/m', strtotime($row['date']));
            $revenue[] = (float)$row['daily_revenue'];
        }

        return [
            'labels' => $labels,
            'revenue' => $revenue
        ];
    }

    private function getTopProducts() {
        $stmt = $this->conn->query("
            SELECT p.name,
                   COUNT(o.order_id) as order_count,
                   SUM(od.amount) as revenue
            FROM products p
            JOIN orders o ON p.product_id = o.product_id
            JOIN order_details od ON o.order_detail_id = od.order_detail_id
            WHERE od.status != 'cancelled'
            GROUP BY p.product_id, p.name
            ORDER BY revenue DESC
            LIMIT 5
        ");
        return $stmt->fetchAll();
    }

    private function getRecentOrders() {
        $stmt = $this->conn->query("
            SELECT od.order_detail_id,
                   od.name as customer_name,
                   od.amount,
                   od.status,
                   od.created_at
            FROM order_details od
            ORDER BY od.created_at DESC
            LIMIT 5
        ");
        return $stmt->fetchAll();
    }

    public function getStatusColor($status) {
        $colors = [
            'pending' => 'warning',
            'confirmed' => 'info',
            'shiping' => 'primary',
            'delivered' => 'success',
            'cancelled' => 'danger'
        ];
        return $colors[$status] ?? 'secondary';
    }

    public function getStatusText($status) {
        $texts = [
            'pending' => 'Chờ xác nhận',
            'confirmed' => 'Đã xác nhận',
            'shiping' => 'Đang giao',
            'delivered' => 'Đã giao',
            'cancelled' => 'Đã hủy'
        ];
        return $texts[$status] ?? $status;
    }
} 