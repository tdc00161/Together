<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;

class TaskController extends Controller
{
    public function showdashboard() {
        $user = Auth::user();

        return view('dashboard', ['user' => $user]);
    }
}
