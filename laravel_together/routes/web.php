<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController; // 

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

Route::get('/layout', function () {
    return view('layout.layout');
});
// Route::get('/board', [BoardController::class, 'index'])->name('board.index');

Route::get('/dashboard', function () {
    return view('dashboard');
});
Route::get('/ganttchart', function () {
    return view('ganttchart');
});
Route::get('/project-create', function () {
    return view('/project-create');
});
Route::get('/project-individual', function () {
    return view('/project-individual');
});
Route::get('/project-team', function () {
    return view('/project-team');
});


// 모달
Route::get('/detail', function () {
    return view('modal/detail');
});
Route::get('/insert', function () {
    return view('modal/insert');
});
Route::get('/messenger', function () {
    return view('modal/messenger');
});




