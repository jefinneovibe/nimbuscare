
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
                                <h2>Proposal for Money</h2>
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
                                            @if($pipeline_details['formData']['coverLoss']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Cover for loss or damage due to  Riots and Strikes</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['coverLoss']))
                                                                
                                                                <td>{{$insures_details[$i]['coverLoss']}}</td>
                                                            
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['coverDishonest']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Cover for dishonesty  of the employees if found out within 7 days</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['coverDishonest']))
                                                                
                                                                <td>{{$insures_details[$i]['coverDishonest']}}</td>
                                                            
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['coverHoldup']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Cover for hold up</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['coverHoldup']))
                                                                
                                                                <td>{{$insures_details[$i]['coverHoldup']}}</td>
                                                            
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['lossDamage']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Loss or damage to cases / bags while being used for carriage of money</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['lossDamage']['isAgree']))
                                                                @if($insures_details[$i]['lossDamage']['comment']!="")
                                                                    <td class="tooltip_sec">
                                                                        <span>{{$insures_details[$i]['lossDamage']['isAgree']}}
                                                                            <br>Comments : {{$insures_details[$i]['lossDamage']['comment']}}
                                                                        </span>
                                                                    </td>
                                                                @else
                                                                    <td>{{$insures_details[$i]['lossDamage']['isAgree']}}</td>
                                                                @endif
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['claimCost']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Claims Preparation cost</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['claimCost']['isAgree']))
                                                                @if($insures_details[$i]['claimCost']['comment']!="")
                                                                    <td class="tooltip_sec">
                                                                        <span>{{$insures_details[$i]['claimCost']['isAgree']}}
                                                                            <br>Comments : {{$insures_details[$i]['claimCost']['comment']}}
                                                                        </span>
                                                                    </td>
                                                                @else
                                                                    <td>{{$insures_details[$i]['claimCost']['isAgree']}}</td>
                                                                @endif
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['additionalPremium']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Automatic reinstatement of sum insured  at pro-rata additional premium</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['additionalPremium']))
                                                                
                                                                <td>{{$insures_details[$i]['additionalPremium']}}</td>
                                                            
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif

                                            @if(isset($pipeline_details['formData']['storageRisk']) && $pipeline_details['formData']['storageRisk']==true && ($pipeline_details['formData']['businessType']=="Bank/ lenders/ financial institution/ currency exchange"
                                            || $pipeline_details['formData']['businessType']=="Cafes & Restaurant"
                                            || $pipeline_details['formData']['businessType']=="Car dealer/ showroom"
                                            || $pipeline_details['formData']['businessType']=="Cinema Hall auditoriums"
                                            || $pipeline_details['formData']['businessType']=="Confectionery/ dairy products processing"
                                            || $pipeline_details['formData']['businessType']=="Department stores/ shopping malls"
                                            || $pipeline_details['formData']['businessType']=="Electronic trading/ sales"
                                            || $pipeline_details['formData']['businessType']=="Entertainment venues"
                                            || $pipeline_details['formData']['businessType']=="Furniture shops/ manufacturing units"
                                            || $pipeline_details['formData']['businessType']=="Hotels/ boarding houses/ motels/ service apartments"
                                            || $pipeline_details['formData']['businessType']=="Hotel multiple cover"
                                            || $pipeline_details['formData']['businessType']=="Jewelry manufacturing/ trade"
                                            || $pipeline_details['formData']['businessType']=="Mega malls & commercial centers"
                                            || $pipeline_details['formData']['businessType']=="Mobile shops"
                                            || $pipeline_details['formData']['businessType']=="Movie theaters"
                                            || $pipeline_details['formData']['businessType']=="Museum/ heritage sites"
                                            || $pipeline_details['formData']['businessType']=="Petrol diesel & gas filling stations"
                                            || $pipeline_details['formData']['businessType']=="Recreational clubs/Theme & water parks"
                                            || $pipeline_details['formData']['businessType']=="Refrigerated distribution"
                                            || $pipeline_details['formData']['businessType']=="Restaurant/ catering services"
                                            || $pipeline_details['formData']['businessType']=="Salons/ grooming services"
                                            || $pipeline_details['formData']['businessType']=="Souk and similar markets"
                                            || $pipeline_details['formData']['businessType']=="Supermarkets / hypermarket/ other retail shops"))
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Automatic increase to 4 times the approved limits during week ends and public holidays for storage risks</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['storageRisk']))
                                                                
                                                                <td>{{$insures_details[$i]['storageRisk']}}</td>
                                                            
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['lossNotification']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Loss notification – ‘as soon as reasonably practicable’</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['lossNotification']['isAgree']))
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
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['cancellation']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Cancellation – 30 days notice by either party; refund of premium at pro-rata unless a claim has attached </label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['cancellation']))
                                                                
                                                                <td>{{$insures_details[$i]['cancellation']}}</td>
                                                            
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['thirdParty']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Third party money's for which responsibility is assumed will be covered</label></div></td>
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
                                            @endif

                                            @if($pipeline_details['formData']['carryVehicle']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Carry by own vehicle / hired vehicles and / or on foot personal money of owners</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['carryVehicle']['isAgree']))
                                                                @if($insures_details[$i]['carryVehicle']['comment']!="")
                                                                    <td class="tooltip_sec">
                                                                        <span>{{$insures_details[$i]['carryVehicle']['isAgree']}}
                                                                            <br>Comments : {{$insures_details[$i]['carryVehicle']['comment']}}
                                                                        </span>
                                                                    </td>
                                                                @else
                                                                    <td>{{$insures_details[$i]['carryVehicle']['isAgree']}}</td>
                                                                @endif
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['nominatedLoss']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Nominated Loss adjuster – Panel Crawford Intl, Cunningham Lindsey, Miller International, John Kidd LA, Insured can  select</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['nominatedLoss']['isAgree']))
                                                                @if($insures_details[$i]['nominatedLoss']['comment']!="")
                                                                    <td class="tooltip_sec">
                                                                        <span>{{$insures_details[$i]['nominatedLoss']['isAgree']}}
                                                                            <br>Comments : {{$insures_details[$i]['nominatedLoss']['comment']}}
                                                                        </span>
                                                                    </td>
                                                                @else
                                                                    <td>{{$insures_details[$i]['nominatedLoss']['isAgree']}}</td>
                                                                @endif
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['errorsClause']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Errors and Omissions clause</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['errorsClause']))
                                                                
                                                                <td>{{$insures_details[$i]['errorsClause']}}</td>
                                                            
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['personalAssault']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Cover for personal assault</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['personalAssault']['isAgree']))
                                                                @if($insures_details[$i]['personalAssault']['comment']!="")
                                                                    <td class="tooltip_sec">
                                                                        <span>{{$insures_details[$i]['personalAssault']['isAgree']}}
                                                                            <br>Comments : {{$insures_details[$i]['personalAssault']['comment']}}
                                                                        </span>
                                                                    </td>
                                                                @else
                                                                    <td>{{$insures_details[$i]['personalAssault']['isAgree']}}</td>
                                                                @endif
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['accountantFees']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Auditor’s fees/ accountant fees</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['accountantFees']['isAgree']))
                                                                @if($insures_details[$i]['accountantFees']['comment']!="")
                                                                    <td class="tooltip_sec">
                                                                        <span>{{$insures_details[$i]['accountantFees']['isAgree']}}
                                                                            <br>Comments : {{$insures_details[$i]['accountantFees']['comment']}}
                                                                        </span>
                                                                    </td>
                                                                @else
                                                                    <td>{{$insures_details[$i]['accountantFees']['isAgree']}}</td>
                                                                @endif
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['sustainedFees']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Cover for damages sustained to safe</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['sustainedFees']['isAgree']))
                                                                @if($insures_details[$i]['sustainedFees']['comment']!="")
                                                                    <td class="tooltip_sec">
                                                                        <span>{{$insures_details[$i]['sustainedFees']['isAgree']}}
                                                                            <br>Comments : {{$insures_details[$i]['sustainedFees']['comment']}}
                                                                        </span>
                                                                    </td>
                                                                @else
                                                                    <td>{{$insures_details[$i]['sustainedFees']['isAgree']}}</td>
                                                                @endif
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['primartClause']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Primary Insurance clause</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['primartClause']))
                                                                
                                                                <td>{{$insures_details[$i]['primartClause']}}</td>
                                                            
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['accountClause']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Payment on account clause</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['accountClause']['isAgree']))
                                                                @if($insures_details[$i]['accountClause']['comment']!="")
                                                                    <td class="tooltip_sec">
                                                                        <span>{{$insures_details[$i]['accountClause']['isAgree']}}
                                                                            <br>Comments : {{$insures_details[$i]['accountClause']['comment']}}
                                                                        </span>
                                                                    </td>
                                                                @else
                                                                    <td>{{$insures_details[$i]['accountClause']['isAgree']}}</td>
                                                                @endif
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['lossParkingAReas']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Cover for loss from unattended vehicle if it was left in locked condition at designated parking areas</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['lossParkingAReas']))
                                                                
                                                                <td>{{$insures_details[$i]['lossParkingAReas']}}</td>
                                                            
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['worldwideCover']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Cover for loss of money whilst in the personal possession of authorized employees (Worldwide cover)</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['worldwideCover']['isAgree']))
                                                                @if($insures_details[$i]['worldwideCover']['comment']!="")
                                                                    <td class="tooltip_sec">
                                                                        <span>{{$insures_details[$i]['worldwideCover']['isAgree']}}
                                                                            <br>Comments : {{$insures_details[$i]['worldwideCover']['comment']}}
                                                                        </span>
                                                                    </td>
                                                                @else
                                                                    <td>{{$insures_details[$i]['worldwideCover']['isAgree']}}</td>
                                                                @endif
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['locationAddition']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Automatic addition of location</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['locationAddition']['isAgree']))
                                                                @if($insures_details[$i]['locationAddition']['comment']!="")
                                                                    <td class="tooltip_sec">
                                                                        <span>{{$insures_details[$i]['locationAddition']['isAgree']}}
                                                                            <br>Comments : {{$insures_details[$i]['locationAddition']['comment']}}
                                                                        </span>
                                                                    </td>
                                                                @else
                                                                    <td>{{$insures_details[$i]['locationAddition']['isAgree']}}</td>
                                                                @endif
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif

                                            @if(isset($pipeline_details['formData']['moneyCarrying']) && $pipeline_details['formData']['moneyCarrying']==true && ($pipeline_details['formData']['agencies']=='yes'))
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Money carrying / pooling / storage by any group company employees / security agencies to be covered anywhere in the country </label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['moneyCarrying']['isAgree']))
                                                                @if($insures_details[$i]['moneyCarrying']['comment']!="")
                                                                    <td class="tooltip_sec">
                                                                        <span>{{$insures_details[$i]['moneyCarrying']['isAgree']}}
                                                                            <br>Comments : {{$insures_details[$i]['moneyCarrying']['comment']}}
                                                                        </span>
                                                                    </td>
                                                                @else
                                                                    <td>{{$insures_details[$i]['moneyCarrying']['isAgree']}}</td>
                                                                @endif
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['parties']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Brokers Claim Handling Clause : A loss notification received by the Insurance Broker will be deemed as a loss notification to Insurer. All communications flowing between the Insurer, Insured and the appointed Loss Surveyor should be channelized through the Broker, unless there is any unavoidable reasons compelling direct communications between the parties</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['parties']))
                                                                
                                                                <td>{{$insures_details[$i]['parties']}}</td>
                                                            
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['personalEffects']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Loss or damage to personal effect </label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['personalEffects']['isAgree']))
                                                                @if($insures_details[$i]['personalEffects']['comment']!="")
                                                                    <td class="tooltip_sec">
                                                                        <span>{{$insures_details[$i]['personalEffects']['isAgree']}}
                                                                            <br>Comments : {{$insures_details[$i]['personalEffects']['comment']}}
                                                                        </span>
                                                                    </td>
                                                                @else
                                                                    <td>{{$insures_details[$i]['personalEffects']['isAgree']}}</td>
                                                                @endif
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['holdUp']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Cover to include house breaking, theft and burglary from safe or strong room and hold up or attempt of hold up</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['holdUp']['isAgree']))
                                                                @if($insures_details[$i]['holdUp']['comment']!="")
                                                                    <td class="tooltip_sec">
                                                                        <span>{{$insures_details[$i]['holdUp']['isAgree']}}
                                                                            <br>Comments : {{$insures_details[$i]['holdUp']['comment']}}
                                                                        </span>
                                                                    </td>
                                                                @else
                                                                    <td>{{$insures_details[$i]['holdUp']['isAgree']}}</td>
                                                                @endif
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['transitdRate'])
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Rate  (Money in Transit) (in %)</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['transitdRate']) && $insures_details[$i]['transitdRate']!='')
                                                                
                                                                <td>{{$insures_details[$i]['transitdRate']}}</td>
                                                            
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['safeRate'])
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Rate  (Money in Safe) (in %)</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['safeRate']) && $insures_details[$i]['safeRate']!='')
                                                                
                                                                <td>{{$insures_details[$i]['safeRate']}}</td>
                                                            
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['premiumTransit'])
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Premium (Money in Transit) (in %)</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['premiumTransit']) && $insures_details[$i]['premiumTransit']!='')
                                                                
                                                                <td>{{$insures_details[$i]['premiumTransit']}}</td>
                                                            
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['premiumSafe'])
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Premium  (Money in Safe) (in %)</label></div></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['premiumSafe']) && $insures_details[$i]['premiumSafe']!='')
                                                                
                                                                <td>{{$insures_details[$i]['premiumSafe']}}</td>
                                                            
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