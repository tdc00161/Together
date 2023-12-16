<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\FriendRequest;
use App\Models\Friendlist;

class FriendRequestController extends Controller
{
   
    // 친구요청 보내기 로직
    public function sendFriendRequest(Request $request)
    {
        // 입력된 이메일 주소
        $receiverEmail = $request->input('receiver_email');

        // 수신자 정보 찾기 (이메일 중복방지)
        try {
            $receiver = User::where('email', $receiverEmail)->firstOrFail();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return response()->json([
                'success' => false,
                'message' => '사용자를 찾을 수 없습니다.',
            ]);
        }

        // 현재 사용자 정보
        $sender = Auth::user();

        // 이미 친구인지 확인
        if ($sender->id === $receiver->id) {
            return response()->json([
                'success' => false, 
                'message' => '나에게는 친구요청을 보낼수 없습니다.']);
        }

        //  // 이미 친구인지 확인
        //  if ($sender->id === $receiver->id || $sender->isFriendWith($receiver)) {
        //     return response()->json([
        //         'success' => false, 
        //         'message' => '이미 친구입니다.']);
        // }

        // 이미 친구 요청을 보냈는지 확인
        if ($sender->hasPendingFriendRequestTo($receiver) ) {
        
            return response()->json([
                'success' => false, 
                'message' => '이미 친구 요청을 보냈습니다.']);
        }

        //    // 이미 친구 요청을 보냈는지 확인
        //    if ($receiver->hasPendingFriendRequestFrom($sender)) {
        
        //     return response()->json([
        //         'success' => false, 
        //         'message' => '이미 친구 요청을 받았습니다.']);
        // }

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
            'message' => '친구 요청을 보냈습니다.',
            // 추가적인 필요한 데이터도 함께 반환할 수 있음
        ]);
    }
}
