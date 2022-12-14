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
Route::get('/registration', [AuthController::class, 'index']);
Route::post('/registration', [AuthController::class, 'store']);
Route::get('/signin', [AuthController::class, 'login'])->name('login');
Route::post('/signin', [AuthController::class, 'customLogin']);
Route::get('/signout', [AuthController::class, 'signout'])->middleware('auth:sanctum');

Route::get('/', [ArticleController::class, 'index']);

//Article
Route::group(['prefix' => '/article', 'middleware'=>['auth:sanctum','task']], function(){
    Route::get('/create', [ArticleController::class, 'create']);
    Route::post('/store', [ArticleController::class, 'store']);
    Route::get('/show/{id}', [ArticleController::class, 'show']);
    Route::get('/edit/{id}', [ArticleController::class, 'edit']);
    Route::post('/update/{id}', [ArticleController::class, 'update']);
    Route::get('/destroy/{id}', [ArticleController::class, 'destroy']);
});

//Comment
Route::resource('comment', CommentController::class)->middleware('auth:sanctum');
Route::get('/comment/{comment}/accept', [CommentController::class, 'accept']);
Route::get('/comment/{comment}/reject', [CommentController::class, 'reject']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
