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

        // $start = $data['start_date'];
        // $start = Carbon::create($data['start_date']);
        // $end = Carbon::create($data['end_date']);
        // $dday[] = $start->diffInDays($end);

        foreach ($data as $items) {
          $start = Carbon::create($data['start_date']);
          $end = Carbon::create($data['end_date']);
          // $dday[] = $start->diffInDays($end);
          $data['dday'] = $start->diffInDays($end); // data에 dday 추가
        }
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

        if ($result->flg == '0'){
          return redirect()->route('individual.get',['id' => $user_id['id']]);
        } elseif ($result->flg == '1'){
          return redirect()->route('team.get',['id' => $user_id['id']]);
        } else {
          return '다시 확인해주세요';
        }

    }


    public function mainshow($id) {
        
        $result = project::find($id);


        $tkdata = DB::table('projects')
                      -> select('tasks.id',
                                'projects.user_pk',
                                'tasks.project_id',
                                'tasks.task_responsible_id',
                                'tasks.title',
                                'tasks.content',
                                'tasks.category_id',
                                'tasks.start_date',
                                'tasks.end_date',
                                'base1.data_content_name as status_name',
                                'base2.data_content_name as category_name',
                                )
                      -> join('tasks', function($join) {
                        $join->on('tasks.project_id','=','projects.id')->where('projects.user_pk', '=', 7);
                      })
                      -> join('basedata as base1', function($base1){
                        $base1->on('base1.data_content_code','=','tasks.task_status_id')->where('base1.data_title_code', '=', '0');
                      })
                      -> join('basedata as base2', function($base2){
                        $base2->on('base2.data_content_code','=','tasks.category_id')->where('base2.data_title_code', '=', '2');
                      })
                      -> get();
        // dd($tkdata);
        // $projectdata = DB::table('projects')
        //               -> select('projects.user_pk',
        //                         'projects.start_date',
        //                         'projects.end_date',
        //                         'tasks.project_id',
        //                         'tasks.task_responsible_id',
        //                         'tasks.title',
        //                         'tasks.content',
        //                         'tasks.category_id'
        //               )
        //               -> join('tasks', function($join) {
        //                 $join->on('tasks.project_id','=','projects.id')->where('projects.user_pk', '=', 7);
        //               })
        //               -> get();
        // dd($projectdata);

        // $statusdata = DB::table('tasks')
        //                   -> select('data_content_name')
        //                   -> join('basedata', function($base1){
        //                     $base1->on('data_content_code','=','tasks.task_status_id')->where('data_title_code', '=', '0');
        //                   })
        //                   // -> join('basedata', function($base2){
        //                   //   $base2->on('data_content_code','=','tasks.category_id')->where('data_title_code', '=', '2');
        //                   // })
        //                   -> get();
        // // dd($statusdata);

        // $categorydata = DB::table('tasks')
        //                     -> select('data_content_name')
        //                     // -> join('basedata', function($base1){
        //                     //   $base1->on('data_content_code','=','tasks.task_status_id')->where('data_title_code', '=', '0');
        //                     // })
        //                     -> join('basedata', function($base2){
        //                       $base2->on('data_content_code','=','tasks.category_id')->where('data_title_code', '=', '2');
        //                     })
        //                     -> get();
          // dd($categorydata);

        // 업무 시작/마감일자 d-day 설정
        foreach ($tkdata as $items) {
          $start = Carbon::create($items->start_date);
          $end = Carbon::create($items->end_date);
          // $dday[] = $start->diffInDays($end);
          $items->dday = $start->diffInDays($end); // tkdata에 dday 추가
        }
        // dd($tkdata);




        // dd($result);

        // $data2 = if ($tkdata->category_id = 0) {
          
        // }

        return view('project_individual')->with('result',$result)->with('data',$tkdata);
    }
}
