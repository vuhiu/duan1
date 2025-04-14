<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    $host = "localhost";
    $dbname = "du_an_1";
    $username = "root";
    $password = "";

    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
// if ($conn) {
//     echo "Kết nối cơ sở dữ liệu thành công!";
// } else {
//     echo "Kết nối cơ sở dữ liệu thất bại!";
// }
