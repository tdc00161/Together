<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/task/{id}', [TestController::class, 'view']);
Route::post('/task/{id}',[TestController::class,'store']); // 작성
Route::put('/task/{id}',[TestController::class,'update']); // 수정
Route::delete('/task/{id}',[TestController::class,'delete']); // 삭제