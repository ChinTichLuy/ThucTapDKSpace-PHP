<?php
// Cấu hình thông tin kết nối
$host = 'localhost';
$dbname = 'tech_factory';
$username = 'root';
$password = '';

try {
    // Tạo PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

    // báo lỗi nếu có
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Kết nối thành công!";
} catch (PDOException $e) {
    // Bắt lỗi nếu kết nối thất bại
    echo "Kết nối thất bại: " . $e->getMessage();
}
