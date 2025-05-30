<?php
require_once 'db.php';

$brand = $_GET['brand'] ?? '';

if ($brand) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE brand = ?");
    $stmt->execute([$brand]);
} else {
    $stmt = $pdo->query("SELECT * FROM products");
}

while ($product = $stmt->fetch()) {
    echo '<div class="col-md-4">';
    echo '  <div class="card h-100 shadow-sm">';
    echo '    <div class="card-body">';
    echo '      <h5 class="card-title text-primary product" style="cursor:pointer;" data-id="' . $product['id'] . '">' . $product['name'] . " - " . $product['brand']  . '</h5>';
    echo '      <button class="btn btn-success add-to-cart" data-id="' . $product['id'] . '">Thêm vào giỏ</button>';
    echo '    </div>';
    echo '  </div>';
    echo '</div>';
}
