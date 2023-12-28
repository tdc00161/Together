<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use App\Models\BaseData;

class GanttChartController extends Controller
{
    // 태스크 전체 조회 (수정이전)
    public function ganttIndex()
    {
        // --- 유저 정보
        $user = Auth::user();

        $user_data = project::where('user_pk',$user->id)
                                ->select('id'
                                        ,'user_pk'
                                        ,'color_code_pk'
                                        ,'project_title'
                                        ,'project_content'
                                        ,'start_date'
                                        ,'end_date'
                                        ,'created_at'
                                        ,'flg'
                                        )
                                ->get();
        // dd($user_data);

        $userId = Auth::id();

        $project0title = DB::table('projects as p')
                            ->join('project_users as pu', 'p.id','=','pu.project_id')
                            ->join('basedata as b', 'b.data_content_code', '=', 'p.color_code_pk')
                            ->select('p.project_title', 'b.data_content_name', 'p.id')
                            ->where('pu.member_id', '=', $userId)
                            ->where('p.flg','=', 0)
                            ->where('b.data_title_code', '=', 3)
                            ->orderBy('p.created_at', 'asc')
                            ->get();

        $project1title = DB::table('projects as p')
                            ->join('project_users as pu', 'p.id','=','pu.project_id')
                            ->join('basedata as b', 'b.data_content_code', '=', 'p.color_code_pk')
                            ->select('p.project_title', 'b.data_content_name', 'p.id')
                            ->where('pu.member_id', '=', $userId)
                            ->where('p.flg','=', 1)
                            ->where('b.data_title_code', '=', 3)
                            ->orderBy('p.created_at', 'asc')
                            ->get();

        // 담당자 이름 출력
        $managername = DB::table('tasks')
                        ->join('users', function($user) {
                            $user->on('tasks.task_responsible_id','=','users.id');
                        })
                        ->join('projects', function($projects) {
                            $projects->on('tasks.project_id','=','projects.id');
                        })
                        ->select('users.name','tasks.project_id','projects.user_pk')
                        ->where('projects.user_pk',$user)
                        ->get();
        // dd($managername);

        $returnData = [];

        foreach ($user_data as $item) {
            $tempData = $item->getAttributes();
            $tempData['task'] = [];
            // 상위 테이블
            $firstTask = DB::table('tasks')
                ->join('users', function($user) {
                    $user->on('tasks.task_responsible_id','=','users.id');
                })
                ->join('projects', function($projects) {
                    $projects->on('tasks.project_id','=','projects.id');
                })
                ->join('basedata as base1', function($base1) {
                    $base1->on('tasks.task_status_id','=','base1.data_content_code');
                })
                ->select(
                    'tasks.id'
                    ,'tasks.project_id'
                    ,'tasks.title'
                    ,'tasks.task_responsible_id'
                    ,'users.name'
                    ,'tasks.start_date'
                    ,'tasks.end_date'
                    ,'tasks.task_status_id'
                    ,'base1.data_content_name'
                    ,'tasks.task_depth'
                    ,'tasks.task_parent'
                )
                ->where('projects.user_pk',$user->id)
                ->where('projects.id',$item->id)
                ->where('tasks.task_depth','0')
                ->where('base1.data_title_code','0')
                ->orderby('tasks.id')
                ->get();
            // dd($firstTask);

            //하위 테이블
            foreach ($firstTask as $fristItem) {
                array_push($tempData['task'],(array)$fristItem);
                $secondTask = DB::table('tasks')
                    ->join('users', function($user) {
                        $user->on('tasks.task_responsible_id','=','users.id');
                    })
                    ->join('projects', function($projects) {
                        $projects->on('tasks.project_id','=','projects.id');
                    })
                    ->join('basedata as base1', function($base1) {
                        $base1->on('tasks.task_status_id','=','base1.data_content_code');
                    })
                    ->select(
                        'tasks.id'
                        ,'tasks.title'
                        ,'tasks.task_responsible_id'
                        ,'users.name'
                        ,'tasks.start_date'
                        ,'tasks.end_date'
                        ,'tasks.task_status_id'
                        ,'base1.data_content_name'
                        ,'tasks.task_depth'
                        ,'tasks.task_parent'
                    )
                    ->where('projects.id',$fristItem->project_id)
                    ->where('tasks.task_parent',$fristItem->id)
                    ->where('base1.data_title_code','0')
                    ->where('tasks.task_depth','1')
                    ->orderby('tasks.id')
                    ->get();
                    // echo $fristItem->id, $fristItem->project_id;
                    // dd($secondTask);
                foreach ($secondTask as $secondItem) {
                    array_push($tempData['task'],(array)$secondItem);
                    // $item['task'][] = $secondItem;
                }
            }

            $returnData[] = $tempData;
        }
    //  dd($returnData);
   
        if(Auth::check()) {
            return view('ganttchart-all')
            ->with('user_data',$user_data)
            ->with('managername',$managername)
            ->with('listdata',$returnData)
            ->with('project0title',$project0title)
            ->with('project1title',$project1title);
        } else {
            return redirect('/user/login');
        }
    }


