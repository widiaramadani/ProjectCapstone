<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;   // ✔ BENAR



class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboardadmin');
    }


    //produk
    public function produk()
    {
        $produk = \App\Models\Product::paginate(10);
        $kategori = \App\Models\Category::all(); // ← Tambahkan ini
        return view('admin.produkadmin', compact('produk', 'kategori'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required',
            'harga' => 'required|numeric',
        ]);

        \App\Models\Product::create([
            'nama_produk' => $request->nama_produk,
            'harga' => $request->harga
        ]);

        return redirect()->route('admin.produk')->with('success', 'Produk berhasil ditambahkan!');
    }
    

    //Transaksi
    public function transaksi()
    {
         $transaksi = DB::table('transaksi')->get();
         return view('admin.transaksiadmin', compact('transaksi'));
    }


    public function laporan()
    {
    return view('admin.laporanadmin');
    }
}