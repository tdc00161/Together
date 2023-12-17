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
   
    // 친구요청 보내기
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

        // // 입력하지 않았을 때
        // if (empty($receiverEmail)) {
        //     return response()->json([
        //         'success' => false, 
        //         'message' => '이메일을 입력하세요.',
        //     ]);
        // }

        // // 이메일 형식 검사
        // $emailRegex = '/^[^\s@]+@[^\s@]+\.[^\s@]+$/';

        // if (!preg_match($emailRegex, $receiverEmail)) {
        //     return response()->json([
        //         'success' => false, 
        //         'message' => '올바른 이메일 형식이 아닙니다.']);
        // }


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

    // 친구 요청 목록
    public function friendRequests()
    {
        // 현재 로그인한 사용자의 ID
        $userId = Auth::id();

        // 친구 요청을 보낸 사용자 목록
        // $friendRequestlist = User::find($userId)->friendRequeststo()
        // ->where('status', 'pending')
        // ->with('from_user')
        // ->get();

        $friendRequestlist = DB::table('friend_requests')
        ->join('users', 'users.id', '=', 'friend_requests.from_user_id')
        ->select('users.id', 'users.name', 'users.email')
        ->where('friend_requests.to_user_id', '=', $userId)
        ->where('friend_requests.status', '=', 'pending')
        ->orderBy('friend_requests.created_at', 'desc')
        ->get();

        $friendRequestCount = DB::table('friend_requests')
        ->where('to_user_id', $userId)
        ->where('status', 'pending')
        ->count();

        return response()->json([
            'friendRequests' => $friendRequestlist,
            'friendRequestCount' => $friendRequestCount,
        ]);
    }

    public function rejectFriendRequest(Request $request)
    {
    // 요청에서 받은 requestId를 사용하여 데이터베이스 업데이트 등의 작업 수행
    $requestData = $request->json()->all();
    $requestId = $requestData['requestId'];
    
    // 예시: FriendRequest 모델을 사용하여 업데이트
    $friendRequest = FriendRequest::find($requestId);
    
    if ($friendRequest) {
        $friendRequest->status = 'rejected';
        $friendRequest->save();

        return response()->json(['success' => true, 'message' => 'Friend request rejected.']);
    } else {
        return response()->json(['success' => false, 'message' => 'Friend request not found.']);
    }
    }
}
