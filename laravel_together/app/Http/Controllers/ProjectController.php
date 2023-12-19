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

    public function maincreate(Request $request) {

        $data= $request
                ->only('user_pk','color_code_pk','project_title', 'project_content', 'flg', 'start_date', 'end_date');
        
        // user_id (session 에 저장된 값 호출)
        $user_id = Session::get('user')->only('id');
        // $user_id = 171;
        // dd($user_id);
        
        $data['user_pk'] = $user_id['id'];

        // color_code 랜덤 호출
        $color_code = DB::table('basedata')
                        ->join('projects','color_code_pk','=','data_content_code')
                        // ->select('data_content_name')
                        ->select('data_content_code')
                        ->where("data_title_code","=","3")
                        ->get();


        foreach ($color_code as $items) {
          $data['color_code_pk'] = $items->data_content_code; //
        }

        // dd($data);


        // dday 호출
        foreach ($data as $items) {
          $start = Carbon::create($data['start_date']);
          $end = Carbon::create($data['end_date']);
          // $dday[] = $start->diffInDays($end);
          $data['dday'] = $start->diffInDays($end); // data에 dday 추가
        }
        // dd($data);



        // dd($project_title);
        // $project_content = $request->project_content');
        // $start_date = $request->input('start_date');
        // $end_date = $request->input('end_date');

        $result = Project::create($data);

        if ($result->flg == '0'){
          return redirect()->route('individual.get',['user_pk' => $result['user_pk']]);
        } elseif ($result->flg == '1'){
          return redirect()->route('team.get',['user_pk' => $result['user_pk']]);
        }

        return '다시 확인해주세요';

    }


    public function mainshow($user_pk) {
        // dd($request);
      // find -> pk 호출만 가능
        $result = DB::table('projects')
                    -> select('id'
                      ,'user_pk'
                      ,'color_code_pk'
                      ,'project_title'
                      ,'project_content'
                      ,'flg'
                      ,'start_date'
                      ,'end_date')
                    -> where('user_pk', $user_pk)
                    -> get();
        // dd($result);

        $project_title = $result[$items->project_title];
        dd($project_title);

        // $tkdata = DB::table('projects')
        // -> select('tasks.id',
        //           'projects.user_pk',
        //           'tasks.project_id',
        //           'tasks.task_responsible_id',
        //           'tasks.title',
        //           'tasks.content',
        //           'tasks.category_id',
        //           'tasks.start_date',
        //           'tasks.end_date',
        //           'base1.data_content_name as status_name',
        //           'base2.data_content_name as category_name',
        //           )
        // -> join('tasks', function($join) {
        //   $join->on('tasks.project_id','=','projects.id');
        // })
        // -> join('basedata as base1', function($base1){
        //   $base1->on('base1.data_content_code','=','tasks.task_status_id');
        // })
        // -> join('basedata as base2', function($base2){
        //   $base2->on('base2.data_content_code','=','tasks.category_id');
        // })
        // -> where('projects.user_pk', '=', $user_pk)
        // -> where('base1.data_title_code', '=', '0')
        // -> where('base2.data_title_code', '=', '2')
        // -> get();

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
                        $join->on('tasks.project_id','=','projects.user_pk');
                      })
                      -> join('basedata as base1', function($base1){
                        $base1->on('base1.data_content_code','=','tasks.task_status_id');
                      })
                      -> join('basedata as base2', function($base2){
                        $base2->on('base2.data_content_code','=','tasks.category_id');
                      })
                      -> where('projects.user_pk', '=', $user_pk)
                      -> where('base1.data_title_code', '=', '0')
                      -> where('base2.data_title_code', '=', '2')
                      -> get();
        // dd($tkdata);


        // 업무 시작/마감일자 d-day 설정
        foreach ($tkdata as $items) {
          $start = Carbon::create($items->start_date);
          $end = Carbon::create($items->end_date);
          // $dday[] = $start->diffInDays($end);
          $items->dday = $start->diffInDays($end); // tkdata에 dday 추가
        }

        dd($tkdata);

        return view('project_individual')->with('result',$result)->with('data',$tkdata);
    }
}


