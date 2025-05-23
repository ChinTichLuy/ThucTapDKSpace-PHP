<?php
include "includes/logger.php";
require 'includes/upload.php';

// test hàm
// ghiNhatKy("Người dùng đã đăng nhập");
// ghiNhatKy("Người dùng đã đăng xuất");
// ghiNhatKy("Người dùng đã comment");
// echo "Đã ghi log!";

if (isset($_POST['submit'])) {

    // Ghi log hành động
    $hanhdong = $_POST['hanhdong'] ?? 'Không có hành động gì';
    ghiNhatKy($hanhdong);

    // Xử lý upload
    $ketquaUpload = xuLyUpload();

    echo $ketquaUpload . "<br>";
    echo $hanhdong . "<br>";
}

?>

<form method="post" enctype="multipart/form-data">
    <input type="text" name="hanhdong" placeholder="Nhập hành động">
    <input type="file" name="minhchung">
    <button type="submit" name="submit">Ghi nhật ký</button>
</form>

<a href="view_log.php">Xem nhật kí log</a>