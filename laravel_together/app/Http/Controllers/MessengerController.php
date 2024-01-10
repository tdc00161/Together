<?php

namespace App\Http\Controllers;

use App\Events\MessageCame;
use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\ChatRoom;
use App\Models\ChatUser;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MessengerController extends Controller
{
	// 자신이 참여한 채팅방들을 가져옴
	public function chatlist()
	{
		$data = [];
		$userId = Auth::id();

		$data['myChatRooms'] = DB::table('chat_rooms as cr')
			->join('chat_users as cu', 'cu.chat_room_id', 'cr.id')
			->where('cu.user_id', $userId)
			->get()
			->toArray();

		$data['myChatCount'] = $this->getAlarm();

		return $data;
	}

	// 한 채팅방의 채팅내역을 불러옴
	public function chatRoomRecords($chatRoomId)
	{

		// 채팅방 id로 채팅 내역을 검색
		$response['chatRecords'] = DB::table('chats as c')
			->join('users as u', 'u.id', 'c.sender_id')
			->where('receiver_id', $chatRoomId)
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
	public function store(Request $request)
	{

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
		// Log::debug($validated);

		// 채팅 생성
		$result = Chat::create($validated);

		// 해당 채팅방의 최신 내역 갱신
		ChatRoom::where('id', $result->receiver_id)
			->update([
				'last_chat' => $result->content,
				'last_chat_created_at' => now(),
			]);

		// 채팅 이벤트 실행
		MessageSent::dispatch($result);

		return $result;
	}

	// // 채팅수신알람
	// public function alarm(Request $request)
	// {

	// 	// $userId = Auth::id();

	// 	// 실행 시 알람리스트에 레코드 추가 (필요: 수신 받는 사람 / 내용)
	// 	// Log::debug('알람컨트롤러');
	// 	// Log::debug($request);

	// 	// 채팅 이벤트 실행
	// 	MessageCame::dispatch($request);

	// 	return $request;
	// }

	// 채팅수신알람 조회
	public function getAlarm()
	{

		$userId = Auth::id();

		// 자신이 참여한 채팅방 중 chat_user->chat_checked 이후로 생성된 채팅 가져오기
		$result = DB::table('chat_users as cu')
			->join('chat_rooms as cr', function ($join) {
				$join->on('cr.id', 'cu.chat_room_id')
					->where('cu.user_id', Auth::id());
			})
			->join('chats as c', function ($join) {
				$join->on('c.receiver_id', 'cr.id')
					->whereColumn('c.created_at', '>', 'cu.chat_checked');
			})
			->select('cr.id as chat_room_id', DB::raw('COUNT(c.id) as chat_count'))
			->groupBy('cr.id')
			->get();
		// dd($result);

		return $result;
	}

	// 채팅 읽음 처리
	public function removeAlarm(Request $request)
	{

		$userId = Auth::id();

		// Log::debug($request);
		// 해당 chat_users에 읽음 시간 갱신
		$readChatUser = ChatUser::where('chat_room_id', $request->now_chat_id)
			->where('user_id', $userId);
		$readChatUser->update([
				'chat_checked' => now(),
			]);
		// dd($result);

		$result = $readChatUser->first();

		Log::debug($result);

		return $result;
	}
}
