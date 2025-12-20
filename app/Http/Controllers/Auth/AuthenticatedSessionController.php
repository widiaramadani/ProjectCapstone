<?php


namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthenticatedSessionController extends Controller
{
/**
* Proses login admin
*/
public function store(Request $request)
{
$credentials = $request->validate([
'email' => ['required', 'email'],
'password' => ['required'],
]);


// Coba login
if (!Auth::attempt($credentials)) {
return back()->with('status', 'Email atau password salah');
}


// Cek role admin
if (Auth::user()->role !== 'admin') {
Auth::logout();
return back()->with('status', 'Akun ini bukan admin');
}


// Regenerasi session
$request->session()->regenerate();


return redirect()->route('admin.dashboard');
}


/**
* Logout admin
*/
public function destroy(Request $request)
{
Auth::logout();


$request->session()->invalidate();
$request->session()->regenerateToken();


return redirect()->route('admin.login');
}
}