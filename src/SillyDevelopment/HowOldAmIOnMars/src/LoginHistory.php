<?php

namespace SillyDevelopment\HowOldAmIOnMars;

use Illuminate\Database\Eloquent\Model;

class LoginHistory extends Model
{
    protected $fillable = [
        'user_id',
        'created_at'
    ];
}
