<?php

namespace App\Http\Controllers;

use App\Models\ChatRoom;
use App\Models\ChatUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\FriendRequest;
use App\Models\Friendlist;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
            'u.online_flg', // 0114 김관호 알림 출력용
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

            $deleted = Friendlist::where(function ($query) use ($userId, $deletefriendId) {
                $query->where('user_id', $userId)
                      ->where('friend_id', $deletefriendId);
            })
            ->orWhere(function ($query) use ($userId, $deletefriendId) {
                $query->where('user_id', $deletefriendId)
                      ->where('friend_id', $userId);
            })
            ->delete();

            // 친구채팅방 나가기 및 삭제
            $chatRoom = ChatRoom::join('chat_users as cu', 'cu.chat_room_id', '=', 'chat_rooms.id')
                ->where('chat_rooms.flg', '0')
                ->whereNull('chat_rooms.deleted_at')
                ->where(function($query) use ($userId, $deletefriendId) {
                    $query->where('cu.user_id', $userId)
                        ->orWhere('cu.user_id', $deletefriendId);
                })
                ->select(
                    'chat_rooms.id',
                    'chat_rooms.flg',
                    'chat_rooms.project_id',
                    'chat_rooms.user_count',
                    'chat_rooms.last_chat',
                    'chat_rooms.last_chat_created_at',
                    'chat_rooms.chat_room_name',
                    'chat_rooms.created_at',
                    'chat_rooms.updated_at',
                    'chat_rooms.deleted_at',
                )
                ->distinct();           
            Log::debug('$chatUser');
            // // 채팅방 참여 레코드
            // $chatUser = DB::table('chat_users as cu')
            //     ->join('chat_rooms as cr', function($j){
            //         $j->on('cu.chat_room_id','cr.id')
            //             ->where('cr.flg','0')
            //             ->whereNull('cr.deleted_at')
            //             ->whereNull('cu.deleted_at');
            //     })
            //     ->where(function($query) use ($userId, $deletefriendId) {
            //         $query->where('cu.user_id',$userId)
            //         ->orWhere('cu.user_id',$deletefriendId);
            //     })
            //     ->select(
            //         'cu.id',
            //         'cu.chat_room_id',
            //         'cu.user_id',
            //         'cu.chat_checked',
            //         'cu.created_at',
            //         'cu.updated_at',
            //         'cu.deleted_at',
            //     );
            // Log::debug('$chatUser');
            // Log::debug([$chatUser->get()]);
            
            // if (!$deleted || $chatUser->count() !== 2) {
            //     return response()->json(['status' => 'error', 'message' => '친구를 찾을 수 없습니다.'], 404);
            // }
            // // 채팅방/채팅참여 삭제
            // $chatUsers = $chatUser->get();
            // Log::debug('$chatUsers');
            // Log::debug($chatUsers);

            // foreach ($chatUsers as $chatUserRecord) {
            //     $model = ChatUser::find($chatUserRecord->id);
            //     $model->delete();
            // }
            
            $chatRoom->delete();
            
            return response()->json(['status' => 'success', 'message' => '친구가 성공적으로 삭제되었습니다.']);
        } catch (\Exception $e) {
            // 예외 발생 시 로깅
            Log::error($e->getMessage());

            return response()->json(['status' => 'error', 'message' => '오류가 발생했습니다.'], 500);
        }
    }
}