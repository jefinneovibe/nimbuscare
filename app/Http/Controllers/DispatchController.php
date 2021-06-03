<?php

namespace App\Http\Controllers;

use App\CountryListModel;
use App\Customer;
use App\CustomerLevel;
use App\CustomerType;
use App\DeliveryMode;
use App\Departments;
use App\DispatchStatus;
use App\DispatchTypes;
use App\DocumentType;
use App\EmployeeDetails;
use App\Jobs\SendcasemanagerADleads;
use App\Jobs\SendCaseManagerDelivery;
use App\Jobs\Sendcasemangerleads;
use App\Jobs\sendExcel;
use App\Jobs\SendReceptionADleads;
use App\Jobs\SendReceptionDelivery;
use App\Jobs\SendTransferleads;
use App\LeadDetails;
use App\Mail\sendMailToAgent;
use App\Mail\sendTransferRejectedMail;
use App\PipelineItems;
use App\RecipientDetails;
use App\Role;
use App\State;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use MongoDB\BSON\ObjectID;
use PDF;
use Illuminate\Support\Facades\DB;
use App\Exports\CompletedExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\WorkTypeData;
use Illuminate\Support\Collection;

//use Maatwebsite\Excel\Facades\Excel;


class DispatchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.dispatcher');
    }


    /**
     * view dispatch dashboard
     */
    public function dashboard(Request $request)
    {
        $request->session()->forget('dispatch');
        session(['dispatch' => 'Dispatcher']);
        return view('dispatch.dashboard');
    }

    /**
     * function for creating lead from dispatch module
     */
    public function createLead()
    {
        $delivery_mode = DeliveryMode::orderBy('deliveryMode')->get();
        if (
            session('role') == 'Insurer' || session('role') == 'Employee' || session('role') == 'Agent' ||
            session('role') == 'Coordinator' || session('role') == 'Courier' || session('role') == 'Messenger' ||
            session('role') == 'Accountant' || session('role') == 'Supervisor'
        ) {
            $dispatch_types = DispatchTypes::where('type', '!=', 'Direct Collections')->get();
        } else {
            $dispatch_types = DispatchTypes::all();
        }
        $id = 0; //lead create from dispatch login,id set 0
        $method = ''; //lead create from dispatch login,id set 0
        return view('dispatch.create_lead')
            ->with(compact(
                'customers',
                'delivery_mode',
                'dispatch_types',
                'id',
                'method'
            ));
    }

    private function passwordCorrect($suppliedPassword)
    {
        return Hash::check($suppliedPassword, Auth::user()->password, []);
    }

    /**
     * function for deleting user from dispatch module
     */
    public function deleteLead($leads_id)
    {
        $leadDetails = LeadDetails::find($leads_id);
        if ($leadDetails) {
            $leadDetails->active = 0;
            $leadDetails->save();
            Session::flash('status', 'Lead deleted successfully.');
            return "success";
        }
    }

    /**
     * function for update password of user from dispatch module
     */
    public function changePassword(Request $request)
    {
        $user_det = User::find(Auth::user()->_id);
        $check_password = $this->passwordCorrect($request->input('old_password'));
        if ($check_password) {
            $user_det->password = bcrypt($request->input('new_password1'));
            $user_det->save();
            return response()->json([
                'success' => true,
                'message' => 'Password updated successfully'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Incorrect old password'
            ]);
        }
    }

    /**
     * function for creating lead from other module like pipeline
     */
    public function createLeadOther(Request $request)
    {
        $role = Auth::user()->roleDetail('abbreviation');
        if ($role['abbreviation'] == 'EM' || $role['abbreviation'] == 'CO' || $role['abbreviation'] == 'AG' || $role['abbreviation'] == 'RP' || $role['abbreviation'] == 'SV') {
            $employee_id = new ObjectID(Auth::id());
            $LeadDetails = LeadDetails::where('active', 1)->where('employeeTabStatus', (int) 1)->whereNotNull('transferTo')->where(function ($q) use ($employee_id) {
                $q->where('transferTo', 'elemMatch', array('id' => $employee_id, 'status' => 'Transferred'))->orwhere('transferTo', 'elemMatch', array('id' => $employee_id, 'status' => 'Collected'));
            })->get();
            if (count($LeadDetails) >= 20) {
                return response()->json([
                    'success' => false,
                    'save_method' => '',
                    'next_location' => ''
                ]);
            }
        }
        $save_from = $request->input('save_from');
        $reference_number = $request->input('reference_number');
        $dispatch_type = $request->input('dispatch_type');

        $leadDetails = new LeadDetails();
        $pipelineItem = WorkTypeData::where('refereneceNumber', $reference_number)->first();
        $customer_name = $pipelineItem['customer']['name'];
        $customer_id = $pipelineItem['customer']['id'];
        $customerCode = $pipelineItem['customer']['customerCode'];

        $customer_object = new \stdClass();
        $customer_object->id = new ObjectID($customer_id);
        $customer_object->name = $customer_name;
        $customer_object->recipientName = $customer_name;
        $customer_object->customerCode = $customerCode;
        $leadDetails->customer = $customer_object;
        $leadDetails->saveType = 'customer';


        $agentId = $pipelineItem['agent']['id'];
        $agent = User::find($agentId);
        $agentObject = new \stdClass();
        $agentObject->id = new ObjectID($request->input('agent'));
        $agentObject->name = $agent->name;
        $leadDetails->agent = $agentObject;

        $casemanagerId = $pipelineItem['caseManager']['id'];
        $caseManager = User::find($casemanagerId);
        $caseManagerObject = new \stdClass();
        $caseManagerObject->id = new ObjectID($request->input('caseManager'));
        $caseManagerObject->name = $caseManager->name;
        $leadDetails->caseManager = $caseManagerObject;

        $dispatchType = DispatchTypes::where('type', $dispatch_type)->first();
        $dispatchTypeObject = new \stdClass();
        $dispatchTypeObject->id = new ObjectID($dispatchType->_id);
        $dispatchTypeObject->dispatchType = $dispatchType->type;
        $dispatchTypeObject->code = $dispatchType->code;
        $leadDetails->dispatchType = $dispatchTypeObject;
        $leadDetails->active = (int) 1;
        $customer = Customer::find($customer_id);
        $leadDetails->contactEmail = $customer->email[0];
        $leadDetails->contactNumber = $customer->contactNumber[0];


        $Date = date('d/m/y');
        $splted_date = explode('/', $Date);
        $currentdate = implode($splted_date);
        date_default_timezone_set('Asia/Dubai');
        $time = date('His');
        $count = LeadDetails::where('referenceNumber', 'like', '%' . $currentdate . '%')->count();
        $newCount = $count + 1;
        if ($newCount < 10) {
            $newCount = '0' . $newCount;
        }
        $refNumber = $dispatchTypeObject->code . "/" . $currentdate . "/" . $time . "/" . $newCount;
        $leadDetails->referenceNumber = (string) $refNumber;

        $createdBy_obj = new \stdClass();
        $createdBy_obj->id = new ObjectID(Auth::id());
        $createdBy_obj->name = Auth::user()->name;
        $createdBy_obj->date = date('d/m/Y');
        $createdBy_obj->action = "Lead Created";
        $createdBy[] = $createdBy_obj;
        $leadDetails->createdBy = $createdBy;

        $leadDetails->other_id = new ObjectID($pipelineItem->_id);
        $leadDetails->saveFrom = $save_from;
        if ($dispatchType->type == 'Direct Collections' || $dispatchType->type == 'Direct Delivery') {
            $leadDetails->dispatchStatus = 'Reception';
            $next_location = 'go_reception';
        } else {
            $leadDetails->dispatchStatus = 'Lead';
            $next_location = 'go_lead';
        }
        $leadDetails->save();
        if ($next_location == 'go_lead') {
            $this->saveTabStatus($leadDetails->_id);
        } else {
            if ($next_location == 'go_reception') {
                $this->saveDirectTabStatus($leadDetails->_id);
            }
        }
        Session::flash('status', 'Lead created successfully');

        return response()->json([
            'success' => true,
            'save_method' => $save_from,
            'next_location' => $next_location
        ]);
    }

    /**
     * get customer details
     */
    public function getCustomerDetails(Request $request)
    {
        if ($request->input('type') == 'customerCode') {
            $customercode = $request->input('customerCode');
            $customerDetails = Customer::find($customercode);
        } elseif ($request->input('type') == 'recName') {
            $recName = $request->input('rName');
            $customerDetails = RecipientDetails::find($recName);
        }

        if (isset($customerDetails->agent['id']) && !empty($customerDetails->agent['id']) && $request->input('type') == 'customerCode') {
            $agent = $customerDetails->agent['id'];
            $response[] = "<option value=''>Select Agent</option>";
            $allAgents = User::find($agent);
            if ($allAgents['_id'] == $agent) {
                if ($allAgents->empID != '') {
                    $id = ' (' . $allAgents->empID . ')';
                } else {
                    $id = '';
                }
                $response[] = "<option value='$allAgents->id' selected>$allAgents->name $id</option>";
            }
        } elseif ($request->input('type') == 'recName') {
            $agent = '';
            $response[] = "<option value=''>Select Agent</option>";
            $allAgents = User::where('isActive', 1)->where(function ($q) {
                $q->where('role', 'AG')->orWhere('role', 'EM');
            })->orderBy('name')->get();
            foreach ($allAgents as $single) {
                if ($single->empID != '') {
                    $id = ' (' . $single->empID . ')';
                } else {
                    $id = '';
                }
                $response[] = "<option value='$single->id'>$single->name $id</option>";
            }
        } else {
            $response[] = "<option value=''>Select Agent</option>";
            $allAgents = User::where('isActive', 1)->where(function ($q) {
                $q->where('role', 'AG')->orWhere('role', 'EM');
            })->orderBy('name')->get();
            $agent = '';
            foreach ($allAgents as $single) {
                if ($single->empID != '') {
                    $id = ' (' . $single->empID . ')';
                } else {
                    $id = '';
                }
                $response[] = "<option value='$single->id'>$single->name $id</option>";
            }
        }
        $string_version = implode(',', $response);

        return response()->json([
            'success' => true,
            'CustomerDetails' => $customerDetails,
            'agent' => $agent,
            'response' => $string_version
        ]);
    }

    /**
     * save lead details
     */
    public function saveLead(Request $request)
    {
        $role = Auth::user()->roleDetail('abbreviation');
        if ($role['abbreviation'] == 'EM' || $role['abbreviation'] == 'CO' || $role['abbreviation'] == 'AG' || $role['abbreviation'] == 'RP' 
        || $role['abbreviation'] == 'SV') {
            $employee_id = new ObjectID(Auth::id());
            $LeadDetails = LeadDetails::where('active', 1)->where('employeeTabStatus', (int) 1)->whereNotNull('transferTo')->where(function ($q) use ($employee_id) {
                $q->where('transferTo', 'elemMatch', array('id' => $employee_id, 'status' => 'Transferred'))
                ->orwhere('transferTo', 'elemMatch', array('id' => $employee_id, 'status' => 'Collected'));
            })->get();
            if (count($LeadDetails) >= 20) {
                return response()->json([
                    'success' => false,
                    'save_method' => '',
                    'next_location' => ''
                ]);
            }
        }
        $emp_id = new ObjectId($request->input('assign'));
        $other_id = $request->input('other_id');
        $type_select = $request->input('select_type');

        $leadDetails = new LeadDetails();
        if ($type_select == 'customer') {
            $customercode = $request->input('customerCode');
            $customer = Customer::find($customercode);
            $customer_object = new \stdClass();
            $customer_object->id = new ObjectID($customer->_id);
            $fullName = $customer->fullName;
            $customer_object->name = $fullName;
            $customer_object->recipientName = $request->input('recipientName');
            $customer_object->customerCode = $customer->customerCode;
            $leadDetails->customer = $customer_object;
        } elseif ($type_select == 'recipient') {
            $customercode = '';
            $RecName = RecipientDetails::find($request->input('RecName'));
            $customer_object = new \stdClass();
            $customer_object->id = new ObjectID($RecName->_id);
            $fullName = $RecName->fullName;
            $customer_object->name = $fullName;
            $customer_object->recipientName = $request->input('recipientName');
            $customer_object->customerCode = $customercode;
            $leadDetails->customer = $customer_object;
        }
        
        if($type_select != 'recipient'){
            $agent = User::where('_id', new ObjectID($request->input('agentVal')))->first();
            $agentObject = new \stdClass();
            $agentObject->id = new ObjectID($request->input('agent'));
            $agentObject->name = ucwords(strtolower($agent->name));
            if ($agent->empID) {
                $agentObject->empid = $agent->empID;
            } else {
                $agentObject->empid = "";
            }
            $leadDetails->agent = $agentObject;
        }
        $caseManager = User::find(Auth::id());
        $caseManagerObject = new \stdClass();
        $caseManagerObject->id = new ObjectID(Auth::id());
        $caseManagerObject->name = $caseManager->name;
        $leadDetails->caseManager = $caseManagerObject;
        $delivery = DeliveryMode::find($request->input('deliveryMode'));
        $deliveryObject = new \stdClass();
        $deliveryObject->id = new ObjectID($delivery->_id);
        $deliveryObject->deliveryMode = $delivery->deliveryMode;
        if ($request->input('way_bill') != '') {
            $deliveryObject->wayBill = $request->input('way_bill');
        }
        $leadDetails->deliveryMode = $deliveryObject;
        $leadDetails->saveType = $type_select;

        $dispatchType = DispatchTypes::find($request->input('dispatchType'));
        $dispatchTypeObject = new \stdClass();
        $dispatchTypeObject->id = new ObjectID($dispatchType->_id);
        $dispatchTypeObject->dispatchType = $dispatchType->type;
        $dispatchTypeObject->code = $dispatchType->code;
        $leadDetails->dispatchType = $dispatchTypeObject;
        $leadDetails->active = (int) 1;
        $leadDetails->contactNumber = $request->input('contactNumber');
        $leadDetails->contactEmail = $request->input('contactEmail');


        $emp_details = User::find($emp_id);
        $employee = new \stdClass();
        $employee->id = new ObjectId($emp_details->_id);
        $employee->name = $emp_details->name;
        $employee->empId = $emp_details->empID;
        $leadDetails->employee = $employee;

        $Date = date('d/m/y');
        $splted_date = explode('/', $Date);
        $currentdate = implode($splted_date);
        date_default_timezone_set('Asia/Dubai');
        $time = date('His');
        $count = LeadDetails::where('referenceNumber', 'like', '%' . $currentdate . '%')->count();
        $newCount = $count + 1;
        if ($newCount < 10) {
            $newCount = '0' . $newCount;
        }
        $refNumber = $dispatchTypeObject->code . "/" . $currentdate . "/" . $time . "/" . $newCount;
        $leadDetails->referenceNumber = (string) $refNumber;

        $createdBy_obj = new \stdClass();
        $createdBy_obj->id = new ObjectID(Auth::id());
        $createdBy_obj->name = Auth::user()->name;
        $createdBy_obj->date = date('d/m/Y');
        $createdBy_obj->action = "Lead Created";
        $createdBy[] = $createdBy_obj;
        $leadDetails->createdBy = $createdBy;
        if ($other_id != 0) {
            $leadDetails->other_id = new ObjectID($other_id);
            $saveFromMethod = $request->input('method');
            $leadDetails->saveFrom = $saveFromMethod;
        } else {
            $saveFromMethod = 'Dispatch';
        }
        if ($dispatchType->type == 'Direct Collections' || $dispatchType->type == 'Direct Delivery') {
            $leadDetails->dispatchStatus = 'Reception';
            $action = "Reception";
            $caselink = url('/dispatch/receptionist-list/');
            $next_location = 'go_reception';
        } else {
            $leadDetails->dispatchStatus = 'Lead';
            $action = "Lead";
            $caselink = url('/dispatch/dispatch-list/');
            $next_location = 'go_lead';
        }
        $leadDetails->save();
        if ($next_location == 'go_lead') {
            $this->saveTabStatus($leadDetails->_id);
        } elseif ($next_location == 'go_reception') {
            $this->saveDirectTabStatus($leadDetails->_id);
        }
        Session::flash('status', 'Lead created successfully');
        Session::put('leadId', $leadDetails->_id);

        return response()->json([
            'success' => true,
            'save_method' => $saveFromMethod,
            'next_location' => $next_location
        ]);
    }

    //set tab status of lead
    public static function saveDirectTabStatus($id)
    {
        $statusArray = [];
        $leadDetails = LeadDetails::find($id);

        $lead = $leadDetails['dispatchDetails']['documentDetails'];
        $leadStatus = (int) 0;
        $receptionStatus = (int) 0;
        $deliveryStatus = (int) 0;
        $employeeStatus = (int) 0;
        $scheduleStatus = (int) 0;
        $completedStatus = (int) 0;
        if ($lead) {
            foreach ($lead as $key => $value) {
                $statusArray[] = $value['DocumentCurrentStatus'];
            }
            if (count(array_unique($statusArray)) === 1 && end($statusArray) === '18' || in_array("18", $statusArray) || in_array("10", $statusArray)) {
                $receptionStatus = (int) 1;
            }
            $data = array(
                'leadTabStatus' => $leadStatus,
                'receptionTabStatus' => $receptionStatus,
                'scheduledTabStatus' => $scheduleStatus,
                'deliveryTabStatus' => $deliveryStatus,
                'employeeTabStatus' => $employeeStatus,
                'completedTabStatus' => $completedStatus
            );
            LeadDetails::where('_id', new ObjectID($id))->update($data, ['multiple' => true]);
        } else {
            $receptionStatus = (int) 1;
            $data = array(
                'leadTabStatus' => $leadStatus,
                'receptionTabStatus' => $receptionStatus,
                'scheduledTabStatus' => $scheduleStatus,
                'deliveryTabStatus' => $deliveryStatus,
                'employeeTabStatus' => $employeeStatus,
                'completedTabStatus' => $completedStatus
            );
            LeadDetails::where('_id', new ObjectID($id))->update($data, ['multiple' => true]);
        }
    }

    //set tab status of lead
    public static function saveTabStatus($id)
    {
        $statusArray = [];
        $leadDetails = LeadDetails::find($id);
        $lead = $leadDetails['dispatchDetails']['documentDetails'];
        $dispatchStatus = $leadDetails->dispatchStatus;
        $leadStatus = (int) 0;
        $receptionStatus = (int) 0;
        $deliveryStatus = (int) 0;
        $employeeStatus = (int) 0;
        $scheduleStatus = (int) 0;
        $completedStatus = (int) 0;
        if ($lead) {
            foreach ($lead as $key => $value) {
                $statusArray[] = $value['DocumentCurrentStatus'];
            }
            if (count(array_unique($statusArray)) === 1 && end($statusArray) === '1' || (in_array("1", $statusArray) && $dispatchStatus != 'Partial')) {
                $leadStatus = (int) 1;
            }
            if (count(array_unique($statusArray)) === 1 && end($statusArray) === '10' || in_array("10", $statusArray)) {
                $leadStatus = (int) 1;
            }

            if ((count(array_unique($statusArray)) === 1 && end($statusArray) === '6' ||
                count(array_unique($statusArray)) === 1 && end($statusArray) === '15' || in_array(
                    "6",
                    $statusArray
                ) || in_array("15", $statusArray)) && ($leadDetails->dispatchType['dispatchType'] == 'Delivery')) {
                $leadStatus = (int) 1;
            }

            if (
                count(array_unique($statusArray)) === 1 && end($statusArray) === '2' ||
                count(array_unique($statusArray)) === 1 && end($statusArray) === '18' || in_array(
                    "2",
                    $statusArray
                ) || in_array("18", $statusArray)
            ) {
                $receptionStatus = (int) 1;
            }
            if ((count(array_unique($statusArray)) === 1 && end($statusArray) === '3' ||
                count(array_unique($statusArray)) === 1 && end($statusArray) === '11') || in_array(
                "3",
                $statusArray
            ) || in_array("11", $statusArray)) {
                $deliveryStatus = (int) 1;
            }
            if ((count(array_unique($statusArray)) === 1 && end($statusArray) === '4') || (count(array_unique($statusArray)) === 1 && end($statusArray) === '5') || (count(array_unique($statusArray)) === 1 && end($statusArray) === '6') || (count(array_unique($statusArray)) === 1 && end($statusArray) === '15') || (count(array_unique($statusArray)) === 1 && end($statusArray) === '8') || (count(array_unique($statusArray)) === 1 && end($statusArray) === '12')
            ) {
                $receptionStatus = (int) 1;
            }
            if ((count(array_unique($statusArray)) === 1 && end($statusArray) === '9') || (in_array(
                "9",
                $statusArray
            )) || (in_array("14", $statusArray))) {
                $employeeStatus = (int) 1;
                //$receptionStatus = (int)1;
            }
            if ((count(array_unique($statusArray)) === 1 && end($statusArray) === '13') || (in_array(
                "13",
                $statusArray
            ))) {
                $scheduleStatus = (int) 1;
            }
            if ((count(array_unique($statusArray)) === 1 && end($statusArray) === '7') || (in_array("7", $statusArray)) || (in_array("16", $statusArray))) {
                $completedStatus = (int) 1;
            }

            if (
                in_array("12", $statusArray)
                || (in_array("8", $statusArray)) || (in_array("6", $statusArray)) || (in_array("15", $statusArray))
                || (in_array("5", $statusArray)) || (in_array("4", $statusArray)) || (in_array("17", $statusArray))
            ) {
                $receptionStatus = (int) 1;
            }
        } else {
            $leadStatus = (int) 1;
        }
        $data = array(
            'leadTabStatus' => $leadStatus,
            'receptionTabStatus' => $receptionStatus,
            'scheduledTabStatus' => $scheduleStatus,
            'deliveryTabStatus' => $deliveryStatus,
            'employeeTabStatus' => $employeeStatus,
            'completedTabStatus' => $completedStatus
        );
        LeadDetails::where('_id', new ObjectID($id))->update($data, ['multiple' => true]);
    }

    /**
     * dispatch listing page
     */
    public function dispatchList(Request $request)
    {
        $leadId = session()->get('leadId');
        if (!empty($request->input('agent'))) {
            $count = 0;
            foreach ($request->input('agent') as $cust) {
                $objectArray[$count] = new ObjectId($cust);
                $count++;
            }
            $agents = User::where('isActive', 1)->where(function ($q) {
                $q->where('role', 'EM')->orWhere('role', 'AG');
            })->whereIn('_id', $objectArray)->get();
        } else {
            $agents = '';
        }

        if (!empty($request->input('assigned'))) {
            $count = 0;
            foreach ($request->input('assigned') as $cust) {
                $objectArray[$count] = new ObjectId($cust);
                $count++;
            }
            $assigned_to = User::where('isActive', 1)->where(function ($q) {
                $q->where('role', 'EM')->orWhere('role', 'AG')->orWhere('role', 'CR')->orWhere('role', 'AD')->orWhere('role', 'MS')->orWhere('role', 'CO')->orWhere('role', 'SV');
            })->whereIn('_id', $objectArray)->get();
        } else {
            $assigned_to = '';
        }

        if (!empty($request->input('customer'))) {
            $count = 0;
            foreach ($request->input('customer') as $cust) {
                $objectArray[$count] = new ObjectId($cust);
                $count++;
            }
            $customers = Customer::whereIn('_id', $objectArray)->get();
            $recepients = RecipientDetails::whereIn('_id', $objectArray)->get();
            $customers = $customers->merge($recepients);
        } else {
            $customers = '';
        }
        
        $recipientsDetails = RecipientDetails::where('status', 0)->get();
        if (!empty($request->input('case_manager'))) {
            $count = 0;
            foreach ($request->input('case_manager') as $cust) {
                $objectArray[$count] = new ObjectId($cust);
                $count++;
            }
            $case_managers = User::where('isActive', 1)->where(function ($q) {
                $q->where('role', 'EM')->orWhere('role', 'AD')->orWhere('role', 'RP')->orWhere('role', 'AG')->orWhere('role', 'CO')->orWhere('role', 'SV');
            })->whereIn('_id', $objectArray)->get();
        } else {
            $case_managers = '';
        }
        if (!empty($request->input('status'))) {
            $count = 0;
            foreach ($request->input('status') as $cust) {
                $objectArray[$count] = $cust;
                $count++;
            }
            $Allstatus = DispatchStatus::whereIn('status', $objectArray)->groupBy('status')->get();
        } else {
            $Allstatus = '';
        }

        if (!empty($request->input('dispatch'))) {
            $count = 0;
            foreach ($request->input('dispatch') as $cust) {
                $objectArray[$count] = new ObjectId($cust);
                $count++;
            }
            if (
                session('role') == 'Insurer' || session('role') == 'Employee' || session('role') == 'Agent' || session('role') == 'Coordinator' ||
                session('role') == 'Courier' || session('role') == 'Messenger' || session('role') == 'Accountant' || session('role') == 'Supervisor'
            ) {
                $dispatch_type_check = DispatchTypes::where('type', '!=', 'Direct Collections')->whereIn('_id', $objectArray)->get();
            } else {
                $dispatch_type_check = DispatchTypes::whereIn('_id', $objectArray)->get();
            }
        } else {
            $dispatch_type_check = '';
        }
        if (!empty($request->input('delivery'))) {
            $count = 0;
            foreach ($request->input('delivery') as $cust) {
                $objectArray[$count] = new ObjectId($cust);
                $count++;
            }
            $delivery_mode_check = DeliveryMode::whereIn('_id', $objectArray)->get();
        } else {
            $delivery_mode_check = '';
        }

        $delivery_mode = DeliveryMode::all();
        if (
            session('role') == 'Insurer' || session('role') == 'Employee' || session('role') == 'Agent' || session('role') == 'Coordinator' ||
            session('role') == 'Courier' || session('role') == 'Messenger' || session('role') == 'Accountant' || session('role') == 'Supervisor'
        ) {
            $dispatch_types = DispatchTypes::where('type', '!=', 'Direct Collections')->get();
        } else {
            $dispatch_types = DispatchTypes::all();
        }
        $document_types = DocumentType::all();
        $filter_data = $request->input();
        $current_path = $request->path();

        if (session()->has('leadId')) {
            return view('dispatch.newlead')
                ->with(compact(
                    'customers',
                    'agents',
                    'case_managers',
                    'current_path',
                    'delivery_mode',
                    'dispatch_types',
                    'dispatch_type_check',
                    'delivery_mode_check',
                    'filter_data',
                    'document_types',
                    'recipientsDetails',
                    'leadId',
                    'Allstatus'
                ));
        } else {
            return view('dispatch.lead_list')
                ->with(compact(
                    'customers',
                    'agents',
                    'case_managers',
                    'current_path',
                    'delivery_mode',
                    'dispatch_types',
                    'dispatch_type_check',
                    'delivery_mode_check',
                    'filter_data',
                    'document_types',
                    'recipientsDetails',
                    'leadId',
                    'assigned_to',
                    'Allstatus'
                ));
        }
    }

    /**
     * datatable for leads
     */
    public function dataTable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $filter = $request->input('search');
        $filter_data_en = $request->get('filterData');
        $filter_data = json_decode($filter_data_en);
        $sort = $request->get('field');
        $search = (isset($filter['value'])) ? $filter['value'] : false;
        session()->put('filter', $filter_data_en);
        session()->put('sort', $sort);
        $LeadDetails = LeadDetails::where('active', 1)->where('leadTabStatus', (int) 1);
        if (session('role') == 'Employee') {
            $LeadDetails = $LeadDetails->where(function ($q) {
                $q->where('caseManager.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('agent.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('employee.id', new ObjectID(Auth::user()->_id));
            });
        } elseif (session('role') == 'Agent') {
            $LeadDetails = $LeadDetails->where(function ($q) {
                $q->where('agent.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('caseManager.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('employee.id', new ObjectID(Auth::user()->_id));
            });
        } elseif (session('role') == 'Coordinator') {
            $LeadDetails = $LeadDetails->where(function ($q) {
                $q->where('agent.id', session('assigned_agent'))
                    ->orwhere('agent.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('employee.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('employee.id', session('assigned_agent'));
            });
        } elseif (session('role') == 'Supervisor') {
            $LeadDetails = $LeadDetails->where(function ($q) {
                $q->where('agent.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('caseManager.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('employee.id', new ObjectID(Auth::user()->_id))
                    ->orwhereIn('employee.id', session('employees'));
            });
        } elseif (session('role') != 'Admin' && session('role') != 'Receptionist') {
            $LeadDetails = $LeadDetails->where('employee.id', new ObjectID(Auth::user()->_id));
        }

        if (!empty($filter_data)) {
            if (!empty($filter_data->agent)) {
                $count = 0;
                foreach ($filter_data->agent as $agent) {
                    $objectArray[$count] = new ObjectId($agent);
                    $count++;
                }
                $LeadDetails = $LeadDetails->whereIn('agent.id', $objectArray);
            }
            if (!empty($filter_data->case_manager)) {
                $count = 0;
                foreach ($filter_data->case_manager as $manager) {
                    $objectArray[$count] = new ObjectId($manager);
                    $count++;
                }
                $LeadDetails = $LeadDetails->whereIn('caseManager.id', $objectArray);
            }
            if (!empty($filter_data->customer)) {
                $count = 0;
                foreach ($filter_data->customer as $cust) {
                    $objectArray[$count] = new ObjectId($cust);
                    $count++;
                }
                $LeadDetails = $LeadDetails->whereIn('customer.id', $objectArray);
            }
            if (!empty($filter_data->delivery)) {
                $count = 0;
                foreach ($filter_data->delivery as $mode) {
                    $objectArray[$count] = new ObjectId($mode);
                    $count++;
                }
                $LeadDetails = $LeadDetails->whereIn('deliveryMode.id', $objectArray);
            }
            if (!empty($filter_data->dispatch)) {
                $count = 0;
                foreach ($filter_data->dispatch as $type) {
                    $objectArray[$count] = new ObjectId($type);
                    $count++;
                }
                $LeadDetails = $LeadDetails->whereIn('dispatchType.id', $objectArray);
            }
            if (!empty($filter_data->assigned)) {
                $count = 0;
                foreach ($filter_data->assigned as $type) {
                    $objectArray[$count] = new ObjectId($type);
                    $count++;
                }
                $LeadDetails = $LeadDetails->whereIn('employee.id', $objectArray);
            }
            if (!empty($filter_data->status)) {
                $count = 0;
                foreach ($filter_data->status as $stat) {
                    $objectArray[$count] = $stat;
                    $count++;
                }
                $LeadDetails = $LeadDetails->whereIn('dispatchStatus', $objectArray);
            }
        }

        if (!empty($sort)) {
            if ($sort == "Customer Name") {
                $LeadDetails = $LeadDetails->orderBy(trim('customer.name'));
            } elseif ($sort == "Agent") {
                $LeadDetails = $LeadDetails->orderBy('agent.name');
            } elseif ($sort == "Case Manager") {
                $LeadDetails = $LeadDetails->orderBy('caseManager.name');
            } elseif ($sort == "Dispatch Type") {
                $LeadDetails = $LeadDetails->orderBy('dispatchType.dispatchType');
            } elseif ($sort == "Delivery Mode") {
                $LeadDetails = $LeadDetails->orderBy('deliveryMode.deliveryMode');
            }
        } elseif (empty($sort)) {
            $LeadDetails = $LeadDetails->orderBy(
                'created_at',
                'DESC'
            );
        }
        if ($search) {
            $LeadDetails = $LeadDetails->where(function ($query) use ($search) {
                $query->Where('referenceNumber', 'like', '%' . $search . '%')
                    ->orWhere('customer.name', 'like', '%' . $search . '%')
                    ->orWhere('customer.recipientName', 'like', '%' . $search . '%')
                    ->orWhere('customer.customerCode', 'like', '%' . $search . '%')
                    ->orWhere('agent.name', 'like', '%' . $search . '%')
                    ->orWhere('caseManager.name', 'like', '%' . $search . '%')
                    ->orWhere('contactNumber', 'like', '%' . $search . '%')
                    ->orWhere('deliveryMode.deliveryMode', 'like', '%' . $search . '%')
                    ->orWhere('dispatchStatus', 'like', '%' . $search . '%')
                    ->orWhere('dispatchType.dispatchType', 'like', '%' . $search . '%');
            });


            session()->put('search', $search);
        }
        if ($search == "") {
            $LeadDetails = $LeadDetails;
            session()->put('search', "");
        }

        $searchField = $request->get('searchField');
        if ($searchField != "") {
            $LeadDetails = $LeadDetails->where(function ($query) use ($searchField) {
                $query->Where('referenceNumber', 'like', '%' . $searchField . '%')
                    ->orWhere('customer.name', 'like', '%' . $searchField . '%')
                    ->orWhere('customer.recipientName', 'like', '%' . $searchField . '%')
                    ->orWhere('customer.customerCode', 'like', '%' . $searchField . '%')
                    ->orWhere('agent.name', 'like', '%' . $searchField . '%')
                    ->orWhere('caseManager.name', 'like', '%' . $searchField . '%')
                    ->orWhere('contactNumber', 'like', '%' . $searchField . '%')
                    ->orWhere('dispatchStatus', 'like', '%' . $searchField . '%')
                    ->orWhere('deliveryMode.deliveryMode', 'like', '%' . $searchField . '%')
                    ->orWhere('dispatchType.dispatchType', 'like', '%' . $searchField . '%');
            });
        }
        $total_leads = $LeadDetails->count(); // get your total no of data;
        $members_query = $LeadDetails;
        $search_count = $members_query->count();
        $LeadDetails->skip((int) $start)->take((int) $length);
        $final_leads = $LeadDetails->get();


        foreach ($final_leads as $leads) {
            if ($leads['dispatchDetails'] != "") {
                $check = '<div class="custom_checkbox">' .
                    '<input type="checkbox" name="marked_list[]" class="inp-cbx check" id="' . $leads->_id . '" style="display: none"  onchange="markedCheck(this.id)">' .
                    '<label for="' . $leads->_id . '" class="cbx">' .
                    '<span>' .
                    '    <svg width="10px" height="8px" viewBox="0 0 12 10">' .
                    '      <polyline points="1.5 6 4.5 9 10.5 1"></polyline>' .
                    '    </svg>' .
                    '</span>' .
                    '    <span></span>' .
                    '</label>' .
                    '</div>';
                $count = sizeof($leads['dispatchDetails']['documentDetails']);
                $check = '<div class="custom_checkbox">' .
                    '<input type="checkbox" name="marked_list[]" class="inp-cbx check" id="' . $leads->_id . '" style="display: none"  onchange="markedCheck(this.id)">' .
                    '<label for="' . $leads->_id . '" class="cbx">' .
                    '<span>' .
                    '    <svg width="10px" height="8px" viewBox="0 0 12 10">' .
                    '      <polyline points="1.5 6 4.5 9 10.5 1"></polyline>' .
                    '    </svg>' .
                    '</span>' .
                    '    <span></span>' .
                    '</label>' .
                    '</div>';
                for ($i = 0; $i < $count; $i++) {
                    if (
                        $leads['dispatchDetails']['land_mark'] && $leads['dispatchDetails']['documentDetails'] && $leads['dispatchDetails']['documentDetails'][$i]['documentName'] && $leads['dispatchDetails']['documentDetails'][$i]['documentName'] &&
                        isset($leads['dispatchDetails']['documentDetails'][$i]['amount']) && $leads['dispatchDetails']['documentDetails'][$i]['documentDescription'] &&
                        $leads['dispatchDetails']['documentDetails'][$i]['documentType'] && $leads['dispatchDetails']['address'] && isset($leads['dispatchDetails']['employee'])
                    ) {
                        if ($leads['dispatchDetails']['documentDetails'][$i]['amount'] == "NA") {
                            $check = '<div class="custom_checkbox">' .
                                '<input   type="checkbox" name="marked_list[]" disabled class="inp-cbx check" id="' . $leads->_id . '" style="display: none"  onchange="markedCheck(this.id)">' .
                                '<label for="' . $leads->_id . '" class="cbx" style="cursor: auto;">' .
                                '<span>' .
                                '    <svg width="10px" height="8px" viewBox="0 0 12 10">' .
                                '      <polyline points="1.5 6 4.5 9 10.5 1"></polyline>' .
                                '    </svg>' .
                                '</span>' .
                                '    <span><i style="color: #f96617;font-size: 12px;" class="fa fa-exclamation-triangle" data-toggle="tooltip" title="Lead Not Completed" aria-hidden="true"></i></span>' .
                                '</label>' .
                                '</div>';
                            $disable = true;
                            break;
                        } else {
                            $disable = false;
                        }
                        if ($leads['dispatchDetails']['deliveryMode']['deliveryMode'] == "Courier") {
                            $bill = $leads['dispatchDetails']['deliveryMode']['wayBill'];
                            if ($bill == "--") {
                                $check = '<div class="custom_checkbox">' .
                                    '<input   type="checkbox" name="marked_list[]" disabled class="inp-cbx check" id="' . $leads->_id . '" style="display: none"  onchange="markedCheck(this.id)">' .
                                    '<label for="' . $leads->_id . '" class="cbx" style="cursor: auto;">' .
                                    '<span>' .
                                    '    <svg width="10px" height="8px" viewBox="0 0 12 10">' .
                                    '      <polyline points="1.5 6 4.5 9 10.5 1"></polyline>' .
                                    '    </svg>' .
                                    '</span>' .
                                    '    <span><i style="color: #f96617;font-size: 12px;" class="fa fa-exclamation-triangle" data-toggle="tooltip" title="Lead Not Completed" aria-hidden="true"></i></span>' .
                                    '</label>' .
                                    '</div>';
                                $disable = true;
                                break;
                            } else {
                                $disable = false;
                            }
                        } else {
                            $disable = false;
                        }
                        if (Auth::user()->_id != @$leads->caseManager['id']) {
                            $check = '<div class="custom_checkbox">' .
                                '<input  type="checkbox" name="marked_list[]" disabled class="inp-cbx check" id="' . $leads->_id . '" style="display: none"  onchange="markedCheck(this.id)">' .
                                '<label for="' . $leads->_id . '" class="cbx" style="cursor: auto;">' .
                                '<span>' .
                                '    <svg width="10px" height="8px" viewBox="0 0 12 10">' .
                                '      <polyline points="1.5 6 4.5 9 10.5 1"></polyline>' .
                                '    </svg>' .
                                '</span>' .
                                '    <span></span>' .
                                '</label>' .
                                '</div>';
                            $disable = true;
                            break;
                        }
                    } else {
                        $check = '<div class="custom_checkbox">' .
                            '<input  type="checkbox" name="marked_list[]" disabled class="inp-cbx check" id="' . $leads->_id . '" style="display: none"  onchange="markedCheck(this.id)">' .
                            '<label for="' . $leads->_id . '" class="cbx" style="cursor: auto;">' .
                            '<span>' .
                            '    <svg width="10px" height="8px" viewBox="0 0 12 10">' .
                            '      <polyline points="1.5 6 4.5 9 10.5 1"></polyline>' .
                            '    </svg>' .
                            '</span>' .
                            '    <span><i style="color: #f96617;font-size: 12px;" class="fa fa-exclamation-triangle" data-toggle="tooltip" title="Lead Not Completed" aria-hidden="true"></i></span>' .
                            '</label>' .
                            '</div>';
                        $disable = true;
                        break;
                    }
                }
            } else {
                $check = '<div class="custom_checkbox">' .
                    '<input type="checkbox" name="marked_list[]" disabled class="inp-cbx check" id="' . $leads->_id . '" style="display: none"  onchange="markedCheck(this.id)">' .
                    '<label for="' . $leads->_id . '" class="cbx" style="cursor: auto;">' .
                    '<span>' .
                    '    <svg width="10px" height="8px" viewBox="0 0 12 10">' .
                    '      <polyline points="1.5 6 4.5 9 10.5 1"></polyline>' .
                    '    </svg>' .
                    '</span>' .
                    '    <span><i style="color: #f96617;font-size: 12px;" class="fa fa-exclamation-triangle" data-toggle="tooltip" title="Lead Not Completed" aria-hidden="true"></i></span>' .
                    '</label>' .
                    '</div>';
                $disable = true;
            }

            if ($leads['referenceNumber'] == '') {
                $referenceNumber = '--';
            } else {
                $referenceNumber = '<a href="#" class="auto_modal table_link" dir="' . $leads->_id . '" onclick="view_lead_popup(\'' . $leads->_id . '\');">

<span data-toggle="tooltip" data-placement="bottom" title="View Dispatch Slip" data-container="body"  data-modal="view_lead_popup"> ' . $leads['referenceNumber'] . ' </span>  ';
            }

            if (isset($leads->rejectstatus)) {
                $referenceNumber = $referenceNumber . '<i style="color: #f00; font-size: 14px;" class="fas fa-ban"  data-toggle="tooltip" title="' . $leads->rejectstatus . '"  aria-hidden="true"></i> </a>';
            }
            if (isset($leads->agent['name'])) {
                $agentname = ucwords(strtolower($leads->agent['name']));
                if (isset($leads->agent['empid'])) {
                    if ($leads->agent['empid'] != "") {
                        $agentid = $leads->agent['empid'];
                        $agentvalue = $agentname . ' (' . $agentid . ')';
                    } else {
                        $agentvalue = $agentname;
                    }
                } else {
                    $agentvalue = $agentname;
                }
            } else {
                $agentvalue = 'NA';
            }

            $agent = $agentvalue;
            $caseManager = ucwords(strtolower($leads['caseManager.name']));
            $email = $leads->contactEmail;
            $contact = $leads->contactNumber;
            $recipientName = ucwords(strtolower($leads['customer.recipientName']));
            $dispatchType = $leads['dispatchType.dispatchType'];
            $deliveryMode = $leads['deliveryMode.deliveryMode'];
            $code = $leads['customer.customerCode'] ?: '--';
            $customerName = ucwords(strtolower($leads['customer.name']));
            $created_at = $leads['created_at'];
            if (isset($leads->employee['name'])) {
                $assignname = ucwords(strtolower($leads->employee['name']));
                if (isset($leads->employee['empId'])) {
                    if ($leads->employee['empId'] != "") {
                        $assignid = $leads->employee['empId'];
                        $assignvalue = $assignname . ' (' . $assignid . ')';
                    } else {
                        $assignvalue = $assignname;
                    }
                } else {
                    $assignvalue = $assignname;
                }
            } else {
                $assignvalue = '--';
            }
            if ($leads['dispatchStatus'] == '') {
                $status = '--';
            } else {
                $status = '<a href="#">

<span data-toggle="tooltip" data-placement="bottom" title="Assigned to : ' . $assignvalue . '"  data-container="body" > ' . $leads['dispatchStatus'] . ' </span>  ';
            }


            $leads->checkall = $check;
            $leads->customerCode = $code;
            $leads->referenceNumber = $referenceNumber;
            $leads->customerName = $customerName;
            $leads->recipientName = $recipientName;
            $leads->contactNo = $contact;
            $leads->email = $email;
            $leads->caseManager = $caseManager;
            $leads->agent = $agent;
            $leads->dispatchType = $dispatchType;
            $leads->deliveryMode = $deliveryMode ?: '--';
            $leads->status = $status;
            $leads->assign = $assignvalue;
            $leads->created = Carbon::parse($created_at)->format('d/m/Y');
            if (session('role') == 'Admin') {
                $delete_button = '<button class="btn export_btn waves-effect auto_modal delete_icon_btn" type="button" data-toggle="tooltip" data-placement="bottom" title="Delete" data-container="body"  data-modal="delete_popup" dir="' . $leads->_id . '" onclick="delete_pop(this);">
<i class="material-icons">delete_outline</i>
</button>';
                $leads->delete_button = $delete_button;
            } else {
                $leads->delete_button = "";
            }
        }
        if ($search) {
            $filtered_count = $search_count;
        } else {
            $filtered_count = $total_leads;
        }


        $data = array(
            'draw' => $draw,
            'recordsTotal' => $total_leads,
            'recordsFiltered' => $filtered_count,
            'data' => $final_leads,
        );

        return json_encode($data);
    }

    /**
     * get lead details
     */
    public function getLeadDetails(Request $request)
    {
        $current_path = $request->input('current_path');
        $leadDetails = LeadDetails::find($request->input('lead_id'));
        $allMode = DeliveryMode::orderBy('deliveryMode')->get();
        if (
            session('role') == 'Insurer' || session('role') == 'Employee' || session('role') == 'Agent' || session('role') == 'Coordinator' || session('role') == 'Courier' ||
            session('role') == 'Messenger' || session('role') == 'Accountant' || session('role') == 'Supervisor'
        ) {
            $dispatchTypes = DispatchTypes::where('type', '!=', 'Direct Collections')->orderBy('type')->get();
        } else {
            $dispatchTypes = DispatchTypes::orderBy('type')->get();
        }
        if ($leadDetails->dispatchDetails) {
            foreach ($allMode as $single) {
                if ($leadDetails['dispatchDetails']['deliveryMode']['id'] == $single->_id) {
                    $response[] = "<option value='$single->id' selected>$single->deliveryMode</option>";
                } else {
                    $response[] = "<option value='$single->id'>$single->deliveryMode</option>";
                }
            }
            $documentTypes = DocumentType::all();
            $string_version = implode(',', $response);

            foreach ($dispatchTypes as $type) {
                if ($leadDetails['dispatchDetails']['taskType']['id'] == $type->_id) {
                    $response1[] = "<option value='$type->id' selected>$type->type</option>";
                } else {
                    $response1[] = "<option value='$type->id'>$type->type</option>";
                }
            }
            $dis_type = implode(',', $response1);
            if ($leadDetails->deliveryMode['deliveryMode'] == 'Agent') {
               
                $employees = User::where('isActive', 1)->where('role', 'AG')->orderBy('name')->get();
                $emp_name[] = "<option value=''>Select Agent</option>";
                foreach ($employees as $employee) {
                    if ($employee->_id == @$leadDetails->employee['id']) {
                        if ($employee->empID != '') {
                            $id = ' (' . $employee->empID . ')';
                        } else {
                            $id = '';
                        }
                        $emp_name[] = "<option value='$employee->_id' selected>$employee->name $id</option>";
                    } else {
                        if ($employee->empID != '') {
                            $id = ' (' . $employee->empID . ')';
                        } else {
                            $id = '';
                        }
                        $emp_name[] = "<option value='$employee->_id'>$employee->name $id</option>";
                    }
                }
            } elseif ($leadDetails->deliveryMode['deliveryMode'] == 'Admin') {
                $employeesAdmin = User::where('isActive', 1)->where('role', 'AD')->orderBy('name')->get();
                $emp_name[] = "<option value=''>Select Admin</option>";
                foreach ($employeesAdmin as $employee) {
                    if ($employee->_id == @$leadDetails->employee['id']) {
                        if ($employee->empID != '') {
                            $id = ' (' . $employee->empID . ')';
                        } else {
                            $id = '';
                        }
                        $emp_name[] = "<option value='$employee->_id' selected>$employee->name $id</option>";
                    } else {
                        if ($employee->empID != '') {
                            $id = ' (' . $employee->empID . ')';
                        } else {
                            $id = '';
                        }
                        $emp_name[] = "<option value='$employee->_id'>$employee->name $id</option>";
                    }
                }
            } elseif ($leadDetails->deliveryMode['deliveryMode'] == 'Coordinator') {
                $employeesAdmin = User::where('isActive', 1)->where('role', 'CO')->orderBy('name')->get();
                $emp_name[] = "<option value=''>Select Coordinator</option>";
                foreach ($employeesAdmin as $employee) {
                    if ($employee->_id == @$leadDetails->employee['id']) {
                        if ($employee->empID != '') {
                            $id = ' (' . $employee->empID . ')';
                        } else {
                            $id = '';
                        }
                        $emp_name[] = "<option value='$employee->_id' selected>$employee->name $id</option>";
                    } else {
                        if ($employee->empID != '') {
                            $id = ' (' . $employee->empID . ')';
                        } else {
                            $id = '';
                        }
                        $emp_name[] = "<option value='$employee->_id'>$employee->name $id</option>";
                    }
                }
            } elseif ($leadDetails->deliveryMode['deliveryMode'] == 'Supervisor') {
                $employeesAdmin = User::where('isActive', 1)->where('role', 'SV')->orderBy('name')->get();
                $emp_name[] = "<option value=''>Select Supervisor</option>";
                foreach ($employeesAdmin as $employee) {
                    if ($employee->_id == @$leadDetails->employee['id']) {
                        if ($employee->empID != '') {
                            $id = ' (' . $employee->empID . ')';
                        } else {
                            $id = '';
                        }
                        $emp_name[] = "<option value='$employee->_id' selected>$employee->name $id</option>";
                    } else {
                        if ($employee->empID != '') {
                            $id = ' (' . $employee->empID . ')';
                        } else {
                            $id = '';
                        }
                        $emp_name[] = "<option value='$employee->_id'>$employee->name $id</option>";
                    }
                }
            } elseif ($leadDetails->deliveryMode['deliveryMode'] == 'Courier') {
               
                $employees = User::where('isActive', 1)->where('role', 'CR')->orderBy('name')->get();

                $emp_name[] = "<option value=''>Select Courier</option>";
                foreach ($employees as $employee) {
                    if ($employee->_id == @$leadDetails->employee['id']) {
                        if ($employee->empID != '') {
                            $id = ' (' . $employee->empID . ')';
                        } else {
                            $id = '';
                        }
                        $emp_name[] = "<option value='$employee->_id' selected>$employee->name $id</option>";
                    } else {
                        if ($employee->empID != '') {
                            $id = ' (' . $employee->empID . ')';
                        } else {
                            $id = '';
                        }
                        $emp_name[] = "<option value='$employee->_id'>$employee->name $id</option>";
                    }
                    
                }
            } else {
               
                $employees = User::where('isActive', 1)->where(function ($q) {
                    $q->where('role', 'EM')->orwhere('role', 'MS');
                })->orderBy('name')->get();
                $emp_name[] = "<option value=''>Select Employee</option>";
                foreach ($employees as $employee) {
                    if ($employee->_id == @$leadDetails->employee['id']) {
                        if ($employee->empID != '') {
                            $id = ' (' . $employee->empID . ')';
                        } else {
                            $id = '';
                        }
                        $emp_name[] = "<option value='$employee->_id' selected>$employee->name $id</option>";
                    } else {
                        if ($employee->empID != '') {
                            $id = ' (' . $employee->empID . ')';
                        } else {
                            $id = '';
                        }
                        $emp_name[] = "<option value='$employee->_id'>$employee->name $id</option>";
                    }
                }
            }

            if ($leadDetails->dispatchType['dispatchType'] == 'Collections') {
                $DispatchType = DispatchTypes::where('_id', $leadDetails->dispatchType['id'])->get();
            } else {
                if ($leadDetails->dispatchType['dispatchType'] == 'Delivery') {
                    $DispatchType = DispatchTypes::where('_id', $leadDetails->dispatchType['id'])->get();
                } else {
                    if ($leadDetails->dispatchType['dispatchType'] == 'Direct Collections') {
                        $DispatchType = DispatchTypes::where('_id', $leadDetails->dispatchType['id'])->get();
                    } else {
                        if ($leadDetails->dispatchType['dispatchType'] == 'Delivery & Collections') {
                            $DispatchType = DispatchTypes::whereNotIn('code', ['DC', 'DI'])->get();
                        }
                    }
                }
            }

            $doctype[] = "<option value=''>Select Type</option>";
            foreach ($DispatchType as $disType) {
                $doctype[] = "<option value='$disType->_id'>$disType->type</option>";
            }
            $lead = 'lead';
            $document = $leadDetails['dispatchDetails']['documentDetails'];
            $documentSection = view('dispatch.includes_pages.documents_section', [
                'document' => $document,
                'doctype' => $doctype,
                'documentTypes' => $documentTypes,
                'current_path' => $current_path,
                'dispatchTypes' => $dispatchTypes,
                'DispatchType' => $DispatchType,
                'save_status' => $lead,
                'leadDetails' => $leadDetails
            ])->render();
            if (Auth::user()->_id == $leadDetails->caseManager['id'] && Auth::user()->role != 'Admin') {
                $case_manager = true;
            } else {
                $case_manager = false;
            }
            $docStatus = [];
            if ($document) {
                foreach ($document as $doc) {
                    $docStatus[] = $doc['DocumentCurrentStatus'];
                }
            }
            if (isset($leadDetails['agent']['name'])) {
                $ag_value = $leadDetails['agent']['name'];
                if (isset($leadDetails['agent']['empid'])) {
                    if ($leadDetails['agent']['empid'] != "") {
                        $ag_id = $leadDetails['agent']['empid'];
                        $ag_name = $ag_value . ' (' . $ag_id . ')';
                    } else {
                        $ag_name = $ag_value?:'NA';
                    }
                } else {
                    $ag_name = $ag_value?:'NA';
                }
            } else {
                $ag_name = 'NA';
            }
            return response()->json([
                'emp_name' => $emp_name,
                'ag_name' => $ag_name,
                'success' => 'edit',
                'edit' => 'editValue',
                'leadDetails' => $leadDetails,
                'document' => $document,
                'string_version' => $string_version,
                'documentSection' => $documentSection,
                'case_manager' => $case_manager,
                'dis_type' => $dis_type
            ]);
        } else {
            foreach ($allMode as $single) {
                if ($leadDetails['deliveryMode']['id'] == $single->_id) {
                    $response[] = "<option value='$single->id' selected>$single->deliveryMode</option>";
                } else {
                    $response[] = "<option value='$single->id'>$single->deliveryMode</option>";
                }
            }
            $string_version = implode(',', $response);

            foreach ($dispatchTypes as $type) {
                if ($leadDetails['dispatchType']['id'] == $type->_id) {
                    $response1[] = "<option value='$type->id' selected>$type->type</option>";
                } else {
                    $response1[] = "<option value='$type->id'>$type->type</option>";
                }
            }
            $dis_type = implode(',', $response1);
            $customer_id = $leadDetails['customer.id'];
            if ($leadDetails->saveType == 'customer') {
                $customer = Customer::find($customer_id);
            } else {
                $customer = RecipientDetails::find($customer_id);
            }
            if (isset($customer->addressLine2) != '') {
                $address2 = ',' . $customer->addressLine2;
            } else {
                $address2 = '';
            }
            if (isset($customer->addressLine1) != '') {
                $address1 = $customer->addressLine1;
            } else {
                $address1 = '';
            }
            if (isset($customer->streetName)) {
                $streetName = '' . $customer->streetName;
            } else {
                $streetName = '';
            }
            if (isset($customer->cityName)) {
                $cityName = '' . $customer->cityName;
            } else {
                $cityName = '';
            }
            $address = $address1 . '' . $address2 . '' . $cityName;
            $landmark = $streetName;
            if ($leadDetails->deliveryMode['deliveryMode'] == 'Agent') {
                //				if(isset($leadDetails->employee['id'])&& !empty($leadDetails->employee['id']))
                //				{
                //					$employee= User::find($leadDetails->employee['id']);
                //					if($employee->empID!='')
                //					{
                //						$id=' ('.$employee->empID.')';
                //					}
                //					else{
                //						$id='';
                //					}
                //					$emp_name[] = "<option value='$employee->_id' selected>$employee->name$id</option>";
                //
                //				}else{
                $employees = User::where('isActive', 1)->where('role', 'AG')->orderBy('name')->get();
                $emp_name[] = "<option value=''>Select Agent</option>";
                foreach ($employees as $employee) {
                    if ($employee->_id == @$leadDetails->employee['id']) {
                        if ($employee->empID != '') {
                            $id = ' (' . $employee->empID . ')';
                        } else {
                            $id = '';
                        }
                        $emp_name[] = "<option value='$employee->_id' selected>$employee->name $id</option>";
                    } else {
                        if ($employee->empID != '') {
                            $id = ' (' . $employee->empID . ')';
                        } else {
                            $id = '';
                        }
                        $emp_name[] = "<option value='$employee->_id'>$employee->name $id</option>";
                    }
                }
                //				}
            } elseif ($leadDetails->deliveryMode['deliveryMode'] == 'Admin') {
                $employees = User::where('isActive', 1)->where('role', 'AD')->orderBy('name')->get();
                $emp_name[] = "<option value=''>Select Admin</option>";
                foreach ($employees as $employee) {
                    if ($employee->_id == @$leadDetails->employee['id']) {
                        if ($employee->empID != '') {
                            $id = ' (' . $employee->empID . ')';
                        } else {
                            $id = '';
                        }
                        $emp_name[] = "<option value='$employee->_id' selected>$employee->name $id</option>";
                    } else {
                        if ($employee->empID != '') {
                            $id = ' (' . $employee->empID . ')';
                        } else {
                            $id = '';
                        }
                        $emp_name[] = "<option value='$employee->_id'>$employee->name $id</option>";
                    }
                }
            } elseif ($leadDetails->deliveryMode['deliveryMode'] == 'Coordinator') {
                $employees = User::where('isActive', 1)->where('role', 'CO')->orderBy('name')->get();
                $emp_name[] = "<option value=''>Select Coordinator</option>";
                foreach ($employees as $employee) {
                    if ($employee->_id == @$leadDetails->employee['id']) {
                        if ($employee->empID != '') {
                            $id = ' (' . $employee->empID . ')';
                        } else {
                            $id = '';
                        }
                        $emp_name[] = "<option value='$employee->_id' selected>$employee->name $id</option>";
                    } else {
                        if ($employee->empID != '') {
                            $id = ' (' . $employee->empID . ')';
                        } else {
                            $id = '';
                        }
                        $emp_name[] = "<option value='$employee->_id'>$employee->name $id</option>";
                    }
                }
            } elseif ($leadDetails->deliveryMode['deliveryMode'] == 'Supervisor') {
                $employees = User::where('isActive', 1)->where('role', 'SV')->orderBy('name')->get();
                $emp_name[] = "<option value=''>Select Supervisor</option>";
                foreach ($employees as $employee) {
                    if ($employee->_id == @$leadDetails->employee['id']) {
                        if ($employee->empID != '') {
                            $id = ' (' . $employee->empID . ')';
                        } else {
                            $id = '';
                        }
                        $emp_name[] = "<option value='$employee->_id' selected>$employee->name $id</option>";
                    } else {
                        if ($employee->empID != '') {
                            $id = ' (' . $employee->empID . ')';
                        } else {
                            $id = '';
                        }
                        $emp_name[] = "<option value='$employee->_id'>$employee->name $id</option>";
                    }
                }
            } elseif ($leadDetails->deliveryMode['deliveryMode'] == 'Courier') {
                //				if (isset($leadDetails->employee['id']) && !empty($leadDetails->employee['id'])) {
                //					$employee = User::find($leadDetails->employee['id']);
                //					if ($employee->empID != '') {
                //						$id = ' (' . $employee->empID . ')';
                //					} else {
                //						$id = '';
                //					}
                //					$emp_name[] = "<option value='$employee->_id' selected>$employee->name$id</option>";
                //
                //				} else {
                $employees = User::where('isActive', 1)->where('role', 'CR')->orderBy('name')->get();

                $emp_name[] = "<option value=''>Select Courier</option>";
                foreach ($employees as $employee) {
                    if ($employee->_id == @$leadDetails->employee['id']) {
                        if ($employee->empID != '') {
                            $id = ' (' . $employee->empID . ')';
                        } else {
                            $id = '';
                        }
                        $emp_name[] = "<option value='$employee->_id' selected>$employee->name $id</option>";
                    } else {
                        if ($employee->empID != '') {
                            $id = ' (' . $employee->empID . ')';
                        } else {
                            $id = '';
                        }
                        $emp_name[] = "<option value='$employee->_id'>$employee->name $id</option>";
                    }
                    //					}
                }
            } else {
                //				if(isset($leadDetails->employee['id'])&& !empty($leadDetails->employee['id']))
                //				{
                //					$employee= User::find($leadDetails->employee['id']);
                //					if($employee->empID!='')
                //					{
                //						$id=' ('.$employee->empID.')';
                //					}
                //					else{
                //						$id='';
                //					}
                //					$emp_name[] = "<option value='$employee->_id' selected>$employee->name$id</option>";
                //				}else{
                $employees = User::where('isActive', 1)->where(function ($q) {
                    $q->where('role', 'EM')->orwhere('role', 'MS');
                })->orderBy('name')->get();
                $emp_name[] = "<option value=''>Select Employee</option>";
                foreach ($employees as $employee) {
                    if ($employee->_id == @$leadDetails->employee['id']) {
                        if ($employee->empID != '') {
                            $id = ' (' . $employee->empID . ')';
                        } else {
                            $id = '';
                        }
                        $emp_name[] = "<option value='$employee->_id' selected>$employee->name $id</option>";
                    } else {
                        if ($employee->empID != '') {
                            $id = ' (' . $employee->empID . ')';
                        } else {
                            $id = '';
                        }
                        $emp_name[] = "<option value='$employee->_id'>$employee->name $id</option>";
                    }
                }
                //				}
            }

            if ($leadDetails->dispatchType['dispatchType'] == 'Collections') {
                $DispatchType = DispatchTypes::where('_id', $leadDetails->dispatchType['id'])->get();
            } else {
                if ($leadDetails->dispatchType['dispatchType'] == 'Delivery') {
                    $DispatchType = DispatchTypes::where('_id', $leadDetails->dispatchType['id'])->get();
                } else {
                    if ($leadDetails->dispatchType['dispatchType'] == 'Delivery & Collections') {
                        $DispatchType = DispatchTypes::whereNotIn('code', ['DC', 'DI'])->get();
                    }
                }
            }

            $doctype[] = "<option value='' disabled>Select Type</option>";
            foreach ($DispatchType as $disType) {
                if ($leadDetails->dispatchType['dispatchType'] == 'Delivery & Collections') {
                    $doctype[] = "<option value='$disType->_id'>$disType->type</option>";
                } else {
                    $doctype[] = "<option value='$disType->_id' selected>$disType->type</option>";
                }
            }
            if (Auth::user()->_id == $leadDetails->caseManager['id']) {
                $case_manager = true;
            } else {
                $case_manager = false;
            }
            if (isset($leadDetails['agent']['name'])) {
                $ag_value = $leadDetails['agent']['name'];
                if (isset($leadDetails['agent']['empid'])) {
                    if ($leadDetails['agent']['empid'] != "") {
                        $ag_id = $leadDetails['agent']['empid'];
                        $ag_name = $ag_value . ' (' . $ag_id . ')';
                    } else {
                        $ag_name =$ag_value?:'NA';
                    }
                } else {
                    $ag_name = $ag_value?:'NA';
                }
            } else {
                $ag_name = 'NA';
            }
            return response()->json([
                'emp_name' => $emp_name,
                'ag_name' => $ag_name,
                'doctype' => $doctype,
                'success' => 'save',
                'leadDetails' => $leadDetails,
                'address' => $address,
                'landmark' => $landmark,
                'string_version' => $string_version,
                'case_manager' => $case_manager,
                'dis_type' => $dis_type
            ]);
        }
    }

    /**
     * get document details of lead
     */
    public function getDocType(Request $request)
    {
        $lead_id = $request->input('lead_id');
        $taskType = $request->input('taskType');
        if ($taskType != '') {
            $DispatchType = DispatchTypes::where('_id', $taskType)->first();
            $dispatchTypeSelected = $DispatchType->type;
            if ($DispatchType->type == 'Delivery & Collections') {
                $DispatchTypes = DispatchTypes::whereNotIn('code', ['DC', 'DI'])->get();
            } else {
                $DispatchTypes = DispatchTypes::where('_id', $taskType)->get();
            }
            $doctype[] = "<option value=''selected disabled>Select Type</option>";

            foreach ($DispatchTypes as $disType) {
                if ($disType->type == 'Delivery & Collections') {
                    $doctype[] = "<option value='$disType->_id'>$disType->type</option>";
                } else {
                    $doctype[] = "<option value='$disType->_id' >$disType->type</option>";
                }
            }
            return response()->json(['doctype' => $doctype, 'dispatchTypeSelected' => $dispatchTypeSelected, 'success' => true]);
        } else {
            $leadDetails = LeadDetails::find($lead_id);
            if ($leadDetails->dispatchType['dispatchType'] == 'Collections') {
                $DispatchTypes = DispatchTypes::where('_id', $leadDetails->dispatchType['id'])->get();
            } else {
                if ($leadDetails->dispatchType['dispatchType'] == 'Delivery') {
                    $DispatchTypes = DispatchTypes::where('_id', $leadDetails->dispatchType['id'])->get();
                } else {
                    if ($leadDetails->dispatchType['dispatchType'] == 'Delivery & Collections') {
                        $DispatchTypes = DispatchTypes::whereNotIn('code', ['DC', 'DI'])->get();
                    }
                }
            }
            $doctype[] = "<option value='' selected disabled>Select Type</option>";
            foreach ($DispatchTypes as $disType) {
                if ($leadDetails->dispatchType['dispatchType'] == 'Delivery & Collections') {
                    $doctype[] = "<option value='$disType->_id'>$disType->type</option>";
                } else {
                    $doctype[] = "<option value='$disType->_id' >$disType->type</option>";
                }
            }
            return response()->json(['doctype' => $doctype, 'success' => true]);
        }
    }

    /**
     * save dispatch form details
     */
    public function saveDispatchForm(Request $request)
    {
        $uniqIdArrayForm = $request->input('uniqIdArray');
        $idUniq = explode(",", $uniqIdArrayForm);
        $lead_id = $request->input('lead_id');
        $leadDetails = LeadDetails::find($lead_id);
        $dispatchDetails = new \stdClass();
        if ($leadDetails->saveType == 'recipient') {
            $customer = RecipientDetails::find($leadDetails->customer['id']);
            $customerCode = '';
        } else {
            $customer = Customer::find($leadDetails->customer['id']);
            $customerCode = $customer->customerCode;
        }
        if ($request->input('employee_list') != '') {
            $emp_object = new \stdClass();
            $employee = User::find($request->input('employee_list'));
            $emp_object->id = new ObjectId($employee->_id);
            $emp_object->name = $employee->name;
            $emp_object->empId = $employee->empID;
            $dispatchDetails->employee = $emp_object;
        } else {
            $emp_object = '';
        }

        $customer_object = new \stdClass();
        $customer_object->id = new ObjectID($customer->_id);
        $customer_object->name = $request->input('customerName');
        $customer_object->recipientName = $request->input('recipientName');
        $customer_object->customerCode = $customerCode;
        $dispatchDetails->customer = $customer_object;

        $delivery = DeliveryMode::find($request->input('deliveryMode'));
        $deliveryObject = new \stdClass();
        $deliveryObject->id = new ObjectID($delivery->_id);
        $deliveryObject->deliveryMode = $delivery->deliveryMode;
        if ($deliveryObject->deliveryMode == "Courier") {
            if ($request->input('way_bill')) {
                $deliveryObject->wayBill = $request->input('way_bill');
            } else {
                $deliveryObject->wayBill = '--';
            }
        }
        $dispatchDetails->deliveryMode = $deliveryObject;
        $disType = DispatchTypes::find($request->input('taskType'));
        $disTypeObject = new \stdClass();
        $disTypeObject->id = new ObjectID($disType->_id);
        $disTypeObject->dispatchType = $disType->type;
        $dispatchDetails->taskType = $disTypeObject;
        $referenceNumber = explode('/', $leadDetails->referenceNumber);
        $referencenumber = $disType->code . "/" . $referenceNumber[1] . "/" . $referenceNumber[2] . "/" . $referenceNumber[3];
        $dispatchDetails->agent = $request->input('agentName');
        $dispatchDetails->caseManager = $request->input('caseManager');
        $dispatchDetails->date_time = $request->input('date_time') ?: '';
        $dispatchDetails->land_mark = $request->input('land_mark');
        $dispatchDetails->address = $request->input('address');
        $dispatchDetails->emailId = $request->input('emailId');
        $dispatchDetails->contactNum = $request->input('contactNum');
        $documentNameArray = $request->input('docName');
        $documentTypeArray = $request->input('type');
        $documentDescArray = $request->input('docDesc');
        $documentamountArray = $request->input('doc_amount');
        $documentSelectArray = $request->input('docid');
        $saveMethod = $request->input('save_method');
        $uniqIdArray = [];
        if (isset($idUniq)) {
            foreach ($idUniq as $uniqDocId) {
                LeadDetails::where('_id', new ObjectId($lead_id))->pull('dispatchDetails.documentDetails', ['id' => $uniqDocId]);
            }
        }
        $statusArray = [];
        $collectedAmountArray = [];
        if (isset($leadDetails['dispatchDetails']) && isset($documentSelectArray)) {
            $leadDocument = $leadDetails['dispatchDetails']['documentDetails'];
            foreach ($leadDocument as $key => $value) {
                if (in_array($value['id'], $documentSelectArray)) {
                    $statusArray[] = $value['DocumentCurrentStatus'];
                    if (isset($value['doc_collected_amount'])) {
                        $collectedAmountArray[] = $value['doc_collected_amount'];
                    }
                }
            }
        }

        foreach ($documentNameArray as $key => $doc) {
            $doc_array = [];
            if (isset($documentTypeArray[$key]) || isset($documentNameArray[$key]) || isset($documentDescArray[$key])) {
                $doc_object = new \stdClass();
                if (strval($doc) == strval(intval($doc))) {
                    $documentTypeDetails = DocumentType::where('docNum', (int) $doc)->first();
                    if (count($documentTypeDetails) == 0) {
                        $docId = '';
                        $docname = '';
                    } else {
                        $docId = new ObjectID($documentTypeDetails->_id);
                        $docname = $documentTypeDetails->documentType;
                    }
                } else {
                    $documentTypeDetails = DocumentType::where('documentType', $doc)->first();
                    if (count($documentTypeDetails) == 0) {
                        $docId = '';
                        $docname = '';
                    } else {
                        $docId = new ObjectID($documentTypeDetails->_id);
                        $docname = $documentTypeDetails->documentType;
                    }
                }
                if (isset($documentTypeArray[$key])) {
                    if (preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/', $documentTypeArray[$key])) {
                        $dispatchType = DispatchTypes::find($documentTypeArray[$key]);
                        if (count($dispatchType) == 0) {
                            $disId = '';
                            $disType1 = '';
                        } else {
                            $disId = new ObjectID($dispatchType->id);
                            $disType1 = $dispatchType->type;
                        }
                    } else {
                        $dispatchType = DispatchTypes::where('type', $documentTypeArray[$key])->first();
                        $disId = new ObjectID($dispatchType->id);
                        $disType1 = $dispatchType->type;
                    }
                } else {
                    $disId = '';
                    $disType1 = '';
                }

                $doc_object->documentId = $docId;
                $doc_object->documentName = $docname;
                if (strval($doc) == strval(intval($doc))) {
                    if ($doc == 3 || $doc == 4 || $doc == 5) {
                        if (isset($documentamountArray[$key])) {
                            $doc_object->amount = $documentamountArray[$key];
                        } else {
                            $doc_object->amount = '';
                        }
                    } else {
                        $doc_object->amount = '';
                    }
                }
                if (strval($doc) != strval(intval($doc))) {
                    if (isset($documentamountArray[$key]) && $documentamountArray[$key] != 'NA') {
                        $doc_object->amount = $documentamountArray[$key];
                    } else {
                        $doc_object->amount = '';
                    }
                }
                if (isset($collectedAmountArray[$key])) {
                    $doc_object->doc_collected_amount = $collectedAmountArray[$key];
                } else {
                    $doc_object->doc_collected_amount = '';
                }
                $doc_object->documentDescription = $documentDescArray[$key];
                $doc_object->documentTypeId = $disId;
                //					$doc_object->DocumentCurrentStatus = '1';
                if (isset($statusArray[$key])) {
                    $doc_object->DocumentCurrentStatus = $statusArray[$key];
                } elseif ($saveMethod == 'submit_button') {
                    $doc_object->DocumentCurrentStatus = '18';
                } else {
                    $doc_object->DocumentCurrentStatus = '1';
                }
                $doc_object->documentType = $disType1;

                if (isset($documentSelectArray[$key])) {
                    $doc_object->id = $documentSelectArray[$key];
                    LeadDetails::where('_id', new ObjectId($lead_id))->pull('dispatchDetails.documentDetails', ['id' => $documentSelectArray[$key]]);
                    $doc_array[] = $doc_object;
                    LeadDetails::where('_id', new ObjectId($lead_id))->push('dispatchDetails.documentDetails', $doc_array);
                } else {
                    $uniqId = uniqid();
                    $doc_object->id = $uniqId;
                    $doc_array[] = $doc_object;
                    LeadDetails::where('_id', new ObjectId($lead_id))->push('dispatchDetails.documentDetails', $doc_array);
                    $uniqIdArray[] = $uniqId;
                }
            }
        }
        //		dd($statusArray);
        $lead_details = LeadDetails::find($lead_id);
        $dispatchDetails->documentDetails = $lead_details['dispatchDetails']['documentDetails'];
        $dispatchDetails->receivedBy = $request->input('receivedBy');
        $dispatchDetails->deliveredBy = $request->input('deliveredBy');
        $dispatchDetails->active = (int) 1;

        $leadDetails->dispatchDetails = $dispatchDetails;

        $leadDetails->contactNumber = $request->input('contactNum');
        $leadDetails->contactEmail = $request->input('emailId');
        $leadDetails->deliveryMode = $deliveryObject;
        $leadDetails->dispatchType = $disTypeObject;
        $leadDetails->customer = $customer_object;
        $leadDetails->employee = $emp_object;

        //		$leadDetails->push('previousDetails', $dispatchDetails);
        $updatedBy_obj = new \stdClass();
        $updatedBy_obj->id = new ObjectID(Auth::id());
        $updatedBy_obj->name = Auth::user()->name;
        $updatedBy_obj->date = date('d/m/Y');
        $name = $updatedBy_obj->name;
        $updatedBy_obj->action = "Dispatch Slip Created";
        $updatedBy[] = $updatedBy_obj;
        if ($leadDetails->updatedBy) {
            $leadDetails->push('updatedBy', $updatedBy);
        } else {
            $leadDetails->updatedBy = $updatedBy;
        }
        $leadDetails->save();

        if ($saveMethod == 'print_without_button') {
            $print = "print_without";
        } elseif ($saveMethod == 'print_button') {
            $print = "print_with";
        } else {
            $referenceNumber = explode('/', $leadDetails->referenceNumber);
            $refNumber = $disType->code . "/" . $referenceNumber[1] . "/" . $referenceNumber[2] . "/" . $referenceNumber[3];
            LeadDetails::where('_id', new ObjectID($lead_id))->update(array('referenceNumber' => $refNumber));
            $print = '';
            if ($saveMethod == 'save_button') {
                $leadDetails->save();
                //				$this->saveTabStatus( $request->input('lead_id'));
                Session::flash('status', 'Dispatch slip saved successfully');
                return response()->json(['success' => true]);
            } elseif ($saveMethod == 'submit_button') {
                if (isset($leadDetails->rejectstatus)) {
                    LeadDetails::where('_id', new ObjectId($lead_id))->unset('rejectstatus');
                }
                if (isset($leadDetails->schedulerejectstatus)) {
                    LeadDetails::where('_id', new ObjectId($lead_id))->unset('schedulerejectstatus');
                }
                $dispatchStatus = $leadDetails->dispatchStatus;

                if (isset($dispatchStatus)) {
                    if ($dispatchStatus == 'Rejected From reception' || $dispatchStatus == 'Partial') {
                        if ($dispatchStatus == 'Rejected From reception') {
                            $leadDetails->dispatchStatus = 'Reception';
                        } else {
                            $leadDetails->dispatchStatus = 'Partial';
                        }
                    } else {
                        $leadDetails->dispatchStatus = 'Reception';
                    }
                } else {
                    $leadDetails->dispatchStatus = 'Reception';
                }
                $leadDetails->save();
                if ($leadDetails->dispatchStatus == 'Partial') {
                    $leadDetailsDet = LeadDetails::find($lead_id);
                    $lead = $leadDetailsDet['dispatchDetails']['documentDetails'];
                    foreach ($lead as $count => $reply) {
                        if ((in_array($reply['id'], $documentSelectArray)) && ($reply['DocumentCurrentStatus'] != '6' && $reply['DocumentCurrentStatus'] != '15')) {
                            $this->saveDocumentStatus($lead_id, $count, '18');
                        }
                    }
                    $this->saveTabStatus($leadDetails->_id);
                } elseif ($leadDetails->dispatchStatus == 'Rejected From reception') {
                    $leadDetailsDet = LeadDetails::find($lead_id);
                    $lead = $leadDetailsDet['dispatchDetails']['documentDetails'];
                    foreach ($lead as $count => $reply) {
                        if (in_array($reply['id'], $documentSelectArray) && ($reply['DocumentCurrentStatus'] != '6' && $reply['DocumentCurrentStatus'] != '15')) {
                            $this->saveDocumentStatus($lead_id, $count, '18');
                        }
                    }
                    $this->saveTabStatus($leadDetails->_id);
                } else {
                    $leadDetailsDet = LeadDetails::find($lead_id);
                    $lead = $leadDetailsDet['dispatchDetails']['documentDetails'];
                    foreach ($lead as $count => $reply) {
                        $this->saveDocumentStatus($lead_id, $count, '18');
                    }
                    $this->saveDirectTabStatus($leadDetails->_id);
                }
                date_default_timezone_set('Asia/Dubai');
                $comment_time = date('H:i:s');
                $comment_object = new \stdClass();
                $comment_object->comment = 'Lead created' . ',' . 'Message' . ' : ' . ucfirst(ucwords($request->input('action_comment')));
                $comment_object->commentBy = Auth::user()->name;
                $comment_object->commentTime = $comment_time;
                $comment_object->id = new ObjectId(Auth::id());
                $comment_object->date = date('d/m/Y');
                $comment_array[] = $comment_object;
                $leadDetails->push('comments', $comment_array);
                Session::flash('status', 'Dispatch slip submitted successfully');
                return response()->json(['success' => 'reception']);
            }
        }

        if ($print != '') {
            $leadDetails->save();
            if (isset($documentSelectArray) && isset($uniqIdArray)) {
                $documentSelectArray = array_merge($documentSelectArray, $uniqIdArray);
            } elseif (isset($documentSelectArray) && !isset($uniqIdArray)) {
                $documentSelectArray = $documentSelectArray;
            } elseif (!isset($documentSelectArray) && isset($uniqIdArray)) {
                $documentSelectArray = $uniqIdArray;
            }
            $leadDet = LeadDetails::find($leadDetails->_id);
            $documentsList = $leadDet['dispatchDetails']['documentDetails'];
            $pdf = PDF::loadView('dispatch.pdf.dispatch_slip', ['documentSelectArray' => $documentSelectArray, 'documentsList' => $documentsList, 'leadDetails' => $leadDetails, 'print' => $print]);
            $pdf_name = 'dispatch-slip_' . time() . '_' . $leadDetails->_id . '.pdf';
            $pdf->setOption('page-width', '200');
            $pdf->setOption('page-height', '260')->inline();
            $temp_path = public_path('pdf/' . $pdf_name);
            $pdf->save('pdf/' . $pdf_name);
            $pdf_file = $this->uploadFileToCloud_file($pdf_name, $temp_path);
            unlink($temp_path);
            $leadDetails->dispatchSlip = $pdf_file;
            $leadDetails->save();
            return response()->json(['success' => 'pdf', 'pdf' => $leadDetails->dispatchSlip, 'uniqIdArray' => $uniqIdArray]);
        } else {
            $leadDetails->save();
            Session::flash('status', 'Lead created successfully');
            return response()->json(['success' => true]);
        }
    }


    public function test()
    {
        $leadDetails = LeadDetails::where('referenceNumber', 'DC/170119/160946/01')->get();
        $count = 0;
        foreach ($leadDetails as $lead) {
            $lead->active = (int) 0;
            $lead->delete();
            $count++;
            echo $count;
        }
        //
        //		$custname=" haii";
        //		$action="Reception";
        //		$casename="krishna";
        //		$caseemail="krishna@gmail.com";
        //		$referencenumber="DC/031218/085940/03";
        //		$documents= ['5c04b86d14035'];
        //		$leadDetails = LeadDetails::find('5c0270b06e3a9201ad05eff3');
        //		$name="vishnu";
        //		$caselink=url('/dispatch/receptionist-list/');
        //		$saveMethod="submit_button";
        //		$prefered_date = $leadDetails->dispatchDetails['date_time'];
        //		$leadss =$leadDetails['dispatchDetails']['documentDetails'];
        ////        SendCaseManagerDelivery::dispatch($casename,$caseemail,$referencenumber,$name,$caselink,$saveMethod,$action,$leadss,$custname, $documents);
        ////        return 1;
        //		$data=['custname'=>$custname,'custemail'=>$caseemail,'referencenumber'=>$referencenumber,'name'=>$name,'caselink'=>$caselink,
        //			'saveMethod'=>$saveMethod,'action'=>$action,'leadss'=>$leadss, 'prefered_date'=> $prefered_date];
        //		return view('dispatch.emails.leads_email_customer', $data);
    }

    /**
     * Function for upload file to cloud
     */
    private static function uploadFileToCloud_file($file_name, $public_path)
    {
        $filePath = '/' . $file_name;
        $disk = Storage::disk('s3');
        $disk->put($filePath, fopen($public_path, 'r+'), 'public'); //uploading as streams, useful for large uploads.
        $file_url = 'https://s3-' . Config::get('filesystems.disks.s3.region') . '.amazonaws.com/' . Config::get('filesystems.disks.s3.bucket') . $filePath;
        return $file_url;
    }

    /**
     * save dispatch comment details
     */
    public function saveDispatchComment(Request $request)
    {
        $lead_id = $request->input('lead_id');
        $employee = $request->input('employee');
        $emp_unique = $request->input('emp_unique');

        if (!empty($employee) && $employee == 'true') {
            $userName = 'Employee';
        } else {
            $userName = '';
        }
        if (!empty($emp_unique)) {
            $user = User::find($emp_unique);
        } else {
            $user = '';
        }
        //$dt = new \DateTime();

        date_default_timezone_set('Asia/Dubai');
        // $dt = date('Y/m/d H:i:s');
        //dd($dt);
        $comment_time = date('H:i:s');
        $dispatchDetails = LeadDetails::find($lead_id);
        if ($dispatchDetails->comments) {
            $comment_object = new \stdClass();
            $comment_object->comment = ucfirst(ucwords($request->input('new_comment')));
            if ($userName != 'Employee') {
                $comment_object->commentBy = Auth::user()->name;
            } else {
                $comment_object->commentBy = $user->name;
            }

            $comment_object->commentTime = $comment_time;
            $comment_object->Documentname = $comment_time;
            $role = Auth::user()->roleDetail('name');
            $comment_object->userType = $role['name'];
            $comment_object->id = new ObjectId(Auth::id());
            $comment_object->date = date('d/m/Y ');
            $comment_array[] = $comment_object;
            $dispatchDetails->push('comments', $comment_array);
            $updatedBy_obj = new \stdClass();
            $updatedBy_obj->id = new ObjectID(Auth::id());
            $updatedBy_obj->name = Auth::user()->name;
            $updatedBy_obj->date = date('d/m/Y');
            $updatedBy_obj->action = "Commented";
            $updatedBy[] = $updatedBy_obj;
            $dispatchDetails->push('updatedBy', $updatedBy);
            $dispatchDetails->save();
        } else {
            $comment_object = new \stdClass();
            $comment_object->comment = ucfirst(ucwords($request->input('new_comment')));
            if ($userName != 'Employee') {
                $comment_object->commentBy = Auth::user()->name;
            } else {
                $comment_object->commentBy = $user->name;
            }
            $comment_object->commentTime = $comment_time;
            $role = Auth::user()->roleDetail('name');
            $comment_object->userType = $role['name'];
            $comment_object->id = new ObjectID(Auth::id());
            $comment_object->date = date('d/m/Y');
            $comment_array[] = $comment_object;
            $dispatchDetails->comments = $comment_array;
            $updatedBy_obj = new \stdClass();
            $updatedBy_obj->id = new ObjectID(Auth::id());
            $updatedBy_obj->name = Auth::user()->name;
            $updatedBy_obj->date = date('d/m/Y');
            $updatedBy_obj->action = "Commented";
            $updatedBy[] = $updatedBy_obj;
            $dispatchDetails->push('updatedBy', $updatedBy);
            $dispatchDetails->save();
        }
        if ($userName != 'Employee') {
            $commentBy = Auth::user()->name;
        } else {
            $commentBy = $user->name;
        }
        return response()->json([
            'success' => true,
            'time' => $comment_time,
            'commentBy' => $commentBy,
            'date' => date('d/m/Y')
        ]);
    }

    /**
     * load previous dispatch comment
     */
    public function loadDispatchComment(Request $request)
    {
        $leadDetails = LeadDetails::find($request->input('lead_id'));
        if (isset($leadDetails->comments)) {
            $comments = $leadDetails->comments;
        } else {
            $comments = '';
        }
        return json_encode($comments);
    }


    /**
     * export leads data
     */
    public function exportLeads(Request $request)
    {
        ini_set('xdebug.max_nesting_level', 500);
        $email = $request->input('email');
        $filter_data = json_decode(session('filter'));
        $sort = session('sort');
        $search = session('search');
        $leadDetails = LeadDetails::where('active', 1)->where('leadTabStatus', (int) 1);
        if (session('role') == 'Employee') {
            $leadDetails = $leadDetails->where(function ($q) {
                $q->where('caseManager.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('agent.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('employee.id', new ObjectID(Auth::user()->_id));
            });
        } elseif (session('role') == 'Agent') {
            $leadDetails = $leadDetails->where(function ($q) {
                $q->where('agent.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('caseManager.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('employee.id', new ObjectID(Auth::user()->_id));
            });
        } elseif (session('role') == 'Coordinator') {
            $leadDetails = $leadDetails->where(function ($q) {
                $q->where('agent.id', session('assigned_agent'))
                    ->orwhere('agent.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('employee.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('employee.id', session('assigned_agent'));
            });
        } elseif (session('role') == 'Supervisor') {
            $leadDetails = $leadDetails->where(function ($q) {
                $q->where('agent.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('caseManager.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('employee.id', new ObjectID(Auth::user()->_id))
                    ->orwhereIn('employee.id', session('employees'));
            });
        } elseif (session('role') != 'Admin' && session('role') != 'Receptionist') {
            $leadDetails = $leadDetails->where('employee.id', new ObjectID(Auth::user()->_id));
        }

        if (!empty($filter_data)) {
            if (!empty($filter_data->agent)) {
                $count = 0;
                foreach ($filter_data->agent as $agent) {
                    $objectArray[$count] = new ObjectId($agent);
                    $count++;
                }
                $leadDetails = $leadDetails->whereIn('agent.id', $objectArray);
            }
            if (!empty($filter_data->case_manager)) {
                $count = 0;
                foreach ($filter_data->case_manager as $manager) {
                    $objectArray[$count] = new ObjectId($manager);
                    $count++;
                }
                $leadDetails = $leadDetails->whereIn('caseManager.id', $objectArray);
            }
            if (!empty($filter_data->customer)) {
                $count = 0;
                foreach ($filter_data->customer as $cust) {
                    $objectArray[$count] = new ObjectId($cust);
                    $count++;
                }
                $leadDetails = $leadDetails->whereIn('customer.id', $objectArray);
            }
            if (!empty($filter_data->delivery)) {
                $count = 0;
                foreach ($filter_data->delivery as $mode) {
                    $objectArray[$count] = new ObjectId($mode);
                    $count++;
                }
                $leadDetails = $leadDetails->whereIn('deliveryMode.id', $objectArray);
            }
            if (!empty($filter_data->dispatch)) {
                $count = 0;
                foreach ($filter_data->dispatch as $type) {
                    $objectArray[$count] = new ObjectId($type);
                    $count++;
                }
                $leadDetails = $leadDetails->whereIn('dispatchType.id', $objectArray);
            }
            if (!empty($filter_data->assigned)) {
                $count = 0;
                foreach ($filter_data->assigned as $type) {
                    $objectArray[$count] = new ObjectId($type);
                    $count++;
                }
                $leadDetails = $leadDetails->whereIn('employee.id', $objectArray);
            }
            if (!empty($filter_data->status)) {
                $count = 0;
                foreach ($filter_data->status as $stat) {
                    $objectArray[$count] = $stat;
                    $count++;
                }
                $leadDetails = $leadDetails->whereIn('dispatchStatus', $objectArray);
            }
        }

        if (!empty($sort)) {
            if ($sort == "Customer Name") {
                $leadDetails = $leadDetails->orderBy('customer.name');
            } elseif ($sort == "Agent") {
                $leadDetails = $leadDetails->orderBy('agent.name');
            } elseif ($sort == "Case Manager") {
                $leadDetails = $leadDetails->orderBy('caseManager.name');
            } elseif ($sort == "Dispatch Type") {
                $leadDetails = $leadDetails->orderBy('dispatchType.dispatchType');
            } elseif ($sort == "Delivery Mode") {
                $leadDetails = $leadDetails->orderBy('deliveryMode.deliveryMode');
            }
        } elseif (empty($sort)) {
            $leadDetails = $leadDetails->orderBy(
                'created_at',
                'DESC'
            );
        }

        if ($search) {
            $leadDetails = $leadDetails->where(function ($query) use ($search) {
                $query->Where('referenceNumber', 'like', '%' . $search . '%')
                    ->orWhere('customer.name', 'like', '%' . $search . '%')
                    ->orWhere('customer.recipientName', 'like', '%' . $search . '%')
                    ->orWhere('customer.customerCode', 'like', '%' . $search . '%')
                    ->orWhere('agent.name', 'like', '%' . $search . '%')
                    ->orWhere('caseManager.name', 'like', '%' . $search . '%')
                    ->orWhere('contactNumber', 'like', '%' . $search . '%')
                    ->orWhere('contactEmail', 'like', '%' . $search . '%')
                    ->orWhere('deliveryMode.deliveryMode', 'like', '%' . $search . '%')
                    ->orWhere('dispatchType.dispatchType', 'like', '%' . $search . '%');
            });
            session()->put('search', $search);
        }

        $leadDetails = $leadDetails->select('customer', 'created_at', 'contactNumber', 'contactEmail', 'referenceNumber', 'deliveryMode', 'dispatchType', 'employee', 'agent', 'dispatchDetails.land_mark', 'dispatchDetails.documentDetails');
        $data[] = array('Lead List');
        $excel_header = [
            'CID',
            'CUSTOMER NAME',
            'LEAD CREATED DATE',
            'TRANSACTION NUMBER',
            'DISPATCH TYPE',
            'TYPE OF DOCUMENT',
            'TYPE OF DELIVERY',
            'AMOUNT / CARDS',
            'CUSTOMER CONTACT NUMBER',
            'CUSTOMER EMAIL ID',
            'RECIPIENT NAME',
            'AGENT NAME',
            'DELIVERY MODE',
            'ASSIGNED TO',
            'LAND MARK',
            'DOCUMENT DESCRIPTION'
        ];
        $file_name_ = 'Lead List' . rand();
        Excel::create($file_name_, function ($excel) use ($leadDetails, $excel_header) {
            $excel->sheet('Lead list', function ($sheet) use ($leadDetails, $excel_header) {
                $sheet->appendRow($excel_header);
                $sheet->row(1, function ($row) {
                    $row->setFontSize(10);
                    $row->setFontColor('#ffffff');
                    $row->setBackground('#1155CC');
                });
                $leadDetails->chunk(100, function ($final_leads) use ($sheet) {
                    foreach ($final_leads as $leads) {
                        $createdDate = $leads->created_at;
                        $date = date("d/m/Y", strtotime($createdDate));
                        if (isset($leads->employee['name'])) {
                            $assignname = ucwords(strtolower($leads->employee['name']));
                            if (isset($leads->employee['empId'])) {
                                if ($leads->employee['empId'] != "") {
                                    $assignid = $leads->employee['empId'];
                                    $assignvalue = $assignname . ' (' . $assignid . ')';
                                } else {
                                    $assignvalue = $assignname;
                                }
                            } else {
                                $assignvalue = $assignname;
                            }
                        } else {
                            $assignvalue = '--';
                        }
                        if (isset($leads->agent['name'])) {
                            $agentname = ucwords(strtolower($leads->agent['name']));
                            if (isset($leads->agent['empid'])) {
                                if ($leads->agent['empid'] != "") {
                                    $agentid = $leads->agent['empid'];
                                    $agentvalue = ucwords(strtolower($agentname)) . ' (' . $agentid . ')';
                                } else {
                                    $agentvalue = ucwords(strtolower($agentname));
                                }
                            } else {
                                $agentvalue = ucwords(strtolower($agentname));
                            }
                        } else {
                            $agentvalue = 'NA';
                        }
                        if (isset($leads['dispatchType.dispatchType'])) {
                            $disType = $leads['dispatchType.dispatchType'];
                        } else {
                            $disType = '--';
                        }
                        if (isset($leads['deliveryMode.deliveryMode'])) {
                            $disMode = $leads['deliveryMode.deliveryMode'];
                        } else {
                            $disMode = '--';
                        }
                        if (isset($leads['customer.customerCode'])) {
                            $custCode = $leads['customer.customerCode'];
                        } else {
                            $custCode = '--';
                        }
                        if (isset($leads['customer.name'])) {
                            $custName = $leads['customer.name'];
                        } else {
                            $custName = '--';
                        }
                        if (isset($leads['customer.recipientName'])) {
                            $recName = $leads['customer.recipientName'];
                        } else {
                            $recName = '--';
                        }
                        if (isset($leads['dispatchDetails.land_mark'])) {
                            $land = $leads['dispatchDetails.land_mark'];
                        } else {
                            $land = '--';
                        }
                        if (isset($leads['dispatchDetails']['documentDetails'])) {
                            $leadDocuments = $leads['dispatchDetails']['documentDetails'];
                            foreach ($leadDocuments as $count => $reply) {
                                if ($reply['DocumentCurrentStatus'] == '1' || $reply['DocumentCurrentStatus'] == '10') {
                                    $data = array(
                                        $custCode ?: '--',
                                        ucwords(strtolower($custName)),
                                        $date,
                                        $leads['referenceNumber'],
                                        $disType,
                                        $reply['documentName'],
                                        $disMode,
                                        $reply['amount'] ?: '--',
                                        $leads['contactNumber'] ?: '--',
                                        $leads['contactEmail'] ?: '--',
                                        ucwords(strtolower($recName)),
                                        $agentvalue,
                                        $disMode,
                                        $assignvalue,
                                        $land ?: '--',
                                        $reply['documentDescription'] ?: '--'
                                    );
                                    $sheet->appendRow($data);
                                }
                            }
                        } else {
                            $data = array(
                                $custCode,
                                ucwords(strtolower($custName)),
                                $date,
                                $leads['referenceNumber'],
                                $disType,
                                '--',
                                $disMode,
                                '--',
                                $leads['contactNumber'] ?: '--',
                                $leads['contactEmail'] ?: '--',
                                ucwords(strtolower($recName)),
                                $agentvalue,
                                $disMode,
                                $assignvalue,
                                $land ?: '--',
                                '--'
                            );
                            $sheet->appendRow($data);
                        }
                        //
                    }
                });
            });
        })->store('xls', public_path('excel'));
        $excel_name = $file_name_ . '.' . 'xls';
        $send_excel = public_path('/excel/' . $excel_name);
        //		dd($send_excel);
        $tab_value = 'lead';
        sendExcel::dispatch($email, $send_excel, $tab_value);
        //		Session::flash('status', 'Excel send to '. $email );
        return 'success';
    }

    /**
     * view receptionist list page
     */
    public function receptionistList(Request $request)
    {
        $leadId = session()->get('leadId');
        if (!empty($request->input('agent'))) {
            $count = 0;
            foreach ($request->input('agent') as $cust) {
                $objectArray[$count] = new ObjectId($cust);
                $count++;
            }
            $agents = User::where('isActive', 1)->where(function ($q) {
                $q->where('role', 'EM')->orWhere('role', 'AG');
            })->whereIn('_id', $objectArray)->get();
        } else {
            $agents = '';
        }

        if (!empty($request->input('assigned'))) {
            $count = 0;
            foreach ($request->input('assigned') as $cust) {
                $objectArray[$count] = new ObjectId($cust);
                $count++;
            }
            $assigned_to = User::where('isActive', 1)->where(function ($q) {
                $q->where('role', 'EM')->orWhere('role', 'AG')->orWhere('role', 'CR')->orWhere('role', 'MS')->orWhere('role', 'AD')->orWhere('role', 'CO')->orWhere('role', 'SV');
            })->whereIn('_id', $objectArray)->get();
        } else {
            $assigned_to = '';
        }

        if (!empty($request->input('customer'))) {
            $count = 0;
            foreach ($request->input('customer') as $cust) {
                $objectArray[$count] = new ObjectId($cust);
                $count++;
            }
            $customers = Customer::whereIn('_id', $objectArray)->get();
            $recepients = RecipientDetails::whereIn('_id', $objectArray)->get();
            $customers = $customers->merge($recepients);
        } else {
            $customers = '';
        }
        //\		$customer_code = [];
        //		foreach ($customers as $customer) {
        //			$customer_code[] = $customer->customerCode;
        //		}
        //        $recipientsDetails = RecipientDetails::where('status', 0)->get();
        if (!empty($request->input('case_manager'))) {
            $count = 0;
            foreach ($request->input('case_manager') as $cust) {
                $objectArray[$count] = new ObjectId($cust);
                $count++;
            }
            $case_managers = User::where('isActive', 1)->where(function ($q) {
                $q->where('role', 'EM')->orWhere('role', 'AD')->orWhere('role', 'RP')->orWhere('role', 'AG')->orWhere('role', 'CO')->orWhere('role', 'SV');
            })->whereIn('_id', $objectArray)->get();
        } else {
            $case_managers = '';
        }

        if (!empty($request->input('dispatch'))) {
            $count = 0;
            foreach ($request->input('dispatch') as $cust) {
                $objectArray[$count] = new ObjectId($cust);
                $count++;
            }
            if (
                session('role') == 'Insurer' || session('role') == 'Employee' || session('role') == 'Supervisor' || session('role') == 'Agent' ||
                session('role') == 'Coordinator' || session('role') == 'Courier' || session('role') == 'Messenger' || session('role') == 'Accountant'
            ) {
                $dispatch_type_check = DispatchTypes::where('type', '!=', 'Direct Collections')->whereIn('_id', $objectArray)->get();
            } else {
                $dispatch_type_check = DispatchTypes::whereIn('_id', $objectArray)->get();
            }
        } else {
            $dispatch_type_check = '';
        }
        if (!empty($request->input('delivery'))) {
            $count = 0;
            foreach ($request->input('delivery') as $cust) {
                $objectArray[$count] = new ObjectId($cust);
                $count++;
            }
            $delivery_mode_check = DeliveryMode::whereIn('_id', $objectArray)->get();
        } else {
            $delivery_mode_check = '';
        }
        $delivery_mode = DeliveryMode::all();
        if (
            session('role') == 'Insurer' || session('role') == 'Employee' || session('role') == 'Agent' || session('role') == 'Coordinator' ||
            session('role') == 'Supervisor' || session('role') == 'Courier' || session('role') == 'Messenger' || session('role') == 'Accountant'
        ) {
            $dispatch_types = DispatchTypes::where('type', '!=', 'Direct Collections')->get();
        } else {
            $dispatch_types = DispatchTypes::all();
        }
        $document_types = DocumentType::all();
        $filter_data = $request->input();
        $current_path = $request->path();
        if (!empty($request->input('status'))) {
            $count = 0;
            foreach ($request->input('status') as $cust) {
                $objectArray[$count] = $cust;
                $count++;
            }
            $Allstatus = DispatchStatus::whereIn('status', $objectArray)->groupBy('status')->get();
        } else {
            $Allstatus = '';
        }
        if (session()->has('leadId')) {
            return view('dispatch.newreceptionist')
                ->with(compact(
                    'customers',
                    'agents',
                    'case_managers',
                    'delivery_mode',
                    'dispatch_types',
                    'assigned_to',
                    'delivery_mode_check',
                    'dispatch_type_check',
                    'filter_data',
                    'document_types',
                    'leadId',
                    'current_path',
                    'Allstatus'
                ));
        } else {
            return view('dispatch.receptionist_list')
                ->with(compact(
                    'customers',
                    'agents',
                    'case_managers',
                    'delivery_mode',
                    'dispatch_types',
                    'assigned_to',
                    'delivery_mode_check',
                    'dispatch_type_check',
                    'filter_data',
                    'document_types',
                    'leadId',
                    'current_path',
                    'Allstatus'
                ));
        }
    }

    /**
     * view data table for receptionist list page
     */
    public function receptionistData(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $filter = $request->input('search');
        $filter_data_en = $request->get('filterData');
        $filter_data = json_decode($filter_data_en);
        $sort = $request->get('field');
        $search = (isset($filter['value'])) ? $filter['value'] : false;
        session()->put('filter', $filter_data_en);
        session()->put('sort', $sort);
        //		$LeadDetails = LeadDetails::where('active', 1)->whereIn('dispatchStatus',array('Reception','Delivered','Collected','reschedule_another','not_contact','delivered_and_collected',
        //			'delivered_not_collected','collected_not_delivered','neither_collected_nor_delivered','Partial','Incomplete','Update Again'))->where('transferTo.status','!=','Transferred')->whereNull('finalStatus');

        $LeadDetails = LeadDetails::where('active', 1)->where('receptionTabStatus', (int) 1);

        if (session('role') == 'Employee') {
            $LeadDetails = $LeadDetails->where(function ($q) {
                $q->where('caseManager.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('agent.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('employee.id', new ObjectID(Auth::user()->_id));
            });
        } elseif (session('role') == 'Agent') {
            $LeadDetails = $LeadDetails->where(function ($q) {
                $q->where('agent.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('caseManager.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('employee.id', new ObjectID(Auth::user()->_id));
            });
        } elseif (session('role') == 'Coordinator') {
            $LeadDetails = $LeadDetails->where(function ($q) {
                $q->where('agent.id', session('assigned_agent'))
                    ->orwhere('agent.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('employee.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('employee.id', session('assigned_agent'));
            });
        } elseif (session('role') == 'Supervisor') {
            $LeadDetails = $LeadDetails->where(function ($q) {
                $q->where('agent.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('caseManager.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('employee.id', new ObjectID(Auth::user()->_id))
                    ->orwhereIn('employee.id', session('employees'));
            });
        } elseif (session('role') != 'Admin' && session('role') != 'Receptionist') {
            $LeadDetails = $LeadDetails->where('employee.id', new ObjectID(Auth::user()->_id));
        }

        if (!empty($filter_data)) {
            if (!empty($filter_data->agent)) {
                $count = 0;
                foreach ($filter_data->agent as $agent) {
                    $objectArray[$count] = new ObjectId($agent);
                    $count++;
                }
                $LeadDetails = $LeadDetails->whereIn('agent.id', $objectArray);
            }
            if (!empty($filter_data->case_manager)) {
                $count = 0;
                foreach ($filter_data->case_manager as $manager) {
                    $objectArray[$count] = new ObjectId($manager);
                    $count++;
                }
                $LeadDetails = $LeadDetails->whereIn('caseManager.id', $objectArray);
            }
            if (!empty($filter_data->customer)) {
                $count = 0;
                foreach ($filter_data->customer as $cust) {
                    $objectArray[$count] = new ObjectId($cust);
                    $count++;
                }
                $LeadDetails = $LeadDetails->whereIn('customer.id', $objectArray);
            }
            if (!empty($filter_data->delivery)) {
                $count = 0;
                foreach ($filter_data->delivery as $mode) {
                    $objectArray[$count] = new ObjectId($mode);
                    $count++;
                }
                $LeadDetails = $LeadDetails->whereIn('deliveryMode.id', $objectArray);
            }
            if (!empty($filter_data->dispatch)) {
                $count = 0;
                foreach ($filter_data->dispatch as $type) {
                    $objectArray[$count] = new ObjectId($type);
                    $count++;
                }
                $LeadDetails = $LeadDetails->whereIn('dispatchType.id', $objectArray);
            }
            if (!empty($filter_data->assigned)) {
                $count = 0;
                foreach ($filter_data->assigned as $type) {
                    $objectArray[$count] = new ObjectId($type);
                    $count++;
                }
                $LeadDetails = $LeadDetails->whereIn('employee.id', $objectArray);
            }
            if (!empty($filter_data->status)) {
                $count = 0;
                foreach ($filter_data->status as $stat) {
                    $objectArray[$count] = $stat;
                    $count++;
                }
                $LeadDetails = $LeadDetails->whereIn('dispatchStatus', $objectArray);
            }
        }

        if (!empty($sort)) {
            if ($sort == "Customer Name") {
                $LeadDetails = $LeadDetails->orderBy(trim('customer.name'));
            } elseif ($sort == "Agent") {
                $LeadDetails = $LeadDetails->orderBy('agent.name');
            } elseif ($sort == "Case Manager") {
                $LeadDetails = $LeadDetails->orderBy('caseManager.name');
            } elseif ($sort == "Dispatch Type") {
                $LeadDetails = $LeadDetails->orderBy('dispatchType.dispatchType');
            } elseif ($sort == "Delivery Mode") {
                $LeadDetails = $LeadDetails->orderBy('deliveryMode.deliveryMode');
            }
        } elseif (empty($sort)) {
            $LeadDetails = $LeadDetails->orderBy(
                'created_at',
                'DESC'
            );
        }
        if ($search) {
            $LeadDetails = $LeadDetails->where(function ($query) use ($search) {
                $query->Where('referenceNumber', 'like', '%' . $search . '%')
                    ->orWhere('customer.name', 'like', '%' . $search . '%')
                    ->orWhere('customer.recipientName', 'like', '%' . $search . '%')
                    ->orWhere('customer.customerCode', 'like', '%' . $search . '%')
                    ->orWhere('agent.name', 'like', '%' . $search . '%')
                    ->orWhere('caseManager.name', 'like', '%' . $search . '%')
                    ->orWhere('contactNumber', 'like', '%' . $search . '%')
                    //					->orWhere('contactEmail', 'like', '%' . $search . '%')
                    ->orWhere('deliveryMode.deliveryMode', 'like', '%' . $search . '%')
                    ->orWhere('dispatchType.dispatchType', 'like', '%' . $search . '%')
                    ->orWhere('dispatchStatus', 'like', '%' . $search . '%');
            });


            session()->put('search', $search);
        }
        if ($search == "") {
            $LeadDetails = $LeadDetails;
            session()->put('search', "");
        }

        $searchField = $request->get('searchField');
        if ($searchField != "") {
            $LeadDetails = $LeadDetails->where(function ($query) use ($searchField) {
                $query->Where('referenceNumber', 'like', '%' . $searchField . '%')
                    ->orWhere('customer.name', 'like', '%' . $searchField . '%')
                    ->orWhere('customer.recipientName', 'like', '%' . $searchField . '%')
                    ->orWhere('customer.customerCode', 'like', '%' . $searchField . '%')
                    ->orWhere('agent.name', 'like', '%' . $searchField . '%')
                    ->orWhere('caseManager.name', 'like', '%' . $searchField . '%')
                    ->orWhere('contactNumber', 'like', '%' . $searchField . '%')
                    ->orWhere('contactEmail', 'like', '%' . $searchField . '%')
                    ->orWhere('deliveryMode.deliveryMode', 'like', '%' . $searchField . '%')
                    ->orWhere('dispatchType.dispatchType', 'like', '%' . $searchField . '%')
                    ->orWhere('dispatchStatus', 'like', '%' . $searchField . '%');
            });
        }
        $total_leads = $LeadDetails->count(); // get your total no of data;
        $members_query = $LeadDetails;
        $search_count = $members_query->count();
        $LeadDetails->skip((int) $start)->take((int) $length);
        $final_leads = $LeadDetails->get();

        foreach ($final_leads as $leads) {
            $check = '<div class="custom_checkbox">' .
                '<input type="checkbox" name="marked_list[]" class="inp-cbx check" id="' . $leads->_id . '" style="display: none"  onchange="markedCheck(this.id)">' .
                '<label for="' . $leads->_id . '" class="cbx">' .
                '<span>' .
                '    <svg width="10px" height="8px" viewBox="0 0 12 10">' .
                '      <polyline points="1.5 6 4.5 9 10.5 1"></polyline>' .
                '    </svg>' .
                '</span>' .
                '<span></span>' .
                '</label>' .
                '</div>';

            if ($leads['referenceNumber'] == '') {
                $referenceNumber = '--';
            } else {
                $referenceNumber = '<a href="#" class="auto_modal table_link" data-toggle="tooltip" data-placement="bottom" title="View Dispatch Slip" data-container="body"  data-modal="view_lead_popup" dir="' . $leads->_id . '" onclick="view_lead_popup(\'' . $leads->_id . '\');">

' . $leads['referenceNumber'] . '  </a> ';
            }
            if (isset($leads->schedulerejectstatus)) {
                $referenceNumber = $referenceNumber . '<i style="color: #f00; font-size: 14px;" class="fas fa-ban"  data-toggle="tooltip" title="' . $leads->schedulerejectstatus . '"  aria-hidden="true"></i> </a>';
            }
            if (isset($leads->agent['name'])) {
                $agentname = ucwords(strtolower($leads->agent['name']));
                if (isset($leads->agent['empid'])) {
                    if ($leads->agent['empid'] != "") {
                        $agentid = $leads->agent['empid'];
                        $agentvalue = $agentname . ' (' . $agentid . ')';
                    } else {
                        $agentvalue = $agentname;
                    }
                } else {
                    $agentvalue = $agentname;
                }
            } else {
                $agentvalue = 'NA';
            }

            $agent = $agentvalue;
            $caseManager = ucwords(strtolower($leads['caseManager.name']));
            $email = $leads->contactEmail;
            $contact = $leads->contactNumber;
            $dispatchStatus = $leads->dispatchStatus;
            $recipientName = ucwords(strtolower($leads['customer.recipientName']));
            $dispatchType = $leads['dispatchType.dispatchType'];
            $deliveryMode = $leads['deliveryMode.deliveryMode'] ?: '--';
            $code = $leads['customer.customerCode'] ?: '--';
            $customerName = ucwords(strtolower($leads['customer.name']));
            $created_at = $leads->created_at;
            if (isset($leads->employee['name'])) {
                $assignname = ucwords(strtolower($leads->employee['name']));
                if (isset($leads->employee['empId'])) {
                    if ($leads->employee['empId'] != "") {
                        $assignid = $leads->employee['empId'];
                        $assignvalue = $assignname . ' (' . $assignid . ')';
                    } else {
                        $assignvalue = $assignname;
                    }
                } else {
                    $assignvalue = $assignname;
                }
            } else {
                $assignvalue = '--';
            }
            if ($leads['dispatchStatus'] == '') {
                $status = '--';
            } else {
                $status = '<a href="#">

<span data-toggle="tooltip" data-placement="bottom" title="Assigned to : ' . $assignvalue . '"  data-container="body" > ' . $leads['dispatchStatus'] . ' </span>  ';
            }
            $leads->checkall = $check;
            $leads->customerCode = $code;
            $leads->referenceNumber = $referenceNumber;
            $leads->customerName = $customerName;
            $leads->recipientName = $recipientName;
            $leads->contactNo = $contact;
            $leads->email = $email;
            $leads->status = $dispatchStatus;
            $leads->caseManager = $caseManager;
            $leads->agent = $agent;
            $leads->dispatchType = $dispatchType;
            $leads->deliveryMode = $deliveryMode;
            $leads->status = $status;
            $leads->assigned = $assignvalue;
            $leads->created = Carbon::parse($created_at)->format('d/m/Y');
            if (session('role') == 'Admin') {
                $delete_button = '<button class="btn export_btn waves-effect auto_modal delete_icon_btn" type="button" data-toggle="tooltip" data-placement="bottom" title="Delete" data-container="body"  data-modal="delete_popup" dir="' . $leads->_id . '" onclick="delete_pop(this);">
<i class="material-icons">delete_outline</i>
</button>';
                $leads->delete_button = $delete_button;
            } else {
                $leads->delete_button = "";
            }
        }
        if ($search) {
            $filtered_count = $search_count;
        } else {
            $filtered_count = $total_leads;
        }


        $data = array(
            'draw' => $draw,
            'recordsTotal' => $total_leads,
            'recordsFiltered' => $filtered_count,
            'data' => $final_leads,
        );

        return json_encode($data);
    }

    /**
     * export receptionist details as excel
     */
    public function exportReceptionist(Request $request)
    {
        ini_set('xdebug.max_nesting_level', 500);
        $email = $request->input('send_email_id');
        $filter_data = json_decode(session('filter'));
        $sort = session('sort');
        $search = session('search');
        $leadDetails = LeadDetails::where('active', (int) 1)->where('receptionTabStatus', (int) 1);
        if (session('role') == 'Employee') {
            $leadDetails = $leadDetails->where(function ($q) {
                $q->where('caseManager.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('agent.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('employee.id', new ObjectID(Auth::user()->_id));
            });
        } elseif (session('role') == 'Coordinator') {
            $leadDetails = $leadDetails->where(function ($q) {
                $q->where('agent.id', session('assigned_agent'))
                    ->orwhere('agent.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('employee.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('employee.id', session('assigned_agent'));
            });
        } elseif (session('role') == 'Agent') {
            $leadDetails = $leadDetails->where(function ($q) {
                $q->where('agent.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('caseManager.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('employee.id', new ObjectID(Auth::user()->_id));
            });
        } elseif (session('role') == 'Supervisor') {
            $leadDetails = $leadDetails->where(function ($q) {
                $q->where('agent.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('caseManager.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('employee.id', new ObjectID(Auth::user()->_id))
                    ->orwhereIn('employee.id', session('employees'));
            });
        } elseif (session('role') != 'Admin' && session('role') != 'Receptionist') {
            $leadDetails = $leadDetails->where('employee.id', new ObjectID(Auth::user()->_id));
        }

        if (!empty($filter_data)) {
            if (!empty($filter_data->agent)) {
                $count = 0;
                foreach ($filter_data->agent as $agent) {
                    $objectArray[$count] = new ObjectId($agent);
                    $count++;
                }
                $leadDetails = $leadDetails->whereIn('agent.id', $objectArray);
            }
            if (!empty($filter_data->case_manager)) {
                $count = 0;
                foreach ($filter_data->case_manager as $manager) {
                    $objectArray[$count] = new ObjectId($manager);
                    $count++;
                }
                $leadDetails = $leadDetails->whereIn('caseManager.id', $objectArray);
            }
            if (!empty($filter_data->customer)) {
                $count = 0;
                foreach ($filter_data->customer as $cust) {
                    $objectArray[$count] = new ObjectId($cust);
                    $count++;
                }
                $leadDetails = $leadDetails->whereIn('customer.id', $objectArray);
            }
            if (!empty($filter_data->delivery)) {
                $count = 0;
                foreach ($filter_data->delivery as $mode) {
                    $objectArray[$count] = new ObjectId($mode);
                    $count++;
                }
                $leadDetails = $leadDetails->whereIn('deliveryMode.id', $objectArray);
            }
            if (!empty($filter_data->dispatch)) {
                $count = 0;
                foreach ($filter_data->dispatch as $type) {
                    $objectArray[$count] = new ObjectId($type);
                    $count++;
                }
                $leadDetails = $leadDetails->whereIn('dispatchType.id', $objectArray);
            }
            if (!empty($filter_data->assigned)) {
                $count = 0;
                foreach ($filter_data->assigned as $type) {
                    $objectArray[$count] = new ObjectId($type);
                    $count++;
                }
                $leadDetails = $leadDetails->whereIn('employee.id', $objectArray);
            }
            if (!empty($filter_data->status)) {
                $count = 0;
                foreach ($filter_data->status as $stat) {
                    $objectArray[$count] = $stat;
                    $count++;
                }
                $leadDetails = $leadDetails->whereIn('dispatchStatus', $objectArray);
            }
        }



        if (!empty($sort)) {
            if ($sort == "Customer Name") {
                $leadDetails = $leadDetails->orderBy('customer.name');
            } elseif ($sort == "Agent") {
                $leadDetails = $leadDetails->orderBy('agent.name');
            } elseif ($sort == "Case Manager") {
                $leadDetails = $leadDetails->orderBy('caseManager.name');
            } elseif ($sort == "Dispatch Type") {
                $leadDetails = $leadDetails->orderBy('dispatchType.dispatchType');
            } elseif ($sort == "Delivery Mode") {
                $leadDetails = $leadDetails->orderBy('deliveryMode.deliveryMode');
            }
        } elseif (empty($sort)) {
            $leadDetails = $leadDetails->orderBy('created_at', 'DESC');
        }
        if ($search) {
            $leadDetails = $leadDetails->where(function ($query) use ($search) {
                $query->Where('referenceNumber', 'like', '%' . $search . '%')
                    ->orWhere('customer.name', 'like', '%' . $search . '%')
                    ->orWhere('customer.recipientName', 'like', '%' . $search . '%')
                    ->orWhere('customer.customerCode', 'like', '%' . $search . '%')
                    ->orWhere('agent.name', 'like', '%' . $search . '%')
                    ->orWhere('caseManager.name', 'like', '%' . $search . '%')
                    ->orWhere('contactNumber', 'like', '%' . $search . '%')
                    ->orWhere('contactEmail', 'like', '%' . $search . '%')
                    ->orWhere('deliveryMode.deliveryMode', 'like', '%' . $search . '%')
                    ->orWhere('dispatchType.dispatchType', 'like', '%' . $search . '%');
            });
            session()->put('search', $search);
        }
        $leadDetails = $leadDetails->select('customer', 'created_at', 'contactNumber', 'contactEmail', 'referenceNumber', 'deliveryMode', 'dispatchType', 'employee', 'agent', 'dispatchDetails.land_mark', 'dispatchDetails.documentDetails');

        //		 $leadDetails->chunk(100, function($LeadData) use (&$final_leads) {
        //			foreach ($LeadData as $total) {
        //				$final_leads[] = $total;
        //				dd($total->toArray());
        //			}
        //		});
        //		echo "<pre>"; print_r($final_leads); die;

        $data[] = array('Receptionist List');
        $excel_header = [
            'CID',
            'CUSTOMER NAME',
            'LEAD CREATED DATE',
            'TRANSACTION NUMBER',
            'DISPATCH TYPE',
            'TYPE OF DOCUMENT',
            'TYPE OF DELIVERY',
            'AMOUNT / CARDS',
            'CUSTOMER CONTACT NUMBER',
            'CUSTOMER EMAIL ID',
            'RECIPIENT NAME',
            'AGENT NAME',
            'DELIVERY MODE',
            'ASSIGNED TO',
            'LAND MARK',
            'DOCUMENT DESCRIPTION'
        ];
        $file_name = 'Reception_List' . (string) time() . rand();
        Excel::create($file_name, function ($excel) use ($leadDetails, $excel_header) {
            $excel->sheet('Reception list', function ($sheet) use ($leadDetails, $excel_header) {
                $sheet->appendRow($excel_header);
                $sheet->row(1, function ($row) {
                    $row->setFontSize(10);
                    $row->setFontColor('#ffffff');
                    $row->setBackground('#1155CC');
                });
                $leadDetails->chunk(100, function ($final_leads) use ($sheet) {
                    foreach ($final_leads as $leads) {
                        $createdDate = $leads->created_at;
                        $date = date("d/m/Y", strtotime($createdDate));
                        if (isset($leads->employee['name'])) {
                            $assignname = ucwords(strtolower($leads->employee['name']));
                            if (isset($leads->employee['empId'])) {
                                if ($leads->employee['empId'] != "") {
                                    $assignid = $leads->employee['empId'];
                                    $assignvalue = $assignname . ' (' . $assignid . ')';
                                } else {
                                    $assignvalue = $assignname;
                                }
                            } else {
                                $assignvalue = $assignname;
                            }
                        } else {
                            $assignvalue = '--';
                        }
                        if (isset($leads->agent['name'])) {
                            $agentname = ucwords(strtolower($leads->agent['name']));
                            if (isset($leads->agent['empid'])) {
                                if ($leads->agent['empid'] != "") {
                                    $agentid = $leads->agent['empid'];
                                    $agentvalue = ucwords(strtolower($agentname)) . ' (' . $agentid . ')';
                                } else {
                                    $agentvalue = ucwords(strtolower($agentname));
                                }
                            } else {
                                $agentvalue = ucwords(strtolower($agentname));
                            }
                        } else {
                            $agentvalue = 'NA';
                        }
                        if (isset($leads->contactNumber)) {
                            $contact = $leads->contactNumber;
                        } else {
                            $contact = '--';
                        }
                        if (isset($leads->contactEmail)) {
                            $contactEmail = $leads->contactEmail;
                        } else {
                            $contactEmail = '--';
                        }
                        if (isset($leads['dispatchType.dispatchType'])) {
                            $disType = $leads['dispatchType.dispatchType'];
                        } else {
                            $disType = '--';
                        }
                        if (isset($leads['deliveryMode.deliveryMode'])) {
                            $disMode = $leads['deliveryMode.deliveryMode'];
                        } else {
                            $disMode = '--';
                        }
                        if (isset($leads['customer.customerCode'])) {
                            $custCode = $leads['customer.customerCode'];
                        } else {
                            $custCode = '--';
                        }
                        if (isset($leads['customer.name'])) {
                            $custName = $leads['customer.name'];
                        } else {
                            $custName = '--';
                        }
                        if (isset($leads['customer.recipientName'])) {
                            $recName = $leads['customer.recipientName'];
                        } else {
                            $recName = '--';
                        }
                        if (isset($leads['dispatchDetails.land_mark'])) {
                            $land = $leads['dispatchDetails.land_mark'];
                        } else {
                            $land = '--';
                        }
                        if (isset($leads['dispatchDetails']['documentDetails'])) {
                            $leadDocuments = $leads['dispatchDetails']['documentDetails'];
                            foreach ($leadDocuments as $count => $reply) {
                                if (($reply['DocumentCurrentStatus'] != '3' &&  $reply['DocumentCurrentStatus'] != '13' && ($reply['DocumentCurrentStatus'] != '7')
                                    && ($reply['DocumentCurrentStatus'] != '16') && $reply['DocumentCurrentStatus'] != '10'
                                    && $reply['DocumentCurrentStatus'] != '11' && $reply['DocumentCurrentStatus'] != '9' && $reply['DocumentCurrentStatus'] != '14')) {
                                    $data = array(
                                        $custCode ?: '--',
                                        ucwords(strtolower($custName)),
                                        $date,
                                        $leads['referenceNumber'],
                                        $disType,
                                        $reply['documentName'],
                                        $disMode,
                                        $reply['amount'] ?: '--',
                                        $contact,
                                        $contactEmail,
                                        ucwords(strtolower($recName)),
                                        $agentvalue,
                                        $disMode,
                                        $assignvalue,
                                        $land ?: '--',
                                        $reply['documentDescription'] ?: '--'
                                    );
                                    $sheet->appendRow($data);
                                }
                            }
                        } else {
                            $data = array(
                                $custCode,
                                ucwords(strtolower($custName)),
                                $date,
                                $leads['referenceNumber'],
                                $disType,
                                '--',
                                $disMode,
                                '--',
                                $contact,
                                $contactEmail,
                                ucwords(strtolower($recName)),
                                $agentvalue,
                                $disMode,
                                $assignvalue,
                                $land ?: '--',
                                '--'
                            );
                            $sheet->appendRow($data);
                        }
                        //
                    }
                });
            });
        })->store('xls', public_path('excel'));
        $excel_name = $file_name . '.' . 'xls';
        $send_excel = public_path('/excel/' . $excel_name);
        $tab_value = 'reception';
        sendExcel::dispatch($email, $send_excel, $tab_value);
        return 'success';
    }

    /**
     * get reception details
     */
    public function getReceptionDetails(Request $request)
    {
        $current_path = $request->input('current_path');
        $emp_option = 'text';
        $leadDetails = LeadDetails::find($request->input('lead_id'));
        $caseManager = (string) $leadDetails->caseManager['id'];

        if (
            session('role') == 'Insurer' || session('role') == 'Employee' || session('role') == 'Agent' || session('role') == 'Coordinator' ||
            session('role') == 'Courier' || session('role') == 'Messenger' || session('role') == 'Accountant' || session('role') == 'Supervisor'
        ) {
            $dispatchTypes = DispatchTypes::where('type', '!=', 'Direct Collections')->orderBy('type')->get();
        } else {
            $dispatchTypes = DispatchTypes::orderBy('type')->get();
        }
        $allMode = DeliveryMode::orderBy('deliveryMode')->get();
        if (isset($leadDetails->saveType)) {
            if ($leadDetails->saveType == 'recipient') {
                $customercode = $leadDetails->customer['id'];
                $customer = RecipientDetails::find($customercode);
            } else {
                $customercode = $leadDetails->customer['id'];
                $customer = Customer::find($customercode);
            }
        }
        if ($customer->addressLine2 != '') {
            $address2 = ',' . $customer->addressLine2;
        } else {
            $address2 = '';
        }
        $cityName = ',' . $customer->cityName;
        $address = $customer->addressLine1 . '' . $address2 . '' . $cityName;
        $landmark = $customer->streetName;
        $documentTypes = DocumentType::all();
        $document = $leadDetails['dispatchDetails']['documentDetails'];
        $docStatus = [];
        $approve_again_button = 0;
        $approve_and_reject_button = 0;
        if ($document) {
            foreach ($document as $doc) {
                $docStatus[] = $doc['DocumentCurrentStatus'];
            }
            if ($leadDetails->dispatchType['dispatchType'] != 'Direct Collections') {
                if (in_array(18, $docStatus) || in_array(12, $docStatus)) {
                    $approve_and_reject_button = 1; //approve and reject button
                } else {
                    $approve_and_reject_button = 0;
                }
                if (in_array(4, $docStatus) || in_array(5, $docStatus)) {
                    $approve_again_button = 1; //approve again (redirect from delivery)
                } else {
                    $approve_again_button = 0;
                }
                $collected_button = 0;
            } elseif ($leadDetails->dispatchType['dispatchType'] == 'Direct Collections') {
                if (in_array(1, $docStatus) || in_array(18, $docStatus)) {
                    $collected_button = 1;  //collected button
                } else {
                    $collected_button = 0;
                }
            } else {
                $approve_again_button = 0;
                $approve_and_reject_button = 0;
                $collected_button = 0;
            }
            if (in_array(2, $docStatus)  || in_array(8, $docStatus) || in_array(17, $docStatus) || in_array(6, $docStatus) || in_array(15, $docStatus)) {
                $transfer_button = 1; //transfer button
            } else {
                $transfer_button = 0;
            }
        } else {
            $approve_again_button = 0;
            $transfer_button = 0;
            $approve_and_reject_button = 0;
            $collected_button = 1;
        }


        if ($leadDetails->dispatchType['dispatchType'] == 'Collections') {
            $DispatchType = DispatchTypes::where('_id', $leadDetails->dispatchType['id'])->get();
        } elseif ($leadDetails->dispatchType['dispatchType'] == 'Delivery') {
            $DispatchType = DispatchTypes::where('_id', $leadDetails->dispatchType['id'])->get();
        } elseif ($leadDetails->dispatchType['dispatchType'] == 'Delivery & Collections') {
            $DispatchType = DispatchTypes::whereNotIn('code', ['DC', 'DI'])->get();
        } else {
            $DispatchType = DispatchTypes::where('_id', $leadDetails->dispatchType['id'])->get();
        }
        $lead = '';
        $doctype[] = "<option value='' disabled>Select Type</option>";
        foreach ($DispatchType as $disType) {
            if ($leadDetails->dispatchType['dispatchType'] == 'Delivery & Collections') {
                $doctype[] = "<option value='$disType->_id'>$disType->type</option>";
            } else {
                $doctype[] = "<option value='$disType->_id' selected>$disType->type</option>";
            }
        }
        if (isset($leadDetails->MapDetails)) {
            $mapData = $leadDetails['MapDetails'];
            $testArray = [];
            foreach ($mapData as $data) {
                $array1 = $data['location']['coordinates'];
                $array2 = array($data['updateBy'], $data['deliveryTime'], $data['deliveryDate']);
                $testArray[] = array_merge($array1, $array2);
            }
            $mapSection = view('dispatch.includes_pages.map_lead', [
                'testArray' => $testArray
            ])->render();
        } else {
            $mapSection = '';
            $testArray = [];
        }
        if ($document) {
            $documentSection = view('dispatch.includes_pages.documents_section', [
                'document' => $document,
                'current_path' => $current_path,
                'documentTypes' => $documentTypes,
                'save_status' => $lead,
                'doctype' => $doctype,
                'dispatchTypes' => $dispatchTypes,
                'DispatchType' => $DispatchType,
                'leadDetails' => $leadDetails
            ])->render();
        } else {
            $documentSection = view('dispatch.includes_pages.documents_section', [
                'document' => $document,
                'current_path' => $current_path,
                'documentTypes' => $documentTypes,
                'save_status' => $lead,
                'doctype' => $doctype,
                'dispatchTypes' => $dispatchTypes,
                'DispatchType' => $DispatchType,
                'leadDetails' => $leadDetails
            ])->render();
        }
        if ($leadDetails->finalStatus) { //last stage
            $finalStatus = true;
        } else {
            $finalStatus = false;
        }
        if (($current_path != 'dispatch/delivery') && $current_path != 'dispatch/complete-list' && $current_path != 'dispatch/schedule-delivery' && $current_path != 'dispatch/employee-view-list') {
            $emp_option = 'select';
            if ($leadDetails->deliveryMode['deliveryMode'] == 'Agent') {
                $employees = User::where('isActive', 1)->where('role', 'AG')->orderBy('name')->get();
                $emp_select[] = "<option value=''>Select Agent</option>";
                foreach ($employees as $employee) {
                    if ($employee->_id == @$leadDetails->employee['id']) {
                        if ($employee->empID != '') {
                            $id = ' (' . $employee->empID . ')';
                        } else {
                            $id = '';
                        }
                        $emp_select[] = "<option value='$employee->_id' selected>$employee->name $id</option>";
                    } else {
                        if ($employee->empID != '') {
                            $id = ' (' . $employee->empID . ')';
                        } else {
                            $id = '';
                        }
                        $emp_select[] = "<option value='$employee->_id'>$employee->name $id</option>";
                    }
                }
            } elseif ($leadDetails->deliveryMode['deliveryMode'] == 'Admin') {
                $employees = User::where('isActive', 1)->where('role', 'AD')->orderBy('name')->get();
                $emp_select[] = "<option value=''>Select Admin</option>";
                foreach ($employees as $employee) {
                    if ($employee->_id == @$leadDetails->employee['id']) {
                        if ($employee->empID != '') {
                            $id = ' (' . $employee->empID . ')';
                        } else {
                            $id = '';
                        }
                        $emp_select[] = "<option value='$employee->_id' selected>$employee->name $id</option>";
                    } else {
                        if ($employee->empID != '') {
                            $id = ' (' . $employee->empID . ')';
                        } else {
                            $id = '';
                        }
                        $emp_select[] = "<option value='$employee->_id'>$employee->name $id</option>";
                    }
                }
            } elseif ($leadDetails->deliveryMode['deliveryMode'] == 'Coordinator') {
                $employees = User::where('isActive', 1)->where('role', 'CO')->orderBy('name')->get();
                $emp_select[] = "<option value=''>Select Coordinator</option>";
                foreach ($employees as $employee) {
                    if ($employee->_id == @$leadDetails->employee['id']) {
                        if ($employee->empID != '') {
                            $id = ' (' . $employee->empID . ')';
                        } else {
                            $id = '';
                        }
                        $emp_select[] = "<option value='$employee->_id' selected>$employee->name $id</option>";
                    } else {
                        if ($employee->empID != '') {
                            $id = ' (' . $employee->empID . ')';
                        } else {
                            $id = '';
                        }
                        $emp_select[] = "<option value='$employee->_id'>$employee->name $id</option>";
                    }
                }
            } elseif ($leadDetails->deliveryMode['deliveryMode'] == 'Supervisor') {
                $employees = User::where('isActive', 1)->where('role', 'SV')->orderBy('name')->get();
                $emp_select[] = "<option value=''>Select Supervisor</option>";
                foreach ($employees as $employee) {
                    if ($employee->_id == @$leadDetails->employee['id']) {
                        if ($employee->empID != '') {
                            $id = ' (' . $employee->empID . ')';
                        } else {
                            $id = '';
                        }
                        $emp_select[] = "<option value='$employee->_id' selected>$employee->name $id</option>";
                    } else {
                        if ($employee->empID != '') {
                            $id = ' (' . $employee->empID . ')';
                        } else {
                            $id = '';
                        }
                        $emp_select[] = "<option value='$employee->_id'>$employee->name $id</option>";
                    }
                }
            } elseif ($leadDetails->deliveryMode['deliveryMode'] == 'Courier') {
                $employees = User::where('isActive', 1)->where('role', 'CR')->orderBy('name')->get();
                $emp_select[] = "<option value=''>Select Courier</option>";
                foreach ($employees as $employee) {
                    if ($employee->_id == @$leadDetails->employee['id']) {
                        if ($employee->empID != '') {
                            $id = ' (' . $employee->empID . ')';
                        } else {
                            $id = '';
                        }
                        $emp_select[] = "<option value='$employee->_id' selected>$employee->name $id</option>";
                    } else {
                        if ($employee->empID != '') {
                            $id = ' (' . $employee->empID . ')';
                        } else {
                            $id = '';
                        }
                        $emp_select[] = "<option value='$employee->_id'>$employee->name $id</option>";
                    }
                }
            } else {
                $employees = User::where('isActive', 1)->where(function ($q) {
                    $q->where('role', 'EM')->orwhere('role', 'MS');
                })->orderBy('name')->get();
                $emp_select[] = "<option value=''>Select Employee</option>";
                foreach ($employees as $employee) {
                    if ($employee->_id == @$leadDetails->employee['id']) {
                        if ($employee->empID != '') {
                            $id = ' (' . $employee->empID . ')';
                        } else {
                            $id = '';
                        }
                        $emp_select[] = "<option value='$employee->_id' selected>$employee->name $id</option>";
                    } else {
                        if ($employee->empID != '') {
                            $id = ' (' . $employee->empID . ')';
                        } else {
                            $id = '';
                        }
                        $emp_select[] = "<option value='$employee->_id'>$employee->name $id</option>";
                    }
                }
            }
            $emp_name = $emp_select;
            foreach ($allMode as $single) {
                if ($leadDetails['deliveryMode']['id'] == $single->_id) {
                    $response[] = "<option value='$single->id' selected>$single->deliveryMode</option>";
                } else {
                    $response[] = "<option value='$single->id'>$single->deliveryMode</option>";
                }
            }
            $string_version = implode(',', $response);

            foreach ($dispatchTypes as $type) {
                if ($leadDetails['dispatchType']['id'] == $type->_id) {
                    $response1[] = "<option value='$type->id' selected>$type->type</option>";
                } else {
                    $response1[] = "<option value='$type->id'>$type->type</option>";
                }
            }
            $dis_type = implode(',', $response1);
        } else {
            if (isset($leadDetails['employee']['name'])) {
                $emp_value = $leadDetails['employee']['name'];
                $emp_id = $leadDetails['employee']['empId'];
                if ($emp_id) {
                    $emp_name = $emp_value . ' (' . $emp_id . ')';
                } else {
                    $emp_name = $emp_value;
                }
            } else {
                $emp_name = '--';
            }
            $dis_type = $leadDetails['dispatchType']['dispatchType'];
            $string_version = $leadDetails['deliveryMode']['deliveryMode'];
        }

        $emp = User::where('isActive', 1)->where('role', 'EM')->get();
        $transfer[] = "<option value=''>Select Employee</option>";
        foreach ($emp as $employee) {
            $transfer[] = "<option value='$employee->_id'>$employee->name</option>";
        }

        if (Auth::user()->_id == $leadDetails->createdBy[0]['id']) {
            $receptionist = true;
        } else {
            $receptionist = false;
        }

        if ((Auth::user()->_id == $leadDetails->employee['id'])  || ($leadDetails->employee['id'] == session('assigned_agent'))
            || (session('role') == 'Supervisor' && in_array($leadDetails->employee['id'], session('employees')))
        ) {
            $assign_to = true;
        } else {
            $assign_to = false;
        }
        if (isset($leadDetails['agent']['name'])) {
            $ag_value = $leadDetails['agent']['name'];
            if (isset($leadDetails['agent']['empid'])) {
                if ($leadDetails['agent']['empid'] != "") {
                    $ag_id = $leadDetails['agent']['empid'];
                    $ag_name = $ag_value . ' (' . $ag_id . ')';
                } else {
                    $ag_name = $ag_value?:'NA';
                }
            } else {
                $ag_name = $ag_value?:'NA';
            }
        } else {
            $ag_name = 'NA';
        }
        $employee_id = new ObjectId(session('employee_id'));
        if ($employee_id != '') {
            $user = User::find($employee_id);
            if (isset($user->role) && $user->role == 'SV') {
                $employees = $user->employees;
                if (isset($employees) && !empty($employees)) {
                    $empids = $this->stringCollectEmployees($employees);
                    $empids = array_values(array_unique($empids));
                    $employee_id1 = $empids ?: [];
                    array_push($employee_id1, (string) $user->_id);
                    session(['employees_supervisor' => $employee_id1]);
                } else {
                    session(['employees_supervisor' => [(string) $user->_id]]);
                }
                if (session('employees_supervisor')) {
                    $employeeRoleId = session('employees_supervisor');
                } else {
                    $employeeRoleId = [];
                }
            } elseif (isset($user->role) && $user->role == 'CO') {
                $employees = $user->assigned_agent;
                $employee_id1 = [];
                // foreach ($employees as $emp) {
                $employee_id1[] = (string) $employees['id'];
                // }
                $employee_id1[] = (string) $user->_id;
                session(['employees_supervisor' => $employee_id1]);
                if (session('employees_supervisor')) {
                    $employeeRoleId = session('employees_supervisor');
                } else {
                    $employeeRoleId = [];
                }
            } else {
                $employeeRoleId = [];
            }
        } else {
            $employeeRoleId = [];
        }

        $collected_status = 0;
        $not_collected_status = 0;
        if (isset($leadDetails->transferTo)) {
            $transferto = $leadDetails->transferTo;
            foreach ($transferto as $key => $value) {
                if (($value['status'] == 'Collected' && (string) $value['id'] == (string) session('employee_id')) ||
                    $value['status'] == 'Collected' && in_array((string) $value['id'], $employeeRoleId)
                ) {
                    $collected_status = 1;
                    break;
                }
            }
        }
        if (isset($leadDetails->transferTo)) {
            $transferto = $leadDetails->transferTo;
            foreach ($transferto as $key => $value) {
                if (($value['status'] == 'Transferred' && (string) $value['id'] == (string) session('employee_id')) ||
                    $value['status'] == 'Transferred' && in_array((string) $value['id'], $employeeRoleId)
                ) {
                    $not_collected_status = 1;
                    break;
                }
            }
        }
        $docStatus = '';
        if ($document) {
            foreach ($document as $doc) {
                if (isset($doc['signUpload'])) {
                    $docStatus = $doc['signUpload'];
                    break;
                }
            }
        }

        $upload_num = 0;
        $uploadSign = '';
        if ($docStatus == '') {
            if (isset($leadDetails->deliveryStatus)) {
                foreach ($leadDetails->deliveryStatus as $status) {
                    if ((isset($status['upload_sign'])     && $status['upload_sign'] != ""   && !isset($status['status']))
                        || (isset($status['upload_sign'])     && $status['upload_sign'] != ""   && isset($status['status']) && $status['status'] == "Delivered")
                    ) {
                        $upload_num++;
                    }
                }
                if ($upload_num > 0) {
                    $uploadSign = view('dispatch.includes_pages.upload_sign', [
                        'deliveryStatus' => $leadDetails->deliveryStatus
                    ])->render();
                }
            }
        }

        return response()->json([
            'transfer' => $transfer,
            'emp_option' => $emp_option,
            'emp_name' => $emp_name,
            'ag_name' => $ag_name,
            'success' => true,
            'leadDetails' => $leadDetails,
            'documentSection' => $documentSection,
            'finalStatus' => $finalStatus,
            'string_version' => $string_version,
            'dis_type' => $dis_type,
            'address' => $address,
            'landmark' => $landmark,
            'doctype' => $doctype,
            'document' => $document,
            'approve_again_button' => $approve_again_button,
            'transfer_button' => $transfer_button,
            'approve_and_reject_button' => $approve_and_reject_button,
            'receptionist' => $receptionist,
            'assign_to' => $assign_to,
            'collected_button' => $collected_button,
            'caseManager' => $caseManager,
            'collected_status' => $collected_status,
            'not_collected_status' => $not_collected_status,
            'mapSection' => $mapSection,
            'testArray' => $testArray,
            'uploadSign' => $uploadSign,
            'employeeRoleId' => $employeeRoleId
        ]);
    }

    /**
     * function for set dispatch status
     */
    public static function setDispatchStatus($id)
    {
        $statusArray1 = [];
        $leadDetails = LeadDetails::find($id);
        if ($leadDetails->dispatchType['dispatchType'] == 'Direct Collections') {
            $statusName = 'Collected';
        } elseif ($leadDetails->dispatchType['dispatchType'] == 'Delivery') {
            $statusName = 'Delivered';
        } elseif ($leadDetails->dispatchType['dispatchType'] == 'Collections') {
            $statusName = 'Collected';
        } elseif ($leadDetails->dispatchType['dispatchType'] == 'Delivery & Collections') {
            $statusName = 'Delivery and collection';
        }

        $lead = $leadDetails['dispatchDetails']['documentDetails'];
        if ($lead) {
            foreach ($lead as $key => $value) {
                $statusArray1[] = $value['DocumentCurrentStatus'];
            }
            $statusArray = array_unique($statusArray1);
            if (count(array_unique($statusArray)) === 1 && end($statusArray) === '1') {
                $dispatchStatus = 'Lead';
            } elseif (count(array_unique($statusArray)) === 1 && end($statusArray) === '10') {
                $dispatchStatus = 'Rejected From reception';
            } elseif (count(array_unique($statusArray)) === 1 && end($statusArray) === '2') {
                $dispatchStatus = $statusName;
            } elseif (count(array_unique($statusArray)) === 1 && end($statusArray) === '3') {
                $dispatchStatus = 'Reschedule for same day';
            } elseif (count(array_unique($statusArray)) === 1 && end($statusArray) === '4') {
                $dispatchStatus = 'Reschedule for another day';
            } elseif (count(array_unique($statusArray)) === 1 && end($statusArray) === '5') {
                $dispatchStatus = 'Could not contact';
            } elseif ((count(array_unique($statusArray)) === 1 && end($statusArray) === '6' || count(array_unique($statusArray)) === 1 && end($statusArray) === '15') || ((in_array('6', $statusArray) && in_array('15', $statusArray)) && (count(array_unique($statusArray))) <= 2)
            ) {
                $dispatchStatus = 'Transfer Accepted';
            } elseif (count(array_unique($statusArray)) === 1 && end($statusArray) === '8') {
                $dispatchStatus = 'Canceled';
            } elseif (count(array_unique($statusArray)) === 1 && end($statusArray) === '11') {
                $dispatchStatus = 'Delivery';
            } elseif (count(array_unique($statusArray)) === 1 && end($statusArray) === '17') {
                $dispatchStatus = 'Transfer Rejected';
            } elseif (count(array_unique($statusArray)) === 1 && end($statusArray) === '12') {
                $dispatchStatus = 'Reception(Rejected from schedule for delivery )';
            } elseif (count(array_unique($statusArray)) === 1 && end($statusArray) === '13') {
                $dispatchStatus = 'Schedule for delivery';
            } elseif ((count(array_unique($statusArray)) === 1 && end($statusArray) === '9' || count(array_unique($statusArray)) === 1 && end($statusArray) === '14') || ((in_array('9', $statusArray) && in_array('14', $statusArray)) && (count(array_unique($statusArray))) <= 2)
            ) {
                $dispatchStatus = 'Transferred';
            } elseif ((count(array_unique($statusArray)) === 1 && end($statusArray) === '7' || count(array_unique($statusArray)) === 1 && end($statusArray) === '16') || ((in_array('7', $statusArray) && in_array('16', $statusArray)) && (count(array_unique($statusArray))) <= 2)
            ) {
                $dispatchStatus = 'Completed';
            } else {
                $dispatchStatus = 'Partial';
            }
            $data = array(
                'dispatchStatus' => $dispatchStatus
            );
            LeadDetails::where('_id', new ObjectID($id))->update($data, ['upsert' => true]);
        }
    }

    /**
     * save reception form
     */
    public function saveReceptionForm(Request $request)
    {
        date_default_timezone_set('Asia/Dubai');
        $uniqIdArrayForm = $request->input('uniqIdArray');
        $idUniq = explode(",", $uniqIdArrayForm);
        $docIdArray = $request->input('docid');
        $lead_id = $request->input('lead_id');
        $leadDetails = LeadDetails::find($lead_id);
        $casemanagerid = $leadDetails->caseManager['id'];
        $casemanager = User::find($casemanagerid);
        $caseemail = $casemanager->email;
        $casename = $casemanager->name;
        $saveMethod = $request->input('save_method');
        $dispatchDetails = new \stdClass();
        if ($leadDetails->saveType == 'recipient') {
            $customer = RecipientDetails::find($leadDetails->customer['id']);
            $customerCode = '';
            $customername = $leadDetails->customer['recipientName'];
        } else {
            $customerCode = $request->input('customerCode');
            $customer = Customer::find($leadDetails->customer['id']);
            $customername = $leadDetails->customer['name'];
        }
        $customer_object = new \stdClass();
        $customer_object->id = new ObjectID($customer->_id);
        $customer_object->name = $request->input('customerName');
        $customer_object->recipientName = $request->input('recipientName');
        $customer_object->customerCode = $customerCode;
        $dispatchDetails->customer = $customer_object;
        $emp_object = new \stdClass();
        $employee = User::find($request->input('employee_list'));
        $emp_object->id = new ObjectId($employee->_id);
        $emp_object->name = $employee->name;
        $emp_object->empId = $employee->empID;
        $dispatchDetails->employee = $emp_object;
        $delivery = DeliveryMode::find($request->input('deliveryMode'));
        $deliveryObject = new \stdClass();
        $deliveryObject->id = new ObjectID($delivery->_id);
        $deliveryObject->deliveryMode = $delivery->deliveryMode;
        if ($request->input('way_bill') != '') {
            $deliveryObject->wayBill = $request->input('way_bill');
        }
        $dispatchDetails->deliveryMode = $deliveryObject;
        $disType = DispatchTypes::find($request->input('taskType'));
        $disTypeObject = new \stdClass();
        $disTypeObject->id = new ObjectID($disType->_id);
        $disTypeObject->dispatchType = $disType->type;
        $dispatchDetails->taskType = $disTypeObject;
        $referenceNumber = explode('/', $leadDetails->referenceNumber);
        $referencenumber = $disType->code . "/" . $referenceNumber[1] . "/" . $referenceNumber[2] . "/" . $referenceNumber[3];
        $dispatchDetails->agent = $request->input('agentName');
        $dispatchDetails->caseManager = $request->input('caseManager');
        $dispatchDetails->date_time = $request->input('date_time') ?: '--';
        $dispatchDetails->land_mark = $request->input('land_mark');
        $dispatchDetails->address = $request->input('address');
        $dispatchDetails->emailId = $request->input('emailId');
        $dispatchDetails->contactNum = $request->input('contactNum');
        $documentNameArray = $request->input('docName');
        $documentTypeArray = $request->input('type');
        $documentDescArray = $request->input('docDesc');
        $documentamountArray = $request->input('doc_amount');
        $documentCollectedAmount = $request->input('doc_collected_amount');
        $documentSelectArray = $request->input('docSelect');
        if (isset($idUniq)) {
            foreach ($idUniq as $uniqDocId) {
                LeadDetails::where('_id', new ObjectId($lead_id))->pull('dispatchDetails.documentDetails', ['id' => $uniqDocId]);
            }
        }
        $uniqIdArray = [];
        $statusArray = [];
        $fileUpload = [];
        $signUpload = [];
        $collectedAmountArray = [];
        if (isset($leadDetails['dispatchDetails']) && isset($docIdArray)) {
            $leadDocument = $leadDetails['dispatchDetails']['documentDetails'];
            foreach ($leadDocument as $key => $value) {
                if (in_array($value['id'], $docIdArray)) {
                    $statusArray[] = $value['DocumentCurrentStatus'];
                    if (isset($value['doc_collected_amount']) && $value['DocumentCurrentStatus'] != 18) {
                        $collectedAmountArray[] = $value['doc_collected_amount'];
                    }
                    if (isset($value['signUpload'])) {
                        $signUpload[] = $value['signUpload'];
                    }
                    if (isset($value['fileUpload'])) {
                        $fileUpload[] = $value['fileUpload'];
                    }
                    if (isset($value['uniqTransferId'])) {
                        $unique_transferid[] = $value['uniqTransferId'];
                    } else {
                        $unique_transferid[] = '';
                    }
                }
            }
        }
        foreach ($documentNameArray as $key => $doc) {
            $doc_array = [];
            $doc_object = new \stdClass();
            if (strval($doc) == strval(intval($doc))) {
                $documentTypeDetails = DocumentType::where('docNum', (int) $doc)->first();
                if (count($documentTypeDetails) == 0) {
                    $docId = '';
                    $docname = '';
                } else {
                    $docId = new ObjectID($documentTypeDetails->_id);
                    $docname = $documentTypeDetails->documentType;
                }
            } else {
                $documentTypeDetails = DocumentType::where('documentType', $doc)->first();
                $docId = new ObjectID($documentTypeDetails->_id);
                $docname = $documentTypeDetails->documentType;
            }
            if (preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/', $documentTypeArray[$key])) {
                $dispatchType = DispatchTypes::find($documentTypeArray[$key]);
                if (count($dispatchType) == 0) {
                    $disId = '';
                    $disType1 = '';
                } else {
                    $disId = new ObjectID($dispatchType->id);
                    $disType1 = $dispatchType->type;
                }
            } else {
                $dispatchType = DispatchTypes::where('type', $documentTypeArray[$key])->first();
                $disId = new ObjectID($dispatchType->id);
                $disType1 = $dispatchType->type;
            }

            $doc_object->documentId = $docId;
            $doc_object->documentName = $docname;
            if (strval($doc) == strval(intval($doc))) {
                if ($doc == 3 || $doc == 4 || $doc == 5) {
                    $doc_object->amount = $documentamountArray[$key];
                } else {
                    $doc_object->amount = '';
                }
            }
            if (strval($doc) != strval(intval($doc))) {
                if ($documentamountArray[$key] != 'NA') {
                    $doc_object->amount = $documentamountArray[$key];
                } else {
                    $doc_object->amount = '';
                }
            }

            if ($disType->type == "Direct Collections" && (($doc == 3 || $doc == 4 || $doc == 5) || ($doc == 'Cheque' || $doc == 'Cash' || $doc == 'Medical cards'))) {
                $doc_object->doc_collected_amount = $documentCollectedAmount[$key];
            } elseif (isset($collectedAmountArray[$key])) {
                $doc_object->doc_collected_amount = $collectedAmountArray[$key];
            } else {
                $doc_object->doc_collected_amount = '';
            }
            if (isset($unique_transferid[$key]) && $unique_transferid[$key] != '') {
                $doc_object->uniqTransferId = $unique_transferid[$key];
            }
            $doc_object->documentDescription = $documentDescArray[$key];
            if (isset($statusArray[$key])) {
                $doc_object->DocumentCurrentStatus = $statusArray[$key];
            } else {
                $doc_object->DocumentCurrentStatus = '18';
            }
            if (isset($fileUpload[$key])) {
                $doc_object->fileUpload = $fileUpload[$key];
            } else {
                $doc_object->fileUpload = '';
            }
            if (isset($signUpload[$key])) {
                $doc_object->signUpload = $signUpload[$key];
            } else {
                $doc_object->signUpload = '';
            }
            $doc_object->documentTypeId = $disId;
            $doc_object->documentType = $disType1;
            if (isset($docIdArray[$key])) {
                $doc_object->id = $docIdArray[$key];
                LeadDetails::where('_id', new ObjectId($lead_id))->pull('dispatchDetails.documentDetails', ['id' => $docIdArray[$key]]);
                $doc_array[] = $doc_object;
                LeadDetails::where('_id', new ObjectId($lead_id))->push('dispatchDetails.documentDetails', $doc_array);
            } else {
                $uniqId = uniqid();
                $doc_object->id = $uniqId;
                $doc_array[] = $doc_object;
                LeadDetails::where('_id', new ObjectId($lead_id))->push('dispatchDetails.documentDetails', $doc_array);
                $uniqIdArray[] = $uniqId;
            }
        }
        $lead_details = LeadDetails::find($lead_id);
        $dispatchDetails->documentDetails = $lead_details['dispatchDetails']['documentDetails'];
        $dispatchDetails->receivedBy = $request->input('receivedBy');
        $dispatchDetails->deliveredBy = $request->input('deliveredBy');
        $dispatchDetails->active = (int) 1;
        $leadDetails->dispatchDetails = $dispatchDetails;
        $leadDetails->contactNumber = $request->input('contactNum');
        $leadDetails->contactEmail = $request->input('emailId');
        $leadDetails->deliveryMode = $deliveryObject;
        $leadDetails->dispatchType = $disTypeObject;
        $leadDetails->customer = $customer_object;
        $leadDetails->employee = $emp_object;
        //		$leadDetails->push('previousDetails', $dispatchDetails);
        $leadDetails->save();
        if ($saveMethod) {
            $updatedBy_obj = new \stdClass();
            $updatedBy_obj->id = new ObjectID(Auth::id());
            $updatedBy_obj->name = Auth::user()->name;
            $updatedBy_obj->date = date('d/m/Y');
            $updatedBy_obj->action = "Reception";
            $updatedBy[] = $updatedBy_obj;
            $name = $updatedBy_obj->name;
            LeadDetails::where('_id', new ObjectId($lead_id))->push('updatedBy', $updatedBy);

            if ($saveMethod == 'print_without_button') {
                $print = "print_without";
            } elseif ($saveMethod == 'print_button') {
                $print = "print_with";
            } else {
                $referenceNumber = explode('/', $leadDetails->referenceNumber);
                $refNumber = $disType->code . "/" . $referenceNumber[1] . "/" . $referenceNumber[2] . "/" . $referenceNumber[3];
                LeadDetails::where('_id', new ObjectID($lead_id))->update(array('referenceNumber' => $refNumber));
                $print = '';
                $comment_time = date('H:i:s');
                $receptionStatusObject = new \stdClass();
                $receptionStatusObject->id = new ObjectID(Auth::id());
                $receptionStatusObject->name = Auth::user()->name;
                $receptionStatusObject->date = date('d/m/Y');
                if ($saveMethod == 'approve_button') {
                    if (isset($leadDetails->schedulerejectstatus)) {
                        LeadDetails::where('_id', new ObjectId($lead_id))->unset('schedulerejectstatus');
                    }
                    if ($request->input('employee_list') != '') {
                        $emp_object = new \stdClass();
                        $employee = User::find($request->input('employee_list'));
                        $assignname = $employee->name;
                        $assignemail = $employee->email;
                        $emp_object->id = new ObjectId($employee->_id);
                        $emp_object->name = $employee->name;
                        $emp_object->empId = $employee->empID;
                        LeadDetails::where('_id', new ObjectId($lead_id))->update(array('employee' => $emp_object));
                    }
                    $receptionStatusObject->status = "Approved";
                    $receStatus[] = $receptionStatusObject;
                    if ($leadDetails->receptionistStatus) {
                        LeadDetails::where('_id', new ObjectId($lead_id))->push('receptionistStatus', $receStatus);
                    } else {
                        $leadDetails->receptionistStatus = $receStatus;
                    }

                    $comment_object = new \stdClass();
                    $comment_object->comment = 'Approved from reception' . ',' . 'Message' . ' : ' . ucfirst(ucwords($request->input('action_comment')));
                    $comment_object->commentBy = Auth::user()->name;
                    $comment_object->commentTime = $comment_time;
                    $comment_object->id = new ObjectId(Auth::id());
                    $comment_object->date = date('d/m/Y');
                    $comment_array[] = $comment_object;
                    $leadDetails->push('comments', $comment_array);

                    Session::flash('status', 'Dispatch slip approved successfully');
                    $leadDetails->save();
                    $leadDetailsDet = LeadDetails::find($lead_id);
                    $lead = $leadDetailsDet['dispatchDetails']['documentDetails'];
                    $test_array = ['18', '12', '10'];
                    foreach ($lead as $count => $reply) {
                        if (in_array($reply['DocumentCurrentStatus'], $test_array)) {
                            $this->saveDocumentStatus($lead_id, $count, '13');
                        }
                    }
                    $this->setDispatchStatus($lead_id);
                    $this->saveTabStatus($lead_id);
                    $lead = "";
                    return response()->json(['status' => 'approved']);
                } elseif ($saveMethod == 'approve_button1') {
                    if ($request->input('employee_list') != '') {
                        $emp_object = new \stdClass();
                        $employee = User::find($request->input('employee_list'));
                        $emp_object->id = new ObjectId($employee->_id);
                        $emp_object->name = $employee->name;
                        $emp_object->empId = $employee->empID;
                        LeadDetails::where(
                            '_id',
                            new ObjectId($lead_id)
                        )->update(array('employee' => $emp_object));
                    }
                    $receptionStatusObject->status = "Approved";
                    $receStatus[] = $receptionStatusObject;
                    if ($leadDetails->receptionistStatus) {
                        LeadDetails::where('_id', new ObjectId($lead_id))->push(
                            'receptionistStatus',
                            $receStatus
                        );
                    } else {
                        $leadDetails->receptionistStatus = $receStatus;
                    }

                    Session::flash('status', 'Dispatch slip approved successfully');

                    $leadDetails->save();
                    $leadDetailsDet = LeadDetails::find($lead_id);
                    $lead = $leadDetailsDet['dispatchDetails']['documentDetails'];
                    foreach ($lead as $count => $reply) {
                        if (isset($documentSelectArray)) {
                            if (in_array($reply['id'], $documentSelectArray)) {
                                $this->saveDocumentStatus($lead_id, $count, '13');
                            }
                        }
                    }
                    $this->setDispatchStatus($lead_id);
                    $this->saveTabStatus($request->input('lead_id'));
                    return response()->json(['status' => 'approved']);
                } elseif ($saveMethod == 'reject_button') {
                    $leadDetails->rejectstatus = $request->input('message');
                    $receptionStatusObject->status = "Rejected";
                    $receptionStatusObject->comment = $request->input('message');
                    $receStatus[] = $receptionStatusObject;

                    $comment_object = new \stdClass();
                    $comment_object->comment = 'Reject from reception' . ',' . 'Message' . ' : ' . ucfirst(ucwords($request->input('message')));
                    $comment_object->commentBy = Auth::user()->name;
                    $comment_object->commentTime = $comment_time;
                    $comment_object->id = new ObjectId(Auth::id());
                    $comment_object->date = date('d/m/Y');
                    $comment_array[] = $comment_object;
                    $leadDetails->push('comments', $comment_array);
                    if ($leadDetails->receptionistStatus) {
                        LeadDetails::where('_id', new ObjectId($lead_id))->push('receptionistStatus', $receStatus);
                    } else {
                        $leadDetails->receptionistStatus = $receStatus;
                    }
                    Session::flash('status', 'Dispatch slip rejected successfully');

                    $leadDetails->save();
                    $leadDetailsDet = LeadDetails::find($lead_id);
                    $lead = $leadDetailsDet['dispatchDetails']['documentDetails'];
                    $test_array = ['18', '12'];

                    foreach ($lead as $count => $reply) {
                        if (in_array($reply['DocumentCurrentStatus'], $test_array)) {
                            $this->saveDocumentStatus($lead_id, $count, '10');
                        }
                    }
                    $this->setDispatchStatus($lead_id);
                    $this->saveTabStatus($request->input('lead_id'));
                    $caselink = url('/dispatch/dispatch-list/');
                    $action = "Reception";
                    $lead = "";
                    if (isset($leadDetailsDet->schedulerejectstatus)) {
                        LeadDetails::where('_id', new ObjectId($lead_id))->unset('schedulerejectstatus');
                    }
                    if ($caseemail != '') {
                        SendcasemanagerADleads::dispatch($casename, $caseemail, $referencenumber, $name, $caselink, $saveMethod, $action, $lead, $customername);
                    }
                    return response()->json(['status' => 'rejected']);
                } elseif ($saveMethod == 'direct_collected_button') {
                    $receptionStatusObject->status = "Collected Directly";
                    $comment_object = new \stdClass();
                    $comment_object->comment = 'Collected from reception';
                    $comment_object->commentBy = Auth::user()->name;
                    $comment_object->commentTime = $comment_time;
                    $comment_object->id = new ObjectId(Auth::id());
                    $comment_object->date = date('d/m/Y');
                    $comment_array[] = $comment_object;
                    $leadDetails->push('comments', $comment_array);
                    $receStatus[] = $receptionStatusObject;
                    if ($leadDetails->receptionistStatus) {
                        LeadDetails::where('_id', new ObjectId($lead_id))->push(
                            'receptionistStatus',
                            $receStatus
                        );
                    } else {
                        $leadDetails->receptionistStatus = $receStatus;
                    }
                    $leadDetailsDet = LeadDetails::find($lead_id);
                    $lead = $leadDetailsDet['dispatchDetails']['documentDetails'];
                    foreach ($lead as $count => $reply) {
                        $this->saveDocumentStatus($lead_id, $count, '2');
                    }
                    Session::flash('status', 'Dispatch slip collected successfully');
                    $leadDetails->save();
                    $this->saveTabStatus($lead_id);
                    $this->setDispatchStatus($lead_id);
                    return response()->json(['status' => 'go_reception']);
                } elseif ($saveMethod == 'direct_delivered_button') {
                    $receptionStatusObject->status = "Delivered Directly";
                    $receStatus[] = $receptionStatusObject;
                    if ($leadDetails->receptionistStatus) {
                        LeadDetails::where(
                            '_id',
                            new ObjectId($lead_id)
                        )->push('receptionistStatus', $receStatus);
                    } else {
                        $leadDetails->receptionistStatus = $receStatus;
                    }
                    Session::flash('status', 'Dispatch slip delivered successfully');
                    $leadDetails->save();
                    return response()->json(['status' => 'go_reception']);
                }
            }
            if ($print != '') {
                $leadDetails->save();
                if (isset($docIdArray) && isset($uniqIdArray)) {
                    $documentSelectArray1 = array_merge($docIdArray, $uniqIdArray);
                } elseif (isset($docIdArray) && !isset($uniqIdArray)) {
                    $documentSelectArray1 =    $docIdArray;
                } elseif (!isset($docIdArray) && isset($uniqIdArray)) {
                    $documentSelectArray1 =    $uniqIdArray;
                }
                $leadDet = LeadDetails::find($leadDetails->_id);
                $documentsList = $leadDet['dispatchDetails']['documentDetails'];

                $pdf = PDF::loadView('dispatch.pdf.dispatch_slip', ['leadDetails' => $leadDetails, 'documentsList' => $documentsList, 'documentSelectArray' => $documentSelectArray1, 'print' => $print]);
                $pdf_name = 'dispatch-slip_' . time() . '_' . $leadDetails->_id . '.pdf';
                //dd($pdf);
                $pdf->setOption('page-width', '220');
                $pdf->setOption('page-height', '260')->inline();
                $temp_path = public_path('pdf/' . $pdf_name);

                $pdf->save('pdf/' . $pdf_name);

                $pdf_file = $this->uploadFileToCloud_file($pdf_name, $temp_path);
                unlink($temp_path);
                $leadDetails->dispatchSlip = $pdf_file;
                $leadDetails->save();
                return response()->json(['success' => 'pdf', 'pdf' => $leadDetails->dispatchSlip, 'uniqIdArray' => $uniqIdArray]);
            }
        }
    }

    /**
     * schedule for delivery listing page
     */
    public function scheduleDelivery(Request $request)
    {
        if (!empty($request->input('agent'))) {
            $count = 0;
            foreach ($request->input('agent') as $cust) {
                $objectArray[$count] = new ObjectId($cust);
                $count++;
            }
            $agents = User::where('isActive', 1)->where(function ($q) {
                $q->where('role', 'EM')->orWhere('role', 'AG');
            })->whereIn('_id', $objectArray)->get();
        } else {
            $agents = '';
        }

        if (!empty($request->input('assigned'))) {
            $count = 0;
            foreach ($request->input('assigned') as $cust) {
                $objectArray[$count] = new ObjectId($cust);
                $count++;
            }
            $assigned_to = User::where('isActive', 1)->where(function ($q) {
                $q->where('role', 'EM')->orWhere('role', 'AG')->orWhere('role', 'CR')->orWhere('role', 'AD')->orWhere('role', 'MS')->orWhere('role', 'CO')->orWhere('role', 'SV');
            })->whereIn('_id', $objectArray)->get();
        } else {
            $assigned_to = '';
        }

        if (!empty($request->input('customer'))) {
            $count = 0;
            foreach ($request->input('customer') as $cust) {
                $objectArray[$count] = new ObjectId($cust);
                $count++;
            }
            $customers = Customer::whereIn('_id', $objectArray)->get();
            $recepients = RecipientDetails::whereIn('_id', $objectArray)->get();
            $customers = $customers->merge($recepients);
        } else {
            $customers = '';
        }
        //\		$customer_code = [];
        //		foreach ($customers as $customer) {
        //			$customer_code[] = $customer->customerCode;
        //		}
        if (!empty($request->input('case_manager'))) {
            $count = 0;
            foreach ($request->input('case_manager') as $cust) {
                $objectArray[$count] = new ObjectId($cust);
                $count++;
            }
            $case_managers = User::where('isActive', 1)->where(function ($q) {
                $q->where('role', 'EM')->orWhere('role', 'AD')->orWhere('role', 'RP')->orWhere('role', 'AG')->orWhere('role', 'CO')->orWhere('role', 'SV');
            })->whereIn('_id', $objectArray)->get();
        } else {
            $case_managers = '';
        }

        if (!empty($request->input('dispatch'))) {
            $count = 0;
            foreach ($request->input('dispatch') as $cust) {
                $objectArray[$count] = new ObjectId($cust);
                $count++;
            }
            if (
                session('role') == 'Insurer' || session('role') == 'Employee' || session('role') == 'Agent' || session('role') == 'Coordinator' ||
                session('role') == 'Supervisor' || session('role') == 'Courier' || session('role') == 'Messenger' || session('role') == 'Accountant'
            ) {
                $dispatch_type_check = DispatchTypes::where('type', '!=', 'Direct Collections')->whereIn('_id', $objectArray)->get();
            } else {
                $dispatch_type_check = DispatchTypes::whereIn('_id', $objectArray)->get();
            }
        } else {
            $dispatch_type_check = '';
        }
        if (!empty($request->input('delivery'))) {
            $count = 0;
            foreach ($request->input('delivery') as $cust) {
                $objectArray[$count] = new ObjectId($cust);
                $count++;
            }
            $delivery_mode_check = DeliveryMode::whereIn('_id', $objectArray)->get();
        } else {
            $delivery_mode_check = '';
        }
        if (!empty($request->input('status'))) {
            $count = 0;
            foreach ($request->input('status') as $cust) {
                $objectArray[$count] = $cust;
                $count++;
            }
            $Allstatus = DispatchStatus::whereIn('status', $objectArray)->groupBy('status')->get();
        } else {
            $Allstatus = '';
        }

        $delivery_mode = DeliveryMode::all();
        $dispatch_types = DispatchTypes::all();
        $document_types = DocumentType::all();
        $filter_data = $request->input();
        $current_path = $request->path();
        return view('dispatch.schedule_for_delivery_list')
            ->with(compact(
                'dispatch_type_check',
                'assigned_to',
                'customers',
                'delivery_mode_check',
                'agents',
                'case_managers',
                'delivery_mode',
                'dispatch_types',
                'customer_code',
                'filter_data',
                'document_types',
                'current_path',
                'Allstatus'
            ));
    }

    /**
     * schedule listing page
     */
    public function scheduleData(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $filter = $request->input('search');
        $filter_data_en = $request->get('filterData');
        $filter_data = json_decode($filter_data_en);
        $sort = $request->get('field');
        $search = (isset($filter['value'])) ? $filter['value'] : false;
        session()->put('filter', $filter_data_en);
        session()->put('sort', $sort);
        $LeadDetails = LeadDetails::where('active', 1)->where('scheduledTabStatus', (int) 1);

        //	     $LeadDetails = LeadDetails::where('active', 1)->whereIn('dispatchStatus',array('Schedule Delivery','Update Again'));
        if (session('role') == 'Employee') {
            $LeadDetails = $LeadDetails->where(function ($q) {
                $q->where('caseManager.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('agent.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('employee.id', new ObjectID(Auth::user()->_id));
            });
        } elseif (session('role') == 'Coordinator') {
            $LeadDetails = $LeadDetails->where(function ($q) {
                $q->where('agent.id', session('assigned_agent'))
                    ->orwhere('agent.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('employee.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('employee.id', session('assigned_agent'));
            });
        } elseif (session('role') == 'Agent') {
            $LeadDetails = $LeadDetails->where(function ($q) {
                $q->where('agent.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('caseManager.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('employee.id', new ObjectID(Auth::user()->_id));
            });
        } elseif (session('role') == 'Supervisor') {
            $LeadDetails = $LeadDetails->where(function ($q) {
                $q->where('agent.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('caseManager.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('employee.id', new ObjectID(Auth::user()->_id))
                    ->orwhereIn('employee.id', session('employees'));
            });
        } elseif (session('role') != 'Admin' && session('role') != 'Receptionist') {
            $LeadDetails = $LeadDetails->where('employee.id', new ObjectID(Auth::user()->_id));
        }

        if (!empty($filter_data)) {
            if (!empty($filter_data->agent)) {
                $count = 0;
                foreach ($filter_data->agent as $agent) {
                    $objectArray[$count] = new ObjectId($agent);
                    $count++;
                }
                $LeadDetails = $LeadDetails->whereIn('agent.id', $objectArray);
            }
            if (!empty($filter_data->case_manager)) {
                $count = 0;
                foreach ($filter_data->case_manager as $manager) {
                    $objectArray[$count] = new ObjectId($manager);
                    $count++;
                }
                $LeadDetails = $LeadDetails->whereIn('caseManager.id', $objectArray);
            }
            if (!empty($filter_data->customer)) {
                $count = 0;
                foreach ($filter_data->customer as $cust) {
                    $objectArray[$count] = new ObjectId($cust);
                    $count++;
                }
                $LeadDetails = $LeadDetails->whereIn('customer.id', $objectArray);
            }
            if (!empty($filter_data->delivery)) {
                $count = 0;
                foreach ($filter_data->delivery as $mode) {
                    $objectArray[$count] = new ObjectId($mode);
                    $count++;
                }
                $LeadDetails = $LeadDetails->whereIn('deliveryMode.id', $objectArray);
            }
            if (!empty($filter_data->dispatch)) {
                $count = 0;
                foreach ($filter_data->dispatch as $type) {
                    $objectArray[$count] = new ObjectId($type);
                    $count++;
                }
                $LeadDetails = $LeadDetails->whereIn('dispatchType.id', $objectArray);
            }
            if (!empty($filter_data->assigned)) {
                $count = 0;
                foreach ($filter_data->assigned as $type) {
                    $objectArray[$count] = new ObjectId($type);
                    $count++;
                }
                $LeadDetails = $LeadDetails->whereIn('employee.id', $objectArray);
            }
            if (!empty($filter_data->status)) {
                $count = 0;
                foreach ($filter_data->status as $stat) {
                    $objectArray[$count] = $stat;
                    $count++;
                }
                $LeadDetails = $LeadDetails->whereIn('dispatchStatus', $objectArray);
            }
        }

        if (!empty($sort)) {
            if ($sort == "Customer Name") {
                $LeadDetails = $LeadDetails->orderBy('customer.name');
            } elseif ($sort == "Agent") {
                $LeadDetails = $LeadDetails->orderBy('agent.name');
            } elseif ($sort == "Case Manager") {
                $LeadDetails = $LeadDetails->orderBy('caseManager.name');
            } elseif ($sort == "Dispatch Type") {
                $LeadDetails = $LeadDetails->orderBy('dispatchType.dispatchType');
            } elseif ($sort == "Delivery Mode") {
                $LeadDetails = $LeadDetails->orderBy('deliveryMode.deliveryMode');
            }
        } elseif (empty($sort)) {
            $LeadDetails = $LeadDetails->orderBy(
                'created_at',
                'DESC'
            );
        }
        if ($search) {
            $LeadDetails = $LeadDetails->where(function ($query) use ($search) {
                $query->Where('referenceNumber', 'like', '%' . $search . '%')
                    ->orWhere('customer.name', 'like', '%' . $search . '%')
                    ->orWhere('customer.recipientName', 'like', '%' . $search . '%')
                    ->orWhere('customer.customerCode', 'like', '%' . $search . '%')
                    ->orWhere('agent.name', 'like', '%' . $search . '%')
                    ->orWhere('caseManager.name', 'like', '%' . $search . '%')
                    ->orWhere('contactNumber', 'like', '%' . $search . '%')
                    ->orWhere('dispatchStatus', 'like', '%' . $search . '%')
                    ->orWhere('deliveryMode.deliveryMode', 'like', '%' . $search . '%')
                    ->orWhere('dispatchType.dispatchType', 'like', '%' . $search . '%');
            });


            session()->put('search', $search);
        }
        if ($search == "") {
            $LeadDetails = $LeadDetails;
            session()->put('search', "");
        }
// dd(session('employees'));
        $searchField = $request->get('searchField');
        if ($searchField != "") {
            $LeadDetails = $LeadDetails->where(function ($query) use ($searchField) {
                $query->Where('referenceNumber', 'like', '%' . $searchField . '%')
                    ->orWhere('customer.name', 'like', '%' . $searchField . '%')
                    ->orWhere('customer.recipientName', 'like', '%' . $searchField . '%')
                    ->orWhere('customer.customerCode', 'like', '%' . $searchField . '%')
                    ->orWhere('agent.name', 'like', '%' . $searchField . '%')
                    ->orWhere('caseManager.name', 'like', '%' . $searchField . '%')
                    ->orWhere('contactNumber', 'like', '%' . $searchField . '%')
                    ->orWhere('dispatchStatus', 'like', '%' . $searchField . '%')
                    ->orWhere('deliveryMode.deliveryMode', 'like', '%' . $searchField . '%')
                    ->orWhere('dispatchType.dispatchType', 'like', '%' . $searchField . '%');
            });
        }
        $total_leads = $LeadDetails->count(); // get your total no of data;
        $members_query = $LeadDetails;
        $search_count = $members_query->count();
        $LeadDetails->skip((int) $start)->take((int) $length);
        $final_leads = $LeadDetails->get();
        $empID=session('employees')?: [];
        array_push($empID, new ObjectId(Auth::user()->_id));
        session(['employees_idCheck' => $empID]);
        foreach ($final_leads as $leads) {
            $check = '<div class="custom_checkbox">' .
                '<input type="checkbox" name="marked_list[]" value="" id="' . $leads->_id . '" class="inp-cbx" style="display: none" onchange="markedCheck(this.id)">' .
                '<label for="' . $leads->_id . '" class="cbx">' .
                '<span>' .
                '    <svg width="10px" height="8px" viewBox="0 0 12 10">' .
                '      <polyline points="1.5 6 4.5 9 10.5 1"></polyline>' .
                '    </svg>' .
                '</span>' .
                '</label>' .
                '</div>';
            if ((session('role') == 'Employee' && Auth::user()->_id != @$leads->employee['id'])  || (session('role') == 'Agent' && Auth::user()->_id != @$leads->employee['id'])
                || (session('role') == 'Coordinator' && session('assigned_agent') != @$leads->employee['id']) ||
                 (session('role') == 'Supervisor' && !in_array(@$leads->employee['id'], session('employees_idCheck')))
            ) {
                $check = '<div class="custom_checkbox">' .
                    '<input  type="checkbox" name="marked_list[]" disabled class="inp-cbx check" id="' . $leads->_id . '" style="display: none"  onchange="markedCheck(this.id)">' .
                    '<label for="' . $leads->_id . '" class="cbx" style="cursor: auto;">' .
                    '<span>' .
                    '    <svg width="10px" height="8px" viewBox="0 0 12 10">' .
                    '      <polyline points="1.5 6 4.5 9 10.5 1"></polyline>' .
                    '    </svg>' .
                    '</span>' .
                    '    <span></span>' .
                    '</label>' .
                    '</div>';
            }

            if ($leads['referenceNumber'] == '') {
                $referenceNumber = '--';
            } else {
                $referenceNumber = '<a href="#" class="auto_modal table_link" data-toggle="tooltip" data-placement="bottom" title="View Dispatch Slip" data-container="body"  data-modal="view_lead_popup" dir="' . $leads->_id . '" onclick="view_lead_popup(\'' . $leads->_id . '\');">

' . $leads['referenceNumber'] . '  </a> ';
            }
            if (isset($leads->agent['name'])) {
                $agentname = ucwords(strtolower($leads->agent['name']));
                if (isset($leads->agent['empid'])) {
                    if ($leads->agent['empid'] != "") {
                        $agentid = $leads->agent['empid'];
                        $agentvalue = $agentname . ' (' . $agentid . ')';
                    } else {
                        $agentvalue = $agentname;
                    }
                } else {
                    $agentvalue = $agentname;
                }
            } else {
                $agentvalue = 'NA';
            }
            $agent = $agentvalue;
            $caseManager = ucwords(strtolower($leads['caseManager.name']));
            $email = $leads->contactEmail;
            $contact = $leads->contactNumber;
            $recipientName = ucwords(strtolower($leads['customer.recipientName']));
            $dispatchType = $leads['dispatchType.dispatchType'];
            $deliveryMode = $leads['deliveryMode.deliveryMode'];
            $code = $leads['customer.customerCode'] ?: '--';
            $customerName = ucwords(strtolower($leads['customer.name']));
            $created_at = $leads->created_at;
            if (isset($leads->employee['name'])) {
                $assignname = ucwords(strtolower($leads->employee['name']));
                if ($leads->employee['empId'] != null) {
                    $assignid = $leads->employee['empId'];
                    $assignvalue = $assignname . ' (' . $assignid . ')';
                } else {
                    $assignvalue = $assignname;
                }
            } else {
                $assignvalue = '--';
            }
            //			if ($leads['dispatchType.dispatchType'] == 'Delivery' && $leads->dispatchStatus == 'Schedule Delivery') {
            //				$status = 'Schedule Delivery';
            //			} elseif ($leads['dispatchType.dispatchType'] == 'Collections' && $leads->dispatchStatus == 'Schedule Delivery') {
            //				$status = 'Schedule Collection';
            //			} elseif ($leads['dispatchType.dispatchType'] == 'Delivery & Collections' && $leads->dispatchStatus == 'Schedule Delivery') {
            //				$status = 'Schedule Delivery & Collection';
            //			} elseif ($leads['dispatchType.dispatchType'] == 'Delivery' && $leads->dispatchStatus == 'Update Again') {
            //				$status = 'Schedule Delivery';
            //			} else {

            //			}
            if ($leads['dispatchStatus'] == '') {
                $status = '--';
            } else {
                $status = '<a href="#">

<span data-toggle="tooltip" data-placement="bottom" title="Assigned to : ' . $assignvalue . '"  data-container="body" > ' . $leads['dispatchStatus'] . ' </span>  ';
            }
            $leads->checkall = $check;
            $leads->customerCode = $code;
            $leads->referenceNumber = $referenceNumber;
            $leads->customerName = $customerName;
            $leads->recipientName = $recipientName;
            $leads->contactNo = $contact;
            $leads->email = $email;
            $leads->caseManager = $caseManager;
            $leads->agent = $agent;
            $leads->dispatchType = $dispatchType;
            $leads->deliveryMode = $deliveryMode;
            $leads->status = $status;
            $leads->assigned = $assignvalue;
            $leads->created = Carbon::parse($created_at)->format('d/m/Y');
            if (session('role') == 'Admin') {
                $delete_button = '<button class="btn export_btn waves-effect auto_modal delete_icon_btn" type="button" data-toggle="tooltip" data-placement="bottom" title="Delete" data-container="body"  data-modal="delete_popup" dir="' . $leads->_id . '" onclick="delete_pop(this);">
<i class="material-icons">delete_outline</i>
</button>';
                $leads->delete_button = $delete_button;
            } else {
                $leads->delete_button = "";
            }
        }
        if ($search) {
            $filtered_count = $search_count;
        } else {
            $filtered_count = $total_leads;
        }


        $data = array(
            'draw' => $draw,
            'recordsTotal' => $total_leads,
            'recordsFiltered' => $filtered_count,
            'data' => $final_leads,
        );

        return json_encode($data);
    }

    /**
     * export excel for scheduled list
     */
    public function exportScheduleList(Request $request)
    {
        ini_set('xdebug.max_nesting_level', 500);
        $email = $request->input('email');
        $filter_data = json_decode(session('filter'));
        $sort = session('sort');
        $search = session('search');
        $leadDetails = LeadDetails::where('active', 1)->where('scheduledTabStatus', (int) 1);
        if (session('role') == 'Employee') {
            $leadDetails = $leadDetails->where(function ($q) {
                $q->where('caseManager.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('agent.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('employee.id', new ObjectID(Auth::user()->_id));
            });
        } elseif (session('role') == 'Agent') {
            $leadDetails = $leadDetails->where(function ($q) {
                $q->where('agent.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('caseManager.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('employee.id', new ObjectID(Auth::user()->_id));
            });
        } elseif (session('role') == 'Coordinator') {
            $leadDetails = $leadDetails->where(function ($q) {
                $q->where('agent.id', session('assigned_agent'))
                    ->orwhere('agent.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('employee.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('employee.id', session('assigned_agent'));
            });
        } elseif (session('role') == 'Supervisor') {
            $leadDetails = $leadDetails->where(function ($q) {
                $q->where('agent.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('caseManager.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('employee.id', new ObjectID(Auth::user()->_id))
                    ->orwhereIn('employee.id', session('employees'));
            });
        } elseif (session('role') != 'Admin' && session('role') != 'Receptionist') {
            $leadDetails = $leadDetails->where('employee.id', new ObjectID(Auth::user()->_id));
        }

        if (!empty($filter_data)) {
            if (!empty($filter_data->agent)) {
                $count = 0;
                foreach ($filter_data->agent as $agent) {
                    $objectArray[$count] = new ObjectId($agent);
                    $count++;
                }
                $leadDetails = $leadDetails->whereIn('agent.id', $objectArray);
            }
            if (!empty($filter_data->case_manager)) {
                $count = 0;
                foreach ($filter_data->case_manager as $manager) {
                    $objectArray[$count] = new ObjectId($manager);
                    $count++;
                }
                $leadDetails = $leadDetails->whereIn('caseManager.id', $objectArray);
            }
            if (!empty($filter_data->customer)) {
                $count = 0;
                foreach ($filter_data->customer as $cust) {
                    $objectArray[$count] = new ObjectId($cust);
                    $count++;
                }
                $leadDetails = $leadDetails->whereIn('customer.id', $objectArray);
            }
            if (!empty($filter_data->delivery)) {
                $count = 0;
                foreach ($filter_data->delivery as $mode) {
                    $objectArray[$count] = new ObjectId($mode);
                    $count++;
                }
                $leadDetails = $leadDetails->whereIn('deliveryMode.id', $objectArray);
            }
            if (!empty($filter_data->dispatch)) {
                $count = 0;
                foreach ($filter_data->dispatch as $type) {
                    $objectArray[$count] = new ObjectId($type);
                    $count++;
                }
                $leadDetails = $leadDetails->whereIn('dispatchType.id', $objectArray);
            }
            if (!empty($filter_data->assigned)) {
                $count = 0;
                foreach ($filter_data->assigned as $type) {
                    $objectArray[$count] = new ObjectId($type);
                    $count++;
                }
                $leadDetails = $leadDetails->whereIn('employee.id', $objectArray);
            }
            if (!empty($filter_data->status)) {
                $count = 0;
                foreach ($filter_data->status as $stat) {
                    $objectArray[$count] = $stat;
                    $count++;
                }
                $leadDetails = $leadDetails->whereIn('dispatchStatus', $objectArray);
            }
        }


        if (!empty($sort)) {
            if ($sort == "Customer Name") {
                //				$leadDetails = $leadDetails->where('active', 1)->where('dispatchStatus',
                //					'Schedule Delivery')->orderBy('customer.name');
                $leadDetails = $leadDetails->orderBy('customer.name');
            } elseif ($sort == "Agent") {
                //				$leadDetails = $leadDetails->where('active', 1)->where('dispatchStatus',
                //					'Schedule Delivery')->orderBy('agent.name');
                $leadDetails = $leadDetails->orderBy('agent.name');
            } elseif ($sort == "Case Manager") {
                //				$leadDetails = $leadDetails->where('active', 1)->where('dispatchStatus',
                //					'Schedule Delivery')->orderBy('caseManager.name');
                $leadDetails = $leadDetails->orderBy('caseManager.name');
            } elseif ($sort == "Dispatch Type") {
                //				$leadDetails = $leadDetails->where('active', 1)->where('dispatchStatus',
                //					'Schedule Delivery')->orderBy('dispatchType.dispatchType');
                $leadDetails = $leadDetails->orderBy('dispatchType.dispatchType');
            } elseif ($sort == "Delivery Mode") {
                //				$leadDetails = $leadDetails->where('active', 1)->where('dispatchStatus',
                //					'Schedule Delivery')->orderBy('deliveryMode.deliveryMode');
                $leadDetails = $leadDetails->orderBy('deliveryMode.deliveryMode');
            }
        } elseif (empty($sort)) {
            //			$leadDetails = $leadDetails->where('active', 1)->where('dispatchStatus',
            //				'Schedule Delivery')->orderBy('created_at', 'DESC');
            $leadDetails = $leadDetails->orderBy('created_at', 'DESC');
        }

        if ($search) {
            $leadDetails = $leadDetails->where(function ($query) use ($search) {
                $query->Where('referenceNumber', 'like', '%' . $search . '%')
                    ->orWhere('customer.name', 'like', '%' . $search . '%')
                    ->orWhere('customer.recipientName', 'like', '%' . $search . '%')
                    ->orWhere('customer.customerCode', 'like', '%' . $search . '%')
                    ->orWhere('agent.name', 'like', '%' . $search . '%')
                    ->orWhere('caseManager.name', 'like', '%' . $search . '%')
                    ->orWhere('contactNumber', 'like', '%' . $search . '%')
                    ->orWhere('contactEmail', 'like', '%' . $search . '%')
                    ->orWhere('deliveryMode.deliveryMode', 'like', '%' . $search . '%')
                    ->orWhere('dispatchType.dispatchType', 'like', '%' . $search . '%');
            });
            session()->put('search', $search);
        }
        $leadDetails = $leadDetails->select('customer', 'created_at', 'contactNumber', 'contactEmail', 'referenceNumber', 'deliveryMode', 'dispatchType', 'employee', 'agent', 'dispatchDetails.land_mark', 'dispatchDetails.documentDetails');
        $data[] = array('Schedule for delivery/collection');
        $excel_header = [
            'CID',
            'CUSTOMER NAME',
            'LEAD CREATED DATE',
            'TRANSACTION NUMBER',
            'DISPATCH TYPE',
            'TYPE OF DOCUMENT',
            'TYPE OF DELIVERY',
            'AMOUNT / CARDS',
            'CUSTOMER CONTACT NUMBER',
            'CUSTOMER EMAIL ID',
            'RECIPIENT NAME',
            'AGENT NAME',
            'DELIVERY MODE',
            'ASSIGNED TO',
            'LAND MARK',
            'DOCUMENT DESCRIPTION'
        ];

        $file_name = 'Schedule for delivery-collection' . rand();
        Excel::create($file_name, function ($excel) use ($leadDetails, $excel_header) {
            $excel->sheet('Schedule for delivery list', function ($sheet) use ($leadDetails, $excel_header) {
                $sheet->appendRow($excel_header);
                $sheet->row(1, function ($row) {
                    $row->setFontSize(10);
                    $row->setFontColor('#ffffff');
                    $row->setBackground('#1155CC');
                });
                $leadDetails->chunk(100, function ($final_leads) use ($sheet) {
                    foreach ($final_leads as $leads) {
                        $createdDate = $leads->created_at;
                        $date = date("d/m/Y", strtotime($createdDate));
                        if (isset($leads->employee['name'])) {
                            $assignname = ucwords(strtolower($leads->employee['name']));
                            if (isset($leads->employee['empId'])) {
                                if ($leads->employee['empId'] != "") {
                                    $assignid = $leads->employee['empId'];
                                    $assignvalue = $assignname . ' (' . $assignid . ')';
                                } else {
                                    $assignvalue = $assignname;
                                }
                            } else {
                                $assignvalue = $assignname;
                            }
                        } else {
                            $assignvalue = '--';
                        }
                        if (isset($leads->agent['name'])) {
                            $agentname = ucwords(strtolower($leads->agent['name']));
                            if (isset($leads->agent['empid'])) {
                                if ($leads->agent['empid'] != "") {
                                    $agentid = $leads->agent['empid'];
                                    $agentvalue = ucwords(strtolower($agentname)) . ' (' . $agentid . ')';
                                } else {
                                    $agentvalue = ucwords(strtolower($agentname));
                                }
                            } else {
                                $agentvalue = ucwords(strtolower($agentname));
                            }
                        } else {
                            $agentvalue = 'NA';
                        }
                        if (isset($leads->contactNumber)) {
                            $contact = $leads->contactNumber;
                        } else {
                            $contact = '--';
                        }
                        if (isset($leads->contactEmail)) {
                            $contactEmail = $leads->contactEmail;
                        } else {
                            $contactEmail = '--';
                        }
                        if (isset($leads['customer.customerCode'])) {
                            $custCode = $leads['customer.customerCode'];
                        } else {
                            $custCode = '--';
                        }
                        if (isset($leads['customer.name'])) {
                            $custName = $leads['customer.name'];
                        } else {
                            $custName = '--';
                        }
                        if (isset($leads['customer.recipientName'])) {
                            $recName = $leads['customer.recipientName'];
                        } else {
                            $recName = '--';
                        }
                        if (isset($leads['dispatchDetails']['documentDetails'])) {
                            $leadDocuments = $leads['dispatchDetails']['documentDetails'];
                            foreach ($leadDocuments as $count => $reply) {
                                if ($reply['DocumentCurrentStatus'] == '13') {
                                    $data = array(
                                        $custCode ?: '--',
                                        ucwords(strtolower($custName)),
                                        $date,
                                        $leads['referenceNumber'],
                                        $leads['dispatchType.dispatchType'],
                                        $reply['documentName'],
                                        $leads['deliveryMode.deliveryMode'],
                                        $reply['amount'] ?: '--',
                                        $contact,
                                        $contactEmail,
                                        ucwords(strtolower($recName)),
                                        $agentvalue,
                                        $leads['deliveryMode.deliveryMode'],
                                        $assignvalue,
                                        $leads['dispatchDetails.land_mark'] ?: '--',
                                        $reply['documentDescription'] ?: '--'
                                    );
                                    $sheet->appendRow($data);
                                }
                            }
                        } else {
                            $data = array(
                                $custCode ?: '--',
                                ucwords(strtolower($custName)),
                                $date,
                                $leads['referenceNumber'],
                                $leads['dispatchType.dispatchType'],
                                '--',
                                $leads['deliveryMode.deliveryMode'],
                                '--',
                                $contact,
                                $contactEmail,
                                ucwords(strtolower($recName)),
                                $agentvalue,
                                $leads['deliveryMode.deliveryMode'],
                                $assignvalue,
                                $leads['dispatchDetails.land_mark'] ?: '--',
                                '--'
                            );
                            $sheet->appendRow($data);
                        }
                    }
                });
            });
        })->store('xls', public_path('excel'));
        $excel_name = $file_name . '.' . 'xls';
        $send_excel = public_path('/excel/' . $excel_name);
        //		dd($send_excel);
        $tab_value = 'schedule';
        sendExcel::dispatch($email, $send_excel, $tab_value);
        //		Session::flash('status', 'Excel send to '. $email );
        return 'success';
    }

    /**
     * save schedule form
     */
    public function saveScheduleForm(Request $request)
    {
        date_default_timezone_set('Asia/Dubai');
        $comment_time = date('H:i:s');
        $lead_id = $request->input('lead_id');
        $leadDetails = LeadDetails::find($lead_id);
        $referencenumber = $leadDetails->referenceNumber;
        $casemanagerid = $leadDetails->caseManager['id'];
        //        $cusname=$leadDetails->caseManager['name'];
        $casemanager = User::find($casemanagerid);
        $caseemail = $casemanager->email;
        $casename = $casemanager->name;
        $assignid = $leadDetails->employee['id'];
        $assign = User::find($assignid);
        $assignname = $assign->name;
        $assignemail = $assign->email;
        $custid = $leadDetails->customer['id'];
        //        $cust=Customer::find($custid);
        $custname = $leadDetails->customer['name'];
        $custemail = $leadDetails->contactEmail;
        $saveMethod = $request->input('save_method');
        $docID = $request->input('docid');
        //		$documentSelectArray = $request->input('docSelect');

        if ($saveMethod) {
            $updatedBy_obj = new \stdClass();
            $updatedBy_obj->id = new ObjectID(Auth::id());
            $updatedBy_obj->name = Auth::user()->name;
            $updatedBy_obj->date = date('d/m/Y');
            $updatedBy_obj->action = "Schedule";
            $updatedBy[] = $updatedBy_obj;
            $name = $updatedBy_obj->name;
            LeadDetails::where('_id', new ObjectId($lead_id))->push('updatedBy', $updatedBy);

            if ($saveMethod == 'print_without_button') {
                $print = "print_without";
            } else {
                if ($saveMethod == 'print_button') {
                    $print = "print_with";
                } else {
                    $print = '';
                    $scheduleStatusObject = new \stdClass();
                    $scheduleStatusObject->id = new ObjectID(Auth::id());
                    $scheduleStatusObject->name = Auth::user()->name;
                    $scheduleStatusObject->date = date('d/m/Y');
                    if ($saveMethod == 'approve_button') {
                        $comment_object = new \stdClass();
                        $comment_object->comment = 'Approved from schedule for delivery/collection' . ',' . 'Message' . ' : ' . ucfirst(ucwords($request->input('action_comment')));
                        $comment_object->commentBy = Auth::user()->name;
                        $comment_object->commentTime = $comment_time;
                        $comment_object->id = new ObjectId(Auth::id());
                        $comment_object->date = date('d/m/Y');
                        $comment_array[] = $comment_object;
                        $leadDetails->push('comments', $comment_array);

                        $scheduleStatusObject->status = "Approved";
                        //						$leadDetails->dispatchStatus = 'Delivery';
                        $ScheduleStatus[] = $scheduleStatusObject;
                        if ($leadDetails->scheduleStatus) {
                            LeadDetails::where('_id', new ObjectId($lead_id))->push('scheduleStatus', $ScheduleStatus);
                        } else {
                            $leadDetails->scheduleStatus = $ScheduleStatus;
                        }

                        $leadDetailsDet = LeadDetails::find($lead_id);

                        $lead = $leadDetailsDet['dispatchDetails']['documentDetails'];

                        foreach ($lead as $count => $reply) {
                            if (isset($docID)) {
                                if (in_array($reply['id'], $docID)) {
                                    $this->saveDocumentStatus($lead_id, $count, '11');
                                }
                            }
                        }
                        Session::flash('status', 'Dispatch slip approved successfully');


                        $documents = $leadDetails['dispatchDetails']['documentDetails'];
                        foreach ($documents as $key => $value) {
                            $statusArray[] = $value['DocumentCurrentStatus'];
                        }
                        $this->saveTabStatus($lead_id);

                        $caselink = url('/dispatch/delivery/');
                        $action = "Delivery/Collection";
                        $leadss = "";
                        $leadDetails->save();
                        $this->setDispatchStatus($lead_id);
                        return response()->json(['status' => 'approved']);
                    } else {
                        if ($saveMethod == 'reject_button') {
                            $scheduleStatusObject->status = "Rejected";
                            $leadDetails->schedulerejectstatus = $request->input('message');
                            $scheduleStatusObject->comment = $request->input('message');
                            $ScheduleStatus[] = $scheduleStatusObject;
                            if ($leadDetails->scheduleStatus) {
                                LeadDetails::where('_id', new ObjectId($lead_id))->push(
                                    'scheduleStatus',
                                    $ScheduleStatus
                                );
                            } else {
                                $leadDetails->scheduleStatus = $ScheduleStatus;
                            }

                            $comment_object = new \stdClass();
                            $comment_object->comment = 'Reject from schedule for delivery/collection' . ',' . 'Message' . ' : ' . ucfirst(ucwords($request->input('message')));
                            $comment_object->commentBy = Auth::user()->name;
                            $comment_object->commentTime = $comment_time;
                            $comment_object->id = new ObjectId(Auth::id());
                            $comment_object->date = date('d/m/Y');
                            $comment_array[] = $comment_object;
                            $leadDetails->push('comments', $comment_array);

                            //							dd($docID);
                            //							$leadDetails->dispatchStatus = 'Reception';
                            Session::flash('status', 'Dispatch slip rejected successfully');
                            $leadDetailsDet = LeadDetails::find($lead_id);
                            $lead = $leadDetailsDet['dispatchDetails']['documentDetails'];
                            foreach ($lead as $count => $reply) {
                                if (isset($docID)) {
                                    if (in_array($reply['id'], $docID)) {
                                        $this->saveDocumentStatus($lead_id, $count, '12');
                                    }
                                }
                            }
                            $this->saveTabStatus($request->input('lead_id'));
                            $caselink = url('/dispatch/receptionist-list/');
                            $action = "Schedule for delivery/Collection";
                            $leadss = "";
                            if ($caseemail != '') {
                                SendcasemanagerADleads::dispatch($casename, $caseemail, $referencenumber, $name, $caselink, $saveMethod, $action, $leadss, $custname);
                            }
                            $recp = User::where('isActive', 1)->where('role', "RP")->get();
                            foreach ($recp as $user) {
                                $casename = $user['name'];
                                $caseemail = $user['email'];
                                if ($caseemail != '') {
                                    SendReceptionADleads::dispatch($casename, $caseemail, $referencenumber, $name, $caselink, $saveMethod, $custname);
                                }
                            }
                            $leadDetails->save();
                            $this->setDispatchStatus($lead_id);
                            return response()->json(['status' => 'rejected']);
                        }
                    }
                }
            }

            if ($print != '') {
                $leadDetails->save();
                $pdf = PDF::loadView(
                    'dispatch.pdf.scheduledelivery',
                    ['leadDetails' => $leadDetails, 'print' => $print, 'documentSelectArray' => $docID]
                );
                $pdf_name = 'dispatch-slip_' . time() . '_' . $leadDetails->_id . '.pdf';
                $pdf->setOption('page-width', '200');
                $pdf->setOption('page-height', '260')->inline();
                $temp_path = public_path('pdf/' . $pdf_name);
                $pdf->save('pdf/' . $pdf_name);
                $pdf_file = $this->uploadFileToCloud_file($pdf_name, $temp_path);
                unlink($temp_path);
                $leadDetails->dispatchSlip = $pdf_file;
                $leadDetails->save();
                return response()->json(['success' => 'pdf', 'pdf' => $leadDetails->dispatchSlip]);
            }
        }
    }

    /**
     * delivery listing page
     */
    public function delivery(Request $request)
    {
        if (!empty($request->input('agent'))) {
            $count = 0;
            foreach ($request->input('agent') as $cust) {
                $objectArray[$count] = new ObjectId($cust);
                $count++;
            }
            $agents = User::where('isActive', 1)->where(function ($q) {
                $q->where('role', 'EM')->orWhere('role', 'AG');
            })->whereIn('_id', $objectArray)->get();
        } else {
            $agents = '';
        }

        if (!empty($request->input('assigned'))) {
            $count = 0;
            foreach ($request->input('assigned') as $cust) {
                $objectArray[$count] = new ObjectId($cust);
                $count++;
            }
            $assigned_to = User::where('isActive', 1)->where(function ($q) {
                $q->where('role', 'EM')->orWhere('role', 'AG')->orWhere('role', 'CR')->orWhere('role', 'AD')->orWhere('role', 'MS')->orWhere('role', 'CO')->orWhere('role', 'SV');
            })->whereIn('_id', $objectArray)->get();
        } else {
            $assigned_to = '';
        }

        if (!empty($request->input('customer'))) {
            $count = 0;
            foreach ($request->input('customer') as $cust) {
                $objectArray[$count] = new ObjectId($cust);
                $count++;
            }
            $customers = Customer::whereIn('_id', $objectArray)->get();
            $recepients = RecipientDetails::whereIn('_id', $objectArray)->get();
            $customers = $customers->merge($recepients);
        } else {
            $customers = '';
        }
        //\		$customer_code = [];
        //		foreach ($customers as $customer) {
        //			$customer_code[] = $customer->customerCode;
        //		}
        if (!empty($request->input('case_manager'))) {
            $count = 0;
            foreach ($request->input('case_manager') as $cust) {
                $objectArray[$count] = new ObjectId($cust);
                $count++;
            }
            $case_managers = User::where('isActive', 1)->where(function ($q) {
                $q->where('role', 'EM')->orWhere('role', 'AD')->orWhere('role', 'RP')->orWhere('role', 'AG')->orWhere('role', 'CO')->orWhere('role', 'SV');
            })->whereIn('_id', $objectArray)->get();
        } else {
            $case_managers = '';
        }

        if (!empty($request->input('dispatch'))) {
            $count = 0;
            foreach ($request->input('dispatch') as $cust) {
                $objectArray[$count] = new ObjectId($cust);
                $count++;
            }
            if (
                session('role') == 'Insurer' || session('role') == 'Employee' || session('role') == 'Agent' || session('role') == 'Supervisor' ||
                session('role') == 'Coordinator' || session('role') == 'Courier' || session('role') == 'Messenger' || session('role') == 'Accountant'
            ) {
                $dispatch_type_check = DispatchTypes::where('type', '!=', 'Direct Collections')->whereIn('_id', $objectArray)->get();
            } else {
                $dispatch_type_check = DispatchTypes::whereIn('_id', $objectArray)->get();
            }
        } else {
            $dispatch_type_check = '';
        }
        if (!empty($request->input('delivery'))) {
            $count = 0;
            foreach ($request->input('delivery') as $cust) {
                $objectArray[$count] = new ObjectId($cust);
                $count++;
            }
            $delivery_mode_check = DeliveryMode::whereIn('_id', $objectArray)->get();
        } else {
            $delivery_mode_check = '';
        }
        if (!empty($request->input('status'))) {
            $count = 0;
            foreach ($request->input('status') as $cust) {
                $objectArray[$count] = $cust;
                $count++;
            }
            $Allstatus = DispatchStatus::whereIn('status', $objectArray)->groupBy('status')->get();
        } else {
            $Allstatus = '';
        }
        $delivery_mode = DeliveryMode::all();
        $dispatch_types = DispatchTypes::all();
        $document_types = DocumentType::all();
        $filter_data = $request->input();
        $current_path = $request->path();
        return view('dispatch.delivery_list')
            ->with(compact(
                'customers',
                'agents',
                'case_managers',
                'delivery_mode',
                'dispatch_types',
                'assigned_to',
                'dispatch_type_check',
                'delivery_mode_check',
                'filter_data',
                'document_types',
                'current_path',
                'Allstatus'
            ));
    }

    /**
     * list delivery details
     */
    public function deliveryData(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $filter = $request->input('search');
        $filter_data_en = $request->get('filterData');
        $filter_data = json_decode($filter_data_en);
        $sort = $request->get('field');
        $search = (isset($filter['value'])) ? $filter['value'] : false;
        session()->put('filter', $filter_data_en);
        session()->put('sort', $sort);
        $LeadDetails = LeadDetails::where('active', 1)->where('deliveryTabStatus', (int) 1);

        //	     $LeadDetails = LeadDetails::where('active', 1)->whereIn('dispatchStatus',array('Delivery','reschedule_same','Incomplete'));

        if (session('role') == 'Employee') {
            $LeadDetails = $LeadDetails->where(function ($q) {
                $q->where('caseManager.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('agent.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('employee.id', new ObjectID(Auth::user()->_id));
            });
        } elseif (session('role') == 'Agent') {
            $LeadDetails = $LeadDetails->where(function ($q) {
                $q->where('agent.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('caseManager.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('employee.id', new ObjectID(Auth::user()->_id));
            });
        } elseif (session('role') == 'Coordinator') {
            $LeadDetails = $LeadDetails->where(function ($q) {
                $q->where('agent.id', session('assigned_agent'))
                    ->orwhere('agent.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('employee.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('employee.id', session('assigned_agent'));
            });
        } elseif (session('role') == 'Supervisor') {
            $LeadDetails = $LeadDetails->where(function ($q) {
                $q->where('agent.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('caseManager.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('employee.id', new ObjectID(Auth::user()->_id))
                    ->orwhereIn('employee.id', session('employees'));
            });
        } elseif (session('role') != 'Admin' && session('role') != 'Receptionist') {
            $LeadDetails = $LeadDetails->where('employee.id', new ObjectID(Auth::user()->_id));
        }

        if (!empty($filter_data)) {
            if (!empty($filter_data->agent)) {
                $count = 0;
                foreach ($filter_data->agent as $agent) {
                    $objectArray[$count] = new ObjectId($agent);
                    $count++;
                }
                $LeadDetails = $LeadDetails->whereIn('agent.id', $objectArray);
            }
            if (!empty($filter_data->case_manager)) {
                $count = 0;
                foreach ($filter_data->case_manager as $manager) {
                    $objectArray[$count] = new ObjectId($manager);
                    $count++;
                }
                $LeadDetails = $LeadDetails->whereIn('caseManager.id', $objectArray);
            }
            if (!empty($filter_data->customer)) {
                $count = 0;
                foreach ($filter_data->customer as $cust) {
                    $objectArray[$count] = new ObjectId($cust);
                    $count++;
                }
                $LeadDetails = $LeadDetails->whereIn('customer.id', $objectArray);
            }
            if (!empty($filter_data->delivery)) {
                $count = 0;
                foreach ($filter_data->delivery as $mode) {
                    $objectArray[$count] = new ObjectId($mode);
                    $count++;
                }
                $LeadDetails = $LeadDetails->whereIn('deliveryMode.id', $objectArray);
            }
            if (!empty($filter_data->dispatch)) {
                $count = 0;
                foreach ($filter_data->dispatch as $type) {
                    $objectArray[$count] = new ObjectId($type);
                    $count++;
                }
                $LeadDetails = $LeadDetails->whereIn('dispatchType.id', $objectArray);
            }
            if (!empty($filter_data->assigned)) {
                $count = 0;
                foreach ($filter_data->assigned as $type) {
                    $objectArray[$count] = new ObjectId($type);
                    $count++;
                }
                $LeadDetails = $LeadDetails->whereIn('employee.id', $objectArray);
            }
            if (!empty($filter_data->status)) {
                $count = 0;
                foreach ($filter_data->status as $stat) {
                    $objectArray[$count] = $stat;
                    $count++;
                }
                $LeadDetails = $LeadDetails->whereIn('dispatchStatus', $objectArray);
            }
        }

        if (!empty($sort)) {
            if ($sort == "Customer Name") {
                $LeadDetails = $LeadDetails->orderBy('customer.name');
            } elseif ($sort == "Agent") {
                $LeadDetails = $LeadDetails->orderBy('agent.name');
            } elseif ($sort == "Case Manager") {
                $LeadDetails = $LeadDetails->orderBy('caseManager.name');
            } elseif ($sort == "Dispatch Type") {
                $LeadDetails = $LeadDetails->orderBy('dispatchType.dispatchType');
            } elseif ($sort == "Delivery Mode") {
                $LeadDetails = $LeadDetails->orderBy('deliveryMode.deliveryMode');
            }
        } elseif (empty($sort)) {
            $LeadDetails = $LeadDetails->orderBy(
                'created_at',
                'DESC'
            );
        }
        if ($search) {
            $LeadDetails = $LeadDetails->where(function ($query) use ($search) {
                $query->Where('referenceNumber', 'like', '%' . $search . '%')
                    ->orWhere('customer.name', 'like', '%' . $search . '%')
                    ->orWhere('customer.recipientName', 'like', '%' . $search . '%')
                    ->orWhere('customer.customerCode', 'like', '%' . $search . '%')
                    ->orWhere('agent.name', 'like', '%' . $search . '%')
                    ->orWhere('caseManager.name', 'like', '%' . $search . '%')
                    ->orWhere('contactNumber', 'like', '%' . $search . '%')
                    ->orWhere('dispatchStatus', 'like', '%' . $search . '%')
                    ->orWhere('deliveryMode.deliveryMode', 'like', '%' . $search . '%')
                    ->orWhere('dispatchType.dispatchType', 'like', '%' . $search . '%');
            });


            session()->put('search', $search);
        }
        if ($search == "") {
            $LeadDetails = $LeadDetails;
            session()->put('search', "");
        }

        $searchField = $request->get('searchField');
        if ($searchField != "") {
            $LeadDetails = $LeadDetails->where(function ($query) use ($searchField) {
                $query->Where('referenceNumber', 'like', '%' . $searchField . '%')
                    ->orWhere('customer.name', 'like', '%' . $searchField . '%')
                    ->orWhere('customer.recipientName', 'like', '%' . $searchField . '%')
                    ->orWhere('customer.customerCode', 'like', '%' . $searchField . '%')
                    ->orWhere('agent.name', 'like', '%' . $searchField . '%')
                    ->orWhere('caseManager.name', 'like', '%' . $searchField . '%')
                    ->orWhere('contactNumber', 'like', '%' . $searchField . '%')
                    ->orWhere('dispatchStatus', 'like', '%' . $searchField . '%')
                    ->orWhere('deliveryMode.deliveryMode', 'like', '%' . $searchField . '%')
                    ->orWhere('dispatchType.dispatchType', 'like', '%' . $searchField . '%');
            });
        }
        $total_leads = $LeadDetails->count(); // get your total no of data;
        $members_query = $LeadDetails;
        $search_count = $members_query->count();
        $LeadDetails->skip((int) $start)->take((int) $length);
        $final_leads = $LeadDetails->get();
        $empID=session('employees')?: [];
        array_push($empID, new ObjectId(Auth::user()->_id));
        session(['employees_idCheck' => $empID]);

        foreach ($final_leads as $leads) {
            $check = '<div class="custom_checkbox">' .
                '<input type="checkbox" name="marked_list[]" class="inp-cbx check" id="' . $leads->_id . '" style="display: none"  onchange="markedCheck(this.id)">' .
                '<label for="' . $leads->_id . '" class="cbx">' .
                '<span>' .
                '    <svg width="10px" height="8px" viewBox="0 0 12 10">' .
                '      <polyline points="1.5 6 4.5 9 10.5 1"></polyline>' .
                '    </svg>' .
                '</span>' .
                '<span></span>' .
                '</label>' .
                '</div>';
            if ((session('role') == 'Employee' && Auth::user()->_id != @$leads->employee['id']) || (session('role') == 'Agent' && Auth::user()->_id != @$leads->employee['id'])
                || (session('role') == 'Coordinator' && session('assigned_agent') != @$leads->employee['id']) || (session('role') == 'Supervisor' && !in_array(@$leads->employee['id'], session('employees_idCheck')))
            ) {
                $check = '<div class="custom_checkbox">' .
                    '<input  type="checkbox" name="marked_list[]" disabled class="inp-cbx check" id="' . $leads->_id . '" style="display: none"  onchange="markedCheck(this.id)">' .
                    '<label for="' . $leads->_id . '" class="cbx" style="cursor: auto;">' .
                    '<span>' .
                    '    <svg width="10px" height="8px" viewBox="0 0 12 10">' .
                    '      <polyline points="1.5 6 4.5 9 10.5 1"></polyline>' .
                    '    </svg>' .
                    '</span>' .
                    '    <span></span>' .
                    '</label>' .
                    '</div>';
            }
            if ($leads['referenceNumber'] == '') {
                $referenceNumber = '--';
            } else {
                $referenceNumber = '<a href="#" class="auto_modal table_link" data-toggle="tooltip" data-placement="bottom" title="View Dispatch Slip" data-container="body"  data-modal="view_lead_popup" dir="' . $leads->_id . '" onclick="view_lead_popup(\'' . $leads->_id . '\');">

' . $leads['referenceNumber'] . '  </a> ';
            }
            if (isset($leads->agent['name'])) {
                $agentname = ucwords(strtolower($leads->agent['name']));
                if (isset($leads->agent['empid'])) {
                    if ($leads->agent['empid'] != "") {
                        $agentid = $leads->agent['empid'];
                        $agentvalue = $agentname . ' (' . $agentid . ')';
                    } else {
                        $agentvalue = $agentname;
                    }
                } else {
                    $agentvalue = $agentname;
                }
            } else {
                $agentvalue = 'NA';
            }
            $agent = $agentvalue;
            $caseManager = ucwords(strtolower($leads['caseManager.name']));
            $email = $leads->contactEmail;
            $contact = $leads->contactNumber;
            $recipientName = ucwords(strtolower($leads['customer.recipientName']));
            $dispatchType = $leads['dispatchType.dispatchType'];
            $deliveryMode = $leads['deliveryMode.deliveryMode'];
            $code = $leads['customer.customerCode'] ?: '--';
            $customerName = ucwords(strtolower($leads['customer.name']));
            $created_at = $leads->created_at;
            if (isset($leads->employee['name'])) {
                $assignname = ucwords(strtolower($leads->employee['name']));
                if (isset($leads->employee['empId'])) {
                    if ($leads->employee['empId'] != "") {
                        $assignid = $leads->employee['empId'];
                        $assignvalue = $assignname . ' (' . $assignid . ')';
                    } else {
                        $assignvalue = $assignname;
                    }
                } else {
                    $assignvalue = $assignname;
                }
            } else {
                $assignvalue = '--';
            }
            //			if ($leads['dispatchType.dispatchType'] == 'Delivery' && $leads->dispatchStatus == 'Delivery') {
            //				$status = 'Delivery';
            //			} elseif ($leads['dispatchType.dispatchType'] == 'Collections' && $leads->dispatchStatus == 'Delivery') {
            //				$status = 'Collection';
            //			} elseif ($leads['dispatchType.dispatchType'] == 'Delivery & Collections' && $leads->dispatchStatus == 'Delivery') {
            //				$status = 'Delivery and Collection';
            //			} elseif ($leads->dispatchStatus == 'reschedule_same') {
            //				$status = 'Rescheduled to same day';
            //			} elseif ($leads->dispatchStatus == 'Incomplete') {
            //				$status = 'Incomplete Data';
            //			} else {
            //				$status = $leads->dispatchStatus;
            //			}
            if ($leads['dispatchStatus'] == '') {
                $status = '--';
            } else {
                $status = '<a href="#">

<span data-toggle="tooltip" data-placement="bottom" title="Assigned to : ' . $assignvalue . '"  data-container="body" > ' . $leads['dispatchStatus'] . ' </span>  ';
            }
            $leads->checkall = $check;
            $leads->customerCode = $code;
            $leads->referenceNumber = $referenceNumber;
            $leads->customerName = $customerName;
            $leads->recipientName = $recipientName;
            $leads->contactNo = $contact;
            $leads->email = $email;
            $leads->caseManager = $caseManager;
            $leads->agent = $agent;
            $leads->dispatchType = $dispatchType;
            $leads->deliveryMode = $deliveryMode;
            $leads->status = $status;
            $leads->assigned = $assignvalue;
            $leads->created = Carbon::parse($created_at)->format('d/m/Y');
            if (session('role') == 'Admin') {
                $delete_button = '<button class="btn export_btn waves-effect auto_modal delete_icon_btn" type="button" data-toggle="tooltip" data-placement="bottom" title="Delete" data-container="body"  data-modal="delete_popup" dir="' . $leads->_id . '" onclick="delete_pop(this);">
<i class="material-icons">delete_outline</i>
</button>';
                $leads->delete_button = $delete_button;
            } else {
                $leads->delete_button = "";
            }
        }
        if ($search) {
            $filtered_count = $search_count;
        } else {
            $filtered_count = $total_leads;
        }


        $data = array(
            'draw' => $draw,
            'recordsTotal' => $total_leads,
            'recordsFiltered' => $filtered_count,
            'data' => $final_leads,
        );

        return json_encode($data);
    }

    /**
     * export delivery list
     */
    public function exportDeliveryList(Request $request)
    {
        ini_set('xdebug.max_nesting_level', 500);

        $email = $request->input('email');
        $filter_data = json_decode(session('filter'));
        $sort = session('sort');
        $search = session('search');
        $leadDetails = LeadDetails::where('active', 1)->where('deliveryTabStatus', (int) 1);
        if (session('role') == 'Employee') {
            $leadDetails = $leadDetails->where(function ($q) {
                $q->where('caseManager.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('agent.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('employee.id', new ObjectID(Auth::user()->_id));
            });
        } elseif (session('role') == 'Agent') {
            $leadDetails = $leadDetails->where(function ($q) {
                $q->where('agent.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('caseManager.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('employee.id', new ObjectID(Auth::user()->_id));
            });
        } elseif (session('role') == 'Coordinator') {
            $leadDetails = $leadDetails->where(function ($q) {
                $q->where('agent.id', session('assigned_agent'))
                    ->orwhere('agent.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('employee.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('employee.id', session('assigned_agent'));
            });
        } elseif (session('role') == 'Supervisor') {
            $leadDetails = $leadDetails->where(function ($q) {
                $q->where('agent.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('caseManager.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('employee.id', new ObjectID(Auth::user()->_id))
                    ->orwhereIn('employee.id', session('employees'));
            });
        } elseif (session('role') != 'Admin' && session('role') != 'Receptionist') {
            $leadDetails = $leadDetails->where('employee.id', new ObjectID(Auth::user()->_id));
        }

        if (!empty($filter_data)) {
            if (!empty($filter_data->agent)) {
                $count = 0;
                foreach ($filter_data->agent as $agent) {
                    $objectArray[$count] = new ObjectId($agent);
                    $count++;
                }
                $leadDetails = $leadDetails->whereIn('agent.id', $objectArray);
            }
            if (!empty($filter_data->case_manager)) {
                $count = 0;
                foreach ($filter_data->case_manager as $manager) {
                    $objectArray[$count] = new ObjectId($manager);
                    $count++;
                }
                $leadDetails = $leadDetails->whereIn('caseManager.id', $objectArray);
            }
            if (!empty($filter_data->customer)) {
                $count = 0;
                foreach ($filter_data->customer as $cust) {
                    $objectArray[$count] = new ObjectId($cust);
                    $count++;
                }
                $leadDetails = $leadDetails->whereIn('customer.id', $objectArray);
            }
            if (!empty($filter_data->delivery)) {
                $count = 0;
                foreach ($filter_data->delivery as $mode) {
                    $objectArray[$count] = new ObjectId($mode);
                    $count++;
                }
                $leadDetails = $leadDetails->whereIn('deliveryMode.id', $objectArray);
            }
            if (!empty($filter_data->dispatch)) {
                $count = 0;
                foreach ($filter_data->dispatch as $type) {
                    $objectArray[$count] = new ObjectId($type);
                    $count++;
                }
                $leadDetails = $leadDetails->whereIn('dispatchType.id', $objectArray);
            }
            if (!empty($filter_data->assigned)) {
                $count = 0;
                foreach ($filter_data->assigned as $type) {
                    $objectArray[$count] = new ObjectId($type);
                    $count++;
                }
                $leadDetails = $leadDetails->whereIn('employee.id', $objectArray);
            }
            if (!empty($filter_data->status)) {
                $count = 0;
                foreach ($filter_data->status as $stat) {
                    $objectArray[$count] = $stat;
                    $count++;
                }
                $leadDetails = $leadDetails->whereIn('dispatchStatus', $objectArray);
            }
        }


        if (!empty($sort)) {
            if ($sort == "Customer Name") {
                //				$leadDetails = $leadDetails->where('active', 1)->whereIn('dispatchStatus',
                //					array('Delivery', 'reschedule_same', 'Incomplete'))->orderBy('customer.name');
                $leadDetails = $leadDetails->orderBy('customer.name');
            } elseif ($sort == "Agent") {
                //				$leadDetails = $leadDetails->where('active', 1)->whereIn('dispatchStatus',
                //					array('Delivery', 'reschedule_same', 'Incomplete'))->orderBy('agent.name');
                $leadDetails = $leadDetails->orderBy('agent.name');
            } elseif ($sort == "Case Manager") {
                //				$leadDetails = $leadDetails->where('active', 1)->whereIn('dispatchStatus',
                //					array('Delivery', 'reschedule_same', 'Incomplete'))->orderBy('caseManager.name');
                $leadDetails = $leadDetails->orderBy('caseManager.name');
            } elseif ($sort == "Dispatch Type") {
                //				$leadDetails = $leadDetails->where('active', 1)->whereIn('dispatchStatus',
                //					array('Delivery', 'reschedule_same', 'Incomplete'))->orderBy('dispatchType.dispatchType');
                $leadDetails = $leadDetails->orderBy('dispatchType.dispatchType');
            } elseif ($sort == "Delivery Mode") {
                //				$leadDetails = $leadDetails->where('active', 1)->whereIn('dispatchStatus',
                //					array('Delivery', 'reschedule_same', 'Incomplete'))->orderBy('deliveryMode.deliveryMode');
                $leadDetails = $leadDetails->orderBy('deliveryMode.deliveryMode');
            }
        } elseif (empty($sort)) {
            //			$leadDetails = $leadDetails->where('active', 1)->whereIn('dispatchStatus',
            //				array('Delivery', 'reschedule_same', 'Incomplete'))->orderBy('created_at', 'DESC');
            $leadDetails = $leadDetails->orderBy('created_at', 'DESC');
        }

        if ($search) {
            $leadDetails = $leadDetails->where(function ($query) use ($search) {
                $query->Where('referenceNumber', 'like', '%' . $search . '%')
                    ->orWhere('customer.name', 'like', '%' . $search . '%')
                    ->orWhere('customer.recipientName', 'like', '%' . $search . '%')
                    ->orWhere('customer.customerCode', 'like', '%' . $search . '%')
                    ->orWhere('agent.name', 'like', '%' . $search . '%')
                    ->orWhere('caseManager.name', 'like', '%' . $search . '%')
                    ->orWhere('contactNumber', 'like', '%' . $search . '%')
                    ->orWhere('contactEmail', 'like', '%' . $search . '%')
                    ->orWhere('deliveryMode.deliveryMode', 'like', '%' . $search . '%')
                    ->orWhere('dispatchType.dispatchType', 'like', '%' . $search . '%');
            });
            session()->put('search', $search);
        }
        $leadDetails = $leadDetails->select('customer', 'created_at', 'contactNumber', 'contactEmail', 'referenceNumber', 'deliveryMode', 'dispatchType', 'employee', 'agent', 'dispatchDetails.land_mark', 'dispatchDetails.documentDetails');

        $data[] = array('Delivery List');
        $excel_header = [
            'CID',
            'CUSTOMER NAME',
            'LEAD CREATED DATE',
            'REFERENCE NUMBER',
            'DISPATCH TYPE',
            'TYPE OF DOCUMENT',
            'TYPE OF DELIVERY',
            'AMOUNT / CARDS',
            'CUSTOMER CONTACT NUMBER',
            'CUSTOMER EMAIL ID',
            'RECIPIENT NAME',
            'AGENT NAME',
            'DELIVERY MODE',
            'ASSIGNED TO',
            'LAND MARK',
            'DOCUMENT DESCRIPTION'
        ];
        $file_name_ = 'Delivery List' . rand();
        Excel::create($file_name_, function ($excel) use ($leadDetails, $excel_header) {
            $excel->sheet('Delivery list', function ($sheet) use ($leadDetails, $excel_header) {
                $sheet->appendRow($excel_header);
                $sheet->row(1, function ($row) {
                    $row->setFontSize(10);
                    $row->setFontColor('#ffffff');
                    $row->setBackground('#1155CC');
                });
                $leadDetails->chunk(100, function ($final_leads) use ($sheet) {
                    foreach ($final_leads as $leads) {
                        $createdDate = $leads->created_at;
                        $date = date("d/m/Y", strtotime($createdDate));
                        if (isset($leads->employee['name'])) {
                            $assignname = ucwords(strtolower($leads->employee['name']));
                            if (isset($leads->employee['empId'])) {
                                if ($leads->employee['empId'] != "") {
                                    $assignid = $leads->employee['empId'];
                                    $assignvalue = $assignname . ' (' . $assignid . ')';
                                } else {
                                    $assignvalue = $assignname;
                                }
                            } else {
                                $assignvalue = $assignname;
                            }
                        } else {
                            $assignvalue = '--';
                        }
                        if (isset($leads->agent['name'])) {
                            $agentname = ucwords(strtolower($leads->agent['name']));
                            if (isset($leads->agent['empid'])) {
                                if ($leads->agent['empid'] != "") {
                                    $agentid = $leads->agent['empid'];
                                    $agentvalue = ucwords(strtolower($agentname)) . ' (' . $agentid . ')';
                                } else {
                                    $agentvalue = ucwords(strtolower($agentname));
                                }
                            } else {
                                $agentvalue = ucwords(strtolower($agentname));
                            }
                        } else {
                            $agentvalue = 'NA';
                        }
                        if (isset($leads->contactNumber)) {
                            $contact = $leads->contactNumber;
                        } else {
                            $contact = '--';
                        }
                        if (isset($leads->contactEmail)) {
                            $contactEmail = $leads->contactEmail;
                        } else {
                            $contactEmail = '--';
                        }
                        if (isset($leads['dispatchType.dispatchType'])) {
                            $disType = $leads['dispatchType.dispatchType'];
                        } else {
                            $disType = '--';
                        }
                        if (isset($leads['deliveryMode.deliveryMode'])) {
                            $disMode = $leads['deliveryMode.deliveryMode'];
                        } else {
                            $disMode = '--';
                        }
                        if (isset($leads['customer.customerCode'])) {
                            $custCode = $leads['customer.customerCode'];
                        } else {
                            $custCode = '--';
                        }
                        if (isset($leads['customer.name'])) {
                            $custName = $leads['customer.name'];
                        } else {
                            $custName = '--';
                        }
                        if (isset($leads['customer.recipientName'])) {
                            $recName = $leads['customer.recipientName'];
                        } else {
                            $recName = '--';
                        }
                        if (isset($leads['dispatchDetails.land_mark'])) {
                            $land = $leads['dispatchDetails.land_mark'];
                        } else {
                            $land = '--';
                        }
                        if (isset($leads['dispatchDetails']['documentDetails'])) {
                            $leadDocuments = $leads['dispatchDetails']['documentDetails'];
                            foreach ($leadDocuments as $count => $reply) {
                                if ($reply['DocumentCurrentStatus'] == '3' || $reply['DocumentCurrentStatus'] == '11') {
                                    $data = array(
                                        $custCode ?: '--',
                                        ucwords(strtolower($custName)),
                                        $date,
                                        $leads['referenceNumber'],
                                        $disType,
                                        $reply['documentName'],
                                        $disMode,
                                        $reply['amount'] ?: '--',
                                        $contact,
                                        $contactEmail,
                                        ucwords(strtolower($recName)),
                                        $agentvalue,
                                        $disMode,
                                        $assignvalue,
                                        $land ?: '--',
                                        $reply['documentDescription'] ?: '--'
                                    );
                                    $sheet->appendRow($data);
                                }
                            }
                        } else {
                            $data = array(
                                $custCode ?: '--',
                                ucwords(strtolower($custName)),
                                $date,
                                $leads['referenceNumber'],
                                $disType,
                                '--',
                                $disMode,
                                '--',
                                $contact,
                                $contactEmail,
                                ucwords(strtolower($recName)),
                                $agentvalue,
                                $disMode,
                                $assignvalue,
                                $land ?: '--',
                                '--'
                            );
                            $sheet->appendRow($data);
                        }
                        //
                    }
                });
            });
        })->store('xls', public_path('excel'));
        $excel_name = $file_name_ . '.' . 'xls';
        $send_excel = public_path('/excel/' . $excel_name);
        //		dd($send_excel);
        $tab_value = 'delivery';
        sendExcel::dispatch($email, $send_excel, $tab_value);
        //		Session::flash('status', 'Excel send to '. $email );
        return 'success';
    }


    /**
     * function for upload to cloud
     */
    public static function uploadToCloud($file)
    {
        $extension = $file->getClientOriginalExtension();
        $fileName = time() . uniqid() . '.' . $extension;
        $filePath = "/" . $fileName;
        $disk = Storage::disk('s3');
        $disk->put($filePath, fopen($file, 'r+'), 'public'); //uploading as streams, useful for large uploads.
        $file_url = 'https://s3-' . Config::get('filesystems.disks.s3.region') . '.amazonaws.com/' . Config::get('filesystems.disks.s3.bucket') . '/' . $fileName;
        return $file_url;
    }

    /**
     * save delivery form
     */
    public function saveDeliveryForm(Request $request)
    {
        $statusArray = [];
        $lead_id = $request->input('lead_id');
        $leadDetails = LeadDetails::find($lead_id);
        $value = $request->input('docid');
        $doc_collected_amount = $request->input('doc_collected_amount');
        $saveMethod = $request->input('save_method');
        $upload_sign = $request->file('upload_sign');
        if ($upload_sign) {
            $upload = $this->uploadToCloud($upload_sign);
        } else {
            $upload = '';
        }
        date_default_timezone_set('Asia/Dubai');
        $comment_time = date('H:i:s');
        $deliveryStatus = [];
        $dispatchDetails = LeadDetails::find($lead_id);
        $leadSubmitStatus = 0;
        $leadRejectStatus = 0;
        if ($saveMethod) {
            $updatedBy_obj = new \stdClass();
            $updatedBy_obj->id = new ObjectID(Auth::id());
            $updatedBy_obj->name = Auth::user()->name;
            $updatedBy_obj->date = date('d/m/Y');
            $updatedBy_obj->action = "Delivery";
            $updatedBy[] = $updatedBy_obj;
            LeadDetails::where('_id', new ObjectId($lead_id))->push('updatedBy', $updatedBy);
            $deliveryStatusObject = new \stdClass();
            $deliveryStatusObject->id = new ObjectID(Auth::id());
            $deliveryStatusObject->name = Auth::user()->name;
            $deliveryStatusObject->date = date('d/m/Y');
            $name = $deliveryStatusObject->name;
            $action = $request->input('action');
            $conceptName = $request->input('cust');
            $deliverd_date = $request->input('preferred_date');
            $remarks = $request->input('remarks');
            $docname = $request->input('docName');
            if ($action) {
                foreach ($action as $key => $value1) {
                    if ($action[$key] == 'deliveryid') {
                        $deliveryStatusObject->status = "Delivered";
                        $deliveryStatusObject->uploadFrom = 'delivery web';
                        $deliveryStatus[] = $deliveryStatusObject;
                        if ($leadDetails->deliveryStatus) {
                            LeadDetails::where('_id', new ObjectId($lead_id))->push('deliveryStatus', $deliveryStatus);
                        } else {
                            $leadDetails->deliveryStatus = $deliveryStatus;
                        }
                        $leads = $leadDetails['dispatchDetails']['documentDetails'];
                        foreach ($leads as $count => $reply) {
                            if ($reply['id'] == $value[$key]) {
                                if (isset($doc_collected_amount[$key])) {
                                    $keyAmount = $doc_collected_amount[$key];
                                } else {
                                    $keyAmount = 'NA';
                                }
                                LeadDetails::where(
                                    '_id',
                                    new ObjectId($lead_id)
                                )->update(array('dispatchDetails.documentDetails.' . $count . '.status' => 1, 
                                'dispatchDetails.documentDetails.' . $count . '.dispatchStatus' => "Delivered",
                                'dispatchDetails.documentDetails.' . $count . '.gostatus' => 1,
                                'dispatchDetails.documentDetails.' . $count . '.signUpload' => $upload,
                                'dispatchDetails.documentDetails.' . $count . '.doc_collected_amount' => $keyAmount
                                ));
                                $this->saveDocumentStatus($lead_id, $count, '2');
                            }
                        }
                        $leadSubmitStatus = 1;
                        $leadDetails->save();
                    } else {
                        if ($action[$key] == 'notdelivertryid') {
                            $comment_array = [];
                            if ($conceptName[$key] == "Scheduled for same day") {
                                $deliveryStatusObject->status = "reschedule_same";
                                $deliveryStatusObject->uploadFrom = 'delivery web';
                                $deliveryStatus[] = $deliveryStatusObject;
                                if ($leadDetails->deliveryStatus) {
                                    LeadDetails::where('_id', new ObjectId($lead_id))->push('deliveryStatus', $deliveryStatus);
                                } else {
                                    $leadDetails->deliveryStatus = $deliveryStatus;
                                }
                                if ($leadDetails->dispatchType['dispatchType'] == 'Collections') {
                                    Session::flash('status', 'Collection rescheduled same day');
                                } else {
                                    if ($leadDetails->dispatchType['dispatchType'] == 'Delivery') {
                                        Session::flash('status', 'Delivery rescheduled same day');
                                    }
                                }
                                $comment_object = new \stdClass();
                                $comment_object->docId = $value[$key];
                                $comment_object->comment = 'Document Name' . ' : ' . $docname[$key] . ' , ' . 'Action' . ' : ' . $conceptName[$key]  . ' , ' . 'Remarks' . ' : ' . ucfirst(ucwords($remarks[$key]));
                                $comment_object->commentBy = Auth::user()->name;
                                $comment_object->commentTime = $comment_time;
                                $comment_object->id = new ObjectId(Auth::id());
                                $comment_object->date = date('d/m/Y');
                                $comment_array[] = $comment_object;
                                $dispatchDetails->push('comments', $comment_array);
                                $updatedBy_obj = new \stdClass();
                                $updatedBy_obj->id = new ObjectID(Auth::id());
                                $updatedBy_obj->name = Auth::user()->name;
                                $updatedBy_obj->date = date('d/m/Y');
                                $updatedBy_obj->action = "Commented";
                                $updatedBy[] = $updatedBy_obj;
                                $dispatchDetails->push('updatedBy', $updatedBy);
                                $dispatchDetails->save();
                                $leads = $leadDetails['dispatchDetails']['documentDetails'];
                                foreach ($leads as $count => $reply) {
                                    if ($reply['id'] == $value[$key]) {
                                        if (isset($doc_collected_amount[$key])) {
                                            $keyAmount = $doc_collected_amount[$key];
                                        } else {
                                            $keyAmount = 'NA';
                                        }
                                        LeadDetails::where(
                                            '_id',
                                            new ObjectId($lead_id)
                                        )->update(array('dispatchDetails.documentDetails.' . $count . '.status' => 2,
                                        'dispatchDetails.documentDetails.' . $count . '.remarks' => $remarks[$key],
                                        'dispatchDetails.documentDetails.' . $count . '.dispatchStatus' => "reschedule_same",
                                        'dispatchDetails.documentDetails.' . $count . '.gostatus' => 2,
                                        'dispatchDetails.documentDetails.' . $count . '.doc_collected_amount' => $keyAmount
                                        ));
                                        $this->saveDocumentStatus($lead_id, $count, '3');
                                    }
                                }
                                $leadDetails->save();
                            } elseif ($conceptName[$key] == "Scheduled for another day") {
                                $comment_array1 = [];
                                $deliveryStatusObject->status = "reschedule_another";
                                $deliveryStatusObject->uploadFrom = 'delivery web';
                                $deliveryStatusObject->preferred_date = $deliverd_date[$key];
                                $deliveryStatus[] = $deliveryStatusObject;
                                if ($leadDetails->deliveryStatus) {
                                    LeadDetails::where('_id', new ObjectId($lead_id))->push('deliveryStatus', $deliveryStatus);
                                } else {
                                    $leadDetails->deliveryStatus = $deliveryStatus;
                                }
                                if ($leadDetails->dispatchType['dispatchType'] == 'Collections') {
                                    Session::flash('status', 'Collection rescheduled another day');
                                } else {
                                    if ($leadDetails->dispatchType['dispatchType'] == 'Delivery') {
                                        Session::flash('status', 'Delivery rescheduled another day');
                                    }
                                }
                                $comment_object = new \stdClass();
                                $comment_object->docId = $value[$key];
                                $comment_object->comment = 'Document Name' . ' : ' . $docname[$key] . ' , ' . 'Action' . ' : ' . $conceptName[$key] . ' , ' . 'Remarks' . ' : ' . ucfirst(ucwords($remarks[$key]));
                                $comment_object->commentBy = Auth::user()->name;
                                $comment_object->commentTime = $comment_time;
                                $comment_object->id = new ObjectId(Auth::id());
                                $comment_object->date = date('d/m/Y');
                                $comment_array1[] = $comment_object;
                                $dispatchDetails->push('comments', $comment_array1);
                                $updatedBy_obj = new \stdClass();
                                $updatedBy_obj->id = new ObjectID(Auth::id());
                                $updatedBy_obj->name = Auth::user()->name;
                                $updatedBy_obj->date = date('d/m/Y');
                                $updatedBy_obj->action = "Commented";
                                $updatedBy[] = $updatedBy_obj;
                                $dispatchDetails->push('updatedBy', $updatedBy);
                                $dispatchDetails->save();
                                $leads = $leadDetails['dispatchDetails']['documentDetails'];
                                foreach ($leads as $count => $reply) {
                                    if ($reply['id'] == $value[$key]) {
                                        if (isset($doc_collected_amount[$key])) {
                                            $keyAmount = $doc_collected_amount[$key];
                                        } else {
                                            $keyAmount = 'NA';
                                        }
                                        LeadDetails::where(
                                            '_id',
                                            new ObjectId($lead_id)
                                        )->update(array('dispatchDetails.documentDetails.' . $count . '.status' => 4,
                                        'dispatchDetails.documentDetails.' . $count . '.remarks' => $remarks[$key],
                                        'dispatchDetails.documentDetails.' . $count . '.dispatchStatus' => "reschedule_another",
                                        'dispatchDetails.documentDetails.' . $count . '.gostatus' => 1,
                                        'dispatchDetails.documentDetails.' . $count . '.doc_collected_amount' => $keyAmount
                                        ));
                                        $this->saveDocumentStatus($lead_id, $count, '4');
                                    }
                                }
                                $leadDetails->save();
                            } elseif ($conceptName[$key] == "Could not contact") {
                                $comment_array2 = [];
                                $deliveryStatusObject->uploadFrom = 'delivery web';
                                $deliveryStatusObject->status = "not_contact";
                                $deliveryStatus[] = $deliveryStatusObject;
                                $comment_object = new \stdClass();
                                $comment_object->docId = $value[$key];
                                $comment_object->comment = 'Document Name' . ' : ' . $docname[$key] . ' , ' . 'Action' . ' : ' . $conceptName[$key] . ' , ' . 'Remarks' . ' : ' . ucfirst(ucwords($remarks[$key]));
                                $comment_object->commentBy = Auth::user()->name;
                                $comment_object->commentTime = $comment_time;
                                $comment_object->id = new ObjectId(Auth::id());
                                $comment_object->date = date('d/m/Y');
                                $comment_array2[] = $comment_object;
                                $dispatchDetails->push('comments', $comment_array2);
                                $updatedBy_obj = new \stdClass();
                                $updatedBy_obj->id = new ObjectID(Auth::id());
                                $updatedBy_obj->name = Auth::user()->name;
                                $updatedBy_obj->date = date('d/m/Y');
                                $updatedBy_obj->action = "Commented";
                                $updatedBy[] = $updatedBy_obj;
                                $dispatchDetails->push('updatedBy', $updatedBy);
                                $dispatchDetails->save();
                                if ($leadDetails->deliveryStatus) {
                                    LeadDetails::where('_id', new ObjectId($lead_id))->push('deliveryStatus', $deliveryStatus);
                                } else {
                                    $leadDetails->deliveryStatus = $deliveryStatus;
                                }
                                Session::flash(
                                    'status',
                                    'Unsuccessful attempt, Impossible to contact customer for information'
                                );
                                $leads = $leadDetails['dispatchDetails']['documentDetails'];
                                foreach ($leads as $count => $reply) {
                                    if ($reply['id'] == $value[$key]) {
                                        if (isset($doc_collected_amount[$key])) {
                                            $keyAmount = $doc_collected_amount[$key];
                                        } else {
                                            $keyAmount = 'NA';
                                        }
                                        LeadDetails::where(
                                            '_id',
                                            new ObjectId($lead_id)
                                        )->update(array('dispatchDetails.documentDetails.' . $count . '.status' => 6,
                                        'dispatchDetails.documentDetails.' . $count . '.remarks' => $remarks[$key],
                                        'dispatchDetails.documentDetails.' . $count . '.dispatchStatus' => "not_contact",
                                        'dispatchDetails.documentDetails.' . $count . '.gostatus' => 1,
                                        'dispatchDetails.documentDetails.' . $count . '.doc_collected_amount' => $keyAmount
                                        ));
                                        $this->saveDocumentStatus($lead_id, $count, '5');
                                    }
                                }
                                $leadDetails->save();
                            }
                            $leadRejectStatus = 1;
                        } else {
                            if ($action[$key] == 'cancelid') {
                                $deliveryStatusObject->status = "Canceled";
                                $deliveryStatusObject->uploadFrom = 'delivery web';
                                $deliveryStatus[] = $deliveryStatusObject;
                                if ($leadDetails->deliveryStatus) {
                                    LeadDetails::where('_id', new ObjectId($lead_id))->push('deliveryStatus', $deliveryStatus);
                                } else {
                                    $leadDetails->deliveryStatus = $deliveryStatus;
                                }
                                $leads = $leadDetails['dispatchDetails']['documentDetails'];
                                foreach ($leads as $count => $reply) {
                                    if ($reply['id'] == $value[$key]) {
                                        if (isset($doc_collected_amount[$key])) {
                                            $keyAmount = $doc_collected_amount[$key];
                                        } else {
                                            $keyAmount = 'NA';
                                        }
                                        LeadDetails::where(
                                            '_id',
                                            new ObjectId($lead_id)
                                        )->update(array('dispatchDetails.documentDetails.' . $count . '.status' => 8,
                                        'dispatchDetails.documentDetails.' . $count . '.dispatchStatus' => "Canceled",
                                        'dispatchDetails.documentDetails.' . $count . '.gostatus' => 3,
                                        'dispatchDetails.documentDetails.' . $count . '.doc_collected_amount' => $keyAmount
                                        ));
                                        $this->saveDocumentStatus($lead_id, $count, '8');
                                    }
                                }
                                $leadDetails->save();
                            } else { }
                            $leadRejectStatus = 1;
                        }
                    }
                }
                if ($saveMethod == 'submitt_button') {
                    $agentMailID='';
                    $comment_submit_array = [];
                    $comment_submit_time = date('H:i:s');
                    $leadDetails = LeadDetails::find($lead_id);
                    $comment_submit_object = new \stdClass();
                    $comment_submit_object->comment = 'Submitted from delivery' . ',' . 'Message' . ' : ' . ucfirst(ucwords($request->input('action_comment')));
                    $comment_submit_object->commentBy = Auth::user()->name;
                    $comment_submit_object->commentTime = $comment_submit_time;
                    $comment_submit_object->id = new ObjectId(Auth::id());
                    $comment_submit_object->date = date('d/m/Y');
                    $comment_submit_array[] = $comment_submit_object;
                    $leadDetails->push('comments', $comment_submit_array);

                    $referencenumber = $leadDetails->referenceNumber;
                    $casemanagerid = $leadDetails->caseManager['id'];
                    $casemanager = User::find($casemanagerid);
                    $caseemail = $casemanager->email;
                    $casename = $casemanager->name;
                    $custid = $leadDetails->customer['id'];
                    $custname = $leadDetails->customer['name'];
                    $custemail = $leadDetails->contactEmail;
                    $recp = User::where('isActive', 1)->where('role', "RP")->get();
                    //                    dd($recp);
                    $lead = $leadDetails['dispatchDetails']['documentDetails'];
                    foreach ($lead as $key => $value2) {
                        $statusArray[] = $value2['DocumentCurrentStatus'];
                    }
                    if ((in_array("3", $statusArray) && in_array("2", $statusArray)) || (in_array("3", $statusArray) && in_array("4", $statusArray)) || (in_array("3", $statusArray) && in_array("5", $statusArray)) || (in_array("3", $statusArray) && in_array("8", $statusArray))
                    ) {
                        $goto_value = 'delivery';
                    } else {
                        $goto_value = 'reception';
                    }
                    $caselink = url('/dispatch/receptionist-list/');
                    $action = " Reception";
                    $leadss = $leadDetails['dispatchDetails']['documentDetails'];
                    if($leadDetails->saveType=='recipient'){
                        $agentMailID=='';
                    } else{
                        $agent = $leadDetails->agent['id'];
                        $agentValue = User::find($agent);
                        $agentMailID = $agentValue->email;
                    }
                    if ($leadRejectStatus == 1) {
                        $saveMethod = 'reject_button';
                        foreach ($recp as $user) {
                            $recpname = $user['name'];
                            $recpmail = $user['email'];
                            if ($recpmail != '') {
                                SendReceptionDelivery::dispatch($recpname, $recpmail, $referencenumber, $name, $caselink, $saveMethod, $leadss, $custname, $value);
                            }
                        }
                        if ($agentMailID != '') {
                            Mail::to($agentMailID)->send(new sendMailToAgent($agentMailID, $referencenumber, $name, $saveMethod, $action, $leadss, $custname, $value));
                        }
                        if ($caseemail != '') {
                            SendCaseManagerDelivery::dispatch($casename, $caseemail, $referencenumber, $name, $caselink, $saveMethod, $action, $leadss, $custname, $value);
                        }
                     
                    }
                    if ($leadSubmitStatus == 1) {
                        $saveMethod = 'submitt_button';
                        if ($agentMailID != '') {
                            Mail::to($agentMailID)->send(new sendMailToAgent($agentMailID, $referencenumber, $name, $saveMethod, $action, $leadss, $custname, $value));
                        }
                        if ($caseemail != '') {
                            SendCaseManagerDelivery::dispatch($casename, $caseemail, $referencenumber, $name, $caselink, $saveMethod, $action, $leadss, $custname, $value);
                        }
                       
                    }
                    $this->saveTabStatus($lead_id);
                    $this->setDispatchStatus($lead_id);
                    if ($goto_value == 'delivery') {
                        $leadDetails->save();
                        return response()->json(['status' => 'go_delivery']);
                    } else {
                        $leadDetails->save();
                        return response()->json(['status' => 'go_reception']);
                    }
                }
            }
        }
    }

    /**
     * save document status
     */
    public static function saveDocumentStatus($lead_id, $count, $status)
    {
        LeadDetails::where(
            '_id',
            new ObjectId($lead_id)
        )->update(array('dispatchDetails.documentDetails.' . $count . '.DocumentCurrentStatus' => $status));
        //         return 'success';
    }

    /**
     * save receptionist reply
     */
    public function saveReceptionistReply(Request $request)
    {
        $lead_id = $request->input('lead_id');
        $leadDetails = LeadDetails::find($lead_id);
        $saveMethod = $request->input('save_method');
        $documentSelectArray = $request->input('docSelect');
        $documentIdArray = $request->input('docid');
        if ($saveMethod) {
            $updatedBy_obj = new \stdClass();
            $updatedBy_obj->id = new ObjectID(Auth::id());
            $updatedBy_obj->name = Auth::user()->name;
            $updatedBy_obj->date = date('d/m/Y');
            $updatedBy_obj->action = "Receptionist Final Reply";
            $updatedBy[] = $updatedBy_obj;
            LeadDetails::where('_id', new ObjectId($lead_id))->push('updatedBy', $updatedBy);
            $finalStatusObject = new \stdClass();
            $finalStatusObject->id = new ObjectID(Auth::id());
            $finalStatusObject->name = Auth::user()->name;
            $finalStatusObject->date = date('d/m/Y');
            if ($saveMethod == 'collected_button') {
                $finalStatusObject->status = "Marked as collected";
                $finalStatus[] = $finalStatusObject;
                if ($leadDetails->finalStatus) {
                    LeadDetails::where('_id', new ObjectId($lead_id))->push('finalStatus', $finalStatus);
                } else {
                    $leadDetails->finalStatus = $finalStatus;
                }

                $leadDetailsDet = LeadDetails::find($lead_id);
                $lead = $leadDetailsDet['dispatchDetails']['documentDetails'];
                foreach ($lead as $count => $reply) {
                    if (isset($documentSelectArray)) {
                        if (in_array($reply['id'], $documentSelectArray)) {
                            $this->saveDocumentStatus($lead_id, $count, '7');
                        }
                    }
                }
                $this->saveTabStatus($request->input('lead_id'));
                Session::flash('status', 'Collected successfully');
                $leadDetails->save();
                return response()->json(['status' => 'go_reception']);
            } elseif ($saveMethod == 'btn_cancel_save') {
                Session::flash('status', 'Saved successfully');
                $leadDetails->save();
                return response()->json(['status' => 'go_reception']);
            } elseif ($saveMethod == 'delivered_button') {
                $finalStatusObject->status = "Marked as delivered";
                $finalStatus[] = $finalStatusObject;
                if ($leadDetails->finalStatus) {
                    LeadDetails::where('_id', new ObjectId($lead_id))->push('finalStatus', $finalStatus);
                } else {
                    $leadDetails->finalStatus = $finalStatus;
                }
                Session::flash('status', 'Delivered successfully');
                $leadDetails->save();
                $leadDetailsDet = LeadDetails::find($lead_id);
                $lead = $leadDetailsDet['dispatchDetails']['documentDetails'];
                foreach ($lead as $count => $reply) {
                    if (isset($documentSelectArray)) {
                        if (in_array($reply['id'], $documentSelectArray)) {
                            $this->saveDocumentStatus($lead_id, $count, '7');
                        }
                    }
                }
                $this->saveTabStatus($lead_id);

                return response()->json(['status' => 'go_reception']);
            } elseif ($saveMethod == 'collected_and_delivered_button') {
                $finalStatusObject->status = "Marked as collected and delivered";
                $finalStatus[] = $finalStatusObject;
                if ($leadDetails->finalStatus) {
                    LeadDetails::where('_id', new ObjectId($lead_id))->push('finalStatus', $finalStatus);
                } else {
                    $leadDetails->finalStatus = $finalStatus;
                }
                Session::flash('status', 'Collected and delivered successfully');
                $leadDetails->save();
                return response()->json(['status' => 'go_reception']);
            }
        }
    }

    /**
     * Function for get the employees for drop down
     */
    public function getEmployees(Request $request)
    {
        $mode = new ObjectId($request->input('mode'));
        $agent = $request->input('agent');
        $delivery_mode = DeliveryMode::find($mode);
        if ($delivery_mode->deliveryMode == 'Agent') {
            $employees = User::where('isActive', 1)->where('role', 'AG')->orderBy('name')->get();
            $response[] = "<option value=''>Select Agent</option>";
            foreach ($employees as $employee) {
                if ($employee['_id'] == $agent) {
                    if ($employee->empID != '') {
                        $id = ' (' . $employee->empID . ')';
                    } else {
                        $id = '';
                    }
                    $response[] = "<option value='$employee->_id' selected>$employee->name $id</option>";
                } else {
                    if ($employee->empID != '') {
                        $id = ' (' . $employee->empID . ')';
                    } else {
                        $id = '';
                    }
                    $response[] = "<option value='$employee->_id'>$employee->name $id</option>";
                }
            }
        } elseif ($delivery_mode->deliveryMode == 'Admin') {
            $employees = User::where('isActive', 1)->where('role', 'AD')->orderBy('name')->get();
            $response[] = "<option value=''>Select Admin</option>";
            foreach ($employees as $employee) {
                if ($employee['_id'] == $agent) {
                    if ($employee->empID != '') {
                        $id = ' (' . $employee->empID . ')';
                    } else {
                        $id = '';
                    }
                    $response[] = "<option value='$employee->_id' selected>$employee->name $id</option>";
                } else {
                    if ($employee->empID != '') {
                        $id = ' (' . $employee->empID . ')';
                    } else {
                        $id = '';
                    }
                    $response[] = "<option value='$employee->_id'>$employee->name $id</option>";
                }
            }
        } elseif ($delivery_mode->deliveryMode == 'Courier') {
            $employees = User::where('isActive', 1)->where('role', 'CR')->orderBy('name')->get();
            $response[] = "<option value=''>Select Courier</option>";
            foreach ($employees as $employee) {
                if ($employee->empID != '') {
                    $id = ' (' . $employee->empID . ')';
                } else {
                    $id = '';
                }
                $response[] = "<option value='$employee->_id'>$employee->name $id</option>";
            }
        } elseif ($delivery_mode->deliveryMode == 'Coordinator') {
            $employees = User::where('isActive', 1)->where('role', 'CO')->orderBy('name')->get();
            $response[] = "<option value=''>Select Coordinator</option>";
            foreach ($employees as $employee) {
                if ($employee->empID != '') {
                    $id = ' (' . $employee->empID . ')';
                } else {
                    $id = '';
                }
                $response[] = "<option value='$employee->_id'>$employee->name $id</option>";
            }
        } elseif ($delivery_mode->deliveryMode == 'Supervisor') {
            $employees = User::where('isActive', 1)->where('role', 'SV')->orderBy('name')->get();
            $response[] = "<option value=''>Select Supervisor</option>";
            foreach ($employees as $employee) {
                if ($employee->empID != '') {
                    $id = ' (' . $employee->empID . ')';
                } else {
                    $id = '';
                }
                $response[] = "<option value='$employee->_id'>$employee->name $id</option>";
            }
        } else {
            $employees = User::where('isActive', 1)->where(function ($q) {
                $q->where('role', 'EM')->orwhere('role', 'MS');
            })->orderBy('name')->get();
            $response[] = "<option value=''>Select Employee</option>";
            foreach ($employees as $employee) {
                if ($employee->empID != '') {
                    $id = ' (' . $employee->empID . ')';
                } else {
                    $id = '';
                }
                $response[] = "<option value='$employee->_id'>$employee->name $id</option>";
            }
        }

        return response()->json(['success' => true, 'response' => $response]);
    }

    /**
     * get select all for all data tables
     */
    public function getSelectAll(Request $request)
    {
        $save_from = $request->input('datatable');
        $filter_data = json_decode(session('filter'));
        $sort = session('sort');
        $search = session('search');
        $array_test = [];
        if ($save_from == 'lead') {
            $leadDetails1 = LeadDetails::where('active', 1)->where('leadTabStatus', (int) 1)
                ->whereNotNull('dispatchDetails.land_mark')->whereNotNull('dispatchDetails.documentDetails')->where('dispatchDetails.documentDetails.documentName', '!=', "")->whereNotNull('dispatchDetails.documentDetails.amount')->whereNotNull('dispatchDetails.documentDetails.documentDescription')->whereNotNull('dispatchDetails.documentDetails.documentType')
                ->whereNotNull('dispatchDetails.address')->whereNotNull('dispatchDetails.employee');
            if (session('role') == 'Admin') {
                $leadDetails1 = $leadDetails1->get();
            } else {
                $leadDetails1 = $leadDetails1->where('caseManager.id', new ObjectID(Auth::user()->_id))->get();
            }
            //			$leadDetails1 = LeadDetails::where('active', 1)->where('leadTabStatus', (int)1)
            //				->whereNotNull('dispatchDetails.land_mark')->whereNotNull('dispatchDetails.documentDetails')->whereNotNull('dispatchDetails.documentDetails.documentName')->whereNotNull('dispatchDetails.documentDetails.amount')->whereNotNull('dispatchDetails.documentDetails.documentDescription')->whereNotNull('dispatchDetails.documentDetails.documentType')
            //				->whereNotNull('dispatchDetails.address')->whereNotNull('dispatchDetails.employee')->get();
            foreach ($leadDetails1 as $newlead) {
                $array = $newlead->deliveryMode['deliveryMode'];
                if ($array == "Courier") {
                    $array1 = $newlead->deliveryMode['wayBill'];
                    if ($array1 != "--") {
                        $array_test[] = $newlead->_id;
                    }
                }
                if ($array != "Courier") {
                    $array_test[] = $newlead->_id;
                }
            }
            $leadDetails = LeadDetails::whereIn('_id', $array_test);
        } elseif ($save_from == 'employee') {
            $employee_id = new ObjectId(session('employee_id'));
            //             $leadDetails = LeadDetails::where('active', 1)->where('transferTo.id',$employee_id)->whereNotNull('transferTo')->where('dispatchStatus','!=','Completed');
            $leadDetails = LeadDetails::where('active', 1)->where('employeeTabStatus', (int) 1)->whereNotNull('transferTo')->where(
                'transferTo.id',
                $employee_id
            );
        } elseif ($save_from == 'schedule') {
            $leadDetails = LeadDetails::where('active', 1)->where('scheduledTabStatus', (int) 1);
            if (session('role') == 'Employee' || session('role') == 'Agent') {
                $leadDetails = $leadDetails->where('employee.id', new ObjectID(Auth::user()->_id));
            } elseif (session('role') == 'Coordinator') {
                $leadDetails = $leadDetails->where(function ($q) {
                    $q->where('employee.id', new ObjectID(Auth::user()->_id))
                        ->orwhere('employee.id', session('assigned_agent'));
                });
                // $leadDetails = $leadDetails->where('employee.id', session('assigned_agent'));
            } elseif (session('role') == 'Supervisor') {
                $leadDetails = $leadDetails->where(function ($q) {
                    $q->where('employee.id', new ObjectID(Auth::user()->_id))
                        ->orwhereIn('employee.id', session('employees'));
                });
            } elseif (session('role') != 'Admin' && session('role') != 'Receptionist') {
                $leadDetails = $leadDetails->where('employee.id', new ObjectID(Auth::user()->_id));
            }
        } elseif ($save_from == 'delivery' || session('role') == 'Agent') {
            $leadDetails = LeadDetails::where('active', 1)->where('deliveryTabStatus', (int) 1);
            if (session('role') == 'Employee') {
                $leadDetails = $leadDetails->where('employee.id', new ObjectID(Auth::user()->_id));
            } elseif (session('role') == 'Coordinator') {
                $leadDetails = $leadDetails->where(function ($q) {
                    $q->where('employee.id', new ObjectID(Auth::user()->_id))
                        ->orwhere('employee.id', session('assigned_agent'));
                });
            } elseif (session('role') == 'Supervisor') {
                $leadDetails = $leadDetails->where(function ($q) {
                    $q->where('employee.id', new ObjectID(Auth::user()->_id))
                        ->orwhereIn('employee.id', session('employees'));
                });
            } elseif (session('role') != 'Admin' && session('role') != 'Receptionist') {
                $leadDetails = $leadDetails->where('employee.id', new ObjectID(Auth::user()->_id));
            }
        } elseif ($save_from == 'receptionist') {
            $leadDetails = LeadDetails::where('active', 1)->where('receptionTabStatus', (int) 1);
        } elseif ($save_from == 'transferred') {
            $leadDetails = LeadDetails::where('active', 1)->where('employeeTabStatus', (int) 1);
        }

        if (!empty($filter_data)) {
            if (!empty($filter_data->agent)) {
                $count = 0;
                foreach ($filter_data->agent as $agent) {
                    $objectArray[$count] = new ObjectId($agent);
                    $count++;
                }
                $leadDetails = $leadDetails->whereIn('agent.id', $objectArray);
            }
            if (!empty($filter_data->case_manager)) {
                $count = 0;
                foreach ($filter_data->case_manager as $manager) {
                    $objectArray[$count] = new ObjectId($manager);
                    $count++;
                }
                $leadDetails = $leadDetails->whereIn('caseManager.id', $objectArray);
            }
            if (!empty($filter_data->customer)) {
                $count = 0;
                foreach ($filter_data->customer as $cust) {
                    $objectArray[$count] = new ObjectId($cust);
                    $count++;
                }
                $leadDetails = $leadDetails->whereIn('customer.id', $objectArray);
            }
            if (!empty($filter_data->delivery)) {
                $count = 0;
                foreach ($filter_data->delivery as $mode) {
                    $objectArray[$count] = new ObjectId($mode);
                    $count++;
                }
                $leadDetails = $leadDetails->whereIn('deliveryMode.id', $objectArray);
            }
            if (!empty($filter_data->dispatch)) {
                $count = 0;
                foreach ($filter_data->dispatch as $type) {
                    $objectArray[$count] = new ObjectId($type);
                    $count++;
                }
                $leadDetails = $leadDetails->whereIn('dispatchType.id', $objectArray);
            }
            if (!empty($filter_data->assigned)) {
                $count = 0;
                foreach ($filter_data->assigned as $type) {
                    $objectArray[$count] = new ObjectId($type);
                    $count++;
                }
                $leadDetails = $leadDetails->whereIn('employee.id', $objectArray);
            }
            if (!empty($filter_data->status)) {
                $count = 0;
                foreach ($filter_data->status as $stat) {
                    $objectArray[$count] = $stat;
                    $count++;
                }
                $leadDetails = $leadDetails->whereIn('dispatchStatus', $objectArray);
            }
        }

        if ($search) {
            $leadDetails = $leadDetails->where(function ($query) use ($search) {
                $query->Where('referenceNumber', 'like', '%' . $search . '%')
                    ->orWhere('customer.name', 'like', '%' . $search . '%')
                    ->orWhere('customer.recipientName', 'like', '%' . $search . '%')
                    ->orWhere('customer.customerCode', 'like', '%' . $search . '%')
                    ->orWhere('agent.name', 'like', '%' . $search . '%')
                    ->orWhere('caseManager.name', 'like', '%' . $search . '%')
                    ->orWhere('contactNumber', 'like', '%' . $search . '%')
                    ->orWhere('contactEmail', 'like', '%' . $search . '%')
                    ->orWhere('deliveryMode.deliveryMode', 'like', '%' . $search . '%')
                    ->orWhere('dispatchType.dispatchType', 'like', '%' . $search . '%');
            });
            session()->put('search', $search);
        }
        $final_data = $leadDetails->pluck('_id')->toArray();
        return $final_data;
    }

    /**
     * Login function for employee
     */
    public function employeeLogin(Request $request)
    {
        $request->session()->forget('employees_supervisor');
        $uniqueCode = $request->input('password');
        $employee = User::where('uniqueCode', $uniqueCode)->where('isActive', 1)->first();
        // dd($employee->_id);
        if (!$employee) {
            return 'not_found';
        } else {
            $employees = $employee->employees;
            if (isset($employees) && !empty($employees)) {
                $empids = $this->collectEmployees($employees);
                $empids = array_values(array_unique($empids));
                session(['employees' => $empids]);
            } else {
                session(['employees' => []]);
            }
            session()->put('employee_id', $employee->_id);
            session()->put('EmpID', $employee->empID);
            session()->put('EmployeeName', $employee->name);
            return 'success';
        }
    }
    protected function collectEmployees($employees)
    {
        $ids = [];
        $employeeList = [];
        $supervisorList = [];
        foreach ($employees as $emp) {
            $ids[] = new ObjectId($emp['id']);
        }
        $users = User::select('_id', 'role', 'employees')->whereIn('_id', $ids)->get();
        if ($users) {
            foreach ($users as $result) {
                if ($result && $result->role != 'SV') {
                    $employeeList = array_merge($employeeList, [new ObjectId($result->_id)]);
                } else {
                    if (in_array(new ObjectId($result->_id), $employeeList)) {
                        continue;
                    }
                    $employeeList = array_merge($employeeList, [new ObjectId($result->_id)]);
                    $supervisorList = array_merge($supervisorList, [$result]);
                }
            }
            foreach ($supervisorList as $supervisor) {
                $employ = $this->collectEmployees($supervisor->employees);
                $employeeList = array_merge($employeeList, $employ);
            }
        }
        return $employeeList;
    }
    protected function stringCollectEmployees($employees)
    {
        $ids = [];
        $employeeList = [];
        $supervisorList = [];
        foreach ($employees as $emp) {
            $ids[] = new ObjectId($emp['id']);
        }
        $users = User::select('_id', 'role', 'employees')->whereIn('_id', $ids)->get();
        if ($users) {
            foreach ($users as $result) {
                if ($result && $result->role != 'SV') {
                    $employeeList = array_merge($employeeList, [(string) $result->_id]);
                } else {
                    if (in_array((string) $result->_id, $employeeList)) {
                        continue;
                    }
                    $employeeList = array_merge($employeeList, [(string) $result->_id]);
                    $supervisorList = array_merge($supervisorList, [$result]);
                }
            }
            foreach ($supervisorList as $supervisor) {
                $employ = $this->stringCollectEmployees($supervisor->employees);
                $employeeList = array_merge($employeeList, $employ);
            }
        }
        return $employeeList;
    }

    /**
     * Display the list for employee Login
     */
    public function employeeViewList(Request $request)
    {
        if (!empty($request->input('agent'))) {
            $count = 0;
            foreach ($request->input('agent') as $cust) {
                $objectArray[$count] = new ObjectId($cust);
                $count++;
            }
            $agents = User::where('isActive', 1)->where(function ($q) {
                $q->where('role', 'EM')->orWhere('role', 'AG');
            })->whereIn('_id', $objectArray)->get();
        } else {
            $agents = '';
        }

        if (!empty($request->input('assigned'))) {
            $count = 0;
            foreach ($request->input('assigned') as $cust) {
                $objectArray[$count] = new ObjectId($cust);
                $count++;
            }
            $assigned_to = User::where('isActive', 1)->where(function ($q) {
                $q->where('role', 'EM')->orWhere('role', 'AG')->orWhere('role', 'CR')->orWhere('role', 'MS')->orWhere('role', 'AD')->orWhere('role', 'CO')->orWhere('role', 'SV');
            })->whereIn('_id', $objectArray)->get();
        } else {
            $assigned_to = '';
        }

        if (!empty($request->input('customer'))) {
            $count = 0;
            foreach ($request->input('customer') as $cust) {
                $objectArray[$count] = new ObjectId($cust);
                $count++;
            }
            $customers = Customer::whereIn('_id', $objectArray)->get();
            $recepients = RecipientDetails::whereIn('_id', $objectArray)->get();
            $customers = $customers->merge($recepients);
        } else {
            $customers = '';
        }
        //\		$customer_code = [];
        //		foreach ($customers as $customer) {
        //			$customer_code[] = $customer->customerCode;
        //		}
        if (!empty($request->input('case_manager'))) {
            $count = 0;
            foreach ($request->input('case_manager') as $cust) {
                $objectArray[$count] = new ObjectId($cust);
                $count++;
            }
            $case_managers = User::where('isActive', 1)->where(function ($q) {
                $q->where('role', 'EM')->orWhere('role', 'AD')->orWhere('role', 'RP')->orWhere('role', 'AG')->orWhere('role', 'CO')->orWhere('role', 'SV');
            })->whereIn('_id', $objectArray)->get();
        } else {
            $case_managers = '';
        }

        if (!empty($request->input('dispatch'))) {
            $count = 0;
            foreach ($request->input('dispatch') as $cust) {
                $objectArray[$count] = new ObjectId($cust);
                $count++;
            }
            if (
                session('role') == 'Insurer' || session('role') == 'Employee' || session('role') == 'Agent' || session('role') == 'Coordinator' ||
                session('role') == 'Supervisor' || session('role') == 'Courier' || session('role') == 'Messenger' || session('role') == 'Accountant'
            ) {
                $dispatch_type_check = DispatchTypes::where('type', '!=', 'Direct Collections')->whereIn('_id', $objectArray)->get();
            } else {
                $dispatch_type_check = DispatchTypes::whereIn('_id', $objectArray)->get();
            }
        } else {
            $dispatch_type_check = '';
        }
        if (!empty($request->input('delivery'))) {
            $count = 0;
            foreach ($request->input('delivery') as $cust) {
                $objectArray[$count] = new ObjectId($cust);
                $count++;
            }
            $delivery_mode_check = DeliveryMode::whereIn('_id', $objectArray)->get();
        } else {
            $delivery_mode_check = '';
        }
        $delivery_mode = DeliveryMode::all();
        $dispatch_types = DispatchTypes::all();
        $document_types = DocumentType::all();
        $filter_data = $request->input();
        $current_path = $request->path();
        if (!empty($request->input('status'))) {
            $count = 0;
            foreach ($request->input('status') as $cust) {
                $objectArray[$count] = $cust;
                $count++;
            }
            $Allstatus = DispatchStatus::whereIn('status', $objectArray)->groupBy('status')->get();
        } else {
            $Allstatus = '';
        }
        return view('dispatch.employee_view')
            ->with(compact(
                'customers',
                'agents',
                'case_managers',
                'delivery_mode',
                'dispatch_types',
                'dispatch_type_check',
                'delivery_mode_check',
                'assigned_to',
                'filter_data',
                'document_types',
                'current_path',
                'Allstatus'
            ));
    }

    /**
     * Function for listing marked list in employee login page
     */
    public function listMarked(Request $request)
    {
        $employee_id = new ObjectId(session('employee_id'));
        $user = User::select('role', 'employees', 'assigned_agent')->find($employee_id);
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $filter = $request->input('search');
        $filter_data_en = $request->get('filterData');
        $filter_data = json_decode($filter_data_en);
        $sort = $request->get('field');
        $search = (isset($filter['value'])) ? $filter['value'] : false;
        session()->put('filter', $filter_data_en);
        session()->put('sort', $sort);
        $lead = [];
        // dd(session('employees'));
        $LeadDetails = LeadDetails::where('active', 1)->where('employeeTabStatus', (int) 1)->whereNotNull('transferTo');
        if ($user->role == 'SV') {
            $employee_id1 = session('employees') ?: [];
            // dd($employee_id1);
            array_push($employee_id1, new ObjectId($user->_id));
            session(['employees_supervisor' => $employee_id1]);
            // dd($employee_id1);
            $idPrimary = [];
            if (count($employee_id1) != '') {
                foreach ($employee_id1 as $id) {
                    $idArry = LeadDetails::where('active', 1)->where('employeeTabStatus', (int) 1)->whereNotNull('transferTo')->where(function ($q) use ($id) {
                        $q->where('transferTo', 'elemMatch', array('id' => $id, 'status' => 'Transferred'))->orwhere('transferTo', 'elemMatch', array('id' => $id, 'status' => 'Collected'));
                    })->get();
                    foreach ($idArry as $iArray) {
                        $idPrimary[] = $iArray->_id;
                    }
                }
                $LeadDetails = LeadDetails::whereIn('_id', $idPrimary);
            }
        } elseif ($user->role == 'CO') {
            // dd($user);
            //  $employee_id=session('employees');
            $employees = $user->assigned_agent;
            //  dd($employees);
            $employee_id1 = [];
            //  foreach ($employees as $emp) {
            $employee_id1[] = $employees['id'];
            //  }
            $employee_id1[] = new ObjectId($user->_id);
            session(['employees_supervisor' => $employee_id1]);
            $idPrimary = [];
            if (count($employee_id1) != '') {
                foreach ($employee_id1 as $id) {
                    $idArry = LeadDetails::where('active', 1)->where('employeeTabStatus', (int) 1)->whereNotNull('transferTo')->where(function ($q) use ($id) {
                        $q->where('transferTo', 'elemMatch', array('id' => $id, 'status' => 'Transferred'))->orwhere('transferTo', 'elemMatch', array('id' => $id, 'status' => 'Collected'));
                    })->get();
                    foreach ($idArry as $iArray) {
                        $idPrimary[] = $iArray->_id;
                    }
                }
                // dd($idPrimary);
                $LeadDetails = LeadDetails::whereIn('_id', $idPrimary);
            }
        } else {
            $LeadDetails = $LeadDetails->where(function ($q) use ($employee_id) {
                $q->where('transferTo', 'elemMatch', array('id' => $employee_id, 'status' => 'Transferred'))->orwhere('transferTo', 'elemMatch', array('id' => $employee_id, 'status' => 'Collected'));
            });
        }
        if (!empty($filter_data)) {
            if (!empty($filter_data->agent)) {
                $count = 0;
                foreach ($filter_data->agent as $agent) {
                    $objectArray[$count] = new ObjectId($agent);
                    $count++;
                }
                $LeadDetails = $LeadDetails->whereIn('agent.id', $objectArray);
            }
            if (!empty($filter_data->case_manager)) {
                $count = 0;
                foreach ($filter_data->case_manager as $manager) {
                    $objectArray[$count] = new ObjectId($manager);
                    $count++;
                }
                $LeadDetails = $LeadDetails->whereIn('caseManager.id', $objectArray);
            }
            if (!empty($filter_data->customer)) {
                $count = 0;
                foreach ($filter_data->customer as $cust) {
                    $objectArray[$count] = new ObjectId($cust);
                    $count++;
                }
                $LeadDetails = $LeadDetails->whereIn('customer.id', $objectArray);
            }
            if (!empty($filter_data->delivery)) {
                $count = 0;
                foreach ($filter_data->delivery as $mode) {
                    $objectArray[$count] = new ObjectId($mode);
                    $count++;
                }
                $LeadDetails = $LeadDetails->whereIn('deliveryMode.id', $objectArray);
            }
            if (!empty($filter_data->dispatch)) {
                $count = 0;
                foreach ($filter_data->dispatch as $type) {
                    $objectArray[$count] = new ObjectId($type);
                    $count++;
                }
                $LeadDetails = $LeadDetails->whereIn('dispatchType.id', $objectArray);
            }
            if (!empty($filter_data->assigned)) {
                $count = 0;
                foreach ($filter_data->assigned as $type) {
                    $objectArray[$count] = new ObjectId($type);
                    $count++;
                }
                $LeadDetails = $LeadDetails->whereIn('employee.id', $objectArray);
            }
            if (!empty($filter_data->status)) {
                $count = 0;
                foreach ($filter_data->status as $stat) {
                    $objectArray[$count] = $stat;
                    $count++;
                }
                $LeadDetails = $LeadDetails->whereIn('dispatchStatus', $objectArray);
            }
        }

        if (!empty($sort)) {
            if ($sort == "Customer Name") {
                $LeadDetails = $LeadDetails->orderBy('customer.name');
            } elseif ($sort == "Agent") {
                $LeadDetails = $LeadDetails->orderBy('agent.name');
            } elseif ($sort == "Case Manager") {
                $LeadDetails = $LeadDetails->orderBy('caseManager.name');
            } elseif ($sort == "Dispatch Type") {
                $LeadDetails = $LeadDetails->orderBy('dispatchType.dispatchType');
            } elseif ($sort == "Delivery Mode") {
                $LeadDetails = $LeadDetails->orderBy('deliveryMode.deliveryMode');
            }
        } elseif (empty($sort)) {
            $LeadDetails = $LeadDetails->orderBy('created_at', 'DESC');
        }
        if ($search) {
            $LeadDetails = $LeadDetails->where(function ($query) use ($search) {
                $query->Where('referenceNumber', 'like', '%' . $search . '%')
                    ->orWhere('customer.name', 'like', '%' . $search . '%')
                    ->orWhere('customer.recipientName', 'like', '%' . $search . '%')
                    ->orWhere('customer.customerCode', 'like', '%' . $search . '%')
                    ->orWhere('agent.name', 'like', '%' . $search . '%')
                    ->orWhere('caseManager.name', 'like', '%' . $search . '%')
                    ->orWhere('contactNumber', 'like', '%' . $search . '%')
                    //					->orWhere('contactEmail', 'like', '%' . $search . '%')
                    ->orWhere('deliveryMode.deliveryMode', 'like', '%' . $search . '%')
                    ->orWhere('dispatchStatus', 'like', '%' . $search . '%')
                    ->orWhere('dispatchType.dispatchType', 'like', '%' . $search . '%');
            });


            session()->put('search', $search);
        }
        if ($search == "") {
            $LeadDetails = $LeadDetails;
            session()->put('search', "");
        }

        $searchField = $request->get('searchField');
        if ($searchField != "") {
            $LeadDetails = $LeadDetails->where(function ($query) use ($searchField) {
                $query->Where('referenceNumber', 'like', '%' . $searchField . '%')
                    ->orWhere('customer.name', 'like', '%' . $searchField . '%')
                    ->orWhere('customer.recipientName', 'like', '%' . $searchField . '%')
                    ->orWhere('customer.customerCode', 'like', '%' . $searchField . '%')
                    ->orWhere('agent.name', 'like', '%' . $searchField . '%')
                    ->orWhere('caseManager.name', 'like', '%' . $searchField . '%')
                    ->orWhere('contactNumber', 'like', '%' . $searchField . '%')
                    //					->orWhere('contactEmail', 'like', '%' . $searchField . '%')
                    ->orWhere('dispatchStatus', 'like', '%' . $searchField . '%')
                    ->orWhere('deliveryMode.deliveryMode', 'like', '%' . $searchField . '%')
                    ->orWhere('dispatchType.dispatchType', 'like', '%' . $searchField . '%');
            });
        }
        $total_leads = $LeadDetails->count(); // get your total no of data;
        $members_query = $LeadDetails;
        $search_count = $members_query->count();
        $LeadDetails->skip((int) $start)->take((int) $length);
        $final_leads = $LeadDetails->get();
        foreach ($final_leads as $leads) {
            $check = '<div class="custom_checkbox">' .
                '<input type="checkbox" name="marked_list[]" value="" id="' . $leads->_id . '" class="inp-cbx" style="display: none" onchange="markedCheck(this.id)">' .
                '<label for="' . $leads->_id . '" class="cbx">' .
                '<span>' .
                '    <svg width="10px" height="8px" viewBox="0 0 12 10">' .
                '      <polyline points="1.5 6 4.5 9 10.5 1"></polyline>' .
                '    </svg>' .
                '</span>' .
                '</label>' .
                '</div>';
            if ($leads['referenceNumber'] == '') {
                $referenceNumber = '--';
            } else {
                //$referenceNumber = $leads['referenceNumber'];
                $referenceNumber = '<a href="#" class="auto_modal table_link" data-toggle="tooltip" data-placement="bottom" title="View Dispatch Slip" data-container="body"  data-modal="view_lead_popup" dir="' . $leads->_id . '" onclick="view_lead_popup(\'' . $leads->_id . '\');">

' . $leads['referenceNumber'] . '  </a> ';
            }
            if (isset($leads->agent['name'])) {
                $agentname = ucwords(strtolower($leads->agent['name']));
                if (isset($leads->agent['empid'])) {
                    if ($leads->agent['empid'] != "") {
                        $agentid = $leads->agent['empid'];
                        $agentvalue = $agentname . ' (' . $agentid . ')';
                    } else {
                        $agentvalue = $agentname;
                    }
                } else {
                    $agentvalue = $agentname;
                }
            } else {
                $agentvalue = 'NA';
            }
            $agent = $agentvalue;
            $caseManager = ucwords(strtolower($leads['caseManager.name']));
            $email = $leads->contactEmail;
            $contact = $leads->contactNumber;
            $recipientName = ucwords(strtolower($leads['customer.recipientName']));
            $dispatchType = $leads['dispatchType.dispatchType'];
            $deliveryMode = $leads['deliveryMode.deliveryMode'];
            $code = $leads['customer.customerCode'] ?: '--';
            $customerName = ucwords(strtolower($leads['customer.name']));
            $created_at = $leads['created_at'];
            if (isset($leads->employee['name'])) {
                $assignname = ucwords(strtolower($leads->employee['name']));
                if (isset($leads->employee['empId'])) {
                    if ($leads->employee['empId'] != "") {
                        $assignid = $leads->employee['empId'];
                        $assignvalue = $assignname . ' (' . $assignid . ')';
                    } else {
                        $assignvalue = $assignname;
                    }
                } else {
                    $assignvalue = $assignname;
                }
            } else {
                $assignvalue = '--';
            }
            $documentUniqid = [];
            $lead = $leads['dispatchDetails']['documentDetails'];
            foreach ($lead as $key => $value) {
                if (isset($value['uniqTransferId'])) {
                    $documentUniqid[] = $value['uniqTransferId'];
                }
            }
            $transfer_name = [];
            $transfer_empid = [];
            $transferto = $leads->transferTo;
            foreach ($transferto as $key => $value) {
                if (isset($value['uniqval'])) {
                    if (in_array(
                        $value['uniqval'],
                        $documentUniqid
                    ) && ($value['status'] == 'Transferred' || $value['status'] == 'Collected')) {
                        if (isset($value['empCode']) && $value['empCode'] != '') {
                            $transfer_name[] = $value['name'] . '( ' . $value['empCode'] . ')';
                        } else {
                            $transfer_name[] = $value['name'];
                        }
                        $transfer_empid[] = (string) $value['id'];
                    }
                }
            }
            if (count(array_unique($transfer_empid)) === 1 && end($transfer_empid) === $transfer_empid[0]) {
                $string_version = $transfer_name[0];
            } else {
                $string_version = implode(',', $transfer_name);
            }
            $status = '<a href="#"><span data-toggle="tooltip" data-placement="bottom" title="Transfer to : ' . $string_version . '"  data-container="body" > ' . $leads['dispatchStatus'] . ' </span>  ';
            //			$leads->checkall = $check;
            $leads->customerCode = $code;
            $leads->referenceNumber = $referenceNumber;
            $leads->customerName = $customerName;
            $leads->recipientName = $recipientName;
            $leads->contactNo = $contact;
            $leads->email = $email;
            $leads->caseManager = $caseManager;
            $leads->agent = $agent;
            $leads->dispatchType = $dispatchType;
            $leads->deliveryMode = $deliveryMode;
            $leads->status = $status;
            $leads->assign = $assignvalue;
            $leads->created = Carbon::parse($created_at)->format('d/m/Y');
        }
        if ($search) {
            $filtered_count = $search_count;
        } else {
            $filtered_count = $total_leads;
        }


        $data = array(
            'draw' => $draw,
            'recordsTotal' => $total_leads,
            'recordsFiltered' => $filtered_count,
            'data' => $final_leads,
        );

        return json_encode($data);
    }

    /**
     * export leads in employee login page
     */
    public function exportEmployeeleads(Request $request)
    {
        ini_set('xdebug.max_nesting_level', 500);
        $email = $request->input('email');
        $employee_id = new ObjectId(session('employee_id'));
        $filter_data = json_decode(session('filter'));
        $sort = session('sort');
        $search = session('search');
        $LeadDetails = LeadDetails::where('active', 1)->where('employeeTabStatus', (int) 1)->whereNotNull('transferTo')->where(
            'transferTo.id',
            $employee_id
        );
        if (!empty($filter_data)) {
            if (!empty($filter_data->agent)) {
                $count = 0;
                foreach ($filter_data->agent as $agent) {
                    $objectArray[$count] = new ObjectId($agent);
                    $count++;
                }
                $LeadDetails = $LeadDetails->whereIn('agent.id', $objectArray);
            }
            if (!empty($filter_data->case_manager)) {
                $count = 0;
                foreach ($filter_data->case_manager as $manager) {
                    $objectArray[$count] = new ObjectId($manager);
                    $count++;
                }
                $LeadDetails = $LeadDetails->whereIn('caseManager.id', $objectArray);
            }
            if (!empty($filter_data->customer)) {
                $count = 0;
                foreach ($filter_data->customer as $cust) {
                    $objectArray[$count] = new ObjectId($cust);
                    $count++;
                }
                $LeadDetails = $LeadDetails->whereIn('customer.id', $objectArray);
            }
            if (!empty($filter_data->delivery)) {
                $count = 0;
                foreach ($filter_data->delivery as $mode) {
                    $objectArray[$count] = new ObjectId($mode);
                    $count++;
                }
                $LeadDetails = $LeadDetails->whereIn('deliveryMode.id', $objectArray);
            }
            if (!empty($filter_data->dispatch)) {
                $count = 0;
                foreach ($filter_data->dispatch as $type) {
                    $objectArray[$count] = new ObjectId($type);
                    $count++;
                }
                $LeadDetails = $LeadDetails->whereIn('dispatchType.id', $objectArray);
            }
            if (!empty($filter_data->assigned)) {
                $count = 0;
                foreach ($filter_data->assigned as $type) {
                    $objectArray[$count] = new ObjectId($type);
                    $count++;
                }
                $LeadDetails = $LeadDetails->whereIn('employee.id', $objectArray);
            }
            if (!empty($filter_data->status)) {
                $count = 0;
                foreach ($filter_data->status as $stat) {
                    $objectArray[$count] = $stat;
                    $count++;
                }
                $LeadDetails = $LeadDetails->whereIn('dispatchStatus', $objectArray);
            }
        } else {
            $LeadDetails = $LeadDetails->orderBy('created_at', 'DESC');;
        }


        if (!empty($sort)) {
            if ($sort == "Customer Name") {
                $LeadDetails = $LeadDetails->orderBy('customer.name');
            } elseif ($sort == "Agent") {
                $LeadDetails = $LeadDetails->orderBy('agent.name');
            } elseif ($sort == "Case Manager") {
                $LeadDetails = $LeadDetails->orderBy('caseManager.name');
            } elseif ($sort == "Dispatch Type") {
                $LeadDetails = $LeadDetails->orderBy('dispatchType.dispatchType');
            } elseif ($sort == "Delivery Mode") {
                $LeadDetails = $LeadDetails->orderBy('deliveryMode.deliveryMode');
            }
        } elseif (empty($sort)) {
            $LeadDetails = $LeadDetails->orderBy('created_at', 'DESC');
        }

        if ($search) {
            $LeadDetails = $LeadDetails->where(function ($query) use ($search) {
                $query->Where('referenceNumber', 'like', '%' . $search . '%')
                    ->orWhere('customer.name', 'like', '%' . $search . '%')
                    ->orWhere('customer.recipientName', 'like', '%' . $search . '%')
                    ->orWhere('customer.customerCode', 'like', '%' . $search . '%')
                    ->orWhere('agent.name', 'like', '%' . $search . '%')
                    ->orWhere('caseManager.name', 'like', '%' . $search . '%')
                    ->orWhere('contactNumber', 'like', '%' . $search . '%')
                    //					->orWhere('contactEmail', 'like', '%' . $search . '%')
                    ->orWhere('deliveryMode.deliveryMode', 'like', '%' . $search . '%')
                    ->orWhere('dispatchStatus', 'like', '%' . $search . '%')
                    ->orWhere('dispatchType.dispatchType', 'like', '%' . $search . '%');
            });


            session()->put('search', $search);
        }
        $LeadDetails = $LeadDetails->select('customer', 'created_at', 'contactNumber', 'transferTo', 'contactEmail', 'referenceNumber', 'deliveryMode', 'dispatchType', 'employee', 'agent', 'dispatchDetails.land_mark', 'dispatchDetails.documentDetails');
        $data[] = array('Leads List');
        $excel_header = [
            'CID',
            'CUSTOMER NAME',
            'LEAD CREATED DATE',
            'TRANSACTION NUMBER',
            'DISPATCH TYPE',
            'TYPE OF DOCUMENT',
            'TYPE OF DELIVERY',
            'AMOUNT / CARDS',
            'CUSTOMER CONTACT NUMBER',
            'CUSTOMER EMAIL ID',
            'RECIPIENT NAME',
            'AGENT NAME',
            'DELIVERY MODE',
            'ASSIGNED TO',
            'LAND MARK',
            'DOCUMENT DESCRIPTION'
        ];
        $file_name = 'Leads_list' . (string) time() . rand();
        Excel::create($file_name, function ($excel) use ($LeadDetails, $excel_header) {
            $excel->sheet('Leads List', function ($sheet) use ($LeadDetails, $excel_header) {
                $sheet->appendRow($excel_header);
                $sheet->row(1, function ($row) {
                    $row->setFontSize(10);
                    $row->setFontColor('#ffffff');
                    $row->setBackground('#1155CC');
                });
                $LeadDetails->chunk(100, function ($final_leads) use ($sheet) {
                    foreach ($final_leads as $leads) {
                        // dd($leads);
                        $createdDate = $leads->created_at;
                        $date = date("d/m/Y", strtotime($createdDate));
                        if (isset($leads->employee['name'])) {
                            $assignname = ucwords(strtolower($leads->employee['name']));
                            if (isset($leads->employee['empId'])) {
                                if ($leads->employee['empId'] != "") {
                                    $assignid = $leads->employee['empId'];
                                    $assignvalue = $assignname . ' (' . $assignid . ')';
                                } else {
                                    $assignvalue = $assignname;
                                }
                            } else {
                                $assignvalue = $assignname;
                            }
                        } else {
                            $assignvalue = '--';
                        }
                        if (isset($leads->agent['name'])) {
                            $agentname = ucwords(strtolower($leads->agent['name']));
                            if (isset($leads->agent['empid'])) {
                                if ($leads->agent['empid'] != "") {
                                    $agentid = $leads->agent['empid'];
                                    $agentvalue = ucwords(strtolower($agentname)) . ' (' . $agentid . ')';
                                } else {
                                    $agentvalue = ucwords(strtolower($agentname));
                                }
                            } else {
                                $agentvalue = ucwords(strtolower($agentname));
                            }
                        } else {
                            $agentvalue = 'NA';
                        }
                        if (isset($leads->contactNumber)) {
                            $contact = $leads->contactNumber;
                        } else {
                            $contact = '--';
                        }
                        if (isset($leads->contactEmail)) {
                            $contactEmail = $leads->contactEmail;
                        } else {
                            $contactEmail = '--';
                        }
                        if (isset($leads['dispatchType.dispatchType'])) {
                            $disType = $leads['dispatchType.dispatchType'];
                        } else {
                            $disType = '--';
                        }
                        if (isset($leads['deliveryMode.deliveryMode'])) {
                            $disMode = $leads['deliveryMode.deliveryMode'];
                        } else {
                            $disMode = '--';
                        }
                        if (isset($leads['customer.customerCode'])) {
                            $custCode = $leads['customer.customerCode'];
                        } else {
                            $custCode = '--';
                        }
                        if (isset($leads['customer.name'])) {
                            $custName = $leads['customer.name'];
                        } else {
                            $custName = '--';
                        }
                        if (isset($leads['customer.recipientName'])) {
                            $recName = $leads['customer.recipientName'];
                        } else {
                            $recName = '--';
                        }
                        if (isset($leads['dispatchDetails.land_mark'])) {
                            $land = $leads['dispatchDetails.land_mark'];
                        } else {
                            $land = '--';
                        }
                        if (isset($leads['dispatchDetails']['documentDetails'])) {
                            $uniqval = [];
                            $employee_id = session('EmpID');
                            $transferto = $leads->transferTo;
                            // dd($leads);
                            foreach ($transferto as $key => $value) {
                                if (($value['status'] == 'Transferred' || $value['status'] == 'Collected') && $value['empCode'] == $employee_id) {
                                    $uniqval[] = $value['uniqval'];
                                }
                            }

                            $leadDocuments = $leads['dispatchDetails']['documentDetails'];
                            foreach ($leadDocuments as $count => $reply) {
                                if (($reply['DocumentCurrentStatus'] == '14' || $reply['DocumentCurrentStatus'] == '9') && (in_array($reply['uniqTransferId'], $uniqval))) {
                                    // d("in");
                                    $data = array(
                                        $custCode ?: '--',
                                        ucwords(strtolower($custName)),
                                        $date,
                                        $leads['referenceNumber'],
                                        $disType,
                                        $reply['documentName'],
                                        $disMode,
                                        $reply['amount'] ?: '--',
                                        $contact,
                                        $contactEmail,
                                        ucwords(strtolower($recName)),
                                        $agentvalue,
                                        $disMode,
                                        $assignvalue,
                                        $land ?: '--',
                                        $reply['documentDescription'] ?: '--'
                                    );
                                    $sheet->appendRow($data);
                                }
                            }
                        } else {
                            $data = array(
                                $custCode ?: '--',
                                ucwords(strtolower($custName)),
                                $date,
                                $leads['referenceNumber'],
                                $disType,
                                '--',
                                $disMode,
                                '--',
                                $contact,
                                $contactEmail,
                                ucwords(strtolower($recName)),
                                $agentvalue,
                                $disMode,
                                $assignvalue,
                                $land ?: '--',
                                '--'
                            );
                            $sheet->appendRow($data);
                        }
                    }
                    //  die();
                });
            });
        })->store('xls', public_path('excel'));
        $excel_name = $file_name . '.' . 'xls';
        $send_excel = public_path('/excel/' . $excel_name);
        //		dd($send_excel);
        $tab_value = 'employee';
        sendExcel::dispatch($email, $send_excel, $tab_value);
        //		Session::flash('status', 'Excel send to '. $email );
        return 'success';
    }


    /**
     * function for employee accept list export asa excel
     */
    public function acceptExport()
    {
        $employee_id = new ObjectId(session('employee_id'));
        $filterData = json_decode(session('filter'));
        $sort = session('sort');
        $search = session('search');
        $leadDetails = LeadDetails::where('active', 1)->whereNotNull('transferTo')->where('dispatchStatus', '!=', 'Completed')->where(
            'transferTo.id',
            $employee_id
        );
        if ($filterData) {
            if (!empty($filterData->caseManager)) {
                $count = 0;
                foreach ($filterData->caseManager as $manager) {
                    $objectArray[$count] = new ObjectId($manager);
                    $count++;
                }
                $leadDetails = $leadDetails->whereIn('caseManager.id', $objectArray);
            }
            if (!empty($filterData->agent)) {
                $count = 0;
                foreach ($filterData->agent as $agent) {
                    $objectArray[$count] = new ObjectId($agent);
                    $count++;
                }
                $leadDetails = $leadDetails->whereIn('agent.id', $objectArray);
            }
            if (!empty($filterData->customer)) {
                $count = 0;
                foreach ($filterData->customer as $cust) {
                    $objectArray[$count] = new ObjectId($cust);
                    $count++;
                }
                $leadDetails = $filterData->whereIn('customer.id', $objectArray);
            }
            if (!empty($filterData->deliveryModeFil)) {
                $count = 0;
                foreach ($filterData->deliveryModeFil as $mode) {
                    $objectArray[$count] = new ObjectId($mode);
                    $count++;
                }
                $leadDetails = $leadDetails->whereIn('deliveryMode.id', $objectArray);
            }
            if (!empty($filterData->dispathTypeCheck)) {
                $count = 0;
                foreach ($filterData->dispathTypeCheck as $type) {
                    $objectArray[$count] = new ObjectId($type);
                    $count++;
                }
                $leadDetails = $leadDetails->whereIn('dispatchType.id', $objectArray);
            }
        } else {
            $leadDetails = $leadDetails->where('dispatchStatus', 'Lead');
        }


        if (!empty($sort)) {
            if ($sort == "Customer Name") {
                $leadDetails = $leadDetails->orderBy('customer.name');
            } elseif ($sort == "Agent") {
                $leadDetails = $leadDetails->orderBy('agent.name');
            } elseif ($sort == "Case Manager") {
                $leadDetails = $leadDetails->orderBy('caseManager.name');
            } elseif ($sort == "Dispatch Type") {
                $leadDetails = $leadDetails->orderBy('dispatchType.dispatchType');
            } elseif ($sort == "Delivery Mode") {
                $leadDetails = $leadDetails->orderBy('deliveryMode.deliveryMode');
            }
        } elseif (empty($sort)) {
            $leadDetails = $leadDetails->orderBy(
                'created_at',
                'DESC'
            );
        }

        if ($search) {
            $leadDetails = $leadDetails->where(function ($query) use ($search) {
                $query->Where('referenceNumber', 'like', '%' . $search . '%')
                    ->orWhere('customer.name', 'like', '%' . $search . '%')
                    ->orWhere('customer.recipientName', 'like', '%' . $search . '%')
                    ->orWhere('customer.customerCode', 'like', '%' . $search . '%')
                    ->orWhere('agent.name', 'like', '%' . $search . '%')
                    ->orWhere('caseManager.name', 'like', '%' . $search . '%')
                    ->orWhere('contactNumber', 'like', '%' . $search . '%')
                    ->orWhere('contactEmail', 'like', '%' . $search . '%')
                    ->orWhere('deliveryMode.deliveryMode', 'like', '%' . $search . '%')
                    ->orWhere('dispatchType.dispatchType', 'like', '%' . $search . '%');
            });
            session()->put('search', $search);
        } else {
            $leadDetails = $leadDetails;
        }

        $final_leads = $leadDetails->get();

        $data[] = array('Leads to be accepted');
        $data[] = [
            'REFERENCE NUMBER',
            'CUSTOMER CODE',
            'CUSTOMER NAME',
            'RECIPIENT NAME',
            'CONTACT NUMBER',
            'EMAIL ID',
            'CASE MANAGER',
            'AGENT',
            'DISPATCH TYPE',
            'DELIVERY MODE',
            'STATUS'
        ];


        foreach ($final_leads as $leads) {
            $data[] = array(

                $leads['referenceNumber'],
                $leads['customer.customerCode'] ?: '--',
                $leads['customer.name'],
                $leads['customer.recipientName'],
                $leads->contactNumber,
                $leads->contactEmail,
                $leads['caseManager.name'],
                $leads['agent.name'],
                $leads['dispatchType.dispatchType'],
                $leads['deliveryMode.deliveryMode'],
                $leads['dispatchStatus'] ?: '--'
            );
        }
        Excel::create('Leads to be accepted', function ($excel) use ($data) {
            $excel->sheet('Leads to be accepted', function ($sheet) use ($data) {
                $sheet->mergeCells('A1:K1');
                $sheet->row(1, function ($row) {
                    $row->setFontSize(15);
                    $row->setFontColor('#ffffff');
                    $row->setBackground('#1155CC');
                });
                $sheet->fromArray($data, null, 'A1', true, false);
            });
        })->download('xls');
    }

    /**
     * function to assign transfer to employee
     */
    public function transferTo(Request $request)
    {
        $address = $request->input('address');
        $date_time = $request->input('date_time');
        $land_mark = $request->input('land_mark');
        $contactNum = $request->input('contactNum');
        $employee_list = $request->input('employee_list');
        $way_bill = $request->input('way_bill');
        $deliveryMode = $request->input('deliveryMode');
        $saveStatus = [];
        $id = $request->input('lead_id');
        $employee = $request->input('employee');
        $documentdetIdArray = $request->input('docDetid');
        $leadDetails = LeadDetails::find($id);
        $referencenumber = $leadDetails->referenceNumber;
        $casemanagerid = $leadDetails->caseManager['id'];
        $casemanager = User::find($casemanagerid);
        $caseemail = $casemanager->email;
        $casename = $casemanager->name;
        $custname = $leadDetails->customer['name'];
        $uniq_id = uniqid();
        $leads = $leadDetails['dispatchDetails']['documentDetails'];
        foreach ($leads as $count => $reply) {
            if (in_array($reply['id'], $documentdetIdArray)) {
                if ($reply['DocumentCurrentStatus'] == '8' || $reply['DocumentCurrentStatus'] == '15') {
                    $saveStatus[] = $this->saveDocumentStatus($id, $count, '14');
                    LeadDetails::where(
                        '_id',
                        new ObjectId($id)
                    )->update(array('dispatchDetails.documentDetails.' . $count . '.uniqTransferId' => $uniq_id));
                }
                if ($reply['DocumentCurrentStatus'] == '2' || $reply['DocumentCurrentStatus'] == '17' || $reply['DocumentCurrentStatus'] == '6') {
                    $saveStatus[] = $this->saveDocumentStatus($id, $count, '9');
                    LeadDetails::where(
                        '_id',
                        new ObjectId($id)
                    )->update(array('dispatchDetails.documentDetails.' . $count . '.uniqTransferId' => $uniq_id));
                }
            }
        }
        $this->saveTabStatus($id);
        $this->setDispatchStatus($id);
        $employee_details = User::find($employee);
        $link = url('/dispatch/employee-view-list/');
        $caselink = url('/dispatch/receptionist-list/');
        $name = $employee_details->name;
        $email = $employee_details->email;
        SendTransferleads::dispatch($name, $email, $referencenumber, $link, $custname, Auth::user()->name);
        $transfer = new \stdClass();
        $transfer->id = new ObjectId($employee_details->_id);
        $transfer->uniqval = $uniq_id;
        $transfer->name = $employee_details->name;
        $transfer->empCode = $employee_details->empID;
        $transfer->transferById = new ObjectId(Auth::id());
        $transfer->transfered_documents = $documentdetIdArray;
        $transfer->transferByName = Auth::user()->name;
        $transfer->transferDate = date('d/m/Y');
        $transfer->status = 'Transferred';
        $transferStatus = $transfer;
        if (isset($leadDetails->employee)) {
            LeadDetails::where('_id', new ObjectId($id))->unset('employee');
        }
        if (isset($leadDetails->deliveryMode)) {
            LeadDetails::where('_id', new ObjectId($id))->unset('deliveryMode');
        }
        $emp_object = new \stdClass();
        $employeeListDetails = User::find($employee_list);
        $emp_object->id = new ObjectId($employeeListDetails->_id);
        $emp_object->name = $employeeListDetails->name;
        $emp_object->empId = $employeeListDetails->empID;
        $leadDetails->employee = $emp_object;

        $delivery = DeliveryMode::find($deliveryMode);
        $deliveryObject = new \stdClass();
        $deliveryObject->id = new ObjectID($delivery->_id);
        $deliveryObject->deliveryMode = $delivery->deliveryMode;
        if ($way_bill != '') {
            $deliveryObject->wayBill = $request->input('way_bill');
        }
        $leadDetails->deliveryMode = $deliveryObject;
        $comment_submit_time = date('H:i:s');
        $comment_submit_object = new \stdClass();
        $comment_submit_object->comment = 'Transferred from reception' . ',' . 'Message' . ' : ' . ucfirst(ucwords($request->input('action_transfer_comment')));
        $comment_submit_object->commentBy = Auth::user()->name;
        $comment_submit_object->commentTime = $comment_submit_time;
        $comment_submit_object->id = new ObjectId(Auth::id());
        $comment_submit_object->date = date('d/m/Y');
        $comment_submit_array[] = $comment_submit_object;
        $leadDetails->push('comments', $comment_submit_array);

        $data = array(
            'dispatchDetails.address' => $address,
            'dispatchDetails.date_time' => $date_time,
            'dispatchDetails.land_mark' => $land_mark,
            'contactNumber' => $contactNum,
            'dispatchDetails.contactNum' => $contactNum
        );
        if (isset($leadDetails->schedulerejectstatus)) {
            LeadDetails::where('_id', new ObjectId($id))->unset('schedulerejectstatus');
        }
        LeadDetails::where('_id', new ObjectID($id))->update($data, ['multiple' => true]);
        Sendcasemangerleads::dispatch($casename, $caseemail, $referencenumber, $name, $caselink, $custname, Auth::user()->name);
        LeadDetails::where('_id', $id)->push(['transferTo' => $transferStatus]);
        $leadDetails->save();
        Session::flash('status', 'Lead is transferred to ' . $employee_details->name);
        return 'success';
        //	     }
    }

    /**
     * to list the completeted lead page
     */
    public function listComplete(Request $request)
    {
        if (!empty($request->input('agent'))) {
            $count = 0;
            foreach ($request->input('agent') as $cust) {
                $objectArray[$count] = new ObjectId($cust);
                $count++;
            }
            $agents = User::where('isActive', 1)->where(function ($q) {
                $q->where('role', 'EM')->orWhere('role', 'AG');
            })->whereIn('_id', $objectArray)->get();
        } else {
            $agents = '';
        }

        if (!empty($request->input('assigned'))) {
            $count = 0;
            foreach ($request->input('assigned') as $cust) {
                $objectArray[$count] = new ObjectId($cust);
                $count++;
            }
            $assigned_to = User::where('isActive', 1)->where(function ($q) {
                $q->where('role', 'EM')->orWhere('role', 'AG')->orWhere('role', 'CR')->orWhere('role', 'MS')->orWhere('role', 'AD')->orWhere('role', 'CO')->orWhere('role', 'SV');
            })->whereIn('_id', $objectArray)->get();
        } else {
            $assigned_to = '';
        }

        if (!empty($request->input('customer'))) {
            $count = 0;
            foreach ($request->input('customer') as $cust) {
                $objectArray[$count] = new ObjectId($cust);
                $count++;
            }
            $customers = Customer::whereIn('_id', $objectArray)->get();
            $recepients = RecipientDetails::whereIn('_id', $objectArray)->get();
            $customers = $customers->merge($recepients);
        } else {
            $customers = '';
        }
        //\		$customer_code = [];
        //		foreach ($customers as $customer) {
        //			$customer_code[] = $customer->customerCode;
        //		}
        if (!empty($request->input('case_manager'))) {
            $count = 0;
            foreach ($request->input('case_manager') as $cust) {
                $objectArray[$count] = new ObjectId($cust);
                $count++;
            }
            $case_managers = User::where('isActive', 1)->where(function ($q) {
                $q->where('role', 'EM')->orWhere('role', 'AD')->orWhere('role', 'RP')->orWhere('role', 'AG')->orWhere('role', 'CO')->orWhere('role', 'SV');
            })->whereIn('_id', $objectArray)->get();
        } else {
            $case_managers = '';
        }

        if (!empty($request->input('dispatch'))) {
            $count = 0;
            foreach ($request->input('dispatch') as $cust) {
                $objectArray[$count] = new ObjectId($cust);
                $count++;
            }
            if (
                session('role') == 'Insurer' || session('role') == 'Employee' || session('role') == 'Agent' || session('role') == 'Coordinator' ||
                session('role') == 'Courier' || session('role') == 'Messenger' || session('role') == 'Accountant' || session('role') == 'Supervisor'
            ) {
                $dispatch_type_check = DispatchTypes::where('type', '!=', 'Direct Collections')->whereIn('_id', $objectArray)->get();
            } else {
                $dispatch_type_check = DispatchTypes::whereIn('_id', $objectArray)->get();
            }
        } else {
            $dispatch_type_check = '';
        }
        if (!empty($request->input('delivery'))) {
            $count = 0;
            foreach ($request->input('delivery') as $cust) {
                $objectArray[$count] = new ObjectId($cust);
                $count++;
            }
            $delivery_mode_check = DeliveryMode::whereIn('_id', $objectArray)->get();
        } else {
            $delivery_mode_check = '';
        }
        $delivery_mode = DeliveryMode::all();
        $dispatch_types = DispatchTypes::all();
        $document_types = DocumentType::all();
        $filter_data = $request->input();
        $current_path = $request->path();
        if (!empty($request->input('status'))) {
            $count = 0;
            foreach ($request->input('status') as $cust) {
                $objectArray[$count] = $cust;
                $count++;
            }
            $Allstatus = DispatchStatus::whereIn('status', $objectArray)->groupBy('status')->get();
        } else {
            $Allstatus = '';
        }
        return view('dispatch.complete_list')
            ->with(compact(
                'customers',
                'agents',
                'current_path',
                'case_managers',
                'delivery_mode',
                'dispatch_types',
                'dispatch_type_check',
                'Allstatus',
                'delivery_mode_check',
                'assigned_to',
                'filter_data',
                'document_types'
            ));
    }

    /**
     * to list the transffered lead page
     */
    public function Transferred(Request $request)
    {
        if (!empty($request->input('agent'))) {
            $count = 0;
            foreach ($request->input('agent') as $cust) {
                $objectArray[$count] = new ObjectId($cust);
                $count++;
            }
            $agents = User::where('isActive', 1)->where(function ($q) {
                $q->where('role', 'EM')->orWhere('role', 'AG');
            })->whereIn('_id', $objectArray)->get();
        } else {
            $agents = '';
        }

        if (!empty($request->input('assigned'))) {
            $count = 0;
            foreach ($request->input('assigned') as $cust) {
                $objectArray[$count] = new ObjectId($cust);
                $count++;
            }
            $assigned_to = User::where('isActive', 1)->where(function ($q) {
                $q->where('role', 'EM')->orWhere('role', 'AG')->orWhere('role', 'CR')->orWhere('role', 'MS')->orWhere('role', 'AD')->orWhere('role', 'CO')->orWhere('role', 'SV');
            })->whereIn('_id', $objectArray)->get();
        } else {
            $assigned_to = '';
        }

        if (!empty($request->input('customer'))) {
            $count = 0;
            foreach ($request->input('customer') as $cust) {
                $objectArray[$count] = new ObjectId($cust);
                $count++;
            }
            $customers = Customer::whereIn('_id', $objectArray)->get();
            $recepients = RecipientDetails::whereIn('_id', $objectArray)->get();
            $customers = $customers->merge($recepients);
        } else {
            $customers = '';
        }
        //\		$customer_code = [];
        //		foreach ($customers as $customer) {
        //			$customer_code[] = $customer->customerCode;
        //		}
        if (!empty($request->input('case_manager'))) {
            $count = 0;
            foreach ($request->input('case_manager') as $cust) {
                $objectArray[$count] = new ObjectId($cust);
                $count++;
            }
            $case_managers = User::where('isActive', 1)->where(function ($q) {
                $q->where('role', 'EM')->orWhere('role', 'AD')->orWhere('role', 'RP')->orWhere('role', 'AG')->orWhere('role', 'CO')->orWhere('role', 'SV');
            })->whereIn('_id', $objectArray)->get();
        } else {
            $case_managers = '';
        }

        if (!empty($request->input('dispatch'))) {
            $count = 0;
            foreach ($request->input('dispatch') as $cust) {
                $objectArray[$count] = new ObjectId($cust);
                $count++;
            }
            if (
                session('role') == 'Insurer' || session('role') == 'Employee' || session('role') == 'Agent' || session('role') == 'Coordinator' ||
                session('role') == 'Supervisor' || session('role') == 'Courier' || session('role') == 'Messenger' || session('role') == 'Accountant'
            ) {
                $dispatch_type_check = DispatchTypes::where('type', '!=', 'Direct Collections')->whereIn('_id', $objectArray)->get();
            } else {
                $dispatch_type_check = DispatchTypes::whereIn('_id', $objectArray)->get();
            }
        } else {
            $dispatch_type_check = '';
        }
        if (!empty($request->input('delivery'))) {
            $count = 0;
            foreach ($request->input('delivery') as $cust) {
                $objectArray[$count] = new ObjectId($cust);
                $count++;
            }
            $delivery_mode_check = DeliveryMode::whereIn('_id', $objectArray)->get();
        } else {
            $delivery_mode_check = '';
        }
        if (!empty($request->input('status'))) {
            $count = 0;
            foreach ($request->input('status') as $cust) {
                $objectArray[$count] = $cust;
                $count++;
            }
            $Allstatus = DispatchStatus::whereIn('status', $objectArray)->groupBy('status')->get();
        } else {
            $Allstatus = '';
        }
        $delivery_mode = DeliveryMode::all();
        $dispatch_types = DispatchTypes::all();
        $document_types = DocumentType::all();
        $filter_data = $request->input();
        $current_path = $request->path();
        return view('dispatch.transferred')
            ->with(compact(
                'customers',
                'agents',
                'case_managers',
                'delivery_mode',
                'dispatch_types',
                'delivery_mode_check',
                'dispatch_type_check',
                'assigned_to',
                'Allstatus',
                'filter_data',
                'document_types',
                'leadId',
                'current_path'
            ));
    }

    /**
     * to list the data in completed datatable
     */
    public function completeData(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $filter = $request->input('search');
        $filter_data_en = $request->get('filterData');
        $filter_data = json_decode($filter_data_en);
        $sort = $request->get('field');
        $search = (isset($filter['value'])) ? $filter['value'] : false;
        session()->put('filter', $filter_data_en);
        session()->put('sort', $sort);
        $LeadDetails = LeadDetails::where('active', 1)->where('completedTabStatus', (int) 1);
        //		if(session('role') == 'Employee'){
        //			$LeadDetails = $LeadDetails->where(function ($q) {
        //				$q->where('caseManager.id', new ObjectID(Auth::user()->_id))
        //					->orwhere('agent.id', new ObjectID(Auth::user()->_id))
        //					->orwhere('employee.id', new ObjectID(Auth::user()->_id));
        //			});
        //		}
        if (session('role') == 'Agent') {
            $LeadDetails = $LeadDetails->where(function ($q) {
                $q->where('agent.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('employee.id', new ObjectID(Auth::user()->_id));
            });
        } elseif (session('role') == 'Coordinator') {
            $LeadDetails = $LeadDetails->where(function ($q) {
                $q->where('agent.id', session('assigned_agent'))
                    ->orwhere('agent.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('employee.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('employee.id', session('assigned_agent'));
            });
        }
        //		else if(session('role') != 'Admin' && session('role') != 'Receptionist'&& session('role') != 'Agent'){
        //			$LeadDetails = $LeadDetails->where('employee.id', new ObjectID(Auth::user()->_id));
        //		}

        if (!empty($filter_data)) {
            if (!empty($filter_data->agent)) {
                $count = 0;
                foreach ($filter_data->agent as $agent) {
                    $objectArray[$count] = new ObjectId($agent);
                    $count++;
                }
                $LeadDetails = $LeadDetails->whereIn('agent.id', $objectArray);
            }
            if (!empty($filter_data->case_manager)) {
                $count = 0;
                foreach ($filter_data->case_manager as $manager) {
                    $objectArray[$count] = new ObjectId($manager);
                    $count++;
                }
                $LeadDetails = $LeadDetails->whereIn('caseManager.id', $objectArray);
            }
            if (!empty($filter_data->customer)) {
                $count = 0;
                foreach ($filter_data->customer as $cust) {
                    $objectArray[$count] = new ObjectId($cust);
                    $count++;
                }
                $LeadDetails = $LeadDetails->whereIn('customer.id', $objectArray);
            }
            if (!empty($filter_data->delivery)) {
                $count = 0;
                foreach ($filter_data->delivery as $mode) {
                    $objectArray[$count] = new ObjectId($mode);
                    $count++;
                }
                $LeadDetails = $LeadDetails->whereIn('deliveryMode.id', $objectArray);
            }
            if (!empty($filter_data->dispatch)) {
                $count = 0;
                foreach ($filter_data->dispatch as $type) {
                    $objectArray[$count] = new ObjectId($type);
                    $count++;
                }
                $LeadDetails = $LeadDetails->whereIn('dispatchType.id', $objectArray);
            }
            if (!empty($filter_data->assigned)) {
                $count = 0;
                foreach ($filter_data->assigned as $type) {
                    $objectArray[$count] = new ObjectId($type);
                    $count++;
                }
                $LeadDetails = $LeadDetails->whereIn('employee.id', $objectArray);
            }
            if (!empty($filter_data->status)) {
                $count = 0;
                foreach ($filter_data->status as $stat) {
                    $objectArray[$count] = $stat;
                    $count++;
                }
                $LeadDetails = $LeadDetails->whereIn('dispatchStatus', $objectArray);
            }
        }

        if (!empty($sort)) {
            if ($sort == "Customer Name") {
                $LeadDetails = $LeadDetails->orderBy('customer.name');
            } elseif ($sort == "Agent") {
                $LeadDetails = $LeadDetails->orderBy('agent.name');
            } elseif ($sort == "Case Manager") {
                $LeadDetails = $LeadDetails->orderBy('caseManager.name');
            } elseif ($sort == "Dispatch Type") {
                $LeadDetails = $LeadDetails->orderBy('dispatchType.dispatchType');
            } elseif ($sort == "Delivery Mode") {
                $LeadDetails = $LeadDetails->orderBy('deliveryMode.deliveryMode');
            }
        } elseif (empty($sort)) {
            $LeadDetails = $LeadDetails->orderBy('created_at', 'DESC');
        }
        if ($search) {
            $LeadDetails = $LeadDetails->where(function ($query) use ($search) {
                $query->Where('referenceNumber', 'like', '%' . $search . '%')
                    ->orWhere('customer.name', 'like', '%' . $search . '%')
                    ->orWhere('customer.recipientName', 'like', '%' . $search . '%')
                    ->orWhere('customer.customerCode', 'like', '%' . $search . '%')
                    ->orWhere('agent.name', 'like', '%' . $search . '%')
                    ->orWhere('caseManager.name', 'like', '%' . $search . '%')
                    ->orWhere('contactNumber', 'like', '%' . $search . '%')
                    ->orWhere('dispatchStatus', 'like', '%' . $search . '%')
                    ->orWhere('deliveryMode.deliveryMode', 'like', '%' . $search . '%')
                    ->orWhere('dispatchType.dispatchType', 'like', '%' . $search . '%');
            });


            session()->put('search', $search);
        }
        if ($search == "") {
            $LeadDetails = $LeadDetails;
            session()->put('search', "");
        }

        $searchField = $request->get('searchField');
        if ($searchField != "") {
            $LeadDetails = $LeadDetails->where(function ($query) use ($searchField) {
                $query->Where('referenceNumber', 'like', '%' . $searchField . '%')
                    ->orWhere('customer.name', 'like', '%' . $searchField . '%')
                    ->orWhere('customer.recipientName', 'like', '%' . $searchField . '%')
                    ->orWhere('customer.customerCode', 'like', '%' . $searchField . '%')
                    ->orWhere('agent.name', 'like', '%' . $searchField . '%')
                    ->orWhere('caseManager.name', 'like', '%' . $searchField . '%')
                    ->orWhere('contactNumber', 'like', '%' . $searchField . '%')
                    ->orWhere('dispatchStatus', 'like', '%' . $searchField . '%')
                    ->orWhere('deliveryMode.deliveryMode', 'like', '%' . $searchField . '%')
                    ->orWhere('dispatchType.dispatchType', 'like', '%' . $searchField . '%');
            });
        }
        $total_leads = $LeadDetails->count(); // get your total no of data;
        $members_query = $LeadDetails;
        $search_count = $members_query->count();
        $LeadDetails->skip((int) $start)->take((int) $length);
        $final_leads = $LeadDetails->get();


        foreach ($final_leads as $leads) {
            $check = '<div class="custom_checkbox">' .
                '<input type="checkbox" name="marked_list[]" value="" id="' . $leads->_id . '" class="inp-cbx" style="display: none" onchange="markedCheck(this.id)">' .
                '<label for="' . $leads->_id . '" class="cbx">' .
                '<span>' .
                '    <svg width="10px" height="8px" viewBox="0 0 12 10">' .
                '      <polyline points="1.5 6 4.5 9 10.5 1"></polyline>' .
                '    </svg>' .
                '</span>' .
                '</label>' .
                '</div>';

            if ($leads['referenceNumber'] == '') {
                $referenceNumber = '--';
            } else {
                $referenceNumber = '<a href="#" class="auto_modal table_link" data-toggle="tooltip" data-placement="bottom" title="View Dispatch Slip" data-container="body"  data-modal="view_lead_popup" dir="' . $leads->_id . '" onclick="view_lead_popup(\'' . $leads->_id . '\');">

' . $leads['referenceNumber'] . '  </a> ';
            }
            if (isset($leads->agent['name'])) {
                $agentname = $leads->agent['name'];
                if (isset($leads->agent['empid'])) {
                    if ($leads->agent['empid'] != "") {
                        $agentid = $leads->agent['empid'];
                        $agentvalue = $agentname . ' (' . $agentid . ')';
                    } else {
                        $agentvalue = $agentname;
                    }
                } else {
                    $agentvalue = $agentname;
                }
            } else {
                $agentvalue = 'NA';
            }
            $agent = $agentvalue;
            $caseManager = $leads['caseManager.name'];
            $email = $leads->contactEmail;
            $contact = $leads->contactNumber;
            $recipientName = $leads['customer.recipientName'];
            $dispatchType = $leads['dispatchType.dispatchType'];
            $deliveryMode = $leads['deliveryMode.deliveryMode'];
            $code = $leads['customer.customerCode'] ?: '--';
            $customerName = $leads['customer.name'];
            $created_at = $leads->created_at;
            if (isset($leads->employee['name'])) {
                $assignname = $leads->employee['name'];
                if (isset($leads->employee['empId'])) {
                    if ($leads->employee['empId'] != "") {
                        $assignid = $leads->employee['empId'];
                        $assignvalue = $assignname . ' (' . $assignid . ')';
                    } else {
                        $assignvalue = $assignname;
                    }
                } else {
                    $assignvalue = $assignname;
                }
            } else {
                $assignvalue = '--';
            }
            $status = $leads->dispatchStatus;
            //             $leads->checkall = $check;
            $leads->customerCode = $code;
            $leads->referenceNumber = $referenceNumber;
            $leads->customerName = $customerName;
            $leads->recipientName = $recipientName;
            $leads->contactNo = $contact;
            $leads->email = $email;
            $leads->caseManager = $caseManager;
            $leads->agent = $agent;
            $leads->dispatchType = $dispatchType;
            $leads->deliveryMode = $deliveryMode;
            $leads->status = $status;
            $leads->assigned = $assignvalue;
            $leads->created = Carbon::parse($created_at)->format('d/m/Y');
        }
        if ($search) {
            $filtered_count = $search_count;
        } else {
            $filtered_count = $total_leads;
        }


        $data = array(
            'draw' => $draw,
            'recordsTotal' => $total_leads,
            'recordsFiltered' => $filtered_count,
            'data' => $final_leads,
        );

        return json_encode($data);
    }

    /**
     * view recipients listing page
     */
    public function recipients(Request $request)
    {
        $mainGroups = Customer::where('mainGroup.id', (string) 0)->get();
        $recipients = RecipientDetails::where('status', (int) 1)->get();
        $agents = User::where('isActive', 1)->where('role', 'AG')->orderby('name')->get();
        $customerLevels = CustomerLevel::get();
        $filter_data = $request->input();
        return view('dispatch.recipients.recipients_list')->with(compact(
            'recipients',
            'mainGroups',
            'agents',
            'customerLevels',
            'filter_data'
        ));
    }

    /**
     * recipients data table
     */
    public function recipientsData(Request $request)
    {
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $filter = $request->input('search');
        $filter_data_en = $request->input('filter_data');
        $filter_data = json_decode($filter_data_en);
        $sort = $request->input('field');
        $search = (isset($filter['value'])) ? $filter['value'] : false;
        session()->put('filter', $filter_data_en);
        session()->put('sort', $sort);
        $recipients = RecipientDetails::where('status', 1);
        // if (session('role') == 'Agent') {
        //     $recipients = $recipients->where(function ($q) {
        //         $q->where('agent.id', new ObjectID(Auth::user()->_id));
        //     });
        // }
        // if (session('role') == 'Coordinator') {
        //     $recipients = $recipients->where(function ($q) {
        //         $q->where('agent.id', session('assigned_agent'));
        //     });
        // }
        if (!empty($filter_data)) {
            // if (!empty($filter_data->agent)) {
            //     $count = 0;
            //     foreach ($filter_data->agent as $agent) {
            //         $objectArray[$count] = new ObjectId($agent);
            //         $count++;
            //     }
            //     $recipients = $recipients->whereIn('agent.id', $objectArray);
            // }
        }

        if (!empty($sort)) {
            if ($sort == "Customer Name") {
                $recipients = $recipients->orderBy('fullName', 'ASC');
            } elseif ($sort == "Agent") {
                $recipients = $recipients->orderBy('agent.name');
            }
        } elseif (empty($sort)) {
            $recipients = $recipients->orderBy('createdAt', 'DESC');
        }

        if ($search) {
            $recipients = $recipients->where(function ($query) use ($search) {
                $query->Where('fullName', 'like', '%' . $search . '%')
                    ->orWhere('contactNumber', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
                    // ->orWhere('agent.name', 'like', '%' . $search . '%');
            });
            session()->put('search', $search);
        }
        if ($search == "") {
            $recipients = $recipients;
            session()->put('search', "");
        }

        $searchField = $request->get('searchField');
        if ($searchField != "") {
            $recipients = $recipients->where(function ($query) use ($searchField) {
                $query->Where('fullName', 'like', '%' . $searchField . '%')
                    ->orWhere('contactNumber', 'like', '%' . $searchField . '%')
                    ->orWhere('email', 'like', '%' . $searchField . '%');
                    // ->orWhere('agent.name', 'like', '%' . $searchField . '%');
            });
        }


        $total_recipient = $recipients->count(); // get your total no of data;

        $members_query = $recipients;
        $search_count = $members_query->count();
        $recipients->skip((int) $start)->take((int) $length);
        $total_recipients = $recipients->get();


        foreach ($total_recipients as $recipient) {
            if (session('role') == 'Admin') {
                $action1 = '<button class="btn export_btn waves-effect auto_modal delete_icon_btn" data-toggle="tooltip" data-placement="bottom" title="Delete" data-container="body"  data-modal="delete_popup" dir="' . $recipient->_id . '" onclick="delete_pop(\'' . $recipient->_id . '\');">
<i class="material-icons">delete_outline</i>
</button>
';
            } else {
                $action1 = '';
            }
            $action2 = '<a href="' . URL::to('dispatch/view-recipient/' . $recipient->_id) . '" class="btn btn-sm btn-success" style="font-weight: 600">View Details</a>';
            $mainGroup = $recipient['mainGroup.id'] != "0" ? $recipient['mainGroup.name'] : 'Nil';


            if (isset($recipient['agent'])) {
                $agent = User::find($recipient['agent.id']);
                $agentId = $agent['empID'];
                if (isset($agentId) && $agentId != '') {
                    $agentId = $agent['name'] . '( ' . $agentId . ')';
                } else {
                    $agentId = $agent['name'];
                }
            } else {
                $agentId = '--';
            }

            $agent = $agentId;
            $level = $recipient['customerLevel.name'];
            if (is_array($recipient->email)) {
                $email = $recipient->email['0'];
            } else {
                $email = $recipient->email;
            }

            if (is_array($recipient->contactNumber)) {
                $contact = $recipient->contactNumber['0'];
            } else {
                $contact = $recipient->contactNumber;
            }

            if (!empty($recipient->salutation)) {
                $name = '<a href="' . URL::to('dispatch/view-recipient/' . $recipient->_id) . '" class="p">' . ucwords(strtolower($recipient->salutation)) . ucwords(strtolower($recipient->fullName)) . '</a>';
            } else {
                $name = '<a href="' . URL::to('dispatch/view-recipient/' . $recipient->_id) . '" class="p">' . ucwords(strtolower($recipient->fullName)) . '</a>';
            }
            //	        if($customer->department)
            //	        {
            //	        	$dpt_name=$customer->getDepartment->name;
            //	        }
            //	        else{
            //	        	$dpt_name='';
            //	        }
            if (isset($recipient['departmentDetails'])) {
                $policyDetails = $recipient['policyDetails'];
                $policy = count($policyDetails);
            } else {
                $policy = 0;
            }
            $recipient->fullName = $name;
            $recipient->contactNumber = $contact ?: '--';
            $recipient->email = $email ?: '--';
            // $recipient->agent = $agent ?: '--';
            $recipient->policies = $policy ?: '--';
            $recipient->action1 = $action1 ?: '';
            $recipient->action2 = $action2 ?: '--';
        }
        if ($search) {
            $filtered_count = $search_count;
        } else {
            $filtered_count = $total_recipient;
        }


        $data = array(
            'draw' => $draw,
            'recordsTotal' => $total_recipient,
            'recordsFiltered' => $filtered_count,
            'data' => $total_recipients,
        );

        return json_encode($data);
    }

    /**
     * create recipients
     */
    public function createRecipients()
    {
        $mainGroups = Customer::where('status', 1)->where('mainGroup.id', (string) 0)->get();
        $customerLevels = CustomerLevel::get();
        $customerTypes = CustomerType::get();
        $departments = Departments::get();
        $all_countries = CountryListModel::get();
        $cities = State::all();
        $countries = [];
        foreach ($all_countries as $key => $country) {
            $name = $country['country'];
            $countries[] = $name['countryName'];
        }
        return view('dispatch.recipients.create_recipients')
            ->with(compact(
                'mainGroups',
                'customerLevels',
                'customerTypes',
                // 'agents',
                'cities',
                'countries',
                'departments'
            ));
    }

    /**
     * save recipents
     */
    public function saveRecipients(Request $request)
    {
        if ($request->input('recipient_id')) {
            $data = $request->except([
                '_token',
                'customer_id',
                'depContactMobile',
                'depContactPerson',
                'department',
                'depContactEmail'
            ]);
            $customer_type = $data['customerType'];
            $customer_type_details = CustomerType::where('is_corporate', (int) $customer_type)->first();
            if ($customer_type == 0) {
                $data["fullName"] = ucwords(strtolower($data['firstName'] . " " . $data['middleName'] . " " . $data['lastName']));
            } else {
                $data["firstName"] = ucwords(strtolower($data["corFirstName"]));
                $data["fullName"] = ucwords(strtolower($data['corFirstName']));
            }
            $data["customerCodeValue"] = strtolower($request->input('customerCode')) ?: '';
            $data["customerType"] = new ObjectID($customer_type_details->_id) ?: '';
            $data["status"] = 1;

            // if (count($request->input('agent')) != 0) {
            //     $agent_object = new \stdClass();
            //     $id_agent = $request->input('agent');
            //     $agent = User::find($id_agent);
            //     $name_agent = $agent->name;
            //     $agent_object->id = new ObjectID($id_agent);
            //     $agent_object->name = $name_agent;
            //     $data["agent"] = $agent_object;
            // }
            $deartment_name = $request->input('department');
            $deartment_contact_person = $request->input('depContactPerson');
            $deartment_contact_person_email = $request->input('depContactEmail');
            $deartment_contact_person_mobile = $request->input('depContactMobile');
            $array_unique_count = count(array_unique($deartment_name));
            $array_actual_count = count($deartment_name);
            if ($array_actual_count != $array_unique_count) {
                return "department_exist";
            }

            $recipient = RecipientDetails::find($request->input('recipient_id'));
            $departmentid = [];
            $departments = $recipient['departmentDetails'];
            if ($departments) {
                foreach ($departments as $department) {
                    $departmentid[] = $department['department'];
                }
            }

            $deprtment_array = [];
            foreach ($deartment_name as $key => $department) {
                if ($department != '' && $deartment_contact_person[$key] != '' && $deartment_contact_person_email[$key] != '' && $deartment_contact_person_mobile[$key] != '') {
                    $department_object = new \stdClass();
                    $department_object->department = new ObjectID($department);
                    $department_name = Departments::find($department);
                    $department_object->departmentName = $department_name->name;
                    $department_object->depContactPerson = $deartment_contact_person[$key];
                    $department_object->depContactEmail = $deartment_contact_person_email[$key];
                    $department_object->depContactMobile = $deartment_contact_person_mobile[$key];
                    $deprtment_array[] = $department_object;
                } else {
                    $deprtment_array = [];
                }
            }
            if (!empty($deprtment_array)) {
                $data["departmentDetails"] = $deprtment_array;
            }
            DB::collection('recipientsDetails ')->where('_id', new ObjectID($request->input('recipient_id')))
                ->update($data);
            Session::flash('status', 'Recipient details updated successfully.');
            return "success";
        } else {
            $data = $request->except([
                '_token',
                'depContactMobile',
                'depContactPerson',
                'department',
                'depContactEmail'
            ]);
            $customer_type = $data['customerType'] ?: '';
            $customer_type_details = CustomerType::where('is_corporate', (int) $customer_type)->first();
            if ($customer_type == 0) {
                $data["fullName"] = ucwords(strtolower($data['firstName'] . " " . $data['middleName'] . " " . $data['lastName']));
            } else {
                $data["firstName"] = ucwords(strtolower($data["corFirstName"]));
                $data["fullName"] = ucwords(strtolower($data['corFirstName']));
                $data["salutation"] = '';
                $data["middleName"] = '';
                $data["lastName"] = '';
            }
            $data["customerType"] = new ObjectID($customer_type_details->_id);
            $data["status"] = 1;
            $deartment_name = $request->input('department');

            $deartment_contact_person = $request->input('depContactPerson');
            $deartment_contact_person_email = $request->input('depContactEmail');
            $deartment_contact_person_mobile = $request->input('depContactMobile');
            $deprtment_array = [];
            $array_unique_count = count(array_unique($deartment_name));
            $array_actual_count = count($deartment_name);
            if ($array_actual_count != $array_unique_count) {
                return "department_exist";
            }
            foreach ($deartment_name as $key => $department) {
                if ($department != '' && $deartment_contact_person[$key] != '' && $deartment_contact_person_email[$key] != '' && $deartment_contact_person_mobile[$key] != '') {
                    $department_object = new \stdClass();
                    $department_object->department = new ObjectID($department);
                    $department_name = Departments::find($department);
                    $department_object->departmentName = $department_name->name;
                    $department_object->depContactPerson = $deartment_contact_person[$key];
                    $department_object->depContactEmail = $deartment_contact_person_email[$key];
                    $department_object->depContactMobile = $deartment_contact_person_mobile[$key];
                    $deprtment_array[] = $department_object;
                } else {
                    $deprtment_array = [];
                }
            }
            if (!empty($deprtment_array)) {
                $data["departmentDetails"] = $deprtment_array;
            }
            // if (count($request->input('agent')) != 0) {
            //     $id_agent = $request->input('agent');
            //     $agent = User::find($id_agent);
            //     $agent_object = new \stdClass();
            //     $name_agent = $agent->name;
            //     $agent_object->id = new ObjectID($id_agent);
            //     $agent_object->name = $name_agent;
            //     $data["agent"] = $agent_object;
            // }
            $created_by = Auth::user()->name;
            $data["created_by"] = $created_by;
            RecipientDetails::create($data);
            Session::flash('status', 'Recipient added successfully.');
            return "success";
        }
    }

    /**
     * view recipient details
     */
    public function viewRecipient($rec_id)
    {
        $details = RecipientDetails::find($rec_id);
        if (isset($details['agent'])) {
            $agent = User::find($details['agent.id']);
            $agentId = $agent['empID'];
            if (isset($agentId) && $agentId != '') {
                $agentId = $agent['name'] . '( ' . $agentId . ')';
            } else {
                $agentId = $agent['name'];
            }
        } else {
            $agentId = '';
        }

        if ($details) {
            return view('dispatch.recipients.recipient_details')->with(compact('details', 'agentId'));
        } else {
            return view('error');
        }
    }

    /**
     * edit recipient page
     */
    public function editRecipient($rec_id)
    {
        $mainGroups = Customer::where('mainGroup.id', (string) 0)->get();
        $recipientDetails = RecipientDetails::find($rec_id);
        $customerLevels = CustomerLevel::get();
        // $agents = User::where('isActive', 1)->where('role', 'AG')->get();
        $customerTypes = CustomerType::get();
        $departments = Departments::get();
        //		if(isset($recipientDetails->countryName)&&!empty($recipientDetails->countryName))
        //		{
        //			$all_countries=CountryListModel::where('country.countryName',$recipientDetails->countryName)->first();
        //			$name=$all_countries['country'];
        //			$countries[]=$name['countryName'];
        //		}
        //		else{
        $all_countries = CountryListModel::get();
        $cities = State::all();
        $countries = [];
        foreach ($all_countries as $key => $country) {
            $name = $country['country'];
            $countries[] = $name['countryName'];
        }
        //		}
        if ($recipientDetails) {
            return view('dispatch.recipients.create_recipients')
                ->with(compact(
                    'mainGroups',
                    'customerLevels',
                    'customerTypes',
                    // 'agents',
                    'cities',
                    'countries',
                    'recipientDetails',
                    'departments'
                ));
        } else {
            return view('error');
        }
    }

    /**
     * export recipient
     */
    public function exportRecipients(Request $request)
    {
        ini_set('xdebug.max_nesting_level', 500);
        $email = $request->input('email');
        $filter_data = json_decode(session('filter'));
        $sort = session('sort');
        $search = session('search');
        $user_lists = RecipientDetails::where('status', 1);
        // if (session('role') == 'Agent') {
        //     $user_lists = $user_lists->where(function ($q) {
        //         $q->where('agent.id', new ObjectID(Auth::user()->_id));
        //     });
        // }
        // if (session('role') == 'Coordinator') {
        //     $user_lists = $user_lists->where(function ($q) {
        //         $q->where('agent.id', session('assigned_agent'));
        //     });
        // }
        if (!empty($filter_data)) {
            // if (!empty($filter_data->agent)) {
            //     $count = 0;
            //     foreach ($filter_data->agent as $agent) {
            //         $objectArray[$count] = new ObjectId($agent);
            //         $count++;
            //     }
            //     $user_lists = $user_lists->whereIn('agent.id', $objectArray);
            // }
            if (!empty($filter_data->level)) {
                $count = 0;
                foreach ($filter_data->level as $level) {
                    $objectArray[$count] = new ObjectId($level);
                    $count++;
                }
                $user_lists = $user_lists->whereIn('customerLevel.id', $objectArray);
            }
            if (!empty($filter_data->mainGroup)) {
                $count = 0;
                foreach ($filter_data->mainGroup as $mainGroup) {
                    if ($mainGroup != "Nil") {
                        $objectArray[$count] = new ObjectId($mainGroup);
                        $count++;
                    } else {
                        $objectArray[$count] = '0';
                        $count++;
                    }
                }
                $user_lists = $user_lists->whereIn('mainGroup.id', $objectArray);
            }
        }

        if (!empty($sort)) {
            if ($sort == "Customer Name") {
                $user_lists = $user_lists->orderBy('fullName');
            } 
            // elseif ($sort == "Agent") {
            //     $user_lists = $user_lists->orderBy('agent.name');
            // } 
            elseif ($sort == "Main Group") {
                $user_lists = $user_lists->orderBy('mainGroup.name');
            }
        } elseif (empty($sort)) {
            $user_lists = $user_lists->orderBy('created_at', 'DESC');
        }


        if (!empty($search)) {
            $user_lists = $user_lists->where(function ($query) use ($search) {
                $query->Where('fullName', 'like', '%' . $search . '%')
                    ->orWhere('contactNumber', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    // ->orWhere('agent.name', 'like', '%' . $search . '%')
                    ->orWhere('mainGroup.name', 'like', '%' . $search . '%')
                    ->orWhere('customerLevel.name', 'like', '%' . $search . '%');
            });
        }


        //		$user_list = $user_lists->get();
        $data[] = array('Recipients List');
        $excel_header = [
            'Type',
            'Name',
            'Contact No',
            'Email',
            // 'Agent',
            'Number of Policies',
            'Address Line 1',
            'City',
            'Emirates',
            'Country',
            'Zip Code'
        ];
        $file_name_ = 'Recipients List' . rand();
        Excel::create($file_name_, function ($excel) use ($user_lists, $excel_header) {
            $excel->sheet('Recipients list', function ($sheet) use ($user_lists, $excel_header) {
                $sheet->appendRow($excel_header);
                $sheet->row(1, function ($row) {
                    $row->setFontSize(10);
                    $row->setFontColor('#ffffff');
                    $row->setBackground('#1155CC');
                });
                $user_lists->chunk(100, function ($final) use ($sheet) {
                    foreach ($final as $user) {
                        if (isset($user['departmentDetails'])) {
                            $policyDetails = $user['policyDetails'];
                            $policy = count($policyDetails);
                        } else {
                            $policy = 0;
                        }
                        $mainGroup = $user['mainGroup'];
                        $mainGroupName = ucwords(strtolower($mainGroup['name']));
                        // $agent = $user['agent'];
                        // $agentName = ucwords(strtolower($agent['name']));
                        $level = $user['customerLevel'];
                        $levelName = $level['name'];
                        if (is_array($user['email'])) {
                            $primaryEmail = $user['email'];
                            $email = $primaryEmail[0];
                        } else {
                            $email = $user['email'];
                        }

                        if (is_array($user['contactNumber'])) {
                            $primaryContact = $user['contactNumber'];
                            $contact = $primaryContact[0];
                        } else {
                            $contact = $user['contactNumber'];
                        }

                        if (!empty($user['salutation'])) {
                            $name = $user['salutation'] . $user['fullName'];
                        } else {
                            $name = ucwords(strtolower($user['fullName']));
                        }

                        $data = array(
                            $user->getType->name,
                            $name,
                            $contact,
                            $email ?: '--',
                            // $agentName ?: '--',
                            $policy ?: '--',
                            $user['addressLine1'] ? $user['addressLine1'] : 'Nil',
                            $user['streetName'] ?: '--',
                            $user['cityName'] ?: '--',
                            $user['countryName'] ?: '--',
                            $user['zipCode'] ?: '--',
                        );
                        $sheet->appendRow($data);
                    }
                });
            });
        })->store('xls', public_path('excel'));
        $excel_name = $file_name_ . '.' . 'xls';
        $send_excel = public_path('/excel/' . $excel_name);
        //		dd($send_excel);
        $tab_value = 'recipients';
        sendExcel::dispatch($email, $send_excel, $tab_value);
        //		Session::flash('status', 'Excel send to '. $email );
        return 'success';
    }

    /**
     * delete recipient
     */
    public function deleteRecipient(Request $request)
    {
        $recipientId = $request->input('recipient_id');
        $recipient_details = RecipientDetails::find($recipientId);
        if ($recipient_details) {
            $recipient_details->status = 0;
            $recipient_details->save();
            Session::flash('status', 'Recipient deleted successfully.');
            return "success";
        }
    }


    public function exportCompletedList11()
    {
        // return (new CompletedExport)->download('invoices.xlsx');
        //    return (new InvoicesExport)->download('invoices.csv', \Maatwebsite\Excel\Excel::CSV);

        // ob_end_clean(); 
        // ob_start(); 
        // return Excel::download(new CompletedExport,'karthika.xls');
        $x = Excel::store(new CompletedExport, 'karthika.xlsx')
            ->header('Content-Type', "application/octet-stream; charset=UTF-8");
        return response()->download("/home/nvpc23/projects/iib-l5/storage/app/karthika.xlsx");

        // dd($x);
        // return new CompletedExport();
    }

    /**
     * export completed leads
     */
    public function exportCompletedList(Request $request)
    {
        ini_set('xdebug.max_nesting_level', 256);
        // ini_set('memory_limit','1024M');

        $email = $request->input('email');
        $filter_data = json_decode(session('filter'));
        $sort = session('sort');
        $search = session('search');
        $leadDetails = LeadDetails::where('active', 1)->where('completedTabStatus', (int) 1);
        //		if(session('role') == 'Employee'){
        //			$leadDetails = $leadDetails->where(function ($q) {
        //				$q->where('caseManager.id', new ObjectID(Auth::user()->_id))
        //					->orwhere('agent.id', new ObjectID(Auth::user()->_id))
        //					->orwhere('employee.id', new ObjectID(Auth::user()->_id));
        //			});
        //		}
        if (session('role') == 'Agent') {
            $leadDetails = $leadDetails->where(function ($q) {
                $q->where('agent.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('employee.id', new ObjectID(Auth::user()->_id));
            });
        } elseif (session('role') == 'Coordinator') {
            $leadDetails = $leadDetails->where(function ($q) {
                $q->where('agent.id', session('assigned_agent'))
                    ->orwhere('agent.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('employee.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('employee.id', session('assigned_agent'));
            });
        }
        //		else if(session('role') != 'Admin' && session('role') != 'Receptionist' && session('role') != 'Agent' ){
        //			$leadDetails = $leadDetails->where('employee.id', new ObjectID(Auth::user()->_id));
        //		}

        if (!empty($filter_data)) {
            if (!empty($filter_data->agent)) {
                $count = 0;
                foreach ($filter_data->agent as $agent) {
                    $objectArray[$count] = new ObjectId($agent);
                    $count++;
                }
                $leadDetails = $leadDetails->whereIn('agent.id', $objectArray);
            }
            if (!empty($filter_data->case_manager)) {
                $count = 0;
                foreach ($filter_data->case_manager as $manager) {
                    $objectArray[$count] = new ObjectId($manager);
                    $count++;
                }
                $leadDetails = $leadDetails->whereIn('caseManager.id', $objectArray);
            }
            if (!empty($filter_data->customer)) {
                $count = 0;
                foreach ($filter_data->customer as $cust) {
                    $objectArray[$count] = new ObjectId($cust);
                    $count++;
                }
                $leadDetails = $leadDetails->whereIn('customer.id', $objectArray);
            }
            if (!empty($filter_data->delivery)) {
                $count = 0;
                foreach ($filter_data->delivery as $mode) {
                    $objectArray[$count] = new ObjectId($mode);
                    $count++;
                }
                $leadDetails = $leadDetails->whereIn('deliveryMode.id', $objectArray);
            }
            if (!empty($filter_data->dispatch)) {
                $count = 0;
                foreach ($filter_data->dispatch as $type) {
                    $objectArray[$count] = new ObjectId($type);
                    $count++;
                }
                $leadDetails = $leadDetails->whereIn('dispatchType.id', $objectArray);
            }
            if (!empty($filter_data->assigned)) {
                $count = 0;
                foreach ($filter_data->assigned as $type) {
                    $objectArray[$count] = new ObjectId($type);
                    $count++;
                }
                $leadDetails = $leadDetails->whereIn('employee.id', $objectArray);
            }
            if (!empty($filter_data->status)) {
                $count = 0;
                foreach ($filter_data->status as $stat) {
                    $objectArray[$count] = $stat;
                    $count++;
                }
                $leadDetails = $leadDetails->whereIn('dispatchStatus', $objectArray);
            }
        }


        if (!empty($sort)) {
            if ($sort == "Customer Name") {
                $leadDetails = $leadDetails->orderBy('customer.name');
            } elseif ($sort == "Agent") {
                $leadDetails = $leadDetails->orderBy('agent.name');
            } elseif ($sort == "Case Manager") {
                $leadDetails = $leadDetails->orderBy('caseManager.name');
            } elseif ($sort == "Dispatch Type") {
                $leadDetails = $leadDetails->orderBy('dispatchType.dispatchType');
            } elseif ($sort == "Delivery Mode") {
                $leadDetails = $leadDetails->orderBy('deliveryMode.deliveryMode');
            }
        } elseif (empty($sort)) {
            $leadDetails = $leadDetails;
        }

        if ($search) {
            $leadDetails = $leadDetails->where(function ($query) use ($search) {
                $query->Where('referenceNumber', 'like', '%' . $search . '%')
                    ->orWhere('customer.name', 'like', '%' . $search . '%')
                    ->orWhere('customer.recipientName', 'like', '%' . $search . '%')
                    ->orWhere('customer.customerCode', 'like', '%' . $search . '%')
                    ->orWhere('agent.name', 'like', '%' . $search . '%')
                    ->orWhere('caseManager.name', 'like', '%' . $search . '%')
                    ->orWhere('contactNumber', 'like', '%' . $search . '%')
                    ->orWhere('contactEmail', 'like', '%' . $search . '%')
                    ->orWhere('deliveryMode.deliveryMode', 'like', '%' . $search . '%')
                    ->orWhere('dispatchType.dispatchType', 'like', '%' . $search . '%');
            });
            session()->put('search', $search);
        }
        $leadDetails = $leadDetails->select('customer', 'created_at', 'contactNumber', 'contactEmail', 'referenceNumber', 'deliveryMode', 'dispatchType', 'employee', 'agent', 'dispatchDetails.land_mark', 'dispatchDetails.documentDetails');
        $data[] = array('Completed List');
        $excel_header = [
            'CID',
            'CUSTOMER NAME',
            'LEAD CREATED DATE',
            'TRANSACTION NUMBER',
            'DISPATCH TYPE',
            'TYPE OF DOCUMENT',
            'TYPE OF DELIVERY',
            'AMOUNT / CARDS',
            'CUSTOMER CONTACT NUMBER',
            'CUSTOMER EMAIL ID',
            'RECIPIENT NAME',
            'AGENT NAME',
            'DELIVERY MODE',
            'ASSIGNED TO',
            'LAND MARK',
            'DOCUMENT DESCRIPTION'
        ];
        $file_name = 'Completed List' . rand();
        // foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
        //     foreach ($worksheet->getRowIterator() as $row) {
        //         $cellIterator = $row->getCellIterator();
        //         $cellIterator->setIterateOnlyExistingCells(true);
        //         foreach ($cellIterator as $cell) {
        //             if (preg_match( '/^=/', $cell->getValue())) {
        //                 $cellcoordinate = $cell->getCoordinate();
        //                 $worksheet->setCellValueExplicit($cellcoordinate,$worksheet->getCell($cellcoordinate));
        //             }
        //         }
        //     }
        // }

        Excel::create($file_name, function ($excel) use ($leadDetails, $excel_header) {
            $excel->sheet('Completed list', function ($sheet) use ($leadDetails, $excel_header) {
                $sheet->appendRow($excel_header);
                // $sheet->calculate(false);
                $sheet->setAutoSize(false);
                $sheet->row(1, function ($row) {


                    $row->setFontSize(10);
                    $row->setFontColor('#ffffff');
                    $row->setBackground('#1155CC');
                });
                $leadDetails->chunk(100, function ($final_leads) use ($sheet) {
                    foreach ($final_leads as $leads) {
                        // $sheet->setPreCalculateFormulas();

                        $createdDate = $leads->created_at;
                        $date = date("d/m/Y", strtotime($createdDate));
                        if (isset($leads->employee['name'])) {
                            $assignname = ucwords(strtolower($leads->employee['name']));
                            if (isset($leads->employee['empId'])) {
                                if ($leads->employee['empId'] != "") {
                                    $assignid = $leads->employee['empId'];
                                    $assignvalue = $assignname . ' (' . $assignid . ')';
                                } else {
                                    $assignvalue = $assignname;
                                }
                            } else {
                                $assignvalue = $assignname;
                            }
                        } else {
                            $assignvalue = '--';
                        }
                        if (isset($leads->agent['name'])) {
                            $agentname = ucwords(strtolower($leads->agent['name']));
                            if (isset($leads->agent['empid'])) {
                                if ($leads->agent['empid'] != "") {
                                    $agentid = $leads->agent['empid'];
                                    $agentvalue = ucwords(strtolower($agentname)) . ' (' . $agentid . ')';
                                } else {
                                    $agentvalue = ucwords(strtolower($agentname));
                                }
                            } else {
                                $agentvalue = ucwords(strtolower($agentname));
                            }
                        } else {
                            $agentvalue = 'NA';
                        }
                        if (isset($leads->contactNumber)) {
                            $contact = $leads->contactNumber;
                        } else {
                            $contact = '--';
                        }
                        if (isset($leads->contactEmail)) {
                            $contactEmail = $leads->contactEmail;
                        } else {
                            $contactEmail = '--';
                        }
                        if (isset($leads['dispatchType.dispatchType'])) {
                            $disType = $leads['dispatchType.dispatchType'];
                        } else {
                            $disType = '--';
                        }
                        if (isset($leads['deliveryMode.deliveryMode'])) {
                            $disMode = $leads['deliveryMode.deliveryMode'];
                        } else {
                            $disMode = '--';
                        }
                        if (isset($leads['customer.customerCode'])) {
                            $custCode = $leads['customer.customerCode'];
                        } else {
                            $custCode = '--';
                        }
                        if (isset($leads['customer.name'])) {
                            $custName = $leads['customer.name'];
                        } else {
                            $custName = '--';
                        }
                        if (isset($leads['customer.recipientName'])) {
                            $recName = $leads['customer.recipientName'];
                        } else {
                            $recName = '--';
                        }
                        if (isset($leads['dispatchDetails.land_mark'])) {
                            $land = (string) $leads['dispatchDetails.land_mark'];
                        } else {
                            $land = '--';
                        }

                        if (isset($leads['dispatchDetails']['documentDetails'])) {
                            $leadDocuments = $leads['dispatchDetails']['documentDetails'];
                            foreach ($leadDocuments as $count => $reply) {
                                if ($reply['DocumentCurrentStatus'] == '16' || $reply['DocumentCurrentStatus'] == '7') {
                                    //  var_dump($land.'ID'.$leads->_id);
                                    $data = array(
                                        $custCode ?: '--',
                                        ucwords(strtolower($custName)),
                                        $date,
                                        $leads['referenceNumber'],
                                        $disType,
                                        $reply['documentName'],
                                        $disMode,
                                        $reply['amount'] ?: '--',
                                        $contact,
                                        $contactEmail,
                                        ucwords(strtolower($recName)),
                                        $agentvalue,
                                        $disMode,
                                        $assignvalue,
                                        $land ?: '--',
                                        $reply['documentDescription'] ?: '--'
                                    );
                                    $sheet->appendRow($data);
                                }
                            }
                        } else {
                            $data = array(
                                $custCode ?: '--',
                                ucwords(strtolower($custName)),
                                $date,
                                $leads['referenceNumber'],
                                $disType,
                                '--',
                                $disMode,
                                '--',
                                $contact,
                                $contactEmail,
                                ucwords(strtolower($recName)),
                                $agentvalue,
                                $disMode,
                                $assignvalue,
                                $land ?: '--',
                                '--'
                            );
                            $sheet->appendRow($data);
                        }
                        //
                    }
                });
                // die();
            });
        })->store('xls', public_path('excel'));
        $excel_name = $file_name . '.' . 'xls';

        $send_excel = public_path('/excel/' . $excel_name);
        $tab_value = 'complete';
        sendExcel::dispatch($email, $send_excel, $tab_value);
        return 'success';
    }

    /**
     * remove document comment from all comment
     */
    public function Removedocument(Request $request)
    {
        $lead_id = $request->input('lead_id');
        $leadDetails = LeadDetails::find($lead_id);
        $value = $request->input('value');
        //		$comments=$leadDetails->comments;
        LeadDetails::where('_id', new ObjectId($lead_id))->pull('comments', ['docId' => $value]);
        //		foreach($comments as $comment){
        //		    $dicid=$comment['docId'];
        //		    if($dicid == $value ){
        //                LeadDetails::where('_id', new ObjectId($lead_id))->pull('$comment');
        //            }
        //        }
        //		$leads = $leadDetails['dispatchDetails']['documentDetails'];
        //		foreach ($leads as $count => $reply) {
        //			if ($reply['id'] == $value) {
        //				LeadDetails::where('_id',
        //					new ObjectId($lead_id))->update(array('dispatchDetails.documentDetails.' . $count . '.DocumentCurrentStatus' => 11));
        //			}
        //		}
        $leadDetails->save();
        return response()->json(['status' => 'go_recep']);
    }

    /**
     * get status
     */
    public function getStatus(Request $request)
    {
        $lead_id = $request->input('lead_id');
        $leadDetails = LeadDetails::find($lead_id);
        $id = $request->input('id');
        $leads = $leadDetails['dispatchDetails']['documentDetails'];
        foreach ($leads as $count => $reply) {
            if ($reply['id'] == $id && $reply['DocumentCurrentStatus'] == '2') {
                return response()->json(['status' => 'go_status1']);
            }
            if (
                $reply['id'] == $id && $reply['DocumentCurrentStatus'] != '2' &&
                $reply['id'] == $id && $reply['DocumentCurrentStatus'] != '6'
            ) {
                return response()->json(['status' => 'go_status2']);
            }
            if ($reply['id'] == $id && $reply['DocumentCurrentStatus'] == '6') {
                return response()->json(['status' => 'go_status3']);
            }
        }
    }

    /**
     * get approved item
     */
    public function getApprovedItem(Request $request)
    {
        $lead_id = $request->input('lead_id');
        $function_type = $request->input('save_method');
        // dd($function_type);
        $leadDetails = LeadDetails::find($lead_id);
        $document = $leadDetails['dispatchDetails']['documentDetails'];
        $current_path = $request->input('current_path');

        if ($function_type == 'approve_popup_button') {
            //			if(isset($leadDetails->schedulerejectstatus)){
            //				LeadDetails::where('_id', new ObjectId($lead_id))->unset('schedulerejectstatus');
            //			}
            $requestMethod = 'approve';
        } elseif ($function_type == 'popup_collected_button') {
            //			if(isset($leadDetails->schedulerejectstatus)){
            //				LeadDetails::where('_id', new ObjectId($lead_id))->unset('schedulerejectstatus');
            //			}
            $requestMethod = 'completed';
        }
        $dispatchType = $leadDetails['dispatchType.dispatchType'];
        $documentOperationSection = view(
            'dispatch.includes_pages.document_operation',
            ['document' => $document, 'current_path' => $current_path, 'requestMethod' => $requestMethod, 'dispatchType' => $dispatchType]
        )->render();
        return response()->json(['status' => 'success', 'documentOperationSection' => $documentOperationSection]);
    }

    /**
     * get transfered item
     */
    public function getTransferItem(Request $request)
    {
        $requestMethod = 'transfer';
        $lead_id = $request->input('lead_id');
        $leadDetails = LeadDetails::find($lead_id);
        $document = $leadDetails['dispatchDetails']['documentDetails'];
        $current_path = $request->input('current_path');
        $documentOperationSection = view(
            'dispatch.includes_pages.document_operation',
            ['document' => $document, 'current_path' => $current_path, 'requestMethod' => $requestMethod]
        )->render();
        //		$emp = User::where('isActive',1)->where('role', 'EM')->get();

        $emp = User::where('isActive', 1)->where(function ($q) {
            $q->where('role', 'EM')->orwhere('role', 'AD')->orwhere('role', 'AG')->orwhere('role', 'RP')->orwhere('role', 'CO')->orwhere('role', 'SV');
        })->get();
        $transfer[] = "<option value=''>Select Employee</option>";
        foreach ($emp as $employee) {
            if ($employee->empID != '') {
                $id = ' (' . $employee->empID . ')';
            } else {
                $id = '';
            }
            $transfer[] = "<option value='$employee->_id'>$employee->name $id</option>";
        }
        //		if(isset($leadDetails->schedulerejectstatus)){
        //			LeadDetails::where('_id', new ObjectId($lead_id))->unset('schedulerejectstatus');
        //		}

        return response()->json(['status' => 'success', 'transfer' => $transfer, 'documentOperationSection' => $documentOperationSection]);
    }
    //employee operation popup
    public function getEmployeeOperation(Request $request)
    {
        $id = $request->input('id');
        $lead_id = $request->input('lead_id');
        $leadDetails = LeadDetails::find($lead_id);
        $document = $leadDetails['dispatchDetails']['documentDetails'];
        $current_path = $request->input('current_path');
        $documentEmployeeSection = view(
            'dispatch.includes_pages.document_employee_operation',
            ['document' => $document, 'current_path' => $current_path, 'requestMethod' => $id, 'leadDetails' => $leadDetails]
        )->render();
        $emp = User::where('isActive', 1)->where(function ($q) {
            $q->where('role', 'EM')->orwhere('role', 'AD')->orwhere('role', 'AG')->orwhere('role', 'RP')->orwhere('role', 'CO')->orwhere('role', 'SV');
        })->get();
        $transfer[] = "<option value=''>Select Employee</option>";
        foreach ($emp as $employee) {
            if ($employee->empID != '') {
                $id = ' (' . $employee->empID . ')';
            } else {
                $id = '';
            }
            $transfer[] = "<option value='$employee->_id'>$employee->name $id</option>";
        }
        return response()->json(['status' => 'success', 'transfer' => $transfer, 'documentOperationSection' => $documentEmployeeSection]);
    }

    /**
     * save opeartions (transferred tab and employee login tab button actions)
     */
    public function saveOperations(Request $request)
    {
        $saveMethod = $request->input('save_method');
        $documentdetIdArray = $request->input('docDetid');
        $address = $request->input('address');
        $land_mark = $request->input('land_mark');
        $date_time = $request->input('date_time');
        $contactNum = $request->input('contactNum');
        $employee_list = $request->input('employee_list');
        $way_bill = $request->input('way_bill');
        $deliveryMode = $request->input('deliveryMode');
        if ($saveMethod == 'approve_button1') {
            $lead_id = $request->input('leadIdApprove');
            $leadDetails = LeadDetails::find($lead_id);

            $comment_submit_time = date('H:i:s');
            $comment_submit_object = new \stdClass();
            $comment_submit_object->comment = 'Approved from reception' . ',' . 'Message' . ' : ' . ucfirst(ucwords($request->input('action_approve_comment')));
            $comment_submit_object->commentBy = Auth::user()->name;
            $comment_submit_object->commentTime = $comment_submit_time;
            $comment_submit_object->id = new ObjectId(Auth::id());
            $comment_submit_object->date = date('d/m/Y');
            $comment_submit_array[] = $comment_submit_object;
            $leadDetails->push('comments', $comment_submit_array);

            $receptionStatusObject = new \stdClass();
            $receptionStatusObject->id = new ObjectID(Auth::id());
            $receptionStatusObject->name = Auth::user()->name;
            $receptionStatusObject->date = date('d/m/Y');
            $receptionStatusObject->status = "Approved";
            $receStatus[] = $receptionStatusObject;
            if (isset($leadDetails->receptionistStatus)) {
                LeadDetails::where('_id', new ObjectId($lead_id))->push('receptionistStatus', $receStatus);
            } else {
                //
                $leadDetails->receptionistStatus = $receStatus;
            }
            //			$leadDetails->dispatchStatus = 'Update Again';
            Session::flash('status', 'Dispatch slip approved successfully');
            $leadDetailsDet = LeadDetails::find($lead_id);
            $employeeId = $leadDetailsDet->employee['id'];
            $employee = User::find($employeeId);
            $assignname = $employee->name;
            $assignemail = $employee->email;
            $lead = $leadDetailsDet['dispatchDetails']['documentDetails'];
            foreach ($lead as $count => $reply) {
                if (isset($documentdetIdArray)) {
                    if (in_array($reply['id'], $documentdetIdArray)) {
                        $this->saveDocumentStatus($lead_id, $count, '13');
                    }
                }
            }
            $this->saveTabStatus($lead_id);
            $this->setDispatchStatus($lead_id);
            if (isset($leadDetails->employee)) {
                LeadDetails::where('_id', new ObjectId($lead_id))->unset('employee');
            }
            if (isset($leadDetails->deliveryMode)) {
                LeadDetails::where('_id', new ObjectId($lead_id))->unset('deliveryMode');
            }
            $emp_object = new \stdClass();
            $employeeListDetails = User::find($employee_list);
            $emp_object->id = new ObjectId($employeeListDetails->_id);
            $emp_object->name = $employeeListDetails->name;
            $emp_object->empId = $employeeListDetails->empID;
            $leadDetails->employee = $emp_object;

            $delivery = DeliveryMode::find($deliveryMode);
            $deliveryObject = new \stdClass();
            $deliveryObject->id = new ObjectID($delivery->_id);
            $deliveryObject->deliveryMode = $delivery->deliveryMode;
            if ($way_bill != '') {
                $deliveryObject->wayBill = $request->input('way_bill');
            }
            $leadDetails->deliveryMode = $deliveryObject;
            $data = array(
                'dispatchDetails.address' => $address,
                'dispatchDetails.date_time' => $date_time,
                'contactNumber' => $contactNum,
                'dispatchDetails.contactNum' => $contactNum,
                'dispatchDetails.land_mark' => $land_mark
            );
            LeadDetails::where('_id', new ObjectID($lead_id))->update($data, ['multiple' => true]);         
            if (isset($leadDetails->schedulerejectstatus)) {
                LeadDetails::where('_id', new ObjectId($lead_id))->unset('schedulerejectstatus');
            }
            $leadDetails->save();
            return response()->json(['status' => 'approved']);
        }
        //		else if($saveMethod=='reject_button')
        //		{
        //			$lead_id=$request->input('leadReject');
        //			$leadDetails = LeadDetails::find($request->input('leadId'));
        //			$receptionStatusObject = new \stdClass();
        //			$receptionStatusObject->id = new ObjectID(Auth::id());
        //			$receptionStatusObject->name = Auth::user()->name;
        //			$receptionStatusObject->date = date('d/m/Y');
        //			$receptionStatusObject->status = "Rejected";
        //			$receptionStatusObject->comment = $request->input('message');
        //			$receStatus[] = $receptionStatusObject;
        //			if (isset($leadDetails->receptionistStatus)) {
        //				LeadDetails::where('_id', new ObjectId($lead_id))->push('receptionistStatus',$receStatus);
        //			} else {
        ////
        //				$leadDetails->receptionistStatus = $receStatus;
        //			}
        ////			$leadDetails->dispatchStatus = 'Update Again';
        //			Session::flash('status', 'Dispatch slip Approved successfully');
        //			$leadDetailsDet = LeadDetails::find($lead_id);
        //			$lead = $leadDetailsDet['dispatchDetails']['documentDetails'];
        //			foreach ($lead as $count => $reply) {
        //				if (isset($documentdetIdArray)) {
        //					if (in_array($reply['id'], $documentdetIdArray)) {
        //						$this->saveDocumentStatus($lead_id, $count, '1');
        //					}
        //				}
        //			}
        //			$this->saveTabStatus($lead_id);
        //			$this->setDispatchStatus($lead_id);
        //			$data = array(
        //				'dispatchDetails.address' => $address,
        //				'dispatchDetails.date_time' => $date_time
        //			);
        //			LeadDetails::where('_id', new ObjectID($lead_id))->update($data, ['multiple' => true]);
        //			return response()->json(['status' => 'approved']);
        //		}
        elseif ($saveMethod == 'collected_button') {
            $lead_id = $request->input('leadIdCompleted');
            $leadDetails = LeadDetails::find($request->input('leadIdCompleted'));
            $finalStatusObject = new \stdClass();
            $finalStatusObject->id = new ObjectID(Auth::id());
            $finalStatusObject->name = Auth::user()->name;
            $finalStatusObject->date = date('d/m/Y');
            $finalStatus[] = $finalStatusObject;
            if (isset($leadDetails->finalStatus)) {
                LeadDetails::where('_id', new ObjectId($lead_id))->push('finalStatus', $finalStatus);
            } else {
                $leadDetails->finalStatus = $finalStatus;
            }
            $leadDetailsDet = LeadDetails::find($lead_id);
            $lead = $leadDetailsDet['dispatchDetails']['documentDetails'];
            $dispatchType = $leadDetails['dispatchType.dispatchType'];
            $uniqTransferId = [];
            if ($dispatchType == 'Direct Collections') {
                if (isset($leadDetailsDet['transferTo'])) {
                    $transferTo = $leadDetailsDet['transferTo'];
                    $uniq_val = [];
                    foreach ($transferTo as $transfer) {
                        $uniq_val[] = $transfer['uniqval'];
                    }
                    foreach ($lead as $count => $reply) {
                        if (isset($documentdetIdArray)) {
                            if (in_array($reply['id'], $documentdetIdArray)) {
                                if ($reply['DocumentCurrentStatus'] == '2') {
                                    $uniqTransferId[] = $reply['uniqTransferId'];
                                    $this->saveDocumentStatus($lead_id, $count, '7');
                                } elseif ($reply['DocumentCurrentStatus'] == '17') {
                                    $uniqTransferId[] = $reply['uniqTransferId'];
                                    $this->saveDocumentStatus($lead_id, $count, '7');
                                }
                            }
                        }
                    }
                    foreach ($uniq_val as $count => $transfer) {
                        if ((in_array($transfer, $uniqTransferId))) {
                            LeadDetails::where(
                                '_id',
                                new ObjectId($lead_id)
                            )->update(array('transferTo.' . $count . '.status' => 'Completed'));
                        }
                    }
                } else {
                    foreach ($lead as $count => $reply) {
                        if (isset($documentdetIdArray)) {
                            if (in_array($reply['id'], $documentdetIdArray)) {
                                if ($reply['DocumentCurrentStatus'] == '2') {
                                    $this->saveDocumentStatus($lead_id, $count, '7');
                                }
                            }
                        }
                    }
                }
            }
            $comment_submit_time = date('H:i:s');
            $comment_submit_object = new \stdClass();
            $comment_submit_object->comment = 'Completed by ' . Auth::user()->name . ',' . 'Message' . ' : ' . ucfirst(ucwords($request->input('action_completed_comment')));
            $comment_submit_object->commentBy = Auth::user()->name;
            $comment_submit_object->commentTime = $comment_submit_time;
            $comment_submit_object->id = new ObjectId(session('employee_id'));
            $comment_submit_object->date = date('d/m/Y');
            $comment_submit_array[] = $comment_submit_object;
            $leadDetails->push('comments', $comment_submit_array);

            $this->saveTabStatus($request->input('leadIdCompleted'));
            Session::flash('status', 'Collected successfully');
            $leadDetails->save();
            if (isset($leadDetails->schedulerejectstatus)) {
                LeadDetails::where('_id', new ObjectId($lead_id))->unset('schedulerejectstatus');
            }
            $this->setDispatchStatus($lead_id);
            return response()->json(['status' => 'go_completed']);
        }
    }

    /**
     * view comments
     */
    public function CommentsView(Request $request)
    {
        $lead_id = $request->input('lead_id');
        $name = $request->input('name');
        $remarks = $request->input('remarks');
        $docid = $request->input('id');
        $dispatchDetails = LeadDetails::find($lead_id);
        $leadDetails = LeadDetails::find($lead_id);
        $leads = $leadDetails['dispatchDetails']['documentDetails'];
        date_default_timezone_set('Asia/Dubai');
        $comment_time = date('H:i:s');
        if ($remarks != "" && $name != "") {
            foreach ($leads as $reply) {
                if ($reply['id'] == $docid) {
                    $comment_object = new \stdClass();
                    $comment_object->docId = $reply['id'];
                    $comment_object->comment = 'Document Name' . ' : ' . $reply['documentName'] . ' , ' . 'Action' . ' : ' . $name . ' , ' . 'Remarks' . ' : ' . ucfirst(ucwords($remarks));
                    $comment_object->commentBy = Auth::user()->name;
                    $comment_object->commentTime = $comment_time;
                    $comment_object->id = new ObjectId(Auth::id());
                    $comment_object->date = date('d/m/Y');
                    $comment_array[] = $comment_object;
                    $dispatchDetails->push('comments', $comment_array);
                    $updatedBy_obj = new \stdClass();
                    $updatedBy_obj->id = new ObjectID(Auth::id());
                    $updatedBy_obj->name = Auth::user()->name;
                    $updatedBy_obj->date = date('d/m/Y');
                    $updatedBy_obj->action = "Commented";
                    $updatedBy[] = $updatedBy_obj;
                    $dispatchDetails->push('updatedBy', $updatedBy);
                    $dispatchDetails->save();
                }
            }
        }
        // $leadDetails->save();
    }

    /**
     * save employee list form
     */
    public function saveEmployeelistForm(Request $request)
    {
        $comment_submit_time = date('H:i:s');
        $lead_id = $request->input('lead_id');
        $selectedDocs = $request->input('docid');
        $leadDetails = LeadDetails::find($lead_id);
        $referencenumber = $leadDetails->referenceNumber;
        $casemanagerid = $leadDetails->caseManager['id'];
        $casemanager = User::find($casemanagerid);
        $caseemail = $casemanager->email;
        $casename = $casemanager->name;
        $caselink = url('/dispatch/receptionist-list/');
        // $recp = User::where('isActive', 1)->where('role', "RP")->get();
        $users = [];
        $custname = $leadDetails->customer['name'];
        $saveMethod = $request->input('save_method');
        $array = $request->input('docDetid');
        $docID = explode(',', $array);

        $EmployeeStatus = [];
        if ($saveMethod) {
            $employee = User::find(session('employee_id'));
            $updatedBy_obj = new \stdClass();
            $updatedBy_obj->id = new ObjectId(session('employee_id'));
            $updatedBy_obj->name = $employee->name;
            $updatedBy_obj->date = date('d/m/Y');
            $updatedBy_obj->action = "Employee Login";
            $updatedBy[] = $updatedBy_obj;
            LeadDetails::where('_id', new ObjectId($lead_id))->push('updatedBy', $updatedBy);

            if ($saveMethod == 'print_without_button') {
                $print = "print_without";
            } else {
                if ($saveMethod == 'print_button') {
                    $print = "print_with";
                } else {
                    $print = '';
                    $employeeStatusObject = new \stdClass();
                    $employeeStatusObject->id = new ObjectId(session('employee_id'));
                    $employeeStatusObject->name = $employee->name;
                    $employeeStatusObject->date = date('d/m/Y');
                    $name = $employeeStatusObject->name;
                    if ($saveMethod == 'delivered_button') {
                        $leadDetails = LeadDetails::find($lead_id);
                        $employeeStatusObject->status = "Completed";
                        $employeeStatusObject->comment = $request->input('completed_comment');
                        $EmployeeStatus[] = $employeeStatusObject;
                        if ($leadDetails->employeeStatus) {
                            LeadDetails::where('_id', new ObjectId($lead_id))->push(
                                'employeeStatus',
                                $EmployeeStatus
                            );
                        } else {
                            $leadDetails->employeeStatus = $EmployeeStatus;
                        }
                        $comment_submit_object = new \stdClass();
                        $comment_submit_object->comment = 'Completed by ' . $employee->name . ',' . 'Message' . ' : ' . ucfirst(ucwords($request->input('completed_comment')));
                        $comment_submit_object->commentBy = $employee->name;
                        $comment_submit_object->commentTime = $comment_submit_time;
                        $comment_submit_object->id = new ObjectId(session('employee_id'));
                        $comment_submit_object->date = date('d/m/Y');
                        $comment_submit_array[] = $comment_submit_object;
                        $leadDetails->push('comments', $comment_submit_array);

                        $leads = $leadDetails['dispatchDetails']['documentDetails'];
                        $transferTo = $leadDetails['transferTo'];
                        $uniq_val = [];
                        foreach ($transferTo as $transfer) {
                            $uniq_val[] = $transfer['uniqval'];
                        }
                        $uniqTransferId = [];
                        foreach ($leads as $count => $reply) {
                            if ($reply['DocumentCurrentStatus'] == '9' && (in_array($reply['id'], $docID))) {
                                $uniqTransferId[] = $reply['uniqTransferId'];
                                DispatchController::saveDocumentStatus($leadDetails->_id, $count, '7');
                            }
                            if ($reply['DocumentCurrentStatus'] == '14' && (in_array($reply['id'], $docID))) {
                                $uniqTransferId[] = $reply['uniqTransferId'];
                                DispatchController::saveDocumentStatus($leadDetails->_id, $count, '16');
                            }
                        }
                        foreach ($uniq_val as $count => $transfer) {
                            if ((in_array($transfer, $uniqTransferId))) {
                                LeadDetails::where(
                                    '_id',
                                    new ObjectId($lead_id)
                                )->update(array('transferTo.' . $count . '.status' => 'Completed'));
                            }
                        }
                        $this->saveTabStatus($lead_id);
                        $action = "Transferred";
                        $leadss = "";
                        //                        SendcasemanagerADleads::dispatch($casename,$caseemail,$referencenumber,$name,$caselink,$saveMethod,$action,$leadss,$custname);
                        //                        foreach($recp as $user){
                        //                            $casename=$user['name'];
                        //                            $caseemail=$user['email'];
                        //                            if($caseemail != '') {
                        //                                SendReceptionADleads::dispatch($casename, $caseemail, $referencenumber, $name, $caselink, $saveMethod, $custname);
                        //                            }
                        //                        }
                        $leadDetails->save();
                        $this->setDispatchStatus($lead_id);
                        Session::flash('status', 'Completed successfully');
                        return response()->json(['status' => 'approved']);
                    } elseif ($saveMethod == 'approve_button') {
                        $leads = $leadDetails['dispatchDetails']['documentDetails'];
                        $transferTo = $leadDetails['transferTo'];
                        $uniq_val = [];
                        foreach ($transferTo as $transfer) {
                            $uniq_val[] = $transfer['uniqval'];
                        }
                        $uniqTransferId = [];
                        foreach ($leads as $count => $reply) {
                            if ($reply['DocumentCurrentStatus'] == '9' && (in_array($reply['id'], $docID))) {
                                $uniqTransferId[] = $reply['uniqTransferId'];
                                DispatchController::saveDocumentStatus($leadDetails->_id, $count, '6');
                            }
                            if ($reply['DocumentCurrentStatus'] == '14' && (in_array($reply['id'], $docID))) {
                                $uniqTransferId[] = $reply['uniqTransferId'];
                                DispatchController::saveDocumentStatus($leadDetails->_id, $count, '15');
                            }
                        }

                        foreach ($uniq_val as $count => $transfer) {
                            if ((in_array($transfer, $uniqTransferId))) {
                                LeadDetails::where(
                                    '_id',
                                    new ObjectId($lead_id)
                                )->update(array('transferTo.' . $count . '.status' => 'Completed'));
                            }
                        }
                        $this->saveTabStatus($lead_id);

                        $action = "Receptionist List";
                        $transfrByName = [];
                        foreach ($leadDetails->transferTo as $key => $transfer) {
                            if (isset($transfer['uniqval'])) {
                                if (in_array($transfer['uniqval'], $uniqTransferId)) {
                                    $user = User::find($transfer['transferById']);
                                    $transfrByName[] = $user->name;
                                    $ActionPerformed = 'approved';
                                    Mail::to($user->email)->send(new sendTransferRejectedMail($referencenumber, $name, $saveMethod, $action, $custname, $caselink, $ActionPerformed));
                                }
                            }
                        }
                        $leadDetails->save();
                        $comment_submit_object = new \stdClass();
                        $comment_submit_object->comment = 'Approved by ' . $employee->name . ',' . 'Message' . ' : ' . ucfirst(ucwords($request->input('action_comment')));
                        $comment_submit_object->commentBy = $employee->name;
                        $comment_submit_object->commentTime = $comment_submit_time;
                        $comment_submit_object->id = new ObjectId(session('employee_id'));
                        $comment_submit_object->date = date('d/m/Y');
                        $comment_submit_array[] = $comment_submit_object;
                        $leadDetails->push('comments', $comment_submit_array);
                        $this->setDispatchStatus($lead_id);
                        Session::flash('status', 'Lead approved successfully');
                        return response()->json(['status' => 'approved']);
                    } elseif ($saveMethod == 'transfer_to') {
                        $employeeStatusObject->status = "Transferred";
                        $employeeStatusObject->comment = $request->input('action_transfer_comment');
                        $EmployeeStatus[] = $employeeStatusObject;
                        if ($leadDetails->employeeStatus) {
                            LeadDetails::where('_id', new ObjectId($lead_id))->push(
                                'employeeStatus',
                                $EmployeeStatus
                            );
                        } else {
                            $leadDetails->employeeStatus = $EmployeeStatus;
                        }


                        $transferTo = $leadDetails['transferTo'];
                        $transfer_employee = $request->input('transfer_employee');
                        $leads = $leadDetails['dispatchDetails']['documentDetails'];
                        $uniq_val = [];
                        $uniqTransferId = [];
                        foreach ($transferTo as $transfer) {
                            $uniq_val[] = $transfer['uniqval'];
                        }
                        $uniq_id = uniqid();
                        foreach ($leads as $count => $reply) {
                            if (in_array($reply['id'], $docID)) {
                                if ($reply['DocumentCurrentStatus'] == '9') {
                                    $saveStatus[] = $this->saveDocumentStatus($lead_id, $count, '9');
                                    $uniqTransferId[] = $reply['uniqTransferId'];
                                    LeadDetails::where(
                                        '_id',
                                        new ObjectId($lead_id)
                                    )->update(array('dispatchDetails.documentDetails.' . $count . '.uniqTransferId' => $uniq_id));
                                }
                                if ($reply['DocumentCurrentStatus'] == '14') {
                                    $saveStatus[] = $this->saveDocumentStatus($lead_id, $count, '14');
                                    $uniqTransferId[] = $reply['uniqTransferId'];
                                    LeadDetails::where(
                                        '_id',
                                        new ObjectId($lead_id)
                                    )->update(array('dispatchDetails.documentDetails.' . $count . '.uniqTransferId' => $uniq_id));
                                }
                            }
                        }
                        foreach ($uniq_val as $count => $transfer) {
                            if ((in_array($transfer, $uniqTransferId))) {
                                LeadDetails::where(
                                    '_id',
                                    new ObjectId($lead_id)
                                )->update(array('transferTo.' . $count . '.status' => 'transfer cancelled'));
                            }
                        }
                        $this->saveTabStatus($lead_id);
                        $this->setDispatchStatus($lead_id);
                        $employee_details = User::find($transfer_employee);
                        if ($employee_details) {
                            $name = $employee_details->name;
                            $email = $employee_details->email;
                            $link = url('/dispatch/employee-view-list/');
                            $caselink = url('/dispatch/receptionist-list/');

                            SendTransferleads::dispatch(
                                $name,
                                $email,
                                $referencenumber,
                                $link,
                                $custname,
                                Auth::user()->name
                            );
                        } else {
                            $name = '';
                        }

                        $transfer = new \stdClass();
                        $transfer->id = new ObjectId($employee_details->_id);
                        $transfer->uniqval = $uniq_id;
                        $transfer->name = $employee_details->name;
                        $transfer->empCode = $employee_details->empID;
                        $transfer->transferById = new ObjectId(session('employee_id'));
                        $transfer->transfered_documents = $docID;
                        $transfer->transferByName = $employee->name;
                        $transfer->transferDate = date('d/m/Y');
                        $transfer->status = 'Transferred';
                        $transferStatus = $transfer;
                        $comment_submit_time = date('H:i:s');
                        $comment_submit_object = new \stdClass();
                        $comment_submit_object->comment = 'Lead transferred' . ',' . 'Message' . ' : ' . ucfirst(ucwords($request->input('action_transfer_comment')));
                        $comment_submit_object->commentBy = $employee->name;
                        $comment_submit_object->commentTime = $comment_submit_time;
                        $comment_submit_object->id = new ObjectId(session('employee_id'));
                        $comment_submit_object->date = date('d/m/Y');
                        $comment_submit_array[] = $comment_submit_object;
                        $leadDetails->push('comments', $comment_submit_array);
                        Sendcasemangerleads::dispatch(
                            $casename,
                            $caseemail,
                            $referencenumber,
                            $name,
                            $caselink,
                            $custname,
                            Auth::user()->name
                        );
                        LeadDetails::where('_id', $lead_id)->push(['transferTo' => $transferStatus]);
                        $leadDetails->save();
                        Session::flash('status', 'Lead is transferred to ' . $employee_details->name);
                        return response()->json(['status' => 'approved']);
                    } elseif ($saveMethod == 'reject_button') {
                        $employeeStatusObject->status = "Rejected";
                        $comment_submit_object = new \stdClass();
                        $comment_submit_object->comment = 'Rejected by ' . $employee->name . ',' . 'Message' . ' : ' . ucfirst(ucwords($request->input('message')));
                        $comment_submit_object->commentBy = $employee->name;
                        $comment_submit_object->commentTime = $comment_submit_time;
                        $comment_submit_object->id = new ObjectId(session('employee_id'));
                        $comment_submit_object->date = date('d/m/Y');
                        $comment_submit_array[] = $comment_submit_object;
                        $leadDetails->push('comments', $comment_submit_array);
                        $leadDetails->schedulerejectstatus = $request->input('message');
                        $employeeStatusObject->comment = $request->input('message');
                        $EmployeeStatus[] = $employeeStatusObject;
                        if ($leadDetails->employeeStatus) {
                            LeadDetails::where('_id', new ObjectId($lead_id))->push(
                                'employeeStatus',
                                $EmployeeStatus
                            );
                        } else {
                            $leadDetails->employeeStatus = $EmployeeStatus;
                        }
                        $uniqID = [];
                        $leadDetailsDet = LeadDetails::find($lead_id);
                        $lead = $leadDetailsDet['dispatchDetails']['documentDetails'];
                        $uniq_val = [];
                        $transferTo = $leadDetailsDet['transferTo'];
                        foreach ($transferTo as $transfer) {
                            $uniq_val[] = $transfer['uniqval'];
                        }

                        foreach ($lead as $count => $reply) {
                            if (isset($docID)) {
                                if (in_array($reply['id'], $docID)) {
                                    $uniqID[] = $reply['uniqTransferId'];
                                    $this->saveDocumentStatus($lead_id, $count, '17');
                                }
                            }
                        }
                        foreach ($uniq_val as $count => $transfer) {
                            if ((in_array($transfer, $uniqID))) {
                                LeadDetails::where(
                                    '_id',
                                    new ObjectId($lead_id)
                                )->update(array('transferTo.' . $count . '.status' => 'Rejected'));
                            }
                        }
                        $this->saveTabStatus($request->input('lead_id'));
                        $action = "Receptionist List";
                        $transfrByName = [];
                        foreach ($leadDetailsDet->transferTo as $key => $transfer) {
                            if (isset($transfer['uniqval'])) {
                                if (in_array($transfer['uniqval'], $uniqID)) {
                                    $user = User::find($transfer['transferById']);
                                    $transfrByName[] = $user->name;
                                    $ActionPerformed = 'rejected';
                                    Mail::to($user->email)->send(new sendTransferRejectedMail($referencenumber, $user->name, $saveMethod, $action, $custname, $caselink, $ActionPerformed));
                                }
                            }
                        }
                        $leadss = "";
                        if ($caseemail != '') {
                            $saveMethod = 'transfer_reject';
                            SendcasemanagerADleads::dispatch($casename, $caseemail, $referencenumber, $transfrByName[0], $caselink, $saveMethod, $action, $leadss, $custname);
                        }
                        //							foreach($recp as $user){
                        //								$casename=$user['name'];
                        //								$caseemail=$user['email'];
                        //								if($caseemail != '') {
                        //									SendReceptionADleads::dispatch($casename, $caseemail, $referencenumber, $name, $caselink, $saveMethod, $custname);
                        //								}
                        //							}
                        $leadDetails->save();
                        $this->setDispatchStatus($lead_id);
                        Session::flash('status', 'Dispatch slip rejected successfully');
                        return response()->json(['status' => 'rejected']);
                    } elseif ($saveMethod == 'collected_button') {
                        $employeeStatusObject->status = "Collected";
                        $comment_submit_object = new \stdClass();
                        $comment_submit_object->comment = 'Collected by ' . $employee->name;
                        $comment_submit_object->commentBy = $employee->name;
                        $comment_submit_object->commentTime = $comment_submit_time;
                        $comment_submit_object->id = new ObjectId(session('employee_id'));
                        $comment_submit_object->date = date('d/m/Y');
                        $comment_submit_array[] = $comment_submit_object;
                        $leadDetails->push('comments', $comment_submit_array);
                        $employeeStatusObject->comment = $request->input('action_comment');
                        $EmployeeStatus[] = $employeeStatusObject;
                        if ($leadDetails->employeeStatus) {
                            LeadDetails::where('_id', new ObjectId($lead_id))->push(
                                'employeeStatus',
                                $EmployeeStatus
                            );
                        } else {
                            $leadDetails->employeeStatus = $EmployeeStatus;
                        }
                        $uniqID = [];
                        $leadDetailsDet = LeadDetails::find($lead_id);
                        $lead = $leadDetailsDet['dispatchDetails']['documentDetails'];
                        $uniq_val = [];
                        $transferTo = $leadDetailsDet['transferTo'];
                        foreach ($transferTo as $transfer) {
                            $uniq_val[] = $transfer['uniqval'];
                        }
                        foreach ($lead as $count => $reply) {
                            if (isset($docID)) {
                                if (in_array($reply['id'], $docID)) {
                                    $uniqID[] = $reply['uniqTransferId'];
                                }
                            }
                        }
                        foreach ($uniq_val as $count => $transfer) {
                            if ((in_array($transfer, $uniqID))) {
                                LeadDetails::where(
                                    '_id',
                                    new ObjectId($lead_id)
                                )->update(array('transferTo.' . $count . '.status' => 'Collected'));
                            }
                        }
                        $leadDetails->save();
                        //						Session::flash('status', 'Dispatch slip rejected successfully');
                        $employee_id = new ObjectId(session('employee_id'));
                        if ($employee_id != '') {
                            $user = User::find($employee_id);
                            if (isset($user->role) && $user->role == 'SV') {
                                $employees = $user->employees;
                                if (isset($employees) && !empty($employees)) {
                                    $empids = $this->stringCollectEmployees($employees);
                                    $empids = array_values(array_unique($empids));
                                    $employee_id1 = $empids ?: [];
                                    array_push($employee_id1, (string) $user->_id);
                                    session(['employees_supervisor' => $employee_id1]);
                                } else {
                                    session(['employees_supervisor' => [(string) $user->_id]]);
                                }
                                if (session('employees_supervisor')) {
                                    $employeeRoleId = session('employees_supervisor');
                                } else {
                                    $employeeRoleId = [];
                                }
                            } elseif (isset($user->role) && $user->role == 'CO') {
                                $employees = $user->assigned_agent;
                                $employee_id1 = [];
                                // foreach ($employees as $emp) {
                                $employee_id1[] = (string) $employees['id'];
                                // }
                                $employee_id1[] = (string) $user->_id;
                                session(['employees_supervisor' => $employee_id1]);
                                if (session('employees_supervisor')) {
                                    $employeeRoleId = session('employees_supervisor');
                                } else {
                                    $employeeRoleId = [];
                                }
                            } else {
                                $employeeRoleId = [];
                            }
                        } else {
                            $employeeRoleId = [];
                        }
                        return response()->json(['status' => 'collected', 'employeeRoleId' => $employeeRoleId, 'caseManager' => (string) $leadDetails->caseManager['id']]);
                    }
                }
            }

            if ($print != '') {
                $leadDetails->save();
                if (isset($selectedDocs)) {
                    $docExist = true;
                } else {
                    $docExist = false;
                }
                $pdf = PDF::loadView(
                    'dispatch.pdf.scheduledelivery',
                    ['leadDetails' => $leadDetails, 'print' => $print, 'docExist' => $docExist, 'documentSelectArray' => $selectedDocs]
                );
                $pdf_name = 'dispatch-slip_' . time() . '_' . $leadDetails->_id . '.pdf';
                $pdf->setOption('page-width', '200');
                $pdf->setOption('page-height', '260')->inline();
                $temp_path = public_path('pdf/' . $pdf_name);
                $pdf->save('pdf/' . $pdf_name);
                $pdf_file = $this->uploadFileToCloud_file($pdf_name, $temp_path);
                unlink($temp_path);
                $leadDetails->dispatchSlip = $pdf_file;
                $leadDetails->save();
                return response()->json(['success' => 'pdf', 'pdf' => $leadDetails->dispatchSlip]);
            }
        }
    }

    /**
     * update users
     */
    public function updateUsers()
    {
        $count = 0;
        $employee_details = EmployeeDetails::all();
        foreach ($employee_details as $employee) {
            //	        User::where('empID', $employee->empID)->delete();
            $user = new User();
            $user->email = $employee->emailID;
            $user->password = bcrypt('123456');
            $user->empID = $employee->empID;
            $user->firstName = $employee->firstName;
            $user->lastName = $employee->lastName;
            $user->name = $employee->fullName;
            $user->department = $employee->department;
            $user->position = $employee->position;
            $user->nameOfSupervisor = $employee->nameOfSupervisor;
            $user->uniqueCode = $employee->uniqueCode;
            if ($employee->position == "Agent") {
                $user->role = "AG";
            } elseif ($employee->position == "courier") {
                $user->role = "CR";
            } else {
                $user->role = "EM";
            }
            $user->isActive = (int) 1;
            $user->save();
            $count++;
        }
        echo $count . " updated";
    }

    /**
     * update role name
     */
    public function updateRolename()
    {
        $users = User::all();
        $count = 0;
        foreach ($users as $user) {
            $role = Role::where('abbreviation', $user->role)->first();
            if ($role) {
                $user->role_name = $role->name;
                $user->save();
                $count++;
            }
        }
        echo $count . ' Updated';
    }

    public function testpdf()
    {
        $leadDetails = LeadDetails::find('5bec34c66e3a9258bd5a2514');
        $documentsList = $leadDetails['dispatchDetails']['documentDetails'];

        $pdf = PDF::loadView('dispatch.pdf.dispatch_slip', ['leadDetails' => $leadDetails, 'documentsList' => $documentsList, 'documentSelectArray' => '', 'print' => '']);
        $pdf_name = 'dispatch-slip_' . time() . '_' . $leadDetails->_id . '.pdf';
        $pdf->setOption('page-width', '220');
        $pdf->setOption('page-height', '260')->inline();
        $temp_path = public_path('pdf/' . $pdf_name);
        $pdf->inline('pdf/' . $pdf_name);
        //	    $count = 0;
        //	    $lead_details = LeadDetails::all();
        //	    foreach ($lead_details as $lead){
        ////	        User::where('empID', $employee->empID)->delete();
        //            if($lead->transferTo){
        //                foreach ($lead->transferTo as $key => $transfer){
        //                    $delivery_id = $transfer['id'];
        //                    $employee = EmployeeDetails::where('_id', new ObjectID($delivery_id))->first();
        //
        //                    if($employee){
        //                        $user = User::where('name', $employee->fullName)->first();
        //                        if($user){
        //                            LeadDetails::where('_id', new ObjectID($lead->_id))->update(array('transferTo'.$key.'.id' => new ObjectID($user->_id)));
        //                            $count++;
        //                        }
        //                    }
        //                }
        //
        //            }
        //        }
        //        echo $count." updated";
    }
    public function closeDocument(Request $request)
    {
        $lead_id = $request->input('lead_id');
        $leadDetails = LeadDetails::find($lead_id);
        $comments = $leadDetails->comments;

        foreach ($comments as $key => $comment) {
            if (@$comment['docId'] != "") {
                LeadDetails::where('_id', new ObjectID($lead_id))->update(['comments.' . $key . '.docId' => ""]);
                LeadDetails::where('_id', new ObjectID($lead_id))->update(['comments.' . $key . '.comment' => ""]);
                LeadDetails::where('_id', new ObjectID($lead_id))->update(['comments.' . $key . '.commentBy' => ""]);
                LeadDetails::where('_id', new ObjectID($lead_id))->update(['comments.' . $key . '.commentTime' => ""]);
                LeadDetails::where('_id', new ObjectID($lead_id))->update(['comments.' . $key . '.date' => ""]);
            }
        }
    }

    // /**
    //  * show user
    //  */
    // public function show($user)
    // {
    //     $user=User::find($user);
    //     $role_name = Role::where('abbreviation', $user->role)->first();
    //     $role=@$role_name->name;
    //     if ($user) {
    //         return view('dispatch.user_details')->with(compact('user', 'role'));
    //     } else {
    //         return view('error');
    //     }
    // }

    /**
     * view data table for transferred list page
     */
    public function transferredData(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $filter = $request->input('search');
        $filter_data_en = $request->get('filterData');
        $filter_data = json_decode($filter_data_en);
        $sort = $request->get('field');
        $search = (isset($filter['value'])) ? $filter['value'] : false;
        session()->put('filter', $filter_data_en);
        session()->put('sort', $sort);
        //		$LeadDetails = LeadDetails::where('active', 1)->whereIn('dispatchStatus',array('Reception','Delivered','Collected','reschedule_another','not_contact','delivered_and_collected',
        //			'delivered_not_collected','collected_not_delivered','neither_collected_nor_delivered','Partial','Incomplete','Update Again'))->where('transferTo.status','!=','Transferred')->whereNull('finalStatus');

        $LeadDetails = LeadDetails::where('active', 1)->where('employeeTabStatus', (int) 1);

        if (session('role') == 'Employee') {
            $LeadDetails = $LeadDetails->where(function ($q) {
                $q->where('caseManager.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('agent.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('employee.id', new ObjectID(Auth::user()->_id))->orwhere('transferTo.id', new ObjectID(Auth::user()->_id));
            });
        } elseif (session('role') == 'Coordinator') {
            $LeadDetails = $LeadDetails->where(function ($q) {
                $q->where('agent.id', session('assigned_agent'))
                    ->orwhere('agent.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('employee.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('employee.id', session('assigned_agent'));
            });
        } elseif (session('role') == 'Agent') {
            $LeadDetails = $LeadDetails->where(function ($q) {
                $q->where('agent.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('caseManager.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('employee.id', new ObjectID(Auth::user()->_id));
            });
        } elseif (session('role') == 'Supervisor') {
            $LeadDetails = $LeadDetails->where(function ($q) {
                $q->where('agent.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('caseManager.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('employee.id', new ObjectID(Auth::user()->_id))
                    ->orwhereIn('employee.id', session('employees'));
            });
        } elseif (session('role') != 'Admin' && session('role') != 'Receptionist') {
            $LeadDetails = $LeadDetails->where('employee.id', new ObjectID(Auth::user()->_id));
        }

        if (!empty($filter_data)) {
            if (!empty($filter_data->agent)) {
                $count = 0;
                foreach ($filter_data->agent as $agent) {
                    $objectArray[$count] = new ObjectId($agent);
                    $count++;
                }
                $LeadDetails = $LeadDetails->whereIn('agent.id', $objectArray);
            }
            if (!empty($filter_data->case_manager)) {
                $count = 0;
                foreach ($filter_data->case_manager as $manager) {
                    $objectArray[$count] = new ObjectId($manager);
                    $count++;
                }
                $LeadDetails = $LeadDetails->whereIn('caseManager.id', $objectArray);
            }
            if (!empty($filter_data->customer)) {
                $count = 0;
                foreach ($filter_data->customer as $cust) {
                    $objectArray[$count] = new ObjectId($cust);
                    $count++;
                }
                $LeadDetails = $LeadDetails->whereIn('customer.id', $objectArray);
            }
            if (!empty($filter_data->delivery)) {
                $count = 0;
                foreach ($filter_data->delivery as $mode) {
                    $objectArray[$count] = new ObjectId($mode);
                    $count++;
                }
                $LeadDetails = $LeadDetails->whereIn('deliveryMode.id', $objectArray);
            }
            if (!empty($filter_data->dispatch)) {
                $count = 0;
                foreach ($filter_data->dispatch as $type) {
                    $objectArray[$count] = new ObjectId($type);
                    $count++;
                }
                $LeadDetails = $LeadDetails->whereIn('dispatchType.id', $objectArray);
            }
            if (!empty($filter_data->assigned)) {
                $count = 0;
                foreach ($filter_data->assigned as $type) {
                    $objectArray[$count] = new ObjectId($type);
                    $count++;
                }
                $LeadDetails = $LeadDetails->whereIn('employee.id', $objectArray);
            }
            if (!empty($filter_data->status)) {
                $count = 0;
                foreach ($filter_data->status as $stat) {
                    $objectArray[$count] = $stat;
                    $count++;
                }
                $LeadDetails = $LeadDetails->whereIn('dispatchStatus', $objectArray);
            }
        }

        if (!empty($sort)) {
            if ($sort == "Customer Name") {
                $LeadDetails = $LeadDetails->orderBy('customer.name');
            } elseif ($sort == "Agent") {
                $LeadDetails = $LeadDetails->orderBy('agent.name');
            } elseif ($sort == "Case Manager") {
                $LeadDetails = $LeadDetails->orderBy('caseManager.name');
            } elseif ($sort == "Dispatch Type") {
                $LeadDetails = $LeadDetails->orderBy('dispatchType.dispatchType');
            } elseif ($sort == "Delivery Mode") {
                $LeadDetails = $LeadDetails->orderBy('deliveryMode.deliveryMode');
            }
        } elseif (empty($sort)) {
            $LeadDetails = $LeadDetails->where('employeeTabStatus', (int) 1)->orderBy(
                'created_at',
                'DESC'
            );
        }
        if ($search) {
            $LeadDetails = $LeadDetails->where(function ($query) use ($search) {
                $query->Where('referenceNumber', 'like', '%' . $search . '%')
                    ->orWhere('customer.name', 'like', '%' . $search . '%')
                    ->orWhere('customer.recipientName', 'like', '%' . $search . '%')
                    ->orWhere('customer.customerCode', 'like', '%' . $search . '%')
                    ->orWhere('agent.name', 'like', '%' . $search . '%')
                    ->orWhere('caseManager.name', 'like', '%' . $search . '%')
                    ->orWhere('contactNumber', 'like', '%' . $search . '%')
                    //					->orWhere('contactEmail', 'like', '%' . $search . '%')
                    ->orWhere('deliveryMode.deliveryMode', 'like', '%' . $search . '%')
                    ->orWhere('dispatchType.dispatchType', 'like', '%' . $search . '%')
                    ->orWhere('dispatchStatus', 'like', '%' . $search . '%');
            });


            session()->put('search', $search);
        }
        if ($search == "") {
            $LeadDetails = $LeadDetails;
            session()->put('search', "");
        }

        $searchField = $request->get('searchField');
        if ($searchField != "") {
            $LeadDetails = $LeadDetails->where(function ($query) use ($searchField) {
                $query->Where('referenceNumber', 'like', '%' . $searchField . '%')
                    ->orWhere('customer.name', 'like', '%' . $searchField . '%')
                    ->orWhere('customer.recipientName', 'like', '%' . $searchField . '%')
                    ->orWhere('customer.customerCode', 'like', '%' . $searchField . '%')
                    ->orWhere('agent.name', 'like', '%' . $searchField . '%')
                    ->orWhere('caseManager.name', 'like', '%' . $searchField . '%')
                    ->orWhere('contactNumber', 'like', '%' . $searchField . '%')
                    ->orWhere('contactEmail', 'like', '%' . $searchField . '%')
                    ->orWhere('deliveryMode.deliveryMode', 'like', '%' . $searchField . '%')
                    ->orWhere('dispatchType.dispatchType', 'like', '%' . $searchField . '%')
                    ->orWhere('dispatchStatus', 'like', '%' . $searchField . '%');
            });
        }
        $total_leads = $LeadDetails->count(); // get your total no of data;
        $members_query = $LeadDetails;
        $search_count = $members_query->count();
        $LeadDetails->skip((int) $start)->take((int) $length);
        $final_leads = $LeadDetails->get();

        foreach ($final_leads as $leads) {
            $check = '<div class="custom_checkbox">' .
                '<input type="checkbox" name="marked_list[]" class="inp-cbx check" id="' . $leads->_id . '" style="display: none"  onchange="markedCheck(this.id)">' .
                '<label for="' . $leads->_id . '" class="cbx">' .
                '<span>' .
                '    <svg width="10px" height="8px" viewBox="0 0 12 10">' .
                '      <polyline points="1.5 6 4.5 9 10.5 1"></polyline>' .
                '    </svg>' .
                '</span>' .
                '<span></span>' .
                '</label>' .
                '</div>';

            if ($leads['referenceNumber'] == '') {
                $referenceNumber = '--';
            } else {
                $referenceNumber = '<a href="#" class="auto_modal table_link" data-toggle="tooltip" data-placement="bottom" title="View Dispatch Slip" data-container="body"  data-modal="view_lead_popup" dir="' . $leads->_id . '" onclick="view_lead_popup(\'' . $leads->_id . '\');">

' . $leads['referenceNumber'] . '  </a> ';
            }
            if (isset($leads->schedulerejectstatus)) {
                $referenceNumber = $referenceNumber . '<i style="color: #f00; font-size: 14px;" class="fas fa-ban"  data-toggle="tooltip" title="' . $leads->schedulerejectstatus . '"  aria-hidden="true"></i> </a>';
            }
            if (isset($leads->agent['name'])) {
                $agentname = ucwords(strtolower($leads->agent['name']));
                if (isset($leads->agent['empid'])) {
                    if ($leads->agent['empid'] != "") {
                        $agentid = $leads->agent['empid'];
                        $agentvalue = $agentname . ' (' . $agentid . ')';
                    } else {
                        $agentvalue = $agentname;
                    }
                } else {
                    $agentvalue = $agentname;
                }
            } else {
                $agentvalue = 'NA';
            }
            $documentUniqid = [];
            $lead = $leads['dispatchDetails']['documentDetails'];
            foreach ($lead as $key => $value) {
                if (isset($value['uniqTransferId'])) {
                    $documentUniqid[] = $value['uniqTransferId'];
                }
            }
            $transfer_name = [];
            $transfer_empid = [];
            $transferto = $leads->transferTo;
            foreach ($transferto as $key => $value) {
                if (isset($value['uniqval'])) {
                    if (in_array($value['uniqval'], $documentUniqid) && ($value['status'] == 'Transferred' || $value['status'] == 'Collected')) {
                        if (isset($value['empCode']) && $value['empCode'] != '') {
                            $transfer_name[] = $value['name'] . '( ' . $value['empCode'] . ')';
                        } else {
                            $transfer_name[] = $value['name'];
                        }
                        $transfer_empid[] = (string) $value['id'];
                    }
                }
            }
            $name_transffered = array_unique($transfer_name);
            if (count(array_unique($transfer_empid)) === 1 && end($transfer_empid) === $transfer_empid[0]) {
                $string_version = $transfer_name[0];
            } else {
                $string_version = implode(',', $name_transffered);
            }
            $agent = $agentvalue;
            $caseManager = ucwords(strtolower($leads['caseManager.name']));
            $email = $leads->contactEmail;
            $contact = $leads->contactNumber;
            $dispatchStatus = $leads->dispatchStatus;
            $recipientName = ucwords(strtolower($leads['customer.recipientName']));
            $dispatchType = $leads['dispatchType.dispatchType'];
            $deliveryMode = $leads['deliveryMode.deliveryMode'] ?: '--';
            $code = $leads['customer.customerCode'] ?: '--';
            $customerName = ucwords(strtolower($leads['customer.name']));
            $created_at = $leads->created_at;
            if (isset($leads->employee['name'])) {
                $assignname = ucwords(strtolower($leads->employee['name']));
                if (isset($leads->employee['empId'])) {
                    if ($leads->employee['empId'] != "") {
                        $assignid = $leads->employee['empId'];
                        $assignvalue = $assignname . ' (' . $assignid . ')';
                    } else {
                        $assignvalue = $assignname;
                    }
                } else {
                    $assignvalue = $assignname;
                }
            } else {
                $assignvalue = '--';
            }
            $status = '<a href="#"><span data-toggle="tooltip" data-placement="bottom" title="Transfer to : ' . $string_version . '"  data-container="body" > ' . $leads['dispatchStatus'] . ' </span>  ';
            $leads->checkall = $check;
            $leads->customerCode = $code;
            $leads->referenceNumber = $referenceNumber;
            $leads->customerName = $customerName;
            $leads->recipientName = $recipientName;
            $leads->contactNo = $contact;
            $leads->email = $email;
            $leads->status = $dispatchStatus;
            $leads->caseManager = $caseManager;
            $leads->agent = $agent;
            $leads->dispatchType = $dispatchType;
            $leads->deliveryMode = $deliveryMode;
            $leads->status = $status;
            $leads->assigned = $assignvalue;
            $leads->created = Carbon::parse($created_at)->format('d/m/Y');
            if (session('role') == 'Admin') {
                $delete_button = '<button class="btn export_btn waves-effect auto_modal delete_icon_btn" type="button" data-toggle="tooltip" data-placement="bottom" title="Delete" data-container="body"  data-modal="delete_popup" dir="' . $leads->_id . '" onclick="delete_pop(this);">
<i class="material-icons">delete_outline</i>
</button>';
                $leads->delete_button = $delete_button;
            } else {
                $leads->delete_button = "";
            }
        }
        if ($search) {
            $filtered_count = $search_count;
        } else {
            $filtered_count = $total_leads;
        }


        $data = array(
            'draw' => $draw,
            'recordsTotal' => $total_leads,
            'recordsFiltered' => $filtered_count,
            'data' => $final_leads,
        );

        return json_encode($data);
    }

    /**
     * get transferred details
     */
    public function getTransferredDetails(Request $request)
    {
        $current_path = $request->input('current_path');
        $emp_option = 'text';
        $leadDetails = LeadDetails::find($request->input('lead_id'));
        $caseManager = (string) $leadDetails->caseManager['id'];
        $dispatchTypes = DispatchTypes::orderBy('type')->get();
        $allMode = DeliveryMode::orderBy('deliveryMode')->get();
        if (isset($leadDetails->saveType)) {
            if ($leadDetails->saveType == 'recipient') {
                $customercode = $leadDetails->customer['id'];
                $customer = RecipientDetails::find($customercode);
            } else {
                $customercode = $leadDetails->customer['id'];
                $customer = Customer::find($customercode);
            }
        }
        if ($customer->addressLine2 != '') {
            $address2 = ',' . $customer->addressLine2;
        } else {
            $address2 = '';
        }
        $cityName = ',' . $customer->cityName;
        $address = $customer->addressLine1 . '' . $address2 . '' . $cityName;
        $landmark = $customer->streetName;
        $documentTypes = DocumentType::all();
        $document = $leadDetails['dispatchDetails']['documentDetails'];
        $docStatus = [];
        $value = '0';
        if ($leadDetails->dispatchType['dispatchType'] == 'Collections') {
            $DispatchType = DispatchTypes::where('_id', $leadDetails->dispatchType['id'])->get();
            $value = '0';
        } elseif ($leadDetails->dispatchType['dispatchType'] == 'Delivery') {
            $value = '1';
            $DispatchType = DispatchTypes::where('_id', $leadDetails->dispatchType['id'])->get();
        } elseif ($leadDetails->dispatchType['dispatchType'] == 'Delivery & Collections') {
            $value = '0';
            $DispatchType = DispatchTypes::whereNotIn('code', ['DC', 'DI'])->get();
        } else {
            $value = '0';
            $DispatchType = DispatchTypes::where('_id', $leadDetails->dispatchType['id'])->get();
        }
        $lead = '';
        $doctype[] = "<option value='' disabled>Select Type</option>";
        foreach ($DispatchType as $disType) {
            if ($leadDetails->dispatchType['dispatchType'] == 'Delivery & Collections') {
                $doctype[] = "<option value='$disType->_id'>$disType->type</option>";
            } else {
                $doctype[] = "<option value='$disType->_id' selected>$disType->type</option>";
            }
        }
        if ($document) {
            $documentSection = view('dispatch.includes_pages.documents_section', [
                'document' => $document,
                'current_path' => $current_path,
                'documentTypes' => $documentTypes,
                'save_status' => $lead,
                'doctype' => $doctype,
                'dispatchTypes' => $dispatchTypes,
                'DispatchType' => $DispatchType,
                'leadDetails' => $leadDetails
            ])->render();
        } else {
            $documentSection = view('dispatch.includes_pages.documents_section', [
                'document' => $document,
                'current_path' => $current_path,
                'documentTypes' => $documentTypes,
                'save_status' => $lead,
                'doctype' => $doctype,
                'dispatchTypes' => $dispatchTypes,
                'DispatchType' => $DispatchType,
                'leadDetails' => $leadDetails
            ])->render();
        }

        $user = "1";
        if (session('role') == 'Employee') {
            $employees = $leadDetails['transferTo'];
            foreach ($employees as $emp) {
                if ($emp['id'] == new ObjectID(Auth::user()->_id)) {
                    $user = "1";
                } else {
                    $user = "0";
                }
            }
        }
        if (Auth::user()->_id == $leadDetails['caseManager']['id'] && $value == 1) {
            $user = "1";
        }

        if (isset($leadDetails['employee']['name'])) {
            $emp_value = $leadDetails['employee']['name'];
            $emp_id = $leadDetails['employee']['empId'];
            if ($emp_id) {
                $emp_name = $emp_value . ' (' . $emp_id . ')';
            } else {
                $emp_name = $emp_value;
            }
        } else {
            $emp_name = '--';
        }
        $dis_type = $leadDetails['dispatchType']['dispatchType'];
        $string_version = $leadDetails['deliveryMode']['deliveryMode'];
        //        }

        //        $emp = User::where('role', 'EM')->where('isActive', 1)->get();
        //        $transfer[] = "<option value=''>Select Employee</option>";
        //        foreach ($emp as $employee) {
        //            $transfer[] = "<option value='$employee->_id'>$employee->name</option>";
        //        }

        if (Auth::user()->_id == $leadDetails->createdBy[0]['id']) {
            $receptionist = true;
        } else {
            $receptionist = false;
        }

        if ((Auth::user()->_id == $leadDetails->employee['id']) || (session('assigned_agent') == $leadDetails->employee['id'])) {
            $assign_to = true;
        } else {
            $assign_to = false;
        }
        if (isset($leadDetails['agent']['name'])) {
            $ag_value = $leadDetails['agent']['name'];
            if (isset($leadDetails['agent']['empid'])) {
                if ($leadDetails['agent']['empid'] != "") {
                    $ag_id = $leadDetails['agent']['empid'];
                    $ag_name = $ag_value . ' (' . $ag_id . ')';
                } else {
                    $ag_name = $ag_value?:'NA';
                }
            } else {
                $ag_name = $ag_value?:'NA';
            }
        } else {
            $ag_name = 'NA';
        }
        if (isset($leadDetails->MapDetails)) {
            $mapData = $leadDetails['MapDetails'];
            $testArray = [];
            foreach ($mapData as $data) {
                //				$testArray[]=$data['location']['coordinates'];
                $array1 = $data['location']['coordinates'];
                $array2 = array($data['updateBy'], $data['deliveryTime'], $data['deliveryDate']);
                $testArray[] = array_merge($array1, $array2);
            }
            $mapSection = view('dispatch.includes_pages.map_lead', [
                'testArray' => $testArray
            ])->render();
        } else {
            $mapSection = '';
            $testArray = [];
        }
        $upload_num = 0;
        $uploadSign = '';
        if (isset($leadDetails->deliveryStatus)) {
            foreach ($leadDetails->deliveryStatus as $status) {
                if (isset($status['upload_sign']) && $status['upload_sign'] != "") {
                    $upload_num++;
                }
            }
            if ($upload_num > 0) {
                $uploadSign = view('dispatch.includes_pages.upload_sign', [
                    'deliveryStatus' => $leadDetails->deliveryStatus
                ])->render();
            }
        }
        return response()->json([
            //            'transfer' => $transfer,
            'emp_option' => $emp_option,
            'emp_name' => $emp_name,
            'ag_name' => $ag_name,
            'success' => true,
            'leadDetails' => $leadDetails,
            'documentSection' => $documentSection,
            'string_version' => $string_version,
            'dis_type' => $dis_type,
            'address' => $address,
            'landmark' => $landmark,
            'doctype' => $doctype,
            'document' => $document,
            'receptionist' => $receptionist,
            'assign_to' => $assign_to,
            'value' => $value,
            'user' => $user,
            'caseManager' => $caseManager,
            'mapSection' => $mapSection,
            'testArray' => $testArray,
            'uploadSign' => $uploadSign
        ]);
    }

    /**
     * save transferred details
     */
    public function saveTransferred(Request $request)
    {
        $lead_id = $request->input('lead_id');
        $leadDetails = LeadDetails::find($lead_id);
        $saveMethod = $request->input('save_method');
        $referencenumber = $leadDetails->referenceNumber;
        $documentSelectArray = $request->input('docSelect');
        $documentIdArray = $request->input('docid');
        $casemanagerid = $leadDetails->caseManager['id'];
        $casemanager = User::find($casemanagerid);
        $caseemail = $casemanager->email;
        $casename = $casemanager->name;
        $caselink = url('/dispatch/receptionist-list/');
        $recp = User::where('isActive', 1)->where('role', "RP")->get();
        $users = [];
        $custname = $leadDetails->customer['name'];
        if ($saveMethod) {
            $updatedBy_obj = new \stdClass();
            $updatedBy_obj->id = new ObjectID(Auth::id());
            $updatedBy_obj->name = Auth::user()->name;
            $updatedBy_obj->date = date('d/m/Y');
            $updatedBy_obj->action = "For Transferred";
            $updatedBy[] = $updatedBy_obj;
            LeadDetails::where('_id', new ObjectId($lead_id))->push('updatedBy', $updatedBy);

            $finalStatusObject = new \stdClass();
            $finalStatusObject->id = new ObjectID(Auth::id());
            $finalStatusObject->name = Auth::user()->name;
            $finalStatusObject->date = date('d/m/Y');
            if ($saveMethod == 'delivered_button') {
                $finalStatusObject->status = "Marked as delivered";
                $finalStatus[] = $finalStatusObject;
                if ($leadDetails->finalStatus) {
                    LeadDetails::where('_id', new ObjectId($lead_id))->push('finalStatus', $finalStatus);
                } else {
                    $leadDetails->finalStatus = $finalStatus;
                }
                Session::flash('status', 'Delivered successfully');
                $leadDetails->save();
                $leadDetailsDet = LeadDetails::find($lead_id);
                $lead = $leadDetailsDet['dispatchDetails']['documentDetails'];
                foreach ($lead as $count => $reply) {
                    if (isset($documentSelectArray)) {
                        if (in_array($reply['id'], $documentSelectArray)) {
                            $this->saveDocumentStatus($lead_id, $count, '7');
                        }
                    }
                }
                foreach ($recp as $user) {
                    $casename = $user['name'];
                    $caseemail = $user['email'];
                    if ($caseemail != '') {
                        SendReceptionADleads::dispatch($casename, $caseemail, $referencenumber, $name, $caselink, $saveMethod, $custname);
                    }
                }
                $this->saveTabStatus($lead_id);

                return response()->json(['status' => 'go_completed']);
            } elseif ($saveMethod == 'reject_button') {
                $employeeStatusObject = new \stdClass();
                $employeeStatusObject->status = "Rejected";
                $leadDetails->schedulerejectstatus = $request->input('message');
                $employeeStatusObject->comment = $request->input('message');
                $EmployeeStatus[] = $employeeStatusObject;
                $name = $employeeStatusObject->name;
                if ($leadDetails->employeeStatus) {
                    LeadDetails::where('_id', new ObjectId($lead_id))->push(
                        'EmployeeStatus',
                        $EmployeeStatus
                    );
                } else {
                    $leadDetails->employeeStatus = $EmployeeStatus;
                }
                //  $leadDetails->dispatchStatus = 'Reception';
                Session::flash('status', 'Dispatch slip rejected successfully');
                $leadDetailsDet = LeadDetails::find($lead_id);
                $lead = $leadDetailsDet['dispatchDetails']['documentDetails'];
                foreach ($lead as $count => $reply) {
                    if (isset($docID)) {
                        if (in_array($reply['id'], $docID)) {
                            $this->saveDocumentStatus($lead_id, $count, '17');
                        }
                    }
                }
                $this->saveTabStatus($request->input('lead_id'));
                $action = "Employee List";
                $leadss = "";
                if ($caseemail != '') {
                    SendcasemanagerADleads::dispatch($casename, $caseemail, $referencenumber, $name, $caselink, $saveMethod, $action, $leadss, $custname);
                }
                foreach ($recp as $user) {
                    $casename = $user['name'];
                    $caseemail = $user['email'];
                    if ($caseemail != '') {
                        SendReceptionADleads::dispatch($casename, $caseemail, $referencenumber, $name, $caselink, $saveMethod, $custname);
                    }
                }
                $leadDetails->save();
                $this->setDispatchStatus($lead_id);
                return response()->json(['status' => 'go_reception']);
            }
        }
    }

    /**
     * save transfer form
     */
    public function saveTransferForm(Request $request)
    {
        $lead_id = $request->input('lead_id');
        $leadDetails = LeadDetails::find($lead_id);
        $referencenumber = $leadDetails->referenceNumber;
        $casemanagerid = $leadDetails->caseManager['id'];
        $cusname = $leadDetails->caseManager['name'];
        $casemanager = User::find($casemanagerid);
        $caseemail = $casemanager->email;
        $casename = $casemanager->name;
        $comment_submit_time = date('H:i:s');
        //		$assignid=$leadDetails->employee['id'];
        //		$assign=User::find($assignid);
        //		$assignname=$assign->name;
        //		$assignemail=$assign->email;
        //		$custid=$leadDetails->customer['id'];
        //        $cust=Customer::find($custid);
        $custname = $leadDetails->customer['name'];
        $custemail = $leadDetails->contactEmail;
        $saveMethod = $request->input('save_method');
        $docID = $request->input('docid');
        //		$recp=User::where('role',"RP")->where('isActive',1)->get();
        $caselink = url('/dispatch/receptionist-list/');
        if ($saveMethod) {
            $updatedBy_obj = new \stdClass();
            $updatedBy_obj->id = new ObjectID(Auth::id());
            $updatedBy_obj->name = Auth::user()->name;
            $updatedBy_obj->date = date('d/m/Y');
            $updatedBy_obj->action = "Transferred";
            $updatedBy[] = $updatedBy_obj;
            $name = $updatedBy_obj->name;
            LeadDetails::where('_id', new ObjectId($lead_id))->push('updatedBy', $updatedBy);

            if ($saveMethod == 'print_without_button') {
                $print = "print_without";
            } else {
                if ($saveMethod == 'print_button') {
                    $print = "print_with";
                } else {
                    $print = '';
                    if ($saveMethod == 'delivered_button') {
                        $comment_submit_object = new \stdClass();
                        $comment_submit_object->comment = 'Completed from transferred list' . ',' . 'Message' . ' : ' . ucfirst(ucwords($request->input('action_comment')));
                        $comment_submit_object->commentBy = Auth::user()->name;
                        $comment_submit_object->commentTime = $comment_submit_time;
                        $comment_submit_object->id = new ObjectId(Auth::id());
                        $comment_submit_object->date = date('d/m/Y');
                        $comment_submit_array[] = $comment_submit_object;
                        $leadDetails->push('comments', $comment_submit_array);

                        $finalStatusObject = new \stdClass();
                        $finalStatusObject->id = new ObjectID(Auth::id());
                        $finalStatusObject->name = Auth::user()->name;
                        $finalStatusObject->date = date('d/m/Y');
                        $finalStatus[] = $finalStatusObject;
                        if (isset($leadDetails->finalStatus)) {
                            LeadDetails::where('_id', new ObjectId($lead_id))->push('finalStatus', $finalStatus);
                        } else {
                            $leadDetails->finalStatus = $finalStatus;
                        }
                        $transferTo = $leadDetails['transferTo'];
                        $uniq_val = [];
                        foreach ($transferTo as $transfer) {
                            $uniq_val[] = $transfer['uniqval'];
                        }
                        $leadDetailsDet = LeadDetails::find($lead_id);
                        $lead = $leadDetailsDet['dispatchDetails']['documentDetails'];
                        $uniqTransferId = [];
                        foreach ($lead as $count => $reply) {
                            if (isset($docID)) {
                                if (in_array($reply['id'], $docID)) {
                                    if ($reply['DocumentCurrentStatus'] == '9') {
                                        $uniqTransferId[] = $reply['uniqTransferId'];
                                        $this->saveDocumentStatus($lead_id, $count, '7');
                                    }
                                    if ($reply['DocumentCurrentStatus'] == '14') {
                                        $uniqTransferId[] = $reply['uniqTransferId'];
                                        $this->saveDocumentStatus($lead_id, $count, '16');
                                    }
                                }
                            }
                        }
                        foreach ($uniq_val as $count => $transfer) {
                            if ((in_array($transfer, $uniqTransferId))) {
                                LeadDetails::where(
                                    '_id',
                                    new ObjectId($lead_id)
                                )->update(array('transferTo.' . $count . '.status' => 'Completed'));
                            }
                        }
                        $this->saveTabStatus($request->input('lead_id'));

                        $action = "Completed List";
                        $leadss = "";
                        //						if($caseemail != '') {
                        //							SendcasemanagerADleads::dispatch($casename, $caseemail, $referencenumber, $name, $caselink, $saveMethod, $action, $leadss, $custname);
                        //						}
                        //						foreach($recp as $user){
                        //							$casename=$user['name'];
                        //							$caseemail=$user['email'];
                        //							if($caseemail != '') {
                        //								SendReceptionADleads::dispatch($casename, $caseemail, $referencenumber, $name, $caselink, $saveMethod, $custname);
                        //							}
                        //						}
                        Session::flash('status', 'Completed successfully');
                        $leadDetails->save();
                        $this->setDispatchStatus($lead_id);
                        return response()->json(['status' => 'go_completed']);
                    } elseif ($saveMethod == 'approve_button') {
                        $leads = $leadDetails['dispatchDetails']['documentDetails'];
                        $transferTo = $leadDetails['transferTo'];
                        $uniq_val = [];
                        foreach ($transferTo as $transfer) {
                            $uniq_val[] = $transfer['uniqval'];
                        }
                        $uniqTransferId = [];
                        foreach ($leads as $count => $reply) {
                            if ($reply['DocumentCurrentStatus'] == '9' && (in_array($reply['id'], $docID))) {
                                $uniqTransferId[] = $reply['uniqTransferId'];
                                DispatchController::saveDocumentStatus($leadDetails->_id, $count, '6');
                            }
                            if ($reply['DocumentCurrentStatus'] == '14' && (in_array($reply['id'], $docID))) {
                                $uniqTransferId[] = $reply['uniqTransferId'];
                                DispatchController::saveDocumentStatus($leadDetails->_id, $count, '15');
                            }
                        }

                        foreach ($uniq_val as $count => $transfer) {
                            if ((in_array($transfer, $uniqTransferId))) {
                                LeadDetails::where(
                                    '_id',
                                    new ObjectId($lead_id)
                                )->update(array('transferTo.' . $count . '.status' => 'Completed'));
                            }
                        }
                        $this->saveTabStatus($lead_id);

                        $action = "Receptionist List";
                        $transfrByName = [];
                        foreach ($leadDetails->transferTo as $key => $transfer) {
                            if (isset($transfer['uniqval'])) {
                                if (in_array($transfer['uniqval'], $uniqTransferId)) {
                                    $user = User::find($transfer['transferById']);
                                    $transfrByName[] = $user->name;
                                    $ActionPerformed = 'approved';
                                    Mail::to($user->email)->send(new sendTransferRejectedMail($referencenumber, $name, $saveMethod, $action, $custname, $caselink, $ActionPerformed));
                                }
                            }
                        }
                        $comment_submit_object = new \stdClass();
                        $comment_submit_object->comment = 'Approved by ' . Auth::user()->name . ',' . 'Message' . ' : ' . ucfirst(ucwords($request->input('action_comment')));
                        $comment_submit_object->commentBy = Auth::user()->name;
                        $comment_submit_object->commentTime = $comment_submit_time;
                        $comment_submit_object->id = new ObjectId(Auth::id());
                        $comment_submit_object->date = date('d/m/Y');
                        $comment_submit_array[] = $comment_submit_object;
                        $leadDetails->push('comments', $comment_submit_array);
                        $leadDetails->save();
                        $this->setDispatchStatus($lead_id);
                        Session::flash('status', 'Transfer Approved');

                        return response()->json(['status' => 'approved']);
                    } elseif ($saveMethod == 'reject_button') {
                        $comment_submit_time = date('H:i:s');
                        $comment_submit_object = new \stdClass();
                        $comment_submit_object->comment = 'Rejected from transferred list' . ',' . 'Message' . ' : ' . ucfirst(ucwords($request->input('message')));
                        $comment_submit_object->commentBy = Auth::user()->name;
                        $comment_submit_object->commentTime = $comment_submit_time;
                        $comment_submit_object->id = new ObjectId(Auth::id());
                        $comment_submit_object->date = date('d/m/Y');
                        $comment_submit_array[] = $comment_submit_object;
                        $leadDetails->push('comments', $comment_submit_array);

                        $leadDetails->schedulerejectstatus = $request->input('message');
                        //							dd($docID);
                        //							$leadDetails->dispatchStatus = 'Reception';
                        Session::flash('status', 'Dispatch slip rejected successfully');
                        $leadDetailsDet = LeadDetails::find($lead_id);
                        $uniq_val = [];
                        $uniqTransferId = [];
                        $transferTo = $leadDetailsDet['transferTo'];
                        foreach ($transferTo as $transfer) {
                            $uniq_val[] = $transfer['uniqval'];
                        }

                        $lead = $leadDetailsDet['dispatchDetails']['documentDetails'];
                        $uniqID = [];
                        foreach ($lead as $count => $reply) {
                            if (isset($docID)) {
                                if (in_array($reply['id'], $docID)) {
                                    $uniqID[] = $reply['uniqTransferId'];
                                    $this->saveDocumentStatus($lead_id, $count, '17');
                                }
                            }
                        }
                        foreach ($uniq_val as $count => $transfer) {
                            if ((in_array($transfer, $uniqID))) {
                                LeadDetails::where(
                                    '_id',
                                    new ObjectId($lead_id)
                                )->update(array('transferTo.' . $count . '.status' => 'Rejected'));
                            }
                        }
                        $transfrByName = [];
                        $this->saveTabStatus($request->input('lead_id'));
                        $action = "Reception List";
                        foreach ($leadDetails->transferTo as $key => $transfer) {
                            if (isset($transfer['uniqval'])) {
                                if (in_array($transfer['uniqval'], $uniqID)) {
                                    $user = User::find($transfer['transferById']);
                                    $transfrByName[] = $user->name;
                                    $ActionPerformed = 'rejected';
                                    Mail::to($user->email)->send(new sendTransferRejectedMail($referencenumber, $user->name, $saveMethod, $action, $custname, $caselink, $ActionPerformed));
                                }
                            }
                        }
                        $leadss = "";
                        if ($caseemail != '') {
                            $saveMethod = 'transfer_reject';
                            SendcasemanagerADleads::dispatch($casename, $caseemail, $referencenumber, $transfrByName[0], $caselink, $saveMethod, $action, $leadss, $custname);
                        }
                        //						foreach($recp as $user){
                        //							$casename=$user['name'];
                        //							$caseemail=$user['email'];
                        //							if($caseemail != '') {
                        //								SendReceptionADleads::dispatch($casename, $caseemail, $referencenumber, $name, $caselink, $saveMethod, $custname);
                        //							}
                        //						}
                        $leadDetails->save();
                        $this->setDispatchStatus($lead_id);
                        Session::flash('status', 'Transfer Rejected');
                        return response()->json(['status' => 'rejected']);
                    } elseif ($saveMethod == 'transfer_to') {
                        $transferTo = $leadDetails['transferTo'];
                        $transfer_employee = $request->input('transfer_employee');
                        $leads = $leadDetails['dispatchDetails']['documentDetails'];
                        $uniq_val = [];
                        $uniqTransferId = [];
                        foreach ($transferTo as $transfer) {
                            $uniq_val[] = $transfer['uniqval'];
                        }
                        $uniq_id = uniqid();
                        foreach ($leads as $count => $reply) {
                            if (in_array($reply['id'], $docID)) {
                                if ($reply['DocumentCurrentStatus'] == '9') {
                                    $saveStatus[] = $this->saveDocumentStatus($lead_id, $count, '9');
                                    $uniqTransferId[] = $reply['uniqTransferId'];
                                    LeadDetails::where(
                                        '_id',
                                        new ObjectId($lead_id)
                                    )->update(array('dispatchDetails.documentDetails.' . $count . '.uniqTransferId' => $uniq_id));
                                }
                                if ($reply['DocumentCurrentStatus'] == '14') {
                                    $saveStatus[] = $this->saveDocumentStatus($lead_id, $count, '14');
                                    $uniqTransferId[] = $reply['uniqTransferId'];
                                    LeadDetails::where(
                                        '_id',
                                        new ObjectId($lead_id)
                                    )->update(array('dispatchDetails.documentDetails.' . $count . '.uniqTransferId' => $uniq_id));
                                }
                            }
                        }
                        foreach ($uniq_val as $count => $transfer) {
                            if ((in_array($transfer, $uniqTransferId))) {
                                LeadDetails::where(
                                    '_id',
                                    new ObjectId($lead_id)
                                )->update(array('transferTo.' . $count . '.status' => 'transfer cancelled'));
                            }
                        }
                        $this->saveTabStatus($lead_id);
                        $this->setDispatchStatus($lead_id);
                        $employee_details = User::find($transfer_employee);
                        $link = url('/dispatch/employee-view-list/');
                        $caselink = url('/dispatch/receptionist-list/');
                        $name = $employee_details->name;
                        $email = $employee_details->email;
                        SendTransferleads::dispatch(
                            $name,
                            $email,
                            $referencenumber,
                            $link,
                            $custname,
                            Auth::user()->name
                        );
                        $transfer = new \stdClass();
                        $transfer->id = new ObjectId($employee_details->_id);
                        $transfer->uniqval = $uniq_id;
                        $transfer->name = $employee_details->name;
                        $transfer->empCode = $employee_details->empID;
                        $transfer->transferById = new ObjectId(Auth::id());
                        $transfer->transfered_documents = $docID;
                        $transfer->transferByName = Auth::user()->name;
                        $transfer->transferDate = date('d/m/Y');
                        $transfer->status = 'Transferred';
                        $transferStatus = $transfer;
                        $comment_submit_time = date('H:i:s');
                        $comment_submit_object = new \stdClass();
                        $comment_submit_object->comment = 'Lead transferred' . ',' . 'Message' . ' : ' . ucfirst(ucwords($request->input('action_transfer_comment')));
                        $comment_submit_object->commentBy = Auth::user()->name;
                        $comment_submit_object->commentTime = $comment_submit_time;
                        $comment_submit_object->id = new ObjectId(Auth::id());
                        $comment_submit_object->date = date('d/m/Y');
                        $comment_submit_array[] = $comment_submit_object;
                        $leadDetails->push('comments', $comment_submit_array);
                        Sendcasemangerleads::dispatch(
                            $casename,
                            $caseemail,
                            $referencenumber,
                            $name,
                            $caselink,
                            $custname,
                            Auth::user()->name
                        );
                        LeadDetails::where('_id', $lead_id)->push(['transferTo' => $transferStatus]);
                        $leadDetails->save();
                        Session::flash('status', 'Lead is transferred to ' . $employee_details->name);
                        return response()->json(['status' => 'approved']);
                    }
                }
            }

            if ($print != '') {
                $leadDetails->save();
                $pdf = PDF::loadView(
                    'dispatch.pdf.scheduledelivery',
                    ['leadDetails' => $leadDetails, 'print' => $print, 'documentSelectArray' => $docID]
                );
                $pdf_name = 'dispatch-slip_' . time() . '_' . $leadDetails->_id . '.pdf';
                $pdf->setOption('page-width', '200');
                $pdf->setOption('page-height', '260')->inline();
                $temp_path = public_path('pdf/' . $pdf_name);
                $pdf->save('pdf/' . $pdf_name);
                $pdf_file = $this->uploadFileToCloud_file($pdf_name, $temp_path);
                unlink($temp_path);
                $leadDetails->dispatchSlip = $pdf_file;
                $leadDetails->save();
                return response()->json(['success' => 'pdf', 'pdf' => $leadDetails->dispatchSlip]);
            }
        }
    }

    /**
     * export transferred details as excel
     */
    public function exportTransferred(Request $request)
    {
        ini_set('xdebug.max_nesting_level', 500);

        $email = $request->input('email');
        $filter_data = json_decode(session('filter'));

        $sort = session('sort');
        $search = session('search');
        $leadDetails = LeadDetails::where('active', 1)->where('employeeTabStatus', (int) 1);
        if (session('role') == 'Employee') {
            $leadDetails = $leadDetails->where(function ($q) {
                $q->where('caseManager.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('agent.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('employee.id', new ObjectID(Auth::user()->_id))->orwhere('transferTo.id', new ObjectID(Auth::user()->_id));
            });
        } elseif (session('role') == 'Agent') {
            $leadDetails = $leadDetails->where(function ($q) {
                $q->where('agent.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('caseManager.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('employee.id', new ObjectID(Auth::user()->_id));
            });
        } elseif (session('role') == 'Coordinator') {
            $leadDetails = $leadDetails->where(function ($q) {
                $q->where('agent.id', session('assigned_agent'))
                    ->orwhere('agent.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('employee.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('employee.id', session('assigned_agent'));
            });
        } elseif (session('role') == 'Supervisor') {
            $leadDetails = $leadDetails->where(function ($q) {
                $q->where('agent.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('caseManager.id', new ObjectID(Auth::user()->_id))
                    ->orwhere('employee.id', new ObjectID(Auth::user()->_id))
                    ->orwhereIn('employee.id', session('employees'));
            });
        } elseif (session('role') != 'Admin' && session('role') != 'Receptionist') {
            $leadDetails = $leadDetails->where('employee.id', new ObjectID(Auth::user()->_id));
        }

        if (!empty($filter_data)) {
            if (!empty($filter_data->agent)) {
                $count = 0;
                foreach ($filter_data->agent as $agent) {
                    $objectArray[$count] = new ObjectId($agent);
                    $count++;
                }
                $leadDetails = $leadDetails->whereIn('agent.id', $objectArray);
            }
            if (!empty($filter_data->case_manager)) {
                $count = 0;
                foreach ($filter_data->case_manager as $manager) {
                    $objectArray[$count] = new ObjectId($manager);
                    $count++;
                }
                $leadDetails = $leadDetails->whereIn('caseManager.id', $objectArray);
            }
            if (!empty($filter_data->customer)) {
                $count = 0;
                foreach ($filter_data->customer as $cust) {
                    $objectArray[$count] = new ObjectId($cust);
                    $count++;
                }
                $leadDetails = $leadDetails->whereIn('customer.id', $objectArray);
            }
            if (!empty($filter_data->delivery)) {
                $count = 0;
                foreach ($filter_data->delivery as $mode) {
                    $objectArray[$count] = new ObjectId($mode);
                    $count++;
                }
                $leadDetails = $leadDetails->whereIn('deliveryMode.id', $objectArray);
            }
            if (!empty($filter_data->dispatch)) {
                $count = 0;
                foreach ($filter_data->dispatch as $type) {
                    $objectArray[$count] = new ObjectId($type);
                    $count++;
                }
                $leadDetails = $leadDetails->whereIn('dispatchType.id', $objectArray);
            }
            if (!empty($filter_data->assigned)) {
                $count = 0;
                foreach ($filter_data->assigned as $type) {
                    $objectArray[$count] = new ObjectId($type);
                    $count++;
                }
                $leadDetails = $leadDetails->whereIn('employee.id', $objectArray);
            }
            if (!empty($filter_data->status)) {
                $count = 0;
                foreach ($filter_data->status as $stat) {
                    $objectArray[$count] = $stat;
                    $count++;
                }
                $leadDetails = $leadDetails->whereIn('dispatchStatus', $objectArray);
            }
        }



        if (!empty($sort)) {
            if ($sort == "Customer Name") {
                $leadDetails = $leadDetails->orderBy('customer.name');
            } elseif ($sort == "Agent") {
                $leadDetails = $leadDetails->orderBy('agent.name');
            } elseif ($sort == "Case Manager") {
                $leadDetails = $leadDetails->orderBy('caseManager.name');
            } elseif ($sort == "Dispatch Type") {
                $leadDetails = $leadDetails->orderBy('dispatchType.dispatchType');
            } elseif ($sort == "Delivery Mode") {
                $leadDetails = $leadDetails->orderBy('deliveryMode.deliveryMode');
            }
        } elseif (empty($sort)) {
            $leadDetails = $leadDetails->orderBy('created_at', 'DESC');
        }
        if ($search) {
            $leadDetails = $leadDetails->where(function ($query) use ($search) {
                $query->Where('referenceNumber', 'like', '%' . $search . '%')
                    ->orWhere('customer.name', 'like', '%' . $search . '%')
                    ->orWhere('customer.recipientName', 'like', '%' . $search . '%')
                    ->orWhere('customer.customerCode', 'like', '%' . $search . '%')
                    ->orWhere('agent.name', 'like', '%' . $search . '%')
                    ->orWhere('caseManager.name', 'like', '%' . $search . '%')
                    ->orWhere('contactNumber', 'like', '%' . $search . '%')
                    ->orWhere('contactEmail', 'like', '%' . $search . '%')
                    ->orWhere('deliveryMode.deliveryMode', 'like', '%' . $search . '%')
                    ->orWhere('dispatchType.dispatchType', 'like', '%' . $search . '%');
            });
            session()->put('search', $search);
        }
        $leadDetails = $leadDetails->select('customer', 'created_at', 'contactNumber', 'contactEmail', 'referenceNumber', 'deliveryMode', 'dispatchType', 'caseManager.name', 'employee', 'agent', 'transferTo', 'dispatchDetails.land_mark', 'dispatchDetails.documentDetails');

        $data[] = array('Transferred Documents');
        $excel_header = [
            'CID',
            'CUSTOMER NAME',
            'LEAD CREATED DATE',
            'TRANSACTION NUMBER',
            'DISPATCH TYPE',
            'TYPE OF DOCUMENT',
            'TYPE OF DELIVERY',
            'AMOUNT / CARDS',
            'CUSTOMER CONTACT NUMBER',
            'CUSTOMER EMAIL ID',
            'RECIPIENT NAME',
            'CASE MANAGER',
            'AGENT NAME',
            'TRANSFER TO',
            'DELIVERY MODE',
            'ASSIGNED TO',
            'LAND MARK',
            'DOCUMENT DESCRIPTION'
        ];

        $file_name = 'Transferred Documents' . (string) time() . rand();
        Excel::create($file_name, function ($excel) use ($leadDetails, $excel_header) {
            $excel->sheet('Transferred Documents', function ($sheet) use ($leadDetails, $excel_header) {
                $sheet->appendRow($excel_header);
                $sheet->row(1, function ($row) {
                    $row->setFontSize(10);
                    $row->setFontColor('#ffffff');
                    $row->setBackground('#1155CC');
                });
                $leadDetails->chunk(100, function ($final_leads) use ($sheet) {
                    foreach ($final_leads as $leads) {
                        $createdDate = $leads->created_at;
                        $date = date("d/m/Y", strtotime($createdDate));
                        if (isset($leads->employee['name'])) {
                            $assignname = ucwords(strtolower($leads->employee['name']));
                            if (isset($leads->employee['empId'])) {
                                if ($leads->employee['empId'] != "") {
                                    $assignid = $leads->employee['empId'];
                                    $assignvalue = $assignname . ' (' . $assignid . ')';
                                } else {
                                    $assignvalue = $assignname;
                                }
                            } else {
                                $assignvalue = $assignname;
                            }
                        } else {
                            $assignvalue = '--';
                        }
                        if (isset($leads->agent['name'])) {
                            $agentname = ucwords(strtolower($leads->agent['name']));
                            if (isset($leads->agent['empid'])) {
                                if ($leads->agent['empid'] != "") {
                                    $agentid = $leads->agent['empid'];
                                    $agentvalue = ucwords(strtolower($agentname)) . ' (' . $agentid . ')';
                                } else {
                                    $agentvalue = ucwords(strtolower($agentname));
                                }
                            } else {
                                $agentvalue = ucwords(strtolower($agentname));
                            }
                        } else {
                            $agentvalue = 'NA';
                        }
                        if (isset($leads->contactNumber)) {
                            $contact = $leads->contactNumber;
                        } else {
                            $contact = '--';
                        }
                        if (isset($leads->contactEmail)) {
                            $contactEmail = $leads->contactEmail;
                        } else {
                            $contactEmail = '--';
                        }
                        if (isset($leads['dispatchType.dispatchType'])) {
                            $disType = $leads['dispatchType.dispatchType'];
                        } else {
                            $disType = '--';
                        }
                        if (isset($leads['deliveryMode.deliveryMode'])) {
                            $disMode = $leads['deliveryMode.deliveryMode'];
                        } else {
                            $disMode = '--';
                        }
                        if (isset($leads['customer.customerCode'])) {
                            $custCode = $leads['customer.customerCode'];
                        } else {
                            $custCode = '--';
                        }
                        if (isset($leads['customer.name'])) {
                            $custName = $leads['customer.name'];
                        } else {
                            $custName = '--';
                        }
                        if (isset($leads['customer.recipientName'])) {
                            $recName = $leads['customer.recipientName'];
                        } else {
                            $recName = '--';
                        }
                        if (isset($leads['caseManager.name'])) {
                            $caseManager = $leads['caseManager.name'];
                        } else {
                            $caseManager = '--';
                        }
                        if (isset($leads['dispatchDetails.land_mark'])) {
                            $land = $leads['dispatchDetails.land_mark'];
                        } else {
                            $land = '--';
                        }
                        if (isset($leads['dispatchDetails']['documentDetails'])) {
                            $leadDocuments = $leads['dispatchDetails']['documentDetails'];
                            foreach ($leadDocuments as $count => $reply) {
                                if ($reply['DocumentCurrentStatus'] == '9' || $reply['DocumentCurrentStatus'] == '14') {
                                    $transfer_name = '--';
                                    $transferto = $leads->transferTo;
                                    foreach ($transferto as $key => $value) {
                                        if (isset($value['uniqval'])   && ($value['status'] == 'Transferred' || $value['status'] == 'Collected')) {
                                            if ($value['uniqval'] == $reply['uniqTransferId']) {
                                                $transfer_name = $value['name'];
                                                break;
                                            }
                                        }
                                    }
                                    $data = array(
                                        $custCode ?: '--',
                                        ucwords(strtolower($custName)),
                                        $date,
                                        $leads['referenceNumber'],
                                        $disType,
                                        $reply['documentName'],
                                        $disMode,
                                        $reply['amount'] ?: '--',
                                        $contact,
                                        $contactEmail,
                                        ucwords(strtolower($recName)),
                                        ucwords(strtolower($caseManager)),
                                        $agentvalue,
                                        $transfer_name,
                                        $disMode,
                                        $assignvalue,
                                        $land ?: '--',
                                        $reply['documentDescription'] ?: '--'
                                    );
                                    $sheet->appendRow($data);
                                }
                            }
                        } else {
                            $data = array(
                                $custCode ?: '--',
                                ucwords(strtolower($custName)),
                                $date,
                                $leads['referenceNumber'],
                                $disType,
                                '--',
                                $disMode,
                                '--',
                                $contact,
                                $contactEmail,
                                ucwords(strtolower($recName)),
                                $agentvalue,
                                $disMode,
                                $assignvalue,
                                $land ?: '--',
                                '--'
                            );
                            $sheet->appendRow($data);
                        }
                        //
                    }
                });
            });
        })->store('xls', public_path('excel'));
        $excel_name = $file_name . '.' . 'xls';
        $send_excel = public_path('/excel/' . $excel_name);
        //		dd($send_excel);
        $tab_value = 'transfer';
        sendExcel::dispatch($email, $send_excel, $tab_value);
        //		Session::flash('status', 'Excel send to '. $email );
        return 'success';
    }

    /**
     * get assigned name list
     */
    public function getAssignedName(Request $request)
    {
        $mode = $request->input('delMode');
        $agent = $request->input('agent');
        $searchData = $request->input('searchData');
        $delivery_mode = DeliveryMode::find($mode);
        if ($delivery_mode->deliveryMode == 'Agent') {
            $employees = User::where('isActive', 1)->where('role', 'AG');
            if (!empty($searchData)) {
                $employees = $employees->where(function ($q) use ($searchData, $agent) {
                    $q->where('name', 'like', '%' . $searchData . '%')->orWhere(
                        'empID',
                        'like',
                        '%' . $searchData . '%'
                    )->orWhere('_id', 'like', '%' . new ObjectID($agent) . '%');
                });
            }
            $response[] = "<option value=''>Select Agent</option>";
        } elseif ($delivery_mode->deliveryMode == 'Courier') {
            $employees = User::where('isActive', 1)->where('role', 'CR');
            if (!empty($searchData)) {
                $employees = $employees->where(function ($q) use ($searchData) {
                    $q->where('name', 'like', '%' . $searchData . '%')->orWhere(
                        'empID',
                        'like',
                        '%' . $searchData . '%'
                    );
                });
            }
            $response[] = "<option value=''>Select Courier</option>";
        } elseif ($delivery_mode->deliveryMode == 'Supervisor') {
            $employees = User::where('isActive', 1)->where('role', 'SV');
            if (!empty($searchData)) {
                $employees = $employees->where(function ($q) use ($searchData) {
                    $q->where('name', 'like', '%' . $searchData . '%')->orWhere(
                        'empID',
                        'like',
                        '%' . $searchData . '%'
                    );
                });
            }
            $response[] = "<option value=''>Select Supervisor</option>";
        } else {
            $employees = User::where('isActive', 1)->where(function ($q) {
                $q->where('role', 'EM')->orwhere('role', 'MS');
            });
            if (!empty($searchData)) {
                $employees = $employees->where(function ($q) use ($searchData) {
                    $q->where('name', 'like', '%' . $searchData . '%')->orWhere(
                        'empID',
                        'like',
                        '%' . $searchData . '%'
                    );
                });
            }
            $response[] = "<option value=''>Select Employee</option>";
        }
        $employees = $employees->orderBy('name')->take(10)->get();
        foreach ($employees as $employee) {
            if ($employee['_id'] == $agent) {
                if ($employee->empID != '') {
                    $id = ' (' . $employee->empID . ')';
                } else {
                    $id = '';
                }
                $response[] = "<option value='$employee->_id' selected>$employee->name $id</option>";
            } else {
                if ($employee->empID != '') {
                    $id = ' (' . $employee->empID . ')';
                } else {
                    $id = '';
                }
                $response[] = "<option value='$employee->_id'>$employee->name $id</option>";
            }
        }
        return response()->json(['success' => true, 'response_assign' => $response]);
    }

    /**
     * get agent name list
     */
    public function getAgentName(Request $request)
    {
        $searchData = $request->input('searchData');
        if (!empty($searchData)) {
            $employees = User::where('isActive', 1)->where('role', 'AG')->where(function ($q) use ($searchData) {
                $q->where('name', 'like', $searchData . '%')->orWhere(
                    'empID',
                    'like',
                    $searchData . '%'
                );
            });
            if (count($employees) == 0) {
                $employees = User::where('isActive', 1)->where('role', 'AG')->where(function ($q) use ($searchData) {
                    $q->where('name', 'like', '%' . $searchData . '%')->orWhere(
                        'empID',
                        'like',
                        $searchData . '%'
                    );
                });
            }
            $employees = $employees->take(10)->get();
        } else {
            $employees = User::where('isActive', 1)->where('role', 'AG')->take(10)->get();
        }

        $response[] = "<option value=''>Select Agent</option>";
        foreach ($employees as $employee) {
            if ($employee->empID != '') {
                $id = ' (' . $employee->empID . ')';
            } else {
                $id = '';
            }
            $response[] = "<option value='$employee->_id'>$employee->name $id</option>";
        }
        return response()->json(['success' => true, 'response_agent' => $response]);
    }

    /**
     * get transfer to name list
     */
    public function getTransferName(Request $request)
    {
        $searchData = $request->input('searchData');
        $employees = User::where('isActive', 1)->where(function ($q) {
            $q->where('role', 'EM')->orwhere('role', 'AD');
        });
        if (!empty($searchData)) {
            $employees = $employees->where(function ($q) use ($searchData) {
                $q->where('name', 'like', '%' . $searchData . '%')->orWhere(
                    'empID',
                    'like',
                    '%' . $searchData . '%'
                );
            });
        }
        $response[] = "<option value=''>Select Employee</option>";
        $employees = $employees->orderBy('name')->take(10)->get();
        foreach ($employees as $employee) {
            if ($employee->empID != '') {
                $id = ' (' . $employee->empID . ')';
            } else {
                $id = '';
            }
            $response[] = "<option value='$employee->_id'>$employee->name $id</option>";
        }
        return response()->json(['success' => true, 'response_transfer' => $response]);
    }


    /**
     * Replace all direct with one
     */
    public function replaceAgent()
    {
        $agents = User::where('firstName', 'Direct')->delete();
        $user_details = new User();
        $user_details->role = "AG";
        $role = Role::where('abbreviation', 'AG')->first();
        $user_details->firstName = ucwords(strtolower('Direct'));
        $user_details->lastName = ucwords(strtolower(''));
        $user_details->email = '';
        $user_details->password = bcrypt(123456);
        $user_details->empID = 'B-0001';

        $user_details->department = ucwords(strtolower(''));
        $user_details->position = ucwords(strtolower(''));
        $user_details->nameOfSupervisor = ucwords(strtolower(''));
        $user_details->name = 'Direct';
        $user_details->role_name = 'Agent';
        $user_details->isActive = (int) 1;
        $user_details->save();
        dd($user_details);
    }


    public function changeAgentRec()
    {
        $customers = RecipientDetails::where('status', (int) 1)->where('agent.name', 'like', 'direct%')->get();
        $cunt = 0;
        foreach ($customers as $customer) {
            RecipientDetails::where(
                '_id',
                new ObjectId($customer->_id)
            )->update(array('agent.name' => 'Direct', 'agent.id' => new ObjectID('5c2c78bcec47fb6a504b02f2')));
            $cunt++;
        }
        echo $cunt;
    }
    public function RemoveSpecialChapr($value)
    {
        $str = ltrim($value, '=');
        return $str;
    }

    /**
     * unset all agents
     */
    public function unsetAgent()
    {
        $customers = RecipientDetails::all();
        $cunt = 0;
        foreach ($customers as $customer) {
            // var_dump($customer->agent);
            // if($customer->agent || $customer->agent==null)
            // {
                RecipientDetails::where('_id',new ObjectID($customer->_id))->unset('agent');
                $cunt++;
            // }
        }
        echo $cunt;
    }
    /**
     * unset agent in leads table
     */
    public function unsetAgentLead()
    {
        $customers = LeadDetails::where('saveType','recipient')->get();
        $cunt = 0;
        $Acunt = 0;
        $Dcunt = 0;
        foreach ($customers as $customer) {
            $id=$customer->_id;
            if(isset($customer->agent))
            {
                 LeadDetails::where('_id',new ObjectID($id))->unset('agent');
                 $Acunt++;
            }
            if(isset($customer->dispatchDetails))
            {
                LeadDetails::where('_id', new ObjectID($id))->update(array('dispatchDetails.agent' => (string)'NA'));
                $Dcunt++;
            }
            $cunt++;
            
        }
        echo 'count'.$cunt .'Agnt Count'.$Acunt.'In Ag count'.$Dcunt;
        }
}
