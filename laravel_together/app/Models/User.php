<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\FriendRequest;

use App\Models\Project;
use App\Models\Comment;
use App\Models\ProjectUser;
class User extends Authenticatable // 유저
{
    use HasApiTokens, HasFactory, Notifiable;

 

     //belongsToMany를 사용하여 사용자 간의 다대다 관계를 정의
     public function friends()
     
     {
         $userId = $this->id;
     
         return $this->belongsToMany(User::class, 'friendlists', 'user_id', 'friend_id')
             ->where(function ($query) use ($userId) {
                 $query->where('friend_id', $userId)
                     ->orWhere('user_id', $userId);
             })
             ->whereNull('friendlists.deleted_at');
     }
     

    // 특정 사용자에게 보낸 친구 요청이 있는지 확인
    public function hasPendingFriendRequestTo(User $user)
    {
        return $this->friendRequeststo()->where('from_user_id', $user->id)->exists();
    }

    // 특정 사용자로부터 받은 친구 요청이 있는지 확인
    public function hasPendingFriendRequestFrom(User $user)
    {
        return $this->friendRequestsfrom()->where('to_user_id', $user->id)->exists();
    }

    // 특정 사용자와 이미 친구인지 확인
    public function isFriendWith(User $user)
    {
        // 이미 친구이면서 삭제되지 않았다면
        if ($this->friends()->where('friend_id', $user->id)->exists()) {
            return !$this->friends()->where('friend_id', $user->id)->whereNotNull('deleted_at')->exists();
        }

        // 친구 관계가 아니거나 삭제된 경우
        return false;
    }

    // 유저에게 보낸 친구요청
    public function friendRequeststo()
    {
        return $this->hasMany(FriendRequest::class, 'to_user_id');
    }

     // 유저로 부터 받은 친구요청
    public function friendRequestsfrom()
    {
        return $this->hasMany(FriendRequest::class, 'from_user_id');
    }

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // 모델 연관 관리
    public function comments(){
        // return $this->belongsTo(Task::class,'task_id','id'); 이걸 생략하면        
        return $this->hasMany(Comment::class);
    }
    public function  projects(){      
        return $this->hasMany(Project::class);
    }
    public function  project_users(){      
        return $this->hasMany(ProjectUser::class,'id','member_id');
    }
}
