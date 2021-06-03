<?php

/*
|--------------------------------------------------------------------------
|Property Web Routes
|--------------------------------------------------------------------------
|
 */
Route::prefix('business_interruption')->group(
    function () {
        //get///

        //e questtionare
        Route::get('e-questionnaire/{id}', ['as' => 'pipeline', 'uses' =>'BusinessController@eQuestionaire']);
        // //e slip
        Route::get('e-slip/{id}', ['as' => 'pipeline', 'uses' =>'BusinessController@ESlip']);
        // //e quotation
        Route::get('e-quotation/{id}', ['as' => 'pipeline', 'uses' =>'BusinessController@eQuotation']);
        // //customer qestionnaire page
        Route::get('customer-questionnaire/{id}', 'BusinessController@customerQuestionnaire');
        //get imported page
        Route::get('imported-list', ['as' => 'pipeline', 'uses' =>'BusinessController@importedList']);
        //view e comparison
        Route::get('e-comparison/{pipelineId}', ['as' => 'pipeline', 'uses' =>'BusinessController@eComparison']);
        //view comparison page for customers
        Route::get('view-comparison/{token}', 'BusinessController@customerViewComparison');
        //view compariosn pdf
        Route::get('comparison-pdf/{pipelineId}', 'BusinessController@savePDF');
        //view quote ammendement page
        Route::get('quot-amendment/{pipeline_id}', ['as' => 'pipeline', 'uses' =>'BusinessController@quoteAmendment']);
        //view approved quote
        Route::get('approved-quot/{pipelineId}', ['as' => 'pipeline', 'uses' =>'BusinessController@approvedEquot']);
        //view issuence list page
        Route::get('issuance/{pipelineId}', ['as' => 'pending-issuance', 'uses' =>'BusinessController@issuance']);
        // view #regionpending-details
        Route::get('view-pending-details/{id}', ['as' => 'pending-approvals', 'uses' =>'BusinessController@viewPendingDetails']);
        // view policy details
        Route::get('view-policy-details/{id}', ['as' => 'policies', 'uses' =>'BusinessController@viewPolicy']);

        //end get//

        //post//
        //save e qustionnaire
        Route::post('equestionnaire-save', 'BusinessController@equestionnaireSave');
        // //send e qustionnaire
        Route::post('send-questionnaire', 'BusinessController@sendQuestionnaire');
        //save eslip
        Route::post('eslip-save', 'BusinessController@eslipSave');
        // //save insurance company and send excel to insurers
        Route::post('insurance-company-save', 'BusinessController@insuranceCompanySave');
        //save excel to pipeline in e quotation
        Route::post('save-imported-list', 'BusinessController@saveImportedList');
        //ammend quote from e quotation
        Route::post('quot-amend', 'BusinessController@amendQuot');
        //save selcted insures from e quotation
        Route::post('save-selected-insurers', 'BusinessController@saveSelectedInsurers');
        //send comparison for customers
        Route::post('send-comparison', 'BusinessController@sendComparison');
        //save customer decision for e compariosn
        Route::post('customer-save', 'BusinessController@decisionSave');
        //save account details for issuance
        Route::post('save-account', 'BusinessController@saveAccounts');
        //end post//
    }
);
