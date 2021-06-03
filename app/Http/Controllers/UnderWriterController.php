<?php

namespace App\Http\Controllers;

use App\AllCountries;
use App\Customer;
use App\CustomerMode;
use App\Insurer;
use App\Jobs\SendComparison;
use App\Jobs\SendQuestionnaire;
use App\PipelineItems;
use App\PipelineStatus;
use App\Role;
use App\State;
use App\User;
use App\WorkTypeData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use MongoDB\BSON\ObjectId;
use Barryvdh\Snappy\Facades\SnappyPdf;
use PDF;

class UnderWriterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.underwriter');
    }

    /**
     * view dashboard
     */
    public function index(Request $request)
    {

        $request->session()->forget('dispatch');
        $totalPipeline = WorkTypeData::where('pipelineStatus', "true")->count();
        $totalPending = WorkTypeData::where('pipelineStatus', "pending")->count();
        $totalIssuance = WorkTypeData::where('pipelineStatus', "issuance")->count();
        $totalClosed = WorkTypeData::where('pipelineStatus', "Closed")->count();
        return view('dashboard')->with(compact('totalPipeline','totalCustomer','totalPending', 'totalIssuance', 'totalClosed'));
    }
    /**
     * view dashboard
     */
    public function crmDashbord(Request $request)
    {
        $request->session()->forget('dispatch');
        session(['dispatch' => 'Underwriter']);
        $totalPipeline = WorkTypeData::where('pipelineStatus', "true")->count();
        $totalPending = WorkTypeData::where('pipelineStatus', "pending")->count();
        $totalIssuance = WorkTypeData::where('pipelineStatus', "issuance")->count();
        $totalClosed = WorkTypeData::where('pipelineStatus', "Closed")->count();
        $totalpolicies = WorkTypeData::where('pipelineStatus', "approved")->count();
        $customerMode =    CustomerMode::pluck('_id');
        $customers = Customer::where('status', 1);        
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
        // $temporaryCustomer= $customers->where('customerMode', new ObjectID($customerMode[1]));
        // $permanantCustomer= $customers->where('customerMode', new ObjectID($customerMode[0]));
        // $totalTemporaryCustomer = $temporaryCustomer->count();
        // $totalPermanantCustomer = $permanantCustomer->count();
        return view('crmDashboard')->with(compact('totalPipeline', 'totalPending', 'totalIssuance', 'totalClosed', 'totalpolicies'));
    }

    /**
     * Function for send to customers
     */
    public function sendQuestionnaire(Request $request)
    {
        $pipelineId = $request->input('id');
        $files = $request->input('files');
        $comment = $request->input('txt_comment');
        $status = 0;
        $token = str_random(3) . time() . str_random(3);
        $pipeLine = WorkTypeData::findOrFail($pipelineId);
        $departments = $pipeLine->getCustomer['departmentDetails'];
        if ($departments != '') {
            foreach ($departments as $department) {
                if ($department['departmentName'] == 'Genaral & Marine') {
                    $name = $department['depContactPerson'];
                    $email = $department['depContactEmail'];
                    $status = 1;
                    break;
                }
            }
        }
        if ($status == 0) {
            $name = $pipeLine->customer['name'];
            $email = $pipeLine->getCustomer->email[0];
        }
        $pipeLine->token = $token;
        $pipeLine->tokenStatus = 'active';
        $pipeLine->save();
        $link = url('/customer-questionnaire/' . $token);
        $workType = $pipeLine->workTypeId['name'];
        if(isset($email)&& !empty($email)) {
            SendQuestionnaire::dispatch($email, $name, $link, $workType, $files, $comment);
        }
        else{
            return 'Failed! Email ID not provided for this customer';
        }
        $updatedBy_obj = new \stdClass();
        $updatedBy_obj->id = new ObjectID(Auth::id());
        $updatedBy_obj->name = Auth::user()->name;
        $updatedBy_obj->date = date('d/m/Y');
        $updatedBy_obj->action = "E questionnaire send";
        $updatedBy[] = $updatedBy_obj;
        if ($pipeLine['status']['status'] == 'Worktype Created') {
            $pipline_status = PipelineStatus::where('status', 'E-questionnaire')->first();
            $pipeline_status_object = new \stdClass();
            $pipeline_status_object->id = new ObjectID($pipline_status->_id);
            $pipeline_status_object->status = (string)$pipline_status->status;
            $pipeline_status_object->UpdatedById = new ObjectId(Auth::id());
            $pipeline_status_object->UpdatedByName = Auth::user()->name;
            $pipeline_status_object->date = date('d/m/Y');
            $pipeLine->status = $pipeline_status_object;
        }
        $pipeLine->save();
        WorkTypeData::where('_id', new ObjectId($pipelineId))->push('updatedBy', $updatedBy);
        return 'E-questionnaire has been sent to ' . $email;
    }



    /**
     * Function for add new comments in E questionnaire
     */
    public function addComment(Request $request)
    {
        try {
            $id = $request->get('id');
            $pipeData = WorkTypeData::where('_id', $id)->get()->first();
            $seen = [];
            $seen[] = new ObjectId(Auth::id());
            if ($pipeData->comments) {
                $comment_object = new \stdClass();
                $comment_object->comment = $request->get('comment');
                $comment_object->commentBy = Auth::user()->name;
                $role= Auth::user()->roleDetail('name');
                $comment_object->userType =  $role['name'];
                $comment_object->id = new ObjectId(Auth::id());
                $comment_object->date = $request->get('date');
                $comment_array[] = $comment_object;
                $pipeData->push('comments', $comment_array);
                $updatedBy_obj = new \stdClass();
                $updatedBy_obj->id = new ObjectID(Auth::id());
                $updatedBy_obj->name = Auth::user()->name;
                $updatedBy_obj->date = date('d/m/Y');
                $updatedBy_obj->action = "Commented";
                $updatedBy[] = $updatedBy_obj;
                $pipeData->push('updatedBy', $updatedBy);
                $pipeData->save();
                WorkTypeData::where('_id', $id)->update(['commentSeen'=>$seen]);
            } else {
                $comment_object = new \stdClass();
                $comment_object->comment = $request->get('comment');
                $comment_object->commentBy = Auth::user()->name;
                $role= Auth::user()->roleDetail('name');
                $comment_object->userType =  $role['name'];
                $comment_object->id = new ObjectID(Auth::id());
                $comment_object->date = $request->get('date');
                $comment_array[] = $comment_object;
                $pipeData->comments = $comment_array;
                $pipeData->commentSeen = $seen;
                $updatedBy_obj = new \stdClass();
                $updatedBy_obj->id = new ObjectID(Auth::id());
                $updatedBy_obj->name = Auth::user()->name;
                $updatedBy_obj->date = date('d/m/Y');
                $updatedBy_obj->action = "Commented";
                $updatedBy[] = $updatedBy_obj;
                $pipeData->push('updatedBy', $updatedBy);
                $pipeData->save();
            }
            return "success";
        }catch (\Exception $exception){
            return "failure";
        }
    }

    /**
     * Function for get comments using AJAX
     */
    public function getComment(Request $request)
    {
        $seen = new ObjectId(Auth::id());
        $id = $request->get('id');
        $pipeData = WorkTypeData::where('_id', $id)->first();
        $comment_seen = WorkTypeData::where('_id', $id)->where('commentSeen', '=', new ObjectId(Auth::id()))->first();
        if(!$comment_seen) {
            WorkTypeData::where('_id', $id)->push(['commentSeen'=>$seen]);
        }
        $comments = $pipeData->comments;
        return json_encode($comments);
    }

    /**
     * Function for ger insurer list in e-slip form
     */
    public function getInsurer(Request $request)
    {
        $company_id=[];
        $eslip_id=$request->get('eslip_id');
        $insurer_list = Insurer::where('isActive', 1)->orderBy('name')->get();
        if($request->get('eslip_id')) {
            $pipeline_details = WorkTypeData::find($eslip_id);
            $insurence_company=$pipeline_details->insuraceCompanyList;
            if($insurence_company) {
                foreach ($insurence_company as $company)
                {
                    $company_id[]=$company['id'];
                }
            }
            else
            {
                $company_id="";
            }
        }
        else
        {
            $company_id="";
        }
        return view('forms.insurer_list')->with(compact('insurer_list', 'company_id'));
    }

    /**
     * Function for send comparison to the customer
     */
    public function sendComparison(Request $request)
    {
        $pipelineId = $request->input('id');
        $files = $request->input('files');
        $comment = $request->input('txt_comment');
        $status = 0;
         $pipeLine = WorkTypeData::findOrFail($pipelineId);
        $departments = $pipeLine->getCustomer['departmentDetails'];
        if(isset($department)) {
            foreach($departments as $department )
            {
                if($department['departmentName'] == 'Genaral & Marine') {
                    $name = $department['depContactPerson'];
                    $email = $department['depContactEmail'];
                    $status = 1;
                    break;
                }
            }
        }
        $token = str_random(3).time().str_random(3);
        if(isset($pipeLine['documentNo'])) {
            $number = $pipeLine['documentNo'] + 1;
        }
        else
        {
            $number = 0;
        }


        if($status == 0) {
            $name = $pipeLine->customer['name'];
            $email = $pipeLine->getCustomer->email[0];
        }
        $refNo = $pipeLine->refereneceNumber;
        $token_object = new \stdClass();
        $token_object->token = (string)$token;
        $token_object->status = (string)'active';
        $token_object->date = date('d/m/Y');
        $token_object->viewStatus = (string)'Sent to customer';
        $pipeLine->comparisonToken = $token_object;
        $workType = $pipeLine->workTypeId['name'];
        if ($workType=="Workman's Compensation") {
            $link = url('/view-comparison/' . $token);
        } elseif($workType=="Employers Liability") {
            $link = url('employer/view-comparison/' . $token);
        } elseif($workType=="Property") {
            $link = url('property/view-comparison/' . $token);
        } elseif($workType=="Fire and Perils") {
            $link = url('fireperils/view-comparison/' . $token);
        } elseif ($workType=="Contractor`s Plant and Machinery") {
            $link = url('contractor-plant/view-comparison/' . $token);
        }
        if (isset($email)&& !empty($email)) {
            SendComparison::dispatch($email, $name, $link, $workType, $refNo, $files, $comment);
            $updatedBy_obj = new \stdClass();
            $updatedBy_obj->id = new ObjectID(Auth::id());
            $updatedBy_obj->name = Auth::user()->name;
            $updatedBy_obj->date = date('d/m/Y');
            $updatedBy_obj->action = "E comparison send";
            $updatedBy[] = $updatedBy_obj;
            WorkTypeData::where('_id', new ObjectId($pipelineId))->push('updatedBy', $updatedBy);
            $pipeLine->documentNo = $number;
            $pipeLine->save();
            return 'E-comparison has been sent to '.$email;
        }
        else{
            return 'Failed! Email ID not provided for this customer';
        }

    }

     /**
      * Function for save as PDF
      */
    public function savePDF($pipelineId)
    {
        $pipeline_details=WorkTypeData::find($pipelineId);
        $insurerReplay=$pipeline_details['insurerReplay'];
        foreach ($insurerReplay as $insures_rep)
        {
            if($insures_rep['quoteStatus']=='active') {
                $insures_details[]=$insures_rep;
            }
        }
        $alreadySelected=$pipeline_details->selected_insurers;
        foreach ($alreadySelected as $selected)
        {
            if($selected['active_insurer']=='active') {
                $selectedId[]=$selected['insurer'];
            }
        }
                // return view('forms.property.e_comparison_pdf')->with(compact('pipeline_details', 'insures_details', 'selectedId'));;

        $pdf = PDF::loadView('forms.e_comparison_pdf', ['pipeline_details' => $pipeline_details, 'selectedId'=>$selectedId,'insures_details' => $insures_details])->setPaper('a3')->setOrientation('landscape')->setOption('margin-bottom', 0);
        $pdf_name = 'e_comparison_'.time().'_'.$pipelineId.'.pdf';
        $pdf->setOption('margin-top', 5);
        $pdf->setOption('margin-bottom', 5);
        $pdf->setOption('margin-left', 0);
        $pdf->setOption('margin-right', 0);
        $temp_path =public_path('pdf/'.$pdf_name);
        $pdf->save('pdf/'.$pdf_name);
        $pdf_file = $this->uploadFileToCloud_file($pdf_name, $temp_path);
        unlink($temp_path);
        $comparison_file_object = new \stdClass();
        $comparison_file_object->name = $pdf_name;
        $comparison_file_object->url = $pdf_file;
        $comparison_file_object->date = (string)date('d/m/Y');
        $pipeline_details->push('comparisonUploads', $comparison_file_object);
        $pipeline_details->save();
        return $pdf->inline($pdf_name);
    }

    /**
     * Function for upload file to cloud
     */
    private static function uploadFileToCloud_file($file_name,$public_path)
    {
        $filePath = '/'.$file_name;
        $disk = Storage::disk('s3');
        $disk->put($filePath, fopen($public_path, 'r+'), 'public'); //uploading as streams, useful for large uploads.
        $file_url = 'https://s3-'.Config::get('filesystems.disks.s3.region').'.amazonaws.com/'.Config::get('filesystems.disks.s3.bucket').$filePath;
        return $file_url;
    }

    /**
     * Function for quot amendment in e quotation
     */
    public function amendQuot(Request $request)
    {
        try
        {
            $uniqueToken = $request->input('token');
            $id = $request->input('id');
            $field = $request->input('field');
            $new_quot = $request->input('new_quot');
            $pipelineDetails = WorkTypeData::find($id);
            if($pipelineDetails) {
                $replies = $pipelineDetails->insurerReplay;
                foreach($replies as $key =>$reply)
                {
                    if($reply['uniqueToken']==$uniqueToken) {
                        if($field != 'coverHiredWorkers' && $field != 'herniaCover' && $field != 'HoursPAC' && $field != 'coverOffshore' && $field != 'waiverOfSubrogation'
                            && $field != 'automaticClause' && $field != 'automaticClause' && $field != 'brokersClaimClause' && $field != 'lossNotification'
                        ) {
                            if($field=='medicalExpense' || $field=='repatriationExpenses') {
                                $old_quot = $reply[$field];
                                $old_quot=str_replace(',', '', $old_quot);
                                $new_quot=str_replace(',', '', $new_quot);
                            }
                            else{
                                $old_quot = $reply[$field];
                            }
                            $amend_object = new \stdClass();
                            $amend_object->amendedBy = new ObjectId(Auth::id());
                            $amend_object->name = Auth::user()->name;
                            $amend_object->field = $field;
                            $amend_object->oldQuot = $old_quot;
                            $amend_object->newQuot = $new_quot;
                            $item = WorkTypeData::where('_id', $id)->first();
                            $item->push('insurerReplay.'.$key.'.amendmentDetails', $amend_object);
                            $updatedBy_obj = new \stdClass();
                            $updatedBy_obj->id = new ObjectID(Auth::id());
                            $updatedBy_obj->name = Auth::user()->name;
                            $updatedBy_obj->date = date('d/m/Y');
                            $updatedBy_obj->action = "Quote amended";
                            $updatedBy[] = $updatedBy_obj;
                            $item->push('updatedBy', $updatedBy);
                            $item->save();
                            WorkTypeData::where('_id', $id)->update(array('insurerReplay.'.$key.'.'.$field => $new_quot));
                        }
                        else
                        {
                            if($request->get('comment') == "") {
                                $old_quot = $reply[$field]['isAgree'];
                                $amend_object = new \stdClass();
                                $amend_object->amendedBy = new ObjectId(Auth::id());
                                $amend_object->name = Auth::user()->name;
                                $amend_object->field = $field;
                                $amend_object->oldQuot = $old_quot;
                                $amend_object->newQuot = $new_quot;
                                $item = WorkTypeData::where('_id', $id)->first();
                                $item->push('insurerReplay.'.$key.'.amendmentDetails', $amend_object);
                                $updatedBy_obj = new \stdClass();
                                $updatedBy_obj->id = new ObjectID(Auth::id());
                                $updatedBy_obj->name = Auth::user()->name;
                                $updatedBy_obj->date = date('d/m/Y');
                                $updatedBy_obj->action = "Quote amended";
                                $updatedBy[] = $updatedBy_obj;
                                $item->push('updatedBy', $updatedBy);
                                $item->save();
                                WorkTypeData::where('_id', $id)->update(array('insurerReplay.'.$key.'.'.$field.'.isAgree' => $new_quot));
                            }
                            else
                            {
                                $old_quot ="Comment : ". $reply[$field]['comment'];
                                $amend_object = new \stdClass();
                                $amend_object->amendedBy = new ObjectId(Auth::id());
                                $amend_object->name = Auth::user()->name;
                                $amend_object->field = $field;
                                $amend_object->oldQuot = $old_quot;
                                $amend_object->newQuot ="Comment : ". $new_quot;
                                $item = WorkTypeData::where('_id', $id)->first();
                                $item->push('insurerReplay.'.$key.'.amendmentDetails', $amend_object);
                                $updatedBy_obj = new \stdClass();
                                $updatedBy_obj->id = new ObjectID(Auth::id());
                                $updatedBy_obj->name = Auth::user()->name;
                                $updatedBy_obj->date = date('d/m/Y');
                                $updatedBy_obj->action = "Quote amended";
                                $updatedBy[] = $updatedBy_obj;
                                $item->push('updatedBy', $updatedBy);
                                $item->save();
                                WorkTypeData::where('_id', $id)->update(array('insurerReplay.'.$key.'.'.$field.'.comment' => $new_quot));
                            }
                        }
                    }
                }
            }
            return 'success';
        }
        catch (\Exception $e)
        {
            return 'failed';
        }

    }
    /**
     * Function for fill permission popup
     */
    public function givePermission(Request $request)
    {
        $piplineId = $request->get('pipeline_id');
        $pipelineDetails = WorkTypeData::find($piplineId);
        $creator = $pipelineDetails->createdBy['id'];
        $permittedUsers = $pipelineDetails->commentPermission;
        $users = User::where('isActive', 1)->where(
            function ($q) {
                $q->where('role', 'AD')->orWhere('role', 'EM')->orWhere('role', 'AG');
            }
        )->get();
        return view('forms.give_permission')->with(compact('users', 'creator', 'permittedUsers'));
    }

    /**
     * save prmission for comments
     */
    public function permissionSave(Request $request)
    {
        try {
            $pipelineId = $request->input('worktype_id');
            $pipeline=WorkTypeData::find($pipelineId);
            if(isset($pipeline->commentPermission)) {
                DB::collection('WorkTypeData')->where('_id', new ObjectId($request->input('worktype_id')))->unset(['commentPermission']);
            }
            $users = $request->input('users');
            $object_array = [];
            if($users) {
                foreach ($users as $user) {
                    $object_array[] = new ObjectId($user);
                }
            }
            $object_array[] = new ObjectId(Auth::id());
            WorkTypeData::where('_id', $pipelineId)->update(['commentPermission' => $object_array]);
            return 'success';
        }
        catch(\Exception $e)
        {
            return 'failed';
        }
    }

    /**
     * GET FILE DETAILS FOR FILE UPLOAD BOX
     */
    public function getFiles(Request $request)
    {
        $id = $request->get('pipeline_id');
        $pipeline_details = WorkTypeData::find($id);
        $data = [];
        $files = $pipeline_details->files;
        foreach ($files as $file) {
            if($file['url'] != "") {
                $file_data = new \stdClass();
                $file_data->filename = $file['file_name'];
                $file_data->url = $file['url'];
                $data[] = $file_data;
            }
        }
        return json_encode($data);
    }
    /**
     * Function for amend issuance
     */
    public function issuanceAmend(Request $request)
    {
        try
        {
            $id = $request->input('id');
            $new_data = $request->input('data');
            $field = $request->input('field');
            $pipelineDetails = WorkTypeData::find($id);
            if($pipelineDetails) {
                $old_data = $pipelineDetails['accountsDetails'][$field];
                WorkTypeData::where('_id', $id)->update(array('accountsDetails.'.$field => $new_data));
                if($field == 'commissionPremium' || $field == 'agentCommissionAmount') {
                    $this->issuanceReverse($id, $field);
                }
                else
                {
                    $this->issuanceCalculation($id);
                }
                $amend_object = new \stdClass();
                $amend_object->amendedBy = new ObjectId(Auth::id());
                $amend_object->name = Auth::user()->name;
                $amend_object->field = $field;
                $amend_object->oldData = $old_data;
                $amend_object->newData = $new_data;
                $item = WorkTypeData::where('_id', $id)->first();
                $item->push('accountsDetails.amendmentDetails', $amend_object);
                $updatedBy_obj = new \stdClass();
                $updatedBy_obj->id = new ObjectID(Auth::id());
                $updatedBy_obj->name = Auth::user()->name;
                $updatedBy_obj->date = date('d/m/Y');
                $updatedBy_obj->action = "Issuance amended";
                $updatedBy[] = $updatedBy_obj;
                $item->push('updatedBy', $updatedBy);
                $item->save();
                return 'success';
            }
            else
            {
                return 'failed';
            }
        }
        catch(\Exception $e)
        {
            return 'failed';
        }
    }

    /**
     * calculate issuance data
     */
    public function issuanceCalculation($pipelineId)
    {
        $pipeline_details = WorkTypeData::find($pipelineId);
        $premium = $pipeline_details['accountsDetails']['premium'];
        $vat_total = $pipeline_details['accountsDetails']['vatTotal'];
        $commission_percent = $pipeline_details['accountsDetails']['commissionPercent'];
        $commission_premium = $pipeline_details['accountsDetails']['commissionPremium'];
        $commission_vat = $pipeline_details['accountsDetails']['commissionVat'];
        $insurer_discount = $pipeline_details['accountsDetails']['insurerDiscount'];
        $iib_discount = $pipeline_details['accountsDetails']['iibDiscount'];
        $insurer_fee = $pipeline_details['accountsDetails']['insurerFees'];
        $iib_fee = $pipeline_details['accountsDetails']['iibFees'];
        $agent_percent = $pipeline_details['accountsDetails']['agentCommissionPecent'];
        $agent_amount = $pipeline_details['accountsDetails']['agentCommissionAmount'];


        $vat_total = $premium*5/100;
        $vat_total = round($vat_total, 2);

        $commission_premium = ($premium-$insurer_discount)*$commission_percent/100;
        $commission_premium = round($commission_premium, 2);

        $commission_vat = ((($premium-$insurer_discount)*5/100)*$commission_percent/100);
        $commission_vat = round($commission_vat, 2);

        $agent_amount = ($commission_premium*$agent_percent/100);
        $agent_amount = round($agent_amount, 2);

        $payable_insurer = (($premium+$vat_total)-$iib_discount-$commission_premium-$commission_vat);
        $payable_insurer = round($payable_insurer, 2);

        if($insurer_discount>0) {
            $first = $premium-$insurer_discount-$iib_discount;
            $second = $insurer_fee*5/100;
            $third = $first+$second+$iib_fee;
            $fourth = ($premium-$insurer_discount)*5/100;
            $payable_customer = ($third+$fourth);
            $payable_customer = round($payable_customer, 2);
        }
        else
        {
            $payable_customer = ($premium+$vat_total-$iib_discount);
        }

        $data = [];
        $data['accountsDetails.premium'] = $premium;
        $data['accountsDetails.vatTotal'] = $vat_total;
        $data['accountsDetails.commissionPercent'] = $commission_percent;
        $data['accountsDetails.commissionPremium'] = $commission_premium;
        $data['accountsDetails.commissionVat'] = $commission_vat;
        $data['accountsDetails.insurerDiscount'] = $insurer_discount;
        $data['accountsDetails.iibDiscount'] = $iib_discount;
        $data['accountsDetails.insurerFees'] = $insurer_fee;
        $data['accountsDetails.iibFees'] = $iib_fee;
        $data['accountsDetails.agentCommissionPecent'] = $agent_percent;
        $data['accountsDetails.agentCommissionAmount'] = $agent_amount;
        $data['accountsDetails.payableToInsurer'] = $payable_insurer;
        $data['accountsDetails.payableByClient'] = $payable_customer;

        WorkTypeData::where('_id', $pipelineId)->update($data);
    }

    /**
     * issuance reverse calculation
     */
    public function issuanceReverse($pipelineId,$field)
    {
        $pipeline_details = WorkTypeData::find($pipelineId);
        $premium = $pipeline_details['accountsDetails']['premium'];
        $vat_total = $pipeline_details['accountsDetails']['vatTotal'];
        $commission_percent = $pipeline_details['accountsDetails']['commissionPercent'];
        $commission_premium = $pipeline_details['accountsDetails']['commissionPremium'];
        $commission_vat = $pipeline_details['accountsDetails']['commissionVat'];
        $insurer_discount = $pipeline_details['accountsDetails']['insurerDiscount'];
        $iib_discount = $pipeline_details['accountsDetails']['iibDiscount'];
        $insurer_fee = $pipeline_details['accountsDetails']['insurerFees'];
        $iib_fee = $pipeline_details['accountsDetails']['iibFees'];
        $agent_percent = $pipeline_details['accountsDetails']['agentCommissionPecent'];
        $agent_amount = $pipeline_details['accountsDetails']['agentCommissionAmount'];

        $commission_percent = ($commission_premium/($premium-$iib_discount))*100;
        $commission_percent = round($commission_percent, 2);

        if($field == 'agentCommissionAmount') {
            $agent_percent = (($agent_amount/$commission_premium)*100);
            $agent_percent = round($agent_percent, 2);
        }

        $vat_total = $premium*5/100;
        $vat_total = round($vat_total, 2);

        $commission_premium = ($premium-$insurer_discount)*$commission_percent/100;
        $commission_premium = round($commission_premium, 2);

        $commission_vat = ((($premium-$insurer_discount)*5/100)*$commission_percent/100);
        $commission_vat = round($commission_vat, 2);

        $agent_amount = ($commission_premium*$agent_percent/100);
        $agent_amount = round($agent_amount, 2);

        $payable_insurer = (($premium+$vat_total)-$iib_discount-$commission_premium-$commission_vat);
        $payable_insurer = round($payable_insurer, 2);

        if($insurer_discount>0) {
            $first = $premium-$insurer_discount-$iib_discount;
            $second = $insurer_fee*5/100;
            $third = $first+$second+$iib_fee;
            $fourth = ($premium-$insurer_discount)*5/100;
            $payable_customer = ($third+$fourth);
            $payable_customer = round($payable_customer, 2);
        }
        else
        {
            $payable_customer = ($premium+$vat_total-$iib_discount);
        }

        $data = [];
        $data['accountsDetails.premium'] = $premium;
        $data['accountsDetails.vatTotal'] = $vat_total;
        $data['accountsDetails.commissionPercent'] = $commission_percent;
        $data['accountsDetails.commissionPremium'] = $commission_premium;
        $data['accountsDetails.commissionVat'] = $commission_vat;
        $data['accountsDetails.insurerDiscount'] = $insurer_discount;
        $data['accountsDetails.iibDiscount'] = $iib_discount;
        $data['accountsDetails.insurerFees'] = $insurer_fee;
        $data['accountsDetails.iibFees'] = $iib_fee;
        $data['accountsDetails.agentCommissionPecent'] = $agent_percent;
        $data['accountsDetails.agentCommissionAmount'] = $agent_amount;
        $data['accountsDetails.payableToInsurer'] = $payable_insurer;
        $data['accountsDetails.payableByClient'] = $payable_customer;

        WorkTypeData::where('_id', $pipelineId)->update($data);
    }
    /**
     * Function for load files for attach with email
     */
    public function emailFilesLoad(Request $request)
    {
        try
        {
            $pipelineId = $request->get('id');
            $pipeline_details = WorkTypeData::find($pipelineId);
            $data = [];
            $files = $pipeline_details->files;
            foreach ($files as $file) {
                if ($file['url'] != "") {
                    $file_data = new \stdClass();
                    $file_data->filename = $file['file_name'];
                    $file_data->url = $file['url'];
                    $data[] = $file_data;
                }
            }
            return view('forms.uploaded_file_list')->with('datas', $data);
        }
        catch (\Exception $e)
        {
            return $e;
        }
    }

     /**
      * Function for load files for attach with email
      */
    public function emailFilesLoadSlip(Request $request)
    {
        try
        {
            $pipelineId = $request->input('pipeline_id');
            $pipeline_details=WorkTypeData::find($pipelineId);
            $send_type=$request->input('send_type');
            $existing_insures=[];
            $insurance_companies=$request->input('insurance_companies');
            if(isset($pipeline_details->insuraceCompanyList)) {
                $insurence_company = $pipeline_details->insuraceCompanyList;
                foreach ($insurence_company as $company) {
                    $existing_insures[] = $company['id'];
                }
                if ($send_type == 'send_new') {
                    $flg = 0;
                    foreach ($insurance_companies as $x => $x_value) {
                        if (!in_array($x_value, $existing_insures)) {
                            $flg = 1;
                        }
                    }
                    if ($flg == 0) {
                        return response()->json(['success' => 'failed', 'id' => $request->input('pipeline_id')]);
                    }
                }
            }
            $pipeline_details = WorkTypeData::find($pipelineId);
            $data = [];
            $files = $pipeline_details->files;
            foreach ($files as $file) {
                if ($file['url'] != "") {
                    $file_data = new \stdClass();
                    $file_data->filename = $file['file_name'];
                    $file_data->url = $file['url'];
                    $data[] = $file_data;
                }
            }
            $documentSection = view('forms.uploaded_file_list', ['datas' => $data])->render();
            return response()->json(['success'=>'success','documentSection'=>$documentSection]);
        }
        catch (\Exception $e)
        {
            return $e;
        }
    }

}
