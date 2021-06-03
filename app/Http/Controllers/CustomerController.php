<?php

namespace App\Http\Controllers;

use App\Agent;
use App\AllCountries;
use App\CountryListModel;
use App\Customer;
use App\Enquiries;
use App\CustomerLevel;
use App\CustomerType;
use App\DeliveryMode;
use App\Departments;
use App\DispatchTypes;
use App\Insurer;
use App\PipelineItems;
use App\PipelineStatus;
use App\State;
use App\User;
use App\Emails;
use App\WorkType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use MongoDB\BSON\ObjectID;
use App\RecipientDetails;
use Log;
use App\CustomerDocuments;
use App\CustomerMode;
use App\SharedDocuments;
use App\LeadDetails;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.customer');
    }
    /**
     * index page
     */
    public function index(Request $request, $customerMode)
    {
        //        DB::enableQueryLog();
        //        $mainGroups = Customer::where('mainGroup.id', (string)0)->get();
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
        $customerModeIDs =    CustomerMode::pluck('_id');
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
            if ($customerMode == 1) {
                $mainGroups = Customer::where('mainGroup.id', (string) 0)->whereIn('_id', $mainArray)->where('customerMode', '!=',  new ObjectID($customerModeIDs[1]))->get();
            } else {
                $mainGroups = Customer::where('mainGroup.id', (string) 0)->whereIn('_id', $mainArray)->where('customerMode', new ObjectID($customerModeIDs[1]))->get();

            }
        } else {
            $mainGroups = '';
        }

        if (!empty($request->input('level'))) {
            $count = 0;
            foreach ($request->input('level') as $cust) {
                $mainArray[$count] = new ObjectId($cust);
                $count++;
            }
            $customerLevels = CustomerLevel::whereIn('_id', $mainArray)->get();
        } else {
            $customerLevels = '';
        }
        $filter_data = $request->input();
        return view('customers.index')->with(compact('customers', 'mainGroups', 'agents', 'customerMode', 'customerLevels', 'filter_data'));
    }

    /**
     * get agents for filter
     */
    public function getAgents(Request $request)
    {
        if ($request->input('q')) {
            $agents = User::where('isActive', 1)->where(
                function ($q) use ($request) {
                    $q->where('name', 'like', $request->input('q') . '%')
                        ->orwhere('empID', 'like', $request->input('q') . '%');
                }
            )->where(
                function ($q) {
                        $q->where('role', 'EM')->orWhere('role', 'AG');
                }
            )->orderBy('name')->get();

            if (count($agents) == 0) {
                $agents = User::where('isActive', 1)->where(
                    function ($q) use ($request) {
                        $q->where('name', 'like', '%' . $request->input('q') . '%')
                            ->orwhere('empID', 'like', '%' . $request->input('q') . '%');
                    }
                )->where(
                    function ($q) {
                            $q->where('role', 'EM')->orWhere('role', 'AG');
                    }
                )->orderBy('name')->get();
            }
        } else {
            $agents = User::where('isActive', 1)->where('role', 'AG')->take(10)->orderBy('name')->get();
        }
        foreach ($agents as $agent) {
            if ($agent->empID) {
                $agent->text = $agent->name . ' ( ' . $agent->empID . ' )';
                $agent->name = $agent->name . ' ( ' . $agent->empID . ' )';
            } else {
                $agent->text = $agent->name;
            }
            $agent->id = $agent->_id;
        }
        $data = array(
            'total_count' => count($agents),
            'incomplete_results' => false,
            'items' => $agents,
        );
        return json_encode($data);
    }

    /**
     * get main groups for filter
     */
    public function getMainGroup(Request $request)
    {
        if ($request->input('q')) {
            $mainGroups = Customer::where('mainGroup.id', (string) 0)
                ->where('fullName', 'like', $request->input('q') . '%')->get();
            if (count($mainGroups) == 0) {
                $mainGroups = Customer::where('mainGroup.id', (string) 0)
                    ->where('fullName', 'like', '%' . $request->input('q') . '%')->get();
            }
        } else {
            $mainGroups = Customer::where('mainGroup.id', (string) 0)->take(9)->get();
        }
        foreach ($mainGroups as $group) {
            $group->text = $group->fullName;
            $group->id = $group->_id;
            $group->name = $group->fullName;
        }

        if ($request->input('q')) {
            if (stripos('Nil', $request->input('q')) !== false) {
                $mainGroups->add(
                    [
                    'text' =>  'Nil',
                    'id' =>  'Nil',
                    'name' =>  'Nil'
                    ]
                );
            }
        } else {
            $mainGroups->add(
                [
                'text' =>  'Nil',
                'id' =>  'Nil',
                'name' =>  'Nil'
                ]
            );
        }

        $data = array(
            'total_count' => count($mainGroups),
            'incomplete_results' => false,
            'items' => $mainGroups,
        );
        return json_encode($data);
    }

    /**
     * get departments for filter
     */
    public function getDepartment(Request $request)
    {
        if ($request->input('q')) {
            $departments = Departments::where('name', 'like', $request->input('q') . '%')->get();
            if (count($departments) == 0) {
                $departments = Departments::where('name', 'like', '%' . $request->input('q') . '%')->get();
            }
        } else {
            $departments = Departments::take(10)->get();
        }
        foreach ($departments as $department) {
            $department->text = $department->name;
            $department->id = $department->_id;
        }
        $data = array(
            'total_count' => count($departments),
            'incomplete_results' => false,
            'items' => $departments,
        );
        return json_encode($data);
    }

    /**
     * get work types for filter
     */
    public function getWorkTypes(Request $request)
    {
        if ($request->input('q')) {
            $work_types = WorkType::where('name', 'like', $request->input('q') . '%')->get();
            if (count($work_types) == 0) {
                $work_types = WorkType::where('name', 'like', '%' . $request->input('q') . '%')->get();
            }
        } else {
            $work_types = WorkType::take(10)->get();
        }
        foreach ($work_types as $work) {
            $work->text = $work->name;
            $work->id = $work->_id;
        }
        $data = array(
            'total_count' => count($work_types),
            'incomplete_results' => false,
            'items' => $work_types,
        );
        return json_encode($data);
    }


    /**
     * get insurer for filter
     */
    public function filterInsurer(Request $request)
    {
        if ($request->input('q')) {
            $insurers = Insurer::where('name', 'like', $request->input('q') . '%')->get();

            if (count($insurers) == 0) {
                $insurers = Insurer::where('name', 'like', '%' . $request->input('q') . '%')->get();
            }
        } else {
            $insurers = Insurer::take(10)->get();
        }
        foreach ($insurers as $ins) {
            $ins->id = $ins->_id;
            $ins->text = $ins->name;
        }
        $data = array(
            'total_count' => count($insurers),
            'incomplete_results' => false,
            'items' => $insurers,
        );
        return json_encode($data);
    }

    /**
     * get work types for filter
     */
    public function getCurrentStatus(Request $request)
    {
        if ($request->input('q')) {
            $status = PipelineStatus::where('status', 'like', $request->input('q') . '%')->get();
            if (count($status) == 0) {
                $status = PipelineStatus::where('status', 'like', '%' . $request->input('q') . '%')->get();
            }
        } else {
            $status = PipelineStatus::take(10)->get();
        }
        foreach ($status as $status_data) {
            $status_data->text = $status_data->status;
            $status_data->name = $status_data->status;
            $status_data->id = $status_data->_id;
        }
        $data = array(
            'total_count' => count($status),
            'incomplete_results' => false,
            'items' => $status,
        );
        return json_encode($data);
    }

    /**
     * get main groups for filter
     */
    public function getMainGroupIds(Request $request)
    {
        if ($request->input('q')) {
            $mainGroups = Customer::where('customerCode', 'like', $request->input('q') . '%')->where('mainGroup.id', (string) 0)->get();
            if (count($mainGroups) == 0) {
                $mainGroups = Customer::where('customerCode', 'like', '%' . $request->input('q') . '%')->where('mainGroup.id', (string) 0)->get();
            }
        } else {
            $mainGroups = Customer::where('mainGroup.id', (string) 0)->take(9)->get();
        }
        foreach ($mainGroups as $group) {
            $group->text = $group->customerCode;
            $group->id = $group->customerCode;
            $group->name = $group->customerCode;
        }
        if ($request->input('q')) {
            if (stripos('Nil', $request->input('q')) !== false) {
                $mainGroups->add(
                    [
                    'text' =>  'Nil',
                    'id' =>  'Nil',
                    'name' =>  'Nil'
                    ]
                );
            }
        } else {
            $mainGroups->add(
                [
                'text' =>  'Nil',
                'id' =>  'Nil',
                'name' =>  'Nil'
                ]
            );
        }
        $data = array(
            'total_count' => count($mainGroups),
            'incomplete_results' => false,
            'items' => $mainGroups,
        );
        return json_encode($data);
    }


    /**
     * get level for filter
     */
    public function getLevel(Request $request)
    {
        if ($request->input('q')) {
            $mainGroups = CustomerLevel::where('name', 'like', '%' . $request->input('q') . '%')->get();
        } else {
            $mainGroups = CustomerLevel::take(10)->get();
        }
        foreach ($mainGroups as $group) {
            $group->text = $group->name;
            $group->id = $group->_id;
        }
        $data = array(
            'total_count' => count($mainGroups),
            'incomplete_results' => false,
            'items' => $mainGroups,
        );
        return json_encode($data);
    }

    /**
     * get customers for filter
     */
    public function getCustomer(Request $request)
    {
        // dd($request);
        if ($request->input('q')) {
            $customers = Customer::where('status', (int) 1)->where('fullName', 'like', $request->input('q') . '%')->get();
            $recepients = RecipientDetails::where('status', (int) 1)->where('fullName', 'like', $request->input('q') . '%')->get();
            if (count($customers) == 0 && count($recepients) == 0) {
                $customers = Customer::where('status', (int) 1)->where('fullName', 'like', '%' . $request->input('q') . '%')->get();
                $recepients = RecipientDetails::where('status', (int) 1)->where('fullName', 'like', '%' . $request->input('q') . '%')->get();
            }
            $customers = $customers->merge($recepients);
        } else {
            $customers = Customer::where('status', (int) 1)->take(10)->get();
        }
        foreach ($customers as $customer) {
            $customer->text = $customer->fullName;
            $customer->id = $customer->_id;
            $customer->name = $customer->fullName;
        }
        $data = array(
            'total_count' => count($customers),
            'incomplete_results' => false,
            'items' => $customers,
        );
        return json_encode($data);
    }

    /**
     * get customers for filter
     */
    public function getCaseManagers(Request $request)
    {
        if ($request->input('q')) {
            $case_managers = User::where('isActive', 1)->where(
                function ($q) {
                    $q->where('role', 'EM')->orWhere('role', 'AD')->orWhere('role', 'RP')->orWhere('role', 'AG')->orWhere('role', 'CO')->orWhere('role', 'SV');
                }
            )->where('name', 'like', $request->input('q') . '%')->get();
            if (count($case_managers) == 0) {
                $case_managers = User::where('isActive', 1)->where(
                    function ($q) {
                        $q->where('role', 'EM')->orWhere('role', 'AD')->orWhere('role', 'RP')->orWhere('role', 'AG')->orWhere('role', 'CO')->orWhere('role', 'SV');
                    }
                )->where('name', 'like', '%' . $request->input('q') . '%')->get();
            }
        } else {
            $case_managers = User::where('isActive', 1)->where(
                function ($q) {
                    $q->where('role', 'EM')->orWhere('role', 'AD')->orWhere('role', 'RP')->orWhere('role', 'AG')->orWhere('role', 'CO')->orWhere('role', 'SV');
                }
            )->take(10)->get();
        }

        foreach ($case_managers as $case) {
            $case->text = $case->name;
            $case->id = $case->_id;
        }
        $data = array(
            'total_count' => count($case_managers),
            'incomplete_results' => false,
            'items' => $case_managers,
        );
        return json_encode($data);
    }

    /**
     * get dispatch type for filter
     */
    public function getDispatchType(Request $request)
    {
        if (session('role') == 'Insurer' || session('role') == 'Employee' || session('role') == 'Supervisor'  || session('role') == 'Agent' || session('role') == 'Coordinator'
            || session('role') == 'Courier' || session('role') == 'Messenger' || session('role') == 'Accountant'
        ) {
            if ($request->input('q')) {
                $dispatch_types = DispatchTypes::where('type', '!=', 'Direct Collections')->where('type', 'like', $request->input('q') . '%')->get();
                if (count($dispatch_types) == 0) {
                    $dispatch_types = DispatchTypes::where('type', '!=', 'Direct Collections')->where('type', 'like', '%' . $request->input('q') . '%')->get();
                }
            } else {
                $dispatch_types = DispatchTypes::where('type', '!=', 'Direct Collections')->take(10)->get();
            }
        } else {
            if ($request->input('q')) {
                $dispatch_types = DispatchTypes::where('type', 'like', $request->input('q') . '%')->get();
                if (count($dispatch_types) == 0) {
                    $dispatch_types = DispatchTypes::where('type', 'like', '%' . $request->input('q') . '%')->get();
                }
            } else {
                $dispatch_types = DispatchTypes::take(10)->get();
            }
        }
        foreach ($dispatch_types as $dispatch) {
            $dispatch->text = $dispatch->type;
            $dispatch->name = $dispatch->type;
            $dispatch->id = $dispatch->_id;
        }
        $data = array(
            'total_count' => count($dispatch_types),
            'incomplete_results' => false,
            'items' => $dispatch_types,
        );
        return json_encode($data);
    }

    /**
     * get delivery mode for filter
     */
    public function getDeliveryMode(Request $request)
    {
        if ($request->input('q')) {
            $delivery_modes = DeliveryMode::where('deliveryMode', 'like', $request->input('q') . '%')->get();
            if (count($delivery_modes) == 0) {
                $delivery_modes = DeliveryMode::where('deliveryMode', 'like', '%' . $request->input('q') . '%')->get();
            }
        } else {
            $delivery_modes = DeliveryMode::take(10)->get();
        }

        foreach ($delivery_modes as $delivery) {
            $delivery->text = $delivery->deliveryMode;
            $delivery->name = $delivery->deliveryMode;
            $delivery->id = $delivery->_id;
        }
        $data = array(
            'total_count' => count($delivery_modes),
            'incomplete_results' => false,
            'items' => $delivery_modes,
        );
        return json_encode($data);
    }

    /**
     * get assignedto for filter
     */
    public function getAssignedTo(Request $request)
    {
        if ($request->input('q')) {
            $assigned_to = User::where('isActive', 1)->where(
                function ($q) {
                    $q->where('role', 'EM')->orWhere('role', 'AG')->orWhere('role', 'SV')->orWhere('role', 'CR')->orWhere('role', 'MS')->orWhere('role', 'AD')->orWhere('role', 'CO');
                }
            )->where(
                function ($q) use ($request) {
                        $q->where('name', 'like', $request->input('q') . '%')
                            ->orWhere('empID', 'like', $request->input('q') . '%');
                }
            )->get();
            if (count($assigned_to) == 0) {
                $assigned_to = User::where('isActive', 1)->where(
                    function ($q) {
                        $q->where('role', 'EM')->orWhere('role', 'AG')->orWhere('role', 'CR')->orWhere('role', 'SV')->orWhere('role', 'MS')->orWhere('role', 'AD')->orWhere('role', 'CO');
                    }
                )->where(
                    function ($q) use ($request) {
                            $q->where('name', 'like', '%' . $request->input('q') . '%')
                                ->orWhere('empID', 'like', '%' . $request->input('q') . '%');
                    }
                )->get();
            }
        } else {
            $assigned_to = User::where('isActive', 1)->where(
                function ($q) {
                    $q->where('role', 'EM')->orWhere('role', 'AG')->orWhere('role', 'CR')->orWhere('role', 'MS')->orWhere('role', 'SV')->orWhere('role', 'AD')->orWhere('role', 'CO');
                }
            )->take(10)->get();
        }

        foreach ($assigned_to as $assigned) {
            if ($assigned->empID) {
                $assigned->text = $assigned->name . '( ' . $assigned->empID . ' )';
                $assigned->name = $assigned->name . '( ' . $assigned->empID . ' )';
            } else {
                $assigned->text = $assigned->name;
            }
            $assigned->id = $assigned->_id;
        }
        $data = array(
            'total_count' => count($assigned_to),
            'incomplete_results' => false,
            'items' => $assigned_to,
        );
        return json_encode($data);
    }

    /**
     * customer create page
     */
    public function create()
    {
        $mainGroups = Customer::where('status', 1)->where('mainGroup.id', (string) 0)->get();
        $customerLevels = CustomerLevel::get();
        //        $agents = Agent::get();
        $agents = User::where('isActive', 1)->where('role', 'AG')->orderBy('name')->get();
        $customerTypes = CustomerType::get();
        $customerMode = CustomerMode::get();
        //        $cities = City::get();
        //        $countries = Country::get();
        $departments = Departments::get();
        //
        //        $all_countries=AllCountries::first();
        $all_countries = CountryListModel::get();
        $cities = State::all();
        $countries = [];
        foreach ($all_countries as $key => $country) {
            $name = $country['country'];
            $countries[] = $name['countryName'];
        }
        return view('customers.create')
            ->with(compact('mainGroups', 'customerLevels', 'customerTypes', 'agents', 'customerMode', 'cities', 'countries', 'departments'));
    }

    /**
     * function for get emirates
     */
    public function getEmirates(Request $request)
    {
        $country_name = $request->input('country_name');
        $id = $request->input('customer_id');
        $rid = $request->input('recipient_id');
        $recipient = RecipientDetails::find($rid);
        $customer = Customer::find($id);
        if ($customer) {
            $city_name = $customer->cityName;
        } elseif ($recipient) {
            $city_name = $recipient->cityName;
        } else {
            $city_name = '';
        }
        if ($country_name) {
            $all_countries = CountryListModel::where('country.countryName', $country_name)->first();
            $state_name = [];
            foreach ($all_countries['country']['states'] as $key => $states) {
                $state_name[] = $states['StateName'];
            }
            $response = '<option value=""  selected>Select Emirate</option>';
            foreach ($state_name as $state) {
                $response .= '<option value="' . $state . '"';
                if ($city_name == $state) {
                    $response .= ' selected ';
                }
                $response .= '>' . $state . '</option>';
            }
            echo $response;
        } else {
            $response = '<option value=""  selected>Select Emirate</option>';
            echo $response;
        }
    }

    /**
     * save customer details
     */
    public function store(Request $request)
    {
        if ($request->input('customer_id')) {
            if ($request->input('customerCode')) {
                $customer_code = $request->input('customerCode');
                $customerWithCode = Customer::where('customerCode', $customer_code)->where('status', 1)->first();
                if ($customerWithCode) {
                    if ($customerWithCode->_id != $request->input('customer_id')) {
                        return 'code_exist';
                    }
                }
            }
            $data = $request->except(['_token', 'customer_id', 'depContactMobile', 'depContactPerson', 'department', 'depContactEmail']);
            $customer_type = $data['customerType'];
            $customer_type_details = CustomerType::where('is_corporate', (int) $customer_type)->first();
            $customer_mode = $data['customerMode'];
            $customer_mode_details = CustomerMode::where('is_permanant', (int) $customer_mode)->first();
            if ($customer_type == 0) {
                $data["fullName"] = ucwords(strtolower($data['firstName'] . " " . $data['middleName'] . " " . $data['lastName']));
            } else {
                $data["firstName"] = ucwords(strtolower($data["corFirstName"]));
                $data["fullName"] = ucwords(strtolower($data['corFirstName']));
            }
            $data["customerCodeValue"] = strtolower($request->input('customerCode'));
            $data["customerType"] = new ObjectID($customer_type_details->_id);
            $data["customerMode"] = new ObjectID($customer_mode_details->_id);
            $data["status"] = 1;
            if ($request->input('mainGroup')) {
                $maingroup_object = new \stdClass();
                $id_maingroup = $request->input('mainGroup');
                if ($id_maingroup == 0) {
                    $id_maingroup = (string) $id_maingroup;
                    $name_maingrop = (string) 'Nil';
                } else {
                    $id_maingroup = new ObjectID($id_maingroup);
                    $main_group = Customer::find($id_maingroup);
                    $name_maingrop = ucfirst($main_group->firstName);
                }
                $maingroup_object->id = $id_maingroup;
                $maingroup_object->name = $name_maingrop;
                $data["mainGroup"] = $maingroup_object;
            }
            if ($request->input('customerLevel')) {
                $customerlevel_object = new \stdClass();
                $id_customerlevel = $request->input('customerLevel');
                $customer_level = CustomerLevel::find($id_customerlevel);
                $name_customer_level = $customer_level->name;
                $customerlevel_object->id = new ObjectID($id_customerlevel);
                $customerlevel_object->name = $name_customer_level;
                $data["customerLevel"] = $customerlevel_object;
            }
            if ($request->input('agent')) {
                $agent_object = new \stdClass();
                $id_agent = $request->input('agent');
                $agent = User::find($id_agent);
                $name_agent = $agent->name;
                $agent_object->id = new ObjectID($id_agent);
                $agent_object->name = $name_agent;
                $data["agent"] = $agent_object;


                //updating.....related collections.....

                Emails::where('assaignedTo.customerId', new ObjectId($request->input('customer_id')))
                ->update(
                    [
                    'assaignedTo.customerAgentId' => @$id_agent,
                    'assaignedTo.customerAgentName' => $name_agent,
                    'assaignedTo.customerName' => $data['fullName']
                    ]
                ); // updation in fetched emails collection
                Enquiries::where('assaignedTo.customerId', new ObjectId($request->input('customer_id')))
                ->update(
                    [
                    'assaignedTo.customerAgentId' => @$id_agent,
                    'assaignedTo.customerAgentName' => $name_agent,
                    'assaignedTo.customerName' => $data['fullName']
                    ]
                ); // updation in fetched emails collection

                LeadDetails::where('customer.id', new ObjectId($request->input('customer_id')))
                ->update(
                    [
                    'customer.name' =>$data['fullName'],
                    'customer.customerCode' =>strtolower($request->input('customerCode')),
                    'id' =>new ObjectId($id_agent),
                    'agent.name' =>$name_agent,
                    'agent.empid' =>$agent->empID?:''
                    ]
                ); // updation in fetched emails collection
                // CustomerDocuments::where('customerId', $request->input('customer_id'))
                //     ->update(['customerName'=>$data['fullName']]); // updation in CustomerDocuments collection
                $changeAgent = new \stdClass();
                $changeAgent->id = $id_agent;
                $changeAgent->name = $name_agent;
                SharedDocuments::where('customerId', $request->input('customer_id'))
                ->update(
                    [
                        'customerName' => $data['fullName'],
                        'agentDetails' => $changeAgent
                    ]
                );
                //updating.....related collections.....end.......

            }
            $deartment_name = $request->input('department');
            $deartment_contact_person = $request->input('depContactPerson');
            $deartment_contact_person_email = $request->input('depContactEmail');
            $deartment_contact_person_mobile = $request->input('depContactMobile');
            $array_unique_count = count(array_unique($deartment_name));
            $array_actual_count = count($deartment_name);
            if ($array_actual_count != $array_unique_count) {
                return "department_exist";
            }

            // $customer=Customer::find($request->input('customer_id'));
            // $departmentid=[];
            // if (isset($customer['departmentDetails'])) {
            //     $departments=$customer['departmentDetails'];
            //     foreach ($departments as $department) {
            //         $departmentid[]=$department['department'];
            //     }
            // }

            $deprtment_array = [];
            foreach ($deartment_name as $key => $department) {
                if ($department) {
                    $department_object = new \stdClass();
                    $department_object->department = new ObjectID($department) ?: '';
                    if ($department != '') {
                        $department_name = Departments::find($department);
                        $department_object->departmentName = $department_name->name ?: '';
                        $department_object->depContactPerson = $deartment_contact_person[$key] ?: '';
                        $department_object->depContactEmail = $deartment_contact_person_email[$key] ?: '';
                        $department_object->depContactMobile = $deartment_contact_person_mobile[$key] ?: '';
                    } else {
                        $department_object->departmentName = '';
                        $department_object->depContactPerson = $deartment_contact_person[$key] ?: '';
                        $department_object->depContactEmail = $deartment_contact_person_email[$key] ?: '';
                        $department_object->depContactMobile = $deartment_contact_person_mobile[$key] ?: '';
                    }
                    $deprtment_array[] = $department_object;
                }
            }
            $data["departmentDetails"] = $deprtment_array;
            // $data["passCode"] = $request->input('passCode');

            DB::collection('customers')->where('_id', new ObjectID($request->input('customer_id')))
                ->update($data);
            $customer_details = Customer::find($request->input('customer_id'));
            $customer_det = new \stdClass();
            $customer_det->id = new ObjectID($customer_details->_id);
            if ($customer_details->getType->name == 'Corporate') {
                $customer_det->name = $customer_details->fullName;
                $customer_det->salutation = '';
                $customer_det->first_name = '';
                $customer_det->middle_name = '';
                $customer_det->last_name = '';
            } else {
                $customer_det->name = '';
                $customer_det->salutation = $customer_details->salutation;
                $customer_det->firstName = $customer_details->firstName;
                $customer_det->middleName = $customer_details->middleName;
                $customer_det->lastName =  $customer_details->lastName;
            }
            $customer_det->name = $customer_details->fullName;
            $customer_det->type = $customer_details->getType->name;
            $customer_det->customerCode = $customer_details->customerCode;
            if (@$customer_details['mainGroup']['id'] == '0') {
                $customer_det->maingroupCode = 'Nil';
            } else {
                $customer_det->maingroupCode = @$customer_details->getMainGroup->customerCode;
            }
            if (@$customer_details['mainGroup']['id'] != "0") {
                if ($customer_details['mainGroup']['id']) {
                    $customer_det->maingroupId = new ObjectID(@$customer_details['mainGroup']['id']);
                    $customer_det->maingroupName = @$customer_details['mainGroup']['name'];
                } else {
                    $customer_det->maingroupId = "0";
                    $customer_det->maingroupName = "Nil";
                }
            } else {
                $customer_det->maingroupId = "0";
                $customer_det->maingroupName = "Nil";
            }

            PipelineItems::where('customer.id', new ObjectID($request->input('customer_id')))->update(['customer' => $customer_det]);

            Session::flash('status', 'Customer details updated successfully.');
            return "success";
        } else {
            if ($request->input('customerCode')) {
                $customer_code = $request->input('customerCode');
                $customerWithCode = Customer::where('customerCode', $customer_code)->where('status', 1)->first();
                if ($customerWithCode) {
                    return 'code_exist';
                }
            }
            //            try {
            //                $count = Counter::where('_id','customer')->first();
            $data = $request->except(['_token', 'depContactMobile', 'depContactPerson', 'department', 'depContactEmail']);
            $customer_type = $data['customerType'];
            $customer_type_details = CustomerType::where('is_corporate', (int) $customer_type)->first();
            $customer_mode = $data['customerMode'];
            $customer_mode_details = CustomerMode::where('is_permanant', (int) $customer_mode)->first();
            //                $current_customer_id = $count->sequence_value;
            //                $next_order_no = $current_customer_id+1;
            //                $formatted_reg_no =  sprintf('%05d', $next_order_no);
            if ($customer_type == 0) {
                $data["fullName"] = ucwords(strtolower($data['firstName'] . " " . $data['middleName'] . " " . $data['lastName']));
                //                    $data["customerCode"] = "IIB_CI-".$formatted_reg_no;
            } else {
                $data["firstName"] = ucwords(strtolower($data["corFirstName"]));
                $data["fullName"] = ucwords(strtolower($data['corFirstName']));
                //                    $data["customerCode"] = "IIB_CC-".$formatted_reg_no;
                $data["salutation"] = '';
                $data["middleName"] = '';
                $data["lastName"] = '';
            }
            $data["customerType"] = new ObjectID($customer_type_details->_id);
            $data["customerMode"] = new ObjectID($customer_mode_details->_id);
            $data["status"] = 1;
            $maingroup_object = new \stdClass();
            $id_maingroup = $request->input('mainGroup');
            if ($id_maingroup == 0) {
                $id_maingroup = (string) $id_maingroup;
                $name_maingrop = (string) 'Nil';
            } else {
                $id_maingroup = new ObjectID($id_maingroup);
                $main_group = Customer::find($id_maingroup);
                $name_maingrop = ucfirst($main_group->firstName);
            }

            $maingroup_object->id = $id_maingroup;
            $maingroup_object->name = $name_maingrop;
            $data["mainGroup"] = $maingroup_object;
            if ($request->input('customerLevel')) {
                $customerlevel_object = new \stdClass();
                $id_customerlevel = $request->input('customerLevel');
                $customer_level = CustomerLevel::find($id_customerlevel);
                $name_customer_level = $customer_level->name;
                $customerlevel_object->id = new ObjectID($id_customerlevel);
                $customerlevel_object->name = $name_customer_level;
                $data["customerLevel"] = $customerlevel_object;
            }

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
            if (!empty($deartment_name)) {
                foreach ($deartment_name as $key => $department) {
                    if ($department != '') {
                        $department_object = new \stdClass();
                        $department_object->department = new ObjectID($department);
                        $department_name = Departments::find($department);
                        $department_object->departmentName = $department_name->name;
                        $department_object->depContactPerson = $deartment_contact_person[$key];
                        $department_object->depContactEmail = $deartment_contact_person_email[$key];
                        $department_object->depContactMobile = $deartment_contact_person_mobile[$key];
                        $deprtment_array[] = $department_object;
                    }
                }
            }
            if ($request->input('agent')) {
                $id_agent = $request->input('agent');
                $agent = User::find($id_agent);
                $agent_object = new \stdClass();
                $name_agent = $agent->name;
                $agent_object->id = new ObjectID($id_agent);
                $agent_object->name = $name_agent;
                $data["agent"] = $agent_object;
            }

            $data["customerCodeValue"] = strtolower($request->input('customerCode'));
            //                $country=Country::find($request->input('country'));
            //                $data["countryName"] = $country->name;
            //                $city=City::find($request->input('city'));
            //                $data["cityName"] = $city->name;
            $created_by = Auth::user()->name;
            $data["created_by"] = $created_by;
            $data["departmentDetails"] = $deprtment_array;
            Customer::create($data);
            //                $count->sequence_value=$next_order_no;
            //                $count->save();
            Session::flash('status', 'Customer added successfully.');
            return "success";

            //            } catch (\Exception $e) {
            //                return back()->withInput()->with('status', 'Customer added successfully');
            //            }
        }
    }

    /**
     * view customer page
     */
    public function show($customer_id)
    {
        $customer = Customer::find($customer_id);
        $agent = User::find($customer['agent.id']);
        $agentId = $agent['empID'];
        if (isset($agentId) && $agentId != '') {
            $agentId = $agent['name'] . '( ' . $agentId . ')';
        } else {
            $agentId = $agent['name'];
        }
        if ($customer) {
            return view('customers.customer_details')->with(compact('customer', 'agentId'));
        } else {
            return view('error');
        }
    }

    /**
     * edit customer page
     */
    public function edit($customer)
    {
        $mainGroups = Customer::where('mainGroup.id', (string) 0)->get();
        $customerDetails = Customer::find($customer);
        $customerLevels = CustomerLevel::get();
        $agents = User::where('isActive', 1)->where('role', 'AG')->get();
        $customerTypes = CustomerType::get();
        $customerMode = CustomerMode::get();
        $departments = Departments::get();
        $all_countries = CountryListModel::get();
        $countries = [];
        foreach ($all_countries as $key => $country) {
            $name = $country['country'];
            $countries[] = $name['countryName'];
        }
        if ($customerDetails) {
            return view('customers.create')
                ->with(compact('mainGroups', 'customerLevels', 'customerTypes', 'agents', 'customerMode', 'countries', 'customerDetails', 'departments'));
        } else {
            return view('error');
        }
    }

    /**
     * delete customer page
     */
    public function destroy($customer)
    {
        $customer_det = Customer::find($customer);
        if ($customer_det) {
            $customer_det->status = 0;
            $customer_det->save();
            Emails::where('assaignedTo.customerId', new ObjectId($customer))->where('mailStatus', 1)
                ->update(['assaignedTo.customerId' => "", 'assaignedTo.customerName' => ""]);
            Enquiries::where('assaignedTo.customerId', new ObjectId($customer))->where('mailStatus', 1)
                ->update(['assaignedTo.customerId' => "", 'assaignedTo.customerName' => ""]);
            $pipline_details = PipelineItems::where('customer.id', new ObjectID($customer))->get();
            if (count($pipline_details) != 0) {
                $status = array(
                    'pipelineStatus' => 'false'
                );
                DB::collection('pipelineItems')->where('customer.id', new ObjectId($customer))->update($status);
            }
            Session::flash('status', 'Customer deleted successfully.');
            return "success";
        }
    }

    /**
     * view customer list datatable
     */
    public function dataTable(Request $request)
    {
        DB::enableQueryLog();
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $filter = $request->input('search');
        $filter_data_en = $request->input('filterData');
        $filterData = json_decode($filter_data_en);
        $sort = $request->input('field');
        $customerMode = $request->input('customerMode');
        $customerModeIDs =    CustomerMode::pluck('_id');
        //        $searchField = (isset($filter_data['search']))? $filter_data['search'] :"";
        $search = (isset($filter['value'])) ? $filter['value'] : false;
        session()->put('filter', $filter_data_en);
        session()->put('sort', $sort);
        $customers = Customer::where('status', 1);
        if (isset($customerMode)) {
            if ($customerMode == 1) {
                $customers->where('customerMode', '!=', new ObjectID($customerModeIDs[1]));
            } else {
                $customers->where('customerMode', new ObjectID($customerModeIDs[1]));
            }
        }
        if (session('role') == 'Agent') {
            $customers = $customers->where(
                function ($q) {
                    $q->where('agent.id', new ObjectID(Auth::user()->_id));
                }
            );
        }
        if (session('role') == 'Coordinator') {
            $customers = $customers->where(
                function ($q) {
                    $q->where('agent.id', session('assigned_agent'));
                }
            );
        }
        if (!empty($filterData)) {
            if (!empty($filterData->agent)) {
                $val_array = [];
                foreach ($filterData->agent as $val) {
                    if ($val == "Nil") {
                        $val_array[] = (string) 0;
                    }
                    if ($val != '0' && $val != 'Nil') {
                        $val_array[] = new ObjectID($val);
                    }
                }
                $customers = $customers->whereIn('agent.id', $val_array);
            }
            if (!empty($filterData->main_group)) {
                $val_array = [];
                foreach ($filterData->main_group as $val) {
                    if ($val == "Nil") {
                        $val_array[] = (string) 0;
                    }
                    if ($val != '0' && $val != 'Nil') {
                        $val_array[] = new ObjectID($val);
                    }
                }
                $customers = $customers->whereIn('mainGroup.id', $val_array);
            }

            if (!empty($filterData->level)) {
                $val_array = [];
                foreach ($filterData->level as $val) {
                    if ($val == "Nil") {
                        $val_array[] = (string) 0;
                    }
                    if ($val != '0' && $val != 'Nil') {
                        $val_array[] = new ObjectID($val);
                    }
                }
                $customers = $customers->whereIn('customerLevel.id', $val_array);
            }
        }


        if (!empty($sort)) {
            if ($sort == "Name") {
                $customers = $customers->orderBy('fullName');
            } elseif ($sort == "Customer Code") {
                $customers = $customers->orderBy('customerCodeValue');
            } elseif ($sort == "Agent") {
                $customers = $customers->orderBy('agent.name');
            } elseif ($sort == "Main Group") {
                $customers = $customers->orderBy('mainGroup.name');
            }
        } elseif (empty($sort)) {
            $customers = $customers->orderBy('createdAt', 'DESC');
        }

        if ($search) {
            $customers = $customers->where(
                function ($query) use ($search) {
                    $query->where('customerCode', 'like', '%' . $search . '%')
                        ->orWhere('fullName', 'like', '%' . $search . '%')
                        ->orWhere('contactNumber', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%')
                        ->orWhere('agent.name', 'like', '%' . $search . '%')
                        ->orWhere('mainGroup.name', 'like', '%' . $search . '%')
                        ->orWhere('customerLevel.name', 'like', '%' . $search . '%');
                }
            );
            session()->put('search', $search);
        }
        if ($search == "") {
            $customers = $customers;
            session()->put('search', "");
        }

        $searchField = $request->get('searchField');
        if ($searchField != "") {
            $customers = $customers->where(
                function ($query) use ($searchField) {
                    $query->where('customerCode', 'like', '%' . $searchField . '%')
                        ->orWhere('fullName', 'like', '%' . $searchField . '%')
                        ->orWhere('contactNumber', 'like', '%' . $searchField . '%')
                        ->orWhere('email', 'like', '%' . $searchField . '%')
                        ->orWhere('agent.name', 'like', '%' . $searchField . '%')
                        ->orWhere('mainGroup.name', 'like', '%' . $searchField . '%')
                        ->orWhere('customerLevel.name', 'like', '%' . $searchField . '%');
                }
            );
        }



        $total_customers = $customers->count(); // get your total no of data;
        $members_query = $customers;
        $search_count = $members_query->count();
        $customers->skip((int) $start)->take((int) $length);
        $final_customers = $customers->get();


        foreach ($final_customers as $customer) {
            if (session('role') == 'Admin') {
                $action1 = '<button type="button"class="btn export_btn waves-effect auto_modal delete_icon_btn" data-toggle="tooltip" data-placement="bottom" title="Delete" data-container="body"  data-modal="delete_popup" dir="' . $customer->_id . '" onclick="delete_pop(\'' . $customer->_id . '\');">

                                            <i class="material-icons">delete_outline</i>
                                        </button>
            ';
            } else {
                $action1 = '';
            }
            $action2 = '<a href="' . URL::to('customers-show/' . $customer->_id) . '" class="btn btn-sm btn-success" style="font-weight: 600">View Details</a>';
            $mainGroup = $customer['mainGroup.id'] != "0" ? $customer['mainGroup.name'] : 'Nil';
            $level = $customer['customerLevel.name'];
            if ($customer['agent.id']) {
                $agentUser = User::find($customer['agent.id']);
                $agent = ucwords(strtolower($customer['agent.name']));
                $agentId = $agentUser->empID;
                if (isset($agentId) && $agentId != '') {
                    $agentName =    $agent . ' (' . $agentId . ')';
                } else {
                    $agentName = $agent;
                }
            }
            if (is_array($customer->email)) {
                $email = $customer->email['0']?: '--';
            } else {
                $email = $customer->email ?: '--';
            }

            if (is_array($customer->contactNumber)) {
                $contact = $customer->contactNumber['0']?: '--';
            } else {
                $contact = $customer->contactNumber ?: '--';
            }

            if (!empty($customer->salutation)) {
                $name = '<a href="' . URL::to('customers-show/' . $customer->_id) . '" class="p">' . $customer->salutation . $customer->fullName . '</a>';
            } else {
                $name = '<a href="' . URL::to('customers-show/' . $customer->_id) . '" class="p">' . $customer->fullName . '</a>';
            }
            //            if($customer->department)
            //            {
            //                $dpt_name=$customer->getDepartment->name;
            //            }
            //            else{
            //                $dpt_name='';
            //            }
            if (isset($customer['departmentDetails'])) {
                $policyDetails = $customer['policyDetails'];
                $policy = count($policyDetails);
            } else {
                $policy = 0;
            }
            $customer->Code = $customer->customerCode ?: '--';
            $customer->fullName = $name ?: '--';
            $customer->contactNumber = $contact;
            $customer->email = $email;
            $customer->mainGroup = $mainGroup ?: '--';
            $customer->agent = @$agentName ?: '--';
            $customer->level = @$level ?: '--';
            $customer->policies = @$policy;
            //            $customer->department = $dpt_name;
            $customer->action1 = $action1;
            $customer->action2 = $action2;
        }
        if ($search) {
            $filtered_count = $search_count;
        } else {
            $filtered_count = $total_customers;
        }


        $data = array(
            'draw' => $draw,
            'recordsTotal' => $total_customers,
            'recordsFiltered' => $filtered_count,
            'data' => $final_customers,
        );

        return json_encode($data);
    }



    /**
     * get customer details
     */
    public function getCustomers(Request $request)
    {
        $customers = Customer::where('status', (int) 1);
        if (!empty($request->input('q'))) {
            $customers = $customers->where(
                function ($q) use ($request) {
                    $q->where('customerCode', 'like', $request->input('q') . '%')->orWhere(
                        'fullName',
                        'like',
                        $request->input('q') . '%'
                    );
                }
            );
        }
        if (session('role') == 'Agent') {
            $customers = $customers->where(
                function ($q) {
                    $q->where('agent.id', new ObjectID(Auth::user()->_id));
                }
            );
        }
        if (session('role') == 'Coordinator') {
            $customers = $customers->where(
                function ($q) {
                    $q->where('agent.id', session('assigned_agent'));
                }
            );
        }
        $customers = $customers->orderBy('fullName')->take(10)->get();
        if (count($customers)  == 0) {
            $customers = Customer::where('status', (int) 1);
            $customers = $customers->where(
                function ($q) use ($request) {
                    $q->where('customerCode', 'like', '%' . $request->input('q') . '%')->orWhere(
                        'fullName',
                        'like',
                        '%' . $request->input('q') . '%'
                    );
                }
            );
            if (session('role') == 'Agent') {
                $customers = $customers->where(
                    function ($q) {
                        $q->where('agent.id', new ObjectID(Auth::user()->_id));
                    }
                );
            }
            if (session('role') == 'Coordinator') {
                $customers = $customers->where(
                    function ($q) {
                        $q->where('agent.id', session('assigned_agent'));
                    }
                );
            }
            $customers = $customers->orderBy('fullName')->take(10)->get();
        }
        foreach ($customers as $customer) {
            $customer->text = $customer->customerCode;
            $customer->name = $customer->fullName;
            $customer->id = $customer->_id;
        }
        $data = array(
            'total_count' => count($customers),
            'incomplete_results' => false,
            'items' => $customers,
        );
        return json_encode($data);
    }

    /**
     * get customer details
     */
    public function getRecipientsList(Request $request)
    {
        $customers = RecipientDetails::where('status', (int) 1);
        if (!empty($request->input('q'))) {
            $customers = $customers->Where('fullName', 'like', $request->input('q') . '%');
        }
        // if (session('role') == 'Agent') {
        //     $customers = $customers->where(function ($q) {
        //         $q->where('agent.id', new ObjectID(Auth::user()->_id));
        //     });
        // }
        // if (session('role') == 'Coordinator') {
        //     $customers = $customers->where(function ($q) {
        //         $q->where('agent.id', session('assigned_agent'));
        //     });
        // }
        $customers = $customers->orderBy('fullName')->take(10)->get();
        if (count($customers) == 0) {
            $customers = RecipientDetails::where('status', (int) 1);
            $customers = $customers->Where('fullName', 'like', '%' . $request->input('q') . '%');
            // if (session('role') == 'Agent') {
            //     $customers = $customers->where(function ($q) {
            //         $q->where('agent.id', new ObjectID(Auth::user()->_id));
            //     });
            // }
            // if (session('role') == 'Coordinator') {
            //     $customers = $customers->where(function ($q) {
            //         $q->where('agent.id', session('assigned_agent'));
            //     });
            // }
            $customers = $customers->orderBy('fullName')->take(10)->get();
        }
        foreach ($customers as $customer) {
            $customer->text = $customer->fullName;
            $customer->id = $customer->_id;
        }
        $data = array(
            'total_count' => count($customers),
            'incomplete_results' => false,
            'items' => $customers,
        );
        return json_encode($data);
    }

    /**
     * insert country
     */
    public function insertCountry()
    {
        $all_countries = AllCountries::first();
        $count = 0;
        foreach ($all_countries->Countries as $key => $country) {
            $country1 = new CountryListModel();
            $countryObject = new \stdClass();
            $countryObject->countryName = $country['CountryName'];
            $countryObject->states = $country['States'];
            $country1->country = $countryObject;
            $country1->save();
            $count++;
        }
        return $count;
    }

    /**
     * get countries name
     */
    public function getCountriesName(Request $request)
    {
        $searchData = $request->input('searchData');
        if (!empty($searchData)) {
            $employees = CountryListModel::where(
                function ($q) use ($searchData) {
                    $q->where('country.countryName', 'like', $searchData . '%');
                }
            );
            if (count($employees) == 0) {
                $employees = CountryListModel::where(
                    function ($q) use ($searchData) {
                        $q->where('country.countryName', 'like', '%' . $searchData . '%');
                    }
                );
            }
            $employees = $employees->take(10)->get();
        } else {
            $employees = CountryListModel::orderBy('name')->get();
        }

        $response[] = "<option value=''>Select Country</option>";
        foreach ($employees as $key => $country) {
            $name = $country['country'];
            $countries = $name['countryName'];
            $response[] = "<option value='$countries'>$countries</option>";
        }
        return response()->json(['success' => true, 'response_country' => $response]);
    }


    /**
     * change agent name in customer page
     */
    public function changeAgent()
    {
        $customers = Customer::where('status', (int) 1)->where('agent.name', 'like', ' direct%')->get();
        $cunt = 0;
        foreach ($customers as $customer) {
            Customer::where(
                '_id',
                new ObjectId($customer->_id)
            )->update(array('agent.name' => 'Direct', 'agent.id' => new ObjectID('5c30bc1eb8ace01d08691f32')));
            $cunt++;
        }
        echo $cunt;
    }
}
