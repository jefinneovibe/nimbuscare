
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


    <style>
        /* .page_break {page-break-before: always !important; } */
    </style>


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
                                <h2>Proposal for property</h2>
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
                                    <table class="comparison table table-bordered" cellpadding="0" cellspacing="0" style="width: 100%">
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
                                            <td class="main_question"><label class="form_label bold">Adjoining building clause</label></td>
                                            @for ($i = 0; $i < $insure_count; $i++)
                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                    <td>{{$insures_details[$i]['adjBusinessClause']}}</td>
                                                @endif
                                            @endfor
                                        </tr>
                                        @if(isset($pipeline_details['formData']['stock']) && $pipeline_details['formData']['stock']!='')
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Stock Declaration clause</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['stockDeclaration']['isAgree']))
                                                            @if($insures_details[$i]['stockDeclaration']['comment']!="")
                                                                <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['stockDeclaration']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['stockDeclaration']['comment']}}
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>{{$insures_details[$i]['stockDeclaration']['isAgree']}}</td>
                                                            @endif
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif
                                        @if(isset($pipeline_details['formData']['annualRent']) && $pipeline_details['formData']['annualRent']!='')
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Loss of rent</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['lossRent']['isAgree']))
                                                            @if($insures_details[$i]['lossRent']['comment']!="")
                                                                <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['lossRent']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['lossRent']['comment']}}
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>{{$insures_details[$i]['lossRent']['isAgree']}}</td>
                                                            @endif
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif
                                        @if($pipeline_details['formData']['businessType']=="Hotels/ boarding houses/ motels/ service apartments" ||
                                                $pipeline_details['formData']['businessType']=="Hotel multiple cover")
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Cover for personal effects of staff / guests property / valuables</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['personalStaff']['isAgree']))
                                                            @if($insures_details[$i]['personalStaff']['comment']!="")
                                                                <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['personalStaff']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['personalStaff']['comment']}}
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>{{$insures_details[$i]['personalStaff']['isAgree']}}</td>
                                                            @endif
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>    
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Cover to include unregistered motorised vehicles (like passenger, luggage, laundry carts) used on or around the premises</label></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        <td>{{$insures_details[$i]['coverInclude']}}</td>
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif  
                                        @if($pipeline_details['formData']['businessType']=="Cafes & Restaurant"
                                            || $pipeline_details['formData']['businessType']=="Clothing manufacturing"
                                            || $pipeline_details['formData']['businessType']=="Computer hardware trading/ sales"
                                            || $pipeline_details['formData']['businessType']=="Confectionery/ dairy products processing"
                                            || $pipeline_details['formData']['businessType']=="Cotton ginning wool/ textile manufacturing"
                                            || $pipeline_details['formData']['businessType']=="Department stores/ shopping malls"
                                            || $pipeline_details['formData']['businessType']=="Food & beverage manufacturers"
                                            || $pipeline_details['formData']['businessType']=="Hotels/ boarding houses/ motels/ service apartments"
                                            || $pipeline_details['formData']['businessType']=="Hotel multiple cover"
                                            || $pipeline_details['formData']['businessType']=="Livestock"
                                            || $pipeline_details['formData']['businessType']=="Mega malls & commercial centers"
                                            || $pipeline_details['formData']['businessType']=="Recreational clubs/Theme & water parks"
                                            || $pipeline_details['formData']['businessType']=="Restaurant/ catering services"
                                            || $pipeline_details['formData']['businessType']=="Souk and similar markets"
                                            || $pipeline_details['formData']['businessType']=="Supermarkets / hypermarket/ other retail shops"
                                            || $pipeline_details['formData']['businessType']=="Textile mills/ traders/ sales"
                                            || $pipeline_details['formData']['businessType']=="Warehouse/ cold storage"
                                            )
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Seasonal increase in stocks</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['seasonalIncrease']['isAgree']))
                                                            @if($insures_details[$i]['seasonalIncrease']['comment']!="")
                                                                <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['seasonalIncrease']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['seasonalIncrease']['comment']}}
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>{{$insures_details[$i]['seasonalIncrease']['isAgree']}}</td>
                                                            @endif
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>   
                                        @endif 
                                        @if($pipeline_details['formData']['occupancy']['type']=='Residence')
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Cover for alternative accommodation</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['coverAlternative']['isAgree']))
                                                            @if($insures_details[$i]['coverAlternative']['comment']!="")
                                                                <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['coverAlternative']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['coverAlternative']['comment']}}
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>{{$insures_details[$i]['coverAlternative']['isAgree']}}</td>
                                                            @endif
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr> 
                                        @endif 
                                        @if ($pipeline_details['formData']['businessType'] == "Cafes & Restaurant"
                                            || $pipeline_details['formData']['businessType'] == "Clothing manufacturing"
                                            || $pipeline_details['formData']['businessType'] == "Computer hardware trading/ sales"
                                            || $pipeline_details['formData']['businessType'] == "Confectionery/ dairy products processing"
                                            || $pipeline_details['formData']['businessType'] == "Cotton ginning wool/ textile manufacturing"
                                            || $pipeline_details['formData']['businessType'] == "Department stores/ shopping malls"
                                            || $pipeline_details['formData']['businessType'] == "Food & beverage manufacturers"
                                            || $pipeline_details['formData']['businessType'] == "Hotels/ boarding houses/ motels/ service apartments"
                                            || $pipeline_details['formData']['businessType'] == "Hotel multiple cover"
                                            || $pipeline_details['formData']['businessType'] == "Livestock"
                                            || $pipeline_details['formData']['businessType'] == "Mega malls & commercial centers"
                                            || $pipeline_details['formData']['businessType'] == "Recreational clubs/Theme & water parks"
                                            || $pipeline_details['formData']['businessType'] == "Restaurant/ catering services"
                                            || $pipeline_details['formData']['businessType'] == "Souk and similar markets"
                                            || $pipeline_details['formData']['businessType'] == "Supermarkets / hypermarket/ other retail shops"
                                            || $pipeline_details['formData']['businessType'] == "Textile mills/ traders/ sales"
                                            || $pipeline_details['formData']['businessType'] == "Warehouse/ cold storage"
                                            )  
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Cover for exhibition risks</label></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        <td>{{$insures_details[$i]['coverExihibition']}}</td>
                                                    @endif
                                                @endfor
                                             </tr>
                                        @endif
                                        @if (@$pipeline_details['formData']['occupancy']['type'] == 'Warehouse'
                                            || @$pipeline_details['formData']['occupancy']['type'] == 'Factory'
                                            || @$pipeline_details['formData']['occupancy']['type'] == 'Others') 
                                            <tr class="page">
                                                <td class="main_question"><label class="form_label bold">Cover for property in the open</label></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        <td>{{$insures_details[$i]['coverProperty']}}</td>
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif
                                        @if ($pipeline_details['formData']['otherItems'] != '') 
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Including property in the care, custody & control of the insured</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['propertyCare']['isAgree']))
                                                            @if($insures_details[$i]['propertyCare']['comment']!="")
                                                                <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['propertyCare']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['propertyCare']['comment']}}
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>{{$insures_details[$i]['propertyCare']['isAgree']}}</td>
                                                            @endif
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif 
                                        <tr>
                                            <td class="main_question"><label class="form_label bold">Cover for property in the open</label></td>
                                            @for ($i = 0; $i < $insure_count; $i++)
                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                    <td>{{$insures_details[$i]['lossPayee']}}</td>
                                                @endif
                                            @endfor
                                        </tr>
                                        @if ($pipeline_details['formData']['businessType'] == "Art galleries/ fine arts collection"
                                            || $pipeline_details['formData']['businessType'] == "Colleges/ Universities/ schools & educational institute"
                                            || $pipeline_details['formData']['businessType'] == "Hotels/ boarding houses/ motels/ service apartments"
                                            || $pipeline_details['formData']['businessType'] == "Hotel multiple cover"
                                            || $pipeline_details['formData']['businessType'] == "Museum/ heritage sites"
                                            ) 
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Cover for curios and work of art</label></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        <td>{{$insures_details[$i]['coverCurios']}}</td>
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif
                                        @if ($pipeline_details['formData']['indemnityOwner'] == true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Indemnity to owners and principals</label></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        <td>{{$insures_details[$i]['indemnityOwner']}}</td>
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif        
                                        @if ($pipeline_details['formData']['conductClause'] == true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Conduct of business clause</label></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        <td>{{$insures_details[$i]['conductClause']}}</td>
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif        
                                        @if ($pipeline_details['formData']['saleClause'] == true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Sale of interest clause</label></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        <td>{{$insures_details[$i]['saleClause']}}</td>
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif        
                                        @if ($pipeline_details['formData']['fireBrigade'] == true)
                                             <tr>
                                                <td><div class="main_question"><label class="form_label bold">Fire brigade and extinguishing clause</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['fireBrigade']['isAgree']))
                                                            @if($insures_details[$i]['fireBrigade']['comment']!="")
                                                                <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['fireBrigade']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['fireBrigade']['comment']}}
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>{{$insures_details[$i]['fireBrigade']['isAgree']}}</td>
                                                            @endif
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif 
                                        @if ($pipeline_details['formData']['clauseWording'] == true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">72 Hours clause-wording modified- the 72 hours will stretch beyond the expiration of the policy period provided the first earthquake/flood/storm occurred prior to the expiry time of the policy</label></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        <td>{{$insures_details[$i]['clauseWording']}}</td>
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif        
                                        @if ($pipeline_details['formData']['automaticReinstatement'] == true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Automatic reinstatement of sum insured at pro-rata additional premium</label></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        <td>{{$insures_details[$i]['automaticReinstatement']}}</td>
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif 
                                        @if ($pipeline_details['formData']['capitalClause'] == true)
                                             <tr>
                                                <td><div class="main_question"><label class="form_label bold">Capital addition clause</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['capitalClause']['isAgree']))
                                                            @if($insures_details[$i]['capitalClause']['comment']!="")
                                                                <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['capitalClause']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['capitalClause']['comment']}}
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>{{$insures_details[$i]['capitalClause']['isAgree']}}</td>
                                                            @endif
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif 
                                        @if($pipeline_details['formData']['mainClause'] == true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Workmen’s Maintenance clause</label></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        <td>{{$insures_details[$i]['mainClause']}}</td>
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif  
                                        @if ($pipeline_details['formData']['repairCost'] == true)
                                             <tr>
                                                <td><div class="main_question"><label class="form_label bold">Repair investigation costs</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['repairCost']['isAgree']))
                                                            @if($insures_details[$i]['repairCost']['comment']!="")
                                                                <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['repairCost']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['repairCost']['comment']}}
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>{{$insures_details[$i]['repairCost']['isAgree']}}</td>
                                                            @endif
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif     
                                        @if ($pipeline_details['formData']['debris'] == true)
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
                                        @if($pipeline_details['formData']['reinstatementValClass'] == true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Reinstatement Value  clause (85% condition of  average)</label></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        <td>{{$insures_details[$i]['reinstatementValClass']}}</td>
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif   
                                        @if($pipeline_details['formData']['waiver'] == true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Waiver  of subrogation (against affiliates and subsidiaries)</label></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        <td>{{$insures_details[$i]['waiver']}}</td>
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif
                                        @if ($pipeline_details['formData']['publicClause'] == true)
                                             <tr>
                                                <td><div class="main_question"><label class="form_label bold">Public authorities clause</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['publicClause']['isAgree']))
                                                            @if($insures_details[$i]['publicClause']['comment']!="")
                                                                <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['publicClause']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['publicClause']['comment']}}
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>{{$insures_details[$i]['publicClause']['isAgree']}}</td>
                                                            @endif
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif     
                                        @if ($pipeline_details['formData']['contentsClause'] == true)
                                             <tr>
                                                <td><div class="main_question"><label class="form_label bold">All other contents clause</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['contentsClause']['isAgree']))
                                                            @if($insures_details[$i]['contentsClause']['comment']!="")
                                                                <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['contentsClause']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['contentsClause']['comment']}}
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>{{$insures_details[$i]['contentsClause']['isAgree']}}</td>
                                                            @endif
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif  
                                        @if($pipeline_details['formData']['buildingInclude'] != '' && $pipeline_details['formData']['errorOmission'] == true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Errors & Omissions</label></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        <td>{{$insures_details[$i]['errorOmission']}}</td>
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif   
                                        @if($pipeline_details['formData']['alterationClause'] == true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Alteration and use  clause</label></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        <td>{{$insures_details[$i]['alterationClause']}}</td>
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif   
                                        @if($pipeline_details['formData']['tradeAccess'] == true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Trace and Access</label></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        <td>{{$insures_details[$i]['tradeAccess']}}</td>
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif   
                                        @if($pipeline_details['formData']['tempRemoval'] == true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Temporary repair clause</label></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        <td>{{$insures_details[$i]['tempRemoval']}}</td>
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif  
                                        @if ($pipeline_details['formData']['proFee'] == true)
                                             <tr>
                                                <td><div class="main_question"><label class="form_label bold">Professional fees clause</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['proFee']['isAgree']))
                                                            @if($insures_details[$i]['proFee']['comment']!="")
                                                                <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['proFee']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['proFee']['comment']}}
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>{{$insures_details[$i]['proFee']['isAgree']}}</td>
                                                            @endif
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif  
                                        @if ($pipeline_details['formData']['expenseClause'] == true)
                                             <tr>
                                                <td><div class="main_question"><label class="form_label bold">Expediting expense clause</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['expenseClause']['isAgree']))
                                                            @if($insures_details[$i]['expenseClause']['comment']!="")
                                                                <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['expenseClause']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['expenseClause']['comment']}}
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>{{$insures_details[$i]['expenseClause']['isAgree']}}</td>
                                                            @endif
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif  
                                        @if ($pipeline_details['formData']['desigClause'] == true)
                                             <tr>
                                                <td><div class="main_question"><label class="form_label bold">Designation of property clause</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['desigClause']['isAgree']))
                                                            @if($insures_details[$i]['desigClause']['comment']!="")
                                                                <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['desigClause']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['desigClause']['comment']}}
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>{{$insures_details[$i]['desigClause']['isAgree']}}</td>
                                                            @endif
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif 
                                        @if($pipeline_details['formData']['cancelThirtyClause'] == true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Cancellation clause-30 days either party subject to pro-rata refund of premium in either case unless a claim attached</label></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        <td>{{$insures_details[$i]['cancelThirtyClause']}}</td>
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif   
                                        @if($pipeline_details['formData']['primaryInsuranceClause'] == true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Primary insurance clause</label></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        <td>{{$insures_details[$i]['primaryInsuranceClause']}}</td>
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif
                                        @if ($pipeline_details['formData']['paymentAccountClause'] == true)
                                             <tr>
                                                <td><div class="main_question"><label class="form_label bold">Payment on account clause (75%)</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['paymentAccountClause']['isAgree']))
                                                            @if($insures_details[$i]['paymentAccountClause']['comment']!="")
                                                                <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['paymentAccountClause']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['paymentAccountClause']['comment']}}
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>{{$insures_details[$i]['paymentAccountClause']['isAgree']}}</td>
                                                            @endif
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif 
                                        @if($pipeline_details['formData']['nonInvalidClause'] == true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Non-invalidation clause</label></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        <td>{{$insures_details[$i]['nonInvalidClause']}}</td>
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif   
                                        @if($pipeline_details['formData']['warrantyConditionClause'] == true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Breach of warranty or condition clause</label></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        <td>{{$insures_details[$i]['warrantyConditionClause']}}</td>
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif 
                                        @if ($pipeline_details['formData']['escalationClause'] == true)
                                             <tr>
                                                <td><div class="main_question"><label class="form_label bold">Escalation clause</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['escalationClause']['isAgree']))
                                                            @if($insures_details[$i]['escalationClause']['comment']!="")
                                                                <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['escalationClause']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['escalationClause']['comment']}}
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>{{$insures_details[$i]['escalationClause']['isAgree']}}</td>
                                                            @endif
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif 
                                        @if($pipeline_details['formData']['addInterestClause'] == true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Additional Interest Clause</label></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        <td>{{$insures_details[$i]['addInterestClause']}}</td>
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif   
                                        @if($pipeline_details['formData']['improvementClause'] == true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Improvement and betterment clause</label></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        <td>{{$insures_details[$i]['improvementClause']}}</td>
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif 
                                        @if ($pipeline_details['formData']['automaticClause'] == true)
                                             <tr>
                                                <td><div class="main_question"><label class="form_label bold">Automatic Addition deletion clause to be notified within 30 days period</label></div></td>
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
                                        @if ($pipeline_details['formData']['reduseLoseClause'] == true)
                                             <tr>
                                                <td><div class="main_question"><label class="form_label bold">Expense to reduce the loss clause</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['reduseLoseClause']['isAgree']))
                                                            @if($insures_details[$i]['reduseLoseClause']['comment']!="")
                                                                <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['reduseLoseClause']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['reduseLoseClause']['comment']}}
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>{{$insures_details[$i]['reduseLoseClause']['isAgree']}}</td>
                                                            @endif
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif
                                        @if($pipeline_details['formData']['buildingInclude']!='' && 
                                          $pipeline_details['formData']['demolitionClause'] == true)
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Demolition clause</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['demolitionClause']['isAgree']))
                                                            @if($insures_details[$i]['demolitionClause']['comment']!="")
                                                                <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['demolitionClause']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['demolitionClause']['comment']}}
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>{{$insures_details[$i]['demolitionClause']['isAgree']}}</td>
                                                            @endif
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif 
                                        @if($pipeline_details['formData']['noControlClause'] == true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">No control clause</label></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        <td>{{$insures_details[$i]['noControlClause']}}</td>
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif
                                        @if($pipeline_details['formData']['preparationCostClause'] == true)
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Claims preparation cost clause</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['preparationCostClause']['isAgree']))
                                                            @if($insures_details[$i]['preparationCostClause']['comment']!="")
                                                                <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['preparationCostClause']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['preparationCostClause']['comment']}}
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>{{$insures_details[$i]['preparationCostClause']['isAgree']}}</td>
                                                            @endif
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif 
                                        @if($pipeline_details['formData']['coverPropertyCon'] == true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Cover for property lying in the premises in containers</label></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        <td>{{$insures_details[$i]['coverPropertyCon']}}</td>
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif
                                        @if($pipeline_details['formData']['personalEffectsEmployee'] == true)
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Personal effects of employee including tools and bicycles</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['personalEffectsEmployee']['isAgree']))
                                                            @if($insures_details[$i]['personalEffectsEmployee']['comment']!="")
                                                                <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['personalEffectsEmployee']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['personalEffectsEmployee']['comment']}}
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>{{$insures_details[$i]['personalEffectsEmployee']['isAgree']}}</td>
                                                            @endif
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif 
                                        @if($pipeline_details['formData']['incidentLandTransit'] == true)
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Incidental Land Transit</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['incidentLandTransit']['isAgree']))
                                                            @if($insures_details[$i]['incidentLandTransit']['comment']!="")
                                                                <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['incidentLandTransit']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['incidentLandTransit']['comment']}}
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>{{$insures_details[$i]['incidentLandTransit']['isAgree']}}</td>
                                                            @endif
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif 
                                        @if($pipeline_details['formData']['lossOrDamage'] == true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Including loss or damage due to subsidence, ground heave or landslip</label></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        <td>{{$insures_details[$i]['lossOrDamage']}}</td>
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif
                                        @if($pipeline_details['formData']['nominatedLossAdjusterClause'] == true)
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Nominated Loss Adjuster clause-Insured can select the loss surveyor out of a panel – John Kidd LA, Cunningham Lindsey, & Miller International</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['nominatedLossAdjusterClause']['isAgree']))
                                                            @if($insures_details[$i]['nominatedLossAdjusterClause']['comment']!="")
                                                                <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['nominatedLossAdjusterClause']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['nominatedLossAdjusterClause']['comment']}}
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>{{$insures_details[$i]['nominatedLossAdjusterClause']['isAgree']}}</td>
                                                            @endif
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif
                                        @if($pipeline_details['formData']['sprinkerLeakage'] == true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Sprinkler leakage clause</label></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        <td>{{$insures_details[$i]['sprinkerLeakage']}}</td>
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif
                                        @if($pipeline_details['formData']['minLossClause'] == true)
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Minimization of loss clause</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['minLossClause']['isAgree']))
                                                            @if($insures_details[$i]['minLossClause']['comment']!="")
                                                                <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['minLossClause']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['minLossClause']['comment']}}
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>{{$insures_details[$i]['minLossClause']['isAgree']}}</td>
                                                            @endif
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif
                                        @if($pipeline_details['formData']['costConstruction'] == true)
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Increased cost of construction</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['costConstruction']['isAgree']))
                                                            @if($insures_details[$i]['costConstruction']['comment']!="")
                                                                <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['costConstruction']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['costConstruction']['comment']}}
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>{{$insures_details[$i]['costConstruction']['isAgree']}}</td>
                                                            @endif
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif
                                        @if($pipeline_details['formData']['propertyValuationClause'] == true)
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Property Valuation clause</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['propertyValuationClause']['isAgree']))
                                                            @if($insures_details[$i]['propertyValuationClause']['comment']!="")
                                                                <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['propertyValuationClause']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['propertyValuationClause']['comment']}}
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>{{$insures_details[$i]['propertyValuationClause']['isAgree']}}</td>
                                                            @endif
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif
                                        @if($pipeline_details['formData']['accidentalDamage'] == true)
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Including accidental damage to plate glass, interior and exterior signs</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['accidentalDamage']['isAgree']))
                                                            @if($insures_details[$i]['accidentalDamage']['comment']!="")
                                                                <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['accidentalDamage']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['accidentalDamage']['comment']}}
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>{{$insures_details[$i]['accidentalDamage']['isAgree']}}</td>
                                                            @endif
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif
                                        @if($pipeline_details['formData']['auditorsFee'] == true)
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Auditor’s fee</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['auditorsFee']['isAgree']))
                                                            @if($insures_details[$i]['auditorsFee']['comment']!="")
                                                                <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['auditorsFee']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['auditorsFee']['comment']}}
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>{{$insures_details[$i]['auditorsFee']['isAgree']}}</td>
                                                            @endif
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif
                                        @if($pipeline_details['formData']['smokeSoot'] == true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Smoke and Soot damage extension</label></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        <td>{{$insures_details[$i]['smokeSoot']}}</td>
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif
                                        @if($pipeline_details['formData']['boilerExplosion'] == true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Boiler explosion extension</label></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        <td>{{$insures_details[$i]['boilerExplosion']}}</td>
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif
                                        @if($pipeline_details['formData']['strikeRiot'] == true)
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Strike riot and civil commotion clause</label></div></td>
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
                                        @endif
                                        @if($pipeline_details['formData']['chargeAirfreight'] == true)
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Extra charges for airfreight</label></div></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['chargeAirfreight']['isAgree']))
                                                            @if($insures_details[$i]['chargeAirfreight']['comment']!="")
                                                                <td class="tooltip_sec">
                                                                    <span>{{$insures_details[$i]['chargeAirfreight']['isAgree']}}
                                                                        <br>Comments : {{$insures_details[$i]['chargeAirfreight']['comment']}}
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td>{{$insures_details[$i]['chargeAirfreight']['isAgree']}}</td>
                                                            @endif
                                                        @else
                                                            <td>--</td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif




                                        @if ($pipeline_details['formData']['machinery'] != '') 
                                            @if($pipeline_details['formData']['maliciousDamage'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Malicious damage / mischief, vandalism</label></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            <td>{{$insures_details[$i]['maliciousDamage']}}</td>
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['burglaryExtension'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Burglary Extension</label></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            <td>{{$insures_details[$i]['burglaryExtension']}}</td>
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['burglaryFacilities'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Burglary Extension for diesel tank and similar storage facilities in the open</label></div></td>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['burglaryFacilities']['isAgree']))
                                                                    @if($insures_details[$i]['burglaryFacilities']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details[$i]['burglaryFacilities']['isAgree']}}
                                                                                <br>Comments : {{$insures_details[$i]['burglaryFacilities']['comment']}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details[$i]['burglaryFacilities']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['tsunami'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Tsunami</label></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            <td>{{$insures_details[$i]['burglaryExtension']}}</td>
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif 
                                            @if($pipeline_details['formData']['mobilePlant'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Cover for mobile plant</label></div></td>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['mobilePlant']['isAgree']))
                                                                    @if($insures_details[$i]['mobilePlant']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details[$i]['mobilePlant']['isAgree']}}
                                                                                <br>Comments : {{$insures_details[$i]['mobilePlant']['comment']}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details[$i]['mobilePlant']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                </tr>
                                            @endif 
                                            @if($pipeline_details['formData']['clearanceDrains'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Clearance of drains</label></div></td>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['clearanceDrains']['isAgree']))
                                                                    @if($insures_details[$i]['clearanceDrains']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details[$i]['clearanceDrains']['isAgree']}}
                                                                                <br>Comments : {{$insures_details[$i]['clearanceDrains']['comment']}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details[$i]['clearanceDrains']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['accidentalFire'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Accidental discharge of fire protection</label></div></td>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['accidentalFire']['isAgree']))
                                                                    @if($insures_details[$i]['accidentalFire']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details[$i]['accidentalFire']['isAgree']}}
                                                                                <br>Comments : {{$insures_details[$i]['accidentalFire']['comment']}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details[$i]['accidentalFire']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['locationgSource'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Locating source of leak</label></div></td>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['locationgSource']['isAgree']))
                                                                    @if($insures_details[$i]['locationgSource']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details[$i]['locationgSource']['isAgree']}}
                                                                                <br>Comments : {{$insures_details[$i]['locationgSource']['comment']}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details[$i]['locationgSource']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['reWriting'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Re-writing of records</label></div></td>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['reWriting']['isAgree']))
                                                                    @if($insures_details[$i]['reWriting']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details[$i]['reWriting']['isAgree']}}
                                                                                <br>Comments : {{$insures_details[$i]['reWriting']['comment']}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details[$i]['reWriting']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['landSlip'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Landslip full subsidence and ground heave</label></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            <td>{{$insures_details[$i]['landSlip']}}</td>
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['civilAuthority'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Civil authority clause</label></div></td>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['civilAuthority']['isAgree']))
                                                                    @if($insures_details[$i]['civilAuthority']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details[$i]['civilAuthority']['isAgree']}}
                                                                                <br>Comments : {{$insures_details[$i]['civilAuthority']['comment']}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details[$i]['civilAuthority']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['documentsPlans'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Documents / plans / specification clause</label></div></td>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['documentsPlans']['isAgree']))
                                                                    @if($insures_details[$i]['documentsPlans']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details[$i]['documentsPlans']['isAgree']}}
                                                                                <br>Comments : {{$insures_details[$i]['documentsPlans']['comment']}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details[$i]['documentsPlans']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['propertyConstruction'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Property held intrust for comission</label></div></td>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['propertyConstruction']['isAgree']))
                                                                    @if($insures_details[$i]['propertyConstruction']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details[$i]['propertyConstruction']['isAgree']}}
                                                                                <br>Comments : {{$insures_details[$i]['propertyConstruction']['comment']}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details[$i]['propertyConstruction']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['architecture'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Architecture or surveyor, consulting engineer & other professional fee</label></div></td>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['architecture']['isAgree']))
                                                                    @if($insures_details[$i]['architecture']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details[$i]['architecture']['isAgree']}}
                                                                                <br>Comments : {{$insures_details[$i]['architecture']['comment']}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details[$i]['architecture']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['automaticExtension'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Automatic extension for one month</label></div></td>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['automaticExtension']['isAgree']))
                                                                    @if($insures_details[$i]['automaticExtension']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details[$i]['automaticExtension']['isAgree']}}
                                                                                <br>Comments : {{$insures_details[$i]['automaticExtension']['comment']}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details[$i]['automaticExtension']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['mortguageClause'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Mortgage clause</label></div></td>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['mortguageClause']['isAgree']))
                                                                    @if($insures_details[$i]['mortguageClause']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details[$i]['mortguageClause']['isAgree']}}
                                                                                <br>Comments : {{$insures_details[$i]['mortguageClause']['comment']}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details[$i]['mortguageClause']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['surveyCommittee'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Survey committee clause</label></div></td>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['surveyCommittee']['isAgree']))
                                                                    @if($insures_details[$i]['surveyCommittee']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details[$i]['surveyCommittee']['isAgree']}}
                                                                                <br>Comments : {{$insures_details[$i]['surveyCommittee']['comment']}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details[$i]['surveyCommittee']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['protectExpense'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Expense to protect preserve or reduce the loss</label></div></td>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['protectExpense']['isAgree']))
                                                                    @if($insures_details[$i]['protectExpense']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details[$i]['protectExpense']['isAgree']}}
                                                                                <br>Comments : {{$insures_details[$i]['protectExpense']['comment']}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details[$i]['protectExpense']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['tenatsClause'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Tenants Clause</label></div></td>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['tenatsClause']['isAgree']))
                                                                    @if($insures_details[$i]['tenatsClause']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details[$i]['tenatsClause']['isAgree']}}
                                                                                <br>Comments : {{$insures_details[$i]['tenatsClause']['comment']}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details[$i]['tenatsClause']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['keysLockClause'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Keys and Lock replacement clause</label></div></td>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['keysLockClause']['isAgree']))
                                                                    @if($insures_details[$i]['keysLockClause']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details[$i]['keysLockClause']['isAgree']}}
                                                                                <br>Comments : {{$insures_details[$i]['keysLockClause']['comment']}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details[$i]['keysLockClause']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['exploratoryCost'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Exploratory Cost</label></div></td>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['exploratoryCost']['isAgree']))
                                                                    @if($insures_details[$i]['exploratoryCost']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details[$i]['exploratoryCost']['isAgree']}}
                                                                                <br>Comments : {{$insures_details[$i]['exploratoryCost']['comment']}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details[$i]['exploratoryCost']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['coverStatus'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Cover for bursting,overflowing, discharging,or leaking of water tanks apparatus or pipes when premises are empty or disused</label></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            <td>{{$insures_details[$i]['coverStatus']}}</td>
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['propertyDetails'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Property in the open or open sided sheds other than building structure and machineries which are designed to exist and to operate in the open</label></div></td>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['propertyDetails']['isAgree']))
                                                                    @if($insures_details[$i]['propertyDetails']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details[$i]['propertyDetails']['isAgree']}}
                                                                                <br>Comments : {{$insures_details[$i]['propertyDetails']['comment']}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details[$i]['propertyDetails']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['smokeSootDamage'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Smoke and soot damage extension</label></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            <td>{{$insures_details[$i]['smokeSootDamage']}}</td>
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['impactDamage'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Impact damage due to own vehicle and / or animals / third party vehicles</label></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            <td>{{$insures_details[$i]['impactDamage']}}</td>
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['curiousWorkArt'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Curious and work of art</label></div></td>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['curiousWorkArt']['isAgree']))
                                                                    @if($insures_details[$i]['curiousWorkArt']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details[$i]['curiousWorkArt']['isAgree']}}
                                                                                <br>Comments : {{$insures_details[$i]['curiousWorkArt']['comment']}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details[$i]['curiousWorkArt']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['sprinklerInoperativeClause'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Sprinkler inoperative clause</label></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            <td>{{$insures_details[$i]['sprinklerInoperativeClause']}}</td>
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['sprinklerUpgradation'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Sprinkler upgradation</label></div></td>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['sprinklerUpgradation']['isAgree']))
                                                                    @if($insures_details[$i]['sprinklerUpgradation']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details[$i]['sprinklerUpgradation']['isAgree']}}
                                                                                <br>Comments : {{$insures_details[$i]['sprinklerUpgradation']['comment']}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details[$i]['sprinklerUpgradation']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['fireProtection'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Fire protection system updating</label></div></td>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['fireProtection']['isAgree']))
                                                                    @if($insures_details[$i]['fireProtection']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details[$i]['fireProtection']['isAgree']}}
                                                                                <br>Comments : {{$insures_details[$i]['fireProtection']['comment']}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details[$i]['fireProtection']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['burglaryExtensionDiesel'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Burglary extension from diesel tank and similar storage facilities</label></div></td>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['burglaryExtensionDiesel']['isAgree']))
                                                                    @if($insures_details[$i]['burglaryExtensionDiesel']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details[$i]['burglaryExtensionDiesel']['isAgree']}}
                                                                                <br>Comments : {{$insures_details[$i]['burglaryExtensionDiesel']['comment']}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details[$i]['burglaryExtensionDiesel']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['machineryBreakdown'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Machinery breakdown extension</label></div></td>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['machineryBreakdown']['isAgree']))
                                                                    @if($insures_details[$i]['machineryBreakdown']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details[$i]['machineryBreakdown']['isAgree']}}
                                                                                <br>Comments : {{$insures_details[$i]['machineryBreakdown']['comment']}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details[$i]['machineryBreakdown']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['extraCover'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Cover of extra charges for overtime, nightwork, work on public holidays exprss freight, air freight</label></div></td>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['extraCover']['isAgree']))
                                                                    @if($insures_details[$i]['extraCover']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details[$i]['extraCover']['isAgree']}}
                                                                                <br>Comments : {{$insures_details[$i]['extraCover']['comment']}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details[$i]['extraCover']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['dissappearanceDetails'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Dishonesty, Dissappearance, Distraction</label></div></td>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['dissappearanceDetails']['isAgree']))
                                                                    @if($insures_details[$i]['dissappearanceDetails']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details[$i]['dissappearanceDetails']['isAgree']}}
                                                                                <br>Comments : {{$insures_details[$i]['dissappearanceDetails']['comment']}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details[$i]['dissappearanceDetails']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['elaborationCoverage'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Elaboration of coverage</label></div></td>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['elaborationCoverage']['isAgree']))
                                                                    @if($insures_details[$i]['elaborationCoverage']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details[$i]['elaborationCoverage']['isAgree']}}
                                                                                <br>Comments : {{$insures_details[$i]['elaborationCoverage']['comment']}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details[$i]['elaborationCoverage']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['permitClause'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Permit clause</label></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            <td>{{$insures_details[$i]['permitClause']}}</td>
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['repurchase'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Repurchase</label></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            <td>{{$insures_details[$i]['repurchase']}}</td>
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['bankruptcy'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Bankruptcy & insolvancy</label></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            <td>{{$insures_details[$i]['bankruptcy']}}</td>
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['aircraftDamage'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Aircraft damage</label></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            <td>{{$insures_details[$i]['aircraftDamage']}}</td>
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['appraisementClause'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Appraisement clause</label></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            <td>{{$insures_details[$i]['appraisementClause']}}</td>
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['assiatnceInsured'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Assiatnce and co-operation of the Insured</label></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            <td>{{$insures_details[$i]['assiatnceInsured']}}</td>
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['moneySafe'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Money in Safe</label></div></td>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['moneySafe']['isAgree']))
                                                                    @if($insures_details[$i]['moneySafe']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details[$i]['moneySafe']['isAgree']}}
                                                                                <br>Comments : {{$insures_details[$i]['moneySafe']['comment']}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details[$i]['moneySafe']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['moneyTransit'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Money in transit</label></div></td>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['moneyTransit']['isAgree']))
                                                                    @if($insures_details[$i]['moneyTransit']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details[$i]['moneyTransit']['isAgree']}}
                                                                                <br>Comments : {{$insures_details[$i]['moneyTransit']['comment']}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details[$i]['moneyTransit']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['computersAllRisk'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Computers all risk including damages to computers, additional expenses and media reconstruction cost</label></div></td>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['computersAllRisk']['isAgree']))
                                                                    @if($insures_details[$i]['computersAllRisk']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details[$i]['computersAllRisk']['isAgree']}}
                                                                                <br>Comments : {{$insures_details[$i]['computersAllRisk']['comment']}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details[$i]['computersAllRisk']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['coverForDeterioration'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Cover for deterioration due to change in temperature or humidity or failure / inadequate operation of an airconditioning cooling or heating system</label></div></td>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['coverForDeterioration']['isAgree']))
                                                                    @if($insures_details[$i]['coverForDeterioration']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details[$i]['coverForDeterioration']['isAgree']}}
                                                                                <br>Comments : {{$insures_details[$i]['coverForDeterioration']['comment']}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details[$i]['coverForDeterioration']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['hailDamage'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Hail Damage</label></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            <td>{{$insures_details[$i]['hailDamage']}}</td>
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['thunderboltLightening'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Thunderbolt and or lightening</label></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            <td>{{$insures_details[$i]['thunderboltLightening']}}</td>
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['waterRain'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Water / rain damage</label></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            <td>{{$insures_details[$i]['waterRain']}}</td>
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['specifiedLocations'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Specified locations cover</label></div></td>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['specifiedLocations']['isAgree']))
                                                                    @if($insures_details[$i]['specifiedLocations']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details[$i]['specifiedLocations']['isAgree']}}
                                                                                <br>Comments : {{$insures_details[$i]['specifiedLocations']['comment']}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details[$i]['specifiedLocations']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['portableItems'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Cover to include portable items worldwide</label></div></td>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['portableItems']['isAgree']))
                                                                    @if($insures_details[$i]['portableItems']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details[$i]['portableItems']['isAgree']}}
                                                                                <br>Comments : {{$insures_details[$i]['portableItems']['comment']}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details[$i]['portableItems']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['propertyAndAlteration'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">New property and alteration</label></div></td>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['propertyAndAlteration']['isAgree']))
                                                                    @if($insures_details[$i]['propertyAndAlteration']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details[$i]['propertyAndAlteration']['isAgree']}}
                                                                                <br>Comments : {{$insures_details[$i]['propertyAndAlteration']['comment']}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details[$i]['propertyAndAlteration']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['dismantleingExt'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Dismantleing and re-erection extension</label></div></td>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['dismantleingExt']['isAgree']))
                                                                    @if($insures_details[$i]['dismantleingExt']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details[$i]['dismantleingExt']['isAgree']}}
                                                                                <br>Comments : {{$insures_details[$i]['dismantleingExt']['comment']}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details[$i]['dismantleingExt']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['automaticPurchase'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Automatic cover for newly purchased items</label></div></td>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['automaticPurchase']['isAgree']))
                                                                    @if($insures_details[$i]['automaticPurchase']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details[$i]['automaticPurchase']['isAgree']}}
                                                                                <br>Comments : {{$insures_details[$i]['automaticPurchase']['comment']}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details[$i]['automaticPurchase']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['coverForTrees'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Cover for Trees, Shrubs, Plants, Lawns, Rockwork</label></div></td>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['coverForTrees']['isAgree']))
                                                                    @if($insures_details[$i]['coverForTrees']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details[$i]['coverForTrees']['isAgree']}}
                                                                                <br>Comments : {{$insures_details[$i]['coverForTrees']['comment']}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details[$i]['coverForTrees']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['informReward'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Reward for Information</label></div></td>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['informReward']['isAgree']))
                                                                    @if($insures_details[$i]['informReward']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details[$i]['informReward']['isAgree']}}
                                                                                <br>Comments : {{$insures_details[$i]['informReward']['comment']}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details[$i]['informReward']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['coverLandscape'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Cover to include Landscaping, Fountains, Drive ways, pavement roads, minor arches and other similar items within the insured property</label></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            <td>{{$insures_details[$i]['coverLandscape']}}</td>
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['damageWalls'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Damage to walls, gates fences, neon, signs, flag poles, landscaping and other properties intented to exist or operate in the open</label></td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            <td>{{$insures_details[$i]['damageWalls']}}</td>
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['occupancy']['type'] == "Building" && $pipeline_details['formData']['fitOutWorks'] == true)
                                                 <tr>
                                                    <td><div class="main_question"><label class="form_label bold">During fit out works, renovation works, or any alteration/repairs all losses above the limit of the PESP of CAR should be covered under the property</label></div></td>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['fitOutWorks']['isAgree']))
                                                                    @if($insures_details[$i]['fitOutWorks']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details[$i]['fitOutWorks']['isAgree']}}
                                                                                <br>Comments : {{$insures_details[$i]['fitOutWorks']['comment']}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details[$i]['fitOutWorks']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                </tr>
                                            @endif
                                        @endif 





                                        @if($pipeline_details['formData']['coverMechanical'] == true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Cover for  mechanical, electrical and electronic breakdown  for fixed non-mobile plant and machinery</label></td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        <td>{{$insures_details[$i]['coverMechanical']}}</td>
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif   
                                        @if($pipeline_details['formData']['coverExtWork'] == true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Cover for external works including sign boards,  landscaping  including trees in building/label</td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        <td>{{$insures_details[$i]['coverExtWork']}}</td>
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif   
                                        @if($pipeline_details['formData']['misdescriptionClause'] == true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Misdescription Clause</td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        <td>{{$insures_details[$i]['misdescriptionClause']}}</td>
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif   
                                        @if($pipeline_details['formData']['tempRemovalClause'] == true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Temporary removal clause</td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        <td>{{$insures_details[$i]['tempRemovalClause']}}</td>
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif   
                                        @if($pipeline_details['formData']['otherInsuranceClause'] == true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Other insurance allowed clause</td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        <td>{{$insures_details[$i]['otherInsuranceClause']}}</td>
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif   
                                        @if($pipeline_details['formData']['automaticAcqClause'] == true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Automatic acquisition clause</td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        <td>{{$insures_details[$i]['automaticAcqClause']}}</td>
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif   
                                        @if($pipeline_details['formData']['minorWorkExt'] == true)
                                             <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Minor works extension</label></div></td>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['minorWorkExt']['isAgree']))
                                                                    @if($insures_details[$i]['minorWorkExt']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details[$i]['minorWorkExt']['isAgree']}}
                                                                                <br>Comments : {{$insures_details[$i]['minorWorkExt']['comment']}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details[$i]['minorWorkExt']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                            </tr>
                                        @endif 
                                        @if($pipeline_details['formData']['saleInterestClause'] == true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Sale of Interest Clause</td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        <td>{{$insures_details[$i]['saleInterestClause']}}</td>
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif    
                                        @if($pipeline_details['formData']['sueLabourClause'] == true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Sue and labour clause</td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        <td>{{$insures_details[$i]['sueLabourClause']}}</td>
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif    
                                        @if($pipeline_details['formData']['electricalClause'] == true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Electrical clause waiver- Loss or damage by fire to electrical or electronic appliances , installations and wiring insured by this policy arising from or occasioned by over running, overheating excessive current, short circuiting, arcing, self-heating or leakage of electricity from whatever cause (lightning included) is covered</td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        <td>{{$insures_details[$i]['electricalClause']}}</td>
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif    
                                        @if($pipeline_details['formData']['contractPriceClause'] == true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Contract price clause</td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        <td>{{$insures_details[$i]['contractPriceClause']}}</td>
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif    
                                        @if($pipeline_details['formData']['sprinklerUpgradationClause'] == true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Sprinkler upgradation clause</td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        <td>{{$insures_details[$i]['sprinklerUpgradationClause']}}</td>
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif   
                                         @if($pipeline_details['formData']['accidentalFixClass'] == true)
                                             <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Accidental damage to fixed glass, glass (other than fixed glass)</label></div></td>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['accidentalFixClass']['isAgree']))
                                                                    @if($insures_details[$i]['accidentalFixClass']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details[$i]['accidentalFixClass']['isAgree']}}
                                                                                <br>Comments : {{$insures_details[$i]['accidentalFixClass']['comment']}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details[$i]['accidentalFixClass']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                            </tr>
                                        @endif 
                                         @if($pipeline_details['formData']['electronicInstallation'] == true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Electronic installation, computers, data processing, equipment and other fragile or brittle object</td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        <td>{{$insures_details[$i]['electronicInstallation']}}</td>
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif  
                                         @if($pipeline_details['formData']['brandTrademark'] == true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Brand and trademark</td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        <td>{{$insures_details[$i]['brandTrademark']}}</td>
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif  
                                         @if($pipeline_details['formData']['lossNotification'] == true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Loss Notification – ‘as soon as reasonably practicable’</td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        <td>{{$insures_details[$i]['lossNotification']}}</td>
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif  
                                         @if($pipeline_details['formData']['brockersClaimClause'] == true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Brokers Claim Handling Clause : A loss notification received by the Insurance Broker will be deemed as a loss notification to Insurer. All communications flowing between the Insurer, Insured and the appointed Loss Surveyor should be channelized through the Broker, unless there is any unavoidable reasons compelling direct communications between the parties</td>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        <td>{{$insures_details[$i]['brockersClaimClause']}}</td>
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endif
                                        @if (isset($pipeline_details['formData']['businessInterruption']) && $pipeline_details['formData']['businessInterruption']['business_interruption'] == true) 
                                            @if($pipeline_details['formData']['addCostWorking'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Additional increase in cost of working</td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            <td>{{$insures_details[$i]['addCostWorking']}}</td>
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['claimPreparationClause'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Claims preparation clause</label></div></td>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['claimPreparationClause']['isAgree']))
                                                                    @if($insures_details[$i]['claimPreparationClause']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details[$i]['claimPreparationClause']['isAgree']}}
                                                                                <br>Comments : {{$insures_details[$i]['claimPreparationClause']['comment']}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details[$i]['claimPreparationClause']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                </tr>
                                            @endif 
                                            @if($pipeline_details['formData']['suppliersExtension'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Suppliers extension/customer extension</label></div></td>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['suppliersExtension']['isAgree']))
                                                                    @if($insures_details[$i]['suppliersExtension']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details[$i]['suppliersExtension']['isAgree']}}
                                                                                <br>Comments : {{$insures_details[$i]['suppliersExtension']['comment']}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details[$i]['suppliersExtension']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                </tr>
                                            @endif 
                                            @if($pipeline_details['formData']['accountantsClause'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Accountants clause</label></div></td>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['accountantsClause']['isAgree']))
                                                                    @if($insures_details[$i]['accountantsClause']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details[$i]['accountantsClause']['isAgree']}}
                                                                                <br>Comments : {{$insures_details[$i]['accountantsClause']['comment']}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details[$i]['accountantsClause']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                </tr>
                                            @endif 
                                            @if($pipeline_details['formData']['accountPayment'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Payment on account</label></div></td>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['accountPayment']['isAgree']))
                                                                    @if($insures_details[$i]['accountPayment']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details[$i]['accountPayment']['isAgree']}}
                                                                                <br>Comments : {{$insures_details[$i]['accountPayment']['comment']}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details[$i]['accountPayment']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                </tr>
                                            @endif 
                                            @if($pipeline_details['formData']['preventionDenialClause'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Prevention/denial of access</label></div></td>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['preventionDenialClause']['isAgree']))
                                                                    @if($insures_details[$i]['preventionDenialClause']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details[$i]['preventionDenialClause']['isAgree']}}
                                                                                <br>Comments : {{$insures_details[$i]['preventionDenialClause']['comment']}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details[$i]['preventionDenialClause']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                </tr>
                                            @endif 
                                            @if($pipeline_details['formData']['premiumAdjClause'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Premium adjustment clause</label></div></td>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['premiumAdjClause']['isAgree']))
                                                                    @if($insures_details[$i]['premiumAdjClause']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details[$i]['premiumAdjClause']['isAgree']}}
                                                                                <br>Comments : {{$insures_details[$i]['premiumAdjClause']['comment']}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details[$i]['premiumAdjClause']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                </tr>
                                            @endif 
                                            @if($pipeline_details['formData']['publicUtilityClause'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Public utilities clause</label></div></td>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['publicUtilityClause']['isAgree']))
                                                                    @if($insures_details[$i]['publicUtilityClause']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details[$i]['publicUtilityClause']['isAgree']}}
                                                                                <br>Comments : {{$insures_details[$i]['publicUtilityClause']['comment']}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details[$i]['publicUtilityClause']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                </tr>
                                            @endif 
                                            @if($pipeline_details['formData']['brockersClaimHandlingClause'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Brokers Claim Handling Clause : A loss notification received by the Insurance Broker will be deemed as a loss notification to Insurer. All communications flowing between the Insurer, Insured and the appointed Loss Surveyor should be channelized through the Broker, unless there is any unavoidable reasons compelling direct communications between the parties</td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            <td>{{$insures_details[$i]['brockersClaimHandlingClause']}}</td>
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                             @if($pipeline_details['formData']['accountsRecievable'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Accounts recievable / Loss of booked debts/label</div></td>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['accountsRecievable']['isAgree']))
                                                                    @if($insures_details[$i]['accountsRecievable']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details[$i]['accountsRecievable']['isAgree']}}
                                                                                <br>Comments : {{$insures_details[$i]['accountsRecievable']['comment']}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details[$i]['accountsRecievable']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                </tr>
                                            @endif 
                                            @if($pipeline_details['formData']['interDependency'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Interdependany clause</td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            <td>{{$insures_details[$i]['interDependency']}}</td>
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['extraExpense'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Extra expense</div></td>
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
                                            @if($pipeline_details['formData']['contaminatedWater'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Contaminated water</td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['contaminatedWater'],$selectedId))
                                                            <td>{{$insures_details[$i]['contaminatedWater']}}</td>
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['auditorsFeeCheck'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Auditors fees</div></td>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['auditorsFeeCheck']['isAgree']))
                                                                    @if($insures_details[$i]['auditorsFeeCheck']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details[$i]['auditorsFeeCheck']['isAgree']}}
                                                                                <br>Comments : {{$insures_details[$i]['auditorsFeeCheck']['comment']}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details[$i]['auditorsFeeCheck']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['expenseReduceLoss'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Expense to reduce the loss</div></td>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['expenseReduceLoss']['isAgree']))
                                                                    @if($insures_details[$i]['expenseReduceLoss']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details[$i]['expenseReduceLoss']['isAgree']}}
                                                                                <br>Comments : {{$insures_details[$i]['expenseReduceLoss']['comment']}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details[$i]['expenseReduceLoss']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['nominatedLossAdjuster'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Nominated loss adjuster</div></td>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['nominatedLossAdjuster']['isAgree']))
                                                                    @if($insures_details[$i]['nominatedLossAdjuster']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details[$i]['nominatedLossAdjuster']['isAgree']}}
                                                                                <br>Comments : {{$insures_details[$i]['nominatedLossAdjuster']['comment']}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details[$i]['nominatedLossAdjuster']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['outbreakDiscease'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Outbreak of discease</div></td>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['outbreakDiscease']['isAgree']))
                                                                    @if($insures_details[$i]['outbreakDiscease']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details[$i]['outbreakDiscease']['isAgree']}}
                                                                                <br>Comments : {{$insures_details[$i]['outbreakDiscease']['comment']}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details[$i]['outbreakDiscease']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['nonPublicFailure'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Failure of non public power supply</div></td>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['nonPublicFailure']['isAgree']))
                                                                    @if($insures_details[$i]['nonPublicFailure']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details[$i]['nonPublicFailure']['isAgree']}}
                                                                                <br>Comments : {{$insures_details[$i]['nonPublicFailure']['comment']}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details[$i]['nonPublicFailure']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['premisesDetails'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Murder, Suicide or outbreak of discease on the premises</div></td>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['premisesDetails']['isAgree']))
                                                                    @if($insures_details[$i]['premisesDetails']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details[$i]['premisesDetails']['isAgree']}}
                                                                                <br>Comments : {{$insures_details[$i]['premisesDetails']['comment']}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details[$i]['premisesDetails']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['bombscare'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Bombscare and unexploded devices on the premises</div></td>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['bombscare']['isAgree']))
                                                                    @if($insures_details[$i]['bombscare']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details[$i]['bombscare']['isAgree']}}
                                                                                <br>Comments : {{$insures_details[$i]['bombscare']['comment']}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details[$i]['bombscare']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['bookDebits'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Book of Debts</div></td>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['bombscare']['isAgree']))
                                                                    @if($insures_details[$i]['bookDebits']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details[$i]['bookDebits']['isAgree']}}
                                                                                <br>Comments : {{$insures_details[$i]['bookDebits']['comment']}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details[$i]['bookDebits']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['publicFailure'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Failure of public utility</div></td>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['publicFailure']['isAgree']))
                                                                    @if($insures_details[$i]['publicFailure']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details[$i]['publicFailure']['isAgree']}}
                                                                                <br>Comments : {{$insures_details[$i]['publicFailure']['comment']}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details[$i]['publicFailure']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                </tr>
                                            @endif
                                            @if (isset($pipeline_details['formData']['businessInterruption']['noLocations']) &&
                                               $pipeline_details['formData']['businessInterruption']['noLocations'] > 1) 
                                               @if($pipeline_details['formData']['departmentalClause'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Departmental clause</td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            <td>{{$insures_details[$i]['departmentalClause']}}</td>
                                                        @endif
                                                    @endfor
                                                </tr>
                                                @endif
                                                 @if($pipeline_details['formData']['rentLease'] == true)
                                                 <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Rent & Lease hold interest</div></td>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['rentLease']['isAgree']))
                                                                    @if($insures_details[$i]['rentLease']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details[$i]['rentLease']['isAgree']}}
                                                                                <br>Comments : {{$insures_details[$i]['rentLease']['comment']}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details[$i]['rentLease']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                </tr>
                                                @endif
                                            @endif
                                            @if(isset($pipeline_details['formData']['CoverAccomodation']) && $pipeline_details['formData']['CoverAccomodation']['coverAccomodation'] == true)
                                                 <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Cover for alternate accomodation</div></td>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['coverAccomodation']['isAgree']))
                                                                    @if($insures_details[$i]['coverAccomodation']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details[$i]['coverAccomodation']['isAgree']}}
                                                                                <br>Comments : {{$insures_details[$i]['coverAccomodation']['comment']}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details[$i]['coverAccomodation']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                </tr>
                                                @endif
                                            @if($pipeline_details['formData']['contingentBusiness'] == true)
                                                 <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Contingent business inetruption and contingent extra expense</div></td>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['contingentBusiness']['isAgree']))
                                                                    @if($insures_details[$i]['contingentBusiness']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details[$i]['contingentBusiness']['isAgree']}}
                                                                                <br>Comments : {{$insures_details[$i]['contingentBusiness']['comment']}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details[$i]['contingentBusiness']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                </tr>
                                                @endif
                                            @if($pipeline_details['formData']['nonOwnedProperties'] == true)
                                                 <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Non Owned property in vicinity interuption</div></td>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['nonOwnedProperties']['isAgree']))
                                                                    @if($insures_details[$i]['nonOwnedProperties']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details[$i]['nonOwnedProperties']['isAgree']}}
                                                                                <br>Comments : {{$insures_details[$i]['nonOwnedProperties']['comment']}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details[$i]['nonOwnedProperties']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                </tr>
                                                @endif
                                                 @if($pipeline_details['formData']['royalties'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Royalties</td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            <td>{{$insures_details[$i]['royalties']}}</td>
                                                        @endif
                                                    @endfor
                                                </tr>
                                                @endif
                                        @endif  
                                        @if (isset($pipeline_details['formData']['cliamPremium']) &&
                                            $pipeline_details['formData']['cliamPremium'] == 'combined_data')

                                            @if($pipeline_details['formData']['claimPremiyumDetails']['deductableProperty'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Deductible for Property</td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            <td>{{number_format(trim($insures_details[$i]['claimPremiyumDetails']['deductableProperty']),2)}}</td>
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['claimPremiyumDetails']['deductableBusiness'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Deductible for Business Interruption</td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            <td>{{number_format(trim($insures_details[$i]['claimPremiyumDetails']['deductableBusiness']),2)}}</td>
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['claimPremiyumDetails']['rateCombined'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Rate (combined)</td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            <td>{{number_format(trim($insures_details[$i]['claimPremiyumDetails']['rateCombined']),2)}}</td>
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['claimPremiyumDetails']['premiumCombined'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Premium (combined)</td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            <td>{{number_format(trim($insures_details[$i]['claimPremiyumDetails']['premiumCombined']),2)}}</td>
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['claimPremiyumDetails']['brokerage'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Brokerage (combined)</td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            <td>{{number_format(trim($insures_details[$i]['claimPremiyumDetails']['brokerage']),2)}}</td>
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['claimPremiyumDetails']['warrantyProperty'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Warranty (Property)</td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            <td>{{$insures_details[$i]['claimPremiyumDetails']['warrantyProperty']}}</td>
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['claimPremiyumDetails']['warrantyBusiness'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Warranty (Business Interruption)</td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            <td>{{$insures_details[$i]['claimPremiyumDetails']['warrantyBusiness']}}</td>
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['claimPremiyumDetails']['exclusionProperty'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Exclusion (Property)</td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            <td>{{$insures_details[$i]['claimPremiyumDetails']['exclusionProperty']}}</td>
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['claimPremiyumDetails']['exclusionBusiness'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Exclusion (Business Interruption)</td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            <td>{{$insures_details[$i]['claimPremiyumDetails']['exclusionBusiness']}}</td>
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['claimPremiyumDetails']['specialProperty'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Special Condition (Property)</td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            <td>{{$insures_details[$i]['claimPremiyumDetails']['specialProperty']}}</td>
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['claimPremiyumDetails']['specialBusiness'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Special Condition (Business Interruption)</td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            <td>{{$insures_details[$i]['claimPremiyumDetails']['specialBusiness']}}</td>
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                        @endif    


                                        @if (isset($pipeline_details['formData']['cliamPremium']) &&
                                            $pipeline_details['formData']['cliamPremium'] == 'only_property')

                                            @if($pipeline_details['formData']['claimPremiyumDetails']['deductableProperty'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Deductible</td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            <td>{{number_format(trim($insures_details[$i]['claimPremiyumDetails']['deductableProperty']),2)}}</td>
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                            
                                            @if($pipeline_details['formData']['claimPremiyumDetails']['propertyRate'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Rate</td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            <td>{{number_format(trim($insures_details[$i]['claimPremiyumDetails']['propertyRate']),2)}}</td>
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['claimPremiyumDetails']['propertyPremium'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Premium</td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            <td>{{number_format(trim($insures_details[$i]['claimPremiyumDetails']['propertyPremium']),2)}}</td>
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['claimPremiyumDetails']['propertyBrockerage'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Brokerage</td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            <td>{{number_format(trim($insures_details[$i]['claimPremiyumDetails']['propertyBrockerage']),2)}}</td>
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['claimPremiyumDetails']['propertyWarranty'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Warranty </td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            <td>{{$insures_details[$i]['claimPremiyumDetails']['propertyWarranty']}}</td>
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['claimPremiyumDetails']['propertyExclusion'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Exclusion</td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            <td>{{$insures_details[$i]['claimPremiyumDetails']['propertyExclusion']}}</td>
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['claimPremiyumDetails']['propertySpecial'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Special Condition</td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            <td>{{$insures_details[$i]['claimPremiyumDetails']['propertySpecial']}}</td>
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                        @endif  



                                         @if (isset($pipeline_details['formData']['cliamPremium']) &&
                                            $pipeline_details['formData']['cliamPremium'] == 'separate_property')

                                            @if($pipeline_details['formData']['claimPremiyumDetails']['propertySeparateDeductable'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Deductible for (Property)</td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            <td>{{number_format(trim($insures_details[$i]['claimPremiyumDetails']['propertySeparateDeductable']),2)}}</td>
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                           
                                            @if($pipeline_details['formData']['claimPremiyumDetails']['propertySeparateRate'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Rate (Property)</td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            <td>{{number_format(trim($insures_details[$i]['claimPremiyumDetails']['propertySeparateRate']),2)}}</td>
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['claimPremiyumDetails']['propertySeparatePremium'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Premium (Property)</td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            <td>{{number_format(trim($insures_details[$i]['claimPremiyumDetails']['propertySeparatePremium']),2)}}</td>
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['claimPremiyumDetails']['propertySeparateBrokerage'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Brokerage (Property)</td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            <td>{{number_format(trim($insures_details[$i]['claimPremiyumDetails']['propertySeparateBrokerage']),2)}}</td>
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['claimPremiyumDetails']['propertySeparateWarranty'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Warranty (Property)</td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            <td>{{$insures_details[$i]['claimPremiyumDetails']['propertySeparateWarranty']}}</td>
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                            
                                            @if($pipeline_details['formData']['claimPremiyumDetails']['propertySeparateExclusion'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Exclusion (Property)</td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            <td>{{$insures_details[$i]['claimPremiyumDetails']['propertySeparateExclusion']}}</td>
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                           
                                            @if($pipeline_details['formData']['claimPremiyumDetails']['propertySeparateSpecial'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Special Condition (Property)</td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            <td>{{$insures_details[$i]['claimPremiyumDetails']['propertySeparateSpecial']}}</td>
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif



                                            @if($pipeline_details['formData']['claimPremiyumDetails']['businessSeparateDeductable'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Deductible for (Business Interruption)</td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            <td>{{number_format(trim($insures_details[$i]['claimPremiyumDetails']['businessSeparateDeductable']),2)}}</td>
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                           
                                            @if($pipeline_details['formData']['claimPremiyumDetails']['businessSeparateRate'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Rate (Business Interruption)</td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            <td>{{number_format(trim($insures_details[$i]['claimPremiyumDetails']['businessSeparateRate']),2)}}</td>
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['claimPremiyumDetails']['businessSeparatePremium'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Premium (Business Interruption)</td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            <td>{{number_format(trim($insures_details[$i]['claimPremiyumDetails']['businessSeparatePremium']),2)}}</td>
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['claimPremiyumDetails']['businessSeparateBrokerage'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Brokerage (Business Interruption)</td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            <td>{{number_format(trim($insures_details[$i]['claimPremiyumDetails']['businessSeparateBrokerage']),2)}}</td>
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['claimPremiyumDetails']['businessSeparateWarranty'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Warranty (Business Interruption)</td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            <td>{{$insures_details[$i]['claimPremiyumDetails']['businessSeparateWarranty']}}</td>
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                            
                                            @if($pipeline_details['formData']['claimPremiyumDetails']['businessSeparateExclusion'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Exclusion (Business Interruption)</td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            <td>{{$insures_details[$i]['claimPremiyumDetails']['businessSeparateExclusion']}}</td>
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                           
                                            @if($pipeline_details['formData']['claimPremiyumDetails']['businessSeparateSpecial'])
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Special Condition (Business Interruption)</td>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            <td>{{$insures_details[$i]['claimPremiyumDetails']['businessSeparateSpecial']}}</td>
                                                        @endif
                                                    @endfor
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

<div class="page_break" style="display: block"></div>

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