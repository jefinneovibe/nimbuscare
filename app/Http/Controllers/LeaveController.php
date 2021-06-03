<?php

namespace App\Http\Controllers;

use App\CaseManager;
use App\LeavesDetails;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use MongoDB\BSON\ObjectID;

class LeaveController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth.underwriter');
    }

	/**
	 * apply leave page
	 */
	public function addLeave()
	{
		$case_managers = User::where('isActive',1)->where('role', 'EM')->get();
		return view('leaves.apply_leave')->with(compact('case_managers'));
	}
	
	/**
	 * save leave details
	 */
	public function saveLeave(Request $request)
	{
		
	    $leave_details=new LeavesDetails();
		$leave_details->leaveFrom=$request->input('leaveFrom');
		$leave_details->leaveTo=$request->input('leaveTo');
		$case_managers = User::find($request->input('caseManager'));
		$caseManager_object=new \stdClass();
		$caseManager_object->id=new ObjectID($request->input('caseManager'));
		$caseManager_object->name=$case_managers->name;
		$leave_details->userDetails=$caseManager_object;
		$leave_details->save();
		Session::flash('msg', 'Leave details added successfully.');
		return response()->json(['success' => true]);
		
		
//		$from= Carbon::createFromFormat('d/m/Y', $request->input('leaveFrom'))->timestamp;
//		dd(date('d/m/Y',$from));
//		$leave_details->leaveFrom= Carbon::createFromFormat('d/m/Y', $request->input('leaveFrom'))->timestamp;
//		$leave_details->leaveTo=Carbon::createFromFormat('d/m/Y', $request->input('leaveTo'))->timestamp;
	}
	
	/***
	 * leave listing page
	 */
	public function leaveList()
	{
		$current_date=date("d/m/Y");
		$leave_details=LeavesDetails::orderBy('leaveTo','asc')->get();
		return view('leaves.leave_list')->with(compact('leave_details','current_date'));
	}
}
