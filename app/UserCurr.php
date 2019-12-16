<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCurr extends Model
{
    protected $table = 'user_curr';

    protected $fillable = [
        'user_id', 'curr_id', 'curr_state', 'req_flag',
    ];
}
