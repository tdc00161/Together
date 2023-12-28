<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\Task;
use App\Models\User;
use App\Models\BaseData;
use App\Models\Friendlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\style;

use Carbon\Carbon;

class ProjectController extends Controller
{
    public function tableget() {
        // dd($user_id);
        if (Auth::check()) {
          return view('project_create');
        } else {
            return redirect('/user/login');
        }

    }

    public function maincreate(Request $request) {

      // 프로젝트 생성
        $data= $request
                ->only('user_pk','color_code_pk','project_title', 'project_content', 'flg', 'start_date', 'end_date');
        
        $user_id = Auth::id();
        
        $data['user_pk'] = $user_id;

         // color_code 랜덤 호출   
        $data['color_code_pk'] = (string)rand(0,4);

        $result = Project::create($data);
        // dd($result);

        //본인이 프로젝트 생성시 구성원으로 추가
        $user_id = Auth::id();

        $data2= $request
                 ->only('project_id','authority_id','member_id','created_at');

        $data2['project_id'] = $result->id;
        $data2['authority_id'] = $user_id;
        $data2['member_id'] = $user_id;

        $data2result = ProjectUser::create($data2);

        // dd($result);
        if (Auth::check()) {
          if ($result->flg == '0'){
            return redirect()->route('individual.get',['id' => $result['id']]);
          } elseif ($result->flg == '1'){
            return redirect()->route('team.get',['id' => $result['id']]);
          };
        } else {
            return redirect('/user/login');
        }
    }


    public function mainshow(Request $request, $id) {

        $result = project::find($id);
        // dd($result);

        $user = Auth::user();
        // dd($user);

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

        // 프로젝트 상태갯수
        $before =DB::table('tasks')
                    ->selectRaw('count(task_status_id) as cnt')
                    ->where('project_id',$id)
                    ->where('category_id',0)
                    ->where('task_status_id',0)
                    ->groupBy('task_status_id')
                    ->get();
                    // dd($before);

        $ing =DB::table('tasks')
                ->selectRaw('count(task_status_id) as cnt')
                ->where('project_id',$id)
                ->where('category_id',0)
                ->where('task_status_id',1)
                ->groupBy('task_status_id')
                ->get();

        $feedback =DB::table('tasks')
                    ->selectRaw('count(task_status_id) as cnt')
                    ->where('project_id',$id)
                    ->where('category_id',0)
                    ->where('task_status_id',2)
                    ->groupBy('task_status_id')
                    ->get();

        $complete =DB::table('tasks')
                    ->selectRaw('count(task_status_id) as cnt')
                    ->where('project_id',$id)
                    ->where('category_id',0)
                    ->where('task_status_id',3)
                    ->groupBy('task_status_id')
                    ->get();

        //데이터 담을 빈 객체 생성
        $baseObj = new \stdClass();
        $baseObj->cnt = 0;
        $statuslist = [
          'before'=> count($before) === 0 ? collect([$baseObj]) : $before,
          'ing'=> count($ing) === 0 ? collect([$baseObj]) : $ing,
          'feedback'=> count($feedback) === 0 ? collect([$baseObj]) : $feedback,
          'complete'=> count($complete) === 0 ? collect([$baseObj]) : $complete
        ];
        // dd($statuslist);

        // 공지
        $first_data = DB::table('tasks as tk')
                        ->join('projects as pj','pj.id','tk.project_id')
                        ->select('tk.id','tk.title','tk.created_at')
                        ->whereNull('tk.deleted_at')
                        ->where('tk.project_id',$result->id)
                        ->where('tk.category_id','1')
                        ->orderBy('tk.created_at','desc')
                        ->get();
        // dump($first_data);

        // 업데이트 내역
        $update_data = DB::table('tasks as tk')
                        ->join('projects as pj','pj.id','tk.project_id')
                        ->join('basedata as bd','bd.data_content_code','tk.category_id')
                        ->select('tk.id','tk.title','tk.updated_at','tk.category_id','bd.data_content_name')
                        ->whereNull('tk.deleted_at')
                        ->where('bd.data_title_code','2')
                        ->where('tk.project_id',$result->id)
                        ->orderBy('tk.updated_at','desc')
                        ->get();
        // dump($update_data);

        // 마감기한 내역
        $deadline_data = DB::table('tasks as tk')
                        ->join('projects as pj','pj.id','tk.project_id')
                        ->join('basedata as bd','bd.data_content_code','tk.category_id')
                        ->join('users as us','us.id','pj.user_pk')
                        ->select('tk.id'
                                ,'tk.title'
                                ,'tk.task_responsible_id'
                                ,'us.name'
                                ,'tk.task_status_id'
                                ,'bd.data_content_name'
                                , DB::raw('tk.end_date - tk.start_date as dday'))
                                ->whereNull('tk.deleted_at')
                        ->where('tk.category_id','0')
                        ->where('bd.data_title_code','0')
                        ->where('tk.project_id',$result->id)
                        ->orderBy('dday','desc')
                        ->get();
        // dd($deadline_data);


        // (jueunyang08) 사이드바 출력
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

        // (jueunyang08) 프로젝트 구성원 출력
        $projectmemberdata = DB::table('project_users as p')
        ->join('users as u', 'u.id', '=', 'p.member_id')
        ->select('p.project_id', 'u.name', 'p.member_id')
        ->where('p.project_id', '=', $id)
        ->orderBy('p.created_at','asc')
        ->get();

        // return view('project_individual')
        // ->with('color_code',$color_code)
        // ->with('result',$result)
        // ->with('first_data',$first_data)
        // ->with('update_data',$update_data)
        // ->with('deadline_data',$deadline_data)
        // ->with('statuslist',$statuslist)
        // ->with('user',Auth::id())
        // ->with('project0title', $project0title)
        // ->with('project1title', $project1title)
        // ->with('projectmemberdata',$projectmemberdata); // (jueunyang08) 프로젝트 구성원 출력
        if (Auth::check()) {
            return view('project_individual')
            ->with('color_code',$color_code)
            ->with('result',$result)
            ->with('first_data',$first_data)
            ->with('update_data',$update_data)
            ->with('deadline_data',$deadline_data)
            ->with('statuslist',$statuslist)
            ->with('user',Auth::id())
            ->with('project0title', $project0title)
            ->with('project1title', $project1title)
            ->with('projectmemberdata',$projectmemberdata); // (jueunyang08) 프로젝트 구성원 출력
      } else {
          return redirect('/user/login');
      }
    }


