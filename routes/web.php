<?php

//dash board
Route::get('dash', 'UnderWriterController@index');
//dash board
Route::get('crm-dashbord', 'UnderWriterController@crmDashbord');
//filter agent data
Route::get('get-agents', 'CustomerController@getAgents');
//filter main group data
Route::get('get-main-group', 'CustomerController@getMainGroup');
//filter main group data
Route::get('get-main-group-id', 'CustomerController@getMainGroupIds');
//filter level
Route::get('get-level', 'CustomerController@getLevel');
//filter customer
Route::get('get-customer', 'CustomerController@getCustomer');
//filter case manager
Route::get('get-case-manager', 'CustomerController@getCaseManagers');
//filter case manager
Route::get('get-dispatch-type', 'CustomerController@getDispatchType');
//filter delivery mode
Route::get('get-delivery-mode', 'CustomerController@getDeliveryMode');
//filter assigned to
Route::get('get-assigned-to', 'CustomerController@getAssignedTo');
//filter departmets
Route::get('get-departmets', 'CustomerController@getDepartment');
//filter work types
Route::get('get-work-types', 'CustomerController@getWorkTypes');
//filter current status
Route::get('get-current-status', 'CustomerController@getCurrentStatus');
//filter insurer
Route::get('filter-insurer', 'CustomerController@filterInsurer');
//clossed pipelines list view page
Route::get('closed-pipelines', ['as' => 'closed-pipelines', 'uses' =>'CloseController@closedPipelines']);
//reinstate pipelines list
Route::get('reinstate-item/{id}', 'CloseController@reinstateItem');

//login page view
Route::get('/', ['as' => 'login', 'uses' => 'LoginController@index']);
//save customer
Route::post('customers-save', 'CustomerController@store');
//list customers
Route::get('customers/{customerMode}/show', ['as' => 'customer', 'uses' => 'CustomerController@index']);
//view save customer page
Route::get('customers/create', 'CustomerController@create');

//create insurer page
Route::get('insurers/create', 'InsurersController@create'); 
//save insurer
Route::post('insurers-save', 'InsurersController@store');
//list insurer
Route::get('insurers/show', ['as' => 'insurers', 'uses' => 'InsurersController@index']);
//view insurer datatable
Route::post('insurers/insurers-data', 'InsurersController@dataTable');
//delete insurer page
Route::get('insurers/delete/{insurer}', 'InsurersController@destroy');
//create insurer page
Route::post('insurers/create/validate_email', 'InsurersController@validate_email');
//view insurer page
Route::get('insurers-show/{insurer}', ['as' => 'insurers', 'uses' => 'InsurersController@show']); 
//view edit insurers details
Route::get('insurers/{insurer}/edit', ['as' => 'insurers','uses' =>'InsurersController@edit']);
//view edit insurers password
Route::get('insurers/{insurer}/update', ['as' => 'insurers','uses' =>'InsurersController@update']);
//reset insurer password
Route::post('insurers-psave', 'InsurersController@pstore');
//view add login insurers details
Route::get('insurers/{insurer}/addLogin', ['as' => 'insurers','uses' =>'InsurersController@addLogin']);
//save add login insurers details
Route::get('insurers/addLogin', ['as' => 'insurers','uses' =>'InsurersController@addLoginSave']);
//update insurer email and login status
Route::get('update-insurer-email-loginStatus', 'InsurersController@insurerUpdate');


