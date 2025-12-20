<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;


    class AdminProductController extends Controller
    {
    public function index()
    {
    $products = Product::latest()->get();
    return view('admin.products.index', compact('products'));
    }


    public function create()
    {
    return view('admin.products.create');
    }


    public function store(Request $request)
    {
    $request->validate([
    'name' => 'required',
    'price' => 'required|numeric',
    'stock' => 'required|numeric',
    ]);


    Product::create($request->all());


    return redirect()->route('admin.products.index')
    ->with('success', 'Produk berhasil ditambahkan');
    }


    public function edit(Product $product)
    {
    return view('admin.products.edit', compact('product'));
    }


    public function update(Request $request, Product $product)
    {
    $request->validate([
    'name' => 'required',
    'price' => 'required|numeric',
    'stock' => 'required|numeric',
    ]);


    $product->update($request->all());


    return redirect()->route('admin.products.index')
    ->with('success', 'Produk berhasil diperbarui');
    }


    public function destroy(Product $product)
    {
    $product->delete();


    return redirect()->route('admin.products.index')
    ->with('success', 'Produk berhasil dihapus');
    }
}