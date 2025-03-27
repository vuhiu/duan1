<?php
$upload_dir = __DIR__ . '/upload';
// echo "Đường dẫn thư mục upload: " . $upload_dir;

if (is_writable($upload_dir)) {
    echo "Thư mục '$upload_dir' có quyền ghi.";
} else {
    echo "Thư mục '$upload_dir' không có quyền ghi.";
}
?>