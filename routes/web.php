<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
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

Route::get('/about', function () {
    return view('main/about');
});

Route::get('/contact', function () {
    return view('main/adress');
});

Route::get('/', function(){
    return redirect('/article');
});

Route::group(['prefix' => '/article'], function(){
    Route::get('', [ArticleController::class, 'index']);
});

// Route::get('/', [MainController::class, 'index']);
Route::get('/galery/{full}', [MainController::class, 'show']);
Route::get('/view', [AuthController::class, 'view']);
Route::post('/signin', [AuthController::class, 'signin']);
