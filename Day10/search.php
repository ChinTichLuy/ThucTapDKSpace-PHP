<?php
require_once 'db.php';

$keyword = isset($_GET['keyword']) ? trim(string: $_GET['keyword']) : '';

// Chuẩn bị truy vấn tìm kiếm sử dụng LIKE ( tìm kiếm tương đối )
$stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE :keyword");
$stmt->execute(['keyword' => '%' . $keyword . '%']); //tìm mọi tên sản phẩm có chứa $keyword ở bất kỳ đâu trong chuỗi.

$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($products) > 0) {
    foreach ($products as $product) {
        echo '<div class="col-md-4">';
        echo '  <div class="card h-100 shadow-sm">';
        echo '    <div class="card-body">';
        echo '      <h5 class="card-title text-primary product" style="cursor:pointer;" data-id="' . $product['id'] . '">' . $product['name'] . '</h5>';
        echo '      <button class="btn btn-success add-to-cart" data-id="' . $product['id'] . '">Thêm vào giỏ</button>';
        echo '    </div>';
        echo '  </div>';
        echo '</div>';
    }
} else {
    echo '<div class="col-md-4">';
    echo 'Không tìm thấy sản phẩm phù hợp!';
    echo '</div>';
}
