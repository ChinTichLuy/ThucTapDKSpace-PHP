<?php
session_start();

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    die('Giỏ hàng trống hoặc phiên làm việc không hợp lệ.');
}

// Lưu thông tin giỏ hàng và khách hàng
$cart = $_SESSION['cart'];
$customer = $_SESSION['customer'] ?? [
    'email' => '',
    'phone' => '',
    'address' => ''
];

// Tính tổng tiền
$total_amount = 0;
foreach ($cart as $item) {
    $total_amount += $item['quantity'] * $item['price'];
}

// Lưu JSON
$order_data = [
    'customer_email' => $customer['email'],
    'products' => $cart,
    'total_amount' => $total_amount,
    'created_at' => date('Y-m-d H:i:s')
];

$file = 'json/cart_data.json';
try {
    $json_data = json_encode($order_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    if (file_put_contents($file, $json_data) === false) {
        throw new Exception("Không thể ghi vào file JSON.");
    }
} catch (Exception $e) {
    echo "Lỗi: " . $e->getMessage();
    exit;
}
?>
/*
json_encode($order_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
- Chuyển mảng dữ liệu $order_data thành chuỗi JSON.
- JSON_PRETTY_PRINT -> Giúp JSON dễ đọc (thêm dấu xuống dòng, thụt lề).
- JSON_UNESCAPED_UNICODE -> Giữ nguyên tiếng việt và Unicode, không mã hóa thành \uXXXX

file_put_contents($file, $json_data)
- Ghi nội dung JSON vào file json/cart_data.json
- Nếu ghi thành công, trả về số byte đã ghi
- Nếu thất bại, trả về false
*/
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Xác nhận đơn hàng</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container py-5">
        <h2 class="mb-4 text-primary">Xác nhận đơn hàng</h2>

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Tên sách</th>
                        <th>Số lượng</th>
                        <th>Đơn giá</th>
                        <th>Thành tiền</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart as $item): ?>
                        <tr>
                            <td><?= $item['title'] ?></td>
                            <td><?= $item['quantity'] ?></td>
                            <td><?= number_format($item['price']) ?>đ</td>
                            <td><?= number_format($item['quantity'] * $item['price']) ?>đ</td>
                            <td>
                                <form action="remove_from_cart.php" method="post" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?');">
                                    <input type="hidden" name="title" value="<?= $item['title'] ?>">
                                    <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end fw-bold">Tổng cộng:</td>
                        <td colspan="2" class="fw-bold text-danger"><?= number_format($total_amount) ?>đ</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="card mt-4">
            <div class="card-header bg-primary text-white">
                Thông tin khách hàng
            </div>
            <div class="card-body">
                <p><strong>Email:</strong> <?= $customer['email'] ?></p>
                <p><strong>Số điện thoại:</strong> <?= $customer['phone'] ?></p>
                <p><strong>Địa chỉ:</strong> <?= $customer['address'] ?></p>
                <p class="text-muted"><em>Thời gian đặt hàng: <?= date('d/m/Y H:i:s') ?></em></p>
            </div>
        </div>
    </div>
</body>

</html>