<?php

namespace app\Http\Controllers\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validasi permintaan
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Ambil kredensial
        $credentials = $request->only('email', 'password');

        // Coba untuk login pengguna
        if (Auth::attempt($credentials)) {
            // Login berhasil, redirect ke halaman yang dimaksud
            return redirect()->intended('dashboard');
        }

        // Jika otentikasi gagal
        return back()->withErrors([
            'email' => 'Kredensial yang diberikan tidak cocok dengan catatan kami.',
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/'); // Redirect ke halaman utama atau halaman login
    }
}

