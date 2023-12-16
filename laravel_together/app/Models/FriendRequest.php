<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FriendRequest extends Model // 친구 요청
{
    use HasFactory,SoftDeletes;

       /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'from_user_email',
        'to_user_email',
        'status',
    ];
    
    public function from_user()
    {
        return $this->belongsTo(User::class, 'from_user_email');
    }

    public function to_user()
    {
        return $this->belongsTo(User::class, 'to_user_email');
    }


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
    // --------------------------------------------------------------
   
}
