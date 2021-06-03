<?php
namespace App\Http\Controllers;

use App\CountryListModel;
use App\WorkTypeForms;
use App\WorkTypeData;
use App\ESlipFormData;
use App\PipelineStatus;
use MongoDB\BSON\ObjectID;
use App\Jobs\SendQuestionnaire;
use App\Jobs\SendEquestionnaireCompleted;
use App\State;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class EquestionareController extends Controller
{
    public function EQuestionnaire($Id) //call initial widgets page
    {
        //$work_type = WorkType::orderBy('name')->get();
        // $forms = IibWidgets :: where('worktypeId',new Object"5dc546b1354c1b14a15a9013")->where('stages.name','E Questionnaire')->first();
        // $Id =  new ObjectId($Id);
        $workTypeDataId = $Id;
        $formValues = WorkTypeData::where('_id', new ObjectId($Id))->first();
        $workTypeId = $formValues->workTypeId['id'];

        $forms = WorkTypeForms :: where("worktypeId", $workTypeId)->first();
        if($forms) {
            $data = $forms->stages['eQuestionnaire'];
        }

        $stage =  'eQuestionnaire';
        $title = 'E-Questionnaire';
        $values = [];
        if ($formValues && $forms) {
            $values = @$formValues->$stage?:[];
            return view('pages.eQuestionnaire')->with(compact('data', 'workTypeId', 'stage', 'values', 'workTypeDataId', 'formValues', 'title'));
        }
    }

    public function saveEQuestionnaireDraft(Request $request)
    {
        $formDataArr = json_decode($request->input('formDataArr'));
        $toalSteps = json_decode($request->input('toalSteps'));
        foreach ($formDataArr as $key => $formdata) {
            //$formdata['']
            $this->saveEachEQuestionnaireDraft($formdata);

        }



    }

    private function saveEachEQuestionnaireDraft($postData)
    {
        //$postData = $request->post();
        $fileData = [];
        if ($fileData) {
            $fileArr = [];
            if (count($fileData) !== 0) {
                foreach ($fileData['documents'] as $fieldLabel => $file) {
                    // There must be single file in each array
                    foreach ($file as $fieldName => $fileVal) {
                        $url = PipelineController::uploadToCloud($fileVal);
                        $fieldName = $fieldName;
                    }
                    $files = new \stdClass();
                    $files->url = $url;
                    $files->fieldName = $fieldName;
                    $files->file_name = $fieldLabel;
                    $files->upload_type = 'worktype';
                    $fileArr[] = $files;
                    $postData[$fieldName] = $files;
                }
                //$postData['documents'] = $fileArr;
            }
        }

        $workTypeId = $postData['workTypeId'];
        $workTypeDataId = $postData['workTypeDataId'];
        $stage = $postData['stage'];
        $step = $postData['step'];
        unset($postData['workTypeId']);
        unset($postData['findFieldTotal']);
        unset($postData['workTypeDataId']);
        unset($postData['stage']);
        unset($postData['step']);
        unset($postData['_token']);
        unset($postData['CFValueKey']);
        unset($postData['CFArrayKey']);
        unset($postData['type']);
        unset($postData['filler_type']);
        //Send files from filedata to s3 and add their links to formData here
        $workTypeData = WorkTypeData::where('_id', new ObjectId($workTypeDataId))->first();
        if (!$workTypeData) {
            $workTypeData = new WorkTypeData();
        }

        if (isset($workTypeData['eQuestionnaire']['businessDetails']['locationSum'])) {
            $locationSumArr = $workTypeData['eQuestionnaire']['businessDetails']['locationSum'];
        }
        // $workTypeData->workTypeId = new ObjectId($workTypeId);
        $arr = $workTypeData->$stage;
        if (isset($fileArr) && !empty($fileArr)) {
            $files = @$workTypeData->files ?: [];
            $workTypeData->files = array_merge($files, $fileArr);
        }
        $arr[$step] = $postData;
        $workTypeData->$stage = $arr;
        $workTypeData->save();
        if (isset($postData['output_url']) && $postData['output_url']) {
            $pipeline_details = WorkTypeData::find($workTypeDataId);
            $upload_url = @$postData['output_url'];
            $output_file = @$postData['output_file'];
            $upload_url_values =  explode(',', $upload_url);
            $output_file_values =  explode(',', $output_file);
            foreach ($upload_url_values as $url => $url_value) {
                $multi_files = new \stdClass();
                if ($output_file_values[$url] != '0') {
                    $multi_files->url = $upload_url_values[$url];
                    $multi_files->file_name = $output_file_values[$url];
                    $multi_files->upload_type = 'e_questionnaire_fancy';
                    $multi_file[] = $multi_files;
                }
            }
            $pipeline_details->push('files', $multi_file);
            $pipeline_details->save();
        }
        $pipline_status = PipelineStatus::where('status', 'E-slip')->first();
        if (Auth::user()) {
            $pipeline_status_object = new \stdClass();
            $pipeline_status_object->id = new ObjectID($pipline_status->_id);
            $pipeline_status_object->status = (string) $pipline_status->status;
            $pipeline_status_object->UpdatedById = new ObjectID(Auth::id());
            $pipeline_status_object->UpdatedByName = Auth::user()->name;
            $pipeline_status_object->date = date('d/m/Y');
            $workTypeData->status = $pipeline_status_object;
        } else {
            $pipeline_status_object = new \stdClass();
            $pipeline_status_object->id = new ObjectID($pipline_status->_id);
            $pipeline_status_object->status = (string) $pipline_status->status;
            $pipeline_status_object->UpdatedById = new ObjectID(@$workTypeData->getCustomer->_id);
            $pipeline_status_object->UpdatedByName = @$workTypeData->getCustomer->fullName;
            $pipeline_status_object->date = date('d/m/Y');
            $workTypeData->status = $pipeline_status_object;
        }
        $workTypeData->save();
        if (@$locationSumArr) {
            WorkTypeData::where('_id', new ObjectId($workTypeDataId))->update(['eQuestionnaire.businessDetails.locationSum' => $locationSumArr]);
        }
        if ($step == 'documents') {
            Session::flash('success', "Details Saved Successfully");
            return 'success';
        } else {
            Session::flash('success', "Details Drafted Successfully");
        }
    }



    public function saveEQuestionnaire(Request $request) //save fields into db
    {
        if ($request->input('type') == 'draft') {
            $postData = $request->post();
            $fileData = $request->file();
            if ($fileData) {
                $fileArr = [];
                if (count($fileData) !== 0) {
                    foreach ($fileData['documents'] as $fieldLabel => $file) {
                        // There must be single file in each array
                        foreach ($file as $fieldName => $fileVal) {
                            $url = PipelineController::uploadToCloud($fileVal);
                            $fieldName = $fieldName;
                        }
                        $files = new \stdClass();
                        $files->url = $url;
                        $files->fieldName = $fieldName;
                        $files->file_name = $fieldLabel;
                        $files->upload_type = 'worktype';
                        $fileArr[] = $files;
                        $postData[$fieldName] = $files;
                    }
                    //$postData['documents'] = $fileArr;
                }
            }

            $workTypeId = $postData['workTypeId'];
            $workTypeDataId = $postData['workTypeDataId'];
            $stage = $postData['stage'];
            $step = $postData['step'];
            unset($postData['workTypeId']);
            unset($postData['findFieldTotal']);
            unset($postData['workTypeDataId']);
            unset($postData['stage']);
            unset($postData['step']);
            unset($postData['_token']);
            unset($postData['CFValueKey']);
            unset($postData['CFArrayKey']);
            unset($postData['type']);
            unset($postData['filler_type']);
            //Send files from filedata to s3 and add their links to formData here
            $workTypeData = WorkTypeData::where('_id', new ObjectId($workTypeDataId))->first();
            if (!$workTypeData) {
                $workTypeData = new WorkTypeData();
            }

            if (isset($workTypeData['eQuestionnaire']['businessDetails']['locationSum'])) {
                $locationSumArr = $workTypeData['eQuestionnaire']['businessDetails']['locationSum'];
            }
            // $workTypeData->workTypeId = new ObjectId($workTypeId);
            $arr = $workTypeData->$stage;
            if (isset($fileArr) && !empty($fileArr)) {
                $files = @$workTypeData->files?:[];
                $workTypeData->files = array_merge($files, $fileArr);
            }
            $arr[$step] = $postData;
            $workTypeData->$stage = $arr;
            $workTypeData->save();
            if ($request->input('output_url')) {
                $pipeline_details=WorkTypeData::find($workTypeDataId);
                $upload_url=$request->input('output_url');
                $output_file=$request->input('output_file');
                $upload_url_values =  explode(',', $upload_url);
                $output_file_values =  explode(',', $output_file);
                foreach ($upload_url_values as $url => $url_value) {
                    $multi_files = new \stdClass();
                    if ($output_file_values[$url]!='0') {
                        $multi_files->url = $upload_url_values[$url];
                        $multi_files->file_name = $output_file_values[$url];
                        $multi_files->upload_type = 'e_questionnaire_fancy';
                        $multi_file[] = $multi_files;
                    }
                }
                $pipeline_details->push('files', $multi_file);
                $pipeline_details->save();
            }
            $pipline_status = PipelineStatus::where('status', 'E-slip')->first();
            if (Auth::user()) {
                $pipeline_status_object = new \stdClass();
                $pipeline_status_object->id = new ObjectID($pipline_status->_id);
                $pipeline_status_object->status = (string)$pipline_status->status;
                $pipeline_status_object->UpdatedById = new ObjectID(Auth::id());
                $pipeline_status_object->UpdatedByName = Auth::user()->name;
                $pipeline_status_object->date = date('d/m/Y');
                $workTypeData->status = $pipeline_status_object;
            } else {
                $pipeline_status_object = new \stdClass();
                $pipeline_status_object->id = new ObjectID($pipline_status->_id);
                $pipeline_status_object->status = (string)$pipline_status->status;
                $pipeline_status_object->UpdatedById = new ObjectID(@$workTypeData->getCustomer->_id);
                $pipeline_status_object->UpdatedByName = @$workTypeData->getCustomer->fullName;
                $pipeline_status_object->date = date('d/m/Y');
                $workTypeData->status = $pipeline_status_object;
            }
            $workTypeData->save();
            // if ($request->input('filler_type') != "fill_customer") {
            //     $updatedBy_obj = new \stdClass();
            //     $updatedBy_obj->id = new ObjectID(Auth::id());
            //     $updatedBy_obj->name = Auth::user()->name;
            //     $updatedBy_obj->date = date('d/m/Y');
            //     $updatedBy_obj->action = "E questionnaire saved as draft";
            //     $updatedByedit[] = $updatedBy_obj;
            //     WorkTypeData::where('_id', new ObjectId($workTypeDataId))->push('updatedBy', $updatedByedit);
            // } else {
            //     $status = 0;
            //     $questionnaire = $workTypeData;
            //     $departments = $questionnaire->getCustomer['departmentDetails'];
            //     if (isset($departments)) {
            //         foreach ($departments as $department) {
            //             if ($department['departmentName'] == 'Genaral & Marine') {
            //                 $questionnaire->filledBy = (String) "Genaral & Marine Department";
            //                 $updatedBy_obj = new \stdClass();
            //                 $updatedBy_obj->id = new ObjectID($department['department']);
            //                 $updatedBy_obj->name = 'Genaral & Marine (' . $department['depContactPerson'] . ')';
            //                 $updatedBy_obj->date = date('d/m/Y');
            //                 $updatedBy_obj->action = "E questionnaire saved as draft";
            //                 WorkTypeData::where('_id', new ObjectId($workTypeDataId))->push('updatedBy', $updatedBy_obj);
            //                 $status = 1;
            //                 break;
            //             }
            //         }
            //     }
            //     if ($status == 0) {
            //         $questionnaire->filledBy = (String) "Customer";
            //         $updatedBy_obj = new \stdClass();
            //         $updatedBy_obj->id = new ObjectID($questionnaire->getCustomer['_id']);
            //         $updatedBy_obj->name = 'Customer (' . $questionnaire->getCustomer['firstName'] . ')';
            //         $updatedBy_obj->date = date('d/m/Y');
            //         $updatedBy_obj->action = "E questionnaire saved as draft";
            //         WorkTypeData::where('_id', new ObjectId($workTypeDataId))->push('updatedBy', $updatedBy_obj);
            //     }
            // }
            // $workTypeData->save();
            if (@$locationSumArr) {
                WorkTypeData::where('_id', new ObjectId($workTypeDataId))->update(['eQuestionnaire.businessDetails.locationSum'=> $locationSumArr]);
            }
            if ($step == 'documents') {
                Session::flash('success', "Details Saved Successfully");
                return 'success';
            } else {
                Session::flash('success', "Details Drafted Successfully");
            }

        } else {
            $postData = $request->post();
            $fileData = $request->file();
            if ($fileData) {
                $fileArr = [];
                if (isset($fileData['documents']) && !empty($fileData['documents'])) {
                    foreach ($fileData['documents'] as $fieldLabel => $file) {
                        // There must be single file in each array
                        foreach ($file as $fieldName => $fileVal) {
                            $url = PipelineController::uploadToCloud($fileVal);
                            $fieldName = $fieldName;
                        }
                        $files = new \stdClass();
                        $files->url = $url;
                        $files->fieldName = $fieldName;
                        $files->file_name = $fieldLabel;
                        $files->upload_type = 'worktype';
                        $fileArr[] = $files;
                        $postData[$fieldName] = $files;
                    }
                    //$postData['documents'] = $fileArr;
                } else {
                    foreach ($fileData as $fieldLabel => $file) {
                        // There must be single file in each array
                        foreach ($file as $fieldName => $fileVal) {
                            $url = PipelineController::uploadToCloud($fileVal);
                            $fieldName = $fieldName;
                        }
                        $files = new \stdClass();
                        $files->url = $url;
                        $files->fieldName = $fieldName;
                        $files->file_name = $fieldLabel;
                        $files->upload_type = 'worktype';
                        $fileArr[] = $files;
                        $postData[$fieldLabel][$fieldName] = $files;
                        //$postData[] = $arr;
                    }

                }
            }
            $workTypeId = $postData['workTypeId'];
            $workTypeDataId = $postData['workTypeDataId'];
            $stage = $postData['stage'];
            $step = $postData['step'];
            unset($postData['workTypeId']);
            unset($postData['workTypeDataId']);
            unset($postData['stage']);
            unset($postData['findFieldTotal']);
            unset($postData['step']);
            unset($postData['CFValueKey']);
            unset($postData['CFArrayKey']);
            unset($postData['_token']);
            unset($postData['filler_type']);
            //Send files from filedata to s3 and add their links to formData here
            $workTypeData = WorkTypeData::where('_id', new ObjectId($workTypeDataId))->first();
            if (!$workTypeData) {
                $workTypeData = new WorkTypeData();
            }
            if (isset($workTypeData['eQuestionnaire']['businessDetails']['locationSum'])) {
                $locationSumArr = $workTypeData['eQuestionnaire']['businessDetails']['locationSum'];
            }
            // $workTypeData->workTypeId = new ObjectId($workTypeId);
            $arr = $workTypeData->$stage;
            if (isset($fileArr) && !empty($fileArr)) {
                $files = @$workTypeData->files?:[];
                $workTypeData->files = array_merge($files, $fileArr);
            }
            $arr[$step] = $postData;
            $workTypeData->$stage = $arr;
            if ($request->input('complete_status')) {
                $workTypeData->eQuestinareStatus = true;
            }
            $workTypeData->save();

            if ($request->input('output_url')) {
                $pipeline_details=WorkTypeData::find($workTypeDataId);
                $upload_url=$request->input('output_url');
                $output_file=$request->input('output_file');
                $upload_url_values =  explode(',', $upload_url);
                $output_file_values =  explode(',', $output_file);
                foreach ($upload_url_values as $url => $url_value) {
                    $multi_file = new \stdClass();
                    if ($output_file_values[$url]!='0') {
                        $multi_file->url = $upload_url_values[$url];
                        $multi_file->file_name = $output_file_values[$url];
                        $multi_file->upload_type = 'e_questionnaire_fancy';
                        $multi_files[] = $multi_file;
                    }
                }
                if (!empty($multi_files)) {
                    $prevFiles = @$pipeline_details->files?:[];
                    $pipeline_details->files = array_merge($prevFiles, $multi_files);
                }
                //$pipeline_details->files = $multi_file;
                $pipeline_details->save();
            }
            /**
             * @todo after customer save status set change the name and id accordingly
             */

            if (Auth::user()) {
                $updatedBy_obj = new \stdClass();
                $updatedBy_obj->id = new ObjectID(Auth::id());
                $updatedBy_obj->name = Auth::user()->name;
                $updatedBy_obj->date = date('d/m/Y');
                $updatedBy_obj->action = "E questionnaire Filled";
                $updatedBy[] = $updatedBy_obj;
            }

            if ($workTypeData['status']['status'] == 'Worktype Created' || $workTypeData['status']['status'] == 'E-questionnaire') {
                $pipline_status = PipelineStatus::where('status', 'E-slip')->first();
                if (Auth::user()) {
                    $pipeline_status_object = new \stdClass();
                    $pipeline_status_object->id = new ObjectID($pipline_status->_id);
                    $pipeline_status_object->status = (string)$pipline_status->status;
                    $pipeline_status_object->UpdatedById = new ObjectID(Auth::id());
                    $pipeline_status_object->UpdatedByName = Auth::user()->name;
                    $pipeline_status_object->date = date('d/m/Y');
                    $workTypeData->status = $pipeline_status_object;
                } else {
                    $pipeline_status_object = new \stdClass();
                    $pipeline_status_object->id = new ObjectID($pipline_status->_id);
                    $pipeline_status_object->status = (string)$pipline_status->status;
                    $pipeline_status_object->UpdatedById = new ObjectID(@$workTypeData->getCustomer->_id);
                    $pipeline_status_object->UpdatedByName = @$workTypeData->getCustomer->fullName;
                    $pipeline_status_object->date = date('d/m/Y');
                    $workTypeData->status = $pipeline_status_object;
                }

            }
            $workTypeData->save();
            if (Auth::user()) {
                WorkTypeData::where('_id', new ObjectId($workTypeData->_id))->push('updatedBy', $updatedBy);
            }

            if ($request->input('filler_type') == "fill_customer" && (isset($workTypeData['eQuestinareStatus']) && $workTypeData['eQuestinareStatus'] )) {
                $status = 0;
                $refNumber = $workTypeData->refereneceNumber;
                $departments = $workTypeData->getCustomer['departmentDetails'];
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
                    $name = $workTypeData->customer['name'];
                    $email = $workTypeData->getCustomer->email[0];
                    $refNumber = $workTypeData->refereneceNumber;
                }
                if (isset($email) && !empty($email)) {
                    $type = $workTypeData->workTypeId['name'];
                    SendEquestionnaireCompleted::dispatch($email, $name, $refNumber, $type);
                }
            }

            $displaySteps = ['basicDetails' => 'Basic Details', 'businessDetails' => 'Business Details', 'policyDetails' => 'Policy Details', 'locationDetails' => 'Location details'];
            $stepToDisplay = @$displaySteps[$step]?:$step;
            Session::flash('success', "$stepToDisplay  Saved Successfully");
            if (@$locationSumArr) {
                WorkTypeData::where('_id', new ObjectId($workTypeDataId))->update(['eQuestionnaire.businessDetails.locationSum'=> $locationSumArr]);
            }
            return 'success';
        }
    }



    /**
     * Function to save multiple documents
     */
    public function saveMultiDocuments(Request $request)
    {
        $WorkTypeDataId = $request->get('workTypeDataId');
        $Work_type_data = WorkTypeData::find($WorkTypeDataId);
        $output_url=explode(',', $request->get('output_url'));
        $output_file=explode(',', $request->get('output_file'));
        $fieldName=explode(',', $request->get('arrayIndex'));
        $keyIndex = @$Work_type_data['eQuestionnaire'];
        // for ($i=0; $i < count($fieldName); $i++) {
        //     if (@$keyIndex[$fieldName[$i]] != '') {
        //         $keyIndex  = @$keyIndex[$fieldName[$i]];
        //     } else {
        //         $keyIndex  = [];
        //     }

        // }
        foreach ($output_url as $key => $value) {
            $multi_file = new \stdClass();
            if ($value != '') {
                $multi_file->url = $value;
                $multi_file->file_name = $output_file[$key];
                $multi_file->upload_type = last($fieldName);
                $multi_files[] = $multi_file;
            }
        }
        if (!empty($multi_files)) {
            $prevFiles = @$Work_type_data->files?:[];
            $Work_type_data->files = array_merge($prevFiles, $multi_files);
        }
        //$pipeline_details->files = $multi_file;
        $Work_type_data->save();
        // if (!empty($multi_files)) {
        //     $prevFiles = array_merge(@$keyIndex, $multi_files);

        // }
        // if (!empty($prevFiles)) {
        //     $fieldName=implode('.', $fieldName);
        //     WorkTypeData::where('_id', new ObjectId($WorkTypeDataId))->update(["eQuestionnaire.$fieldName"=> $prevFiles]);
        // }
        return 'success';
    }

    /**
     * Function to load all file in e-questinare files for attach with email
     */
    public function equestionnaireFiles(Request $request)
    {
        try {
            $WorkTypeDataId = $request->get('id');
            $Work_type_data = WorkTypeData::find($WorkTypeDataId);
            $data = [];
            if(isset($Work_type_data->files)) {
                $files = $Work_type_data->files;
                foreach ($files as $file) {
                    if ($file['url'] != "") {
                        $file_data = new \stdClass();
                        $file_data->filename = $file['file_name'];
                        $file_data->url = $file['url'];
                        $data[] = $file_data;
                    }
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
     * Function for send to customers
     */
    public function sendQuestionnaireEmail(Request $request)
    {
        $to_email = $request->input('to_email');
        $cc_email = $request->input('cc_email');
        $cc_email = array_filter($cc_email);
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
        if (isset($to_email) && !empty($to_email)) {
            $email = $to_email;
        }
        $pipeLine->token = $token;
        $pipeLine->tokenStatus = 'active';
        $pipeLine->save();
        $link = url('/customer-equestionnaire/' . $token);
        $workType = $pipeLine->workTypeId['name'];
        if (isset($email)&& !empty($email)) {
            SendQuestionnaire::dispatch($email, $name, $link, $workType, $files, $comment, @$cc_email);
        } else {
            return 'failed';
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
        if (!empty($cc_email)) {
            $mssg = 'E-questionnaire has been sent to ' . $email . ','.implode(", ", $cc_email);
        } else {
            $mssg = 'E-questionnaire has been sent to ' . $email;
        }
        return $mssg;
    }

    /**
     * Function for display e questionnaire for customers
     */
    public function displayEQuestionnaire($token)
    {
        $formValues = WorkTypeData::where('token', $token)->get()->first();
        $values = [];
        if ($formValues) {
            $workTypeDataId = $formValues->_id;
            $workTypeId = $formValues->workTypeId['id'];
            $forms = WorkTypeForms :: where("worktypeId", $workTypeId)->first();
            $data = $forms->stages['eQuestionnaire'];
            $stage =  'eQuestionnaire';
            $title = 'E-Questionnaire';
            $values = @$formValues->$stage?:[];
        }
        if ($formValues) {
            if ($formValues->tokenStatus == 'active') {
                $eQuestionnaireid = $formValues->_id;
                $form_data = $formValues['formData'];
                return view('layouts.customer_equestionare')->with(compact('data', 'workTypeId', 'stage', 'values', 'workTypeDataId', 'formValues', 'title'));
            } else {
                $refNumber = $formValues->refereneceNumber;
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
     * Function for display the notification page for customer
     */
    public function viewNotification($Id)
    {
        $formValues = WorkTypeData::find($Id);
        $refNumber = $formValues->refereneceNumber;
        $formValues->tokenStatus = 'inactive';
        $formValues->save();
        Session::flash('msg', 'You have successfully filled the e-questionnaire');
        Session::flash('refNo', $refNumber);
        return view('customer_notification');
    }
    /***
     * Get emirates from country
     */
    public function getCountryEmirates(Request $request)
    {
        try {
            $country_name = @$request->input('country_name');
            if ($country_name) {
                $country = CountryListModel::where('country.countryName', $country_name)->first();
            }
            $state=[];
            foreach ($country->country['states'] as $states) {
                $state[] = $states['StateName'];
            }
            return response()->json(['status'=>'success', 'state'=>$state]);
        } catch (\Throwable $th) {
            return response()->json(['status'=>'failed']);
        }
    }

    /***
     * Get emirates from country
     */
    public function getLocationForm(Request $request)
    {

        $Id = $request->input('workTypeId');
        $workTypeDataId = $Id;
        $CFArrayKey = $request->input('arrayKey');
        $formValues = WorkTypeData::where('_id', new ObjectId($Id))->first();
        $workTypeId = $formValues->workTypeId['id'];

        $forms = WorkTypeForms :: where("worktypeId", $workTypeId)->first();
        if ($forms) {
            $data = $forms->stages['eQuestionnaire']['steps'][$CFArrayKey];
        }

        $stage =  'eQuestionnaire';
        $title = 'E-Questionnaire';
        $values = [];
        if ($formValues && $forms) {
            $values = isset($formValues->$stage)?$formValues->$stage:[];
            return view('pages.eQ_multiLocForm')->with(compact('data', 'workTypeId', 'stage', 'values', 'workTypeDataId', 'formValues', 'title', 'CFArrayKey'));
        }
    }

    /***
     * Get emirates from country
     */
    public function getSingleLocationForm(Request $request)
    {
        //$work_type = WorkType::orderBy('name')->get();
        // $forms = IibWidgets :: where('worktypeId',new Object"5dc546b1354c1b14a15a9013")->where('stages.name','E Questionnaire')->first();
        // $Id =  new ObjectId($Id);
        $Id = $request->input('workTypeId');
        $workTypeDataId = $Id;
        //current form value key incase of a multiple form
        $CFValueKey = $request->input('valueKey');
        $CFArrayKey = $request->input('arrVal');
        $formValues = WorkTypeData::where('_id', new ObjectId($Id))->first();
        $workTypeId = $formValues->workTypeId['id'];
        $forms = WorkTypeForms :: where("worktypeId", $workTypeId)->first();
        if ($forms) {
            $data = $forms->stages['eQuestionnaire']['steps'][$CFArrayKey];
        } 
        $stage =  'eQuestionnaire';
        $title = 'E-Questionnaire';
        $values = [];
        $frm=$forms->stages['eQuestionnaire']['steps'][$CFArrayKey]['rows'];
        $i=0;
        if ($frm && $forms) {
            foreach($frm as $form){
                $frmm=$form["fields"];
                foreach($frmm as $formm){
                    if($formm["widgetType"]=="RadioButton")
                    {
                        $fval[$i]=$formm["config"]["id"] ;
                        $i++;
                    }
                }
            }
        }
        if ($formValues && $forms ) {            
            $values = @$formValues['eQuestionnaire'][$CFArrayKey][$CFValueKey]?:[];             
            if ($request->has('eslip') && $request->input('eslip') == 1) {
                $values = @$formValues['eQuestionnaire'][$CFArrayKey][$CFValueKey]?:[];
                if(@$fval){
                    foreach($fval as $fo){
                        $vall= @$values[$fo];            
                        $fom=$fo."Yes";            
                        $fon=$fo."No";            
                        if($vall=="Yes"||$vall==$fom){
                                    $values[$fo]  ="Yes";
                        }else
                        if($vall=="No"||$vall==$fon){
                                    $values[$fo]  ="No";
                        }            
                    }
                }
           
                return view('pages.eslip_multiLocForm')->with(compact('data', 'values'));
            } else {
                return view('pages.eQ_multiLocForm')->with(compact('data', 'workTypeId', 'stage', 'CFValueKey', 'CFArrayKey', 'values', 'workTypeDataId', 'formValues', 'title'));
            }

        }
    }

    /**
     * delete single entry of multiple form data
     */
    public function deleteSingleLocationForm(Request $request)
    {
        try {

            $worktypeDataId = $request->input('worktypeData');
            $keyName = $request->input('keyName');
            $keyValue = $request->input('keyValue');
            $formValues = WorkTypeData::where('_id', new ObjectId($worktypeDataId))->first();
            if (isset($formValues->eQuestionnaire[$keyName])) {
                $mDetailsForm = $formValues->eQuestionnaire[$keyName];
                foreach ($formValues->eQuestionnaire[$keyName] as $key => $mlDet) {
                    if ($key == @$keyValue) {
                        if (isset($formValues->eQuestionnaire['businessDetails']['locationSum']) && !empty(@$formValues->eQuestionnaire['businessDetails']['locationSum'])) {
                            $locSumArr = $formValues->eQuestionnaire['businessDetails']['locationSum'];
                            foreach ($formValues->eQuestionnaire['businessDetails']['locationSum'] as $locLabel =>$locValue) {
                                $locSumArr[$locLabel] -=$mlDet[$locLabel];
                            }
                            WorkTypeData::where('_id', new ObjectId($worktypeDataId))->update(['eQuestionnaire.businessDetails.locationSum'=> $locSumArr]);
                        }
                        unset($mDetailsForm[$keyValue]);
                    }
                }
                WorkTypeData::where('_id', new ObjectId($worktypeDataId))->update(["eQuestionnaire.$keyName"=> $mDetailsForm]);
            }
            $formValues->refresh();
            return 'success';
        } catch (\Throwable $th) {
            // dd($th->getMessage());
            return 'failed';
        }
    }

    public function saveEQuestionnaireMD(Request $request)
    {

        $CFValueKey = $request->input('CFValueKey');
        $CFArrayKey = $request->input('CFArrayKey');
        $postData = $request->post();
        $findFieldTotal = $postData['findFieldTotal'];
        $totalFieldArr = json_decode(base64_decode($findFieldTotal));
        $workTypeId = $postData['workTypeId'];
        $workTypeDataId = $postData['workTypeDataId'];
        $stage = $postData['stage'];
        $step = $postData['step'];
        unset($postData['workTypeId']);
        unset($postData['workTypeDataId']);
        unset($postData['stage']);
        unset($postData['findFieldTotal']);
        unset($postData['step']);
        unset($postData['CFValueKey']);
        unset($postData['CFArrayKey']);
        unset($postData['filler_type']);
        unset($postData['_token']);
        //Send files from filedata to s3 and add their links to formData here
        $workTypeData = WorkTypeData::where('_id', new ObjectId($workTypeDataId))->first();

        if (!$workTypeData) {
            $workTypeData = new WorkTypeData();
        }

        if (isset($CFValueKey)) {
            WorkTypeData::where('_id', new ObjectId($workTypeDataId))->update(["eQuestionnaire.$CFArrayKey.$CFValueKey"=> $postData]);
        } else {
            if (!empty(@$workTypeData['eQuestionnaire'][$CFArrayKey])) {
                $multiFormDetails = @$workTypeData['eQuestionnaire'][$CFArrayKey];
            }
            if ($postData) {
                $notNull = 0;
                foreach ($postData as $keyVal =>$valData) {
                    if ($valData) {
                        $notNull++;
                    }
                }
                if ($notNull != 0) {
                    $multiFormDetails[] = $postData;
                }
            }
            if(isset($multiFormDetails) && !empty($multiFormDetails)) {
                WorkTypeData::where('_id', new ObjectId($workTypeDataId))->update(["eQuestionnaire.$CFArrayKey"=> $multiFormDetails]);
            }

        }
        $workTypeData->refresh();
        $locationSumArr = [];
        if (isset($totalFieldArr) && !empty($totalFieldArr)) {
            foreach ($totalFieldArr as $totalfieldName) {
                $totalSum = 0;
                if (isset($CFArrayKey) && isset($workTypeData['eQuestionnaire'][$CFArrayKey])) {
                    foreach ($workTypeData['eQuestionnaire'][$CFArrayKey] as $multiFFields) {
                        foreach ($multiFFields as $fieldsLabel => $fieldsValue) {
                            if ($totalfieldName == $fieldsLabel) {

                                $totalSum += intval(str_replace(',', '', $fieldsValue));
                            }
                        }
                    }
                }
                $locationSumArr[$totalfieldName] = @$totalSum;
            }
            WorkTypeData::where('_id', new ObjectId($workTypeDataId))->update(['eQuestionnaire.businessDetails.locationSum'=> $locationSumArr]);
            $workTypeData->refresh();
        }
        return 'success';
    }


    /**
     * GET FILE DETAILS FOR FILE UPLOAD BOX
     */
    public function getFiles(Request $request)
    {
        $id = $request->get('pipeline_id');
        $multi = 0;
        if ($request->get('multi')) {
            $multi = 1;
        }
        $pipeline_details = WorkTypeData::find($id);
        $data = [];
        $files = $pipeline_details->files;
        if ($files) {
            foreach ($files as $file) {
                if ($multi == 1) {
                    if ($file['url'] != "" && $file['upload_type'] == 'e_questionnaire_fancy') {
                        $file_data = new \stdClass();
                        $file_data->filename = $file['file_name'];
                        $file_data->url = $file['url'];
                        $data[] = $file_data;
                    }
                } else {
                    if ($file['url'] != "") {
                        $file_data = new \stdClass();
                        $file_data->filename = $file['file_name'];
                        $file_data->url = $file['url'];
                        $data[] = $file_data;
                    }
                }

            }
        }
        return json_encode($data);
    }

    /**
     * save field onchange of eslip
     */
    public function equestionareFieldSave(Request $request)
    {
        $worktypeDataId = $request->input('workTypeDataId');
        $saveFields = $request->input('saveFields');
        $elemValue = $request->input('elemValue');
        $formValues = WorkTypeData::where('_id', new ObjectId($worktypeDataId))->first();
        if (!empty($formValues)) {
            WorkTypeData::where('_id', new ObjectId($worktypeDataId))->update(["eQuestionnaire.$saveFields"=> $elemValue]);
        }
        $formValues->refresh();
    }

}
