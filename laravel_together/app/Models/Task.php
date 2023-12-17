<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use App\Models\Project;
use App\Models\Comment;
use App\Models\Attachment;

class Task extends Model // 업무/공지
{
    use HasFactory,SoftDeletes;

       /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'project_id',
        'responsible_id',
        'writer_id',
        'status_id',
        'priority_id',
        'category_id',
        'task_number',
        'task_depth',
        'task_parent',
        'title',
        'content',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // 모델 연관 관리
    public function comments(){
        // return $this->belongsTo(Task::class,'task_id','id'); 이걸 생략하면        
        return $this->hasMany(Comment::class);
    }
    public function  attachments(){      
        return $this->hasMany(Attachment::class);
    }
    public function  projects(){      
        return $this->belongsTo(Project::class);
    }

    // task 깊이별로 가져오기
    public static function depth($task_depth){
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
            WHERE tsk.task_depth = " . $task_depth
        );

        return $result;
    }
}
