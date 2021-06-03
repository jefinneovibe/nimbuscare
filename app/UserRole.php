<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;
use MongoDB\BSON\ObjectId;

class UserRole extends Model
{
    protected $collection = 'userRoles';
    protected $primaryKey = "_id";

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    public function roleDetail($ret)
    {
        $role = Role::where('_id', new \MongoDB\BSON\ObjectID($this->roleId))->first();
        return $role->$ret;
    }
}
