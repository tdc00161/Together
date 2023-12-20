<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Task;
use App\Models\BaseData;
use App\Models\Project;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;

class TestController extends Controller
{
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

    public function view($id)
    {
        $result['task'] = Task::task_detail($id);
        $result['children'] = Task::task_detail_children($id);
        $result['comment'] = Task::task_detail_comment($id);

        // task->depth 값을 보고 부모를 데려올지 결정
        if ($result['task'][0]->task_depth !== '0') {
            $result['parents'] = Task::task_detail_parents($result['task'][0]->task_depth, $id);
        }

        return $result;
    }

    public function store(Request $request)
    {
        $responseData = [
            "code" => "0",
            "msg" => "",
            "data" => []
        ];
        
        // Log::debug($request->data['title']);
        // $request->data['task_writer_id'] = Session::get('user')->id;
        Log::debug(['세션',session('user')]);
        // $result = Task::create($request->data);
        // $responseData['msg'] = 'task created.';
        // $responseData['data'] = $result;

        // return $responseData;
    }
    public function update(Request $request, $id)
    {
        $responseData = [
            "code" => "0",
            "msg" => "",
            "data" => []
        ];

        $result = Task::find($id);

        if (!$result) {
            $responseData["code"] = "E01";
            $responseData["msg"] = "No Data.";
        } else {
            $res = User::where('name', $request['task_responsible_id'])->first();
            $sta = DB::table('basedata')->where('data_content_name', $request['task_status_id'])->first();
            $pri = DB::table('basedata')->where('data_content_name', $request['priority_id'])->first();
            Log::debug('$request :'.$request);
            Log::debug('$res :'.$res->id);
            $result->task_responsible_id = $res->id;
            $result->task_status_id = $sta->id;
            $result->priority_id = $pri->id;
            Log::debug('$request->title :'.$request->title);
            $result->title = $request->title;
            Log::debug('$request->content :'.$request->content);
            $result->content = $request->content;
            Log::debug('$request->start_date :'.$request->start_date);
            if($request->start_date !== '시작일'){
                $result->start_date = $request->start_date;
                Log::debug('$result->start_date :'.$result->start_date);
            }
            Log::debug($request->end_date);
            if($request->end_date !== '마감일'){
                $result->end_date = $request->end_date;
                Log::debug('$result->end_date :'.$result->end_date);
            }
            $result->save();

            $responseData['data'] = $result;
        }

        return $responseData;
    }
    public function delete(Request $request, $id)
    {
        $responseData = [
            "code" => "0",
            "msg" => ""
        ];

        // Log::debug('$id: '.$id);
        // $record = DB::select(
        //     "SELECT
        //         *
        //     FROM
        //         tasks
        //     WHERE
        //         id = ". $id
        // );
        // Log::debug('DB: '.$record[0]->id);
        $result = DB::table('tasks')->where('id',$id);
        if (!$result) {
            $responseData['code'] = 'E01';
            $responseData['msg'] = $id.' is no where';
        } else {
            $result->delete();
            $responseData['code'] = 'D01';
            $responseData['msg'] = $id.'->deleted.';
        }

        return $responseData;
    }

    public function project_color($id)
    {
        $responseData = [
            "code" => "0",
            "msg" => "",
            "data" => ""
        ];
        $dataContent = DB::select(
            "SELECT
                pj.id
                ,pj.project_title
                ,pj.color_code_pk
                ,bd.data_content_name
            FROM
                projects pj
                JOIN basedata bd
                  ON bd.data_content_code = pj.color_code_pk
                 AND bd.data_title_code = 3
            WHERE
                pj.id = ".$id
        );
        if (!$dataContent) {
            $responseData['code'] = 'E01';
            $responseData['msg'] = $id.' is no where';
        } else {
            $responseData['code'] = 'D01';
            $responseData['msg'] = 'project_color come';
            $responseData['data'] = $dataContent;
        }
        return $responseData;
    }
}
