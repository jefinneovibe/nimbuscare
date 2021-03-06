
@extends('layouts.app')

@section('sidebar')
    @parent
@endsection

@section('content')
    <style>
        .cd-breadcrumb.triangle li.active_arrow > * {
            /* selected step */
            color: #ffffff;
            background-color: #FFA500;
            border-color: #FFA500;
        }
    </style>
    <div class="section_details">
        <form id="e-slip-form" name="e-slip-form"  method="post"> 
            {{csrf_field()}}
            <input type="hidden" value="{{@$worktype_id}}" name="eslip_id" id="eslip_id">
            <input type="hidden" id="pipeline_id" name="pipeline_id" value="{{$worktype_id}}">
            <div class="card_header clearfix">
                <h3 class="title" style="margin-bottom: 8px;">Property</h3>
            </div>
            <div class="card_content">
                <div class="edit_sec clearfix">

                    <!-- Steps -->
                    <section>
                        <nav>
                            <ol class="cd-breadcrumb triangle">
                                @if($pipeline_details['status']['status'] == 'E-slip')
                                    <li class="complete"><a href="{{ url('property/e-questionnaire/'.$worktype_id) }}"><em>E-Questionnaire</em></a></li>
                                    <li class="current"><em>E-Slip</em></li>
                                    <li><em>E-Quotation</em></li>
                                    <li><em>E-Comparison</em></li>
                                    <li><em>Quote Amendment</em></li>
                                    <li><em>Approved E Quote</em></li>
                                    {{--<li><em>Issuance</em></li>--}}
                                @elseif($pipeline_details['status']['status'] == 'E-quotation')
                                    <li class="complete"><a href="{{ url('property/e-questionnaire/'.$worktype_id) }}"><em>E-Questionnaire</em></a></li>
                                    <li class="active_arrow"><a href="{{url('property/e-slip/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>
                                    <li class="current"><a href="{{url('property/e-quotation/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                                    <li><em>E-Comparison</em></li>
                                    <li><em>Quote Amendment</em></li>
                                    <li><em>Approved E Quote</em></li>
                                    {{--<li><em>Issuance</em></li>--}}
                                @elseif($pipeline_details['status']['status'] == 'E-comparison')
                                    <li class="complete"><a href="{{ url('property/e-questionnaire/'.$worktype_id) }}"><em>E-Questionnaire</em></a></li>
                                    <li class="active_arrow"><a href="{{url('property/e-slip/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>
                                    <li class="complete"><a href="{{url('property/e-quotation/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                                    <li class="current"><a href="{{url('property/e-comparison/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                                    <li><em>Quote Amendment</em></li>
                                    <li><em>Approved E Quote</em></li>
                                    {{--<li><em>Issuance</em></li>--}}
                                @elseif($pipeline_details['status']['status'] == 'Quote Amendment')
                                    <li class="complete"><a href="{{ url('property/e-questionnaire/'.$worktype_id) }}"><em>E-Questionnaire</em></a></li>
                                    <li class="active_arrow"><a href="{{url('property/e-slip/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>
                                    <li class="complete"><a href="{{url('property/e-quotation/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                                    <li class = complete><a href="{{url('property/e-comparison/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                                    <li class = current><a href="{{url('property/quot-amendment/'.$worktype_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>
                                    <li><em>Approved E Quote</em></li>
                                    {{--<li><em>Issuance</em></li>--}}
                                @elseif($pipeline_details['status']['status'] == 'Approved E Quote')
                                    <li class="complete"><a href="{{ url('property/e-questionnaire/'.$worktype_id) }}"><em>E-Questionnaire</em></a></li>
                                    <li class="active_arrow"><a href="{{url('property/e-slip/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>
                                    <li class="complete"><a href="{{url('property/e-quotation/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                                    <li class = complete><a href="{{url('property/e-comparison/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                                    <li class = complete><a href="{{url('property/quot-amendment/'.$worktype_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>
                                    <li class = "current"><a href="{{url('property/approved-quot/'.$worktype_id)}}" style="color: #ffffff;"><em>Approved E Quote</em></a></li>
                                    {{--<li><em>Issuance</em></li>--}}
                                @elseif($pipeline_details['status']['status'] == 'Quote Amendment-E-comparison' || $pipeline_details['status']['status'] == 'Quote Amendment-E-quotation' || $pipeline_details['status']['status'] == 'Quote Amendment-E-slip')
                                    <li class="complete"><a href="{{ url('property/e-questionnaire/'.$worktype_id) }}"><em>E-Questionnaire</em></a></li>
                                    <li class="active_arrow"><a href="{{url('property/e-slip/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>
                                    <li class="complete"><a href="{{url('property/e-quotation/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                                    <li class = complete><a href="{{url('property/e-comparison/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                                    <li class = current><a href="{{url('property/quot-amendment/'.$worktype_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>
                                    <li><em>Approved E Quote</em></li>
                                    {{--@elseif($pipeline_details['status']['status'] == 'Issuance')--}}
                                    {{--<li class="complete"><a href="{{ url('e-questionnaire/'.$worktype_id) }}"><em>E-Questionnaire</em></a></li>--}}
                                    {{--<li class="complete"><a href="{{url('e-slip/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>--}}
                                    {{--<li class="complete"><a href="{{url('e-quotation/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>--}}
                                    {{--<li class = complete><a href="{{url('e-comparison/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>--}}
                                    {{--<li class = complete><a href="{{url('quot-amendment/'.$worktype_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>--}}
                                    {{--<li class = "complete"><a href="{{url('approved-quot/'.$worktype_id)}}" style="color: #ffffff;"><em>Approved E Quote</em></a></li>--}}
                                    {{--<li class = "current"><a href="{{url('issuance/'.$worktype_id)}}" style="color: #ffffff;"><em>Issuance</em></a></li>--}}
                                @else
                                    <li class="complete"><a href="{{ url('property/e-questionnaire/'.$worktype_id) }}"><em>E-Questionnaire</em></a></li>
                                    <li class="current"><a href="{{url('property/e-slip/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>
                                    <li><em>E-Quotation</em></li>
                                    <li><em>E-Comparison</em></li>
                                    <li><em>Quote Amendment</em></li>
                                    <li><em>Approved E Quote</em></li>
                                    {{--<li><em>Issuance</em></li>--}}
                                @endif
                            </ol>
                        </nav>
                    </section>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form_group">
                                <label class="form_label">Name of the Company <span style="visibility:hidden">*</span></label>
                                <div class="enter_data">
                                    <p>{{ucwords(strtolower(@$pipeline_details['formData']['companyName']))}}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form_group">
                                <label class="form_label">Cover <span  style="visibility:hidden">*</span></label>
                                <div class="row">
                                    <div class="col-md-12">
                                        <span class="note">
                                        <label>
                                        {{-- <b>Property</b><br> --}}
                                        As per LM7 wording
                                        </label>
                                        </span>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form_group">
                                <label class="form_label">Interest <span  style="visibility:hidden">*</span></label>
                                <div class="row">
                                    <div class="col-md-12">
                                        <span class="note">
                                        <label>
                                        {{-- <b>Interest</b><br> --}}
                                        All real and physical personal properties of every description state herein owned in whole or in parts by the Insurerd and hold the interest of the Insured in properties of others on commission, trust, custody, control, joint accounts with others including the intesrest pf the insured in improvements and betterment of building not owned by theinsured for which th insured might become liable to pay in case of loss or damage by any cause covered under LM7 wording whilst stored and/or located and/or sitauted and/or lying and/or kept and/or contained at the premises described herein
                                        </label>
                                        </span>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- name of the company --}}


                    <div class="row">
                        <div class="col-md-6">
                            <div class="form_group">
                                <label class="form_label">No of locations <span  style="visibility:hidden">*</span></label>
                                <div class="enter_data">
                                    <p>{{@$pipeline_details['formData']['risk']['noLocations']}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <label class="form_label">Locations of the Risk <span  style="visibility:hidden">*</span></label>
                                <div class="enter_data">
                                    <p>{{@$pipeline_details['formData']['risk']['locationRisk']}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- No of locations --}}

                    <div class="card_separation">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card_sub_head">
                                    <div class="clearfix">
                                        <h3 class="card_sub_heading pull-left">Occupancy</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form_group">
                                    <label class="form_label">Occupancy Type<span  style="visibility:hidden">*</span></label>
                                    <div class="enter_data">
                                        <p>{{@$pipeline_details['formData']['occupancy']['type']}}</p>
                                    </div>
                                </div>
                            </div>
                            @if(@$pipeline_details['formData']['occupancy']['type']=='Others')
                                <div class="col-md-6">
                                    <div class="form_group">
                                        <label class="form_label">Others<span  style="visibility:hidden">*</span></label>
                                        <div class="enter_data">
                                            <p>{{@$pipeline_details['formData']['occupancy']['Others']}}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if(@$pipeline_details['formData']['occupancy']['type']=='Warehouse')
                                <div class="col-md-6">
                                    <div class="form_group">
                                        <label class="form_label">Warehouse Type  <span  style="visibility:hidden">*</span></label>
                                        <div class="enter_data">
                                            <p>{{@$pipeline_details['formData']['occupancy']['warehouseType']}}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form_group">
                                <label class="form_label">Age of the building  <span style="visibility:hidden">*</span></label>
                                <div class="enter_data">
                                    <p>{{@$pipeline_details['formData']['ageBuilding']}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <label class="form_label">No of floors <span  style="visibility:hidden">*</span></label>
                                <div class="enter_data">
                                    <p>{{@$pipeline_details['formData']['noOfFloors']}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Age of the building & No of floors --}}

                    <div class="card_separation">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form_group">
                                    <label class="form_label">Existence about any hazardous material<span  style="visibility:hidden">*</span></label>
                                    <div class="enter_data">
                                        <p>{{@$pipeline_details['formData']['hazardous']['hazardous'] ? "Yes" : "No"}}</p>
                                    </div>
                                </div>
                            </div>
                            @if(@$pipeline_details['formData']['hazardous']['hazardous']=='true')
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form_group">
                                                <label class="form_label bold">Details <span  style="visibility:hidden">*</span></label>
                                                <div class="enter_data">
                                                    <p>{{@$pipeline_details['formData']['hazardous']['hazardous_reason']}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    {{-- Existence about any hazardous material --}}

                    <div class="card_separation" >
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card_sub_head">
                                    <div class="clearfix">
                                        <h3 class="card_sub_heading pull-left">Construction</h3>
                                    </div>
                                </div>
                                <div class="form_group">
                                    <label class="form_label bold">Type of Construction <span  style="visibility:hidden">*</span></label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form_group">
                                    <label class="form_label">Roof<span  style="visibility:hidden">*</span></label>
                                    <div class="enter_data">
                                        <p>{{@$pipeline_details['formData']['constuctionType']['roof']}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <label class="form_label">Walls<span  style="visibility:hidden">*</span></label>
                                    <div class="enter_data">
                                        <p>{{@$pipeline_details['formData']['constuctionType']['wallType']}}</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                        @if(@$pipeline_details['formData']['constuctionType']['wallType']=='Cladding')
                            <div class="row"  id="cladding_show" style="">
                                <div class="col-md-4">
                                    <div class="form_group">
                                        <label class="form_label bold form_text" style="color:#9c27b0">Percentage of Cladding on the overall building exterior wall construction<span style="visibility:hidden">*</span></label>
                                        <div class="enter_data">
                                            <p>{{@$pipeline_details['formData']['constuctionType']['percentageCladding']}}</p>
                                        </div>
                                    </div>
                                </div>
                                @if($pipeline_details['formData']['constuctionType']['percentageCladding']=='Others')
                                <div class="col-md-4">
                                    <div class="form_group">
                                        <label class="form_label bold form_text" style="color:#9c27b0">Other Details<span style="visibility:hidden">*</span></label>
                                        <div class="enter_data">
                                            <p>{{@$pipeline_details['formData']['constuctionType']['percentageCladdingOther']}}</p>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <div class="col-md-4">
                                    <div class="form_group">
                                        <label class="form_label bold form_text" style="color:#9c27b0">Is cladding present vertically or horizontally or a mix of both<span style="visibility:hidden">*</span></label>
                                        <div class="enter_data">
                                            <p>{{@$pipeline_details['formData']['constuctionType']['claddingPresence']}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form_group">
                                        <label class="form_label bold form_text" style="color:#9c27b0">Whether continuous or intermittent breaks have been provided <span style="visibility:hidden">*</span></label>
                                        <div class="enter_data">
                                            <p>{{@$pipeline_details['formData']['constuctionType']['claddingType'] ? "Yes" : "No"}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form_group">
                                        <label class="form_label bold form_text" style="color:#9c27b0">Type of Cladding Materials (ACP / others & etc.) <span style="visibility:hidden">*</span></label>
                                        <div class="enter_data">
                                            <p>{{@$pipeline_details['formData']['constuctionType']['claddingMatType']}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form_group">
                                        <label class="form_label bold form_text" style="color:#9c27b0">Fire rating of the insulation material used in the Cladding  <span style="visibility:hidden">*</span></label>
                                        <div class="enter_data">
                                            <p>{{@$pipeline_details['formData']['constuctionType']['claddingFireRate']}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form_group">
                                        <label class="form_label bold form_text" style="color:#9c27b0">Technical specification of ACP???s especially on the core material involve <span style="visibility:hidden">*</span></label>
                                        <div class="enter_data">
                                            <p>{{@$pipeline_details['formData']['constuctionType']['claddingTechSpec']}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form_group">
                                        <label class="form_label bold form_text" style="color:#9c27b0">Material used for construction (Combustible or Non-combustible). <span style="visibility:hidden">*</span></label>
                                        <div class="enter_data">
                                            <p>{{@$pipeline_details['formData']['constuctionType']['claddingConsMat']}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form_group">
                                        <label class="form_label bold form_text" style="color:#9c27b0">Whether the insulation material or the ACP core is exposed open at any place <span style="visibility:hidden">*</span></label>
                                        <div class="enter_data">
                                            <p>{{@$pipeline_details['formData']['constuctionType']['claddingInsMat']? "Yes" : "No"}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form_group">
                                        <label class="form_label bold form_text" style="color:#9c27b0">Available fire fighting facilities <span style="visibility:hidden">*</span></label>
                                        <div class="enter_data">
                                            <p>{{@$pipeline_details['formData']['constuctionType']['claddingFacilities']}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form_group">
                                    <label class="form_label bold">Floor <span  style="visibility:hidden">*</span></label>
                                    <div class="enter_data">
                                        <p>{{@$pipeline_details['formData']['constuctionType']['floorType']}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <label class="form_label bold">Year of Construction <span  style="visibility:hidden">*</span></label>
                                    <div class="enter_data">
                                        <p>{{@$pipeline_details['formData']['constuctionType']['yearConstruction']}}</p>
                                    </div>
                                </div>
                            </div>

                            {{-- Construction-year of construction --}}


                            <div class="col-md-4" style="display:none">
                                <div class="form_group">
                                    <label class="form_label bold">Number of stories <span  style="visibility:hidden">*</span></label>
                                    <div class="enter_data">
                                        <p>{{@$pipeline_details['formData']['constuctionType']['numberStories']}}</p>
                                    </div>
                                </div>
                            </div>
                            {{-- Construction-Number of stories --}}
                        </div>
                    </div>
                    {{-- Construction --}}


                    <div class="row">

                        <div class="col-md-4">
                            <div class="form_group">
                                <label class="form_label bold">Business Activity<span  style="visibility:hidden">*</span></label>
                                <div class="enter_data">
                                    <p>{{@$pipeline_details['formData']['businessType']}}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card_separation">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card_sub_head">
                                    <div class="clearfix">
                                        <h3 class="card_sub_heading pull-left">Risk Protection Measures</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form_group">
                                    <label class="form_label bold">Safety Signs  <span  style="visibility:hidden">*</span></label>
                                    <div class="enter_data">
                                        <p>{{@$pipeline_details['formData']['safetySigns'] ? "Yes" : "No"}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Safety Signs --}}

                    <div class="row">
                        <div   @if(isset($pipeline_details['formData']['fireFight']['fireFacilities']) && (in_array('others',@$pipeline_details['formData']['fireFight']['fireFacilities'])))
                               class="col-md-3" @else  class="col-md-4" @endif>
                            <div class="form_group">
                                <label class="form_label bold">Available fire fighting facilities <span  style="visibility:hidden">*</span></label>
                                <div class="enter_data">

                                    @foreach (@$pipeline_details['formData']['fireFight']['fireFacilities'] as $item)
                                        <p> {{$item}} </p>
                                    @endforeach
                                    {{-- {{@$pipeline_details['formData']['fireFight']['fireFacilities']}} --}}

                                </div>
                            </div>
                        </div>
                        @if(isset($pipeline_details['formData']['fireFight']['fireFacilities']) && (in_array('others',@$pipeline_details['formData']['fireFight']['fireFacilities'])))
                            <div class="col-md-3">
                                <div class="form_group">
                                    <label class="form_label bold">Other<span  style="visibility:hidden">*</span></label>
                                    <div class="enter_data">
                                        <p>{{@$pipeline_details['formData']['fireFight']['other']}}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div @if(isset($pipeline_details['formData']['fireFight']['fireFacilities']) && (in_array('others',@$pipeline_details['formData']['fireFight']['fireFacilities'])))
                             class="col-md-3" @else  class="col-md-4" @endif>
                            <div class="form_group">
                                <label class="form_label bold">Direct connection to Civil Defence <span  style="visibility:hidden">*</span></label>
                                <div class="enter_data">
                                    <p>{{@$pipeline_details['formData']['civilDefence']? "Yes" : "No"}}</p>
                                </div>
                            </div>
                        </div>
                        {{-- Direct connection to Civil Defence --}}

                        <div @if(isset($pipeline_details['formData']['fireFight']['fireFacilities']) && (in_array('others',@$pipeline_details['formData']['fireFight']['fireFacilities'])))
                             class="col-md-3" @else  class="col-md-4" @endif>
                             <div class="form_group">
                                    <label class="form_label bold">Frequency of removing waste material</label>
                                    <div class="enter_data">
                                    <span> {{@$pipeline_details['formData']['frequency']['time_day']}} time/s a day
                                        {{@$pipeline_details['formData']['frequency']['once_day']}} time/s a week</span>
                                    </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form_group">
                                <label class="form_label bold">Security Guards available <span  style="visibility:hidden">*</span></label>
                                <div class="enter_data">
                                    <p>{{@$pipeline_details['formData']['securityGuard']['securityGuard']}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form_group">
                                <label class="form_label bold">Burglary Alarm <span  style="visibility:hidden">*</span></label>
                                <div class="enter_data">
                                    <p>{{@$pipeline_details['formData']['burglaryAlarm']}}</p>
                                </div>
                            </div>
                        </div>

                        {{-- Burglary Alarm --}}

                        <div class="col-md-4">
                            <div class="form_group">
                                <label class="form_label bold">CCTV <span  style="visibility:hidden">*</span></label>
                                <div class="enter_data">
                                    <p>{{@$pipeline_details['formData']['cctv']}}</p>
                                </div>
                            </div>
                        </div>
                        {{-- CCTV --}}
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form_group">
                                <label class="form_label bold">Electicity usage <span  style="visibility:hidden">*</span></label>
                                <div class="enter_data">
                                    <p>{{@$pipeline_details['formData']['electicity_usage']}}</p>
                                </div>
                            </div>
                        </div>

                        {{-- Electicity usage --}}



                        <div class="col-md-4">
                            <div class="form_group">
                                <label class="form_label bold">Neighborhood <span  style="visibility:hidden">*</span></label>
                                <div class="enter_data">
                                    <table>
                                        <tr>
                                            <td>West </td>
                                            <td>:</td>
                                            <td>{{@$pipeline_details['formData']['neighborhood']['west']}} </td>
                                        </tr>
                                        <tr>
                                            <td>East </td>
                                            <td>:</td>
                                            <td>{{@$pipeline_details['formData']['neighborhood']['east']}} </td>
                                        </tr>
                                        <tr>
                                            <td>South </td>
                                            <td>:</td>
                                            <td>{{@$pipeline_details['formData']['neighborhood']['south']}} </td>
                                        </tr>
                                        <tr>
                                            <td>North </td>
                                            <td>:</td>
                                            <td>{{@$pipeline_details['formData']['neighborhood']['north']}} </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <style>
                            /* KARTHIKA SHIJIN :) */
                            .enter_data table td{
                                vertical-align: top;
                                line-height: 16px;
                                padding: 5px 0;
                            }
                            .enter_data table td:nth-child(2){
                                padding-left: 4px;
                                padding-right: 4px;
                            }
                        </style>

                        {{-- Neighborhood --}}
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form_label bold">Distance to nearest Fire station(kms)<span  style="visibility:hidden">*</span></label>
                                </div>
                                <div class="col-md-12">
                                    <div class="enter_data">
                                        <p>{{@$pipeline_details['formData']['distance']}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Distance to nearest Fire station --}}
                    <div class="card_separation">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form_group">
                                    <label class="form_label bold">Water storage for fire fighting<span  style="visibility:hidden">*</span></label>
                                    <div class="enter_data">
                                        <p>{{@$pipeline_details['formData']['waterSorage']['waterSorage']? "Yes" : "No"}}</p>
                                    </div>
                                </div>
                            </div>
                            @if(@$pipeline_details['formData']['waterSorage']['waterSorage']=='true')
                                <div class="col-md-4">
                                    <div class="form_group">
                                        <label class="form_label bold">Storage capacity details <span  style="visibility:hidden">*</span></label>
                                        <div class="enter_data">
                                            <p>{{@$pipeline_details['formData']['waterSorage']['gallonsValue']}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4" style="display:none">
                                    <div class="form_group">
                                        <label class="form_label bold">Numberical value field for Lts  <span  style="visibility:hidden">*</span></label>
                                        <div class="enter_data">
                                            <p>{{@$pipeline_details['formData']['waterSorage']['ltsValue']}}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                    {{-- Water storage for fire fighting --}}
                    <div class="card_separation">
                            <div class="row">
                                    <div class="col-md-6">
                                            <div class="card_sub_head">
                                                <div class="clearfix">
                                                    <h3 class="card_sub_heading pull-left">Sum Insured and Description</h3>
                                                </div>
                                            </div>
                                        </div>
                            </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form_group">
                                    <label class="form_label">Building including compound walls, fencing  <span  style="visibility:hidden">*</span></label>
                                    <div class="enter_data">
                                        <p>{{number_format(trim(@$pipeline_details['formData']['buildingInclude']),2)}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="form_group">
                                        <label class="form_label">Stock in Trade  <span  style="visibility:hidden">*</span></label>
                                        <div class="enter_data">
                                            <p>{{number_format(trim(@$pipeline_details['formData']['stock']),2)}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form_group">
                                    <label class="form_label">Finished and Semi-Finished Goods  <span  style="visibility:hidden">*</span></label>
                                    <div class="enter_data">
                                        <p>{{number_format(trim(@$pipeline_details['formData']['finishedGoods']),2)}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="form_group">
                                        <label class="form_label">Raw Materials  <span  style="visibility:hidden">*</span></label>
                                        <div class="enter_data">
                                            <p>{{number_format(trim(@$pipeline_details['formData']['rawMaterials']),2)}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form_group">
                                    <label class="form_label">Machinery, Equipments, Tools etc.  <span  style="visibility:hidden">*</span></label>
                                    <div class="enter_data">
                                        <p>{{number_format(trim(@$pipeline_details['formData']['machinery']),2)}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="form_group">
                                        <label class="form_label">Sign Boards <span  style="visibility:hidden">*</span></label>
                                        <div class="enter_data">
                                            <p>{{number_format(trim(@$pipeline_details['formData']['signBoards']),2)}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form_group">
                                    <label class="form_label">Furniture, Fixtures & Fittings & Decoration  <span  style="visibility:hidden">*</span></label>
                                    <div class="enter_data">
                                        <p>{{number_format(trim(@$pipeline_details['formData']['furniture']),2)}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="form_group">
                                        <label class="form_label">Office Equipments including Computers, Fax, Photocopy etc <span  style="visibility:hidden">*</span></label>
                                        <div class="enter_data">
                                            <p>{{number_format(trim(@$pipeline_details['formData']['officeEquipments']),2)}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form_group">
                                    <label class="form_label">Annual Rent  <span  style="visibility:hidden">*</span></label>
                                    <div class="enter_data">
                                        <p>{{number_format(trim(@$pipeline_details['formData']['annualRent']),2)}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <div class="form_group">
                                        <label class="form_label">Total  <span  style="visibility:hidden">*</span></label>
                                        <div class="enter_data">
                                            <p>{{number_format(trim(@$pipeline_details['formData']['total']),2)}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                                <div class="col-md-6">
                                    <div class="form_group">
                                        <div class="form_group">
                                            <label class="form_label">Any other items  <span  style="visibility:hidden">*</span></label>
                                            <div class="enter_data">
                                                <p>{{@$pipeline_details['formData']['otherItems']}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                    {{--  --}}
					<?php
					if(@$pipeline_details['formData']['claimExperienceDetails']=='only_property')
					{
						$heading='Only Property';
					}else  if(@$pipeline_details['formData']['claimExperienceDetails']=='combined_data'){
						$heading='Combined data for Property and Business interruption coverages';
					}
					else  if(@$pipeline_details['formData']['claimExperienceDetails']=='separate_property'){
						$heading='Property ';
					}


					?>
                    <div class="card_separation">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form_group">
                                    <label class="form_label bold">{{$heading}} <span style="visibility: hidden">*</span></label>
                                    <table class="table table-bordered custom_table">
                                        <thead>
                                        <tr>
                                            <th>Year</th>
                                            <th>Claim amount</th>
                                            <th>Description</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>Year 1 </td>
                                            <td>
                                                @if(isset($pipeline_details['formData']['claimsHistory'][0]['claim_amount'])&&(@$pipeline_details['formData']['claimsHistory'][0]['claim_amount'])!="")
                                                    {{number_format(trim(@$pipeline_details['formData']['claimsHistory'][0]['claim_amount']),2)}} @else {{ ' -- '}} @endif</td>
                                            <td>{{@$pipeline_details['formData']['claimsHistory'][0]['description']?:' -- '}}</td>
                                        </tr>

                                        <tr>
                                            <td>Year 2</td>
                                            <td>
                                                @if(isset($pipeline_details['formData']['claimsHistory'][1]['claim_amount'])&&(@$pipeline_details['formData']['claimsHistory'][1]['claim_amount'])!="")
                                                    {{number_format(trim(@$pipeline_details['formData']['claimsHistory'][1]['claim_amount']),2)}} @else {{ ' -- '}}@endif</td>
                                            <td>{{@$pipeline_details['formData']['claimsHistory'][1]['description']?:' -- '}}</td>

                                        </tr>

                                        <tr>
                                            <td>Year 3</td>
                                            <td>
                                                @if(isset($pipeline_details['formData']['claimsHistory'][2]['claim_amount'])&&(@$pipeline_details['formData']['claimsHistory'][2]['claim_amount'])!="")
                                                    {{number_format(trim(@$pipeline_details['formData']['claimsHistory'][2]['claim_amount']),2)}} @else {{ ' -- '}} @endif</td>
                                            <td>{{@$pipeline_details['formData']['claimsHistory'][2]['description']?:' -- '}}</td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(@$pipeline_details['formData']['claimExperienceDetails'] =='separate_property')
                        <div class="card_separation">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form_group">
                                        <label class="form_label bold">FIRE & PERILS <span style="visibility: hidden">*</span></label>
                                        <table class="table table-bordered custom_table">
                                            <thead>
                                            <tr>
                                                <th>Year</th>
                                                <th>Claim amount</th>
                                                <th>Description</th>

                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                               
                                                <td>Year 1 </td>

                                                <td> @if(isset($pipeline_details['formData']['claimsHistory_sep'][0]['claim_amount'])&&(@$pipeline_details['formData']['claimsHistory_sep'][0]['claim_amount'])!="")
                                                        {{number_format(trim(@$pipeline_details['formData']['claimsHistory_sep'][0]['claim_amount']),2)}} @else {{ ' -- '}} @endif</td>
                                                <td>{{@$pipeline_details['formData']['claimsHistory_sep'][0]['description']?:' -- '}}         </td>
                                            </tr>

                                            <tr>
                                                <td>Year 2</td>
                                                <td>
                                                    @if(isset($pipeline_details['formData']['claimsHistory_sep'][1]['claim_amount'])&&(@$pipeline_details['formData']['claimsHistory_sep'][1]['claim_amount'])!="")
                                                        {{number_format(trim(@$pipeline_details['formData']['claimsHistory_sep'][1]['claim_amount']),2)}} @else {{ ' -- '}}@endif</td>
                                                <td> {{@$pipeline_details['formData']['claimsHistory_sep'][1]['description']?:' -- '}}</td>

                                            </tr>

                                            <tr>
                                                <td>Year 3</td>
                                                <td>
                                                    @if(isset($pipeline_details['formData']['claimsHistory_sep'][2]['claim_amount'])&&(@$pipeline_details['formData']['claimsHistory_sep'][2]['claim_amount'])!="")
                                                        {{number_format(trim(@$pipeline_details['formData']['claimsHistory_sep'][2]['claim_amount']),2)}} @else {{ ' -- '}}@endif</td>
                                                <td>  {{@$pipeline_details['formData']['claimsHistory_sep'][2]['description']?:' -- '}}</td>
                                            </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    {{--Claims experience --}}



                    {{-- file upload --}}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form_group">
                                @if(in_array('CIVIL DEFENSE COMPLIANCE CERTIFICATE',$file_name))
									<?php $key = array_search('CIVIL DEFENSE COMPLIANCE CERTIFICATE', $file_name) ?>
                                    @if($file_url[$key]!='')
                                        <input type="hidden" value="{{$file_url[$key]}}" id="civil_url" name="civil_url">
                                        <span class="pull-right" id="saved_civil_list">
                                            <a target="_blank" href="{{$file_url[$key]}}">
                                            <i class="fa fa-file"></i>
                                            </a>
                                            </span>
                                    @endif
                                    @endif
                                    <label class="form_label">Copy of Civil Defense compliance certificate <span >*</span></label>
                                    <div class="custom_upload">
                                        <input type="file" name="civil_certificate" id="civil_certificate" onchange="upload_file(this)">
                                        <p id="civil_p">Drag your files or click here.</p>
                                    </div>
                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="form_group">
                                @if(in_array('COPY OF THE POLICY',$file_name))
									<?php $key = array_search('COPY OF THE POLICY', $file_name) ?>
                                    @if($file_url[$key]!='')
                                        <input type="hidden" value="{{$file_url[$key]}}" id="policy_url" name="policy_url">
                                        <span class="pull-right" id="saved_policy_list">
                                                        <a target="_blank" href="{{$file_url[$key]}}">
                                                        <i class="fa fa-file"></i>
                                                        </a>
                                                        </span>
                                        @endif
                                        @endif
                                    <label class="form_label">Copy of the policy if possible (upload)<span >*</span></label>
                                    <div class="custom_upload">
                                        <input type="file" name="policyCopy" id="policyCopy" onchange="upload_file(this)">
                                        <p id="policy_p">Drag your files or click here.</p>
                                    </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form_group">
                                @if(in_array('TRADE LICENSE',$file_name))
									<?php $key = array_search('TRADE LICENSE', $file_name) ?>
                                    @if($file_url[$key]!='')
                                        <input type="hidden" value="{{$file_url[$key]}}" id="trade_url" name="trade_url">
                                        <span class="pull-right" id="saved_trade_list">
                                                        <a target="_blank" href="{{$file_url[$key]}}">
                                                        <i class="fa fa-file"></i>
                                                        </a>
                                                        </span>
                                            @endif

                                    @endif
                                    <label class="form_label">Copy of trade license <span >*</span></label>
                                    <div class="custom_upload">
                                        <input type="file" name="trade_list" id="trade_list" onchange="upload_file(this)">
                                        <p id="trade_list_p">Drag your files or click here.</p>
                                    </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form_group">
                                @if(in_array('VAT CERTIFICATE/TRN',$file_name))
									<?php $key = array_search('VAT CERTIFICATE/TRN', $file_name) ?>
                                    @if($file_url[$key]!='')
                                        <input type="hidden" value="{{$file_url[$key]}}" id="vat_url" name="vat_url">
                                        <span class="pull-right" id="saved_vat_list">
                                                    <a target="_blank" href="{{$file_url[$key]}}">
                                                    <i class="fa fa-file"></i>
                                                    </a>
                                                    </span>
                                        @endif

                                    @endif
                                    <label class="form_label">Copy of VAT Certificate/TRN <span >*</span></label>
                                    <div class="custom_upload">
                                        <input type="file" name="vat_copy" id="vat_copy" onchange="upload_file(this)">
                                        <p id="vat_copy_p">Drag your files or click here.</p>
                                    </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form_group">
                                @if(in_array('OTHERS 1',$file_name))
									<?php $key = array_search('OTHERS 1', $file_name) ?>
                                    @if($file_url[$key]!='')
                                        <input type="hidden" value="{{$file_url[$key]}}" id="other1_url" name="other1_url">
                                        <span class="pull-right" id="saved_other1_list">
                                        <a target="_blank" href="{{$file_url[$key]}}">
                                        <i class="fa fa-file"></i>
                                        </a>
                                        </span>
                                        @endif

                                    @endif
                                    <label class="form_label">Others 1 <span >*</span></label>
                                    <div class="custom_upload">
                                        <input type="file" name="others1" id="others1" onchange="upload_file(this)">
                                        <p id="others1_p">Drag your files or click here.</p>
                                    </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form_group">
                                @if(in_array('OTHERS 2',$file_name))
									<?php $key = array_search('OTHERS 2', $file_name) ?>
                                    @if($file_url[$key]!='')
                                        <input type="hidden" value="{{$file_url[$key]}}" id="other2_url" name="other2_url">
                                        <span class="pull-right" id="saved_other2_list">
                                            <a target="_blank" href="{{$file_url[$key]}}">
                                            <i class="fa fa-file"></i>
                                            </a>
                                            </span>
                                        @endif

                                    @endif
                                    <label class="form_label">Others 2 <span >*</span></label>
                                    <div class="custom_upload">
                                        <input type="file" name="others2" id="others2" onchange="upload_file(this)">
                                        <p id="others2_p">Drag your files or click here.</p>
                                    </div>
                            </div>
                        </div>
                    </div>

                    {{-- file upload --}}




                    <div class="row">
                        <div class="col-md-4">
                            <div class="form_group">
                                <div class="form_group">
                                    <label class="form_label" style="min-height: 40px">Adjoining building clause  <span>*</span></label>
                                    <div class="enter_data">
                                        <input class="form_input" placeholder="" name="adj_business_caluse" id="adj_business_caluse"  type="text" @if(isset($pipeline_details['formData']['adjBusinessClause']) && 
                                        $pipeline_details['formData']['adjBusinessClause']!='') value="{{$pipeline_details['formData']['adjBusinessClause']}}" @endif>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(isset($pipeline_details['formData']['stock']) && $pipeline_details['formData']['stock']!='')
                            <div class="col-md-4">
                                <div class="form_group">
                                    <div class="form_group">
                                        <label class="form_label" style="min-height: 40px">Stock Declaration clause  <span>*</span></label>
                                        <div class="enter_data">
                                            <input class="form_input" placeholder=""  name="stock_declaration" id="stock_declaration"  @if(isset($pipeline_details['formData']['stockDeclaration']) && 
                                            $pipeline_details['formData']['stockDeclaration']!='') value="{{$pipeline_details['formData']['stockDeclaration']}}" @endif>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if(isset($pipeline_details['formData']['annualRent']) &&  $pipeline_details['formData']['annualRent']!='')
                            <div class="col-md-4">
                                <div class="form_group">
                                    <div class="form_group">
                                        <label class="form_label" style="min-height: 40px">Loss of rent  <span>*</span></label>
                                        <div class="enter_data">
                                            <input class="form_input"  placeholder="" name="loss_rent" id="loss_rent"  type="text" @if(isset($pipeline_details['formData']['lossRent']) && 
                                            $pipeline_details['formData']['lossRent']!='') value="{{$pipeline_details['formData']['lossRent']}}" @endif>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>
                    @if($pipeline_details['formData']['businessType']=="Hotels/ boarding houses/ motels/ service apartments" || 
                    $pipeline_details['formData']['businessType']=="Hotel multiple cover")
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="form_group">
                                        <label class="form_label" style="min-height: 40px">Cover for personal effects of staff / guests property / valuables  <span>*</span></label>
                                        <div class="enter_data">
                                            <input class="form_input" placeholder="" required name="personal_staff" id="personal_staff"  type="text"  @if(isset($pipeline_details['formData']['personalStaff']) && 
                                            $pipeline_details['formData']['personalStaff']!='') value="{{$pipeline_details['formData']['personalStaff']}}" @endif>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="form_group">
                                        <label class="form_label" style="min-height: 40px">Cover to include unregistered motorised vehicles (like passenger, luggage, laundry carts) used on or around the premises  <span>*</span></label>
                                        <div class="enter_data">
                                            <input class="form_input" placeholder="" required name="cover_include" id="cover_include"  type="text" @if(isset($pipeline_details['formData']['coverInclude']) && 
                                            $pipeline_details['formData']['coverInclude']!='') value="{{$pipeline_details['formData']['coverInclude']}}" @endif>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="row">
                                                            @if($pipeline_details['formData']['businessType']=="Cafes & Restaurant"
                                    || $pipeline_details['formData']['businessType']=="Clothing manufacturing"
                                    || $pipeline_details['formData']['businessType']=="Computer hardware trading/ sales"
                                    || $pipeline_details['formData']['businessType']=="Confectionery/ dairy products processing"
                                    || $pipeline_details['formData']['businessType']=="Cotton ginning wool/ textile manufacturing"
                                    || $pipeline_details['formData']['businessType']=="Department stores/ shopping malls"
                                    || $pipeline_details['formData']['businessType']=="Food & beverage manufacturers"
                                    || $pipeline_details['formData']['businessType']=="Hotels/ boarding houses/ motels/ service apartments"
                                    || $pipeline_details['formData']['businessType']=="Hotel multiple cover"
                                    || $pipeline_details['formData']['businessType']=="Livestock"
                                    || $pipeline_details['formData']['businessType']=="Mega malls & commercial centers"
                                    || $pipeline_details['formData']['businessType']=="Recreational clubs/Theme & water parks"
                                    || $pipeline_details['formData']['businessType']=="Restaurant/ catering services"
                                    || $pipeline_details['formData']['businessType']=="Souk and similar markets"
                                    || $pipeline_details['formData']['businessType']=="Supermarkets / hypermarket/ other retail shops"
                                    || $pipeline_details['formData']['businessType']=="Textile mills/ traders/ sales"
                                    || $pipeline_details['formData']['businessType']=="Warehouse/ cold storage"
                                    )

                            <div class="col-md-4">
                                <div class="form_group">
                                    <div class="form_group">
                                        <label class="form_label" style="min-height: 40px">Seasonal increase in stocks <span>*</span></label>
                                        <div class="enter_data">
                                            <input class="form_input" placeholder=""  required name="seasonal_increase" id="seasonal_increase"  type="text" @if(isset($pipeline_details['formData']['seasonalIncrease']) && 
                                            $pipeline_details['formData']['seasonalIncrease']!='') value="{{$pipeline_details['formData']['seasonalIncrease']}}" @endif>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if(@$pipeline_details['formData']['occupancy']['type']=='Residence')
                            <div class="col-md-4">
                                <div class="form_group">
                                    <div class="form_group">
                                        <label class="form_label" style="min-height:40px">Cover for alternative accommodation  <span>*</span></label>
                                        <div class="enter_data">
                                            <input class="form_input" placeholder="" name="cover_alternative" id="cover_alternative" required type="text" @if(isset($pipeline_details['formData']['coverAlternative']) && 
                                            $pipeline_details['formData']['coverAlternative']!='') value="{{$pipeline_details['formData']['coverAlternative']}}" @endif>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                                                    @if($pipeline_details['formData']['businessType']=="Cafes & Restaurant"
                            || $pipeline_details['formData']['businessType']=="Clothing manufacturing"
                            || $pipeline_details['formData']['businessType']=="Computer hardware trading/ sales"
                            || $pipeline_details['formData']['businessType']=="Confectionery/ dairy products processing"
                            || $pipeline_details['formData']['businessType']=="Cotton ginning wool/ textile manufacturing"
                            || $pipeline_details['formData']['businessType']=="Department stores/ shopping malls"
                            || $pipeline_details['formData']['businessType']=="Food & beverage manufacturers"
                            || $pipeline_details['formData']['businessType']=="Hotels/ boarding houses/ motels/ service apartments"
                            || $pipeline_details['formData']['businessType']=="Hotel multiple cover"
                            || $pipeline_details['formData']['businessType']=="Livestock"
                            || $pipeline_details['formData']['businessType']=="Mega malls & commercial centers"
                            || $pipeline_details['formData']['businessType']=="Recreational clubs/Theme & water parks"
                            || $pipeline_details['formData']['businessType']=="Restaurant/ catering services"
                            || $pipeline_details['formData']['businessType']=="Souk and similar markets"
                            || $pipeline_details['formData']['businessType']=="Supermarkets / hypermarket/ other retail shops"
                            || $pipeline_details['formData']['businessType']=="Textile mills/ traders/ sales"
                            || $pipeline_details['formData']['businessType']=="Warehouse/ cold storage"
                            )
                            <div class="col-md-4">
                                <div class="form_group">
                                    <div class="form_group">
                                        <label class="form_label" style="min-height: 40px">Cover for exhibition risks  <span>*</span></label>
                                        <div class="enter_data">
                                            <input class="form_input" placeholder="" required name="cover_exihibition" id="cover_exihibition"  type="text" @if(isset($pipeline_details['formData']['coverExihibition']) && 
                                            $pipeline_details['formData']['coverExihibition']!='') value="{{$pipeline_details['formData']['coverExihibition']}}" @endif>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="row">
                        @if(@$pipeline_details['formData']['occupancy']['type']=='Warehouse'
                        ||  @$pipeline_details['formData']['occupancy']['type']=='Factory'
                        ||  @$pipeline_details['formData']['occupancy']['type']=='Others')
                                                    <div class="col-md-4">
                                <div class="form_group">
                                    <div class="form_group">
                                        <label class="form_label" style="min-height: 40px">Cover for property in the open<span>*</span></label>
                                        <div class="enter_data">
                                            <input class="form_input" required placeholder="" name="cover_property" id="cover_property"  type="text" @if(isset($pipeline_details['formData']['coverProperty']) && 
                                            $pipeline_details['formData']['coverProperty']!='') value="{{$pipeline_details['formData']['coverProperty']}}" @endif>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if(@$form_data['otherItems']!='')
                            <div class="col-md-4">
                                <div class="form_group">
                                    <div class="form_group">
                                        <label class="form_label" style="min-height: 40px">Including property in the care, custody & control of the insured  <span>*</span></label>
                                        <div class="enter_data">
                                            <input class="form_input" placeholder="" required name="property_care" id="property_care"  type="text"@if(isset($pipeline_details['formData']['propertyCare']) && 
                                            $pipeline_details['formData']['propertyCare']!='') value="{{$pipeline_details['formData']['propertyCare']}}" @endif>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="col-md-4">
                            <div class="form_group">
                                <div class="form_group">
                                    <label class="form_label" style="min-height: 40px">Loss payee clause  <span>*</span></label>
                                    <div class="enter_data">
                                        <input class="form_input" placeholder="" name="loss_payee" id="loss_payee"  type="text" @if(isset($pipeline_details['formData']['lossPayee']) && 
                                        $pipeline_details['formData']['lossPayee']!='') value="{{$pipeline_details['formData']['lossPayee']}}" @endif>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        @if($pipeline_details['formData']['businessType']=="Art galleries/ fine arts collection"
                                    || $pipeline_details['formData']['businessType']=="Colleges/ Universities/ schools & educational institute"
                                    || $pipeline_details['formData']['businessType']=="Hotels/ boarding houses/ motels/ service apartments"
                                    || $pipeline_details['formData']['businessType']=="Hotel multiple cover"
                                    || $pipeline_details['formData']['businessType']=="Museum/ heritage sites"
                                    )
                                                                <div class="col-md-6">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox"  name="cover_curios" value="true" id="cover_curios" class="inp-cbx" @if(isset($pipeline_details['formData']['coverCurios']) && 
                                            $pipeline_details['formData']['coverCurios']==true) checked @endif style="display: none">
                                            <label for="cover_curios" class="cbx">
                                            <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                            </span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">Cover for curios and work of art</label>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox"  name="indemnity_owner" value="true" id="indemnity_owner" class="inp-cbx" @if(isset($pipeline_details['formData']['indemnityOwner']) && 
                                        $pipeline_details['formData']['indemnityOwner']==true) checked @endif  style="display: none">
                                        <label for="indemnity_owner" class="cbx">
                                        <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">
                                        Indemnity to owners and principals
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox"  name="conduct_clause" value="true" id="conduct_clause" class="inp-cbx"  @if(isset($pipeline_details['formData']['conductClause']) && 
                                        $pipeline_details['formData']['conductClause']==true) checked @endif style="display: none">
                                        <label for="conduct_clause" class="cbx">
                                            <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                            </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Conduct of business clause</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" onclick="return false" checked name="sale_clause" value="true" id="sale_clause" class="inp-cbx" style="display: none">
                                        <label for="sale_clause" class="cbx">
                                        <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">
                                        Sale of interest clause
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" onclick="return false" checked name="fire_brigade" value="true" id="fire_brigade" class="inp-cbx" style="display: none">
                                        <label for="fire_brigade" class="cbx">
                                        <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Fire brigade and extinguishing clause</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" onclick="return false" checked name="clause_wording" value="true" id="clause_wording" class="inp-cbx" style="display: none">
                                        <label for="clause_wording" class="cbx">
                                            <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                            </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">
                                        72 Hours clause-wording modified- the 72 hours will stretch beyond the expiration of the policy period provided the first earthquake/flood/storm occurred prior to the expiry time of the policy.
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" onclick="return false" checked name="automatic_reinstatement" value="true" id="automatic_reinstatement" class="inp-cbx" style="display: none">
                                        <label for="automatic_reinstatement" class="cbx">
                                        <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Automatic reinstatement of sum insured at pro-rata additional premium</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" onclick="return false" checked name="capital_clause" value="true" id="capital_clause" class="inp-cbx" style="display: none">
                                        <label for="capital_clause" class="cbx">
                                                    <span>
                                                    <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                    <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                    </svg>
                                                    </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">
                                        Capital addition clause
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" onclick="return false" checked name="main_clause" value="true" id="main_clause" class="inp-cbx" style="display: none">
                                        <label for="main_clause" class="cbx">
                                                        <span>
                                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                        </svg>
                                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Workmen???s Maintenance clause</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" onclick="return false" checked name="repair_cost" value="true" id="repair_cost" class="inp-cbx" style="display: none">
                                        <label for="repair_cost" class="cbx">
                                        <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">
                                        Repair investigation costs
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" onclick="return false" checked name="debris" value="true" id="debris" class="inp-cbx" style="display: none">
                                        <label for="debris" class="cbx">
                                            <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                            </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Removal of debris</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" onclick="return false" checked name="reinstatement_val_class" value="true" id="reinstatement_val_class" class="inp-cbx" style="display: none">
                                        <label for="reinstatement_val_class" class="cbx">
                                                    <span>
                                                    <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                    <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                    </svg>
                                                    </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">
                                        Reinstatement Value  clause (85% condition of  average)
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" onclick="return false" checked name="waiver" value="true" id="waiver" class="inp-cbx" style="display: none">
                                        <label for="waiver" class="cbx">
                                                            <span>
                                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                            </svg>
                                                            </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Waiver  of subrogation (against affiliates and subsidiaries)</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" onclick="return false" checked name="public_clause" value="true" id="public_clause" class="inp-cbx" style="display: none">
                                        <label for="public_clause" class="cbx">
                                        <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">
                                        Public authorities clause
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" onclick="return false" checked name="contents_clause" value="true" id="contents_clause" class="inp-cbx" style="display: none">
                                        <label for="contents_clause" class="cbx">
                                        <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">All other contents clause</label>
                                </div>
                            </div>
                        </div>
                        @if($form_data['buildingInclude']!='')
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" onclick="return false" checked name="error_omission" value="true" id="error_omission" class="inp-cbx" style="display: none">
                                            <label for="error_omission" class="cbx">
                                                <span>
                                                <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                </svg>
                                                </span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">
                                            Errors & Omissions
                                        </label>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" onclick="return false" checked name="alteration_clause" value="true" id="alteration_clause" class="inp-cbx" style="display: none">
                                        <label for="alteration_clause" class="cbx">
                                            <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                            </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Alteration and use  clause</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" onclick="return false" checked name="trade_access" value="true" id="trade_access" class="inp-cbx" style="display: none">
                                        <label for="trade_access" class="cbx">
                                        <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">
                                        Trace and Access
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" onclick="return false" checked name="temp_removal"  value="true" id="temp_removal" class="inp-cbx" style="display: none">
                                        <label for="temp_removal" class="cbx">
                                                <span>
                                                <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                </svg>
                                                </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Temporary repair clause</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" onclick="return false" checked name="prof_fee" value="true" id="prof_fee" class="inp-cbx" style="display: none">
                                        <label for="prof_fee" class="cbx">
                            <span>
                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                            </svg>
                            </span>
                                                                    </label>
                                    </div>
                                    <label class="form_label bold">
                                        Professional fees clause
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" onclick="return false" checked name="expense_clause" value="true" id="expense_clause" class="inp-cbx" style="display: none">
                                        <label for="expense_clause" class="cbx">
                                        <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Expediting expense clause</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" onclick="return false" checked name="desig_clause" value="true" id="desig_clause" class="inp-cbx" style="display: none">
                                        <label for="desig_clause" class="cbx">
                                        <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">
                                        Designation of property clause
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" onclick="return false" checked name="cancel_thirty_clause" value="true" id="cancel_thirty_clause" class="inp-cbx" style="display: none">
                                        <label for="cancel_thirty_clause" class="cbx">
                                        <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Cancellation clause-30 days either party subject to pro-rata refund of premium in either case unless a claim attached</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" onclick="return false" checked name="primary_insurance_clause" value="true" id="primary_insurance_clause" class="inp-cbx" style="display: none">
                                        <label for="primary_insurance_clause" class="cbx">
                                <span>
                                <svg width="10px" height="8px" viewBox="0 0 12 10">
                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                </svg>
                                </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">
                                        Primary insurance clause
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" onclick="return false" checked name="payment_account_clause" value="true" id="payment_account_clause" class="inp-cbx" style="display: none">
                                        <label for="payment_account_clause" class="cbx">
                                        <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Payment on account clause</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" onclick="return false" checked name="non_invalid_clause" value="true" id="non_invalid_clause" class="inp-cbx" style="display: none">
                                        <label for="non_invalid_clause" class="cbx">
                        <span>
                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                        </svg>
                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">
                                        Non-invalidation clause
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" onclick="return false" checked name="warranty_condition_clause" value="true" id="warranty_condition_clause" class="inp-cbx" style="display: none">
                                        <label for="warranty_condition_clause" class="cbx">
                                            <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                            </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Breach of warranty or condition clause</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" onclick="return false" checked name="escalation_clause" value="true" id="escalation_clause" class="inp-cbx" style="display: none">
                                        <label for="escalation_clause" class="cbx">
                                        <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">
                                        Escalation clause
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" onclick="return false" checked name="add_interest_clause" value="true" id="add_interest_clause" class="inp-cbx" style="display: none">
                                        <label for="add_interest_clause" class="cbx">
                                        <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Additional Interest Clause</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" onclick="return false" checked name="improvement_clause" value="true" id="improvement_clause" class="inp-cbx" style="display: none">
                                        <label for="improvement_clause" class="cbx">
                                                    <span>
                                                    <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                    <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                    </svg>
                                                    </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">
                                        Improvement and betterment  clause
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" onclick="return false" checked name="automaticClause" value="true" id="automaticClause" class="inp-cbx" style="display: none">
                                        <label for="automaticClause" class="cbx">
                                            <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                            </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Automatic Addition deletion clause to be notified within 30 days period</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" onclick="return false" checked name="reduse_lose_clause" value="true" id="reduse_lose_clause" class="inp-cbx" style="display: none">
                                        <label for="reduse_lose_clause" class="cbx">
                                                        <span>
                                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                        </svg>
                                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">
                                        Expense to reduce the loss clause
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        @if($form_data['buildingInclude']!='')
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" onclick="return false" checked name="demolition_clause" value="true" id="demolition_clause" class="inp-cbx" style="display: none">
                                            <label for="demolition_clause" class="cbx">
                                            <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                            </span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">Demolition clause</label>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" onclick="return false" checked name="no_control_clause" value="true" id="no_control_clause" class="inp-cbx" style="display: none">
                                        <label for="no_control_clause" class="cbx">
                                        <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">
                                        No control clause
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" onclick="return false" checked name="preparation_cost_clause" value="true" id="preparation_cost_clause" class="inp-cbx" style="display: none">
                                        <label for="preparation_cost_clause" class="cbx">
                                            <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                            </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Claims preparation cost clause</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" onclick="return false" checked name="cover_property_con" value="true" id="cover_property_con" class="inp-cbx" style="display: none">
                                        <label for="cover_property_con" class="cbx">
                                            <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                            </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">
                                        Cover for property lying in the premises in containers
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" onclick="return false" checked name="personal_effects_employee" value="true" id="personal_effects_employee" class="inp-cbx" style="display: none">
                                        <label for="personal_effects_employee" class="cbx">
                                        <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Personal effects of employee including tools and bicycles</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" onclick="return false" checked name="incident_land_transit" value="true" id="incident_land_transit" class="inp-cbx" style="display: none">
                                        <label for="incident_land_transit" class="cbx">
                                            <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                            </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">
                                        Incidental Land Transit
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" onclick="return false" checked name="loss_or_damage" value="true" id="loss_or_damage" class="inp-cbx" style="display: none">
                                        <label for="loss_or_damage" class="cbx">
                                            <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                            </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Including loss or damage due to subsidence, ground heave or landslip</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" onclick="return false" checked name="nominated_loss_adjuster_clause" value="true" id="nominated_loss_adjuster_clause" class="inp-cbx" style="display: none">
                                        <label for="nominated_loss_adjuster" class="cbx">
                                        <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">
                                        Nominated Loss Adjuster clause-Insured can select the loss surveyor out of a panel ??? John Kidd LA, Cunningham Lindsey, & Miller International
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" onclick="return false" checked="" name="sprinker_leakage" value="true" id="sprinker_leakage" class="inp-cbx" style="display: none">
                                        <label for="sprinker_leakage" class="cbx">
                                            <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                            </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Sprinkler leakage clause</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" onclick="return false" checked name="min_loss_clause" value="true" id="min_loss_clause" class="inp-cbx" style="display: none">
                                        <label for="min_loss_clause" class="cbx">
                                        <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">
                                        Minimization of loss clause
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" onclick="return false" checked name="cost_construction" value="true" id="cost_construction" class="inp-cbx" style="display: none">
                                        <label for="cost_construction" class="cbx">
                                                <span>
                                                <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                </svg>
                                                </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Increased cost of construction</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" onclick="return false" checked name="property_valuation_clause" value="true" id="property_valuation_clause" class="inp-cbx" style="display: none">
                                        <label for="property_valuation_clause" class="cbx">
                                        <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">
                                        Property Valuation clause
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" onclick="return false" checked name="accidental_damage" value="true" id="accidental_damage" class="inp-cbx" style="display: none">
                                        <label for="accidental_damage" class="cbx">
                                            <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                            </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Including accidental damage to plate glass, interior and exterior signs</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" onclick="return false" checked name="auditors_fee" value="true" id="auditors_fee" class="inp-cbx" style="display: none">
                                        <label for="auditors_fee" class="cbx">
                                                <span>
                                                <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                </svg>
                                                </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">
                                        Auditor???s fee
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" onclick="return false" checked name="smoke_soot" value="true" id="smoke_soot" class="inp-cbx" style="display: none">
                                        <label for="smoke_soot" class="cbx">
                                            <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                            </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Smoke and Soot damage extension</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" onclick="return false" checked name="boiler_explosion" value="true" id="boiler_explosion" class="inp-cbx" style="display: none">
                                        <label for="boiler_explosion" class="cbx">
                                                                <span>
                                                                <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                                </svg>
                                                                </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">
                                        Boiler explosion extension
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" onclick="return false" checked name="charge_airfreight" value="true" id="charge_airfreight" class="inp-cbx" style="display: none">
                                        <label for="charge_airfreight" class="cbx">
                                        <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Extra charges for airfreight</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" onclick="return false" checked name="strike_riot" value="true" id="strike_riot" class="inp-cbx" style="display: none">
                                        <label for="strike_riot" class="cbx">
                                        <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Strike riot and civil commotion clause</label>
                                </div>
                            </div>
                        </div>

                        @if($form_data['machinery']!='')
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" onclick="return false" checked name="malicious_damage" value="true" id="malicious_damage" class="inp-cbx" style="display: none">
                                            <label for="malicious_damage" class="cbx">
                                            <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                            </span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">
                                            Malicious damage / mischief, vandalism
                                        </label>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    @if($form_data['machinery']!='')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" onclick="return false" checked name="burglary_extension" value="true" id="burglary_extension" class="inp-cbx" style="display: none">
                                            <label for="burglary_extension" class="cbx">
                                            <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                            </span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">Burglary Extension</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" onclick="return false" checked name="burglary_facilities" value="true" id="burglary_facilities" class="inp-cbx" style="display: none">
                                            <label for="burglary_facilities" class="cbx">
                                            <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                            </span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">
                                            Burglary Extension for diesel tank and similar storage facilities in the open
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" onclick="return false" checked name="tsunami" value="true" id="tsunami" class="inp-cbx" style="display: none">
                                            <label for="tsunami" class="cbx">
                                                    <span>
                                                    <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                    <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                    </svg>
                                                    </span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">Tsunami</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" onclick="return false" checked name="mobile_plant" value="true" id="mobile_plant" class="inp-cbx" style="display: none">
                                            <label for="mobile_plant" class="cbx">
                                                                <span>
                                                                <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                                </svg>
                                                                </span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">
                                            Cover for mobile plant
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" onclick="return false" checked name="clearance_drains" value="true" id="clearance_drains" class="inp-cbx" style="display: none">
                                            <label for="clearance_drains" class="cbx">
                                            <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                            </span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">Clearance of drains</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" onclick="return false" checked name="accidental_fire" value="true" id="accidental_fire" class="inp-cbx" style="display: none">
                                            <label for="accidental_fire" class="cbx">
                                            <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                            </span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">
                                            Accidental discharge of fire protection
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" onclick="return false" checked name="locationg_source" value="true" id="locationg_source" class="inp-cbx" style="display: none">
                                            <label for="locationg_source" class="cbx">
                                            <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                            </span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">Locating source of leak</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" onclick="return false" checked name="re_writing" value="true" id="re_writing" class="inp-cbx" style="display: none">
                                                <label for="re_writing" class="cbx">
                                                        <span>
                                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                        </svg>
                                                        </span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">
                                            Re-writing of records
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" onclick="return false" checked name="land_slip" value="true" id="land_slip" class="inp-cbx" style="display: none">
                                                <label for="land_slip" class="cbx">
                                                <span>
                                                <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                </svg>
                                                </span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">Landslip full subsidence and ground heave</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" onclick="return false" checked name="civil_authority" value="true" id="civil_authority" class="inp-cbx" style="display: none">
                                            <label for="civil_authority" class="cbx">
                                            <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                            </span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">
                                            Civil authority clause
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" onclick="return false" checked name="documents_plans" value="true" id="documents_plans" class="inp-cbx" style="display: none">
                                            <label for="documents_plans" class="cbx">
                                            <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                            </span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">Documents / plans / specification clause</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" onclick="return false" checked name="property_construction" value="true" id="property_construction" class="inp-cbx" style="display: none">
                                            <label for="property_construction" class="cbx">
                                            <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                            </span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">
                                            Property held intrust for comission
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" onclick="return false" checked name="architecture" value="true" id="architecture" class="inp-cbx" style="display: none">
                                            <label for="architecture" class="cbx">
                                                <span>
                                                <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                </svg>
                                                </span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">Architecture or surveyor, consulting engineer & other professional fee</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" onclick="return false" checked name="automatic_extension" value="true" id="automatic_extension" class="inp-cbx" style="display: none">
                                            <label for="automatic_extension" class="cbx">
                                                <span>
                                                <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                </svg>
                                                </span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">
                                            Automatic extension for one month
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" onclick="return false" checked name="mortguage_clause" value="true" id="mortguage_clause" class="inp-cbx" style="display: none">
                                            <label for="mortguage_clause" class="cbx">
                                                <span>
                                                <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                </svg>
                                                </span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">Mortgage clause</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" onclick="return false" checked name="survey_committee" value="true" id="survey_committee" class="inp-cbx" style="display: none">
                                            <label for="survey_committee" class="cbx">
                                                <span>
                                                <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                </svg>
                                                </span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">
                                            Survey committee clause
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" onclick="return false" checked name="protect_expense" value="true" id="protect_expense" class="inp-cbx" style="display: none">
                                            <label for="protect_expense" class="cbx">
                                            <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                            </span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">Expense to protect preserve or reduce the loss</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" onclick="return false" checked name="tenats_clause" value="true" id="tenats_clause" class="inp-cbx" style="display: none">
                                            <label for="tenats_clause" class="cbx">
                                    <span>
                                    <svg width="10px" height="8px" viewBox="0 0 12 10">
                                    <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                    </svg>
                                    </span>
                                                                                </label>
                                        </div>
                                        <label class="form_label bold">
                                            Tenants Clause
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" onclick="return false" checked name="keys_lock_clause" value="true" id="keys_lock_clause" class="inp-cbx" style="display: none">
                                            <label for="keys_lock_clause" class="cbx">
                                        <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                        </span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">Keys and Lock replacement clause</label>
                                    </div>
                                </div>
                            </div>
                            @if($form_data['occupancy']['type'] == "Building")
                                <div class="col-md-6">
                                    <div class="form_group">
                                        <div class="flex_sec">
                                            <div class="custom_checkbox">
                                                <input type="checkbox" onclick="return false" checked name="fit_out_works" value="true" id="fit_out_works" class="inp-cbx" style="display: none">
                                                <label for="fit_out_works" class="cbx">
                                                <span>
                                                <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                </svg>
                                                </span>
                                                </label>
                                            </div>
                                            <label class="form_label bold">
                                                During fit out works, renovation works, or any alteration/repairs all losses above the limit of the PESP of CAR should be covered under the property
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" onclick="return false" checked name="exploratory_cost" value="true" id="exploratory_cost" class="inp-cbx" style="display: none">
                                            <label for="exploratory_cost" class="cbx">
                                                        <span>
                                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                        </svg>
                                                        </span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">Exploratory Cost</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" onclick="return false" checked name="cover_status" value="true" id="cover_status" class="inp-cbx" style="display: none">
                                            <label for="cover_status" class="cbx">
                                            <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                            </span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">
                                            cover for bursting,overflowing, discharging,or leaking of water tanks apparatus or pipes when premises are empty or disused
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" onclick="return false" checked name="property_details" value="true" id="property_details" class="inp-cbx" style="display: none">
                                            <label for="property_details" class="cbx">
                                                    <span>
                                                    <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                    <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                    </svg>
                                                    </span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">Property in the open or open sided sheds other than building structure and machineries which are designed to exist and to operate in the open</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" onclick="return false" checked name="smoke_soot_damage" value="true" id="smoke_soot_damage" class="inp-cbx" style="display: none">
                                            <label for="smoke_soot_damage" class="cbx">
                                                            <span>
                                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                            </svg>
                                                            </span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">
                                            Smoke and soot damage extension
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" onclick="return false" checked name="impact_damage" value="true" id="impact_damage" class="inp-cbx" style="display: none">
                                            <label for="impact_damage" class="cbx">
                                                    <span>
                                                    <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                    <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                    </svg>
                                                    </span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">Impact damage due to own vehicle and / or animals / third party vehicles</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" onclick="return false" checked name="curious_work_art" value="true" id="curious_work_art" class="inp-cbx" style="display: none">
                                            <label for="curious_work_art" class="cbx">
                                        <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                        </span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">
                                            curious and work of art
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" onclick="return false" checked name="sprinkler_inoperative_clause" value="true" id="sprinkler inoperative sprinkler_inoperative_clause" class="inp-cbx" style="display: none">
                                            <label for="sprinkler_inoperative_clause" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">sprinkler inoperative clause</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" onclick="return false" checked name="sprinkler_upgradation" value="true" id="sprinkler_upgradation" class="inp-cbx" style="display: none">
                                            <label for="sprinkler_upgradation" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">
                                            Sprinkler upgradation
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" onclick="return false" checked name="fire_protection" value="true" id="fire_protection" class="inp-cbx" style="display: none">
                                            <label for="fire_protection" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">Fire protection system updating</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" onclick="return false" checked name=" burglary_extension_diesel" value="true" id="burglary_extension_diesel" class="inp-cbx" style="display: none">
                                            <label for="burglary_extension_diesel" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">
                                            Burglary extension from diesel tank and similar storage facilities
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" onclick="return false" checked name="machinery_breakdown" value="true" id="machinery_breakdown" class="inp-cbx" style="display: none">
                                            <label for="machinery_breakdown" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">machinery breakdown extension</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" onclick="return false" checked name="extra_cover" value="true" id="extra_cover" class="inp-cbx" style="display: none">
                                            <label for="extra_cover" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">
                                            Cover of extra charges for overtime, nightwork, work on public holidays exprss freight, air freight
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" onclick="return false" checked name="dissappearance_details" value="true" id="dissappearance_details" class="inp-cbx" style="display: none">
                                            <label for="dissappearance_details" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">Dishonesty, Dissappearance, Distraction</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" onclick="return false" checked name="elaboration_coverage" value="true" id="elaboration_coverage" class="inp-cbx" style="display: none">
                                            <label for="flightCover_16" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">
                                            Elaboration of coverage
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" onclick="return false" checked name="permit_clause" value="true" id="permit_clause" class="inp-cbx" style="display: none">
                                            <label for="permit_clause" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">Permit clause</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" onclick="return false" checked name="repurchase" value="true" id="repurchase" class="inp-cbx" style="display: none">
                                            <label for="repurchase" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">
                                            Repurchase
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" onclick="return false" checked name="bankruptcy" value="true" id="bankruptcy" class="inp-cbx" style="display: none">
                                            <label for="bankruptcy" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">Bankruptcy & insolvancy</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" onclick="return false" checked name="aircraft_damage" value="true" id="aircraft_damage" class="inp-cbx" style="display: none">
                                            <label for="aircraft_damage" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">
                                            Aircraft damage
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" onclick="return false" checked name="appraisement_clause" value="true" id="appraisement_clause" class="inp-cbx" style="display: none">
                                            <label for="appraisement_clause" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">Appraisement clause</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" onclick="return false" checked name="assiatnce_insured" value="true" id="assiatnce_insured" class="inp-cbx" style="display: none">
                                            <label for="assiatnce_insured" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">
                                            Assiatnce and co-operation of the Insured
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" onclick="return false" checked name="money_safe" value="true" id="money_safe" class="inp-cbx" style="display: none">
                                            <label for="money_safe" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">Money in Safe</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" onclick="return false" checked name="money_transit" value="true" id="money_transit" class="inp-cbx" style="display: none">
                                            <label for="money_transit" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">
                                            Money in transit
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" onclick="return false" checked name="computers_all_risk" value="true" id="computers_all_risk" class="inp-cbx" style="display: none">
                                            <label for="computers_all_risk" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">Computers all risk including damages to computers, additional expenses and media reconstruction cost</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" onclick="return false" checked name="cover_for_deterioration" value="true" id="cover_for_deterioration" class="inp-cbx" style="display: none">
                                            <label for="cover_for_deterioration" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">
                                            Cover for deterioration due to change in temperature or humidity or failure / inadequate operation of an airconditioning cooling or heating system
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" onclick="return false" checked name="hail_damage" value="true" id="hail_damage" class="inp-cbx" style="display: none">
                                            <label for="hail_damage" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">Hail Damage</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" onclick="return false" checked name="hazardous_materials" value="true" id="hazardous_materials" class="inp-cbx" style="display: none">
                                            <label for="hazardous_materials" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">
                                            Hazardous materials and / or substances
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" onclick="return false" checked name="thunderbolt_lightening" value="true" id="thunderbolt_lightening" class="inp-cbx" style="display: none">
                                            <label for="thunderbolt_lightening" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">thunderbolt and or lightening</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" onclick="return false" checked name="water_rain" value="true" id="water_rain" class="inp-cbx" style="display: none">
                                            <label for="water_rain" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">
                                            Water / rain damage
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" onclick="return false" checked name="specified_locations" value="true" id="specified_locations" class="inp-cbx" style="display: none">
                                            <label for="specified_locations" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">Specified locations cover</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" onclick="return false" checked name="portable_items" value="true" id="portable_items" class="inp-cbx" style="display: none">
                                            <label for="portable_items" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">
                                            Cover to include portable items worldwide
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" onclick="return false" checked name="property_and_alteration" value="true" id="property_and_alteration" class="inp-cbx" style="display: none">
                                            <label for="property_and_alteration" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">New property and alteration</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" onclick="return false" checked name="dismantleing_ext" value="true" id="dismantleing_ext" class="inp-cbx" style="display: none">
                                            <label for="dismantleing_ext" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">
                                            Dismantleing and re-erection extension
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" onclick="return false" checked name="automatic_purchase" value="true" id="automatic_purchase" class="inp-cbx" style="display: none">
                                            <label for="automatic_purchase" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">Automatic cover for newly purchased items</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" onclick="return false" checked name="cover_for_trees" value="true" id="cover_for_trees" class="inp-cbx" style="display: none">
                                            <label for="cover_for_trees" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">
                                            Cover for Trees, Shrubs, Plants, Lawns, Rockwork
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" onclick="return false" checked name="inform_reward" value="true" id="inform_reward" class="inp-cbx" style="display: none">
                                            <label for="inform_reward" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">Reward for Information</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" onclick="return false" checked name="cover_landscape" value="true" id="cover_landscape" class="inp-cbx" style="display: none">
                                            <label for="cover_landscape" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">
                                            Cover to include Landscaping, Fountains, Drive ways, pavement roads, minor arches and other similar items within the insured property
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif


                    <div class="row">
                        @if($form_data['machinery']!='')
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" onclick="return false" checked name="damage_walls" value="true" id="damage_walls" class="inp-cbx" style="display: none">
                                            <label for="damage_walls" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">Damage to walls, gates fences, neon, signs, flag poles, landscaping and other properties intented to exist or operate in the open</label>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" onclick="return false" checked name="cover_mechanical" value="true" id="cover_mechanical" class="inp-cbx" style="display: none">
                                        <label for="cover_mechanical" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">
                                        Cover for  mechanical, electrical and electronic breakdown  for fixed non-mobile plant and machinery
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" onclick="return false" checked name="cover_ext_work" value="true" id="cover_ext_work" class="inp-cbx" style="display: none">
                                        <label for="cover_ext_work" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Cover for external works including sign boards,  landscaping  including trees in building</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" onclick="return false" checked name="misdescription_clause" value="true" id="misdescription_clause" class="inp-cbx" style="display: none">
                                        <label for="misdescription_clause" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">
                                        Misdescription Clause
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" onclick="return false" checked name="temp_removal_clause" value="true" id="temp_removal_clause" class="inp-cbx" style="display: none">
                                        <label for="temp_removal_clause" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Temporary removal clause</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" onclick="return false" checked name="other_insurance_clause" value="true" id="other_insurance_clause" class="inp-cbx" style="display: none">
                                        <label for="other_insurance_clause" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">
                                        Other insurance allowed clause
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" onclick="return false" checked name="automatic_acq_clause" value="true" id="automatic_acq_clause" class="inp-cbx" style="display: none">
                                        <label for="automatic_acq_clause" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Automatic acquisition clause</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" onclick="return false" checked name="minor_work_ext" value="true" id="minor_work_ext" class="inp-cbx" style="display: none">
                                        <label for="minor_work_ext" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">
                                        Minor works extension
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" onclick="return false" checked name="sale_interest_clause" value="true" id="sale_interest_clause" class="inp-cbx" style="display: none">
                                        <label for="sale_interest_clause" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Sale of Interest Clause</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" onclick="return false" checked name="sue_labour_clause" value="true" id="sue_labour_clause" class="inp-cbx" style="display: none">
                                        <label for="sue_labour_clause" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">
                                        Sue and labour clause
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" onclick="return false" checked name="electrical_cause" value="true" id="electrical_cause" class="inp-cbx" style="display: none">
                                        <label for="electrical_cause" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Electrical clause waiver- Loss or damage by fire to electrical or electronic appliances , installations and wiring insured by this policy arising from or occasioned by over running, overheating excessive current, short circuiting, arcing, self-heating or leakage of electricity from whatever cause (lightning included) is covered </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" onclick="return false" checked name="contract_price_clause" value="true" id="contract_price_clause" class="inp-cbx" style="display: none">
                                        <label for="contract_price_clause" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">
                                        Contract price clause
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" onclick="return false" checked name="sprinkler_upgradation_clause" value="true" id="sprinkler_upgradation_clause" class="inp-cbx" style="display: none">
                                        <label for="sprinkler_upgradation_clause" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Sprinkler upgradation clause</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" onclick="return false" checked name="accidental_fix_class" value="true" id="accidental_fix_class" class="inp-cbx" style="display: none">
                                        <label for="accidental_fix_class" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">
                                        Accidental damage to fixed glass, glass (other than fixed glass)
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" onclick="return false" checked name="electronic_installation" value="true" id="electronic_installation" class="inp-cbx" style="display: none">
                                        <label for="electronic_installation" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Electronic installation, computers, data processing, equipment and other fragile or brittle object</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" onclick="return false" checked name="brand_trademark" value="true" id="brand_trademark" class="inp-cbx" style="display: none">
                                        <label for="brand_trademark" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">
                                        Brand and trademark
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" onclick="return false" checked name="loss_notification" value="true" id="loss_notification" class="inp-cbx" style="display: none">
                                        <label for="loss_notification" class="cbx">
                                                                                <span>
                                                                                <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                                                </svg>
                                                                                </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Loss Notification ??? ???as soon as reasonably practicable???</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" onclick="return false" checked name="brockers_claim_clause" value="true" id="brockers_claim_clause" class="inp-cbx" style="display: none">
                                        <label for="brockers_claim_clause" class="cbx">
                                                                <span>
                                                                <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                                </svg>
                                                                </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">
                                        Brokers Claim Handling Clause : A loss notification received by the Insurance Broker will be deemed as a loss notification to Insurer. All communications flowing between the Insurer, Insured and the appointed Loss Surveyor should be channelized through the Broker, unless there is any unavoidable reasons compelling direct communications between the parties
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                        @if(@$form_data['businessInterruption']['business_interruption'] ==true )
                        <div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form_group">
                                <label class="form_label">No of locations<span style="visibility:hidden">*</span></label>
                                <div class="enter_data">
                                    <p>{{$form_data['businessInterruption']['noLocations']}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form_group">
                                <label class="form_label">Business Activity <span style="visibility:hidden">*</span></label>
                                <div class="enter_data">
                                    <p>{{@$pipeline_details['formData']['businessType']}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form_group">
                                <label class="form_label">Estimated Annual Gross profit<span style="visibility:hidden">*</span></label>
                                <div class="enter_data">
                                    <p>{{number_format(@$form_data['businessInterruption']['estimatedProfit'],2)}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form_group">
                                <label class="form_label">Standing charges<span style="visibility:hidden">*</span></label>
                                <div class="enter_data">
                                    <p>{{number_format($form_data['businessInterruption']['standCharge'],2)}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form_group">
                                <label class="form_label">Increase cost of working <span style="visibility:hidden">*</span></label>
                                <div class="enter_data">
                                    <p>{{number_format($form_data['businessInterruption']['costWork'],2)}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form_group">
                                <label class="form_label">Indemnity period<span style="visibility:hidden">*</span></label>
                                <div class="enter_data">
                                    <p>{{$form_data['businessInterruption']['indemnityPeriod']}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form_group">
                                <label class="form_label">Policy period<span style="visibility:hidden">*</span></label>
                                <div class="enter_data">
                                    <p>12 Months</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    @endif
                {{-- </div> --}}
                 </div>
                    @if(@$form_data['businessInterruption']['business_interruption'] ==true )                                                                                                                                                                                                                                                        
                      

                <div class="row">
                    <div class="col-md-6">
                        <div class="form_group">
                            <div class="flex_sec">
                                <div class="custom_checkbox">
                                    <input type="checkbox" onclick="return false" checked name="add_cost_working" value="true" id="add_cost_working" class="inp-cbx" style="display: none">
                                    <label for="add_cost_working" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                    </label>
                                </div>
                                <label class="form_label bold">Additional increase in cost of working</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form_group">
                            <div class="flex_sec">
                                <div class="custom_checkbox">
                                    <input type="checkbox" onclick="return false" checked name="claim_preparation_clause" value="true" id="claim_preparation_clause" class="inp-cbx" style="display: none">
                                    <label for="claim_preparation_clause" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                    </label>
                                </div>
                                <label class="form_label bold">
                                    Claims preparation clause
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form_group">
                            <div class="flex_sec">
                                <div class="custom_checkbox">
                                    <input type="checkbox" onclick="return false" checked name="suppliers_extension" value="true" id="suppliers_extension" class="inp-cbx" style="display: none">
                                    <label for="suppliers_extension" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                    </label>
                                </div>
                                <label class="form_label bold">Suppliers extension/customer extension</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form_group">
                            <div class="flex_sec">
                                <div class="custom_checkbox">
                                    <input type="checkbox" onclick="return false" checked name="accountants_clause" value="true" id="accountants_clause" class="inp-cbx" style="display: none">
                                    <label for="accountants_clause" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                    </label>
                                </div>
                                <label class="form_label bold">
                                    Accountants clause
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form_group">
                            <div class="flex_sec">
                                <div class="custom_checkbox">
                                    <input type="checkbox" onclick="return false" checked name="account_payment" value="true" id="account_payment" class="inp-cbx" style="display: none">
                                    <label for="account_payment" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                    </label>
                                </div>
                                <label class="form_label bold">Payment on account</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form_group">
                            <div class="flex_sec">
                                <div class="custom_checkbox">
                                    <input type="checkbox" onclick="return false" checked name="prevention_denial_clause" value="true" id="prevention_denial_clause" class="inp-cbx" style="display: none">
                                    <label for="prevention_denial_clause" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                    </label>
                                </div>
                                <label class="form_label bold">
                                    Prevention/denial of access
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form_group">
                            <div class="flex_sec">
                                <div class="custom_checkbox">
                                    <input type="checkbox" onclick="return false" checked name="premium_adj_clause" value="true" id="premium_adj_clause" class="inp-cbx" style="display: none">
                                    <label for="premium_adj_clause" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                    </label>
                                </div>
                                <label class="form_label bold">Premium adjustment clause</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form_group">
                            <div class="flex_sec">
                                <div class="custom_checkbox">
                                    <input type="checkbox" onclick="return false" checked name="public_utility_clause" value="true" id="public_utility_clause" class="inp-cbx" style="display: none">
                                    <label for="public_utility_clause" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                    </label>
                                </div>
                                <label class="form_label bold">
                                    Public utilities clause
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form_group">
                            <div class="flex_sec">
                                <div class="custom_checkbox">
                                    <input type="checkbox" onclick="return false" checked name="brockers_claim_handling_clause" value="true" id="brockers_claim_handling_clause" class="inp-cbx" style="display: none">
                                    <label for="brockers_claim_handling_clause" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                    </label>
                                </div>
                                <label class="form_label bold">Brokers Claim Handling Clause : A loss notification received by the Insurance Broker will be deemed as a loss notification to Insurer. All communications flowing between the Insurer, Insured and the appointed Loss Surveyor should be channelized through the Broker, unless there is any unavoidable reasons compelling direct communications between the parties</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form_group">
                            <div class="flex_sec">
                                <div class="custom_checkbox">
                                    <input type="checkbox" onclick="return false" checked name="accounts_recievable" value="true" id="accounts_recievable" class="inp-cbx" style="display: none">
                                    <label for="accounts_recievable" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                    </label>
                                </div>
                                <label class="form_label bold">
                                    Accounts recievable / Loss of booked debts
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form_group">
                            <div class="flex_sec">
                                <div class="custom_checkbox">
                                    <input type="checkbox" onclick="return false" checked name="inter_dependency" value="true" id="inter_dependency" class="inp-cbx" style="display: none">
                                    <label for="inter_dependency" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                    </label>
                                </div>
                                <label class="form_label bold">Interdependany clause</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form_group">
                            <div class="flex_sec">
                                <div class="custom_checkbox">
                                    <input type="checkbox" onclick="return false" checked name="extra_expense" value="true" id="extra_expense" class="inp-cbx" style="display: none">
                                    <label for="extra_expense" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                    </label>
                                </div>
                                <label class="form_label bold">
                                    Extra expense
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form_group">
                            <div class="flex_sec">
                                <div class="custom_checkbox">
                                    <input type="checkbox" onclick="return false" checked name="contaminated_water" value="true" id="contaminated_water" class="inp-cbx" style="display: none">
                                    <label for="contaminated_water" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                    </label>
                                </div>
                                <label class="form_label bold">Contaminated water</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form_group">
                            <div class="flex_sec">
                                <div class="custom_checkbox">
                                    <input type="checkbox" onclick="return false" checked name="auditors_fee_check" value="true" id="auditors_fee_check" class="inp-cbx" style="display: none">
                                    <label for="auditors_fee_check" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                    </label>
                                </div>
                                <label class="form_label bold">
                                    Auditors fees
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form_group">
                            <div class="flex_sec">
                                <div class="custom_checkbox">
                                    <input type="checkbox" onclick="return false" checked name="expense_reduce_loss" value="true" id="expense_reduce_loss" class="inp-cbx" style="display: none">
                                    <label for="expense_reduce_loss" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                    </label>
                                </div>
                                <label class="form_label bold">expense to reduce the loss</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form_group">
                            <div class="flex_sec">
                                <div class="custom_checkbox">
                                    <input type="checkbox" onclick="return false" checked name="nominated_loss_adjuster" value="true" id="nominated_loss_adjuster" class="inp-cbx" style="display: none">
                                    <label for="nominated_loss_adjuster" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                    </label>
                                </div>
                                <label class="form_label bold">
                                    Nominated loss adjuster
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form_group">
                            <div class="flex_sec">
                                <div class="custom_checkbox">
                                    <input type="checkbox" onclick="return false" checked name="outbreak_discease" value="true" id="outbreak_discease" class="inp-cbx" style="display: none">
                                    <label for="outbreak_discease" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                    </label>
                                </div>
                                <label class="form_label bold">Outbreak of discease</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form_group">
                            <div class="flex_sec">
                                <div class="custom_checkbox">
                                    <input type="checkbox" onclick="return false" checked name="non_public_failure" value="true" id="non_public_failure" class="inp-cbx" style="display: none">
                                    <label for="non_public_failure" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                    </label>
                                </div>
                                <label class="form_label bold">
                                    Failure of non public power supply
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form_group">
                            <div class="flex_sec">
                                <div class="custom_checkbox">
                                    <input type="checkbox" onclick="return false" checked name="premises_details" value="true" id="premises_details" class="inp-cbx" style="display: none">
                                    <label for="premises_details" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                    </label>
                                </div>
                                <label class="form_label bold">Murder, Suicide or outbreak of discease on the premises</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form_group">
                            <div class="flex_sec">
                                <div class="custom_checkbox">
                                    <input type="checkbox" onclick="return false" checked name="bombscare" value="true" id="bombscare" class="inp-cbx" style="display: none">
                                    <label for="bombscare" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                    </label>
                                </div>
                                <label class="form_label bold">
                                    Bombscare and unexploded devices on the premises
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form_group">
                            <div class="flex_sec">
                                <div class="custom_checkbox">
                                    <input type="checkbox" onclick="return false" checked name="book_debits" value="true" id="book_debits" class="inp-cbx" style="display: none">
                                    <label for="book_debits" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                    </label>
                                </div>
                                <label class="form_label bold">Book of Debts</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form_group">
                            <div class="flex_sec">
                                <div class="custom_checkbox">
                                    <input type="checkbox" onclick="return false" checked name="public_failure" value="true" id="public_failure" class="inp-cbx" style="display: none">
                                    <label for="public_failure" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                    </label>
                                </div>
                                <label class="form_label bold">
                                    failure of public utility
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                @if(isset($form_data['businessInterruption']['noLocations']) && $form_data['businessInterruption']['noLocations']>1)
                <div class="row">
                    <div class="col-md-6">
                        <div class="form_group">
                            <div class="flex_sec">
                                <div class="custom_checkbox">
                                    <input type="checkbox" onclick="return false" checked name="departmental_clause" value="true" id="departmental_clause" class="inp-cbx" style="display: none">
                                    <label for="departmental_clause" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                    </label>
                                </div>
                                <label class="form_label bold">Departmental clause</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form_group">
                            <div class="flex_sec">
                                <div class="custom_checkbox">
                                    <input type="checkbox" onclick="return false" checked name="rent_lease" value="true" id="rent_lease" class="inp-cbx" style="display: none">
                                    <label for="rent_lease" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                    </label>
                                </div>
                                <label class="form_label bold">
                                    Rent & Lease hold interest
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                @endif


                <div class="row">
                    <div class="col-md-4">
                        <div class="form_group">
                            <label class="form_label bold">Cover for alternate accomodation <span>*</span></label>
                            <div class="custom_select">
                                <select class="form_input" id="cover_accomodation" name="cover_accomodation" onchange="validation(this.id);">
                                    <option value="" selected>Select</option>
                                    <option value="yes" @if(isset($pipeline_details['formData']['CoverAccomodation']['coverAccomodation']) && @$pipeline_details['formData']['CoverAccomodation']['coverAccomodation'] ==true) selected @endif >Yes</option>
                                    <option value="no" @if(isset($pipeline_details['formData']['CoverAccomodation']['coverAccomodation']) && @$pipeline_details['formData']['CoverAccomodation']['coverAccomodation'] ==false) selected @endif >No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8"  id="accomodation_yes"  @if(isset($pipeline_details['formData']['CoverAccomodation']['coverAccomodation']) && @$pipeline_details['formData']['CoverAccomodation']['coverAccomodation'] ==true) style="display:block" @else  style="display:none" @endif >
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form_group">
                                    <label class="form_label bold">Cover for alternate accomodation  <span>*</span></label>
                                    <input class="form_input" id="cover_alternate" name="cover_alternate" 
                                    @if(isset($pipeline_details['formData']['CoverAccomodation']['coverAccomodation']) && ($pipeline_details['formData']['CoverAccomodation']['coverAccomodation']==true)) 
                                    value="{{@$pipeline_details['formData']['CoverAccomodation']['OtherCover']}}" @endif>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-6">
                        <div class="form_group">
                            <div class="flex_sec">
                                <div class="custom_checkbox">
                                    <input type="checkbox"   name="contingent_business" value="true" id="contingent_business" class="inp-cbx"  @if(isset($pipeline_details['formData']['contingentBusiness']) && 
                                    $pipeline_details['formData']['contingentBusiness']==true) checked @endif style="display: none">
                                    <label for="contingent_business" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                    </label>
                                </div>
                                <label class="form_label bold">Contingent business inetruption and contingent extra expense</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form_group">
                            <div class="flex_sec">
                                <div class="custom_checkbox">
                                    <input type="checkbox" name="non_owned_properties" value="true" id="non_owned_properties" class="inp-cbx" @if(isset($pipeline_details['formData']['nonOwnedProperties']) && 
                                    $pipeline_details['formData']['nonOwnedProperties']==true) checked @endif  style="display: none">
                                    <label for="non_owned_properties" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                    </label>
                                </div>
                                <label class="form_label bold">
                                    Non Owned property in vicinity interuption
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form_group">
                            <div class="flex_sec">
                                <div class="custom_checkbox">
                                    <input type="checkbox"   name="royalties" value="true" id="royalties" class="inp-cbx" @if(isset($pipeline_details['formData']['royalties']) && 
                                    $pipeline_details['formData']['royalties']==true) checked @endif style="display: none">
                                    <label for="royalties" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
                                    </label>
                                </div>
                                <label class="form_label bold">Royalties</label>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <div class="row">
                    <div class="col-md-6">
                        <div class="form_group">
                            <label class="form_label bold">Claims experience details for<span>*</span></label>
                            <div class="">
                                <select class="selectpicker" id="claim_experience_details" name="claim_experience_details"  onchange="validation(this.id);">
                                    <option value="" selected>Select</option>
                                    <option value="combined_data" @if(@$pipeline_details['formData']['cliamPremium'] =='combined_data') selected @endif  >Combined Premium details for Property and Business interruption</option>
                                    <option value="only_property"  @if(@$pipeline_details['formData']['cliamPremium'] =='only_property') selected @endif>Only Property</option>
                                    <option value="separate_property"  @if(@$pipeline_details['formData']['cliamPremium'] =='separate_property') selected @endif>Individual premiums for Property and Business interruption </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="table1"   @if(isset($pipeline_details['formData']['cliamPremium']) && @$pipeline_details['formData']['cliamPremium'] =='combined_data') style="display:block" @else style="display:none" @endif>
                    <div class="row" >
                        <div class="col-md-12">
                            <div class="form_group">
                                {{-- <label class="form_label bold">Claims experience <span style="visibility: hidden">*</span></label> --}}
                                <table class="table table-bordered custom_table">
                                    <thead>
                                    <tr>
                                        <th style="font-size: 15px;" colspan="2"> Combined premium for Property and Business interruption</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>Deductible for Property:  </td>
                                        <td><input class="form_input number" name="deductable_property" id="deductable_property" 
                                         @if(isset($pipeline_details['formData']['claimPremiyumDetails']['deductableProperty'])
                                          && (@$pipeline_details['formData']['claimPremiyumDetails']['deductableProperty']))
                                             value="{{number_format(trim($pipeline_details['formData']['claimPremiyumDetails']['deductableProperty']),2)}}" @endif></td>
                                    </tr>

                                    <tr>
                                        <td>Deductible for Business Interruption: </td>
                                        <td><input class="form_input number" name="deductable_interuption" type="text" id="deductable_interuption"  
                                        @if(isset($pipeline_details['formData']['claimPremiyumDetails']['deductableBusiness']) 
                                            && @$pipeline_details['formData']['claimPremiyumDetails']['deductableBusiness'])
                                             value="{{number_format(trim($pipeline_details['formData']['claimPremiyumDetails']['deductableBusiness']),2)}}" @endif></td>
                                    </tr>

                                    <tr>
                                        <td>Rate required (combined):</td>
                                        <td><input class="form_input number" name="rate_required" type="text" id="rate_required" 
                                         @if(isset($pipeline_details['formData']['claimPremiyumDetails']['rateCombined']) 
                                            && @$pipeline_details['formData']['claimPremiyumDetails']['rateCombined'])
                                             value="{{number_format(trim($pipeline_details['formData']['claimPremiyumDetails']['rateCombined']),2)}}" @endif></td>
                                    </tr>

                                    <tr>
                                        <td>Premium required (combined):</td>
                                        <td><input class="form_input number" name="premium_required" type="text" id="premium_required"  
                                        @if(isset($pipeline_details['formData']['claimPremiyumDetails']['premiumCombined']) 
                                            && @$pipeline_details['formData']['claimPremiyumDetails']['premiumCombined'])
                                             value="{{number_format(trim($pipeline_details['formData']['claimPremiyumDetails']['premiumCombined']),2)}}" @endif></td>
                                    </tr>

                                    <tr>
                                        <td>Brokerage (combined)</td>
                                        <td><input class="form_input number" name="brokerage" type="text" id="brokerage" 
                                         @if(isset($pipeline_details['formData']['claimPremiyumDetails']['brokerage']) 
                                            && @$pipeline_details['formData']['claimPremiyumDetails']['brokerage'])
                                             value="{{number_format(trim($pipeline_details['formData']['claimPremiyumDetails']['brokerage']),2)}}" @endif></td>
                                    </tr>

                                    <tr>
                                        <td>Warranty (Property)</td>
                                        <td><input class="form_input" name="warranty" type="text" id="warranty"
                                         @if(isset($pipeline_details['formData']['claimPremiyumDetails']['warrantyProperty']) 
                                            && @$pipeline_details['formData']['claimPremiyumDetails']['warrantyProperty'])
                                             value="{{$pipeline_details['formData']['claimPremiyumDetails']['warrantyProperty']}}" @endif></td>
                                    </tr>

                                    <tr>
                                        <td>Warranty (Business Interruption)</td>
                                        <td><input class="form_input" name="warranty_business" type="text" id="warranty_business" 
                                        @if(isset($pipeline_details['formData']['claimPremiyumDetails']['warrantyBusiness']) 
                                            && @$pipeline_details['formData']['claimPremiyumDetails']['warrantyBusiness'])
                                             value="{{$pipeline_details['formData']['claimPremiyumDetails']['warrantyBusiness']}}" @endif></td>
                                    </tr>

                                    <tr>
                                        <td>Exclusion (Property) </td>
                                        <td><input class="form_input" name="exclusion_property" type="text" id="exclusion_property"
                                         @if(isset($pipeline_details['formData']['claimPremiyumDetails']['exclusionProperty']) 
                                            && @$pipeline_details['formData']['claimPremiyumDetails']['exclusionProperty'])
                                             value="{{$pipeline_details['formData']['claimPremiyumDetails']['exclusionProperty']}}" @endif></td>
                                    </tr>

                                    <tr>
                                        <td>Exclusion (Business Interruption)</td>
                                        <td><input class="form_input" name="exclusion_business" type="text" id="exclusion_business"
                                          @if(isset($pipeline_details['formData']['claimPremiyumDetails']['exclusionBusiness']) 
                                            && @$pipeline_details['formData']['claimPremiyumDetails']['exclusionBusiness'])
                                             value="{{$pipeline_details['formData']['claimPremiyumDetails']['exclusionBusiness']}}" @endif></td>
                                    </tr>

                                    <tr>
                                        <td>Special Condition (Property) </td>
                                        <td><input class="form_input" name="special_property" type="text" id="special_property" 
                                         @if(isset($pipeline_details['formData']['claimPremiyumDetails']['specialProperty']) 
                                            && @$pipeline_details['formData']['claimPremiyumDetails']['specialProperty'])
                                             value="{{$pipeline_details['formData']['claimPremiyumDetails']['specialProperty']}}" @endif></td>
                                    </tr>

                                    <tr>
                                        <td>Special Condition (Business Interruption)</td>
                                        <td><input class="form_input" name="special_business" type="text" id="special_business"  
                                        @if(isset($pipeline_details['formData']['claimPremiyumDetails']['specialBusiness']) 
                                            && @$pipeline_details['formData']['claimPremiyumDetails']['specialBusiness'])
                                             value="{{$pipeline_details['formData']['claimPremiyumDetails']['specialBusiness']}}" @endif></td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="row" id="table2" @if(isset($pipeline_details['formData']['cliamPremium']) && @$pipeline_details['formData']['cliamPremium'] =='only_property') style="display:block" @else style="display:none" @endif>
                    <div class="col-md-12">
                        <div class="form_group">
                            {{-- <label class="form_label bold">Claims experience <span style="visibility: hidden">*</span></label> --}}
                            <table class="table table-bordered custom_table">
                                <thead>
                                <tr>
                                    <th style="font-size: 15px;" colspan="2"> Property</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>Deductible:    </td>
                                    <td><input class="form_input number" name="property_deductable" id="property_deductable" 
                                    @if(isset($pipeline_details['formData']['claimPremiyumDetails']['deductableProperty']) 
                                        && @$pipeline_details['formData']['claimPremiyumDetails']['deductableProperty'])
                                         value="{{number_format(trim($pipeline_details['formData']['claimPremiyumDetails']['deductableProperty']),2)}}" @endif>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Rate required: </td>
                                    <td><input class="form_input number" name="property_rate" type="text" id="property_rate"
                                     @if(isset($pipeline_details['formData']['claimPremiyumDetails']['propertyRate']) 
                                        && @$pipeline_details['formData']['claimPremiyumDetails']['propertyRate'])
                                         value="{{number_format(trim($pipeline_details['formData']['claimPremiyumDetails']['propertyRate']),2)}}" @endif></td>
                                </tr>

                                <tr>
                                    <td>Premium required:   </td>
                                    <td><input class="form_input number" name="property_premium" type="text" id="property_premium" 
                                    @if(isset($pipeline_details['formData']['claimPremiyumDetails']['propertyPremium']) 
                                        && @$pipeline_details['formData']['claimPremiyumDetails']['propertyPremium'])
                                         value="{{number_format(trim($pipeline_details['formData']['claimPremiyumDetails']['propertyPremium']),2)}}" @endif></td>
                                </tr>

                                <tr>
                                    <td>Brokerage </td>
                                    <td><input class="form_input number" name="property_brockerage" type="text" id="property_brockerage" 
                                    @if(isset($pipeline_details['formData']['claimPremiyumDetails']['propertyBrockerage']) 
                                        && @$pipeline_details['formData']['claimPremiyumDetails']['propertyBrockerage'])
                                         value="{{number_format(trim($pipeline_details['formData']['claimPremiyumDetails']['propertyBrockerage']),2)}}" @endif></td>
                                </tr>

                                <tr>
                                    <td>Warranty</td>
                                    <td><input class="form_input" name="property_warranty" type="text" id="property_warranty"
                                    @if(isset($pipeline_details['formData']['claimPremiyumDetails']['propertyWarranty']) 
                                        && @$pipeline_details['formData']['claimPremiyumDetails']['propertyWarranty'])
                                         value="{{$pipeline_details['formData']['claimPremiyumDetails']['propertyWarranty']}}" @endif></td>
                                </tr>

                                <tr>
                                    <td>Exclusion</td>
                                    <td><input class="form_input" name="property_exclusion" type="text" id="property_exclusion"
                                     @if(isset($pipeline_details['formData']['claimPremiyumDetails']['propertyExclusion']) 
                                        && @$pipeline_details['formData']['claimPremiyumDetails']['propertyExclusion'])
                                         value="{{$pipeline_details['formData']['claimPremiyumDetails']['propertyExclusion']}}" @endif></td>
                                </tr>

                                <tr>
                                    <td>Special Condition</td>
                                    <td><input class="form_input" name="property_special" type="text" id="property_special" 
                                        @if(isset($pipeline_details['formData']['claimPremiyumDetails']['propertySpecial']) 
                                        && @$pipeline_details['formData']['claimPremiyumDetails']['propertySpecial'])
                                         value="{{$pipeline_details['formData']['claimPremiyumDetails']['propertySpecial']}}" @endif></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                <div class="row" id="table3"  @if(isset($pipeline_details['formData']['cliamPremium']) && @$pipeline_details['formData']['cliamPremium'] =='separate_property') style="display:block" @else style="display:none" @endif>
                    <div class="col-md-12">
                        <div class="form_group">
                            {{-- <label class="form_label bold">Claims experience <span style="visibility: hidden">*</span></label> --}}
                            <table class="table table-bordered custom_table">
                                <thead>
                                <tr>
                                    <th style="font-size: 15px;" colspan="2"> Separate Premiums for Property and Business interruption </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>Deductible for (Property):  </td>
                                    <td><input class="form_input number" name="property_separate_deductable" id="property_separate_deductable" 
                                        @if(isset($pipeline_details['formData']['claimPremiyumDetails']['propertySeparateDeductable']) 
                                        && @$pipeline_details['formData']['claimPremiyumDetails']['propertySeparateDeductable'])
                                         value="{{number_format(trim($pipeline_details['formData']['claimPremiyumDetails']['propertySeparateDeductable']),2)}}" @endif>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Rate required (Property):</td>
                                    <td><input class="form_input number" name="property_separate_rate" type="text" id="property_separate_rate" 
                                        @if(isset($pipeline_details['formData']['claimPremiyumDetails']['propertySeparateRate']) && 
                                        @$pipeline_details['formData']['claimPremiyumDetails']['propertySeparateRate'])
                                         value="{{number_format(trim($pipeline_details['formData']['claimPremiyumDetails']['propertySeparateRate']),2)}}" @endif
                                        ></td>
                                </tr>

                                <tr>
                                    <td>Premium required (Property):</td>
                                    <td><input class="form_input number" name="property_separate_premium" type="text" id="property_separate_premium" 
                                    @if(isset($pipeline_details['formData']['claimPremiyumDetails']['propertySeparatePremium']) && 
                                    @$pipeline_details['formData']['claimPremiyumDetails']['propertySeparatePremium']) 
                                    value="{{number_format(trim($pipeline_details['formData']['claimPremiyumDetails']['propertySeparatePremium']),2)}}" @endif></td>
                                </tr>

                                <tr>
                                    <td>Brokerage (Property)</td>
                                    <td><input class="form_input number" name="property_separate_brokerage"  id="property_separate_brokerage"
                                        @if(isset($pipeline_details['formData']['claimPremiyumDetails']['propertySeparateBrokerage']) && 
                                        @$pipeline_details['formData']['claimPremiyumDetails']['propertySeparateBrokerage'])
                                         value="{{number_format(trim($pipeline_details['formData']['claimPremiyumDetails']['propertySeparateBrokerage']),2)}}" @endif></td>
                                </tr>

                                <tr>
                                    <td>Warranty (Property)</td>
                                    <td><input class="form_input" name="property_separate_warranty" type="text" id="property_separate_warranty"
                                     @if(isset($pipeline_details['formData']['claimPremiyumDetails']['propertySeparateWarranty']) 
                                    && @$pipeline_details['formData']['claimPremiyumDetails']['propertySeparateWarranty']) 
                                        value="{{$pipeline_details['formData']['claimPremiyumDetails']['propertySeparateWarranty']}}" @endif></td>
                                </tr>
                                <tr>
                                    <td>Exclusion (Property)</td>
                                    <td><input class="form_input" name="property_separate_exclusion" type="text" id="property_separate_exclusion"
                                        @if(isset($pipeline_details['formData']['claimPremiyumDetails']['propertySeparateExclusion']) && 
                                        @$pipeline_details['formData']['claimPremiyumDetails']['propertySeparateExclusion'])
                                         value="{{$pipeline_details['formData']['claimPremiyumDetails']['propertySeparateExclusion']}}" @endif></td>
                                </tr>

                                <tr>
                                    <td>Special Condition (Property)</td>
                                    <td><input class="form_input" name="property_separate_special" type="text" id="property_separate_special"
                                         @if(isset($pipeline_details['formData']['claimPremiyumDetails']['propertySeparateSpecial']) &&
                                          @$pipeline_details['formData']['claimPremiyumDetails']['propertySeparateSpecial']) 
                                        value="{{$pipeline_details['formData']['claimPremiyumDetails']['propertySeparateSpecial']}}" @endif></td>
                                </tr>

                                <tr>
                                    <td>Deductible for (Business Interruption):</td>
                                    <td><input class="form_input number" name="business_separate_deductable" id="business_separate_deductable"
                                         @if(isset($pipeline_details['formData']['claimPremiyumDetails']['businessSeparateDeductable']) 
                                         && @$pipeline_details['formData']['claimPremiyumDetails']['businessSeparateDeductable'])
                                        value="{{number_format(trim($pipeline_details['formData']['claimPremiyumDetails']['businessSeparateDeductable']),2)}}" @endif></td>
                                </tr>

                                <tr>
                                    <td>Rate required (Business Interruption):</td>
                                    <td><input class="form_input number" name="business_separate_rate" id="business_separate_rate" 
                                        @if(isset($pipeline_details['formData']['claimPremiyumDetails']['businessSeparateRate']) &&
                                         @$pipeline_details['formData']['claimPremiyumDetails']['businessSeparateRate'])
                                         value="{{number_format(trim($pipeline_details['formData']['claimPremiyumDetails']['businessSeparateRate']),2)}}" @endif></td>
                                </tr>

                                <tr>
                                    <td>Premium required (Business Interruption):</td>
                                    <td><input class="form_input number" name="business_separate_premium" type="text" id="business_separate_premium"
                                         @if(isset($pipeline_details['formData']['claimPremiyumDetails']['businessSeparatePremium']) 
                                         && @$pipeline_details['formData']['claimPremiyumDetails']['businessSeparatePremium'])
                                         value="{{number_format(trim($pipeline_details['formData']['claimPremiyumDetails']['businessSeparatePremium']),2)}}" @endif></td>
                                </tr>

                                <tr>
                                    <td>Brokerage (Business Interruption):</td>
                                    <td><input class="form_input number" name="business_separate_brokerage" type="text" id="business_separate_brokerage"
                                         @if(isset($pipeline_details['formData']['claimPremiyumDetails']['businessSeparateBrokerage']) && 
                                         @$pipeline_details['formData']['claimPremiyumDetails']['businessSeparateBrokerage'])
                                         value="{{number_format(trim($pipeline_details['formData']['claimPremiyumDetails']['businessSeparateBrokerage']),2)}}" @endif></td>
                                </tr>

                                <tr>
                                    <td>Warranty (Business Interruption):</td>
                                    <td><input class="form_input" name="business_separate_warranty" type="text" id="business_separate_warranty" 
                                    @if(isset($pipeline_details['formData']['claimPremiyumDetails']['businessSeparateWarranty'])
                                     && @$pipeline_details['formData']['claimPremiyumDetails']['businessSeparateWarranty'])
                                         value="{{$pipeline_details['formData']['claimPremiyumDetails']['businessSeparateWarranty']}}" @endif></td>
                                </tr>

                                <tr>
                                    <td>Exclusion (Business Interruption):</td>
                                    <td><input class="form_input" name="business_separate_exclusion" type="text" id="business_separate_exclusion"
                                         @if(isset($pipeline_details['formData']['claimPremiyumDetails']['businessSeparateExclusion']) &&
                                          @$pipeline_details['formData']['claimPremiyumDetails']['businessSeparateExclusion'])
                                         value="{{$pipeline_details['formData']['claimPremiyumDetails']['businessSeparateExclusion']}}" @endif></td>
                                </tr>

                                <tr>
                                    <td>Special Condition (Business Interruption):
                                    <td><input class="form_input" name="business_separate_special" type="text" id="business_separate_special"
                                         @if(isset($pipeline_details['formData']['claimPremiyumDetails']['businessSeparateSpecial']) &&
                                          @$pipeline_details['formData']['claimPremiyumDetails']['businessSeparateSpecial'])
                                         value="{{$pipeline_details['formData']['claimPremiyumDetails']['businessSeparateSpecial']}}" @endif></td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div> 
                </div>
                <div class="clearfix">
                <button type="submit"  id="eslip_submit" name="eslip_submit"  class="btn btn-primary btn_action pull-right" @if($pipeline_details['status']['status']=='Approved E Quote' || $pipeline_details['status']['status']=='Issuance') style="display: none" @endif>Proceed</button>
                @if($pipeline_details['status']['status']=='E-slip')
                    <button type = "button" class="btn blue_btn pull-right btn_action" onclick="saveEslip()">Save as Draft</button>
                @endif
                </div>
                </div>
        </form>
    </div>
               
            <!-- Popup -->
                <div id="insurance_popup">
                    <form name="insurance_companies_form" method="post" id="insurance_companies_form">

                    <input type="hidden" name="pipeline_id" value="{{@$worktype_id}}">
                        <input type="hidden" name="send_type" id="send_type">
                        <div class="cd-popup">
                            <div class="cd-popup-container">
                                <div class="modal_content">
                                    <h1>Insurance Companies List</h1>

                                    <div class="clearfix"> </div> <span class="error" id="no_new_company" style="display: none">No New Insurance Company Selected</span>
                                    <div class="content_spacing">
                                        <div class="row">
                                            <div class="col-md-12" id="insurer_list">
                                                <i class="fa fa-spinner fa-spin fa-3x fa-fw col-md-12 col-md-2 col-md-push-6" style="padding: 25px;"></i><span class="sr-only">Loading...</span>
                                            </div>
                                        </div>
                                    </div>


                                </div>

                                <div class="modal_footer">
                                    <button class="btn btn-primary btn-link btn_cancel" type="button" onclick="">Cancel</button>
                                    @if(count(@$pipeline_details['insuraceCompanyList'])!=0)
                                    <button class="btn btn-primary btn_action" value="send_all" id="send_all_button" type="button">Send To All Selected</button>
                                    <button class="btn btn-primary btn_action" value="send_new" id="send_new_button" type="button">Send To Newly Selected</button>
                                    @else  
                                    <button class="btn btn-primary btn_action" id="insurance_button" type="button">Send</button>
                                        @endif

                                </div>
                            </div>
                        </div>
                    </form>
                </div><!--//END Popup -->
             @include('includes.mail_popup')
            @include('includes.chat') 
            @endsection

            @push('scripts')
      <!--jquery validate-->
 <script src="{{URL::asset('js/main/jquery.validate.js')}}"></script>
 <script src="{{URL::asset('js/main/additional-methods.min.js')}}"></script>
 {{-- <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script> --}}
<!-- Custom Select -->
<script src="{{URL::asset('js/main/custom-select.js')}}"></script>

<!-- Bootstrap Select -->
<script src="{{URL::asset('js/main/bootstrap-select.js')}}"></script>

<!-- Date Picker -->
<script src="{{URL::asset('js/main/bootstrap-datetimepicker.js')}}"></script>


{{-- <!-- Fancy FileUpload -->
<script src="{{URL::asset('js/file-uploader/jquery.ui.widget.js')}}"></script>
<script src="{{URL::asset('js/file-uploader/jquery.fileupload.js')}}"></script>
<script src="{{URL::asset('js/file-uploader/jquery.iframe-transport.js')}}"></script>
<script src="{{URL::asset('js/file-uploader/jquery.fancy-fileupload.js')}}"></script> --}}


<script>
             var new_num;
$("input.number").keyup(function(event){

    //   debugger;
    var $this = $(this);
    var num =  $this.val();
    var num_parts = num.toString().split(".");
    
    if(num_parts[1]){
     
            if(num_parts[1].length >2){
                num2 = new_num;
               
            } else{
                num_parts[0] = num_parts[0].replace(/,/gi, "");
                num_parts[0] = num_parts[0].split(/(?=(?:\d{3})+$)/).join(",");
                var num2 = num_parts.join(".");
                new_num = num2;
                
            }
      
        
    } else{
        num_parts[0] = num_parts[0].replace(/,/gi, "");
        num_parts[0] = num_parts[0].split(/(?=(?:\d{3})+$)/).join(",");
        var num2 = num_parts.join(".");
        new_num = num2;
    
    }
    $this.val(num2);

}); 
function upload_file(obj)
{
   var id=obj.id;
    var fullPath =  obj.value;
    if(id=='')
            {
                $('#'+'id'+'-error').show();
            }
            else{
                $('#'+'id'+'-error').hide();
            }
            var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
            var filename = fullPath.substring(startIndex);
            if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
                filename = filename.substring(1);
            }
//            console.log(filename);
            // $('.remove_file_upload').show();
            if(id=='civil_certificate')
            {
                        $('#civil_p').text(filename);
            }
            else if(id=='policyCopy')
            {
                        $('#policy_p').text(filename);
            }
            else if(id=='trade_list')
            {
                        $('#trade_list_p').text(filename);
            }
            else if(id=='vat_copy')
            {
                        $('#vat_copy_p').text(filename);
            }
            else if(id=='others1')
            {
                        $('#others1_p').text(filename);
            }
            else if(id=='others2')
            {
                        $('#others2_p').text(filename);
            }
            }
                         function validation(id) {
                            if($('#'+id).val()=='')
                            {
                                $('#'+id+'-error').show();
                            }else{
                                $('#'+id+'-error').hide();
                            }
                        }
                        $('#claim_experience_details').change(function(){

                            var claim_value =$('#claim_experience_details').val();
                            console.log(claim_value);
                            if(claim_value=='combined_data')
                            {
                                $('#table1').show();
                                $('#table2').hide();
                                $('#table3').hide();
                            }else if(claim_value=='only_property')
                            {
                                claim_data='Only Property';
                                $('#table2').show();
                                $('#table1').hide();
                                $('#table3').hide();

                            }else if(claim_value=='separate_property')
                            {
                                $('#table3').show();
                                $('#table1').hide();
                                $('#table2').hide();
                            }
                            else if(claim_value=='')
                            {
                                $('#table3').hide();
                                $('#table1').hide();
                                $('#table2').hide();
                            }
                        });
                      
                        // Business Interruption cover Required

                        $('#cover_accomodation').change(function () {
                            var cover_accomodation = $('#cover_accomodation').val();

                            if(cover_accomodation=='yes')
                            {
                                $('#accomodation_yes').show();
                            }
                            else{
                                $('#accomodation_yes').hide();
                            }
                        });
                      

                        $( "#send_all_button" ).click(function() {
                            var valid=  $("#insurance_companies_form").valid();
                            if(valid==true) {

                                    $('#send_type').val('send_all');
                                    $('#insurance_companies_form').submit();
                                }
                        });
                        $( "#send_new_button" ).click(function() {
                            var valid=  $("#insurance_companies_form").valid();
                            if(valid==true) {

                                    $('#send_type').val('send_new');
                                    $('#insurance_companies_form').submit();
                                }
                        });
                        $( "#insurance_button" ).click(function() {
                            var valid=  $("#insurance_companies_form").valid();
                            if(valid==true) {

                                    $('#send_type').val('0');
                                    $('#insurance_companies_form').submit();
                                }
                        });



                   

            
            $('#e-slip-form').validate({
                             ignore: [],
                                     rules: {
                                     civil_certificate: {
                                     accept:"image/jpg,image/jpeg,image/png,application/pdf,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
                                     required: function () {
                                         return ($("#civil_url").val() == undefined);
                                     }
                                 },
                                 policyCopy: {
                                     accept: "image/jpg,image/jpeg,image/png,application/pdf,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
                                     required: function () {
                                         return ($("#policy_url").val() == undefined);
                                     }
                                 },
                                 trade_list: {
                                     accept: "image/jpg,image/jpeg,image/png,application/pdf,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
                                     required: function () {
                                         return ($("#trade_url").val() == undefined);
                                     }
                                 },
                                 vat_copy: {
                                     accept: "image/jpg,image/jpeg,image/png,application/pdf,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
                                     required: function () {
                                         return ($("#vat_url").val() == undefined);
                                     }
                                 },
                                 others1: {
                                     accept: "image/jpg,image/jpeg,image/png,application/pdf,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
                                     required: function () {
                                         return ($("#other1_url").val() == undefined);
                                     }
                                 },
                                 others2: {
                                     accept: "image/jpg,image/jpeg,image/png,application/pdf,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
                                     required: function () {
                                         return ($("#other2_url").val() == undefined);
                                     }
                                 },
                                adj_business_caluse: {
                                     required: true
                                 },
                                 stock_declaration: {
                                     required: true
                                 },
                                 loss_rent: {
                                     required: true
                                 },
                                 personal_staff: {
                                     required: true
                                 },
                                 cover_include: {
                                     required: true
                                 },
                                 seasonal_increase: {
                                     required: true
                                 },
                                 cover_alternative: {
                                     required: true
                                 },
                                 cover_exihibition: {
                                     required: true
                                 },
                                 cover_property: {
                                     required: true
                                 },
                                 property_care: {
                                     required: true
                                 },
                                  loss_payee: {
                                     required: true
                                 },
                                 cover_accomodation: {
                                     required: true
                                 },
                               
                                 cover_alternate: {
                                     required:function () {
                                         return ($("#cover_accomodation").val() =='yes');
                                     }
                                 },

                                 claim_experience_details: {
                                     required: true
                                 },


                                 deductable_property: {
                                     required:function () {
                                         return ($("#claim_experience_details").val() =='combined_data');
                                     },
                                     number:true
                                 },
                                 deductable_interuption: {
                                     required:function () {
                                         return ($("#claim_experience_details").val() =='combined_data');
                                     },
                                     number:true
                                 },
                                 rate_required: {
                                     required:function () {
                                         return ($("#claim_experience_details").val() =='combined_data');
                                     },
                                     number:true
                                 },
                                 premium_required: {
                                     required:function () {
                                         return ($("#claim_experience_details").val() =='combined_data');
                                     },
                                     number:true
                                 },
                                 brokerage: {
                                     required:function () {
                                         return ($("#claim_experience_details").val() =='combined_data');
                                     },
                                     number:true
                                 },
                                 warranty: {
                                     required:function () {
                                         return ($("#claim_experience_details").val() =='combined_data');
                                     }
                                 },
                                 warranty_business: {
                                     required:function () {
                                         return ($("#claim_experience_details").val() =='combined_data');
                                     }
                                 },
                                 exclusion_property: {
                                     required:function () {
                                         return ($("#claim_experience_details").val() =='combined_data');
                                     }
                                 },
                                 exclusion_business: {
                                     required:function () {
                                         return ($("#claim_experience_details").val() =='combined_data');
                                     }
                                 },
                                 special_property: {
                                     required:function () {
                                         return ($("#claim_experience_details").val() =='combined_data');
                                     }
                                 },
                                 special_business: {
                                     required:function () {
                                         return ($("#claim_experience_details").val() =='combined_data');
                                     }
                                 },
                                 property_deductable: {
                                     required:function () {
                                         return ($("#claim_experience_details").val() =='only_property');
                                     },
                                     number:true
                                 },
                                 property_rate: {
                                     required:function () {
                                         return ($("#claim_experience_details").val() =='only_property');
                                     },
                                     number:true
                                 },
                                 property_premium: {
                                     required:function () {
                                         return ($("#claim_experience_details").val() =='only_property');
                                     },
                                     number:true
                                 },
                                 property_brockerage: {
                                     required:function () {
                                         return ($("#claim_experience_details").val() =='only_property');
                                     },
                                     number:true
                                 },
                                 property_warranty: {
                                     required:function () {
                                         return ($("#claim_experience_details").val() =='only_property');
                                     }
                                 },
                                 property_exclusion: {
                                     required:function () {
                                         return ($("#claim_experience_details").val() =='only_property');
                                     }
                                 },
                                 property_special: {
                                     required:function () {
                                         return ($("#claim_experience_details").val() =='only_property');
                                     }
                                 },
                                 property_separate_deductable: {
                                     required:function () {
                                         return ($("#claim_experience_details").val() =='separate_property');
                                     },
                                     number:true
                                 },
                                 property_separate_rate: {
                                     required:function () {
                                         return ($("#claim_experience_details").val() =='separate_property');
                                     },
                                     number:true
                                 },
                                 property_separate_premium: {
                                     required:function () {
                                         return ($("#claim_experience_details").val() =='separate_property');
                                     },
                                     number:true
                                 },
                                 property_separate_brokerage: {
                                     required:function () {
                                         return ($("#claim_experience_details").val() =='separate_property');
                                     },
                                     number:true
                                 },
                                 property_separate_warranty: {
                                     required:function () {
                                         return ($("#claim_experience_details").val() =='separate_property');
                                     },
                                 },
                                 property_separate_exclusion: {
                                     required:function () {
                                         return ($("#claim_experience_details").val() =='separate_property');
                                     }
                                 },
                                 property_separate_special: {
                                     required:function () {
                                         return ($("#claim_experience_details").val() =='separate_property');
                                     },
                                 },
                                 business_separate_deductable: {
                                     required:function () {
                                         return ($("#claim_experience_details").val() =='separate_property');
                                     },
                                     number:true
                                 },
                                 business_separate_rate: {
                                     required:function () {
                                         return ($("#claim_experience_details").val() =='separate_property');
                                     },
                                     number:true
                                 },
                                 business_separate_premium: {
                                     required:function () {
                                         return ($("#claim_experience_details").val() =='separate_property');
                                     },
                                     number:true
                                 },
                                 business_separate_brokerage: {
                                     required:function () {
                                         return ($("#claim_experience_details").val() =='separate_property');
                                     },
                                     number:true
                                 },
                                 business_separate_warranty: {
                                     required:function () {
                                         return ($("#claim_experience_details").val() =='separate_property');
                                     }
                                 },
                                 business_separate_exclusion: {
                                     required:function () {
                                         return ($("#claim_experience_details").val() =='separate_property');
                                     }
                                 },
                                 business_separate_special: {
                                     required:function () {
                                         return ($("#claim_experience_details").val() =='separate_property');
                                     }
                                 }
                             },
                             messages: {
                                 civil_certificate: "Please upload valid certificate.(.png,.jpeg,.jpg,.pdf,.xls)",
                                 policyCopy: "Please upload valid copy.(.png,.jpeg,.jpg,.pdf,.xls)",
                                 trade_list: "Please upload valid file.(.png,.jpeg,.jpg,.pdf,.xls)",
                                 vat_copy: "Please upload valid file.(.png,.jpeg,.jpg,.pdf,.xls)",
                                 others1: "Please upload valid file.(.png,.jpeg,.jpg,.pdf,.xls)",
                                 others2: "Please upload valid file.(.png,.jpeg,.jpg,.pdf,.xls)",
                                 adj_business_caluse: "Please enter adjoining building clause.",
                                 stock_declaration: "Please enter stock declaration clause.",
                                 loss_rent: "Please enter loss of rent.",
                                 personal_staff: "Please enter cover for personal effects of staff / guests property / valuables.",
                                 cover_include: "Please enter cover to include unregistered motorised vehicles (like passenger, luggage, laundry carts) used on or around the premises.",
                                 seasonal_increase: "Please enter seasonal increase in stocks.",
                                 cover_alternative: "Please enter cover for alternative accommodation.",
                                 cover_exihibition: "Please enter cover for exhibition risks.",
                                 cover_property: "Please enter cover for property in the open.",
                                 property_care: "Please enter including property in the care, custody & control of the insured.",
                                 loss_payee: "Please enter loss payee clause.",
                               
                                 cover_accomodation: "Please select cover for alternate accomodation.",
                                 cover_alternate: "Please enter cover for alternate accomodation details.",
                                 claim_experience_details: "Please select any option",
                                 deductable_property: "Please enter deductible for property.",
                                 deductable_interuption: "Please enter deductible for business interruption: .",
                                 rate_required: "Please enter rate required (Combined).",
                                 premium_required: "Please enter premium required (Combined).",
                                 brokerage: "Please enter brokerage (Combined).",
                                 warranty: "Please enter warranty (Property).",
                                 warranty_business: "Please enter warranty (Business Interruption).",
                                 exclusion_property: "Please enter exclusion (Property).",
                                 exclusion_business: "Please enter exclusion (Business Interruption).",
                                 special_property: "Please enter special condition (Property).",
                                 special_business: "Please enter special condition (Business Interruption).",
                                 property_deductable: "Please enter deductible.",
                                 property_rate: "Please enter rate required.",
                                 property_premium: "Please enter premium required.",
                                 property_brockerage: "Please enter brokerage.",
                                 property_warranty: "Please enter warranty.",
                                 property_exclusion: "Please enter exclusion.",
                                 property_special: "Please enter special condition.",
                                 property_separate_deductable: "Please enter deductible for (Property).",
                                 property_separate_rate: "Please enter rate required (Property).",
                                 property_separate_premium: "Please enter premium required (Property).",
                                 property_separate_brokerage: "Please enter brokerage (Property).",
                                 property_separate_warranty: "Please enter warranty (Property).",
                                 property_separate_exclusion: "Please enter exclusion (Property).",
                                 property_separate_special: "Please enter special condition (Property).",
                                 business_separate_deductable: "Please enter deductible for (Business Interruption).",
                                 business_separate_rate: "Please enter rate required (Business Interruption).",
                                 business_separate_premium: "Please enter premium required (Business Interruption).",
                                 business_separate_brokerage: "Please enter brokerage (Business Interruption).",
                                 business_separate_warranty: "Please enter warranty (Business Interruption).",
                                 business_separate_exclusion: "Please enter exclusion (Business Interruption).",
                                 business_separate_special: "Please enter special condition (Business Interruption)."
                               },
                             errorPlacement: function (error, element) {
                                
                                  if(element.attr("name") == "cover_accomodation" ||
                                  element.attr("name") == "civil_certificate" ||
                                  element.attr("name") == "policyCopy" ||
                                  element.attr("name") == "trade_list" ||
                                  element.attr("name") == "vat_copy" ||
                                  element.attr("name") == "others1" ||
                                  element.attr("name") == "others2"
                                   )
                                 {
                                     error.insertAfter(element.parent());
                                     // scrolltop();
                                 }
                                 else {
                                     error.insertAfter(element);
                                     // scrolltop();
                                 }
                             },
                            submitHandler: function (form,event) {

                                var form_data = new FormData($("#e-slip-form")[0]);
                                form_data.append('_token', '{{csrf_token()}}');
                                $('#preLoader').show();
//$("#eslip_submit").attr( "disabled", "disabled" );
                                $.ajax({
                                    method: 'post',
                                    url: '{{url('property/eslip-save')}}',
                                    data: form_data,
                                     cache : false,
                                     contentType: false,
                                     processData: false,
                                    success: function (result) {
                                        if (result.success== 'success') {
                                            getInsurerList();
                                        }
                                    }
                                });
                            }
                        });
                        //     function scrolltop()
                        //     {
                        //         $('html,body').animate({
                        //             scrollTop: 150
                        //         }, 0);
                        //     }

                        //form validation
                            $('#insurance_companies_form').validate({
                            ignore: [],
                                rules: {
                                'insurance_companies[]': {
                                    required: true
                                }
                            },
                            messages: {
                                    'insurance_companies[]': "Please select insurance companies."
                            },
                            errorPlacement: function (error, element) {

                                    error.insertAfter(element.parent().parent());
                            },
                            submitHandler: function (form,event) {
                                var form_data = new FormData($("#insurance_companies_form")[0]);
                                form_data.append('_token', '{{csrf_token()}}');
                                $("#insurance_button").attr( "disabled", "disabled" );
                                $.ajax({
                                    method: 'post',
                                    url: '{{url('email-file-eslip')}}',
                                    data: form_data,
                                    processData: false,
                                    contentType: false,
                                    success: function (result) {
                                        if (result.success != 'failed') {
                                            $("#insurance_popup .cd-popup").removeClass('is-visible');
                                            $('#questionnaire_popup .cd-popup').addClass('is-visible');
                                            $("#send_btn").attr( "disabled", false );
                                            $('#attach_div').html(result.documentSection);
                                        }
                                        else {
                                            $("#insurance_button").attr( "disabled",false );
                                            $('#insurance_popup').show();
                                            $('#no_new_company').show();
                                            $('#attach_div').html('Files loading failed');
                                        }
                                    }
                                });
                            }
                            });

                        var new_num;
                        $("input.number").keyup(function(event){

                            //   debugger;
                            var $this = $(this);
                            var num =  $this.val();
                            var num_parts = num.toString().split(".");
                            
                            if(num_parts[1]){
                            
                                    if(num_parts[1].length >2){
                                        num2 = new_num;
                                    
                                    } else{
                                        num_parts[0] = num_parts[0].replace(/,/gi, "");
                                        num_parts[0] = num_parts[0].split(/(?=(?:\d{3})+$)/).join(",");
                                        var num2 = num_parts.join(".");
                                        new_num = num2;
                                        
                                    }
                            
                                
                            } else{
                                num_parts[0] = num_parts[0].replace(/,/gi, "");
                                num_parts[0] = num_parts[0].split(/(?=(?:\d{3})+$)/).join(",");
                                var num2 = num_parts.join(".");
                                new_num = num2;
                            
                            }
                            $this.val(num2);

                        });
                            function getInsurerList()
                            {
                                $("#insurance_button").attr( "disabled", false );
                                $("#insurance_popup .cd-popup").toggleClass('is-visible');
                                $('#preLoader').fadeOut('slow');
                                var eslip_id = $('#eslip_id').val();
                                $.ajax({
                                    method: 'get',
                                    data:{'eslip_id' : eslip_id},
                                    url: '{{url('get-insurer')}}',
                                    success:function (data) {
                                        $('#insurer_list').html('');
                                        $('#insurer_list').append(data);
                                    }

                                });
                            }
                            function popupHide()
                            {
                                $('#insurer_list').html('<i class="fa fa-spinner fa-spin fa-3x fa-fw col-md-12 col-md-2 col-md-push-6" style="padding: 25px;"></i><span class="sr-only">Loading...</span>');
                                $("#insurance_popup .cd-popup").toggleClass('is-visible');
                                $("#eslip_submit").attr( "disabled", false );
                            }
                            function sendQuestion() {
                                $("#questionnaire_popup .cd-popup").removeClass('is-visible');
                                $('#quest_send_form :input').not(':submit').clone().hide().appendTo('#insurance_companies_form');
                                var form_data = new FormData($("#insurance_companies_form")[0]);
                                form_data.append('_token', '{{csrf_token()}}');
                                $('#preLoader').show();
                                $("#insurance_button").attr( "disabled", "disabled" );
                                $("#send_btn").attr( "disabled", true );
                                $.ajax({
                                    method: 'post',
                                    url: '{{url('property/insurance-company-save')}}',
                                    data: form_data,
                                    processData: false,
                                    contentType: false,
                                    success: function (result) {
                                        if (result.success== 'success') {
                                            $("#send_btn").attr( "disabled", false );
                                            window.location.href = '{{url('property/e-quotation')}}'+'/'+result.id;
                                            // $("#insurance_popup .cd-popup").removeClass('is-visible');
                                            $('#insurance_popup').show();
                                            $('#insurer_list').html('<i class="fa fa-spinner fa-spin fa-3x fa-fw col-md-12 col-md-2 col-md-push-6" style="padding: 25px;"></i><span class="sr-only">Loading...</span>');
                                        }
                                        else{
                                            $("#send_btn").attr( "disabled", false );
                                            $('#questionnaire_popup .cd-popup').removeClass('is-visible');
                                            $('#preLoader').hide();
                                            $('#insurance_popup').show();
                                            $('#no_new_company').show();
                                        }
                                    }
                                });
                            }
                            function saveEslip()
                            {
                                var form_data = new FormData($("#e-slip-form")[0]);
                                form_data.append('_token', '{{csrf_token()}}');
                                form_data.append('is_save','true');
                                $('#preLoader').show();
                                //$("#eslip_submit").attr( "disabled", "disabled" );
                                $.ajax({
                                    method: 'post',
                                    url: '{{url('property/eslip-save')}}',
                                    data: form_data,
                                    cache : false,
                                    contentType: false,
                                    processData: false,
                                    success: function (result) {
                                        $('#preLoader').hide();
                                        if (result.success== 'success') {
                                            $('#success_message').html('E-Slip is saved as draft.');
                                            $('#success_popup .cd-popup').addClass('is-visible');
                                        }
                                        else
                                        {
                                            $('#success_message').html('E-Slip saving failed.');
                                            $('#success_popup .cd-popup').addClass('is-visible');
                                        }
                                    }
                                });
                            }
                    </script>
    @endpush


