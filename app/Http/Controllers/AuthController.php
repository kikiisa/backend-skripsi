<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required|min:5|',
        ],[
            'username.required' => 'Username Wajib Di isi',
            'password.required' => 'Password Wajib Di isi',
            'password.min' => 'Password Minimal 5 karakter',
        ]);
        $credential = $request->only('username','password');
        if(auth()->guard('operator')->attempt($credential)){
            return redirect()->route('dashboard')->with('success','Selamat Datang' . auth()->guard('operator')->user()->name);
        }else{
            return redirect()->back()->with('error','Username Atau Password Anda Salah');
        }
    }

    public function logout()
    {
        Auth::guard('operator')->logout();
        return redirect()->route('auth.login');
    }
}