//view pending issuence page
Route::get('pending-issuance', ['as' => 'pending-issuance', 'uses' =>'PendingApprovalController@showIssuance']);
//issuece listing
Route::post('get-issuance', 'PendingApprovalController@issuanceData');
//view edit customer details
Route::get('customers/{customer}/edit', ['as' => 'customer','uses' =>'CustomerController@edit']);
//update customer page
Route::post('customers/update', 'CustomerController@update');
//view customer page
Route::get('customers-show/{customer}', ['as' => 'customer', 'uses' => 'CustomerController@show']);
//delete customer page
Route::get('customers/delete/{customer}', 'CustomerController@destroy');
//view customer datatable
Route::post('customers/customers-data', 'CustomerController@dataTable');
//export customers
Route::post('export-customers', 'ExcelController@exportCustomers');
//export closed list
Route::get('export-closed', 'CloseController@exportClosed');
//test function
Route::get('test', 'CustomerViewController@test');
//show users
// Route::get('users-show/{users}', ['as' => 'dispatch/view-user', 'uses' => 'DispatchController@show']);
//view create work type page
Route::get('work-types', 'WorkTypeController@index');
//create work type page
Route::get('work-types/create', 'WorkTypeController@create');
//get agent
Route::get('get-agent', 'WorkTypeController@getAgent');
//save worktype
Route::post('work-types-save', 'WorkTypeController@store');

//view pipelines listing page
Route::get('pipelines', ['as' => 'pipeline', 'uses' => 'PipelineController@index']);
//pipeline get ajax data
Route::post('pipelines/data', 'PipelineController@dataTable');
//get pending approval data table
Route::post('pending/get-data', 'PendingApprovalController@dataTable');
//view pending invoice
Route::get('pending/view-pending-details/{worktypeid}', ['as' => 'pending-approvals', 'uses' => 'PendingApprovalController@viewPendingDetails']);
//approve pending details
Route::get('pending/approve-details', 'PendingApprovalController@approveDetails');
//view policies page
Route::get('policies', ['as' => 'policies', 'uses' =>'PolicyController@index']);
//view pending approvals
Route::get('pending-approvals', ['as' => 'pending-approvals', 'uses' =>'PendingApprovalController@index']);
//view e qustionnaire page
Route::get('e-questionnaire/{worktypeid}', ['as' => 'pipeline', 'uses' => 'PipelineController@eQuestionnaire']);
//view e slip page
Route::get('e-slip/{worktypeid}', ['as' => 'pipeline', 'uses' => 'PipelineController@eSlip']);
//view e quaotation
Route::get('e-quotation/{pipelineId}', ['as' => 'pipeline', 'uses' => 'PipelineController@eQuotations']);
//view quote ammendement page
Route::get('quot-amendment/{pipeline_id}', ['as' => 'pipeline', 'uses' => 'PipelineController@quoteAmendment']);
//view e comparison
Route::get('e-comparison/{pipelineId}', ['as' => 'pipeline', 'uses' => 'PipelineController@eComparison']);
//view approved quote
Route::get('approved-quot/{pipelineId}', ['as' => 'pipeline', 'uses' => 'PipelineController@approvedEquot']);
// //view issuence list page
// Route::get('issuance/{pipelineId}', ['as' => 'pending-issuance', 'uses' =>'PipelineController@issuance']);
//approve issuance
Route::get('issuance-complete', 'PipelineController@issuanceComplete');
//upload file
Route::post('worktype-fileupload', 'WorkTypeController@worktypeFileupload');
//Route::post('questionnaire-fileupload', 'PipelineController@questionnaireFileupload');
//export pipeline list
Route::get('export-pipeline', 'ExcelController@exportPipeline');
//export issuance list
Route::get('export-issuance', 'PendingApprovalController@issuanceExport');
//export pending list
Route::get('pending/export-pending-list', 'ExcelController@exportPendingList');
//view e questionnire for customer
Route::get('customer-questionnaire/{token}', 'CustomerViewController@displayQuestionnaire');
//add comment
Route::get('add-comment', 'UnderWriterController@addComment');
//get comment
Route::get('get-comment', 'UnderWriterController@getComment');
//get files
Route::get('get-files', 'UnderWriterController@getFiles');
//save customer response from e questionnaire
Route::post('customer-fill', 'CustomerViewController@store');
//save account details for issuance
Route::post('save-account', 'PipelineController@saveAccounts');
//save customer decision for e compariosn
Route::post('customer-save', 'CustomerViewController@decisionSave');
//send e questionnaire for insurers
Route::post('send-questionnaire', 'UnderWriterController@sendQuestionnaire');
//send comparison for customers
Route::post('send-comparison', 'UnderWriterController@sendComparison');
//view comparison page for customers
Route::get('view-comparison/{token}', 'CustomerViewController@customerViewComparison');

