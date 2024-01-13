<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Alarm;
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

        // 한달전까지 알람 호출
        $startDate = now()->subMonth();
        $result = DB::table('alarms as a')
			->join('users as u', function($j) use ($startDate){
				$j->on('a.listener_id','u.id')
					->where('u.id', Auth::id())
                    ->whereNull('a.deleted_at')
                    ->where('a.created_at','>',$startDate);
			})			
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

	// 알람 읽기
    public function readAlarm($id){
        $responseData = [
            "code" => "0",
            "msg" => ""
        ];

		$userId = Auth::id();

        $result = Alarm::find($id)
            ->update([
                'read' => '1'
            ]);
        // Log::debug($result);

        if (!$result) {
            $responseData['code'] = 'E01';
            $responseData['msg'] = 'Alarm has not been read';
        } else {
            $responseData['data'] = $result;
            $responseData['code'] = 'D01';
            $responseData['msg'] = 'Alarms has been read';
        }

        return $responseData;
    }
}
