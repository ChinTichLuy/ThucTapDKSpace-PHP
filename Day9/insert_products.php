<?php
require 'db.php'; // Kết nối PDO

try {
    $products = [
        ['Động cơ Servo 500W', 2500000, 10],
        ['Cảm biến nhiệt độ', 950000, 50],
        ['Bảng điều khiển PLC', 3500000, 15],
        ['Thiết bị đóng cắt', 1200000, 20],
        ['Relay công suất lớn', 890000, 30],
    ];

    $sql = "INSERT INTO products (product_name, unit_price, stock_quantity, created_at)
            VALUES (:name, :price, :quantity, NOW())";

    $stmt = $pdo->prepare($sql); //prepare() giúp bảo vệ tránh SQL Injection

    foreach ($products as $product) {
        [$name, $price, $quantity] = $product; //destructuring: Gán các giá trị trong mảng con theo thứ tự
        $stmt->execute([
            ':name' => $name,
            ':price' => $price,
            ':quantity' => $quantity,
        ]);

        echo "Đã thêm: $name | ID = " . $pdo->lastInsertId() . "<br>"; //lastInsertId() in ra ID cuối cùng được tạo mỗi lần thêm
    }
} catch (PDOException $e) {
    echo "Lỗi thêm sản phẩm: " . $e->getMessage();
}
