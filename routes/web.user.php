<?php

/*
|--------------------------------------------------------------------------
|Property Web Routes
|--------------------------------------------------------------------------
|
*/
Route::prefix('user')->group(function () {
    //get///

    //view dashboard
    Route::get('dashboard', 'UserManagementController@dashboard');
    //view user
    Route::get('view-user', ['as' => 'user', 'uses' =>'UserManagementController@viewUser']);
    //create user page
    Route::get('create-user', 'UserManagementController@createUser');
    //dashboard for editing user
    Route::get('edit-user/{user_id}', ['as' => 'user', 'uses' =>'UserManagementController@editUser']);
    //deactivate user
    Route::get('delete-user/{user_id}', 'UserManagementController@deleteUser');
    //activate user
    Route::get('activate-user/{user_id}', 'UserManagementController@activateUser');
    //show users
    Route::get('users-show/{users}', ['as' => 'user', 'uses' => 'UserManagementController@show']);
    
    //to select employees for supervisor role
    Route::get('select-employees', ['as' => 'user', 'uses' => 'UserManagementController@selectEmployees']);
    
    //end get//

    //post//
    //user data table
    Route::post('get-user', 'UserManagementController@getUser');
    //save user details
    Route::post('save-user', 'UserManagementController@saveUser');
    //dashboard for update password of  user
    Route::post('update-user-password', 'UserManagementController@updatePassword');
    //end post//
});
