<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [MainController::class, 'index']);
Route::get('/galery/{full}', [MainController::class, 'galery']);
Route::get('/registration', [AuthController::class, 'index']);
Route::post('/signin', [AuthController::class, 'store']);   

Route::get('/about', function () {
    return view('main/about');
});
Route::get('/contact', function () {
    $contact=[
        'name' => 'Политех',
        'adres' => 'Пряники',
        'phone' => '8(495)432-2323',
        'email' => '@polytech.ru'
    ];
    return view('main/contact', ['contact' => $contact]);
});