<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{
    // 댓글 작성
    public function store(Request $request, $id) // 업무 id
    {
        // $responseData = [
        //     "code" => "0",
        //     "msg" => "",
        //     "data" => []
        // ];
        // // Log::debug('cookie: '.$request->cookie('user'));
        // // Log::debug('Auth: '. Auth::id());

        // $usr = Auth::id();
        // $con = $request['content']; // TODO: 유효성 처리 추가

        // $request['task_id'] = $id;
        // $request['user_id'] = $usr;
        // $request['content'] = $con;

        Log::debug([$request,$id]);
        // $result = Comment::create($request->toArray());
        // $responseData['msg'] = 'comment created.';
        // $responseData['data'] = $result;


        // return $responseData;
    }

    // 댓글 수정
    public function update($id)
    {
        // $result['task'] = Task::task_detail($id);
        // $result['children'] = Task::task_detail_children($id);
        // $result['comment'] = Task::task_detail_comment($id);

        // // task->depth 값을 보고 부모를 데려올지 결정
        // return $result;
        // if ($result['task'][0]->task_depth !== '0') {
        //     $result['parents'] = Task::task_detail_parents($result['task'][0]->task_depth, $id);
        // }

        // return $result;
    }

    // 댓글 삭제
    public function delete($id)
    {
        $responseData = [
            "code" => "0",
            "msg" => ""
        ];

        $result = DB::table('comments')->where('id',$id);
        if (!$result) {
            $responseData['code'] = 'E01';
            $responseData['msg'] = $id.' is no where';
        } else {
            $result->delete();
            $responseData['code'] = 'D01';
            $responseData['msg'] = 'comment: '.$id.'->deleted.';
        }

        return $responseData;
    }
}
