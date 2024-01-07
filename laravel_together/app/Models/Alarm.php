<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Alarm extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'listener_id',
        'content',
        'created_at',
    ];

    public $timestamps = ["created_at"];
}
