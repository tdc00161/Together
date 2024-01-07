<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MessengerController extends Controller
{
    public function a() {

		// $userId = Auth::id();

		// // $result = DB::table('chats')->where('flg','0')->where('receiver_id', $userId)->get();
		// $result = DB::table('chat_users as cu')
		// 	->join('projects as p','p.id','=','cu.chat_room_id')
		// 	->where('user_id', $userId)->get();
		// // dd($result);

    	// return $result;
    	return true;
    }
}
