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
use Carbon\Carbon;

class ProjectController extends Controller
{
    public function tableget() {
        // dd($user_id);
        return view('project_create');
    }

    public function mainstore(Request $request) {
        $user_id = Session::get('user')->only('id');
        // $user_id = 171;
        // dd($user_id);

        $color_code = DB::table('basedata')
                        ->join('projects','color_code_pk','=','data_content_code')
                        // ->select('data_content_name')
                        ->select('data_title_code')
                        ->where("data_title_code","=","3")
                        ->orderByRaw('RAND()')
                        ->first();
        // dd($color_code->data_content_name);

        // $color_coded = $color_code->shuffle();
        // $color_array = $color_coded->all();
        // foreach ($color_coded as $items) {
        //     $color_array[] = color_code[$items]; 
        // }

        // $color_coded = $items[0,4].(mt_rand(0,3));
          
        // $color_coded = array_rand($color_code,count($color_code));

        // dd($color_code);
        $data= $request
                ->only('user_pk','color_code_pk','project_title', 'project_content', 'flg', 'start_date', 'end_date');
        $data['user_pk'] = $user_id['id'];
        // $data['user_pk'] = $user_id;
        // $data['color_code_pk'] = $color_code->data_content_name;
        $data['color_code_pk'] = $color_code->data_title_code;
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

        return redirect()->route('individual.get',['user_id' => $user_id['id']]);

    }


    public function mainshow(Request $request, $user_id) {
        
        $tkdata = DB::table('projects')
                  -> select('tasks.project_id',
                            'tasks.task_responsible_id',
                            'tasks.title',
                            'tasks.content',
                            'tasks.category_id',
                            'projects.start_date',
                            'projects.end_date',
                            'base1.data_content_name status_name',
                            'base2.data_content_name category_name',
                            )
                  -> join('tasks', function($join) {
                    $join->on('tasks.projects.id','=','projects.id')->where('projects.user_pk', '=', $user_id);
                  })
                  -> join('basedata base1', function($base1){
                    $join->on('base1.data_content_code','=','tasks.task_status_id')->where('base1.data_title_code', '=', '0');
                  })
                  -> join('basedata base2', function($base2){
                    $join->on('base2.data_content_code','=','tasks.category_id')->where('base2.data_title_code', '=', '2');
                  })
                  -> get();
        dd($tkdata);

        $start = project::start_date();
        dd($start);
        $end = parse($data->end_date);

        $dday = $start->diffInDays($end);

        $result = project::find($user_id);
        // dd($result);

        return view('project_individual')->with('result',$result)->with('data',$tkdata);
    }
}
