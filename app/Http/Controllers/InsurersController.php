<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Insurer;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use MongoDB\BSON\ObjectID;
use Illuminate\Support\Facades\Validator;

class InsurersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.customer');
    }
    /**
     * insurer create page
     */
    public function create()
    {                    
        return view('insurers.create');            
    }
      /**
     * save customer details
     */
    public function store(Request $request)
    {   
        if ($request->input('insurer_id')) {
            $insurer_id=$request->input('insurer_id');            
            $insurer_details=Insurer::find($insurer_id);  
            $name = $request->input('name');  
            $name=str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($name))));
            $email = $request->input('email');            
            if($request->input('addlogin')){
                $insurer_details->login_created=true;
                $Password=$request->input('Password');
                $user=new User();
                $this->adduser($user,$name,$insurer_id,$email,$Password);
                $insurer_details->name=$user->name;
                $insurer_details->email=$user->email;
                $insurer_details->save(); 
                Session::flash('status', 'Login created successfully.');
                return "success"; 
            } else{
                $user= User::where('insurer.id',new ObjectID($insurer_id))->first();                
                if($request->input('Password')){
                    $Password=$request->input('Password');  
                }else{
                    $Password="";
                }
                if($user){
                    $this->adduser($user,$name,$insurer_id,$email,$Password);
                }
                 // $insurerdet=$user->insurer["id"];
                $insurer_details->name=$name;
                $insurer_details->email=$email;
                $insurer_details->save();    
                    Session::flash('status', 'Insurer updated successfully.');
                    return "success"; 
            }
        }
        else{
            $insurer=new Insurer();
            // $insurer->name = $request->input('name'); 
            $name = $request->input('name'); 
            $email = $request->input('email');
            $insurer->name =str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($name))));  
            $insurer->isActive=1; 
            $insurer->email = $request->input('email'); 
            $insurer->login_created=true;
            $insurer_details=$insurer->save();
            $insurerDetails=new Insurer();
            if($insurer_details){
                $insurer_details=Insurer::where('name',$insurer->name)->first();          
                $insurerDetails->id=new ObjectID($insurer_details->_id);      
                $insurerDetails->name=$insurer_details->name;             
            } 
            $Password=$request->input('Password');
            $insurer_id=$insurerDetails->id;
            $user=new User();
            $this->adduser($user,$name,$insurer_id,$email,$Password);
              
                Session::flash('status', 'Insurer added successfully.');
                return "success"; 
        }              
       
    }


      /**
     * save insurer details in user table details
     */
    public function adduser(User $user,$insurer_name,$insurer_id,$email,$Password)
    {  
            $user->insurer=["id"=>new ObjectID($insurer_id),"name"=>$insurer_name];
           // $user->customerType = "Insurer";
            $user->name =  $insurer_name; 
            // $user->name = $request->input('name');       
            $user->email = $email;  
            if($Password!="") {
                $user->password =bcrypt($Password);
            }          
            $user->isActive=1;  
            $user->role="IN";  
            $user->role_name="Insurer"; 
            $user->userType= "insurer";
            $user->firstName="";
            $user->lastName=""; 
            $user->userData="";
            $user->dob="";
            $user->phone="";
            $user->mobileNumber="";
            $user->updatedBy="";   
            $user->created_by = Auth::user()->name;                      
            $user->save();
    }
       /**
     * reset insurer password details
     */
    public function pstore(Request $request)
    {            
        if ($request->input('insurer_id')) {
            $insurer_id=$request->input('insurer_id');
            // $user= User::find($insurer_id);
            $user= User::where('insurer.id',new ObjectID($insurer_id))->first();      
           // $oldPassword = $request->input('oldPassword');       
            $newPassword = $request->input('newPassword'); 
           //if(Hash::check($oldPassword, $user->password)){
                $user->password=bcrypt($newPassword);
                $user->updatedBy = Auth::user()->name;          
                $user->save();              
                Session::flash('status', 'Password updated successfully.');              
                return "success"; 
          // } 
           //else
           //{
           // Session::flash('status', 'Incorrect Old Password.'); 
           // return "wrong_password";           
           //}       
            
        }
                    
       
    }
    /**
     * email validation 
     */
    function validate_email(Request $request) {
       
        if ($request->input('email') !== '') {
            if ($request->input('email')) {
                $route=$request->input('route');
                if($route=="AppHttpControllersInsurersController@edit") {
                    $rule = array('email' => 'Required|email');
                }
                else
                    {
                    $rule = array('email' => 'Required|email|unique:users');
                    }
                $validator = Validator::make($request->all(), $rule);
            }
            if (!$validator->fails()) {
                die('true');
            }
        }
        die('false');
    }
    /**
     * index page
     */
    public function index(Request $request)
    {
        // $insurers = User::where('isActive', 1)->where('role', 'IN')->get();  
        $insurers = Insurer::where('isActive', 1)->get();   
        return view('insurers.index')->with(compact('insurers'));
    }

     /**
     * delete customer page
     */
    public function destroy($insurer)
    {   
        $insurer_det = Insurer::find($insurer);
        $customer_det = User::where('insurer.id',new ObjectID($insurer))->first();
        $insurer_id=$insurer_det->_id;
        if ($insurer_det) {
            if ($customer_det) {
                $customer_det->isActive = 0;
                $customer_det->save();
                $insurer_det->isActive = 0;
                $insurer_det->save();
                // $pipline_details = PipelineItems::where('customer.id', new ObjectID($customer))->get();
                // if (count($pipline_details) != 0) {
                //     $status = array(
                //         'pipelineStatus' => 'false'
                //     );
                //     DB::collection('pipelineItems')->where('customer.id', new ObjectId($customer))->update($status);
                // }
                Session::flash('status', 'Insurer deleted successfully.');
                return "success";
            }else {            
                $insurer_det->isActive = 0;
                $insurer_det->save();
                
                Session::flash('status', 'Insurer deleted successfully.');
                return "success";
            }
         }else {  
            
            Session::flash('status', 'Insurer details not available.');
            return "failure";
        }
    }

      /**
      view customer list datatable
     **/
    public function dataTable(Request $request)
    {        
        DB::enableQueryLog();
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $filter = $request->input('search');
        $sort = $request->input('field');
        session()->put('sort', $sort);
        $search = (isset($filter['value'])) ? $filter['value'] : false;
        // $insurers =new Insurer();
        // $insurers = User::where('isActive', 1)->where('customerType', 'Insurer')->get(); 
        $insurers = Insurer::where('isActive', 1);
        // $insurers = $insurers->where('role', 'IN');         
        
        if (!empty($sort)) {
            if ($sort == "Name(A-Z)") {
               $insurers = $insurers->orderBy('name');              
            }else if ($sort == "Name(Z-A)") {
                $insurers = $insurers->orderBy('name', 'DESC');              
             }
            //  elseif ($sort == "Email") {
            // //    $insurers = $insurers->sortBy('email', SORT_NATURAL|SORT_FLAG_CASE);
            //    $insurers = $insurers->orderBy('email','asc');
            // }
        } elseif (empty($sort)) {
           $insurers = $insurers->orderBy('createdAt', 'DESC');       
        }
       
        if ($search) {
            $insurers = $insurers->where(
                function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
                }
            );
            session()->put('search', $search);
        }
        if ($search == "") {
            $insurers = $insurers;
            session()->put('search', "");
        }

        $searchField = $request->get('searchField');
        if ($searchField != "") {
            $insurers = $insurers->where(
                function ($query) use ($searchField) {
                    $query->where('name', 'like', '%' . $searchField . '%')
                        ->orWhere('email', 'like', '%' . $searchField . '%');
                }
            );
        }

        $total_insurers = $insurers->count(); // get your total no of data;
        $members_query = $insurers;
        $search_count = $members_query->count();
        $insurers->skip((int) $start)->take((int) $length);
        $insurers = $insurers->get();
        foreach ($insurers as $insurer) {
            if (session('role') == 'Admin') {
                $action1 = '<button type="button"class="btn export_btn waves-effect auto_modal delete_icon_btn" data-toggle="tooltip" data-placement="bottom" title="Delete" data-container="body"  data-modal="delete_popup" dir="' . $insurer->_id . '" onclick="delete_pop(\'' . $insurer->_id . '\');">

                                            <i class="material-icons">delete_outline</i>
                                        </button>
            ';
            } else {
                $action1 = '';
            }
            $action2 = '<a href="' . URL::to('insurers-show/' . $insurer->_id) . '" class="btn btn-sm btn-success" style="font-weight: 600">View Details</a>';
            
            if (is_array($insurer->email)) {
                $email = $insurer->email['0']?: '--';
            } else {
                $email = $insurer->email ?: '--';
            }
            if($insurer->login_created){
                $login_created="Yes";
            } else {
                $login_created = "No";
            }
            $insurer->name = $insurer->name ?: '--';           
            $insurer->email = $email;   
            $insurer->login_created= $login_created;      
            $insurer->action1 = $action1; 
            $insurer->action2 = $action2;           
        }
        if ($search) {
            $filtered_count = $search_count;
        } else {
            $filtered_count = $total_insurers;
        }
        $data = array(
           'draw' => $draw,
            'recordsTotal' => $total_insurers,
            'recordsFiltered' => $filtered_count,        
           'data' => $insurers
        );

        return json_encode($data);
        
    }

      /**
     * view insurer page
     */
    public function show($insurer_id)
    {
        $insurer = Insurer::find($insurer_id);
       
        if ($insurer) {
            return view('insurers.insurer_details')->with(compact('insurer'));
        } else {
            return view('error');
        }
    }

      /**
     * edit insurer page
     */
    public function edit($insurer)
    {
        $insurerDetails = Insurer::find($insurer);
      
        if ($insurerDetails) {
            return view('insurers.create')
                ->with(compact('insurerDetails'));
        } else {
            return view('error');
        }
    }
       /**
     * edit insurer password page
     */
    public function update($insurer)
    {
        $insurerDetails = Insurer::find($insurer);
      
        if ($insurerDetails) {
            return view('insurers.passEdit')
                ->with(compact('insurerDetails'));
        } else {
            return view('error');
        }
    }
    public function addLogin($insurer)
    {
        $insurerDetails = Insurer::find($insurer);
      
        if ($insurerDetails) {
            return view('insurers.create')
                ->with(compact('insurerDetails'));
        } else {
            return view('error');
        }
    }
    public function insurerUpdate()
    {
        $insurerDetails = Insurer::all();
        $users = User::where('role', 'IN')->get();        
        foreach($insurerDetails as $insurer){
            foreach($users as $user){
                $id=$user->insurer["id"];                
                // $user->userType= "insurer";
                // $user->save();
                if($id==$insurer->_id && @$insurer->login_created!=true){
                    $insurer->email=$user->email;
                    $insurer->login_created=true;
                    $insurer->save();
                }
            }            
        }
      return "sucess";
    }
}