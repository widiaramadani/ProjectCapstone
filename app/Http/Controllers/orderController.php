<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Menampilkan semua data order.
     */
    public function index()
    {
        $orders = Order::all();

        return response()->json([
            'status' => true,
            'message' => 'Data order berhasil diambil',
            'data' => $orders
        ], 200);
    }

    /**
     * Menyimpan order baru.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string|max:255',
            'product_name'  => 'required|string|max:255',
            'quantity'      => 'required|integer|min:1',
            'price'         => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $order = Order::create([
                'customer_name' => $request->customer_name,
                'product_name'  => $request->product_name,
                'quantity'      => $request->quantity,
                'price'         => $request->price,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Order berhasil dibuat',
                'data' => $order
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Menampilkan detail order berdasarkan ID.
     */
    public function show($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'status' => false,
                'message' => 'Order tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Detail order ditemukan',
            'data' => $order
        ], 200);
    }

    /**
     * Mengupdate data order.
     */
    public function update(Request $request, $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'status' => false,
                'message' => 'Order tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'customer_name' => 'sometimes|string|max:255',
            'product_name'  => 'sometimes|string|max:255',
            'quantity'      => 'sometimes|integer|min:1',
            'price'         => 'sometimes|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $order->update($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Order berhasil diperbarui',
                'data' => $order
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat update data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Menghapus order berdasarkan ID.
     */
    public function destroy($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'status' => false,
                'message' => 'Order tidak ditemukan'
            ], 404);
        }

        try {
            $order->delete();

            return response()->json([
                'status' => true,
                'message' => 'Order berhasil dihapus'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat menghapus data',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
