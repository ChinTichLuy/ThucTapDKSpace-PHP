<?php

// Khai báo namespace 
namespace TalyBank\Accounts;

/**
 * Abstract class (lớp trừu tượng) BankAccount
 * Đây là lớp cơ sở (base class) dùng chung cho các loại tài khoản (như tiết kiệm, thanh toán)
 * Lớp trừu tượng có thể có các phương thức bình thường và cả phương thức trừu tượng
 */
abstract class BankAccount
{
    protected string $accountNumber; // Số tài khoản 
    protected string $ownerName; // Tên chủ tài khoản
    protected float $balance; // Số dư tài khoản

    /**
     * Hàm khởi tạo (constructor) để gán giá trị ban đầu cho tài khoản
     * Khi tạo mới 1 đối tượng tài khoản cần truyền vào 3 tham số:
     * - mã số tài khoản
     * - tên chủ tài khoản
     * - số dư ban đầu
     */
    public function __construct(string $accountNumber, string $ownerName, float $balance)
    {
        $this->accountNumber = $accountNumber;
        $this->ownerName = $ownerName;
        $this->balance = $balance;
        // Tăng tổng số tài khoản
        Bank::$totalAccounts++;
    }

    // Lấy số tài khoản ngân hàng
    public function getAccountNumber(): string
    {
        return $this->accountNumber;
    }

    // Lấy số dư hiện tại của tài khoản
    public function getBalance(): float
    {
        return $this->balance;
    }

    // Lấy tên chủ tài khoản
    public function getOwnerName(): string
    {
        return $this->ownerName;
    }

    /**
     * Phương thức trừu tượng (abstract) để nạp tiền vào tài khoản
     * Lớp con bắt buộc phải định nghĩa cụ thể nội dung của hàm này
     */
    abstract public function deposit(float $amount): void;

    /**
     * Phương thức trừu tượng (abstract) để rút tiền từ tài khoản
     * Lớp con bắt buộc phải định nghĩa cụ thể nội dung của hàm này
     */
    abstract public function withdraw(float $amount): void;

    /**
     * Phương thức trừu tượng (abstract) để lấy loại tài khoản (VD: Tiết kiệm, Thanh toán)
     * Lớp con sẽ triển khai và trả về loại tài khoản tương ứng
     */
    abstract public function getAccountType(): string;
}
