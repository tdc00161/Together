<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\Task;
use App\Models\User;
use App\Models\BaseData;
use App\Models\Friendlist;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

use Carbon\Carbon;

class ProjectController extends Controller
{
    public function tableget() {
        // dd($user_id);
        return view('project_create');
    }

    public function maincreate(Request $request) {

        $data= $request
                ->only('user_pk','color_code_pk','project_title', 'project_content', 'flg', 'start_date', 'end_date');
        
        // user_id (session 에 저장된 값 호출)
        $user_id = Session::get('user')->only('id');
        // $user_id = 171;
        // dd($user_id);
        
        $data['user_pk'] = $user_id['id'];

         // color_code 랜덤 호출   
        $data['color_code_pk'] = (string)rand(0,4);
        // dd($data);
        // foreach ($color_code as $items) {
        //   $data['color_code_pk'] = $items->data_content_code; //
        // }

        // dd($data);

        // dd($project_title);
        // $project_content = $request->project_content');
        // $start_date = $request->input('start_date');
        // $end_date = $request->input('end_date');

        $result = Project::create($data);
        // dd($result);

        if ($result->flg == '0'){
          return redirect()->route('individual.get',['id' => $result['id']]);
        } elseif ($result->flg == '1'){
          return redirect()->route('team.get',['id' => $result['id']]);
        }

        return '다시 확인해주세요';

    }


    public function mainshow(Request $request, $id) {
        dump($id);
        dump($request);
      // find -> pk 호출만 가능
        // $user_pk = project::where('user_pk', $user_pk)
        //         -> get();

        $result = project::find($id);

        $user_id = Session::get('user')->only('id');

        $user_data = project::where('user_pk',$user_id)
                    ->get();
        // dd($user_data);
        // dd($user_data);
        // if ($user_data->flg == '0'){
        //   return view('individual.get',['id' => $user_data['id']]);
        // } elseif ($user_data->flg == '1'){
        //   return view('team.get',['id' => $user_data['id']]);
        // }
        dump($user_data);

        $color_code = DB::table('basedata')
                        ->join('projects','color_code_pk','=','data_content_code')
                        ->select('data_content_name')
                        ->where('data_title_code','=','3')
                        ->where('projects.user_pk','=',$user_id)
                        ->first();
        dump($color_code);


        // dday 호출
        foreach ($result as $items) {
          $start = Carbon::create($result['start_date']);
          $end = Carbon::create($result['end_date']);
          // $dday[] = $start->diffInDays($end);
          $result['dday'] = $start->diffInDays($end); // data에 dday 추가
        }

        // dd($result);

        $tkdata = DB::table('projects')
                      -> select('projects.id',
                                'tasks.id',
                                'projects.user_pk',
                                'tasks.project_id',
                                'tasks.task_responsible_id',
                                'tasks.title',
                                'tasks.content',
                                'tasks.category_id',
                                'tasks.start_date',
                                'tasks.end_date',
                                'base1.data_content_name as status_name',
                                'base2.data_content_name as category_name',
                                )
                      ->join('tasks', function($join) {
                        $join->on('tasks.project_id','=','projects.user_pk');
                      })
                      ->join('basedata as base1', function($base1){
                        $base1->on('base1.data_content_code','=','tasks.task_status_id');
                      })
                      ->join('basedata as base2', function($base2){
                        $base2->on('base2.data_content_code','=','tasks.category_id');
                      })
                      ->where('projects.id', '=', $id)
                      ->where('base1.data_title_code', '=', '0')
                      ->where('base2.data_title_code', '=', '2')
                      ->orderby('projects.id','desc')
                      -> get();
        dump($tkdata);

        // 업무 시작/마감일자 d-day 설정
        foreach ($tkdata as $items) {
          $start = Carbon::create($items->start_date);
          $end = Carbon::create($items->end_date);
          // $dday[] = $start->diffInDays($end);
          $items->dday = $start->diffInDays($end); // tkdata에 dday 추가
        }

        // dd($tkdata);
        // dd($id);
        $before = DB::table('tasks')
                     ->selectRaw('count(project_id) as cnt')
                     ->where('task_status_id',0)
                     ->groupBy('project_id')
                     ->having('project_id',$user_id)
                     ->get();

        $ing = DB::table('tasks')
                  ->selectRaw('count(project_id) as cnt')
                  ->where('task_status_id',1)
                  ->groupBy('project_id')
                  ->having('project_id',$user_id)
                  ->get();

        $feedback = DB::table('tasks')
                       ->selectRaw('count(project_id) as cnt')
                       ->where('task_status_id',2)
                       ->groupBy('project_id')
                       ->having('project_id',$user_id)
                       ->first();
        // dd($feedback);
        $complete =  DB::table('tasks')
                        ->selectRaw('count(project_id) as cnt')
                        ->where('task_status_id',3)
                        ->groupBy('project_id')
                        ->having('project_id',$user_id)
                        ->get();

        // return view('project_individual',compact('before','ing','feedback','complete'))
        // ->with('before',$before)
        // ->with('ing',$ing)
        // ->with('feedback',$feedback)
        // ->with('complete',$complete)
        return view('project_individual')
        ->with('color_code',$color_code)
        ->with('user_data',$user_data)
        ->with('result',$result)
        ->with('data',$tkdata);
    }

    // 프로젝트 데이터 + 컬러
    public function project_select($id)
    {
        $responseData = [
            "code" => "0",
            "msg" => "",
            "data" => ""
        ];
        $dataContent = DB::select(
            "SELECT
                pj.*
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

    // 프로젝트 참여자 조회
    public function project_user_select($id)
    {
        $responseData = [
            "code" => "0",
            "msg" => "",
            "data" => ""
        ];
        $dataContent = DB::select(
            "SELECT
                pj.*
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


