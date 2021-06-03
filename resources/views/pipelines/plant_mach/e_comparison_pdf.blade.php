
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
                                <h2>Proposal for Contractor`s Plant and Machinery</h2>
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
                                            @if($pipeline_details['formData']['authRepair']&& $pipeline_details['formData']['authRepair']!='')
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Authorised repair limit</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['authRepair']['isAgree']))
                                                            @if($insures_details[$i]['authRepair']['comment']!="")
                                                                <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['authRepair']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['authRepair']['comment']}}
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>{{$insures_details[$i]['authRepair']['isAgree']}}</td>
                                                            @endif
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                            @endif
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Strike, riot and civil commotion and malicious damage</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['strikeRiot']['isAgree']))
                                                            @if($insures_details[$i]['strikeRiot']['comment']!="")
                                                                <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['strikeRiot']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['strikeRiot']['comment']}}
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>{{$insures_details[$i]['strikeRiot']['isAgree']}}</td>
                                                            @endif
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Overtime, night works , works on public holidays and express freight</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['overtime']['isAgree']))
                                                            @if($insures_details[$i]['overtime']['comment']!="")
                                                                <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['overtime']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['overtime']['comment']}}
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>{{$insures_details[$i]['overtime']['isAgree']}}</td>
                                                            @endif
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Cover for extra charges for Airfreight</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['coverExtra']['isAgree']))
                                                            @if($insures_details[$i]['coverExtra']['comment']!="")
                                                                <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['coverExtra']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['coverExtra']['comment']}}
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>{{$insures_details[$i]['coverExtra']['isAgree']}}</td>
                                                            @endif
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Cover for underground Machinery and equipment</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['coverUnder']))
                                                            
                                                            <td>{{$insures_details[$i]['coverUnder']}}</td>
                                                        
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                            @if (isset($pipeline_details['formData']['drillRigs'])&& $pipeline_details['formData']['drillRigs']==true) 
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Cover for water well drilling rigs and equipment</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['drillRigs']))
                                                            
                                                            <td>{{$insures_details[$i]['drillRigs']}}</td>
                                                        
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                            @endif
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Inland Transit including loading and unloading cover</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['inlandTransit']['isAgree']))
                                                            @if($insures_details[$i]['inlandTransit']['comment']!="")
                                                                <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['inlandTransit']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['inlandTransit']['comment']}}
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>{{$insures_details[$i]['inlandTransit']['isAgree']}}</td>
                                                            @endif
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Transit and Road risks whilst the insured items are travelling/transporting on own power on public roads</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['transitRoad']['isAgree']))
                                                            @if($insures_details[$i]['transitRoad']['comment']!="")
                                                                <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['transitRoad']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['transitRoad']['comment']}}
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>{{$insures_details[$i]['transitRoad']['isAgree']}}</td>
                                                            @endif
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Third Party Liability- whilst on site, owned and/or hired parking yard, during participation in any sales promotions, sports, social events, display at various sites within GCC either contract of hire or otherwise</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['thirdParty']['isAgree']))
                                                            @if($insures_details[$i]['thirdParty']['comment']!="")
                                                                <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['thirdParty']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['thirdParty']['comment']}}
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>{{$insures_details[$i]['thirdParty']['isAgree']}}</td>
                                                            @endif
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                            @if(isset($pipeline_details['formData']['machEquip']['machEquip']) && ($pipeline_details['formData']['machEquip']['machEquip'] == true) &&
                                                            isset($pipeline_details['formData']['coverHired']))
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Cover when items are hired out</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['coverHired']))
                                                            
                                                            <td>{{$insures_details[$i]['coverHired']}}</td>
                                                        
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                            @endif
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Automatic Reinstatement of sum insured</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['autoSum']['isAgree']))
                                                            @if($insures_details[$i]['autoSum']['comment']!="")
                                                                <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['autoSum']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['autoSum']['comment']}}
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>{{$insures_details[$i]['autoSum']['isAgree']}}</td>
                                                            @endif
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Including the risk of erection, resettling and dismantling</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['includRisk']))
                                                            <td>{{$insures_details[$i]['includRisk']}}</td>
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Tool of trade extension</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['tool']['isAgree']))
                                                            @if($insures_details[$i]['tool']['comment']!="")
                                                                <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['tool']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['tool']['comment']}}
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>{{$insures_details[$i]['tool']['isAgree']}}</td>
                                                            @endif
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">72 Hours clause</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['hoursClause']))
                                                            <td>{{$insures_details[$i]['hoursClause']}}</td>
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Nominated Loss Adjuster Clause</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['lossAdj']['isAgree']))
                                                            @if($insures_details[$i]['lossAdj']['comment']!="")
                                                                <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['lossAdj']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['lossAdj']['comment']}}
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>{{$insures_details[$i]['lossAdj']['isAgree']}}</td>
                                                            @endif
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Primary Insurance Clause</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['primaryClause']))
                                                            <td>{{$insures_details[$i]['primaryClause']}}</td>
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Payment on accounts clause-75%</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['paymentAccount']['isAgree']))
                                                            @if($insures_details[$i]['paymentAccount']['comment']!="")
                                                                <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['paymentAccount']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['paymentAccount']['comment']}}
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>{{$insures_details[$i]['paymentAccount']['isAgree']}}</td>
                                                            @endif
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">85% condition of average</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['avgCondition']))
                                                            <td>{{$insures_details[$i]['avgCondition']}}</td>
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Automatic addition</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['autoAddition']['isAgree']))
                                                            @if($insures_details[$i]['autoAddition']['comment']!="")
                                                                <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['autoAddition']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['autoAddition']['comment']}}
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>{{$insures_details[$i]['autoAddition']['isAgree']}}</td>
                                                            @endif
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Cancellation clause</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['cancelClause']['isAgree']))
                                                            @if($insures_details[$i]['cancelClause']['comment']!="")
                                                                <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['cancelClause']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['cancelClause']['comment']}}
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>{{$insures_details[$i]['cancelClause']['isAgree']}}</td>
                                                            @endif
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Removal of debris</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['derbis']['isAgree']))
                                                            @if($insures_details[$i]['derbis']['comment']!="")
                                                                <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['derbis']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['derbis']['comment']}}
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>{{$insures_details[$i]['derbis']['isAgree']}}</td>
                                                            @endif
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Repair investigation clause</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['repairClause']['isAgree']))
                                                            @if($insures_details[$i]['repairClause']['comment']!="")
                                                                <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['repairClause']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['repairClause']['comment']}}
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>{{$insures_details[$i]['repairClause']['isAgree']}}</td>
                                                            @endif
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Temporary repair clause</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['tempRepair']['isAgree']))
                                                            @if($insures_details[$i]['tempRepair']['comment']!="")
                                                                <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['tempRepair']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['tempRepair']['comment']}}
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>{{$insures_details[$i]['tempRepair']['isAgree']}}</td>
                                                            @endif
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Errors & omission clause</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['errorOmission']))
                                                            <td>{{$insures_details[$i]['errorOmission']}}</td>
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Minimization of loss</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['minLoss']['isAgree']))
                                                            @if($insures_details[$i]['minLoss']['comment']!="")
                                                                <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['minLoss']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['minLoss']['comment']}}
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>{{$insures_details[$i]['minLoss']['isAgree']}}</td>
                                                            @endif
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                            @if(isset($pipeline_details['formData']['affCompany']) && $pipeline_details['formData']['affCompany'] !='' &&
                                            isset($pipeline_details['formData']['crossLiability']))
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Cross liability</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['crossLiability']['isAgree']))
                                                            @if($insures_details[$i]['crossLiability']['comment']!="")
                                                                <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['crossLiability']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['crossLiability']['comment']}}
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>{{$insures_details[$i]['crossLiability']['isAgree']}}</td>
                                                            @endif
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                            @endif
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Including cover for loading/ unloading and delivery risks</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['coverInclude']))
                                                            <td>{{$insures_details[$i]['coverInclude']}}</td>
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Towing charges</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['towCharge']['isAgree']))
                                                            @if($insures_details[$i]['towCharge']['comment']!="")
                                                                <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['towCharge']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['towCharge']['comment']}}
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>{{$insures_details[$i]['towCharge']['isAgree']}}</td>
                                                            @endif
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                            @if(isset($pipeline_details['formData']['policyBank']['policyBank']) && $pipeline_details['formData']['policyBank']['policyBank'] ==true && isset($pipeline_details['formData']['lossPayee']))
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Loss payee clause</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['lossPayee']))
                                                            <td>{{$insures_details[$i]['lossPayee']}}</td>
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                            @endif
                                             <tr>
                                                <td><div class="main_question"><label class="form_label bold">Agency repair</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['agencyRepair']['isAgree']))
                                                            @if($insures_details[$i]['agencyRepair']['comment']!="")
                                                                <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['agencyRepair']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['agencyRepair']['comment']}}
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>{{$insures_details[$i]['agencyRepair']['isAgree']}}</td>
                                                            @endif
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Indemnity to principal</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['indemnityPrincipal']))
                                                            <td>{{$insures_details[$i]['indemnityPrincipal']}}</td>
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Designation of property</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['propDesign']))
                                                            <td>{{$insures_details[$i]['propDesign']}}</td>
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Special condition :It is understood and agreed that exclusion ‘C’ will not apply to accidental losses’</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['specialAgree']))
                                                            <td>{{$insures_details[$i]['specialAgree']}}</td>
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Declaration of sum insured and basis of settlement: Total loss claims will be settled on the current market value of the vehicle on the day of accident and insured should submit 3 valuation report for consideration of loss surveyor</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['declarationSum']['isAgree']))
                                                            @if($insures_details[$i]['declarationSum']['comment']!="")
                                                                <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['declarationSum']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['declarationSum']['comment']}}
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>{{$insures_details[$i]['declarationSum']['isAgree']}}</td>
                                                            @endif
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Salvage: In case of total loss Insurer will give the option to the Insured to purchase the salvage based on the amount of the highest bid obtained by the Insurer</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['salvage']['isAgree']))
                                                            @if($insures_details[$i]['salvage']['comment']!="")
                                                                <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['salvage']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['salvage']['comment']}}
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>{{$insures_details[$i]['salvage']['isAgree']}}</td>
                                                            @endif
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Total Loss:An equipment will be considered as total loss (destroyed) in case the repair cost is 50% or more than the NRV of the equipment (considered as constructive total loss)</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['totalLoss']['isAgree']))
                                                            @if($insures_details[$i]['totalLoss']['comment']!="")
                                                                <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['totalLoss']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['totalLoss']['comment']}}
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>{{$insures_details[$i]['totalLoss']['isAgree']}}</td>
                                                            @endif
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Profit Sharing</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['profitShare']['isAgree']))
                                                            @if($insures_details[$i]['profitShare']['comment']!="")
                                                                <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['profitShare']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['profitShare']['comment']}}
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>{{$insures_details[$i]['profitShare']['isAgree']}}</td>
                                                            @endif
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Claims procedure: Existing claim procedure attached and should form the framework for renewal period</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['claimPro']['isAgree']))
                                                            @if($insures_details[$i]['claimPro']['comment']!="")
                                                                <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['claimPro']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['claimPro']['comment']}}
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>{{$insures_details[$i]['claimPro']['isAgree']}}</td>
                                                            @endif
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Waiver of subrogation against principal</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['waiver']))
                                                            <td>{{$insures_details[$i]['waiver']}}</td>
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Rate</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['rate']))
                                                            <td>{{number_format($insures_details[$i]['rate'],2)}}</td>
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Premium</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['premium']))
                                                            <td>{{number_format($insures_details[$i]['premium'],2)}}</td>
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Payment Terms</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['payTerm']))
                                                            <td>{{$insures_details[$i]['payTerm']}}</td>
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