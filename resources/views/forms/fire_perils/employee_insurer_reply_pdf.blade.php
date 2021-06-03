
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
                                            @if($pipeline_details['formData']['saleClause'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Sale of interest clause</label></div></td>
                                                    <td>{{$insures_details['saleClause']}}</td>
                                                </tr>
                                            @endif
                                            @if ($pipeline_details['formData']['fireBrigade'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Fire brigade and extinguishing clause</label></div></td>
                                                            @if(isset($insures_details['fireBrigade']['isAgree']))
                                                                @if($insures_details['fireBrigade']['comment']!="")
                                                                    <td class="tooltip_sec">
                                                                        <span>{{$insures_details['fireBrigade']['isAgree']}}
                                                                            <br>Comments : {{$insures_details['fireBrigade']['comment']}}
                                                                        </span>
                                                                    </td>
                                                                @else
                                                                    <td>{{$insures_details['fireBrigade']['isAgree']}}</td>
                                                                @endif
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                </tr>
                                            @endif 
                                            @if ($pipeline_details['formData']['clauseWording'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">72 Hours clause-wording modified- the 72 hours will stretch beyond the expiration of the policy period provided the first earthquake/flood/storm occurred prior to the expiry time of the policy</label></td>
                                                    <td>{{$insures_details['clauseWording']}}</td>
                                                </tr>
                                            @endif

                                            @if ($pipeline_details['formData']['automaticReinstatement'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Automatic reinstatement of sum insured at pro-rata additional premium</label></td>
                                                    <td>{{$insures_details['automaticReinstatement']}}</td>
                                                </tr>
                                            @endif 

                                            @if ($pipeline_details['formData']['capitalClause'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Capital addition clause</label></div></td>
                                                        @if(isset($insures_details['capitalClause']['isAgree']))
                                                            @if($insures_details['capitalClause']['comment']!="")
                                                                <td class="tooltip_sec">
                                                                    <span>{{$insures_details['capitalClause']['isAgree']}}
                                                                        <br>Comments : {{$insures_details['capitalClause']['comment']}}
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>{{$insures_details['capitalClause']['isAgree']}}</td>
                                                            @endif
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                </tr>
                                            @endif 

                                            @if($pipeline_details['formData']['mainClause'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Workmen’s Maintenance clause</label></td>                                                       
                                                    <td>{{$insures_details['mainClause']}}</td>
                                                </tr>
                                            @endif  

                                            @if ($pipeline_details['formData']['repairCost'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Repair investigation costs</label></div></td>
                                                        @if(isset($insures_details['repairCost']['isAgree']))
                                                            @if($insures_details['repairCost']['comment']!="")
                                                                <td class="tooltip_sec">
                                                                    <span>{{$insures_details['repairCost']['isAgree']}}
                                                                        <br>Comments : {{$insures_details['repairCost']['comment']}}
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>{{$insures_details['repairCost']['isAgree']}}</td>
                                                            @endif
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                </tr>
                                            @endif 

                                            @if ($pipeline_details['formData']['debris'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Removal of debris</label></div></td>
                                                    @if(isset($insures_details['debris']['isAgree']))
                                                        @if($insures_details['debris']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['debris']['isAgree']}}
                                                                    <br>Comments : {{$insures_details['debris']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['debris']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif 

                                              
                                            @if($pipeline_details['formData']['reinstatementValClass'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Reinstatement Value  clause (85% condition of  average)</label></td>
                                                    <td>{{$insures_details['reinstatementValClass']}}</td>
                                                </tr>
                                            @endif 
                                            
                                            @if($pipeline_details['formData']['waiver'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Waiver  of subrogation (against affiliates and subsidiaries)</label></td>
                                                    <td>{{$insures_details['waiver']}}</td>
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['trace'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Trace and Access Clause</label></td>
                                                    <td>{{$insures_details['trace']}}</td>
                                                </tr>
                                            @endif

                                            @if ($pipeline_details['formData']['publicClause'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Public authorities clause</label></div></td>
                                                    @if(isset($insures_details['publicClause']['isAgree']))
                                                        @if($insures_details['publicClause']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['publicClause']['isAgree']}}
                                                                    <br>Comments : {{$insures_details['publicClause']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['publicClause']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif   

                                            @if ($pipeline_details['formData']['contentsClause'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">All other contents clause</label></div></td>
                                                    @if(isset($insures_details['contentsClause']['isAgree']))
                                                        @if($insures_details['contentsClause']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['contentsClause']['isAgree']}}
                                                                    <br>Comments : {{$insures_details['contentsClause']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['contentsClause']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif

                                            @if( $pipeline_details['formData']['errorOmission'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Errors & Omissions</label></td>
                                                    <td>{{$insures_details['errorOmission']}}</td>
                                                </tr>
                                            @endif  

                                            @if($pipeline_details['formData']['alterationClause'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Alteration and use  clause</label></td>
                                                    <td>{{$insures_details['alterationClause']}}</td>
                                                </tr>
                                            @endif 

                                            @if($pipeline_details['formData']['tempRemovalClause'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Temporary removal clause</td>
                                                    <td>{{$insures_details['tempRemovalClause']}}</td>
                                                </tr>
                                            @endif   

                                            @if ($pipeline_details['formData']['proFee'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Professional fees clause</label></div></td>
                                                    @if(isset($insures_details['proFee']['isAgree']))
                                                        @if($insures_details['proFee']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['proFee']['isAgree']}}
                                                                    <br>Comments : {{$insures_details['proFee']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['proFee']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif  

                                            @if ($pipeline_details['formData']['expenseClause'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Expediting expense clause</label></div></td>
                                                    @if(isset($insures_details['expenseClause']['isAgree']))
                                                        @if($insures_details['expenseClause']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['expenseClause']['isAgree']}}
                                                                    <br>Comments : {{$insures_details['expenseClause']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['expenseClause']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif  

                                            @if ($pipeline_details['formData']['desigClause'] == true)
                                                    <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Designation of property clause</label></div></td>
                                                    @if(isset($insures_details['desigClause']['isAgree']))
                                                        @if($insures_details['desigClause']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['desigClause']['isAgree']}}
                                                                    <br>Comments : {{$insures_details['desigClause']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['desigClause']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif 

                                            @if($pipeline_details['formData']['buildingInclude'] == true && $pipeline_details['formData']['buildingInclude']!='')
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Adjoining building clause</label></td>
                                                    <td>{{$insures_details['adjBusinessClause']}}</td>
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['cancelThirtyClause'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Cancellation clause-30 days either party subject to pro-rata refund of premium in either case unless a claim attached</label></td>
                                                    <td>{{$insures_details['cancelThirtyClause']}}</td>
                                                 </tr>
                                            @endif   

                                            @if($pipeline_details['formData']['primaryInsuranceClause'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Primary insurance clause</label></td>
                                                    <td>{{$insures_details['primaryInsuranceClause']}}</td>
                                                </tr>
                                            @endif

                                            @if ($pipeline_details['formData']['paymentAccountClause'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Payment on account clause (75%)</label></div></td>
                                                    @if(isset($insures_details['paymentAccountClause']['isAgree']))
                                                        @if($insures_details['paymentAccountClause']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['paymentAccountClause']['isAgree']}}
                                                                    <br>Comments : {{$insures_details['paymentAccountClause']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['paymentAccountClause']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif 
                                            @if($pipeline_details['formData']['nonInvalidClause'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Non-invalidation clause</label></td>
                                                    <td>{{$insures_details['nonInvalidClause']}}</td>
                                                </tr>
                                            @endif   
                                            @if($pipeline_details['formData']['warrantyConditionClause'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Breach of warranty or condition clause</label></td>                                                    
                                                    <td>{{$insures_details['warrantyConditionClause']}}</td>                                                        
                                                </tr>
                                            @endif 
                                            @if ($pipeline_details['formData']['escalationClause'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Escalation clause</label></div></td>                                           
                                                    @if(isset($insures_details['escalationClause']['isAgree']))
                                                        @if($insures_details['escalationClause']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['escalationClause']['isAgree']}}
                                                                    <br>Comments : {{$insures_details['escalationClause']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['escalationClause']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif                                                     
                                                </tr>
                                            @endif 
                                            @if($pipeline_details['formData']['addInterestClause'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Additional Interest Clause</label></td>
                                                    <td>{{$insures_details['addInterestClause']}}</td>
                                                </tr>
                                            @endif 

                                            @if(isset($pipeline_details['formData']['stock']) && $pipeline_details['formData']['stock']!='')
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Stock Declaration clause</label></div></td>
                                                    @if(isset($insures_details['stockDeclaration']['isAgree']))
                                                        @if($insures_details['stockDeclaration']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['stockDeclaration']['isAgree']}}
                                                                    <br>Comments : {{$insures_details['stockDeclaration']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['stockDeclaration']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['improvementClause'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Improvement and betterment clause</label></td>                                                  
                                                    <td>{{$insures_details['improvementClause']}}</td>                                                       
                                                </tr>
                                            @endif 

                                            @if ($pipeline_details['formData']['automaticClause'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Automatic Addition deletion clause to be notified within 30 days period</label></div></td>
                                                    @if(isset($insures_details['automaticClause']['isAgree']))
                                                        @if($insures_details['automaticClause']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['automaticClause']['isAgree']}}
                                                                    <br>Comments : {{$insures_details['automaticClause']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['automaticClause']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif   

                                            @if ($pipeline_details['formData']['reduseLoseClause'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Expense to reduce the loss clause</label></div></td>
                                                    @if(isset($insures_details['reduseLoseClause']['isAgree']))
                                                        @if($insures_details['reduseLoseClause']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['reduseLoseClause']['isAgree']}}
                                                                    <br>Comments : {{$insures_details['reduseLoseClause']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['reduseLoseClause']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['buildingInclude']!='' && 
                                            $pipeline_details['formData']['demolitionClause'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Demolition clause</label></div></td>
                                                    @if(isset($insures_details['demolitionClause']['isAgree']))
                                                        @if($insures_details['demolitionClause']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['demolitionClause']['isAgree']}}
                                                                    <br>Comments : {{$insures_details['demolitionClause']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['demolitionClause']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif 

                                            @if($pipeline_details['formData']['noControlClause'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">No control clause</label></td>
                                                    <td>{{$insures_details['noControlClause']}}</td>
                                                </tr>
                                            @endif
                                            
                                            @if($pipeline_details['formData']['preparationCostClause'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Claims preparation cost clause</label></div></td>
                                                    @if(isset($insures_details['preparationCostClause']['isAgree']))
                                                        @if($insures_details['preparationCostClause']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['preparationCostClause']['isAgree']}}
                                                                    <br>Comments : {{$insures_details['preparationCostClause']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['preparationCostClause']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif 

                                            @if($pipeline_details['formData']['coverPropertyCon'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Cover for property lying in the premises in containers</label></td>
                                                    <td>{{$insures_details['coverPropertyCon']}}</td>
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['personalEffectsEmployee'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Personal effects of employee</label></div></td>
                                                    @if(isset($insures_details['personalEffectsEmployee']['isAgree']))
                                                        @if($insures_details['personalEffectsEmployee']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['personalEffectsEmployee']['isAgree']}}
                                                                    <br>Comments : {{$insures_details['personalEffectsEmployee']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['personalEffectsEmployee']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif 

                                            @if($pipeline_details['formData']['incidentLandTransit'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Incidental Land Transit</label></div></td>
                                                    @if(isset($insures_details['incidentLandTransit']['isAgree']))
                                                        @if($insures_details['incidentLandTransit']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['incidentLandTransit']['isAgree']}}
                                                                    <br>Comments : {{$insures_details['incidentLandTransit']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['incidentLandTransit']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif 

                                            @if($pipeline_details['formData']['lossOrDamage'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Including loss or damage due to subsidence, ground heave or landslip</label></td>
                                                    <td>{{$insures_details['lossOrDamage']}}</td>
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['nominatedLossAdjusterClause'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Nominated Loss Adjuster clause-Insured can select the loss surveyor out of a panel – John Kidd LA, Cunningham Lindsey, & Miller International</label></div></td>
                                                    @if(isset($insures_details['nominatedLossAdjusterClause']['isAgree']))
                                                        @if($insures_details['nominatedLossAdjusterClause']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['nominatedLossAdjusterClause']['isAgree']}}
                                                                    <br>Comments : {{$insures_details['nominatedLossAdjusterClause']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['nominatedLossAdjusterClause']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['sprinkerLeakage'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Sprinkler leakage clause</label></td>
                                                    <td>{{$insures_details['sprinkerLeakage']}}</td>
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['minLossClause'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Minimization of loss clause</label></div></td>   
                                                    @if(isset($insures_details['minLossClause']['isAgree']))
                                                        @if($insures_details['minLossClause']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['minLossClause']['isAgree']}}
                                                                    <br>Comments : {{$insures_details['minLossClause']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['minLossClause']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['costConstruction'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Increased cost of construction</label></div></td>
                                                    @if(isset($insures_details['costConstruction']['isAgree']))
                                                        @if($insures_details['costConstruction']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['costConstruction']['isAgree']}}
                                                                    <br>Comments : {{$insures_details['costConstruction']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['costConstruction']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif                                                      
                                                </tr>
                                            @endif

                                            @if(isset($pipeline_details['formData']['annualRent']) && $pipeline_details['formData']['annualRent']!='')
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Loss of rent</label></div></td>
                                                    @if(isset($insures_details['lossRent']['isAgree']))
                                                        @if($insures_details['lossRent']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['lossRent']['isAgree']}}
                                                                    <br>Comments : {{$insures_details['lossRent']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['lossRent']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif                                                      
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['propertyValuationClause'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Property Valuation clause</label></div></td>
                                                    @if(isset($insures_details['propertyValuationClause']['isAgree']))
                                                        @if($insures_details['propertyValuationClause']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['propertyValuationClause']['isAgree']}}
                                                                    <br>Comments : {{$insures_details['propertyValuationClause']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['propertyValuationClause']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['accidentalDamage'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Including accidental damage to plate glass, interior and exterior signs</label></div></td>
                                                    @if(isset($insures_details['accidentalDamage']['isAgree']))
                                                        @if($insures_details['accidentalDamage']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['accidentalDamage']['isAgree']}}
                                                                    <br>Comments : {{$insures_details['accidentalDamage']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['accidentalDamage']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['auditorsFee'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Auditor’s fee</label></div></td>
                                                    @if(isset($insures_details['auditorsFee']['isAgree']))
                                                        @if($insures_details['auditorsFee']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['auditorsFee']['isAgree']}}
                                                                    <br>Comments : {{$insures_details['auditorsFee']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['auditorsFee']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['smokeSoot'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Smoke and Soot damage extension</label></td>
                                                    <td>{{$insures_details['smokeSoot']}}</td>
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['boilerExplosion'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Boiler explosion extension</label></td>
                                                    <td>{{$insures_details['boilerExplosion']}}</td>
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['chargeAirfreight'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Extra charges for airfreight</label></div></td>
                                                    @if(isset($insures_details['chargeAirfreight']['isAgree']))
                                                        @if($insures_details['chargeAirfreight']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['chargeAirfreight']['isAgree']}}
                                                                    <br>Comments : {{$insures_details['chargeAirfreight']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['chargeAirfreight']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['tempRemoval'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Temporary repair clause</label></td>
                                                    <td>{{$insures_details['tempRemoval']}}</td>
                                                </tr>
                                            @endif  
                                        

                                            @if($pipeline_details['formData']['strikeRiot'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Strike riot and civil commotion clause</label></div></td>
                                                    @if(isset($insures_details['strikeRiot']['isAgree']))
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
                                            @endif

                                            @if($pipeline_details['formData']['coverMechanical'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Cover for  mechanical, electrical and electronic breakdown  for fixed non-mobile plant and machinery</label></td>
                                                    <td>{{$insures_details['coverMechanical']}}</td>
                                                </tr>
                                            @endif   

                                            @if($pipeline_details['formData']['coverExtWork'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Cover for external works including sign boards,  landscaping  including trees in building/label</td>
                                                    <td>{{$insures_details['coverExtWork']}}</td>
                                                </tr>
                                            @endif  
                                            
                                            @if($pipeline_details['formData']['misdescriptionClause'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Misdescription Clause</td>                                                
                                                    <td>{{$insures_details['misdescriptionClause']}}</td>   
                                                </tr>
                                            @endif 


                                            @if($pipeline_details['formData']['otherInsuranceClause'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Other insurance allowed clause</td>
                                                    <td>{{$insures_details['otherInsuranceClause']}}</td>                                                       
                                                </tr>
                                            @endif  

                                            @if($pipeline_details['formData']['automaticAcqClause'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Automatic acquisition clause</td>
                                                    <td>{{$insures_details['automaticAcqClause']}}</td>
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['occupancy']['type']=='Residence' ||  $pipeline_details['formData']['occupancy']['type']=='Labour Camp')
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Cover for alternative accommodation</label></div></td>
                                                    @if(isset($insures_details['coverAlternative']['isAgree']))
                                                        @if($insures_details['coverAlternative']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['coverAlternative']['isAgree']}}
                                                                    <br>Comments : {{$insures_details['coverAlternative']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['coverAlternative']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr> 
                                            @endif 

                                            @if($pipeline_details['formData']['businessType'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Cover for exhibition risks</label></td>
                                                    <td>{{$insures_details['coverExihibition']}}</td>      
                                                 </tr>
                                            @endif

                                            @if (@$pipeline_details['formData']['occupancy']['type'] == 'Warehouse'
                                            || @$pipeline_details['formData']['occupancy']['type'] == 'Factory'
                                            || @$pipeline_details['formData']['occupancy']['type'] == 'Others') 
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Cover for property in the open</label></td>
                                                    <td>{{$insures_details['coverProperty']}}</td>
                                                </tr>
                                            @endif

                                            @if ($pipeline_details['formData']['otherItems'] != '') 
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Including property in the care, custody & control of the insured</label></div></td>
                                                    @if(isset($insures_details['propertyCare']['isAgree']))
                                                        @if($insures_details['propertyCare']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['propertyCare']['isAgree']}}
                                                                    <br>Comments : {{$insures_details['propertyCare']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['propertyCare']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif 

                                            @if($pipeline_details['formData']['minorWorkExt'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Minor works extension</label></div></td>
                                                    @if(isset($insures_details['minorWorkExt']['isAgree']))
                                                        @if($insures_details['minorWorkExt']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['minorWorkExt']['isAgree']}}
                                                                    <br>Comments : {{$insures_details['minorWorkExt']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else 
                                                            <td>{{$insures_details['minorWorkExt']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif 

                                            @if($pipeline_details['formData']['saleInterestClause'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Sale of Interest Clause</td>
                                                    <td>{{$insures_details['saleInterestClause']}}</td>
                                                </tr>
                                            @endif    

                                            @if($pipeline_details['formData']['sueLabourClause'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Sue and labour clause</td>
                                                    <td>{{$insures_details['sueLabourClause']}}</td>
                                                </tr>
                                            @endif 
                                            
                                            @if($pipeline_details['formData']['bankPolicy']['bankPolicy'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Loss payee clause</td>
                                                    <td>{{$insures_details['lossPayee']}}</td>
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['electricalClause'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Electrical clause waiver- Loss or damage by fire to electrical or electronic appliances , installations and wiring insured by this policy arising from or occasioned by over running, overheating excessive current, short circuiting, arcing, self-heating or leakage of electricity from whatever cause (lightning included) is covered</td>
                                                    <td>{{$insures_details['electricalClause']}}</td>
                                                </tr>
                                            @endif  

                                            @if($pipeline_details['formData']['contractPriceClause'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Contract price clause</td>
                                                   <td>{{$insures_details['contractPriceClause']}}</td>
                                                </tr>
                                            @endif    

                                            @if($pipeline_details['formData']['sprinklerUpgradationClause'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Sprinkler upgradation clause</td>
                                                    <td>{{$insures_details['sprinklerUpgradationClause']}}</td>
                                                </tr>
                                            @endif  

                                            @if($pipeline_details['formData']['accidentalFixClass'] == true)
                                                <tr>
                                                <td><div class="main_question"><label class="form_label bold">Accidental damage to fixed glass, glass (other than fixed glass)</label></div></td>
                                                    @if(isset($insures_details['accidentalFixClass']['isAgree']))
                                                        @if($insures_details['accidentalFixClass']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['accidentalFixClass']['isAgree']}}
                                                                    <br>Comments : {{$insures_details['accidentalFixClass']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['accidentalFixClass']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif 
                                            @if($pipeline_details['formData']['electronicInstallation'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Electronic installation, computers, data processing, equipment and other fragile or brittle object</td>
                                                    <td>{{$insures_details['electronicInstallation']}}</td>
                                                </tr>
                                            @endif
                                            @if ($pipeline_details['formData']['businessType'] == "Art galleries/ fine arts collection"
                                            || $pipeline_details['formData']['businessType'] == "Colleges/ Universities/ schools & educational institute"
                                            || $pipeline_details['formData']['businessType'] == "Hotels/ boarding houses/ motels/ service apartments"
                                            || $pipeline_details['formData']['businessType'] == "Hotel multiple cover"
                                            || $pipeline_details['formData']['businessType'] == "Museum/ heritage sites"
                                            ) 
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Cover for curios and work of art</label></td>
                                                    <td>{{$insures_details['coverCurios']}}</td>
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['brandTrademark'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Brand and trademark</td>
                                                    <td>{{$insures_details['brandTrademark']}}</td>
                                                </tr>
                                            @endif 
                                            @if ($pipeline_details['formData']['ownerPrinciple'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Indemnity to owners and principals</label></td>
                                                    <td>{{$insures_details['ownerPrinciple']}}</td>
                                                </tr>
                                            @endif 
                                            @if ($pipeline_details['formData']['conductClause'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Conduct of business clause</label></td>
                                                   <td>{{$insures_details['conductClause']}}</td>
                                                </tr>
                                            @endif  
                                            @if($pipeline_details['formData']['lossNotification'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Loss Notification – ‘as soon as reasonably practicable’</td>
                                                    <td>{{$insures_details['lossNotification']}}</td>
                                                </tr>
                                            @endif 
                                            @if($pipeline_details['formData']['brockersClaimClause'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Brokers Claim Handling Clause : A loss notification received by the Insurance Broker will be deemed as a loss notification to Insurer. All communications flowing between the Insurer, Insured and the appointed Loss Surveyor should be channelized through the Broker, unless there is any unavoidable reasons compelling direct communications between the parties</td>
                                                    <td>{{$insures_details['brockersClaimClause']}}</td>
                                                </tr>
                                            @endif

                                            @if (isset($pipeline_details['formData']['businessInterruption']) && $pipeline_details['formData']['businessInterruption']['business_interruption'] == true) 
                                            @if($pipeline_details['formData']['addCostWorking'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Additional increase in cost of working</td>
                                                    <td>{{$insures_details['addCostWorking']}}</td>
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['claimPreparationClause'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Claims preparation clause</label></div></td>
                                                    @if(isset($insures_details['claimPreparationClause']['isAgree']))
                                                        @if($insures_details['claimPreparationClause']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['claimPreparationClause']['isAgree']}}
                                                                    <br>Comments : {{$insures_details['claimPreparationClause']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['claimPreparationClause']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif 

                                            @if($pipeline_details['formData']['suppliersExtension'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Suppliers extension/customer extension</label></div></td>
                                                    @if(isset($insures_details['suppliersExtension']['isAgree']))
                                                        @if($insures_details['suppliersExtension']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['suppliersExtension']['isAgree']}}
                                                                    <br>Comments : {{$insures_details['suppliersExtension']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['suppliersExtension']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['accountantsClause'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Accountants clause</label></div></td>
                                                    @if(isset($insures_details['accountantsClause']['isAgree']))
                                                        @if($insures_details['accountantsClause']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['accountantsClause']['isAgree']}}
                                                                    <br>Comments : {{$insures_details['accountantsClause']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['accountantsClause']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif 

                                            @if($pipeline_details['formData']['accountPayment'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Payment on account</label></div></td>
                                                    @if(isset($insures_details['accountPayment']['isAgree']))
                                                        @if($insures_details['accountPayment']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['accountPayment']['isAgree']}}
                                                                    <br>Comments : {{$insures_details['accountPayment']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['accountPayment']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif 

                                            @if($pipeline_details['formData']['preventionDenialClause'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Prevention/denial of access</label></div></td>
                                                    @if(isset($insures_details['preventionDenialClause']['isAgree']))
                                                        @if($insures_details['preventionDenialClause']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['preventionDenialClause']['isAgree']}}
                                                                    <br>Comments : {{$insures_details['preventionDenialClause']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['preventionDenialClause']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif 

                                            @if($pipeline_details['formData']['premiumAdjClause'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Premium adjustment clause</label></div></td>
                                                    @if(isset($insures_details['premiumAdjClause']['isAgree']))
                                                        @if($insures_details['premiumAdjClause']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['premiumAdjClause']['isAgree']}}
                                                                    <br>Comments : {{$insures_details['premiumAdjClause']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['premiumAdjClause']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['publicUtilityClause'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Public utilities clause</label></div></td>
                                                    @if(isset($insures_details['publicUtilityClause']['isAgree']))
                                                        @if($insures_details['publicUtilityClause']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['publicUtilityClause']['isAgree']}}
                                                                    <br>Comments : {{$insures_details['publicUtilityClause']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['publicUtilityClause']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif 

                                            @if($pipeline_details['formData']['brockersClaimHandlingClause'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Brokers Claim Handling Clause : A loss notification received by the Insurance Broker will be deemed as a loss notification to Insurer. All communications flowing between the Insurer, Insured and the appointed Loss Surveyor should be channelized through the Broker, unless there is any unavoidable reasons compelling direct communications between the parties</td>
                                                    <td>{{$insures_details['brockersClaimHandlingClause']}}</td>
                                                </tr>
                                            @endif

                                             @if($pipeline_details['formData']['accountsRecievable'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Accounts recievable / Loss of booked debts/label</div></td>
                                                    @if(isset($insures_details['accountsRecievable']['isAgree']))
                                                        @if($insures_details['accountsRecievable']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['accountsRecievable']['isAgree']}}
                                                                    <br>Comments : {{$insures_details['accountsRecievable']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['accountsRecievable']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif 

                                            @if($pipeline_details['formData']['interDependency'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Interdependany clause</td>
                                                    <td>{{$insures_details['interDependency']}}</td>
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['extraExpense'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Extra expense</div></td>
                                                    @if(isset($insures_details['extraExpense']['isAgree']))
                                                        @if($insures_details['extraExpense']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['extraExpense']['isAgree']}}
                                                                    <br>Comments : {{$insures_details['extraExpense']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['extraExpense']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['contaminatedWater'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Contaminated water</td>
                                                    <td>{{$insures_details['contaminatedWater']}}</td>
                                                </tr>
                                            @endif
                                            
                                            @if($pipeline_details['formData']['auditorsFeeCheck'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Auditors fees</div></td>
                                                    @if(isset($insures_details['auditorsFeeCheck']['isAgree']))
                                                        @if($insures_details['auditorsFeeCheck']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['auditorsFeeCheck']['isAgree']}}
                                                                    <br>Comments : {{$insures_details['auditorsFeeCheck']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['auditorsFeeCheck']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['expenseReduceLoss'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Expense to reduce the loss</div></td>
                                                    @if(isset($insures_details['expenseReduceLoss']['isAgree']))
                                                        @if($insures_details['expenseReduceLoss']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['expenseReduceLoss']['isAgree']}}
                                                                    <br>Comments : {{$insures_details['expenseReduceLoss']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['expenseReduceLoss']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['nominatedLossAdjuster'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Nominated loss adjuster</div></td>
                                                    @if(isset($insures_details['nominatedLossAdjuster']['isAgree']))
                                                        @if($insures_details['nominatedLossAdjuster']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['nominatedLossAdjuster']['isAgree']}}
                                                                    <br>Comments : {{$insures_details['nominatedLossAdjuster']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['nominatedLossAdjuster']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['outbreakDiscease'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Outbreak of discease</div></td>
                                                    @if(isset($insures_details['outbreakDiscease']['isAgree']))
                                                        @if($insures_details['outbreakDiscease']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['outbreakDiscease']['isAgree']}}
                                                                    <br>Comments : {{$insures_details['outbreakDiscease']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['outbreakDiscease']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['nonPublicFailure'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Failure of non public power supply</div></td>
                                                    @if(isset($insures_details['nonPublicFailure']['isAgree']))
                                                        @if($insures_details['nonPublicFailure']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['nonPublicFailure']['isAgree']}}
                                                                    <br>Comments : {{$insures_details['nonPublicFailure']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['nonPublicFailure']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['premisesDetails'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Murder, Suicide or outbreak of discease on the premises</div></td>
                                                    @if(isset($insures_details['premisesDetails']['isAgree']))
                                                        @if($insures_details['premisesDetails']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['premisesDetails']['isAgree']}}
                                                                    <br>Comments : {{$insures_details['premisesDetails']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['premisesDetails']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['bombscare'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Bombscare and unexploded devices on the premises</div></td>
                                                    @if(isset($insures_details['bombscare']['isAgree']))
                                                        @if($insures_details['bombscare']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['bombscare']['isAgree']}}
                                                                    <br>Comments : {{$insures_details['bombscare']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['bombscare']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['DenialClause'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Denial of accesss</div></td>
                                                    @if(isset($insures_details['DenialClause']['isAgree']))
                                                        @if($insures_details['DenialClause']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['DenialClause']['isAgree']}}
                                                                    <br>Comments : {{$insures_details['DenialClause']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['DenialClause']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                    </tr>
                                            @endif

                                            @if($pipeline_details['formData']['bookDebits'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Book of Debts</div></td>
                                                    @if(isset($insures_details['bombscare']['isAgree']))
                                                        @if($insures_details['bookDebits']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['bookDebits']['isAgree']}}
                                                                    <br>Comments : {{$insures_details['bookDebits']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['bookDebits']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif

                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['publicFailure'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Failure of public utility</div></td>
                                                    @if(isset($insures_details['publicFailure']['isAgree']))
                                                        @if($insures_details['publicFailure']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['publicFailure']['isAgree']}}
                                                                    <br>Comments : {{$insures_details['publicFailure']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['publicFailure']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif

                                            @if (isset($pipeline_details['formData']['businessInterruption']['noLocations']) &&
                                               $pipeline_details['formData']['businessInterruption']['noLocations'] > 1) 
                                               @if($pipeline_details['formData']['departmentalClause'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Departmental clause</td>
                                                    <td>{{$insures_details['departmentalClause']}}</td>
                                                </tr>
                                                @endif
                                                @if($pipeline_details['formData']['rentLease'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Rent & Lease hold interest</div></td>
                                                        @if(isset($insures_details['rentLease']['isAgree']))
                                                            @if($insures_details['rentLease']['comment']!="")
                                                                <td class="tooltip_sec">
                                                                    <span>{{$insures_details['rentLease']['isAgree']}}
                                                                        <br>Comments : {{$insures_details['rentLease']['comment']}}
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>{{$insures_details['rentLease']['isAgree']}}</td>
                                                            @endif
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    </tr>
                                                 @endif
                                            @endif

                                            @if(isset($pipeline_details['formData']['CoverAccomodation']) && $pipeline_details['formData']['CoverAccomodation']['coverAccomodation'] == true)
                                                 <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Cover for alternate accomodation</div></td>
                                                    @if(isset($insures_details['coverAccomodation']['isAgree']))
                                                        @if($insures_details['coverAccomodation']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['coverAccomodation']['isAgree']}}
                                                                    <br>Comments : {{$insures_details['coverAccomodation']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['coverAccomodation']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['demolitionCost'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Demolition and increased cost of construction</div></td>
                                                    @if(isset($insures_details['demolitionCost']['isAgree']))
                                                        @if($insures_details['demolitionCost']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['demolitionCost']['isAgree']}}
                                                                    <br>Comments : {{$insures_details['demolitionCost']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['demolitionCost']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>  
                                            @endif

                                            @if($pipeline_details['formData']['contingentBusiness'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Contingent business inetruption and contingent extra expense</div></td>
                                                    @if(isset($insures_details['contingentBusiness']['isAgree']))
                                                        @if($insures_details['contingentBusiness']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['contingentBusiness']['isAgree']}}
                                                                    <br>Comments : {{$insures_details['contingentBusiness']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['contingentBusiness']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif

                                            @if($pipeline_details['formData']['nonOwnedProperties'] == true)
                                                    <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Non Owned property in vicinity interuption</div></td>
                                                    @if(isset($insures_details['nonOwnedProperties']['isAgree']))
                                                        @if($insures_details['nonOwnedProperties']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['nonOwnedProperties']['isAgree']}}
                                                                    <br>Comments : {{$insures_details['nonOwnedProperties']['comment']}}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['nonOwnedProperties']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['royalties'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Royalties</td>
                                                    <td>{{$insures_details['royalties']}}</td>
                                                </tr>
                                            @endif
                                        @endif 
                                        @if (isset($pipeline_details['formData']['cliamPremium']) &&
                                            $pipeline_details['formData']['cliamPremium'] == 'combined_data')

                                            @if($pipeline_details['formData']['claimPremiyumDetails']['deductableProperty'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Deductible for Property</td>
                                                    <td>{{number_format($insures_details['claimPremiyumDetails']['deductableProperty'],2)}}</td>
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['claimPremiyumDetails']['deductableBusiness'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Deductible for Business Interruption</td>
                                                    <td>{{number_format($insures_details['claimPremiyumDetails']['deductableBusiness'],2)}}</td>
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['claimPremiyumDetails']['rateCombined'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Rate required (combined)</td>
                                                    <td>{{number_format($insures_details['claimPremiyumDetails']['rateCombined'],2)}}</td>
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['claimPremiyumDetails']['premiumCombined'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Premium required (combined)</td>
                                                    <td>{{number_format($insures_details['claimPremiyumDetails']['premiumCombined'],2)}}</td>
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['claimPremiyumDetails']['brokerage'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Brokerage (combined)</td>
                                                    <td>{{number_format($insures_details['claimPremiyumDetails']['brokerage'],2)}}</td>
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['claimPremiyumDetails']['warrantyProperty'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Warranty (Property)</td>
                                                    <td>{{$insures_details['claimPremiyumDetails']['warrantyProperty']}}</td>
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['claimPremiyumDetails']['warrantyBusiness'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Warranty (Business Interruption)</td>
                                                    <td>{{$insures_details['claimPremiyumDetails']['warrantyBusiness']}}</td>
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['claimPremiyumDetails']['exclusionProperty'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Exclusion (Property)</td>
                                                    <td>{{$insures_details['claimPremiyumDetails']['exclusionProperty']}}</td>
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['claimPremiyumDetails']['exclusionBusiness'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Exclusion (Business Interruption)</td>
                                                    <td>{{$insures_details['claimPremiyumDetails']['exclusionBusiness']}}</td>
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['claimPremiyumDetails']['specialProperty'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Special Condition (Property)</td>
                                                    <td>{{$insures_details['claimPremiyumDetails']['specialProperty']}}</td>
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['claimPremiyumDetails']['specialBusiness'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Special Condition (Business Interruption)</td>
                                                    <td>{{$insures_details['claimPremiyumDetails']['specialBusiness']}}</td>
                                                </tr>
                                            @endif
                                        @endif    
                                        @if (isset($pipeline_details['formData']['cliamPremium']) &&
                                            $pipeline_details['formData']['cliamPremium'] == 'only_fire')

                                            @if($pipeline_details['formData']['claimPremiyumDetails']['deductableProperty'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Deductible</td>
                                                    <td>{{number_format($insures_details['claimPremiyumDetails']['deductableProperty'],2)}}</td>
                                                </tr>
                                            @endif
                                            
                                            @if($pipeline_details['formData']['claimPremiyumDetails']['propertyRate'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Rate required</td>
                                                    <td>{{number_format($insures_details['claimPremiyumDetails']['propertyRate'],2)}}</td>
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['claimPremiyumDetails']['propertyPremium'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Premium required</td>
                                                    <td>{{number_format($insures_details['claimPremiyumDetails']['propertyPremium'],2)}}</td>
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['claimPremiyumDetails']['propertyBrockerage'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Brokerage</td>
                                                   <td>{{number_format($insures_details['claimPremiyumDetails']['propertyBrockerage'],2)}}</td>
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['claimPremiyumDetails']['propertyWarranty'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Warranty </td>
                                                    <td>{{$insures_details['claimPremiyumDetails']['propertyWarranty']}}</td>
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['claimPremiyumDetails']['propertyExclusion'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Exclusion</td>
                                                    <td>{{$insures_details['claimPremiyumDetails']['propertyExclusion']}}</td>
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['claimPremiyumDetails']['propertySpecial'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Special Condition</td>
                                                    <td>{{$insures_details['claimPremiyumDetails']['propertySpecial']}}</td>
                                                </tr>
                                            @endif
                                        @endif  
                                         @if (isset($pipeline_details['formData']['cliamPremium']) &&
                                            $pipeline_details['formData']['cliamPremium'] == 'separate_property')
                                            @if($pipeline_details['formData']['claimPremiyumDetails']['propertySeparateDeductable'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Deductible for (Property)</td>
                                                    <td>{{number_format($insures_details['claimPremiyumDetails']['propertySeparateDeductable'],2)}}</td>
                                                </tr>
                                            @endif
                                           
                                            @if($pipeline_details['formData']['claimPremiyumDetails']['propertySeparateRate'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Rate required (Property)</td>
                                                    <td>{{number_format($insures_details['claimPremiyumDetails']['propertySeparateRate'],2)}}</td>
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['claimPremiyumDetails']['propertySeparatePremium'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Premium required (Property)</td>
                                                    <td>{{number_format($insures_details['claimPremiyumDetails']['propertySeparatePremium'],2)}}</td>
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['claimPremiyumDetails']['propertySeparateBrokerage'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Brokerage (Property)</td>
                                                    <td>{{number_format($insures_details['claimPremiyumDetails']['propertySeparateBrokerage'],2)}}</td>
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['claimPremiyumDetails']['propertySeparateWarranty'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Warranty (Property)</td>
                                                    <td>{{$insures_details['claimPremiyumDetails']['propertySeparateWarranty']}}</td>
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['claimPremiyumDetails']['propertySeparateExclusion'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Exclusion (Property)</td>
                                                    <td>{{$insures_details['claimPremiyumDetails']['propertySeparateExclusion']}}</td>
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['claimPremiyumDetails']['propertySeparateSpecial'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Special Condition (Property)</td>
                                                    <td>{{$insures_details['claimPremiyumDetails']['propertySeparateSpecial']}}</td>
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['claimPremiyumDetails']['businessSeparateDeductable'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Deductible for (Business Interruption)</td>
                                                    <td>{{number_format($insures_details['claimPremiyumDetails']['businessSeparateDeductable'],2)}}</td>
                                                </tr>
                                            @endif
                                           
                                            @if($pipeline_details['formData']['claimPremiyumDetails']['businessSeparateRate'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Rate required (Business Interruption)</td>
                                                    <td>{{number_format($insures_details['claimPremiyumDetails']['businessSeparateRate'],2)}}</td>
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['claimPremiyumDetails']['businessSeparatePremium'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Premium required (Business Interruption)</td>
                                                    <td>{{number_format($insures_details['claimPremiyumDetails']['businessSeparatePremium'],2)}}</td>
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['claimPremiyumDetails']['businessSeparateBrokerage'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Brokerage (Business Interruption)</td>
                                                    <td>{{number_format($insures_details['claimPremiyumDetails']['businessSeparateBrokerage'],2)}}</td>
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['claimPremiyumDetails']['businessSeparateWarranty'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Warranty (Business Interruption)</td>
                                                    <td>{{$insures_details['claimPremiyumDetails']['businessSeparateWarranty']}}</td>
                                                </tr>
                                            @endif
                                            
                                            @if($pipeline_details['formData']['claimPremiyumDetails']['businessSeparateExclusion'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Exclusion (Business Interruption)</td>
                                                    <td>{{$insures_details['claimPremiyumDetails']['businessSeparateExclusion']}}</td>
                                                </tr>
                                            @endif
                                           
                                            @if($pipeline_details['formData']['claimPremiyumDetails']['businessSeparateSpecial'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Special Condition (Business Interruption)</td>
                                                    <td>{{$insures_details['claimPremiyumDetails']['businessSeparateSpecial']}}</td>
                                                </tr>
                                            @endif
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