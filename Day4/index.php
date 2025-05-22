<?php

session_start();

// $warnings = $_SESSION['warnings'] ?? [];
// unset($_SESSION['warnings']);

// Khởi tạo session nếu chưa có
if (!isset($_SESSION['transactions'])) {
    $_SESSION['transactions'] = [];
}

// Khởi tạo tổng thu và chi trong biến toàn cục $GLOBALS[]
$GLOBALS['total_income'] = 0;
$GLOBALS['total_expense'] = 0;

// Mảng từ khóa nhạy cảm
$sensitive_keywords = ['nợ xấu', 'vay nóng'];

$errors = []; // Mảng chứa lỗi
$warnings = []; // Mảng cảnh báo

// Xử lý khi người dùng submit form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // print_r($_POST);
    // Lấy dữ liệu từ form
    $transaction_name = trim($_POST['transaction_name'] ?? '');
    $amount = trim($_POST['amount'] ?? '');
    $type = $_POST['type'] ?? '';
    $note = trim($_POST['note'] ?? '');
    $date = trim($_POST['date'] ?? '');

    // VALIDATION 

    // Regex: Tên giao dịch không chứa ký tự đặc biệt
    if (!preg_match('/^[a-zA-Z0-9\sÀ-ỹà-ỹ]+$/u', $transaction_name)) {
        $errors[] = "Tên giao dịch không hợp lệ (không chứa ký tự đặc biệt)";
    }

    // Regex: Số tiền phải là số dương
    if (!preg_match('/^\d+(\.\d{1,2})?$/', $amount)) {
        $errors[] = "Số tiền phải là số dương";
    }

    // Regex: Định dạng ngày phải dd/mm/yyyy
    if (preg_match('/^([1-9]|0[1-9]|[12][0-9]|3[01])\/([1-9]|0[1-9]|1[0-2])\/\d{4}$/', $date)) {
        list($day, $month, $year) = explode('/', $date);
        if (!checkdate((int)$month, (int)$day, (int)$year)) {
            $errors[] = "Ngày không tồn tại trong lịch!";
        }
    } else {
        $errors[] = "Ngày không đúng định dạng dd/mm/yyyy!";
    }


    // Kiểm tra loại giao dịch
    if ($type !== 'income' && $type !== 'expense') {
        $errors[] = "Loại giao dịch không hợp lệ";
    }

    // Cảnh báo nếu ghi chú chứa từ khóa nhạy cảm
    foreach ($sensitive_keywords as $keyword) {
        if (stripos($note, $keyword) !== false) {
            $warnings[] = "Cảnh báo: Ghi chú chứa từ khóa nhạy cảm => $keyword";
        }
    }

    // Nếu không có lỗi, lưu vào session
    if (empty($errors)) {
        $transaction = [
            'name' => $transaction_name,
            'amount' => (float)$amount,
            'type' => $type,
            'note' => $note,
            'date' => $date,
        ];

        $_SESSION['transactions'][] = $transaction;

        // Lưu lại cảnh báo trước khi header()
        // if (!empty($warnings)) {
        //     $_SESSION['warnings'] = $warnings;
        //     header("Location: " . $_SERVER['PHP_SELF']);
        //     exit();
        // }
        // header("Location: " . $_SERVER['PHP_SELF']);
        // exit();
    }
}

// Tính toán lại tổng thu/chi từ session (trong trường hợp reload lại trang)
foreach ($_SESSION['transactions'] as $t) {
    if ($t['type'] === 'income') {
        $GLOBALS['total_income'] += $t['amount'];
        $GLOBALS['total_income'] = round($GLOBALS['total_income'], 2);
    } else {
        $GLOBALS['total_expense'] += $t['amount'];
        $GLOBALS['total_expense'] = round($GLOBALS['total_expense'], 2);
    }
}

