<?php
session_start();

if (isset($_POST['id'])) {
    $id = (int) $_POST['id'];

    if (isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]); // Xóa sản phẩm
    }
}

// Sau khi xóa, trả lại HTML mới của giỏ hàng
if (empty($_SESSION['cart'])) {
    echo "Giỏ hàng trống.";
    exit;
}

echo "<ul>";
foreach ($_SESSION['cart'] as $id => $qty) {
    echo "<li>Sản phẩm ID: $id | Số lượng: $qty 
        <button class='btn btn-danger remove-item' data-id='$id'>Xóa</button></li>";
}
echo "</ul>";
