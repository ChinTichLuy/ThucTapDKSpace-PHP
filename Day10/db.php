<?php
// Cấu hình thông tin kết nối
$host = 'localhost';
$dbname = 'day10php';
$username = 'root';
$password = '';

try {
    // Tạo PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
} catch (PDOException $e) {
    // Bắt lỗi nếu kết nối thất bại
    echo "Kết nối thất bại: " . $e->getMessage();
}
