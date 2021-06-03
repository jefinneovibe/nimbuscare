<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class RecipientDetails extends Model
{
	protected $collection = 'recipientsDetails ';
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
		'email',
		'contactNumber',
		'status',
		'fullName',
		'countryName',
		'cityName',
		'created_by',
		'zipCode',
		'streetName',
		'departmentDetails',
	];
	
	public function getMainGroup(){
		return $this->hasOne('App\recipientsDetails','_id','mainGroup.id');
	}
	
	public function getLevel(){
		return $this->hasOne('App\CustomerLevel','_id','customerLevel');
	}
	
	public function getType(){
		return $this->hasOne('App\CustomerType','_id','customerType');
	}
	
	public function getCountry(){
		return $this->hasOne('App\Country', '_id', 'country');
	}
	
	public function getCity(){
		return $this->hasOne('App\City', '_id', 'city');
	}
	
	public function getAgent(){
		return $this->hasOne('App\Agent', '_id', 'agent');
	}
	public function getDepartment(){
		return $this->hasOne('App\Departments', '_id', 'department');
	}
	
}
