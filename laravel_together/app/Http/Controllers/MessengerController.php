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

		// 자신이 참여한 채팅방 
		$data['myChatRooms'] = DB::table('chat_rooms as cr')
			->join('chat_users as cu', 'cu.chat_room_id', 'cr.id')
			->where('cu.user_id', $userId)
			->orderBy('last_chat_created_at','desc')
			->get()
			->toArray();

		// 알람 갯수 불러오기
		$data['myChatCount'] = $this->getAlarm();

		// 채팅방 인원구 불러오기
		// $data['myChatMembers'] = 0;

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

		// Log::debug($request);
		// Log::debug($validated);
		
		// 채팅 생성
		$result = Chat::create($validated);
		
		// 해당 채팅방의 최신 내역 갱신
		ChatRoom::where('id', $result->receiver_id)
		->update([
			'last_chat' => $result->content,
			'last_chat_created_at' => now()->format('Y-m-d H:i:s'),
		]);
		
		// 채팅 이벤트 실행
		MessageSent::dispatch($result);
		
		return $result;
	}

	// // 채팅수신알람
	public function alarm(Request $request)
	{

		// $userId = Auth::id();

		// 실행 시 알람리스트에 레코드 추가 (필요: 수신 받는 사람 / 내용)
		// Log::debug('알람컨트롤러');
		// Log::debug($request);

		// 채팅 이벤트 실행
		MessageCame::dispatch($request);

		return $request;
	}

	// 채팅수신알람 조회
	public function getAlarm()
	{

		$userId = Auth::id();

		// 자신이 참여한 채팅방 중 내가 쓴게 아닌 chat_user->chat_checked 이후로 생성된 채팅 가져오기
		$result = DB::table('chat_users as cu')
			->join('chat_rooms as cr', function ($join) {
				$join->on('cr.id', 'cu.chat_room_id')
					->where('cu.user_id', Auth::id());
			})
			->join('chats as c', function ($join) {
				$join->on('c.receiver_id', 'cr.id')
					->whereColumn('c.created_at', '>', 'cu.chat_checked')
					->where('c.sender_id','!=',Auth::id());
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
				'chat_checked' => now()->format('Y-m-d H:i:s'),
			]);
		// dd($result);

		$result = $readChatUser->first();

		// Log::debug($result);

		return $result;
	}

	// 채팅방 생성 및 초대 처리 (선 - 프로젝트 생성(자동) / 친구추가(자동) / 나중 - 초대(수동))
	public function createRoomAndInvite(Request $request)
	{
		$data = [
			'flg' => $request->flg,
			'user_count' => $request->defaultPeople,
			'chat_room_name' => $request->defaultRoomName,
		];
		
		$result = ChatRoom::create($data);

		return $result;
	}

	// 채팅방 마다 인원수 구하기
	public function getChatMembers()
	{
		$userId = Auth::id();

		$result = DB::table('chat_users as cu')
			->join('chat_rooms as cr', function($join) {
				$join->on('cr.id','cu.chat_room_id');
			}) // 여기서 자신이 포함된 채팅방을 가져오라는 이중쿼리를 해야함 -> 보류
			->select('cu.chat_room_id', DB::raw('count(cu.id) as user_count'))
			->groupBy('cu.chat_room_id')
			->get();

		return $result;
	}
}