    // 간트 프로젝트별 조회
    public function ganttIndex_one($id)
    {
        $result = project::find($id);
        $user = Auth::user();

        // $project_id = $id; 

        $user_data = project::where('user_pk',$user->id)
        ->select('id'
                ,'user_pk'
                ,'color_code_pk'
                ,'project_title'
                ,'project_content'
                ,'start_date'
                ,'end_date'
                ,'created_at'
                ,'flg'
                )
        ->get();

        // --- 대시보드 공지 출력
        $dashboardNotice = DB::table('tasks as t')
        ->join('projects as p','p.id','=','t.project_id')
        ->join('project_users as pu','pu.project_id','=','p.id')
        ->join('basedata as b','p.color_code_pk','=','b.data_content_code')
        ->select ('t.title', 't.content', 'p.color_code_pk', 'p.project_title', 'b.data_content_name')
        ->where('b.data_title_code', '=', 3)
        ->where('pu.member_id', '=', $user->id)
        ->get();

        $userId = Auth::id();
        
        $project0title = DB::table('projects as p')
        ->join('project_users as pu', 'p.id','=','pu.project_id')
        ->join('basedata as b', 'b.data_content_code', '=', 'p.color_code_pk')
        ->select('p.project_title', 'b.data_content_name', 'p.id')
        ->where('pu.member_id', '=', $userId)
        ->where('p.flg','=', 0)
        ->where('b.data_title_code', '=', 3)
        ->orderBy('p.created_at', 'asc')
        ->get();

        $project1title = DB::table('projects as p')
        ->join('project_users as pu', 'p.id','=','pu.project_id')
        ->join('basedata as b', 'b.data_content_code', '=', 'p.color_code_pk')
        ->select('p.project_title', 'b.data_content_name', 'p.id')
        ->where('pu.member_id', '=', $userId)
        ->where('p.flg','=', 1)
        ->where('b.data_title_code', '=', 3)
        ->orderBy('p.created_at', 'asc')
        ->get();

        $color_code = DB::table('projects as pj')
                        ->join('basedata as bd','bd.data_content_code','pj.color_code_pk')
                        ->select('pj.id', 'bd.data_content_name')
                        ->where('pj.id',$result->id)
                        ->where('bd.data_title_code','3')
                        ->whereNull('pj.deleted_at')
                        ->get();
        // dd($color_code);

        // dday 호출
        foreach ($result as $items) {
          $start = Carbon::create($result['start_date']);
          $end = Carbon::create($result['end_date']);
          $result['dday'] = $start->diffInDays($end); // data에 dday 추가
        }

        $data = [];
        // 프로젝트와 업무들을 모두 호출 (나중에 조건 추가가능, 허나 정렬은 여기서 못함, TODO: project_id와 task_parent의 관계성 정해야 함)
        $data['project'] = Project::find($id);
        $depth_0 = Task::depth_pj(0,$id); // 모델에서 만들어 놓은 쿼리로 하위 업무 각자 가져옴
        // $data = $depth_0;
        foreach ($depth_0 as $key => $value) {            
            $value->depth_1 = Task::depth_tsk(1,$value->id);
        }
        $data['task'] = $depth_0;
        // dd($data);
        // dd($data['task'][0]->id);
        return view('ganttchart')->with('data', $data)
        ->with('user', Session::get('user'))
        ->with('project0title',$project0title)
        ->with('project1title',$project1title)
        // ->with('project_id', $project_id)
        ->with('color_code',$color_code)
        ->with('result',$result);
    }

