<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Project;
use App\Http\Models\ProjectUser;
use App\Http\Models\Task;
use App\Http\Models\User;
use App\Http\Models\BaseData;
use App\Http\Models\Friendlist;
use Illuminate\Support\Facades\DB;

class ProjectIndividualController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Projects::all->get();

        $data = [
            'project_title' => $project_title,
            'project_content' => $project_content,
            'user_id' => $user_id,
        ];
        
        return view('project_individual')->with(data,$data);
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
        $result = project::find($id);

        DB::table('project')
            ->SELECT('user_id','color_code','project_title','project_content','start_date','end_date')
            ->where('user_id','$id')
            ->get();
        return view('project_individual')->with(data,$result);
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
