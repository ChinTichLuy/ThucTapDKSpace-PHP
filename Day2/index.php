<?php

$users = [
    1 => ['name' => 'Alice', 'referrer_id' => null],
    2 => ['name' => 'Bob', 'referrer_id' => 1],
    3 => ['name' => 'Charlie', 'referrer_id' => 2],
    4 => ['name' => 'David', 'referrer_id' => 3],
    5 => ['name' => 'Eva', 'referrer_id' => 1],
];

$orders = [
    ['order_id' => 101, 'user_id' => 4, 'amount' => 200.0],
    ['order_id' => 102, 'user_id' => 3, 'amount' => 150.0],
    ['order_id' => 103, 'user_id' => 5, 'amount' => 300.0],
];

$commissionRates = [
    1 => 0.10,  // cấp 1: 10%
    2 => 0.05,  // cấp 2: 5%
    3 => 0.02,  // cấp 3: 2%
];

function getReferrers(int $userId, array $users, int $maxLevel = 3): array
{
    // Mảng kết quả để lưu danh sách người giới thiệu theo từng cấp
    $referrers = [];
    $userId = 3;
    /*  Hàm đệ quy nội bộ để tìm người giới thiệu của người hiện tại */
    // use (...)	Giúp hàm ẩn danh truy cập các biến bên ngoài hàm.
    // Dùng dấu & để truyền theo tham chiếu, để chính nó có thể gọi lại (đệ quy).
    $findReferrer = function ($currentUserId, $level) use (&$findReferrer, $users, &$referrers, $maxLevel) {
        // Điều kiện dừng:
        // - Nếu vượt quá cấp tối đa cho phép
        // - Hoặc người hiện tại không có referrer_id (tức là không ai giới thiệu họ)
        if ($level > $maxLevel || empty($users[$currentUserId]['referrer_id'])) {
            return;
        }

        // Lấy ID người giới thiệu cấp hiện tại
        $referrerId = $users[$currentUserId]['referrer_id'];

        // Lưu referrer vào mảng kết quả, key là $level ( [1] => 3 )
        $referrers[$level] = $referrerId;

        // Gọi lại chính hàm này để tìm người giới thiệu cấp tiếp theo
        $findReferrer($referrerId, $level + 1);
    };

    // Bắt đầu tìm từ user ban đầu (level 1)
    $findReferrer($userId, 1);

    // Trả về mảng các referrer theo cấp
    return $referrers;
}

// $referrers = getReferrers(4, $users);
// echo "<pre>";
// print_r($referrers);
// echo "</pre>";

function calculateCommissionForOrder(array $order, array $users, array $commissionRates): array
{
    $commissions = [];

    // Danh sách referrers cấp 1 -> 3
    $referrers = getReferrers($order['user_id'], $users);

    foreach ($referrers as $level => $referrerId) {
        // Lấy tỉ lệ theo cấp, nếu không có thì bỏ qua
        $rate = $commissionRates[$level] ?? 0;
        // echo $rate . "<br>";

        // Tính tiền hoa hồng
        $commissionAmount = $order['amount'] * $rate;

        // Thêm thông tin hoa hồng vào mảng
        $commissions[] = [
            'referrer_id' => $referrerId,
            'amount' => $commissionAmount,
            'order_id' => $order['order_id'],
            'buyer_id' => $order['user_id'],
            'level' => $level
        ];
    }

    return $commissions;
}

// $order = ['order_id' => 101, 'user_id' => 4, 'amount' => 200.0];
// $commissions = calculateCommissionForOrder($order, $users, $commissionRates);
// echo "<pre>";
// print_r($commissions);
// echo "</pre>";


function calculateCommission(array $orders, array $users, array $commissionRates): array
{
    $report = [];

    foreach ($orders as $order) {

        $commissions = calculateCommissionForOrder($order, $users, $commissionRates);

        foreach ($commissions as $commission) {
            $referrerId = $commission['referrer_id'];

            if (!isset($report[$referrerId])) {
                $report[$referrerId] = [
                    'total' => 0,
                    'details' => []
                ];
            }

            // Cộng dồn tổng hoa hồng
            $report[$referrerId]['total'] += $commission['amount'];

            // Thêm chi tiết hoa hồng
            $report[$referrerId]['details'][] = [
                'order_id' => $order['order_id'],
                'amount' => $commission['amount'],
                'level' => $commission['level'],
                'from_user_id' => $order['user_id'],
            ];
        }
    }

    // echo "<pre>";
    // print_r($report);
    // echo "</pre>";

    return $report;
}


function printCommissionReport(array $report, array $users): void
{
    foreach ($report as $userId => $data) {
        $userName = $users[$userId]['name'] ?? 'Không có dữ liệu';

        echo "{$userName} (ID: {$userId}) - Tổng hoa hồng: " . number_format($data['total'], 2) . " VND<br>";

        foreach ($data['details'] as $detail) {
            $buyerId = $detail['from_user_id'];
            $buyerName = $users[$buyerId]['name'] ?? 'Không có dữ liệu';

            echo "Đơn hàng {$detail['order_id']} | Người mua: {$buyerName} (ID: {$buyerId}) | ";
            echo "Cấp: {$detail['level']} | Hoa hồng: " . number_format($detail['amount'], 2) . " VND<br>";
        }
        echo str_repeat("-", 60) . "<br>";

        echo "<br>";
    }
}

$finalReport = calculateCommission($orders, $users, $commissionRates);
printCommissionReport($finalReport, $users);
