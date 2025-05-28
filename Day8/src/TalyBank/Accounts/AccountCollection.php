<?php

namespace TalyBank\Accounts;

/** IteratorAggregate
 * là một interface có sẵn trong PHP    
 * bắt buộc phải định nghĩa một phương thức getIterator()
 * sử dụng các tính năng liên quan đến việc lặp (iterating) qua các phần tử trong một đối tượng.
 */
/** ArrayIterator	
 * là một class có sẵn của PHP, đại diện cho một iterator cho mảng (array)
 * dùng để trả về từ getIterator()
 */
use IteratorAggregate;
use ArrayIterator;

// Quản lý danh sách tài khoản
class AccountCollection implements IteratorAggregate
{
    // Mảng chứa các tài khoản
    private array $accounts = [];

    //Thêm tài khoản mới vào danh sách
    public function addAccount(BankAccount $account): void
    {
        $this->accounts[] = $account;
    }

    // Trả về iterator để foreach hoạt động
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->accounts);
    }

    /**
     * Lọc các tài khoản có số dư >= 10.000.000 VNĐ
     * @return BankAccount[]
     */
    public function filterHighBalanceAccounts(): array
    {
        return array_filter($this->accounts, function (BankAccount $account) {
            return $account->getBalance() >= 10000000;
        });
    }
}
