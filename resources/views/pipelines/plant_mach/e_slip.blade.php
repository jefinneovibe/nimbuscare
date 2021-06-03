
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
                <h3 class="title" style="margin-bottom: 8px;">{{$pipeline_details['workTypeId']['name']}}</h3>
            </div>
            <div class="card_content">
                <div class="edit_sec clearfix">

                    <!-- Steps -->
                    <section>
                        <nav>
                            <ol class="cd-breadcrumb triangle">
                                @if($pipeline_details['status']['status'] == 'E-slip')
                                    <li class="complete"><a href="{{ url('contractor-plant/e-questionnaire/'.$worktype_id) }}"><em>E-Questionnaire</em></a></li>
                                    <li class="current"><em>E-Slip</em></li>
                                    <li><em>E-Quotation</em></li>
                                    <li><em>E-Comparison</em></li>
                                    <li><em>Quote Amendment</em></li>
                                    <li><em>Approved E Quote</em></li>
                                @elseif($pipeline_details['status']['status'] == 'E-quotation')
                                    <li class="complete"><a href="{{ url('contractor-plant/e-questionnaire/'.$worktype_id) }}"><em>E-Questionnaire</em></a></li>
                                    <li class="active_arrow"><a href="{{url('contractor-plant/e-slip/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>
                                    <li class="current"><a href="{{url('contractor-plant/e-quotation/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                                    <li><em>E-Comparison</em></li>
                                    <li><em>Quote Amendment</em></li>
                                    <li><em>Approved E Quote</em></li>
                                @elseif($pipeline_details['status']['status'] == 'E-comparison')
                                    <li class="complete"><a href="{{ url('contractor-plant/e-questionnaire/'.$worktype_id) }}"><em>E-Questionnaire</em></a></li>
                                    <li class="active_arrow"><a href="{{url('contractor-plant/e-slip/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>
                                    <li class="complete"><a href="{{url('contractor-plant/e-quotation/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                                    <li class="current"><a href="{{url('contractor-plant/e-comparison/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                                    <li><em>Quote Amendment</em></li>
                                    <li><em>Approved E Quote</em></li>
                                @elseif($pipeline_details['status']['status'] == 'Quote Amendment')
                                    <li class="complete"><a href="{{ url('contractor-plant/e-questionnaire/'.$worktype_id) }}"><em>E-Questionnaire</em></a></li>
                                    <li class="active_arrow"><a href="{{url('contractor-plant/e-slip/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>
                                    <li class="complete"><a href="{{url('contractor-plant/e-quotation/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                                    <li class = complete><a href="{{url('contractor-plant/e-comparison/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                                    <li class = current><a href="{{url('contractor-plant/quot-amendment/'.$worktype_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>
                                    <li><em>Approved E Quote</em></li>
                                @elseif($pipeline_details['status']['status'] == 'Approved E Quote')
                                    <li class="complete"><a href="{{ url('contractor-plant/e-questionnaire/'.$worktype_id) }}"><em>E-Questionnaire</em></a></li>
                                    <li class="active_arrow"><a href="{{url('contractor-plant/e-slip/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>
                                    <li class="complete"><a href="{{url('contractor-plant/e-quotation/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                                    <li class = complete><a href="{{url('contractor-plant/e-comparison/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                                    <li class = complete><a href="{{url('contractor-plant/quot-amendment/'.$worktype_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>
                                    <li class = "current"><a href="{{url('contractor-plant/approved-quot/'.$worktype_id)}}" style="color: #ffffff;"><em>Approved E Quote</em></a></li>
                                @elseif($pipeline_details['status']['status'] == 'Quote Amendment-E-comparison' || $pipeline_details['status']['status'] == 'Quote Amendment-E-quotation' || $pipeline_details['status']['status'] == 'Quote Amendment-E-slip')
                                    <li class="complete"><a href="{{ url('contractor-plant/e-questionnaire/'.$worktype_id) }}"><em>E-Questionnaire</em></a></li>
                                    <li class="active_arrow"><a href="{{url('contractor-plant/e-slip/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>
                                    <li class="complete"><a href="{{url('contractor-plant/e-quotation/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                                    <li class = complete><a href="{{url('contractor-plant/e-comparison/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                                    <li class = current><a href="{{url('contractor-plant/quot-amendment/'.$worktype_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>
                                    <li><em>Approved E Quote</em></li>
                                @else
                                    <li class="complete"><a href="{{ url('contractor-plant/e-questionnaire/'.$worktype_id) }}"><em>E-Questionnaire</em></a></li>
                                    <li class="current"><a href="{{url('contractor-plant/e-slip/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>
                                    <li><em>E-Quotation</em></li>
                                    <li><em>E-Comparison</em></li>
                                    <li><em>Quote Amendment</em></li>
                                    <li><em>Approved E Quote</em></li>
                                @endif
                            </ol>
                        </nav>
                    </section>
                    <div class="row" style="display:none">
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
                                <label class="form_label">NAME <span style="visibility:hidden">*</span></label>
                                <div class="enter_data">
                                    <p>{{@$pipeline_details['formData']['firstName']}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <label class="form_label">If there is any subsidiary/affliated company <span  style="visibility:hidden">*</span></label>
                                <div class="enter_data">
                                    <p>{{@$pipeline_details['formData']['affCompany']}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form_group">
                                <label class="form_label">Address<span style="visibility:hidden">*</span></label>
                                <div class="enter_data">
                                <p>{{@$pipeline_details['formData']['addressDetails']['addressLine1']}},{{$pipeline_details['formData']['addressDetails']['city']}},
                                    {{$pipeline_details['formData']['addressDetails']['state']}},{{$pipeline_details['formData']['addressDetails']['country']}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form_group">
                                <label class="form_label">BUSINESS OF THE  INSURED<span style="visibility:hidden">*</span></label>
                                <div class="enter_data">
                                    <p>{{@$pipeline_details['formData']['businessType']}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <label class="form_label bold">Geographical Area <span style="visibility:hidden">*</span></label>
                                <div class="enter_data border_none">
                                    @if(@$pipeline_details['formData']['placeOfEmployment']['withinUAE'] == 1)
                                        <?php $geo_area=@$pipeline_details['formData']['placeOfEmployment']['emirateName'].' ,UAE';?>
                                    @elseif(@$pipeline_details['formData']['placeOfEmployment']['withinUAE'] == 0)
                                        <?php $geo_area=@$pipeline_details['formData']['placeOfEmployment']['countryName'];?>
                                    @endif
                                    <p>{{$geo_area}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card_separation">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form_group">
                                    <label class="form_label bold">CLAIM EXPERIENCE <span style="visibility: hidden">*</span></label>
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
           

{{-- file upload --}}
<div class="row">
    <div class="col-md-4">
        <div class="form_group">
                @if(in_array('TAX REGISTRATION DOCUMENT',$file_name))
                <?php $key = array_search('TAX REGISTRATION DOCUMENT', $file_name) ?>
                @if($file_url[$key]!='')
                    <input type="hidden" value="{{$file_url[$key]}}" id="tax_url" name="tax_url">
                    <span class="pull-right" id="saved_tax_url">
                    <a target="_blank" href="{{$file_url[$key]}}">
                        <i class="fa fa-file"></i>
                    </a>
                </span>
                @endif
                </span>
                @endif
            <label class="form_label">Tax registration document <span style="visibility:hidden">*</span></label>
            <div class="custom_upload">
                <input type="file" name="tax_certificate" id="tax_certificate" onchange="upload_file(this)">
                <p id="tax_p">Drag your files or click here.</p>
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
                </span>
                @endif
                <label class="form_label">Copy of trade license <span style="visibility:hidden">*</span></label>
            <div class="custom_upload">
                <input type="file" name="trade_list" id="trade_list" onchange="upload_file(this)">
                <p id="trade_list_p">Drag your files or click here.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form_group">
                @if(in_array('LIST OF EMPLOYEES',$file_name))
                <?php $key = array_search('LIST OF EMPLOYEES', $file_name) ?>
                @if($file_url[$key]!='')
                    <input type="hidden" value="{{$file_url[$key]}}" id="emp_url" name="emp_url">
                    <span class="pull-right" id="saved_emp_list">
                    <a target="_blank" href="{{$file_url[$key]}}">
                        <i class="fa fa-file"></i>
                    </a>
                </span>
                @endif
                </span>
                @endif
                        <label class="form_label">List of employees <span style="visibility:hidden">*</span></label>
            <div class="custom_upload">
                <input type="file" name="employee_upload" id="employee_upload" onchange="upload_file(this)">
                <p id="employee_upload_p">Drag your files or click here.</p>
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
                </span>
                @endif
                        <label class="form_label">Others 1 <span style="visibility:hidden">*</span></label>
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
                </span>
                @endif
                        <label class="form_label">Others 2 <span style="visibility:hidden">*</span></label>
            <div class="custom_upload">
                <input type="file" name="others2" id="others2" onchange="upload_file(this)">
                <p id="others2_p">Drag your files or click here.</p>
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
                </span>
                @endif
                <label class="form_label">Copy of the policy if possible<span style="visibility:hidden">*</span></label>
            <div class="custom_upload">
                <input type="file" name="policyCopy" id="policyCopy" onchange="upload_file(this)">
                <p id="policy_p">Drag your files or click here.</p>
            </div>
        </div>
    </div>
</div>
{{-- file upload --}}
<div class="row">
    <div class="col-md-4">
            <div class="form_group">
                    @if(in_array('EXCEL',$file_name))
                    <?php $key = array_search('EXCEL', $file_name) ?>
                    @if($file_url[$key]!='')
                        <input type="hidden" value="{{$file_url[$key]}}" id="excel_url" name="excel_url">
                        <span class="pull-right" id="saved_excel_list">
                        <a target="_blank" href="{{$file_url[$key]}}">
                            <i class="fa fa-file"></i>
                        </a>
                    </span>
                    @endif
                    </span>
                    @endif
                    <label class="form_label">Uploaded Excel<span style="visibility:hidden">*</span></label>
                <div class="custom_upload">
                    <input type="file" name="excelCopy" id="excelCopy" onchange="upload_file(this)">
                    <p id="excelCopy_p">Drag your files or click here.</p>
                </div>
            </div>
        </div>
</div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="form_group">
                                    <label class="form_label" style="min-height: 40px">Authorised repair limit<span>*</span></label>
                                    <div class="enter_data">
                                        <input class="form_input" placeholder="" name="auth_repair" id="auth_repair"  type="text" @if(isset($pipeline_details['formData']['authRepair']) && 
                                        $pipeline_details['formData']['authRepair']!='') value="{{$pipeline_details['formData']['authRepair']}}" @endif>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox"  onclick="return false" name="strike_riot" value="true" id="strike_riot" class="inp-cbx" checked style="display: none">
                                        <label for="strike_riot" class="cbx">
                                        <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Strike, riot and civil commotion and malicious damage</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox"  name="overtime" onclick="return false" value="true" id="overtime" class="inp-cbx" checked style="display: none">
                                        <label for="overtime" class="cbx">
                                        <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Overtime, night works , works on public holidays and express freight</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox"  name="cover_extra" onclick="return false" value="true" id="cover_extra" class="inp-cbx" checked  style="display: none">
                                        <label for="cover_extra" class="cbx">
                                        <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Cover for extra charges for Airfreight</label>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox"  name="cover_under" onclick="return false" value="true" id="cover_under" class="inp-cbx"  checked style="display: none">
                                        <label for="cover_under" class="cbx">
                                        <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Cover for underground Machinery and equipment</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox"  name="drill_rigs" value="true" id="drill_rigs" class="inp-cbx" @if(@$pipeline_details['formData']['drillRigs'] && @$pipeline_details['formData']['drillRigs'] ==true) checked @endif style="display: none">
                                        <label for="drill_rigs" class="cbx">
                                        <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Cover for water well drilling rigs and equipment</label>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox"  name="inland_transit" onclick="return false" value="true" id="inland_transit" class="inp-cbx" checked  style="display: none">
                                        <label for="inland_transit" class="cbx">
                                        <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Inland Transit including loading and unloading cover</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox"  name="transit_road" onclick="return false" value="true" id="transit_road" class="inp-cbx" checked  style="display: none">
                                        <label for="transit_road" class="cbx">
                                        <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Transit and Road risks whilst the insured items are travelling/transporting on own power on public roads</label>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox"  name="third_party" onclick="return false" value="true" id="third_party" class="inp-cbx" checked style="display: none">
                                        <label for="third_party" class="cbx">
                                        <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Third Party Liability- whilst on site, owned and/or hired parking yard, during participation in any sales promotions, sports, social events, display at various sites within GCC either contract of hire or otherwise</label>
                                </div>
                            </div>
                        </div>
                        @if(isset($form_data['machEquip']['machEquip']) && ($form_data['machEquip']['machEquip'] == true))
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox"  name="cover_hired" onclick="return false" value="true" id="cover_hired" class="inp-cbx"  checked  style="display: none">
                                        <label for="cover_hired" class="cbx">
                                        <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Cover when items are hired out </label>
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
                                        <input type="checkbox"  name="auto_sum" onclick="return false" value="true" id="auto_sum" class="inp-cbx" checked style="display: none">
                                        <label for="auto_sum" class="cbx">
                                        <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Automatic Reinstatement of sum insured</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox"  name="includ_risk" onclick="return false" value="true" id="includ_risk" class="inp-cbx"  checked  style="display: none">
                                        <label for="includ_risk" class="cbx">
                                        <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Including the risk of erection, resettling and dismantling</label>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox"  name="tool" onclick="return false" value="true" id="tool" class="inp-cbx" checked  style="display: none">
                                        <label for="tool" class="cbx">
                                        <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Tool of trade extension</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox"  name="hours_clause" onclick="return false" value="true" id="hours_clause" class="inp-cbx" checked  style="display: none">
                                        <label for="hours_clause" class="cbx">
                                        <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">72 Hours clause</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox"  name="loss_adj" onclick="return false" value="true" id="loss_adj" class="inp-cbx" checked  style="display: none">
                                        <label for="loss_adj" class="cbx">
                                        <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Nominated Loss Adjuster Clause</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox"  name="primary_clause" onclick="return false" value="true" id="primary_clause" class="inp-cbx" checked  style="display: none">
                                        <label for="primary_clause" class="cbx">
                                        <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Primary Insurance Clause</label>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox"  name="payment_account" onclick="return false" value="true" id="payment_account" class="inp-cbx"  checked  style="display: none">
                                        <label for="payment_account" class="cbx">
                                        <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Payment on accounts clause-75%</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox"  name="avg_condition" onclick="return false" value="true" id="avg_condition" class="inp-cbx"  checked  style="display: none">
                                        <label for="avg_condition" class="cbx">
                                        <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">85% condition of average</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox"  name="auto_addition" onclick="return false" value="true" id="auto_addition" class="inp-cbx" checked  style="display: none">
                                        <label for="auto_addition" class="cbx">
                                        <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Automatic addition</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox"  name="cancel_clause" onclick="return false" value="true" id="cancel_clause" class="inp-cbx"  checked  style="display: none">
                                        <label for="cancel_clause" class="cbx">
                                        <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Cancellation clause</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox"  name="derbis" onclick="return false" value="true" id="derbis" class="inp-cbx"  checked  style="display: none">
                                        <label for="derbis" class="cbx">
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
                                        <input type="checkbox"  name="repair_clause" onclick="return false" value="true" id="repair_clause" class="inp-cbx"  checked  style="display: none">
                                        <label for="repair_clause" class="cbx">
                                        <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Repair investigation clause</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox"  name="temp_repair" onclick="return false" value="true" id="temp_repair" class="inp-cbx" checked style="display: none">
                                        <label for="temp_repair" class="cbx">
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
                                        <input type="checkbox"  name="error_omission" onclick="return false" value="true" id="error_omission" class="inp-cbx"  checked  style="display: none">
                                        <label for="error_omission" class="cbx">
                                        <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Errors & omission clause</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox"  name="min_loss" onclick="return false" value="true" id="min_loss" class="inp-cbx"  checked  style="display: none">
                                        <label for="min_loss" class="cbx">
                                        <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Minimization of loss</label>
                                </div>
                            </div>
                        </div>
                        @if(isset($form_data['affCompany']) && $form_data['affCompany']!='')
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox"  name="cross_liability" onclick="return false" value="true" id="cross_liability" class="inp-cbx"  checked  style="display: none">
                                        <label for="cross_liability" class="cbx">
                                        <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Cross liability</label>
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
                                        <input type="checkbox"  name="cover_include" onclick="return false" value="true" id="cover_include" class="inp-cbx"  checked  style="display: none">
                                        <label for="cover_include" class="cbx">
                                        <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Including cover for loading/ unloading and delivery risks</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox"  name="tow_charge" onclick="return false" value="true" id="tow_charge" class="inp-cbx" checked  style="display: none">
                                            <label for="tow_charge" class="cbx">
                                            <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                            </span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">Towing charges</label>
                                    </div>
                                </div>
                             </div>
                       
                    </div>
                    <div class="row">
                        
                        @if(isset($form_data['policyBank']['policyBank']) && @$form_data['policyBank']['policyBank'] ==true)
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox"  name="loss_payee" onclick="return false" value="true" id="loss_payee" class="inp-cbx"  checked  style="display: none">
                                        <label for="loss_payee" class="cbx">
                                        <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Loss payee clause</label>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="form_group">
                                    <label class="form_label" style="min-height: 40px">Agency repair<span>*</span></label>
                                    <div class="enter_data">
                                        <input class="form_input" placeholder="" name="agency_repair" id="agency_repair"  type="text" @if(isset($pipeline_details['formData']['agencyRepair']) && 
                                        $pipeline_details['formData']['agencyRepair']!='') value="{{$pipeline_details['formData']['agencyRepair']}}" @endif>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="form_group">
                                    <label class="form_label" style="min-height: 40px">Indemnity to principal<span>*</span></label>
                                    <div class="enter_data">
                                        <input class="form_input" placeholder="" name="indemnity_principal" id="indemnity_principal"  type="text" @if(isset($pipeline_details['formData']['indemnityPrincipal']) && 
                                        $pipeline_details['formData']['indemnityPrincipal']!='') value="{{$pipeline_details['formData']['indemnityPrincipal']}}" @endif>
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
                                        <input type="checkbox"  name="prop_design" onclick="return false" value="true" id="prop_design" class="inp-cbx"  checked  style="display: none">
                                        <label for="prop_design" class="cbx">
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
                                            <input type="checkbox"  name="special_agree" onclick="return false" value="true" id="special_agree" class="inp-cbx" checked  style="display: none">
                                            <label for="special_agree" class="cbx">
                                            <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                            </span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">Special condition :It is understood and agreed that exclusion ‘C’ will not apply to accidental losses’.</label>
                                    </div>
                                </div>
                             </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox"  name="declaration_sum" onclick="return false" value="true" id="declaration_sum" class="inp-cbx"  checked  style="display: none">
                                        <label for="declaration_sum" class="cbx">
                                        <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Declaration of sum insured and basis of settlement: Total loss claims will be settled on the current market value of the vehicle on the day of accident and insured should submit 3 valuation report for consideration of loss surveyor</label>
                                </div>
                            </div>
                         </div>
                         <div class="col-md-6">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox"  name="salvage" onclick="return false" value="true" id="salvage" class="inp-cbx" checked  style="display: none">
                                            <label for="salvage" class="cbx">
                                            <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                            </span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">Salvage: In case of total loss Insurer will give the option to the Insured to purchase the salvage based on the amount of the highest bid obtained by the Insurer</label>
                                    </div>
                                </div>
                             </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox"  name="total_loss" onclick="return false" value="true" id="total_loss" class="inp-cbx"  checked  style="display: none">
                                        <label for="total_loss" class="cbx">
                                        <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Total Loss:An equipment will be considered as total loss (destroyed) in case the repair cost is 50% or more than the NRV of the equipment (considered as constructive total loss)</label>
                                </div>
                            </div>
                         </div>
                         <div class="col-md-6">
                                <div class="form_group">
                                    <div class="form_group">
                                        <label class="form_label" style="min-height: 40px">Profit Sharing<span>*</span></label>
                                        <div class="enter_data">
                                            <input class="form_input" placeholder="" name="profit_share" id="profit_share"  type="text" @if(isset($pipeline_details['formData']['profitShare']) && 
                                            $pipeline_details['formData']['profitShare']!='') value="{{$pipeline_details['formData']['profitShare']}}" @endif>
                                        </div>
                                    </div>
                                </div>
                         </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="form_group">
                                    <label class="form_label" style="min-height: 40px">Claims procedure: Existing claim procedure attached and should form the framework for renewal period<span>*</span></label>
                                    <div class="enter_data">
                                        <input class="form_input" placeholder="" name="claim_pro" id="claim_pro"  type="text" @if(isset($pipeline_details['formData']['claimPro']) && 
                                        $pipeline_details['formData']['claimPro']!='') value="{{$pipeline_details['formData']['claimPro']}}" @endif>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                                <div class="form_group">
                                    <div class="form_group">
                                        <label class="form_label" style="min-height: 40px">Waiver of subrogation against principal<span>*</span></label>
                                        <div class="enter_data">
                                            <input class="form_input" placeholder="" name="waiver" id="waiver"  type="text" @if(isset($pipeline_details['formData']['waiver']) && 
                                            $pipeline_details['formData']['waiver']!='') value="{{$pipeline_details['formData']['waiver']}}" @endif>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="row">
                            <div class="col-md-4">
                                <div class="form_group">
                                    <label class="form_label bold">Rate required (in %)<span>*</span></label>
                                    <input class="form_input number" name="rate"  value="@if(isset($pipeline_details['formData']['rate']) && $pipeline_details['formData']['rate'] != ''){{number_format($pipeline_details['formData']['rate'],2)}}@endif">        
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <label class="form_label bold">Premium Required (in %)<span>*</span></label>
                                    <input class="form_input number" name="premium"  value="@if(isset($pipeline_details['formData']['premium']) && $pipeline_details['formData']['premium'] != ''){{number_format($pipeline_details['formData']['premium'],2)}}@endif">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <label class="form_label bold">Payment Terms<span>*</span></label>
                                    <input class="form_input" name="pay_term"  value="@if(isset($pipeline_details['formData']['payTerm']) && $pipeline_details['formData']['payTerm'] != ''){{$pipeline_details['formData']['payTerm']}}@endif">
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
<!-- Custom Select -->
<script src="{{URL::asset('js/main/custom-select.js')}}"></script>

<!-- Bootstrap Select -->
<script src="{{URL::asset('js/main/bootstrap-select.js')}}"></script>

<!-- Date Picker -->
<script src="{{URL::asset('js/main/bootstrap-datetimepicker.js')}}"></script>

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
                                //  auth_repair   : {
                                //     required: true
                                //  },
                                 agency_repair: {
                                     required: true
                                 },
                                 indemnity_principal: {
                                     required: true
                                 },
                                 profit_share: {
                                     required: true
                                 },
                                 claim_pro: {
                                     required: true
                                 },
                                 waiver: {
                                     required: true
                                 },
                                
                                 rate: {
                                    required: true,
                                     number:true,
                                     max:100
                                 },
                                 premium: {
                                    required: true,
                                     number:true,
                                     max:100
                                 },
                                 pay_term: {
                                    required: true
                                 }
                             },
                             messages: {
                                 
                                //  auth_repair: "Please enter authorised repair limit.",
                                 agency_repair: "Please enter agency repair.",
                                 indemnity_principal: "Please enter indemnity to principal.",
                                 profit_share: "Please enter profit sharing.",
                                 claim_pro: "Please enter claims procedure.",
                                 waiver: "Please enter waiver of subrogation against principal.",
                                 rate: "Please enter rate in %.",
                                 premium: "Please enter premium in %",
                                 pay_term: "Please enter payment terms."
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
                                    url: '{{url('contractor-plant/eslip-save')}}',
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
                                    url: '{{url('contractor-plant/insurance-company-save')}}',
                                    data: form_data,
                                    processData: false,
                                    contentType: false,
                                    success: function (result) {
                                        if (result.success== 'success') {
                                            $("#send_btn").attr( "disabled", false );
                                            window.location.href = '{{url('contractor-plant/e-quotation')}}'+'/'+result.id;
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
                                    url: '{{url('contractor-plant/eslip-save')}}',
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


