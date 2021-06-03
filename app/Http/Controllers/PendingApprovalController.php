<?php

namespace App\Http\Controllers;

use App\Agent;
use App\CaseManager;
use App\Customer;
use App\Departments;
use App\ESlipFormData;
use App\PipelineItems;
use App\PipelineStatus;
use App\User;
use App\WorkType;
use App\WorkTypeData;
use Carbon\Carbon;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//use Maatwebsite\Excel\Excel;
use Illuminate\Support\Facades\URL;
use MongoDB\BSON\ObjectID;

class PendingApprovalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.underwriter');
    }

    /**
     * pending approval list page
     */
    public function index(Request $request)
    {
        $filter_data = $request->input();
        $mainGroups = $request->input('main_group_id');
        //        $mainGroups = Customer::where('mainGroup.id', '0')->get();
        if (!empty($request->input('work_type'))) {
            $count = 0;
            foreach ($request->input('work_type') as $cust) {
                $workArray[$count] = new ObjectId($cust);
                $count++;
            }
            $workTypes = WorkType::whereIn('_id', $workArray)->get();
        } else {
            $workTypes = '';
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
        return view('pending_approvals.pending_approvals')->with(compact('workTypes', 'mainGroups', 'agents', 'caseManagers', 'filter_data', 'mainGroupCodes', 'customers', 'departments'));
    }

    /**
     * Function for fill the data table
     */
    public function dataTable(Request $request)
    {
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $filter = $request->input('search');
        $sort = $request->input('field');
        $jsonFilter = $request->input('filterData');
        session()->put('filter', $jsonFilter);
        session()->put('sort', $sort);
        $filterData = json_decode($jsonFilter);

        /**
         * Conditions for Filtering
*/
        if ($filterData) {
            $pipeData = WorkTypeData::where('pipelineStatus', "pending");
            if (!empty($filterData->customer)) {
                $count = 0;
                foreach ($filterData->customer as $cust) {
                    $objectArray[$count] = new ObjectId($cust);
                    $count++;
                }
                $pipeData = $pipeData->whereIn('customer.id', $objectArray);
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
            $pipeData = WorkTypeData::where('pipelineStatus', "pending");
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
        } elseif ($sort == "Last Updated At") {
            $items1 = $pipeData->orderBy('updated_at', 'desc');
        } else {
            $items1 = $pipeData->orderBy('updated_at', 'desc');
        }
        /**
         * Conditions for searching
*/
        if ($search) {
            $item1 = $items1->where(
                function ($query) use ($search) {
                    $query->where('refereneceNumber', 'like', '%' . $search . '%')
                        ->orwhere('createdBy.name', 'like', '%' . $search . '%')
                        ->orwhere('customer.customerCode', 'like', '%' . $search . '%')
                        ->orwhere('customer.name', 'like', '%' . $search . '%')
                        ->orwhere('customer.maingroupCode', 'like', '%' . $search . '%')
                        ->orwhere('customer.maingroupName', 'like', '%' . $search . '%')
                        ->orWhere('workTypeId.department', 'like', '%' . $search . '%')
                        ->orWhere('workTypeId.name', 'like', '%' . $search . '%')
                        ->orWhere('agent.name', 'like', '%' . $search . '%')
                        ->orWhere('caseManager.name', 'like', '%' . $search . '%')
                        ->orWhere('accountsDetails.requestedForApproval.name', 'like', '%' . $search . '%')
                        ->orWhere('accountsDetails.requestedForApproval.date', 'like', '%' . $search . '%')
                        ->orWhere('accountsDetails.iibDiscount', 'like', '%' . $search . '%')
                        ->orWhere('accountsDetails.premium', 'like', '%' . $search . '%')
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
                        ->orWhere('accountsDetails.paymentStatus', 'like', '%' . $search . '%')
                        ->orWhere('accountsDetails.datePaymentInsurer', 'like', '%' . $search . '%')
                        ->orWhere('accountsDetails.delivaryMode', 'like', '%' . $search . '%');
                }
            );
            session()->put('search', $search);
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
                $referanceNumber = '<a href="' . URL::to('pending/view-pending-details/' . $item->_id) . '" class="table_link" >' . $item->refereneceNumber . '</a>';

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
            $name = $item->customer['name'];
            $maingroup = $item->customer['maingroupName'];
            $case_manager = $item->caseManager['name'];
            $created_at = $item->created_at;
            $created_at_date = Carbon::parse($created_at)->format('d-m-Y');
            $created_by = $item->createdBy;
            $created_by_name = $created_by['name'];
            $discount = $item['accountsDetails']['iibDiscount'];
            $agent = $item->agent['name'];
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
            if (isset($item->accountsDetails['requestedForApproval'])) {
                $submittedApprovalFrom = $item->accountsDetails['requestedForApproval']['name'];
            } else {
                $submittedApprovalFrom = '--';
            }
            if (isset($item->accountsDetails['requestedForApproval'])) {
                $submittedApprovalOn = $item->accountsDetails['requestedForApproval']['date'];
            } else {
                $submittedApprovalOn = '--';
            }
            $temp = new \stdClass();
            $temp->referenceNumber = $referanceNumber ?: '--';
            $temp->createdAt = $created_at_date ?: '--';
            $temp->createdBy = $created_by_name ?: '--';
            $temp->customerId = $id ?: '--';
            $temp->customerName = $name ?: '--';
            $temp->mainGroupID = $maingroup_code ?: '--';
            $temp->mainGroup = $maingroup ?: '--';
            $temp->department = $department ?: '--';
            $temp->category = $category ?: '--';
            $temp->agent = $agent ?: '--';
            $temp->underWriter = $item->caseManager['name'] ?: '--';
            $temp->submittedApprovalOn = $submittedApprovalOn;
            $temp->submittedApprovalFrom = $submittedApprovalFrom;
            $temp->caseManager = $case_manager ?: '--';
            $temp->discount = $discount ?: '--';
            $temp->totalPremiumAmount = $item['accountsDetails']['premium'] ?: '--';
            $temp->insurerPolicyNumber = $item['accountsDetails']['insurerPolicyNumber'] ?: '--';
            $temp->IIBPolicyNumber = $item['accountsDetails']['iibPolicyNumber'] ?: '--';
            $temp->insurer = $item['accountsDetails']['insurenceCompany'] ?: '--';
            $temp->inceptionDate = $item['accountsDetails']['inceptionDate'] ?: '--';
            $temp->expiryDate = $item['accountsDetails']['expiryDate'] ?: '--';
            $temp->currency = $item['accountsDetails']['currency'] ?: '--';
            $temp->invoiceDate = $item['accountsDetails']['premiumInvoiceDate'] ?: '--';
            $temp->premiumInvoiceNo = $item['accountsDetails']['premiumInvoice'] ?: '--';
            $temp->commissionInvoiceNo = $item['accountsDetails']['commissionInvoice'] ?: '--';
            $temp->paymentMode = $item['accountsDetails']['paymentMode'] ?: '--';
            $temp->paymentStatus = $item['accountsDetails']['paymentStatus'] ?: '--';
            $temp->datepaymentsenttoInsurer = $item['accountsDetails']['datePaymentInsurer'] ?: '--';
            $temp->deliveryMode = $item['accountsDetails']['delivaryMode'] ?: '--';
            $temp->nameoftheunderwriter = '--';
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
     * view pending list page
     */
    public function viewPendingDetails($workTypeDataId)
    {
        $pipeline_details = WorkTypeData::find($workTypeDataId);
        if (!$workTypeDataId) {
            return view('error');
        }
        if ($pipeline_details->pipelineStatus != "pending") {
            return view('error');
        }
        if ($pipeline_details) {

            $eComparisonData = [];
            $InsurerData = [];
            $Insurer = [];
            $formValues = $pipeline_details;

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
                                if($selected['insurer'] == @$insurer['uniqueToken']) {
                                    if(@$insurer['customerDecision']['decision'] == "Approved") {
                                        $Insurer[] = $insurer;
                                    }

                                }
                            }
                        }
                    }
                }
            }
            $InsurerData  = $this->flip($Insurer);
            $title = 'PENDING APPROVAL';
            $onclose = 'pending-approvals';

            $insurerReplay = $pipeline_details['insurerReply'];
            foreach ($insurerReplay as $insures_rep) {
                if (isset($insures_rep['customerDecision'])) {
                    if ($insures_rep['quoteStatus'] == 'active' && @$insures_rep['customerDecision']['decision'] == 'Approved') {
                        $insures_details = $insures_rep;
                    }
                }
            }
            return view('pages.pending_approval')->with(compact('workTypeDataId', 'formValues', 'title', 'eComparisonData', 'InsurerData', 'Insurer', 'formData', 'selectedInsurers', 'pipeline_details', 'insures_details', 'onclose'));
        }
    }
    /**
     * approve pending list
     */
    public function approveDetails(Request $request)
    {
        $id = $request->get('id');
        PipelineItems::where('_id', $id)->update(array('pipelineStatus' => 'approved'));
        $pipeline = PipelineItems::where('_id', $id)->first();
        $item = PipelineItems::where('_id', $id)->first();
        $updatedBy_obj = new \stdClass();
        $updatedBy_obj->id = new ObjectID(Auth::id());
        $updatedBy_obj->name = Auth::user()->name;
        $updatedBy_obj->date = date('d/m/Y');
        $updatedBy_obj->action = "Approved";
        $updatedBy[] = $updatedBy_obj;
        $item->push('updatedBy', $updatedBy);
        $item->save();
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
        $pipeline->approvedBy = $approvedBy;
        $pipeline->save();
        return 'success';
    }

    /**
     * show issuance
     */
    public function showIssuance(Request $request)
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
        if (!empty($request->input('current_status'))) {
            $count = 0;
            foreach ($request->input('current_status') as $cust) {
                $objectArray[$count] = new ObjectId($cust);
                $count++;
            }
            $status = PipelineStatus::whereIn('_id', $objectArray)->get();
        } else {
            $status = '';
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
        return view('pipelines.pending_issuance')->with(
            compact(
                'departments',
                'workTypes',
                'mainGroups',
                'agents',
                'caseManagers',
                'filter_data',
                'status',
                'customers',
                'mainGroupCodes'
            )
        );
    }

    /**
     * issuance datatable
     */
    public function issuanceData(Request $request)
    {
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $filter = $request->input('search');
        $sort = $request->input('field');
        $jsonFilter = $request->input('filterData');
        session()->put('filter', $jsonFilter);
        session()->put('sort', $sort);
        $filterData = json_decode($jsonFilter);

        /**
         * Conditions for Filtering
*/
        if ($filterData) {
            $pipeData = WorkTypeData::where('pipelineStatus', "issuance");
            if (!empty($filterData->customer)) {
                $count = 0;
                foreach ($filterData->customer as $cust) {
                    $objectArray[$count] = new ObjectId($cust);
                    $count++;
                }
                $pipeData = $pipeData->whereIn('customer.id', $objectArray);
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

            if (!empty($filterData->current_status)) {
                $count = 0;
                foreach ($filterData->current_status as $cust) {
                    $objectArray[$count] = new ObjectId($cust);
                    $count++;
                }
                $pipeData = $pipeData->whereIn('status.id', $objectArray);
            }
        } else {
            $pipeData = WorkTypeData::where('pipelineStatus', "issuance");
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
        } elseif ($sort == "Worktype") {
            $items1 = $pipeData->orderBy('workTypeId.name');
        } elseif ($sort == "Status") {
            $items1 = $pipeData->orderBy('status.status');
        } elseif ($sort == "Last Updated At") {
            $items1 = $pipeData->orderBy('updated_at', 'desc');
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
                        ->orwhere('customer.customerCode', 'like', '%' . $search . '%')
                        ->orWhere('workTypeId.name', 'like', '%' . $search . '%')
                        ->orWhere('workTypeId.department', 'like', '%' . $search . '%')
                        ->orWhere('customer.maingroupName', 'like', '%' . $search . '%')
                        ->orWhere('customer.maingroupCode', 'like', '%' . $search . '%')
                        ->orWhere('caseManager.name', 'like', '%' . $search . '%')
                        ->orwhere('updated_at', 'like', '%' . $search . '%')
                        ->orWhere('status.status', 'like', '%' . $search . '%')
                        ->orWhere('agent.name', 'like', '%' . $search . '%')
                    //                ->orWhere('status.date','like','%'.$search.'%')
                    //                ->orWhere('status.UpdatedByName','like','%'.$search.'%')
                    //                ->orWhere('status.date','like','%'.$search.'%')
                        ->orwhere('createdBy.name', 'like', '%' . $search . '%')
                        ->orwhere('documentNo', 'like', '%' . $search . '%')
                        ->orWhere('refereneceNumber', 'like', '%' . $search . '%');
                }
            );
            session()->put('search', $search);
        } else {
            $item1 = $items1;
            session()->put('search', "");
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
            if ($item->workTypeId) {
                $referanceNumber = '<a href="' . URL::to('issuance/' . $item->_id) . '" class="table_link">' . $item->refereneceNumber . '</a>';
            }
            else {
                $referanceNumber = '<a  class="table_link">' . $item->refereneceNumber . '</button>';
            }

            $id = @$item->getCustomer->customerCode;
            $seen = $item->commentSeen;
            if (in_array(new ObjectID(Auth::id()), $item->commentPermission)) {
                if ($seen) {
                    if (!in_array(Auth::id(), $seen)) {
                        $comments = $item->comments;
                        if ($comments) {
                            $newComment = end($comments);
                            $commentDisplay = $newComment['commentBy'] . ' (' . $newComment['userType'] . ') : ' . $newComment['comment'];
                            $category = '<div class="name_sec"><span>' . $item->workTypeId['name'] . '</span><i data-toggle="tooltip" data-placement="right" data-container="body" data-original-title="' . $commentDisplay . '" class="fa fa-comments"></i></div>';
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
            $created = $item->created_at;
            $created_at = Carbon::parse($created)->format('d-m-Y');
            $created_by = $item->createdBy['name'];
            $name = $item->customer['name'];
            if (isset($item->customer['maingroupCode'])) {
                $maingroup_code = $item->customer['maingroupCode'];
            } else {
                $maingroup_code = '--';
            }
            $maingroup = $item->customer['maingroupName'];
            if (isset($item->workTypeId['department'])) {
                $department = $item->workTypeId['department'];
            } else {
                $department = '--';
            }
            $underwriter = $item->caseManager['name'];
            $case_manager = $item->caseManager['name'];
            $update = $item->updatedBy;
            $lastUpdate = end($update);
            $old = str_replace("/", "-", $lastUpdate['date']);
            $today = date('d-m-Y');
            $date1 = date_create($today);
            $date2 = date_create($old);
            $diff = date_diff($date1, $date2);
            $diff = $diff->format("%a days");
            $updated_by = $lastUpdate['name'];
            $updated_at = $item->updated_at;
            $date = Carbon::parse($updated_at)->format('d-m-Y');
            ////        $referanceNumber = $item->refereneceNumber;
            $status = $item->status['status'];
            $agent = $item->agent['name'];
            if (isset($item->status['UpdatedByName'])) {
                $current_update = $item->status['UpdatedByName'];
            } else {
                $current_update = '--';
            }
            if (isset($item->status['date'])) {
                $status_date = $item->status['date'];
            } else {
                $status_date = '--';
            }
            if (isset($item['documentNo'])) {
                $amendments = $item['documentNo'];
            } else {
                $amendments = '--';
            }
            $temp = new \stdClass();
            $temp->category = $category;
            $temp->referenceNumber = $referanceNumber;
            $temp->created_at = $created_at;
            $temp->created_by = $created_by;
            $temp->customerId = $id;
            $temp->customerName = $name;
            $temp->maingroup_id = $maingroup_code;
            $temp->mainGroup = $maingroup;
            $temp->department = $department;
            $temp->agent = $agent;
            $temp->underwriter = $underwriter;
            $temp->status = $status;
            $temp->current_update = $updated_by;
            $temp->status_date = $date;
            $temp->caseManager = $case_manager;
            $temp->diff = $diff;
            $temp->amendments = $amendments;
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
     * issuance export
     */
    public function issuanceExport(Request $request)
    {
        $filterData = json_decode(session('filter'));
        $sort = session('sort');
        $search = session('search');
        if ($filterData) {
            $pipeData = WorkTypeData::where('pipelineStatus', "issuance");
            if (!empty($filterData->customer)) {
                $count = 0;
                foreach ($filterData->customer as $cust) {
                    $objectArray[$count] = new ObjectId($cust);
                    $count++;
                }
                $pipeData = $pipeData->whereIn('customer.id', $objectArray);
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

            if (!empty($filterData->current_status)) {
                $count = 0;
                foreach ($filterData->current_status as $cust) {
                    $objectArray[$count] = new ObjectId($cust);
                    $count++;
                }
                $pipeData = $pipeData->whereIn('status.id', $objectArray);
            }
        } else {
            $pipeData = WorkTypeData::where('pipelineStatus', "issuance");
        }

        if ($sort == "Customer Name") {
            $items1 = $pipeData->orderBy('customer.name');
        } elseif ($sort == "Agent Name") {
            $items1 = $pipeData->orderBy('agent.name');
        } elseif ($sort == "Category") {
            $items1 = $pipeData->orderBy('workTypeId.name');
        } elseif ($sort == "Status") {
            $items1 = $pipeData->orderBy('status.status');
        } elseif ($sort == "Last Updated At") {
            $items1 = $pipeData->orderBy('updated_at', 'desc');
        } else {
            $items1 = $pipeData->orderBy('updated_at', 'desc');
        }
        if ($search) {
            $item1 = $items1->where(
                function ($query) use ($search) {
                    $query->where('customer.name', 'like', '%' . $search . '%')
                        ->orwhere('customer.customerCode', 'like', '%' . $search . '%')
                        ->orWhere('workTypeId.name', 'like', '%' . $search . '%')
                        ->orWhere('workTypeId.department', 'like', '%' . $search . '%')
                        ->orWhere('customer.maingroupName', 'like', '%' . $search . '%')
                        ->orWhere('customer.maingroupCode', 'like', '%' . $search . '%')
                        ->orWhere('caseManager.name', 'like', '%' . $search . '%')
                        ->orwhere('updated_at', 'like', '%' . $search . '%')
                        ->orWhere('status.status', 'like', '%' . $search . '%')
                        ->orWhere('agent.name', 'like', '%' . $search . '%')
                    //                    ->orWhere('status.date','like','%'.$search.'%')
                    //                    ->orWhere('status.UpdatedByName','like','%'.$search.'%')
                    //                    ->orWhere('status.date','like','%'.$search.'%')
                        ->orwhere('createdBy.name', 'like', '%' . $search . '%')
                        ->orWhere('refereneceNumber', 'like', '%' . $search . '%');
                }
            );
            session()->put('search', $search);
        } else {
            $item1 = $items1;
        }

        $pipeItem = $item1->get();

        $data[] = array('Pending Issuance List');
        $data[] = ['REFERENCE NUMBER', 'DATE CREATED', 'CREATED BY', 'CUSTOMER ID', 'CUSTOMER NAME', 'MAIN GROUP ID', 'MAIN GROUP NAME', 'DEPARTMENT', 'WORK TYPE', 'AGENT NAME',
            'UNDERWRITER', 'CURRENT STATUS', 'CURRENT STATUS UPDATED BY', 'LAST STATUS CHANGE DATE', 'CURRENT OWNER', 'NUMBER OF DAYS SINCE LAST TOUCHED', 'NUMBER OF AMENDMENTS'];

        foreach ($pipeItem as $pipeline) {
            if ($pipeline->status['status'] == "") {
                $status = "--";
            } else {
                $status = $pipeline->status['status'];
            }
            if (isset($pipeline->customer['customerCode'])) {
                $code = $pipeline->customer['customerCode'];
            } else {
                $code = '--';
            }
            $update = $pipeline->updatedBy;
            $lastUpdate = end($update);
            $updated_by = $lastUpdate['name'];
            $updated_at = $lastUpdate['date'];
            if (isset($pipeline->customer['maingroupCode'])) {
                $maingroupId = $pipeline->customer['maingroupCode'];
            } else {
                $maingroupId = '--';
            }
            if (isset($pipeline->workTypeId['department'])) {
                $department = $pipeline->workTypeId['department'];
            } else {
                $department = '--';
            }
            if (isset($pipeline->status['UpdatedByName'])) {
                $current_update = $pipeline->status['UpdatedByName'];
            } else {
                $current_update = '--';
            }
            if (isset($pipeline->status['date'])) {
                $status_date = $pipeline->status['date'];
            } else {
                $status_date = '--';
            }
            $update = $pipeline->updatedBy;
            $lastUpdate = end($update);
            $old = str_replace("/", "-", $lastUpdate['date']);
            $today = date('d-m-Y');
            $date1 = date_create($today);
            $date2 = date_create($old);
            $diff = date_diff($date1, $date2);
            $diff = $diff->format("%a days");
            if (isset($pipeline['documentNo'])) {
                $amendments = $pipeline['documentNo'];
            } else {
                $amendments = '--';
            }
            $data[] = array(

                $pipeline->refereneceNumber,
                Carbon::parse($pipeline->created_at)->format('d-m-Y'),
                $pipeline->createdBy['name'],
                $pipeline->customer['customerCode'],
                $pipeline->customer['name'],
                $maingroupId,
                $pipeline->customer['maingroupName'],
                $department,
                $pipeline->workTypeId['name'],
                $pipeline->agent['name'],
                $pipeline->caseManager['name'],
                $status,
                $updated_by,
                Carbon::parse($pipeline->updated_at)->format('d-m-Y'),
                $pipeline->caseManager['name'],
                $diff,
                $amendments,
            );
        }
        Excel::create(
            'Pending_Issuance_List', function ($excel) use ($data) {
                $excel->sheet(
                    'Pending Issuance', function ($sheet) use ($data) {
                        $sheet->mergeCells('A1:Q1');
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
