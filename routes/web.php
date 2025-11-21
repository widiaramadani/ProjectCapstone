<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthAdminController;


// Public (user)
Route::get('/', [UserController::class, 'home'])->name('home');
Route::get('/produk', [UserController::class, 'produk'])->name('produk');
Route::get('/kontak', [UserController::class, 'kontak'])->name('kontak');
Route::get('/tentang', [UserController::class, 'tentang'])->name('tentang');


// Admin Auth
// Login admin
Route::get('/loginadmin', [AuthAdminController::class, 'showLogin'])->name('admin.login');
Route::post('/loginadmin', [AuthAdminController::class, 'login'])->name('admin.login.submit');

// Group protected admin
Route::middleware('admin')->group(function () {

    Route::get('/dashboardadmin', function () {
        return view('admin.dashboardadmin');
    })->name('admin.dashboardadmin');

    Route::get('/logoutadmin', [AuthAdminController::class, 'logout'])->name('admin.logout');
});
