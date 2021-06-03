<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use MongoDB\BSON\ObjectId;
use Illuminate\Support\Facades\Auth;
use App\Customer;
use App\Emails;
use App\CustomerDocuments;
use App\SharedDocuments;

class LoginController extends Controller
{
    /*
     * Controller Function for load login page*/

    public function index()
    {
        if (!Auth::check()) {
            return view('login')->with('error');
        } elseif (Auth::check()) {
            return redirect('/dash');
        }
    }

    /**
     * login dispatch module.
     */
    public function loginDispatch()
    {
        session(['dispatch' => 'Dispatcher']);
        // $role = Auth::user()->roleDetail('name');
        // if ($role == 'UnderWriter' || session('role') == 'Dispatcher') {
        //     return redirect('dispatch/dashboard');
        // }

        return redirect('dispatch/dashboard');
    }

    /*
     * Controller Function for authentication*/

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
        $email = $request->input('email');
        $password = $request->input('password');
        $email = trim($email);
        $password = trim($password);
        if (Auth::attempt(['email' => $email, 'password' => $password, 'isActive' => 1])) {
            $role = Auth::user()->roleDetail('name');
            if ($role['name'] == 'Coordinator') {
                $user = User::find(Auth::user()->_id);
                $assigned_agent = new ObjectID($user['assigned_agent']['id']);
            } else {
                $assigned_agent = '';
            }
            if (isset(Auth::user()->permission['permissionCheck'])) {
                $assigned_permissions = Auth::user()->permission['permissionCheck'];
            } else {
                $assigned_permissions = [];
            }

            session([
                'role' => $role['name'],
                'user_name' => Auth::user()->name,
                'permissions' => $role['permissions'],
                'abbreviation' => $role['abbreviation'],
                'assigned_agent' => $assigned_agent,
                'assigned_permissions' => $assigned_permissions,
            ]);
            if ($role['name'] == 'Admin') {
                return redirect('/dash');
            } elseif ($role['name'] == 'Insurer') {
                return redirect('insurer/dashboard');
            } elseif ($role['name'] == 'Supervisor') {
                $employees = User::select('employees')->find(Auth::user()->_id);
                $employees = $employees->employees;
                // $emps= $this->collectSubordinate($employees);
                // $emps= array_unique($emps);
                // $emps= array_values($emps);
                if (isset($employees) && !empty($employees)) {
                    $empids = $this->collectEmployees($employees);
                    $empids = array_values(array_unique($empids));
                    session(['employees' => $empids]);
                } else {
                    session(['employees' => []]);
                }
            } elseif ($role['name'] != 'Accountant') {
                session(['dispatch' => 'Dispatcher']);
                return redirect('/dash');
            } else {
                Session::flash('error', 'Invalid login');
                return back()->withInput()->with('error', 'Invalid login!');
            }
            return redirect('/dash');
        } elseif ($customer = Customer::where('userName', $email)->where('passCode', $password)->first()) {
            session([
                'customer.additional_role' => 'Customer', 'customer.user_name' => $email,
                'customer.customer_id' => $customer->_id,
                'customer.name' => $customer->fullName
            ]);
            $docs = SharedDocuments::where('customerId', (string) $customer->_id)
                ->where('status', 1)->where('deleted', 0)
                ->orderBy('uploadedUtcDate', 'desc')->get();

            return view('document_management.customer_document.customer_document_view')
                ->with(compact('docs'));
        } else {
            Session::flash('error', 'Invalid login');

            return back()->withInput()->with('error', 'Invalid login!');
        }
    }

    /* Function to traverse all subordinates of the supervisor
    including all levels of supervisors and employees - type 1*/
    /*       Recursive        */
    protected function collectSubordinate($employees)
    {
        $employeeList = [];
        foreach ($employees as $emp) {
            $result = User::select('role', 'employees')->find(new ObjectId($emp['id']));
            if ($result && $result->role != 'SV') {
                $employeeList = array_merge($employeeList, [new ObjectId($result->_id)]);
            } else {
                $employeeList = array_merge($employeeList, [new ObjectId($result->_id)]);
                $sub = $this->collectSubordinate($result->employees);
                $employeeList = array_merge($employeeList, $sub);
            }
        }
        return $employeeList;
    }

    /* Function to traverse all subordinates of the supervisor
    including all levels of supervisors and employees - type 2*/
    /*       Recursive        */
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

    // protected function collectEmployees($employees)
    // {
    //     $employeeList=[];
    //     $supervisorList=[];
    //     foreach ($employees as $emp) {
    //         $ids[]=new ObjectId($emp['id']);
    //     }
    //     $users=User::select('_id', 'role', 'employees')->whereIn('_id', $ids)->get();
    //     dd($users);
    //     foreach ($employees as $emp) {
    //         $result=User::select('_id', 'role', 'employees')->find($emp['id']);
    //         if ($result && $result->role!= 'SV') {
    //             $employeeList=array_merge($employeeList, [new ObjectId($result->_id)]);
    //         } else {
    //             $employeeList=array_merge($employeeList, [new ObjectId($result->_id)]);
    //             if (in_array(new ObjectId($result->_id), $employeeList)) {
    //                 continue;
    //             }
    //             $supervisorList=array_merge($supervisorList, [$result]);
    //         }
    //     }
    //     foreach ($supervisorList as $supervisor) {
    //         $employ=$this->collectEmployees($supervisor->employees);
    //         $employeeList=array_merge($employeeList, $employ);
    //     }
    //     return $employeeList;
    // }


    /*Function For Logout The Auth*/

    public function logout()
    {
        Auth::logout();
        Session::flush();

        return redirect('/');
    }

    /**
     * login.
     */
    public function dispatchLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
        $email = $request->input('email');
        $password = $request->input('password');
        if (Auth::attempt(['email' => $email, 'password' => $password, 'isActive' => 1])) {
            $role = Auth::user()->roleDetail('name');
            session(['role' => $role]);
            if ($role == 'UnderWriter' || session('role') == 'Dispatcher') {
                return redirect('dispatch/dashboard');
            } else {
                echo 'No Login Available';
            }
        } else {
            Session::flash('error', 'Invalid login');

            return back()->withInput()->with('error', 'Invalid login!');
        }
    }
}
