<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;

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

Route::get('/auth/registr', [AuthController::class, 'index']);
Route::post('/auth/registr', [AuthController::class, 'store']);
Route::get('/auth/login', [AuthController::class, 'login'])->name('login');
Route::post('/auth/login', [AuthController::class, 'customLogin']);

Route::get('/', [ArticleController::class, 'index']);
Route::resource('/article', ArticleController::class);

Route::group(['prefix' => '/comment'], function(){
    Route::post('/{id}', [CommentController::class, 'store']);
    Route::get('/{id}', [CommentController::class, 'edit']);
    Route::put('/{id}', [CommentController::class, 'update']);
    Route::get('/{comment}/delete', [CommentController::class, 'destroy']);
});


// Route::group(['prefix' => '/article'], function(){
//     Route::get('create', [ArticleController::class, 'create']);
//     Route::post('store', [ArticleController::class, 'store']);
//     Route::get('show/{id}', [ArticleController::class, 'show']);
//     Route::get('edit/{id}', [ArticleController::class, 'edit']);
//     Route::post('update/{id}', [ArticleController::class, 'update']);
//     Route::get('destroy/{id}', [ArticleController::class, 'destroy']);
// });
// Route::get('/', [MainController::class, 'index']);
Route::get('/galery/{full}', [MainController::class, 'show']);
Route::get('/about', function () {
    return view('main/about');
});

Route::get('/contact', function () {
    return view('main/adress');
});



