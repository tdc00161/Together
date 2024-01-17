<?php

use App\Http\Controllers\AlarmController;
use App\Http\Controllers\MessengerController;
use App\Http\Middleware\UpdateUserActivity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\GanttChartController;
use App\Http\Controllers\FriendRequestController;
use App\Http\Controllers\FriendlistController;
use App\Http\Controllers\BaseDataController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\InviteController;
use App\Http\Controllers\OnOfflineController;
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
Route::get('/user/login', [UserController::class, 'loginget'])->name('user.login.get'); // 로그인 화면 이동
Route::post('/user/login', [UserController::class, 'loginpost'])->name('user.login.post'); // 로그인 처리
Route::get('/user/registration', [UserController::class, 'registrationget'])->name('user.registration.get'); // 회원가입 화면 이동
Route::middleware('my.user.validation')->post('/user/registration', [UserController::class, 'registrationpost'])->name('user.registration.post'); // 회원가입 처리

Route::middleware('auth')->group(function () {
    Route::middleware(UpdateUserActivity::class)->group(function () {
        Route::get('/dashboard', [TaskController::class,'showdashboard'])->name('dashboard.show');
        Route::get('/ganttchart', [GanttChartController::class, 'ganttIndex'])->name('ganttall.index'); // 간트 전체 출력
        Route::get('/ganttchart/{id}', [GanttChartController::class, 'ganttIndex_one'])->name('gantt.index'); // 간트 개인 출력
        Route::post('/friendsend', [FriendRequestController::class, 'sendFriendRequest'])->name('friend.sendFriendRequest'); // 친구요청
        Route::patch('/rejectFriendRequest', [FriendRequestController::class, 'rejectFriendRequest']); // 친구요청 거절
        Route::patch('/acceptFriendRequest', [FriendRequestController::class, 'acceptFriendRequest']); // 친구요청 수락
        Route::patch('/cancleFriendRequest', [FriendRequestController::class, 'cancleFriendRequest']); // 친구요청 취소
        Route::get('/myfriendlist', [FriendlistController::class, 'myfriendList']); // 친구 목록
        Route::delete('/friendDelete', [FriendlistController::class, 'deleteFriend']); // 친구 삭제
        Route::get('/viewfriendDelete', [FriendlistController::class, 'frienddelete']); // 친구 삭제
        Route::get('/create', [ProjectController::class,'tableget'])->name('create.get'); //프로젝트 생성 페이지
        Route::get('/projectupdate/{id}', [ProjectController::class,'projectUpdateget'])->name('project.updateget'); //프로젝트 수정 페이지
        Route::put('/projectupdateput/{id}', [ProjectController::class,'projectUpdateput'])->name('project.updateput'); //프로젝트 수정 post
        Route::get('/invite/{token}',  [ProjectController::class,'acceptInvite'])->name('invite'); //  초대수락
        Route::put('/ganttchartRequest/{id}', [TaskController::class, 'ganttUpdate']); // 간트차트 수정    
    });
    Route::get('/user/logout', [UserController::class, 'logoutget'])->name('user.logout.get'); // 로그아웃 처리
    Route::get('/sidebar', [TaskController::class,'showSidebar']);
    Route::get('/friendRequests', [FriendRequestController::class, 'friendRequests']); // 친구요청 받은 목록
    Route::get('/friendSendlist', [FriendRequestController::class, 'friendSendlist']); // 친구요청 보낸 목록
    Route::get('/membermodal/{token}',[ProjectController::class,'membermodal'])->name('mbmodal'); // 구성원 중복일 때 알림창
    Route::post('/friendinvite',[ProjectController::class,'friendmember'])->name('fdinvite'); //친구목록 구성원 초대
    Route::post('/create', [ProjectController::class,'maincreate'])->name('create.post'); //프로젝트 생성정보 처리
    Route::get('/individual', [ProjectController::class,'mainindex']); //페이지 비활성화
    Route::get('/individual/{id}', [ProjectController::class,'mainshow'])->name('individual.get'); //개인 프로젝트 출력
    Route::get('/team', [ProjectController::class,'mainindex']); //페이지 비활성화
    Route::get('/team/{id}', [ProjectController::class,'mainshow'])->name('team.get'); //팀 프로젝트 출력
    Route::middleware('auth')->get('/task', [TaskController::class, 'index']); // 전체 업무 조회 / page
});
Route::middleware('auth.api')->group(function () {
    Route::middleware(UpdateUserActivity::class)->group(function () {
        Route::post('/update/{id}', [ProjectController::class, 'update_project']); // 프로젝트 수정
        Route::delete('/projectDelete/{id}', [ProjectController::class, 'delete_project']); // 프로젝트 삭제
        Route::delete('/projectExit/{id}', [ProjectController::class,'exit_project']); // 방나가기
        Route::get('/task/{id}', [TaskController::class, 'view']); // 상세 업무 하나 조회 (연결된 상/하위, 댓글 포함) / api
        Route::post('/task',[TaskController::class,'store']); // 업무 작성 / api
        Route::put('/task/{id}',[TaskController::class,'update']); // 업무 수정 / api
        Route::delete('/task/{id}',[TaskController::class,'delete']); // 업무 삭제 / api
        Route::post('/comment/{id}',[CommentController::class,'store']); // 댓글 작성 // id => 업무 id / api
        Route::put('/comment/{id}',[CommentController::class,'update']); // 댓글 수정 // 댓글 id / api
        Route::delete('/comment/{id}',[CommentController::class,'delete']); // 댓글 삭제 // 댓글 id / api
        Route::get('/chatlist', [MessengerController::class,'chatlist']); // 채팅 리스트 출력
        Route::post('/chat', [MessengerController::class,'store']); // 채팅 전송
        Route::delete('/chat-alarm', [MessengerController::class,'removeAlarm']); // 채팅 읽어서 알람 없애기
        Route::get('/chat/{chatRoomId}', [MessengerController::class,'chatRoomRecords']); // 채팅방 내역 불러오기
        Route::delete('/chat/{chatRoomId}', [MessengerController::class,'chatRoomRecords']); // 채팅방 나가기
        Route::delete('/signout',[ProjectController::class,'signoutm']); // 구성원 내보내기
    });
    Route::get('/dashboard-chart', [TaskController::class, 'board_graph_data']); // 그래프 데이터 추출
    Route::get('/chart-data/{id}', [ProjectController::class, 'project_graph_data']); // 프로젝트 그래프 데이터 추출
    Route::get('/basedata/{id}', [BaseDataController::class, 'get_priority_list']); // 우선순위 리스트 조회 / api
    Route::get('/project/{id}', [ProjectController::class, 'project_select']); // 프로젝트 색상 가져오기 / api
    Route::get('/project/user/{id}', [ProjectController::class, 'project_user_select']); // 프로젝트 참여자 가져오기 / api
    Route::get('/chart-data', [ProjectController::class, 'project_graph_data']); // 프로젝트 그래프 데이터 추출
    Route::post('/chat-alarm', [MessengerController::class,'alarm']); // 채팅 왔다는 알람 전송
    Route::get('/alarms',[AlarmController::class,'getAlarmList']); // 알람 불러오기
    Route::post('/alarms/{id}',[AlarmController::class,'readAlarm']); // 알람 읽기
    Route::get('/online/{id}',[OnOfflineController::class,'areYouMyFriend']); // 채널에 온 온라인표시가 내 친구인지 판별
    Route::get('/modal-auth/{id}', [TaskController::class,'auth']); //업무 삭제권한 부여
    Route::get('/comment-auth/{id}', [TaskController::class,'commentAuth']); //댓글 편집권한 부여
});