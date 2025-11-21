<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'total_produk'   => DB::table('produk')->count(),
            'total_po'       => DB::table('purchase_order')->count(),
            'total_customer' => DB::table('customer')->count(),
            'total_admin'    => DB::table('admin')->where('status', 'active')->count(),

            'produk_list' => DB::table('produk')
                ->select('id','kode','nama_produk','harga')
                ->orderBy('id', 'DESC')
                ->limit(5)
                ->get(),

            'admin_list' => DB::table('admin')
                ->where('status', 'active')
                ->orderBy('id','DESC')
                ->get(),
        ]);
    }
}
