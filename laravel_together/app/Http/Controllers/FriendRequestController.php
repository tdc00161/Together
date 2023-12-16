<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\FriendRequest;
use App\Models\Friendlist;
use Illuminate\Support\Facades\DB;

class FriendRequestController extends Controller
{
   
    // 친구요청 보내기 로직
    public function sendFriendRequest(Request $request)
    {
        $receiverEmail = $request->input('receiver_email'); // 입력된 이메일 주소
        $sender = Auth::user(); // 현재 사용자 정보

        // 수신자 정보 찾기 (이메일 중복방지)
        try {
            $receiver = User::where('email', $receiverEmail)->firstOrFail();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return response()->json([
                'success' => false,
                'message' => '유저가 존재하지 않습니다.',
            ]);
        }

        // 자신에게 친구요청
        if ($sender->id === $receiver->id) {
            return response()->json([
                'success' => false, 
                'message' => '자기 자신에게 요청할 수 없습니다.']);
        }

         // 이미 친구인지 확인
         if ($sender->isFriendWith($receiver)) {
            return response()->json([
                'success' => false, 
                'message' => '이미 친구입니다.']);
        }

        // 친구요청 중복 방지
        $existingRequest = FriendRequest::where('from_user_id', $sender->id)
        ->where('to_user_id', $receiver->id)
        ->where('status', 'pending')
        ->first();

        if ($existingRequest) {
            return response()->json([
                'success' => false, 
                'message' => '이미 친구 요청을 보냈습니다.',
            ]);
        }

        // 현재 사용자에게 이미 친구 요청을 보낸 경우
        $existingRequestToCurrentUser = FriendRequest::where('from_user_id', $receiver->id)
        ->where('to_user_id', $sender->id)
        ->where('status', 'pending')
        ->first();

        if ($existingRequestToCurrentUser) {
            return response()->json([
                'success' => false, 
                'message' => '상대방이 이미 친구 요청을 보낸 상태입니다.',
            ]);
        }

        // 친구 요청 생성
        $friendRequest = new FriendRequest([
            'from_user_id' => $sender->id,
            'to_user_id' => $receiver->id,
            'status' => 'pending',
        ]);

        $friendRequest->save();

        // Ajax 요청에서 처리할 응답 데이터 반환
        return response()->json([
            'success' => true,
            'message' => '친구 요청을 정상적으로 보냈습니다.',
            // 추가적인 필요한 데이터도 함께 반환할 수 있음
        ]);
    }

    public function friendRequests()
    {
        // 현재 로그인한 사용자의 ID를 가져옴
        $userId = Auth::id();

        // 친구 요청을 보낸 사용자 목록을 가져옴
        $friendRequestlist = DB::table('friend_requests')
        ->join('users', 'users.id', '=', 'friend_requests.from_user_id')
        ->select('users.id', 'users.name')
        ->where('friend_requests.to_user_id', '=', $userId)
        ->where('friend_requests.status', '=', 'pending')
        ->get();
        // dd($friendRequestlist);
        return view('modal.messenger')->with('friendRequestlist', $friendRequestlist);
    }
}
