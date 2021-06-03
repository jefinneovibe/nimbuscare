
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
                                <h2>Proposal for Workman’s Compensation</h2>
                                    <table class="customer_info table table-bordered" style="border: black solid">
                                        <tr>
                                            <td height="20" style="border-right: 1px solid #ddd"><p style="font-size: 15px">Prepared for : <b>{{$pipeline_details['customer']['name']}}</b></p></td>
                                            <td height="20" style="border-right: 1px solid #ddd"><p style="font-size: 15px">Customer ID : <b>{{$pipeline_details['customer']['customerCode']}}</b></p></td>
                                        </tr>
                                        <tr>
                                            <td height="20" style="border-right: 1px solid #ddd"><p style="font-size: 15px">Prepared by : <b>INTERACTIVE Insurance Brokers LLC</b></p></td>
                                            @if(isset($pipeline_details['comparisonToken']['date']))
                                                <td height="20" style="border-right: 1px solid #ddd"><p style="font-size: 15px">Date : <b>{{$pipeline_details['comparisonToken']['date']}}</b></p></td>
                                            @else
                                                <td height="20" style="border-right: 1px solid #ddd"><p style="font-size: 15px">Date : <b>{{date('d/m/Y')}}</b></p></td>
                                            @endif
                                            <td height="20" style="border-right: 1px solid #ddd"><p style="font-size: 15px">Document ID : <b>{{$pipeline_details['refereneceNumber']}} –
                                                        @if(isset($pipeline_details['documentNo']))
                                                            R{{$pipeline_details['documentNo']}}
                                                        @else
                                                            R0
                                                        @endif
                                                        </b></p></td>
                                        </tr>
                                    </table>
                                </div>
                            <div style="height: 50px"></div>
                            <div class="material-table table-responsive">
                                <div class="table-responsive">
                                    <table class="comparison table table-bordered" cellpadding="0" cellspacing="0">
                                        <thead>
                                        <tr>
                                            <th class="main_question" style="text-align: left;border-bottom: 2px solid #000">Questions</th>
                                            {{--<th class="main_answer">Customer Response</th>--}}
											<?php $selected_insures_count=count($selectedId);?>
											<?php $insure_count=count(@$insures_details);?>
                                            @for ($i = 0; $i < $insure_count; $i++)
                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))<th style="text-align: left"> {{$insures_details[$i]['insurerDetails']['insurerName']}}
                                                </th>@endif
                                            @endfor
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            @if(isset($pipeline_details['formData']['scaleOfCompensation']))
                                                @if($pipeline_details['formData']['scaleOfCompensation']['asPerUAELaw']==true)
                                                    <?php $scale='As per UAE Labour Law';?>
                                                @elseif($pipeline_details['formData']['scaleOfCompensation']['isPTD']==true)
                                                    <?php $scale='Death/Permanent Total Disability (PTD) Benefit increased to AED 50,000/- for those monthly salary is not more than AED 2,000/- and AE 75,000/- for those whose monthly salary is AED 2,000/- or more';?>
                                                @endif
                                            @endif
                                            <td class="main_question"><label class="form_label bold">Scale of Compensation /Limit of Indemnity<br>{{$scale}}</label></td>
                                            {{--<td class="main_answer">{{$scale}}</td>--}}
                                            @for ($i = 0; $i < $insure_count; $i++)
                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                    <td>{{$insures_details[$i]['scaleOfCompensation']}}</td>
                                                @endif
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td class="main_question"><label class="form_label bold">Employer’s extended liability under Common Law/Shariah Law </label></td>
                                            {{--<td class="main_answer">{{$pipeline_details['formData']['extendedLiability']}}</td>--}}
                                            @for ($i = 0; $i < $insure_count; $i++)
                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                    <td>{{$insures_details[$i]['extendedLiability']}}</td>
                                                @endif
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td class="main_question"><label class="form_label bold">Medical Expense (In AED) </label></td>
                                            {{--<td class="main_answer">{{$pipeline_details['formData']['medicalExpense']}}</td>--}}
                                            @for ($i = 0; $i < $insure_count; $i++)
                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                    <td>@if(is_numeric($insures_details[$i]['medicalExpense'])==true){{number_format($insures_details[$i]['medicalExpense'])}} @else {{$insures_details[$i]['medicalExpense']}}@endif</td>
                                                @endif
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td class="main_question"><label class="form_label bold">Repatriation Expenses (Repatriation of mortal remains or injured employee to his/her home country on medical advice) including  expenses of an accompanying person </label></td>
                                            {{--<td class="main_answer">{{$pipeline_details['formData']['repatriationExpenses']}}</td>--}}
                                            @for ($i = 0; $i < $insure_count; $i++)
                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                    <td>@if(is_numeric($insures_details[$i]['repatriationExpenses'])==true){{number_format($insures_details[$i]['repatriationExpenses'])}} @else {{$insures_details[$i]['repatriationExpenses']}}@endif</td>
                                                @endif
                                            @endfor
                                        </tr>
                                        @if($pipeline_details['formData']['hiredWorkersDetails']['hasHiredWorkers']==true)
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">COVER FOR HIRED WORKERS OR CASUAL LABOURS</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['coverHiredWorkers']['isAgree']))
                                                            @if($insures_details[$i]['coverHiredWorkers']['comment']!="")
                                                                <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['coverHiredWorkers']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['coverHiredWorkers']['comment']}}
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>{{$insures_details[$i]['coverHiredWorkers']['isAgree']}}</td>
                                                            @endif
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif
                                        @if($pipeline_details['formData']['offShoreEmployeeDetails']['hasOffShoreEmployees']==true)
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">COVER FOR OFFSHORE EMPLOYEES</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['coverOffshore']['isAgree']))
                                                            @if($insures_details[$i]['coverOffshore']['comment']!="")
                                                                <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['coverOffshore']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['coverOffshore']['comment']}}
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>{{$insures_details[$i]['coverOffshore']['isAgree']}}</td>
                                                            @endif
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif
                                        @if($pipeline_details['formData']['HoursPAC']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">
                                                        24 hours non-occupational personal accident cover – in UAE and home country benefits as per UAE Labour Law
                                                        </label></td>
                                                @if(isset($pipeline_details['formData']['HoursPAC']))
                                                    @if($pipeline_details['formData']['HoursPAC']==true)
                                                        <?php $HoursPAC='Yes';?>
                                                    @else
                                                        <?php $HoursPAC='No';?>
                                                    @endif
                                                @endif
                                                {{--<td class="main_answer">{{$HoursPAC}}</td>--}}
                                                @if($HoursPAC=='Yes')
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['HoursPAC']['isAgree']))
                                                                @if($insures_details[$i]['HoursPAC']['comment']!="")
                                                                    <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['HoursPAC']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['HoursPAC']['comment']}}
                                                                    </span>
                                                                    </td>
                                                                @else
                                                                    <td>{{$insures_details[$i]['HoursPAC']['isAgree']}}</td>
                                                                @endif
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                @else
                                                    @for($j=0;$j<$selected_insures_count;$j++)
                                                        <td>--</td>
                                                    @endfor
                                                @endif
                                            </tr>
                                        @endif
                                        @if($pipeline_details['formData']['herniaCover']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Cover for hernia, heat/sun stroke, muscle spasm, muscle strain, lumbago related to work</label></td>
                                                @if(isset($pipeline_details['formData']['herniaCover']))
                                                    @if($pipeline_details['formData']['herniaCover']==true)
                                                        <?php $herniaCover='Yes';?>
                                                    @else
                                                        <?php $herniaCover='No';?>
                                                    @endif
                                                @endif
                                                {{--<td class="main_answer">{{$herniaCover}}</td>--}}
                                                @if($herniaCover=='Yes')
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['herniaCover']['comment']))

                                                                @if($insures_details[$i]['herniaCover']['comment']!="")
                                                                    <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['herniaCover']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['herniaCover']['comment']}}
                                                                    </span>
                                                                    </td>
                                                                @else
                                                                    <td>{{$insures_details[$i]['herniaCover']['isAgree']}}</td>
                                                                @endif
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                @else
                                                    @for($j=0;$j<$selected_insures_count;$j++)
                                                        <td>--</td>
                                                    @endfor
                                                @endif

                                            </tr>
                                        @endif
                                        @if($pipeline_details['formData']['emergencyEvacuation']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label">
                                                        Emergency evacuation
                                                    </label></td>
                                                @if(isset($pipeline_details['formData']['emergencyEvacuation']))
                                                    @if($pipeline_details['formData']['emergencyEvacuation']==true)
                                                        <?php $emergencyEvacuation='Yes';?>
                                                    @else
                                                        <?php $emergencyEvacuation='No';?>
                                                    @endif
                                                @endif
                                                {{--<td class="main_answer">{{$emergencyEvacuation}}</td>--}}
                                                @if($emergencyEvacuation=='Yes')
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['emergencyEvacuation']))

                                                                <td>{{$insures_details[$i]['emergencyEvacuation']}}</td>
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                @else
                                                    @for($j=0;$j<$selected_insures_count;$j++)
                                                        <td>--</td>
                                                    @endfor
                                                @endif

                                            </tr>
                                        @endif
                                        @if($pipeline_details['formData']['legalCost']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Including Legal and Defence cost </label></td>
                                                @if(isset($pipeline_details['formData']['legalCost']))
                                                    @if($pipeline_details['formData']['legalCost']==true)
                                                        <?php $legalCost='Yes';?>
                                                    @else
                                                        <?php $legalCost='No';?>
                                                    @endif
                                                @endif
                                                {{--<td class="main_answer">{{$legalCost}}</td>--}}

                                                @if($legalCost=='Yes')
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['legalCost']))

                                                                <td>{{$insures_details[$i]['legalCost']}}</td>
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                @else
                                                    @for($j=0;$j<$selected_insures_count;$j++)
                                                        <td>--</td>
                                                    @endfor
                                                @endif

                                            </tr>
                                        @endif
                                        @if($pipeline_details['formData']['empToEmpLiability']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Employee to employee liability </label></td>
                                                @if(isset($pipeline_details['formData']['empToEmpLiability']))
                                                    @if($pipeline_details['formData']['empToEmpLiability']==true)
                                                        <?php $empToEmpLiability='Yes';?>
                                                    @else
                                                        <?php $empToEmpLiability='No';?>
                                                    @endif
                                                @endif
                                                {{--<td class="main_answer">{{$empToEmpLiability}}</td>--}}
                                                @if($empToEmpLiability=='Yes')
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['empToEmpLiability']))

                                                                <td>{{$insures_details[$i]['empToEmpLiability']}}</td>
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                @else
                                                    @for($j=0;$j<$selected_insures_count;$j++)
                                                        <td>--</td>
                                                    @endfor
                                                @endif

                                            </tr>
                                        @endif
                                        @if($pipeline_details['formData']['errorsOmissions']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">ERRORS & OMISSIONS</label></td>
                                                @if(isset($pipeline_details['formData']['errorsOmissions']))
                                                    @if($pipeline_details['formData']['errorsOmissions']==true)
                                                        <?php $errorsOmissions='Yes';?>
                                                    @else
                                                        <?php $errorsOmissions='No';?>
                                                    @endif
                                                @endif
                                                {{--<td class="main_answer">{{$errorsOmissions}}</td>--}}

                                                @if($errorsOmissions=='Yes')
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['errorsOmissions']))
                                                                <td>{{$insures_details[$i]['errorsOmissions']}}</td>
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                @else
                                                    @for($j=0;$j<$selected_insures_count;$j++)
                                                        <td>--</td>
                                                    @endfor
                                                @endif
                                            </tr>
                                        @endif
                                        @if($pipeline_details['formData']['crossLiability']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">CROSS LIABILITY</label></td>
                                                @if(isset($pipeline_details['formData']['crossLiability']))
                                                    @if($pipeline_details['formData']['crossLiability']==true)
                                                        <?php $crossLiability='Yes';?>
                                                    @else
                                                        <?php $crossLiability='No';?>
                                                    @endif
                                                @endif
                                                {{--<td class="main_answer">{{$crossLiability}}</td>--}}

                                                @if($crossLiability=='Yes')
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['crossLiability']))

                                                                <td>{{$insures_details[$i]['crossLiability']}}</td>
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                @else
                                                    @for($j=0;$j<$selected_insures_count;$j++)
                                                        <td>--</td>
                                                    @endfor
                                                @endif
                                            </tr>
                                        @endif
                                        @if(isset($pipeline_details['formData']['waiverOfSubrogation']))
                                        {{-- @if($pipeline_details['formData']['waiverOfSubrogation']==true) --}}
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">WAIVER OF SUBROGATION</label></td>
                                                @if(isset($pipeline_details['formData']['waiverOfSubrogation']))
                                                    {{-- @if($pipeline_details['formData']['waiverOfSubrogation']==true) --}}
                                                        <?php $waiverOfSubrogation='Yes';?>
                                                    {{-- @else
                                                    @endif --}}
                                                @endif
                                                {{--<td class="main_answer">{{$waiverOfSubrogation}}</td>--}}
                                                @if($waiverOfSubrogation=='Yes')
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['waiverOfSubrogation']))

                                                                @if($insures_details[$i]['waiverOfSubrogation']['comment']!="")
                                                                    <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['waiverOfSubrogation']['isAgree']}}
                                                                        <br> Comments : {{$insures_details[$i]['waiverOfSubrogation']['comment']}}
                                                                    </span>
                                                                    </td>
                                                                @else
                                                                    <td>{{$insures_details[$i]['waiverOfSubrogation']['isAgree']}}</td>
                                                                @endif
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                @else
                                                    @for($j=0;$j<$selected_insures_count;$j++)
                                                        <td>--</td>
                                                    @endfor
                                                @endif
                                            </tr>
                                        {{-- @endif --}}
                                        @endif
                                        @if($pipeline_details['formData']['automaticClause']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">AUTOMATIC ADDITION & DELETION CLAUSE</label></td>
                                                @if(isset($pipeline_details['formData']['automaticClause']))
                                                    @if($pipeline_details['formData']['automaticClause']==true)
                                                        <?php $automaticClause='Yes';?>
                                                    @else
                                                        <?php $automaticClause='No';?>
                                                    @endif
                                                @endif
                                                {{--<td class="main_answer">{{$automaticClause}}</td>--}}
                                                @if($automaticClause=='Yes')
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['automaticClause']['comment']))
                                                                @if($insures_details[$i]['automaticClause']['comment']!="")
                                                                    <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['automaticClause']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['automaticClause']['comment']}}
                                                                    </span>
                                                                    </td>
                                                                @else
                                                                    <td>{{$insures_details[$i]['automaticClause']['isAgree']}}</td>
                                                                @endif
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                @else
                                                    @for($j=0;$j<$selected_insures_count;$j++)
                                                        <td>--</td>
                                                    @endfor
                                                @endif
                                            </tr>
                                        @endif
                                        @if($pipeline_details['formData']['flightCover']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">COVER FOR INSURED’S EMPLOYEES ON EMPLOYMENT VISAS WHILST ON INCOMING AND OUTGOING FLIGHTS TO/FROM UAE</label></td>
                                                @if(isset($pipeline_details['formData']['flightCover']))
                                                    @if($pipeline_details['formData']['flightCover']==true)
                                                        <?php $flightCover='Yes';?>
                                                    @else
                                                        <?php $flightCover='No';?>
                                                    @endif
                                                @endif
                                                {{--<td class="main_answer">{{$flightCover}}</td>--}}

                                                @if($flightCover=='Yes')
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['flightCover']))
                                                                <td>{{$insures_details[$i]['flightCover']}}</td>
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                @else
                                                    @for($j=0;$j<$selected_insures_count;$j++)
                                                        <td>--</td>
                                                    @endfor
                                                @endif
                                            </tr>
                                        @endif
                                        @if($pipeline_details['formData']['diseaseCover']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">COVER FOR OCCUPATIONAL/ INDUSTRIAL DISEASE AS PER LABOUR LAW</label></td>
                                                @if(isset($pipeline_details['formData']['diseaseCover']))
                                                    @if($pipeline_details['formData']['diseaseCover']==true)
                                                        <?php $diseaseCover='Yes';?>
                                                    @else
                                                        <?php $diseaseCover='No';?>
                                                    @endif
                                                @endif
                                                {{--<td class="main_answer">{{$diseaseCover}}</td>--}}

                                                @if($diseaseCover=='Yes')
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['diseaseCover']))

                                                                <td>{{$insures_details[$i]['diseaseCover']}}</td>
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                @else
                                                    @for($j=0;$j<$selected_insures_count;$j++)
                                                        <td>--</td>
                                                    @endfor
                                                @endif
                                            </tr>
                                        @endif
                                        @if($pipeline_details['formData']['cancellationClause']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">CANCELLATION CLAUSE-30 DAYS BY EITHER SIDE ON PRO-RATA</label></td>
                                                @if(isset($pipeline_details['formData']['cancellationClause']))
                                                    @if($pipeline_details['formData']['cancellationClause']==true)
                                                        <?php $cancellationClause='Yes';?>
                                                    @else
                                                        <?php $cancellationClause='No';?>
                                                    @endif
                                                @endif
                                                {{--<td class="main_answer">{{$cancellationClause}}</td>--}}
                                                @if($cancellationClause=='Yes')
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['cancellationClause']))
                                                                <td>{{$insures_details[$i]['cancellationClause']}}</td>
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                @else
                                                    @for($j=0;$j<$selected_insures_count;$j++)
                                                        <td>--</td>
                                                    @endfor
                                                @endif
                                            </tr>
                                        @endif
                                        @if(isset($pipeline_details['formData']['indemnityToPrincipal']))
                                        @if($pipeline_details['formData']['indemnityToPrincipal']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">INDEMNITY TO PRINCIPAL</label></td>
                                                @if(isset($pipeline_details['formData']['indemnityToPrincipal']))
                                                    @if($pipeline_details['formData']['indemnityToPrincipal']==true)
                                                        <?php $indemnityToPrincipal='Yes';?>
                                                    @else
                                                        <?php $indemnityToPrincipal='No';?>
                                                    @endif
                                                @endif
                                                {{--<td class="main_answer">{{$indemnityToPrincipal}}</td>--}}
                                                @if($indemnityToPrincipal=='Yes')
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['indemnityToPrincipal']))

                                                                <td>{{$insures_details[$i]['indemnityToPrincipal']}}</td>
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                @else
                                                    @for($j=0;$j<$selected_insures_count;$j++)
                                                        <td>--</td>
                                                    @endfor
                                                @endif
                                            </tr>
                                        @endif
                                        @endif
                                        @if($pipeline_details['formData']['overtimeWorkCover']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">INCLUDING WORK RELATED ACCIDENTS AND BODILY INJURIES DURING OVERTIME WORK, NIGHT SHIFTS, WORK ON PUBLIC HOLIDAYS AND WEEK-ENDS.</label></td>
                                                @if(isset($pipeline_details['formData']['overtimeWorkCover']))
                                                    @if($pipeline_details['formData']['overtimeWorkCover']==true)
                                                        <?php $overtimeWorkCover='Yes';?>
                                                    @else
                                                        <?php $overtimeWorkCover='No';?>
                                                    @endif
                                                @endif
                                                {{--<td class="main_answer">{{$overtimeWorkCover}}</td>--}}

                                                @if($overtimeWorkCover=='Yes')
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['overtimeWorkCover']))

                                                                <td>{{$insures_details[$i]['overtimeWorkCover']}}</td>
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                @else
                                                    @for($j=0;$j<$selected_insures_count;$j++)
                                                        <td>--</td>
                                                    @endfor
                                                @endif
                                            </tr>
                                        @endif
                                        @if($pipeline_details['formData']['lossNotification']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">LOSS NOTIFICATION – ‘AS SOON AS REASONABLY PRACTICABLE’</label></td>
                                                @if(isset($pipeline_details['formData']['lossNotification']))
                                                    @if($pipeline_details['formData']['lossNotification']==true)
                                                        <?php $lossNotification='Yes';?>
                                                    @else
                                                        <?php $lossNotification='No';?>
                                                    @endif
                                                @endif
                                                {{--<td class="main_answer">{{$lossNotification}}</td>--}}
                                                @if($lossNotification=='Yes')
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['lossNotification']))

                                                                @if($insures_details[$i]['lossNotification']['comment']!="")
                                                                    <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['lossNotification']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['lossNotification']['comment']}}
                                                                    </span>
                                                                    </td>
                                                                @else
                                                                    <td>{{$insures_details[$i]['lossNotification']['isAgree']}}</td>
                                                                @endif
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                @else
                                                    @for($j=0;$j<$selected_insures_count;$j++)
                                                        <td>--</td>
                                                    @endfor
                                                @endif
                                            </tr>
                                        @endif
                                        @if($pipeline_details['formData']['primaryInsuranceClause']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">PRIMARY INSURANCE CLAUSE</label></td>
                                                @if(isset($pipeline_details['formData']['primaryInsuranceClause']))
                                                    @if($pipeline_details['formData']['primaryInsuranceClause']==true)
                                                        <?php $primaryInsuranceClause='Yes';?>
                                                    @else
                                                        <?php $primaryInsuranceClause='No';?>
                                                    @endif
                                                @endif
                                                {{--<td class="main_answer">{{$primaryInsuranceClause}}</td>--}}

                                                @if($primaryInsuranceClause=='Yes')
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['primaryInsuranceClause']))

                                                                <td>{{$insures_details[$i]['primaryInsuranceClause']}}</td>
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                @else
                                                    @for($j=0;$j<$selected_insures_count;$j++)
                                                        <td>--</td>
                                                    @endfor
                                                @endif
                                            </tr>
                                        @endif
                                        @if($pipeline_details['formData']['travelCover']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">TRAVELLING TO AND FROM WORKPLACE</label></td>
                                                @if(isset($pipeline_details['formData']['travelCover']))
                                                    @if($pipeline_details['formData']['travelCover']==true)
                                                        <?php $travelCover='Yes';?>
                                                    @else
                                                        <?php $travelCover='No';?>
                                                    @endif
                                                @endif
                                                {{--<td class="main_answer">{{$travelCover}}</td>--}}

                                                @if($travelCover=='Yes')
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['travelCover']))
                                                                <td>{{$insures_details[$i]['travelCover']}}</td>
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                @else
                                                    @for($j=0;$j<$selected_insures_count;$j++)
                                                        <td>--</td>
                                                    @endfor
                                                @endif
                                            </tr>
                                        @endif
                                        @if($pipeline_details['formData']['riotCover']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">RIOT, STRIKES, CIVIL COMMOTION AND PASSIVE WAR RISK</label></td>
                                                @if(isset($pipeline_details['formData']['riotCover']))
                                                    @if($pipeline_details['formData']['riotCover']==true)
                                                        <?php $riotCover='Yes';?>
                                                    @else
                                                        <?php $riotCover='No';?>
                                                    @endif
                                                @endif
                                                {{--<td class="main_answer">{{$riotCover}}</td>--}}

                                                @if($riotCover=='Yes')
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['riotCover']))
                                                                <td>{{$insures_details[$i]['riotCover']}}</td>
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                @else
                                                    @for($j=0;$j<$selected_insures_count;$j++)
                                                        <td>--</td>
                                                    @endfor
                                                @endif
                                            </tr>
                                        @endif
                                        @if($pipeline_details['formData']['brokersClaimClause']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">BROKERS CLAIM HANDLING CLAUSE : A LOSS NOTIFICATION RECEIVED BY THE INSURANCE BROKER WILL BE DEEMED AS A LOSS NOTIFICATION TO INSURER. ALL COMMUNICATIONS FLOWING BETWEEN THE INSURER, INSURED AND THE APPOINTED LOSS SURVEYOR SHOULD BE CHANNELIZED THROUGH THE BROKER, UNLESS THERE IS ANY UNAVOIDABLE REASONS COMPELLING DIRECT COMMUNICATIONS BETWEEN THE PARTIES</label></td>
                                                @if(isset($pipeline_details['formData']['brokersClaimClause']))
                                                    @if($pipeline_details['formData']['brokersClaimClause']==true)
                                                        <?php $brokersClaimClause='Yes';?>
                                                    @else
                                                        <?php $brokersClaimClause='No';?>
                                                    @endif
                                                @endif
                                                {{--<td class="main_answer">{{$brokersClaimClause}}</td>--}}
                                                @if($brokersClaimClause=='Yes')
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['brokersClaimClause']))

                                                                @if($insures_details[$i]['brokersClaimClause']['comment']!="")
                                                                    <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['brokersClaimClause']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['brokersClaimClause']['comment']}}
                                                                    </span>
                                                                    </td>
                                                                @else
                                                                    <td>{{$insures_details[$i]['brokersClaimClause']['isAgree']}}</td>
                                                                @endif
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                @else
                                                    @for($j=0;$j<$selected_insures_count;$j++)
                                                        <td>--</td>
                                                    @endfor
                                                @endif
                                            </tr>
                                        @endif
                                        @if($pipeline_details['formData']['hiredWorkersDetails']['hasHiredWorkers']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">EMPLOYMENT CLAUSE</label></td>
                                                @if(isset($pipeline_details['formData']['hiredCheck']))
                                                    @if($pipeline_details['formData']['hiredCheck']==true)
				                                        <?php $hiredCheck='Yes';?>
                                                    @else
				                                        <?php $hiredCheck='No';?>
                                                    @endif
                                                @endif
                                                {{--<td class="main_answer">{{$riotCover}}</td>--}}

                                                @if($hiredCheck=='Yes')
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['hiredCheck']))
                                                                <td>{{$insures_details[$i]['hiredCheck']}}</td>
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                @else
                                                    @for($j=0;$j<$selected_insures_count;$j++)
                                                        <td>--</td>
                                                    @endfor
                                                @endif
                                            </tr>
                                            @endif
                                        @if($pipeline_details['formData']['offShoreEmployeeDetails']['hasOffShoreEmployees']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">COVER FOE OFFSHORE EMPLOYEE</label></td>
                                                @if(isset($pipeline_details['formData']['offshoreCheck']))
                                                    @if($pipeline_details['formData']['offshoreCheck']==true)
				                                        <?php $offshoreCheck='Yes';?>
                                                    @else
				                                        <?php $offshoreCheck='No';?>
                                                    @endif
                                                @endif
                                                {{--<td class="main_answer">{{$riotCover}}</td>--}}

                                                @if($offshoreCheck=='Yes')
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['offshoreCheck']))
                                                                <td>{{$insures_details[$i]['offshoreCheck']}}</td>
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                @else
                                                    @for($j=0;$j<$selected_insures_count;$j++)
                                                        <td>--</td>
                                                    @endfor
                                                @endif
                                            </tr>
                                            @endif
                                        @if(isset($pipeline_details['formData']['sepOrCom']) &&$pipeline_details['formData']['sepOrCom']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">RATE (ADMIN)</label></td>
                                                {{--<td class="main_answer">{{$pipeline_details['formData']['rateRequiredAdmin']}}</td>--}}
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['rateRequiredAdmin']))
                                                            <td>{{$insures_details[$i]['rateRequiredAdmin']}}</td>
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif
                                        @if(isset($pipeline_details['formData']['sepOrCom']) &&$pipeline_details['formData']['sepOrCom']==true )
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">RATE (NON-ADMIN)</label></td>
                                                {{--<td class="main_answer">{{$pipeline_details['formData']['rateRequiredNonAdmin']}}</td>--}}
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['rateRequiredNonAdmin']))
                                                            <td>{{$insures_details[$i]['rateRequiredNonAdmin']}}</td>
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif
                                        @if(isset($pipeline_details['formData']['sepOrCom']) &&$pipeline_details['formData']['sepOrCom']==false)
                                        <tr>
                                            <td class="main_question"><label class="form_label bold">COMBINED RATE</label></td>
											<?php $insure_count=count(@$insures_details);?>
                                            {{--<td class="main_answer">{{$pipeline_details['formData']['combinedRate']}}</td>--}}
                                            @for ($i = 0; $i < $insure_count; $i++)
                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                    @if(isset($insures_details[$i]['combinedRate']))

                                                        <td>{{$insures_details[$i]['combinedRate']}}</td>
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                @endif
                                            @endfor
                                        </tr>
                                        @endif
                                        <tr>
                                            <td class="main_question"><label class="form_label bold">WARRANTY</label></td>
                                            {{--<td class="main_answer">{{$pipeline_details['formData']['warranty']}}</td>--}}
                                            @for ($i = 0; $i < $insure_count; $i++)
                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                    @if(isset($insures_details[$i]['warranty']))

                                                        <td>{{$insures_details[$i]['warranty']}}</td>
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                @endif
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td class="main_question"><label class="form_label bold">EXCLUSION</label></td>
                                            {{--<td class="main_answer">{{$pipeline_details['formData']['exclusion']}}</td>--}}

                                            @for ($i = 0; $i < $insure_count; $i++)
                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                    @if(isset($insures_details[$i]['exclusion']))
                                                        <td>{{$insures_details[$i]['exclusion']}}</td>
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                @endif
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td class="main_question"><label class="form_label bold">SPECIAL CONDITION </label></td>
                                            {{--<td class="main_answer">{{$pipeline_details['formData']['specialCondition']}}</td>--}}

                                            @for ($i = 0; $i < $insure_count; $i++)
                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                    @if(isset($insures_details[$i]['specialCondition']))
                                                        <td>{{$insures_details[$i]['specialCondition']}}</td>
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                @endif
                                            @endfor
                                        </tr>
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                            <p class="Info" style="font-size: 13px;font-weight: 500;font-style: italic;margin-bottom: 15px">IMPORTANT: This document is the property of INTERACTIVE Insurance Brokers LLC, Dubai and is
                                strictly confidential to its recipients. The document should not be copied, distributed or
                                reproduced in whole or in part, nor passed to any third party without the consent of its owner.
                            </p>

                            <p style="font-weight: 600;font-size: 13px;">Selected Insurer & Option : </p>
                            <p style="font-weight: 600;font-size: 13px;">Signature : </p>
                            <p style="font-weight: 600;font-size: 13px;">Date : </p>
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