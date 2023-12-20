<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\FriendRequest;
use App\Models\Friendlist;
use Illuminate\Support\Facades\DB;

class FriendlistController extends Controller
{
    public function frienddelete($friendId)
    {
        // 여기에서 소프트 삭제 또는 다른 친구 삭제 로직을 수행
        // $friendId를 이용하여 친구 삭제 로직을 수행

        // 성공 응답
        return response()->json(['message' => 'Friend deleted successfully']);
    }
}
