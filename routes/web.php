<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\ProductAdminController;
use App\Http\Controllers\Admin\OrderAdminController;


Route::get('/', [ProductController::class,'index'])->name('home');
Route::get('/products', [ProductController::class,'index'])->name('products.index');
Route::get('/product/{slug}', [ProductController::class,'show'])->name('products.show');


// Cart
Route::get('/cart', [CartController::class,'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class,'add'])->name('cart.add');
Route::post('/cart/update/{id}', [CartController::class,'update'])->name('cart.update');
Route::get('/cart/remove/{id}', [CartController::class,'remove'])->name('cart.remove');


// Checkout
Route::get('/checkout', [OrderController::class,'checkoutForm'])->name('checkout.form');
Route::post('/checkout', [OrderController::class,'placeOrder'])->name('checkout.place');
Route::get('/checkout/thankyou/{id}', [OrderController::class,'thankyou'])->name('checkout.thankyou');


// Admin (simple, no auth scaffold included here)
Route::prefix('admin')->group(function (){
Route::get('/products', [ProductAdminController::class,'index'])->name('admin.products.index');
Route::get('/orders', [OrderAdminController::class,'index'])->name('admin.orders.index');
});