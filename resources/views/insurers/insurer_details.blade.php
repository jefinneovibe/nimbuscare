@extends('layouts.app')

@section('sidebar')
        @parent
@endsection

@section('content')

    <div class="section_details">
        <div class="card_header clearfix">
            <h3 class="title">Insurer Details</h3>
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
                                <a href="{{url('insurers/'.$insurer->_id.'/edit')}}" class="dropdown-item">Edit Insurer Details</a>  
                                @if (@$insurer->login_created==true)
                                    <a href="{{url('insurers/'.$insurer->_id.'/update')}}"class="dropdown-item">Reset password</a>                                    
                                @else
                                   <a href="{{url('insurers/'.$insurer->_id.'/addLogin')}}"class="dropdown-item">Create Login</a>
                                @endif
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card_content">
            <div class="user_dtl_top">
                <div class="media">
                    
                    <div class="media-body align-self-center">
                        {{-- <h2>{{$insurer->name}}</h2> --}}
                        {{-- <h3>Customer Code : <span class="label_bg">{{$customer->customerCode}}</span></h3> --}}
                    </div>
                </div>
            </div>
            <div class="user_dtl_main">
                <div class="row">
                    <div class="col-md-6">
                        <table>
                            <tr>
                                <td class="name">Name</td>
                                <td class="colon">:</td>
                                <td><span>{{$insurer->name}}</span></td>
                               
                            </tr>
                          
                            @if($insurer->email)
                                <tr>
                                    <td class="name">Email Id</td>
                                    <td class="colon">:</td>
                                    <td><span>{{$insurer->email?:'--'}}</span></td>
                                </tr>
                           
                            @endif
                             <tr>
                          
                                {{--  <td><span><a href="{{url('insurers/'.$insurer->_id.'/update')}}">Reset password</span></td>  --}}
                               
                            </tr>
                            @if(session('role') == 'Admin'|| session('role') == 'Supervisor')
                            
                                <tr>
                                    {{-- <td class="name">Password</td>
                                    <td class="colon">:</td> --}}
                                    {{-- <td><span>{{$customer->passCode?:'--'}}</span></td> --}}
                                </tr>
                            @endif
                        </table>
                    </div>
                   
                          
                        </table>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>

    <!-- Floating Action -->
    <div class="floating_icon">
        <div class="fab edit">
            <a href="{{url('insurers/'.$insurer->_id.'/edit')}}">
                <div class="trigger" data-toggle="tooltip" data-placement="left" title="Edit Insurer Details" data-container="body">
                    <span><i class="material-icons">edit</i></span>
                </div>
            </a>
        </div>
    </div><!--//END Floating Action -->

@endsection

@push('scripts')

@endpush
