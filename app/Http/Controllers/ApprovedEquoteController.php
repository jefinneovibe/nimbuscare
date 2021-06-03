<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;

use App\ESlipFormData;
use App\Insurer;
use App\WorkTypeData;
use MongoDB\BSON\ObjectID;
use App\Jobs\SendComparison;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Jobs\IssuanceProposal;
use App\WorkTypeForms;
use Illuminate\Support\Facades\Session;

class ApprovedEquoteController extends Controller
{
    public function ApprovedEquote($Id) //call initial widgets page
    {
        $workTypeDataId = $Id;
        $eComparisonData = [];
        $InsurerData = [];
        $Insurer = [];
        $formValues = WorkTypeData::where('_id', new ObjectId($Id))->first();
        $workTypeId = $formValues->workTypeId['id'];
        $forms = WorkTypeForms :: where("worktypeId", $workTypeId)->first();
        $eslipForms=@$forms->stages["eSlip"]["steps"]["forms"]["rows"]?:[];
        foreach($eslipForms as $eslipForm){
            $eslipForm=$eslipForm["fields"];
            foreach($eslipForm as $eslipFor){
                $eslipFor=$eslipFor["config"];
                    if(@$eslipFor["premium"]==true){
                        $premium_fieldName=$eslipFor["fieldName"];
                    }else if(@$eslipFor["commission"]==true){
                        $brokerage_fieldName=$eslipFor["fieldName"];
                    }
            }
        }
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
        if($eSlipFormData) {
            $eComparisonData = $eSlipFormData->eSlipData;
            $InsurerList = $eSlipFormData->insurerReply;
            $selectedInsurers =  $eSlipFormData->selected_insurers;
        }

        $final =[];
        if ($InsurerList) {
            foreach ($InsurerList as $key =>$insurer) {
                if ($selectedInsurers) {
                    foreach ($selectedInsurers as $key1 =>$selected) {
                        if ($insurer['quoteStatus'] == 'active') {
                            if ($selected['insurer'] == $insurer['uniqueToken']) {
                                if (!empty($insurer['customerDecision']) && $insurer['customerDecision']['decision'] == "Approved" && $selected['active_insurer'] == 'active') {
                                    $Insurer[] = $insurer;
                                }
                            }
                        }
                    }
                }
            }
        }
        $InsurerData  = $this->flip($Insurer);
        $title = 'Approved E-Quote';
        $pipeline_details = $formValues;
        $pipeline_details->insurer_premium=@$Insurer[0][$premium_fieldName]["agreeStatus"];
        $pipeline_details->insurer_brokerage=@$Insurer[0][$brokerage_fieldName]["agreeStatus"];
        // $formValues->insurer_premium=@$pipeline_details->insurer_premium;
        $formValues->insurer_brokerage=@$pipeline_details->insurer_brokerage;
        if(@$pipeline_details->insurer_premium){
            $pipeline_details->insurer_premium=(float)str_replace(",", "", "$pipeline_details->insurer_premium");
            $formValues->insurer_premium=$pipeline_details->insurer_premium;
        }  
        $formValues->save();
        return view('pages.approvedEquote')->with(compact('workTypeDataId', 'formValues', 'title', 'eComparisonData', 'InsurerData', 'Insurer', 'formData', 'selectedInsurers', 'pipeline_details'));
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
       /**
        * Functon for save account details in approved e quotes
        */
    public function saveApprovedEQuote(Request $request)
    {
        $id = $request->input('workTypeDataId');
        $pipelineItem = WorkTypeData::find(new ObjectId($id));

        // try {
        $accounts_object = new \stdClass();
        $accounts_object->premium = str_replace(',', '', $request->input('premium'));
        $request->input('');
        $accounts_object->vatPercent = $request->input('vat');
        $accounts_object->vatTotal = str_replace(',', '', $request->input('vat_total'));
        $accounts_object->commissionPercent = $request->input('commision');
        $accounts_object->commissionPremium = str_replace(',', '', $request->input('commission_premium_amount'));
        $accounts_object->commissionVat = str_replace(',', '', $request->input('commission_vat_amount'));
        $accounts_object->insurerDiscount = str_replace(',', '', $request->input('insurer_discount'));
        $accounts_object->iibDiscount = str_replace(',', '', $request->input('iib_discount'));
        $accounts_object->insurerFees = str_replace(',', '', $request->input('insurer_fees'));
        $accounts_object->iibFees = str_replace(',', '', $request->input('iib_fees'));
        $accounts_object->agentCommissionPecent = $request->input('agent_commission_percent');
        $accounts_object->agentCommissionAmount = str_replace(',', '', $request->input('agent_commission'));
        $accounts_object->payableToInsurer = str_replace(',', '', $request->input('payable_to_insurer'));
        $accounts_object->payableByClient = str_replace(',', '', $request->input('payable_by_client'));
        $accounts_object->noOfInstallment = str_replace(',', '', $request->input('no_of_installments'));
        $accounts_object->updateProvision = str_replace(',', '', $request->input('update_provision'));
        $accounts_object->insurerPolicyNumber = str_replace(',', '', $request->input('policy_no'));
        $accounts_object->iibPolicyNumber = str_replace(',', '', $request->input('iib_policy_no'));
        $accounts_object->premiumInvoice = str_replace(',', '', $request->input('premium_invoice'));
        $accounts_object->premiumInvoiceDate = str_replace(',', '', $request->input('premium_invoice_date'));
        $accounts_object->commissionInvoice = str_replace(',', '', $request->input('commission_invoice'));
        $accounts_object->commissionInvoiceDate = $request->input('commission_invoice_date');
        $accounts_object->inceptionDate = $request->input('inception_date');
        $accounts_object->expiryDate = $request->input('expiry_date');
        $accounts_object->currency = $request->input('currency');
        $accounts_object->paymentMode = $request->input('payment_mode');
        $accounts_object->chequeNumber = $request->input('cheque_no');
        $accounts_object->datePaymentInsurer = $request->input('date_send');
        $accounts_object->insurenceCompany = $request->input('insurer_name');
        $accounts_object->paymentStatus = $request->input('payment_status');
        $accounts_object->delivaryMode = $request->input('delivery_mode');
        $pipelineItem->accountsDetails = $accounts_object;
        $pipelineItem->save();

        if ($request->input('type') != 'draft') {
            if ($request->input('page') == 'issuance') {
                $requestedApproval = new \stdClass();
                $requestedApproval->id = new ObjectId(Auth::id());
                $requestedApproval->name = Auth::user()->name;
                $requestedApproval->date = date('d/m/Y');
                WorkTypeData::where('_id', $id)->update(array('pipelineStatus' => 'pending', 'accountsDetails.requestedForApproval' => $requestedApproval));
                $pipelineItem->refresh();
                $item = $pipelineItem;
                $updatedBy_obj = new \stdClass();
                $updatedBy_obj->id = new ObjectID(Auth::id());
                $updatedBy_obj->name = Auth::user()->name;
                $updatedBy_obj->date = date('d/m/Y');
                $updatedBy_obj->action = "Issuance Completed";
                $updatedBy[] = $updatedBy_obj;
                ESlipFormData::where('workTypeDataId', new ObjectId($id))->push('updatedBy', $updatedBy);
                // $item->push('updatedBy', $updatedBy);
                // $item->save();
            } elseif ($request->input('page') == 'pending') {
                WorkTypeData::where('_id', $id)->update(array('pipelineStatus' => 'approved'));
                $pipelineItem->refresh();
                $item = $pipelineItem;
                $updatedBy_obj = new \stdClass();
                $updatedBy_obj->id = new ObjectID(Auth::id());
                $updatedBy_obj->name = Auth::user()->name;
                $updatedBy_obj->date = date('d/m/Y');
                $updatedBy_obj->action = "Approved";
                $updatedBy[] = $updatedBy_obj;
                ESlipFormData::where('workTypeDataId', new ObjectId($id))->push('updatedBy', $updatedBy);
                $customerId = $item->getCustomer->_id;
                $customerDetails = Customer::find($customerId);
                $policyObject = new \stdClass();
                $policyObject->policyNumber = $item['accountsDetails']['insurerPolicyNumber'];
                $policyarray[] = $policyObject;
                $customerDetails->policyDetails = $policyarray;
                $customerDetails->save();
                $approvedBy = new \stdClass();
                $approvedBy->id = new ObjectId(Auth::id());
                $approvedBy->name = Auth::user()->name;
                $approvedBy->date = date('d/m/y');
                $item->approvedBy = $approvedBy;
                $item->save();
                return 'success';
            } else {
                WorkTypeData::where('_id', new ObjectId($id))->update(array('pipelineStatus' => 'issuance', 'insurerResponse.mailStatus' => 'active', 'insurerResponse.response' => ''));
                $pipelineItem->refresh();
                $pipeline_details = $pipelineItem;
                $insurerReplay = $pipeline_details['insurerReply'];
                foreach ($insurerReplay as $insures_rep) {
                    if (isset($insures_rep['customerDecision'])) {
                        if ($insures_rep['quoteStatus'] == 'active' && $insures_rep['customerDecision']['decision'] == 'Approved') {
                            $insures_details = $insures_rep;
                            break;
                        }
                    }
                }
                $insurer_id = new ObjectId($insures_details['insurerDetails']['insurerId']);
                $users = User::where('userType', 'insurer')->where('insurer.id', $insurer_id)->get();
                $token = $pipeline_details['comparisonToken']['token'];
                $workType = $pipeline_details->workTypeId['name'];

                $link = url('insurer/view-issuance/' . $token);
                $customer_name = $pipeline_details['customer']['name'];
                foreach ($users as $user) {
                    $name = $user['name'];
                    $email = $user['email'];
                    // if (isset($email) && !empty($email)) {
                        IssuanceProposal::dispatch($name, $email, $customer_name, $link, $workType);
                    // }
                }
                // $item = ESlipFormData::where('workTypeDataId', $id)->first();
                $updatedBy_obj = new \stdClass();
                $updatedBy_obj->id = new ObjectID(Auth::id());
                $updatedBy_obj->name = Auth::user()->name;
                $updatedBy_obj->date = date('d/m/Y');
                $updatedBy_obj->action = "Approved e quot filled";
                $updatedBy[] = $updatedBy_obj;
                // $item->push('updatedBy', $updatedBy);
                // $item->save();
                WorkTypeData::where('_id', new ObjectId($id))->push('updatedBy', $updatedBy);
            }
        } else {
            $updatedBy_obj = new \stdClass();
            $updatedBy_obj->id = new ObjectID(Auth::id());
            $updatedBy_obj->name = Auth::user()->name;
            $updatedBy_obj->date = date('d/m/Y');
            $updatedBy_obj->action = "Accounts saved as draft";
            $updatedBy[] = $updatedBy_obj;
            WorkTypeData::where('_id', new ObjectId($id))->push('updatedBy', $updatedBy);
        }
        Session::flash('success', 'E Quote Approved Successfully.');
        return 'success';
        // } catch (\Exception $e) {
        //     return 'failed';
        // }
    }



    /**
     * show response for ecompariosn
     */
    public function showResponse($token)
    {
        $pipeline_details = WorkTypeData::where('comparisonToken.token', $token)->first();
        if (isset($pipeline_details->insurerResponse['mailStatus'])) {
            if ($pipeline_details->insurerResponse['mailStatus'] == 'active') {
                $insurerReplay = $pipeline_details['insurerReply'];
                foreach ($insurerReplay as $insures_rep) {
                    if (isset($insures_rep['customerDecision'])) {
                        if ($insures_rep['quoteStatus'] == 'active' && $insures_rep['customerDecision']['decision'] == 'Approved') {
                            $insures_details = $insures_rep;
                            break;
                        }
                    }
                }
                $pipelineId = $pipeline_details->_id;
                $workType = $pipeline_details->workTypeId['name'];


                $eQuotationData = [];
                $InsurerData = [];
                $Insurer = [];
                $formValues = $pipeline_details;

                $d = $pipeline_details['eSlipData'];
                $formData = [];
                if (!empty($d)) {
                    foreach ($d as $step => $value) {
                        foreach ($value as $key => $val) {
                            $formData[$val['fieldName']] = $val;
                        }
                    }
                }
                if ($pipeline_details) {
                    $eQuotationData = $pipeline_details->eSlipData;
                    $Insurer = [];
                    foreach ($pipeline_details->insurerReply as $insurer) {
                        if ($pipeline_details->selected_insurers) {
                            foreach ($pipeline_details->selected_insurers as $selected) {
                                if ($insurer['quoteStatus'] == 'active') {
                                    if ($selected['insurer'] == $insurer['uniqueToken']) {
                                        if (!empty($insurer['customerDecision']) && $insurer['customerDecision']['decision'] == "Approved") {
                                            $Insurer[] = $insurer;
                                        }

                                    }
                                }
                            }
                        }
                    }
                    $InsurerData  = $this->flip($Insurer);
                }

                    return view('pages.insurer_view_approval')->with(
                        compact(
                            'pipelineId',
                            'pipeline_details',
                            'insures_details',
                            'InsurerData',
                            'formValues',
                            'formData',
                            'Insurer'
                        )
                    );
            } else {
                Session::flash('msg', 'You have already responded to the request');
                return redirect('customer-notification');
            }
        } else {
            return view('error');
        }
    }
     /**
      * save insrer decision
      */
    public function decisionInsurer(Request $request)
    {
        $id = $request->input('workTypeDataId');
        $decision = $request->input('insurer_decision');
        $pipeline_details = WorkTypeData::find(new ObjectId($id));
        if ($pipeline_details->insurerResponse['mailStatus'] == 'active') {
            $insurerReplay = $pipeline_details['insurerReply'];
            foreach ($insurerReplay as $insures_rep) {
                if (isset($insures_rep['customerDecision'])) {
                    if ($insures_rep['quoteStatus'] == 'active' && $insures_rep['customerDecision']['decision'] == 'Approved') {
                        $insures_details = $insures_rep;
                        break;
                    }
                }
            }
            if ($decision == 'approved') {
                WorkTypeData::where('_id', new ObjectId($id))->update(array('insurerResponse.response' => 'approved', 'insurerResponse.mailStatus' => 'inactive'));
            } else {
                WorkTypeData::where('_id', new ObjectId($id))->update(array('insurerResponse.response' => 'rejected', 'pipelineStatus' => 'true', 'insurerResponse.mailStatus' => 'inactive'));
            }
            $updatedBy_obj = new \stdClass();
            $updatedBy_obj->id = new ObjectID($insures_details['insurerDetails']['insurerId']);
            $updatedBy_obj->name = $insures_details['insurerDetails']['insurerName'];
            $updatedBy_obj->date = date('d/m/Y');
            $updatedBy_obj->action = "Responded for issuance";
            WorkTypeData::where('_id', new ObjectId($id))->push('updatedBy', $updatedBy_obj);
            Session::flash('msg', 'You have successfully responded to the request');
            return redirect('customer-notification');
        } else {
            Session::flash('msg', 'You have already responded to the request');
            return redirect('customer-notification');
        }
    }


    public function getInsurers()
    {
        // $insurers = Insurer::all();
        // foreach($insurers as $insurer){
        //     $user_name = preg_replace("/[^a-zA-Z0-9]+/", "", strtolower($insurer['name']));
        //     $email = $user_name.'@iib.com';
        //     $user = User::where('insurer.id',$insurer['id'])->where('addedfor','ApprovedEqoute')->first();
        //     $user->name = $insurer['name'];
        //     $user->email = $email;
        //     $user->password = bcrypt('123456');
        //     $user->addedfor = 'ApprovedEqoute';
        //     $user->userType = 'insurer';
        //     $insurer_obj = new \stdClass();
        //     $insurer_obj->id=new ObjectID($insurer['id']);
        //     $insurer_obj->name=$insurer['name'];
        //     $user->insurer = $insurer_obj;
        //     $user->role = 'IN';
        //     $user->role_name = 'Insurer';
        //     $user->save();
        // }
        // return 'succes';
    }

}
