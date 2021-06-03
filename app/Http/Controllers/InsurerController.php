<?php

namespace App\Http\Controllers;

use App\CaseManager;
use App\Customer;
use App\Jobs\QuoteFilledInformationInsurer;
use App\Jobs\QuoteFilledInformationUnderwriter;
use App\PipelineItems;
use App\PipelineStatus;
use App\WorkTypeData;
use App\ESlipFormData;
use App\User;
use App\Insurer;
use App\WorkType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use MongoDB\BSON\ObjectId;
use PDF;

class InsurerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.insurer');
    }

    /**
     * dashboard insurer login
     */
    public function dashboard()
    {
        $insurerId = new ObjectId(Auth::user()->insurer['id']);
        $total_quots = WorkTypeData::where('pipelineStatus', "true")
            ->where('insurerList', 'elemMatch', array('id' => $insurerId, 'status'=>'active'))
            ->where('status.status', '!=', 'Approved E Quote')->where('status.status', '!=', 'Issuance')->count();
        $total_given = WorkTypeData::where('insurerList.id', '=', $insurerId)->where('pipelineStatus', "true")
            ->where('insurerReply', 'elemMatch', array('insurerDetails.insurerId' => $insurerId, 'quoteStatus' => 'active'))->count();

        return view('insurer.dashboard')->with(compact('total_quots', 'total_given'));
    }
    private function passwordCorrect($suppliedPassword)
    {
        return Hash::check($suppliedPassword, Auth::user()->password, []);
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
            return response()->json(
                [
                'success' => true,
                'message' => 'Password updated successfully',
                ]
            );
        } else {
            return response()->json(
                [
                'success' => false,
                'message' => 'Incorrect old password',
                ]
            );
        }
    }

    /**
     * view e quotes
     */
    public function equotesProviderView(Request $request)
    {
        $filter_data = $request->input();
        $mainGroups = Customer::where('mainGroup.id', '0')->get();
        $workTypes = WorkType::get();
        $caseManagers = User::where('isActive', 1)->where(
            function ($q) {
                $q->where('role', 'EM')->orWhere('role', 'AD');
            }
        )->get();
        $agents = User::where('isActive', 1)->where('role', 'AG')->get();
        $status = PipelineStatus::get();
        $customers = Customer::select('_id', 'fullName')->where('status', (int) 1)->get();

        return view('insurer.equotes_provider')->with(compact('customers', 'status', 'filter_data', 'mainGroups', 'workTypes', 'caseManagers', 'agents'));
    }

    //    public function equoteDetailsView($pipelineId)
    //    {
    //        return view('insurer.equote_details');
    //    }

    /**
     * view given e quotes
     */
    public function equotesGivenView(Request $request)
    {
        $filter_data = $request->input();
        $mainGroups = Customer::where('mainGroup.id', '0')->get();
        $workTypes = WorkType::get();
        $caseManagers = User::where('isActive', 1)->where(
            function ($q) {
                $q->where('role', 'EM')->orWhere('role', 'AD');
            }
        )->get();
        $agents = User::where('isActive', 1)->where('role', 'AG')->get();
        $status = PipelineStatus::get();
        $customers = Customer::select('_id', 'fullName')->where('status', (int) 1)->get();

        return view('insurer.equotes_given')->with(compact('customers', 'filter_data', 'status', 'mainGroups', 'workTypes', 'caseManagers', 'agents'));
    }

    /**
     * Function for fill the data table in e quots provider
     */
    public function fillDatatable(Request $request)
    {
        $insurerId = new ObjectId(Auth::user()->insurer['id']);
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $filter = $request->input('search');
        $quots = WorkTypeData::where('pipelineStatus', "true")
        ->where('insurerList', 'elemMatch', array('id' => $insurerId,'status'=>'active'))
        ->where('status.status', '!=', 'Approved E Quote')->where('status.status', '!=', 'Issuance');
        $search = (isset($filter['value'])) ? $filter['value'] : false;
        $searchField = $request->input('searchField');
        $sortField = $request->input('field');
        // dd($sortField);
        session()->put('filter', $request->input('filterData'));
        session()->put('sort', $sortField);

        $filterData = json_decode($request->input('filterData'));
        /**
         * Condition for filtering
         */
        if ($filterData) {
            foreach ($filterData as $key => $value) {
                $val_array = [];
                foreach ($value as $val) {
                    if ($val == "Nil") {
                        $val_array[] = (string) 0;
                    }
                    if ($val != '0' && $val != 'Nil') {
                        $val_array[] = new ObjectID($val);
                    }
                }

                if (count($val_array) > 0) {
                    $quots = $quots->whereIn($key, $val_array);
                }
            }
        }

        /**
         * Condition for sorting
         */
        if ($sortField) {
            if ($sortField == "Category") {
                $quots = $quots->orderBy('workTypeId.name');
            } elseif ($sortField == "Main Group") {
                $quots = $quots->orderBy('customer.maingroupName');
            } elseif ($sortField == "Customer Name") {
                $quots = $quots->orderBy('customer.name');
            } elseif ($sortField == "Case Manager") {
                $quots = $quots->orderBy('caseManager.name');
            } elseif ($sortField == "Last Updated By") {
                $quots = $quots->orderBy('updatedBy.name');
            } elseif ($sortField == "Last Updated At") {
                $quots = $quots->orderBy('updated_at', 'desc');
            } elseif ($sortField == "Status") {
                $quots = $quots->orderBy('status.status');
            } elseif ($sortField == "Agent") {
                $quots = $quots->orderBy('agent.name');
            } else {
                $quots = $quots->orderBy('updated_at', 'desc');
            }
        } else {
            $quots = $quots->orderBy('updated_at', 'desc');
        }
        /**
         * Condition for searching
         */
        if ($search) {
            session()->put('search_provide', $search);
            $quots = $quots->where(
                function ($query) use ($search) {
                    $query->where('customer.name', 'like', '%' . $search . '%')
                        ->orWhere('workTypeId.name', 'like', '%' . $search . '%')
                        ->orWhere('customer.maingroupName', 'like', '%' . $search . '%')
                        ->orWhere('caseManager.name', 'like', '%' . $search . '%')
                        ->orWhere('status.status', 'like', '%' . $search . '%');
                }
            );
        }
        if ($search == "") {
            session()->put('search_provide', "");
        }
        $total_items = $quots->count(); // get your total no of data;
        $members_query = $quots;
        $search_count = $members_query->count();
        $quots->skip((int) $start)->take((int) $length);
        $finalQuots = $quots->get();
        $q = [];
        foreach ($finalQuots as $quot) {
            $action = '<a href="' . URL::to('insurer/e-quote-details/' . $quot->_id) . '" class="btn btn-sm btn-success" style="font-weight: 600">View Details</a>';
            $name = $quot->customer['name'];
            $category = $quot->workTypeId['name'];
            $maingroup = $quot->customer['maingroupName'];
            $case_manager = $quot->caseManager['name'];
            $update = $quot->updatedBy;
            //                $lastUpdate = end($update);
            //                $updated_by = $lastUpdate['name'];
            //                $updatedAt = $quot->updated_at;
            //                $date = Carbon::parse($updatedAt)->format('d-m-Y');
            $status = $quot->status['status'];
            //                $agent = $quot->agent['name'];

            $qw = new \stdClass();
            $qw->category = $category;
            $qw->maingroup = $maingroup;
            $qw->customer_name = $name;
            $qw->case_manager = $case_manager;
            //                $qw->updated_by = $updated_by;
            //                $qw->updatedAt = $date;
            $qw->status = $status;
            //                $qw->agent = $agent;
            $qw->action = $action;
            $q[] = $qw;
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
            'data' => $q,
        );
        return json_encode($data);
    }
    /**
     * Function for display e quote form
     */
    public function quoteDetails($workTypeDataId)
    {
        $insurerId = new ObjectId(Auth::user()->insurer['id']);
        $workTypeId = '';
        $values = '';
        $data = WorkTypeData::find(new ObjectId($workTypeDataId));
        $formValues= $data;
        $equestionnaire = $formValues['eQuestionnaire'];
        $formData = [];
        if (!empty($equestionnaire)) {
            foreach ($equestionnaire as $step => $value) {
                foreach ($value as $key => $val) {
                    $formData[$key] = $val;
                }
            }
        }
        $uploadedFiles = @$formValues['files'];
        //$result = ESlipFormData::find($eslipDataId);
        $replies = @$data['insurerReply']?:[];
        $insurerReply = "";
        $token = "";
        if (isset($data['insurerReply'])) {
            foreach ($replies as $reply) {
                if ($reply['insurerDetails']['insurerId'] == $insurerId && $reply['quoteStatus'] == 'saved') {
                    $insurerReply = $reply;
                    $token=@$insurerReply['uniqueToken'];
                    break;
                }
            }
        }
        $title = 'E-quotes to be Provided';
        //echo 'here';
        return view('pages.insurer_view')->with(compact('data', 'token', 'uploadedFiles', 'title', 'workTypeId', 'insurerReply', 'values', 'workTypeDataId', 'formValues', 'formData'));
    }
    /**
     * Function for display e quote form
     */
    public function amendDetails($workTypeDataId, $uniqueToken)
    {

        $insurerId = new ObjectId(Auth::user()->insurer['id']);
        $data = WorkTypeData::find(new ObjectId($workTypeDataId));
        $formValues= $data;
        $equestionnaire = $formValues['eQuestionnaire'];
        $formData = [];
        if (!empty($equestionnaire)) {
            foreach ($equestionnaire as $step => $value) {
                foreach ($value as $key => $val) {
                    $formData[$key] = $val;
                }
            }
        }
        $uploadedFiles = @$formValues['files'];
        //$result = ESlipFormData::find($eslipDataId);
        $replies = @$data['insurerReply']?:[];
        $insurerReply = "";
        $token = "";
        if (isset($data['insurerReply'])) {
            foreach ($replies as $reply) {
                if ($reply['insurerDetails']['insurerId'] == $insurerId && $reply['quoteStatus'] == 'active') {
                    if (@$reply['uniqueToken'] == $uniqueToken) {
                        $insurerReply = $reply;
                        $token=$insurerReply['uniqueToken'];
                        break;
                    }
                }
            }
        }
        $title = 'E-quotes Given';
        //echo 'here';
        return view('pages.insurer_view')->with(compact('data', 'uploadedFiles', 'token', 'title', 'workTypeId', 'insurerReply', 'values', 'workTypeDataId', 'formValues', 'formData'));
    }


    /**
     * Quotation save as draft
     */
    public function saveAsDraftAndExit(Request $request)
    {
        try {
            $workTypeData = WorkTypeData::find(new ObjectId($request->input('workTypeDataId')));
            $data = $request->post();
            $insurerId = new ObjectId(Auth::user()->insurer['id']);
            $insurer = Insurer::find($insurerId);
            $pipeLineItems = WorkTypeData::where('_id', new ObjectId($request->input('workTypeDataId')))->first();
            WorkTypeData::where('_id', new ObjectId($request->input('workTypeDataId')))
            ->pull('insurerReply', ['insurerDetails.insurerId' => $insurerId, 'quoteStatus' => 'saved']);
            $insurer_name = $insurer->name;
            $insurerDetails_object = new \stdClass();
            $insurerDetails_object->insurerId = new ObjectId($insurerId);
            $insurerDetails_object->insurerName = $insurer_name;
            $insurerDetails_object->givenById = new ObjectId(Auth::id());
            $insurerDetails_object->givenByName = 'Under Writer (' . Auth::user()->name . ')';
            $data['insurerDetails'] = $insurerDetails_object;
            $stage = $data['stage'];
            unset($data['_token']);
            unset($data['workTypeDataId']);
            unset($data['stage']);
            $data['quoteStatus'] = (string) "saved";
            $updatedBy = new \stdClass();
            $updatedBy->id = new ObjectId(Auth::id());
            $updatedBy->name = Auth::user()->insurer['name'] . ' (' . Auth::user()->name . ')';
            $updatedBy->date = date('d/m/Y');
            $updatedBy->action = "Equotation saved and exit";
            $updatedByarray[] = $updatedBy;
            $pipeLineItems->push('updatedBy', $updatedByarray);
            $pipeLineItems->push('insurerReply', $data);
            $pipeLineItems->save();
            Session::flash('success', 'E-Quote saved successfully');
            return 'success';
        } catch (\Exception $e) {
            Session::flash('failed', 'E-quote does not saved');
            return 'failed';
        }
    }




    public function saveInsurerResponse(Request $request)
    {
        // dd($request);
        $workTypeData = WorkTypeData::find(new ObjectId($request->input('workTypeDataId')));

        $data = $request->post();
        $insurerId = new ObjectId(Auth::user()->insurer['id']);
        $insurer = Insurer::find($insurerId);
        if ($request->input('quoteActive') == 'true') {
            $replies = $workTypeData['insurerReply'];
            foreach ($replies as $count => $reply) {
                if ($reply['insurerDetails']['insurerId'] == $insurerId && $reply['quoteStatus'] == 'active' && $reply['uniqueToken'] == $request->input('hiddenToken')) {
                    if(@$reply['customerDecision']['decision']=="Requested for amendment"){

                    }else{
                        WorkTypeData::where('_id', new ObjectId($request->input('workTypeDataId')))
                        ->where(['insurerReply.' . $count .'.uniqueToken'=> @$reply['uniqueToken']])
                        ->update(array('insurerReply.' . $count . '.quoteStatus' => 'inactive'));
                    }

                }
            }
        } else {
            WorkTypeData::where('_id', new ObjectId($request->input('workTypeDataId')))
            ->pull('insurerReply', ['insurerDetails.insurerId' => $insurerId, 'quoteStatus' => 'saved']);
        }
        if ($request->input('quoteActive') == 'true') {
            $updatedBy = new \stdClass();
            $updatedBy->id = new ObjectId(Auth::id());
            $updatedBy->name = Auth::user()->insurer['name'] . ' (' . Auth::user()->name . ')';
            $updatedBy->date = date('d/m/Y');
            $updatedBy->action = "E quote amended";
            $updatedByarray[] = $updatedBy;
            $workTypeData->push('updatedBy', $updatedByarray);
        } else {
            $updatedBy = new \stdClass();
            $updatedBy->id = new ObjectId(Auth::id());
            $updatedBy->name = Auth::user()->insurer['name'] . ' (' . Auth::user()->name . ')';
            $updatedBy->date = date('d/m/Y');
            $updatedBy->action = "E quote gave";
            $updatedByarray[] = $updatedBy;
            $workTypeData->push('updatedBy', $updatedByarray);
        }
        $insurer_name = $insurer->name;
        $insurerDetails_object = new \stdClass();
        $insurerDetails_object->insurerId = new ObjectId($insurerId);
        $insurerDetails_object->insurerName = $insurer_name;
        $insurerDetails_object->givenById = new ObjectId(Auth::id());
        $insurerDetails_object->givenByName = 'Under Writer (' . Auth::user()->name . ')';
        $data['insurerDetails'] = $insurerDetails_object;
        $stage = $data['stage'];
        unset($data['_token']);
        unset($data['workTypeDataId']);
        unset($data['stage']);
        unset($data['quoteActive']);
        unset($data['hiddenToken']);
        $data['quoteStatus'] = 'active';
        $data['repliedDate'] = (string) date('d/m/Y');
        $uniqueToken = (string) time() . rand(1000, 9999);
        $data['uniqueToken'] =$uniqueToken;
        $data['repliedMethod'] = (string) "insurer";
        $insReply[] = $data;
        if ($workTypeData->insurerReply) {
            $workTypeData->push('insurerReply', $insReply);
            if ($request->input('quoteActive') == 'false') {
                $array[] = new ObjectId(Auth::user()->insurer['id']);
            }
            $workTypeData->save();
        } else {
            $workTypeData->insurerReply = $insReply;
            if ($request->input('quoteActive') == 'false') {
                $array[] = new ObjectId(Auth::user()->insurer['id']);
            }
            $workTypeData->save();
        }
        if ($request->input('quoteActive') == 'false') {
            $count = 0;
            $insurers_repeat = $workTypeData->insurerList;
            foreach ($insurers_repeat as $temp) {
                //dd($temp);
                if ($temp["id"] == $insurerId && $temp['status'] == 'active') {
                    WorkTypeData::where('_id', new ObjectId($request->input('workTypeDataId')))
                    ->update(array('insurerList.' . $count . '.status' => 'inactive'));
                    break;
                }
                $count++;
            }
        }
        $mail =  $this->mailSend($request->input('workTypeDataId'));
        //    return $mail;
        //    dd($mail);
        // WorkTypeData::where('_id', new ObjectId($request->input('workTypeDataId')))->pull('insurerReply', ['insurerDetails.insurerId' => $insurerId]);
        // $workTypeData->refresh();
        // $insReply = $workTypeData->insurerReply?:[];
        // $insReply[] = $data;
        // $workTypeData->insurerReply = $insReply;
        // $workTypeData->save();
        Session::flash('quotation', "E-Quote $stage  Successfully");
        return 'success';


    }




    /**
     * Function for display e quote form
     */
    public function quoteDeatailsBackup($pipeLineId)
    {
        $insurerId = new ObjectId(Auth::user()->insurer['id']);
        $pipeline_items = ESlipFormData::where('_id', $pipeLineId)->where('insurerList.id', '=', new ObjectId(Auth::user()->insurer['id']))->first();
        if (!$pipeline_items) {
            Session::flash('error', 'Pipeline not defined');
            return redirect('insurer/e-quotes-provider');
        }
        $result = ESlipFormData::where('_id', $pipeLineId)->first();
        $replies = $result['insurerReplay'];
        $insurerReply = "";
        if (isset($result['insurerReplay'])) {
            foreach ($replies as $reply) {
                if ($reply['insurerDetails']['insurerId'] == $insurerId && $reply['quoteStatus'] == 'saved') {
                    $insurerReply = $reply;
                    break;
                }
            }
        }
        $token = "";
        $formData = $pipeline_items->formData;
        $pipeline_details = $pipeline_items;
        $pipelineStatus = $pipeline_items['status']['status'];
        if ($pipeline_items->workTypeId['name'] == "Workman's Compensation") {
            return view('insurer.e_quotation')->with(compact('formData', 'pipeLineId', 'insurerReply', 'token', 'pipelineStatus'));
        } elseif ($pipeline_items->workTypeId['name'] == "Employers Liability") {
            return view('insurer.employee_e_quotation')->with(compact('formData', 'pipeLineId', 'insurerReply', 'token', 'pipelineStatus'));
        } elseif ($pipeline_items->workTypeId['name'] == "Money") {
            return view('insurer.money_e_quotation')->with(compact('formData', 'pipeLineId', 'insurerReply', 'token', 'pipelineStatus'));
        } elseif ($pipeline_items->workTypeId['name'] == "Property") {
            return view('insurer.property_quotation')->with(compact('formData', 'pipeLineId', 'insurerReply', 'token', 'pipelineStatus', 'pipeline_details'));
        } elseif ($pipeline_items->workTypeId['name'] == "Fire and Perils") {
            return view('insurer.fireperils_e_quotation')->with(compact('formData', 'pipeLineId', 'insurerReply', 'token', 'pipelineStatus', 'pipeline_details'));
        } elseif ($pipeline_items->workTypeId['name'] == "Business Interruption") {
            return view('insurer.business_e_quotation')->with(compact('formData', 'pipeLineId', 'insurerReply', 'token', 'pipelineStatus', 'pipeline_details'));
        } elseif ($pipeline_items->workTypeId['name'] == "Machinery Breakdown") {
            return view('insurer.machinery_e_quotation')->with(compact('formData', 'pipeLineId', 'insurerReply', 'token', 'pipelineStatus', 'pipeline_details'));
        } elseif ($pipeline_items->workTypeId['name'] == "Contractor`s Plant and Machinery") {
            return view('insurer.plant_e_quotation')->with(compact('formData', 'pipeLineId', 'insurerReply', 'token', 'pipelineStatus', 'pipeline_details'));
        }
    }

    /**
     * save the reply provided by insurer
     */
    public function replySave(Request $request)
    {
        try {
            $insurerId = new ObjectId(Auth::user()->insurer['id']);
            $pipeLineId = $request->input('id');
            $pipeLineItems = PipelineItems::where('_id', $pipeLineId)->first();
            if (!$pipeLineItems) {
                Session::flash('error', 'Pipeline not defined');
                return "failed";
            }
            if ($request->input('quoteActive') == 'true') {
                $replies = $pipeLineItems['insurerReplay'];
                foreach ($replies as $count => $reply) {
                    if ($reply['insurerDetails']['insurerId'] == $insurerId && $reply['quoteStatus'] == 'active' && $reply['uniqueToken'] == $request->input('hiddenToken')) {
                        PipelineItems::where('_id', $pipeLineId)->update(array('insurerReplay.' . $count . '.quoteStatus' => 'inactive'));
                    }
                }
            } else {
                PipelineItems::where('_id', $pipeLineId)->pull('insurerReplay', ['insurerDetails.insurerId' => $insurerId, 'quoteStatus' => 'saved']);
            }
            $insurerReplay_object = new \stdClass();
            $insurerDetails_object = new \stdClass();
            $insurerDetails_object->insurerId = new ObjectId(Auth::user()->insurer['id']);
            $insurerDetails_object->insurerName = Auth::user()->insurer['name'];
            $insurerDetails_object->givenById = new ObjectId(Auth::id());
            $insurerDetails_object->givenByName = Auth::user()->name;
            $insurerReplay_object->insurerDetails = $insurerDetails_object;

            $insurerReplay_object->scaleOfCompensation = (string) $request->input('d_scale');
            if ($request->input('select_liability') == "option_other1") {
                $insurerReplay_object->extendedLiability = (string) $request->input('other_liability');
            } else {
                $insurerReplay_object->extendedLiability = (string) str_replace(',', '', $request->input('select_liability'));
            }
            if ($request->input('medical_expense') == "option_other2") {
                $insurerReplay_object->medicalExpense = (string) str_replace(',', '', $request->input('other_medical_expense'));
            } else {
                $insurerReplay_object->medicalExpense = (string) str_replace(',', '', $request->input('medical_expense'));
            }
            if ($request->input('repatriation_expenses') == "option_other3") {
                $insurerReplay_object->repatriationExpenses = (string) $request->input('other_repatriation_expenses');
            } else {
                $insurerReplay_object->repatriationExpenses = (string) str_replace(',', '', $request->input('repatriation_expenses'));
            }
            if ($pipeLineItems->formData['hiredWorkersDetails']['hasHiredWorkers'] == true) {
                $coverHiredWorkers = new \stdClass();
                $coverHiredWorkers->isAgree = (string) $request->input('hired_labours');
                $coverHiredWorkers->comment = (string) $request->input('hired_workers_comment');
                $insurerReplay_object->coverHiredWorkers = $coverHiredWorkers;
            }

            if ($pipeLineItems->formData['offShoreEmployeeDetails']['hasOffShoreEmployees'] == true) {
                $coverOffshore = new \stdClass();
                $coverOffshore->isAgree = (string) $request->input('offshore_employee');
                $coverOffshore->comment = (string) $request->input('offshore_comment');
                $insurerReplay_object->coverOffshore = $coverOffshore;
            }
            if ($pipeLineItems->formData['herniaCover'] == true) {
                $coverForHernia_object = new \stdClass();
                $coverForHernia_object->isAgree = (string) $request->input('d_cover_hernia');
                $coverForHernia_object->comment = (string) $request->input('cover_hernia_comment');
                $insurerReplay_object->herniaCover = $coverForHernia_object;
            }

            if ($pipeLineItems->formData['HoursPAC'] == true) {
                $personalAccidentCover_object = new \stdClass();
                $personalAccidentCover_object->isAgree = (string) $request->input('d_non_occupational');
                $personalAccidentCover_object->comment = (string) $request->input('non_occupational_comment');
                $insurerReplay_object->HoursPAC = $personalAccidentCover_object;
            }
            if (isset($pipeLineItems->formData['waiverOfSubrogation'])) {
                // if ($pipeLineItems->formData['waiverOfSubrogation'] == true) {
                $waiverSubrogation_object = new \stdClass();
                $waiverSubrogation_object->isAgree = (string) $request->input('d_waiver');
                $waiverSubrogation_object->comment = (string) $request->input('waiver_comment');
                $insurerReplay_object->waiverOfSubrogation = $waiverSubrogation_object;
                // }
            }
            if ($pipeLineItems->formData['automaticClause'] == true) {
                $automaticClause_object = new \stdClass();
                $automaticClause_object->isAgree = (string) $request->input('d_automatic_addition');
                $automaticClause_object->comment = (string) $request->input('automatic_addition_comment');
                $insurerReplay_object->automaticClause = $automaticClause_object;
            }

            if ($pipeLineItems->formData['lossNotification'] == true) {
                $lossNotification_object = new \stdClass();
                $lossNotification_object->isAgree = (string) $request->input('d_loss_notification');
                $lossNotification_object->comment = (string) $request->input('loss_notification_comment');
                $insurerReplay_object->lossNotification = $lossNotification_object;
            }

            if ($pipeLineItems->formData['brokersClaimClause'] == true) {
                $brokersClaim_object = new \stdClass();
                $brokersClaim_object->isAgree = (string) $request->input('d_brokers_claim');
                $brokersClaim_object->comment = (string) $request->input('brokers_claim_comment');
                $insurerReplay_object->brokersClaimClause = $brokersClaim_object;
            }

            if ($pipeLineItems->formData['flightCover'] == true) {
                $insurerReplay_object->flightCover = (string) $request->input('d_employees_employment');
            }

            if ($pipeLineItems->formData['emergencyEvacuation'] == true) {
                $insurerReplay_object->emergencyEvacuation = (string) $request->input('d_emergency_evacuation');
            }

            if ($pipeLineItems->formData['legalCost'] == true) {
                $insurerReplay_object->legalCost = (string) $request->input('d_defence_cost');
            }

            if ($pipeLineItems->formData['empToEmpLiability'] == true) {
                $insurerReplay_object->empToEmpLiability = (string) $request->input('d_employee_employee');
            }

            if ($pipeLineItems->formData['crossLiability'] == true) {
                $insurerReplay_object->crossLiability = (string) $request->input('d_cross_liability');
            }

            if ($pipeLineItems->formData['diseaseCover'] == true) {
                $insurerReplay_object->diseaseCover = (string) $request->input('d_occupational_industrial');
            }
            if ($pipeLineItems->formData['cancellationClause'] == true) {
                $insurerReplay_object->cancellationClause = (string) $request->input('d_cancellation_clause');
            }
            if (isset($pipeLineItems->formData['indemnityToPrincipal'])) {
                if ($pipeLineItems->formData['indemnityToPrincipal'] == true) {
                    $insurerReplay_object->indemnityToPrincipal = (string) $request->input('d_indemnity_principal');
                }
            }

            if ($pipeLineItems->formData['overtimeWorkCover'] == true) {
                $insurerReplay_object->overtimeWorkCover = (string) $request->input('d_work_accidents');
            }
            if ($pipeLineItems->formData['primaryInsuranceClause'] == true) {
                $insurerReplay_object->primaryInsuranceClause = (string) $request->input('d_primary_insurance');
            }
            if ($pipeLineItems->formData['travelCover'] == true) {
                $insurerReplay_object->travelCover = (string) $request->input('d_travelling');
            }
            if ($pipeLineItems->formData['riotCover'] == true) {
                $insurerReplay_object->riotCover = (string) $request->input('d_riot_strikes');
            }
            if ($pipeLineItems->formData['errorsOmissions'] == true) {
                $insurerReplay_object->errorsOmissions = (string) $request->input('d_ommisions');
            }

            if ($pipeLineItems->formData['hiredWorkersDetails']['hasHiredWorkers'] == true) {
                $insurerReplay_object->hiredCheck = (string) $request->input('employeeclause');
            }

            if ($pipeLineItems->formData['offShoreEmployeeDetails']['hasOffShoreEmployees'] == true) {
                $insurerReplay_object->offshoreCheck = (string) $request->input('d_offshore');
            }

            $insurerReplay_object->rateRequiredAdmin = (string) $request->input('rate_admin');
            $insurerReplay_object->rateRequiredNonAdmin = (string) $request->input('rate_nadmin');
            $insurerReplay_object->combinedRate = (string) $request->input('combined_rate');
            $insurerReplay_object->brokerage = (string) $request->input('brokerage');
            $insurerReplay_object->warranty = (string) $request->input('warranty');
            $insurerReplay_object->exclusion = (string) $request->input('exclusion');
            $insurerReplay_object->specialCondition = (string) $request->input('special_condition');
            $insurerReplay_object->quoteStatus = (string) "active";
            $insurerReplay_object->repliedDate = (string) date('d/m/Y');
            $insurerReplay_object->uniqueToken = (string) time() . rand(1000, 9999);
            $insurerReplay_object->repliedMethod = (string) "insurer";
            if ($request->input('quoteActive') == 'true') {
                $updatedBy = new \stdClass();
                $updatedBy->id = new ObjectId(Auth::id());
                $updatedBy->name = Auth::user()->insurer['name'] . ' (' . Auth::user()->name . ')';
                $updatedBy->date = date('d/m/Y');
                $updatedBy->action = "E quote amended";
                $updatedByarray[] = $updatedBy;
                $pipeLineItems->push('updatedBy', $updatedByarray);
            } else {
                $updatedBy = new \stdClass();
                $updatedBy->id = new ObjectId(Auth::id());
                $updatedBy->name = Auth::user()->insurer['name'] . ' (' . Auth::user()->name . ')';
                $updatedBy->date = date('d/m/Y');
                $updatedBy->action = "E quote gave";
                $updatedByarray[] = $updatedBy;
                $pipeLineItems->push('updatedBy', $updatedByarray);
            }

            $insurerData[] = $insurerReplay_object;

            if ($pipeLineItems->insurerReplay) {
                $pipeLineItems->push('insurerReplay', $insurerData);
                if ($request->input('quoteActive') == 'false') {
                    $array[] = new ObjectId(Auth::user()->insurer['id']);
                }
                $pipeLineItems->save();
            } else {
                $pipeLineItems->insurerReplay = $insurerData;
                if ($request->input('quoteActive') == 'false') {
                    $array[] = new ObjectId(Auth::user()->insurer['id']);
                }
                $pipeLineItems->save();
            }
            if ($request->input('quoteActive') == 'false') {
                $count = 0;
                $insurers_repeat = $pipeLineItems->insuraceCompanyList;
                foreach ($insurers_repeat as $temp) {
                    if ($temp['id'] == $insurerId && $temp['status'] == 'active') {
                        PipelineItems::where('_id', $pipeLineId)->update(array('insuraceCompanyList.' . $count . '.status' => 'inactive'));
                        break;
                    }
                    $count++;
                }
            }
            $this->mailSend($pipeLineId);
            if ($request->input('quoteActive') == 'false') {
                Session::flash('quotation', 'E-Quote given successfully');
                return "success";
            } else {
                Session::flash('quotation', 'E-Quote amended successfully');
                return "amended";
            }
        } catch (\Exception $e) {
            if ($request->input('quoteActive') == 'false') {
                dd($e);
                Session::flash('error', 'Failed');
                return "failed";
            } else {
                Session::flash('error', 'Quote amendment failed');
                return "amended";
            }
        }
    }

    /**
     * save the reply provided by insurer
     */
    public function employerSave(Request $request)
    {
        try {
            $insurerId = new ObjectId(Auth::user()->insurer['id']);
            $pipeLineId = $request->input('id');
            $pipeLineItems = PipelineItems::where('_id', $pipeLineId)->first();
            if (!$pipeLineItems) {
                Session::flash('error', 'Pipeline not defined');
                return "failed";
            }
            if ($request->input('quoteActive') == 'true') {
                $replies = $pipeLineItems['insurerReplay'];
                foreach ($replies as $count => $reply) {
                    if ($reply['insurerDetails']['insurerId'] == $insurerId && $reply['quoteStatus'] == 'active' && $reply['uniqueToken'] == $request->input('hiddenToken')) {
                        PipelineItems::where('_id', $pipeLineId)->update(array('insurerReplay.' . $count . '.quoteStatus' => 'inactive'));
                    }
                }
            } else {
                PipelineItems::where('_id', $pipeLineId)->pull('insurerReplay', ['insurerDetails.insurerId' => $insurerId, 'quoteStatus' => 'saved']);
            }
            $insurerReplay_object = new \stdClass();
            $insurerDetails_object = new \stdClass();
            $insurerDetails_object->insurerId = new ObjectId(Auth::user()->insurer['id']);
            $insurerDetails_object->insurerName = Auth::user()->insurer['name'];
            $insurerDetails_object->givenById = new ObjectId(Auth::id());
            $insurerDetails_object->givenByName = Auth::user()->name;
            $insurerReplay_object->insurerDetails = $insurerDetails_object;

            if ($request->input('select_liability') == "option_other1") {
                $insurerReplay_object->extendedLiability = (string) $request->input('other_liability');
            } else {
                $insurerReplay_object->extendedLiability = (string) str_replace(',', '', $request->input('select_liability'));
            }

            if ($pipeLineItems->formData['hiredWorkersDetails']['hasHiredWorkers'] == true) {
                $coverHiredWorkers = new \stdClass();
                $coverHiredWorkers->isAgree = (string) $request->input('hired_labours');
                $coverHiredWorkers->comment = (string) $request->input('hired_workers_comment');
                $insurerReplay_object->coverHiredWorkers = $coverHiredWorkers;
            }

            if ($pipeLineItems->formData['offShoreEmployeeDetails']['hasOffShoreEmployees'] == true) {
                $coverOffshore = new \stdClass();
                $coverOffshore->isAgree = (string) $request->input('offshore_employee');
                $coverOffshore->comment = (string) $request->input('offshore_comment');
                $insurerReplay_object->coverOffshore = $coverOffshore;
            }

            if (isset($pipeLineItems->formData['waiverOfSubrogation'])) {
                if ($pipeLineItems->formData['waiverOfSubrogation'] == true) {
                    $waiverSubrogation_object = new \stdClass();
                    $waiverSubrogation_object->isAgree = (string) $request->input('d_waiver');
                    $waiverSubrogation_object->comment = (string) $request->input('waiver_comment');
                    $insurerReplay_object->waiverOfSubrogation = $waiverSubrogation_object;
                }
            }
            if ($pipeLineItems->formData['automaticClause'] == true) {
                $automaticClause_object = new \stdClass();
                $automaticClause_object->isAgree = (string) $request->input('d_automatic_addition');
                $automaticClause_object->comment = (string) $request->input('automatic_addition_comment');
                $insurerReplay_object->automaticClause = $automaticClause_object;
            }

            if ($pipeLineItems->formData['lossNotification'] == true) {
                $lossNotification_object = new \stdClass();
                $lossNotification_object->isAgree = (string) $request->input('d_loss_notification');
                $lossNotification_object->comment = (string) $request->input('loss_notification_comment');
                $insurerReplay_object->lossNotification = $lossNotification_object;
            }

            if ($pipeLineItems->formData['brokersClaimClause'] == true) {
                $brokersClaim_object = new \stdClass();
                $brokersClaim_object->isAgree = (string) $request->input('d_brokers_claim');
                $brokersClaim_object->comment = (string) $request->input('brokers_claim_comment');
                $insurerReplay_object->brokersClaimClause = $brokersClaim_object;
            }

            if ($pipeLineItems->formData['emergencyEvacuation'] == true) {
                $insurerReplay_object->emergencyEvacuation = (string) $request->input('d_emergency_evacuation');
            }

            if ($pipeLineItems->formData['empToEmpLiability'] == true) {
                $insurerReplay_object->empToEmpLiability = (string) $request->input('d_employee_employee');
            }

            if ($pipeLineItems->formData['crossLiability'] == true) {
                $insurerReplay_object->crossLiability = (string) $request->input('d_cross_liability');
            }

            if ($pipeLineItems->formData['cancellationClause'] == true) {
                $insurerReplay_object->cancellationClause = (string) $request->input('d_cancellation_clause');
            }
            if (isset($pipeLineItems->formData['indemnityToPrincipal'])) {
                if ($pipeLineItems->formData['indemnityToPrincipal'] == true) {
                    $insurerReplay_object->indemnityToPrincipal = (string) $request->input('d_indemnity_principal');
                }
            }

            if ($pipeLineItems->formData['primaryInsuranceClause'] == true) {
                $insurerReplay_object->primaryInsuranceClause = (string) $request->input('d_primary_insurance');
            }
            if ($pipeLineItems->formData['travelCover'] == true) {
                $insurerReplay_object->travelCover = (string) $request->input('d_travelling');
            }
            if ($pipeLineItems->formData['riotCover'] == true) {
                $insurerReplay_object->riotCover = (string) $request->input('d_riot_strikes');
            }
            if ($pipeLineItems->formData['errorsOmissions'] == true) {
                $insurerReplay_object->errorsOmissions = (string) $request->input('d_ommisions');
            }

            if ($pipeLineItems->formData['hiredWorkersDetails']['hasHiredWorkers'] == true) {
                $insurerReplay_object->hiredCheck = (string) $request->input('employeeclause');
            }

            $insurerReplay_object->rateRequiredAdmin = (string) $request->input('rate_admin');
            $insurerReplay_object->rateRequiredNonAdmin = (string) $request->input('rate_nadmin');
            $insurerReplay_object->combinedRate = (string) $request->input('combined_rate');
            $insurerReplay_object->brokerage = (string) $request->input('brokerage');
            $insurerReplay_object->warranty = (string) $request->input('warranty');
            $insurerReplay_object->exclusion = (string) $request->input('exclusion');
            $insurerReplay_object->excess = (string) str_replace(',', '', $request->input('excess'));
            $insurerReplay_object->specialCondition = (string) $request->input('special_condition');
            $insurerReplay_object->quoteStatus = (string) "active";
            $insurerReplay_object->repliedDate = (string) date('d/m/Y');
            $insurerReplay_object->uniqueToken = (string) time() . rand(1000, 9999);
            $insurerReplay_object->repliedMethod = (string) "insurer";
            if ($request->input('quoteActive') == 'true') {
                $updatedBy = new \stdClass();
                $updatedBy->id = new ObjectId(Auth::id());
                $updatedBy->name = Auth::user()->insurer['name'] . ' (' . Auth::user()->name . ')';
                $updatedBy->date = date('d/m/Y');
                $updatedBy->action = "E quote amended";
                $updatedByarray[] = $updatedBy;
                $pipeLineItems->push('updatedBy', $updatedByarray);
            } else {
                $updatedBy = new \stdClass();
                $updatedBy->id = new ObjectId(Auth::id());
                $updatedBy->name = Auth::user()->insurer['name'] . ' (' . Auth::user()->name . ')';
                $updatedBy->date = date('d/m/Y');
                $updatedBy->action = "E quote gave";
                $updatedByarray[] = $updatedBy;
                $pipeLineItems->push('updatedBy', $updatedByarray);
            }

            $insurerData[] = $insurerReplay_object;

            if ($pipeLineItems->insurerReplay) {
                $pipeLineItems->push('insurerReplay', $insurerData);
                if ($request->input('quoteActive') == 'false') {
                    $array[] = new ObjectId(Auth::user()->insurer['id']);
                }
                $pipeLineItems->save();
            } else {
                $pipeLineItems->insurerReplay = $insurerData;
                if ($request->input('quoteActive') == 'false') {
                    $array[] = new ObjectId(Auth::user()->insurer['id']);
                }
                $pipeLineItems->save();
            }
            if ($request->input('quoteActive') == 'false') {
                $count = 0;
                $insurers_repeat = $pipeLineItems->insuraceCompanyList;
                foreach ($insurers_repeat as $temp) {
                    if ($temp['id'] == $insurerId && $temp['status'] == 'active') {
                        PipelineItems::where('_id', $pipeLineId)->update(array('insuraceCompanyList.' . $count . '.status' => 'inactive'));
                        break;
                    }
                    $count++;
                }
            }
            $this->mailSend($pipeLineId);
            if ($request->input('quoteActive') == 'false') {
                Session::flash('quotation', 'E-Quote given successfully');
                return "success";
            } else {
                Session::flash('quotation', 'E-Quote amended successfully');
                return "amended";
            }
        } catch (\Exception $e) {
            if ($request->input('quoteActive') == 'false') {
                dd($e);
                Session::flash('error', 'Failed');
                return "failed";
            } else {
                Session::flash('error', 'Quote amendment failed');
                return "amended";
            }
        }
    }

    /**
     * view e quotes
     */
    public function eQuotesProvider(Request $request)
    {
        $insurerId = new ObjectId(Auth::user()->insurer['id']);
        // $quots = PipelineItems::where('insuraceCompanyList.id', '=', $insurerId)->where('pipelineStatus', "true")->where('insuraceCompanyList', 'elemMatch', array('insurerDetails.insurerId' => $insurerId, 'quoteStatus' => 'active'))->where('status.status', '!=', 'Approved E Quote')->where('status.status', '!=', 'Issuance');
        // $quots = PipelineItems::where('pipelineStatus', "true")->where('insuraceCompanyList', 'elemMatch', array('id' => $insurerId, 'status' => 'active'))
        //     ->where('status.status', '!=', 'Approved E Quote')->where('status.status', '!=', 'Issuance');
        $quots = WorkTypeData::where('pipelineStatus', "true")->where('insurerList', 'elemMatch', array('id' => $insurerId,'status'=>'active'))
            ->where('status.status', '!=', 'Approved E Quote')->where('status.status', '!=', 'Issuance');
        $search = session('search_provide');
        $sortField = session('sort');
        $filterData = json_decode(session('filter'));
        if ($filterData) {
            foreach ($filterData as $key => $value) {
                $val_array = [];
                foreach ($value as $val) {
                    if ($val == "Nil") {
                        $val_array[] = (string) 0;
                    }
                    if ($val != '0' && $val != 'Nil') {
                        $val_array[] = new ObjectID($val);
                    }
                }

                if (count($val_array) > 0) {
                    $quots = $quots->whereIn($key, $val_array);
                }
            }
        }

        if ($sortField) {
            if ($sortField == "Category") {
                $quots = $quots->orderBy('workTypeId.name');
            } elseif ($sortField == "Main Group") {
                $quots = $quots->orderBy('customer.maingroupName');
            } elseif ($sortField == "Customer Name") {
                $quots = $quots->orderBy('customer.name');
            } elseif ($sortField == "Case Manager") {
                $quots = $quots->orderBy('caseManager.name');
            } elseif ($sortField == "Last Updated By") {
                $quots = $quots->orderBy('updatedBy.name');
            } elseif ($sortField == "Last Updated At") {
                $quots = $quots->orderBy('updated_at', 'desc');
            } elseif ($sortField == "Status") {
                $quots = $quots->orderBy('status.status');
            } elseif ($sortField == "Agent") {
                $quots = $quots->orderBy('agent.name');
            }
        } else {
            $quots = $quots->orderBy('updated_at', 'desc');
        }

        if (!empty($search)) {
            $quots = $quots->where(
                function ($query) use ($search) {
                    $query->where('customer.name', 'like', '%' . $search . '%')
                        ->orWhere('workTypeId.name', 'like', '%' . $search . '%')
                        ->orWhere('customer.maingroupName', 'like', '%' . $search . '%')
                        ->orWhere('caseManager.name', 'like', '%' . $search . '%')
                        ->orWhere('status.status', 'like', '%' . $search . '%');
                }
            );
        }

        $data[] = array('E-quotes to be provided');
        $data[] = ['CATEGORY', 'MAIN GROUP', 'CUSTOMER NAME', 'CASE MANAGER', 'STATUS'];
        $finalQuots = $quots->get();
        foreach ($finalQuots as $quot) {

            //                $updatedAt = $quot->updated_at;
            //                $update = $quot->updatedBy;
            //                $lastUpdate = end($update);
            //                $updated_by = $lastUpdate['name'];
            $data[] = array(
                $quot->workTypeId['name'],
                $quot->customer['maingroupName'],
                $quot->customer['name'],
                $quot->caseManager['name'],
            //                    $updated_by,
                //                    Carbon::parse($updatedAt)->format('d-m-Y'),
                $quot->status['status'],
            //                    $quot->agent['name'],
            );
        }

        Excel::create(
            'E-quotes to be provided', function ($excel) use ($data) {
                $excel->sheet(
                    'E-quotes to be provided', function ($sheet) use ($data) {
                        $sheet->mergeCells('A1:L1');
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

    /**
     * view e quotes given data table
     */
    public function givenDatatable(Request $request)
    {
        $insurerId = new ObjectId(Auth::user()->insurer['id']);
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $filter = $request->input('search');
        $quots = WorkTypeData::where('insurerList.id', '=', $insurerId)->where('pipelineStatus', "true")
            ->where('insurerReply', 'elemMatch', array('insurerDetails.insurerId' => $insurerId, 'quoteStatus' => 'active'));
            // $quots = WorkTypeData::where('insurerList.id', '=', $insurerId)->where('pipelineStatus', "true")
            //     ->where('insurerReply', 'elemMatch', array('insurerDetails.insurerId' => $insurerId, 'quoteStatus' => 'active'));
        $search = (isset($filter['value'])) ? $filter['value'] : false;
        $searchField = $request->input('searchField');
        $sortField = $request->input('field');
        session()->put('filter', $request->input('filterData'));
        session()->put('sort', $sortField);

        $filterData = json_decode($request->input('filterData'));
        /**
         * Condition for filtering
         */
        if ($filterData) {
            foreach ($filterData as $key => $value) {
                $val_array = [];
                foreach ($value as $val) {
                    if ($val == "Nil") {
                        $val_array[] = (string) 0;
                    }
                    if ($val != '0' && $val != 'Nil') {
                        $val_array[] = new ObjectID($val);
                    }
                }

                if (count($val_array) > 0) {
                    $quots = $quots->whereIn($key, $val_array);
                }
            }
        }

        /**
         * Condition for sorting
         */
        if ($sortField) {
            if ($sortField == "Category") {
                $quots = $quots->orderBy('workTypeId.name');
            } elseif ($sortField == "Main Group") {
                $quots = $quots->orderBy('customer.maingroupName');
            } elseif ($sortField == "Customer Name") {
                $quots = $quots->orderBy('customer.name');
            } elseif ($sortField == "Case Manager") {
                $quots = $quots->orderBy('caseManager.name');
            } elseif ($sortField == "Last Updated By") {
                $quots = $quots->orderBy('updatedBy.name');
            } elseif ($sortField == "Last Updated At") {
                $quots = $quots->orderBy('updated_at', 'desc');
            } elseif ($sortField == "Status") {
                $quots = $quots->orderBy('status.status');
            } elseif ($sortField == "Agent") {
                $quots = $quots->orderBy('agent.name');
            }
        } else {
            $quots = $quots->orderBy('updated_at', 'desc');
        }
        /**
         * Condition for searching
         */
        if ($search) {
            $quots = $quots->where(
                function ($query) use ($search) {
                    $query->where('customer.name', 'like', '%' . $search . '%')
                        ->orWhere('workTypeId.name', 'like', '%' . $search . '%')
                        ->orWhere('customer.maingroupName', 'like', '%' . $search . '%')
                        ->orWhere('caseManager.name', 'like', '%' . $search . '%')
                        ->orWhere('insurerReplay.insurerDetails.givenByName', 'like', '%' . $search . '%');
                }
            );
            session()->put('search', $search);
        }
        if ($search == "") {
            session()->put('search', "");
        }
        $total_items = $quots->count(); // get your total no of data;
        $members_query = $quots;
        $search_count = $members_query->count();
        $quots->skip((int) $start)->take((int) $length);
        $finalQuots = $quots->get();
        $q = [];
        foreach ($finalQuots as $quot) {
            $array = [];
            $name = $quot->customer['name'];
            $category = $quot->workTypeId['name'];
            $maingroup = $quot->customer['maingroupName'];
            $case_manager = $quot->caseManager['name'];
            //                $update = $quot->updatedBy;
            //                $lastUpdate = end($update);
            //                $updated_by = $lastUpdate['name'];
            //                $updatedAt = $quot->updated_at;
            //                $date = Carbon::parse($updatedAt)->format('d-m-Y');
            $status = $quot->status['status'];
            //                $agent = $quot->agent['name'];
            $current = $quot['insurerReply'];
            foreach ($current as $crnt) {
                if ($crnt['insurerDetails']['insurerId'] == Auth::user()->insurer['id'] && $crnt['quoteStatus'] == 'active') {
                    $array[] = $crnt;
                }
            }
            $last = end($array);
            $qw = new \stdClass();
            $qw->category = $category;
            $qw->maingroup = $maingroup;
            $qw->customer_name = $name;
            $qw->case_manager = $case_manager;
            //                $qw->updated_by = $updated_by;
            //                $qw->updatedAt = $date;
            $qw->status = $status;
            //                $qw->agent = $agent;
            $qw->givenBy = $last['insurerDetails']['givenByName'];
            //$qw->action = '<a href="' . URL::to('insurer/amend-equot/' . $quot->_id . '/' . @$last['uniqueToken']) . '" class="btn btn-sm btn-success" style="font-weight: 600">Amend Quote</a>';
            $qw->action = '<a href="' . URL::to('insurer/amend-details/' . $quot->_id.'/'.@$last['uniqueToken']) . '" class="btn btn-sm btn-success" style="font-weight: 600">Amend Quote</a>';

            $q[] = $qw;
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
            'data' => $q,
        );
        return json_encode($data);
    }
    /**
     * quote ammendment page
     */
    public function quotAmend($pipeLineId, $token)
    {
        return $this->quoteDetails($pipeLineId);
        $pipeline_items = PipelineItems::where('_id', $pipeLineId)->where('insuraceCompanyList.id', '=', new ObjectId(Auth::user()->insurer['id']))->first();
        if (!$pipeline_items) {
            Session::flash('error', 'Pipeline not defined');
            return redirect('insurer/equotes-given');
        }
        $replies = $pipeline_items->insurerReplay;
        foreach ($replies as $reply) {
            if ($reply['quoteStatus'] == 'active') {
                if (@$reply['uniqueToken'] == $token) {
                    $insurerReply = $reply;
                    break;
                }
            }
        }
        $pipelineStatus = $pipeline_items['status']['status'];
        $formData = $pipeline_items->formData;
        $pipeline_details = $pipeline_items;
        if ($pipeline_items->workTypeId['name'] == "Workman's Compensation") {
            return view('insurer.e_quotation')->with(compact('formData', 'pipeLineId', 'insurerReply', 'token', 'pipelineStatus'));
        } elseif ($pipeline_items->workTypeId['name'] == "Employers Liability") {
            return view('insurer.employee_e_quotation')->with(compact('formData', 'pipeLineId', 'insurerReply', 'token', 'pipelineStatus'));
        } elseif ($pipeline_items->workTypeId['name'] == "Money") {
            return view('insurer.money_e_quotation')->with(compact('formData', 'pipeLineId', 'insurerReply', 'token', 'pipelineStatus'));
        } elseif ($pipeline_items->workTypeId['name'] == "Property") {
            return view('insurer.property_quotation')->with(compact('formData', 'pipeLineId', 'insurerReply', 'token', 'pipelineStatus', 'pipeline_details'));
        } elseif ($pipeline_items->workTypeId['name'] == "Fire and Perils") {
            return view('insurer.fireperils_e_quotation')->with(compact('formData', 'pipeLineId', 'insurerReply', 'token', 'pipelineStatus', 'pipeline_details'));
        } elseif ($pipeline_items->workTypeId['name'] == "Business Interruption") {
            return view('insurer.business_e_quotation')->with(compact('formData', 'pipeLineId', 'insurerReply', 'token', 'pipelineStatus', 'pipeline_details'));
        } elseif ($pipeline_items->workTypeId['name'] == "Machinery Breakdown") {
            return view('insurer.machinery_e_quotation')->with(compact('formData', 'pipeLineId', 'insurerReply', 'token', 'pipelineStatus', 'pipeline_details'));
        } elseif ($pipeline_items->workTypeId['name'] == "Contractor`s Plant and Machinery") {
            return view('insurer.plant_e_quotation')->with(compact('formData', 'pipeLineId', 'insurerReply', 'token', 'pipelineStatus', 'pipeline_details'));
        }
    }
    /**
     * Function for export as excel in equotes given page
     */
    public function exportEquotGiven(Request $request)
    {
        $insurerId = new ObjectId(Auth::user()->insurer['id']);
        $quots = PipelineItems::where('insuraceCompanyList.id', '=', $insurerId)->where('pipelineStatus', "true")->where('insurerReplay', 'elemMatch', array('insurerDetails.insurerId' => $insurerId, 'quoteStatus' => 'active'));
        $search = session('search');
        $sortField = session('sort');
        $filterData = json_decode(session('filter'));
        if ($filterData) {
            foreach ($filterData as $key => $value) {
                $val_array = [];
                foreach ($value as $val) {
                    if ($val == "Nil") {
                        $val_array[] = (string) 0;
                    }
                    if ($val != '0' && $val != 'Nil') {
                        $val_array[] = new ObjectID($val);
                    }
                }

                if (count($val_array) > 0) {
                    $quots = $quots->whereIn($key, $val_array);
                }
            }
        }

        if ($sortField) {
            if ($sortField == "Category") {
                $quots = $quots->orderBy('workTypeId.name');
            } elseif ($sortField == "Main Group") {
                $quots = $quots->orderBy('customer.maingroupName');
            } elseif ($sortField == "Customer Name") {
                $quots = $quots->orderBy('customer.name');
            } elseif ($sortField == "Case Manager") {
                $quots = $quots->orderBy('caseManager.name');
            } elseif ($sortField == "Last Updated By") {
                $quots = $quots->orderBy('updatedBy.name');
            } elseif ($sortField == "Last Updated At") {
                $quots = $quots->orderBy('updated_at', 'desc');
            } elseif ($sortField == "Status") {
                $quots = $quots->orderBy('status.status');
            } elseif ($sortField == "Agent") {
                $quots = $quots->orderBy('agent.name');
            }
        } else {
            $quots = $quots->orderBy('updated_at', 'desc');
        }

        if (!empty($search)) {
            $quots = $quots->where(
                function ($query) use ($search) {
                    $query->where('customer.name', 'like', '%' . $search . '%')
                        ->orWhere('workTypeId.name', 'like', '%' . $search . '%')
                        ->orWhere('customer.maingroupName', 'like', '%' . $search . '%')
                        ->orWhere('caseManager.name', 'like', '%' . $search . '%')
                        ->orWhere('status.status', 'like', '%' . $search . '%')
                        ->orWhere('insurerReplay.insurerDetails.givenByName', 'like', '%' . $search . '%');
                }
            );
        }

        $data[] = array('E-quotes given');
        $data[] = ['CATEGORY', 'MAIN GROUP', 'CUSTOMER NAME', 'CASE MANAGER', 'GIVEN BY', 'STATUS'];
        $finalQuots = $quots->get();

        foreach ($finalQuots as $quot) {
            $updatedAt = $quot->updated_at;
            $current = $quot['insurerReplay'];
            foreach ($current as $crnt) {
                if ($crnt['insurerDetails']['insurerId'] == Auth::user()->insurer['id'] && $crnt['quoteStatus'] == 'active') {
                    $array[] = $crnt;
                }
            }
            $last = end($array);
            //                $update = $quot->updatedBy;
            //                $lastUpdate = end($update);
            //                $updated_b/y = $lastUpdate['name'];
            $data[] = array(
                $quot->workTypeId['name'],
                $quot->customer['maingroupName'],
                $quot->customer['name'],
                $quot->caseManager['name'],
            //                    $updated_by,
                $last['insurerDetails']['givenByName'],
            //                    Carbon::parse($updatedAt)->format('d-m-Y'),
                $quot->status['status'],
            //                    $quot->agent['name'],
            );
        }

        Excel::create(
            'E-quotes given', function ($excel) use ($data) {
                $excel->sheet(
                    'E-quotes given', function ($sheet) use ($data) {
                        $sheet->mergeCells('A1:L1');
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

    /**
     * Function for save and exit
     */
    public function saveAndExit(Request $request)
    {
        $pipeLineId = $request->input('id');
        $pipeLineItems = PipelineItems::where('_id', $pipeLineId)->first();
        if ($pipeLineItems->workTypeId['name'] == "Workman's Compensation") {
            try {
                $insurerId = new ObjectId(Auth::user()->insurer['id']);
                $pipeLineId = $request->input('id');
                $pipeLineItems = PipelineItems::where('_id', $pipeLineId)->first();
                if (!$pipeLineItems) {
                    Session::flash('error', 'Pipeline not defined');
                    return "failed";
                }
                PipelineItems::where('_id', $pipeLineId)->pull('insurerReplay', ['insurerDetails.insurerId' => $insurerId, 'quoteStatus' => 'saved']);
                $insurerReplay_object = new \stdClass();
                $insurerDetails_object = new \stdClass();
                $insurerDetails_object->insurerId = new ObjectId(Auth::user()->insurer['id']);
                $insurerDetails_object->insurerName = Auth::user()->insurer['name'];
                $insurerDetails_object->givenById = new ObjectId(Auth::id());
                $insurerDetails_object->givenByName = Auth::user()->name;
                $insurerReplay_object->insurerDetails = $insurerDetails_object;

                $insurerReplay_object->scaleOfCompensation = (string) $request->input('d_scale');
                if ($request->input('select_liability') == "option_other1") {
                    $insurerReplay_object->extendedLiability = (string) $request->input('other_liability');
                } else {
                    $insurerReplay_object->extendedLiability = (string) str_replace(',', '', $request->input('select_liability'));
                }
                if ($request->input('medical_expense') == "option_other2") {
                    $insurerReplay_object->medicalExpense = (string) $request->input('other_medical_expense');
                } else {
                    $insurerReplay_object->medicalExpense = (string) str_replace(',', '', $request->input('medical_expense'));
                }
                if ($request->input('repatriation_expenses') == "option_other3") {
                    $insurerReplay_object->repatriationExpenses = (string) $request->input('other_repatriation_expenses');
                } else {
                    $insurerReplay_object->repatriationExpenses = (string) str_replace(',', '', $request->input('repatriation_expenses'));
                }
                if ($pipeLineItems->formData['hiredWorkersDetails']['hasHiredWorkers'] == true) {
                    $coverHiredWorkers = new \stdClass();
                    $coverHiredWorkers->isAgree = (string) $request->input('hired_labours');
                    $coverHiredWorkers->comment = (string) $request->input('hired_workers_comment');
                    $insurerReplay_object->coverHiredWorkers = $coverHiredWorkers;
                }

                if ($pipeLineItems->formData['offShoreEmployeeDetails']['hasOffShoreEmployees'] == true) {
                    $coverOffshore = new \stdClass();
                    $coverOffshore->isAgree = (string) $request->input('offshore_employee');
                    $coverOffshore->comment = (string) $request->input('offshore_comment');
                    $insurerReplay_object->coverOffshore = $coverOffshore;
                }
                if ($pipeLineItems->formData['herniaCover'] == true) {
                    $coverForHernia_object = new \stdClass();
                    $coverForHernia_object->isAgree = (string) $request->input('d_cover_hernia');
                    $coverForHernia_object->comment = (string) $request->input('cover_hernia_comment');
                    $insurerReplay_object->herniaCover = $coverForHernia_object;
                }

                if ($pipeLineItems->formData['HoursPAC'] == true) {
                    $personalAccidentCover_object = new \stdClass();
                    $personalAccidentCover_object->isAgree = (string) $request->input('d_non_occupational');
                    $personalAccidentCover_object->comment = (string) $request->input('non_occupational_comment');
                    $insurerReplay_object->HoursPAC = $personalAccidentCover_object;
                }
                if (isset($pipeLineItems->formData['waiverOfSubrogation'])) {
                    // if ($pipeLineItems->formData['waiverOfSubrogation'] == true) {
                    $waiverSubrogation_object = new \stdClass();
                    $waiverSubrogation_object->isAgree = (string) $request->input('d_waiver');
                    $waiverSubrogation_object->comment = (string) $request->input('waiver_comment');
                    $insurerReplay_object->waiverOfSubrogation = $waiverSubrogation_object;
                    // }
                }

                if ($pipeLineItems->formData['automaticClause'] == true) {
                    $automaticClause_object = new \stdClass();
                    $automaticClause_object->isAgree = (string) $request->input('d_automatic_addition');
                    $automaticClause_object->comment = (string) $request->input('automatic_addition_comment');
                    $insurerReplay_object->automaticClause = $automaticClause_object;
                }

                if ($pipeLineItems->formData['lossNotification'] == true) {
                    $lossNotification_object = new \stdClass();
                    $lossNotification_object->isAgree = (string) $request->input('d_loss_notification');
                    $lossNotification_object->comment = (string) $request->input('loss_notification_comment');
                    $insurerReplay_object->lossNotification = $lossNotification_object;
                }

                if ($pipeLineItems->formData['brokersClaimClause'] == true) {
                    $brokersClaim_object = new \stdClass();
                    $brokersClaim_object->isAgree = (string) $request->input('d_brokers_claim');
                    $brokersClaim_object->comment = (string) $request->input('brokers_claim_comment');
                    $insurerReplay_object->brokersClaimClause = $brokersClaim_object;
                }

                if ($pipeLineItems->formData['flightCover'] == true) {
                    $insurerReplay_object->flightCover = (string) $request->input('d_employees_employment');
                }

                if ($pipeLineItems->formData['emergencyEvacuation'] == true) {
                    $insurerReplay_object->emergencyEvacuation = (string) $request->input('d_emergency_evacuation');
                }

                if ($pipeLineItems->formData['legalCost'] == true) {
                    $insurerReplay_object->legalCost = (string) $request->input('d_defence_cost');
                }

                if ($pipeLineItems->formData['empToEmpLiability'] == true) {
                    $insurerReplay_object->empToEmpLiability = (string) $request->input('d_employee_employee');
                }

                if ($pipeLineItems->formData['crossLiability'] == true) {
                    $insurerReplay_object->crossLiability = (string) $request->input('d_cross_liability');
                }

                if ($pipeLineItems->formData['diseaseCover'] == true) {
                    $insurerReplay_object->diseaseCover = (string) $request->input('d_occupational_industrial');
                }
                if ($pipeLineItems->formData['cancellationClause'] == true) {
                    $insurerReplay_object->cancellationClause = (string) $request->input('d_cancellation_clause');
                }
                if (isset($pipeLineItems->formData['indemnityToPrincipal'])) {
                    if ($pipeLineItems->formData['indemnityToPrincipal'] == true) {
                        $insurerReplay_object->indemnityToPrincipal = (string) $request->input('d_indemnity_principal');
                    }
                }

                if ($pipeLineItems->formData['overtimeWorkCover'] == true) {
                    $insurerReplay_object->overtimeWorkCover = (string) $request->input('d_work_accidents');
                }
                if ($pipeLineItems->formData['primaryInsuranceClause'] == true) {
                    $insurerReplay_object->primaryInsuranceClause = (string) $request->input('d_primary_insurance');
                }
                if ($pipeLineItems->formData['travelCover'] == true) {
                    $insurerReplay_object->travelCover = (string) $request->input('d_travelling');
                }
                if ($pipeLineItems->formData['riotCover'] == true) {
                    $insurerReplay_object->riotCover = (string) $request->input('d_riot_strikes');
                }
                if ($pipeLineItems->formData['errorsOmissions'] == true) {
                    $insurerReplay_object->errorsOmissions = (string) $request->input('d_ommisions');
                }
                if ($pipeLineItems->formData['hiredWorkersDetails']['hasHiredWorkers'] == true) {
                    $insurerReplay_object->hiredCheck = (string) $request->input('employeeclause');
                }

                if ($pipeLineItems->formData['offShoreEmployeeDetails']['hasOffShoreEmployees'] == true) {
                    $insurerReplay_object->offshoreCheck = (string) $request->input('d_offshore');
                }

                $insurerReplay_object->rateRequiredAdmin = (string) $request->input('rate_admin');
                $insurerReplay_object->rateRequiredNonAdmin = (string) $request->input('rate_nadmin');
                $insurerReplay_object->combinedRate = (string) $request->input('combined_rate');
                $insurerReplay_object->brokerage = (string) $request->input('brokerage');
                $insurerReplay_object->warranty = (string) $request->input('warranty');
                $insurerReplay_object->exclusion = (string) $request->input('exclusion');
                $insurerReplay_object->specialCondition = (string) $request->input('special_condition');
                $insurerReplay_object->quoteStatus = (string) "saved";
                $updatedBy = new \stdClass();
                $updatedBy->id = new ObjectId(Auth::id());
                $updatedBy->name = Auth::user()->insurer['name'] . ' (' . Auth::user()->name . ')';
                $updatedBy->date = date('d/m/Y');
                $updatedBy->action = "Equotation saved and exit";
                $updatedByarray[] = $updatedBy;
                $pipeLineItems->push('updatedBy', $updatedByarray);
                $insurerData[] = $insurerReplay_object;
                $pipeLineItems->push('insurerReplay', $insurerData);
                $pipeLineItems->save();
                Session::flash('quotation', 'E-Quote saved successfully');
                return 'success';
            } catch (\Exception $e) {
                Session::flash('error', 'E-quote does not saved');
                return 'failed';
            }
        } elseif ($pipeLineItems->workTypeId['name'] == "Employers Liability") {
            try {
                $insurerId = new ObjectId(Auth::user()->insurer['id']);
                $pipeLineId = $request->input('id');
                $pipeLineItems = PipelineItems::where('_id', $pipeLineId)->first();
                if (!$pipeLineItems) {
                    Session::flash('error', 'Pipeline not defined');
                    return "failed";
                }
                PipelineItems::where('_id', $pipeLineId)->pull('insurerReplay', ['insurerDetails.insurerId' => $insurerId, 'quoteStatus' => 'saved']);
                $insurerReplay_object = new \stdClass();
                $insurerDetails_object = new \stdClass();
                $insurerDetails_object->insurerId = new ObjectId(Auth::user()->insurer['id']);
                $insurerDetails_object->insurerName = Auth::user()->insurer['name'];
                $insurerDetails_object->givenById = new ObjectId(Auth::id());
                $insurerDetails_object->givenByName = Auth::user()->name;
                $insurerReplay_object->insurerDetails = $insurerDetails_object;

                if ($request->input('select_liability') == "option_other1") {
                    $insurerReplay_object->extendedLiability = (string) $request->input('other_liability');
                } else {
                    $insurerReplay_object->extendedLiability = (string) str_replace(',', '', $request->input('select_liability'));
                }

                if ($pipeLineItems->formData['hiredWorkersDetails']['hasHiredWorkers'] == true) {
                    $coverHiredWorkers = new \stdClass();
                    $coverHiredWorkers->isAgree = (string) $request->input('hired_labours');
                    $coverHiredWorkers->comment = (string) $request->input('hired_workers_comment');
                    $insurerReplay_object->coverHiredWorkers = $coverHiredWorkers;
                }

                if ($pipeLineItems->formData['offShoreEmployeeDetails']['hasOffShoreEmployees'] == true) {
                    $coverOffshore = new \stdClass();
                    $coverOffshore->isAgree = (string) $request->input('offshore_employee');
                    $coverOffshore->comment = (string) $request->input('offshore_comment');
                    $insurerReplay_object->coverOffshore = $coverOffshore;
                }

                if (isset($pipeLineItems->formData['waiverOfSubrogation'])) {
                    if ($pipeLineItems->formData['waiverOfSubrogation'] == true) {
                        $waiverSubrogation_object = new \stdClass();
                        $waiverSubrogation_object->isAgree = (string) $request->input('d_waiver');
                        $waiverSubrogation_object->comment = (string) $request->input('waiver_comment');
                        $insurerReplay_object->waiverOfSubrogation = $waiverSubrogation_object;
                    }
                }

                if ($pipeLineItems->formData['automaticClause'] == true) {
                    $automaticClause_object = new \stdClass();
                    $automaticClause_object->isAgree = (string) $request->input('d_automatic_addition');
                    $automaticClause_object->comment = (string) $request->input('automatic_addition_comment');
                    $insurerReplay_object->automaticClause = $automaticClause_object;
                }

                if ($pipeLineItems->formData['lossNotification'] == true) {
                    $lossNotification_object = new \stdClass();
                    $lossNotification_object->isAgree = (string) $request->input('d_loss_notification');
                    $lossNotification_object->comment = (string) $request->input('loss_notification_comment');
                    $insurerReplay_object->lossNotification = $lossNotification_object;
                }

                if ($pipeLineItems->formData['brokersClaimClause'] == true) {
                    $brokersClaim_object = new \stdClass();
                    $brokersClaim_object->isAgree = (string) $request->input('d_brokers_claim');
                    $brokersClaim_object->comment = (string) $request->input('brokers_claim_comment');
                    $insurerReplay_object->brokersClaimClause = $brokersClaim_object;
                }

                if ($pipeLineItems->formData['emergencyEvacuation'] == true) {
                    $insurerReplay_object->emergencyEvacuation = (string) $request->input('d_emergency_evacuation');
                }

                if ($pipeLineItems->formData['empToEmpLiability'] == true) {
                    $insurerReplay_object->empToEmpLiability = (string) $request->input('d_employee_employee');
                }

                if ($pipeLineItems->formData['crossLiability'] == true) {
                    $insurerReplay_object->crossLiability = (string) $request->input('d_cross_liability');
                }

                if ($pipeLineItems->formData['cancellationClause'] == true) {
                    $insurerReplay_object->cancellationClause = (string) $request->input('d_cancellation_clause');
                }
                if (isset($pipeLineItems->formData['indemnityToPrincipal'])) {
                    if ($pipeLineItems->formData['indemnityToPrincipal'] == true) {
                        $insurerReplay_object->indemnityToPrincipal = (string) $request->input('d_indemnity_principal');
                    }
                }

                if ($pipeLineItems->formData['primaryInsuranceClause'] == true) {
                    $insurerReplay_object->primaryInsuranceClause = (string) $request->input('d_primary_insurance');
                }
                if ($pipeLineItems->formData['travelCover'] == true) {
                    $insurerReplay_object->travelCover = (string) $request->input('d_travelling');
                }
                if ($pipeLineItems->formData['riotCover'] == true) {
                    $insurerReplay_object->riotCover = (string) $request->input('d_riot_strikes');
                }
                if ($pipeLineItems->formData['errorsOmissions'] == true) {
                    $insurerReplay_object->errorsOmissions = (string) $request->input('d_ommisions');
                }
                if ($pipeLineItems->formData['hiredWorkersDetails']['hasHiredWorkers'] == true) {
                    $insurerReplay_object->hiredCheck = (string) $request->input('employeeclause');
                }

                $insurerReplay_object->rateRequiredAdmin = (string) $request->input('rate_admin');
                $insurerReplay_object->rateRequiredNonAdmin = (string) $request->input('rate_nadmin');
                $insurerReplay_object->combinedRate = (string) $request->input('combined_rate');
                $insurerReplay_object->brokerage = (string) $request->input('brokerage');
                $insurerReplay_object->warranty = (string) $request->input('warranty');
                $insurerReplay_object->exclusion = (string) $request->input('exclusion');
                $insurerReplay_object->excess = (string) str_replace(',', '', $request->input('excess'));
                $insurerReplay_object->specialCondition = (string) $request->input('special_condition');
                $insurerReplay_object->quoteStatus = (string) "saved";
                $updatedBy = new \stdClass();
                $updatedBy->id = new ObjectId(Auth::id());
                $updatedBy->name = Auth::user()->insurer['name'] . ' (' . Auth::user()->name . ')';
                $updatedBy->date = date('d/m/Y');
                $updatedBy->action = "Equotation saved and exit";
                $updatedByarray[] = $updatedBy;
                $pipeLineItems->push('updatedBy', $updatedByarray);
                $insurerData[] = $insurerReplay_object;
                $pipeLineItems->push('insurerReplay', $insurerData);
                $pipeLineItems->save();
                Session::flash('quotation', 'E-Quote saved successfully');
                return 'success';
            } catch (\Exception $e) {
                Session::flash('error', 'E-quote does not saved');
                return 'failed';
            }
        } elseif ($pipeLineItems->workTypeId['name'] == "Money") {
            try {
                $insurerId = new ObjectId(Auth::user()->insurer['id']);
                $pipeLineId = $request->input('id');
                $pipeLineItems = PipelineItems::where('_id', $pipeLineId)->first();
                if (!$pipeLineItems) {
                    Session::flash('error', 'Pipeline not defined');
                    return "failed";
                }
                PipelineItems::where('_id', $pipeLineId)->pull('insurerReplay', ['insurerDetails.insurerId' => $insurerId, 'quoteStatus' => 'saved']);
                $insurerReplay_object = new \stdClass();
                $insurerDetails_object = new \stdClass();
                $insurerDetails_object->insurerId = new ObjectId(Auth::user()->insurer['id']);
                $insurerDetails_object->insurerName = Auth::user()->insurer['name'];
                $insurerDetails_object->givenById = new ObjectId(Auth::id());
                $insurerDetails_object->givenByName = Auth::user()->name;
                $insurerReplay_object->insurerDetails = $insurerDetails_object;

                if ($pipeLineItems->formData['coverLoss'] == true) {
                    $insurerReplay_object->coverLoss = (string) $request->input('coverLoss');
                }
                if ($pipeLineItems->formData['coverDishonest'] == true) {
                    $insurerReplay_object->coverDishonest = (string) $request->input('coverDishonest');
                }
                if ($pipeLineItems->formData['coverHoldup'] == true) {
                    $insurerReplay_object->coverHoldup = (string) $request->input('coverHoldup');
                }
                if ($pipeLineItems->formData['lossDamage'] == true) {
                    $lossdamage_object = new \stdClass();
                    $lossdamage_object->isAgree = (string) $request->input('lossDamage');
                    $lossdamage_object->comment = (string) $request->input('lossDamage_comment');
                    $insurerReplay_object->lossDamage = $lossdamage_object;
                }

                if ($pipeLineItems->formData['claimCost'] == true) {
                    $claimCost_object = new \stdClass();
                    $claimCost_object->isAgree = (string) $request->input('claimCost');
                    $claimCost_object->comment = (string) $request->input('claimCost_comment');
                    $insurerReplay_object->claimCost = $claimCost_object;
                }

                if ($pipeLineItems->formData['additionalPremium'] == true) {
                    $insurerReplay_object->additionalPremium = (string) $request->input('additionalPremium');
                }

                if (isset($pipeLineItems->formData['storageRisk']) && $pipeLineItems->formData['storageRisk'] == true) {
                    $insurerReplay_object->storageRisk = (string) $request->input('storageRisk');
                }

                if ($pipeLineItems->formData['lossNotification'] == true) {
                    $lossNotification_object = new \stdClass();
                    $lossNotification_object->isAgree = (string) $request->input('lossNotification');
                    $lossNotification_object->comment = (string) $request->input('lossNotification_comment');
                    $insurerReplay_object->lossNotification = $lossNotification_object;
                }
                if ($pipeLineItems->formData['cancellation'] == true) {
                    $insurerReplay_object->cancellation = (string) $request->input('cancellation');
                }

                if ($pipeLineItems->formData['thirdParty'] == true) {
                    $thirdParty_object = new \stdClass();
                    $thirdParty_object->isAgree = (string) $request->input('thirdParty');
                    $thirdParty_object->comment = (string) $request->input('thirdParty_comment');
                    $insurerReplay_object->thirdParty = $thirdParty_object;
                }

                if ($pipeLineItems->formData['carryVehicle'] == true) {
                    $carryVehicle_object = new \stdClass();
                    $carryVehicle_object->isAgree = (string) $request->input('carryVehicle');
                    $carryVehicle_object->comment = (string) $request->input('carryVehicle_comment');
                    $insurerReplay_object->carryVehicle = $carryVehicle_object;
                }

                if ($pipeLineItems->formData['nominatedLoss'] == true) {
                    $nominatedLoss_object = new \stdClass();
                    $nominatedLoss_object->isAgree = (string) $request->input('nominatedLoss');
                    $nominatedLoss_object->comment = (string) $request->input('nominatedLoss_comment');
                    $insurerReplay_object->nominatedLoss = $nominatedLoss_object;
                }

                if ($pipeLineItems->formData['errorsClause'] == true) {
                    $insurerReplay_object->errorsClause = (string) $request->input('errorsClause');
                }

                if ($pipeLineItems->formData['personalAssault'] == true) {
                    $personalAssault_object = new \stdClass();
                    $personalAssault_object->isAgree = (string) $request->input('personalAssault');
                    $personalAssault_object->comment = (string) $request->input('personalAssault_comment');
                    $insurerReplay_object->personalAssault = $personalAssault_object;
                }

                // die;

                if ($pipeLineItems->formData['accountantFees'] == true) {
                    $accountantFees_object = new \stdClass();
                    $accountantFees_object->isAgree = (string) $request->input('accountantFees');
                    $accountantFees_object->comment = (string) $request->input('accountantFees_comment');
                    $insurerReplay_object->accountantFees = $accountantFees_object;
                }

                if ($pipeLineItems->formData['sustainedFees'] == true) {
                    $sustainedFees_object = new \stdClass();
                    $sustainedFees_object->isAgree = (string) $request->input('sustainedFees');
                    $sustainedFees_object->comment = (string) $request->input('sustainedFees_comment');
                    $insurerReplay_object->sustainedFees = $sustainedFees_object;
                }
                if ($pipeLineItems->formData['primartClause'] == true) {
                    $insurerReplay_object->primartClause = (string) $request->input('primartClause');
                }
                if ($pipeLineItems->formData['accountClause'] == true) {
                    $accountClause_object = new \stdClass();
                    $accountClause_object->isAgree = (string) $request->input('accountClause');
                    $accountClause_object->comment = (string) $request->input('accountClause_comment');
                    $insurerReplay_object->accountClause = $accountClause_object;
                }

                if ($pipeLineItems->formData['lossParkingAReas'] == true) {
                    $insurerReplay_object->lossParkingAReas = (string) $request->input('lossParkingAReas');
                }
                if ($pipeLineItems->formData['worldwideCover'] == true) {
                    $worldwideCover_object = new \stdClass();
                    $worldwideCover_object->isAgree = (string) $request->input('worldwideCover');
                    $worldwideCover_object->comment = (string) $request->input('worldwideCover_comment');
                    $insurerReplay_object->worldwideCover = $worldwideCover_object;
                }
                if ($pipeLineItems->formData['locationAddition'] == true) {
                    $locationAddition_object = new \stdClass();
                    $locationAddition_object->isAgree = (string) $request->input('locationAddition');
                    $locationAddition_object->comment = (string) $request->input('locationAddition_comment');
                    $insurerReplay_object->locationAddition = $locationAddition_object;
                }
                if (isset($pipeLineItems->formData['moneyCarrying']) && $pipeLineItems->formData['moneyCarrying'] == true) {
                    $moneyCarrying_object = new \stdClass();
                    $moneyCarrying_object->isAgree = (string) $request->input('moneyCarrying');
                    $moneyCarrying_object->comment = (string) $request->input('moneyCarrying_comment');
                    $insurerReplay_object->moneyCarrying = $moneyCarrying_object;
                }
                if ($pipeLineItems->formData['parties'] == true) {
                    $insurerReplay_object->parties = (string) $request->input('parties');
                }
                if ($pipeLineItems->formData['personalEffects'] == true) {
                    $personalEffects_object = new \stdClass();
                    $personalEffects_object->isAgree = (string) $request->input('personalEffects');
                    $personalEffects_object->comment = (string) $request->input('personalEffects_comment');
                    $insurerReplay_object->personalEffects = $personalEffects_object;
                }
                if ($pipeLineItems->formData['holdUp'] == true) {
                    $holdUp_object = new \stdClass();
                    $holdUp_object->isAgree = (string) $request->input('holdUp');
                    $holdUp_object->comment = (string) $request->input('holdUp_comment');
                    $insurerReplay_object->holdUp = $holdUp_object;
                }

                if ($pipeLineItems->formData['transitdRate']) {
                    $insurerReplay_object->transitdRate = str_replace(',', '', $request->input('transitdRate'));
                }
                if ($pipeLineItems->formData['safeRate']) {
                    $insurerReplay_object->safeRate = str_replace(',', '', $request->input('safeRate'));
                }
                if ($pipeLineItems->formData['premiumTransit']) {
                    $insurerReplay_object->premiumTransit = str_replace(',', '', $request->input('premiumTransit'));
                }
                if ($pipeLineItems->formData['premiumSafe']) {
                    $insurerReplay_object->premiumSafe = str_replace(',', '', $request->input('premiumSafe'));
                }
                if ($pipeLineItems->formData['brokerage']) {
                    $insurerReplay_object->brokerage = str_replace(',', '', $request->input('brokerage'));
                }

                $insurerReplay_object->quoteStatus = (string) "saved";
                $updatedBy = new \stdClass();
                $updatedBy->id = new ObjectId(Auth::id());
                $updatedBy->name = Auth::user()->insurer['name'] . ' (' . Auth::user()->name . ')';
                $updatedBy->date = date('d/m/Y');
                $updatedBy->action = "Equotation saved and exit";
                $updatedByarray[] = $updatedBy;
                $pipeLineItems->push('updatedBy', $updatedByarray);
                $insurerData[] = $insurerReplay_object;
                $pipeLineItems->push('insurerReplay', $insurerData);
                $pipeLineItems->save();
                Session::flash('quotation', 'E-Quote saved successfully');
                return 'success';
            } catch (\Exception $e) {
                Session::flash('error', 'E-quote does not saved');
                return 'failed';
            }
        } elseif ($pipeLineItems->workTypeId['name'] == "Business Interruption") {
            try {
                $insurerId = new ObjectId(Auth::user()->insurer['id']);
                $pipeLineId = $request->input('id');
                $pipeLineItems = PipelineItems::where('_id', $pipeLineId)->first();
                if (!$pipeLineItems) {
                    Session::flash('error', 'Pipeline not defined');
                    return "failed";
                }
                PipelineItems::where('_id', $pipeLineId)->pull('insurerReplay', ['insurerDetails.insurerId' => $insurerId, 'quoteStatus' => 'saved']);
                $insurerReplay_object = new \stdClass();
                $insurerDetails_object = new \stdClass();
                $insurerDetails_object->insurerId = new ObjectId(Auth::user()->insurer['id']);
                $insurerDetails_object->insurerName = Auth::user()->insurer['name'];
                $insurerDetails_object->givenById = new ObjectId(Auth::id());
                $insurerDetails_object->givenByName = Auth::user()->name;
                $insurerReplay_object->insurerDetails = $insurerDetails_object;

                if ($pipeLineItems->formData['costWork'] == true) {
                    $insurerReplay_object->costWork = (string) $request->input('costWork');
                }
                if ($pipeLineItems->formData['claimClause'] == true) {
                    $claimClause_object = new \stdClass();
                    $claimClause_object->isAgree = (string) $request->input('claimClause');
                    $claimClause_object->comment = (string) $request->input('claimClause_comment');
                    $insurerReplay_object->claimClause = $claimClause_object;
                }
                if ($pipeLineItems->formData['custExtension'] == true) {
                    $custExtension_object = new \stdClass();
                    $custExtension_object->isAgree = (string) $request->input('custExtension');
                    $custExtension_object->comment = (string) $request->input('custExtension_comment');
                    $insurerReplay_object->custExtension = $custExtension_object;
                }
                if ($pipeLineItems->formData['accountants'] == true) {
                    $accountants_object = new \stdClass();
                    $accountants_object->isAgree = (string) $request->input('accountants');
                    $accountants_object->comment = (string) $request->input('accountants_comment');
                    $insurerReplay_object->accountants = $accountants_object;
                }
                if ($pipeLineItems->formData['payAccount'] == true) {
                    $payAccount_object = new \stdClass();
                    $payAccount_object->isAgree = (string) $request->input('payAccount');
                    $payAccount_object->comment = (string) $request->input('payAccount_comment');
                    $insurerReplay_object->payAccount = $payAccount_object;
                }

                if ($pipeLineItems->formData['denialAccess'] == true) {
                    $denialAccess_object = new \stdClass();
                    $denialAccess_object->isAgree = (string) $request->input('denialAccess');
                    $denialAccess_object->comment = (string) $request->input('denialAccess_comment');
                    $insurerReplay_object->denialAccess = $denialAccess_object;
                }

                if ($pipeLineItems->formData['premiumClause'] == true) {
                    $premiumClause_object = new \stdClass();
                    $premiumClause_object->isAgree = (string) $request->input('premiumClause');
                    $premiumClause_object->comment = (string) $request->input('premiumClause_comment');
                    $insurerReplay_object->premiumClause = $premiumClause_object;
                }

                if ($pipeLineItems->formData['utilityClause'] == true) {
                    $utilityClause_object = new \stdClass();
                    $utilityClause_object->isAgree = (string) $request->input('utilityClause');
                    $utilityClause_object->comment = (string) $request->input('utilityClause_comment');
                    $insurerReplay_object->utilityClause = $utilityClause_object;
                }
                if ($pipeLineItems->formData['brokerClaim'] == true) {
                    $insurerReplay_object->brokerClaim = (string) $request->input('brokerClaim');
                }
                if ($pipeLineItems->formData['bookedDebts'] == true) {
                    $bookedDebts_object = new \stdClass();
                    $bookedDebts_object->isAgree = (string) $request->input('bookedDebts');
                    $bookedDebts_object->comment = (string) $request->input('bookedDebts_comment');
                    $insurerReplay_object->bookedDebts = $bookedDebts_object;
                }
                if ($pipeLineItems->formData['interdependanyClause'] == true) {
                    $insurerReplay_object->interdependanyClause = (string) $request->input('interdependanyClause');
                }

                if ($pipeLineItems->formData['extraExpense'] == true) {
                    $extraExpense_object = new \stdClass();
                    $extraExpense_object->isAgree = (string) $request->input('extraExpense');
                    $extraExpense_object->comment = (string) $request->input('extraExpense_comment');
                    $insurerReplay_object->extraExpense = $extraExpense_object;
                }
                if ($pipeLineItems->formData['water'] == true) {
                    $insurerReplay_object->water = (string) $request->input('water');
                }
                if ($pipeLineItems->formData['auditorFee'] == true) {
                    $auditorFee_object = new \stdClass();
                    $auditorFee_object->isAgree = (string) $request->input('auditorFee');
                    $auditorFee_object->comment = (string) $request->input('auditorFee_comment');
                    $insurerReplay_object->auditorFee = $auditorFee_object;
                }

                if ($pipeLineItems->formData['expenseLaws'] == true) {
                    $expenseLaws_object = new \stdClass();
                    $expenseLaws_object->isAgree = (string) $request->input('expenseLaws');
                    $expenseLaws_object->comment = (string) $request->input('expenseLaws_comment');
                    $insurerReplay_object->expenseLaws = $expenseLaws_object;
                }

                if ($pipeLineItems->formData['lossAdjuster'] == true) {
                    $lossAdjuster_object = new \stdClass();
                    $lossAdjuster_object->isAgree = (string) $request->input('lossAdjuster');
                    $lossAdjuster_object->comment = (string) $request->input('lossAdjuster_comment');
                    $insurerReplay_object->lossAdjuster = $lossAdjuster_object;
                }

                if ($pipeLineItems->formData['discease'] == true) {
                    $discease_object = new \stdClass();
                    $discease_object->isAgree = (string) $request->input('discease');
                    $discease_object->comment = (string) $request->input('discease_comment');
                    $insurerReplay_object->discease = $discease_object;
                }

                if ($pipeLineItems->formData['powerSupply'] == true) {
                    $powerSupply_object = new \stdClass();
                    $powerSupply_object->isAgree = (string) $request->input('powerSupply');
                    $powerSupply_object->comment = (string) $request->input('powerSupply_comment');
                    $insurerReplay_object->powerSupply = $powerSupply_object;
                }
                if ($pipeLineItems->formData['condition1'] == true) {
                    $condition1_object = new \stdClass();
                    $condition1_object->isAgree = (string) $request->input('condition1');
                    $condition1_object->comment = (string) $request->input('condition1_comment');
                    $insurerReplay_object->condition1 = $condition1_object;
                }
                if ($pipeLineItems->formData['condition2'] == true) {
                    $condition2_object = new \stdClass();
                    $condition2_object->isAgree = (string) $request->input('condition2');
                    $condition2_object->comment = (string) $request->input('condition2_comment');
                    $insurerReplay_object->condition2 = $condition2_object;
                }
                if ($pipeLineItems->formData['bookofDebts'] == true) {
                    $bookofDebts_object = new \stdClass();
                    $bookofDebts_object->isAgree = (string) $request->input('bookofDebts');
                    $bookofDebts_object->comment = (string) $request->input('bookofDebts_comment');
                    $insurerReplay_object->bookofDebts = $bookofDebts_object;
                }
                if ($pipeLineItems->formData['depclause'] == true) {
                    $insurerReplay_object->depclause = (string) $request->input('depclause');
                }

                if ($pipeLineItems->formData['rent'] == true) {
                    $rent_object = new \stdClass();
                    $rent_object->isAgree = (string) $request->input('rent');
                    $rent_object->comment = (string) $request->input('rent_comment');
                    $insurerReplay_object->rent = $rent_object;
                }
                if ($pipeLineItems->formData['hasaccomodation'] == true) {
                    $hasaccomodation_object = new \stdClass();
                    $hasaccomodation_object->isAgree = (string) $request->input('hasaccomodation');
                    $hasaccomodation_object->comment = (string) $request->input('hasaccomodation_comment');
                    $insurerReplay_object->hasaccomodation = $hasaccomodation_object;
                }

                if ($pipeLineItems->formData['costofConstruction'] == true) {
                    $costofConstruction_object = new \stdClass();
                    $costofConstruction_object->isAgree = (string) $request->input('costofConstruction');
                    $costofConstruction_object->comment = (string) $request->input('costofConstruction_comment');
                    $insurerReplay_object->costofConstruction = $costofConstruction_object;
                }
                if ($pipeLineItems->formData['ContingentExpense'] == true) {
                    $ContingentExpense_object = new \stdClass();
                    $ContingentExpense_object->isAgree = (string) $request->input('ContingentExpense');
                    $ContingentExpense_object->comment = (string) $request->input('ContingentExpense_comment');
                    $insurerReplay_object->ContingentExpense = $ContingentExpense_object;
                }
                if ($pipeLineItems->formData['interuption'] == true) {
                    $interuption_object = new \stdClass();
                    $interuption_object->isAgree = (string) $request->input('interuption');
                    $interuption_object->comment = (string) $request->input('interuption_comment');
                    $insurerReplay_object->interuption = $interuption_object;
                }
                if ($pipeLineItems->formData['Royalties'] == true) {
                    $insurerReplay_object->Royalties = (string) $request->input('Royalties');
                }

                if ($pipeLineItems->formData['deductible']) {
                    $insurerReplay_object->deductible = str_replace(',', '', $request->input('deductible'));
                }
                if ($pipeLineItems->formData['ratep']) {
                    $insurerReplay_object->ratep = str_replace(',', '', $request->input('ratep'));
                }
                if ($pipeLineItems->formData['brokerage']) {
                    $insurerReplay_object->brokerage = str_replace(',', '', $request->input('brokerage'));
                }
                if ($pipeLineItems->formData['spec_condition']) {
                    $insurerReplay_object->spec_condition = str_replace(',', '', $request->input('spec_condition'));
                }
                if ($pipeLineItems->formData['warranty']) {
                    $insurerReplay_object->warranty = str_replace(',', '', $request->input('warranty'));
                }
                if ($pipeLineItems->formData['exclusion']) {
                    $insurerReplay_object->exclusion = str_replace(',', '', $request->input('exclusion'));
                }

                $insurerReplay_object->quoteStatus = (string) "saved";
                $updatedBy = new \stdClass();
                $updatedBy->id = new ObjectId(Auth::id());
                $updatedBy->name = Auth::user()->insurer['name'] . ' (' . Auth::user()->name . ')';
                $updatedBy->date = date('d/m/Y');
                $updatedBy->action = "Equotation saved and exit";
                $updatedByarray[] = $updatedBy;
                $pipeLineItems->push('updatedBy', $updatedByarray);
                $insurerData[] = $insurerReplay_object;
                $pipeLineItems->push('insurerReplay', $insurerData);
                $pipeLineItems->save();
                Session::flash('quotation', 'E-Quote saved successfully');
                return 'success';
            } catch (\Exception $e) {
                Session::flash('error', 'E-quote does not saved');
                return 'failed';
            }
        } elseif ($pipeLineItems->workTypeId['name'] == "Machinery Breakdown") {
            try {
                $insurerId = new ObjectId(Auth::user()->insurer['id']);
                $pipeLineId = $request->input('id');
                $pipeLineItems = PipelineItems::where('_id', $pipeLineId)->first();
                if (!$pipeLineItems) {
                    Session::flash('error', 'Pipeline not defined');
                    return "failed";
                }
                PipelineItems::where('_id', $pipeLineId)->pull('insurerReplay', ['insurerDetails.insurerId' => $insurerId, 'quoteStatus' => 'saved']);
                $insurerReplay_object = new \stdClass();
                $insurerDetails_object = new \stdClass();
                $insurerDetails_object->insurerId = new ObjectId(Auth::user()->insurer['id']);
                $insurerDetails_object->insurerName = Auth::user()->insurer['name'];
                $insurerDetails_object->givenById = new ObjectId(Auth::id());
                $insurerDetails_object->givenByName = Auth::user()->name;
                $insurerReplay_object->insurerDetails = $insurerDetails_object;

                if ($pipeLineItems->formData['localclause'] == true) {
                    $localclause_object = new \stdClass();
                    $localclause_object->isAgree = (string) $request->input('localclause');
                    $localclause_object->comment = (string) $request->input('localclause_comment');
                    $insurerReplay_object->localclause = $localclause_object;
                }
                if ($pipeLineItems->formData['express'] == true) {
                    $express_object = new \stdClass();
                    $express_object->isAgree = (string) $request->input('express');
                    $express_object->comment = (string) $request->input('express_comment');
                    $insurerReplay_object->express = $express_object;
                }
                if ($pipeLineItems->formData['airfreight'] == true) {
                    $airfreight_object = new \stdClass();
                    $airfreight_object->isAgree = (string) $request->input('airfreight');
                    $airfreight_object->comment = (string) $request->input('airfreight_comment');
                    $insurerReplay_object->airfreight = $airfreight_object;
                }

                if ($pipeLineItems->formData['addpremium'] == true) {
                    $addpremium_object = new \stdClass();
                    $addpremium_object->isAgree = (string) $request->input('addpremium');
                    $addpremium_object->comment = (string) $request->input('addpremium_comment');
                    $insurerReplay_object->addpremium = $addpremium_object;
                }

                if ($pipeLineItems->formData['payAccount'] == true) {
                    $payAccount_object = new \stdClass();
                    $payAccount_object->isAgree = (string) $request->input('payAccount');
                    $payAccount_object->comment = (string) $request->input('payAccount_comment');
                    $insurerReplay_object->payAccount = $payAccount_object;
                }

                if ($pipeLineItems->formData['primaryclause'] == true) {
                    $insurerReplay_object->primaryclause = (string) $request->input('primaryclause');
                }

                if ($pipeLineItems->formData['premiumClaim'] == true) {
                    $insurerReplay_object->premiumClaim = (string) $request->input('premiumClaim');
                }

                if ($pipeLineItems->formData['lossnotification'] == true) {
                    $lossnotification_object = new \stdClass();
                    $lossnotification_object->isAgree = (string) $request->input('lossnotification');
                    $lossnotification_object->comment = (string) $request->input('lossnotification_comment');
                    $insurerReplay_object->lossnotification = $lossnotification_object;
                }

                if ($pipeLineItems->formData['adjustmentPremium'] == true) {
                    $adjustmentPremium_object = new \stdClass();
                    $adjustmentPremium_object->isAgree = (string) $request->input('adjustmentPremium');
                    $adjustmentPremium_object->comment = (string) $request->input('adjustmentPremium_comment');
                    $insurerReplay_object->adjustmentPremium = $adjustmentPremium_object;
                }
                if ($pipeLineItems->formData['temporaryclause'] == true) {
                    $temporaryclause_object = new \stdClass();
                    $temporaryclause_object->isAgree = (string) $request->input('temporaryclause');
                    $temporaryclause_object->comment = (string) $request->input('temporaryclause_comment');
                    $insurerReplay_object->temporaryclause = $temporaryclause_object;
                }

                if ($pipeLineItems->formData['automaticClause'] == true) {
                    $automaticClause_object = new \stdClass();
                    $automaticClause_object->isAgree = (string) $request->input('automaticClause');
                    $automaticClause_object->comment = (string) $request->input('automaticClause_comment');
                    $insurerReplay_object->automaticClause = $automaticClause_object;
                }

                if ($pipeLineItems->formData['capitalclause'] == true) {
                    $capitalclause_object = new \stdClass();
                    $capitalclause_object->isAgree = (string) $request->input('capitalclause');
                    $capitalclause_object->comment = (string) $request->input('capitalclause_comment');
                    $insurerReplay_object->capitalclause = $capitalclause_object;
                }

                if ($pipeLineItems->formData['debris'] == true) {
                    $debris_object = new \stdClass();
                    $debris_object->isAgree = (string) $request->input('debris');
                    $debris_object->comment = (string) $request->input('debris_comment');
                    $insurerReplay_object->debris = $debris_object;
                }

                if ($pipeLineItems->formData['property'] == true) {
                    $property_object = new \stdClass();
                    $property_object->isAgree = (string) $request->input('property');
                    $property_object->comment = (string) $request->input('property_comment');
                    $insurerReplay_object->property = $property_object;
                }
                if ($pipeLineItems->formData['errorclause'] == true) {
                    $insurerReplay_object->errorclause = (string) $request->input('errorclause');
                }

                if ($pipeLineItems->formData['waiver'] == true) {
                    $waiver_object = new \stdClass();
                    $waiver_object->isAgree = (string) $request->input('waiver');
                    $waiver_object->comment = (string) $request->input('waiver_comment');
                    $insurerReplay_object->waiver = $waiver_object;
                }

                if ($pipeLineItems->formData['claimclause'] == true) {
                    $claimclause_object = new \stdClass();
                    $claimclause_object->isAgree = (string) $request->input('claimclause');
                    $claimclause_object->comment = (string) $request->input('claimclause_comment');
                    $insurerReplay_object->claimclause = $claimclause_object;
                }
                if ($pipeLineItems->formData['Innocent'] == true) {
                    $insurerReplay_object->Innocent = (string) $request->input('Innocent');
                }
                if ($pipeLineItems->formData['Noninvalidation'] == true) {
                    $insurerReplay_object->Noninvalidation = (string) $request->input('Noninvalidation');
                }

                if ($pipeLineItems->formData['brokerclaim'] == true) {
                    $insurerReplay_object->brokerclaim = (string) $request->input('brokerclaim');
                }

                // if ($pipeLineItems->formData['deductm']) {
                $insurerReplay_object->deductm = str_replace(',', '', $request->input('deductm'));
                // }
                // if ($pipeLineItems->formData['ratem']) {
                $insurerReplay_object->ratem = str_replace(',', '', $request->input('ratem'));
                // }
                // if ($pipeLineItems->formData['brokeragem']) {
                $insurerReplay_object->brokeragem = str_replace(',', '', $request->input('brokeragem'));
                // }
                // if ($pipeLineItems->formData['premiumm']) {
                $insurerReplay_object->premiumm = str_replace(',', '', $request->input('premiumm'));
                // }
                // if ($pipeLineItems->formData['specialm']) {
                $insurerReplay_object->specialm = $request->input('specialm');
                // }
                // if ($pipeLineItems->formData['warrantym']) {
                $insurerReplay_object->warrantym = $request->input('warrantym');
                // }
                // if ($pipeLineItems->formData['exclusionm']) {
                $insurerReplay_object->exclusionm = $request->input('exclusionm');
                // }

                // if ($pipeLineItems->formData['deductb']) {
                $insurerReplay_object->deductb = str_replace(',', '', $request->input('deductb'));
                // }
                // if ($pipeLineItems->formData['rateb']) {
                $insurerReplay_object->rateb = str_replace(',', '', $request->input('rateb'));
                // }
                // if ($pipeLineItems->formData['brokerageb']) {
                $insurerReplay_object->brokerageb = str_replace(',', '', $request->input('brokerageb'));
                // }
                // if ($pipeLineItems->formData['premiumb']) {
                $insurerReplay_object->premiumb = str_replace(',', '', $request->input('premiumb'));
                // }
                // if ($pipeLineItems->formData['specialb']) {
                $insurerReplay_object->specialb = $request->input('specialb');
                // }
                // if ($pipeLineItems->formData['warrantyb']) {
                $insurerReplay_object->warrantyb = $request->input('warrantyb');
                // }
                // if ($pipeLineItems->formData['exclusionb']) {
                $insurerReplay_object->exclusionb = $request->input('exclusionb');
                // }

                $insurerReplay_object->quoteStatus = (string) "saved";
                $updatedBy = new \stdClass();
                $updatedBy->id = new ObjectId(Auth::id());
                $updatedBy->name = Auth::user()->insurer['name'] . ' (' . Auth::user()->name . ')';
                $updatedBy->date = date('d/m/Y');
                $updatedBy->action = "Equotation saved and exit";
                $updatedByarray[] = $updatedBy;
                $pipeLineItems->push('updatedBy', $updatedByarray);
                $insurerData[] = $insurerReplay_object;
                $pipeLineItems->push('insurerReplay', $insurerData);
                $pipeLineItems->save();
                Session::flash('quotation', 'E-Quote saved successfully');
                return 'success';
            } catch (\Exception $e) {
                Session::flash('error', 'E-quote does not saved');
                return 'failed';
            }
        }
    }

    /**
     * send mail
     */
    public function mailSend($pipelineId)
    {
        try {
            $insurerId = new ObjectId(Auth::user()->insurer['id']);
            // $pipeline_details = WorkTypeData::find(new ObjectId($pipelineId));
            // if ($pipeline_details) {
            //     $replies = $pipeline_details['insurerReply'];
            //     foreach ($replies as $reply) {
            //         if ($reply['insurerDetails']['insurerId'] == $insurerId && $reply['quoteStatus'] == 'active') {
            //             $insures_details = $reply;
            //             break;
            //         }
            //     }
                $workTypeDataId = $pipelineId;
                $eQuotationData = [];
                $InsurerData = [];
                $Insurer = [];
                $formValues = WorkTypeData::find(new ObjectId($pipelineId));
                $eSlipFormData = $formValues;
                $d = $eSlipFormData['eSlipData'];
                $formData = [];$insurerName;
            if (!empty($d)) {
                foreach ($d as $step => $value) {
                    foreach ($value as $key => $val) {
                        // if ($val['fieldName'] != 'brokerage' && $val['fieldName'] != 'CombinedOrSeperatedRate') {
                            $formData[$val['fieldName']] = $val;
                        // }
                    }
                }
            }

                $basicDetails = [];
                $basicDetails['name']= @$eSlipFormData->workTypeId['name'];
                $basicDetails['refereneceNumber'] = @$eSlipFormData->refereneceNumber;
                $basicDetails['customer']= @$eSlipFormData->customer['name'];
                $basicDetails['customer_id']= @$eSlipFormData->customer['customerCode'];
                $basicDetails['date']=  @$eSlipFormData->comparisonToken['date']?:date('d/m/Y');
            if ($eSlipFormData) {
                $eQuotationData = $eSlipFormData->eSlipData;
                $Insurer = [];
                foreach ($eSlipFormData->insurerReply as $insure) {
                    if ($insure['insurerDetails']['insurerId'] == $insurerId && $insure['quoteStatus'] == 'active') {
                        $Insurer[] = $insure;
                        $insurerName = $insure['insurerDetails']['insurerName'];
                        break;
                    }
                }
                $InsurerData  = $this->flip($Insurer);
            }
                // dd($Insurer);
                $workType = @$pipeline_details->workTypeId['name'];
                $title = 'IIB - Insurer Reply';
                // return view('pages.insurer_reply_pdf')->with(compact('workTypeDataId', 'formValues', 'title', 'eQuotationData', 'InsurerData', 'Insurer', 'formData', 'basicDetails'));
                $pdf = PDF::loadView(
                    'pages.insurer_reply_pdf', [
                    'workTypeDataId'=>$workTypeDataId,
                    'formValues'=>$formValues,
                    'title'=>$title,
                    'eQuotationData'=>$eQuotationData,
                    'InsurerData'=>$InsurerData,
                    'Insurer'=>$Insurer,
                    'formData'=>$formData,
                    'basicDetails'=>$basicDetails
                    ]
                )
                    ->setPaper('a4')->setOrientation('portrait');

                $pdf->setOption("footer-right", "[page] of [topage]");
                $pdf->setOption("footer-font-size", 7);
                $pdf_name = 'Quote_reply_' . time() . '_' . $pipelineId . '_' . $insurerId . '.pdf';
                $pdf->setOption('margin-top', 5);
                $pdf->setOption('margin-bottom', 5);
                $pdf->setOption('margin-left', 5);
                $pdf->setOption('margin-right', 5);
                $temp_path = public_path('pdf/' . $pdf_name);
                $pdf->save('pdf/' . $pdf_name);
                $underwriters = User::where('isActive', 1)->where('userType', 'under writer')->get();
            foreach ($underwriters as $writer) {
                $name = $writer['name'];
                $email = $writer['email'];
                $insurerName = $insurerName;
                $customerName = $formValues['customer']['name'];
                if (isset($email) && !empty($email)) {
                    QuoteFilledInformationUnderwriter::dispatch($name, $email, $insurerName, $customerName);
                }
            }
                $users = User::where('isActive', 1)->where('userType', 'insurer')->where('insurer.id', $insurerId)->get();
            foreach ($users as $user) {
                $user_name = $user['name'];
                $user_email = $user['email'];
                $customerName = $formValues['customer']['name'];
                if (isset($user_email) && !empty($user_email)) {
                    QuoteFilledInformationInsurer::dispatch($user_name, $user_email, $customerName, $temp_path);
                }
            }
        }
        catch(\Exception $e)
        {
            dd($e->getMessage());
        }
    }
    private function flip($arr)
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
     * save the reply provided by insurer
     */
    public function moneySave(Request $request)
    {
        try {
            $insurerId = new ObjectId(Auth::user()->insurer['id']);
            $pipeLineId = $request->input('id');
            $pipeLineItems = PipelineItems::where('_id', $pipeLineId)->first();
            if (!$pipeLineItems) {
                Session::flash('error', 'Pipeline not defined');
                return "failed";
            }
            if ($request->input('quoteActive') == 'true') {
                $replies = $pipeLineItems['insurerReplay'];
                foreach ($replies as $count => $reply) {
                    if ($reply['insurerDetails']['insurerId'] == $insurerId && $reply['quoteStatus'] == 'active' && $reply['uniqueToken'] == $request->input('hiddenToken')) {
                        PipelineItems::where('_id', $pipeLineId)->update(array('insurerReplay.' . $count . '.quoteStatus' => 'inactive'));
                    }
                }
            } else {
                PipelineItems::where('_id', $pipeLineId)->pull('insurerReplay', ['insurerDetails.insurerId' => $insurerId, 'quoteStatus' => 'saved']);
            }
            $insurerReplay_object = new \stdClass();
            $insurerDetails_object = new \stdClass();
            $insurerDetails_object->insurerId = new ObjectId(Auth::user()->insurer['id']);
            $insurerDetails_object->insurerName = Auth::user()->insurer['name'];
            $insurerDetails_object->givenById = new ObjectId(Auth::id());
            $insurerDetails_object->givenByName = Auth::user()->name;
            $insurerReplay_object->insurerDetails = $insurerDetails_object;

            if ($pipeLineItems->formData['coverLoss'] == true) {
                $insurerReplay_object->coverLoss = (string) $request->input('coverLoss');
            }
            if ($pipeLineItems->formData['coverDishonest'] == true) {
                $insurerReplay_object->coverDishonest = (string) $request->input('coverDishonest');
            }
            if ($pipeLineItems->formData['coverHoldup'] == true) {
                $insurerReplay_object->coverHoldup = (string) $request->input('coverHoldup');
            }
            if ($pipeLineItems->formData['lossDamage'] == true) {
                $lossdamage_object = new \stdClass();
                $lossdamage_object->isAgree = (string) $request->input('lossDamage');
                $lossdamage_object->comment = (string) $request->input('lossDamage_comment');
                $insurerReplay_object->lossDamage = $lossdamage_object;
            }

            if ($pipeLineItems->formData['claimCost'] == true) {
                $claimCost_object = new \stdClass();
                $claimCost_object->isAgree = (string) $request->input('claimCost');
                $claimCost_object->comment = (string) $request->input('claimCost_comment');
                $insurerReplay_object->claimCost = $claimCost_object;
            }

            if ($pipeLineItems->formData['additionalPremium'] == true) {
                $insurerReplay_object->additionalPremium = (string) $request->input('additionalPremium');
            }

            if (isset($pipeLineItems->formData['storageRisk']) && $pipeLineItems->formData['storageRisk'] == true) {
                $insurerReplay_object->storageRisk = (string) $request->input('storageRisk');
            }

            if ($pipeLineItems->formData['lossNotification'] == true) {
                $lossNotification_object = new \stdClass();
                $lossNotification_object->isAgree = (string) $request->input('lossNotification');
                $lossNotification_object->comment = (string) $request->input('lossNotification_comment');
                $insurerReplay_object->lossNotification = $lossNotification_object;
            }
            if ($pipeLineItems->formData['cancellation'] == true) {
                $insurerReplay_object->cancellation = (string) $request->input('cancellation');
            }

            if ($pipeLineItems->formData['thirdParty'] == true) {
                $thirdParty_object = new \stdClass();
                $thirdParty_object->isAgree = (string) $request->input('thirdParty');
                $thirdParty_object->comment = (string) $request->input('thirdParty_comment');
                $insurerReplay_object->thirdParty = $thirdParty_object;
            }

            if ($pipeLineItems->formData['carryVehicle'] == true) {
                $carryVehicle_object = new \stdClass();
                $carryVehicle_object->isAgree = (string) $request->input('carryVehicle');
                $carryVehicle_object->comment = (string) $request->input('carryVehicle_comment');
                $insurerReplay_object->carryVehicle = $carryVehicle_object;
            }

            if ($pipeLineItems->formData['nominatedLoss'] == true) {
                $nominatedLoss_object = new \stdClass();
                $nominatedLoss_object->isAgree = (string) $request->input('nominatedLoss');
                $nominatedLoss_object->comment = (string) $request->input('nominatedLoss_comment');
                $insurerReplay_object->nominatedLoss = $nominatedLoss_object;
            }

            if ($pipeLineItems->formData['errorsClause'] == true) {
                $insurerReplay_object->errorsClause = (string) $request->input('errorsClause');
            }

            if ($pipeLineItems->formData['personalAssault'] == true) {
                $personalAssault_object = new \stdClass();
                $personalAssault_object->isAgree = (string) $request->input('personalAssault');
                $personalAssault_object->comment = (string) $request->input('personalAssault_comment');
                $insurerReplay_object->personalAssault = $personalAssault_object;
            }

            if ($pipeLineItems->formData['accountantFees'] == true) {
                $accountantFees_object = new \stdClass();
                $accountantFees_object->isAgree = (string) $request->input('accountantFees');
                $accountantFees_object->comment = (string) $request->input('accountantFees_comment');
                $insurerReplay_object->accountantFees = $accountantFees_object;
            }

            if ($pipeLineItems->formData['sustainedFees'] == true) {
                $sustainedFees_object = new \stdClass();
                $sustainedFees_object->isAgree = (string) $request->input('sustainedFees');
                $sustainedFees_object->comment = (string) $request->input('sustainedFees_comment');
                $insurerReplay_object->sustainedFees = $sustainedFees_object;
            }
            if ($pipeLineItems->formData['primartClause'] == true) {
                $insurerReplay_object->primartClause = (string) $request->input('primartClause');
            }
            if ($pipeLineItems->formData['accountClause'] == true) {
                $accountClause_object = new \stdClass();
                $accountClause_object->isAgree = (string) $request->input('accountClause');
                $accountClause_object->comment = (string) $request->input('accountClause_comment');
                $insurerReplay_object->accountClause = $accountClause_object;
            }

            if ($pipeLineItems->formData['lossParkingAReas'] == true) {
                $insurerReplay_object->lossParkingAReas = (string) $request->input('lossParkingAReas');
            }
            if ($pipeLineItems->formData['worldwideCover'] == true) {
                $worldwideCover_object = new \stdClass();
                $worldwideCover_object->isAgree = (string) $request->input('worldwideCover');
                $worldwideCover_object->comment = (string) $request->input('worldwideCover_comment');
                $insurerReplay_object->worldwideCover = $worldwideCover_object;
            }
            if ($pipeLineItems->formData['locationAddition'] == true) {
                $locationAddition_object = new \stdClass();
                $locationAddition_object->isAgree = (string) $request->input('locationAddition');
                $locationAddition_object->comment = (string) $request->input('locationAddition_comment');
                $insurerReplay_object->locationAddition = $locationAddition_object;
            }
            if (isset($pipeLineItems->formData['moneyCarrying']) && $pipeLineItems->formData['moneyCarrying'] == true) {
                $moneyCarrying_object = new \stdClass();
                $moneyCarrying_object->isAgree = (string) $request->input('moneyCarrying');
                $moneyCarrying_object->comment = (string) $request->input('moneyCarrying_comment');
                $insurerReplay_object->moneyCarrying = $moneyCarrying_object;
            }
            if ($pipeLineItems->formData['parties'] == true) {
                $insurerReplay_object->parties = (string) $request->input('parties');
            }
            if ($pipeLineItems->formData['personalEffects'] == true) {
                $personalEffects_object = new \stdClass();
                $personalEffects_object->isAgree = (string) $request->input('personalEffects');
                $personalEffects_object->comment = (string) $request->input('personalEffects_comment');
                $insurerReplay_object->personalEffects = $personalEffects_object;
            }
            if ($pipeLineItems->formData['holdUp'] == true) {
                $holdUp_object = new \stdClass();
                $holdUp_object->isAgree = (string) $request->input('holdUp');
                $holdUp_object->comment = (string) $request->input('holdUp_comment');
                $insurerReplay_object->holdUp = $holdUp_object;
            }

            if ($pipeLineItems->formData['transitdRate']) {
                $insurerReplay_object->transitdRate = str_replace(',', '', $request->input('transitdRate'));
            }
            if ($pipeLineItems->formData['safeRate']) {
                $insurerReplay_object->safeRate = str_replace(',', '', $request->input('safeRate'));
            }
            if ($pipeLineItems->formData['premiumTransit']) {
                $insurerReplay_object->premiumTransit = str_replace(',', '', $request->input('premiumTransit'));
            }
            if ($pipeLineItems->formData['premiumSafe']) {
                $insurerReplay_object->premiumSafe = str_replace(',', '', $request->input('premiumSafe'));
            }
            if ($pipeLineItems->formData['brokerage']) {
                $insurerReplay_object->brokerage = str_replace(',', '', $request->input('brokerage'));
            }

            $insurerReplay_object->quoteStatus = (string) "active";
            $insurerReplay_object->repliedDate = (string) date('d/m/Y');
            $insurerReplay_object->uniqueToken = (string) time() . rand(1000, 9999);
            $insurerReplay_object->repliedMethod = (string) "insurer";
            if ($request->input('quoteActive') == 'true') {
                $updatedBy = new \stdClass();
                $updatedBy->id = new ObjectId(Auth::id());
                $updatedBy->name = Auth::user()->insurer['name'] . ' (' . Auth::user()->name . ')';
                $updatedBy->date = date('d/m/Y');
                $updatedBy->action = "E quote amended";
                $updatedByarray[] = $updatedBy;
                $pipeLineItems->push('updatedBy', $updatedByarray);
            } else {
                $updatedBy = new \stdClass();
                $updatedBy->id = new ObjectId(Auth::id());
                $updatedBy->name = Auth::user()->insurer['name'] . ' (' . Auth::user()->name . ')';
                $updatedBy->date = date('d/m/Y');
                $updatedBy->action = "E quote gave";
                $updatedByarray[] = $updatedBy;
                $pipeLineItems->push('updatedBy', $updatedByarray);
            }

            $insurerData[] = $insurerReplay_object;

            if ($pipeLineItems->insurerReplay) {
                $pipeLineItems->push('insurerReplay', $insurerData);
                if ($request->input('quoteActive') == 'false') {
                    $array[] = new ObjectId(Auth::user()->insurer['id']);
                }
                $pipeLineItems->save();
            } else {
                $pipeLineItems->insurerReplay = $insurerData;
                if ($request->input('quoteActive') == 'false') {
                    $array[] = new ObjectId(Auth::user()->insurer['id']);
                }
                $pipeLineItems->save();
            }
            if ($request->input('quoteActive') == 'false') {
                $count = 0;
                $insurers_repeat = $pipeLineItems->insuraceCompanyList;
                foreach ($insurers_repeat as $temp) {
                    if ($temp['id'] == $insurerId && $temp['status'] == 'active') {
                        PipelineItems::where('_id', $pipeLineId)->update(array('insuraceCompanyList.' . $count . '.status' => 'inactive'));
                        break;
                    }
                    $count++;
                }
            }
            $this->mailSend($pipeLineId);
            if ($request->input('quoteActive') == 'false') {
                Session::flash('quotation', 'E-Quote given successfully');
                return "success";
            } else {
                Session::flash('quotation', 'E-Quote amended successfully');
                return "amended";
            }
        } catch (\Exception $e) {
            if ($request->input('quoteActive') == 'false') {
                dd($e);
                Session::flash('error', 'Failed');
                return "failed";
            } else {
                Session::flash('error', 'Quote amendment failed');
                return "amended";
            }
        }
    }
    /**
     * save insurer reply for property
     */
    public function propertySave(Request $request)
    {
        try {
            $insurerId = new ObjectId(Auth::user()->insurer['id']);
            $pipeLineId = $request->input('id');
            $pipeLineItems = PipelineItems::where('_id', $pipeLineId)->first();
            $pipeline_details = $pipeLineItems;
            if (!$pipeLineItems) {
                Session::flash('error', 'Pipeline not defined');
                return "failed";
            }
            if ($request->input('quoteActive') == 'true') {
                $replies = $pipeLineItems['insurerReplay'];
                foreach ($replies as $count => $reply) {
                    if ($reply['insurerDetails']['insurerId'] == $insurerId && $reply['quoteStatus'] == 'active' && $reply['uniqueToken'] == $request->input('hiddenToken')) {
                        PipelineItems::where('_id', $pipeLineId)->update(array('insurerReplay.' . $count . '.quoteStatus' => 'inactive'));
                    }
                }
            } else {
                PipelineItems::where('_id', $pipeLineId)->pull('insurerReplay', ['insurerDetails.insurerId' => $insurerId, 'quoteStatus' => 'saved']);
            }
            $insurerReplay_object = new \stdClass();
            $insurerDetails_object = new \stdClass();
            $insurerDetails_object->insurerId = new ObjectId(Auth::user()->insurer['id']);
            $insurerDetails_object->insurerName = Auth::user()->insurer['name'];
            $insurerDetails_object->givenById = new ObjectId(Auth::id());
            $insurerDetails_object->givenByName = Auth::user()->name;
            $insurerReplay_object->insurerDetails = $insurerDetails_object;

            $insurerReplay_object->adjBusinessClause = (string) $request->input('adj_business_caluse');
            if (isset($pipeline_details['formData']['stock']) && $pipeline_details['formData']['stock'] != '') {
                $stockDeclaration_object = new \stdClass();
                $stockDeclaration_object->isAgree = (string) $request->input('stock_declaration');
                $stockDeclaration_object->comment = (string) $request->input('stock_declaration_comment');
                $insurerReplay_object->stockDeclaration = $stockDeclaration_object;
            }
            $loss_rent_object = new \stdClass();
            $loss_rent_object->isAgree = (string) $request->input('loss_rent');
            $loss_rent_object->comment = (string) $request->input('loss_rent_comment');
            $insurerReplay_object->lossRent = $loss_rent_object;
            if ($pipeline_details['formData']['businessType'] == "Hotels/ boarding houses/ motels/ service apartments"
                || $pipeline_details['formData']['businessType'] == "Hotel multiple cover"
            ) {
                $personal_object = new \stdClass();
                $personal_object->isAgree = (string) $request->input('personal_staff');
                $personal_object->comment = (string) $request->input('personal_staff_comment');
                $insurerReplay_object->personalStaff = $personal_object;
                $insurerReplay_object->coverInclude = (string) $request->input('cover_include');
            }
            if ($pipeline_details['formData']['businessType'] == "Cafes & Restaurant"
                || $pipeline_details['formData']['businessType'] == "Clothing manufacturing"
                || $pipeline_details['formData']['businessType'] == "Computer hardware trading/ sales"
                || $pipeline_details['formData']['businessType'] == "Confectionery/ dairy products processing"
                || $pipeline_details['formData']['businessType'] == "Cotton ginning wool/ textile manufacturing"
                || $pipeline_details['formData']['businessType'] == "Department stores/ shopping malls"
                || $pipeline_details['formData']['businessType'] == "Food & beverage manufacturers"
                || $pipeline_details['formData']['businessType'] == "Hotels/ boarding houses/ motels/ service apartments"
                || $pipeline_details['formData']['businessType'] == "Hotel multiple cover"
                || $pipeline_details['formData']['businessType'] == "Livestock"
                || $pipeline_details['formData']['businessType'] == "Mega malls & commercial centers"
                || $pipeline_details['formData']['businessType'] == "Recreational clubs/Theme & water parks"
                || $pipeline_details['formData']['businessType'] == "Restaurant/ catering services"
                || $pipeline_details['formData']['businessType'] == "Souk and similar markets"
                || $pipeline_details['formData']['businessType'] == "Supermarkets / hypermarket/ other retail shops"
                || $pipeline_details['formData']['businessType'] == "Textile mills/ traders/ sales"
                || $pipeline_details['formData']['businessType'] == "Warehouse/ cold storage"
            ) {
                $sesonal_object = new \stdClass();
                $sesonal_object->isAgree = (string) $request->input('personal_staff');
                $sesonal_object->comment = (string) $request->input('personal_staff_comment');
                $insurerReplay_object->seasonalIncrease = $sesonal_object;
            }
            if ($pipeline_details['formData']['occupancy']['type'] == 'Residence') {
                $cover_object = new \stdClass();
                $cover_object->isAgree = (string) $request->input('cover_alternative');
                $cover_object->comment = (string) $request->input('cover_alternative_comment');
                $insurerReplay_object->coverAlternative = $cover_object;
            }
            if ($pipeline_details['formData']['businessType'] == "Cafes & Restaurant"
                || $pipeline_details['formData']['businessType'] == "Clothing manufacturing"
                || $pipeline_details['formData']['businessType'] == "Computer hardware trading/ sales"
                || $pipeline_details['formData']['businessType'] == "Confectionery/ dairy products processing"
                || $pipeline_details['formData']['businessType'] == "Cotton ginning wool/ textile manufacturing"
                || $pipeline_details['formData']['businessType'] == "Department stores/ shopping malls"
                || $pipeline_details['formData']['businessType'] == "Food & beverage manufacturers"
                || $pipeline_details['formData']['businessType'] == "Hotels/ boarding houses/ motels/ service apartments"
                || $pipeline_details['formData']['businessType'] == "Hotel multiple cover"
                || $pipeline_details['formData']['businessType'] == "Livestock"
                || $pipeline_details['formData']['businessType'] == "Mega malls & commercial centers"
                || $pipeline_details['formData']['businessType'] == "Recreational clubs/Theme & water parks"
                || $pipeline_details['formData']['businessType'] == "Restaurant/ catering services"
                || $pipeline_details['formData']['businessType'] == "Souk and similar markets"
                || $pipeline_details['formData']['businessType'] == "Supermarkets / hypermarket/ other retail shops"
                || $pipeline_details['formData']['businessType'] == "Textile mills/ traders/ sales"
                || $pipeline_details['formData']['businessType'] == "Warehouse/ cold storage"
            ) {
                $insurerReplay_object->coverExihibition = (string) $request->input('cover_exihibition');
            }

            if ($pipeline_details['formData']['occupancy']['type'] == 'Warehouse'
                || @$pipeline_details['formData']['occupancy']['type'] == 'Factory'
                || @$pipeline_details['formData']['occupancy']['type'] == 'Others'
            ) {
                $insurerReplay_object->coverProperty = (string) $request->input('cover_property');
            }

            if ($pipeline_details['formData']['otherItems'] != '') {
                $property_care_object = new \stdClass();
                $property_care_object->isAgree = (string) $request->input('property_care');
                $property_care_object->comment = (string) $request->input('property_care_comment');
                $insurerReplay_object->propertyCare = $property_care_object;
            }
            // $loss_payee_object = new \stdClass();
            // $loss_payee_object->isAgree = (string)$request->input('loss_payee');
            // $loss_payee_object->comment = (string)$request->input('loss_payee_comment');
            // $insurerReplay_object->lossPayee = $loss_payee_object;
            $insurerReplay_object->lossPayee = (string) $request->input('loss_payee');

            if (($pipeline_details['formData']['businessType'] == "Art galleries/ fine arts collection"
                || $pipeline_details['formData']['businessType'] == "Colleges/ Universities/ schools & educational institute"
                || $pipeline_details['formData']['businessType'] == "Hotels/ boarding houses/ motels/ service apartments"
                || $pipeline_details['formData']['businessType'] == "Hotel multiple cover"
                || $pipeline_details['formData']['businessType'] == "Museum/ heritage sites") && $pipeline_details['formData']['coverCurios'] == true
            ) {
                $insurerReplay_object->coverCurios = (string) $request->input('cover_curios');
            }
            if ($pipeline_details['formData']['indemnityOwner'] == true) {
                $insurerReplay_object->indemnityOwner = (string) $request->input('indemnity_owner');
            }
            if ($pipeline_details['formData']['conductClause'] == true) {
                $insurerReplay_object->conductClause = (string) $request->input('conduct_clause');
            }
            if ($pipeline_details['formData']['saleClause'] == true) {
                $insurerReplay_object->saleClause = (string) $request->input('sale_clause');
            }
            $fireBrigade_object = new \stdClass();
            $fireBrigade_object->isAgree = (string) $request->input('fire_brigade');
            $fireBrigade_object->comment = (string) $request->input('fire_brigade_comment');
            $insurerReplay_object->fireBrigade = $fireBrigade_object;
            $insurerReplay_object->clauseWording = (string) $request->input('clause_wording');
            $insurerReplay_object->automaticReinstatement = (string) $request->input('automatic_reinstatement');
            $capitalClause_object = new \stdClass();
            $capitalClause_object->isAgree = (string) $request->input('capital_clause');
            $capitalClause_object->comment = (string) $request->input('capital_clause_comment');
            $insurerReplay_object->capitalClause = $capitalClause_object;
            $insurerReplay_object->mainClause = (string) $request->input('main_clause');
            $repairCost_object = new \stdClass();
            $repairCost_object->isAgree = (string) $request->input('repair_cost');
            $repairCost_object->comment = (string) $request->input('repair_cost_comment');
            $insurerReplay_object->repairCost = $repairCost_object;
            $debris_object = new \stdClass();
            $debris_object->isAgree = (string) $request->input('debris');
            $debris_object->comment = (string) $request->input('debris_comment');
            $insurerReplay_object->debris = $debris_object;
            $insurerReplay_object->reinstatementValClass = (string) $request->input('reinstatement_val_class');
            $insurerReplay_object->waiver = (string) $request->input('waiver');
            $publicClause_object = new \stdClass();
            $publicClause_object->isAgree = (string) $request->input('public_clause');
            $publicClause_object->comment = (string) $request->input('public_clause_comment');
            $insurerReplay_object->publicClause = $publicClause_object;
            $contentsClause_object = new \stdClass();
            $contentsClause_object->isAgree = (string) $request->input('contents_clause');
            $contentsClause_object->comment = (string) $request->input('contents_clause_comment');
            $insurerReplay_object->contentsClause = $contentsClause_object;
            if ($pipeline_details['formData']['buildingInclude'] != '' && $pipeline_details['formData']['errorOmission'] == true) {
                $insurerReplay_object->errorOmission = (string) $request->input('error_omission');
            }
            $insurerReplay_object->alterationClause = (string) $request->input('alteration_clause');
            $insurerReplay_object->tradeAccess = (string) $request->input('trade_access');
            $insurerReplay_object->tempRemoval = (string) $request->input('temp_removal');
            $proFee_object = new \stdClass();
            $proFee_object->isAgree = (string) $request->input('prof_fee');
            $proFee_object->comment = (string) $request->input('prof_fee_comment');
            $insurerReplay_object->proFee = $proFee_object;
            $expenseClause_object = new \stdClass();
            $expenseClause_object->isAgree = (string) $request->input('expense_clause');
            $expenseClause_object->comment = (string) $request->input('expense_clause_comment');
            $insurerReplay_object->expenseClause = $expenseClause_object;
            $desigClause_object = new \stdClass();
            $desigClause_object->isAgree = (string) $request->input('desig_clause');
            $desigClause_object->comment = (string) $request->input('desig_clause_comment');
            $insurerReplay_object->desigClause = $desigClause_object;
            $insurerReplay_object->cancelThirtyClause = (string) $request->input('cancel_thirty_clause');
            $insurerReplay_object->primaryInsuranceClause = (string) $request->input('primary_insurance_clause');
            $paymentAccountClause_object = new \stdClass();
            $paymentAccountClause_object->isAgree = (string) $request->input('payment_account_clause');
            $paymentAccountClause_object->comment = (string) $request->input('payment_account_clause_comment');
            $insurerReplay_object->paymentAccountClause = $paymentAccountClause_object;
            $insurerReplay_object->nonInvalidClause = (string) $request->input('non_invalid_clause');
            $insurerReplay_object->warrantyConditionClause = (string) $request->input('warranty_condition_clause');
            $escalationClause_object = new \stdClass();
            $escalationClause_object->isAgree = (string) $request->input('escalation_clause');
            $escalationClause_object->comment = (string) $request->input('escalation_clause_comment');
            $insurerReplay_object->escalationClause = $escalationClause_object;
            $insurerReplay_object->addInterestClause = (string) $request->input('add_interest_clause');
            $insurerReplay_object->improvementClause = (string) $request->input('improvement_clause');
            $automaticClause_object = new \stdClass();
            $automaticClause_object->isAgree = (string) $request->input('automaticClause');
            $automaticClause_object->comment = (string) $request->input('automaticClause_comment');
            $insurerReplay_object->automaticClause = $automaticClause_object;
            $reduseLoseClause_object = new \stdClass();
            $reduseLoseClause_object->isAgree = (string) $request->input('reduse_lose_clause');
            $reduseLoseClause_object->comment = (string) $request->input('reduse_lose_clause_comment');
            $insurerReplay_object->reduseLoseClause = $reduseLoseClause_object;
            if ($pipeline_details['formData']['buildingInclude'] != '' && $pipeline_details['formData']['demolitionClause'] == true) {
                $demolitionClause_object = new \stdClass();
                $demolitionClause_object->isAgree = (string) $request->input('demolition_clause');
                $demolitionClause_object->comment = (string) $request->input('demolition_clause_comment');
                $insurerReplay_object->demolitionClause = $demolitionClause_object;
            }
            $insurerReplay_object->noControlClause = (string) $request->input('no_control_clause');
            $preparationCostClause_object = new \stdClass();
            $preparationCostClause_object->isAgree = (string) $request->input('preparation_cost_clause');
            $preparationCostClause_object->comment = (string) $request->input('preparation_cost_clause_comment');
            $insurerReplay_object->preparationCostClause = $preparationCostClause_object;
            $insurerReplay_object->coverPropertyCon = (string) $request->input('cover_property_con');
            $personalEffectsEmployee_object = new \stdClass();
            $personalEffectsEmployee_object->isAgree = (string) $request->input('personal_effects_employee');
            $personalEffectsEmployee_object->comment = (string) $request->input('personal_effects_employee_comment');
            $insurerReplay_object->personalEffectsEmployee = $personalEffectsEmployee_object;
            $incidentLandTransit_object = new \stdClass();
            $incidentLandTransit_object->isAgree = (string) $request->input('incident_land_transit');
            $incidentLandTransit_object->comment = (string) $request->input('incident_land_transit_comment');
            $insurerReplay_object->incidentLandTransit = $incidentLandTransit_object;
            $insurerReplay_object->lossOrDamage = (string) $request->input('loss_or_damage');
            $nominatedLossAdjusterClause_object = new \stdClass();
            $nominatedLossAdjusterClause_object->isAgree = (string) $request->input('nominated_loss_adjuster_clause');
            $nominatedLossAdjusterClause_object->comment = (string) $request->input('nominated_loss_adjuster_clause_comment');
            $insurerReplay_object->nominatedLossAdjusterClause = $nominatedLossAdjusterClause_object;
            $insurerReplay_object->sprinkerLeakage = (string) $request->input('sprinker_leakage');
            $minLossClause_object = new \stdClass();
            $minLossClause_object->isAgree = (string) $request->input('min_loss_clause');
            $minLossClause_object->comment = (string) $request->input('min_loss_clause_comment');
            $insurerReplay_object->minLossClause = $minLossClause_object;
            $costConstruction_object = new \stdClass();
            $costConstruction_object->isAgree = (string) $request->input('cost_construction');
            $costConstruction_object->comment = (string) $request->input('cost_construction_comment');
            $insurerReplay_object->costConstruction = $costConstruction_object;
            $propertyValuationClause_object = new \stdClass();
            $propertyValuationClause_object->isAgree = (string) $request->input('property_valuation_clause');
            $propertyValuationClause_object->comment = (string) $request->input('property_valuation_clause_comment');
            $insurerReplay_object->propertyValuationClause = $propertyValuationClause_object;
            $accidentalDamage_object = new \stdClass();
            $accidentalDamage_object->isAgree = (string) $request->input('accidental_damage');
            $accidentalDamage_object->comment = (string) $request->input('accidental_damage_comment');
            $insurerReplay_object->accidentalDamage = $accidentalDamage_object;
            $auditorsFee_object = new \stdClass();
            $auditorsFee_object->isAgree = (string) $request->input('auditors_fee');
            $auditorsFee_object->comment = (string) $request->input('auditors_fee_comment');
            $insurerReplay_object->auditorsFee = $auditorsFee_object;
            $insurerReplay_object->smokeSoot = (string) $request->input('smoke_soot');
            $insurerReplay_object->boilerExplosion = (string) $request->input('boiler_explosion');
            $strikeRiot_object = new \stdClass();
            $strikeRiot_object->isAgree = (string) $request->input('strike_riot');
            $strikeRiot_object->comment = (string) $request->input('strike_riot_comment');
            $insurerReplay_object->strikeRiot = $strikeRiot_object;
            $chargeAirfreight_object = new \stdClass();
            $chargeAirfreight_object->isAgree = (string) $request->input('charge_airfreight');
            $chargeAirfreight_object->comment = (string) $request->input('charge_airfreight_comment');
            $insurerReplay_object->chargeAirfreight = $chargeAirfreight_object;
            if ($pipeline_details['formData']['machinery'] != '') {
                $insurerReplay_object->maliciousDamage = (string) $request->input('malicious_damage');
                $insurerReplay_object->burglaryExtension = (string) $request->input('burglary_extension');
                $burglaryFacilities_object = new \stdClass();
                $burglaryFacilities_object->isAgree = (string) $request->input('burglary_facilities');
                $burglaryFacilities_object->comment = (string) $request->input('burglary_facilities_comment');
                $insurerReplay_object->burglaryFacilities = $burglaryFacilities_object;
                $insurerReplay_object->tsunami = (string) $request->input('tsunami');
                $mobilePlant_object = new \stdClass();
                $mobilePlant_object->isAgree = (string) $request->input('mobile_plant');
                $mobilePlant_object->comment = (string) $request->input('mobile_plant_comment');
                $insurerReplay_object->mobilePlant = $mobilePlant_object;
                $clearanceDrains_object = new \stdClass();
                $clearanceDrains_object->isAgree = (string) $request->input('clearance_drains');
                $clearanceDrains_object->comment = (string) $request->input('clearance_drains_comment');
                $insurerReplay_object->clearanceDrains = $clearanceDrains_object;
                $accidentalFire_object = new \stdClass();
                $accidentalFire_object->isAgree = (string) $request->input('accidental_fire');
                $accidentalFire_object->comment = (string) $request->input('accidental_fire_comment');
                $insurerReplay_object->accidentalFire = $accidentalFire_object;
                $locationgSource_object = new \stdClass();
                $locationgSource_object->isAgree = (string) $request->input('locationg_source');
                $locationgSource_object->comment = (string) $request->input('locationg_source_comment');
                $insurerReplay_object->locationgSource = $locationgSource_object;
                $reWriting_object = new \stdClass();
                $reWriting_object->isAgree = (string) $request->input('re_writing');
                $reWriting_object->comment = (string) $request->input('re_writing_comment');
                $insurerReplay_object->reWriting = $reWriting_object;
                $insurerReplay_object->landSlip = (string) $request->input('land_slip');
                $civilAuthority_object = new \stdClass();
                $civilAuthority_object->isAgree = (string) $request->input('civil_authority');
                $civilAuthority_object->comment = (string) $request->input('civil_authority_comment');
                $insurerReplay_object->civilAuthority = $civilAuthority_object;
                $documentsPlans_object = new \stdClass();
                $documentsPlans_object->isAgree = (string) $request->input('documents_plans');
                $documentsPlans_object->comment = (string) $request->input('documents_plans_comment');
                $insurerReplay_object->documentsPlans = $documentsPlans_object;
                $propertyConstruction_object = new \stdClass();
                $propertyConstruction_object->isAgree = (string) $request->input('property_construction');
                $propertyConstruction_object->comment = (string) $request->input('property_construction_comment');
                $insurerReplay_object->propertyConstruction = $propertyConstruction_object;
                $architecture_object = new \stdClass();
                $architecture_object->isAgree = (string) $request->input('architecture');
                $architecture_object->comment = (string) $request->input('architecture_comment');
                $insurerReplay_object->architecture = $architecture_object;
                $automaticExtension_object = new \stdClass();
                $automaticExtension_object->isAgree = (string) $request->input('automatic_extension');
                $automaticExtension_object->comment = (string) $request->input('automatic_extension_comment');
                $insurerReplay_object->automaticExtension = $automaticExtension_object;
                $mortguageClause_object = new \stdClass();
                $mortguageClause_object->isAgree = (string) $request->input('mortguage_clause');
                $mortguageClause_object->comment = (string) $request->input('mortguage_clause_comment');
                $insurerReplay_object->mortguageClause = $mortguageClause_object;
                $surveyCommittee_object = new \stdClass();
                $surveyCommittee_object->isAgree = (string) $request->input('survey_committee');
                $surveyCommittee_object->comment = (string) $request->input('survey_committee_comment');
                $insurerReplay_object->surveyCommittee = $surveyCommittee_object;
                $protectExpense_object = new \stdClass();
                $protectExpense_object->isAgree = (string) $request->input('protect_expense');
                $protectExpense_object->comment = (string) $request->input('protect_expense_comment');
                $insurerReplay_object->protectExpense = $protectExpense_object;
                $tenatsClause_object = new \stdClass();
                $tenatsClause_object->isAgree = (string) $request->input('tenats_clause');
                $tenatsClause_object->comment = (string) $request->input('tenats_clause_comment');
                $insurerReplay_object->tenatsClause = $tenatsClause_object;
                $keysLockClause_object = new \stdClass();
                $keysLockClause_object->isAgree = (string) $request->input('keys_lock_clause');
                $keysLockClause_object->comment = (string) $request->input('keys_lock_clause_comment');
                $insurerReplay_object->keysLockClause = $keysLockClause_object;
                $exploratoryCost_object = new \stdClass();
                $exploratoryCost_object->isAgree = (string) $request->input('exploratory_cost');
                $exploratoryCost_object->comment = (string) $request->input('exploratory_cost_comment');
                $insurerReplay_object->exploratoryCost = $exploratoryCost_object;
                $propertyDetails_object = new \stdClass();
                $propertyDetails_object->isAgree = (string) $request->input('property_details');
                $propertyDetails_object->comment = (string) $request->input('property_details_comment');
                $insurerReplay_object->propertyDetails = $propertyDetails_object;
                $insurerReplay_object->smokeSootDamage = (string) $request->input('smoke_soot_damage');
                $insurerReplay_object->impactDamage = (string) $request->input('impact_damage');
                $insurerReplay_object->coverStatus = (string) $request->input('cover_status');
                $curiousWorkArt_object = new \stdClass();
                $curiousWorkArt_object->isAgree = (string) $request->input('curious_work_art');
                $curiousWorkArt_object->comment = (string) $request->input('curious_work_art_comment');
                $insurerReplay_object->curiousWorkArt = $curiousWorkArt_object;
                $insurerReplay_object->sprinklerInoperativeClause = (string) $request->input('sprinkler_inoperative_clause');
                $sprinklerUpgradation_object = new \stdClass();
                $sprinklerUpgradation_object->isAgree = (string) $request->input('sprinkler_upgradation');
                $sprinklerUpgradation_object->comment = (string) $request->input('sprinkler_upgradation_comment');
                $insurerReplay_object->sprinklerUpgradation = $sprinklerUpgradation_object;
                $fireProtection_object = new \stdClass();
                $fireProtection_object->isAgree = (string) $request->input('fire_protection');
                $fireProtection_object->comment = (string) $request->input('fire_protection_comment');
                $insurerReplay_object->fireProtection = $fireProtection_object;
                $burglaryExtensionDiesel_object = new \stdClass();
                $burglaryExtensionDiesel_object->isAgree = (string) $request->input('burglary_extension_diesel');
                $burglaryExtensionDiesel_object->comment = (string) $request->input('burglary_extension_diesel_comment');
                $insurerReplay_object->burglaryExtensionDiesel = $burglaryExtensionDiesel_object;
                $machineryBreakdown_object = new \stdClass();
                $machineryBreakdown_object->isAgree = (string) $request->input('machinery_breakdown');
                $machineryBreakdown_object->comment = (string) $request->input('machinery_breakdown_comment');
                $insurerReplay_object->machineryBreakdown = $machineryBreakdown_object;
                $extraCover_object = new \stdClass();
                $extraCover_object->isAgree = (string) $request->input('extra_cover');
                $extraCover_object->comment = (string) $request->input('extra_cover_comment');
                $insurerReplay_object->extraCover = $extraCover_object;
                $dissappearanceDetails_object = new \stdClass();
                $dissappearanceDetails_object->isAgree = (string) $request->input('dissappearance_details');
                $dissappearanceDetails_object->comment = (string) $request->input('dissappearance_details_comment');
                $insurerReplay_object->dissappearanceDetails = $dissappearanceDetails_object;
                $elaborationCoverage_object = new \stdClass();
                $elaborationCoverage_object->isAgree = (string) $request->input('elaboration_coverage');
                $elaborationCoverage_object->comment = (string) $request->input('elaboration_coverage_comment');
                $insurerReplay_object->elaborationCoverage = $elaborationCoverage_object;
                $insurerReplay_object->permitClause = (string) $request->input('permit_clause');
                $insurerReplay_object->repurchase = (string) $request->input('repurchase');
                $insurerReplay_object->bankruptcy = (string) $request->input('bankruptcy');
                $insurerReplay_object->aircraftDamage = (string) $request->input('aircraft_damage');
                $insurerReplay_object->appraisementClause = (string) $request->input('appraisement_clause');
                $insurerReplay_object->assiatnceInsured = (string) $request->input('assiatnce_insured');
                $moneySafe_object = new \stdClass();
                $moneySafe_object->isAgree = (string) $request->input('money_safe');
                $moneySafe_object->comment = (string) $request->input('money_safe_comment');
                $insurerReplay_object->moneySafe = $moneySafe_object;
                $moneyTransit_object = new \stdClass();
                $moneyTransit_object->isAgree = (string) $request->input('money_transit');
                $moneyTransit_object->comment = (string) $request->input('money_transit_comment');
                $insurerReplay_object->moneyTransit = $moneyTransit_object;
                $computersAllRisk_object = new \stdClass();
                $computersAllRisk_object->isAgree = (string) $request->input('computers_all_risk');
                $computersAllRisk_object->comment = (string) $request->input('computers_all_risk_comment');
                $insurerReplay_object->computersAllRisk = $computersAllRisk_object;
                $coverForDeterioration_object = new \stdClass();
                $coverForDeterioration_object->isAgree = (string) $request->input('cover_for_deterioration');
                $coverForDeterioration_object->comment = (string) $request->input('cover_for_deterioration_comment');
                $insurerReplay_object->coverForDeterioration = $coverForDeterioration_object;
                $insurerReplay_object->hailDamage = (string) $request->input('hail_damage');
                $insurerReplay_object->hazardousMaterialsSlip = (string) $request->input('hazardous_materials');
                $insurerReplay_object->thunderboltLightening = (string) $request->input('thunderbolt_lightening');
                $insurerReplay_object->waterRain = (string) $request->input('water_rain');
                $specifiedLocations_object = new \stdClass();
                $specifiedLocations_object->isAgree = (string) $request->input('specified_locations');
                $specifiedLocations_object->comment = (string) $request->input('specified_locations_comment');
                $insurerReplay_object->specifiedLocations = $specifiedLocations_object;
                $portableItems_object = new \stdClass();
                $portableItems_object->isAgree = (string) $request->input('portable_items');
                $portableItems_object->comment = (string) $request->input('portable_items_comment');
                $insurerReplay_object->portableItems = $portableItems_object;
                $propertyAndAlteration_object = new \stdClass();
                $propertyAndAlteration_object->isAgree = (string) $request->input('property_and_alteration');
                $propertyAndAlteration_object->comment = (string) $request->input('property_and_alteration_comment');
                $insurerReplay_object->propertyAndAlteration = $propertyAndAlteration_object;
                $dismantleingExt_object = new \stdClass();
                $dismantleingExt_object->isAgree = (string) $request->input('dismantleing_ext');
                $dismantleingExt_object->comment = (string) $request->input('dismantleing_ext_comment');
                $insurerReplay_object->dismantleingExt = $dismantleingExt_object;
                $automaticPurchase_object = new \stdClass();
                $automaticPurchase_object->isAgree = (string) $request->input('automatic_purchase');
                $automaticPurchase_object->comment = (string) $request->input('automatic_purchase_comment');
                $insurerReplay_object->automaticPurchase = $automaticPurchase_object;
                $coverForTrees_object = new \stdClass();
                $coverForTrees_object->isAgree = (string) $request->input('cover_for_trees');
                $coverForTrees_object->comment = (string) $request->input('cover_for_trees_comment');
                $insurerReplay_object->coverForTrees = $coverForTrees_object;
                $informReward_object = new \stdClass();
                $informReward_object->isAgree = (string) $request->input('inform_reward');
                $informReward_object->comment = (string) $request->input('inform_reward_comment');
                $insurerReplay_object->informReward = $informReward_object;
                $insurerReplay_object->coverLandscape = (string) $request->input('cover_landscape');
                $insurerReplay_object->damageWalls = (string) $request->input('damage_walls');
                if ($pipeline_details['formData']['occupancy']['type'] == "Building") {
                    $fitOutWorks_object = new \stdClass();
                    $fitOutWorks_object->isAgree = (string) $request->input('fit_out_works');
                    $fitOutWorks_object->comment = (string) $request->input('fit_out_works_comment');
                    $insurerReplay_object->fitOutWorks = $fitOutWorks_object;
                }
            }
            $insurerReplay_object->coverMechanical = (string) $request->input('cover_mechanical');
            $insurerReplay_object->coverExtWork = (string) $request->input('cover_ext_work');
            $insurerReplay_object->misdescriptionClause = (string) $request->input('misdescription_clause');
            $insurerReplay_object->tempRemovalClause = (string) $request->input('temp_removal_clause');
            $insurerReplay_object->otherInsuranceClause = (string) $request->input('other_insurance_clause');
            $insurerReplay_object->automaticAcqClause = (string) $request->input('automatic_acq_clause');
            $minorWorkExt_object = new \stdClass();
            $minorWorkExt_object->isAgree = (string) $request->input('minor_work_ext');
            $minorWorkExt_object->comment = (string) $request->input('minor_work_ext_comment');
            $insurerReplay_object->minorWorkExt = $minorWorkExt_object;
            $insurerReplay_object->saleInterestClause = (string) $request->input('sale_interest_clause');
            $insurerReplay_object->sueLabourClause = (string) $request->input('sue_labour_clause');
            $insurerReplay_object->electricalClause = (string) $request->input('electrical_cause');
            $insurerReplay_object->contractPriceClause = (string) $request->input('contract_price_clause');
            $insurerReplay_object->sprinklerUpgradationClause = (string) $request->input('sprinkler_upgradation_clause');
            $accidentalFixClass_object = new \stdClass();
            $accidentalFixClass_object->isAgree = (string) $request->input('accidental_fix_class');
            $accidentalFixClass_object->comment = (string) $request->input('accidental_fix_class_comment');
            $insurerReplay_object->accidentalFixClass = $accidentalFixClass_object;
            $insurerReplay_object->electronicInstallation = (string) $request->input('electronic_installation');
            $insurerReplay_object->brandTrademark = (string) $request->input('brand_trademark');
            $insurerReplay_object->lossNotification = (string) $request->input('loss_notification');
            $insurerReplay_object->brockersClaimClause = (string) $request->input('brockers_claim_clause');
            if ($pipeline_details['formData']['businessInterruption']['business_interruption'] == true) {
                $insurerReplay_object->addCostWorking = (string) $request->input('add_cost_working');
                $claimPreparationClause_object = new \stdClass();
                $claimPreparationClause_object->isAgree = (string) $request->input('claim_preparation_clause');
                $claimPreparationClause_object->comment = (string) $request->input('claim_preparation_clause_comment');
                $insurerReplay_object->claimPreparationClause = $claimPreparationClause_object;
                $suppliersExtension_object = new \stdClass();
                $suppliersExtension_object->isAgree = (string) $request->input('suppliers_extension');
                $suppliersExtension_object->comment = (string) $request->input('suppliers_extension_comment');
                $insurerReplay_object->suppliersExtension = $suppliersExtension_object;
                $accountantsClause_object = new \stdClass();
                $accountantsClause_object->isAgree = (string) $request->input('accountants_clause');
                $accountantsClause_object->comment = (string) $request->input('accountants_clause_comment');
                $insurerReplay_object->accountantsClause = $accountantsClause_object;
                $accountPayment_object = new \stdClass();
                $accountPayment_object->isAgree = (string) $request->input('account_payment');
                $accountPayment_object->comment = (string) $request->input('account_payment_comment');
                $insurerReplay_object->accountPayment = $accountPayment_object;
                $preventionDenialClause_object = new \stdClass();
                $preventionDenialClause_object->isAgree = (string) $request->input('prevention_denial_clause');
                $preventionDenialClause_object->comment = (string) $request->input('prevention_denial_clause_comment');
                $insurerReplay_object->preventionDenialClause = $preventionDenialClause_object;
                $premiumAdjClause_object = new \stdClass();
                $premiumAdjClause_object->isAgree = (string) $request->input('premium_adj_clause');
                $premiumAdjClause_object->comment = (string) $request->input('premium_adj_clause_comment');
                $insurerReplay_object->premiumAdjClause = $premiumAdjClause_object;
                $publicUtilityClause_object = new \stdClass();
                $publicUtilityClause_object->isAgree = (string) $request->input('public_utility_clause');
                $publicUtilityClause_object->comment = (string) $request->input('public_utility_clause_comment');
                $insurerReplay_object->publicUtilityClause = $publicUtilityClause_object;
                $insurerReplay_object->brockersClaimHandlingClause = (string) $request->input('brockers_claim_handling_clause');
                $accountsRecievable_object = new \stdClass();
                $accountsRecievable_object->isAgree = (string) $request->input('accounts_recievable');
                $accountsRecievable_object->comment = (string) $request->input('accounts_recievable_comment');
                $insurerReplay_object->accountsRecievable = $accountsRecievable_object;
                $insurerReplay_object->interDependency = (string) $request->input('inter_dependency');
                $extraExpense_object = new \stdClass();
                $extraExpense_object->isAgree = (string) $request->input('extra_expense');
                $extraExpense_object->comment = (string) $request->input('extra_expense_comment');
                $insurerReplay_object->extraExpense = $extraExpense_object;
                $insurerReplay_object->contaminatedWater = (string) $request->input('contaminated_water');
                $auditorsFeeCheck_object = new \stdClass();
                $auditorsFeeCheck_object->isAgree = (string) $request->input('auditors_fee_check');
                $auditorsFeeCheck_object->comment = (string) $request->input('auditors_fee_check_comment');
                $insurerReplay_object->auditorsFeeCheck = $auditorsFeeCheck_object;
                $expenseReduceLoss_object = new \stdClass();
                $expenseReduceLoss_object->isAgree = (string) $request->input('expense_reduce_loss');
                $expenseReduceLoss_object->comment = (string) $request->input('expense_reduce_loss_comment');
                $insurerReplay_object->expenseReduceLoss = $expenseReduceLoss_object;
                $nominatedLossAdjuster_object = new \stdClass();
                $nominatedLossAdjuster_object->isAgree = (string) $request->input('nominated_loss_adjuster');
                $nominatedLossAdjuster_object->comment = (string) $request->input('nominated_loss_adjuster_comment');
                $insurerReplay_object->nominatedLossAdjuster = $nominatedLossAdjuster_object;
                $outbreakDiscease_object = new \stdClass();
                $outbreakDiscease_object->isAgree = (string) $request->input('outbreak_discease');
                $outbreakDiscease_object->comment = (string) $request->input('outbreak_discease_comment');
                $insurerReplay_object->outbreakDiscease = $outbreakDiscease_object;
                $nonPublicFailure_object = new \stdClass();
                $nonPublicFailure_object->isAgree = (string) $request->input('non_public_failure');
                $nonPublicFailure_object->comment = (string) $request->input('non_public_failure_comment');
                $insurerReplay_object->nonPublicFailure = $nonPublicFailure_object;
                $premisesDetails_object = new \stdClass();
                $premisesDetails_object->isAgree = (string) $request->input('premises_details');
                $premisesDetails_object->comment = (string) $request->input('premises_details_comment');
                $insurerReplay_object->premisesDetails = $premisesDetails_object;
                $bombscare_object = new \stdClass();
                $bombscare_object->isAgree = (string) $request->input('bombscare');
                $bombscare_object->comment = (string) $request->input('bombscare_comment');
                $insurerReplay_object->bombscare = $bombscare_object;
                $bookDebits_object = new \stdClass();
                $bookDebits_object->isAgree = (string) $request->input('book_debits');
                $bookDebits_object->comment = (string) $request->input('book_debits_comment');
                $insurerReplay_object->bookDebits = $bookDebits_object;
                $publicFailure_object = new \stdClass();
                $publicFailure_object->isAgree = (string) $request->input('public_failure');
                $publicFailure_object->comment = (string) $request->input('public_failure_comment');
                $insurerReplay_object->publicFailure = $publicFailure_object;
                if (isset($pipeline_details['formData']['businessInterruption']['noLocations']) && $pipeline_details['formData']['businessInterruption']['noLocations'] > 1) {
                    if ($pipeline_details['formData']['departmentalClause'] == true) {
                        $insurerReplay_object->departmentalClause = (string) $request->input('departmental_clause');
                    }
                    if ($pipeline_details['formData']['rentLease'] == true) {
                        $rentLease_object = new \stdClass();
                        $rentLease_object->isAgree = (string) $request->input('rent_lease');
                        $rentLease_object->comment = (string) $request->input('rent_lease_comment');
                        $insurerReplay_object->rentLease = $rentLease_object;
                    }
                }
                if ($pipeline_details['formData']['CoverAccomodation']['coverAccomodation'] == true) {
                    $coverAccomodation_object = new \stdClass();
                    $coverAccomodation_object->isAgree = (string) $request->input('cover_accomodation');
                    $coverAccomodation_object->comment = (string) $request->input('cover_accomodation_comment');
                    $insurerReplay_object->coverAccomodation = $coverAccomodation_object;
                }
                if ($pipeline_details['formData']['contingentBusiness'] == true) {
                    $contingentBusiness_object = new \stdClass();
                    $contingentBusiness_object->isAgree = (string) $request->input('contingent_business');
                    $contingentBusiness_object->comment = (string) $request->input('contingent_business_comment');
                    $insurerReplay_object->contingentBusiness = $contingentBusiness_object;
                }
                if ($pipeline_details['formData']['nonOwnedProperties'] == true) {
                    $nonOwnedProperties_object = new \stdClass();
                    $nonOwnedProperties_object->isAgree = (string) $request->input('non_owned_properties');
                    $nonOwnedProperties_object->comment = (string) $request->input('non_owned_properties_comment');
                    $insurerReplay_object->nonOwnedProperties = $nonOwnedProperties_object;
                }
                if ($pipeline_details['formData']['royalties'] == true) {
                    $insurerReplay_object->royalties = (string) $request->input('royalties');
                }
            }
            if (isset($pipeline_details['formData']['cliamPremium']) && $pipeline_details['formData']['cliamPremium'] == 'combined_data') {
                $claimPremiyumDetails_object = new \stdClass();
                $claimPremiyumDetails_object->deductableProperty = (string) str_replace(',', '', $request->input('comdeductableProperty'));
                $claimPremiyumDetails_object->deductableBusiness = (string) str_replace(',', '', $request->input('comdeductableBusiness'));
                $claimPremiyumDetails_object->rateCombined = (string) str_replace(',', '', $request->input('comrateCombined'));
                $claimPremiyumDetails_object->premiumCombined = (string) str_replace(',', '', $request->input('compremiumCombined'));
                $claimPremiyumDetails_object->brokerage = (string) str_replace(',', '', $request->input('combrokerage'));
                $claimPremiyumDetails_object->warrantyProperty = (string) $request->input('comwarrantyProperty');
                $claimPremiyumDetails_object->warrantyBusiness = (string) $request->input('comwarrantyBusiness');
                $claimPremiyumDetails_object->exclusionProperty = (string) $request->input('comexclusionProperty');
                $claimPremiyumDetails_object->exclusionBusiness = (string) $request->input('comexclusionBusiness');
                $claimPremiyumDetails_object->specialProperty = (string) $request->input('comspecialProperty');
                $claimPremiyumDetails_object->specialBusiness = (string) $request->input('comspecialBusiness');
                $insurerReplay_object->claimPremiyumDetails = $claimPremiyumDetails_object;
            } elseif (isset($pipeline_details['formData']['cliamPremium']) && $pipeline_details['formData']['cliamPremium'] == 'only_property') {
                $claimPremiyumDetails_object = new \stdClass();
                $claimPremiyumDetails_object->deductableProperty = (string) str_replace(',', '', $request->input('onlydeductableProperty'));
                $claimPremiyumDetails_object->propertyRate = (string) str_replace(',', '', $request->input('onlypropertyRate'));
                $claimPremiyumDetails_object->propertyPremium = (string) str_replace(',', '', $request->input('onlypropertyPremium'));
                $claimPremiyumDetails_object->propertyBrockerage = (string) str_replace(',', '', $request->input('onlypropertyBrockerage'));
                $claimPremiyumDetails_object->propertyWarranty = (string) $request->input('onlypropertyWarranty');
                $claimPremiyumDetails_object->propertyExclusion = (string) $request->input('onlypropertyExclusion');
                $claimPremiyumDetails_object->propertySpecial = (string) $request->input('onlypropertySpecial');
                $insurerReplay_object->claimPremiyumDetails = $claimPremiyumDetails_object;
            } elseif (isset($pipeline_details['formData']['cliamPremium']) && $pipeline_details['formData']['cliamPremium'] == 'separate_property') {
                $claimPremiyumDetails_object = new \stdClass();
                $claimPremiyumDetails_object->propertySeparateDeductable = (string) str_replace(',', '', $request->input('propertySeparateDeductable'));
                $claimPremiyumDetails_object->propertySeparateRate = (string) str_replace(',', '', $request->input('propertySeparateRate'));
                $claimPremiyumDetails_object->propertySeparatePremium = (string) str_replace(',', '', $request->input('propertySeparatePremium'));
                $claimPremiyumDetails_object->propertySeparateBrokerage = (string) str_replace(',', '', $request->input('propertySeparateBrokerage'));
                $claimPremiyumDetails_object->propertySeparateWarranty = (string) $request->input('propertySeparateWarranty');
                $claimPremiyumDetails_object->propertySeparateExclusion = (string) $request->input('propertySeparateExclusion');
                $claimPremiyumDetails_object->propertySeparateSpecial = (string) $request->input('propertySeparateSpecial');
                $claimPremiyumDetails_object->businessSeparateDeductable = (string) str_replace(',', '', $request->input('businessSeparateDeductable'));
                $claimPremiyumDetails_object->businessSeparateRate = (string) str_replace(',', '', $request->input('businessSeparateRate'));
                $claimPremiyumDetails_object->businessSeparatePremium = (string) str_replace(',', '', $request->input('businessSeparatePremium'));
                $claimPremiyumDetails_object->businessSeparateBrokerage = (string) str_replace(',', '', $request->input('businessSeparateBrokerage'));
                $claimPremiyumDetails_object->businessSeparateWarranty = (string) $request->input('businessSeparateWarranty');
                $claimPremiyumDetails_object->businessSeparateExclusion = (string) $request->input('businessSeparateExclusion');
                $claimPremiyumDetails_object->businessSeparateSpecial = (string) $request->input('businessSeparateSpecial');
                $insurerReplay_object->claimPremiyumDetails = $claimPremiyumDetails_object;
            }
            if ($request->input('saveDraft') == 'true') {
                $insurerReplay_object->quoteStatus = (string) "saved";
                $updatedBy = new \stdClass();
                $updatedBy->id = new ObjectId(Auth::id());
                $updatedBy->name = Auth::user()->insurer['name'] . ' (' . Auth::user()->name . ')';
                $updatedBy->date = date('d/m/Y');
                $updatedBy->action = "Equotation saved and exit";
                $updatedByarray[] = $updatedBy;
                $pipeLineItems->push('updatedBy', $updatedByarray);
                $insurerData[] = $insurerReplay_object;
                $pipeLineItems->push('insurerReplay', $insurerData);
                $pipeLineItems->save();
                Session::flash('quotation', 'E-Quote saved successfully');
                return 'success';
            } else {
                $insurerReplay_object->quoteStatus = (string) "active";
                $insurerReplay_object->repliedDate = (string) date('d/m/Y');
                $insurerReplay_object->uniqueToken = (string) time() . rand(1000, 9999);
                $insurerReplay_object->repliedMethod = (string) "insurer";
                if ($request->input('quoteActive') == 'true') {
                    $updatedBy = new \stdClass();
                    $updatedBy->id = new ObjectId(Auth::id());
                    $updatedBy->name = Auth::user()->insurer['name'] . ' (' . Auth::user()->name . ')';
                    $updatedBy->date = date('d/m/Y');
                    $updatedBy->action = "E quote amended";
                    $updatedByarray[] = $updatedBy;
                    $pipeLineItems->push('updatedBy', $updatedByarray);
                } else {
                    $updatedBy = new \stdClass();
                    $updatedBy->id = new ObjectId(Auth::id());
                    $updatedBy->name = Auth::user()->insurer['name'] . ' (' . Auth::user()->name . ')';
                    $updatedBy->date = date('d/m/Y');
                    $updatedBy->action = "E quote gave";
                    $updatedByarray[] = $updatedBy;
                    $pipeLineItems->push('updatedBy', $updatedByarray);
                }

                $insurerData[] = $insurerReplay_object;

                if ($pipeLineItems->insurerReplay) {
                    $pipeLineItems->push('insurerReplay', $insurerData);
                    if ($request->input('quoteActive') == 'false') {
                        $array[] = new ObjectId(Auth::user()->insurer['id']);
                    }
                    $pipeLineItems->save();
                } else {
                    $pipeLineItems->insurerReplay = $insurerData;
                    if ($request->input('quoteActive') == 'false') {
                        $array[] = new ObjectId(Auth::user()->insurer['id']);
                    }
                    $pipeLineItems->save();
                }
                if ($request->input('quoteActive') == 'false') {
                    $count = 0;
                    $insurers_repeat = $pipeLineItems->insuraceCompanyList;
                    foreach ($insurers_repeat as $temp) {
                        if ($temp['id'] == $insurerId && $temp['status'] == 'active') {
                            PipelineItems::where('_id', $pipeLineId)->update(array('insuraceCompanyList.' . $count . '.status' => 'inactive'));
                            break;
                        }
                        $count++;
                    }
                }
                $this->mailSend($pipeLineId);
                if ($request->input('quoteActive') == 'false') {
                    Session::flash('quotation', 'E-Quote given successfully');
                    return "success";
                } else {
                    Session::flash('quotation', 'E-Quote amended successfully');
                    return "amended";
                }
            }
        } catch (\Exception $e) {
            if ($request->input('quoteActive') == 'false') {
                dd($e);
                Session::flash('error', 'Failed');
                return "failed";
            } elseif ($request->input('saveDraft') == 'true') {
                dd($e);
                Session::flash('error', 'Failed');
                return "failed";
            } else {
                Session::flash('error', 'Quote amendment failed');
                return "amended";
            }
        }
    }

    /**
     * save insurer reply for property
     */
    public function FirePerilsSave(Request $request)
    {
        try {
            $insurerId = new ObjectId(Auth::user()->insurer['id']);
            $pipeLineId = $request->input('id');
            $pipeLineItems = PipelineItems::where('_id', $pipeLineId)->first();
            $pipeline_details = $pipeLineItems;
            if (!$pipeLineItems) {
                Session::flash('error', 'Pipeline not defined');
                return "failed";
            }
            if ($request->input('quoteActive') == 'true') {
                $replies = $pipeLineItems['insurerReplay'];
                foreach ($replies as $count => $reply) {
                    if ($reply['insurerDetails']['insurerId'] == $insurerId && $reply['quoteStatus'] == 'active' && $reply['uniqueToken'] == $request->input('hiddenToken')) {
                        PipelineItems::where('_id', $pipeLineId)->update(array('insurerReplay.' . $count . '.quoteStatus' => 'inactive'));
                    }
                }
            } else {
                PipelineItems::where('_id', $pipeLineId)->pull('insurerReplay', ['insurerDetails.insurerId' => $insurerId, 'quoteStatus' => 'saved']);
            }
            $insurerReplay_object = new \stdClass();
            $insurerDetails_object = new \stdClass();
            $insurerDetails_object->insurerId = new ObjectId(Auth::user()->insurer['id']);
            $insurerDetails_object->insurerName = Auth::user()->insurer['name'];
            $insurerDetails_object->givenById = new ObjectId(Auth::id());
            $insurerDetails_object->givenByName = Auth::user()->name;
            $insurerReplay_object->insurerDetails = $insurerDetails_object;

            if ($pipeline_details['formData']['saleClause'] == true) {
                $insurerReplay_object->saleClause = (string) $request->input('sale_interest_clause');
            }

            $fireBrigade_object = new \stdClass();
            $fireBrigade_object->isAgree = (string) $request->input('fire_brigade');
            $fireBrigade_object->comment = (string) $request->input('fire_brigade_comment');
            $insurerReplay_object->fireBrigade = $fireBrigade_object;

            $insurerReplay_object->clauseWording = (string) $request->input('clause_wording');
            $insurerReplay_object->automaticReinstatement = (string) $request->input('automatic_reinstatement');

            $capitalClause_object = new \stdClass();
            $capitalClause_object->isAgree = (string) $request->input('capital_clause');
            $capitalClause_object->comment = (string) $request->input('capital_clause_comment');
            $insurerReplay_object->capitalClause = $capitalClause_object;

            $insurerReplay_object->mainClause = (string) $request->input('main_clause');

            $repairCost_object = new \stdClass();
            $repairCost_object->isAgree = (string) $request->input('repair_cost');
            $repairCost_object->comment = (string) $request->input('repair_cost_comment');
            $insurerReplay_object->repairCost = $repairCost_object;

            $debris_object = new \stdClass();
            $debris_object->isAgree = (string) $request->input('debris');
            $debris_object->comment = (string) $request->input('debris_comment');
            $insurerReplay_object->debris = $debris_object;

            $insurerReplay_object->reinstatementValClass = (string) $request->input('reinstatement_val_class');

            $insurerReplay_object->waiver = (string) $request->input('waiver');

            $insurerReplay_object->trace = (string) $request->input('trade_access');

            $publicClause_object = new \stdClass();
            $publicClause_object->isAgree = (string) $request->input('public_clause');
            $publicClause_object->comment = (string) $request->input('public_clause_comment');
            $insurerReplay_object->publicClause = $publicClause_object;

            $contentsClause_object = new \stdClass();
            $contentsClause_object->isAgree = (string) $request->input('contents_clause');
            $contentsClause_object->comment = (string) $request->input('contents_clause_comment');
            $insurerReplay_object->contentsClause = $contentsClause_object;

            if ($pipeline_details['formData']['errorOmission'] == true) {
                $insurerReplay_object->errorOmission = (string) $request->input('error_omission');
            }

            $insurerReplay_object->alterationClause = (string) $request->input('alteration_clause');

            $insurerReplay_object->tempRemovalClause = (string) $request->input('temp_removal_clause');

            $proFee_object = new \stdClass();
            $proFee_object->isAgree = (string) $request->input('prof_fee');
            $proFee_object->comment = (string) $request->input('prof_fee_comment');
            $insurerReplay_object->proFee = $proFee_object;

            $expenseClause_object = new \stdClass();
            $expenseClause_object->isAgree = (string) $request->input('expense_clause');
            $expenseClause_object->comment = (string) $request->input('expense_clause_comment');
            $insurerReplay_object->expenseClause = $expenseClause_object;

            $desigClause_object = new \stdClass();
            $desigClause_object->isAgree = (string) $request->input('desig_clause');
            $desigClause_object->comment = (string) $request->input('desig_clause_comment');
            $insurerReplay_object->desigClause = $desigClause_object;

            if (isset($pipeline_details['formData']['buildingInclude']) && $pipeline_details['formData']['buildingInclude'] == true) {
                $insurerReplay_object->adjBusinessClause = (string) $request->input('adj_business_caluse');
            }

            $insurerReplay_object->cancelThirtyClause = (string) $request->input('cancel_thirty_clause');

            $insurerReplay_object->primaryInsuranceClause = (string) $request->input('primary_insurance_clause');

            $paymentAccountClause_object = new \stdClass();
            $paymentAccountClause_object->isAgree = (string) $request->input('payment_account_clause');
            $paymentAccountClause_object->comment = (string) $request->input('payment_account_clause_comment');
            $insurerReplay_object->paymentAccountClause = $paymentAccountClause_object;

            $insurerReplay_object->nonInvalidClause = (string) $request->input('non_invalid_clause');

            $insurerReplay_object->warrantyConditionClause = (string) $request->input('warranty_condition_clause');

            $escalationClause_object = new \stdClass();
            $escalationClause_object->isAgree = (string) $request->input('escalation_clause');
            $escalationClause_object->comment = (string) $request->input('escalation_clause_comment');
            $insurerReplay_object->escalationClause = $escalationClause_object;

            $insurerReplay_object->addInterestClause = (string) $request->input('add_interest_clause');

            if (isset($pipeline_details['formData']['stock']) && $pipeline_details['formData']['stock'] != '') {
                $stockDeclaration_object = new \stdClass();
                $stockDeclaration_object->isAgree = (string) $request->input('stock_declaration');
                $stockDeclaration_object->comment = (string) $request->input('stock_declaration_comment');
                $insurerReplay_object->stockDeclaration = $stockDeclaration_object;
            }
            $insurerReplay_object->improvementClause = (string) $request->input('improvement_clause');

            $automaticClause_object = new \stdClass();
            $automaticClause_object->isAgree = (string) $request->input('automaticClause');
            $automaticClause_object->comment = (string) $request->input('automaticClause_comment');
            $insurerReplay_object->automaticClause = $automaticClause_object;

            $reduseLoseClause_object = new \stdClass();
            $reduseLoseClause_object->isAgree = (string) $request->input('reduse_lose_clause');
            $reduseLoseClause_object->comment = (string) $request->input('reduse_lose_clause_comment');
            $insurerReplay_object->reduseLoseClause = $reduseLoseClause_object;

            if ($pipeline_details['formData']['buildingInclude'] != '' && $pipeline_details['formData']['demolitionClause'] == true) {
                $demolitionClause_object = new \stdClass();
                $demolitionClause_object->isAgree = (string) $request->input('demolition_clause');
                $demolitionClause_object->comment = (string) $request->input('demolition_clause_comment');
                $insurerReplay_object->demolitionClause = $demolitionClause_object;
            }

            $insurerReplay_object->noControlClause = (string) $request->input('no_control_clause');

            $preparationCostClause_object = new \stdClass();
            $preparationCostClause_object->isAgree = (string) $request->input('preparation_cost_clause');
            $preparationCostClause_object->comment = (string) $request->input('preparation_cost_clause_comment');
            $insurerReplay_object->preparationCostClause = $preparationCostClause_object;

            $insurerReplay_object->coverPropertyCon = (string) $request->input('cover_property_con');

            $personalEffectsEmployee_object = new \stdClass();
            $personalEffectsEmployee_object->isAgree = (string) $request->input('personal_effects_employee');
            $personalEffectsEmployee_object->comment = (string) $request->input('personal_effects_employee_comment');
            $insurerReplay_object->personalEffectsEmployee = $personalEffectsEmployee_object;

            $incidentLandTransit_object = new \stdClass();
            $incidentLandTransit_object->isAgree = (string) $request->input('incident_land_transit');
            $incidentLandTransit_object->comment = (string) $request->input('incident_land_transit_comment');
            $insurerReplay_object->incidentLandTransit = $incidentLandTransit_object;

            $insurerReplay_object->lossOrDamage = (string) $request->input('loss_or_damage');

            $nominatedLossAdjusterClause_object = new \stdClass();
            $nominatedLossAdjusterClause_object->isAgree = (string) $request->input('nominated_loss_adjuster_clause');
            $nominatedLossAdjusterClause_object->comment = (string) $request->input('nominated_loss_adjuster_clause_comment');
            $insurerReplay_object->nominatedLossAdjusterClause = $nominatedLossAdjusterClause_object;

            $insurerReplay_object->sprinkerLeakage = (string) $request->input('sprinker_leakage');

            $minLossClause_object = new \stdClass();
            $minLossClause_object->isAgree = (string) $request->input('min_loss_clause');
            $minLossClause_object->comment = (string) $request->input('min_loss_clause_comment');
            $insurerReplay_object->minLossClause = $minLossClause_object;

            $costConstruction_object = new \stdClass();
            $costConstruction_object->isAgree = (string) $request->input('cost_construction');
            $costConstruction_object->comment = (string) $request->input('cost_construction_comment');
            $insurerReplay_object->costConstruction = $costConstruction_object;

            if (isset($pipeline_details['formData']['annualRent']) && $pipeline_details['formData']['annualRent'] != '') {
                $loss_rent_object = new \stdClass();
                $loss_rent_object->isAgree = (string) $request->input('loss_rent');
                $loss_rent_object->comment = (string) $request->input('loss_rent_comment');
                $insurerReplay_object->lossRent = $loss_rent_object;
            }

            $propertyValuationClause_object = new \stdClass();
            $propertyValuationClause_object->isAgree = (string) $request->input('property_valuation_clause');
            $propertyValuationClause_object->comment = (string) $request->input('property_valuation_clause_comment');
            $insurerReplay_object->propertyValuationClause = $propertyValuationClause_object;

            $accidentalDamage_object = new \stdClass();
            $accidentalDamage_object->isAgree = (string) $request->input('accidental_damage');
            $accidentalDamage_object->comment = (string) $request->input('accidental_damage_comment');
            $insurerReplay_object->accidentalDamage = $accidentalDamage_object;

            $auditorsFee_object = new \stdClass();
            $auditorsFee_object->isAgree = (string) $request->input('auditors_fee');
            $auditorsFee_object->comment = (string) $request->input('auditors_fee_comment');
            $insurerReplay_object->auditorsFee = $auditorsFee_object;

            $insurerReplay_object->smokeSoot = (string) $request->input('smoke_soot');

            $insurerReplay_object->boilerExplosion = (string) $request->input('boiler_explosion');

            $chargeAirfreight_object = new \stdClass();
            $chargeAirfreight_object->isAgree = (string) $request->input('charge_airfreight');
            $chargeAirfreight_object->comment = (string) $request->input('charge_airfreight_comment');
            $insurerReplay_object->chargeAirfreight = $chargeAirfreight_object;

            $insurerReplay_object->tempRemoval = (string) $request->input('temp_removal');

            $strikeRiot_object = new \stdClass();
            $strikeRiot_object->isAgree = (string) $request->input('strike_riot');
            $strikeRiot_object->comment = (string) $request->input('strike_riot_comment');
            $insurerReplay_object->strikeRiot = $strikeRiot_object;

            $insurerReplay_object->coverMechanical = (string) $request->input('cover_mechanical');

            $insurerReplay_object->coverExtWork = (string) $request->input('cover_ext_work');

            $insurerReplay_object->misdescriptionClause = (string) $request->input('misdescription_clause');

            $insurerReplay_object->otherInsuranceClause = (string) $request->input('other_insurance_clause');

            $insurerReplay_object->automaticAcqClause = (string) $request->input('automatic_acq_clause');

            if (@$pipeline_details['formData']['occupancy']['type'] == 'Residence' || @$pipeline_details['formData']['occupancy']['type'] == 'Labour Camp') {
                $cover_object = new \stdClass();
                $cover_object->isAgree = (string) $request->input('cover_alternative');
                $cover_object->comment = (string) $request->input('cover_alternative_comment');
                $insurerReplay_object->coverAlternative = $cover_object;
            }

            if ($pipeline_details['formData']['businessType']) {
                $insurerReplay_object->coverExihibition = (string) $request->input('cover_exihibition');
            }

            if ($pipeline_details['formData']['occupancy']['type'] == 'Warehouse'
                || @$pipeline_details['formData']['occupancy']['type'] == 'Factory'
                || @$pipeline_details['formData']['occupancy']['type'] == 'Others'
            ) {
                $insurerReplay_object->coverProperty = (string) $request->input('cover_property');
            }

            if ($pipeline_details['formData']['otherItems'] != '') {
                $property_care_object = new \stdClass();
                $property_care_object->isAgree = (string) $request->input('property_care');
                $property_care_object->comment = (string) $request->input('property_care_comment');
                $insurerReplay_object->propertyCare = $property_care_object;
            }

            $minorWorkExt_object = new \stdClass();
            $minorWorkExt_object->isAgree = (string) $request->input('minor_work_ext');
            $minorWorkExt_object->comment = (string) $request->input('minor_work_ext_comment');
            $insurerReplay_object->minorWorkExt = $minorWorkExt_object;

            $insurerReplay_object->saleInterestClause = (string) $request->input('sale_interest_clause');

            $insurerReplay_object->sueLabourClause = (string) $request->input('sue_labour_clause');

            if ($pipeline_details['formData']['bankPolicy']['bankPolicy'] == true) {
                $insurerReplay_object->lossPayee = (string) $request->input('loss_payee');
            }

            $insurerReplay_object->electricalClause = (string) $request->input('electrical_cause');

            $insurerReplay_object->contractPriceClause = (string) $request->input('contract_price_clause');

            $insurerReplay_object->sprinklerUpgradationClause = (string) $request->input('sprinkler_upgradation_clause');

            $accidentalFixClass_object = new \stdClass();
            $accidentalFixClass_object->isAgree = (string) $request->input('accidental_fix_class');
            $accidentalFixClass_object->comment = (string) $request->input('accidental_fix_class_comment');
            $insurerReplay_object->accidentalFixClass = $accidentalFixClass_object;

            $insurerReplay_object->electronicInstallation = (string) $request->input('electronic_installation');

            if ($pipeline_details['formData']['businessType'] == "Art galleries/ fine arts collection"
                || $pipeline_details['formData']['businessType'] == "Colleges/ Universities/ schools & educational institute"
                || $pipeline_details['formData']['businessType'] == "Hotels/ boarding houses/ motels/ service apartments"
                || $pipeline_details['formData']['businessType'] == "Hotel multiple cover"
                || $pipeline_details['formData']['businessType'] == "Museum/ heritage sites"
            ) {
                $insurerReplay_object->coverCurios = (string) $request->input('cover_curios');
            }

            $insurerReplay_object->brandTrademark = (string) $request->input('brand_trademark');

            $insurerReplay_object->ownerPrinciple = (string) $request->input('indemnity_owner');

            if ($pipeline_details['formData']['conductClause'] == true) {
                $insurerReplay_object->conductClause = (string) $request->input('conduct_clause');
            }

            $insurerReplay_object->lossNotification = (string) $request->input('loss_notification');

            $insurerReplay_object->brockersClaimClause = (string) $request->input('brockers_claim_clause');

            if ($pipeline_details['formData']['businessInterruption']['business_interruption'] == true) {
                $insurerReplay_object->addCostWorking = (string) $request->input('add_cost_working');

                $claimPreparationClause_object = new \stdClass();
                $claimPreparationClause_object->isAgree = (string) $request->input('claim_preparation_clause');
                $claimPreparationClause_object->comment = (string) $request->input('claim_preparation_clause_comment');
                $insurerReplay_object->claimPreparationClause = $claimPreparationClause_object;

                $suppliersExtension_object = new \stdClass();
                $suppliersExtension_object->isAgree = (string) $request->input('suppliers_extension');
                $suppliersExtension_object->comment = (string) $request->input('suppliers_extension_comment');
                $insurerReplay_object->suppliersExtension = $suppliersExtension_object;

                $accountantsClause_object = new \stdClass();
                $accountantsClause_object->isAgree = (string) $request->input('accountants_clause');
                $accountantsClause_object->comment = (string) $request->input('accountants_clause_comment');
                $insurerReplay_object->accountantsClause = $accountantsClause_object;

                $accountPayment_object = new \stdClass();
                $accountPayment_object->isAgree = (string) $request->input('account_payment');
                $accountPayment_object->comment = (string) $request->input('account_payment_comment');
                $insurerReplay_object->accountPayment = $accountPayment_object;
                $preventionDenialClause_object = new \stdClass();

                $preventionDenialClause_object->isAgree = (string) $request->input('prevention_denial_clause');
                $preventionDenialClause_object->comment = (string) $request->input('prevention_denial_clause_comment');
                $insurerReplay_object->preventionDenialClause = $preventionDenialClause_object;
                $premiumAdjClause_object = new \stdClass();

                $premiumAdjClause_object->isAgree = (string) $request->input('premium_adj_clause');
                $premiumAdjClause_object->comment = (string) $request->input('premium_adj_clause_comment');
                $insurerReplay_object->premiumAdjClause = $premiumAdjClause_object;
                $publicUtilityClause_object = new \stdClass();

                $publicUtilityClause_object->isAgree = (string) $request->input('public_utility_clause');
                $publicUtilityClause_object->comment = (string) $request->input('public_utility_clause_comment');
                $insurerReplay_object->publicUtilityClause = $publicUtilityClause_object;
                $insurerReplay_object->brockersClaimHandlingClause = (string) $request->input('brockers_claim_handling_clause');

                $accountsRecievable_object = new \stdClass();
                $accountsRecievable_object->isAgree = (string) $request->input('accounts_recievable');
                $accountsRecievable_object->comment = (string) $request->input('accounts_recievable_comment');
                $insurerReplay_object->accountsRecievable = $accountsRecievable_object;

                $insurerReplay_object->interDependency = (string) $request->input('inter_dependency');

                $extraExpense_object = new \stdClass();
                $extraExpense_object->isAgree = (string) $request->input('extra_expense');
                $extraExpense_object->comment = (string) $request->input('extra_expense_comment');
                $insurerReplay_object->extraExpense = $extraExpense_object;

                $insurerReplay_object->contaminatedWater = (string) $request->input('contaminated_water');

                $auditorsFeeCheck_object = new \stdClass();
                $auditorsFeeCheck_object->isAgree = (string) $request->input('auditors_fee_check');
                $auditorsFeeCheck_object->comment = (string) $request->input('auditors_fee_check_comment');
                $insurerReplay_object->auditorsFeeCheck = $auditorsFeeCheck_object;

                $expenseReduceLoss_object = new \stdClass();
                $expenseReduceLoss_object->isAgree = (string) $request->input('expense_reduce_loss');
                $expenseReduceLoss_object->comment = (string) $request->input('expense_reduce_loss_comment');
                $insurerReplay_object->expenseReduceLoss = $expenseReduceLoss_object;

                $nominatedLossAdjuster_object = new \stdClass();
                $nominatedLossAdjuster_object->isAgree = (string) $request->input('nominated_loss_adjuster');
                $nominatedLossAdjuster_object->comment = (string) $request->input('nominated_loss_adjuster_comment');
                $insurerReplay_object->nominatedLossAdjuster = $nominatedLossAdjuster_object;

                $outbreakDiscease_object = new \stdClass();
                $outbreakDiscease_object->isAgree = (string) $request->input('outbreak_discease');
                $outbreakDiscease_object->comment = (string) $request->input('outbreak_discease_comment');
                $insurerReplay_object->outbreakDiscease = $outbreakDiscease_object;

                $nonPublicFailure_object = new \stdClass();
                $nonPublicFailure_object->isAgree = (string) $request->input('non_public_failure');
                $nonPublicFailure_object->comment = (string) $request->input('non_public_failure_comment');
                $insurerReplay_object->nonPublicFailure = $nonPublicFailure_object;

                $premisesDetails_object = new \stdClass();
                $premisesDetails_object->isAgree = (string) $request->input('premises_details');
                $premisesDetails_object->comment = (string) $request->input('premises_details_comment');
                $insurerReplay_object->premisesDetails = $premisesDetails_object;

                $premisesDetails_object = new \stdClass();
                $premisesDetails_object->isAgree = (string) $request->input('denialclause');
                $premisesDetails_object->comment = (string) $request->input('denialclause_comment');
                $insurerReplay_object->DenialClause = $premisesDetails_object;

                $bombscare_object = new \stdClass();
                $bombscare_object->isAgree = (string) $request->input('bombscare');
                $bombscare_object->comment = (string) $request->input('bombscare_comment');
                $insurerReplay_object->bombscare = $bombscare_object;

                $bookDebits_object = new \stdClass();
                $bookDebits_object->isAgree = (string) $request->input('book_debits');
                $bookDebits_object->comment = (string) $request->input('book_debits_comment');
                $insurerReplay_object->bookDebits = $bookDebits_object;

                $publicFailure_object = new \stdClass();
                $publicFailure_object->isAgree = (string) $request->input('public_failure');
                $publicFailure_object->comment = (string) $request->input('public_failure_comment');
                $insurerReplay_object->publicFailure = $publicFailure_object;

                if (isset($pipeline_details['formData']['businessInterruption']['noLocations']) && $pipeline_details['formData']['businessInterruption']['noLocations'] > 1) {
                    if ($pipeline_details['formData']['departmentalClause'] == true) {
                        $insurerReplay_object->departmentalClause = (string) $request->input('departmental_clause');
                    }
                    if ($pipeline_details['formData']['rentLease'] == true) {
                        $rentLease_object = new \stdClass();
                        $rentLease_object->isAgree = (string) $request->input('rent_lease');
                        $rentLease_object->comment = (string) $request->input('rent_lease_comment');
                        $insurerReplay_object->rentLease = $rentLease_object;
                    }
                }
                if ($pipeline_details['formData']['CoverAccomodation']['coverAccomodation'] == true) {
                    $coverAccomodation_object = new \stdClass();
                    $coverAccomodation_object->isAgree = (string) $request->input('cover_accomodation');
                    $coverAccomodation_object->comment = (string) $request->input('cover_accomodation_comment');
                    $insurerReplay_object->coverAccomodation = $coverAccomodation_object;
                }

                if ($pipeline_details['formData']['demolitionCost'] == true) {
                    $coverAccomodation_object = new \stdClass();
                    $coverAccomodation_object->isAgree = (string) $request->input('demolitionCost');
                    $coverAccomodation_object->comment = (string) $request->input('demolitionCost_comment');
                    $insurerReplay_object->demolitionCost = $coverAccomodation_object;
                }

                if ($pipeline_details['formData']['contingentBusiness'] == true) {
                    $contingentBusiness_object = new \stdClass();
                    $contingentBusiness_object->isAgree = (string) $request->input('contingent_business');
                    $contingentBusiness_object->comment = (string) $request->input('contingent_business_comment');
                    $insurerReplay_object->contingentBusiness = $contingentBusiness_object;
                }
                if ($pipeline_details['formData']['nonOwnedProperties'] == true) {
                    $nonOwnedProperties_object = new \stdClass();
                    $nonOwnedProperties_object->isAgree = (string) $request->input('non_owned_properties');
                    $nonOwnedProperties_object->comment = (string) $request->input('non_owned_properties_comment');
                    $insurerReplay_object->nonOwnedProperties = $nonOwnedProperties_object;
                }
                if ($pipeline_details['formData']['royalties'] == true) {
                    $insurerReplay_object->royalties = (string) $request->input('royalties');
                }
            }
            if (isset($pipeline_details['formData']['cliamPremium']) && $pipeline_details['formData']['cliamPremium'] == 'combined_data') {
                $claimPremiyumDetails_object = new \stdClass();
                $claimPremiyumDetails_object->deductableProperty = (string) str_replace(',', '', $request->input('comdeductableProperty'));
                $claimPremiyumDetails_object->deductableBusiness = (string) str_replace(',', '', $request->input('comdeductableBusiness'));
                $claimPremiyumDetails_object->rateCombined = (string) str_replace(',', '', $request->input('comrateCombined'));
                $claimPremiyumDetails_object->premiumCombined = (string) str_replace(',', '', $request->input('compremiumCombined'));
                $claimPremiyumDetails_object->brokerage = (string) str_replace(',', '', $request->input('combrokerage'));
                $claimPremiyumDetails_object->warrantyProperty = (string) $request->input('comwarrantyProperty');
                $claimPremiyumDetails_object->warrantyBusiness = (string) $request->input('comwarrantyBusiness');
                $claimPremiyumDetails_object->exclusionProperty = (string) $request->input('comexclusionProperty');
                $claimPremiyumDetails_object->exclusionBusiness = (string) $request->input('comexclusionBusiness');
                $claimPremiyumDetails_object->specialProperty = (string) $request->input('comspecialProperty');
                $claimPremiyumDetails_object->specialBusiness = (string) $request->input('comspecialBusiness');
                $insurerReplay_object->claimPremiyumDetails = $claimPremiyumDetails_object;
            } elseif (isset($pipeline_details['formData']['cliamPremium']) && $pipeline_details['formData']['cliamPremium'] == 'only_fire') {
                $claimPremiyumDetails_object = new \stdClass();
                $claimPremiyumDetails_object->deductableProperty = (string) str_replace(',', '', $request->input('onlydeductableProperty'));
                $claimPremiyumDetails_object->propertyRate = (string) str_replace(',', '', $request->input('onlypropertyRate'));
                $claimPremiyumDetails_object->propertyPremium = (string) str_replace(',', '', $request->input('onlypropertyPremium'));
                $claimPremiyumDetails_object->propertyBrockerage = (string) str_replace(',', '', $request->input('onlypropertyBrockerage'));
                $claimPremiyumDetails_object->propertyWarranty = (string) $request->input('onlypropertyWarranty');
                $claimPremiyumDetails_object->propertyExclusion = (string) $request->input('onlypropertyExclusion');
                $claimPremiyumDetails_object->propertySpecial = (string) $request->input('onlypropertySpecial');
                $insurerReplay_object->claimPremiyumDetails = $claimPremiyumDetails_object;
            } elseif (isset($pipeline_details['formData']['cliamPremium']) && $pipeline_details['formData']['cliamPremium'] == 'separate_fire') {
                $claimPremiyumDetails_object = new \stdClass();
                $claimPremiyumDetails_object->propertySeparateDeductable = (string) str_replace(',', '', $request->input('propertySeparateDeductable'));
                $claimPremiyumDetails_object->propertySeparateRate = (string) str_replace(',', '', $request->input('propertySeparateRate'));
                $claimPremiyumDetails_object->propertySeparatePremium = (string) str_replace(',', '', $request->input('propertySeparatePremium'));
                $claimPremiyumDetails_object->propertySeparateBrokerage = (string) str_replace(',', '', $request->input('propertySeparateBrokerage'));
                $claimPremiyumDetails_object->propertySeparateWarranty = (string) $request->input('propertySeparateWarranty');
                $claimPremiyumDetails_object->propertySeparateExclusion = (string) $request->input('propertySeparateExclusion');
                $claimPremiyumDetails_object->propertySeparateSpecial = (string) $request->input('propertySeparateSpecial');
                $claimPremiyumDetails_object->businessSeparateDeductable = (string) str_replace(',', '', $request->input('businessSeparateDeductable'));
                $claimPremiyumDetails_object->businessSeparateRate = (string) str_replace(',', '', $request->input('businessSeparateRate'));
                $claimPremiyumDetails_object->businessSeparatePremium = (string) str_replace(',', '', $request->input('businessSeparatePremium'));
                $claimPremiyumDetails_object->businessSeparateBrokerage = (string) str_replace(',', '', $request->input('businessSeparateBrokerage'));
                $claimPremiyumDetails_object->businessSeparateWarranty = (string) $request->input('businessSeparateWarranty');
                $claimPremiyumDetails_object->businessSeparateExclusion = (string) $request->input('businessSeparateExclusion');
                $claimPremiyumDetails_object->businessSeparateSpecial = (string) $request->input('businessSeparateSpecial');
                $insurerReplay_object->claimPremiyumDetails = $claimPremiyumDetails_object;
            }

            if ($request->input('saveDraft') == 'true') {
                $insurerReplay_object->quoteStatus = (string) "saved";
                $updatedBy = new \stdClass();
                $updatedBy->id = new ObjectId(Auth::id());
                $updatedBy->name = Auth::user()->insurer['name'] . ' (' . Auth::user()->name . ')';
                $updatedBy->date = date('d/m/Y');
                $updatedBy->action = "Equotation saved and exit";
                $updatedByarray[] = $updatedBy;
                $pipeLineItems->push('updatedBy', $updatedByarray);
                $insurerData[] = $insurerReplay_object;
                $pipeLineItems->push('insurerReplay', $insurerData);
                $pipeLineItems->save();
                Session::flash('quotation', 'E-Quote saved successfully');
                return 'success';
            } else {
                $insurerReplay_object->quoteStatus = (string) "active";
                $insurerReplay_object->repliedDate = (string) date('d/m/Y');
                $insurerReplay_object->uniqueToken = (string) time() . rand(1000, 9999);
                $insurerReplay_object->repliedMethod = (string) "insurer";
                if ($request->input('quoteActive') == 'true') {
                    $updatedBy = new \stdClass();
                    $updatedBy->id = new ObjectId(Auth::id());
                    $updatedBy->name = Auth::user()->insurer['name'] . ' (' . Auth::user()->name . ')';
                    $updatedBy->date = date('d/m/Y');
                    $updatedBy->action = "E quote amended";
                    $updatedByarray[] = $updatedBy;
                    $pipeLineItems->push('updatedBy', $updatedByarray);
                } else {
                    $updatedBy = new \stdClass();
                    $updatedBy->id = new ObjectId(Auth::id());
                    $updatedBy->name = Auth::user()->insurer['name'] . ' (' . Auth::user()->name . ')';
                    $updatedBy->date = date('d/m/Y');
                    $updatedBy->action = "E quote gave";
                    $updatedByarray[] = $updatedBy;
                    $pipeLineItems->push('updatedBy', $updatedByarray);
                }

                $insurerData[] = $insurerReplay_object;

                if ($pipeLineItems->insurerReplay) {
                    $pipeLineItems->push('insurerReplay', $insurerData);
                    if ($request->input('quoteActive') == 'false') {
                        $array[] = new ObjectId(Auth::user()->insurer['id']);
                    }
                    $pipeLineItems->save();
                } else {
                    $pipeLineItems->insurerReplay = $insurerData;
                    if ($request->input('quoteActive') == 'false') {
                        $array[] = new ObjectId(Auth::user()->insurer['id']);
                    }
                    $pipeLineItems->save();
                }
                if ($request->input('quoteActive') == 'false') {
                    $count = 0;
                    $insurers_repeat = $pipeLineItems->insuraceCompanyList;
                    foreach ($insurers_repeat as $temp) {
                        if ($temp['id'] == $insurerId && $temp['status'] == 'active') {
                            PipelineItems::where('_id', $pipeLineId)->update(array('insuraceCompanyList.' . $count . '.status' => 'inactive'));
                            break;
                        }
                        $count++;
                    }
                }
                $this->mailSend($pipeLineId);
                if ($request->input('quoteActive') == 'false') {
                    Session::flash('quotation', 'E-Quote given successfully');
                    return "success";
                } else {
                    Session::flash('quotation', 'E-Quote amended successfully');
                    return "amended";
                }
            }
        } catch (\Exception $e) {
            if ($request->input('quoteActive') == 'false') {
                dd($e);
                Session::flash('error', 'Failed');
                return "failed";
            } elseif ($request->input('saveDraft') == 'true') {
                dd($e);
                Session::flash('error', 'Failed');
                return "failed";
            } else {
                Session::flash('error', 'Quote amendment failed');
                return "amended";
            }
        }
    }
    /**
     * save the reply provided by insurer
     */
    public function businessSave(Request $request)
    {
        try {
            $insurerId = new ObjectId(Auth::user()->insurer['id']);
            $pipeLineId = $request->input('id');
            $pipeLineItems = PipelineItems::where('_id', $pipeLineId)->first();
            if (!$pipeLineItems) {
                Session::flash('error', 'Pipeline not defined');
                return "failed";
            }
            if ($request->input('quoteActive') == 'true') {
                $replies = $pipeLineItems['insurerReplay'];
                foreach ($replies as $count => $reply) {
                    if ($reply['insurerDetails']['insurerId'] == $insurerId && $reply['quoteStatus'] == 'active' && $reply['uniqueToken'] == $request->input('hiddenToken')) {
                        PipelineItems::where('_id', $pipeLineId)->update(array('insurerReplay.' . $count . '.quoteStatus' => 'inactive'));
                    }
                }
            } else {
                PipelineItems::where('_id', $pipeLineId)->pull('insurerReplay', ['insurerDetails.insurerId' => $insurerId, 'quoteStatus' => 'saved']);
            }
            $insurerReplay_object = new \stdClass();
            $insurerDetails_object = new \stdClass();
            $insurerDetails_object->insurerId = new ObjectId(Auth::user()->insurer['id']);
            $insurerDetails_object->insurerName = Auth::user()->insurer['name'];
            $insurerDetails_object->givenById = new ObjectId(Auth::id());
            $insurerDetails_object->givenByName = Auth::user()->name;
            $insurerReplay_object->insurerDetails = $insurerDetails_object;

            if ($pipeLineItems->formData['costWork'] == true) {
                $insurerReplay_object->costWork = (string) $request->input('costWork');
            }
            if ($pipeLineItems->formData['claimClause'] == true) {
                $claimClause_object = new \stdClass();
                $claimClause_object->isAgree = (string) $request->input('claimClause');
                $claimClause_object->comment = (string) $request->input('claimClause_comment');
                $insurerReplay_object->claimClause = $claimClause_object;
            }
            if ($pipeLineItems->formData['custExtension'] == true) {
                $custExtension_object = new \stdClass();
                $custExtension_object->isAgree = (string) $request->input('custExtension');
                $custExtension_object->comment = (string) $request->input('custExtension_comment');
                $insurerReplay_object->custExtension = $custExtension_object;
            }
            if ($pipeLineItems->formData['accountants'] == true) {
                $accountants_object = new \stdClass();
                $accountants_object->isAgree = (string) $request->input('accountants');
                $accountants_object->comment = (string) $request->input('accountants_comment');
                $insurerReplay_object->accountants = $accountants_object;
            }
            if ($pipeLineItems->formData['payAccount'] == true) {
                $payAccount_object = new \stdClass();
                $payAccount_object->isAgree = (string) $request->input('payAccount');
                $payAccount_object->comment = (string) $request->input('payAccount_comment');
                $insurerReplay_object->payAccount = $payAccount_object;
            }

            if ($pipeLineItems->formData['denialAccess'] == true) {
                $denialAccess_object = new \stdClass();
                $denialAccess_object->isAgree = (string) $request->input('denialAccess');
                $denialAccess_object->comment = (string) $request->input('denialAccess_comment');
                $insurerReplay_object->denialAccess = $denialAccess_object;
            }

            if ($pipeLineItems->formData['premiumClause'] == true) {
                $premiumClause_object = new \stdClass();
                $premiumClause_object->isAgree = (string) $request->input('premiumClause');
                $premiumClause_object->comment = (string) $request->input('premiumClause_comment');
                $insurerReplay_object->premiumClause = $premiumClause_object;
            }

            if ($pipeLineItems->formData['utilityClause'] == true) {
                $utilityClause_object = new \stdClass();
                $utilityClause_object->isAgree = (string) $request->input('utilityClause');
                $utilityClause_object->comment = (string) $request->input('utilityClause_comment');
                $insurerReplay_object->utilityClause = $utilityClause_object;
            }
            if ($pipeLineItems->formData['brokerClaim'] == true) {
                $insurerReplay_object->brokerClaim = (string) $request->input('brokerClaim');
            }
            if ($pipeLineItems->formData['bookedDebts'] == true) {
                $bookedDebts_object = new \stdClass();
                $bookedDebts_object->isAgree = (string) $request->input('bookedDebts');
                $bookedDebts_object->comment = (string) $request->input('bookedDebts_comment');
                $insurerReplay_object->bookedDebts = $bookedDebts_object;
            }
            if ($pipeLineItems->formData['interdependanyClause'] == true) {
                $insurerReplay_object->interdependanyClause = (string) $request->input('interdependanyClause');
            }

            if ($pipeLineItems->formData['extraExpense'] == true) {
                $extraExpense_object = new \stdClass();
                $extraExpense_object->isAgree = (string) $request->input('extraExpense');
                $extraExpense_object->comment = (string) $request->input('extraExpense_comment');
                $insurerReplay_object->extraExpense = $extraExpense_object;
            }
            if ($pipeLineItems->formData['water'] == true) {
                $insurerReplay_object->water = (string) $request->input('water');
            }
            if ($pipeLineItems->formData['auditorFee'] == true) {
                $auditorFee_object = new \stdClass();
                $auditorFee_object->isAgree = (string) $request->input('auditorFee');
                $auditorFee_object->comment = (string) $request->input('auditorFee_comment');
                $insurerReplay_object->auditorFee = $auditorFee_object;
            }

            if ($pipeLineItems->formData['expenseLaws'] == true) {
                $expenseLaws_object = new \stdClass();
                $expenseLaws_object->isAgree = (string) $request->input('expenseLaws');
                $expenseLaws_object->comment = (string) $request->input('expenseLaws_comment');
                $insurerReplay_object->expenseLaws = $expenseLaws_object;
            }

            if ($pipeLineItems->formData['lossAdjuster'] == true) {
                $lossAdjuster_object = new \stdClass();
                $lossAdjuster_object->isAgree = (string) $request->input('lossAdjuster');
                $lossAdjuster_object->comment = (string) $request->input('lossAdjuster_comment');
                $insurerReplay_object->lossAdjuster = $lossAdjuster_object;
            }

            if ($pipeLineItems->formData['discease'] == true) {
                $discease_object = new \stdClass();
                $discease_object->isAgree = (string) $request->input('discease');
                $discease_object->comment = (string) $request->input('discease_comment');
                $insurerReplay_object->discease = $discease_object;
            }

            if ($pipeLineItems->formData['powerSupply'] == true) {
                $powerSupply_object = new \stdClass();
                $powerSupply_object->isAgree = (string) $request->input('powerSupply');
                $powerSupply_object->comment = (string) $request->input('powerSupply_comment');
                $insurerReplay_object->powerSupply = $powerSupply_object;
            }
            if ($pipeLineItems->formData['condition1'] == true) {
                $condition1_object = new \stdClass();
                $condition1_object->isAgree = (string) $request->input('condition1');
                $condition1_object->comment = (string) $request->input('condition1_comment');
                $insurerReplay_object->condition1 = $condition1_object;
            }
            if ($pipeLineItems->formData['condition2'] == true) {
                $condition2_object = new \stdClass();
                $condition2_object->isAgree = (string) $request->input('condition2');
                $condition2_object->comment = (string) $request->input('condition2_comment');
                $insurerReplay_object->condition2 = $condition2_object;
            }
            if ($pipeLineItems->formData['bookofDebts'] == true) {
                $bookofDebts_object = new \stdClass();
                $bookofDebts_object->isAgree = (string) $request->input('bookofDebts');
                $bookofDebts_object->comment = (string) $request->input('bookofDebts_comment');
                $insurerReplay_object->bookofDebts = $bookofDebts_object;
            }
            if ($pipeLineItems->formData['depclause'] == true) {
                $insurerReplay_object->depclause = (string) $request->input('depclause');
            }

            if ($pipeLineItems->formData['rent'] == true) {
                $rent_object = new \stdClass();
                $rent_object->isAgree = (string) $request->input('rent');
                $rent_object->comment = (string) $request->input('rent_comment');
                $insurerReplay_object->rent = $rent_object;
            }
            if ($pipeLineItems->formData['hasaccomodation'] == true) {
                $hasaccomodation_object = new \stdClass();
                $hasaccomodation_object->isAgree = (string) $request->input('hasaccomodation');
                $hasaccomodation_object->comment = (string) $request->input('hasaccomodation_comment');
                $insurerReplay_object->hasaccomodation = $hasaccomodation_object;
            }

            if ($pipeLineItems->formData['costofConstruction'] == true) {
                $costofConstruction_object = new \stdClass();
                $costofConstruction_object->isAgree = (string) $request->input('costofConstruction');
                $costofConstruction_object->comment = (string) $request->input('costofConstruction_comment');
                $insurerReplay_object->costofConstruction = $costofConstruction_object;
            }
            if ($pipeLineItems->formData['ContingentExpense'] == true) {
                $ContingentExpense_object = new \stdClass();
                $ContingentExpense_object->isAgree = (string) $request->input('ContingentExpense');
                $ContingentExpense_object->comment = (string) $request->input('ContingentExpense_comment');
                $insurerReplay_object->ContingentExpense = $ContingentExpense_object;
            }
            if ($pipeLineItems->formData['interuption'] == true) {
                $interuption_object = new \stdClass();
                $interuption_object->isAgree = (string) $request->input('interuption');
                $interuption_object->comment = (string) $request->input('interuption_comment');
                $insurerReplay_object->interuption = $interuption_object;
            }
            if ($pipeLineItems->formData['Royalties'] == true) {
                $insurerReplay_object->Royalties = (string) $request->input('Royalties');
            }

            if ($pipeLineItems->formData['deductible']) {
                $insurerReplay_object->deductible = str_replace(',', '', $request->input('deductible'));
            }
            if ($pipeLineItems->formData['ratep']) {
                $insurerReplay_object->ratep = str_replace(',', '', $request->input('ratep'));
            }
            if ($pipeLineItems->formData['brokerage']) {
                $insurerReplay_object->brokerage = str_replace(',', '', $request->input('brokerage'));
            }
            if ($pipeLineItems->formData['spec_condition']) {
                $insurerReplay_object->spec_condition = str_replace(',', '', $request->input('spec_condition'));
            }
            if ($pipeLineItems->formData['warranty']) {
                $insurerReplay_object->warranty = str_replace(',', '', $request->input('warranty'));
            }
            if ($pipeLineItems->formData['exclusion']) {
                $insurerReplay_object->exclusion = str_replace(',', '', $request->input('exclusion'));
            }
            if ($request->input('saveDraft') == 'true') {
                $insurerReplay_object->quoteStatus = (string) "saved";
                $updatedBy = new \stdClass();
                $updatedBy->id = new ObjectId(Auth::id());
                $updatedBy->name = Auth::user()->insurer['name'] . ' (' . Auth::user()->name . ')';
                $updatedBy->date = date('d/m/Y');
                $updatedBy->action = "Equotation saved and exit";
                $updatedByarray[] = $updatedBy;
                $pipeLineItems->push('updatedBy', $updatedByarray);
                $insurerData[] = $insurerReplay_object;
                $pipeLineItems->push('insurerReplay', $insurerData);
                $pipeLineItems->save();
                Session::flash('quotation', 'E-Quote saved successfully');
                return 'success';
            } else {
                $insurerReplay_object->quoteStatus = (string) "active";
                $insurerReplay_object->repliedDate = (string) date('d/m/Y');
                $insurerReplay_object->uniqueToken = (string) time() . rand(1000, 9999);
                $insurerReplay_object->repliedMethod = (string) "insurer";
                if ($request->input('quoteActive') == 'true') {
                    $updatedBy = new \stdClass();
                    $updatedBy->id = new ObjectId(Auth::id());
                    $updatedBy->name = Auth::user()->insurer['name'] . ' (' . Auth::user()->name . ')';
                    $updatedBy->date = date('d/m/Y');
                    $updatedBy->action = "E quote amended";
                    $updatedByarray[] = $updatedBy;
                    $pipeLineItems->push('updatedBy', $updatedByarray);
                } else {
                    $updatedBy = new \stdClass();
                    $updatedBy->id = new ObjectId(Auth::id());
                    $updatedBy->name = Auth::user()->insurer['name'] . ' (' . Auth::user()->name . ')';
                    $updatedBy->date = date('d/m/Y');
                    $updatedBy->action = "E quote gave";
                    $updatedByarray[] = $updatedBy;
                    $pipeLineItems->push('updatedBy', $updatedByarray);
                }

                $insurerData[] = $insurerReplay_object;

                if ($pipeLineItems->insurerReplay) {
                    $pipeLineItems->push('insurerReplay', $insurerData);
                    if ($request->input('quoteActive') == 'false') {
                        $array[] = new ObjectId(Auth::user()->insurer['id']);
                    }
                    $pipeLineItems->save();
                } else {
                    $pipeLineItems->insurerReplay = $insurerData;
                    if ($request->input('quoteActive') == 'false') {
                        $array[] = new ObjectId(Auth::user()->insurer['id']);
                    }
                    $pipeLineItems->save();
                }
                if ($request->input('quoteActive') == 'false') {
                    $count = 0;
                    $insurers_repeat = $pipeLineItems->insuraceCompanyList;
                    foreach ($insurers_repeat as $temp) {
                        if ($temp['id'] == $insurerId && $temp['status'] == 'active') {
                            PipelineItems::where('_id', $pipeLineId)->update(array('insuraceCompanyList.' . $count . '.status' => 'inactive'));
                            break;
                        }
                        $count++;
                    }
                }
                $this->mailSend($pipeLineId);
                if ($request->input('quoteActive') == 'false') {
                    Session::flash('quotation', 'E-Quote given successfully');
                    return "success";
                } else {
                    Session::flash('quotation', 'E-Quote amended successfully');
                    return "amended";
                }
            }
        } catch (\Exception $e) {
            if ($request->input('quoteActive') == 'false') {
                dd($e);
                Session::flash('error', 'Failed');
                return "failed";
            } else {
                Session::flash('error', 'Quote amendment failed');
                return "amended";
            }
        }
    }
    public function machinerySave(Request $request)
    {
        try {
            $insurerId = new ObjectId(Auth::user()->insurer['id']);
            $pipeLineId = $request->input('id');
            $pipeLineItems = PipelineItems::where('_id', $pipeLineId)->first();
            if (!$pipeLineItems) {
                Session::flash('error', 'Pipeline not defined');
                return "failed";
            }
            if ($request->input('quoteActive') == 'true') {
                $replies = $pipeLineItems['insurerReplay'];
                foreach ($replies as $count => $reply) {
                    if ($reply['insurerDetails']['insurerId'] == $insurerId && $reply['quoteStatus'] == 'active' && $reply['uniqueToken'] == $request->input('hiddenToken')) {
                        PipelineItems::where('_id', $pipeLineId)->update(array('insurerReplay.' . $count . '.quoteStatus' => 'inactive'));
                    }
                }
            } else {
                PipelineItems::where('_id', $pipeLineId)->pull('insurerReplay', ['insurerDetails.insurerId' => $insurerId, 'quoteStatus' => 'saved']);
            }
            $insurerReplay_object = new \stdClass();
            $insurerDetails_object = new \stdClass();
            $insurerDetails_object->insurerId = new ObjectId(Auth::user()->insurer['id']);
            $insurerDetails_object->insurerName = Auth::user()->insurer['name'];
            $insurerDetails_object->givenById = new ObjectId(Auth::id());
            $insurerDetails_object->givenByName = Auth::user()->name;
            $insurerReplay_object->insurerDetails = $insurerDetails_object;

            if ($pipeLineItems->formData['localclause'] == true) {
                $localclause_object = new \stdClass();
                $localclause_object->isAgree = (string) $request->input('localclause');
                $localclause_object->comment = (string) $request->input('localclause_comment');
                $insurerReplay_object->localclause = $localclause_object;
            }
            if ($pipeLineItems->formData['express'] == true) {
                $express_object = new \stdClass();
                $express_object->isAgree = (string) $request->input('express');
                $express_object->comment = (string) $request->input('express_comment');
                $insurerReplay_object->express = $express_object;
            }
            if ($pipeLineItems->formData['airfreight'] == true) {
                $airfreight_object = new \stdClass();
                $airfreight_object->isAgree = (string) $request->input('airfreight');
                $airfreight_object->comment = (string) $request->input('airfreight_comment');
                $insurerReplay_object->airfreight = $airfreight_object;
            }

            if ($pipeLineItems->formData['addpremium'] == true) {
                $addpremium_object = new \stdClass();
                $addpremium_object->isAgree = (string) $request->input('addpremium');
                $addpremium_object->comment = (string) $request->input('addpremium_comment');
                $insurerReplay_object->addpremium = $addpremium_object;
            }

            if ($pipeLineItems->formData['payAccount'] == true) {
                $payAccount_object = new \stdClass();
                $payAccount_object->isAgree = (string) $request->input('payAccount');
                $payAccount_object->comment = (string) $request->input('payAccount_comment');
                $insurerReplay_object->payAccount = $payAccount_object;
            }

            if ($pipeLineItems->formData['primaryclause'] == true) {
                $insurerReplay_object->primaryclause = (string) $request->input('primaryclause');
            }

            if ($pipeLineItems->formData['premiumClaim'] == true) {
                $insurerReplay_object->premiumClaim = (string) $request->input('premiumClaim');
            }

            if ($pipeLineItems->formData['lossnotification'] == true) {
                $lossnotification_object = new \stdClass();
                $lossnotification_object->isAgree = (string) $request->input('lossnotification');
                $lossnotification_object->comment = (string) $request->input('lossnotification_comment');
                $insurerReplay_object->lossnotification = $lossnotification_object;
            }

            if ($pipeLineItems->formData['adjustmentPremium'] == true) {
                $adjustmentPremium_object = new \stdClass();
                $adjustmentPremium_object->isAgree = (string) $request->input('adjustmentPremium');
                $adjustmentPremium_object->comment = (string) $request->input('adjustmentPremium_comment');
                $insurerReplay_object->adjustmentPremium = $adjustmentPremium_object;
            }
            if ($pipeLineItems->formData['brokerclaim'] == true) {
                $insurerReplay_object->brokerclaim = (string) $request->input('brokerclaim');
            }
            if ($pipeLineItems->formData['temporaryclause'] == true) {
                $temporaryclause_object = new \stdClass();
                $temporaryclause_object->isAgree = (string) $request->input('temporaryclause');
                $temporaryclause_object->comment = (string) $request->input('temporaryclause_comment');
                $insurerReplay_object->temporaryclause = $temporaryclause_object;
            }

            if ($pipeLineItems->formData['automaticClause'] == true) {
                $automaticClause_object = new \stdClass();
                $automaticClause_object->isAgree = (string) $request->input('automaticClause');
                $automaticClause_object->comment = (string) $request->input('automaticClause_comment');
                $insurerReplay_object->automaticClause = $automaticClause_object;
            }

            if ($pipeLineItems->formData['capitalclause'] == true) {
                $capitalclause_object = new \stdClass();
                $capitalclause_object->isAgree = (string) $request->input('capitalclause');
                $capitalclause_object->comment = (string) $request->input('capitalclause_comment');
                $insurerReplay_object->capitalclause = $capitalclause_object;
            }

            if ($pipeLineItems->formData['debris'] == true) {
                $debris_object = new \stdClass();
                $debris_object->isAgree = (string) $request->input('debris');
                $debris_object->comment = (string) $request->input('debris_comment');
                $insurerReplay_object->debris = $debris_object;
            }

            if ($pipeLineItems->formData['property'] == true) {
                $property_object = new \stdClass();
                $property_object->isAgree = (string) $request->input('property');
                $property_object->comment = (string) $request->input('property_comment');
                $insurerReplay_object->property = $property_object;
            }
            if ($pipeLineItems->formData['errorclause'] == true) {
                $insurerReplay_object->errorclause = (string) $request->input('errorclause');
            }

            if ($pipeLineItems->formData['waiver'] == true) {
                $waiver_object = new \stdClass();
                $waiver_object->isAgree = (string) $request->input('waiver');
                $waiver_object->comment = (string) $request->input('waiver_comment');
                $insurerReplay_object->waiver = $waiver_object;
            }

            if ($pipeLineItems->formData['claimclause'] == true) {
                $claimclause_object = new \stdClass();
                $claimclause_object->isAgree = (string) $request->input('claimclause');
                $claimclause_object->comment = (string) $request->input('claimclause_comment');
                $insurerReplay_object->claimclause = $claimclause_object;
            }
            if ($pipeLineItems->formData['Innocent'] == true) {
                $insurerReplay_object->Innocent = (string) $request->input('Innocent');
            }
            if ($pipeLineItems->formData['Noninvalidation'] == true) {
                $insurerReplay_object->Noninvalidation = (string) $request->input('Noninvalidation');
            }

            if ($pipeLineItems->formData['brokerclaim'] == true) {
                $insurerReplay_object->brokerclaim = (string) $request->input('brokerclaim');
            }

            // if ($pipeLineItems->formData['deductm']) {
            $insurerReplay_object->deductm = str_replace(',', '', $request->input('deductm'));
            // }
            // if ($pipeLineItems->formData['ratem']) {
            $insurerReplay_object->ratem = str_replace(',', '', $request->input('ratem'));
            // }
            // if ($pipeLineItems->formData['brokeragem']) {
            $insurerReplay_object->brokeragem = str_replace(',', '', $request->input('brokeragem'));
            // }
            // if ($pipeLineItems->formData['premiumm']) {
            $insurerReplay_object->premiumm = str_replace(',', '', $request->input('premiumm'));
            // }
            // if ($pipeLineItems->formData['specialm']) {
            $insurerReplay_object->specialm = $request->input('specialm');
            // }
            // if ($pipeLineItems->formData['warrantym']) {
            $insurerReplay_object->warrantym = $request->input('warrantym');
            // }
            // if ($pipeLineItems->formData['exclusionm']) {
            $insurerReplay_object->exclusionm = $request->input('exclusionm');
            // }

            // if ($pipeLineItems->formData['deductb']) {
            $insurerReplay_object->deductb = str_replace(',', '', $request->input('deductb'));
            // }
            // if ($pipeLineItems->formData['rateb']) {
            $insurerReplay_object->rateb = str_replace(',', '', $request->input('rateb'));
            // }
            // if ($pipeLineItems->formData['brokerageb']) {
            $insurerReplay_object->brokerageb = str_replace(',', '', $request->input('brokerageb'));
            // }
            // if ($pipeLineItems->formData['premiumb']) {
            $insurerReplay_object->premiumb = str_replace(',', '', $request->input('premiumb'));
            // }
            // if ($pipeLineItems->formData['specialb']) {
            $insurerReplay_object->specialb = $request->input('specialb');
            // }
            // if ($pipeLineItems->formData['warrantyb']) {
            $insurerReplay_object->warrantyb = $request->input('warrantyb');
            // }
            // if ($pipeLineItems->formData['exclusionb']) {
            $insurerReplay_object->exclusionb = $request->input('exclusionb');
            // }
            if ($request->input('saveDraft') == 'true') {
                $insurerReplay_object->quoteStatus = (string) "saved";
                $updatedBy = new \stdClass();
                $updatedBy->id = new ObjectId(Auth::id());
                $updatedBy->name = Auth::user()->insurer['name'] . ' (' . Auth::user()->name . ')';
                $updatedBy->date = date('d/m/Y');
                $updatedBy->action = "Equotation saved and exit";
                $updatedByarray[] = $updatedBy;
                $pipeLineItems->push('updatedBy', $updatedByarray);
                $insurerData[] = $insurerReplay_object;
                $pipeLineItems->push('insurerReplay', $insurerData);
                $pipeLineItems->save();
                Session::flash('quotation', 'E-Quote saved successfully');
                return 'success';
            } else {
                $insurerReplay_object->quoteStatus = (string) "active";
                $insurerReplay_object->repliedDate = (string) date('d/m/Y');
                $insurerReplay_object->uniqueToken = (string) time() . rand(1000, 9999);
                $insurerReplay_object->repliedMethod = (string) "insurer";
                if ($request->input('quoteActive') == 'true') {
                    $updatedBy = new \stdClass();
                    $updatedBy->id = new ObjectId(Auth::id());
                    $updatedBy->name = Auth::user()->insurer['name'] . ' (' . Auth::user()->name . ')';
                    $updatedBy->date = date('d/m/Y');
                    $updatedBy->action = "E quote amended";
                    $updatedByarray[] = $updatedBy;
                    $pipeLineItems->push('updatedBy', $updatedByarray);
                } else {
                    $updatedBy = new \stdClass();
                    $updatedBy->id = new ObjectId(Auth::id());
                    $updatedBy->name = Auth::user()->insurer['name'] . ' (' . Auth::user()->name . ')';
                    $updatedBy->date = date('d/m/Y');
                    $updatedBy->action = "E quote gave";
                    $updatedByarray[] = $updatedBy;
                    $pipeLineItems->push('updatedBy', $updatedByarray);
                }

                $insurerData[] = $insurerReplay_object;

                if ($pipeLineItems->insurerReplay) {
                    $pipeLineItems->push('insurerReplay', $insurerData);
                    if ($request->input('quoteActive') == 'false') {
                        $array[] = new ObjectId(Auth::user()->insurer['id']);
                    }
                    $pipeLineItems->save();
                } else {
                    $pipeLineItems->insurerReplay = $insurerData;
                    if ($request->input('quoteActive') == 'false') {
                        $array[] = new ObjectId(Auth::user()->insurer['id']);
                    }
                    $pipeLineItems->save();
                }
                if ($request->input('quoteActive') == 'false') {
                    $count = 0;
                    $insurers_repeat = $pipeLineItems->insuraceCompanyList;
                    foreach ($insurers_repeat as $temp) {
                        if ($temp['id'] == $insurerId && $temp['status'] == 'active') {
                            PipelineItems::where('_id', $pipeLineId)->update(array('insuraceCompanyList.' . $count . '.status' => 'inactive'));
                            break;
                        }
                        $count++;
                    }
                }
                $this->mailSend($pipeLineId);
                if ($request->input('quoteActive') == 'false') {
                    Session::flash('quotation', 'E-Quote given successfully');
                    return "success";
                } else {
                    Session::flash('quotation', 'E-Quote amended successfully');
                    return "amended";
                }
            }
        } catch (\Exception $e) {
            if ($request->input('quoteActive') == 'false') {
                dd($e);
                Session::flash('error', 'Failed');
                return "failed";
            } else {
                Session::flash('error', 'Quote amendment failed');
                return "amended";
            }
        }
    }

    /**
     * save machinary plant
     */
    public function plantSave(Request $request)
    {
        try {
            $insurerId = new ObjectId(Auth::user()->insurer['id']);
            $pipeLineId = $request->input('id');
            $pipeLineItems = PipelineItems::where('_id', $pipeLineId)->first();
            $pipeline_details = $pipeLineItems;
            // $tokenAmend=[];
            if (!$pipeLineItems) {
                Session::flash('error', 'Pipeline not defined');
                return "failed";
            }
            if ($request->input('quoteActive') == 'true') {
                $replies = $pipeLineItems['insurerReplay'];
                foreach ($replies as $count => $reply) {
                    if ($reply['insurerDetails']['insurerId'] == $insurerId && $reply['quoteStatus'] == 'active' && $reply['uniqueToken'] == $request->input('hiddenToken')) {
                        // $tokenAmend[]=$reply['uniqueToken'];
                        PipelineItems::where('_id', $pipeLineId)->update(array('insurerReplay.' . $count . '.quoteStatus' => 'inactive'));
                    }
                }
            } else {
                PipelineItems::where('_id', $pipeLineId)->pull('insurerReplay', ['insurerDetails.insurerId' => $insurerId, 'quoteStatus' => 'saved']);
            }
            $insurerReplay_object = new \stdClass();
            $insurerDetails_object = new \stdClass();
            $insurerDetails_object->insurerId = new ObjectId(Auth::user()->insurer['id']);
            $insurerDetails_object->insurerName = Auth::user()->insurer['name'];
            $insurerDetails_object->givenById = new ObjectId(Auth::id());
            $insurerDetails_object->givenByName = Auth::user()->name;
            $insurerReplay_object->insurerDetails = $insurerDetails_object;
            if ($request->input('authRepair') !='') {
                 $authRepair_object = new \stdClass();
                $authRepair_object->isAgree = (string) $request->input('authRepair');
                $authRepair_object->comment = (string) $request->input('authRepair_comment');
                $insurerReplay_object->authRepair = $authRepair_object;
            } else {
                $insurerReplay_object->authRepair = [];
            }


            $strikeRiot_object = new \stdClass();
            $strikeRiot_object->isAgree = (string) $request->input('strikeRiot');
            $strikeRiot_object->comment = (string) $request->input('strikeRiot_comment');
            $insurerReplay_object->strikeRiot = $strikeRiot_object;

            $overtime_object = new \stdClass();
            $overtime_object->isAgree = (string) $request->input('overtime');
            $overtime_object->comment = (string) $request->input('overtime_comment');
            $insurerReplay_object->overtime = $overtime_object;

            $coverExtra_object = new \stdClass();
            $coverExtra_object->isAgree = (string) $request->input('coverExtra');
            $coverExtra_object->comment = (string) $request->input('coverExtra_comment');
            $insurerReplay_object->coverExtra = $coverExtra_object;

            $insurerReplay_object->coverUnder = (string) $request->input('coverUnder');
            if (isset($pipeline_details['formData']['drillRigs'])&& $pipeline_details['formData']['drillRigs']==true) {
                $drill=(string) $request->input('drillRigs');
            } else {
                $drill='';
            }
            $insurerReplay_object->drillRigs = $drill;

            $inlandTransit_object = new \stdClass();
            $inlandTransit_object->isAgree = (string) $request->input('inlandTransit');
            $inlandTransit_object->comment = (string) $request->input('inlandTransit_comment');
            $insurerReplay_object->inlandTransit = $inlandTransit_object;

            $transitRoad_object = new \stdClass();
            $transitRoad_object->isAgree = (string) $request->input('transitRoad');
            $transitRoad_object->comment = (string) $request->input('transitRoad_comment');
            $insurerReplay_object->transitRoad = $transitRoad_object;

            $thirdParty_object = new \stdClass();
            $thirdParty_object->isAgree = (string) $request->input('thirdParty');
            $thirdParty_object->comment = (string) $request->input('thirdParty_comment');
            $insurerReplay_object->thirdParty = $thirdParty_object;
            if (isset($pipeline_details['formData']['machEquip']['machEquip']) && ($pipeline_details['formData']['machEquip']['machEquip'] == true)
                && isset($pipeline_details['formData']['coverHired'])
            ) {
                $insurerReplay_object->coverHired = (string) $request->input('coverHired');
            }
            $autoSum_object = new \stdClass();
            $autoSum_object->isAgree = (string) $request->input('autoSum');
            $autoSum_object->comment = (string) $request->input('autoSum_comment');
            $insurerReplay_object->autoSum = $autoSum_object;
            $insurerReplay_object->includRisk = (string) $request->input('includRisk');

            $tool_object = new \stdClass();
            $tool_object->isAgree = (string) $request->input('tool');
            $tool_object->comment = (string) $request->input('tool_comment');
            $insurerReplay_object->tool = $tool_object;
            $insurerReplay_object->hoursClause = (string) $request->input('hoursClause');

            $lossAdj_object = new \stdClass();
            $lossAdj_object->isAgree = (string) $request->input('lossAdj');
            $lossAdj_object->comment = (string) $request->input('lossAdj_comment');
            $insurerReplay_object->lossAdj = $lossAdj_object;
            $insurerReplay_object->primaryClause = (string) $request->input('primaryClause');

            $paymentAccount_object = new \stdClass();
            $paymentAccount_object->isAgree = (string) $request->input('paymentAccount');
            $paymentAccount_object->comment = (string) $request->input('paymentAccount_comment');
            $insurerReplay_object->paymentAccount = $paymentAccount_object;
            $insurerReplay_object->avgCondition = (string) $request->input('avgCondition');

            $autoAddition_object = new \stdClass();
            $autoAddition_object->isAgree = (string) $request->input('autoAddition');
            $autoAddition_object->comment = (string) $request->input('autoAddition_comment');
            $insurerReplay_object->autoAddition = $autoAddition_object;

            $cancelClause_object = new \stdClass();
            $cancelClause_object->isAgree = (string) $request->input('cancelClause');
            $cancelClause_object->comment = (string) $request->input('cancelClause_comment');
            $insurerReplay_object->cancelClause = $cancelClause_object;

            $derbis_object = new \stdClass();
            $derbis_object->isAgree = (string) $request->input('derbis');
            $derbis_object->comment = (string) $request->input('derbis_comment');
            $insurerReplay_object->derbis = $derbis_object;

            $repairClause_object = new \stdClass();
            $repairClause_object->isAgree = (string) $request->input('repairClause');
            $repairClause_object->comment = (string) $request->input('repairClause_comment');
            $insurerReplay_object->repairClause = $repairClause_object;

            $tempRepair_object = new \stdClass();
            $tempRepair_object->isAgree = (string) $request->input('tempRepair');
            $tempRepair_object->comment = (string) $request->input('tempRepair_comment');
            $insurerReplay_object->tempRepair = $tempRepair_object;

            $insurerReplay_object->errorOmission = (string) $request->input('errorOmission');
            $minLoss_object = new \stdClass();
            $minLoss_object->isAgree = (string) $request->input('minLoss');
            $minLoss_object->comment = (string) $request->input('minLoss_comment');
            $insurerReplay_object->minLoss = $minLoss_object;
            if (isset($pipeline_details['formData']['affCompany']) && $pipeline_details['formData']['affCompany'] !='' && isset($pipeline_details['formData']['crossLiability'])) {
                $crossLiability_object = new \stdClass();
                $crossLiability_object->isAgree = (string) $request->input('crossLiability');
                $crossLiability_object->comment = (string) $request->input('crossLiability_comment');
                $insurerReplay_object->crossLiability = $crossLiability_object;
            }

            $insurerReplay_object->coverInclude = (string) $request->input('coverInclude');
            $towCharge_object = new \stdClass();
            $towCharge_object->isAgree = (string) $request->input('towCharge');
            $towCharge_object->comment = (string) $request->input('towCharge_comment');
            $insurerReplay_object->towCharge = $towCharge_object;
            if (isset($pipeline_details['formData']['policyBank']['policyBank']) && $pipeline_details['formData']['policyBank']['policyBank'] ==true && isset($pipeline_details['formData']['lossPayee'])) {
                $insurerReplay_object->lossPayee = (string) $request->input('lossPayee');
            }
            $agencyRepair_object = new \stdClass();
            $agencyRepair_object->isAgree = (string) $request->input('agencyRepair');
            $agencyRepair_object->comment = (string) $request->input('agencyRepair_comment');
            $insurerReplay_object->agencyRepair = $agencyRepair_object;
            $insurerReplay_object->indemnityPrincipal = (string) $request->input('indemnityPrincipal');
            $insurerReplay_object->propDesign = (string) $request->input('propDesign');
            $insurerReplay_object->specialAgree = (string) $request->input('specialAgree');
            $declarationSum_object = new \stdClass();
            $declarationSum_object->isAgree = (string) $request->input('declarationSum');
            $declarationSum_object->comment = (string) $request->input('declarationSum_comment');
            $insurerReplay_object->declarationSum = $declarationSum_object;
            $salvage_object = new \stdClass();
            $salvage_object->isAgree = (string) $request->input('salvage');
            $salvage_object->comment = (string) $request->input('salvage_comment');
            $insurerReplay_object->salvage = $salvage_object;
            $totalLoss_object = new \stdClass();
            $totalLoss_object->isAgree = (string) $request->input('totalLoss');
            $totalLoss_object->comment = (string) $request->input('totalLoss_comment');
            $insurerReplay_object->totalLoss = $totalLoss_object;
            $profitShare_object = new \stdClass();
            $profitShare_object->isAgree = (string) $request->input('profitShare');
            $profitShare_object->comment = (string) $request->input('profitShare_comment');
            $insurerReplay_object->profitShare = $profitShare_object;
            $claimPro_object = new \stdClass();
            $claimPro_object->isAgree = (string) $request->input('claimPro');
            $claimPro_object->comment = (string) $request->input('claimPro_comment');
            $insurerReplay_object->claimPro = $claimPro_object;
            $insurerReplay_object->waiver = (string) $request->input('waiver');
            $insurerReplay_object->rate = (string) $request->input('rate');
            $insurerReplay_object->premium = (string) $request->input('premium');
            $insurerReplay_object->payTerm = (string) $request->input('payTerm');
            if ($request->input('saveDraft') == 'true') {
                $insurerReplay_object->quoteStatus = (string) "saved";
                $updatedBy = new \stdClass();
                $updatedBy->id = new ObjectId(Auth::id());
                $updatedBy->name = Auth::user()->insurer['name'] . ' (' . Auth::user()->name . ')';
                $updatedBy->date = date('d/m/Y');
                $updatedBy->action = "Equotation saved and exit";
                $updatedByarray[] = $updatedBy;
                $pipeLineItems->push('updatedBy', $updatedByarray);
                $insurerData[] = $insurerReplay_object;
                $pipeLineItems->push('insurerReplay', $insurerData);
                $pipeLineItems->save();
                Session::flash('quotation', 'E-Quote saved successfully');
                return 'success';
            } else {
                $insurerReplay_object->quoteStatus = (string) "active";
                $insurerReplay_object->repliedDate = (string) date('d/m/Y');
                $uniqueToken = (string) time() . rand(1000, 9999);
                $insurerReplay_object->uniqueToken =$uniqueToken;
                // if ($request->input('quoteActive') == 'true') {
                //     $insurers_selected = $pipeLineItems->selected_insurers;
                //     foreach ($insurers_selected as $temp) {
                //         if (in_array($temp['insurer'], $tokenAmend)) {
                //             PipelineItems::where('_id', $pipeLineId)->update(array('selected_insurers.' . $count . '.status' => 'inactive'));
                //             // PipelineItems::where('_id', $pipeLineId)->update(array('selected_insurers.' . $count . '.insurer' => $uniqueToken));
                //             PipelineItems::where('_id', $pipeLineId)->push(array('selected_insurers.' . $count . '.insurer' =>$uniqueToken));

                //             break;
                //         }
                //         $count++;
                //     }
                // }

                $insurerReplay_object->repliedMethod = (string) "insurer";
                if ($request->input('quoteActive') == 'true') {
                    $updatedBy = new \stdClass();
                    $updatedBy->id = new ObjectId(Auth::id());
                    $updatedBy->name = Auth::user()->insurer['name'] . ' (' . Auth::user()->name . ')';
                    $updatedBy->date = date('d/m/Y');
                    $updatedBy->action = "E quote amended";
                    $updatedByarray[] = $updatedBy;
                    $pipeLineItems->push('updatedBy', $updatedByarray);
                } else {
                    $updatedBy = new \stdClass();
                    $updatedBy->id = new ObjectId(Auth::id());
                    $updatedBy->name = Auth::user()->insurer['name'] . ' (' . Auth::user()->name . ')';
                    $updatedBy->date = date('d/m/Y');
                    $updatedBy->action = "E quote gave";
                    $updatedByarray[] = $updatedBy;
                    $pipeLineItems->push('updatedBy', $updatedByarray);
                }

                $insurerData[] = $insurerReplay_object;

                if ($pipeLineItems->insurerReplay) {
                    $pipeLineItems->push('insurerReplay', $insurerData);
                    if ($request->input('quoteActive') == 'false') {
                        $array[] = new ObjectId(Auth::user()->insurer['id']);
                    }
                    $pipeLineItems->save();
                } else {
                    $pipeLineItems->insurerReplay = $insurerData;
                    if ($request->input('quoteActive') == 'false') {
                        $array[] = new ObjectId(Auth::user()->insurer['id']);
                    }
                    $pipeLineItems->save();
                }
                if ($request->input('quoteActive') == 'false') {
                    $count = 0;
                    $insurers_repeat = $pipeLineItems->insuraceCompanyList;
                    foreach ($insurers_repeat as $temp) {
                        if ($temp['id'] == $insurerId && $temp['status'] == 'active') {
                            PipelineItems::where('_id', $pipeLineId)->update(array('insuraceCompanyList.' . $count . '.status' => 'inactive'));
                            break;
                        }
                        $count++;
                    }
                }
                $this->mailSend($pipeLineId);
                if ($request->input('quoteActive') == 'false') {
                    Session::flash('quotation', 'E-Quote given successfully');
                    return "success";
                } else {
                    Session::flash('quotation', 'E-Quote amended successfully');
                    return "amended";
                }
            }
        } catch (\Exception $e) {
            if ($request->input('quoteActive') == 'false') {
                dd($e);
                Session::flash('error', 'Failed');
                return "failed";
            } elseif ($request->input('saveDraft') == 'true') {
                dd($e);
                Session::flash('error', 'Failed');
                return "failed";
            } else {
                Session::flash('error', 'Quote amendment failed');
                return "amended";
            }
        }
    }

    public function insurerView($id)
    {
        $workTypeDataId = new ObjectId($id);
        $formValues= WorkTypeData::find($workTypeDataId);
        $data = ESlipFormData::where('workTypeDataId', $workTypeDataId)->first();
        $equestionnaire = $formValues['eQuestionnaire'];
        $formData = [];
        if (!empty($equestionnaire)) {
            foreach ($equestionnaire as $step => $value) {
                foreach ($value as $key => $val) {
                    $formData[$key] = $val;
                }
            }
        }
        return view('pages.insurer_view')->with(compact('data', 'workTypeId', 'stage', 'values', 'workTypeDataId', 'formValues', 'formData'));
    }

    // public function saveInsurerResponse(Request $request)
    // {
    //     $eslip = ESlipFormData::find(new ObjectId('5dd3be5ce9792f102704e993'));
    //     $data = $request->post();
    //     $insurer_id = $data['insurer_id'];
    //     $insurer = Insurer::find('5b505b97a01c4e1d723df148');
    //     $insurer_name = $insurer->name;
    //     $insurerDetails_object = new \stdClass();
    //     $insurerDetails_object->insurerId = new ObjectId($insurer_id);
    //     $insurerDetails_object->insurerName = $insurer_name;
    //     $insurerDetails_object->givenById = new ObjectId(Auth::id());
    //     $insurerDetails_object->givenByName = 'Under Writer (' . Auth::user()->name . ')';
    //     $data['insurerDetails'] = $insurerDetails_object;
    //     unset($data['_token']);
    //     unset($data['insurer_id']);
    //     $InsReply = $eslip->insurerReply?:[];
    //     $InsReply[] = $data;
    //     $eslip->insurerReply = $InsReply;
    //     $eslip->save();


    //     echo '<pre>';
    //     print_r($data);
    //     echo '</pre>';


    // }
}
