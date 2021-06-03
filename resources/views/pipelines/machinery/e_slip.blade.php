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
                <h3 class="title" style="margin-bottom: 8px;">Machinery Breakdown</h3>
            </div>
            <div class="card_content">
                <div class="edit_sec clearfix">

                    <!-- Steps -->
                    <section>
                        <nav>
                            <ol class="cd-breadcrumb triangle">
                                @if($pipeline_details['status']['status'] == 'E-slip')
                                    <li class="complete"><a href="{{ url('Machinery-Breakdown/e-questionnaire/'.$worktype_id) }}"><em>E-Questionnaire</em></a></li>
                                    <li class="current"><em>E-Slip</em></li>
                                    <li><em>E-Quotation</em></li>
                                    <li><em>E-Comparison</em></li>
                                    <li><em>Quote Amendment</em></li>
                                    <li><em>Approved E Quote</em></li>
                                    {{--<li><em>Issuance</em></li>--}}
                                @elseif($pipeline_details['status']['status'] == 'E-quotation')
                                    <li class="complete"><a href="{{ url('Machinery-Breakdown/e-questionnaire/'.$worktype_id) }}"><em>E-Questionnaire</em></a></li>
                                    <li class="active_arrow"><a href="{{url('Machinery-Breakdown/e-slip/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>
                                    <li class="current"><a href="{{url('Machinery-Breakdown/e-quotation/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                                    <li><em>E-Comparison</em></li>
                                    <li><em>Quote Amendment</em></li>
                                    <li><em>Approved E Quote</em></li>
                                    {{--<li><em>Issuance</em></li>--}}
                                @elseif($pipeline_details['status']['status'] == 'E-comparison')
                                    <li class="complete"><a href="{{ url('Machinery-Breakdown/e-questionnaire/'.$worktype_id) }}"><em>E-Questionnaire</em></a></li>
                                    <li class="active_arrow"><a href="{{url('Machinery-Breakdown/e-slip/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>
                                    <li class="complete"><a href="{{url('Machinery-Breakdown/e-quotation/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                                    <li class="current"><a href="{{url('Machinery-Breakdown/e-comparison/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                                    <li><em>Quote Amendment</em></li>
                                    <li><em>Approved E Quote</em></li>
                                    {{--<li><em>Issuance</em></li>--}}
                                @elseif($pipeline_details['status']['status'] == 'Quote Amendment')
                                    <li class="complete"><a href="{{ url('Machinery-Breakdown/e-questionnaire/'.$worktype_id) }}"><em>E-Questionnaire</em></a></li>
                                    <li class="active_arrow"><a href="{{url('Machinery-Breakdown/e-slip/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>
                                    <li class="complete"><a href="{{url('Machinery-Breakdown/e-quotation/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                                    <li class = complete><a href="{{url('Machinery-Breakdown/e-comparison/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                                    <li class = current><a href="{{url('Machinery-Breakdown/quot-amendment/'.$worktype_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>
                                    <li><em>Approved E Quote</em></li>
                                    {{--<li><em>Issuance</em></li>--}}
                                @elseif($pipeline_details['status']['status'] == 'Approved E Quote')
                                    <li class="complete"><a href="{{ url('Machinery-Breakdown/e-questionnaire/'.$worktype_id) }}"><em>E-Questionnaire</em></a></li>
                                    <li class="active_arrow"><a href="{{url('Machinery-Breakdown/e-slip/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>
                                    <li class="complete"><a href="{{url('Machinery-Breakdown/e-quotation/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                                    <li class = complete><a href="{{url('Machinery-Breakdown/e-comparison/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                                    <li class = complete><a href="{{url('Machinery-Breakdown/quot-amendment/'.$worktype_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>
                                    <li class = "current"><a href="{{url('Machinery-Breakdown/approved-quot/'.$worktype_id)}}" style="color: #ffffff;"><em>Approved E Quote</em></a></li>
                                    {{--<li><em>Issuance</em></li>--}}
                                @elseif($pipeline_details['status']['status'] == 'Quote Amendment-E-comparison' || $pipeline_details['status']['status'] == 'Quote Amendment-E-quotation' || $pipeline_details['status']['status'] == 'Quote Amendment-E-slip')
                                    <li class="complete"><a href="{{ url('Machinery-Breakdown/e-questionnaire/'.$worktype_id) }}"><em>E-Questionnaire</em></a></li>
                                    <li class="active_arrow"><a href="{{url('Machinery-Breakdown/e-slip/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>
                                    <li class="complete"><a href="{{url('Machinery-Breakdown/e-quotation/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                                    <li class = complete><a href="{{url('Machinery-Breakdown/e-comparison/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                                    <li class = current><a href="{{url('Machinery-Breakdown/quot-amendment/'.$worktype_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>
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
                                    <li class="complete"><a href="{{ url('Machinery-Breakdown/e-questionnaire/'.$worktype_id) }}"><em>E-Questionnaire</em></a></li>
                                    <li class="current"><a href="{{url('Machinery-Breakdown/e-slip/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>
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
                            <div class="col-md-6">
                                <div class="form_group">
                                    <label class="form_label">Name of the Insured</label>
                                    <div class="enter_data">
                                        <p>{{@$pipeline_details['formData']['firstName']}}</p>
                                    </div>
                                </div>
                            </div>
    
                            <div class="col-md-6">
                                <div class="form_group">
                                    <label class="form_label">If there is any subsidiary/affliated company </label>
                                    <div class="enter_data">
                                        <p>{{@$pipeline_details['formData']['aff_company']?:'--'}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                    <div class="form_group">
                                        <label class="form_label">Address Line 1</label>
                                        <div class="enter_data">
                                            <p>{{@$pipeline_details['formData']['addressDetails']['addressLine1']}}</p>
                                        </div>
                                    </div>
                            </div>
                            <div class="col-md-6">
                                    <div class="form_group">
                                        <label class="form_label">Address Line 2</label>
                                        <div class="enter_data">
                                            <p>{{@$pipeline_details['formData']['addressDetails']['addressLine2']}}</p>
                                        </div>
                                    </div>
                            </div>
                            <div class="col-md-6">
                                    <div class="form_group">
                                        <label class="form_label">Telephone Number</label>
                                        <div class="enter_data">
                                            <p>{{@$pipeline_details['formData']['telno']}}</p>
                                        </div>
                                    </div>
                            </div>
                            <div class="col-md-6">
                                    <div class="form_group">
                                        <label class="form_label">Fax Number</label>
                                        <div class="enter_data">
                                            <p>{{@$pipeline_details['formData']['faxno']}}</p>
                                        </div>
                                    </div>
                            </div>
                            <div class="col-md-6">
                                    <div class="form_group">
                                        <label class="form_label">Email ID</label>
                                        <div class="enter_data">
                                            <p>{{@$pipeline_details['formData']['email']}}</p>
                                        </div>
                                    </div>
                            </div>
                            <div class="col-md-6">
                                    <div class="form_group">
                                        <label class="form_label">Nature of Business</label>
                                        <div class="enter_data">
                                            <p>{{@$pipeline_details['formData']['businessType']}}</p>
                                        </div>
                                    </div>
                            </div>
                            <div class="col-md-6">
                                    <div class="form_group">
                                        <label class="form_label">Name of Chief engineer or plant manager</label>
                                        <div class="enter_data">
                                            <p>{{@$pipeline_details['formData']['chief_eng']?:'--'}}</p>
                                        </div>
                                    </div>
                            </div>
                           
                    </div>
                  
                <div class="card_separation">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form_group">
                            <label class="form_label">Has any of the machinary to be insured previously been covered by other companies ?</label>
                            <div class="enter_data">
                                <p>@if(isset($form_data['previousInsurer']) && @$form_data['previousInsurer'] ==true) Yes @else No @endif</p>
                            </div>
                            </div>
                        </div>
                    </div>
<div class="wrapper" @if(isset($form_data['previousInsurer']) && @$form_data['previousInsurer'] == true ) style="display:block" @else style="display:none" @endif>

@foreach($form_data['previousInsure'] as $data)
@if($data['equipment']=='' ||  $data['equipment'] || $data['expirydate']=='' || $data['companyname']=='' || $data['companyname'] || $data['expirydate'])
   <div class="row locations" id="safe_location1">
    <div class="col-md-4">
        <div class="form-group">
            <label class="form_label">Equipment Name</label>
            <input class="form_input"  name="equipment[]"  id="equipment"  type="text" readonly placeholder="Equipment Name" value="{{$data['equipment']}}">
        </div>
    </div>
    <div class="col-md-4">
         <div class="form-group">
             <label class="form_label">Company Name</label>
             <input class="form_input"  name="companyname[]"  id="companyname"  readonly type="text" value="{{$data['companyname']}}">
         </div>
     </div>
     <div class="col-md-4">
             <div class="form-group">
                 <label class="form_label">Expiry Date</label>
                 <input class="form_input"  name="expirydate[]"  id="expirydate"  readonly type="text" value="{{$data['expirydate']}}">
             </div>
     </div>
          
   </div>
  
@endif
@endforeach

</div>
                </div>
                    <div class="row">
                            <div class="col-md-6">
                                <div class="form_group">
                                    <label class="form_label">Do you wish to insure the foundation of the machinery?</label>
                                    <div class="enter_data">
                                            <p>@if(isset($form_data['found_machiners']['found_machinery']) && @$form_data['found_machiners']['found_machinery'] ==true) Yes @else No @endif</p>
                                    </div>
                                </div>
                            </div>
                            @if(isset($form_data['found_machiners']['found_machinery']) && @$form_data['found_machiners']['found_machinery'] ==true)
                            <div class="col-md-6">
                                <div class="form_group">
                                        <label class="form_label">Mention relevant items of the specification</label>
                                        <textarea class="form_input" id="machinery_comment" name="machinery_comment" readonly placeholder="Mention relevant items of the specification ">{{$form_data['found_machiners']['comment']}}</textarea>
                                </div>
                            </div>
                            @endif
                        </div>
                    <div class="row">
                            <div class="col-md-6">
                                <div class="form_group">
                                    <label class="form_label">DOES THE SPECIFICATION INCLUDE ALL THE MACHINERY COVERABLE UNDER A MACHINERY POLICY?</label>
                                    <div class="enter_data">
                                            <p>@if(isset($form_data['machinery_policy']['machinery_policy']) && @$form_data['machinery_policy']['machinery_policy'] ==false) No @else Yes @endif</p>
                                    </div>
                                </div>
                            </div>
                            @if(isset($form_data['machinery_policy']['machinery_policy']) && @$form_data['machinery_policy']['machinery_policy'] ==false)
                            <div class="col-md-6">
                                <div class="form_group">
                                        <label class="form_label">Mention relevant items of the specification</label>
                                        <textarea class="form_input" id="machinery_comment" name="machinery_comment" readonly placeholder="Mention relevant items of the specification ">{{$form_data['machinery_policy']['comment']}}</textarea>
                                </div>
                            </div>
                            @endif
                        </div>
                      
                        <div class="card_separation">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card_sub_head">
                                            <div class="clearfix">
                                                <h3 class="card_sub_heading pull-left">Do you wish the cover to include extra charges (incase of loss) for:</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                        <div class="col-md-6">
                                            <div class="form_group">
                                                <label class="form_label">Air Freight</label>
                                                <div class="enter_data">
                                                        <p>@if(isset($form_data['freight']['freight']) && @$form_data['freight']['freight'] ==true) Yes @else No @endif</p>
                                                </div>
                                            </div>
                                        </div>
                                        @if(isset($form_data['freight']['freight']) && @$form_data['freight']['freight'] ==true)
                                        <div class="col-md-6">
                                                <div class="form_group">
                                                        <div class="form-group">
                                                                <label class="form_label">LIMIT OF INDEMNITY FOR AIR FREIGHT</label>
                                                                <textarea class="form_input" id="air_freight" name="air_freight" readonly>{{$form_data['freight']['comment']}}</textarea>
                                                            </div>
                                                </div>
                                        </div>
                                        @endif
                                        <div class="col-md-6">
                                                <div class="form_group">
                                                        <div class="form-group">
                                                                <label class="form_label">Overtime</label>
                                                                <div class="enter_data">
                                                                <p>@if(isset($form_data['overtime']['overtime']) && @$form_data['overtime']['overtime'] ==true) Yes @else No @endif</p>
                                                                </div>
                                                            </div>
                                                </div>
                                        </div>
                                        <div class="col-md-6">
                                                <div class="form_group">
                                                        <div class="form-group">
                                                                <label class="form_label">Night work & work on public holidays</label>
                                                                <div class="enter_data">
                                                                <p>@if(isset($form_data['holiday']['holiday']) && @$form_data['holiday']['holiday'] ==true) Yes @else No @endif</p>
                                                                </div>
                                                            </div>
                                                </div>
                                        </div>
                                </div>
                            </div>
                        
                        
                        <div class="row">
                                <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form_label">Give details of any special extension of cover required</label>
                                            <textarea class="form_input" id="spec_extension" name="spec_extension" readonly placeholder="Give details of any special extension of cover required ">@if(!empty($form_data)) {{$form_data['spec_extension']?:'--'}} @else {{'--'}} @endif</textarea>
                                        </div>
                                </div>
                        </div>
                        <div class="card_separation">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form_group">
                                            {{-- <label class="form_label">Publications- Journal</label> --}}
                                            <table class="table table-bordered custom_table">
                                                    <thead>
                                                    <tr>
                                                        <th style="position: absolute; top: 0; border: none;">Item No</th>
                                                        <th>Description of items Please give full and exact description of all machines, including name of
                                                                manufacturer , type, output, capacity, speed, load, voltage, amperage, Cycles, fuel,pressure, temperature etc. </th>
                                                        <th style="position: absolute; top: 0; border: none;">Year of Manufacture</th>
                                                        <th>Remarks Give particulars of any part of the machinery to be insured which has had a
                                                                breakdown of failure during the last three years, which shows any signs of repair, or which is exposed to any special risk. </th>
                                                        <th>Replacement value Please state current cost of replacing the machinery of the same kind and capacity (including oil in the case of transformers & switches) plus freight charges,
                                                                customs duties, costs of erection and also value of foundations, if the latter are to be insured.</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody class="optionBox">
                                                    <tr class="block">
                                                        <td style="width: 80px;">
                                                            <textarea class="form_input" name="itemno" type="text" placeholder="Item No" readonly>@if(@$form_data['equipment_details']['itemno']!=''){{@$form_data['equipment_details']['itemno']}}@endif</textarea>
                                                            {{-- <input class="form_input" name="itemno" type="text" placeholder="Item No" value="@if(@$form_data['equipment_details']['itemno']!=''){{@$form_data['equipment_details']['itemno']}}@endif" readonly> --}}
                                                        </td>
                                                        <td>
                                                            <textarea class="form_input" name="item_description" type="text" placeholder="Description of items" readonly>@if(@$form_data['equipment_details']['description']!=''){{@$form_data['equipment_details']['description']}}@endif</textarea>
                                                            {{-- <input class="form_input" name="item_description" type="text" placeholder="Description of items " value="@if(@$form_data['equipment_details']['description']!=''){{@$form_data['equipment_details']['description']}}@endif" readonly> --}}
                                                        </td>
                                                        <td style="width: 155px;">
                                                            <textarea class="form_input" name="manufac_year" type="text" placeholder="Year of Manufacture" readonly>@if(@$form_data['equipment_details']['manufac_year']!=''){{@$form_data['equipment_details']['manufac_year']}}@endif</textarea>
                                                            {{-- <input class="form_input" name="manufac_year" type="text" placeholder="Year of Manufacture" value="@if(@$form_data['equipment_details']['manufac_year']!=''){{@$form_data['equipment_details']['manufac_year']}}@endif" readonly> --}}
                                                        </td>
                                                        <td>
                                                            <textarea  class="form_input" name="remarks" type="text" placeholder="Remarks Give particulars of any part of the machinery to be insured" readonly>@if(@$form_data['equipment_details']['remarks']!=''){{@$form_data['equipment_details']['remarks']}}@endif</textarea>
                                                            {{-- <input class="form_input" name="remarks" type="text" placeholder="Remarks Give particulars of any part of the machinery to be insured" value="@if(@$form_data['equipment_details']['remarks']!=''){{@$form_data['equipment_details']['remarks']}}@endif" readonly> --}}
                                                        </td>
                                                        <td>
                                                            <textarea class="form_input number" name="revalue" type="text" placeholder="Replacement value Please state current cost of replacing the machinery" readonly>@if(@$form_data['equipment_details']['revalue']!=''){{number_format(@$form_data['equipment_details']['revalue'],2)}}@endif</textarea>
                                                            {{-- <input class="form_input number" name="revalue" type="text" placeholder="Replacement value Please state current cost of replacing the machinery" value="@if(@$form_data['equipment_details']['revalue']!=''){{@$form_data['equipment_details']['revalue']}}@endif" readonly> --}}
                                                        </td>
                                                        
                                                    </tr>
                                                    </tbody>
                                                </table>
                        
                                            </div>
                                        </div>
                                    </div>
                        </div>
                                <div class="card_separation">
                                        {{-- <div class="row">
                                            <div class="col-md-6">
                                                <div class="card_sub_head">
                                                    <div class="clearfix">
                                                        <h3 class="card_sub_heading pull-left">Do you wish the cover to include extra charges(incase of loss) for:</h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}
                                        <div class="row">
                                                <div class="col-md-6">
                                                <div class="form_group">
                                                        <div class="form-group">
                                                                <label class="form_label bold">Business Interruption cover Required</label>
                                                                <div class="enter_data">
                                                                <p>@if(isset($form_data['machineryInterruption']['bus_inter']) && @$form_data['machineryInterruption']['bus_inter'] ==true) Yes @else No @endif</p>
                                                                </div>
                                                            </div>
                                                </div>
                                                </div>
                                        </div>
                                        <div id="business" @if(isset($form_data['machineryInterruption']['bus_inter']) && @$form_data['machineryInterruption']['bus_inter'] == true ) style="display:block" @else style="display:none" @endif>
                                                <div class="row">
                                                        <div class="col-md-6">
                                                                <div class="form_group">
                                                                
                                                                        <label class="form_label">Actual Annual Gross Profit for the previous year (AED)</label>
                                                                        <input class="form_input number"  name="actual_profit"  id="actual_profit"  type="text" value="@if(isset($form_data['machineryInterruption']['actualProfit']) && @$form_data['machineryInterruption']['bus_inter'] ==true){{number_format($form_data['machineryInterruption']['actualProfit'],2)}}@endif" readonly>
                                                                
                                                                </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                                <div class="form_group">
                                                                
                                                                        <label class="form_label">Estimated Annual Gross Profit for the next year (AED)</label>
                                                                        <input class="form_input number"  name="estimated_profit"  id="estimated_profit"  type="text" value="@if(isset($form_data['machineryInterruption']['estimatedProfit']) && @$form_data['machineryInterruption']['bus_inter'] ==true){{number_format($form_data['machineryInterruption']['estimatedProfit'],2)}}@endif" readonly>
                                                                
                                                                </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                                <div class="form_group">
                                                                
                                                                        <label class="form_label">Standing Charges</label>
                                                                        <input class="form_input number"  name="standing_charge"  id="standing_charge"  type="text" value="@if(isset($form_data['machineryInterruption']['standCharge']) && @$form_data['machineryInterruption']['bus_inter'] ==true){{number_format($form_data['machineryInterruption']['standCharge'],2)}}@endif" readonly>
                                                                
                                                                </div>
                                                        </div>
                                                
                                               
                                                    <div class="col-md-6">
                                                            <div class="form_group">
                                                            
                                                                    <label class="form_label">No of locations</label>
                                                                    <input class="form_input number"  name="no_location"  id="no_location"  type="text" value="@if(isset($form_data['machineryInterruption']['no_location']) && @$form_data['machineryInterruption']['bus_inter'] ==true){{number_format($form_data['machineryInterruption']['no_location'],2)}}@endif" readonly>
                                                            
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                            <div class="form_group">
                                                            
                                                                    <label class="form_label">Increase cost of working</label>
                                                                    <input class="form_input number"  name="cost_work"  id="cost_work"  type="text" value="@if(isset($form_data['machineryInterruption']['costwork']) && @$form_data['machineryInterruption']['bus_inter'] ==true){{number_format($form_data['machineryInterruption']['costwork'],2)}}@endif" readonly>
                                                            
                                                            </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                            <div class="form_group">
                                                            
                                                                    <label class="form_label">Period of indemnity</label>
                                                                    <input class="form_input number"  name="indemnity_period"  id="indemnity_period"  type="text" value="@if(isset($form_data['machineryInterruption']['indemnityPeriod']) && @$form_data['machineryInterruption']['bus_inter'] ==true){{number_format($form_data['machineryInterruption']['indemnityPeriod'],2)}}@endif" readonly>
                                                            
                                                            </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form_group">
                                                        
                                                                <label class="form_label">Policy period</label>
                                                                <input class="form_input"  name="period"  id="period"  type="text" value="12" readonly>
                                                        
                                                        </div>
                                                </div>
                                                
                                                </div>
                                        </div>
                                    </div>
                                        {{-- <div class="row">
                                                <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="form_label">Amount</label>
                                                            <textarea class="form_input" id="amount" name="amount" placeholder="Amount" readonly>@if(!empty($form_data)) {{$form_data['amount']}} @endif</textarea>
                                                        </div>
                                                </div>
                                        </div>     --}}
                                        <div class="card_separation">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form_group">
                                                            <label class="form_label bold" id="claim_label">Claims experience <span style="visibility:hidden">*</span></label>
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
                                                                    <input type="hidden" value="Year 1" name="year[]" id="year1">
                                                                    <td>Year 1 </td>
                                                                    <td>
                                                                        <input class="form_input" name="claim_amount[]" id="claim_amount1"  value="@if(isset($form_data['claimsHistory'][0]['claim_amount']) && (@$form_data['claimsHistory'][0]['claim_amount'])!=""){{number_format(@$form_data['claimsHistory'][0]['claim_amount'],2)}}@else--@endif" readonly>
                                                                        <label id="claim_amount1-error" class="error" for="claim_amount1" style="display: none">Please enter claim amount.</label>
                                                                    </td>
                                                                    <td><textarea class="form_input" name="description[]" id="description1"readonly>{{@$form_data['claimsHistory'][0]['description']?:'--'}}</textarea>
                                                                        <label id="description1-error" class="error" for="description1" style="display: none">Please enter description.</label>
                                                                    </td>
                                                                    
                                                                </tr>
                                                                
                                                                <tr>
                                                                    <td>Year 2 <input type="hidden" value="Year 2" name="year[]" id="year2"></td>
                                                                    <td><input class="form_input" name="claim_amount[]" id="claim_amount2"  value="@if(isset($form_data['claimsHistory'][1]['claim_amount']) && (@$form_data['claimsHistory'][1]['claim_amount'])!=""){{number_format(@$form_data['claimsHistory'][1]['claim_amount'],2)}}@else--@endif" readonly></td>
                                                                    <td><textarea class="form_input" name="description[]" type="text" id="description2" readonly>{{@$form_data['claimsHistory'][1]['description']?:'--'}}</textarea></td>
                                                                    
                                                                </tr>
                                                                
                                                                <tr>
                                                                    <td>Year 3<input type="hidden" value="Year 3" name="year[]" id="year3"></td>
                                                                    <td><input class="form_input" name="claim_amount[]" id="claim_amount3"  value="@if(isset($form_data['claimsHistory'][2]['claim_amount']) && (@$form_data['claimsHistory'][2]['claim_amount'])!=""){{number_format(@$form_data['claimsHistory'][2]['claim_amount'],2)}}@else--@endif" readonly></td>
                                                                    <td><textarea class="form_input" name="description[]" type="text" id="description3" readonly>{{@$form_data['claimsHistory'][2]['description']?:'--'}}</textarea></td>
                                                                </tr>
                                                                
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                   

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['localclause']) @if(@$pipeline_details['formData']['localclause'] != false) checked @endif @else checked @endif  name="localclause" value="true" id="localclause" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="automaticClause" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Local Jurisdiction Clause</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['express']) @if(@$pipeline_details['formData']['express'] != false) checked @endif @else checked @endif  name="express" value="true" id="express" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="automaticClause" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Overtime, night works and express freight</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['airfreight']) @if(@$pipeline_details['formData']['airfreight'] != false) checked @endif @else checked @endif  name="airfreight" value="true" id="airfreight" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="automaticClause" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Airfreight</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['addpremium'] ) @if(@$pipeline_details['formData']['addpremium'] != false) checked @endif @else checked @endif  name="addpremium" value="true" id="addpremium" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="automaticClause" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Automatic Reinstatement of sum insured at pro rata additional premium</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['payAccount']) @if(@$pipeline_details['formData']['payAccount'] != false) checked @endif @else checked @endif  name="payAccount" value="true" id="payAccount" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="automaticClause" class="cbx">
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
                                        <input type="checkbox" @if(@$pipeline_details['formData']['primaryclause']) @if(@$pipeline_details['formData']['primaryclause'] != false) checked @endif @else checked @endif  name="primaryclause" value="true" id="primaryclause" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="automaticClause" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Primary Insurance clause</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['premiumClaim']) @if(@$pipeline_details['formData']['premiumClaim'] != false) checked @endif @else checked @endif  name="premiumClaim" value="true" id="premiumClaim" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="automaticClause" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Cancellation – 60 days notice by either party subject to pro-rata refund of premium unless a claim has attached</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['lossnotification']) @if(@$pipeline_details['formData']['lossnotification'] != false) checked @endif @else checked @endif  name="lossnotification" value="true" id="lossnotification" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="automaticClause" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Loss Notification – ‘as soon as reasonably practicable’ </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['adjustmentPremium']) @if(@$pipeline_details['formData']['adjustmentPremium'] != false) checked @endif @else checked @endif  name="adjustmentPremium" value="true" id="adjustmentPremium" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="automaticClause" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Adjustment of sum insured and premium (Mre-410)</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['temporaryclause']) @if(@$pipeline_details['formData']['temporaryclause'] != false) checked @endif @else checked @endif  name="temporaryclause" value="true" id="temporaryclause" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="automaticClause" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Temporary repairs clause</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['automaticClause']) @if(@$pipeline_details['formData']['automaticClause'] != false) checked @endif @else checked @endif  name="automaticClause" value="true" id="automaticClause" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="automaticClause" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Automatic addition clause</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['capitalclause']) @if(@$pipeline_details['formData']['capitalclause'] != false) checked @endif @else checked @endif  name="capitalclause" value="true" id="capitalclause" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="automaticClause" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Capital addition clause</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['debris']) @if(@$pipeline_details['formData']['debris'] != false) checked @endif @else checked @endif  name="debris" value="true" id="debris" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="automaticClause" class="cbx">
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
                                        <input type="checkbox" @if(@$pipeline_details['formData']['property']) @if(@$pipeline_details['formData']['property'] != false) checked @endif @else checked @endif  name="property" value="true" id="property" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="automaticClause" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Designation of property</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['errorclause']) @if(@$pipeline_details['formData']['errorclause'] != false) checked @endif @else checked @endif  name="errorclause" value="true" id="errorclause" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="automaticClause" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Errors and omission clause</label>
                                </div>
                            </div>
                        </div>
                        @if(@$form_data['aff_company']!='')
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['waiver']) @if(@$pipeline_details['formData']['waiver'] != false) checked @endif @else checked @endif  name="waiver" value="true" id="waiver" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="automaticClause" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Waiver of subrogation</label>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['claimclause']) @if(@$pipeline_details['formData']['claimclause'] != false) checked @endif @else checked @endif  name="claimclause" value="true" id="claimclause" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="automaticClause" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Claims preparation clause</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['Innocent']) @if(@$pipeline_details['formData']['Innocent'] != false) checked @endif @else checked @endif  name="Innocent" value="true" id="Innocent" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="automaticClause" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Innocent non-disclosure</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['Noninvalidation']) @if(@$pipeline_details['formData']['Noninvalidation'] != false) checked @endif @else checked @endif  name="Noninvalidation" value="true" id="Noninvalidation" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="automaticClause" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Non-invalidation clause</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['brokerclaim']) @if(@$pipeline_details['formData']['brokerclaim'] != false) checked @endif @else checked @endif  name="brokerclaim" value="true" id="brokerclaim" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="automaticClause" class="cbx">
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
                        <div class="col-md-4">
                            <div class="form_group">
                                <label class="form_label bold">Deductible:<span>*</span></label>
                                <input class="form_input number" id="deductible" name="deductible" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="@if(isset($pipeline_details['formData']['deductible']) && $pipeline_details['formData']['deductible'] != ''){{number_format(@$pipeline_details['formData']['deductible'],2)}}@endif" >
                               
    
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form_group">
                                <label class="form_label bold">Rate/premium required: <span>*</span></label>
                                <input class="form_input number" id="ratep" name="ratep" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="@if(isset($pipeline_details['formData']['ratep']) && $pipeline_details['formData']['ratep'] != ''){{number_format(@$pipeline_details['formData']['ratep'],2)}}@endif" >
                                
    
                            </div>
                        </div>
                        
                    </div>
                   


                  
                </div>
                    <div class="clearfix">
                    {{-- <button type="button"  id="logOut" name="logOut"  class="btn btn-primary btn_action pull-right">logOut</button> --}}

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
                     
                        $("#logOut").click(function() {
                           
                            $.ajax({
                                    method: 'post',
                                    url: '{{url('Machinery-Breakdown/log-out')}}',
                                    data:
                                    {
                                        _token:'{{csrf_token()}}'
                                    },
                                    success: function (result) {
                                        if (result== 'success') {
                                          console.log("success");
                                        }
                                    }
                                });
                        });



                   

            
            $('#e-slip-form').validate({
                             ignore: [],
                                     rules: {
                                       
                                        deductible:{
                                            required:true,
                                            number:true
                                        },
                                        ratep:{
                                            required:true,
                                            number:true
                                        },
                                        

                             },
                             messages: {
                              
                                deductible: "Please enter deductible.",
                                ratep: "Please enter Rate/premium.",
                                 
                               },
                             errorPlacement: function (error, element) {
                                
                                  if(element.attr("name") == "hasaccomodation")
                                 {
                                     error.insertAfter(element.parent());
                                     // scrolltop();
                                 }
                                 else if(element.attr("name") == "deductible" ||
                                  element.attr("name") == "ratep")
                                {
                                    error.insertAfter(element);
                                }
                                 else {
                                     error.insertAfter(element);
                                     // scrolltop();
                                 }
                             },
                            submitHandler: function (form,event) {
                                // if ({{ Auth::check() }} == true) {
                                var form_data = new FormData($("#e-slip-form")[0]);
                                form_data.append('_token', '{{csrf_token()}}');
                                $('#preLoader').show();
//$("#eslip_submit").attr( "disabled", "disabled" );
                                $.ajax({
                                    method: 'post',
                                    url: '{{url('Machinery-Breakdown/eslip-save')}}',
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
                                // }
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
                                
                            },
                            messages: {
                                 
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
                                    url: '{{url('Machinery-Breakdown/insurance-company-save')}}',
                                    data: form_data,
                                    processData: false,
                                    contentType: false,
                                    success: function (result) {
                                        if (result.success== 'success') {
                                            $("#send_btn").attr( "disabled", false );
                                            window.location.href = '{{url('Machinery-Breakdown/e-quotation')}}'+'/'+result.id;
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
                                // console.log(Auth::check());
                                // if ({{ Auth::check() }} == true) {
                                var form_data = new FormData($("#e-slip-form")[0]);
                                form_data.append('_token', '{{csrf_token()}}');
                                form_data.append('is_save','true');
                                $('#preLoader').show();
                                //$("#eslip_submit").attr( "disabled", "disabled" );
                                $.ajax({
                                    method: 'post',
                                    url: '{{url('Machinery-Breakdown/eslip-save')}}',
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
                                // }
                            }

      
    // function validate(x,type) {
    //                             // debugger;
    //     var parts = x.split(".");
    //     if (typeof parts[1] == "string" && (parts[1].length == 0 || parts[1].length > 2))
    //     {
    //         if(type=='deductible')
    //         {
    //             $("#deductible-error").show();
    //         }else if(type=='ratep')
    //         {
    //             $("#ratep-error").show();
    //         }else if(type=='brokerage')
    //         {
    //             $("#brokerage-error").show();
    //         }else if(type=='spec_conditions')
    //         {
    //             $("#spec_conditions-error").show();
    //         }else if(type=='warranty')
    //         {
    //             $("#warranty-error").show();
    //         }
    //         else if(type=='exclusion')
    //         {
    //             $("#exclusion-error").show();
    //         }
    //     }
        
    //     var n = parseFloat(x);
    //      if (isNaN(n))
    //     {
    //         if(type=='deductible')
    //         {
    //             $("#deductible-error").show();
    //         }else if(type=='ratep')
    //         {
    //             $("#ratep-error").show();
    //         }else if(type=='brokerage')
    //         {
    //             $("#brokerage-error").show();
    //         }else if(type=='spec_conditions')
    //         {
    //             $("#spec_conditions-error").show();
    //         }else if(type=='warranty')
    //         {
    //             $("#warranty-error").show();
    //         }
    //         else if(type=='exclusion')
    //         {
    //             $("#exclusion-error").show();
    //         }
    //     }
    //     else if (n < 0 || n > 100)
    //     {
    //         if(type=='deductible')
    //         {
    //             $("#deductible-error").show();
    //         }else if(type=='ratep')
    //         {
    //             $("#ratep-error").show();
    //         }else if(type=='brokerage')
    //         {
    //             $("#brokerage-error").show();
    //         }else if(type=='spec_conditions')
    //         {
    //             $("#spec_conditions-error").show();
    //         }else if(type=='warranty')
    //         {
    //             $("#warranty-error").show();
    //         }
    //         else if(type=='exclusion')
    //         {
    //             $("#exclusion-error").show();
    //         }
    //     }
    //     else{
    //         if(type=='deductible')
    //         {
    //             $("#deductible-error").show();
    //         }else if(type=='ratep')
    //         {
    //             $("#ratep-error").show();
    //         }else if(type=='brokerage')
    //         {
    //             $("#brokerage-error").show();
    //         }else if(type=='spec_conditions')
    //         {
    //             $("#spec_conditions-error").show();
    //         }else if(type=='warranty')
    //         {
    //             $("#warranty-error").show();
    //         }
    //         else if(type=='exclusion')
    //         {
    //             $("#exclusion-error").show();
    //         }
    //      }
    // }
                    </script>
    @endpush


