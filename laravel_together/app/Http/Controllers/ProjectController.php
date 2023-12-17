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
        // dd($user_id);

        $color_code = DB::table('basedata')
                        ->select('data_content_name')
                        ->where("data_title_code","=","3")
                        ->orderByRaw('RAND()')
                        ->get();
        // dd($color_code);

        // $color_coded = $color_code->shuffle();
        // $color_array = $color_coded->all();
        // foreach ($color_coded as $items) {
        //     $color_array[] = color_code[$items]; 
        // }

        // $color_coded = $items[0,4].(mt_rand(0,3));
          
        // $color_coded = array_rand($color_code,count($color_code));

        // dd($color_code);
        $data= $request
                ->only('color_code','project_title', 'project_content', 'flg', 'start_date', 'end_date');
        $data['user_id'] = $user_id['id'];
        $data['color_code'] = $color_code[0];
        dd($data);
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
