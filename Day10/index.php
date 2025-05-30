<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Day 10</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light p-4">
    <div class="container">
        <h1 class="text-center fw-bold display-4" style="color: #3BC8AC; text-shadow: 1px 1px 2px rgba(0,0,0,0.1);">
            HoangTaly E-Mart
        </h1>

        <h2 class="mb-4">Danh sách sản phẩm</h2>

        <div class="d-flex justify-content-end mb-4">
            <input type="text" id="search" class="form-control" placeholder="Tìm kiếm sản phẩm..." style="width: 300px;">
            <select id="brand-filter" class="form-select" style="width: 300px;">
                <option value="">-- Lọc theo thương hiệu --</option>
            </select>
        </div>
        <div id="product-list" class="row g-3">
            <?php
            require_once 'db.php';

            $stmt = $pdo->query("SELECT * FROM products");
            while ($product = $stmt->fetch()) {
                echo '<div class="col-md-4">';
                echo '  <div class="card h-100 shadow-sm">';
                echo '    <div class="card-body">';
                echo '      <h5 class="card-title text-primary product" style="cursor:pointer;" data-id="' . $product['id'] . '">' . $product['name'] . " - " . $product['brand'] . '</h5>';
                echo '      <button class="btn btn-success add-to-cart" data-id="' . $product['id'] . '">Thêm vào giỏ</button>';
                echo '    </div>';
                echo '  </div>';
                echo '</div>';
            }
            ?>
        </div>

        <h3 class="mt-5">Chi tiết sản phẩm</h3>
        <div id="product-detail" class="border p-3 bg-white mt-2 rounded">Click vào tên sản phẩm để xem chi tiết...</div>

        <h3 class="mt-5">Bình chọn sản phẩm yêu thích</h3>
        <form id="poll-form" class="bg-white p-3 rounded border">
            <div class="mb-3" id="poll-options">
                <!-- các option bình chọn sẽ được ném vào đây từ cái ajax -->
            </div>
            <button type="submit" class="btn btn-primary">Bình chọn</button>
        </form>
        <div id="poll-result" class="mt-3"></div>

        <h3 class="mt-5">Giỏ hàng</h3>
        <div id="cart" class="border p-3 bg-white mt-2 rounded"></div>

    </div>

    <!-- Bootstrap JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- AJAX -->
    <script>
        // Bắt sự kiện click vào sản phẩm
        function bindDetailEvents() {
            document.querySelectorAll('.product').forEach(item => {
                item.addEventListener('click', function() { // Gắn sự kiện 'click' cho từng sản phẩm
                    const productId = this.getAttribute('data-id'); // Lấy ID sản phẩm

                    // Gửi request AJAX tới PHP để lấy thông tin chi tiết
                    fetch('get_product.php?id=' + productId)
                        .then(response => response.text()) // Server trả về HTML nên phải dùng .text() để đọc dữ liệu
                        .then(data => {
                            // Hiển thị vào div đã set ở giao diẹn có ID 'product-detail'
                            document.getElementById('product-detail').innerHTML = data;
                        })
                        .catch(error => {
                            console.error('Lỗi:', error);
                        });
                });
            });
        }

        // Gắn sự kiện click cho nút "Bỏ vào giỏ"
        function bindAddToCartEvents() {
            document.querySelectorAll('.add-to-cart').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.stopPropagation(); // Ngăn click lan ra ngoài, sự kiện click lan sang các phần tử khác (ví dụ: click vào sản phẩm)

                    const id = this.getAttribute('data-id');

                    // Gửi request thêm sản phẩm vào giỏ
                    fetch('cart.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded', // Gửi dữ liệu theo định dạng form
                            },
                            body: 'id=' + encodeURIComponent(id) // Truyền tham số 'id' đã được mã hóa
                        })
                        .then(response => response.text())
                        .then(data => {
                            alert(data); // Hiển thị thông báo thành công
                            loadCart(); // Tự động cập nhật giỏ hàng sau khi thêm sản phẩm
                        })
                        .catch(error => {
                            console.error('Lỗi:', error);
                        });
                });
            });
        }

        // Hàm gọi AJAX hiển thị view giỏ hàng
        function loadCart() {
            // Gửi request GET đến 'view_cart.php' để lấy nội dung giỏ hàng dưới dạng HTML
            fetch('view_cart.php')
                .then(res => res.text())
                .then(cartHTML => {
                    // Gắn HTML giỏ hàng vào div có ID là 'cart'
                    document.getElementById('cart').innerHTML = cartHTML;

                    bindRemoveEvents(); // Gắn lại sự kiện xóa sau khi load giỏ
                });
        }

        // Gắn lại nút XÓA cho từng item sau khi render giỏ
        function bindRemoveEvents() {
            document.querySelectorAll('.remove-item').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    fetch('remove_from_cart.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: 'id=' + encodeURIComponent(id)
                        })
                        .then(res => res.text())
                        .then(data => {
                            document.getElementById('cart').innerHTML = data; // Cập nhật lại nội dung giỏ hàng
                            bindRemoveEvents(); // Gắn lại nút xóa sau khi cập nhật
                        });
                });
            });
        }

        // Xử lý sự kiện tìm kiếm trong ô tìm kiếm
        document.getElementById('search').addEventListener('input', function() {

            const keyword = this.value;

            // Gửi AJAX đến search.php
            fetch('search.php?keyword=' + encodeURIComponent(keyword))
                .then(res => res.text())
                .then(data => {
                    document.getElementById('product-list').innerHTML = data;
                    bindAddToCartEvents(); // gắn lại sự kiện bỏ vào giỏ
                    bindDetailEvents(); // gắn lại click để xem chi tiết sp
                })
                .catch(error => console.error('Lỗi:', error));
        });

        // Load danh sách thương hiệu từ XML để ném vào dropdown
        fetch('brands.xml')
            .then(response => response.text())
            .then(str => {
                // Khởi tạo trình phân tích XML
                const parser = new DOMParser();

                // Phân tích chuỗi XML thành đối tượng DOM
                const xml = parser.parseFromString(str, "application/xml");

                // Lấy tất cả thẻ brand trong XML
                const brands = xml.querySelectorAll('brand');

                // Lấy element có ID là 'brand-filter'
                const select = document.getElementById('brand-filter');

                // Lặp qua từng thẻ brand để tạo option cho dropdown
                brands.forEach(brand => {
                    const option = document.createElement('option'); // Tạo phần tử <option> mới
                    option.value = brand.getAttribute('id'); // Lấy giá trị ID từ thẻ <brand>
                    option.textContent = brand.textContent; // Lấy tên thương hiệu (nội dung trong thẻ <brand>)
                    select.appendChild(option); // Thêm option vào dropdown
                });
            });

        // Gắn sự kiện cho dropdown lọc thương hiệu (khi người dùng chọn thương hiệu)
        document.getElementById('brand-filter').addEventListener('change', function() {
            const selectedBrand = this.value;

            fetch('filter_by_brand.php?brand=' + encodeURIComponent(selectedBrand))
                .then(res => res.text())
                .then(data => {
                    document.getElementById('product-list').innerHTML = data;
                    bindAddToCartEvents();
                    bindDetailEvents();
                });
        });

        // Hàm tải các lựa chọn bình chọn từ server và hiển thị lên giao diện
        function loadPollOptions() {
            fetch('poll_options.php')
                .then(res => res.text())
                .then(html => {
                    document.getElementById('poll-options').innerHTML = html;
                });
        }

        // Gắn sự kiện nút submit form bình chọn
        document.getElementById('poll-form').addEventListener('submit', function(e) {
            e.preventDefault(); // Ngăn chặn form gửi theo cách mặc định (tải lại trang)

            // Tạo đối tượng formData từ chính form này (tự động lấy tất cả dữ liệu trong form)
            const formData = new FormData(this);

            fetch('vote.php', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.text())
                .then(data => {
                    alert(data);
                    showPollResult(); // cập nhật hiện kết quả bình chọn
                });
        });

        // hiện kết quả bình chọn
        function showPollResult() {
            fetch('poll_result.php')
                .then(res => res.text())
                .then(html => {
                    document.getElementById('poll-result').innerHTML = html;
                });
        }

        // Khi load trang xong, tự động gắn sự kiện
        window.addEventListener('DOMContentLoaded', function() {
            loadCart(); // Gọi giỏ hàng
            bindDetailEvents(); // Gắn sự kiện click sản phẩm
            bindAddToCartEvents(); // Gắn sự kiện thêm giỏ
            loadPollOptions();
            showPollResult();
        });
    </script>
</body>

</html>