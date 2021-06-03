<?php

namespace App\Http\Controllers;

use App\Customer;
use App\DocumentType;
use App\Jobs\SendcasemanagerADleads;
use App\Jobs\SendCaseManagerDelivery;
use App\Jobs\SendCustomer;
use App\Jobs\SendCustomerDelivery;
use App\Jobs\SendReceptionADleads;
use App\Jobs\SendReceptionDelivery;
use App\LeadDetails;
use App\Mail\sendMailToAgent;
use App\RecipientDetails;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use MongoDB\BSON\ObjectID;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use FCM;

class ApiController extends Controller
{
    /**
     * function to check login authentication
     */
    public function Login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',

        ]); // for input field validation
        if ($validator->fails()) {
            return response()
                ->json([
                    'status' => "error",
                    'data' => null,
                    "messages" => $validator->errors()], 202);
        } else {
            $email = $request->input('email');
            $password = $request->input('password');
            $latitude = $request->input('Latitude');
            $longitude = $request->input('Longitude');
            $token = $request->input('Token');
            //  check email is exist in database and verifying requested password against a Hash from database
            $credential = User::where('isActive', 1)->where('email', $email)->first();
            if ($credential) {
                if (Hash::check($password, $credential->password) && $credential) {
                    if ($latitude!='' && $longitude!='') {
                        $CurrentLocation=[];
                        $empids=[];
                        date_default_timezone_set('Asia/Dubai');
                        $submit_time = date('H:i:s');
                        $live_object = new \stdClass();
                        $live_object->location =  ['type' => 'Point', 'coordinates' => [$latitude,$longitude]];
                        $live_object->updateBy = $credential->name;
                        $live_object->updateByID = new ObjectID($credential->_id);
                        $live_object->deliveryDate =date('d/m/Y');
                        $live_object->deliveryTime =$submit_time;
                        $CurrentLocation[] = $live_object;
                        $credential->liveLocation = $CurrentLocation;
                    }
                    $credential->Token=$token;
                    $userid = $credential->_id;
                    $credential->save();
                    $role = $credential->role_name;
                    $roleAbbr = $credential->role;
                    if ($roleAbbr=='CO') {
                        $assigned_agent = new ObjectID($credential['assigned_agent']['id']);
                    } else {
                        $assigned_agent='';
                    }
                    if ($roleAbbr=='SV') {
                        $employees = $credential->employees;
                        if (isset($employees) && !empty($employees)) {
                            $empids = $this->collectEmployees($employees);
                            $empids = array_values(array_unique($empids));
                        } else {
                            $empids=[];
                        }
                    } else {
                        $empids=[];
                    }
                    $username = $credential->name;
                    if ($credential->role != "AD" &&$credential->role != "CO" && $credential->role != "SV") {
                        $LeadDetails = LeadDetails::where('active', 1)->where('scheduledTabStatus', 1)->where('employee.id', new ObjectID($userid))->orderBy('updated_at', 'DESC')->get();
                    } elseif ($credential->role == "CO") {
                        $LeadDetails = LeadDetails::where('active', 1)->where('scheduledTabStatus', 1)->where(function ($q) use ($assigned_agent, $userid) {
                              $q->where('employee.id', new ObjectID($userid))
                                ->orwhere('employee.id', $assigned_agent);
                        })
                        ->orderBy('updated_at', 'DESC')->get();
                    } elseif ($credential->role == "SV") {
                        $LeadDetails = LeadDetails::where('active', 1)->where('scheduledTabStatus', 1)->where(function ($q) use ($empids, $userid) {
                              $q->where('employee.id', new ObjectID($userid))
                                ->orwhereIn('employee.id', $empids);
                        })
                        ->orderBy('updated_at', 'DESC')->get();
                    } else {
                        $LeadDetails = LeadDetails::where('active', 1)->where('scheduledTabStatus', 1)->orderBy('updated_at', 'DESC')->get();
                    }
                    if (count($LeadDetails)>0) {
                        $data_array = [];
                        foreach ($LeadDetails as $leads) {
                            $leadId = $leads['_id'];
                            $referenceNumber = $leads['referenceNumber'];
                            $customerName = $leads['customer.name'];
                            $contact = $leads->contactNumber;
                            $recipientName = $leads['customer.recipientName'];
                            $code = $leads['customer.customerCode']?:'NA';
                            if (isset($leads['agent.name'])) {
                                $agentname = ucwords(strtolower($leads['agent.name']));
                                if (isset($leads['agent.empid'])) {
                                    if ($leads['agent.empid'] !="") {
                                        $agentid = $leads['agent.empid'];
                                        $agentvalue = $agentname.' ('.$agentid.')';
                                    } else {
                                        $agentvalue = $agentname;
                                    }
                                } else {
                                    $agentvalue = $agentname;
                                }
                            } else {
                                $agentvalue = 'NA';
                            }
                            $agent = $agentvalue;
                            $email = $leads->contactEmail;
                            $caseManager = $leads['caseManager.name'];
                            $dispatchType = $leads['dispatchType.dispatchType'];
                            $deliveryMode = $leads['deliveryMode.deliveryMode'];
                            if (isset($leads['deliveryMode.wayBill'])) {
                                $waybill = $leads['deliveryMode.wayBill'];
                            } else {
                                $waybill = "NA";
                            }
                            if (isset($leads->employee['name'])) {
                                $assignname = ucwords(strtolower($leads->employee['name']));
                                if (isset($leads->employee['empId'])) {
                                    if ($leads->employee['empId'] !="") {
                                        $assignid = $leads->employee['empId'];
                                        $assignvalue = $assignname.' ('.$assignid.')';
                                    } else {
                                        $assignvalue = $assignname;
                                    }
                                } else {
                                    $assignvalue = $assignname;
                                }
                            } else {
                                $assignvalue = '--';
                            }
                            $assign = $assignvalue;
                            $status = $leads['dispatchStatus'];
                            $created = $leads['created_at'];
                            $address = $leads['dispatchDetails']['address'];
                            $landmark = $leads['dispatchDetails']['land_mark'];
                            $preferreddate = $leads['dispatchDetails']['date_time'];
                            if ($leads['dispatchDetails']['documentDetails']) {
                                $document = $leads['dispatchDetails']['documentDetails'];
                                $doc_array = [];
                                foreach ($document as $key => $doc) {
                                    if ($doc['DocumentCurrentStatus'] == 13) {
                                        $documentId = $doc['id'];
                                        $documentName = $doc['documentName'];
                                        $documentDescription = $doc['documentDescription'];
                                        $documentType = $doc['documentType'];
                                        $DocumentCurrentStatus = $doc['DocumentCurrentStatus'];
                                        $amount = $doc['amount']?:'NA';
                                        if (isset($doc['doc_collected_amount'])) {
                                            $collectedamount = $doc['doc_collected_amount'];
                                        } else {
                                            $collectedamount = "--";
                                        }
                                        $doc_array[] = array('documentId' => (string)$documentId, 'documentName' => $documentName, 'documentDescription' => $documentDescription, 'documentType' => $documentType, 'DocumentCurrentStatus' => $DocumentCurrentStatus, 'amount' => $amount, 'collectedamount' => $collectedamount);
                                    }
                                }
                            } else {
                                $doc_array = null;
                            }

                            if (isset($leads['comments'])) {
                                $comment_array = [];
                                foreach ($leads['comments'] as $comment) {
                                    if (isset($comment['docId'])) {
                                        $docId = $comment['docId'];
                                    } else {
                                        $docId = "";
                                    }
                                    $commentBy = $comment['commentBy'];
                                    $date = $comment['date'];
                                    $time = $comment['commentTime'];
                                    $remark = $comment['comment'];
                                    $comment_array[] = array('commenteddocument' => $docId, 'commentBy' => $commentBy, 'date' => $date, 'time' => $time, 'comment' => $remark);
                                }
                            } else {
                                $comment_array = null;
                            }
                            if ($leads['deliveryTabStatus'] == 1) {
                                $lead_status = 'Delivery';
                            } else {
                                $lead_status = 'Schedule for delivery/collection';
                            }
                            $data_array[] = array('leadId' => $leadId, 'referenceNumber' => $referenceNumber, 'customerName' => $customerName, 'contact' => $contact, 'recipientName' => $recipientName, 'code' => $code, 'creationdate' => $created, 'agent' => $agent, 'caseManager'
                            => $caseManager, 'dispatchType' => $dispatchType, 'deliveryMode' => $deliveryMode, 'email' => $email, 'waybill' => $waybill, 'assign' => $assign, 'status' => $status, 'address' => $address, 'landmark' => $landmark, 'preferreddate' => $preferreddate,
                                'DocumentDetails' => $doc_array, 'Commentdetails' => $comment_array,'role' => $role, 'leadStatus' => $lead_status,'UserName'=>$username,'UserId'=>$userid);
                        }
                        return response()
                            ->json([
                                'status' => "success",
                                'data' => array('LeadDetails' => $data_array,'user_id' => $userid),
                            ], 201);
                    } else {
                        return response()
                            ->json([
                                'status' => "no documents",
                                'data' => array('user_id' => $userid),
                                'messages' => array('Not Found' => array('Documents not Found'))
                            ], 202);
                    }
                } else {
                    return response()
                        ->json([
                            'status' => "error",
                            'data' => null,
                            'messages' => array('InvalidUser' => array('Invalid Username or Password'))
                        ], 202);
                }
            } else {
                return response()
                    ->json([
                        'status' => "error",
                        'data' => null,
                        'messages' => array('InvalidUser' => array('Invalid Username or Password'))
                    ], 202);
            }
        }
    }
    
    /**
     *API for delivery
     */
    public function DeliveryList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        
        ]); // for input field validation
        if ($validator->fails()) {
            return response()
                ->json([
                    'status' => "error",
                    'data' => null,
                    "messages" => $validator->errors()], 202);
        } else {
            $email = $request->input('email');
            $password = $request->input('password');
            //  check email is exist in database and verifying requested password against a Hash from database
            $credential = User::where('isActive', 1)->where('email', $email)->first();
            if ($credential) {
                if (Hash::check($password, $credential->password) && $credential) {
                    $userid = $credential->_id;
                    $role = $credential->role_name;
                    $username = $credential->name;
                    $roleAbbr = $credential->role;
                    $empids=[];
                    if ($roleAbbr=='CO') {
                        $assigned_agent = new ObjectID($credential['assigned_agent']['id']);
                    } else {
                        $assigned_agent='';
                    }
                    if ($roleAbbr=='SV') {
                        $employees = $credential->employees;
                        if (isset($employees) && !empty($employees)) {
                            $empids = $this->collectEmployees($employees);
                            $empids = array_values(array_unique($empids));
                        } else {
                            $empids=[];
                        }
                    } else {
                        $empids=[];
                    }
                    // dd($assigned_agent);
                    if ($credential->role != "AD" && $credential->role != "CO" && $credential->role != "SV") {
                        $LeadDetails = LeadDetails::where('active', 1)->where('deliveryTabStatus', 1)->where('employee.id', new ObjectID($userid))->orderBy('updated_at', 'DESC')->get();
                    } elseif ($credential->role == "CO") {
                        $LeadDetails = LeadDetails::where('active', 1)->where('deliveryTabStatus', 1)->where(function ($q) use ($assigned_agent, $userid) {
                              $q->where('employee.id', new ObjectID($userid))
                                ->orwhere('employee.id', $assigned_agent);
                        })
                        ->orderBy('updated_at', 'DESC')->get();
                    } elseif ($credential->role == "SV") {
                        $LeadDetails = LeadDetails::where('active', 1)->where('deliveryTabStatus', 1)->where(function ($q) use ($empids, $userid) {
                              $q->where('employee.id', new ObjectID($userid))
                                ->orwhereIn('employee.id', $empids);
                        })
                        ->orderBy('updated_at', 'DESC')->get();
                    } else {
                        $LeadDetails = LeadDetails::where('active', 1)->where('deliveryTabStatus', 1)->orderBy('updated_at', 'DESC')->get();
                    }
                    if (count($LeadDetails)>0) {
                        $data_array = [];
                        foreach ($LeadDetails as $leads) {
                            $leadId = $leads['_id'];
                            $referenceNumber = $leads['referenceNumber'];
                            $customerName = $leads['customer.name'];
                            $contact = $leads->contactNumber;
                            $recipientName = $leads['customer.recipientName'];
                            $code = $leads['customer.customerCode']?:'NA';
                            if (isset($leads['agent.name'])) {
                                $agentname = ucwords(strtolower($leads['agent.name']));
                                if (isset($leads['agent.empid'])) {
                                    if ($leads['agent.empid'] !="") {
                                        $agentid = $leads['agent.empid'];
                                        $agentvalue = $agentname.' ('.$agentid.')';
                                    } else {
                                        $agentvalue = $agentname;
                                    }
                                } else {
                                    $agentvalue = $agentname;
                                }
                            } else {
                                $agentvalue = 'NA';
                            }
                            $agent = $agentvalue;
                            $email = $leads->contactEmail;
                            $caseManager = $leads['caseManager.name'];
                            $dispatchType = $leads['dispatchType.dispatchType'];
                            $deliveryMode = $leads['deliveryMode.deliveryMode'];
                            if (isset($leads['deliveryMode.wayBill'])) {
                                $waybill = $leads['deliveryMode.wayBill'];
                            } else {
                                $waybill = "NA";
                            }
                            if (isset($leads->employee['name'])) {
                                $assignname = ucwords(strtolower($leads->employee['name']));
                                if (isset($leads->employee['empId'])) {
                                    if ($leads->employee['empId'] !="") {
                                        $assignid = $leads->employee['empId'];
                                        $assignvalue = $assignname.' ('.$assignid.')';
                                    } else {
                                        $assignvalue = $assignname;
                                    }
                                } else {
                                    $assignvalue = $assignname;
                                }
                            } else {
                                $assignvalue = '--';
                            }
                            $assign = $assignvalue;
                            $status = $leads['dispatchStatus'];
//                       $created= Carbon::parse($leads['created_at'])->format('d/m/Y');
                            $created = $leads['created_at'];
//                       if(isset($leads['saveType']))
//                       {
//                           if($leads['saveType']=='recipient')
//                           {
//                               $customercode=$leads['customer.id'];
//                               $customer = RecipientDetails::find($customercode);
//                           } else {
//                               $customercode =  $leads['customer.customerCode'];
//                               $customer = Customer::where('customerCode', $customercode)->first();
//                           }
//                       }
//                       if ($customer->addressLine2 != '') {
//                           $address2 = ',' . $customer->addressLine2;
//                       } else {
//                           $address2 = '';
//                       }
//                       $cityName = ',' . $customer->cityName;
//                       $address = $customer->addressLine1 . '' . $address2 . '' . $cityName;
                            $address = $leads['dispatchDetails']['address'];
                            $landmark = $leads['dispatchDetails']['land_mark'];
                            $preferreddate = $leads['dispatchDetails']['date_time'];
                            if ($leads['dispatchDetails']['documentDetails']) {
                                $document = $leads['dispatchDetails']['documentDetails'];
                                $doc_array = [];
                                foreach ($document as $key => $doc) {
                                    if ($doc['DocumentCurrentStatus'] == 3 || $doc['DocumentCurrentStatus'] == 11) {
                                        $documentId = $doc['id'];
                                        $documentName = $doc['documentName'];
                                        $documentDescription = $doc['documentDescription'];
                                        $documentType = $doc['documentType'];
                                        $DocumentCurrentStatus = $doc['DocumentCurrentStatus'];
                                        $amount = $doc['amount']?:'NA';
                                        if (isset($doc['doc_collected_amount'])) {
                                            $collectedamount = $doc['doc_collected_amount'];
                                        } else {
                                            $collectedamount = "--";
                                        }
                                        $doc_array[] = array('documentId' => (string)$documentId, 'documentName' => $documentName, 'documentDescription' => $documentDescription, 'documentType' => $documentType, 'DocumentCurrentStatus' => $DocumentCurrentStatus, 'amount' => $amount, 'collectedamount' => $collectedamount);
                                    }
                                }
                            } else {
                                $doc_array = null;
                            }
                            
                            if (isset($leads['comments'])) {
                                $comment_array = [];
                                foreach ($leads['comments'] as $comment) {
                                    if (isset($comment['docId'])) {
                                        $docId = $comment['docId'];
                                    } else {
                                        $docId = "";
                                    }
                                    $commentBy = $comment['commentBy'];
                                    $date = $comment['date'];
                                    $time = $comment['commentTime'];
                                    $remark = $comment['comment'];
                                    $comment_array[] = array('commenteddocument' => $docId, 'commentBy' => $commentBy, 'date' => $date, 'time' => $time, 'comment' => $remark);
                                }
                            } else {
                                $comment_array = null;
                            }
                            if ($leads['deliveryTabStatus'] == 1) {
                                $lead_status = 'Delivery';
                            } else {
                                $lead_status = 'Schedule for delivery/collection';
                            }
                            $data_array[] = array('leadId' => $leadId, 'referenceNumber' => $referenceNumber, 'customerName' => $customerName, 'contact' => $contact, 'recipientName' => $recipientName, 'code' => $code, 'creationdate' => $created, 'agent' => $agent, 'caseManager'
                            => $caseManager, 'dispatchType' => $dispatchType, 'deliveryMode' => $deliveryMode, 'email' => $email, 'waybill' => $waybill, 'assign' => $assign, 'status' => $status, 'address' => $address, 'landmark' => $landmark, 'preferreddate' => $preferreddate,
                                'DocumentDetails' => $doc_array, 'Commentdetails' => $comment_array,'role' => $role, 'leadStatus' => $lead_status,'UserName'=>$username,'UserId'=> $userid);
                        }
                        return response()
                            ->json([
                                'status' => "success",
                                'data' => array('LeadDetails' => $data_array, 'user_id' => $userid),
                            ], 201);
                    } else {
                        return response()
                            ->json([
                                'status' => "no documents",
                                'data' => array('user_id' => $userid),
                                'messages' => array('Not Found' => array('Documents not Found'))
                            ], 202);
                    }
                } else {
                    return response()
                        ->json([
                            'status' => "error",
                            'data' => null,
                            'messages' => array('InvalidUser' => array('Invalid Username or Password'))
                        ], 202);
                }
            } else {
                return response()
                    ->json([
                        'status' => "error",
                        'data' => null,
                        'messages' => array('InvalidUser' => array('Invalid Username or Password'))
                    ], 202);
            }
        }
    }
    
    /**
     * function for getting lead
     */
    public function getlead(Request $request)
    {
        $valid=Validator::make($request->all(), [
            'userId' => 'required',
            'role' =>'required'
        ]);

        if ($valid->fails()) {
            return response()
                ->json([
                    'status'=> "error",
                    'data' => null,
                    'messages'=>$valid->errors()
                ], 200);
        } else {
            $userid=$request->input('userId');
            $role=$request->input('role');
            if (User::where('_id', new ObjectID($userid))->exists()) {
                if ($role == "Employee") {
                    $LeadDetails = LeadDetails::where('caseManager.id', new ObjectID($userid))->orwhere('agent.id', new ObjectID($userid))->orwhere('employee.id', new ObjectID($userid));
                } elseif ($role == "Agent") {
                    $LeadDetails = LeadDetails::where('agent.id', new ObjectID($userid))->orwhere('employee.id', new ObjectID($userid));
                } elseif ($role != "Admin" && $role != "Receptionist") {
                    $LeadDetails = LeadDetails::where('employee.id', new ObjectID($userid));
                }
                $final_leads = $LeadDetails->orderBy('updated_at', 'DESC')->get();
                $data_array = [];
                foreach ($final_leads as $key => $leads) {
                    $leadId=$leads['_id'];
                    $referenceNumber=$leads['referenceNumber'];
                    $customerName = $leads['customer.name'];
                    $contact = $leads->contactNumber;
                    $recipientName = $leads['customer.recipientName'];
                    $code = $leads['customer.customerCode'];
                    if (isset($leads['agent.name'])) {
                        $agent = $leads['agent.name'];
                    } else {
                        $agent = "NA";
                    }
                    $caseManager = $leads['caseManager.name'];
                    $dispatchType = $leads['dispatchType.dispatchType'];
                    $deliveryMode = $leads['deliveryMode.deliveryMode'];
                    $assign = $leads->employee['name'];
                    $status = $leads['dispatchStatus'];
                    $created= Carbon::parse($leads['created_at'])->format('d/m/Y');
                    $data_array[]=array('leadId'=>$leadId,'referenceNumber'=>$referenceNumber,'customerName'=>$customerName,'contact'=>$contact,'recipientName'=> $recipientName,'code' =>$code,'creationdate'=>$created,'agent'=> $agent,'caseManager'
                    =>$caseManager,'dispatchType'=>$dispatchType,'deliveryMode'=>$deliveryMode,'assign'=>$assign,'status'=>$status);
                }
                $data = array(
                    'data' =>  $data_array,
                );
                return response()
                    ->json([
                        'status'=> "success",
                        'data' => $data,
                    ], 201);
            } else {
                return response()
                    ->json([
                        'status' => "error",
                        'data' => null,
                        'messages' => array('notFound' => array('User not found'))
                    ], 202);
            }
        }
    }
    /**
     * function for getting lead details
     */
    public function getleadDetails(Request $request)
    {
        $valid=Validator::make($request->all(), [
            'leadId' => 'required',
        ]);
        if ($valid->fails()) {
            return response()
                ->json([
                    'status'=> "error",
                    'data' => null,
                    'messages'=>$valid->errors()
                ], 200);
        } else {
            $leadId=$request->input('leadId');
            if (LeadDetails::where('_id', new ObjectID($leadId))->exists()) {
                $leadDetails = LeadDetails::find($leadId);
                $customername=$leadDetails->customer['name'];
                $customerId=$leadDetails->customer['customerCode'];
                $recipientname=$leadDetails->customer['recipientName'];
                if (isset($leadDetails->agent['name'])) {
                    $agent=$leadDetails->agent['name']?:'NA';
                } else {
                    $agent='NA';
                }
                $emailid=$leadDetails->contactEmail;
                $tasktype=$leadDetails->dispatchType['dispatchType'];
                $deliverymode=$leadDetails->deliveryMode['deliveryMode'];
                $Mobilenumber=$leadDetails->contactNumber;
                $assignto=$leadDetails->employee['name'];
                $casemanager=$leadDetails->caseManager['name'];
                $createddate= Carbon::parse($leadDetails->created_at)->format('d/m/Y');
                if (isset($leadDetails->saveType)) {
                    if ($leadDetails->saveType=='recipient') {
                        $customercode = $leadDetails->customer['id'];
                        $customer = RecipientDetails::find($customercode);
                    } else {
                        $customercode = $leadDetails->customer['customerCode'];
                        $customer = Customer::where('customerCode', $customercode)->first();
                    }
                }
                if ($customer->addressLine2 != '') {
                    $address2 = ',' . $customer->addressLine2;
                } else {
                    $address2 = '';
                }
                $cityName = ',' . $customer->cityName;
                $address = $customer->addressLine1 . '' . $address2 . '' . $cityName;
                $landmark = $customer->streetName;
                $documentTypes = DocumentType::all();
                $document = $leadDetails['dispatchDetails']['documentDetails'];
                $doc_array=[];
                foreach ($document as $key => $doc) {
                    $documentId=$doc['documentId'];
                    $documentName=$doc['documentName'];
                    $documentDescription=$doc['documentDescription'];
                    $documentType=$doc['documentType'];
                    $DocumentCurrentStatus=$doc['DocumentCurrentStatus'];
                    $amount=$doc['amount'];
                    if (isset($doc['doc_collected_amount'])) {
                        $collectedamount=$doc['doc_collected_amount'];
                    } else {
                        $collectedamount="--";
                    }
                    $doc_array[]=array('documentId'=>(string)$documentId,'documentName'=>$documentName,'documentDescription'=>$documentDescription,'documentType'=>$documentType,'DocumentCurrentStatus'=>$DocumentCurrentStatus,'amount'=> $amount,'collectedamount'=>$collectedamount);
                }
//               $docdata = array(
//                   'docdata' =>  $doc_array,
//               );
                if (isset($leadDetails->comments)) {
                    $comment_array=[];
                    foreach ($leadDetails->comments as $comment) {
                        if (isset($comment['docId'])) {
                            $docId=$comment['docId'];
                        } else {
                            $docId="";
                        }
                        $commentBy=$comment['commentBy'];
                        $date=$comment['date'];
                        $time=$comment['commentTime'];
                        $remark=$comment['comment'];
                        $comment_array[]=array('commenteddocument'=>$docId,'commentBy'=>$commentBy,'date'=>$date,'time'=>$time,'comment'=>$remark);
                    }
//                   $commentdata = array(
//                       'commentdata' =>  $comment_array,
//                   );
                } else {
                    $comment_array=null;
                }

                return response()
                   ->json([
                       'status'=> "success",
                       'data' => array('customername'=>$customername,'customerId'=>$customerId,'recipientname'=>$recipientname,'agent'=>$agent,'emailid'=>$emailid,'tasktype'=>$tasktype
                       ,'deliverymode'=>$deliverymode,'number'=>$Mobilenumber,'assignto'=>$assignto,'casemanager'=>$casemanager,
                           'address'=>$address,'landmark'=>$landmark,'date'=>$createddate,'docdata' =>  $doc_array,'commentdata' =>  $comment_array)
                   ], 201);
            } else {
                return response()
                   ->json([
                       'status' => "error",
                       'data' => null,
                       'messages' => array('notFound' => array('Lead not found'))
                   ], 202);
            }
        }
    }
    /**
     * save document status
     */
    public static function saveDocumentStatus($leadId, $count, $status)
    {
        LeadDetails::where(
            '_id',
            new ObjectId($leadId)
        )->update(array('dispatchDetails.documentDetails.' . $count . '.DocumentCurrentStatus' => $status));
//         return 'success';
    }

    /**
     * save lead function
     */
    public function saveLead(Request $request)
    {
        $valid=Validator::make($request->all(), [
           'leadId' => 'required',
           'documentId'=>'required',
           'DocumentCurrentStatus'=>'required',
           'role'=>'required',

        ]);
        if ($valid->fails()) {
            return response()
               ->json([
                   'status' => "error",
                   'data' => null,
                   'messages' => $valid->errors()
               ], 200);
        } else {
            $leadId=$request->input('leadId');
            $leadDetails = LeadDetails::find($leadId);
            $leads=$leadDetails->dispatchDetails['documentDetails'];
            $documentId=$request->input('documentId');
            $role=$request->input('role');
            $DocumentCurrentStatus=$request->input('DocumentCurrentStatus');
            $deliverdate=$request->input('deliverdate');
            $remarks=$request->input('remarks');
            $doc_collected_amount=$request->input('collectedamount');
            date_default_timezone_set('Asia/Dubai');
            $comment_time = date('H:i:s');
            $dispatchDetails = LeadDetails::find($leadId);
            if (LeadDetails::where('_id', new ObjectID($leadId))->exists()) {
                foreach ($leads as $count => $lead) {
                    // $statusArray[] = $lead['DocumentCurrentStatus'];
                    if ($lead['id'] == $documentId) {
                        if ($DocumentCurrentStatus==2) {
                            LeadDetails::where(
                                '_id',
                                new ObjectId($leadId)
                            )->update(array('dispatchDetails.documentDetails.' . $count . '.status' => 1,
                                            'dispatchDetails.documentDetails.' . $count . '.dispatchStatus' => "Delivered",
                                            'dispatchDetails.documentDetails.' . $count . '.gostatus' => 1
                             ));
                            if ($lead['documentName']=="Cheque" || $lead['documentName']=="Cash" || $lead['documentName']=="Medical cards") {
                                if (isset($doc_collected_amount)) {
                                    $keyAmount=$doc_collected_amount;
                                } else {
                                    return response()
                                        ->json([
                                            'status' => "error",
                                            'data' => null,
                                            'messages' => array('Collected Amount' => array('The Collected Amount field is required'))
                                        ], 202);
                                }
                            } else {
                                $keyAmount='NA';
                            }
                            LeadDetails::where(
                                '_id',
                                new ObjectId($leadId)
                            )->update(array('dispatchDetails.documentDetails.' . $count . '.doc_collected_amount' => $keyAmount ));
                            $this->saveDocumentStatus($leadId, $count, '2');
                        } elseif ($DocumentCurrentStatus==3) {
                            LeadDetails::where(
                                '_id',
                                new ObjectId($leadId)
                            )->update(array('dispatchDetails.documentDetails.' . $count . '.status' => 2));
                            if (isset($remarks)) {
                                LeadDetails::where(
                                    '_id',
                                    new ObjectId($leadId)
                                )->update(array('dispatchDetails.documentDetails.' . $count . '.remarks' => $remarks));
                            } else {
                                return response()
                                    ->json([
                                        'status' => "error",
                                        'data' => null,
                                        'messages' => array('Remarks' => array('The Remarks field is required'))
                                    ], 202);
                            }

                            $keyAmount='NA';
                            LeadDetails::where(
                                '_id',
                                new ObjectId($leadId)
                            )->update(array('dispatchDetails.documentDetails.' . $count . '.dispatchStatus' => "reschedule_same",
                                            'dispatchDetails.documentDetails.' . $count . '.gostatus' => 2,
                                            'dispatchDetails.documentDetails.' . $count . '.doc_collected_amount' => $keyAmount
                                       ));
                            $this->saveDocumentStatus($leadId, $count, '3');
                            $comment_object = new \stdClass();
                            $comment_object->docId = $documentId;
                            $comment_object->comment = 'Document Name' . ' : ' . $lead['documentName'] . ' , ' . 'Action' . ' : ' . "Reschedule for same day" . ' , ' . 'Remarks' . ' : ' . ucfirst(ucwords($remarks));
                            $comment_object->commentBy = $role;
                            $comment_object->commentTime = $comment_time;
                            $comment_object->id = '';
                            $comment_object->date = date('d/m/Y');
                            $comment_array2[] = $comment_object;
                            $dispatchDetails->push('comments', $comment_array2);
                            $updatedBy_obj = new \stdClass();
                            $updatedBy_obj->name = $role;
                            $updatedBy_obj->date = date('d/m/Y');
                            $updatedBy_obj->action = "Commented";
                            $updatedBy[] = $updatedBy_obj;
                            $dispatchDetails->push('updatedBy', $updatedBy);
                            $dispatchDetails->save();
                        } elseif ($DocumentCurrentStatus==4) {
                            LeadDetails::where(
                                '_id',
                                new ObjectId($leadId)
                            )->update(array('dispatchDetails.documentDetails.' . $count . '.status' => 4));
                            if (isset($remarks)) {
                                LeadDetails::where(
                                    '_id',
                                    new ObjectId($leadId)
                                )->update(array('dispatchDetails.documentDetails.' . $count . '.remarks' => $remarks));
                            } else {
                                return response()
                                    ->json([
                                        'status' => "error",
                                        'data' => null,
                                        'messages' => array('Remarks' => array('The Remarks field is required'))
                                    ], 202);
                            }
                            $keyAmount='NA';
                            LeadDetails::where(
                                '_id',
                                new ObjectId($leadId)
                            )->update(array('dispatchDetails.documentDetails.' . $count . '.dispatchStatus' => "reschedule_another",
                                             'dispatchDetails.documentDetails.' . $count . '.gostatus' => 1,
                                             'dispatchDetails.documentDetails.' . $count . '.doc_collected_amount' => $keyAmount
                            ));              
                            $this->saveDocumentStatus($leadId, $count, '4');
                            $comment_object = new \stdClass();
                            $comment_object->docId = $documentId;
                            $comment_object->comment = 'Document Name' . ' : ' . $lead['documentName'] . ' , ' . 'Action' . ' : ' . "Reschedule for another day" . ' , ' . 'Remarks' . ' : ' . ucfirst(ucwords($remarks));
                            $comment_object->commentBy = $role;
                            $comment_object->commentTime = $comment_time;
                            $comment_object->id = '';
                            $comment_object->date = date('d/m/Y');
                            $comment_array2[] = $comment_object;
                            $dispatchDetails->push('comments', $comment_array2);
                            $updatedBy_obj = new \stdClass();
                            $updatedBy_obj->id = '';
                            $updatedBy_obj->name = $role;
                            $updatedBy_obj->date = date('d/m/Y');
                            $updatedBy_obj->action = "Commented";
                            $updatedBy[] = $updatedBy_obj;
                            $dispatchDetails->push('updatedBy', $updatedBy);
                            $dispatchDetails->save();
                        } elseif ($DocumentCurrentStatus==5) {
                            LeadDetails::where(
                                '_id',
                                new ObjectId($leadId)
                            )->update(array('dispatchDetails.documentDetails.' . $count . '.status' => 6));
                            if (isset($remarks)) {
                                LeadDetails::where(
                                    '_id',
                                    new ObjectId($leadId)
                                )->update(array('dispatchDetails.documentDetails.' . $count . '.remarks' => $remarks));
                            } else {
                                return response()
                                    ->json([
                                        'status' => "error",
                                        'data' => null,
                                        'messages' => array('Remarks' => array('The Remarks field is required'))
                                    ], 202);
                            }
                            $keyAmount='NA';
                            LeadDetails::where(
                                '_id',
                                new ObjectId($leadId)
                            )->update(array('dispatchDetails.documentDetails.' . $count . '.dispatchStatus' => "not_contact",
                                            'dispatchDetails.documentDetails.' . $count . '.gostatus' => 1,
                                            'dispatchDetails.documentDetails.' . $count . '.doc_collected_amount' =>$keyAmount));
                            $this->saveDocumentStatus($leadId, $count, '5');
                            $comment_object = new \stdClass();
                            $comment_object->docId = $documentId;
                            $comment_object->comment = 'Document Name' . ' : ' . $lead['documentName'] . ' , ' . 'Action' . ' : ' . "Could not contact" . ' , ' . 'Remarks' . ' : ' . ucfirst(ucwords($remarks));
                            $comment_object->commentBy = $role;
                            $comment_object->commentTime = $comment_time;
                            $comment_object->id = '';
                            $comment_object->date = date('d/m/Y');
                            $comment_array2[] = $comment_object;
                            $dispatchDetails->push('comments', $comment_array2);
                            $updatedBy_obj = new \stdClass();
                            $updatedBy_obj->id = '';
                            $updatedBy_obj->name = $role;
                            $updatedBy_obj->date = date('d/m/Y');
                            $updatedBy_obj->action = "Commented";
                            $updatedBy[] = $updatedBy_obj;
                            $dispatchDetails->push('updatedBy', $updatedBy);
                            $dispatchDetails->save();
                        } elseif ($DocumentCurrentStatus==8) {
                            $keyAmount='NA';
                            LeadDetails::where(
                                '_id',
                                new ObjectId($leadId)
                            )->update(array('dispatchDetails.documentDetails.' . $count . '.status' => 8,
                            'dispatchDetails.documentDetails.' . $count . '.dispatchStatus' => "Canceled",
                            'dispatchDetails.documentDetails.' . $count . '.gostatus' => 3,
                            'dispatchDetails.documentDetails.' . $count . '.doc_collected_amount' =>$keyAmount
                        ));
                        $this->saveDocumentStatus($leadId, $count, '8');
                        }
                    }
                    $leadDetails->save();
                }
                return response()
                 ->json([
                     'status' => "success",
                     'messages' => array('Action' => array('Action Submitted Successfully')),
                     'Documentstatus'=>$DocumentCurrentStatus
                 ], 201);
            } else {
                return response()
                 ->json([
                     'status' => "error",
                     'data' => null,
                     'messages' => array('notFound' => array('Lead not found'))
                 ], 202);
            }
        }
    }
    /**
     * save comments
     */
    public function AddComments(Request $request)
    {
        $valid=Validator::make($request->all(), [
           'leadId' => 'required',
           'role' => 'required',
           'time'=>'required',
           'comments'=>'required'
        ]);
        if ($valid->fails()) {
            return response()
               ->json([
                   'status' => "error",
                   'data' => null,
                   'messages' => $valid->errors()
               ], 200);
        } else {
            $leadId=$request->input('leadId');
            $role=$request->input('role');
            $time=$request->input('time');
            $comments=$request->input('comments');
            $UserName=$request->input('UserName');
            if ($UserName=='') {
                $UserName=$role;
            }
            date_default_timezone_set('Asia/Dubai');
            if (LeadDetails::where('_id', new ObjectID($leadId))->exists()) {
                $dispatchDetails = LeadDetails::find($leadId);
                if ($dispatchDetails->comments) {
                    $comment_object = new \stdClass();
                    $comment_object->comment = ucfirst(ucwords($comments));
                    $comment_object->commentBy = $UserName;
                    $comment_object->commentTime = $time;
                    $comment_object->userType = $role;
                    $comment_object->id = '';
                    $comment_object->date = date('d/m/Y ');
                    $comment_array[] = $comment_object;
                    $dispatchDetails->push('comments', $comment_array);
                    $updatedBy_obj = new \stdClass();
                    $updatedBy_obj->id = '';
                    $updatedBy_obj->name = $role;
                    $updatedBy_obj->date = date('d/m/Y');
                    $updatedBy_obj->action = "Commented";
                    $updatedBy[] = $updatedBy_obj;
                    $dispatchDetails->push('updatedBy', $updatedBy);
                    $dispatchDetails->save();
                } else {
                    $comment_object = new \stdClass();
                    $comment_object->comment = ucfirst(ucwords($comments));
                    $comment_object->commentBy = $UserName;
                    $comment_object->commentTime = $time;
                    $comment_object->userType = $role;
                    $comment_object->id = '';
                    $comment_object->date = date('d/m/Y');
                    $comment_array[] = $comment_object;
                    $dispatchDetails->comments = $comment_array;
                    $updatedBy_obj = new \stdClass();
                    $updatedBy_obj->id ='';
                    $updatedBy_obj->name = $role;
                    $updatedBy_obj->date = date('d/m/Y');
                    $updatedBy_obj->action = "Commented";
                    $updatedBy[] = $updatedBy_obj;
                    $dispatchDetails->push('updatedBy', $updatedBy);
                    $dispatchDetails->save();
                }
                return response()->json([
                  'success' => "success",
                  'time' => $time,
                  'commentBy' => $role,
                  'date' => date('d/m/Y'),
                  'messages' => array('Comments' => array('Comments Added Successfully'))
                ], 201);
            } else {
                return response()
                  ->json([
                      'status' => "error",
                      'data' => null,
                      'messages' => array('notFound' => array('Lead not found'))
                  ], 202);
            }
        }
    }

    public static function uploadToCloud($file)
    {
        $extension = $file->getClientOriginalExtension();
        $fileName = time() . uniqid() . '.' . $extension;
        $filePath = "/" . $fileName;
        $disk = Storage::disk('s3');
        $disk->put($filePath, fopen($file, 'r+'), 'public'); //uploading as streams, useful for large uploads.
        $file_url = 'https://s3-' . Config::get('filesystems.disks.s3.region') . '.amazonaws.com/' . Config::get('filesystems.disks.s3.bucket') . '/' . $fileName;
        return $file_url;
    }
    /**
     * upload sign
     */
    public function UploadSign(Request $request)
    {
        $valid=Validator::make($request->all(), [
           'leadId' => 'required',
           'signature'=>'required ',
           'role' => 'required'
        ]);
        if ($valid->fails()) {
            return response()
               ->json([
                   'status' => "error",
                   'data' => null,
                   'messages' => $valid->errors()
               ], 200);
        } else {
            $leadId=$request->input('leadId');
            $upload_sign = $request->file('signature');
            $role=$request->input('role');
            if (LeadDetails::where('_id', new ObjectID($leadId))->exists()) {
                $LeadDetails = LeadDetails::find($leadId);
                if ($upload_sign) {
                    $upload = $this->uploadToCloud($upload_sign);
                } else {
                    $upload = '';
                }
                if ($LeadDetails->deliveryStatus) {
                    $deliveryStatusObject = new \stdClass();
                    $deliveryStatusObject->id = '';
                    $deliveryStatusObject->name = $role;
                    $deliveryStatusObject->date = date('d/m/Y');
                    $deliveryStatusObject->upload_sign = $upload;
                    $sign_array[] = $deliveryStatusObject;
                    $LeadDetails->push('deliveryStatus', $sign_array);
                    $LeadDetails->save();
                } else {
                    $deliveryStatusObject = new \stdClass();
                    $deliveryStatusObject->id = '';
                    $deliveryStatusObject->name = $role;
                    $deliveryStatusObject->date = date('d/m/Y');
                    $deliveryStatusObject->upload_sign = $upload;
                    $sign_array[] = $deliveryStatusObject;
                    $LeadDetails->deliveryStatus = $sign_array;
                    $LeadDetails->save();
                }
                return response()->json([
                   'success' => "success",
                   'messages' => array('Signature' => array('Signature Added Successfully'))
                ], 201);
            } else {
                return response()
                   ->json([
                       'status' => "error",
                       'data' => null,
                       'messages' => array('notFound' => array('Lead not found'))
                   ], 202);
            }
        }
    }
    /**
     * upload file
     */
    public function UploadFile(Request $request)
    {
        $valid=Validator::make($request->all(), [
           'uploadFile'=>'required '
           
        ]);
        if ($valid->fails()) {
            return response()
               ->json([
                   'status' => "error",
                   'data' => null,
                   'messages' => $valid->errors()
               ], 200);
        } else {
            $uploadFile = $request->file('uploadFile');
            if ($uploadFile) {
                if ($uploadFile) {
                    $upload = $this->uploadToCloud($uploadFile);
                } else {
                    $upload = '';
                }
                return response()->json([
                   'success' => "success",
                   'messages' => $upload
                ], 201);
            } else {
                return response()
                   ->json([
                       'status' => "error",
                       'data' => null,
                       'messages' => array('notFound' => array('File not found'))
                   ], 202);
            }
        }
    }
    /**
     * save file
     */
    public function SaveFile(Request $request)
    {
        $valid=Validator::make($request->all(), [
           'data.leadId' => 'required',
           'data.uploadFile'=>'required ',
           'data.docIdArray' => 'required'
        ]);
        if ($valid->fails()) {
            return response()
               ->json([
                   'status' => "error",
                   'data' => null,
                   'messages' => $valid->errors()
               ], 200);
        } else {
            $leadId=$request->input('data.leadId');
            $docIdArray=$request->input('data.docIdArray');
            $uploadFile = $request->input('data.uploadFile');
            $docArray=[];
            foreach ($docIdArray as $doc) {
                if ($doc['documentId']!='NA') {
                    $docArray[]=$doc['documentId'];
                }
            }
            if (LeadDetails::where('_id', new ObjectID($leadId))->exists()) {
                $LeadDetails = LeadDetails::find($leadId);
                $leads = $LeadDetails['dispatchDetails']['documentDetails'];
                foreach ($leads as $count => $reply) {
                    if (in_array($reply['id'], $docArray)) {
                        LeadDetails::where(
                            '_id',
                            new ObjectId($leadId)
                        )->update(array('dispatchDetails.documentDetails.' . $count . '.fileUpload' => $uploadFile));
                    }
                }
                $LeadDetails->save();
                return response()->json([
                   'success' => "success",
                   'messages' => array('uploadFile' => array('File uploaded Successfully'))
                ], 201);
            } else {
                return response()
                   ->json([
                       'status' => "error",
                       'data' => null,
                       'messages' => array('notFound' => array('Lead not found'))
                   ], 202);
            }
        }
    }
    
    //  public function UploadFile(Request $request){
    //      $valid=Validator::make($request->all(),[
    //          'leadId' => 'required',
    //          'uploadFile'=>'required ',
    //          'docIdArray' => 'required'
    //      ]);
    //      if($valid->fails()) {
    //          return response()
    //              ->json([
    //                  'status' => "error",
    //                  'data' => null,
    //                  'messages' => $valid->errors()
    //              ], 200);
    //      }else{
    //          $leadId=$request->input('leadId');
    //          $jsondocIdArray=$request->input('docIdArray');
    //          $docIdArray=json_decode($jsondocIdArray, true);
