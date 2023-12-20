<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Models\Project;
use App\Http\Models\ProjectUser;
use App\Http\Models\Task;
use App\Http\Models\User;
use App\Http\Models\BaseData;

class GanttChartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ganttshow()
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
            
            
        ");
        // $result['count']=count($result);
        // dd($result);
        return view('ganttchart')->with('data',$result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ganttstore(Request $request)
    {
        $result = Task::find($id);

        $result->
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ganttupdate(Request $request, $id)
    {
        $responseData = [
            "code" => "0",
            "msg" => "",
            "data" => []
        ];

        $result = Task::find($id);

        if (!$result) {
            // 예외 처리 : 데이터 0건
            $responseData['code'] = 'E01';
            $responseData['msg'] = 'No Date.';
        } else {
            // 정상 처리
            $resposibleName = User::where('name', $request['task_reponsible_id'])->first();
            $statusName = DB::table('basedata')->where('data_content_name', $request['task_status_id'])->first();
            $priorityName = DB::table('basedata')->where('data_content_name', $request['priority_id'])->first();

            $result->task_responsible_id = $resposibleName->id;
            $result->task_status_id = $statusName->id;
            // $result->prioity_id = $priorityName->id;

            $result->title = $request->title;
            $result->content = $request->content;

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

}
