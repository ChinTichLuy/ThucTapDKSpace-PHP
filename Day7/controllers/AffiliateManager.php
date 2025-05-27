<?php

class AffiliateManager
{
    private array $partners = []; // Mảng chứa đối tượng cộng tác viên

    // Thêm cộng tác viên vào danh sách
    public function addPartner(AffiliatePartner $affiliate): void
    {
        $this->partners[] = $affiliate;
    }

    // In thông tin của tất cả cộng tác viên
    public function listPartners(): void
    {
        echo "===== DANH SÁCH CỘNG TÁC VIÊN =====<br>";
        foreach ($this->partners as $partner) {
            echo $partner->getSummary() . "<br>";
        }
    }

    // Tính tổng hoa hồng nếu mỗi người đều có 1 đơn hàng trị giá $orderValue
    public function totalCommission(float $orderValue): float
    {
        $total = 0;
        foreach ($this->partners as $partner) {
            $total += $partner->calculateCommission($orderValue);
        }
        return $total;
    }
}
