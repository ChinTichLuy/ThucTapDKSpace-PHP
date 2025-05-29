<?php
require_once 'db.php';

// Dữ liệu từ form người dùng nhập
$product_name = "Bộ điều khiển thông minh Taly";
$unit_price = 1490000;
$stock_quantity = 30;
$created_at = date('Y-m-d H:i:s');

// Chuẩn bị câu lệnh INSERT
$sql = "INSERT INTO products (product_name, unit_price, stock_quantity, created_at) 
        VALUES (:name, :price, :stock, :created)";
$stmt = $pdo->prepare($sql);

// Gắn dữ liệu vào placeholder bằng bind
$stmt->bindValue(':name', $product_name);
$stmt->bindValue(':price', $unit_price);
$stmt->bindValue(':stock', $stock_quantity);
$stmt->bindValue(':created', $created_at);

// Thực thi
$stmt->execute();

echo "Đã thêm sản phẩm mới với ID: " . $pdo->lastInsertId();


/**
 * bindParam() (liên kết với biến → lấy giá trị khi execute())
 * ví dụ:
 * $stmt = $pdo->prepare("SELECT * FROM products WHERE unit_price > :price");
 * $minPrice = 1000000;
 * $stmt->bindParam(':price', $minPrice);
 * $minPrice = 2000000; // giá trị dùng sẽ là 2000000
 * $stmt->execute();    // DÙ đã bind trước đó là 1000000
 * ===
 *  Vì bindParam() liên kết biến $minPrice, nó sẽ lấy giá trị mới nhất khi execute()
 */
/**
 * bindValue() (gắn giá trị ngay lúc gọi)
 * ví dụ:
 * $stmt = $pdo->prepare("SELECT * FROM products WHERE unit_price > :price");
 * $minPrice = 1000000;
 * $stmt->bindValue(':price', $minPrice);
 * $minPrice = 2000000;  // Không ảnh hưởng — vì nó đã dùng 1000000
 * $stmt->execute();
 * ===
 *  Vì bindValue() đã lấy giá trị 1000000 ngay lúc gọi — không quan tâm thay đổi biến sau đó
 */
