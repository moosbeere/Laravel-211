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

Route::get('/about', function () {
    return view('main/about');
});

Route::get('/contact', function () {
    return view('main/adress');
});

Route::get('/', [ArticleController::class, 'index']);

// Route::group(['prefix' => '/article'], function(){
//     Route::get('create', [ArticleController::class, 'create']);
//     Route::post('store', [ArticleController::class, 'store']);
//     Route::get('show/{id}', [ArticleController::class, 'show']);
//     Route::get('edit/{id}', [ArticleController::class, 'edit']);
//     Route::post('update/{id}', [ArticleController::class, 'update']);
//     Route::get('destroy/{id}', [ArticleController::class, 'destroy']);
// });
Route::post('/comment/{id}', [CommentController::class, 'store']);
Route::get('/comment/{id}', [CommentController::class, 'edit']);
Route::put('/comment/{id}', [CommentController::class, 'update']);
Route::resource('/article', ArticleController::class);


// Route::get('/', [MainController::class, 'index']);
Route::get('/galery/{full}', [MainController::class, 'show']);
Route::get('/view', [AuthController::class, 'view']);
Route::post('/signin', [AuthController::class, 'signin']);
