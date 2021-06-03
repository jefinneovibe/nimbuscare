@extends('layouts.app')

@section('sidebar')
        @parent
@endsection

@section('content')

    <div class="section_details">
        <div class="card_header clearfix">
            <h3 class="title">Customer Details</h3>
            <div class="right_actions">
                <ul>
                    <li>
                        <div class="dropdown nav-item more_vert">
                            <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                                <button class="btn btn-round btn-link btn_more">
                                    <i class="material-icons">more_vert</i>
                                </button>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="{{url('customers/'.$customer->_id.'/edit')}}" class="dropdown-item">Edit Customer Details</a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card_content">
            <div class="user_dtl_top">
                <div class="media">
                    @if($customer->getType->name == "Single")
                    <div class="align-self-center user_name_label mr-3"><span>{{strtoupper($customer->firstName[0])}}{{strtoupper($customer->lastName[0])}}</span></div>
                    @else
                    <div class="align-self-center user_name_label mr-3"><span>{{strtoupper($customer->firstName[0])}}</span></div>
                    @endif
                    <div class="media-body align-self-center">
                        <h2>{{$customer->salutation ? $customer->salutation : ''}}{{$customer->fullName}}</h2>
                        <h3>Customer Code : <span class="label_bg">{{$customer->customerCode}}</span></h3>
                    </div>
                </div>
            </div>
            <div class="user_dtl_main">
                <div class="row">
                    <div class="col-md-6">
                        <table>
                            <tr>
                                <td class="name">Main Group</td>
                                <td class="colon">:</td>
                                <?php
                                if(isset($customer['mainGroup.id']) && ($customer['mainGroup.id'])!='0')
                                {
                                        $main=$customer['mainGroup.name'];
                                }else if(isset($customer['mainGroup.id']) && $customer['mainGroup.id']=='0')

                                {
                                        $main='Nil';
                                }
                                else{
                                        $main='--';
                                }
                                ?>
                                {{-- <td><span>{{$customer['mainGroup.id'] != "0" ? $customer['mainGroup.name'] : 'Nil'}}</span></td> --}}
                                <td><span>{{$main}}</span></td>
                            </tr>
                            <tr>
                                <td class="name">Agent</td>
                                <td class="colon">:</td>
                                <td><span>{{$agentId}} </span></td>
                            </tr>
                            <tr>
                                <td class="name">Level</td>
                                <td class="colon">:</td>
                                <td><span>{{$customer['customerLevel.name']?: '--'}}</span></td>
                            </tr>
                            <tr>
                                <?php
                                    if(isset($customer['departmentDetails']))
                                    {
                                    $policyDetails=$customer['policyDetails'];
                                    $policy=count($policyDetails);
                                    }
                                    else{
                                    $policy=0;
                                    }
                                ?>
                                <td class="name">No of policies</td>
                                <td class="colon">:</td>
                                <td><span>{{$policy}}</span></td>
                            </tr>
                            @if(is_array($customer->contactNumber))
                                <tr>
                                    <td class="name">Primary Contact Number</td>
                                    <td class="colon">:</td>
                                    <td><span>{{$customer->contactNumber[0]?:'--'}}</span></td>
                                </tr>
                            @for($x = 1; $x < count($customer->contactNumber); $x++)
                                <tr>
                                    <td class="name">Other Contact Number</td>
                                    <td class="colon">:</td>
                                    <td><span>{{$customer->contactNumber[$x]?:'--'}}</span></td>
                                </tr>
                            @endfor
                            @else
                                <tr>
                                    <td class="name">Primary Contact Number</td>
                                    <td class="colon">:</td>
                                    <td><span>{{$customer->contactNumber?:'--'}}</span></td>
                                </tr>
                            @endif

                            @if(is_array($customer->email))
                                <tr>
                                    <td class="name">Primary Email Id</td>
                                    <td class="colon">:</td>
                                    <td><span>{{$customer->email[0]?:'--'}}</span></td>
                                </tr>
                                @for($x = 1; $x < count($customer->email); $x++)
                                    <tr>
                                        <td class="name">Other Email Id</td>
                                        <td class="colon">:</td>
                                        <td><span>{{$customer->email[$x]?:'--'}}</span></td>
                                    </tr>
                                @endfor
                            @else
                                <tr>
                                    <td class="name">Primary Email Id</td>
                                    <td class="colon">:</td>
                                    <td><span>{{$customer->email?:'--'}}</span></td>
                                </tr>
                            @endif
                            @if(session('role') == 'Admin'|| session('role') == 'Supervisor')
                                <tr>
                                    <td class="name">Login Id</td>
                                    <td class="colon">:</td>
                                    <td><span>{{$customer->userName?:'--'}}</span></td>
                                </tr>
                                <tr>
                                    <td class="name">Password</td>
                                    <td class="colon">:</td>
                                    <td><span>{{$customer->passCode?:'--'}}</span></td>
                                </tr>
                            @endif
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table>
                            <tr>
                                <td class="name">Address Line 1</td>
                                <td class="colon">:</td>
                                <td><span>{{$customer->addressLine1 ? $customer->addressLine1 : 'Nil'}}</span></td>
                            </tr>
                            <tr>
                                <td class="name">Address Line 2</td>
                                <td class="colon">:</td>
                                <td><span>{{$customer->addressLine2 ? $customer->addressLine2 : 'Nil'}}</span></td>
                            </tr>
                            <tr>
                                <td class="name">City </td>
                                <td class="colon">:</td>
                                <td><span>{{$customer->streetName?:'--'}}</span></td>
                            </tr>
                            <tr>
                                <td class="name">Emirates </td>
                                <td class="colon">:</td>
                                <td><span>{{$customer->cityName?: '--'}}</span></td>
                            </tr>
                            <tr>
                                <td class="name">Country</td>
                                <td class="colon">:</td>
                                <td><span>{{$customer->countryName?: '--'}}</span></td>
                            </tr>
                            <tr>
                                <td class="name">PIN/ZIP</td>
                                <td class="colon">:</td>
                                <td><span>{{$customer->zipCode?: '--'}}</span></td>
                            </tr>
                            @if($customer['created_by'])
                                <tr>
                                    <td class="name">Created By</td>
                                    <td class="colon">:</td>
                                    <td><span>{{$customer['created_by']?: '--'}}</span></td>
                                </tr>
                            @endif
                            <tr>
                                <td class="name">Customer Type</td>
                                <td class="colon">:</td>
                                <td><span>{{@$customer->getMode->name?: '--'}}</span></td>
                            </tr>
                        </table>
                    </div>
                    @if(isset($customer->departmentDetails))
                        <div class="col-md-12">
                            <div class="table-responsive card_table">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Department Name</th>
                                        <th>Contact Person Name</th>
                                        <th>Contact Person Email ID</th>
                                        <th>Contact Person Mobile Number</th>
                                    </tr>
                                    <?php $count = 1; ?>
                                    @foreach($customer->departmentDetails as $details)
                                        <tr>
                                            <td>{{$details['departmentName']?:'--'}}</td>
                                            <td>{{$details['depContactPerson']?:'--'}}</td>
                                            <td>{{$details['depContactEmail']?:'--'}}</td>
                                            <td>{{$details['depContactMobile']?:'--'}}</td>
                                        </tr><?php $count++?>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Floating Action -->
    <div class="floating_icon">
        <div class="fab edit">
            <a href="{{url('customers/'.$customer->_id.'/edit')}}">
                <div class="trigger" data-toggle="tooltip" data-placement="left" title="Edit Customer Details" data-container="body">
                    <span><i class="material-icons">edit</i></span>
                </div>
            </a>
        </div>
    </div><!--//END Floating Action -->

@endsection

@push('scripts')

@endpush