Route::get('customer-approve', 'CustomerViewController@customerApprove');
Route::get('customer-reject', 'CustomerViewController@customerReject');
Route::get('customer-amend/', 'CustomerViewController@customerAmend');
//ammend quote from e quotation
Route::post('quot-amend', 'UnderWriterController@amendQuot');
Route::post('issuance-amend', 'UnderWriterController@issuanceAmend');
//closed list  datatatble
Route::post('close-data', 'CloseController@closeData');
//get case managers
Route::post('get-active-caseManager', 'PipelineController@getActiveCaseManager');
//save all documents from common file upload page
Route::post('all-documents-save', 'WorkTypeController@allDocumentsSave');

//Route::get('create-excel/{id}','PipelineController@createExcel');
//view compariosn pdf
Route::get('comparison-pdf/{pipelineId}', 'UnderWriterController@savePDF');
//get policylist
Route::post('get-policy', 'PolicyController@fillPolicies');
//close pipeline
Route::post('close-pipeline', 'PipelineController@closePipeline');
//view policy
Route::get('view-policy-details/{pipelineId}', ['as' => 'policies', 'uses' =>'PolicyController@viewPolicy']);
//export policy details
Route::get('policy-export', 'PolicyController@exportExcel');
// //view issuance for insurers
// Route::get('insurer/view-issuance/{token}', 'CustomerViewController@showResponse');



Route::get('insurer/employer-issuance/{token}', 'CustomerViewController@employerIssuance');
Route::get('e-quote-list/{pipelineId}', 'PipelineController@eQuoteList');
Route::get('e-comparison', 'PipelineController@eComparison');
Route::get('e-quote-details', 'PipelineController@eQuoteDetails');
//get insurers
Route::get('get-insurer', 'UnderWriterController@getInsurer');
//ger users for permission in comment
Route::get('get-users', 'UnderWriterController@givePermission');
//get file for sending email
Route::get('email-file', 'UnderWriterController@emailFilesLoad');
//for eslip email
Route::post('email-file-eslip', 'UnderWriterController@emailFilesLoadSlip');
//view imported list in excel upload
Route::get('imported-list', 'PipelineController@ImportedList');
//get states
Route::post('get-states', 'PipelineController@getStates');
//get emirates
Route::post('get-emirates', 'CustomerController@getEmirates');
//save e qusetionnaire
Route::post('equestionnaire-save', 'PipelineController@equestionnaireSave');
//save e slip
Route::post('eslip-save', 'PipelineController@eslipSave');
//save insurence company list
Route::post('insurance-company-save', 'PipelineController@insuranceCompanySave');
//save selcted insures from e quotation
Route::post('save-selected-insurers', 'PipelineController@saveSelectedInsurers');
//save excel insurer reply details temporary
Route::post('save-temporary', 'PipelineController@saveTemporary');
//save excel insurer reply details temporary
Route::post('save-imported-list', 'PipelineController@saveImportedList');
//save permission for comments
Route::post('save-permission', 'UnderWriterController@permissionSave');
//save insurer decision
// Route::post('insurer-decision', 'CustomerViewController@decisionInsurer');
//include_once 'web.customer.php';

//login view page
Route::post('login', 'LoginController@login');
//login redirect page
Route::get(
    'login', function () {
        return redirect('/');
    }
);
//logout page
Route::get('logout', 'LoginController@logout');

//view customer notification
Route::get('customer-notification', 'CustomerViewController@viewNotification');

