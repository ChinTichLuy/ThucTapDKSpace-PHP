<?php

namespace TalyBank\Accounts;

/**
 * Interface InterestBearing
 * Dùng cho các loại tài khoản có tính lãi (ở đây là SavingsAccount dùng)
 * Interface giúp đảm bảo class nào "implements" nó phải có phương thức tính lãi 
 * (kiểu như hợp đồng, class nào "implements" thì phải có tất cả phương thức nó đã có, đã quy định phải có)
 */
interface InterestBearing
{
    /**
     * Tính lãi suất hàng năm
     * Trả về số tiền lãi được tính ( định dạng kiểu float)
     */
    public function calculateAnnualInterest(): float;
}
