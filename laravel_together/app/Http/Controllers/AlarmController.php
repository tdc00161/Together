<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AlarmController extends Controller
{
	// 알람 출력
    public function getAlarmList(){
        $responseData = [
            "code" => "0",
            "msg" => ""
        ];

		$userId = Auth::id();

        $result = DB::table('alarms as a')
			->join('users as u', function($j){
				$j->on('a.listener_id','u.id')
					->where('u.id', Auth::id());
			})
			->whereNull('a.deleted_at')
            ->select(
                'a.id',
                'a.listener_id',
                'a.read',
                'a.content',
                'a.created_at',
                )
			->orderByDesc('a.created_at')
			->get();
        // Log::debug($result);

        if ($result === []) {
            $responseData['code'] = 'E01';
            $responseData['msg'] = 'Alarms are no where';
        } else {
            $responseData['data'] = $result;
            $responseData['code'] = 'D01';
            $responseData['msg'] = 'Alarms comeing';
        }

        return $responseData;
    }
}
