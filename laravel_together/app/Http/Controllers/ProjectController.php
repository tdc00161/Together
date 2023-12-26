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
        return view('project_create');
    }

    public function maincreate(Request $request) {

        $data= $request
                ->only('user_pk','color_code_pk','project_title', 'project_content', 'flg', 'start_date', 'end_date');
        
        // user_id (session 에 저장된 값 호출)
        $user_id = Auth::id();
        // $user_id = 171;
        // dd($user_id);
        
        $data['user_pk'] = $user_id;

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
        // dump($id);
        // dump($request);
      // find -> pk 호출만 가능
        // $user_pk = project::where('user_pk', $user_pk)
        //         -> get();
        // dd($user_pk);

        $result = project::find($id);
        // dd($result);

        $user = Auth::user();
        // dump($user);

        // $user_id = Auth::id();
        // dd($user_id);

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

        // 대표 레이아웃 사이드바 생성
        $userflg0=[];
        $userflg1=[];
        foreach ($user_data as $items) {
            if ($items->flg == '0'){
              array_push($userflg0,$items);
          } elseif ($items->flg == '1'){
            array_push($userflg1,$items);
          }
        }

        // 탭명과 해당 프로젝트 연동
        

        // dd($userflg1);

        // dd($user_data);
        // if ($user_data->flg == '0'){
        //   return view('individual.get',['id' => $user_data['id']]);
        // } elseif ($user_data->flg == '1'){
        //   return view('team.get',['id' => $user_data['id']]);
        // }
        // dump($user_data);

        $color_code = DB::table('basedata')
                        ->join('projects','color_code_pk','=','data_content_code')
                        ->select('data_content_name')
                        ->where('data_title_code','=','3')
                        ->where('projects.user_pk','=',$user->id)
                        ->first();
        // dump($color_code);


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
                                // 'users.id',
                                // 'tasks.id',
                                'users.name',
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
                                'tasks.updated_at'
                                )
                      ->join('users', function($join) {
                        $join->on('users.id','=','projects.user_pk');
                      })  
                      ->join('tasks', function($join) {
                        $join->on('tasks.project_id','=','projects.id');
                      })
                      ->join('basedata as base1', function($base1){
                        $base1->on('base1.data_content_code','=','tasks.task_status_id');
                      })
                      ->join('basedata as base2', function($base2){
                        $base2->on('base2.data_content_code','=','tasks.category_id');
                      })
                      ->where('projects.id', '=', $result->id)
                      ->where('base1.data_title_code', '=', '0')
                      ->where('base2.data_title_code', '=', '2')
                      ->orderby('tasks.updated_at','desc')
                      // ->orderby('projects.id','desc')
                      -> get();

        // foreach ($tkdata as $items) {
        //   if($items->category_name == '공지') {
        //     color:red;
        //   } else if($items->category_name == '업무') {
        //     color:black;
        //   } else {
        //     return 'error';
        //   }
        // }
        // dump($tkdata);

        // 업무 시작/마감일자 d-day 설정
        foreach ($tkdata as $items) {
          $start = Carbon::create($items->start_date);
          $end = Carbon::create($items->end_date);
          // $dday[] = $start->diffInDays($end);
          $items->dday = $start->diffInDays($end); // tkdata에 dday 추가
        }

        // dd($result);

        // (jueunyang08) 프로젝트 구성원 출력
        $projectmemberdata = DB::table('project_users as p')
        ->join('users as u', 'u.id', '=', 'p.member_id')
        ->select('p.project_id', 'u.name', 'p.member_id')
        ->where('p.project_id', '=', $id)
        ->orderBy('p.created_at','asc')
        ->get();

        return view('project_individual')
        ->with('color_code',$color_code)
        ->with('user_data',$user_data)
        ->with('result',$result)
        ->with('data',$tkdata)
        ->with('user',Auth::id())
        ->with('userflg0',$userflg0)
        ->with('userflg1',$userflg1)
        ->with('projectmemberdata',$projectmemberdata); // (jueunyang08) 프로젝트 구성원 출력
    }


    public function project_graph_data(Request $request, $id) {

      // Log::debug("***** project_graph_data Start *****".$request);
      // $user = Auth::id();
      // return $user;
      // $user_id = Session::get('user')->only('id');
      $user_id = Auth::id();
      // dump($user_id);
      // Log::debug("user_id : ".$user_id);
      // $project_id = project::find($id);
      // dd($project_id);

      $before =DB::table('tasks')
                  ->selectRaw('count(task_status_id) as cnt')
                  ->where('project_id',$id)
                  ->where('task_status_id',0)
                  ->groupBy('task_status_id')
                  ->get();
      // dd($before);
      // $before=DB::table('tasks')
      //             ->selectRaw('count(project_id) as cnt')
      //             ->where('task_status_id',0)
      //             ->groupBy('project_id')
      //             ->having('project_id',$result[0]->id)
      //             ->get();
      // Log::debug("before : ", $before->all())
      // dd($before);

      $ing =DB::table('tasks')
              ->selectRaw('count(task_status_id) as cnt')
              ->where('task_status_id',1)
              ->where('project_id',$id)
              ->groupBy('tasks.task_status_id')
              ->get();
      // dump($ing);
      // $ing=DB::table('tasks')
      //         ->selectRaw('count(task_status_id) as cnt')
      //         ->where('task_status_id',1)
      //         ->groupBy('tasks.task_status_id')
      //         ->having('project_id',$result[0]->project_id) //프로젝트 pk
      //         ->get();
      // // Log::debug("ing : ", $before->all());

      $feedback =DB::table('tasks')
                    ->selectRaw('count(task_status_id) as cnt')
                    ->where('task_status_id',2)
                    ->where('project_id',$id)
                    ->groupBy('tasks.task_status_id')
                    ->get();

      // $feedback=DB::table('tasks')
      //               ->selectRaw('count(task_status_id) as cnt')
      //               ->where('task_status_id',2)
      //               ->groupBy('tasks.task_status_id')
      //               ->having('project_id',$result[0]->project_id)
      //               ->get();
      // Log::debug("feedback : ", $before->all());
      // dump($feedback);
      // dd($feedback);

      $complete =DB::table('tasks')
                  ->selectRaw('count(task_status_id) as cnt')
                  ->where('task_status_id',3)
                  ->where('project_id',$id)
                  ->groupBy('tasks.task_status_id')
                  ->get();

      // $complete=DB::table('tasks')
      //               ->selectRaw('count(task_status_id) as cnt')
      //               ->where('task_status_id',3)
      //               ->groupBy('tasks.task_status_id')
      //               ->having('project_id',$result[0]->project_id)
      //               ->get();
      // Log::debug("complete : ", $before->all());
      // dd($complete);

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

      // Log::debug("Response : ", $statuslist);
      // Log::debug("***** project_graph_data End *****");
      return response()->json($statuslist);
      // return '반환 테스트';
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
      // // 업데이트 내용
      // $project->project_title = $newValue;
      // Log::debug($newValue);

      // // 저장
      // $updateproject =

      return redirect()->route('/individual');
      // return redirect()->json(['result' => $updateproject, 'project' => $project],200, [], JSON_PRETTY_PRINT);


      // return redirect('/individual')->with('newValue',$newValue);

      // return response()->json(['update_project' => $UpdateValue]);
      // return response()->json(['update_project' => $newValue]);



    }


    // 프로젝트 삭제
    public function delete_project(Request $request, $id)
    {
      Log::debug($request);
        // $responseData = [
        //     "code" => "0",
        //     "msg" => "",
        //     "data" => ""
        // ];
        // $dataContent = Project::find(1);
        // // Log::debug($dataContent);
        // // Log::debug(!$dataContent);
        // // if (!$dataContent) {
        // //   $responseData['code'] = 'E01';
        // //   $responseData['msg'] = 'this '.$id.' project user is no where';
        // // } else {
        // //   $responseData['code'] = 'D01';
        // //   $responseData['msg'] = 'project_user come';
        // //   $responseData['data'] = $dataContent;
        // // }
        // Log::debug($dataContent);
        // // return $responseData;
        return $id.'연결확인';
    }
}


