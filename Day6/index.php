<?php
session_start();
$customer_email = $_COOKIE['customer_email'] ?? ''; // lấy email người dùng từ cookie nếu có
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Thêm Sách Vào Giỏ Hàng</title>

    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body>
    <div class="container my-5" style="max-width: 600px;">
        <h2 class="mb-4 text-center">Chọn sách muốn mua</h2>
        <form action="process_cart.php" method="post" novalidate>
            <div class="mb-3">
                <label for="book_title" class="form-label">Sách</label>
                <select class="form-select" id="book_title" name="book_title" required>
                    <option value="" disabled selected>-- Chọn sách --</option>
                    <option value="Clean Code">Clean Code - 150,000đ</option>
                    <option value="Design Patterns">Design Patterns - 200,000đ</option>
                    <option value="Refactoring">Refactoring - 180,000đ</option>
                </select>
                <div class="invalid-feedback">
                    Vui lòng chọn một cuốn sách.
                </div>
            </div>

            <div class="mb-3">
                <label for="quantity" class="form-label">Số lượng</label>
                <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1" required />
                <div class="invalid-feedback">
                    Vui lòng nhập số lượng hợp lệ (tối thiểu 1).
                </div>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= $customer_email ?>" required />
                <div class="invalid-feedback">
                    Vui lòng nhập email hợp lệ.
                </div>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Số điện thoại</label>
                <input type="text" class="form-control" id="phone" name="phone" required />
                <div class="invalid-feedback">
                    Vui lòng nhập số điện thoại.
                </div>
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Địa chỉ giao hàng</label>
                <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                <div class="invalid-feedback">
                    Vui lòng nhập địa chỉ giao hàng.
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100">Thêm vào giỏ hàng</button>
        </form>
    </div>

    <!-- Bootstrap JS + Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Bootstrap form validation
        (() => {
            'use strict'
            const forms = document.querySelectorAll('form')

            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
</body>

</html>