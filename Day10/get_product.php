<?php
require_once 'db.php';

// lấy giá trị id từ URL (qua biến $_GET)
// sử dụng toán tử ba ngôi để gán giá trị cho biến $id
// đảm bảo luôn là số nguyên "int"
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// Chuẩn bị truy vấn an toàn với PDO (tránh SQL Injection)
$sql = "SELECT * FROM products WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $id]);

// Lấy kết quả
$product = $stmt->fetch(PDO::FETCH_ASSOC);

// Kiểm tra và echo nó ra
if ($product) {
    echo "<strong>Tên:</strong> " . $product['name'] . "<br>";
    echo "<strong>Thương hiệu:</strong> " . $product['brand'] . "<br>";
    echo "<strong>Mô tả:</strong> " . $product['description'] . "<br>";
    echo "<strong>Giá:</strong> " . number_format($product['price']) . " VNĐ<br>";
    echo "<strong>Tồn kho:</strong> " . $product['stock'] . "<br>";
} else {
    echo "Không tìm thấy sản phẩm.";
}


// Lấy đánh giá
$stmt = $pdo->prepare("SELECT rating, comment, created_at FROM reviews WHERE product_id = ? ORDER BY created_at DESC");
$stmt->execute([$id]);
$reviews = $stmt->fetchAll();

echo "<h5 class='mt-4'>Đánh giá:</h5>";
if ($reviews) {
    foreach ($reviews as $review) {
        $stars = str_repeat("⭐", $review['rating']);
        echo "<div class='border-bottom pb-2 mb-2'>";
        echo "<div>$stars</div>";
        echo "<div><em>{$review['comment']}</em></div>";
        echo "<small class='text-muted'>{$review['created_at']}</small>";
        echo "</div>";
    }
} else {
    echo "<p>Chưa có đánh giá nào.</p>";
}


