<?php

/*
|--------------------------------------------------------------------------
|Property Web Routes
|--------------------------------------------------------------------------
|
*/
Route::prefix('fireperils')->group(function () {
    //get///

    //e questtionare
    Route::get('e-questionnaire/{id}', ['as' => 'pipeline', 'uses' =>'FirePerilsController@eQuestionaire']);
    //e slip
    Route::get('e-slip/{id}', ['as' => 'pipeline', 'uses' =>'FirePerilsController@ESlip']);
    //e quotation
    Route::get('e-quotation/{id}', ['as' => 'pipeline', 'uses' =>'FirePerilsController@eQuotation']);
    //customer qestionnaire page
    Route::get('customer-questionnaire/{id}', 'FirePerilsController@customerQuestionnaire');
    //get imported page
    Route::get('imported-list', ['as' => 'pipeline', 'uses' =>'FirePerilsController@ImportedList']);
    //view e comparison
    Route::get('e-comparison/{pipelineId}', ['as' => 'pipeline', 'uses' =>'FirePerilsController@eComparison']);
    //view comparison page for customers
    Route::get('view-comparison/{token}', 'FirePerilsController@viewComparison');
    //view compariosn pdf
    Route::get('comparison-pdf/{pipelineId}', 'FirePerilsController@comparisonPdf');
    //view quote ammendement page
    Route::get('quot-amendment/{pipeline_id}', ['as' => 'pipeline', 'uses' =>'FirePerilsController@quotAmendment']);
    //view approved quote
    Route::get('approved-quot/{pipelineId}', ['as' => 'pipeline', 'uses' =>'FirePerilsController@approvedQuot']);
    //view issuence list page
    Route::get('issuance/{pipelineId}', ['as' => 'pending-issuance', 'uses' =>'FirePerilsController@issuance']);
    // view #regionpending-details
    Route::get('view-pending-details/{id}', ['as' => 'pending-approvals', 'uses' => 'FirePerilsController@viewPendingDetails']);
    // view policy details
    Route::get('view-policy-details/{id}', ['as' => 'policies', 'uses' =>'FirePerilsController@viewPolicy']);
    

    //end get//

    //post//
    //save e qustionnaire
    Route::post('equestionnaire-save', 'FirePerilsController@equestionnaireSave');
    //send e qustionnaire
    Route::post('send-questionnaire', 'FirePerilsController@sendQuestionnaire');
    //save eslip
    Route::post('eslip-save', 'FirePerilsController@eslipSave');
    //save insurance company and send excel to insurers
    Route::post('insurance-company-save', 'FirePerilsController@insuranceCompanySave');
    //save excel to pipeline in e quotation
    Route::post('save-imported-list', 'FirePerilsController@saveImportedList');
    //ammend quote from e quotation
    Route::post('quot-amend', 'FirePerilsController@quotAmend');
    //save selcted insures from e quotation
    Route::post('save-selected-insurers', 'FirePerilsController@saveSelectedInsurers');
    //send comparison for customers
    Route::post('send-comparison', 'FirePerilsController@sendComparison');
    //save customer decision for e compariosn
    Route::post('customer-save', 'FirePerilsController@decisionSave');
    //save account details for issuance
    Route::post('save-account', 'FirePerilsController@saveAccounts');
    
    

    //end post//
});
