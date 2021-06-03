
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
    {{-- <link rel="stylesheet" href="{{ URL::asset('css/main/main.css')}}"><!-- Main CSS --> --}}
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
                                        <tr>
                                            <td class="main_question"><label class="form_label bold">Employer’s extended liability under Common Law/Shariah Law </label></td>
                                            <td>{{$insures_details['extendedLiability']}}</td>
                                        </tr>
                                        @if($pipeline_details['formData']['emergencyEvacuation']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label">
                                                        Emergency evacuation following work related accident
                                                    </label>
                                                </td>
                                                <td>{{$insures_details['emergencyEvacuation']}}</td>
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
                                        @if($pipeline_details['formData']['waiverOfSubrogation']==true)
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
                                        @endif
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
  <td class="main_question"><label class="form_label bold">EXCESS</label></td>
  <td>{{$insures_details['excess']}}</td>
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
        @import url('https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900,900');
        body{
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Roboto', sans-serif;
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
            /* border-bottom:none !important; */
        }
        .main_question{
            /* width: 400px !important; */
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
            /* height: 10px !important; */
            padding: 0 10px !important;
            text-align: left;
        }
        table{
            width: 100%;
        }
        div.material-table table th{
            /* height: 10px !important; */
        }
    
        html, body, .layout_content {
            height: auto;
        }
    
        thead { display: table-header-group; }
        tr { page-break-inside: avoid; }
    
        div.material-table {
            padding: 0;
        }
    
        div.material-table .hiddensearch {
            padding: 0 14px 0 24px;
            border-bottom: solid 1px #DDDDDD;
            display: none;
        }
    
        div.material-table .hiddensearch input {
            margin: 0;
            border: transparent 0 !important;
            height: 48px;
            color: rgba(0, 0, 0, .84);
        }
    
        div.material-table .hiddensearch input:active {
            border: transparent 0 !important;
        }
    
        div.material-table table {
            /*table-layout: fixed;*/
        }
    
    
        div.material-table table tr td {
            padding: 5px 0 5px 56px;
            /* height: 20px !important; */
            font-size: 12px;
            color: rgba(0, 0, 0, 1);
            border-bottom: solid 1px #DDDDDD;
            /*white-space: nowrap;*/
            /*overflow: hidden;*/
            /*text-overflow: ellipsis;*/
            line-height: 20px;
            font-weight: 600;
        }
    
        div.material-table table tr td a {
            color: inherit;
        }
    
        div.material-table table tr td a i {
            font-size: 18px;
            color: rgba(0, 0, 0, 0.54);
        }
    
        div.material-table table tr {
            font-size: 12px;
        }
    
        div.material-table table th {
            font-size: 11px;
            font-weight: 600;
            color: #707477;
            /*cursor: pointer;*/
            /* white-space: nowrap; */
            padding: 0;
            height: 44px;
            padding-left: 56px;
            vertical-align: middle;
            outline: none !important;
        }
    
        div.material-table table th.sorting_asc,
        div.material-table table th.sorting_desc {
            color: rgba(0, 0, 0, 0.87);
        }
    
        div.material-table table th.sorting:hover:after,
        div.material-table table th.sorting_asc:after,
        div.material-table table th.sorting_desc:after {
            display: inline-block;
        }
    
        div.material-table table th.sorting_desc:after {
            content: "arrow_forward";
        }
    
        div.material-table table tbody tr:hover {
            background-color: #EEE;
        }
        div.material-table table tbody tr:focus {
            background-color: #EEE;
        }
    
        div.material-table table th:first-child,
        div.material-table table td:first-child {
            padding: 0 0 0 24px;
        }
    
        div.material-table table th:last-child,
        div.material-table table td:last-child {
            padding-right: 24px !important;
        }
        .data_table{
            margin-bottom: 78px;
        }
        .data_table .material-table{
            margin: 0;
            background-color: #fff;
        }
        .dataTable{
            width: 100% !important;
        }
        div.material-table table thead tr {
            font-size: 12px;
            border-bottom: 1px solid #dadada;
            text-transform: uppercase;
            font-weight: 600;
        }
        div.material-table table td {
            font-weight: 500;
        }
        .div.material-table th {
            padding: 10px 20px !important;
        }
        .material-table {
            width: 100%;
        }
        .table-responsive td{
            max-width: 400px;
        }
        img{
            width: 100%;
        }
        .customer_header{
            width: 100%;
        }
        .customer_logo{
            width: 140px;
            float: right;
            margin-bottom: 18px;
        }
        .customer_info{
            width: 100%;
            margin-bottom: 0;
            background: #eceef3;
        }
        .customer_info p{
            margin: 0;
            font-size: 12px;
            font-weight: 500;
            color: #3e4a56;
        }
        .customer_info p b{
            color: #000;
        }
    
        .customer_header{
            width: 100%;
        }
        .customer_logo{
            width: 140px;
            float: right;
            margin-bottom: 18px;
        }
        .customer_info{
            width: 100%;
            margin-bottom: 0;
            background: #eceef3;
        }
        .customer_info p{
            margin: 0;
            font-size: 12px;
            font-weight: 500;
            color: #3e4a56;
        }
        .customer_info p b{
            color: #000;
        }
        .customer_header > h2{
            font-size: 23px;
            font-weight: 400;
            color: #9c27b0;
            border-left: 6px solid;
            padding: 0 0 0 12px;
            line-height: normal;
            float: left;
            margin: 22px 0;
        }
        .card_table th {
            font-size: 12px;
            color: #4f5a7b;
            text-align: left;
        }
        .card_table td {
            font-size: 12px;
            color: #181818;
            text-align: left;
            padding: 0.75rem !important;
        }
    
        .form_label {
            display: block;
            font-size: 11px;
            color: #264cd8;
            margin-bottom: 2px;
            text-transform: uppercase;
            font-weight: 700;
        }
</style>

</body>