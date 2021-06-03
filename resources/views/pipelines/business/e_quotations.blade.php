
@extends('layouts.app')

@section('sidebar')
    @parent
@endsection

@section('content')
    <style>
        .cd-breadcrumb.triangle li.active_arrow > * {
            /* selected step */
            color: #ffffff;
            background-color: #FFA500;
            border-color: #FFA500;
        }
    </style>
    <div class="section_details">
        <div class="card_header clearfix">
            <h3 class="title" style="margin-bottom: 8px;">business interruption</h3>
        </div>
        @if (session('msg'))
            <div class="alert alert-success alert-dismissible" role="alert" id="success_excel">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                {{ session('msg') }}
            </div>
        @endif
        <div class="card_content">
            <div class="edit_sec clearfix">
                <!-- Steps -->
                <section>
                    <nav>
                        <ol class="cd-breadcrumb triangle">
                            <li class="complete"><a href="{{url('business_interruption/e-questionnaire/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Questionnaire</em></a></li>
                            <li class="complete"><a href="{{url('business_interruption/e-slip/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>
                            @if($pipeline_details['status']['status'] == 'E-quotation')
                                <li class="current"><a href="{{url('business_interruption/e-quotation/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                                <li><em>E-Comparison</em></li>
                                <li><em>Quote Amendment</em></li>
                                <li><em>Approved E Quote</em></li>
                                {{--<li><em>Issuance</em></li>--}}
                            @elseif($pipeline_details['status']['status'] == 'E-comparison')
                                <li class="active_arrow"><a href="{{url('business_interruption/e-quotation/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                                <li class="current"><a href="{{url('business_interruption/e-comparison/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                                <li><em>Quote Amendment</em></li>
                                <li><em>Approved E Quote</em></li>
                                {{--<li><em>Issuance</em></li>--}}
                            @elseif($pipeline_details['status']['status'] == 'Quote Amendment')
                                <li class="active_arrow"><a href="{{url('business_interruption/e-quotation/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                                <li class="complete"><a href="{{url('business_interruption/e-comparison/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                                <li class="current"><a href="{{url('business_interruption/quot-amendment/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>
                                <li><em>Approved E Quote</em></li>
                                {{--<li><em>Issuance</em></li>--}}
                            @elseif($pipeline_details['status']['status'] == 'Approved E Quote')
                                <li class="active_arrow"><a href="{{url('business_interruption/e-quotation/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                                <li class="complete"><a href="{{url('business_interruption/e-comparison/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                                <li class="complete"><a href="{{url('business_interruption/quot-amendment/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>
                                <li class="current"><a href="{{url('business_interruption/approved-quot/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Approved E Quote</em></a></li>
                                {{--<li><em>Issuance</em></li>--}}
                            @elseif($pipeline_details['status']['status'] == 'Quote Amendment-E-comparison' || $pipeline_details['status']['status'] == 'Quote Amendment-E-quotation' || $pipeline_details['status']['status'] == 'Quote Amendment-E-slip')
                                <li class="active_arrow"><a href="{{url('business_interruption/e-quotation/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                                <li class="complete"><a href="{{url('business_interruption/e-comparison/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                                <li class="current"><a href="{{url('business_interruption/quot-amendment/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>
                                <li><em>Approved E Quote</em></li>
                                {{--@elseif($pipeline_details['status']['status'] == 'Issuance')--}}
                                {{--<li class="complete"><a href="{{url('e-quotation/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>--}}
                                {{--<li class="complete"><a href="{{url('e-comparison/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>--}}
                                {{--<li class="complete"><a href="{{url('quot-amendment/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>--}}
                                {{--<li class="complete"><a href="{{url('approved-quot/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Approved E Quote</em></a></li>--}}
                                {{--<li class="current"><a href="{{url('issuance/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Issuance</em></a></li>--}}
                            @else
                                <li class="current"><a href="{{url('business_interruption/e-quotation/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                                <li><em>E-Comparison</em></li>
                                <li><em>Quote Amendment</em></li>
                                <li><em>Approved E Quote</em></li>
                                <li><em>Issuance</em></li>
                            @endif
                        </ol>
                    </nav>
                </section>
                
                @if(isset($pipeline_details['selected_insurers']))
                    <input type="hidden" id="selected_insurers" value="{{json_encode($id_insurer)}}">
                @else
                    <input type="hidden" id="selected_insurers" value="empty">
                @endif
                <form id="e_quat_form" name="e_quat_form" method="post" >
                    <input type="hidden" value="{{$pipeline_details->_id}}" id="pipeline_id" name="pipeline_id">
                    {{csrf_field()}}
                    <div class="data_table compare_sec">
                        <div id="admin">

                            <div class="material-table">
                                <div class="table-header">
                                    <span class="table-title">E-Quotation</span>
                                </div>
                                <div class="table_fixed height_fix">
                                    <div class="table_sep_fix">
                                        <div class="material-table table-responsive" style="border-bottom: none;overflow: hidden">
                                            <table class="table table-bordered"  style="border-bottom: none">
                                                <thead>
                                                <tr>
                                                    <th><div class="main_question">Questions</div></th>
                                                    <th><div class="main_answer" style="background-color: transparent">Customer Response</div></th>
                                                </tr>
                                                </thead>
                                                <tbody style="border-bottom: none" class="syncscroll"  name="myElements">
												<?php $insure_count=count(@$insures_details);?>
												<?php $sel_insure_count=count(@$insures_name);?> <!--Insurance Company List Active-->
												<?php $total_insure_count=$insure_count+$sel_insure_count;?> <!--Insurance Company List Active-->
                                               
                                                @if(isset($pipeline_details['formData']['costWork']) && $pipeline_details['formData']['costWork'] == true)
                                                    <tr>   
                                                        <td><div class="main_question"><label class="form_label bold">Additional increase in cost of working</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif
                                                @if(isset($pipeline_details['formData']['claimClause']) && $pipeline_details['formData']['claimClause'] == true)

                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Claims preparation clause</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif
                                                @if(isset($pipeline_details['formData']['custExtension']) && $pipeline_details['formData']['custExtension'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Suppliers extension/customer extension</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>

                                                    </tr>
                                                @endif
                                                @if(isset($pipeline_details['formData']['accountants']) && $pipeline_details['formData']['accountants'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Accountants clause</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif
                                                @if(isset($pipeline_details['formData']['payAccount']) && $pipeline_details['formData']['payAccount']==true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Payment on account</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif
                                                @if(isset($pipeline_details['formData']['denialAccess']) && $pipeline_details['formData']['denialAccess'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Prevention/denial of access</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif
                                                @if(isset($pipeline_details['formData']['premiumClause']) && $pipeline_details['formData']['premiumClause'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Premium adjustment clause</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif
                                                @if(isset($pipeline_details['formData']['utilityClause']) && $pipeline_details['formData']['utilityClause'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Public utilities clause</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif
                                                @if(isset($pipeline_details['formData']['brokerClaim']) && $pipeline_details['formData']['brokerClaim'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Brokers Claim Handling Clause : A loss notification received by the Insurance Broker will be deemed as a loss notification to Insurer. All communications flowing between the Insurer, Insured and the appointed Loss Surveyor should be channelized through the Broker, unless there is any unavoidable reasons compelling direct communications between the parties</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif
                                                @if(isset($pipeline_details['formData']['bookedDebts']) && $pipeline_details['formData']['bookedDebts'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Accounts recievable / Loss of booked debts</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif
                                                @if(isset($pipeline_details['formData']['interdependanyClause']) && $pipeline_details['formData']['interdependanyClause'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Interdependany clause</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif
                                                @if(isset($pipeline_details['formData']['extraExpense']) && $pipeline_details['formData']['extraExpense'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Extra expense</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif
                                                @if(isset($pipeline_details['formData']['water']) && $pipeline_details['formData']['water'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Contaminated water</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif
                                                @if(isset($pipeline_details['formData']['auditorFee']) && $pipeline_details['formData']['auditorFee'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Auditors fees</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif
                                                @if(isset($pipeline_details['formData']['expenseLaws']) && $pipeline_details['formData']['expenseLaws'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">expense to reduce the laws</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif
                                                @if(isset($pipeline_details['formData']['lossAdjuster']) && $pipeline_details['formData']['lossAdjuster'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Nominated loss adjuster</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif
                                                @if(isset($pipeline_details['formData']['discease']) && $pipeline_details['formData']['discease'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Outbreak of discease</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif
                                                @if(isset($pipeline_details['formData']['powerSupply']) && $pipeline_details['formData']['powerSupply'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Failure of non public power supply</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif
                                                @if(isset($pipeline_details['formData']['condition1']) && $pipeline_details['formData']['condition1']!='' && $pipeline_details['formData']['condition1'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Murder, Suicide or outbreak of discease on the premises</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif
                                                @if(isset($pipeline_details['formData']['condition2']) && $pipeline_details['formData']['condition2'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Bombscare and unexploded devices on the premise</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif
                                                @if(isset($pipeline_details['formData']['bookofDebts']) && $pipeline_details['formData']['bookofDebts'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Book of Debts</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['risk']>1 && isset($pipeline_details['formData']['depclause']) && $pipeline_details['formData']['depclause'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Departmental clause</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif
                                                @if(isset($pipeline_details['formData']['rent']) && $pipeline_details['formData']['rent'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Rent & Lease hold interest</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif
                                                @if(isset($pipeline_details['formData']['hasaccomodation']) && $pipeline_details['formData']['hasaccomodation'] == "yes")
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Cover for alternate accomodation</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif
                                                @if(isset($pipeline_details['formData']['costofConstruction']) && $pipeline_details['formData']['costofConstruction'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Demolition and increased cost of construction</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif
                                                @if(isset($pipeline_details['formData']['ContingentExpense']) && $pipeline_details['formData']['ContingentExpense'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Contingent business inetruption and contingent extra expense</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif
                                                @if(isset($pipeline_details['formData']['interuption']) && $pipeline_details['formData']['interuption'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Non Owned property in vicinity interuption</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif
                                                @if(isset($pipeline_details['formData']['Royalties']) && $pipeline_details['formData']['Royalties'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Royalties</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif
                                                @if(isset($pipeline_details['formData']['deductible']) && $pipeline_details['formData']['deductible']!= '')
                                                    <tr>   
                                                        <td><div class="main_question"><label class="form_label bold">Deductible</label></div></td>
                                                        <td class="main_answer"><div class="ans">{{number_format($pipeline_details['formData']['deductible'],2)}}</div></td>
                                                    </tr>
                                                @endif
                                                @if(isset($pipeline_details['formData']['ratep']) && $pipeline_details['formData']['ratep']!= '')
                                                    <tr>   
                                                        <td><div class="main_question"><label class="form_label bold">Rate/premium required</label></div></td>
                                                        <td class="main_answer"><div class="ans">{{number_format($pipeline_details['formData']['ratep'],2)}}</div></td>
                                                    </tr>
                                                @endif
                                                @if(isset($pipeline_details['formData']['spec_condition']) && $pipeline_details['formData']['spec_condition']!= '')
                                                    <tr>   
                                                        <td><div class="main_question"><label class="form_label bold">Special Condition</div></td>
                                                        <td class="main_answer"><div class="ans">{{number_format($pipeline_details['formData']['spec_condition'],2)}}</div></td>
                                                        </tr>
                                                           
                                                @endif
                                                @if(isset($pipeline_details['formData']['warranty']) && $pipeline_details['formData']['warranty']!= '')
                                                    <tr>   
                                                        <td><div class="main_question"><label class="form_label bold">Warranty</label></div></td>
                                                        <td class="main_answer"><div class="ans">{{number_format($pipeline_details['formData']['warranty'],2)}}</div></td>
                                                    </tr>
                                                @endif
                                                @if(isset($pipeline_details['formData']['brokerage']) && $pipeline_details['formData']['brokerage']!= '')
                                                    <tr>   
                                                        <td><div class="main_question"><label class="form_label bold">Brokerage</label></div></td>
                                                        <td class="main_answer"><div class="ans">{{number_format($pipeline_details['formData']['brokerage'],2)}}</div></td>
                                                    </tr>
                                                @endif
                                                @if(isset($pipeline_details['formData']['exclusion']) && $pipeline_details['formData']['exclusion']!= '')
                                                    <tr>   
                                                        <td><div class="main_question"><label class="form_label bold">Exclusion</label></div></td>
                                                    <td class="main_answer"><div class="ans">{{number_format($pipeline_details['formData']['exclusion'],2)}}</div></td>
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['status']['status'] == 'E-slip' || $pipeline_details['status']['status']=='E-quotation' || $pipeline_details['status']['status']=='E-comparison' || $pipeline_details['status']['status']=='Quote Amendment'|| $pipeline_details['status']['status']=='Quote Amendment-E-quotation')
                                                    <tr style="border-bottom: none">
                                                        <?php $insure_count=count(@$insures_details);?>
                                                        @if($insure_count==0)
                                                            @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                <td style="border-bottom: none;border-right: none"></td>
                                                            @endfor
                                                        @else
                                                            @for ($i = 0; $i < $total_insure_count; $i++)
                                                                @if(array_key_exists($i,$insures_details))
                                                                    <td style="border-bottom: none;border-right: none"></td>
                                                                @else
                                                                    <?php $i_cont=$i-$insure_count; ?>
                                                                    <td style="border-bottom: none;border-right: none"></td>
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="table_sep_pen">
                                        <div class="material-table table-responsive">
                                            <table class="table comparison table-bordered" style="table-layout: auto">
                                                <thead>
                                                    <tr>
                                                      <?php $insure_count=count(@$insures_details);?><!--Replied insures count -->
                                                        @if($insure_count==0)
                                                            @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                <th><div class="ans"> {{$insures_name[$i]}}</div></th>
                                                            @endfor
                                                        @else
                                                            @for ($i = 0; $i < $total_insure_count; $i++)
                                                                @if(array_key_exists($i,$insures_details))
                                                                    <th>
                                                                        @if(isset($insures_details[$i]['insurerDetails']['insurerName']))
                                                                            <div class="ans">
                                                                                <div class="custom_checkbox">
                                                                                    <input type="checkbox" value="hide" name="insure_check[]" id="insure_check_{{$insures_details[$i]['uniqueToken']}}" class="inp-cbx" style="display: none" onclick="color_change_table(this.id);">
                                                                                    <label for="insure_check_{{$insures_details[$i]['uniqueToken']}}" class="cbx">
                                                                                        <span>
                                                                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                                                        </svg>
                                                                                        </span>
                                                                                        <?php $length=strlen($insures_details[$i]['insurerDetails']['insurerName']);
                                                                                        if($length>32)
                                                                                        {
                                                                                            $dot="...";
                                                                                        }
                                                                                        else{
                                                                                            $dot=null;
                                                                                        }

                                                                                        ?>
                                                                                        @if($dot!=null)
                                                                                            <span data-toggle="tooltip" data-placement="right" title="{{$insures_details[$i]['insurerDetails']['insurerName']}}" data-container="body">{{substr(ucfirst($insures_details[$i]['insurerDetails']['insurerName']), 0, 32).$dot}}</span>
                                                                                        @else
                                                                                            <span>{{$insures_details[$i]['insurerDetails']['insurerName']}}</span>
                                                                                        @endif
                                                                                        <?php if(isset($insures_details[$i]['repliedMethod']))
                                                                                        {
                                                                                        if($insures_details[$i]['repliedMethod']=='excel')
                                                                                        {
                                                                                        $method=$insures_details[$i]['repliedMethod'];
                                                                                        ?>
                                                                                        <div class="pointer" data-toggle="tooltip" data-placement="right" data-container="body" data-original-title="{{$method}}">
                                                                                            <i style="color: #9c27b0;" class="fa fa-file-excel-o"></i>
                                                                                        </div>
                                                                                        <?php
                                                                                        }
                                                                                        else{
                                                                                        $method=$insures_details[$i]['repliedMethod'];
                                                                                        ?>

                                                                                        <div class="pointer" data-toggle="tooltip" data-placement="right" data-container="body" data-original-title="{{$method}}">
                                                                                            <i style="color: #9c27b0;" class="fa fa-user"></i>
                                                                                        </div>
                                                                                        <?php
                                                                                        }
                                                                                        }
                                                                                        else{
                                                                                            $method='';
                                                                                        }
                                                                                        ?>

                                                                                    </label>


                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                    </th>
                                                                @else
                                                                    <?php $i_cont=$i-$insure_count; ?>
                                                                    <?php $lengthval=strlen($insures_name[$i_cont]);
                                                                    if($lengthval>32)
                                                                    {
                                                                        $dot_value="...";
                                                                    }
                                                                    else{
                                                                        $dot_value=null;
                                                                    }

                                                                    ?>
                                                                    <th>
                                                                        @if($dot_value!=null)
                                                                            <div class="ans" data-toggle="tooltip" data-placement="right" title="{{$insures_name[$i_cont]}}">{{substr(ucfirst($insures_name[$i_cont]), 0, 32).$dot_value}}</div>
                                                                        @else
                                                                            <div class="ans">{{substr(ucfirst($insures_name[$i_cont]), 0, 32)}}</div>
                                                                        @endif
                                                                    </th>
                                                                @endif
                                                            @endfor
                                                        @endif

                                                    </tr>
                                                </thead>
                                                <tbody  class="syncscroll" name="myElements">
                                                    @if(isset($pipeline_details['formData']['costWork']) && $pipeline_details['formData']['costWork']== true)     
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
                                                                        <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                            <div class="ans">
                                                                                <span id='div_costWork_{{$insures_details[$i]['uniqueToken']}}'
                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
                                                                                    <input id='costWork_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['costWork']?:'--'}}' required>
                                                                                    <label class='error' id='costWork_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='costWork' onclick='fun(this)'>Update</button>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='costWork' onclick='cancel(this)'>
                                                                                    <i class='material-icons'>close</i></button>"
                                                                                    data-container="body">{{$insures_details[$i]['costWork']?:'--'}}
                                                                                </span>
                                                                            </div>
                                                                        </td>
                                                                    @else
                                                                        <td>  <div class="ans">--</div></td>
                                                                    @endif
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
                                                    @if(isset($pipeline_details['formData']['claimClause']) && $pipeline_details['formData']['claimClause'] == true)
                                                        <tr>
                                                            <?php $insure_count=count(@$insures_details);?>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
                                                                        @if(isset($insures_details[$i]['claimClause']['isAgree']))
                                                                                @if(@$insures_details[$i]['claimClause']['comment']!="")
                                                                                    <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                        <div class="ans">
                                                                                            <span id="div_claimClause_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                data-content="<input id='claimClause_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['claimClause']['isAgree']}}'>
                                                                                                <label class='error' id='claimClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='claimClause' onclick='fun(this)'>Update</button>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='claimClause' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                data-container="body">{{@$insures_details[$i]['claimClause']['isAgree']}}
                                                                                            </span>
                                                                                            
                                                                                                    <div class="post_comments">
                                                                                                            <div class="post_comments_main clearfix">
                                                                                                                <div class="media">
                                                                                                                    <div class="media-body">
                                                                                                                        <span  class="comment_txt">{{$insures_details[$i]['claimClause']['comment']}}</span>        
                                                                                                                    </div>
                                                                                                                    <div class="media-right">
                                                                                                                            <span id="cancel_claimClause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                                             data-content="<input id='claimClause_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['claimClause']['comment']}}'>
                                                                                                                             <label class='error' id='claimClause_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                                             </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='claimClause' onclick='commentEdit(this)'>Update</button>
                                                                                                                             <button name='{{$insures_details[$i]['uniqueToken']}}' value='claimClause' onclick='commentCancel(this)'><i class='material-icons'>close</i></button" data-container="body">
                                                                                                                            <button type="button">
                                                                                                                                    <i class="material-icons">edit</i>
                                                                                                                            </button>
                                                                                                                        </span>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    @else
                                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                                                <div class="ans">
                                                                                                <span id="div_claimClause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                                    title="Edit existing value" data-html="true" data-content="<input id='claimClause_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['claimClause']['isAgree']}}'>
                                                                                                <label class='error' id='claimClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='claimClause' onclick='fun(this)'>Update</button>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='claimClause' onclick='cancel(this)'>
                                                                                                <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['claimClause']['isAgree']}}</span></div></td>
                                                                                    @endif
                                                                            @else
                                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                                            @endif
        
                                                                        @else
                                                                            <td>  <div class="ans">--</div></td>
                                                                        @endif
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
                                                    @if(isset($pipeline_details['formData']['custExtension']) && $pipeline_details['formData']['custExtension'] == true)
                                                            <tr>
                                                                <?php $insure_count=count(@$insures_details);?>
                                                                @if($insure_count==0)
                                                                    @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                        <td>  <div class="ans">--</div></td>
                                                                    @endfor
                                                                @else
                                                                    @for ($i = 0; $i < $total_insure_count; $i++)
                                                                        @if(array_key_exists($i,$insures_details))
                                                                            @if(isset($insures_details[$i]['custExtension']['isAgree']))
                                                                                    @if(@$insures_details[$i]['custExtension']['comment']!="")
                                                                                        <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                            <div class="ans">
                                                                                                <span id="div_custExtension_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                    data-content="<input id='custExtension_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['custExtension']['isAgree']}}'>
                                                                                                    <label class='error' id='custExtension_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='custExtension' onclick='fun(this)'>Update</button>
                                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='custExtension' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                    data-container="body">{{@$insures_details[$i]['custExtension']['isAgree']}}
                                                                                                </span>
                                                                                                
                                                                                                <div class="post_comments">
                                                                                                        <div class="post_comments_main clearfix">
                                                                                                            <div class="media">
                                                                                                                <div class="media-body">
                                                                                                                    <span  class="comment_txt">{{$insures_details[$i]['custExtension']['comment']}}</span>        
                                                                                                                </div>
                                                                                                                <div class="media-right">
                                                                                                                        <span id="cancel_custExtension_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                                        data-content="<input id='custExtension_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['custExtension']['comment']}}'>
                                                                                                                    <label class='error' id='custExtension_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                                    </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='custExtension' onclick='commentEdit(this)'>Update</button>
                                                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='custExtension' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
                                                                                                                                                                                                            data-container="body">
                                                                                                                        <button type="button">
                                                                                                                                <i class="material-icons">edit</i>
                                                                                                                            </button>
                                                                                                                    </span>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                            </div>
                                                                                        </td>
                                                                                    @else
                                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                                                <div class="ans">
                                                                                                <span id="div_custExtension_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                                    title="Edit existing value" data-html="true" data-content="<input id='custExtension_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['custExtension']['isAgree']}}'>
                                                                                                <label class='error' id='custExtension_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='custExtension' onclick='fun(this)'>Update</button>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='custExtension' onclick='cancel(this)'>
                                                                                                <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['custExtension']['isAgree']}}</span></div></td>
                                                                                    @endif
                                                                            @else
                                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                                            @endif
            
                                                                        @else
                                                                            <td>  <div class="ans">--</div></td>
                                                                        @endif
                                                                    @endfor
                                                                @endif
                                                            </tr>
                                                        @endif
                                                        @if(isset($pipeline_details['formData']['accountants']) && $pipeline_details['formData']['accountants'] == true)
                                                        <tr>
                                                            <?php $insure_count=count(@$insures_details);?>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
                                                                        @if(isset($insures_details[$i]['accountants']['isAgree']))
                                                                                @if(@$insures_details[$i]['accountants']['comment']!="")
                                                                                    <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                        <div class="ans">
                                                                                            <span id="div_accountants_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                data-content="<input id='accountants_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['accountants']['isAgree']}}'>
                                                                                                <label class='error' id='accountants_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='accountants' onclick='fun(this)'>Update</button>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='accountants' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                data-container="body">{{@$insures_details[$i]['accountants']['isAgree']}}
                                                                                            </span>
                                                                                            
                                                                                                <div class="post_comments">
                                                                                                        <div class="post_comments_main clearfix">
                                                                                                            <div class="media">
                                                                                                                <div class="media-body">
                                                                                                                    <span  class="comment_txt">{{$insures_details[$i]['accountants']['comment']}}</span>        
                                                                                                                </div>
                                                                                                                <div class="media-right">
                                                                                                                        <span id="cancel_accountants_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                                        data-content="<input id='accountants_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['accountants']['comment']}}'>
                                                                                                                    <label class='error' id='accountants_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                                    </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='accountants' onclick='commentEdit(this)'>Update</button>
                                                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='accountants' onclick='commentCancel(this)'><i class='material-icons'>close</i></button" data-container="body">
                                                                                                                        <button type="button">
                                                                                                                                <i class="material-icons">edit</i>
                                                                                                                            </button>
                                                                                                                    </span>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                        </div>
                                                                                    </td>
                                                                                @else
                                                                                        <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                                            <div class="ans">
                                                                                            <span id="div_accountants_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                                title="Edit existing value" data-html="true" data-content="<input id='accountants_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['accountants']['isAgree']}}'>
                                                                                            <label class='error' id='accountants_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='accountants' onclick='fun(this)'>Update</button>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='accountants' onclick='cancel(this)'>
                                                                                            <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['accountants']['isAgree']}}</span></div></td>
                                                                                @endif
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                                        @endif
        
                                                                    @else
                                                                        <td>  <div class="ans">--</div></td>
                                                                    @endif
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
                                                    @if(isset($pipeline_details['formData']['payAccount']) && $pipeline_details['formData']['payAccount'] == true)
                                                        <tr>
                                                            <?php $insure_count=count(@$insures_details);?>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
                                                                        @if(isset($insures_details[$i]['payAccount']['isAgree']))
                                                                                @if(@$insures_details[$i]['payAccount']['comment']!="")
                                                                                    <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                        <div class="ans">
                                                                                            <span id="div_payAccount_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                data-content="<input id='payAccount_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['payAccount']['isAgree']}}'>
                                                                                                <label class='error' id='payAccount_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='payAccount' onclick='fun(this)'>Update</button>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='payAccount' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                data-container="body">{{@$insures_details[$i]['payAccount']['isAgree']}}
                                                                                            </span>
                                                                                            
                                                                                                <div class="post_comments">
                                                                                                        <div class="post_comments_main clearfix">
                                                                                                            <div class="media">
                                                                                                                <div class="media-body">
                                                                                                                    <span  class="comment_txt">{{$insures_details[$i]['payAccount']['comment']}}</span>        
                                                                                                                </div>
                                                                                                                <div class="media-right">
                                                                                                                        <span id="cancel_payAccount_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                                            data-content="<input id='payAccount_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['payAccount']['comment']}}'>
                                                                                                                            <label class='error' id='payAccount_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                                            </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='payAccount' onclick='commentEdit(this)'>Update</button>
                                                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='payAccount' onclick='commentCancel(this)'><i class='material-icons'>close</i></button" data-container="body">
                                                                                                                        <button type="button">
                                                                                                                                <i class="material-icons">edit</i>
                                                                                                                            </button>
                                                                                                                    </span>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                        </div>
                                                                                    </td>
                                                                                @else
                                                                                        <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                                            <div class="ans">
                                                                                            <span id="div_payAccount_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                                title="Edit existing value" data-html="true" data-content="<input id='payAccount_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['payAccount']['isAgree']}}'>
                                                                                            <label class='error' id='payAccount_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='payAccount' onclick='fun(this)'>Update</button>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='payAccount' onclick='cancel(this)'>
                                                                                            <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['payAccount']['isAgree']}}</span></div></td>
                                                                                @endif
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                                        @endif

                                                                    @else
                                                                        <td>  <div class="ans">--</div></td>
                                                                    @endif
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
                                                    @if(isset($pipeline_details['formData']['denialAccess']) && $pipeline_details['formData']['denialAccess'] == true)
                                                        <tr>
                                                            <?php $insure_count=count(@$insures_details);?>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
                                                                        @if(isset($insures_details[$i]['denialAccess']['isAgree']))
                                                                                @if(@$insures_details[$i]['denialAccess']['comment']!="")
                                                                                    <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                        <div class="ans">
                                                                                            <span id="div_denialAccess_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                data-content="<input id='denialAccess_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['denialAccess']['isAgree']}}'>
                                                                                                <label class='error' id='denialAccess_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='denialAccess' onclick='fun(this)'>Update</button>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='denialAccess' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                data-container="body">{{@$insures_details[$i]['denialAccess']['isAgree']}}
                                                                                            </span>
                                                                                      
                                                                                                <div class="post_comments">
                                                                                                        <div class="post_comments_main clearfix">
                                                                                                            <div class="media">
                                                                                                                <div class="media-body">
                                                                                                                    <span  class="comment_txt">{{$insures_details[$i]['denialAccess']['comment']}}</span>        
                                                                                                                </div>
                                                                                                                <div class="media-right">
                                                                                                                        <span id="cancel_denialAccess_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                                        data-content="<input id='denialAccess_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['denialAccess']['comment']}}'>
                                                                                                                    <label class='error' id='denialAccess_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                                    </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='denialAccess' onclick='commentEdit(this)'>Update</button>
                                                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='denialAccess' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
                                                                                                                                                                                                            data-container="body">
                                                                                                                        <button type="button">
                                                                                                                                <i class="material-icons">edit</i>
                                                                                                                            </button>
                                                                                                                    </span>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                        </div>
                                                                                    </td>
                                                                                @else
                                                                                        <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                                            <div class="ans">
                                                                                            <span id="div_denialAccess_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                                title="Edit existing value" data-html="true" data-content="<input id='denialAccess_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['denialAccess']['isAgree']}}'>
                                                                                            <label class='error' id='denialAccess_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='denialAccess' onclick='fun(this)'>Update</button>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='denialAccess' onclick='cancel(this)'>
                                                                                            <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['denialAccess']['isAgree']}}</span></div></td>
                                                                                @endif
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                                        @endif

                                                                    @else
                                                                        <td>  <div class="ans">--</div></td>
                                                                    @endif
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
                                                    @if(isset($pipeline_details['formData']['premiumClause']) && $pipeline_details['formData']['premiumClause'] == true)
                                                        <tr>
                                                            <?php $insure_count=count(@$insures_details);?>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
                                                                        @if(isset($insures_details[$i]['premiumClause']['isAgree']))
                                                                                @if(@$insures_details[$i]['premiumClause']['comment']!="")
                                                                                    <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                        <div class="ans">
                                                                                            <span id="div_premiumClause_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                data-content="<input id='premiumClause_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['premiumClause']['isAgree']}}'>
                                                                                                <label class='error' id='premiumClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='premiumClause' onclick='fun(this)'>Update</button>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='premiumClause' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                data-container="body">{{@$insures_details[$i]['premiumClause']['isAgree']}}
                                                                                            </span>
                                                                                            
                                                                                            <div class="post_comments">
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <div class="media">
                                                                                                            <div class="media-body">
                                                                                                                <span  class="comment_txt">{{$insures_details[$i]['premiumClause']['comment']}}</span>        
                                                                                                            </div>
                                                                                                            <div class="media-right">
                                                                                                                    <span id="cancel_premiumClause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                    data-content="<input id='premiumClause_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['premiumClause']['comment']}}'>
                                                                                                <label class='error' id='premiumClause_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='premiumClause' onclick='commentEdit(this)'>Update</button>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='premiumClause' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
                                                                                                                                                                                        data-container="body">
                                                                                                                    <button type="button">
                                                                                                                            <i class="material-icons">edit</i>
                                                                                                                        </button>
                                                                                                                </span>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                        </div>
                                                                                    </td>
                                                                                @else
                                                                                        <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                                            <div class="ans">
                                                                                            <span id="div_premiumClause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                                title="Edit existing value" data-html="true" data-content="<input id='premiumClause_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['premiumClause']['isAgree']}}'>
                                                                                            <label class='error' id='premiumClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='premiumClause' onclick='fun(this)'>Update</button>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='premiumClause' onclick='cancel(this)'>
                                                                                            <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['premiumClause']['isAgree']}}</span></div></td>
                                                                                @endif
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                                        @endif
                                                                    @else
                                                                        <td>  <div class="ans">--</div></td>
                                                                    @endif
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
                                                    @if(isset($pipeline_details['formData']['utilityClause']) && $pipeline_details['formData']['utilityClause'] == true)
                                                        <tr>
                                                            <?php $insure_count=count(@$insures_details);?>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
                                                                        @if(isset($insures_details[$i]['utilityClause']['isAgree']))
                                                                                @if(@$insures_details[$i]['utilityClause']['comment']!="")
                                                                                    <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                        <div class="ans">
                                                                                            <span id="div_utilityClause_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                data-content="<input id='utilityClause_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['utilityClause']['isAgree']}}'>
                                                                                                <label class='error' id='utilityClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='utilityClause' onclick='fun(this)'>Update</button>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='utilityClause' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                data-container="body">{{@$insures_details[$i]['utilityClause']['isAgree']}}
                                                                                            </span>
                                                                                            
                                                                                                <div class="post_comments">
                                                                                                        <div class="post_comments_main clearfix">
                                                                                                            <div class="media">
                                                                                                                <div class="media-body">
                                                                                                                    <span  class="comment_txt">{{$insures_details[$i]['utilityClause']['comment']}}</span>        
                                                                                                                </div>
                                                                                                                <div class="media-right">
                                                                                                                        <span id="cancel_utilityClause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                    data-content="<input id='utilityClause_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['utilityClause']['comment']}}'>
                                                                                                <label class='error' id='utilityClause_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='utilityClause' onclick='commentEdit(this)'>Update</button>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='utilityClause' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
                                                                                                                                                                                        data-container="body">
                                                                                                                        <button type="button">
                                                                                                                                <i class="material-icons">edit</i>
                                                                                                                            </button>
                                                                                                                    </span>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    @else
                                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                                                <div class="ans">
                                                                                                <span id="div_utilityClause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                                    title="Edit existing value" data-html="true" data-content="<input id='utilityClause_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['utilityClause']['isAgree']}}'>
                                                                                                <label class='error' id='utilityClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='utilityClause' onclick='fun(this)'>Update</button>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='utilityClause' onclick='cancel(this)'>
                                                                                                <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['utilityClause']['isAgree']}}</span></div></td>
                                                                                    @endif
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                                        @endif
        
                                                                    @else
                                                                        <td>  <div class="ans">--</div></td>
                                                                    @endif
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
                                                    @if(isset($pipeline_details['formData']['brokerClaim']) && $pipeline_details['formData']['brokerClaim']== true)     
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                        @if(array_key_exists($i,$insures_details))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                                <div class="ans">
                                                                                    <span id='div_brokerClaim_{{$insures_details[$i]['uniqueToken']}}'
                                                                                        data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
                                                                                        <input id='brokerClaim_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['brokerClaim']?:'--'}}' required>
                                                                                        <label class='error' id='brokerClaim_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='brokerClaim' onclick='fun(this)'>Update</button>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='brokerClaim' onclick='cancel(this)'>
                                                                                        <i class='material-icons'>close</i></button>"
                                                                                        data-container="body">{{$insures_details[$i]['brokerClaim']?:'--'}}
                                                                                    </span>
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td>  <div class="ans">--</div></td>
                                                                        @endif
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
                                                    @if(isset($pipeline_details['formData']['bookedDebts']) && $pipeline_details['formData']['bookedDebts'] == true)
                                                        <tr>
                                                            <?php $insure_count=count(@$insures_details);?>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
                                                                        @if(isset($insures_details[$i]['bookedDebts']['isAgree']))
                                                                                @if(@$insures_details[$i]['bookedDebts']['comment']!="")
                                                                                    <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                        <div class="ans">
                                                                                            <span id="div_bookedDebts_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                data-content="<input id='bookedDebts_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['bookedDebts']['isAgree']}}'>
                                                                                                <label class='error' id='bookedDebts_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='bookedDebts' onclick='fun(this)'>Update</button>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='bookedDebts' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                data-container="body">{{@$insures_details[$i]['bookedDebts']['isAgree']}}
                                                                                            </span>
                                                                                            
                                                                                                <div class="post_comments">
                                                                                                        <div class="post_comments_main clearfix">
                                                                                                            <div class="media">
                                                                                                                <div class="media-body">
                                                                                                                    <span  class="comment_txt">{{$insures_details[$i]['bookedDebts']['comment']}}</span>        
                                                                                                                </div>
                                                                                                                <div class="media-right">
                                                                                                                        <span id="cancel_bookedDebts_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                                        data-content="<input id='bookedDebts_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['bookedDebts']['comment']}}'>
                                                                                                                    <label class='error' id='bookedDebts_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                                    </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='bookedDebts' onclick='commentEdit(this)'>Update</button>
                                                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='bookedDebts' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
                                                                                                                                                                                                            data-container="body">
                                                                                                                        <button type="button">
                                                                                                                                <i class="material-icons">edit</i>
                                                                                                                            </button>
                                                                                                                    </span>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                        </div>
                                                                                    </td>
                                                                                @else
                                                                                        <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                                            <div class="ans">
                                                                                            <span id="div_bookedDebts_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                                title="Edit existing value" data-html="true" data-content="<input id='bookedDebts_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['bookedDebts']['isAgree']}}'>
                                                                                            <label class='error' id='bookedDebts_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='bookedDebts' onclick='fun(this)'>Update</button>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='bookedDebts' onclick='cancel(this)'>
                                                                                            <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['bookedDebts']['isAgree']}}</span></div></td>
                                                                                @endif
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                                        @endif
        
                                                                    @else
                                                                        <td>  <div class="ans">--</div></td>
                                                                    @endif
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
                                                    @if(isset($pipeline_details['formData']['interdependanyClause']) && $pipeline_details['formData']['interdependanyClause']== true)     
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                        @if(array_key_exists($i,$insures_details))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                                <div class="ans">
                                                                                    <span id='div_interdependanyClause_{{$insures_details[$i]['uniqueToken']}}'
                                                                                        data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
                                                                                        <input id='interdependanyClause_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['interdependanyClause']?:'--'}}' required>
                                                                                        <label class='error' id='interdependanyClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='interdependanyClause' onclick='fun(this)'>Update</button>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='interdependanyClause' onclick='cancel(this)'>
                                                                                        <i class='material-icons'>close</i></button>"
                                                                                        data-container="body">{{$insures_details[$i]['interdependanyClause']?:'--'}}
                                                                                    </span>
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td>  <div class="ans">--</div></td>
                                                                        @endif
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
                                                    @if(isset($pipeline_details['formData']['extraExpense']) && $pipeline_details['formData']['extraExpense'] == true)
                                                        <tr>
                                                            <?php $insure_count=count(@$insures_details);?>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
                                                                        @if(isset($insures_details[$i]['extraExpense']['isAgree']))
                                                                                @if(@$insures_details[$i]['extraExpense']['comment']!="")
                                                                                    <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                        <div class="ans">
                                                                                            <span id="div_extraExpense_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                data-content="<input id='extraExpense_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['extraExpense']['isAgree']}}'>
                                                                                                <label class='error' id='extraExpense_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='extraExpense' onclick='fun(this)'>Update</button>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='extraExpense' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                data-container="body">{{@$insures_details[$i]['extraExpense']['isAgree']}}
                                                                                            </span>
                                                                                          
                                                                                            <div class="post_comments">
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <div class="media">
                                                                                                            <div class="media-body">
                                                                                                                <span  class="comment_txt">{{$insures_details[$i]['extraExpense']['comment']}}</span>        
                                                                                                            </div>
                                                                                                            <div class="media-right">
                                                                                                                    <span id="cancel_extraExpense_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                    data-content="<input id='extraExpense_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['extraExpense']['comment']}}'>
                                                                                                <label class='error' id='extraExpense_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='extraExpense' onclick='commentEdit(this)'>Update</button>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='extraExpense' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
                                                                                                                                                                                        data-container="body">
                                                                                                                    <button type="button">
                                                                                                                            <i class="material-icons">edit</i>
                                                                                                                        </button>
                                                                                                                </span>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                        </div>
                                                                                    </td>
                                                                                @else
                                                                                        <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                                            <div class="ans">
                                                                                            <span id="div_extraExpense_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                                title="Edit existing value" data-html="true" data-content="<input id='extraExpense_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['extraExpense']['isAgree']}}'>
                                                                                            <label class='error' id='extraExpense_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='extraExpense' onclick='fun(this)'>Update</button>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='extraExpense' onclick='cancel(this)'>
                                                                                            <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['extraExpense']['isAgree']}}</span></div></td>
                                                                                @endif
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                                        @endif
        
                                                                    @else
                                                                        <td>  <div class="ans">--</div></td>
                                                                    @endif
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
                                                    @if(isset($pipeline_details['formData']['water']) && $pipeline_details['formData']['water']== true)      
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                        @if(array_key_exists($i,$insures_details))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                                <div class="ans">
                                                                                    <span id='div_water_{{$insures_details[$i]['uniqueToken']}}'
                                                                                        data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
                                                                                        <input id='water_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['water']?:'--'}}' required>
                                                                                        <label class='error' id='water_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='water' onclick='fun(this)'>Update</button>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='water' onclick='cancel(this)'>
                                                                                        <i class='material-icons'>close</i></button>"
                                                                                        data-container="body">{{$insures_details[$i]['water']?:'--'}}
                                                                                    </span>
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td>  <div class="ans">--</div></td>
                                                                        @endif
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif          
                                                    @if(isset($pipeline_details['formData']['auditorFee']) && $pipeline_details['formData']['auditorFee'] == true)
                                                        <tr>
                                                            <?php $insure_count=count(@$insures_details);?>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
                                                                        @if(isset($insures_details[$i]['auditorFee']['isAgree']))
                                                                                @if(@$insures_details[$i]['auditorFee']['comment']!="")
                                                                                    <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                        <div class="ans">
                                                                                            <span id="div_auditorFee_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                data-content="<input id='auditorFee_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['auditorFee']['isAgree']}}'>
                                                                                                <label class='error' id='auditorFee_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='auditorFee' onclick='fun(this)'>Update</button>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='auditorFee' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                data-container="body">{{@$insures_details[$i]['auditorFee']['isAgree']}}
                                                                                            </span>
                                                                                            
                                                                                            <div class="post_comments">
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <div class="media">
                                                                                                            <div class="media-body">
                                                                                                                <span  class="comment_txt">{{$insures_details[$i]['auditorFee']['comment']}}</span>        
                                                                                                            </div>
                                                                                                            <div class="media-right">
                                                                                                                    <span id="cancel_auditorFee_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                                    data-content="<input id='auditorFee_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['auditorFee']['comment']}}'>
                                                                                                                <label class='error' id='auditorFee_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                                </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='auditorFee' onclick='commentEdit(this)'>Update</button>
                                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='auditorFee' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
                                                                                                                                                                                                        data-container="body">
                                                                                                                    <button type="button">
                                                                                                                            <i class="material-icons">edit</i>
                                                                                                                        </button>
                                                                                                                </span>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    @else
                                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                                                <div class="ans">
                                                                                                <span id="div_auditorFee_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                                    title="Edit existing value" data-html="true" data-content="<input id='auditorFee_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['auditorFee']['isAgree']}}'>
                                                                                                <label class='error' id='auditorFee_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='auditorFee' onclick='fun(this)'>Update</button>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='auditorFee' onclick='cancel(this)'>
                                                                                                <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['auditorFee']['isAgree']}}</span></div></td>
                                                                                    @endif
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                                        @endif

                                                                    @else
                                                                        <td>  <div class="ans">--</div></td>
                                                                    @endif
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif   
                                                    @if(isset($pipeline_details['formData']['expenseLaws']) && $pipeline_details['formData']['expenseLaws'] == true)
                                                        <tr>
                                                            <?php $insure_count=count(@$insures_details);?>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
                                                                        @if(isset($insures_details[$i]['expenseLaws']['isAgree']))
                                                                                @if(@$insures_details[$i]['expenseLaws']['comment']!="")
                                                                                    <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                        <div class="ans">
                                                                                            <span id="div_expenseLaws_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                data-content="<input id='expenseLaws_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['expenseLaws']['isAgree']}}'>
                                                                                                <label class='error' id='expenseLaws_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='expenseLaws' onclick='fun(this)'>Update</button>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='expenseLaws' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                data-container="body">{{@$insures_details[$i]['expenseLaws']['isAgree']}}
                                                                                            </span>
                                                                                           
                                                                                                <div class="post_comments">
                                                                                                        <div class="post_comments_main clearfix">
                                                                                                            <div class="media">
                                                                                                                <div class="media-body">
                                                                                                                    <span  class="comment_txt">{{$insures_details[$i]['expenseLaws']['comment']}}</span>        
                                                                                                                </div>
                                                                                                                <div class="media-right">
                                                                                                                        <span id="cancel_expenseLaws_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                    data-content="<input id='expenseLaws_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['expenseLaws']['comment']}}'>
                                                                                                <label class='error' id='expenseLaws_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='expenseLaws' onclick='commentEdit(this)'>Update</button>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='expenseLaws' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
                                                                                                                                                                                        data-container="body">
                                                                                                                        <button type="button">
                                                                                                                                <i class="material-icons">edit</i>
                                                                                                                            </button>
                                                                                                                    </span>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    @else
                                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                                                <div class="ans">
                                                                                                <span id="div_expenseLaws_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                                    title="Edit existing value" data-html="true" data-content="<input id='expenseLaws_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['expenseLaws']['isAgree']}}'>
                                                                                                <label class='error' id='expenseLaws_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='expenseLaws' onclick='fun(this)'>Update</button>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='expenseLaws' onclick='cancel(this)'>
                                                                                                <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['expenseLaws']['isAgree']}}</span></div></td>
                                                                                    @endif
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                                        @endif
        
                                                                    @else
                                                                        <td>  <div class="ans">--</div></td>
                                                                    @endif
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
                                                    @if(isset($pipeline_details['formData']['lossAdjuster']) && $pipeline_details['formData']['lossAdjuster'] == true)
                                                        <tr>
                                                            <?php $insure_count=count(@$insures_details);?>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
                                                                        @if(isset($insures_details[$i]['lossAdjuster']['isAgree']))
                                                                                @if(@$insures_details[$i]['lossAdjuster']['comment']!="")
                                                                                    <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                        <div class="ans">
                                                                                            <span id="div_lossAdjuster_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                data-content="<input id='lossAdjuster_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['lossAdjuster']['isAgree']}}'>
                                                                                                <label class='error' id='lossAdjuster_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='lossAdjuster' onclick='fun(this)'>Update</button>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='lossAdjuster' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                data-container="body">{{@$insures_details[$i]['lossAdjuster']['isAgree']}}
                                                                                            </span>
                                                                                           
                                                                                                <div class="post_comments">
                                                                                                        <div class="post_comments_main clearfix">
                                                                                                            <div class="media">
                                                                                                                <div class="media-body">
                                                                                                                    <span  class="comment_txt">{{$insures_details[$i]['lossAdjuster']['comment']}}</span>        
                                                                                                                </div>
                                                                                                                <div class="media-right">
                                                                                                                        <span id="cancel_lossAdjuster_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                                        data-content="<input id='lossAdjuster_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['lossAdjuster']['comment']}}'>
                                                                                                                    <label class='error' id='lossAdjuster_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                                    </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='lossAdjuster' onclick='commentEdit(this)'>Update</button>
                                                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='lossAdjuster' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
                                                                                                                                                                                                            data-container="body">
                                                                                                                        <button type="button">
                                                                                                                                <i class="material-icons">edit</i>
                                                                                                                            </button>
                                                                                                                    </span>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    @else
                                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                                                <div class="ans">
                                                                                                <span id="div_lossAdjuster_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                                    title="Edit existing value" data-html="true" data-content="<input id='lossAdjuster_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['lossAdjuster']['isAgree']}}'>
                                                                                                <label class='error' id='lossAdjuster_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='lossAdjuster' onclick='fun(this)'>Update</button>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='lossAdjuster' onclick='cancel(this)'>
                                                                                                <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['lossAdjuster']['isAgree']}}</span></div></td>
                                                                                    @endif
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                                        @endif
        
                                                                    @else
                                                                        <td>  <div class="ans">--</div></td>
                                                                    @endif
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
                                                    @if(isset($pipeline_details['formData']['discease']) && $pipeline_details['formData']['discease'] == true)
                                                        <tr>
                                                            <?php $insure_count=count(@$insures_details);?>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
                                                                        @if(isset($insures_details[$i]['discease']['isAgree']))
                                                                                @if(@$insures_details[$i]['discease']['comment']!="")
                                                                                    <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                        <div class="ans">
                                                                                            <span id="div_discease_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                data-content="<input id='discease_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['discease']['isAgree']}}'>
                                                                                                <label class='error' id='discease_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='discease' onclick='fun(this)'>Update</button>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='discease' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                data-container="body">{{@$insures_details[$i]['discease']['isAgree']}}
                                                                                            </span>
                                                                                            
                                                                                            <div class="post_comments">
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <div class="media">
                                                                                                            <div class="media-body">
                                                                                                                <span  class="comment_txt">{{$insures_details[$i]['discease']['comment']}}</span>        
                                                                                                            </div>
                                                                                                            <div class="media-right">
                                                                                                                    <span id="cancel_discease_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                                    data-content="<input id='discease_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['discease']['comment']}}'>
                                                                                                                <label class='error' id='discease_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                                </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='discease' onclick='commentEdit(this)'>Update</button>
                                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='discease' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
                                                                                                                                                                                                        data-container="body">
                                                                                                                    <button type="button">
                                                                                                                            <i class="material-icons">edit</i>
                                                                                                                        </button>
                                                                                                                </span>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    @else
                                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                                                <div class="ans">
                                                                                                <span id="div_discease_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                                    title="Edit existing value" data-html="true" data-content="<input id='discease_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['discease']['isAgree']}}'>
                                                                                                <label class='error' id='discease_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='discease' onclick='fun(this)'>Update</button>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='discease' onclick='cancel(this)'>
                                                                                                <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['discease']['isAgree']}}</span></div></td>
                                                                                    @endif
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                                        @endif

                                                                    @else
                                                                        <td>  <div class="ans">--</div></td>
                                                                    @endif
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
                                                    @if(isset($pipeline_details['formData']['powerSupply']) && $pipeline_details['formData']['powerSupply'] == true)
                                                        <tr>
                                                            <?php $insure_count=count(@$insures_details);?>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
                                                                        @if(isset($insures_details[$i]['powerSupply']['isAgree']))
                                                                                @if(@$insures_details[$i]['powerSupply']['comment']!="")
                                                                                    <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                        <div class="ans">
                                                                                            <span id="div_powerSupply_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                data-content="<input id='powerSupply_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['powerSupply']['isAgree']}}'>
                                                                                                <label class='error' id='powerSupply_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='powerSupply' onclick='fun(this)'>Update</button>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='powerSupply' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                data-container="body">{{@$insures_details[$i]['powerSupply']['isAgree']}}
                                                                                            </span>
                                                                                            
                                                                                            <div class="post_comments">
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <div class="media">
                                                                                                            <div class="media-body">
                                                                                                                <span  class="comment_txt">{{$insures_details[$i]['powerSupply']['comment']}}</span>        
                                                                                                            </div>
                                                                                                            <div class="media-right">
                                                                                                                    <span id="cancel_powerSupply_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                                    data-content="<input id='powerSupply_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['powerSupply']['comment']}}'>
                                                                                                                <label class='error' id='powerSupply_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                                </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='powerSupply' onclick='commentEdit(this)'>Update</button>
                                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='powerSupply' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
                                                                                                                                                                                                        data-container="body">
                                                                                                                    <button type="button">
                                                                                                                            <i class="material-icons">edit</i>
                                                                                                                        </button>
                                                                                                                </span>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    @else
                                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                                                <div class="ans">
                                                                                                <span id="div_powerSupply_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                                    title="Edit existing value" data-html="true" data-content="<input id='powerSupply_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['powerSupply']['isAgree']}}'>
                                                                                                <label class='error' id='powerSupply_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='powerSupply' onclick='fun(this)'>Update</button>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='powerSupply' onclick='cancel(this)'>
                                                                                                <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['powerSupply']['isAgree']}}</span></div></td>
                                                                                    @endif
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                                        @endif
        
                                                                    @else
                                                                        <td>  <div class="ans">--</div></td>
                                                                    @endif
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
                                                    @if(isset($pipeline_details['formData']['condition1']) && $pipeline_details['formData']['condition1'] == true)
                                                        <tr>
                                                            <?php $insure_count=count(@$insures_details);?>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
                                                                        @if(isset($insures_details[$i]['condition1']['isAgree']))
                                                                                @if(@$insures_details[$i]['condition1']['comment']!="")
                                                                                    <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                        <div class="ans">
                                                                                            <span id="div_condition1_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                data-content="<input id='condition1_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['condition1']['isAgree']}}'>
                                                                                                <label class='error' id='condition1_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='condition1' onclick='fun(this)'>Update</button>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='condition1' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                data-container="body">{{@$insures_details[$i]['condition1']['isAgree']}}
                                                                                            </span>
                                                                                       
                                                                                                <div class="post_comments">
                                                                                                        <div class="post_comments_main clearfix">
                                                                                                            <div class="media">
                                                                                                                <div class="media-body">
                                                                                                                    <span  class="comment_txt">{{$insures_details[$i]['condition1']['comment']}}</span>        
                                                                                                                </div>
                                                                                                                <div class="media-right">
                                                                                                                        <span id="cancel_condition1_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                                        data-content="<input id='condition1_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['condition1']['comment']}}'>
                                                                                                                    <label class='error' id='condition1_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                                    </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='condition1' onclick='commentEdit(this)'>Update</button>
                                                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='condition1' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
                                                                                                                                                                                                            data-container="body">
                                                                                                                        <button type="button">
                                                                                                                                <i class="material-icons">edit</i>
                                                                                                                            </button>
                                                                                                                    </span>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                        </div>
                                                                                    </td>
                                                                                @else
                                                                                        <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                                            <div class="ans">
                                                                                            <span id="div_condition1_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                                title="Edit existing value" data-html="true" data-content="<input id='condition1_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['condition1']['isAgree']}}'>
                                                                                            <label class='error' id='condition1_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='condition1' onclick='fun(this)'>Update</button>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='condition1' onclick='cancel(this)'>
                                                                                            <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['condition1']['isAgree']}}</span></div></td>
                                                                                @endif
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                                        @endif
        
                                                                    @else
                                                                        <td>  <div class="ans">--</div></td>
                                                                    @endif
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
                                                    @if(isset($pipeline_details['formData']['condition2']) && $pipeline_details['formData']['condition2'] == true)
                                                        <tr>
                                                            <?php $insure_count=count(@$insures_details);?>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
                                                                        @if(isset($insures_details[$i]['condition2']['isAgree']))
                                                                                @if(@$insures_details[$i]['condition2']['comment']!="")
                                                                                    <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                        <div class="ans">
                                                                                            <span id="div_condition2_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                data-content="<input id='condition2_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['condition2']['isAgree']}}'>
                                                                                                <label class='error' id='condition2_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='condition2' onclick='fun(this)'>Update</button>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='condition2' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                data-container="body">{{@$insures_details[$i]['condition2']['isAgree']}}
                                                                                            </span>
                                                                                            
                                                                                                <div class="post_comments">
                                                                                                        <div class="post_comments_main clearfix">
                                                                                                            <div class="media">
                                                                                                                <div class="media-body">
                                                                                                                    <span  class="comment_txt">{{$insures_details[$i]['condition2']['comment']}}</span>        
                                                                                                                </div>
                                                                                                                <div class="media-right">
                                                                                                                        <span id="cancel_condition2_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                                        data-content="<input id='condition2_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['condition2']['comment']}}'>
                                                                                                                    <label class='error' id='condition2_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                                    </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='condition2' onclick='commentEdit(this)'>Update</button>
                                                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='condition2' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
                                                                                                                                                                                                            data-container="body">
                                                                                                                        <button type="button">
                                                                                                                                <i class="material-icons">edit</i>
                                                                                                                            </button>
                                                                                                                    </span>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                        </div>
                                                                                    </td>
                                                                                @else
                                                                                        <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                                            <div class="ans">
                                                                                            <span id="div_condition2_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                                title="Edit existing value" data-html="true" data-content="<input id='condition2_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['condition2']['isAgree']}}'>
                                                                                            <label class='error' id='condition2_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='condition2' onclick='fun(this)'>Update</button>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='condition2' onclick='cancel(this)'>
                                                                                            <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['condition2']['isAgree']}}</span></div></td>
                                                                                @endif
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                                        @endif
        
                                                                    @else
                                                                        <td>  <div class="ans">--</div></td>
                                                                    @endif
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
                                                    @if(isset($pipeline_details['formData']['bookofDebts']) && $pipeline_details['formData']['bookofDebts'] == true)
                                                        <tr>
                                                            <?php $insure_count=count(@$insures_details);?>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
                                                                        @if(isset($insures_details[$i]['bookofDebts']['isAgree']))
                                                                            @if(@$insures_details[$i]['bookofDebts']['comment']!="")
                                                                                <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                    <div class="ans">
                                                                                        <span id="div_bookofDebts_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                            data-content="<input id='bookofDebts_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['bookofDebts']['isAgree']}}'>
                                                                                            <label class='error' id='bookofDebts_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='bookofDebts' onclick='fun(this)'>Update</button>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='bookofDebts' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                            data-container="body">{{@$insures_details[$i]['bookofDebts']['isAgree']}}
                                                                                        </span>
                                                                                        
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['bookofDebts']['comment']}}</span>        
                                                                                                        </div>
                                                                                                        <div class="media-right">
                                                                                                                <span id="cancel_bookofDebts_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                                data-content="<input id='bookofDebts_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['bookofDebts']['comment']}}'>
                                                                                                            <label class='error' id='bookofDebts_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                            </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='bookofDebts' onclick='commentEdit(this)'>Update</button>
                                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='bookofDebts' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
                                                                                                                                                                                                    data-container="body">
                                                                                                                <button type="button">
                                                                                                                        <i class="material-icons">edit</i>
                                                                                                                    </button>
                                                                                                            </span>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>
                                                                                </td>
                                                                        @else
                                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                                    <div class="ans">
                                                                                    <span id="div_bookofDebts_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                        title="Edit existing value" data-html="true" data-content="<input id='bookofDebts_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['bookofDebts']['isAgree']}}'>
                                                                                    <label class='error' id='bookofDebts_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='bookofDebts' onclick='fun(this)'>Update</button>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='bookofDebts' onclick='cancel(this)'>
                                                                                    <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['bookofDebts']['isAgree']}}</span></div></td>
                                                                        @endif
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                                        @endif
        
                                                                    @else
                                                                        <td>  <div class="ans">--</div></td>
                                                                    @endif
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['risk']>1 && isset($pipeline_details['formData']['depclause']) && $pipeline_details['formData']['depclause']== true)     
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
                                                                        <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                            <div class="ans">
                                                                                <span id='div_depclause_{{$insures_details[$i]['uniqueToken']}}'
                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
                                                                                    <input id='depclause_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['depclause']?:'--'}}' required>
                                                                                    <label class='error' id='depclause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='depclause' onclick='fun(this)'>Update</button>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='depclause' onclick='cancel(this)'>
                                                                                    <i class='material-icons'>close</i></button>"
                                                                                    data-container="body">{{$insures_details[$i]['depclause']?:'--'}}
                                                                                </span>
                                                                            </div>
                                                                        </td>
                                                                    @else
                                                                        <td>  <div class="ans">--</div></td>
                                                                    @endif
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
                                                    @if(isset($pipeline_details['formData']['rent']) && $pipeline_details['formData']['rent'] == true)
                                                        <tr>
                                                            <?php $insure_count=count(@$insures_details);?>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
                                                                        @if(isset($insures_details[$i]['rent']['isAgree']))
                                                                            @if(@$insures_details[$i]['rent']['comment']!="")
                                                                                <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                    <div class="ans">
                                                                                        <span id="div_rent_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                            data-content="<input id='rent_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['rent']['isAgree']}}'>
                                                                                            <label class='error' id='rent_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='rent' onclick='fun(this)'>Update</button>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='rent' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                            data-container="body">{{@$insures_details[$i]['rent']['isAgree']}}
                                                                                        </span>
                                                                                       
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['rent']['comment']}}</span>        
                                                                                                        </div>
                                                                                                        <div class="media-right">
                                                                                                                <span id="cancel_rent_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                data-content="<input id='rent_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['rent']['comment']}}'>
                                                                                            <label class='error' id='rent_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                            </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='rent' onclick='commentEdit(this)'>Update</button>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='rent' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
                                                                                                                                                                                    data-container="body">
                                                                                                                <button type="button">
                                                                                                                        <i class="material-icons">edit</i>
                                                                                                                    </button>
                                                                                                            </span>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>
                                                                                </td>
                                                                        @else
                                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                                    <div class="ans">
                                                                                    <span id="div_rent_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                        title="Edit existing value" data-html="true" data-content="<input id='rent_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['rent']['isAgree']}}'>
                                                                                    <label class='error' id='rent_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='rent' onclick='fun(this)'>Update</button>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='rent' onclick='cancel(this)'>
                                                                                    <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['rent']['isAgree']}}</span></div></td>
                                                                        @endif
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                                        @endif
        
                                                                    @else
                                                                        <td>  <div class="ans">--</div></td>
                                                                    @endif
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
                                                    @if(isset($pipeline_details['formData']['hasaccomodation']) && $pipeline_details['formData']['hasaccomodation'] == "yes")
                                                        <tr>
                                                            <?php $insure_count=count(@$insures_details);?>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
                                                                        @if(isset($insures_details[$i]['hasaccomodation']['isAgree']))
                                                                            @if(@$insures_details[$i]['hasaccomodation']['comment']!="")
                                                                                <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                    <div class="ans">
                                                                                        <span id="div_hasaccomodation_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                            data-content="<input id='hasaccomodation_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['hasaccomodation']['isAgree']}}'>
                                                                                            <label class='error' id='hasaccomodation_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='hasaccomodation' onclick='fun(this)'>Update</button>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='hasaccomodation' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                            data-container="body">{{@$insures_details[$i]['hasaccomodation']['isAgree']}}
                                                                                        </span>
                                                                                        
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['hasaccomodation']['comment']}}</span>        
                                                                                                        </div>
                                                                                                        <div class="media-right">
                                                                                                                <span id="cancel_hasaccomodation_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                                data-content="<input id='hasaccomodation_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['hasaccomodation']['comment']}}'>
                                                                                                            <label class='error' id='hasaccomodation_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                            </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='hasaccomodation' onclick='commentEdit(this)'>Update</button>
                                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='hasaccomodation' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
                                                                                                                                                                                                    data-container="body">
                                                                                                                <button type="button">
                                                                                                                        <i class="material-icons">edit</i>
                                                                                                                    </button>
                                                                                                            </span>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>
                                                                                </td>
                                                                        @else
                                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                                    <div class="ans">
                                                                                    <span id="div_hasaccomodation_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                        title="Edit existing value" data-html="true" data-content="<input id='hasaccomodation_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['hasaccomodation']['isAgree']}}'>
                                                                                    <label class='error' id='hasaccomodation_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='hasaccomodation' onclick='fun(this)'>Update</button>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='hasaccomodation' onclick='cancel(this)'>
                                                                                    <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['hasaccomodation']['isAgree']}}</span></div></td>
                                                                        @endif
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                                        @endif
        
                                                                    @else
                                                                        <td>  <div class="ans">--</div></td>
                                                                    @endif
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
                                                    @if(isset($pipeline_details['formData']['costofConstruction']) && $pipeline_details['formData']['costofConstruction'] == true)
                                                        <tr>
                                                            <?php $insure_count=count(@$insures_details);?>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
                                                                        @if(isset($insures_details[$i]['costofConstruction']['isAgree']))
                                                                                @if(@$insures_details[$i]['costofConstruction']['comment']!="")
                                                                                    <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                        <div class="ans">
                                                                                            <span id="div_costofConstruction_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                data-content="<input id='costofConstruction_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['costofConstruction']['isAgree']}}'>
                                                                                                <label class='error' id='costofConstruction_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='costofConstruction' onclick='fun(this)'>Update</button>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='costofConstruction' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                data-container="body">{{@$insures_details[$i]['costofConstruction']['isAgree']}}
                                                                                            </span>
                                                                                            
                                                                                            <div class="post_comments">
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <div class="media">
                                                                                                            <div class="media-body">
                                                                                                                <span  class="comment_txt">{{$insures_details[$i]['costofConstruction']['comment']}}</span>        
                                                                                                            </div>
                                                                                                            <div class="media-right">
                                                                                                                    <span id="cancel_costofConstruction_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                    data-content="<input id='costofConstruction_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['costofConstruction']['comment']}}'>
                                                                                                <label class='error' id='costofConstruction_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='costofConstruction' onclick='commentEdit(this)'>Update</button>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='costofConstruction' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
                                                                                                                                                                                        data-container="body">
                                                                                                                    <button type="button">
                                                                                                                            <i class="material-icons">edit</i>
                                                                                                                        </button>
                                                                                                                </span>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                        </div>
                                                                                    </td>
                                                                            @else
                                                                                    <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                                        <div class="ans">
                                                                                        <span id="div_costofConstruction_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                            title="Edit existing value" data-html="true" data-content="<input id='costofConstruction_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['costofConstruction']['isAgree']}}'>
                                                                                        <label class='error' id='costofConstruction_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='costofConstruction' onclick='fun(this)'>Update</button>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='costofConstruction' onclick='cancel(this)'>
                                                                                        <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['costofConstruction']['isAgree']}}</span></div></td>
                                                                            @endif
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                                        @endif
        
                                                                    @else
                                                                        <td>  <div class="ans">--</div></td>
                                                                    @endif
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
                                                    @if(isset($pipeline_details['formData']['ContingentExpense']) && $pipeline_details['formData']['ContingentExpense'] == true)
                                                        <tr>
                                                            <?php $insure_count=count(@$insures_details);?>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
                                                                        @if(isset($insures_details[$i]['ContingentExpense']['isAgree']))
                                                                            @if(@$insures_details[$i]['ContingentExpense']['comment']!="")
                                                                                <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                    <div class="ans">
                                                                                        <span id="div_ContingentExpense_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                            data-content="<input id='ContingentExpense_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['ContingentExpense']['isAgree']}}'>
                                                                                            <label class='error' id='ContingentExpense_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='ContingentExpense' onclick='fun(this)'>Update</button>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='ContingentExpense' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                            data-container="body">{{@$insures_details[$i]['ContingentExpense']['isAgree']}}
                                                                                        </span>
                                                                                       
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['ContingentExpense']['comment']}}</span>        
                                                                                                        </div>
                                                                                                        <div class="media-right">
                                                                                                                <span id="cancel_ContingentExpense_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                                data-content="<input id='ContingentExpense_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['ContingentExpense']['comment']}}'>
                                                                                                            <label class='error' id='ContingentExpense_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                            </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='ContingentExpense' onclick='commentEdit(this)'>Update</button>
                                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='ContingentExpense' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
                                                                                                                                                                                                    data-container="body">
                                                                                                                <button type="button">
                                                                                                                        <i class="material-icons">edit</i>
                                                                                                                    </button>
                                                                                                            </span>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>
                                                                                </td>
                                                                        @else
                                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                                    <div class="ans">
                                                                                    <span id="div_ContingentExpense_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                        title="Edit existing value" data-html="true" data-content="<input id='ContingentExpense_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['ContingentExpense']['isAgree']}}'>
                                                                                    <label class='error' id='ContingentExpense_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='ContingentExpense' onclick='fun(this)'>Update</button>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='ContingentExpense' onclick='cancel(this)'>
                                                                                    <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['ContingentExpense']['isAgree']}}</span></div></td>
                                                                        @endif
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                                        @endif
        
                                                                    @else
                                                                        <td>  <div class="ans">--</div></td>
                                                                    @endif
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
                                                    @if(isset($pipeline_details['formData']['interuption']) && $pipeline_details['formData']['interuption'] == true)
                                                        <tr>
                                                            <?php $insure_count=count(@$insures_details);?>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
                                                                        @if(isset($insures_details[$i]['interuption']['isAgree']))
                                                                            @if(@$insures_details[$i]['interuption']['comment']!="")
                                                                                <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                    <div class="ans">
                                                                                        <span id="div_interuption_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                            data-content="<input id='interuption_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['interuption']['isAgree']}}'>
                                                                                            <label class='error' id='interuption_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='interuption' onclick='fun(this)'>Update</button>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='interuption' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                            data-container="body">{{@$insures_details[$i]['interuption']['isAgree']}}
                                                                                        </span>
                                                                                        
                                                                                            <div class="post_comments">
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <div class="media">
                                                                                                            <div class="media-body">
                                                                                                                <span  class="comment_txt">{{$insures_details[$i]['interuption']['comment']}}</span>        
                                                                                                            </div>
                                                                                                            <div class="media-right">
                                                                                                                    <span id="cancel_interuption_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                                    data-content="<input id='interuption_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['interuption']['comment']}}'>
                                                                                                                <label class='error' id='interuption_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                                </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='interuption' onclick='commentEdit(this)'>Update</button>
                                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='interuption' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
                                                                                                                                                                                                        data-container="body">
                                                                                                                    <button type="button">
                                                                                                                            <i class="material-icons">edit</i>
                                                                                                                    </button>
                                                                                                                </span>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                    </div>
                                                                                </td>
                                                                        @else
                                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                                    <div class="ans">
                                                                                    <span id="div_interuption_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                        title="Edit existing value" data-html="true" data-content="<input id='interuption_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['interuption']['isAgree']}}'>
                                                                                    <label class='error' id='interuption_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='interuption' onclick='fun(this)'>Update</button>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='interuption' onclick='cancel(this)'>
                                                                                    <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['interuption']['isAgree']}}</span></div></td>
                                                                        @endif
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                                        @endif
        
                                                                    @else
                                                                        <td>  <div class="ans">--</div></td>
                                                                    @endif
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
                                                    @if(isset($pipeline_details['formData']['Royalties']) && $pipeline_details['formData']['Royalties']== true)      
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
                                                                        <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                            <div class="ans">
                                                                                <span id='div_Royalties_{{$insures_details[$i]['uniqueToken']}}'
                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
                                                                                    <input id='Royalties_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['Royalties']?:'--'}}' required>
                                                                                    <label class='error' id='Royalties_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='Royalties' onclick='fun(this)'>Update</button>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='Royalties' onclick='cancel(this)'>
                                                                                    <i class='material-icons'>close</i></button>"
                                                                                    data-container="body">{{$insures_details[$i]['Royalties']?:'--'}}
                                                                                </span>
                                                                            </div>
                                                                        </td>
                                                                    @else
                                                                        <td>  <div class="ans">--</div></td>
                                                                    @endif
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
                                                    @if(isset($pipeline_details['formData']['deductible']) && $pipeline_details['formData']['deductible']!= '')     
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
                                                                        <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                            <div class="ans">
                                                                                <span id='div_deductible_{{$insures_details[$i]['uniqueToken']}}'
                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
                                                                                    <input id='deductible_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['deductible']?:'--'}}' required>
                                                                                    <label class='error' id='deductible_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='deductible' onclick='fun(this)'>Update</button>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='deductible' onclick='cancel(this)'>
                                                                                    <i class='material-icons'>close</i></button>"
                                                                                    data-container="body">{{number_format($insures_details[$i]['deductible'],2)?:'--'}}
                                                                                </span>
                                                                            </div>
                                                                        </td>
                                                                    @else
                                                                        <td>  <div class="ans">--</div></td>
                                                                    @endif
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
                                                    @if(isset($pipeline_details['formData']['ratep']) && $pipeline_details['formData']['ratep']!= '')     
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
                                                                        <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                            <div class="ans">
                                                                                <span id='div_ratep_{{$insures_details[$i]['uniqueToken']}}'
                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
                                                                                    <input id='ratep_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['ratep']?:'--'}}' required>
                                                                                    <label class='error' id='ratep_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='ratep' onclick='fun(this)'>Update</button>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='ratep' onclick='cancel(this)'>
                                                                                    <i class='material-icons'>close</i></button>"
                                                                                    data-container="body">{{number_format($insures_details[$i]['ratep'],2)?:'--'}}
                                                                                </span>
                                                                            </div>
                                                                        </td>
                                                                    @else
                                                                        <td>  <div class="ans">--</div></td>
                                                                    @endif
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
                                                    @if(isset($pipeline_details['formData']['spec_condition']) && $pipeline_details['formData']['spec_condition']!= '')     
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
                                                                        <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                            <div class="ans">
                                                                                <span id='div_spec_condition_{{$insures_details[$i]['uniqueToken']}}'
                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
                                                                                    <input id='spec_condition_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['spec_condition']?:'--'}}' required>
                                                                                    <label class='error' id='spec_condition_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='spec_condition' onclick='fun(this)'>Update</button>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='spec_condition' onclick='cancel(this)'>
                                                                                    <i class='material-icons'>close</i></button>"
                                                                                    data-container="body">{{number_format($insures_details[$i]['spec_condition'],2)?:'--'}}
                                                                                </span>
                                                                            </div>
                                                                        </td>
                                                                    @else
                                                                        <td>  <div class="ans">--</div></td>
                                                                    @endif
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
                                                    @if(isset($pipeline_details['formData']['warranty']) && $pipeline_details['formData']['warranty']!= '')     
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
                                                                        <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                            <div class="ans">
                                                                                <span id='div_warranty_{{$insures_details[$i]['uniqueToken']}}'
                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
                                                                                    <input id='warranty_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['warranty']?:'--'}}' required>
                                                                                    <label class='error' id='warranty_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='warranty' onclick='fun(this)'>Update</button>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='warranty' onclick='cancel(this)'>
                                                                                    <i class='material-icons'>close</i></button>"
                                                                                    data-container="body">{{number_format($insures_details[$i]['warranty'],2)?:'--'}}
                                                                                </span>
                                                                            </div>
                                                                        </td>
                                                                    @else
                                                                        <td>  <div class="ans">--</div></td>
                                                                    @endif
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
                                                    @if(isset($pipeline_details['formData']['brokerage']) && $pipeline_details['formData']['brokerage']!= '')     
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
                                                                        <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                            <div class="ans">
                                                                                <span id='div_brokerage_{{$insures_details[$i]['uniqueToken']}}'
                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
                                                                                    <input id='brokerage_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['brokerage']?:'--'}}' required>
                                                                                    <label class='error' id='brokerage_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='brokerage' onclick='fun(this)'>Update</button>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='brokerage' onclick='cancel(this)'>
                                                                                    <i class='material-icons'>close</i></button>"
                                                                                    data-container="body">{{number_format($insures_details[$i]['brokerage'],2)?:'--'}}
                                                                                </span>
                                                                            </div>
                                                                        </td>
                                                                    @else
                                                                        <td>  <div class="ans">--</div></td>
                                                                    @endif
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
                                                    @if(isset($pipeline_details['formData']['exclusion']) && $pipeline_details['formData']['exclusion']!= '')     
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
                                                                        <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                            <div class="ans">
                                                                                <span id='div_exclusion_{{$insures_details[$i]['uniqueToken']}}'
                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
                                                                                    <input id='exclusion_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['exclusion']?:'--'}}' required>
                                                                                    <label class='error' id='exclusion_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='exclusion' onclick='fun(this)'>Update</button>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='exclusion' onclick='cancel(this)'>
                                                                                    <i class='material-icons'>close</i></button>"
                                                                                    data-container="body">{{number_format($insures_details[$i]['exclusion'],2)?:'--'}}
                                                                                </span>
                                                                            </div>
                                                                        </td>
                                                                    @else
                                                                        <td>  <div class="ans">--</div></td>
                                                                    @endif
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
                                                    {{-- <tr>
                                                    </tr> --}}
                                                    @if($pipeline_details['status']['status'] == 'E-slip' || $pipeline_details['status']['status']=='E-quotation' || $pipeline_details['status']['status']=='E-comparison' || $pipeline_details['status']['status']=='Quote Amendment'|| $pipeline_details['status']['status']=='Quote Amendment-E-quotation')
        
                                                        <tr >
                                                            <?php $insure_count=count(@$insures_details);?>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans"><button class="btn pink_btn upload_excel auto_modal" data-modal="upload_excel" onclick="get_excel_id('{{$insures_id[$i]}}','{{$pipeline_details->_id}}')"><i class="material-icons">cloud_upload</i> Upload Excel</button></div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
                                                                        <td><div class="ans"></div></td>
                                                                    @else
                                                                        <?php $i_cont=$i-$insure_count; ?>
                                                                        <td><div class="ans"><button class="btn pink_btn upload_excel auto_modal" data-modal="upload_excel" onclick="get_excel_id('{{$insures_id[$i_cont]}}','{{$pipeline_details->_id}}')" ><i class="material-icons">cloud_upload</i> Upload Excel</button></div></td>
                                                                    @endif
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
                                                </tbody>
                                             </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($insure_count!=0)
                        <button class="btn btn-primary btn_action pull-right" id="button_submit" type="submit" @if($pipeline_details['status']['status']=='Approved E Quote' || $pipeline_details['status']['status']=='Issuance') style="display: none" @endif>Proceed</button>
                        @if(@$pipeline_details['status']['status']!='Approved E Quote')
                            <button type = "button" class="btn blue_btn pull-right btn_action" onclick="saveQuotation()">Save as Draft</button>
                        @endif
                    @endif
                </form>
                {{--@else--}}
                {{--No Data--}}
                {{--@endif--}}
            </div>
        </div>

    </div>
    <!-- Popup -->
    <div id="upload_excel">
        <div class="cd-popup">
            <div class="cd-popup-container">
                <div class="modal_content">
                    <div class="clearfix">
                        <h1>Upload Excel</h1>
                    </div>
                    <form id="upload_excel_form" name="upload_excel_form" method="post">
                        {{csrf_field()}}
                        <div class="upload_sec">
                            <input type="hidden" id="pipelinedetails_id" name="pipelinedetails_id">
                            <input type="hidden" id="insurer_id" name="insurer_id">
                            <div class="custom_upload">
                                <input type="file" name="import_excel_file" id="import_excel_file" >
                                <p>Drag your files or click here.</p>
                            </div>
                            <label style="float: left" class="error" id="error-label"></label>
                        </div>
                        <div class="modal_footer">
                            <button class="btn btn-primary btn-link btn_cancel" id="upload_excel_cancel" type="button">Cancel</button>
                            <button type="submit" id="upload_excel" class="btn btn-primary btn_action">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('includes.chat')
    @include('includes.mail_popup')
@endsection

{{--<style>--}}
{{--.material-table{--}}
{{--position: relative;--}}
{{--}--}}
{{--.main_question,.main_answer{--}}
{{--position: absolute;--}}
{{--}--}}
{{--.main_answer{--}}
{{--left: 300px;--}}
{{--}--}}
{{--</style>--}}



@push('scripts')

    <!--jquery validate-->
    <script src="{{URL::asset('js/main/jquery.validate.js')}}"></script>
    <script src="{{URL::asset('js/main/additional-methods.min.js')}}"></script>
    {{--    <script src="{{URL::asset('js/jquery.CongelarFilaColumna.?js')}}"></script>--}}
    <!-- table fix -->
    {{--    <link rel="stylesheet" href="{{ URL::asset('css/ScrollTabla.css')}}" />--}}
    {{--<script type="text/javascript">--}}
    {{--$(document).ready(function(){--}}
    {{--$("#pruebatabla").CongelarFilaColumna({lboHoverTr:true});--}}
    {{--});--}}
    {{--</script>--}}
    <script>

        function get_excel_id(insurer_id,pipeline_id)
        {
            $('#pipelinedetails_id').val(pipeline_id);
            $('#insurer_id').val(insurer_id);
        }

        $("#upload_excel_form").validate({
            ignore: [],
            rules: {
                import_excel_file: {
                    required: true,
                    accept: "application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                }
            },
            messages: {
                import_excel_file: "Please upload a valid excel file."
            },
            errorPlacement: function(error, element){
                if(element.attr("name") == "import_excel_file" ){
                    error.insertAfter(element.parent());
                }
            },
            submitHandler: function (form, event) {
                var form_data = new FormData($("#upload_excel_form")[0]);
                var excel = $('#import_excel_file').prop('files')[0];
                $('#preLoader').show();
                $("#upload_excel").attr( "disabled", true );
                form_data.append('file', excel);
                form_data.append('_token', '{{csrf_token()}}');
                $.ajax({
                    url: '{{url('save-temporary')}}',
                    data: form_data,
                    method: 'post',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (result) {
                        if (result == 1) {
                            window.location.href = "{{url('business_interruption/imported-list')}}";
                        }
                        else if(result.length> 1){
                            $("#upload_excel").attr( "disabled", false );

                            $('#preLoader').hide();
                            $('#error-label').html('The file you uploaded is not a Quotation');
                            $('#error-label').show();
                        }
                        else if(result == 0)
                        {
                            $("#upload_excel").attr( "disabled", false );
                            $('#preLoader').hide();
                            $('#error-label').html('The file you uploaded is not a Quotation');
                            $('#error-label').show();
                        }
                        {{--else {--}}
                        {{--alert('something went wrong');--}}
                        {{--}--}}
                    }
                });
            }
        });

        //add customer form validation//
        $("#e_quat_form").validate({

            ignore: [],
            rules: {
                'insure_check[]': {
                    required: true
                }
            },
            messages: {
                'insure_check[]': "Please select one of insurer."
            },

            errorPlacement: function (error, element) {
                // console.log('sdfsdfdf');
                error.insertBefore(element.parent().parent().parent().parent());
            },
            submitHandler: function (form,event) {
                var form_data = new FormData($("#e_quat_form")[0]);
                form_data.append('_token', '{{csrf_token()}}');
                $('#preLoader').show();
                $("#button_submit").attr( "disabled", "disabled" );
                $.ajax({
                    method: 'post',
                    url: '{{url('business_interruption/save-selected-insurers')}}',
                    data: form_data,
                    cache : false,
                    contentType: false,
                    processData: false,
                    success: function (result) {
                        if (result== 'success') {
                            window.location.href = '{{url('business_interruption/e-comparison/'.$pipeline_details->_id)}}';
                        }
                    }
                });
            }
        });
        //end//

        function color_change_table(col_name)
        {

            var result = col_name.split('_');
            var checkbox_val=document.getElementById(col_name).value;
            if(checkbox_val=="hide")
            {
                var all_col=document.getElementsByClassName(col_name);
                for(var i=0;i<all_col.length;i++)
                {
                    all_col[i].style.background="#C8CDE3";
                }
                document.getElementById(col_name).value=result[2];
//                document.getElementById(col_name+"_head").style.background="#F00";

            }

            else
            {
                var all_col=document.getElementsByClassName(col_name);
                for(var i=0;i<all_col.length;i++)
                {
                    all_col[i].style.background="#fff";
                }
                document.getElementById(col_name).value="hide";
//                document.getElementById(col_name+"_head").style.background="#fff";

            }
        }
    </script>
    <style>
        label.error {
            float:right;
        }
        #demodocs-error {
            float:left;
        }
        #import_excel_file-error{
            display: block;
            float: left;
            margin: 6px 0;
        }
        .section_details{
            max-width: 100%;
        }

        thead label.error {
            position: fixed;
            z-index: 9;
            background: #e01c1c;
            margin: -34px 0 0;
            color: #ffffff;
            padding: 8px 15px;
        }
        thead label.error:after {
            top: 100%;
            left: 0;
            border: solid transparent;
            content: " ";
            height: 0;
            width: 0;
            position: absolute;
            pointer-events: none;
            border-color: rgba(136, 183, 213, 0);
            border-top-color: #e01c1c;
            border-width: 6px;
            margin-left: 5px;
        }

    </style>
    <script>
        $(document).ready(function () {

            $('thead .error').addClass('sdfsdfsdf');

            var selected = $('#selected_insurers').val();
            if(selected != 'empty')
            {
                var values = JSON.parse(selected);
                $.each(values , function (index , value) {
                    var col_name ='insure_check_'+value;
                    color_change_table(col_name);
                    $('#'+col_name).prop('checked',true);
                })
            }
            setTimeout(function() {
                $('#success_excel').fadeOut('fast');
            }, 5000);
            $('form input').change(function () {
                var fullPath = $('#import_excel_file').val();
                var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
                var filename = fullPath.substring(startIndex);
                if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
                    filename = filename.substring(1);
                }
//            console.log(filename);
                $('.custom_upload p').text(filename);
            });


        });
        function fun(obj) {
            var token = obj.name;
            var field = obj.value;
            var new_quot = $('#'+field+'_'+token+'').val();
            var id = $('#pipeline_id').val();
            if(new_quot!="")
            {
                $('#preLoader').show();
                $.ajax({
                    method: 'post',
                    url: '{{url('business_interruption/quot-amend')}}',
                    data: {
                        token:token,
                        field:field,
                        new_quot:new_quot,
                        id:id,
                        _token: '{{csrf_token()}}'
                    },
                    success:function(data){
                        if(data == 'success')
                        {
                            location.reload();
                        }else{
                            $('#preLoader').hide();
                            $('#'+field+'_'+token+'-error').html('Please enter numerical value');
                            // console.log($('#'+field+'_'+token+'-error'));
                        }
                    }
                });
            }
            else{
                $('#'+field+'_'+token+'-error').html('Please enter a valid data');
            }
        }
        function cancel(obj) {
            var token = obj.name;
            var field = obj.value;
            $('#div_'+field+'_'+token+'').popover('hide');

        }
        
        function commentEdit(obj)
        {
            var token = obj.name;
            var field = obj.value;
            var new_quot = $('#'+field+'_comment_'+token+'').val();
            var id = $('#pipeline_id').val();
            if(new_quot!="")
            {
                $('#preLoader').show();
                $.ajax({
                    method: 'post',
                    url: '{{url('business_interruption/quot-amend')}}',
                    data: {
                        token:token,
                        field:field,
                        new_quot:new_quot,
                        id:id,
                        comment:"comment",
                        _token: '{{csrf_token()}}'
                    },
                    success:function(data){
                        if(data == 'success')
                        {
// $('#div_'+field+'_'+token+'').popover('hide');
// $('#div_'+field+'_'+token+'').html(new_quot);
                            location.reload();
                        }
                    }
                });
            }
            else{
                $('#'+field+'_'+token+'-error').html('Please enter a valid data');
            }
        }
        function commentCancel(obj)
        {
            var token = obj.name;
            var field = obj.value;
            $('#cancel_'+field+'_'+token+'').popover('hide');
        }
    </script>

    <script>
        function resizeHandler() {
// Treat each container separately
            $(".height_fix").each(function(i, height_fix) {
// Stores the highest rowheight for all tables in this container, per row
                var aRowHeights = [];
// Loop through the tables
                $(height_fix).find("table").each(function(indx, table) {
// Loop through the rows of current table
                    $(table).find("tr").css("height", "").each(function(i, tr) {
// If there is already a row height defined
                        if (aRowHeights[i])
// Replace value with height of current row if current row is higher.
                            aRowHeights[i] = Math.max(aRowHeights[i], $(tr).height());
                        else
// Else set it to the height of the current row
                            aRowHeights[i] = $(tr).height();
                    });
                });
// Loop through the tables in this container separately again
                $(height_fix).find("table").each(function(i, table) {
// Set the height of each row to the stored greatest height.
                    $(table).find("tr").each(function(i, tr) {
                        $(tr).css("height", aRowHeights[i]);
                    });
                });
            });
        }
        $( "#upload_excel_cancel" ).click(function() {
            $('#error-label').hide();
            $('#import_excel_file').val('');
            $('#import_excel_file-error').hide();
            $('.custom_upload p').text('Drag your files or click here.');
        });
        $(document).ready(resizeHandler);
        $(window).resize(resizeHandler);

        $(function(){
            var rows = $('.material-table tbody tr');

            rows.hover(function(){
                var i = $(this).GetIndex() + 1;
                rows.filter(':nth-child(' + i + ')').addClass('hoverx');
            },function(){
                rows.removeClass('hoverx');
            });
        });

        jQuery.fn.GetIndex = function(){
            return $(this).parent().children().index($(this));
        }
        function saveQuotation()
        {
            $('#preLoader').show();
            var form_data = new FormData($("#e_quat_form")[0]);
            form_data.append('_token', '{{csrf_token()}}');
            form_data.append('is_save','true');
            $.ajax({
                method: 'post',
                url: '{{url('business_interruption/save-selected-insurers')}}',
                data: form_data,
                cache : false,
                contentType: false,
                processData: false,
                success: function (result) {
                    $('#preLoader').hide();
                    if (result== 'success') {
                        $('#success_message').html('E-Quotation is saved as draft.');
                        $('#success_popup .cd-popup').addClass('is-visible');
                    }
                    else
                    {
                        $('#success_message').html('E-Quotation saving failed.');
                        $('#success_popup .cd-popup').addClass('is-visible');
                    }
                }
            });
        }
    </script>

    <script src="{{URL::asset('js/syncscroll.js')}}"></script>
@endpush
