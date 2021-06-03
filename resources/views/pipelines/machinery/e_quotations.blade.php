
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
            <h3 class="title" style="margin-bottom: 8px;">Machinery Breakdown</h3>
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
                            <li class="complete"><a href="{{url('Machinery-Breakdown/e-questionnaire/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Questionnaire</em></a></li>
                            <li class="complete"><a href="{{url('Machinery-Breakdown/e-slip/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>
                            @if($pipeline_details['status']['status'] == 'E-quotation')
                                <li class="current"><a href="{{url('Machinery-Breakdown/e-quotation/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                                <li><em>E-Comparison</em></li>
                                <li><em>Quote Amendment</em></li>
                                <li><em>Approved E Quote</em></li>
                                {{--<li><em>Issuance</em></li>--}}
                            @elseif($pipeline_details['status']['status'] == 'E-comparison')
                                <li class="active_arrow"><a href="{{url('Machinery-Breakdown/e-quotation/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                                <li class="current"><a href="{{url('Machinery-Breakdown/e-comparison/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                                <li><em>Quote Amendment</em></li>
                                <li><em>Approved E Quote</em></li>
                                {{--<li><em>Issuance</em></li>--}}
                            @elseif($pipeline_details['status']['status'] == 'Quote Amendment')
                                <li class="active_arrow"><a href="{{url('Machinery-Breakdown/e-quotation/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                                <li class="complete"><a href="{{url('Machinery-Breakdown/e-comparison/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                                <li class="current"><a href="{{url('Machinery-Breakdown/quot-amendment/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>
                                <li><em>Approved E Quote</em></li>
                                {{--<li><em>Issuance</em></li>--}}
                            @elseif($pipeline_details['status']['status'] == 'Approved E Quote')
                                <li class="active_arrow"><a href="{{url('Machinery-Breakdown/e-quotation/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                                <li class="complete"><a href="{{url('Machinery-Breakdown/e-comparison/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                                <li class="complete"><a href="{{url('Machinery-Breakdown/quot-amendment/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>
                                <li class="current"><a href="{{url('Machinery-Breakdown/approved-quot/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Approved E Quote</em></a></li>
                                {{--<li><em>Issuance</em></li>--}}
                            @elseif($pipeline_details['status']['status'] == 'Quote Amendment-E-comparison' || $pipeline_details['status']['status'] == 'Quote Amendment-E-quotation' || $pipeline_details['status']['status'] == 'Quote Amendment-E-slip')
                                <li class="active_arrow"><a href="{{url('Machinery-Breakdown/e-quotation/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                                <li class="complete"><a href="{{url('Machinery-Breakdown/e-comparison/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                                <li class="current"><a href="{{url('Machinery-Breakdown/quot-amendment/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>
                                <li><em>Approved E Quote</em></li>
                                {{--@elseif($pipeline_details['status']['status'] == 'Issuance')--}}
                                {{--<li class="complete"><a href="{{url('e-quotation/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>--}}
                                {{--<li class="complete"><a href="{{url('e-comparison/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>--}}
                                {{--<li class="complete"><a href="{{url('quot-amendment/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>--}}
                                {{--<li class="complete"><a href="{{url('approved-quot/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Approved E Quote</em></a></li>--}}
                                {{--<li class="current"><a href="{{url('issuance/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Issuance</em></a></li>--}}
                            @else
                                <li class="current"><a href="{{url('Machinery-Breakdown/e-quotation/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
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
                                               
                                                @if(isset($pipeline_details['formData']['localclause']) && $pipeline_details['formData']['localclause'] == true)
                                                    <tr>   
                                                        <td><div class="main_question"><label class="form_label bold">Local Jurisdiction Clause</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif
                                                @if(isset($pipeline_details['formData']['express']) && $pipeline_details['formData']['express'] == true)

                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Overtime, night works and express freight</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif
                                                @if(isset($pipeline_details['formData']['airfreight']) && $pipeline_details['formData']['airfreight'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Airfreight</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>

                                                    </tr>
                                                @endif
                                                @if(isset($pipeline_details['formData']['addpremium']) && $pipeline_details['formData']['addpremium'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Automatic Reinstatement of sum insured at pro rata additional premium</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif
                                                @if(isset($pipeline_details['formData']['payAccount']) && $pipeline_details['formData']['payAccount']==true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Payment on account clause</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif
                                                @if(isset($pipeline_details['formData']['primaryclause']) && $pipeline_details['formData']['primaryclause'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Primary Insurance clause</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif
                                                @if(isset($pipeline_details['formData']['premiumClaim']) && $pipeline_details['formData']['premiumClaim'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Cancellation – 60 days notice by either party subject to pro-rata refund of premium unless a claim has attached</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif
                                                @if(isset($pipeline_details['formData']['lossnotification']) && $pipeline_details['formData']['lossnotification'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Loss Notification – ‘as soon as reasonably practicable’</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif
                                                @if(isset($pipeline_details['formData']['adjustmentPremium']) && $pipeline_details['formData']['adjustmentPremium'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Adjustment of sum insured and premium (Mre-410)</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif
                                                @if(isset($pipeline_details['formData']['temporaryclause']) && $pipeline_details['formData']['temporaryclause'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Temporary repairs clause</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif
                                                @if(isset($pipeline_details['formData']['automaticClause']) && $pipeline_details['formData']['automaticClause'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Automatic addition clause</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif
                                                @if(isset($pipeline_details['formData']['capitalclause']) && $pipeline_details['formData']['capitalclause'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Capital addition clause</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif
                                                @if(isset($pipeline_details['formData']['debris']) && $pipeline_details['formData']['debris'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Removal of debris</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif
                                                @if(isset($pipeline_details['formData']['property']) && $pipeline_details['formData']['property'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Designation of property</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif
                                                @if(isset($pipeline_details['formData']['errorclause']) && $pipeline_details['formData']['errorclause'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Errors and omission clause</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif
                                                @if(@$pipeline_details['formData']['aff_company']!='' && isset($pipeline_details['formData']['waiver']) && $pipeline_details['formData']['waiver'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Waiver of subrogation</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif
                                                @if(isset($pipeline_details['formData']['claimclause']) && $pipeline_details['formData']['claimclause'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Claims preparation clause</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif
                                                @if(isset($pipeline_details['formData']['Innocent']) && $pipeline_details['formData']['Innocent'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Innocent non-disclosure</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif
                                                @if(isset($pipeline_details['formData']['Noninvalidation']) && $pipeline_details['formData']['Noninvalidation'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Non-invalidation clause</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif
                                                @if(isset($pipeline_details['formData']['brokerclaim']) && $pipeline_details['formData']['brokerclaim'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Brokers Claim Handling Clause : A loss notification received by the Insurance Broker will be deemed as a loss notification to Insurer. All communications flowing between the Insurer, Insured and the appointed Loss Surveyor should be channelized through the Broker, unless there is any unavoidable reasons compelling direct communications between the parties</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif
                                                {{-- @if(isset($pipeline_details['formData']['deductm']) && $pipeline_details['formData']['deductm']!= '') --}}
                                                    <tr>   
                                                        <td><div class="main_question"><label class="form_label bold">Deductible for (Machinary Breakdown):  </label></div></td>
                                                        {{-- <td class="main_answer"><div class="ans">{{number_format($pipeline_details['formData']['deductm'],2)}}</div></td> --}}
                                                        <td class="main_answer"><div class="ans">--</div></td>
                                                    </tr>
                                                {{-- @endif
                                                @if(isset($pipeline_details['formData']['ratem']) && $pipeline_details['formData']['ratem']!= '') --}}
                                                    <tr>   
                                                        <td><div class="main_question"><label class="form_label bold">Rate required (Machinary Breakdown):</label></div></td>
                                                        {{-- <td class="main_answer"><div class="ans">{{number_format($pipeline_details['formData']['ratem'],2)}}</div></td> --}}
                                                        <td class="main_answer"><div class="ans">--</div></td>
                                                    </tr>
                                                {{-- @endif
                                                @if(isset($pipeline_details['formData']['premiumm']) && $pipeline_details['formData']['premiumm']!= '') --}}
                                                    <tr>   
                                                        <td><div class="main_question"><label class="form_label bold">Premium required (Machinary Breakdown): </label></div></td>
                                                        {{-- <td class="main_answer"><div class="ans">{{number_format($pipeline_details['formData']['premiumm'],2)}}</div></td> --}}
                                                        <td class="main_answer"><div class="ans">--</div></td>
                                                    </tr>
                                                {{-- @endif
                                                    @if(isset($pipeline_details['formData']['brokeragem']) && $pipeline_details['formData']['brokeragem']!= '') --}}
                                                    <tr>   
                                                        <td><div class="main_question"><label class="form_label bold">Brokerage (Machinary Breakdown) :</label></div></td>
                                                        {{-- <td class="main_answer"><div class="ans">{{number_format($pipeline_details['formData']['brokeragem'],2)}}</div></td> --}}
                                                        <td class="main_answer"><div class="ans">--</div></td>
                                                    </tr>
                                                {{-- @endif
                                                @if(isset($pipeline_details['formData']['warrantym']) && $pipeline_details['formData']['warrantym']!= '') --}}
                                                    <tr>   
                                                        <td><div class="main_question"><label class="form_label bold">Warranty (Machinary Breakdown):</label></div></td>
                                                        <td class="main_answer"><div class="ans">--</div></td>
                                                        {{-- <td class="main_answer"><div class="ans">{{number_format($pipeline_details['formData']['warrantym'],2)}}</div></td> --}}
                                                    </tr>
                                                {{-- @endif
                                                @if(isset($pipeline_details['formData']['exclusionm']) && $pipeline_details['formData']['exclusionm']!= '') --}}
                                                    <tr>   
                                                        <td><div class="main_question"><label class="form_label bold">Exclusion (Machinary Breakdown):</label></div></td>
                                                        <td class="main_answer"><div class="ans">--</div></td>
                                                        {{-- <td class="main_answer"><div class="ans">{{number_format($pipeline_details['formData']['exclusionm'],2)}}</div></td> --}}
                                                    </tr>
                                                {{-- @endif                                                
                                                @if(isset($pipeline_details['formData']['specialm']) && $pipeline_details['formData']['specialm']!= '') --}}
                                                    <tr>   
                                                        <td><div class="main_question"><label class="form_label bold">Special Condition (Machinary Breakdown):</label></div></td>
                                                        <td class="main_answer"><div class="ans">--</div></td>
                                                        {{-- <td class="main_answer"><div class="ans">{{number_format($pipeline_details['formData']['specialm'],2)}}</div></td> --}}
                                                    </tr>
                                                {{-- @endif
                                                @if(isset($pipeline_details['formData']['deductb']) && $pipeline_details['formData']['deductb']!= '') --}}
                                                    <tr>   
                                                        <td><div class="main_question"><label class="form_label bold">Deductible for (Business Interruption): </label></div></td>
                                                        <td class="main_answer"><div class="ans">--</div></td>
                                                        {{-- <td class="main_answer"><div class="ans">{{number_format($pipeline_details['formData']['deductb'],2)}}</div></td> --}}
                                                    </tr>
                                                {{-- @endif
                                                @if(isset($pipeline_details['formData']['rateb']) && $pipeline_details['formData']['rateb']!= '') --}}
                                                    <tr>   
                                                        <td><div class="main_question"><label class="form_label bold">Rate required (Business Interruption):</label></div></td>
                                                        <td class="main_answer"><div class="ans">--</div></td>
                                                        {{-- <td class="main_answer"><div class="ans">{{number_format($pipeline_details['formData']['rateb'],2)}}</div></td> --}}
                                                    </tr>
                                                {{-- @endif
                                                @if(isset($pipeline_details['formData']['premiumb']) && $pipeline_details['formData']['premiumb']!= '') --}}
                                                    <tr>   
                                                        <td><div class="main_question"><label class="form_label bold">Premium required(Business Interruption):</label></div></td>
                                                        <td class="main_answer"><div class="ans">--</div></td>
                                                        {{-- <td class="main_answer"><div class="ans">{{number_format($pipeline_details['formData']['premiumb'],2)}}</div></td> --}}
                                                    </tr>
                                                {{-- @endif --}}
                                                {{-- @if(isset($pipeline_details['formData']['brokerageb']) && $pipeline_details['formData']['brokerageb']!= '') --}} 
                                                    <tr>   
                                                        <td><div class="main_question"><label class="form_label bold">Brokerage (Business Interruption):</label></div></td>
                                                        {{-- <td class="main_answer"><div class="ans">{{number_format($pipeline_details['formData']['brokerageb'],2)}}</div></td> --}}
                                                        <td class="main_answer"><div class="ans">--</div></td>
                                                    </tr>
                                                {{-- @endif
                                                {{-- @if(isset($pipeline_details['formData']['warrantyb']) && $pipeline_details['formData']['warrantyb']!= '') --}}
                                                    <tr>   
                                                        <td><div class="main_question"><label class="form_label bold">Warranty (Business Interruption):</label></div></td>
                                                        <td class="main_answer"><div class="ans">--</div></td>
                                                        {{-- <td class="main_answer"><div class="ans">{{number_format($pipeline_details['formData']['warrantyb'],2)}}</div></td> --}}
                                                    </tr>
                                                {{-- @endif --}}
                                                {{-- @if(isset($pipeline_details['formData']['exclusionb']) && $pipeline_details['formData']['exclusionb']!= '') --}}
                                                    <tr>   
                                                        <td><div class="main_question"><label class="form_label bold">Exclusion (Business Interruption):</label></div></td>
                                                        <td class="main_answer"><div class="ans">--</div></td>
                                                        {{-- <td class="main_answer"><div class="ans">{{number_format($pipeline_details['formData']['exclusionb'],2)}}</div></td> --}}
                                                    </tr>
                                                {{-- @endif --}}
                                                {{-- @if(isset($pipeline_details['formData']['specialb']) && $pipeline_details['formData']['specialb']!= '') --}}
                                                    <tr>   
                                                        <td><div class="main_question"><label class="form_label bold">Special Condition (Business Interruption): </label></div></td>
                                                        <td class="main_answer"><div class="ans">--</div></td>
                                                        {{-- <td class="main_answer"><div class="ans">{{number_format($pipeline_details['formData']['specialb'],2)}}</div></td> --}}
                                                    </tr>
                                                {{-- @endif --}}
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
                                                    @if(isset($pipeline_details['formData']['localclause']) && $pipeline_details['formData']['localclause'] == true)
                                                    <tr>
                                                        <?php $insure_count=count(@$insures_details);?>
                                                        @if($insure_count==0)
                                                            @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                <td>  <div class="ans">--</div></td>
                                                            @endfor
                                                        @else
                                                            @for ($i = 0; $i < $total_insure_count; $i++)
                                                                @if(array_key_exists($i,$insures_details))
                                                                    @if(isset($insures_details[$i]['localclause']['isAgree']))
                                                                            @if(@$insures_details[$i]['localclause']['comment']!="")
                                                                                <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                    <div class="ans">
                                                                                        <span id="div_localclause_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                            data-content="<input id='localclause_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['localclause']['isAgree']}}'>
                                                                                            <label class='error' id='localclause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='localclause' onclick='fun(this)'>Update</button>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='localclause' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                            data-container="body">{{@$insures_details[$i]['localclause']['isAgree']}}
                                                                                        </span>
                                                                                        
                                                                                                <div class="post_comments">
                                                                                                        <div class="post_comments_main clearfix">
                                                                                                            <div class="media">
                                                                                                                <div class="media-body">
                                                                                                                    <span  class="comment_txt">{{$insures_details[$i]['localclause']['comment']}}</span>        
                                                                                                                </div>
                                                                                                                <div class="media-right">
                                                                                                                        <span id="cancel_localclause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                                         data-content="<input id='localclause_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['localclause']['comment']}}'>
                                                                                                                         <label class='error' id='localclause_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                                         </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='localclause' onclick='commentEdit(this)'>Update</button>
                                                                                                                         <button name='{{$insures_details[$i]['uniqueToken']}}' value='localclause' onclick='commentCancel(this)'><i class='material-icons'>close</i></button" data-container="body">
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
                                                                                            <span id="div_localclause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                                title="Edit existing value" data-html="true" data-content="<input id='localclause_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['localclause']['isAgree']}}'>
                                                                                            <label class='error' id='localclause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='localclause' onclick='fun(this)'>Update</button>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='localclause' onclick='cancel(this)'>
                                                                                            <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['localclause']['isAgree']}}</span></div></td>
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
                                                    @if(isset($pipeline_details['formData']['express']) && $pipeline_details['formData']['express'] == true)
                                                        <tr>
                                                            <?php $insure_count=count(@$insures_details);?>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
                                                                        @if(isset($insures_details[$i]['express']['isAgree']))
                                                                                @if(@$insures_details[$i]['express']['comment']!="")
                                                                                    <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                        <div class="ans">
                                                                                            <span id="div_express_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                data-content="<input id='express_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['express']['isAgree']}}'>
                                                                                                <label class='error' id='express_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='express' onclick='fun(this)'>Update</button>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='express' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                data-container="body">{{@$insures_details[$i]['express']['isAgree']}}
                                                                                            </span>
                                                                                            
                                                                                                    <div class="post_comments">
                                                                                                            <div class="post_comments_main clearfix">
                                                                                                                <div class="media">
                                                                                                                    <div class="media-body">
                                                                                                                        <span  class="comment_txt">{{$insures_details[$i]['express']['comment']}}</span>        
                                                                                                                    </div>
                                                                                                                    <div class="media-right">
                                                                                                                            <span id="cancel_express_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                                             data-content="<input id='express_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['express']['comment']}}'>
                                                                                                                             <label class='error' id='express_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                                             </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='express' onclick='commentEdit(this)'>Update</button>
                                                                                                                             <button name='{{$insures_details[$i]['uniqueToken']}}' value='express' onclick='commentCancel(this)'><i class='material-icons'>close</i></button" data-container="body">
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
                                                                                                <span id="div_express_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                                    title="Edit existing value" data-html="true" data-content="<input id='express_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['express']['isAgree']}}'>
                                                                                                <label class='error' id='express_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='express' onclick='fun(this)'>Update</button>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='express' onclick='cancel(this)'>
                                                                                                <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['express']['isAgree']}}</span></div></td>
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
                                                    @if(isset($pipeline_details['formData']['airfreight']) && $pipeline_details['formData']['airfreight'] == true)
                                                            <tr>
                                                                <?php $insure_count=count(@$insures_details);?>
                                                                @if($insure_count==0)
                                                                    @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                        <td>  <div class="ans">--</div></td>
                                                                    @endfor
                                                                @else
                                                                    @for ($i = 0; $i < $total_insure_count; $i++)
                                                                        @if(array_key_exists($i,$insures_details))
                                                                            @if(isset($insures_details[$i]['airfreight']['isAgree']))
                                                                                    @if(@$insures_details[$i]['airfreight']['comment']!="")
                                                                                        <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                            <div class="ans">
                                                                                                <span id="div_airfreight_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                    data-content="<input id='airfreight_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['airfreight']['isAgree']}}'>
                                                                                                    <label class='error' id='airfreight_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='airfreight' onclick='fun(this)'>Update</button>
                                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='airfreight' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                    data-container="body">{{@$insures_details[$i]['airfreight']['isAgree']}}
                                                                                                </span>
                                                                                                
                                                                                                <div class="post_comments">
                                                                                                        <div class="post_comments_main clearfix">
                                                                                                            <div class="media">
                                                                                                                <div class="media-body">
                                                                                                                    <span  class="comment_txt">{{$insures_details[$i]['airfreight']['comment']}}</span>        
                                                                                                                </div>
                                                                                                                <div class="media-right">
                                                                                                                        <span id="cancel_airfreight_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                                        data-content="<input id='airfreight_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['airfreight']['comment']}}'>
                                                                                                                    <label class='error' id='airfreight_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                                    </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='airfreight' onclick='commentEdit(this)'>Update</button>
                                                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='airfreight' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
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
                                                                                                <span id="div_airfreight_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                                    title="Edit existing value" data-html="true" data-content="<input id='airfreight_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['airfreight']['isAgree']}}'>
                                                                                                <label class='error' id='airfreight_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='airfreight' onclick='fun(this)'>Update</button>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='airfreight' onclick='cancel(this)'>
                                                                                                <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['airfreight']['isAgree']}}</span></div></td>
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
                                                        @if(isset($pipeline_details['formData']['addpremium']) && $pipeline_details['formData']['addpremium'] == true)
                                                        <tr>
                                                            <?php $insure_count=count(@$insures_details);?>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
                                                                        @if(isset($insures_details[$i]['addpremium']['isAgree']))
                                                                                @if(@$insures_details[$i]['addpremium']['comment']!="")
                                                                                    <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                        <div class="ans">
                                                                                            <span id="div_addpremium_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                data-content="<input id='addpremium_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['addpremium']['isAgree']}}'>
                                                                                                <label class='error' id='addpremium{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='addpremium' onclick='fun(this)'>Update</button>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='addpremium' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                data-container="body">{{@$insures_details[$i]['addpremium']['isAgree']}}
                                                                                            </span>
                                                                                            
                                                                                                <div class="post_comments">
                                                                                                        <div class="post_comments_main clearfix">
                                                                                                            <div class="media">
                                                                                                                <div class="media-body">
                                                                                                                    <span  class="comment_txt">{{$insures_details[$i]['addpremium']['comment']}}</span>        
                                                                                                                </div>
                                                                                                                <div class="media-right">
                                                                                                                        <span id="cancel_addpremium_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                                        data-content="<input id='addpremium_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['addpremium']['comment']}}'>
                                                                                                                    <label class='error' id='addpremium_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                                    </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='addpremium' onclick='commentEdit(this)'>Update</button>
                                                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='addpremium' onclick='commentCancel(this)'><i class='material-icons'>close</i></button" data-container="body">
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
                                                                                            <span id="div_addpremium_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                                title="Edit existing value" data-html="true" data-content="<input id='addpremium_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['addpremium']['isAgree']}}'>
                                                                                            <label class='error' id='addpremium_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='addpremium' onclick='fun(this)'>Update</button>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='addpremium' onclick='cancel(this)'>
                                                                                            <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['addpremium']['isAgree']}}</span></div></td>
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
                                                    @if(isset($pipeline_details['formData']['primaryclause']) && $pipeline_details['formData']['primaryclause']== true)     
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
                                                                                    <span id='div_primaryclause_{{$insures_details[$i]['uniqueToken']}}'
                                                                                        data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
                                                                                        <input id='primaryclause_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['primaryclause']?:'--'}}' required>
                                                                                        <label class='error' id='primaryclause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='primaryclause' onclick='fun(this)'>Update</button>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='primaryclause' onclick='cancel(this)'>
                                                                                        <i class='material-icons'>close</i></button>"
                                                                                        data-container="body">{{$insures_details[$i]['primaryclause']?:'--'}}
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
                                   
                                                    @if(isset($pipeline_details['formData']['premiumClaim']) && $pipeline_details['formData']['premiumClaim']== true)     
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
                                                                                    <span id='div_premiumClaim_{{$insures_details[$i]['uniqueToken']}}'
                                                                                        data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
                                                                                        <input id='premiumClaim_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['premiumClaim']?:'--'}}' required>
                                                                                        <label class='error' id='premiumClaim_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='premiumClaim' onclick='fun(this)'>Update</button>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='premiumClaim' onclick='cancel(this)'>
                                                                                        <i class='material-icons'>close</i></button>"
                                                                                        data-container="body">{{$insures_details[$i]['premiumClaim']?:'--'}}
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
                                                    @if(isset($pipeline_details['formData']['lossnotification']) && $pipeline_details['formData']['lossnotification'] == true)
                                                        <tr>
                                                            <?php $insure_count=count(@$insures_details);?>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
                                                                        @if(isset($insures_details[$i]['lossnotification']['isAgree']))
                                                                                @if(@$insures_details[$i]['lossnotification']['comment']!="")
                                                                                    <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                        <div class="ans">
                                                                                            <span id="div_lossnotification_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                data-content="<input id='lossnotification_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['lossnotification']['isAgree']}}'>
                                                                                                <label class='error' id='lossnotification_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='lossnotification' onclick='fun(this)'>Update</button>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='lossnotification' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                data-container="body">{{@$insures_details[$i]['lossnotification']['isAgree']}}
                                                                                            </span>
                                                                                            
                                                                                                <div class="post_comments">
                                                                                                        <div class="post_comments_main clearfix">
                                                                                                            <div class="media">
                                                                                                                <div class="media-body">
                                                                                                                    <span  class="comment_txt">{{$insures_details[$i]['lossnotification']['comment']}}</span>        
                                                                                                                </div>
                                                                                                                <div class="media-right">
                                                                                                                        <span id="cancel_lossnotification_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                                        data-content="<input id='lossnotification_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['lossnotification']['comment']}}'>
                                                                                                                    <label class='error' id='lossnotification_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                                    </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='lossnotification' onclick='commentEdit(this)'>Update</button>
                                                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='lossnotification' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
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
                                                                                            <span id="div_lossnotification_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                                title="Edit existing value" data-html="true" data-content="<input id='lossnotification_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['lossnotification']['isAgree']}}'>
                                                                                            <label class='error' id='lossnotification_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='lossnotification' onclick='fun(this)'>Update</button>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='lossnotification' onclick='cancel(this)'>
                                                                                            <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['lossnotification']['isAgree']}}</span></div></td>
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
                                                    @if(isset($pipeline_details['formData']['adjustmentPremium']) && $pipeline_details['formData']['adjustmentPremium'] == true)
                                                    <tr>
                                                        <?php $insure_count=count(@$insures_details);?>
                                                        @if($insure_count==0)
                                                            @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                <td>  <div class="ans">--</div></td>
                                                            @endfor
                                                        @else
                                                            @for ($i = 0; $i < $total_insure_count; $i++)
                                                                @if(array_key_exists($i,$insures_details))
                                                                    @if(isset($insures_details[$i]['adjustmentPremium']['isAgree']))
                                                                            @if(@$insures_details[$i]['adjustmentPremium']['comment']!="")
                                                                                <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                    <div class="ans">
                                                                                        <span id="div_adjustmentPremium_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                            data-content="<input id='adjustmentPremium_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['adjustmentPremium']['isAgree']}}'>
                                                                                            <label class='error' id='adjustmentPremium_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='adjustmentPremium' onclick='fun(this)'>Update</button>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='adjustmentPremium' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                            data-container="body">{{@$insures_details[$i]['adjustmentPremium']['isAgree']}}
                                                                                        </span>
                                                                                  
                                                                                            <div class="post_comments">
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <div class="media">
                                                                                                            <div class="media-body">
                                                                                                                <span  class="comment_txt">{{$insures_details[$i]['adjustmentPremium']['comment']}}</span>        
                                                                                                            </div>
                                                                                                            <div class="media-right">
                                                                                                                    <span id="cancel_adjustmentPremium_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                                    data-content="<input id='adjustmentPremium_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['adjustmentPremium']['comment']}}'>
                                                                                                                <label class='error' id='adjustmentPremium_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                                </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='adjustmentPremium' onclick='commentEdit(this)'>Update</button>
                                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='adjustmentPremium' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
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
                                                                                        <span id="div_adjustmentPremium_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                            title="Edit existing value" data-html="true" data-content="<input id='adjustmentPremium_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['adjustmentPremium']['isAgree']}}'>
                                                                                        <label class='error' id='adjustmentPremium_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='adjustmentPremium' onclick='fun(this)'>Update</button>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='adjustmentPremium' onclick='cancel(this)'>
                                                                                        <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['adjustmentPremium']['isAgree']}}</span></div></td>
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
                                                @if(isset($pipeline_details['formData']['temporaryclause']) && $pipeline_details['formData']['temporaryclause'] == true)
                                                <tr>
                                                    <?php $insure_count=count(@$insures_details);?>
                                                    @if($insure_count==0)
                                                        @for ($i = 0; $i < $sel_insure_count; $i++)
                                                            <td>  <div class="ans">--</div></td>
                                                        @endfor
                                                    @else
                                                        @for ($i = 0; $i < $total_insure_count; $i++)
                                                            @if(array_key_exists($i,$insures_details))
                                                                @if(isset($insures_details[$i]['temporaryclause']['isAgree']))
                                                                        @if(@$insures_details[$i]['temporaryclause']['comment']!="")
                                                                            <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                <div class="ans">
                                                                                    <span id="div_temporaryclause_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                        data-content="<input id='temporaryclause_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['temporaryclause']['isAgree']}}'>
                                                                                        <label class='error' id='temporaryclause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='temporaryclause' onclick='fun(this)'>Update</button>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='temporaryclause' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                        data-container="body">{{@$insures_details[$i]['temporaryclause']['isAgree']}}
                                                                                    </span>
                                                                              
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['temporaryclause']['comment']}}</span>        
                                                                                                        </div>
                                                                                                        <div class="media-right">
                                                                                                                <span id="cancel_temporaryclause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                                data-content="<input id='temporaryclause_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['temporaryclause']['comment']}}'>
                                                                                                            <label class='error' id='temporaryclause_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                            </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='temporaryclause' onclick='commentEdit(this)'>Update</button>
                                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='temporaryclause' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
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
                                                                                    <span id="div_temporaryclause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                        title="Edit existing value" data-html="true" data-content="<input id='temporaryclause_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['temporaryclause']['isAgree']}}'>
                                                                                    <label class='error' id='temporaryclause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='temporaryclause' onclick='fun(this)'>Update</button>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='temporaryclause' onclick='cancel(this)'>
                                                                                    <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['temporaryclause']['isAgree']}}</span></div></td>
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
                                                    
                                                    @if(isset($pipeline_details['formData']['automaticClause']) && $pipeline_details['formData']['automaticClause'] == true)
                                                        <tr>
                                                            <?php $insure_count=count(@$insures_details);?>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
                                                                        @if(isset($insures_details[$i]['automaticClause']['isAgree']))
                                                                                @if(@$insures_details[$i]['automaticClause']['comment']!="")
                                                                                    <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                        <div class="ans">
                                                                                            <span id="div_automaticClause_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                data-content="<input id='automaticClause_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['automaticClause']['isAgree']}}'>
                                                                                                <label class='error' id='automaticClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='automaticClause' onclick='fun(this)'>Update</button>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='automaticClause' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                data-container="body">{{@$insures_details[$i]['automaticClause']['isAgree']}}
                                                                                            </span>
                                                                                          
                                                                                            <div class="post_comments">
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <div class="media">
                                                                                                            <div class="media-body">
                                                                                                                <span  class="comment_txt">{{$insures_details[$i]['automaticClause']['comment']}}</span>        
                                                                                                            </div>
                                                                                                            <div class="media-right">
                                                                                                                    <span id="cancel_automaticClause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                    data-content="<input id='automaticClause_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['automaticClause']['comment']}}'>
                                                                                                <label class='error' id='automaticClause_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='automaticClause' onclick='commentEdit(this)'>Update</button>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='automaticClause' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
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
                                                                                            <span id="div_automaticClause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                                title="Edit existing value" data-html="true" data-content="<input id='automaticClause_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['automaticClause']['isAgree']}}'>
                                                                                            <label class='error' id='automaticClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='automaticClause' onclick='fun(this)'>Update</button>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='automaticClause' onclick='cancel(this)'>
                                                                                            <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['automaticClause']['isAgree']}}</span></div></td>
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
                                                    @if(isset($pipeline_details['formData']['capitalclause']) && $pipeline_details['formData']['capitalclause'] == true)
                                                    <tr>
                                                        <?php $insure_count=count(@$insures_details);?>
                                                        @if($insure_count==0)
                                                            @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                <td>  <div class="ans">--</div></td>
                                                            @endfor
                                                        @else
                                                            @for ($i = 0; $i < $total_insure_count; $i++)
                                                                @if(array_key_exists($i,$insures_details))
                                                                    @if(isset($insures_details[$i]['capitalclause']['isAgree']))
                                                                            @if(@$insures_details[$i]['capitalclause']['comment']!="")
                                                                                <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                    <div class="ans">
                                                                                        <span id="div_capitalclause_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                            data-content="<input id='capitalclause_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['capitalclause']['isAgree']}}'>
                                                                                            <label class='error' id='capitalclause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='capitalclause' onclick='fun(this)'>Update</button>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='capitalclause' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                            data-container="body">{{@$insures_details[$i]['capitalclause']['isAgree']}}
                                                                                        </span>
                                                                                  
                                                                                            <div class="post_comments">
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <div class="media">
                                                                                                            <div class="media-body">
                                                                                                                <span  class="comment_txt">{{$insures_details[$i]['capitalclause']['comment']}}</span>        
                                                                                                            </div>
                                                                                                            <div class="media-right">
                                                                                                                    <span id="cancel_capitalclause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                                    data-content="<input id='capitalclause_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['capitalclause']['comment']}}'>
                                                                                                                <label class='error' id='capitalclause_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                                </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='capitalclause' onclick='commentEdit(this)'>Update</button>
                                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='capitalclause' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
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
                                                                                        <span id="div_capitalclause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                            title="Edit existing value" data-html="true" data-content="<input id='capitalclause_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['capitalclause']['isAgree']}}'>
                                                                                        <label class='error' id='capitalclause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='capitalclause' onclick='fun(this)'>Update</button>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='capitalclause' onclick='cancel(this)'>
                                                                                        <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['capitalclause']['isAgree']}}</span></div></td>
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
                                                           
                                                    @if(isset($pipeline_details['formData']['debris']) && $pipeline_details['formData']['debris'] == true)
                                                        <tr>
                                                            <?php $insure_count=count(@$insures_details);?>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
                                                                        @if(isset($insures_details[$i]['debris']['isAgree']))
                                                                                @if(@$insures_details[$i]['debris']['comment']!="")
                                                                                    <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                        <div class="ans">
                                                                                            <span id="div_debris_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                data-content="<input id='debris_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['debris']['isAgree']}}'>
                                                                                                <label class='error' id='debris_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='debris' onclick='fun(this)'>Update</button>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='debris' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                data-container="body">{{@$insures_details[$i]['debris']['isAgree']}}
                                                                                            </span>
                                                                                            
                                                                                            <div class="post_comments">
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <div class="media">
                                                                                                            <div class="media-body">
                                                                                                                <span  class="comment_txt">{{$insures_details[$i]['debris']['comment']}}</span>        
                                                                                                            </div>
                                                                                                            <div class="media-right">
                                                                                                                    <span id="cancel_debris_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                                    data-content="<input id='debris_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['debris']['comment']}}'>
                                                                                                                <label class='error' id='debris_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                                </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='debris' onclick='commentEdit(this)'>Update</button>
                                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='debris' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
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
                                                                                                <span id="div_debris_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                                    title="Edit existing value" data-html="true" data-content="<input id='debris_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['debris']['isAgree']}}'>
                                                                                                <label class='error' id='debris_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='debris' onclick='fun(this)'>Update</button>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='debris' onclick='cancel(this)'>
                                                                                                <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['debris']['isAgree']}}</span></div></td>
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
                                                    @if(isset($pipeline_details['formData']['property']) && $pipeline_details['formData']['property'] == true)
                                                        <tr>
                                                            <?php $insure_count=count(@$insures_details);?>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
                                                                        @if(isset($insures_details[$i]['property']['isAgree']))
                                                                                @if(@$insures_details[$i]['property']['comment']!="")
                                                                                    <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                        <div class="ans">
                                                                                            <span id="div_property_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                data-content="<input id='property_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['property']['isAgree']}}'>
                                                                                                <label class='error' id='property_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='property' onclick='fun(this)'>Update</button>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='property' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                data-container="body">{{@$insures_details[$i]['property']['isAgree']}}
                                                                                            </span>
                                                                                           
                                                                                                <div class="post_comments">
                                                                                                        <div class="post_comments_main clearfix">
                                                                                                            <div class="media">
                                                                                                                <div class="media-body">
                                                                                                                    <span  class="comment_txt">{{$insures_details[$i]['property']['comment']}}</span>        
                                                                                                                </div>
                                                                                                                <div class="media-right">
                                                                                                                        <span id="cancel_property_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                    data-content="<input id='property_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['property']['comment']}}'>
                                                                                                <label class='error' id='property_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='property' onclick='commentEdit(this)'>Update</button>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='property' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
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
                                                                                                <span id="div_property_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                                    title="Edit existing value" data-html="true" data-content="<input id='property_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['property']['isAgree']}}'>
                                                                                                <label class='error' id='property_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='property' onclick='fun(this)'>Update</button>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='property' onclick='cancel(this)'>
                                                                                                <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['property']['isAgree']}}</span></div></td>
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
                                                    @if(isset($pipeline_details['formData']['errorclause']) && $pipeline_details['formData']['errorclause']== true)     
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
                                                                                    <span id='div_errorclause_{{$insures_details[$i]['uniqueToken']}}'
                                                                                        data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
                                                                                        <input id='errorclause_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['errorclause']?:'--'}}' required>
                                                                                        <label class='error' id='errorclause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='errorclause' onclick='fun(this)'>Update</button>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='errorclause' onclick='cancel(this)'>
                                                                                        <i class='material-icons'>close</i></button>"
                                                                                        data-container="body">{{$insures_details[$i]['errorclause']?:'--'}}
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
                                                    @if(@$pipeline_details['formData']['aff_company']!='' && isset($pipeline_details['formData']['waiver']) && $pipeline_details['formData']['waiver'] == true)
                                                        <tr>
                                                            <?php $insure_count=count(@$insures_details);?>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
                                                                        @if(isset($insures_details[$i]['waiver']['isAgree']))
                                                                                @if(@$insures_details[$i]['waiver']['comment']!="")
                                                                                    <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                        <div class="ans">
                                                                                            <span id="div_waiver_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                data-content="<input id='waiver_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['waiver']['isAgree']}}'>
                                                                                                <label class='error' id='waiver_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='waiver' onclick='fun(this)'>Update</button>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='waiver' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                data-container="body">{{@$insures_details[$i]['waiver']['isAgree']}}
                                                                                            </span>
                                                                                            
                                                                                            <div class="post_comments">
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <div class="media">
                                                                                                            <div class="media-body">
                                                                                                                <span  class="comment_txt">{{$insures_details[$i]['waiver']['comment']}}</span>        
                                                                                                            </div>
                                                                                                            <div class="media-right">
                                                                                                                    <span id="cancel_waiver_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                                    data-content="<input id='waiver_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['waiver']['comment']}}'>
                                                                                                                <label class='error' id='waiver_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                                </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='waiver' onclick='commentEdit(this)'>Update</button>
                                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='waiver' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
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
                                                                                                <span id="div_waiver_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                                    title="Edit existing value" data-html="true" data-content="<input id='waiver_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['waiver']['isAgree']}}'>
                                                                                                <label class='error' id='waiver_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='waiver' onclick='fun(this)'>Update</button>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='waiver' onclick='cancel(this)'>
                                                                                                <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['waiver']['isAgree']}}</span></div></td>
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
                                                    @if(isset($pipeline_details['formData']['claimclause']) && $pipeline_details['formData']['claimclause'] == true)
                                                        <tr>
                                                            <?php $insure_count=count(@$insures_details);?>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
                                                                        @if(isset($insures_details[$i]['claimclause']['isAgree']))
                                                                                @if(@$insures_details[$i]['claimclause']['comment']!="")
                                                                                    <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                        <div class="ans">
                                                                                            <span id="div_claimclause_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                data-content="<input id='claimclause_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['claimclause']['isAgree']}}'>
                                                                                                <label class='error' id='claimclause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='claimclause' onclick='fun(this)'>Update</button>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='claimclause' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                data-container="body">{{@$insures_details[$i]['claimclause']['isAgree']}}
                                                                                            </span>
                                                                                            
                                                                                            <div class="post_comments">
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <div class="media">
                                                                                                            <div class="media-body">
                                                                                                                <span  class="comment_txt">{{$insures_details[$i]['claimclause']['comment']}}</span>        
                                                                                                            </div>
                                                                                                            <div class="media-right">
                                                                                                                    <span id="cancel_claimclause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                                    data-content="<input id='claimclause_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['claimclause']['comment']}}'>
                                                                                                                <label class='error' id='claimclause_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                                </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='claimclause' onclick='commentEdit(this)'>Update</button>
                                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='claimclause' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
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
                                                                                                <span id="div_claimclause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                                    title="Edit existing value" data-html="true" data-content="<input id='claimclause_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['claimclause']['isAgree']}}'>
                                                                                                <label class='error' id='claimclause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='claimclause' onclick='fun(this)'>Update</button>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='claimclause' onclick='cancel(this)'>
                                                                                                <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['claimclause']['isAgree']}}</span></div></td>
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
                                                    @if(isset($pipeline_details['formData']['Innocent']) && $pipeline_details['formData']['Innocent']== true)     
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
                                                                            <span id='div_Innocent_{{$insures_details[$i]['uniqueToken']}}'
                                                                                data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
                                                                                <input id='Innocent_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['Innocent']?:'--'}}' required>
                                                                                <label class='error' id='Innocent_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='Innocent' onclick='fun(this)'>Update</button>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='Innocent' onclick='cancel(this)'>
                                                                                <i class='material-icons'>close</i></button>"
                                                                                data-container="body">{{$insures_details[$i]['Innocent']?:'--'}}
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
                                                    @if(isset($pipeline_details['formData']['Noninvalidation']) && $pipeline_details['formData']['Noninvalidation']== true)     
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
                                                                            <span id='div_Noninvalidation_{{$insures_details[$i]['uniqueToken']}}'
                                                                                data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
                                                                                <input id='Noninvalidation_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['Noninvalidation']?:'--'}}' required>
                                                                                <label class='error' id='Noninvalidation_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='Noninvalidation' onclick='fun(this)'>Update</button>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='Noninvalidation' onclick='cancel(this)'>
                                                                                <i class='material-icons'>close</i></button>"
                                                                                data-container="body">{{$insures_details[$i]['Noninvalidation']?:'--'}}
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
                                                   
                                                @if(isset($pipeline_details['formData']['brokerclaim']) && $pipeline_details['formData']['brokerclaim'] == true)     
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
                                                                        <span id='div_brokerclaim_{{$insures_details[$i]['uniqueToken']}}'
                                                                            data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
                                                                            <input id='brokerclaim_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['brokerclaim']?:'--'}}' required>
                                                                            <label class='error' id='brokerclaim{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='brokerclaim' onclick='fun(this)'>Update</button>
                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='brokerclaim' onclick='cancel(this)'>
                                                                            <i class='material-icons'>close</i></button>"
                                                                            data-container="body">{{$insures_details[$i]['brokerclaim']?:'--'}}
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
                                                {{-- @if(isset($pipeline_details['formData']['deductm']) && $pipeline_details['formData']['deductm']!= '')      --}}
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
                                                                                <span id='div_deductm_{{$insures_details[$i]['uniqueToken']}}'
                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
                                                                                    <input id='deductm_{{$insures_details[$i]['uniqueToken']}}' type='text' value='@if(isset($insures_details[$i]['deductm'])){{$insures_details[$i]['deductm']}} @else -- @endif' required>
                                                                                    <label class='error' id='deductm{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='deductm' onclick='fun(this)'>Update</button>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='deductm' onclick='cancel(this)'>
                                                                                    <i class='material-icons'>close</i></button>"
                                                                                    data-container="body">@if(isset($insures_details[$i]['deductm'])){{number_format($insures_details[$i]['deductm'],2)}} @else -- @endif
                                                                                </span>
                                                                            </div>
                                                                        </td>
                                                                    @else
                                                                        <td>  <div class="ans">--</div></td>
                                                                    @endif
                                                                @endfor
                                                            @endif
                                                           
                                                        </tr>
                                                    {{-- @endif
                                                    @if(isset($pipeline_details['formData']['ratem']) && $pipeline_details['formData']['ratem']!= '')      --}}
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
                                                                                <span id='div_ratem_{{$insures_details[$i]['uniqueToken']}}'
                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
                                                                                    <input id='ratem_{{$insures_details[$i]['uniqueToken']}}' type='text' value='@if(isset($insures_details[$i]['ratem'])){{$insures_details[$i]['ratem']}} @else -- @endif' required>
                                                                                    <label class='error' id='ratem{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='ratem' onclick='fun(this)'>Update</button>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='ratem' onclick='cancel(this)'>
                                                                                    <i class='material-icons'>close</i></button>"
                                                                                    data-container="body">@if(isset($insures_details[$i]['ratem'])){{number_format($insures_details[$i]['ratem'],2)}} @else -- @endif
                                                                                </span>
                                                                            </div>
                                                                        </td>
                                                                    @else
                                                                        <td>  <div class="ans">--</div></td>
                                                                    @endif
                                                                @endfor
                                                            @endif
                                                          
                                                        </tr>
                                                    {{-- @endif
                                                    @if(isset($pipeline_details['formData']['premiumm']) && $pipeline_details['formData']['premiumm']!= '')      --}}
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
                                                                                <span id='div_premiumm_{{$insures_details[$i]['uniqueToken']}}'
                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
                                                                                    <input id='premiumm_{{$insures_details[$i]['uniqueToken']}}' type='text' value='@if(isset($insures_details[$i]['premiumm'])){{$insures_details[$i]['premiumm']}} @else -- @endif' required>
                                                                                    <label class='error' id='premiumm{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='premiumm' onclick='fun(this)'>Update</button>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='premiumm' onclick='cancel(this)'>
                                                                                    <i class='material-icons'>close</i></button>"
                                                                                    data-container="body">@if(isset($insures_details[$i]['premiumm'])){{number_format($insures_details[$i]['premiumm'],2)}} @else -- @endif
                                                                                </span>
                                                                            </div>
                                                                        </td>
                                                                    @else
                                                                        <td>  <div class="ans">--</div></td>
                                                                    @endif
                                                                @endfor
                                                            @endif
                                                         
                                                        </tr>
                                                    {{-- @endif
                                                    @if(isset($pipeline_details['formData']['brokeragem']) && $pipeline_details['formData']['brokeragem']!= '')      --}}
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
                                                                            <span id='div_brokeragem_{{$insures_details[$i]['uniqueToken']}}'
                                                                                data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
                                                                                <input id='brokeragem_{{$insures_details[$i]['uniqueToken']}}' type='text' value='@if(isset($insures_details[$i]['brokeragem'])){{$insures_details[$i]['brokeragem']}} @else -- @endif' required>
                                                                                <label class='error' id='brokeragem{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='brokeragem' onclick='fun(this)'>Update</button>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='brokeragem' onclick='cancel(this)'>
                                                                                <i class='material-icons'>close</i></button>"
                                                                                data-container="body">@if(isset($insures_details[$i]['brokeragem'])){{number_format($insures_details[$i]['brokeragem'],2)}} @else -- @endif
                                                                            </span>
                                                                        </div>
                                                                    </td>
                                                                @else
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endif
                                                            @endfor
                                                        @endif
                                              
                                                    </tr>
                                                {{-- @endif
                                                @if(isset($pipeline_details['formData']['warrantym']) && $pipeline_details['formData']['warrantym']!= '')      --}}
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
                                                                                <span id='div_warrantym_{{$insures_details[$i]['uniqueToken']}}'
                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
                                                                                    <input id='warrantym_{{$insures_details[$i]['uniqueToken']}}' type='text' value='@if(isset($insures_details[$i]['warrantym'])){{$insures_details[$i]['warrantym']}} @else -- @endif' required>
                                                                                    <label class='error' id='warrantym{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='warrantym' onclick='fun(this)'>Update</button>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='warrantym' onclick='cancel(this)'>
                                                                                    <i class='material-icons'>close</i></button>"
                                                                                    data-container="body">@if(isset($insures_details[$i]['warrantym'])){{$insures_details[$i]['warrantym']}} @else -- @endif
                                                                                </span>
                                                                            </div>
                                                                        </td>
                                                                    @else
                                                                        <td>  <div class="ans">--</div></td>
                                                                    @endif
                                                                @endfor
                                                            @endif
                                                          
                                                        </tr>
                                                    {{-- @endif
                                                    @if(isset($pipeline_details['formData']['exclusionm']) && $pipeline_details['formData']['exclusionm']!= '')      --}}
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
                                                                            <span id='div_exclusionm_{{$insures_details[$i]['uniqueToken']}}'
                                                                                data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
                                                                                <input id='exclusionm_{{$insures_details[$i]['uniqueToken']}}' type='text' value='@if(isset($insures_details[$i]['exclusionm'])){{$insures_details[$i]['exclusionm']}} @else -- @endif' required>
                                                                                <label class='error' id='exclusionm{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='exclusionm' onclick='fun(this)'>Update</button>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='exclusionm' onclick='cancel(this)'>
                                                                                <i class='material-icons'>close</i></button>"
                                                                                data-container="body">@if(isset($insures_details[$i]['exclusionm'])){{$insures_details[$i]['exclusionm']}} @else -- @endif
                                                                            </span>
                                                                        </div>
                                                                    </td>
                                                                @else
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endif
                                                            @endfor
                                                        @endif
                                                       
                                                    </tr>
                                                {{-- @endif
                                                @if(isset($pipeline_details['formData']['specialm']) && $pipeline_details['formData']['specialm']!= '')      --}}
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
                                                                            <span id='div_specialm_{{$insures_details[$i]['uniqueToken']}}'
                                                                                data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
                                                                                <input id='specialm_{{$insures_details[$i]['uniqueToken']}}' type='text' value='@if(isset($insures_details[$i]['specialm'])){{$insures_details[$i]['specialm']}} @else -- @endif' required>
                                                                                <label class='error' id='specialm{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='specialm' onclick='fun(this)'>Update</button>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='specialm' onclick='cancel(this)'>
                                                                                <i class='material-icons'>close</i></button>"
                                                                                data-container="body">@if(isset($insures_details[$i]['specialm'])){{$insures_details[$i]['specialm']}} @else -- @endif
                                                                            </span>
                                                                        </div>
                                                                    </td>
                                                                @else
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endif
                                                            @endfor
                                                        @endif
                                                      
                                                    </tr>
                                                {{-- @endif
                                                @if(isset($pipeline_details['formData']['deductb']) && $pipeline_details['formData']['deductb']!= '')      --}}
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
                                                                                <span id='div_deductb_{{$insures_details[$i]['uniqueToken']}}'
                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
                                                                                    <input id='deductb_{{$insures_details[$i]['uniqueToken']}}' type='text' value='@if(isset($insures_details[$i]['deductb'])){{$insures_details[$i]['deductb']}} @else -- @endif' required>
                                                                                    <label class='error' id='deductb{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='deductb' onclick='fun(this)'>Update</button>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='deductb' onclick='cancel(this)'>
                                                                                    <i class='material-icons'>close</i></button>"
                                                                                    data-container="body">@if(isset($insures_details[$i]['deductb'])){{number_format($insures_details[$i]['deductb'],2)}} @else -- @endif
                                                                                </span>
                                                                            </div>
                                                                        </td>
                                                                    @else
                                                                        <td>  <div class="ans">--</div></td>
                                                                    @endif
                                                                @endfor
                                                            @endif
                                                           
                                                        </tr>
                                                    {{-- @endif
                                                    @if(isset($pipeline_details['formData']['rateb']) && $pipeline_details['formData']['rateb']!= '')      --}}
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
                                                                                <span id='div_rateb_{{$insures_details[$i]['uniqueToken']}}'
                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
                                                                                    <input id='rateb_{{$insures_details[$i]['uniqueToken']}}' type='text' value='@if(isset($insures_details[$i]['rateb'])){{$insures_details[$i]['rateb']}} @else -- @endif' required>
                                                                                    <label class='error' id='rateb{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='rateb' onclick='fun(this)'>Update</button>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='rateb' onclick='cancel(this)'>
                                                                                    <i class='material-icons'>close</i></button>"
                                                                                    data-container="body">@if(isset($insures_details[$i]['rateb'])){{number_format($insures_details[$i]['rateb'],2)}} @else -- @endif
                                                                                </span>
                                                                            </div>
                                                                        </td>
                                                                    @else
                                                                        <td>  <div class="ans">--</div></td>
                                                                    @endif
                                                                @endfor
                                                            @endif
                                           
                                                        </tr>
                                                    {{-- @endif
                                                    @if(isset($pipeline_details['formData']['premiumb']) && $pipeline_details['formData']['premiumb']!= '')      --}}
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
                                                                                <span id='div_premiumb_{{$insures_details[$i]['uniqueToken']}}'
                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
                                                                                    <input id='premiumb_{{$insures_details[$i]['uniqueToken']}}' type='text' value='@if(isset($insures_details[$i]['premiumb'])){{$insures_details[$i]['premiumb']}} @else -- @endif' required>
                                                                                    <label class='error' id='premiumb{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='premiumb' onclick='fun(this)'>Update</button>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='premiumb' onclick='cancel(this)'>
                                                                                    <i class='material-icons'>close</i></button>"
                                                                                    data-container="body">@if(isset($insures_details[$i]['premiumb'])){{number_format($insures_details[$i]['premiumb'],2)}} @else -- @endif
                                                                                </span>
                                                                            </div>
                                                                        </td>
                                                                    @else
                                                                        <td>  <div class="ans">--</div></td>
                                                                    @endif
                                                                @endfor
                                                            @endif
                                                        
                                                        </tr>
                                                    {{-- @endif
                                                    @if(isset($pipeline_details['formData']['brokerageb']) && $pipeline_details['formData']['brokerageb']!= '')      --}}
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
                                                                            <span id='div_brokerageb_{{$insures_details[$i]['uniqueToken']}}'
                                                                                data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
                                                                                <input id='brokerageb_{{$insures_details[$i]['uniqueToken']}}' type='text' value='@if(isset($insures_details[$i]['brokerageb'])){{$insures_details[$i]['brokerageb']}} @else -- @endif' required>
                                                                                <label class='error' id='brokerageb{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='brokerageb' onclick='fun(this)'>Update</button>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='brokerageb' onclick='cancel(this)'>
                                                                                <i class='material-icons'>close</i></button>"
                                                                                data-container="body">@if(isset($insures_details[$i]['brokerageb'])){{number_format($insures_details[$i]['brokerageb'],2)}} @else -- @endif
                                                                            </span>
                                                                        </div>
                                                                    </td>
                                                                @else
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endif
                                                            @endfor
                                                        @endif
                                                        
                                                    </tr>
                                                {{-- @endif
                                                @if(isset($pipeline_details['formData']['warrantyb']) && $pipeline_details['formData']['warrantyb']!= '')      --}}
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
                                                                                <span id='div_warrantyb_{{$insures_details[$i]['uniqueToken']}}'
                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
                                                                                    <input id='warrantyb_{{$insures_details[$i]['uniqueToken']}}' type='text' value='@if(isset($insures_details[$i]['warrantyb'])){{$insures_details[$i]['warrantyb']}} @else -- @endif' required>
                                                                                    <label class='error' id='warrantyb{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='warrantyb' onclick='fun(this)'>Update</button>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='warrantyb' onclick='cancel(this)'>
                                                                                    <i class='material-icons'>close</i></button>"
                                                                                    data-container="body">@if(isset($insures_details[$i]['warrantyb'])){{$insures_details[$i]['warrantyb']}} @else -- @endif
                                                                                </span>
                                                                            </div>
                                                                        </td>
                                                                    @else
                                                                        <td>  <div class="ans">--</div></td>
                                                                    @endif
                                                                @endfor
                                                            @endif
                                                            
                                                        </tr>
                                                    {{-- @endif
                                                    @if(isset($pipeline_details['formData']['exclusionb']) && $pipeline_details['formData']['exclusionb']!= '')      --}}
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
                                                                            <span id='div_exclusionb_{{$insures_details[$i]['uniqueToken']}}'
                                                                                data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
                                                                                <input id='exclusionb_{{$insures_details[$i]['uniqueToken']}}' type='text' value='@if(isset($insures_details[$i]['exclusionb'])){{$insures_details[$i]['exclusionb']}} @else -- @endif' required>
                                                                                <label class='error' id='exclusionb{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='exclusionb' onclick='fun(this)'>Update</button>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='exclusionb' onclick='cancel(this)'>
                                                                                <i class='material-icons'>close</i></button>"
                                                                                data-container="body">@if(isset($insures_details[$i]['exclusionb'])){{$insures_details[$i]['exclusionb']}} @else -- @endif
                                                                            </span>
                                                                        </div>
                                                                    </td>
                                                                @else
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endif
                                                            @endfor
                                                        @endif
                                                      
                                                    </tr>
                                                {{-- @endif
                                                @if(isset($pipeline_details['formData']['specialb']) && $pipeline_details['formData']['specialb']!= '')      --}}
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
                                                                            <span id='div_specialb_{{$insures_details[$i]['uniqueToken']}}'
                                                                                data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
                                                                                <input id='specialb_{{$insures_details[$i]['uniqueToken']}}' type='text' value='@if(isset($insures_details[$i]['specialb'])){{$insures_details[$i]['specialb']}} @else -- @endif' required>
                                                                                <label class='error' id='specialb{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='specialb' onclick='fun(this)'>Update</button>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='specialb' onclick='cancel(this)'>
                                                                                <i class='material-icons'>close</i></button>"
                                                                                data-container="body">@if(isset($insures_details[$i]['specialb'])){{$insures_details[$i]['specialb']}} @else -- @endif
                                                                            </span>
                                                                        </div>
                                                                    </td>
                                                                @else
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endif
                                                            @endfor
                                                        @endif
                                              
                                                    </tr>
                                                {{-- @endif --}}
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
                            window.location.href = "{{url('Machinery-Breakdown/imported-list')}}";
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
        function validation(id) {
                            if($('#'+id).val()=='')
                            {
                                $('#'+id+'-error').show();
                            }else{
                                $('#'+id+'-error').hide();
                            }
                        }
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
                console.log('sdfsdfdf');
                error.insertBefore(element.parent().parent().parent().parent());
            },
            submitHandler: function (form,event) {
                var form_data = new FormData($("#e_quat_form")[0]);
                form_data.append('_token', '{{csrf_token()}}');
                $('#preLoader').show();
                $("#button_submit").attr( "disabled", "disabled" );
                $.ajax({
                    method: 'post',
                    url: '{{url('Machinery-Breakdown/save-selected-insurers')}}',
                    data: form_data,
                    cache : false,
                    contentType: false,
                    processData: false,
                    success: function (result) {
                        if (result== 'success') {
                            window.location.href = '{{url('Machinery-Breakdown/e-comparison/'.$pipeline_details->_id)}}';
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
                    url: '{{url('Machinery-Breakdown/quot-amend')}}',
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
                    url: '{{url('Machinery-Breakdown/quot-amend')}}',
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
                url: '{{url('Machinery-Breakdown/save-selected-insurers')}}',
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
