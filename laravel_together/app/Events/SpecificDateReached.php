<?php

namespace App\Events;

use Carbon\Carbon;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SpecificDateReached implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data = 'data';
    
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    // 업무 날짜별 이벤트
    public function TaskDateCheck()
    {
        Log::debug('TaskDateCheck');
        $Tasks = DB::table('tasks as t')
            ->join('projects as p', 'p.id', 't.project_id')
            ->select(
                't.title',
                't.start_date',
                't.end_date',
                't.task_responsible_id',
                'p.project_title',
                )
            ->get();
        foreach ($Tasks as $key => $Task) {    
            if($Task->start_date !== null){
                if($Task->start_date === now()->format('Y-m-d') && $Task->task_responsible_id !== null){
                    Log::debug('오늘일시작');                    
                    $AlarmEvent = new AlarmEvent(['TS',$Task->task_responsible_id,[$Task]]);
                    $AlarmEvent->newAlarm();
                }
            }
            if($Task->end_date !== null){
                $date1 = Carbon::parse($Task->end_date);
                $date2 = Carbon::parse(now()->format('Y-m-d'));
                $daysDifference = $date1->diffInDays($date2);  
                // Log::debug('$daysDifference',[$daysDifference]);                  
                // Log::debug('$date1 > $date2',[$date1 > $date2]);                  
                if($Task->task_responsible_id !== null && $date1 > $date2){
                    if($daysDifference === 7 || $daysDifference === 3 || $daysDifference === 1){
                        // Log::debug('마감까지 일주일',[$Task]);                    
                        $AlarmEvent = new AlarmEvent(['TE'.$daysDifference,$Task->task_responsible_id,[$Task]]);
                        $AlarmEvent->newAlarm();
                    }
                }
            }
            // Log::debug([$Task]);
            // Log::debug(now()->format('Y-m-d'));
        }
    }

    // 프로젝트 날짜별 이벤트
    public function ProjectDateCheck()
    {
        Log::debug('ProjectDateCheck');
        // 프로젝트와 멤버 가져오기
        // $Projects = DB::table('projects')->get();
        $ProjectUsers = DB::table('project_users as pu')
            ->join('projects as p',function($j){
                $j->on('p.id','pu.project_id')
                    // ->where('p.id',)
                    ->whereNull('pu.deleted_at')
                    ->whereNull('p.deleted_at');
                })
            ->select('p.id','p.project_title','p.start_date','p.end_date','pu.member_id')
            ->get();

        // 프로젝트별 멤버를 새배열로 만들기
        $PUarr = [];
        foreach ($ProjectUsers as $key => $ProjectUser) {
            $PUarr[$ProjectUser->id][] = $ProjectUser->member_id;
        }

        // 프로젝트 멤버별 초대하는 함수 모듈화
        function PUarrForEach($PUarrForEach){  
            $getAlarmMembers = $PUarrForEach['PUarr'][$PUarrForEach['ProjectKey']];
            foreach ($getAlarmMembers as $key => $value) {
                // Log::debug($value);
                // Log::debug([$PUarrForEach['Project']]);
                $AlarmEvent = new AlarmEvent([$PUarrForEach['code'],$value,$PUarrForEach['Project']]); // 0112 김관호: 이제 AlarmEvent파라미터 알맞게 맞추고 heidi로 레코드 생성 확인
                $AlarmEvent->newAlarm();        
            }
        }

        // Log::debug($PUarr); 프로젝트마다 유저 획득
        // 이제 프로젝트별 날짜비교해서 프로젝트 유저에게 이벤트 발생시키기
        foreach ($ProjectUsers as $key => $ProjectUser) {
            // 마감일자와 시작일자가 현재와 같을 때 반복문을 돌려서 멤버마다 이벤트 발생
            $date1 = Carbon::parse($ProjectUser->end_date);
            $date2 = Carbon::parse(now()->format('Y-m-d'));
            $daysDifference = $date1->diffInDays($date2); 
            if($ProjectUser->start_date === now()->format('Y-m-d')){
                Log::debug('프로젝트 시작');
                // 해당 if에 맞는 프로젝트만 ($key 획득) 멤버들을 반복돌려서 이벤트 뿌리기
                PUarrForEach([
                    'code' => 'PS',
                    'PUarr' => $PUarr,
                    'ProjectKey' => $ProjectUser->id,
                    'Project' => $ProjectUser
                ]);                
            }
            if($date1 > $date2){
                if($daysDifference === 30 || $daysDifference === 14 || $daysDifference === 7 || $daysDifference === 3 || $daysDifference === 1){
                    Log::debug('프로젝트 마감');
                    // 해당 if에 맞는 프로젝트만 ($key 획득) 멤버들을 반복돌려서 이벤트 뿌리기
                    PUarrForEach([
                        'code' => 'PE'.$daysDifference,
                        'PUarr' => $PUarr,
                        'ProjectKey' => $ProjectUser->id,
                        'Project' => $ProjectUser
                    ]);                 
                }
            }
        }
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('daycheck');
    }
}
