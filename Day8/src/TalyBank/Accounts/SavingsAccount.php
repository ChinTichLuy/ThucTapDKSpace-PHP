<?php

namespace TalyBank\Accounts;

use TalyBank\Accounts\BankAccount;
use TalyBank\Accounts\InterestBearing;
use TalyBank\Accounts\TransactionLogger;

class SavingsAccount extends BankAccount implements InterestBearing
{
    use TransactionLogger;

    // Hằng số: lãi suất mặc định 5%
    private const INTEREST_RATE = 0.05;

    public function deposit(float $amount): void
    {
        $this->balance += $amount;
        $this->logTransaction('Gửi tiền', $amount, $this->balance);
    }

    public function withdraw(float $amount): void
    {
        // Không cho rút nếu rút xong còn dưới 1 triệu
        if ($this->balance - $amount < 1000000) {
            echo "Không thể rút! Số dư sau giao dịch phải ≥ 1.000.000 VNĐ vì bạn đang tiết kiệm mà:((<br>";
            return;
        }

        $this->balance -= $amount;
        $this->logTransaction('Rút tiền', $amount, $this->balance);
    }

    public function getAccountType(): string
    {
        return 'Tiết kiệm';
    }

    public function calculateAnnualInterest(): float
    {
        return $this->balance * self::INTEREST_RATE;
    }
}
