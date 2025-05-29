<?php
require_once 'db.php';

try {
    // Thông tin sản phẩm cần cập nhật
    $idToUpdate = 9; // ID sản phẩm cần sửa
    $newName = "Bộ máy TalyBang"; 
    $newPrice = 3500000; 
    $newStock = 75; 

    $sql = "UPDATE products 
            SET product_name = :name, unit_price = :price, stock_quantity = :stock 
            WHERE id = :id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $newName, PDO::PARAM_STR);
    $stmt->bindParam(':price', $newPrice, PDO::PARAM_STR);
    $stmt->bindParam(':stock', $newStock, PDO::PARAM_INT);
    $stmt->bindParam(':id', $idToUpdate, PDO::PARAM_INT);

    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo "Đã cập nhật sản phẩm có ID = $idToUpdate";
    } else {
        echo "Không có sản phẩm nào được cập nhật (có thể ID không tồn tại hoặc dữ liệu không đổi)";
    }
} catch (PDOException $e) {
    die("Lỗi cập nhật: " . $e->getMessage());
}
