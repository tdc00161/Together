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

Route::get('/task', [TestController::class, 'index']); // 전체
Route::get('/task/{id}', [TestController::class, 'view']); // 상세
Route::get('/project/{id}', [TestController::class, 'project_color']); // 프로젝트 색상 가져오기
Route::post('/task',[TestController::class,'store']); // 작성
Route::put('/task/{id}',[TestController::class,'update']); // 수정
Route::delete('/task/{id}',[TestController::class,'delete']); // 삭제