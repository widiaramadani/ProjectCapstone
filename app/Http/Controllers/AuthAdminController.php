<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthAdminController extends Controller
{
    public function showLogin()
    {
        return view('admin.loginadmin'); // file login
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        // Contoh saja, kamu bisa ganti pakai database
        $adminEmail = "admin@gmail.com";
        $adminPassword = "admin123";

        if ($request->email === $adminEmail && $request->password === $adminPassword) {

            // Simpan session login admin
            session([
                'admin_logged_in' => true,
                'admin_email' => $request->email
            ]);

            return redirect()->route('admin.dashboardadmin');
        }

        return back()->with('error', 'Email atau password salah.');
    }

    public function logout()
    {
    session()->forget('admin_logged_in');
    session()->forget('admin_email');

    return redirect()->route('admin.login');
    }
}
