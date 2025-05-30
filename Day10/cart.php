<?php
session_start();

// Kiểm tra dữ liệu POST
if (isset($_POST['id'])) {
    
    $id = (int) $_POST['id'];

    // Nếu session giỏ hàng chưa có thì khởi tạo
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Nếu đã có sp trong giỏ rồi thì cộng thêm vào còn nếu chưa có thì tạo mới = 1 
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]++;
    } else {
        $_SESSION['cart'][$id] = 1;
    }

    echo "Đã thêm sản phẩm ID $id vào giỏ hàng.";
} else {
    echo "Thiếu dữ liệu sản phẩm.";
}
