<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;


class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
        'totalOrders' => Order::count(),
        'totalRevenue' => Order::sum('total_price'),
        'totalProducts'=> Product::count(),
        'latestOrders' => Order::latest()->limit(5)->get(),
        ]);
    }
}