    // 상세 업무/공지 조회
    public function view($id)
    {
        $result['task'] = Task::task_detail($id);
        // Log::debug($result);
        $result['children'] = Task::task_detail_children($id);
        $result['comment'] = Task::task_detail_comment($id);

        // task->depth 값을 보고 부모를 데려올지 결정
        return $result;
        if ($result['task'][0]->task_depth !== '0') {
            $result['parents'] = Task::task_detail_parents($result['task'][0]->task_depth, $id);
        }

        if(Auth::check()) {
            return view('ganttchart')
            ->with('data',$result)
            ->with('user', Session::get('user'))
            ->with('color_code',$color_code)
            ->with('user_data',$user_data)
            ->with('userflg0',$userflg0)
            ->with('userflg1',$userflg1);
        } else {
            return redirect('/user/login');
        }   
    }
    
    
    // 간트차트 전체화면 출력
//     public function ganttindex()
// {
//         // $id = project_id;
//         // $result = Project::find($id);
//         $user = Auth::user();

//         $user_data = project::where('user_pk',$user->id)
//         ->select('id'
//                 ,'user_pk'
//                 ,'color_code_pk'
//                 ,'project_title'
//                 ,'project_content'
//                 ,'start_date'
//                 ,'end_date'
//                 ,'created_at'
//                 ,'flg'
//                 )
//         ->get();

//         // 대표 레이아웃 사이드바 생성
//         $userflg0=[];
//         $userflg1=[];
//         foreach ($user_data as $items) {
//         if ($items->flg == '0'){
//         array_push($userflg0,$items);
//         } elseif ($items->flg == '1'){
//         array_push($userflg1,$items);
//         }
//         }
//         // dd($userflg0);
        
//         $color_code = DB::table('basedata')
//         ->join('projects','color_code_pk','=','data_content_code')
//         ->select('data_content_name')
//         ->where('data_title_code','=','3')
//         ->where('projects.user_pk','=',$user->id)
//         ->first();

//         $result = DB::select("
//             SELECT
//                 tks.id
//                 ,tks.project_id
//                 ,pj.project_title
//                 ,tks.task_responsible_id
//                 ,us.name
//                 ,tks.task_status_id
//                 ,(SELECT bs1.data_content_name FROM basedata bs1 WHERE bs1.data_title_code = '0' AND tks.task_status_id = bs1.data_content_code) task_status_name
//                 ,tks.priority_id
//                 ,(SELECT bs2.data_content_name FROM basedata bs2 WHERE bs2.data_title_code = '1' AND tks.priority_id = bs2.data_content_code) priority_name
//                 ,tks.category_id
//                 ,(SELECT bs3.data_content_name FROM basedata bs3 WHERE bs3.data_title_code = '2' AND tks.category_id = bs3.data_content_code) category_name
//                 ,tks.task_parent
//                 ,tks.task_depth
//                 ,tks.title
//                 ,tks.start_date
//                 ,tks.end_date
//             FROM tasks tks
//                 LEFT JOIN users us
//                 ON tks.task_responsible_id = us.id
//                 LEFT JOIN projects pj
//                 ON tks.project_id = pj.id
//             WHERE tks.deleted_at IS NULL    
            
            
//         ");

//         // $result['count']=count($result);
//         // dd($result);

//         if(Auth::check()) {
//             return view('ganttchart')
//             ->with('data',$result)
//             ->with('user', Session::get('user'))
//             ->with('color_code',$color_code)
//             ->with('user_data',$user_data)
//             ->with('userflg0',$userflg0)
//             ->with('userflg1',$userflg1);
//         } else {
//             return redirect('/user/login');
//         }
//     }        

