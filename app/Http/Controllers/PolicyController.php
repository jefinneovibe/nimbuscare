<?php

namespace App\Http\Controllers;

use App\Agent;
use App\CaseManager;
use App\Customer;
use App\Departments;
use App\ESlipFormData;
use App\Insurer;
use App\PipelineItems;
use App\PipelineStatus;
use App\User;
use App\WorkType;
use App\WorkTypeData;
use Carbon\Carbon;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use MongoDB\BSON\ObjectId;

class PolicyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.underwriter');
    }

    /**
     * view policy listing page
     */
    public function index(Request $request)
    {
        $filter_data = $request->input();
        $mainGroups = $request->input('main_group_id');
        //        $mainGroups = Customer::where('mainGroup.id', '0')->get();
        if (!empty($request->input('work_type'))) {
            $count = 0;
            foreach ($request->input('work_type') as $cust) {
                $objectArray[$count] = new ObjectId($cust);
                $count++;
            }
            $workTypes = WorkType::whereIn('_id', $objectArray)->get();
        } else {
            $workTypes = '';
        }
        if (!empty($request->input('policy_status'))) {
            $count = 0;
            foreach ($request->input('policy_status') as $policyStatus) {
                $objectArray[$count] = $policyStatus;
                $count++;
            }
            $pipeData = WorkTypeData::whereIn('pipelineStatus', $objectArray);
        } else {
            $pipeData= '';
        }
        if (!empty($request->input('agent'))) {
            $count = 0;
            foreach ($request->input('agent') as $cust) {
                $objectArray[$count] = new ObjectId($cust);
                $count++;
            }
            $agents = User::where('isActive', 1)->where('role', 'AG')->whereIn('_id', $objectArray)->get();
        } else {
            $agents = '';
        }

        if (!empty($request->input('case_manager'))) {
            $count = 0;
            foreach ($request->input('case_manager') as $cust) {
                $objectArray[$count] = new ObjectId($cust);
                $count++;
            }
            $caseManagers = User::where('isActive', 1)->where(
                function ($q) {
                    $q->where('role', 'EM')->orWhere('role', 'AD');
                }
            )->whereIn('_id', $objectArray)->get();
        } else {
            $caseManagers = '';
        }

        if (!empty($request->input('customer'))) {
            $count = 0;
            foreach ($request->input('customer') as $cust) {
                $objectArray[$count] = new ObjectId($cust);
                $count++;
            }
            $customers = Customer::whereIn('_id', $objectArray)->get();
        } else {
            $customers = '';
        }
        if (!empty($request->input('department'))) {
            $count = 0;
            foreach ($request->input('department') as $cust) {
                $objectArray[$count] = new ObjectId($cust);
                $count++;
            }
            $departments = Departments::whereIn('_id', $objectArray)->get();
        } else {
            $departments = '';
        }
        if (!empty($request->input('main_group'))) {
            $count = 0;
            foreach ($request->input('main_group') as $cust) {
                if ($cust == "Nil") {
                    $mainArray[$count] = (string) 0;
                }
                if ($cust != '0' && $cust != 'Nil') {
                    $mainArray[$count] = new ObjectId($cust);
                }
                $count++;
            }
            $mainGroupCodes = Customer::whereIn('_id', $mainArray)->get();
        } else {
            $mainGroupCodes = '';
        }

        if (!empty($request->input('insurer'))) {
            $count = 0;
            foreach ($request->input('insurer') as $cust) {
                $objectArray[$count] = new ObjectId($cust);
                $count++;
            }
            $insuranceCompanies = Insurer::whereIn('_id', $objectArray)->get();
        } else {
            $insuranceCompanies = '';
        }
        return view('policies.policies')->with(
            compact(
                'departments',
                'workTypes',
                'mainGroups',
                'pipeData',
                'agents',
                'caseManagers',
                'filter_data',
                'customers',
                'insuranceCompanies',
                'mainGroupCodes'
            )
        );
    }

    /**
     * Function for fill the listing data table
     */

    public function fillPolicies(Request $request)
    {
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $filter = $request->input('search');
        $sort = $request->input('field');
        $jsonFilter = $request->input('filterData');
        session()->put('policy_filter', $jsonFilter);
        session()->put('policy_sort', $sort);
        $filterData = json_decode($jsonFilter);

        /**
         * Conditions for Filtering
*/
        if ($filterData) {
            $pipeData = WorkTypeData::where('pipelineStatus', "approved")->orWhere('pipelineStatus', 'lost business');
            if (!empty($filterData->customer)) {
                $count = 0;
                foreach ($filterData->customer as $cust) {
                    $objectArray[$count] = new ObjectId($cust);
                    $count++;
                }
                $pipeData = $pipeData->whereIn('customer.id', $objectArray);
            }
            if (!empty($filterData->policy_status)) {
                $count = 0;
                foreach ($filterData->policy_status as $policyStatus) {
                    $objectArray[$count] = $policyStatus;
                    $count++;
                }
                $pipeData = $pipeData->whereIn('pipelineStatus', $objectArray);
            }
            if (!empty($filterData->main_group_id)) {
                $pipeData = $pipeData->whereIn('customer.maingroupCode', $filterData->main_group_id);
            }

            if (!empty($filterData->main_group)) {
                $count = 0;
                foreach ($filterData->main_group as $cust) {
                    if ($cust == "Nil") {
                        $mainArray[$count] = (string) 0;
                    }
                    if ($cust != '0' && $cust != 'Nil') {
                        $mainArray[$count] = new ObjectId($cust);
                    }
                    $count++;
                }
                $pipeData = $pipeData->whereIn('customer.maingroupId', $mainArray);
            }

            if (!empty($filterData->department)) {
                $val_array = [];
                foreach ($filterData->department as $cust) {
                    $departmentDet = Departments::find($cust);
                    $val_array[] = $departmentDet->name;
                }
                $pipeData = $pipeData->whereIn('workTypeId.department', $val_array);
            }

            if (!empty($filterData->insurer)) {
                $val_array = [];
                foreach ($filterData->insurer as $cust) {
                    $insurerDet = Insurer::find($cust);
                    $val_array[] = $insurerDet->name;
                }
                $pipeData = $pipeData->whereIn('accountsDetails.insurenceCompany', $val_array);
            }
            if (!empty($filterData->work_type)) {
                $count = 0;
                foreach ($filterData->work_type as $cust) {
                    $objectArray[$count] = new ObjectId($cust);
                    $count++;
                }
                $pipeData = $pipeData->whereIn('workTypeId.id', $objectArray);
            }
            if (!empty($filterData->agent)) {
                $count = 0;
                foreach ($filterData->agent as $cust) {
                    $objectArray[$count] = new ObjectId($cust);
                    $count++;
                }
                $pipeData = $pipeData->whereIn('agent.id', $objectArray);
            }
            if (!empty($filterData->case_manager)) {
                $count = 0;
                foreach ($filterData->case_manager as $cust) {
                    $objectArray[$count] = new ObjectId($cust);
                    $count++;
                }
                $pipeData = $pipeData->whereIn('caseManager.id', $objectArray);
            }
        } else {
            $pipeData = WorkTypeData::where('pipelineStatus', "approved")->orWhere('pipelineStatus', 'lost business');
        }
        $searchField = $request->get('searchField');
        $search = (isset($filter['value'])) ? $filter['value'] : false;

        /**
         * Conditions for Sorting
*/
        if ($sort == "Customer Name") {
            $items1 = $pipeData->orderBy('customer.name');
        } elseif ($sort == "Agent Name") {
            $items1 = $pipeData->orderBy('agent.name');
        } elseif ($sort == "Work Type") {
            $items1 = $pipeData->orderBy('workTypeId.name');
        } else {
            $items1 = $pipeData->orderBy('updated_at', 'desc');
        }
        /**
         * Conditions for searching
*/
        if ($search) {
            $item1 = $items1->where(
                function ($query) use ($search) {
                    $query->where('customer.name', 'like', '%' . $search . '%')
                        ->orwhere('pipelineStatus', 'like', '%' . $search . '%')
                        ->orwhere('accountsDetails.insurerPolicyNumber', 'like', '%' . $search . '%')
                        ->orWhere('workTypeId.name', 'like', '%' . $search . '%')
                        ->orWhere('customer.maingroupName', 'like', '%' . $search . '%')
                        ->orWhere('caseManager.name', 'like', '%' . $search . '%')
                        ->orWhere('formData.policyPeriod.policyFrom', 'like', '%' . $search . '%')
                        ->orwhere('accountsDetails.expiryDate', 'like', '%' . $search . '%')
                        ->orWhere('agent.name', 'like', '%' . $search . '%')
                        ->orWhere('refereneceNumber', 'like', '%' . $search . '%')

                        ->orWhere('createdBy.name', 'like', '%' . $search . '%')
                        ->orWhere('customer.customerCode', 'like', '%' . $search . '%')
                        ->orWhere('customer.maingroupCode', 'like', '%' . $search . '%')
                        ->orWhere('workTypeId.department', 'like', '%' . $search . '%')
                        ->orWhere('accountsDetails.insurerPolicyNumber', 'like', '%' . $search . '%')
                        ->orWhere('accountsDetails.iibPolicyNumber', 'like', '%' . $search . '%')
                        ->orWhere('accountsDetails.insurenceCompany', 'like', '%' . $search . '%')
                        ->orWhere('accountsDetails.inceptionDate', 'like', '%' . $search . '%')
                        ->orWhere('accountsDetails.expiryDate', 'like', '%' . $search . '%')
                        ->orWhere('accountsDetails.currency', 'like', '%' . $search . '%')
                        ->orWhere('accountsDetails.premiumInvoiceDate', 'like', '%' . $search . '%')
                        ->orWhere('accountsDetails.premiumInvoice', 'like', '%' . $search . '%')
                        ->orWhere('accountsDetails.commissionInvoice', 'like', '%' . $search . '%')
                        ->orWhere('accountsDetails.paymentMode', 'like', '%' . $search . '%')
                        ->orWhere('accountsDetails.datePaymentInsurer', 'like', '%' . $search . '%')
                        ->orWhere('accountsDetails.iibFees', 'like', '%' . $search . '%')
                        ->orWhere('accountsDetails.insurerFees', 'like', '%' . $search . '%')
                        ->orWhere('accountsDetails.vatTotal', 'like', '%' . $search . '%')
                        ->orWhere('accountsDetails.commissionPercent', 'like', '%' . $search . '%')
                        ->orWhere('accountsDetails.commissionPremium', 'like', '%' . $search . '%');
                }
            );
            session()->put('policy_search', $search);
        }
        if ($search == "") {
            $item1 = $items1;
            session()->put('search', "");
        }

        $total_items = $item1->count(); // get your total no of data;
        $members_query = $item1;
        $search_count = $members_query->count();
        $item1->skip((int) $start)->take((int) $length);
        $items = $item1->get();
        $datas = [];
        foreach ($items as $item) {
            $referanceNumber = '<a href="' . URL::to('view-policy-details/' . $item->_id) . '" class="table_link" >' . $item->refereneceNumber . '</a>';
            $id = @$item->getCustomer->customerCode;
            $seen = $item->commentSeen;
            if (in_array(new ObjectID(Auth::id()), $item->commentPermission)) {
                if ($seen) {
                    if (!in_array(Auth::id(), $seen)) {
                        $comments = $item->comments;
                        if ($comments) {
                            $newComment = end($comments);
                            $commentDisplay = $newComment['commentBy'] . ' (' . $newComment['userType'] . ') : ' . $newComment['comment'];
                            $category = '<div class="name_sec"><span>' . $item->workTypeId['name'] . '</span><i data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="' . $commentDisplay . '" class="fa fa-comments"></i></div>';
                            //                $category = $item->workTypeId['name'].'<i class="material-icons">forum</i>';
                        } else {
                            $category = '<div class="name_sec"><span>' . $item->workTypeId['name'] . '</span></div>';
                        }
                    } else {
                        $category = '<div class="name_sec"><span>' . $item->workTypeId['name'] . '</span></div>';
                        //                $category = $item->workTypeId['name'];
                    }
                } else {
                    $category = '<div class="name_sec"><span>' . $item->workTypeId['name'] . '</span></div>';
                }
            } else {
                $category = '<div class="name_sec"><span>' . $item->workTypeId['name'] . '</span></div>';
            }
            if (isset($item->customer['maingroupCode'])) {
                $maingroup_code = $item->customer['maingroupCode'];
            } else {
                $maingroup_code = '--';
            }
            if (isset($item->workTypeId['department'])) {
                $department = $item->workTypeId['department'];
            } else {
                $department = '--';
            }
            $policyNumber = $item['accountsDetails']['insurerPolicyNumber'];
            $name = $item->customer['name'];
            $maingroup = $item->customer['maingroupName'];
            $caseManagers = $item->caseManager['name'];
            // $insurenceDate = $item['formData']['policyPeriod']['policyFrom'];
            // $expDate = $item['accountsDetails']['expiryDate'];
            $agent = $item->agent['name'];
            $created = $item->created_at;
            $created_at = Carbon::parse($created)->format('d-m-Y');
            $created_by = $item->createdBy['name'];
            $id = @$item->getCustomer->customerCode;
            $name = $item->customer['name'];
            $iib_policy = $item['accountsDetails']['iibPolicyNumber'];
            $insurer = $item['accountsDetails']['insurenceCompany'];
            $emailid_1 = @$item->getCustomer->email[0];
            if (isset($item->getCustomer->email[1])) {
                $emailid_2 = $item->getCustomer->email[1];
            } else {
                $emailid_2 = "--";
            }
            $ph_1 = @$item->getCustomer->contactNumber[0];
            if (isset($item->getCustomer->contactNumber[1])) {
                $ph_2 = $item->getCustomer->contactNumber[1];
            } else {
                $ph_2 = "--";
            }
            $inception_date = $item['accountsDetails']['inceptionDate'];
            $expiry_date = $item['accountsDetails']['expiryDate'];
            $currency = $item['accountsDetails']['currency'];
            $invoice_date = $item['accountsDetails']['premiumInvoiceDate'];
            $premium_invoice_no = $item['accountsDetails']['premiumInvoice'];
            $commission_invoice_no = $item['accountsDetails']['commissionInvoice'];
            $payment_mode = $item['accountsDetails']['paymentMode'];
            $policy_delivery_mode = '--';
            $date_send = $item['accountsDetails']['datePaymentInsurer'];
            $approver = $item['approvedBy']['name'] ?: '--';
            $gross_premium = '--';
            if ($item['accountsDetails']['iibFees'] == "") {
                $iib_fees = '--';
            } else {
                $iib_fees = $item['accountsDetails']['iibFees'];
            }
            if ($item['accountsDetails']['insurerFees'] == "") {
                $insurer_fees = '--';
            } else {
                $insurer_fees = $item['accountsDetails']['insurerFees'];
            }
            $iib_vat = '--';
            $insurer_vat = '--';
            $total_vat = $item['accountsDetails']['vatTotal'];
            $commission = $item['accountsDetails']['commissionPercent'];
            if ($commission == "") {
                $commission = '--';
            }

            $total_commission = $item['accountsDetails']['commissionPremium'];
            $agent_commission = $item['accountsDetails']['agentCommissionPecent'];
            $agent_amount = $item['accountsDetails']['agentCommissionAmount'];
            $iib_commission = '--';
            $iib_amount = '--';
            $discount = $item['accountsDetails']['iibDiscount'] ?: '--';
            $total_bill = $item['accountsDetails']['premium'];
            $total_customer = $item['accountsDetails']['payableByClient'];
            $total_insurer = $item['accountsDetails']['payableToInsurer'];
            $pipelineStatus = $item['pipelineStatus']? ucwords(@$item['pipelineStatus']): '--';
            $temp = new \stdClass();
            //            $temp->policyNumber = $policyNumber;
            //            $temp->category = $category;
            //            $temp->mainGroup = $maingroup;
            //            $temp->referenceNumber = $referanceNumber;
            //            $temp->customerName = $name;
            //            $temp->caseManager = $case_manager;
            //            $temp->agent = $agent;
            //            $temp->insurenceDate = $insurenceDate;
            //            $temp->expDate = $expDate;
            //            $temp->expDate = $expDate;
            //              $item->action = $action;
            $temp->category = $category;
            $temp->referenceNumber = $referanceNumber;
            $temp->created_at = $created_at;
            $temp->created_by = $created_by;
            $temp->id = $id;
            $temp->name = $name;
            $temp->maingroup_id = $maingroup_code;
            $temp->mainGroup = $maingroup;
            $temp->pipelineStatus = $pipelineStatus;
            $temp->department = $department;
            $temp->agent = $agent;
            $temp->policyNumber = $policyNumber;
            $temp->iib_policy = $iib_policy;
            $temp->insurer = $insurer;
            $temp->emailid_1 = $emailid_1;
            $temp->emailid_2 = $emailid_2;
            $temp->ph_1 = $ph_1;
            $temp->ph_2 = $ph_2;
            $temp->inception_date = $inception_date;
            $temp->expiry_date = $expiry_date;
            $temp->currency = $currency;
            $temp->invoice_date = $invoice_date;
            $temp->premium_invoice_no = $premium_invoice_no;
            $temp->commission_invoice_no = $commission_invoice_no;
            $temp->payment_mode = $payment_mode;
            $temp->policy_delivery_mode = $policy_delivery_mode;
            $temp->underwriter_name = $caseManagers;
            $temp->date_send = $date_send;
            $temp->approver = $approver;
            $temp->gross_premium = $gross_premium;
            $temp->iib_fees = $iib_fees;
            $temp->insurer_fees = $insurer_fees;
            $temp->iib_vat = $iib_vat;
            $temp->insurer_vat = $insurer_vat;
            $temp->total_vat = $total_vat;
            $temp->commission = $commission;
            $temp->total_commission = $total_commission;
            $temp->agent_commission = $agent_commission;
            $temp->agent_amount = $agent_amount;
            $temp->iib_commission = $iib_commission;
            $temp->iib_amount = $iib_amount;
            $temp->discount = $discount;
            $temp->total_bill = $total_bill;
            $temp->total_customer = $total_customer;
            $temp->total_insurer = $total_insurer;
            $datas[] = $temp;
        }
        if ($search) {
            $filtered_count = $search_count;
        } else {
            $filtered_count = $total_items;
        }
        $data = array(
            'draw' => $draw,
            'recordsTotal' => $total_items,
            'recordsFiltered' => $filtered_count,
            'data' => $datas,
        );
        return json_encode($data);
    }

    /**
     * view policy
     */
    public function viewPolicy($pipelineId)
    {
        $pipeline_details = WorkTypeData::find($pipelineId);
        $workTypeDataId = $pipelineId;
        if (!$pipeline_details) {
            return view('error');
        }

        if ($pipeline_details->pipelineStatus != "approved" && $pipeline_details->pipelineStatus != "lost business" ) {
            return view('error');
        } else {
            $eComparisonData = [];
            $InsurerData = [];
            $Insurer = [];
            $formValues = WorkTypeData::where('_id', new ObjectId($workTypeDataId))->first();

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
                                    if(@$insurer['customerDecision']) {
                                        if(@$insurer['customerDecision']['decision'] == "Approved") {
                                            $Insurer[] = $insurer;
                                        }
                                    } elseif ($pipeline_details->pipelineStatus == 'lost business') {
                                        $Insurer[] = $insurer;
                                    }
                                }
                            }
                        }
                    }
                }
            }
            $InsurerData  = $this->flip($Insurer);
            $title = 'POLICY DETAILS';
            $onclose = 'policies';

            $insurerReplay = $pipeline_details['insurerReply'];
            foreach ($insurerReplay as $insures_rep) {
                if ($insures_rep['quoteStatus'] == 'active' && @$insures_rep['customerDecision']['decision'] == 'Approved') {
                    $insures_details = $insures_rep;
                }
            }
            return view('pages.policy')->with(compact('workTypeDataId', 'formValues', 'title', 'eComparisonData', 'InsurerData', 'Insurer', 'formData', 'selectedInsurers', 'pipeline_details', 'insures_details', 'onclose'));
        }
    }

    /**
     * export as excel in policy
     */
    public function exportExcel()
    {
        $filterData = json_decode(session('policy_filter'));
        $sort = session('policy_sort');
        $search = session('policy_search');
        if ($filterData) {
            $pipeData = WorkTypeData::where('pipelineStatus', "approved")->orWhere('pipelineStatus', 'lost business');
            if (!empty($filterData->customer)) {
                $count = 0;
                foreach ($filterData->customer as $cust) {
                    $objectArray[$count] = new ObjectId($cust);
                    $count++;
                }
                $pipeData = $pipeData->whereIn('customer.id', $objectArray);
            }

            if (!empty($filterData->policy_status)) {
                $count = 0;
                foreach ($filterData->policy_status as $policyStatus) {
                    $objectArray[$count] = $policyStatus;
                    $count++;
                }
                $pipeData = $pipeData->whereIn('pipelineStatus', $objectArray);
            }
            if (!empty($filterData->main_group_id)) {
                $pipeData = $pipeData->whereIn('customer.maingroupCode', $filterData->main_group_id);
            }

            if (!empty($filterData->main_group)) {
                $count = 0;
                foreach ($filterData->main_group as $cust) {
                    if ($cust == "Nil") {
                        $objectArray[$count] = (string) 0;
                    }
                    if ($cust != '0' && $cust != 'Nil') {
                        $objectArray[$count] = new ObjectId($cust);
                    }
                    $count++;
                }
                $pipeData = $pipeData->whereIn('customer.maingroupId', $objectArray);
            }

            if (!empty($filterData->department)) {
                $val_array = [];
                foreach ($filterData->department as $cust) {
                    $departmentDet = Departments::find($cust);
                    $val_array[] = $departmentDet->name;
                }
                $pipeData = $pipeData->whereIn('workTypeId.department', $val_array);
            }
            if (!empty($filterData->work_type)) {
                $count = 0;
                foreach ($filterData->work_type as $cust) {
                    $objectArray[$count] = new ObjectId($cust);
                    $count++;
                }
                $pipeData = $pipeData->whereIn('workTypeId.id', $objectArray);
            }
            if (!empty($filterData->agent)) {
                $count = 0;
                foreach ($filterData->agent as $cust) {
                    $objectArray[$count] = new ObjectId($cust);
                    $count++;
                }
                $pipeData = $pipeData->whereIn('agent.id', $objectArray);
            }
            if (!empty($filterData->case_manager)) {
                $count = 0;
                foreach ($filterData->case_manager as $cust) {
                    $objectArray[$count] = new ObjectId($cust);
                    $count++;
                }
                $pipeData = $pipeData->whereIn('caseManager.id', $objectArray);
            }
            if (!empty($filterData->insurer)) {
                $val_array = [];
                foreach ($filterData->insurer as $cust) {
                    $insurerDet = Insurer::find($cust);
                    $val_array[] = $insurerDet->name;
                }
                $pipeData = $pipeData->whereIn('accountsDetails.insurenceCompany', $val_array);
            }
        } else {
            $pipeData = WorkTypeData::where('pipelineStatus', "approved")->orWhere('pipelineStatus', 'lost business');
        }
        if ($sort == "Customer Name") {
            $items1 = $pipeData->orderBy('customer.name');
        } elseif ($sort == "Agent Name") {
            $items1 = $pipeData->orderBy('agent.name');
        } elseif ($sort == "Category") {
            $items1 = $pipeData->orderBy('workTypeId.name');
        } else {
            $items1 = $pipeData->orderBy('updated_at', 'desc');
        }
        if ($search) {
            $item1 = $items1->where(
                function ($query) use ($search) {
                    $query->where('customer.name', 'like', '%' . $search . '%')
                        ->orwhere('pipelineStatus', 'like', '%' . $search . '%')
                        ->orwhere('accountsDetails.insurerPolicyNumber', 'like', '%' . $search . '%')
                        ->orWhere('workTypeId.name', 'like', '%' . $search . '%')
                        ->orWhere('customer.maingroupName', 'like', '%' . $search . '%')
                        ->orWhere('caseManager.name', 'like', '%' . $search . '%')
                        ->orWhere('formData.policyPeriod.policyFrom', 'like', '%' . $search . '%')
                        ->orwhere('accountsDetails.expiryDate', 'like', '%' . $search . '%')
                        ->orWhere('agent.name', 'like', '%' . $search . '%')

                        ->orWhere('createdBy.name', 'like', '%' . $search . '%')
                        ->orWhere('customer.customerCode', 'like', '%' . $search . '%')
                        ->orWhere('customer.maingroupCode', 'like', '%' . $search . '%')
                        ->orWhere('workTypeId.department', 'like', '%' . $search . '%')
                        ->orWhere('accountsDetails.insurerPolicyNumber', 'like', '%' . $search . '%')
                        ->orWhere('accountsDetails.iibPolicyNumber', 'like', '%' . $search . '%')
                        ->orWhere('accountsDetails.insurenceCompany', 'like', '%' . $search . '%')
                        ->orWhere('accountsDetails.inceptionDate', 'like', '%' . $search . '%')
                        ->orWhere('accountsDetails.expiryDate', 'like', '%' . $search . '%')
                        ->orWhere('accountsDetails.currency', 'like', '%' . $search . '%')
                        ->orWhere('accountsDetails.premiumInvoiceDate', 'like', '%' . $search . '%')
                        ->orWhere('accountsDetails.premiumInvoice', 'like', '%' . $search . '%')
                        ->orWhere('accountsDetails.commissionInvoice', 'like', '%' . $search . '%')
                        ->orWhere('accountsDetails.paymentMode', 'like', '%' . $search . '%')
                        ->orWhere('accountsDetails.datePaymentInsurer', 'like', '%' . $search . '%')
                        ->orWhere('accountsDetails.iibFees', 'like', '%' . $search . '%')
                        ->orWhere('accountsDetails.insurerFees', 'like', '%' . $search . '%')
                        ->orWhere('accountsDetails.vatTotal', 'like', '%' . $search . '%')
                        ->orWhere('accountsDetails.commissionPercent', 'like', '%' . $search . '%')
                        ->orWhere('accountsDetails.commissionPremium', 'like', '%' . $search . '%');
                }
            );
        } else {
            $item1 = $items1;
        }
        $item1 = $item1->get();
        $data[] = array('Policy List');
        $data[] = ['REFERENCE NO', 'DATE CREATED', 'CREATED BY', 'CUSTOMER ID', 'CUSTOMER NAME', 'MAIN GROUP ID', 'MAIN GROUP NAME', 'POLICY STATUS','DEPARTMENT', 'WORK TYPE',
            'AGENT NAME', 'INSURER POLICY NUMBER', 'IIB POLICY NUMBER', 'INSURER', 'INCEPTION DATE', 'EXPIRY DATE', 'CURRENCY', 'INVOICE DATE', 'PREMIUM INVOICE NO',
            'COMMISSION INVOICE NO', 'PAYMENT MODE', 'POLICY DELIVERY MODE', 'NAME OF THE UNDERWRITER', 'DATE PAYMENT SENT TO INSURER', 'ACCOUNTS APPROVER',
            'GROSS PREMIUM', 'IIB FEES', 'INSURER FEES', 'IIB VAT', 'INSURER VAT', 'TOTAL VAT', 'COMMISSION %	', 'TOTAL COMMISSION AMOUNT'];

        foreach ($item1 as $pipeline) {
            if (isset($pipeline->customer['maingroupCode'])) {
                $mainCode = $pipeline->customer['maingroupCode'];
            } else {
                $mainCode = "--";
            }
            if (isset($pipeline->workTypeId['department'])) {
                $department = $pipeline->workTypeId['department'];
            } else {
                $department = "--";
            }
            $pipelineStatus = $pipeline['pipelineStatus']? ucwords(@$pipeline['pipelineStatus']): '--';
            $deliveryMode = '--';
            $caseManagers = $pipeline->caseManager['name'];
            $approver = $pipeline['approvedBy']['name'] ?: '--';
            $grossPremium = '--';
            $iibVat = '--';
            $insurerVat = '--';
            $data[] = array(
                $pipeline->refereneceNumber,
                Carbon::parse($pipeline->created_at)->format('d-m-Y'),
                $pipeline->createdBy['name'],
                $pipeline->customer['customerCode'],
                $pipeline->customer['name'],
                $mainCode,
                $pipeline->customer['maingroupName'],
                $pipelineStatus,
                $department,
                $pipeline->workTypeId['name'],
                $pipeline->agent['name'],
                $pipeline->accountsDetails['insurerPolicyNumber'],
                $pipeline->accountsDetails['iibPolicyNumber'],
                $pipeline->accountsDetails['insurenceCompany'],
                $pipeline->accountsDetails['inceptionDate'],
                $pipeline->accountsDetails['expiryDate'],
                $pipeline->accountsDetails['currency'],
                $pipeline->accountsDetails['premiumInvoiceDate'],
                $pipeline->accountsDetails['premiumInvoice'],
                $pipeline->accountsDetails['commissionInvoice'],
                $pipeline->accountsDetails['paymentMode'],
                $deliveryMode,
                $caseManagers,
                $pipeline->accountsDetails['datePaymentInsurer'],
                $approver,
                $grossPremium,
                $pipeline->accountsDetails['iibFees'],
                $pipeline->accountsDetails['insurerFees'],
                $iibVat,
                $insurerVat,
                $pipeline->accountsDetails['vatTotal'],
                $pipeline->accountsDetails['commissionPercent'],
                $pipeline->accountsDetails['commissionPremium'],
            );
        }
        Excel::create(
            'Policy-List', function ($excel) use ($data) {
                $excel->sheet(
                    'Policy', function ($sheet) use ($data) {
                        $sheet->mergeCells('A1:AF1');
                        $sheet->row(
                            1, function ($row) {
                                $row->setFontSize(15);
                                $row->setFontColor('#ffffff');
                                $row->setBackground('#1155CC');
                            }
                        );
                        $sheet->fromArray($data, null, 'A1', true, false);
                    }
                );
            }
        )->download('xls');
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
