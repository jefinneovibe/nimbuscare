<?php

namespace App\Http\Controllers;

use App\Agent;
use App\CaseManager;
use App\CountryListModel;
use App\Customer;
use App\Departments;
use App\ImportExcel;
use App\Insurer;
use App\Jobs\EslipSubmittedReminder;
use App\Jobs\IssuanceProposal;
use App\LeavesDetails;
use App\PipelineItems;
use App\PipelineStatus;
use App\State;
use App\User;
use App\WorkType;
use App\WorkTypeData;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Maatwebsite\Excel\Facades\Excel;
use MongoDB\BSON\ObjectID;

class PipelineController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.underwriter', ['except' => ['getStates', 'equestionnaireSave', 'questionnaireFileupload', 'uploadToCloud']]);
    }

    /**
     * view all pipelines
     */
    public function index(Request $request)
    {
        $filter_data = $request->input();
        $mainGroups = $request->input('main_group_id');
        //Just to fix sidebar issue
        //comment/remove below two session related lines if anthing bad happens
        $request->session()->forget('dispatch');
        session(['dispatch' => 'Underwriter']);

        //$mainGroups = Customer::where('mainGroup.id', '0')->get();
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
                    $objectArray[$count] = (string) 0;
                }
                if ($cust != '0' && $cust != 'Nil') {
                    $objectArray[$count] = new ObjectId($cust);
                }
                $count++;
            }
            $mainGroupCodes = Customer::whereIn('_id', $objectArray)->get();
        } else {
            $mainGroupCodes = '';
        }
        return view('pipelines.pipeline')->with(compact('workTypes', 'mainGroups', 'agents', 'caseManagers', 'filter_data', 'status', 'customers', 'departments', 'mainGroupCodes'));
    }

    /**
     * view e qustionnaire
     */
    public function eQuestionnaire($eQuestionnaireid)
    {
        $PipelineItems = PipelineItems::find($eQuestionnaireid);
        if ($PipelineItems->pipelineStatus != "true") {
            return view('error');
        }
        $country_name = [];
        $country_name_place = [];
        $all_emirates = State::all();
        //
        //        if(($PipelineItems['formData']) && (isset($PipelineItems['formData']['addressDetails']['country']))){
        //            $country=$PipelineItems['formData']['addressDetails']['country'];
        //            $all_countries=CountryListModel::where('country.countryName',$country)->first();
        //            $name=$all_countries['country'];
        //            $country_name[]=$name['countryName'];
        //        }else if(empty($PipelineItems['formData']) && !empty($PipelineItems->getCustomer->countryName))
        //        {
        //            $country=$PipelineItems->getCustomer->countryName;
        //            $all_countries=CountryListModel::where('country.countryName',$country)->first();
        //            $name=$all_countries['country'];
        //            $country_name[]=$name['countryName'];
        //        }
        //        else {
        $all_countries = CountryListModel::get();
        foreach ($all_countries as $key => $country) {
            $name = $country['country'];
            $country_name[] = $name['countryName'];
        }
        //            dd($country_name);
        //        }
        //        if(($PipelineItems['formData']) && (isset($PipelineItems['formData']['placeOfEmployment'])) && (!empty($PipelineItems['formData']['placeOfEmployment']['countryName']))){
        //            $country1=$PipelineItems['formData']['placeOfEmployment']['countryName'];
        //            $all_countriesPlace=CountryListModel::where('country.countryName',$country1)->first();
        //            $namePlace=$all_countriesPlace['country'];
        //            $country_name_place[]=$namePlace['countryName'];
        //        }
        //        else {
        //            $all_countriesPlace=CountryListModel::take(10)->get();
        //            foreach ($all_countriesPlace as $key=>$country)
        //            {
        //                $namePlace=$country['country'];
        //                $country_name_place[]=$namePlace['countryName'];
        //            }
        //        }
        $form_data = $PipelineItems['formData'];
        $all_insurers = Insurer::where('isActive', 1)->orderBy('name')->get();
        $file_name = [];
        $file_url = [];
        $files = $PipelineItems['files'];
        if (isset($PipelineItems['files'])) {
            foreach ($files as $file) {
                $file_name[] = $file['file_name'];
                $file_url[] = $file['url'];
            }
        } else {
            $file_name[] = '';
            $file_url[] = '';
        }
        $customer_details = Customer::find($PipelineItems['customer']['id']);
        if ($PipelineItems) {
            return view('pipelines.workmans_compensation.e_questionnaire')->with(compact('country_name_place', 'country_name', 'all_emirates', 'eQuestionnaireid', 'form_data', 'PipelineItems', 'customer_details', 'all_insurers', 'file_name', 'file_url'));
        } else {
            return view('error');
        }
    }

    /**
     * get states
     */
    public function getStates(Request $request)
    {
        $country_name = $request->input('country_name');
        $id = $request->input('pipeline_id');
        $customer = PipelineItems::find($id);
        if ($customer['formData']) {
            if ($customer['formData']['addressDetails']['country'] != $country_name) {
                $city_name = '';
            } elseif ($customer['formData']['addressDetails']['country'] == $country_name) {
                $city_name = $customer['formData']['addressDetails']['state'];
            }
        } else {
            if ($customer->getCustomer->countryName != $country_name) {
                $city_name = '';
            } elseif ($customer->getCustomer->countryName == $country_name) {
                $city_name = $customer->getCustomer->cityName;
            }
        }

        if ($country_name) {
            $all_countries = CountryListModel::where('country.countryName', $country_name)->first();
            $state_name = [];
            foreach ($all_countries['country']['states'] as $key => $states) {
                $state_name[] = $states['StateName'];
            }
            $response = '<option value=""  selected>Select State</option>';
            foreach ($state_name as $state) {
                $response .= '<option value="' . $state . '"';
                if ($city_name == $state) {
                    $response .= ' selected ';
                }
                $response .= '>' . $state . '</option>';
            }
            echo $response;
        } else {
            $response = '<option value=""  selected>Select State</option>';
            echo $response;
        }
    }

    /**
     * view e slip
     */
    public function eSlip($worktype_id)
    {
        $pipeline_details = PipelineItems::find($worktype_id);
        if ($pipeline_details['status']['status'] == 'Worktype Created' || $pipeline_details['status']['status'] == 'E-questionnaire') {
            return view('error');
        }
        if ($pipeline_details->pipelineStatus != "true") {
            return view('error');
        }
        if ($pipeline_details) {
            return view('pipelines.workmans_compensation.e_slip')->with(compact('worktype_id', 'pipeline_details'));
        } else {
            return view('error');
        }
    }

    public function eQuotation()
    {
        return view('pipelines.workmans_compensation.e_quotation');
    }

    /**
     * view e quote list
     */
    public function eQuoteList($pipeline_id)
    {
        return view('pipelines.workmans_compensation.e_quote_list')->with(compact('pipeline_id'));
    }

    public function eQuoteDetails()
    {
        return view('pipelines.workmans_compensation.e_quote_details');
    }

    /**
     * view approved quote
     */
    public function approvedEquot($pipelineId)
    {
        $pipeline_details = PipelineItems::find($pipelineId);
        if ($pipeline_details['status']['status'] == 'Worktype Created' || $pipeline_details['status']['status'] == 'E-questionnaire' || $pipeline_details['status']['status'] == 'E-slip' || $pipeline_details['status']['status'] == 'E-quotation' || $pipeline_details['status']['status'] == 'Quote Amendment' || $pipeline_details['status']['status'] == 'E-comparison') {
            return view('error');
        }
        if ($pipeline_details->pipelineStatus != "true") {
            return view('error');
        }
        if ($pipeline_details) {
            $insurerReplay = $pipeline_details['insurerReplay'];
            foreach ($insurerReplay as $insures_rep) {
                if (isset($insures_rep['customerDecision'])) {
                    if ($insures_rep['quoteStatus'] == 'active' && $insures_rep['customerDecision']['decision'] == 'Approved') {
                        $insures_details = $insures_rep;
                        break;
                    }
                }
            }
            return view('pipelines.workmans_compensation.approved_quot')->with(compact('pipelineId', 'pipeline_details', 'insures_details'));
        }
    }

    /**
     * view quote ammndement
     */
    public function quoteAmendment($pipeline_id)
    {
        $insures_details = [];
        $pipeline_details = PipelineItems::find($pipeline_id);
        if ($pipeline_details['status']['status'] == 'Worktype Created' || $pipeline_details['status']['status'] == 'E-questionnaire' || $pipeline_details['status']['status'] == 'E-slip' || $pipeline_details['status']['status'] == 'E-quotation' || $pipeline_details['status']['status'] == 'E-comparison') {
            return view('error');
        }
        if ($pipeline_details->pipelineStatus != "true") {
            return view('error');
        }
        if ($pipeline_details) {
            $insurerReplay = $pipeline_details['insurerReplay'];
            foreach ($insurerReplay as $insures_rep) {
                if ($insures_rep['quoteStatus'] == 'active') {
                    $insures_details[] = $insures_rep;
                }
            }
            $alreadySelected = $pipeline_details->selected_insurers;
            foreach ($alreadySelected as $selected) {
                if ($selected['active_insurer'] == 'active') {
                    $selectedId[] = $selected['insurer'];
                }
            }
            return view('pipelines.workmans_compensation.quote_amendment')->with(compact('pipeline_details', 'insures_details', 'selectedId'));
        } else {
            return view('error');
        }
    }

    /**
     * Function for fill the data table
     */
    public function dataTable(Request $request)
    {
        //    dd($request);
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $filter = $request->input('search');
        $sort = $request->input('field');
        $jsonFilter = $request->input('filterData');
        //     dd($jsonFilter);
        session()->put('filter', $jsonFilter);
        session()->put('sort', $sort);
        $filterData = json_decode($jsonFilter);

        //     var_dump($filterData);
        /**
         * Conditions for Filtering
*/
        if ($filterData) {
            $pipeData = WorkTypeData::where('pipelineStatus', "true");
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
            //        foreach ($filterData as $key => $value)
            //        {
            //            if($key=='customer.maingroupCode')
            //            {
            //                $val_array=[];
            //                foreach ($value as $val)
            //                {
            //                    if($val=='Nil')
            //                    {
            //                        $val_array[]=$val;
            //                    }
            //                    if($val!='0' && $val!='Nil'){
            //                        $customerDet=Customer::find($val);
            //                        $val_array[]=$customerDet->customerCode;
            //                    }
            //                }
            //            }
            //            else if($key=='workTypeId.department')
            //            {
            //                $val_array=[];
            //                foreach ($value as $val)
            //                {
            //                    if($val!='0'){
            //                        $departmentDet=Departments::find($val);
            //                        $val_array[]=$departmentDet->name;
            //                    }
            //
            //                }
            //            }
            //            else if($key!='customer.maingroupCode'|| $key!='workTypeId.department') {
            //                $val_array = [];
            //                foreach ($value as $val) {
            //                    if ($val == "Nil") {
            //                        $val_array[] = (string)0;
            //                    }
            //                    if($val!='0' && $val!='Nil'){
            //                        $val_array[] = new ObjectID($val);
            //                    }
            //                }
            //            }
            //            if(count($val_array)>0) {
            //                $pipeData = $pipeData->whereIn($key, $val_array);
            //            }
            //        }
        } else {
            $pipeData = WorkTypeData::where('pipelineStatus', "true");
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
            // if ($item->workTypeId['name'] == "Workman's Compensation") {
            if ($item->status['status'] == "Worktype Created") {
                $referanceNumber = '<a href="' . URL::to('equestionnaire/' . $item->_id) . '" class="table_link">' . $item->refereneceNumber . '</a>';
            } elseif ($item->status['status'] == "E-questionnaire" || !isset($item['eQuestinareStatus'])) {
                $referanceNumber = '<a href="' . URL::to('equestionnaire/' . $item->_id) . '" class="table_link">' . $item->refereneceNumber . '</a>';
            } elseif ($item->status['status'] == "E-slip" || $item->status['status'] == "Quote Amendment-E-slip") {
                $referanceNumber = '<a href="' . URL::to('eslip/' . $item->_id) . '" class="table_link">' . $item->refereneceNumber . '</a>';
            } elseif ($item->status['status'] == "E-quotation" || $item->status['status'] == "Quote Amendment-E-quotation") {
                $referanceNumber = '<a href="' . URL::to('equotation/' . $item->_id) . '" class="table_link" >' . $item->refereneceNumber . '</a>';
            } elseif ($item->status['status'] == "E-comparison" || $item->status['status'] == "Quote Amendment-E-comparison") {
                $referanceNumber = '<a href="' . URL::to('ecomparison/' . $item->_id) . '" class="table_link" >' . $item->refereneceNumber . '</a>';
            } elseif ($item->status['status'] == "Approved E Quote") {
                $referanceNumber = '<a href="' . URL::to('approved-equote/' . $item->_id) . '" class="table_link" >' . $item->refereneceNumber . '</a>';
            } elseif ($item->status['status'] == "Quote Amendment") {
                $referanceNumber = '<a href="' . URL::to('quote-amendment/' . $item->_id) . '" class="table_link" >' . $item->refereneceNumber . '</a>';
            } elseif ($item->status['status'] == "Issuance") {
                $referanceNumber = '<a href="' . URL::to('issuance/' . $item->_id) . '" class="table_link" >' . $item->refereneceNumber . '</a>';
            } elseif ($item->status['status'] == "Lost Business") {
                $referanceNumber = '<a href="' . URL::to('view-policy-details/' . $item->_id) . '" class="table_link" >' . $item->refereneceNumber . '</a>';
            }
            // } elseif ($item->workTypeId['name'] == "Property") {
            //     if ($item->status['status'] == "Worktype Created") {
            //         $referanceNumber = '<a href="' . URL::to('property/e-questionnaire/' . $item->_id) . '" class="table_link">' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "E-questionnaire") {
            //         $referanceNumber = '<a href="' . URL::to('property/e-questionnaire/' . $item->_id) . '" class="table_link">' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "E-slip" || $item->status['status'] == "Quote Amendment-E-slip") {
            //         $referanceNumber = '<a href="' . URL::to('property/e-slip/' . $item->_id) . '" class="table_link">' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "E-quotation" || $item->status['status'] == "Quote Amendment-E-quotation") {
            //         $referanceNumber = '<a href="' . URL::to('property/e-quotation/' . $item->_id) . '" class="table_link">' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "E-comparison" || $item->status['status'] == "Quote Amendment-E-comparison") {
            //         $referanceNumber = '<a href="' . URL::to('property/e-comparison/' . $item->_id) . '" class="table_link">' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "Approved E Quote") {
            //         $referanceNumber = '<a href="' . URL::to('property/approved-quot/' . $item->_id) . '" class="table_link" >' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "Quote Amendment") {
            //         $referanceNumber = '<a href="' . URL::to('property/quot-amendment/' . $item->_id) . '" class="table_link" >' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "Issuance") {
            //         $referanceNumber = '<a href="' . URL::to('property/issuance/' . $item->_id) . '" class="table_link" >' . $item->refereneceNumber . '</a>';
            //     }
            // } elseif ($item->workTypeId['name'] == "Employers Liability") {
            //     if ($item->status['status'] == "Worktype Created") {
            //         $referanceNumber = '<a href="' . URL::to('employer/e-questionnaire/' . $item->_id) . '" class="table_link">' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "E-questionnaire") {
            //         $referanceNumber = '<a href="' . URL::to('employer/e-questionnaire/' . $item->_id) . '" class="table_link">' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "E-slip" || $item->status['status'] == "Quote Amendment-E-slip") {
            //         $referanceNumber = '<a href="' . URL::to('employer/e-slip/' . $item->_id) . '" class="table_link">' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "E-quotation" || $item->status['status'] == "Quote Amendment-E-quotation") {
            //         $referanceNumber = '<a href="' . URL::to('employer/e-quotation/' . $item->_id) . '" class="table_link" >' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "E-comparison" || $item->status['status'] == "Quote Amendment-E-comparison") {
            //         $referanceNumber = '<a href="' . URL::to('employer/e-comparison/' . $item->_id) . '" class="table_link" >' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "Approved E Quote") {
            //         $referanceNumber = '<a href="' . URL::to('employer/approved-quot/' . $item->_id) . '" class="table_link" >' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "Quote Amendment") {
            //         $referanceNumber = '<a href="' . URL::to('employer/quot-amendment/' . $item->_id) . '" class="table_link" >' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "Issuance") {
            //         $referanceNumber = '<a href="' . URL::to('employer/issuance/' . $item->_id) . '" class="table_link" >' . $item->refereneceNumber . '</a>';
            //     }
            // } elseif ($item->workTypeId['name'] == "Money") {
            //     if ($item->status['status'] == "Worktype Created") {
            //         $referanceNumber = '<a href="' . URL::to('money/e-questionnaire/' . $item->_id) . '" class="table_link">' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "E-questionnaire") {
            //         $referanceNumber = '<a href="' . URL::to('money/e-questionnaire/' . $item->_id) . '" class="table_link">' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "E-slip" || $item->status['status'] == "Quote Amendment-E-slip") {
            //         $referanceNumber = '<a href="' . URL::to('money/e-slip/' . $item->_id) . '" class="table_link">' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "E-quotation" || $item->status['status'] == "Quote Amendment-E-quotation") {
            //         $referanceNumber = '<a href="' . URL::to('money/e-quotation/' . $item->_id) . '" class="table_link">' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "E-comparison" || $item->status['status'] == "Quote Amendment-E-comparison") {
            //         $referanceNumber = '<a href="' . URL::to('money/e-comparison/' . $item->_id) . '" class="table_link">' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "Approved E Quote") {
            //         $referanceNumber = '<a href="' . URL::to('money/approved-quot/' . $item->_id) . '" class="table_link" >' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "Quote Amendment") {
            //         $referanceNumber = '<a href="' . URL::to('money/quot-amendment/' . $item->_id) . '" class="table_link" >' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "Issuance") {
            //         $referanceNumber = '<a href="' . URL::to('money/issuance/' . $item->_id) . '" class="table_link" >' . $item->refereneceNumber . '</a>';
            //     }
            // } elseif ($item->workTypeId['name'] == "Business Interruption") {
            //     if ($item->status['status'] == "Worktype Created") {
            //         $referanceNumber = '<a href="' . URL::to('business_interruption/e-questionnaire/' . $item->_id) . '" class="table_link">' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "E-questionnaire") {
            //         $referanceNumber = '<a href="' . URL::to('business_interruption/e-questionnaire/' . $item->_id) . '" class="table_link">' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "E-slip" || $item->status['status'] == "Quote Amendment-E-slip") {
            //         $referanceNumber = '<a href="' . URL::to('business_interruption/e-slip/' . $item->_id) . '" class="table_link">' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "E-quotation" || $item->status['status'] == "Quote Amendment-E-quotation") {
            //         $referanceNumber = '<a href="' . URL::to('business_interruption/e-quotation/' . $item->_id) . '" class="table_link">' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "E-comparison" || $item->status['status'] == "Quote Amendment-E-comparison") {
            //         $referanceNumber = '<a href="' . URL::to('business_interruption/e-comparison/' . $item->_id) . '" class="table_link">' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "Approved E Quote") {
            //         $referanceNumber = '<a href="' . URL::to('business_interruption/approved-quot/' . $item->_id) . '" class="table_link" >' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "Quote Amendment") {
            //         $referanceNumber = '<a href="' . URL::to('business_interruption/quot-amendment/' . $item->_id) . '" class="table_link" >' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "Issuance") {
            //         $referanceNumber = '<a href="' . URL::to('business_interruption/issuance/' . $item->_id) . '" class="table_link" >' . $item->refereneceNumber . '</a>';
            //     }
            // } elseif ($item->workTypeId['name'] == "Fire and Perils") {
            //     if ($item->status['status'] == "Worktype Created") {
            //         $referanceNumber = '<a href="' . URL::to('fireperils/e-questionnaire/' . $item->_id) . '" class="table_link">' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "E-questionnaire") {
            //         $referanceNumber = '<a href="' . URL::to('fireperils/e-questionnaire/' . $item->_id) . '" class="table_link">' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "E-slip" || $item->status['status'] == "Quote Amendment-E-slip") {
            //         $referanceNumber = '<a href="' . URL::to('fireperils/e-slip/' . $item->_id) . '" class="table_link">' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "E-quotation" || $item->status['status'] == "Quote Amendment-E-quotation") {
            //         $referanceNumber = '<a href="' . URL::to('fireperils/e-quotation/' . $item->_id) . '" class="table_link">' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "E-comparison" || $item->status['status'] == "Quote Amendment-E-comparison") {
            //         $referanceNumber = '<a href="' . URL::to('fireperils/e-comparison/' . $item->_id) . '" class="table_link">' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "Approved E Quote") {
            //         $referanceNumber = '<a href="' . URL::to('fireperils/approved-quot/' . $item->_id) . '" class="table_link" >' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "Quote Amendment") {
            //         $referanceNumber = '<a href="' . URL::to('fireperils/quot-amendment/' . $item->_id) . '" class="table_link" >' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "Issuance") {
            //         $referanceNumber = '<a href="' . URL::to('fireperils/issuance/' . $item->_id) . '" class="table_link" >' . $item->refereneceNumber . '</a>';
            //     }
            // } elseif ($item->workTypeId['name'] == "Machinery Breakdown") {
            //     if ($item->status['status'] == "Worktype Created") {
            //         $referanceNumber = '<a href="' . URL::to('Machinery-Breakdown/e-questionnaire/' . $item->_id) . '" class="table_link">' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "E-questionnaire") {
            //         $referanceNumber = '<a href="' . URL::to('Machinery-Breakdown/e-questionnaire/' . $item->_id) . '" class="table_link">' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "E-slip" || $item->status['status'] == "Quote Amendment-E-slip") {
            //         $referanceNumber = '<a href="' . URL::to('Machinery-Breakdown/e-slip/' . $item->_id) . '" class="table_link">' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "E-quotation" || $item->status['status'] == "Quote Amendment-E-quotation") {
            //         $referanceNumber = '<a href="' . URL::to('Machinery-Breakdown/e-quotation/' . $item->_id) . '" class="table_link">' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "E-comparison" || $item->status['status'] == "Quote Amendment-E-comparison") {
            //         $referanceNumber = '<a href="' . URL::to('Machinery-Breakdown/e-comparison/' . $item->_id) . '" class="table_link">' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "Approved E Quote") {
            //         $referanceNumber = '<a href="' . URL::to('Machinery-Breakdown/approved-quot/' . $item->_id) . '" class="table_link" >' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "Quote Amendment") {
            //         $referanceNumber = '<a href="' . URL::to('Machinery-Breakdown/quot-amendment/' . $item->_id) . '" class="table_link" >' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "Issuance") {
            //         $referanceNumber = '<a href="' . URL::to('Machinery-Breakdown/issuance/' . $item->_id) . '" class="table_link" >' . $item->refereneceNumber . '</a>';
            //     }
            // } elseif ($item->workTypeId['name'] == "Contractor`s Plant and Machinery") {
            //     if ($item->status['status'] == "Worktype Created") {
            //         $referanceNumber = '<a href="' . URL::to('contractor-plant/e-questionnaire/' . $item->_id) . '" class="table_link">' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "E-questionnaire") {
            //         $referanceNumber = '<a href="' . URL::to('contractor-plant/e-questionnaire/' . $item->_id) . '" class="table_link">' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "E-slip" || $item->status['status'] == "Quote Amendment-E-slip") {
            //         $referanceNumber = '<a href="' . URL::to('contractor-plant/e-slip/' . $item->_id) . '" class="table_link">' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "E-quotation" || $item->status['status'] == "Quote Amendment-E-quotation") {
            //         $referanceNumber = '<a href="' . URL::to('contractor-plant/e-quotation/' . $item->_id) . '" class="table_link">' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "E-comparison" || $item->status['status'] == "Quote Amendment-E-comparison") {
            //         $referanceNumber = '<a href="' . URL::to('contractor-plant/e-comparison/' . $item->_id) . '" class="table_link">' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "Approved E Quote") {
            //         $referanceNumber = '<a href="' . URL::to('contractor-plant/approved-quot/' . $item->_id) . '" class="table_link" >' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "Quote Amendment") {
            //         $referanceNumber = '<a href="' . URL::to('contractor-plant/quot-amendment/' . $item->_id) . '" class="table_link" >' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "Issuance") {
            //         $referanceNumber = '<a href="' . URL::to('contractor-plant/issuance/' . $item->_id) . '" class="table_link" >' . $item->refereneceNumber . '</a>';
            //     }
            // } else {
            //     $referanceNumber = '<a  class="table_link">' . $item->refereneceNumber . '</button>';
            // }
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
                $maingroup = $item->customer['maingroupName'];
            } else {
                $maingroup = '--';
                $maingroup_code = '--';
            }

            if (isset($item->workTypeId['department'])) {
                $department = $item->workTypeId['department'];
            } else {
                $department = '--';
            }
            $underwriter = '--';
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
                $amendments = '0';
            }
            $temp = new \stdClass();
            $temp->category = $category;
            $temp->referenceNumber = @$referanceNumber;
            $temp->created_at = $created_at;
            $temp->created_by = $created_by;
            $temp->customerId = $id;
            $temp->customerName = $name;
            $temp->maingroup_id = $maingroup_code;
            $temp->mainGroup = $maingroup;
            $temp->department = $department;
            $temp->agent = $agent;
            $temp->underwriter = $case_manager;
            $temp->status = $status;
            // $temp->current_update = $updated_by
            $temp->current_update = $current_update;
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
     * save questionnaire details
     */
    public static function equestionnaireSave(Request $request)
    {
        try {
            $file = [];
            $questionnaire = PipelineItems::find($request->input('id'));
            $address_object = new \stdClass();
            $address_object->addressLine1 = $request->input('addressLine1');
            $address_object->addressLine2 = $request->input('addressLine2');
            $address_object->country = $request->input('country');
            $address_object->state = $request->input('state');
            $address_object->city = $request->input('city');
            $address_object->zipCode = $request->input('zipCode');

            $formdata = new \stdClass();
            $formdata->salutation = $request->input('salutation');
            $formdata->firstName = $request->input('firstName');
            $formdata->middleName = $request->input('middleName');
            $formdata->lastName = $request->input('lastName');
            $formdata->lastName = $request->input('lastName');
            $formdata->addressDetails = $address_object;
            $formdata->businessType = $request->input('businessType');

            $existing_policy_object = new \stdClass();
            if ($request->input('hasExistingPolicy') != '') {
                if ($request->input('hasExistingPolicy') == 'existing_policy') {
                    $policy = (boolean) true;
                    $existingRate = str_replace(',', '', $request->input('existingRate'));
                    $currentInsurer = $request->input('currentInsurer');
                }
                if ($request->input('hasExistingPolicy') == 'no') {
                    $policy = (boolean) false;
                    $existingRate = '';
                    $currentInsurer = '';
                }
                $existing_policy_object->hasExistingPolicy = $policy;
                $existing_policy_object->existingRate = $existingRate;
                $existing_policy_object->currentInsurer = $currentInsurer;
                $formdata->existingPolicyDetails = $existing_policy_object;
            }
            if ($request->input('withinUAE') != '') {
                $place_employement_object = new \stdClass();
                $withinUAE = $request->input('withinUAE');
                if ($withinUAE == 'WithinUAE') {
                    $emirateName = $request->input('emirateName');
                    $countryName = '';
                    $withinUAE_status = (boolean) true;
                } elseif ($withinUAE == 'OutsideUAE') {
                    $emirateName = '';
                    $countryName = $request->input('countryName');
                    $withinUAE_status = (boolean) false;
                }
                $place_employement_object->withinUAE = $withinUAE_status;
                $place_employement_object->emirateName = $emirateName;
                $place_employement_object->countryName = $countryName;
                $formdata->placeOfEmployment = $place_employement_object;
            }
            $policy_period_object = new \stdClass();
            $policy_period_object->policyFrom = $request->input('policyFrom');
            $policy_period_object->policyTo = $request->input('policyTo');
            $formdata->policyPeriod = $policy_period_object;

            $employee_details_object = new \stdClass();
            $hasAdmin = $request->input('hasAdmin');
            if ($hasAdmin != null) {
                if ($hasAdmin == 'admin_employees') {
                    $admin_true = (boolean) true;
                    $nonadmin_true = (boolean) false;
                    $adminCount = $request->input('adminCount');
                    $adminAnnualWages = str_replace(',', '', $request->input('adminAnnualWages'));
                    $nonadminCount = '';
                    $nonadminAnnualWages = '';
                } elseif ($hasAdmin == 'non_admin_employees') {
                    $admin_true = (boolean) false;
                    $nonadmin_true = (boolean) true;
                    $nonadminCount = $request->input('nonAdminCount');
                    $nonadminAnnualWages = str_replace(',', '', $request->input('nonAdminAnnualWages'));
                    $adminCount = '';
                    $adminAnnualWages = '';
                } elseif ($hasAdmin == 'both_employees') {
                    $admin_true = (boolean) true;
                    $nonadmin_true = (boolean) true;
                    $adminCount = $request->input('bothAdminCount');
                    $nonadminCount = $request->input('bothNonAdminCount');
                    $adminAnnualWages = str_replace(',', '', $request->input('bothAdminAnnualWages'));
                    $nonadminAnnualWages = str_replace(',', '', $request->input('bothNonAdminAnnualWages'));
                } else {
                    $adminCount = '';
                    $nonadminCount = '';
                    $adminAnnualWages = '';
                    $nonadminAnnualWages = '';
                }
                $employee_details_object->hasAdmin = $admin_true;
                $employee_details_object->hasNonAdmin = $nonadmin_true;
                $employee_details_object->adminCount = $adminCount;
                $employee_details_object->nonAdminCount = $nonadminCount;
                $employee_details_object->adminAnnualWages = $adminAnnualWages;
                $employee_details_object->nonAdminAnnualWages = $nonadminAnnualWages;
                $formdata->employeeDetails = $employee_details_object;
            }
            if ($request->input('work_labour') != '') {
                $hired_details_object = new \stdClass();
                if ($request->input('work_labour') == 'hired_workers') {
                    $status_details = (boolean) true;
                } else {
                    $status_details = (boolean) false;
                }
                $hired_details_object->hasHiredWorkers = $status_details;
                if ($status_details == true) {
                    $hired_details_object->noOfLabourers = $request->input('noOfLabourers');
                    $hired_details_object->annualWages = str_replace(',', '', $request->input('annualWages'));
                } else {
                    $hired_details_object->noOfLabourers = "";
                    $hired_details_object->annualWages = "";
                }
                $formdata->hiredWorkersDetails = $hired_details_object;
            }
            if ($request->input('offshore') != '') {
                $offshore_object = new \stdClass();
                if ($request->input('offshore') == 'offshore_employees') {
                    $status_offshore = (boolean) true;
                } else {
                    $status_offshore = (boolean) false;
                }
                $offshore_object->hasOffShoreEmployees = $status_offshore;
                if ($status_offshore == true) {
                    $offshore_object->noOfLabourers = $request->input('offshoreNoOfLabourers');
                    $offshore_object->annualWages = str_replace(',', '', $request->input('offshoreAnnualWages'));
                } else {
                    $offshore_object->noOfLabourers = "";
                    $offshore_object->annualWages = "";
                }
                $formdata->offShoreEmployeeDetails = $offshore_object;
            }
            $taxRegistrationDocument = $request->file('taxRegistrationDocument');
            $tradeLicense = $request->file('tradeLicense');
            $listOfEmployees = $request->file('listOfEmployees');
            $policyCopy = $request->file('policyCopy');
            if ($taxRegistrationDocument) {
                $taxRegistrationDocument = PipelineController::uploadToCloud($taxRegistrationDocument);
                $taxRegistrationDocument_object = new \stdClass();
                $taxRegistrationDocument_object->url = $taxRegistrationDocument;
                $taxRegistrationDocument_object->file_name = 'TAX REGISTRATION DOCUMENT';
                $taxRegistrationDocument_object->upload_type = 'e_questionnaire';
                $file[] = $taxRegistrationDocument_object;
            } elseif ($request->input('tax_registation_url') != '') {
                $taxRegistrationDocument_object = new \stdClass();
                $taxRegistrationDocument_object->url = $request->input('tax_registation_url');
                $taxRegistrationDocument_object->file_name = 'TAX REGISTRATION DOCUMENT';
                $taxRegistrationDocument_object->upload_type = 'e_questionnaire';
                $file[] = $taxRegistrationDocument_object;
            } else {
                $taxRegistrationDocument_file = '';
            }
            if ($tradeLicense) {
                $tradeLicense = PipelineController::uploadToCloud($tradeLicense);
                $tradeLicense_object = new \stdClass();
                $tradeLicense_object->url = $tradeLicense;
                $tradeLicense_object->file_name = 'TRADE LICENSE';
                $tradeLicense_object->upload_type = 'e_questionnaire';
                $file[] = $tradeLicense_object;
            } elseif ($request->input('trade_license_url') != '') {
                $tradeLicense_object = new \stdClass();
                $tradeLicense_object->url = $request->input('trade_license_url');
                $tradeLicense_object->file_name = 'TRADE LICENSE';
                $tradeLicense_object->upload_type = 'e_questionnaire';
                $file[] = $tradeLicense_object;
            } else {
                $tradeLicense_file = '';
            }
            if ($listOfEmployees) {
                $listOfEmployees = PipelineController::uploadToCloud($listOfEmployees);
                $employee_list_object = new \stdClass();
                $employee_list_object->url = $listOfEmployees;
                $employee_list_object->file_name = 'LIST OF EMPLOYEES';
                $employee_list_object->upload_type = 'e_questionnaire';
                $file[] = $employee_list_object;
            } elseif ($request->input('employee_list_url') != '') {
                $employee_list_object = new \stdClass();
                $employee_list_object->url = $request->input('employee_list_url');
                $employee_list_object->file_name = 'LIST OF EMPLOYEES';
                $employee_list_object->upload_type = 'e_questionnaire';
                $file[] = $employee_list_object;
            } else {
                $employee_list_file = '';
            }
            if ($policyCopy) {
                $policyCopy = PipelineController::uploadToCloud($policyCopy);
                $policy_files = new \stdClass();
                $policy_files->url = $policyCopy;
                $policy_files->file_name = 'COPY OF THE POLICY';
                $policy_files->upload_type = 'e_questionnaire';
                $file[] = $policy_files;
            } elseif ($request->input('policy_file_url') != '') {
                $policy_files = new \stdClass();
                $policy_files->url = $request->input('policy_file_url');
                $policy_files->file_name = 'COPY OF THE POLICY';
                $policy_files->upload_type = 'e_questionnaire';
                $file[] = $policy_files;
            } else {
                $policy_file = '';
            }
            PipelineItems::where('_id', $request->input('id'))->pull('files', ['upload_type' => 'e_questionnaire']);
            PipelineItems::where('_id', $request->input('id'))->pull('files', ['upload_type' => 'worktype']);
            $upload_url = $request->input('output_url');
            $output_file = $request->input('output_file');
            $upload_url_values = explode(',', $upload_url);
            $output_file_values = explode(',', $output_file);
            $uploadedFiles = $questionnaire->files;
            PipelineItems::where('_id', $request->input('id'))->pull('files', ['upload_type' => 'e_questionnaire_fancy']);
            foreach ($output_file_values as $url => $url_value) {
                $files = new \stdClass();
                if ($output_file_values[$url] != '0') {
                    $files->url = $upload_url_values[$url];
                    $files->file_name = $output_file_values[$url];
                    $files->upload_type = 'e_questionnaire_fancy';
                    $file[] = $files;
                }
            }
            $other_document_saved = $request->input('other_document_saved');
            $other_document_saved_name = $request->input('other_document_saved_name');
            if ($other_document_saved) {
                foreach ($other_document_saved_name as $url => $url_value) {
                    $files_saved = new \stdClass();
                    $files_saved->url = $other_document_saved[$url];
                    $files_saved->file_name = $other_document_saved_name[$url];
                    $files_saved->upload_type = 'e_questionnaire_fancy';
                    $file[] = $files_saved;
                }
            }
            $year = $request->input('year');
            $type = $request->input('type');
            $description = $request->input('description');
            $minor_claim_amount = $request->input('minor_claim_amount');
            $death_claim_amount = $request->input('death_claim_amount');
            $claim_array = [];
            foreach ($description as $key => $year_value) {
                if ($year_value != 0 || $year_value != null) {
                    $claim_history_object = new \stdClass();
                    $claim_history_object->year = $year[$key];
                    $claim_history_object->type = $type[$key];
                    $claim_history_object->description = $description[$key];
                    $claim_history_object->minorInjuryClaimAmount = str_replace(',', '', $minor_claim_amount[$key]);
                    $claim_history_object->deathClaimAmount = str_replace(',', '', $death_claim_amount[$key]);
                    $claim_array[] = $claim_history_object;
                } else {
                    $claim_history_object = new \stdClass();
                    $claim_history_object->year = $year[$key];
                    $claim_history_object->type = $type[$key];
                    $claim_history_object->description = '';
                    $claim_history_object->minorInjuryClaimAmount = '';
                    $claim_history_object->deathClaimAmount = '';
                    $claim_array[] = $claim_history_object;
                }
            }

            $formdata->claimsHistory = $claim_array;

            if ($request->input('comments') && $request->input('comments') != '') {
                if ($request->input('filler_type') != "fill_customer") {
                    $comment_object = new \stdClass();
                    $comment_object->comment = $request->input('comments');
                    $comment_object->commentBy = Auth::user()->name;
                    $comment_object->userType = Auth::user()->roleDetail('name');
                    $comment_object->id = new ObjectID(Auth::id());
                    $comment_object->date = date('d-m-Y');
                    $comment_array[] = $comment_object;
                    $commentSeen[] = new ObjectID(Auth::id());
                } else {
                    $departments = $questionnaire->getCustomer['departmentDetails'];
                    $status = 0;
                    if (isset($departments)) {
                        foreach ($departments as $department) {
                            if ($department['departmentName'] == 'Genaral & Marine') {
                                $comment_object = new \stdClass();
                                $comment_object->comment = $request->input('comments');
                                $comment_object->commentBy = $department['depContactPerson'];
                                $comment_object->userType = "General & Marine";
                                $comment_object->id = new ObjectID($department['department']);
                                $comment_object->date = date('d/m/Y');
                                $comment_array[] = $comment_object;
                                $commentSeen[] = new ObjectID($questionnaire->customer['id']);
                                $status = 1;
                                break;
                            }
                        }
                    }
                    if ($status == 0) {
                        $comment_object = new \stdClass();
                        $comment_object->comment = $request->input('comments');
                        $comment_object->commentBy = $questionnaire->customer['name'];
                        $comment_object->userType = "Customer";
                        $comment_object->id = new ObjectID($questionnaire->customer['id']);
                        $comment_object->date = date('d/m/Y');
                        $comment_array[] = $comment_object;
                        $commentSeen[] = new ObjectID($questionnaire->customer['id']);
                    }
                }
                if ($questionnaire->comments) {
                    $questionnaire->push('comments', $comment_array);
                    PipelineItems::where('_id', $request->input('id'))->update(['commentSeen' => $commentSeen]);
                } else {
                    $questionnaire->comments = $comment_array;
                    $questionnaire->commentSeen = $commentSeen;
                }
            }
            $questionnaire->formData = $formdata;
            if ($request->input('is_save') == 'true') {
                if ($request->input('is_edit') == "0") {
                    $updatedBy_obj = new \stdClass();
                    $updatedBy_obj->id = new ObjectID(Auth::id());
                    $updatedBy_obj->name = Auth::user()->name;
                    $updatedBy_obj->date = date('d/m/Y');
                    $updatedBy_obj->action = "E questionnaire saved as draft";
                    $updatedBy[] = $updatedBy_obj;
                    $questionnaire->push('files', $file);
                    $questionnaire->push('updatedBy', $updatedBy);
                    $questionnaire->save();
                    return 'success';
                }
            }
            if ($request->input('filler_type') == "fill_customer") {
                $status = 0;
                if ($request->input('is_edit') == "0") {
                    $departments = $questionnaire->getCustomer['departmentDetails'];
                    if (isset($departments)) {
                        foreach ($departments as $department) {
                            if ($department['departmentName'] == 'Genaral & Marine') {
                                $questionnaire->filledBy = (String) "Genaral & Marine Department";
                                $updatedBy_obj = new \stdClass();
                                $updatedBy_obj->id = new ObjectID($department['department']);
                                $updatedBy_obj->name = 'Genaral & Marine (' . $department['depContactPerson'] . ')';
                                $updatedBy_obj->date = date('d/m/Y');
                                $updatedBy_obj->action = "E questionnaire filled";
                                $updatedBy[] = $updatedBy_obj;
                                $status = 1;
                                break;
                            }
                        }
                    }
                    if ($status == 0) {
                        $questionnaire->filledBy = (String) "Customer";
                        $updatedBy_obj = new \stdClass();
                        $updatedBy_obj->id = new ObjectID($questionnaire->getCustomer['_id']);
                        $updatedBy_obj->name = 'Customer (' . $questionnaire->getCustomer['firstName'] . ')';
                        $updatedBy_obj->date = date('d/m/Y');
                        $updatedBy_obj->action = "E questionnaire filled";
                        $updatedBy[] = $updatedBy_obj;
                    }
                    $questionnaire->tokenStatus = "inactive";
                    $questionnaire->push('updatedBy', $updatedBy);
                }
                if ($questionnaire['status']['status'] == 'Worktype Created' || $questionnaire['status']['status'] == 'E-questionnaire') {
                    $pipline_status = PipelineStatus::where('status', 'E-slip')->first();
                } elseif ($questionnaire['status']['status'] == 'Quote Amendment') {
                    $pipline_status = PipelineStatus::where('status', 'Quote Amendment-E-slip')->first();
                }
                if (isset($pipline_status)) {
                    $upStatus = 0;
                    $departments = $questionnaire->getCustomer['departmentDetails'];
                    if (isset($departments)) {
                        foreach ($departments as $department) {
                            if ($department['departmentName'] == 'Genaral & Marine') {
                                $pipeline_status_object = new \stdClass();
                                $pipeline_status_object->id = new ObjectID($pipline_status->_id);
                                $pipeline_status_object->status = (string) $pipline_status->status;
                                $pipeline_status_object->UpdatedById = new ObjectID($department['department']);
                                $pipeline_status_object->UpdatedByName = 'Genaral & Marine (' . $department['depContactPerson'] . ')';
                                $pipeline_status_object->date = date('d/m/Y');
                                $questionnaire->status = $pipeline_status_object;
                                $upStatus = 1;
                                break;
                            }
                        }
                    }
                    if ($upStatus == 0) {
                        $pipeline_status_object = new \stdClass();
                        $pipeline_status_object->id = new ObjectID($pipline_status->_id);
                        $pipeline_status_object->status = (string) $pipline_status->status;
                        $pipeline_status_object->UpdatedById = new ObjectId($questionnaire->getCustomer['_id']);
                        $pipeline_status_object->UpdatedByName = 'Customer (' . $questionnaire->getCustomer['firstName'] . ')';
                        $pipeline_status_object->date = date('d/m/Y');
                        $questionnaire->status = $pipeline_status_object;
                    }
                }
            } else {
                if ($request->input('is_edit') == "0") {
                    $updatedBy_obj = new \stdClass();
                    $updatedBy_obj->id = new ObjectID(Auth::id());
                    $updatedBy_obj->name = Auth::user()->name;
                    $updatedBy_obj->date = date('d/m/Y');
                    $updatedBy_obj->action = "E questionnaire filled";
                    $updatedBy[] = $updatedBy_obj;
                    if (isset($questionnaire->tokenStatus)) {
                        $questionnaire->tokenStatus = "inactive";
                    }
                    $questionnaire->push('updatedBy', $updatedBy);
                }
                $pipline_status = PipelineStatus::where('status', 'E-slip')->first();
                $pipeline_status_object = new \stdClass();
                $pipeline_status_object->id = new ObjectID($pipline_status->_id);
                $pipeline_status_object->status = (string) $pipline_status->status;
                $pipeline_status_object->UpdatedById = new ObjectId(Auth::id());
                $pipeline_status_object->UpdatedByName = Auth::user()->name;
                $pipeline_status_object->date = date('d/m/Y');
                $questionnaire->status = $pipeline_status_object;
            }
            if ($request->input('is_edit') == "0") {
                $questionnaire->push('files', $file);
                $questionnaire->save();
            } else {
                $formdata_object = array('formData.salutation' => $request->input('salutation'),
                    'formData.firstName' => $request->input('firstName'),
                    'formData.middleName' => $request->input('middleName'),
                    'formData.lastName' => $request->input('lastName'),
                    'formData.addressDetails' => $address_object,
                    'formData.businessType' => $request->input('businessType'),
                    'formData.existingPolicyDetails' => $existing_policy_object,
                    'formData.placeOfEmployment' => $place_employement_object,
                    'formData.policyPeriod' => $policy_period_object,
                    'formData.hiredWorkersDetails' => $hired_details_object,
                    'formData.offShoreEmployeeDetails' => $offshore_object,
                    'formData.employeeDetails' => $employee_details_object,
                    'formData.claimsHistory' => $claim_array,
                );

                if ($request->input('comments') && $request->input('comments') != '') {
                    PipelineItems::where('_id', $request->input('id'))->push('comments', $comment_array);
                    PipelineItems::where('_id', $request->input('id'))->update(['commentSeen' => $commentSeen]);
                }
                DB::collection('pipelineItems')->where('_id', new ObjectId($request->input('id')))
                    ->update($formdata_object);
                $questionnaire1 = PipelineItems::find($request->input('id'));
                if (isset($questionnaire1['formData']['hiredWorkersDetails'])) {
                    if ($questionnaire1['formData']['hiredWorkersDetails']['hasHiredWorkers'] == false) {
                        DB::collection('pipelineItems')->where('_id', new ObjectId($request->input('id')))->unset('formData.hiredCheck');
                    } else {
                        DB::collection('pipelineItems')->where('_id', new ObjectId($request->input('id')))->update(['formData.hiredCheck' => true]);
                    }
                }
                if (isset($questionnaire1['formData']['offShoreEmployeeDetails'])) {
                    if ($questionnaire1['formData']['offShoreEmployeeDetails']['hasOffShoreEmployees'] == false) {
                        DB::collection('pipelineItems')->where('_id', new ObjectId($request->input('id')))->unset('formData.offshoreCheck');
                    } else {
                        DB::collection('pipelineItems')->where('_id', new ObjectId($request->input('id')))->update(['formData.offshoreCheck' => true]);
                    }
                }

                if (@$questionnaire1['formData']['businessType'] == 'Bridges & tunnels' || @$questionnaire1['formData']['businessType'] == 'Builders/ general contractors'
                    || @$questionnaire1['formData']['businessType'] == 'Infrastructure' || @$questionnaire1['formData']['businessType'] == 'Rail roads & related infrastructure'
                ) {
                    DB::collection('pipelineItems')->where('_id', new ObjectId($request->input('id')))->update(['formData.waiverOfSubrogation' => $questionnaire1['formData']['businessType'], 'formData.indemnityToPrincipal' => true]);
                } else {
                    DB::collection('pipelineItems')->where('_id', new ObjectId($request->input('id')))->unset(['formData.waiverOfSubrogation', 'formData.indemnityToPrincipal']);
                }

                DB::collection('pipelineItems')->where('_id', new ObjectId($request->input('id')))
                    ->push('files', $file);
                if ($request->input('is_save') == 'true') {
                    $updatedBy_obj = new \stdClass();
                    $updatedBy_obj->id = new ObjectID(Auth::id());
                    $updatedBy_obj->name = Auth::user()->name;
                    $updatedBy_obj->date = date('d/m/Y');
                    $updatedBy_obj->action = "E questionnaire saved as draft";
                    $updatedByedit[] = $updatedBy_obj;
                    PipelineItems::where('_id', new ObjectId($request->input('id')))->push('updatedBy', $updatedByedit);
                    return 'success';
                }
                if ($request->input('filler_type') != "fill_customer") {
                    $updatedBy_obj = new \stdClass();
                    $updatedBy_obj->id = new ObjectID(Auth::id());
                    $updatedBy_obj->name = Auth::user()->name;
                    $updatedBy_obj->date = date('d/m/Y');
                    $updatedBy_obj->action = "E questionnaire updated";
                    $updatedByedit[] = $updatedBy_obj;
                    PipelineItems::where('_id', new ObjectId($request->input('id')))->push('updatedBy', $updatedByedit);
                } else {
                    $status = 0;
                    $departments = $questionnaire->getCustomer['departmentDetails'];
                    if (isset($departments)) {
                        foreach ($departments as $department) {
                            if ($department['departmentName'] == 'Genaral & Marine') {
                                $questionnaire->filledBy = (String) "Genaral & Marine Department";
                                $updatedBy_obj = new \stdClass();
                                $updatedBy_obj->id = new ObjectID($department['department']);
                                $updatedBy_obj->name = 'Genaral & Marine (' . $department['depContactPerson'] . ')';
                                $updatedBy_obj->date = date('d/m/Y');
                                $updatedBy_obj->action = "E questionnaire filled";
                                PipelineItems::where('_id', new ObjectId($request->input('id')))->push('updatedBy', $updatedBy_obj);
                                $status = 1;
                                break;
                            }
                        }
                    }
                    if ($status == 0) {
                        $questionnaire->filledBy = (String) "Customer";
                        $updatedBy_obj = new \stdClass();
                        $updatedBy_obj->id = new ObjectID($questionnaire->getCustomer['_id']);
                        $updatedBy_obj->name = 'Customer (' . $questionnaire->getCustomer['firstName'] . ')';
                        $updatedBy_obj->date = date('d/m/Y');
                        $updatedBy_obj->action = "E questionnaire filled";
                        PipelineItems::where('_id', new ObjectId($request->input('id')))->push('updatedBy', $updatedBy_obj);
                    }
                }
                if ($request->input('filler_type') != "fill_customer") {
                    $pipeline = PipelineItems::where('_id', new ObjectId($request->input('id')))->first();
                    if ($pipeline['status']['status'] == 'Worktype Created' || $pipeline['status']['status'] == 'E-questionnaire') {
                        $pipline_status = PipelineStatus::where('status', 'E-slip')->first();
                        $pipeline_status_object = new \stdClass();
                        $pipeline_status_object->id = new ObjectID($pipline_status->_id);
                        $pipeline_status_object->status = (string) $pipline_status->status;
                        $pipeline_status_object->UpdatedById = new ObjectId(Auth::id());
                        $pipeline_status_object->UpdatedByName = Auth::user()->name;
                        $pipeline_status_object->date = date('d/m/Y');
                        $pipeline->status = $pipeline_status_object;
                        $pipeline->tokenStatus = "inactive";
                        $pipeline->save();
                    } elseif ($pipeline['status']['status'] == 'Quote Amendment') {
                        $pipline_status = PipelineStatus::where('status', 'Quote Amendment-E-slip')->first();
                        $pipeline_status_object = new \stdClass();
                        $pipeline_status_object->id = new ObjectID($pipline_status->_id);
                        $pipeline_status_object->status = (string) $pipline_status->status;
                        $pipeline_status_object->UpdatedById = new ObjectId(Auth::id());
                        $pipeline_status_object->UpdatedByName = Auth::user()->name;
                        $pipeline_status_object->date = date('d/m/Y');
                        $pipeline->status = $pipeline_status_object;
                        $pipeline->tokenStatus = "inactive";
                        $pipeline->save();
                    }
                } else {
                    $pipeline = PipelineItems::where('_id', new ObjectId($request->input('id')))->first();
                    $upStatus = 0;
                    $departments = $pipeline->getCustomer['departmentDetails'];
                    if (isset($departments)) {
                        foreach ($departments as $department) {
                            if ($department['departmentName'] == 'Genaral & Marine') {
                                $pipeline_status_object = new \stdClass();
                                $pipeline_status_object->id = new ObjectID($pipline_status->_id);
                                $pipeline_status_object->status = (string) $pipline_status->status;
                                $pipeline_status_object->UpdatedById = new ObjectID($department['department']);
                                $pipeline_status_object->UpdatedByName = 'Genaral & Marine (' . $department['depContactPerson'] . ')';
                                $pipeline_status_object->date = date('d/m/Y');
                                $pipeline->status = $pipeline_status_object;
                                $pipeline->tokenStatus = "inactive";
                                $pipeline->save();
                                $upStatus = 1;
                                break;
                            }
                        }
                    }
                    if ($upStatus == 0) {
                        $pipeline_status_object = new \stdClass();
                        $pipeline_status_object->id = new ObjectID($pipline_status->_id);
                        $pipeline_status_object->status = (string) $pipline_status->status;
                        $pipeline_status_object->UpdatedById = new ObjectId($questionnaire->getCustomer['_id']);
                        $pipeline_status_object->UpdatedByName = 'Customer (' . $questionnaire->getCustomer['firstName'] . ')';
                        $pipeline_status_object->date = date('d/m/Y');
                        $pipeline->status = $pipeline_status_object;
                        $pipeline->tokenStatus = "inactive";
                        $pipeline->save();
                    }
                }
            }

            if ($request->input('filler_type') != "fill_customer") {
                Session::flash('status', 'Questionnaire added successfully.');
                return "success";
            } else {
                Session::flash('msg', 'E-questionnaire successfully added');
                return redirect('customer-notification');
            }
        } catch (\Exception $e) {
            if ($request->input('filler_type') != "fill_customer.") {
                return back()->withInput()->with('status', 'Failed');
            } else {
                Session::flash('msg', 'E-questionnaire is failed to add.');
                return redirect('customer-notification');
            }
        }
    }

    /**
     *  fancy file upload
     */
    public static function questionnaireFileupload(Request $request)
    {
        $files = WorkTypeController::NormalizeFiles("documents");
        $file_name = $files[0];
        $file_name_from_form = $file_name['name'];
        if ($file_name['ext'] == '') {
            return response()->json(['success' => false, "error" => "File name Required", "errorcode" => "file required"]);
        } else {
            $file_url = WorkTypeController::uploadToCloud($file_name);
            return response()->json(['success' => true, 'file_url' => $file_url, 'file_name' => $file_name_from_form]);
        }
    }

    /**
     * function for upload to cloud
     */
    public static function uploadToCloud($file)
    {

        $extension = $file->getClientOriginalExtension();
        // dd($extension);
        $fileName = time() . uniqid() . '.' . $extension;

        $filePath = "/" . $fileName;
        //        dd($file);
        $disk = Storage::disk('s3');
        $disk->put($filePath, fopen($file, 'r+'), 'public'); //uploading as streams, useful for large uploads.
        $file_url = 'https://s3-' . Config::get('filesystems.disks.s3.region') . '.amazonaws.com/' . Config::get('filesystems.disks.s3.bucket') . '/' . $fileName;
        return $file_url;
    }

    /**
     * save e-slip details
     */
    public function eslipSave(Request $request)
    {
        try {
            if ($request->input('is_save') != 'true') {
                $scale_value = $request->input('scale');
                if ($scale_value == 'uae_law') {
                    $asPerUAELaw = true;
                    $isPTD = false;
                } elseif ($scale_value == 'as_ptd') {
                    $asPerUAELaw = false;
                    $isPTD = true;
                }
                $scale_object = new \stdClass();
                $scale_object->asPerUAELaw = $asPerUAELaw;
                $scale_object->isPTD = $isPTD;
                //            var_dump($request->input('HoursPAC') =='yes' ? true : false);
                //            die();
                $pipeline_details = PipelineItems::find(new ObjectId($request->input('eslip_id')));
                if (@$pipeline_details['formData']['businessType'] == 'Bridges & tunnels' || @$pipeline_details['formData']['businessType'] == 'Builders/ general contractors'
                    || @$pipeline_details['formData']['businessType'] == 'Infrastructure' || @$pipeline_details['formData']['businessType'] == 'Rail roads & related infrastructure'
                ) {
                    $formdata_object = array('formData.scaleOfCompensation' => $scale_object,
                        'formData.extendedLiability' => (string) str_replace(',', '', $request->input('extended_liability')),
                        'formData.medicalExpense' => (string) str_replace(',', '', $request->input('medical_expenses')),
                        'formData.repatriationExpenses' => (string) str_replace(',', '', $request->input('repatriation_expenses')),
                        'formData.HoursPAC' => $request->input('HoursPAC') == 'yes' ? true : false,
                        'formData.herniaCover' => $request->input('herniaCover')?: false,
                        'formData.emergencyEvacuation' => $request->input('emergencyEvacuation') ?: false,
                        'formData.legalCost' => $request->input('legalCost') ?: false,
                        'formData.empToEmpLiability' => $request->input('empToEmpLiability')?: false,
                        'formData.errorsOmissions' => $request->input('errorsOmissions') ?: false,
                        'formData.crossLiability' => $request->input('crossLiability') ?: false,
                        'formData.waiverOfSubrogation' => $pipeline_details['formData']['businessType'],
                        'formData.automaticClause' => (boolean) $request->input('automaticClause') ?: false,
                        'formData.flightCover' => (boolean) $request->input('flightCover') ?: false,
                        'formData.diseaseCover' => (boolean) $request->input('diseaseCover') ?: false,
                        'formData.cancellationClause' => (boolean) $request->input('cancellationClause') ?: false,
                        'formData.indemnityToPrincipal' => (boolean) $request->input('indemnityToPrincipal') ?: false,
                        'formData.overtimeWorkCover' => (boolean) $request->input('overtimeWorkCover') ?: false,
                        'formData.lossNotification' => (boolean) $request->input('lossNotification') ?: false,
                        'formData.primaryInsuranceClause' => (boolean) $request->input('primaryInsuranceClause') ?: false,
                        'formData.travelCover' => (boolean) $request->input('travelCover') ?: false,
                        'formData.riotCover' => (boolean) $request->input('riotCover') ?: false,
                        'formData.brokersClaimClause' => (boolean) $request->input('brokersClaimClause') ?: false,
                        'formData.sepOrCom' => (boolean) ($request->input('sepOrCom') == 'yes') ? true : ($request->input('sepOrCom') == 'no' ? false : null),
                        'formData.rateRequiredAdmin' => (string) $request->input('rateRequiredAdmin'),
                        'formData.rateRequiredNonAdmin' => (string) $request->input('rateRequiredNonAdmin'),
                        'formData.combinedRate' => (string) $request->input('combinedRate'),
                        'formData.brokerage' => (string) $request->input('brokerage'),
                        'formData.warranty' => (string) $request->input('warranty') ?: '',
                        'formData.exclusion' => (string) $request->input('exclusion') ?: '',
                        'formData.specialCondition' => (string) $request->input('specialCondition') ?: '',
                        'formData.offshoreCheck' => (boolean) $request->input('offshoreCheck') ?: false,
                        'formData.hiredCheck' => (boolean) $request->input('hiredCheck') ?: false,
                    );
                } else {
                    $formdata_object = array('formData.scaleOfCompensation' => $scale_object,
                        'formData.extendedLiability' => (string) str_replace(',', '', $request->input('extended_liability')),
                        'formData.medicalExpense' => (string) str_replace(',', '', $request->input('medical_expenses')),
                        'formData.repatriationExpenses' => (string) str_replace(',', '', $request->input('repatriation_expenses')),
                        'formData.HoursPAC' => $request->input('HoursPAC') == 'yes' ? true : false,
                        'formData.herniaCover' => $request->input('herniaCover')?: false,
                        'formData.emergencyEvacuation' => $request->input('emergencyEvacuation')?: false,
                        'formData.legalCost' => $request->input('legalCost')?: false,
                        'formData.empToEmpLiability' => $request->input('empToEmpLiability')?: false,
                        'formData.errorsOmissions' => $request->input('errorsOmissions') ?: false,
                        'formData.crossLiability' => $request->input('crossLiability') ?: false,
                        'formData.automaticClause' => (boolean) $request->input('automaticClause') ?: false,
                        'formData.flightCover' => (boolean) $request->input('flightCover') ?: false,
                        'formData.diseaseCover' => (boolean) $request->input('diseaseCover') ?: false,
                        'formData.cancellationClause' => (boolean) $request->input('cancellationClause') ?: false,
                        'formData.overtimeWorkCover' => (boolean) $request->input('overtimeWorkCover') ?: false,
                        'formData.lossNotification' => (boolean) $request->input('lossNotification') ?: false,
                        'formData.primaryInsuranceClause' => (boolean) $request->input('primaryInsuranceClause') ?: false,
                        'formData.travelCover' => (boolean) $request->input('travelCover') ?: false,
                        'formData.riotCover' => (boolean) $request->input('riotCover') ?: false,
                        'formData.brokersClaimClause' => (boolean) $request->input('brokersClaimClause') ?: false,
                        'formData.sepOrCom' => (boolean) ($request->input('sepOrCom') == 'yes') ? true : ($request->input('sepOrCom') == 'no' ? false : null),
                        'formData.rateRequiredAdmin' => (string) $request->input('rateRequiredAdmin'),
                        'formData.rateRequiredNonAdmin' => (string) $request->input('rateRequiredNonAdmin'),
                        'formData.combinedRate' => (string) $request->input('combinedRate'),
                        'formData.brokerage' => (string) $request->input('brokerage'),
                        'formData.warranty' => (string) $request->input('warranty') ?: '',
                        'formData.exclusion' => (string) $request->input('exclusion') ?: '',
                        'formData.specialCondition' => (string) $request->input('specialCondition') ?: '',
                        'formData.offshoreCheck' => (boolean) $request->input('offshoreCheck') ?: false,
                        'formData.hiredCheck' => (boolean) $request->input('hiredCheck') ?: false,
                    );
                    if (isset($pipeline_details['formData']['waiverOfSubrogation'])) {
                        DB::collection('pipelineItems')->where('_id', new ObjectId($request->input('eslip_id')))->unset('formData.waiverOfSubrogation');
                    }
                    if (isset($pipeline_details['formData']['indemnityToPrincipal'])) {
                        DB::collection('pipelineItems')->where('_id', new ObjectId($request->input('eslip_id')))->unset('formData.indemnityToPrincipal');
                    }
                }

                $updatedBy_obj = new \stdClass();
                $updatedBy_obj->id = new ObjectID(Auth::id());
                $updatedBy_obj->name = Auth::user()->name;
                $updatedBy_obj->date = date('d/m/Y');
                $updatedBy_obj->action = "E slip";
                $updatedBy[] = $updatedBy_obj;
                DB::collection('pipelineItems')->where('_id', new ObjectId($request->input('eslip_id')))
                    ->update($formdata_object);
                if (isset($pipeline_details['formData']['hiredWorkersDetails'])) {
                    if ($pipeline_details['formData']['hiredWorkersDetails']['hasHiredWorkers'] == false) {
                        DB::collection('pipelineItems')->where('_id', new ObjectId($request->input('eslip_id')))->unset('formData.hiredCheck');
                    }
                }
                if (isset($pipeline_details['formData']['offShoreEmployeeDetails'])) {
                    if ($pipeline_details['formData']['offShoreEmployeeDetails']['hasOffShoreEmployees'] == false) {
                        DB::collection('pipelineItems')->where('_id', new ObjectId($request->input('eslip_id')))->unset('formData.offshoreCheck');
                    }
                }
                PipelineItems::where('_id', new ObjectId($request->input('eslip_id')))->push('updatedBy', $updatedBy);
                return response()->json(['success' => 'success']);
            } else {
                if ($request->input('scale') != null) {
                    $scale_value = $request->input('scale');
                    if ($scale_value == 'uae_law') {
                        $asPerUAELaw = true;
                        $isPTD = false;
                    } elseif ($scale_value == 'as_ptd') {
                        $asPerUAELaw = false;
                        $isPTD = true;
                    }
                    $scale_object = new \stdClass();
                    $scale_object->asPerUAELaw = $asPerUAELaw;
                    $scale_object->isPTD = $isPTD;
                } else {
                    $scale_object = "";
                }
                //            var_dump($request->input('HoursPAC') =='yes' ? true : false);
                //            die();
                if ($request->input('HoursPAC') == 'yes') {
                    $HoursPAC = true;
                } elseif ($request->input('HoursPAC') == 'no') {
                    $HoursPAC = false;
                } else {
                    $HoursPAC = 'empty';
                }
                if ($request->input('herniaCover') == 'true') {
                    $herniaCover = true;
                } elseif ($request->input('herniaCover') == 'no') {
                    $herniaCover = false;
                } else {
                    $herniaCover = 'empty';
                }
                if ($request->input('emergencyEvacuation') == 'true') {
                    $emergencyEvacuation = true;
                } elseif ($request->input('emergencyEvacuation') == 'no') {
                    $emergencyEvacuation = false;
                } else {
                    $emergencyEvacuation = 'empty';
                }
                if ($request->input('legalCost') == 'true') {
                    $legalCost = true;
                } elseif ($request->input('legalCost') == 'no') {
                    $legalCost = false;
                } else {
                    $legalCost = 'empty';
                }
                if ($request->input('empToEmpLiability') == 'true') {
                    $empToEmpLiability = true;
                } elseif ($request->input('empToEmpLiability') == 'no') {
                    $empToEmpLiability = false;
                } else {
                    $empToEmpLiability = 'empty';
                }
                if ($request->input('errorsOmissions') == 'true') {
                    $errorsOmissions = true;
                } elseif ($request->input('errorsOmissions') == 'no') {
                    $errorsOmissions = false;
                } else {
                    $errorsOmissions = 'empty';
                }
                if ($request->input('crossLiability') == 'true') {
                    $crossLiability = true;
                } elseif ($request->input('crossLiability') == 'no') {
                    $crossLiability = false;
                } else {
                    $crossLiability = 'empty';
                }
                // if ($request->input('waiverOfSubrogation') == 'yes') {
                //     $waiverOfSubrogation = true;
                // } elseif ($request->input('waiverOfSubrogation') == 'no') {
                //     $waiverOfSubrogation = false;
                // } else {
                //     $waiverOfSubrogation = 'empty';
                // }

                $pipeline_details = PipelineItems::find(new ObjectId($request->input('eslip_id')));
                if (@$pipeline_details['formData']['businessType'] == 'Bridges & tunnels' || @$pipeline_details['formData']['businessType'] == 'Builders/ general contractors'
                    || @$pipeline_details['formData']['businessType'] == 'Infrastructure' || @$pipeline_details['formData']['businessType'] == 'Rail roads & related infrastructure'
                ) {
                    $formdata_object = array('formData.scaleOfCompensation' => $scale_object,
                        'formData.extendedLiability' => (string) str_replace(',', '', $request->input('extended_liability')),
                        'formData.medicalExpense' => (string) str_replace(',', '', $request->input('medical_expenses')),
                        'formData.repatriationExpenses' => (string) str_replace(',', '', $request->input('repatriation_expenses')),
                        'formData.HoursPAC' => $HoursPAC,
                        'formData.herniaCover' => $herniaCover,
                        'formData.emergencyEvacuation' => $emergencyEvacuation,
                        'formData.legalCost' => $legalCost,
                        'formData.empToEmpLiability' => $empToEmpLiability,
                        'formData.errorsOmissions' => $errorsOmissions,
                        'formData.crossLiability' => $crossLiability,
                        'formData.waiverOfSubrogation' =>$pipeline_details['formData']['businessType'],
                        'formData.automaticClause' => (boolean) $request->input('automaticClause') ?: '',
                        'formData.flightCover' => (boolean) $request->input('flightCover') ?: '',
                        'formData.diseaseCover' => (boolean) $request->input('diseaseCover') ?: '',
                        'formData.cancellationClause' => (boolean) $request->input('cancellationClause') ?: '',
                        'formData.indemnityToPrincipal' => (boolean) $request->input('indemnityToPrincipal') ?: '',
                        'formData.overtimeWorkCover' => (boolean) $request->input('overtimeWorkCover') ?: '',
                        'formData.lossNotification' => (boolean) $request->input('lossNotification') ?: '',
                        'formData.primaryInsuranceClause' => (boolean) $request->input('primaryInsuranceClause') ?: '',
                        'formData.travelCover' => (boolean) $request->input('travelCover') ?: '',
                        'formData.riotCover' => (boolean) $request->input('riotCover') ?: '',
                        'formData.brokersClaimClause' => (boolean) $request->input('brokersClaimClause') ?: '',
                        'formData.sepOrCom' => (boolean) ($request->input('sepOrCom') == 'yes') ? true : ($request->input('sepOrCom') == 'no' ? false : null),
                        'formData.rateRequiredAdmin' => (string) $request->input('rateRequiredAdmin'),
                        'formData.rateRequiredNonAdmin' => (string) $request->input('rateRequiredNonAdmin'),
                        'formData.combinedRate' => (string) $request->input('combinedRate'),
                        'formData.brokerage' => (string) $request->input('brokerage'),
                        'formData.warranty' => (string) $request->input('warranty') ?: '',
                        'formData.exclusion' => (string) $request->input('exclusion') ?: '',
                        'formData.specialCondition' => (string) $request->input('specialCondition') ?: '',
                        'formData.offshoreCheck' => (boolean) $request->input('offshoreCheck') ?: '',
                        'formData.hiredCheck' => (boolean) $request->input('hiredCheck') ?: '',
                    );
                } else {
                    $formdata_object = array('formData.scaleOfCompensation' => $scale_object,
                        'formData.extendedLiability' => (string) str_replace(',', '', $request->input('extended_liability')),
                        'formData.medicalExpense' => (string) str_replace(',', '', $request->input('medical_expenses')),
                        'formData.repatriationExpenses' => (string) str_replace(',', '', $request->input('repatriation_expenses')),
                        'formData.HoursPAC' => $HoursPAC,
                        'formData.herniaCover' => $herniaCover,
                        'formData.emergencyEvacuation' => $emergencyEvacuation,
                        'formData.legalCost' => $legalCost,
                        'formData.empToEmpLiability' => $empToEmpLiability,
                        'formData.errorsOmissions' => $errorsOmissions,
                        'formData.crossLiability' => $crossLiability,
                        'formData.automaticClause' => (boolean) $request->input('automaticClause') ?: '',
                        'formData.flightCover' => (boolean) $request->input('flightCover') ?: '',
                        'formData.diseaseCover' => (boolean) $request->input('diseaseCover') ?: '',
                        'formData.cancellationClause' => (boolean) $request->input('cancellationClause') ?: '',
                        'formData.overtimeWorkCover' => (boolean) $request->input('overtimeWorkCover') ?: '',
                        'formData.lossNotification' => (boolean) $request->input('lossNotification') ?: '',
                        'formData.primaryInsuranceClause' => (boolean) $request->input('primaryInsuranceClause') ?: '',
                        'formData.travelCover' => (boolean) $request->input('travelCover') ?: '',
                        'formData.riotCover' => (boolean) $request->input('riotCover') ?: '',
                        'formData.brokersClaimClause' => (boolean) $request->input('brokersClaimClause') ?: '',
                        'formData.sepOrCom' => (boolean) ($request->input('sepOrCom') == 'yes') ? true : ($request->input('sepOrCom') == 'no' ? false : null),
                        'formData.rateRequiredAdmin' => (string) $request->input('rateRequiredAdmin'),
                        'formData.rateRequiredNonAdmin' => (string) $request->input('rateRequiredNonAdmin'),
                        'formData.combinedRate' => (string) $request->input('combinedRate'),
                        'formData.brokerage' => (string) $request->input('brokerage'),
                        'formData.warranty' => (string) $request->input('warranty') ?: '',
                        'formData.exclusion' => (string) $request->input('exclusion') ?: '',
                        'formData.specialCondition' => (string) $request->input('specialCondition') ?: '',
                        'formData.offshoreCheck' => (boolean) $request->input('offshoreCheck') ?: '',
                        'formData.hiredCheck' => (boolean) $request->input('hiredCheck') ?: '',
                    );
                    if (isset($pipeline_details['formData']['waiverOfSubrogation'])) {
                        DB::collection('pipelineItems')->where('_id', new ObjectId($request->input('eslip_id')))->unset('formData.waiverOfSubrogation');
                    }
                    if (isset($pipeline_details['formData']['indemnityToPrincipal'])) {
                        DB::collection('pipelineItems')->where('_id', new ObjectId($request->input('eslip_id')))->unset('formData.indemnityToPrincipal');
                    }
                }

                DB::collection('pipelineItems')->where('_id', new ObjectId($request->input('eslip_id')))
                    ->update($formdata_object);
                if (isset($pipeline_details['formData']['hiredWorkersDetails'])) {
                    if ($pipeline_details['formData']['hiredWorkersDetails']['hasHiredWorkers'] == false) {
                        //                        var_dump($pipeline_details['formData']['hiredWorkersDetails']['hasHiredWorkers']);
                        DB::collection('pipelineItems')->where('_id', new ObjectId($request->input('eslip_id')))->unset('formData.hiredCheck');
                    }
                }
                if (isset($pipeline_details['formData']['offShoreEmployeeDetails'])) {
                    if ($pipeline_details['formData']['offShoreEmployeeDetails']['hasOffShoreEmployees'] == false) {
                        //                        var_dump($pipeline_details['formData']['offShoreEmployeeDetails']['hasOffShoreEmployees']);

                        DB::collection('pipelineItems')->where('_id', new ObjectId($request->input('eslip_id')))->unset('formData.offshoreCheck');
                    }
                }
                $updatedBy_obj = new \stdClass();
                $updatedBy_obj->id = new ObjectID(Auth::id());
                $updatedBy_obj->name = Auth::user()->name;
                $updatedBy_obj->date = date('d/m/Y');
                $updatedBy_obj->action = "E slip saved as draft";
                $updatedBy[] = $updatedBy_obj;
                PipelineItems::where('_id', new ObjectId($request->input('eslip_id')))->push('updatedBy', $updatedBy);
                return response()->json(['success' => 'success']);
            }
        } catch (\Exception $e) {
            return back()->withInput()->with('status', 'Failed');
        }
    }

    //create excel sheet for insurers
    public function createExcel($pipeline_details)
    {
        $pipeline_details = PipelineItems::find($pipeline_details->_id);
        $questions_array = [];
        $answes_array = [];
        if ($pipeline_details['formData']['scaleOfCompensation']['asPerUAELaw'] == true) {
            $questions_array[] = 'Scale of Compensation /Limit of Indemnity';
            $answes_array[] = 'As per UAE Labour Law';
        }
        if ($pipeline_details['formData']['scaleOfCompensation']['isPTD'] == true) {
            $questions_array[] = 'Scale of Compensation /Limit of Indemnity';
            $answes_array[] = 'Death/Permanent Total Disability (PTD) Benefit increased to AED 50,000/- for those monthly salary is not more than AED 2,000/- and AE 75,000/- for those whose monthly salary is AED 2,000/- or more';
        }
        $questions_array[] = 'Employer’s extended liability under Common Law/Shariah Law';
        $answes_array[] = $pipeline_details['formData']['extendedLiability'];
        $questions_array[] = 'Medical Expense (In AED)';
        $answes_array[] = $pipeline_details['formData']['medicalExpense'];
        $questions_array[] = 'Repatriation Expenses (Repatriation of mortal remains or injured employee to his/her home country on medical advice) including  expenses of an accompanying person';
        $answes_array[] = $pipeline_details['formData']['repatriationExpenses'];
        if ($pipeline_details['formData']['hiredWorkersDetails']['hasHiredWorkers'] == true) {
            $questions_array[] = 'Cover for hired workers or casual labours';
            $answes_array[] = 'Number of Employees : ' . $pipeline_details['formData']['hiredWorkersDetails']['noOfLabourers'] . ', Wages : ' . $pipeline_details['formData']['hiredWorkersDetails']['annualWages'];
        }
        if ($pipeline_details['formData']['offShoreEmployeeDetails']['hasOffShoreEmployees'] == true) {
            $questions_array[] = 'Cover for offshore employees';
            $answes_array[] = 'Number of Employees : ' . $pipeline_details['formData']['offShoreEmployeeDetails']['noOfLabourers'] . ', Wages : ' . $pipeline_details['formData']['offShoreEmployeeDetails']['annualWages'];
        }
        if ($pipeline_details['formData']['HoursPAC'] == true) {
            $questions_array[] = '24 hours non-occupational personal accident cover – in UAE and home country benefits as per UAE Labour Law';
            $answes_array[] = 'Yes';
        }
        if ($pipeline_details['formData']['herniaCover'] == true) {
            $questions_array[] = 'Cover for hernia, heat/sun stroke, muscle spasm, muscle strain, lumbago related to work';
            $answes_array[] = 'Yes';
        }
        if ($pipeline_details['formData']['emergencyEvacuation'] == true) {
            $questions_array[] = 'Emergency evacuation';
            $answes_array[] = 'Yes';
        }
        if ($pipeline_details['formData']['legalCost'] == true) {
            $questions_array[] = 'Including Legal and Defence cost';
            $answes_array[] = 'Yes';
        }
        if ($pipeline_details['formData']['empToEmpLiability'] == true) {
            $questions_array[] = 'Employee to employee liability';
            $answes_array[] = 'Yes';
        }
        if ($pipeline_details['formData']['errorsOmissions'] == true) {
            $questions_array[] = 'Errors & Omissions';
            $answes_array[] = 'Yes';
        }
        if ($pipeline_details['formData']['crossLiability'] == true) {
            $questions_array[] = 'Cross Liability';
            $answes_array[] = 'Yes';
        }
        if (isset($pipeline_details['formData']['waiverOfSubrogation'])) {
            $questions_array[] = 'Waiver of subrogation';
            $answes_array[] = $pipeline_details['formData']['waiverOfSubrogation'];
        }
        if ($pipeline_details['formData']['automaticClause'] == true) {
            $questions_array[] = 'Automatic addition & deletion Clause';
            $answes_array[] = 'Yes';
        }
        if ($pipeline_details['formData']['flightCover'] == true) {
            $questions_array[] = 'Cover for insured’s employees on employment visas whilst on incoming and outgoing flights to/from  UAE';
            $answes_array[] = 'Yes';
        }
        if ($pipeline_details['formData']['diseaseCover'] == true) {
            $questions_array[] = 'Cover for occupational/ industrial disease as per Labour Law';
            $answes_array[] = 'Yes';
        }
        if ($pipeline_details['formData']['cancellationClause'] == true) {
            $questions_array[] = 'Cancellation clause-30 days by either side on  pro-rata';
            $answes_array[] = 'Yes';
        }
        if (isset($pipeline_details['formData']['indemnityToPrincipal'])) {
            if ($pipeline_details['formData']['indemnityToPrincipal'] == true) {
                $questions_array[] = 'Indemnity to principal';
                $answes_array[] = 'Yes';
            }
        }

        if ($pipeline_details['formData']['overtimeWorkCover'] == true) {
            $questions_array[] = 'Including work related accidents and bodily injuries during overtime work, night shifts, work on public holidays and week-ends.';
            $answes_array[] = 'Yes';
        }
        if ($pipeline_details['formData']['lossNotification'] == true) {
            $questions_array[] = 'Loss Notification – ‘as soon as reasonably practicable’';
            $answes_array[] = 'Yes';
        }
        if ($pipeline_details['formData']['primaryInsuranceClause'] == true) {
            $questions_array[] = 'Primary insurance clause';
            $answes_array[] = 'Yes';
        }
        if ($pipeline_details['formData']['travelCover'] == true) {
            $questions_array[] = 'Travelling to and from workplace';
            $answes_array[] = 'Yes';
        }
        if ($pipeline_details['formData']['riotCover'] == true) {
            $questions_array[] = 'Riot, Strikes, civil commotion and Passive war risk';
            $answes_array[] = 'Yes';
        }
        if ($pipeline_details['formData']['brokersClaimClause'] == true) {
            $questions_array[] = 'Brokers Claim Handling Clause : A loss notification received by the Insurance Broker will be deemed as a loss notification to Insurer. All communications flowing between the Insurer, Insured and the appointed Loss Surveyor should be channelized through the Broker, unless there is any unavoidable reasons compelling direct communications between the parties';
            $answes_array[] = 'Yes';
        }
        if ($pipeline_details['formData']['hiredWorkersDetails']['hasHiredWorkers'] == true) {
            $questions_array[] = 'Employment Clause';
            $answes_array[] = 'Yes';
        }
        if ($pipeline_details['formData']['offShoreEmployeeDetails']['hasOffShoreEmployees'] == true) {
            $questions_array[] = 'Cover for offshore employee';
            $answes_array[] = 'Yes';
        }
        if (isset($pipeline_details['formData']['sepOrCom']) && $pipeline_details['formData']['sepOrCom'] == true) {
            if ($pipeline_details['formData']['rateRequiredAdmin'] != "") {
                $questions_array[] = 'Rate required (Admin) (in %)';
                $answes_array[] = $pipeline_details['formData']['rateRequiredAdmin'];
            }
            if ($pipeline_details['formData']['rateRequiredNonAdmin'] != "") {
                $questions_array[] = 'Rate required (Non-Admin) (in %)';
                $answes_array[] = $pipeline_details['formData']['rateRequiredNonAdmin'];
            }
        } elseif (isset($pipeline_details['formData']['sepOrCom']) && $pipeline_details['formData']['sepOrCom'] == false) {
            $questions_array[] = 'Combined Rate (in %)';
            $answes_array[] = $pipeline_details['formData']['combinedRate'];
        }

        $questions_array[] = 'Brokerage (in %)';
        $answes_array[] = $pipeline_details['formData']['brokerage'];
        $questions_array[] = 'Warranty';
        $answes_array[] = $pipeline_details['formData']['warranty'];
        $questions_array[] = 'Exclusion';
        $answes_array[] = $pipeline_details['formData']['exclusion'];
        $questions_array[] = 'Special Condition';
        $answes_array[] = $pipeline_details['formData']['specialCondition'];
        $data[] = ['Questions', 'Customer Response', 'Insurer Response', 'Comments'];
        foreach ($questions_array as $key => $each_question) {
            $question = $each_question;
            $answer = $answes_array[$key];
            $data[] = array(
                $question,
                $answer,
            );
        }
        $file_name_ = 'IIB E-Quotes' . rand();
        Excel::create(
            $file_name_, function ($excel) use ($data) {
                $excel->sheet(
                    'Workmans Compensation', function ($sheet) use ($data) {
                        $sheet->fromArray($data, null, 'A1', true, false);
                        $sheet->row(
                            1, function ($row) {
                                $row->setFontSize(10);
                                $row->setFontColor('#ffffff');
                                $row->setBackground('#1155CC');
                            }
                        );
                        $sheet->protect('password');
                        $sheet->getStyle('C2:D35')->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
                        $sheet->setAutoSize(true);
                        $sheet->setWidth('A', 70);
                        $sheet->getRowDimension(1)->setRowHeight(10);
                        $sheet->setWidth('B', 50);
                        $sheet->getStyle('A0:A32')->getAlignment()->setWrapText(true);
                        $sheet->getStyle('B0:B32')->getAlignment()->setWrapText(true);
                    }
                );
            }
        )->store('xls', public_path('excel'));
        return $file_name_;
    }
    /**
     * insurance company details save
     */
    public function insuranceCompanySave(Request $request)
    {
        $files = $request->input('files');
        $comment = $request->input('txt_comment');
        $pipeline_details = PipelineItems::find($request->input('pipeline_id'));
        $insurance_companies = $request->input('insurance_companies');
        $insurers = [];
        $existing_insures = [];
        $send_type = $request->input('send_type');
        $create_excel = $this->createExcel($pipeline_details);
        $excel_name = $create_excel . '.' . 'xls';
        $send_excel = public_path('/excel/' . $excel_name);
        //        $send_excel=fopen($send_excel1, 'r+');

        if ($send_excel) {
            if (isset($pipeline_details->insuraceCompanyList)) {
                $insurence_company = $pipeline_details->insuraceCompanyList;
                foreach ($insurence_company as $company) {
                    $existing_insures[] = $company['id'];
                }
                if ($send_type == 'send_all') {
                    foreach ($existing_insures as $key => $value) {
                        if (in_array($value, $insurance_companies)) {
                            PipelineItems::where('_id', $request->input('pipeline_id'))->update(array('insuraceCompanyList.' . $key . '.status' => 'resend'));
                        }
                    }

                    foreach ($insurance_companies as $x => $x_value) {
                        $users = User::where('insurer.id', new ObjectID($x_value))->get();
                        $link = url('/');
                        foreach ($users as $user) {
                            if (isset($user->email) && !empty($user->email)) {
                                $type = "Workman's Compensation";
                                EslipSubmittedReminder::dispatch($user->email, $send_excel, $user, $link, $files, $comment, $type);
                            }
                        }
                        $insurer_object = new \stdClass();
                        $insure_list = Insurer::find($x_value);
                        $insures_name = $insure_list->name;
                        $insurer_object->id = new ObjectID($x_value);
                        $insurer_object->status = 'active';
                        $insurer_object->name = $insures_name;
                        $insurers[] = $insurer_object;

                        //                    $insurers[]=new ObjectID($x_value);
                    }
                } elseif ($send_type == 'send_new') {
                    $flg = 0;
                    foreach ($insurance_companies as $x => $x_value) {
                        if (!in_array($x_value, $existing_insures)) {
                            $flg = 1;
                            $users = User::where('insurer.id', new ObjectID($x_value))->get();
                            $link = url('/');
                            foreach ($users as $user) {
                                if (isset($user->email) && !empty($user->email)) {
                                    $type = "Workman's Compensation";
                                    EslipSubmittedReminder::dispatch($user->email, $send_excel, $user, $link, $files, $comment, $type);
                                }
                            }
                            $insurer_object = new \stdClass();
                            $insure_list = Insurer::find($x_value);
                            $insures_name = $insure_list->name;
                            $insurer_object->id = new ObjectID($x_value);
                            $insurer_object->status = 'active';
                            $insurer_object->name = $insures_name;
                            $insurers[] = $insurer_object;
                        }
                    }
                    if ($flg == 0) {
                        return response()->json(['success' => 'failed', 'id' => $request->input('pipeline_id')]);
                    }
                }
            } else {
                foreach ($insurance_companies as $x => $x_value) {
                    $link = url('/');
                    $users = User::where('insurer.id', new ObjectID($x_value))->get();
                    foreach ($users as $user) {
                        if (isset($user->email) && !empty($user->email)) {
                            $type = "Workman's Compensation";
                            EslipSubmittedReminder::dispatch($user->email, $send_excel, $user, $link, $files, $comment, $type);
                        }
                    }
                    $insurer_object = new \stdClass();
                    $insure_list = Insurer::find($x_value);
                    $insures_name = $insure_list->name;
                    $insurer_object->id = new ObjectID($x_value);
                    $insurer_object->status = 'active';
                    $insurer_object->name = $insures_name;
                    $insurers[] = $insurer_object;
                }
            }
            $pipeline_details = PipelineItems::find($request->input('pipeline_id'));
            if ($pipeline_details->status['status'] == 'E-slip') {
                $pipeline_status = PipelineStatus::where('status', 'E-quotation')->first();
                $status_array = array('status.id' => new ObjectID($pipeline_status->_id),
                    'status.status' => (string) $pipeline_status->status,
                    'status.UpdatedById' => new ObjectId(Auth::id()),
                    'status.UpdatedByName' => Auth::user()->name,
                    'status.date' => date('d/m/Y'));
                DB::collection('pipelineItems')->where('_id', new ObjectId($request->input('pipeline_id')))
                    ->update($status_array);
            } elseif ($pipeline_details->status['status'] == 'Quote Amendment' || $pipeline_details->status['status'] == 'Quote Amendment-E-slip') {
                $pipeline_status = PipelineStatus::where('status', 'Quote Amendment-E-quotation')->first();
                $status_array = array('status.id' => new ObjectID($pipeline_status->_id),
                    'status.status' => (string) $pipeline_status->status,
                    'status.UpdatedById' => new ObjectId(Auth::id()),
                    'status.UpdatedByName' => Auth::user()->name,
                    'status.date' => date('d/m/Y'));
                DB::collection('pipelineItems')->where('_id', new ObjectId($request->input('pipeline_id')))
                    ->update($status_array);
            }

            DB::collection('pipelineItems')->where('_id', new ObjectID($request->input('pipeline_id')))
                ->push('insuraceCompanyList', $insurers);
            return response()->json(['success' => 'success', 'id' => $request->input('pipeline_id')]);
        }
    }

    /**
     * e comparison page
     */
    public function eQuotations($pipeline_id)
    {
        $insures_name = [];
        $insures_details = [];
        $insures_id = [];
        $pipeline_details = PipelineItems::find($pipeline_id);
        if ($pipeline_details['status']['status'] == 'Worktype Created' || $pipeline_details['status']['status'] == 'E-questionnaire' || $pipeline_details['status']['status'] == 'E-slip') {
            return view('error');
        }
        if ($pipeline_details->pipelineStatus != "true") {
            return view('error');
        }
        if ($pipeline_details) {
            $selected_insures = $pipeline_details['insuraceCompanyList'];
            if (isset($pipeline_details['insurerReplay'])) {
                $insurerReplay = $pipeline_details['insurerReplay'];
                foreach ($insurerReplay as $insures_rep) {
                    if ($insures_rep['quoteStatus'] == 'active') {
                        $insures_details[] = $insures_rep;
                    }
                }
            }
            foreach ($selected_insures as $insures) {
                if ($insures['status'] == 'active') {
                    $insures_name[] = $insures['name'];
                    $insures_id[] = $insures['id'];
                }
            }

            $selectedIds = $pipeline_details['selected_insurers'];
            if (isset($selectedIds)) {
                foreach ($selectedIds as $ids) {
                    $id_insurer[] = $ids['insurer'];
                }
            } else {
                $id_insurer = [];
            }

            return view('pipelines.workmans_compensation.e_quotations')->with(compact('pipeline_details', 'insures_name', 'insures_details', 'insures_id', 'id_insurer'));
        } else {
            return view('error');
        }
    }

    /**
     * save selected insurers after  e-quotation
     */
    public function saveSelectedInsurers(Request $request)
    {
        $pipeline_details = PipelineItems::find($request->input('pipeline_id'));
        if (isset($pipeline_details['comparisonToken'])) {
            PipelineItems::where('_id', $request->input('pipeline_id'))->
                update(array('comparisonToken.status' => 'active'));
        }
        $checked = $request->input('insure_check');
        //         if($checked!='')
        //         {
        //             if(isset($pipeline_details->selected_insurers))
        //            {
        //
        //            }
        //         }
        //         else{
        //             PipelineItems::where('_id',$request->input('pipeline_id'))->unset('selected_insurers');
        //         }

        if ($checked != '') {
            $selected_insurers = [];
            if (isset($pipeline_details->selected_insurers)) {
                $selectedId = [];
                $alreadySelected = $pipeline_details->selected_insurers;
                foreach ($alreadySelected as $selected) {
                    //                    if($selected['active_insurer']=='1')
                    //                    {
                    $selectedId[] = $selected['insurer'];
                    $selectedStatus[] = $selected['active_insurer'];
                    //                    }
                }
                foreach ($selectedId as $id => $value) {
                    if (!in_array($value, $checked) && ($request->input('is_save') != 'true')) {
                        PipelineItems::where('_id', $request->input('pipeline_id'))->pull('selected_insurers', ['insurer' => $value]);
                    } elseif (in_array($value, $checked) && $request->input('is_save') != 'true') {
                        if ($selectedStatus[$id] == 'inactive') {
                            PipelineItems::where(
                                '_id',
                                $request->input('pipeline_id')
                            )->update(array('selected_insurers.' . $id . '.active_insurer' => 'active'));
                        }
                    }
                }
                foreach ($checked as $x => $x_value) {
                    if (!in_array($x_value, $selectedId)) {
                        $selected_insurersObject = new \stdClass();
                        $selected_insurersObject->insurer = $x_value;
                        if ($request->input('is_save') == 'true') {
                            $selected_insurersObject->active_insurer = 'inactive';
                        } else {
                            $selected_insurersObject->active_insurer = 'active';
                        }
                        $selected_insurers[] = $selected_insurersObject;
                        PipelineItems::where('_id', $request->input('pipeline_id'))
                            ->push('selected_insurers', $selected_insurers);
                    }
                    //                    else{
                    //                        if($request->input('is_save') != 'true') {
                    ////                           if($selectedStatus[$x]=='inactive')
                    ////                           {
                    ////                               PipelineItems::where('_id',
                    ////                                   $request->input('pipeline_id'))->update(array('selected_insurers.' . $x . '.active_insurer' => 'inactive'));
                    ////                           }
                    ////                           if($selectedStatus[$x]=='active')
                    ////                           {
                    ////                               PipelineItems::where('_id',
                    ////                                   $request->input('pipeline_id'))->update(array('selected_insurers.' . $x . '.active_insurer' => 'active'));
                    ////                           }
                    //                            if($selectedStatus[$x]=='inactive') {
                    //                                PipelineItems::where('_id',
                    //                                    $request->input('pipeline_id'))->update(array('selected_insurers.' . $x . '.active_insurer' => 'active'));
                    //                            }
                    //
                    //                        }
                    ////else {
                    ////                            if($selectedStatus[$x]=='active') {
                    ////                                PipelineItems::where('_id',
                    ////                                    $request->input('pipeline_id'))->update(array('selected_insurers.' . $x . '.active_insurer' => 'active'));
                    ////                            }
                    ////
                    ////                        }
                    //                    }
                }
            } else {
                foreach ($checked as $x => $x_value) {
                    $selected_insurersObject = new \stdClass();
                    $selected_insurersObject->insurer = $x_value;
                    if ($request->input('is_save') == 'true') {
                        $selected_insurersObject->active_insurer = 'inactive';
                    } else {
                        $selected_insurersObject->active_insurer = 'active';
                    }
                    $selected_insurers[] = $selected_insurersObject;
                }
                $pipeline_details->selected_insurers = $selected_insurers; //save token of the insurer reply
            }
        } else {
            PipelineItems::where('_id', $request->input('pipeline_id'))->unset('selected_insurers');
        }
        $pipeline_details->save();
        if ($request->input('is_save') == 'true') {
            $updatedBy_obj = new \stdClass();
            $updatedBy_obj->id = new ObjectID(Auth::id());
            $updatedBy_obj->name = Auth::user()->name;
            $updatedBy_obj->date = date('d/m/Y');
            $updatedBy_obj->action = "E quotation saved as draft";
            $updatedBy[] = $updatedBy_obj;
            PipelineItems::where('_id', new ObjectId($request->input('pipeline_id')))->push('updatedBy', $updatedBy);
            return 'success';
        }
        if ($pipeline_details->status['status'] == 'E-quotation') {
            $pipeline_status = PipelineStatus::where('status', 'E-comparison')->first();
            $status_array = array('status.id' => new ObjectID($pipeline_status->_id),
                'status.status' => (string) $pipeline_status->status,
                'status.UpdatedById' => new ObjectId(Auth::id()),
                'status.UpdatedByName' => Auth::user()->name,
                'status.date' => date('d/m/Y'));
            DB::collection('pipelineItems')->where('_id', new ObjectId($request->input('pipeline_id')))
                ->update($status_array);
        } elseif ($pipeline_details->status['status'] == 'Quote Amendment' || $pipeline_details->status['status'] == 'Quote Amendment-E-slip' || $pipeline_details->status['status'] == 'Quote Amendment-E-quotation') {
            $pipeline_status = PipelineStatus::where('status', 'Quote Amendment-E-comparison')->first();
            $status_array = array('status.id' => new ObjectID($pipeline_status->_id),
                'status.status' => (string) $pipeline_status->status,
                'status.UpdatedById' => new ObjectId(Auth::id()),
                'status.UpdatedByName' => Auth::user()->name,
                'status.date' => date('d/m/Y'));
            DB::collection('pipelineItems')->where('_id', new ObjectId($request->input('pipeline_id')))
                ->update($status_array);
        }
        $updatedBy_obj = new \stdClass();
        $updatedBy_obj->id = new ObjectID(Auth::id());
        $updatedBy_obj->name = Auth::user()->name;
        $updatedBy_obj->date = date('d/m/Y');
        $updatedBy_obj->action = "E quotation done";
        $updatedBy[] = $updatedBy_obj;
        PipelineItems::where('_id', new ObjectId($request->input('pipeline_id')))->push('updatedBy', $updatedBy);
        Session::flash('status', 'E-Quotation submitted successfully.');
        return "success";
    }

    /**
     * e comparison view page
     */
    public function eComparison($pipeline_id)
    {
        $insures_details = [];
        $pipeline_details = PipelineItems::find($pipeline_id);
        if ($pipeline_details['status']['status'] == 'Worktype Created' || $pipeline_details['status']['status'] == 'E-questionnaire' || $pipeline_details['status']['status'] == 'E-slip' || $pipeline_details['status']['status'] == 'E-quotation') {
            return view('error');
        }
        if ($pipeline_details->pipelineStatus != "true") {
            return view('error');
        }
        if ($pipeline_details) {
            $insurerReplay = $pipeline_details['insurerReplay'];
            foreach ($insurerReplay as $insures_rep) {
                if ($insures_rep['quoteStatus'] == 'active') {
                    $insures_details[] = $insures_rep;
                }
            }
            $alreadySelected = $pipeline_details->selected_insurers;
            foreach ($alreadySelected as $selected) {
                if ($selected['active_insurer'] == 'active') {
                    $selectedId[] = $selected['insurer'];
                }
            }

            return view('pipelines.workmans_compensation.e_comparison')->with(compact('pipeline_details', 'selectedId', 'insures_details'));
        } else {
            return view('error');
        }
    }

    /*
     * save insurer reply details as excel
     */
    public function saveTemporary(Request $request)
    {
        try {
            // ini_set('xdebug.max_nesting_level', 500);
            $pipeline_id = $request->input('pipelinedetails_id');
            $insurer_id = $request->input('insurer_id');
            if ($request->file('import_excel_file')) {
                $excel_file = $request->file('import_excel_file');

                Excel::load(
                    $excel_file, function ($reader) use ($pipeline_id, $insurer_id) {
                        DB::table('importExcel')->truncate();
                        $excel = new ImportExcel();

                        $uploaded_excel = $reader->each(
                            function ($sheet) {
                                // var_dump($sheet->questions);
                                $questions = $sheet->questions;
                                if ($questions == '') {
                                    echo 2;
                                }
                                $answer = $sheet->insurer_response;
                                $upload_excel_object = new \stdClass();
                                $upload_excel_object->questions = $questions;
                                $upload_excel_object->answer = $answer;
                            }
                        );
                        $details = $uploaded_excel->toArray();
                        $excel->upload = $details;
                        $excel->insurer_id = new ObjectID($insurer_id);
                        $excel->pipeline_id = new ObjectID($pipeline_id);
                        $excel->save();
                    }
                );

                echo 1;
            } else {
                echo 0;
            }
        } catch (\Exception $e) {
            echo 0;
        }
    }

    /**
     * Preview of excel details
     */
    public function ImportedList()
    {
        $data1 = ImportExcel::first();
        $data = $data1['upload'];
        $pipeline_id = $data1['pipeline_id'];
        $insurer_id = $data1['insurer_id'];
        return view('pipelines.workmans_compensation.imported_list', compact('data', 'pipeline_id', 'insurer_id'));
    }

    /**
     * save imported list to pipeline details
     */
    public function saveImportedList(Request $request)
    {
        $pipeline_id = $request->input('pipeline_id');
        $pipeline_details = PipelineItems::find($pipeline_id);
        $insurer_id = $request->input('insurer_id');
        $insurer = Insurer::find($insurer_id);
        $insurer_name = $insurer->name;
        $customer_response_array = $request->input('customer_response');
        $insurer_response_array = $request->input('insurer_response');
        $new_comments__array = $request->input('new_comments');
        $questions = $request->input('questions');
        $insurerReplay_object = new \stdClass();
        $insurerDetails_object = new \stdClass();
        $insurerDetails_object->insurerId = new ObjectId($insurer_id);
        $insurerDetails_object->insurerName = $insurer_name;
        $insurerDetails_object->givenById = new ObjectId(Auth::id());
        $insurerDetails_object->givenByName = 'Under Writer (' . Auth::user()->name . ')';
        $insurerReplay_object->insurerDetails = $insurerDetails_object;
        //        dd($insurerReplay_object);
        ////
        ////        $item->push('insurerReplay.'.$key.'.amendmentDetails' , $amend_object);
        ////        $item->save();
        ////
        //        foreach ($customer_response_array as $question => $each_question) {
        ////            $array_answers[]=array()
        ////            $insurerReplay_object->$question=$insurer_response_array[$question];
        //            $insurerReplay_object->$question=$insurerDetails_object;
        ////            $customer_response_array[]=    $customer_response[$question];
        //        }
        foreach ($questions as $key => $question) {
            if ($question == 'Scale of Compensation /Limit of Indemnity') {
                $insurerReplay_object->scaleOfCompensation = ucwords($insurer_response_array[$key]);
            } elseif ($question == 'Employer’s extended liability under Common Law/Shariah Law') {
                if ($insurer_response_array[$key] >= 0 && $insurer_response_array[$key] <= 100) {
                    $insurerReplay_object->extendedLiability = $insurer_response_array[$key];
                } else {
                    return response()->json(['success' => 'failed', "pipeline_id" => $pipeline_details->_id]);
                }
            } elseif ($question == 'Medical Expense (In AED)') {
                // $insurerReplay_object->medicalExpense = ucwords($insurer_response_array[$key]);
                if ($insurer_response_array[$key] >= 0 && $insurer_response_array[$key] <= 100) {
                    $insurerReplay_object->medicalExpense = $insurer_response_array[$key];
                } else {
                    return response()->json(['success' => 'failed', "pipeline_id" => $pipeline_details->_id]);
                }
            } elseif ($question == 'Repatriation Expenses (Repatriation of mortal remains or injured employee to his/her home country on medical advice) including  expenses of an accompanying person') {
                // $insurerReplay_object->repatriationExpenses = ucwords($insurer_response_array[$key]);
                if ($insurer_response_array[$key] >= 0 && $insurer_response_array[$key] <= 100) {
                    $insurerReplay_object->repatriationExpenses = $insurer_response_array[$key];
                } else {
                    return response()->json(['success' => 'failed', "pipeline_id" => $pipeline_details->_id]);
                }
            } elseif ($question == 'Cover for hired workers or casual labours') {
                $hired_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $hired_object->isAgree = ucwords($insurer_response_array[$key]);
                $hired_object->comment = ucwords($comments);
                $insurerReplay_object->coverHiredWorkers = $hired_object;
            } elseif ($question == 'Cover for offshore employees') {
                $offshore_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $offshore_object->isAgree = ucwords($insurer_response_array[$key]);
                $offshore_object->comment = ucwords($comments);
                $insurerReplay_object->coverOffshore = $offshore_object;
            } elseif ($question == '24 hours non-occupational personal accident cover – in UAE and home country benefits as per UAE Labour Law') {
                $pac_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $pac_object->isAgree = ucwords($insurer_response_array[$key]);
                $pac_object->comment = ucwords($comments);
                $insurerReplay_object->HoursPAC = $pac_object;
            } elseif ($question == 'Cover for hernia, heat/sun stroke, muscle spasm, muscle strain, lumbago related to work') {
                $hernia_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $hernia_object->isAgree = ucwords($insurer_response_array[$key]);
                $hernia_object->comment = ucwords($comments);
                $insurerReplay_object->herniaCover = $hernia_object;
            } elseif ($question == 'Emergency evacuation') {
                $insurerReplay_object->emergencyEvacuation = ucwords($insurer_response_array[$key]);
            } elseif ($question == 'Emergency evacuation following work related accident') {
                $insurerReplay_object->emergencyEvacuation = ucwords($insurer_response_array[$key]);
            } elseif ($question == 'Including Legal and Defence cost') {
                $insurerReplay_object->legalCost = ucwords($insurer_response_array[$key]);
            } elseif ($question == 'Employee to employee liability') {
                $insurerReplay_object->empToEmpLiability = ucwords($insurer_response_array[$key]);
            } elseif ($question == 'Errors & Omissions') {
                $insurerReplay_object->errorsOmissions = ucwords($insurer_response_array[$key]);
            } elseif ($question == 'Cross Liability') {
                $insurerReplay_object->crossLiability = ucwords($insurer_response_array[$key]);
            } elseif ($question == 'Waiver of subrogation') {
                $waiver_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $waiver_object->isAgree = ucwords($insurer_response_array[$key]);
                $waiver_object->comment = ucwords($comments);
                $insurerReplay_object->waiverOfSubrogation = $waiver_object;
            } elseif ($question == 'Automatic addition & deletion Clause') {
                $auto_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $auto_object->isAgree = ucwords($insurer_response_array[$key]);
                $auto_object->comment = ucwords($comments);
                $insurerReplay_object->automaticClause = $auto_object;
            } elseif ($question == 'Cover for insured’s employees on employment visas whilst on incoming and outgoing flights to/from  UAE') {
                $insurerReplay_object->flightCover = ucwords($insurer_response_array[$key]);
            } elseif ($question == 'Cover for occupational/ industrial disease as per Labour Law') {
                $insurerReplay_object->diseaseCover = ucwords($insurer_response_array[$key]);
            } elseif ($question == 'Cancellation clause-30 days by either side on  pro-rata') {
                $insurerReplay_object->cancellationClause = ucwords($insurer_response_array[$key]);
            } elseif ($question == 'Indemnity to principal') {
                $insurerReplay_object->indemnityToPrincipal = ucwords($insurer_response_array[$key]);
            } elseif ($question == 'Including work related accidents and bodily injuries during overtime work, night shifts, work on public holidays and week-ends.') {
                $insurerReplay_object->overtimeWorkCover = ucwords($insurer_response_array[$key]);
            } elseif ($question == 'Loss Notification – ‘as soon as reasonably practicable’') {
                $loss_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $loss_object->isAgree = ucwords($insurer_response_array[$key]);
                $loss_object->comment = ucwords($comments);
                $insurerReplay_object->lossNotification = $loss_object;
            } elseif ($question == 'Primary insurance clause') {
                $insurerReplay_object->primaryInsuranceClause = ucwords($insurer_response_array[$key]);
            } elseif ($question == 'Travelling to and from workplace') {
                $insurerReplay_object->travelCover = ucwords($insurer_response_array[$key]);
            } elseif ($question == 'Riot, Strikes, civil commotion and Passive war risk') {
                $insurerReplay_object->riotCover = ucwords($insurer_response_array[$key]);
            } elseif ($question == 'Brokers Claim Handling Clause : A loss notification received by the Insurance Broker will be deemed as a loss notification to Insurer. All communications flowing between the Insurer, Insured and the appointed Loss Surveyor should be channelized through the Broker, unless there is any unavoidable reasons compelling direct communications between the parties') {
                $broker_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $broker_object->isAgree = ucwords($insurer_response_array[$key]);
                $broker_object->comment = ucwords($comments);
                $insurerReplay_object->brokersClaimClause = $broker_object;
            } elseif ($question == 'Employment Clause') {
                $insurerReplay_object->hiredCheck = ucwords($insurer_response_array[$key]);
            } elseif ($question == 'Cover for offshore employee') {
                $insurerReplay_object->offshoreCheck = ucwords($insurer_response_array[$key]);
            } elseif (isset($pipeline_details['formData']['sepOrCom']) && $pipeline_details['formData']['sepOrCom'] == true && $question == 'Rate required (Admin) (in %)') {
                if ($insurer_response_array[$key] >= 0 && $insurer_response_array[$key] <= 100) {
                    $insurerReplay_object->rateRequiredAdmin = $insurer_response_array[$key];
                } else {
                    return response()->json(['success' => 'failed', "pipeline_id" => $pipeline_details->_id]);
                }
            } elseif (isset($pipeline_details['formData']['sepOrCom']) && $pipeline_details['formData']['sepOrCom'] == true && $question == 'Rate required (Non-Admin) (in %)') {
                if ($insurer_response_array[$key] >= 0 && $insurer_response_array[$key] <= 100) {
                    $insurerReplay_object->rateRequiredNonAdmin = $insurer_response_array[$key];
                } else {
                    return response()->json(['success' => 'failed', "pipeline_id" => $pipeline_details->_id]);
                }
            } elseif (isset($pipeline_details['formData']['sepOrCom']) && $pipeline_details['formData']['sepOrCom'] == false && $question == 'Combined Rate (in %)') {
                if ($insurer_response_array[$key] >= 0 && $insurer_response_array[$key] <= 100) {
                    $insurerReplay_object->combinedRate = $insurer_response_array[$key];
                } else {
                    return response()->json(['success' => 'failed', "pipeline_id" => $pipeline_details->_id]);
                }
            } elseif ($question == 'Brokerage (in %)') {
                if ($insurer_response_array[$key] >= 0 && $insurer_response_array[$key] <= 100) {
                    $insurerReplay_object->brokerage = $insurer_response_array[$key];
                } else {
                    return response()->json(['success' => 'failed', "pipeline_id" => $pipeline_details->_id]);
                }
            } elseif ($question == 'Warranty') {
                $insurerReplay_object->warranty = ucwords($insurer_response_array[$key]);
            } elseif ($question == 'Exclusion') {
                $insurerReplay_object->exclusion = ucwords($insurer_response_array[$key]);
            } elseif ($question == 'Excess') {
                $insurerReplay_object->excess = ucwords($insurer_response_array[$key]);
            } elseif ($question == 'Special Condition') {
                $insurerReplay_object->specialCondition = ucwords($insurer_response_array[$key]);
            } else {
                dd($insurer_response_array[$key]);
            }
        }
        $insurerReplay_object->quoteStatus = (string) "active";
        $insurerReplay_object->repliedMethod = (string) "excel";
        $insurerReplay_object->repliedDate = (string) date('d/m/Y');
        $insurerReplay_object->uniqueToken = (string) time() . rand(1000, 9999);
        $insurerData[] = $insurerReplay_object;
        $pipeline_details->push('insurerReplay', $insurerData);

        $existing_insures = $pipeline_details->insuraceCompanyList;
        foreach ($existing_insures as $key => $value) {
            if ($insurer_id == $value['id'] && $value['status'] == 'active') {
                PipelineItems::where('_id', $pipeline_id)->update(array('insuraceCompanyList.' . $key . '.status' => 'inactive'));
            }
        }
        $pipeline_details->save();
        Session::flash('msg', 'Excel uploaded successfully.');
        return response()->json(['success' => 'success', "pipeline_id" => $pipeline_details->_id]);
    }

    /**
     * get active case manager details
     */
    public function getActiveCaseManager(Request $request)
    {
        $flag = 1;
        $casemanager_id = $request->input('caseManager');
        //        $casemanager_id='5b34b6ef3c63021e3c9698df';

        $current_date = date('d/m/Y');
        $current_date_time = str_replace('/', '-', $current_date);
        $newformat = strtotime($current_date_time);
        $tilldate = $newformat;
        $leave_details = LeavesDetails::where('userDetails.id', new ObjectID($casemanager_id))->get();
        foreach ($leave_details as $leave) {
            $leaveto = $leave->leaveTo;
            $db_to_date = str_replace('/', '-', $leaveto);
            $db_to_date_newformat = strtotime($db_to_date);

            $leavefrom = $leave->leaveFrom;
            $db_from_date = str_replace('/', '-', $leavefrom);
            $db_from_date_newformat = strtotime($db_from_date);
            if ($db_to_date_newformat >= $newformat && $db_from_date_newformat <= $newformat) {
                $flag = 0;
                if ($db_to_date_newformat > $tilldate) {
                    $tilldate = $db_to_date_newformat;
                }
            }
        }
        if ($flag == 1) {
            return response()->json(['status' => 'present']);
        } elseif ($flag == 0) {
            return response()->json(['status' => 'leave', 'leave_date' => date('d/m/Y', $tilldate)]);
        }
    }

    /**
     * Functon for save account details in approved e quotes
     */
    public function saveAccounts(Request $request)
    {
        $id = $request->input('pipeline_id');
        $pipelineItem = PipelineItems::find($id);
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
        if ($request->input('is_save') != 'true') {
            if ($request->input('page') == 'issuance') {
                $requestedApproval = new \stdClass();
                $requestedApproval->id = new ObjectId(Auth::id());
                $requestedApproval->name = Auth::user()->name;
                $requestedApproval->date = date('d/m/Y');
                PipelineItems::where('_id', $id)->update(array('pipelineStatus' => 'pending', 'accountsDetails.requestedForApproval' => $requestedApproval));
                $item = PipelineItems::where('_id', $id)->first();
                $updatedBy_obj = new \stdClass();
                $updatedBy_obj->id = new ObjectID(Auth::id());
                $updatedBy_obj->name = Auth::user()->name;
                $updatedBy_obj->date = date('d/m/Y');
                $updatedBy_obj->action = "Issuance Completed";
                $updatedBy[] = $updatedBy_obj;
                $item->push('updatedBy', $updatedBy);
                $item->save();
            } elseif ($request->input('page') == 'pending') {
                PipelineItems::where('_id', $id)->update(array('pipelineStatus' => 'approved'));
                $item = PipelineItems::where('_id', $id)->first();
                $updatedBy_obj = new \stdClass();
                $updatedBy_obj->id = new ObjectID(Auth::id());
                $updatedBy_obj->name = Auth::user()->name;
                $updatedBy_obj->date = date('d/m/Y');
                $updatedBy_obj->action = "Approved";
                $updatedBy[] = $updatedBy_obj;
                $item->push('updatedBy', $updatedBy);
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
                PipelineItems::where('_id', $id)->update(array('pipelineStatus' => 'issuance', 'insurerResponse.mailStatus' => 'active', 'insurerResponse.response' => ''));
                $pipeline_details = PipelineItems::where('_id', $id)->first();
                $insurerReplay = $pipeline_details['insurerReplay'];
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
                    if (isset($email) && !empty($email)) {
                        IssuanceProposal::dispatch($name, $email, $customer_name, $link, $workType);
                    }
                }
                $item = PipelineItems::where('_id', $id)->first();
                $updatedBy_obj = new \stdClass();
                $updatedBy_obj->id = new ObjectID(Auth::id());
                $updatedBy_obj->name = Auth::user()->name;
                $updatedBy_obj->date = date('d/m/Y');
                $updatedBy_obj->action = "Approved e quot filled";
                $updatedBy[] = $updatedBy_obj;
                $item->push('updatedBy', $updatedBy);
                $item->save();
            }
        } else {
            $item = PipelineItems::where('_id', $id)->first();
            $updatedBy_obj = new \stdClass();
            $updatedBy_obj->id = new ObjectID(Auth::id());
            $updatedBy_obj->name = Auth::user()->name;
            $updatedBy_obj->date = date('d/m/Y');
            $updatedBy_obj->action = "Accounts saved as draft";
            $updatedBy[] = $updatedBy_obj;
            $item->push('updatedBy', $updatedBy);
            $item->save();
        }
        return 'success';
        // } catch (\Exception $e) {
        //     return 'failed';
        // }
    }
    /**
     * Function for display issuance page
     */
    public function issuance($pipelineId)
    {
        $pipeline_details = PipelineItems::find($pipelineId);
        if ($pipeline_details['status']['status'] == 'Worktype Created' || $pipeline_details['status']['status'] == 'E-questionnaire' || $pipeline_details['status']['status'] == 'E-slip' || $pipeline_details['status']['status'] == 'E-quotation'
            || $pipeline_details['status']['status'] == 'Quote Amendment' || $pipeline_details['status']['status'] == 'E-comparison'
        ) {
            return view('error');
        }
        if ($pipeline_details->pipelineStatus != "issuance") {
            return view('error');
        }
        if ($pipeline_details) {
            $insurerReplay = $pipeline_details['insurerReplay'];
            foreach ($insurerReplay as $insures_rep) {
                if (isset($insures_rep['customerDecision'])) {
                    if ($insures_rep['quoteStatus'] == 'active' && $insures_rep['customerDecision']['decision'] == 'Approved') {
                        $insures_details = $insures_rep;
                        break;
                    }
                }
            }
            return view('pipelines.workmans_compensation.issuance')->with(compact('pipelineId', 'pipeline_details', 'insures_details'));
        }
    }

    /**
     * Function for complete the issuance in issuance page
     */
    public function issuanceComplete(Request $request)
    {
        $id = $request->get('id');
        $requestedApproval = new \stdClass();
        $requestedApproval->id = new ObjectId(Auth::id());
        $requestedApproval->name = Auth::user()->name;
        $requestedApproval->date = date('d/m/Y');
        PipelineItems::where('_id', $id)->update(array('pipelineStatus' => 'pending', 'accountsDetails.requestedForApproval' => $requestedApproval));
        $item = PipelineItems::where('_id', $id)->first();
        $updatedBy_obj = new \stdClass();
        $updatedBy_obj->id = new ObjectID(Auth::id());
        $updatedBy_obj->name = Auth::user()->name;
        $updatedBy_obj->date = date('d/m/Y');
        $updatedBy_obj->action = "Issuance Completed";
        $updatedBy[] = $updatedBy_obj;
        $item->push('updatedBy', $updatedBy);
        $item->save();
        return 'success';
    }

    /**
     * close the pipeline
     */
    public function closePipeline(Request $request)
    {
        $id = $request->get('id');
        $item = WorkTypeData::find($id);
        $oldStatus=$item->pipelineStatus;
        $updatedBy_obj = new \stdClass();
        $updatedBy_obj->id = new ObjectID(Auth::id());
        $updatedBy_obj->name = Auth::user()->name;
        $updatedBy_obj->date = date('d/m/Y');
        $updatedBy_obj->action = "Close the lead";
        $updatedBy[] = $updatedBy_obj;
        $item->push('updatedBy', $updatedBy);
        $item->prevPiplineStatus=$oldStatus;
        $item->save();
        WorkTypeData::where('_id', $id)->update(array('pipelineStatus' => 'Closed'));
        Session::flash('status', 'Closed successfully.');
        return 'success';
    }
}
