@extends('layouts.app')

@section('sidebar')
    @parent
@endsection
@section('content')
            <div class="section_details">
                <div class="card_header clearfix">
                    <h3 class="title">User Details</h3>
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
                                        <a href="{{url('user/edit-user/' . $user->_id)}}" class="dropdown-item">Edit User Details</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="card_content">
                    <div class="user_dtl_top">
                        <div class="media">
                                <div class="align-self-center user_name_label mr-3"><span>{{strtoupper($user['firstName'][0])}}</span></div>
                            <div class="media-body align-self-center">
                                <h2>{{ucwords(strtolower($user['firstName']))}} {{ucwords(strtolower($user['lastName']))}}</h2>
                                <h3>Employee ID : <span class="label_bg">{{$user['empID']?:"--"}}</span></h3>
                            </div>
                        </div>
                    </div>
                    <div class="user_dtl_main">
                        <div class="row">
                            <div class="col-md-6">
                                <table>
                                    <tr>
                                        <td class="name">Role</td>
                                        <td class="colon">:</td>
                                        <td><span>{{$role}}</span></td>
                                    </tr>
                                    <tr>
                                        <td class="name">First Name</td>
                                        <td class="colon">:</td>
                                        <td><span>{{ucwords(strtolower($user['firstName']))}} </span></td>
                                    </tr>
                                    <tr>
                                        <td class="name">Last Name</td>
                                        <td class="colon">:</td>
                                        <td><span>{{ucwords(strtolower($user['lastName']))}}</span></td>
                                    </tr>
                                    <tr>
                                        <td class="name">Email</td>
                                        <td class="colon">:</td>
                                        <td><span>{{$user['email']}}</span></td>
                                    </tr>
                                    <tr>
                                        <td class="name">Employee Id</td>
                                        <td class="colon">:</td>
                                        <td><span>{{$user['empID']?:"--"}}</span></td>
                                    </tr>
                                    @if(isset($user['permission']['permissionCheck']))
                                    <tr>
                                        <td class="name">Assigned Permissions</td>
                                        <td class="colon">:</td>
                                        <td><span><?php $count=1?>
                                            @foreach (@$user['permission']['permissionCheck'] as $item)
                                            {{$count}}. {{$item}}<br>
                                           <?php $count++;?>
                                                  @endforeach
                                            </span></td>
                                    </tr>
                                    @endif
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table>
                                    <tr>
                                        <td class="name">Department</td>
                                        <td class="colon">:</td>
                                        <td><span>{{$user['department']?:"--"}}</span></td>
                                    </tr>
                                    <tr>
                                        <td class="name">Position</td>
                                        <td class="colon">:</td>
                                        <td><span>{{$user['position']?:"--"}}</span></td>
                                    </tr>
                                    <tr>
                                        <td class="name">Name of Supervisor</td>
                                        <td class="colon">:</td>
                                        <td><span>{{$user['nameOfSupervisor']?:"--"}}</span></td>
                                    </tr>
                                    <tr>
                                        <td class="name">Unique Code</td>
                                        <td class="colon">:</td>
                                        <td><span>{{$user['uniqueCode']?:"--"}}</span></td>
                                    </tr>
                                    @if($role=='Coordinator')
                                        <tr>
                                            <td class="name">Assigned Agent</td>
                                            <td class="colon">:</td>
                                            <td><span>{{@$user['assigned_agent']['agentName']?:"--"}}</span></td>
                                        </tr>
                                    @elseif($role== 'Supervisor')
                                    @php
                                        $employees=@$user['employees']? $user['employees'] : [];
                                    @endphp
                                        <tr>
                                            <td class="name">Assigned Employees</td>
                                            <td class="colon">:</td>
                                            @if($employees)
                                                <td>
                                                    @foreach ($employees as $employee)
                                                        <span>{{$employee['empName']?:"--"}}</span><br>
                                                    @endforeach
                                                </td>
                                            @else
                                                 <td>
                                                    <span>--</span><br>
                                                </td>
                                            @endif
                                        </tr>
                                    @endif
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Floating Action -->
            <div class="floating_icon">
                <div class="fab edit">
                    <a href="{{url('user/edit-user/' . $user->_id)}}">
                        <div class="trigger" data-toggle="tooltip" data-placement="left" title="Edit User Details" data-container="body">
                            <span><i class="material-icons">edit</i></span>
                        </div>
                    </a>
                </div>
            </div><!--//END Floating Action -->

@endsection

@push('scripts')

@endpush