<?php
require_once __DIR__ . '/../../../commons/connect.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);
$conn = connectDB(); 

$id = $_GET['id'] ?? '';

if (!empty($id)) {
    try {
        $sql = "DELETE FROM categories WHERE category_id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            header("Location:http://localhost/duan1/admin/?act=danhmuc");
            exit;
        } else {
            header("Location:http://localhost/duan1/admin/?act=danhmuc");
            exit;
        }
    } catch (PDOException $e) {
        echo "Lỗi: " . $e->getMessage();
    }
} else {
    header("Location:http://localhost/duan1/admin/?act=danhmuc");
    exit;
}

?>


// session_start();
// require '../commons/connect.php'; 

// $conn = connectDB(); 

// $id = $_GET['id'] ?? '';

// if (!empty($id)) {
//     try {
//         $sql = "DELETE FROM categories WHERE category_id = :id";
//         $stmt = $conn->prepare($sql);
//         $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
//         if ($stmt->execute()) {
//             $_SESSION['alert'] = "Xóa danh mục thành công!";
//             $_SESSION['alert_type'] = "success";
//         } else {
//             $_SESSION['alert'] = "Xóa thất bại!";
//             $_SESSION['alert_type'] = "danger";
//         }
//     } catch (PDOException $e) {
//         $_SESSION['alert'] = "Lỗi: " . $e->getMessage();
//         $_SESSION['alert_type'] = "danger";
//     }
// } else {
//     $_SESSION['alert'] = "ID không hợp lệ!";
//     $_SESSION['alert_type'] = "warning";
// }

// header("Location: ../../admin/?act=danhmuc");
// exit();