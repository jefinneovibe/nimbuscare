
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
                                        
                                        @if($pipeline_details['formData']['coverLoss']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label">
                                                        Cover for loss or damage due to  Riots and Strikes
                                                    </label>
                                                </td>
                                                <td>{{$insures_details['coverLoss']}}</td>
                                            </tr>
                                        @endif

                                        @if($pipeline_details['formData']['coverDishonest']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">
                                                        Cover for dishonesty  of the employees if found out within 7 days
                                                 </label></td>
                                                <td>{{$insures_details['coverDishonest']}}</td>
                                            </tr>
                                        @endif

                                        @if($pipeline_details['formData']['coverHoldup']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Cover for hold up</label></td>
                                                <td>{{$insures_details['coverHoldup']}}</td>
                                            </tr>
                                        @endif

                                        @if($pipeline_details['formData']['lossDamage']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">
                                                        Loss or damage to cases / bags while being used for carriage of money
                                                </label></td>
                                                @if(isset($insures_details['lossDamage']))
                                                    @if($insures_details['lossDamage']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['lossDamage']['isAgree']}}
                                                                <br> Comments : {{$insures_details['lossDamage']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['lossDamage']['isAgree']}}</td>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endif

                                        @if($pipeline_details['formData']['claimCost']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">
                                                        Claims Preparation cost
                                                </label></td>
                                                @if(isset($insures_details['claimCost']))
                                                    @if($insures_details['claimCost']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['claimCost']['isAgree']}}
                                                                <br> Comments : {{$insures_details['claimCost']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['claimCost']['isAgree']}}</td>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endif

                                        @if($pipeline_details['formData']['additionalPremium']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">
                                                        Automatic reinstatement of sum insured  at pro-rata additional premium
                                                </label></td>
                                                <td>{{$insures_details['additionalPremium']}}</td>
                                            </tr>
                                        @endif

                                        @if(isset($pipeline_details['formData']['storageRisk']) && $pipeline_details['formData']['storageRisk']==true &&  ($pipeline_details['formData']['businessType']=="Bank/ lenders/ financial institution/ currency exchange"
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
                                                <td class="main_question"><label class="form_label bold">
                                                        Automatic increase to 4 times the approved limits during week ends and public holidays for storage risks
                                                </label></td>
                                                <td>{{$insures_details['storageRisk']}}</td>
                                            </tr>
                                        @endif

                                        @if($pipeline_details['formData']['lossNotification']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">
                                                        Loss notification – ‘as soon as reasonably practicable’
                                                </label></td>
                                                @if(isset($insures_details['lossNotification']))
                                                    @if($insures_details['lossNotification']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['lossNotification']['isAgree']}}
                                                                <br> Comments : {{$insures_details['lossNotification']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['lossNotification']['isAgree']}}</td>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endif

                                        @if($pipeline_details['formData']['cancellation']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">
                                                        Cancellation – 30 days notice by either party; refund of premium at pro-rata unless a claim has attached 
                                                </label></td>
                                                <td>{{$insures_details['cancellation']}}</td>
                                            </tr>
                                        @endif

                                        @if($pipeline_details['formData']['thirdParty']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">
                                                        Third party money's for which responsibility is assumed will be covered
                                                </label></td>
                                                @if(isset($insures_details['thirdParty']))
                                                    @if($insures_details['thirdParty']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['thirdParty']['isAgree']}}
                                                                <br> Comments : {{$insures_details['thirdParty']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['thirdParty']['isAgree']}}</td>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endif

                                        @if($pipeline_details['formData']['carryVehicle']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">
                                                        Carry by own vehicle / hired vehicles and / or on foot personal money of owners
                                                </label></td>
                                                @if(isset($insures_details['carryVehicle']))
                                                    @if($insures_details['carryVehicle']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['carryVehicle']['isAgree']}}
                                                                <br> Comments : {{$insures_details['carryVehicle']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['carryVehicle']['isAgree']}}</td>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endif

                                        @if($pipeline_details['formData']['nominatedLoss']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">
                                                        Nominated Loss adjuster – Panel Crawford Intl, Cunningham Lindsey, Miller International, John Kidd LA, Insured can  select
                                                </label></td>
                                                @if(isset($insures_details['nominatedLoss']))
                                                    @if($insures_details['nominatedLoss']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['nominatedLoss']['isAgree']}}
                                                                <br> Comments : {{$insures_details['nominatedLoss']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['nominatedLoss']['isAgree']}}</td>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endif

                                        @if($pipeline_details['formData']['errorsClause']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">
                                                        Errors and Omissions clause
                                                </label></td>
                                                <td>{{$insures_details['errorsClause']}}</td>
                                            </tr>
                                        @endif

                                        @if($pipeline_details['formData']['personalAssault']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">
                                                        Cover for personal assault
                                                </label></td>
                                                @if(isset($insures_details['personalAssault']))
                                                    @if($insures_details['personalAssault']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['personalAssault']['isAgree']}}
                                                                <br> Comments : {{$insures_details['personalAssault']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['personalAssault']['isAgree']}}</td>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endif

                                        @if($pipeline_details['formData']['accountantFees']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">
                                                        Auditor’s fees/ accountant fees 
                                                </label></td>
                                                @if(isset($insures_details['accountantFees']))
                                                    @if($insures_details['accountantFees']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['accountantFees']['isAgree']}}
                                                                <br> Comments : {{$insures_details['accountantFees']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['accountantFees']['isAgree']}}</td>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endif

                                        @if($pipeline_details['formData']['sustainedFees']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">
                                                        Cover for damages sustained to safe
                                                </label></td>
                                                @if(isset($insures_details['sustainedFees']))
                                                    @if($insures_details['sustainedFees']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['sustainedFees']['isAgree']}}
                                                                <br> Comments : {{$insures_details['sustainedFees']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['sustainedFees']['isAgree']}}</td>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endif

                                        @if($pipeline_details['formData']['primartClause']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">
                                                        Primary Insurance clause
                                                </label></td>
                                                <td>{{$insures_details['primartClause']}}</td>
                                            </tr>
                                        @endif

                                        @if($pipeline_details['formData']['accountClause']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">
                                                        Payment on account clause
                                                </label></td>
                                                @if(isset($insures_details['accountClause']))
                                                    @if($insures_details['accountClause']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['accountClause']['isAgree']}}
                                                                <br> Comments : {{$insures_details['accountClause']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['accountClause']['isAgree']}}</td>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endif

                                        @if($pipeline_details['formData']['lossParkingAReas']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">
                                                        Cover for loss from unattended vehicle if it was left in locked condition at designated parking areas
                                                </label></td>
                                                <td>{{$insures_details['lossParkingAReas']}}</td>
                                            </tr>
                                        @endif

                                        @if($pipeline_details['formData']['worldwideCover']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">
                                                        Cover for loss of money whilst in the personal possession of authorized employees (Worldwide cover)
                                                </label></td>
                                                @if(isset($insures_details['worldwideCover']))
                                                    @if($insures_details['worldwideCover']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['worldwideCover']['isAgree']}}
                                                                <br> Comments : {{$insures_details['worldwideCover']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['worldwideCover']['isAgree']}}</td>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endif

                                        @if($pipeline_details['formData']['locationAddition']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">
                                                        Automatic addition of location
                                                </label></td>
                                                @if(isset($insures_details['locationAddition']))
                                                    @if($insures_details['locationAddition']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['locationAddition']['isAgree']}}
                                                                <br> Comments : {{$insures_details['locationAddition']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['locationAddition']['isAgree']}}</td>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endif

                                        @if(($pipeline_details['formData']['agencies']=='yes') && isset($pipeline_details['formData']['moneyCarrying']) && $pipeline_details['formData']['moneyCarrying']==true )
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">
                                                        Money carrying / pooling / storage by any group company employees / security agencies to be covered anywhere in the country 
                                                </label></td>
                                                @if(isset($insures_details['moneyCarrying']))
                                                    @if($insures_details['moneyCarrying']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['moneyCarrying']['isAgree']}}
                                                                <br> Comments : {{$insures_details['moneyCarrying']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['moneyCarrying']['isAgree']}}</td>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endif

                                        @if($pipeline_details['formData']['parties']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label">
                                                        Brokers Claim Handling Clause : A loss notification received by the 
                                                        Insurance Broker will be deemed as a loss notification to Insurer. All
                                                         communications flowing between the Insurer, Insured and the appointed 
                                                         Loss Surveyor should be channelized through the Broker, unless there is 
                                                         any unavoidable reasons compelling direct communications between the parties
                                                    </label>
                                                </td>
                                                <td>{{$insures_details['parties']}}</td>
                                            </tr>
                                        @endif

                                        @if($pipeline_details['formData']['personalEffects']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">
                                                        Loss or damage to personal effect
                                                </label></td>
                                                @if(isset($insures_details['personalEffects']))
                                                    @if($insures_details['personalEffects']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['personalEffects']['isAgree']}}
                                                                <br> Comments : {{$insures_details['personalEffects']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['personalEffects']['isAgree']}}</td>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endif

                                        @if($pipeline_details['formData']['holdUp']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">
                                                        Cover to include house breaking, theft and burglary from safe or strong room and hold up or attempt of hold up
                                                </label></td>
                                                @if(isset($insures_details['holdUp']))
                                                    @if($insures_details['holdUp']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['holdUp']['isAgree']}}
                                                                <br> Comments : {{$insures_details['holdUp']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['holdUp']['isAgree']}}</td>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endif

                                        @if($pipeline_details['formData']['transitdRate'])
                                            <tr>
                                                <td class="main_question"><label class="form_label">
                                                        Rate required (Money in Transit) (in %)
                                                    </label>
                                                </td>
                                                <td>{{$insures_details['transitdRate']}}</td>
                                            </tr>
                                        @endif

                                        @if($pipeline_details['formData']['safeRate'])
                                            <tr>
                                                <td class="main_question"><label class="form_label">
                                                        Rate required (Money in Safe) (in %)
                                                    </label>
                                                </td>
                                                <td>{{$insures_details['safeRate']}}</td>
                                            </tr>
                                        @endif

                                        @if($pipeline_details['formData']['premiumTransit'])
                                            <tr>
                                                <td class="main_question"><label class="form_label">
                                                        Premium required (Money in Transit) (in %)
                                                    </label>
                                                </td>
                                                <td>{{$insures_details['premiumTransit']}}</td>
                                            </tr>
                                        @endif

                                        @if($pipeline_details['formData']['premiumSafe'])
                                            <tr>
                                                <td class="main_question"><label class="form_label">
                                                        Premium required (Money in Safe) (in %)
                                                    </label>
                                                </td>
                                                <td>{{$insures_details['premiumSafe']}}</td>
                                            </tr>
                                        @endif

                                        @if($pipeline_details['formData']['brokerage'])
                                            <tr>
                                                <td class="main_question"><label class="form_label">
                                                        Brokerage
                                                    </label>
                                                </td>
                                                <td>{{$insures_details['brokerage']}}</td>
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