//
    //          $uploadFile = $request->file('uploadFile');
    //          if(LeadDetails::where('_id',new ObjectID($leadId))->exists()) {
    //              $LeadDetails = LeadDetails::find($leadId);
    //              $leads = $LeadDetails['dispatchDetails']['documentDetails'];
    //              if ($uploadFile) {
    //                  $upload = $this->uploadToCloud($uploadFile);
    //              } else {
    //                  $upload = '';
    //              }
    //              foreach ($leads as $count => $reply) {
    //                  if (in_array($reply['documentId'], $docIdArray)) {
    //                      LeadDetails::where('_id',
    //                          new ObjectId($leadId))->update(array('dispatchDetails.documentDetails.' . $count . '.fileUpload' => $upload));
    //                  }
    //              }
    //              $LeadDetails->save();
    //              return response()->json([
    //                  'success' => "success",
    //                  'messages' => array('uploadFile' => array('File uploaded Successfully'))
    //              ], 201);
    //          } else{
    //              return response()
    //                  ->json([
    //                      'status' => "error",
    //                      'data' => null,
    //                      'messages' => array('notFound' => array('Lead not found'))
    //                  ], 202);
    //          }
//
    //      }
    //  }
//


    public function Save(Request $request)
    {
        $role = $request->input('data.role');
        $agentMailID='';
        $UserName = $request->input('data.UserName');
        if ($UserName=='') {
            $UserName=$role;
        }
        $document = $request->input('data.docdata');
        $longitude = $request->input('data.long');
        $latitude = $request->input('data.lat');
        $user_id = $request->input('data.UserId');
        $comment=$request->input('data.commentdata');
        $approveComment = $request->input('data.approvecomment');
        date_default_timezone_set('Asia/Dubai');
        $comment_time = date('H:i:s');
        if ($request->input('data.leadId') == "") {
            return response()
               ->json([
                   'status' => "error",
                   'data' => null,
                   'messages' => array('leadId' => array('The lead id field is required.'))
               ], 202);
        }
        if ($request->input('data.approvecomment') == "") {
            return response()
               ->json([
                   'status' => "error",
                   'data' => null,
                   'messages' => array('approvecomment' => array('The approvecomment field is required.'))
               ], 202);
        } else {
            $lead_id=$request->input('data.leadId');
            if (LeadDetails::where('_id', new ObjectID($lead_id))->exists()) {
                $leadDetails = LeadDetails::find($lead_id);
                //   $dispatchDetails = LeadDetails::find($lead_id);
                $leads = $leadDetails['dispatchDetails']['documentDetails'];
                $document_id = [];
                $document_map_id = [];
                $document_name = [];
                $document_map_name = [];
                $leadSubmitStatus=0;
                $leadRejectStatus=0;
                foreach ($document as $value) {
                    foreach ($leads as $count => $reply) {
                        if ($value['documentId']!="") {
                            if ($value['DocumentCurrentStatus']!="") {
                                if ($value['documentId']==$reply['id']) {
                                    $document_id[] = $value['documentId'];
                                    $document_name[] = $value['documentName'];
                                    if ($value['DocumentCurrentStatus']==2) {
                                        $document_map_id[] = $value['documentId'];
                                        $document_map_name[] = $value['documentName'];
                                        if ($value['collectedamount']!="--" ||$value['collectedamount']!=""  ||$value['collectedamount']!=null) {
                                            $keyAmount=$value['collectedamount'];
                                        } else {
                                            $keyAmount='NA';
                                        }
                                        LeadDetails::where(
                                            '_id',
                                            new ObjectId($lead_id)
                                        )->update(array('dispatchDetails.documentDetails.' . $count . '.status' => 1,
                                        'dispatchDetails.documentDetails.' . $count . '.dispatchStatus' => "Delivered",
                                        'dispatchDetails.documentDetails.' . $count . '.gostatus' => 1,
                                        'dispatchDetails.documentDetails.' . $count . '.doc_collected_amount' => $keyAmount
                                    ));
                                        $this->saveDocumentStatus($lead_id, $count, '2');
                                        $leadSubmitStatus=1;
                                    } elseif ($value['DocumentCurrentStatus']==3) {
                                        if ($value['collectedamount']!="--" ||$value['collectedamount']!="" ||$value['collectedamount']!=null) {
                                            $keyAmount=$value['collectedamount'];
                                        } else {
                                            $keyAmount='NA';
                                        }
                                        LeadDetails::where(
                                            '_id',
                                            new ObjectId($lead_id)
                                        )->update(array('dispatchDetails.documentDetails.' . $count . '.status' => 2,
                                        'dispatchDetails.documentDetails.' . $count . '.remarks' =>$value['Remarks'],
                                        'dispatchDetails.documentDetails.' . $count . '.dispatchStatus' => "reschedule_same",
                                        'dispatchDetails.documentDetails.' . $count . '.gostatus' => 2,
                                        'dispatchDetails.documentDetails.' . $count . '.doc_collected_amount' => $keyAmount
                                    ));
                                        $this->saveDocumentStatus($lead_id, $count, '3');
                                        $comment_array2=[];
                                        $updatedBy=[];
                                        $comment_object = new \stdClass();
                                        $comment_object->docId = $value['documentId'];
                                        $comment_object->comment = 'Document Name' . ' : ' . $value['documentName'] . ' , ' . 'Action' . ' : ' . "Reschedule for same day" . ' , ' . 'Remarks' . ' : ' . ucfirst(ucwords($value['Remarks']));
                                        $comment_object->commentBy = $UserName;
                                        $comment_object->commentTime = $comment_time;
                                        $comment_object->date = date('d/m/Y');
                                        $comment_array2[] = $comment_object;
                                        $leadDetails->push('comments', $comment_array2);
                                        $updatedBy_obj = new \stdClass();
                                        $updatedBy_obj->name = $UserName;
                                        $updatedBy_obj->date = date('d/m/Y');
                                        $updatedBy_obj->action = "Commented";
                                        $updatedBy[] = $updatedBy_obj;
                                        $leadDetails->push('updatedBy', $updatedBy);
                                        $leadDetails->save();
                                        $leadRejectStatus=1;
                                    } elseif ($value['DocumentCurrentStatus']==4) {
                                        if ($value['collectedamount']!="--" ||$value['collectedamount']!=""||$value['collectedamount']!=null) {
                                            $keyAmount=$value['collectedamount'];
                                        } else {
                                            $keyAmount='NA';
                                        }
                                        LeadDetails::where(
                                            '_id',
                                            new ObjectId($lead_id)
                                        )->update(array('dispatchDetails.documentDetails.' . $count . '.status' => 4,
                                        'dispatchDetails.documentDetails.' . $count . '.remarks' =>$value['Remarks'],
                                        'dispatchDetails.documentDetails.' . $count . '.dispatchStatus' => "reschedule_another",
                                        'dispatchDetails.documentDetails.' . $count . '.gostatus' => 1,
                                        'dispatchDetails.documentDetails.' . $count . '.doc_collected_amount' => $keyAmount
                                    ));
                                        $this->saveDocumentStatus($lead_id, $count, '4');
                                        $comment_array2=[];
                                        $updatedBy=[];
                                        $comment_object = new \stdClass();
                                        $comment_object->docId = $value['documentId'];
                                        $comment_object->comment = 'Document Name' . ' : ' . $value['documentName'] . ' , ' . 'Action' . ' : ' . "Reschedule for another day" . ' , ' . 'Remarks' . ' : ' . ucfirst(ucwords($value['Remarks']));
                                        $comment_object->commentBy = $UserName;
                                        $comment_object->commentTime = $comment_time;
                                        $comment_object->date = date('d/m/Y');
                                        $comment_array2[] = $comment_object;
                                        $leadDetails->push('comments', $comment_array2);
                                        $updatedBy_obj = new \stdClass();
                                        $updatedBy_obj->name = $UserName;
                                        $updatedBy_obj->date = date('d/m/Y');
                                        $updatedBy_obj->action = "Commented";
                                        $updatedBy[] = $updatedBy_obj;
                                        $leadDetails->push('updatedBy', $updatedBy);
                                        $leadDetails->save();
                                        $leadRejectStatus=1;
                                    } elseif ($value['DocumentCurrentStatus']==5) {
                                        if ($value['collectedamount']!="--" ||$value['collectedamount']!=""||$value['collectedamount']!=null) {
                                            $keyAmount=$value['collectedamount'];
                                        } else {
                                            $keyAmount='NA';
                                        }
                                        LeadDetails::where(
                                            '_id',
                                            new ObjectId($lead_id)
                                        )->update(array('dispatchDetails.documentDetails.' . $count . '.status' => 6,
                                        'dispatchDetails.documentDetails.' . $count . '.remarks' => $value['Remarks'],
                                        'dispatchDetails.documentDetails.' . $count . '.dispatchStatus' => "not_contact",
                                        'dispatchDetails.documentDetails.' . $count . '.gostatus' => 1,
                                        'dispatchDetails.documentDetails.' . $count . '.doc_collected_amount' => $keyAmount
                                    ));
                                        $this->saveDocumentStatus($lead_id, $count, '5');
                                        $comment_array2=[];
                                        $updatedBy=[];
                                        $comment_object = new \stdClass();
                                        $comment_object->docId = $value['documentId'];
                                        $comment_object->comment = 'Document Name' . ' : ' . $value['documentName'] . ' , ' . 'Action' . ' : ' . "Reschedule for another day" . ' , ' . 'Remarks' . ' : ' . ucfirst(ucwords($value['Remarks']));
                                        $comment_object->commentBy = $UserName;
                                        $comment_object->commentTime = $comment_time;
                                        $comment_object->date = date('d/m/Y');
                                        $comment_array2[] = $comment_object;
                                        $leadDetails->push('comments', $comment_array2);
                                        $updatedBy_obj = new \stdClass();
                                        $updatedBy_obj->name = $UserName;
                                        $updatedBy_obj->date = date('d/m/Y');
                                        $updatedBy_obj->action = "Commented";
                                        $updatedBy[] = $updatedBy_obj;
                                        $leadDetails->push('updatedBy', $updatedBy);
                                        $leadDetails->save();
                                        $leadRejectStatus=1;
                                    } elseif ($value['DocumentCurrentStatus']==8) {
                                        if ($value['collectedamount']!="--" ||$value['collectedamount']!="" ||$value['collectedamount']!=null) {
                                            $keyAmount=$value['collectedamount'];
                                        } else {
                                            $keyAmount='NA';
                                        }
                                        LeadDetails::where(
                                            '_id',
                                            new ObjectId($lead_id)
                                        )->update(array('dispatchDetails.documentDetails.' . $count . '.status' => 8,
                                        'dispatchDetails.documentDetails.' . $count . '.dispatchStatus' => "Canceled",
                                        'dispatchDetails.documentDetails.' . $count . '.gostatus' => 3,
                                        'dispatchDetails.documentDetails.' . $count . '.doc_collected_amount' => $keyAmount
                                    ));
                                        $this->saveDocumentStatus($lead_id, $count, '8');
                                        $leadRejectStatus=1;
                                    }
                                }
                            } else {
                                return response()
                                  ->json([
                                      'status' => "error",
                                      'data' => null,
                                      'messages' => array('DocumentCurrentStatus' => array('The DocumentCurrentStatus  field is required.'))
                                  ], 202);
                            }
                        } else {
                            return response()
                              ->json([
                                  'status' => "error",
                                  'data' => null,
                                  'messages' => array('documentId' => array('The document Id field is required.'))
                              ], 202);
                        }
                    }
                    $leadDetails->save();
                }
                if ($comment !="") {
                    foreach ($comment as $comments) {
                        $comment_array=[];
                        $updatedBy=[];
                        if ($leadDetails->comments) {
                            $comment_object = new \stdClass();
                            $comment_object->comment = ucfirst(ucwords($comments['comment']));
                            $comment_object->commentBy = $UserName;
                            $comment_object->commentTime = $comments['commentTime'];
                            $comment_object->userType = $role;
                            $comment_object->date = $comments['date'];
                            $comment_array[] = $comment_object;
                            $leadDetails->push('comments', $comment_array);
                            $updatedBy_obj = new \stdClass();
                            $updatedBy_obj->name = $UserName;
                            $updatedBy_obj->date = $comments['date'];
                            $updatedBy_obj->action = "Commented";
                            $updatedBy[] = $updatedBy_obj;
                            $leadDetails->push('updatedBy', $updatedBy);
                            $leadDetails->save();
                        } else {
                            $comment_object = new \stdClass();
                            $comment_object->comment = ucfirst($comments['comment']);
                            $comment_object->commentBy = $UserName;
                            $comment_object->commentTime = $comments['commentTime'];
                            $comment_object->userType = $role;
                            $comment_object->date = $comments['date'];
                            $comment_array[] = $comment_object;
                            $leadDetails->comments = $comment_array;
                            $updatedBy_obj = new \stdClass();
                            $updatedBy_obj->name = $UserName;
                            $updatedBy_obj->date = $comments['date'];
                            $updatedBy_obj->action = "Commented";
                            $updatedBy[] = $updatedBy_obj;
                            $leadDetails->push('updatedBy', $updatedBy);
                            $leadDetails->save();
                        }
                    }
                }
                $leadDetails = LeadDetails::find($lead_id);
                if (!empty($document_map_name) && !empty($document_map_id) && ($latitude!='' && $longitude!='')) {
                    $mapDetails=[];
                    date_default_timezone_set('Asia/Dubai');
                    $submit_time = date('H:i:s');
                    $user=User::find($user_id);
                    $map_object = new \stdClass();
                    $map_object->location =  ['docName'=>$document_map_name,'docId'=>$document_map_id,'type' => 'Point', 'coordinates' => [$latitude,$longitude,'Reference Number:'.$leadDetails->referenceNumber]];
                    $map_object->updateBy = $UserName;
                    $map_object->deliveryDate =date('d/m/Y');
                    $map_object->deliveryTime =$submit_time;
                    $mapDetails[] = $map_object;
                    //            dd($mapDetails);
                    if (isset($user->MapDetails)) {
                        $user->where('_id', new ObjectId($user_id))->push('MapDetails', $mapDetails);
                    } else {
                        $user->MapDetails = $mapDetails;
                    }
                    $user->save();
                    if (isset($leadDetails->MapDetails)) {
                        $leadDetails->where('_id', new ObjectId($lead_id))->push('MapDetails', $mapDetails);
                    } else {
                        $leadDetails->MapDetails = $mapDetails;
                    }
                }
             
             
             
                $referencenumber=$leadDetails->referenceNumber;
                $casemanagerid=$leadDetails->caseManager['id'];
                $casemanager = User::find($casemanagerid);
                $caseemail=$casemanager->email;
                $casename=$casemanager->name;
                $custname = $leadDetails->customer['name'];
                $custemail = $leadDetails->contactEmail;
                $recp = User::where('isActive', 1)->where('role', "RP")->get();
                $caselink=url('/dispatch/receptionist-list/');
                $action=" Reception";
                $leadss= $leadDetails['dispatchDetails']['documentDetails'];
                if (isset($leadDetails->agent['id'])) {
                    $agent=$leadDetails->agent['id'];
                    $agentValue=User::find($agent);
                    $agentMailID=$agentValue->email;
                } else {
                    $agentMailID=='';
                }
                if ($leadRejectStatus==1) {
                    $saveMethod='reject_button';
                    foreach ($recp as $user) {
                        $recpname=$user['name'];
                        $recmail=$user['email'];
                        if ($caseemail != '') {
                            SendReceptionDelivery::dispatch($recpname, $recmail, $referencenumber, $role, $caselink, $saveMethod, $leadss, $custname, $document_id);
                        }
                    }
                    if ($agentMailID != '') {
                        Mail::to($agentMailID)->send(new sendMailToAgent($agentMailID, $referencenumber, $role, $saveMethod, $action, $leadss, $custname, $document_id));
                    }
                    if ($caseemail != '') {
                        SendCaseManagerDelivery::dispatch($casename, $caseemail, $referencenumber, $role, $caselink, $saveMethod, $action, $leadss, $custname, $document_id);
                    }
                    //                if($custemail != '') {
//                    SendCustomerDelivery::dispatch($custname, $custemail, $referencenumber, $role, $caselink, $saveMethod, $action, $leadss, $document_id);
//                }
                }
                if ($leadSubmitStatus==1) {
                    $saveMethod='submitt_button';
                    if ($agentMailID != '') {
                        Mail::to($agentMailID)->send(new sendMailToAgent($agentMailID, $referencenumber, $role, $saveMethod, $action, $leadss, $custname, $document_id));
                    }
                    if ($caseemail != '') {
                        SendCaseManagerDelivery::dispatch($casename, $caseemail, $referencenumber, $role, $caselink, $saveMethod, $action, $leadss, $custname, $document_id);
                    }
                    //                if($custemail != '') {
//                    SendCustomerDelivery::dispatch($custname, $custemail, $referencenumber, $role, $caselink, $saveMethod, $action, $leadss, $document_id);
//                }
                }
           
//
//              $saveMethod = 'submitt_button';
//              if($caseemail != '') {
//
//                  SendCaseManagerDelivery::dispatch($casename, $caseemail, $referencenumber, $role, $caselink, $saveMethod, $action, $leadss, $custname, $document_id);
//              }
//              foreach($recp as $user){
//                  $casename=$user['name'];
//                  $caseemail=$user['email'];
//                  if($caseemail != '') {
//                      SendReceptionDelivery::dispatch($casename, $caseemail, $referencenumber, $role, $caselink, $saveMethod, $leadss, $custname, $document_id);
//                  }
//              }
//              if($custemail != '') {
//                  SendCustomerDelivery::dispatch($custname, $custemail, $referencenumber, $role, $caselink, $saveMethod, $action, $leadss, $document_id);
//              }

                DispatchController::saveTabStatus($lead_id);
                DispatchController::setDispatchStatus($lead_id);
                $approve_comment_array=[];
                $approve_comment_object = new \stdClass();
                $approve_comment_object->comment = 'Submitted from delivery' . ','.'Message' . ' : ' . ucfirst(ucwords($approveComment));
                $approve_comment_object->commentBy = $UserName;
                $approve_comment_object->commentTime = $comment_time;
                $approve_comment_object->date = date('d/m/Y');
                $approve_comment_array[] = $approve_comment_object;
                $leadDetails->push('comments', $approve_comment_array);
                $sign_array=[];
                if ($leadDetails->deliveryStatus) {
                    $deliveryStatusObject = new \stdClass();
                    $deliveryStatusObject->id = '';
                    $deliveryStatusObject->name = $UserName;
                    $deliveryStatusObject->date = date('d/m/Y');
                    $deliveryStatusObject->uploadFrom = 'delivery app';
                    $sign_array[] = $deliveryStatusObject;
                    $leadDetails->push('deliveryStatus', $sign_array);
                } else {
                    $deliveryStatusObject = new \stdClass();
                    $deliveryStatusObject->id = '';
                    $deliveryStatusObject->name = $UserName;
                    $deliveryStatusObject->date = date('d/m/Y');
                    $deliveryStatusObject->uploadFrom = 'delivery app';
                    $sign_array[] = $deliveryStatusObject;
                    $leadDetails->deliveryStatus = $sign_array;
                }
              
              
              
                $leadDetails->save();
                return response()
                  ->json([
                      'status' => "success",
                      'messages' => array('Action' => array('Action Submitted Successfully')),
                  ], 201);
            } else {
                return response()
                  ->json([
                      'status' => "error",
                      'data' => null,
                      'messages' => array('notFound' => array('Lead not found'))
                  ], 202);
            }
        }
    }
    /**
     * approve lead from schedule for delivery tab
     */
    public function ApproveLead(Request $request)
    {
        $role = $request->input('data.role');
        $document = $request->input('data.docdata');
        $approveComment=$request->input('data.approvecomment');
        $user_id = $request->input('data.UserId');
        $comment=$request->input('data.commentdata');
        date_default_timezone_set('Asia/Dubai');
        $comment_time = date('H:i:s');
        if ($request->input('data.leadId') == "") {
            return response()
                ->json([
                    'status' => "error",
                    'data' => null,
                    'messages' => array('leadId' => array('The lead id field is required.'))
                ], 202);
        }
        if ($request->input('data.approvecomment') == "") {
            return response()
                ->json([
                    'status' => "error",
                    'data' => null,
                    'messages' => array('approvecomment' => array('The approvecomment field is required.'))
                ], 202);
        } else {
            $lead_id=$request->input('data.leadId');
            if (LeadDetails::where('_id', new ObjectID($lead_id))->exists()) {
                $user=User::find($user_id);
                $leadDetails = LeadDetails::find($lead_id);
                //   $dispatchDetails = LeadDetails::find($lead_id);
                $leads = $leadDetails['dispatchDetails']['documentDetails'];
                $document_id = [];
                
                foreach ($document as $value) {
                    foreach ($leads as $count => $reply) {
                        if ($value['documentId'] != "") {
                            if ($value['documentId'] == $reply['id']) {
                                $document_id[] = $value['documentId'];
                                $this->saveDocumentStatus($lead_id, $count, '11');
                            }
                        } else {
                            return response()
                                ->json([
                                    'status' => "error",
                                    'data' => null,
                                    'messages' => array('documentId' => array('The document Id field is required.'))
                                ], 202);
                        }
                    }
                    $leadDetails->save();
                }
                if ($comment !="") {
                    foreach ($comment as $comments) {
                        $comment_array=[];
                        $updatedBy=[];
                        if ($leadDetails->comments) {
                            $comment_object = new \stdClass();
                            $comment_object->comment = ucfirst(ucwords($comments['comment']));
                            $comment_object->commentBy = $user->name;
                            $comment_object->commentTime = $comments['commentTime'];
                            $comment_object->userType = $role;
                            $comment_object->date = $comments['date'];
                            $comment_array[] = $comment_object;
                            $leadDetails->push('comments', $comment_array);
                            $updatedBy_obj = new \stdClass();
                            $updatedBy_obj->name =  $user->name;
                            ;
                            $updatedBy_obj->date = $comments['date'];
                            $updatedBy_obj->action = "Commented";
                            $updatedBy[] = $updatedBy_obj;
                            $leadDetails->push('updatedBy', $updatedBy);
                            $leadDetails->save();
                        } else {
                            $comment_object = new \stdClass();
                            $comment_object->comment = ucfirst($comments['comment']);
                            $comment_object->commentBy = $user->name;
                            $comment_object->commentTime = $comments['commentTime'];
                            $comment_object->userType = $role;
                            $comment_object->date = $comments['date'];
                            $comment_array[] = $comment_object;
                            $leadDetails->comments = $comment_array;
                            $updatedBy_obj = new \stdClass();
                            $updatedBy_obj->name =  $user->name;
                            ;
                            $updatedBy_obj->date = $comments['date'];
                            $updatedBy_obj->action = "Commented";
                            $updatedBy[] = $updatedBy_obj;
                            $leadDetails->push('updatedBy', $updatedBy);
                            $leadDetails->save();
                        }
                    }
                }
                $ScheduleStatus=[];
                $approve_comment_array=[];
                $leadDetails = LeadDetails::find($lead_id);
                $scheduleStatusObject = new \stdClass();
                $scheduleStatusObject->name = $user->name;
                ;
                $scheduleStatusObject->date =$comment_time;
                $scheduleStatusObject->status = "Approved from app";
                $ScheduleStatus[] = $scheduleStatusObject;
                if ($leadDetails->scheduleStatus) {
                    LeadDetails::where('_id', new ObjectId($lead_id))->push(
                        'scheduleStatus',
                        $ScheduleStatus
                    );
                } else {
                    $leadDetails->scheduleStatus = $ScheduleStatus;
                }
                
                $approve_comment_object = new \stdClass();
                $approve_comment_object->comment = 'Approved from schedule for delivery/collection' . ','.'Message' . ' : ' . ucfirst(ucwords($approveComment));
                $approve_comment_object->commentBy = $user->name;
                $approve_comment_object->commentTime = $comment_time;
                $approve_comment_object->date = date('d/m/Y');
                $approve_comment_array[] = $approve_comment_object;
                $leadDetails->push('comments', $approve_comment_array);
                
                $referencenumber=$leadDetails->referenceNumber;
                $custname = $leadDetails->customer['name'];
                $custemail = $leadDetails->contactEmail;
                $caselink=url('/dispatch/delivery/');
                $saveMethod='reject_button';
                $action="Delivery/Collection";
                $prefered_date=$leadDetails->dispatchDetails['date_time'];
                $leadss="";
                //              if($custemail != ''){
                //                          SendCustomer::dispatch($custname,$custemail,$referencenumber,$role,$caselink,$saveMethod,$action,$leadss, $prefered_date);
                //                      }
                DispatchController::saveTabStatus($lead_id);
                DispatchController::setDispatchStatus($lead_id);
                $leadDetails->save();
                return response()
                    ->json([
                        'status' => "success",
                        'messages' => array('Action' => array('Action Submitted Successfully')),
                    ], 201);
            } else {
                return response()
                    ->json([
                        'status' => "error",
                        'data' => null,
                        'messages' => array('notFound' => array('Lead not found'))
                    ], 202);
            }
        }
    }
    /**
     * reject lead from schedule for delivery tab
     */
    public function RejectLead(Request $request)
    {
        $role = $request->input('data.role');
        $rejectComment = $request->input('data.rejectComment');
        $document = $request->input('data.docdata');
        $user_id = $request->input('data.UserId');
        $comment=$request->input('data.commentdata');
        date_default_timezone_set('Asia/Dubai');
        $comment_time = date('H:i:s');
        if ($request->input('data.leadId') == "") {
            return response()
                ->json([
                    'status' => "error",
                    'data' => null,
                    'messages' => array('leadId' => array('The lead id field is required.'))
                ], 202);
        }
        if ($request->input('data.rejectComment')=="") {
            return response()
                ->json([
                    'status' => "error",
                    'data' => null,
                    'messages' => array('rejectComment' => array('The reject comment field is required.'))
                ], 202);
        } else {
            $lead_id=$request->input('data.leadId');
            if (LeadDetails::where('_id', new ObjectID($lead_id))->exists()) {
                $leadDetails = LeadDetails::find($lead_id);
                $user=User::find($user_id);
                //   $dispatchDetails = LeadDetails::find($lead_id);
                $leads = $leadDetails['dispatchDetails']['documentDetails'];
                $document_id = [];
                
                foreach ($document as $value) {
                    foreach ($leads as $count => $reply) {
                        if ($value['documentId'] != "") {
                            if ($value['documentId'] == $reply['id']) {
                                $document_id[] = $value['documentId'];
                                $this->saveDocumentStatus($lead_id, $count, '12');
                            }
                        } else {
                            return response()
                                ->json([
                                    'status' => "error",
                                    'data' => null,
                                    'messages' => array('documentId' => array('The document Id field is required.'))
                                ], 202);
                        }
                    }
                    $leadDetails->save();
                }
                if ($comment !="") {
                    foreach ($comment as $comments) {
                        $comment_array=[];
                        $updatedBy=[];
                        $ScheduleStatus=[];
                        $reject_comment_array=[];
                        if ($leadDetails->comments) {
                            $comment_object = new \stdClass();
                            $comment_object->comment = ucfirst(ucwords($comments['comment']));
                            $comment_object->commentBy = $user->name;
                            $comment_object->commentTime = $comments['commentTime'];
                            $comment_object->userType = $role;
                            $comment_object->date = $comments['date'];
                            $comment_array[] = $comment_object;
                            $leadDetails->push('comments', $comment_array);
                            $updatedBy_obj = new \stdClass();
                            $updatedBy_obj->name = $user->name;
                            ;
                            $updatedBy_obj->date = $comments['date'];
                            $updatedBy_obj->action = "Commented";
                            $updatedBy[] = $updatedBy_obj;
                            $leadDetails->push('updatedBy', $updatedBy);
                            $leadDetails->save();
                        } else {
                            $comment_object = new \stdClass();
                            $comment_object->comment = ucfirst($comments['comment']);
                            $comment_object->commentBy =$user->name;
                            $comment_object->commentTime = $comments['commentTime'];
                            $comment_object->userType = $role;
                            $comment_object->date = $comments['date'];
                            $comment_array[] = $comment_object;
                            $leadDetails->comments = $comment_array;
                            $updatedBy_obj = new \stdClass();
                            $updatedBy_obj->name = $user->name;
                            ;
                            $updatedBy_obj->date = $comments['date'];
                            $updatedBy_obj->action = "Commented";
                            $updatedBy[] = $updatedBy_obj;
                            $leadDetails->push('updatedBy', $updatedBy);
                            $leadDetails->save();
                        }
                    }
                }
                $leadDetails = LeadDetails::find($lead_id);
                $scheduleStatusObject = new \stdClass();
                $scheduleStatusObject->name =$user->name;
                ;
                $scheduleStatusObject->date =date('d/m/Y');
                $scheduleStatusObject->status = "Rejected from app";
                $scheduleStatusObject->comment = $rejectComment;
                $ScheduleStatus[] = $scheduleStatusObject;
                if ($leadDetails->scheduleStatus) {
                    LeadDetails::where('_id', new ObjectId($lead_id))->push(
                        'scheduleStatus',
                        $ScheduleStatus
                    );
                } else {
                    $leadDetails->scheduleStatus = $ScheduleStatus;
                }
                $reject_comment_object = new \stdClass();
                $reject_comment_object->comment = 'Reject from schedule for delivery/collection' . ','.'Message' . ' : ' . ucfirst(ucwords($rejectComment));
                $reject_comment_object->commentBy = $user->name;
                ;
                $reject_comment_object->commentTime = $comment_time;
                $reject_comment_object->date = date('d/m/Y');
                $reject_comment_array[] = $reject_comment_object;
                $leadDetails->push('comments', $reject_comment_array);
                
                $leadDetails->schedulerejectstatus=$rejectComment;
                $custname = $leadDetails->customer['name'];
                $casemanagerid=$leadDetails->caseManager['id'];
                $casemanager=User::find($casemanagerid);
                $caseemail=$casemanager->email;
                $casename=$casemanager->name;
                $referencenumber=$leadDetails->referenceNumber;
                $saveMethod='reject_button';
                $caselink=url('/dispatch/receptionist-list/');
                $action="Schedule for delivery/Collection";
                $leadss="";
                if ($caseemail != '') {
                    SendcasemanagerADleads::dispatch($casename, $caseemail, $referencenumber, $role, $caselink, $saveMethod, $action, $leadss, $custname);
                }
                $recp=User::where('isActive', 1)->where('role', "RP")->get();
                foreach ($recp as $user) {
                    $casename=$user['name'];
                    $caseemail=$user['email'];
                    if ($caseemail != '') {
                        SendReceptionADleads::dispatch($casename, $caseemail, $referencenumber, $role, $caselink, $saveMethod, $custname);
                    }
                }
                DispatchController::saveTabStatus($lead_id);
                DispatchController::setDispatchStatus($lead_id);
                $leadDetails->save();
                return response()
                    ->json([
                        'status' => "success",
                        'messages' => array('Action' => array('Action Submitted Successfully')),
                    ], 201);
            } else {
                return response()
                    ->json([
                        'status' => "error",
                        'data' => null,
                        'messages' => array('notFound' => array('Lead not found'))
                    ], 202);
            }
        }
    }
    
    //upload signature
    public function SignUpload(Request $request)
    {
        $valid=Validator::make($request->all(), [
            'signature'=>'required '
        
        ]);
        if ($valid->fails()) {
            return response()
                ->json([
                    'status' => "error",
                    'data' => null,
                    'messages' => $valid->errors()
                ], 200);
        } else {
            $uploadFile = $request->file('signature');
            if ($uploadFile) {
                if ($uploadFile) {
                    $upload = $this->uploadToCloud($uploadFile);
                } else {
                    $upload = '';
                }
                return response()->json([
                    'success' => "success",
                    'messages' => $upload
                ], 201);
            } else {
                return response()
                    ->json([
                        'status' => "error",
                        'data' => null,
                        'messages' => array('notFound' => array('File not found'))
                    ], 202);
            }
        }
    }
    
    //save uploaded signature
    public function SignSave(Request $request)
    {
        $valid=Validator::make($request->all(), [
            'data.leadId' => 'required',
            'data.signature'=>'required ',
            'data.docIdArray' => 'required'
        ]);
        if ($valid->fails()) {
            return response()
                ->json([
                    'status' => "error",
                    'data' => null,
                    'messages' => $valid->errors()
                ], 200);
        } else {
            $leadId=$request->input('data.leadId');
            $docIdArray=$request->input('data.docIdArray');
            $uploadFile = $request->input('data.signature');
            $docArray=[];
            foreach ($docIdArray as $doc) {
                if ($doc['documentId']!='NA') {
                    $docArray[]=$doc['documentId'];
                }
            }
            if (LeadDetails::where('_id', new ObjectID($leadId))->exists()) {
                $LeadDetails = LeadDetails::find($leadId);
                $leads = $LeadDetails['dispatchDetails']['documentDetails'];
                foreach ($leads as $count => $reply) {
                    if (in_array($reply['id'], $docArray)) {
                        LeadDetails::where(
                            '_id',
                            new ObjectId($leadId)
                        )->update(array('dispatchDetails.documentDetails.' . $count . '.signUpload' => $uploadFile));
                    }
                }
                $LeadDetails->save();
                return response()->json([
                    'success' => "success",
                    'messages' => array('signature' => array('Signature uploaded Successfully'))
                ], 201);
            } else {
                return response()
                    ->json([
                        'status' => "error",
                        'data' => null,
                        'messages' => array('notFound' => array('Lead not found'))
                    ], 202);
            }
        }
    }
    
    /**
     * cron job for part time payment
     */
    public static function sendPushNotification()
    {
        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60 * 20);
        $notificationBuilder = new PayloadNotificationBuilder();
        $notificationBuilder->setSound(null);
        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['data' => 'test data']);
        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();
        
        // You must change it to get your tokens
        $tokens = User::pluck('Token')->toArray();
        if (count($tokens)) {
            $downstreamResponse = FCM::sendTo($tokens, $option, $notification, $data);
            //          $fcm_deatils = FcmDetails::all();
        }
    }
    
    /**
     * api to save live location
     */
    public function saveLiveLocation(Request $request)
    {
        $longitude = $request->input('data.long');
        $latitude = $request->input('data.lat');
        $user_id = $request->input('data.UserId');
        $valid=Validator::make($request->all(), [
            'data.long' => 'required',
            'data.lat' => 'required',
            'data.UserId' => 'required'
        ]);
        if ($valid->fails()) {
            return response()
                ->json([
                    'status' => "error",
                    'data' => null,
                    'messages' => $valid->errors()
                ], 200);
        } else {
            date_default_timezone_set('Asia/Dubai');
            if (User::where('_id', new ObjectID($user_id))->exists()) {
                if ($latitude!='' && $longitude !='') {
                    $CurrentLocation=[];
                    date_default_timezone_set('Asia/Dubai');
                    $submit_time = date('H:i:s');
                    $user=User::find($user_id);
                    $live_object = new \stdClass();
                    $live_object->location =  ['type' => 'Point', 'coordinates' => [$latitude,$longitude]];
                    $live_object->updateBy = $user->name;
                    $live_object->updateByID = new ObjectID($user_id);
                    $live_object->deliveryDate =date('d/m/Y');
                    $live_object->deliveryTime =$submit_time;
                    $CurrentLocation[] = $live_object;
                    //              if (isset($user->liveLocation)) {
                    //                  $user->where('_id', new ObjectId($user_id))->push('liveLocation', $CurrentLocation);
                    //              } else {
                    $user->liveLocation = $CurrentLocation;
                    //              }
                    $user->save();
                    return response()
                        ->json([
                            'status' => "success",
                            'messages' => array('Action' => array('Action Submitted Successfully')),
                        ], 201);
                } else {
                    return response()
                    ->json([
                        'status' => "error",
                        'data' => null,
                        'messages' => array('notFound' => array('Location not found'))
                    ], 202);
                }
            } else {
                return response()
                    ->json([
                        'status' => "error",
                        'data' => null,
                        'messages' => array('notFound' => array('User not found'))
                    ], 202);
            }
        }
    }
    /**
     * function for update token
     */
    public function updateToken(Request $request)
    {
        $token = $request->input('data.Token');
        $user_id = $request->input('data.UserId');
        $valid=Validator::make($request->all(), [
            'data.Token' => 'required',
            'data.UserId' => 'required'
        ]);
        if ($valid->fails()) {
            return response()
                ->json([
                    'status' => "error",
                    'data' => null,
                    'messages' => $valid->errors()
                ], 200);
        } else {
            if (User::where('_id', new ObjectID($user_id))->exists()) {
                $user=User::find($user_id);
                $user->Token=$token;
                $user->save();
                return response()
                    ->json([
                        'status' => "success",
                        'messages' => array('Action' => array('Action Submitted Successfully')),
                    ], 201);
            } else {
                return response()
                    ->json([
                        'status' => "error",
                        'data' => null,
                        'messages' => array('notFound' => array('User not found'))
                    ], 202);
            }
        }
    }
    protected function collectEmployees($employees)
    {
        $ids = [];
        $employeeList = [];
        $supervisorList = [];
        foreach ($employees as $emp) {
            $ids[] = new ObjectId($emp['id']);
        }
        $users = User::select('_id', 'role', 'employees')->whereIn('_id', $ids)->get();
        if ($users) {
            foreach ($users as $result) {
                if ($result && $result->role != 'SV') {
                    $employeeList = array_merge($employeeList, [new ObjectId($result->_id)]);
                } else {
                    if (in_array(new ObjectId($result->_id), $employeeList)) {
                        continue;
                    }
                    $employeeList = array_merge($employeeList, [new ObjectId($result->_id)]);
                    $supervisorList = array_merge($supervisorList, [$result]);
                }
            }
            foreach ($supervisorList as $supervisor) {
                $employ = $this->collectEmployees($supervisor->employees);
                $employeeList = array_merge($employeeList, $employ);
            }
        }
        return $employeeList;
    }
}
