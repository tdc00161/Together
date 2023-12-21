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

     // 친구 목록
    public function myfriendList()
    {
        $userId = Auth::id();

        $useUserId = // 특정 조건에 따라 true 또는 false를 설정

        $myfriendList = DB::table('friendlists as f')
        ->join('users as u', function ($join) use ($userId) {
            $join->on(function ($query) use ($userId) {
                    $query->on('u.id', '=', 'f.friend_id')
                        ->where('f.user_id', '=', $userId);
                })
                ->orOn(function ($query) use ($userId) {
                    $query->on('u.id', '=', 'f.user_id')
                        ->where('f.friend_id', '=', $userId);
                });
        })
        ->select([
            'f.friend_id',
            'u.id as user_id',
            'u.name',
            DB::raw("CASE WHEN f.user_id = {$userId} THEN u.name ELSE NULL END AS friend_name"),
            'u.email',
        ])
        ->whereNull('f.deleted_at')
        ->orderBy('u.name', 'asc')
        ->distinct()
        ->get();

         // dd($friendList);
        return response()->json([
            'myfriendList' => $myfriendList,
            'useUserId' => $useUserId
        ]);
    }

    public function deleteFriend(Request $request)
    {
        try {
            $userId = Auth::id();
            $deletefriendId = $request->json('deletefriendId');

            $deleted = Friendlist::where('user_id', $userId)
                ->where('friend_id', $deletefriendId)
                ->delete();

            if (!$deleted) {
                return response()->json(['status' => 'error', 'message' => '친구를 찾을 수 없습니다.'], 404);
            }

            return response()->json(['status' => 'success', 'message' => '친구가 성공적으로 삭제되었습니다.']);
        } catch (\Exception $e) {
            // 예외 발생 시 로깅
            Log::error($e->getMessage());

            return response()->json(['status' => 'error', 'message' => '오류가 발생했습니다.'], 500);
        }
    }
}