<?php
require_once 'db.php';

try {
    $sql = "SELECT * FROM products 
            ORDER BY created_at DESC 
            LIMIT 5";

    $stmt = $pdo->query($sql);
    $products = $stmt->fetchAll();

    echo "<h3>5 Sản phẩm mới nhất:</h3>";
    echo "<ul>";
    foreach ($products as $product) {
        echo "<li>";
        echo $product['product_name'] . "<br>" .
            " - " . number_format($product['unit_price'], 0, ',', '.') . " VNĐ<br>" .
            " - Tồn kho: " . $product['stock_quantity'] . "<br><br>";
        echo "</li>";
    }
    echo "</ul>";
} catch (PDOException $e) {
    die("Lỗi truy xuất sản phẩm mới: " . $e->getMessage());
}
