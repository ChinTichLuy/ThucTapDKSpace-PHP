<?php
// Dữ liệu mẫu
$employees = [
    ['id' => 101, 'name' => 'Nguyễn Văn A', 'base_salary' => 5000000],
    ['id' => 102, 'name' => 'Trần Thị B', 'base_salary' => 4500000],
    ['id' => 103, 'name' => 'Lê Văn C', 'base_salary' => 5500000]
];

$timesheet = [
    101 => ['2025-03-01', '2025-03-02', '2025-03-03', '2025-03-04'],
    102 => ['2025-03-01', '2025-03-03', '2025-03-04'],
    103 => ['2025-03-01', '2025-03-02', '2025-03-03', '2025-03-04', '2025-03-05'],
    104 => ['Ngay 1', 'Ngay 2']
];

$adjustments = [
    101 => ['allowance' => 500000, 'deduction' => 200000],
    102 => ['allowance' => 400000, 'deduction' => 100000],
    103 => ['allowance' => 600000, 'deduction' => 300000],
    104 => ['allowance' => 20000, 'deduction' => 30000],
];

// Thêm nhân viên
$new_employees = [
    ['id' => 104, 'name' => 'Phạm Thị D', 'base_salary' => 5800000]
];
$employees = array_merge($employees, $new_employees);
// echo "<pre>";
// print_r( $employees);
// echo "</pre>";


// Thêm và xóa ngày công
// array_unshift($timesheet[101], 'day đầu'); // Thêm đầu
// array_push($timesheet[101], 'day cuối'); // Thêm cuối
// array_shift($timesheet[101]); //Xóa đầu
// array_pop($timesheet[101]); //Xóa cuối
// echo "<pre>";
// print_r( $timesheet);
// echo "</pre>";

// Tính ngày công
$working_days = array_map(function ($days) {
    return count($days);
}, $timesheet);
// echo "<pre>";
// print_r($working_days);
// echo "</pre>";

// Tính lương thực lĩnh
$net_salaries = array_combine(
    // array_column() Trích ra mảng chỉ chứa id của từng nhân viên.
    array_column($employees, 'id'),
    array_map(function ($emp) use ($working_days, $adjustments) {
        $id = $emp['id'];
        $base_salary = $emp['base_salary'];
        $days = $working_days[$id];
        $allowance = $adjustments[$id]['allowance'];
        $deduction = $adjustments[$id]['deduction'];

        $daily_salary = $base_salary / 22;
        return round($daily_salary * $days + $allowance - $deduction); //round() mặc định làm tròn đến số nguyên gần nhất, 0.5 trở lên thì tăng, dưới 0.5 thì giữ nguyên.Trả về số tiền lương dạng int
    }, $employees)
);
// echo "<pre>";
// print_r( $net_salaries);
// echo "</pre>";

// Tạo báo cáo
$payroll_report = array_map(function ($emp) use ($working_days, $adjustments, $net_salaries) {
    $id = $emp['id'];
    $name = $emp['name'];
    $base_salary = $emp['base_salary'];
    $days = $working_days[$id];
    $allowance = $adjustments[$id]['allowance'];
    $deduction = $adjustments[$id]['deduction'];
    $net_salary = $net_salaries[$id];

    return compact('id', 'name', 'days', 'base_salary', 'allowance', 'deduction', 'net_salary');
}, $employees);
// compact() Gom nhiều biến thành một mảng với key là tên biến, value là giá trị biến
// echo "<pre>";
// print_r( $payroll_report);
// echo "</pre>";

// Tìm nhân viên có ngày công cao nhất/thấp nhất
$sorted = $working_days; // Tạo một bản sao của mảng $working_days để sắp xếp, tránh ảnh hưởng bản gốc.
asort($sorted); // Sắp xếp value tăng dần nhưng giữ nguyên key
// echo "<pre>";
// print_r( $sorted);
// echo "</pre>";

$min_id = array_key_first($sorted); // Lấy key đầu tiên
$max_id = array_key_last($sorted); // Lấy key cuối cùng

// Lấy cột 'name' từ mảng $employees, dùng 'id' làm key
$names_by_id = array_column($employees, 'name', 'id');
$min_name = $names_by_id[$min_id];
$max_name = $names_by_id[$max_id];


// Lọc nhân viên có ngày công >= 4
$filtered = array_filter($working_days, function ($days) {
    return $days >= 4;
});
// echo "<pre>";
// print_r( $filtered);
// echo "</pre>";

$filtered_names = array_intersect_key($names_by_id, $filtered);
// echo "<pre>";
// print_r( $filtered_names);
// echo "</pre>";

// Kiểm tra
$check_worked = in_array('2025-03-03', $timesheet[102]); // in_array() kiểm tra xem một giá trị có nằm trong mảng hay không.
$check_adjustment = array_key_exists(101, $adjustments); //array_key_exists() kiểm tra xem key có tồn tại trong mảng hay không.

// Loại bỏ ngày công trùng
$timesheet = array_map('array_unique', $timesheet);
// Duyệt qua từng mảng con trong $timesheet
// Sử dụng hàm array_unique() vào từng mảng con để loại bỏ các ngày bị trùng.

// Tổng quỹ lương
$total_salary = array_sum($net_salaries);

// In bảng lương
echo <<<HTML
<h2>=== BẢNG LƯƠNG NHÂN VIÊN ===</h2>
<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>Mã NV</th>
            <th>Họ tên</th>
            <th>Ngày công</th>
            <th>Lương cơ bản</th>
            <th>Phụ cấp</th>
            <th>Khấu trừ</th>
            <th>Lương thực lĩnh</th>
        </tr>
    </thead>
    <tbody>
HTML;

foreach ($payroll_report as $r) {
    echo "<tr>
            <td>{$r['id']}</td>
            <td>{$r['name']}</td>
            <td>{$r['days']}</td>
            <td>" . number_format($r['base_salary']) . "</td>
            <td>" . number_format($r['allowance']) . "</td>
            <td>" . number_format($r['deduction']) . "</td>
            <td><strong>" . number_format($r['net_salary']) . "</strong></td>
          </tr>";
}

echo "</tbody></table>";

// Thông tin phụ
echo "<br>- Nhân viên đi làm nhiều nhất: $max_name ({$working_days[$max_id]} ngày)<br>";
echo "- Nhân viên đi làm ít nhất: $min_name ({$working_days[$min_id]} ngày)<br>";
echo "- Tổng quỹ lương: " . number_format($total_salary, 2) . " VND<br>";
echo "- Nhân viên có ngày công >= 4: <br> ";
foreach ($filtered_names as $id => $name) {
    echo "ID: $id - Tên: $name - Số ngày công: {$working_days[$id]}<br>";
}
echo "- Kiểm tra xem nhân viên có đi làm vào ngày cụ thể (ví dụ: 2025-03-03) không?    " . ($check_worked ? 'Có' : 'Không') . "<br>";
echo "- Có tồn tại NV 101?     " . ($check_adjustment ? 'Có' : 'Không') . "<br>";
