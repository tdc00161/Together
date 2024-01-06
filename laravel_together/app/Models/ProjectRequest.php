<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectRequest extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'project_id',
        'flg',
        'from_user_id',
        'to_user_id',
        'to_user_email',
        'invite_token',
        'status',
    ];
}
