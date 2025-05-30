<?php
require_once 'db.php';

$stmt = $pdo->query("SELECT id, name FROM products");

while ($row = $stmt->fetch()) {
    echo '<div class="form-check">';
    echo '  <input class="form-check-input" type="radio" name="product_id" value="' . $row['id'] . '" id="poll' . $row['id'] . '">';
    echo '  <label class="form-check-label" for="poll' . $row['id'] . '">' . $row['name'] . '</label>';
    echo '</div>';
}
