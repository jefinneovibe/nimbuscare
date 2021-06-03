<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class EnquiryCredentials extends Model
{
    //
    protected $collection='enquiryCredentials';
    protected $primaryKey = "_id";
}
