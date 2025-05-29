<?php
require_once 'db.php';

try {
    $sql = "SELECT * FROM products ORDER BY unit_price DESC";
    $stmt = $pdo->query($sql);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<h2>Sản phẩm sắp xếp theo giá giảm dần:</h2>";
    foreach ($products as $product) {
        echo "<div style='border:1px solid #ccc; padding:10px; margin-bottom:10px;'>";
        echo "<strong>Tên:</strong> " . htmlspecialchars($product['product_name']) . "<br>";
        echo "<strong>Giá:</strong> " . number_format($product['unit_price']) . " VNĐ<br>";
        echo "<strong>Tồn kho:</strong> " . $product['stock_quantity'] . "<br>";
        echo "<strong>Ngày tạo:</strong> " . $product['created_at'];
        echo "</div>";
    }
} catch (PDOException $e) {
    die("Lỗi truy vấn: " . $e->getMessage());
}
