<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;
use MongoDB\BSON\ObjectID;

class WorkType extends Model
{
    protected $collection = 'workTypes';
}
