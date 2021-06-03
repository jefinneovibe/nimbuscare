<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class EmployeeDetails extends Model
{
    protected $collection = 'employeeDetails';
    protected $primaryKey = "_id";
}
