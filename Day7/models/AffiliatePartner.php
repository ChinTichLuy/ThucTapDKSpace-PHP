<?php

class AffiliatePartner
{
    // Hằng số tên nền tảng
    const PLATFORM_NAME = "VietLink Affiliate";

    // Thuộc tính
    private string $name;
    private string $email;
    private float $commissionRate; // phần trăm hoa hồng
    protected bool $isActive;

    // Hàm khởi tạo
    public function __construct(string $name, string $email, float $commissionRate, bool $isActive = true)
    {
        $this->name = $name;
        $this->email = $email;
        $this->commissionRate = $commissionRate;
        $this->isActive = $isActive;
    }

    // Hàm hủy
    public function __destruct()
    {
        echo "Cộng tác viên '{$this->name}' đã bị huỷ khỏi hệ thống<br>";
    }

    // Tính hoa hồng theo đơn hàng
    public function calculateCommission(float $orderValue): float
    {
        if (!$this->isActive) return 0;
        return $orderValue * ($this->commissionRate / 100);
    }

    // Thông tin tổng quan cộng tác viên
    public function getSummary(): string
    {
        return "Tên: {$this->name} | Email: {$this->email} | Tỷ lệ hoa hồng: {$this->commissionRate}% | Trạng thái: " .
            ($this->isActive ? "Đang hoạt động" : "Ngừng hoạt động") .
            " | Nền tảng: " . self::PLATFORM_NAME;
    }

    // Getter nếu cần dùng ngoài class vì hiện tại biến name đang được bảo vệ bởi $private
    public function getName(): string
    {
        return $this->name;
    }
}
