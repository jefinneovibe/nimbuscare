<?php

/*
|--------------------------------------------------------------------------
|contractor plant Web Routes
|--------------------------------------------------------------------------
|
*/
Route::prefix('contractor-plant')->group(function () {
  //get// 
    //e questtionare
    Route::get('e-questionnaire/{id}', ['as' => 'pipeline', 'uses' =>'ContractorPlantController@eQuestionaire']);
    //download excel for e questionnaire
    Route::get('download-excel', 'ContractorPlantController@downloadExcel');
    //download excel for e questionnaire
    Route::get('customer-questionnaire/{token}', 'ContractorPlantController@customerQuestionnaire');
    //download excel for e questionnaire
    Route::get('e-slip/{id}', ['as' => 'pipeline', 'uses' =>'ContractorPlantController@eSlip']);
    //e quotation
    Route::get('e-quotation/{id}', ['as' => 'pipeline', 'uses' =>'ContractorPlantController@eQuotation']);
    //e quotation
    Route::get('e-comparison/{id}', ['as' => 'pipeline', 'uses' =>'ContractorPlantController@eComparison']);
     //view imported list
    Route::get('imported-list', ['as' => 'pipeline', 'uses' =>'ContractorPlantController@importedList']);
     //view customer comparison page
    Route::get('view-comparison/{token}', 'ContractorPlantController@viewComparison');
     //view customer comparison page
    Route::get('comparison-pdf/{id}', 'ContractorPlantController@comparisonPdf');
      //view quote ammendement page
    Route::get('quot-amendment/{pipeline_id}', ['as' => 'pipeline', 'uses' =>'ContractorPlantController@quoteAmendment']);
    //view approved quote
    Route::get('approved-quot/{pipelineId}', ['as' => 'pipeline', 'uses' =>'ContractorPlantController@approvedEquot']);
    //view pending approval
    Route::get('view-pending-details/{pipelineId}', ['as' => 'pending-approvals', 'uses' =>'ContractorPlantController@viewPendingDetails']);
    //view pending issuance
    Route::get('issuance/{pipelineId}', ['as' => 'pending-issuance', 'uses' => 'ContractorPlantController@issuance']);
    //view policy
    Route::get('view-policy-details/{pipelineId}', ['as' => 'policies', 'uses' =>'ContractorPlantController@viewPolicyDetails']);
    //end get//
    //post//
    //save e questionnaire
    Route::post('equestionnaire-save', 'ContractorPlantController@equestionnaireSave');
    //save insurance company
    Route::post('insurance-company-save', 'ContractorPlantController@insuranceCompanySave');
    //download excel for e questionnaire
    Route::post('send-questionnaire', 'ContractorPlantController@sendQuestionnaire');
    //download excel for e questionnaire
    Route::post('eslip-save', 'ContractorPlantController@eslipSave');
     //save insurance company and send excel to insurer
     Route::post('insurance-company-save', 'ContractorPlantController@insuranceCompanySave');
     //save imported list
     Route::post('save-imported-list', 'ContractorPlantController@saveImportedList');
     //save imported list
     Route::post('quot-amend', 'ContractorPlantController@quotAmend');
    //end post//
});
