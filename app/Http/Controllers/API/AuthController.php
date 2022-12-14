<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;


class AuthController extends Controller
{
    public function index(){
        // return view('auth/registration');
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'email' =>'required|email|unique:App\Models\User',
            'password' =>'required|min:6',
        ]);

        $user = new User();
        $user->name = request('name');
        $user->email = request('email');
        $user->password = Hash::make(request('password'));
        $user->role_id = 2;
        $user->save();
        $user->createToken('myapptoken')->plainTextToken;
        return response()->json($user);
    }

    public function login(){
        // return view('auth.signin');
    }

    public function customLogin(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        $credentials = $request->only('email', 'password');

        if(Auth::attempt($credentials)){
            $user = User::where('email', request('email'))->first();
            $token = $user->createToken('myAppToken');
            return response($token);
        }
        return response('Bad login', 401);       

    }

    public function signout(Request $request){
        auth()->user()->tokens()->delete();
        return response('Logout');
    }
}
