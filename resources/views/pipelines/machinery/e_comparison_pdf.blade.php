
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
                                <h2>Proposal for Machinery Breakdown</h2>
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
                                            @if($pipeline_details['formData']['localclause']==true)
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Local Jurisdiction Clause</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['localclause']['isAgree']))
                                                            @if($insures_details[$i]['localclause']['comment']!="")
                                                                <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['localclause']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['localclause']['comment']}}
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>{{$insures_details[$i]['localclause']['isAgree']}}</td>
                                                            @endif
                                                            @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                            @endif

                                            @if($pipeline_details['formData']['express']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Overtime, night works and express freight</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['express']['isAgree']))
                                                                @if($insures_details[$i]['express']['comment']!="")
                                                                    <td class="tooltip_sec">
                                                                        <span>{{$insures_details[$i]['express']['isAgree']}}
                                                                            <br>Comments : {{$insures_details[$i]['express']['comment']}}
                                                                        </span>
                                                                    </td>
                                                                @else
                                                                    <td>{{$insures_details[$i]['express']['isAgree']}}</td>
                                                                @endif
                                                                @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['airfreight']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Airfreight</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['airfreight']['isAgree']))
                                                            @if($insures_details[$i]['airfreight']['comment']!="")
                                                                <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['airfreight']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['airfreight']['comment']}}
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>{{$insures_details[$i]['airfreight']['isAgree']}}</td>
                                                            @endif
                                                        @else
                                                        <td>--</td>
                                                    @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['addpremium']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Automatic Reinstatement of sum insured at pro rata additional premium</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['addpremium']['isAgree']))
                                                        @if($insures_details[$i]['addpremium']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details[$i]['addpremium']['isAgree']}}
                                                                    <br>Comments : {{$insures_details[$i]['addpremium']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details[$i]['addpremium']['isAgree']}}</td>
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
                                                    <td><div class="main_question"><label class="form_label bold">Payment on account clause</label></div></td>
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
                                            @if($pipeline_details['formData']['primaryclause']==true)
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Primary Insurance clause</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                    @if(isset($insures_details[$i]['primaryclause']))
                                                            
                                                    <td>{{$insures_details[$i]['primaryclause']}}</td>
                                                
                                                @else
                                                    <td>--</td>
                                                @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif
                                            @if($pipeline_details['formData']['premiumClaim']==true)
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Cancellation – 60 days notice by either party subject to pro-rata refund of premium unless a claim has attached</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                    @if(isset($insures_details[$i]['premiumClaim']))
                                                            
                                                    <td>{{$insures_details[$i]['premiumClaim']}}</td>
                                                
                                                @else
                                                    <td>--</td>
                                                @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif
                                            @if($pipeline_details['formData']['lossnotification']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Loss Notification – ‘as soon as reasonably practicable’</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['lossnotification']['isAgree']))
                                                        @if($insures_details[$i]['lossnotification']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details[$i]['lossnotification']['isAgree']}}
                                                                    <br>Comments : {{$insures_details[$i]['lossnotification']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details[$i]['lossnotification']['isAgree']}}</td>
                                                        @endif
                                                        @else
                                                        <td>--</td>
                                                    @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif


                                            @if($pipeline_details['formData']['adjustmentPremium']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Adjustment of sum insured and premium (Mre-410)</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['adjustmentPremium']['isAgree']))
                                                        @if($insures_details[$i]['adjustmentPremium']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details[$i]['adjustmentPremium']['isAgree']}}
                                                                    <br>Comments : {{$insures_details[$i]['adjustmentPremium']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details[$i]['adjustmentPremium']['isAgree']}}</td>
                                                        @endif
                                                        @else
                                                        <td>--</td>
                                                    @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                          
                                            @if($pipeline_details['formData']['temporaryclause']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Temporary repairs clause</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['temporaryclause']['isAgree']))
                                                                @if($insures_details[$i]['temporaryclause']['comment']!="")
                                                                    <td class="tooltip_sec">
                                                                        <span>{{$insures_details[$i]['temporaryclause']['isAgree']}}
                                                                            <br>Comments : {{$insures_details[$i]['temporaryclause']['comment']}}
                                                                        </span>
                                                                    </td>
                                                                @else
                                                                    <td>{{$insures_details[$i]['temporaryclause']['isAgree']}}</td>
                                                                @endif
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                             @if($pipeline_details['formData']['automaticClause']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Automatic addition clause</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['automaticClause']['isAgree']))
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
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['capitalclause']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Capital addition clause</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['capitalclause']['isAgree']))
                                                                @if($insures_details[$i]['capitalclause']['comment']!="")
                                                                    <td class="tooltip_sec">
                                                                        <span>{{$insures_details[$i]['capitalclause']['isAgree']}}
                                                                            <br>Comments : {{$insures_details[$i]['capitalclause']['comment']}}
                                                                        </span>
                                                                    </td>
                                                                @else
                                                                    <td>{{$insures_details[$i]['capitalclause']['isAgree']}}</td>
                                                                @endif
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['debris']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Removal of debris</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['debris']['isAgree']))
                                                        @if($insures_details[$i]['debris']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details[$i]['debris']['isAgree']}}
                                                                    <br>Comments : {{$insures_details[$i]['debris']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details[$i]['debris']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['property']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Designation of property</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['property']['isAgree']))
                                                        @if($insures_details[$i]['property']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details[$i]['property']['isAgree']}}
                                                                    <br>Comments : {{$insures_details[$i]['property']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details[$i]['property']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['errorclause']==true)
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Errors and omission clause</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                    @if(isset($insures_details[$i]['errorclause']))
                                                            
                                                    <td>{{$insures_details[$i]['errorclause']}}</td>
                                                
                                                @else
                                                    <td>--</td>
                                                @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif
                                            @if(@$pipeline_details['formData']['aff_company']!='' && $pipeline_details['formData']['waiver']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Waiver of subrogations</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['waiver']['isAgree']))
                                                        @if($insures_details[$i]['waiver']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details[$i]['waiver']['isAgree']}}
                                                                    <br>Comments : {{$insures_details[$i]['waiver']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details[$i]['waiver']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['claimclause']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Claims preparation clause</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['claimclause']['isAgree']))
                                                        @if($insures_details[$i]['claimclause']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details[$i]['claimclause']['isAgree']}}
                                                                    <br>Comments : {{$insures_details[$i]['claimclause']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details[$i]['claimclause']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                       
                                        @if($pipeline_details['formData']['Innocent']==true)
                                        <tr>
                                            <td><div class="main_question"><label class="form_label bold">Innocent non-disclosure</label></div></td>
                                            @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['Innocent']))
                                                                
                                                                <td>{{$insures_details[$i]['Innocent']}}</td>
                                                            
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                        </tr>
                                    @endif
                                    @if($pipeline_details['formData']['Noninvalidation']==true)
                                    <tr>
                                        <td><div class="main_question"><label class="form_label bold">Non-invalidation clause</label></div></td>
                                        @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['Noninvalidation']))
                                                            
                                                            <td>{{$insures_details[$i]['Noninvalidation']}}</td>
                                                        
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                    </tr>
                                @endif

                                            @if($pipeline_details['formData']['brokerclaim']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Brokers Claim Handling Clause : A loss notification received by the Insurance Broker will be deemed as a loss notification to Insurer. All communications flowing between the Insurer, Insured and the appointed Loss Surveyor should be channelized through the Broker, unless there is any unavoidable reasons compelling direct communications between the parties</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['brokerclaim']))
                                                                
                                                                <td>{{$insures_details[$i]['brokerclaim']}}</td>
                                                            
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                              
                                            {{-- @if($pipeline_details['formData']['deductible']) --}}
                                            <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Deductible for (Machinary Breakdown): </label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['deductm']))
                                                        
                                                            <td class="tooltip_sec">
                                                                <div class="ans">
                                                                    <span>{{number_format($insures_details[$i]['deductm'],2)}}</span>
                                                                </div>
                                                            </td>
                                                            
                                                        @else
                                                            <td><div class="ans">--</div></td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                        {{-- @endif --}}
                                       
                                        {{-- @if($pipeline_details['formData']['ratep']) --}}
                                            <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Rate required (Machinary Breakdown):</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['ratem']))
                                                        
                                                            <td class="tooltip_sec">
                                                                <div class="ans">
                                                                    <span>{{number_format($insures_details[$i]['ratem'],2)}}</span>
                                                                </div>
                                                            </td>
                                                            
                                                        @else
                                                            <td><div class="ans">--</div></td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                        {{-- @endif --}}
                                       
                                         {{-- @if($pipeline_details['formData']['premiumm']) --}}
                                            <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Premium required (Machinary Breakdown): </label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['premiumm']))
                                                        
                                                            <td class="tooltip_sec">
                                                                <div class="ans">
                                                                    <span>{{number_format($insures_details[$i]['premiumm'],2)}}</span>
                                                                </div>
                                                            </td>
                                                            
                                                        @else
                                                            <td><div class="ans">--</div></td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                        {{-- @endif --}}

                                        {{-- @if($pipeline_details['formData']['warranty']) --}}
                                            <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Brokerage (Machinary Breakdown)</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['brokeragem']))
                                                        
                                                            <td class="tooltip_sec">
                                                                <div class="ans">
                                                                    <span>{{number_format($insures_details[$i]['brokeragem'],2)}}</span>
                                                                </div>
                                                            </td>
                                                            
                                                        @else
                                                            <td><div class="ans">--</div></td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                        {{-- @endif --}}

                                        {{-- @if($pipeline_details['formData']['exclusion']) --}}
                                            <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Warranty (Machinary Breakdown)</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['warrantym']))
                                                        
                                                            <td class="tooltip_sec">
                                                                <div class="ans">
                                                                    <span>{{$insures_details[$i]['warrantym']}}</span>
                                                                </div>
                                                            </td>
                                                            
                                                        @else
                                                            <td><div class="ans">--</div></td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                        {{-- @endif --}}

                                        {{-- @if($pipeline_details['formData']['brokerage']) --}}
                                            <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Exclusion (Machinary Breakdown)</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['exclusionm']))
                                                        
                                                            <td class="tooltip_sec">
                                                                <div class="ans">
                                                                    <span>{{$insures_details[$i]['exclusionm']}}</span>
                                                                </div>
                                                            </td>
                                                            
                                                        @else
                                                            <td><div class="ans">--</div></td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                        {{-- @endif --}}
                                        <tr>
                                                <td><div class="main_question"><label class="form_label bold">Special Condition (Machinary Breakdown)</label></div></td>
                                            @for ($i = 0; $i < $insure_count; $i++)
                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                    @if(isset($insures_details[$i]['specialm']))
                                                    
                                                        <td class="tooltip_sec">
                                                            <div class="ans">
                                                                <span>{{$insures_details[$i]['specialm']}}</span>
                                                            </div>
                                                        </td>
                                                        
                                                    @else
                                                        <td><div class="ans">--</div></td>
                                                    @endif
                                                @endif
                                            @endfor
                                        </tr>
                                        <tr>
                                                <td><div class="main_question"><label class="form_label bold">Deductible for (Business Interruption):  </label></div></td>
                                            @for ($i = 0; $i < $insure_count; $i++)
                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                    @if(isset($insures_details[$i]['deductb']))
                                                    
                                                        <td class="tooltip_sec">
                                                            <div class="ans">
                                                                <span>{{number_format($insures_details[$i]['deductb'],2)}}</span>
                                                            </div>
                                                        </td>
                                                        
                                                    @else
                                                        <td><div class="ans">--</div></td>
                                                    @endif
                                                @endif
                                            @endfor
                                        </tr>

                                        <tr>
                                                <td><div class="main_question"><label class="form_label bold">Rate required (Business Interruption): </label></div></td>
                                            @for ($i = 0; $i < $insure_count; $i++)
                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                    @if(isset($insures_details[$i]['rateb']))
                                                    
                                                        <td class="tooltip_sec">
                                                            <div class="ans">
                                                                <span>{{number_format($insures_details[$i]['rateb'],2)}}</span>
                                                            </div>
                                                        </td>
                                                        
                                                    @else
                                                        <td><div class="ans">--</div></td>
                                                    @endif
                                                @endif
                                            @endfor
                                        </tr>
                                        <tr>
                                                <td><div class="main_question"><label class="form_label bold">Premium required (Business Interruption):  </label></div></td>
                                            @for ($i = 0; $i < $insure_count; $i++)
                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                    @if(isset($insures_details[$i]['premiumb']))
                                                    
                                                        <td class="tooltip_sec">
                                                            <div class="ans">
                                                                <span>{{number_format($insures_details[$i]['premiumb'],2)}}</span>
                                                            </div>
                                                        </td>
                                                        
                                                    @else
                                                        <td><div class="ans">--</div></td>
                                                    @endif
                                                @endif
                                            @endfor
                                        </tr>
                                    {{-- @endif --}}

                                    {{-- @if($pipeline_details['formData']['warranty']) --}}
                                        <tr>
                                                <td><div class="main_question"><label class="form_label bold">Brokerage (Business Interruption):</label></div></td>
                                            @for ($i = 0; $i < $insure_count; $i++)
                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                    @if(isset($insures_details[$i]['brokerageb']))
                                                    
                                                        <td class="tooltip_sec">
                                                            <div class="ans">
                                                                <span>{{number_format($insures_details[$i]['brokerageb'],2)}}</span>
                                                            </div>
                                                        </td>
                                                        
                                                    @else
                                                        <td><div class="ans">--</div></td>
                                                    @endif
                                                @endif
                                            @endfor
                                        </tr>
                                    {{-- @endif --}}

                                    {{-- @if($pipeline_details['formData']['exclusion']) --}}
                                        <tr>
                                                <td><div class="main_question"><label class="form_label bold">Warranty (Business Interruption):</label></div></td>
                                            @for ($i = 0; $i < $insure_count; $i++)
                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                    @if(isset($insures_details[$i]['warrantyb']))
                                                    
                                                        <td class="tooltip_sec">
                                                            <div class="ans">
                                                                <span>{{$insures_details[$i]['warrantyb']}}</span>
                                                            </div>
                                                        </td>
                                                        
                                                    @else
                                                        <td><div class="ans">--</div></td>
                                                    @endif
                                                @endif
                                            @endfor
                                        </tr>
                                    {{-- @endif --}}

                                    {{-- @if($pipeline_details['formData']['brokerage']) --}}
                                        <tr>
                                                <td><div class="main_question"><label class="form_label bold">Exclusion (Business Interruption):</label></div></td>
                                            @for ($i = 0; $i < $insure_count; $i++)
                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                    @if(isset($insures_details[$i]['exclusionb']))
                                                    
                                                        <td class="tooltip_sec">
                                                            <div class="ans">
                                                                <span>{{$insures_details[$i]['exclusionb']}}</span>
                                                            </div>
                                                        </td>
                                                        
                                                    @else
                                                        <td><div class="ans">--</div></td>
                                                    @endif
                                                @endif
                                            @endfor
                                        </tr>
                                    {{-- @endif --}}
                                    <tr>
                                            <td><div class="main_question"><label class="form_label bold">Special Condition (Business Interruption):</label></div></td>
                                        @for ($i = 0; $i < $insure_count; $i++)
                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                @if(isset($insures_details[$i]['specialb']))
                                                
                                                    <td class="tooltip_sec">
                                                        <div class="ans">
                                                            <span>{{$insures_details[$i]['specialb']}}</span>
                                                        </div>
                                                    </td>
                                                    
                                                @else
                                                    <td><div class="ans">--</div></td>
                                                @endif
                                            @endif
                                        @endfor
                                    </tr>
                                            {{-- @if($pipeline_details['formData']['deductible'])
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
                                         --}}
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