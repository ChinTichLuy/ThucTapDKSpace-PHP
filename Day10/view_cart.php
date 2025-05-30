<?php
session_start();

// Giỏ hàng chưa có gì
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "Giỏ hàng trống";
    exit;
}

// Hiển thị giỏ hàng
echo "<ul>";
foreach ($_SESSION['cart'] as $id => $qty) {
    echo "<li>Sản phẩm ID: $id | Số lượng: $qty 
        <button class='btn btn-danger remove-item' data-id='$id'>Xóa</button></li>";
}
echo "</ul>";
