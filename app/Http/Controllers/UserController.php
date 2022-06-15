<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function authen(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required' 
        ]);
        
        if(Auth::attempt($credentials)){
            //     $request->session()->regenerate();
            // dd("login");
            return redirect()->intended("/1_Dashboard");
        }

        return back()->with('LoginError', "Login Gagal Pastikan Email dan Password Benar");

    }
}
