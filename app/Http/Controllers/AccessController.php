<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccessController extends Controller
{
    //
    public function form_akses(){
        return view('akses.form');
    }

    public function verify_akses(Request $request)
    {
        $request->validate([
            'kode' => 'required'
        ]);

        // misalnya kode valid adalah '12345' — bisa ambil dari database juga
        if ($request->kode === '12345') {
            session(['akses_token' => true]); // simpan token ke session
            return redirect()->intended('/'); // kembali ke halaman terakhir
        }

        return back()->withErrors(['kode' => 'Kode salah']);
    }
}
