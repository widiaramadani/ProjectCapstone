<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminReportController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\admin\AdminInboxController;
use App\Http\Controllers\MidtransController;


/*
|--------------------------------------------------------------------------
| PUBLIC (USER)
|--------------------------------------------------------------------------
*/
Route::get('/', [UserController::class, 'home'])->name('home');
Route::get('/produk', [UserController::class, 'produk'])->name('produk');
Route::get('/kontak', [UserController::class, 'kontak'])->name('kontak');
Route::get('/tentang', [UserController::class, 'tentang'])->name('tentang');

/* CONTACT */
Route::post('/contact/send', [ContactController::class, 'store'])
    ->name('contact.send');

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::get('/admin/login', function () {
    return view('admin.auth.login');
})->name('admin.login');

Route::post('/admin/login', [AuthenticatedSessionController::class, 'store'])
    ->name('admin.login.store');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])
        ->name('dashboard');

    Route::resource('/products', AdminProductController::class);

    Route::get('/reports', [AdminReportController::class, 'index'])
        ->name('reports');

    Route::get('/orders', [AdminOrderController::class, 'index'])
        ->name('orders.index');

    Route::get('/orders/{id}', [AdminOrderController::class, 'show'])
        ->name('orders.show');

            Route::put('/orders/{id}/acc', [AdminOrderController::class, 'acc'])
        ->name('orders.acc');

    Route::put('/orders/{id}/reject', [AdminOrderController::class, 'reject'])
        ->name('orders.reject');

    /* INBOX */
    Route::get('/inbox', [AdminInboxController::class, 'index'])
        ->name('inbox.index');

    Route::get('/inbox/{message}', [AdminInboxController::class, 'show'])
        ->name('inbox.show');

    Route::delete('/inbox/{message}', [AdminInboxController::class, 'destroy'])
        ->name('inbox.destroy');
});

Route::post('/checkout-midtrans', [MidtransController::class, 'checkoutMidtrans']);
Route::post('/midtrans/callback', [MidtransController::class, 'callback']);

