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

class GanttChartController extends Controller
{
    // 간트차트 전체화면 출력
    public function ganttindex()
{
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

        // $result['count']=count($result);
        // dd($result);

        if(Auth::check()) {
            return view('ganttchart')->with('data',$result)->with('user', Session::get('user'));
        } else {
            return redirect('/user/login');
        }
    }        

    // 간트차트 업무 작성
    public function ganttstore(Request $request)
    {
        $responseData = [
            "code" => "0",
            "msg" => "",
            "data" => []
        ];
        // Log::debug('cookie: '.$request->cookie('user'));
        // Log::debug('Auth: '. Auth::id());
        $sta = DB::table('basedata')->where('data_title_code',0)->where('data_content_name', $request['task_status_id'])->first();
        $pri = DB::table('basedata')->where('data_title_code',1)->where('data_content_name', $request['priority_id'])->first();
        $res = DB::table('users')->where('name', $request['task_responsible_id'])->first();
        // $eml = DB::table('users')->where('email', $request['email'])->first();
        if($request['start_date'] === '시작일') {
            $start = null;
        } else {
            $start = $request['start_date'];
        }
        if($request['end_date'] === '마감일') {
            $end = null;
        } else {
            $end = $request['end_date'];
        }
        $tit = $request['title']; // TODO: 유효성 처리 추가
        $con = $request['content']; // TODO: 유효성 처리 추가

        $request['title'] = $tit;
        $request['content'] = $con;
        // $request['project_id'] = $con;
        $request['task_status_id'] = $sta->data_content_code;
        // $request['task_responsible_id'] = $res->id;
        $request['start_date'] = $start;
        $request['end_date'] = $end;
        $request['priority_id'] = $pri->data_content_code;

        // Log::debug($request);
        $result = Task::create($request->data);
        $responseData['msg'] = 'task created.';
        $responseData['data'] = $result;

        return $responseData;

    }

    // 간트차트 업무 수정
    public function ganttUpdate(Request $request)
    {
        Log::debug("**** ganttupdate Start ****");
        dd($request);
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
            // Log::debug('$request->content :'.$request->content);
            // $result->content = $request->content;

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
        Log::debug("**** ganttupdate End ****");
        return $responseData;
    }

}
