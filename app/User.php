<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Jenssegers\Mongodb\Auth\User as Authenticatable;
use Jenssegers\Mongodb\Eloquent\Model;
use MongoDB\BSON\ObjectId;
use DB;

class User extends Authenticatable
{
    use Notifiable;

    protected $collection = 'users';
    protected $primaryKey = "_id";
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';
	

    public function getParentKey()
    {
        $value = $this->parent->getAttribute($this->localKey);
        return new \MongoId($value);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
//    protected $fillable = [
//        'name', 'email', 'password','_id'
//    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
//    protected $hidden = [
//        'password', 'remember_token',
//    ];

    protected $casts = [
        'createdAt' => 'date',
        'deliveryDate' => 'date'
    ];

    public function roleDetail($ret)
    {
//        $user_role = UserRole::where('userId', new \MongoDB\BSON\ObjectID($this->_id))->first();
//        $user = Role::where('_id',$user_role->roleId)->first();
//        return $user->$ret;
        $user = Role::where('abbreviation',$this->role)->first();
        return $user;
    }

    public function userRole()
    {
        return $this->hasOne('App\Role','abbreviation','role');
    }
}
