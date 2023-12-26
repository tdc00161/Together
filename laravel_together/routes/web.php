<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\GanttChartController;
use App\Http\Controllers\FriendRequestController;
use App\Http\Controllers\FriendlistController;
use App\Models\User;


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

Route::get('/', function () {
    return redirect("/user/login");
});

// 로그인
Route::get('/user/login', [UserController::class, 'loginget'])->name('user.login.get'); // 로그인 화면 이동
Route::middleware('my.user.validation')->post('/user/login', [UserController::class, 'loginpost'])->name('user.login.post'); // 로그인 처리
Route::get('/user/registration', [UserController::class, 'registrationget'])->name('user.registration.get'); // 회원가입 화면 이동
Route::middleware('my.user.validation')->post('/user/registration', [UserController::class, 'registrationpost'])->name('user.registration.post'); // 회원가입 처리
Route::get('/user/logout', [UserController::class, 'logoutget'])->name('user.logout.get'); // 로그아웃 처리

// 헤더
Route::get('/header', [TaskController::class,'showheader']);

// 대시보드
Route::get('/dashboard', [TaskController::class,'showdashboard'])->name('dashboard.show');
Route::get('/dashboard-chart', [TaskController::class, 'board_graph_data']); // 그래프 데이터 추출


// 간트차트
Route::get('/ganttchart', [GanttChartController::class, 'ganttIndex'])->name('ganttall.index'); // 간트 전체 출력
Route::get('/ganttchart/{id}', [GanttChartController::class, 'ganttIndex_one'])->name('gantt.index'); // 간트 개인 출력
// Route::post('/ganttchart', [GanttChartController::class, 'ganttstore'])->name('gantt.store'); // 간트 업무 저장
// Route::put('/ganttchartRequest', [TaskController::class, 'update'])->name('gantt.update'); // 간트 업무 수정

// Friend
Route::get('/friendRequests', [FriendRequestController::class, 'friendRequests']); // 친구요청 받은 목록
Route::get('/friendSendlist', [FriendRequestController::class, 'friendSendlist']); // 친구요청 보낸 목록
Route::middleware('auth')->post('/friendsend', [FriendRequestController::class, 'sendFriendRequest'])->name('friend.sendFriendRequest'); // 친구요청
Route::middleware('auth')->patch('/rejectFriendRequest', [FriendRequestController::class, 'rejectFriendRequest']); // 친구요청 거절
Route::middleware('auth')->patch('/acceptFriendRequest', [FriendRequestController::class, 'acceptFriendRequest']); // 친구요청 수락
Route::middleware('auth')->patch('/cancleFriendRequest', [FriendRequestController::class, 'cancleFriendRequest']); // 친구요청 취소
Route::get('/myfriendlist', [FriendlistController::class, 'myfriendList']); // 친구 목록
Route::delete('/friendDelete', [FriendlistController::class, 'deleteFriend']); // 친구 삭제
Route::get('/viewfriendDelete', [FriendlistController::class, 'frienddelete']); // 친구 삭제
// 프로젝트 생성
Route::get('/create', [ProjectController::class,'tableget'])->name('create.get');
Route::post('/create', [ProjectController::class,'maincreate'])->name('create.post');

// 프로젝트 개인/팀 화면
Route::get('/individual/{id}', [ProjectController::class,'mainshow'])->name('individual.get');
Route::get('/team/{id}', [ProjectController::class,'mainshow'])->name('team.get');
Route::get('/chart-data/{id}', [ProjectController::class, 'project_graph_data']); // 프로젝트 그래프 데이터 추출
Route::post('/update/{id}', [ProjectController::class, 'update_project']); // 프로젝트 수정
Route::delete('/delete/{id}', [ProjectController::class, 'delete_project']); // 프로젝트 삭제

// 모달
Route::get('/modaltest', [TaskController::class,'index']);
Route::get('/modaltest2/{id}', [TaskController::class,'index_one']);
Route::get('/detail', function () {
    return view('modal/detail');
});
Route::get('/insert', function () {
    return view('modal/insert');
});
Route::get('/messenger', function () {
    return view('modal/messenger');
});

Route::group(['middleware' => ['web']], function () { // web이라는 기본 미들웨어, session 접근 가능
});




