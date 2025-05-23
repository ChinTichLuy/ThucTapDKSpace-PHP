<?php 
include "includes/header.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // lấy dữ liệu
    $ngay = $_POST['ngay'];
    $tenFile = __DIR__ . "/logs/log_" . $ngay . ".txt";

    if (file_exists($tenFile)) {

        echo "<h3>Nhật ký ngày: $ngay</h3>";
        echo "<ul>";

        $fp = fopen($tenFile, "r"); //fopen($tenFile, "r") -> Mở file ở chế độ đọc (read-only). Trả về $fp để đọc dữ liệu trong file.
        while (!feof($fp)) {
            // feof() nghĩa là file end-of-file, trả về true nếu đã tới cuối file.
            // !feof(...) nghĩa là chưa tới cuối file -> tiếp tục đọc.

            $dong = fgets($fp); //fgets($fp) -> Đọc từng dòng từ file $fp.

            if (trim($dong) !== "") {
                echo "<li>" . $dong . "</li>";
            }
        }
        fclose($fp); // fclose() đóng file sau khi đọc xong

        echo "</ul>";
    } else {
        echo "<p style='color:red'>Không có nhật ký cho ngày này.</p>";
    }
}
