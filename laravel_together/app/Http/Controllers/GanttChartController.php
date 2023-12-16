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
    public function index()
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
            LIMIT 15
            
        ");
        // $result['count']=count($result);
        // dd($result);
        return view('ganttchart')->with('data',$result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
