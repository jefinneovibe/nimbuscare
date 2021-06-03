@extends('layouts.dispatch_layout')

@section('sidebar')
    @parent
@endsection

@section('content')
    <div class="section_details">
        <div class="card_header clearfix">
            <h3 class="title">Recipient details</h3>
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
                                    <a href="{{url('dispatch/edit-recipient/'.$details->_id)}}" class="dropdown-item">Edit Recipient Details</a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card_content">
            <div class="user_dtl_top">
                <div class="media">
                    @if($details->getType->name == "Single")
                    <div class="align-self-center user_name_label mr-3"><span>{{strtoupper($details->firstName[0])}}{{strtoupper($details->lastName[0])}}</span></div>
                    @else
                    <div class="align-self-center user_name_label mr-3"><span>{{strtoupper($details->firstName[0])}}</span></div>
                    @endif
                    <div class="media-body align-self-center">
                        <h2>{{$details->salutation ? $details->salutation : ''}}{{$details->fullName}}</h2>
                    </div>
                </div>
            </div>
            <div class="user_dtl_main">
                <div class="row">
                    <div class="col-md-6">
                        <table>
                            {{-- <tr>
                                    <td class="name">Agent</td>
                                    <td class="colon">:</td>
                                    <td><span>{{$agentId?:'--'}} </span></td>
                            </tr> --}}
                            <tr>
                                <?php
                                    if(isset($details['departmentDetails']))
                                    {
                                    $policyDetails=$details['policyDetails'];
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
                            @if(is_array($details->contactNumber))
                                <tr>
                                    <td class="name">Primary Contact Number</td>
                                    <td class="colon">:</td>
                                    <td><span>{{$details->contactNumber[0]?:'--'}}</span></td>
                                </tr>
                            @for($x = 1; $x < count($details->contactNumber); $x++)
                                <tr>
                                    <td class="name">Other Contact Number</td>
                                    <td class="colon">:</td>
                                    <td><span>{{$details->contactNumber[$x]?:'--'}}</span></td>
                                </tr>
                            @endfor
                            @else
                                <tr>
                                    <td class="name">Primary Contact Number</td>
                                    <td class="colon">:</td>
                                    <td><span>{{$details->contactNumber?:'--'}}</span></td>
                                </tr>
                            @endif
                            @if(is_array($details->email))
                                <tr>
                                    <td class="name">Primary Email Id</td>
                                    <td class="colon">:</td>
                                    <td><span>{{$details->email[0]?:'--'}}</span></td>
                                </tr>
                                @for($x = 1; $x < count($details->email); $x++)
                                    <tr>
                                        <td class="name">Other Email Id</td>
                                        <td class="colon">:</td>
                                        <td><span>{{$details->email[$x]?:'--'}}</span></td>
                                    </tr>
                                @endfor
                            @else
                                <tr>
                                    <td class="name">Primary Email Id</td>
                                    <td class="colon">:</td>
                                    <td><span>{{$details->email?:'--'}}</span></td>
                                </tr>
                            @endif
                            @if($details['created_by'])
                                <tr>
                                    <td class="name">Created By</td>
                                    <td class="colon">:</td>
                                    <td><span>{{$details['created_by']}}</span></td>
                                </tr>
                            @endif
                        </table>
                    </div>
                    <div class="col-md-6">
                            <table>
                                    <tr>
                                            <td class="name">Address Line 1</td>
                                            <td class="colon">:</td>
                                            <td><span>{{$details->addressLine1 ? $details->addressLine1 : 'Nil'}}</span></td>
                                    </tr>
                                    <tr>
                                            <td class="name">Address Line 2</td>
                                            <td class="colon">:</td>
                                            <td><span>{{$details->addressLine2 ? $details->addressLine2 : 'Nil'}}</span></td>
                                    </tr>
                                    <tr>
                                            <td class="name">City </td>
                                            <td class="colon">:</td>
                                            <td><span>{{$details->streetName?:'--'}}</span></td>
                                    </tr>
                                    <tr>
                                            <td class="name">Emirates </td>
                                            <td class="colon">:</td>
                                            <td><span>{{$details->cityName?:'--'?:'--'}}</span></td>
                                    </tr>
                                    <tr>
                                            <td class="name">Country</td>
                                            <td class="colon">:</td>
                                            <td><span>{{$details->countryName?:'--'?:'--'}}</span></td>
                                    </tr>
                                    <tr>
                                            <td class="name">PIN/ZIP</td>
                                            <td class="colon">:</td>
                                            <td><span>{{$details->zipCode?:'--'?:'--'}}</span></td>
                                    </tr>
                                    
                            </table>
                    </div>
                    @if(isset($details->departmentDetails))
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
                                    @foreach($details->departmentDetails as $detail)
                                        <tr>
                                            <td>{{$detail['departmentName']?:'--'}}</td>
                                            <td>{{$detail['depContactPerson']?:'--'}}</td>
                                            <td>{{$detail['depContactEmail']?:'--'}}</td>
                                            <td>{{$detail['depContactMobile']?:'--'}}</td>
                                        </tr>
                                        <?php $count++?>
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
            <a href="{{url('dispatch/edit-recipient/'.$details->_id)}}">
                <div class="trigger" data-toggle="tooltip" data-placement="left" title="Edit Recipient Details" data-container="body">
                    <span><i class="material-icons">edit</i></span>
                </div>
            </a>
        </div>
    </div><!--//END Floating Action -->
@endsection

@push('scripts')

@endpush