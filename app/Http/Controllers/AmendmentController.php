<?php

namespace App\Http\Controllers;
use App\ESlipFormData;
use App\WorkTypeData;
use MongoDB\BSON\ObjectID;

use Illuminate\Http\Request;

class AmendmentController extends Controller
{
    public function quoteAmendment($Id)
    {

        $workTypeDataId = $Id;
        $eComparisonData = [];
        $InsurerData = [];
        $Insurer = [];
        $formValues = WorkTypeData::where('_id', new ObjectId($Id))->first();

        $eSlipFormData = $formValues;
        $d = $eSlipFormData['eSlipData'];
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
        if ($eSlipFormData) {
            $eComparisonData = $eSlipFormData->eSlipData;
            $InsurerList = $eSlipFormData->insurerReply;
            $selectedInsurers =  $eSlipFormData->selected_insurers;
        }

        $final =[];
        if (!empty($InsurerList)) {
            foreach ($InsurerList as $key => $insurer) {
                if (!empty($selectedInsurers)) {
                    foreach ($selectedInsurers as $key1 => $selected) {
                        if (isset($insurer['customerDecision'])) {
                            if ($insurer['quoteStatus'] == 'active') {
                                if ($selected['insurer'] == $insurer['uniqueToken'] && $selected['active_insurer'] == 'active') {
                                    $Insurer[] = $insurer;
                                }
                            }
                        }
                    }
                }
            }
        }
        // print_r($Insurer);
        $InsurerData  = $this->flip($Insurer);
        // dd($InsurerData);
        $title = 'Quote Amendment';
        return view('pages.amendment')->with(compact('workTypeDataId', 'formValues', 'title', 'eComparisonData', 'InsurerData', 'Insurer', 'formData', 'selectedInsurers'));
    }

    public function flip($arr)
    {
        $out = array();
        if (!empty($arr)) {
            foreach ($arr as $key => $subarr) {
                foreach ($subarr as $subkey => $subvalue) {
                    $out[$subkey][$key] = $subvalue;
                }
            }
        }
        return $out;
    }
}
