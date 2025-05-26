<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';

    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $index => $item) {
            if ($item['title'] === $title) {

                unset($_SESSION['cart'][$index]);

                // Reset lại key index để tránh lỗi 
                $_SESSION['cart'] = array_values($_SESSION['cart']);
                break;
            }
        }
    }
}

// Quay lại trang xác nhận
header('Location: confirm_order.php');
exit;
