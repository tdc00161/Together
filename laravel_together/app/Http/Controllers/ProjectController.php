<?php

namespace App\Http\Controllers;

use App\Events\AlarmEvent;
use App\Models\ChatRoom;
use App\Models\ChatUser;
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
            ->only('user_pk','color_code_pk','project_title', 'project_content', 'flg', 'start_date', 'end_date','invite');
    
    //data에 로그인한 유저 id 추가
    $data['user_pk'] = $user_id;

    //color_code 랜덤으로 추가   
    $data['color_code_pk'] = (string)rand(0,4);

    //프로젝트별 랜덤 고유 토큰 추가
    $data['invite'] = url()->to('/')."/invite/".Str::random(10);
    
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

    // --------------------------------------------- 240110 김관호: 프로젝트 제작 후 채팅방 생성 및 참가
	if((int)$result->flg === 1){ // 팀프로젝트일 경우만 생성 후 참가
		$ChatRoomData = [
			'flg' => $result->flg,
			'project_id' => $result->id,
			'chat_room_name' => $result->project_title,
		];
			
		$ChatRoom = ChatRoom::create($ChatRoomData);
		// Log::debug($ChatRoom);

	
		// 채팅방 초대 모듈 호출
    $this->chatRoomInvite( $ChatRoom->project_id,$user_id);
    // 초대 알람 -> 자기가 만들었으니 초대 안해도 됨
    // $AlarmEvent = new AlarmEvent(['PI',$user_id,$ChatRoom]);
    // $AlarmEvent->newAlarm();
	}
    // --------------------------------------------- 240110 김관호 

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
    // dump($user);
    //프로젝트 id 출력
    $result = project::find($id);
    // dump($result);
    if(!$result){
      return redirect()->route('dashboard.show');
    }

    //권한여부 체크
    $authoritychk = DB::table('project_users as pu')
                      ->select('pu.authority_id','pu.project_id','pu.member_id')
                      ->join('projects as pj','pj.id','pu.project_id')
                      ->join('users as us','us.id','pu.member_id')
                      ->where('pu.project_id',$result->id)
                      // ->where('pu.member_id',$user->id)
                      ->whereNull('pu.deleted_at')
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
                            ->select('p.project_id', 'u.name', 'p.member_id','u.email','p.authority_id') //240112 권한 데이터 출력 추가 : 양수진
                            ->where('p.project_id', '=', $id)
                            ->whereNull('p.deleted_at')
                            ->orderBy('p.created_at','asc')
                            ->get();

    //친구 목록에서 초대
    $friendinvite = DB::table('friendlists as f')
                        ->join('users as u', function ($join) use ($userId) {
                            $join->on(function ($query) use ($userId) {
                                    $query->on('u.id', '=', 'f.friend_id')
                                        ->where('f.user_id', '=', $userId);
                                })
                                ->orOn(function ($query) use ($userId) {
                                    $query->on('u.id', '=', 'f.user_id')
                                        ->where('f.friend_id', '=', $userId);
                                });
                        })
                        ->select([
                            'f.friend_id',
                            'u.id as user_id',
                            'u.name',
                            DB::raw("CASE WHEN f.user_id = {$userId} THEN u.name ELSE NULL END AS friend_name"),
                            'u.email',
                        ])
                        ->whereNull('f.deleted_at')
                        ->orderBy('u.name', 'asc')
                        ->distinct()
                        ->get();


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
        ->with('friendinvite',$friendinvite);
    } else {
        return redirect('/user/login');
    }
  }


  
  //초대 응했을 때 들어오는 링크
  public function acceptInvite(Request $request, $token) {

    $url = url()->current();

    $user = Auth::user();


    $project = DB::table('projects as pj')
                ->join('users as us','us.id','pj.user_pk')
                ->select('pj.id as project_id','pj.flg','us.id as uid','pj.invite')
                ->where('pj.invite',$url)
                ->get();

    $member_id = $user->id;

    $invite_member = ProjectUser::where('member_id',$member_id)
                                  ->join('projects as pj','pj.id','project_users.project_id')
                                  ->where('pj.invite',$url)
                                  ->first();

    if(!$invite_member){
        //초대 구성원 추가
        $invite_user = ProjectUser::create([
          'project_id' => $project[0]->project_id,
          'authority_id' => '1',
          'member_id' => $member_id
        ]);

        // 채팅방 초대
        $this->chatRoomInvite($invite_member[0]->id,$member_id);
        // 초대 알람
        $AlarmEvent = new AlarmEvent(['PI',$member_id,$invite_member]);
        $AlarmEvent->newAlarm();

    }else{
      return view('/membermodal')->with('project_id',$project[0]->project_id)->with('url',$url);
    }
    
    if(!Auth::check()){
      return redirect()->route('user.login.get');
    }else{
      if($project[0]->flg === '0'){
        return redirect()->route('individual.get',['id' => $project[0]->project_id]);
      }elseif($project[0]->flg === '1'){
        return redirect()->route('team.get',['id' => $project[0]->project_id]);
      }
    }
  }

  //구성원 중복시 창
  public function membermodal(){ // Request $request, $token
    // dd($token);
    return view('/membermodal');
    // ->with('token',$request->token)
  }


  //친구목록에서 구성원 추가
  public function friendmember(Request $request){
    // dd($request);
    Log::debug($request);

    $url = $request->url;
    Log::debug($url);

    $urlsb = substr($url, -3);
    Log::debug($urlsb);

    $invite_member = ProjectUser::where('member_id',$request->Value)
                                ->join('projects as pj','pj.id','project_users.project_id')
                                ->where('project_users.project_id',$urlsb)
                                ->first();
	Log::debug($invite_member);
    
	if(!$invite_member){
      
      $memberpj = ProjectUser::create([
        'project_id' => $urlsb,
        'authority_id' => '1',
        'member_id' => $request->Value
      ]);
      
      // 초대 시 채팅방에 참여
      $this->chatRoomInvite($urlsb,$request->Value);
      // 초대 알람
      $AlarmEvent = new AlarmEvent(['PI',$request->Value,$memberpj]);
      $AlarmEvent->newAlarm();

      return response()->json('성공');

    }else{

      return response()->json('실패');
    
    }

  }

  // 구성원 내보내기
  public function signoutm(Request $request){

    Log::debug("리퀘스트:".$request);

    $murl = $request->url;
    Log::debug('주소'.$murl);

    $murlid = substr($murl, -3);
    Log::debug('프로젝트 아이디'.$murlid);

    $uid = User::select('id')
                ->where('email',$request->memail)
                ->get();
    Log::debug('유저아이디'.$uid);
    
    $deletem = ProjectUser::where('project_id',$murlid)
                          ->where('member_id',$uid[0]->id)
                          ->delete();
    Log::debug('삭제'.$deletem);

    return response()->json('성공');
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

    // // 채팅방도 나가기
    $userId = Auth::id();
    $this->chatRoomExit($id,$userId);

    return response()->json();
    Log::debug("화면전달");
  }


    // 프로젝트 나가기
    public function exit_project($id)
    {
      $user = auth::user();
      // dump($user);
      Log::debug("user 확인요청 : ". $user);        
      $pu = ProjectUser::find($id);
      // dd($pu);

      if(!$user) {
        return response()->json(['errer' => 'item not found'], 404);
      }
      //구성원 나가기 기능
      $member = ProjectUser::select('project_users.member_id','project_users.project_id')
                          ->join('projects as pj', 'pj.id', 'project_users.project_id')
                          ->join('users as us', 'us.id', 'project_users.member_id')
                          ->where('project_users.project_id',$id)
                          ->where('project_users.authority_id',1)
                          ->where('project_users.member_id',$user->id)
                          ->delete();

      // 나갈 때 채팅방에서 나가기
      $this->chatRoomExit($id,$user->id);

      return response()->json();
      
      Log::debug("화면전달");
  }

  // 채팅방 초대 모듈
  public function chatRoomInvite($project_id,$user_id)
  {
    $chatRoomId = ChatRoom::where('project_id',$project_id)->first(); //$ChatRoom->project_id
		$ChatRoom = null;
    
		if($chatRoomId){
			$ChatUserData = [
				'chat_room_id' => $chatRoomId->id,
				'user_id' => $user_id,
			];
			
			$ChatRoom = ChatUser::create($ChatUserData);

      // 채팅방 인원 증가
      $result = $chatRoomId->update([
        'user_count' => $chatRoomId->user_count+1,
      ]);
    }
    // Log::debug($ChatRoom);
    return $ChatRoom;
  }

  // 채팅방 나가기 모듈
  public function chatRoomExit($project_id,$user_id)
  {
    $chatRoomId = ChatRoom::where('project_id',$project_id)->first(); //$ChatRoom->project_id
		$ChatUser = null;
    
		if($chatRoomId){
			$ChatUser = ChatUser::where('chat_room_id',$chatRoomId->id)
        ->where('user_id',$user_id);
      $ChatUser->delete();

      // 유저가 다 나갔으면 채팅방 삭제
      Log::debug(ChatUser::where('chat_room_id',$chatRoomId->id)->whereNull('deleted_at')->count());
      if(ChatUser::where('chat_room_id',$chatRoomId->id)->count() === 0){
        Log::debug('사람 없는 채팅방');
        $chatRoomId->delete();
      }
      
      // 아마 채팅창에 표시하거나 유저수 카운트 변화하려면 여기서 이벤트 발생해야 할 것

      // 채팅방 인원 감소
      $result = $chatRoomId->update([
        'user_count' => $chatRoomId->user_count-1,
      ]);
    }
      return $ChatUser;
  }

}

