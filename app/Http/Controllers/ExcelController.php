<?php

namespace App\Http\Controllers;

use App\Customer;
use App\CustomerMode;
use App\Departments;
use App\Jobs\sendExcel;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\PipelineItems;
use App\WorkTypeData;
use Illuminate\Http\Request;
use MongoDB\BSON\ObjectId;

class ExcelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.underwriter');
    }

    /**
     * Export Users list
     */
    public function exportCustomers(Request $request)
    {
        ini_set('xdebug.max_nesting_level', 500);
        $email=$request->input('email');
        $filterData = json_decode(session('filter'));
        $sort = session('sort');
        $search = session('search');
        $customerMode = @$request->input('customerMode');
        $user_lists = Customer::where('status', 1);
        if (isset($customerMode)) {
            $customerModeIDs =    CustomerMode::pluck('_id');
            if ($customerMode == 1) {
                $user_lists = $user_lists->where('customerMode', '!=',  new ObjectID($customerModeIDs[1]));
            } else {
                $user_lists = $user_lists->where('customerMode',  new ObjectID($customerModeIDs[1]));
            }
        }
        if (session('role') == 'Agent') {
            $user_lists = $user_lists->where(
                function ($q) {
                    $q->where('agent.id', new ObjectID(Auth::user()->_id));
                }
            );
        }
        if (!empty($filterData)) {
            if (!empty($filterData->agent)) {
                $val_array = [];
                foreach ($filterData->agent as $val) {
                    if ($val == "Nil") {
                        $val_array[] = (string)0;
                    }
                    if ($val!='0' && $val!='Nil') {
                        $val_array[] = new ObjectID($val);
                    }
                }
                $user_lists = $user_lists->whereIn('agent.id', $val_array);
            }
            if (!empty($filterData->main_group)) {
                $val_array = [];
                foreach ($filterData->main_group as $val) {
                    if ($val == "Nil") {
                        $val_array[] = (string)0;
                    }
                    if ($val!='0' && $val!='Nil') {
                        $val_array[] = new ObjectID($val);
                    }
                }
                $user_lists = $user_lists->whereIn('mainGroup.id', $val_array);
            }

            if (!empty($filterData->level)) {
                $val_array = [];
                foreach ($filterData->level as $val) {
                    if ($val == "Nil") {
                        $val_array[] = (string)0;
                    }
                    if ($val!='0' && $val!='Nil') {
                        $val_array[] = new ObjectID($val);
                    }
                }
                $user_lists = $user_lists->whereIn('customerLevel.id', $val_array);
            }
        }

        if (!empty($sort)) {
            if ($sort=="Name") {
                $user_lists = $user_lists->orderBy('fullName');
            } elseif ($sort=="Customer Code") {
                $user_lists = $user_lists->orderBy('customerCodeValue');
            } elseif ($sort=="Agent") {
                $user_lists = $user_lists->orderBy('agent.name');
            } elseif ($sort=="Main Group") {
                $user_lists = $user_lists->orderBy('mainGroup.name');
            }
        } elseif (empty($sort)) {
            $user_lists = $user_lists->orderBy('createdAt', 'DESC');
        }


        if (!empty($search)) {
            $user_lists = $user_lists->where(
                function ($query) use ($search) {
                    $query->where('customerCode', 'like', '%'.$search.'%')
                        ->orWhere('fullName', 'like', '%'.$search.'%')
                        ->orWhere('contactNumber', 'like', '%'.$search.'%')
                        ->orWhere('email', 'like', '%'.$search.'%')
                        ->orWhere('agent.name', 'like', '%'.$search.'%')
                        ->orWhere('mainGroup.name', 'like', '%'.$search.'%')
                        ->orWhere('customerLevel.name', 'like', '%'.$search.'%');
                }
            );
        }
        //        $user_list = $user_lists->get();
        $data[] = array('Customer List');
        $excel_header= ['Type','Customer Code', 'Name', 'Contact No', 'Email', 'Main Group', 'Agent', 'Level', 'Number of Policies','Address Line 1','City','Emirates','Country','Zip Code'];
        $file_name_= 'Customer-List'.rand();
        Excel::create(
            $file_name_, function ($excel) use ($user_lists,$excel_header) {
                $excel->sheet(
                    'Customers list', function ($sheet) use ($user_lists,$excel_header) {
                        $sheet->appendRow($excel_header);
                        $sheet->row(
                            1, function ($row) {
                                $row->setFontSize(10);
                                $row->setFontColor('#ffffff');
                                $row->setBackground('#1155CC');
                            }
                        );
                        $user_lists->chunk(
                            100, function ($final) use ($sheet) {
                                foreach ($final as $user) {
                                    if (isset($user['departmentDetails'])) {
                                        $policyDetails=$user['policyDetails'];
                                        $policy=count($policyDetails);
                                    } else {
                                        $policy=0;
                                    }
                                    $mainGroup = $user['mainGroup'];
                                    $mainGroupName = $mainGroup['name'];
                                    $agentUser=User::find($user['agent.id']);
                                    $agent = $user['agent.name'];
                                    $agentId=$agentUser->empID;
                                    if (isset($agentId)&& $agentId!='') {
                                        $agentName=    $agent.' ('.$agentId .')';
                                    } else {
                                        $agentName=$agent;
                                    }
                                    //            $agent = $user['agent'];
                                    //            $agentName = $agent['name'];
                                    $level = $user['customerLevel'];
                                    $levelName = $level['name'];
                                    if (is_array($user['email'])) {
                                        $primaryEmail = $user['email'];
                                        $email = $primaryEmail[0];
                                    } else {
                                        $email = $user['email'];
                                    }

                                    if (is_array($user['contactNumber'])) {
                                        $primaryContact = $user['contactNumber'];
                                        $contact = $primaryContact[0];
                                    } else {
                                        $contact = $user['contactNumber'];
                                    }

                                    if (!empty($user['salutation'])) {
                                        $name = $user['salutation'].$user['fullName'];
                                    } else {
                                        $name = $user['fullName'];
                                    }

                                    $data= array(
                                    $user->getType->name,
                                    $user['customerCode'],
                                    $name,
                                    $contact,
                                    $email?: '--',
                                    $mainGroupName?: '--',
                                    $agentName?: '--',
                                    $levelName?: '--',
                                    $policy?: '--',
                                    $user['addressLine1'] ? $user['addressLine1'] : 'Nil',
                                    $user['streetName']?:'--',
                                    $user['cityName']?: '--',
                                    $user['countryName']?: '--',
                                    $user['zipCode']?:'--',
                                    );
                                    $sheet->appendRow($data);
                                }
                            }
                        );
                    }
                );
            }
        )->store('xls', public_path('excel'));
        $excel_name=$file_name_.'.'.'xls';
        $send_excel=public_path('/excel/'.$excel_name);
        //        dd($send_excel);
        $tab_value='customers';
        sendExcel::dispatch($email, $send_excel, $tab_value);
        //        Session::flash('status', 'Excel send to '. $email );
        return 'success';
    }

    /*
     * Function for pipeline export*/

    public function exportPipeline(Request $request)
    {
        $filterData = json_decode(session('filter'));
        $sort = session('sort');
        $search = session('search');
        if ($filterData) {
            $pipeData = WorkTypeData::where('pipelineStatus', "true");
            if (!empty($filterData->customer)) {
                $count = 0;
                foreach ($filterData->customer as $cust) {
                    $objectArray[$count] = new ObjectId($cust);
                    $count++;
                }
                $pipeData = $pipeData->whereIn('customer.id', $objectArray);
            }

            if (!empty($filterData->main_group_id)) {
                $pipeData = $pipeData->whereIn('customer.maingroupCode', $filterData->main_group_id);
            }

            if (!empty($filterData->main_group)) {
                $count = 0;
                foreach ($filterData->main_group as $cust) {
                    if ($cust == "Nil") {
                        $objectArray[$count] = (string)0;
                    }
                    if ($cust != '0' && $cust != 'Nil') {
                        $objectArray[$count] = new ObjectId($cust);
                    }
                    $count++;
                }
                $pipeData = $pipeData->whereIn('customer.maingroupId', $objectArray);
            }

            if (!empty($filterData->department)) {
                $val_array=[];
                foreach ($filterData->department as $cust) {
                    $departmentDet = Departments::find($cust);
                    $val_array[]=$departmentDet->name;
                }
                $pipeData = $pipeData->whereIn('workTypeId.department', $val_array);
            }
            if (!empty($filterData->work_type)) {
                $count = 0;
                foreach ($filterData->work_type as $cust) {
                    $objectArray[$count] = new ObjectId($cust);
                    $count++;
                }
                $pipeData = $pipeData->whereIn('workTypeId.id', $objectArray);
            }
            if (!empty($filterData->agent)) {
                $count = 0;
                foreach ($filterData->agent as $cust) {
                    $objectArray[$count] = new ObjectId($cust);
                    $count++;
                }
                $pipeData = $pipeData->whereIn('agent.id', $objectArray);
            }
            if (!empty($filterData->case_manager)) {
                $count = 0;
                foreach ($filterData->case_manager as $cust) {
                    $objectArray[$count] = new ObjectId($cust);
                    $count++;
                }
                $pipeData = $pipeData->whereIn('caseManager.id', $objectArray);
            }

            if (!empty($filterData->current_status)) {
                $count = 0;
                foreach ($filterData->current_status as $cust) {
                    $objectArray[$count] = new ObjectId($cust);
                    $count++;
                }
                $pipeData = $pipeData->whereIn('status.id', $objectArray);
            }
        } else {
            $pipeData = WorkTypeData::where('pipelineStatus', "true");
        }

        if ($sort=="Customer Name") {
            $items1 = $pipeData->orderBy('customer.name');
        } elseif ($sort=="Agent Name") {
            $items1 = $pipeData->orderBy('agent.name');
        } elseif ($sort=="Category") {
            $items1 = $pipeData->orderBy('workTypeId.name');
        } elseif ($sort=="Status") {
            $items1 = $pipeData->orderBy('status.status');
        } elseif ($sort=="Last Updated At") {
            $items1 = $pipeData->orderBy('updated_at', 'desc');
        } else {
            $items1 = $pipeData->orderBy('updated_at', 'desc');
        }
        if ($search) {
            $item1 = $items1->where(
                function ($query) use ($search) {
                    $query->where('customer.name', 'like', '%'.$search.'%')
                        ->orwhere('customer.customerCode', 'like', '%'.$search.'%')
                        ->orWhere('workTypeId.name', 'like', '%'.$search.'%')
                        ->orWhere('workTypeId.department', 'like', '%'.$search.'%')
                        ->orWhere('customer.maingroupName', 'like', '%'.$search.'%')
                        ->orWhere('customer.maingroupCode', 'like', '%'.$search.'%')
                        ->orWhere('caseManager.name', 'like', '%'.$search.'%')
                        ->orwhere('updated_at', 'like', '%'.$search.'%')
                        ->orWhere('status.status', 'like', '%'.$search.'%')
                        ->orWhere('agent.name', 'like', '%'.$search.'%')
                    //                    ->orWhere('status.date','like','%'.$search.'%')
                    //                    ->orWhere('status.UpdatedByName','like','%'.$search.'%')
                    //                    ->orWhere('status.date','like','%'.$search.'%')
                        ->orwhere('createdBy.name', 'like', '%'.$search.'%')
                        ->orWhere('refereneceNumber', 'like', '%'.$search.'%');
                }
            );
            session()->put('search', $search);
        } else {
            $item1 = $items1;
        }

        $pipeItem = $item1->get();

        $data[] = array('PipeLine List');
        $data[] = ['REFERENCE NUMBER', 'DATE CREATED', 'CREATED BY','CUSTOMER ID', 'CUSTOMER NAME', 'MAIN GROUP ID', 'MAINGROUP NAME', 'DEPARTMENT','WORK TYPE', 'AGENT NAME',
            'UNDERWRITER', 'CURRENT STATUS', 'CURRENT STATUS UPDATED BY', 'LAST STATUS CHANGE DATE', 'CURRENT OWNER', 'NUMBER OF DAYS SINCE LAST TOUCHED' ,'NUMBER OF AMENDMENTS'];


        foreach ($pipeItem as $pipeline) {
            if ($pipeline->status['status'] == "") {
                $status = "--";
            } else {
                $status = $pipeline->status['status'];
            }
            if (isset($pipeline->customer['customerCode'])) {
                $code=$pipeline->customer['customerCode'];
            } else {
                $code='--';
            }
            $update = $pipeline->updatedBy;
            $lastUpdate = end($update);
            $updated_by = $lastUpdate['name'];
            $updated_at = $lastUpdate['date'];
            if (isset($pipeline->customer['maingroupCode'])) {
                $maingroupId = $pipeline->customer['maingroupCode'];
            } else {
                $maingroupId = '--';
            }
            if (isset($pipeline->workTypeId['department'])) {
                $department = $pipeline->workTypeId['department'];
            } else {
                $department = '--';
            }
            if (isset($pipeline->status['UpdatedByName'])) {
                $current_update = $pipeline->status['UpdatedByName'];
            } else {
                $current_update = '--';
            }
            if (isset($pipeline->status['date'])) {
                $status_date = $pipeline->status['date'];
            } else {
                $status_date = '--';
            }
            $update = $pipeline->updatedBy;
            $lastUpdate = end($update);
            $old = str_replace("/", "-", $lastUpdate['date']);
            $today = date('d-m-Y');
            $date1=date_create($today);
            $date2=date_create($old);
            $diff = date_diff($date1, $date2);
            $diff = $diff->format("%a days");
            $underwriter = '--';
            if (isset($pipeline['documentNo'])) {
                $amendments = $pipeline['documentNo'];
            } else {
                $amendments = '--';
            }
            if (isset($pipeline->customer['maingroupName'])) {
                $maingroupName = $pipeline->customer['maingroupName'];
            } else {
                $maingroupName = '--';
            }
            $data[] = array(

                $pipeline->refereneceNumber,
                Carbon::parse($pipeline->created_at)->format('d-m-Y'),
                $pipeline->createdBy['name'],
                $pipeline->customer['customerCode'],
                $pipeline->customer['name'],
                $maingroupId,
                $maingroupName,
                $department,
                $pipeline->workTypeId['name'],
                $pipeline->agent['name'],
                $pipeline->caseManager['name'],
                $status,
                $updated_by,
                Carbon::parse($pipeline->updated_at)->format('d-m-Y'),
                $pipeline->caseManager['name'],
                $diff,
                $amendments
            );
        }
        Excel::create(
            'Pipeline-List', function ($excel) use ($data) {
                $excel->sheet(
                    'Pipelines', function ($sheet) use ($data) {
                        $sheet->mergeCells('A1:Q1');
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
    /*
    * Function for pipeline export*/

    public function exportPendingList(Request $request)
    {
        $filterData = json_decode(session('filter'));
        $sort = session('sort');
        $search = session('search');
        if ($filterData) {
            $pipeData = WorkTypeData::where('pipelineStatus', "pending");
            if (!empty($filterData->customer)) {
                $count = 0;
                foreach ($filterData->customer as $cust) {
                    $objectArray[$count] = new ObjectId($cust);
                    $count++;
                }
                $pipeData = $pipeData->whereIn('customer.id', $objectArray);
            }

            if (!empty($filterData->main_group_id)) {
                $pipeData = $pipeData->whereIn('customer.maingroupCode', $filterData->main_group_id);
            }

            if (!empty($filterData->main_group)) {
                $count = 0;
                foreach ($filterData->main_group as $cust) {
                    if ($cust == "Nil") {
                        $objectArray[$count] = (string)0;
                    }
                    if ($cust != '0' && $cust != 'Nil') {
                        $objectArray[$count] = new ObjectId($cust);
                    }
                    $count++;
                }
                $pipeData = $pipeData->whereIn('customer.maingroupId', $objectArray);
            }

            if (!empty($filterData->department)) {
                $val_array=[];
                foreach ($filterData->department as $cust) {
                    $departmentDet = Departments::find($cust);
                    $val_array[]=$departmentDet->name;
                }
                $pipeData = $pipeData->whereIn('workTypeId.department', $val_array);
            }
            if (!empty($filterData->work_type)) {
                $count = 0;
                foreach ($filterData->work_type as $cust) {
                    $objectArray[$count] = new ObjectId($cust);
                    $count++;
                }
                $pipeData = $pipeData->whereIn('workTypeId.id', $objectArray);
            }
            if (!empty($filterData->agent)) {
                $count = 0;
                foreach ($filterData->agent as $cust) {
                    $objectArray[$count] = new ObjectId($cust);
                    $count++;
                }
                $pipeData = $pipeData->whereIn('agent.id', $objectArray);
            }
            if (!empty($filterData->case_manager)) {
                $count = 0;
                foreach ($filterData->case_manager as $cust) {
                    $objectArray[$count] = new ObjectId($cust);
                    $count++;
                }
                $pipeData = $pipeData->whereIn('caseManager.id', $objectArray);
            }
        } else {
            $pipeData = WorkTypeData::where('pipelineStatus', "pending");
        }

        if ($sort=="Customer Name") {
            $items1 = $pipeData->orderBy('customer.name');
        } elseif ($sort=="Agent Name") {
            $items1 = $pipeData->orderBy('agent.name');
        } elseif ($sort=="Worktype") {
            $items1 = $pipeData->orderBy('workTypeId.name');
        } elseif ($sort=="Status") {
            $items1 = $pipeData->orderBy('status.status');
        } elseif ($sort=="Last Updated At") {
            $items1 = $pipeData->orderBy('updated_at', 'desc');
        } else {
            $items1 = $pipeData->orderBy('updated_at', 'desc');
        }
        if ($search) {
            $item1 = $items1->where(
                function ($query) use ($search) {
                    $query->where('refereneceNumber', 'like', '%'.$search.'%')
                        ->orwhere('createdBy.name', 'like', '%'.$search.'%')
                        ->orwhere('customer.customerCode', 'like', '%'.$search.'%')
                        ->orwhere('customer.name', 'like', '%'.$search.'%')
                        ->orwhere('customer.maingroupCode', 'like', '%'.$search.'%')
                        ->orwhere('customer.maingroupName', 'like', '%'.$search.'%')
                        ->orWhere('workTypeId.department', 'like', '%'.$search.'%')
                        ->orWhere('workTypeId.name', 'like', '%'.$search.'%')
                        ->orWhere('agent.name', 'like', '%'.$search.'%')
                        ->orWhere('caseManager.name', 'like', '%'.$search.'%')
                        ->orWhere('accountsDetails.requestedForApproval.name', 'like', '%'.$search.'%')
                        ->orWhere('accountsDetails.requestedForApproval.date', 'like', '%'.$search.'%')
                        ->orWhere('accountsDetails.iibDiscount', 'like', '%'.$search.'%')
                        ->orWhere('accountsDetails.premium', 'like', '%'.$search.'%')
                        ->orWhere('accountsDetails.insurerPolicyNumber', 'like', '%'.$search.'%')
                        ->orWhere('accountsDetails.iibPolicyNumber', 'like', '%'.$search.'%')
                        ->orWhere('accountsDetails.insurenceCompany', 'like', '%'.$search.'%')
                        ->orWhere('accountsDetails.inceptionDate', 'like', '%'.$search.'%')
                        ->orWhere('accountsDetails.expiryDate', 'like', '%'.$search.'%')
                        ->orWhere('accountsDetails.currency', 'like', '%'.$search.'%')
                        ->orWhere('accountsDetails.premiumInvoiceDate', 'like', '%'.$search.'%')
                        ->orWhere('accountsDetails.premiumInvoice', 'like', '%'.$search.'%')
                        ->orWhere('accountsDetails.commissionInvoice', 'like', '%'.$search.'%')
                        ->orWhere('accountsDetails.paymentMode', 'like', '%'.$search.'%')
                        ->orWhere('accountsDetails.paymentStatus', 'like', '%'.$search.'%')
                        ->orWhere('accountsDetails.datePaymentInsurer', 'like', '%'.$search.'%')
                        ->orWhere('accountsDetails.delivaryMode', 'like', '%'.$search.'%');
                }
            );
            session()->put('search', $search);
        } else {
            $item1 = $items1;
        }

        $pipeItem = $item1->get();

        $data[] = array('Pending Approval List');
        $data[] = ['REFERENCE NUMBER','DATE CREATED','CREATED BY','CUSTOMER ID','CUSTOMER NAME','MAIN GROUP ID','MAIN GROUP NAME','DEPARTMENT','WORK TYPE','AGENT NAME','UNDER WRITER','SUBMITTED FOR APPROVAL ON','SUBMITTED FOR APPROVAL FROM	','CURRENT OWNER OF CASE','DISCOUNT','TOTAL PREMIUM AMOUNT','INSURER POLICY NUMBER','IIB POLICY NUMBER','INSURER','INCEPTION DATE','EXPIRY DATE','CURRENCY','INVOICE DATE','PREMIUM INVOICE NO','COMMISSION INVOICE NO','PAYMENT MODE','PAYMENT STATUS','DATE PAYMENT SENT TO INSURER','DELIVERY MODE','NAME OF THE UNDERWRITER'];


        foreach ($pipeItem as $pipeline) {
            if (isset($pipeline->customer['customerCode'])) {
                $code=$pipeline->customer['customerCode'];
            } else {
                $code='--';
            }
            $update = $pipeline->updatedBy;
            $lastUpdate = end($update);
            $updated_by = $lastUpdate['name'];

            $created_at=$pipeline->created_at;
            $created_at_date= Carbon::parse($created_at)->format('d-m-Y');
            $created_by=$pipeline->createdBy;
            $created_by_name=$created_by['name'];
            if (isset($pipeline->customer['maingroupCode'])) {
                $maingroup_code = $pipeline->customer['maingroupCode'];
            } else {
                $maingroup_code = '--';
            }

            if (isset($pipeline->workTypeId['department'])) {
                $department = $pipeline->workTypeId['department'];
            } else {
                $department = '--';
            }
            if (isset($pipeline->accountsDetails['requestedForApproval'])) {
                $submittedApprovalFrom= $pipeline->accountsDetails['requestedForApproval']['name'];
            } else {
                $submittedApprovalFrom = '--';
            }
            if (isset($pipeline->accountsDetails['requestedForApproval'])) {
                $submittedApprovalOn= $pipeline->accountsDetails['requestedForApproval']['date'];
            } else {
                $submittedApprovalOn = '--';
            }

            $data[] = array(
                $pipeline->refereneceNumber,
                $created_at_date,
                $created_by_name,
                $code,
                $pipeline->customer['name'],
                $maingroup_code,
                $pipeline->customer['maingroupName'],
                $department,
                $pipeline->workTypeId['name'],
                $pipeline->agent['name'],
                $pipeline->caseManager['name'],
                $submittedApprovalOn,
                $submittedApprovalFrom,
                $pipeline->caseManager['name'],
                $pipeline['accountsDetails']['iibDiscount']?:'--',
                $pipeline['accountsDetails']['premium']?:'--',
                $pipeline['accountsDetails']['insurerPolicyNumber']?:'--',
                $pipeline['accountsDetails']['iibPolicyNumber']?:'--',
                $pipeline['accountsDetails']['insurenceCompany']?:'--',
                $pipeline['accountsDetails']['inceptionDate']?:'--',
                $pipeline['accountsDetails']['expiryDate']?:'--',
                $pipeline['accountsDetails']['currency']?:'--',
                $pipeline['accountsDetails']['premiumInvoiceDate']?:'--',
                $pipeline['accountsDetails']['premiumInvoice']?:'--',
                $pipeline['accountsDetails']['commissionInvoice']?:'--',
                $pipeline['accountsDetails']['paymentMode']?:'--',
                $pipeline['accountsDetails']['paymentStatus']?:'--',
                $pipeline['accountsDetails']['datePaymentInsurer']?:'--',
                $pipeline['accountsDetails']['delivaryMode']?:'--',
                '--'

            );
        }
        Excel::create(
            'Pending Approval List', function ($excel) use ($data) {
                $excel->sheet(
                    'Pending Approval List', function ($sheet) use ($data) {
                        $sheet->mergeCells('A1:AD1');
                        $sheet->row(
                            1, function ($row) {
                                $row->setFontSize(13);
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
}
