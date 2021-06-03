<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Jobs\saveUserMail;
use MongoDB\BSON\ObjectID;
use Illuminate\Support\Facades\DB;
use App\Emails;
use App\Enquiries;
use App\LeadDetails;
use App\WorkType;
use App\WorkTypeData;
use Illuminate\Support\Facades\Auth;

class UserManagementController extends Controller
{
    /**
     *  user management dashboard
     * */
    public function dashboard(Request $request)
    {
        $request->session()->forget('dispatch');
        session(['dispatch' => 'User']);
        return view('user_management.dashboard');
    }

    /**
     *  getting employees list for supervisor roled user creation
     * */
    public function selectEmployees(Request $request)
    {
        $key= $request->q;
        $edit=$request->input('edit');
        $edit=$edit?new ObjectId($edit):"";
        $supers=[$edit];
        if ($edit) {
            $edit= [$edit];
            $supers= $this->collectSupervisors($edit, $supers);
        }
        $employees= User:: where('isActive', 1)
        ->whereIn('role', ['EM', 'SV'])
        ->whereNotIn('_id', $supers);
        if ($key) {
            $employees->where(function ($query) use ($key) {
                $query->where('name', 'like', $key . '%')
                    ->orWhere('empID', 'like', $key . '%');
            });
            
            $count= $employees->count();
            if (! $count) {
                $employees= User:: where('isActive', 1)
                                    ->whereIn('role', ['EM', 'SV'])
                                    ->whereNotIn('_id', $supers);
                $employees->where(function ($query) use ($key) {
                    $query->where('name', 'like', '%' . $key . '%')
                        ->orWhere('empID', 'like', '%' . $key . '%');
                });
                // $employees->where('name', 'like', '%'.$key.'%');
            }
        }
        $employees = $employees->orderBy('name')->take(10)->get();
        foreach ($employees as $key => $item) {
            $idname = $item->name . " (" . (@$item->empID ?: 'No ID available') . ")";
            $item->text = $idname;
            $item->id = $item->_id;
            $item->name = $idname;
        }
        $data = array(
            'total_count' => count($employees),
            'incomplete_results' => false,
            'items' => $employees
        );
        return json_encode($data);
    }


    /* find supervisors */
    protected function collectSupervisors($user = [], $supers = [])
    {
        $heads = User::select('_id')
            ->where('role', 'SV')
            ->whereIn('employees.id', $user)->get();
        $user=[];
        
        if (! $heads->isEmpty()) {
            foreach ($heads as $head) {
                $objId=new ObjectId($head->_id);
                if (!in_array($objId, $supers)) {
                    $user[] = $objId;
                    $supers[] = $objId;
                }
            }
            $supers = $this->collectSupervisors($user, $supers);
        }
        return $supers;
    }

    /**
     * view user page
     */
    public function viewUser(Request $request)
    {
        $users = User::get();
        $filter_data = $request->input();
        return view('user_management.users')->with(compact('users', 'filter_data'));
    }
    /**
     * get user
     */
    public function getUser(Request $request)
    {
        //        DB::enableQueryLog();
        $update_array = [];
        //        $data = array(
        //            'createdAt' => date('Y-m-d H:i:s'),
        //            'updatedAt' => date('Y-m-d H:i:s')
        //        );
        //        User::where('createdAt','<>',"")->update($data, ['upsert' => true]);die;

        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $filter = $request->input('search');
        $filter_data_en = $request->input('filterData');
        $filterData = json_decode($filter_data_en);
        $sort = $request->input('field');
        //        $searchField = (isset($filter_data['search']))? $filter_data['search'] :"";
        $search = (isset($filter['value'])) ? $filter['value'] : false;
        session()->put('filter', $filter_data_en);
        session()->put('sort', $sort);
        $users = User::where('role', '!=', 'IN');
        if (!empty($filterData)) {
            foreach ($filterData as $key => $value) {
                $val_array = [];
                foreach ($value as $val) {
                    if ($val == "Nil") {
                        $val_array[] = (string) 0;
                    }
                    if ($val != '0' && $val != 'Nil') {
                        $val_array[] = new ObjectID($val);
                    }
                }

                if (count($val_array) > 0) {
                    $users = $users->whereIn($key, $val_array);
                }
            }
        }

        if ($search) {
            $users = $users->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('empID', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('role_name', 'like', '%' . $search . '%');
            });
            session()->put('search', $search);
        }
        if ($search == "") {
            session()->put('search', "");
        }

