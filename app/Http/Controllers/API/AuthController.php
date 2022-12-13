<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function index(){
        // return view('auth.registration');
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:App\Models\User',
            'password' => 'required|min:6',
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $token = $user->createToken('myAppToken')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token
        ];
        return response()->json($response);
    }

    public function login(){
        // return response(201);
    }

    public function customLogin(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = [
            'email' => request('email'),
            'password' => request('password'),
        ];
        if (!Auth::attempt($credentials)){
                return response('Bad login', 401);
        }
        $user = User::where('email', request('email'))->first();
        $token = $user->createToken('myAppToken')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token
        ];
        return response($response, 201);
    }

    public function logout(Request $request){
        Auth::logout();
        return response([
            'message' => 'Logged out'
            ], 201);
    }
}
