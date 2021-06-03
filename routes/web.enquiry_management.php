<?php
/*
|--------------------------------------------------------------------------
|Enquiry management route
|--------------------------------------------------------------------------
|
*/
// Route::prefix('enquiry')->middleware('auth.underwriter')->group(function () {
Route::prefix('enquiry')->group(function () {

    //enquiry dashboard //
    Route::get('enquiry-dashboard', 'EnquiryManagementController@enquiryDashboard');

    /**
     * route to sort documents in selected order
     */
    Route::post('dynamic-sort', 'EnquiryManagementController@dynamicSort');


    //function for load all emails
    Route::get('view-enquiries', 'EnquiryManagementController@viewEnquiries');
    //clossed enquiry listing page
    Route::get('closed-enquiry', 'EnquiryManagementController@closedDocuments');
    //latest comments listing page
     Route::get('latest-comments', 'EnquiryManagementController@latestComments');
    //save customer,agent etc details
    Route::post('assign-document', 'EnquiryManagementController@asignDocument');
    //get mail content from mail box
    Route::post('get-mail-content', 'EnquiryManagementController@getEmail');
    //function for forward document
    Route::post('forward-document', 'EnquiryManagementController@forwardDocument');
    //funvtion for view comments
    Route::post('view-comments', 'EnquiryManagementController@viewComments');
    //save comments
    Route::post('submit-comments', 'EnquiryManagementController@submitComments');
    //filter function
    Route::post('custom-filter', 'EnquiryManagementController@customFilter');
    //show filter and prefill data
    Route::post('filter-options', 'EnquiryManagementController@filterOptions');
    //search option
    Route::post('custom-search', 'EnquiryManagementController@customSearch');
    //function for downloading as excel
    Route::get('emails-to-excel/{mailBox}/{status}', 'EnquiryManagementController@emailsToExcel');
    //get insrer list
    Route::get('get-insurer', 'EnquiryManagementController@getInsurer');

    // view credetial listing page //
    Route::get('enquiry-view-settings', 'EnquiryManagementController@enquiryViewSettings');
    //edit credetial listing page
    Route::get('enquiry-edit-settings/{id}', 'EnquiryManagementController@enquiryEditSettings');
    //edit credential function
    Route::post('edit-credentials', 'EnquiryManagementController@editCredentials');
    //add credential function
    Route::post('add-credentials', 'EnquiryManagementController@addCredentials');
    //view enquiry settings page
    Route::get('enquiry-settings', 'EnquiryManagementController@enquirySettings');
    //function for renewal reminder cron job
    Route::get('renewalReminder', 'EnquiryManagementController@renewalReminder');
    //cron job for auto refresh and save
    Route::get('refresh-enquiry', 'EnquiryManagementController@refreshEnquiry');
    Route::get('setrequstss', 'EnquiryManagementController@setrequstss');
    //get agent for listing page
    Route::get('get-agent', 'EnquiryManagementController@getAgent');
    //get customer for search
    Route::get('get-customer-management/{box}/{status}', 'EnquiryManagementController@getCustomerManagement');
     //get insurer for search
    Route::get('get-insurer-management/{box}/{status}', 'EnquiryManagementController@getInsurerManagement');
    Route::get('upload-insurer-bulk', 'EnquiryManagementController@uploadInsurerBulk');
    Route::get('convert-id', 'EnquiryManagementController@convertId');
    Route::post('get-agent-details', 'EnquiryManagementController@getAgentDetails');
    Route::post('delete-enquiry', 'EnquiryManagementController@deleteEnquiry');
    Route::post('find-attachments', 'EnquiryManagementController@findAttachments');
    //save activity logs
    Route::post('save-log', 'EnquiryManagementController@saveLog');
    //view action report page
    Route::get('view-action-report', 'EnquiryManagementController@viewActionReport');
    //dowload action level report excel
    Route::get('download-action-report', 'EnquiryManagementController@downloadActionReport');
    //change date format in existing data
    Route::get('change-date-format', 'EnquiryManagementController@changeDateFormat');
    //function for view add and edit group details
    Route::get('enquiry-group-settings/{id}', 'EnquiryManagementController@enquiryGroupSettings');
    //save group details
    Route::post('add-group-data', 'EnquiryManagementController@addGroupData');
    //add new sub status
    Route::get('enquiry-substatus/{id}', 'EnquiryManagementController@enquirySubstatus');
    //get sub status of selected status
    Route::post('get-subStatus', 'EnquiryManagementController@getSubStatus');
    //add sub status of selected status
    Route::post('add-sub-status', 'EnquiryManagementController@addSubStatus');
    //get substatus list
    Route::post('get-substatus-list', 'EnquiryManagementController@getSubstatusList');
    //get status
    Route::post('get-status', 'EnquiryManagementController@getStatus');
    //add status
    Route::post('add-status', 'EnquiryManagementController@addStatus');

    // migrations //

    /*
    to set customer for previously fetched unselected customered mails.
    that contains customer code at the subject line
    */
    Route::get('set-tsk-cust', 'EnquiryManagementController@setCustomerForOldTasks');
    //add uniq id for existing status
    Route::get('add-uniq', 'EnquiryManagementController@addUniq');
});
