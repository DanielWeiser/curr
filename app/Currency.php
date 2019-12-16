<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $table = 'currency';

    protected $id = 'id';

    protected $fillable = [
        'curr_name', 'code', 'rate',
    ];
}
