<?php

namespace App\Http\Controllers;

use App\Agent;
use App\CaseManager;
use App\Customer;
use App\PipelineItems;
use App\PipelineStatus;
use App\User;
use App\WorkType;
use App\WorkTypeData;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use MongoDB\BSON\ObjectID;

class WorkTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.underwriter', ['except' => ['worktypeFileupload']]);
    }
    /**
     * work type index page
     */
    public function index()
    {
        return view('work_types.index');//->with(compact('customers'));
    }

    /**
     * create work type page
     */
    public function create()
    {
        $customers = Customer::where('status', 1)->orderby('customerCode', 'asc')->take(10)->get();
        $work_type=WorkType::where('isActive', 1)->orderBy('name')->get();
        $case_managers = User::where('isActive', 1)->where(
            function ($q) {
                $q->where('role', 'EM')->orWhere('role', 'AD')->orWhere('role', 'SV');
            }
        )->orderBy('name')->get();
        return view('work_types.new_worktype')->with(compact('customers', 'work_type', 'case_managers', 'agents'));
    }
    /**
     * for file upload to cloud
     */
    public function worktypeFileupload(Request $request)
    {
        $files = $this->NormalizeFiles("documents");
        $file_name=$files[0];
        $file_name_from_form=$file_name['name'];
        if ($file_name['ext'] == '') {
            return response()->json(['success' => false,"error"=>"File name Required","errorcode" =>"file required"]);
        } elseif ($file_name['success']==false) {
            return response()->json(['success' => false,"error"=>"File name Required","errorcode" =>"file required"]);
        } else {
            $file_url=$this->uploadToCloud($file_name);
            return response()->json(['success' => true, 'file_url' => $file_url,'file_name'=>$file_name_from_form]);
        }
    }

    /**
     * function for upload to cloud
     */
    public static function uploadToCloud($file)
    {
        $extension = $file['ext'];
        $fileName = time() . uniqid() .'.'.$extension;
        $filePath = "/" . $fileName;
        $disk = Storage::disk('s3');
        $disk->put($filePath, fopen($file['file'], 'r+'), 'public'); //uploading as streams, useful for large uploads.
        $file_url = 'https://s3-'.Config::get('filesystems.disks.s3.region').'.amazonaws.com/'.Config::get('filesystems.disks.s3.bucket').'/' . $fileName;
        return $file_url;
    }
    public static function FilenameSafe($filename)
    {
        return preg_replace('/\s+/', "-", trim(trim(preg_replace('/[^A-Za-z0-9_.\-]/', " ", $filename), ".")));
    }
    public static function NormalizeFiles($key)
    {

        $result = array();
        if (isset($_FILES) && is_array($_FILES) && isset($_FILES[$key]) && is_array($_FILES[$key])) {
            $currfiles = $_FILES[$key];
            if (isset($currfiles["name"]) && isset($currfiles["type"]) && isset($currfiles["tmp_name"]) && isset($currfiles["error"]) && isset($currfiles["size"])) {
                if (is_string($currfiles["name"])) {
                    $currfiles["name"] = array($currfiles["name"]);
                    $currfiles["type"] = array($currfiles["type"]);
                    $currfiles["tmp_name"] = array($currfiles["tmp_name"]);
                    $currfiles["error"] = array($currfiles["error"]);
                    $currfiles["size"] = array($currfiles["size"]);
                }
                $y = count($currfiles["name"]);
                for ($x = 0; $x < $y; $x++) {
                    if ($currfiles["error"][$x] != 0) {
                        switch ($currfiles["error"][$x]) {
                        case 1:
                            $msg = "The uploaded file exceeds the 'upload_max_filesize' directive in 'php.ini'.";
                            $code = "upload_err_ini_size";
                            break;
                        case 2:
                            $msg = "The uploaded file exceeds the 'MAX_FILE_SIZE' directive that was specified in the submitted form.";
                            $code = "upload_err_form_size";
                            break;
                        case 3:
                            $msg = "The uploaded file was only partially uploaded.";
                            $code = "upload_err_partial";
                            break;
                        case 4:
                            $msg = "No file was uploaded.";
                            $code = "upload_err_no_file";
                            break;
                        case 6:
                            $msg = "The configured temporary folder on the server is missing.";
                            $code = "upload_err_no_tmp_dir";
                            break;
                        case 7:
                            $msg = "Unable to write the temporary file to disk.  The server is out of disk space, incorrectly configured, or experiencing hardware issues.";
                            $code = "upload_err_cant_write";
                            break;
                        case 8:
                            $msg = "A PHP extension stopped the upload.";
                            $code = "upload_err_extension";
                            break;
                        default:
                            $msg = "An unknown error occurred.";
                            $code = "upload_err_unknown";
                            break;
                        }
                        $entry = array(
                            "success" => false,
                            "error" => self::FFTranslate($msg),
                            "errorcode" => $code
                        );
                    } elseif (!is_uploaded_file($currfiles["tmp_name"][$x])) {
                        $entry = array(
                            "success" => false,
                            "error" => self::FFTranslate("The specified input filename was not uploaded to this server."),
                            "errorcode" => "invalid_input_filename"
                        );
                    } else {
                        $currfiles["name"][$x] = self::FilenameSafe($currfiles["name"][$x]);
                        $pos = strrpos($currfiles["name"][$x], ".");
                        $fileext = ($pos !== false ? (string)substr($currfiles["name"][$x], $pos + 1) : "");
                        $entry = array(
                            "success" => true,
                            "file" => $currfiles["tmp_name"][$x],
                            "name" => $currfiles["name"][$x],
                            "ext" => $fileext,
                            "type" => $currfiles["type"][$x],
                            "size" => $currfiles["size"][$x]
                        );
                    }
                    $result[] = $entry;
                }
            }
        }
        return $result;
    }
    public static function FFTranslate()
    {
        $args = func_get_args();
        if (!count($args)) {
            return "";
        }
        return call_user_func_array((defined("CS_TRANSLATE_FUNC") && function_exists(CS_TRANSLATE_FUNC) ? CS_TRANSLATE_FUNC : "sprintf"), $args);
    }

    /**
     * save worktype details
     */
    public function store(Request $request)
    {
        try {
            $PipelineItems=new WorkTypeData();
            $case_managers=$request->input('caseManager');
            $upload_url=$request->input('output_url');
            $output_file=$request->input('output_file');
            $upload_url_values =  explode(',', $upload_url);
            $output_file_values =  explode(',', $output_file);
            $worktype=$request->input('workType');
            $agent = $request->input('agent');
            $taxRegistrationDocument=$request->file('taxRegistrationDocument');
            $tradeLicense=$request->file('tradeLicense');
            $listOfEmployees=$request->file('listOfEmployees');
            $policyCopy=$request->file('policyCopy');

            $worktype_list=WorkType::find($worktype);
            $worktype_object = new \stdClass();
            $worktype_object->id = new ObjectID($worktype_list->_id);
            $worktype_object->name = $worktype_list->name;
            $worktype_object->department = $worktype_list->departmentName;
            $PipelineItems->workTypeId=$worktype_object;

            $case_manager_details = User::find($case_managers);
            $case_object = new \stdClass();
            $case_object->id = new ObjectID($case_manager_details->_id);
            $case_object->name = $case_manager_details->name;
            $PipelineItems->caseManager=$case_object;

            $customer=$request->input('customer');
            $customer_details=Customer::find($customer);
            $customer_det = new \stdClass();
            $customer_det->id = new ObjectID($customer_details->_id);
            if ($customer_details->getType->name=='Corporate') {
                $customer_det->name = $customer_details->fullName;
                $customer_det->salutation = '';
                $customer_det->first_name = '';
                $customer_det->middle_name = '';
                $customer_det->last_name = '';
            } else {
                $customer_det->name = '';
                $customer_det->salutation = $customer_details->salutation;
                $customer_det->firstName = $customer_details->firstName;
                $customer_det->middleName = $customer_details->middleName;
                $customer_det->lastName =  $customer_details->lastName;
            }
            $customer_det->name = $customer_details->fullName;
            $customer_det->type = $customer_details->getType->name;
            $customer_det->customerCode = $customer_details->customerCode;
            if (isset($customer_details['mainGroup']) &&(isset($customer_details['mainGroup']['id'])) && @$customer_details['mainGroup']['id'] != '') {
                if ($customer_details['mainGroup']['id'] == '0') {
                    $customer_det->maingroupCode = 'Nil';
                } else {
                    $customer_det->maingroupCode = @$customer_details->getMainGroup->customerCode;
                }
                if ($customer_details['mainGroup']['id']!= "0") {
                    $customer_det->maingroupId = new ObjectID($customer_details['mainGroup']['id']);
                    $customer_det->maingroupName = $customer_details['mainGroup']['name'];
                } else {
                    $customer_det->maingroupId="0";
                    $customer_det->maingroupName="Nil";
                }
            } else {
                $customer_det->maingroupId="0";
                $customer_det->maingroupName="Nil";
                $customer_det->maingroupCode = 'Nil';
            }
            $PipelineItems->customer=$customer_det;

            $agents = User::find($agent);
            $agent_object = new \stdClass();
            $agent_object->id = new ObjectID($agents['_id']);
            $agent_object->name = $agents['name'];
            $PipelineItems->agent=$agent_object;
            foreach ($upload_url_values as $url => $url_value) {
                $files = new \stdClass();
                if ($output_file_values[$url]!='0' && $output_file_values[$url]!= '') {
                    $files->url = $upload_url_values[$url];
                    $files->file_name = $output_file_values[$url];
                    $files->upload_type = 'worktype_fancy';
                    $file[] = $files;
                }
            }
            if ($taxRegistrationDocument) {
                $taxRegistrationDocument = PipelineController::uploadToCloud($taxRegistrationDocument);
                $files = new \stdClass();
                $files->url = $taxRegistrationDocument;
                $files->file_name = 'TAX REGISTRATION DOCUMENT';
                $files->upload_type = 'worktype';
                $file[] = $files;
            }
            if ($tradeLicense) {
                $tradeLicense = PipelineController::uploadToCloud($tradeLicense);
                $files = new \stdClass();
                $files->url = $tradeLicense;
                $files->file_name = 'TRADE LICENSE';
                $files->upload_type = 'worktype';
                $file[] = $files;
            }
            if ($listOfEmployees) {
                $listOfEmployees = PipelineController::uploadToCloud($listOfEmployees);
                $files = new \stdClass();
                $files->url = $listOfEmployees;
                $files->file_name = 'LIST OF EMPLOYEES';
                $files->upload_type = 'worktype';
                $file[] = $files;
            }
            if ($policyCopy) {
                $policyCopy = PipelineController::uploadToCloud($policyCopy);
                $files = new \stdClass();
                $files->url = $policyCopy;
                $files->file_name = 'COPY OF THE POLICY';
                $files->upload_type = 'worktype';
                $file[] = $files;
            }
            if (@$file) {
                $PipelineItems->files=$file;
            }
            $PipelineItems->isActive=(boolean)true;
            $PipelineItems->branchCode=(string)'01';
            $Date = date('d/m/y');
            $splted_date=explode('/', $Date);
            $currentdate=implode($splted_date);
            date_default_timezone_set('Asia/Dubai');
            $time = date('His');
            $count = WorkTypeData::where('refereneceNumber', 'like', 'GM/'.$currentdate.'%')->count();
            $newCount = $count+1;
            if ($newCount<10) {
                $newCount = '0'.$newCount;
            }
            if (isset($worktype_list->referralNumber) && $worktype_list->referralNumber != '') {
                $referralNumber = $worktype_list->referralNumber;
            } else {
                $referralNumber = "04205";
            }
            $refNumber = "GM/".$currentdate."/".$time."/$referralNumber/".$newCount;
            // $countExist = WorkTypeData::where('refereneceNumber', 'like', '%'.$refNumber.'%')->count();
            // if($countExist)
            // {

            // }
            $PipelineItems->refereneceNumber=(string)$refNumber;
            $createdBy_obj = new \stdClass();
            $createdBy_obj->id = new ObjectID(Auth::id());
            $createdBy_obj->name = Auth::user()->name;
            $PipelineItems->createdBy = $createdBy_obj;
            $comment_permission = [new ObjectID(Auth::id()), new ObjectID($agent), new ObjectID($case_managers)];
            $PipelineItems->commentPermission = $comment_permission;
            $updatedBy_obj = new\stdClass();
            $updatedBy_obj->id = new ObjectID(Auth::id());
            $updatedBy_obj->name = Auth::user()->name;
            $updatedBy_obj->date = date('d/m/Y');
            $updatedBy_obj->action = "Worktype created";
            $obj[] = $updatedBy_obj;
            $PipelineItems->updatedBy = $obj;

            $PipelineItems->pipelineStatus=(string)'true';

            $pipline_status=PipelineStatus::where('status', 'Worktype Created')->first();
            $pipeline_status_object=new \stdClass();
            $pipeline_status_object->id=new ObjectID($pipline_status->_id);
            $pipeline_status_object->status=$pipline_status->status;
            $pipeline_status_object->UpdatedById = new ObjectId(Auth::id());
            $pipeline_status_object->UpdatedByName = Auth::user()->name;
            $pipeline_status_object->date = date('d/m/Y');
            $PipelineItems->status =$pipeline_status_object;
            if ($PipelineItems->customer) {
                $customerId = @$PipelineItems->customer->id;
                $customerDetails = Customer::find($customerId);
                $eQuestionnaire_obj = new \stdClass();
                $basicDetails_obj = new \stdClass();
                $basicDetails_obj->firstName = @$customerDetails->fullName;
                $basicDetails_obj->address1= @$customerDetails->addressLine1;
                $basicDetails_obj->address2= @$customerDetails->addressLine2;
                $basicDetails_obj->country= @$customerDetails->countryName;
                $basicDetails_obj->emirate= @$customerDetails->cityName;
                $basicDetails_obj->city= @$customerDetails->streetName;
                $basicDetails_obj->pin= @$customerDetails->zipCode;
                $basicDetails_obj->email= @$customerDetails->email[0];
                $eQuestionnaire_obj->basicDetails = $basicDetails_obj;
                $PipelineItems->eQuestionnaire = $eQuestionnaire_obj;
            }
            $PipelineItems->save();
            Session::flash('status', 'Work type added successfully.');
            return "success";
        } catch (Exception $e) {
            return back()->withInput()->with('status', 'Work type added successfully');
        }
    }

    /**
     * get agent list
     */
    public function getAgent(Request $request)
    {
        $customer_id = $request->get('customer_id');
        if ($customer_id == "") {
            return '<option selected value="" name="agent">Select a customer</option>';
        }
        $customer = Customer::find($customer_id);
        $agent = $customer->agent['id'];
        $allAgents = User::where('isActive', 1)->where('role', 'AG')->orderBy('name')->get();
        foreach ($allAgents as $single) {
            if ($single['_id'] == $agent) {
                $response= "<option value='$single->_id' selected>$single->name</option>";
            } else {
                $response= "<option value='$single->_id'>$single->name</option>";
            }
            echo $response;
        }
    }

    /**
     * upload all documents in box
     */
    public function allDocumentsSave(Request $request)
    {
        $pipeline_details=WorkTypeData::find($request->input('worktype_id'));
        $upload_url=$request->input('output_url');
        $output_file=$request->input('output_file');
        $upload_url_values =  explode(',', $upload_url);
        $output_file_values =  explode(',', $output_file);
        foreach ($upload_url_values as $url => $url_value) {
            $files = new \stdClass();
            if ($output_file_values[$url]!='0') {
                $files->url = $upload_url_values[$url];
                $files->file_name = $output_file_values[$url];
                $files->upload_type = 'upload-box';
                $file[] = $files;
            }
        }

        if (!empty($file)) {
            $prevFiles = @$pipeline_details->files?:[];
            $pipeline_details->files = array_merge($prevFiles, $file);
        }
        //$pipeline_details->files = $multi_file;
        $pipeline_details->save();
        return response()->json(['success' =>'success']);
    }

}
