<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        // 1. VALIDASI DI AWAL
        $request->validate([
            'nama' => 'required|string',
            'telepon' => 'required|string',
            'alamat' => 'required|string',
            'kecamatan' => 'required|string',
            'kota' => 'required|string',
            'total' => 'required|numeric',
            'items' => 'required|array|min:1',
            'items.*.name' => 'required|string',
            'items.*.quantity' => 'required|numeric',
            'items.*.price' => 'required|numeric',
        ]);

        DB::beginTransaction();

        try {
            // 2. SIMPAN ORDER
            $orderId = DB::table('orders')->insertGetId([
                'buyer_name'  => $request->nama,
                'phone'       => $request->telepon,
                'address'     => $request->alamat . ', ' . $request->kecamatan . ', ' . $request->kota,
                'total_price' => $request->total,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);

            // 3. SIMPAN ITEM PESANAN
            foreach ($request->items as $item) {
                DB::table('order_items')->insert([
                    'order_id'     => $orderId,
                    'product_name' => $item['name'],
                    'quantity'     => $item['quantity'],
                    'price'        => $item['price'],
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil disimpan',
                'order_id'=> $orderId
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan pesanan',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
