<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class Insurer extends Model
{
    protected $collection = 'insurers';
    protected $primaryKey = "_id";
}
