
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Interactive Insurance Brokers LLC</title>

    {{--    <link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css')}}"><!-- Bootstrap CSS -->--}}
    {{--    <link rel="stylesheet" href="{{ URL::asset('css/main/normalize.css')}}"><!-- Normalize CSS -->--}}
    {{--<link rel="stylesheet" href="http://fonts.googleapis.com/icon?family=Material+Icons" /><!-- Material Icons CSS -->--}}
    {{--<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css"><!-- Font Awesome CSS -->--}}
    {{--    <link rel="stylesheet" href="{{ URL::asset('css/main/material-kit.css?v=2.0.3')}}" /><!-- Material Kit CSS -->--}}
    {{--    <link rel="stylesheet" href="{{ URL::asset('css/main/bootstrap-select.css')}}" />--}}
    {{--    <link rel="stylesheet" href="{{ URL::asset('css/main/fancy_fileupload.css')}}" /><!-- Fancy FileUpload CSS -->--}}
    <link rel="stylesheet" href="{{ URL::asset('css/main/main.css')}}"><!-- Main CSS -->
</head>
<body>

<main class="layout_content">

    <!-- Main Content -->
    <div class="page_content pdf_view">
        <div class="section_details">
            <div class="card_content">
                <div class="edit_sec clearfix">
                    <input type="hidden" id="pipeline_id" name="pipeline_id" value="{{$pipeline_details->_id}}">
                    <div class="data_table compare_sec">
                        <div id="admin">

                            <div class="customer_header clearfix">
                                <div class="customer_logo">
                                    <img src="{{URL::asset('img/main/interactive_logo.png')}}">
                                </div>
                                <h2>Reply for e-quotation</h2>

                                <table class="customer_info table table-bordered">
                                    <tr>
                                        <td height="20" style="border-right: 1px solid #ddd"><p>Prepared for : <b>{{$pipeline_details['customer']['name']}}</b></p></td>
                                        <td height="20" style="border-right: 1px solid #ddd"><p>Customer ID : <b>{{$pipeline_details['customer']['customerCode']}}</b></p></td>
                                        <td height="20" style="border-right: 1px solid #ddd"><p>Prepared by : <b>{{$insures_details['insurerDetails']['insurerName']}}</b></p></td>
                                        <td height="20" style="border-right: 1px solid #ddd"><p>Date : <b>{{date('d/m/Y')}}</b></p></td>
                                    </tr>
                                </table>

                            </div>

                            <div class="material-table table-responsive">
                                <div class="table-header" style="height: 15px;padding: 8px 10px">
                                    <span class="table-title">E-Comparison</span>
                                </div>
                                <div class="table-responsive">
                                    <table class="comparison table table-bordered" cellpadding="0" cellspacing="0">
                                        <thead>
                                        <tr>
                                            <th class="main_question" style="text-align: left;border-bottom: 2px solid #000">Questions</th>
                                            <th>{{$insures_details['insurerDetails']['insurerName']}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(isset($pipeline_details['formData']['scaleOfCompensation']))
                                            @if($pipeline_details['formData']['scaleOfCompensation']['asPerUAELaw']==true)
                                                <?php $scale='As per UAE Labour Law';?>
                                            @elseif($pipeline_details['formData']['scaleOfCompensation']['isPTD']==true)
                                                <?php $scale='Death/Permanent Total Disability (PTD) Benefit increased to AED 50,000/- for those monthly salary is not more than AED 2,000/- and AE 75,000/- for those whose monthly salary is AED 2,000/- or more';?>
                                            @endif
                                        @endif
                                        <tr>
                                            <td class="main_question"><label class="form_label bold">Scale of Compensation /Limit of Indemnity<br></label></td>
                                            <td>{{$scale}}</td>
                                        </tr>
                                        <tr>
                                            <td class="main_question"><label class="form_label bold">Employer’s extended liability under Common Law/Shariah Law </label></td>
                                            <td>{{number_format($insures_details['extendedLiability'],2)}}</td>
                                        </tr>
                                        <tr>
                                            <td class="main_question"><label class="form_label bold">Medical Expense (In AED) </label></td>
                                            <td>@if(is_numeric($insures_details['medicalExpense'])==true) {{number_format($insures_details['medicalExpense'])}} @else {{$insures_details['medicalExpense']}}@endif</td>
                                        </tr>
                                        <tr>
                                            <td class="main_question"><label class="form_label bold">Repatriation Expenses (Repatriation of mortal remains or injured employee to his/her home country on medical advice) including  expenses of an accompanying person </label></td>
                                            <td>@if(is_numeric($insures_details['repatriationExpenses'])==true) {{number_format($insures_details['repatriationExpenses'])}} @else {{$insures_details['repatriationExpenses']}}@endif</td>
                                        </tr>
                                        @if($pipeline_details['formData']['HoursPAC']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">
                                                        24 hours non-occupational personal accident cover – in UAE and home country benefits as per UAE Labour Law
                                                    </label></td>
                                                @if(isset($insures_details['HoursPAC']['isAgree']))
                                                    @if($insures_details['HoursPAC']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['HoursPAC']['isAgree']}}
                                                                <br>Comments : {{$insures_details['HoursPAC']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['HoursPAC']['isAgree']}}</td>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endif
                                        @if($pipeline_details['formData']['herniaCover']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Cover for hernia, heat/sun stroke, muscle spasm, muscle strain, lumbago related to work</label></td>
                                                @if(isset($insures_details['herniaCover']['comment']))
                                                    @if($insures_details['herniaCover']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['herniaCover']['isAgree']}}
                                                                <br>Comments : {{$insures_details['herniaCover']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['herniaCover']['isAgree']}}</td>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endif
                                        @if($pipeline_details['formData']['emergencyEvacuation']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label">
                                                        Emergency evacuation
                                                    </label>
                                                </td>
                                                <td>{{$insures_details['emergencyEvacuation']}}</td>
                                            </tr>
                                        @endif
                                        @if($pipeline_details['formData']['legalCost']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Including Legal and Defence cost </label></td>
                                                <td>{{$insures_details['legalCost']}}</td>
                                            </tr>
                                        @endif
                                        @if($pipeline_details['formData']['empToEmpLiability']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Employee to employee liability </label></td>
                                                <td>{{$insures_details['empToEmpLiability']}}</td>
                                            </tr>
                                        @endif
                                        @if($pipeline_details['formData']['errorsOmissions']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">ERRORS & OMISSIONS</label></td>
                                                <td>{{$insures_details['errorsOmissions']}}</td>
                                            </tr>
                                        @endif
                                        @if($pipeline_details['formData']['crossLiability']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">CROSS LIABILITY</label></td>
                                                <td>{{$insures_details['crossLiability']}}</td>
                                            </tr>
                                        @endif
                                        @if(isset($pipeline_details['formData']['waiverOfSubrogation']))
                                        {{-- @if($pipeline_details['formData']['waiverOfSubrogation']==true) --}}
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">WAIVER OF SUBROGATION</label></td>
                                                @if(isset($insures_details['waiverOfSubrogation']))
                                                    @if($insures_details['waiverOfSubrogation']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['waiverOfSubrogation']['isAgree']}}
                                                                <br> Comments : {{$insures_details['waiverOfSubrogation']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['waiverOfSubrogation']['isAgree']}}</td>
                                                    @endif
                                                @endif
                                            </tr>
                                        {{-- @endif --}}
                                        @endif
                                        @if($pipeline_details['formData']['automaticClause']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">AUTOMATIC ADDITION & DELETION CLAUSE</label></td>
                                                @if(isset($insures_details['automaticClause']['comment']))
                                                    @if($insures_details['automaticClause']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['automaticClause']['isAgree']}}
                                                                <br>Comments : {{$insures_details['automaticClause']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['automaticClause']['isAgree']}}</td>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endif
                                        @if($pipeline_details['formData']['flightCover']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">COVER FOR INSURED’S EMPLOYEES ON EMPLOYMENT VISAS WHILST ON INCOMING AND OUTGOING FLIGHTS TO/FROM UAE</label></td>
                                                <td>{{$insures_details['flightCover']}}</td>
                                            </tr>
                                        @endif
                                        @if($pipeline_details['formData']['diseaseCover']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">COVER FOR OCCUPATIONAL/ INDUSTRIAL DISEASE AS PER LABOUR LAW</label></td>
                                                <td>{{$insures_details['diseaseCover']}}</td>
                                            </tr>
                                        @endif
                                        @if($pipeline_details['formData']['cancellationClause']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">CANCELLATION CLAUSE-30 DAYS BY EITHER SIDE ON PRO-RATA</label></td>
                                                <td>{{$insures_details['cancellationClause']}}</td>
                                            </tr>
                                        @endif
                                        @if(isset($pipeline_details['formData']['indemnityToPrincipal']))
                                        @if($pipeline_details['formData']['indemnityToPrincipal']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">INDEMNITY TO PRINCIPAL</label></td>
                                                <td>{{$insures_details['indemnityToPrincipal']}}</td>
                                            </tr>
                                        @endif
                                        @endif
                                        @if($pipeline_details['formData']['overtimeWorkCover']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">INCLUDING WORK RELATED ACCIDENTS AND BODILY INJURIES DURING OVERTIME WORK, NIGHT SHIFTS, WORK ON PUBLIC HOLIDAYS AND WEEK-ENDS.</label></td>
                                                <td>{{$insures_details['overtimeWorkCover']}}</td>
                                            </tr>
                                        @endif
                                        @if($pipeline_details['formData']['lossNotification']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">LOSS NOTIFICATION – ‘AS SOON AS REASONABLY PRACTICABLE’</label></td>
                                                @if(isset($insures_details['lossNotification']))
                                                    @if($insures_details['lossNotification']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['lossNotification']['isAgree']}}
                                                                <br>Comments : {{$insures_details['lossNotification']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['lossNotification']['isAgree']}}</td>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endif
                                        @if($pipeline_details['formData']['primaryInsuranceClause']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">PRIMARY INSURANCE CLAUSE</label></td>
                                                <td>{{$insures_details['primaryInsuranceClause']}}</td>
                                            </tr>
                                        @endif
                                        @if($pipeline_details['formData']['travelCover']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">TRAVELLING TO AND FROM WORKPLACE</label></td>
                                                <td>{{$insures_details['travelCover']}}</td>
                                            </tr>
                                        @endif
                                        @if($pipeline_details['formData']['riotCover']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">RIOT, STRIKES, CIVIL COMMOTION AND PASSIVE WAR RISK</label></td>
                                                <td>{{$insures_details['riotCover']}}</td>
                                            </tr>
                                        @endif
                                        @if($pipeline_details['formData']['brokersClaimClause']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">BROKERS CLAIM HANDLING CLAUSE : A LOSS NOTIFICATION RECEIVED BY THE INSURANCE BROKER WILL BE DEEMED AS A LOSS NOTIFICATION TO INSURER. ALL COMMUNICATIONS FLOWING BETWEEN THE INSURER, INSURED AND THE APPOINTED LOSS SURVEYOR SHOULD BE CHANNELIZED THROUGH THE BROKER, UNLESS THERE IS ANY UNAVOIDABLE REASONS COMPELLING DIRECT COMMUNICATIONS BETWEEN THE PARTIES</label></td>
                                                @if(isset($insures_details['brokersClaimClause']))
                                                    @if($insures_details['brokersClaimClause']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['brokersClaimClause']['isAgree']}}
                                                                <br>Comments : {{$insures_details['brokersClaimClause']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['brokersClaimClause']['isAgree']}}</td>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endif
                                        @if(isset($pipeline_details['formData']['hiredCheck']))
                                        @if($pipeline_details['formData']['hiredCheck']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">EMPLOYMENT CLAUSE</label></td>
                                                <td>{{$insures_details['hiredCheck']}}</td>
                                            </tr>
                                        @endif
                                        @endif
@if(isset($pipeline_details['formData']['offshoreCheck']))
@if($pipeline_details['formData']['offshoreCheck']==true)
  <tr>
      <td class="main_question"><label class="form_label bold">COVER FOR OFFSHORE EMPLOYEE</label></td>
      <td>{{$insures_details['offshoreCheck']}}</td>
  </tr>
@endif
@endif
@if(isset($pipeline_details['formData']['sepOrCom']) &&$pipeline_details['formData']['sepOrCom']==true)
  <tr>
      <td class="main_question"><label class="form_label bold">RATE REQUIRED (ADMIN)</label></td>
      <td>{{$insures_details['rateRequiredAdmin']}}</td>
  </tr>
@endif
@if(isset($pipeline_details['formData']['sepOrCom']) &&$pipeline_details['formData']['sepOrCom']==true)
  <tr>
      <td class="main_question"><label class="form_label bold">RATE REQUIRED (NON-ADMIN)</label></td>
      <td>{{$insures_details['rateRequiredNonAdmin']}}</td>

  </tr>
@endif
@if(isset($pipeline_details['formData']['sepOrCom']) &&$pipeline_details['formData']['sepOrCom']==false)
<tr>
  <td class="main_question"><label class="form_label bold">COMBINED RATE</label></td>
  <td>{{$insures_details['combinedRate']}}</td>
</tr>
@endif
<tr>
  <td class="main_question"><label class="form_label bold">WARRANTY</label></td>
  <td>{{$insures_details['warranty']}}</td>
</tr>
<tr>
  <td class="main_question"><label class="form_label bold">EXCLUSION</label></td>
  <td>{{$insures_details['exclusion']}}</td>
</tr>
<tr>
  <td class="main_question"><label class="form_label bold">SPECIAL CONDITION </label></td>
  <td>{{$insures_details['specialCondition']}}</td>
</tr>
</tbody>

</table>
</div>
</div>
<p class="Info" style="font-size: 13px;font-weight: 500;font-style: italic;margin-bottom: 15px">IMPORTANT: This document is the property of INTERACTIVE Insurance Brokers LLC, Dubai and is
strictly confidential to its recipients. The document should not be copied, distributed or
reproduced in whole or in part, nor passed to any third party without the consent of its owner.
</p>
</div>
</div>
</div>
</div>
</div>
</div>
</main>

<style>
body{
margin: 0;
padding: 0;
background-color: #fff !important;
}
.section_details{
max-width: 100%;
box-shadow: none;
margin-bottom: 0 !important;
}
.customer_info p{
margin-left: 8px;
}
.comparison th,
.comparison td{
padding: 4px 8px !important;
border: 1px solid #ddd !important;
line-height: 18px !important;
}
.comparison th,
.comparison td{
border-bottom:none !important;
}
.main_question{
width: 400px !important;
}
.page_content{
padding: 0 !important;
margin: 0;
}
.customer_logo{
width: 100px;
}
.customer_header > h2 {
font-size: 20px;
margin: 14px 0;
}
.section_details .card_content {
padding: 15px;
}
.form_label {
font-size: 11px;
}
.comparison th{
height: 10px !important;
padding: 0 !important;
text-align: left;
}
div.material-table table th{
height: 10px !important;
}
</style>

</body>