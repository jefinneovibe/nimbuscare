<?php

namespace App\Http\Controllers;

use App\CaseManager;
use App\Customer;
use App\CustomerType;
use App\DeliveryMode;
use App\DispatchStatus;
use App\DispatchTypes;
use App\DocumentType;
use App\Jobs\SendAssignleads;
use App\Jobs\SendcasemanagerADleads;
use App\Jobs\SendCustomer;
use App\Jobs\SendReceptionADleads;
use App\LeadDetails;
use App\newAgents;
use App\RecipientDetails;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use MongoDB\BSON\ObjectId;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\PipelineItems;

class DispatchBulkActionController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth.dispatcher');
	}
	/**
	 * submit leads bulk
	 */
	public function submitLeads(Request $request)
	{
		$myArray = $request->input('checked_array');
		$ids_array = json_decode($myArray, true);
		//		$ids_array=$request->input('checked_array');
		$updatedBy_obj = new \stdClass();
		$updatedBy_obj->id = new ObjectID(Auth::id());
		$updatedBy_obj->name = Auth::user()->name;
		$updatedBy_obj->date = date('d/m/Y');
		$updatedBy_obj->action = "Dispatch Slip Created";
		$updatedBy[] = $updatedBy_obj;
		foreach ($ids_array as $id) {
			$reception_flg = 0;
			$completed_flg = 0;
			$leadDetails = LeadDetails::find($id);
			$cusname = $leadDetails->customer['name'];
			$leads = $leadDetails['dispatchDetails']['documentDetails'];
			foreach ($leads as $count => $reply) {
				if ($reply['DocumentCurrentStatus'] == '1' || $reply['DocumentCurrentStatus'] == '10') {

					DispatchController::saveDocumentStatus($id, $count, '18');
					$reception_flg = 1;
				}
				if ($reply['DocumentCurrentStatus'] == '6') {

					DispatchController::saveDocumentStatus($id, $count, '7');
					$completed_flg = 1;
				}
				if ($reply['DocumentCurrentStatus'] == '15') {
					DispatchController::saveDocumentStatus($id, $count, '16');
					$completed_flg = 1;
				}
			}
			if ($reception_flg != '1') {
				DispatchController::saveTabStatus($id);
				DispatchController::setDispatchStatus($id);
			} else {
				$data = array(
					'dispatchStatus' => 'Reception'
				);
				LeadDetails::where('_id', new ObjectID($id))->update($data, ['upsert' => true]);
				DispatchController::saveDirectTabStatus($id);
				//
				//				$caselink = url('/dispatch/receptionist-list/');
				//				$recp = User::where('isActive', 1)->where('role', "RP")->get();
				//				foreach ($recp as $user) {
				//					$casename = $user['name'];
				//					$caseemail = $user['email'];
				//                    if($caseemail != '') {
				//                        SendReceptionADleads::dispatch($casename, $caseemail, $leadDetails->referenceNumber,
				//                            Auth::user()->name, $caselink, 'submit_button', $cusname);
				//                    }
				//				}
			}
		}
		Session::flash('status', 'Selected lead(s) are submitted successfully');
		LeadDetails::whereIn('_id', $ids_array)->push('updatedBy', $updatedBy);
		return 'success';
	}
	/**
	 * Function for accept all in employee login
	 */
	public function acceptAll(Request $request)
	{
		$selected_leads = $request->input('selected_leads');
		$statusArray = [];
		$uniq_val = [];
		$action = "Reception";
		$leadss = "";
		$saveMethod = "approve_button";
		foreach ($selected_leads as $leadDetails1) {
			$leadDetails = LeadDetails::find($leadDetails1);
			//        $cusname=$leadDetails->customer['name'];
			//        $casemanagerid=$leadDetails->caseManager['id'];
			//        $casemanager=User::find($casemanagerid);
			//        $caseemail=$casemanager->email;
			//        $casename=$casemanager->name;
			//        $caselink=url('/dispatch/receptionist-list/');
			//        $recp=User::where('isActive',1)->where('role',"RP")->get();
			$leads = $leadDetails['dispatchDetails']['documentDetails'];
			$transferTo = $leadDetails['transferTo'];
			foreach ($transferTo as $transfer) {
				$uniq_val[] = $transfer['uniqval'];
			}
			foreach ($leads as $count => $reply) {
				if ($reply['DocumentCurrentStatus'] == '9' && in_array($reply['uniqTransferId'], $uniq_val)) {
					DispatchController::saveDocumentStatus($leadDetails->_id, $count, '7');
				}
				if ($reply['DocumentCurrentStatus'] == '14' && in_array($reply['uniqTransferId'], $uniq_val)) {
					DispatchController::saveDocumentStatus($leadDetails->_id, $count, '16');
				}
			}
			foreach ($uniq_val as $count => $transfer) {
				LeadDetails::where(
					'_id',
					new ObjectId($leadDetails1)
				)->update(array('transferTo.' . $count . '.status' => 'Completed'));
			}

			DispatchController::saveTabStatus($leadDetails1);
			DispatchController::setDispatchStatus($leadDetails1);
			$employee = User::find(session('employee_id'));
			//        SendcasemanagerADleads::dispatch($casename,$caseemail,$leadDetails->referenceNumber,Auth::user()->name,$caselink,$saveMethod,$action,$leadss,$cusname);
			//        foreach($recp as $user){
			//            $casename=$user['name'];
			//            $caseemail=$user['email'];
			//            if($caseemail != '') {
			//                SendReceptionADleads::dispatch($casename, $caseemail, $leadDetails->referenceNumber, $employee->name, $caselink, $saveMethod, $cusname);
			//            }
			//        }

		}

		Session::flash('status', 'Selected leads are completed successfully.');
		return 'success';
	}

	/**
	 * Function for bulk action in Scheduled delivery
	 */
	public function bulkSchedule(Request $request)
	{
		date_default_timezone_set('Asia/Dubai');
		$comment_time = date('H:i:s');
		$action = $request->input('action');
		$myArray = $request->input('selected_leads');
		$selected_leads = json_decode($myArray, true);
		$updatedBy_obj = new \stdClass();
		$updatedBy_obj->id = new ObjectID(Auth::id());
		$updatedBy_obj->name = Auth::user()->name;
		$updatedBy_obj->date = date('d/m/Y');
		$updatedBy_obj->action = "Reception";
		$updatedBy[] = $updatedBy_obj;
		$scheduleStatusObject = new \stdClass();
		$scheduleStatusObject->id = new ObjectId(Auth::id());
		$scheduleStatusObject->name = Auth::user()->name;
		$scheduleStatusObject->date = date('d/m/Y');

		if ($action == 'approve_all') {
			$caselink = url('/dispatch/delivery/');
			$action = "Delivery/Collection";
			$leadss = "";
			$saveMethod = "approve_button";

			foreach ($selected_leads as $id) {
				$comment_array = [];
				$leadDetails = LeadDetails::find($id);
				$casemanagerid = $leadDetails->caseManager['id'];
				$cusname = $leadDetails->customer['name'];
				$casemanager = User::find($casemanagerid);
				$caseemail = $casemanager->email;
				$casename = $casemanager->name;
				$assignid = $leadDetails->employee['id'];
				$assign = User::find($assignid);
				$assignname = $assign->name;
				$assignemail = $assign->email;
				$custname = $leadDetails->customer['name'];
				$custemail = $leadDetails->contactEmail;
				$leads = $leadDetails['dispatchDetails']['documentDetails'];
				$test_array = ['13'];
				foreach ($leads as $count => $reply) {
					if (in_array($reply['DocumentCurrentStatus'], $test_array)) {
						DispatchController::saveDocumentStatus($id, $count, '11');
					}
				}
				DispatchController::saveTabStatus($id);
				DispatchController::setDispatchStatus($id);
				$prefered_date = $leadDetails->dispatchDetails['date_time'];


				//                if($caseemail != '') {
				//                    SendcasemanagerADleads::dispatch($casename, $caseemail, $leadDetails->referenceNumber, Auth::user()->name, $caselink, $saveMethod, $action, $leadss, $cusname);
				//                }
				//                if($assignemail != ''){
				//                    SendAssignleads::dispatch($assignname,$assignemail,$leadDetails->referenceNumber,Auth::user()->name,$caselink,$saveMethod,$action,$cusname);
				//                }
				//                if ($custemail != ''){
				//                    SendCustomer::dispatch($custname,$custemail,$leadDetails->referenceNumber,Auth::user()->name,$caselink,$saveMethod,$action,$leadss, $prefered_date);
				//                }
				//                $recp=User::where('isActive',1)->where('role',"RP")->get();
				//                foreach($recp as $user){
				//                    $casename=$user['name'];
				//                    $caseemail=$user['email'];
				//                    if($caseemail != '') {
				//                        SendReceptionADleads::dispatch($casename, $caseemail, $leadDetails->referenceNumber, Auth::user()->name, $caselink, $saveMethod, $cusname);
				//                    }
				//                }
				$comment_object = new \stdClass();
				$comment_object->comment = 'Bulk Action- Approved from schedule for delivery/collection';
				$comment_object->commentBy = Auth::user()->name;
				$comment_object->commentTime = $comment_time;
				$comment_object->id = new ObjectId(Auth::id());
				$comment_object->date = date('d/m/Y');
				$comment_array[] = $comment_object;
				$leadDetails->push('comments', $comment_array);
				$leadDetails->save();
			}
			$scheduleStatusObject->status = "Approved";
			$ScheduleStatus[] = $scheduleStatusObject;
			$go_to = 'delivery';

			//            LeadDetails::whereIn('_id',$selected_leads)->update(['dispatchStatus' => 'Delivery']);
			Session::flash('status', 'Selected leads are approved successfully');
		} else {
			$caselink = url('/dispatch/receptionist-list/');
			$action = "Schedule for delivery/Collection";
			$leadss = "";
			$saveMethod = "reject_button";
			foreach ($selected_leads as $id) {
				$comment_array = [];
				$leadDetails = LeadDetails::find($id);
				$cusname = $leadDetails->customer['name'];
				$casemanagerid = $leadDetails->caseManager['id'];
				$casemanager = User::find($casemanagerid);
				$caseemail = $casemanager->email;
				$casename = $casemanager->name;
				$leads = $leadDetails['dispatchDetails']['documentDetails'];
				$test_array = ['13'];
				foreach ($leads as $count => $reply) {
					if (in_array($reply['DocumentCurrentStatus'], $test_array)) {
						DispatchController::saveDocumentStatus($id, $count, '12');
					}
				}
				DispatchController::saveTabStatus($id);
				DispatchController::setDispatchStatus($id);
				if ($caseemail != '') {
					SendcasemanagerADleads::dispatch($casename, $caseemail, $leadDetails->referenceNumber, Auth::user()->name, $caselink, $saveMethod, $action, $leadss, $cusname);
				}
				$recp = User::where('isActive', 1)->where('role', "RP")->get();
				foreach ($recp as $user) {
					$casename = $user['name'];
					$caseemail = $user['email'];
					if ($caseemail != '') {
						SendReceptionADleads::dispatch($casename, $caseemail, $leadDetails->referenceNumber, Auth::user()->name, $caselink, $saveMethod, $cusname);
					}
				}
				$comment_object = new \stdClass();
				$comment_object->comment = 'Bulk Action- Rejected from schedule for delivery/collection';
				$comment_object->commentBy = Auth::user()->name;
				$comment_object->commentTime = $comment_time;
				$comment_object->id = new ObjectId(Auth::id());
				$comment_object->date = date('d/m/Y');
				$comment_array[] = $comment_object;
				$leadDetails->push('comments', $comment_array);
				$leadDetails->save();
				$leadDetails->schedulerejectstatus = '';
				$leadDetails->save();
			}
			$scheduleStatusObject->status = "Rejected";
			$ScheduleStatus[] = $scheduleStatusObject;
			$go_to = 'reception';
			//	        LeadDetails::whereIn('_id',$selected_leads)->update(['dispatchStatus' => 'Reception']);
			Session::flash('status', 'Selected leads are rejected successfully');
		}
		LeadDetails::whereIn('_id', $selected_leads)->push('scheduleStatus', $ScheduleStatus);
		LeadDetails::whereIn('_id', $selected_leads)->push('updatedBy', $updatedBy);
		return response()->json(['success' => true, 'go_to' => $go_to]);
	}

	/**
	 * create label for leads
	 */
	public function createLabel(Request $request)
	{
		$myArray = $request->input('checked_array');
		$ids_array = json_decode($myArray, true);
		$LeadDetails = LeadDetails::whereIn('_id', $ids_array);

		if (session('role') == 'Employee') {
			$LeadDetails = $LeadDetails->where(function ($q) {
				$q->where('caseManager.id', new ObjectID(Auth::user()->_id))
					->orwhere('agent.id', new ObjectID(Auth::user()->_id))
					->orwhere('employee.id', new ObjectID(Auth::user()->_id));
			});
		} elseif (session('role') == 'Agent') {
			$LeadDetails = $LeadDetails->where(function ($q) {
				$q->where('agent.id', new ObjectID(Auth::user()->_id))
					->orwhere('caseManager.id', new ObjectID(Auth::user()->_id))
					->orwhere('employee.id', new ObjectID(Auth::user()->_id));
			});
		} elseif (session('role') == 'Coordinator') {
			$LeadDetails = $LeadDetails->where(function ($q) {
				$q->where('agent.id', session('assigned_agent'))
					->orwhere('agent.id', new ObjectID(Auth::user()->_id))
					->orwhere('employee.id', new ObjectID(Auth::user()->_id))
					->orwhere('employee.id', session('assigned_agent'));
			});
		} elseif (session('role') == 'Supervisor') {
			$LeadDetails = $LeadDetails->where(function ($q) {
				$q->where('agent.id', new ObjectID(Auth::user()->_id))
					->orwhere('caseManager.id', new ObjectID(Auth::user()->_id))
					->orwhere('employee.id', new ObjectID(Auth::user()->_id))
					->orwhereIn('employee.id', session('employees'));
			});
		} else if (session('role') != 'Admin' && session('role') != 'Receptionist') {
			$LeadDetails = $LeadDetails->where('employee.id', new ObjectID(Auth::user()->_id));
		}
		//        else{
		//            $LeadDetails = $LeadDetails->get();
		//        }

		$LeadDetails = $LeadDetails->select('customer', 'dispatchDetails.address');
		$result = [];
		$LeadDetails->chunk(500, function ($properties) use (&$result) {
			foreach ($properties as $property) {
				$result[] = $property;
			}
		});

		$pdf = PDF::loadView('dispatch.pdf.leads_label', ['leadDetails' => $result])->setPaper('a3')->setOption('margin-bottom', 0)->setOption('footer-right', '--internal');
		$pdf_name = 'label' . time() . '_' . rand() . '.pdf';
		$temp_path = public_path('pdf/' . $pdf_name);
		$pdf->save('pdf/' . $pdf_name);
		$pdf_file = $this->uploadFileToCloud_file($pdf_name, $temp_path);
		unlink($temp_path);
		$label_obj = new \stdClass();
		$label_obj->name = $pdf_file;
		$label_obj->created_by = Auth::user()->name;
		$label_obj->created_date = date('d/m/Y');
		$labelCreated[] = $label_obj;
		LeadDetails::whereIn('_id', $ids_array)->push('labelCreated', $labelCreated);

		//	    Session::flash('status','Label created successfully');
		return response()->json(['success' => true, 'pdf' => $pdf_file]);
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
	 * create log pdf
	 */
	public function createLog(Request $request)
	{
		$myArray = $request->input('checked_array');
		$ids_array = json_decode($myArray, true);
		$path = $request->input('path');
		$LeadDetails = LeadDetails::whereIn('_id', $ids_array);
		if (session('role') == 'Employee') {
			$LeadDetails = $LeadDetails->where(function ($q) {
				$q->where('caseManager.id', new ObjectID(Auth::user()->_id))
					->orwhere('agent.id', new ObjectID(Auth::user()->_id))
					->orwhere('employee.id', new ObjectID(Auth::user()->_id));
			});
		} else if (session('role') == 'Agent') {
			$LeadDetails = $LeadDetails->where(function ($q) {
				$q->where('agent.id', new ObjectID(Auth::user()->_id))
					->orwhere('caseManager.id', new ObjectID(Auth::user()->_id))
					->orwhere('employee.id', new ObjectID(Auth::user()->_id));
			});
		} else if (session('role') == 'Coordinator') {
			$LeadDetails = $LeadDetails->where(function ($q) {
				$q->where('agent.id', session('assigned_agent'))
					->orwhere('agent.id', new ObjectID(Auth::user()->_id))
					->orwhere('employee.id', new ObjectID(Auth::user()->_id))
					->orwhere('employee.id', session('assigned_agent'));
			});
		} elseif (session('role') == 'Supervisor') {
			$LeadDetails = $LeadDetails->where(function ($q) {
				$q->where('agent.id', new ObjectID(Auth::user()->_id))
					->orwhere('caseManager.id', new ObjectID(Auth::user()->_id))
					->orwhere('employee.id', new ObjectID(Auth::user()->_id))
					->orwhereIn('employee.id', session('employees'));
			});
		} else if (session('role') != 'Admin' && session('role') != 'Receptionist') {
			$LeadDetails = $LeadDetails->where('employee.id', new ObjectID(Auth::user()->_id));
		}
		$LeadDetails = $LeadDetails->select('created_at', 'referenceNumber', 'customer', 'contactNumber', 'dispatchType', 'dispatchDetails.address');
		$result = [];
		$LeadDetails->chunk(500, function ($properties) use (&$result) {
			foreach ($properties as $property) {
				$result[] = $property;
			}
		});
		$pdf = PDF::loadView('dispatch.pdf.dispatch_collection_log', ['leadDetails' => $result, 'path' => $path])->setPaper('a4')->setOrientation('landscape')
			->setOption('footer-right', '--internal')->setOption('margin-bottom', 0);
		//   $pdf = PDF::loadView('dispatch.pdf.dispatch_collection_log',['leadDetails' =>$leadDetails])->setPaper('a3')->setOrientation('portrait')->inline();
		$pdf_name = 'log' . time() . '_' . rand() . '.pdf';
		//		$pdf->setOption('page-width', '200');
		//		$pdf->setOption('page-height', '260')->inline();
		$temp_path = public_path('pdf/' . $pdf_name);
		$pdf->save('pdf/' . $pdf_name);
		$pdf_file = $this->uploadFileToCloud_file($pdf_name, $temp_path);
		unlink($temp_path);
		$log_obj = new \stdClass();
		$log_obj->name = $pdf_file;
		$log_obj->created_by = Auth::user()->name;
		$log_obj->created_date = date('d/m/Y');
		$logCreated[] = $log_obj;
		LeadDetails::whereIn('_id', $ids_array)->push('logCreated', $logCreated);
		//		Session::flash('status','Log created successfully');
		return response()->json(['success' => true, 'pdf' => $pdf_file]);
	}


	/**
	 * upload agent
	 */
	public function uploadAgent()
	{

		$excel = public_path('/dispatch/PrdDetailSum.xls');
		Excel::load($excel, function ($reader) {
			//			DB::table('allAgents ')->truncate();
			$reader->each(function ($sheet) {
				if ($sheet->getTitle() == 'Sheet1') {
					$agent = [];
					foreach ($sheet as $sheetVal) {
						$allAgents = User::where('empID', $sheetVal->agentcode)->first();
						if (!$allAgents) {
							$array = explode(' ', $sheetVal->agentname, 2);

							$excel = new User();
							if (isset($array[0])) {
								$excel->firstName = $array[0];
							}
							if (isset($array[1])) {
								$excel->lastName = $array[1];
							} else {
								$excel->lastName = '';
							}
							$excel->name = $sheetVal->agentname;
							$excel->empID = $sheetVal->agentcode;
							$excel->isActive = (int) 1;
							$excel->position = 'Agent';
							$excel->role = 'AG';
							$excel->role_name = 'Agent';
							$excel->save();
						}
					}
				}
			});
		});
		return 'success';
	}

	/**
	 * upload customers
	 */
	public function uploadCustomers()
	{
		$excel = public_path('/dispatch/PrdDetailSum.xls');
		Excel::load($excel, function ($reader) {
			//			DB::table('allAgents ')->truncate();
			$reader->each(function ($sheet) {
				if ($sheet->getTitle() == 'Sheet1') {
					$agent = [];
					$count = 0;
					$new_count = 0;
					foreach ($sheet as $sheetVal) {
						$count++;
						$allCustomer = Customer::where('customerCode', $sheetVal->cid)->first();
						if (!$allCustomer) {

							$excel = new Customer();
							$excel->salutation = '';
							$excel->firstName = $sheetVal->customername;
							$excel->middleName = '';
							$excel->lastName = '';
							$excel->fullName = $sheetVal->customername;
							$excel->customerCode = $sheetVal->cid;
							$excel->customerCodeValue = $sheetVal->cid;
							$excel->addressLine1 = $sheetVal->address;
							$excel->status = (int) 1;

							$agent_object = new \stdClass();
							$id_agent = $sheetVal->agentcode;
							$agent = User::where('empID', $id_agent)->first();
							$name_agent = $agent->name;
							$agent_object->id = new ObjectID($agent->_id);
							$agent_object->name = $name_agent;
							$excel->agent = $agent_object;

							$contactNumber = [];
							$contactNumber[] = $sheetVal->contactnumber;
							$excel->contactNumber = $contactNumber;
							$customer_type_details = CustomerType::where('is_corporate', (int) 1)->first();
							$excel->customerType = new ObjectID($customer_type_details->_id);
							$excel->save();
							$new_count++;
						}
					}
					echo $new_count . '...';
					echo $count;
				}
			});
		});
		return 'success';
	}

	/**
	 * upload insurers
	 */
	public function uploadInsurers()
	{
		$excel = public_path('/dispatch/receipients_list.xlsx');
		Excel::load($excel, function ($reader) {
			//			DB::table('allAgents ')->truncate();
			$reader->each(function ($sheetVal) {
				$agent = [];
				//					foreach ($sheet as $sheetVal) {
				$allCustomer = RecipientDetails::where('companyId', $sheetVal->companyid)->first();
				if (!$allCustomer) {

					$excel = new RecipientDetails();
					$excel->salutation = '';
					$excel->firstName = $sheetVal->name;
					$excel->middleName = '';
					$excel->lastName = '';
					$excel->fullName = ucfirst(ucwords($sheetVal->name));
					$excel->addressLine1 = $sheetVal->address;
					$excel->accountNumber = $sheetVal->accountnumber;
					$excel->companyId = $sheetVal->companyid;
					$excel->status = (int) 1;
					$contactNumber = [];
					$contactNumber[] = $sheetVal->phonenumber;
					$excel->contactNumber = $contactNumber;
					$contactemail = [];
					$contactemail[] = strtolower($sheetVal->email);
					$excel->email = $contactemail;
					$customer_type_details = CustomerType::where('is_corporate', (int) 1)->first();
					$excel->customerType = new ObjectID($customer_type_details->_id);
					$excel->save();
				}
				//					}

			});
		});
		return 'success';
	}

	/**
	 * delete customers
	 */
	public function deleteCustomers()
	{
		$allCustomer = Customer::where('firstName', null)->get();
		foreach ($allCustomer as $cust) {
			$cust->delete();
			echo "success";
		}
	}

	/**
	 * change lowercase
	 */
	public function changeCase()
	{
		$recipients = RecipientDetails::all();
		$count = 0;
		foreach ($recipients as $recipient) {
			$recipient->firstName = ucwords(strtolower($recipient->firstName));
			$recipient->fullName = ucwords(strtolower($recipient->fullName));
			$recipient->save();
			$count++;
		}
		echo $count;
	}

	/**
	 * change lowercase
	 */
	public function changeCaseAgent()
	{
		$users = User::all();
		$count = 0;
		foreach ($users as $user) {
			$user->firstName = ucwords(strtolower($user->firstName));
			$user->lastName = ucwords(strtolower($user->lastName));
			$user->name = ucwords(strtolower($user->name));
			$user->save();
			$count++;
		}
		echo $count;
	}

	/**
	 * change lowercase
	 */
	public function changeCaseCustomers()
	{
		$users = Customer::all();
		$count = 0;
		foreach ($users as $user) {
			if (strtoupper($user->firstName) == $user->firstName) {
				$user->firstName = ucwords(strtolower($user->firstName));
			}
			if (strtoupper($user->middleName) == $user->middleName) {
				$user->middleName = ucwords(strtolower($user->middleName));
			}
			if (strtoupper($user->lastName) == $user->lastName) {
				$user->lastName = ucwords(strtolower($user->lastName));
			}
			if (strtoupper($user->fullName) == $user->fullName) {
				$user->fullName = ucwords(strtolower($user->fullName));
			}
			$user->save();
			$count++;
		}
		echo $count;
	}

	/**
	 * change agent name to direct in lead table
	 */
	public function changeAgentLead()
	{
		$customers = LeadDetails::where('active', 1)->where('agent.name', 'like',  'direct%')->get();
		$cunt = 0;
		foreach ($customers as $customer) {
			LeadDetails::where(
				'_id',
				new ObjectId($customer->_id)
			)->update(array('agent.name' => 'Direct', 'agent.id' => new ObjectID('5c30bc1eb8ace01d08691f32'), 'agent.empid' => 'B-0001'));

			LeadDetails::where(
				'_id',
				new ObjectId($customer->_id)
			)->update(array('dispatchDetails.agent' => 'Direct'));
			$cunt++;
		}

		echo "AGENT : " . $cunt;

		$caseManagers = LeadDetails::where('active', 1)->where('caseManager.name', 'like',  'direct%')->get();
		$cuntCase = 0;
		foreach ($caseManagers as $case) {
			LeadDetails::where(
				'_id',
				new ObjectId($case->_id)
			)->update(array('caseManager.name' => 'Direct', 'caseManager.id' => new ObjectID('5c30bc1eb8ace01d08691f32')));

			LeadDetails::where(
				'_id',
				new ObjectId($case->_id)
			)->update(array('dispatchDetails.caseManager' => 'Direct'));
			$cuntCase++;
		}
		echo "CASE " . $cuntCase;

		$assignto = LeadDetails::where('active', 1)->where('employee.name', 'like',  'direct%')->get();
		$cuntAssign = 0;
		foreach ($assignto as $assign) {
			LeadDetails::where(
				'_id',
				new ObjectId($assign->_id)
			)->update(array(
				'employee.name' => 'Direct', 'employee.id' => new ObjectID('5c30bc1eb8ace01d08691f32'),
				'employee.empId' => 'B-0001'
			));

			LeadDetails::where(
				'_id',
				new ObjectId($assign->_id)
			)->update(array(
				'dispatchDetails.employee.name' => 'Direct', 'dispatchDetails.employee.id' => new ObjectID('5c30bc1eb8ace01d08691f32'),
				'dispatchDetails.employee.empId' => 'B-0001'
			));
			$cuntAssign++;
		}
		echo "ASSIGN TO " . $cuntAssign;
	}

	/**
	 * all leads list page
	 */
	public function allLeads(Request $request)
	{
		if (!empty($request->input('agent'))) {
			$count = 0;
			foreach ($request->input('agent') as $cust) {
				$objectArray[$count] = new ObjectId($cust);
				$count++;
			}
			$agents = User::where('isActive', 1)->where(function ($q) {
				$q->where('role', 'EM')->orWhere('role', 'AG');
			})->whereIn('_id', $objectArray)->get();
		} else {
			$agents = '';
		}

		if (!empty($request->input('assigned'))) {
			$count = 0;
			foreach ($request->input('assigned') as $cust) {
				$objectArray[$count] = new ObjectId($cust);
				$count++;
			}
			$assigned_to = User::where('isActive', 1)->where(function ($q) {
				$q->where('role', 'EM')->orWhere('role', 'AG')->orWhere('role', 'CR')->orWhere('role', 'AD')->orWhere('role', 'MS')->orWhere('role', 'CO')
					->orwhere('role', 'SV');
			})->whereIn('_id', $objectArray)->get();
		} else {
			$assigned_to = '';
		}

		if (!empty($request->input('customer'))) {
			$count = 0;
			foreach ($request->input('customer') as $cust) {
				$objectArray[$count] = new ObjectId($cust);
				$count++;
			}
			$customers = Customer::whereIn('_id', $objectArray)->get();
			$recepients = RecipientDetails::whereIn('_id', $objectArray)->get();
			$customers = $customers->merge($recepients);
		} else {
			$customers = '';
		}

		$recipientsDetails = RecipientDetails::where('status', 0)->get();
		if (!empty($request->input('case_manager'))) {
			$count = 0;
			foreach ($request->input('case_manager') as $cust) {
				$objectArray[$count] = new ObjectId($cust);
				$count++;
			}
			$case_managers = User::where('isActive', 1)->where(function ($q) {
				$q->where('role', 'EM')->orWhere('role', 'AD')->orWhere('role', 'RP')->orWhere('role', 'AG')->orWhere('role', 'CO')->orwhere('role', 'SV');
			})->whereIn('_id', $objectArray)->get();
		} else {
			$case_managers = '';
		}

		if (!empty($request->input('dispatch'))) {
			$count = 0;
			foreach ($request->input('dispatch') as $cust) {
				$objectArray[$count] = new ObjectId($cust);
				$count++;
			}
			if (
				session('role') == 'Insurer' || session('role') == 'Employee' || session('role') == 'Agent' || session('role') == 'Coordinator' ||
				session('role') == 'Supervisor' || session('role') == 'Courier' || session('role') == 'Messenger' || session('role') == 'Accountant'
			) {
				$dispatch_type_check = DispatchTypes::where('type', '!=', 'Direct Collections')->whereIn('_id', $objectArray)->get();
			} else {
				$dispatch_type_check = DispatchTypes::whereIn('_id', $objectArray)->get();
			}
		} else {
			$dispatch_type_check = '';
		}
		if (!empty($request->input('delivery'))) {
			$count = 0;
			foreach ($request->input('delivery') as $cust) {
				$objectArray[$count] = new ObjectId($cust);
				$count++;
			}
			$delivery_mode_check = DeliveryMode::whereIn('_id', $objectArray)->get();
		} else {
			$delivery_mode_check = '';
		}

		$delivery_mode = DeliveryMode::all();
		if (
			session('role') == 'Insurer' || session('role') == 'Employee' || session('role') == 'Agent' || session('role') == 'Coordinator' ||
			session('role', 'Supervisor') || session('role') == 'Courier' || session('role') == 'Messenger' || session('role') == 'Accountant'
		) {
			$dispatch_types = DispatchTypes::where('type', '!=', 'Direct Collections')->get();
		} else {
			$dispatch_types = DispatchTypes::all();
		}
		$document_types = DocumentType::all();
		$filter_data = $request->input();
		$current_path = $request->path();
		return view('dispatch.all_leads')
			->with(compact(
				'customers',
				'agents',
				'case_managers',
				'current_path',
				'delivery_mode',
				'dispatch_types',
				'dispatch_type_check',
				'delivery_mode_check',
				'filter_data',
				'document_types',
				'recipientsDetails',
				'assigned_to'
			));
	}

	/**
	 * get lead all lead page
	 */
	public function getAllLeads(Request $request)
	{
		$draw = $request->get('draw');
		$start = $request->get('start');
		$length = $request->get('length');
		$filter = $request->input('search');
		$filter_data_en = $request->get('filterData');
		$filter_data = json_decode($filter_data_en);
		$sort = $request->get('field');
		$search = (isset($filter['value'])) ? $filter['value'] : false;
		session()->put('filter', $filter_data_en);
		session()->put('sort', $sort);
		$LeadDetails = LeadDetails::where('active', 1);
		if (session('role') == 'Employee') {
			$LeadDetails = $LeadDetails->where(function ($q) {
				$q->where('caseManager.id', new ObjectID(Auth::user()->_id))
					->orwhere('agent.id', new ObjectID(Auth::user()->_id))
					->orwhere('employee.id', new ObjectID(Auth::user()->_id));
			});
		} else if (session('role') == 'Agent') {
			$LeadDetails = $LeadDetails->where(function ($q) {
				$q->where('agent.id', new ObjectID(Auth::user()->_id))
					->orwhere('caseManager.id', new ObjectID(Auth::user()->_id))
					->orwhere('employee.id', new ObjectID(Auth::user()->_id));
			});
		} else if (session('role') == 'Coordinator') {
			$LeadDetails = $LeadDetails->where(function ($q) {
				$q->where('agent.id', session('assigned_agent'))
					->orwhere('agent.id', new ObjectID(Auth::user()->_id))
					->orwhere('employee.id', new ObjectID(Auth::user()->_id))
					->orwhere('employee.id', session('assigned_agent'));
			});
		} elseif (session('role') == 'Supervisor') {
			$LeadDetails = $LeadDetails->where(function ($q) {
				$q->where('agent.id', new ObjectID(Auth::user()->_id))
					->orwhere('caseManager.id', new ObjectID(Auth::user()->_id))
					->orwhere('employee.id', new ObjectID(Auth::user()->_id))
					->orwhereIn('employee.id', session('employees'));
			});
		} else if (session('role') != 'Admin' && session('role') != 'Receptionist') {
			$LeadDetails = $LeadDetails->where('employee.id', new ObjectID(Auth::user()->_id));
		}

		if (!empty($filter_data)) {
			if (!empty($filter_data->agent)) {
				$count = 0;
				foreach ($filter_data->agent as $agent) {
					$objectArray[$count] = new ObjectId($agent);
					$count++;
				}
				$LeadDetails = $LeadDetails->whereIn('agent.id', $objectArray);
			}
			if (!empty($filter_data->case_manager)) {
				$count = 0;
				foreach ($filter_data->case_manager as $manager) {
					$objectArray[$count] = new ObjectId($manager);
					$count++;
				}
				$LeadDetails = $LeadDetails->whereIn('caseManager.id', $objectArray);
			}
			if (!empty($filter_data->customer)) {
				$count = 0;
				foreach ($filter_data->customer as $cust) {
					$objectArray[$count] = new ObjectId($cust);
					$count++;
				}
				$LeadDetails = $LeadDetails->whereIn('customer.id', $objectArray);
			}
			if (!empty($filter_data->delivery)) {
				$count = 0;
				foreach ($filter_data->delivery as $mode) {
					$objectArray[$count] = new ObjectId($mode);
					$count++;
				}
				$LeadDetails = $LeadDetails->whereIn('deliveryMode.id', $objectArray);
			}
			if (!empty($filter_data->dispatch)) {
				$count = 0;
				foreach ($filter_data->dispatch as $type) {
					$objectArray[$count] = new ObjectId($type);
					$count++;
				}
				$LeadDetails = $LeadDetails->whereIn('dispatchType.id', $objectArray);
			}
			if (!empty($filter_data->assigned)) {
				$count = 0;
				foreach ($filter_data->assigned as $type) {
					$objectArray[$count] = new ObjectId($type);
					$count++;
				}
				$LeadDetails = $LeadDetails->whereIn('employee.id', $objectArray);
			}
			if (!empty($filter_data->status)) {
				$count = 0;
				foreach ($filter_data->status as $stat) {
					$objectArray[$count] = $stat;
					$count++;
				}
				$LeadDetails = $LeadDetails->whereIn('dispatchStatus', $objectArray);
			}
		}

		if (!empty($sort)) {
			if ($sort == "Customer Name") {
				$LeadDetails = $LeadDetails->orderBy('customer.name');
			} elseif ($sort == "Agent") {
				$LeadDetails = $LeadDetails->orderBy('agent.name');
			} elseif ($sort == "Case Manager") {
				$LeadDetails = $LeadDetails->orderBy('caseManager.name');
			} elseif ($sort == "Dispatch Type") {
				$LeadDetails = $LeadDetails->orderBy('dispatchType.dispatchType');
			} elseif ($sort == "Delivery Mode") {
				$LeadDetails = $LeadDetails->orderBy('deliveryMode.deliveryMode');
			}
		} elseif (empty($sort)) {
			$LeadDetails = $LeadDetails->orderBy(
				'created_at',
				'DESC'
			);
		}
		if ($search) {

			$LeadDetails = $LeadDetails->where(function ($query) use ($search) {
				$query->Where('referenceNumber', 'like', '%' . $search . '%')
					->orWhere('customer.name', 'like', '%' . $search . '%')
					->orWhere('customer.recipientName', 'like', '%' . $search . '%')
					->orWhere('customer.customerCode', 'like', '%' . $search . '%')
					->orWhere('agent.name', 'like', '%' . $search . '%')
					->orWhere('caseManager.name', 'like', '%' . $search . '%')
					->orWhere('contactNumber', 'like', '%' . $search . '%')
					//					->orWhere('contactEmail', 'like', '%' . $search . '%')
					->orWhere('deliveryMode.deliveryMode', 'like', '%' . $search . '%')
					->orWhere('dispatchStatus', 'like', '%' . $search . '%')
					->orWhere('dispatchType.dispatchType', 'like', '%' . $search . '%');
			});


			session()->put('search', $search);
		}
		if ($search == "") {
			$LeadDetails = $LeadDetails;
			session()->put('search', "");
		}

		$searchField = $request->get('searchField');
		if ($searchField != "") {

			$LeadDetails = $LeadDetails->where(function ($query) use ($searchField) {
				$query->Where('referenceNumber', 'like', '%' . $searchField . '%')
					->orWhere('customer.name', 'like', '%' . $searchField . '%')
					->orWhere('customer.recipientName', 'like', '%' . $searchField . '%')
					->orWhere('customer.customerCode', 'like', '%' . $searchField . '%')
					->orWhere('agent.name', 'like', '%' . $searchField . '%')
					->orWhere('caseManager.name', 'like', '%' . $searchField . '%')
					->orWhere('contactNumber', 'like', '%' . $searchField . '%')
					//					->orWhere('contactEmail', 'like', '%' . $searchField . '%')
					->orWhere('dispatchStatus', 'like', '%' . $searchField . '%')
					->orWhere('deliveryMode.deliveryMode', 'like', '%' . $searchField . '%')
					->orWhere('dispatchType.dispatchType', 'like', '%' . $searchField . '%');
			});
		}
		$total_leads = $LeadDetails->count(); // get your total no of data;
		$members_query = $LeadDetails;
		$search_count = $members_query->count();
		$LeadDetails->skip((int) $start)->take((int) $length);
		$final_leads = $LeadDetails->orderBy(
			'created_at',
			'DESC'
		)->get();


		foreach ($final_leads as $leads) {
			// dd($leads['dispatchDetails']['employee']);
			if ($leads['dispatchDetails'] != "") {
				$check = '<div class="custom_checkbox">' .
					'<input type="checkbox" name="marked_list[]" class="inp-cbx check" id="' . $leads->_id . '" style="display: none"  onchange="markedCheck(this.id)">' .
					'<label for="' . $leads->_id . '" class="cbx">' .
					'<span>' .
					'    <svg width="10px" height="8px" viewBox="0 0 12 10">' .
					'      <polyline points="1.5 6 4.5 9 10.5 1"></polyline>' .
					'    </svg>' .
					'</span>' .
					'    <span></span>' .
					'</label>' .
					'</div>';
				$count = sizeof($leads['dispatchDetails']['documentDetails']);
				$check = '<div class="custom_checkbox">' .
					'<input type="checkbox" name="marked_list[]" class="inp-cbx check" id="' . $leads->_id . '" style="display: none"  onchange="markedCheck(this.id)">' .
					'<label for="' . $leads->_id . '" class="cbx">' .
					'<span>' .
					'    <svg width="10px" height="8px" viewBox="0 0 12 10">' .
					'      <polyline points="1.5 6 4.5 9 10.5 1"></polyline>' .
					'    </svg>' .
					'</span>' .
					'    <span></span>' .
					'</label>' .
					'</div>';
				for ($i = 0; $i < $count; $i++) {
					if (
						$leads['dispatchDetails']['land_mark'] && $leads['dispatchDetails']['documentDetails'] && $leads['dispatchDetails']['documentDetails'][$i]['documentName'] && $leads['dispatchDetails']['documentDetails'][$i]['documentName'] &&
						isset($leads['dispatchDetails']['documentDetails'][$i]['amount']) && $leads['dispatchDetails']['documentDetails'][$i]['documentDescription'] &&
						$leads['dispatchDetails']['documentDetails'][$i]['documentType'] && $leads['dispatchDetails']['address'] && isset($leads['dispatchDetails']['employee'])
					) {
						if ($leads['dispatchDetails']['documentDetails'][$i]['amount'] == "NA") {

							$check = '<div class="custom_checkbox">' .
								'<input   type="checkbox" name="marked_list[]" disabled class="inp-cbx check" id="' . $leads->_id . '" style="display: none"  onchange="markedCheck(this.id)">' .
								'<label for="' . $leads->_id . '" class="cbx" style="cursor: auto;">' .
								'<span>' .
								'    <svg width="10px" height="8px" viewBox="0 0 12 10">' .
								'      <polyline points="1.5 6 4.5 9 10.5 1"></polyline>' .
								'    </svg>' .
								'</span>' .
								'    <span><i style="color: #f96617;font-size: 12px;" class="fa fa-exclamation-triangle" data-toggle="tooltip" title="Lead Not Completed" aria-hidden="true"></i></span>' .
								'</label>' .
								'</div>';
							$disable = true;
							break;
						} else {
							$disable = false;
						}
						if ($leads['dispatchDetails']['deliveryMode']['deliveryMode'] == "Courier") {
							$bill = $leads['dispatchDetails']['deliveryMode']['wayBill'];
							if ($bill == "--") {
								$check = '<div class="custom_checkbox">' .
									'<input   type="checkbox" name="marked_list[]" disabled class="inp-cbx check" id="' . $leads->_id . '" style="display: none"  onchange="markedCheck(this.id)">' .
									'<label for="' . $leads->_id . '" class="cbx" style="cursor: auto;">' .
									'<span>' .
									'    <svg width="10px" height="8px" viewBox="0 0 12 10">' .
									'      <polyline points="1.5 6 4.5 9 10.5 1"></polyline>' .
									'    </svg>' .
									'</span>' .
									'    <span><i style="color: #f96617;font-size: 12px;" class="fa fa-exclamation-triangle" data-toggle="tooltip" title="Lead Not Completed" aria-hidden="true"></i></span>' .
									'</label>' .
									'</div>';
								$disable = true;
								break;
							} else {
								$disable = false;
							}
						} else {
							$disable = false;
						}
						if (Auth::user()->_id != @$leads->caseManager['id']) {
							$check = '<div class="custom_checkbox">' .
								'<input  type="checkbox" name="marked_list[]" disabled class="inp-cbx check" id="' . $leads->_id . '" style="display: none"  onchange="markedCheck(this.id)">' .
								'<label for="' . $leads->_id . '" class="cbx" style="cursor: auto;">' .
								'<span>' .
								'    <svg width="10px" height="8px" viewBox="0 0 12 10">' .
								'      <polyline points="1.5 6 4.5 9 10.5 1"></polyline>' .
								'    </svg>' .
								'</span>' .
								'    <span></span>' .
								'</label>' .
								'</div>';
							$disable = true;
							break;
						}
					} else {
						$check = '<div class="custom_checkbox">' .
							'<input  type="checkbox" name="marked_list[]" disabled class="inp-cbx check" id="' . $leads->_id . '" style="display: none"  onchange="markedCheck(this.id)">' .
							'<label for="' . $leads->_id . '" class="cbx" style="cursor: auto;">' .
							'<span>' .
							'    <svg width="10px" height="8px" viewBox="0 0 12 10">' .
							'      <polyline points="1.5 6 4.5 9 10.5 1"></polyline>' .
							'    </svg>' .
							'</span>' .
							'    <span><i style="color: #f96617;font-size: 12px;" class="fa fa-exclamation-triangle" data-toggle="tooltip" title="Lead Not Completed" aria-hidden="true"></i></span>' .
							'</label>' .
							'</div>';
						$disable = true;
						break;
					}
				}
			} else {
				$check = '<div class="custom_checkbox">' .
					'<input type="checkbox" name="marked_list[]" disabled class="inp-cbx check" id="' . $leads->_id . '" style="display: none"  onchange="markedCheck(this.id)">' .
					'<label for="' . $leads->_id . '" class="cbx" style="cursor: auto;">' .
					'<span>' .
					'    <svg width="10px" height="8px" viewBox="0 0 12 10">' .
					'      <polyline points="1.5 6 4.5 9 10.5 1"></polyline>' .
					'    </svg>' .
					'</span>' .
					'    <span><i style="color: #f96617;font-size: 12px;" class="fa fa-exclamation-triangle" data-toggle="tooltip" title="Lead Not Completed" aria-hidden="true"></i></span>' .
					'</label>' .
					'</div>';
				$disable = true;
			}

			//$check='<input type="checkbox" class="check" id="'.$leads->_id.'">';
			if ($leads['referenceNumber'] == '') {
				$referenceNumber = '--';
			} else {
				$referenceNumber = '<a href="#" class="auto_modal table_link" dir="' . $leads->_id . '" onclick="view_lead(\'' . $leads->_id . '\');">

	<span data-toggle="tooltip" data-placement="bottom" title="View Dispatch Slip" data-container="body"  data-modal="view_lead"> ' . $leads['referenceNumber'] . ' </span>  ';
			}

			if (isset($leads->rejectstatus)) {
				$referenceNumber = $referenceNumber . '<i style="color: #f00; font-size: 14px;" class="fas fa-ban"  data-toggle="tooltip" title="' . $leads->rejectstatus . '"  aria-hidden="true"></i> </a>';
			} else if (isset($leads->schedulerejectstatus)) {
				$referenceNumber = $referenceNumber . '<i style="color: #f00; font-size: 14px;" class="fas fa-ban"  data-toggle="tooltip" title="' . $leads->schedulerejectstatus . '"  aria-hidden="true"></i> </a>';
			}

			//            if($disable==true)
			//            {
			//                $referenceNumber = $referenceNumber.'<i style="color:red" class="fa fa-exclamation-triangle" aria-hidden="true"></i>';
			//            }
			if (isset($leads->agent['name'])) {
				$agentname = ucwords(strtolower($leads->agent['name']));
				if (isset($leads->agent['empid'])) {
					if ($leads->agent['empid'] != "") {
						$agentid = $leads->agent['empid'];
						$agentvalue = $agentname . ' (' . $agentid . ')';
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
			$caseManager = ucwords(strtolower($leads['caseManager.name']));
			$email = $leads->contactEmail;
			$contact = $leads->contactNumber;
			$recipientName = ucwords(strtolower($leads['customer.recipientName']));
			$dispatchType = $leads['dispatchType.dispatchType'];
			$deliveryMode = $leads['deliveryMode.deliveryMode'];
			$code = $leads['customer.customerCode'] ?: '--';
			$customerName = ucwords(strtolower($leads['customer.name']));
			$created_at = $leads['created_at'];
			if (isset($leads->employee['name'])) {
				$assignname = ucwords(strtolower($leads->employee['name']));
				if (isset($leads->employee['empId'])) {
					if ($leads->employee['empId'] != "") {
						$assignid = $leads->employee['empId'];
						$assignvalue = $assignname . ' (' . $assignid . ')';
					} else {
						$assignvalue = $assignname;
					}
				} else {
					$assignvalue = $assignname;
				}
			} else {
				$assignvalue = '--';
			}
			if ($leads['dispatchStatus'] == '') {
				$status = '--';
			} else {
				$status = $leads['dispatchStatus'];
			}


			//			$leads->checkall = $check;
			$leads->customerCode = $code;
			$leads->referenceNumber = $referenceNumber;
			$leads->customerName = $customerName;
			$leads->recipientName = $recipientName;
			$leads->contactNo = $contact;
			$leads->email = $email;
			$leads->caseManager = $caseManager;
			$leads->agent = $agent;
			$leads->dispatchType = $dispatchType;
			$leads->deliveryMode = $deliveryMode ?: '--';
			$leads->status = $status;
			$leads->assign = $assignvalue;
			$leads->created = Carbon::parse($created_at)->format('d/m/Y');
			if (session('role') == 'Admin') {
				$delete_button = '<button class="btn export_btn waves-effect auto_modal delete_icon_btn" type="button" data-toggle="tooltip" data-placement="bottom" title="Delete" data-container="body"  data-modal="delete_popup" dir="' . $leads->_id . '" onclick="delete_pop(this);">
	<i class="material-icons">delete_outline</i>
	</button>';
				$leads->delete_button = $delete_button;
			} else {
				$leads->delete_button = "";
			}
		}
		if ($search) {
			$filtered_count = $search_count;
		} else {
			$filtered_count = $total_leads;
		}


		$data = array(
			'draw' => $draw,
			'recordsTotal' => $total_leads,
			'recordsFiltered' => $filtered_count,
			'data' => $final_leads,
		);

		return json_encode($data);
	}

	/**
	 * view single lead
	 */
	public function viewSingleLead(Request $request)
	{
		$leadDetails = LeadDetails::find($request->input('lead_id'));
		$documentSection = view('dispatch.includes_pages.view_single_lead', [
			'leadDetails' => $leadDetails
		])->render();
		return response()->json([
			'documentSection' => $documentSection
		]);
	}

	/**
	 * update status script
	 */
	public function UpdateStatus()
	{
		$LeadDetails = LeadDetails::where('active', 1)->where(function ($query) {
			$query->where('dispatchDetails.documentDetails.DocumentCurrentStatus', '6')
				->orWhere('dispatchDetails.documentDetails.DocumentCurrentStatus', '15');
		})->get();
		$leadid = [];
		$leadidTransferred = [];
		foreach ($LeadDetails as $lead) {
			$leadid[] = $lead->referenceNumber;
			$documents = $lead['dispatchDetails']['documentDetails'];
			foreach ($documents as $count => $reply) {
				if ($reply['DocumentCurrentStatus'] == '6') {
					$leadidTransferred[] = $lead->referenceNumber;
					DispatchController::saveDocumentStatus($lead->_id, $count, '7');
				}
				if ($reply['DocumentCurrentStatus'] == '15') {
					$leadidTransferred[] = $lead->referenceNumber;
					DispatchController::saveDocumentStatus($lead->_id, $count, '16');
				}
			}
			DispatchController::saveTabStatus($lead->_id);
			DispatchController::setDispatchStatus($lead->_id);
			date_default_timezone_set('Asia/Dubai');
			$comment_time = date('H:i:s');
			$comment_submit_object = new \stdClass();
			$comment_submit_object->comment = 'Completed by Admin' . ',' . 'Message' . ' : ' . ucfirst(ucwords('Script executed by admin'));
			$comment_submit_object->commentBy = 'Admin';
			$comment_submit_object->commentTime = $comment_time;
			$comment_submit_object->id = new ObjectID(Auth::id());
			$comment_submit_object->date = date('d/m/Y');
			$comment_submit_array[] = $comment_submit_object;
			$lead->push('comments', $comment_submit_array);
			$lead->save();
		}
		dd($leadid, $leadidTransferred);
	}

	/**
	 * delete status script
	 */
	public function DeleteStatus()
	{
		$LeadDetails = LeadDetails::where('active', 1)->where('comments.comment', 'Completed by Admin,Message : Script Executed By Admin')->get();
		foreach ($LeadDetails as $lead) {
			$comment_submit_array = [];
			$leadid[] = $lead->referenceNumber;
			foreach ($lead->comments as $count => $reply) {
				if ($reply['comment'] == 'Completed by Admin,Message : Script Executed By Admin') {
					LeadDetails::where('_id', new ObjectId($lead->_id))->pull('comments', ['comment' => 'Completed by Admin,Message : Script Executed By Admin']);
				}
			}
			date_default_timezone_set('Asia/Dubai');
			$comment_time = date('H:i:s');
			$comment_submit_object = new \stdClass();
			$comment_submit_object->comment = 'Completed by Admin' . ',' . 'Message' . ' : ' . ucfirst(ucwords('Script executed by admin'));
			$comment_submit_object->commentBy = 'Admin';
			$comment_submit_object->commentTime = $comment_time;
			$comment_submit_object->id = new ObjectID(Auth::id());
			$comment_submit_object->date = date('d/m/Y');
			$comment_submit_array[] = $comment_submit_object;
			$lead->push('comments', $comment_submit_array);
			$lead->save();
		}
		dd($leadid);
	}

	//get dispatch status
	public function getDispatchStatus(Request $request)
	{
		if ($request->input('q')) {
			$Allstatus = DispatchStatus::where('status', 'like', $request->input('q') . '%')->groupBy('status')->get();
			if (count($Allstatus) == 0) {
				$Allstatus = DispatchStatus::where('status', 'like', '%' . $request->input('q') . '%')->groupBy('status')->get();
			}
		} else {
			$Allstatus = DispatchStatus::take(10)->groupBy('status')->get();
		}
		foreach ($Allstatus as $status) {
			if ($status->status) {
				$status->text = $status->status;
				$status->name = $status->status;
			} else {
				$status->text = $status->status;
			}
			$status->id = $status->status;
		}
		$data = array(
			'total_count' => count($Allstatus),
			'incomplete_results' => false,
			'items' => $Allstatus,
		);
		return json_encode($data);
	}

	/**
	 * get reference number script
	 */
	public function getRefNumber()
	{
		$LeadDetails = LeadDetails::where('active', 1)->whereNotNull('deliveryStatus')->get();
		$refNumber1 = [];
		foreach ($LeadDetails as $lead) {
			if (isset($lead->deliveryStatus)) {
				foreach ($lead->deliveryStatus as $status) {
					if ((isset($status['upload_sign'])     && $status['upload_sign'] != ""   && isset($status['status']) && $status['status'] == "Delivered")
						|| (isset($status['upload_sign'])     && $status['upload_sign'] != ""   && !isset($status['status']))
					) {
						$refNumber1[] = $lead->referenceNumber;
					}
				}
			}
		}
		dd(array_unique($refNumber1));
	}

	/**
	 * update name and remove space 
	 */
	public function testChangeName()
	{
		$LeadDetails = LeadDetails::where('active', 1)->select('customer', 'agent', 'caseManager');
		$result = [];
		$LeadDetails->chunk(500, function ($properties) use (&$result) {
			foreach ($properties as $property) {
				$result[] = $property;
			}
		});

		// $leadList=LeadDetails::where('active',1)->taget();
		foreach ($result as $lead) {
			$custName = ltrim(ucwords(strtolower($lead->customer['name'])));
			$agentName = ltrim(ucwords(strtolower($lead->agent['name'])));
			$caseName = ltrim(ucwords(strtolower($lead->caseManager['name'])));
			LeadDetails::where('_id', new ObjectId($lead->_id))->update(array('customer.name' => $custName, 'agent.name' => $agentName, 'caseManager.name' => $caseName));
		}
		echo "success";
	}

	/**
	 * update name and remove space customer 
	 */
	public function testChangeNameCustomers()
	{
		$customer = Customer::where('status', (int) 1)->select('fullName', 'mainGroup.name', 'agent.name');
		$result = [];
		$customer->chunk(500, function ($properties) use (&$result) {
			foreach ($properties as $property) {
				$result[] = $property;
			}
		});

		// $leadList=LeadDetails::where('active',1)->taget();
		foreach ($result as $cust) {
			$custName = ltrim(ucwords(strtolower($cust->fullName)));
			if (isset($cust->mainGroup)) {
				$main = ltrim(ucwords(strtolower($cust->mainGroup['name'])));
				Customer::where('_id', new ObjectId($cust->_id))->update(array('mainGroup.name' => $main));
			}
			if (isset($cust->agent)) {
				$agent = ltrim(ucwords(strtolower($cust->agent['name'])));
				Customer::where('_id', new ObjectId($cust->_id))->update(array('agent.name' => $agent));
			}
			Customer::where('_id', new ObjectId($cust->_id))->update(array('fullName' => $custName));
		}
		echo "success";
	}

	/**
	 * update name and remove space recipients
	 */
	public function testChangeNameRec()
	{
		$customer = RecipientDetails::where('status', (int) 1)->select('fullName', 'mainGroup.name', 'agent.name');
		$result = [];
		$customer->chunk(500, function ($properties) use (&$result) {
			foreach ($properties as $property) {
				$result[] = $property;
			}
		});

		// $leadList=LeadDetails::where('active',1)->taget();
		foreach ($result as $cust) {
			$custName = ltrim(ucwords(strtolower($cust->fullName)));
			if (isset($cust->mainGroup)) {
				$main = ltrim(ucwords(strtolower($cust->mainGroup['name'])));
				RecipientDetails::where('_id', new ObjectId($cust->_id))->update(array('mainGroup.name' => $main));
			}
			if (isset($cust->agent)) {
				$agent = ltrim(ucwords(strtolower($cust->agent['name'])));
				RecipientDetails::where('_id', new ObjectId($cust->_id))->update(array('agent.name' => $agent));
			}
			RecipientDetails::where('_id', new ObjectId($cust->_id))->update(array('fullName' => $custName));
		}
		echo "success";
	}

	/**
	 * update name and remove space pipelines
	 */
	public function ChangePipeline()
	{
		$customer = PipelineItems::where('pipelineStatus', "true")->select('customer.name', 'agent.name');
		$result = [];
		$customer->chunk(500, function ($properties) use (&$result) {
			foreach ($properties as $property) {
				$result[] = $property;
			}
		});

		// $leadList=LeadDetails::where('active',1)->taget();
		foreach ($result as $cust) {
			$custName = ltrim(ucwords(strtolower($cust->customer['name'])));
			if (isset($cust->agent)) {
				$agent = ltrim(ucwords(strtolower($cust->agent['name'])));
				PipelineItems::where('_id', new ObjectId($cust->_id))->update(array('agent.name' => $agent));
			}
			PipelineItems::where('_id', new ObjectId($cust->_id))->update(array('customer.name' => $custName));
		}
		echo "success";
	}
}

