<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use App\Models\Task;
use App\Models\User;
use App\Models\BaseData;

class Project extends Model // 프로젝트
{
    use HasFactory,SoftDeletes;

       /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_pk',
        'color_code_pk',
        'project_title',
        'project_content',
        'flg',
        'start_date',
        'end_date',
        'depth_0',
    ];


    protected $table = 'projects'; // 디폴트값을 따르고싶지않다면 테이블명 설정해주면 됨

    // pk 정의(정의하지 않을 경우에는 'id'컬럼을 pk로 인식)
    protected $primaryKey = 'id';

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
    //     return $this->belongsTo(BaseData::class,'color_code');
    // }
    // public function  users(){      
    //     return $this->belongsTo(User::class);
    // }
    public static function project_depth(){
        $result = DB::select(
            "SELECT
                pj.id
                ,pj.user_pk
                ,us.name user_name
                ,pj.color_code_pk
                ,base3.data_content_name project_color
                ,pj.project_title
                ,pj.project_content
                ,pj.flg
                ,pj.start_date
                ,pj.end_date
                ,pj.created_at
                ,pj.updated_at
            FROM projects pj
            LEFT JOIN users us
                ON pj.user_pk = us.id
            LEFT JOIN basedata base3
                ON pj.color_code_pk = base3.id
                AND data_title_code = 3
            "
        );
        return $result;
    }

    public static function project_depth_one($id){
        $result = DB::select(
            "SELECT
                pj.id
                ,pj.user_pk
                ,us.name user_name
                ,pj.color_code_pk
                ,base3.data_content_name project_color
                ,pj.project_title
                ,pj.project_content
                ,pj.flg
                ,pj.start_date
                ,pj.end_date
                ,pj.created_at
                ,pj.updated_at
            FROM projects pj
            LEFT JOIN users us
                ON pj.user_pk = us.id
            LEFT JOIN basedata base3
                ON pj.color_code_pk = base3.id
                AND data_title_code = 3
            WHERE pj.id = " . $id
        );
        return $result;
    }
}
