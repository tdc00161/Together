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

class TaskController extends Controller
{
    public function showdashboard()
    {

        $user = Auth::user();
        $now = Carbon::now();
        $koreanDayOfWeek = $now->isoFormat('dddd');

        $formatDate1 = $now->format('Y년 n월 j일');
        // $formatDate2 = $now->format('G시 i분');

        if (Auth::check()) {
            return view('dashboard', [
                'user' => $user,
                'formatDate1' => $formatDate1,
                // 'formatDate2' => $formatDate2,
                'koreanDayOfWeek' => $koreanDayOfWeek,
            ]);
        } else {
            return redirect('/user/login');
        }
    }

    public function showheader()
    {

        $user = Auth::user();

        if (Auth::check()) {
            return view('layout', [
                'user' => $user,
            ]);
        } else {
            return redirect('/user/login');
        }
    }

    // 태스크 전체 조회 (수정이전)
    public function index()
    {
        // 프로젝트와 업무들을 모두 호출 (나중에 조건 추가가능, 허나 정렬은 여기서 못함, TODO: project_id와 task_parent의 관계성 정해야 함)
        // $project = Project::project_depth();
        // $depth_0 = Task::depth(0); // 모델에서 만들어 놓은 쿼리로 하위 업무 각자 가져옴
        // $depth_1 = Task::depth(1);
        // // 변수에 프로젝트와 하위 업무들을 다차원으로 합친다
        // $data = [];
        // foreach ($project as $value_pj) {
        //     foreach ($depth_0 as $value_0) { // 위에꺼랑 속도 테스트 필요
        //         if ($value_pj->id === $value_0->project_id) {
        //             $value_pj->depth_0[] = $value_0;
        //             foreach ($depth_1 as $value_1) {
        //                 if ($value_0->id === $value_1->task_parent) {
        //                     $value_0->depth_1[] = $value_1;
        //                 }
        //                 $data[$value_pj->id] = $value_pj;
        //             }
        //             $data[$value_pj->id] = $value_pj;
        //         }
        //     }
        // }
        $result = DB::select("
            SELECT
                tks.id
                ,tks.project_id
                ,pj.project_title
                ,tks.task_responsible_id
                ,us.name                
                ,tks.task_status_id
                ,(SELECT bs1.data_content_name FROM basedata bs1 WHERE bs1.data_title_code = '0' AND tks.task_status_id = bs1.data_content_code) task_status_name
                ,tks.priority_id
                ,(SELECT bs2.data_content_name FROM basedata bs2 WHERE bs2.data_title_code = '1' AND tks.priority_id = bs2.data_content_code) priority_name
                ,tks.category_id
                ,(SELECT bs3.data_content_name FROM basedata bs3 WHERE bs3.data_title_code = '2' AND tks.category_id = bs3.data_content_code) category_name
                ,tks.task_parent
                ,tks.task_depth
                ,tks.title
                ,tks.start_date
                ,tks.end_date
            FROM tasks tks
                LEFT JOIN users us
                ON tks.task_responsible_id = us.id
                LEFT JOIN projects pj
                ON tks.project_id = pj.id
            WHERE tks.deleted_at IS NULL
            
            
        ");
        // return $depth_1;
        // dd($data);  
        // 정렬 (data배열의 값에 상응하는 key값을 따로 변수로 선언해, (0 => title_6, 1 => title_9 ...)
        //     그 변수를 정렬하고 (4 => title_1, 6 => title_2, ...) 그 정렬 순으로 data[4], data[6], ... data값과 키를 이용해 부를 예정)

        // 정렬하고 싶은 값을 빼온다
        // foreach ($data as $key => $item) {
        //     $sort[$key] = $item['project']->project_title;
        // }

        // // asort로 키값과 value를 정렬
        // asort($sort);

        // // data에 정렬된 배열 key값대로 변경
        // foreach ($sort as $key => $item) {
        //     $sorted_data[] = $data[$key]; // 배열로 넣어서 자동으로 배열 뒤로 들어가게
        // }
        return view('modal.modalgantt')->with('data', $result)->with('user', Session::get('user'));
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

        return $result;
    }

    // 업무 작성
    public function store(Request $request)
    {
        // 반환 틀
        $responseData = [
            "code" => "0",
            "msg" => "",
            "data" => []
        ];

        // 입력받은 데이터로 pk(id) 추출
        // Log::debug('cookie: '.$request->cookie('user'));
        // Log::debug('Auth: '. Auth::id());
        $sta = DB::table('basedata as status')
            ->where('data_title_code', 0)
            ->where('data_content_name', $request['task_status_id'])
            ->select('data_content_code','data_content_name')
            ->get();
        Log::debug('상태: ' . $sta);
        $pri = DB::table('basedata')
            ->where('data_title_code', 1)
            ->where('data_content_name', $request['priority_id'])
            ->select('data_content_code','data_content_name')
            ->get();
        Log::debug('순위: ' . $pri);
        $res = DB::table('users')
            ->where('name', $request['task_responsible_id'])
            ->select('id','name')
            ->get();
        Log::debug('user_id: ' . $res);
        $tsk_num = DB::table('tasks')
            ->where('project_id', $request['project_id'])
            ->count();
        Log::debug('$tsk_num: ' . $tsk_num);

        // 이메일 추가 시 대비
        // $eml = DB::table('users')->where('email', $request['email'])->first();
        
        // 입력 컨텐츠 유효성 검사
        // $tit = $request['title']; // TODO: 유효성 처리 추가
        // $con = $request['content']; // TODO: 유효성 처리 추가
        // $request['title'] = $tit;
        // $request['content'] = $con;

        // nullable
        if(!empty($sta[0])){
            $request['task_status_id'] = $sta[0]->data_content_code;
            $responseData['names']['task_status_name'] = $sta[0]->data_content_name;
        } else {
            $request['task_status_name'] = null;
        }
        if(!empty($res[0])){
            $request['task_responsible_id'] = $res[0]->id;
            $responseData['names']['task_responsible_name'] = $res[0]->name;
        } else {
            $request['task_responsible_name'] = null;
        }
        if(!empty($pri[0])){
            $request['priority_id'] = $pri[0]->data_content_code;
            $responseData['names']['priority_name'] = $pri[0]->data_content_name;
        } else {
            $request['priority_name'] = null;
        }

        // not null
        $nowUser = Auth::id();
        $request['task_writer_id'] = $nowUser;
        $request['category_id'] = $nowUser;
        $request['task_number'] = $tsk_num + 1;
        $request['test'] = '갱신 체크 1319';
        
        // $request['start_date'] = $start;
        // $request['end_date'] = $end;
        Log::debug($request);

        // 업무 생성 및 반환 분기
        $result = Task::create($request->toArray());
        if (!$result) {
            $responseData['msg'] = 'task not created.';
            $responseData['data'] = $result;
        } else {
            $responseData['msg'] = 'task created.';
            $responseData['data'] = $result;
        }

        return $responseData;
    }

    // 업무 수정
    public function update(Request $request, $id)
    {
        $responseData = [
            "code" => "0",
            "msg" => "",
            "data" => []
        ];

        // $result = Task::find($id);
        Log::debug('$request :' . $request);
        // Log::debug($result->data);

        // if (!$result) {
        //     $responseData["code"] = "E01";
        //     $responseData["msg"] = "No Data.";
        // } else {
        //     $res = User::where('name', $request['task_responsible_id'])->first();
        //     $sta = DB::table('basedata')->where('data_title_code',0)->where('data_content_name', $request['task_status_id'])->first();
        //     $pri = DB::table('basedata')->where('data_title_code',1)->where('data_content_name', $request['priority_id'])->first();
        //     Log::debug('$request :' . $request);
        //     Log::debug('$res :' . $res->data_content_code);
        //     Log::debug('$sta :' . $sta->data_content_code);
        //     $result->task_responsible_id = $res->data_content_code;
        //     $result->task_status_id = $sta->data_content_code;
        //     $result->priority_id = $pri->id;
        //     Log::debug('$request->title :' . $request->title);
        //     $result->title = $request->title;
        //     Log::debug('$request->content :' . $request->content);
        //     $result->content = $request->content;
        //     Log::debug('$request->start_date :' . $request->start_date);
        //     if ($request->start_date !== '시작일') {
        //         $result->start_date = $request->start_date;
        //         Log::debug('$result->start_date :' . $result->start_date);
        //     }
        //     Log::debug($request->end_date);
        //     if ($request->end_date !== '마감일') {
        //         $result->end_date = $request->end_date;
        //         Log::debug('$result->end_date :' . $result->end_date);
        //     }
        //     $result->save();

        //     $responseData["code"] = "U01";
        //     $responseData["msg"] = $id." updated";
        //     $responseData['data'] = $result;
        // }

        // return $responseData;
    }
    // 업무 수정 간트버전
    public function ganttUpdate(Request $request, $id)
    {
        $responseData = [
            "code" => "E01",
            "msg" => "no data"
        ];
        
        Log::debug('---------------------------------------'.$id);
        $result = Task::find($id);
        Log::debug('$request :' . $request);
        Log::debug('$result :' . $result);
        foreach ($request->value as $key => $updatedData) {
            if($updatedData != ''){
                Log::debug($updatedData.": 들어온 ".$key."값입니다");
                Log::debug($result->$key.'안에 값이 있습니다');
                $result->$key = $updatedData;
                $result->save();

                $responseData["code"] = "U01";
                $responseData["msg"] = $id." updated";
                $responseData['data'] = $result;
            }
        }


        return $responseData;
    }

    // 업무 삭제
    public function delete(Request $request, $id)
    {
        $responseData = [
            "code" => "0",
            "msg" => ""
        ];
        
        $result = Task::where('id', $id)->delete();

        if (!$result) {
            $responseData['code'] = 'E01';
            $responseData['msg'] = $id . ' is no where';
        } else {
            $responseData['code'] = 'D01';
            $responseData['msg'] = 'task : ' . $id . '->deleted.';
        }

        return $responseData;
    }
}

