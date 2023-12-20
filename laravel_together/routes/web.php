<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\GanttChartController;
use App\Http\Controllers\FriendRequestController;
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
Route::group(['middleware' => ['web']], function () { // web이라는 기본 미들웨어, session 접근 가능
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

// 간트차트
    Route::get('/ganttchart', [GanttChartController::class,'ganttindex'])->name('gantt.index'); // 간트 전체 출력
    // Route::get('/ganttchart', [GanttChartController::class, 'ganttstore'])->name('gantt.store'); // 간트 업무 저장
    Route::patch('/ganttchart', [GanttChartController::class, 'ganttupdate'])->name('gantt.update'); // 간트 업무 수정

// Friend 
Route::get('/friendRequests', [FriendRequestController::class, 'friendRequests']); // 친구요청 받은 목록
Route::get('/friendSendlist', [FriendRequestController::class, 'friendSendlist']); // 친구요청 보낸 목록
Route::get('/myfriendlist', [FriendRequestController::class, 'myfriendList']); // 친구 목록
Route::middleware('auth')->post('/friendsend', [FriendRequestController::class, 'sendFriendRequest'])->name('friend.sendFriendRequest'); // 친구요청
Route::middleware('auth')->patch('/rejectFriendRequest', [FriendRequestController::class, 'rejectFriendRequest']); // 친구요청 거절
Route::middleware('auth')->patch('/acceptFriendRequest', [FriendRequestController::class, 'acceptFriendRequest']); // 친구요청 수락
Route::middleware('auth')->patch('/cancleFriendRequest', [FriendRequestController::class, 'cancleFriendRequest']); // 친구요청 취소
Route::middleware('auth')->delete('/frienddelete', [FriendlistController::class, 'frienddelete']); // 친구 삭제

    // 프로젝트 생성
    Route::get('/create', [ProjectController::class,'tableget'])->name('create.get');
    Route::post('/create', [ProjectController::class,'maincreate'])->name('create.post');

// 프로젝트 개인/팀 화면
Route::get('/individual/{id}', [ProjectController::class,'mainshow'])->name('individual.get');
// Route::post('/individual', [ProjectController::class,'mainpost'])->name('individual.post');
Route::get('/team/{id}', [ProjectController::class,'mainshow'])->name('team.get');


    // 모달
    Route::get('/modaltest', [TaskController::class,'index']);
    Route::get('/detail', function () {
        return view('modal/detail');
    });
    Route::get('/insert', function () {
        return view('modal/insert');
    });
    Route::get('/messenger', function () {
        return view('modal/messenger');
    });
});




