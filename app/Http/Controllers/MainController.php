<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index(){
        $result = json_decode(file_get_contents(public_path().'/articles.json'), true);
        return view('main.hello', ['results' => $result]);
    }
}
