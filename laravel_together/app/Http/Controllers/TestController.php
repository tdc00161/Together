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
        // $result = DB::select(
        //     'SELECT
        //         tks.id
        //         ,tks.project_id
        //         ,pj.project_title
        //         ,tks.task_responsible_id
        //         ,us.name
        //         ,tks.task_status_id
        //         ,(SELECT bs1.data_content_name FROM basedata bs1 WHERE bs1.data_title_code = '0' AND tks.task_status_id = bs1.data_content_code) task_status_name
        //         ,tks.priority_id
        //         ,(SELECT bs2.data_content_name FROM basedata bs2 WHERE bs2.data_title_code = '1' AND tks.priority_id = bs2.data_content_code) priority_name
        //         ,tks.category_id
        //         ,(SELECT bs3.data_content_name FROM basedata bs3 WHERE bs3.data_title_code = '2' AND tks.category_id = bs3.data_content_code) category_name
        //         ,tks.task_parent
        //         ,tks.task_depth
        //         ,tks.start_date
        //         ,tks.end_date
        //     FROM tasks tks
        //       JOIN users us
        //         ON tks.task_responsible_id = us.id
        //       JOIN projects pj
        //         ON tks.project_id = pj.id
        //     LIMIT 9
        //     '
        // );
        // dd($result);
        // return view('modal/modaltest');
    }
}
