<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Hệ thống nhật ký</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h2 {
            color: #007BFF;
        }

        ul {
            background: #f1f1f1;
            padding: 10px;
        }

        li {
            margin-bottom: 5px;
        }

        p {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h2>Xem Nhật Ký Hoạt Động</h2>

    <form method="post">
        <label for="ngay">Chọn ngày:</label>
        <input type="date" name="ngay" required>
        <button type="submit">Xem nhật ký</button>
    </form>
    <a href="index.php">Back</a>
</body>

</html>