<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class Role extends Model
{
    protected $collection = 'roles';
    protected $primaryKey = "_id";

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';
}
