<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ArticleController;
use App\Http\Controllers\API\CommentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Auth
Route::get('/auth/registr', [AuthController::class, 'index']);
Route::post('/auth/registr', [AuthController::class, 'store']);
Route::get('/auth/login', [AuthController::class, 'login'])->name('login');
Route::post('/auth/login', [AuthController::class, 'customLogin']);
Route::get('/auth/logout', [AuthController::class, 'logout']);

// Routes for Article
Route::get('/', [ArticleController::class, 'index']);
Route::resource('articles', ArticleController::class)->middleware(['auth:sanctum' , 'schedule']);

// Routes for Comment
Route::group(['prefix' => 'comment', 'middleware'=>'auth:sanctum'], function(){
    Route::get('', [CommentController::class, 'index']);
    Route::post('', [CommentController::class, 'store']);
    Route::get('/{comment}/edit', [CommentController::class, 'edit']);
    Route::get('/{comment}/accept', [CommentController::class, 'accept']);
    Route::get('/{comment}/reject', [CommentController::class, 'reject']);
    Route::put('/{comment}', [CommentController::class, 'update']);
    Route::get('/{comment}/delete', [CommentController::class, 'destroy']);

});

Route::get('/{any}', function($any){
    return redirect('/');
})->where('any', '.*');
