<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// to check login authentication
Route::post('login','ApiController@Login');
// delivery lead  list
Route::post('deliverylist','ApiController@DeliveryList');
// to get lead list(not use)
Route::post('getlead','ApiController@getlead');
// to get lead Details of corresponding lead (not use)
Route::post('getleaddetails','ApiController@getleadDetails');
//  update data from api **not used**
Route::post('savelead','ApiController@saveLead');
// Add Comments
Route::post('addcomments','ApiController@AddComments');
//Upload Signature (not use)
Route::post('uploadsign','ApiController@UploadSign');
//upload file for individual documents
Route::post('uploadfile','ApiController@UploadFile');
//save file for individual documents
Route::post('savefile','ApiController@SaveFile');
//save delivery **currently using**
Route::post('save','ApiController@Save');
//approve lead from schedule for delivery
Route::post('approvelead','ApiController@ApproveLead');
//approve lead from schedule for delivery
Route::post('rejectlead','ApiController@RejectLead');
//upload file for individual documents
Route::post('signupload','ApiController@SignUpload');
//save file for individual documents
Route::post('signsave','ApiController@SignSave');
//save live location
Route::post('livelocation','ApiController@saveLiveLocation');
//update token api
Route::post('updatetoken','ApiController@updateToken');
