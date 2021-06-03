<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;
use MongoDB\BSON\ObjectID;

class Customer extends Model
{
    protected $collection = 'customers';
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';
    protected $fillable = [
        'salutation',
        'firstName',
        'middleName',
        'lastName',
        'mainGroup',
        'customerLevel',
        'agent',
        'customerType',
        'addressLine1',
        'addressLine2',
    //        'city',
    //        'country',
        'email',
        'contactNumber',
        'status',
        'customerCode',
        'customerMode',
        'fullName',
        'customerCodeValue',
        'countryName',
        'cityName',
        'created_by',
        'zipCode',
        'streetName',
        'departmentDetails',
    ];

    public function getMainGroup()
    {
        return $this->hasOne('App\Customer', '_id', 'mainGroup.id');
    }

    public function getLevel()
    {
        return $this->hasOne('App\CustomerLevel', '_id', 'customerLevel');
    }

    public function getType()
    {
        return $this->hasOne('App\CustomerType', '_id', 'customerType');
    }
    public function getMode()
    {
        return $this->hasOne('App\CustomerMode', '_id', 'customerMode');
    }


    public function getCountry()
    {
        return $this->hasOne('App\Country', '_id', 'country');
    }

    public function getCity()
    {
        return $this->hasOne('App\City', '_id', 'city');
    }

    public function getAgent()
    {
        return $this->hasOne('App\Agent', '_id', 'agent');
    }
    public function getDepartment()
    {
        return $this->hasOne('App\Departments', '_id', 'department');
    }


    //    public function setCustomerTypeAttribute($value)
    //    {
    //        $this->attributes['customerType'] = new ObjectID($value);
    //    }
    //
    //    public function setcustomerLevelAttribute($value)
    //    {
    //        $this->attributes['customerLevel'] = new ObjectID($value);
    //    }
    //
    public function setCityAttribute($value)
    {
        $this->attributes['city'] = new ObjectID($value);
    }

    public function setCountryAttribute($value)
    {
        $this->attributes['country'] = new ObjectID($value);
    }




}
