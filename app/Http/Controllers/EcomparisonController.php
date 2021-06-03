<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ESlipFormData;
use App\WorkTypeData;
use MongoDB\BSON\ObjectID;
use App\Jobs\SendComparison;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;
use App\PipelineStatus;
use PDF;
class EcomparisonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.underwriter', ['except' => ['viewComparison', 'customerDecision', 'eComparisonPdf']]);
    }
    public function EComparison($Id) //call initial widgets page
    {

        $workTypeDataId = $Id;
        $eComparisonData = [];
        $InsurerData = [];
        $Insurer = [];
        $selectedInsurers = [];
        $formValues = WorkTypeData::where('_id', new ObjectId($Id))->first();

        $eSlipFormData = $formValues;
        $d = $eSlipFormData['eSlipData'];
        $formData = [];
        if (!empty($d)) {
            foreach ($d as $step => $value) {
                foreach ($value as $key => $val) {
                    //if ($val['fieldName'] != 'brokerage' && $val['fieldName'] != 'CombinedOrSeperatedRate') {
                        $formData[$val['fieldName']] = $val;
                    //}
                }
            }
        }

        if ($eSlipFormData) {
            $eComparisonData = $eSlipFormData->eSlipData;
            // dd($eComparisonData);
            $InsurerList = $eSlipFormData->insurerReply;
            $selectedInsurers =  $eSlipFormData->selected_insurers;
        }

        $final =[];
        if ($InsurerList) {
            foreach ($InsurerList as $key => $insurer) {
                if ($selectedInsurers) {
                    foreach ($selectedInsurers as $key1 => $selected) {
                        if ($insurer['quoteStatus'] == 'active') {
                            if ($selected['insurer'] == $insurer['uniqueToken'] && $selected['active_insurer'] == 'active') {
                                $Insurer[] = $insurer;
                            }

                        }
                    }
                }
            }
        }
        $InsurerData  = $this->flip($Insurer);
        // dd($InsurerData);
        $title = 'E-Comparison';
        //attached documents

        $documents = [];
        $files = $eSlipFormData->files;
        if ($files) {
            foreach ($files as $file) {
                if ($file['url'] != "") {
                    $file_data = new \stdClass();
                    $file_data->filename = $file['file_name'];
                    $file_data->url = $file['url'];
                    $documents[] = $file_data;
                }
            }
        }

        // dd($documents);
        return view('pages.eComparison')->with(compact('workTypeDataId', 'formValues', 'title', 'eComparisonData', 'InsurerData', 'Insurer', 'formData', 'selectedInsurers', 'documents'));
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
      * Function for send comparison to the customer
      */
    public function sendComparison(Request $request)
    {
        $to_email = $request->input('to_email');
        $cc_email = $request->input('cc_email');
        $cc_email = array_filter($cc_email);
        $workTypeDataId = $request->input('id');
        $files = $request->input('files');
        $comment = $request->input('txt_comment');
        $status = 0;
        $pipeLine = WorkTypeData::find(new ObjectId($workTypeDataId));
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

        if (isset($pipeLine['documentNo'])) {
            $number = $pipeLine['documentNo'] + 1;
        } else {
            $number = 0;
        }

        if ($status == 0) {
            $name = $pipeLine->customer['name'];
            $email = $pipeLine->getCustomer->email[0];
        }
        if (isset($to_email) && !empty($to_email)) {
            $email = $to_email;
        }
        $refNo = $pipeLine->refereneceNumber;
        $token_object = new \stdClass();
        $token_object->token = (string)$token;
        $token_object->status = (string)'active';
        $token_object->date = date('d/m/Y');
        $token_object->viewStatus = (string)'Sent to customer';
        $pipeLine->comparisonToken = $token_object;
        $workType = $pipeLine->workTypeId['name'];
        // if ($workType=="Workman's Compensation") {
            // $link = url('/ecomparison-proposal/' . $token);
            $link = url('/ecomparison-proposal/' . $workTypeDataId);
            $temp_link = url('/ecomparison-proposal/' . $workTypeDataId);
        // }
        if (isset($email)&& !empty($email)) {
            SendComparison::dispatch($email, $name, $link, $workType, $refNo, $files, $comment, @$cc_email);
            $updatedBy_obj = new \stdClass();
            $updatedBy_obj->id = new ObjectID(Auth::id());
            $updatedBy_obj->name = Auth::user()->name;
            $updatedBy_obj->date = date('d/m/Y');
            $updatedBy_obj->action = "E comparison send";
            $updatedBy[] = $updatedBy_obj;
            WorkTypeData::where('_id', new ObjectId($workTypeDataId))->push('updatedBy', $updatedBy);
            $pipeLine->documentNo = $number;
            $pipeLine->save();
            if (!empty($cc_email)) {
                $mssg = 'E-comparison has been sent to ' . $email . ','.implode(", ", $cc_email);
            } else {
                $mssg = 'E-comparison has been sent to ' . $email;
            }
            Session::flash('success', $mssg);

            return 'E-comparison has been sent to '.$email;
        } else {
            Session::flash('failed', 'Failed! Email ID not provided for this customer');
            return 'Failed! Email ID not provided for this customer';
        }

    }
    /**
     * Send Ecomparison Data to Customer
     */
    public function viewComparison($Id)
    {
        $workTypeDataId = $Id;
        $eQuotationData = [];
        $InsurerData = [];
        $Insurer = [];
        $formValues = WorkTypeData::find(new ObjectId($Id));
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

        $basicDetails = [];
        $basicDetails['name']= @$eSlipFormData->workTypeId['name'];
        $basicDetails['refereneceNumber'] = @$eSlipFormData->refereneceNumber;
        $basicDetails['customer']= @$eSlipFormData->customer['name'];
        $basicDetails['customer_id']= @$eSlipFormData->customer['customerCode'];
        $basicDetails['date']=  @$eSlipFormData->comparisonToken['date'];
        if ($eSlipFormData) {
            $eQuotationData = $eSlipFormData->eSlipData;
            $Insurer = [];
            foreach ($eSlipFormData->insurerReply as $insure) {
                if ($eSlipFormData->selected_insurers) {
                    foreach ($eSlipFormData->selected_insurers as $selected) {
                        if ($selected['active_insurer'] == 'active' && @$insure['quoteStatus'] == 'active') {
                            if ($selected['insurer'] == $insure['uniqueToken']) {
                                $Insurer[] = $insure;
                            }
                        }
                    }
                }
            }
            $InsurerData  = $this->flip($Insurer);
        }
        if ($eSlipFormData->selected_insurers) {
            if ($eSlipFormData->comparisonToken['status'] == 'active') {
                if ($eSlipFormData->comparisonToken['viewStatus'] == 'Sent to customer') {
                    WorkTypeData::where('_id', $Id)->update(array('comparisonToken.viewStatus' => 'Viewed by customer'));
                }
                $title = 'E-comparison Proposal';
                return view('pages.ecomparison-proposal')->with(compact('workTypeDataId', 'formValues', 'title', 'eQuotationData', 'InsurerData', 'Insurer', 'formData', 'basicDetails'));
            } else {
                Session::flash('msg', "You have already completed the proposal");
                return view('customer_notification');
            }
        } else {
            Session::flash('msg', "This link is not active yet.");
            return view('customer_notification');
        }
    }
    /**
     * Ecomparison Data Save
     */
    public function customerDecision(Request $request)
    {

        $workTypeDataId = new ObjectID($request->input('workTypeDataId'));
        $eSlipFormData_det = WorkTypeData::where('_id', new ObjectId($workTypeDataId));
        $eSlipFormData = $eSlipFormData_det->first();
        $insurerIdArr = $request->input('insurer_id');
        $flag =0;
        // try {
        if ($eSlipFormData->comparisonToken['status'] == 'active') {
            $eSlipFormData_det->update(array('comparisonToken.status' => 'inactive'));
            $insures_details = [];
            $Insurer = $eSlipFormData->insurerReply;
            // $insurerList = $eSlipFormData->insurerList;
            if (isset($Insurer)) {
                foreach ($Insurer as $insures_rep) {
                    if ($insures_rep['quoteStatus'] == 'active') {
                        $insures_details[] = $insures_rep;
                    }
                }
            }
            $cust_flag = 0;
            foreach ($eSlipFormData->insurerReply as $key => $insure) {
                if ($insure['quoteStatus'] == 'active') {
                    if ($insure['uniqueToken']&& in_array($insure['uniqueToken'], $insurerIdArr)) {
                        $cust_flag++;
                        // if ($request->input('customer-decision_'.$insure['uniqueToken']) != '') {
                        if ($request->input('customer-decision_'.@$insure['uniqueToken']) == "Approved") {
                            $eSlipFormData_det->where(['insurerReply.' . $key .'.uniqueToken'=> @$insure['uniqueToken'],'insurerReply.' . $key .'.quoteStatus'=> 'active' ])->update(
                                array(
                                    'insurerReply.' . $key . '.customerDecision.decision' => $request->input('customer-decision_'.$insure['uniqueToken']),
                                    'insurerReply.' . $key . '.customerDecision.comment' => $request->input('comment_'.$insure['uniqueToken']),
                                    'insurerReply.' . $key . '.customerDecision.rejectReason' => ''
                                )
                            );
                        } else {
                            if ($request->input('customer-decision_'.$insure['uniqueToken']) != '') {
                                $custDescion = $request->input('customer-decision_'.$insure['uniqueToken']);
                            } else {
                                $custDescion = 'Discarded';
                            }

                            $eSlipFormData_det->where(['insurerReply.' . $key .'.uniqueToken'=> @$insure['uniqueToken'],'insurerReply.' . $key .'.quoteStatus'=> 'active' ])->update(
                                array(
                                    'insurerReply.' . $key . '.customerDecision.decision' => @$custDescion,
                                    'insurerReply.' . $key . '.customerDecision.comment' => $request->input('comment_'.$insure['uniqueToken']),
                                    'insurerReply.' . $key . '.customerDecision.rejectReason' => $request->input('reason_'.$insure['uniqueToken']))
                            );
                        }
                            $decision = [];
                            $decision_object = new \stdClass();
                            $decision_object->decision = $request->input('customer-decision_'.$insure['uniqueToken']);
                            $decision_object->comment = $request->input('comment_'.$insure['uniqueToken']);
                            $decision[] = $decision_object;
                            $eSlipFormData_det->push('insurerReply.' . $key . '.previousDecision', $decision);
                        if ($request->input('customer-decision_'.$insure['uniqueToken']) == "Approved") {
                            $flag = 1;
                            // break;
                        }

                        // }
                    }
                }
            }
            if (($eSlipFormData->comparisonToken['viewStatus'] == 'Viewed by customer' || $eSlipFormData->comparisonToken['viewStatus'] == 'Downloaded as Pdf') && $cust_flag != 0) {
                $eSlipFormData_det->update(array('comparisonToken.viewStatus' => 'Responded by customer'));
            }
            if ($flag == 0) {
                $pipeline_status = PipelineStatus::where('status', 'Quote Amendment')->first();
                $status = 0;
                $departments = $eSlipFormData->getCustomer['departmentDetails'];
                if (isset($departments)) {
                    foreach ($departments as $department) {
                        if ($department['departmentName'] == 'Genaral & Marine') {
                            $status_array = array('status.id' => new ObjectID($pipeline_status->_id),
                            'status.status' => (string) $pipeline_status->status,
                            'status.UpdatedById' => new ObjectID($department['department']),
                            'status.UpdatedByName' => 'Genaral & Marine (' . $department['depContactPerson'] . ')',
                            'status.date' => date('d/m/Y'));
                            $status = 1;
                            break;
                        }
                    }
                }
                if ($status == 0) {
                    $status_array = array('status.id' => new ObjectID($pipeline_status->_id),
                    'status.status' => (string) $pipeline_status->status,
                    'status.UpdatedById' => new ObjectId($eSlipFormData->getCustomer['_id']),
                    'status.UpdatedByName' => 'Customer (' . $eSlipFormData->getCustomer['firstName'] . ')',
                    'status.date' => date('d/m/Y'));
                }
                $eSlipFormData_det->update($status_array);
                Session::flash('msg', "We have received your feedback on the proposal");
                Session::flash('refNo', $eSlipFormData->refereneceNumber);
            } else {
                $pipeline_status = PipelineStatus::where('status', 'Approved E Quote')->first();
                $status = 0;
                $departments = $eSlipFormData->getCustomer['departmentDetails'];
                if (isset($departments)) {
                    foreach ($departments as $department) {
                        if ($department['departmentName'] == 'Genaral & Marine') {
                            $status_array = array('status.id' => new ObjectID($pipeline_status->_id),
                            'status.status' => (string) $pipeline_status->status,
                            'status.UpdatedById' => new ObjectID($department['department']),
                            'status.UpdatedByName' => 'Genaral & Marine (' . $department['depContactPerson'] . ')',
                            'status.date' => date('d/m/Y'));
                            $status = 1;
                            break;
                        }
                    }
                }
                if ($status == 0) {
                    $status_array = array('status.id' => new ObjectID($pipeline_status->_id),
                    'status.status' => (string) $pipeline_status->status,
                    'status.UpdatedById' => new ObjectId($eSlipFormData->getCustomer['_id']),
                    'status.UpdatedByName' => 'Customer (' . $eSlipFormData->getCustomer['firstName'] . ')',
                    'status.date' => date('d/m/Y'));
                }
                $eSlipFormData_det->update($status_array);
                Session::flash('insurer', $insure['insurerDetails']['insurerName']);
                // if($workType=='Employers Liability')
                // {
                //     Session::flash('msg', "You have approved the proposal for employers liability");
                // }else if($workType=="Workman's Compensation"){
                //     Session::flash('msg', "You have approved the proposal for workman's compensation");
                // }
                Session::flash('msg', "You have approved the proposal for " . $eSlipFormData->workTypeId['name']);
                Session::flash('refNo', $eSlipFormData->refereneceNumber);
            }

            $status = 0;
            $departments = $eSlipFormData->getCustomer['departmentDetails'];
            if (isset($departments)) {
                foreach ($departments as $department) {
                    if ($department['departmentName'] == 'Genaral & Marine') {
                        $updatedBy_obj = new \stdClass();
                        $updatedBy_obj->id = new ObjectID($department['department']);
                        $updatedBy_obj->name = 'Genaral & Marine (' . $department['depContactPerson'] . ')';
                        $updatedBy_obj->date = date('d/m/Y');
                        $updatedBy_obj->action = "E comparison done";
                        $updatedBy[] = $updatedBy_obj;
                        $status = 1;
                        break;
                    }
                }
            }
            if ($status == 0) {
                $updatedBy_obj = new \stdClass();
                $updatedBy_obj->id = new ObjectID($eSlipFormData->getCustomer['id']);
                $updatedBy_obj->name = 'Customer (' . @$eSlipFormData->getCustomer['first_name'] .' ' .@$eSlipFormData->custgetCustomeromer['middle_name'] . ' ' . @$eSlipFormData->getCustomer['last_name'] .')';
                $updatedBy_obj->date = date('d/m/Y');
                $updatedBy_obj->action = "E comparison done";
                $updatedBy[] = $updatedBy_obj;
            }

            $eSlipFormData_det->push('updatedBy', $updatedBy);



            if ($request->input('responder') == '') {
                Session::flash('msg', "Thank you for contacting Interactive Insurance Brokers. Your feedback/Response has been received and we shall revert to you soon.");
                return 'success';
            } else {
                return 'success';
            }
        } else {
            Session::flash('msg', "This Link become Inactive.");
            return 'failed';
        }
        // } catch (\Exception $e) {
        //     Session::flash('msg', "Something Went Wrong Please try Again..!!");
        //     return 'failed';
        // }
    }



    /**
     * Downlad as pdf in ecomparsion
     *
     * @parameter worktypedataid
     */
    public function eComparisonPdf($Id)
    {
        try {
            if ($Id) {
                $workTypeDataId = $Id;
                $eQuotationData = [];
                $InsurerData = [];
                $Insurer = [];
                $formValues = WorkTypeData::find(new ObjectId($Id));
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
                        if ($eSlipFormData->selected_insurers) {
                            foreach ($eSlipFormData->selected_insurers as $selected) {
                                if ($insure['quoteStatus'] == 'active' ) {
                                    if ($selected['insurer'] == $insure['uniqueToken'] && $selected['active_insurer'] == 'active') {
                                        $Insurer[] = $insure;
                                    }
                                }
                            }
                        }
                    }
                    $InsurerData  = $this->flip($Insurer);
                }
                $title = 'E-comparison Quotation';
                // return view('pages.ecomparison_pdf')->with(compact('workTypeDataId', 'formValues', 'title', 'eQuotationData', 'InsurerData', 'Insurer', 'formData', 'basicDetails'));
                $pdf = PDF::loadView(
                    'pages.ecomparison_pdf', [
                        'workTypeDataId'=>$workTypeDataId,
                        'formValues'=>$formValues,
                        'title'=>$title,
                        'eQuotationData'=>$eQuotationData,
                        'InsurerData'=>$InsurerData,
                        'Insurer'=>$Insurer,
                        'formData'=>$formData,
                        'basicDetails'=>$basicDetails
                        ]
                )->setPaper('a4')->setOrientation('portrait');
                    $pdf->setOption("footer-right", "[page] of [topage]");
                    $pdf->setOption("footer-font-size", 7);
                    $pdf_name = 'e_comparison_'.time().'_'.$Id.'.pdf';
                    $pdf->setOption('margin-top', 5);
                    $pdf->setOption('margin-bottom', 5);
                    $pdf->setOption('margin-left', 5);
                    $pdf->setOption('margin-right', 5);
                    $temp_path = public_path('pdf/'.$pdf_name);
                    $pdf->save('pdf/'.$pdf_name);
                    $pdf_file = $this->uploadFileToCloud_file($pdf_name, $temp_path);
                    unlink($temp_path);
                    $comparison_file_object = new \stdClass();
                    $comparison_file_object->name = $pdf_name;
                    $comparison_file_object->url = $pdf_file;
                    $comparison_file_object->date = (string) date('d/m/Y');
                    $formValues->push('comparisonUploads', $comparison_file_object);
                    $formValues->save();
                    //(@$formValues->comparisonToken['viewStatus'] != 'Responded by customer') && (
                if (@$formValues['status']['status'] != 'Approved E Quote') {
                    $token_object = new \stdClass();
                    $token = str_random(3).time().str_random(3);
                    $token_object->token = (string)$token;
                    $token_object->status = (string)'active';
                    $token_object->date = date('d/m/Y');
                    $token_object->viewStatus = (string)'Downloaded as Pdf';
                    $formValues->comparisonToken = $token_object;
                    $formValues->save();
                }
                return $pdf->inline($pdf_name);
            }
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }
     /**
      * Function for upload file to cloud.
      */
    private static function uploadFileToCloud_file($file_name, $public_path)
    {
        $filePath = '/'.$file_name;
        $disk = Storage::disk('s3');
        $disk->put($filePath, fopen($public_path, 'r+'), 'public'); //uploading as streams, useful for large uploads.
        $file_url = 'https://s3-'.Config::get('filesystems.disks.s3.region').'.amazonaws.com/'.Config::get('filesystems.disks.s3.bucket').$filePath;

        return $file_url;
    }
    public function lostBusiness(Request $request)
    {
        if ($request->input('workTypeDataId')) {
            $workTypeDataId = $request->input('workTypeDataId');
            $formValues = WorkTypeData::find(new ObjectId($workTypeDataId));
            $pipeline_status = PipelineStatus::where('status', 'Lost Business')->first();
            $status_array = array('status.id' => new ObjectID($pipeline_status->_id),
            'status.status' => (string) $pipeline_status->status,
            'status.UpdatedById' => new ObjectId(Auth::id()),
            'status.UpdatedByName' => 'Admin',
            'status.date' => date('d/m/Y'),
            'pipelineStatus' => "lost business"
            );
            WorkTypeData::where('_id', new ObjectId($workTypeDataId))->update($status_array);
            Session::flash('status', "Worktype has been successfully moved to lost business.");
            return 'Sucess';
        } else {
            return 'Failed';
        }
    }
}
