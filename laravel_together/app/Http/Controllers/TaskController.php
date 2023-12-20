<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Models\Task;

class TaskController extends Controller
{
    public function showdashboard() {

        $user = Auth::user();
        $now = Carbon::now();
        $koreanDayOfWeek = $now->isoFormat('dddd');
   
        $formatDate1 = $now->format('Y년 n월 j일');
        // $formatDate2 = $now->format('G시 i분');

        if(Auth::check()) {
            return view('dashboard', [
                'user' => $user,
                'formatDate1' => $formatDate1,
                // 'formatDate2' => $formatDate2,
                'koreanDayOfWeek' => $koreanDayOfWeek,
            ]);
        } else {
            return redirect('/user/login');
        }
    }

    public function showheader() {

        $user = Auth::user();

        if(Auth::check()) {
            return view('layout', [
                'user' => $user,
            ]);
        } else {
            return redirect('/user/login');
        }
    }
}