        $searchField = $request->get('searchField');
        if ($searchField != "") {
            $users = $users->where(function ($query) use ($searchField) {
                $query->where('name', 'like', '%' . $searchField . '%')
                    ->orWhere('empID', 'like', '%' . $searchField . '%')
                    ->orWhere('email', 'like', '%' . $searchField . '%')
                    ->orWhere('role_name', 'like', '%' . $searchField . '%');
            });
        }


        $total_users = $users->count(); // get your total no of data;
        $members_query = $users;
        $search_count = $members_query->count();
        $users->skip((int) $start)->take((int) $length);
        $final_users = $users->orderBy('createdAt', 'DESC')->get();


        foreach ($final_users as $user) {
            $name = '<a href="' . URL::to('user/users-show/' . $user->_id) . '" class="p">' . ucwords(strtolower($user->name)) . '</a>';
            //            $role_name = Role::where('abbreviation', $user->role)->first();
            $edit_button = '<a class="btn btn-sm btn-success" href="' . URL::to('user/edit-user/' . $user->_id) . '">Edit</a>';
            if ($user->isActive == 1) {
                $delete_button = '<button class="btn export_btn waves-effect auto_modal delete_icon_btn" data-toggle="tooltip" data-placement="bottom" title="Deactivate" data-container="body"  data-modal="delete_popup" dir="' . $user->_id . '" onclick="delete_pop(\'' . $user->_id . '\');">
				<i class="material-icons">delete_outline</i>
				</button>';
            } else {
                $delete_button = '<button class="btn export_btn waves-effect auto_modal delete_icon_btn" data-toggle="tooltip" data-placement="bottom" title="Activate" data-container="body"  data-modal="active_popup" dir="' . $user->_id . '" onclick="active_pop(\'' . $user->_id . '\');">
				<i style="color:green" class="material-icons">save</i>
				</button>';
            }

            $update_password = '<button class="btn btn-sm btn-success auto_modal" data-toggle="tooltip" data-placement="bottom" data-container="body"  data-modal="update_password_popup" dir="' . $user->_id . '" onclick="update_password_pop(\'' . $user->_id . '\');">
            update password
            </button>';
            //            $user->role_name = @$user->role_name?:'--';
            $user->edit_button = $edit_button;
            $user->delete_button = $delete_button;
            $user->update_password = $update_password;
            $user->fullName = $name;
            if (isset($user->empID)) {
                $empid = $user->empID;
            } else {
                $empid = '--';
            }
            $user->empID = $empid;
            if (isset($user->email)) {
                $email = $user->email;
            } else {
                $email = '--';
            }
            $user->email = $email;
        }
        if ($search) {
            $filtered_count = $search_count;
        } else {
            $filtered_count = $total_users;
        }


