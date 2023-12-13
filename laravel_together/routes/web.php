<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/layout', function () {
    return view('layout.layout');
});
Route::get('/dashboard', function () {
    return view('dashboard');
});
Route::get('/ganttchart', function () {
    return view('ganttchart');
});
Route::get('/project-create', function () {
    return view('/project_create');
});
Route::get('/project_individual', function () {
    return view('/project_individual');
});
Route::get('/project_team', function () {
    return view('/project_team');
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




