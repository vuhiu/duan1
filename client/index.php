<?php
session_start();
if (isset($_SESSION['client'])) {
    echo "Xin chào, " . $_SESSION['client']['name'] . " (Client)";
} else {
    echo "Bạn chưa đăng nhập!";
}
?>