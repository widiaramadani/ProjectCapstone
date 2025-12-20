<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'kode' => 'required',
        'nama_produk' => 'required',
        'category_id' => 'required',
        'harga' => 'required|numeric',
        'stok' => 'required|numeric',
        'satuan' => 'required',
    ]);

    // Upload Gambar
    $namaGambar = null;
    if ($request->hasFile('gambar')) {
        $namaGambar = time() . '.' . $request->gambar->extension();
        $request->gambar->storeAs('public/uploads/produk', $namaGambar);
    }

    \App\Models\Product::create([
        'kode' => $request->kode,
        'nama_produk' => $request->nama_produk,
        'category_id' => $request->category_id,  // FIX
        'harga' => $request->harga,
        'stok' => $request->stok,
        'satuan' => $request->satuan,
        'gambar' => $namaGambar,
        'deskripsi' => $request->deskripsi,
    ]);

    return redirect()->route('admin.produkadmin')
                     ->with('success', 'Produk berhasil ditambahkan!');
}

}
