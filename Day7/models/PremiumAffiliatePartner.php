<?php

require_once "AffiliatePartner.php"; // Kế thừa từ class gốc

class PremiumAffiliatePartner extends AffiliatePartner
{
    private float $bonusPerOrder; // Thưởng cố định mỗi đơn hàng

    public function __construct(string $name, string $email, float $commissionRate, float $bonusPerOrder, bool $isActive = true)
    {
        parent::__construct($name, $email, $commissionRate, $isActive); // Gọi constructor cha
        $this->bonusPerOrder = $bonusPerOrder;
    }

    // Ghi đè phương thức tính hoa hồng
    public function calculateCommission(float $orderValue): float
    {
        if (!$this->isActive) return 0;
        return parent::calculateCommission($orderValue) + $this->bonusPerOrder;
    }

    // Ghi đè tóm tắt để bổ sung thông tin bonus
    public function getSummary(): string
    {
        return parent::getSummary() . " | Thưởng mỗi đơn: " . number_format($this->bonusPerOrder, 0, ',', '.') . " VNĐ";
    }
}
