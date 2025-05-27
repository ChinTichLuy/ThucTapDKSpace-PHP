<?php

function showPartnerInfo(AffiliatePartner $partner, float $orderValue): void
{
    echo $partner->getSummary() . "<br>";
    echo "→ Hoa hồng: " . number_format($partner->calculateCommission($orderValue), 0, ',', '.') . " VNĐ<br><br>";
}

function showTotalCommission(float $total): void
{
    echo "→ Tổng hoa hồng hệ thống chi trả: " . number_format($total, 0, ',', '.') . " VNĐ<br><br>";
}
