<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;
class TestController extends Controller
{
    public function index()
    {
        // $result = Comment::with(['tasks','users'])->find(1);
        // $result = [
        //     $result->tasks->title,
        //     $result->users->name
        // ];
        $result = DB::select(
            "SELECT 
                tsk.id
                ,tsk.project_id
                ,pj.project_title
                ,tsk.task_responsible_id
                ,us.name
                ,tsk.task_status_id
                ,base.data_content_name
                ,tsk.priority_id
                ,base2.data_content_name
                ,tsk.category_id
                ,base3.data_content_name
                ,tsk.task_parent
                ,tsk.task_depth
                ,tsk.start_date
                ,tsk.end_date
            FROM tasks tsk
                LEFT JOIN basedata base 
                    ON tsk.task_status_id = base.data_content_code
                    AND base.data_title_code = '0'
                LEFT JOIN basedata base2 
                    ON tsk.priority_id = base2.data_content_code
                    AND base2.data_title_code = '1'
                LEFT JOIN basedata base3 
                    ON tsk.category_id = base3.data_content_code
                    AND base3.data_title_code = '2'
                LEFT JOIN users us
                    ON tsk.task_responsible_id = us.id
                LEFT JOIN projects pj
                    ON tsk.project_id = pj.id
            WHERE tsk.id < 136
            "
        );
        // dd($result);

        // 배열화 가능 테스트
        // foreach ($result as $record){
        //     echo $record->task_parent.'<br>';
        //     if($record->task_parent) {
        //         $nowID=$record->id
        //         $result[$record->task_parent] = [$result->];
        //     }
        // }

        // 버블링과 배열화를 동시에 하는 함수구축

        return view('modal/modaltest');
    }
}
