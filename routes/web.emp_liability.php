<?php

/*
|--------------------------------------------------------------------------
| Leave Handling Web Routes
|--------------------------------------------------------------------------
|
*/
Route::prefix('employer')->group(function () {
    //get method
    //view e questionnaire
    Route::get('e-questionnaire/{id}', ['as' => 'pipeline', 'uses' =>'EmployersController@eQuestionnaire']);
    
    //view e slip
    Route::get('e-slip/{id}', ['as' => 'pipeline', 'uses' =>'EmployersController@eSlip']);
    //view e quotation
    Route::get('e-quotation/{id}', ['as' => 'pipeline', 'uses' =>'EmployersController@eQuotation']);
    //view imported slip
    Route::get('imported-list', ['as' => 'pipeline', 'uses' => 'EmployersController@importedList']);
    //view e comaprison
    Route::get('e-comparison/{id}', ['as' => 'pipeline', 'uses' =>'EmployersController@eComparison']);
    //view e comaprison login from mail
    Route::get('view-comparison/{id}', 'EmployersController@viewComparison');
    //view e comaprison pdf
    Route::get('comparison-pdf/{id}', 'EmployersController@comparisonPdf');
    //view quot-amendment
    Route::get('quot-amendment/{id}', ['as' => 'pipeline', 'uses' =>'EmployersController@quotAmendment']);
    //view approved quote
    Route::get('approved-quot/{id}', ['as' => 'pipeline', 'uses' =>'EmployersController@approvedQuot']);
    //view issuance
    Route::get('issuance/{id}', ['as' => 'pending-issuance', 'uses' => 'EmployersController@issuance']);
    // view #regionpending-details
    Route::get('view-pending-details/{id}', ['as' => 'pending-approvals', 'uses' => 'EmployersController@viewPendingDetails']);
    // view policy details
    Route::get('view-policy-details/{id}', ['as' => 'policies', 'uses' =>'EmployersController@viewPolicy']);
    // view customer questionnire
    Route::get('customer-questionnaire/{id}', 'EmployersController@customerQuestionnaire');
    
    
    
    //end
    
    //post methods
    
    //save e questionnaire
    Route::post('equestionnaire-save', 'EmployersController@eQuestionnaireSave');
    //save e slip details
    Route::post('eslip-save', 'EmployersController@eslipSave');
    //save details and create excel
    Route::post('insurance-company-save', 'EmployersController@insuranceCompanySave');
    // send questionnaire
    Route::post('send-questionnaire', 'EmployersController@sendQuestionnaire');
    //end
});
