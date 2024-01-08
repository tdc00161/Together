<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Http\Controllers\style;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\Task;
use App\Models\User;
use App\Models\BaseData;
use App\Models\Friendlist;
use App\Models\ProjectRequest;

class ProjectController extends Controller
{
  // 프로젝트 생성 화면 출력
  public function tableget() {

    return view('project_create');

  }

  public function maincreate(Request $request) {

    //로그인한 유저 정보 출력
    $user_id = Auth::id();

    //----projects 테이블 데이터 추가

    //데이터 전달(post)
    $data= $request
            ->only('user_pk','color_code_pk','project_title', 'project_content', 'flg', 'start_date', 'end_date');

    //data에 로그인한 유저 id 추가
    $data['user_pk'] = $user_id;

    //color_code 랜덤으로 추가   
    $data['color_code_pk'] = (string)rand(0,4);

    // $data['start_data'] = str_replace('-', '/', $data['start_date']);
    
    //DB 저장
    $result = Project::create($data);

    //----project_users 테이블 데이터 추가

    //데이터 전달(post)
    $data2= $request
              ->only('project_id','authority_id','member_id','created_at');

    //project_id 추가
    $data2['project_id'] = $result->id;

    //authority_id 추가
    $data2['authority_id'] = 0;

    //member_id 추가
    $data2['member_id'] = $user_id;

    //DB 저장
    $data2result = ProjectUser::create($data2);

    //flg 기준 개인/팀 화면으로 전달, 로그인 안한 유저일 경우 log 화면으로 이동
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

  public function mainindex() {
    if (Auth::check()) {
      return redirect('/dashboard');
    } else {
        return redirect('/user/login');
    }
  }

  public function mainshow(Request $request, $id) {

    //로그인한 유저 정보 출력
    $user = Auth::user();

    //프로젝트 id 출력
    $result = project::find($id);
    // dump($result);

    if(!$result){
      return redirect()->route('dashboard.show');
    }

    $authoritychk = DB::table('project_users as pu')
                      ->join('projects as pj','pj.id','pu.project_id')
                      ->select('pu.authority_id','pu.project_id','pu.member_id','pj.user_pk')
                      ->where('pu.project_id',$result->id)
                      ->where('pu.member_id',$result->user_pk)
                      ->get();

    // dd($authoritychk);

    //프로젝트 색상 출력
    $color_code = DB::table('projects as pj')
                    ->join('basedata as bd','bd.data_content_code','pj.color_code_pk')
                    ->select('pj.id', 'bd.data_content_name')
                    ->where('pj.id',$result->id)
                    ->where('bd.data_title_code','3')
                    ->whereNull('pj.deleted_at')
                    ->get();

    //프로젝트 dday 출력 240101 수정
    $projectDday = Carbon::now()->addDays(-1)->diffInDays($result->end_date);
    // dd($projectDday);

    //프로젝트 상태별 개수 출력
    $before =DB::table('tasks')
                ->selectRaw('count(task_status_id) as cnt')
                ->where('project_id',$id)
                ->where('category_id',0)
                ->where('task_status_id',0)
                ->where('task_depth','0')
                ->whereNull('tasks.deleted_at')
                ->groupBy('task_status_id')
                ->get();
                // dd($before);

    $ing =DB::table('tasks')
            ->selectRaw('count(task_status_id) as cnt')
            ->where('project_id',$id)
            ->where('category_id',0)
            ->where('task_status_id',1)
            ->where('task_depth','0')
            ->whereNull('tasks.deleted_at')
            ->groupBy('task_status_id')
            ->get();

    $feedback =DB::table('tasks')
                ->selectRaw('count(task_status_id) as cnt')
                ->where('project_id',$id)
                ->where('category_id',0)
                ->where('task_status_id',2)
                ->where('task_depth','0')
                ->whereNull('tasks.deleted_at')
                ->groupBy('task_status_id')
                ->get();

    $complete =DB::table('tasks')
                ->selectRaw('count(task_status_id) as cnt')
                ->where('project_id',$id)
                ->where('category_id',0)
                ->where('task_status_id',3)
                ->where('task_depth','0')
                ->whereNull('tasks.deleted_at')
                ->groupBy('task_status_id')
                ->get();

    //데이터 담을 빈 객체 생성
    $baseObj = new \stdClass();

    //데이터가 비었을 때는 0 으로 설정
    $baseObj->cnt = 0;
    
    //데이터 삼항연산자로 비교해서 개수 출력
    $statuslist = [
      'before'=> count($before) === 0 ? collect([$baseObj]) : $before,
      'ing'=> count($ing) === 0 ? collect([$baseObj]) : $ing,
      'feedback'=> count($feedback) === 0 ? collect([$baseObj]) : $feedback,
      'complete'=> count($complete) === 0 ? collect([$baseObj]) : $complete
    ];

    //공지 출력(생성일순)
    $first_data = DB::table('tasks as tk')
                    ->join('projects as pj','pj.id','tk.project_id')
                    ->select('tk.id','tk.title','tk.created_at')
                    ->where('tk.project_id',$result->id)
                    ->where('tk.category_id','1')
                    ->whereNull('tk.deleted_at')
                    ->orderBy('tk.created_at','desc')
                    ->get();


    //업데이트 내역 출력(수정일순)
    $update_data = DB::table('tasks as tk')
                    ->join('projects as pj','pj.id','tk.project_id')
                    ->join('basedata as bd','bd.data_content_code','tk.category_id')
                    ->select('tk.id','tk.title','tk.updated_at','tk.category_id','bd.data_content_name')
                    ->where('bd.data_title_code','2')
                    ->where('tk.project_id',$result->id)
                    ->whereNull('tk.deleted_at')
                    ->orderBy('tk.updated_at','desc')
                    ->get();


    //마감기한 내역(d-day순)
    $deadline_data = DB::table('tasks as tk')
                    ->join('projects as pj','pj.id','tk.project_id')
                    ->join('basedata as bd','bd.data_content_code','tk.task_status_id')
                    ->leftJoin('users as us','us.id','tk.task_responsible_id') //담당자 수정완료
                    ->select('tk.id'
                            ,'tk.title'
                            ,'tk.task_responsible_id'
                            ,'us.name'
                            ,'tk.task_status_id'
                            ,'bd.data_content_name'
                            , DB::raw('TIMESTAMPDIFF(DAY, curdate(), tk.end_date) as dday'))
                    ->where('bd.data_title_code','0')
                    ->where('tk.project_id',$result->id)
                    ->where('tk.task_status_id','!=','3')
                    ->where('task_depth','0')
                    ->where('tk.start_date','<=',now()) // 오늘날짜기준 이전 시작일 출력(수정)
                    ->whereNull('tk.deleted_at')
                    ->orderBy('dday','asc')
                    ->get();


    // (jueunyang08) 사이드바 출력
    $userId = Auth::id();

    $project0title = DB::table('projects as p')
                        ->join('project_users as pu', 'p.id','=','pu.project_id')
                        ->join('basedata as b', 'b.data_content_code', '=', 'p.color_code_pk')
                        ->select('p.project_title', 'b.data_content_name', 'p.id')
                        ->where('pu.member_id', '=', $userId)
                        ->where('p.flg','=', 0)
                        ->where('b.data_title_code', '=', 3)
                        ->whereNull('p.deleted_at')
                        ->orderBy('p.created_at', 'asc')
                        ->get();

    $project1title = DB::table('projects as p')
                        ->join('project_users as pu', 'p.id','=','pu.project_id')
                        ->join('basedata as b', 'b.data_content_code', '=', 'p.color_code_pk')
                        ->select('p.project_title', 'b.data_content_name', 'p.id')
                        ->where('pu.member_id', '=', $userId)
                        ->where('p.flg','=', 1)
                        ->where('b.data_title_code', '=', 3)
                        ->whereNull('p.deleted_at')
                        ->orderBy('p.created_at', 'asc')
                        ->get();

    // (jueunyang08) 프로젝트 구성원 출력
    $projectmemberdata = DB::table('project_users as p')
                            ->join('users as u', 'u.id', '=', 'p.member_id')
                            ->select('p.project_id', 'u.name', 'p.member_id')
                            ->where('p.project_id', '=', $id)
                            ->orderBy('p.created_at','asc')
                            ->get();

    // 초대 토큰
    $invitation = ProjectRequest::create([
      'invite_token' => Str::random(32),
      'from_user_id' => $user->id,
      'to_user_id' => auth::user()->id,
      'project_id' => $result->id,
    ]);

    $inviteLink = URL::signedRoute('invite', ['token'=> $invitation->invite_token]);

    //개인,팀 화면에 정보 출력 , 로그인 안 한 유저일 경우 login 화면으로 이동
    if (Auth::check()) {
        return view('project_individual')
        ->with('color_code',$color_code)
        ->with('result',$result)
        ->with('first_data',$first_data)
        ->with('update_data',$update_data)
        ->with('deadline_data',$deadline_data)
        ->with('statuslist',$statuslist)
        ->with('projectDday',$projectDday)
        ->with('user',Auth::id())
        ->with('project0title', $project0title)
        ->with('project1title', $project1title)
        ->with('projectmemberdata',$projectmemberdata) // (jueunyang08) 프로젝트 구성원 출력
        ->with('authoritychk',$authoritychk)
        ->with('inviteLink',$inviteLink);
    } else {
        return redirect('/user/login');
    }
  }

  //초대 응했을 때 들어오는 링크
  public function acceptInvite(Request $request) {

    $token = $request->input('token');
    $invite = ProjectRequest::where('invite_token',$token)->first();

    if (!$request->hasValidSignature()) {
        abort(403);
    }



    return redirect()->route('user.login.get')->with('invite',$invite);

  }



  public function project_graph_data(Request $request, $id) {

    //로그인한 유저 정보 출력
    $user_id = Auth::id();

    //업무상태별 개수 출력
    $before=DB::table('tasks')
                ->selectRaw('count(task_status_id) as cnt')
                ->where('project_id',$id)
                ->where('category_id',0)
                ->where('task_status_id',0)
                ->where('task_depth','0')
                ->whereNull('tasks.deleted_at')
                ->groupBy('task_status_id')
                ->get();

    $ing=DB::table('tasks')
            ->selectRaw('count(task_status_id) as cnt')
            ->where('project_id',$id)
            ->where('category_id',0)
            ->where('task_status_id',1)
            ->where('task_depth','0')
            ->whereNull('tasks.deleted_at')
            ->groupBy('tasks.task_status_id')
            ->get();

    $feedback=DB::table('tasks')
                  ->selectRaw('count(task_status_id) as cnt')
                  ->where('project_id',$id)
                  ->where('category_id',0)
                  ->where('task_status_id',2)
                  ->where('task_depth','0')
                  ->whereNull('tasks.deleted_at')
                  ->groupBy('tasks.task_status_id')
                  ->get();

    $complete=DB::table('tasks')
                ->selectRaw('count(task_status_id) as cnt')
                ->where('project_id',$id)
                ->where('category_id',0)
                ->where('task_status_id',3)
                ->where('task_depth','0')
                ->whereNull('tasks.deleted_at')
                ->groupBy('tasks.task_status_id')
                ->get();

    //데이터 담을 빈 객체 생성
    $baseObj=new \stdClass();

    //데이터가 비었을 때는 0 으로 설정
    $baseObj->cnt=0;

    //데이터 삼항연산자로 비교해서 개수 출력
    $statuslist=[
      'before'=> count($before) === 0 ? collect([$baseObj]) : $before,
      'ing'=> count($ing) === 0 ? collect([$baseObj]) : $ing,
      'feedback'=> count($feedback) === 0 ? collect([$baseObj]) : $feedback,
      'complete'=> count($complete) === 0 ? collect([$baseObj]) : $complete
    ];
    //project.js 로 데이터 변환해서 전송
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

  //프로젝트명, 콘텐츠, 시작일, 마감일 수정
  public function update_project(Request $request, $id)
  {
    Log::debug("시작".$request);
    //project.js 에서 전송한 업데이트할 데이터를 변수에 담음
    $newValue = $request->Updatetitle;
    Log::debug("값호출".$newValue);
    //project에 수정한 내용으로 업데이트
    $project = project::where('id',$id)
                      ->update([
                        'project_title' => $request->Updatetitle,
                        'project_content' => $request->Updatecontent,
                        'start_date' => $request->Updatestart,
                        'end_date' => $request->Updateend,
                      ]);
    Log::debug("정보출력".$project);
    //DB에 저장
    $project->save();

    return redirect()->route('/individual');
  }


  // 프로젝트 삭제
  public function delete_project(Request $request, $id)
  {
    Log::debug("id 확인요청 : ". $id);
    $user = Project::find($id);
    Log::debug("id 확인완료");

    if(!$user) {
      return response()->json(['errer' => 'item not found'], 404);
    }
    Log::debug("user 에러");
    $user->delete();
    Log::debug("user 삭제");
    return response()->json();
    Log::debug("화면전달");
  }


    // 프로젝트 나가기
    public function exit_project(Request $request, $id)
    {
        $user = auth::user();
        Log::debug("user 확인요청 : ". $user);
        if(!$user) {
          return response()->json(['errer' => 'item not found'], 404);
        }
        //구성원 나가기 기능
        $member = ProjectUser::where('project_users.project_id',$id)
                            ->where('project_users.member_id', $user->id)
                            ->join('projects as pj', 'pj.id', 'project_users.project_id')
                            ->join('users as us', 'us.id', 'pj.user_pk')
                            ->select('project_users.*')
                            ->delete();

        return response()->json();
        
        Log::debug("화면전달");
    }

}

