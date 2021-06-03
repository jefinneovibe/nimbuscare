<?php

/*
|--------------------------------------------------------------------------
|dispatch Web Routes
|--------------------------------------------------------------------------
|
*/ 
Route::prefix('dispatch')->group(function () {
	//get method
	//login dispatch
	Route::get('login', 'LoginController@loginDispatch');
	//dashboard for dispatch
	Route::get('dashboard', 'DispatchController@dashboard');
	//dashboard for creating leads
	Route::get('create-lead', 'DispatchController@createLead');
    //dashboard for deleteing lead
    Route::get('delete-lead/{leads_id}', 'DispatchController@deleteLead');
	//dispatch list details
	Route::get('dispatch-list', 'DispatchController@dispatchList');
	//dispatch list details
	Route::get('leads-data', 'DispatchController@dataTable');
	//dispatch list details
	Route::get('get-all-leads', 'DispatchBulkActionController@getAllLeads');
	//receptionist list details
	Route::get('receptionist-data', 'DispatchController@receptionistData');
	//schedule list details
	Route::get('schedule-data', 'DispatchController@scheduleData');
	//schedule list details
	Route::get('delivery-data', 'DispatchController@deliveryData');
	//test function
	Route::get('update-role', 'DispatchController@updateRolename');
	//export leads details
	Route::post('export-leads', 'DispatchController@exportLeads');
    //export employee details
    Route::post('export-employeeleads', 'DispatchController@exportEmployeeleads');
	//export receptionist details
	Route::post('export-receptionist', 'DispatchController@exportReceptionist');
    //export transferred details
    Route::post('export-transferred', 'DispatchController@exportTransferred');
	//export receptionist details
	Route::post('export-schedule-list', 'DispatchController@exportScheduleList');
	//export receptionist details
	Route::post('export-delivery-list', 'DispatchController@exportDeliveryList');
	//export receptionist details
	Route::post('export-completed-list', 'DispatchController@exportCompletedList');
	//receptionist list page
	Route::get('receptionist-list', 'DispatchController@receptionistList');
	//schedule delivery listing page
	Route::get('schedule-delivery', 'DispatchController@scheduleDelivery');
	//delivery listing page
	Route::get('delivery', 'DispatchController@delivery');
	//view marked as collected/delivered listing page
    Route::get('employee-view-list','DispatchController@employeeViewList');
    //fill data table in employee login
    Route::get('list-marked','DispatchController@listMarked');
    //export for list in employee login
    Route::get('export-accept','DispatchController@acceptExport');
    //completed leads list
    Route::get('complete-list','DispatchController@listComplete');
    //load completed data table
    Route::get('complete-data','DispatchController@completeData');
    //Transfered leads list
    Route::get('transferred-list','DispatchController@Transferred');
    //transferred list details
    Route::get('transferred-data', 'DispatchController@transferredData');
    //set dispatch status
    Route::get('set-dispatchStatus/{id}','DispatchController@setDispatchStatus');
    //change agent name in lead table
    Route::get('change-agent-lead','DispatchBulkActionController@changeAgentLead');
    //All lead list
    Route::get('all-leads','DispatchBulkActionController@allLeads');
	//filter assigned to
	Route::get('get-dispatch-status', 'DispatchBulkActionController@getDispatchStatus');
	//get reference number
	Route::get('get-ref-number', 'DispatchBulkActionController@getRefNumber');
	//change name and remove space
	Route::get('test-change-name', 'DispatchBulkActionController@testChangeName');
	Route::get('test-change-name-cust', 'DispatchBulkActionController@testChangeNameCustomers');
	Route::get('test-change-name-rec', 'DispatchBulkActionController@testChangeNameRec');
	Route::get('change-pipeline', 'DispatchBulkActionController@ChangePipeline');


    //RECIPIENT DETAILS//////////////////
    //recipients listing page
    Route::get('recipients', ['as' => 'dispatch/recipients', 'uses' =>'DispatchController@recipients']);
    //create recipients page
    Route::get('create-recipients', 'DispatchController@createRecipients');
    //view recipients page
    Route::get('view-recipient/{id}', ['as' => 'dispatch/recipients', 'uses' =>'DispatchController@viewRecipient']);
    //edit recipients page
    Route::get('edit-recipient/{id}', ['as' => 'dispatch/recipients', 'uses' =>'DispatchController@editRecipient']);
    //edit recipients page
    Route::get('change-agent-rec','DispatchController@changeAgentRec');
    
	//END RECIPIENT DETAILS//////////////////
	
	//end
	
	//post methods
	
	//view single lead
	Route::post('view-single-lead','DispatchBulkActionController@viewSingleLead');
	//export recipients details
	Route::post('export-recipients','DispatchController@exportRecipients');
	//login dispatch
	Route::post('dispatch-login', 'LoginController@dispatchLogin');
	//get customer details
	Route::post('get-customer-details','DispatchController@getCustomerDetails');
	//save lead details
	Route::post('save-lead','DispatchController@saveLead');
    //dashboard for update password of  user
    Route::post('change-password', 'DispatchController@changePassword');
	//get lead details
	Route::post('get-lead-details','DispatchController@getLeadDetails');
	//save dispatch form details
	Route::post('save-dispatch-form','DispatchController@saveDispatchForm');
	// save-reception-form
	Route::post('save-reception-form','DispatchController@saveReceptionForm');
    // save-transfer-form
    Route::post('save-transfer-form','DispatchController@saveTransferForm');
	//save-receptionist-reply
	Route::post('save-receptionist-reply','DispatchController@saveReceptionistReply');
	//save-transferred-reply
    Route::post('save-transferred','DispatchController@saveTransferred');
	// save-schedule-form
	Route::post('save-schedule-form','DispatchController@saveScheduleForm');
    // save-employeelist-form
    Route::post('save-employeelist-form','DispatchController@saveEmployeelistForm');
	// save-delivery-form
	Route::post('save-delivery-form','DispatchController@saveDeliveryForm');
    // Remove document
    Route::post('remove-document','DispatchController@Removedocument');
	//save dispatch comment
	Route::post('save-dispatch-comment','DispatchController@saveDispatchComment');
	//load previous  dispatch comment
	Route::post('load-dispatch-comment','DispatchController@loadDispatchComment');
	//get reception details
	Route::post('get-reception-details','DispatchController@getReceptionDetails');
    //get transferred details
    Route::post('get-transferred-details','DispatchController@getTransferredDetails');
	//get employee details
	Route::post('get-employees','DispatchController@getEmployees');
	//get employee details
	Route::post('get-select-all','DispatchController@getSelectAll');
	//employee login
    Route::post('employee-login','DispatchController@employeeLogin');
    //submit lead directly(bulk action)
    Route::post('submit-leads','DispatchBulkActionController@submitLeads');
    //approve all in employee login
    Route::post('accept-all','DispatchBulkActionController@acceptAll');
    //bulk action in scheduled delivery
    Route::post('bulk-schedule','DispatchBulkActionController@bulkSchedule');
    //create label for leads
    Route::post('create-label','DispatchBulkActionController@createLabel');
    //create log leads
    Route::post('create-log','DispatchBulkActionController@createLog');
    //transfer to a employee
    Route::post('transfer-to','DispatchController@transferTo');
    //get-doc-type
    Route::post('get-doc-type','DispatchController@getDocType');
	//get lead
	Route::post('get-approved-item', 'DispatchController@getApprovedItem');
	//get lead
	Route::post('get-transfer-item', 'DispatchController@getTransferItem');
	//get lead when employee
	Route::post('get-employee-operation', 'DispatchController@getEmployeeOperation');
	//save opearations
	Route::post('save-operations', 'DispatchController@saveOperations');
	//creating leads from other
	Route::post('create-lead-other', 'DispatchController@createLeadOther');
	//get assigned list
	Route::post('get-assigned-name','DispatchController@getAssignedName');
	//get agents list
	Route::post('get-agent-name','DispatchController@getAgentName');
	//get transfer list
	Route::post('get-transfer-name','DispatchController@getTransferName');
	
	//RECIPIENT DETAILS//////////////////
    //recipients data  table
    Route::post('recipients-data','DispatchController@recipientsData');
    //save recipients details
    Route::post('save-recipients','DispatchController@saveRecipients');
	//delete recipients details
	Route::post('delete-recipient','DispatchController@deleteRecipient');
    //get document status
    Route::post('get-status','DispatchController@getStatus');
    //get comments
    Route::post('comments_view','DispatchController@CommentsView');
    
    //upload agent
    Route::get('upload-agent','DispatchBulkActionController@uploadAgent');
    //upload customers
    Route::get('upload-customer','DispatchBulkActionController@uploadCustomers');
    
    //upload customers
    Route::get('upload-insurers','DispatchBulkActionController@uploadInsurers');
    //delete customers
    Route::get('delete-customers','DispatchBulkActionController@deleteCustomers');
    //update transfer accepted to mark as completed
    Route::get('update-status','DispatchBulkActionController@UpdateStatus');
    //update transfer accepted to mark as completed
    Route::get('delete-status','DispatchBulkActionController@DeleteStatus');
    
    
    
    
	//END RECIPIENT DETAILS//////////////////
    Route::get('test','DispatchController@test');
    Route::get('change-case','DispatchBulkActionController@changeCase');
    Route::get('change-case-agent','DispatchBulkActionController@changeCaseAgent');
    Route::get('change-case-customer','DispatchBulkActionController@changeCaseCustomers');
	//end
    Route::get('Login','ApiController@Login');

    //remove direct agent
    Route::get('remove-direct-agent', 'DispatchController@replaceAgent');
    
    //remove direct agent
    Route::get('remove-char/{value}', 'DispatchController@RemoveSpecialChapr');
    Route::get('unset-agent', 'DispatchController@unsetAgent');
    Route::get('unset-agent-lead', 'DispatchController@unsetAgentLead');
    
    
});