<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
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
}
