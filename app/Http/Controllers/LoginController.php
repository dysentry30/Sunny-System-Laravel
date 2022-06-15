<?php

namespace App\Http\Controllers;

use App\Models\Logins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function auth(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required' 
        ]);
        
        if(Auth::attempt([$credentials])){
            $request->session()->regenerate();
            return redirect()->intended("/1_Dashboard");
        }

        return back()->with('LoginError', "Login Gagal Pastikan Email dan Password Benar");

        dd("login");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Logins  $logins
     * @return \Illuminate\Http\Response
     */
    public function show(Logins $logins)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Logins  $logins
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Logins $logins)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Logins  $logins
     * @return \Illuminate\Http\Response
     */
    public function destroy(Logins $logins)
    {
        //
    }
}
