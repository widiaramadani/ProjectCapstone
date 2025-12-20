<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\DB;


class AdminReportController extends Controller
{
    public function index()
    {
    $reports = Order::select(
    DB::raw('DATE(created_at) as date'),
    DB::raw('COUNT(*) as total_orders'),
    DB::raw('SUM(total_price) as total_revenue')
    )
    ->groupBy('date')
    ->orderBy('date', 'desc')
    ->get();


    return view('admin.report', compact('reports'));
    }
}