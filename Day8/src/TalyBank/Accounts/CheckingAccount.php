<?php

namespace TalyBank\Accounts;

use TalyBank\Accounts\BankAccount;
use TalyBank\Accounts\TransactionLogger;

class CheckingAccount extends BankAccount
{
    use TransactionLogger;

    public function deposit(float $amount): void
    {
        $this->balance += $amount;
        $this->logTransaction('Nhận tiền', $amount, $this->balance);
    }

    public function withdraw(float $amount): void
    {
        if ($amount > $this->balance) {
            echo "Không đủ số dư để rút<br>";
            return;
        }

        $this->balance -= $amount;
        $this->logTransaction('Rút tiền', $amount, $this->balance);
    }

    public function getAccountType(): string
    {
        return 'Thanh toán';
    }
}
