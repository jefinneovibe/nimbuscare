<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Enquiries;
use App\EnquiryCredentials;
use App\EmailCredentials;
use Carbon\Carbon;
use App\Customer;
use App\ActivityLog;
use App\Jobs\ForwordEnquiry;
use App\Jobs\reminderRenewalMail;
use App\RecipientDetails;
use App\User;
use App\Insurer;
use Webklex\IMAP\Client;
use MongoDB\BSON\ObjectId;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\File\File as LocalFile;
use App\Role;
use Illuminate\Support\Facades\Mail;
use PhpParser\Node\Stmt\Catch_;
use App\CronJobLog;
use Illuminate\Support\Facades\Session;
use App\TestInsures;
use DateTime;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use MongoDB\BSON\UTCDateTime;
use PHPExcel_Style_NumberFormat;

class EnquiryManagementController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth.underwriter');
    }
    public function enquiryDashboard()
    {
        session()->pull('enquiryFilter');
        session()->pull('ActiveSearchKey');
        session()->forget('dispatch');
        session(['dispatch' => 'Enquiry']);
        return view('enquiry_management.enquiry_dashboard');
    }

    /**
     * to sort the documents in selected order
     */
    public function dynamicSort(Request $request)
    {
        $order = $request->input('order');
        session(['enquiryFilter.order' => $order]);
        $result = $this->buildQuery($request, $order);
        // dd($result);
        $documentOperation = $result['page'];
        $countMails = $result['count'];

        return response()->json(
            [
                'status' => 'success', 'documentOperation' => $documentOperation,
                'countMails' => $countMails
            ]
        );
    }

    protected function buildQuery($request, $order = null)
    {
        $paginationFactor = (int) Config::get('documents.pagination_factor');
        $order = session('enquiryFilter.order');
        // $key = $request->key;
        $documentStatus = $request->status;
        $mailBox = EnquiryCredentials::find($request->mailBox);
        $user = $mailBox->userID;
        $data = Enquiries::where('mailStatus', (int) $documentStatus)->where('documentMailBox', $user)
            ->where('deleted', '!=', 1);
        if ($request->status == 1) {
            $stat = session('enquiryFilter.statusList');
            $cust = session('enquiryFilter.customerList');
            $agen = session('enquiryFilter.agentList');
            $custAgent = session('enquiryFilter.customerAgentList');
            $mailFrom = session('enquiryFilter.from');
            $fromDateFilter = session('enquiryFilter.fromDateFilter');
            $toDateFilter = session('enquiryFilter.toDateFilter');
            $renewalFilter = session('enquiryFilter.renewalFilter');
            $nonrenewalFilter = session('enquiryFilter.nonrenewalFilter');
            $commentsCheck = session('enquiryFilter.commentsCheck');

            $key = session('activeSearchKey');
            $order = session('enquiryFilter.order');
            $group = session('enquiryFilter.GroupList');
            $nonstat = session('enquiryFilter.nonstatusList');
            $insurer = session('enquiryFilter.insurerList');
            // session()->pull('activeSearchKey');
            // session(['activeSearchKey' => $key]);
        } elseif ($request->status == 0) {
            // $stat = session('closedDocumentFilter.statusList');
            // $cust = session('closedDocumentFilter.customerList');
            // $agen = session('closedDocumentFilter.agentList');
            // $custAgent = session('closedDocumentFilter.customerAgentList');
            // $mailFrom = session('closedDocumentFilter.from');
            // $fromDate = session('closedDocumentFilter.fromDate');
            // $toDate = session('closedDocumentFilter.toDate');
            // $key = session('closedSearchKey');
        }
        if (isset($nonstat) && isset($stat) && $nonstat != '' && $stat != '') {
            $statArray = array_merge($stat, $nonstat);
            if (isset($statArray)) {
                $data->where(function ($query) use ($statArray) {
                    foreach ($statArray as $status) {
                        if (count(@$status['subStatus']) > 0) {
                            $subStatus = $status['subStatus'];
                            $Status = $status['status'];
                            $query->orwhere(function ($query2) use ($subStatus, $Status) {
                                $query2->where('assaignedTo.assaignStatusName', $Status);
                                $query2->where(function ($query3) use ($subStatus, $Status) {
                                    foreach ($subStatus as $eachstatus) {
                                        $query3->orWhere('assaignedTo.assaignSubStatusName', $eachstatus);
                                    }
                                });
                            });
                        } else {
                            $query->orWhere('assaignedTo.assaignStatusName', $status['status']);
                        }
                    }
                });
            }
        } else {
            if (isset($nonstat)) {
                $data->where(function ($query) use ($nonstat) {
                    foreach ($nonstat as $status) {
                        if (count(@$status['subStatus']) > 0) {
                            $subStatus = $status['subStatus'];
                            $Status = $status['status'];
                            $query->orwhere(function ($query2) use ($subStatus, $Status) {
                                $query2->where('assaignedTo.assaignStatusName', $Status);
                                $query2->where(function ($query3) use ($subStatus, $Status) {
                                    foreach ($subStatus as $eachstatus) {
                                        $query3->orWhere('assaignedTo.assaignSubStatusName', $eachstatus);
                                    }
                                });
                            });
                        } else {
                            $query->orWhere('assaignedTo.assaignStatusName', $status['status']);
                        }
                    }
                });
            }
            if (isset($stat)) {
                $data->where(function ($query) use ($stat) {
                    foreach ($stat as $status) {
                        if (count(@$status['subStatus']) > 0) {
                            $subStatus = $status['subStatus'];
                            $Status = $status['status'];
                            $query->orwhere(function ($query2) use ($subStatus, $Status) {
                                $query2->where('assaignedTo.assaignStatusName', $Status);
                                $query2->where(function ($query3) use ($subStatus, $Status) {
                                    foreach ($subStatus as $eachstatus) {
                                        $query3->orWhere('assaignedTo.assaignSubStatusName', $eachstatus);
                                    }
                                });
                            });
                        } else {
                            $query->orWhere('assaignedTo.assaignStatusName', $status['status']);
                        }
                    }
                });
            }
        }
        if (isset($cust)) {
            $data->whereIn('assaignedTo.customerId', $cust);
            $customers = Customer::whereIn('_id', $cust)->orderBy('fullName')->get();
        } else {
            $customers = '';
        }
        if (isset($custAgent)) {
            $data->whereIn('assaignedTo.customerAgentId', $custAgent);
        }
        if (isset($group)) {
            $data->whereIn('assaignedTo.groupName', $group);
        }
        if (isset($agen)) {
            $data->whereIn('assaignedTo.agentId', $agen);
        }
        if (isset($fromDateFilter)) {
            $fDate = Carbon::createFromFormat('!d/m/Y', $fromDateFilter);
            $data->where('mailRecTme', '>=', $fDate);
        }
        if (isset($toDateFilter)) {
            $TDate = Carbon::createFromFormat('!d/m/Y', $toDateFilter);
            $todate = $TDate->endOfDay();
            $data->where('mailRecTme', '<=', $todate);
        }
        if (isset($renewalFilter) && !isset($nonrenewalFilter)) {
            $data->where('renewal', 1);
        }
        if (isset($nonrenewalFilter) && !isset($renewalFilter)) {
            $data->where('renewal', '!=', 1);
        }
        if (isset($nonrenewalFilter) && isset($renewalFilter)) {
            $data;
        }
        if (isset($commentsCheck) && $commentsCheck) {
            $data = $data->where('comments', 'exists', true)
                ->where('commentSeen', '!=', new ObjectId(Auth::user()->_id));
        }
        if (isset($insurer)) {
            $data->whereIn('assaignedTo.insurerId', $insurer);
            $insurers = Insurer::whereIn('_id', $insurer)->orderBy('name')->get();
        } else {
            $insurers = '';
        }
        $key = session('ActiveSearchKey');
        if (isset($key)) {
            $data = $data->where(function ($query) use ($key) {
                $query->where('subject', 'like', '%' . $key . '%')
                    ->orWhere('assaignedTo.customerName', 'like', '%' . $key . '%')
                    ->orWhere('assaignedTo.insurerName', 'like', '%' . $key . '%')
                    ->orWhere('mailsText', 'like', '%' . $key . '%')
                    ->orWhere('attachements.attachName', 'like', '%' . $key . '%');
            });
        }
        if (isset($order) && $order == 'latest') {
            $data = $data->orderBy('created_at', 'desc');
        } else if (isset($order) && $order == 'earliest') {
            $data = $data->orderBy('created_at', 'asc');
        } else {
            $data = $data->orderBy('created_at', 'desc');
        }

        if (session('role') == 'Employee') {
            if ($documentStatus == 1 && !isset($agen)) {
                $data = $data->whereIn('assaignedTo.agentId', [new ObjectId(Auth::user()->_id), "999"]);
            }
        } elseif (session('role') == 'Coordinator') {
            $coAgent = (string) session('assigned_agent');
            $data = $data->where('assaignedTo.customerAgentId', $coAgent);
        } elseif (session('role') == 'Agent') {
            $data = $data->where('assaignedTo.customerAgentId', Auth::user()->_id);
        } elseif (session('role') == 'Supervisor' && $documentStatus == 1) {
            $employees = session('employees') ?: [];
            $employees = array_merge($employees, ["999", "", new ObjectId(Auth::user()->_id), null]);
            $data->whereIn('assaignedTo.agentId', $employees);
        }
        $countMails = $data->count();
        $data = $data->skip(0)->take($paginationFactor)->get();
        // dd($data);
        $mailBoxes = EnquiryCredentials::where('credentialStatus', 1)->get();
        $agents = User::where('isActive', 1)->where('role', 'AG')->orderBy('name')->get();
        if ($request->status == 1) {
            $documentOperation = view(
                'enquiry_management.enquiry_search',
                [
                    'data' => $data,
                    'mailBoxes' => $mailBoxes,
                    'user' => $user, 'agents' => $agents,
                    'countMails' => $countMails,
                    'customers' => $customers,
                    'insurers' => $insurers,
                    'countMails' => $countMails
                ]
            )->render();
        }
        return array(
            "page" => $documentOperation,
            "count" => $countMails
        );
    }


    public function getInsurer(Request $request)
    {
        if ($request->input('q')) {
            $insurers = Insurer::where('isActive', (int) 1)->where('name', 'like', $request->input('q') . '%')->orderBy('name')->get();
            if (count($insurers) == 0) {
                $insurers = Insurer::where('isActive', (int) 1)
                    ->where('name', 'like', '%' . $request->input('q') . '%')->orderBy('name')->get();
            }
        } else {
            $insurers = Insurer::where('isActive', (int) 1)->take(10)->orderBy('name')->get();
        }
        foreach ($insurers as $insurer) {
            $insurer->text = $insurer->name;
            $insurer->id = $insurer->_id;
        }
        $data = array(
            'total_count' => count($insurers),
            'incomplete_results' => false,
            'items' => $insurers,
        );

        return json_encode($data);
    }


    public static function removeTag($str, $remove)
    {
        while ((strpos($str, '< ') !== false) || (strpos($str, '/ ') !== false)) {
            $str = str_replace(array('< ', '/ '), array('<', '/'), $str);
        }
        foreach ((array) $remove as $tag) {
            $search_arr = array(
                '<' . strtolower($tag), '<' . strtoupper($tag),
                '</' . strtolower($tag), '</' . strtoupper($tag),
            );
            foreach ($search_arr as $search) {
                $start_pos = 0;
                while (($start_pos = strpos($str, $search, $start_pos)) !== false) {
                    $end_pos = strpos($str, '>', $start_pos);
                    $len = $end_pos - $start_pos + 1;
                    $str = substr_replace($str, '', $start_pos, $len);
                }
            }
        }

        return $str;
    }

    public static function uploadFileToCloud($file)
    {
        $extension = $file->getExtension();
        $fileName = time() . uniqid() . '.' . $extension;
        $filePath = "/" . $fileName;
        $disk = Storage::disk('s3');
        $disk->put($filePath, fopen($file, 'r+'), 'public'); //uploading as streams, useful for large uploads.
        $file_url = 'https://s3-' .
            Config::get('filesystems.disks.s3.region') . '.amazonaws.com/' .
            Config::get('filesystems.disks.s3.bucket') . '/' . $fileName;
        return $file_url;
    }

    public static function uploadFile($attachment, $path, $fileName)
    {
        if ($attachment->save(public_path() . '/' . $path, $fileName)) { //uploading
            $fileName = public_path() . '/' . $path . '/' . $fileName;
            chmod($fileName, 0777);

            return $fileName;
        } else {
            //error
            return '';
        }
    }

    public static function viewEnquiries(Request $req)
    {
        $start = $req->page;
        // dd($start);
        $filterMethod = $req->filterMethod;

        if ($start == '') {
            $start = 0;
        }
        $length = 20;
        $countMails = 0;
        $mailIdLog = [];
        $failedLog = [];
        $same = session('oldCache');
        $user = Config::get('documents.default_enquiry_user');
        $pass = Config::get('documents.default_enquiry_pass');
        $path = 'attachments';
        if (isset($req->index)) {
            $result = EnquiryCredentials::find($req->index);
            $user = $result->userID;
            $pass = $result->passWord;
            if (isset($result->autorenew)) {
                $autorenew = $result->autorenew;
            } else {
                $autorenew = '';
            }

            if (isset($result->assignEmployee)) {
                $assignedEmployee = $result->assignEmployee;
            } else {
                $assignedEmployee = '';
            }

            if ($same != $user) {
                session()->pull('enquiryFilter');
                session()->pull('ActiveSearchKey');
            }
        } else {
            $existingUser = EnquiryCredentials::where('userID', $user)->where('credentialStatus', 1)->first();
            if (isset($existingUser->assignEmployee)) {
                $assignedEmployee = $existingUser->assignEmployee;
            } else {
                $assignedEmployee = '';
            }
            if (isset($existingUser->autorenew)) {
                $autorenew = $existingUser->autorenew;
            } else {
                $autorenew = '';
            }
        }
        $statusDetails = $req->statusDetails;
        $groupDetails = $req->groupDetails;
        $nonSubStatusDetails = $req->nonSubStatusDetails;
        // dd($nonSubStatusDetails);
        $nonstatusDetails = $req->nonstatusDetails;
        $customerDetails = $req->customerDetails;
        $agentDetails = $req->agentDetails;
        $customerAgentDetails = $req->customerAgentDetails;
        $insurerDetails = $req->insurerDetails;
        $filterFromDate = $req->filterFromDate;
        $filterToDate = $req->filterToDate;
        $renewalCheck = $req->renewalCheck;
        $commentsCheckFilter = $req->commentsCheck;
        $nonrenewalCheck = $req->nonrenewalCheck;
        // dd($renewalCheck, $req);
        $order = session('enquiryFilter.order');
        // dd($statusDetails, $nonstatusDetails);
        // $arr = [];
        // $order = $req->input('order');
        // if (isset($order)) {
        //     session(['enquiryFilter.order' => $order]);
        // } else {
        //     $order = session('enquiryFilter.order');
        // }

        $stat = session('enquiryFilter.statusList');
        if ($statusDetails != "") {
            session(['enquiryFilter.statusList' => $statusDetails]);
            $stat = session('enquiryFilter.statusList');
        } elseif ($filterMethod == 'filter' && $statusDetails == "") {
            session()->pull('enquiryFilter.statusList');
            unset($stat);
        }
        $group = session('enquiryFilter.GroupList');
        $arr = [];
        if ($groupDetails != "") {
            foreach ($groupDetails as $item) {
                array_push($arr, $item);
            }
            session(['enquiryFilter.GroupList' => $arr]);
            $group = session('enquiryFilter.GroupList');
        } elseif ($filterMethod == 'filter' && $groupDetails == "") {
            session()->pull('enquiryFilter.GroupList');
            unset($group);
        }
        $nonstat = session('enquiryFilter.nonstatusList');
        if ($nonstatusDetails != "") {
            session(['enquiryFilter.nonstatusList' => $nonstatusDetails]);
            $nonstat = session('enquiryFilter.nonstatusList');
        } elseif ($filterMethod == 'filter' && $nonstatusDetails == "") {
            session()->pull('enquiryFilter.nonstatusList');
            unset($nonstat);
        }
        $arr = [];
        $cust = session('enquiryFilter.customerList');
        if ($customerDetails != "") {
            foreach ($customerDetails as $item) {
                array_push($arr, new ObjectId($item));
            }
            session(['enquiryFilter.customerList' => $arr]);
            $cust = session('enquiryFilter.customerList');
        } elseif ($filterMethod == 'filter' && $customerDetails == "") {
            session()->pull('enquiryFilter.customerList');
            unset($cust);
        }
        $arr = [];
        $custAgent = session('enquiryFilter.customerAgentList');
        if ($customerAgentDetails != "") {
            foreach ($customerAgentDetails as $item) {
                array_push($arr, $item);
            }
            session(['enquiryFilter.customerAgentList' => $arr]);
            $custAgent = session('enquiryFilter.customerAgentList');
        } elseif ($filterMethod == 'filter' && $customerAgentDetails == "") {
            session()->pull('enquiryFilter.customerAgentList');
            unset($custAgent);
        }
        $insurer = session('enquiryFilter.insurerList');
        $arr = [];
        if ($insurerDetails != "") {
            foreach ($insurerDetails as $item) {
                array_push($arr, $item);
            }
            session(['enquiryFilter.insurerList' => $arr]);
            $insurer = session('enquiryFilter.insurerList');
        } elseif ($filterMethod == 'filter' && $insurerDetails == "") {
            session()->pull('enquiryFilter.insurerList');
            unset($insurer);
        }
        $agen = session('enquiryFilter.agentList');
        $arr = [];
        if ($agentDetails != "") {
            foreach ($agentDetails as $item) {
                if ($item != "999") {
                    array_push($arr, new ObjectId($item));
                } else {
                    array_push($arr, $item);
                }
            }
            session(['enquiryFilter.agentList' => $arr]);
            $agen = session('enquiryFilter.agentList');
        } elseif ($filterMethod == 'filter' && $agentDetails == "") {
            session()->pull('enquiryFilter.agentList');
            unset($agen);
        }
        if (isset($nonstat) && isset($stat) && $nonstat != '' && $stat != '') {
            $statArray = array_merge($stat, $nonstat);
        }
        $fromDateFilter = session('enquiryFilter.fromDateFilter');
        if ($filterFromDate != "") {
            session(['enquiryFilter.fromDateFilter' => $filterFromDate]);
            $fromDateFilter = session('enquiryFilter.fromDateFilter');
        } elseif ($filterMethod == 'filter' && $filterFromDate == "") {
            session()->pull('enquiryFilter.fromDateFilter');
            unset($fromDateFilter);
        }
        $toDateFilter = session('enquiryFilter.toDateFilter');
        if ($filterToDate != "") {
            session(['enquiryFilter.toDateFilter' => $filterToDate]);
            $toDateFilter = session('enquiryFilter.toDateFilter');
        } elseif ($filterMethod == 'filter' && $filterToDate == "") {
            session()->pull('enquiryFilter.toDateFilter');
            unset($toDateFilter);
        }
        $renewalFilter = session('enquiryFilter.renewalFilter');
        if ($renewalCheck != "") {
            // dump("TEst1");
            session(['enquiryFilter.renewalFilter' => $renewalCheck]);
            $renewalFilter = session('enquiryFilter.renewalFilter');
        } elseif ($filterMethod == 'filter' && $renewalCheck == "") {
            session()->pull('enquiryFilter.renewalFilter');
            unset($renewalFilter);
        }
        $nonrenewalFilter = session('enquiryFilter.nonrenewalFilter');
        if ($nonrenewalCheck != "") {
            session(['enquiryFilter.nonrenewalFilter' => $nonrenewalCheck]);
            $nonrenewalFilter = session('enquiryFilter.nonrenewalFilter');
        } elseif ($filterMethod == 'filter' && $nonrenewalCheck == "") {
            session()->pull('enquiryFilter.nonrenewalFilter');
            unset($nonrenewalFilter);
        }
        $commentsCheck = session('enquiryFilter.commentsCheck');
        if ($commentsCheckFilter != "") {
            // dd("test2");
            session(['enquiryFilter.commentsCheck' => $commentsCheckFilter]);
            $commentsCheck = session('enquiryFilter.commentsCheck');
        } elseif ($filterMethod == 'filter' && $commentsCheckFilter == "") {
            session()->pull('enquiryFilter.commentsCheck');
            unset($commentsCheck);
        }

        $data = Enquiries::where('mailStatus', 1)->where('documentMailBox', $user)->where('deleted', '!=', 1);


        $latestComment = session('enquiryFilter.commentsCheck');
        if ($latestComment) {
            $data = $data->where('comments', 'exists', true)
                ->where('commentSeen', '!=', new ObjectId(Auth::user()->_id));
        }


        if (isset($nonstat) && isset($stat) && $nonstat != '' && $stat != '') {
            $statArray = array_merge($stat, $nonstat);
            if (isset($statArray)) {
                $data->where(function ($query) use ($statArray) {
                    foreach ($statArray as $status) {
                        if (count(@$status['subStatus']) > 0) {
                            $subStatus = $status['subStatus'];
                            $Status = $status['status'];
                            $query->orwhere(function ($query2) use ($subStatus, $Status) {
                                $query2->where('assaignedTo.assaignStatusName', $Status);
                                $query2->where(function ($query3) use ($subStatus, $Status) {
                                    foreach ($subStatus as $eachstatus) {
                                        $query3->orWhere('assaignedTo.assaignSubStatusName', $eachstatus);
                                    }
                                });
                            });
                        } else {
                            $query->orWhere('assaignedTo.assaignStatusName', $status['status']);
                        }
                    }
                });
            }
        } else {
            if (isset($nonstat)) {
                $data->where(function ($query) use ($nonstat) {
                    foreach ($nonstat as $status) {
                        if (count(@$status['subStatus']) > 0) {
                            $subStatus = $status['subStatus'];
                            $Status = $status['status'];
                            $query->orwhere(function ($query2) use ($subStatus, $Status) {
                                $query2->where('assaignedTo.assaignStatusName', $Status);
                                $query2->where(function ($query3) use ($subStatus, $Status) {
                                    foreach ($subStatus as $eachstatus) {
                                        $query3->orWhere('assaignedTo.assaignSubStatusName', $eachstatus);
                                    }
                                });
                            });
                        } else {
                            $query->orWhere('assaignedTo.assaignStatusName', $status['status']);
                        }
                    }
                });
            }
            if (isset($stat)) {
                $data->where(function ($query) use ($stat) {
                    foreach ($stat as $status) {
                        if (count(@$status['subStatus']) > 0) {
                            $subStatus = $status['subStatus'];
                            $Status = $status['status'];
                            $query->orwhere(function ($query2) use ($subStatus, $Status) {
                                $query2->where('assaignedTo.assaignStatusName', $Status);
                                $query2->where(function ($query3) use ($subStatus, $Status) {
                                    foreach ($subStatus as $eachstatus) {
                                        $query3->orWhere('assaignedTo.assaignSubStatusName', $eachstatus);
                                    }
                                });
                            });
                        } else {
                            $query->orWhere('assaignedTo.assaignStatusName', $status['status']);
                        }
                    }
                });
            }
        }

        // if (isset($nonstat) && isset($stat) && $nonstat != '' && $stat != '') {
        //     $data->whereIn('assaignedTo.assaignStatusName', $statArray);
        // }
        if (isset($cust)) {
            $data->whereIn('assaignedTo.customerId', $cust);
            $customers = Customer::whereIn('_id', $cust)->orderBy('fullName')->get();
        } else {
            $customers = '';
        }
        if (isset($custAgent)) {
            $data->whereIn('assaignedTo.customerAgentId', $custAgent);
        }
        if (isset($group)) {
            $data->whereIn('assaignedTo.groupName', $group);
        }
        if (isset($agen)) {
            $data->whereIn('assaignedTo.agentId', $agen);
        }
        if (isset($fromDateFilter)) {
            $fDate = Carbon::createFromFormat('!d/m/Y', $fromDateFilter);
            $data->where('mailRecTme', '>=', $fDate);
        }
        if (isset($toDateFilter)) {
            $TDate = Carbon::createFromFormat('!d/m/Y', $toDateFilter);
            $todate = $TDate->endOfDay();
            $data->where('mailRecTme', '<=', $todate);
        }
        if (isset($renewalFilter) && !isset($nonrenewalFilter)) {
            $data->where('renewal', 1);
        }
        if (isset($nonrenewalFilter) && !isset($renewalFilter)) {
            $data->where('renewal', '!=', 1);
        }
        if (isset($nonrenewalFilter) && isset($renewalFilter)) {
            $data;
        }

        //  elseif (isset($agen) && session('role')=='Employee') {
        //     $data->where('assaignedTo.agentId', new ObjectId(Auth::user()->_id));
        // } elseif (session('role')=='Agent') {
        //     $data= $data->where('assaignedTo.customerAgentId', Auth::user()->_id);
        // } elseif (session('role')=='Coordinator') {
        //     $coAgent=(string)session('assigned_agent');
        //     $data=$data->where('assaignedTo.customerAgentId', $coAgent);
        // }
        if (isset($insurer)) {
            $data->whereIn('assaignedTo.insurerId', $insurer);
            $insurers = Insurer::whereIn('_id', $insurer)->orderBy('name')->get();
        } else {
            $insurers = '';
        }
        $key = session('ActiveSearchKey');
        if ($req->search2 != "") {
            session(['ActiveSearchKey' => $req->search2]);
            $key = $req->search2;
        } elseif ($req->search2 == '' && $filterMethod == 'search') {
            session()->pull('ActiveSearchKey');
            unset($key);
        }
        if (isset($key)) {
            $data = $data->where(function ($query) use ($key) {
                $query->where('subject', 'like', '%' . $key . '%')
                    ->orWhere('assaignedTo.customerName', 'like', '%' . $key . '%')
                    ->orWhere('assaignedTo.insurerName', 'like', '%' . $key . '%')
                    ->orWhere('mailsText', 'like', '%' . $key . '%')
                    ->orWhere('attachements.attachName', 'like', '%' . $key . '%');
            });
        }
        if (isset($order) && $order == 'latest') {
            $data = $data->orderBy('created_at', 'desc');
        } else if (isset($order) && $order == 'earliest') {
            $data = $data->orderBy('created_at', 'asc');
        } else {
            $data = $data->orderBy('created_at', 'desc');
        }
        if (session('role') == 'Admin') {
            if ($req->ajax() == false) {
                $log = new CronJobLog();
                $log->controller = "not completed";
                $log->function = 'not completed';
                $log->time = date('d-m-Y h:i:s a');
                $log->save();

                $newId = $log->id;
                $log = CronJobLog::find($newId);
                $mailsFetched = 0;

                $notification = new Client([
                    'host' => 'exmail.emirates.net.ae',
                    'port' => 143,
                    'encryption' => 'tls',
                    'validate_cert' => false,
                    'username' => $user,
                    'password' => $pass,
                    'protocol' => 'imap'
                ]);

                try {
                    $notification->connect(1);
                } catch (\Webklex\IMAP\Exceptions\ConnectionFailedException $e) {
                    $msg = $e->getMessage();
                    $failedLogObj = new \stdClass();
                    $failedLogObj->mailBox = $user;
                    $failedLogObj->desc = $msg;
                    $failedLog[] = $failedLogObj;
                    $log->controller = 'EnquiryManagementController';
                    $log->function = 'viewEnquiries';
                    $log->failedLog = $failedLog;
                    $log->failed = 1;
                    $log->save();
                    Session::flash('status', 'We could not connect to the email server, please check the settings.');
                    return redirect('enquiry/view-enquiries');
                }

                $inbox = $notification->getFolders()->first();
                $messages = $inbox->query()->unseen()->markAsRead()->get();

                foreach ($messages as $message) {
                    $message->unsetFlag(["flagged", "seen"]);
                    $messageId = $message->getMessageId();
                    $cc = $message->getCc() ?: "";
                    $mails = new Enquiries();
                    $date = $message->getDate();                                      //receive time
                    $date = $date->timezone('asia/dubai');
                    $time = $date->format('l jS \\of F Y h:i:s A');
                    $subject = $message->getSubject();                                //subject
                    $logSubject = $subject;
                    $from = $message->getFrom();                                      //from address
                    $mailContent = $message->getHtmlBody();
                    $mailText = $message->getTextBody();  //text body of mail
                    //html body
                    if ($mailContent == "<div dir=\"ltr\"><br></div>\r\n") {
                        $mailContent = "<div dir=\"ltr\"><h3> blank mail</h3></div>\r\n";
                    }
                    $mailContent = EnquiryManagementController::removeTag($mailContent, 'img');
                    $formatTime = Carbon::createFromFormat('l jS \\of F Y h:i:s A', $time);
                    $time1 = $formatTime->format('Y-m-d');
                    $Sdate_format = Carbon::createFromFormat('Y-m-d', $time1, 'asia/dubai')->timestamp;
                    $StartTime = new \MongoDB\BSON\UTCDateTime($Sdate_format * 1000);
                    $mails->mailRecTme = $StartTime;
                    $from = $from[0]->mail;
                    $from = trim($from);
                    $agentData = User::where('isActive', 1)->where('role', 'AG')
                        ->where('email', $from)->first();
                    $mails->messageId = $messageId;
                    $mails->subject = $subject;
                    $mails->documentMailBox = $user;
                    $mails->from = $from;
                    $mails->recieveDateObject = $date;
                    $mails->cc = $cc;
                    $mails->recieveTime = $time;
                    $mails->mailsContent = $mailContent;
                    $mails->renewal = 0;
                    $mails->mailsText = $mailText;
                    $newFileName = '';
                    $attachmentCount = 0;
                    $attachArray = [];
                    if ($message->hasAttachments()) {                                  //checking if attachments exists
                        $attachments = $message->getAttachments();                    //getting attachments
                        $attachmentCount = count($attachments);
                        foreach ($attachments as $attachment) {                        //looping attachments
                            $attachmentCount = count($attachments);
                            $fileName = $attachment->getName();                       //getting attachment file name
                            if (file_exists($path . '/' . $fileName)) {               //if file alreading exists
                                $baseName = pathinfo($fileName, PATHINFO_FILENAME);
                                $extension = pathinfo($fileName, PATHINFO_EXTENSION);
                                for ($i = 1;; ++$i) {
                                    $fileName = $baseName . '(' . $i . ').' . $extension;
                                    if (!file_exists($path . '/' . $fileName)) {             //if file alreading exists
                                        $newFileName = EnquiryManagementController::uploadFile(
                                            $attachment,
                                            $path,
                                            $fileName
                                        );
                                        break;
                                    }
                                }
                            } else {
                                $newFileName = EnquiryManagementController::uploadFile($attachment, $path, $fileName);
                            }
                            $uploadedFile = new LocalFile($newFileName);
                            $urlPath = EnquiryManagementController::uploadFileToCloud($uploadedFile);
                            unlink($newFileName);
                            if ($newFileName != '') {
                                date_default_timezone_set('Asia/Dubai');
                                $mails->isAttach = 1;
                                $attachObj = new \stdClass();
                                $attachObj->attachId = (string) time() . uniqid();
                                $attachObj->attachPath = $urlPath;
                                $attachObj->attachName = $fileName;
                                $attachObj->attachStatus = 1;
                                $attachObj->lastUpdate = date('d-m-y h:i:s a');
                                $attachArray[] = $attachObj;
                            }
                        }
                        $mails->attachements = $attachArray;
                    } else {
                        $mails->isAttach = 0;
                    }
                    $mails->mailStatus = 1;
                    if ($mails->save()) {
                        $message->setFlag(["flagged", "seen"]);
                    } else {
                        $message->unsetFlag(["flagged", "seen"]);
                    }
                    EnquiryManagementController::saveLog('New document arrived.', 'Enquiry Management', $mails->_id, $subject, $mails->documentMailBox); //save log
                    $id = null;
                    $customerAgentId = null;
                    $customerAgentName = null;
                    $agent = null;
                    $renewal = null;
                    $request = new Request();
                    $ret = 0;
                    $docCount = count($attachArray);

                    // $mail_subj_format='Vehicle Insurance Renewal Notification * ';
                    // $length_sub=(strlen($mail_subj_format));
                    $extractedSubject = explode('*', $subject);

                    $customerId = @$extractedSubject[1];
                    $renewaldateInitial = @$extractedSubject[2];
                    if ($renewaldateInitial) {
                        $dateArray = explode('/', $renewaldateInitial);
                        $day = @$dateArray[0];
                        $month = @$dateArray[1];
                        $year = @$dateArray[2];
                        $validdate = false;
                        if ($day && $month && $year) {
                            try {
                                $validdate = checkdate($month, $day, $year);
                            } catch (\Exception $e) {
                                $validdate = false;
                            }
                            if ($validdate) {
                                $renewalDate = $renewaldateInitial;
                                $expiryDate = $renewaldateInitial;
                            } else {
                                $renewalDate = '';
                                $expiryDate = '';
                            }
                        } else {
                            $renewalDate = '';
                            $expiryDate = '';
                        }
                    } else {
                        $renewalDate = '';
                        $expiryDate = '';
                    }


                    $customerId = trim($customerId);
                    // $accurate_topic=substr($subject, 0, $length_sub);
                    // $exploded_array=explode('*', $subject);
                    if (isset($agentData) && $agentData->count() != 0) {
                        $customerAgentId = (string) $agentData->_id;
                        $customerAgentName = $agentData->name;
                        $ret = 1;
                    }
                    if ($customerId) {
                        // $customer_id=trim($exploded_array[1]);
                        $customer = Customer::where(
                            'customerCode',
                            'like',
                            $customerId
                        )
                            ->where('status', (int) 1)->first();
                        if (isset($customer)) {
                            $id = $customer->_id ?: null;
                            if ($customerAgentId == null) {
                                $customerAgentId = (string) $customer['agent']['id'] ?: null;
                                $customerAgentName = $customer['agent']['name'] ?: null;
                            }
                        } else {
                            $id = null;
                            // $customerAgentId = null;
                            // $customerAgentName = null;
                        }
                        $ret = 1;
                    }
                    /////////////////new modification/////////////
                    if ($autorenew == 1) {
                        $renewal = (int) 1;
                        $ret = 1;
                    }
                    if ($assignedEmployee != '') {
                        $agent = $assignedEmployee;
                        $ret = 1;
                    }
                    ////////////////ends///////////////////////
                    if ($ret == 1) {
                        $request->replace(
                            [
                                'customer' => $id,
                                'customerAgentId' => $customerAgentId,
                                'customerAgentName' => $customerAgentName,
                                'agent' => $agent,
                                'renewal' => $renewal,
                                'mailId' => $mails->_id,
                                'updateAttachName' => null,
                                'renewal_date' => $renewalDate
                            ]
                        );
                        $val = EnquiryManagementController::asignDocument($request);
                    }
                    $logObj = new \stdClass();
                    $logObj->mailBox = $user;
                    $logObj->inboxMailId = $messageId;
                    $logObj->insertedId = $mails->id;
                    $logObj->subject = $logSubject;
                    $logObj->attachmentsCount = $attachmentCount;
                    $logObj->attachDifference = ($attachmentCount - $docCount);
                    $mailIdLog[] = $logObj;
                }
                $notification->disconnect();
                $log->controller = 'EnquiryManagementController';
                $log->function = 'viewEnquiries';
                $log->successLog = $mailIdLog;
                $log->mailsFetched = $mailsFetched;
                $log->failed = 0;
                $log->save();
            }
            // if (isset($key)) {
            //     $data=$data->where(function ($query) use ($key) {
            //         $query->where('subject', 'like', '%'.$key.'%')
            //                 ->orWhere('assaignedTo.customerName', 'like', '%'.$key.'%')
            //                 ->orWhere('assaignedTo.insurerName', 'like', '%'.$key.'%')
            //                 ->orWhere('mailsText', 'like', '%'.$key.'%')
            //                 ->orWhere('attachements.attachName', 'like', '%'.$key.'%');
            //     });
            // }

            $countMails = $data->count();
            // dd($data->toSql());
            $data = $data->skip((int) $start)->take((int) $length)
                ->get();
        } elseif (session('role') == 'Employee') {
            $data = $data->whereIn('assaignedTo.agentId', ["999", new ObjectId(Auth::user()->_id)]);
            $countMails = $data->count();
            $data = $data->skip((int) $start)->take((int) $length)
                ->get();
        } elseif (session('role') == 'Coordinator') {
            $coAgent = (string) session('assigned_agent');
            $data = $data->where('assaignedTo.customerAgentId', $coAgent);
            $countMails = $data->count();
            $data = $data->skip((int) $start)->take((int) $length)
                ->get();
        } elseif (session('role') == 'Agent') {
            $data = $data->where('assaignedTo.customerAgentId', Auth::user()->_id);
            $countMails = $data->count();
            $data = $data->skip((int) $start)->take((int) $length)
                ->get();
        } elseif (session('role') == 'Supervisor') {
            $employees = session('employees') ?: [];
            $employees = array_merge($employees, ["999", "", new ObjectId(Auth::user()->_id), null]);
            $data = $data->whereIn('assaignedTo.agentId', $employees);
            $countMails = $data->count();
            $data = $data->skip((int) $start)->take((int) $length)
                ->get();
        } else {
            $data = [];
        }
        // dd($data);
        session(['oldCache' => $user]);
        $mailBoxes = EnquiryCredentials::where('credentialStatus', 1)->get();
        if (!$mailBoxes) {
            return redirect('/logout');
        }
        $agents = User::where('isActive', 1)->where('role', 'AG')->orderBy('name')->get();
        if ($req->ajax()) {
            $documentOperation = view(
                'enquiry_management.enquiry_search',
                [
                    'data' => $data,
                    'mailBoxes' => $mailBoxes,
                    'user' => $user, 'agents' => $agents,
                    'countMails' => $countMails,
                    'customers' => $customers,
                    'insurers' => $insurers,
                    'countMails' => $countMails
                ]
            )->render();
            return response()->json([
                'status' => 'success', 'documentOperation' => $documentOperation,
                'countMails' => $countMails, 'agents' => $agents
            ]);
        }
        return view('enquiry_management.enquiry_management')
            ->with(compact('data', 'mailBoxes', 'user', 'customers', 'insurers', 'countMails', 'agents'));
    }

    public function closedDocuments(Request $request)
    {
        $start = $request->page;
        $filterMethod = $request->filterMethod;
        if ($start == '') {
            $start = 0;
        }
        $length = 20;
        $countMails = 0;
        $old = session('closedOldCache');
        $box = $request->box;
        $result = EnquiryCredentials::find(new ObjectId($box));
        $user = $result->userID;
        if ($old != $user) {
            session()->pull('closedEnquiryFilter');
            session()->pull('ClosedSearchKey');
        }
        $data = Enquiries::where('mailStatus', 0)->where('documentMailBox', $user)->where('deleted', '!=', 1);
        $statusDetails = $request->statusDetails;
        $nonstatusDetails = $request->nonstatusDetails;
        $customerDetails = $request->customerDetails;
        $agentDetails = $request->agentDetails;
        $customerAgentDetails = $request->customerAgentDetails;
        $insurerDetails = $request->insurerDetails;
        $filterFromDate = $request->filterFromDate;
        $filterToDate = $request->filterToDate;
        $renewalCheck = $request->renewalCheck;
        $nonrenewalCheck = $request->nonrenewalCheck;
        $groupDetails = $request->groupDetails;
        $stat = session('closedEnquiryFilter.statusList');
        // $arr = [];
        if ($statusDetails != "") {
            // foreach ($statusDetails as $item) {
            //     array_push($arr, $item);
            // }
            session(['closedEnquiryFilter.statusList' => $statusDetails]);
            $stat = session('closedEnquiryFilter.statusList');
        } elseif ($filterMethod == 'filter' && $statusDetails == "") {
            session()->pull('closedEnquiryFilter.statusList');
            unset($stat);
        }
        $group = session('closedEnquiryFilter.GroupList');
        $arr = [];
        if ($groupDetails != "") {
            foreach ($groupDetails as $item) {
                array_push($arr, $item);
            }
            session(['closedEnquiryFilter.GroupList' => $arr]);
            $group = session('closedEnquiryFilter.GroupList');
        } elseif ($filterMethod == 'filter' && $groupDetails == "") {
            session()->pull('closedEnquiryFilter.GroupList');
            unset($group);
        }
        $nonstat = session('closedEnquiryFilter.nonstatusList');
        // $arr = [];
        if ($nonstatusDetails != "") {
            // foreach ($nonstatusDetails as $item) {
            //     array_push($arr, $item);
            // }
            session(['closedEnquiryFilter.nonstatusList' => $nonstatusDetails]);
            $nonstat = session('closedEnquiryFilter.nonstatusList');
        } elseif ($filterMethod == 'filter' && $nonstatusDetails == "") {
            session()->pull('closedEnquiryFilter.nonstatusList');
            unset($nonstat);
        }
        $arr = [];
        $cust = session('closedEnquiryFilter.customerList');
        if ($customerDetails != "") {
            foreach ($customerDetails as $item) {
                array_push($arr, new ObjectId($item));
            }
            session(['closedEnquiryFilter.customerList' => $arr]);
            $cust = session('closedEnquiryFilter.customerList');
        } elseif ($filterMethod == 'filter' && $customerDetails == "") {
            session()->pull('closedEnquiryFilter.customerList');
            unset($cust);
        }
        $arr = [];
        $custAgent = session('closedEnquiryFilter.customerAgentList');
        if ($customerAgentDetails != "") {
            foreach ($customerAgentDetails as $item) {
                array_push($arr, $item);
            }
            session(['closedEnquiryFilter.customerAgentList' => $arr]);
            $custAgent = session('closedEnquiryFilter.customerAgentList');
        } elseif ($filterMethod == 'filter' && $customerAgentDetails == "") {
            session()->pull('closedEnquiryFilter.customerAgentList');
            unset($custAgent);
        }
        $insurer = session('closedEnquiryFilter.insurerList');
        $arr = [];
        if ($insurerDetails != "") {
            foreach ($insurerDetails as $item) {
                array_push($arr, $item);
            }
            session(['closedEnquiryFilter.insurerList' => $arr]);
            $insurer = session('closedEnquiryFilter.insurerList');
        } elseif ($filterMethod == 'filter' && $insurerDetails == "") {
            session()->pull('closedEnquiryFilter.insurerList');
            unset($insurer);
        }
        $agen = session('closedEnquiryFilter.agentList');
        $arr = [];
        if ($agentDetails != "") {
            foreach ($agentDetails as $item) {
                array_push($arr, new ObjectId($item));
            }
            session(['closedEnquiryFilter.agentList' => $arr]);
            $agen = session('closedEnquiryFilter.agentList');
        } elseif ($filterMethod == 'filter' && $agentDetails == "") {
            session()->pull('closedEnquiryFilter.agentList');
            unset($agen);
        }
        $fromDateFilter = session('closedEnquiryFilter.fromDateFilter');
        if ($filterFromDate != "") {
            session(['closedEnquiryFilter.fromDateFilter' => $filterFromDate]);
            $fromDateFilter = session('closedEnquiryFilter.fromDateFilter');
        } elseif ($filterMethod == 'filter' && $filterFromDate == "") {
            session()->pull('closedEnquiryFilter.fromDateFilter');
            unset($fromDateFilter);
        }
        $toDateFilter = session('closedEnquiryFilter.toDateFilter');
        if ($filterToDate != "") {
            session(['closedEnquiryFilter.toDateFilter' => $filterToDate]);
            $toDateFilter = session('closedEnquiryFilter.toDateFilter');
        } elseif ($filterMethod == 'filter' && $filterToDate == "") {
            session()->pull('closedEnquiryFilter.toDateFilter');
            unset($toDateFilter);
        }
        $renewalFilter = session('closedEnquiryFilter.renewalFilter');
        if ($renewalCheck != "") {
            session(['closedEnquiryFilter.renewalFilter' => $renewalCheck]);
            $renewalFilter = session('closedEnquiryFilter.renewalFilter');
        } elseif ($filterMethod == 'filter' && $renewalCheck == "") {
            session()->pull('closedEnquiryFilter.renewalFilter');
            unset($renewalFilter);
        }
        $nonrenewalFilter = session('closedEnquiryFilter.nonrenewalFilter');
        if ($nonrenewalCheck != "") {
            session(['closedEnquiryFilter.nonrenewalFilter' => $nonrenewalCheck]);
            $nonrenewalFilter = session('closedEnquiryFilter.nonrenewalFilter');
        } elseif ($filterMethod == 'filter' && $nonrenewalCheck == "") {
            session()->pull('closedEnquiryFilter.nonrenewalFilter');
            unset($nonrenewalFilter);
        }

        if (isset($nonstat) && isset($stat) && $nonstat != '' && $stat != '') {
            $statArray = array_merge($stat, $nonstat);
            if (isset($statArray)) {
                $data->where(function ($query) use ($statArray) {
                    foreach ($statArray as $status) {
                        if (count(@$status['subStatus']) > 0) {
                            $subStatus = $status['subStatus'];
                            $Status = $status['status'];
                            $query->orwhere(function ($query2) use ($subStatus, $Status) {
                                $query2->where('assaignedTo.assaignStatusName', $Status);
                                $query2->where(function ($query3) use ($subStatus, $Status) {
                                    foreach ($subStatus as $eachstatus) {
                                        $query3->orWhere('assaignedTo.assaignSubStatusName', $eachstatus);
                                    }
                                });
                            });
                        } else {
                            $query->orWhere('assaignedTo.assaignStatusName', $status['status']);
                        }
                    }
                });
            }
        } else {
            if (isset($nonstat)) {
                $data->where(function ($query) use ($nonstat) {
                    foreach ($nonstat as $status) {
                        if (count(@$status['subStatus']) > 0) {
                            $subStatus = $status['subStatus'];
                            $Status = $status['status'];
                            $query->orwhere(function ($query2) use ($subStatus, $Status) {
                                $query2->where('assaignedTo.assaignStatusName', $Status);
                                $query2->where(function ($query3) use ($subStatus, $Status) {
                                    foreach ($subStatus as $eachstatus) {
                                        $query3->orWhere('assaignedTo.assaignSubStatusName', $eachstatus);
                                    }
                                });
                            });
                        } else {
                            $query->orWhere('assaignedTo.assaignStatusName', $status['status']);
                        }
                    }
                });
            }
            if (isset($stat)) {
                $data->where(function ($query) use ($stat) {
                    foreach ($stat as $status) {
                        if (count(@$status['subStatus']) > 0) {
                            $subStatus = $status['subStatus'];
                            $Status = $status['status'];
                            $query->orwhere(function ($query2) use ($subStatus, $Status) {
                                $query2->where('assaignedTo.assaignStatusName', $Status);
                                $query2->where(function ($query3) use ($subStatus, $Status) {
                                    foreach ($subStatus as $eachstatus) {
                                        $query3->orWhere('assaignedTo.assaignSubStatusName', $eachstatus);
                                    }
                                });
                            });
                        } else {
                            $query->orWhere('assaignedTo.assaignStatusName', $status['status']);
                        }
                    }
                });
            }
        }

        // if (isset($nonstat) && isset($stat) && $nonstat != '' && $stat != '') {
        //     $statArray = array_merge($stat, $nonstat);
        // }

        // if (isset($stat) && !isset($nonstat)) {
        //     $data->whereIn('assaignedTo.assaignStatusName', $stat)->where('renewal', 1);
        // }
        // if (isset($nonstat) && !isset($stat)) {
        //     $data->whereIn('assaignedTo.assaignStatusName', $nonstat)->where('renewal', 0);
        // }
        // if (isset($nonstat) && isset($stat) && $nonstat != '' && $stat != '') {
        //     $data->whereIn('assaignedTo.assaignStatusName', $statArray);
        // }
        if (isset($group)) {
            $data->whereIn('assaignedTo.groupName', $group);
        }
        $arr = [];
        if (isset($cust)) {
            $data->whereIn('assaignedTo.customerId', $cust);
            $customers = Customer::whereIn('_id', $cust)->get();
        } else {
            $customers = '';
        }
        $arr = [];
        if (isset($custAgent)) {
            $data->whereIn('assaignedTo.customerAgentId', $custAgent);
        }
        $arr = [];
        if (isset($agen)) {
            $data->whereIn('assaignedTo.agentId', $agen);
        }
        if (isset($fromDateFilter)) {
            $fDate = Carbon::createFromFormat('!d/m/Y', $fromDateFilter);
            $data->where('mailRecTme', '>=', $fDate);
        }
        if (isset($toDateFilter)) {
            $TDate = Carbon::createFromFormat('!d/m/Y', $toDateFilter);
            $todate = $TDate->endOfDay();
            $data->where('mailRecTme', '<=', $todate);
        }
        if (isset($renewalFilter) && !isset($nonrenewalFilter)) {
            $data->where('renewal', 1);
        }
        if (isset($nonrenewalFilter) && !isset($renewalFilter)) {
            $data->where('renewal', '!=', 1);
        }
        if (isset($nonrenewalFilter) && isset($renewalFilter)) {
            $data;
        }
        if (isset($commentsCheck) && isset($commentsCheck)) {
            $data->where('comments', 'exists', true)
                ->where('commentSeen', '!=', new ObjectId(Auth::user()->_id));
        }
        // if (isset($agen) && session('role')=='Admin') {
        //     $data->whereIn('assaignedTo.agentId', $agen);
        // } elseif (isset($agen) && session('role')=='Employee') {
        //     $data->where('assaignedTo.agentId', new ObjectId(Auth::user()->_id));

        // }
        $arr = [];
        if (isset($insurer)) {
            $data->whereIn('assaignedTo.insurerId', $insurer);
            $insurers = Insurer::whereIn('_id', $insurer)->get();
        } else {
            $insurers = '';
        }
        $searchKey = session('ClosedSearchKey');
        if ($request->search2 != "") {
            session(['ClosedSearchKey' => $request->search2]);
            $searchKey = $request->search2;
        } elseif ($request->search2 == '' && $filterMethod == 'search') {
            session()->pull('ClosedSearchKey');
            unset($searchKey);
        }
        if (isset($searchKey)) {
            $data = $data->where(function ($query) use ($searchKey) {
                $query->where('subject', 'like', '%' . $searchKey . '%')
                    ->orWhere('assaignedTo.customerName', 'like', '%' . $searchKey . '%')
                    ->orWhere('assaignedTo.insurerName', 'like', '%' . $searchKey . '%')
                    ->orWhere('mailsText', 'like', '%' . $searchKey . '%')
                    ->orWhere('attachements.attachName', 'like', '%' . $searchKey . '%');
            });
        }
        if (session('role') == 'Agent') {
            $data = $data->where('assaignedTo.customerAgentId', Auth::user()->_id);
        } elseif (session('role') == 'Coordinator') {
            $coAgent = (string) session('assigned_agent');
            $data = $data->where('assaignedTo.customerAgentId', $coAgent);
        }
        session(['closedOldCache' => $user]);
        $countMails = $data->count();
        $data = $data->orderBy('created_at', 'desc')->skip((int) $start)->take((int) $length)
            ->get();
        $mailBoxes = EnquiryCredentials::where('credentialStatus', 1)->get();
        if (!$mailBoxes) {
            return redirect('/logout');
        }
        if ($request->ajax()) {
            $documentOperation = view(
                'enquiry_management.closed_enquiry_search',
                [
                    'data' => $data,
                    'mailBoxes' => $mailBoxes,
                    'user' => $user,
                    'countMails' => $countMails,
                    'customers' => $customers,
                    'insurers' => $insurers,
                    'countMails' => $countMails
                ]
            )->render();
            return response()->json([
                'status' => 'success', 'documentOperation' => $documentOperation,
                'countMails' => $countMails
            ]);
        }
        return view('enquiry_management.closed_enquiry')
            ->with(compact('data', 'mailBoxes', 'user', 'customers', 'insurers', 'countMails'));
    }


    // action of save & saveAndSubmit

    public static function asignDocument(Request $request)
    {
        //dd($request);
        $existingData = Enquiries::find($request->mailId);
        $discription = '';
        $updateStatus = 0;
        $assign = 0;
        $type = $request->input('type');
        if (isset($request->insurerName)) {
            $assign = 1;
            $insurerName = $request->insurerName;
        } else {
            $insurerName = "";
        }
        if (isset($existingData->assaignedTo['insurerName']) && $existingData->assaignedTo['insurerName'] != $insurerName && $insurerName != '') {
            $discription .= 'Insurer name changed to ' . $insurerName . '.';
        } elseif (!isset($existingData->assaignedTo['insurerName']) && $insurerName != '') {
            $discription .= 'Insurer name changed to ' . $insurerName . '.';
        }
        if (isset($request->insurerId)) {
            $assign = 1;
            $insurerId = $request->insurerId;
        } else {
            $insurerId = "";
        }
        if (isset($request->renewal)) {
            $assign = 1;
            $renewal = $request->renewal;
        } else {
            $renewal = "";
        }
        if (isset($existingData->renewal) && $existingData->renewal != $renewal  && $renewal == 1) {
            $discription .= 'Marked as renewed.';
        } elseif (isset($existingData->renewal) && $existingData->renewal != $renewal  && $renewal == 0) {
            $discription .= "'Marked as new'";
        } elseif (!isset($existingData->renewal)  && $renewal == 0) {
            $discription .= 'Marked as renewed.';
        } elseif (!isset($existingData->renewal) && $renewal == 1) {
            $discription .= "'Mark as new'";
        }

        if (isset($request->commissionPercentage) && $request->commissionPercentage) {
            $commissionPercentage = (float) $request->commissionPercentage;
            // $commissionAmount = $request->commissionAmount;
            $policyArray = explode(",", $request->policy);
            $policyValue = (int) join("", $policyArray);
            if ($commissionPercentage <= 100) {

                if (isset($existingData->commissionPercentage)) {
                    if ($existingData->commissionPercentage != $commissionPercentage) {
                        $discription .= "'changed commission percentage'";
                    }
                } else {
                    $discription .= "'added commission percentage'";
                }

                $finalCommission = $commissionPercentage;
                $commissionAmount = number_format(($policyValue * $commissionPercentage / 100), 2, '.', '');
            } else {
                $finalCommission = 0;
                $commissionAmount = 0;
            }
        } else {
            $finalCommission = 0;
            $commissionAmount = 0;
        }


        if (isset($request->date1)) {
            $assign = 1;
            $date1 = $request->date1;
        } else {
            $date1 = "";
        }
        if (isset($existingData->dates['date1']) && $existingData->dates['date1'] != $date1 && $date1 != '') {
            $discription .= 'Expiry from date changed to ' . $date1 . '.';
        } elseif (isset($existingData->dates['date1']) && $existingData->dates['date1'] != '' && $existingData->dates['date1'] != $date1 && $date1 == '') {
            $discription .= 'Expiry from date removed.';
        } elseif (!isset($existingData->dates['date1']) && $date1 != '') {
            $discription .= 'Expiry from date changed to ' . $date1 . '.';
        }
        if (isset($request->date2)) {
            $assign = 1;
            $date2 = $request->date2;
        } else {
            $date2 = "";
        }
        if (isset($existingData->dates['date2']) && $existingData->dates['date2'] != $date2 && $date2 != '') {
            $discription .= 'Expiry to date changed to ' . $date2 . '.';
        } elseif (isset($existingData->dates['date2']) && $existingData->dates['date2'] != '' && $existingData->dates['date2'] != $date2 && $date2 == '') {
            $discription .= 'Expiry to date removed.';
        } elseif (!isset($existingData->dates['date2']) && $date2 != '') {
            $discription .= 'Expiry to date changed to ' . $date2 . '.';
        }
        if (isset($request->note)) {
            $assign = 1;
            $note = $request->note;
        } else {
            $note = "";
        }
        if (isset($existingData->note) && $existingData->note != $note && $note != '') {
            $discription .= 'New note ' . $note . ' added.';
        } elseif (isset($existingData->note) && $existingData->note != '' && $existingData->note != $note && $note == '') {
            $discription .= 'Note removed.';
        } elseif (!isset($existingData->note) && $note != '') {
            $discription .= 'New note ' . $note . ' added.';
        }
        if (isset($request->customerAgentId)) {
            $assign = 1;
            $customerAgentId = $request->customerAgentId;
            $customerAgentName = User::select('name')->find($customerAgentId)->name;
        } else {
            $customerAgentId = "";
            $customerAgentName = "";
        }
        if (isset($existingData->assaignedTo['customerAgentName']) && $existingData->assaignedTo['customerAgentName'] != $customerAgentName && $customerAgentName != '') {
            $discription .= 'Agent changed to ' . $customerAgentName . '.';
        }
        if (
            isset($existingData->assaignedTo['customerAgentName'])
            && $existingData->assaignedTo['customerAgentName'] != ''
            && $existingData->assaignedTo['customerAgentName'] != $customerAgentName
            && $customerAgentName == ''
        ) {
            $discription .= 'Agent name removed .';
        }
        if (!isset($existingData->assaignedTo['customerAgentName'])  && $customerAgentName != '') {
            $discription .= 'Agent changed to ' . $customerAgentName . '.';
        }
        // if (isset($request->customerAgentName)) {
        //     $assign = 1;
        //     $customerAgentName=$request->customerAgentName;
        // } else {
        //     $customerAgentName="";
        // }

        if (isset($request->customer)) {
            $assign = 1;
            $customer = new ObjectId($request->customer);
            $customerName = Customer::select('fullName')->find($customer)->fullName;
        } else {
            $customer = '';
            $customerName = '';
        }
        if (isset($existingData->assaignedTo['customerName']) && $existingData->assaignedTo['customerName'] != $customerName && $customerName != '') {
            $discription .= 'Customer name changed to ' . $customerName . '.';
        }
        if (!isset($existingData->assaignedTo['customerName'])  && $customerName != '') {
            $discription .= 'Customer name changed to ' . $customerName . '.';
        }
        if (isset($request->agent)) {
            $assign = 1;
            if ($request->agent == '999') {
                $agent = "999";
                $agentName = "All";
            } else {
                $agent = new ObjectId($request->agent);
                $agentName = User::select('name')->find($agent);
                $agentName = $agentName->name ?: "";
            }
        } else {
            $agent = '';
            $agentName = '';
        }

        if (isset($existingData->assaignedTo['agentName']) && $existingData->assaignedTo['agentName'] != $agentName && $agentName != '') {
            $discription .= 'Assigned to ' . $agentName . '.';
        }
        if (!isset($existingData->assaignedTo['agentName'])  && $agentName != '') {
            $discription .= 'Assigned to ' . $agentName . '.';
        }
        if (isset($request->substatus)) {
            $assign = 1;
            $substatus = $request->substatus;
            if ($request->substatusText == 'No sub status') {
                $substatusText = '';
            } else {
                $substatusText = $request->substatusText;
            }
        } else {
            $substatus = '';
            $substatusText = '';
        }

        if (isset($request->status)) {
            $assign = 1;
            $status = $request->status;
        } else {
            $status = '';
        }
        if (isset($request->group)) {
            $assign = 1;
            $groupName = ucwords(strtolower($request->group));
        } else {
            $groupName = '';
        }
        if (isset($existingData->assaignedTo['groupName']) && $existingData->assaignedTo['groupName'] != $request->group && $request->group != '') {
            $discription .= 'Group changed to ' . $groupName . '.';
        } elseif (
            isset($existingData->assaignedTo['groupName'])
            && $existingData->assaignedTo['groupName'] != ''
            && $existingData->assaignedTo['groupName'] != $request->group
            && $request->group == ''
        ) {
            $discription .= 'Group name removed.';
        } elseif (!isset($existingData->assaignedTo['groupName'])  && $request->group != '') {
            $discription .= 'Group changed to ' . $groupName . '.';
        }
        if (isset($existingData->assaignedTo['assaignStatusName']) && $existingData->assaignedTo['assaignStatusName'] != $request->statusText && $request->statusText != '') {
            $discription .= 'Status changed to ' . $request->statusText . '.';
        } elseif (
            isset($existingData->assaignedTo['assaignStatusName']) && $existingData->assaignedTo['assaignStatusName'] != '' &&
            $existingData->assaignedTo['assaignStatusName'] != $request->statusText
            && $request->statusText == ''
        ) {
            $discription .= 'Status removed.';
        } elseif (!isset($existingData->assaignedTo['assaignStatusName'])  && $request->statusText != '') {
            $discription .= 'Status changed to ' . $request->statusText . '.';
        }
        if (isset($existingData->assaignedTo['assaignSubStatusName']) && $existingData->assaignedTo['assaignSubStatusName'] != $request->substatusText && $request->substatusText != '') {
            $discription .= 'Sub Status changed to ' . $request->substatusText . '.';
        } elseif (
            isset($existingData->assaignedTo['assaignSubStatusName'])
            && $existingData->assaignedTo['assaignSubStatusName'] != ''
            && $existingData->assaignedTo['assaignSubStatusName'] != $request->substatusText
            && $request->substatusText == ''
        ) {
            $discription .= 'Sub Status removed.';
        } elseif (!isset($existingData->assaignedTo['assaignSubStatusName'])  && $request->substatusText != '') {
            $discription .= 'Sub Status changed to ' . $request->substatusText . '.';
        }
        //  dd($status);
        $currentDoc = Enquiries::find($request->mailId);
        $currentDoc = @$currentDoc->attachements;
        $names = $request->updateAttachName;
        $match = $names;
        $suffix = "";
        if ($names) {
            foreach ($names as $name) {
                if ($name != "") {
                    $$name = 64;
                }
            }
            foreach ($names as $key => $name) {
                // adding suffix to updated name
                if ($name == "" && !$name && isset($currentDoc[$key]['attachId'])) {
                    if (
                        isset($existingData->attachements[$key]['updatedName'])
                        && $existingData->attachements[$key]['updatedName'] != $name
                        && $name == ''
                    ) {
                        $discription .= 'Image name removed.';
                    }
                    Enquiries::where('_id', new ObjectId($request->mailId))
                        // ->where('attachements' . $key . 'attachId', '!=', null)
                        ->update(
                            [
                                'attachements.' . $key . '.updatedName' => $name,
                                'attachements.' . $key . '.suffix' => ""
                            ]
                        );
                    array_shift($match);
                    continue;
                } else {
                    array_shift($match);
                    if (in_array($name, $match)) {
                        $$name++;
                        $suffix = chr($$name);
                    } else {
                        if (chr($$name) == "@") {
                            $suffix = "";
                        } else {
                            $$name++;
                            $suffix = chr($$name);
                        }
                    }
                    // dd($existingData->attachements[$key]['updatedName']);
                    if (
                        isset($existingData->attachements[$key]['updatedName']) &&
                        $existingData->attachements[$key]['updatedName'] != $name &&
                        $name != ''
                    ) {
                        $discription .= 'Image name updated to ' . $name . '.';
                    } elseif (
                        isset($existingData->attachements[$key]['updatedName']) &&
                        $existingData->attachements[$key]['updatedName'] != $name &&
                        $name == ''
                    ) {
                        $discription .= 'Image name removed.';
                    } elseif (!isset($existingData->attachements[$key]['updatedName']) && $name != '') {
                        $discription .= 'Image name updated to ' . $name . '.';
                    }
                    Enquiries::where('_id', new ObjectId($request->mailId))->update([
                        'attachements.' . $key . '.updatedName' => $name,
                        'attachements.' . $key . '.suffix' => $suffix
                    ]);
                }
                //end of adding suffix to updated name

                if ($name != "") {
                    $updateStatus = 1;
                }
            }
        }

        if ($assign == 1) {
            $data = Enquiries::find(new ObjectId($request->mailId));
            $data->renewal = (int) $renewal;
            $assaign = new \stdClass();
            $assaign->customerId = $customer;
            $assaign->customerName = $customerName;
            $assaign->agentId = $agent;
            $assaign->agentName = $agentName;
            $assaign->assaignStatus = $status;
            $assaign->groupName = $groupName;
            $assaign->assaignStatusName = $request->statusText;
            $assaign->assaignSubStatusName = $substatusText;
            $assaign->customerAgentId = $customerAgentId;
            $assaign->customerAgentName = $customerAgentName;
            $assaign->insurerName = $insurerName;
            $assaign->insurerId = $insurerId;
            $data->assaignedTo = $assaign;
            $data->isassigned = 1;
            $data->commissionPercentage = $finalCommission;
            $data->commissionAmount =  $commissionAmount;
            $data->renewalDate = (string) $request->renewal_date; //for saving renewal date
            $data->expiryDate = (string) $request->renewal_date; //for saving expiry date
            $data->reminderDate = (string) $request->reminder_date; //for saving reminder date
            $data->policyAmount = (string) str_replace(',', '', $request->policy); //for policy premium
            $policy = (string) str_replace(',', '', $request->policy);
            if (isset($existingData->policyAmount) && $existingData->policyAmount != $policy && $policy != '') {
                $discription .= 'Policy premium amount (' . $policy . ') added.';
            } elseif (isset($existingData->policyAmount) && $existingData->policyAmount != $policy && $policy == '') {
                $discription .= 'Policy premium amount removed.';
            } elseif (!isset($existingData->policyAmount) &&  $policy != '') {
                $discription .= 'Policy premium amount (' . $policy . ') added.';
            }
            if (isset($existingData->renewalDate) && $existingData->renewalDate != $request->renewal_date && $request->renewal_date != '') {
                $discription .= 'Renewal Date changed to ' . $request->renewal_date . '.';
            } elseif (isset($existingData->renewalDate) &&  $existingData->renewalDate != $request->renewal_date && $request->renewal_date == '') {
                $discription .= 'Renewal Date removed.';
            } elseif (!isset($existingData->renewalDate) &&  $request->renewal_date != '') {
                $discription .= 'Renewal Date changed to ' . $request->renewal_date . '.';
            }

            if (isset($existingData->reminderDate) &&  $existingData->reminderDate != $request->reminder_date && $request->reminder_date != '') {
                $discription .= 'Reminder Date changed to ' . $request->reminder_date . '.';
            } elseif (isset($existingData->reminderDate) &&  $existingData->reminderDate != $request->reminder_date && $request->reminder_date == '') {
                $discription .= 'Reminder Date removed.';
            } elseif (!isset($existingData->reminderDate) &&  $request->reminder_date != '') {
                $discription .= 'Reminder Date changed to ' . $request->reminder_date . '.';
            }

            $dates = new \stdClass();
            $dates->date1 = $date1;
            $dates->date2 = $date2;
            $data->dates = $dates;
            $data->note = $note;
            if ($data->save()) {
                if ($status == 1 && $type == "submit") {
                    date_default_timezone_set('Asia/Dubai');
                    $day = date('d-m-y h:i:s a');
                    Enquiries::where('_id', new ObjectId($request->mailId))
                        ->update(['mailStatus' => 0, 'closedAt' => $day]);
                    $discription .= 'Document completed successfully.';
                } else {
                    $discription .= 'Document saved successfully.';
                }
                EnquiryManagementController::saveLog($discription, 'Enquiry Management', $request->mailId, $existingData->subject, $existingData->documentMailBox); //save log
                return 1;
            } else {
                return 0;
            }
        }
        if ($updateStatus == 0 && $assign == 0) {
            return 'nothing';
        } else {
            return 1;
        }
    }
    //end of action of save & saveAndSubmit

    public function getEmail(Request $req)
    {
        $mailId = $req->index;
        $content = Enquiries::find($mailId);
        return $content;
    }

    public function forwardDocument(Request $request)
    {
        // dd($request);
        $ids = $request->forwardTo;
        foreach ($ids as $to) {
            ForwordEnquiry::dispatch($request->mailId, $to, $request->cc, $request->body);
        }
        $existingData = Enquiries::select('subject', 'documentMailBox')->find(new ObjectId($request->mailId));
        EnquiryManagementController::saveLog("Document forwarded.", 'Enquiry Management', $request->mailId, $existingData->subject, $existingData->documentMailBox); //save log
        return 1;
    }
    public function viewComments(Request $request)
    {
        $seen = new ObjectId(Auth::id());
        $id = $request->index;
        $comment_seen = Enquiries::where('_id', $request->index)
            ->where('commentSeen', '=', new ObjectId(Auth::id()))->first();
        if (!$comment_seen) {
            Enquiries::where('_id', $id)->push(['commentSeen' => $seen]);
        }
        $comments = Enquiries::select('comments')->where('_id', $request->index)
            ->first()->comments;



        if (isset($comments)) {
            $commentsReturn = [];
            foreach ($comments as $comment) {
                $comment["commentDate"] = $comment["commentDate"]->toDateTime()->format('d-m-yy h:m:s a');
                $commentsReturn[] = $comment;
            }

            // dd($commentsReturn);
            return $commentsReturn;
        } else {
            return 0;
        }
    }

    public function submitComments(Request $request)
    {
        date_default_timezone_set('Asia/Dubai');
        $comment = new \stdClass();
        $comment->commentId = (string) time() . uniqid();
        $comment->commentBody = $request->comment;
        $comment->commentBy = session('user_name');
        $date = new UTCDateTime();
        $comment->commentDate = $date;
        $date = $date->toDateTime()->format('d-m-yy h:m:s a');
        Enquiries::where('_id', $request->index)->push('comments', $comment);
        $commentSeen[] = new ObjectID(Auth::id());
        Enquiries::where('_id', $request->index)->update(['commentSeen' => $commentSeen]);
        $response = ['body' => $request->comment, 'date' => $date, 'by' => session('user_name')];
        $existingData = Enquiries::select('subject', 'documentMailBox')->find(new ObjectId($request->index));
        $discription = 'New comment added : ' . $request->comment . '.';
        EnquiryManagementController::saveLog($discription, 'Enquiry Management', $request->mailId, $existingData->subject, $existingData->documentMailBox); //save log
        return $response;
    }


    /**
     * To view entries with latest comments
     */
    public function latestComments(Request $request)
    {
        $start = $request->page;
        $filterMethod = $request->filterMethod;
        if ($start == '') {
            $start = 0;
        }
        $length = 20;
        $countMails = 0;
        $old = session('closedOldCache');
        $box = $request->box;
        $result = EnquiryCredentials::find(new ObjectId($box));
        $user = $result->userID;
        if ($old != $user) {
            session()->pull('closedEnquiryFilter');
            session()->pull('ClosedSearchKey');
        }
        $data = Enquiries::where('documentMailBox', $user)
            ->where('deleted', '!=', 1)
            ->where('comments', 'exists', true);
        // ->where('commentSeen', '!=', new ObjectId(Auth::user()->_id));
        // ->get();
        // dd($data);
        $statusDetails = $request->statusDetails;
        $nonstatusDetails = $request->nonstatusDetails;
        $customerDetails = $request->customerDetails;
        $agentDetails = $request->agentDetails;
        $customerAgentDetails = $request->customerAgentDetails;
        $insurerDetails = $request->insurerDetails;
        $filterFromDate = $request->filterFromDate;
        $filterToDate = $request->filterToDate;
        $renewalCheck = $request->renewalCheck;
        $nonrenewalCheck = $request->nonrenewalCheck;
        $groupDetails = $request->groupDetails;
        $stat = session('closedEnquiryFilter.statusList');
        // $arr = [];
        if ($statusDetails != "") {
            // foreach ($statusDetails as $item) {
            //     array_push($arr, $item);
            // }
            session(['closedEnquiryFilter.statusList' => $statusDetails]);
            $stat = session('closedEnquiryFilter.statusList');
        } elseif ($filterMethod == 'filter' && $statusDetails == "") {
            session()->pull('closedEnquiryFilter.statusList');
            unset($stat);
        }
        $group = session('closedEnquiryFilter.GroupList');
        $arr = [];
        if ($groupDetails != "") {
            foreach ($groupDetails as $item) {
                array_push($arr, $item);
            }
            session(['closedEnquiryFilter.GroupList' => $arr]);
            $group = session('closedEnquiryFilter.GroupList');
        } elseif ($filterMethod == 'filter' && $groupDetails == "") {
            session()->pull('closedEnquiryFilter.GroupList');
            unset($group);
        }
        $nonstat = session('closedEnquiryFilter.nonstatusList');
        // $arr = [];
        if ($nonstatusDetails != "") {
            // foreach ($nonstatusDetails as $item) {
            //     array_push($arr, $item);
            // }
            session(['closedEnquiryFilter.nonstatusList' => $nonstatusDetails]);
            $nonstat = session('closedEnquiryFilter.nonstatusList');
        } elseif ($filterMethod == 'filter' && $nonstatusDetails == "") {
            session()->pull('closedEnquiryFilter.nonstatusList');
            unset($nonstat);
        }
        $arr = [];
        $cust = session('closedEnquiryFilter.customerList');
        if ($customerDetails != "") {
            foreach ($customerDetails as $item) {
                array_push($arr, new ObjectId($item));
            }
            session(['closedEnquiryFilter.customerList' => $arr]);
            $cust = session('closedEnquiryFilter.customerList');
        } elseif ($filterMethod == 'filter' && $customerDetails == "") {
            session()->pull('closedEnquiryFilter.customerList');
            unset($cust);
        }
        $arr = [];
        $custAgent = session('closedEnquiryFilter.customerAgentList');
        if ($customerAgentDetails != "") {
            foreach ($customerAgentDetails as $item) {
                array_push($arr, $item);
            }
            session(['closedEnquiryFilter.customerAgentList' => $arr]);
            $custAgent = session('closedEnquiryFilter.customerAgentList');
        } elseif ($filterMethod == 'filter' && $customerAgentDetails == "") {
            session()->pull('closedEnquiryFilter.customerAgentList');
            unset($custAgent);
        }
        $insurer = session('closedEnquiryFilter.insurerList');
        $arr = [];
        if ($insurerDetails != "") {
            foreach ($insurerDetails as $item) {
                array_push($arr, $item);
            }
            session(['closedEnquiryFilter.insurerList' => $arr]);
            $insurer = session('closedEnquiryFilter.insurerList');
        } elseif ($filterMethod == 'filter' && $insurerDetails == "") {
            session()->pull('closedEnquiryFilter.insurerList');
            unset($insurer);
        }
        $agen = session('closedEnquiryFilter.agentList');
        $arr = [];
        if ($agentDetails != "") {
            foreach ($agentDetails as $item) {
                array_push($arr, new ObjectId($item));
            }
            session(['closedEnquiryFilter.agentList' => $arr]);
            $agen = session('closedEnquiryFilter.agentList');
        } elseif ($filterMethod == 'filter' && $agentDetails == "") {
            session()->pull('closedEnquiryFilter.agentList');
            unset($agen);
        }
        $fromDateFilter = session('closedEnquiryFilter.fromDateFilter');
        if ($filterFromDate != "") {
            session(['closedEnquiryFilter.fromDateFilter' => $filterFromDate]);
            $fromDateFilter = session('closedEnquiryFilter.fromDateFilter');
        } elseif ($filterMethod == 'filter' && $filterFromDate == "") {
            session()->pull('closedEnquiryFilter.fromDateFilter');
            unset($fromDateFilter);
        }
        $toDateFilter = session('closedEnquiryFilter.toDateFilter');
        if ($filterToDate != "") {
            session(['closedEnquiryFilter.toDateFilter' => $filterToDate]);
            $toDateFilter = session('closedEnquiryFilter.toDateFilter');
        } elseif ($filterMethod == 'filter' && $filterToDate == "") {
            session()->pull('closedEnquiryFilter.toDateFilter');
            unset($toDateFilter);
        }
        $renewalFilter = session('closedEnquiryFilter.renewalFilter');
        if ($renewalCheck != "") {
            session(['closedEnquiryFilter.renewalFilter' => $renewalCheck]);
            $renewalFilter = session('closedEnquiryFilter.renewalFilter');
        } elseif ($filterMethod == 'filter' && $renewalCheck == "") {
            session()->pull('closedEnquiryFilter.renewalFilter');
            unset($renewalFilter);
        }
        $nonrenewalFilter = session('closedEnquiryFilter.nonrenewalFilter');
        if ($nonrenewalCheck != "") {
            session(['closedEnquiryFilter.nonrenewalFilter' => $nonrenewalCheck]);
            $nonrenewalFilter = session('closedEnquiryFilter.nonrenewalFilter');
        } elseif ($filterMethod == 'filter' && $nonrenewalCheck == "") {
            session()->pull('closedEnquiryFilter.nonrenewalFilter');
            unset($nonrenewalFilter);
        }

        if (isset($nonstat) && isset($stat) && $nonstat != '' && $stat != '') {
            $statArray = array_merge($stat, $nonstat);
            if (isset($statArray)) {
                $data->where(function ($query) use ($statArray) {
                    foreach ($statArray as $status) {
                        if (count(@$status['subStatus']) > 0) {
                            $subStatus = $status['subStatus'];
                            $Status = $status['status'];
                            $query->orwhere(function ($query2) use ($subStatus, $Status) {
                                $query2->where('assaignedTo.assaignStatusName', $Status);
                                $query2->where(function ($query3) use ($subStatus, $Status) {
                                    foreach ($subStatus as $eachstatus) {
                                        $query3->orWhere('assaignedTo.assaignSubStatusName', $eachstatus);
                                    }
                                });
                            });
                        } else {
                            $query->orWhere('assaignedTo.assaignStatusName', $status['status']);
                        }
                    }
                });
            }
        } else {
            if (isset($nonstat)) {
                $data->where(function ($query) use ($nonstat) {
                    foreach ($nonstat as $status) {
                        if (count(@$status['subStatus']) > 0) {
                            $subStatus = $status['subStatus'];
                            $Status = $status['status'];
                            $query->orwhere(function ($query2) use ($subStatus, $Status) {
                                $query2->where('assaignedTo.assaignStatusName', $Status);
                                $query2->where(function ($query3) use ($subStatus, $Status) {
                                    foreach ($subStatus as $eachstatus) {
                                        $query3->orWhere('assaignedTo.assaignSubStatusName', $eachstatus);
                                    }
                                });
                            });
                        } else {
                            $query->orWhere('assaignedTo.assaignStatusName', $status['status']);
                        }
                    }
                });
            }
            if (isset($stat)) {
                $data->where(function ($query) use ($stat) {
                    foreach ($stat as $status) {
                        if (count(@$status['subStatus']) > 0) {
                            $subStatus = $status['subStatus'];
                            $Status = $status['status'];
                            $query->orwhere(function ($query2) use ($subStatus, $Status) {
                                $query2->where('assaignedTo.assaignStatusName', $Status);
                                $query2->where(function ($query3) use ($subStatus, $Status) {
                                    foreach ($subStatus as $eachstatus) {
                                        $query3->orWhere('assaignedTo.assaignSubStatusName', $eachstatus);
                                    }
                                });
                            });
                        } else {
                            $query->orWhere('assaignedTo.assaignStatusName', $status['status']);
                        }
                    }
                });
            }
        }

        // if (isset($nonstat) && isset($stat) && $nonstat != '' && $stat != '') {
        //     $statArray = array_merge($stat, $nonstat);
        // }

        // if (isset($stat) && !isset($nonstat)) {
        //     $data->whereIn('assaignedTo.assaignStatusName', $stat)->where('renewal', 1);
        // }
        // if (isset($nonstat) && !isset($stat)) {
        //     $data->whereIn('assaignedTo.assaignStatusName', $nonstat)->where('renewal', 0);
        // }
        // if (isset($nonstat) && isset($stat) && $nonstat != '' && $stat != '') {
        //     $data->whereIn('assaignedTo.assaignStatusName', $statArray);
        // }
        if (isset($group)) {
            $data->whereIn('assaignedTo.groupName', $group);
        }
        $arr = [];
        if (isset($cust)) {
            $data->whereIn('assaignedTo.customerId', $cust);
            $customers = Customer::whereIn('_id', $cust)->get();
        } else {
            $customers = '';
        }
        $arr = [];
        if (isset($custAgent)) {
            $data->whereIn('assaignedTo.customerAgentId', $custAgent);
        }
        $arr = [];
        if (isset($agen)) {
            $data->whereIn('assaignedTo.agentId', $agen);
        }
        if (isset($fromDateFilter)) {
            $fDate = Carbon::createFromFormat('!d/m/Y', $fromDateFilter);
            $data->where('mailRecTme', '>=', $fDate);
        }
        if (isset($toDateFilter)) {
            $TDate = Carbon::createFromFormat('!d/m/Y', $toDateFilter);
            $todate = $TDate->endOfDay();
            $data->where('mailRecTme', '<=', $todate);
        }
        if (isset($renewalFilter) && !isset($nonrenewalFilter)) {
            $data->where('renewal', 1);
        }
        if (isset($nonrenewalFilter) && !isset($renewalFilter)) {
            $data->where('renewal', '!=', 1);
        }
        if (isset($nonrenewalFilter) && isset($renewalFilter)) {
            $data;
        }
        // if (isset($agen) && session('role')=='Admin') {
        //     $data->whereIn('assaignedTo.agentId', $agen);
        // } elseif (isset($agen) && session('role')=='Employee') {
        //     $data->where('assaignedTo.agentId', new ObjectId(Auth::user()->_id));

        // }
        $arr = [];
        if (isset($insurer)) {
            $data->whereIn('assaignedTo.insurerId', $insurer);
            $insurers = Insurer::whereIn('_id', $insurer)->get();
        } else {
            $insurers = '';
        }
        $searchKey = session('ClosedSearchKey');
        if ($request->search2 != "") {
            session(['ClosedSearchKey' => $request->search2]);
            $searchKey = $request->search2;
        } elseif ($request->search2 == '' && $filterMethod == 'search') {
            session()->pull('ClosedSearchKey');
            unset($searchKey);
        }
        if (isset($searchKey)) {
            $data = $data->where(function ($query) use ($searchKey) {
                $query->where('subject', 'like', '%' . $searchKey . '%')
                    ->orWhere('assaignedTo.customerName', 'like', '%' . $searchKey . '%')
                    ->orWhere('assaignedTo.insurerName', 'like', '%' . $searchKey . '%')
                    ->orWhere('mailsText', 'like', '%' . $searchKey . '%')
                    ->orWhere('attachements.attachName', 'like', '%' . $searchKey . '%');
            });
        }
        if (session('role') == 'Agent') {
            $data = $data->where('assaignedTo.customerAgentId', Auth::user()->_id);
        } elseif (session('role') == 'Coordinator') {
            $coAgent = (string) session('assigned_agent');
            $data = $data->where('assaignedTo.customerAgentId', $coAgent);
        }
        session(['closedOldCache' => $user]);
        $countMails = $data->count();
        $data = $data->orderBy('comments.commentDate', 'desc')->skip((int) $start)->take((int) $length)
            ->get();
        $mailBoxes = EnquiryCredentials::where('credentialStatus', 1)->get();
        if (!$mailBoxes) {
            return redirect('/logout');
        }
        // dd($data);
        if ($request->ajax()) {
            $documentOperation = view(
                'enquiry_management.latest_comments_search',
                [
                    'data' => $data,
                    'mailBoxes' => $mailBoxes,
                    'user' => $user,
                    'countMails' => $countMails,
                    'customers' => $customers,
                    'insurers' => $insurers,
                    'countMails' => $countMails
                ]
            )->render();
            return response()->json([
                'status' => 'success', 'documentOperation' => $documentOperation,
                'countMails' => $countMails
            ]);
        }
        return view('enquiry_management.latest_comments')
            ->with(compact('data', 'mailBoxes', 'user', 'customers', 'insurers', 'countMails'));
    }


    public function customFilter(Request $request)
    {
        $countMails = 0;
        if ($request->status == 1) {
            $searchKey = session('ActiveSearchKey');
            session()->pull('enquiryFilter');
        } elseif ($request->status == 0) {
            $searchKey = session('ClosedSearchKey');
            session()->pull('closedEnquiryFilter');
        }
        // dd($searchKey);
        $statusDetails = $request->statusDetails;
        $arr = [];
        $customerDetails = $request->customerDetails;
        $agentDetails = $request->agentDetails;
        $customerAgentDetails = $request->customerAgentDetails;
        $insurerDetails = $request->insurerDetails;
        $data = Enquiries::where('mailStatus', (int) $request->status)->where('documentMailBox', $request->user)->where('deleted', '!=', 1);
        if (isset($searchKey)) {
            $data = $data->where(
                function ($query) use ($searchKey) {
                    $query->where('subject', 'like', '%' . $searchKey . '%')
                        ->orWhere('assaignedTo.customerName', 'like', '%' . $searchKey . '%')
                        ->orWhere('assaignedTo.insurerName', 'like', '%' . $searchKey . '%')
                        ->orWhere('mailsText', 'like', '%' . $searchKey . '%')
                        ->orWhere('attachements.attachName', 'like', '%' . $searchKey . '%');
                }
            );
        }
        if ($request->status == 1) {
            if ($statusDetails != "") {
                foreach ($statusDetails as $item) {
                    array_push($arr, $item);
                }
                $data->whereIn('assaignedTo.assaignStatusName', $arr);
                session(['enquiryFilter.statusList' => $arr]);
            }
            $arr = [];
            if ($customerDetails != "") {
                foreach ($customerDetails as $item) {
                    array_push($arr, new ObjectId($item));
                }
                $data->whereIn('assaignedTo.customerId', $arr);
                session(['enquiryFilter.customerList' => $arr]);
            }
            $arr = [];
            if ($customerAgentDetails != "") {
                foreach ($customerAgentDetails as $item) {
                    array_push($arr, $item);
                }
                $data->whereIn('assaignedTo.customerAgentId', $arr);
                session(['enquiryFilter.customerAgentList' => $arr]);
            }
            $arr = [];
            if ($insurerDetails != "") {
                foreach ($insurerDetails as $item) {
                    array_push($arr, $item);
                }
                $data->whereIn('assaignedTo.insurerId', $arr);
                session(['enquiryFilter.insurerList' => $arr]);
            }

            $arr = [];
            if (session('role') == 'Admin' && $agentDetails != "") {
                foreach ($agentDetails as $item) {
                    array_push($arr, new ObjectId($item));
                }
                $data->whereIn('assaignedTo.agentId', $arr);
                session(['enquiryFilter.agentList' => $arr]);
            }
            if (session('role') == 'Employee' && $request->status == 1) {
                $data->where('assaignedTo.agentId', new ObjectId(Auth::user()->_id));
            }
            if (session('role') == 'Employee' && $request->status == 0 && $agentDetails != "") {
                foreach ($agentDetails as $item) {
                    array_push($arr, new ObjectId($item));
                }
                $data->whereIn('assaignedTo.agentId', $arr);
                session(['enquiryFilter.agentList' => $arr]);
            }
        } elseif ($request->status == 0) {
            if (isset($searchKey)) {
                $data = $data->where(
                    function ($query) use ($searchKey) {
                        $query->where('subject', 'like', '%' . $searchKey . '%')
                            ->orWhere('assaignedTo.customerName', 'like', '%' . $searchKey . '%')
                            ->orWhere('assaignedTo.insurerName', 'like', '%' . $searchKey . '%')
                            ->orWhere('mailsText', 'like', '%' . $searchKey . '%')
                            ->orWhere('attachements.attachName', 'like', '%' . $searchKey . '%');
                    }
                );
            }
            if ($statusDetails != "") {
                foreach ($statusDetails as $item) {
                    array_push($arr, $item);
                }
                $data->whereIn('assaignedTo.assaignStatusName', $arr);
                session(['closedEnquiryFilter.statusList' => $arr]);
            }
            $arr = [];
            if ($customerDetails != "") {
                foreach ($customerDetails as $item) {
                    array_push($arr, new ObjectId($item));
                }
                $data->whereIn('assaignedTo.customerId', $arr);
                session(['closedEnquiryFilter.customerList' => $arr]);
            }
            $arr = [];
            if ($customerAgentDetails != "") {
                foreach ($customerAgentDetails as $item) {
                    array_push($arr, $item);
                }
                $data->whereIn('assaignedTo.customerAgentId', $arr);
                session(['closedEnquiryFilter.customerAgentList' => $arr]);
            }
            $arr = [];
            if ($insurerDetails != "") {
                foreach ($insurerDetails as $item) {
                    array_push($arr, $item);
                }
                $data->whereIn('assaignedTo.insurerId', $arr);
                session(['closedEnquiryFilter.insurerList' => $arr]);
            }

            $arr = [];
            if (session('role') == 'Admin' && $agentDetails != "") {
                foreach ($agentDetails as $item) {
                    array_push($arr, new ObjectId($item));
                }
                $data->whereIn('assaignedTo.agentId', $arr);
                session(['closedEnquiryFilter.agentList' => $arr]);
            }
            if (session('role') == 'Employee' && $request->status == 1) {
                $data->where('assaignedTo.agentId', new ObjectId(Auth::user()->_id));
            }
            if (session('role') == 'Employee' && $request->status == 0 && $agentDetails != "") {
                foreach ($agentDetails as $item) {
                    array_push($arr, new ObjectId($item));
                }
                $data->whereIn('assaignedTo.agentId', $arr);
                session(['closedEnquiryFilter.agentList' => $arr]);
            }
        }
        $mailBoxes = EnquiryCredentials::where('credentialStatus', 1)->get();
        $user = $request->user;
        $data = $data->orderBy('created_at', 'desc')->get();
        $countMails = count($data);
        if ($request->status == 1) {
            $documentOperationSection = view(
                'enquiry_management.enquiry_search',
                ['data' => $data, 'mailBoxes' => $mailBoxes, 'user' => $user, 'countMails' => $countMails]
            )->render();
        } elseif ($request->status == 0) {
            $documentOperationSection = view(
                'enquiry_management.closed_enquiry_search',
                ['data' => $data, 'mailBoxes' => $mailBoxes, 'user' => $user, 'countMails' => $countMails]
            )->render();
        }
        return response()->json(
            [
                'status' => 'success',
                'documentOperationSection' => $documentOperationSection,
                'countMails' => $countMails
            ]
        );
    }

    public function customSearch(Request $request)
    {
        $countMails = 0;
        $key = $request->key;
        $documentStatus = $request->status;
        $mailBox = EnquiryCredentials::where('_id', $request->credential)->get()->first();
        $user = $mailBox->userID;
        $data = Enquiries::where('mailStatus', (int) $documentStatus)->where('documentMailBox', $user)->where('deleted', '!=', 1);
        if ($request->status == 1) {
            $stat = session('enquiryFilter.statusList');
            $cust = session('enquiryFilter.customerList');
            $agen = session('enquiryFilter.agentList');
            $custAgent = session('enquiryFilter.customerAgentList');
            $insurer = session('enquiryFilter.insurerList');
            session(['ActiveSearchKey' => $key]);
        } elseif ($request->status == 0) {
            $stat = session('closedEnquiryFilter.statusList');
            $cust = session('closedEnquiryFilter.customerList');
            $agen = session('closedEnquiryFilter.agentList');
            $custAgent = session('closedEnquiryFilter.customerAgentList');
            $insurer = session('closedEnquiryFilter.insurerList');
            session(['ClosedSearchKey' => $key]);
        }

        //    $req= $this->viewEnquiries(new Request());
        // if ($req->ajax()) {
        //    $documentOperation = view('enquiry_management.enquiry_search',
        //      ['data' => $data, 'mailBoxes' => $mailBoxes, 'user'=>$user,
        //     'countMails'=>$countMails, 'customers'=>$customers, 'insurers'=>$insurers, 'countMails'=>$countMails])
        // ->render();
        //     return response()->json(['status' => 'success', 'documentOperation' => $documentOperation,
        //     'countMails'=>$countMails]);
        // }
        // return view('enquiry_management.enquiry_management')
        // ->with(compact('data', 'mailBoxes', 'user', 'customers', 'insurers', 'countMails'));
        // if (isset($stat)) {
        //     $data->whereIn('assaignedTo.assaignStatusName', $stat);
        // }
        // $arr=[];
        // if (isset($cust)) {
        //     $data->whereIn('assaignedTo.customerId', $cust);
        // }
        // $arr=[];
        // if (isset($agen)) {
        //     $data->whereIn('assaignedTo.agentId', $agen);
        // }
        // $arr=[];
        // if (isset($custAgent)) {
        //     $data->whereIn('assaignedTo.customerAgentId', $custAgent);
        // }
        // $arr=[];
        // if (isset($insurer)) {
        //     $data->whereIn('assaignedTo.insurerId', $insurer);
        // }

        // if (session('role')=='Employee') {
        //     if ($key!="") {
        //         if ($documentStatus==0) {
        //             $data=$data->where(function ($query) use ($key) {
        //                 $query->where('subject', 'like', '%'.$key.'%')
        //                                 ->orWhere('assaignedTo.customerName', 'like', '%'.$key.'%')
        //                                 ->orWhere('assaignedTo.insurerName', 'like', '%'.$key.'%')
        //                                 ->orWhere('mailsText', 'like', '%'.$key.'%')
        //                                 ->orWhere('attachements.attachName', 'like', '%'.$key.'%');
        //             })->orderBy('created_at', 'desc')->get();
        //         } elseif ($documentStatus==1) {
        //             $data=$data->where('assaignedTo.agentId', new ObjectId(Auth::user()->_id))
        //                         ->where(function ($query) use ($key) {
        //                             $query->where('subject', 'like', '%'.$key.'%')
        //                                     ->orWhere('assaignedTo.customerName', 'like', '%'.$key.'%')
        //                                     ->orWhere('assaignedTo.insurerName', 'like', '%'.$key.'%')
        //                                     ->orWhere('mailsText', 'like', '%'.$key.'%')
        //                                     ->orWhere('attachements.attachName', 'like', '%'.$key.'%');
        //                         })->orderBy('created_at', 'desc')->get();
        //         }
        //     } else {
        //         if ($documentStatus==1) {
        //             $data=$data->where('assaignedTo.agentId', new ObjectId(Auth::user()->_id))
        //                         ->orderBy('created_at', 'desc')->get();
        //         } elseif ($documentStatus==0) {
        //             $data=$data->orderBy('created_at', 'desc')->get();
        //         }
        //     }
        // }
        // if (session('role')=='Admin') {
        //     if ($key!="") {
        //         $data=$data->where(function ($query) use ($key) {
        //             $query->where('subject', 'like', '%'.$key.'%')
        //                     ->orWhere('assaignedTo.customerName', 'like', '%'.$key.'%')
        //                     ->orWhere('assaignedTo.insurerName', 'like', '%'.$key.'%')
        //                     ->orWhere('mailsText', 'like', '%'.$key.'%')
        //                     ->orWhere('attachements.attachName', 'like', '%'.$key.'%');
        //         })->orderBy('created_at', 'desc')->get();
        //     } else {
        //         $data=$data->orderBy('created_at', 'desc')->get();
        //     }
        // }
        // $countMails=count($data);
        // $mailBoxes = EnquiryCredentials::where('credentialStatus', 1)->get();
        // if ($documentStatus==1) {
        //     $documentOperationSection = view(
        //     'enquiry_management.enquiry_search',
        //     ['data' => $data, 'mailBoxes' => $mailBoxes,'user'=>$user,'countMails'=>$countMails]
        //     )->render();
        // } elseif ($documentStatus==0) {
        // }

        // $documentOperationSection = view($req)->render();

        // return response()->json(['status' => 'success', 'req' => $documentOperationSection]);


        // if ($documentStatus==1) {
        //      return response()->view('enquiry_management.enquiry_management',
        //          compact('data', 'mailBoxes', 'user', 'countMails'));
        //search results from active
        // } elseif ($documentStatus==0) {
        //     return response()
        // ->view('enquiry_management.closed_enquiry_search',
        // compact('data', 'mailBoxes', 'user', ''));        //search results from inactive
        // }
    }

    public function filterOptions(Request $request)
    {
        $role = session('role');
        $customer_drop = [];
        if ($request->input('customerStore') != '') {
            $customers1 = Customer::whereIn('_id', $request->input('customerStore'))->orderBy('fullName')->get();
            if (count($customers1) > 0) {
                foreach ($customers1 as $cust) {
                    $customer_drop[] = "<option value='$cust->_id'  selected>$cust->fullName</option>";
                }
            } else {
                $customer_drop[] = '';
            }
        } else {
            $customer_drop[] = '';
        }
        $insurer_drop = [];
        if ($request->input('insurerStore') != '') {
            $customers1 = Insurer::whereIn('_id', $request->input('insurerStore'))->orderBy('name')->get();
            if (count($customers1) > 0) {
                foreach ($customers1 as $cust) {
                    $insurer_drop[] = "<option value='$cust->_id'  selected>$cust->name</option>";
                }
            } else {
                $insurer_drop[] = '';
            }
        } else {
            $insurer_drop[] = '';
        }

        /////////////////////////////// testing ///////////////////////////////////////////

        $details = Enquiries::where('mailStatus', (int) $request->status)
            ->where('documentMailBox', $request->mailbox)
            ->where('deleted', '!=', 1)
            ->where(function ($q) {
                $q->where('assaignedTo.agentId', '!=', "")
                    ->orWhere('assaignedTo.customerAgentId', '!=', "");
            })
            ->where(function ($query) use ($role, $request) {
                if ($role == "Agent") {
                    $query->where('assaignedTo.customerAgentId', Auth::user()->_id);
                } elseif ($role == "Coordinator") {
                    $coAgent = (string) session('assigned_agent');
                    $query->where('assaignedTo.customerAgentId', $coAgent);
                } elseif ($role == 'Employee' && $request->status == '1') {
                    $query->where('assaignedTo.agentId', new ObjectId(Auth::user()->_id));
                } elseif ($role == 'Supervisor' && $request->status == '1') {
                    $employees = session('employees') ?: [];
                    $employees = array_merge($employees, ["999", "", new ObjectId(Auth::user()->_id), null]);
                    $query->whereIn('assaignedTo.agentId', $employees);
                }
            })
            ->select(
                'assaignedTo.agentId',
                'assaignedTo.agentName',
                'assaignedTo.customerAgentId',
                'assaignedTo.customerAgentName'
            )
            ->get();

        $agentDetails = $details->unique('assaignedTo.agentId')
            ->sortBy('assaignedTo.agentName');
        // $groupDetails = $details->unique('assaignedTo.groupName')
        //     ->sortBy('assaignedTo.groupName');
        $cAgentDetails = $details->unique('assaignedTo.customerAgentId')
            ->sortBy('assaignedTo.customerAgentName');

        $swap = [];
        foreach ($agentDetails as $agent) {
            if (
                isset($agent->assaignedTo) &&
                $agent->assaignedTo != [] &&
                @$agent->assaignedTo['agentId']
            ) {
                array_push($swap, $agent);
            }
        }
        $agents = $swap;
        $swap = [];
        foreach ($cAgentDetails as $customerAgent) {
            if (
                isset($customerAgent->assaignedTo) &&
                $customerAgent->assaignedTo != [] &&
                @$customerAgent->assaignedTo['customerAgentId']
            ) {
                array_push($swap, $customerAgent);
            }
        }
        $customerAgents = $swap;
        $groups = [];
        // $swap = [];
        // foreach ($groupDetails as $key => $group) {
        //     if (
        //         isset($group->assaignedTo) &&
        //         $group->assaignedTo != [] &&
        //         @$group->assaignedTo['groupName'] &&
        //         (@$customerAgent->assaignedTo['customerAgentId'] || @$agent->assaignedTo['agentId'])
        //     ) {
        //         if ($key == 1)
        //         dd($group);
        //         array_push($swap, $group);
        //     }
        // }
        // $groups = $swap;

        return array($agents, $customerAgents, $customer_drop, $insurer_drop, $groups);

        /////////////////////////////// testing ///////////////////////////////////////////

        /**here old code
        $swap = [];
        $agents = Enquiries::select('assaignedTo.agentId', 'assaignedTo.agentName')
            ->where('mailStatus', (int) $request->status)
            ->where('documentMailBox', $request->mailbox)
            ->where('deleted', '!=', 1)
            ->where('assaignedTo.agentId', '!=', "")
            ->where(function ($query) use ($role, $request) {
                if ($role == "Agent") {
                    $query->where('assaignedTo.customerAgentId', Auth::user()->_id);
                } elseif ($role == "Coordinator") {
                    $coAgent = (string) session('assigned_agent');
                    $query->where('assaignedTo.customerAgentId', $coAgent);
                } elseif ($role == 'Employee' && $request->status == '1') {
                    $query->where('assaignedTo.agentId', new ObjectId(Auth::user()->_id));
                } elseif ($role == 'Supervisor' && $request->status == '1') {
                    $employees = session('employees') ?: [];
                    $employees = array_merge($employees, ["999", "", new ObjectId(Auth::user()->_id), null]);
                    $query->whereIn('assaignedTo.agentId', $employees);
                }
            })

            // ->orderBy('assaignedTo.agentName', 'asc')
            ->get()
            ->unique('assaignedTo.agentId')
            ->sortBy('assaignedTo.agentName');

        foreach ($agents as $agent) {
            if (isset($agent->assaignedTo) && $agent->assaignedTo != []) {
                array_push($swap, $agent);
            }
        }
        $agents = $swap;
        $swap = [];
        $groups = Enquiries::select('assaignedTo.groupName')
            ->where('mailStatus', (int) $request->status)
            ->where('documentMailBox', $request->mailbox)
            ->where('deleted', '!=', 1)
            ->where('assaignedTo.groupName', '!=', "")
            ->where(function ($query) use ($role, $request) {
                if ($role == "Agent") {
                    $query->where('assaignedTo.customerAgentId', Auth::user()->_id);
                } elseif ($role == "Coordinator") {
                    $coAgent = (string) session('assigned_agent');
                    $query->where('assaignedTo.customerAgentId', $coAgent);
                } elseif ($role == 'Employee' && $request->status == '1') {
                    $query->where('assaignedTo.agentId', new ObjectId(Auth::user()->_id));
                } elseif ($role == 'Supervisor' && $request->status == '1') {
                    $employees = session('employees') ?: [];
                    $employees = array_merge($employees, ["999", "", new ObjectId(Auth::user()->_id), null]);
                    $query->whereIn('assaignedTo.agentId', $employees);
                }
            })
            ->orderBy('assaignedTo.groupName', 'asc')->get()
            ->unique('assaignedTo.groupName');
        foreach ($groups as $group) {
            if (isset($group->assaignedTo) && $group->assaignedTo != []) {
                array_push($swap, $group);
            }
        }

        // dd($groups);
        $groups = $swap;
        $swap = [];
        $customerAgents = Enquiries::select('assaignedTo.customerAgentId', 'assaignedTo.customerAgentName')

            ->where('mailStatus', (int) $request->status)
            ->where('documentMailBox', $request->mailbox)
            ->where('deleted', '!=', 1)
            ->where('assaignedTo.customerAgentId', '!=', "")
            ->where(function ($query) use ($role, $request) {
                if ($role == "Agent") {
                    $query->where('assaignedTo.customerAgentId', Auth::user()->_id);
                } elseif ($role == "Coordinator") {
                    $coAgent = (string) session('assigned_agent');
                    $query->where('assaignedTo.customerAgentId', $coAgent);
                } elseif ($role == 'Employee' && $request->status == '1') {
                    $query->where('assaignedTo.agentId', new ObjectId(Auth::user()->_id));
                } elseif ($role == 'Supervisor' && $request->status == '1') {
                    $employees = session('employees') ?: [];
                    $employees = array_merge($employees, ["999", "", new ObjectId(Auth::user()->_id), null]);
                    $query->whereIn('assaignedTo.agentId', $employees);
                }
            })

            ->orderBy('assaignedTo.customerAgentName', 'asc')->get()
            ->unique('assaignedTo.customerAgentId');
        foreach ($customerAgents as $customerAgent) {
            if (isset($customerAgent->assaignedTo) && $customerAgent->assaignedTo != []) {
                array_push($swap, $customerAgent);
            }
        }
        $customerAgents = $swap;
        return array($agents, $customerAgents, $customer_drop, $insurer_drop, $groups);
         */
    }

    public function emailsToExcel(Request $request)
    {
        $documentStatus = (int) $request->status;
        $user = $request->mailBox;
        $data = Enquiries::select(
            'documentMailBox',
            'subject',
            'from',
            'recieveTime',
            'assaignedTo',
            'dates',
            'note',
            'renewalDate',
            'policyAmount',
            'updated_at',
            'renewal',
            'reminderDate',
            'commissionAmount',
            'commissionPercentage'
        )->where('mailStatus', (int) $documentStatus)->where('documentMailBox', $user)->where('deleted', '!=', 1);
        if ($request->status == 1) {
            $stat = session('enquiryFilter.statusList');
            $nonstat = session('enquiryFilter.nonstatusList');
            $cust = session('enquiryFilter.customerList');
            $agen = session('enquiryFilter.agentList');
            $custAgent = session('enquiryFilter.customerAgentList');
            $insurer = session('enquiryFilter.insurerList');
            $fromDate = session('enquiryFilter.fromDateFilter');
            $toDate = session('enquiryFilter.toDateFilter');
            $renewalFilter = session('enquiryFilter.renewalFilter');
            $nonRenewalFilter = session('enquiryFilter.nonrenewalFilter');
            $group = session('enquiryFilter.GroupList');
            $key = session('ActiveSearchKey');
            $order = session('enquiryFilter.order');
        } elseif ($request->status == 0) {
            $stat = session('closedEnquiryFilter.statusList');
            $nonstat = session('closedEnquiryFilter.nonstatusList');
            $cust = session('closedEnquiryFilter.customerList');
            $agen = session('closedEnquiryFilter.agentList');
            $custAgent = session('closedEnquiryFilter.customerAgentList');
            $insurer = session('closedEnquiryFilter.insurerList');
            $fromDate = session('closedEnquiryFilter.fromDateFilter');
            $toDate = session('closedEnquiryFilter.toDateFilter');
            $renewalFilter = session('closedEnquiryFilter.renewalFilter');
            $nonRenewalFilter = session('closedEnquiryFilter.nonrenewalFilter');
            $group = session('closedEnquiryFilter.GroupList');
            $key = session('ClosedSearchKey');
        }
        if (isset($nonstat) && isset($stat) && $nonstat != '' && $stat != '') {
            $statArray = array_merge($stat, $nonstat);
            if (isset($statArray)) {
                $data->where(
                    function ($query) use ($statArray) {
                        foreach ($statArray as $status) {
                            if (count(@$status['subStatus']) > 0) {
                                $subStatus = $status['subStatus'];
                                $Status = $status['status'];
                                $query->orwhere(
                                    function ($query2) use ($subStatus, $Status) {
                                        $query2->where('assaignedTo.assaignStatusName', $Status);
                                        $query2->where(
                                            function ($query3) use ($subStatus, $Status) {
                                                foreach ($subStatus as $eachstatus) {
                                                    $query3->orWhere('assaignedTo.assaignSubStatusName', $eachstatus);
                                                }
                                            }
                                        );
                                    }
                                );
                            } else {
                                $query->orWhere('assaignedTo.assaignStatusName', $status['status']);
                            }
                        }
                    }
                );
            }
        } else {
            if (isset($nonstat)) {
                $data->where(function ($query) use ($nonstat) {
                    foreach ($nonstat as $status) {
                        if (count(@$status['subStatus']) > 0) {
                            $subStatus = $status['subStatus'];
                            $Status = $status['status'];
                            $query->orwhere(function ($query2) use ($subStatus, $Status) {
                                $query2->where('assaignedTo.assaignStatusName', $Status);
                                $query2->where(function ($query3) use ($subStatus, $Status) {
                                    foreach ($subStatus as $eachstatus) {
                                        $query3->orWhere('assaignedTo.assaignSubStatusName', $eachstatus);
                                    }
                                });
                            });
                        } else {
                            $query->orWhere('assaignedTo.assaignStatusName', $status['status']);
                        }
                    }
                });
            }
            if (isset($stat)) {
                $data->where(function ($query) use ($stat) {
                    foreach ($stat as $status) {
                        if (count(@$status['subStatus']) > 0) {
                            $subStatus = $status['subStatus'];
                            $Status = $status['status'];
                            $query->orwhere(function ($query2) use ($subStatus, $Status) {
                                $query2->where('assaignedTo.assaignStatusName', $Status);
                                $query2->where(function ($query3) use ($subStatus, $Status) {
                                    foreach ($subStatus as $eachstatus) {
                                        $query3->orWhere('assaignedTo.assaignSubStatusName', $eachstatus);
                                    }
                                });
                            });
                        } else {
                            $query->orWhere('assaignedTo.assaignStatusName', $status['status']);
                        }
                    }
                });
            }
        }
        // if (isset($nonstat) && isset($stat) && $nonstat != '' && $stat != '') {
        //     $statArray = array_merge($stat, $nonstat);
        // }
        // if (isset($stat) && !isset($nonstat)) {
        //     $data->whereIn('assaignedTo.assaignStatusName', $stat)->where('renewal', 1);
        // }
        // if (isset($nonstat) && !isset($stat)) {
        //     $data->whereIn('assaignedTo.assaignStatusName', $nonstat)->where('renewal', 0);
        // }
        // if (isset($nonstat) && isset($stat) && $nonstat != '' && $stat != '') {
        //     $data->whereIn('assaignedTo.assaignStatusName', $statArray);
        // }
        if (isset($cust)) {
            $data->whereIn('assaignedTo.customerId', $cust);
        }
        if (isset($agen)) {
            $data->whereIn('assaignedTo.agentId', $agen);
        }
        if (isset($group)) {
            $data->whereIn('assaignedTo.groupName', $group);
        }
        if (isset($custAgent)) {
            $data->whereIn('assaignedTo.customerAgentId', $custAgent);
        }
        if (isset($insurer)) {
            $data->whereIn('assaignedTo.insurerId', $insurer);
        }
        if (isset($fromDate)) {
            $fDate = Carbon::createFromFormat('!d/m/Y', $fromDate);
            $data->where('mailRecTme', '>=', $fDate);
        }
        if (isset($toDate)) {
            $TDate = Carbon::createFromFormat('!d/m/Y', $toDate);
            $todateF = $TDate->endOfDay();
            $data->where('mailRecTme', '<=', $todateF);
        }
        if (isset($renewalFilter) && !isset($nonRenewalFilter)) {
            $data->where('renewal', 1);
        }
        if (isset($nonRenewalFilter) && !isset($renewalFilter)) {
            $data->where('renewal', '!=', 1);
        }
        if (isset($nonRenewalFilter) && isset($renewalFilter)) {
            $data;
        }

        if (isset($key)) {
            $data = $data->where(
                function ($query) use ($key) {
                    $query->where('subject', 'like', '%' . $key . '%')
                        ->orWhere('mailsText', 'like', '%' . $key . '%')
                        ->orWhere('assaignedTo.customerName', 'like', '%' . $key . '%')
                        ->orWhere('assaignedTo.insurerName', 'like', '%' . $key . '%')
                        ->orWhere('attachements.attachName', 'like', '%' . $key . '%');
                }
            );
        }
        // dd($order);
        if (isset($order) && $order == 'latest') {
            $data = $data->orderBy('created_at', 'desc');
        } else if (isset($order) && $order == 'earliest') {
            $data = $data->orderBy('created_at', 'asc');
        } else {
            $data = $data->orderBy('created_at', 'desc');
        }
        $role = session('role');
        if ($role == 'Admin') {
            $data = $data->get();
        } elseif ($role == 'Employee' && $documentStatus == 1) {
            $data = $data->whereIn('assaignedTo.agentId', [new ObjectId(Auth::user()->_id), "999"])
                ->get();
        } elseif ($role == 'Employee' && $documentStatus == 0) {
            $data = $data->get();
        } elseif ($role == 'Coordinator') {
            $coAgent = (string) session('assigned_agent');
            $data = $data->where('assaignedTo.customerAgentId', $coAgent)->get();
        } elseif ($role == 'Agent') {
            $data = $data->where('assaignedTo.customerAgentId', Auth::user()->_id)
                ->get();
        } elseif ($role == 'Supervisor') {
            if ($documentStatus == 1) {
                $employees = session('employees') ?: [];
                $employees = array_merge($employees, ["999", "", new ObjectId(Auth::user()->_id), null]);
                $data->whereIn('assaignedTo.agentId', $employees);
            }
            $data = $data->get();
        } else {
            $data = [];
        }

        if ($documentStatus == 0) {
            $heading = "Completed Queue";
        } elseif ($documentStatus == 1) {
            $heading = "Active Queue";
        }

        $information = [];
        $information[] = array($heading);
        $information[] = [
            'Document MailBox',
            'Subject',
            'From',
            'Receive Date & Time',
            'Customer Name',
            'Insurer',
            'Agent',
            'Assigned To',
            'Current Status',
            'Current Sub Status',
            'From Date',
            'Expiry Date',
            'Renewal Date',
            'Reminder Date',
            'Note',
            'Policy Premium',
            'Commission Percentage',
            'Commission Amount',
            'Renewal Status',
            'Last Updated Date & Time',
            'Group Name'
        ];
        foreach ($data as $key => $value) {
            $assigned = $value->assaignedTo;
            $dates = $value->dates;
            $time = Carbon::createFromFormat('l jS \\of F Y h:i:s A', $value->recieveTime);
            $time = $time->format('d-m-Y h:i:s a');
            $lastUpdated = $value->updated_at;
            $lastUpdated = $lastUpdated->format('d-m-Y h:i:s a');
            if (isset($value->renewal) && $value->renewal == 1) {
                $renewal = 'Renewal';
            } else {
                $renewal = 'New';
            }
            if (isset($assigned['groupName'])) {
                $groupName = ucwords(strtolower($assigned['groupName']));
            } else {
                $groupName = '--';
            }
            if (isset($assigned['assaignSubStatusName'])) {
                $subStatusName = ucwords(strtolower($assigned['assaignSubStatusName']));
            } else {
                $subStatusName = '--';
            }
            $p_amount = $value->policyAmount;
            if ($p_amount) {
                $formattedPolicyAmount = number_format($p_amount, 2, '.', ',');
            } else {
                $formattedPolicyAmount = '';
            }

            $c_amount = $value->commissionAmount;
            if ($c_amount) {
                $formattedCommissionAmount = number_format($c_amount, 2, '.', ',');
            } else {
                $formattedCommissionAmount = '';
            }
            $information[] = [
                $value->documentMailBox,
                $value->subject ?: '--',
                $value->from,
                $time,
                $assigned['customerName'] ?: '--',
                $assigned['insurerName'] ?: '--',
                $assigned['customerAgentName'] ?: '--',
                $assigned['agentName'] ?: '--',
                $assigned['assaignStatusName'] ?: '--',
                $subStatusName ?: '--',
                $dates['date1'] ?: '--',
                $dates['date2'] ?: '--',
                $value->renewalDate ?: '--',
                $value->reminderDate ?: '--',
                $value->note ?: '--',
                $formattedPolicyAmount ?: '--',
                $value->commissionPercentage ?: '--',
                $formattedCommissionAmount ?: '--',
                $renewal,
                $lastUpdated,
                $groupName ?: '--'
            ];
        }
        Excel::create('Document-List', function ($excel) use ($information) {
            $excel->sheet('Email-Documents', function ($sheet) use ($information) {
                $sheet->mergeCells('A1:U1');
                $sheet->cells('A:U', function ($cells) {
                    $cells->setAlignment('center');
                });
                $sheet->row(1, function ($row) {
                    $row->setBackground('#1155CC');
                    $row->setFontColor('#ffffff');
                });
                $sheet->row(2, function ($row) {
                    $row->setBackground('#C2C2C2');
                });
                $sheet->fromArray($information, null, 'A1', true, false);



                $sheet->getStyle('P')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                $sheet->getStyle('R')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
            });
        })->download('xls');
    }


    //Enquiry settings page

    public function enquiryViewSettings()
    {
        $credentials = EnquiryCredentials::where('credentialStatus', 1)->get();
        return view('enquiry_management.enquiry_management_view_settings')
            ->with(compact('credentials'));
    }

    public function enquiryEditSettings(Request $request)
    {
        $data = EnquiryCredentials::find($request->id);
        $employees = User::where('isActive', 1)->whereIn('role', ['EM', 'SV'])->orderBy('name')->get();
        return view('enquiry_management.enquiry_management_edit_settings')
            ->with(compact('data', 'employees'));
    }

    public function editCredentials(Request $request)
    {
        $index = $request->input('credential_index');
        $username = $request->input('username');
        $check = EnquiryCredentials::where('userID', $username)
            ->where('_id', '!=', $index)->get();
        if (count($check) > 0) {
            return 0;
        }
        $password = $request->input('password');
        $confirm = $request->input('confirm_passWord');
        if ($password != $confirm) {
            return "passFail";
        }
        // $nonRenewTotal = $request->input('non_renew_total');
        // $nonRenewClosure = $request->input('cbx_nonrenew_closure');
        // if (!isset($nonRenewClosure)) {
        //     $nonRenewClosure = [];
        // }
        // $nonRenewStatusList = [];
        // for ($i = 0; $i <= $nonRenewTotal; $i++) {
        //     $statusTxt = $request->input('non_renew_status_txt_' . $i);
        //     if (isset($statusTxt)) {
        //         $statusObj = new \stdClass();
        //         $statusObj->statusName = $statusTxt;
        //         if (in_array($i, $nonRenewClosure)) {
        //             $statusObj->closureProperty = 1;
        //         } else {
        //             $statusObj->closureProperty = 0;
        //         }
        //         $nonRenewStatusList[] = $statusObj;
        //     }
        // }

        // $renewTotal = $request->input('renew_total');
        // $renewClosure = $request->input('cbx_renew_closure');
        // if (!isset($renewClosure)) {
        //     $renewClosure = [];
        // }
        // $renewStatusList = [];

        // for ($i = 0; $i <= $renewTotal; $i++) {
        //     $statusTxt = $request->input('renew_status_txt_' . $i);
        //     if (isset($statusTxt)) {
        //         $statusObj = new \stdClass();
        //         $statusObj->statusName = $statusTxt;
        //         if (in_array($i, $renewClosure)) {
        //             $statusObj->closureProperty = 1;
        //         } else {
        //             $statusObj->closureProperty = 0;
        //         }
        //         $renewStatusList[] = $statusObj;
        //     }
        // }
        if ($request->input('auto_renew') == 'true') {
            $autorenew = (int) 1;
        } else {
            $autorenew = (int) 0;
        }
        $assignEmployee = $request->input('assign_employee');
        if ($assignEmployee != '') {
            $assignEmployee = ($assignEmployee != "999") ? new ObjectId($assignEmployee) : "999";
            // if($assignEmployee== "999")
            // {
            //     $assignEmployee
            // }
            // $assignEmployee=new ObjectId($assignEmployee);
        } else {
            $assignEmployee = '';
        }
        if (EnquiryCredentials::where('_id', new ObjectId($index))
            ->update([
                'userID' => $username,
                'passWord' => $password,
                'assignEmployee' => $assignEmployee,
                'autorenew' => $autorenew
            ])
        ) {
            return 1;
        } else {
            return 0;
        }
    }



    //credential settings.............

    public function addCredentials(Request $request)
    {
        $data = new EnquiryCredentials();
        $username = $request->input('username');
        $check = EnquiryCredentials::where('userID', $username)->get();
        if (count($check) > 0) {
            return 0;
        }
        $data->userID = $username;
        $passward = $request->input('password');
        $confirm = $request->input('confirm_passWord');
        if ($passward != $confirm) {
            return "passFail";
        } else {
            $data->passWord = $passward;
        }
        $nonRenewTotal = $request->input('non_renew_total');
        $nonRenewClosure = $request->input('cbx_nonrenew_closure');
        if (!isset($nonRenewClosure)) {
            $nonRenewClosure = [];
        }
        $nonRenewStatusList = [];
        for ($i = 0; $i <= $nonRenewTotal; $i++) {
            $statusTxt = $request->input('non_renew_status_txt_' . $i);
            if (isset($statusTxt)) {
                $statusObj = new \stdClass();
                $statusObj->statusName = $statusTxt;
                if (in_array($i, $nonRenewClosure)) {
                    $statusObj->closureProperty = 1;
                } else {
                    $statusObj->closureProperty = 0;
                }
                $nonRenewStatusList[] = $statusObj;
            }
        }
        $data->nonRenewalStatus = $nonRenewStatusList;

        $renewTotal = $request->input('renew_total');
        $renewClosure = $request->input('cbx_renew_closure');
        if (!isset($renewClosure)) {
            $renewClosure = [];
        }
        $renewStatusList = [];

        for ($i = 0; $i <= $renewTotal; $i++) {
            $statusTxt = $request->input('renew_status_txt_' . $i);
            if (isset($statusTxt)) {
                $statusObj = new \stdClass();
                $statusObj->statusName = $statusTxt;
                if (in_array($i, $renewClosure)) {
                    $statusObj->closureProperty = 1;
                } else {
                    $statusObj->closureProperty = 0;
                }
                $renewStatusList[] = $statusObj;
            }
        }
        $data->renewalStatus = $renewStatusList;
        if ($request->input('auto_renew') == 'true') {
            $autorenew = (int) 1;
        } else {
            $autorenew = (int) 0;
        }
        $data->autorenew = $autorenew;
        $assignEmployee = $request->input('assign_employee');
        if ($assignEmployee != '') {
            $assignEmployee = ($assignEmployee != "999") ? new ObjectId($assignEmployee) : "999";
            // $assignEmployee=new ObjectId($assignEmployee);
        } else {
            $assignEmployee = '';
        }
        $data->credentialStatus = 1;
        $data->assignEmployee = $assignEmployee;
        if ($data->save()) {
            return 1;
        }
    }
    public function enquirySettings()
    {
        $employees = User::where('isActive', 1)->whereIn('role', ['EM', 'SV'])->orderBy('name')->get();
        return view('enquiry_management.enquiry_management_settings', ['employees' => $employees]);
    }
    //credential settings.............

    /**
     * renewal reminder
     */
    public static function renewalReminder()
    {
        date_default_timezone_set('Asia/Dubai');
        $now = date('d/m/Y');
        $data = Enquiries::where('mailStatus', 1)->where('deleted', '!=', 1)->whereNotNull('reminderDate')
            ->where('reminderDate', '=', $now)->get();
        if (isset($data) && count($data) != 0) {
            $log = new CronJobLog();
            $log->controller = 'EnquiryManagementController';
            $log->function = 'Renewal reminder';
            $log->time = date('d-m-Y h:i:s a');
            $mailIdLog = [];
            // $mailSubject=[];
            $assigneeArray = [];

            foreach ($data as $mail) {
                if (isset($mail['assaignedTo']['agentId']) && $mail['assaignedTo']['agentId'] != '') {
                    $assignee = $mail['assaignedTo']['agentId'];
                    if (!in_array($assignee, $assigneeArray)) {
                        $assigneeArray[] = $assignee;
                    }
                }
                // $mailSubject[]=$mail->subject;
            }
            if (isset($assigneeArray)) {
                $data1 = '';
                foreach ($assigneeArray as $empid) {
                    $data1 = $data->where('assaignedTo.agentId', $empid)->pluck('subject')->toArray();
                    $employee = User::find($empid);
                    if (isset($employee) && isset($employee['email']) && $employee['email'] != '') {
                        $employeeMail = $employee['email'];
                        $mailIdLog[] = $employee->name;
                        reminderRenewalMail::dispatch($employeeMail, $employee->name, $data1);

                        // Mail::to($employeeMail)->send(new sendReminderMail($employee->name, $data1));
                    }
                }
            }
            // dd($mailSubject);
            // $adminList= $employee=User::where('role', 'AD')->where('isActive', 1)->get();
            // foreach ($adminList as $list) {
            //     if (isset($list['email']) && $list['email']!='') {
            //         $mailIdLog[]=$list->name;
            //         reminderRenewalMail::dispatch($list['email'], $list->name, $mailSubject);

            //         // Mail::to($list['email'])->send(new sendReminderMail($list->name, $mailSubject));
            //     }
            // }
            $log->log = $mailIdLog;
            $log->save();
        }
        return "success";
    }

    /**
     * cron job for auto refresh ,assign automatically employee and customer
     */
    public static function refreshEnquiry()
    {
        // try {
        date_default_timezone_set('Asia/Dubai');
        $log = new CronJobLog();
        $log->controller = "not completed";
        $log->function = 'not completed';
        $log->time = date('d-m-Y h:i:s a');
        $log->save();

        $newId = $log->id;
        $log = CronJobLog::find($newId);

        $mailsFetched = 0;
        $failedCount = 0;
        $mailIdLog = [];
        $failedLog = [];
        $path = 'attachments';
        $credentials = EnquiryCredentials::where('credentialStatus', 1)->get();
        foreach ($credentials as $credential) {
            $user = $credential->userID;
            if (isset($credential->autorenew)) {
                $autorenew = $credential->autorenew;
            } else {
                $autorenew = '';
            }

            if (isset($credential->assignEmployee)) {
                $assignedEmployee = $credential->assignEmployee;
            } else {
                $assignedEmployee = '';
            }
            $notification = new Client([
                'host' => 'exmail.emirates.net.ae',
                'port' => 143,
                'encryption' => 'tls',
                'validate_cert' => false,
                'username' => $user,
                'password' => $credential->passWord,
                'protocol' => 'imap'
            ]);
            try {
                $notification->connect();
            } catch (\Webklex\IMAP\Exceptions\ConnectionFailedException $e) {
                $failedCount++;
                $msg = $e->getMessage();
                $failedLogObj = new \stdClass();
                $failedLogObj->mailBox = $user;
                $failedLogObj->desc = $msg;
                $failedLog[] = $failedLogObj;

                continue;
            }
            $inbox = $notification->getFolders()->first();
            $messages = $inbox->query()->unseen()->markAsRead()->get();
            foreach ($messages as $message) {
                $message->unsetFlag(["flagged", "seen"]);
                $messageId = $message->getMessageId();
                $cc = $message->getCc() ?: "";                                    //looping messages
                $mails = new Enquiries();
                $date = $message->getDate();                                      //receive time
                $date = $date->timezone('asia/dubai');
                $time = $date->format('l jS \\of F Y h:i:s A');
                $subject = $message->getSubject();                                //subject
                $logSubject = $subject;
                $from = $message->getFrom();                                      //from address
                $mailContent = $message->getHtmlBody();                           //html body
                $mailText = $message->getTextBody();  //text body of mail
                if ($mailContent == "<div dir=\"ltr\"><br></div>\r\n") {
                    $mailContent = "<div dir=\"ltr\"><h3> blank mail</h3></div>\r\n";
                }
                $mailContent = EnquiryManagementController::removeTag($mailContent, 'img');
                $formatTime = Carbon::createFromFormat('l jS \\of F Y h:i:s A', $time);
                $time1 = $formatTime->format('Y-m-d');
                $Sdate_format = Carbon::createFromFormat('Y-m-d', $time1, 'asia/dubai')->timestamp;
                $StartTime = new \MongoDB\BSON\UTCDateTime($Sdate_format * 1000);
                $mails->mailRecTme = $StartTime;
                $from = $from[0]->mail;
                $agentData = User::where('isActive', 1)->where('role', 'AG')
                    ->where('email', $from)->first();
                $mails->subject = $subject;
                $mails->documentMailBox = $user;
                $mails->from = $from;
                $mails->recieveTime = $time;
                $mails->mailsContent = $mailContent;
                $mails->mailsText = $mailText;
                $mails->recieveDateObject = $date;
                $mails->cc = $cc;
                $mails->messageId = $messageId;
                $newFileName = '';
                $attachmentCount = 0;
                $attachArray = [];
                if ($message->hasAttachments()) {                                  //checking if attachments exists
                    $attachments = $message->getAttachments();                    //getting attachments
                    $attachmentCount = count($attachments);
                    foreach ($attachments as $attachment) {                        //looping attachments
                        $fileName = $attachment->getName();                       //getting attachment file name
                        if (file_exists($path . '/' . $fileName)) {               //if file alreading exists
                            $baseName = pathinfo($fileName, PATHINFO_FILENAME);
                            $extension = pathinfo($fileName, PATHINFO_EXTENSION);
                            for ($i = 1;; ++$i) {
                                $fileName = $baseName . '(' . $i . ').' . $extension;
                                if (!file_exists($path . '/' . $fileName)) {             //if file alreading exists
                                    $newFileName =
                                        EnquiryManagementController::uploadFile($attachment, $path, $fileName);
                                    break;
                                }
                            }
                        } else {
                            $newFileName = EnquiryManagementController::uploadFile($attachment, $path, $fileName);
                        }
                        $uploadedFile = new LocalFile($newFileName);
                        $urlPath = EnquiryManagementController::uploadFileToCloud($uploadedFile);
                        unlink($newFileName);
                        if ($newFileName != '') {
                            //timeZone
                            $mails->isAttach = 1;
                            $attachObj = new \stdClass();
                            $attachObj->attachId = (string) time() . uniqid();
                            $attachObj->attachPath = $urlPath;
                            $attachObj->attachName = $fileName;
                            $attachObj->attachStatus = 1;
                            $attachObj->lastUpdate = date('d-m-y h:i:s a');
                            $attachArray[] = $attachObj;
                        }
                    }
                    $mails->attachements = $attachArray;
                } else {
                    $mails->isAttach = 0;
                }
                $mails->mailStatus = 1;

                $mailsFetched++;
                if ($mails->save()) {
                    $message->setFlag(["flagged", "seen"]);
                } else {
                    $message->unsetFlag(["flagged", "seen"]);
                }
                EnquiryManagementController::saveLog('New document arrived.', 'Enquiry Management', $mails->_id, $subject, $mails->documentMailBox); //save log
                //save customer name automatically
                $id = null;
                $customerAgentId = null;
                $customerAgentName = null;
                $agent = null;
                $renewal = null;
                $request = new Request();
                $ret = 0;
                $docCount = count($attachArray);
                // $mail_subj_format=Config::get('documents.default_enquiry_mail_subject');
                if (isset($agentData) && $agentData->count() != 0) {
                    $customerAgentId = (string) $agentData->_id;
                    $customerAgentName = $agentData->name;
                    $ret = 1;
                }
                // $mail_subj_format='Vehicle Insurance Renewal Notification * ';
                // $length_sub=(strlen($mail_subj_format));
                // $accurate_topic=substr($subject, 0, $length_sub);
                // $exploded_array=explode('*', $subject);
                $extractedSubject = explode('*', $subject);
                // $customerId = end($extractedSubject);

                $customerId = @$extractedSubject[1];
                $customerId = trim($customerId);
                $renewaldateInitial = @$extractedSubject[2];
                if ($renewaldateInitial) {
                    $dateArray = explode('/', $renewaldateInitial);
                    $day = @$dateArray[0];
                    $month = @$dateArray[1];
                    $year = @$dateArray[2];
                    $validdate = false;
                    if ($day && $month && $year) {
                        try {
                            $validdate = checkdate($month, $day, $year);
                        } catch (\Exception $e) {
                            $validdate = false;
                        }
                        if ($validdate) {
                            $renewalDate = $renewaldateInitial;
                            $expiryDate = $renewaldateInitial;
                        } else {
                            $renewalDate = '';
                            $expiryDate = '';
                        }
                    } else {
                        $renewalDate = '';
                        $expiryDate = '';
                    }
                } else {
                    $renewalDate = '';
                    $expiryDate = '';
                }






                $customerId = trim($customerId);
                if ($customerId) {
                    // $customer_id=trim($exploded_array[1]);
                    $customer = Customer::where('customerCode', 'like', $customerId)
                        ->where('status', (int) 1)->first();
                    if (isset($customer)) {
                        $id = $customer->_id ?: null;
                        if ($customerAgentId == null) {
                            $customerAgentId = (string) $customer['agent']['id'] ?: null;
                            $customerAgentName = $customer['agent']['name'] ?: null;
                        }
                    } else {
                        $id = null;
                        // $customerAgentId = null;
                        // $customerAgentName = null;
                    }
                    $ret = 1;
                }
                /////////////////new modification/////////////
                if ($autorenew == 1) {
                    $renewal = (int) 1;
                    $ret = 1;
                }
                if ($assignedEmployee != '') {
                    $agent = $assignedEmployee;
                    $ret = 1;
                }

                ////////////////ends///////////////////////

                // if ($user == Config::get('documents.mail_auto_renew')) {
                //     $EmployeeData=User::where('email', 'jhona@iibcare.com')->where('role', 'EM')->first();
                //     $agent=$EmployeeData->_id;
                //     $renewal=(int)1;
                //     $ret=1;
                // }
                // if ($user == Config::get('documents.mail_auto_renew1')) {
                //     $EmployeeData=User::where('email', 'lovelyza@iibcare.com')->where('role', 'EM')->first();
                //     $agent=$EmployeeData->_id;
                //     // $renewal=(int)1;
                //     $ret=1;
                // }
                // if ($user == Config::get('documents.mail_auto_renew2')) {
                //     $EmployeeData=User::where('email', 'melody@iibcare.com')->where('role', 'EM')->first();
                //     $agent=$EmployeeData->_id;
                //     // $renewal=(int)1;
                //     $ret=1;
                // }

                if ($ret == 1) {
                    $request->replace(
                        [
                            'customer' => $id, 'customerAgentId' => $customerAgentId,
                            'customerAgentName' => $customerAgentName, 'agent' => $agent,
                            'renewal' => $renewal, 'mailId' => $mails->_id,
                            'updateAttachName' => null, 'renewal_date' => $renewalDate
                        ]
                    );
                    $val = EnquiryManagementController::asignDocument($request);
                }
                ///////ends/////////
                $logObj = new \stdClass();
                $logObj->mailBox = $user;
                $logObj->inboxMailId = $messageId;
                $logObj->insertedId = $mails->id;
                $logObj->subject = $logSubject;
                $logObj->attachmentsCount = $attachmentCount;
                $logObj->attachDifference = ($attachmentCount - $docCount);
                $mailIdLog[] = $logObj;
            }
            $log->controller = 'EnquiryManagementController';
            $log->function = 'refreshEnquiry';
            $log->mailsFetched = $mailsFetched;
            $log->successLog = $mailIdLog;
            $log->failedLog = $failedLog;
            $log->failed = $failedCount;
            $log->save();
        }
        $log->controller = 'EnquiryManagementController';
        $log->function = 'refreshEnquiry';
        $log->mailsFetched = $mailsFetched;
        $log->successLog = $mailIdLog;
        $log->failedLog = $failedLog;
        $log->failed = $failedCount;
        $log->save();
        return "success";
        // } catch (\Exception $e) {
        //     return;
        // }
    }

    public function getAgent(Request $request)
    {
        $page = $request->input('page');
        $page = $page ?: 1;

        if ($request->input('q')) {
            $agents = User::where('isActive', 1)
                ->whereIn('role', ['EM', 'SV'])
                ->where('name', 'like', $request->input('q') . '%')->orderBy('name')->get();
            if (count($agents) == 0) {
                $agents = User::where('isActive', 1)
                    ->whereIn('role', ['EM', 'SV'])
                    ->where('name', 'like', '%' . $request->input('q') . '%')->orderBy('name')->get();
            }
        } else {
            $agents = User::where('isActive', 1)
                ->whereIn('role', ['EM', 'SV'])
                ->take(10)->orderBy('name')->get();
        }
        foreach ($agents as $agent) {
            $agent->text = $agent->name;
            $agent->id = $agent->_id;
            $agent->name = $agent->name;
            $agent->employeeID = $agent->empID ? $agent->empID : "ID not available";
        }
        $count = count($agents);
        // dd($count);
        if (count($agents) > 0 && $page == 1) {
            $newData = Collection::make(
                [
                    [
                        'text' => 'All',
                        'id' => 999,
                        'name' => 'All',
                        'employeeID' => 'ID not available'
                    ]
                ]
            );
            $agents = $newData->merge($agents);
        }
        $data = array(
            'total_count' => $count,
            'incomplete_results' => false,
            'items' => $agents,
        );

        return json_encode($data);
    }
    /**
     * function for customer search
     */
    public function getCustomerManagement(Request $request, $box, $mailStatus)
    {
        $customers = Customer::where('status', (int) 1);
        if (!empty($request->input('q'))) {
            $customers = $customers->where(function ($q) use ($request) {
                $q->where('fullName', 'like', $request->input('q') . '%');
            });
            $customers = $customers->orderBy('fullName')->get();
            if (count($customers) == 0) {
                $customers = Customer::where('status', (int) 1);
                if (!empty($request->input('q'))) {
                    $customers = $customers->where(function ($q) use ($request) {
                        $q->where('fullName', 'like', '%' . $request->input('q') . '%');
                    });
                }
                $customers = $customers->orderBy('fullName')->get();
            }
        } else {
            $customers = $customers->take(10)->orderBy('fullName')->get();
        }
        foreach ($customers as $customer) {
            $customer->id =  $customer->_id;
            $customer->text = $customer->fullName;
            $customer->name = $customer->fullName;
        }
        $data = array(
            'total_count' => count($customers),
            'incomplete_results' => false,
            'items' => $customers,
        );
        return json_encode($data);
    }

    /**
     * function for insurer search
     */
    public function getInsurerManagement(Request $request, $box, $mailStatus)
    {
        $customers = Insurer::where('isActive', 1);
        if (!empty($request->input('q'))) {
            $customers = $customers->where(function ($q) use ($request) {
                $q->where('name', 'like', $request->input('q') . '%');
            });
            $customers = $customers->orderBy('name')->get();
            if (count($customers) == 0) {
                $customers = Insurer::where('isActive', 1);
                if (!empty($request->input('q'))) {
                    $customers = $customers->where(function ($q) use ($request) {
                        $q->where('name', 'like', $request->input('q') . '%');
                    });
                }
                $customers = $customers->orderBy('name')->get();
            }
        } else {
            $customers = $customers->take(10)->orderBy('name')->get();
        }
        foreach ($customers as $customer) {
            $customer->id = $customer->_id;
            $customer->text = $customer->name;
            $customer->name = $customer->name;
        }
        $data = array(
            'total_count' => count($customers),
            'incomplete_results' => false,
            'items' => $customers
        );
        return json_encode($data);
    }

    /**
     * upload agent
     */
    public function uploadInsurerBulk()
    {
        $insures = Insurer::pluck('name')->toArray();
        // dd($insures);
        $excel = public_path('/dispatch/InsCompView.xls');
        Excel::load($excel, function ($reader) use ($insures) {
            $reader->each(function ($sheet) use ($insures) {
                foreach ($sheet as $sheetVal) {
                    if (!in_array($sheetVal, $insures)) {
                        $excelUpload = new Insurer();
                        $excelUpload->name = strtoupper(trim($sheetVal));
                        $excelUpload->isActive = (int) 1;
                        $excelUpload->save();
                    }
                }
            });
        });
        return 'success';
    }

    public function convertId()
    {
        $enquiryData = Enquiries::all();
        $count = 0;
        foreach ($enquiryData as $enquiry) {
            if (isset($enquiry['assaignedTo'])) {
                if (
                    isset($enquiry['assaignedTo']['customerAgentId']) &&
                    $enquiry['assaignedTo']['customerAgentId'] != ''
                ) {
                    Enquiries::where('_id', new ObjectId($enquiry->_id))->update([
                        'assaignedTo.customerAgentId' => (string) $enquiry['assaignedTo']['customerAgentId']
                    ]);
                    $count++;
                }
            }
        }
        return $count;
    }
    /**
     * to get the agent details of the selected customer
     */
    public function getAgentDetails(Request $req)
    {
        $response = [];
        $agent = Customer::select('agent')->where('_id', new ObjectId($req->customer))->first();
        $customerDetails = Customer::find($req->customer);
        if (isset($customerDetails->agent['id'])) {
            $agent = $customerDetails->agent['id'];
        } else {
            $agent = '';
        }
        $allAgents = User::where('isActive', 1)->where(function ($q) {
            $q->where('role', 'AG');
        })->orderBy('name')->get();
        foreach ($allAgents as $single) {
            if ($single['_id'] == $agent) {
                $response[] = "<option value='$single->id' selected>$single->name</option>";
            } else {
                $response[] = "<option value='$single->id' >$single->name</option>";
            }
        }
        $string_version = implode(',', $response);
        return response()->json([
            'success' => true,
            'response' => $string_version
        ]);
    }

    public function deleteEnquiry(Request $request)
    {
        if (session('role') == 'Admin') {
            Enquiries::where('_id', $request->index)->update(['deleted' => (int) 1]);
            $mails = Enquiries::select('subject', 'documentMailBox')->find($request->index);
            EnquiryManagementController::saveLog('Document deleted.', 'Enquiry Management', $request->index, $mails->subject, $mails->documentMailBox); //save log
            $response = ['status' => 'success'];
            return $response;
        }
    }

    /**
     * gets all attachments of the given mail id.
     */
    public function findAttachments(Request $req)
    {
        $collect = Enquiries::select('attachements')->find(new ObjectId($req->index));
        if ($collect) {
            $collect = $collect->attachements;
            foreach ($collect as $key => $doc) {
                $collect[$key] = array_except(
                    $collect[$key],
                    [
                        'attachContent',
                        'attachStatus',
                        'lastUpdate',
                        'isPostedToCustomer',
                        'postedToCustomerIndex',
                        'updatedName',
                        'updatedFullName',
                        'suffix'
                    ]
                );
            }
        }

        return $collect;
    }
    /**
     * save activty log
     */
    public static function saveLog($actionName, $moduleInfo, $applicationId, $subject, $mailBox)
    {
        // dd($actionName, $moduleInfo, $applicationId, $subject, $mailBox);
        if (!Auth::user()) {
            $id = '';
            $name = '';
            $role = '';
        } else {
            $id = new ObjectId(Auth::user()->_id);
            $name = Auth::user()->name;
            $role = Auth::user()->role;
        }
        $actionDoneByObject = new \stdClass();
        $actionDoneByObject->id = $id;
        $actionDoneByObject->name = $name;
        $actionDoneByObject->role = $role;
        $activityLog = new ActivityLog();
        $activityLog->actionName = $actionName;
        $activityLog->actionDoneBy = $actionDoneByObject;
        date_default_timezone_set('Asia/Dubai');
        $now = date('d-m-Y h:i:s a');
        $utcDate = date_create_from_format('d-m-Y h:i:s a', $now);
        $utcDate->setTimezone(new \DateTimeZone('UTC'));
        $utcDate = $utcDate->format(DATE_ATOM);

        $activityLog->updateDate = $utcDate;
        $activityLog->moduleInfo = $moduleInfo;
        $activityLog->applicationId = new ObjectId($applicationId);
        $activityLog->subject = $subject;
        $activityLog->mailBox = $mailBox;
        $enqCred = EnquiryCredentials::where('userID', $mailBox)->where('credentialStatus', 1)->first();
        $activityLog->mailBoxID = new ObjectId($enqCred->_id);
        $activityLog->save();
    }

    /**
     * view action level report page
     */
    public function viewActionReport()
    {
        $mailBoxes = EnquiryCredentials::where('credentialStatus', 1)->get();
        return view('enquiry_management.view_report', ['mailBoxes' => $mailBoxes]);
    }

    /**
     * download action report
     */
    public function downloadActionReport(Request $request)
    {
        $mailbox = $request->input('selectMailBox');
        $fromdate = $request->input('fromDate');
        $todate = $request->input('toDate');
        $fromdate = Carbon::createFromFormat('!d/m/Y', $fromdate);
        $todate = Carbon::createFromFormat('!d/m/Y', $todate);
        $todate = $todate->addDays(1);
        $activityLog = ActivityLog::select(
            'subject',
            'actionName',
            'actionDoneBy',
            'updateDate',
            'mailBox',
            'mailBoxID',
            'created_at'
        )
            ->where('created_at', '>=', $fromdate)
            ->where('created_at', '<=', $todate)
            ->where('mailBoxID', new ObjectId($mailbox))
            ->get();
        $data[] = array('Action level report');
        $data[] = [
            'MAIL BOX',
            'SUBJECT',
            'ACTION',
            'UPDATED BY',
            'UPDATED DATE & TIME'
        ];
        foreach ($activityLog as $log) {
            $subject = $log->subject;
            $action = $log->actionName;
            $actionUpdatedBY = $log->actionDoneBy['name'];
            $updatedTime = $log->created_at->format('d-m-Y h:i:s a');
            $mailBox = $log->mailBox;
            $data[] = array(
                $mailBox,
                $subject ?: '--',
                $action,
                $actionUpdatedBY ?: '--',
                $updatedTime
            );
        }
        if ($activityLog->count() == 0) {
            $data[] = array('No documents found');
        }
        Excel::create('Action Level Report', function ($excel) use ($data) {
            $excel->sheet('Action Level Report', function ($sheet) use ($data) {
                $sheet->mergeCells('A1:E1');
                $sheet->cells('A1:E1', function ($cells) {
                    $cells->setAlignment('center');
                });
                $sheet->row(1, function ($row) {
                    $row->setBackground('#1155CC');
                    $row->setFontColor('#ffffff');
                });
                $sheet->row(2, function ($row) {
                    $row->setBackground('#C2C2C2');
                });
                $sheet->fromArray($data, null, 'A1', true, false);
            });
        })->download('xls');
        // return 'success';
        // $mailBoxes = EnquiryCredentials::where('credentialStatus', 1)->get();
        // return view('enquiry_management.view_report', ['mailBoxes' => $mailBoxes]);
    }


    ////////////////Migrations//////////////////////////////////////////


    /* to set customer for those mails which has no customer selected yet.
    but the subject line meant the customer that should be selected */
    public function setCustomerForOldTasks()
    {
        // $q=Enquiries::where('mailStatus', 1)
        //         ->where('documentMailBox', 'test3@iibcare.ae')
        //         ->unset(['assaignedTo','isassigned']);
        // dd($q);

        $tasks = Enquiries::where(function ($query) {
            $query->where('assaignedTo.customerId', "")
                ->orWhere('assaignedTo', null);
        })->where('mailStatus', 1)->get();
        $count = 0;
        $tot = count($tasks);
        $arr = [];
        $arr1 = [];
        foreach ($tasks as $task) {
            $req = new Request();
            $extract = explode('*', $task->subject);
            $extract = array_map('trim', $extract);
            $id = end($extract);
            $customer = Customer::select('_id', 'agent')->where('customerCode', 'like', $id)->first();
            $custId = $customer ? $customer->_id : "";
            $customerAgentId = $customer ? $customer->agent : "";
            $customerAgentId = $customerAgentId ? (string) $customerAgentId['id'] : "";
            if ($custId) {
                $renew = @$task->renewal ? (int) $task->renewal : (int) 0;
                $req->replace([
                    'customer' => $custId,
                    'mailId' => $task->_id,
                    'customerAgentId' => $customerAgentId,
                    'renewal' => $renew
                ]);
                $x = $this->asignDocument($req);
                $arr[] = $task->_id;
                $arr1[] = $renew;
                $count++;
            }
        }
        dd($arr, $tot, $count, $arr1);
    }
    public function changeDateFormat()
    {
        $enquiries = Enquiries::all();
        // $enq=Enquiries::find('5d11ca4c25946b42fe6b5864');
        foreach ($enquiries as $enq) {
            if (isset($enq->recieveTime) && $enq->recieveTime != '') {
                $recveTime = $enq->recieveTime;
                $formatTime = Carbon::createFromFormat('l jS \\of F Y h:i:s A', $recveTime);
                $time = $formatTime->format('Y-m-d');
                $Sdate_format = Carbon::createFromFormat('Y-m-d', $time, 'asia/dubai')->timestamp;
                $StartTime = new \MongoDB\BSON\UTCDateTime($Sdate_format * 1000);

                $enq->mailRecTme = $StartTime;
                $enq->save();
            }
        }
        die();
    }

    /**
     * function for add and edit group details
     */
    public function enquiryGroupSettings($id)
    {
        $data = EnquiryCredentials::find($id);
        if (isset($data)) {
            return view('enquiry_management.enquiry_management_group')->with(compact('data'));
        }
    }
    /**
     * add group details
     */
    public function addGroupData(Request $request)
    {
        $groupName = $request->input('groupName');
        $id = $request->input('credential_index');
        $credential = EnquiryCredentials::find($id);
        $grpArray = [];
        foreach ($groupName as $grp) {
            $grpArray[] = ucwords(strtolower($grp));
        }
        $credential->groups = $grpArray;
        $credential->save();
        return response()->json([
            'success' => true,
            'response' => "success"
        ]);
    }
    /**
     * add sub status pages
     */
    public function enquirySubstatus($credentialId)
    {
        $data = EnquiryCredentials::find($credentialId);
        $renewSubStatus = $data['renewalStatus'] ?: '[]';
        // if(!empty($renewSubStatus)){

        // }
        $nonRenewSubStatus = $data['nonRenewalStatus'] ?: '[]';
        if (isset($data)) {
            return view('enquiry_management.enquiry_status')->with(compact('data', 'renewSubStatus', 'nonRenewSubStatus'));
        }
    }

    /**
     * get sub status of selected status
     */
    public function getSubStatus(Request $request)
    {
        $selectedValue = $request->selectedValue;
        $selectedId = $request->selectedId;
        // dd($selectedValue);
        $id = $request->id;
        $enquiryCredenetial = EnquiryCredentials::find(new ObjectId($id));
        if ($selectedId == 'Renewal') {
            $renew = $enquiryCredenetial->renewalStatus;
            foreach ($renew as $renewStatus => $rStatus) {
                if ($rStatus['statusName'] == $selectedValue && (isset($rStatus['subStatus']) || !empty($rStatus['subStatus']))) {
                    $RenewStatusView = view(
                        'enquiry_management.subStatusView',
                        ['renewStatus' => $rStatus['subStatus']]
                    )->render();
                    return response()->json(['success' => true, 'response' => $RenewStatusView, 'item' => 'renew']);
                    break;
                } elseif ($rStatus['statusName'] == $selectedValue && (isset($rStatus['subStatus']) || empty($rStatus['subStatus']))) {
                    $RenewStatusView = view(
                        'enquiry_management.subStatusView',
                        ['renewStatus' => []]
                    )->render();
                    return response()->json(['success' => true, 'response' => $RenewStatusView, 'item' => 'renew']);
                    break;
                }
            }
        } elseif ($selectedId == 'Non Renewal') {
            $nonRenew = $enquiryCredenetial->nonRenewalStatus;
            foreach ($nonRenew as $nonRenewStatus => $nStatus) {
                if ($nStatus['statusName'] == $selectedValue && (isset($nStatus['subStatus']) || !empty($nStatus['subStatus']))) {
                    $nonRenewStatusView = view(
                        'enquiry_management.nonSubStatusView',
                        ['nonenewStatus' => $nStatus['subStatus']]
                    )->render();
                    return response()->json(['success' => true, 'response' => $nonRenewStatusView, 'item' => 'nonRenew']);
                    break;
                } elseif ($nStatus['statusName'] == $selectedValue && (!isset($nStatus['subStatus']) || empty($nStatus['subStatus']))) {
                    $nonRenewStatusView = view(
                        'enquiry_management.nonSubStatusView',
                        ['nonenewStatus' => []]
                    )->render();
                    return response()->json(['success' => true, 'response' => $nonRenewStatusView, 'item' => 'nonRenew']);
                    break;
                }
            }
        }
    }
    /**
     * add sub status
     */
    public function addSubStatus(Request $request)
    {
        $id = $request->input('credential');
        $Status = $request->input('selectedStatus');
        $typeselect = $request->input('typeselect');
        $subStatus = $request->input('subStatus');
        $subStatusNon = $request->input('subStatusNon');
        // dd($subStatus);
        // dd($subStatusNon);
        $subNonArray = [];
        if ($typeselect == 'Non Renewal' && !empty($subStatusNon)) {
            foreach ($subStatusNon as $subNon) {
                $subNonArray[] = ucwords(strtolower($subNon));
            }
        }
        $subArray = [];
        if ($typeselect == 'Renewal' && !empty($subStatus)) {
            foreach ($subStatus as $subStatusname) {
                $subArray[] = ucwords(strtolower($subStatusname));
            }
        }
        $enquiryCredenetial = EnquiryCredentials::find($id);
        if ($typeselect == 'Renewal') {
            $renew = $enquiryCredenetial->renewalStatus;
            foreach ($renew as $count => $rStatus) {
                if ($rStatus['statusName'] == $Status) {
                    EnquiryCredentials::where(
                        '_id',
                        new ObjectId($id)
                    )->update(array(
                        'renewalStatus.' . $count . '.subStatus' => $subArray
                    ));
                }
            }
        }
        if ($typeselect == 'Non Renewal') {
            $nonrenew = $enquiryCredenetial->nonRenewalStatus;
            foreach ($nonrenew as $countnon => $nStatus) {
                if ($nStatus['statusName'] == $Status) {
                    EnquiryCredentials::where(
                        '_id',
                        new ObjectId($id)
                    )->update(array(
                        'nonRenewalStatus.' . $countnon . '.subStatus' => $subNonArray
                    ));
                }
            }
        }
        return response()->json(['success' => true]);
    }

    /**
     * get sub status for documents
     */
    public function getSubstatusList(Request $request)
    {
        $id = $request->input('mailId');
        $status = $request->input('status');
        $renew = $request->input('renewal');

        $mailData = EnquiryCredentials::find(new ObjectId($id));
        $response = [];
        if ($renew == "true") {
            $renewal = $mailData->renewalStatus;
            foreach ($renewal as $renew) {
                if ($renew['statusName'] == $status && (isset($renew['subStatus']) || !empty($renew['subStatus']))) {
                    $response[] = "<option value=''>Select Sub Status</option>";
                    foreach ($renew['subStatus'] as $subStatus) {
                        $response[] = "<option value='$subStatus'>$subStatus</option>";
                    }
                    break;
                }
            }
            if (empty($response)) {
                $response[] = "<option value=''>No sub status</option>";
            }
        }
        if ($renew == "false") {
            $nonrenewal = $mailData->nonRenewalStatus;
            $renewal = $mailData->renewalStatus;
            foreach ($nonrenewal as $nonrenew) {
                if ($nonrenew['statusName'] == $status && (isset($nonrenew['subStatus']) || !empty($nonrenew['subStatus']))) {
                    $response[] = "<option value=''>Select Sub Status</option>";
                    foreach ($nonrenew['subStatus'] as $subStatus) {
                        $response[] = "<option value='$subStatus'>$subStatus</option>";
                    }
                    break;
                }
            }
            if (empty($response)) {
                $response[] = "<option value=''>No sub status</option>";
            }
        }
        return response()->json(['success' => true, 'response' => $response]);
    }

    /**
     * get status
     */
    public function getStatus(Request $request)
    {
        $id = $request->input('id');
        $selectedValue = $request->input('selectedValue');
        $enquiryCredenetial = EnquiryCredentials::find($id);
        $status = [];
        if ($selectedValue == 'Renewal' && !empty($enquiryCredenetial->renewalStatus)) {
            $status = $enquiryCredenetial->renewalStatus;
        } elseif ($selectedValue == 'Non Renewal' && !empty($enquiryCredenetial->nonRenewalStatus)) {
            $status = $enquiryCredenetial->nonRenewalStatus;
        }

        $StatusView = view(
            'enquiry_management.status_view',
            ['enquiryCredenetial' => $enquiryCredenetial, 'status' => $status]
        )->render();
        return response()->json(['success' => true, 'response' => $StatusView, 'item' => $selectedValue]);
    }

    /**
     * add status
     */
    public function addStatus(Request $request)
    {
        $status = $request->input('Status');
        $checkHidden = $request->input('checkHidden');
        $StatusHidden = $request->input('StatusHidden');
        $credential_index = $request->input('credential_index');
        $enquiryCredenetial = EnquiryCredentials::find(new ObjectId($credential_index));
        $type = $request->input('type');
        $stats = [];
        $uniqueValue = [];
        if (!isset($enquiryCredenetial->renewalStatus) || empty($enquiryCredenetial->renewalStatus)) {
            if ($type == "Renewal" && !empty($status) && !empty($checkHidden)) {
                foreach ($status as $key => $stat) {
                    $statusObj = new \stdClass();
                    $statusName = ucwords(strtolower($stat));
                    $statusObj->statusName = $statusName;
                    $statusObj->uniqueValue = uniqid();
                    $statusObj->closureProperty = $checkHidden[$key];
                    $stats[] = $statusObj;
                }
                EnquiryCredentials::where('_id', new ObjectId($credential_index))
                    ->update([
                        'renewalStatus' => $stats
                    ]);
            }
        } else {
            if ($type == "Renewal" && !empty($status) && !empty($checkHidden)) {
                $renew = $enquiryCredenetial->renewalStatus;
                foreach ($renew as $count => $renewStatus) {
                    $uniqueValue[] = $renewStatus['uniqueValue'];
                }

                // dd($StatusHidden);
                foreach ($status as $count => $RenewStatus) {
                    if (in_array($StatusHidden[$count], $uniqueValue)) {
                        EnquiryCredentials::where(
                            '_id',
                            new ObjectId($credential_index)
                        )->update(array(
                            'renewalStatus.' . $count . '.statusName' => $status[$count],
                            'renewalStatus.' . $count . '.closureProperty' => $checkHidden[$count]
                        ));
                    } else {
                        $statusObj = new \stdClass();
                        $statusName = ucwords(strtolower($status[$count]));
                        $statusObj->statusName = $statusName;
                        $statusObj->uniqueValue = uniqid();
                        $statusObj->closureProperty = $checkHidden[$count];
                        $stats[] = $statusObj;
                        // $enquiryCredenetial->renewalStatus;
                        EnquiryCredentials::where('_id', new ObjectId($credential_index))
                            ->push('renewalStatus', $statusObj);
                    }
                }
                foreach ($uniqueValue as $countUn => $unq) {
                    if (!in_array($unq, $StatusHidden)) {
                        EnquiryCredentials::where('_id', new ObjectId($credential_index))->pull('renewalStatus', ['uniqueValue' => $unq]);
                    }
                }
            }
        }
        if (!isset($enquiryCredenetial->nonRenewalStatus) || empty($enquiryCredenetial->nonRenewalStatus)) {
            if ($type == "Non Renewal" && !empty($status) && !empty($checkHidden)) {
                foreach ($status as $key => $stat) {
                    $statusObj = new \stdClass();
                    $statusName = ucwords(strtolower($stat));
                    $statusObj->statusName = $statusName;
                    $statusObj->uniqueValue = uniqid();
                    $statusObj->closureProperty = $checkHidden[$key];
                    $stats[] = $statusObj;
                }
                EnquiryCredentials::where('_id', new ObjectId($credential_index))
                    ->update([
                        'nonRenewalStatus' => $stats
                    ]);
            }
        } else {
            if ($type == "Non Renewal" && !empty($status) && !empty($checkHidden)) {
                $nonrenew = $enquiryCredenetial->nonRenewalStatus;
                foreach ($nonrenew as $count => $nonrenewStatus) {
                    $uniqueValue[] = $nonrenewStatus['uniqueValue'];
                }
                foreach ($status as $count => $nrenewStatus) {
                    if (in_array($StatusHidden[$count], $uniqueValue)) {
                        EnquiryCredentials::where(
                            '_id',
                            new ObjectId($credential_index)
                        )->update(array(
                            'nonRenewalStatus.' . $count . '.statusName' => $status[$count],
                            'nonRenewalStatus.' . $count . '.closureProperty' => $checkHidden[$count]
                        ));
                    } else {
                        $statusObj = new \stdClass();
                        $statusName = ucwords(strtolower($status[$count]));
                        $statusObj->statusName = $statusName;
                        $statusObj->uniqueValue = uniqid();
                        $statusObj->closureProperty = $checkHidden[$count];
                        $stats[] = $statusObj;
                        EnquiryCredentials::where('_id', new ObjectId($credential_index))
                            ->push('nonRenewalStatus', $statusObj);
                    }
                }
                foreach ($uniqueValue as $countUn => $unq) {
                    if (!in_array($unq, $StatusHidden)) {
                        EnquiryCredentials::where('_id', new ObjectId($credential_index))->pull('nonRenewalStatus', ['uniqueValue' => $unq]);
                    }
                }
            }
        }
        return response()->json(['success' => true, 'item' => $type]);
    }
    /**
     * add unique id
     */
    public function addUniq()
    {
        $mailBox = EnquiryCredentials::where('credentialStatus', 1)->get();
        foreach ($mailBox as $box) {
            if (isset($box->nonRenewalStatus) && !empty($box->nonRenewalStatus)) {
                $nonRenwl = $box->nonRenewalStatus;
                foreach ($nonRenwl as $cnt => $stat) {
                    if (!isset($stat['uniqueValue'])) {
                        EnquiryCredentials::where(
                            '_id',
                            new ObjectId($box->_id)
                        )->update(array('nonRenewalStatus.' . $cnt . '.uniqueValue' => uniqid()));
                    }
                }
            }
            if (isset($box->renewalStatus) && !empty($box->renewalStatus)) {
                $Renwl = $box->renewalStatus;
                foreach ($Renwl as $cnt => $stat) {
                    if (!isset($stat['uniqueValue'])) {
                        EnquiryCredentials::where(
                            '_id',
                            new ObjectId($box->_id)
                        )->update(array('renewalStatus.' . $cnt . '.uniqueValue' => uniqid()));
                    }
                }
            }
        }
        echo "success";
    }
}
