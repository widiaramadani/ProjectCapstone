<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;

class AdminOrderController extends Controller
{
    /**
     * Menampilkan semua pembelian
     */
    public function index()
    {
        $orders = Order::latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Detail pembelian
     */
    public function show($id)
    {
        $order = Order::with('items')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }
    public function acc($id)
{
    $order = Order::findOrFail($id);
    $order->status = 'acc';
    $order->save();

    return back()->with('success', 'Pesanan berhasil di ACC');
}

public function reject($id)
{
    $order = Order::findOrFail($id);
    $order->status = 'ditolak';
    $order->save();

    return back()->with('success', 'Pesanan ditolak');
}

}
