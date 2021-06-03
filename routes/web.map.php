<?php

/*
|--------------------------------------------------------------------------
|dispatch Web Routes
|--------------------------------------------------------------------------
|
*/
Route::prefix('maps')->group(function () {
	//test save function
	Route::get('test-save/{long}/{lat}', 'MapController@testSave');
	
	//view map function
	Route::get('view-map/', 'MapController@ViewMap');
	
	//get map details function
	Route::post('get-map/', 'MapController@getMap');
});
?>