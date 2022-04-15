<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

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

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::get('blogs', [BlogController::class,'index']);
Route::get('blogs/{id}', [BlogController::class,'show']);

Route::middleware('auth_user')->group( function () {

    Route::post('blogs', [BlogController::class,'store']);
    Route::put('blogs/{id}', [BlogController::class,'update']);
    Route::delete('blogs/{id}', [BlogController::class,'destroy']);

    Route::get('blogs/{id}/comments', [CommentController::class, 'index']);
    Route::post('blogs/comments', [CommentController::class, 'store']);
    Route::put('blogs/comments/{id}', [CommentController::class, 'update']);
    Route::delete('blogs/comments/{id}', [CommentController::class, 'destroy']);

});

Route::fallback(function (){
   return \App\Helpers\ResponseHelper::fail('Not found', 404);
});
