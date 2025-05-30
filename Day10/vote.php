<?php
require_once 'db.php';

$id = $_POST['product_id'] ?? null;

if ($id) {
    // Nếu đã có, tăng lượt vote
    $stmt = $pdo->prepare("INSERT INTO polls (product_id, votes) VALUES (?, 1) ON DUPLICATE KEY UPDATE votes = votes + 1");
    $stmt->execute([$id]);
    echo 'Cảm ơn bạn đã bình chọn!';
} else {
    echo 'Vui lòng chọn một sản phẩm!';
}
