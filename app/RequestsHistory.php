<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestsHistory extends Model
{
    protected $fillable = [
        'user_id',
        'birthday',
        'created_at'
    ];
}
