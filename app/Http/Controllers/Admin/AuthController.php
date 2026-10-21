<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (session('admin_logged_in')) {
            return redirect()->route('admin.news.index');
        }
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($request->email === 'admin@makben.co.id' && $request->password === 'password123') {
            session([
                'admin_logged_in' => true,
                'admin_email' => $request->email,
                'admin_name' => 'Administrator MBE'
            ]);
            return redirect()->route('admin.news.index')->with('success', 'Selamat datang di CMS Admin PT Makmur Bersama Enjiniring!');
        }

        return redirect()->back()->withErrors(['email' => 'Email atau password salah!'])->withInput();
    }

    public function logout()
    {
        session()->forget(['admin_logged_in', 'admin_email', 'admin_name']);
        return redirect()->route('admin.login')->with('success', 'Anda telah berhasil logout.');
    }
}
