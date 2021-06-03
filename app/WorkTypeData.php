<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class WorkTypeData extends Model
{
    protected $collection = 'workTypeData';
    
    public function getCustomer()
    {
        return $this->hasOne('App\Customer', '_id', 'customer.id')->where('status', 1);
    }
    public function getInsurer()
    {
        return $this->hasOne('App\Insurer', '_id', 'insuraceCompanyList');
    }
}
