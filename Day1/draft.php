<?php

// Syntax 
echo 'abc abc hello world <br>  ';

// Variables – Biến
$campaignName = "Spring Sale 2025"; // Tên chiến dịch
$orderCount = 150;                  // Số đơn hàng
$productPrice = 99.99;             // Giá sản phẩm
$isEnded = true;                   // Trạng thái: kết thúc

// Echo
echo "Tên chiến dịch: $campaignName<br>";

// Print
print("Số đơn hàng: $orderCount<br>");

// Print_r
$orderList = [
    "ID001" => 99.99,
    "ID002" => 49.99,
    "ID003" => 89.99,
];
print_r($orderList); // Hiển thị mảng

/*
6. Data Types – Kiểu dữ liệu

- string: "Spring Sale"

- int: 150

- float: 99.99

- bool: true / false

- array: (mảng) danh sách đơn hàng

*/

// Strings/ Numbers/ Casting
echo "<br> <br>";
$orderCount = (int) "150"; // ép kiểu chuỗi sang số
echo "Số đơn hàng là: " . $orderCount;

// Math – Tính toán
$revenue = $productPrice * $orderCount;

// Constants – Hằng số
const COMMISSION_RATE = 0.2; // 20%
const VAT_RATE = 0.1;        // 10%

// Magic Constants – Dùng debug
echo "<br> <br>";
echo "File: " . __FILE__ . "<br>";
echo "Dòng: " . __LINE__ . "<br>";

//Operators – Toán tử
echo "<br> <br>";
$profit = $revenue - ($revenue * COMMISSION_RATE) - ($revenue * VAT_RATE);

if ($profit > 0) {
    echo "Profit = $profit$";
    echo "Chiến dịch thành công!";
}

//If...Else...Elseif
echo "<br> <br>";

$profit = -10;

if ($profit > 0) {
    echo "Chiến dịch thành công";
} elseif ($profit == 0) {
    echo "Chiến dịch hòa vốn";
} else {
    echo "Chiến dịch thất bại";
}

// Switch – Phân loại sản phẩm
echo "<br> <br>";
$productType = "Thời trang";

switch ($productType) {
    case "Thời trang":
        echo "Sản phẩm Thời trang có doanh thu ổn định";
        break;
    case "Điện tử":
        echo "Sản phẩm Điện tử cạnh tranh cao";
        break;
}


//Loops – Vòng lặp
// Tính tổng doanh thu từ danh sách đơn
echo "<br> <br>";

$totalRevenue = 0;
foreach ($orderList as $order => $price) {
    echo "Đơn $order có giá: $price$<br>";
    $totalRevenue += $price;
}
echo "<br>Tổng doanh thu: $totalRevenue$";


//Functions – Hàm
function calculateProfit($revenue)
{
    return $revenue - ($revenue * COMMISSION_RATE) - ($revenue * VAT_RATE);
}
echo "<br> Doanh thu = $revenue$";
