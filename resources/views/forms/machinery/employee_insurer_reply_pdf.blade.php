
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
                                        
                                        @if($pipeline_details['formData']['localclause']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">
                                                    Local Jurisdiction Clause
                                                 </label></td>
                                                 @if(isset($insures_details['localclause']))
                                                 @if($insures_details['localclause']['comment']!="")
                                                     <td class="tooltip_sec">
                                                         <span>{{$insures_details['localclause']['isAgree']}}
                                                             <br> Comments : {{$insures_details['localclause']['comment']}}
                                                         </span>
                                                     </td>
                                                 @else
                                                     <td>{{$insures_details['localclause']['isAgree']}}</td>
                                                 @endif
                                             @endif
                                            </tr>
                                        @endif

                                        @if($pipeline_details['formData']['express']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Overtime, night works and express freight</label></td>
                                                @if(isset($insures_details['express']))
                                                    @if($insures_details['express']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['express']['isAgree']}}
                                                                <br> Comments : {{$insures_details['express']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['express']['isAgree']}}</td>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endif

                                        @if($pipeline_details['formData']['airfreight']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">
                                                    Airfreight
                                                </label></td>
                                                @if(isset($insures_details['airfreight']))
                                                    @if($insures_details['airfreight']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['airfreight']['isAgree']}}
                                                                <br> Comments : {{$insures_details['airfreight']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['airfreight']['isAgree']}}</td>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endif
                                        @if($pipeline_details['formData']['addpremium']==true)
                                        <tr>
                                            <td class="main_question"><label class="form_label bold">
                                                Automatic Reinstatement of sum insured at pro rata additional premium
                                            </label></td>
                                            @if(isset($insures_details['addpremium']))
                                            @if($insures_details['addpremium']['comment']!="")
                                                <td class="tooltip_sec">
                                                    <span>{{$insures_details['addpremium']['isAgree']}}
                                                        <br> Comments : {{$insures_details['addpremium']['comment']}}
                                                    </span>
                                                </td>
                                            @else
                                                <td>{{$insures_details['addpremium']['isAgree']}}</td>
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
                                        @if($pipeline_details['formData']['primaryclause']==true)
                                        <tr>
                                            <td class="main_question"><label class="form_label">
                                                Primary Insurance clause
                                                </label>
                                            </td>
                                            <td>{{$insures_details['primaryclause']}}</td>
                                        </tr>
                                    @endif
                                    @if($pipeline_details['formData']['premiumClaim']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label">
                                                    Cancellation – 60 days notice by either party subject to pro-rata refund of premium unless a claim has attached
                                                    </label>
                                                </td>
                                                <td>{{$insures_details['premiumClaim']}}</td>
                                            </tr>
                                        @endif
                                        @if($pipeline_details['formData']['lossnotification']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">
                                                    Loss Notification – ‘as soon as reasonably practicable’
                                                </label></td>
                                                @if(isset($insures_details['lossnotification']))
                                                @if($insures_details['lossnotification']['comment']!="")
                                                    <td class="tooltip_sec">
                                                        <span>{{$insures_details['lossnotification']['isAgree']}}
                                                            <br> Comments : {{$insures_details['lossnotification']['comment']}}
                                                        </span>
                                                    </td>
                                                @else
                                                    <td>{{$insures_details['lossnotification']['isAgree']}}</td>
                                                @endif
                                            @endif
                                            </tr>
                                        @endif

                                        @if($pipeline_details['formData']['adjustmentPremium']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">
                                                    Adjustment of sum insured and premium (Mre-410)
                                                </label></td>
                                                @if(isset($insures_details['adjustmentPremium']))
                                                    @if($insures_details['adjustmentPremium']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['adjustmentPremium']['isAgree']}}
                                                                <br> Comments : {{$insures_details['adjustmentPremium']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['adjustmentPremium']['isAgree']}}</td>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endif

                                        

                                        @if($pipeline_details['formData']['temporaryclause']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">
                                                    Temporary repairs clause
                                                </label></td>
                                                @if(isset($insures_details['temporaryclause']))
                                                    @if($insures_details['temporaryclause']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['temporaryclause']['isAgree']}}
                                                                <br> Comments : {{$insures_details['temporaryclause']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['temporaryclause']['isAgree']}}</td>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endif

                                        
                                        @if($pipeline_details['formData']['automaticClause']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">
                                                    Automatic addition clause
                                                </label></td>
                                                @if(isset($insures_details['automaticClause']))
                                                    @if($insures_details['automaticClause']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['automaticClause']['isAgree']}}
                                                                <br> Comments : {{$insures_details['automaticClause']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['automaticClause']['isAgree']}}</td>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endif

                                      

                                        @if($pipeline_details['formData']['capitalclause']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">
                                                    Capital addition clause
                                                </label></td>
                                                @if(isset($insures_details['capitalclause']))
                                                    @if($insures_details['capitalclause']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['capitalclause']['isAgree']}}
                                                                <br> Comments : {{$insures_details['capitalclause']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['capitalclause']['isAgree']}}</td>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endif

                                        @if($pipeline_details['formData']['debris']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">
                                                    Removal of debris 
                                                </label></td>
                                                @if(isset($insures_details['debris']))
                                                    @if($insures_details['debris']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['debris']['isAgree']}}
                                                                <br> Comments : {{$insures_details['debris']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['debris']['isAgree']}}</td>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endif

                                        @if($pipeline_details['formData']['property']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">
                                                    Designation of property
                                                </label></td>
                                                @if(isset($insures_details['property']))
                                                    @if($insures_details['property']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['property']['isAgree']}}
                                                                <br> Comments : {{$insures_details['property']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['property']['isAgree']}}</td>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endif
                                        
                                        @if($pipeline_details['formData']['errorclause']==true)
                                        <tr>
                                            <td class="main_question"><label class="form_label bold">
                                                Errors and omission clause
                                            </label></td>
                                            <td>{{$insures_details['errorclause']}}</td>
                                        </tr>
                                        @endif

                                        @if(@$pipeline_details['formData']['aff_company']!='' && isset($pipeline_details['formData']['waiver']) && $pipeline_details['formData']['waiver']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">
                                                    Waiver of subrogation
                                                </label></td>
                                                @if(isset($insures_details['waiver']))
                                                    @if($insures_details['waiver']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['waiver']['isAgree']}}
                                                                <br> Comments : {{$insures_details['waiver']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['waiver']['isAgree']}}</td>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endif

                                        @if($pipeline_details['formData']['claimclause']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">
                                                    Claims preparation clause
                                                </label></td>
                                                @if(isset($insures_details['claimclause']))
                                                    @if($insures_details['claimclause']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['claimclause']['isAgree']}}
                                                                <br> Comments : {{$insures_details['claimclause']['comment']}}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['claimclause']['isAgree']}}</td>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endif
                                        @if($pipeline_details['formData']['Innocent']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label">
                                                    Innocent non-disclosure
                                                         
                                                    </label>
                                                </td>
                                                <td>{{$insures_details['Innocent']}}</td>
                                            </tr>
                                        @endif
                                        @if($pipeline_details['formData']['Noninvalidation']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">
                                                    Non-invalidation clause
                                                </label></td>
                                                <td>{{$insures_details['Noninvalidation']}}</td>
                                            </tr>
                                        @endif

                                        @if($pipeline_details['formData']['brokerclaim']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">
                                                        Brokers Claim Handling Clause : A loss notification received by the Insurance Broker will be deemed as a loss notification to Insurer. All communications flowing between the Insurer, Insured and the appointed Loss Surveyor should be channelized through the Broker, unless there is any unavoidable reasons compelling direct communications between the parties
                                                </label></td>
                                                <td>{{$insures_details['brokerclaim']}}</td>
                                            </tr>
                                        @endif

                                        {{-- @if($pipeline_details['formData']['deductible']) --}}
                                            <tr>
                                                <td class="main_question"><label class="form_label">
                                                    Deductible for (Machinary Breakdown): 
                                                    </label>
                                                </td>
                                                <td>{{number_format(trim($insures_details['deductm']),2)}}</td>
                                            </tr>
                                        {{-- @endif --}}

                                        {{-- @if($pipeline_details['formData']['ratep']) --}}
                                            <tr>
                                                <td class="main_question"><label class="form_label">
                                                    Rate required (Machinary Breakdown):
                                                    </label>
                                                </td>
                                                <td>{{number_format(trim($insures_details['ratem']),2)}}</td>
                                            </tr>
                                        {{-- @endif --}}

                                        {{-- @if($pipeline_details['formData']['brokerage']) --}}
                                            <tr>
                                                <td class="main_question"><label class="form_label">
                                                    Premium required (Machinary Breakdown): 
                                                    </label>
                                                </td>
                                                <td>{{number_format(trim($insures_details['premiumm']),2)}}</td>
                                            </tr>
                                        {{-- @endif --}}

                                        {{-- @if($pipeline_details['formData']['spec_condition']) --}}
                                            <tr>
                                                <td class="main_question"><label class="form_label">
                                                    Brokerage (Machinary Breakdown)
                                                    </label>
                                                </td>
                                                <td>{{number_format(trim($insures_details['brokeragem']),2)}}</td>
                                            </tr>
                                        {{-- @endif --}}

                                        {{-- @if($pipeline_details['formData']['warranty']) --}}
                                            <tr>
                                                <td class="main_question"><label class="form_label">
                                                    Warranty (Machinary Breakdown)
                                                    </label>
                                                </td>
                                                <td>{{$insures_details['warrantym']}}</td>
                                            </tr>
                                        {{-- @endif --}}
                                        {{-- @if($pipeline_details['formData']['exclusion']) --}}
                                            <tr>
                                                <td class="main_question"><label class="form_label">
                                                    Exclusion (Machinary Breakdown)
                                                    </label>
                                                </td>
                                                <td>{{$insures_details['exclusionm']}}</td>
                                            </tr>
                                        {{-- @endif --}}
                                        <tr>
                                            <td class="main_question"><label class="form_label">
                                                Special Condition (Machinary Breakdown)
                                                </label>
                                            </td>
                                            <td>{{$insures_details['specialm']}}</td>
                                        </tr>
                                        {{-- @if($pipeline_details['formData']['deductible']) --}}
                                        <tr>
                                            <td class="main_question"><label class="form_label">
                                                Deductible for (Business Interruption): 
                                                </label>
                                            </td>
                                            <td>{{number_format(trim($insures_details['deductb']),2)}}</td>
                                        </tr>
                                    {{-- @endif --}}

                                    {{-- @if($pipeline_details['formData']['ratep']) --}}
                                        <tr>
                                            <td class="main_question"><label class="form_label">
                                                Rate required (Business Interruption):
                                                </label>
                                            </td>
                                            <td>{{number_format(trim($insures_details['rateb']),2)}}</td>
                                        </tr>
                                    {{-- @endif --}}

                                    {{-- @if($pipeline_details['formData']['brokerage']) --}}
                                        <tr>
                                            <td class="main_question"><label class="form_label">
                                                Premium required (Business Interruption): 
                                                </label>
                                            </td>
                                            <td>{{number_format(trim($insures_details['premiumb']),2)}}</td>
                                        </tr>
                                    {{-- @endif --}}

                                    {{-- @if($pipeline_details['formData']['spec_condition']) --}}
                                        <tr>
                                            <td class="main_question"><label class="form_label">
                                                Brokerage (Business Interruption)
                                                </label>
                                            </td>
                                            <td>{{number_format(trim($insures_details['brokerageb']),2)}}</td>
                                        </tr>
                                    {{-- @endif --}}

                                    {{-- @if($pipeline_details['formData']['warranty']) --}}
                                        <tr>
                                            <td class="main_question"><label class="form_label">
                                                Warranty (Business Interruption)
                                                </label>
                                            </td>
                                            <td>{{$insures_details['warrantyb']}}</td>
                                        </tr>
                                    {{-- @endif --}}
                                    {{-- @if($pipeline_details['formData']['exclusion']) --}}
                                        <tr>
                                            <td class="main_question"><label class="form_label">
                                                Exclusion (Business Interruption)
                                                </label>
                                            </td>
                                            <td>{{$insures_details['exclusionb']}}</td>
                                        </tr>
                                    {{-- @endif --}}
                                    <tr>
                                        <td class="main_question"><label class="form_label">
                                            Special Condition (Business Interruption)
                                            </label>
                                        </td>
                                        <td>{{$insures_details['specialb']}}</td>
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