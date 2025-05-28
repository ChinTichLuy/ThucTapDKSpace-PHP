<?php

namespace TalyBank\Accounts;

class Bank
{
    //Tổng số tài khoản đã được khởi tạo
    public static int $totalAccounts = 0;

    // Lấy tên ngân hàng
    public static function getBankName(): string
    {
        return 'Ngân hàng TalyBank';
    }

    //Lấy tổng số tài khoản đã tạo
    public static function getTotalAccounts(): int
    {
        return self::$totalAccounts;
    }
}
