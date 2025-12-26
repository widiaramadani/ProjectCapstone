<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Midtrans\Snap;
use Midtrans\Config;

class CheckoutController extends Controller
{
public function store(Request $request)
{
    $request->validate([
        'nama' => 'required|string',
        'telepon' => 'required|string',
        'alamat' => 'required|string',
        'kecamatan' => 'required|string',
        'kota' => 'required|string',
        'total' => 'required|numeric',
        'items' => 'required|array|min:1',
    ]);

    DB::beginTransaction();

    try {
        $orderId = DB::table('orders')->insertGetId([
            'buyer_name' => $request->nama,
            'phone' => $request->telepon,
            'address' => $request->alamat . ', ' . $request->kecamatan . ', ' . $request->kota,
            'total_price' => $request->total,
            'payment_status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        foreach ($request->items as $item) {
            DB::table('order_items')->insert([
                'order_id' => $orderId,
                'product_name' => $item['name'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        /* ================= MIDTRANS ================= */
        Config::$serverKey = config('midtrans.serverKey');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $orderMidtransId = 'ORDER-' . $orderId . '-' . time();

        $params = [
            'transaction_details' => [
                'order_id' => $orderMidtransId,
                'gross_amount' => (int)$request->total,
            ],
            'customer_details' => [
                'first_name' => $request->nama,
                'phone' => $request->telepon,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);


        DB::commit();

        return response()->json([
            'success' => true,
            'snap_token' => $snapToken
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}
}