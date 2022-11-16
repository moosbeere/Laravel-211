<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function index(){
        return view('auth.registr');
    }

    public function store(Request $request){

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:App\Models\User',
            'password' => 'required|min:6',
        ]);
        $user = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => Hash::make(request('password')),
        ]);

        $user->createToken('myAppToken');
        return redirect()->route('login');
        // $name = $request->name;
        // $email = $request->email;

        // $response = [
        //     'name' => 'rtrtrt',
        //     'email' => 'dgdgg',
        // ];
        // return response()->json($response);
    }

    public function login(){
        return view('auth.login');
    }
    public function customLogin(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
        $credentials=$request->only('email', 'password');
        if(Auth::attempt($credentials)){
            
        }
    }
}
