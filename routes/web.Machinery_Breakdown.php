<?php

/*
|--------------------------------------------------------------------------
|Property Web Routes
|--------------------------------------------------------------------------
|
 */
Route::prefix('Machinery-Breakdown')->group(function () {
    //get///

    //e questtionare
    Route::get('e-questionnaire/{id}', ['as' => 'pipeline', 'uses' =>'MachineryController@eQuestionaire']);
    // //e slip
    Route::get('e-slip/{id}', ['as' => 'pipeline', 'uses' =>'MachineryController@ESlip']);
    // //e quotation
    Route::get('e-quotation/{id}', ['as' => 'pipeline', 'uses' =>'MachineryController@eQuotation']);
    // //customer qestionnaire page
    Route::get('customer-questionnaire/{id}', 'MachineryController@customerQuestionnaire');
    //get imported page
    Route::get('imported-list', ['as' => 'pipeline', 'uses' =>'MachineryController@importedList']);
    //view e comparison
    Route::get('e-comparison/{pipelineId}', ['as' => 'pipeline', 'uses' =>'MachineryController@eComparison']);
    //view comparison page for customers
    Route::get('view-comparison/{token}', 'MachineryController@customerViewComparison');
    //view compariosn pdf
    Route::get('comparison-pdf/{pipelineId}', 'MachineryController@savePDF');
    //view quote ammendement page
    Route::get('quot-amendment/{pipeline_id}', ['as' => 'pipeline', 'uses' =>'MachineryController@quoteAmendment']);
    //view approved quote
    Route::get('approved-quot/{pipelineId}', ['as' => 'pipeline', 'uses' =>'MachineryController@approvedEquot']);
    //view issuence list page
    Route::get('issuance/{pipelineId}', ['as' => 'pending-issuance', 'uses' =>'MachineryController@issuance']);
    // view #regionpending-details
    Route::get('view-pending-details/{id}', ['as' => 'pending-approvals', 'uses' =>'MachineryController@viewPendingDetails']);
    // view policy details
    Route::get('view-policy-details/{id}', ['as' => 'policies', 'uses' =>'MachineryController@viewPolicy']);

    //end get//

    //post//
    //save e qustionnaire
    Route::post('equestionnaire-save', 'MachineryController@equestionnaireSave');
    // //send e qustionnaire
    Route::post('send-questionnaire', 'MachineryController@sendQuestionnaire');
    //save eslip
    Route::post('eslip-save', 'MachineryController@eslipSave');
    // //save insurance company and send excel to insurers
    Route::post('insurance-company-save', 'MachineryController@insuranceCompanySave');
    //save excel to pipeline in e quotation
    Route::post('save-imported-list', 'MachineryController@saveImportedList');
    //ammend quote from e quotation
    Route::post('quot-amend', 'MachineryController@amendQuot');
    //save selcted insures from e quotation
    Route::post('save-selected-insurers', 'MachineryController@saveSelectedInsurers');
    //send comparison for customers
    Route::post('send-comparison', 'MachineryController@sendComparison');
    //save customer decision for e compariosn
    Route::post('customer-save', 'MachineryController@decisionSave');
    //save account details for issuance
    Route::post('save-account', 'MachineryController@saveAccounts');
    //save account details for issuance
    Route::post('log-out', 'MachineryController@logoutTest');
    //end post//
});
