<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function welcome () 
    {
        return view('0_Welcome');
    }
    
    
    public function authen(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required' 
        ]);
        if(Auth::attempt($credentials) && Auth::check()){
            $request->session()->regenerate();

            // if request from API
            if(str_contains($request->url(), "api")) {
                $user = auth()->user();
                return response()->json([
                    "token" => $user->createToken($user->name)->plainTextToken,
                    "user" => $user,
                ]);
            }

            return redirect()->intended("/dashboard");
        }
        
        // dd("gagal login");
        return back()->with('LoginError', "Login Gagal Pastikan Email dan Password Benar");
    }
    
    public function logout (Request $request)
    {

        Auth::logout();
        
        Request()->session()->invalidate();
        
        Request()->session()->regenerateToken();
        
        if(str_contains($request->url(), "api")) {

            return response()->json([
                "status" => "success",
                "msg" => "Logged out",
            ]); 
        }

        return redirect('/');
    }

    // public function createUser()
    // {
        //     $user = new User;
        //     $user->name = 'admin';
        //     $user->email = 'admin@sunny.com';
        //     $user->password = Hash::make('admin@sunny.com');
        
        //     if ( ! ($user->save()))
        //     {
    //         dd('user is not being saved to database properly - this is the problem');          
    //     }

    //     if ( ! (Hash::check('123456', Hash::make('123456'))))
    //     {
    //         dd('hashing of password is not working correctly - this is the problem');          
    //     }

    //     if ( ! (Auth::attempt(array('email' => 'joe@gmail.com', 'password' => '123456'))))
    //     {
    //         dd('storage of user password is not working correctly - this is the problem');          
    //     }

    //     else
    //     {
    //         dd('everything is working when the correct data is supplied - so the problem is related to your forms and the data being passed to the function');
    //     }
    // }


}
