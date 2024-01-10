<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChatRoom extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'flg',
        'user_count',
        'last_chat',
        'last_chat_created_at',
        'chat_room_name',
    ];
}
