<?php

/*
|--------------------------------------------------------------------------
| Customer Web Routes
|--------------------------------------------------------------------------
|
*/
Route::prefix('customer')->group(function () {
	//get method
	Route::get('customers', 'CustomerController@index');
	Route::get('create', 'CustomerController@create');
	Route::get('customers/{customer}/edit', 'CustomerController@edit');
	
	//end
	
	//post methods
	
	Route::post('customers/update', 'CustomerController@update');
	Route::post('customers', 'CustomerController@store');
	//end
});