    public function project_graph_data(Request $request, $id) {

      $user_id = Auth::id();

      $before =DB::table('tasks')
                  ->selectRaw('count(task_status_id) as cnt')
                  ->where('project_id',$id)
                  ->where('task_status_id',0)
                  ->groupBy('task_status_id')
                  ->get();

      $ing =DB::table('tasks')
              ->selectRaw('count(task_status_id) as cnt')
              ->where('task_status_id',1)
              ->where('project_id',$id)
              ->groupBy('tasks.task_status_id')
              ->get();

      $feedback =DB::table('tasks')
                    ->selectRaw('count(task_status_id) as cnt')
                    ->where('task_status_id',2)
                    ->where('project_id',$id)
                    ->groupBy('tasks.task_status_id')
                    ->get();

      $complete =DB::table('tasks')
                  ->selectRaw('count(task_status_id) as cnt')
                  ->where('task_status_id',3)
                  ->where('project_id',$id)
                  ->groupBy('tasks.task_status_id')
                  ->get();

      //데이터 담을 빈 객체 생성
      $baseObj = new \stdClass();
      $baseObj->cnt = 0;
      $statuslist = [
        'before'=> count($before) === 0 ? collect([$baseObj]) : $before,
        'ing'=> count($ing) === 0 ? collect([$baseObj]) : $ing,
        'feedback'=> count($feedback) === 0 ? collect([$baseObj]) : $feedback,
        'complete'=> count($complete) === 0 ? collect([$baseObj]) : $complete
      ];

      return response()->json($statuslist);
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
                pj_usr.*
                ,usr.name member_name
                ,pj.project_title
                ,bd.data_content_name authority_name
            FROM
                project_users pj_usr
              JOIN users usr
                ON usr.id = pj_usr.member_id
              JOIN projects pj
                ON pj.id = pj_usr.project_id
              JOIN basedata bd
                ON bd.data_content_code = pj_usr.authority_id
               AND bd.data_title_code = 4
            WHERE
                pj_usr.project_id = ".$id
        );
        Log::debug($dataContent);
        Log::debug(!$dataContent);
        if (!$dataContent) {
          $responseData['code'] = 'E01';
          $responseData['msg'] = 'this '.$id.' project user is no where';
        } else {
          $responseData['code'] = 'D01';
          $responseData['msg'] = 'project_user come';
          $responseData['data'] = $dataContent;
        }
        Log::debug('before return');
        return $responseData;
    }

    // 프로젝트 수정
    public function update_project(Request $request, $id)
    {
      // dd($id);
      Log::debug($id);
      Log::debug($request);
      $newValue = $request->Updatetitle;
      Log::debug($newValue);


      $project = project::where('id',$id)
                        ->update([
                          'project_title' => $request->Updatetitle,
                          'project_content' => $request->Updatecontent,
                          'start_date' => $request->Updatestart,
                          'end_date' => $request->Updateend,
                        ]);
      Log::debug($project);

      $project->save();

      return redirect()->route('/individual');


    }


    // 프로젝트 삭제
    public function delete_project(Request $request, $id)
    {
      Log::debug($request);

        return $id.'연결확인';
    }
}


