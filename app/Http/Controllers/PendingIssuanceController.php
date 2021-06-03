<?php

namespace App\Http\Controllers;

use App\ESlipFormData;
use App\WorkTypeData;
use MongoDB\BSON\ObjectID;
use Illuminate\Http\Request;

class PendingIssuanceController extends Controller
{
     /**
      * Function for display issuance page
      */
    public function issuance($workTypeDataId)
    {
        $pipeline_details = WorkTypeData::find($workTypeDataId);
        if ($pipeline_details['status']['status'] == 'Worktype Created' || $pipeline_details['status']['status'] == 'E-questionnaire' || $pipeline_details['status']['status'] == 'E-slip' || $pipeline_details['status']['status'] == 'E-quotation'
            || $pipeline_details['status']['status'] == 'Quote Amendment' || $pipeline_details['status']['status'] == 'E-comparison'
        ) {
            return view('error');
        }
        if ($pipeline_details->pipelineStatus != "issuance") {
            return view('error');
        }

        if ($pipeline_details) {
            $eComparisonData = [];
            $InsurerData = [];
            $Insurer = [];
            $formValues = $pipeline_details;
            if(@$pipeline_details->insurer_premium){
                $pipeline_details->insurer_premium=(float)str_replace(",", "", "$pipeline_details->insurer_premium");
                $formValues->insurer_premium=$pipeline_details->insurer_premium;
                $formValues->save();
            }
            $d = $pipeline_details['eSlipData'];
            $formData = [];
            if (!empty($d)) {
                foreach ($d as $step => $value) {
                    foreach ($value as $key => $val) {
                        // if ($val['fieldName'] != 'brokerage' && $val['fieldName'] != 'CombinedOrSeperatedRate') {
                            $formData[$val['fieldName']] = $val;
                        // }
                    }
                }
            }
            $eComparisonData = $pipeline_details->eSlipData;
            $InsurerList = $pipeline_details->insurerReply;
            $selectedInsurers =  $pipeline_details->selected_insurers;

            $final =[];
            if($selectedInsurers) {
                foreach($InsurerList as $key =>$insurer) {
                    if($selectedInsurers) {
                        foreach($selectedInsurers as $key1 =>$selected) {
                            if ($insurer['quoteStatus'] == 'active') {
                                if($selected['insurer'] == $insurer['uniqueToken']) {
                                    if(isset($insurer['customerDecision'])) {
                                        if($insurer['customerDecision']['decision'] == "Approved") {
                                            $Insurer[] = $insurer;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            $InsurerData  = $this->flip($Insurer);
            $title = 'PENDING ISSUANCE';
            $onclose = 'pending-issuance';
            $insurerReplay = $pipeline_details['insurerReply'];
            foreach ($insurerReplay as $insures_rep) {
                if (isset($insures_rep['customerDecision'])) {
                    if ($insures_rep['quoteStatus'] == 'active' && $insures_rep['customerDecision']['decision'] == 'Approved') {
                        $insures_details = $insures_rep;
                        break;
                    }
                }
            }
            return view('pages.pending_issuance')->with(compact('workTypeDataId', 'formValues', 'title', 'eComparisonData', 'InsurerData', 'Insurer', 'formData', 'selectedInsurers', 'pipeline_details', 'insures_details', 'onclose'));
        }
    }


    public function flip($arr)
    {
        $out = array();

        foreach ($arr as $key => $subarr)
        {
            foreach ($subarr as $subkey => $subvalue)
                {
                $out[$subkey][$key] = $subvalue;
            }
        }

        return $out;
    }
}
