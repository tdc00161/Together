<?php

use App\Http\Controllers\BaseDataController;
use App\Http\Controllers\ProjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CommentController;
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
Route::group(['middleware' => ['web']], function () {

    Route::get('/task', [TaskController::class, 'index']); // 전체 업무 조회
    Route::get('/task/{id}', [TaskController::class, 'view']); // 상세 업무 하나 조회 (연결된 상/하위, 댓글 포함)
    Route::post('/task',[TaskController::class,'store']); // 업무 작성
    Route::put('/task/{id}',[TaskController::class,'update']); // 업무 수정
    Route::delete('/task/{id}',[TaskController::class,'delete']); // 업무 삭제
    
    Route::get('/basedata/{id}', [BaseDataController::class, 'get_priority_list']); // 우선순위 리스트 조회
    
    Route::get('/project/{id}', [ProjectController::class, 'project_select']); // 프로젝트 색상 가져오기
    Route::get('/project/user/{id}', [ProjectController::class, 'project_user_select']); // 프로젝트 참여자 가져오기

    Route::post('/comment/{id}',[CommentController::class,'store']); // 댓글 작성 // id => 업무 id
    Route::put('/comment/{id}',[CommentController::class,'update']); // 댓글 수정 // 댓글 id
    Route::delete('/comment/{id}',[CommentController::class,'delete']); // 댓글 삭제 // 댓글 id

    Route::post('/project/{id}', [ProjectController::class, 'project_graph_data']); // 프로젝트 그래프 데이터 추출
});

// Route::get('/chart-data', [ProjectController::class, 'project_graph_data']); // 프로젝트 그래프 데이터 추출

// Route::get('/gantt', [GanttChartController::class,'ganttindex']);
Route::put('/gantt', [GanttChartController::class, 'ganttUpdate']); // 간트차트 수정
// Route::put('/gantt', [TaskController::class, 'store']); // 간트차트 하위생성후 작성
