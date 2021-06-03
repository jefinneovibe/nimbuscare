
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
    <form id="e-slip-form" name="e-slip-form" enctype="multipart/form-data">
        {{csrf_field()}}
        <input type="hidden" value="{{@$worktype_id}}" name="eslip_id" id="eslip_id">
        <input type="hidden" id="pipeline_id" name="pipeline_id" value="{{$worktype_id}}">
    <div class="card_header clearfix">
        <h3 class="title" style="margin-bottom: 8px;">Employers Liability</h3>
    </div>
    <div class="card_content">
        <div class="edit_sec clearfix">

            <!-- Steps -->
            <section>
                <nav>
                    <ol class="cd-breadcrumb triangle">
                        @if($pipeline_details['status']['status'] == 'E-slip')
                            <li class="complete"><a href="{{ url('employer/e-questionnaire/'.$worktype_id) }}"><em>E-Questionnaire</em></a></li>
                            <li class="current"><em>E-Slip</em></li>
                            <li><em>E-Quotation</em></li>
                            <li><em>E-Comparison</em></li>
                            <li><em>Quote Amendment</em></li>
                            <li><em>Approved E Quote</em></li>
                            {{--<li><em>Issuance</em></li>--}}
                        @elseif($pipeline_details['status']['status'] == 'E-quotation')
                            <li class="complete"><a href="{{ url('employer/e-questionnaire/'.$worktype_id) }}"><em>E-Questionnaire</em></a></li>
                            <li class="active_arrow"><a href="{{url('employer/e-slip/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>
                            <li class="current"><a href="{{url('employer/e-quotation/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                            <li><em>E-Comparison</em></li>
                            <li><em>Quote Amendment</em></li>
                            <li><em>Approved E Quote</em></li>
                            {{--<li><em>Issuance</em></li>--}}
                        @elseif($pipeline_details['status']['status'] == 'E-comparison')
                            <li class="complete"><a href="{{ url('employer/e-questionnaire/'.$worktype_id) }}"><em>E-Questionnaire</em></a></li>
                            <li class="active_arrow"><a href="{{url('employer/e-slip/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>
                            <li class="complete"><a href="{{url('employer/e-quotation/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                            <li class="current"><a href="{{url('employer/e-comparison/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                            <li><em>Quote Amendment</em></li>
                            <li><em>Approved E Quote</em></li>
                            {{--<li><em>Issuance</em></li>--}}
                        @elseif($pipeline_details['status']['status'] == 'Quote Amendment')
                            <li class="complete"><a href="{{ url('employer/e-questionnaire/'.$worktype_id) }}"><em>E-Questionnaire</em></a></li>
                            <li class="active_arrow"><a href="{{url('employer/e-slip/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>
                            <li class="complete"><a href="{{url('employer/e-quotation/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                            <li class = complete><a href="{{url('employer/e-comparison/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                            <li class = current><a href="{{url('employer/quot-amendment/'.$worktype_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>
                            <li><em>Approved E Quote</em></li>
                            {{--<li><em>Issuance</em></li>--}}
                        @elseif($pipeline_details['status']['status'] == 'Approved E Quote')
                            <li class="complete"><a href="{{ url('employer/e-questionnaire/'.$worktype_id) }}"><em>E-Questionnaire</em></a></li>
                            <li class="active_arrow"><a href="{{url('employer/e-slip/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>
                            <li class="complete"><a href="{{url('employer/e-quotation/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                            <li class = complete><a href="{{url('employer/e-comparison/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                            <li class = complete><a href="{{url('employer/quot-amendment/'.$worktype_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>
                            <li class = "current"><a href="{{url('employer/approved-quot/'.$worktype_id)}}" style="color: #ffffff;"><em>Approved E Quote</em></a></li>
                            {{--<li><em>Issuance</em></li>--}}
                        @elseif($pipeline_details['status']['status'] == 'Quote Amendment-E-comparison' || $pipeline_details['status']['status'] == 'Quote Amendment-E-quotation' || $pipeline_details['status']['status'] == 'Quote Amendment-E-slip')
                            <li class="complete"><a href="{{ url('employer/e-questionnaire/'.$worktype_id) }}"><em>E-Questionnaire</em></a></li>
                            <li class="active_arrow"><a href="{{url('employer/e-slip/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>
                            <li class="complete"><a href="{{url('employer/e-quotation/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                            <li class = complete><a href="{{url('employer/e-comparison/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                            <li class = current><a href="{{url('employer/quot-amendment/'.$worktype_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>
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
                            <li class="complete"><a href="{{ url('employer/e-questionnaire/'.$worktype_id) }}"><em>E-Questionnaire</em></a></li>
                            <li class="current"><a href="{{url('employer/e-slip/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>
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
                        <label class="form_label">Insured <span style="visibility:hidden">*</span></label>
                        <div class="enter_data">
                            <p>{{ucwords(@$pipeline_details['formData']['firstName'])}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form_group">
                        <label class="form_label">Cover <span style="visibility:hidden">*</span></label>
                        <div class="row">
                            <div class="col-md-12">
                                    <span class="note">
                                        <label>
                                            <b>Employer’s Liability</b><br>
                                            Insured’s legal liability to their employees as per Common Law and/or Shariah law in respect of death/ bodily injury arising out of and in the course of their employment
                                        </label>
                                    </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                {{--<div class="col-md-6">--}}
                    {{--<div class="form_group">--}}
                        {{--<label class="form_label">Law <span>*</span></label>--}}
                        {{--<div class="enter_data">--}}
                            {{--<p>UAE Federal Labour Law No. 8 Of 1980 and subsequent amendments</p>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                <div class="col-md-12">
                    <div class="form_group">
                        <label class="form_label">Business Activity <span style="visibility:hidden">*</span></label>
                        <div class="enter_data">
                            <p>{{@$pipeline_details['formData']['businessType']}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form_group">
                        <label class="form_label bold">Estimated Annual Wages <span style="visibility:hidden">*</span></label>
                        <div class="enter_data border_none">
                            <table class="fill_data">
                                <tr @if(!@$pipeline_details['formData']['employeeDetails']['adminAnnualWages']) style="display: none" @endif>
                                    <td valign="top" class="name">Admin : <span>@if(@$pipeline_details['formData']['employeeDetails']['adminAnnualWages']!='' ){{number_format(@$pipeline_details['formData']['employeeDetails']['adminAnnualWages'],2) ?:' -- '}}@endif</span></td>
                                </tr>
                                <tr @if(!@$pipeline_details['formData']['employeeDetails']['nonAdminAnnualWages']) style="display: none" @endif>
                                    <td valign="top" class="name">Non-Admin : <span>@if(@$pipeline_details['formData']['employeeDetails']['nonAdminAnnualWages']!=''){{number_format($pipeline_details['formData']['employeeDetails']['nonAdminAnnualWages'],2) ?:' -- '}}@endif</span></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form_group">
                        <label class="form_label bold">Number of employees <span style="visibility:hidden">*</span></label>
                        <div class="enter_data border_none">
                            <table class="fill_data">
                                <tr @if(!@$pipeline_details['formData']['employeeDetails']['adminCount']) style="display: none" @endif>
                                    <td valign="top" class="name">Admin : <span>{{@$pipeline_details['formData']['employeeDetails']['adminCount'] ?:' -- '}}</span></td>
                                </tr>
                                <tr @if(!@$pipeline_details['formData']['employeeDetails']['nonAdminCount']) style="display: none" @endif>
                                    <td valign="top" class="name">Non-Admin :{{@$pipeline_details['formData']['employeeDetails']['nonAdminCount'] ?:' -- '}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
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
                <div class="col-md-6">
                    <div class="form_group">
                        <label class="form_label bold">Policy period <span style="visibility:hidden">*</span></label>
                        <div class="enter_data border_none">
                            <table class="fill_data">
                                <tr>
                                    <td valign="top" class="name">From : <span>{{@$pipeline_details['formData']['policyPeriod']['policyFrom'] ?:' -- '}}</span></td>
                                </tr>
                                <tr>
                                    <td valign="top" class="name">To : <span>{{@$pipeline_details['formData']['policyPeriod']['policyTo'] ?:' -- '}}</span></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6" @if(!@$pipeline_details['formData']['hiredWorkersDetails']['noOfLabourers']) style="display: none" @endif>
                    <div class="form_group">
                        <label class="form_label bold">
                            cover for hired workers or casual labours?
                        </label>
                        <div class="enter_data border_none">
                            <table class="fill_data">
                                <tr>
                                    <td class="name" valign="top">No of labourers : <span>{{@$pipeline_details['formData']['hiredWorkersDetails']['noOfLabourers'] ?:' -- '}}</span></td>
                                </tr>
                                <tr>
                                    <td class="name" valign="top">Estimated Annual wages (AED) : <span>@if(@$pipeline_details['formData']['hiredWorkersDetails']['annualWages']!=''){{number_format(@$pipeline_details['formData']['hiredWorkersDetails']['annualWages'],2) ?:' -- '}}@endif</span></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6" @if(!@$pipeline_details['formData']['offShoreEmployeeDetails']['noOfLabourers']) style="display: none" @endif>
                    <div class="form_group">
                        <label class="form_label bold">
                            Cover for offshore employees?
                        </label>
                        <div class="enter_data border_none">
                            <table class="fill_data">
                                <tr>
                                    <td class="name" valign="top">No of labourers : <span>{{@$pipeline_details['formData']['offShoreEmployeeDetails']['noOfLabourers'] ?:' -- '}}</span></td>
                                </tr>
                                <tr>
                                    <td class="name" valign="top">Estimated Annual wages (AED) : <span>@if(@$pipeline_details['formData']['offShoreEmployeeDetails']['annualWages']!=''){{number_format(@$pipeline_details['formData']['offShoreEmployeeDetails']['annualWages'],2) ?:' -- '}}@endif</span></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form_group">
                          
                                            <label class="form_label bold">
                                                    Employer’s extended liability under Common Law/Shariah Law (In AED)
                                                    <span>*</span></label>
                                        <input class="form_input number" id="extended_liability" name="extended_liability" type="text" value="@if(@$pipeline_details['formData']['extendedLiability']!=''){{number_format(trim(@$pipeline_details['formData']['extendedLiability']),2)}}@endif" onblur="dropDownValidation()">
                                   


                        {{-- <label class="form_label bold">Employer’s extended liability under Common Law/Shariah Law (In AED) <span>*</span></label>
                        <div class="custom_select">
                            <select class="form_input" name="extended_liability" id="extended_liability" onchange="dropDownValidation();">
                                <option value="" selected>Select Extended Liability</option>
                                <option value="1M" @if(@$pipeline_details['formData']['extendedLiability'] == "1M") selected @endif>1M</option>
                                <option value="2M" @if(@$pipeline_details['formData']['extendedLiability'] == "2M") selected @endif>2M</option>
                                <option value="3M" @if(@$pipeline_details['formData']['extendedLiability'] == "3M") selected @endif>3M</option>
                                <option value="4M" @if(@$pipeline_details['formData']['extendedLiability'] == "4M") selected @endif>4M</option>
                                <option value="5M" @if(@$pipeline_details['formData']['extendedLiability'] == "5M") selected @endif>5M</option>
                                <option value="7.5M" @if(@$pipeline_details['formData']['extendedLiability'] =="7.5M") selected @endif>7.5M</option>
                                <option value="10M" @if(@$pipeline_details['formData']['extendedLiability'] == "10M") selected @endif>10M</option>
                                <option value="25M" @if(@$pipeline_details['formData']['extendedLiability'] == "25M") selected @endif>25M</option>
                            </select>
                        </div> --}}
                    </div>
                </div>
            </div>
            
            <div class="row">
                
                    @if(@$pipeline_details['formData']['businessType'] == 'Bridges & tunnels' ||@$pipeline_details['formData']['businessType'] == 'Builders/ general contractors' ||
                    @$pipeline_details['formData']['businessType'] == 'Infrastructure' ||  @$pipeline_details['formData']['businessType'] == 'Rail roads & related infrastructure' )
                        <div class="col-md-6">
                            <div class="form_group">
                                <label class="form_label bold">
                                    Waiver of subrogation<span>*</span>
                                </label>
                                <div class="custom_select">
                                    <select class="form_input" name="waiverOfSubrogation" id="waiverOfSubrogation" onchange="dropDownValidation();">
                                        <option value=""  selected>Select</option>
                                        <option value="yes" @if(isset($pipeline_details['formData']['waiverOfSubrogation']) &&  @$pipeline_details['formData']['waiverOfSubrogation'] == true)
                                        @if(@$pipeline_details['formData']['waiverOfSubrogation'] == 1)) selected @endif @endif>Yes</option>
                                        <option value="no" @if(isset($pipeline_details['formData']['waiverOfSubrogation']) && @$pipeline_details['formData']['waiverOfSubrogation'] == false) selected @endif >No</option>
                                    </select>
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
                                <input type="checkbox"  @if(@$pipeline_details['formData']['empToEmpLiability']) @if(@$pipeline_details['formData']['empToEmpLiability'] != false) checked @endif @else checked @endif  name="empToEmpLiability" value="true" id="empToEmpLiability" class="inp-cbx" style="display: none"onclick="return false">
                                <label for="empToEmpLiability" class="cbx">
                                <span>
                                    <svg width="10px" height="8px" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                    </svg>
                                </span>
                                </label>
                            </div>
                            <label class="form_label bold">
                                Employee to employee liability
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form_group">
                        <div class="flex_sec">
                            <div class="custom_checkbox">
                                <input type="checkbox"  @if(@$pipeline_details['formData']['emergencyEvacuation']) @if(@$pipeline_details['formData']['emergencyEvacuation'] != false) checked @endif @else checked @endif  name="emergencyEvacuation" value="true" id="emergencyEvacuation" class="inp-cbx" style="display: none"onclick="return false">
                                <label for="emergencyEvacuation" class="cbx">
                                <span>
                                    <svg width="10px" height="8px" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                    </svg>
                                </span>
                                </label>
                            </div>
                            <label class="form_label bold">
                                Emergency evacuation following work related accident
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
                                <input type="checkbox"  @if(@$pipeline_details['formData']['errorsOmissions']) @if(@$pipeline_details['formData']['errorsOmissions'] != false) checked @endif @else checked @endif  name="errorsOmissions" value="true" id="errorsOmissions" class="inp-cbx" style="display: none"onclick="return false">
                                <label for="errorsOmissions" class="cbx">
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
                <div class="col-md-6">
                    <div class="form_group">
                        <div class="flex_sec">
                        <div class="custom_checkbox">
                            <input type="checkbox"  @if(@$pipeline_details['formData']['crossLiability']) @if(@$pipeline_details['formData']['crossLiability'] != false) checked @endif @else checked @endif  name="crossLiability" value="true" id="crossLiability" class="inp-cbx" style="display: none"onclick="return false">
                            <label for="crossLiability" class="cbx">
                            <span>
                                <svg width="10px" height="8px" viewBox="0 0 12 10">
                                    <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                </svg>
                            </span>
                            </label>
                        </div>
                            <label class="form_label bold">
                            Cross Liability
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
                                <input type="checkbox" @if(@$pipeline_details['insuraceCompanyList']) @if(@$pipeline_details['formData']['automaticClause'] != false) checked @endif @else checked @endif  name="automaticClause" value="true" id="automaticClause" class="inp-cbx" style="display: none"onclick="return false">
                                <label for="automaticClause" class="cbx">
                                <span>
                                    <svg width="10px" height="8px" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                    </svg>
                                </span>
                                </label>
                            </div>
                            <label class="form_label bold">Automatic addition & deletion Clause</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                        <div class="form_group">
                            <div class="flex_sec">
                                <div class="custom_checkbox">
                                    <input type="checkbox" @if(@$pipeline_details['insuraceCompanyList']) @if(@$pipeline_details['formData']['cancellationClause'] != false) checked @endif @else checked @endif name="cancellationClause" value="true" id="cancellationClause" class="inp-cbx" style="display: none" onclick="return false">
                                    <label for="cancellationClause" class="cbx">
                                    <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                    </span>
                                    </label>
                                </div>
                                <label class="form_label bold">
                                    Cancellation clause-30 days by either side on  pro-rata
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
                                <input type="checkbox"  @if(@$pipeline_details['insuraceCompanyList']) @if(@$pipeline_details['formData']['lossNotification'] != false) checked @endif @else checked @endif   name="lossNotification" value="true" id="lossNotification" class="inp-cbx" style="display: none"onclick="return false">
                                <label for="lossNotification" class="cbx">
                                <span>
                                    <svg width="10px" height="8px" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                    </svg>
                                </span>
                                </label>
                            </div>
                            <label class="form_label bold">Loss Notification – ‘as soon as reasonably practicable’</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form_group">
                        <div class="flex_sec">
                            <div class="custom_checkbox">
                                <input type="checkbox"  @if(@$pipeline_details['insuraceCompanyList']) @if(@$pipeline_details['formData']['primaryInsuranceClause'] != false) checked @endif @else checked @endif name="primaryInsuranceClause" value="true" id="primaryInsuranceClause" class="inp-cbx" style="display: none"onclick="return false">
                                <label for="primaryInsuranceClause" class="cbx">
                                <span>
                                    <svg width="10px" height="8px" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                    </svg>
                                </span>
                                </label>
                            </div>
                            <label class="form_label bold">Primary insurance clause</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form_group">
                        <div class="flex_sec">
                            <div class="custom_checkbox">
                                <input type="checkbox"  @if(@$pipeline_details['insuraceCompanyList']) @if(@$pipeline_details['formData']['travelCover'] != false) checked @endif @else checked @endif  name="travelCover" value="true" id="travelCover" class="inp-cbx" style="display: none"onclick="return false">
                                <label for="travelCover" class="cbx">
                                <span>
                                    <svg width="10px" height="8px" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                    </svg>
                                </span>
                                </label>
                            </div>
                            <label class="form_label bold">Travelling to and from workplace</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form_group">
                        <div class="flex_sec">
                            <div class="custom_checkbox">
                                <input type="checkbox" @if(@$pipeline_details['insuraceCompanyList']) @if(@$pipeline_details['formData']['riotCover'] != false) checked @endif @else checked @endif name="riotCover" value="true" id="riotCover" class="inp-cbx" style="display: none"onclick="return false">
                                <label for="riotCover" class="cbx">
                                <span>
                                    <svg width="10px" height="8px" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                    </svg>
                                </span>
                                </label>
                            </div>
                            <label class="form_label bold">
                                Riot, Strikes, civil commotion and Passive war risk
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
                                <input type="checkbox" @if(@$pipeline_details['insuraceCompanyList']) @if(@$pipeline_details['formData']['brokersClaimClause'] != false) checked @endif @else checked @endif  name="brokersClaimClause" value="true" id="brokersClaimClause" class="inp-cbx" style="display: none" onclick="return false">
                                <label for="brokersClaimClause" class="cbx">
                                <span>
                                    <svg width="10px" height="8px" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                    </svg>
                                </span>
                                </label>
                            </div>
                            <label class="form_label bold">
                                Brokers Claim Handling Clause : A loss notification received by the Insurance Broker will be deemed
                                as a loss notification to Insurer. All communications flowing between the Insurer, Insured and the
                                appointed Loss Surveyor should be channelized through the Broker, unless there is any unavoidable
                                reasons compelling direct communications between the parties
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                @if(@$pipeline_details['formData']['businessType'] == 'Bridges & tunnels' ||@$pipeline_details['formData']['businessType'] == 'Builders/ general contractors' ||
                @$pipeline_details['formData']['businessType'] == 'Infrastructure' ||  @$pipeline_details['formData']['businessType'] == 'Rail roads & related infrastructure' )
                    <div class="col-md-6">
                        <div class="form_group">
                            <div class="flex_sec">
                                <div class="custom_checkbox">
                                    <input type="checkbox"
                                            @if(@$pipeline_details['insuraceCompanyList'])
                                            @if(@$pipeline_details['formData']['indemnityToPrincipal'] != false)
                                            checked
                                            @endif
                                            @if(isset($pipeline_details['formData']['indemnityToPrincipal'])==false)
                                            checked
                                            @endif
                                            @else
                                            checked
                                            @endif
                                            name="indemnityToPrincipal" value="true" id="indemnityToPrincipal" class="inp-cbx" style="display: none"onclick="return false">
                                    <label for="indemnityToPrincipal" class="cbx">
                                <span>
                                    <svg width="10px" height="8px" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                    </svg>
                                </span>
                                    </label>
                                </div>
                                <label class="form_label bold">Indemnity to principal  </label>
                            </div>
                        </div>
                    </div>
                @endif
                    @if(@$pipeline_details['formData']['hiredWorkersDetails']['hasHiredWorkers']==true)
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" checked  name="hiredCheck" value="true" id="hiredCheck" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="hiredCheck" class="cbx">
                                <span>
                                    <svg width="10px" height="8px" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                    </svg>
                                </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">
                                        Employment clause
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endif
        
            </div>
        
            <div class="row">
                <div class="col-md-12">
                    <div class="form_group">
                        <label class="form_label bold">Claims History </label>
                        <table class="table table-bordered custom_table">
                            <thead>
                            <tr>
                                <th>Year</th>
                                <th>Type</th>
                                <th>Description</th>
                                <th>Minor Injury Claim Amount</th>
                                <th>Death Claim Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Year 1 <i data-toggle="tooltip" data-placement="bottom" title="Most Resent" data-container="body" class="material-icons info_icon">info</i></td>
                                <td>Admin</td>
                                <td>@if(@$pipeline_details['formData']['claimsHistory'][0]['description'])<textarea class="form_input" name="name" readonly> @if(@$pipeline_details['formData']['claimsHistory'][0]['description']!=''){{@$pipeline_details['formData']['claimsHistory'][0]['description']}} @endif @else -- @endif</textarea></td>
                                {{-- <td>@if(@$pipeline_details['formData']['claimsHistory'][0]['description'])<input class="form_input" name="name" readonly value="{{@$pipeline_details['formData']['claimsHistory'][0]['description'] ?:' -- '}}">@endif</td> --}}
                                <td>@if(@$pipeline_details['formData']['claimsHistory'][0]['minorInjuryClaimAmount'])<input class="form_input" name="name" readonly  value="@if(@$pipeline_details['formData']['claimsHistory'][0]['minorInjuryClaimAmount']!=''){{number_format(@$pipeline_details['formData']['claimsHistory'][0]['minorInjuryClaimAmount'],2)}} @endif">@else --@endif</td>
                                <td>@if(@$pipeline_details['formData']['claimsHistory'][0]['deathClaimAmount'])<input class="form_input" name="name" readonly  value="@if(@$pipeline_details['formData']['claimsHistory'][0]['deathClaimAmount']!=''){{number_format(@$pipeline_details['formData']['claimsHistory'][0]['deathClaimAmount'],2)}}@endif">@else --@endif</td>
                            </tr>
                            <tr>
                                <td>Year 1 <i data-toggle="tooltip" data-placement="bottom" title="Most Resent" data-container="body" class="material-icons info_icon">info</i></td>
                                <td>Non Admin</td>
                                <td>@if(@$pipeline_details['formData']['claimsHistory'][1]['description'])<textarea class="form_input" name="name" readonly> @if(@$pipeline_details['formData']['claimsHistory'][1]['description']!=''){{@$pipeline_details['formData']['claimsHistory'][1]['description']}} @endif @else -- @endif</textarea></td>
                                {{-- <td>@if(@$pipeline_details['formData']['claimsHistory'][1]['description'])<input class="form_input" name="name" readonly value="{{@$pipeline_details['formData']['claimsHistory'][1]['description'] ?:' -- '}}">@endif</td> --}}
                                <td>@if(@$pipeline_details['formData']['claimsHistory'][1]['minorInjuryClaimAmount'])<input class="form_input" name="name" readonly  value="@if(@$pipeline_details['formData']['claimsHistory'][1]['minorInjuryClaimAmount']!=''){{number_format(@$pipeline_details['formData']['claimsHistory'][1]['minorInjuryClaimAmount'],2)}}@endif">@else --@endif</td>
                                <td>@if(@$pipeline_details['formData']['claimsHistory'][1]['deathClaimAmount'])<input class="form_input" name="name" readonly value="@if(@$pipeline_details['formData']['claimsHistory'][1]['deathClaimAmount']!=''){{number_format(@$pipeline_details['formData']['claimsHistory'][1]['deathClaimAmount'],2)}}@endif">@else --@endif</td>
                            </tr>
                            <tr>
                                <td>Year 2</td>
                                <td>Admin</td>
                                <td>@if(@$pipeline_details['formData']['claimsHistory'][2]['description'])<textarea class="form_input" name="name" readonly> @if(@$pipeline_details['formData']['claimsHistory'][2]['description']!=''){{@$pipeline_details['formData']['claimsHistory'][2]['description']}} @endif @else -- @endif</textarea></td>
                                {{-- <td>@if(@$pipeline_details['formData']['claimsHistory'][2]['description'])<input class="form_input" name="name" readonly  value="{{@$pipeline_details['formData']['claimsHistory'][2]['description'] ?:' -- '}}">@endif</td> --}}
                                <td>@if(@$pipeline_details['formData']['claimsHistory'][2]['minorInjuryClaimAmount'])<input class="form_input" name="name" readonly  value="@if(@$pipeline_details['formData']['claimsHistory'][2]['minorInjuryClaimAmount']!=''){{number_format(@$pipeline_details['formData']['claimsHistory'][2]['minorInjuryClaimAmount'],2)}}@endif">@else --@endif</td>
                                <td>@if(@$pipeline_details['formData']['claimsHistory'][2]['deathClaimAmount'])<input class="form_input" name="name" readonly  value="@if(@$pipeline_details['formData']['claimsHistory'][2]['deathClaimAmount']!=''){{number_format(@$pipeline_details['formData']['claimsHistory'][2]['deathClaimAmount'],2)}}@endif">@else --@endif</td>
                            </tr>
                            <tr>
                                <td>Year 2</td>
                                <td>Non Admin</td>
                                <td>@if(@$pipeline_details['formData']['claimsHistory'][3]['description'])<textarea class="form_input" name="name" readonly> @if(@$pipeline_details['formData']['claimsHistory'][3]['description']!=''){{@$pipeline_details['formData']['claimsHistory'][3]['description']}} @endif @else -- @endif</textarea></td>
                                {{-- <td>@if(@$pipeline_details['formData']['claimsHistory'][3]['description'])<input class="form_input" name="name" readonly  value="{{@$pipeline_details['formData']['claimsHistory'][3]['description'] ?:' -- '}}">@endif</td> --}}
                                <td>@if(@$pipeline_details['formData']['claimsHistory'][3]['minorInjuryClaimAmount'])<input class="form_input" name="name" readonly  value="@if(@$pipeline_details['formData']['claimsHistory'][3]['minorInjuryClaimAmount']!=''){{number_format(@$pipeline_details['formData']['claimsHistory'][3]['minorInjuryClaimAmount'],2)}}@endif">@else --@endif</td>
                                <td>@if(@$pipeline_details['formData']['claimsHistory'][3]['deathClaimAmount'])<input class="form_input" name="name" readonly value="@if(@$pipeline_details['formData']['claimsHistory'][3]['deathClaimAmount']!=''){{number_format(@$pipeline_details['formData']['claimsHistory'][3]['deathClaimAmount'],2)}}@endif">@else --@endif</td>
                            </tr>
                            <tr>
                                <td>Year 3</td>
                                <td>Admin</td>
                                <td>@if(@$pipeline_details['formData']['claimsHistory'][4]['description'])<textarea class="form_input" name="name" readonly> @if(@$pipeline_details['formData']['claimsHistory'][4]['description']!=''){{@$pipeline_details['formData']['claimsHistory'][4]['description']}} @endif @else -- @endif</textarea></td>
                                {{-- <td>@if(@$pipeline_details['formData']['claimsHistory'][4]['description'])<input class="form_input" name="name" readonly  value="{{@$pipeline_details['formData']['claimsHistory'][4]['description'] ?:' -- '}}">@endif</td> --}}
                                <td>@if(@$pipeline_details['formData']['claimsHistory'][4]['minorInjuryClaimAmount'])<input class="form_input" name="name" readonly value="@if(@$pipeline_details['formData']['claimsHistory'][4]['minorInjuryClaimAmount']!=''){{number_format(@$pipeline_details['formData']['claimsHistory'][4]['minorInjuryClaimAmount'],2)}}@endif">@else --@endif</td>
                                <td>@if(@$pipeline_details['formData']['claimsHistory'][4]['deathClaimAmount'])<input class="form_input" name="name" readonly value="@if(@$pipeline_details['formData']['claimsHistory'][4]['deathClaimAmount']!=''){{number_format(@$pipeline_details['formData']['claimsHistory'][4]['deathClaimAmount'],2)}}@endif">@else --@endif</td>
                            </tr>
                            <tr>
                                <td>Year 3</td>
                                <td>Non Admin</td>
                                <td>@if(@$pipeline_details['formData']['claimsHistory'][5]['description'])<textarea class="form_input" name="name" readonly> @if(@$pipeline_details['formData']['claimsHistory'][5]['description']!=''){{@$pipeline_details['formData']['claimsHistory'][5]['description']}} @endif @else -- @endif</textarea></td>
                                {{-- <td>@if(@$pipeline_details['formData']['claimsHistory'][5]['description'])<input class="form_input" name="name" readonly value="{{@$pipeline_details['formData']['claimsHistory'][5]['description'] ?:' -- '}}">@endif</td> --}}
                                <td>@if(@$pipeline_details['formData']['claimsHistory'][5]['minorInjuryClaimAmount'])<input class="form_input" name="name" readonly  value="@if(@$pipeline_details['formData']['claimsHistory'][5]['minorInjuryClaimAmount']!=''){{number_format(@$pipeline_details['formData']['claimsHistory'][5]['minorInjuryClaimAmount'],2)}}@endif">@else --@endif</td>
                                <td>@if(@$pipeline_details['formData']['claimsHistory'][5]['deathClaimAmount'])<input class="form_input" name="name" readonly  value="@if(@$pipeline_details['formData']['claimsHistory'][5]['deathClaimAmount']!=''){{number_format(@$pipeline_details['formData']['claimsHistory'][5]['deathClaimAmount'],2)}}@endif">@else --@endif</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form_group">
                        <label class="form_label bold">
                                Are you looking for a combined rate or a seperate rate?
                            <span>*</span></label>
                        <div class="custom_select">
                            <select class="form_input" name="sepOrCom" id="sepOrCom" onchange="dropDownValidation();">
                                <option value="" selected>Select</option>
                                <option value="yes"  @if(isset($pipeline_details['formData']['sepOrCom']) && $pipeline_details['formData']['sepOrCom']==true) selected @endif >Seperate Rate</option>
                                <option value="no"   @if(isset($pipeline_details['formData']['sepOrCom']) && $pipeline_details['formData']['sepOrCom']==false) selected @endif >Combined Rate </option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div @if(isset($pipeline_details['formData']['sepOrCom']) && $pipeline_details['formData']['sepOrCom']==true) style="display:block" @else style="display:none" @endif id="row_seperate">
                <div class="row">
                    <div class="col-md-3">
                        <input type="hidden" id="admin">
                        <div class="form_group">
                            <label class="form_label bold">Rate required (Admin) (in %) <span>*</span></label>
                            <input class="form_input number" name="rateRequiredAdmin" type="text" value="@if(isset($pipeline_details['formData']['rateRequiredAdmin']) && $pipeline_details['formData']['rateRequiredAdmin']!=''){{number_format(@$pipeline_details['formData']['rateRequiredAdmin'],2)}}@endif" >
                            {{--<label class="error" id="rateRequiredAdmin-error" style="display: none">Please enter rate in %</label>--}}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <input type="hidden" id="nonadmin">
                        <div class="form_group">
                            <label class="form_label bold">Rate required (Non-Admin) (in %)<span>*</span></label>
                            <input class="form_input number" name="rateRequiredNonAdmin" type="text"  value="@if(isset($pipeline_details['formData']['rateRequiredNonAdmin']) && $pipeline_details['formData']['rateRequiredNonAdmin']){{number_format(@$pipeline_details['formData']['rateRequiredNonAdmin'],2)}}@endif">
                            {{--<label class="error" id="rateRequiredNonAdmin-error" style="display: none">Please enter rate in %</label>--}}

                        </div>
                    </div>
                </div>
            </div>
            <div @if(isset($pipeline_details['formData']['sepOrCom']) && $pipeline_details['formData']['sepOrCom']==false) style="display:block" @else style="display:none" @endif id="row_combined">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form_group">
                            <label class="form_label bold">Combined Rate (in %)<span>*</span></label>
                            <input class="form_input number" name="combinedRate" type="text"  value="@if(isset($pipeline_details['formData']['combinedRate']) && $pipeline_details['formData']['combinedRate']!=''){{number_format(@$pipeline_details['formData']['combinedRate'],2)}}@endif">
                            <label class="error" id="CombinedRate-error" style="display: none">Please enter rate in %</label>

                        </div>
                    </div>
                </div>
            </div>
            <div class="row"> 
                <div class="col-md-6">
                    <div class="form_group">
                        <label class="form_label bold">Brokerage (in %) <span>*</span></label>
                        <input class="form_input number" name="brokerage" type="text"  value="@if(isset($pipeline_details['formData']['brokerage']) && $pipeline_details['formData']['brokerage']!=''){{number_format(@$pipeline_details['formData']['brokerage'],2)}}@endif" >
                        <label class="error" id="Brokerage-error" style="display: none">Please enter rate in %</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form_group">
                        <label class="form_label bold">Excess <span>*</span></label>
                        <input type="text" class="form_input number" value="@if(isset($pipeline_details['formData']['excess']) && $pipeline_details['formData']['excess']!=''){{number_format(@$pipeline_details['formData']['excess'],2)}}@endif" name="excess">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form_group">
                        <label class="form_label bold">Warranty <span style="visibility:hidden">*</span></label>
                        <textarea class="form_input" name="warranty">{{@$pipeline_details['formData']['warranty']}}</textarea>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form_group">
                        <label class="form_label bold">Exclusion <span style="visibility:hidden">*</span></label>
                        <textarea class="form_input" name="exclusion">{{@$pipeline_details['formData']['exclusion']}}</textarea>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form_group">
                        <label class="form_label bold">Special Condition <span style="visibility:hidden">*</span></label>
                        <textarea class="form_input" name="specialCondition">{{@$pipeline_details['formData']['specialCondition']}}</textarea>
                    </div>
                </div>
            </div>
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
        {{csrf_field()}}
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
                    <button class="btn btn-primary btn-link btn_cancel" type="button" onclick="popupHide()">Cancel</button>
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

<!-- Custom Select -->
<script src="{{URL::asset('js/main/custom-select.js')}}"></script>

<!-- Bootstrap Select -->
<script src="{{URL::asset('js/main/bootstrap-select.js')}}"></script>

<!-- Date Picker -->
<script src="{{URL::asset('js/main/bootstrap-datetimepicker.js')}}"></script>

<script>
// $("input.number").keyup(function(event){
//         // skip for arrow keys
//         if(event.which >= 37 && event.which <= 40){
//             event.preventDefault();
//         }
//         var $this = $(this);
//         var num = $this.val().replace(/,/gi, "");
//         var num2 = num.split(/(?=(?:\d{3})+$)/).join(",");
//         // console.log(num2);
//         // the following line has been simplified. Revision history contains original.
//         $this.val(num2);
//     });
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



$(function () {
    $(window).load(function() {
        $('#preLoader').fadeOut('slow');
        localStorage.clear();
    });
});
function validate(x,type) {
    var parts = x.split(".");
    if (typeof parts[1] == "string" && (parts[1].length == 0 || parts[1].length > 2))
    {
        if(type=='admin')
        {
            $("#rateRequiredAdmin-error").show();
        }else if(type=='non-admin')
        {
            $("#rateRequiredNonAdmin-error").show();
        }else if(type=='combined')
        {
            $("#CombinedRate-error").show();
        }else if(type=='brokerage')
        {
            $("#Brokerage-error").show();
        }
    }
    var n = parseFloat(x);
        if (isNaN(n))
    {
        if(type=='admin')
        {
            $("#rateRequiredAdmin-error").show();
        }else if(type=='non-admin')
        {
            $("#rateRequiredNonAdmin-error").show();
        }else if(type=='combined')
        {
            $("#CombinedRate-error").show();
        }else if(type=='brokerage')
        {
            $("#Brokerage-error").show();
        }
    }
    else if (n < 0 || n > 100)
    {
        if(type=='admin')
        {
            $("#rateRequiredAdmin-error").show();
        }else if(type=='non-admin')
        {
            $("#rateRequiredNonAdmin-error").show();
        }else if(type=='combined')
        {
            $("#CombinedRate-error").show();
        }else if(type=='brokerage')
        {
            $("#Brokerage-error").show();
        }
    }
    else{
            if(type=='admin')
            {
                $("#rateRequiredAdmin-error").hide();
            }else if(type=='non-admin')
            {
                $("#rateRequiredNonAdmin-error").hide();
            }else if(type=='combined')
            {
                $("#CombinedRate-error").hide();
            }else if(type=='brokerage')
            {
                $("#Brokerage-error").hide();
            }
        }
}
$(document).ready(function() {

    materialKit.initFormExtendedDatetimepickers();

    $("#opt1").click(function() {
        $("#existing_policy").show();
    });
    $("#opt2").click(function() {
        $("#existing_policy").hide();
    });

    $("#opt3").click(function() {
        $("#countries").hide();
    });
    $("#opt4").click(function() {
        $("#countries").show();
    });
});

jQuery.validator.addMethod("dropdown_required", function(value, element) {
    if(value!='') {
        return true;
    } else {
        return false;
    }
    // allow any non-whitespace characters as the host part
//        return this.optional( element ) || /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@(?:\S{1,63})$/.test( value );
}, 'Please select this field.');

//form validation
$('#e-slip-form').validate({
ignore: [],
    rules: {
    scale: {
        required: true
    },
    extended_liability: {
        required: true
    },
        medical_expenses: {
        required: true
    },
        repatriation_expenses: {
        required: true
    },
    HoursPAC: {
        dropdown_required: true
    },
    herniaCover: {
        dropdown_required: true
    },
    emergencyEvacuation: {
        dropdown_required: true
    },
        legalCost: {
            dropdown_required: true
    },
        empToEmpLiability: {
            dropdown_required: true
    },
    errorsOmissions: {
        dropdown_required: true
    },
    crossLiability: {
        dropdown_required: true
    },
    waiverOfSubrogation: {
        dropdown_required: true
    },
    combinedRate: {
        required:function(){
                if($('#sepOrCom').val() == "no")
                    return true;
                else
                    return false;
            },
        max: 100,
        number:true

    },
    brokerage: {
        required: true,
        number:true,
        max: 100
    },
    sepOrCom: {
        dropdown_required: true
    },
    // warranty: {
    //     number:true
    // },
    // exclusion: {
    //     number:true
    // },
        excess: {
        required: true,
        number:true
    },
    // specialCondition: {
    //     number:true
    // },
        rateRequiredAdmin:{
            required:function(){
                if($('#sepOrCom').val() == "yes")
                    return true;
                else
                    return false;
            },
            number:true,
            max: 100
        },
        rateRequiredNonAdmin: {
            required: function () {
                if ($('#sepOrCom').val() == "yes")
                    return true;
                else
                    return false;
            },
            number: true,
            max: 100
        },
},
messages: {
        scale: "Please select the scale of compensation / limit of indemnity.",
        extended_liability: "Please enter employers extended liability.",
        medical_expenses: "Please select medical expenses.",
        repatriation_expenses: "Please select repatriation expenses.",
        HoursPAC: "Please select this HoursPAC.",
        herniaCover: "Please select this field.",
        emergencyEvacuation: "Please select this field.",
        legalCost: "Please select this field.",
        empToEmpLiability: "Please select this field.",
        errorsOmissions: "Please select this field.",
        crossLiability: "Please select this field.",
        waiverOfSubrogation: "Please select waiver of subrogation.",
        combinedRate: "Please enter a valid rate in %.",
        brokerage: "Please enter a valid brokerage in %.",
        warranty: "Please enter warranty.",
        exclusion: "Please enter exclusion.",
        excess: "Please enter excess.",
        specialCondition: "Please enter special condition.",
        rateRequiredAdmin:"Please enter a valid rate in %.",
        rateRequiredNonAdmin:"Please enter a valid rate in %.",
        sepOrCom:"Please select rate type."
},
errorPlacement: function (error, element) {
    if(element.attr("name") == "scale")
    {
        error.insertAfter(element.parent().parent());
        scrolltop();
    }
    else if( element.attr("name") == "medical_expenses" ||
    element.attr("name") == "repatriation_expenses"||   element.attr("name") == "HoursPAC"||
    element.attr("name") == "herniaCover" || element.attr("name") == "emergencyEvacuation" ||element.attr("name") == "legalCost"
    || element.attr("name") == "empToEmpLiability" || element.attr("name") == "errorsOmissions" || element.attr("name") == "crossLiability" ||
    element.attr("name") == "waiverOfSubrogation" || element.attr("name") == "sepOrCom" )
    {
        error.insertAfter(element.parent());
        scrolltop();
    }
    else {
        error.insertAfter(element);
        scrolltop();
    }
},
submitHandler: function (form,event) {
    var form_data = new FormData($("#e-slip-form")[0]);
    form_data.append('_token', '{{csrf_token()}}');
    $('#preLoader').show();
    //$("#eslip_submit").attr( "disabled", "disabled" );
    $.ajax({
        method: 'post',
        url: '{{url('employer/eslip-save')}}',
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
function scrolltop()
{
    $('html,body').animate({
        scrollTop: 150
    }, 0);
}

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

$("#sepOrCom").change(function () {
                if ($(this).val() == "yes") {
                    $("#row_seperate").show();
                    $("#row_combined").hide();
                } else {
                    $("#row_combined").show();
                    $("#row_seperate").hide();
                }
            });


/*
* Custom dropDown validation*/

function dropDownValidation(){
    // var extended_liability = $("#extended_liability :selected").val();
    // if(extended_liability == ''){
    //     $('#extended_liability-error').show();
    // }else{
    //     $('#extended_liability-error').hide();
    // }

    // var medical_expenses = $("#medical_expenses :selected").val();
    // if(medical_expenses == ''){
    //     $('#medical_expenses-error').show();
    // }else{
    //     $('#medical_expenses-error').hide();
    // }

    var sepOrCom = $("#sepOrCom :selected").val();
    if(sepOrCom == ''){
        $('#sepOrCom-error').show();
    }else{
        $('#sepOrCom-error').hide();
    }

    var HoursPAC = $("#HoursPAC :selected").val();
    if(HoursPAC == ''){
        $('#HoursPAC-error').show();
    }else{
        $('#HoursPAC-error').hide();
    }

    var herniaCover = $("#herniaCover :selected").val();
    if(herniaCover == ''){
        $('#herniaCover-error').show();
    }else{
        $('#herniaCover-error').hide();
    }

    var emergencyEvacuation = $("#emergencyEvacuation :selected").val();
    if(emergencyEvacuation == ''){
        $('#emergencyEvacuation-error').show();
    }else{
        $('#emergencyEvacuation-error').hide();
    }

    var legalCost = $("#legalCost :selected").val();
    if(legalCost == ''){
        $('#legalCost-error').show();
    }else{
        $('#legalCost-error').hide();
    }

    var empToEmpLiability = $("#empToEmpLiability :selected").val();
    if(empToEmpLiability == ''){
        $('#empToEmpLiability-error').show();
    }else{
        $('#empToEmpLiability-error').hide();
    }

    var errorsOmissions = $("#errorsOmissions :selected").val();
    if(errorsOmissions == ''){
        $('#errorsOmissions-error').show();
    }else{
        $('#errorsOmissions-error').hide();
    }

    var crossLiability = $("#crossLiability :selected").val();
    if(crossLiability == ''){
        $('#crossLiability-error').show();
    }else{
        $('#crossLiability-error').hide();
    }

    var waiverOfSubrogation = $("#waiverOfSubrogation :selected").val();
    if(waiverOfSubrogation == ''){
        $('#waiverOfSubrogation-error').show();
    }else{
        $('#waiverOfSubrogation-error').hide();
    }

}
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
        url: '{{url('employer/insurance-company-save')}}',
        data: form_data,
        processData: false,
        contentType: false,
        success: function (result) {
            if (result.success== 'success') {
                $("#send_btn").attr( "disabled", false );
                window.location.href = '{{url('employer/e-quotation')}}'+'/'+result.id;
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
        url: '{{url('employer/eslip-save')}}',
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


