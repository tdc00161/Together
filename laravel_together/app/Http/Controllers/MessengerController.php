<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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
		$chatRecords = DB::table('chats as c')
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
		Log::debug($chatRecords);
			
    	return $chatRecords;
    }

	// 채팅전송
    public function store(Request $request) {

		$userId = Auth::id();
						
    	return $request;
    	// return $myChatRooms;
    }
}
