<?php

namespace App\Http\Controllers;

use App\Events\AlarmEvent;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{
    // 댓글 작성
    public function store(Request $request, $id) // 업무 id
    {
        $responseData = [
            "code" => "0",
            "msg" => "",
            "data" => []
        ];
        // Log::debug('cookie: '.$request->cookie('user'));
        // Log::debug('Auth: '. Auth::id());
        
        $usr = Auth::id();
        $con = $request['content'];
        
        $request['task_id'] = $id;
        $request['user_id'] = $usr;
        $request['content'] = $con;

        // Log::debug([$request,$id]);
        $result = Comment::create($request->toArray());
        $responsible = Task::where('id',$id)->select('task_responsible_id')->first();

        if (!$result) {
            $responseData['code'] = 'E01';
            $responseData['msg'] = $id.' is no where';
        } else {
            $responseData['code'] = 'C01';
            $responseData['msg'] = 'comment created.';
            $responseData['data'] = $result;

            // 업무 담당자에게 이벤트 발생
            if($responsible->task_responsible_id !== null){
                $data = [];
                $data['user'] = User::find($usr);
                $data['task'] = Task::find($id);
                $AlarmEvent = new AlarmEvent(['CC',$responsible->task_responsible_id,$data]);
                $AlarmEvent->newAlarm();  
            }
        }
        
        
        return $responseData;
    }

    // 댓글 수정
    public function update(Request $request,$id)
    {
        $responseData = [
            "code" => "E01",
            "msg" => "댓글을 찾을 수 없습니다",
            "data" => []
        ];
        // Log::debug('cookie: '.$request->cookie('user'));
        // Log::debug('Auth: '. Auth::id());
        
        // Log::debug($request);
        $usr = Auth::id();
        $con = $request['content']; 
        $tsk = $request['task_id']; 
        
        // $this_comment = DB::table('comments')->where('id',$id)->get();
        $this_comment = Comment::where('id',$id)->get();
        // Log::debug($this_comment);
        // Log::debug(gettype($this_comment[0]->user_id).' : '.gettype($usr));
        // Log::debug(gettype($this_comment[0]->id).' : '.gettype($id));
        // Log::debug($this_comment[0]->id === $id);
        // Log::debug($this_comment[0]->user_id === (int)$usr);
        
        if(empty($this_comment)) {
            return $responseData;
        } else if($this_comment[0]->id != $id || $this_comment[0]->user_id != (int)$usr || $this_comment[0]->task_id != $tsk) {
            $responseData['msg'] = '자신의 댓글이 아닙니다.';
            return $responseData;
        }

        $this_comment[0]->content = $con;
        
        // Log::debug($this_comment[0]->content);

        $result = $this_comment[0]->save();

        if (!$result) {
            $responseData['code'] = 'E01';
            $responseData['msg'] = $id.' is no where';
        } else {
            $responseData['code'] = 'U01';
            $responseData['msg'] = 'comment updated.';
            $responseData['data'] = $this_comment;
        }        
        
        return $responseData;
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
