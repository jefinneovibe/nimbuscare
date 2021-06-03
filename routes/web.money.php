<?php

/*
|--------------------------------------------------------------------------
|Property Web Routes
|--------------------------------------------------------------------------
|
*/
Route::prefix('money')->group(function () {
    //get///

    //e questtionare
    Route::get('e-questionnaire/{id}', ['as' => 'pipeline', 'uses' =>'MoneyController@eQuestionaire']);
    //e slip
    Route::get('e-slip/{id}', ['as' => 'pipeline', 'uses' =>'MoneyController@ESlip']);
    //e quotation
    Route::get('e-quotation/{id}', ['as' => 'pipeline', 'uses' =>'MoneyController@eQuotation']);
    //customer qestionnaire page
    Route::get('customer-questionnaire/{id}', 'MoneyController@customerQuestionnaire');
    //get imported page
    Route::get('imported-list', ['as' => 'pipeline', 'uses' =>'MoneyController@ImportedList']);
    //view e comparison
    Route::get('e-comparison/{pipelineId}', ['as' => 'pipeline', 'uses' =>'MoneyController@eComparison']);
    //view comparison page for customers
    Route::get('view-comparison/{token}', 'MoneyController@customerViewComparison');
    //view compariosn pdf
    Route::get('comparison-pdf/{pipelineId}', 'MoneyController@savePDF');
    //view quote ammendement page
    Route::get('quot-amendment/{pipeline_id}', ['as' => 'pipeline', 'uses' =>'MoneyController@quoteAmendment']);
    //view approved quote
    Route::get('approved-quot/{pipelineId}', ['as' => 'pipeline', 'uses' =>'MoneyController@approvedEquot']);
    //view issuence list page
    Route::get('issuance/{pipelineId}', ['as' => 'pending-issuance', 'uses' =>'MoneyController@issuance']);
    // view #regionpending-details
    Route::get('view-pending-details/{id}', ['as' => 'pending-approvals', 'uses' => 'MoneyController@viewPendingDetails']);
    // view policy details
    Route::get('view-policy-details/{id}', ['as' => 'policies', 'uses' =>'MoneyController@viewPolicy']);
    

    //end get//

    //post//
    //save e qustionnaire
    Route::post('equestionnaire-save', 'MoneyController@equestionnaireSave');
    //send e qustionnaire
    Route::post('send-questionnaire', 'MoneyController@sendQuestionnaire');
    //save eslip
    Route::post('eslip-save', 'MoneyController@eslipSave');
    //save insurance company and send excel to insurers
    Route::post('insurance-company-save', 'MoneyController@insuranceCompanySave');
    //save excel to pipeline in e quotation
    Route::post('save-imported-list', 'MoneyController@saveImportedList');
    //ammend quote from e quotation
    Route::post('quot-amend', 'MoneyController@amendQuot');
    //save selcted insures from e quotation
    Route::post('save-selected-insurers', 'MoneyController@saveSelectedInsurers');
    //send comparison for customers
    Route::post('send-comparison', 'MoneyController@sendComparison');
    //save customer decision for e compariosn
    Route::post('customer-save', 'MoneyController@decisionSave');
    //save account details for issuance
    Route::post('save-account', 'MoneyController@saveAccounts');
    
    

    //end post//
});
