<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'phone' => 'nullable|string|max:30',
            'subject' => 'nullable|string|max:200',
            'message' => 'required|string|min:10',
        ]);

        return redirect()->back()->with('success', 'Terima kasih! Pesan Anda telah berhasil terkirim. Tim kami akan segera menghubungi Anda.');
    }
}
