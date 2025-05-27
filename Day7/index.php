<?php

require_once "models/AffiliatePartner.php";
require_once "models/PremiumAffiliatePartner.php";
require_once "controllers/AffiliateManager.php";
require_once "views/console-view.php";

// Tạo cộng tác viên
$partner1 = new AffiliatePartner("Nguyễn Văn A", "a@gmail.com", 10);
$partner2 = new AffiliatePartner("Trần Thị B", "b@gmail.com", 8);
$premium  = new PremiumAffiliatePartner("Lê Văn C", "c@gmail.com", 12, 50000);

// Khởi tạo controller
$manager = new AffiliateManager();
$manager->addPartner($partner1);
$manager->addPartner($partner2);
$manager->addPartner($premium);

// Hiển thị danh sách
$manager->listPartners();

// Hoa hồng mỗi đơn
echo "<br>===== TÍNH HOA HỒNG =====<br>";
$orderValue = 2000000;
echo "Giá trị mỗi đơn hàng: " . number_format($orderValue, 0, ',', '.') . " VNĐ<br><br>";

// View
foreach ([$partner1, $partner2, $premium] as $p) {
    showPartnerInfo($p, $orderValue);
}

$total = $manager->totalCommission($orderValue);
showTotalCommission($total);
