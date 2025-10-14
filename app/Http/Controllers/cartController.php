<?php


namespace App\Http\Controllers;


use App\Models\Product;
use Illuminate\Http\Request;


class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $items = [];
        $total = 0;
        foreach ($cart as $id => $qty) {
            $p = Product::find($id);
            if (!$p) continue;
            $items[] = ['product'=>$p,'quantity'=>$qty,'subtotal'=>$p->price*$qty];
            $total += $p->price*$qty;
        }
        return view('cart.index', compact('items','total'));
    }


    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);
        $cart[$id] = ($cart[$id] ?? 0) + max(1, (int)$request->input('quantity',1));
        session()->put('cart', $cart);
        return redirect()->back()->with('success','Produk berhasil ditambahkan ke keranjang.');
    }


    public function update(Request $request, $id)
    {
        $qty = max(1, (int)$request->input('quantity',1));
            $cart = session()->get('cart', []);
            if (isset($cart[$id])) {
            $cart[$id] = $qty;
            session()->put('cart', $cart);
        }
        return redirect()->route('cart.index');
    }


    public function remove($id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->route('cart.index');
    }
}