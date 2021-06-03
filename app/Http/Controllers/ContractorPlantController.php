<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PipelineItems;
use App\Customer;
use App\State;
use App\CountryListModel;
use App\ImportExcel;
use App\User;
use App\Insurer;
use App\Jobs\SendQuestionnaire;
use App\Jobs\EslipSubmittedReminder;
use App\PipelineStatus;
use Maatwebsite\Excel\Facades\Excel;
use MongoDB\BSON\ObjectID;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use PDF;

class ContractorPlantController extends Controller
{  
    public function __construct()
    {
        $this->middleware('auth.underwriter', ['except' => [ 'equestionnaireSave', 'decisionSave','viewComparison']]);
    }
    /**
     * view e qustionnaire
     */
    public function eQuestionaire($eQuestionnaireid)
    {
        $PipelineItems = PipelineItems::find($eQuestionnaireid);
        if ($PipelineItems->pipelineStatus != "true") {
            return view('error');
        }
        $country_name = [];
        $country_name_place = [];
        $all_emirates = State::all();
        $all_countries = CountryListModel::get();
        foreach ($all_countries as $key => $country) {
            $name = $country['country'];
            $country_name[] = $name['countryName'];
        }
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
            return view('pipelines.plant_mach.e_questionnaire')->with(compact('country_name_place', 'country_name', 'all_emirates', 'eQuestionnaireid', 'form_data', 'PipelineItems', 'customer_details', 'all_insurers', 'file_name', 'file_url'));
        } else {
            return view('error');
        }
    }

    /**
     * download excel for e questionnaire
     */
    public function downloadExcel()
    {
        // $data=[];
        // $data[] = array("Contractor`s Plant and Machinery");
        $data[] = ['Brand','Model','Year of Manufacture','Engine Number','Registration Number','Chassis No.','Location ','Market Value (AED)','New Replacement Value (AED)'];
        Excel::create("Contractor`s Plant and Machinery", function ($excel) use ($data) {
            $excel->sheet("Contractor`s Plant & Machinery", function ($sheet) use ($data) {
                // $sheet->mergeCells('A1:I1');
                // $sheet->row(1, function ($row) {
                //     $row->setFontSize(13);
                //     $row->setFontColor('#ffffff');
                //     $row->setBackground('#1155CC');
                // });
                // $sheet->protect('password');
                // $sheet->freezeFirstRow();
                // $sheet->getStyle('A1:I1')->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_PROTECTED);
                $sheet->fromArray($data, null, 'A1', true, false);
            });
        })->download('xls');
    }
    
    /**
     * save equstionnaire
     */
    public static function equestionnaireSave(Request $request)
    {
       
        $questionnaire = PipelineItems::find($request->input('id'));
        // dd($questionnaire);
        if ($questionnaire) {
            // try{
                $address_object = new \stdClass();
                $address_object->addressLine1 = $request->input('addressLine1');
                $address_object->addressLine2 = $request->input('addressLine2');
                $address_object->country = $request->input('country');
                $address_object->state = $request->input('state');
                $address_object->city = $request->input('city');
                $address_object->zipCode = $request->input('zipCode');
            $placeOfEmployment_object = new \stdClass();
            if ($request->input('withinUAE')=='WithinUAE') {
                $placeOfEmployment_object->withinUAE = (boolean)true;
                $placeOfEmployment_object->emirateName=$request->input('emirateName');
            } elseif ($request->input('withinUAE')=='OutsideUAE') {
                $placeOfEmployment_object->withinUAE = (boolean)false;
                $placeOfEmployment_object->countryName=$request->input('countryName');
            }
            $policy_bank_object = new \stdClass();
            $policybank = $request->input('policy_bank');
            if ($policybank == 'yes') {
                $policy_bank_object->policyBank = (boolean)true;
                $policy_bank_object->bankname = $request->input('bankname');
                $policy_bank_object->telnumber = $request->input('telnumber');
                $policy_bank_object->fax = $request->input('fax');
                $policy_bank_object->pobox = $request->input('pobox');
                $policy_bank_object->location = $request->input('location');
                $policy_bank_object->contact = $request->input('contact');
                $policy_bank_object->deptBank = $request->input('dept_bank');
                $policy_bank_object->email = $request->input('email');
                $policy_bank_object->mobile = $request->input('mobile');
                // $policy_bank_object->amount = $request->input('amount');
            } elseif ($policybank == 'no') {
                $policy_bank_object->policyBank = (boolean)false;
            }
            // $formdata->occupancy=$occupancy_object;
            $machEquipObject = new \stdClass();
            if ($request->input('mach_equip') == 'yes') {
                $machEquipObject->machEquip = (boolean) true;
                $machEquipObject->details = $request->input('details');
            } elseif ($request->input('mach_equip') == 'no') {
                $machEquipObject->machEquip = (boolean) false;
            }
            $year = $request->input('year');
            $description = $request->input('description');
            $claim_amount = $request->input('claim_amount');
            $claim_array = [];
            foreach ($year as $key => $year_value) {
                if ($year_value != 0 || $year_value != null) {
                    $claim_history_object = new \stdClass();
                    $claim_history_object->year = $year[$key];
                    $claim_history_object->description = $description[$key];
                    $claim_history_object->claim_amount = str_replace(',', '', $claim_amount[$key]);
                    $claim_array[] = $claim_history_object;
                } else {
                    $claim_history_object = new \stdClass();
                    $claim_history_object->year = $year[$key];
                    $claim_history_object->description = '';
                    $claim_history_object->claim_amount = '';
                    $claim_array[] = $claim_history_object;
                }
            }

            // $formdata->claimsHistory=$claim_array;
            // $formdata->businessInterruption=$businessInterruptionObject;

            $formdata_object = [];

            $formdata_object = [
                'formData.salutation' => $request->input('salutation'),
                'formData.firstName' => ucwords(strtolower($request->input('firstName'))),
                'formData.middleName' => ucwords(strtolower($request->input('middleName'))),
                'formData.lastName' => ucwords(strtolower($request->input('lastName'))),
                'formData.addressDetails' => $address_object,
                'formData.affCompany' => ucwords(strtolower($request->input('aff_company'))),
                'formData.businessType' =>$request->input('businessType'),
                'formData.policyBank' => $policy_bank_object,
                'formData.placeOfEmployment' => $placeOfEmployment_object,
                'formData.machEquip' => $machEquipObject,
                'formData.claimsHistory' => $claim_array
            ];
            $tax_certificate = $request->file('tax_certificate');
            $policyCopy = $request->file('policyCopy');
            $trade_list = $request->file('trade_list');
            $employee_upload = $request->file('employee_upload');
            $others1 = $request->file('others1');
            // dd($others1);
            $others2 = $request->file('others2');
            $excel = $request->file('excelCopy');
            // $file=[];
            if ($tax_certificate) {
                $tax_certificate = PipelineController::uploadToCloud($tax_certificate);
                $tax_certificate_object = new \stdClass();
                $tax_certificate_object->url = $tax_certificate;
                $tax_certificate_object->file_name = 'TAX REGISTRATION DOCUMENT';
                $tax_certificate_object->upload_type = 'e_questionnaire';
                $file[] = $tax_certificate_object;
            } elseif ($request->input('tax_url') != '') {
                $tax_certificate_object = new \stdClass();
                $tax_certificate_object->url = $request->input('tax_url');
                $tax_certificate_object->file_name = 'TAX REGISTRATION DOCUMENT';
                $tax_certificate_object->upload_type = 'e_questionnaire';
                $file[] = $tax_certificate_object;
            } else {
                $tax_certificate_object = '';
            }
            if ($others1) {
                $others1 = PipelineController::uploadToCloud($others1);
                $others1_object = new \stdClass();
                $others1_object->url = $others1;
                $others1_object->file_name = 'OTHERS 1';
                $others1_object->upload_type = 'e_questionnaire';
                $file[] = $others1_object;
            } elseif ($request->input('other1_url') != '') {
                $others1_object = new \stdClass();
                $others1_object->url = $request->input('other1_url');
                $others1_object->file_name = 'OTHERS 1'; 
                $others1_object->upload_type = 'e_questionnaire';
                $file[] = $others1_object;
            } else {
                $others1_object = '';
            }
            if ($others2) {
                $others2 = PipelineController::uploadToCloud($others2);
                $others2_object = new \stdClass();
                $others2_object->url = $others2;
                $others2_object->file_name = 'OTHERS 2';
                $others2_object->upload_type = 'e_questionnaire';
                $file[] = $others2_object;
            } elseif ($request->input('other2_url') != '') {
                $others2_object = new \stdClass();
                $others2_object->url = $request->input('other2_url');
                $others2_object->file_name = 'OTHERS 2';
                $others2_object->upload_type = 'e_questionnaire';
                $file[] = $others2_object;
            } else {
                $others1_object = '';
            }
            if ($trade_list) {
                $trade_list = PipelineController::uploadToCloud($trade_list);
                $trade_list_object = new \stdClass();
                $trade_list_object->url = $trade_list;
                $trade_list_object->file_name = 'TRADE LICENSE';
                $trade_list_object->upload_type = 'e_questionnaire';
                $file[] = $trade_list_object;
            } elseif ($request->input('trade_url') != '') {
                $trade_list_object = new \stdClass();
                $trade_list_object->url = $request->input('trade_url');
                $trade_list_object->file_name = 'TRADE LICENSE';
                $trade_list_object->upload_type = 'e_questionnaire';
                $file[] = $trade_list_object;
            } else {
                $trade_list_object = '';
            }
            if ($employee_upload) {
                $employee_upload = PipelineController::uploadToCloud($employee_upload);
                $employee_upload_object = new \stdClass();
                $employee_upload_object->url = $employee_upload;
                $employee_upload_object->file_name = 'LIST OF EMPLOYEES';
                $employee_upload_object->upload_type = 'e_questionnaire';
                $file[] = $employee_upload_object;
            } elseif ($request->input('emp_url') != '') {
                $employee_upload_object = new \stdClass();
                $employee_upload_object->url = $request->input('emp_url');
                $employee_upload_object->file_name = 'LIST OF EMPLOYEES';
                $employee_upload_object->upload_type = 'e_questionnaire';
                $file[] = $employee_upload_object;
            } else {
                $employee_upload_object = '';
            }
            if ($policyCopy) {
                $policyCopy = PipelineController::uploadToCloud($policyCopy);
                $policy_files = new \stdClass();
                $policy_files->url = $policyCopy;
                $policy_files->file_name = 'COPY OF THE POLICY';
                $policy_files->upload_type = 'e_questionnaire';
                $file[] = $policy_files;
            } elseif ($request->input('policy_url') != '') {
                $policy_files = new \stdClass();
                $policy_files->url = $request->input('policy_url');
                $policy_files->file_name = 'COPY OF THE POLICY';
                $policy_files->upload_type = 'e_questionnaire';
                $file[] = $policy_files;
            } else {
                $policy_files = '';
            }
            if ($excel) {
                $excel = PipelineController::uploadToCloud($excel);
                $excel_files = new \stdClass();
                $excel_files->url = $excel;
                $excel_files->file_name = 'EXCEL';
                $excel_files->upload_type = 'e_questionnaire';
                $file[] = $excel_files;
            } elseif ($request->input('excel_url') != '') {
                $excel_files = new \stdClass();
                $excel_files->url = $request->input('excel_url');
                $excel_files->file_name = 'EXCEL';
                $excel_files->upload_type = 'e_questionnaire';
                $file[] = $excel_files;
            } else {
                $excel_files = '';
            }
            PipelineItems::where('_id', $request->input('id'))->pull('files', ['upload_type' => 'e_questionnaire']);
            // PipelineItems::where('_id', $request->input('id'))->pull('files', ['upload_type' => 'e_questionnaire_fancy']);

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
            PipelineItems::where('_id', $request->input('id'))->update($formdata_object);
            // $questionnaire->formData=$formdata;
            if (isset($file) && !empty($file)) {
                $questionnaire->push('files', $file);
            }
            // $updatedBy_obj = new \stdClass();
            // $updatedBy_obj->id = new ObjectID(Auth::id());
            // $updatedBy_obj->name = Auth::user()->name ;
            // $updatedBy_obj->date = date('d/m/Y');
            // if($request->input('is_edit')=='1')
            // {
            //    $updatedBy_obj->action = "E questionnaire updated";
            // }else{
            //    $updatedBy_obj->action = "E questionnaire filled";
            // }
            // $updatedBy[] = $updatedBy_obj;
            // if(isset($questionnaire->tokenStatus))
            // {
            //    $questionnaire->tokenStatus = "inactive";
            // }
            // $questionnaire->push('updatedBy', $updatedBy);

            // $pipline_status=PipelineStatus::where('status','E-slip')->first();
            // $pipeline_status_object=new \stdClass();
            // $pipeline_status_object->id=new ObjectID($pipline_status->_id);
            // $pipeline_status_object->status=(string)$pipline_status->status;
            // $pipeline_status_object->UpdatedById = new ObjectId(Auth::id());
            // $pipeline_status_object->UpdatedByName = Auth::user()->name;
            // $pipeline_status_object->date = date('d/m/Y');
            // $questionnaire->status =$pipeline_status_object;

            if ($request->input('is_save') == 'true') {
                if ($request->input('is_edit') == "0") {
                    $updatedBy_obj = new \stdClass();
                    $updatedBy_obj->id = new ObjectID(Auth::id());
                    $updatedBy_obj->name = Auth::user()->name;
                    $updatedBy_obj->date = date('d/m/Y');
                    $updatedBy_obj->action = "E questionnaire saved as draft";
                    $updatedBy[] = $updatedBy_obj;
                    // if (isset($file) && !empty($file)) {
                    //     $questionnaire->push('files', $file);
                    // }
                    $questionnaire->push('updatedBy', $updatedBy);
                    $questionnaire->save();
                    return 'success';
                } else {
                    $updatedBy_obj = new \stdClass();
                    $updatedBy_obj->id = new ObjectID(Auth::id());
                    $updatedBy_obj->name = Auth::user()->name;
                    $updatedBy_obj->date = date('d/m/Y');
                    $updatedBy_obj->action = "E questionnaire saved as draft";
                    $updatedByedit[] = $updatedBy_obj;
                    PipelineItems::where('_id', new ObjectId($request->input('id')))->push('updatedBy', $updatedByedit);
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
                    $pipline_status = PipelineStatus::where('status', 'E-slip')->first();
                    $pipeline_status_object = new \stdClass();
                    $pipeline_status_object->id = new ObjectID($pipline_status->_id);
                    $pipeline_status_object->status = (string) $pipline_status->status;
                    $pipeline_status_object->UpdatedById = new ObjectId(Auth::id());
                    $pipeline_status_object->UpdatedByName = Auth::user()->name;
                    $pipeline_status_object->date = date('d/m/Y');
                    $questionnaire->status = $pipeline_status_object;
                }
                
            }
            $questionnaire->save();

            if ($request->input('filler_type') != "fill_customer") {
                Session::flash('status', 'Questionnaire added successfully.');
                return "success";
            } else {
                Session::flash('msg', 'E-questionnaire successfully added');
                return redirect('customer-notification');
            }

            // }
            // catch(\Exception $e)
            // {
            //    if($request->input('filler_type') != "fill_customer."){
            //       return back()->withInput()->with('status', 'Failed');
            //    }
            //    else
            //    {
            //       Session::flash('msg','E-questionnaire is failed to add.');
            //       return redirect('customer-notification');
            //    }
            // }
        } else {
            return view('error');
        }
    }

   /**
     * send questionnire
     */
    public function sendQuestionnaire(Request $request)
    {
        $pipelineId = $request->input('id');
        $files = $request->input('files');
        $comment = $request->input('txt_comment');
        $status = 0;
        $token = str_random(3) . time() . str_random(3);
        $pipeLine = PipelineItems::findOrFail($pipelineId);
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
        $link = url('/contractor-plant/customer-questionnaire/' . $token);
        $workType = $pipeLine->workTypeId['name'];
        if (isset($email) && !empty($email)) {
            SendQuestionnaire::dispatch($email, $name, $link, $workType, $files, $comment);
        } else {
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
            $pipeline_status_object->status = (string) $pipline_status->status;
            $pipeline_status_object->UpdatedById = new ObjectId(Auth::id());
            $pipeline_status_object->UpdatedByName = Auth::user()->name;
            $pipeline_status_object->date = date('d/m/Y');
            $pipeLine->status = $pipeline_status_object;
        }
        $pipeLine->save();
        PipelineItems::where('_id', new ObjectId($pipelineId))->push('updatedBy', $updatedBy);
        return 'E-questionnaire has been sent to ' . $email;
    }

      /**
     * Function for display e questionnaire for customers
     */
    public function customerQuestionnaire($token)
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
                return view('pipelines.plant_mach.sendQuestion')->with(compact('country_name', 'all_emirates', 'eQuestionnaireid', 'form_data', 'PipelineItems', 'customer_details', 'all_insurers', 'file_name', 'file_url'));
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
     * eslip view page
     */
    public function ESlip($worktype_id)
    {
        $pipeline_details = PipelineItems::find($worktype_id);
        if ($pipeline_details['status']['status'] == 'Worktype Created' || $pipeline_details['status']['status'] == 'E-questionnaire') {
            return view('error');
        }
        if ($pipeline_details->pipelineStatus != "true") {
            return view('error');
        }
        if ($pipeline_details) {
            $form_data = $pipeline_details['formData'];
            $file_name = [];
            $file_url = [];
            $files = $pipeline_details['files'];
            if (isset($pipeline_details['files'])) {
                foreach ($files as $file) {
                    $file_name[] = $file['file_name'];
                    $file_url[] = $file['url'];
                }
            } else {
                $file_name[] = '';
                $file_url[] = '';
            }
            return view('pipelines.plant_mach.e_slip')->with(compact('worktype_id', 'pipeline_details', 'file_name', 'file_url', 'form_data'));
        } else {
            return view('error');
        }
        // return view('pipelines.property.e_slip');
    }
       /**
     * save eslip
     */
    public function eslipSave(Request $request)
    {
        $pipeline_details = PipelineItems::find(new ObjectId($request->input('eslip_id')));
        $formdata_object = [];
        if (isset($pipeline_details['formData']['machEquip']['machEquip']) && ($pipeline_details['formData']['machEquip']['machEquip'] == true)) {
            $coverHired = (boolean) $request->input('cover_hired')?: false;
            $formdata_object['formData.coverHired'] = $coverHired;
        } else {
            PipelineItems::where('_id', $request->input('eslip_id'))->unset('formData.coverHired');
        }
        if (isset($pipeline_details['formData']['affCompany']) && $pipeline_details['formData']['affCompany']!='') {
            $crossLiability = (boolean) $request->input('cross_liability')?: false;
            $formdata_object['formData.crossLiability'] = $crossLiability;
        } else {
            PipelineItems::where('_id', $request->input('eslip_id'))->unset('formData.crossLiability');
        }
        if (isset($pipeline_details['formData']['policyBank']['policyBank']) && @$pipeline_details['formData']['policyBank']['policyBank'] ==true) {
             $lossPayee = (boolean) $request->input('loss_payee')?: false;
            $formdata_object['formData.lossPayee'] = $lossPayee;
        } else {
            PipelineItems::where('_id', $request->input('eslip_id'))->unset('formData.lossPayee');
        }
        if ($request->input('auth_repair')!='') {
            $auhrepair=(string) $request->input('auth_repair');
        } else {
            $auhrepair='';
        }
        $formdata_object4 = [
            'formData.authRepair' =>$auhrepair ,
            'formData.agencyRepair' => (string) $request->input('agency_repair'),
            'formData.profitShare' => (string) $request->input('profit_share'),
            'formData.claimPro' => (string) $request->input('claim_pro'),
            'formData.waiver' => (string) $request->input('waiver'),
            'formData.rate' => (string) $request->input('rate'),
            'formData.premium' => (string) $request->input('premium'),
            'formData.payTerm' => (string) $request->input('pay_term'),
            'formData.indemnityPrincipal' => (string) $request->input('indemnity_principal'),
            'formData.strikeRiot' => (boolean) $request->input('strike_riot') ?: false,
            'formData.overtime' => (boolean) $request->input('overtime') ?: false,
            'formData.coverExtra' => (boolean) $request->input('cover_extra') ?: false,
            'formData.coverUnder' => (boolean) $request->input('cover_under') ?: false,
            'formData.drillRigs' => (boolean) $request->input('drill_rigs') ?: false,
            'formData.inlandTransit' => (boolean) $request->input('inland_transit') ?: false,
            'formData.transitRoad' => (boolean) $request->input('transit_road') ?: false,
            'formData.thirdParty' => (boolean) $request->input('third_party') ?: false,
            'formData.autoSum' => (boolean) $request->input('auto_sum') ?: false,
            'formData.includRisk' => (boolean) $request->input('includ_risk') ?: false,
            'formData.tool' => (boolean) $request->input('tool') ?: false,
            'formData.hoursClause' => (boolean) $request->input('hours_clause') ?: false,
            'formData.lossAdj' => (boolean) $request->input('loss_adj') ?: false,
            'formData.primaryClause' => (boolean) $request->input('primary_clause') ?: false,
            'formData.paymentAccount' => (boolean) $request->input('payment_account') ?: false,
            'formData.avgCondition' => (boolean) $request->input('avg_condition') ?: false,
            'formData.autoAddition' => (boolean) $request->input('auto_addition') ?: false,
            'formData.cancelClause' => (boolean) $request->input('cancel_clause') ?: false,
            'formData.derbis' => (boolean) $request->input('derbis') ?: false,
            'formData.repairClause' => (boolean) $request->input('repair_clause') ?: false,
            'formData.tempRepair' => (boolean) $request->input('temp_repair') ?: false,
            'formData.errorOmission' => (boolean) $request->input('error_omission') ?: false,
            'formData.minLoss' => (boolean) $request->input('min_loss') ?: false,
            'formData.coverInclude' => (boolean) $request->input('cover_include') ?: false,
            'formData.towCharge' => (boolean) $request->input('tow_charge') ?: false,
            'formData.propDesign' => (boolean) $request->input('prop_design') ?: false,
            'formData.specialAgree' => (boolean) $request->input('special_agree') ?: false,
            'formData.declarationSum' => (boolean) $request->input('declaration_sum') ?: false,
            'formData.salvage' => (boolean) $request->input('salvage') ?: false,
            'formData.totalLoss' => (boolean) $request->input('total_loss') ?: false
                ];
        $formdata_object = array_merge($formdata_object, $formdata_object4);

        //  dd($formdata_object);
        PipelineItems::where('_id', $request->input('eslip_id'))->update($formdata_object);
        $updatedBy_obj = new \stdClass();
        $updatedBy_obj->id = new ObjectID(Auth::id());
        $updatedBy_obj->name = Auth::user()->name;
        $updatedBy_obj->date = date('d/m/Y');
        if ($request->input('is_save') == 'true') {
            $updatedBy_obj->action = "E slip saved as draft";
        } else {
            $updatedBy_obj->action = "E slip saved";
        }
        $updatedBy[] = $updatedBy_obj;
        PipelineItems::where('_id', new ObjectId($request->input('eslip_id')))->push('updatedBy', $updatedBy);
        return response()->json(['success' => 'success']);
    }

      /**
     * save insurance company and send excel
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
                                $type =$pipeline_details['workTypeId']['name'];
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
                                    $type =$pipeline_details['workTypeId']['name'];
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
                            $type =$pipeline_details['workTypeId']['name'];
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

    //create excel sheet for insurers
    public function createExcel($pipeline_details)
    {
        $pipeline_details = PipelineItems::find($pipeline_details->_id);
        $questions_array = [];
        $answes_array = [];
        if (isset($pipeline_details['formData']['authRepair'])&& $pipeline_details['formData']['authRepair']!='') {
            $questions_array[] = 'Authorised repair limit';
            $answes_array[] = $pipeline_details['formData']['authRepair'];
        }
        $questions_array[] = 'Strike, riot and civil commotion and malicious damage';
        $answes_array[] = $pipeline_details['formData']['strikeRiot']? "Yes" : "No";
        $questions_array[] = 'Overtime, night works , works on public holidays and express freight';
        $answes_array[] = $pipeline_details['formData']['overtime']? "Yes" : "No";
        $questions_array[] = 'Cover for extra charges for Airfreight';
        $answes_array[] = $pipeline_details['formData']['coverExtra']? "Yes" : "No";
        $questions_array[] = 'Cover for underground Machinery and equipment';
        $answes_array[] = $pipeline_details['formData']['coverUnder']? "Yes" : "No";
        if (isset($pipeline_details['formData']['drillRigs'])&& $pipeline_details['formData']['drillRigs']==true) {
            $questions_array[] = 'Cover for water well drilling rigs and equipment';
            $answes_array[] = $pipeline_details['formData']['drillRigs']? "Yes" : "No";
        }
        $questions_array[] = 'Inland Transit including loading and unloading cover';
        $answes_array[] = $pipeline_details['formData']['inlandTransit']? "Yes" : "No";
        $questions_array[] = 'Transit and Road risks whilst the insured items are travelling/transporting on own power on public roads';
        $answes_array[] = $pipeline_details['formData']['transitRoad']? "Yes" : "No";
        $questions_array[] = 'Third Party Liability- whilst on site, owned and/or hired parking yard, during participation in any sales promotions, sports, social events, display at various sites within GCC either contract of hire or otherwise';
        $answes_array[] = $pipeline_details['formData']['thirdParty']? "Yes" : "No";
        if (isset($pipeline_details['formData']['machEquip']['machEquip']) && ($pipeline_details['formData']['machEquip']['machEquip'] == true) && isset($pipeline_details['formData']['coverHired'])) {
            $questions_array[] = 'Cover when items are hired out';
            $answes_array[] = $pipeline_details['formData']['coverHired']? "Yes" : "No";
        }
        $questions_array[] = 'Automatic Reinstatement of sum insured';
        $answes_array[] = $pipeline_details['formData']['autoSum']? "Yes" : "No";
        $questions_array[] = 'Including the risk of erection, resettling and dismantling';
        $answes_array[] = $pipeline_details['formData']['includRisk']? "Yes" : "No";
        $questions_array[] = 'Tool of trade extension';
        $answes_array[] = $pipeline_details['formData']['tool']? "Yes" : "No";
        $questions_array[] = '72 Hours clause';
        $answes_array[] = $pipeline_details['formData']['hoursClause']? "Yes" : "No";
        $questions_array[] = 'Nominated Loss Adjuster Clause';
        $answes_array[] = $pipeline_details['formData']['lossAdj']? "Yes" : "No";
        $questions_array[] = 'Primary Insurance Clause';
        $answes_array[] = $pipeline_details['formData']['primaryClause']? "Yes" : "No";
        $questions_array[] = 'Payment on accounts clause-75%';
        $answes_array[] = $pipeline_details['formData']['paymentAccount']? "Yes" : "No";
        $questions_array[] = '85% condition of average';
        $answes_array[] = $pipeline_details['formData']['avgCondition']? "Yes" : "No";
        $questions_array[] = 'Automatic addition';
        $answes_array[] = $pipeline_details['formData']['autoAddition']? "Yes" : "No";
        $questions_array[] = 'Cancellation clause';
        $answes_array[] = $pipeline_details['formData']['cancelClause']? "Yes" : "No";
        $questions_array[] = 'Removal of debris';
        $answes_array[] = $pipeline_details['formData']['derbis']? "Yes" : "No";
        $questions_array[] = 'Repair investigation clause';
        $answes_array[] = $pipeline_details['formData']['repairClause']? "Yes" : "No";
        $questions_array[] = 'Temporary repair clause';
        $answes_array[] = $pipeline_details['formData']['tempRepair']? "Yes" : "No";
        $questions_array[] = 'Errors & omission clause';
        $answes_array[] = $pipeline_details['formData']['errorOmission']? "Yes" : "No";
        $questions_array[] = 'Minimization of loss';
        $answes_array[] = $pipeline_details['formData']['minLoss']? "Yes" : "No";
        $questions_array[] = 'Including cover for loading/ unloading and delivery risks';
        $answes_array[] = $pipeline_details['formData']['coverInclude']? "Yes" : "No";
        $questions_array[] = 'Towing charges';
        $answes_array[] = $pipeline_details['formData']['towCharge']? "Yes" : "No";
        if (isset($pipeline_details['formData']['affCompany']) && $pipeline_details['formData']['affCompany']!='' && isset($pipeline_details['formData']['crossLiability'])) {
            $questions_array[] = 'Cross liability';
            $answes_array[] = $pipeline_details['formData']['crossLiability']? "Yes" : "No";
        }
        if (isset($pipeline_details['formData']['policyBank']['policyBank']) && $pipeline_details['formData']['policyBank']['policyBank'] ==true && isset($pipeline_details['formData']['lossPayee'])) {
            $questions_array[] = 'Loss payee clause';
            $answes_array[] = $pipeline_details['formData']['lossPayee']? "Yes" : "No";
        }
            $questions_array[] = 'Agency repair';
            $answes_array[] = $pipeline_details['formData']['agencyRepair'];
            $questions_array[] = 'Indemnity to principal';
            $answes_array[] = $pipeline_details['formData']['indemnityPrincipal'];
            $questions_array[] = 'Designation of property';
            $answes_array[] = $pipeline_details['formData']['propDesign']? "Yes" : "No";
            $questions_array[] = "Special condition :It is understood and agreed that exclusion ‘C’ will not apply to accidental losses’";
            $answes_array[] = $pipeline_details['formData']['specialAgree']? "Yes" : "No";
            $questions_array[] = "Declaration of sum insured and basis of settlement: Total loss claims will be settled on the current market value of the vehicle on the day of accident and insured should submit 3 valuation report for consideration of loss surveyor";
            $answes_array[] = $pipeline_details['formData']['declarationSum']? "Yes" : "No";
            $questions_array[] = "Salvage: In case of total loss Insurer will give the option to the Insured to purchase the salvage based on the amount of the highest bid obtained by the Insurer";
            $answes_array[] = $pipeline_details['formData']['salvage']? "Yes" : "No";
            $questions_array[] = "Total Loss:An equipment will be considered as total loss (destroyed) in case the repair cost is 50% or more than the NRV of the equipment (considered as constructive total loss)";
            $answes_array[] = $pipeline_details['formData']['totalLoss']? "Yes" : "No";
            $questions_array[] = "Profit Sharing";
            $answes_array[] = $pipeline_details['formData']['profitShare'];
            $questions_array[] = "Claims procedure: Existing claim procedure attached and should form the framework for renewal period";
            $answes_array[] = $pipeline_details['formData']['claimPro'];
            $questions_array[] = "Waiver of subrogation against principal";
            $answes_array[] = $pipeline_details['formData']['waiver'];
            $questions_array[] = "Rate required (in %)";
            $answes_array[] = $pipeline_details['formData']['rate'];
            $questions_array[] = "Premium required (in %)";
            $answes_array[] = $pipeline_details['formData']['premium'];
            $questions_array[] = "Payment Terms";
            $answes_array[] = $pipeline_details['formData']['payTerm'];
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
        Excel::create($file_name_, function ($excel) use ($data) {
            $excel->sheet("Plant & Machinery", function ($sheet) use ($data) {
                $sheet->fromArray($data, null, 'A1', true, false);
                $sheet->row(1, function ($row) {
                    $row->setFontSize(10);
                    $row->setFontColor('#ffffff');
                    $row->setBackground('#1155CC');
                });
                $sheet->protect('password');
                $sheet->getStyle('C2:D201')->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
                $sheet->setAutoSize(true);
                $sheet->setWidth('A', 70);
                $sheet->getRowDimension(1)->setRowHeight(10);
                $sheet->setWidth('B', 50);
                $sheet->getStyle('A0:A200')->getAlignment()->setWrapText(true);
                $sheet->getStyle('B0:B200')->getAlignment()->setWrapText(true);
            });
        })->store('xls', public_path('excel'));
        return $file_name_;
    }

    /**
     * view quotation
     */
    public function eQuotation($pipeline_id)
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
// dd($id_insurer);
            return view('pipelines.plant_mach.e_quotations')->with(compact('pipeline_details', 'insures_name', 'insures_details', 'insures_id', 'id_insurer'));
        } else {
            return view('error');
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
        return view('pipelines.plant_mach.imported_list', compact('data', 'pipeline_id', 'insurer_id'));
    }

    /**
     * save immported list
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

        foreach ($questions as $key => $question) {
            if ($question == 'Authorised repair limit' &&  isset($pipeline_details['formData']['authRepair'])&& $pipeline_details['formData']['authRepair']!='') {
                $authRepair_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $authRepair_object->isAgree = ucwords($insurer_response_array[$key]);
                $authRepair_object->comment = ucwords($comments);
                $insurerReplay_object->authRepair = $authRepair_object;
            }
            if ($question == 'Strike, riot and civil commotion and malicious damage') {
                $strikeRiot_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $strikeRiot_object->isAgree = ucwords($insurer_response_array[$key]);
                $strikeRiot_object->comment = ucwords($comments);
                $insurerReplay_object->strikeRiot = $strikeRiot_object;
            }
            if ($question == 'Overtime, night works , works on public holidays and express freight') {
                $overtime_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $overtime_object->isAgree = ucwords($insurer_response_array[$key]);
                $overtime_object->comment = ucwords($comments);
                $insurerReplay_object->overtime = $overtime_object;
            }
            if ($question == 'Cover for extra charges for Airfreight') {
                $coverExtra_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $coverExtra_object->isAgree = ucwords($insurer_response_array[$key]);
                $coverExtra_object->comment = ucwords($comments);
                $insurerReplay_object->coverExtra = $coverExtra_object;
            }
            if ($question == 'Cover for underground Machinery and equipment') {
                $insurerReplay_object->coverUnder = ucwords($insurer_response_array[$key]);
            }
            if ($question == 'Cover for water well drilling rigs and equipment' && isset($pipeline_details['formData']['drillRigs'])&& $pipeline_details['formData']['drillRigs']==true) {
                $insurerReplay_object->drillRigs = ucwords($insurer_response_array[$key]);
            }
            if ($question == 'Inland Transit including loading and unloading cover') {
                $inlandTransit_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $inlandTransit_object->isAgree = ucwords($insurer_response_array[$key]);
                $inlandTransit_object->comment = ucwords($comments);
                $insurerReplay_object->inlandTransit = $inlandTransit_object;
            }
            if ($question == 'Transit and Road risks whilst the insured items are travelling/transporting on own power on public roads') {
                $transitRoad_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $transitRoad_object->isAgree = ucwords($insurer_response_array[$key]);
                $transitRoad_object->comment = ucwords($comments);
                $insurerReplay_object->transitRoad = $transitRoad_object;
            }
            if ($question == 'Third Party Liability- whilst on site, owned and/or hired parking yard, during participation in any sales promotions, sports, social events, display at various sites within GCC either contract of hire or otherwise') {
                $thirdParty_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $thirdParty_object->isAgree = ucwords($insurer_response_array[$key]);
                $thirdParty_object->comment = ucwords($comments);
                $insurerReplay_object->thirdParty = $thirdParty_object;
            }
            if ($question == 'Cover when items are hired out' && isset($pipeline_details['formData']['machEquip']['machEquip']) &&
                $pipeline_details['formData']['machEquip']['machEquip'] == true && isset($pipeline_details['formData']['coverHired'])) {
                    $insurerReplay_object->coverHired = ucwords($insurer_response_array[$key]);
            }
         
            if ($question == 'Automatic Reinstatement of sum insured') {
                $autoSum_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $autoSum_object->isAgree = ucwords($insurer_response_array[$key]);
                $autoSum_object->comment = ucwords($comments);
                $insurerReplay_object->autoSum = $autoSum_object;
            }
            if ($question == 'Including the risk of erection, resettling and dismantling') {
                $insurerReplay_object->includRisk = ucwords($insurer_response_array[$key]);
            }
            if ($question == 'Tool of trade extension') {
                $tool_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $tool_object->isAgree = ucwords($insurer_response_array[$key]);
                $tool_object->comment = ucwords($comments);
                $insurerReplay_object->tool = $tool_object;
            }
            if ($question == '72 Hours clause') {
                $insurerReplay_object->hoursClause = ucwords($insurer_response_array[$key]);
            }
            if ($question == 'Nominated Loss Adjuster Clause') {
                $lossAdj_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $lossAdj_object->isAgree = ucwords($insurer_response_array[$key]);
                $lossAdj_object->comment = ucwords($comments);
                $insurerReplay_object->lossAdj = $lossAdj_object;
            }
            if ($question == 'Primary Insurance Clause') {
                $insurerReplay_object->primaryClause = ucwords($insurer_response_array[$key]);
            }
            if ($question == 'Payment on accounts clause-75%') {
                $paymentAccount_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $paymentAccount_object->isAgree = ucwords($insurer_response_array[$key]);
                $paymentAccount_object->comment = ucwords($comments);
                $insurerReplay_object->paymentAccount = $paymentAccount_object;
            }
            if ($question == '85% condition of average') {
                $insurerReplay_object->avgCondition = ucwords($insurer_response_array[$key]);
            }
            if ($question == 'Automatic addition') {
                $autoAddition_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $autoAddition_object->isAgree = ucwords($insurer_response_array[$key]);
                $autoAddition_object->comment = ucwords($comments);
                $insurerReplay_object->autoAddition = $autoAddition_object;
            }
            if ($question == 'Cancellation clause') {
                $cancelClause_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $cancelClause_object->isAgree = ucwords($insurer_response_array[$key]);
                $cancelClause_object->comment = ucwords($comments);
                $insurerReplay_object->cancelClause = $cancelClause_object;
            }
            if ($question == 'Removal of debris') {
                $derbis_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $derbis_object->isAgree = ucwords($insurer_response_array[$key]);
                $derbis_object->comment = ucwords($comments);
                $insurerReplay_object->derbis = $derbis_object;
            }
            if ($question == 'Repair investigation clause') {
                $repairClause_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $repairClause_object->isAgree = ucwords($insurer_response_array[$key]);
                $repairClause_object->comment = ucwords($comments);
                $insurerReplay_object->repairClause = $repairClause_object;
            }
            if ($question == 'Temporary repair clause') {
                $tempRepair_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $tempRepair_object->isAgree = ucwords($insurer_response_array[$key]);
                $tempRepair_object->comment = ucwords($comments);
                $insurerReplay_object->tempRepair = $tempRepair_object;
            }
            if ($question == 'Errors & omission clause') {
                $insurerReplay_object->errorOmission =  ucwords($insurer_response_array[$key]);
            }
            if ($question == 'Minimization of loss') {
                $minLoss_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $minLoss_object->isAgree = ucwords($insurer_response_array[$key]);
                $minLoss_object->comment = ucwords($comments);
                $insurerReplay_object->minLoss = $minLoss_object;
            }
            if ($question == 'Including cover for loading/ unloading and delivery risks') {
                $insurerReplay_object->coverInclude = ucwords($insurer_response_array[$key]);
            }
            if ($question == 'Towing charges') {
                $towCharge_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $towCharge_object->isAgree = ucwords($insurer_response_array[$key]);
                $towCharge_object->comment = ucwords($comments);
                $insurerReplay_object->towCharge = $towCharge_object;
            }
            if (isset($pipeline_details['formData']['affCompany']) && $pipeline_details['formData']['affCompany']!='' && isset($pipeline_details['formData']['crossLiability']) && ($question == 'Cross liability')) {
                $crossLiability_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $crossLiability_object->isAgree = ucwords($insurer_response_array[$key]);
                $crossLiability_object->comment = ucwords($comments);
                $insurerReplay_object->crossLiability = $crossLiability_object;
            }
            if ($question == 'Agency repair') {
                $agencyRepair_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $agencyRepair_object->isAgree = ucwords($insurer_response_array[$key]);
                $agencyRepair_object->comment = ucwords($comments);
                $insurerReplay_object->agencyRepair = $agencyRepair_object;
            }
            if (isset($pipeline_details['formData']['policyBank']['policyBank']) && $pipeline_details['formData']['policyBank']['policyBank'] ==true && $question == 'Loss payee clause' && isset($pipeline_details['formData']['lossPayee'])) {
                $insurerReplay_object->lossPayee = ucwords($insurer_response_array[$key]);
            }
            if ($question == 'Indemnity to principal') {
                $insurerReplay_object->indemnityPrincipal = ucwords($insurer_response_array[$key]);
            }
            if ($question == 'Designation of property') {
                $insurerReplay_object->propDesign = ucwords($insurer_response_array[$key]);
            }
            if ($question == "Special condition :It is understood and agreed that exclusion ‘C’ will not apply to accidental losses’") {
                $insurerReplay_object->specialAgree = ucwords($insurer_response_array[$key]);
            }
            if ($question == "Declaration of sum insured and basis of settlement: Total loss claims will be settled on the current market value of the vehicle on the day of accident and insured should submit 3 valuation report for consideration of loss surveyor") {
                $declarationSum_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $declarationSum_object->isAgree = ucwords($insurer_response_array[$key]);
                $declarationSum_object->comment = ucwords($comments);
                $insurerReplay_object->declarationSum = $declarationSum_object;
            }
            if ($question == "Salvage: In case of total loss Insurer will give the option to the Insured to purchase the salvage based on the amount of the highest bid obtained by the Insurer") {
                $salvage_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $salvage_object->isAgree = ucwords($insurer_response_array[$key]);
                $salvage_object->comment = ucwords($comments);
                $insurerReplay_object->salvage = $salvage_object;
            }
            if ($question == "Total Loss:An equipment will be considered as total loss (destroyed) in case the repair cost is 50% or more than the NRV of the equipment (considered as constructive total loss)") {
                $totalLoss_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $totalLoss_object->isAgree = ucwords($insurer_response_array[$key]);
                $totalLoss_object->comment = ucwords($comments);
                $insurerReplay_object->totalLoss = $totalLoss_object;
            }
            if ($question == "Profit Sharing") {
                $profitShare_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $profitShare_object->isAgree = ucwords($insurer_response_array[$key]);
                $profitShare_object->comment = ucwords($comments);
                $insurerReplay_object->profitShare = $profitShare_object;
            }
            if ($question == "Claims procedure: Existing claim procedure attached and should form the framework for renewal period") {
                $claimPro_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $claimPro_object->isAgree = ucwords($insurer_response_array[$key]);
                $claimPro_object->comment = ucwords($comments);
                $insurerReplay_object->claimPro = $claimPro_object;
            }
            if ($question == "Waiver of subrogation against principal") {
                $insurerReplay_object->waiver = ucwords($insurer_response_array[$key]);
            }
            if ($question == 'Rate required (in %)') {
                if ($insurer_response_array[$key] >= 0 && $insurer_response_array[$key] <= 100) {
                    $insurerReplay_object->rate = ucwords($insurer_response_array[$key]);
                } else {
                    return response()->json(['success' => 'failed', "pipeline_id" => $pipeline_details->_id]);
                }
            }
            if ($question == 'Premium required (in %)') {
                if ($insurer_response_array[$key] >= 0 && $insurer_response_array[$key] <= 100) {
                    $insurerReplay_object->premium = ucwords($insurer_response_array[$key]);
                } else {
                    return response()->json(['success' => 'failed', "pipeline_id" => $pipeline_details->_id]);
                }
            }
            if ($question == 'Payment Terms') {
                    $insurerReplay_object->payTerm = ucwords($insurer_response_array[$key]);
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
     * quote ammend page
     */
    public function quotAmend(Request $request)
    {
        try {
            $uniqueToken = $request->input('token');
            $id = $request->input('id');
            $field = $request->input('field');
            $new_quot = $request->input('new_quot');
            $pipelineDetails = PipelineItems::find($id);
            if ($pipelineDetails) {
                $replies = $pipelineDetails->insurerReplay;
                foreach ($replies as $key => $reply) {
                    if ($reply['uniqueToken']==$uniqueToken) {
                        if ($field == 'coverUnder' && $field == 'drillRigs' && $field == 'includRisk' && $field == 'coverHired' && $field == 'hoursClause'
                            && $field == 'primaryClause' && $field == 'avgCondition' && $field == 'errorOmission' && $field == 'coverInclude'
                            && $field == 'specialAgree' && $field == 'rate' && $field == 'premium' && $field == 'payTerm'
                            && $field == 'waiver' && $field == 'indemnityPrincipal' && $field == 'lossPayee' && $field == 'propDesign') {
                            $amend_object = new \stdClass();
                            $amend_object->amendedBy = new ObjectId(Auth::id());
                            $amend_object->name = Auth::user()->name;
                            $amend_object->field = $field;
                            $amend_object->oldQuot = $old_quot;
                            $amend_object->newQuot = $new_quot;
                            $item = PipelineItems::where('_id', $id)->first();
                            $item->push('insurerReplay.'.$key.'.amendmentDetails' , $amend_object);
                            $updatedBy_obj = new \stdClass();
                            $updatedBy_obj->id = new ObjectID(Auth::id());
                            $updatedBy_obj->name = Auth::user()->name;
                            $updatedBy_obj->date = date('d/m/Y');
                            $updatedBy_obj->action = "Quote amended";
                            $updatedBy[] = $updatedBy_obj;
                            $item->push('updatedBy', $updatedBy);
                            $item->save();
                            PipelineItems::where('_id', $id)->update(array('insurerReplay.'.$key.'.'.$field => $new_quot));
                        } else {
                            if ($request->get('comment') == "") {
                                $old_quot = $reply[$field]['isAgree'];
                                $amend_object = new \stdClass();
                                $amend_object->amendedBy = new ObjectId(Auth::id());
                                $amend_object->name = Auth::user()->name;
                                $amend_object->field = $field;
                                $amend_object->oldQuot = $old_quot;
                                $amend_object->newQuot = $new_quot;
                                $item = PipelineItems::where('_id', $id)->first();
                                $item->push('insurerReplay.'.$key.'.amendmentDetails' , $amend_object);
                                $updatedBy_obj = new \stdClass();
                                $updatedBy_obj->id = new ObjectID(Auth::id());
                                $updatedBy_obj->name = Auth::user()->name;
                                $updatedBy_obj->date = date('d/m/Y');
                                $updatedBy_obj->action = "Quote amended";
                                $updatedBy[] = $updatedBy_obj;
                                $item->push('updatedBy', $updatedBy);
                                $item->save();
                                PipelineItems::where('_id', $id)->update(array('insurerReplay.'.$key.'.'.$field.'.isAgree' => $new_quot));
                            } else {
                                $old_quot ="Comment : ". $reply[$field]['comment'];
                                $amend_object = new \stdClass();
                                $amend_object->amendedBy = new ObjectId(Auth::id());
                                $amend_object->name = Auth::user()->name;
                                $amend_object->field = $field;
                                $amend_object->oldQuot = $old_quot;
                                $amend_object->newQuot ="Comment : ". $new_quot;
                                $item = PipelineItems::where('_id', $id)->first();
                                $item->push('insurerReplay.'.$key.'.amendmentDetails' , $amend_object);
                                $updatedBy_obj = new \stdClass();
                                $updatedBy_obj->id = new ObjectID(Auth::id());
                                $updatedBy_obj->name = Auth::user()->name;
                                $updatedBy_obj->date = date('d/m/Y');
                                $updatedBy_obj->action = "Quote amended";
                                $updatedBy[] = $updatedBy_obj;
                                $item->push('updatedBy', $updatedBy);
                                $item->save();
                                PipelineItems::where('_id', $id)->update(array('insurerReplay.'.$key.'.'.$field.'.comment' => $new_quot));
                            }
                        }
                    }
                }
            }
            return 'success';
          } catch (\Exception $e) {
            return 'failed';
        }

    }

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
// dd($insures_details);
            return view('pipelines.plant_mach.e_comparison')->with(compact('pipeline_details', 'selectedId', 'insures_details'));
        } else {
            return view('error');
        }
    }

    /**
     * send comparison to customer 
     */
    public function viewComparison($token)
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
            return view('pipelines.plant_mach.customer_e_comparison')->with(compact('pipeline_details', 'insures_details', 'selectedId'));
        } else {
            return view('error');
        }
    }
     /**
     * Function for save as PDF
     */
    public function comparisonPdf($pipelineId)
    {
        $pipeline_details = PipelineItems::find($pipelineId);
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
        $pdf = PDF::loadView('pipelines.plant_mach.e_comparison_pdf', ['pipeline_details' => $pipeline_details, 'selectedId' => $selectedId, 'insures_details' => $insures_details])->setPaper('a3')->setOrientation('landscape')->setOption('margin-bottom', 0);
        $pdf_name = 'e_comparison_' . time() . '_' . $pipelineId . '.pdf';
        $pdf->setOption('margin-top', 5);
        $pdf->setOption('margin-bottom', 5);
        $pdf->setOption('margin-left', 0);
        $pdf->setOption('margin-right', 0);
        $temp_path = public_path('pdf/' . $pdf_name);
        $pdf->save('pdf/' . $pdf_name);
        $pdf_file = $this->uploadFileToCloud_file($pdf_name, $temp_path);
        unlink($temp_path);
        $comparison_file_object = new \stdClass();
        $comparison_file_object->name = $pdf_name;
        $comparison_file_object->url = $pdf_file;
        $comparison_file_object->date = (string) date('d/m/Y');
        $pipeline_details->push('comparisonUploads', $comparison_file_object);
        $pipeline_details->save();
        return $pdf->inline($pdf_name);
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
            return view('pipelines.plant_mach.quote_amendment')->with(compact('pipeline_details', 'insures_details', 'selectedId'));
        } else {
            return view('error');
        }
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
            return view('pipelines.plant_mach.approved_quot')->with(compact('pipelineId', 'pipeline_details', 'insures_details'));
        }
    }
      /**
     * Function for display issuance page
     */
    public function issuance($pipelineId)
    {
        $pipeline_details = PipelineItems::find($pipelineId);
        if ($pipeline_details['status']['status'] == 'Worktype Created' || $pipeline_details['status']['status'] == 'E-questionnaire' || $pipeline_details['status']['status'] == 'E-slip' || $pipeline_details['status']['status'] == 'E-quotation'
            || $pipeline_details['status']['status'] == 'Quote Amendment' || $pipeline_details['status']['status'] == 'E-comparison') {
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
            return view('pipelines.plant_mach.issuance')->with(compact('pipelineId', 'pipeline_details', 'insures_details'));
        }
    }

     /**
     * view pending list page
     */
    public function viewPendingDetails($pipelineId)
    {
        $pipeline_details = PipelineItems::find($pipelineId);
        if (!$pipelineId) {
            return view('error');
        }
        if ($pipeline_details->pipelineStatus != "pending") {
            return view('error');
        }
        if ($pipeline_details) {
            $insurerReplay = $pipeline_details['insurerReplay'];
            foreach ($insurerReplay as $insures_rep) {
                if (isset($insures_rep['customerDecision'])) {
                    if ($insures_rep['quoteStatus'] == 'active' && @$insures_rep['customerDecision']['decision'] == 'Approved') {
                        $insures_details = $insures_rep;
                    }
                }
            }
            return view('pipelines.plant_mach.view_pending_details')->with(compact('pipelineId', 'pipeline_details', 'insures_details'));
        }
    }
    /**
     * @param $pipelineId
     * view policy
     */
    public function viewPolicyDetails($pipelineId)
    {
        $pipeline_details = PipelineItems::find($pipelineId);
        if (!$pipeline_details) {
            return view('error');
        }
        if ($pipeline_details->pipelineStatus != "approved") {
            return view('error');
        } else {
            $insurerReplay = $pipeline_details['insurerReplay'];
            foreach ($insurerReplay as $insures_rep) {
                if ($insures_rep['quoteStatus'] == 'active' && @$insures_rep['customerDecision']['decision'] == 'Approved') {
                    $insures_details = $insures_rep;
                }
            }
            return view('pipelines.plant_mach.worksman_issuance')->with(compact('pipelineId', 'pipeline_details', 'insures_details'));
        }
    }

}
