<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function logout(Request $request)
    {

        return "hu";
        /*Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');*/
    }
}
