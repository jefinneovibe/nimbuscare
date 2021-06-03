<?php

namespace App\Http\Controllers;
use App\WorkType;
use App\Customer;
use App\Departments;
use App\User;
use App\PipelineStatus;
use App\PipelineItems;
use App\WorkTypeData;
use Carbon\Carbon;
use Illuminate\Http\Request;
use MongoDB\BSON\ObjectID;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Session;

class CloseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.underwriter');
    }
   public function closedPipelines(Request $request)
   {
        $filter_data = $request->input();
        $mainGroups = $request->input('main_group_id');
    //        $mainGroups = Customer::where('mainGroup.id', '0')->get();
    if (!empty($request->input('work_type'))) {
        $count = 0;
        foreach ($request->input('work_type') as $cust) {
            $objectArray[$count] = new ObjectId($cust);
            $count++;
        }
        $workTypes = WorkType::whereIn('_id', $objectArray)->get();
    } else {
        $workTypes = '';
    }
    if (!empty($request->input('agent'))) {
        $count = 0;
        foreach ($request->input('agent') as $cust) {
            $objectArray[$count] = new ObjectId($cust);
            $count++;
        }
        $agents = User::where('isActive', 1)->where('role', 'AG')->whereIn('_id', $objectArray)->get();
    } else {
        $agents = '';
    }

    if (!empty($request->input('case_manager'))) {
        $count = 0;
        foreach ($request->input('case_manager') as $cust) {
            $objectArray[$count] = new ObjectId($cust);
            $count++;
        }
        $caseManagers = User::where('isActive', 1)->where(function ($q) {
            $q->where('role', 'EM')->orWhere('role', 'AD');
        })->whereIn('_id', $objectArray)->get();
    } else {
        $caseManagers = '';
    }
    if (!empty($request->input('current_status'))) {
        $count = 0;
        foreach ($request->input('current_status') as $cust) {
            $objectArray[$count] = new ObjectId($cust);
            $count++;
        }
        $status = PipelineStatus::whereIn('_id', $objectArray)->get();
    } else {
        $status = '';
    }

    if (!empty($request->input('customer'))) {
        $count = 0;
        foreach ($request->input('customer') as $cust) {
            $objectArray[$count] = new ObjectId($cust);
            $count++;
        }
        $customers = Customer::whereIn('_id', $objectArray)->get();
    } else {
        $customers = '';
    }
    if (!empty($request->input('department'))) {
        $count = 0;
        foreach ($request->input('department') as $cust) {
            $objectArray[$count] = new ObjectId($cust);
            $count++;
        }
        $departments = Departments::whereIn('_id', $objectArray)->get();
    } else {
        $departments = '';
    }

    if (!empty($request->input('main_group'))) {
        $count = 0;
        foreach ($request->input('main_group') as $cust) {
            if ($cust == "Nil") {
                $objectArray[$count] = (string) 0;
            }
            if ($cust != '0' && $cust != 'Nil') {
                $objectArray[$count] = new ObjectId($cust);
            }
            $count++;
        }
        $mainGroupCodes = Customer::whereIn('_id', $objectArray)->get();
    } else {
        $mainGroupCodes = '';
    }
    return view('closed.closed_view')->with(compact('workTypes', 'agents', 'caseManagers', 'filter_data', 'status', 'customers', 'departments', 'mainGroupCodes'));
   }

   /**
    * datatable
    */
    public function closeData(Request $request)
    {
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $filter = $request->input('search');
        $sort = $request->input('field');
        $jsonFilter = $request->input('filterData');
        session()->put('filter', $jsonFilter);
        session()->put('sort', $sort);
        $filterData = json_decode($jsonFilter);
        /**
         *
         * Conditions for Filtering*/
        if ($filterData) {
            $pipeData = WorkTypeData::where('pipelineStatus', "Closed");
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
                        $objectArray[$count] = (string) 0;
                    }
                    if ($cust != '0' && $cust != 'Nil') {
                        $objectArray[$count] = new ObjectId($cust);
                    }
                    $count++;
                }
                $pipeData = $pipeData->whereIn('customer.maingroupId', $objectArray);
            }

            if (!empty($filterData->department)) {
                $val_array = [];
                foreach ($filterData->department as $cust) {
                    $departmentDet = Departments::find($cust);
                    $val_array[] = $departmentDet->name;
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
            $pipeData = WorkTypeData::where('pipelineStatus', "Closed");
        }
        $searchField = $request->get('searchField');
        $search = (isset($filter['value'])) ? $filter['value'] : false;

        /**
         * Conditions for Sorting*/
        if ($sort == "Customer Name") {
            $items1 = $pipeData->orderBy('customer.name');
        } elseif ($sort == "Agent") {
            $items1 = $pipeData->orderBy('agent.name');
        } elseif ($sort == "Worktype") {
            $items1 = $pipeData->orderBy('workTypeId.name');
        } elseif ($sort == "Status") {
            $items1 = $pipeData->orderBy('status.status');
        } elseif ($sort == "Last Updated At") {
            $items1 = $pipeData->orderBy('updated_at', 'desc');
        } else {
            $items1 = $pipeData->orderBy('updated_at', 'desc');
        }
        /**
         * Conditions for searching*/
        if ($search) {
            $item1 = $items1->where(function ($query) use ($search) {
                $query->where('customer.name', 'like', '%' . $search . '%')
                    ->orwhere('customer.customerCode', 'like', '%' . $search . '%')
                    ->orWhere('workTypeId.name', 'like', '%' . $search . '%')
                    ->orWhere('workTypeId.department', 'like', '%' . $search . '%')
                    ->orWhere('customer.maingroupName', 'like', '%' . $search . '%')
                    ->orWhere('customer.maingroupCode', 'like', '%' . $search . '%')
                    ->orWhere('caseManager.name', 'like', '%' . $search . '%')
                    ->orwhere('updated_at', 'like', '%' . $search . '%')
                    ->orWhere('status.status', 'like', '%' . $search . '%')
                    ->orWhere('agent.name', 'like', '%' . $search . '%')
//                ->orWhere('status.date','like','%'.$search.'%')
                //                ->orWhere('status.UpdatedByName','like','%'.$search.'%')
                //                ->orWhere('status.date','like','%'.$search.'%')
                    ->orwhere('createdBy.name', 'like', '%' . $search . '%')
                    ->orwhere('documentNo', 'like', '%' . $search . '%')
                    ->orWhere('refereneceNumber', 'like', '%' . $search . '%');
            });
            session()->put('search', $search);
        } else {
            $item1 = $items1;
            session()->put('search', "");
        }
        if ($search == "") {
            $item1 = $items1;
            session()->put('search', "");
        }

        $total_items = $item1->count(); // get your total no of data;
        $members_query = $item1;
        $search_count = $members_query->count();
        $item1->skip((int) $start)->take((int) $length);
        $items = $item1->get();
        $datas = [];
        foreach ($items as $item) {
            // if ($item->workTypeId['name'] == "Workman's Compensation") {
            //     if ($item->status['status'] == "Quote Amendment-E-slip") {
            //         $referanceNumber = '<a href="' . URL::to('e-slip/' . $item->_id) . '" class="table_link">' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "Quote Amendment-E-quotation") {
            //         $referanceNumber = '<a href="' . URL::to('e-quotation/' . $item->_id) . '" class="table_link" >' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "Quote Amendment-E-comparison") {
            //         $referanceNumber = '<a href="' . URL::to('e-comparison/' . $item->_id) . '" class="table_link" >' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "Quote Amendment") {
            //         $referanceNumber = '<a href="' . URL::to('quot-amendment/' . $item->_id) . '" class="table_link" >' . $item->refereneceNumber . '</a>';
            //     }
            // } elseif ($item->workTypeId['name'] == "Property") {
            //     if ($item->status['status'] == "Quote Amendment-E-slip") {
            //         $referanceNumber = '<a href="' . URL::to('property/e-slip/' . $item->_id) . '" class="table_link">' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "Quote Amendment-E-quotation") {
            //         $referanceNumber = '<a href="' . URL::to('property/e-quotation/' . $item->_id) . '" class="table_link">' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "Quote Amendment-E-comparison") {
            //         $referanceNumber = '<a href="' . URL::to('property/e-comparison/' . $item->_id) . '" class="table_link">' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "Quote Amendment") {
            //         $referanceNumber = '<a href="' . URL::to('property/quot-amendment/' . $item->_id) . '" class="table_link" >' . $item->refereneceNumber . '</a>';
            //     }
            // } elseif ($item->workTypeId['name'] == "Employers Liability") {
            //     if ($item->status['status'] == "Quote Amendment-E-slip") {
            //         $referanceNumber = '<a href="' . URL::to('employer/e-slip/' . $item->_id) . '" class="table_link">' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "Quote Amendment-E-quotation") {
            //         $referanceNumber = '<a href="' . URL::to('employer/e-quotation/' . $item->_id) . '" class="table_link" >' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "Quote Amendment-E-comparison") {
            //         $referanceNumber = '<a href="' . URL::to('employer/e-comparison/' . $item->_id) . '" class="table_link" >' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "Quote Amendment") {
            //         $referanceNumber = '<a href="' . URL::to('employer/quot-amendment/' . $item->_id) . '" class="table_link" >' . $item->refereneceNumber . '</a>';
            //     }
            // } elseif ($item->workTypeId['name'] == "Money") {
            //     if ($item->status['status'] == "Quote Amendment-E-slip") {
            //         $referanceNumber = '<a href="' . URL::to('money/e-slip/' . $item->_id) . '" class="table_link">' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "Quote Amendment-E-quotation") {
            //         $referanceNumber = '<a href="' . URL::to('money/e-quotation/' . $item->_id) . '" class="table_link">' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "Quote Amendment-E-comparison") {
            //         $referanceNumber = '<a href="' . URL::to('money/e-comparison/' . $item->_id) . '" class="table_link">' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "Quote Amendment") {
            //         $referanceNumber = '<a href="' . URL::to('money/quot-amendment/' . $item->_id) . '" class="table_link" >' . $item->refereneceNumber . '</a>';
            //     }
            // } elseif ($item->workTypeId['name'] == "Business Interruption") {
            //     if ($item->status['status'] == "Quote Amendment-E-slip") {
            //         $referanceNumber = '<a href="' . URL::to('business_interruption/e-slip/' . $item->_id) . '" class="table_link">' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "Quote Amendment-E-quotation") {
            //         $referanceNumber = '<a href="' . URL::to('business_interruption/e-quotation/' . $item->_id) . '" class="table_link">' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "Quote Amendment-E-comparison") {
            //         $referanceNumber = '<a href="' . URL::to('business_interruption/e-comparison/' . $item->_id) . '" class="table_link">' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "Quote Amendment") {
            //         $referanceNumber = '<a href="' . URL::to('business_interruption/quot-amendment/' . $item->_id) . '" class="table_link" >' . $item->refereneceNumber . '</a>';
            //     }
            // } elseif ($item->workTypeId['name'] == "Fire and Perils") {
            //     if ($item->status['status'] == "Quote Amendment-E-slip") {
            //         $referanceNumber = '<a href="' . URL::to('fireperils/e-slip/' . $item->_id) . '" class="table_link">' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "Quote Amendment-E-quotation") {
            //         $referanceNumber = '<a href="' . URL::to('fireperils/e-quotation/' . $item->_id) . '" class="table_link">' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "Quote Amendment-E-comparison") {
            //         $referanceNumber = '<a href="' . URL::to('fireperils/e-comparison/' . $item->_id) . '" class="table_link">' . $item->refereneceNumber . '</a>';
            //     } elseif ($item->status['status'] == "Quote Amendment") {
            //         $referanceNumber = '<a href="' . URL::to('fireperils/quot-amendment/' . $item->_id) . '" class="table_link" >' . $item->refereneceNumber . '</a>';
            //     }
            // } else {
                $referanceNumber = '<a  class="table_link">' . $item->refereneceNumber . '</button>';
            // }
            $id = @$item->getCustomer->customerCode;
            $seen = $item->commentSeen;
            if (in_array(new ObjectID(Auth::id()), $item->commentPermission)) {
                if ($seen) {
                    if (!in_array(Auth::id(), $seen)) {
                        $comments = $item->comments;
                        if ($comments) {
                            $newComment = end($comments);
                            $commentDisplay = $newComment['commentBy'] . ' (' . $newComment['userType'] . ') : ' . $newComment['comment'];
                            $category = '<div class="name_sec"><span>' . $item->workTypeId['name'] . '</span><i data-toggle="tooltip" data-placement="right" data-container="body" data-original-title="' . $commentDisplay . '" class="fa fa-comments"></i></div>';
//                $category = $item->workTypeId['name'].'<i class="material-icons">forum</i>';
                        } else {
                            $category = '<div class="name_sec"><span>' . $item->workTypeId['name'] . '</span></div>';
                        }
                    } else {
                        $category = '<div class="name_sec"><span>' . $item->workTypeId['name'] . '</span></div>';
//                $category = $item->workTypeId['name'];
                    }
                } else {
                    $category = '<div class="name_sec"><span>' . $item->workTypeId['name'] . '</span></div>';
                }
            } else {
                $category = '<div class="name_sec"><span>' . $item->workTypeId['name'] . '</span></div>';
            }
            $action1 = '<button type="button"  style="font-weight: 600;" class="btn-primary" data-container="body"   data-modal="reinstate_popup" dir="'.$item->_id.'" onclick="reinstate_popup(\''.$item->_id.'\');">Reinstate</button>
';
            // $action2 = '<a href="' . URL::to('customers-show/' . $customer->_id) . '" class="btn btn-sm btn-success" style="font-weight: 600">View Details</a>';
            $created = $item->created_at;
            $created_at = Carbon::parse($created)->format('d-m-Y');
            $created_by = $item->createdBy['name'];
            $name = $item->customer['name'];
            if (isset($item->customer['maingroupCode'])) {
                $maingroup_code = $item->customer['maingroupCode'];
                $maingroup = $item->customer['maingroupName'];
            } else {
                $maingroup = '--';
                $maingroup_code = '--';
            }

            if (isset($item->workTypeId['department'])) {
                $department = $item->workTypeId['department'];
            } else {
                $department = '--';
            }
            $underwriter = '--';
            $case_manager = $item->caseManager['name'];
            $update = $item->updatedBy;
            $lastUpdate = end($update);
            $old = str_replace("/", "-", $lastUpdate['date']);
            $today = date('d-m-Y');
            $date1 = date_create($today);
            $date2 = date_create($old);
            $diff = date_diff($date1, $date2);
            $diff = $diff->format("%a days");
            $updated_by = $lastUpdate['name'];
            $updated_at = $item->updated_at;
            $date = Carbon::parse($updated_at)->format('d-m-Y');
            ////        $referanceNumber = $item->refereneceNumber;
            $status = $item->status['status'];
            $agent = $item->agent['name'];
            if (isset($item->status['UpdatedByName'])) {
                $current_update = $item->status['UpdatedByName'];
            } else {
                $current_update = '--';
            }
            if (isset($item->status['date'])) {
                $status_date = $item->status['date'];
            } else {
                $status_date = '--';
            }
            if (isset($item['documentNo'])) {
                $amendments = $item['documentNo'];
            } else {
                $amendments = '--';
            }
            $temp = new \stdClass();
            $temp->category = $category;
            $temp->referenceNumber = $referanceNumber;
            $temp->created_at = $created_at;
            $temp->created_by = $created_by;
            $temp->customerId = $id;
            $temp->customerName = $name;
            $temp->maingroup_id = $maingroup_code;
            $temp->mainGroup = $maingroup;
            $temp->department = $department;
            $temp->agent = $agent;
            $temp->underwriter = $case_manager;
            $temp->status = $status;
            $temp->current_update = $updated_by;
            $temp->status_date = $date;
            $temp->caseManager = $case_manager;
            $temp->diff = $diff;
            $temp->amendments = $amendments;
            $temp->action1=$action1;
            $datas[] = $temp;
        }
        if ($search) {
            $filtered_count = $search_count;
        } else {
            $filtered_count = $total_items;
        }
        $data = array(
            'draw' => $draw,
            'recordsTotal' => $total_items,
            'recordsFiltered' => $filtered_count,
            'data' => $datas,
        );
        return json_encode($data);
    }

    /**
     * export closed list
     */
    public function exportClosed(Request $request)
    {
        $filterData = json_decode(session('filter'));
        $sort = session('sort');
        $search = session('search');
        if ($filterData) {
            $pipeData = WorkTypeData::where('pipelineStatus', "Closed");
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
            $pipeData = WorkTypeData::where('pipelineStatus', "Closed");
        }

        if ($sort=="Customer Name") {
            $items1 = $pipeData->orderBy('customer.name');
        } elseif ($sort=="Agent") {
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
            $item1 = $items1->where(function ($query) use ($search) {
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
            });
            session()->put('search', $search);
        } else {
            $item1 = $items1;
        }

        $pipeItem = $item1->get();

        $data[] = array('Clossed PipeLine List');
        $data[] = ['REFERENCE NUMBER', 'DATE CREATED', 'CREATED BY','CUSTOMER ID', 'CUSTOMER NAME', 'MAIN GROUP ID', 'MAING ROUP NAME', 'DEPARTMENT','WORK TYPE', 'AGENT NAME',
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
        Excel::create('Clossed-List', function ($excel) use ($data) {
            $excel->sheet('Clossed Pipeline List', function ($sheet) use ($data) {
                $sheet->mergeCells('A1:Q1');
                $sheet->row(1, function ($row) {
                    $row->setFontSize(15);
                    $row->setFontColor('#ffffff');
                    $row->setBackground('#1155CC');
                });
                $sheet->fromArray($data, null, 'A1', true, false);
            });
        })->download('xls');
    }

    /**
     * reinstate item
     */
    public function reinstateItem($id)
    {
        $item = WorkTypeData::find($id);
		if ($item)
		{
            // $oldStatus=$item->pipelineStatus;
            $updatedBy_obj = new \stdClass();
            $updatedBy_obj->id = new ObjectID(Auth::id());
            $updatedBy_obj->name = Auth::user()->name;
            $updatedBy_obj->date = date('d/m/Y');
            $updatedBy_obj->action = "Reinstate the lead";
            $updatedBy[] = $updatedBy_obj;
            $item->push('updatedBy', $updatedBy);
            // $item->prevPiplineStatus=$oldStatus;
            $item->save();
            WorkTypeData::where('_id', $id)->update(array('pipelineStatus' => 'true'));
            Session::flash('status', 'Reinstated successfully.');
            return 'success';
		}
    }
}
