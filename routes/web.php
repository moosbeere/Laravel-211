<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;

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

Route::get('/', [ArticleController::class, 'index']);
Route::resource('article', ArticleController::class);

// Route::get('/', [MainController::class, 'index']);
Route::get('/main/galery/{full}', [MainController::class, 'show']);
Route::get('/auth/registr', [AuthController::class, 'create']);
Route::post('/auth/store', [AuthController::class, 'store']);

Route::get('/about', function () {
    return view('main.about');
});

Route::get('/contact', function(){
    $contact = [
        'name' => 'Политех',
        'adres' => 'Пряники',
        'phone' => '8(495)433-2323',
        'email' => '@polytech.ru'
    ];
    return view('main.contact', ['contact' => $contact]);

});
