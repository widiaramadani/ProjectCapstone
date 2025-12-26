<?php
namespace App\Services;

use Midtrans\Snap;
use Midtrans\Config;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$clientKey = env('MIDTRANS_CLIENT_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION') === 'true';
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

   public function createTransaction($orderId, $totalPrice, $buyerName)
    {
        $params = [
            'transaction_details' => [
                'order_id' => $orderId . '-' . time(),
                'gross_amount' => $totalPrice,
            ],
            'customer_details' => [
                'first_name' => $buyerName,
            ],
        ];

        return Snap::createTransaction($params);
    }
}
