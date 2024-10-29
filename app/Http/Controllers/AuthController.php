<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login.index', [
            'title'   => 'Login'
        ]);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        // cek username dan password
        if (Auth::attempt($credentials)) {
            // input data user ke dalam session
            $request->session()->regenerate();

            Alert::success('Berhasil', 'Login Berhasil!');
            return redirect()->intended('dashboard');
        }

        // kirim pesan flash gagal
        Alert::error('Gagal', 'Username atau Password salah!');
        return redirect()->back();
    }

    public function actionLogout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        Alert::success('Berhasil', 'Anda Berhasil Keluar');
        return redirect('/login');
    }
}
