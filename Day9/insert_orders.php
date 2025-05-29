<?php
require_once 'db.php';

// thông tin khách + danh sách sản phẩm đặt
$orders = [
    [
        'customer_name' => 'Nguyễn Văn A',
        'note' => 'Giao hàng trong tuần này',
        'items' => [
            ['product_id' => 8, 'quantity' => 2, 'price' => 2500000],
            ['product_id' => 9, 'quantity' => 1, 'price' => 950000],
        ]
    ],
    [
        'customer_name' => 'Trần Thị B',
        'note' => null,
        'items' => [
            ['product_id' => 10, 'quantity' => 1, 'price' => 3500000],
            ['product_id' => 11, 'quantity' => 2, 'price' => 890000],
        ]
    ],
    [
        'customer_name' => 'Lê Văn C',
        'note' => 'Ưu tiên hàng còn tồn kho',
        'items' => [
            ['product_id' => 12, 'quantity' => 3, 'price' => 1200000],
        ]
    ],
];

// Chuẩn bị câu lệnh INSERT cho orders
$orderStmt = $pdo->prepare("INSERT INTO orders (order_date, customer_name, note) VALUES (CURDATE(), ?, ?)");

// Chuẩn bị câu lệnh INSERT cho order_items
$itemStmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price_at_order_time) VALUES (?, ?, ?, ?)");

foreach ($orders as $order) {
    // Thêm đơn hàng vào bảng orders
    $orderStmt->execute([$order['customer_name'], $order['note']]);
    $orderId = $pdo->lastInsertId();
    echo "Đã thêm đơn hàng ID: $orderId cho khách {$order['customer_name']}<br>";

    // Thêm từng sản phẩm vào order_items
    foreach ($order['items'] as $item) {
        $itemStmt->execute([$orderId, $item['product_id'], $item['quantity'], $item['price']]);
        echo "- Sản phẩm ID {$item['product_id']} | SL: {$item['quantity']} | Giá: {$item['price']}<br>";
    }

    echo "<hr>";
}
