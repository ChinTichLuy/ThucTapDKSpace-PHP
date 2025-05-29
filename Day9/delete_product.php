<?php
require_once 'db.php';

try {
    // Giả sử ID cần xoá 
    $idToDelete = 8;

    $sql = "DELETE FROM products WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $idToDelete, PDO::PARAM_INT);

    $stmt->execute();

    //Nếu có sản phẩm với id = $idToDelete tồn tại, thì DELETE sẽ thành công → rowCount() trả về lớn hơn 0 (tức là có xóa dòng)
    //Nếu không có bản ghi nào có id = $idToDelete, thì không có gì bị xoá → rowCount() trả về 0 (tức là ko xóa đc dòng nào)
    // rowCount() Đếm số dòng bị ảnh hưởng và trả về
    if ($stmt->rowCount() > 0) {
        echo "Đã xoá sản phẩm có ID = $idToDelete";
    } else {
        echo "Không tìm thấy sản phẩm để xoá (ID = $idToDelete)";
    }
} catch (PDOException $e) {
    die("Lỗi xoá sản phẩm: " . $e->getMessage());
}
