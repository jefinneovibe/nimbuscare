<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class Counter extends Model
{
    protected $collection = 'counters';
}
