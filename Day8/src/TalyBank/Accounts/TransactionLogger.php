<?php

namespace TalyBank\Accounts;

/**
 * Trait TransactionLogger
 * Dùng để log lại các giao dịch gửi tiền hoặc rút tiền
 * Có thể tái sử dụng trong nhiều class
 * Các lớp tài khoản sẽ sử dụng lại trait này
 */
trait TransactionLogger
{
    /**
     * Ghi log giao dịch ra màn hình.
     *
     * @param string $type  Loại giao dịch ("Gửi tiền", "Rút tiền")
     * @param float  $amount Số tiền giao dịch
     * @param float  $newBalance Số dư sau giao dịch
     */
    public function logTransaction(string $type, float $amount, float $newBalance): void
    {
        // Lấy thời gian hiện tại
        $timestamp = date('Y-m-d H:i:s');

        // Ghi log ra màn hình
        echo "[{$timestamp}] Giao dịch: {$type} " . number_format($amount, 0, ',', '.') . " VNĐ | Số dư mới: " . number_format($newBalance, 0, ',', '.') . " VNĐ<br>";
    }
}
