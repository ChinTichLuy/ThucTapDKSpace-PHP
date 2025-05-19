<?php

// mảng danh sách Chiến dịch
$campaigns = [
    [
        "ten_chien_dich" => "Spring Sale 2025",
        "so_luong_don" => 150,
        "gia_san_pham" => 99.99,
        "ty_le_hoa_hong" => 0.2,
        "loai_san_pham" => "Thời trang",
        "trang_thai" => true,
        "don_hang" => [
            "ID001" => 99.99,
            "ID002" => 49.99,
            "ID003" => 129.99,
            "ID004" => 99.99,
            "ID005" => 79.99
        ]
    ],
    [
        "ten_chien_dich" => "Tech Boom 2025",
        "so_luong_don" => 200,
        "gia_san_pham" => 299.99,
        "ty_le_hoa_hong" => 0.15,
        "loai_san_pham" => "Điện tử",
        "trang_thai" => false,
        "don_hang" => [
            "ID101" => 299.99,
            "ID102" => 199.99,
            "ID103" => 399.99,
            "ID104" => 289.99,
            "ID105" => 310.00
        ]
    ],
    [
        "ten_chien_dich" => "Home Deals 2025",
        "so_luong_don" => 180,
        "gia_san_pham" => 59.99,
        "ty_le_hoa_hong" => 0.1,
        "loai_san_pham" => "Gia dụng",
        "trang_thai" => true,
        "don_hang" => [
            "ID201" => 59.99,
            "ID202" => 39.99,
            "ID203" => 49.99,
            "ID204" => 69.99,
            "ID205" => 59.99
        ]
    ]
];
// Khai báo hằng số (constants) cho hoa hồng và thuế VAT
const COMMISSION_RATE_DEFAULT = 0.2; // mặc định là 20% nếu không có dữ liệu về tỉ lệ hoa hồng trong mảng
const VAT_RATE = 0.1;        // 10%

// Duyệt qua từng chiến dịch để xử lý mảng con bên trong mảng đa chiều
foreach ($campaigns as $index => $camp) {
    // Ép kiểu
    $soLuong = (int)$camp["so_luong_don"];
    $giaSP = (float)$camp["gia_san_pham"];
    $tyLeHoaHong = isset($camp["ty_le_hoa_hong"]) ? (float)$camp["ty_le_hoa_hong"] : COMMISSION_RATE_DEFAULT;

    // Tính doanh thu = giá × số lượng
    $doanhThu = $giaSP * $soLuong;

    // Chi phí hoa hồng = doanh thu × tỷ lệ
    $phiHoaHong = $doanhThu * $tyLeHoaHong;

    // Thuế VAT
    $thueVAT = $doanhThu * VAT_RATE;

    // Lợi nhuận = doanh thu - hoa hồng - VAT
    $loiNhuan = $doanhThu - $phiHoaHong - $thueVAT;

    // Đánh giá chiến dịch
    if ($loiNhuan > 0) {
        $danhGia = "Chiến dịch thành công";
    } elseif ($loiNhuan == 0) {
        $danhGia = "Chiến dịch hòa vốn";
    } else {
        $danhGia = "Chiến dịch thất bại";
    }

    // Thông báo theo loại sản phẩm kết hợp với doanh thu
    switch ($camp["loai_san_pham"]) {
        case "Điện tử":
            $loaiSPMessage = "Sản phẩm điện tử có tính cạnh tranh cao.";
            break;
        case "Thời trang":
            $loaiSPMessage = "Sản phẩm thời trang có doanh thu ổn định.";
            break;
        case "Gia dụng":
            $loaiSPMessage = "Sản phẩm gia dụng thường có nhu cầu cao.";
            break;
        default:
            $loaiSPMessage = "Loại sản phẩm không xác định.";
            break;
    }


    // Tổng doanh thu thực tế từ mảng đơn hàng
    $tongTuDonHang = 0;
    foreach ($camp["don_hang"] as $id => $giaTri) {
        $tongTuDonHang += $giaTri;
    }

    //kết quả đầu ra

    echo "<br>=============================== <br>";
    echo "Chiến dịch " . ($index + 1) . ": " . $camp["ten_chien_dich"] . "<br>";
    echo "Trạng thái: " . ($camp["trang_thai"] ? "Đã kết thúc" : "Đang chạy") . "<br>";
    echo "Tổng doanh thu (theo số lượng x giá): $" . number_format($doanhThu, 2) . "<br>";
    echo "Chi phí hoa hồng: $" . number_format($phiHoaHong, 2) . "<br>";
    echo "Thuế VAT: $" . number_format($thueVAT, 2) . "<br>";
    echo "Lợi nhuận: $" . number_format($loiNhuan, 2) . "<br>";
    echo "Đánh giá: $danhGia <br>";
    echo $loaiSPMessage . "<br>";
    echo "Tổng thực thu từ đơn hàng thực tế: $" . number_format($tongTuDonHang, 2) . "<br>";
    // Hiển thị từng đơn hàng
    echo "Chi tiết đơn hàng:<br>";
    echo "<pre>";
    print_r($camp["don_hang"]);
    echo "</pre>";
    // Thông báo tổng kết
    echo "=>> Chiến dịch {$camp["ten_chien_dich"]} " . ($camp["trang_thai"] ? "kết thúc" : "đang chạy") . " với lợi nhuận: $" . number_format($loiNhuan, 2) . "\n\n";
}
