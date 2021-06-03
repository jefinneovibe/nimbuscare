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
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use MongoDB\BSON\ObjectID;
use PDF;

class FirePerilsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.underwriter', ['except' => [ 'equestionnaireSave', 'decisionSave','viewComparison']]);
    }
    /**
     * e questionaire
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
        return view('pipelines.fire_perils.e_questionaire')->with(compact(
            'country_name_place',
            'country_name',
            'all_emirates',
            'eQuestionnaireid',
            'form_data',
            'PipelineItems',
            'customer_details',
            'file_name',
            'file_url'
        ));
    }

    /**
     * function to save e qustionaire
     */
    public static function equestionnaireSave(Request $request)
    {

        // var_dump($request->input('business_interruption'));die;
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

            // $formdata=new \stdClass();

            // $formdata->salutation=$request->input('salutation');
            // $formdata->firstName=$request->input('firstName');
            // $formdata->middleName=$request->input('middleName');
            // $formdata->lastName=$request->input('lastName');
            // $formdata->addressDetails=$address_object;
            // $formdata->companyName=$request->input('company_name');

            $risk_object = new \stdClass();
            $risk_object->noLocations = $request->input('no_of_locations');
            $risk_object->locationRisk = $request->input('locations_risk');
            // $formdata->risk=$risk_object;
            $occupancy_object = new \stdClass();
            $occupancyType = $request->input('occupancy');
            $occupancy_object->type = $request->input('occupancy');
            if ($occupancyType == 'Warehouse') {
                $occupancy_object->warehouseType = $request->input('warehouse_type');
            } elseif ($occupancyType == 'Others') {
                $occupancy_object->Others = $request->input('other_occupancy');
            }
            // $formdata->occupancy=$occupancy_object;
            $hazardousObject = new \stdClass();
            if ($request->input('hazardous_material') == 'yes') {
                $hazardousObject->hazardous = (boolean) true;
                $hazardousObject->hazardous_reason = $request->input('hazardous_reason');
            }
            if ($request->input('hazardous_material') == 'no') {
                $hazardousObject->hazardous = (boolean) false;
            }
            // $formdata->hazardous=$hazardousObject;

            $constructionObject = new \stdClass();
            $constructionObject->roof = $request->input('roof');
            $constructionObject->floorType = $request->input('floor');
            $constructionObject->yearConstruction = $request->input('year_construction');
            $constructionObject->numberStories = $request->input('number_stories') ?: '';
            $constructionObject->wallType = $request->input('construction_walls');
            if ($request->input('construction_walls') == 'Cladding') {
                $constructionObject->percentageCladding = $request->input('percentage_cladding');
                $constructionObject->claddingPresence = $request->input('cladding_presence');
                $constructionObject->claddingType = ($request->input('cladding_type') == 'yes') ? true : ($request->input('cladding_type') == 'no' ? false : null);
                $constructionObject->claddingMatType = $request->input('cladding_mat_type');
                $constructionObject->claddingFireRate = $request->input('cladding_fire_rate');
                $constructionObject->claddingTechSpec = $request->input('cladding_tech_spec');
                $constructionObject->claddingConsMat = $request->input('cladding_cons_mat');
                $constructionObject->claddingInsMat = ($request->input('cladding_ins_mat') == 'yes') ? true : ($request->input('cladding_ins_mat') == 'no' ? false : null);
                $constructionObject->claddingFacilities = $request->input('cladding_facilities');
                if ($request->input('percentage_cladding') == 'Others') {
                    $constructionObject->percentageCladdingOther = $request->input('percentage_cladding_other');
                } else {
                    $constructionObject->percentageCladdingOther = '';
                }
            }
            // $formdata->constuctionType=$constructionObject;

            $fireFightObject = new \stdClass();
            // $fireFightObject->fireFacilities=implode(',',  $request->input('fire_facilities'));
            $fireFightObject->fireFacilities = $request->input('fire_facilities');
            if (!empty($request->input('fire_facilities'))) {
                if (in_array('others', $request->input('fire_facilities'))) {
                    $fireFightObject->other = $request->input('fire_other');
                }
            }
            $securityGuardObject = new \stdClass();
            $securityGuardObject->securityGuard = $request->input('security_guard');
            if ($request->input('security_guard') == 'Others') {
                $securityGuardObject->securityOther = $request->input('security_other');
            }
            // $formdata->securityGuard=$securityGuardObject;
            // $formdata->fireFight=$fireFightObject;
            $frequencyObject = new \stdClass();
            $frequencyObject->time_day = $request->input('time_day');
            $frequencyObject->once_day = $request->input('once_day');
            // $formdata->frequency=$frequencyObject;

            $neighborhoodObject = new \stdClass();
            $neighborhoodObject->west = $request->input('west');
            $neighborhoodObject->east = $request->input('east');
            $neighborhoodObject->north = $request->input('north');
            $neighborhoodObject->south = $request->input('south');
            // $formdata->neighborhood=$neighborhoodObject;
            $waterSorageObject = new \stdClass();
            if ($request->input('water_storage') == 'yes') {
                $waterSorageObject->waterSorage = (boolean) true;
                $waterSorageObject->gallonsValue = $request->input('gallons_value');
                $waterSorageObject->ltsValue = $request->input('lts_value') ?: '';
            } elseif ($request->input('water_storage') == 'no') {
                $waterSorageObject->waterSorage = (boolean) false;
            }
            // $formdata->waterSorage=$waterSorageObject;
            $businessInterruptionObject = new \stdClass();
            if ($request->input('business_interruption') == 'yes') { 
                $businessInterruptionObject->business_interruption = (boolean) true;
                $businessInterruptionObject->actualProfit = str_replace(',', '', $request->input('actual_profit'));
                $businessInterruptionObject->estimatedProfit = str_replace(',', '', $request->input('estimated_profit'));
                $businessInterruptionObject->standCharge = str_replace(',', '', $request->input('stand_charge'));
                $businessInterruptionObject->noLocations = $request->input('no_locations');
                $businessInterruptionObject->costWork = str_replace(',', '', $request->input('cost_work'));
                $businessInterruptionObject->rentLoss = str_replace(',', '', $request->input('rent_loss'));
                $businessInterruptionObject->mainCustName = $request->input('main_cust_name');
                $businessInterruptionObject->mainSuppName = $request->input('main_supp_name');
                $businessInterruptionObject->indemnityPeriod = str_replace(',', '', $request->input('indemnity_period'));
            } elseif ($request->input('business_interruption') == 'no') {
                $businessInterruptionObject->business_interruption = (boolean) false;
            }
            $bankPolicyObject = new \stdClass();
            if ($request->input('bank_policy') == 'yes') {
                $bankPolicyObject->bankPolicy = (boolean) true;
                $bankPolicyObject->bankLocation = $request->input('bank_location');
                $bankPolicyObject->bankPo = $request->input('bank_po');
                $bankPolicyObject->bankName = $request->input('bank_name');
                $bankPolicyObject->bankAmount = str_replace(',', '', $request->input('bank_amount'));
            } elseif ($request->input('bank_policy') == 'no') {
                $bankPolicyObject->bankPolicy = (boolean) false;
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
                'formData.firstName' => $request->input('firstName'),
                'formData.middleName' => $request->input('middleName'),
                'formData.lastName' => $request->input('lastName'),
                'formData.addressDetails' => $address_object,
                'formData.companyName' => $request->input('company_name'),
                'formData.occupancy' => $occupancy_object,
                'formData.risk' => $risk_object,
                'formData.ageBuilding' => $request->input('age_building'),
                'formData.noOfFloors' => $request->input('no_of_floors'),
                'formData.hazardous' => $hazardousObject,
                'formData.constuctionType' => $constructionObject,
                'formData.businessType' => $request->input('businessType'),
                'formData.safetySigns' => ($request->input('safety_signs') == 'yes') ? true : ($request->input('safety_signs') == 'no' ? false : null),
                'formData.fireFight' => $fireFightObject,
                'formData.civilDefence' => ($request->input('civil_defence') == 'yes') ? true : ($request->input('civil_defence') == 'no' ? false : null),
                'formData.burglaryAlarm' => $request->input('burglary_alarm'),
                'formData.cctv' => $request->input('cctv'),
                'formData.electicity_usage' => $request->input('electicity_usage'),
                'formData.securityGuard' => $securityGuardObject,
                'formData.frequency' => $frequencyObject,
                'formData.neighborhood' => $neighborhoodObject,
                'formData.distance' => $request->input('distance'),
                'formData.waterSorage' => $waterSorageObject,
                'formData.buildingInclude' => str_replace(',', '', $request->input('building_include')),
                'formData.stock' => str_replace(',', '', $request->input('stock')),
                'formData.finishedGoods' => str_replace(',', '', $request->input('finished_goods')),
                'formData.rawMaterials' => str_replace(',', '', $request->input('raw_materials')),
                'formData.machinery' => str_replace(',', '', $request->input('machinery')),
                'formData.signBoards' => str_replace(',', '', $request->input('sign_boards')),
                'formData.furniture' => str_replace(',', '', $request->input('furniture')),
                'formData.officeEquipments' => str_replace(',', '', $request->input('office_equipments')),
                'formData.annualRent' => str_replace(',', '', $request->input('annual_rent')),
                'formData.otherItems' => $request->input('other_items'),
                'formData.total' => str_replace(',', '', $request->input('total')),
                'formData.claimExperienceDetails' => $request->input('claim_experience_details'),
                'formData.businessInterruption' => $businessInterruptionObject,
                'formData.claimsHistory' => $claim_array,
                'formData.bankPolicy' => $bankPolicyObject,
            ];

            if ($request->input('claim_experience_details') == 'separate_fire' && $request->input('business_interruption') == 'yes') {
                $year_sep = $request->input('year_sep');
                $description_sep = $request->input('description_sep');
                $claim_amount_sep = $request->input('claim_amount_sep');
                $claim_array_sep = [];
                foreach ($year_sep as $key => $year_value) {
                    if ($year_value != 0 || $year_value != null) {
                        $claim_history_object = new \stdClass();
                        $claim_history_object->year = $year_sep[$key];
                        $claim_history_object->description = $description_sep[$key];
                        $claim_history_object->claim_amount = str_replace(',', '', $claim_amount_sep[$key]);
                        $claim_array_sep[] = $claim_history_object;
                    } else {
                        $claim_history_object = new \stdClass();
                        $claim_history_object->year = $year_sep[$key];
                        $claim_history_object->description_sep = '';
                        $claim_history_object->claim_amount_sep = '';
                        $claim_array_sep[] = $claim_history_object;
                    }
                }

                // $formdata->claimsHistory_sep=$claim_array_sep;
                $formdata_object1 = [
                    'formData.claimsHistory_sep' => $claim_array_sep];
                $formdata_object = array_merge($formdata_object, $formdata_object1);
            } else {
                PipelineItems::where('_id', $request->input('id'))->pull('formData.claimsHistory_sep');
            }
            // dd($formdata_object);

            $civil_certificate = $request->file('civil_certificate');
            $policyCopy = $request->file('policyCopy');
            $trade_list = $request->file('trade_list');
            $vat_copy = $request->file('vat_copy');
            $others1 = $request->file('others1');
            $others2 = $request->file('others2');
            // $file=[];
            if ($civil_certificate) {
                $civil_certificate = PipelineController::uploadToCloud($civil_certificate);
                $civil_certificate_object = new \stdClass();
                $civil_certificate_object->url = $civil_certificate;
                $civil_certificate_object->file_name = 'CIVIL DEFENSE COMPLIANCE CERTIFICATE';
                $civil_certificate_object->upload_type = 'e_questionnaire';
                $file[] = $civil_certificate_object;
            } elseif ($request->input('civil_url') != '') {
                $civil_certificate_object = new \stdClass();
                $civil_certificate_object->url = $request->input('civil_url');
                $civil_certificate_object->file_name = 'CIVIL DEFENSE COMPLIANCE CERTIFICATE';
                $civil_certificate_object->upload_type = 'e_questionnaire';
                $file[] = $civil_certificate_object;
            } else {
                $civil_certificate_object = '';
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
            if ($vat_copy) {
                $vat_copy = PipelineController::uploadToCloud($vat_copy);
                $vat_copy_object = new \stdClass();
                $vat_copy_object->url = $vat_copy;
                $vat_copy_object->file_name = 'VAT CERTIFICATE/TRN';
                $vat_copy_object->upload_type = 'e_questionnaire';
                $file[] = $vat_copy_object;
            } elseif ($request->input('vat_url') != '') {
                $vat_copy_object = new \stdClass();
                $vat_copy_object->url = $request->input('vat_url');
                $vat_copy_object->file_name = 'VAT CERTIFICATE/TRN';
                $vat_copy_object->upload_type = 'e_questionnaire';
                $file[] = $vat_copy_object;
            } else {
                $vat_copy_object = '';
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
                $policy_file = '';
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
        $link = url('/fireperils/customer-questionnaire/' . $token);
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
                return view('pipelines.fire_perils.sendQuestion')->with(compact('country_name', 'all_emirates', 'eQuestionnaireid', 'form_data', 'PipelineItems', 'customer_details', 'all_insurers', 'file_name', 'file_url'));
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
            return view('pipelines.fire_perils.e_slip')->with(compact('worktype_id', 'pipeline_details', 'file_name', 'file_url', 'form_data'));
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
        $civil_certificate = $request->file('civil_certificate');
        $policyCopy = $request->file('policyCopy');
        $trade_list = $request->file('trade_list');
        $vat_copy = $request->file('vat_copy');
        $others1 = $request->file('others1');
        $others2 = $request->file('others2');
        if ($civil_certificate) {
            $civil_certificate = PipelineController::uploadToCloud($civil_certificate);
            $civil_certificate_object = new \stdClass();
            $civil_certificate_object->url = $civil_certificate;
            $civil_certificate_object->file_name = 'CIVIL DEFENSE COMPLIANCE CERTIFICATE';
            $civil_certificate_object->upload_type = 'e_questionnaire';
            $file[] = $civil_certificate_object;
        } elseif ($request->input('civil_url') != '') {
            $civil_certificate_object = new \stdClass();
            $civil_certificate_object->url = $request->input('civil_url');
            $civil_certificate_object->file_name = 'CIVIL DEFENSE COMPLIANCE CERTIFICATE';
            $civil_certificate_object->upload_type = 'e_questionnaire';
            $file[] = $civil_certificate_object;
        } else {
            $civil_certificate_object = '';
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
        if ($vat_copy) {
            $vat_copy = PipelineController::uploadToCloud($vat_copy);
            $vat_copy_object = new \stdClass();
            $vat_copy_object->url = $vat_copy;
            $vat_copy_object->file_name = 'VAT CERTIFICATE/TRN';
            $vat_copy_object->upload_type = 'e_questionnaire';
            $file[] = $vat_copy_object;
        } elseif ($request->input('vat_url') != '') {
            $vat_copy_object = new \stdClass();
            $vat_copy_object->url = $request->input('vat_url');
            $vat_copy_object->file_name = 'VAT CERTIFICATE/TRN';
            $vat_copy_object->upload_type = 'e_questionnaire';
            $file[] = $vat_copy_object;
        } else {
            $vat_copy_object = '';
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
            $policy_file = '';
        }
        PipelineItems::where('_id', $request->input('eslip_id'))->pull('files', ['upload_type' => 'e_questionnaire']);
        if (isset($file) && !empty($file)) {
            $pipeline_details->push('files', $file);
        }
        $formdata_object = [];

        if ($pipeline_details['formData']['buildingInclude'] != '') {
            $demolitionClause = (boolean) $request->input('demolition_clause') ?: false;

            $formdata_object1 = [

                'formData.demolitionClause' => $demolitionClause,
            ];
            $formdata_object = array_merge($formdata_object, $formdata_object1);
        } else {
            PipelineItems::where('_id', $request->input('eslip_id'))->unset('formData.demolitionClause');
        }
        if ($pipeline_details['formData']['businessType'] == "Art galleries/ fine arts collection"
        || $pipeline_details['formData']['businessType'] == "Colleges/ Universities/ schools & educational institute"
        || $pipeline_details['formData']['businessType'] == "Hotels/ boarding houses/ motels/ service apartments"
        || $pipeline_details['formData']['businessType'] == "Hotel multiple cover"
        || $pipeline_details['formData']['businessType'] == "Museum/ heritage sites"
        ) {
            $coverCurios =$pipeline_details['formData']['businessType'];
            $formdata_object['formData.coverCurios'] = $coverCurios;
        } else {
            PipelineItems::where('_id', $request->input('eslip_id'))->unset('formData.coverCurios');
        }
        if (isset($pipeline_details['formData']['annualRent']) && $pipeline_details['formData']['annualRent'] != '') {
            $lossRent = (string) $pipeline_details['formData']['annualRent'];
            $formdata_object['formData.lossRent'] = $lossRent;
        } else {
            PipelineItems::where('_id', $request->input('eslip_id'))->unset('formData.lossRent');
        }
        if ($pipeline_details['formData']['occupancy']['type'] == 'Residence' || @$pipeline_details['formData']['occupancy']['type'] == 'Labour Camp') {
            $alternateacco = (string) $pipeline_details['formData']['occupancy']['type'];
            $formdata_object['formData.alternateAcco'] = $alternateacco;
        } else {
            PipelineItems::where('_id', $request->input('eslip_id'))->unset('formData.alternateAcco');
        }

        if ($pipeline_details['formData']['businessType']) {
            $exhibitionRisk = (string) $pipeline_details['formData']['businessType'];
            $formdata_object['formData.exhibitionRisk'] = $exhibitionRisk;
        } else {
            PipelineItems::where('_id', $request->input('eslip_id'))->unset('formData.exhibitionRisk');
        }
        if ($pipeline_details['formData']['otherItems'] != '') {
            $custody = (string) $pipeline_details['formData']['otherItems'];
            $formdata_object['formData.custody'] = $custody;
        } else {
            PipelineItems::where('_id', $request->input('eslip_id'))->unset('formData.custody');
        }
        if ($pipeline_details['formData']['bankPolicy'] == true) {
            $saleInterestClause = (boolean) true;
            $formdata_object['formData.saleInterestClause'] = $saleInterestClause;
        } else {
            PipelineItems::where('_id', $request->input('eslip_id'))->unset('formData.saleInterestClause');
        }
        if ($pipeline_details['formData']['bankPolicy']['bankPolicy'] == true) {
            $lossPayee = (boolean) true;
            $formdata_object['formData.lossPayee'] = $lossPayee;
        } else {
            PipelineItems::where('_id', $request->input('eslip_id'))->unset('formData.lossPayee');
        }
        if ($pipeline_details['formData']['occupancy']['type'] == 'Warehouse'
            || $pipeline_details['formData']['occupancy']['type'] == 'Factory'
            || $pipeline_details['formData']['occupancy']['type'] == 'Others') {
            $coverOpen = (string) $pipeline_details['formData']['occupancy']['type'];
            $formdata_object['formData.coverOpen'] = $coverOpen;
        } else {
            PipelineItems::where('_id', $request->input('eslip_id'))->unset('formData.coverOpen');
        }

        if ($pipeline_details['formData']['businessInterruption']['business_interruption'] == true) {
            $addCostWorking = (boolean) $request->input('add_cost_working') ?: false;
            $claimPreparationClause = (boolean) $request->input('claim_preparation_clause') ?: false;
            $suppliersExtension = (boolean) $request->input('suppliers_extension') ?: false;
            $accountantsClause = (boolean) $request->input('accountants_clause') ?: false;
            $accountPayment = (boolean) $request->input('account_payment') ?: false;
            $preventionDenialClause = (boolean) $request->input('prevention_denial') ?: false;
            $DenialClause = (boolean) $request->input('denial_clause') ?: false;
            $premiumAdjClause = (boolean) $request->input('premium_adj_clause') ?: false;
            $publicUtilityClause = (boolean) $request->input('public_utility_clause') ?: false;
            $brockersClaimHandlingClause = (boolean) $request->input('brockers_claim_handling_clause') ?: false;
            $accountsRecievable = (boolean) $request->input('accounts_recievable') ?: false;
            $interDependency = (boolean) $request->input('inter_dependency') ?: false;
            $extraExpense = (boolean) $request->input('extra_expense') ?: false;
            $contaminatedWater = (boolean) $request->input('contaminated_water') ?: false;
            $auditorsFeeCheck = (boolean) $request->input('auditors_fee_check') ?: false;
            $expenseReduceLoss = (boolean) $request->input('expense_reduce_loss') ?: false;
            $nominatedLossAdjuster = (boolean) $request->input('nominated_loss_adjuster') ?: false;
            $outbreakDiscease = (boolean) $request->input('outbreak_discease') ?: false;
            $nonPublicFailure = (boolean) $request->input('non_public_failure') ?: false;
            $premisesDetails = (boolean) $request->input('premises_details') ?: false;
            $bombscare = (boolean) $request->input('bombscare') ?: false;
            $bookDebits = (boolean) $request->input('book_debits') ?: false;
            $publicFailure = (boolean) $request->input('public_failure') ?: false;

            $contingentBusiness = (boolean) $request->input('contingent_business') ?: false;
            $nonOwnedProperties = (boolean) $request->input('non_owned_properties') ?: false;
            $royalties = (boolean) $request->input('royalties') ?: false;
            $coverAccObject = new \stdClass();
            if (($request->input('cover_accomodation') == 'yes')) {
                $coverAccObject->coverAccomodation = (boolean) true;
                $coverAccObject->OtherCover = $request->input('cover_alternate');
            } elseif (($request->input('cover_accomodation') == 'no')) {
                $coverAccObject->coverAccomodation = (boolean) false;
            }
            if (isset($pipeline_details['formData']['businessInterruption']['noLocations']) && $pipeline_details['formData']['businessInterruption']['noLocations'] > 1) {
                $departmentalClause = (boolean) $request->input('departmental_clause') ?: false;
                $rentLease = (boolean) $request->input('rent_lease') ?: false;
                $formdata_object['formData.departmentalClause'] = $departmentalClause;
                $formdata_object['formData.rentLease'] = $rentLease;
            } else {
                PipelineItems::where('_id', $request->input('eslip_id'))->unset('formData.departmentalClause');
                PipelineItems::where('_id', $request->input('eslip_id'))->unset('formData.rentLease');
            }
            // if (($request->input('cover_accomodation') == 'yes')) {
            //     $coverAccObject->coverAccomodation = (boolean) true;
            //     $coverAccObject->OtherCover = $request->input('cover_alternate');
            // } else {
            //     $coverAccObject->coverAccomodation = (boolean) false;
            // }

            $formdata_object3 = [
                'formData.addCostWorking' => $addCostWorking,
                'formData.claimPreparationClause' => $claimPreparationClause,
                'formData.suppliersExtension' => $suppliersExtension,
                'formData.accountantsClause' => $accountantsClause,
                'formData.accountPayment' => $accountPayment,
                'formData.preventionDenialClause' => $preventionDenialClause,
                'formData.DenialClause' => $DenialClause,
                'formData.premiumAdjClause' => $premiumAdjClause,
                'formData.publicUtilityClause' => $publicUtilityClause,
                'formData.brockersClaimHandlingClause' => $brockersClaimHandlingClause,
                'formData.accountsRecievable' => $accountsRecievable,
                'formData.interDependency' => $interDependency,
                'formData.extraExpense' => $extraExpense,
                'formData.contaminatedWater' => $contaminatedWater,
                'formData.auditorsFeeCheck' => $auditorsFeeCheck,
                'formData.expenseReduceLoss' => $expenseReduceLoss,
                'formData.nominatedLossAdjuster' => $nominatedLossAdjuster,
                'formData.outbreakDiscease' => $outbreakDiscease,
                'formData.nonPublicFailure' => $nonPublicFailure,
                'formData.premisesDetails' => $premisesDetails,
                'formData.bombscare' => $bombscare,
                'formData.bookDebits' => $bookDebits,
                'formData.publicFailure' => $publicFailure,
                'formData.contingentBusiness' => $contingentBusiness,
                'formData.nonOwnedProperties' => $nonOwnedProperties,
                'formData.royalties' => $royalties,
                'formData.CoverAccomodation' => $coverAccObject,

            ];
            $formdata_object = array_merge($formdata_object, $formdata_object3);
        } else {
            PipelineItems::where('_id', $request->input('eslip_id'))->unset(
                'formData.addCostWorking',
                'formData.claimPreparationClause',
                'formData.suppliersExtension',
                'formData.accountantsClause',
                'formData.accountPayment',
                'formData.preventionDenialClause',
                'formData.premiumAdjClause',
                'formData.publicUtilityClause',
                'formData.brockersClaimHandlingClause',
                'formData.accountsRecievable',
                'formData.interDependency',
                'formData.extraExpense',
                'formData.contaminatedWater',
                'formData.auditorsFeeCheck',
                'formData.expenseReduceLoss',
                'formData.nominatedLossAdjuster',
                'formData.outbreakDiscease',
                'formData.nonPublicFailure',
                'formData.premisesDetails',
                'formData.bombscare',
                'formData.bookDebits',
                'formData.publicFailure',
                'formData.contingentBusiness',
                'formData.nonOwnedProperties',
                'formData.royalties',
                'formData.CoverAccomodation'

            );
        }
        $claimPremiyumDetails = new \stdClass();
        if ($request->input('claim_experience_details') == 'combined_data') {
            $claimPremiyumDetails = new \stdClass();
            $claimPremiyumDetails->deductableProperty = str_replace(',', '', $request->input('deductable_property'));
            $claimPremiyumDetails->deductableBusiness = str_replace(',', '', $request->input('deductable_interuption'));
            $claimPremiyumDetails->rateCombined = str_replace(',', '', $request->input('rate_required'));
            $claimPremiyumDetails->premiumCombined = str_replace(',', '', $request->input('premium_required'));
            $claimPremiyumDetails->brokerage = str_replace(',', '', $request->input('brokerage'));
            $claimPremiyumDetails->warrantyProperty = (string) $request->input('warranty');
            $claimPremiyumDetails->warrantyBusiness = (string) $request->input('warranty_business');
            $claimPremiyumDetails->exclusionProperty = (string) $request->input('exclusion_property');
            $claimPremiyumDetails->exclusionBusiness = (string) $request->input('exclusion_business');
            $claimPremiyumDetails->specialProperty = (string) $request->input('special_property');
            $claimPremiyumDetails->specialBusiness = (string) $request->input('special_business');
        } elseif ($request->input('claim_experience_details') == 'only_fire') {
            $claimPremiyumDetails = new \stdClass();
            $claimPremiyumDetails->deductableProperty = (string) str_replace(',', '', $request->input('property_deductable'));
            $claimPremiyumDetails->propertyRate = (string) str_replace(',', '', $request->input('property_rate'));
            $claimPremiyumDetails->propertyPremium = (string) str_replace(',', '', $request->input('property_premium'));
            $claimPremiyumDetails->propertyBrockerage = (string) str_replace(',', '', $request->input('property_brockerage'));
            $claimPremiyumDetails->propertyWarranty = (string) $request->input('property_warranty');
            $claimPremiyumDetails->propertyExclusion = (string) $request->input('property_exclusion');
            $claimPremiyumDetails->propertySpecial = (string) $request->input('property_special');
        } elseif ($request->input('claim_experience_details') == 'separate_fire') {
            $claimPremiyumDetails = new \stdClass();
            $claimPremiyumDetails->propertySeparateDeductable = (string) str_replace(',', '', $request->input('property_separate_deductable'));
            $claimPremiyumDetails->propertySeparateRate = (string) str_replace(',', '', $request->input('property_separate_rate'));
            $claimPremiyumDetails->propertySeparatePremium = (string) str_replace(',', '', $request->input('property_separate_premium'));
            $claimPremiyumDetails->propertySeparateBrokerage = (string) str_replace(',', '', $request->input('property_separate_brokerage'));
            $claimPremiyumDetails->propertySeparateWarranty = (string) $request->input('property_separate_warranty');
            $claimPremiyumDetails->propertySeparateExclusion = (string) $request->input('property_separate_exclusion');
            $claimPremiyumDetails->propertySeparateSpecial = (string) $request->input('property_separate_special');
            $claimPremiyumDetails->businessSeparateDeductable = (string) str_replace(',', '', $request->input('business_separate_deductable'));
            $claimPremiyumDetails->businessSeparateRate = (string) str_replace(',', '', $request->input('business_separate_rate'));
            $claimPremiyumDetails->businessSeparatePremium = (string) str_replace(',', '', $request->input('business_separate_premium'));
            $claimPremiyumDetails->businessSeparateBrokerage = (string) str_replace(',', '', $request->input('business_separate_brokerage'));
            $claimPremiyumDetails->businessSeparateWarranty = (string) $request->input('business_separate_warranty');
            $claimPremiyumDetails->businessSeparateExclusion = (string) $request->input('business_separate_exclusion');
            $claimPremiyumDetails->businessSeparateSpecial = (string) $request->input('business_separate_special');
        }

        $formdata_object4 = [
            'formData.saleClause' => (boolean) $request->input('sale_clause') ?: false,
            'formData.fireBrigade' => (boolean) $request->input('fire_brigade') ?: false,
            'formData.clauseWording' => (boolean) $request->input('clause_wording') ?: false,
            'formData.automaticReinstatement' => (boolean) $request->input('automatic_reinstatement') ?: false,
            'formData.capitalClause' => (boolean) $request->input('capital_clause') ?: false,
            'formData.mainClause' => (boolean) $request->input('main_clause') ?: false,
            'formData.repairCost' => (boolean) $request->input('repair_cost') ?: false,
            'formData.debris' => (boolean) $request->input('debris') ?: false,
            'formData.reinstatementValClass' => (boolean) $request->input('reinstatement_val_class') ?: false,
            'formData.waiver' => (boolean) $request->input('waiver') ?: false,
            'formData.trace' => (boolean) $request->input('trace') ?: false,
            'formData.publicClause' => (boolean) $request->input('public_clause') ?: false,
            'formData.contentsClause' => (boolean) $request->input('contents_clause') ?: false,
            'formData.alterationClause' => (boolean) $request->input('alteration_clause') ?: false,
            'formData.tradeAccess' => (boolean) $request->input('trade_access') ?: false,
            'formData.tempRemovalClause' => (boolean) $request->input('temp_removal_clause') ?: false,
            'formData.proFee' => (boolean) $request->input('prof_fee') ?: false,
            'formData.expenseClause' => (boolean) $request->input('expense_clause') ?: false,
            'formData.desigClause' => (boolean) $request->input('desig_clause') ?: false,
            'formData.cancelThirtyClause' => (boolean) $request->input('cancel_thirty_clause') ?: false,
            'formData.primaryInsuranceClause' => (boolean) $request->input('primary_insurance_clause') ?: false, 
            // 'formData.accountClause' => (boolean) $request->input('account_clause') ?: false,
            'formData.paymentAccountClause' => (boolean) $request->input('account_clause') ?: false,
            'formData.nonInvalidClause' => (boolean) $request->input('non_invalid_clause') ?: false,
            'formData.warrantyConditionClause' => (boolean) $request->input('warranty_condition_clause') ?: false,
            'formData.escalationClause' => (boolean) $request->input('escalation_clause') ?: false,
            'formData.addInterestClause' => (boolean) $request->input('add_interest_clause') ?: false,
            'formData.improvementClause' => (boolean) $request->input('improvement_clause') ?: false,
            'formData.automaticClause' => (boolean) $request->input('automaticClause') ?: false,
            'formData.reduseLoseClause' => (boolean) $request->input('reduse_lose_clause') ?: false,
            'formData.errorOmission' => (boolean) $request->input('error_omission') ?: false,
            'formData.noControlClause' => (boolean) $request->input('no_control_clause') ?: false,
            'formData.preparationCostClause' => (boolean) $request->input('preparation_cost_clause') ?: false,
            'formData.coverPropertyCon' => (boolean) $request->input('cover_property_con') ?: false,
            'formData.personalEffectsEmployee' => (boolean) $request->input('personal_effects_employee') ?: false,
            'formData.incidentLandTransit' => (boolean) $request->input('incidental') ?: false,
            'formData.lossOrDamage' => (boolean) $request->input('loss_or_damage') ?: false,
            'formData.nominatedLossAdjusterClause' => (boolean) $request->input('nominated_loss_adjuster_clause') ?: false,
            'formData.sprinkerLeakage' => (boolean) $request->input('sprinker_leakage') ?: false,
            'formData.minimiseLoss' => (boolean) $request->input('minimise_loss') ?: false,
            'formData.minLossClause' => (boolean) $request->input('min_loss_clause') ?: false,
            'formData.costConstruction' => (boolean) $request->input('cost_construction') ?: false,
            'formData.propertyValuationClause' => (boolean) $request->input('property_valuation_clause') ?: false,
            'formData.accidentalDamage' => (boolean) $request->input('accidental_damage') ?: false,
            'formData.auditorsFee' => (boolean) $request->input('auditors_fee') ?: false,
            'formData.smokeSoot' => (boolean) $request->input('smoke_soot') ?: false,
            'formData.boilerExplosion' => (boolean) $request->input('boiler_explosion') ?: false,
            'formData.strikeRiot' => (boolean) $request->input('strike_riot') ?: false,
            'formData.chargeAirfreight' => (boolean) $request->input('charge_airfreight') ?: false,
            'formData.tempRemoval' => (boolean) $request->input('temp_removal') ?: false,
            'formData.coverMechanical' => (boolean) $request->input('cover_mechanical') ?: false,
            'formData.coverExtWork' => (boolean) $request->input('cover_ext_work') ?: false,
            'formData.misdescriptionClause' => (boolean) $request->input('misdescription_clause') ?: false,
            'formData.otherInsuranceClause' => (boolean) $request->input('other_insurance_clause') ?: false,
            'formData.automaticAcqClause' => (boolean) $request->input('automatic_acq_clause') ?: false,
            'formData.minorWorkExt' => (boolean) $request->input('minor_work_ext') ?: false,
            'formData.saleInterestClause' => (boolean) $request->input('sale_interest_clause') ?: false,
            'formData.sueLabourClause' => (boolean) $request->input('sue_labour_clause') ?: false,
            'formData.electricalClause' => (boolean) $request->input('electrical_cause') ?: false,
            'formData.contractPriceClause' => (boolean) $request->input('contract_price_clause') ?: false,
            'formData.sprinklerUpgradationClause' => (boolean) $request->input('sprinkler_upgradation_clause') ?: false,
            'formData.accidentalFixClass' => (boolean) $request->input('accidental_fix_class') ?: false,
            'formData.electronicInstallation' => (boolean) $request->input('electronic_installation') ?: false,
            'formData.brandTrademark' => (boolean) $request->input('brand_trademark') ?: false,
            'formData.lossNotification' => (boolean) $request->input('loss_notification') ?: false,
            'formData.brockersClaimClause' => (boolean) $request->input('brockers_claim_clause') ?: false,
            'formData.ownerPrinciple' => (boolean) $request->input('indemnity_owner') ?: false,
            'formData.conductClause' => (boolean) $request->input('conduct_clause') ?: false,
            'formData.policyPeriod' => '12 Months',
            'formData.cliamPremium' => (string) $request->input('claim_experience_details'),
            'formData.claimPremiyumDetails' => $claimPremiyumDetails,
            // 'formData.CoverAccomodation' => $coverAccObject,
            'formData.demolitionCost' => (string) $request->input('demolition_cost'),

        ];

        $formdata_object = array_merge($formdata_object, $formdata_object4);

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
                                $type = "Fire and Perils";
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
                                    $type = "Fire and Perils";
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
                            $type = "Property";
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

        if ($pipeline_details['formData']['saleClause'] == true) {
            $questions_array[] = 'Sale of interest clause';
            $answes_array[] = 'Yes';
        }
        if ($pipeline_details['formData']['fireBrigade'] == true) {
            $questions_array[] = 'Fire brigade and extinguishing clause';
            $answes_array[] = 'Yes';
        }
        if ($pipeline_details['formData']['clauseWording'] == true) {
            $questions_array[] = '72 Hours clause-wording modified- the 72 hours will stretch beyond the expiration of the policy period provided the first earthquake/flood/storm occurred prior to the expiry time of the policy';
            $answes_array[] = 'Yes';
        }
        if ($pipeline_details['formData']['automaticReinstatement'] == true) {
            $questions_array[] = 'Automatic reinstatement of sum insured at pro-rata additional premium';
            $answes_array[] = 'Yes';
        }
        if ($pipeline_details['formData']['capitalClause'] == true) {
            $questions_array[] = 'Capital addition clause';
            $answes_array[] = 'Yes';
        }
        if ($pipeline_details['formData']['mainClause'] == true) {
            $questions_array[] = "Workmen’s Maintenance clause";
            $answes_array[] = 'Yes';
        }
        if ($pipeline_details['formData']['repairCost'] == true) {
            $questions_array[] = 'Repair investigation costs';
            $answes_array[] = 'Yes';
        }
        if ($pipeline_details['formData']['debris'] == true) {
            $questions_array[] = 'Removal of debris';
            $answes_array[] = 'Yes';
        }
        if ($pipeline_details['formData']['reinstatementValClass'] == true) {
            $questions_array[] = 'Reinstatement Value  clause (85% condition of  average)';
            $answes_array[] = 'Yes';
        }
        if ($pipeline_details['formData']['waiver'] == true) {
            $questions_array[] = 'Waiver  of subrogation (against affiliates and subsidiaries)';
            $answes_array[] = 'Yes';
        }
        if ($pipeline_details['formData']['trace'] == true) {
            $questions_array[] = 'Trace and Access Clause';
            $answes_array[] = 'Yes';
        }
        if ($pipeline_details['formData']['publicClause'] == true) {
            $questions_array[] = 'Public authorities clause';
            $answes_array[] = 'Yes';
        }
        if ($pipeline_details['formData']['contentsClause'] == true) {
            $questions_array[] = 'All other contents clause';
            $answes_array[] = 'Yes';
        }
        if ($pipeline_details['formData']['errorOmission'] == true) {
            $questions_array[] = 'Errors & Omissions';
            $answes_array[] = 'Yes';
        }
        if ($pipeline_details['formData']['alterationClause'] == true) {
            $questions_array[] = 'Alteration and use  clause';
            $answes_array[] = 'Yes';
        }

        if ($pipeline_details['formData']['proFee'] == true) {
            $questions_array[] = 'Professional fees clause';
            $answes_array[] = 'Yes';
        }
        if ($pipeline_details['formData']['expenseClause'] == true) {
            $questions_array[] = 'Expediting expense clause';
            $answes_array[] = 'Yes';
        }

        if ($pipeline_details['formData']['tempRemovalClause'] == true) {
            $questions_array[] = 'Temporary removal clause';
            $answes_array[] = 'Yes';
        }

        if ($pipeline_details['formData']['desigClause'] == true) {
            $questions_array[] = 'Designation of property clause';
            $answes_array[] = 'Yes';
        }
        if ($pipeline_details['formData']['occupancy']['type'] == 'Residence' || $pipeline_details['formData']['occupancy']['type'] == 'Labour Camp') {
            $questions_array[] = 'Cover for alternative accommodation';
            $answes_array[] = $pipeline_details['formData']['occupancy']['type'];
        }

        if ($pipeline_details['formData']['cancelThirtyClause'] == true) {
            $questions_array[] = 'Cancellation clause-30 days either party subject to pro-rata refund of premium in either case unless a claim attached';
            $answes_array[] = 'Yes';
        }
        if ($pipeline_details['formData']['primaryInsuranceClause'] == true) {
            $questions_array[] = 'Primary insurance clause';
            $answes_array[] = 'Yes';
        }
        if ($pipeline_details['formData']['paymentAccountClause'] == true) {
            $questions_array[] = 'Payment on account clause (75%)';
            $answes_array[] = 'Yes';
        }

        if ($pipeline_details['formData']['nonInvalidClause'] == true) {
            $questions_array[] = 'Non-invalidation clause';
            $answes_array[] = 'Yes';
        }

        if ($pipeline_details['formData']['warrantyConditionClause'] == true) {
            $questions_array[] = 'Breach of warranty clause';
            $answes_array[] = 'Yes';
        }
        if ($pipeline_details['formData']['escalationClause'] == true) {
            $questions_array[] = 'Escalation clause';
            $answes_array[] = 'Yes';
        }

        if ($pipeline_details['formData']['addInterestClause'] == true) {
            $questions_array[] = 'Additional Interest Clause';
            $answes_array[] = 'Yes';
        }

        if (isset($pipeline_details['formData']['stock']) && $pipeline_details['formData']['stock'] != '') {
            $questions_array[] = 'Stock Declaration clause';
            $answes_array[] = 'Yes';
        }

        if ($pipeline_details['formData']['improvementClause'] == true) {
            $questions_array[] = 'Improvement and betterment clause';
            $answes_array[] = 'Yes';
        }

        if ($pipeline_details['formData']['automaticClause'] == true) {
            $questions_array[] = 'Automatic Addition deletion clause to be notified within 30 days period';
            $answes_array[] = 'Yes';
        }

        if ($pipeline_details['formData']['reduseLoseClause'] == true) {
            $questions_array[] = 'Expense to reduce the loss clause';
            $answes_array[] = 'Yes';
        }

        if ($pipeline_details['formData']['bankPolicy']['bankPolicy'] == true) {
            $questions_array[] = 'Loss payee clause';
            $answes_array[] = 'Yes';
        }

        if ($pipeline_details['formData']['buildingInclude'] != '') {
            $questions_array[] = 'Demolition clause';
            $answes_array[] = $pipeline_details['formData']['demolitionClause'] ? "Yes" : "No";
        }
        if ($pipeline_details['formData']['buildingInclude'] != '') {
            $questions_array[] = 'Adjoining building clause';
            $answes_array[] = $pipeline_details['formData']['buildingInclude'];
        }

        if (isset($pipeline_details['formData']['businessType']) && $pipeline_details['formData']['businessType'] != '') {
            $questions_array[] = 'Cover for exhibition risks';
            $answes_array[] = $pipeline_details['formData']['businessType'];
        }
        if ($pipeline_details['formData']['occupancy']['type'] == 'Warehouse'
            || @$pipeline_details['formData']['occupancy']['type'] == 'Factory'
            || @$pipeline_details['formData']['occupancy']['type'] == 'Others') {
            $questions_array[] = 'Cover for property in the open';
            $answes_array[] = $pipeline_details['formData']['occupancy']['type'];
        }
        if ($pipeline_details['formData']['otherItems'] != '') {
            $questions_array[] = 'Including property in the care, custody & control of the insured';
            $answes_array[] = 'Yes';
        }

        if (isset($pipeline_details['formData']['annualRent']) && $pipeline_details['formData']['annualRent'] != '') {
            $questions_array[] = 'Loss of rent';
            $answes_array[] = $pipeline_details['formData']['lossRent'];
        }

        $questions_array[] = 'No control clause';
        $answes_array[] = $pipeline_details['formData']['noControlClause'] ? "Yes" : "No";

        $questions_array[] = 'Claims preparation cost clause';
        $answes_array[] = $pipeline_details['formData']['preparationCostClause'] ? "Yes" : "No";

        $questions_array[] = 'Cover for property lying in the premises in containers';
        $answes_array[] = $pipeline_details['formData']['coverPropertyCon'] ? "Yes" : "No";

        $questions_array[] = 'Personal effects of employee';
        $answes_array[] = $pipeline_details['formData']['personalEffectsEmployee'] ? "Yes" : "No";

        $questions_array[] = 'Incidental Land Transit ';
        $answes_array[] = $pipeline_details['formData']['incidentLandTransit'] ? "Yes" : "No";

        $questions_array[] = 'Including loss or damage due to subsidence, ground heave or landslip';
        $answes_array[] = $pipeline_details['formData']['lossOrDamage'] ? "Yes" : "No";

        $questions_array[] = 'Nominated Loss Adjuster clause-Insured can select the loss surveyor out of a panel – John Kidd LA, Cunningham Lindsey, & Miller International';
        $answes_array[] = $pipeline_details['formData']['nominatedLossAdjusterClause'] ? "Yes" : "No";

        $questions_array[] = 'Sprinkler leakage clause';
        $answes_array[] = $pipeline_details['formData']['sprinkerLeakage'] ? "Yes" : "No";

        $questions_array[] = 'Minimization of loss clause';
        $answes_array[] = $pipeline_details['formData']['minLossClause'] ? "Yes" : "No";

        $questions_array[] = 'Increased cost of construction';
        $answes_array[] = $pipeline_details['formData']['costConstruction'] ? "Yes" : "No";

        $questions_array[] = 'Property Valuation clause';
        $answes_array[] = $pipeline_details['formData']['propertyValuationClause'] ? "Yes" : "No";

        $questions_array[] = 'Including accidental damage to plate glass, interior and exterior signs';
        $answes_array[] = $pipeline_details['formData']['accidentalDamage'] ? "Yes" : "No";

        $questions_array[] = 'Auditor’s fee';
        $answes_array[] = $pipeline_details['formData']['auditorsFee'] ? "Yes" : "No";

        $questions_array[] = 'Smoke and Soot damage extension';
        $answes_array[] = $pipeline_details['formData']['smokeSoot'] ? "Yes" : "No";

        $questions_array[] = 'Boiler explosion extension';
        $answes_array[] = $pipeline_details['formData']['boilerExplosion'] ? "Yes" : "No";

        $questions_array[] = 'Extra charges for airfreight';
        $answes_array[] = $pipeline_details['formData']['chargeAirfreight'] ? "Yes" : "No";

        if ($pipeline_details['formData']['tempRemoval'] == true) {
            $questions_array[] = 'Temporary repair clause';
            $answes_array[] = 'Yes';
        }

        $questions_array[] = 'Strike riot and civil commotion clause';
        $answes_array[] = $pipeline_details['formData']['strikeRiot'] ? "Yes" : "No";

        $questions_array[] = "Cover for  mechanical, electrical and electronic breakdown  for fixed non-mobile plant and machinery";
        $answes_array[] = $pipeline_details['formData']['coverMechanical'] ? "Yes" : "No";

        $questions_array[] = "Cover for external works including sign boards,  landscaping  including trees in building";
        $answes_array[] = $pipeline_details['formData']['coverExtWork'] ? "Yes" : "No";

        $questions_array[] = "Misdescription Clause";
        $answes_array[] = $pipeline_details['formData']['misdescriptionClause'] ? "Yes" : "No";

        $questions_array[] = "Other insurance allowed clause";
        $answes_array[] = $pipeline_details['formData']['otherInsuranceClause'] ? "Yes" : "No";

        $questions_array[] = "Automatic acquisition clause";
        $answes_array[] = $pipeline_details['formData']['automaticAcqClause'] ? "Yes" : "No";

        // $questions_array[] = "Cover for alternative accommodation";
        // $answes_array[] = $pipeline_details['formData']['occupancy']['type'];

        $questions_array[] = "Minor works extension";
        $answes_array[] = $pipeline_details['formData']['minorWorkExt'] ? "Yes" : "No";

        $questions_array[] = "Sale of Interest Clause";
        $answes_array[] = $pipeline_details['formData']['saleInterestClause'] ? "Yes" : "No";

        $questions_array[] = "Sue and labour clause";
        $answes_array[] = $pipeline_details['formData']['sueLabourClause'] ? "Yes" : "No";

        $questions_array[] = "Electrical clause waiver- Loss or damage by fire to electrical or electronic appliances , installations and wiring insured by this policy arising from or occasioned by over running, overheating excessive current, short circuiting, arcing, self-heating or leakage of electricity from whatever cause (lightning included) is covered ";
        $answes_array[] = $pipeline_details['formData']['electricalClause'] ? "Yes" : "No";

        // $questions_array[] = 'Loss payee clause ';
        // $answes_array[] = $pipeline_details['formData']['lossPayee'];
        if ($pipeline_details['formData']['businessType'] == "Art galleries/ fine arts collection"
        || $pipeline_details['formData']['businessType'] == "Colleges/ Universities/ schools & educational institute"
        || $pipeline_details['formData']['businessType'] == "Hotels/ boarding houses/ motels/ service apartments"
        || $pipeline_details['formData']['businessType'] == "Hotel multiple cover"
        || $pipeline_details['formData']['businessType'] == "Museum/ heritage sites"
        ) {
            if (isset($pipeline_details['formData']['coverCurios'])) {
                $questions_array[] = 'Cover for curios and work of art';
                $answes_array[] = $pipeline_details['formData']['businessType'];
            }
        }
        $questions_array[] = "Contract price clause";
        $answes_array[] = $pipeline_details['formData']['contractPriceClause'] ? "Yes" : "No";

        $questions_array[] = "Sprinkler upgradation clause";
        $answes_array[] = $pipeline_details['formData']['sprinklerUpgradationClause'] ? "Yes" : "No";

        $questions_array[] = "Accidental damage to fixed glass, glass (other than fixed glass)";
        $answes_array[] = $pipeline_details['formData']['accidentalFixClass'] ? "Yes" : "No";

        $questions_array[] = "Electronic installation, computers, data processing, equipment and other fragile or brittle object";
        $answes_array[] = $pipeline_details['formData']['electronicInstallation'] ? "Yes" : "No";

        $questions_array[] = "Brand and trademark";
        $answes_array[] = $pipeline_details['formData']['brandTrademark'] ? "Yes" : "No";

        if ($pipeline_details['formData']['ownerPrinciple'] == true) {
            $questions_array[] = 'Indemnity to owners and principals';
            $answes_array[] = 'Yes';
        }

        if ($pipeline_details['formData']['conductClause'] == true) {
            $questions_array[] = 'Conduct of business clause';
            $answes_array[] = 'Yes';
        }

        $questions_array[] = "Loss Notification – ‘as soon as reasonably practicable’";
        $answes_array[] = $pipeline_details['formData']['lossNotification'] ? "Yes" : "No";

        $questions_array[] = "Brokers Claim Handling Clause : A loss notification received by the Insurance Broker will be deemed as a loss notification to Insurer. All communications flowing between the Insurer, Insured and the appointed Loss Surveyor should be channelized through the Broker, unless there is any unavoidable reasons compelling direct communications between the parties";
        $answes_array[] = $pipeline_details['formData']['brockersClaimClause'] ? "Yes" : "No";

        if ($pipeline_details['formData']['businessInterruption']['business_interruption'] == true) {
            $questions_array[] = "Additional increase in cost of working";
            $answes_array[] = $pipeline_details['formData']['addCostWorking'] ? "Yes" : "No";
            $questions_array[] = "Claims preparation clause";
            $answes_array[] = $pipeline_details['formData']['claimPreparationClause'] ? "Yes" : "No";
            $questions_array[] = "Suppliers extension/customer extension";
            $answes_array[] = $pipeline_details['formData']['suppliersExtension'] ? "Yes" : "No";
            $questions_array[] = "Accountants clause";
            $answes_array[] = $pipeline_details['formData']['accountantsClause'] ? "Yes" : "No";
            $questions_array[] = "Payment on account";
            $answes_array[] = $pipeline_details['formData']['accountPayment'] ? "Yes" : "No";
            $questions_array[] = "Prevention/denial of access";
            $answes_array[] = $pipeline_details['formData']['preventionDenialClause'] ? "Yes" : "No";
            $questions_array[] = "Denial of access";
            $answes_array[] = $pipeline_details['formData']['DenialClause'] ? "Yes" : "No";
            $questions_array[] = "Premium adjustment clause";
            $answes_array[] = $pipeline_details['formData']['premiumAdjClause'] ? "Yes" : "No";
            $questions_array[] = "Public utilities clause";
            $answes_array[] = $pipeline_details['formData']['publicUtilityClause'] ? "Yes" : "No";
            $questions_array[] = "Brokers Claim Handling Clause : A loss notification received by the Insurance Broker will be deemed as a loss notification to Insurer. All communications flowing between the Insurer, Insured and the appointed Loss Surveyor should be channelized through the Broker, unless there is any unavoidable reasons compelling direct communications between the parties";
            $answes_array[] = $pipeline_details['formData']['brockersClaimHandlingClause'] ? "Yes" : "No";
            $questions_array[] = "Accounts recievable / Loss of booked debts";
            $answes_array[] = $pipeline_details['formData']['accountsRecievable'] ? "Yes" : "No";
            $questions_array[] = "Interdependany clause";
            $answes_array[] = $pipeline_details['formData']['interDependency'] ? "Yes" : "No";
            $questions_array[] = "Extra expense";
            $answes_array[] = $pipeline_details['formData']['extraExpense'] ? "Yes" : "No";
            $questions_array[] = "Contaminated water";
            $answes_array[] = $pipeline_details['formData']['contaminatedWater'] ? "Yes" : "No";
            $questions_array[] = "Auditors fees";
            $answes_array[] = $pipeline_details['formData']['auditorsFeeCheck'] ? "Yes" : "No";
            $questions_array[] = "Expense to reduce the loss";
            $answes_array[] = $pipeline_details['formData']['expenseReduceLoss'] ? "Yes" : "No";
            $questions_array[] = "Nominated loss adjuster";
            $answes_array[] = $pipeline_details['formData']['nominatedLossAdjuster'] ? "Yes" : "No";
            $questions_array[] = "Outbreak of discease";
            $answes_array[] = $pipeline_details['formData']['outbreakDiscease'] ? "Yes" : "No";
            $questions_array[] = "Failure of non public power supply";
            $answes_array[] = $pipeline_details['formData']['nonPublicFailure'] ? "Yes" : "No";
            $questions_array[] = "Murder, Suicide or outbreak of discease on the premises";
            $answes_array[] = $pipeline_details['formData']['premisesDetails'] ? "Yes" : "No";
            $questions_array[] = "Bombscare and unexploded devices on the premises";
            $answes_array[] = $pipeline_details['formData']['bombscare'] ? "Yes" : "No";
            $questions_array[] = "Book of Debts";
            $answes_array[] = $pipeline_details['formData']['bookDebits'] ? "Yes" : "No";
            $questions_array[] = "Failure of public utility";
            $answes_array[] = $pipeline_details['formData']['publicFailure'] ? "Yes" : "No";
            if (isset($pipeline_details['formData']['businessInterruption']['noLocations']) && $pipeline_details['formData']['businessInterruption']['noLocations'] > 1) {
                $questions_array[] = "Departmental clause";
                $answes_array[] = $pipeline_details['formData']['departmentalClause'] ? "Yes" : "No";
                $questions_array[] = "Rent & Lease hold interest";
                $answes_array[] = $pipeline_details['formData']['rentLease'] ? "Yes" : "No";
            }
            if (isset($pipeline_details['formData']['CoverAccomodation']['coverAccomodation']) &&
                $pipeline_details['formData']['CoverAccomodation']['coverAccomodation'] == true) {
                $questions_array[] = "Cover for alternate accomodation";
                $answes_array[] = $pipeline_details['formData']['CoverAccomodation']['coverAccomodation'] ? "Yes" : "No";
            }
            if ($pipeline_details['formData']['contingentBusiness'] == true) {
                $questions_array[] = "Contingent business inetruption and contingent extra expense";
                $answes_array[] = $pipeline_details['formData']['contingentBusiness'] ? "Yes" : "No";
            }
            if ($pipeline_details['formData']['demolitionCost'] == true) {
                $questions_array[] = "Demolition and increased cost of construction";
                $answes_array[] = $pipeline_details['formData']['demolitionCost'] ? "Yes" : "No";
            }
            if ($pipeline_details['formData']['nonOwnedProperties'] == true) {
                $questions_array[] = "Non Owned property in vicinity interuption";
                $answes_array[] = $pipeline_details['formData']['nonOwnedProperties'] ? "Yes" : "No";
            }
            if ($pipeline_details['formData']['royalties'] == true) {
                $questions_array[] = "Royalties";
                $answes_array[] = $pipeline_details['formData']['royalties'] ? "Yes" : "No";
            }
        }

        if (isset($pipeline_details['formData']['cliamPremium']) &&
            $pipeline_details['formData']['cliamPremium'] == 'combined_data') {
            $questions_array[] = "Deductible for Property";
            $answes_array[] = $pipeline_details['formData']['claimPremiyumDetails']['deductableProperty'];
            $questions_array[] = "Deductible for Business Interruption";
            $answes_array[] = $pipeline_details['formData']['claimPremiyumDetails']['deductableBusiness'];
            $questions_array[] = "Rate required (combined)";
            $answes_array[] = $pipeline_details['formData']['claimPremiyumDetails']['rateCombined'];
            $questions_array[] = "Premium required (combined)";
            $answes_array[] = $pipeline_details['formData']['claimPremiyumDetails']['premiumCombined'];
            $questions_array[] = "Brokerage (combined)";
            $answes_array[] = $pipeline_details['formData']['claimPremiyumDetails']['brokerage'];
            $questions_array[] = "Warranty (Property)";
            $answes_array[] = $pipeline_details['formData']['claimPremiyumDetails']['warrantyProperty'];
            $questions_array[] = "Warranty (Business Interruption)";
            $answes_array[] = $pipeline_details['formData']['claimPremiyumDetails']['warrantyBusiness'];
            $questions_array[] = "Exclusion (Property)";
            $answes_array[] = $pipeline_details['formData']['claimPremiyumDetails']['exclusionProperty'];
            $questions_array[] = "Exclusion (Business Interruption)";
            $answes_array[] = $pipeline_details['formData']['claimPremiyumDetails']['exclusionBusiness'];
            $questions_array[] = "Special Condition (Property)";
            $answes_array[] = $pipeline_details['formData']['claimPremiyumDetails']['specialProperty'];
            $questions_array[] = "Special Condition (Business Interruption)";
            $answes_array[] = $pipeline_details['formData']['claimPremiyumDetails']['specialBusiness'];
        }

        if (isset($pipeline_details['formData']['cliamPremium']) &&
            $pipeline_details['formData']['cliamPremium'] == 'only_fire') {
            $questions_array[] = "Deductible";
            $answes_array[] = $pipeline_details['formData']['claimPremiyumDetails']['deductableProperty'];
            $questions_array[] = "Rate required";
            $answes_array[] = $pipeline_details['formData']['claimPremiyumDetails']['propertyRate'];
            $questions_array[] = "Premium required";
            $answes_array[] = $pipeline_details['formData']['claimPremiyumDetails']['propertyPremium'];
            $questions_array[] = "Brokerage";
            $answes_array[] = $pipeline_details['formData']['claimPremiyumDetails']['propertyBrockerage'];
            $questions_array[] = "Warranty";
            $answes_array[] = $pipeline_details['formData']['claimPremiyumDetails']['propertyWarranty'];
            $questions_array[] = "Exclusion";
            $answes_array[] = $pipeline_details['formData']['claimPremiyumDetails']['propertyExclusion'];
            $questions_array[] = "Special Condition";
            $answes_array[] = $pipeline_details['formData']['claimPremiyumDetails']['propertySpecial'];
        }

        if (isset($pipeline_details['formData']['cliamPremium']) &&
            $pipeline_details['formData']['cliamPremium'] == 'separate_fire') {
            $questions_array[] = "Deductible for (Property)";
            $answes_array[] = $pipeline_details['formData']['claimPremiyumDetails']['propertySeparateDeductable'];
            $questions_array[] = "Rate required (Property)";
            $answes_array[] = $pipeline_details['formData']['claimPremiyumDetails']['propertySeparateRate'];
            $questions_array[] = "Premium required (Property)";
            $answes_array[] = $pipeline_details['formData']['claimPremiyumDetails']['propertySeparatePremium'];
            $questions_array[] = "Brokerage (Property)";
            $answes_array[] = $pipeline_details['formData']['claimPremiyumDetails']['propertySeparateBrokerage'];
            $questions_array[] = "Warranty (Property)";
            $answes_array[] = $pipeline_details['formData']['claimPremiyumDetails']['propertySeparateWarranty'];
            $questions_array[] = "Exclusion (Property)";
            $answes_array[] = $pipeline_details['formData']['claimPremiyumDetails']['propertySeparateExclusion'];
            $questions_array[] = "Special Condition (Property)";
            $answes_array[] = $pipeline_details['formData']['claimPremiyumDetails']['propertySeparateSpecial'];

            $questions_array[] = "Deductible for (Business Interruption)";
            $answes_array[] = $pipeline_details['formData']['claimPremiyumDetails']['businessSeparateDeductable'];
            $questions_array[] = "Rate required (Business Interruption)";
            $answes_array[] = $pipeline_details['formData']['claimPremiyumDetails']['businessSeparateRate'];
            $questions_array[] = "Premium required (Business Interruption)";
            $answes_array[] = $pipeline_details['formData']['claimPremiyumDetails']['businessSeparatePremium'];
            $questions_array[] = "Brokerage (Business Interruption)";
            $answes_array[] = $pipeline_details['formData']['claimPremiyumDetails']['businessSeparateBrokerage'];
            $questions_array[] = "Warranty (Business Interruption)";
            $answes_array[] = $pipeline_details['formData']['claimPremiyumDetails']['businessSeparateWarranty'];
            $questions_array[] = "Exclusion (Business Interruption)";
            $answes_array[] = $pipeline_details['formData']['claimPremiyumDetails']['businessSeparateExclusion'];
            $questions_array[] = "Special Condition (Business Interruption)";
            $answes_array[] = $pipeline_details['formData']['claimPremiyumDetails']['businessSeparateSpecial'];
        }

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
            $excel->sheet('Fire & Perils', function ($sheet) use ($data) {
                $sheet->fromArray($data, null, 'A1', true, false);
                $sheet->row(1, function ($row) {
                    $row->setFontSize(10);
                    $row->setFontColor('#ffffff');
                    $row->setBackground('#1155CC');
                });
                $sheet->protect('password');
                $sheet->getStyle('C2:D114')->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
                $sheet->setAutoSize(true);
                $sheet->setWidth('A', 70);
                $sheet->getRowDimension(1)->setRowHeight(10);
                $sheet->setWidth('B', 50);
                $sheet->getStyle('A0:A113')->getAlignment()->setWrapText(true);
                $sheet->getStyle('B0:B113')->getAlignment()->setWrapText(true);
            });
        })->store('xls', public_path('excel'));
        return $file_name_;
    }

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

            return view('pipelines.fire_perils.e_quotations')->with(compact('pipeline_details', 'insures_name', 'insures_details', 'insures_id', 'id_insurer'));
        } else {
            return view('error');
        }
    }
    /**
     * imported list
     */
    public function importedList()
    {
        $data1 = ImportExcel::first();
        $data = $data1['upload'];
        $pipeline_id = $data1['pipeline_id'];
        $insurer_id = $data1['insurer_id'];
        return view('pipelines.fire_perils.imported_list', compact('data', 'pipeline_id', 'insurer_id'));
    }

    /**
     * save imported list to pipeline details
     */
    public function saveImportedList(Request $request)
    {

        // var_dump('in');die;
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
        $claimObject = new \stdClass();

        foreach ($questions as $key => $question) {
            if ($pipeline_details['formData']['saleClause'] == true && $question == 'Sale of interest clause') {
                $insurerReplay_object->saleClause = ucwords($insurer_response_array[$key]);
            }
            if ($pipeline_details['formData']['fireBrigade'] == true && $question == 'Fire brigade and extinguishing clause') {
                $fireBrigade_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $fireBrigade_object->isAgree = ucwords($insurer_response_array[$key]);
                $fireBrigade_object->comment = ucwords($comments);
                $insurerReplay_object->fireBrigade = $fireBrigade_object;
            }
            if ($pipeline_details['formData']['clauseWording'] == true && $question == '72 Hours clause-wording modified- the 72 hours will stretch beyond the expiration of the policy period provided the first earthquake/flood/storm occurred prior to the expiry time of the policy') {
                $insurerReplay_object->clauseWording = ucwords($insurer_response_array[$key]);
            }
            if ($pipeline_details['formData']['automaticReinstatement'] == true && $question == 'Automatic reinstatement of sum insured at pro-rata additional premium') {
                $insurerReplay_object->automaticReinstatement = ucwords($insurer_response_array[$key]);
            }
            if ($pipeline_details['formData']['capitalClause'] == true && $question == 'Capital addition clause') {
                $capitalClause_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $capitalClause_object->isAgree = ucwords($insurer_response_array[$key]);
                $capitalClause_object->comment = ucwords($comments);
                $insurerReplay_object->capitalClause = $capitalClause_object;
            }
            if ($pipeline_details['formData']['mainClause'] == true && $question == 'Workmen’s Maintenance clause') {
                $insurerReplay_object->mainClause = ucwords($insurer_response_array[$key]);
            }
            if ($pipeline_details['formData']['repairCost'] == true && $question == 'Repair investigation costs') {
                $repairCost_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $repairCost_object->isAgree = ucwords($insurer_response_array[$key]);
                $repairCost_object->comment = ucwords($comments);
                $insurerReplay_object->repairCost = $repairCost_object;
            }
            if ($pipeline_details['formData']['debris'] == true && $question == 'Removal of debris') {
                $debris_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $debris_object->isAgree = ucwords($insurer_response_array[$key]);
                $debris_object->comment = ucwords($comments);
                $insurerReplay_object->debris = $debris_object;
            }
            if ($pipeline_details['formData']['reinstatementValClass'] == true && $question == 'Reinstatement Value  clause (85% condition of  average)') {
                $insurerReplay_object->reinstatementValClass = ucwords($insurer_response_array[$key]);
            }
            if ($pipeline_details['formData']['waiver'] == true && $question == 'Waiver  of subrogation (against affiliates and subsidiaries)') {
                $insurerReplay_object->waiver = ucwords($insurer_response_array[$key]);
            }
            if ($pipeline_details['formData']['trace'] == true && $question == 'Trace and Access Clause') {
                $insurerReplay_object->trace = ucwords($insurer_response_array[$key]);
            }
            if ($pipeline_details['formData']['publicClause'] == true && $question == 'Public authorities clause') {
                $publicClause_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $publicClause_object->isAgree = ucwords($insurer_response_array[$key]);
                $publicClause_object->comment = ucwords($comments);
                $insurerReplay_object->publicClause = $publicClause_object;
            }
            if ($pipeline_details['formData']['contentsClause'] == true && $question == 'All other contents clause') {
                $contentsClause_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $contentsClause_object->isAgree = ucwords($insurer_response_array[$key]);
                $contentsClause_object->comment = ucwords($comments);
                $insurerReplay_object->contentsClause = $contentsClause_object;
            }
            if ($pipeline_details['formData']['errorOmission'] == true && $question == 'Errors & Omissions') {
                $insurerReplay_object->errorOmission = ucwords($insurer_response_array[$key]);
            }
            if ($pipeline_details['formData']['alterationClause'] == true && $question == 'Alteration and use  clause') {
                $insurerReplay_object->alterationClause = ucwords($insurer_response_array[$key]);
            }

            if ($pipeline_details['formData']['proFee'] == true && $question == 'Professional fees clause') {
                $proFee_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $proFee_object->isAgree = ucwords($insurer_response_array[$key]);
                $proFee_object->comment = ucwords($comments);
                $insurerReplay_object->proFee = $proFee_object;
            }
            if ($pipeline_details['formData']['expenseClause'] == true && $question == 'Expediting expense clause') {
                $expenseClause_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $expenseClause_object->isAgree = ucwords($insurer_response_array[$key]);
                $expenseClause_object->comment = ucwords($comments);
                $insurerReplay_object->expenseClause = $expenseClause_object;
            }
            if ($pipeline_details['formData']['desigClause'] == true && $question == 'Designation of property clause') {
                $desigClause_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $desigClause_object->isAgree = ucwords($insurer_response_array[$key]);
                $desigClause_object->comment = ucwords($comments);
                $insurerReplay_object->desigClause = $desigClause_object;
            }
            if ($question == 'Adjoining building clause') {
                $insurerReplay_object->adjBusinessClause = ucwords($insurer_response_array[$key]);
            }
            if ($pipeline_details['formData']['cancelThirtyClause'] == true && $question == 'Cancellation clause-30 days either party subject to pro-rata refund of premium in either case unless a claim attached') {
                $insurerReplay_object->cancelThirtyClause = ucwords($insurer_response_array[$key]);
            }
            if ($pipeline_details['formData']['primaryInsuranceClause'] == true && $question == 'Primary insurance clause') {
                $insurerReplay_object->primaryInsuranceClause = ucwords($insurer_response_array[$key]);
            }

            if ($pipeline_details['formData']['paymentAccountClause'] == true && $question == 'Payment on account clause') {
                $paymentAccountClause_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $paymentAccountClause_object->isAgree = ucwords($insurer_response_array[$key]);
                $paymentAccountClause_object->comment = ucwords($comments);
                $insurerReplay_object->paymentAccountClause = $paymentAccountClause_object;
            }
            if ($pipeline_details['formData']['nonInvalidClause'] == true && $question == 'Non-invalidation clause') {
                $insurerReplay_object->nonInvalidClause = ucwords($insurer_response_array[$key]);
            }
            if ($pipeline_details['formData']['warrantyConditionClause'] == true && $question == 'Breach of warranty clause') {
                $insurerReplay_object->warrantyConditionClause = ucwords($insurer_response_array[$key]);
            }
            if ($pipeline_details['formData']['escalationClause'] == true && $question == 'Escalation clause') {
                $escalationClause_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $escalationClause_object->isAgree = ucwords($insurer_response_array[$key]);
                $escalationClause_object->comment = ucwords($comments);
                $insurerReplay_object->escalationClause = $escalationClause_object;
            }
            if ($pipeline_details['formData']['addInterestClause'] == true && $question == 'Additional Interest Clause') {
                $insurerReplay_object->addInterestClause = ucwords($insurer_response_array[$key]);
            }
            if (isset($pipeline_details['formData']['stock']) && $pipeline_details['formData']['stock'] != '' && $question == 'Stock Declaration clause') {
                $stock_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $stock_object->isAgree = ucwords($insurer_response_array[$key]);
                $stock_object->comment = ucwords($comments);
                $insurerReplay_object->stockDeclaration = $stock_object;
            }
            if ($pipeline_details['formData']['improvementClause'] == true && $question == 'Improvement and betterment clause') {
                $insurerReplay_object->improvementClause = ucwords($insurer_response_array[$key]);
            }
            if ($pipeline_details['formData']['automaticClause'] == true && $question == 'Automatic Addition deletion clause to be notified within 30 days period') {
                $automaticClause_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $automaticClause_object->isAgree = ucwords($insurer_response_array[$key]);
                $automaticClause_object->comment = ucwords($comments);
                $insurerReplay_object->automaticClause = $automaticClause_object;
            }
            if ($pipeline_details['formData']['reduseLoseClause'] == true && $question == 'Expense to reduce the loss clause') {
                $reduseLoseClause_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $reduseLoseClause_object->isAgree = ucwords($insurer_response_array[$key]);
                $reduseLoseClause_object->comment = ucwords($comments);
                $insurerReplay_object->reduseLoseClause = $reduseLoseClause_object;
            }
            if ($pipeline_details['formData']['buildingInclude'] != '' &&
                $pipeline_details['formData']['demolitionClause'] == true &&
                $question == 'Demolition clause') {
                $demolitionClause_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $demolitionClause_object->isAgree = ucwords($insurer_response_array[$key]);
                $demolitionClause_object->comment = ucwords($comments);
                $insurerReplay_object->demolitionClause = $demolitionClause_object;
            }
            if ($pipeline_details['formData']['noControlClause'] == true && $question == 'No control clause') {
                $insurerReplay_object->noControlClause = ucwords($insurer_response_array[$key]);
            }
            if ($pipeline_details['formData']['preparationCostClause'] == true && $question == 'Claims preparation cost clause') {
                $preparationCostClause_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $preparationCostClause_object->isAgree = ucwords($insurer_response_array[$key]);
                $preparationCostClause_object->comment = ucwords($comments);
                $insurerReplay_object->preparationCostClause = $preparationCostClause_object;
            }
            if ($pipeline_details['formData']['coverPropertyCon'] == true && $question == 'Cover for property lying in the premises in containers') {
                $insurerReplay_object->coverPropertyCon = ucwords($insurer_response_array[$key]);
            }
            if ($pipeline_details['formData']['personalEffectsEmployee'] == true && $question == 'Personal effects of employee') {
                $personalEffectsEmployee_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $personalEffectsEmployee_object->isAgree = ucwords($insurer_response_array[$key]);
                $personalEffectsEmployee_object->comment = ucwords($comments);
                $insurerReplay_object->personalEffectsEmployee = $personalEffectsEmployee_object;
            }
            if ($pipeline_details['formData']['incidentLandTransit'] == true && $question == 'Incidental Land Transit') {
                $incidentLandTransit_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $incidentLandTransit_object->isAgree = ucwords($insurer_response_array[$key]);
                $incidentLandTransit_object->comment = ucwords($comments);
                $insurerReplay_object->incidentLandTransit = $incidentLandTransit_object;
            }
            if ($pipeline_details['formData']['lossOrDamage'] == true && $question == 'Including loss or damage due to subsidence, ground heave or landslip') {
                $insurerReplay_object->lossOrDamage = ucwords($insurer_response_array[$key]);
            }
            if ($pipeline_details['formData']['nominatedLossAdjusterClause'] == true &&
                $question == 'Nominated Loss Adjuster clause-Insured can select the loss surveyor out of a panel – John Kidd LA, Cunningham Lindsey, & Miller International') {
                $nominatedLossAdjusterClause_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $nominatedLossAdjusterClause_object->isAgree = ucwords($insurer_response_array[$key]);
                $nominatedLossAdjusterClause_object->comment = ucwords($comments);
                $insurerReplay_object->nominatedLossAdjusterClause = $nominatedLossAdjusterClause_object;
            }
            if ($pipeline_details['formData']['sprinkerLeakage'] == true && $question == 'Sprinkler leakage clause') {
                $insurerReplay_object->sprinkerLeakage = ucwords($insurer_response_array[$key]);
            }
            if ($pipeline_details['formData']['minLossClause'] == true &&
                $question == 'Minimization of loss clause') {
                $minLossClause_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $minLossClause_object->isAgree = ucwords($insurer_response_array[$key]);
                $minLossClause_object->comment = ucwords($comments);
                $insurerReplay_object->minLossClause = $minLossClause_object;
            }
            if ($pipeline_details['formData']['costConstruction'] == true &&
                $question == 'Increased cost of construction') {
                $costConstruction_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $costConstruction_object->isAgree = ucwords($insurer_response_array[$key]);
                $costConstruction_object->comment = ucwords($comments);
                $insurerReplay_object->costConstruction = $costConstruction_object;
            }
            if (isset($pipeline_details['formData']['annualRent']) && $pipeline_details['formData']['annualRent'] != '' && $question == 'Loss of rent') {
                $rent_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $rent_object->isAgree = ucwords($insurer_response_array[$key]);
                $rent_object->comment = ucwords($comments);
                $insurerReplay_object->lossRent = $rent_object;
            }
            if ($pipeline_details['formData']['propertyValuationClause'] == true &&
                $question == 'Property Valuation clause') {
                $propertyValuationClause_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $propertyValuationClause_object->isAgree = ucwords($insurer_response_array[$key]);
                $propertyValuationClause_object->comment = ucwords($comments);
                $insurerReplay_object->propertyValuationClause = $propertyValuationClause_object;
            }
            if ($pipeline_details['formData']['accidentalDamage'] == true &&
                $question == 'Including accidental damage to plate glass, interior and exterior signs') {
                $accidentalDamage_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $accidentalDamage_object->isAgree = ucwords($insurer_response_array[$key]);
                $accidentalDamage_object->comment = ucwords($comments);
                $insurerReplay_object->accidentalDamage = $accidentalDamage_object;
            }
            if ($pipeline_details['formData']['auditorsFee'] == true &&
                $question == 'Auditor’s fee') {
                $auditorsFee_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $auditorsFee_object->isAgree = ucwords($insurer_response_array[$key]);
                $auditorsFee_object->comment = ucwords($comments);
                $insurerReplay_object->auditorsFee = $auditorsFee_object;
            }
            if ($pipeline_details['formData']['smokeSoot'] == true && $question == 'Smoke and Soot damage extension') {
                $insurerReplay_object->smokeSoot = ucwords($insurer_response_array[$key]);
            }
            if ($pipeline_details['formData']['boilerExplosion'] == true && $question == 'Boiler explosion extension') {
                $insurerReplay_object->boilerExplosion = ucwords($insurer_response_array[$key]);
            }
            if ($pipeline_details['formData']['chargeAirfreight'] == true &&
                $question == 'Extra charges for airfreight') {
                $chargeAirfreight_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $chargeAirfreight_object->isAgree = ucwords($insurer_response_array[$key]);
                $chargeAirfreight_object->comment = ucwords($comments);
                $insurerReplay_object->chargeAirfreight = $chargeAirfreight_object;
            }
            if ($pipeline_details['formData']['tempRemoval'] == true && $question == 'Temporary repair clause') {
                $insurerReplay_object->tempRemoval = ucwords($insurer_response_array[$key]);
            }
            if ($pipeline_details['formData']['strikeRiot'] == true &&
                $question == 'Strike riot and civil commotion clause') {
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
            if ($pipeline_details['formData']['coverMechanical'] == true &&
                $question == 'Cover for  mechanical, electrical and electronic breakdown  for fixed non-mobile plant and machinery') {
                $insurerReplay_object->coverMechanical = ucwords($insurer_response_array[$key]);
            }
            if ($pipeline_details['formData']['coverExtWork'] == true &&
                $question == 'Cover for external works including sign boards,  landscaping  including trees in building') {
                $insurerReplay_object->coverExtWork = ucwords($insurer_response_array[$key]);
            }
            if ($pipeline_details['formData']['misdescriptionClause'] == true &&
                $question == 'Misdescription Clause') {
                $insurerReplay_object->misdescriptionClause = ucwords($insurer_response_array[$key]);
            }
            if ($pipeline_details['formData']['tempRemovalClause'] == true &&
                $question == 'Temporary removal clause') {
                $insurerReplay_object->tempRemovalClause = ucwords($insurer_response_array[$key]);
            }
            if ($pipeline_details['formData']['otherInsuranceClause'] == true &&
                $question == 'Other insurance allowed clause') {
                $insurerReplay_object->otherInsuranceClause = ucwords($insurer_response_array[$key]);
            }
            if ($pipeline_details['formData']['automaticAcqClause'] == true &&
                $question == 'Automatic acquisition clause') {
                $insurerReplay_object->automaticAcqClause = ucwords($insurer_response_array[$key]);
            }
            if ($pipeline_details['formData']['occupancy']['type'] == 'Residence' && $question == 'Cover for alternative accommodation' || $pipeline_details['formData']['occupancy']['type'] == 'Labour Camp' && $question == 'Cover for alternative accommodation') {
                $coverAlternative_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $coverAlternative_object->isAgree = ucwords($insurer_response_array[$key]);
                $coverAlternative_object->comment = ucwords($comments);
                $insurerReplay_object->coverAlternative = $coverAlternative_object;
            }
            if ($pipeline_details['formData']['businessType'] && $question == 'Cover for exhibition risks') {
                $insurerReplay_object->coverExihibition = ucwords($insurer_response_array[$key]);
            }
            if ((@$pipeline_details['formData']['occupancy']['type'] == 'Warehouse'
                || @$pipeline_details['formData']['occupancy']['type'] == 'Factory'
                || @$pipeline_details['formData']['occupancy']['type'] == 'Others') && $question == 'Cover for property in the open') {
                $insurerReplay_object->coverProperty = ucwords($insurer_response_array[$key]);
            }
            if ($pipeline_details['formData']['otherItems'] != '' && $question == 'Including property in the care, custody & control of the insured') {
                $propertyCare_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $propertyCare_object->isAgree = ucwords($insurer_response_array[$key]);
                $propertyCare_object->comment = ucwords($comments);
                $insurerReplay_object->propertyCare = $propertyCare_object;
            }
            if ($pipeline_details['formData']['minorWorkExt'] == true && $question == 'Minor works extension') {
                $minorWorkExt_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $minorWorkExt_object->isAgree = ucwords($insurer_response_array[$key]);
                $minorWorkExt_object->comment = ucwords($comments);
                $insurerReplay_object->minorWorkExt = $minorWorkExt_object;
            }
            if ($pipeline_details['formData']['saleInterestClause'] == true &&
                $question == 'Sale of Interest Clause') {
                $insurerReplay_object->saleInterestClause = ucwords($insurer_response_array[$key]);
            }
            if ($pipeline_details['formData']['sueLabourClause'] == true &&
                $question == 'Sue and labour clause') {
                $insurerReplay_object->sueLabourClause = ucwords($insurer_response_array[$key]);
            }
            if ($pipeline_details['formData']['bankPolicy']['bankPolicy'] == true && $question == 'Loss payee clause') {
                $insurerReplay_object->lossPayee = ucwords($insurer_response_array[$key]);
            }
            if ($pipeline_details['formData']['electricalClause'] == true &&
                $question == 'Electrical clause waiver- Loss or damage by fire to electrical or electronic appliances , installations and wiring insured by this policy arising from or occasioned by over running, overheating excessive current, short circuiting, arcing, self-heating or leakage of electricity from whatever cause (lightning included) is covered') {
                $insurerReplay_object->electricalClause = ucwords($insurer_response_array[$key]);
            }
            if ($pipeline_details['formData']['contractPriceClause'] == true &&
                $question == 'Contract price clause') {
                $insurerReplay_object->contractPriceClause = ucwords($insurer_response_array[$key]);
            }
            if ($pipeline_details['formData']['sprinklerUpgradationClause'] == true &&
                $question == 'Sprinkler upgradation clause') {
                $insurerReplay_object->sprinklerUpgradationClause = ucwords($insurer_response_array[$key]);
            }
            if ($pipeline_details['formData']['accidentalFixClass'] == true && $question == 'Accidental damage to fixed glass, glass (other than fixed glass)') {
                $accidentalFixClass_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $accidentalFixClass_object->isAgree = ucwords($insurer_response_array[$key]);
                $accidentalFixClass_object->comment = ucwords($comments);
                $insurerReplay_object->accidentalFixClass = $accidentalFixClass_object;
            }
            if ($pipeline_details['formData']['electronicInstallation'] == true &&
                $question == 'Electronic installation, computers, data processing, equipment and other fragile or brittle object') {
                $insurerReplay_object->electronicInstallation = ucwords($insurer_response_array[$key]);
            }

            if (($pipeline_details['formData']['businessType'] == "Art galleries/ fine arts collection"
                || $pipeline_details['formData']['businessType'] == "Colleges/ Universities/ schools & educational institute"
                || $pipeline_details['formData']['businessType'] == "Hotels/ boarding houses/ motels/ service apartments"
                || $pipeline_details['formData']['businessType'] == "Hotel multiple cover"
                || $pipeline_details['formData']['businessType'] == "Museum/ heritage sites") && isset($pipeline_details['formData']['coverCurios'])
                && $question == 'Cover for curios and work of art') {
                $insurerReplay_object->coverCurios = ucwords($insurer_response_array[$key]);
            }

            if ($pipeline_details['formData']['brandTrademark'] == true &&
                $question == 'Brand and trademark') {
                $insurerReplay_object->brandTrademark = ucwords($insurer_response_array[$key]);
            }
            if ($pipeline_details['formData']['ownerPrinciple'] == true && $question == 'Indemnity to owners and principals') {
                $insurerReplay_object->ownerPrinciple = ucwords($insurer_response_array[$key]);
            }
            if ($pipeline_details['formData']['conductClause'] == true && $question == 'Conduct of business clause') {
                $insurerReplay_object->conductClause = ucwords($insurer_response_array[$key]);
            }
            if ($pipeline_details['formData']['lossNotification'] == true &&
                $question == "Loss Notification – ‘as soon as reasonably practicable’") {
                $insurerReplay_object->lossNotification = ucwords($insurer_response_array[$key]);
            }
            if ($pipeline_details['formData']['brockersClaimClause'] == true &&
                $question == "Brokers Claim Handling Clause : A loss notification received by the Insurance Broker will be deemed as a loss notification to Insurer. All communications flowing between the Insurer, Insured and the appointed Loss Surveyor should be channelized through the Broker, unless there is any unavoidable reasons compelling direct communications between the parties") {
                $insurerReplay_object->brockersClaimClause = ucwords($insurer_response_array[$key]);
            }
            if ($pipeline_details['formData']['businessInterruption']['business_interruption'] == true) {
                if ($pipeline_details['formData']['addCostWorking'] == true && $question == 'Additional increase in cost of working') {
                    $insurerReplay_object->addCostWorking = ucwords($insurer_response_array[$key]);
                }
                if ($pipeline_details['formData']['claimPreparationClause'] == true && $question == 'Claims preparation clause') {
                    $claimPreparationClause_object = new \stdClass();
                    if ($new_comments__array[$key] == '--') {
                        $comments = '';
                    } else {
                        $comments = $new_comments__array[$key];
                    }
                    $claimPreparationClause_object->isAgree = ucwords($insurer_response_array[$key]);
                    $claimPreparationClause_object->comment = ucwords($comments);
                    $insurerReplay_object->claimPreparationClause = $claimPreparationClause_object;
                }
                if ($pipeline_details['formData']['suppliersExtension'] == true && $question == 'Suppliers extension/customer extension') {
                    $suppliersExtension_object = new \stdClass();
                    if ($new_comments__array[$key] == '--') {
                        $comments = '';
                    } else {
                        $comments = $new_comments__array[$key];
                    }
                    $suppliersExtension_object->isAgree = ucwords($insurer_response_array[$key]);
                    $suppliersExtension_object->comment = ucwords($comments);
                    $insurerReplay_object->suppliersExtension = $suppliersExtension_object;
                }
                if ($pipeline_details['formData']['accountantsClause'] == true && $question == 'Accountants clause') {
                    $accountantsClause_object = new \stdClass();
                    if ($new_comments__array[$key] == '--') {
                        $comments = '';
                    } else {
                        $comments = $new_comments__array[$key];
                    }
                    $accountantsClause_object->isAgree = ucwords($insurer_response_array[$key]);
                    $accountantsClause_object->comment = ucwords($comments);
                    $insurerReplay_object->accountantsClause = $accountantsClause_object;
                }
                if ($pipeline_details['formData']['accountPayment'] == true && $question == 'Payment on account') {
                    $accountPayment_object = new \stdClass();
                    if ($new_comments__array[$key] == '--') {
                        $comments = '';
                    } else {
                        $comments = $new_comments__array[$key];
                    }
                    $accountPayment_object->isAgree = ucwords($insurer_response_array[$key]);
                    $accountPayment_object->comment = ucwords($comments);
                    $insurerReplay_object->accountPayment = $accountPayment_object;
                }
                if ($pipeline_details['formData']['preventionDenialClause'] == true && $question == 'Prevention/denial of access') {
                    $preventionDenialClause_object = new \stdClass();
                    if ($new_comments__array[$key] == '--') {
                        $comments = '';
                    } else {
                        $comments = $new_comments__array[$key];
                    }
                    $preventionDenialClause_object->isAgree = ucwords($insurer_response_array[$key]);
                    $preventionDenialClause_object->comment = ucwords($comments);
                    $insurerReplay_object->preventionDenialClause = $preventionDenialClause_object;
                }

                if ($pipeline_details['formData']['premiumAdjClause'] == true && $question == 'Premium adjustment clause') {
                    $premiumAdjClause_object = new \stdClass();
                    if ($new_comments__array[$key] == '--') {
                        $comments = '';
                    } else {
                        $comments = $new_comments__array[$key];
                    }
                    $premiumAdjClause_object->isAgree = ucwords($insurer_response_array[$key]);
                    $premiumAdjClause_object->comment = ucwords($comments);
                    $insurerReplay_object->premiumAdjClause = $premiumAdjClause_object;
                }
                if ($pipeline_details['formData']['publicUtilityClause'] == true && $question == 'Public utilities clause') {
                    $publicUtilityClause_object = new \stdClass();
                    if ($new_comments__array[$key] == '--') {
                        $comments = '';
                    } else {
                        $comments = $new_comments__array[$key];
                    }
                    $publicUtilityClause_object->isAgree = ucwords($insurer_response_array[$key]);
                    $publicUtilityClause_object->comment = ucwords($comments);
                    $insurerReplay_object->publicUtilityClause = $publicUtilityClause_object;
                }
                if ($pipeline_details['formData']['brockersClaimHandlingClause'] == true &&
                    $question == "Brokers Claim Handling Clause : A loss notification received by the Insurance Broker will be deemed as a loss notification to Insurer. All communications flowing between the Insurer, Insured and the appointed Loss Surveyor should be channelized through the Broker, unless there is any unavoidable reasons compelling direct communications between the parties") {
                    $insurerReplay_object->brockersClaimHandlingClause = ucwords($insurer_response_array[$key]);
                }
                if ($pipeline_details['formData']['accountsRecievable'] == true && $question == 'Accounts recievable / Loss of booked debts') {
                    $accountsRecievable_object = new \stdClass();
                    if ($new_comments__array[$key] == '--') {
                        $comments = '';
                    } else {
                        $comments = $new_comments__array[$key];
                    }
                    $accountsRecievable_object->isAgree = ucwords($insurer_response_array[$key]);
                    $accountsRecievable_object->comment = ucwords($comments);
                    $insurerReplay_object->accountsRecievable = $accountsRecievable_object;
                }
                if ($pipeline_details['formData']['interDependency'] == true &&
                    $question == "Interdependany clause") {
                    $insurerReplay_object->interDependency = ucwords($insurer_response_array[$key]);
                }
                if ($pipeline_details['formData']['extraExpense'] == true && $question == 'Extra expense') {
                    $extraExpense_object = new \stdClass();
                    if ($new_comments__array[$key] == '--') {
                        $comments = '';
                    } else {
                        $comments = $new_comments__array[$key];
                    }
                    $extraExpense_object->isAgree = ucwords($insurer_response_array[$key]);
                    $extraExpense_object->comment = ucwords($comments);
                    $insurerReplay_object->extraExpense = $extraExpense_object;
                }
                if ($pipeline_details['formData']['contaminatedWater'] == true &&
                    $question == "Contaminated water") {
                    $insurerReplay_object->contaminatedWater = ucwords($insurer_response_array[$key]);
                }
                if ($pipeline_details['formData']['auditorsFeeCheck'] == true && $question == 'Auditors fees') {
                    $auditorsFeeCheck_object = new \stdClass();
                    if ($new_comments__array[$key] == '--') {
                        $comments = '';
                    } else {
                        $comments = $new_comments__array[$key];
                    }
                    $auditorsFeeCheck_object->isAgree = ucwords($insurer_response_array[$key]);
                    $auditorsFeeCheck_object->comment = ucwords($comments);
                    $insurerReplay_object->auditorsFeeCheck = $auditorsFeeCheck_object;
                }
                if ($pipeline_details['formData']['expenseReduceLoss'] == true && $question == 'Expense to reduce the loss') {
                    $expenseReduceLoss_object = new \stdClass();
                    if ($new_comments__array[$key] == '--') {
                        $comments = '';
                    } else {
                        $comments = $new_comments__array[$key];
                    }
                    $expenseReduceLoss_object->isAgree = ucwords($insurer_response_array[$key]);
                    $expenseReduceLoss_object->comment = ucwords($comments);
                    $insurerReplay_object->expenseReduceLoss = $expenseReduceLoss_object;
                }
                if ($pipeline_details['formData']['nominatedLossAdjuster'] == true && $question == 'Nominated loss adjuster') {
                    $nominatedLossAdjuster_object = new \stdClass();
                    if ($new_comments__array[$key] == '--') {
                        $comments = '';
                    } else {
                        $comments = $new_comments__array[$key];
                    }
                    $nominatedLossAdjuster_object->isAgree = ucwords($insurer_response_array[$key]);
                    $nominatedLossAdjuster_object->comment = ucwords($comments);
                    $insurerReplay_object->nominatedLossAdjuster = $nominatedLossAdjuster_object;
                }
                if ($pipeline_details['formData']['outbreakDiscease'] == true && $question == 'Outbreak of discease') {
                    $outbreakDiscease_object = new \stdClass();
                    if ($new_comments__array[$key] == '--') {
                        $comments = '';
                    } else {
                        $comments = $new_comments__array[$key];
                    }
                    $outbreakDiscease_object->isAgree = ucwords($insurer_response_array[$key]);
                    $outbreakDiscease_object->comment = ucwords($comments);
                    $insurerReplay_object->outbreakDiscease = $outbreakDiscease_object;
                }
                if ($pipeline_details['formData']['nonPublicFailure'] == true && $question == 'Failure of non public power supply') {
                    $nonPublicFailure_object = new \stdClass();
                    if ($new_comments__array[$key] == '--') {
                        $comments = '';
                    } else {
                        $comments = $new_comments__array[$key];
                    }
                    $nonPublicFailure_object->isAgree = ucwords($insurer_response_array[$key]);
                    $nonPublicFailure_object->comment = ucwords($comments);
                    $insurerReplay_object->nonPublicFailure = $nonPublicFailure_object;
                }
                if ($pipeline_details['formData']['premisesDetails'] == true && $question == 'Murder, Suicide or outbreak of discease on the premises') {
                    $premisesDetails_object = new \stdClass();
                    if ($new_comments__array[$key] == '--') {
                        $comments = '';
                    } else {
                        $comments = $new_comments__array[$key];
                    }
                    $premisesDetails_object->isAgree = ucwords($insurer_response_array[$key]);
                    $premisesDetails_object->comment = ucwords($comments);
                    $insurerReplay_object->premisesDetails = $premisesDetails_object;
                }
                if ($pipeline_details['formData']['bombscare'] == true && $question == 'Bombscare and unexploded devices on the premises') {
                    $bombscare_object = new \stdClass();
                    if ($new_comments__array[$key] == '--') {
                        $comments = '';
                    } else {
                        $comments = $new_comments__array[$key];
                    }
                    $bombscare_object->isAgree = ucwords($insurer_response_array[$key]);
                    $bombscare_object->comment = ucwords($comments);
                    $insurerReplay_object->bombscare = $bombscare_object;
                }
                if ($pipeline_details['formData']['DenialClause'] == true && $question == 'Denial of access') {
                    $denial_object = new \stdClass();
                    if ($new_comments__array[$key] == '--') {
                        $comments = '';
                    } else {
                        $comments = $new_comments__array[$key];
                    }
                    $denial_object->isAgree = ucwords($insurer_response_array[$key]);
                    $denial_object->comment = ucwords($comments);
                    $insurerReplay_object->DenialClause = $denial_object;
                }
                if ($pipeline_details['formData']['bookDebits'] == true && $question == 'Book of Debts') {
                    $bookDebits_object = new \stdClass();
                    if ($new_comments__array[$key] == '--') {
                        $comments = '';
                    } else {
                        $comments = $new_comments__array[$key];
                    }
                    $bookDebits_object->isAgree = ucwords($insurer_response_array[$key]);
                    $bookDebits_object->comment = ucwords($comments);
                    $insurerReplay_object->bookDebits = $bookDebits_object;
                }
                if ($pipeline_details['formData']['publicFailure'] == true && $question == 'Failure of public utility') {
                    $publicFailure_object = new \stdClass();
                    if ($new_comments__array[$key] == '--') {
                        $comments = '';
                    } else {
                        $comments = $new_comments__array[$key];
                    }
                    $publicFailure_object->isAgree = ucwords($insurer_response_array[$key]);
                    $publicFailure_object->comment = ucwords($comments);
                    $insurerReplay_object->publicFailure = $publicFailure_object;
                }
                if (isset($pipeline_details['formData']['businessInterruption']['noLocations']) &&
                    $pipeline_details['formData']['businessInterruption']['noLocations'] > 1 && $pipeline_details['formData']['departmentalClause'] == true &&
                    $question == 'Departmental clause') {
                    $insurerReplay_object->departmentalClause = ucwords($insurer_response_array[$key]);
                }
                if (isset($pipeline_details['formData']['businessInterruption']['noLocations']) &&
                    $pipeline_details['formData']['businessInterruption']['noLocations'] > 1 && $pipeline_details['formData']['rentLease'] == true &&
                    $question == 'Rent & Lease hold interest') {
                    $rentLease_object = new \stdClass();
                    if ($new_comments__array[$key] == '--') {
                        $comments = '';
                    } else {
                        $comments = $new_comments__array[$key];
                    }
                    $rentLease_object->isAgree = ucwords($insurer_response_array[$key]);
                    $rentLease_object->comment = ucwords($comments);
                    $insurerReplay_object->rentLease = $rentLease_object;
                }
                if ($pipeline_details['formData']['CoverAccomodation']['coverAccomodation'] == true && $question == 'Cover for alternate accomodation') {
                    $coverAccomodation_object = new \stdClass();
                    if ($new_comments__array[$key] == '--') {
                        $comments = '';
                    } else {
                        $comments = $new_comments__array[$key];
                    }
                    $coverAccomodation_object->isAgree = ucwords($insurer_response_array[$key]);
                    $coverAccomodation_object->comment = ucwords($comments);
                    $insurerReplay_object->coverAccomodation = $coverAccomodation_object;
                }

                if ($pipeline_details['formData']['demolitionCost'] == true && $question == 'Demolition and increased cost of construction') {
                    $cost_object = new \stdClass();
                    if ($new_comments__array[$key] == '--') {
                        $comments = '';
                    } else {
                        $comments = $new_comments__array[$key];
                    }
                    $cost_object->isAgree = ucwords($insurer_response_array[$key]);
                    $cost_object->comment = ucwords($comments);
                    $insurerReplay_object->demolitionCost = $cost_object;
                }
                if ($pipeline_details['formData']['contingentBusiness'] == true && $question == 'Contingent business inetruption and contingent extra expense') {
                    $contingentBusiness_object = new \stdClass();
                    if ($new_comments__array[$key] == '--') {
                        $comments = '';
                    } else {
                        $comments = $new_comments__array[$key];
                    }
                    $contingentBusiness_object->isAgree = ucwords($insurer_response_array[$key]);
                    $contingentBusiness_object->comment = ucwords($comments);
                    $insurerReplay_object->contingentBusiness = $contingentBusiness_object;
                }
                if ($pipeline_details['formData']['nonOwnedProperties'] == true && $question == 'Non Owned property in vicinity interuption') {
                    $nonOwnedProperties_object = new \stdClass();
                    if ($new_comments__array[$key] == '--') {
                        $comments = '';
                    } else {
                        $comments = $new_comments__array[$key];
                    }
                    $nonOwnedProperties_object->isAgree = ucwords($insurer_response_array[$key]);
                    $nonOwnedProperties_object->comment = ucwords($comments);
                    $insurerReplay_object->nonOwnedProperties = $nonOwnedProperties_object;
                }
                if ($pipeline_details['formData']['royalties'] == true &&
                    $question == "Royalties") {
                    $insurerReplay_object->royalties = ucwords($insurer_response_array[$key]);
                }
            }
            if (isset($pipeline_details['formData']['cliamPremium']) &&
                $pipeline_details['formData']['cliamPremium'] == 'combined_data') {
                if ($question == "Deductible for Property") {
                    if (is_numeric($insurer_response_array[$key])) {
                        $claimObject->deductableProperty = $insurer_response_array[$key];
                    } else {
                        return response()->json(['success' => 'failed', "pipeline_id" => $pipeline_details->_id]);
                    }
                }
                if ($question == "Deductible for Business Interruption") {
                    if (is_numeric($insurer_response_array[$key])) {
                        $claimObject->deductableBusiness = ucwords($insurer_response_array[$key]);
                    } else {
                        return response()->json(['success' => 'failed', "pipeline_id" => $pipeline_details->_id]);
                    }
                }
                if ($question == "Rate required (combined)") {
                    if (is_numeric($insurer_response_array[$key])) {
                        if (is_numeric($insurer_response_array[$key])) {
                            $claimObject->rateCombined = ucwords($insurer_response_array[$key]);
                        }
                    } else {
                        return response()->json(['success' => 'failed', "pipeline_id" => $pipeline_details->_id]);
                    }
                }
                if ($question == "Premium required (combined)") {
                    if (is_numeric($insurer_response_array[$key])) {
                        $claimObject->premiumCombined = ucwords($insurer_response_array[$key]);
                    } else {
                        return response()->json(['success' => 'failed', "pipeline_id" => $pipeline_details->_id]);
                    }
                }
                if ($question == "Brokerage (combined)") {
                    if (is_numeric($insurer_response_array[$key])) {
                        $claimObject->brokerage = ucwords($insurer_response_array[$key]);
                    } else {
                        return response()->json(['success' => 'failed', "pipeline_id" => $pipeline_details->_id]);
                    }
                }
                if ($question == "Warranty (Property)") {
                    $claimObject->warrantyProperty = ucwords($insurer_response_array[$key]);
                }
                if ($question == "Warranty (Business Interruption)") {
                    $claimObject->warrantyBusiness = ucwords($insurer_response_array[$key]);
                }
                if ($question == "Exclusion (Property)") {
                    $claimObject->exclusionProperty = ucwords($insurer_response_array[$key]);
                }
                if ($question == "Exclusion (Business Interruption)") {
                    $claimObject->exclusionBusiness = ucwords($insurer_response_array[$key]);
                }
                if ($question == "Special Condition (Property)") {
                    $claimObject->specialProperty = ucwords($insurer_response_array[$key]);
                }
                if ($question == "Special Condition (Business Interruption)") {
                    $claimObject->specialBusiness = ucwords($insurer_response_array[$key]);
                }
                $insurerReplay_object->claimPremiyumDetails = $claimObject;
            }

            if (isset($pipeline_details['formData']['cliamPremium']) &&
                $pipeline_details['formData']['cliamPremium'] == 'only_fire') {
                if ($question == "Deductible") {
                    if (is_numeric($insurer_response_array[$key])) {
                        $claimObject->deductableProperty = ucwords($insurer_response_array[$key]);
                    } else {
                        return response()->json(['success' => 'failed', "pipeline_id" => $pipeline_details->_id]);
                    }
                }

                if ($question == "Rate required") {
                    if (is_numeric($insurer_response_array[$key])) {
                        $claimObject->propertyRate = ucwords($insurer_response_array[$key]);
                    } else {
                        return response()->json(['success' => 'failed', "pipeline_id" => $pipeline_details->_id]);
                    }
                }
                if ($question == "Premium required") {
                    if (is_numeric($insurer_response_array[$key])) {
                        $claimObject->propertyPremium = ucwords($insurer_response_array[$key]);
                    } else {
                        return response()->json(['success' => 'failed', "pipeline_id" => $pipeline_details->_id]);
                    }
                }
                if ($question == "Brokerage") {
                    if (is_numeric($insurer_response_array[$key])) {
                        $claimObject->propertyBrockerage = ucwords($insurer_response_array[$key]);
                    } else {
                        return response()->json(['success' => 'failed', "pipeline_id" => $pipeline_details->_id]);
                    }
                }
                if ($question == "Warranty") {
                    $claimObject->propertyWarranty = ucwords($insurer_response_array[$key]);
                }

                if ($question == "Exclusion") {
                    $claimObject->propertyExclusion = ucwords($insurer_response_array[$key]);
                }
                if ($question == "Special Condition") {
                    $claimObject->propertySpecial = ucwords($insurer_response_array[$key]);
                }

                $insurerReplay_object->claimPremiyumDetails = $claimObject;
            }

            if (isset($pipeline_details['formData']['cliamPremium']) &&
                $pipeline_details['formData']['cliamPremium'] == 'separate_fire') {
                if ($question == "Deductible for (Property)") {
                    if (is_numeric($insurer_response_array[$key])) {
                        $claimObject->propertySeparateDeductable = ucwords($insurer_response_array[$key]);
                    } else {
                        return response()->json(['success' => 'failed', "pipeline_id" => $pipeline_details->_id]);
                    }
                }
                if ($question == "Rate required (Property)") {
                    if (is_numeric($insurer_response_array[$key])) {
                        $claimObject->rateCombined = ucwords($insurer_response_array[$key]);
                    } else {
                        return response()->json(['success' => 'failed', "pipeline_id" => $pipeline_details->_id]);
                    }
                }
                if ($question == "Premium required (Property)") {
                    if (is_numeric($insurer_response_array[$key])) {
                        $claimObject->propertySeparatePremium = ucwords($insurer_response_array[$key]);
                    } else {
                        return response()->json(['success' => 'failed', "pipeline_id" => $pipeline_details->_id]);
                    }
                }
                if ($question == "Brokerage (Property)") {
                    if (is_numeric($insurer_response_array[$key])) {
                        $claimObject->propertySeparateBrokerage = ucwords($insurer_response_array[$key]);
                    } else {
                        return response()->json(['success' => 'failed', "pipeline_id" => $pipeline_details->_id]);
                    }
                }
                if ($question == "Warranty (Property)") {
                    $claimObject->propertySeparateWarranty = ucwords($insurer_response_array[$key]);
                }
                if ($question == "Exclusion (Property)") {
                    $claimObject->propertySeparateExclusion = ucwords($insurer_response_array[$key]);
                }
                if ($question == "Special Condition (Property)") {
                    $claimObject->propertySeparateSpecial = ucwords($insurer_response_array[$key]);
                }

                if ($question == "Deductible for (Business Interruption)") {
                    if (is_numeric($insurer_response_array[$key])) {
                        $claimObject->businessSeparateDeductable = ucwords($insurer_response_array[$key]);
                    } else {
                        return response()->json(['success' => 'failed', "pipeline_id" => $pipeline_details->_id]);
                    }
                }
                if ($question == "Rate required (Business Interruption)") {
                    if (is_numeric($insurer_response_array[$key])) {
                        $claimObject->businessSeparateRate = ucwords($insurer_response_array[$key]);
                    } else {
                        return response()->json(['success' => 'failed', "pipeline_id" => $pipeline_details->_id]);
                    }
                }
                if ($question == "Premium required (Business Interruption)") {
                    if (is_numeric($insurer_response_array[$key])) {
                        $claimObject->businessSeparatePremium = ucwords($insurer_response_array[$key]);
                    } else {
                        return response()->json(['success' => 'failed', "pipeline_id" => $pipeline_details->_id]);
                    }
                }
                if ($question == "Brokerage (Business Interruption)") {
                    if (is_numeric($insurer_response_array[$key])) {
                        $claimObject->businessSeparateBrokerage = ucwords($insurer_response_array[$key]);
                    } else {
                        return response()->json(['success' => 'failed', "pipeline_id" => $pipeline_details->_id]);
                    }
                }
                if ($question == "Warranty (Business Interruption)") {
                    $claimObject->businessSeparateWarranty = ucwords($insurer_response_array[$key]);
                }
                if ($question == "Exclusion (Business Interruption)") {
                    $claimObject->businessSeparateExclusion = ucwords($insurer_response_array[$key]);
                }
                if ($question == "Special Condition (Business Interruption)") {
                    $claimObject->businessSeparateSpecial = ucwords($insurer_response_array[$key]);
                }

                $insurerReplay_object->claimPremiyumDetails = $claimObject;
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

        //   try {
        $uniqueToken = $request->input('token');
        $id = $request->input('id');
        $field = $request->input('field');
        $new_quot = $request->input('new_quot');
        $pipelineDetails = PipelineItems::find($id);
        if ($pipelineDetails) {
            $replies = $pipelineDetails->insurerReplay;
            foreach ($replies as $key => $reply) {
                if ($reply['uniqueToken'] == $uniqueToken) {
                    if ($field == 'saleClause' || $field == 'clauseWording' || $field == 'automaticReinstatement' || $field == 'mainClause' || $field == 'reinstatementValClass' ||
                        $field == 'waiver' || $field == 'trace' || $field == 'errorOmission' || $field == 'alterationClause' || $field == 'tempRemovalClause' ||
                        $field == 'adjBusinessClause' || $field == 'cancelThirtyClause' || $field == 'primaryInsuranceClause' || $field == 'nonInvalidClause' ||
                        $field == 'warrantyConditionClause' || $field == 'addInterestClause' || $field == 'improvementClause' || $field == 'demolitionClause' ||
                        $field == 'noControlClause' || $field == 'coverPropertyCon' || $field == 'lossOrDamage' || $field == 'sprinkerLeakage' ||
                        $field == 'smokeSoot' || $field == 'boilerExplosion' || $field == 'coverMechanical' || $field == 'coverExtWork' || $field == 'misdescriptionClause' ||
                        $field == 'otherInsuranceClause' || $field == 'automaticAcqClause' || $field == 'coverExihibition' || $field == 'coverProperty' ||
                        $field == 'saleInterestClause' || $field == 'sueLabourClause' || $field == 'lossPayee' || $field == 'electricalClause' || $field == 'contractPriceClause' ||
                        $field == 'sprinklerUpgradationClause' || $field == 'electronicInstallation' || $field == 'coverCurios' || $field == 'brandTrademark' ||
                        $field == 'ownerPrinciple' || $field == 'conductClause' || $field == 'lossNotification' || $field == 'brockersClaimClause' ||
                        $field == 'addCostWorking' || $field == 'brockersClaimHandlingClause' || $field == 'interDependency' || $field == 'contaminatedWater' ||
                        $field == 'departmentalClause' || $field == 'royalties' || $field == 'claimPremiyumDetails_deductableProperty' || $field == 'claimPremiyumDetails_propertyRate' || $field == 'claimPremiyumDetails_propertyPremium' || $field == 'claimPremiyumDetails_propertyBrockerage' || $field == 'claimPremiyumDetails_propertyWarranty'
                        || $field == 'claimPremiyumDetails_propertyExclusion' || $field == 'claimPremiyumDetails_propertySpecial' || $field == 'claimPremiyumDetails_specialBusiness' || $field == 'claimPremiyumDetails_specialProperty' || $field == 'claimPremiyumDetails_exclusionBusiness'
                        || $field == 'claimPremiyumDetails_exclusionProperty' || $field == 'claimPremiyumDetails_warrantyBusiness' || $field == 'claimPremiyumDetails_warrantyProperty' || $field == 'claimPremiyumDetails_brokerage' || $field == 'claimPremiyumDetails_premiumCombined'
                        || $field == 'claimPremiyumDetails_rateCombined' || $field == 'claimPremiyumDetails_deductableBusiness' || $field == 'claimPremiyumDetails_propertySeparateDeductable' || $field == 'claimPremiyumDetails_propertySeparateRate' || $field == 'claimPremiyumDetails_propertySeparatePremium'
                        || $field == 'claimPremiyumDetails_propertySeparateBrokerage' || $field == 'claimPremiyumDetails_propertySeparateWarranty' || $field == 'claimPremiyumDetails_propertySeparateExclusion' || $field == 'claimPremiyumDetails_propertySeparateSpecial'
                        || $field == 'claimPremiyumDetails_businessSeparateDeductable'
                        || $field == 'claimPremiyumDetails_businessSeparateRate' || $field == 'claimPremiyumDetails_businessSeparatePremium' || $field == 'claimPremiyumDetails_businessSeparateBrokerage' || $field == 'claimPremiyumDetails_businessSeparateWarranty' ||
                        $field == 'claimPremiyumDetails_businessSeparateExclusion' || $field == 'claimPremiyumDetails_businessSeparateSpecial'
                    ) {

                        if ($field == 'claimPremiyumDetails_deductableProperty' || $field == 'claimPremiyumDetails_propertyRate' || $field == 'claimPremiyumDetails_propertyPremium' || $field == 'claimPremiyumDetails_propertyBrockerage' || $field == 'claimPremiyumDetails_propertyWarranty'
                            || $field == 'claimPremiyumDetails_propertyExclusion' || $field == 'claimPremiyumDetails_propertySpecial' || $field == 'claimPremiyumDetails_specialBusiness' || $field == 'claimPremiyumDetails_specialProperty' || $field == 'claimPremiyumDetails_exclusionBusiness'
                            || $field == 'claimPremiyumDetails_exclusionProperty' || $field == 'claimPremiyumDetails_warrantyBusiness' || $field == 'claimPremiyumDetails_warrantyProperty' || $field == 'claimPremiyumDetails_brokerage' || $field == 'claimPremiyumDetails_premiumCombined'
                            || $field == 'claimPremiyumDetails_rateCombined' || $field == 'claimPremiyumDetails_deductableBusiness' || $field == 'claimPremiyumDetails_propertySeparateDeductable' || $field == 'claimPremiyumDetails_propertySeparateRate' || $field == 'claimPremiyumDetails_propertySeparatePremium'
                            || $field == 'claimPremiyumDetails_propertySeparateBrokerage' || $field == 'claimPremiyumDetails_propertySeparateWarranty' || $field == 'claimPremiyumDetails_propertySeparateExclusion' || $field == 'claimPremiyumDetails_propertySeparateSpecial'
                            || $field == 'claimPremiyumDetails_businessSeparateDeductable'
                            || $field == 'claimPremiyumDetails_businessSeparateRate' || $field == 'claimPremiyumDetails_businessSeparatePremium' || $field == 'claimPremiyumDetails_businessSeparateBrokerage' || $field == 'claimPremiyumDetails_businessSeparateWarranty' ||
                            $field == 'claimPremiyumDetails_businessSeparateExclusion' || $field == 'claimPremiyumDetails_businessSeparateSpecial') {

                            if ($field == 'claimPremiyumDetails_deductableProperty' || $field == 'claimPremiyumDetails_deductableBusiness' || $field == 'claimPremiyumDetails_rateCombined'
                                || $field == 'claimPremiyumDetails_premiumCombined' || $field == 'claimPremiyumDetails_brokerage' || $field == 'claimPremiyumDetails_propertyRate' || $field == 'claimPremiyumDetails_propertyPremium'
                                || $field == 'claimPremiyumDetails_propertyBrockerage' || $field == 'claimPremiyumDetails_propertySeparateDeductable' || $field == 'claimPremiyumDetails_propertySeparateRate' || $field == 'claimPremiyumDetails_propertySeparatePremium'
                                || $field == 'claimPremiyumDetails_propertySeparateBrokerage' || $field == 'claimPremiyumDetails_businessSeparateDeductable' || $field == 'claimPremiyumDetails_businessSeparateRate'
                                || $field == 'claimPremiyumDetails_businessSeparatePremium' || $field == 'claimPremiyumDetails_businessSeparateBrokerage') {
                                $fieldExp = explode('_', $field);
                                $old_quot = $reply['claimPremiyumDetails'][$fieldExp[1]];
                                $old_quot = str_replace(',', '', $old_quot);
                                $new_quot = str_replace(',', '', $new_quot);
                                if (!is_numeric($new_quot)) {
                                    return 'failed';
                                }
                            } else {
                                $fieldExp = explode('_', $field);
                                $old_quot = $reply['claimPremiyumDetails'][$fieldExp[1]];
                            }
                        } else {
                            $old_quot = $reply[$field];
                        }
                        $amend_object = new \stdClass();
                        $amend_object->amendedBy = new ObjectId(Auth::id());
                        $amend_object->name = Auth::user()->name;
                        $amend_object->field = $field;
                        $amend_object->oldQuot = $old_quot;
                        $amend_object->newQuot = $new_quot;
                        $item = PipelineItems::where('_id', $id)->first();
                        $item->push('insurerReplay.' . $key . '.amendmentDetails', $amend_object);
                        $updatedBy_obj = new \stdClass();
                        $updatedBy_obj->id = new ObjectID(Auth::id());
                        $updatedBy_obj->name = Auth::user()->name;
                        $updatedBy_obj->date = date('d/m/Y');
                        $updatedBy_obj->action = "Quote amended";
                        $updatedBy[] = $updatedBy_obj;
                        $item->push('updatedBy', $updatedBy);
                        $item->save();
                        $field = str_replace('_', '.', $field);
                        PipelineItems::where('_id', $id)->update(array('insurerReplay.' . $key . '.' . $field => $new_quot));
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
                            $item->push('insurerReplay.' . $key . '.amendmentDetails', $amend_object);
                            $updatedBy_obj = new \stdClass();
                            $updatedBy_obj->id = new ObjectID(Auth::id());
                            $updatedBy_obj->name = Auth::user()->name;
                            $updatedBy_obj->date = date('d/m/Y');
                            $updatedBy_obj->action = "Quote amended";
                            $updatedBy[] = $updatedBy_obj;
                            $item->push('updatedBy', $updatedBy);
                            $item->save();
                            PipelineItems::where('_id', $id)->update(array('insurerReplay.' . $key . '.' . $field . '.isAgree' => $new_quot));
                        } else {
                            $old_quot = "Comment : " . $reply[$field]['comment'];
                            $amend_object = new \stdClass();
                            $amend_object->amendedBy = new ObjectId(Auth::id());
                            $amend_object->name = Auth::user()->name;
                            $amend_object->field = $field;
                            $amend_object->oldQuot = $old_quot;
                            $amend_object->newQuot = "Comment : " . $new_quot;
                            $item = PipelineItems::where('_id', $id)->first();
                            $item->push('insurerReplay.' . $key . '.amendmentDetails', $amend_object);
                            $updatedBy_obj = new \stdClass();
                            $updatedBy_obj->id = new ObjectID(Auth::id());
                            $updatedBy_obj->name = Auth::user()->name;
                            $updatedBy_obj->date = date('d/m/Y');
                            $updatedBy_obj->action = "Quote amended";
                            $updatedBy[] = $updatedBy_obj;
                            $item->push('updatedBy', $updatedBy);
                            $item->save();
                            PipelineItems::where('_id', $id)->update(array('insurerReplay.' . $key . '.' . $field . '.comment' => $new_quot));
                        }
                    }
                }
            }
        }
        return 'success';
        //   } catch (\Exception $e) {
        //       return 'failed';
        //   }
    }

    /**
     * view e comparison page
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
            return view('pipelines.fire_perils.e_comparison')->with(compact('pipeline_details', 'selectedId', 'insures_details'));
        } else {
            return view('error');
        }
    }

    /**
     * pdf comparisosn
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
        $pdf = PDF::loadView('pipelines.fire_perils.e_comparison_pdf', ['pipeline_details' => $pipeline_details, 'selectedId' => $selectedId, 'insures_details' => $insures_details])->setPaper('a3')->setOrientation('landscape')->setOption('margin-bottom', 0);
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
     * view compariosn for customers
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
            return view('pipelines.fire_perils.customer_e_comparison')->with(compact('pipeline_details', 'insures_details', 'selectedId'));
        } else {
            return view('error');
        }
    }
    /**
     * quote ammendment
     */
    public function quotAmendment($pipeline_id)
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
            return view('pipelines.fire_perils.quote_amendment')->with(compact('pipeline_details', 'insures_details', 'selectedId'));
        } else {
            return view('error');
        }
    }
    /**
     * approve quote view page
     */
    public function approvedQuot($pipelineId)
    {
        $pipeline_details = PipelineItems::find($pipelineId);
        if ($pipeline_details['status']['status'] == 'Worktype Created' || $pipeline_details['status']['status'] == 'E-questionnaire'
            || $pipeline_details['status']['status'] == 'E-slip' || $pipeline_details['status']['status'] == 'E-quotation' ||
            $pipeline_details['status']['status'] == 'Quote Amendment' || $pipeline_details['status']['status'] == 'E-comparison') {
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
            return view('pipelines.fire_perils.approved_quot')->with(compact('pipelineId', 'pipeline_details', 'insures_details'));
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
            return view('pipelines.fire_perils.issuance')->with(compact('pipelineId', 'pipeline_details', 'insures_details'));
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
            return view('pipelines.fire_perils.view_pending_details')->with(compact('pipelineId', 'pipeline_details', 'insures_details'));
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
        if ($pipeline_details->pipelineStatus != "approved") {
            return view('error');
        } else {
            $insurerReplay = $pipeline_details['insurerReplay'];
            foreach ($insurerReplay as $insures_rep) {
                if ($insures_rep['quoteStatus'] == 'active' && @$insures_rep['customerDecision']['decision'] == 'Approved') {
                    $insures_details = $insures_rep;
                }
            }
            return view('pipelines.fire_perils.worksman_issuance')->with(compact('pipelineId', 'pipeline_details', 'insures_details'));
        }
    }
}
