<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class Enquiries extends Model
{
    //
    protected $collection='enquiries';
    protected $primaryKey = "_id";
    protected $dates=['comments.commentDate'];
}
