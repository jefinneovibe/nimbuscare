
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
                                        
                                        @if($pipeline_details['formData']['costWork']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label">
                                                        Additional increase in cost of working
                                                    </label>
                                                </td>
                                                <td>{{$insures_details['costWork']}}</td>
                                            </tr>
                                        @endif

                                        @if($pipeline_details['formData']['claimClause']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">
                                                        Claims preparation clause
                                                 </label></td>
                                                 @if(isset($insures_details['claimClause']))
                                                 @if($insures_details['claimClause']['comment']!="")
                                                     <td class="tooltip_sec">
                                                         <span>{{$insures_details['claimClause']['isAgree']}}
                                                             <br> Comments : {{$insures_details['claimClause']['comment']}}
                                                         </span>
                                                     </td>
                                                 @else
                                                     <td>{{$insures_details['claimClause']['isAgree']}}</td>
                                                 @endif
                                             @endif
                                            </tr>
                                        @endif

                                        @if($pipeline_details['formData']['custExtension']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Suppliers extension/customer extension</label></td>
                                                @if(isset($insures_details['custExtension']))
                                                    @if($insures_details['custExtension']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['custExtension']['isAgree']}}
                                                                <br> Comments : {{$insures_details['custExtension']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['custExtension']['isAgree']}}</td>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endif

                                        @if($pipeline_details['formData']['accountants']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">
                                                        Accountants clause
                                                </label></td>
                                                @if(isset($insures_details['accountants']))
                                                    @if($insures_details['accountants']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['accountants']['isAgree']}}
                                                                <br> Comments : {{$insures_details['accountants']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['accountants']['isAgree']}}</td>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endif

                                        @if($pipeline_details['formData']['payAccount']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">
                                                        Payment on account
                                                </label></td>
                                                @if(isset($insures_details['payAccount']))
                                                    @if($insures_details['payAccount']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['payAccount']['isAgree']}}
                                                                <br> Comments : {{$insures_details['payAccount']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['payAccount']['isAgree']}}</td>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endif

                                        @if($pipeline_details['formData']['denialAccess']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">
                                                        Prevention/denial of access
                                                </label></td>
                                                @if(isset($insures_details['denialAccess']))
                                                @if($insures_details['denialAccess']['comment']!="")
                                                    <td class="tooltip_sec">
                                                        <span>{{$insures_details['denialAccess']['isAgree']}}
                                                            <br> Comments : {{$insures_details['denialAccess']['comment']}}
                                                        </span>
                                                    </td>
                                                @else
                                                    <td>{{$insures_details['denialAccess']['isAgree']}}</td>
                                                @endif
                                            @endif
                                            </tr>
                                        @endif

                                        @if($pipeline_details['formData']['premiumClause']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">
                                                        Premium adjustment clause
                                                </label></td>
                                                @if(isset($insures_details['premiumClause']))
                                                @if($insures_details['premiumClause']['comment']!="")
                                                    <td class="tooltip_sec">
                                                        <span>{{$insures_details['premiumClause']['isAgree']}}
                                                            <br> Comments : {{$insures_details['premiumClause']['comment']}}
                                                        </span>
                                                    </td>
                                                @else
                                                    <td>{{$insures_details['premiumClause']['isAgree']}}</td>
                                                @endif
                                            @endif
                                            </tr>
                                        @endif

                                        @if($pipeline_details['formData']['utilityClause']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">
                                                        Public utilities clause
                                                </label></td>
                                                @if(isset($insures_details['utilityClause']))
                                                    @if($insures_details['utilityClause']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['utilityClause']['isAgree']}}
                                                                <br> Comments : {{$insures_details['utilityClause']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['utilityClause']['isAgree']}}</td>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endif

                                        @if($pipeline_details['formData']['brokerClaim']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">
                                                        Brokers Claim Handling Clause : A loss notification received by the Insurance Broker will be deemed as a loss notification to Insurer. All communications flowing between the Insurer, Insured and the appointed Loss Surveyor should be channelized through the Broker, unless there is any unavoidable reasons compelling direct communications between the parties
                                                </label></td>
                                                <td>{{$insures_details['brokerClaim']}}</td>
                                            </tr>
                                        @endif

                                        @if($pipeline_details['formData']['bookedDebts']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">
                                                        Accounts recievable / Loss of booked debts
                                                </label></td>
                                                @if(isset($insures_details['bookedDebts']))
                                                    @if($insures_details['bookedDebts']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['bookedDebts']['isAgree']}}
                                                                <br> Comments : {{$insures_details['bookedDebts']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['bookedDebts']['isAgree']}}</td>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endif

                                        @if($pipeline_details['formData']['depclause']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">
                                                        Interdependany clause
                                                </label></td>
                                                <td>{{$insures_details['depclause']}}</td>
                                            </tr>
                                        @endif

                                        @if($pipeline_details['formData']['extraExpense']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">
                                                        Extra expense
                                                </label></td>
                                                @if(isset($insures_details['extraExpense']))
                                                    @if($insures_details['extraExpense']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['extraExpense']['isAgree']}}
                                                                <br> Comments : {{$insures_details['extraExpense']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['extraExpense']['isAgree']}}</td>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endif

                                        @if($pipeline_details['formData']['water']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">
                                                        Contaminated water
                                                </label></td>
                                                <td>{{$insures_details['water']}}</td>
                                            </tr>
                                        @endif

                                        @if($pipeline_details['formData']['auditorFee']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">
                                                        Auditors fees
                                                </label></td>
                                                @if(isset($insures_details['auditorFee']))
                                                    @if($insures_details['auditorFee']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['auditorFee']['isAgree']}}
                                                                <br> Comments : {{$insures_details['auditorFee']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['auditorFee']['isAgree']}}</td>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endif

                                        @if($pipeline_details['formData']['expenseLaws']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">
                                                        Expense to reduce the laws 
                                                </label></td>
                                                @if(isset($insures_details['expenseLaws']))
                                                    @if($insures_details['expenseLaws']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['expenseLaws']['isAgree']}}
                                                                <br> Comments : {{$insures_details['expenseLaws']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['expenseLaws']['isAgree']}}</td>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endif

                                        @if($pipeline_details['formData']['lossAdjuster']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">
                                                        Nominated loss adjuster
                                                </label></td>
                                                @if(isset($insures_details['lossAdjuster']))
                                                    @if($insures_details['lossAdjuster']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['lossAdjuster']['isAgree']}}
                                                                <br> Comments : {{$insures_details['lossAdjuster']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['lossAdjuster']['isAgree']}}</td>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endif

                                        @if($pipeline_details['formData']['discease']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">
                                                        Outbreak of discease
                                                </label></td>
                                                @if(isset($insures_details['discease']))
                                                    @if($insures_details['discease']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['discease']['isAgree']}}
                                                                <br> Comments : {{$insures_details['discease']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['discease']['isAgree']}}</td>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endif

                                        @if($pipeline_details['formData']['powerSupply']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">
                                                        Failure of non public power supply
                                                </label></td>
                                                @if(isset($insures_details['powerSupply']))
                                                    @if($insures_details['powerSupply']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['powerSupply']['isAgree']}}
                                                                <br> Comments : {{$insures_details['powerSupply']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['powerSupply']['isAgree']}}</td>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endif

                                        @if($pipeline_details['formData']['condition1']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">
                                                        Murder, Suicide or outbreak of discease on the premises
                                                </label></td>
                                                @if(isset($insures_details['condition1']))
                                                @if($insures_details['condition1']['comment']!="")
                                                    <td class="tooltip_sec">
                                                        <span>{{$insures_details['condition1']['isAgree']}}
                                                            <br> Comments : {{$insures_details['condition1']['comment']}}
                                                        </span>
                                                    </td>
                                                @else
                                                    <td>{{$insures_details['condition1']['isAgree']}}</td>
                                                @endif
                                            @endif
                                            </tr>
                                        @endif

                                        @if($pipeline_details['formData']['condition2']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">
                                                        Bombscare and unexploded devices on the premises
                                                </label></td>
                                                @if(isset($insures_details['condition2']))
                                                    @if($insures_details['condition2']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['condition2']['isAgree']}}
                                                                <br> Comments : {{$insures_details['condition2']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['condition2']['isAgree']}}</td>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endif

                                        @if($pipeline_details['formData']['bookofDebts']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">
                                                        Book of Debts
                                                </label></td>
                                                @if(isset($insures_details['bookofDebts']))
                                                    @if($insures_details['bookofDebts']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['bookofDebts']['isAgree']}}
                                                                <br> Comments : {{$insures_details['bookofDebts']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['bookofDebts']['isAgree']}}</td>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endif
                                        @if($pipeline_details['formData']['risk']>1 && $pipeline_details['formData']['depclause']==true)
                                        <tr>
                                            <td class="main_question"><label class="form_label bold">
                                                    Departmental clause
                                            </label></td>
                                            <td>{{$insures_details['depclause']}}</td>
                                        </tr>
                                        @endif
                                        @if($pipeline_details['formData']['rent']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">
                                                        Rent & Lease hold interest 
                                                </label></td>
                                                @if(isset($insures_details['rent']))
                                                    @if($insures_details['rent']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['rent']['isAgree']}}
                                                                <br> Comments : {{$insures_details['rent']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['rent']['isAgree']}}</td>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endif

                                        {{--  --}}

                                        @if($pipeline_details['formData']['hasaccomodation']=="yes")
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">
                                                        Cover for alternate accomodation
                                                </label></td>
                                                @if(isset($insures_details['hasaccomodation']))
                                                    @if($insures_details['hasaccomodation']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['hasaccomodation']['isAgree']}}
                                                                <br> Comments : {{$insures_details['hasaccomodation']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['hasaccomodation']['isAgree']}}</td>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endif

                                        @if($pipeline_details['formData']['costofConstruction']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">
                                                        Demolition and increased cost of construction
                                                </label></td>
                                                @if(isset($insures_details['costofConstruction']))
                                                    @if($insures_details['costofConstruction']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['costofConstruction']['isAgree']}}
                                                                <br> Comments : {{$insures_details['costofConstruction']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['costofConstruction']['isAgree']}}</td>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endif
                                        @if($pipeline_details['formData']['ContingentExpense']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">
                                                        Contingent business inetruption and contingent extra expense
                                                </label></td>
                                                @if(isset($insures_details['ContingentExpense']))
                                                    @if($insures_details['ContingentExpense']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['ContingentExpense']['isAgree']}}
                                                                <br> Comments : {{$insures_details['ContingentExpense']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['ContingentExpense']['isAgree']}}</td>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endif
                                        @if($pipeline_details['formData']['interuption']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">
                                                        Non Owned property in vicinity interuption
                                                </label></td>
                                                @if(isset($insures_details['interuption']))
                                                    @if($insures_details['interuption']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['interuption']['isAgree']}}
                                                                <br> Comments : {{$insures_details['interuption']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['interuption']['isAgree']}}</td>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endif
                                        @if($pipeline_details['formData']['Royalties']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label">
                                                        Royalties
                                                         
                                                    </label>
                                                </td>
                                                <td>{{$insures_details['Royalties']}}</td>
                                            </tr>
                                        @endif
                                        @if($pipeline_details['formData']['deductible'])
                                            <tr>
                                                <td class="main_question"><label class="form_label">
                                                        Deductible
                                                    </label>
                                                </td>
                                                <td>{{number_format(trim($insures_details['deductible']),2)}}</td>
                                            </tr>
                                        @endif

                                        @if($pipeline_details['formData']['ratep'])
                                            <tr>
                                                <td class="main_question"><label class="form_label">
                                                        Rate/premium required
                                                    </label>
                                                </td>
                                                <td>{{number_format(trim($insures_details['ratep']),2)}}</td>
                                            </tr>
                                        @endif

                                        @if($pipeline_details['formData']['brokerage'])
                                            <tr>
                                                <td class="main_question"><label class="form_label">
                                                        Brokerage
                                                    </label>
                                                </td>
                                                <td>{{number_format(trim($insures_details['brokerage']),2)}}</td>
                                            </tr>
                                        @endif

                                        @if($pipeline_details['formData']['spec_condition'])
                                            <tr>
                                                <td class="main_question"><label class="form_label">
                                                        Special Condition
                                                    </label>
                                                </td>
                                                <td>{{number_format(trim($insures_details['spec_condition']),2)}}</td>
                                            </tr>
                                        @endif

                                        @if($pipeline_details['formData']['warranty'])
                                            <tr>
                                                <td class="main_question"><label class="form_label">
                                                        Warranty
                                                    </label>
                                                </td>
                                                <td>{{number_format(trim($insures_details['warranty']),2)}}</td>
                                            </tr>
                                        @endif
                                        @if($pipeline_details['formData']['exclusion'])
                                            <tr>
                                                <td class="main_question"><label class="form_label">
                                                        Exclusion
                                                    </label>
                                                </td>
                                                <td>{{number_format(trim($insures_details['exclusion']),2)}}</td>
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