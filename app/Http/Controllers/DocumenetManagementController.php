<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Emails;
use App\CustomerDocuments;
use App\SharedDocuments;
use App\Customer;
use App\RecipientDetails;
use App\CronJobLog;
use App\User;
use App\EmailCredentials;
use Webklex\IMAP\Client;
use MongoDB\BSON\ObjectId;
use App\Jobs\ForwardMail;
use App\Jobs\PostToCustomer;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\PdfToText\Pdf as PdfToText;

use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\File\File as LocalFile;
use Mockery\CountValidator\Exception;
use App\PostDocumentMails;
use Spatie\PdfToText\Exceptions as PdfException;

class DocumenetManagementController extends Controller
{
    /**
     * view document operation page.
     */
    public function __construct()
    {
        $this->middleware('auth.underwriter', ['except' => [ 'download', 'customerDocumentView','customerView','searchCustomerDocument']]);
    }
    public function documentDashboard()
    {
        session()->forget('dispatch');
        session(['dispatch' => 'Document']);
        session()->pull('customer_view');
        session()->pull('closedDocumentFilter');
        session()->pull('closedSearchKey');
        session()->pull('documentFilter');
        session()->pull('activeSearchKey');
        return view('document_management.document_dashboard');
    }

    /**
     * view document  "not used yet".
     */
    public function viewDocument()
    {
        return view('document_management.document_management');
    }

    /**
     * to sort the documents in selected order
     */
    public function dynamicSort(Request $request)
    {
        $order = $request->input('order');
        session(['documentFilter.order' => $order]);
        $result = $this->buildQuery($request, $order);
        $documentOperation = $result['page'];
        $countMails = $result['count'];

        return response()->json([
            'status' => 'success', 'documentOperation' => $documentOperation,
            'countMails' => $countMails
        ]);

    }

