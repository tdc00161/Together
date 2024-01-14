<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OnOfflineController extends Controller
{
    // 내 친구인지 판별
    public function areYouMyFriend($id) {
        $me = Auth::id();
        $friend = $id;
        Log::debug($me);
        Log::debug($friend);

        $result = DB::table('friendlists')
            ->where(function ($query) use ($me, $friend) {
                $query->where('user_id', $me)
                    ->where('friend_id', $friend);
            })
            ->orWhere(function ($query) use ($me, $friend) {
                $query->where('user_id', $friend)
                    ->where('friend_id', $me);
            })
            ->count();
        // Log::debug($result);

        return $result;
    }
}
