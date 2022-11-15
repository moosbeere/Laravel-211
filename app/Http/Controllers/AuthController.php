<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function create(){
        return view('auth.registr');
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' =>'required|min:6',
        ]);
        $result = [
            'name' => request('name'), 
            // 'name' => $request->name,
            'email' => request('email'), 
            'password' => request('password'), 

        ];

        return  response()->json($result);

    }
}
