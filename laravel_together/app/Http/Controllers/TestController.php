<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class TestController extends Controller
{
    public function index()
    {
        $result = Comment::with(['tasks','users'])->find(1);
        $result = [
            $result->tasks->title,
            $result->users->name
        ];
        dd($result);
        return view('modal/modaltest');
    }
}
