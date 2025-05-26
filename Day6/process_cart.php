<?php
session_start();

// mảng giá sách theo tên
$book_prices = [
    'Clean Code' => 150000,
    'Design Patterns' => 200000,
    'Refactoring' => 180000
];

// lấy dữ liệu từ form POST
// --- DÙNG FILTER ĐỂ LẤY VÀ KIỂM TRA DỮ LIỆU POST ---
$book_title = filter_input(INPUT_POST, 'book_title', FILTER_SANITIZE_FULL_SPECIAL_CHARS); // FILTER_SANITIZE_FULL_SPECIAL_CHARS	Loại bỏ HTML tag
$quantity = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT, [ //FILTER_VALIDATE_INT + min_range	Ép kiểu số, số lượng phải ≥ 1
    'options' => ['min_range' => 1]
]);
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$phone = filter_input(INPUT_POST, 'phone', FILTER_VALIDATE_REGEXP, [
    'options' => ['regexp' => '/^[0-9]{10}$/']
]);
$address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

if (!$book_title || !$quantity || !$email || !$phone || !$address) {
    die("Dữ liệu không hợp lệ. Vui lòng quay lại <a href='index.php'>form đặt sách</a>");
}

// Lưu email vào cookie 7 ngày
setcookie('customer_email', $email, time() + (86400 * 7), '/'); // 86400s = 1 ngày
/*
 ### setcookie(name, value, expire, path, domain, secure, httponly);
- thường ta chỉ dùng các tham số chính: name, value, expire, path
 'customer_email':        trình duyệt sẽ lưu cookie này dưới key "customer_email"
  $email:                 là giá trị của cookie. nếu $email = "abc@example.com" thì cookie lưu:'customer_email' = 'abc@example.com'
  time() + (86400 * 7)    là thời điểm hết hạn của cookie (tính bằng số giây)
  '/'                     là đường dẫn (path)
  '/' nghĩa là cookie sẽ có hiệu lực cho toàn bộ website (từ gốc tên miền trở đi)
  Nếu dùng /shop/ thì cookie chỉ hoạt động trong /shop và các thư mục con                     
*/

// Gán giá dựa trên tên sách
$price = $book_prices[$book_title] ?? 0;

// tạo mảng giỏ hàng
$item = [
    'title' => $book_title,
    'quantity' => $quantity,
    'price' => $price
];

// Nếu chưa có session giỏ hàng, tạo mới
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Kiểm tra nếu sách đã có thì cộng thêm số lượng
$found = false; // khởi tạo mặc định là chưa thấy(false) để tiến hành tìm
foreach ($_SESSION['cart'] as &$cart_item) {
    if ($cart_item['title'] === $book_title) {
        $cart_item['quantity'] += $quantity;
        $found = true; // tìm thấy sẽ trả về (true) đã tìm thấy
        break;
    }
}
unset($cart_item); // xóa tham chiếu

// Nếu chưa có sách này, thêm mới
if (!$found) {
    $_SESSION['cart'][] = $item;
}

// Lưu thêm thông tin khách hàng vào session
$_SESSION['customer'] = [
    'email' => $email,
    'phone' => $phone,
    'address' => $address
];
// echo "<pre>";
// print_r($_SESSION);
// echo "</pre>";


// Chuyển hướng sang trang xác nhận đơn hàng
header("Location: confirm_order.php");
exit;
