<?php
function redirect($url)
{
    header("Location: $url");
    exit();
}

// Các hàm helper khác nếu có
