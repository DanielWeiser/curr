<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class MongoRates extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'curr_rates';
}
