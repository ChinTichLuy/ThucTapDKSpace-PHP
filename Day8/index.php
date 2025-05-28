<?php

require_once 'vendor/autoload.php';

use TalyBank\Accounts\Bank;
use TalyBank\Accounts\SavingsAccount;
use TalyBank\Accounts\CheckingAccount;
use TalyBank\Accounts\AccountCollection;

// Tạo biến lưu tài khoản
$collection = new AccountCollection();

// Tạo tài khoản tiết kiệm
$savings = new SavingsAccount("16271125", "HoangTaly", 90000000);
$collection->addAccount($savings);

// Tạo 2 tài khoản thanh toán
$checking1 = new CheckingAccount("20301123", "Lê Văn B", 8000000);
$checking2 = new CheckingAccount("20401124", "Trần Minh C", 2100000);
$collection->addAccount($checking1);
$collection->addAccount($checking2);

// Gửi, rút thêm tiền tài khoản tiết kiệm
$savings->deposit(99999);
$savings->withdraw(9000000);

// Gửi, rút thêm tiền tài khoản thường
$checking1->deposit(5000000);
$checking2->withdraw(2000000);
$checking2->withdraw(100000);
$checking2->withdraw(100000);


//Duyệt tất cả tài khoản và in ra thông tin
echo "<br><strong>Danh sách tài khoản:</strong><br>";
foreach ($collection as $account) {
    echo "Tài khoản: {$account->getAccountNumber()} | {$account->getOwnerName()} | Loại: {$account->getAccountType()} | Số dư: " . number_format($account->getBalance(), 0, ',', '.') . " VNĐ<br>";
}

// Tính và hiển thị lãi suất hàng năm của tài khoản tiết kiệm
$interest = $savings->calculateAnnualInterest();
echo "<br>Lãi suất hàng năm cho {$savings->getOwnerName()}: " . number_format($interest, 0, ',', '.') . " VNĐ<br>";

// In tổng số tài khoản đã khởi tạo
echo "<br>Tổng số tài khoản đã tạo: " . Bank::getTotalAccounts() . "<br>";

// In tên ngân hàng
echo "Tên ngân hàng: " . Bank::getBankName() . "<br>";
