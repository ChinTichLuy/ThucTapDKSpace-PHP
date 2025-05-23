<?php
function xuLyUpload($fileInputName = 'minhchung')
{
    if (isset($_FILES[$fileInputName]) && $_FILES[$fileInputName]['error'] === 0) {
        $file = $_FILES[$fileInputName];
        // echo "<pre>";
        // print_r( $file);
        // echo "</pre>";die;

        // Lấy thông tin
        $tenGoc = $file['name'];
        $duoi = strtolower(pathinfo($tenGoc, PATHINFO_EXTENSION)); // pathinfo( $tenFile, PATHINFO_EXTENSION) lấy phần đuôi của tên file.
        $kichThuoc = $file['size'];
        $tmp = $file['tmp_name'];

        // Kích thước file <= 2MB
        // 1MB = 1024 KB, 1KB = 1024 byte
        //  (2 * 1024 * 1024) = 2MB = 2,097,152 byte
        if ($kichThuoc > 2 * 1024 * 1024) {
            return "File quá lớn (tối đa 2MB)";
        }

        // Kiểm tra định dạng hợp lệ
        $hopLe = ['jpg', 'png', 'pdf'];
        
        if (!in_array($duoi, $hopLe)) { // in_array() là hàm kiểm tra một giá trị có nằm trong mảng không.
            return "Định dạng không hợp lệ (chỉ cho phép jpg, png, pdf)";
        }

        // Tạo tên mới với timestamp
        $tenMoi = 'upload_' . time() . '_' . basename($tenGoc); // basename() để lấy tên file từ đường dẫn đầy đủ (loại bỏ phần thư mục). 
        $duongDan = __DIR__ . '/../uploads/' . $tenMoi;               // images/abc.jpg thì basename() sẽ chỉ giữ lại "abc.jpg"

        // Di chuyển file
        if (move_uploaded_file($tmp, $duongDan)) {
            return "File đã được upload thành công: uploads/$tenMoi";
        } else {
            return "Lỗi khi upload file";
        }
    }
    return "Không có file nào được upload";
}