    /**
     * to build frequently used query, and view "document_search.blade.php"
     */
    protected function buildQuery($request, $order = null)
    {
        $paginationFactor = (int) Config::get('documents.pagination_factor');
        $documentStatus = $request->status;
        $mailBox = EmailCredentials::find($request->mailBox);
        $user = $mailBox->userID;
        $data = Emails::where('mailStatus', (int) $documentStatus)->where('documentMailBox', $user)
            ->where('deleted', '!=', 1);
        if ($request->status == 1) {
            $stat = session('documentFilter.statusList');
            $cust = session('documentFilter.customerList');
            $agen = session('documentFilter.agentList');
            $custAgent = session('documentFilter.customerAgentList');
            $mailFrom = session('documentFilter.from');
            $fromDate = session('documentFilter.fromDate');
            $toDate = session('documentFilter.toDate');
            $key = session('activeSearchKey');
            $order = session('documentFilter.order');
        } elseif ($request->status == 0) {
            $stat = session('closedDocumentFilter.statusList');
            $cust = session('closedDocumentFilter.customerList');
            $agen = session('closedDocumentFilter.agentList');
            $custAgent = session('closedDocumentFilter.customerAgentList');
            $mailFrom = session('closedDocumentFilter.from');
            $fromDate = session('closedDocumentFilter.fromDate');
            $toDate = session('closedDocumentFilter.toDate');
            $key = session('closedSearchKey');
        }
        if (isset($fromDate)) {
            $data->where('mailRecTime', '>=', $fromDate);
        }
        if (isset($toDate)) {
            $data->where('mailRecTime', '<=', $toDate);
        }
        if (isset($mailFrom)) {
            $data->whereIn('from', $mailFrom);
        }
        if (isset($stat)) {
            $data->whereIn('assaignedTo.assaignStatusName', $stat);
        }
        if (isset($cust)) {
            $data->whereIn('assaignedTo.customerId', $cust);
        }
        if (isset($agen)) {
            $data->whereIn('assaignedTo.agentId', $agen);
        }
        if (isset($custAgent)) {
            $data->whereIn('assaignedTo.customerAgentId', $custAgent);
        }
        if ($key != "") {
            $data = $data->where(function ($query) use ($key) {
                $query->where('subject', 'like', '%' . $key . '%')
                    ->orWhere('mailsText', 'like', '%' . $key . '%')
                    ->orWhere('attachements.attachName', 'like', '%' . $key . '%')
                    ->orWhere('attachements.attachContent', 'like', '%' . $key . '%');
            });
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
        if (isset($order) && $order == "latest") {
            $data->orderBy('created_at', 'desc');
        }
        $countMails = $data->count();
        $data = $data->skip(0)->take($paginationFactor)->get();
        $mailBoxes = EmailCredentials::where('credentialStatus', 1)->get();
        if ($request->status == 1) {
            $documentOperation = view(
                'document_management.document_search',
                [
                    'data' => $data,
                    'mailBoxes' => $mailBoxes,
                    'user' => $user,
                    'countMails' => $countMails
                ]
            )->render();
        } elseif ($request->status == 0) {
            $documentOperation = view(
                'document_management.closed_document_search',
                [
                    'data' => $data,
                    'mailBoxes' => $mailBoxes,
                    'user' => $user,
                    'countMails' => $countMails
                ]
            )->render();
        }
        return array(
            "page" => $documentOperation,
            "count" => $countMails
        );
    }

    /**
     * view document in completed queue.
     */
    public function closedDocuments(Request $request)
    {
        $start = $request->page;
        $filterMethod = $request->filterMethod;
        if ($start == '') {
            $start = 0;
        }
        $length = (int) Config::get('documents.pagination_factor');
        $countMails = 0;
        $old = session('closedOldCache');
        $user = $request->box;
        $result = EmailCredentials::find($user);
        $user = $result->userID;
        if ($old != $user) {
            session()->pull('closedDocumentFilter');
            session()->pull('closedSearchKey');
        }
        $data = Emails::where('mailStatus', 0)->where('documentMailBox', $user)->where('deleted', '!=', 1);
        $stat = session('closedDocumentFilter.statusList');
        $cust = session('closedDocumentFilter.customerList');
        $agen = session('closedDocumentFilter.agentList');
        $custAgent = session('closedDocumentFilter.customerAgentList');
        $mailFrom = session('closedDocumentFilter.from');
        $fromDate = session('closedDocumentFilter.fromDate');
        $toDate = session('closedDocumentFilter.toDate');
        $searchKey = session('closedSearchKey');
        $order = session('closedDocumentFilter.order');
        if (isset($fromDate)) {
            $data->where('mailRecTime', '>=', $fromDate);
        }
        if (isset($toDate)) {
            $data->where('mailRecTime', '<=', $toDate);
        }
        if (isset($mailFrom)) {
            $data->whereIn('from', $mailFrom);
        }
        if (isset($stat)) {
            $data->whereIn('assaignedTo.assaignStatusName', $stat);
        }
        $arr = [];
        if (isset($cust)) {
            $data->whereIn('assaignedTo.customerId', $cust);
        }
        $arr = [];
        if (isset($agen)) {
            $data->whereIn('assaignedTo.agentId', $agen);
        }
        if (isset($custAgent)) {
            $data->whereIn('assaignedTo.customerAgentId', $custAgent);
        }
        if (isset($searchKey)) {
            $data->where(function ($query) use ($searchKey) {
                $query->where('subject', 'like', '%' . $searchKey . '%')
                    ->orWhere('mailsText', 'like', '%' . $searchKey . '%')
                    ->orWhere('attachements.attachName', 'like', '%' . $searchKey . '%')
                    ->orWhere('attachements.attachContent', 'like', '%' . $searchKey . '%');
            });
        }
        if (session('role') == 'Agent') {
            $data->where('assaignedTo.customerAgentId', Auth::user()->_id);
        } elseif (session('role') == 'Coordinator') {
            $coAgent = (string) session('assigned_agent');
            $data->where('assaignedTo.customerAgentId', $coAgent);
        }
        if (isset($order) && $order == "latest") {
            $data = $data->orderBy('created_at', 'desc');
        }
        session(['closedOldCache' => $user]);
        $countMails = $data->count();
        $data = $data->skip((int) $start)->take((int) $length)->get();
        $mailBoxes = EmailCredentials::where('credentialStatus', 1)->get();

        if ($request->ajax()) {
            $documentOperation = view('document_management.closed_document_search', [
                'data' => $data,
                'mailBoxes' => $mailBoxes,
                'user' => $user,
                'countMails' => $countMails
            ])->render();
            return response()->json([
                'status' => 'success',
                'documentOperation' => $documentOperation,
                'countMails' => $countMails
            ]);
        }

        return view('document_management.closed_documents')->with(compact('data', 'mailBoxes', 'user', 'countMails'));
    }


    /**
     * to get options for filter pop up.
     */

    public function filterOptions(Request $request)
    {
        $role = session('role');
        $customers = [];
        if (isset($request->customers)) {
            $customers = Customer::select('fullName')->whereIn('_id', $request->customers)->get();
            if (!$customers) {
                $customers = [];
            }
        }
        $swap = [];
        $agents = Emails::select('assaignedTo.agentId', 'assaignedTo.agentName')
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
                    $query->whereIn('assaignedTo.agentId', [new ObjectId(Auth::user()->_id), '999']);
                } elseif (session('role') == 'Supervisor' && $request->status == '1') {
                    $employees = session('employees') ?: [];
                    $employees = array_merge($employees, ["999", "", new ObjectId(Auth::user()->_id), null]);
                    $query->whereIn('assaignedTo.agentId', $employees);
                }
            })
            ->orderBy('assaignedTo.agentName', 'asc')->get()
            ->unique('assaignedTo.agentId');


            // dd($agents);
        foreach ($agents as $agent) {
            if (isset($agent->assaignedTo) && $agent->assaignedTo != []) {
                array_push($swap, $agent);
            }
        }
        $agents = $swap;
        $new = (Object) [
            'agentId' => '000',
            'agentName'=> 'None'
        ];
        $newAgent= Collection::make(
            [
                [
                'assaignedTo'=> $new
                ]
            ]
        );
        $agents = $newAgent->merge($agents);

        $swap = [];
        $customerAgents = Emails::select('assaignedTo.customerAgentId', 'assaignedTo.customerAgentName')
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
                    $query->whereIn('assaignedTo.agentId', [new ObjectId(Auth::user()->_id), '999']);
                } elseif (session('role') == 'Supervisor' && $request->status == '1') {
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

        return array($customers, $agents, $customerAgents);
    }

    /**
     * get the from mail addresses to show in filter
     */
    public function getMailFromFilter(Request $request)
    {
        $key= $request->input('key');
        $page= $request->input('page');
        $status= $request->input('status');
        $box= $request->input('mailBox');
        $box= EmailCredentials::select('userID')->find($box)->userID;
        $mailFrom= Emails::distinct('from')
            ->where('mailStatus', (int)$status)
            ->where('documentMailBox', $box)
            ->where('deleted', '!=', 1);
        if ($key) {
            $mailFrom->where('from', 'like', $key.'%');
            $count=$mailFrom->count();
            if ($count) {
                $mailFrom = $mailFrom->take(10)->get();
            } else {
                $mailFrom= Emails::distinct('from')
                    ->where('mailStatus', (int)$status)
                    ->where('documentMailBox', $box)
                    ->where('deleted', '!=', 1);
                $mailFrom = $mailFrom->where('from', 'like', '%'.$key.'%')
                    ->take(10)->get();
            }
        } else {
            $mailFrom= $mailFrom->take(10)->get();
        }
        $count=count($mailFrom);
        foreach ($mailFrom as $mail) {
            $id = $mail->getAttributes()["0"];
            $mail->text = $id;
            $mail->id = $id;
            $mail->name = $id;
        }
        $data = array(
            'total_count' => $count,
            'incomplete_results' => false,
            'items' => $mailFrom,
        );

        return json_encode($data);
    }

    /**
     * filter upon the selected option by the user.
     */
    public function customFilter(Request $request)
    {
        $paginationFactor = (int) Config::get('documents.pagination_factor');
        if ($request->status == 1) {
            session()->pull('documentFilter');
            $searchKey = session('activeSearchKey');
        } elseif ($request->status == 0) {
            session()->pull('closedDocumentFilter');
            $searchKey = session('closedSearchKey');
        }
        $arr = [];
        $statusDetails = $request->statusDetails;
        $customerDetails = $request->customerDetails;
        $agentDetails = $request->agentDetails;
        $customerAgentDetails = $request->customerAgentDetails;
        $mailFrom = $request->input('mailFrom');
        // dd($mailFrom);
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');

        // dd($mailFrom, $fromDate, $toDate);
        // dd($statusDetails, $customerDetails, $agentDetails, $customerAgentDetails);
        $data = Emails::where('mailStatus', (int) $request->status)->where('documentMailBox', $request->user)
            ->where('deleted', '!=', 1);
        if ($searchKey != "") {
            $data->where(function ($query) use ($searchKey) {
                $query->where('subject', 'like', '%' . $searchKey . '%')
                    ->orWhere('mailsText', 'like', '%' . $searchKey . '%')
                    ->orWhere('attachements.attachName', 'like', '%' . $searchKey . '%')
                    ->orWhere('attachements.attachContent', 'like', '%' . $searchKey . '%');
            });
        }

        if ($request->status == 1) {
            $order = session('documentFilter.order');
            if (isset($fromDate)) {
                $fDate= Carbon::createFromFormat('!d/m/Y', $fromDate);
                $data->where('mailRecTime', '>=', $fDate);
                session(['documentFilter.fromDate' => $fDate]);
            }
            if (isset($toDate)) {
                $tDate= Carbon::createFromFormat('!d/m/Y', $toDate);
                $tDate=$tDate->endOfDay();

                $data->where('mailRecTime', '<=', $tDate);
                session(['documentFilter.toDate' => $tDate]);
            }
            if ($mailFrom) {
                $data->whereIn('from', $mailFrom);
                session(['documentFilter.from' => $mailFrom]);
            }
            $arr = [];
            if ($statusDetails != "") {
                foreach ($statusDetails as $item) {
                    array_push($arr, $item);
                }
                $data->whereIn('assaignedTo.assaignStatusName', $arr);
                session(['documentFilter.statusList' => $arr]);
            }
            $arr = [];
            if ($customerAgentDetails != "") {
                foreach ($customerAgentDetails as $item) {
                    array_push($arr, $item);
                }
                $data->whereIn('assaignedTo.customerAgentId', $arr);
                session(['documentFilter.customerAgentList' => $arr]);
            }
            $arr = [];
            if ($customerDetails != "") {
                foreach ($customerDetails as $item) {
                    array_push($arr, new ObjectId($item));
                }
                $data->whereIn('assaignedTo.customerId', $arr);
                session(['documentFilter.customerList' => $arr]);
            }
            $arr = [];
            if ($agentDetails != "") {
                foreach ($agentDetails as $item) {
                    if ($item == "000") {
                        $arr = array_merge($arr, ["", null]);
                    } elseif ($item != "999") {
                        array_push($arr, new ObjectId($item));
                    } else {
                        array_push($arr, $item);
                    }
                }
                $data->whereIn('assaignedTo.agentId', $arr);
                session(['documentFilter.agentList' => $arr]);
            }
        } elseif ($request->status == 0) {
            $order = session('closedDocumentFilter.order');
            if (isset($fromDate)) {
                $fDate= Carbon::createFromFormat('!d/m/Y', $fromDate);
                $data->where('mailRecTime', '>=', $fDate);
                session(['closedDocumentFilter.fromDate' => $fDate]);
            }
            if (isset($toDate)) {
                $tDate= Carbon::createFromFormat('!d/m/Y', $toDate);
                $tDate=$tDate->endOfDay();

                $data->where('mailRecTime', '<=', $tDate);
                session(['closedDocumentFilter.toDate' => $tDate]);
            }
            $arr = [];
            if ($mailFrom) {
                $data->whereIn('from', $mailFrom);
                session(['closedDocumentFilter.from' => $mailFrom]);
            }
            $arr = [];
            if ($statusDetails != "") {
                foreach ($statusDetails as $item) {
                    array_push($arr, $item);
                }
                $data->whereIn('assaignedTo.assaignStatusName', $arr);
                session(['closedDocumentFilter.statusList' => $arr]);
            }
            $arr = [];
            if ($customerDetails != "") {
                foreach ($customerDetails as $item) {
                    array_push($arr, new ObjectId($item));
                }
                $data->whereIn('assaignedTo.customerId', $arr);
                session(['closedDocumentFilter.customerList' => $arr]);
            }
            $arr = [];
            if ($customerAgentDetails != "") {
                foreach ($customerAgentDetails as $item) {
                    array_push($arr, $item);
                }
                $data->whereIn('assaignedTo.customerAgentId', $arr);
                session(['closedDocumentFilter.customerAgentList' => $arr]);
            }
            $arr = [];
            if ($agentDetails != "") {
                foreach ($agentDetails as $item) {
                    // if ($item != "999") {
                    //     array_push($arr, new ObjectId($item));
                    // } else {
                    //     array_push($arr, $item);
                    // }
                    if ($item == "000") {
                        $arr = array_merge($arr, ["", null]);
                    } elseif ($item != "999") {
                        array_push($arr, new ObjectId($item));
                    } else {
                        array_push($arr, $item);
                    }
                }
                $data->whereIn('assaignedTo.agentId', $arr);
                session(['closedDocumentFilter.agentList' => $arr]);
            }
        }

        if (session('role') == 'Coordinator') {
            $coAgent = (string) session('assigned_agent');
            $data->where('assaignedTo.customerAgentId', $coAgent);
        } elseif (session('role') == 'Agent') {
            $data->where('assaignedTo.customerAgentId', Auth::user()->_id);
        } elseif (session('role') == 'Employee' && $request->status == 1) {
            $data->whereIn('assaignedTo.agentId', [new ObjectId(Auth::user()->_id), "999"]);
        } elseif (session('role') == 'Supervisor' && $request->status == 1) {
            $employees = session('employees') ?: [];
            $employees = array_merge($employees, ["999", "", new ObjectId(Auth::user()->_id), null]);
            $data->whereIn('assaignedTo.agentId', $employees);
        }

        $mailBoxes = EmailCredentials::where('credentialStatus', 1)->get();
        $user = $request->user;
        if (isset($order) && $order == "latest") {
            $data = $data->orderBy('created_at', 'desc');
        }
        $countMails = $data->count();
        $data = $data->skip(0)->take($paginationFactor)->get();
        if ($request->status == 1) {
            $documentOperation = view(
                'document_management.document_search',
                [
                    'data' => $data,
                    'mailBoxes' => $mailBoxes,
                    'user' => $user,
                    'countMails' => $countMails
                ]
            )->render();
        } elseif ($request->status == 0) {
            $documentOperation = view(
                'document_management.closed_document_search',
                [
                    'data' => $data,
                    'mailBoxes' => $mailBoxes,
                    'user' => $user,
                    'countMails' => $countMails
                ]
            )->render();
        }
        return response()->json([
            'status' => 'success', 'documentOperation' => $documentOperation,
            'countMails' => $countMails
        ]);
    }

    /**
     * search emails upon the given string bythe user // on mail content, attachement's name, inside pdf files
     */
    public function customSearch(Request $request)
    {
        $paginationFactor = (int) Config::get('documents.pagination_factor');
        $key = $request->key;
        $documentStatus = $request->status;
        $mailBox = EmailCredentials::where('_id', $request->credential)->get()->first();
        $user = $mailBox->userID;
        $data = Emails::where('mailStatus', (int) $documentStatus)->where('documentMailBox', $user)
            ->where('deleted', '!=', 1);
        if ($request->status == 1) {
            $stat = session('documentFilter.statusList');
            $cust = session('documentFilter.customerList');
            $agen = session('documentFilter.agentList');
            $custAgent = session('documentFilter.customerAgentList');
            $mailFrom = session('documentFilter.from');
            $fromDate = session('documentFilter.fromDate');
            $toDate = session('documentFilter.toDate');
            $order = session('documentFilter.order');
            session(['activeSearchKey' => $key]);
        } elseif ($request->status == 0) {
            $stat = session('closedDocumentFilter.statusList');
            $cust = session('closedDocumentFilter.customerList');
            $agen = session('closedDocumentFilter.agentList');
            $custAgent = session('closedDocumentFilter.customerAgentList');
            $mailFrom = session('closedDocumentFilter.from');
            $fromDate = session('closedDocumentFilter.fromDate');
            $toDate = session('closedDocumentFilter.toDate');
            $order = session('closedDocumentFilter.order');
            session(['closedSearchKey' => $key]);
        }
        if (isset($fromDate)) {
            $data->where('mailRecTime', '>=', $fromDate);
        }
        if (isset($toDate)) {
            $data->where('mailRecTime', '<=', $toDate);
        }
        if (isset($mailFrom)) {
            $data->whereIn('from', $mailFrom);
        }
        if (isset($stat)) {
            $data->whereIn('assaignedTo.assaignStatusName', $stat);
        }
        if (isset($cust)) {
            $data->whereIn('assaignedTo.customerId', $cust);
        }
        if (isset($agen)) {
            $data->whereIn('assaignedTo.agentId', $agen);
        }
        if (isset($custAgent)) {
            $data->whereIn('assaignedTo.customerAgentId', $custAgent);
        }
        if ($key != "") {
            $data = $data->where(function ($query) use ($key) {
                $query->where('subject', 'like', '%' . $key . '%')
                    ->orWhere('mailsText', 'like', '%' . $key . '%')
                    ->orWhere('attachements.attachName', 'like', '%' . $key . '%')
                    ->orWhere('attachements.attachContent', 'like', '%' . $key . '%');
            });
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
        if (isset($order) && $order == "latest") {
            $data = $data->orderBy('created_at', 'desc');
        }
        $countMails = $data->count();
        $data = $data->skip(0)->take($paginationFactor)->get();
        $mailBoxes = EmailCredentials::where('credentialStatus', 1)->get();
        if ($request->status == 1) {
            $documentOperation = view(
                'document_management.document_search',
                [
                    'data' => $data,
                    'mailBoxes' => $mailBoxes,
                    'user' => $user,
                    'countMails' => $countMails
                ]
            )->render();
        } elseif ($request->status == 0) {
            $documentOperation = view(
                'document_management.closed_document_search',
                [
                    'data' => $data,
                    'mailBoxes' => $mailBoxes,
                    'user' => $user,
                    'countMails' => $countMails
                ]
            )->render();
        }
        return response()->json([
            'status' => 'success', 'documentOperation' => $documentOperation,
            'countMails' => $countMails
        ]);
    }

    /**
     * to remove the <img> tags from mail content fatched from email
     */
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

    /**
     * to save activity log  of document management
     */
    private function saveLog($action)
    {
        // $log=new \stdClass();
        // $log->time=Carbon::now('asia/dubai')->format('l jS \\of F Y h:i:s A');
        // $log->actorId
        return 1;
    }

    /**
     * to load the email listing page and refresh the database with newly arraived emails
     */
    public function listEmails(Request $req)
    {

        $start = $req->page;
        if ($start == '') {
            $start = 0;
        }
        $length = (int) Config::get('documents.pagination_factor');
        $countMails = 0;

        $mailIdLog = [];
        $failedLog = [];
        $oldId = session('oldCache');
        $user = Config::get('documents.default_username');
        $pass = Config::get('documents.default_passcode');
        $commonMailBox = Config::get('documents.common_mailbox');
        $path = 'attachments';
        if (isset($req->index)) {
            $result = EmailCredentials::find($req->index);
            $user = $result->userID;
            $pass = $result->passWord;
            if (isset($result->assignEmployee)) {
                $assignedEmployee = $result->assignEmployee; //asign employee
            } else {
                $assignedEmployee = '';
            }

            if ($oldId != $user) {
                session()->pull('documentFilter');
                session()->pull('activeSearchKey');
            }
        } else {
            $existingUser = EmailCredentials::where('userID', $user)->where('credentialStatus', 1)->first();
            if (isset($existingUser->assignEmployee)) {
                $assignedEmployee = $existingUser->assignEmployee; //asign employee
            } else {
                $assignedEmployee = ''; //asign employee
            }
        }

        $stat = session('documentFilter.statusList');
        $cust = session('documentFilter.customerList');
        $agen = session('documentFilter.agentList');
        $custAgent = session('documentFilter.customerAgentList');
        $mailFrom = session('documentFilter.from');
        $fromDate = session('documentFilter.fromDate');
        $toDate = session('documentFilter.toDate');
        $key = session('activeSearchKey');
        $order = session('documentFilter.order');

        $data = Emails::where('mailStatus', 1)->where('documentMailBox', $user)->where('deleted', '!=', 1);
        if (isset($fromDate)) {
            $data->where('mailRecTime', '>=', $fromDate);
        }
        if (isset($toDate)) {
            $data->where('mailRecTime', '<=', $toDate);
        }
        if (isset($mailFrom)) {
            $data->whereIn('from', $mailFrom);
        }
        if (isset($stat)) {
            $data->whereIn('assaignedTo.assaignStatusName', $stat);
        }
        if (isset($cust)) {
            $data->whereIn('assaignedTo.customerId', $cust);
        }
        if (isset($agen)) {
            $data->whereIn('assaignedTo.agentId', $agen);
        }
        if (isset($custAgent)) {
            $data->whereIn('assaignedTo.customerAgentId', $custAgent);
        }
        if (isset($key)) {
            $data = $data->where(function ($query) use ($key) {
                $query->where('subject', 'like', '%' . $key . '%')
                    ->orWhere('mailsText', 'like', '%' . $key . '%')
                    ->orWhere('attachements.attachName', 'like', '%' . $key . '%')
                    ->orWhere('attachements.attachContent', 'like', '%' . $key . '%');
            });
        }
        if (isset($order) && $order == "latest") {
            $data = $data->orderBy('created_at', 'desc');
        }
        if (session('role') == 'Admin') {
            if (!$req->ajax()) {
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
                    $notification->connect(2);
                } catch (\Webklex\IMAP\Exceptions\ConnectionFailedException $e) {
                    $msg = $e->getMessage();
                    $failedLogObj = new \stdClass();
                    $failedLogObj->mailBox = $user;
                    $failedLogObj->desc = $msg;
                    $failedLog[] = $failedLogObj;
                    $log->controller = 'DocumentManagementController';
                    $log->function = 'listMails';
                    $log->failedLog = $failedLog;
                    $log->failed = 1;
                    $log->save();

                    $result = EmailCredentials::where('userID', $req->oldUser)->first();
                    Session::flash('status', 'We could not connect to the email server,please check the settings !');
                    return redirect('document/view-emails?index=' . $result->_id . '&oldUser=' . $req->oldUser);
                }
                $fileExtension = "";
                $inbox = $notification->getFolders()->first(); // navigating to inbox

                //fetching unseen messages and marking as read (seen)
                $messages = $inbox->query()->unseen()->markAsRead()->get();

                //fetching unseen messages and not marking as read (seen)
                // $messages = $inbox->query()->unseen()->get();

                //fetching unflagged messages and marking as flagged
                // $messages = $inbox->query()->unflagged()->get();


                foreach ($messages as $message) {                                      //looping messages
                    $message->unsetFlag(["flagged", "seen"]);
                    $messageId = $message->getMessageId();
                    $cc = $message->getCc() ?: "";
                    $mails = new Emails();
                    $date = $message->getDate();                                      //receive time
                    $date = $date->timezone('asia/dubai');
                    $time = $date->format('l jS \\of F Y h:i:s A');

                    $filterTime = $date->timestamp;
                    $filterTime =  new \MongoDB\BSON\UTCDateTime($filterTime * 1000);

                    $subject = $message->getSubject();                                //subject
                    $logSubject = $subject;
                    $from = $message->getFrom();                                      //from address
                    $mailContent = $message->getHtmlBody();  //html body
                    $mailText = $message->getTextBody();  //text body of mail
                    if ($mailContent == "<div dir=\"ltr\"><br></div>\r\n") {
                        $mailContent = "<div dir=\"ltr\"><h3> blank mail</h3></div>\r\n";
                    }

                    //removing the specified tages from the mail body content
                    $mailContent = $this->removeTag($mailContent, 'img');
                    $from = $from[0];
                    $mailfrom = $from->mail;
                    $mails->messageId = $messageId;
                    $mails->subject = $subject;
                    $mails->documentMailBox = $user;
                    $mails->from = $mailfrom;
                    $mails->fromDetails = $from;
                    $mails->cc = $cc;
                    $mails->recieveDateObject = $date;
                    $mails->recieveTime = $time;
                    $mails->mailsContent = $mailContent;
                    $mails->mailsText = $mailText;
                    $newFileName = '';
                    $attachments = [];
                    $attachArray = [];
                    if ($message->hasAttachments()) {                                   //checking if attachments exists
                        $attachments = $message->getAttachments();                      //getting attachments
                        foreach ($attachments as $attachment) {                         //looping attachments
                            $fileName = $attachment->getName();
                            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);   //getting attachment file name
                            if (file_exists($path . '/' . $fileName)) {                 //if file alreading exists
                                $baseName = pathinfo($fileName, PATHINFO_FILENAME);
                                for ($i = 1;; ++$i) {
                                    $fileName = $baseName . '(' . $i . ').' . $fileExtension;
                                    if (!file_exists($path . '/' . $fileName)) {   //if file alreading exists rename
                                        $newFileName = $this->uploadFile($attachment, $path, $fileName);
                                        break;
                                    }
                                }
                            } else {
                                $newFileName = $this->uploadFile($attachment, $path, $fileName);
                            }
                            $uploadedFile = new LocalFile($newFileName);
                            try {
                                $mimeType = $uploadedFile->getMimeType(); //application/pdf  //application/pdf
                            } catch (\Exception $e) {
                                $mimeType = null;
                            }
                            $urlPath = $this->uploadFileToCloud($uploadedFile);
                            if ($mimeType == "application/pdf") {
                                try {
                                    $attachContent = (new PdfToText())->setPdf($newFileName)->text();
                                } catch (PdfException\PdfNotFound $e) {
                                    $attachContent = "";
                                } catch (PdfException\CouldNotExtractText $e) {
                                    $attachContent = "";
                                }
                                $attachContent = strip_tags($attachContent);
                            } else {
                                $attachContent = "";
                            }
                            unlink($newFileName);
                            if ($newFileName != '') {
                                date_default_timezone_set('Asia/Dubai');
                                $mails->isAttach = 1;
                                $attachObj = new \stdClass();
                                $attachObj->attachId = (string) time() . uniqid();
                                $attachObj->attachPath = $urlPath;
                                $attachObj->attachName = $fileName;
                                $attachObj->mimeType = $mimeType;
                                $attachObj->attachContent = $attachContent;
                                $attachObj->attachStatus = 1;
                                $attachObj->lastUpdate = date('d-m-Y h:i:s a');
                                $attachArray[] = $attachObj;
                            }
                        }
                        $mails->attachements = $attachArray;
                    } else {
                        $mails->isAttach = 0;
                    }
                    $mails->mailStatus = 1;
                    $mails->deleted = 0;
                    $mails->mailRecTime = $filterTime;

                    $mailsFetched++;
                    if ($mails->save()) {
                        $message->setFlag(["flagged", "seen"]);
                    } else {
                        $message->unsetFlag(["flagged", "seen"]);
                    }

                    $reqObj = new Request();
                    $reqObj->mailId = $mails->id;
                    $subject = explode('*', $subject);
                    $subject = array_map('trim', $subject);
                    $customerId = Customer::where('customerCode', 'like', $subject[0])->first();
                    $attachmentCount = count($attachments);
                    $docCount=count($attachArray);

                    //////////////ASSIGN EMPLOYEE AUTOMATICALLY/////////////////
                    if ($assignedEmployee != '') {
                        $reqObj->agent = $assignedEmployee;
                    }
                    //////////END/////////////////
                    if (isset($customerId)) {
                        $customerId = $customerId->_id;
                        $reqObj->customer = $customerId;
                        $updatedNames = [];
                        // dd($docCount, $customerId);
                        if ($docCount) {
                            for ($i = 0; $i < $docCount; $i++) {
                                $updatedNames[$i] = @$subject[1]?:"";
                            }
                        }
                        $reqObj->updateAttachName = $updatedNames;
                    }
                    $x = $this->asignDocument($reqObj);
                    $logObj = new \stdClass();
                    $logObj->mailBox = $user;
                    $logObj->inboxMailId = $messageId;
                    $logObj->insertedId = $mails->id;
                    $logObj->subject = $logSubject;
                    $logObj->attachmentsCount = $attachmentCount;
                    $logObj->attachDifference = ($attachmentCount-$docCount);
                    $mailIdLog[] = $logObj;
                }
                $notification->disconnect();

                //log creation
                $log->controller = 'DocumentManagementController';
                $log->function = 'listMails';
                $log->successLog = $mailIdLog;
                $log->mailsFetched = $mailsFetched;
                $log->failed = 0;
                $log->save();
            }

            $countMails = $data->count();
            $data = $data->skip((int) $start)->take((int) $length)->get();
        } elseif (session('role') == 'Employee') {
            $data = $data->whereIn('assaignedTo.agentId', [new ObjectId(Auth::user()->_id), "999"]);
            $countMails = $data->count();
            $data = $data->skip((int) $start)->take((int) $length)->get();
        } elseif (session('role') == 'Coordinator') {
            $coAgent = (string) session('assigned_agent');
            $data = $data->where('assaignedTo.customerAgentId', $coAgent);
            $countMails = $data->count();
            $data = $data->skip((int) $start)->take((int) $length)->get();
        } elseif (session('role') == 'Agent') {
            $data = $data->where('assaignedTo.customerAgentId', Auth::user()->_id);
            $countMails = $data->count();
            $data = $data->skip((int) $start)->take((int) $length)->get();
        } elseif (session('role') == 'Supervisor') {
            $employees = session('employees') ?: [];
            $employees = array_merge($employees, ["999", "", new ObjectId(Auth::user()->_id), null]);
            $data->whereIn('assaignedTo.agentId', $employees);
            $countMails = $data->count();
            $data = $data->skip((int) $start)->take((int) $length)->get();
        } else {
            $data = [];
        }
        $mailBoxes = EmailCredentials::where('credentialStatus', 1)->get();
        if ($req->ajax()) {
            $documentOperation = view(
                'document_management.document_search',
                [
                    'data' => $data,
                    'mailBoxes' => $mailBoxes,
                    'user' => $user,
                    'countMails' => $countMails
                ]
            )->render();
            return response()->json([
                'status' => 'success', 'documentOperation' => $documentOperation,
                'countMails' => $countMails
            ]);
        }
        session(['oldCache' => $user]);
        if (!$mailBoxes) {
            return redirect('/logout');
        }
        return view('document_management.email_management')->with(compact('data', 'mailBoxes', 'user', 'countMails'));
    }

    /**
     * to automatically refresh the database with new arrived emails in background
     * its used by the cronjob "documents:refresh"
     */
    public static function documentRefreshSchedule()
    {
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
        $path = 'attachments';
        $mailIdLog = [];
        $failedLog = [];
        $credentials = EmailCredentials::where('credentialStatus', 1)->get();
        foreach ($credentials as $credential) {
            $user = $credential->userID;
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
                $notification->connect(2);
            } catch (\Webklex\IMAP\Exceptions\ConnectionFailedException $e) {
                $failedCount++;
                $msg = $e->getMessage();
                $failedLogObj = new \stdClass();
                $failedLogObj->mailBox = $user;
                $failedLogObj->desc = $msg;
                $failedLog[] = $failedLogObj;

                continue;
            }

            $fileExtension = "";
            $inbox = $notification->getFolders()->first();
            $messages = $inbox->query()->unseen()->markAsRead()->get();
            foreach ($messages as $message) {                                      //looping messages
                $message->unsetFlag(["flagged", "seen"]);
                $messageId = $message->getMessageId();
                $cc = $message->getCc() ?: "";
                $mails = new Emails();
                $date = $message->getDate();                                      //receive time
                $date = $date->timezone('asia/dubai');
                $time = $date->format('l jS \\of F Y h:i:s A');

                $filterTime = $date->timestamp;
                $filterTime =  new \MongoDB\BSON\UTCDateTime($filterTime * 1000);

                $subject = $message->getSubject();                                //subject
                $from = $message->getFrom();                                      //from address
                $mailContent = $message->getHtmlBody();                           //html body
                $mailText = $message->getTextBody();  //text body of mail

                if ($mailContent == "<div dir=\"ltr\"><br></div>\r\n") {
                    $mailContent = "<div dir=\"ltr\"><h3> blank mail</h3></div>\r\n";
                }
                $mailContent = DocumenetManagementController::removeTag($mailContent, 'img');
                $from = $from[0];
                $mailfrom = $from->mail;
                $mails->messageId = $messageId;
                $mails->subject = $subject;
                $mails->documentMailBox = $user;
                $mails->from = $mailfrom;
                $mails->fromDetails = $from;
                $mails->cc = $cc;
                $mails->recieveDateObject = $date;
                $mails->recieveTime = $time;
                $mails->mailsContent = $mailContent;
                $mails->mailsText = $mailText;
                $newFileName = '';
                $attachments = [];
                $attachArray = [];
                if ($message->hasAttachments()) {                                  //checking if attachments exists
                    $attachments = $message->getAttachments();                    //getting attachments
                    foreach ($attachments as $attachment) {                        //looping attachments
                        $fileName = $attachment->getName();                       //getting attachment file name
                        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);  //getting attachment file name
                        if (file_exists($path . '/' . $fileName)) {                        //if file alreading exists
                            $baseName = pathinfo($fileName, PATHINFO_FILENAME);
                            // $extension = pathinfo($fileName, PATHINFO_EXTENSION);
                            for ($i = 1;; ++$i) {
                                $fileName = $baseName . '(' . $i . ').' . $fileExtension;
                                if (!file_exists($path . '/' . $fileName)) {             //if file alreading exists
                                    $newFileName =
                                        DocumenetManagementController::uploadFile($attachment, $path, $fileName);
                                    break;
                                }
                            }
                        } else {
                            $newFileName = DocumenetManagementController::uploadFile($attachment, $path, $fileName);
                        }
                        $uploadedFile = new LocalFile($newFileName);
                        try {
                            $mimeType = $uploadedFile->getMimeType(); //application/pdf  //application/pdf
                        } catch (\Exception $e) {
                            $mimeType = null;
                        }
                        $urlPath = DocumenetManagementController::uploadFileToCloud($uploadedFile);
                        if ($mimeType == "application/pdf") {
                            try {
                                $attachContent = (new PdfToText())->setPdf($newFileName)->text();
                            } catch (PdfException\PdfNotFound $e) {
                                $attachContent = "";
                            } catch (PdfException\CouldNotExtractText $e) {
                                $attachContent = "";
                            }
                            $attachContent = strip_tags($attachContent);
                        } else {
                            $attachContent = "";
                        }

                        unlink($newFileName);
                        if ($newFileName != '') {
                            //timeZone
                            $mails->isAttach = 1;
                            $attachObj = new \stdClass();
                            $attachObj->attachId = (string) time() . uniqid();
                            $attachObj->attachPath = $urlPath;
                            $attachObj->attachName = $fileName;
                            $attachObj->attachContent = $attachContent;
                            $attachObj->attachStatus = 1;
                            $attachObj->lastUpdate = date('d-m-Y h:i:s a');
                            $attachArray[] = $attachObj;
                        }
                    }

                    $mails->attachements = $attachArray;
                } else {
                    $mails->isAttach = 0;
                    $attachments = [];
                }
                $mails->mailStatus = 1;
                $mails->deleted = 0;
                $mails->mailRecTime = $filterTime;

                $mailsFetched++;
                if ($mails->save()) {
                    $message->setFlag(["flagged", "seen"]);
                } else {
                    $message->unsetFlag(["flagged", "seen"]);
                }

                $commonMailBox = Config::get('documents.common_mailbox');
                $reqObj = new Request();
                $reqObj->mailId = $mails->id;
                $logSubject = $subject;
                $subject = explode('*', $subject);
                $subject = array_map('trim', $subject);
                $customerId = Customer::where('customerCode', 'like', $subject[0])->first();
                $attachmentCount = count($attachments);
                $docCount=count($attachArray);

                /////////////ASSIGN EMPLOYEE AUTOMATICALLY///////////////////
                if ($assignedEmployee != '') {
                    $reqObj->agent = $assignedEmployee;
                }
                ///////////////////END//////////////
                if (isset($customerId)) {
                    $customerId = $customerId->_id;
                    $reqObj->customer = $customerId;

                    $updatedNames = [];
                    if ($docCount) {
                        for ($i = 0; $i < $docCount; $i++) {
                            $updatedNames[$i] = @$subject[1]?:"";
                        }
                    }
                    $reqObj->updateAttachName = $updatedNames;
                }
                $x = DocumenetManagementController::asignDocument($reqObj);

                $logObj = new \stdClass();
                $logObj->mailBox = $user;
                $logObj->inboxMailId = $messageId;
                $logObj->insertedId = $mails->id;
                $logObj->subject = $logSubject;
                $logObj->attachmentsCount = $attachmentCount;
                $logObj->attachDifference = ($attachmentCount-$docCount);
                $mailIdLog[] = $logObj;
            }
            $notification->disconnect();
        }
        $log->controller = 'DocumentManagementController';
        $log->function = 'documentRefreshSchedule';
        $log->mailsFetched = $mailsFetched;
        $log->successLog = $mailIdLog;
        $log->failedLog = $failedLog;
        $log->failed = $failedCount;
        $log->save();

        return "success";
    }

    /**
     * to upload the file to s3 cloud
     */
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


    /**
     * to save the attachment fetched from mail to local folder before upload to s3 cloud
     */
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

    /**
     * to view mailsContent as open mail function .
     */
    public function getEmail(Request $req)
    {
        $mailId = $req->index;
        $content = Emails::find($mailId);
        // dd($content->mailsContent);
        return $content;
    }

    /**
     * to pick options for customer select.
     */
    public function getCustomer(Request $request)
    {
        if ($request->input('q')) {
            $search = $request->input('q');
            $customers = Customer::where('status', (int) 1)
                ->where(function ($query) use ($search) {
                    $query->where('fullName', 'like', $search . '%')
                        ->orWhere('customerCode', 'like', $search . '%');
                })->orderBy('fullName')->get();
            // $recepients = RecipientDetails::where('status', (int) 1)
            //     ->where('fullName', 'like', $request->input('q') . '%')->orderBy('fullName')->get();
            if (count($customers) == 0) {
                $customers = Customer::where('status', (int) 1)
                    ->where(function ($query) use ($search) {
                        $query->where('fullName', 'like', '%' . $search . '%')
                            ->orWhere('customerCode', 'like', '%' . $search . '%');
                    })->orderBy('fullName')->get();
                // $recepients = RecipientDetails::where('status', (int) 1)
                //     ->where('fullName', 'like', '%' . $request->input('q') . '%')->orderBy('fullName')->get();
            }
            // $customers = $customers->merge($recepients);
        } else {
            $customers = Customer::where('status', (int) 1)->take(10)->orderBy('fullName')->get();
        }
        foreach ($customers as $customer) {
            $customer->customerCD = $customer->customerCode ? $customer->customerCode : "Code not available";
            $customer->text = $customer->fullName . ' (' . $customer->customerCD . ')';
            $customer->id = $customer->_id;
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
     * to pick options for customer select in customer view.
     */
    public function getCustomerInCustomerView(Request $request)
    {
        $role=session('role');
        if ($request->input('q')) {
            $search = $request->input('q');
            $customers = Customer::where('status', (int) 1)
                ->where(function ($query) use ($role) {
                    if ($role=='Agent') {
                        $query->where('agent.id', new ObjectId(Auth::user()->_id));
                    } elseif ($role=='Coordinator') {
                        $coAgent = (string) session('assigned_agent');
                        $query->where('agent.id', new ObjectId($coAgent));
                    }
                })
                ->where(function ($query) use ($search) {
                    $query->where('fullName', 'like', $search . '%')
                        ->orWhere('customerCode', 'like', $search . '%');
                })->get();
            // $recepients = RecipientDetails::where('status', (int) 1)
            //     ->where('fullName', 'like', $request->input('q') . '%')->get();
            if (count($customers) == 0) {
                $customers = Customer::where('status', (int) 1)
                    ->where(function ($query) use ($role) {
                        if ($role=='Agent') {
                            $query->where('agent.id', new ObjectId(Auth::user()->_id));
                        } elseif ($role=='Coordinator') {
                            $coAgent = (string) session('assigned_agent');
                            $query->where('agent.id', new ObjectId($coAgent));
                        }
                    })
                    ->where(function ($query) use ($search) {
                        $query->where('fullName', 'like', '%' . $search . '%')
                            ->orWhere('customerCode', 'like', '%' . $search . '%');
                    })->get();
                // $recepients = RecipientDetails::where('status', (int) 1)
                //     ->where('fullName', 'like', '%' . $request->input('q') . '%')->get();
            }
            // $customers = $customers->merge($recepients);
        } else {
            $customers = Customer::where('status', (int) 1)
                                    ->where(function ($query) use ($role) {
                                        if ($role=='Agent') {
                                            $query->where('agent.id', new ObjectId(Auth::user()->_id));
                                        } elseif ($role=='Coordinator') {
                                            $coAgent = (string) session('assigned_agent');
                                            $query->where('agent.id', new ObjectId($coAgent));
                                        }
                                    })->take(10)->get();
        }
        foreach ($customers as $customer) {
            $customer->customerCD = $customer->customerCode ? $customer->customerCode : "Code not available";
            $customer->text = $customer->fullName . ' (' . $customer->customerCD . ')';
            $customer->id = $customer->_id;
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
     * function for customer option get.
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
     * to get the agent details of the selected customer
     */
    public function getAgentDetails(Request $req)
    {
        // $agent = Customer::select('agent')->where('_id', new ObjectId($req->customer))->first();
        $agent = Customer::select('agent')->find($req->customer);

        return json_encode($agent);
    }

    /**
     * to pick options for "assigned to" select.
     */
    public function getAgent(Request $request)
    {
        $page = $request->input('page');
        $page = $page ?: 1;
        // dd($page);
        if ($request->input('q')) {
            $agents = User::where('isActive', 1)
                ->whereIn('role', ['EM', 'SV'])
                ->where('name', 'like', $request->input('q') . '%')->get();
            if (count($agents) == 0) {
                $agents = User::where('isActive', 1)
                    ->whereIn('role', ['EM', 'SV'])
                    ->where('name', 'like', '%' . $request->input('q') . '%')->get();
            }
        } else {
            $agents = User::where('isActive', 1)
                ->whereIn('role', ['EM', 'SV'])
                ->take(10)->get();
        }
        foreach ($agents as $agent) {
            $agent->text = $agent->name;
            $agent->id = $agent->_id;
            $agent->name = $agent->name;
            $agent->employeeID = $agent->empID ? $agent->empID : "ID not available";
        }
        $count = count($agents);
        if (count($agents) > 0 && $page == 1) {
            $newData = Collection::make([['text' => 'All', 'id' => 999, 'name' => 'All', 'employeeID' => 'ID not available']]);
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
     * to save the selected datails of each email
     */
    // action of save & saveAndSubmit

    public static function asignDocument(Request $request)
    {
        $updateStatus = 0;
        $assign = 0;
        if (isset($request->note1)) {
            $assign = 1;
            $note1 = $request->note1;
        } else {
            $note1 = "";
        }
        if (isset($request->note2)) {
            $assign = 1;
            $note2 = $request->note2;
        } else {
            $note2 = "";
        }
        if (isset($request->note3)) {
            $assign = 1;
            $note3 = $request->note3;
        } else {
            $note3 = "";
        }
        if (isset($request->customer)) {
            $assign = 1;
            $customer = new ObjectId($request->customer);
            $document = Customer::select('fullName', 'customerCode', 'agent')
                ->where('status', (int) 1)
                ->where('_id', $customer)->first();
            if (!$document) {
                return "noCustomer";
            }
            $customerName = $document->fullName . ' (' . $document->customerCode ?: "Code not available";
            $customerName = $customerName . ')';
            if (isset($document->agent)) {
                $agentee = $document->agent;
                $customerAgentName = $agentee['name'];
                $customerAgentId = (string) $agentee['id'];
            } else {
                $customerAgentName = "";
                $customerAgentId = "";
            }
        } else {
            $customer = '';
            $customerName = '';
            $customerAgentName = "";
            $customerAgentId = "";
        }
        if (isset($request->agent)) {
            $assign = 1;
            if ($request->agent == '999') {
                $agent = "999";
                $agentName = "All";
                 $newNotification="999";
                 Emails::where('_id', new ObjectId($request->mailId))->unset('assignSeenID');
            } else {
                $agent = new ObjectId($request->agent);
                $agentName = User::select('name')->find($agent);
                $agentName = $agentName->name ?: "";
                $newNotification=new ObjectId($request->agent);
                Emails::where('_id', new ObjectId($request->mailId))->unset('assignSeenID');
            }
        } else {
            $agent = '';
            $agentName = '';
            $newNotification = '';
        }
        if (isset($request->status)) {
            $assign = 1;
            $status = $request->status;
        } else {
            $status = '';
        }

        $currentDoc = Emails::find($request->mailId);
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
                try {
                    if ($name == "" && !$name && isset($currentDoc[$key]['attachId'])) {
                        // where('_id', new ObjectId($request->mailId))
                        Emails::where('_id', new ObjectId($request->mailId))
                            // ->where('attachements' . $key . 'attachId', 'exists', true)
                            ->update([
                                'attachements.' . $key . '.updatedName' => $name,
                                'attachements.' . $key . '.suffix' => "",
                                'attachements.' . $key . '.updatedFullName' => ""
                            ]);
                            // dd("not match");
                        array_shift($match);
                        continue;
                    } else {
                        // $mailAttachments = Emails::select('attachements.attachName')
                        //     ->where('_id', new ObjectId($request->mailId))->first();
                        $mailAttachments = Emails::select('attachements.attachName')
                            ->find($request->mailId);
                        if ($mailAttachments) {
                            $attachments = $mailAttachments->attachements ?: "";
                            if (isset($attachments)) {
                                $attachName = $attachments[$key]['attachName'];
                                $extFileName = pathinfo("$attachName", PATHINFO_EXTENSION);
                            }
                        }
                        // dd($extFileName);
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
                        $updatedFullName = $name . (($suffix) ? "-" . $suffix : "") . "." . $extFileName;
                        // dd($updatedFullName);
                        Emails::where('_id', new ObjectId($request->mailId))->update([
                            'attachements.' . $key . '.updatedName' => $name,
                            'attachements.' . $key . '.suffix' => $suffix,
                            'attachements.' . $key . '.updatedFullName' => $updatedFullName
                        ]);
                    }
                    //end of adding suffix to updated name

                    if ($name != "") {
                        $updateStatus = 1;
                    }
                } catch (\Exception $e) {
                    continue;
                }
            }
        }

        if ($assign == 1) {
            $data = Emails::find(new ObjectId($request->mailId));
            $assaign = new \stdClass();
            $assaign->customerId = $customer;
            $assaign->customerName = $customerName;
            $assaign->agentId = $agent;
            $assaign->agentName = $agentName;
            $assaign->assaignStatus = $status;
            $assaign->assaignStatusName = $request->statusText ?: "";
            $assaign->customerAgentId = $customerAgentId;
            $assaign->customerAgentName = $customerAgentName;
            $data->assaignedTo = $assaign;
            $data->isassigned = 1;

            $notes = new \stdClass();
            $notes->note1 = $note1;
            $notes->note2 = $note2;
            $notes->note3 = $note3;
            $data->notes = $notes;
            $data->newNotification = $newNotification;
            if ($data->save()) {
                if ($status == 1) {
                    date_default_timezone_set('Asia/Dubai');
                    $day = date('d-m-Y h:i:s a');
                    Emails::where('_id', new ObjectId($request->mailId))
                        ->update(['mailStatus' => 0, 'closedAt' => $day]);
                }
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

    /**
     * to view entered comments of each email.
     */
    public function viewComments(Request $request)
    {
        // $comments = Emails::select('comments')->where('_id', $request->index)
        //     ->first()->comments;
        $comments = Emails::select('comments')->find($request->index)->comments;

        if (isset($comments)) {
            return $comments;
        } else {
            return 0;
        }
    }

    /**
     * to submit new comment for an email
     */
    public function submitComments(Request $request)
    {
        date_default_timezone_set('Asia/Dubai');
        $comment = new \stdClass();
        $comment->commentId = (string) time() . uniqid();
        $comment->commentBody = $request->comment;
        $comment->commentBy = session('user_name');
        $date = date('d-m-Y h:i:s a');
        $comment->commentDate = $date;
        Emails::where('_id', $request->index)->push('comments', $comment);
        $commentSeen[] = new ObjectID(Auth::id());
        Emails::where('_id', $request->index)->update(['commentSeen' => $commentSeen]);
        $response = ['body' => $request->comment, 'date' => $date, 'by' => session('user_name')];

        return $response;
    }

    /**
     * to forwaord a document to entered email ids
     */
    public function forwardDocument(Request $request)
    {
        $ids = $request->forwardTo;
        foreach ($ids as $to) {
            ForwardMail::dispatch($request->mailId, $to, $request->cc, $request->body);
        }
        return 1;
    }

    /**
     * to get details to show post customer pop up.
     */
    public function showPostCostomer(Request $request)
    {
        $mailId = $request->index;
        $customerId = $request->customerIndex;
        // $attachments = Emails::select('attachements')->where('_id', new ObjectId($mailId))->get()->first();
        $attachments = Emails::select('attachements')->find($mailId);
        $result = Customer::select('email', 'agent')
            ->where('_id', new ObjectId($customerId))->where('status', (int) 1)->first();
        // dd($result);
        if ($result) {
            $mails = $result->email;
            $agent = $result->agent;
            $agent = $agent['id'];
            $agentMail = User::find($agent)->email;
        } else {
            $mails = null;
            $agentMail = null;
            return 0;
        }

        $agentMail = $agentMail ? $agentMail : "";
        if ($mails == null) {
            $mails = "";
        } elseif ($mails != null) {
            $mails = $mails;
        }
        return array($mails, $attachments->attachements, $agentMail);
    }

    /**
     *
     */
    public function getSelectedAttachments(Request $request)
    {
        $attach = $request->attach;
        // $data = Emails::select('attachements')->where('_id', $request->mailId)->first()->attachements;
        $data = Emails::select('attachements')->find($request->mailId)->attachements;
        return $data;
    }

    /**
     * to save the posted documents to CustomerDocuments collection .
     */
    protected function updateCustomerDocuments($customerId, $attachmentId, $mailIndex, $customer)
    {
        date_default_timezone_set('Asia/Dubai');
        $today = date('d-m-Y h:i:s a');
        $utcDate = date_create_from_format('d-m-Y h:i:s a', $today);
        $utcDate->setTimezone(new \DateTimeZone('UTC'));
        if (is_array($attachmentId)) {
            $attach = $attachmentId;
        } else {
            $attach[] = $attachmentId;
        }
        // $agentData = Customer::select('agent', 'customerCode')->where('_id', new ObjectId($customerId))->first();
        $agentData = Customer::select('agent', 'customerCode')->find($customerId);
        $code = $agentData ? $agentData->customerCode : "";
        $agentDetails = $agentData ? $agentData->agent : "";
        $agent = new \stdClass();
        $agent->id = $agentDetails ? (string) $agentDetails['id'] : "";
        $agent->name = $agentDetails ? @$agentDetails['name'] : "";

        // $attachments = Emails::select('attachements')->where('_id', new ObjectId($mailIndex))->first();
        $attachments = Emails::select('attachements')->find($mailIndex);
        $attachments = $attachments->attachements;


        foreach ($attachments as $key => $attachment) {
            if (in_array($attachment['attachId'], $attach)) {
                $newPost = new SharedDocuments();
                $newPost->fileName = $attachment['attachName'];
                $newPost->filePath = $attachment['attachPath'];
                $newPost->documentId = $attachment['attachId'];
                $newPost->documentContent = $attachment['attachContent'];

                $ext = pathinfo($attachment['attachName'], PATHINFO_EXTENSION);
                $upName = @$attachment['updatedName'] ?: "";
                $upName = $upName . ($upName ? (@$attachment['suffix'] ? "-" . $attachment['suffix'] : "") : "");
                $upName = ($upName ? ($upName . "." . $ext) : "");
                $upName = $upName ?: $attachment['attachName'];

                $newPost->updatedName = @$attachment['updatedName'] ?: "";
                $newPost->suffix = @$attachment['suffix'] ?: "";
                $newPost->updatedFullName = $upName;
                $newPost->customerId = $customerId;
                $newPost->customerName = $customer->fullName;
                $newPost->customerCode = $code;
                $newPost->agentDetails = $agent;
                $newPost->customerViewed = 0;
                $newPost->uploadedAt = $today;
                $newPost->uploadedUtcDate =  $utcDate->format(DATE_ATOM);
                $newPost->status = 1;
                $newPost->deleted = 0;
                $newPost->save();
            }
        }
        return;
    }

    /**
     *  post a single document to customer .
     */
    public function postCustomer(Request $request)
    {
        date_default_timezone_set('Asia/Dubai');
        $success = 0;
        // $customer = Customer::where('_id', new ObjectId($request->customerIndex))->first();
        $customer = Customer::find($request->customerIndex);
        $passWard = $this->generateRandomString(6);
        $now = date('d-m-Y h:i:s a');
        if (Emails::where('_id', new ObjectId($request->mailIndex))
            ->update([
                'attachements.' . $request->attachmentIndex . '.postedToCustomerIndex'
                => new ObjectId($request->customerIndex),
                'attachements.' . $request->attachmentIndex . '.isPostedToCustomer' => 1
            ])
        ) {
            $success = 1;
        } else {
            $success = 0;
        }

        $this->updateCustomerDocuments(
            $request->customerIndex,
            $request->attachmentId,
            $request->mailIndex,
            $customer
        );

        while (1) {
            $ranKey = mt_rand(10000, 99999);
            $fname = "user_" . $ranKey . "@iibcare.com";
            $exist = Customer::where('userName', $fname)->get();
            if (count($exist) > 0) {
                continue;
            } else {
                break;
            }
        }
        if ($customer->userName == null) {
            Customer::where('_id', new ObjectId($request->customerIndex))
                ->update(['userName' => $fname, 'passCode' => $passWard]);
        } else {
            $fname = $customer->userName;
            $passWard = $customer->passCode;
        }
        if ($success == 1) {
            $mailIds = $request->mailTo;
            $mailCc = $request->mailCc;

            //to save details of mails to be sent next day morning.
            $this->toBeMailed($mailIds, $fname, $passWard, $customer->fullName, $mailCc);

            // foreach ($mailIds as $id) {
            //     if (filter_var($id, FILTER_VALIDATE_EMAIL)) {
            //         PostToCustomer::dispatch($id, $fname, $passWard, $customer->fullName, $mailCc);
            //     }
            // }
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * to generate randum number to make login dateails for customer when a document has been posted
     */
    private function generateRandomString($length = 10)
    {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * to download selected documents to loacal directory at a single click.
     */
    public function bulkDocumentDownload(Request $request)
    {
        // $data = Emails::select('attachements')->where('_id', $request->mailIndex)->first();
        $data = Emails::select('attachements')->find($request->mailIndex);
        return $data;
    }

    /**
     * to post selected documents to a selected customer.
     */
    public function postSelectedToCustomer(Request $request)
    {
        date_default_timezone_set('Asia/Dubai');
        // $customer = Customer::where('_id', new ObjectId($request->customer))->first();
        $customer = Customer::find($request->customer);
        $passWard = $this->generateRandomString(6);
        $fname = "";
        $ranKey = "";
        while (1) {
            $ranKey = mt_rand(10000, 99999);
            $fname = "user_" . $ranKey . "@iibcare.com";
            $exist = Customer::where('userName', $fname)->get();
            if (count($exist) > 0) {
                continue;
            } else {
                break;
            }
        }
        if ($customer->userName == null) {
            Customer::where('_id', new ObjectId($request->customer))
                ->update(['userName' => $fname, 'passCode' => $passWard]);
        } else {
            $fname = $customer->userName;
            $passWard = $customer->passCode;
        }

        $updates = $request->selects;
        // $data = Emails::select('attachements')->where('_id', $request->index)->first()->attachements;
        $data = Emails::select('attachements')->find($request->index)->attachements;
        $keys = [];
        foreach ($data as $key => $value) {
            if ($updates[$key] != "") {
                array_push($keys, $key);
                Emails::where('_id', $request->index)
                    ->update([
                        'attachements.' . $key . '.isPostedToCustomer' => 1,
                        'attachements.' . $key . '.postedToCustomerIndex' => new ObjectId($request->customer),
                    ]);
            }
        }
        $this->updateCustomerDocuments($request->customer, $updates, $request->index, $customer);
        $mailIds = $request->mailTo;
        $mailCc = $request->mailCc;

        //to save details of mails to be sent next day morning.
        $this->toBeMailed($mailIds, $fname, $passWard, $customer->fullName, $mailCc);

        return array(1, $keys);
    }

    /**
     * to save the selected details to an emails. not used now
     */
    public function saveSubmitActive(Request $request)
    {
        $mailId = $request->index;

        if (Emails::where('_id', new ObjectId($mailId))
            ->update([
                'assaignedTo.assaignStatusName' => $request->statusText,
                'assaignedTo.assaignStatus' => $request->statusValue,
                'mailStatus' => 0
            ])
        ) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * to display posted documents to a logined customer.
     */
    public function customerView(Request $request) //recheck
    {
        if (SharedDocuments::where('_id', new ObjectId($request->index))
            ->update(['customerViewed' => 1])
        ) {
            return 1;
        }
    }

    /**
     *  display the shered documents of customer to admin.
     */
    public function adminCustomerView() //to project customers views for admin
    {
        $role = session('role');
        $sessions = session('customer_view');
        if (isset($sessions)) {
            // $customer = Customer::select('fullName')->where('_id', $sessions)->first();
            $customer = Customer::select('fullName')->find($sessions);
            $docs = SharedDocuments::where('status', 1)->where('deleted', 0)
                ->where('customerId', $sessions)
                ->where(function ($query) use ($role) {
                    if ($role == "Coordinator") {
                        $coAgent = (string) session('assigned_agent');
                        $query->where('agentDetails.id', $coAgent);
                    } elseif ($role == "Agent") {
                        $query->where('agentDetails.id', (string) Auth::user()->_id);
                    }
                })->orderBy('uploadedUtcDate', 'desc')->get();
        } else {
            $docs = [];
            $customer = "";
        }

        return view('document_management.admin_customer_view')->with(compact('docs', 'customer'));
    }

    /**
     * in admin customer view => show the shared documents of selected customer.
     */
    public function chooseCustomer(Request $request) // for admin customer view to select customer....
    {
        $role = session('role');
        $customer = $request->customerId;
        if ($customer) {
            $docs = SharedDocuments::where('status', 1)->where('deleted', 0)
                ->where('customerId', $customer)
                ->where(function ($query) use ($role) {
                    if ($role == "Coordinator") {
                        $coAgent = (string) session('assigned_agent');
                        $query->where('agentDetails.id', $coAgent);
                    } elseif ($role == "Agent") {
                        $query->where('agentDetails.id', (string) Auth::user()->_id);
                    }
                })->orderBy('uploadedUtcDate', 'desc')->get();
            session(['customer_view' => $customer]);
        } else {
            $docs = "";
            session()->pull('customer_view');
        }
        return response()
            ->view('document_management.customer_documents_list', compact('docs', 'customer'));
    }

    /**
     * to search the documents at the admin customer view.
     */
    public function searchDoc(Request $request)
    {
        $searchKey = $request->key;
        $role = session('role');
        $customer = $request->customer;

        $docs = SharedDocuments::where('status', 1)->where('deleted', 0)
            ->where('customerId', $customer);
        if ($searchKey) {
            $docs->where(function($query) use ($searchKey) {
                $query->where('updatedFullName', 'like', '%' . $searchKey . '%')
                ->orWhere('documentContent', 'like', '%' . $searchKey . '%');
            });
            // $docs->where('updatedFullName', 'like', '%' . $searchKey . '%');
        }
        $docs->where(function ($query) use ($role) {
            if ($role == 'Agent') {
                $query->where('agentDetails.id', (string) Auth::user()->_id);
            } elseif ($role == 'Coordinator') {
                $coAgent = (string) session('assigned_agent');
                $query->where('agentDetails.id', $coAgent);
            }
        });
        $docs = $docs->orderBy('uploadedUtcDate', 'desc')->get();

        return response()
            ->view(
                'document_management.customer_documents_list',
                compact('docs', 'customer')
            );
    }

    /**
     * to search the documents at the customer login view.
     */
    public function searchCustomerDocument(Request $request)
    {
        $customer = $request->customer;
        $searchKey = $request->key;
        $docs = SharedDocuments::where('status', 1)->where('deleted', 0)
            ->where('customerId', $customer);
        if ($searchKey) {
            $docs->where(function($query) use ($searchKey) {
                $query->where('updatedFullName', 'like', '%' . $searchKey . '%')
                ->orWhere('documentContent', 'like', '%' . $searchKey . '%');
            });
            // $docs->where('updatedFullName', 'like', '%' . $searchKey . '%');
        }
        $docs = $docs->orderBy('uploadedUtcDate', 'desc')->get();

        return response()
            ->view(
                'document_management.customer_document.customer_document_search',
                compact('docs', 'customer')
            );
    }


    /**
     * to remove documents that has been shared with customer at the admin customer view
     */
    public function adminRemoveCustDoc(Request $request)
    {
        if (SharedDocuments::where('_id', new ObjectId($request->docIndex))
            ->update(['status' => 0])
        ) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * to share new documents =>to upload new file in admin customer view.
     */
    public function addFiles(Request $req)
    {
        date_default_timezone_set('Asia/Dubai');
        $now = date('d-m-Y h:i:s a');
        $utcDate = date_create_from_format('d-m-Y h:i:s a', $now);
        $utcDate->setTimezone(new \DateTimeZone('UTC'));
        $utcDate = $utcDate->format(DATE_ATOM);
        $additionalDocs = [];
        $urls = explode(',', $req->output_url);
        $fileNames = explode(',', $req->output_file);
        if ($urls == $fileNames) {
            return 0;
        }
        $length = count($urls);

        // $customerDetails = Customer::where('_id', new ObjectId($req->customer))->first();
        $customerDetails = Customer::find($req->customer);
        $agent = $customerDetails->agent;
        for ($i = 0; $i < $length; $i++) {
            $agentDetails = new \stdClass();
            $agentDetails->id = @$agent['id'] ? (string) $agent['id'] : "";
            $agentDetails->name = @$agent['name'] ?: "";


            $newFiles = new SharedDocuments();
            $newFiles->fileName = $fileNames[$i];
            $newFiles->filePath = $urls[$i];
            $newFiles->documentId = (string) time() . uniqid();
            $newFiles->updatedName = "";
            $newFiles->suffix = "";
            $newFiles->updatedFullName = $fileNames[$i];
            $newFiles->customerId = (string) $customerDetails->_id;
            $newFiles->customerName = $customerDetails->fullName;
            $newFiles->customerCode = $customerDetails->customerCode;
            $newFiles->agentDetails = $agentDetails;
            $newFiles->customerViewed = 0;
            $newFiles->uploadedAt = $now;
            $newFiles->uploadedUtcDate = $utcDate;
            $newFiles->status = 1;
            $newFiles->deleted = 0;
            $newFiles->save();
            $additionalDocs[] = $newFiles;
        }

        return json_encode($additionalDocs);
    }

    /**
     * gets all attachments of the given mail id.
     */
    public function findAttachments(Request $req)
    {
        $collect = Emails::select('attachements')->find(new ObjectId($req->index));
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
     * download shared documents
     */
    public function download(Request $req)
    {
        $assetPath = $req->index;
        if (isset($req->name)) {
            $name = $req->name;
        } else {
            $name = basename($assetPath);
        }
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=" . $name);
        // header("Content-Type: " . 'image/jpg');

        return readfile($assetPath);
    }

    /**
     * to display added emails at the setting section in document management.
     */
    public function documentViewSettings()
    {
        $credentials = EmailCredentials::where('credentialStatus', 1)->get();
        return view('document_management.document_management_view_settings')
            ->with(compact('credentials'));
    }

    /**
     * to show the add setting page for document management.
     */
    public function documentSettings()
    {
        $employees = User::where('isActive', 1)->whereIn('role', ['EM', 'SV'])->orderBy('name')->get();
        return view('document_management.document_management_settings', ['employees' => $employees]);
    }

    /**
     * to display edit page for added settings.
     */
    public function documentEditSettings(Request $request)
    {
        $data = EmailCredentials::find($request->id);
        $employees = User::where('isActive', 1)->whereIn('role', ['EM', 'SV'])->orderBy('name')->get();
        return view('document_management.document_management_edit_settings')
            ->with(compact('data', 'employees'));
    }

    /**
     * to display add page to enter new email credentials.
     */
    public function addCredentials(Request $request)
    {
        $data = new EmailCredentials();
        $username = $request->input('username');
        $check = EmailCredentials::where('userID', $username)->get();
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
        $total = $request->input('total');
        $closure = $request->input('cbx_closure');
        if (!isset($closure)) {
            $closure = [];
        }
        $statusList = [];
        for ($i = 0; $i <= $total; $i++) {
            $statusTxt = $request->input('status_txt_' . $i);
            if (isset($statusTxt)) {
                $statusObj = new \stdClass();
                $statusObj->statusName = $statusTxt;
                if (in_array($i, $closure)) {
                    $statusObj->closureProperty = 1;
                } else {
                    $statusObj->closureProperty = 0;
                }
                $statusList[] = $statusObj;
            }
        }
        $assignEmployee = $request->input('assign_employee');
        if ($assignEmployee != '' && $assignEmployee != '999') {
            $assignEmployee = new ObjectId($assignEmployee);
        } elseif ($assignEmployee == '999') {
            $assignEmployee = (string) $assignEmployee;
        } else {
            $assignEmployee = '';
        }
        $data->assignEmployee = $assignEmployee;
        $data->statusAvailable = $statusList;
        $data->credentialStatus = 1;
        if ($data->save()) {
            return 1;
        }
    }

    /**
     * to edit the existing credentials with new entered details.
     */
    public function editCredentials(Request $request)
    {
        $index = $request->input('credential_index');
        $username = $request->input('username');
        $check = EmailCredentials::where('userID', $username)
            ->where('_id', '!=', $index)->get();
        if (count($check) > 0) {
            return 0;
        }
        $password = $request->input('password');
        $confirm = $request->input('confirm_passWord');
        if ($password != $confirm) {
            return "passFail";
        }
        $total = $request->input('total');
        $closure = $request->input('cbx_closure');
        if (!isset($closure)) {
            $closure = [];
        }
        $statusList = [];
        for ($i = 0; $i <= $total; $i++) {
            $statusTxt = $request->input('status_txt_' . $i);
            if (isset($statusTxt)) {
                $statusObj = new \stdClass();
                $statusObj->statusName = $statusTxt;
                if (in_array($i, $closure)) {
                    $statusObj->closureProperty = 1;
                } else {
                    $statusObj->closureProperty = 0;
                }
                $statusList[] = $statusObj;
            }
        }
        $assignEmployee = $request->input('assign_employee');
        if ($assignEmployee != '' && $assignEmployee != '999') {
            $assignEmployee = new ObjectId($assignEmployee);
        } elseif ($assignEmployee == '999') {
            $assignEmployee = (string) $assignEmployee;
        } else {
            $assignEmployee = '';
        }
        if (EmailCredentials::where('_id', new ObjectId($index))
            ->update([
                'userID' => $username, 'passWord' => $password,
                'statusAvailable' => $statusList,
                'assignEmployee' => $assignEmployee
            ])
        ) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * to build excel file and download.
     */
    public function emailsToExcel(Request $request)
    {
        // dd("test");
        $documentStatus = (int) $request->status;
        $user = $request->mailBox;
        $data = Emails::select(
            'documentMailBox',
            'subject',
            'from',
            'recieveTime',
            'assaignedTo',
            'notes',
            'updated_at'
        )
            ->where('mailStatus', (int) $documentStatus)->where('documentMailBox', $user)
            ->where('deleted', '!=', 1);
        if ($request->status == 1) {
            $stat = session('documentFilter.statusList');
            $cust = session('documentFilter.customerList');
            $agen = session('documentFilter.agentList');
            $custAgent = session('documentFilter.customerAgentList');
            $mailFrom = session('documentFilter.from');
            $fromDate = session('documentFilter.fromDate');
            $toDate = session('documentFilter.toDate');
            $key = session('activeSearchKey');
            $order = session('enquiryFilter.order');
        } elseif ($request->status == 0) {
            $stat = session('closedDocumentFilter.statusList');
            $cust = session('closedDocumentFilter.customerList');
            $agen = session('closedDocumentFilter.agentList');
            $custAgent = session('closedDocumentFilter.customerAgentList');
            $mailFrom = session('closedDocumentFilter.from');
            $fromDate = session('closedDocumentFilter.fromDate');
            $toDate = session('closedDocumentFilter.toDate');
            $key = session('closedSearchKey');
        }
        if (isset($fromDate)) {
            $data->where('mailRecTime', '>=', $fromDate);
        }
        if (isset($toDate)) {
            $data->where('mailRecTime', '<=', $toDate);
        }
        if (isset($mailFrom)) {
            $data->whereIn('from', $mailFrom);
        }
        if (isset($stat)) {
            $data->whereIn('assaignedTo.assaignStatusName', $stat);
        }
        if (isset($cust)) {
            $data->whereIn('assaignedTo.customerId', $cust);
        }
        if (isset($custAgent)) {
            $data->whereIn('assaignedTo.customerAgentId', $custAgent);
        }
        if (isset($agen)) {
            $data->whereIn('assaignedTo.agentId', $agen);
        }
        if (isset($key)) {
            $data = $data->where(function ($query) use ($key) {
                $query->where('subject', 'like', '%' . $key . '%')
                    ->orWhere('mailsText', 'like', '%' . $key . '%')
                    ->orWhere('attachements.attachName', 'like', '%' . $key . '%')
                    ->orWhere('attachements.attachContent', 'like', '%' . $key . '%');
            });
        }
        // if (isset($order) && $order == 'latest') {
        //     $data = $data->orderBy('created_at', 'desc');
        // } else if (isset($order) && $order == 'earliest') {
        //     $data = $data->orderBy('created_at', 'asc');
        // } else {
        //     $data = $data->orderBy('created_at', 'asc');
        // }
        if (session('role') == 'Admin') {
            $data = $data->get();
        } elseif (session('role') == 'Employee' && $documentStatus == 1) {
            $data = $data->whereIn('assaignedTo.agentId', [new ObjectId(Auth::user()->_id), "999"]);
            $data = $data->get();
        } elseif (session('role') == 'Employee' && $documentStatus == 0) {
            $data = $data->get();
        } elseif (session('role') == 'Coordinator') {
            if (!isset($custAgent)) {
                $coAgent = (string) session('assigned_agent');
                $data = $data->where('assaignedTo.customerAgentId', $coAgent)->get();
            } else {
                $data = $data->get();
            }
        } elseif (session('role') == 'Agent') {
            if (!isset($custAgent)) {
                $data = $data->where('assaignedTo.customerAgentId', Auth::user()->_id)->get();
            } else {
                $data = $data->get();
            }
        } elseif (session('role') == 'Supervisor' && $documentStatus == 1) {
            $employees = session('employees') ?: [];
            $employees = array_merge($employees, ["999", "", new ObjectId(Auth::user()->_id), null]);
            $data->whereIn('assaignedTo.agentId', $employees);
            $data = $data->get();
        } elseif (session('role') == 'Supervisor' && $documentStatus == 0) {
            $data = $data->options(['AllowDiskUse' => true])->get();
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
            'Agent',
            'Assigned To',
            'Current Status',
            'Note 1',
            'Note 2',
            'Note 3',
            'Last Updated Date & Time'
        ];
        foreach ($data as $key => $value) {
            $assigned = $value->assaignedTo;
            $notes = $value->notes;
            $lastUpdated = $value->updated_at;
            $lastUpdated = $lastUpdated->format('d-m-Y h:i:s a');
            $time = Carbon::createFromFormat('l jS \\of F Y h:i:s A', $value->recieveTime);
            $time = $time->format('d-m-Y h:i:s a');
            $information[] = [
                $value->documentMailBox,
                $value->subject ?: '--',
                $value->from,
                $time,
                $assigned['customerName'] ?: '--',
                $assigned['customerAgentName'] ?: '--',
                $assigned['agentName'] ?: '--',
                $assigned['assaignStatusName'] ?: '--',
                $notes['note1'] ?: '--',
                $notes['note2'] ?: '--',
                $notes['note3'] ?: '--',
                $lastUpdated
            ];
        }
        Excel::create('Document-List', function ($excel) use ($information) {
            $excel->sheet('Email-Documents', function ($sheet) use ($information) {
                $sheet->mergeCells('A1:L1');
                $sheet->cells('A1:L1', function ($cells) {
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
            });
        })->download('xls');
    }


    /**
     * to delete the closed tasks from closed queue window. the deleted task won't be displayed anywhere.
     */
    public function deleteTask(Request $request)
    {
        $id = $request->input('index');
        $result = Emails::where('_id', new ObjectId($id))
            ->update(['deleted' => (int) 1]);
        return $result;
    }


    /**
     * to save the mails to be dispatched for next day.
     */
    private function toBeMailed($mailIds, $username, $password, $customerName, $mailCc)
    {
        $mailIds = $mailIds ?: [];
        $mailCc = $mailCc ?: [];
        $existing = PostDocumentMails::where('status', 1)->where('dispatchStatus', 0)->where('deleted', 0)
            ->where('customerName', $customerName)
            ->first();
        $mailCc = $mailCc ?: [];
        $lastUpdated = date('d-m-Y h:i:s a');
        $time = Carbon::createFromFormat('d-m-Y h:i:s a', $lastUpdated);
        $time->setTimezone(new \DateTimeZone('UTC'));
        $lastUpdatedUtc = $time->format(DATE_ATOM);

        if (count($existing)) {
            $to = $existing->to ?: [];
            $cc = $existing->cc ?: [];
            $to = array_merge($to, $mailIds);
            $cc = array_merge($cc, $mailCc);
            $to = array_values(array_unique($to));
            $cc = array_values(array_unique($cc));
            PostDocumentMails::where('status', 1)->where('dispatchStatus', 0)
                ->where('deleted', 0)->where('customerName', $customerName)
                ->update(
                    [
                        'to' => $to,
                        'cc' => $cc,
                        'lastUpdated' => $lastUpdated,
                        'lastUpdatedUtc' => $lastUpdatedUtc
                    ]
                );
        } else {
            $newMail = new PostDocumentMails();
            $newMail->customerName = $customerName;
            $newMail->userName = $username;
            $newMail->password = $password;
            $newMail->to = $mailIds ?: [];
            $newMail->cc = $mailCc ?: [];
            $newMail->dispatchStatus = 0;
            $newMail->status = 1;
            $newMail->deleted = 0;
            $newMail->lastUpdated = $lastUpdated;
            $newMail->lastUpdatedUtc = $lastUpdated;
            $newMail->save();
        }
    }

    /**
     * to sent collected post-to-customer mails. this function is used by cronjob.
     */
    public static function sendCollectedMails()
    {
        $successCount = 0;
        $failedCount = 0;
        $success = [];
        $failed = [];
        $collected = PostDocumentMails::where('status', 1)
            ->where('dispatchStatus', 0)
            ->where('deleted', 0)
            ->get();
        foreach ($collected as $key => $mail) {
            $mailIds = $mail->to;
            $mailCc = $mail->cc;
            $username = $mail->userName;
            $password = $mail->password;
            $name = $mail->customerName;
            foreach ($mailIds as $id) {
                if (filter_var($id, FILTER_VALIDATE_EMAIL)) {
                    PostToCustomer::dispatch($id, $username, $password, $name, $mailCc);
                    $successCount++;
                } else {
                    $failed[] = $id;
                    $failedCount++;
                }
            }
            PostDocumentMails::where('status', 1)
                ->where('dispatchStatus', 0)
                ->where('deleted', 0)
                ->where('customerName', $name)
                ->update(
                    [
                        'status' => 0,
                        'dispatchStatus' => 1,
                        'deleted' => 1,
                        'mailSuccess' => $successCount,
                        'failed' => $failedCount,
                        'failedMailIds' => $failed
                    ]
                );
        }
        echo "\n success: " . $successCount;
    }









    //....................MIGRATIONS..........................................................................*********



    /**
     * migration to update customerDocument collection with agents
     */
    public function migrateCustomerDocument()
    {
        $count = 0;
        $custDoc = CustomerDocuments::all();
        foreach ($custDoc as $key => $doc) {
            $result = Customer::where('_id', new ObjectId($doc->customerId))->first();
            $name = $result->fullName;
            $agent = $result->agent;
            $code = $result->customerCode;
            $newObj = new \stdClass();
            $newObj->id = (string) $agent['id'];
            $newObj->name = $agent['name'];
            if (CustomerDocuments::where('customerId', $doc->customerId)
                ->update(
                    [
                        'agentDetails' => $newObj,
                        'customerCode' => $code,
                        'customerName' => $name
                    ]
                )
            ) {
                $count++;
                echo "<br> success";
            } else {
                echo "<br> failed";
            }
        }
        echo "<br>" . $count . "\t\t\t finished <br>";
        return "completed";
    }

    /**
     * migration to create documents in sharedDocument from customerDocuments collection
     */
    public function migrateSharedDocument()
    {
        $result = CustomerDocuments::all();
        $count = 0;
        $fail = 0;
        $array = [];
        foreach ($result as $key => $doc) {
            $documents = $doc->documents;
            foreach ($documents as $key2 => $dt) {
                $newDoc = new SharedDocuments();
                $newDoc->fileName = $dt['fileName'];
                $newDoc->filePath = $dt['filePath'];
                $newDoc->documentId = $dt['id'];
                $ext = pathinfo($dt['filePath'], PATHINFO_EXTENSION);
                $upName = @$dt['updatedName'] ?: "";
                $upName = $upName . ($upName ? (@$dt['suffix'] ? "-" . $dt['suffix'] : "") : "");
                $upName = ($upName ? ($upName . "." . $ext) : "");
                $upName = $upName ?: $dt['fileName'];
                $newDoc->updatedName = @$dt['updatedName'] ?: "";
                $newDoc->suffix = @$dt['suffix'] ?: "";
                $newDoc->updatedFullName = $upName;
                $newDoc->customerId = $doc->customerId;
                $newDoc->customerName = $doc->customerName;
                $newDoc->customerCode = $doc->customerCode;
                $agent = $doc->agentDetails;
                $newAg = new \stdClass();
                $newAg->id = $agent['id'];
                $newAg->name = $agent['name'];
                $newDoc->agentDetails = $newAg;
                $newDoc->customerViewed = (int) $dt['customerViewed'];
                $date = Carbon::createFromFormat('d-m-y h:i:s a', $dt['uploadedAt']);
                $utcDate = date_create_from_format('d-m-y h:i:s a', $dt['uploadedAt']);
                $utcDate->setTimezone(new \DateTimeZone('UTC'));
                $utcDate = $utcDate->format(DATE_ATOM);
                $date = $date->format('d-m-Y h:i:s a');
                $newDoc->uploadedAt = $date;
                $newDoc->uploadedUtcDate = $utcDate;
                $newDoc->status = (int) $dt['status'];
                $newDoc->deleted = 0;
                if ($newDoc->save()) {
                    $count++;
                } else {
                    $fail++;
                    $array[] = ['customer' => $doc->customerId, 'docId' => $dt['id']];
                }
            }
        }
        echo "success : $count <br> failed : $fail";
        foreach ($array as $item) {
            echo "<br> cust: " . $item['customer'] . " <br> docId: " . $item['docId'];
        }
    }

    /**
     * migration to create time field in emails collection for sorting purpose
     */
    public function convertingToSort()
    {
        // Emails::whereIn('mailStatus', [1, 0])->unset(['mailRecTme']);
        $tasks=Emails::all();
        foreach ($tasks as $task) {
            $time= Carbon::createFromFormat('l jS \\of F Y h:i:s A', $task->recieveTime)->timestamp;
            $newFormat= new \MongoDB\BSON\UTCDateTime($time * 1000);
            // dd($task->recieveTime, $time, $newFormat->timezone());
            $task->mailRecTime= $newFormat;
            $task->save();
        }
    }
    /**
     * function for update notifiaction for newly assigned employees
     */
    public function updateNotification(Request $req)
    {
       $mailId=new ObjectId($req->id);
       $email=Emails::find($mailId);
       if(isset($email->assignSeenID)){
           $assignSeenID=$email->assignSeenID;
       }else{
           $assignSeenID=[];
       }
       if(isset($email->newNotification) && $email->newNotification!=''){
           if(new ObjectId(Auth::id())==$email->newNotification){
               Emails::where('_id', $mailId)->unset('newNotification');
           }
           if($email->newNotification=='999' && !in_array(Auth::id(),$assignSeenID)){
               $email->push('assignSeenID', new ObjectId(Auth::id()));
               $email->save();
           }
       }
       return response()->json(['status'=>'success']);
    }

    /**
     * to update pdf contents to sharedDocuments collection from emails collection
     */
    public function migrateAttachContent()
    {
        $count = SharedDocuments::count();
        for($key=0;$key<$count;$key=$key+500) {
            $documents = SharedDocuments::skip($key)->take(500)->get();
            foreach ($documents as $key1 => $doc) {
                $mail = Emails::where('attachements.attachId', $doc->documentId)->first();
                if ($mail) {
                    $attachments = $mail->attachements;
                    foreach ($attachments as $attach) {
                        if($attach['attachId'] == $doc->documentId) {
                            $content = @$attach['attachContent']?:"";
                            SharedDocuments::where('documentId', $doc->documentId)
                                ->update(['documentContent' => $content]);
                        }
                    }
                    dump($doc->_id);
                }
            }
        }
    }





////////////////////////////////////////test//////////////////////////////////////////////////////////

     /**
     * for code test and not a part of this module
     */
    public function test(Request $request)
    {
        // if (Emails::where('_id', new ObjectId("5d00e90225946b362b468bf2"))
        //     ->update(['attachements.6.suffix' => "some"])) {
        //     echo "success";
        // } else {
        //     echo "failed";
        // }
        SharedDocuments::where('documentContent', 'exists', true)->unset('documentContent');
        // $var = User::where('employees.id', new ObjectId('5be3f9b1ec47fb049233a777'))->get();
        // dd($var);
    }

}




