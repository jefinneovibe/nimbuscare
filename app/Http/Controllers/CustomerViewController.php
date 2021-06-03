<?php

namespace App\Http\Controllers;

use App\CountryListModel;
use App\Customer;
use App\Insurer;
use App\Jobs\SendEquestionnaireCompleted;
use App\PipelineItems;
use App\PipelineStatus;
use App\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use MongoDB\BSON\ObjectId;

class CustomerViewController extends Controller
{
    /**
     * Function for display e questionnaire for customers
     */
    public function displayQuestionnaire($token)
    {
        $PipelineItems = PipelineItems::where('token', $token)->get()->first();
        if ($PipelineItems) {
            if ($PipelineItems->tokenStatus == 'active') {
                $eQuestionnaireid = $PipelineItems->_id;
                $form_data = $PipelineItems['formData'];
//                $all_countries = AllCountries::first();
                $all_emirates = State::all();
                $all_insurers = Insurer::where('isActive', 1)->orderBy('name')->get();
                $country_name = [];
                $file_name = [];
                $file_url = [];
                $files = $PipelineItems['files'];
                foreach ($files as $file) {
                    $file_name[] = $file['file_name'];
                    $file_url[] = $file['url'];
                }
                $all_countries = CountryListModel::all();
                foreach ($all_countries as $key => $country) {
                    $name = $country['country'];
                    $country_name[] = $name['countryName'];
                }
                $customer_details = Customer::find($PipelineItems['customer']['id']);
                return view('sendQuestion')->with(compact('country_name', 'all_emirates', 'eQuestionnaireid', 'form_data', 'PipelineItems', 'customer_details', 'all_insurers', 'file_name', 'file_url'));
            } else {
                $refNumber = $PipelineItems->refereneceNumber;
                Session::flash('msg', 'You have already filled the E-questionnaire');
                Session::flash('refNo', $refNumber);
                return redirect('customer-notification');
            }
        } else {
            Session::flash('msg', 'Invalid link');
            return redirect('customer-notification');
        }
    }
    /**
     * Function for save the e questionnaire details
     */
    public function store(Request $request)
    {
        $status = 0;
        $id = $request->input('id');
        $pipeline = PipelineItems::where('_id', $id)->first();
        if ($pipeline->tokenStatus == "active") {
            if ($pipeline['workTypeId']['name'] == "Workman's Compensation") {
                PipelineController::equestionnaireSave($request);
            } elseif ($pipeline['workTypeId']['name'] == "Employers Liability") {
                EmployersController::eQuestionnaireSave($request);
            } elseif ($pipeline['workTypeId']['name'] == "Property") {
                PropertyController::equestionnaireSave($request);
            } elseif ($pipeline['workTypeId']['name'] == "Money") {
                MoneyController::equestionnaireSave($request);
            } elseif ($pipeline['workTypeId']['name'] == "Business Interruption") {
                BusinessController::equestionnaireSave($request);
            } elseif ($pipeline['workTypeId']['name'] == "Contractor`s Plant and Machinery") {
                ContractorPlantController::equestionnaireSave($request);
            } elseif ($pipeline['workTypeId']['name'] == "Fire and Perils") {
                FirePerilsController::equestionnaireSave($request);
            } elseif ($pipeline['workTypeId']['name'] == "Machinery Breakdown") {
                MachineryController::equestionnaireSave($request);
            }
            $refNumber = $pipeline->refereneceNumber;
            Session::flash('msg', 'You have successfully filled the e-questionnaire');
            Session::flash('refNo', $refNumber);
            $departments = $pipeline->getCustomer['departmentDetails'];
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
                $name = $pipeline->customer['name'];
                $email = $pipeline->getCustomer->email[0];
            }
            if (isset($email) && !empty($email)) {
                $type = $pipeline->workTypeId['name'];
                SendEquestionnaireCompleted::dispatch($email, $name, $refNumber, $type);
            }
            return "success";
        } else {
            $refNumber = $pipeline->refereneceNumber;
            Session::flash('msg', 'You have already filled the E-questionnaire');
            Session::flash('refNo', $refNumber);
            return 'success';
        }
    }

    /**
     * Function for display the notification page for customer
     */
    public function viewNotification()
    {
        return view('customer_notification');
    }

    /**
     * view e quoatation for customers
     */
    public function customerViewQuotation($pipeline_id)
    {
        $pipeline_details = PipelineItems::find($pipeline_id);
        if ($pipeline_details) {
            return view('forms.view_e_quotations')->with(compact('pipeline_details'));
        } else {
            Session::flash('msg', 'No Data Found');
            return redirect('customer-notification');
        }
    }

    /**
     * Function for display E comparison for customers
     */

    public function customerViewComparison($token)
    {
        $insures_details = [];
        $cnt = 0;
        $pipeline_details = PipelineItems::where('comparisonToken.token', $token)->first();
        if ($pipeline_details) {
            if ($pipeline_details['comparisonToken']['status'] == 'inactive') {
                Session::flash('msg', 'You have already completed the proposal');
                Session::flash('refNo', $pipeline_details->referenceNumber);
                return redirect('customer-notification');
            }
            if ($pipeline_details['comparisonToken']['viewStatus'] == 'Sent to customer') {
                PipelineItems::where('comparisonToken.token', $token)->update(array('comparisonToken.viewStatus' => 'Viewed by customer'));
            }
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
            return view('forms.customer_e_comparison')->with(compact('pipeline_details', 'insures_details', 'selectedId'));
        } else {
            return view('error');
        }
    }

    /**
     * Function for customer selection e comparison
     */
    public function decisionSave(Request $request)
    {
        try {
            $flag = 0;
            $id = $request->input('pipeline_id');
            //dd($id);
            $pipeline_details = PipelineItems::where('_id', $id)->first();
            if ($pipeline_details['comparisonToken']['status'] == 'active') {
                $workType = $pipeline_details->workTypeId['name'];

                PipelineItems::where('_id', $id)->update(array('comparisonToken.status' => 'inactive'));
                $update_token = $pipeline_details['comparisonToken']['token'];
                if ($pipeline_details['comparisonToken']['viewStatus'] == 'Viewed by customer') {
                    PipelineItems::where('comparisonToken.token', $update_token)->update(array('comparisonToken.viewStatus' => 'Responded by customer'));
                }
                $replies = $pipeline_details['insurerReplay'];
                foreach ($replies as $key => $reply) {
                    if ($reply['quoteStatus'] == "active") {
                        $unique_token = $reply['uniqueToken'];
                        if ($request->input($unique_token)) {
                            if ($request->input($unique_token) == "Approved") {
                                PipelineItems::where('_id', $id)->update(array('insurerReplay.' . $key . '.customerDecision.decision' => $request->input($unique_token), 'insurerReplay.' . $key . '.customerDecision.comment' => $request->input('text_' . $unique_token),
                                'insurerReplay.' . $key . '.customerDecision.rejctReason' => ''));
                            } else {
                                PipelineItems::where('_id', $id)->update(array('insurerReplay.' . $key . '.customerDecision.decision' => $request->input($unique_token), 'insurerReplay.' . $key . '.customerDecision.comment' => $request->input('text_' . $unique_token),
                                'insurerReplay.' . $key . '.customerDecision.rejctReason' => $request->input('reason_'.$unique_token)));
                            }
                            $decision = [];
                            $decision_object = new \stdClass();
                            $decision_object->decision = $request->input($unique_token);
                            $decision_object->comment = $request->input('text_' . $unique_token);
                            $decision[] = $decision_object;
                            PipelineItems::where('_id', $id)->push('insurerReplay.' . $key . '.previousDecision', $decision);
                            if ($request->input($unique_token) == "Approved") {
                                $flag = 1;
                                break;
                            }
                        }
                    }
                }
                if ($flag == 0) {
                    $pipeline_status = PipelineStatus::where('status', 'Quote Amendment')->first();
                    $status = 0;
                    $departments = $pipeline_details->getCustomer['departmentDetails'];
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
                            'status.UpdatedById' => new ObjectId($pipeline_details->getCustomer['_id']),
                            'status.UpdatedByName' => 'Customer (' . $pipeline_details->getCustomer['firstName'] . ')',
                            'status.date' => date('d/m/Y'));
                    }
                    PipelineItems::where('_id', $id)->update($status_array);
                    Session::flash('msg', "We have received your feedback on the proposal");
                    Session::flash('refNo', $pipeline_details->refereneceNumber);
                } else {
                    $pipeline_status = PipelineStatus::where('status', 'Approved E Quote')->first();
                    $status = 0;
                    $departments = $pipeline_details->getCustomer['departmentDetails'];
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
                            'status.UpdatedById' => new ObjectId($pipeline_details->getCustomer['_id']),
                            'status.UpdatedByName' => 'Customer (' . $pipeline_details->getCustomer['firstName'] . ')',
                            'status.date' => date('d/m/Y'));
                    }
                    PipelineItems::where('_id', $id)->update($status_array);
                    Session::flash('insurer', $reply['insurerDetails']['insurerName']);
                    // if($workType=='Employers Liability')
                    // {
                    //     Session::flash('msg', "You have approved the proposal for employers liability");
                    // }else if($workType=="Workman's Compensation"){
                    //     Session::flash('msg', "You have approved the proposal for workman's compensation");
                    // }
                    Session::flash('msg', "You have approved the proposal for " . $workType);
                    Session::flash('refNo', $pipeline_details->refereneceNumber);
                }
                $status = 0;
                $departments = $pipeline_details->getCustomer['departmentDetails'];
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
                    $updatedBy_obj->id = new ObjectID($pipeline_details->getCustomer['_id']);
                    $updatedBy_obj->name = 'Customer (' . $pipeline_details->getCustomer['firstName'] . ')';
                    $updatedBy_obj->date = date('d/m/Y');
                    $updatedBy_obj->action = "E comparison done";
                    $updatedBy[] = $updatedBy_obj;
                }
                PipelineItems::where('_id', $id)->push('updatedBy', $updatedBy);
                PipelineItems::where('_id', $id)->update(array('comparisonToken.status' => 'inactive'));
                return 'success';
            } else {
                Session::flash('msg', 'You have already responded to the request');
                return 'success';
            }
        } catch (\Exception $e) {
            return $e;
        }
    }

    /**
     * show response for ecompariosn
     */
    public function showResponse($token)
    {
        $pipeline_details = PipelineItems::where('comparisonToken.token', $token)->first();
        if (isset($pipeline_details->insurerResponse['mailStatus'])) {
            if ($pipeline_details->insurerResponse['mailStatus'] == 'active') {
                $insurerReplay = $pipeline_details['insurerReplay'];
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
                if ($workType == "Workman's Compensation") {
                    return view('forms.insurer_view_approval')->with(compact(
                        'pipelineId',
                        'pipeline_details',
                        'insures_details'
                    ));
                } elseif ($workType == 'Employers Liability') {
                    return view('forms.emp_liability.insurer_view_approval')->with(compact('pipelineId', 'pipeline_details', 'insures_details'));
                } elseif ($workType == 'Property') {
                    return view('forms.property.insurer_view_approval')->with(compact('pipelineId', 'pipeline_details', 'insures_details'));
                } elseif ($workType == 'Money') {
                    return view('pipelines.money.insurer_view_approval')->with(compact('pipelineId', 'pipeline_details', 'insures_details'));
                } elseif ($workType == 'Business Interruption') {
                    return view('pipelines.business.insurer_view_approval')->with(compact('pipelineId', 'pipeline_details', 'insures_details'));
                } elseif ($workType == 'Machinery Breakdown') {
                    return view('pipelines.machinery.insurer_view_approval')->with(compact('pipelineId', 'pipeline_details', 'insures_details'));
                } elseif ($workType == 'Fire and Perils') {
                    return view('pipelines.fire_perils.insurer_view_approval')->with(compact('pipelineId', 'pipeline_details', 'insures_details'));
                } elseif ($workType == "Contractor`s Plant and Machinery") {
                    return view('pipelines.plant_mach.insurer_view_approval')->with(compact('pipelineId', 'pipeline_details', 'insures_details'));
                }
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
        $id = $request->input('pipeline_id');
        // dd($id);
        $decision = $request->input('insurer_decision');
        $pipeline_details = PipelineItems::find($id);
        if ($pipeline_details->insurerResponse['mailStatus'] == 'active') {
            $insurerReplay = $pipeline_details['insurerReplay'];
            foreach ($insurerReplay as $insures_rep) {
                if (isset($insures_rep['customerDecision'])) {
                    if ($insures_rep['quoteStatus'] == 'active' && $insures_rep['customerDecision']['decision'] == 'Approved') {
                        $insures_details = $insures_rep;
                        break;
                    }
                }
            }
            if ($decision == 'approved') {
                PipelineItems::where('_id', $id)->update(array('insurerResponse.response' => 'approved', 'insurerResponse.mailStatus' => 'inactive'));
            } else {
                PipelineItems::where('_id', $id)->update(array('insurerResponse.response' => 'rejected', 'pipelineStatus' => 'true', 'insurerResponse.mailStatus' => 'inactive'));
            }
            $updatedBy_obj = new \stdClass();
            $updatedBy_obj->id = new ObjectID($insures_details['insurerDetails']['insurerId']);
            $updatedBy_obj->name = $insures_details['insurerDetails']['insurerName'];
            $updatedBy_obj->date = date('d/m/Y');
            $updatedBy_obj->action = "Responded for issuance";
            PipelineItems::where('_id', $id)->push('updatedBy', $updatedBy_obj);
            Session::flash('msg', 'You have successfully responded to the request');
            return redirect('customer-notification');
        } else {
            Session::flash('msg', 'You have already responded to the request');
            return redirect('customer-notification');
        }
    }
    public function test()
    {
        $numb = '10000';
        var_dump(str_replace(',', '', $numb));
//        $quots = PipelineItems::where('insuraceCompanyList.id','=',new ObjectId(Auth::user()->insurer['id']))->where('pipelineStatus',"true")->where('insuraceCompanyList', 'elemMatch', array('id' => new ObjectId(Auth::user()->insurer['id']), 'status' => 'inactive'))->get();
        //
        //        dd($quots);
        //        $string= '104.5';
        //        if($string>0 && $string<100)
        //        {
        //            echo "in";
        //        }
        //        else{
        //            echo "ok";
        //        }
        //            $percentage_match_admin_rate = preg_match("/[0-99]%/", $string);
        //
        //            if(preg_match("/^(100\.0000|[1-9]?\d\.\d{4})$/", $string))
        //        {
        //            echo "in";
        //        }else{
        //            echo "not in";
        //        }
        //        var_dump($percentage_match_admin_rate);
        //        die();
        //        $pipe = PipelineItems::where('status.id',new ObjectId("5b3de6eec38b5e2dc3ae7151"))->get();
        //        $status = array(
        //            'pipelineStatus' => 'false'
        //        );
        //        DB::collection('pipelineItems')->where('pipelineStatus', 'true')->update($status);
        //        $pipeline_details=PipelineItems::find('5b8a83bc6efda738540492f2');
        //        $insurerReplay=$pipeline_details['insurerReplay'];
        //        foreach ($insurerReplay as $insures_rep)
        //        {
        //            if($insures_rep['quoteStatus']=='active')
        //            {
        //                $insures_details[]=$insures_rep;
        //            }
        //        }
        //        return view('forms.e_comparison_pdf')->with(compact('pipeline_details','insures_details'));
        //        try
        //        {
        //            $result = PipelineItems::where('_id',"5b853ad3d4fdab1cfa3a46c1")
        //                ->where('insurerReplay.quoteStatus','active')
        //            ->where(
        //                'insurerReplay.insurerDetails.givenByName', 'AXA Admin'
        //            )->project(array( 'insurerReplay.$' => 1 ) )->first();
        //            $result = $result['insurerReplay'];
        //            dd($result[0]);
        //        }
        //        catch(\Exception $e) {
        //            echo $e;
        //        }
        //        $temp = EmployeeDetails::get();
        //        echo 'loading';
        //        foreach($temp as $emp)
        //        {
        //            $id = new ObjectId($emp->_id);
        //            $time = "".time()."";
        //            $time = substr($time, -5);
        //            $time = $time.rand(10000,99999);
        //            EmployeeDetails::where('_id',$id)->update(['uniqueCode'=>$time]);
        //            EmployeeDetails::where('_id',$id)->push('previousCodes',$time);
        //            sleep(2);
        //        }
        //         $employee = EmployeeDetails::where('position','Agent')->get();
        //         foreach($employee as $employees){
        //             $name=$employees->fullName;
        //             $code=$employees->empID;
        //             $id=new ObjectId($employees->_id);
        ////             $newagent=new Agent();
        ////             $newagent->name=$name;
        ////             $newagent->code=$code;
        ////             $newagent->id=$id;
        ////             $newagent->save();
        //             dd(agent::get());
        //         }
    }
}
