<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class EmailCredentials extends Model
{
    protected $collection='emailDocumentCredentials';
}
