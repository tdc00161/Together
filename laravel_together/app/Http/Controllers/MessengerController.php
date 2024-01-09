<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\ChatRoom;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MessengerController extends Controller
{
	// 자신이 참여한 채팅방들을 가져옴
    public function chatlist() {

		$userId = Auth::id();
		
		$myChatRooms = DB::table('chat_rooms as cr')
			->join('chat_users as cu','cu.chat_room_id','cr.id')
			->where('cu.user_id',$userId)
			->get()
			->toArray();
			
    	return $myChatRooms;
    }

	// 한 채팅방의 채팅내역을 불러옴
    public function chatRoomRecords($chatRoomId) {

		// 채팅방 id로 채팅 내역을 검색
		$response['chatRecords'] = DB::table('chats as c')
			->join('users as u','u.id','c.sender_id')
			->where('receiver_id',$chatRoomId)
			->select(
				'c.id',
				'c.sender_id',
				'u.name',
				'c.receiver_id',
				'c.content',
				'c.created_at',
				'c.updated_at',
				)
			->get()
			->toArray();
		// Log::debug($chatRecords);

		$response['userId'] = Auth::id();
			
    	return $response;
    }

	// 채팅전송
    public function store(Request $request) {

		$userId = Auth::id();

		// chat 채팅내역에 새로운 채팅을 저장 (필요: sender_id, receiver_id(chat_rooms 채팅방 join), content)
		$request['sender_id'] = $userId;

		// 채팅 유효성 검사
		$validated = $request->validate([
			'content' => 'required',
			'sender_id' => 'required',
			'receiver_id' => 'required',
		]);

		Log::debug($request);
		Log::debug($validated);
		
		// 채팅 생성
		$result = Chat::create($validated);

		// 해당 채팅방의 최신 내역 갱신
		ChatRoom::where('id',$result->receiver_id)
			->update([
				'last_chat' => $result->content
			]);

		// 채팅 이벤트 실행
		MessageSent::dispatch($result);

    	return $result;
    }
}
