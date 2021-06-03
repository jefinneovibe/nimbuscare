<?php

// use Symfony\Component\Routing\Route;

/*
|--------------------------------------------------------------------------
|document management route
|--------------------------------------------------------------------------
|
*/

use App\Http\Controllers\DocumenetManagementController;

// Route::prefix('document')->middleware('auth.underwriter')->group(function () {
Route::prefix('document')->group(function () {
    
    /**
     * route to the documentManagement main dashboard
     */
    Route::get('document-dashoard', 'DocumenetManagementController@documentDashboard');

    /**
     * route to sort documents in selected order
     */
    Route::post('dynamic-sort', 'DocumenetManagementController@dynamicSort');

    /**
     * dummy not yet used
     */
    Route::get('view-document', 'DocumenetManagementController@viewDocument');

    /**
     * route to view emails. if user is admin then mails fetch from mail server
     */
    Route::get('view-emails', 'DocumenetManagementController@listEmails');

    /**
     * route to get mail body for function opem mail
     */
    Route::post('get-mail-content', 'DocumenetManagementController@getEmail');

    /**
     * this route is used by select2 assigned to select customer for each document.
     * and response is the list items in the dropdown
     */
    Route::get('get-customers', 'DocumenetManagementController@getCustomer');

    // Route::get('get-customers-in-view', 'DocumenetManagementController@getCustomerInCustomerView');
    
    /**
     * this route is used by select2 assigned to select asignee for each document.
     * and response is the list items in the dropdown
     */
    Route::get('get-agent', 'DocumenetManagementController@getAgent');

    /**
     * route to the page used for add new email credential and status set
     */
    Route::get('document-settings', 'DocumenetManagementController@documentSettings');

    /**
     * Route to the page for view the list of added email credentials
     */
    Route::get('document-view-settings', 'DocumenetManagementController@documentViewSettings');

    /**
     * route to the page for edit added email credential
     */
    Route::get('document-edit-settings/{id}', 'DocumenetManagementController@documentEditSettings');

    /**
     * Route to save new added email credential to db
     */
    Route::post('add-credentials', 'DocumenetManagementController@addCredentials');

    /**
     * Route to edit previously added email credentials in db
     */
    Route::post('edit-credentials', 'DocumenetManagementController@editCredentials');

    /**
     * Route to save the assign idividual selections of each tasks
     * (customer,assignee,status,note1,note2,note3,updated attachment names)
     */
    Route::post('asign-document', 'DocumenetManagementController@asignDocument');

    /**
     * Route to show saved comments in the comment popup
     */
    Route::post('view-comments', 'DocumenetManagementController@viewComments');

    /**
     * Route to save new comment in db
     */
    Route::post('submit-comments', 'DocumenetManagementController@submitComments');

    /**
     * Route to forward task to specified emails with or without cc
     */
    Route::post('forward-document', 'DocumenetManagementController@forwardDocument');

    /**
     * Route to collect attachment details to show in post-customer popup
     */
    Route::post('show-post-costomer', 'DocumenetManagementController@showPostCostomer');

    /**
     * Route to post single attachment to customer
     */
    Route::post('post-customer', 'DocumenetManagementController@postCustomer');

    /**
     * Route to post more than one attachments to customer
     */
    Route::post('post-selected-to-customer', 'DocumenetManagementController@postSelectedToCustomer');

    /**
     * Route to search tasks with entered search string
     * (fields: subject,attachment name,attachment pdf content,mail body)
     */
    Route::post('custom-search', 'DocumenetManagementController@customSearch');

    // Route::post('save-submit', 'DocumenetManagementController@saveSubmitActive');

    /**
     * Route to show closed tasks page
     */
    Route::get('closed-documents', 'DocumenetManagementController@closedDocuments');

    // Route::post('save-submit-closed', 'DocumenetManagementController@saveSubmitClosed');

    /**
     * Route: filter tasks and set filter values to session
     */
    Route::post('custom-filter', 'DocumenetManagementController@customFilter');

    /**
     * Route: find the posible filter option from tasks collection to build the filter pop up
     */
    Route::post('filter-options', 'DocumenetManagementController@filterOptions');

    /**
     * Route: to view the customer view page to employees, admin, agent, coordinator
     */
    Route::get('admin-customer-view', 'DocumenetManagementController@adminCustomerView');
    
    /**
     * Route: to select customer to view the shared documents with them
     */
    Route::post('choose-customer', 'DocumenetManagementController@chooseCustomer');

    /**
     * Route: to remove documents that are previously shared with customer
     */
    Route::post('admin-remove-cust-doc', 'DocumenetManagementController@adminRemoveCustDoc');

    /**
     * Route : to add additional documents to share with customer
     */
    Route::post('add-files', 'DocumenetManagementController@addFiles');

    // Route::post('admin-remove-additional', 'DocumenetManagementController@adminRemoveAdditional');

    /**
     * Route: to find the agent details of customer that is selected for a task
     */
    Route::post('get-agent-details', 'DocumenetManagementController@getAgentDetails');

    /**
     * Route: to download attachment from cloud
     */
    Route::get('download', 'DocumenetManagementController@download');

    // Route::post('get-selected-attachments', 'DocumenetManagementController@getSelectedAttachments');

    /**
     * Route: to build excel sheet detailing the task with applied filter and search options
     */
    Route::get('emails-to-excel/{mailBox}/{status}', 'DocumenetManagementController@emailsToExcel');

    /**
     * Route: to search shared documents with entered key string
     */
    Route::post('search-document', 'DocumenetManagementController@searchDoc');

    /**
     * Route: to find details of selected attachments to bulk download
     */
    Route::post('find-attachments', 'DocumenetManagementController@findAttachments');

    /**
     * Route: to load customer's list in the select2 control in filter
     */
    Route::get('get-customer-management/{box}/{status}', 'DocumenetManagementController@getCustomerManagement');

    /**
     * Route: to delete closed tasks from the closed document page
     */
    Route::post('delete-task', 'DocumenetManagementController@deleteTask');

    /**
     * Route: to load mail addreses from which mail tasks were sent
     */
    Route::get('get-mail-from-filter', 'DocumenetManagementController@getMailFromFilter');

    /**
     * Route: to load customers list respect to the role of loged user in customer view page
     */
    Route::get('get-customers-list', 'DocumenetManagementController@getCustomerInCustomerView');


    /////////////////////////////    MIGRATIONS    //////////////////////////////////////////



    /*migration to update customerDocument collection with agents*/
    Route::get('mig-cust-doc', 'DocumenetManagementController@migrateCustomerDocument');

    /*dummy route to check cronjobs */
    Route::get('cron-check', 'DocumenetManagementController@sendCollectedMails');


    /* migration to update sharedDocument from customerDocuments collection*/
    Route::get('mig-shared-doc', 'DocumenetManagementController@migrateSharedDocument');

    /*      * migration to create time field in emails collection for sorting purpose */
    Route::get('mig-convert-time', 'DocumenetManagementController@convertingToSort');
    Route::get('update-notification', 'DocumenetManagementController@updateNotification');

    /**
     * route to migrate the attachment contents to shared document collection
     */
    Route::get('mig-attach-content-shared', 'DocumenetManagementController@migrateAttachContent');
    


    /////////////////////////////    MIGRATIONS    //////////////////////////////////////////


    //dummy path to auto update emails cronjob.......
    // Route::get('dummy', 'DocumenetManagementController@documentRefreshSchedule');

   
       
    /**
     * test route to test some codes
     */
    Route::get('test', 'DocumenetManagementController@test');
});
// document_management_view_settings
Route::prefix('customer-document')->group(function () {

    /**
     * Route: to download files form cloud
     */
    Route::get('download', 'DocumenetManagementController@download');

    /**
     * Route: to display documents shared with customer when the customer login
     */
    Route::post('customer-document-view', 'DocumenetManagementController@customerDocumentView');

    /**
     * Route: to update the shared document status to "viewed by customer"
     */
    Route::post('customer-viewed', 'DocumenetManagementController@customerView');

    /**
     * Route: to search documents by the entered key string
     */
    Route::post('search-customer-document', 'DocumenetManagementController@searchCustomerDocument');
});
