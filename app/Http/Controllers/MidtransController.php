<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;

class MidtransController extends Controller
{
    public function checkout(Request $request)
    {
        Config::$serverKey = config('midtrans.serverKey');
        Config::$isProduction = config('midtrans.isProduction');
        Config::$isSanitized = config('midtrans.isSanitized');
        Config::$is3ds = config('midtrans.is3ds');

        $orderId = 'NOPIA-' . uniqid();

        // Item produk
        $items = [];
        foreach ($request->items as $item) {
            $items[] = [
                'id' => uniqid(),
                'price' => (int) $item['price'],
                'quantity' => (int) $item['quantity'],
                'name' => $item['name']
            ];
        }

        // Tambahkan ongkir sebagai item
        if ($request->ongkir > 0) {
            $items[] = [
                'id' => 'ONGKIR',
                'price' => (int) $request->ongkir,
                'quantity' => 1,
                'name' => 'Ongkos Kirim J&T'
            ];
        }

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $request->total,
            ],
            'item_details' => $items,
            'customer_details' => [
                'first_name' => $request->nama,
                'phone' => $request->telepon,
                'shipping_address' => [
                    'address' => $request->alamat,
                    'city' => $request->kota,
                ]
            ]
        ];

        $snapToken = Snap::getSnapToken($params);

        return response()->json([
            'snap_token' => $snapToken,
            'total' => $request->total
        ]);
    }
}
