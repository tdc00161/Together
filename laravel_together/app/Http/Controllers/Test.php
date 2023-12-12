<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\BaseData;
use App\Models\Project;
use App\Models\FriendRequest;
use App\Models\Friendlist;
use App\Models\ProjectUser;
use App\Models\Attachment;
use App\Models\Task;
use App\Models\Comment;

class Test extends Controller
{
    public function index()
    {
        // $result = User::limit(5);
        $result = BaseData::find(5);
        // $result = Project::limit(5);
        // $result = FriendRequest::limit(5);
        // $result = Friendlist::limit(5);
        // $result = ProjectUser::limit(5);
        // $result = Attachment::limit(5);
        // $result = Task::limit(5);
        // $result = Comment::limit(5);
        
        // return response()->json($result);
        return $result;
    }
}
