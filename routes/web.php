<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;
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

//Auth
Route::get('/auth/registr', [AuthController::class, 'index']);
Route::post('/auth/registr', [AuthController::class, 'store']);
Route::get('/auth/login', [AuthController::class, 'login'])->name('login');
Route::post('/auth/login', [AuthController::class, 'customLogin']);
Route::get('/auth/logout', [AuthController::class, 'logout']);



//Routes for Article
Route::get('/', [ArticleController::class, 'index']);
Route::resource('articles', ArticleController::class)->middleware('auth:sanctum');

//Routes for Comment
Route::group(['prefix' => 'comment', 'middleware'=>'auth:sanctum'], function(){
    Route::get('', [CommentController::class, 'index']);
    Route::post('', [CommentController::class, 'store']);
    Route::get('/{comment}/edit', [CommentController::class, 'edit']);
    Route::get('/{comment}/accept', [CommentController::class, 'accept']);
    Route::get('/{comment}/reject', [CommentController::class, 'reject']);
    Route::put('/{comment}', [CommentController::class, 'update']);
    Route::get('/{comment}/delete', [CommentController::class, 'destroy']);

});

// Route::get('/', [MainController::class, 'index']);
Route::get('/galery/{full}', [MainController::class, 'galery']);
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
// Route::get('/', function(){
//     return view('welcome');
// });