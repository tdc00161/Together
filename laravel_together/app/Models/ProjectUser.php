<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Project;
use App\Models\User;
use App\Models\BaseData;

class ProjectUser extends Model // 프로젝트 참여자
{
    use HasFactory,SoftDeletes;

       /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'project_id',
        'authority_id',
        'member_id',
        'created_at'
    ];


    public $timestamps = ["created_at"];

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
    // public function basedata(){
    //     // return $this->belongsTo(Task::class,'task_id','id'); 이걸 생략하면        
    //     return $this->belongsTo(BaseData::class,'authority_id','data_content_name');
    // }
    // public function  users(){      
    //     return $this->belongsTo(User::class);
    // }
    // public function  projects(){      
    //     return $this->belongsTo(Project::class);
    // }
}
