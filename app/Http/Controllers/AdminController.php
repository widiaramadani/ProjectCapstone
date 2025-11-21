<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;


class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboardadmin');
    }


    public function produk()
    {
        $products = \App\Models\Product::paginate(10);
        return view('admin.produkadmin', compact('products'));
    }


    public function transaksi()
    {
        return view('admin.transaksiadmin');
    }


    public function laporan()
    {
    return view('admin.laporanadmin');
    }
}