        $data = array(
            'draw' => $draw,
            'recordsTotal' => $total_users,
            'recordsFiltered' => $filtered_count,
            'data' => $final_users,
        );
        return json_encode($data);
    }

    /**
     * function for creating user from dispatch module
     */
    public function createUser()
    {
        $roles = Role::orderBy('name')->get();
        $agents = User::where('isActive', 1)->Where('role', 'AG')->orderBy('name')
            ->get();
        return view('user_management.create_user', ['roles' => $roles, 'agents' => $agents]);
    }

    /**
     * save user details
     */
    public function saveUser(Request $request)
    {
        $user_id = $request->input('user_id');
        $password = $request->input('password');
        $email = $request->input('email');
        if ($user_id) {
            $email_exist = User::where('email', $email)->where('_id', '!=', new ObjectID($user_id))->first();
            $uniquecode_exist = User::where('uniqueCode', $request->input('unique_code'))
                ->where('_id', '!=', new ObjectID($user_id))->first();
            if ($email_exist) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email Id already exist'
                ]);
            } elseif ($uniquecode_exist && $uniquecode_exist->uniqueCode != '') {
                return response()->json([
                    'success' => false,
                    'message' => 'Unique code already exist'
                ]);
            } else {
                $user_details = User::find($user_id);
                $user_details->role = $request->input('role');
                $user_details->firstName = ucwords(strtolower($request->input('first_name')));
                $user_details->lastName = ucwords(strtolower($request->input('last_name')));
                $role = Role::where('abbreviation', $request->input('role'))->first();
                $user_details->role_name = $role->name;
                $user_details->email = $request->input('email');
                $user_details->empID = $request->input('employee_id');
                $user_details->department = ucwords(strtolower($request->input('department')));
                $user_details->position = ucwords(strtolower($request->input('position')));
                $user_details->nameOfSupervisor = ucwords(strtolower($request->input('supervisor_name')));
                $user_details->name = ucwords(strtolower($request->input('first_name'))) . ' ' . ucwords(strtolower($request->input('last_name')));
                $user_details->uniqueCode = $request->input('unique_code');
                User::where('_id', $user_id)->unset('permission');
                $permissionObject = new \stdClass();
                $permissionObject->permissionCheck = $request->input('permissionCheck');
                $user_details->permission = $permissionObject;
                if ($request->input('role') == 'CO') {
                    $agentObj = new \stdClass();
                    $agentObj->id = new ObjectID($request->input('agent'));
                    $userDetals = User::find($request->input('agent'));
                    if ($userDetals->empID != '') {
                        $agentName = $userDetals->name . ' ( ' . $userDetals->empID . ')';
                    } else {
                        $agentName = $userDetals->name;
                    }
                    $agentObj->agentName = $agentName;
                    $user_details->assigned_agent = $agentObj;
                } else {
                    $user_details->assigned_agent = '';
                }
                if ($request->input('role') == 'SV') {
                    $employees = $request->input('employee_select');
                    $employees = $employees ?: [];
                    $emp = [];
                    foreach ($employees as $employee) {
                        $em = User::find($employee);
                        $empObj = new \stdClass();
                        $empObj->id = new ObjectId($em->_id);
                        $empObj->empName = $em->name;
                        $emp[] = $empObj;
                    }
                    $user_details->employees = $emp;
                } else {
                    $user_details->employees = "";
                }
                $user_details->save();

                //updating th e emails collection..........

                Emails::where('assaignedTo.agentId', new ObjectID($user_id))
                    ->update(['assaignedTo.agentName', $user_details->name]);

                Enquiries::where('assaignedTo.agentId', new ObjectID($user_id))
                    ->update(['assaignedTo.agentName', $user_details->name]);
                LeadDetails::where('agent.id', new ObjectID($user_id))
                    ->update(['agent.name', $user_details->name,
                    'dispatchDetails.agent',$user_details->name]);

                //updating th e emails collection..........end

                Session::flash('status', 'User updated successfully');

                return response()->json([
                    'success' => true,
                ]);
            }
        } else {
            $email_exist = User::where('email', $email)->first();
            $uniquecode_exist = User::where('uniqueCode', $request->input('unique_code'))->first();
            if ($email_exist) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email Id already exist'
                ]);
            } elseif ($uniquecode_exist && $uniquecode_exist->uniqueCode != '') {
                return response()->json([
                    'success' => false,
                    'message' => 'Unique code already exist'
                ]);
            } else {
                $user_details = new User();
                $user_details->role = $request->input('role');
                $role = Role::where('abbreviation', $request->input('role'))->first();
                $user_details->firstName = ucwords(strtolower($request->input('first_name')));
                $user_details->lastName = ucwords(strtolower($request->input('last_name')));
                $user_details->email = $request->input('email');
                $user_details->password = bcrypt($request->input('password'));
                $user_details->empID = $request->input('employee_id');

                $user_details->department = ucwords(strtolower($request->input('department')));
                $user_details->position = ucwords(strtolower($request->input('position')));
                $user_details->nameOfSupervisor = ucwords(strtolower($request->input('supervisor_name')));
                $user_details->name = ucwords(strtolower($request->input('first_name'))) . ' ' . ucwords(strtolower($request->input('last_name')));
                $user_details->role_name = $role->name;
                if ($request->input('role') == 'CO') {
                    $agentObj = new \stdClass();
                    $agentObj->id = new ObjectID($request->input('agent'));
                    $userDetals = User::find($request->input('agent'));
                    if ($userDetals->empID != '') {
                        $agentName = $userDetals->name . ' ( ' . $userDetals->empID . ')';
                    } else {
                        $agentName = $userDetals->name;
                    }
                    $agentObj->agentName = $agentName;
                    $user_details->assigned_agent = $agentObj;
                } else {
                    $user_details->assigned_agent = '';
                }
                if ($request->input('role') == 'SV') {
                    $employees = $request->input('employee_select');
                    $employees = $employees ?: [];
                    $emp = [];
                    foreach ($employees as $employee) {
                        $em = User::find($employee);
                        $empObj = new \stdClass();
                        $empObj->id = new ObjectId($em->_id);
                        $empObj->empName = $em->name;
                        $emp[] = $empObj;
                    }
                    $user_details->employees = $emp;
                } else {
                    $user_details->employees = "";
                }
                $permissionObject = new \stdClass();
                $permissionObject->permissionCheck = $request->input('permissionCheck');
                $date = Carbon::now();
                $unique_code = mt_rand(0, 9999) . substr($date->getTimestamp(), 0, 6);
                $user_details->permission = $permissionObject;
                $user_details->uniqueCode = $request->input('unique_code');
                $user_details->isActive = (int) 1;
                $user_details->save();
                $loginLink = url('/dash');
                saveUserMail::dispatch($user_details->email, $user_details, $password, $role->name, $loginLink);
                Session::flash('status', 'User created successfully');

                return response()->json([
                    'success' => true,
                ]);
            }
        }
    }
    /**
     * function for deleting user
     */
    public function deleteUser($user_id)
    {
        $user_det = User::find($user_id);
        if ($user_det) {
            $user_det->isActive = 0;
            $user_det->save();
            Session::flash('status', 'User deactivated successfully.');
            return "success";
        }
    }
    /**
     * function for activate  user from dispatch module
     */
    public function activateUser($user_id)
    {
        $user_det = User::find($user_id);
        if ($user_det) {
            $user_det->isActive = 1;
            $user_det->save();
            Session::flash('status', 'User activated successfully.');
            return "success";
        }
    }

    /**
     * function for update password of user from dispatch module
     */
    public function updatePassword(Request $request)
    {
        $user_id = $request->input('user_id');
        $user_det = User::find($user_id);
        if ($user_det) {
            $user_det->password = bcrypt($request->input('new_password'));
            $user_det->save();
            if (isset($user_det->email) && !empty($user_det->email)) {
                Session::flash('status', 'Password updated for ' . $user_det->email);
            } else {
                Session::flash('status', 'Password updated for ' . $user_det->name . '(' . $user_det->empID . ')');
            }
            return "success";
        }
    }
    /**
     * function for editing user from dispatch module
     */
    public function editUser($user_id)
    {
        $roles = Role::orderBy('name')->get();
        $user = User::find($user_id);
        $agents = User::where('isActive', 1)->Where('role', 'AG')->orderBy('name')
            ->get();
        return view('user_management.create_user', ['roles' => $roles, 'user' => $user, 'agents' => $agents]);
    }
    /**
     * show user
     */
    public function show($user)
    {
        $user = User::find($user);
        $role_name = Role::where('abbreviation', $user->role)->first();
        $role = @$role_name->name;
        if ($user) {
            return view('user_management.user_details')->with(compact('user', 'role'));
        } else {
            return view('error');
        }
    }
    /**
     * update permission page
     */
    public function updatePermission()
    {
        $users = User::get();
        foreach ($users as $user) {
            if ($user['role'] == 'AD') {
                $permissionArray = [
                    '0' => 'CRM',
                    '1' => 'Dispatch',
                    '2' => 'User Management',
                    '3' => 'Document Management',
                    '4' => 'Enquiry Management'
                ];
                $permissionObject = new \stdClass();
                $permissionObject->permissionCheck = $permissionArray;
                $user->permission = $permissionObject;
                $user->save();
            } elseif ($user['role'] == 'AG' || $user['role'] == 'CR' || $user['role'] == 'MS' || $user['role'] == 'CO' || $user['role'] == 'RP') {
                $permissionArray = [
                    '0' => 'Dispatch'
                ];
                $permissionObject = new \stdClass();
                $permissionObject->permissionCheck = $permissionArray;
                $user->permission = $permissionObject;
                $user->save();
            } elseif ($user['role'] == 'EM') {
                $permissionArray = [
                    '0' => 'Dispatch'
                    // '1'=>'Document Management',
                    // '2'=>'Enquiry Management',
                ];
                $permissionObject = new \stdClass();
                $permissionObject->permissionCheck = $permissionArray;
                $user->permission = $permissionObject;
                $user->save();
            }
        }
        return 'success';
    }
    /**
     * Function for fill permission popup
    */
    public function getChatUsers(Request $request)
    {
        $workTypeDataId = $request->get('workTypeDataId');
        $worktypeDetails = WorkTypeData::find($workTypeDataId);
        $creator = $worktypeDetails->createdBy['id'];
        $permittedUsers = $worktypeDetails->commentPermission;
        $users = User::where('isActive',1)->where(function ($q) {
            $q->where('role','AD')->orWhere('role','EM')->orWhere('role','AG');
        })->get();
        return view('popup.chat_permission')->with(compact('users', 'creator', 'permittedUsers'));
    }
     /**
     * save prmission for comments
     */
    public function saveChatPermission(Request $request)
    {
        try {
            $workTypeDataId = $request->input('worktype_id');
            $pipeline=WorkTypeData::find($workTypeDataId);
            if(isset($pipeline->commentPermission))
            {
                DB::collection('workTypeData')->where('_id', new ObjectId($request->input('worktype_id')))->unset(['commentPermission']);
            }
            $users = $request->input('users');
            $object_array = [];
            if($users) {
                foreach ($users as $user) {
                    $object_array[] = new ObjectId($user);
                }
            }
            $object_array[] = new ObjectId(Auth::id());
            workTypeData::where('_id', $workTypeDataId)->update(['commentPermission' => $object_array]);
            Session::flash('success', "Permission Give Successfully");
            return 'success';
        }
        catch(\Exception $e)
        {
            return 'failed';
        }
    }
    /**
     * Function for get comments using AJAX
     */
    public function getChatComment(Request $request)
    {
        $seen = new ObjectId(Auth::id());
        $id = $request->get('id');
        $pipeData = WorkTypeData::where('_id',$id)->first();
        $comment_seen = WorkTypeData::where('_id',$id)->where('commentSeen','=',new ObjectId(Auth::id()))->first();
        if(!$comment_seen)
        {
            WorkTypeData::where('_id',$id)->push(['commentSeen'=>$seen]);
        }
        $comments = $pipeData->comments;
        return json_encode($comments);
    }

    /**
     * Function for add new comments in E questionnaire
     */
    public function addChatComment(Request $request)
    {
        try {
            $id = $request->get('id');
            $workData = WorkTypeData::where('_id',$id)->get()->first();
            $seen = [];
            $seen[] = new ObjectId(Auth::id());
            if ($workData->comments) {
                $comment_object = new \stdClass();
                $comment_object->comment = $request->get('comment');
                $comment_object->commentBy = Auth::user()->name;
                $role= Auth::user()->roleDetail('name');
                $comment_object->userType =  $role['name'];
                $comment_object->id = new ObjectId(Auth::id());
                $comment_object->date = $request->get('date');
                $comment_array[] = $comment_object;
                $workData->push('comments',$comment_array);
                $updatedBy_obj = new \stdClass();
                $updatedBy_obj->id = new ObjectID(Auth::id());
                $updatedBy_obj->name = Auth::user()->name;
                $updatedBy_obj->date = date('d/m/Y');
                $updatedBy_obj->action = "Commented";
                $updatedBy[] = $updatedBy_obj;
                $workData->push('updatedBy',$updatedBy);
                $workData->save();
                WorkTypeData::where('_id',$id)->update(['commentSeen'=>$seen]);
            } else {
                $comment_object = new \stdClass();
                $comment_object->comment = $request->get('comment');
                $comment_object->commentBy = Auth::user()->name;
	            $role= Auth::user()->roleDetail('name');
	            $comment_object->userType =  $role['name'];
                $comment_object->id = new ObjectID(Auth::id());
                $comment_object->date = $request->get('date');
                $comment_array[] = $comment_object;
                $workData->comments = $comment_array;
                $workData->commentSeen = $seen;
                $updatedBy_obj = new \stdClass();
                $updatedBy_obj->id = new ObjectID(Auth::id());
                $updatedBy_obj->name = Auth::user()->name;
                $updatedBy_obj->date = date('d/m/Y');
                $updatedBy_obj->action = "Commented";
                $updatedBy[] = $updatedBy_obj;
                $workData->push('updatedBy',$updatedBy);
                $workData->save();
            }
            return "success";
        }catch (\Exception $exception){
            return "failure";
        }
    }
}
