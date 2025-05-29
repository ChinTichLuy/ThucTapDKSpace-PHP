<?php
require_once 'db.php';

try {
    $minPrice = 1000000;

    $sql = "SELECT * FROM products WHERE unit_price > :min_price ORDER BY unit_price DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':min_price', $minPrice, PDO::PARAM_INT);
    $stmt->execute();

    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<h2>Sản phẩm có giá > 1.000.000 VNĐ:</h2>";
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
