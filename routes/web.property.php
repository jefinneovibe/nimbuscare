<?php

/*
|--------------------------------------------------------------------------
|Property Web Routes
|--------------------------------------------------------------------------
|
*/
Route::prefix('property')->group(function () {
    //get///

    //e questtionare
    Route::get('e-questionnaire/{id}', ['as' => 'pipeline', 'uses' =>'PropertyController@eQuestionaire']);
    //e slip 
    Route::get('e-slip/{id}', ['as' => 'pipeline', 'uses' =>'PropertyController@ESlip']);
    //e quotation
    Route::get('e-quotation/{id}', ['as' => 'pipeline', 'uses' =>'PropertyController@eQuotation']);
    //customer qestionnaire page
    Route::get('customer-questionnaire/{id}', 'PropertyController@customerQuestionnaire');
    //view imported slip
    Route::get('imported-list', ['as' => 'pipeline', 'uses' =>'PropertyController@importedList']);
    //e comparison
    Route::get('e-comparison/{id}', ['as' => 'pipeline', 'uses' =>'PropertyController@eComparison']);
    //e comparison 
    Route::get('view-comparison/{id}', 'PropertyController@viewComparison');
    //e comparison
    Route::get('comparison-pdf/{id}', 'PropertyController@comparisonPdf');
    //quote ammnedment page
    Route::get('quot-amendment/{id}', ['as' => 'pipeline', 'uses' =>'PropertyController@quotAmendment']);
    //quote ammnedment page
    Route::get('approved-quot/{id}', ['as' => 'pipeline', 'uses' =>'PropertyController@approvedQuot']);
    //issuance view page
    Route::get('issuance/{id}', ['as' => 'pending-issuance', 'uses' =>'PropertyController@issuance']);
    //view pending issuance
    Route::get('view-pending-details/{id}', ['as' => 'pending-approvals', 'uses' => 'PropertyController@viewPendingDetails']);
    //view pending issuance
    Route::get('view-policy-details/{id}', ['as' => 'policies', 'uses' =>'PropertyController@viewPolicyDetails']);

    //end get//

    //post//
    //save e qustionnaire
    Route::post('equestionnaire-save', 'PropertyController@equestionnaireSave');
    //send e qustionnaire
    Route::post('send-questionnaire', 'PropertyController@sendQuestionnaire');
    //save eslip
    Route::post('eslip-save', 'PropertyController@eslipSave');
    //save insurance company and send excel to insurers
    Route::post('insurance-company-save', 'PropertyController@insuranceCompanySave');
    //amend quot from quotation
    Route::post('quot-amend', 'PropertyController@quotAmend');
    //save imported list
    Route::post('save-imported-list', 'PropertyController@saveImportedList');

    //end post//
});
