<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function LoginPage()
    {
        return view('admin.auth.login');
    }

    public function Login(Request $request)
    {
        $request->validate([
            'email'=>'required|email|max:255|exists:users,email',
            'password'=>'required',
        ],[
            'email.exists'=>'Email does not exists'
        ]);

        $credentials = $request->only(['email','password']);

        if (Auth::attempt($credentials,true))
        {
            return redirect()->route('admin::dashboard');
        }

        return redirect()->back()->withErrors([
            'password is wrong'
        ]);
    }

    public function Logout()
    {
        Auth::logout();
        return redirect()->route('admin::login');
    }
}
