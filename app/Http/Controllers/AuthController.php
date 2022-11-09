<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function view(){
        return view('main.auth');
    }

    public function signin(Request $request){

        // $request->validate([
        //     'name' => 'required',
        //     'email' => 'required|email',
        //     'password' => 'required|min:6',
        // ]);
        // $name = $request->name;
        // $email = $request->email;

        $response = [
            'name' => 'rtrtrt',
            'email' => 'dgdgg',
        ];
        return response()->json($response);
    }
}
