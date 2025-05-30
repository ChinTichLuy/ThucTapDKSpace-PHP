<?php
require_once 'db.php';

// Truy vấn lấy danh sách sản phẩm và số lượt bình chọn tương ứng (nếu có)
// Nếu sản phẩm chưa có bình chọn thì dùng IFNULL để thay thế bằng 0
$stmt = $pdo->query(
    "SELECT p.name,
            IFNULL(pl.votes, 0) 
            AS votes
            FROM products p
            LEFT JOIN polls pl 
            ON p.id = pl.product_id"
);

$totalVotes = 0;
$results = [];

while ($row = $stmt->fetch()) {
    $results[] = $row;
    $totalVotes += $row['votes'];
}

foreach ($results as $item) {
    // Tính phần trăm số lượt bình chọn cho mỗi sản phẩm (làm tròn đến 2 chữ số thập phân)
    $percent = $totalVotes > 0 ? round($item['votes'] / $totalVotes * 100, 2) : 0;
    echo '<div class="mb-2">';
    echo '<strong>' . $item['name'] . '</strong> - ' . $percent . '% (' . $item['votes'] . ' votes)';
    // thanh tiến trình biểu diễn phần trăm giao diện (Bootstrap)
    echo '<div class="progress">';
    echo '  <div class="progress-bar" style="width: ' . $percent . '%;">' . $percent . '%</div>';
    echo '</div>';
    echo '</div>';
}
