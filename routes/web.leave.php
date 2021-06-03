<?php

/*
|--------------------------------------------------------------------------
| Leave Handling Web Routes
|--------------------------------------------------------------------------
|
*/
Route::prefix('leave')->group(function () {
	//get method
	Route::get('add-leave', 'LeaveController@addLeave');
	//leave list details
	Route::get('leave-list', 'LeaveController@leaveList');
	
	
	//end
	
	//post methods
	Route::post('save-leave','LeaveController@saveLeave');
	//end
});