    // 간트차트 업무 작성
    // public function ganttstore(Request $request)
    // {
    //     $responseData = [
    //         "code" => "0",
    //         "msg" => "",
    //         "data" => []
    //     ];
    //     // Log::debug('cookie: '.$request->cookie('user'));
    //     // Log::debug('Auth: '. Auth::id());
    //     $sta = DB::table('basedata')->where('data_title_code',0)->where('data_content_name', $request['task_status_id'])->first();
    //     $pri = DB::table('basedata')->where('data_title_code',1)->where('data_content_name', $request['priority_id'])->first();
    //     $res = DB::table('users')->where('name', $request['task_responsible_id'])->first();
    //     // $eml = DB::table('users')->where('email', $request['email'])->first();
    //     if($request['start_date'] === '시작일') {
    //         $start = null;
    //     } else {
    //         $start = $request['start_date'];
    //     }
    //     if($request['end_date'] === '마감일') {
    //         $end = null;
    //     } else {
    //         $end = $request['end_date'];
    //     }
    //     $tit = $request['title']; // TODO: 유효성 처리 추가
    //     $con = $request['content']; // TODO: 유효성 처리 추가

    //     $request['title'] = $tit;
    //     $request['content'] = $con;
    //     // $request['project_id'] = $con;
    //     $request['task_status_id'] = $sta->data_content_code;
    //     // $request['task_responsible_id'] = $res->id;
    //     $request['start_date'] = $start;
    //     $request['end_date'] = $end;
    //     $request['priority_id'] = $pri->data_content_code;

    //     // Log::debug($request);
    //     $result = Task::create($request->data);
    //     $responseData['msg'] = 'task created.';
    //     $responseData['data'] = $result;

    //     return $responseData;

    // }

    // 간트차트 업무 수정
    // public function ganttUpdate(Request $request)
    // {
    //     Log::debug("**** ganttupdate Start ****");
    //     dd($request);
    //     $responseData = [
    //         "code" => "0",
    //         "msg" => "",
    //         "data" => []
    //     ];
    //     $result = Task::find($id);

    //     if (!$result) {
    //         $responseData["code"] = "E01";
    //         $responseData["msg"] = "No Data.";
    //     } else {
    //         $res = User::where('name', $request['task_responsible_id'])->first();
    //         $sta = DB::table('basedata')->where('data_content_name', $request['task_status_id'])->first();
    //         $pri = DB::table('basedata')->where('data_content_name', $request['priority_id'])->first();

    //         Log::debug('$request :'.$request);
    //         Log::debug('$res :'.$res->id);

    //         $result->task_responsible_id = $res->id;
    //         $result->task_status_id = $sta->id;
    //         $result->priority_id = $pri->id;

    //         Log::debug('$request->title :'.$request->title);

    //         $result->title = $request->title;
    //         // Log::debug('$request->content :'.$request->content);
    //         // $result->content = $request->content;

    //         Log::debug('$request->start_date :'.$request->start_date);
            
    //         if($request->start_date !== '시작일'){
    //             $result->start_date = $request->start_date;
    //             Log::debug('$result->start_date :'.$result->start_date);
    //         }
    //         Log::debug($request->end_date);
    //         if($request->end_date !== '마감일'){
    //             $result->end_date = $request->end_date;
    //             Log::debug('$result->end_date :'.$result->end_date);
    //         }
    //         $result->save();

    //         $responseData['data'] = $result;
    //     }
    //     Log::debug("**** ganttupdate End ****");
    //     return $responseData;
    // }

}
