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
        $project = Project::project_depth();
        $depth_0 = Task::depth(0); // 모델에서 만들어 놓은 쿼리로 하위 업무 각자 가져옴
        $depth_1 = Task::depth(1);
        // $depth_2 = Task::depth(2);
        // 변수에 프로젝트와 하위 업무들을 다차원으로 합친다
        $data = [];
        foreach ($project as $value_pj) {
            foreach ($depth_0 as $value_0) { // 위에꺼랑 속도 테스트 필요
                if ($value_pj->id === $value_0->project_id) {
                    $value_pj->depth_0[] = $value_0;
                    foreach ($depth_1 as $value_1) {
                        if ($value_0->id === $value_1->task_parent) {
                            $value_0->depth_1[] = $value_1;
                            $data[$value_pj->id] = $value_pj;
                            // foreach ($depth_2 as $key_2 => $value_2) {
                            //     if($value_1->id === $value_2->task_parent){
                            //         $value_1->depth_2[] = $value_2;
                            // $data[$value_pj->id] = $value_pj;
                            //     }
                            // }
                        }
                    }
                }
            }
        }
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
        return view('modal/modaltest')->with('data', $data)->with('user', Session::get('user'));
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

    public function store(Request $request, $id)
    {
        // $responseData = [
        //     "code" => "0",
        //     "msg" => "",
        //     "data" => []
        // ];

        // // $result = Item::create($request->data);
        // // $request->content; 
        // // <php 원래 php만으로는 일케 햇다
        // // $url = 'https://jsonplaceholder.typicode.com/posts/1';
        // // $json = file_get_contents($url);
        // // $jo = json_decode($json);
        // // echo $jo->title;
        // // $responseData['data'] = $result;

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
            // Log::debug('$res :'.$res);
            // Log::debug($request['task_status_id']);
            // Log::debug('$request->task_status_id :'.json_decode($request->task_status_id));
            // Log::debug('json_decode($request->task_status_id) :'.json_decode($request->task_status_id));
            $sta = DB::table('basedata')->where('data_content_name', $request['task_status_id'])->first();
            $pri = DB::table('basedata')->where('data_content_name', $request['priority_id'])->first();
            // Log::debug($pri);

            // $result->project_id = $request->data['completed'];
            Log::debug('$res :'.$res->id);
            $result->task_responsible_id = $res->id;
            // $result->task_writer_id = $request->data['completed'];
            $result->task_status_id = $sta->id;
            // Log::debug($sta->id);
            $result->priority_id = $pri->id;
            // Log::debug($pri->id);
            // $result->category_id = $request->data['completed'];
            // $result->task_number = $request->data['completed'];
            // $result->task_parent = $request->data['completed'];
            // $result->task_depth = $request->data['completed'];
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
            // $result->updated_at = $request->data['completed'] === '1' ? Carbon::now() : null;
            $result->save();

            $responseData['data'] = $result;
        }

        return $responseData;
    }
    public function delete(Request $request, $id)
    {
        // $responseData = [
        //     "code" => "0",
        //     "msg" => ""
        // ];

        // $result = Item::find($id);

        // if (!$result) {
        //     $responseData['code'] = 'E01';
        //     $responseData['msg'] = 'No Data.';
        // } else {
        //     $result->delete();
        // }

        // return $responseData;
    }
}