Route::group(
    ['prefix' => 'insurer'], function () {
        //insurer dashboard
        Route::get('dashboard', 'InsurerController@dashboard');
        //view e quotes
        Route::get('e-quotes-provider', ['as' => 'equoteprovided', 'uses' => 'InsurerController@equotesProviderView']);
        //Route::get('e-quote-details/{pipeLineId}', 'InsurerController@equoteDetailsView');
        // quotes datatable
        Route::post('get-e-quotes', 'InsurerController@fillDatatable');
        //view e quotes
        Route::get('e-quote-details/{pipeLineId}', ['as' => 'equoteprovided', 'uses' => 'InsurerController@quoteDetails']);
        //save insurer reply
        Route::post('save', 'InsurerController@replySave');
        //export e quote list
        Route::get('export-eQuotesProvider', 'InsurerController@eQuotesProvider');
        //export e quotes given list
        Route::get('equotes-given', ['as' => 'equotesgiven', 'uses' => 'InsurerController@equotesGivenView']);
        //given e quotes data table
        Route::post('given-equots', 'InsurerController@givenDatatable');
        //ammend quote for insures
        Route::get('amend-equot/{pipeLineId}/{token}', ['as' => 'equotesgiven', 'uses' => 'InsurerController@quotAmend']);
        //export already provided e quotes
        Route::get('exel-given', 'InsurerController@exportEquotGiven');
        //save as draft for
        Route::post('save-exit', 'InsurerController@saveAndExit');
        //save as draft for
        Route::post('save-draft-exit', 'InsurerController@saveAsDraftAndExit');
        //    Route::post('save-exit-employee','InsurerController@saveExitEmployee');
        Route::post('change-password', 'InsurerController@changePassword');
        //save employer
        Route::post('employer-save', 'InsurerController@employerSave');
        //save property
        Route::post('property-save', 'InsurerController@propertySave');
        //save machinary and plant
        Route::post('plant-save', 'InsurerController@plantSave');
        //save fire and perils
        Route::post('fireperils-save', 'InsurerController@FirePerilsSave');
        //save money
        Route::post('money-save', 'InsurerController@moneySave');
        //save business interruption
        Route::post('business-save', 'InsurerController@businessSave');
        //save machinery
        Route::post('Machinery-Save', 'InsurerController@machinerySave');
    }
);
Route::group(
    ['prefix' => 'insurer'], function () {
        //insurer dashboard
        Route::get('dashboard', 'InsurerController@dashboard');
        //view e quotes
        Route::get('e-quotes-provider', ['as' => 'equoteprovided', 'uses' => 'InsurerController@equotesProviderView']);
        //Route::get('e-quote-details/{pipeLineId}', 'InsurerController@equoteDetailsView');
        // quotes datatable
        Route::post('get-e-quotes', 'InsurerController@fillDatatable');
        //view e quotes
        Route::get('e-quote-details/{pipeLineId}', ['as' => 'equoteprovided', 'uses' => 'InsurerController@quoteDetails']);
        //view e quotes
        Route::get('amend-details/{pipeLineId}/{uniqueToken}', ['as' => 'amendGiven', 'uses' => 'InsurerController@amendDetails']);
        //save insurer reply
        Route::post('save', 'InsurerController@replySave');
        //export e quote list
        Route::get('export-eQuotesProvider', 'InsurerController@eQuotesProvider');
        //export e quotes given list
        Route::get('equotes-given', ['as' => 'equotesgiven', 'uses' => 'InsurerController@equotesGivenView']);
        //given e quotes data table
        Route::post('given-equots', 'InsurerController@givenDatatable');
        //ammend quote for insures
        Route::get('amend-equot/{pipeLineId}/{token}', ['as' => 'equotesgiven', 'uses' => 'InsurerController@quotAmend']);
        //export already provided e quotes
        Route::get('exel-given', 'InsurerController@exportEquotGiven');
        //save as draft for
        Route::post('save-exit', 'InsurerController@saveAndExit');
        //    Route::post('save-exit-employee','InsurerController@saveExitEmployee');
        Route::post('change-password', 'InsurerController@changePassword');
        //save employer
        Route::post('employer-save', 'InsurerController@employerSave');
        //save property
        Route::post('property-save', 'InsurerController@propertySave');
        //save machinary and plant
        Route::post('plant-save', 'InsurerController@plantSave');
        //save fire and perils
        Route::post('fireperils-save', 'InsurerController@FirePerilsSave');
        //save money
        Route::post('money-save', 'InsurerController@moneySave');
        //save business interruption
        Route::post('business-save', 'InsurerController@businessSave');
        //save machinery
        Route::post('Machinery-Save', 'InsurerController@machinerySave');
    }
);

