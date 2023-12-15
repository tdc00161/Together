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

class ProjectController extends Controller
{
    public function tableget() {

        return view('project_create');
    }

    public function tablepost(Request $request) {

        // var_dump($request);
        $data= $request
                ->only('user_id','project_title', 'project_content', 'flg', 'start_date', 'end_date');
        
        // DB::table('project')->insert([
        //     'user_id' => '',
        //     'project_title' => '',
        //     'project_content' => '',
        //     'flg' => '',
        //     'stat_date' =>'',
        //     'end_date' =>'',
        // ]);

        return redirect()->route('individual.get');

    }

    public function main() {

        $data = DB::table('Projects')->get();
        // dd($data);

        // $result = 

        return view('project_individual')->with('data',$data);
    }
}
