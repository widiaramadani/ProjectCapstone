<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;


class OrderAdminController extends Controller
{
        public function index()
    {
        $orders = Order::orderBy('created_at','desc')->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }


    public function show($id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }


    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = $request->input('status','pending');
        $order->save();
        return redirect()->back()->with('success','Status pesanan diperbarui.');
    }
}