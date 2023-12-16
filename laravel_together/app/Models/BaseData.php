<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Project;
use App\Models\ProjectUser;

class BaseData extends Model // 데이터
{
    use HasFactory;

       /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'class1',
        'class1_name',
        'class2',
        'class2_name',
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
    // public function color_codes(){
    //     // return $this->belongsTo(Task::class,'task_id','id'); 이걸 생략하면        
    //     return $this->hasMany(Project::class,'id','color_code');
    // }
    // public function  authorities(){
    //     // return $this->belongsTo(Task::class,'task_id','id'); 이걸 생략하면        
    //     return $this->hasMany(ProjectUser::class,'id','authority_id');
    // }
}