Route::get('get-customers', 'CustomerController@getCustomers');
Route::get('get-recipients-list', 'CustomerController@getRecipientsList');

Route::get('insert-country', 'CustomerController@insertCountry');
Route::post('get-countries-name', 'CustomerController@getCountriesName');

//agent change in customer pge
Route::get('change-agent', 'CustomerController@changeAgent');

//Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
Route::get('test', 'CustomerViewController@test');

//Update User table
Route::get('update-user-table', 'DispatchController@updateLeads');

/* Routes to leave handling module */
require_once 'web.leave.php';

/* Routes to dispatch module */
require_once 'web.dispatch.php';

/* Routes to map */
require_once 'web.map.php';

/* Routes to property */
require_once 'web.property.php';

/* Routes to employers_liability */
require_once 'web.emp_liability.php';

/* Routes to document management */
require_once 'web.document_management.php';

/* Routes to money */
require_once 'web.money.php';

/* Routes to fire and perils */
require_once 'web.fire_perils.php';

/*Routes for Business interruption */
require_once 'web.business_interruption.php';

/* Routes to Machinery Breakdown */
require_once 'web.Machinery_Breakdown.php';

/* Routes to contractors plant */
require_once 'web.contractor_plant.php';

/* Routes to contractors plant */
require_once 'web.enquiry_management.php';

/* Routes to user management */
require_once 'web.user.php';

//test
require_once "web.widget_test.php";

//show users
Route::get('update-permission', 'UserManagementController@updatePermission');



//Routes for insert fields to collection
Route::get('widget-save', 'WidgetsCreationController@widgetSave');
//Routes for update fields in collection
Route::get('widget-update/{id}', 'WidgetsCreationController@widgetUpdate');
//Routes for update steps in collection
Route::get('step-update/{id}', 'WidgetsCreationController@stepUpdate');
//Routes for update steps in collection
Route::get('stage-update', 'WidgetsCreationController@stageUpdate');
//Routes for get review from db
Route::get('get-review', 'WidgetsCreationController@getReviewSlip');



//Routes for link to e questionnaire
Route::get('equestionnaire/{Id}', 'EquestionareController@EQuestionnaire');
Route::post('save-equestionnaire', 'EquestionareController@saveEQuestionnaire');
Route::post('save-multi-documents', 'EquestionareController@saveMultiDocuments');

// Save multiple details
Route::post('save-equestionnaire-multiple-details', 'EquestionareController@saveEQuestionnaireMD');

Route::get('insurer-view/{id}', 'InsurerController@insurerView');
Route::post('save-insurer-response', 'InsurerController@saveInsurerResponse');
//get file for sending email equestionnaire
Route::get('equestionnaire-email-file', 'EquestionareController@equestionnaireFiles');
//send e questionnaire for customer
Route::post('send-questionnaire-email', 'EquestionareController@sendQuestionnaireEmail');
//view e questionnire for customer
Route::get('customer-equestionnaire/{token}', 'EquestionareController@displayEQuestionnaire');
//view customer notification
Route::get('customer-notification-equestionnare/{Id}', 'EquestionareController@viewNotification');

