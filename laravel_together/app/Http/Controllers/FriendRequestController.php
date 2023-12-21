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

        // 입력하지 않았을 때
        if (empty($receiverEmail)) {
            return response()->json([
                'success' => false, 
                'message' => '이메일을 입력하세요.',
            ]);
        }

        // 이메일 형식 검사
        $emailRegex = '/^[^\s@]+@[^\s@]+\.[^\s@]+$/';

        if (!preg_match($emailRegex, $receiverEmail)) {
            return response()->json([
                'success' => false, 
                'message' => '올바른 이메일 형식이 아닙니다.']);
        }

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

    // 친구 요청 목록
    public function friendRequests()
    {
        // 현재 로그인한 사용자의 ID
        $userId = Auth::id();

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

    // 친구 요청 보낸 목록
    public function friendSendlist()
    {
        // 현재 로그인한 사용자의 ID
        $userId = Auth::id();

        $friendSendlist = DB::table('friend_requests as f')
        ->join('users as u', 'u.id', '=', 'f.to_user_id')
        ->select('u.id', 'u.name', 'u.email')
        ->where('f.from_user_id', '=', $userId)
        ->where('f.status', '=', 'pending')
        ->get();

        return response()->json([
            'friendSendlist' => $friendSendlist,
        ]);
    }

    // 친구 on/off 
    public function loginUser()
    {
        session_start(); // 세션을 시작합니다.

        // 로그인된 사용자의 정보 가져오기
        $loggedInUser = $_SESSION['user'];

        // 사용자 정보 출력 또는 활용
        echo "Welcome, " . $loggedInUser['username'];
    }
    
    // 친구요청 취소
    public function cancleFriendRequest(Request $request)
    {
    $userId = Auth::id();
    // 요청에서 받은 requestId를 사용하여 데이터베이스 업데이트 작업 수행
    $sendData = $request->json()->all();
    $sendId = $sendData['sendId'];

    if($sendId) {
        DB::table('friend_requests')
        ->where('from_user_id', $userId)
        ->where('to_user_id', $sendId)
        ->update(['status' => 'rejected']);

        return response()->json(['success' => true, 'message' => 'Friend request rejected.']);
    } else {
        return response()->json(['success' => false, 'message' => 'Friend request not found.']);
    }
    }
    
    // 친구요청 거절
    public function rejectFriendRequest(Request $request)
    {
    $userId = Auth::id();
    // 요청에서 받은 requestId를 사용하여 데이터베이스 업데이트 작업 수행
    $requestData = $request->json()->all();
    $requestId = $requestData['requestId'];

    if($requestId) {
        DB::table('friend_requests')
        ->where('from_user_id', $requestId)
        ->where('to_user_id', $userId)
        ->update(['status' => 'rejected']);

        return response()->json(['success' => true, 'message' => 'Friend request rejected.']);
    } else {
        return response()->json(['success' => false, 'message' => 'Friend request not found.']);
    }
    }

    // <친구요청 수락> 및 <친구 목록에 추가>
    public function acceptFriendRequest(Request $request)
    {
    $userId = Auth::id();
    // 요청에서 받은 requestId를 사용하여 데이터베이스 업데이트 작업 수행
    $requestData = $request->json()->all();
    $requestId = $requestData['requestId'];

    if($requestId) {
        // 친구 요청 상태를 'accepted'로 업데이트
        DB::table('friend_requests')
        ->where('from_user_id', $requestId)
        ->where('to_user_id', $userId)
        ->update(['status' => 'accepted']);

         // 친구 목록에 추가
         $friendRequest = DB::table('friend_requests')
         ->where('from_user_id', $requestId)
         ->where('to_user_id', $userId)
         ->first();

     if ($friendRequest) {
         $addfriendlist = new Friendlist();
         $addfriendlist->user_id = $friendRequest->to_user_id;
         $addfriendlist->friend_id = $friendRequest->from_user_id;
         $addfriendlist->save();
     }
        return response()->json(['success' => true, 'message' => 'Friend request accepted.']);
    } else {
        return response()->json(['success' => false, 'message' => 'Friend request not found.']);
    }
    }

}

