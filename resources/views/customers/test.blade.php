@extends('layouts.app')

@section('sidebar')
    @parent
@endsection

@section('content')
    @if(!empty($customers))
        @forelse($customers as $customer)
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
                                <a href="#" class="dropdown-item">Edit Details</a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card_content">
            <div class="user_dtl_top">
                <div class="media">
                    <div class="align-self-center user_name_label mr-3"><span>AS</span></div>
                    <div class="media-body align-self-center">
                        <h2>{{$customer->fullName}}</h2>
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
                                <td><span>{{$customer->getMainGroup ? $customer->getMainGroup->fullName : 'Nil'}}</span></td>
                            </tr>
                            <tr>
                                <td class="name">Agent</td>
                                <td class="colon">:</td>
                                <td><span>{{$customer->getAgent->name}} </span></td>
                            </tr>
                            <tr>
                                <td class="name">Level</td>
                                <td class="colon">:</td>
                                <td><span>{{$customer->getlevel->name}}</span></td>
                            </tr>
                            <tr>
                                <td class="name">No of policies</td>
                                <td class="colon">:</td>
                                <td><span>0</span></td>
                            </tr>
                            <tr>
                                <td class="name">Primary Contact Number</td>
                                <td class="colon">:</td>
                                <td><span>9562303511</span></td>
                            </tr>
                            <tr>
                                <td class="name">Other Contact Number</td>
                                <td class="colon">:</td>
                                <td><span>8089113712</span></td>
                            </tr>
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
                                <td class="name">Country</td>
                                <td class="colon">:</td>
                                <td><span>{{$customer->getCountry->name}}</span></td>
                            </tr>
                            <tr>
                                <td class="name">Emirates </td>
                                <td class="colon">:</td>
                                <td><span>{{$customer->getCity->name}}</span></td>
                            </tr>
                            <tr>
                                <td class="name">Primary Email Id</td>
                                <td class="colon">:</td>
                                <td><span>azeem@beovibe.in</span></td>
                            </tr>
                            <tr>
                                <td class="name">Other Email Id</td>
                                <td class="colon">:</td>
                                <td><span>azeemazai@gmail.com</span></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Floating Action -->
    <div class="floating_icon">
        <div class="fab edit">
            <a href="">
                <div class="trigger" data-toggle="tooltip" data-placement="left" title="Edit Details" data-container="body">
                    <span><i class="material-icons">edit</i></span>
                </div>
            </a>
        </div>
    </div><!--//END Floating Action -->
        @empty

        @endforelse
    @endif
@endsection

@push('scripts')

@endpush