/* Routes for link to e slip */
Route::get('eslip/{Id}', 'EslipController@getEslip');
Route::post('save-eslip', 'EslipController@saveESlip');
Route::get('get-insurer-eslip', 'EslipController@getInsurerListESlip');
Route::post('save-insurer-list', 'EslipController@saveinsurerList');


//Routes for link to e quotation
Route::get('equotation/{Id}', 'EquotationController@EQuotation');
//save comment update
Route::post('eqoutation-edit', 'EquotationController@eqoutationEdit');
//generatePdfOfInsures
Route::post('generate-insurer-pdf', 'EquotationController@generatePdfOfInsures');
//generatePdfOfInsures
Route::get('get-generate-insurer-pdf/{insurerId}/{workTypeId}', 'EquotationController@getGeneratePdfOfInsures');
//save selcted insures from e-quotation
Route::post('equotation-selected-insurers', 'EquotationController@saveSelectedInsurers');

//Routes for link to e comparison
Route::get('ecomparison/{Id}', 'EcomparisonController@EComparison');
Route::post('send-comparison', 'EcomparisonController@SendComparison');
//Route for sending email from ecomparison data to customer
Route::get('ecomparison-proposal/{Id}', 'EcomparisonController@viewComparison');
//Route for ecomparison save
Route::post('customer-decision', 'EcomparisonController@customerDecision');
//Download as pdf in ecomparison
Route::get('ecomparison-pdf/{Id}', 'EcomparisonController@eComparisonPdf');
//lost business
Route::post('lost-business', 'EcomparisonController@lostBusiness');


//Routes for link to quote-amendment
Route::get('quote-amendment/{Id}', 'AmendmentController@quoteAmendment');

//Routes for link to approved e quote
Route::get('approved-equote/{Id}', 'ApprovedEquoteController@ApprovedEquote');
//save account details for issuance
Route::post('save-approved-equote', 'ApprovedEquoteController@saveApprovedEQuote');
//view issuance for insurers
Route::get('insurer/view-issuance/{token}', 'ApprovedEquoteController@showResponse');
//save insurer decision
Route::post('insurer-decision', 'ApprovedEquoteController@decisionInsurer');

///Routes for country emirates
Route::post('get-country-emirates', 'EquestionareController@getCountryEmirates');
///Routes for location form
Route::post('location-form', 'EquestionareController@getLocationForm');
///Routes for show location form
Route::post('show-location-form', 'EquestionareController@getSingleLocationForm');
///Routes for show location form
Route::post('deleteMultiple-form-list', 'EquestionareController@deleteSingleLocationForm');
///Routes for saving feild of equestionnare
Route::post('equestionare-field-save', 'EquestionareController@equestionareFieldSave');


//view issuence list page
Route::get('issuance/{pipelineId}', ['as' => 'pending-issuance', 'uses' =>'PendingIssuanceController@issuance']);
//get files
Route::get('get-uploaded-files', 'EquestionareController@getFiles');
//ger users for permission in comment
Route::get('get-chat-users', 'UserManagementController@getChatUsers');
//save permission for comments
Route::post('save-chat-permission', 'UserManagementController@saveChatPermission');
//get comment
Route::get('get-chat-comment', 'UserManagementController@getChatComment');
//add comment
Route::get('add-chat-comment', 'UserManagementController@addChatComment');

// excel save for temporAry
Route::post('save-excel-temporary', 'EquotationController@saveExcelTemporary');
//save temporary excel sheet
Route::get('excel-imported-list', 'EquotationController@importedlist');
//save excel uploaded data
Route::post('save-excel-imported-list', 'EquotationController@saveExcelImportedList');

// email for insurer with no users
Route::get('get-update-insurer', 'ApprovedEquoteController@getInsurers');



// Buissness Insured to add new worktype buissness entry use url create-business-insured/{worktypeId}
//if we want to add new option to each worktype add create-business-insured/1/{string?}
Route::get('create-business-insured/{worktypeId}/{string?}', 'WidgetsCreationController@createBusinessInsured');
