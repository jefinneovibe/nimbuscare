<?php

namespace App\Http\Controllers;

use App\ESlipFormData;
use Illuminate\Http\Request;
use App\WorkTypeForms;
use App\WorkTypeData;
use App\Insurer;
use App\User;
use App\ImportExcel;
use Maatwebsite\Excel\Facades\Excel;
use App\Jobs\EslipSubmittedReminder;
use stdClass;
use MongoDB\BSON\ObjectID;
use Illuminate\Support\Facades\DB;
use App\PipelineStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
class EslipController extends Controller
{
    public function getEslip($Id)
    {

        $workTypeDataId = $Id;
        // $values = WorkTypeData::where('_id', new ObjectId($Id))->first();
        // $workTypeId = $values->workTypeId['id'];
        // $forms = WorkTypeForms :: where("worktypeId", $workTypeId)->first();
        // $data = $forms->stages['eSlip'];
        // $stage =  'eSlip';
        // $formValues = [];
        // if ($values) {
        //     $formValues = @$values[$stage]?:[];
        // }
        $formValues = WorkTypeData::where('_id', new ObjectId($Id))->first();
        // dd($formValues);
        $workTypeId = $formValues->workTypeId['id'];
        $forms = WorkTypeForms :: where("worktypeId", $workTypeId)->first();
        $data = $forms->stages['eSlip'];
        $stage =  'eSlip';
        $title =  'E-Slip';
        $values = [];
        if ($formValues) {
            $values = @$formValues[$stage]?:[];
        }
        $reviewData = @$data['steps']['review']?:[];
        $formData = @$data['steps']['forms']?:[];
        $step = 'forms';
        //for modal
        $company_id = [];
        // $insurer_list = Insurer::where('isActive', 1)->orderBy('name')->get();
        $insurer_list = Insurer::where('isActive', 1)->get()->sortBy('name', SORT_NATURAL|SORT_FLAG_CASE);
        //$eslip_details = ESlipFormData::where('workTypeDataId', new ObjectId($workTypeDataId))->first();
        if ($formValues) {
            $insurence_company = $formValues->insurerList?:null;
            if ($insurence_company) {
                foreach ($insurence_company as $company) {
                    if (!empty($company)) {
                        $company_id[]=$company['id'];
                    }
                }
            } else {
                $company_id = [];
            }
        }
        //attached documents
        $workTypeDataDetails = WorkTypeData::find($workTypeDataId);
        $documents = [];
        $files = $workTypeDataDetails->files;
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
        return view('pages.eslip')->with(compact('reviewData', 'formData', 'workTypeId', 'stage', 'values', 'formValues', 'step', 'workTypeDataId', 'title', 'insurer_list', 'company_id', 'documents'));

    }
    public function saveESlip(Request $request) //save fields into db
    {

        $postData = $request->post();
        $fileData = $request->file();
        $workTypeId = $postData['workTypeId'];
        $workTypeDataId = $postData['workTypeDataId'];
        $stage = $postData['stage'];
        $step = $postData['step'];
        $array1 = $postData['reviewArr'];
        $reviewArr = json_decode(base64_decode($array1));
        $array2 = $postData['formArr'];
        $formArr = json_decode(base64_decode($array2));

        //Send files from filedata to s3 and add their links to formData here
        $workTypeData = WorkTypeData::where('_id', new ObjectId($workTypeDataId))->first();
        $formValues = $workTypeData;
        if (!$workTypeData) {
            $workTypeData = new WorkTypeData();
        }
        $arr = $workTypeData->$stage;
        $arr[$step] = $postData;
        $fileUploaded = [];
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
                    $fileUploaded[$fieldName] = $files;
                    @$arr['forms'][$fieldName] = $files;
                }
                //$postData['documents'] = $fileArr;
            }
        }
        if (!empty($fileUploaded)) {
            $prevFiles = @$workTypeData->files?:[];
            $workTypeData->files = array_merge($prevFiles, $fileUploaded);
        }
        $workTypeData->$stage = $arr;
        $workTypeData->save();
        $workTypeData->refresh();
        $eSlipFormDataNew = $workTypeData['eSlip']['forms'];
        foreach ($formArr as $key => $val) {
            if (@$eSlipFormDataNew[$val->fieldName]) {
                $val->value = $eSlipFormDataNew[$val->fieldName];
                $formArr[$key] = $val;
            }
        }
        $arr['review'] = $reviewArr;
        $arr['forms'] = $formArr;
        $review_array = [];
        foreach ($arr['forms'] as $keyForm => $form) {
            if (isset($form->isLocationRelated) && $form->isLocationRelated) {
                @eval("\$viewItm = \"{$form->locationCheckValue}\";");
                if (in_array($viewItm, $form->locationMatchValue)) {
                    if (isset($form->isBusinessRelated) && $form->isBusinessRelated === true) {
                        if (count($form->relatedBusiness) > 0) {
                            if (in_array(@$workTypeData['eQuestionnaire']['businessDetails']['businessType']['optionId'], $form->relatedBusiness)) {
                                if ($form->type == 'checkbox' || $form->type == 'select' || $form->type ==  'RadioButton') {
                                    if (@$form->value == '' ) {
                                        unset($arr['forms'][$keyForm]);
                                    }
                                    if (@$form->value == 'no'|| @$form->value == 'No'|| @$form->value == null) {
                                        unset($arr['forms'][$keyForm]);
                                        // dd($arr['forms'][$keyForm]);
                                    }
                                    if (gettype(@$form->value) == 'array' && !empty(@$form->value) && !isset($form->value['isChecked'])) {
                                        $indexArray =array_values($form->value);
                                        if (strtolower(@$indexArray[0]) != 'yes' || @$indexArray[0] ==null) {
                                            unset($arr['forms'][$keyForm]);
                                        }
                                    }
                                    if (isset($form->value['isChecked']) && $form->value['isChecked'] != '') {
                                        if (strtolower(@$form->value['isChecked']) != 'yes' || @$form->value['isChecked'] == null) {
                                            unset($arr['forms'][$keyForm]);
                                        }
                                    }
                                } elseif ($form->type ==  'RadioWithChildren') {
                                    if (isset($form->value)) {
                                        $i = 0;
                                        foreach ($form->value as $key =>$value) {
                                            if ($i == 0) {
                                                if ($form->value[$key] != 'Yes' || $form->value[$key] != 'yes' || $form->value[$key] == null ) {
                                                    unset($arr['forms'][$keyForm]);
                                                }
                                            }
                                            $i++;
                                        }
                                    }
                                }
                            } else {
                                unset($arr['forms'][$keyForm]);
                            }
                        }
                    } elseif (isset($form->isWidgetRelated) && $form->isWidgetRelated === true) {
                        eval("\$str123 = \"{$form->checkValue}\";");
                        if (count($str123) > 0) {
                            if (in_array(@$str123, $form->matchValue)) {
                                if ($form->type == 'checkbox' || $form->type == 'select' || $form->type ==  'RadioButton') {
                                    if (@$form->value == '') {
                                        unset($arr['forms'][$keyForm]);
                                    }
                                    if (@$form->value == 'no'|| @$form->value == 'No'|| @$form->value == null) {
                                        unset($arr['forms'][$keyForm]);
                                        // dd($arr['forms'][$keyForm]);
                                    }
                                    if (gettype(@$form->value) == 'array' && !empty(@$form->value) && !isset($form->value['isChecked'])) {
                                        $indexArray =array_values($form->value);
                                        if (strtolower(@$indexArray[0]) != 'yes' || @$indexArray[0] == null) {
                                            unset($arr['forms'][$keyForm]);
                                        }
                                    }
                                    if (isset($form->value['isChecked']) && $form->value['isChecked'] != '') {
                                        if (strtolower(@$form->value['isChecked']) != 'yes' || @$form->value['isChecked'] == null) {
                                            unset($arr['forms'][$keyForm]);
                                        }
                                    }
                                } elseif ($form->type ==  'RadioWithChildren') {
                                    if (isset($form->value)) {
                                        $i = 0;
                                        foreach ($form->value as $key =>$value) {
                                            if ($i == 0) {
                                                if (strtolower($form->value[$key]) != 'yes' || $form->value[$key] == null) {
                                                    unset($arr['forms'][$keyForm]);
                                                }
                                            }
                                            $i++;
                                        }
                                    }
                                }
                            } else {
                                unset($arr['forms'][$keyForm]);
                            }
                        }
                    } else {
                        if ($form->type == 'checkbox' || $form->type == 'select') {
                            if (@$form->value == '') {
                                unset($arr['forms'][$keyForm]);
                            }
                            if (@$form->value == 'no'|| @$form->value == 'No'|| @$form->value == null) {
                                unset($arr['forms'][$keyForm]);
                                // dd($arr['forms'][$keyForm]);
                            }
                            if (gettype(@$form->value) == 'array' && !empty(@$form->value) && !isset($form->value['isChecked'])) {
                                $indexArray =array_values($form->value);
                                if (strtolower(@$indexArray[0]) != 'yes' || @$indexArray[0] == null) {
                                    unset($arr['forms'][$keyForm]);
                                }
                            }
                            if (@$form->value['isChecked']) {
                                if (strtolower(@$form->value['isChecked']) != 'yes' || @$form->value['isChecked'] == null) {
                                    unset($arr['forms'][$keyForm]);
                                }
                            } else {
                                unset($arr['forms'][$keyForm]);
                            }
                        } elseif ($form->type ==  'RadioWithChildren') {
                            if (isset($form->value)) {

                                $i = 0;
                                foreach ($form->value as $key =>$value) {
                                    if ($i == 0) {
                                        if (strtolower($form->value[$key]) != 'yes' || $form->value[$key] == null) {
                                            unset($arr['forms'][$keyForm]);
                                        }
                                    }
                                    $i++;
                                }
                            }
                        } elseif ($form->type ==  'RadioButton') {
                            if (@$form->value == '') {
                                unset($arr['forms'][$keyForm]);
                            }
                            if (@$form->value == 'no'|| @$form->value == 'No'|| @$form->value == null) {
                                unset($arr['forms'][$keyForm]);
                                // dd($arr['forms'][$keyForm]);
                            }
                            if (gettype(@$form->value) == 'array' && !empty(@$form->value) && !isset($form->value['isChecked'])) {
                                $indexArray =array_values($form->value);
                                if (strtolower(@$indexArray[0]) != 'yes' || @$indexArray[0] == null) {
                                    unset($arr['forms'][$keyForm]);
                                }
                            }
                            if (isset($form->value['isChecked']) && $form->value['isChecked'] != '') {
                                if (strtolower(@$form->value['isChecked']) != 'yes' || @$form->value['isChecked'] == null) {
                                    unset($arr['forms'][$keyForm]);
                                }
                            }
                        }
                    }
                }
            } else {
                if (isset($form->isBusinessRelated) && $form->isBusinessRelated === true) {
                    if (count($form->relatedBusiness) > 0) {
                        if (in_array(@$workTypeData['eQuestionnaire']['businessDetails']['businessType']['optionId'], $form->relatedBusiness)) {
                            if ($form->type == 'checkbox' || $form->type == 'select' || $form->type ==  'RadioButton') {
                                if (@$form->value == '' ) {
                                    unset($arr['forms'][$keyForm]);
                                }
                                if (@$form->value == 'no'|| @$form->value == 'No' || @$form->value == null ) {
                                    unset($arr['forms'][$keyForm]);
                                    // dd($arr['forms'][$keyForm]);
                                }
                                if (gettype(@$form->value) == 'array' && !empty(@$form->value) && !isset($form->value['isChecked'])) {
                                    $indexArray =array_values($form->value);
                                    if (strtolower(@$indexArray[0]) != 'yes' || @$indexArray[0] ==null) {
                                        unset($arr['forms'][$keyForm]);
                                    }
                                }
                                if (isset($form->value['isChecked']) && $form->value['isChecked'] != '') {
                                    if (strtolower(@$form->value['isChecked']) != 'yes' || @$form->value['isChecked'] == null) {
                                        unset($arr['forms'][$keyForm]);
                                    }
                                }
                            } elseif ($form->type ==  'RadioWithChildren') {
                                if (isset($form->value)) {
                                    $i = 0;
                                    foreach ($form->value as $key =>$value) {
                                        if ($i == 0) {
                                            if ($form->value[$key] != 'Yes' || $form->value[$key] != 'yes'|| $form->value[$key] == null ) {
                                                unset($arr['forms'][$keyForm]);
                                            }
                                        }
                                        $i++;
                                    }
                                }
                            }
                        } else {
                            unset($arr['forms'][$keyForm]);
                        }
                    }
                } elseif (isset($form->isWidgetRelated) && $form->isWidgetRelated === true) {
                    eval("\$str123 = \"{$form->checkValue}\";");
                    if (count($str123) > 0) {
                        if (in_array(@$str123, $form->matchValue)) {
                            if ($form->type == 'checkbox' || $form->type == 'select' || $form->type ==  'RadioButton') {
                                if (@$form->value == '') {
                                    unset($arr['forms'][$keyForm]);
                                }
                                if (@$form->value == 'no'|| @$form->value == 'No' || @$form->value == null ) {
                                    unset($arr['forms'][$keyForm]);
                                    // dd($arr['forms'][$keyForm]);
                                }
                                if (gettype(@$form->value) == 'array' && !empty(@$form->value) && !isset($form->value['isChecked'])) {
                                    $indexArray =array_values($form->value);
                                    if (strtolower(@$indexArray[0]) != 'yes' || @$indexArray[0] == null) {
                                        unset($arr['forms'][$keyForm]);
                                    }
                                }
                                if (isset($form->value['isChecked']) && $form->value['isChecked'] != '') {
                                    if (strtolower(@$form->value['isChecked']) != 'yes' || @$form->value['isChecked'] == null) {
                                        unset($arr['forms'][$keyForm]);
                                    }
                                }
                            } elseif ($form->type ==  'RadioWithChildren') {
                                if (isset($form->value)) {
                                    $i = 0;
                                    foreach ($form->value as $key =>$value) {
                                        if ($i == 0) {
                                            if (strtolower($form->value[$key]) != 'yes' || $form->value[$key] == null) {
                                                unset($arr['forms'][$keyForm]);
                                            }
                                        }
                                        $i++;
                                    }
                                }
                            }
                        } else {
                            unset($arr['forms'][$keyForm]);
                        }
                    }
                } else {
                    if ($form->type == 'checkbox' || $form->type == 'select') {
                        if (@$form->value == '') {
                            unset($arr['forms'][$keyForm]);
                        }
                        if (@$form->value == 'no'|| @$form->value == 'No'|| @$form->value == null) {
                            unset($arr['forms'][$keyForm]);
                            // dd($arr['forms'][$keyForm]);
                        }
                        if (gettype(@$form->value) == 'array' && !empty(@$form->value)) {
                            $indexArray =array_values($form->value);
                            if (strtolower(@$indexArray[0]) != 'yes' || @$indexArray[0] == null) {
                                unset($arr['forms'][$keyForm]);
                            }
                        } else {
                            unset($arr['forms'][$keyForm]);
                        }
                    } elseif ($form->type ==  'RadioWithChildren') {
                        if (isset($form->value)) {

                            $i = 0;
                            foreach ($form->value as $key =>$value) {
                                if ($i == 0) {
                                    if (strtolower($form->value[$key]) != 'yes' || $form->value[$key] == null) {
                                        unset($arr['forms'][$keyForm]);
                                    }
                                }
                                $i++;
                            }
                        }
                    } elseif ($form->type ==  'RadioButton') {
                        if (@$form->value == '') {
                            unset($arr['forms'][$keyForm]);
                        }
                        if (@$form->value == 'no'|| @$form->value == 'No'|| @$form->value == null) {
                            unset($arr['forms'][$keyForm]);
                            // dd($arr['forms'][$keyForm]);
                        }
                        if (gettype(@$form->value) == 'array' && !empty(@$form->value) && !isset($form->value['isChecked'])) {
                            $indexArray =array_values($form->value);
                            if (strtolower(@$indexArray[0]) != 'yes' || @$indexArray[0] == null) {
                                unset($arr['forms'][$keyForm]);
                            }
                        }
                        if (isset($form->value['isChecked']) && $form->value['isChecked'] != '') {
                            if (strtolower(@$form->value['isChecked']) != 'yes' || @$form->value['isChecked'] == null) {
                                unset($arr['forms'][$keyForm]);
                            }
                        }
                    }
                }

            }
        }

        foreach ( $arr['review']  as $review) {
            if (isset($review->isLocationRelated) && $review->isLocationRelated) {
                @eval("\$viewItm = \"{$review->locationCheckValue}\";");
                if (in_array($viewItm, $review->locationMatchValue)) {
                    if (isset($review->isBusinessRelated) && $review->isBusinessRelated === true) {
                        if (count($review->relatedBusiness) > 0) {
                            if (in_array(@$workTypeData['eQuestionnaire']['businessDetails']['businessType']['optionId'], $review->relatedBusiness)) {
                                $review_array[] = $review;
                            }
                        }
                    } else if (isset($review->isWidgetRelated) && $review->isWidgetRelated === true) {
                        eval("\$str123 = \"{$review->checkValue}\";");
                        if (count($str123) > 0) {
                            if (isset($review->isLimitCheck) && $review->isLimitCheck === true) {
                                if (isset($review->lowerLimit) && isset($review->upperLimit)) {
                                    if (($review->lowerLimit < $str123) && ($str123 < $review->upperLimit)) {
                                        $review_array[] = $review;
                                    }
                                } else if (isset($review->lowerLimit)) {
                                    if (($review->lowerLimit < $str123)) {
                                        $review_array[] = $review;
                                    }
                                } else if (isset($review->upperLimit)) {
                                    if (($str123 < $review->upperLimit)) {
                                        $review_array[] = $review;
                                    }
                                }

                            } else if (in_array(@$str123, @$review->matchValue?:[])) {
                                $review_array[] = $review;
                            }
                        }
                    } else {
                        $review_array[] = $review;
                    }
                }
            } else {
                if (isset($review->isBusinessRelated) && $review->isBusinessRelated === true) {
                    if (count($review->relatedBusiness) > 0) {
                        if (in_array(@$workTypeData['eQuestionnaire']['businessDetails']['businessType']['optionId'], $review->relatedBusiness)) {
                            $review_array[] = $review;
                        }
                    }
                } else if (isset($review->isWidgetRelated) && $review->isWidgetRelated === true) {
                    if (strpos(@$review->checkValue, 'locationDetails')!=false ) {
                        if(@$formValues['eQuestionnaire']['locationDetails']){
                            eval("\$str123 = \"{$review->checkValue}\";");
                            if (count($str123) > 0) {
                                if (in_array(@$str123, @$review->matchValue?:[])) {
                                    $review_array[] = $review;
                                }
                            }
                        }
                    }else{
                        eval("\$str123 = \"{$review->checkValue}\";");
                        if (count($str123) > 0) {
                            if (in_array(@$str123, @$review->matchValue?:[])) {
                                $review_array[] = $review;
                            }
                        }
                    }
                } else {
                    $review_array[] = $review;
                }
            }
        }
        $arr['review'] = $review_array;
        $result = WorkTypeData::where('_id', new ObjectId($workTypeDataId))->update(['eSlipData'=> $arr]);
        // dd($result);
        Session::flash('success', ucwords($step)." Saved Successfully");
        return 'success';
    }
    /**
     * Function for ger insurer list in e-slip form
     */
    public function getInsurerListESlip(Request $request)
    {
        $company_id=[];
        $workTypeDataId=$request->get('workTypeDataId');
        $insurer_list = Insurer::where('isActive', 1)->orderBy('name')->get();
        if($request->get('workTypeDataId')) {
            $eslip_details = WorkTypeData::find(new ObjectId($workTypeDataId));
            if ($eslip_details->insuraceCompanyList) {
                $insurence_company = $eslip_details->insurerList;
                if ($insurence_company) {
                    foreach ($insurence_company as $company) {
                        $company_id[]=$company['id'];
                    }
                } else {
                    $company_id="";
                }
            } else {
                $company_id="";
            }
        }
        else {
            $company_id="";
        }
        return response()->json(['workTypeDataId' => $workTypeDataId, 'insurer_list' => $insurer_list, 'company_id' => $company_id]);
    }
    // public function saveinsurerList(Request $request)
    // {
    //     $insurerList = [];
    //     $insurerListArr = [];
    //     $data = $request->all();
    //     $send_type=$request->input('send_type');
    //     $insurerComment = $request->insurer_comment;
    //     $insurerArr = $request->insurerArr;
    //     $insurerListArr = explode(',', $insurerArr);
    //     foreach ($insurerListArr as $insurer) {
    //         $list['id'] = new ObjectId($insurer);
    //         $insurerList[] = $list;
    //     }
    //     // dd($insurerList);
    //     $workTypeDataId = $request->workTypeDataId;
    //     $result = ESlipFormData::where('workTypeDataId', new ObjectId($workTypeDataId))->update(['insurerList'=> $insurerList, 'insurerComment'=> $insurerComment]);

    //     return 'success';
    // }


    public function saveinsurerList(Request $request)
    {
        $files = $request->input('files');
        $comment = $request->input('insurer_comment');
        $workTypeDataId = $request->input('workTypeDataId');
        $pipeline_details = WorkTypeData::find(new ObjectId($workTypeDataId));
        $insurance_companies = [];
        $insurerListArr = [];
        $ins_idArr=[];
        $insurerArr = $request->input('insurerArr');
        $insurerListArr  = json_decode($insurerArr);
        foreach ($insurerListArr as $insurer) {
            $list = $insurer;
            $list->id = new ObjectId($insurer->id);
            $ins_idArr[] = new ObjectId($insurer->id);
            $insurance_companies[] = $list;
        }

        $insurers = [];
        $existing_insures = [];
        $send_type = $request->input('send_type');
        $create_excel = $this->createExcel($pipeline_details);
        $excel_name = $create_excel . '.' . 'xls';
        $send_excel = public_path('/excel/' . $excel_name);
        if ($send_excel) {
            if (isset($pipeline_details->insurerList)) {
                $insurence_company = $pipeline_details->insurerList;
                foreach ($insurence_company as $company) {
                    if (!empty($company)) {
                        $existing_insures[] = $company['id'];
                    }
                }
                if ($send_type == 'send_all') {
                    foreach ($existing_insures as $key => $value) {
                        if (in_array($value, $ins_idArr)) {
                            WorkTypeData::where('_id', new ObjectId($workTypeDataId))->update(array('insurerList.' . $key . '.status' => 'resend'));
                        }
                    }
                    foreach ($insurerListArr as $x => $x_value) {
                        $users = User::where('insurer.id', new ObjectID($x_value->id))->get();
                        $link = url('/');
                        foreach ($users as $user) {
                            if (isset($user->email) && !empty($user->email)) {
                                $type = $pipeline_details['workTypeId']['name'];
                                EslipSubmittedReminder::dispatch($user->email, $send_excel, $user, $link, $files, $comment, $type);
                            }
                        }
                        $insurer_object = new \stdClass();
                        $insure_list = Insurer::find($x_value->id);
                        $insures_name = $insure_list->name;
                        $insurer_object->id = new ObjectID($x_value->id);
                        $insurer_object->status = 'active';
                        $insurer_object->name = $insures_name;
                        $insurers[] = $insurer_object;
                    }
                } elseif ($send_type == 'send_new') {
                    $flg = 0;
                    foreach ($insurerListArr as $x => $x_value) {
                        if (!in_array($x_value->id, $existing_insures)) {
                            $flg = 1;
                            $users = User::where('insurer.id', new ObjectID($x_value->id))->get();
                            $link = url('/');
                            foreach ($users as $user) {
                                if (isset($user->email) && !empty($user->email)) {
                                    $type = $pipeline_details['workTypeId']['name'];
                                    EslipSubmittedReminder::dispatch($user->email, $send_excel, $user, $link, $files, $comment, $type);
                                }
                            }
                            $insurer_object = new \stdClass();
                            $insure_list = Insurer::find($x_value->id);
                            $insures_name = $insure_list->name;
                            $insurer_object->id = new ObjectID($x_value->id);
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
                foreach ($insurerListArr as $x => $x_value) {

                    $link = url('/');
                    $users = User::where('insurer.id', new ObjectId($x_value->id))->get();
                    // $users = User::where('insurer.id', new ObjectId($x_value))->get();

                    foreach ($users as $user) {
                        if (isset($user->email) && !empty($user->email)) {
                            $type = $pipeline_details['workTypeId']['name'];
                            EslipSubmittedReminder::dispatch($user->email, $send_excel, $user, $link, $files, $comment, $type);
                        }
                    }
                    $insurer_object = new \stdClass();
                    $insure_list = Insurer::find($x_value->id);
                    $insures_name = $insure_list->name;
                    $insurer_object->id = new ObjectID($x_value->id);
                    $insurer_object->status = 'active';
                    $insurer_object->name = $insures_name;
                    $insurers[] = $insurer_object;
                }
            }
            $pipeline_details = WorkTypeData::find($request->input('workTypeDataId'));
            if ($pipeline_details->status['status'] == 'E-slip') {
                $pipeline_status = PipelineStatus::where('status', 'E-quotation')->first();
                $status_array = array('status.id' => new ObjectID($pipeline_status->_id),
                'status.status' => (string) $pipeline_status->status,
                'status.UpdatedById' => new ObjectId(Auth::id()),
                'status.UpdatedByName' => Auth::user()->name,
                'status.date' => date('d/m/Y'));
                DB::collection('workTypeData')->where('_id', new ObjectId($request->input('workTypeDataId')))
                    ->update($status_array);
                //DB::collection('eSlipFormData')->where('workTypeDataId', new ObjectId($request->input('workTypeDataId')))
                    //->update($status_array);
            } elseif ($pipeline_details->status['status'] == 'Quote Amendment' || $pipeline_details->status['status'] == 'Quote Amendment-E-slip') {
                $pipeline_status = PipelineStatus::where('status', 'Quote Amendment-E-quotation')->first();
                $status_array = array('status.id' => new ObjectID($pipeline_status->_id),
                'status.status' => (string) $pipeline_status->status,
                'status.UpdatedById' => new ObjectId(Auth::id()),
                'status.UpdatedByName' => Auth::user()->name,
                'status.date' => date('d/m/Y'));
                DB::collection('workTypeData')->where('_id', new ObjectId($request->input('workTypeDataId')))
                ->update($status_array);
                //DB::collection('eSlipFormData')->where('workTypeDataId', new ObjectId($request->input('workTypeDataId')))
                //->update($status_array);
            }

            //ESlipFormData::where('workTypeDataId', new ObjectId($workTypeDataId))->update(['insurerList'=> $insurance_companies, 'insurerComment'=> $comment]);
            WorkTypeData::where('_id', new ObjectId($workTypeDataId))->update(['insurerComment'=> $comment]);
            WorkTypeData::where('_id', new ObjectId($workTypeDataId))->push('insurerList', $insurers);
            // DB::collection('workTypeData')->where('_id', new ObjectID($request->input('workTypeDataId')))
            //     ->push('insuraceCompanyList', $insurers);
            // DB::collection('eSlipFormData')->where('workTypeDataId', new ObjectID($request->input('workTypeDataId')))
            //     ->push('insuraceCompanyList', $insurers);
            Session::flash('success', "Insurer Details Saved Successfully");
            return response()->json(['success' => 'success', 'id' => $request->input('workTypeDataId')]);
        }
    }


    //create excel sheet for insurers
    public function createExcel($pipeline_details)
    {

        $formValues = $pipeline_details;
        $questions_array = [];
        $answes_array = [];
        foreach ($pipeline_details['eSlipData']['review'] as $review) {
            if ($review['eQuotationVisibility'] == true) {
                if ($review['type'] == 'checkbox') {
                    $questions_array[] = $review['label'];
                    $answes_array[] = "Yes";
                }
            }
        }
        foreach ($pipeline_details['eSlipData']['forms'] as $forms) {
            if (!is_array($forms['value'])) {
                if (isset($forms['config']['preCustomerLabel'])) {
                    $questions_array[] = $forms['config']['preCustomerLabel'];
                } else {
                    $questions_array[] = $forms['label'];
                }
                if (isset($forms['eQuoteTextboxValue']) && $forms['eQuoteTextboxValue']) {
                    $answes_array[] = $forms['value'];
                } elseif ((isset($forms['eQuoteTextbox']) && $forms['eQuoteTextbox']) || (isset($forms['eQuoteTextArea']) && $forms['eQuoteTextArea'])) {
                    if (isset($forms['isCustomerResponse']) && isset($forms['isCustomerResponse'])) {
                        $answes_array[] = $forms['value'];
                    } else {
                        $answes_array[] = "";
                    }
                } else {
                    $answes_array[] = $forms['value'];
                }
            } elseif (@$forms['value']['seperateStatus'] || $forms['widgetType'] == 'CombinedOrSeperatedRate') {
                if (isset($forms['config']['preCustomerLabel'])) {
                    $questions_array[] = $forms['config']['preCustomerLabel'];
                } else {
                    $questions_array[] = $forms['label'];
                }
                // $questions_array[] = $forms['label'];
                if (@$forms['value']['seperateStatus'] == 'seperate') {
                    $seperate_data = "";
                    $seperate_data .= @$forms['value']['adminRate']?"Admin Rate :". $forms['value']['adminRate']: '';
                    $seperate_data .= @$forms['value']['nonAdminRate']? ', Admin Rate : '.$forms['value']['nonAdminRate']:'';
                } else {
                    $seperate_data  = "";
                    $seperate_data .= @$forms['value']['combinedRate']? "Combined Rate : ".$forms['value']['combinedRate']:'';
                    $seperate_data .= @$forms['value']['Premium']?'Premium :  '.@$forms['value']['Premium']:'';
                }
                if ((isset($forms['eQuoteTextbox']) && $forms['eQuoteTextbox']) || (isset($forms['eQuoteTextArea']) && $forms['eQuoteTextArea'])) {
                    if (isset($forms['isCustomerResponse']) && isset($forms['isCustomerResponse'])) {
                        $answes_array[] = $seperate_data;
                    } else {
                        $answes_array[] = "";
                    }
                } else {
                    $answes_array[] = $seperate_data;
                }
            } elseif (gettype(@$forms['value']) == 'array' && !empty(@$forms['value']) && !isset($forms['value']['isChecked']) ) {
                $indexArray =array_values($forms['value']);
                if (strtolower(@$indexArray[0]) == 'yes') {
                    if (isset($forms['config']['preCustomerLabel'])) {
                        $questions_array[] = $forms['config']['preCustomerLabel'];
                    } else {
                        $questions_array[] = $forms['label'];
                    }
                    // $questions_array[] = $forms['label'];
                    $answes_array[] = "Yes";
                }
            } elseif (isset($forms['value']['isChecked']) && $forms['value']['isChecked'] == 'yes') {
                if (isset($forms['config']['preCustomerLabel'])) {
                    $questions_array[] = $forms['config']['preCustomerLabel'];
                } else {
                    $questions_array[] = $forms['label'];
                }
                // $questions_array[] = $forms['label'];
                if ((isset($forms['eQuoteTextbox']) && $forms['eQuoteTextbox']) || (isset($forms['eQuoteTextArea']) && $forms['eQuoteTextArea'])) {
                    if (isset($forms['isCustomerResponse']) && isset($forms['isCustomerResponse'])) {
                        $answes_array[] = "Yes";
                    } else {
                        $answes_array[] = "";
                    }
                } else {
                    $answes_array[] = "Yes";
                }
            }
        }
            $cell_count = count($questions_array)+1;
            $cell = 'C2:D'.$cell_count;
        $data[] = ['Questions', 'Customer Response', 'Insurer Response', 'Comments'];
        foreach ($questions_array as $key => $each_question) {
            $question = $each_question;
            $answer = @$answes_array[$key];
            $data[] = array(
            $question,
            $answer,
            );
        }
        $file_name_ = 'IIB E-Quotes' . rand();
        $workTypeName = @$formValues->workTypeId['name'];
        $workTypeName = strlen($workTypeName) > 27 ? substr($workTypeName, 0, 27)."..." : $workTypeName;
        Excel::create(
            $file_name_, function ($excel) use ($data, $cell, $cell_count, $workTypeName) {
                $excel->sheet(
                    $workTypeName, function ($sheet) use ($data, $cell, $cell_count) {
                        $sheet->fromArray($data, null, 'A1', true, false);
                        $sheet->row(
                            1, function ($row) {
                                $row->setFontSize(10);
                                $row->setFontColor('#ffffff');
                                $row->setBackground('#1155CC');
                            }
                        );
                        $sheet->protect('password');
                        $sheet->getStyle($cell)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
                        $sheet->setAutoSize(true);
                        $sheet->setWidth('A', 70);
                        $sheet->getRowDimension(1)->setRowHeight(10);
                        $sheet->setWidth('B', 50);
                        $sheet->getStyle('A0:A'.$cell_count)->getAlignment()->setWrapText(true);
                        $sheet->getStyle('B0:B'.$cell_count)->getAlignment()->setWrapText(true);
                    }
                );
            }
        )->store('xls', public_path('excel'));
                        return $file_name_;
    }
}
