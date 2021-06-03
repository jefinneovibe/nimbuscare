<?php

namespace App;



use Jenssegers\Mongodb\Eloquent\Model;


class ESlipFormData extends Model
{
    protected $collection = 'eSlipFormData';
    public function getCustomer()
    {
        return $this->hasOne('App\Customer', '_id', 'customer.id')->where('status', 1);
    }
    public function getInsurer()
    {
        return $this->hasOne('App\Insurer', '_id', 'insuraceCompanyList');
    }
}
