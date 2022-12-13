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
Route::get('/auth/registr', [AuthController::class, 'create']);
Route::post('/auth/registr', [AuthController::class, 'store']);
Route::get('/auth/login', [AuthController::class, 'login'])->name('login');
Route::post('/auth/login', [AuthController::class, 'customLogin']);
Route::get('auth/logout', [AuthController::class, 'logout']);

//Article
Route::get('/', [ArticleController::class, 'index'])->name('main');
Route::resource('article', ArticleController::class)->middleware(['path', 'auth:sanctum']);

//Comment
Route::group(['prefix'=>'comment', 'middleware'=>'auth:sanctum'], function(){
    Route::get('', [CommentController::class,'index'])->name('index');
    Route::post('/{article_id}', [CommentController::class, 'store']);
    Route::get('/{comment}/edit', [CommentController::class, 'edit']);
    Route::put('/{comment}', [commentController::class, 'update']);
    Route::get('/{comment}/delete', [CommentController::class, 'destroy']);
    Route::get('/{comment}/accept', [CommentController::class, 'accept']);
    Route::get('/{comment}/reject', [CommentController::class, 'reject']);
});

// Route::get('/', [MainController::class, 'index']);
Route::get('/main/galery/{full}', [MainController::class, 'show']);

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
