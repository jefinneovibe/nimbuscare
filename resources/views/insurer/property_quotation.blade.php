
@extends('layouts.insurer_layout')


@section('content')
    <div class="section_details">
        <div class="card_header clearfix">
            <h3 class="title" style="margin-bottom: 8px;">Property</h3>
        </div>
        <div class="card_content">
            <div class="edit_sec clearfix">
                <form id="e-quotation-form" method="post" name="e-quotation-form">
                    {{csrf_field()}}
                    <input type="hidden" value="{{$pipeLineId}}" name="id" id="id">
                    <input type="hidden" name="quoteActive" id="quoteActive" @if(@$insurerReply['quoteStatus']=='active') value="true" @else value="false" @endif>
                    @if(@$token)
                        <input type="hidden" name="hiddenToken" id="hiddenToken" value="{{$token}}">
                    @endif


                    <div class="row">
                        <div class="col-md-12">
                            <div class="form_group">
                                <label class="form_label">Name of the Company <span style="visibility:hidden">*</span></label>
                                <div class="enter_data">
                                    <p>{{@$pipeline_details['formData']['companyName']}}</p>
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
                                        <label class="form_label bold form_text" style="color:#9c27b0">Percentage of Cladding on the overall building exterior wall construction<span style="visibility:hidden"span></label>
                                        <div class="enter_data">
                                            <p>{{@$pipeline_details['formData']['constuctionType']['percentageCladding']}}</p>
                                        </div>
                                    </div>
                                </div>
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
                                        <label class="form_label bold form_text" style="color:#9c27b0">Technical specification of ACP’s especially on the core material involve <span style="visibility:hidden">*</span></label>
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
                                    <label class="form_label bold">Floor <span  style="visibility:hidden" style="visibility:hidden">*</span></label>
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
                        @if(isset($pipeline_details['formData']['fireFight']))
                            <div  @if(isset($pipeline_details['formData']['fireFight']['fireFacilities']) && (in_array('others',@$pipeline_details['formData']['fireFight']['fireFacilities'])))
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
                        @endif
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
                                        <label class="form_label bold">Storage capacity details<span  style="visibility:hidden">*</span></label>
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
                                        <p>{{number_format(trim($pipeline_details['formData']['buildingInclude']),2)}}</p>
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


                    {{-- <div class="row"> --}}
					<?php
					if(@$pipeline_details['formData']['claimExperienceDetails']=='only_property')
					{
						$heading='Only Property';
					}else  if(@$pipeline_details['formData']['claimExperienceDetails']=='combined_data'){
						$heading='Combined data for Property and Business interruption coverages';
					}
					else  if(@$pipeline_details['formData']['claimExperienceDetails']=='separate_property'){
						$heading='Separate data for Property ';
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
                    {{-- </div> --}}
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i>Adjoining building clause<span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="adj_business_caluse1" class="radio">
                                    <input type="radio" name="adj_business_caluse" value="Agree" id="adj_business_caluse1" class="hidden" @if(@$insurerReply['adjBusinessClause'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="adj_business_caluse2" class="radio">
                                    <input type="radio" name="adj_business_caluse" value="Not Agree" id="adj_business_caluse2" class="hidden" @if(@$insurerReply['adjBusinessClause'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    @if(isset($pipeline_details['formData']['stock']) && $pipeline_details['formData']['stock']!='')
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Stock Declaration clause<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="stock_declaration1" class="radio">
                                        <input type="radio" name="stock_declaration" value="Agree" id="stock_declaration1" class="hidden" @if(@$insurerReply['stockDeclaration']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="stock_declaration2" class="radio">
                                        <input type="radio" name="stock_declaration" value="Not Agree" id="stock_declaration2" class="hidden" @if(@$insurerReply['stockDeclaration']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="stock_declaration_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['stockDeclaration']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if(isset($pipeline_details['formData']['annualRent']) && $pipeline_details['formData']['annualRent']!='')
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Loss of rent<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="loss_rent1" class="radio">
                                        <input type="radio" name="loss_rent" value="Agree" id="loss_rent1" class="hidden" @if(@$insurerReply['lossRent']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="loss_rent2" class="radio">
                                        <input type="radio" name="loss_rent" value="Not Agree" id="loss_rent2" class="hidden" @if(@$insurerReply['lossRent']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="loss_rent_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['lossRent']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if($pipeline_details['formData']['businessType']=="Hotels/ boarding houses/ motels/ service apartments" ||
                        $pipeline_details['formData']['businessType']=="Hotel multiple cover")
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Cover for personal effects of staff / guests property / valuables<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="personal_staff1" class="radio">
                                        <input type="radio" name="personal_staff" value="Agree" id="personal_staff1" class="hidden" @if(@$insurerReply['personalStaff']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="personal_staff2" class="radio">
                                        <input type="radio" name="personal_staff" value="Not Agree" id="personal_staff2" class="hidden" @if(@$insurerReply['personalStaff']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="personal_staff_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['personalStaff']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Cover to include unregistered motorised vehicles (like passenger, luggage, laundry carts) used on or around the premises <span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="cover_include1" class="radio">
                                        <input type="radio" name="cover_include" value="Agree" id="cover_include1" class="hidden" @if(@$insurerReply['coverInclude'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="cover_include2" class="radio">
                                        <input type="radio" name="cover_include" value="Not Agree" id="cover_include2" class="hidden" @if(@$insurerReply['coverInclude'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
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
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Seasonal increase in stocks<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="seasonal_increase1" class="radio">
                                        <input type="radio" name="seasonal_increase" value="Agree" id="seasonal_increase1" class="hidden" @if(@$insurerReply['seasonalIncrease'] ['isAgree']== 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="seasonal_increase2" class="radio">
                                        <input type="radio" name="seasonal_increase" value="Not Agree" id="seasonal_increase2" class="hidden" @if(@$insurerReply['seasonalIncrease']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="seasonal_increase_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['seasonalIncrease']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if($pipeline_details['formData']['occupancy']['type']=='Residence')
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Cover for alternative accommodation<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="cover_alternative1" class="radio">
                                        <input type="radio" name="cover_alternative" value="Agree" id="cover_alternative1" class="hidden" @if(@$insurerReply['coverAlternative']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="cover_alternative2" class="radio">
                                        <input type="radio" name="cover_alternative" value="Not Agree" id="cover_alternative2" class="hidden" @if(@$insurerReply['coverAlternative']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="cover_alternative_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['coverAlternative']['comment']}}</textarea>
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
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Cover for exhibition risks<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="cover_exihibition1" class="radio">
                                        <input type="radio" name="cover_exihibition" value="Agree" id="cover_exihibition1" class="hidden" @if(@$insurerReply['coverExihibition'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="cover_exihibition2" class="radio">
                                        <input type="radio" name="cover_exihibition" value="Not Agree" id="cover_exihibition2" class="hidden" @if(@$insurerReply['coverExihibition'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                    @endif
                    @if(@$pipeline_details['formData']['occupancy']['type']=='Warehouse'
                        ||  @$pipeline_details['formData']['occupancy']['type']=='Factory'
                        ||  @$pipeline_details['formData']['occupancy']['type']=='Others')
                                                <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Cover for property in the open<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="cover_property1" class="radio">
                                        <input type="radio" name="cover_property" value="Agree" id="cover_property1" class="hidden" @if(@$insurerReply['coverProperty'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="cover_property2" class="radio">
                                        <input type="radio" name="cover_property" value="Not Agree" id="cover_property2" class="hidden" @if(@$insurerReply['coverProperty'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                    @endif
                    @if($pipeline_details['formData']['otherItems']!='')
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Including property in the care, custody & control of the insured<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="property_care1" class="radio">
                                        <input type="radio" name="property_care" value="Agree" id="property_care1" class="hidden" @if(@$insurerReply['propertyCare']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="property_care2" class="radio">
                                        <input type="radio" name="property_care" value="Not Agree" id="property_care2" class="hidden" @if(@$insurerReply['propertyCare']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="property_care_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['propertyCare']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                    @endif
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Loss payee clause<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="loss_payee1" class="radio">
                                        <input type="radio" name="loss_payee" value="Agree" id="loss_payee1" class="hidden" @if(@$insurerReply['lossPayee'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="loss_payee2" class="radio">
                                        <input type="radio" name="loss_payee" value="Not Agree" id="loss_payee2" class="hidden" @if(@$insurerReply['lossPayee'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    
                    @if(($pipeline_details['formData']['businessType']=="Art galleries/ fine arts collection"
                        || $pipeline_details['formData']['businessType']=="Colleges/ Universities/ schools & educational institute"
                        || $pipeline_details['formData']['businessType']=="Hotels/ boarding houses/ motels/ service apartments"
                        || $pipeline_details['formData']['businessType']=="Hotel multiple cover"
                        || $pipeline_details['formData']['businessType']=="Museum/ heritage sites") && isset($pipeline_details['formData']['coverCurios']) && $pipeline_details['formData']['coverCurios']==true)
                                                )
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Cover for curios and work of art<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="cover_curios1" class="radio">
                                        <input type="radio" name="cover_curios" value="Agree" id="cover_curios1" class="hidden" @if(@$insurerReply['coverCurios'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="cover_curios2" class="radio">
                                        <input type="radio" name="cover_curios" value="Not Agree" id="cover_curios2" class="hidden" @if(@$insurerReply['coverCurios'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if(isset($pipeline_details['formData']['indemnityOwner']) && $pipeline_details['formData']['indemnityOwner']==true)
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Indemnity to owners and principals<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="indemnity_owner1" class="radio">
                                        <input type="radio" name="indemnity_owner" value="Agree" id="indemnity_owner1" class="hidden" @if(@$insurerReply['indemnityOwner'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="indemnity_owner2" class="radio">
                                        <input type="radio" name="indemnity_owner" value="Not Agree" id="indemnity_owner2" class="hidden" @if(@$insurerReply['indemnityOwner'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if(isset($pipeline_details['formData']['conductClause']) && $pipeline_details['formData']['conductClause']==true)
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Conduct of business clause<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="conduct_clause1" class="radio">
                                        <input type="radio" name="conduct_clause" value="Agree" id="conduct_clause1" class="hidden" @if(@$insurerReply['conductClause'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="conduct_clause2" class="radio">
                                        <input type="radio" name="conduct_clause" value="Not Agree" id="conduct_clause2" class="hidden" @if(@$insurerReply['conductClause'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if(isset($pipeline_details['formData']['saleClause']) && $pipeline_details['formData']['saleClause'] == true)
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Sale of interest clause<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="sale_clause1" class="radio">
                                        <input type="radio" name="sale_clause" value="Agree" id="sale_clause1" class="hidden" @if(@$insurerReply['saleClause'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="sale_clause2" class="radio">
                                        <input type="radio" name="sale_clause" value="Not Agree" id="sale_clause2" class="hidden" @if(@$insurerReply['saleClause'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i>Fire brigade and extinguishing clause<span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="fire_brigade1" class="radio">
                                    <input type="radio" name="fire_brigade" value="Agree" id="fire_brigade1" class="hidden" @if(@$insurerReply['fireBrigade']['isAgree'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="fire_brigade2" class="radio">
                                    <input type="radio" name="fire_brigade" value="Not Agree" id="fire_brigade2" class="hidden" @if(@$insurerReply['fireBrigade']['isAgree'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form_group">
                                <textarea name="fire_brigade_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['fireBrigade']['comment']}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i>72 Hours clause-wording modified- the 72 hours will stretch beyond the expiration of the policy period provided the first earthquake/flood/storm occurred prior to the expiry time of the policy.
                                <span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="clause_wording1" class="radio">
                                    <input type="radio" name="clause_wording" value="Agree" id="clause_wording1" class="hidden" @if(@$insurerReply['clauseWording'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="clause_wording2" class="radio">
                                    <input type="radio" name="clause_wording" value="Not Agree" id="clause_wording2" class="hidden" @if(@$insurerReply['clauseWording'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i>Automatic reinstatement of sum insured at pro-rata additional premium
                                <span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="automatic_reinstatement1" class="radio">
                                    <input type="radio" name="automatic_reinstatement" value="Agree" id="automatic_reinstatement1" class="hidden" @if(@$insurerReply['automaticReinstatement'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="automatic_reinstatement2" class="radio">
                                    <input type="radio" name="automatic_reinstatement" value="Not Agree" id="automatic_reinstatement2" class="hidden" @if(@$insurerReply['automaticReinstatement'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i>Capital addition clause<span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="capital_clause1" class="radio">
                                    <input type="radio" name="capital_clause" value="Agree" id="capital_clause1" class="hidden" @if(@$insurerReply['capitalClause']['isAgree'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="capital_clause2" class="radio">
                                    <input type="radio" name="capital_clause" value="Not Agree" id="capital_clause2" class="hidden" @if(@$insurerReply['capitalClause']['isAgree']== 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form_group">
                                <textarea name="capital_clause_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['capitalClause']['comment']}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i>Workmen’s Maintenance clause
                                <span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="main_clause1" class="radio">
                                    <input type="radio" name="main_clause" value="Agree" id="main_clause1" class="hidden" @if(@$insurerReply['mainClause'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="main_clause2" class="radio">
                                    <input type="radio" name="main_clause" value="Not Agree" id="main_clause2" class="hidden" @if(@$insurerReply['mainClause'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i>Repair investigation costs<span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="repair_cost1" class="radio">
                                    <input type="radio" name="repair_cost" value="Agree" id="repair_cost1" class="hidden" @if(@$insurerReply['repairCost']['isAgree'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="repair_cost2" class="radio">
                                    <input type="radio" name="repair_cost" value="Not Agree" id="repair_cost2" class="hidden" @if(@$insurerReply['repairCost']['isAgree']== 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form_group">
                                <textarea name="repair_cost_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['repairCost']['comment']}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i>Removal of debris<span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="debris1" class="radio">
                                    <input type="radio" name="debris" value="Agree" id="debris1" class="hidden" @if(@$insurerReply['debris']['isAgree'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="debris2" class="radio">
                                    <input type="radio" name="debris" value="Not Agree" id="debris2" class="hidden" @if(@$insurerReply['debris']['isAgree'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form_group">
                                <textarea name="debris_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['debris']['comment']}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i>Reinstatement Value  clause (85% condition of  average)
                                <span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="reinstatement_val_class1" class="radio">
                                    <input type="radio" name="reinstatement_val_class" value="Agree" id="reinstatement_val_class1" class="hidden" @if(@$insurerReply['reinstatementValClass'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="reinstatement_val_class2" class="radio">
                                    <input type="radio" name="reinstatement_val_class" value="Not Agree" id="reinstatement_val_class2" class="hidden" @if(@$insurerReply['reinstatementValClass'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i>Waiver  of subrogation (against affiliates and subsidiaries)
                                <span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="waiver1" class="radio">
                                    <input type="radio" name="waiver" value="Agree" id="waiver1" class="hidden" @if(@$insurerReply['waiver'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="waiver2" class="radio">
                                    <input type="radio" name="waiver" value="Not Agree" id="waiver2" class="hidden" @if(@$insurerReply['waiver'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i>Public authorities clause<span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="public_clause1" class="radio">
                                    <input type="radio" name="public_clause" value="Agree" id="public_clause1" class="hidden" @if(@$insurerReply['publicClause']['isAgree'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="public_clause2" class="radio">
                                    <input type="radio" name="public_clause" value="Not Agree" id="public_clause2" class="hidden" @if(@$insurerReply['publicClause']['isAgree'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form_group">
                                <textarea name="public_clause_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['publicClause']['comment']}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i>All other contents clause<span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="contents_clause1" class="radio">
                                    <input type="radio" name="contents_clause" value="Agree" id="contents_clause1" class="hidden" @if(@$insurerReply['contentsClause']['isAgree'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="contents_clause2" class="radio">
                                    <input type="radio" name="contents_clause" value="Not Agree" id="contents_clause2" class="hidden" @if(@$insurerReply['contentsClause']['isAgree'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form_group">
                                <textarea name="contents_clause_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['contentsClause']['comment']}}</textarea>
                            </div>
                        </div>
                    </div>
                    @if(isset($pipeline_details['formData']['buildingInclude']) && isset($pipeline_details['formData']['errorOmission']) && $pipeline_details['formData']['buildingInclude']!='' && $pipeline_details['formData']['errorOmission'] == true)
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Errors & Omissions
                                    <span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="error_omission1" class="radio">
                                        <input type="radio" name="error_omission" value="Agree" id="error_omission1" class="hidden" @if(@$insurerReply['errorOmission'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="error_omission2" class="radio">
                                        <input type="radio" name="error_omission" value="Not Agree" id="error_omission2" class="hidden" @if(@$insurerReply['errorOmission'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i>Alteration and use  clause
                                <span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="alteration_clause1" class="radio">
                                    <input type="radio" name="alteration_clause" value="Agree" id="alteration_clause1" class="hidden" @if(@$insurerReply['alterationClause'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="alteration_clause2" class="radio">
                                    <input type="radio" name="alteration_clause" value="Not Agree" id="alteration_clause2" class="hidden" @if(@$insurerReply['alterationClause'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i>Trace and Access
                                <span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="trade_access1" class="radio">
                                    <input type="radio" name="trade_access" value="Agree" id="trade_access1" class="hidden" @if(@$insurerReply['tradeAccess'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="trade_access2" class="radio">
                                    <input type="radio" name="trade_access" value="Not Agree" id="trade_access2" class="hidden" @if(@$insurerReply['tradeAccess'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i>Temporary repair clause
                                <span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="temp_removal1" class="radio">
                                    <input type="radio" name="temp_removal" value="Agree" id="temp_removal1" class="hidden" @if(@$insurerReply['tempRemoval'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="temp_removal2" class="radio">
                                    <input type="radio" name="temp_removal" value="Not Agree" id="temp_removal2" class="hidden" @if(@$insurerReply['tempRemoval'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i>Professional fees clause<span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="prof_fee1" class="radio">
                                    <input type="radio" name="prof_fee" value="Agree" id="prof_fee1" class="hidden" @if(@$insurerReply['proFee']['isAgree'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="prof_fee2" class="radio">
                                    <input type="radio" name="prof_fee" value="Not Agree" id="prof_fee2" class="hidden" @if(@$insurerReply['proFee']['isAgree'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form_group">
                                <textarea name="prof_fee_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['proFee']['comment']}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i>Expediting expense clause<span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="expense_clause1" class="radio">
                                    <input type="radio" name="expense_clause" value="Agree" id="expense_clause1" class="hidden" @if(@$insurerReply['expenseClause']['isAgree'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="expense_clause2" class="radio">
                                    <input type="radio" name="expense_clause" value="Not Agree" id="expense_clause2" class="hidden" @if(@$insurerReply['expenseClause']['isAgree'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form_group">
                                <textarea name="expense_clause_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['expenseClause']['comment']}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i>Designation of property clause<span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="desig_clause1" class="radio">
                                    <input type="radio" name="desig_clause" value="Agree" id="desig_clause1" class="hidden" @if(@$insurerReply['desigClause']['isAgree'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="desig_clause2" class="radio">
                                    <input type="radio" name="desig_clause" value="Not Agree" id="desig_clause2" class="hidden" @if(@$insurerReply['desigClause']['isAgree'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form_group">
                                <textarea name="desig_clause_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['desigClause']['comment']}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i>Cancellation clause-30 days either party subject to pro-rata refund of premium in either case unless a claim attached
                                <span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="cancel_thirty_clause1" class="radio">
                                    <input type="radio" name="cancel_thirty_clause" value="Agree" id="cancel_thirty_clause1" class="hidden" @if(@$insurerReply['cancelThirtyClause'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="cancel_thirty_clause2" class="radio">
                                    <input type="radio" name="cancel_thirty_clause" value="Not Agree" id="cancel_thirty_clause2" class="hidden" @if(@$insurerReply['cancelThirtyClause'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i>Primary insurance clause
                                <span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="primary_insurance_clause1" class="radio">
                                    <input type="radio" name="primary_insurance_clause" value="Agree" id="primary_insurance_clause1" class="hidden" @if(@$insurerReply['primaryInsuranceClause'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="primary_insurance_clause2" class="radio">
                                    <input type="radio" name="primary_insurance_clause" value="Not Agree" id="primary_insurance_clause2" class="hidden" @if(@$insurerReply['primaryInsuranceClause'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i>Payment on account clause<span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="payment_account_clause1" class="radio">
                                    <input type="radio" name="payment_account_clause" value="Agree" id="payment_account_clause1" class="hidden" @if(@$insurerReply['paymentAccountClause']['isAgree'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="payment_account_clause2" class="radio">
                                    <input type="radio" name="payment_account_clause" value="Not Agree" id="payment_account_clause2" class="hidden" @if(@$insurerReply['paymentAccountClause']['isAgree'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form_group">
                                <textarea name="payment_account_clause_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['paymentAccountClause']['comment']}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i>Non-invalidation clause
                                <span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="non_invalid_clause1" class="radio">
                                    <input type="radio" name="non_invalid_clause" value="Agree" id="non_invalid_clause1" class="hidden" @if(@$insurerReply['nonInvalidClause'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="non_invalid_clause2" class="radio">
                                    <input type="radio" name="non_invalid_clause" value="Not Agree" id="non_invalid_clause2" class="hidden" @if(@$insurerReply['nonInvalidClause'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i>Breach of warranty or condition clause
                                <span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="warranty_condition_clause1" class="radio">
                                    <input type="radio" name="warranty_condition_clause" value="Agree" id="warranty_condition_clause1" class="hidden" @if(@$insurerReply['warrantyConditionClause'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="warranty_condition_clause2" class="radio">
                                    <input type="radio" name="warranty_condition_clause" value="Not Agree" id="warranty_condition_clause2" class="hidden" @if(@$insurerReply['warrantyConditionClause'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i>Escalation clause<span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="escalation_clause1" class="radio">
                                    <input type="radio" name="escalation_clause" value="Agree" id="escalation_clause1" class="hidden" @if(@$insurerReply['escalationClause']['isAgree'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="escalation_clause2" class="radio">
                                    <input type="radio" name="escalation_clause" value="Not Agree" id="escalation_clause2" class="hidden" @if(@$insurerReply['escalationClause']['isAgree'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form_group">
                                <textarea name="escalation_clause_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['escalationClause']['comment']}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i>Additional Interest Clause
                                <span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="add_interest_clause1" class="radio">
                                    <input type="radio" name="add_interest_clause" value="Agree" id="add_interest_clause1" class="hidden" @if(@$insurerReply['addInterestClause'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="add_interest_clause2" class="radio">
                                    <input type="radio" name="add_interest_clause" value="Not Agree" id="add_interest_clause2" class="hidden" @if(@$insurerReply['addInterestClause'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i>Improvement and betterment  clause
                                <span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="improvement_clause1" class="radio">
                                    <input type="radio" name="improvement_clause" value="Agree" id="improvement_clause1" class="hidden" @if(@$insurerReply['improvementClause'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="improvement_clause2" class="radio">
                                    <input type="radio" name="improvement_clause" value="Not Agree" id="improvement_clause2" class="hidden" @if(@$insurerReply['improvementClause'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i>Automatic Addition deletion clause to be notified within 30 days period<span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="automaticClause1" class="radio">
                                    <input type="radio" name="automaticClause" value="Agree" id="automaticClause1" class="hidden" @if(@$insurerReply['automaticClause']['isAgree'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="automaticClause2" class="radio">
                                    <input type="radio" name="automaticClause" value="Not Agree" id="automaticClause2" class="hidden" @if(@$insurerReply['automaticClause']['isAgree'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form_group">
                                <textarea name="automaticClause_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['automaticClause']['comment']}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i>Expense to reduce the loss clause<span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="reduse_lose_clause1" class="radio">
                                    <input type="radio" name="reduse_lose_clause" value="Agree" id="reduse_lose_clause1" class="hidden" @if(@$insurerReply['reduseLoseClause']['isAgree'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="reduse_lose_clause2" class="radio">
                                    <input type="radio" name="reduse_lose_clause" value="Not Agree" id="reduse_lose_clause2" class="hidden" @if(@$insurerReply['reduseLoseClause']['isAgree'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form_group">
                                <textarea name="reduse_lose_clause_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['reduseLoseClause']['comment']}}</textarea>
                            </div>
                        </div>
                    </div>
                    @if(isset($pipeline_details['formData']['buildingInclude']) && isset($pipeline_details['formData']['demolitionClause']) &&$pipeline_details['formData']['buildingInclude']!='' && $pipeline_details['formData']['demolitionClause'] == true)
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Demolition clause<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="demolition_clause1" class="radio">
                                        <input type="radio" name="demolition_clause" value="Agree" id="demolition_clause1" class="hidden" @if(@$insurerReply['demolitionClause']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="demolition_clause2" class="radio">
                                        <input type="radio" name="demolition_clause" value="Not Agree" id="demolition_clause2" class="hidden" @if(@$insurerReply['demolitionClause']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="demolition_clause_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['demolitionClause']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i>No control clause
                                <span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="no_control_clause1" class="radio">
                                    <input type="radio" name="no_control_clause" value="Agree" id="no_control_clause1" class="hidden" @if(@$insurerReply['noControlClause'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="no_control_clause2" class="radio">
                                    <input type="radio" name="no_control_clause" value="Not Agree" id="no_control_clause2" class="hidden" @if(@$insurerReply['noControlClause']== 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i>Claims preparation cost clause<span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="preparation_cost_clause1" class="radio">
                                    <input type="radio" name="preparation_cost_clause" value="Agree" id="preparation_cost_clause1" class="hidden" @if(@$insurerReply['preparationCostClause']['isAgree'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="preparation_cost_clause2" class="radio">
                                    <input type="radio" name="preparation_cost_clause" value="Not Agree" id="preparation_cost_clause2" class="hidden" @if(@$insurerReply['preparationCostClause']['isAgree'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form_group">
                                <textarea name="preparation_cost_clause_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['preparationCostClause']['comment']}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i>Cover for property lying in the premises in containers
                                <span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="cover_property_con1" class="radio">
                                    <input type="radio" name="cover_property_con" value="Agree" id="cover_property_con1" class="hidden" @if(@$insurerReply['coverPropertyCon'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="cover_property_con2" class="radio">
                                    <input type="radio" name="cover_property_con" value="Not Agree" id="cover_property_con2" class="hidden" @if(@$insurerReply['coverPropertyCon'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i>Personal effects of employee including tools and bicycles<span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="personal_effects_employee1" class="radio">
                                    <input type="radio" name="personal_effects_employee" value="Agree" id="personal_effects_employee1" class="hidden" @if(@$insurerReply['personalEffectsEmployee']['isAgree'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="personal_effects_employee2" class="radio">
                                    <input type="radio" name="personal_effects_employee" value="Not Agree" id="personal_effects_employee2" class="hidden" @if(@$insurerReply['personalEffectsEmployee']['isAgree'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form_group">
                                <textarea name="personal_effects_employee_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['personalEffectsEmployee']['comment']}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i>Incidental Land Transit<span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="incident_land_transit1" class="radio">
                                    <input type="radio" name="incident_land_transit" value="Agree" id="incident_land_transit1" class="hidden" @if(@$insurerReply['incidentLandTransit']['isAgree'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="incident_land_transit2" class="radio">
                                    <input type="radio" name="incident_land_transit" value="Not Agree" id="incident_land_transit2" class="hidden" @if(@$insurerReply['incidentLandTransit']['isAgree'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form_group">
                                <textarea name="incident_land_transit_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['incidentLandTransit']['comment']}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i>Including loss or damage due to subsidence, ground heave or landslip
                                <span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="loss_or_damage1" class="radio">
                                    <input type="radio" name="loss_or_damage" value="Agree" id="loss_or_damage1" class="hidden" @if(@$insurerReply['lossOrDamage'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="loss_or_damage2" class="radio">
                                    <input type="radio" name="loss_or_damage" value="Not Agree" id="loss_or_damage2" class="hidden" @if(@$insurerReply['lossOrDamage'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i>Nominated Loss Adjuster clause-Insured can select the loss surveyor out of a panel – John Kidd LA, Cunningham Lindsey, & Miller International<span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="nominated_loss_adjuster_clause1" class="radio">
                                    <input type="radio" name="nominated_loss_adjuster_clause" value="Agree" id="nominated_loss_adjuster_clause1" class="hidden" @if(@$insurerReply['nominatedLossAdjusterClause']['isAgree'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="nominated_loss_adjuster_clause2" class="radio">
                                    <input type="radio" name="nominated_loss_adjuster_clause" value="Not Agree" id="nominated_loss_adjuster_clause2" class="hidden" @if(@$insurerReply['nominatedLossAdjusterClause']['isAgree'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form_group">
                                <textarea name="nominated_loss_adjuster_clause_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['nominatedLossAdjusterClause']['comment']}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i>Sprinkler leakage clause
                                <span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="sprinker_leakage1" class="radio">
                                    <input type="radio" name="sprinker_leakage" value="Agree" id="sprinker_leakage1" class="hidden" @if(@$insurerReply['sprinkerLeakage'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="sprinker_leakage2" class="radio">
                                    <input type="radio" name="sprinker_leakage" value="Not Agree" id="sprinker_leakage2" class="hidden" @if(@$insurerReply['sprinkerLeakage'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i>Minimization of loss clause<span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="min_loss_clause1" class="radio">
                                    <input type="radio" name="min_loss_clause" value="Agree" id="min_loss_clause1" class="hidden" @if(@$insurerReply['minLossClause']['isAgree'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="min_loss_clause2" class="radio">
                                    <input type="radio" name="min_loss_clause" value="Not Agree" id="min_loss_clause2" class="hidden" @if(@$insurerReply['minLossClause']['isAgree'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form_group">
                                <textarea name="min_loss_clause_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['minLossClause']['comment']}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i>Increased cost of construction<span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="cost_construction1" class="radio">
                                    <input type="radio" name="cost_construction" value="Agree" id="cost_construction1" class="hidden" @if(@$insurerReply['costConstruction']['isAgree'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="cost_construction2" class="radio">
                                    <input type="radio" name="cost_construction" value="Not Agree" id="cost_construction2" class="hidden" @if(@$insurerReply['costConstruction']['isAgree'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form_group">
                                <textarea name="cost_construction_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['costConstruction']['comment']}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i>Property Valuation clause<span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="property_valuation_clause1" class="radio">
                                    <input type="radio" name="property_valuation_clause" value="Agree" id="property_valuation_clause1" class="hidden" @if(@$insurerReply['propertyValuationClause']['isAgree'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="property_valuation_clause2" class="radio">
                                    <input type="radio" name="property_valuation_clause" value="Not Agree" id="property_valuation_clause2" class="hidden" @if(@$insurerReply['propertyValuationClause']['isAgree'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form_group">
                                <textarea name="property_valuation_clause_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['propertyValuationClause']['comment']}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i>Including accidental damage to plate glass, interior and exterior signs<span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="accidental_damage1" class="radio">
                                    <input type="radio" name="accidental_damage" value="Agree" id="accidental_damage1" class="hidden" @if(@$insurerReply['accidentalDamage']['isAgree'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="accidental_damage2" class="radio">
                                    <input type="radio" name="accidental_damage" value="Not Agree" id="accidental_damage2" class="hidden" @if(@$insurerReply['accidentalDamage']['isAgree'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form_group">
                                <textarea name="accidental_damage_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['accidentalDamage']['comment']}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i>Auditor’s fee<span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="auditors_fee1" class="radio">
                                    <input type="radio" name="auditors_fee" value="Agree" id="auditors_fee1" class="hidden" @if(@$insurerReply['auditorsFee']['isAgree'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="auditors_fee2" class="radio">
                                    <input type="radio" name="auditors_fee" value="Not Agree" id="auditors_fee2" class="hidden" @if(@$insurerReply['auditorsFee']['isAgree'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form_group">
                                <textarea name="auditors_fee_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['auditorsFee']['comment']}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i>Smoke and Soot damage extension
                                <span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="smoke_soot1" class="radio">
                                    <input type="radio" name="smoke_soot" value="Agree" id="smoke_soot1" class="hidden" @if(@$insurerReply['smokeSoot'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="smoke_soot2" class="radio">
                                    <input type="radio" name="smoke_soot" value="Not Agree" id="smoke_soot2" class="hidden" @if(@$insurerReply['smokeSoot'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i>Boiler explosion extension
                                <span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="boiler_explosion1" class="radio">
                                    <input type="radio" name="boiler_explosion" value="Agree" id="boiler_explosion1" class="hidden" @if(@$insurerReply['boilerExplosion'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="boiler_explosion2" class="radio">
                                    <input type="radio" name="boiler_explosion" value="Not Agree" id="boiler_explosion2" class="hidden" @if(@$insurerReply['boilerExplosion'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i>Strike riot and civil commotion clause<span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="strike_riot1" class="radio">
                                    <input type="radio" name="strike_riot" value="Agree" id="strike_riot1" class="hidden" @if(@$insurerReply['strikeRiot']['isAgree'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="strike_riot2" class="radio">
                                    <input type="radio" name="strike_riot" value="Not Agree" id="strike_riot2" class="hidden" @if(@$insurerReply['strikeRiot']['isAgree'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form_group">
                                <textarea name="strike_riot_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['strikeRiot']['comment']}}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i>Extra charges for airfreight<span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="charge_airfreight1" class="radio">
                                    <input type="radio" name="charge_airfreight" value="Agree" id="charge_airfreight1" class="hidden" @if(@$insurerReply['chargeAirfreight']['isAgree'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="charge_airfreight2" class="radio">
                                    <input type="radio" name="charge_airfreight" value="Not Agree" id="charge_airfreight2" class="hidden" @if(@$insurerReply['chargeAirfreight']['isAgree'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form_group">
                                <textarea name="charge_airfreight_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['chargeAirfreight']['comment']}}</textarea>
                            </div>
                        </div>
                    </div>
                    @if($pipeline_details['formData']['machinery']!='')
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Malicious damage / mischief, vandalism
                                    <span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="malicious_damage1" class="radio">
                                        <input type="radio" name="malicious_damage" value="Agree" id="malicious_damage1" class="hidden" @if(@$insurerReply['maliciousDamage'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="malicious_damage2" class="radio">
                                        <input type="radio" name="malicious_damage" value="Not Agree" id="malicious_damage2" class="hidden" @if(@$insurerReply['maliciousDamage'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Burglary Extension
                                    <span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="burglary_extension1" class="radio">
                                        <input type="radio" name="burglary_extension" value="Agree" id="burglary_extension1" class="hidden" @if(@$insurerReply['burglaryExtension'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="burglary_extension2" class="radio">
                                        <input type="radio" name="burglary_extension" value="Not Agree" id="burglary_extension2" class="hidden" @if(@$insurerReply['burglaryExtension'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Burglary Extension for diesel tank and similar storage facilities in the open<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="burglary_facilities1" class="radio">
                                        <input type="radio" name="burglary_facilities" value="Agree" id="burglary_facilities1" class="hidden" @if(@$insurerReply['burglaryFacilities']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="burglary_facilities2" class="radio">
                                        <input type="radio" name="burglary_facilities" value="Not Agree" id="burglary_facilities2" class="hidden" @if(@$insurerReply['burglaryFacilities']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="burglary_facilities_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['burglaryFacilities']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Tsunami
                                    <span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="tsunami1" class="radio">
                                        <input type="radio" name="tsunami" value="Agree" id="tsunami1" class="hidden" @if(@$insurerReply['tsunami'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="tsunami2" class="radio">
                                        <input type="radio" name="tsunami" value="Not Agree" id="tsunami2" class="hidden" @if(@$insurerReply['tsunami'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Cover for mobile plant<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="mobile_plant1" class="radio">
                                        <input type="radio" name="mobile_plant" value="Agree" id="mobile_plant1" class="hidden" @if(@$insurerReply['mobilePlant']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="mobile_plant2" class="radio">
                                        <input type="radio" name="mobile_plant" value="Not Agree" id="mobile_plant2" class="hidden" @if(@$insurerReply['mobilePlant']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="mobile_plant_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['mobilePlant']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Clearance of drains<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="clearance_drains1" class="radio">
                                        <input type="radio" name="clearance_drains" value="Agree" id="clearance_drains1" class="hidden" @if(@$insurerReply['clearanceDrains']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="clearance_drains2" class="radio">
                                        <input type="radio" name="clearance_drains" value="Not Agree" id="clearance_drains2" class="hidden" @if(@$insurerReply['clearanceDrains']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="clearance_drains_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['clearanceDrains']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Accidental discharge of fire protection<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="accidental_fire1" class="radio">
                                        <input type="radio" name="accidental_fire" value="Agree" id="accidental_fire1" class="hidden" @if(@$insurerReply['accidentalFire']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="accidental_fire2" class="radio">
                                        <input type="radio" name="accidental_fire" value="Not Agree" id="accidental_fire2" class="hidden" @if(@$insurerReply['accidentalFire']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="accidental_fire_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['accidentalFire']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Locating source of leak<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="locationg_source1" class="radio">
                                        <input type="radio" name="locationg_source" value="Agree" id="locationg_source1" class="hidden" @if(@$insurerReply['locationgSource']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="locationg_source2" class="radio">
                                        <input type="radio" name="locationg_source" value="Not Agree" id="locationg_source2" class="hidden" @if(@$insurerReply['locationgSource']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="locationg_source_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['locationgSource']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Re-writing of records<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="re_writing1" class="radio">
                                        <input type="radio" name="re_writing" value="Agree" id="re_writing1" class="hidden" @if(@$insurerReply['reWriting']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="re_writing2" class="radio">
                                        <input type="radio" name="re_writing" value="Not Agree" id="re_writing2" class="hidden" @if(@$insurerReply['reWriting']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="re_writing_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['reWriting']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Landslip full subsidence and ground heave
                                    <span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="land_slip1" class="radio">
                                        <input type="radio" name="land_slip" value="Agree" id="land_slip1" class="hidden" @if(@$insurerReply['landSlip'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="land_slip2" class="radio">
                                        <input type="radio" name="land_slip" value="Not Agree" id="land_slip2" class="hidden" @if(@$insurerReply['landSlip'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Civil authority clause<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="civil_authority1" class="radio">
                                        <input type="radio" name="civil_authority" value="Agree" id="civil_authority1" class="hidden" @if(@$insurerReply['civilAuthority']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="civil_authority2" class="radio">
                                        <input type="radio" name="civil_authority" value="Not Agree" id="civil_authority2" class="hidden" @if(@$insurerReply['civilAuthority']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="civil_authority_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['civilAuthority']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Documents / plans / specification clause<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="documents_plans1" class="radio">
                                        <input type="radio" name="documents_plans" value="Agree" id="documents_plans1" class="hidden" @if(@$insurerReply['documentsPlans']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="documents_plans2" class="radio">
                                        <input type="radio" name="documents_plans" value="Not Agree" id="documents_plans2" class="hidden" @if(@$insurerReply['documentsPlans']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="documents_plans_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['documentsPlans']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Property held intrust for comission<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="property_construction1" class="radio">
                                        <input type="radio" name="property_construction" value="Agree" id="property_construction1" class="hidden" @if(@$insurerReply['propertyConstruction']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="property_construction2" class="radio">
                                        <input type="radio" name="property_construction" value="Not Agree" id="property_construction2" class="hidden" @if(@$insurerReply['propertyConstruction']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="property_construction_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['propertyConstruction']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Architecture or surveyor, consulting engineer & other professional fee<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="architecture1" class="radio">
                                        <input type="radio" name="architecture" value="Agree" id="architecture1" class="hidden" @if(@$insurerReply['architecture']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="architecture2" class="radio">
                                        <input type="radio" name="architecture" value="Not Agree" id="architecture2" class="hidden" @if(@$insurerReply['architecture']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="architecture_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['architecture']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Automatic extension for one month<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="automatic_extension1" class="radio">
                                        <input type="radio" name="automatic_extension" value="Agree" id="automatic_extension1" class="hidden" @if(@$insurerReply['automaticExtension']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="automatic_extension2" class="radio">
                                        <input type="radio" name="automatic_extension" value="Not Agree" id="automatic_extension2" class="hidden" @if(@$insurerReply['automaticExtension']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="automatic_extension_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['automaticExtension']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Mortgage clause<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="mortguage_clause1" class="radio">
                                        <input type="radio" name="mortguage_clause" value="Agree" id="mortguage_clause1" class="hidden" @if(@$insurerReply['mortguageClause']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="mortguage_clause2" class="radio">
                                        <input type="radio" name="mortguage_clause" value="Not Agree" id="mortguage_clause2" class="hidden" @if(@$insurerReply['mortguageClause']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="mortguage_clause_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['mortguageClause']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Survey committee clause<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="survey_committee1" class="radio">
                                        <input type="radio" name="survey_committee" value="Agree" id="survey_committee1" class="hidden" @if(@$insurerReply['surveyCommittee']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="survey_committee2" class="radio">
                                        <input type="radio" name="survey_committee" value="Not Agree" id="survey_committee2" class="hidden" @if(@$insurerReply['surveyCommittee']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="survey_committee_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['surveyCommittee']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Expense to protect preserve or reduce the loss<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="protect_expense1" class="radio">
                                        <input type="radio" name="protect_expense" value="Agree" id="protect_expense1" class="hidden" @if(@$insurerReply['protectExpense']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="protect_expense2" class="radio">
                                        <input type="radio" name="protect_expense" value="Not Agree" id="protect_expense2" class="hidden" @if(@$insurerReply['protectExpense']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="protect_expense_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['protectExpense']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Tenants Clause<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="tenats_clause1" class="radio">
                                        <input type="radio" name="tenats_clause" value="Agree" id="tenats_clause1" class="hidden" @if(@$insurerReply['tenatsClause']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="tenats_clause2" class="radio">
                                        <input type="radio" name="tenats_clause" value="Not Agree" id="tenats_clause2" class="hidden" @if(@$insurerReply['tenatsClause']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="tenats_clause_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['tenatsClause']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Keys and Lock replacement clause<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="keys_lock_clause1" class="radio">
                                        <input type="radio" name="keys_lock_clause" value="Agree" id="keys_lock_clause1" class="hidden" @if(@$insurerReply['keysLockClause']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="keys_lock_clause2" class="radio">
                                        <input type="radio" name="keys_lock_clause" value="Not Agree" id="keys_lock_clause2" class="hidden" @if(@$insurerReply['keysLockClause']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="keys_lock_clause_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['keysLockClause']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Exploratory Cost<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="exploratory_cost1" class="radio">
                                        <input type="radio" name="exploratory_cost" value="Agree" id="exploratory_cost1" class="hidden" @if(@$insurerReply['exploratoryCost']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="exploratory_cost2" class="radio">
                                        <input type="radio" name="exploratory_cost" value="Not Agree" id="exploratory_cost2" class="hidden" @if(@$insurerReply['exploratoryCost']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="exploratory_cost_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['exploratoryCost']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                       
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Property in the open or open sided sheds other than building structure and machineries which are designed to exist and to operate in the open<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="property_details1" class="radio">
                                        <input type="radio" name="property_details" value="Agree" id="property_details1" class="hidden" @if(@$insurerReply['propertyDetails']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="property_details2" class="radio">
                                        <input type="radio" name="property_details" value="Not Agree" id="property_details2" class="hidden" @if(@$insurerReply['propertyDetails']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="property_details_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['propertyDetails']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Smoke and soot damage extension
                                    <span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="smoke_soot_damage1" class="radio">
                                        <input type="radio" name="smoke_soot_damage" value="Agree" id="smoke_soot_damage1" class="hidden" @if(@$insurerReply['smokeSootDamage'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="smoke_soot_damage2" class="radio">
                                        <input type="radio" name="smoke_soot_damage" value="Not Agree" id="smoke_soot_damage2" class="hidden" @if(@$insurerReply['smokeSootDamage'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Impact damage due to own vehicle and / or animals / third party vehicles
                                    <span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="impact_damage1" class="radio">
                                        <input type="radio" name="impact_damage" value="Agree" id="impact_damage1" class="hidden" @if(@$insurerReply['impactDamage'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="impact_damage2" class="radio">
                                        <input type="radio" name="impact_damage" value="Not Agree" id="impact_damage2" class="hidden" @if(@$insurerReply['impactDamage'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>cover for bursting,overflowing, discharging,or leaking of water tanks apparatus or pipes when premises are empty or disused
                                    <span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="cover_status1" class="radio">
                                        <input type="radio" name="cover_status" value="Agree" id="cover_status1" class="hidden" @if(@$insurerReply['coverStatus'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="cover_status2" class="radio">
                                        <input type="radio" name="cover_status" value="Not Agree" id="cover_status2" class="hidden" @if(@$insurerReply['coverStatus'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>curious and work of art<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="curious_work_art1" class="radio">
                                        <input type="radio" name="curious_work_art" value="Agree" id="curious_work_art1" class="hidden" @if(@$insurerReply['curiousWorkArt']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="curious_work_art2" class="radio">
                                        <input type="radio" name="curious_work_art" value="Not Agree" id="curious_work_art2" class="hidden" @if(@$insurerReply['curiousWorkArt']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="curious_work_art_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['curiousWorkArt']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>sprinkler inoperative clause
                                    <span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="sprinkler_inoperative_clause1" class="radio">
                                        <input type="radio" name="sprinkler_inoperative_clause" value="Agree" id="sprinkler_inoperative_clause1" class="hidden" @if(@$insurerReply['sprinklerInoperativeClause'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="sprinkler_inoperative_clause2" class="radio">
                                        <input type="radio" name="sprinkler_inoperative_clause" value="Not Agree" id="sprinkler_inoperative_clause2" class="hidden" @if(@$insurerReply['sprinklerInoperativeClause'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Sprinkler upgradation<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="sprinkler_upgradation1" class="radio">
                                        <input type="radio" name="sprinkler_upgradation" value="Agree" id="sprinkler_upgradation1" class="hidden" @if(@$insurerReply['sprinklerUpgradation']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="sprinkler_upgradation2" class="radio">
                                        <input type="radio" name="sprinkler_upgradation" value="Not Agree" id="sprinkler_upgradation2" class="hidden" @if(@$insurerReply['sprinklerUpgradation']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="sprinkler_upgradation_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['sprinklerUpgradation']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Fire protection system updating<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="fire_protection1" class="radio">
                                        <input type="radio" name="fire_protection" value="Agree" id="fire_protection1" class="hidden" @if(@$insurerReply['fireProtection']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="fire_protection2" class="radio">
                                        <input type="radio" name="fire_protection" value="Not Agree" id="fire_protection2" class="hidden" @if(@$insurerReply['fireProtection']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="fire_protection_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['fireProtection']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Burglary extension from diesel tank and similar storage facilities<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="burglary_extension_diesel1" class="radio">
                                        <input type="radio" name="burglary_extension_diesel" value="Agree" id="burglary_extension_diesel1" class="hidden" @if(@$insurerReply['burglaryExtensionDiesel']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="burglary_extension_diesel2" class="radio">
                                        <input type="radio" name="burglary_extension_diesel" value="Not Agree" id="burglary_extension_diesel2" class="hidden" @if(@$insurerReply['burglaryExtensionDiesel']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="burglary_extension_diesel_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['burglaryExtensionDiesel']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>machinery breakdown extension<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="machinery_breakdown1" class="radio">
                                        <input type="radio" name="machinery_breakdown" value="Agree" id="machinery_breakdown1" class="hidden" @if(@$insurerReply['machineryBreakdown']['isAgree']== 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="machinery_breakdown2" class="radio">
                                        <input type="radio" name="machinery_breakdown" value="Not Agree" id="machinery_breakdown2" class="hidden" @if(@$insurerReply['machineryBreakdown']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="machinery_breakdown_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['machineryBreakdown']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Cover of extra charges for overtime, nightwork, work on public holidays exprss freight, air freight<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="extra_cover1" class="radio">
                                        <input type="radio" name="extra_cover" value="Agree" id="extra_cover1" class="hidden" @if(@$insurerReply['extraCover']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="extra_cover2" class="radio">
                                        <input type="radio" name="extra_cover" value="Not Agree" id="extra_cover2" class="hidden" @if(@$insurerReply['extraCover']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="extra_cover_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['extraCover']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Dishonesty, Dissappearance, Distraction<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="dissappearance_details1" class="radio">
                                        <input type="radio" name="dissappearance_details" value="Agree" id="dissappearance_details1" class="hidden" @if(@$insurerReply['dissappearanceDetails']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="dissappearance_details2" class="radio">
                                        <input type="radio" name="dissappearance_details" value="Not Agree" id="dissappearance_details2" class="hidden" @if(@$insurerReply['dissappearanceDetails']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="dissappearance_details_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['dissappearanceDetails']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Elaboration of coverage<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="elaboration_coverage1" class="radio">
                                        <input type="radio" name="elaboration_coverage" value="Agree" id="elaboration_coverage1" class="hidden" @if(@$insurerReply['elaborationCoverage']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="elaboration_coverage2" class="radio">
                                        <input type="radio" name="elaboration_coverage" value="Not Agree" id="elaboration_coverage2" class="hidden" @if(@$insurerReply['elaborationCoverage']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="elaboration_coverage_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['elaborationCoverage']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Permit clause
                                    <span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="permit_clause1" class="radio">
                                        <input type="radio" name="permit_clause" value="Agree" id="permit_clause1" class="hidden" @if(@$insurerReply['permitClause'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="permit_clause2" class="radio">
                                        <input type="radio" name="permit_clause" value="Not Agree" id="permit_clause2" class="hidden" @if(@$insurerReply['permitClause'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Repurchase
                                    <span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="repurchase1" class="radio">
                                        <input type="radio" name="repurchase" value="Agree" id="repurchase1" class="hidden" @if(@$insurerReply['repurchase'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="repurchase2" class="radio">
                                        <input type="radio" name="repurchase" value="Not Agree" id="repurchase2" class="hidden" @if(@$insurerReply['repurchase'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Bankruptcy & insolvancy
                                    <span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="bankruptcy1" class="radio">
                                        <input type="radio" name="bankruptcy" value="Agree" id="bankruptcy1" class="hidden" @if(@$insurerReply['bankruptcy'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="bankruptcy2" class="radio">
                                        <input type="radio" name="bankruptcy" value="Not Agree" id="bankruptcy2" class="hidden" @if(@$insurerReply['bankruptcy'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Aircraft damage
                                    <span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="aircraft_damage1" class="radio">
                                        <input type="radio" name="aircraft_damage" value="Agree" id="aircraft_damage1" class="hidden" @if(@$insurerReply['aircraftDamage'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="aircraft_damage2" class="radio">
                                        <input type="radio" name="aircraft_damage" value="Not Agree" id="aircraft_damage2" class="hidden" @if(@$insurerReply['aircraftDamage'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Appraisement clause
                                    <span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="appraisement_clause1" class="radio">
                                        <input type="radio" name="appraisement_clause" value="Agree" id="appraisement_clause1" class="hidden" @if(@$insurerReply['appraisementClause'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="appraisement_clause2" class="radio">
                                        <input type="radio" name="appraisement_clause" value="Not Agree" id="appraisement_clause2" class="hidden" @if(@$insurerReply['appraisementClause'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Assiatnce and co-operation of the Insured
                                    <span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="assiatnce_insured1" class="radio">
                                        <input type="radio" name="assiatnce_insured" value="Agree" id="assiatnce_insured1" class="hidden" @if(@$insurerReply['assiatnceInsured'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="assiatnce_insured2" class="radio">
                                        <input type="radio" name="assiatnce_insured" value="Not Agree" id="assiatnce_insured2" class="hidden" @if(@$insurerReply['assiatnceInsured'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Money in Safe<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="money_safe1" class="radio">
                                        <input type="radio" name="money_safe" value="Agree" id="money_safe1" class="hidden" @if(@$insurerReply['moneySafe']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="money_safe2" class="radio">
                                        <input type="radio" name="money_safe" value="Not Agree" id="money_safe2" class="hidden" @if(@$insurerReply['moneySafe']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="money_safe_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['moneySafe']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Money in transit<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="money_transit1" class="radio">
                                        <input type="radio" name="money_transit" value="Agree" id="money_transit1" class="hidden" @if(@$insurerReply['moneyTransit']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="money_transit2" class="radio">
                                        <input type="radio" name="money_transit" value="Not Agree" id="money_transit2" class="hidden" @if(@$insurerReply['moneyTransit']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="money_transit_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['moneyTransit']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Computers all risk including damages to computers, additional expenses and media reconstruction cost<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="computers_all_risk1" class="radio">
                                        <input type="radio" name="computers_all_risk" value="Agree" id="computers_all_risk1" class="hidden" @if(@$insurerReply['computersAllRisk']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="computers_all_risk2" class="radio">
                                        <input type="radio" name="computers_all_risk" value="Not Agree" id="computers_all_risk2" class="hidden" @if(@$insurerReply['computersAllRisk']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="computers_all_risk_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['computersAllRisk']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Cover for deterioration due to change in temperature or humidity or failure / inadequate operation of an airconditioning cooling or heating system<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="cover_for_deterioration1" class="radio">
                                        <input type="radio" name="cover_for_deterioration" value="Agree" id="cover_for_deterioration1" class="hidden" @if(@$insurerReply['coverForDeterioration']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="cover_for_deterioration2" class="radio">
                                        <input type="radio" name="cover_for_deterioration" value="Not Agree" id="cover_for_deterioration2" class="hidden" @if(@$insurerReply['coverForDeterioration']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="cover_for_deterioration_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['coverForDeterioration']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Hail Damage
                                    <span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="hail_damage1" class="radio">
                                        <input type="radio" name="hail_damage" value="Agree" id="hail_damage1" class="hidden" @if(@$insurerReply['hailDamage'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="hail_damage2" class="radio">
                                        <input type="radio" name="hail_damage" value="Not Agree" id="hail_damage2" class="hidden" @if(@$insurerReply['hailDamage'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Hazardous materials and / or substances
                                    <span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="hazardous_materials1" class="radio">
                                        <input type="radio" name="hazardous_materials" value="Agree" id="hazardous_materials1" class="hidden" @if(@$insurerReply['hazardousMaterialsSlip'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="hazardous_materials2" class="radio">
                                        <input type="radio" name="hazardous_materials" value="Not Agree" id="hazardous_materials2" class="hidden" @if(@$insurerReply['hazardousMaterialsSlip'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>thunderbolt and or lightening
                                    <span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="thunderbolt_lightening1" class="radio">
                                        <input type="radio" name="thunderbolt_lightening" value="Agree" id="thunderbolt_lightening1" class="hidden" @if(@$insurerReply['thunderboltLightening'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="thunderbolt_lightening2" class="radio">
                                        <input type="radio" name="thunderbolt_lightening" value="Not Agree" id="thunderbolt_lightening2" class="hidden" @if(@$insurerReply['thunderboltLightening'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Water / rain damage
                                    <span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="water_rain1" class="radio">
                                        <input type="radio" name="water_rain" value="Agree" id="water_rain1" class="hidden" @if(@$insurerReply['waterRain'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="water_rain2" class="radio">
                                        <input type="radio" name="water_rain" value="Not Agree" id="water_rain2" class="hidden" @if(@$insurerReply['waterRain'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Specified locations cover<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="specified_locations1" class="radio">
                                        <input type="radio" name="specified_locations" value="Agree" id="specified_locations1" class="hidden" @if(@$insurerReply['specifiedLocations']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="specified_locations2" class="radio">
                                        <input type="radio" name="specified_locations" value="Not Agree" id="specified_locations2" class="hidden" @if(@$insurerReply['specifiedLocations']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="specified_locations_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['specifiedLocations']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Cover to include portable items worldwide<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="portable_items1" class="radio">
                                        <input type="radio" name="portable_items" value="Agree" id="portable_items1" class="hidden" @if(@$insurerReply['portableItems']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="portable_items2" class="radio">
                                        <input type="radio" name="portable_items" value="Not Agree" id="portable_items2" class="hidden" @if(@$insurerReply['portableItems']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="portable_items_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['portableItems']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>New property and alteration<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="property_and_alteration1" class="radio">
                                        <input type="radio" name="property_and_alteration" value="Agree" id="property_and_alteration1" class="hidden" @if(@$insurerReply['propertyAndAlteration']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="property_and_alteration2" class="radio">
                                        <input type="radio" name="property_and_alteration" value="Not Agree" id="property_and_alteration2" class="hidden" @if(@$insurerReply['propertyAndAlteration']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="property_and_alteration_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['propertyAndAlteration']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Dismantleing and re-erection extension<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="dismantleing_ext1" class="radio">
                                        <input type="radio" name="dismantleing_ext" value="Agree" id="dismantleing_ext1" class="hidden" @if(@$insurerReply['dismantleingExt']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="dismantleing_ext2" class="radio">
                                        <input type="radio" name="dismantleing_ext" value="Not Agree" id="dismantleing_ext2" class="hidden" @if(@$insurerReply['dismantleingExt']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="dismantleing_ext_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['dismantleingExt']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Automatic cover for newly purchased items<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="automatic_purchase1" class="radio">
                                        <input type="radio" name="automatic_purchase" value="Agree" id="automatic_purchase1" class="hidden" @if(@$insurerReply['automaticPurchase']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="automatic_purchase2" class="radio">
                                        <input type="radio" name="automatic_purchase" value="Not Agree" id="automatic_purchase2" class="hidden" @if(@$insurerReply['automaticPurchase']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="automatic_purchase_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['automaticPurchase']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Cover for Trees, Shrubs, Plants, Lawns, Rockwork<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="cover_for_trees1" class="radio">
                                        <input type="radio" name="cover_for_trees" value="Agree" id="cover_for_trees1" class="hidden" @if(@$insurerReply['coverForTrees']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="cover_for_trees2" class="radio">
                                        <input type="radio" name="cover_for_trees" value="Not Agree" id="cover_for_trees2" class="hidden" @if(@$insurerReply['coverForTrees']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="cover_for_trees_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['automaticPurchase']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Reward for Information<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="inform_reward1" class="radio">
                                        <input type="radio" name="inform_reward" value="Agree" id="inform_reward1" class="hidden" @if(@$insurerReply['informReward']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="inform_reward2" class="radio">
                                        <input type="radio" name="inform_reward" value="Not Agree" id="inform_reward2" class="hidden" @if(@$insurerReply['informReward']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="inform_reward_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['informReward']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Cover to include Landscaping, Fountains, Drive ways, pavement roads, minor arches and other similar items within the insured property
                                    <span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="cover_landscape1" class="radio">
                                        <input type="radio" name="cover_landscape" value="Agree" id="cover_landscape1" class="hidden" @if(@$insurerReply['coverLandscape'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="cover_landscape2" class="radio">
                                        <input type="radio" name="cover_landscape" value="Not Agree" id="cover_landscape2" class="hidden" @if(@$insurerReply['coverLandscape'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Damage to walls, gates fences, neon, signs, flag poles, landscaping and other properties intented to exist or operate in the open
                                    <span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="damage_walls1" class="radio">
                                        <input type="radio" name="damage_walls" value="Agree" id="damage_walls1" class="hidden" @if(@$insurerReply['damageWalls'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="damage_walls2" class="radio">
                                        <input type="radio" name="damage_walls" value="Not Agree" id="damage_walls2" class="hidden" @if(@$insurerReply['damageWalls'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        @if($pipeline_details['formData']['occupancy']['type'] == "Building")
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form_label bold"><i class="fa fa-circle"></i>During fit out works, renovation works, or any alteration/repairs all losses above the limit of the PESP of CAR should be covered under the property<span>*</span></label>
                                </div>
                                <div class="form_group" style="padding-left: 15px;">
                                    <div class="cntr">
                                        <label for="fit_out_works1" class="radio">
                                            <input type="radio" name="fit_out_works" value="Agree" id="fit_out_works1" class="hidden" @if(@$insurerReply['fitOutWorks']['isAgree'] == 'Agree') checked @endif/>
                                            <span class="label"></span>
                                            <span>Agree</span>
                                        </label>
                                        <label for="fit_out_works2" class="radio">
                                            <input type="radio" name="fit_out_works" value="Not Agree" id="fit_out_works2" class="hidden" @if(@$insurerReply['fitOutWorks']['isAgree'] == 'Not Agree') checked @endif/>
                                            <span class="label"></span>
                                            <span>Not Agree</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form_group">
                                        <textarea name="fit_out_works_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['fitOutWorks']['comment']}}</textarea>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i>Cover for  mechanical, electrical and electronic breakdown  for fixed non-mobile plant and machinery
                                <span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="cover_mechanical1" class="radio">
                                    <input type="radio" name="cover_mechanical" value="Agree" id="cover_mechanical1" class="hidden" @if(@$insurerReply['coverMechanical'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="cover_mechanical2" class="radio">
                                    <input type="radio" name="cover_mechanical" value="Not Agree" id="cover_mechanical2" class="hidden" @if(@$insurerReply['coverMechanical'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i>Cover for external works including sign boards,  landscaping  including trees in building
                                <span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="cover_ext_work1" class="radio">
                                    <input type="radio" name="cover_ext_work" value="Agree" id="cover_ext_work1" class="hidden" @if(@$insurerReply['coverExtWork'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="cover_ext_work2" class="radio">
                                    <input type="radio" name="cover_ext_work" value="Not Agree" id="cover_ext_work2" class="hidden" @if(@$insurerReply['coverExtWork'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i>Misdescription Clause
                                <span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="misdescription_clause1" class="radio">
                                    <input type="radio" name="misdescription_clause" value="Agree" id="misdescription_clause1" class="hidden" @if(@$insurerReply['misdescriptionClause'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="misdescription_clause2" class="radio">
                                    <input type="radio" name="misdescription_clause" value="Not Agree" id="misdescription_clause2" class="hidden" @if(@$insurerReply['misdescriptionClause'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i>Temporary removal clause
                                <span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="temp_removal_clause1" class="radio">
                                    <input type="radio" name="temp_removal_clause" value="Agree" id="temp_removal_clause1" class="hidden" @if(@$insurerReply['tempRemovalClause'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="temp_removal_clause2" class="radio">
                                    <input type="radio" name="temp_removal_clause" value="Not Agree" id="temp_removal_clause2" class="hidden" @if(@$insurerReply['tempRemovalClause'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i>Other insurance allowed clause
                                <span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="other_insurance_clause1" class="radio">
                                    <input type="radio" name="other_insurance_clause" value="Agree" id="other_insurance_clause1" class="hidden" @if(@$insurerReply['otherInsuranceClause'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="other_insurance_clause2" class="radio">
                                    <input type="radio" name="other_insurance_clause" value="Not Agree" id="other_insurance_clause2" class="hidden" @if(@$insurerReply['otherInsuranceClause'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i>Automatic acquisition clause
                                <span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="automatic_acq_clause1" class="radio">
                                    <input type="radio" name="automatic_acq_clause" value="Agree" id="automatic_acq_clause1" class="hidden" @if(@$insurerReply['automaticAcqClause'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="automatic_acq_clause2" class="radio">
                                    <input type="radio" name="automatic_acq_clause" value="Not Agree" id="automatic_acq_clause2" class="hidden" @if(@$insurerReply['automaticAcqClause'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i>Minor works extension<span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="minor_work_ext1" class="radio">
                                    <input type="radio" name="minor_work_ext" value="Agree" id="minor_work_ext1" class="hidden" @if(@$insurerReply['minorWorkExt']['isAgree'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="minor_work_ext2" class="radio">
                                    <input type="radio" name="minor_work_ext" value="Not Agree" id="minor_work_ext2" class="hidden" @if(@$insurerReply['minorWorkExt']['isAgree'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form_group">
                                <textarea name="minor_work_ext_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['minorWorkExt']['comment']}}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i>Sale of Interest Clause
                                <span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="sale_interest_clause1" class="radio">
                                    <input type="radio" name="sale_interest_clause" value="Agree" id="sale_interest_clause1" class="hidden" @if(@$insurerReply['saleInterestClause'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="sale_interest_clause2" class="radio">
                                    <input type="radio" name="sale_interest_clause" value="Not Agree" id="sale_interest_clause2" class="hidden" @if(@$insurerReply['saleInterestClause'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i>Sue and labour clause
                                <span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="sue_labour_clause1" class="radio">
                                    <input type="radio" name="sue_labour_clause" value="Agree" id="sue_labour_clause1" class="hidden" @if(@$insurerReply['sueLabourClause'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="sue_labour_clause2" class="radio">
                                    <input type="radio" name="sue_labour_clause" value="Not Agree" id="sue_labour_clause2" class="hidden" @if(@$insurerReply['sueLabourClause'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i>Electrical clause waiver- Loss or damage by fire to electrical or electronic appliances , installations and wiring insured by this policy arising from or occasioned by over running, overheating excessive current, short circuiting, arcing, self-heating or leakage of electricity from whatever cause (lightning included) is covered
                                <span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="electrical_cause1" class="radio">
                                    <input type="radio" name="electrical_cause" value="Agree" id="electrical_cause1" class="hidden" @if(@$insurerReply['electricalClause'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="electrical_cause2" class="radio">
                                    <input type="radio" name="electrical_cause" value="Not Agree" id="electrical_cause2" class="hidden" @if(@$insurerReply['electricalClause'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i>Contract price clause
                                <span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="contract_price_clause1" class="radio">
                                    <input type="radio" name="contract_price_clause" value="Agree" id="contract_price_clause1" class="hidden" @if(@$insurerReply['contractPriceClause'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="contract_price_clause2" class="radio">
                                    <input type="radio" name="contract_price_clause" value="Not Agree" id="contract_price_clause2" class="hidden" @if(@$insurerReply['contractPriceClause'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i>Sprinkler upgradation clause
                                <span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="sprinkler_upgradation_clause1" class="radio">
                                    <input type="radio" name="sprinkler_upgradation_clause" value="Agree" id="sprinkler_upgradation_clause1" class="hidden" @if(@$insurerReply['sprinklerUpgradationClause'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="sprinkler_upgradation_clause2" class="radio">
                                    <input type="radio" name="sprinkler_upgradation_clause" value="Not Agree" id="sprinkler_upgradation_clause2" class="hidden" @if(@$insurerReply['sprinklerUpgradationClause'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i>Accidental damage to fixed glass, glass (other than fixed glass)<span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="accidental_fix_class1" class="radio">
                                    <input type="radio" name="accidental_fix_class" value="Agree" id="accidental_fix_class1" class="hidden" @if(@$insurerReply['accidentalFixClass']['isAgree'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="accidental_fix_class2" class="radio">
                                    <input type="radio" name="accidental_fix_class" value="Not Agree" id="accidental_fix_class2" class="hidden" @if(@$insurerReply['accidentalFixClass']['isAgree'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form_group">
                                <textarea name="accidental_fix_class_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['accidentalFixClass']['comment']}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i>Electronic installation, computers, data processing, equipment and other fragile or brittle object
                                <span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="electronic_installation1" class="radio">
                                    <input type="radio" name="electronic_installation" value="Agree" id="electronic_installation1" class="hidden" @if(@$insurerReply['electronicInstallation'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="electronic_installation2" class="radio">
                                    <input type="radio" name="electronic_installation" value="Not Agree" id="electronic_installation2" class="hidden" @if(@$insurerReply['electronicInstallation'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i>Brand and trademark
                                <span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="brand_trademark1" class="radio">
                                    <input type="radio" name="brand_trademark" value="Agree" id="brand_trademark1" class="hidden" @if(@$insurerReply['brandTrademark'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="brand_trademark2" class="radio">
                                    <input type="radio" name="brand_trademark" value="Not Agree" id="brand_trademark2" class="hidden" @if(@$insurerReply['brandTrademark'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i>Loss Notification – ‘as soon as reasonably practicable’
                                <span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="loss_notification1" class="radio">
                                    <input type="radio" name="loss_notification" value="Agree" id="loss_notification1" class="hidden" @if(@$insurerReply['lossNotification'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="loss_notification2" class="radio">
                                    <input type="radio" name="loss_notification" value="Not Agree" id="loss_notification2" class="hidden" @if(@$insurerReply['lossNotification'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i>Brokers Claim Handling Clause : A loss notification received by the Insurance Broker will be deemed as a loss notification to Insurer. All communications flowing between the Insurer, Insured and the appointed Loss Surveyor should be channelized through the Broker, unless there is any unavoidable reasons compelling direct communications between the parties <span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="brockers_claim_clause1" class="radio">
                                    <input type="radio" name="brockers_claim_clause" value="Agree" id="brockers_claim_clause1" class="hidden" @if(@$insurerReply['brockersClaimClause'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="brockers_claim_clause2" class="radio">
                                    <input type="radio" name="brockers_claim_clause" value="Not Agree" id="brockers_claim_clause2" class="hidden" @if(@$insurerReply['brockersClaimClause'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    @if(isset($pipeline_details['formData']['businessInterruption']) && @$pipeline_details['formData']['businessInterruption']['business_interruption'] ==true )
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Additional increase in cost of working<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="add_cost_working1" class="radio">
                                        <input type="radio" name="add_cost_working" value="Agree" id="add_cost_working1" class="hidden" @if(@$insurerReply['addCostWorking'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="add_cost_working2" class="radio">
                                        <input type="radio" name="add_cost_working" value="Not Agree" id="add_cost_working2" class="hidden" @if(@$insurerReply['addCostWorking'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Claims preparation clause<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="claim_preparation_clause1" class="radio">
                                        <input type="radio" name="claim_preparation_clause" value="Agree" id="claim_preparation_clause1" class="hidden" @if(@$insurerReply['claimPreparationClause']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="claim_preparation_clause2" class="radio">
                                        <input type="radio" name="claim_preparation_clause" value="Not Agree" id="claim_preparation_clause2" class="hidden" @if(@$insurerReply['claimPreparationClause']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="claim_preparation_clause_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['claimPreparationClause']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Suppliers extension/customer extension<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="suppliers_extension1" class="radio">
                                        <input type="radio" name="suppliers_extension" value="Agree" id="suppliers_extension1" class="hidden" @if(@$insurerReply['suppliersExtension']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="suppliers_extension2" class="radio">
                                        <input type="radio" name="suppliers_extension" value="Not Agree" id="suppliers_extension2" class="hidden" @if(@$insurerReply['suppliersExtension']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="suppliers_extension_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['suppliersExtension']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Accountants clause<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="accountants_clause1" class="radio">
                                        <input type="radio" name="accountants_clause" value="Agree" id="accountants_clause1" class="hidden" @if(@$insurerReply['accountantsClause']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="accountants_clause2" class="radio">
                                        <input type="radio" name="accountants_clause" value="Not Agree" id="accountants_clause2" class="hidden" @if(@$insurerReply['accountantsClause']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="accountants_clause_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['accountantsClause']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Payment on account<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="account_payment1" class="radio">
                                        <input type="radio" name="account_payment" value="Agree" id="account_payment1" class="hidden" @if(@$insurerReply['accountPayment']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="account_payment2" class="radio">
                                        <input type="radio" name="account_payment" value="Not Agree" id="account_payment2" class="hidden" @if(@$insurerReply['accountPayment']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="account_payment_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['accountPayment']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Prevention/denial of access<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="prevention_denial_clause1" class="radio">
                                        <input type="radio" name="prevention_denial_clause" value="Agree" id="prevention_denial_clause1" class="hidden" @if(@$insurerReply['preventionDenialClause']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="prevention_denial_clause2" class="radio">
                                        <input type="radio" name="prevention_denial_clause" value="Not Agree" id="prevention_denial_clause2" class="hidden" @if(@$insurerReply['preventionDenialClause']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="prevention_denial_clause_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['preventionDenialClause']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Premium adjustment clause<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="premium_adj_clause1" class="radio">
                                        <input type="radio" name="premium_adj_clause" value="Agree" id="premium_adj_clause1" class="hidden" @if(@$insurerReply['premiumAdjClause']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="premium_adj_clause2" class="radio">
                                        <input type="radio" name="premium_adj_clause" value="Not Agree" id="premium_adj_clause2" class="hidden" @if(@$insurerReply['premiumAdjClause']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="premium_adj_clause_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['premiumAdjClause']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Public utilities clause<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="public_utility_clause1" class="radio">
                                        <input type="radio" name="public_utility_clause" value="Agree" id="public_utility_clause1" class="hidden" @if(@$insurerReply['publicUtilityClause']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="public_utility_clause2" class="radio">
                                        <input type="radio" name="public_utility_clause" value="Not Agree" id="public_utility_clause2" class="hidden" @if(@$insurerReply['publicUtilityClause']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="public_utility_clause_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['publicUtilityClause']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Brokers Claim Handling Clause : A loss notification received by the Insurance Broker will be deemed as a loss notification to Insurer. All communications flowing between the Insurer, Insured and the appointed Loss Surveyor should be channelized through the Broker, unless there is any unavoidable reasons compelling direct communications between the parties<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="brockers_claim_handling_clause1" class="radio">
                                        <input type="radio" name="brockers_claim_handling_clause" value="Agree" id="brockers_claim_handling_clause1" class="hidden" @if(@$insurerReply['brockersClaimHandlingClause'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="brockers_claim_handling_clause2" class="radio">
                                        <input type="radio" name="brockers_claim_handling_clause" value="Not Agree" id="brockers_claim_handling_clause2" class="hidden" @if(@$insurerReply['brockersClaimHandlingClause'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Recievable / Loss of booked debts<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="accounts_recievable1" class="radio">
                                        <input type="radio" name="accounts_recievable" value="Agree" id="accounts_recievable1" class="hidden" @if(@$insurerReply['accountsRecievable']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="accounts_recievable2" class="radio">
                                        <input type="radio" name="accounts_recievable" value="Not Agree" id="accounts_recievable2" class="hidden" @if(@$insurerReply['accountsRecievable']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="accounts_recievable_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['accountsRecievable']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Interdependany clause<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="inter_dependency1" class="radio">
                                        <input type="radio" name="inter_dependency" value="Agree" id="inter_dependency1" class="hidden" @if(@$insurerReply['interDependency'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="inter_dependency2" class="radio">
                                        <input type="radio" name="inter_dependency" value="Not Agree" id="inter_dependency2" class="hidden" @if(@$insurerReply['interDependency'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Extra expense<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="extra_expense1" class="radio">
                                        <input type="radio" name="extra_expense" value="Agree" id="extra_expense1" class="hidden" @if(@$insurerReply['extraExpense']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="extra_expense2" class="radio">
                                        <input type="radio" name="extra_expense" value="Not Agree" id="extra_expense2" class="hidden" @if(@$insurerReply['extraExpense']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="extra_expense_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['extraExpense']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Contaminated water<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="contaminated_water1" class="radio">
                                        <input type="radio" name="contaminated_water" value="Agree" id="contaminated_water1" class="hidden" @if(@$insurerReply['contaminatedWater'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="contaminated_water2" class="radio">
                                        <input type="radio" name="contaminated_water" value="Not Agree" id="contaminated_water2" class="hidden" @if(@$insurerReply['contaminatedWater'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Auditors fees<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="auditors_fee_check1" class="radio">
                                        <input type="radio" name="auditors_fee_check" value="Agree" id="auditors_fee_check1" class="hidden" @if(@$insurerReply['auditorsFeeCheck']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="auditors_fee_check2" class="radio">
                                        <input type="radio" name="auditors_fee_check" value="Not Agree" id="auditors_fee_check2" class="hidden" @if(@$insurerReply['auditorsFeeCheck']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="auditors_fee_check_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['auditorsFeeCheck']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>expense to reduce the loss<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="expense_reduce_loss1" class="radio">
                                        <input type="radio" name="expense_reduce_loss" value="Agree" id="expense_reduce_loss1" class="hidden" @if(@$insurerReply['expenseReduceLoss']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="expense_reduce_loss2" class="radio">
                                        <input type="radio" name="expense_reduce_loss" value="Not Agree" id="expense_reduce_loss2" class="hidden" @if(@$insurerReply['expenseReduceLoss']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="expense_reduce_loss_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['expenseReduceLoss']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Nominated loss adjuster<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="nominated_loss_adjuster1" class="radio">
                                        <input type="radio" name="nominated_loss_adjuster" value="Agree" id="nominated_loss_adjuster1" class="hidden" @if(@$insurerReply['nominatedLossAdjuster']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="nominated_loss_adjuster2" class="radio">
                                        <input type="radio" name="nominated_loss_adjuster" value="Not Agree" id="nominated_loss_adjuster2" class="hidden" @if(@$insurerReply['nominatedLossAdjuster']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="nominated_loss_adjuster_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['nominatedLossAdjuster']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Outbreak of discease<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="outbreak_discease1" class="radio">
                                        <input type="radio" name="outbreak_discease" value="Agree" id="outbreak_discease1" class="hidden" @if(@$insurerReply['outbreakDiscease']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="outbreak_discease2" class="radio">
                                        <input type="radio" name="outbreak_discease" value="Not Agree" id="outbreak_discease2" class="hidden" @if(@$insurerReply['outbreakDiscease']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="outbreak_discease_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['outbreakDiscease']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Failure of non public power supply<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="non_public_failure1" class="radio">
                                        <input type="radio" name="non_public_failure" value="Agree" id="non_public_failure1" class="hidden" @if(@$insurerReply['nonPublicFailure']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="non_public_failure2" class="radio">
                                        <input type="radio" name="non_public_failure" value="Not Agree" id="non_public_failure2" class="hidden" @if(@$insurerReply['nonPublicFailure']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="non_public_failure_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['nonPublicFailure']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Murder, Suicide or outbreak of discease on the premises<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="premises_details1" class="radio">
                                        <input type="radio" name="premises_details" value="Agree" id="premises_details1" class="hidden" @if(@$insurerReply['premisesDetails']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="premises_details2" class="radio">
                                        <input type="radio" name="premises_details" value="Not Agree" id="premises_details2" class="hidden" @if(@$insurerReply['premisesDetails']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="premises_details_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['premisesDetails']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Bombscare and unexploded devices on the premises<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="bombscare1" class="radio">
                                        <input type="radio" name="bombscare" value="Agree" id="bombscare1" class="hidden" @if(@$insurerReply['bombscare']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="bombscare2" class="radio">
                                        <input type="radio" name="bombscare" value="Not Agree" id="bombscare2" class="hidden" @if(@$insurerReply['bombscare']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="bombscare_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['bombscare']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Book of Debts<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="book_debits1" class="radio">
                                        <input type="radio" name="book_debits" value="Agree" id="book_debits1" class="hidden" @if(@$insurerReply['bookDebits']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="book_debits2" class="radio">
                                        <input type="radio" name="book_debits" value="Not Agree" id="book_debits2" class="hidden" @if(@$insurerReply['bookDebits']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="book_debits_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['bookDebits']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>failure of public utility<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="public_failure1" class="radio">
                                        <input type="radio" name="public_failure" value="Agree" id="public_failure1" class="hidden" @if(@$insurerReply['publicFailure']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="public_failure2" class="radio">
                                        <input type="radio" name="public_failure" value="Not Agree" id="public_failure2" class="hidden" @if(@$insurerReply['publicFailure']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="public_failure_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['publicFailure']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                        @if(isset($pipeline_details['formData']['businessInterruption']['noLocations']) && $pipeline_details['formData']['businessInterruption']['noLocations']>1)
                            @if($pipeline_details['formData']['departmentalClause'] == true)
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="form_label bold"><i class="fa fa-circle"></i>Departmental clause<span>*</span></label>
                                    </div>
                                    <div class="form_group" style="padding-left: 15px;">
                                        <div class="cntr">
                                            <label for="departmental_clause1" class="radio">
                                                <input type="radio" name="departmental_clause" value="Agree" id="departmental_clause1" class="hidden" @if(@$insurerReply['departmentalClause'] == 'Agree') checked @endif/>
                                                <span class="label"></span>
                                                <span>Agree</span>
                                            </label>
                                            <label for="departmental_clause2" class="radio">
                                                <input type="radio" name="departmental_clause" value="Not Agree" id="departmental_clause2" class="hidden" @if(@$insurerReply['departmentalClause'] == 'Not Agree') checked @endif/>
                                                <span class="label"></span>
                                                <span>Not Agree</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if(isset($pipeline_details['formData']['rentLease']) &&$pipeline_details['formData']['rentLease'] == true)
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="form_label bold"><i class="fa fa-circle"></i>Rent & Lease hold interest<span>*</span></label>
                                    </div>
                                    <div class="form_group" style="padding-left: 15px;">
                                        <div class="cntr">
                                            <label for="rent_lease1" class="radio">
                                                <input type="radio" name="rent_lease" value="Agree" id="rent_lease1" class="hidden" @if(@$insurerReply['rentLease']['isAgree'] == 'Agree') checked @endif/>
                                                <span class="label"></span>
                                                <span>Agree</span>
                                            </label>
                                            <label for="rent_lease2" class="radio">
                                                <input type="radio" name="rent_lease" value="Not Agree" id="rent_lease2" class="hidden" @if(@$insurerReply['rentLease']['isAgree']== 'Not Agree') checked @endif/>
                                                <span class="label"></span>
                                                <span>Not Agree</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form_group">
                                            <textarea name="rent_lease_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['rentLease']['comment']}}</textarea>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                        @if(isset($pipeline_details['formData']['CoverAccomodation']['coverAccomodation']) && $pipeline_details['formData']['CoverAccomodation']['coverAccomodation'] == true)
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form_label bold"><i class="fa fa-circle"></i>Cover for alternate accomodation<span>*</span></label>
                                </div>
                                <div class="form_group" style="padding-left: 15px;">
                                    <div class="cntr">
                                        <label for="cover_accomodation1" class="radio">
                                            <input type="radio" name="cover_accomodation" value="Agree" id="cover_accomodation1" class="hidden" @if(@$insurerReply['coverAccomodation']['isAgree'] == 'Agree') checked @endif/>
                                            <span class="label"></span>
                                            <span>Agree</span>
                                        </label>
                                        <label for="cover_accomodation2" class="radio">
                                            <input type="radio" name="cover_accomodation" value="Not Agree" id="cover_accomodation2" class="hidden" @if(@$insurerReply['coverAccomodation']['isAgree'] == 'Not Agree') checked @endif/>
                                            <span class="label"></span>
                                            <span>Not Agree</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form_group">
                                        <textarea name="cover_accomodation_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['coverAccomodation']['comment']}}</textarea>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if(isset($pipeline_details['formData']['contingentBusiness']) && $pipeline_details['formData']['contingentBusiness'] == true)
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form_label bold"><i class="fa fa-circle"></i>Contingent business inetruption and contingent extra expense<span>*</span></label>
                                </div>
                                <div class="form_group" style="padding-left: 15px;">
                                    <div class="cntr">
                                        <label for="contingent_business1" class="radio">
                                            <input type="radio" name="contingent_business" value="Agree" id="contingent_business1" class="hidden" @if(@$insurerReply['contingentBusiness']['isAgree'] == 'Agree') checked @endif/>
                                            <span class="label"></span>
                                            <span>Agree</span>
                                        </label>
                                        <label for="contingent_business2" class="radio">
                                            <input type="radio" name="contingent_business" value="Not Agree" id="contingent_business2" class="hidden" @if(@$insurerReply['contingentBusiness']['isAgree'] == 'Not Agree') checked @endif/>
                                            <span class="label"></span>
                                            <span>Not Agree</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form_group">
                                        <textarea name="contingent_business_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['contingentBusiness']['comment']}}</textarea>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if(isset($pipeline_details['formData']['nonOwnedProperties']) && $pipeline_details['formData']['nonOwnedProperties'] == true)
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form_label bold"><i class="fa fa-circle"></i>Non Owned property in vicinity interuption<span>*</span></label>
                                </div>
                                <div class="form_group" style="padding-left: 15px;">
                                    <div class="cntr">
                                        <label for="non_owned_properties1" class="radio">
                                            <input type="radio" name="non_owned_properties" value="Agree" id="non_owned_properties1" class="hidden" @if(@$insurerReply['nonOwnedProperties']['isAgree'] == 'Agree') checked @endif/>
                                            <span class="label"></span>
                                            <span>Agree</span>
                                        </label>
                                        <label for="non_owned_properties2" class="radio">
                                            <input type="radio" name="non_owned_properties" value="Not Agree" id="non_owned_properties2" class="hidden" @if(@$insurerReply['nonOwnedProperties']['isAgree'] == 'Not Agree') checked @endif/>
                                            <span class="label"></span>
                                            <span>Not Agree</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form_group">
                                        <textarea name="non_owned_properties_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['nonOwnedProperties']['comment']}}</textarea>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if(isset($pipeline_details['formData']['royalties']) && $pipeline_details['formData']['royalties'] == true)
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form_label bold"><i class="fa fa-circle"></i>Royalties<span>*</span></label>
                                </div>
                                <div class="form_group" style="padding-left: 15px;">
                                    <div class="cntr">
                                        <label for="royalties1" class="radio">
                                            <input type="radio" name="royalties" value="Agree" id="royalties1" class="hidden" @if(@$insurerReply['royalties'] == 'Agree') checked @endif/>
                                            <span class="label"></span>
                                            <span>Agree</span>
                                        </label>
                                        <label for="royalties2" class="radio">
                                            <input type="radio" name="royalties" value="Not Agree" id="royalties2" class="hidden" @if(@$insurerReply['royalties'] == 'Not Agree') checked @endif/>
                                            <span class="label"></span>
                                            <span>Not Agree</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif

                    @if(isset($pipeline_details['formData']['cliamPremium']) &&
                                $pipeline_details['formData']['cliamPremium'] =='combined_data')
                        <div class="row" >
                            <div class="col-md-12">
                                <div class="form_group">
                                    {{-- <label class="form_label bold">Claims experience <span style="visibility: hidden">*</span></label> --}}
                                    <table class="table table-bordered custom_table">
                                        <thead>
                                        <tr>
                                            <th style="font-size: 15px;" colspan="3"> Combined premium for Property and Business interruption</th>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>Expected</td>
                                            <td></td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>Deductible for Property:  </td>
                                            <td><input class="form_input" name="deductable_property" id="deductable_property" readonly
                                                       @if(isset($pipeline_details['formData']['claimPremiyumDetails']['deductableProperty'])
                                                            && (@$pipeline_details['formData']['claimPremiyumDetails']['deductableProperty']))
                                                       value="{{number_format(trim($pipeline_details['formData']['claimPremiyumDetails']['deductableProperty']),2)}}" @endif></td>
                                            <td><div class="sss"><input class="form_input number" name="comdeductableProperty"
                                                 @if(isset($insurerReply['claimPremiyumDetails']['deductableProperty']) &&($insurerReply['claimPremiyumDetails']['deductableProperty']!='')) 
                                                    value="{{number_format(trim(@$insurerReply['claimPremiyumDetails']['deductableProperty']),2)}}"
                                                 @endif ></div></td>
                                        </tr>

                                        <tr>
                                            <td>Deductible for Business Interruption: </td>
                                            <td><input class="form_input" name="deductable_interuption" type="text" id="deductable_interuption"  readonly
                                                       @if(isset($pipeline_details['formData']['claimPremiyumDetails']['deductableBusiness'])
                                                        && @$pipeline_details['formData']['claimPremiyumDetails']['deductableBusiness'])
                                                       value="{{number_format(trim($pipeline_details['formData']['claimPremiyumDetails']['deductableBusiness']),2)}}" @endif></td>
                                            <td><div class="sss"><input class="form_input number" name="comdeductableBusiness" type="text"  @if(isset($insurerReply['claimPremiyumDetails']['deductableBusiness']) && 
                                            ($insurerReply['claimPremiyumDetails']['deductableBusiness']!='')) 
                                                value="{{number_format(trim(@$insurerReply['claimPremiyumDetails']['deductableBusiness']),2)}}"
                                             @endif></div></td>

                                        </tr>

                                        <tr>
                                            <td>Rate required(combined):</td>
                                            <td><input class="form_input" name="rate_required" type="text" id="rate_required" readonly
                                                       @if(isset($pipeline_details['formData']['claimPremiyumDetails']['rateCombined'])
                                                        && @$pipeline_details['formData']['claimPremiyumDetails']['rateCombined'])
                                                       value="{{number_format(trim($pipeline_details['formData']['claimPremiyumDetails']['rateCombined']),2)}}" @endif></td>
                                            <td><div class="sss"><input class="form_input number" name="comrateCombined" type="text" 
                                                @if(isset($insurerReply['claimPremiyumDetails']['rateCombined']) && ($insurerReply['claimPremiyumDetails']['rateCombined'])!='') 
                                                value="{{number_format(trim(@$insurerReply['claimPremiyumDetails']['rateCombined']),2)}}"
                                             @endif></div></td>
                                        </tr>

                                        <tr>
                                            <td>Premium required(combined):</td>
                                            <td><input class="form_input" name="premium_required" type="text" id="premium_required"  readonly
                                                       @if(isset($pipeline_details['formData']['claimPremiyumDetails']['premiumCombined'])
                                                    && @$pipeline_details['formData']['claimPremiyumDetails']['premiumCombined'])
                                                       value="{{number_format(trim($pipeline_details['formData']['claimPremiyumDetails']['premiumCombined']),2)}}" @endif></td>
                                            <td><div class="sss"><input class="form_input number" name="compremiumCombined" type="text" 
                                                @if(isset($insurerReply['claimPremiyumDetails']['premiumCombined']) && ($insurerReply['claimPremiyumDetails']['premiumCombined']!='')) 
                                                value="{{number_format(trim(@$insurerReply['claimPremiyumDetails']['premiumCombined']),2)}}"
                                             @endif></div></td>
                                        </tr>

                                        <tr>
                                            <td>Brokerage (combined)</td>
                                            <td><input class="form_input" name="brokerage" type="text" id="brokerage" readonly
                                                       @if(isset($pipeline_details['formData']['claimPremiyumDetails']['brokerage'])
                                                        && @$pipeline_details['formData']['claimPremiyumDetails']['brokerage'])
                                                       value="{{number_format(trim($pipeline_details['formData']['claimPremiyumDetails']['brokerage']),2)}}" @endif></td>
                                            <td><div class="sss"><input class="form_input number" name="combrokerage" type="text"
                                                @if(isset($insurerReply['claimPremiyumDetails']['brokerage']) && ($insurerReply['claimPremiyumDetails']['brokerage']!='')) 
                                                value="{{number_format(trim(@$insurerReply['claimPremiyumDetails']['brokerage']),2)}}"
                                             @endif></div></td>
                                        </tr>

                                        <tr>
                                            <td>Warranty (Property)</td>
                                            <td><input class="form_input" name="warranty" type="text" id="warranty"readonly
                                                       @if(isset($pipeline_details['formData']['claimPremiyumDetails']['warrantyProperty'])
                                                        && @$pipeline_details['formData']['claimPremiyumDetails']['warrantyProperty'])
                                                       value="{{$pipeline_details['formData']['claimPremiyumDetails']['warrantyProperty']}}" @endif></td>
                                            <td><div class="sss"><input class="form_input" name="comwarrantyProperty" type="text" value="{{@$insurerReply['claimPremiyumDetails']['warrantyProperty']}}"></div></td>

                                        </tr>

                                        <tr>
                                            <td>Warranty (Business Interruption)</td>
                                            <td><input class="form_input" name="warranty_business" type="text" id="warranty_business" readonly
                                                       @if(isset($pipeline_details['formData']['claimPremiyumDetails']['warrantyBusiness'])
                                                        && @$pipeline_details['formData']['claimPremiyumDetails']['warrantyBusiness'])
                                                       value="{{$pipeline_details['formData']['claimPremiyumDetails']['warrantyBusiness']}}" @endif></td>
                                            <td><div class="sss"><input class="form_input" name="comwarrantyBusiness" type="text" value="{{@$insurerReply['claimPremiyumDetails']['warrantyBusiness']}}"></div></td>

                                        </tr>

                                        <tr>
                                            <td>Exclusion (Property) </td>
                                            <td><input class="form_input" name="exclusion_property" type="text" id="exclusion_property"readonly
                                                       @if(isset($pipeline_details['formData']['claimPremiyumDetails']['exclusionProperty'])
                                                            && @$pipeline_details['formData']['claimPremiyumDetails']['exclusionProperty'])
                                                       value="{{$pipeline_details['formData']['claimPremiyumDetails']['exclusionProperty']}}" @endif></td>
                                            <td><div class="sss"><input class="form_input" name="comexclusionProperty" type="text" value="{{@$insurerReply['claimPremiyumDetails']['exclusionProperty']}}"></div></td>

                                        </tr>

                                        <tr>
                                            <td>Exclusion (Business Interruption)</td>
                                            <td><input class="form_input" name="exclusion_business" type="text" id="exclusion_business"readonly
                                                       @if(isset($pipeline_details['formData']['claimPremiyumDetails']['exclusionBusiness'])
                                            && @$pipeline_details['formData']['claimPremiyumDetails']['exclusionBusiness'])
                                                       value="{{$pipeline_details['formData']['claimPremiyumDetails']['exclusionBusiness']}}" @endif></td>
                                            <td><div class="sss"><input class="form_input" name="comexclusionBusiness" type="text" value="{{@$insurerReply['claimPremiyumDetails']['exclusionBusiness']}}"></div></td>

                                        </tr>

                                        <tr>
                                            <td>Special Condition (Property) </td>
                                            <td><input class="form_input" name="special_property" type="text" id="special_property" readonly
                                                       @if(isset($pipeline_details['formData']['claimPremiyumDetails']['specialProperty'])
                                                            && @$pipeline_details['formData']['claimPremiyumDetails']['specialProperty'])
                                                       value="{{$pipeline_details['formData']['claimPremiyumDetails']['specialProperty']}}" @endif></td>
                                            <td><div class="sss"><input class="form_input" name="comspecialProperty" type="text" value="{{@$insurerReply['claimPremiyumDetails']['specialProperty']}}"></div></td>

                                        </tr>

                                        <tr>
                                            <td>Special Condition (Business Interruption)</td>
                                            <td><input class="form_input" name="special_business" type="text" id="special_business"  readonly
                                                       @if(isset($pipeline_details['formData']['claimPremiyumDetails']['specialBusiness'])
                                                        && @$pipeline_details['formData']['claimPremiyumDetails']['specialBusiness'])
                                                       value="{{$pipeline_details['formData']['claimPremiyumDetails']['specialBusiness']}}" @endif></td>
                                            <td><div class="sss"><input class="form_input" name="comspecialBusiness" type="text" value="{{@$insurerReply['claimPremiyumDetails']['specialBusiness']}}"></div></td>

                                        </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if(isset($pipeline_details['formData']['cliamPremium']) &&
                        $pipeline_details['formData']['cliamPremium'] =='only_property')
                            <div class="col-md-12">
                                <div class="form_group">
                                    {{-- <label class="form_label bold">Claims experience <span style="visibility: hidden">*</span></label> --}}
                                    <table class="table table-bordered custom_table">
                                        <thead>
                                        <tr>
                                            <th style="font-size: 15px;" colspan="3"> Property</th>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>Expected</td>
                                            <td></td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>Deductible:    </td>
                                            <td><input class="form_input" name="property_deductable" id="property_deductable" readonly
                                                       @if(isset($pipeline_details['formData']['claimPremiyumDetails']['deductableProperty'])
                                                    && @$pipeline_details['formData']['claimPremiyumDetails']['deductableProperty'])
                                                       value="{{number_format(trim($pipeline_details['formData']['claimPremiyumDetails']['deductableProperty']),2)}}" @endif>
                                            </td>
                                            <td><input class="form_input number" name="onlydeductableProperty" 
                                                @if(isset($insurerReply['claimPremiyumDetails']['deductableProperty']) && ($insurerReply['claimPremiyumDetails']['deductableProperty']!='')) 
                                                value="{{number_format(trim($insurerReply['claimPremiyumDetails']['deductableProperty']),2)}}"
                                             @endif></div></td>
                                        </tr>

                                        <tr>
                                            <td>Rate required: </td>
                                            <td><input class="form_input" name="property_rate" type="text" id="property_rate"readonly
                                                       @if(isset($pipeline_details['formData']['claimPremiyumDetails']['propertyRate'])
                                                && @$pipeline_details['formData']['claimPremiyumDetails']['propertyRate'])
                                                       value="{{number_format(trim($pipeline_details['formData']['claimPremiyumDetails']['propertyRate']),2)}}" @endif></td>
                                            <td><input class="form_input number" name="onlypropertyRate" type="text" 
                                                @if(isset($insurerReply['claimPremiyumDetails']['propertyRate']) && ($insurerReply['claimPremiyumDetails']['propertyRate']!='')) 
                                                value="{{number_format(trim(@$insurerReply['claimPremiyumDetails']['propertyRate']),2)}}"
                                             @endif></div></td>
                                        </tr>

                                        <tr>
                                            <td>Premium required:   </td>
                                            <td><input class="form_input" name="property_premium" type="text" id="property_premium" readonly
                                                       @if(isset($pipeline_details['formData']['claimPremiyumDetails']['propertyPremium'])
                                                && @$pipeline_details['formData']['claimPremiyumDetails']['propertyPremium'])
                                                       value="{{number_format(trim($pipeline_details['formData']['claimPremiyumDetails']['propertyPremium']),2)}}" @endif></td>
                                            <td><input class="form_input number" name="onlypropertyPremium" type="text"
                                                @if(isset($insurerReply['claimPremiyumDetails']['propertyPremium']) && ($insurerReply['claimPremiyumDetails']['propertyPremium']!='')) 
                                                value="{{number_format(trim(@$insurerReply['claimPremiyumDetails']['propertyPremium']),2)}}"
                                             @endif></div></td> 

                                        </tr>

                                        <tr>
                                            <td>Brokerage </td>
                                            <td><input class="form_input" name="property_brockerage" type="text" id="property_brockerage" readonly
                                                       @if(isset($pipeline_details['formData']['claimPremiyumDetails']['propertyBrockerage'])
                                                    && @$pipeline_details['formData']['claimPremiyumDetails']['propertyBrockerage'])
                                                       value="{{number_format(trim($pipeline_details['formData']['claimPremiyumDetails']['propertyBrockerage']),2)}}" @endif></td>
                                            <td><input class="form_input number" name="onlypropertyBrockerage" type="text" 
                                                @if(isset($insurerReply['claimPremiyumDetails']['propertyBrockerage']) && ($insurerReply['claimPremiyumDetails']['propertyBrockerage']!='')) 
                                                value="{{number_format(trim(@$insurerReply['claimPremiyumDetails']['propertyBrockerage']),2)}}"
                                             @endif></div></td> 
                                        </tr>

                                        <tr>
                                            <td>Warranty</td>
                                            <td><input class="form_input" name="property_warranty" type="text" id="property_warranty"readonly
                                                       @if(isset($pipeline_details['formData']['claimPremiyumDetails']['propertyWarranty'])
                                                    && @$pipeline_details['formData']['claimPremiyumDetails']['propertyWarranty'])
                                                       value="{{$pipeline_details['formData']['claimPremiyumDetails']['propertyWarranty']}}" @endif></td>
                                            <td><input class="form_input" name="onlypropertyWarranty" type="text" value="{{@$insurerReply['claimPremiyumDetails']['propertyWarranty']}}"></td>

                                        </tr>

                                        <tr>
                                            <td>Exclusion</td>
                                            <td><input class="form_input" name="property_exclusion"readonly type="text" id="property_exclusion"
                                                       @if(isset($pipeline_details['formData']['claimPremiyumDetails']['propertyExclusion'])
                                                        && @$pipeline_details['formData']['claimPremiyumDetails']['propertyExclusion'])
                                                       value="{{$pipeline_details['formData']['claimPremiyumDetails']['propertyExclusion']}}" @endif></td>
                                            <td><input class="form_input" name="onlypropertyExclusion" type="text" value="{{@$insurerReply['claimPremiyumDetails']['propertyExclusion']}}"></td>

                                        </tr>

                                        <tr>
                                            <td>Special Condition</td>
                                            <td><input class="form_input" name="property_special" readonly type="text" id="property_special"
                                                       @if(isset($pipeline_details['formData']['claimPremiyumDetails']['propertySpecial'])
                                                        && @$pipeline_details['formData']['claimPremiyumDetails']['propertySpecial'])
                                                       value="{{$pipeline_details['formData']['claimPremiyumDetails']['propertySpecial']}}" @endif></td>
                                            <td><input class="form_input" name="onlypropertySpecial" type="text" value="{{@$insurerReply['claimPremiyumDetails']['propertySpecial']}}"></td>

                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if(isset($pipeline_details['formData']['cliamPremium']) &&
                                $pipeline_details['formData']['cliamPremium'] =='separate_property')
                        <div class="row" id="table3">
                            <div class="col-md-12">
                                <div class="form_group">
                                    {{-- <label class="form_label bold">Claims experience <span style="visibility: hidden">*</span></label> --}}
                                    <table class="table table-bordered custom_table">
                                        <thead>
                                        <tr>
                                            <th style="font-size: 15px;" colspan="3"> Separate Premiums for Property and Business interruption </th>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>Expected</td>
                                            <td></td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>Deductible for (Property):  </td>
                                            <td><input class="form_input" name="property_separate_deductable" id="property_separate_deductable" required
                                                       @if(isset($pipeline_details['formData']['claimPremiyumDetails']['propertySeparateDeductable'])
                                                        && @$pipeline_details['formData']['claimPremiyumDetails']['propertySeparateDeductable'])
                                                       value="{{number_format(trim($pipeline_details['formData']['claimPremiyumDetails']['propertySeparateDeductable']),2)}}" @endif>
                                            </td>
                                            <td><input class="form_input number" name="propertySeparateDeductable" type="text" 
                                                @if(isset($insurerReply['claimPremiyumDetails']['propertySeparateDeductable']) && ($insurerReply['claimPremiyumDetails']['propertySeparateDeductable']!='')) 
                                                value="{{number_format(trim(@$insurerReply['claimPremiyumDetails']['propertySeparateDeductable']),2)}}"
                                             @endif></div></td> 
                                        </tr>

                                        <tr>
                                            <td>Rate required(Property):</td>
                                            <td><input class="form_input" name="property_separate_rate" type="text" id="property_separate_rate"  required
                                                       @if(isset($pipeline_details['formData']['claimPremiyumDetails']['propertySeparateRate']) &&
                                                @$pipeline_details['formData']['claimPremiyumDetails']['propertySeparateRate'])
                                                       value="{{number_format(trim($pipeline_details['formData']['claimPremiyumDetails']['propertySeparateRate']),2)}}" @endif
                                                ></td>
                                            <td><input class="form_input number" name="propertySeparateRate" type="text" 
                                                @if(isset($insurerReply['claimPremiyumDetails']['propertySeparateRate']) && ($insurerReply['claimPremiyumDetails']['propertySeparateRate']!='')) 
                                                value="{{number_format(trim(@$insurerReply['claimPremiyumDetails']['propertySeparateRate']),2)}}"
                                             @endif></div></td> 
                                        </tr>

                                        <tr>
                                            <td>Premium required(Property):</td>
                                            <td><input class="form_input" name="property_separate_premium" type="text" id="property_separate_premium"  required
                                                       @if(isset($pipeline_details['formData']['claimPremiyumDetails']['propertySeparatePremium']) &&
                                                @$pipeline_details['formData']['claimPremiyumDetails']['propertySeparatePremium'])
                                                       value="{{number_format(trim($pipeline_details['formData']['claimPremiyumDetails']['propertySeparatePremium']),2)}}" @endif></td>
                                            <td><input class="form_input number" name="propertySeparatePremium" type="text" 
                                                @if(isset($insurerReply['claimPremiyumDetails']['propertySeparatePremium']) && ($insurerReply['claimPremiyumDetails']['propertySeparatePremium']!='')) 
                                                value="{{number_format(trim(@$insurerReply['claimPremiyumDetails']['propertySeparatePremium']),2)}}"
                                             @endif></div></td> 
                                        </tr>

                                        <tr>
                                            <td>Brokerage (Property)</td>
                                            <td><input class="form_input" name="property_separate_brokerage"  id="property_separate_brokerage"required
                                                       @if(isset($pipeline_details['formData']['claimPremiyumDetails']['propertySeparateBrokerage']) &&
                                                        @$pipeline_details['formData']['claimPremiyumDetails']['propertySeparateBrokerage'])
                                                       value="{{number_format(trim($pipeline_details['formData']['claimPremiyumDetails']['propertySeparateBrokerage']),2)}}" @endif></td>
                                            <td><input class="form_input" name="propertySeparateBrokerage" type="text" 
                                                @if(isset($insurerReply['claimPremiyumDetails']['propertySeparateBrokerage']) && ($insurerReply['claimPremiyumDetails']['propertySeparateBrokerage']!='')) 
                                                value="{{number_format(trim(@$insurerReply['claimPremiyumDetails']['propertySeparateBrokerage']),2)}}"
                                             @endif></div></td> 
                                        </tr>

                                        <tr>
                                            <td>Warranty (Property)</td>
                                            <td><input class="form_input" name="property_separate_warranty" type="text" id="property_separate_warranty" required
                                                       @if(isset($pipeline_details['formData']['claimPremiyumDetails']['propertySeparateWarranty'])
                                                        && @$pipeline_details['formData']['claimPremiyumDetails']['propertySeparateWarranty'])
                                                       value="{{$pipeline_details['formData']['claimPremiyumDetails']['propertySeparateWarranty']}}" @endif></td>
                                            <td><input class="form_input" name="propertySeparateWarranty" type="text" value="{{@$insurerReply['claimPremiyumDetails']['propertySeparateWarranty']}}"></td>

                                        </tr>
                                        <tr>
                                            <td>Exclusion (Property)</td>
                                            <td><input class="form_input" name="property_separate_exclusion" type="text" id="property_separate_exclusion" required
                                                       @if(isset($pipeline_details['formData']['claimPremiyumDetails']['propertySeparateExclusion']) &&
                                                    @$pipeline_details['formData']['claimPremiyumDetails']['propertySeparateExclusion'])
                                                       value="{{$pipeline_details['formData']['claimPremiyumDetails']['propertySeparateExclusion']}}" @endif></td>
                                            <td><input class="form_input" name="propertySeparateExclusion" type="text" value="{{@$insurerReply['claimPremiyumDetails']['propertySeparateExclusion']}}"></td>

                                        </tr>

                                        <tr>
                                            <td>Special Condition (Property)</td>
                                            <td><input class="form_input" name="property_separate_special" type="text" id="property_separate_special" required
                                                       @if(isset($pipeline_details['formData']['claimPremiyumDetails']['propertySeparateSpecial']) &&
                                                    @$pipeline_details['formData']['claimPremiyumDetails']['propertySeparateSpecial'])
                                                       value="{{$pipeline_details['formData']['claimPremiyumDetails']['propertySeparateSpecial']}}" @endif></td>
                                            <td><input class="form_input" name="propertySeparateSpecial" type="text" value="{{@$insurerReply['claimPremiyumDetails']['propertySeparateSpecial']}}"></td>

                                        </tr>

                                        <tr>
                                            <td>Deductible for (Business Interruption):</td>
                                            <td><input class="form_input" name="business_separate_deductable" id="business_separate_deductable" required
                                                       @if(isset($pipeline_details['formData']['claimPremiyumDetails']['businessSeparateDeductable'])
                                                            && @$pipeline_details['formData']['claimPremiyumDetails']['businessSeparateDeductable'])
                                                       value="{{number_format(trim($pipeline_details['formData']['claimPremiyumDetails']['businessSeparateDeductable']),2)}}" @endif></td>
                                            <td><input class="form_input number" name="businessSeparateDeductable" type="text"
                                                @if(isset($insurerReply['claimPremiyumDetails']['businessSeparateDeductable']) && ($insurerReply['claimPremiyumDetails']['businessSeparateDeductable']!='')) 
                                                value="{{number_format(trim(@$insurerReply['claimPremiyumDetails']['businessSeparateDeductable']),2)}}"
                                             @endif></div></td> 
                                        </tr>

                                        <tr>
                                            <td>Rate required(Business Interruption):</td>
                                            <td><input class="form_input" name="business_separate_rate" id="business_separate_rate"  required
                                                       @if(isset($pipeline_details['formData']['claimPremiyumDetails']['businessSeparateRate']) &&
                                                            @$pipeline_details['formData']['claimPremiyumDetails']['businessSeparateRate'])
                                                       value="{{number_format(trim($pipeline_details['formData']['claimPremiyumDetails']['businessSeparateRate']),2)}}" @endif></td>
                                            <td><input class="form_input number" name="businessSeparateRate" type="text"
                                                @if(isset($insurerReply['claimPremiyumDetails']['businessSeparateRate']) && ($insurerReply['claimPremiyumDetails']['businessSeparateRate']!='')) 
                                                value="{{number_format(trim(@$insurerReply['claimPremiyumDetails']['businessSeparateRate']),2)}}"
                                             @endif></div></td>

                                        </tr>

                                        <tr>
                                            <td>Premium required(Business Interruption):</td>
                                            <td><input class="form_input" name="business_separate_premium" type="text" id="business_separate_premium" required
                                                       @if(isset($pipeline_details['formData']['claimPremiyumDetails']['businessSeparatePremium'])
                                                        && @$pipeline_details['formData']['claimPremiyumDetails']['businessSeparatePremium'])
                                                       value="{{number_format(trim($pipeline_details['formData']['claimPremiyumDetails']['businessSeparatePremium']),2)}}" @endif></td>
                                            <td><input class="form_input number" name="businessSeparatePremium" type="text" 
                                                @if(isset($insurerReply['claimPremiyumDetails']['businessSeparatePremium']) && ($insurerReply['claimPremiyumDetails']['businessSeparatePremium']!='')) 
                                                value="{{number_format(trim(@$insurerReply['claimPremiyumDetails']['businessSeparatePremium']),2)}}"
                                             @endif></div></td>

                                        </tr>

                                        <tr>
                                            <td>Brokerage (Business Interruption):</td>
                                            <td><input class="form_input" name="business_separate_brokerage" type="text" id="business_separate_brokerage" required
                                                       @if(isset($pipeline_details['formData']['claimPremiyumDetails']['businessSeparateBrokerage']) &&
                                                            @$pipeline_details['formData']['claimPremiyumDetails']['businessSeparateBrokerage'])
                                                       value="{{number_format(trim($pipeline_details['formData']['claimPremiyumDetails']['businessSeparateBrokerage']),2)}}" @endif></td>
                                            <td><input class="form_input number" name="businessSeparateBrokerage" type="text" 
                                                @if(isset($insurerReply['claimPremiyumDetails']['businessSeparateBrokerage']) && ($insurerReply['claimPremiyumDetails']['businessSeparateBrokerage']!='')) 
                                                value="{{number_format(trim(@$insurerReply['claimPremiyumDetails']['businessSeparateBrokerage']),2)}}"
                                             @endif></div></td>

                                        </tr>

                                        <tr>
                                            <td>Warranty (Business Interruption):</td>
                                            <td><input class="form_input" name="business_separate_warranty" type="text" id="business_separate_warranty"  required
                                                       @if(isset($pipeline_details['formData']['claimPremiyumDetails']['businessSeparateWarranty'])
                                                        && @$pipeline_details['formData']['claimPremiyumDetails']['businessSeparateWarranty'])
                                                       value="{{$pipeline_details['formData']['claimPremiyumDetails']['businessSeparateWarranty']}}" @endif></td>
                                            <td><input class="form_input" name="businessSeparateWarranty" type="text" value="{{@$insurerReply['claimPremiyumDetails']['businessSeparateWarranty']}}"></td>

                                        </tr>

                                        <tr>
                                            <td>Exclusion (Business Interruption):</td>
                                            <td><input class="form_input" name="business_separate_exclusion" type="text" id="business_separate_exclusion" required
                                                       @if(isset($pipeline_details['formData']['claimPremiyumDetails']['businessSeparateExclusion']) &&
                                                            @$pipeline_details['formData']['claimPremiyumDetails']['businessSeparateExclusion'])
                                                       value="{{$pipeline_details['formData']['claimPremiyumDetails']['businessSeparateExclusion']}}" @endif></td>
                                            <td><input class="form_input" name="businessSeparateExclusion" type="text" value="{{@$insurerReply['claimPremiyumDetails']['businessSeparateExclusion']}}"></td>

                                        </tr>

                                        <tr>
                                            <td>Special Condition (Business Interruption):
                                            <td><input class="form_input" name="business_separate_special" type="text" id="business_separate_special" required
                                                       @if(isset($pipeline_details['formData']['claimPremiyumDetails']['businessSeparateSpecial']) &&
                                                            @$pipeline_details['formData']['claimPremiyumDetails']['businessSeparateSpecial'])
                                                       value="{{$pipeline_details['formData']['claimPremiyumDetails']['businessSeparateSpecial']}}" @endif></td>
                                            <td><input class="form_input" name="businessSeparateSpecial" type="text" value="{{@$insurerReply['claimPremiyumDetails']['businessSeparateSpecial']}}"></td>

                                        </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                    @endif
                    <div class="clearfix">
                    <button class="btn btn-primary btn_action pull-right" type="submit" id="quot_submit" @if($pipelineStatus=='Approved E Quote' || $pipelineStatus=='Issuance') style="display: none" @endif> @if(@$insurerReply['quoteStatus']=='active') Update @else Proceed @endif</button>
                    <button class="btn blue_btn btn_action pull-right" type="button" @if(@$insurerReply['quoteStatus']=='active') style="display: none" @endif onclick="saveDraft()">SAVE AS DRAFT</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

    <script src="{{\Illuminate\Support\Facades\URL::asset('js/main/jquery.validate.js')}}"></script>

    <!-- Custom Select -->
    <script src="{{\Illuminate\Support\Facades\URL::asset('js/main/custom-select.js')}}"></script>

    <!-- Bootstrap Select -->
    <script src="{{\Illuminate\Support\Facades\URL::asset('js/main/bootstrap-select.js')}}"></script>

    <script>

    $(document).ready(function(){
        $.validator.messages.required = 'Please select agree or not agree';

        $("input[type='radio']").addClass('required');
        // $("table input[type='text']").addClass('required');
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
 
        // Form valodation
        $('#e-quotation-form').validate({
            ignore:[],
            rules:{
                comdeductableProperty: {
                required:true,
                    number:true
                },
                comdeductableBusiness: {
                required:true,
                    number:true
                },
                comrateCombined: {
                required:true,
                    number:true
                },
                compremiumCombined: {
                required:true,
                    number:true
                },
                combrokerage: {
                required:true,
                    number:true
                },
                comwarrantyProperty: {
                required:true
                },
                comwarrantyBusiness: {
                required:true
                },
                comexclusionProperty: {
                required:true
                },
                comexclusionBusiness: {
                required:true
                },
                comspecialProperty: {
                required:true
                },
                comspecialBusiness: {
                required:true
                },
                onlydeductableProperty: {
                    required:true,
                    number:true
                },
                onlypropertyRate: {
                    required:true,
                    number:true
                },
                onlypropertyPremium: {
                required:true,
                    number:true
                },
                onlypropertyBrockerage: {
                required:true,
                    number:true
                },
                onlypropertyWarranty: {
                required:true
                },
                onlypropertyExclusion: {
                required:true
                },
                onlypropertySpecial: {
                required:true
                },
                propertySeparateDeductable: {
                required:true,
                    number:true
                },
                propertySeparateRate: {
                required:true,
                    number:true
                },
                propertySeparatePremium: {
                required:true,
                    number:true
                },
                propertySeparateBrokerage: {
                required:true,
                    number:true
                },
                propertySeparateWarranty: {
                required:true
                },
                propertySeparateExclusion: {
                required:true
                },
                propertySeparateSpecial: {
                required:true
                },
                businessSeparateDeductable: {
                required:true,
                    number:true
                },
                businessSeparateRate: {
                required:true,
                    number:true
                },
                businessSeparatePremium: {
                required:true,
                    number:true
                },
                businessSeparateBrokerage: {
                required:true,
                    number:true
                },
                businessSeparateWarranty: {
                required:true
                },
                businessSeparateExclusion: {
                required:true
                },
                businessSeparateSpecial: {
                required:true
                }
            },
            messages: {
                comdeductableProperty: "Please enter deductible for Property.",
                comdeductableBusiness: "Please enter deductible for Business Interruption.",
                comrateCombined: "Please enter rate (combined).",
                compremiumCombined: "Please enter premium (combined).",
                combrokerage: "Please enter brokerage (combined.",
                comwarrantyProperty: "Please enter warranty (Property).",
                comwarrantyBusiness: "Please enter warranty (Business Interruption).",
                comexclusionProperty: "Please enter exclusion (Property).",
                comexclusionBusiness: "Please enter exclusion (Business Interruption).",
                comspecialProperty: "Please enter special condition (Property).",
                comspecialBusiness: "Please enter special condition (Business Interruption).",
                onlydeductableProperty: "Please enter deductible.",
                onlypropertyRate: "Please enter rate .",
                onlypropertyPremium: "Please enter premium .",
                onlypropertyBrockerage: "Please enter brokerage.",
                onlypropertyWarranty: "Please enter warranty.",
                onlypropertyExclusion: "Please enter exclusion.",
                onlypropertySpecial: "Please enter special condition.",
                propertySeparateDeductable: "Please enter deductible for (Property).",
                propertySeparateRate: "Please enter rate  (Property).",
                propertySeparatePremium: "Please enter premium  (Property).",
                propertySeparateBrokerage: "Please enter brokerage (Property).",
                propertySeparateWarranty: "Please enter warranty (Property).",
                propertySeparateExclusion: "Please enter exclusion (Property).",
                propertySeparateSpecial: "Please enter special condition (Property).",
                businessSeparateDeductable: "Please enter deductible for (Business Interruption).",
                businessSeparateRate: "Please enter rate  (Business Interruption).",
                businessSeparatePremium: "Please enter premium  (Business Interruption).",
                businessSeparateBrokerage: "Please enter brokerage (Business Interruption).",
                businessSeparateWarranty: "Please enter warranty (Business Interruption).",
                businessSeparateExclusion: "Please enter exclusion (Business Interruption).",
                businessSeparateSpecial: "Please enter special condition (Business Interruption)."
            },
        
        errorPlacement: function (error, element)
        {
            // if($("table input[type='text']")){
            //     // alert();
            //     // error.insertAfter($("td.sss").parent().parent().append('<td></td>'));
            //     error.appendTo(element);
            // }
            if($("input[type='radio']")){
                error.insertAfter(element.parent().parent());
            
            }
        
            
        },

        submitHandler: function (form,event) {
            console.log("validation success");
                var form_data = new FormData($("#e-quotation-form")[0]);
                $('#preLoader').fadeIn('slow');
                $.ajax({
                    method: 'post',
                    url: '{{url('insurer/property-save')}}',
                    data: form_data,
                    cache : false,
                    contentType: false,
                    processData: false,
                    success: function (result) {
                        if (result== 'success') {
                            window.location.href = '{{url('insurer/e-quotes-provider')}}';
                        }
                        else if(result=='amended')
                        {
                            window.location.href = '{{url('insurer/equotes-given')}}';
                    }
                        else
                        {
                            window.location.href = '{{url('insurer/e-quotes-provider')}}';
                        }
                    }
                });
            }
    });
        function scrolltop()
        {
            $('html,body').animate({
                scrollTop: 150
            }, 0);
        }

        function dropdownValidation(obj)
        {
            var value = obj.value;

            if(value == '')
                $('#'+obj.id+'-error').show();
            else
                $('#'+obj.id+'-error').hide();
        }
        function saveDraft()
        {
            var form_data = new FormData($("#e-quotation-form")[0]);
            form_data.append('_token',"{{csrf_token()}}");
            form_data.append('saveDraft', 'true');
            $('#preLoader').fadeIn('slow');
            $.ajax({
                method: 'post',
                url: '{{url('insurer/property-save')}}',
                data: form_data,
                cache: false,
                contentType: false,
                processData: false,
                success:function (data) {
                    if(data)
                    {
                        location.href="{{url('insurer/e-quotes-provider')}}";
                    }
                }
            });
        }
        jQuery.validator.addMethod("dropdown_required", function(value, element) {
            if(value!='') {
                return true;
            } else {
                return false;
            }
        }, 'Please select this field.');
    </script>
@endpush


