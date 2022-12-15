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
Route::get('/auth/registr', [AuthController::class, 'create']);
Route::post('/auth/registr', [AuthController::class, 'store']);
Route::get('/auth/login', [AuthController::class, 'login'])->name('login');
Route::post('/auth/login', [AuthController::class, 'customLogin']);
Route::get('auth/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
