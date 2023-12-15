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

class ProjectController extends Controller
{
    public function tableget() {
        // dd($user_id);
        return view('project_create');
    }

    public function mainstore(Request $request) {
        $user_id = Session::get('user')->only('id');
        $color_code = 
        // dd($user_id);
        $data= $request
                ->only('project_title', 'project_content', 'flg', 'start_date', 'end_date');
        $data['user_id'] = $user_id['id'];
        // dd($data);
        $result = Project::create($data);
        // dd($result);
        // DB::table('project')->insert([
        //     'user_id' => '',
        //     'project_title' => '',
        //     'project_content' => '',
        //     'flg' => '',
        //     'stat_date' =>'',
        //     'end_date' =>'',
        // ]);

        return redirect()->route('individual.get')->with('id',$user_id)->with('data',$data);

    }

    // public function mainstore() {

    //     $data = DB::table('Projects')->get();
    //     // dd($data);

    //     // $result = 

    //     return view('project_individual')->with('data',$data);
    // }


    public function mainshow($id) {
        $data = DB::table('projects')->get();
        dd($data);

        $result = Project::find($id);
        dd($id);

        return view('individual.get')->with('data',$data)->with('id',$result);
    }
}
