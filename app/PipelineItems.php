<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class PipelineItems extends Model
{
    protected $collection = 'pipelineItems';

    public function getCustomer()
    {
        return $this->hasOne('App\Customer', '_id', 'customer.id')->where('status', 1);
    }
    public function getInsurer()
    {
        return $this->hasOne('App\Insurer', '_id', 'insuraceCompanyList');
    }
//    public function setCustomerAttribute($value)
    //    {
    //        $this->attributes['customer.id'] = new ObjectID($value);
    //    }
}
