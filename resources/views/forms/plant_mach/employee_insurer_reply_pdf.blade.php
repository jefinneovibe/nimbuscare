
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
                                                @if($pipeline_details['formData']['authRepair']&& $pipeline_details['formData']['authRepair']!='')
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Authorised repair limit</label></div></td>
                                                @if(isset($insures_details['authRepair']))
                                                    @if($insures_details['authRepair']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['authRepair']['isAgree']}}
                                                                <br>Comments : {{$insures_details['authRepair']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['authRepair']['isAgree']}}</td>
                                                    @endif
                                                @endif
                                            </tr>
                                            @endif
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Strike, riot and civil commotion and malicious damage</label></div></td>
                                                    @if(isset($insures_details['strikeRiot']))
                                                        @if($insures_details['strikeRiot']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['strikeRiot']['isAgree']}}
                                                                    <br>Comments : {{$insures_details['strikeRiot']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['strikeRiot']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Overtime, night works , works on public holidays and express freight</label></div></td>
                                                    @if(isset($insures_details['overtime']))
                                                        @if($insures_details['overtime']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['overtime']['isAgree']}}
                                                                    <br>Comments : {{$insures_details['overtime']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['overtime']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Cover for extra charges for Airfreight</label></div></td>
                                                    @if(isset($insures_details['coverExtra']))
                                                        @if($insures_details['coverExtra']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['coverExtra']['isAgree']}}
                                                                    <br>Comments : {{$insures_details['coverExtra']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['coverExtra']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Cover for underground Machinery and equipment</label></div></td>
                                                    @if(isset($insures_details['coverUnder']))
                                                        <td>{{$insures_details['coverUnder']}}</td>
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                            </tr>      
                                            @if (isset($pipeline_details['formData']['drillRigs'])&& $pipeline_details['formData']['drillRigs']==true) 
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Cover for water well drilling rigs and equipment</label></div></td>                                                   
                                                    @if(isset($insures_details['drillRigs']))
                                                        <td>{{$insures_details['drillRigs']}}</td>
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                            </tr>
                                            @endif
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Inland Transit including loading and unloading cover</label></div></td>
                                                    @if(isset($insures_details['inlandTransit']))
                                                        @if($insures_details['inlandTransit']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['inlandTransit']['isAgree']}}
                                                                    <br>Comments : {{$insures_details['inlandTransit']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['inlandTransit']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Transit and Road risks whilst the insured items are travelling/transporting on own power on public roads</label></div></td>
                                                @if(isset($insures_details['transitRoad']['isAgree']))
                                                    @if($insures_details['transitRoad']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['transitRoad']['isAgree']}}
                                                                <br>Comments : {{$insures_details['transitRoad']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['transitRoad']['isAgree']}}</td>
                                                    @endif
                                                @else
                                                    <td>--</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Third Party Liability- whilst on site, owned and/or hired parking yard, during participation in any sales promotions, sports, social events, display at various sites within GCC either contract of hire or otherwise</label></div></td>
                                                @if(isset($insures_details['thirdParty']['isAgree']))
                                                    @if($insures_details['thirdParty']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['thirdParty']['isAgree']}}
                                                                <br>Comments : {{$insures_details['thirdParty']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['thirdParty']['isAgree']}}</td>
                                                    @endif
                                                @else
                                                    <td>--</td>
                                                @endif
                                            </tr>
                                            @if(isset($pipeline_details['formData']['machEquip']['machEquip']) && ($pipeline_details['formData']['machEquip']['machEquip'] == true) &&
                                                            isset($pipeline_details['formData']['coverHired']))
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Cover when items are hired out</label></div></td>
                                                @if(isset($insures_details['coverHired']))
                                                    <td>{{$insures_details['coverHired']}}</td>
                                                @else
                                                    <td>--</td>
                                                @endif
                                            </tr>
                                            @endif
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Automatic Reinstatement of sum insured</label></div></td>
                                                @if(isset($insures_details['autoSum']['isAgree']))
                                                    @if($insures_details['autoSum']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['autoSum']['isAgree']}}
                                                                <br>Comments : {{$insures_details['autoSum']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['autoSum']['isAgree']}}</td>
                                                    @endif
                                                @else
                                                    <td>--</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Including the risk of erection, resettling and dismantling</label></div></td>
                                                @if(isset($insures_details['includRisk']))
                                                    <td>{{$insures_details['includRisk']}}</td>
                                                @else
                                                    <td>--</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Tool of trade extension</label></div></td>
                                                @if(isset($insures_details['tool']['isAgree']))
                                                    @if($insures_details['tool']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['tool']['isAgree']}}
                                                                <br>Comments : {{$insures_details['tool']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['tool']['isAgree']}}</td>
                                                    @endif
                                                @else
                                                    <td>--</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">72 Hours clause</label></div></td>
                                                @if(isset($insures_details['hoursClause']))
                                                    <td>{{$insures_details['hoursClause']}}</td>
                                                @else
                                                    <td>--</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Nominated Loss Adjuster Clause</label></div></td>
                                                @if(isset($insures_details['lossAdj']['isAgree']))
                                                    @if($insures_details['lossAdj']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['lossAdj']['isAgree']}}
                                                                <br>Comments : {{$insures_details['lossAdj']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['lossAdj']['isAgree']}}</td>
                                                    @endif
                                                @else
                                                    <td>--</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Primary Insurance Clause</label></div></td>
                                                @if(isset($insures_details['primaryClause']))
                                                    <td>{{$insures_details['primaryClause']}}</td>
                                                @else
                                                    <td>--</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Payment on accounts clause-75%</label></div></td>
                                                @if(isset($insures_details['paymentAccount']['isAgree']))
                                                    @if($insures_details['paymentAccount']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['paymentAccount']['isAgree']}}
                                                                <br>Comments : {{$insures_details['paymentAccount']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['paymentAccount']['isAgree']}}</td>
                                                    @endif
                                                @else
                                                    <td>--</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">85% condition of average</label></div></td>
                                                @if(isset($insures_details['avgCondition']))
                                                    <td>{{$insures_details['avgCondition']}}</td>
                                                @else
                                                    <td>--</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Automatic addition</label></div></td>
                                                @if(isset($insures_details['autoAddition']['isAgree']))
                                                    @if($insures_details['autoAddition']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['autoAddition']['isAgree']}}
                                                                <br>Comments : {{$insures_details['autoAddition']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['autoAddition']['isAgree']}}</td>
                                                    @endif
                                                @else
                                                    <td>--</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Cancellation clause</label></div></td>
                                                @if(isset($insures_details['cancelClause']['isAgree']))
                                                    @if($insures_details['cancelClause']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['cancelClause']['isAgree']}}
                                                                <br>Comments : {{$insures_details['cancelClause']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['cancelClause']['isAgree']}}</td>
                                                    @endif
                                                @else
                                                    <td>--</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Removal of debris</label></div></td>
                                                @if(isset($insures_details['derbis']['isAgree']))
                                                    @if($insures_details['derbis']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['derbis']['isAgree']}}
                                                                <br>Comments : {{$insures_details['derbis']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['derbis']['isAgree']}}</td>
                                                    @endif
                                                @else
                                                    <td>--</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Repair investigation clause</label></div></td>
                                                @if(isset($insures_details['repairClause']['isAgree']))
                                                    @if($insures_details['repairClause']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['repairClause']['isAgree']}}
                                                                <br>Comments : {{$insures_details['repairClause']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['repairClause']['isAgree']}}</td>
                                                    @endif
                                                @else
                                                    <td>--</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Temporary repair clause</label></div></td>
                                                @if(isset($insures_details['tempRepair']['isAgree']))
                                                    @if($insures_details['tempRepair']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['tempRepair']['isAgree']}}
                                                                <br>Comments : {{$insures_details['tempRepair']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['tempRepair']['isAgree']}}</td>
                                                    @endif
                                                @else
                                                    <td>--</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Errors & omission clause</label></div></td>
                                                @if(isset($insures_details['errorOmission']))
                                                    <td>{{$insures_details['errorOmission']}}</td>
                                                @else
                                                    <td>--</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Minimization of loss</label></div></td>
                                                @if(isset($insures_details['minLoss']['isAgree']))
                                                    @if($insures_details['minLoss']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['minLoss']['isAgree']}}
                                                                <br>Comments : {{$insures_details['minLoss']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['minLoss']['isAgree']}}</td>
                                                    @endif
                                                @else
                                                    <td>--</td>
                                                @endif
                                            </tr>
                                            @if(isset($pipeline_details['formData']['affCompany']) && $pipeline_details['formData']['affCompany'] !='' &&
                                            isset($pipeline_details['formData']['crossLiability']))
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Cross liability</label></div></td>
                                                @if(isset($insures_details['crossLiability']['isAgree']))
                                                    @if($insures_details['crossLiability']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['crossLiability']['isAgree']}}
                                                                <br>Comments : {{$insures_details['crossLiability']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['crossLiability']['isAgree']}}</td>
                                                    @endif
                                                @else
                                                    <td>--</td>
                                                @endif
                                            </tr>
                                            @endif
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Including cover for loading/ unloading and delivery risks</label></div></td>
                                                @if(isset($insures_details['coverInclude']))
                                                    <td>{{$insures_details['coverInclude']}}</td>
                                                @else
                                                    <td>--</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Towing charges</label></div></td>
                                                @if(isset($insures_details['towCharge']['isAgree']))
                                                    @if($insures_details['towCharge']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['towCharge']['isAgree']}}
                                                                <br>Comments : {{$insures_details['towCharge']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['towCharge']['isAgree']}}</td>
                                                    @endif
                                                @else
                                                    <td>--</td>
                                                @endif
                                            </tr>
                                            @if(isset($pipeline_details['formData']['policyBank']['policyBank']) && $pipeline_details['formData']['policyBank']['policyBank'] ==true && isset($pipeline_details['formData']['lossPayee']))
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Loss payee clause</label></div></td>
                                                @if(isset($insures_details['lossPayee']))
                                                    <td>{{$insures_details['lossPayee']}}</td>
                                                @else
                                                    <td>--</td>
                                                @endif
                                            </tr>
                                            @endif
                                             <tr>
                                                <td><div class="main_question"><label class="form_label bold">Agency repair</label></div></td>
                                                @if(isset($insures_details['agencyRepair']['isAgree']))
                                                    @if($insures_details['agencyRepair']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['agencyRepair']['isAgree']}}
                                                                <br>Comments : {{$insures_details['agencyRepair']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['agencyRepair']['isAgree']}}</td>
                                                    @endif
                                                @else
                                                    <td>--</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Indemnity to principal</label></div></td>
                                                @if(isset($insures_details['indemnityPrincipal']))
                                                    <td>{{$insures_details['indemnityPrincipal']}}</td>
                                                @else
                                                    <td>--</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Designation of property</label></div></td>
                                                @if(isset($insures_details['propDesign']))
                                                    <td>{{$insures_details['propDesign']}}</td>
                                                @else
                                                    <td>--</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Special condition :It is understood and agreed that exclusion ‘C’ will not apply to accidental losses’</label></div></td>
                                                @if(isset($insures_details['specialAgree']))
                                                    <td>{{$insures_details['specialAgree']}}</td>
                                                @else
                                                    <td>--</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Declaration of sum insured and basis of settlement: Total loss claims will be settled on the current market value of the vehicle on the day of accident and insured should submit 3 valuation report for consideration of loss surveyor</label></div></td>
                                                @if(isset($insures_details['declarationSum']['isAgree']))
                                                    @if($insures_details['declarationSum']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['declarationSum']['isAgree']}}
                                                                <br>Comments : {{$insures_details['declarationSum']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['declarationSum']['isAgree']}}</td>
                                                    @endif
                                                @else
                                                    <td>--</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Salvage: In case of total loss Insurer will give the option to the Insured to purchase the salvage based on the amount of the highest bid obtained by the Insurer</label></div></td>
                                                @if(isset($insures_details['salvage']['isAgree']))
                                                    @if($insures_details['salvage']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['salvage']['isAgree']}}
                                                                <br>Comments : {{$insures_details['salvage']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['salvage']['isAgree']}}</td>
                                                    @endif
                                                @else
                                                    <td>--</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Total Loss:An equipment will be considered as total loss (destroyed) in case the repair cost is 50% or more than the NRV of the equipment (considered as constructive total loss)</label></div></td>
                                                @if(isset($insures_details['totalLoss']['isAgree']))
                                                    @if($insures_details['totalLoss']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['totalLoss']['isAgree']}}
                                                                <br>Comments : {{$insures_details['totalLoss']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['totalLoss']['isAgree']}}</td>
                                                    @endif
                                                @else
                                                    <td>--</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Profit Sharing</label></div></td>
                                                @if(isset($insures_details['profitShare']['isAgree']))
                                                    @if($insures_details['profitShare']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['profitShare']['isAgree']}}
                                                                <br>Comments : {{$insures_details['profitShare']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['profitShare']['isAgree']}}</td>
                                                    @endif
                                                @else
                                                    <td>--</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Claims procedure: Existing claim procedure attached and should form the framework for renewal period</label></div></td>
                                                @if(isset($insures_details['claimPro']['isAgree']))
                                                    @if($insures_details['claimPro']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['claimPro']['isAgree']}}
                                                                <br>Comments : {{$insures_details['claimPro']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['claimPro']['isAgree']}}</td>
                                                    @endif
                                                @else
                                                    <td>--</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Waiver of subrogation against principal</label></div></td>
                                                @if(isset($insures_details['waiver']))
                                                    <td>{{$insures_details['waiver']}}</td>
                                                @else
                                                    <td>--</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Rate</label></div></td>
                                                @if(isset($insures_details['rate']))
                                                    <td>{{number_format($insures_details['rate'],2)}}</td>
                                                @else
                                                    <td>--</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Premium</label></div></td>
                                                @if(isset($insures_details['premium']))
                                                    <td>{{number_format($insures_details['premium'],2)}}</td>
                                                @else
                                                    <td>--</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Payment Terms</label></div></td>
                                                @if(isset($insures_details['payTerm']))
                                                    <td>{{$insures_details['payTerm']}}</td>
                                                @else
                                                    <td>--</td>
                                                @endif
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