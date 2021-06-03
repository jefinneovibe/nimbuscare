
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
                                <h2>Proposal for Business Interruption</h2>
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
                                            @if($pipeline_details['formData']['costWork']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Additional increase in cost of working</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['costWork']))
                                                                
                                                                <td>{{$insures_details[$i]['costWork']}}</td>
                                                            
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['claimClause']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Claims preparation clause</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['claimClause']['isAgree']))
                                                                @if($insures_details[$i]['claimClause']['comment']!="")
                                                                    <td class="tooltip_sec">
                                                                        <span>{{$insures_details[$i]['claimClause']['isAgree']}}
                                                                            <br>Comments : {{$insures_details[$i]['claimClause']['comment']}}
                                                                        </span>
                                                                    </td>
                                                                @else
                                                                    <td>{{$insures_details[$i]['claimClause']['isAgree']}}</td>
                                                                @endif
                                                                @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['custExtension']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Suppliers extension/customer extension</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['custExtension']['isAgree']))
                                                            @if($insures_details[$i]['custExtension']['comment']!="")
                                                                <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['custExtension']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['custExtension']['comment']}}
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>{{$insures_details[$i]['custExtension']['isAgree']}}</td>
                                                            @endif
                                                        @else
                                                        <td>--</td>
                                                    @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['accountants']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Accountants clause</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['accountants']['isAgree']))
                                                        @if($insures_details[$i]['accountants']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details[$i]['accountants']['isAgree']}}
                                                                    <br>Comments : {{$insures_details[$i]['accountants']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details[$i]['accountants']['isAgree']}}</td>
                                                        @endif
                                                        @else
                                                        <td>--</td>
                                                    @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['payAccount']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Payment on account</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['payAccount']['isAgree']))
                                                        @if($insures_details[$i]['payAccount']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details[$i]['payAccount']['isAgree']}}
                                                                    <br>Comments : {{$insures_details[$i]['payAccount']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details[$i]['payAccount']['isAgree']}}</td>
                                                        @endif
                                                        @else
                                                        <td>--</td>
                                                    @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['denialAccess']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Prevention/denial of access</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['denialAccess']['isAgree']))
                                                        @if($insures_details[$i]['denialAccess']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details[$i]['denialAccess']['isAgree']}}
                                                                    <br>Comments : {{$insures_details[$i]['denialAccess']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details[$i]['denialAccess']['isAgree']}}</td>
                                                        @endif
                                                        @else
                                                        <td>--</td>
                                                    @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['premiumClause']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Premium adjustment clause</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                    @if(isset($insures_details[$i]['premiumClause']['isAgree']))
                                                    @if($insures_details[$i]['premiumClause']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details[$i]['premiumClause']['isAgree']}}
                                                                <br>Comments : {{$insures_details[$i]['premiumClause']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details[$i]['premiumClause']['isAgree']}}</td>
                                                    @endif
                                                    @else
                                                    <td>--</td>
                                                @endif
                                                    @endif
                                                @endfor
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['utilityClause']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Public utilities clause</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['utilityClause']['isAgree']))
                                                        @if($insures_details[$i]['utilityClause']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details[$i]['utilityClause']['isAgree']}}
                                                                    <br>Comments : {{$insures_details[$i]['utilityClause']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details[$i]['utilityClause']['isAgree']}}</td>
                                                        @endif
                                                        @else
                                                        <td>--</td>
                                                    @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['brokerClaim']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Brokers Claim Handling Clause : A loss notification received by the Insurance Broker will be deemed as a loss notification to Insurer. All communications flowing between the Insurer, Insured and the appointed Loss Surveyor should be channelized through the Broker, unless there is any unavoidable reasons compelling direct communications between the parties</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['brokerClaim']))
                                                                
                                                                <td>{{$insures_details[$i]['brokerClaim']}}</td>
                                                            
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['bookedDebts']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Accounts recievable / Loss of booked debts</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['bookedDebts']['isAgree']))
                                                        @if($insures_details[$i]['bookedDebts']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details[$i]['bookedDebts']['isAgree']}}
                                                                    <br>Comments : {{$insures_details[$i]['bookedDebts']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details[$i]['bookedDebts']['isAgree']}}</td>
                                                        @endif
                                                        @else
                                                        <td>--</td>
                                                    @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['interdependanyClause']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Interdependany clause</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['interdependanyClause']))
                                                                
                                                        <td>{{$insures_details[$i]['interdependanyClause']}}</td>
                                                    
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                           
                                            @if($pipeline_details['formData']['extraExpense']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Extra expense</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['extraExpense']['isAgree']))
                                                                @if($insures_details[$i]['extraExpense']['comment']!="")
                                                                    <td class="tooltip_sec">
                                                                        <span>{{$insures_details[$i]['extraExpense']['isAgree']}}
                                                                            <br>Comments : {{$insures_details[$i]['extraExpense']['comment']}}
                                                                        </span>
                                                                    </td>
                                                                @else
                                                                    <td>{{$insures_details[$i]['extraExpense']['isAgree']}}</td>
                                                                @endif
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['water']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Contaminated water</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['water']))
                                                                
                                                        <td>{{$insures_details[$i]['water']}}</td>
                                                    
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['auditorFee']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Auditors fees</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['auditorFee']['isAgree']))
                                                                @if($insures_details[$i]['auditorFee']['comment']!="")
                                                                    <td class="tooltip_sec">
                                                                        <span>{{$insures_details[$i]['auditorFee']['isAgree']}}
                                                                            <br>Comments : {{$insures_details[$i]['auditorFee']['comment']}}
                                                                        </span>
                                                                    </td>
                                                                @else
                                                                    <td>{{$insures_details[$i]['auditorFee']['isAgree']}}</td>
                                                                @endif
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['expenseLaws']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">expense to reduce the laws</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['expenseLaws']['isAgree']))
                                                                @if($insures_details[$i]['expenseLaws']['comment']!="")
                                                                    <td class="tooltip_sec">
                                                                        <span>{{$insures_details[$i]['expenseLaws']['isAgree']}}
                                                                            <br>Comments : {{$insures_details[$i]['expenseLaws']['comment']}}
                                                                        </span>
                                                                    </td>
                                                                @else
                                                                    <td>{{$insures_details[$i]['expenseLaws']['isAgree']}}</td>
                                                                @endif
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['lossAdjuster']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Nominated loss adjuster</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['lossAdjuster']['isAgree']))
                                                        @if($insures_details[$i]['lossAdjuster']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details[$i]['lossAdjuster']['isAgree']}}
                                                                    <br>Comments : {{$insures_details[$i]['lossAdjuster']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details[$i]['lossAdjuster']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['discease']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Outbreak of discease</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['discease']['isAgree']))
                                                        @if($insures_details[$i]['discease']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details[$i]['discease']['isAgree']}}
                                                                    <br>Comments : {{$insures_details[$i]['discease']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details[$i]['discease']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['powerSupply']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Failure of non public power supply</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['powerSupply']['isAgree']))
                                                        @if($insures_details[$i]['powerSupply']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details[$i]['powerSupply']['isAgree']}}
                                                                    <br>Comments : {{$insures_details[$i]['powerSupply']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details[$i]['powerSupply']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['condition1']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Murder, Suicide or outbreak of discease on the premises</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['condition1']['isAgree']))
                                                        @if($insures_details[$i]['condition1']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details[$i]['condition1']['isAgree']}}
                                                                    <br>Comments : {{$insures_details[$i]['condition1']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details[$i]['condition1']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['condition2']==true)
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Bombscare and unexploded devices on the premises</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                    @if(isset($insures_details[$i]['condition2']['isAgree']))
                                                    @if($insures_details[$i]['condition2']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details[$i]['condition2']['isAgree']}}
                                                                <br>Comments : {{$insures_details[$i]['condition2']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details[$i]['condition2']['isAgree']}}</td>
                                                    @endif
                                                @else
                                                    <td>--</td>
                                                @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif
                                        @if($pipeline_details['formData']['bookofDebts']==true)
                                        <tr>
                                            <td><div class="main_question"><label class="form_label bold">Book of Debts</label></div></td>
                                            @for ($i = 0; $i < $insure_count; $i++)
                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                @if(isset($insures_details[$i]['bookofDebts']['isAgree']))
                                                @if($insures_details[$i]['bookofDebts']['comment']!="")
                                                    <td class="tooltip_sec">
                                                        <span>{{$insures_details[$i]['bookofDebts']['isAgree']}}
                                                            <br>Comments : {{$insures_details[$i]['bookofDebts']['comment']}}
                                                        </span>
                                                    </td>
                                                @else
                                                    <td>{{$insures_details[$i]['bookofDebts']['isAgree']}}</td>
                                                @endif
                                                @else
                                                <td>--</td>
                                            @endif
                                                @endif
                                            @endfor
                                        </tr>
                                    @endif
                                            @if($pipeline_details['formData']['risk']>1 && $pipeline_details['formData']['depclause']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Departmental clause</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['depclause']))
                                                                
                                                        <td>{{$insures_details[$i]['depclause']}}</td>
                                                    
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                           
                                            @if($pipeline_details['formData']['rent']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Rent & Lease hold interest</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['rent']['isAgree']))
                                                                @if($insures_details[$i]['rent']['comment']!="")
                                                                    <td class="tooltip_sec">
                                                                        <span>{{$insures_details[$i]['rent']['isAgree']}}
                                                                            <br>Comments : {{$insures_details[$i]['rent']['comment']}}
                                                                        </span>
                                                                    </td>
                                                                @else
                                                                    <td>{{$insures_details[$i]['rent']['isAgree']}}</td>
                                                                @endif
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['hasaccomodation']=="yes")
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Cover for alternate accomodation</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['hasaccomodation']['isAgree']))
                                                                @if($insures_details[$i]['hasaccomodation']['comment']!="")
                                                                    <td class="tooltip_sec">
                                                                        <span>{{$insures_details[$i]['hasaccomodation']['isAgree']}}
                                                                            <br>Comments : {{$insures_details[$i]['hasaccomodation']['comment']}}
                                                                        </span>
                                                                    </td>
                                                                @else
                                                                    <td>{{$insures_details[$i]['hasaccomodation']['isAgree']}}</td>
                                                                @endif
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['costofConstruction']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Demolition and increased cost of construction</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['costofConstruction']['isAgree']))
                                                                @if($insures_details[$i]['costofConstruction']['comment']!="")
                                                                    <td class="tooltip_sec">
                                                                        <span>{{$insures_details[$i]['costofConstruction']['isAgree']}}
                                                                            <br>Comments : {{$insures_details[$i]['costofConstruction']['comment']}}
                                                                        </span>
                                                                    </td>
                                                                @else
                                                                    <td>{{$insures_details[$i]['costofConstruction']['isAgree']}}</td>
                                                                @endif
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['ContingentExpense']==true)
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Contingent business inetruption and contingent extra expense</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['ContingentExpense']['isAgree']))
                                                            @if($insures_details[$i]['ContingentExpense']['comment']!="")
                                                                <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['ContingentExpense']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['ContingentExpense']['comment']}}
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>{{$insures_details[$i]['ContingentExpense']['isAgree']}}</td>
                                                            @endif
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif
                                        @if($pipeline_details['formData']['interuption']==true)
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Non Owned property in vicinity interuption</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['interuption']['isAgree']))
                                                            @if($insures_details[$i]['interuption']['comment']!="")
                                                                <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['interuption']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['interuption']['comment']}}
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>{{$insures_details[$i]['interuption']['isAgree']}}</td>
                                                            @endif
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif
                                        @if($pipeline_details['formData']['Royalties']==true)
                                        <tr>
                                            <td><div class="main_question"><label class="form_label bold">Royalties</label></div></td>
                                            @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['Royalties']))
                                                                
                                                                <td>{{$insures_details[$i]['Royalties']}}</td>
                                                            
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                        </tr>
                                    @endif
                                            @if($pipeline_details['formData']['deductible'])
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Deductible</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['deductible']) && $insures_details[$i]['deductible']!='')
                                                                
                                                                <td>{{number_format(trim($insures_details[$i]['deductible']),2)}}</td>
                                                            
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['ratep'])
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Rate/premium</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['ratep']) && $insures_details[$i]['ratep']!='')
                                                                
                                                                <td>{{number_format(trim($insures_details[$i]['ratep']),2)}}</td>
                                                            
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['brokerage'])
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Brokerage</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId) && $insures_details[$i]['brokerage']!='')
                                                            @if(isset($insures_details[$i]['brokerage']))
                                                                
                                                                <td>{{number_format(trim($insures_details[$i]['brokerage']),2)}}</td>
                                                            
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['spec_condition'])
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Special Condition</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['spec_condition']) && $insures_details[$i]['spec_condition']!='')
                                                                
                                                                <td>{{number_format(trim($insures_details[$i]['spec_condition']),2)}}</td>
                                                            
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['warranty'])
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Warranty</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['warranty']) && $insures_details[$i]['warranty']!='')
                                                                
                                                                <td>{{number_format(trim($insures_details[$i]['warranty']),2)}}</td>
                                                            
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['exclusion'])
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Exclusion</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['exclusion']) && $insures_details[$i]['exclusion']!='')
                                                                
                                                                <td>{{number_format(trim($insures_details[$i]['exclusion']),2)}}</td>
                                                            
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                        
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