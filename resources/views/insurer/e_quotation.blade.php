
@extends('layouts.insurer_layout')


@section('content')
    <div class="section_details">
        <div class="card_header clearfix">
            <h3 class="title" style="margin-bottom: 8px;">Workmans Compensation</h3>
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
                                <label class="form_label">Insured <span style="visibility:hidden">*</span></label>
                                <div class="enter_data">
                                    <p>{{@$formData['firstName']}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form_group">
                                <label class="form_label">Cover <span style="visibility:hidden">*</span></label>
                                <div class="row">
                                    <div class="col-md-6">
                                            <span class="note">
                                               <label>
                                                   <b>Workmen’s Compensation</b><br>
                                                    Benefits to employees in accordance with UAE Federal Labor Law No 8 (Chapter 8 of 1980)
                                                    and amendments thereto in respect of work related accidents arising out of or in the course of their employment.
                                               </label>
                                            </span>
                                    </div>
                                    <div class="col-md-6">
                                            <span class="note">
                                               <label>
                                                   <b>Employer’s Liability </b><br>
                                                    Liability at law as per UAE Shariah and/or Common Law in respect of work related accidents
                                               </label>
                                            </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form_group">
                                <label class="form_label">Law <span style="visibility:hidden">*</span></label>
                                <div class="enter_data">
                                    <p>UAE Federal Labour Law No. 8 Of 1980 and subsequent amendments</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <label class="form_label">Business Activity <span style="visibility:hidden">*</span></label>
                                <div class="enter_data">
                                    <p>{{@$formData['businessType']}}</p>
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
                                        <tr @if(!@$formData['employeeDetails']['adminAnnualWages']) style="display: none" @endif>
                                            <td valign="top" class="name">Admin : <span>@if(@$formData['employeeDetails']['adminAnnualWages']!=""){{number_format(@$formData['employeeDetails']['adminAnnualWages'],2)}}@else -- @endif</span></td>
                                        </tr>
                                        <tr @if(!@$formData['employeeDetails']['nonAdminAnnualWages']) style="display: none" @endif>
                                            <td valign="top" class="name">Non-Admin : <span>@if(@$formData['employeeDetails']['nonAdminAnnualWages']!=""){{number_format(@$formData['employeeDetails']['nonAdminAnnualWages'],2)}}@else -- @endif</span></td>
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
                                        <tr @if(!@$formData['employeeDetails']['adminCount']) style="display: none" @endif>
                                            <td valign="top" class="name">Admin : <span>@if(@$formData['employeeDetails']['adminCount']!=""){{@$formData['employeeDetails']['adminCount']}}@else -- @endif</span></td>
                                        </tr>
                                        <tr @if(!@$formData['employeeDetails']['nonAdminCount']) style="display: none" @endif>
                                            <td valign="top" class="name">Non-Admin : <span>@if(@$formData['employeeDetails']['nonAdminCount']!=""){{@$formData['employeeDetails']['nonAdminCount']}}@else -- @endif</span></td>
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
                                    <p>
                                        @if(@$formData['placeOfEmployment']['withinUAE']==true)
                                            {{@$formData['placeOfEmployment']['emirateName']}} , UAE
                                        @else
                                            {{@$formData['placeOfEmployment']['countryName']}}
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <label class="form_label bold">Policy period <span style="visibility:hidden">*</span></label>
                                <div class="enter_data border_none">
                                    <table class="fill_data">
                                        <tr>
                                            <td valign="top" class="name">From : <span>{{@$formData['policyPeriod']['policyFrom']}}</span></td>
                                        </tr>
                                        <tr>
                                            <td valign="top" class="name">To : <span>{{@$formData['policyPeriod']['policyTo']}}</span></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form_group">
                                <label class="form_label bold">Scale of Compensation /Limit of Indemnity - @if(@$formData['scaleOfCompensation']['asPerUAELaw']==true) As per UAE Labour Law @else Death/Permanent Total Disability (PTD) Benefit increased to AED 50,000/- for those monthly
                                    salary is not more than AED 2,000/- and AE 75,000/- for those whose monthly salary is AED 2,000/- or more @endif<span>*</span>
                                </label>
                                <div class="cntr">
                                    <label for="d_scale_1" class="radio">
                                        <input type="radio" name="d_scale" value="Agree" id="d_scale_1" class="hidden" @if(@$insurerReply['scaleOfCompensation'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="d_scale_2" class="radio">
                                        <input type="radio" name="d_scale" value="Not Agree" id="d_scale_2" class="hidden" @if(@$insurerReply['scaleOfCompensation'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold">Employer’s extended liability under Common Law/Shariah Law <span>*</span></label>
                            <div class="enter_data border_none">
                                <p style="margin-bottom: 10px;">Expected : {{number_format(@$formData['extendedLiability'],2)}}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                                <input class="form_input number" id="select_liability" name="select_liability" type="text" value="@if(@$insurerReply['extendedLiability']!=''){{number_format(@$insurerReply['extendedLiability'],2)}}@endif" >
                        </div>
                        {{-- <div class="col-md-6">
                            <div class="form_group">
                                <div class="custom_select">
                                    <select class="form_input" id="select_liability" name="select_liability" onchange="dropdownValidation(this)">
                                        <option value="">Select</option>
                                        <option value="1M" @if(@$insurerReply['extendedLiability']=='1M') selected @endif>1M</option>
                                        <option value="2M" @if(@$insurerReply['extendedLiability']=='2M') selected @endif>2M</option>
                                        <option value="3M" @if(@$insurerReply['extendedLiability']=='3M') selected @endif>3M</option>
                                        <option value="4M" @if(@$insurerReply['extendedLiability']=='4M') selected @endif>4M</option>
                                        <option value="5M" @if(@$insurerReply['extendedLiability']=='5M') selected @endif>5M</option>
                                        <option value="7.5M" @if(@$insurerReply['extendedLiability']=='7.5M') selected @endif>7.5M</option>
                                        <option value="10M" @if(@$insurerReply['extendedLiability']=='10M') selected @endif>10M</option>
                                        <option value="25M" @if(@$insurerReply['extendedLiability']=='25M') selected @endif>25M</option>
                                        <option value="option_other1" @if(@$insurerReply['extendedLiability'] && !in_array(@$insurerReply['extendedLiability'],['1M','2M','3M','4M','5M','7.5M','10M','25M'])) selected @endif>Other</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" id="option_other1" style="display: none">
                            <div class="form_group">
                                <input class="form_input" id="other_liability" name="other_liability" type="text" placeholder="Please specify">
                            </div>
                        </div> --}}
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold">Medical Expense (In AED) <span>*</span></label>
                            <div class="enter_data border_none">
                                <p style="margin-bottom: 10px;">Expected : {{number_format(@$formData['medicalExpense'],2)}}</p>
                            </div>
                        </div>
                        <div class="col-md-6">

                                <input class="form_input number" id="medical_expense" name="medical_expense" type="text" value="@if(@$insurerReply['medicalExpense']!=''){{number_format(@$insurerReply['medicalExpense'],2)}}@endif">

                        </div>
                        {{-- <div class="col-md-6">
                            <div class="form_group">
                                <div class="custom_select">
                                    <select class="form_input" id="medical_expense" name="medical_expense" onchange="dropdownValidation(this)">
                                        <option value="">Select</option>
                                        <option value="10000" @if(@$insurerReply['medicalExpense']=='10000') selected @endif>10000</option>
                                        <option value="15000" @if(@$insurerReply['medicalExpense']=='15000') selected @endif>15000</option>
                                        <option value="20000" @if(@$insurerReply['medicalExpense']=='20000') selected @endif>20000</option>
                                        <option value="25000" @if(@$insurerReply['medicalExpense']=='25000') selected @endif>25000</option>
                                        <option value="30000" @if(@$insurerReply['medicalExpense']=='30000') selected @endif>30000</option>
                                        <option value="35000" @if(@$insurerReply['medicalExpense']=='35000') selected @endif>35000</option>
                                        <option value="40000" @if(@$insurerReply['medicalExpense']=='40000') selected @endif>40000</option>
                                        <option value="50000" @if(@$insurerReply['medicalExpense']=='50000') selected @endif>50000</option>
                                        <option value="option_other2" @if(@$insurerReply['medicalExpense'] && !in_array(@$insurerReply['medicalExpense'],['50000','40000','35000','30000','25000','20000','15000','10000'])) selected @endif>Other</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" id="option_other2" style="display: none">
                            <div class="form_group">
                                <input class="form_input" id="other_medical_expense" name="other_medical_expense" type="text" placeholder="Please specify">
                            </div>
                        </div> --}}
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold">Repatriation Expenses (Repatriation of mortal remains or injured employee to his/her home country on medical advice) including  expenses of an accompanying person <span>*</span></label>
                            <div class="enter_data border_none">
                                <p style="margin-bottom: 10px;">Expected : {{number_format(@$formData['repatriationExpenses'],2)}}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                                <input class="form_input number" id="repatriation_expenses" name="repatriation_expenses" type="text" value="@if(@$insurerReply['repatriationExpenses']!=''){{number_format(@$insurerReply['repatriationExpenses'],2)}}@endif" >

                        </div>
                        {{-- <div class="col-md-6">
                            <div class="form_group">
                                <div class="custom_select">
                                    <select class="form_input" id="repatriation_expenses" name="repatriation_expenses" onchange="dropdownValidation(this)">
                                        <option value="">Select</option>
                                        <option value="10000" @if(@$insurerReply['repatriationExpenses']=='10000') selected @endif>10000</option>
                                        <option value="15000" @if(@$insurerReply['repatriationExpenses']=='15000') selected @endif>15000</option>
                                        <option value="20000" @if(@$insurerReply['repatriationExpenses']=='20000') selected @endif>20000</option>
                                        <option value="25000" @if(@$insurerReply['repatriationExpenses']=='25000') selected @endif>25000</option>
                                        <option value="30000" @if(@$insurerReply['repatriationExpenses']=='30000') selected @endif>30000</option>
                                        <option value="35000" @if(@$insurerReply['repatriationExpenses']=='35000') selected @endif>35000</option>
                                        <option value="40000" @if(@$insurerReply['repatriationExpenses']=='40000') selected @endif>40000</option>
                                        <option value="50000" @if(@$insurerReply['repatriationExpenses']=='50000') selected @endif>50000</option>
                                        <option value="option_other3" @if(@$insurerReply['repatriationExpenses'] && !in_array(@$insurerReply['repatriationExpenses'],['50000','40000','35000','30000','25000','20000','15000','10000'])) selected @endif>Other</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" id="option_other3" style="display: none">
                            <div class="form_group">
                                <input class="form_input" id="other_repatriation_expenses" name="other_repatriation_expenses" type="text" placeholder="Please specify">
                            </div>
                        </div> --}}
                    </div>
                    <div class="row" @if(@$formData['hiredWorkersDetails']['hasHiredWorkers']==false) style="display: none" @endif>
                        <div class="col-md-12">
                            <label class="form_label bold">cover for hired workers or casual labours? <span>*</span></label>
                        </div>
                        <div class="col-md-4">
                            <div class="form_group">
                                <div class="enter_data border_none">
                                    <table class="fill_data">
                                        <tr>
                                            <td class="name" valign="top">No of labourers : <span>@if(@$formData['hiredWorkersDetails']['hasHiredWorkers']==true) {{@$formData['hiredWorkersDetails']['noOfLabourers']}} @else -- @endif</span></td>
                                        </tr>
                                        <tr>
                                            <td class="name" valign="top">Estimated Annual wages (AED) : <span>@if(@$formData['hiredWorkersDetails']['hasHiredWorkers']==true) {{number_format(@$formData['hiredWorkersDetails']['annualWages'],2)}} @else -- @endif</span></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="form_group">
                            <div class="cntr">
                                <label for="hired_labours_1" class="radio">
                                    <input type="radio" name="hired_labours" value="Agree" id="hired_labours_1" class="hidden" @if(@$insurerReply['coverHiredWorkers']['isAgree'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="hired_labours_2" class="radio">
                                    <input type="radio" name="hired_labours" value="Not Agree" id="hired_labours_2" class="hidden" @if(@$insurerReply['coverHiredWorkers']['isAgree'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form_group">
                                <textarea name="hired_workers_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['coverHiredWorkers']['comment']}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row" @if(!@$formData['offShoreEmployeeDetails']['noOfLabourers']) style="display: none" @endif>
                        <div class="col-md-12">
                            <label class="form_label bold">Cover for offshore employees? <span>*</span></label>
                        </div>
                        <div class="col-md-4">
                            <div class="form_group">
                                <div class="enter_data border_none">
                                    <table class="fill_data">
                                        <tr>
                                            <td class="name" valign="top">No of labourers : <span>@if(@$formData['offShoreEmployeeDetails']['hasOffShoreEmployees']==true) {{@$formData['offShoreEmployeeDetails']['noOfLabourers']}} @else -- @endif</span></td>
                                        </tr>
                                        <tr>
                                            <td class="name" valign="top">Estimated Annual wages (AED) : <span>@if(@$formData['offShoreEmployeeDetails']['hasOffShoreEmployees']==true) {{number_format(@$formData['offShoreEmployeeDetails']['annualWages'],2)}} @else -- @endif</span></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="form_group">
                            <div class="cntr">
                                <label for="offshore_employee_1" class="radio">
                                    <input type="radio" name="offshore_employee" value="Agree" id="offshore_employee_1" class="hidden" @if(@$insurerReply['coverOffshore']['isAgree'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="offshore_employee_2" class="radio">
                                    <input type="radio" name="offshore_employee" value="Not Agree" id="offshore_employee_2" class="hidden" @if(@$insurerReply['coverOffshore']['isAgree'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form_group">
                                <textarea name="offshore_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['coverOffshore']['comment']}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row" @if(@$formData['herniaCover']==false) style="display: none" @endif>
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i> Cover for hernia, heat/sun stroke, muscle spasm, muscle strain, lumbago related to work <span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="d_cover_hernia_1" class="radio">
                                    <input type="radio" name="d_cover_hernia" value="Agree" id="d_cover_hernia_1" class="hidden" @if(@$insurerReply['herniaCover']['isAgree'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="d_cover_hernia_2" class="radio">
                                    <input type="radio" name="d_cover_hernia" value="Not Agree" id="d_cover_hernia_2" class="hidden" @if(@$insurerReply['herniaCover']['isAgree'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form_group">
                                <textarea name="cover_hernia_comment" class="form_input sm_textarea" placeholder="Comment...">{{@$insurerReply['herniaCover']['comment']}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row" @if(@$formData['HoursPAC']==false) style="display: none" @endif>
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i> 24 hours non-occupational personal accident cover – in UAE and home country benefits as per UAE Labour Law <span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="d_non_occupational_1" class="radio">
                                    <input type="radio" name="d_non_occupational" value="Agree" id="d_non_occupational_1" class="hidden" @if(@$insurerReply['HoursPAC']['isAgree'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="d_non_occupational_2" class="radio">
                                    <input type="radio" name="d_non_occupational" value="Not Agree" id="d_non_occupational_2" class="hidden" @if(@$insurerReply['HoursPAC']['isAgree'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form_group">
                                <textarea name="non_occupational_comment" class="form_input sm_textarea" placeholder="Comment...">{{@$insurerReply['HoursPAC']['comment']}}</textarea>
                            </div>
                        </div>
                    </div>
                    @if(isset($formData['waiverOfSubrogation']))
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i> Waiver of subrogation <span>*</span></label>
                            <div class="enter_data border_none">
                                    <p style="margin-bottom: 10px;">Expected : {{@$formData['waiverOfSubrogation']}}</p>
                            </div>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="d_waiver_1" class="radio">
                                    <input type="radio" name="d_waiver" value="Agree" id="d_waiver_1" class="hidden" @if(@$insurerReply['waiverOfSubrogation']['isAgree'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="d_waiver_2" class="radio">
                                    <input type="radio" name="d_waiver" value="Not Agree" id="d_waiver_2" class="hidden" @if(@$insurerReply['waiverOfSubrogation']['isAgree'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form_group">
                                <textarea name="waiver_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['waiverOfSubrogation']['comment']}}</textarea>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="row" @if(@$formData['automaticClause']==false) style="display: none" @endif>
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i> Automatic addition & deletion Clause <span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="d_automatic_addition_1" class="radio">
                                    <input type="radio" name="d_automatic_addition" value="Agree" id="d_automatic_addition_1" class="hidden" @if(@$insurerReply['automaticClause']['isAgree'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="d_automatic_addition_2" class="radio">
                                    <input type="radio" name="d_automatic_addition" value="Not Agree" id="d_automatic_addition_2" class="hidden" @if(@$insurerReply['automaticClause']['isAgree'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form_group">
                                <textarea name="automatic_addition_comment" class="form_input sm_textarea" placeholder="Comment...">{{@$insurerReply['automaticClause']['comment']}}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row" @if(@$formData['lossNotification']==false) style="display:none" @endif>
                        <div class="col-md-12">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <label class="form_label bold"><i class="fa fa-circle"></i> Loss Notification – ‘as soon as reasonably practicable’ <span>*</span></label>
                                </div>
                            </div>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="d_loss_notification_1" class="radio">
                                    <input type="radio" name="d_loss_notification" value="Agree" id="d_loss_notification_1" class="hidden" @if(@$insurerReply['lossNotification']['isAgree'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="d_loss_notification_2" class="radio">
                                    <input type="radio" name="d_loss_notification" value="Not Agree" id="d_loss_notification_2" class="hidden" @if(@$insurerReply['lossNotification']['isAgree'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form_group">
                                <textarea name="loss_notification_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['lossNotification']['comment']}}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row" @if(@$formData['brokersClaimClause']==false) style="display: none" @endif>
                        <div class="col-md-12">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <label class="form_label bold">
                                        <i class="fa fa-circle"></i>
                                        Brokers Claim Handling Clause : A loss notification received by the Insurance Broker will be deemed
                                        as a loss notification to Insurer. All communications flowing between the Insurer, Insured and the
                                        appointed Loss Surveyor should be channelized through the Broker, unless there is any unavoidable
                                        reasons compelling direct communications between the parties<span>*</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="d_brokers_claim_1" class="radio">
                                    <input type="radio" name="d_brokers_claim" value="Agree" id="d_brokers_claim_1" class="hidden" @if(@$insurerReply['brokersClaimClause']['isAgree'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="d_brokers_claim_2" class="radio">
                                    <input type="radio" name="d_brokers_claim" value="Not Agree" id="d_brokers_claim_2" class="hidden" @if(@$insurerReply['brokersClaimClause']['isAgree'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form_group">
                                <textarea name="brokers_claim_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['brokersClaimClause']['comment']}}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row" @if(@$formData['flightCover']==false) style="display: none" @endif>
                        <div class="col-md-12">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <label class="form_label bold">
                                        <i class="fa fa-circle"></i>
                                        Cover for insured’s employees on employment visas whilst on incoming and outgoing flights to/from  UAE<span>*</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="d_employees_employment_1" class="radio">
                                    <input type="radio" name="d_employees_employment" value="Agree" id="d_employees_employment_1" class="hidden" @if(@$insurerReply['flightCover'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="d_employees_employment_2" class="radio">
                                    <input type="radio" name="d_employees_employment" value="Not Agree" id="d_employees_employment_2" class="hidden" @if(@$insurerReply['flightCover'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row" @if(@$formData['emergencyEvacuation']==false) style="display: none" @endif>
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i> Emergency evacuation <span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="d_emergency_evacuation_1" class="radio">
                                    <input type="radio" name="d_emergency_evacuation" value="Agree" id="d_emergency_evacuation_1" class="hidden" @if(@$insurerReply['emergencyEvacuation'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="d_emergency_evacuation_2" class="radio">
                                    <input type="radio" name="d_emergency_evacuation" value="Not Agree" id="d_emergency_evacuation_2" class="hidden" @if(@$insurerReply['emergencyEvacuation'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row" @if(@$formData['legalCost']==false) style="display: none"@endif>
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i> Including Legal and Defence cost <span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="d_defence_cost_1" class="radio">
                                    <input type="radio" name="d_defence_cost" value="Agree" id="d_defence_cost_1" class="hidden" @if(@$insurerReply['legalCost'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="d_defence_cost_2" class="radio">
                                    <input type="radio" name="d_defence_cost" value="Not Agree" id="d_defence_cost_2" class="hidden" @if(@$insurerReply['legalCost'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row" @if(@$formData['empToEmpLiability']==false) style="display: none" @endif>
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i> Employee to employee liability <span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="d_employee_employee_1" class="radio">
                                    <input type="radio" name="d_employee_employee" value="Agree" id="d_employee_employee_1" class="hidden" @if(@$insurerReply['empToEmpLiability'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="d_employee_employee_2" class="radio">
                                    <input type="radio" name="d_employee_employee" value="Not Agree" id="d_employee_employee_2" class="hidden" @if(@$insurerReply['empToEmpLiability'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row" @if(@$formData['crossLiability']==false) style="display: none" @endif>
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i> Cross Liability <span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="d_cross_liability_1" class="radio">
                                    <input type="radio" name="d_cross_liability" value="Agree" id="d_cross_liability_1" class="hidden" @if(@$insurerReply['crossLiability'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="d_cross_liability_2" class="radio">
                                    <input type="radio" name="d_cross_liability" value="Not Agree" id="d_cross_liability_2" class="hidden" @if(@$insurerReply['crossLiability'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row" @if(@$formData['diseaseCover']==false) style="display: none" @endif>
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i> Cover for occupational/ industrial disease as per Labour Law<span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px">
                            <div class="cntr">
                                <label for="d_occupational_industrial_1" class="radio">
                                    <input type="radio" name="d_occupational_industrial" value="Agree" id="d_occupational_industrial_1" class="hidden" @if(@$insurerReply['diseaseCover'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="d_occupational_industrial_2" class="radio">
                                    <input type="radio" name="d_occupational_industrial" value="Not Agree" id="d_occupational_industrial_2" class="hidden" @if(@$insurerReply['diseaseCover'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row" @if(@$formData['cancellationClause']==false) style="display: none" @endif>
                        <div class="col-md-12">
                            <label class="form_label bold">
                                <i class="fa fa-circle"></i> Cancellation clause-30 days by either side on  pro-rata<span>*</span>
                            </label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="d_cancellation_clause_1" class="radio">
                                    <input type="radio" name="d_cancellation_clause" value="Agree" id="d_cancellation_clause_1" class="hidden" @if(@$insurerReply['cancellationClause'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="d_cancellation_clause_2" class="radio">
                                    <input type="radio" name="d_cancellation_clause" value="Not Agree" id="d_cancellation_clause_2" class="hidden" @if(@$insurerReply['cancellationClause'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row" @if(@$formData['indemnityToPrincipal']==false) style="display: none" @endif>
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i> Indemnity to principal <span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="d_indemnity_principal_1" class="radio">
                                    <input type="radio" name="d_indemnity_principal" value="Agree" id="d_indemnity_principal_1" class="hidden" @if(@$insurerReply['indemnityToPrincipal'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="d_indemnity_principal_2" class="radio">
                                    <input type="radio" name="d_indemnity_principal" value="Not Agree" id="d_indemnity_principal_2" class="hidden" @if(@$insurerReply['indemnityToPrincipal'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row"  @if(@$formData['overtimeWorkCover']==false) style="display: none" @endif>
                        <div class="col-md-12">
                            <label class="form_label bold">
                                <i class="fa fa-circle"></i>
                                Including work related accidents and bodily injuries during overtime work, night
                                shifts, work on public holidays and week-ends.<span>*</span>
                            </label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="d_work_accidents_1" class="radio">
                                    <input type="radio" name="d_work_accidents" value="Agree" id="d_work_accidents_1" class="hidden" @if(@$insurerReply['overtimeWorkCover'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="d_work_accidents_2" class="radio">
                                    <input type="radio" name="d_work_accidents" value="Not Agree" id="d_work_accidents_2" class="hidden" @if(@$insurerReply['overtimeWorkCover'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                    </div>


                    <div class="row" @if(@$formData['primaryInsuranceClause']==false) style="display: none" @endif>
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i> Primary insurance clause<span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="d_primary_insurance_1" class="radio">
                                    <input type="radio" name="d_primary_insurance" value="Agree" id="d_primary_insurance_1" class="hidden" @if(@$insurerReply['primaryInsuranceClause'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="d_primary_insurance_2" class="radio">
                                    <input type="radio" name="d_primary_insurance" value="Not Agree" id="d_primary_insurance_2" class="hidden" @if(@$insurerReply['primaryInsuranceClause'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row"  @if(@$formData['travelCover']==false) style="display:none;" @endif>
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i> Travelling to and from workplace<span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="d_travelling_1" class="radio">
                                    <input type="radio" name="d_travelling" value="Agree" id="d_travelling_1" class="hidden" @if(@$insurerReply['travelCover'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="d_travelling_2" class="radio">
                                    <input type="radio" name="d_travelling" value="Not Agree" id="d_travelling_2" class="hidden" @if(@$insurerReply['travelCover'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row" @if(@$formData['riotCover']==false) style="display: none" @endif>
                        <div class="col-md-12">
                            <label class="form_label bold">
                                <i class="fa fa-circle"></i> Riot, Strikes, civil commotion and Passive war risk<span>*</span>
                            </label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="d_riot_strikes_1" class="radio">
                                    <input type="radio" name="d_riot_strikes" value="Agree" id="d_riot_strikes_1" class="hidden" @if(@$insurerReply['riotCover'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="d_riot_strikes_2" class="radio">
                                    <input type="radio" name="d_riot_strikes" value="Not Agree" id="d_riot_strikes_2" class="hidden" @if(@$insurerReply['riotCover'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row"  @if(@$formData['errorsOmissions']==false) style="display: none" @endif>
                        <div class="col-md-12">
                            <label class="form_label bold">
                                <i class="fa fa-circle"></i> Errors and Ommissions<span>*</span>
                            </label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="d_ommisions_1" class="radio">
                                    <input type="radio" name="d_ommisions" value="Agree" id="d_ommisions_1" class="hidden" @if(@$insurerReply['errorsOmissions'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="d_ommisions_2" class="radio">
                                    <input type="radio" name="d_ommisions" value="Not Agree" id="d_ommisions_2" class="hidden" @if(@$insurerReply['errorsOmissions'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                    </div>
               <div class="row" @if(!@$formData['offShoreEmployeeDetails']['noOfLabourers']) style="display: none" @endif>
                        <div class="col-md-12">
                            <label class="form_label bold">
                                <i class="fa fa-circle"></i>Cover for offshore employee<span>*</span>
                            </label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="d_offshore1" class="radio">
                                    <input type="radio" name="d_offshore" value="Agree" id="d_offshore1" class="hidden" @if(@$insurerReply['offshoreCheck'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="d_offshore2" class="radio">
                                    <input type="radio" name="d_offshore" value="Not Agree" id="d_offshore2" class="hidden" @if(@$insurerReply['offshoreCheck'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row" @if(@$formData['hiredWorkersDetails']['hasHiredWorkers']==false) style="display: none" @endif>
                        <div class="col-md-12">
                            <label class="form_label bold">
                                <i class="fa fa-circle"></i>EMPLOYMENT CLAUSE<span>*</span>
                            </label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="employeeclause1" class="radio">
                                    <input type="radio" name="employeeclause" value="Agree" id="employeeclause1" class="hidden" @if(@$insurerReply['hiredCheck'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="employeeclause2" class="radio">
                                    <input type="radio" name="employeeclause" value="Not Agree" id="employeeclause2" class="hidden" @if(@$insurerReply['hiredCheck'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
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
                                        <td>{{@$formData['claimsHistory'][0]['description'] ?:' -- '}}</td>
                                        <td>@if($formData['claimsHistory'][0]['minorInjuryClaimAmount']!=''){{number_format(@$formData['claimsHistory'][0]['minorInjuryClaimAmount'],2)}} @else -- @endif</td>
                                        <td>@if($formData['claimsHistory'][0]['deathClaimAmount']!=''){{number_format(@$formData['claimsHistory'][0]['deathClaimAmount'],2)}} @else --@endif</td>
                                    </tr>
                                    <tr>
                                        <td>Year 1 <i data-toggle="tooltip" data-placement="bottom" title="Most Resent" data-container="body" class="material-icons info_icon">info</i></td>
                                        <td>Non Admin</td>
                                        <td>{{@$formData['claimsHistory'][1]['description'] ?:' -- '}}</td>
                                        <td>@if($formData['claimsHistory'][1]['minorInjuryClaimAmount']!=''){{number_format(@$formData['claimsHistory'][1]['minorInjuryClaimAmount'],2)}}@else --@endif</td>
                                        <td>@if($formData['claimsHistory'][1]['deathClaimAmount']!=''){{number_format(@$formData['claimsHistory'][1]['deathClaimAmount'],2)}}@else --@endif</td>
                                    </tr>
                                    <tr>
                                        <td>Year 2</td>
                                        <td>Admin</td>
                                        <td>{{@$formData['claimsHistory'][2]['description'] ?:' -- '}}</td>
                                        <td>@if($formData['claimsHistory'][2]['minorInjuryClaimAmount']!=''){{number_format(@$formData['claimsHistory'][2]['minorInjuryClaimAmount'],2)}}@else --@endif</td>
                                        <td>@if($formData['claimsHistory'][2]['deathClaimAmount']!=''){{number_format(@$formData['claimsHistory'][2]['deathClaimAmount'],2)}}@else --@endif</td>
                                    </tr>
                                    <tr>
                                        <td>Year 2</td>
                                        <td>Non Admin</td>
                                        <td>{{@$formData['claimsHistory'][3]['description'] ?:' -- '}}</td>
                                        <td>@if($formData['claimsHistory'][3]['minorInjuryClaimAmount']!=''){{number_format(@$formData['claimsHistory'][3]['minorInjuryClaimAmount'],2)}}@else --@endif</td>
                                        <td>@if($formData['claimsHistory'][3]['deathClaimAmount']!=''){{number_format(@$formData['claimsHistory'][3]['deathClaimAmount'],2)}}@else --@endif</td>
                                    </tr>
                                    <tr>
                                        <td>Year 3</td>
                                        <td>Admin</td>
                                        <td>{{@$formData['claimsHistory'][4]['description'] ?:' -- '}}</td>
                                        <td>@if($formData['claimsHistory'][4]['minorInjuryClaimAmount']!=''){{number_format(@$formData['claimsHistory'][4]['minorInjuryClaimAmount'],2)}}@else --@endif</td>
                                        <td>@if($formData['claimsHistory'][4]['deathClaimAmount']!=''){{number_format(@$formData['claimsHistory'][4]['deathClaimAmount'],2)}}@else --@endif</td>
                                    </tr>
                                    <tr>
                                        <td>Year 3</td>
                                        <td>Non Admin</td>
                                        <td>{{@$formData['claimsHistory'][5]['description'] ?:' -- '}}</td>
                                        <td>@if($formData['claimsHistory'][5]['minorInjuryClaimAmount']!=''){{number_format(@$formData['claimsHistory'][5]['minorInjuryClaimAmount'],2)}}@else --@endif</td>
                                        <td>@if($formData['claimsHistory'][5]['deathClaimAmount']!=''){{number_format(@$formData['claimsHistory'][5]['deathClaimAmount'],2)}}@else --@endif</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
 
                    <div class="row">
                        @if(isset($formData['sepOrCom']) && $formData['sepOrCom']==true)
                        <div class="col-md-3" @if($formData['sepOrCom']==true) style="display:block" @else style="display: none" @endif>
                            {{-- <input type="hidden" id="admin" @if(!@$formData['employeeDetails']['adminCount']) value="false" @else value="true" @endif> --}}
                            <div class="form_group">
                                <label class="form_label bold">Rate required (Admin) (IN %) <span>*</span></label>
                                <div class="enter_data border_none">
                                    <p style="margin-bottom: 10px;">Expected : {{number_format(@$formData['rateRequiredAdmin'],2)}}</p>
                                </div>
                                <input class="form_input number" name="rate_admin" type="text" value="@if(isset($insurerReply['rateRequiredAdmin']) && $insurerReply['rateRequiredAdmin'] != ''){{number_format(@$insurerReply['rateRequiredAdmin'],2)}}@endif">
                            </div>
                        </div>
                        <div class="col-md-3" @if($formData['sepOrCom']==true) style="display:block" @else style="display: none" @endif>
                            {{-- <input type="hidden" id="nonadmin" @if(!@$formData['employeeDetails']['nonAdminCount']) value="false" @else value="true" @endif> --}}
                            <div class="form_group">
                                <label class="form_label bold">Rate required (Non-Admin) (IN %) <span>*</span></label>
                                <div class="enter_data border_none">
                                    <p style="margin-bottom: 10px;">Expected : {{number_format(@$formData['rateRequiredNonAdmin'],2)}}</p>
                                </div>
                                <input class="form_input number" name="rate_nadmin" type="text" value="@if(isset($insurerReply['rateRequiredNonAdmin']) && $insurerReply['rateRequiredNonAdmin'] != ''){{number_format(@$insurerReply['rateRequiredNonAdmin'],2)}}@endif">
                            </div>
                        </div>
                        @endif
                        @if(isset($formData['sepOrCom']) && $formData['sepOrCom']==false)
                        <div class="col-md-3">
                            <div class="form_group">
                                <label class="form_label bold">Combined Rate (IN %) <span>*</span></label>
                                <div class="enter_data border_none">
                                    <p style="margin-bottom: 10px;">Expected : {{number_format(@$formData['combinedRate'],2)}}</p>
                                </div>
                                <input class="form_input number" name="combined_rate" type="text" value="@if(isset($insurerReply['combinedRate']) && $insurerReply['combinedRate'] != ''){{number_format(@$insurerReply['combinedRate'],2)}}@endif">
                            </div>
                        </div>
                        @endif
                        <div class="col-md-3">
                            <div class="form_group">
                                <label class="form_label bold">Brokerage (IN %) <span>*</span></label>
                                <div class="enter_data border_none">
                                    <p style="margin-bottom: 10px;">Expected : {{number_format(@$formData['brokerage'],2)}}</p>
                                </div>
                                <input class="form_input number" name="brokerage" type="text" value="@if(isset($insurerReply['brokerage']) && $insurerReply['brokerage'] != ''){{number_format(@$insurerReply['brokerage'],2)}}@endif">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form_group">
                                <label class="form_label bold">Warranty <span>*</span></label>
                                <div class="enter_data border_none">
                                    <p style="margin-bottom: 10px;">Expected : {{@$formData['warranty'] ?:'--'}}</p>
                                </div>
                                <textarea class="form_input" name="warranty" type="text">{{@$insurerReply['warranty']}}</textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form_group">
                                <label class="form_label bold">Exclusion <span>*</span></label>
                                <div class="enter_data border_none">
                                    <p style="margin-bottom: 10px;">Expected : {{@$formData['exclusion']?: '--'}}</p>
                                </div>
                                <textarea class="form_input" name="exclusion" type="text">{{@$insurerReply['exclusion']}}</textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form_group">
                                <label class="form_label bold">Special Condition <span>*</span></label>
                                <div class="enter_data border_none">
                                    <p style="margin-bottom: 10px;">Expected : {{@$formData['specialCondition']?: '--'}}</p>
                                </div>
                                <textarea class="form_input" name="special_condition" type="text">{{@$insurerReply['specialCondition']}}</textarea>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary btn_action pull-right" type="submit" id="quot_submit" @if($pipelineStatus=='Approved E Quote' || $pipelineStatus=='Issuance') style="display: none" @endif> @if(@$insurerReply['quoteStatus']=='active') Update @else Proceed @endif</button>
                    <button class="btn blue_btn btn_action pull-right" type="button" @if(@$insurerReply['quoteStatus']=='active') style="display: none" @endif onclick="saveDraft()">SAVE AS DRAFT</button>
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
            $.validator.setDefaults({
                ignore:[]
            });
            // if($('#repatriation_expenses').val()=='option_other3')
            // {
            //     $('#other_repatriation_expenses').val('{{@$insurerReply['repatriationExpenses']}}');
            //     $('#option_other3').show();
            // }
            // if($('#medical_expense').val()=='option_other2')
            // {
            //     $('#other_medical_expense').val('{{@$insurerReply['medicalExpense']}}');
            //     $('#option_other2').show();
            // }
            // if($('#select_liability').val()=='option_other1')
            // {
            //     $('#other_liability').val('{{@$insurerReply['extendedLiability']}}');
            //     $('#option_other1').show();
            // }
        });

        $(function() {
            // $("#select_liability").change(function () {
            //     if ($(this).val() == "option_other1") {
            //         $("#option_other1").show();
            //     } else {
            //         $("#option_other1").hide();
            //     }
            // });
            // $("#medical_expense").change(function () {
            //     if ($(this).val() == "option_other2") {
            //         $("#option_other2").show();
            //     } else {
            //         $("#option_other2").hide();
            //     }
            // });
            // $("#repatriation_expenses").change(function () {
            //     if ($(this).val() == "option_other3") {
            //         $("#option_other3").show();
            //     } else {
            //         $("#option_other3").hide();
            //     }
            // });
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
        jQuery.validator.addMethod("dropdown_required", function(value, element) {
            // console.log($(element).closest( ".row" ).is(":hidden"));
            if(value!='' || $(element).closest( ".row" ).is(":hidden")) {
                return true;
            } else {
                return false;
            }
            // allow any non-whitespace characters as the host part
//        return this.optional( element ) || /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@(?:\S{1,63})$/.test( value );
        }, 'Please select this field.');
        function validateFunction(name)
        {
            element = document.getElementsByName(name);
            if($(element).closest( ".row" ).is(":hidden")){
                return false
            }
            else
            {
                return true;
            }
        }
        //Form valodation
        $('#e-quotation-form').validate({
            ignore:[],
            rules:{
                d_scale:{
                    required:true
                },
                select_liability:{
                    required:true
                },
                medical_expense:{
                    required:true
                },
                repatriation_expenses:{
                    required:true
                },
                hired_labours:{
                    required: validateFunction('hired_labours')
                },
                offshore_employee:{
                    required: validateFunction('offshore_employee')
                },
                d_cover_hernia:{
                    required: validateFunction('d_cover_hernia')
                },
                d_non_occupational:{
                    required: validateFunction('d_non_occupational')
                },
                d_waiver:{
                    required: validateFunction('d_waiver')
                },
                casual_labourer:{
                    required: validateFunction('casual_labourer')
                },
                d_emergency_evacuation:{
                    required: validateFunction('d_emergency_evacuation')
                },
                defence_cost:{
                    required: validateFunction('defence_cost')
                },
                d_defence_cost:{
                    required: validateFunction('d_defence_cost')
                },
                d_employee_employee:{
                    required: validateFunction('d_employee_employee')
                },
                d_cross_liability:{
                    required: validateFunction('d_cross_liability')
                },
                d_loss_notification:{
                    required: validateFunction('d_loss_notification')
                },
                d_brokers_claim:{
                    required: validateFunction('d_brokers_claim')
                },
                d_employees_employment:{
                    required: validateFunction('d_employees_employment')
                },
                d_occupational_industrial:{
                    required: validateFunction('d_occupational_industrial')
                },
                d_cancellation_clause:{
                    required: validateFunction('d_cancellation_clause')
                },
                d_indemnity_principal:{
                    required: validateFunction('d_indemnity_principal')
                },
                d_work_accidents:{
                    required: validateFunction('d_work_accidents')
                },
                d_primary_insurance:{
                    required: validateFunction('d_primary_insurance')
                },
                d_travelling:{
                    required: validateFunction('d_travelling')
                },
                d_riot_strikes:{
                    required: validateFunction('d_riot_strikes')
                },
                d_ommisions:{
                    required: validateFunction('d_ommisions')
                },
                d_offshore:{
                    required: validateFunction('d_offshore')
                },employeeclause:{
                    required: validateFunction('employeeclause')
                },
                d_automatic_addition:{
                    required: validateFunction('d_automatic_addition')
                },
                rate_admin:{
                    required:true,
                    number:true,
                    max: 100
                },
                rate_nadmin:{
                    required:true,
                    number:true,
                    max: 100
                },
                combined_rate:{
                    required:true,
                    number:true,
                    max: 100
                },
                brokerage:{
                    required:true,
                    number:true,
                    max: 100
                },
                warranty:{
                    required:true
                },
                exclusion:{
                    required:true
                },
                special_condition:{
                    required:true
                },
                other_liability:{
                    required:function () {
                        return ($('#select_liability').val()=='option_other1');
                    },
                    number:true
                },
                other_medical_expense:{
                    required:function () {
                        return($('#medical_expense').val()=='option_other2');
                    },
                    number:true
                },
                other_repatriation_expenses:{
                    required:function () {
                        return($('#repatriation_expenses').val()=='option_other3');
                    },
                    number:true
                }
        },
            messages:{
                d_scale: "Please select agree or not agree.",
                select_liability:"Please enter employer's extended liability.",
                medical_expense:"Please enter medical expense.",
                repatriation_expenses:"Please enter repatriation expenses.",
                hired_labours:"Please select agree or not agree.",
                offshore_employee:"Please select agree or not agree.",
                d_cover_hernia:"Please select agree or not agree.",
                d_non_occupational:"Please select agree or not agree.",
                d_waiver:"Please select agree or not agree.",
                casual_labourer:"Please select agree or not agree.",
                d_emergency_evacuation:"Please select agree or not agree.",
                defence_cost:"Please select yes or no.",
                d_defence_cost:"Please select agree or not agree.",
                d_employee_employee:"Please select agree or not agree.",
                d_cross_liability:"Please select agree or not agree.",
                d_loss_notification:"Please select agree or not agree",
                d_brokers_claim:"Please select agree or not agree",
                d_employees_employment:"Please select agree or not agree",
                d_occupational_industrial:"Please select agree or not agree",
                d_cancellation_clause:"Please select agree or not agree",
                d_indemnity_principal:"Please select agree or not agree",
                d_work_accidents:"Please select agree or not agree",
                d_primary_insurance:"Please select agree or not agree",
                d_travelling:"Please select agree or not agree",
                d_riot_strikes:"Please select agree or not agree",
                d_ommisions:"Please select agree or not agree",
                d_offshore:"Please select agree or not agree",
                employeeclause:"Please select agree or not agree",
                d_automatic_addition:"Please select agree or not agree",
                rate_admin:"Please enter a valid rate",
                rate_nadmin:"Please enter a valid rate",
                combined_rate:"Please enter a valid rate",
                brokerage:"Please enter a valid brokerage",
                warranty:"Please enter the warranty",
                exclusion:"Please enter the exclusion",
                special_condition:"Please enter the special condition",
                other_liability:"Please enter a valid liability",
                other_medical_expense:"Please enter a valid medical expense",
                other_repatriation_expenses:"Please enter a valid repatriation expenses."

            },
            errorPlacement: function (error, element)
            {
                if(element.attr('name')=='scale'){
                    error.insertAfter(element.parent().parent().parent().parent());
                    scrolltop();
                }
                else if(element.attr('name')=='rate_admin' || element.attr('name')=='rate_nadmin' || element.attr('name')=='combined_rate' || element.attr('name')=='brokerage' || element.attr('name')=='warranty' || element.attr('name')=='exclusion' || element.attr('name')=='special_condition'
                    || element.attr('name')=='other_liability' || element.attr('name')=='other_medical_expense'  || element.attr('name')=='other_repatriation_expenses') {
                    error.insertAfter(element);
                    scrolltop();
                }
                // else if(element.attr('name')=='select_liability' || element.attr('name')=='medical_expense' || element.attr('name')=='repatriation_expenses')
                // {
                //     error.insertAfter(element.parent());
                // }
                else{
                    error.insertAfter(element.parent().parent());
                }
            },
//            invalidHandler: function(form, validator) {
//                validator.errorList[0].element.focus();
//            },
            submitHandler: function (form,event) {
                var form_data = new FormData($("#e-quotation-form")[0]);
                $('#preLoader').fadeIn('slow');
                $.ajax({
                    method: 'post',
                    url: '{{url('insurer/save')}}',
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
            $('#preLoader').fadeIn('slow');
            $.ajax({
                method: 'post',
                url: '{{url('insurer/save-exit')}}',
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
    </script>
@endpush


