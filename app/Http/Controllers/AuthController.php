<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function create(){
        return view('auth.registr');
    }

    public function store(Request $request){

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:App\Models\User',
            'password' =>'required|min:6',
        ]);

        User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => Hash::make(request('password')),
        ]);

        return  redirect()->route('login');
    }

    public function login(){
        return view('auth.login');
    }

    public function customLogin(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' =>'required|min:6',
        ]);

        $credentials = [
            'email' => request('email'),
            'password' => request('password'),
        ];

        if (Auth::attempt($credentials)){
            $request->session()->regenerate();
            Auth::user()->createToken('myAppToken');
            return redirect()->intended('/');
        } else return back()->withErrors('error for email');
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
