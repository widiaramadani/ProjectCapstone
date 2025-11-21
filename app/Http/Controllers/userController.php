<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;


class UserController extends Controller
{
    public function home()
    {
        return view('welcome');

    }


    public function produk()
    {
        $products = \App\Models\Product::all();
        return view('produk', compact('products'));
    }


    public function kontak()
    {
        return view('kontak');
    }


    public function tentang()
    {
        return view('tentang');
    }
}