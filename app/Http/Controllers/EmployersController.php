<?php

namespace App\Http\Controllers;

use App\CountryListModel;
use App\Customer;
use App\ImportExcel;
use App\Insurer;
use App\Jobs\EslipSubmittedReminder;
use App\Jobs\SendQuestionnaire;
use App\PipelineItems;
use App\PipelineStatus;
use App\State;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;
use Maatwebsite\Excel\Facades\Excel;
use MongoDB\BSON\ObjectID;
use PDF;

class EmployersController extends Controller
{
    /**
     * @param $eQuestionnaireid
     * VIEW E QUESTIONNAIRE
     */
    public function __construct()
    {
        $this->middleware('auth.underwriter', ['except' => [ 'equestionnaireSave', 'decisionSave','viewComparison']]);
    }
    public function eQuestionnaire($eQuestionnaireid)
    {
        $PipelineItems = PipelineItems::find($eQuestionnaireid);
        if ($PipelineItems->pipelineStatus != 'true') {
            return view('error');
        }
        $country_name = [];
        $country_name_place = [];
        $all_emirates = State::all();

        //	    if(($PipelineItems['formData']) && (isset($PipelineItems['formData']['addressDetails']['country']))){
        //		    $country=$PipelineItems['formData']['addressDetails']['country'];
        //		    $all_countries=CountryListModel::where('country.countryName',$country)->first();
        //		    $name=$all_countries['country'];
        //		    $country_name[]=$name['countryName'];
        //	    }else if(empty($PipelineItems['formData']) && !empty($PipelineItems->getCustomer->countryName))
        //	    {
        //		    $country=$PipelineItems->getCustomer->countryName;
        //		    $all_countries=CountryListModel::where('country.countryName',$country)->first();
        //		    $name=$all_countries['country'];
        //		    $country_name[]=$name['countryName'];
        //	    }
        //	    else {
        $all_countries = CountryListModel::get();
        foreach ($all_countries as $key => $country) {
            $name = $country['country'];
            $country_name[] = $name['countryName'];
        }
        //	    }
        //	    if(($PipelineItems['formData']) && (isset($PipelineItems['formData']['placeOfEmployment'])) && (!empty($PipelineItems['formData']['placeOfEmployment']['countryName']))){
        //		    $country1=$PipelineItems['formData']['placeOfEmployment']['countryName'];
        //		    $all_countriesPlace=CountryListModel::where('country.countryName',$country1)->first();
        //		    $namePlace=$all_countriesPlace['country'];
        //		    $country_name_place[]=$namePlace['countryName'];
        //	    }
        //	    else {
        //		    $all_countriesPlace=CountryListModel::take(10)->get();
        //		    foreach ($all_countriesPlace as $key=>$country)
        //		    {
        //			    $namePlace=$country['country'];
        //			    $country_name_place[]=$namePlace['countryName'];
        //		    }
        //	    }
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
            return view('pipelines.employers_liability.e_questionnaire')->with(compact('country_name_place', 'country_name', 'all_emirates', 'eQuestionnaireid', 'form_data', 'PipelineItems', 'customer_details', 'all_insurers', 'file_name', 'file_url'));
        } else {
            return view('error');
        }
    }

    /**
     * save e questionnaire.
     */
    public static function eQuestionnaireSave(Request $request)
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
                    $policy = (bool) true;
                    $existingRate = str_replace(',', '', $request->input('existingRate'));
                    $currentInsurer = $request->input('currentInsurer');
                }
                if ($request->input('hasExistingPolicy') == 'no') {
                    $policy = (bool) false;
                    $existingRate = '';
                    $currentInsurer = '';
                }
                $existing_policy_object->hasExistingPolicy = $policy;
                $existing_policy_object->existingRate = $existingRate;
                $existing_policy_object->currentInsurer = $currentInsurer;
                $formdata->existingPolicyDetails = $existing_policy_object;
            } else {
                $existing_policy_object = '';
            }
            $place_employement_object = new \stdClass();
            if ($request->input('withinUAE') != '') {
                $withinUAE = $request->input('withinUAE');
                if ($withinUAE == 'WithinUAE') {
                    $emirateName = $request->input('emirateName');
                    $countryName = '';
                    $withinUAE_status = (bool) true;
                } elseif ($withinUAE == 'OutsideUAE') {
                    $emirateName = '';
                    $countryName = $request->input('countryName');
                    $withinUAE_status = (bool) false;
                }
                $place_employement_object->withinUAE = $withinUAE_status;
                $place_employement_object->emirateName = $emirateName;
                $place_employement_object->countryName = $countryName;
                $formdata->placeOfEmployment = $place_employement_object;
            } else {
                $place_employement_object = '';
            }
            $policy_period_object = new \stdClass();
            $policy_period_object->policyFrom = $request->input('policyFrom');
            $policy_period_object->policyTo = $request->input('policyTo');
            $formdata->policyPeriod = $policy_period_object;

            $employee_details_object = new \stdClass();
            $hasAdmin = $request->input('hasAdmin');
            if ($hasAdmin != null) {
                if ($hasAdmin == 'admin_employees') {
                    $admin_true = (bool) true;
                    $nonadmin_true = (bool) false;
                    $adminCount = $request->input('adminCount');
                    $adminAnnualWages = str_replace(',', '', $request->input('adminAnnualWages'));
                    $nonadminCount = '';
                    $nonadminAnnualWages = '';
                } elseif ($hasAdmin == 'non_admin_employees') {
                    $admin_true = (bool) false;
                    $nonadmin_true = (bool) true;
                    $nonadminCount = $request->input('nonAdminCount');
                    $nonadminAnnualWages = str_replace(',', '', $request->input('nonAdminAnnualWages'));
                    $adminCount = '';
                    $adminAnnualWages = '';
                } elseif ($hasAdmin == 'both_employees') {
                    $admin_true = (bool) true;
                    $nonadmin_true = (bool) true;
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
            $hired_details_object = new \stdClass();
            if ($request->input('work_labour') != '') {
                if ($request->input('work_labour') == 'hired_workers') {
                    $status_details = (bool) true;
                } else {
                    $status_details = (bool) false;
                }
                $hired_details_object->hasHiredWorkers = $status_details;
                if ($status_details == true) {
                    $hired_details_object->noOfLabourers = $request->input('noOfLabourers');
                    $hired_details_object->annualWages = str_replace(',', '', $request->input('annualWages'));
                } else {
                    $hired_details_object->noOfLabourers = '';
                    $hired_details_object->annualWages = '';
                }
                $formdata->hiredWorkersDetails = $hired_details_object;
            } else {
                $hired_details_object = '';
            }
            $offshore_object = new \stdClass();
            if ($request->input('offshore') != '') {
                if ($request->input('offshore') == 'offshore_employees') {
                    $status_offshore = (bool) true;
                } else {
                    $status_offshore = (bool) false;
                }
                $offshore_object->hasOffShoreEmployees = $status_offshore;
                if ($status_offshore == true) {
                    $offshore_object->noOfLabourers = $request->input('offshoreNoOfLabourers');
                    $offshore_object->annualWages = str_replace(',', '', $request->input('offshoreAnnualWages'));
                } else {
                    $offshore_object->noOfLabourers = '';
                    $offshore_object->annualWages = '';
                }
                $formdata->offShoreEmployeeDetails = $offshore_object;
            } else {
                $offshore_object = '';
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
                if ($request->input('filler_type') != 'fill_customer') {
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
                                $comment_object->userType = 'General & Marine';
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
                        $comment_object->userType = 'Customer';
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
                if ($request->input('is_edit') == '0') {
                    $updatedBy_obj = new \stdClass();
                    $updatedBy_obj->id = new ObjectID(Auth::id());
                    $updatedBy_obj->name = Auth::user()->name;
                    $updatedBy_obj->date = date('d/m/Y');
                    $updatedBy_obj->action = 'E questionnaire saved as draft';
                    $updatedBy[] = $updatedBy_obj;
                    $questionnaire->push('files', $file);
                    $questionnaire->push('updatedBy', $updatedBy);
                    $questionnaire->save();

                    return 'success';
                }
            }
            if ($request->input('filler_type') == 'fill_customer') {
                $status = 0;
                if ($request->input('is_edit') == '0') {
                    $departments = $questionnaire->getCustomer['departmentDetails'];
                    if (isset($departments)) {
                        foreach ($departments as $department) {
                            if ($department['departmentName'] == 'Genaral & Marine') {
                                $questionnaire->filledBy = (string) 'Genaral & Marine Department';
                                $updatedBy_obj = new \stdClass();
                                $updatedBy_obj->id = new ObjectID($department['department']);
                                $updatedBy_obj->name = 'Genaral & Marine ('.$department['depContactPerson'].')';
                                $updatedBy_obj->date = date('d/m/Y');
                                $updatedBy_obj->action = 'E questionnaire filled';
                                $updatedBy[] = $updatedBy_obj;
                                $status = 1;
                                break;
                            }
                        }
                    }
                    if ($status == 0) {
                        $questionnaire->filledBy = (string) 'Customer';
                        $updatedBy_obj = new \stdClass();
                        $updatedBy_obj->id = new ObjectID($questionnaire->getCustomer['_id']);
                        $updatedBy_obj->name = 'Customer ('.$questionnaire->getCustomer['firstName'].')';
                        $updatedBy_obj->date = date('d/m/Y');
                        $updatedBy_obj->action = 'E questionnaire filled';
                        $updatedBy[] = $updatedBy_obj;
                    }
                    $questionnaire->tokenStatus = 'inactive';
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
                                $pipeline_status_object->UpdatedByName = 'Genaral & Marine ('.$department['depContactPerson'].')';
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
                        $pipeline_status_object->UpdatedByName = 'Customer ('.$questionnaire->getCustomer['firstName'].')';
                        $pipeline_status_object->date = date('d/m/Y');
                        $questionnaire->status = $pipeline_status_object;
                    }
                }
            } else {
                if ($request->input('is_edit') == '0') {
                    $updatedBy_obj = new \stdClass();
                    $updatedBy_obj->id = new ObjectID(Auth::id());
                    $updatedBy_obj->name = Auth::user()->name;
                    $updatedBy_obj->date = date('d/m/Y');
                    $updatedBy_obj->action = 'E questionnaire filled';
                    $updatedBy[] = $updatedBy_obj;
                    if (isset($questionnaire->tokenStatus)) {
                        $questionnaire->tokenStatus = 'inactive';
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
            if ($request->input('is_edit') == '0') {
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
                    if (isset($questionnaire1['formData']['hiredWorkersDetails']['hasHiredWorkers'])) {
                        if ($questionnaire1['formData']['hiredWorkersDetails']['hasHiredWorkers'] == false) {
                            DB::collection('pipelineItems')->where('_id', new ObjectId($request->input('id')))->unset('formData.hiredCheck');
                        } else {
                            DB::collection('pipelineItems')->where('_id', new ObjectId($request->input('id')))->update(['formData.hiredCheck' => true]);
                        }
                    }
                }
                //			    if(isset($questionnaire1['formData']['offShoreEmployeeDetails']))
                //			    {
                //				    if($questionnaire1['formData']['offShoreEmployeeDetails']['hasOffShoreEmployees']==false)
                //				    {
                //					    DB::collection('pipelineItems')->where('_id', new ObjectId($request->input('id')))->unset('formData.offshoreCheck');
                //				    }
                //				    else{
                //					    DB::collection('pipelineItems')->where('_id', new ObjectId($request->input('id')))->update(['formData.offshoreCheck'=>true]);
                //				    }
//
                //			    }

                if (@$questionnaire1['formData']['businessType'] == 'Bridges & tunnels' || @$questionnaire1['formData']['businessType'] == 'Builders/ general contractors' ||
                    @$questionnaire1['formData']['businessType'] == 'Infrastructure' || @$questionnaire1['formData']['businessType'] == 'Rail roads & related infrastructure') {
                    DB::collection('pipelineItems')->where('_id', new ObjectId($request->input('id')))->update(['formData.waiverOfSubrogation' => true, 'formData.indemnityToPrincipal' => true]);
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
                    $updatedBy_obj->action = 'E questionnaire saved as draft';
                    $updatedByedit[] = $updatedBy_obj;
                    PipelineItems::where('_id', new ObjectId($request->input('id')))->push('updatedBy', $updatedByedit);

                    return 'success';
                }
                if ($request->input('filler_type') != 'fill_customer') {
                    $updatedBy_obj = new \stdClass();
                    $updatedBy_obj->id = new ObjectID(Auth::id());
                    $updatedBy_obj->name = Auth::user()->name;
                    $updatedBy_obj->date = date('d/m/Y');
                    $updatedBy_obj->action = 'E questionnaire updated';
                    $updatedByedit[] = $updatedBy_obj;
                    PipelineItems::where('_id', new ObjectId($request->input('id')))->push('updatedBy', $updatedByedit);
                } else {
                    $status = 0;
                    $departments = $questionnaire->getCustomer['departmentDetails'];
                    if (isset($departments)) {
                        foreach ($departments as $department) {
                            if ($department['departmentName'] == 'Genaral & Marine') {
                                $questionnaire->filledBy = (string) 'Genaral & Marine Department';
                                $updatedBy_obj = new \stdClass();
                                $updatedBy_obj->id = new ObjectID($department['department']);
                                $updatedBy_obj->name = 'Genaral & Marine ('.$department['depContactPerson'].')';
                                $updatedBy_obj->date = date('d/m/Y');
                                $updatedBy_obj->action = 'E questionnaire filled';
                                PipelineItems::where('_id', new ObjectId($request->input('id')))->push('updatedBy', $updatedBy_obj);
                                $status = 1;
                                break;
                            }
                        }
                    }
                    if ($status == 0) {
                        $questionnaire->filledBy = (string) 'Customer';
                        $updatedBy_obj = new \stdClass();
                        $updatedBy_obj->id = new ObjectID($questionnaire->getCustomer['_id']);
                        $updatedBy_obj->name = 'Customer ('.$questionnaire->getCustomer['firstName'].')';
                        $updatedBy_obj->date = date('d/m/Y');
                        $updatedBy_obj->action = 'E questionnaire filled';
                        PipelineItems::where('_id', new ObjectId($request->input('id')))->push('updatedBy', $updatedBy_obj);
                    }
                }
                if ($request->input('filler_type') != 'fill_customer') {
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
                        $pipeline->tokenStatus = 'inactive';
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
                        $pipeline->tokenStatus = 'inactive';
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
                                $pipeline_status_object->UpdatedByName = 'Genaral & Marine ('.$department['depContactPerson'].')';
                                $pipeline_status_object->date = date('d/m/Y');
                                $pipeline->status = $pipeline_status_object;
                                $pipeline->tokenStatus = 'inactive';
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
                        $pipeline_status_object->UpdatedByName = 'Customer ('.$questionnaire->getCustomer['firstName'].')';
                        $pipeline_status_object->date = date('d/m/Y');
                        $pipeline->status = $pipeline_status_object;
                        $pipeline->tokenStatus = 'inactive';
                        $pipeline->save();
                    }
                }
            }

            if ($request->input('filler_type') != 'fill_customer') {
                Session::flash('status', 'Questionnaire added successfully.');

                return 'success';
            } else {
                Session::flash('msg', 'E-questionnaire successfully added');

                return redirect('customer-notification');
            }
        } catch (\Exception $e) {
            if ($request->input('filler_type') != 'fill_customer.') {
                return back()->withInput()->with('status', 'Failed');
            } else {
                Session::flash('msg', 'E-questionnaire is failed to add.');

                return redirect('customer-notification');
            }
        }
    }

    /**
     * view slip page.
     */
    public function eSlip($worktype_id)
    {
        $pipeline_details = PipelineItems::find($worktype_id);
        if ($pipeline_details['status']['status'] == 'Worktype Created' || $pipeline_details['status']['status'] == 'E-questionnaire') {
            return view('error');
        }
        if ($pipeline_details->pipelineStatus != 'true') {
            return view('error');
        }
        if ($pipeline_details) {
            return view('pipelines.employers_liability.e_slip')->with(compact('worktype_id', 'pipeline_details'));
        } else {
            return view('error');
        }
    }

    /**
     * save eslip details.
     */
    public function eslipSave(Request $request)
    {
        try {
            if ($request->input('is_save') != 'true') {
                //			    $scale_value = $request->input('scale');
                //			    if ($scale_value == 'uae_law') {
                //				    $asPerUAELaw = true;
                //				    $isPTD = false;
                //			    } else if ($scale_value == 'as_ptd') {
                //				    $asPerUAELaw = false;
                //				    $isPTD = true;
                //			    }
                //			    $scale_object = new \stdClass();
                //			    $scale_object->asPerUAELaw = $asPerUAELaw;
                //			    $scale_object->isPTD = $isPTD;
                //	        var_dump($request->input('HoursPAC') =='yes' ? true : false);
                //	        die();
                $pipeline_details = PipelineItems::find(new ObjectId($request->input('eslip_id')));
                if (@$pipeline_details['formData']['businessType'] == 'Bridges & tunnels' || @$pipeline_details['formData']['businessType'] == 'Builders/ general contractors' ||
                    @$pipeline_details['formData']['businessType'] == 'Infrastructure' || @$pipeline_details['formData']['businessType'] == 'Rail roads & related infrastructure') {
                    $formdata_object = array(
                        'formData.extendedLiability' => (string) str_replace(',', '', $request->input('extended_liability')),
                        // 'formData.emergencyEvacuation' => $request->input('emergencyEvacuation') == 'yes' ? true : false,
                        // 'formData.empToEmpLiability' => $request->input('empToEmpLiability') == 'yes' ? true : false,
                        // 'formData.errorsOmissions' =>$request->input('errorsOmissions') == 'yes' ? true : false,
                        'formData.crossLiability' => $request->input('crossLiability') == 'yes' ? true : false,
                        'formData.waiverOfSubrogation' => $request->input('waiverOfSubrogation') == 'yes' ? true : false,
                        'formData.automaticClause' => (bool) $request->input('automaticClause') ?: false,
                        'formData.empToEmpLiability' => (bool) $request->input('empToEmpLiability') ?: false,
                        'formData.errorsOmissions' => (bool) $request->input('errorsOmissions') ?: false,
                        'formData.emergencyEvacuation' => (bool) $request->input('emergencyEvacuation') ?: false,
                        'formData.cancellationClause' => (bool) $request->input('cancellationClause') ?: false,
                        'formData.indemnityToPrincipal' => (bool) $request->input('indemnityToPrincipal') ?: false,
                        'formData.lossNotification' => (bool) $request->input('lossNotification') ?: false,
                        'formData.primaryInsuranceClause' => (bool) $request->input('primaryInsuranceClause') ?: false,
                        'formData.travelCover' => (bool) $request->input('travelCover') ?: false,
                        'formData.riotCover' => (bool) $request->input('riotCover') ?: false,
                        'formData.brokersClaimClause' => (bool) $request->input('brokersClaimClause') ?: false,
                        'formData.sepOrCom' => (boolean)($request->input('sepOrCom')== 'yes') ? true : ($request->input('sepOrCom')=='no'? false : null),
                        'formData.rateRequiredAdmin' => (string) $request->input('rateRequiredAdmin'),
                        'formData.rateRequiredNonAdmin' => (string) $request->input('rateRequiredNonAdmin'),
                        'formData.combinedRate' => (string) $request->input('combinedRate'),
                        'formData.brokerage' => (string) $request->input('brokerage'),
                        'formData.warranty' => (string) $request->input('warranty') ?: '',
                        'formData.exclusion' => (string) $request->input('exclusion') ?: '',
                        'formData.specialCondition' => (string) $request->input('specialCondition') ?: '',
                        'formData.excess' => (string) str_replace(',', '', $request->input('excess'))?: '',
                        'formData.hiredCheck' => (bool) $request->input('hiredCheck') ?: false,
                    );
                } else {
                    $formdata_object = array(
                        'formData.extendedLiability' => (string) str_replace(',', '', $request->input('extended_liability')),
                        // 'formData.emergencyEvacuation' => $request->input('emergencyEvacuation') == 'yes' ? true : false,
                        // 'formData.empToEmpLiability' => $request->input('empToEmpLiability') == 'yes' ? true : false,
                        // 'formData.errorsOmissions' =>$request->input('errorsOmissions') == 'yes' ? true : false,
                        // 'formData.crossLiability' => $request->input('crossLiability') == 'yes' ? true : false,
                        'formData.automaticClause' => (bool) $request->input('automaticClause') ?: false,
                        'formData.empToEmpLiability' => (bool) $request->input('empToEmpLiability') ?: false,
                        'formData.errorsOmissions' => (bool) $request->input('errorsOmissions') ?: false,
                        'formData.crossLiability' => (bool) $request->input('crossLiability') ?: false,
                        'formData.emergencyEvacuation' => (bool) $request->input('emergencyEvacuation') ?: false,
                        'formData.cancellationClause' => (bool) $request->input('cancellationClause') ?: false,
                        'formData.lossNotification' => (bool) $request->input('lossNotification') ?: false,
                        'formData.primaryInsuranceClause' => (bool) $request->input('primaryInsuranceClause') ?: false,
                        'formData.travelCover' => (bool) $request->input('travelCover') ?: false,
                        'formData.riotCover' => (bool) $request->input('riotCover') ?: false,
                        'formData.brokersClaimClause' => (bool) $request->input('brokersClaimClause') ?: false,
                        'formData.sepOrCom' => (boolean)($request->input('sepOrCom')== 'yes') ? true : ($request->input('sepOrCom')=='no'? false : null),
                        'formData.rateRequiredAdmin' => (string) $request->input('rateRequiredAdmin'),
                        'formData.rateRequiredNonAdmin' => (string) $request->input('rateRequiredNonAdmin'),
                        'formData.combinedRate' => (string) $request->input('combinedRate'),
                        'formData.brokerage' => (string) $request->input('brokerage'),
                        'formData.warranty' => (string) $request->input('warranty') ?: '',
                        'formData.exclusion' => (string) $request->input('exclusion') ?: '',
                        'formData.specialCondition' => (string) $request->input('specialCondition') ?: '',
                        'formData.excess' => (string)str_replace(',', '', $request->input('excess')) ?: '',
                        'formData.hiredCheck' => (bool) $request->input('hiredCheck') ?: false,
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
                $updatedBy_obj->action = 'E slip';
                $updatedBy[] = $updatedBy_obj;
                DB::collection('pipelineItems')->where('_id', new ObjectId($request->input('eslip_id')))
                    ->update($formdata_object);
                if (isset($pipeline_details['formData']['hiredWorkersDetails'])) {
                    if ($pipeline_details['formData']['hiredWorkersDetails']['hasHiredWorkers'] == false) {
                        DB::collection('pipelineItems')->where('_id', new ObjectId($request->input('eslip_id')))->unset('formData.hiredCheck');
                    }
                }
                //			    if(isset($pipeline_details['formData']['offShoreEmployeeDetails']))
                //			    {
                //				    if($pipeline_details['formData']['offShoreEmployeeDetails']['hasOffShoreEmployees']==false)
                //				    {
                //					    DB::collection('pipelineItems')->where('_id', new ObjectId($request->input('eslip_id')))->unset('formData.offshoreCheck');
                //				    }
                //			    }
                PipelineItems::where('_id', new ObjectId($request->input('eslip_id')))->push('updatedBy', $updatedBy);

                return response()->json(['success' => 'success']);
            } else {
                //			    if($request->input('scale') != null) {
                //				    $scale_value = $request->input('scale');
                //				    if ($scale_value == 'uae_law') {
                //					    $asPerUAELaw = true;
                //					    $isPTD = false;
                //				    } else if ($scale_value == 'as_ptd') {
                //					    $asPerUAELaw = false;
                //					    $isPTD = true;
                //				    }
                //				    $scale_object = new \stdClass();
                //				    $scale_object->asPerUAELaw = $asPerUAELaw;
                //				    $scale_object->isPTD = $isPTD;
                //			    }
                //			    else
                //			    {
                //				    $scale_object = "";
                //			    }
                ////	        var_dump($request->input('HoursPAC') =='yes' ? true : false);
                ////	        die();
                //			    if($request->input('HoursPAC') == 'yes')
                //			    {
                //				    $HoursPAC = true;
                //			    }
                //			    elseif ($request->input('HoursPAC') == 'no')
                //			    {
                //				    $HoursPAC = false;
                //			    }
                //			    else
                //			    {
                //				    $HoursPAC = 'empty';
                //			    }
                //			    if($request->input('herniaCover') == 'yes')
                //			    {
                //				    $herniaCover = true;
                //			    }
                //			    elseif ($request->input('herniaCover') == 'no')
                //			    {
                //				    $herniaCover = false;
                //			    }
                //			    else
                //			    {
                //				    $herniaCover = 'empty';
                //			    }
                if ($request->input('emergencyEvacuation') == 'yes') {
                    $emergencyEvacuation = true;
                } elseif ($request->input('emergencyEvacuation') == 'no') {
                    $emergencyEvacuation = false;
                } else {
                    $emergencyEvacuation = 'empty';
                }
                if ($request->input('legalCost') == 'yes') {
                    $legalCost = true;
                } elseif ($request->input('legalCost') == 'no') {
                    $legalCost = false;
                } else {
                    $legalCost = 'empty';
                }
                if ($request->input('empToEmpLiability') == 'yes') {
                    $empToEmpLiability = true;
                } elseif ($request->input('empToEmpLiability') == 'no') {
                    $empToEmpLiability = false;
                } else {
                    $empToEmpLiability = 'empty';
                }
                if ($request->input('errorsOmissions') == 'yes') {
                    $errorsOmissions = true;
                } elseif ($request->input('errorsOmissions') == 'no') {
                    $errorsOmissions = false;
                } else {
                    $errorsOmissions = 'empty';
                }
                if ($request->input('crossLiability') == 'yes') {
                    $crossLiability = true;
                } elseif ($request->input('crossLiability') == 'no') {
                    $crossLiability = false;
                } else {
                    $crossLiability = 'empty';
                }
                if ($request->input('waiverOfSubrogation') == 'yes') {
                    $waiverOfSubrogation = true;
                } elseif ($request->input('waiverOfSubrogation') == 'no') {
                    $waiverOfSubrogation = false;
                } else {
                    $waiverOfSubrogation = 'empty';
                }

                $pipeline_details = PipelineItems::find(new ObjectId($request->input('eslip_id')));
                if (@$pipeline_details['formData']['businessType'] == 'Bridges & tunnels' || @$pipeline_details['formData']['businessType'] == 'Builders/ general contractors' ||
                    @$pipeline_details['formData']['businessType'] == 'Infrastructure' || @$pipeline_details['formData']['businessType'] == 'Rail roads & related infrastructure') {
                    $formdata_object = array(
                        'formData.extendedLiability' => (string) str_replace(',', '', $request->input('extended_liability')),
                        // 'formData.emergencyEvacuation' => $emergencyEvacuation,
//					    'formData.legalCost' => $legalCost,
                        // 'formData.empToEmpLiability' => $empToEmpLiability,
                        // 'formData.errorsOmissions' =>$errorsOmissions,
                        // 'formData.crossLiability' => $crossLiability,
                        'formData.waiverOfSubrogation' => $waiverOfSubrogation,
                        'formData.empToEmpLiability' => (bool) $request->input('empToEmpLiability') ?: '',
                        'formData.errorsOmissions' => (bool) $request->input('errorsOmissions') ?: '',
                        'formData.crossLiability' => (bool) $request->input('crossLiability') ?: '',
                        'formData.emergencyEvacuation' => (bool) $request->input('emergencyEvacuation') ?: '',
                        'formData.automaticClause' => (bool) $request->input('automaticClause') ?: '',
                        'formData.cancellationClause' => (bool) $request->input('cancellationClause') ?: '',
                        'formData.indemnityToPrincipal' => (bool) $request->input('indemnityToPrincipal') ?: '',
                        'formData.lossNotification' => (bool) $request->input('lossNotification') ?: '',
                        'formData.primaryInsuranceClause' => (bool) $request->input('primaryInsuranceClause') ?: '',
                        'formData.travelCover' => (bool) $request->input('travelCover') ?: '',
                        'formData.riotCover' => (bool) $request->input('riotCover') ?: '',
                        'formData.brokersClaimClause' => (bool) $request->input('brokersClaimClause') ?: '',
                        'formData.sepOrCom' => (boolean)($request->input('sepOrCom')== 'yes') ? true : ($request->input('sepOrCom')=='no'? false : null),
                        'formData.rateRequiredAdmin' => (string) $request->input('rateRequiredAdmin'),
                        'formData.rateRequiredNonAdmin' => (string) $request->input('rateRequiredNonAdmin'),
                        'formData.combinedRate' => (string) $request->input('combinedRate'),
                        'formData.brokerage' => (string) $request->input('brokerage'),
                        'formData.warranty' => (string) $request->input('warranty') ?: '',
                        'formData.exclusion' => (string) $request->input('exclusion') ?: '',
                        'formData.specialCondition' => (string) $request->input('specialCondition') ?: '',
                        'formData.excess' => (string) str_replace(',', '', $request->input('excess')) ?: '',
                        'formData.hiredCheck' => (bool) $request->input('hiredCheck') ?: '',
                    );
                } else {
                    $formdata_object = array(
                        'formData.extendedLiability' => (string) str_replace(',', '', $request->input('extended_liability')),
                        // 'formData.emergencyEvacuation' => $emergencyEvacuation,
//					    'formData.legalCost' => $legalCost,
                        // 'formData.empToEmpLiability' =>$empToEmpLiability,
                        // 'formData.errorsOmissions' =>$errorsOmissions,
                        // 'formData.crossLiability' => $crossLiability,
                        'formData.emergencyEvacuation' => (bool) $request->input('emergencyEvacuation') ?: '',
                        'formData.empToEmpLiability' => (bool) $request->input('empToEmpLiability') ?: '',
                        'formData.crossLiability' => (bool) $request->input('crossLiability') ?: '',
                        'formData.errorsOmissions' => (bool) $request->input('errorsOmissions') ?: '',
                        'formData.automaticClause' => (bool) $request->input('automaticClause') ?: '',
                        'formData.cancellationClause' => (bool) $request->input('cancellationClause') ?: '',
                        'formData.lossNotification' => (bool) $request->input('lossNotification') ?: '',
                        'formData.primaryInsuranceClause' => (bool) $request->input('primaryInsuranceClause') ?: '',
                        'formData.travelCover' => (bool) $request->input('travelCover') ?: '',
                        'formData.riotCover' => (bool) $request->input('riotCover') ?: '',
                        'formData.brokersClaimClause' => (bool) $request->input('brokersClaimClause') ?: '',
                        'formData.sepOrCom' => (boolean)($request->input('sepOrCom')== 'yes') ? true : ($request->input('sepOrCom')=='no'? false : null),
                        'formData.rateRequiredAdmin' => (string) $request->input('rateRequiredAdmin'),
                        'formData.rateRequiredNonAdmin' => (string) $request->input('rateRequiredNonAdmin'),
                        'formData.combinedRate' => (string) $request->input('combinedRate'),
                        'formData.brokerage' => (string) $request->input('brokerage'),
                        'formData.warranty' => (string) $request->input('warranty') ?: '',
                        'formData.exclusion' => (string) $request->input('exclusion') ?: '',
                        'formData.specialCondition' => (string) $request->input('specialCondition') ?: '',
                        'formData.excess' => (string) str_replace(',', '', $request->input('excess')) ?: '',
                        'formData.hiredCheck' => (bool) $request->input('hiredCheck') ?: '',
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
                        //		            	var_dump($pipeline_details['formData']['hiredWorkersDetails']['hasHiredWorkers']);
                        DB::collection('pipelineItems')->where('_id', new ObjectId($request->input('eslip_id')))->unset('formData.hiredCheck');
                    }
                }
                //			    if(isset($pipeline_details['formData']['offShoreEmployeeDetails']))
                //			    {
                //				    if($pipeline_details['formData']['offShoreEmployeeDetails']['hasOffShoreEmployees']==false)
                //				    {
                ////			            var_dump($pipeline_details['formData']['offShoreEmployeeDetails']['hasOffShoreEmployees']);
//
                //					    DB::collection('pipelineItems')->where('_id', new ObjectId($request->input('eslip_id')))->unset('formData.offshoreCheck');
                //				    }
//
                //			    }
                $updatedBy_obj = new \stdClass();
                $updatedBy_obj->id = new ObjectID(Auth::id());
                $updatedBy_obj->name = Auth::user()->name;
                $updatedBy_obj->date = date('d/m/Y');
                $updatedBy_obj->action = 'E slip saved as draft';
                $updatedBy[] = $updatedBy_obj;
                PipelineItems::where('_id', new ObjectId($request->input('eslip_id')))->push('updatedBy', $updatedBy);

                return response()->json(['success' => 'success']);
            }
        } catch (\Exception $e) {
            return back()->withInput()->with('status', 'Failed');
        }
    }

    /**
     * save insurance questions.
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
        $excel_name = $create_excel.'.'.'xls';
        $send_excel = public_path('/excel/'.$excel_name);
        //		$send_excel=fopen($send_excel1, 'r+');

        if ($send_excel) {
            if (isset($pipeline_details->insuraceCompanyList)) {
                $insurence_company = $pipeline_details->insuraceCompanyList;
                foreach ($insurence_company as $company) {
                    $existing_insures[] = $company['id'];
                }
                if ($send_type == 'send_all') {
                    foreach ($existing_insures as $key => $value) {
                        if (in_array($value, $insurance_companies)) {
                            PipelineItems::where('_id', $request->input('pipeline_id'))->update(array('insuraceCompanyList.'.$key.'.status' => 'resend'));
                        }
                    }

                    foreach ($insurance_companies as $x => $x_value) {
                        $users = User::where('insurer.id', new ObjectID($x_value))->get();
                        $link = url('/');
                        foreach ($users as $user) {
                            if (isset($user->email) && !empty($user->email)) {
                                $type = 'Employers Liability';
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

                        //					$insurers[]=new ObjectID($x_value);
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
                                    $type = 'Employers Liability';
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
                            $type = 'Employers Liability';
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
                    'status.date' => date('d/m/Y'), );
                DB::collection('pipelineItems')->where('_id', new ObjectId($request->input('pipeline_id')))
                    ->update($status_array);
            } elseif ($pipeline_details->status['status'] == 'Quote Amendment' || $pipeline_details->status['status'] == 'Quote Amendment-E-slip') {
                $pipeline_status = PipelineStatus::where('status', 'Quote Amendment-E-quotation')->first();
                $status_array = array('status.id' => new ObjectID($pipeline_status->_id),
                    'status.status' => (string) $pipeline_status->status,
                    'status.UpdatedById' => new ObjectId(Auth::id()),
                    'status.UpdatedByName' => Auth::user()->name,
                    'status.date' => date('d/m/Y'), );
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
        //		if($pipeline_details['formData']['scaleOfCompensation']['asPerUAELaw'] == true)
        //		{
        //			$questions_array[] = 'Scale of Compensation /Limit of Indemnity';
        //			$answes_array[] = 'As per UAE Labour Law';
        //		}
        //		if($pipeline_details['formData']['scaleOfCompensation']['isPTD'] == true)
        //		{
        //			$questions_array[] = 'Scale of Compensation /Limit of Indemnity';
        //			$answes_array[] = 'Death/Permanent Total Disability (PTD) Benefit increased to AED 50,000/- for those monthly salary is not more than AED 2,000/- and AE 75,000/- for those whose monthly salary is AED 2,000/- or more';
        //		}
        $questions_array[] = 'Employer’s extended liability under Common Law/Shariah Law';
        $answes_array[] = $pipeline_details['formData']['extendedLiability'];
        //		$questions_array[] = 'Medical Expense (In AED)';
        //		$answes_array[] = $pipeline_details['formData']['medicalExpense'];
        //		$questions_array[] = 'Repatriation Expenses (Repatriation of mortal remains or injured employee to his/her home country on medical advice) including  expenses of an accompanying person';
        //		$answes_array[] = $pipeline_details['formData']['repatriationExpenses'];
        if ($pipeline_details['formData']['hiredWorkersDetails']['hasHiredWorkers'] == true) {
            $questions_array[] = 'Cover for hired workers or casual labours';
            $answes_array[] = 'Number of Employees : '.$pipeline_details['formData']['hiredWorkersDetails']['noOfLabourers'].', Wages : '.$pipeline_details['formData']['hiredWorkersDetails']['annualWages'];
        }
        if ($pipeline_details['formData']['offShoreEmployeeDetails']['hasOffShoreEmployees'] == true) {
            $questions_array[] = 'Cover for offshore employees';
            $answes_array[] = 'Number of Employees : '.$pipeline_details['formData']['offShoreEmployeeDetails']['noOfLabourers'].', Wages : '.$pipeline_details['formData']['offShoreEmployeeDetails']['annualWages'];
        }
        //		if($pipeline_details['formData']['HoursPAC'] == true)
        //		{
        //			$questions_array[] = '24 hours non-occupational personal accident cover – in UAE and home country benefits as per UAE Labour Law';
        //			$answes_array[] = 'Yes';
        //		}
        //		if($pipeline_details['formData']['herniaCover'] == true)
        //		{
        //			$questions_array[] = 'Cover for hernia, heat/sun stroke, muscle spasm, muscle strain, lumbago related to work';
        //			$answes_array[] = 'Yes';
        //		}
        if ($pipeline_details['formData']['emergencyEvacuation'] == true) {
            $questions_array[] = 'Emergency evacuation following work related accident';
            $answes_array[] = 'Yes';
        }
        //		if($pipeline_details['formData']['legalCost'] == true)
        //		{
        //			$questions_array[] = 'Including Legal and Defence cost';
        //			$answes_array[] = 'Yes';
        //		}
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
            if ($pipeline_details['formData']['waiverOfSubrogation'] == true) {
                $questions_array[] = 'Waiver of subrogation';
                $answes_array[] = 'Yes';
            }
        }

        if ($pipeline_details['formData']['automaticClause'] == true) {
            $questions_array[] = 'Automatic addition & deletion Clause';
            $answes_array[] = 'Yes';
        }
        //		if($pipeline_details['formData']['flightCover'] == true)
        //		{
        //			$questions_array[] = 'Cover for insured’s employees on employment visas whilst on incoming and outgoing flights to/from  UAE';
        //			$answes_array[] = 'Yes';
        //		}
        //		if($pipeline_details['formData']['diseaseCover'] == true)
        //		{
        //			$questions_array[] = 'Cover for occupational/ industrial disease as per Labour Law';
        //			$answes_array[] = 'Yes';
        //		}
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

        //		if($pipeline_details['formData']['overtimeWorkCover'] == true)
        //		{
        //			$questions_array[] = 'Including work related accidents and bodily injuries during overtime work, night shifts, work on public holidays and week-ends.';
        //			$answes_array[] = 'Yes';
        //		}
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
        //		if($pipeline_details['formData']['offShoreEmployeeDetails']['hasOffShoreEmployees'] == true)
        //		{
        //			$questions_array[] = 'Cover for offshore employee';
        //			$answes_array[] = 'Yes'; 
        //		}
        if (isset($pipeline_details['formData']['sepOrCom']) && $pipeline_details['formData']['sepOrCom']==true) {
            if ($pipeline_details['formData']['rateRequiredAdmin'] != '') {
                $questions_array[] = 'Rate required (Admin) (in %)';
                $answes_array[] = $pipeline_details['formData']['rateRequiredAdmin'];
            }
            if ($pipeline_details['formData']['rateRequiredNonAdmin'] != '') {
                $questions_array[] = 'Rate required (Non-Admin) (in %)';
                $answes_array[] = $pipeline_details['formData']['rateRequiredNonAdmin'];
            }
        } elseif ( isset($pipeline_details['formData']['sepOrCom']) && $pipeline_details['formData']['sepOrCom']==false) {
            $questions_array[] = 'Combined Rate (in %)';
            $answes_array[] = $pipeline_details['formData']['combinedRate'];
        }
        $questions_array[] = 'Brokerage (in %)';
        $answes_array[] = $pipeline_details['formData']['brokerage'];
        $questions_array[] = 'Warranty';
        $answes_array[] = $pipeline_details['formData']['warranty'];
        $questions_array[] = 'Exclusion';
        $answes_array[] = $pipeline_details['formData']['exclusion'];
        $questions_array[] = 'Excess';
        $answes_array[] = $pipeline_details['formData']['excess'];
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
        $file_name_ = 'IIB E-Quotes'.rand();
        Excel::create($file_name_, function ($excel) use ($data) {
            $excel->sheet('Employers Liability', function ($sheet) use ($data) {
                $sheet->fromArray($data, null, 'A1', true, false);
                $sheet->row(1, function ($row) {
                    $row->setFontSize(10);
                    $row->setFontColor('#ffffff');
                    $row->setBackground('#1155CC');
                });
                $sheet->protect('password');
                $sheet->getStyle('C2:D35')->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
                $sheet->setAutoSize(true);
                $sheet->setWidth('A', 70);
                $sheet->getRowDimension(1)->setRowHeight(10);
                $sheet->setWidth('B', 50);
                $sheet->getStyle('A0:A32')->getAlignment()->setWrapText(true);
                $sheet->getStyle('B0:B32')->getAlignment()->setWrapText(true);
            });
        })->store('xls', public_path('excel'));

        return $file_name_;
    }

    /**
     * view e quotation.
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
        if ($pipeline_details->pipelineStatus != 'true') {
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

            return view('pipelines.employers_liability.e_quotations')->with(compact('pipeline_details', 'insures_name', 'insures_details', 'insures_id', 'id_insurer'));
        } else {
            return view('error');
        }
    }

    /**
     * imported list.
     */
    public function importedList()
    {
        $data1 = ImportExcel::first();
        $data = $data1['upload'];
        $pipeline_id = $data1['pipeline_id'];
        $insurer_id = $data1['insurer_id'];

        return view('pipelines.employers_liability.imported_list', compact('data', 'pipeline_id', 'insurer_id'));
    }

    /**
     * view e comparison.
     */
    public function eComparison($pipeline_id)
    {
        $insures_details = [];
        $pipeline_details = PipelineItems::find($pipeline_id);
        if ($pipeline_details['status']['status'] == 'Worktype Created' || $pipeline_details['status']['status'] == 'E-questionnaire' || $pipeline_details['status']['status'] == 'E-slip' || $pipeline_details['status']['status'] == 'E-quotation') {
            return view('error');
        }
        if ($pipeline_details->pipelineStatus != 'true') {
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

            return view('pipelines.employers_liability.e_comparison')->with(compact('pipeline_details', 'selectedId', 'insures_details'));
        } else {
            return view('error');
        }
    }

    /**
     * view e comparison from mail.
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

            return view('forms.emp_liability.customer_e_comparison')->with(compact('pipeline_details', 'insures_details', 'selectedId'));
        } else {
            return view('error');
        }
    }

    /**
     * view e comparison pdf.
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
        $pdf = PDF::loadView('forms.emp_liability.e_comparison_pdf', ['pipeline_details' => $pipeline_details, 'selectedId' => $selectedId, 'insures_details' => $insures_details])->setPaper('a3')->setOrientation('landscape')->setOption('margin-bottom', 0);
        $pdf_name = 'e_comparison_'.time().'_'.$pipelineId.'.pdf';
        $pdf->setOption('margin-top', 5);
        $pdf->setOption('margin-bottom', 5);
        $pdf->setOption('margin-left', 0);
        $pdf->setOption('margin-right', 0);
        $temp_path = public_path('pdf/'.$pdf_name);
        $pdf->save('pdf/'.$pdf_name);
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

    /**
     * view quote amendment page.
     */
    public function quotAmendment($pipeline_id)
    {
        $insures_details = [];
        $pipeline_details = PipelineItems::find($pipeline_id);
        if ($pipeline_details['status']['status'] == 'Worktype Created' || $pipeline_details['status']['status'] == 'E-questionnaire' || $pipeline_details['status']['status'] == 'E-slip' || $pipeline_details['status']['status'] == 'E-quotation' || $pipeline_details['status']['status'] == 'E-comparison') {
            return view('error');
        }
        if ($pipeline_details->pipelineStatus != 'true') {
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

            return view('pipelines.employers_liability.quote_amendment')->with(compact('pipeline_details', 'insures_details', 'selectedId'));
        } else {
            return view('error');
        }
    }

    /**
     * view approved quote.
     */
    public function approvedQuot($pipelineId)
    {
        $pipeline_details = PipelineItems::find($pipelineId);
        if ($pipeline_details['status']['status'] == 'Worktype Created' || $pipeline_details['status']['status'] == 'E-questionnaire' || $pipeline_details['status']['status'] == 'E-slip' || $pipeline_details['status']['status'] == 'E-quotation' || $pipeline_details['status']['status'] == 'Quote Amendment' || $pipeline_details['status']['status'] == 'E-comparison') {
            return view('error');
        }
        if ($pipeline_details->pipelineStatus != 'true') {
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

            return view('pipelines.employers_liability.approved_quot')->with(compact('pipelineId', 'pipeline_details', 'insures_details'));
        }
    }

    /**
     * Function for display issuance page.
     */
    public function issuance($pipelineId)
    {
        $pipeline_details = PipelineItems::find($pipelineId);
        if ($pipeline_details['status']['status'] == 'Worktype Created' || $pipeline_details['status']['status'] == 'E-questionnaire' || $pipeline_details['status']['status'] == 'E-slip' || $pipeline_details['status']['status'] == 'E-quotation'
            || $pipeline_details['status']['status'] == 'Quote Amendment' || $pipeline_details['status']['status'] == 'E-comparison') {
            return view('error');
        }
        if ($pipeline_details->pipelineStatus != 'issuance') {
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

            return view('pipelines.employers_liability.issuance')->with(compact('pipelineId', 'pipeline_details', 'insures_details'));
        }
    }

    /**
     * view pending list page.
     */
    public function viewPendingDetails($pipelineId)
    {
        $pipeline_details = PipelineItems::find($pipelineId);
        if (!$pipelineId) {
            return view('error');
        }
        if ($pipeline_details->pipelineStatus != 'pending') {
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

            return view('pipelines.employers_liability.view_pending_details')->with(compact('pipelineId', 'pipeline_details', 'insures_details'));
        }
    }

    /**
     * @param $pipelineId
     * view policy
     */
    public function viewPolicy($pipelineId)
    {
        $pipeline_details = PipelineItems::find($pipelineId);
        if (!$pipeline_details) {
            return view('error');
        }
        if ($pipeline_details->pipelineStatus != 'approved') {
            return view('error');
        } else {
            $insurerReplay = $pipeline_details['insurerReplay'];
            foreach ($insurerReplay as $insures_rep) {
                if ($insures_rep['quoteStatus'] == 'active' && @$insures_rep['customerDecision']['decision'] == 'Approved') {
                    $insures_details = $insures_rep;
                }
            }

            return view('pipelines.employers_liability.worksman_issuance')->with(compact('pipelineId', 'pipeline_details', 'insures_details'));
        }
    }

    /**
     * send questionnire.
     */
    public function sendQuestionnaire(Request $request)
    {
        $pipelineId = $request->input('id');
        $files = $request->input('files');
        $comment = $request->input('txt_comment');
        $status = 0;
        $token = str_random(3).time().str_random(3);
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
        $link = url('/employer/customer-questionnaire/'.$token);
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
        $updatedBy_obj->action = 'E questionnaire send';
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

        return 'E-questionnaire has been sent to '.$email;
    }

    /**
     * Function for display e questionnaire for customers.
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

                return view('pipelines.employers_liability.sendQuestion')->with(compact('country_name', 'all_emirates', 'eQuestionnaireid', 'form_data', 'PipelineItems', 'customer_details', 'all_insurers', 'file_name', 'file_url'));
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
}
