<?php

namespace App\Http\Controllers;

use App\CountryListModel;
use App\Customer;
use App\ImportExcel;
use App\Insurer;
use App\Jobs\EslipSubmittedReminder;
use App\Jobs\IssuanceProposal;
use App\Jobs\SendComparison;
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

class BusinessController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.underwriter', ['except' => [ 'equestionnaireSave', 'decisionSave', 'customerViewComparison']]);
    }
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
        return view('pipelines.business.e_questionaire')->with(compact(
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
    public static function equestionnaireSave(Request $request)
    {
        $questionnaire = PipelineItems::find($request->input('id'));
        if ($questionnaire) {
            $address_object = new \stdClass();
            $address_object->addressLine1 = $request->input('addressLine1');
            $address_object->addressLine2 = $request->input('addressLine2');
            $address_object->country = $request->input('country');
            $address_object->state = $request->input('state');
            $address_object->city = $request->input('city');
            $address_object->zipCode = $request->input('zipCode');

            $company = $request->input('company_name');
            $location = $request->input('no_of_locations');

            $businessInterruptionObject = new \stdClass();
            $businessInterruptionObject->business_interruption = (boolean) true;
            $businessInterruptionObject->actualProfit = str_replace(',', '', $request->input('actual_profit'));
            $businessInterruptionObject->estimatedProfit = str_replace(',', '', $request->input('estimated_profit'));
            $businessInterruptionObject->standCharge = str_replace(',', '', $request->input('stand_charge'));
            $businessInterruptionObject->rentLoss = str_replace(',', '', $request->input('rent_loss'));
            $businessInterruptionObject->mainCustName = $request->input('main_cust_name');
            $businessInterruptionObject->mainSuppName = $request->input('main_supp_name');
            $businessInterruptionObject->indemnityPeriod = str_replace(',', '', $request->input('indemnity_period'));

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

            $formdata_object = [];

            $formdata_object = [
                'formData.salutation' => $request->input('salutation'),
                'formData.firstName' => $request->input('firstName'),
                'formData.middleName' => $request->input('middleName'),
                'formData.lastName' => $request->input('lastName'),
                'formData.addressDetails' => $address_object,
                'formData.companyName' => $company,
                'formData.risk' => $location,
                'formData.businessType' => $request->input('businessType'),
                'formData.businessInterruption' => $businessInterruptionObject,
                'formData.claimsHistory' => $claim_array,
            ];

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
            //    // $questionnaire->formData=$formdata;
            //    if(isset($file) && !empty($file))
            //    {
            //       $questionnaire->push('files', $file);
            //    }

            if ($request->input('is_save') == 'true') {
                if ($request->input('is_edit') == "0") {
                    $updatedBy_obj = new \stdClass();
                    $updatedBy_obj->id = new ObjectID(Auth::id());
                    $updatedBy_obj->name = Auth::user()->name;
                    $updatedBy_obj->date = date('d/m/Y');
                    $updatedBy_obj->action = "E questionnaire saved as draft";
                    $updatedBy[] = $updatedBy_obj;
                    // if(isset($file) && !empty($file))
                    //  {
                    //   $questionnaire->push('files', $file);
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
                    $updatedBy_obj->date = date('d/m/Y' /*

                 */);
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
        $link = url('/business_interruption/customer-questionnaire/' . $token);
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
                return view('pipelines.business.sendQuestion')->with(compact('country_name', 'all_emirates', 'eQuestionnaireid', 'form_data', 'PipelineItems', 'customer_details', 'all_insurers', 'file_name', 'file_url'));
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
            //  dd($pipeline_details);
            return view('pipelines.business.e_slip')->with(compact('worktype_id', 'pipeline_details', 'file_name', 'file_url', 'form_data'));
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
        $formdata_object = [];

        $formdata_object = [
            'formData.costWork' => (boolean) $request->input('costWork'),
            'formData.claimClause' => (boolean) $request->input('claimClause'),
            'formData.custExtension' => (boolean) $request->input('custExtension'),
            'formData.accountants' => (boolean) $request->input('accountants'),
            'formData.payAccount' => (boolean) $request->input('payAccount'),
            'formData.denialAccess' => (boolean) $request->input('denialAccess'),
            'formData.premiumClause' => (boolean) $request->input('premiumClause'),
            'formData.utilityClause' => (boolean) $request->input('utilityClause'),
            'formData.brokerClaim' => (boolean) $request->input('brokerClaim'),
            'formData.bookedDebts' => (boolean) $request->input('bookedDebts'),
            'formData.interdependanyClause' => (boolean) $request->input('interdependanyClause'),
            'formData.extraExpense' => (boolean) $request->input('extraExpense'),
            'formData.water' => (boolean) $request->input('water'),
            'formData.auditorFee' => (boolean) $request->input('auditorFee'),
            'formData.expenseLaws' => (boolean) $request->input('expenseLaws'),
            'formData.lossAdjuster' => (boolean) $request->input('lossAdjuster'),
            'formData.discease' => (boolean) $request->input('discease'),
            'formData.powerSupply' => (boolean) $request->input('powerSupply'),
            'formData.condition1' => (boolean) $request->input('condition1'),
            'formData.condition2' => (boolean) $request->input('condition2'),
            'formData.bookofDebts' => (boolean) $request->input('bookofDebts'),
            'formData.depclause' => (boolean) $request->input('depclause'),
            'formData.rent' => (boolean) $request->input('rent'),
            'formData.hasaccomodation' => $request->input('hasaccomodation'),
            'formData.costofConstruction' => (boolean) $request->input('costofConstruction'),
            'formData.ContingentExpense' => (boolean) $request->input('ContingentExpense'),
            'formData.interuption' => (boolean) $request->input('interuption'),
            'formData.Royalties' => (boolean) $request->input('Royalties'),
            'formData.deductible' => str_replace(',', '', $request->input('deductible')),
            'formData.ratep' => str_replace(',', '', $request->input('ratep')),
            'formData.brokerage' => str_replace(',', '', $request->input('brokerage')),
            'formData.warranty' => str_replace(',', '', $request->input('warranty')),
            'formData.exclusion' => str_replace(',', '', $request->input('exclusion')),
            'formData.spec_condition' => str_replace(',', '', $request->input('spec_condition')),

        ];

        //    var_dump($formdata_object);die;;
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
                                $type = "Business Interruption";
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
                                    $type = "Business Interruption";
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
                            $type = "Business Interruption";
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
            //dd($pipeline_details);
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
                //  dd($insures['status']);
                if ($insures['status'] == 'active') {
                    $insures_name[] = $insures['name'];
                    $insures_id[] = $insures['id'];
                }
            }
            //  dd($pipeline_details['selected_insurers']);
            $selectedIds = $pipeline_details['selected_insurers'];
            //dd($selectedIds);
            if (isset($selectedIds)) {
                foreach ($selectedIds as $ids) {
                    $id_insurer[] = $ids['insurer'];
                }
            } else {
                $id_insurer = [];
            }
            //dd($insures_details);
            return view('pipelines.business.e_quotations')->with(compact('pipeline_details', 'insures_name', 'insures_details', 'insures_id', 'id_insurer'));
        } else {
            return view('error');
        }
    }
    //create excel sheet for insurers
    public function createExcel($pipeline_details)
    {
        $pipeline_details = PipelineItems::find($pipeline_details->_id);
        $questions_array = [];
        $answes_array = [];
        if (isset($pipeline_details['formData']['costWork']) && $pipeline_details['formData']['costWork'] == true) {
            $questions_array[] = 'Additional increase in cost of working';
            $answes_array[] = "yes";
        }
        if (isset($pipeline_details['formData']['claimClause']) && $pipeline_details['formData']['claimClause'] == true) {
            $questions_array[] = 'Claims preparation clause';
            $answes_array[] = "yes";
        }
        if (isset($pipeline_details['formData']['custExtension']) && $pipeline_details['formData']['custExtension'] == true) {
            $questions_array[] = 'Suppliers extension/customer extension';
            $answes_array[] = "yes";
        }
        if (isset($pipeline_details['formData']['accountants']) && $pipeline_details['formData']['accountants'] == true) {
            $questions_array[] = 'accountants clause';
            $answes_array[] = "yes";
        }
        if (isset($pipeline_details['formData']['payAccount']) && $pipeline_details['formData']['payAccount'] == true) {
            $questions_array[] = 'Payment on account';
            $answes_array[] = "yes";
        }
        if (isset($pipeline_details['formData']['denialAccess']) && $pipeline_details['formData']['denialAccess'] == true) {
            $questions_array[] = 'Prevention/denial of access';
            $answes_array[] = "yes";
        }
        if (isset($pipeline_details['formData']['premiumClause']) && $pipeline_details['formData']['premiumClause'] == true) {
            $questions_array[] = 'Premium adjustment clause';
            $answes_array[] = "yes";
        }
        if (isset($pipeline_details['formData']['utilityClause']) && $pipeline_details['formData']['utilityClause'] == true) {
            $questions_array[] = 'Public utilities clause';
            $answes_array[] = "yes";
        }
        if (isset($pipeline_details['formData']['brokerClaim']) && $pipeline_details['formData']['brokerClaim'] == true) {
            $questions_array[] = 'Brokers Claim Handling Clause : A loss notification received by the Insurance Broker will be deemed as a loss notification to Insurer. All communications flowing between the Insurer, Insured and the appointed Loss Surveyor should be channelized through the Broker, unless there is any unavoidable reasons compelling direct communications between the parties';
            $answes_array[] = "yes";
        }
        if (isset($pipeline_details['formData']['bookedDebts']) && $pipeline_details['formData']['bookedDebts'] == true) {
            $questions_array[] = 'Accounts recievable / Loss of booked debts';
            $answes_array[] = "yes";
        }
        if (isset($pipeline_details['formData']['interdependanyClause']) && $pipeline_details['formData']['interdependanyClause'] == true) {
            $questions_array[] = 'Interdependany clause';
            $answes_array[] = "yes";
        }
        if (isset($pipeline_details['formData']['extraExpense']) && $pipeline_details['formData']['extraExpense'] == true) {
            $questions_array[] = 'Extra expense';
            $answes_array[] = "yes";
        }
        if (isset($pipeline_details['formData']['water']) && $pipeline_details['formData']['water'] == true) {
            $questions_array[] = 'Contaminated water';
            $answes_array[] = "yes";
        }
        if (isset($pipeline_details['formData']['auditorFee']) && $pipeline_details['formData']['auditorFee'] == true) {
            $questions_array[] = 'Auditors fees';
            $answes_array[] = "yes";
        }
        if (isset($pipeline_details['formData']['expenseLaws']) && $pipeline_details['formData']['expenseLaws'] == true) {
            $questions_array[] = 'expense to reduce the laws';
            $answes_array[] = "yes";
        }
        if (isset($pipeline_details['formData']['lossAdjuster']) && $pipeline_details['formData']['lossAdjuster'] == true) {
            $questions_array[] = 'Nominated loss adjuster';
            $answes_array[] = "yes";
        }
        if (isset($pipeline_details['formData']['discease']) && $pipeline_details['formData']['discease'] == true) {
            $questions_array[] = 'Outbreak of discease';
            $answes_array[] = "yes";
        }
        if (isset($pipeline_details['formData']['powerSupply']) && $pipeline_details['formData']['powerSupply'] == true) {
            $questions_array[] = 'Failure of non public power supply';
            $answes_array[] = "yes";
        }
        if (isset($pipeline_details['formData']['condition1']) && $pipeline_details['formData']['condition1'] == true) {
            $questions_array[] = 'Murder, Suicide or outbreak of discease on the premises';
            $answes_array[] = "yes";
        }
        if (isset($pipeline_details['formData']['condition2']) && $pipeline_details['formData']['condition2'] == true) {
            $questions_array[] = 'Bombscare and unexploded devices on the premises';
            $answes_array[] = "yes";
        }

        if (isset($pipeline_details['formData']['bookofDebts']) && $pipeline_details['formData']['bookofDebts'] == true) {
            $questions_array[] = 'Book of Debts';
            $answes_array[] = "yes";
        }
        if (isset($pipeline_details['formData']['depclause']) && $pipeline_details['formData']['depclause'] == true) {
            $questions_array[] = 'Departmental clause';
            $answes_array[] = "yes";
        }

        if ($pipeline_details['formData']['risk'] > 0 && isset($pipeline_details['formData']['rent']) && $pipeline_details['formData']['rent'] == true) {
            $questions_array[] = 'Rent & Lease hold interest';
            $answes_array[] = "yes";
        }
        if (isset($pipeline_details['formData']['hasaccomodation']) && $pipeline_details['formData']['hasaccomodation'] == "yes") {
            $questions_array[] = 'Cover for alternate accomodation';
            $answes_array[] = "yes";
        }

        if (isset($pipeline_details['formData']['costofConstruction']) && $pipeline_details['formData']['costofConstruction'] == true) {
            $questions_array[] = 'Demolition and increased cost of construction';
            $answes_array[] = "yes";
        }
        if (isset($pipeline_details['formData']['ContingentExpense']) && $pipeline_details['formData']['ContingentExpense'] == true) {
            $questions_array[] = 'Contingent business inetruption and contingent extra expense';
            $answes_array[] = "yes";
        }
        if (isset($pipeline_details['formData']['interuption']) && $pipeline_details['formData']['interuption'] == true) {
            $questions_array[] = 'Non Owned property in vicinity interuption';
            $answes_array[] = "yes";
        }
        if (isset($pipeline_details['formData']['Royalties']) && $pipeline_details['formData']['Royalties'] == true) {
            $questions_array[] = 'Royalties';
            $answes_array[] = "yes";
        }
        if (isset($pipeline_details['formData']['deductible'])) {
            $questions_array[] = 'Deductible';
            $answes_array[] = $pipeline_details['formData']['deductible'];
        }
        if (isset($pipeline_details['formData']['ratep'])) {
            $questions_array[] = 'Rate/premium required';
            $answes_array[] = $pipeline_details['formData']['ratep'];
        }
        if (isset($pipeline_details['formData']['brokerage'])) {
            $questions_array[] = 'Brokerage';
            $answes_array[] = $pipeline_details['formData']['brokerage'];
        }
        if (isset($pipeline_details['formData']['spec_condition'])) {
            $questions_array[] = 'Special Condition';
            $answes_array[] = $pipeline_details['formData']['spec_condition'];
        }
        if (isset($pipeline_details['formData']['warranty'])) {
            $questions_array[] = 'Warranty';
            $answes_array[] = $pipeline_details['formData']['warranty'];
        }
        if (isset($pipeline_details['formData']['exclusion'])) {
            $questions_array[] = 'Exclusion';
            $answes_array[] = $pipeline_details['formData']['exclusion'];
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
            $excel->sheet('Business Interruption', function ($sheet) use ($data) {
                $sheet->fromArray($data, null, 'A1', true, false);
                $sheet->row(1, function ($row) {
                    $row->setFontSize(10);
                    $row->setFontColor('#ffffff');
                    $row->setBackground('#1155CC');
                });
                $sheet->protect('password');
                $sheet->getStyle('C2:D36')->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
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

        foreach ($questions as $key => $question) {
            if ($question == 'Additional increase in cost of working' && $pipeline_details['formData']['costWork'] == true) {
                $insurerReplay_object->costWork = ucwords($insurer_response_array[$key]);
            }
            if ($question == 'Claims preparation clause' && $pipeline_details['formData']['claimClause'] == true) {
                $claimClause_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $claimClause_object->isAgree = ucwords($insurer_response_array[$key]);
                $claimClause_object->comment = ucwords($comments);
                $insurerReplay_object->claimClause = $claimClause_object;
            }
            if ($question == 'Suppliers extension/customer extension' && $pipeline_details['formData']['custExtension'] == true) {
                $custExtension_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $custExtension_object->isAgree = ucwords($insurer_response_array[$key]);
                $custExtension_object->comment = ucwords($comments);
                $insurerReplay_object->custExtension = $custExtension_object;
            }
            if ($question == 'accountants clause' && $pipeline_details['formData']['accountants'] == true) {
                $accountants_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $accountants_object->isAgree = ucwords($insurer_response_array[$key]);
                $accountants_object->comment = ucwords($comments);
                $insurerReplay_object->accountants = $accountants_object;
            }
            if ($question == 'Payment on account' && $pipeline_details['formData']['payAccount'] == true) {
                $payAccount_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $payAccount_object->isAgree = ucwords($insurer_response_array[$key]);
                $payAccount_object->comment = ucwords($comments);
                $insurerReplay_object->payAccount = $payAccount_object;
            }
            if ($question == 'Prevention/denial of access' && $pipeline_details['formData']['denialAccess'] == true) {
                $denialAccess_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $denialAccess_object->isAgree = ucwords($insurer_response_array[$key]);
                $denialAccess_object->comment = ucwords($comments);
                $insurerReplay_object->denialAccess = $denialAccess_object;
            }
            if ($question == 'Premium adjustment clause' && $pipeline_details['formData']['premiumClause'] == true) {
                $premiumClause_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $premiumClause_object->isAgree = ucwords($insurer_response_array[$key]);
                $premiumClause_object->comment = ucwords($comments);
                $insurerReplay_object->premiumClause = $premiumClause_object;
            }
            if ($question == 'Public utilities clause' && $pipeline_details['formData']['utilityClause'] == true) {
                $utilityClause_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $utilityClause_object->isAgree = ucwords($insurer_response_array[$key]);
                $utilityClause_object->comment = ucwords($comments);
                $insurerReplay_object->utilityClause = $utilityClause_object;
            }
            if ($question == 'Brokers Claim Handling Clause : A loss notification received by the Insurance Broker will be deemed as a loss notification to Insurer. All communications flowing between the Insurer, Insured and the appointed Loss Surveyor should be channelized through the Broker, unless there is any unavoidable reasons compelling direct communications between the parties' && $pipeline_details['formData']['brokerClaim'] == true) {
                $insurerReplay_object->brokerClaim = ucwords($insurer_response_array[$key]);
            }
            if ($question == 'Accounts recievable / Loss of booked debts' && $pipeline_details['formData']['bookedDebts'] == true) {
                $bookedDebts_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $bookedDebts_object->isAgree = ucwords($insurer_response_array[$key]);
                $bookedDebts_object->comment = ucwords($comments);
                $insurerReplay_object->bookedDebts = $bookedDebts_object;
            }
            if ($question == 'Interdependany clause' && $pipeline_details['formData']['interdependanyClause'] == true) {
                $insurerReplay_object->interdependanyClause = ucwords($insurer_response_array[$key]);
            }
            if ($question == 'Extra expense' && $pipeline_details['formData']['extraExpense'] == true) {
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
            if ($question == 'Contaminated water' && $pipeline_details['formData']['water'] == true) {
                $insurerReplay_object->water = ucwords($insurer_response_array[$key]);
            }
            if ($question == 'Auditors fees' && $pipeline_details['formData']['auditorFee'] == true) {
                $auditorFee_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $auditorFee_object->isAgree = ucwords($insurer_response_array[$key]);
                $auditorFee_object->comment = ucwords($comments);
                $insurerReplay_object->auditorFee = $auditorFee_object;
            }
            if ($question == 'expense to reduce the laws' && $pipeline_details['formData']['expenseLaws'] == true) {
                $expenseLaws_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $expenseLaws_object->isAgree = ucwords($insurer_response_array[$key]);
                $expenseLaws_object->comment = ucwords($comments);
                $insurerReplay_object->expenseLaws = $expenseLaws_object;
            }
            if ($question == 'Nominated loss adjuster' && $pipeline_details['formData']['lossAdjuster'] == true) {
                $lossAdjuster_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $lossAdjuster_object->isAgree = ucwords($insurer_response_array[$key]);
                $lossAdjuster_object->comment = ucwords($comments);
                $insurerReplay_object->lossAdjuster = $lossAdjuster_object;
            }
            if ($question == 'Outbreak of discease' && $pipeline_details['formData']['discease'] == true) {
                $discease_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $discease_object->isAgree = ucwords($insurer_response_array[$key]);
                $discease_object->comment = ucwords($comments);
                $insurerReplay_object->discease = $discease_object;
            }
            if ($question == 'Failure of non public power supply' && $pipeline_details['formData']['powerSupply'] == true) {
                $powerSupply_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $powerSupply_object->isAgree = ucwords($insurer_response_array[$key]);
                $powerSupply_object->comment = ucwords($comments);
                $insurerReplay_object->powerSupply = $powerSupply_object;
            }
            if ($question == 'Murder, Suicide or outbreak of discease on the premises' && $pipeline_details['formData']['condition1'] == true) {
                $condition1_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $condition1_object->isAgree = ucwords($insurer_response_array[$key]);
                $condition1_object->comment = ucwords($comments);
                $insurerReplay_object->condition1 = $condition1_object;
            }
            if ($question == 'Bombscare and unexploded devices on the premises' && $pipeline_details['formData']['condition2'] == true) {
                $condition2_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $condition2_object->isAgree = ucwords($insurer_response_array[$key]);
                $condition2_object->comment = ucwords($comments);
                $insurerReplay_object->condition2 = $condition2_object;
            }
            if ($question == 'Book of Debts' && $pipeline_details['formData']['bookofDebts'] == true) {
                $bookofDebts_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $bookofDebts_object->isAgree = ucwords($insurer_response_array[$key]);
                $bookofDebts_object->comment = ucwords($comments);
                $insurerReplay_object->bookofDebts = $bookofDebts_object;
            }
            if ($question == 'Departmental clause' && $pipeline_details['formData']['depclause'] == true) {
                $insurerReplay_object->depclause = ucwords($insurer_response_array[$key]);
            }
            if ($question == 'Rent & Lease hold interest' && $pipeline_details['formData']['rent'] == true) {
                $rent_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $rent_object->isAgree = ucwords($insurer_response_array[$key]);
                $rent_object->comment = ucwords($comments);
                $insurerReplay_object->rent = $rent_object;
            }
            if ($question == 'Cover for alternate accomodation' && $pipeline_details['formData']['hasaccomodation'] == "yes") {
                $hasaccomodation_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $hasaccomodation_object->isAgree = ucwords($insurer_response_array[$key]);
                $hasaccomodation_object->comment = ucwords($comments);
                $insurerReplay_object->hasaccomodation = $hasaccomodation_object;
            }
            if ($question == 'Demolition and increased cost of construction' && $pipeline_details['formData']['costofConstruction'] == true) {
                $costofConstruction_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $costofConstruction_object->isAgree = ucwords($insurer_response_array[$key]);
                $costofConstruction_object->comment = ucwords($comments);
                $insurerReplay_object->costofConstruction = $costofConstruction_object;
            }
            if ($question == 'Contingent business inetruption and contingent extra expense' && $pipeline_details['formData']['ContingentExpense'] == true) {
                $ContingentExpense_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $ContingentExpense_object->isAgree = ucwords($insurer_response_array[$key]);
                $ContingentExpense_object->comment = ucwords($comments);
                $insurerReplay_object->ContingentExpense = $ContingentExpense_object;
            }
            if ($question == 'Non Owned property in vicinity interuption' && $pipeline_details['formData']['interuption'] == true) {
                $interuption_object = new \stdClass();
                if ($new_comments__array[$key] == '--') {
                    $comments = '';
                } else {
                    $comments = $new_comments__array[$key];
                }
                $interuption_object->isAgree = ucwords($insurer_response_array[$key]);
                $interuption_object->comment = ucwords($comments);
                $insurerReplay_object->interuption = $interuption_object;
            }
            if ($question == 'Royalties' && $pipeline_details['formData']['Royalties'] == true) {
                $insurerReplay_object->Royalties = ucwords($insurer_response_array[$key]);
            }
            if ($question == 'Deductible') {
                if (is_numeric($insurer_response_array[$key])) {
                    $insurerReplay_object->deductible = ucwords($insurer_response_array[$key]);
                } else {
                    return response()->json(['success' => 'failed', "pipeline_id" => $pipeline_details->_id]);
                }
            }
            if ($question == 'Rate/premium required') {
                if (is_numeric($insurer_response_array[$key])) {
                    $insurerReplay_object->ratep = ucwords($insurer_response_array[$key]);
                } else {
                    return response()->json(['success' => 'failed', "pipeline_id" => $pipeline_details->_id]);
                }
            }
            if ($question == 'Brokerage') {
                if (is_numeric($insurer_response_array[$key])) {
                    $insurerReplay_object->brokerage = ucwords($insurer_response_array[$key]);
                } else {
                    return response()->json(['success' => 'failed', "pipeline_id" => $pipeline_details->_id]);
                }
            }
            if ($question == 'Special Condition') {
                if (is_numeric($insurer_response_array[$key])) {
                    $insurerReplay_object->spec_condition = ucwords($insurer_response_array[$key]);
                } else {
                    return response()->json(['success' => 'failed', "pipeline_id" => $pipeline_details->_id]);
                }
            }
            if ($question == 'Warranty') {
                if (is_numeric($insurer_response_array[$key])) {
                    $insurerReplay_object->warranty = ucwords($insurer_response_array[$key]);
                } else {
                    return response()->json(['success' => 'failed', "pipeline_id" => $pipeline_details->_id]);
                }
            }
            if ($question == 'Exclusion') {
                if (is_numeric($insurer_response_array[$key])) {
                    $insurerReplay_object->exclusion = ucwords($insurer_response_array[$key]);
                } else {
                    return response()->json(['success' => 'failed', "pipeline_id" => $pipeline_details->_id]);
                }
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
     * Preview of excel details
     */
    public function importedList()
    {
        $data1 = ImportExcel::first();
        $data = $data1['upload'];
        $pipeline_id = $data1['pipeline_id'];
        $insurer_id = $data1['insurer_id'];
        return view('pipelines.business.imported_list', compact('data', 'pipeline_id', 'insurer_id'));
    }
    /**
     * Function for quot amendment in e quotation
     */
    public function amendQuot(Request $request)
    {
        try {
            $uniqueToken = $request->input('token');
            $id = $request->input('id');
            $field = $request->input('field');
            $new_quot = $request->input('new_quot');
            $pipelineDetails = PipelineItems::find($id);
            // var_dump($request->get('comment') );die;
            if ($pipelineDetails) {
                $replies = $pipelineDetails->insurerReplay;
                foreach ($replies as $key => $reply) {
                    if ($reply['uniqueToken'] == $uniqueToken) {
                        if ($field != 'costWork' && $field != 'brokerClaim' && $field != 'interdependanyClause' && $field != 'water' && $field != 'depclause'
                            && $field != 'Royalties' && $field != 'deductible' && $field != 'ratep' && $field != 'spec_condition' && $field != 'warranty' && $field != 'brokerage' && $field != 'exclusion') {
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
                        } else {
                            if ($field == 'medicalExpense' || $field == 'repatriationExpenses') {
                                $old_quot = $reply[$field];
                                $old_quot = str_replace(',', '', $old_quot);
                                $new_quot = str_replace(',', '', $new_quot);
                            } else {
                                $old_quot = $reply[$field];
                            }
                            if($field == 'ratep' || $field == 'spec_condition'  || $field == 'warranty' || $field == 'exclusion' || $field == 'deductible' || $field == 'brokerage'){
                                if (!is_numeric($new_quot)) {
                                return 'failed';
                            } 
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
                            PipelineItems::where('_id', $id)->update(array('insurerReplay.' . $key . '.' . $field => $new_quot));
                        }
                    }
                }
            }
            return 'success';
        } catch (\Exception $e) {
            return 'failed';
        }
    }

    /**
     * save selected insurers after  e-quotation
     */
    public function saveSelectedInsurers(Request $request)
    {
        $pipeline_details = PipelineItems::find($request->input('pipeline_id'));
        if (isset($pipeline_details['comparisonToken'])) {
            PipelineItems::where('_id', $request->input('pipeline_id'))->update(array('comparisonToken.status' => 'active'));
        }
        $checked = $request->input('insure_check');

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
                        PipelineItems::where('_id', $request->input('pipeline_id'))->push('selected_insurers', $selected_insurers);
                    }
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
            // dd($selectedId);
            return view('pipelines.business.e_comparison')->with(compact('pipeline_details', 'selectedId', 'insures_details'));
        } else {
            return view('error');
        }
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
        $pipeLine = PipelineItems::findOrFail($pipelineId);
        $departments = $pipeLine->getCustomer['departmentDetails'];

        if (isset($department)) {
            foreach ($departments as $department) {
                if ($department['departmentName'] == 'Genaral & Marine') {
                    //dd($department);
                    $name = $department['depContactPerson'];
                    $email = $department['depContactEmail'];
                    $status = 1;
                    break;
                }
            }
        }
        $token = str_random(3) . time() . str_random(3);
        if (isset($pipeLine['documentNo'])) {
            $number = $pipeLine['documentNo'] + 1;
        } else {
            $number = 0;
        }

        if ($status == 0) {
            $name = $pipeLine->customer['name'];
            $email = $pipeLine->getCustomer->email[0];
        }
        $refNo = $pipeLine->refereneceNumber;
        $token_object = new \stdClass();
        $token_object->token = (string) $token;
        $token_object->status = (string) 'active';
        $token_object->date = date('d/m/Y');
        $token_object->viewStatus = (string) 'Sent to customer';
        $pipeLine->comparisonToken = $token_object;
        $workType = $pipeLine->workTypeId['name'];
        if ($workType == "Business Interruption") {
            $link = url('business_interruption/view-comparison/' . $token);
        }
        if (isset($email) && !empty($email)) {
            SendComparison::dispatch($email, $name, $link, $workType, $refNo, $files, $comment);
            $updatedBy_obj = new \stdClass();
            $updatedBy_obj->id = new ObjectID(Auth::id());
            $updatedBy_obj->name = Auth::user()->name;
            $updatedBy_obj->date = date('d/m/Y');
            $updatedBy_obj->action = "E comparison send";
            $updatedBy[] = $updatedBy_obj;
            PipelineItems::where('_id', new ObjectId($pipelineId))->push('updatedBy', $updatedBy);
            $pipeLine->documentNo = $number;
            $pipeLine->save();
            return 'E-comparison has been sent to ' . $email;
        } else {
            return 'Failed! Email ID not provided for this customer';
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
            return view('pipelines.business.customer_e_comparison')->with(compact('pipeline_details', 'insures_details', 'selectedId'));
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
                    if ($workType == "Business Interruption") {
                        Session::flash('msg', "You have approved the proposal for Business Interruption");
                    }
                    // if ($workType == 'Employers Liability') {
                    //     Session::flash('msg', "You have approved the proposal for employers liability");
                    // } elseif ($workType == "Workman's Compensation") {
                    //     Session::flash('msg', "You have approved the proposal for workman's compensation");
                    // } elseif ($workType == "Money") {
                    //     Session::flash('msg', "You have approved the proposal for money");
                    // } elseif ($workType == "Business Interruption") {
                    //     Session::flash('msg', "You have approved the proposal for Business Interruption");
                    // }
                    //                    Session::flash('msg', "You have approved the proposal for workman's compensation");
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
     * Function for save as PDF
     */
    public function savePDF($pipelineId)
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
        // dd($insures_details);
        $pdf = PDF::loadView('pipelines.business.e_comparison_pdf', ['pipeline_details' => $pipeline_details, 'selectedId' => $selectedId, 'insures_details' => $insures_details])->setPaper('a3')->setOrientation('landscape')->setOption('margin-bottom', 0);
        $pdf_name = 'e_comparison_' . time() . '_' . $pipelineId . '.pdf';
        $pdf->setOption('margin-top', 0);
        $pdf->setOption('margin-bottom', 0);
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
     * Functon for save account details in approved e quotes
     */
    public function saveAccounts(Request $request)
    {
        $id = $request->input('pipeline_id');
        $pipelineItem = PipelineItems::find($id);
        try {
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
            $accounts_object->currency = str_replace(',', '', $request->input('currency'));
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
        } catch (\Exception $e) {
            return 'failed';
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
            return view('pipelines.business.issuance')->with(compact('pipelineId', 'pipeline_details', 'insures_details'));
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
            //dd($pipeline_details['accountsDetails']['vatTotal']);
            $insurerReplay = $pipeline_details['insurerReplay'];
            foreach ($insurerReplay as $insures_rep) {
                if (isset($insures_rep['customerDecision'])) {
                    if ($insures_rep['quoteStatus'] == 'active' && @$insures_rep['customerDecision']['decision'] == 'Approved') {
                        $insures_details = $insures_rep;
                    }
                }
            }
            return view('pipelines.business.view_pending_details')->with(compact('pipelineId', 'pipeline_details', 'insures_details'));
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
            return view('pipelines.business.quote_amendment')->with(compact('pipeline_details', 'insures_details', 'selectedId'));
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
            return view('pipelines.business.approved_quot')->with(compact('pipelineId', 'pipeline_details', 'insures_details'));
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
            return view('pipelines.business.worksman_issuance')->with(compact('pipelineId', 'pipeline_details', 'insures_details'));
        }
    }
}
