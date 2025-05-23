<?php
function ghiNhatKy($hanhDong)
{
    // Lấy ngày hiện tại để tạo tên file log
    $ngay = date("Y-m-d");
    $tenFile = __DIR__ . "/../logs/log_$ngay.txt"; //__DIR__ là đường dẫn thư mục chứa file PHP hiện tại.
    // echo __DIR__;

    // Lấy thời gian, IP
    $thoiGian = date("Y-m-d H:i:s");
    $ip = $_SERVER['REMOTE_ADDR']; //$_SERVER['REMOTE_ADDR'] là địa chỉ IP của người dùng gửi request đến server.

    // Dòng log ghi lại
    $noidung = "[$thoiGian] [$ip] $hanhDong" . PHP_EOL; // end of line

    // Ghi log (tạo mới nếu chưa có, thêm vào nếu đã có)
    file_put_contents($tenFile, $noidung, FILE_APPEND); //FILE_APPEND: ghi tiếp vào cuối file thay vì ghi đè
    // file_put_contents(tên_file, nội_dung, cờ_tùy_chọn);
}