// Xử lý xoá giao dịch
if (isset($_GET['delete'])) {
    $deleteIndex = (int)$_GET['delete'];
    if (isset($_SESSION['transactions'][$deleteIndex])) {
        $deleted = $_SESSION['transactions'][$deleteIndex];

        // Cập nhật tổng thu/chi sau khi xoá
        if ($deleted['type'] === 'income') {
            $GLOBALS['total_income'] -= $deleted['amount'];
            $GLOBALS['total_income'] = round($GLOBALS['total_income'], 2);
        } else {
            $GLOBALS['total_expense'] -= $deleted['amount'];
            $GLOBALS['total_expense'] = round($GLOBALS['total_expense'], 2);
        }

        unset($_SESSION['transactions'][$deleteIndex]);

        // Tránh resubmit
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GIAO DỊCH TÀI CHÍNH</title>
    <style>
        body {
            font-family: Arial;
            margin: 30px;
        }

        label {
            display: block;
            margin-top: 10px;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"] {
            padding: 5px;
            width: 300px;
        }

        .error {
            color: red;
        }

        .warning {
            color: orange;
        }
    </style>
</head>

<body>
    <h2>Form giao dịch Tài Chính</h2>
    <!-- Hiển thị lỗi nếu có -->
    <?php if (!empty($errors)) { ?>
        <div class="error">
            <ul>
                <?php foreach ($errors as $err) { ?>
                    <li><?= $err ?></li>
                <?php } ?>
            </ul>
        </div>
    <?php } ?>
    <?php if (!empty($warnings)) { ?>
        <div class="warning">
            <ul>
                <?php foreach ($warnings as $war) { ?>
                    <li><?= $war ?></li>
                <?php } ?>
            </ul>
        </div>
    <?php } ?>

    <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
        <label for="transaction_name">Tên giao dịch:</label>
        <input type="text" id="transaction_name" name="transaction_name" required>

        <label for="amount">Số tiền:</label>
        <input type="number" id="amount" name="amount" min="0" step="0.01" required>

        <label>Loại giao dịch:</label>
        <div style="display: flex; align-items: center; gap: 10px; margin-top: 5px;">
            <input type="radio" id="income" name="type" value="income" required>
            <label for="income">Thu</label>
            <input type="radio" id="expense" name="type" value="expense">
            <label for="expense">Chi</label>
        </div>

        <label for="note">Ghi chú (tùy chọn):</label>
        <textarea id="note" name="note"></textarea>

        <label for="date">Ngày thực hiện:</label>
        <input type="text" id="date" name="date" placeholder="dd/mm/yyyy" required>

        <br><br>
        <button type="submit" name="submit">Gửi giao dịch</button>
    </form>

    <!-- Bảng giao dịch -->
    <?php if (!empty($_SESSION['transactions'])) { ?>
        <h3>Danh sách giao dịch đã nhập:</h3>
        <table border="1" cellpadding="8" cellspacing="0">
            <tr>
                <th>Tên giao dịch</th>
                <th>Số tiền</th>
                <th>Loại</th>
                <th>Ghi chú</th>
                <th>Ngày</th>
                <th>Thao tác</th>
            </tr>
            <?php foreach ($_SESSION['transactions'] as $index => $t) { ?>
                <tr>
                    <td><?= $t['name'] ?></td>
                    <td><?= round($t['amount'], 2) ?></td>
                    <td><?= $t['type'] === 'income' ? 'Thu' : 'Chi' ?></td>
                    <td><?= $t['note'] ?></td>
                    <td><?= $t['date'] ?></td>
                    <td>
                        <a href="?delete=<?= $index ?>" onclick="return confirm('Bạn chắc chắn muốn xoá giao dịch này?')">Xoá</a>
                    </td>
                </tr>
            <?php } ?>
        </table>

        <h3>Thống kê:</h3>
        <ul>
            <li><strong>Tổng thu:</strong> <?= round($GLOBALS['total_income'], 2) ?></li>
            <li><strong>Tổng chi:</strong> <?= round($GLOBALS['total_expense'], 2) ?></li>
            <li><strong>Số dư:</strong> <?= round($GLOBALS['total_income'] - $GLOBALS['total_expense'], 2) ?></li>
        </ul>
    <?php } ?>
</body>

</html>