
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
            <h3 class="title" style="margin-bottom: 8px;">Fire and Perils</h3>
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
                            <li class="complete"><a href="{{url('fireperils/e-questionnaire/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Questionnaire</em></a></li>
                            <li class="complete"><a href="{{url('fireperils/e-slip/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>
                            @if($pipeline_details['status']['status'] == 'E-quotation')
                                <li class="current"><a href="{{url('fireperils/e-quotation/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                                <li><em>E-Comparison</em></li>
                                <li><em>Quote Amendment</em></li>
                                <li><em>Approved E Quote</em></li>
                                {{--<li><em>Issuance</em></li>--}}
                            @elseif($pipeline_details['status']['status'] == 'E-comparison')
                                <li class="active_arrow"><a href="{{url('fireperils/e-quotation/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                                <li class="current"><a href="{{url('fireperils/e-comparison/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                                <li><em>Quote Amendment</em></li>
                                <li><em>Approved E Quote</em></li>
                                {{--<li><em>Issuance</em></li>--}}
                            @elseif($pipeline_details['status']['status'] == 'Quote Amendment')
                                <li class="active_arrow"><a href="{{url('fireperils/e-quotation/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                                <li class="complete"><a href="{{url('fireperils/e-comparison/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                                <li class="current"><a href="{{url('fireperils/quot-amendment/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>
                                <li><em>Approved E Quote</em></li>
                                {{--<li><em>Issuance</em></li>--}}
                            @elseif($pipeline_details['status']['status'] == 'Approved E Quote')
                                <li class="active_arrow"><a href="{{url('fireperils/e-quotation/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                                <li class="complete"><a href="{{url('fireperils/e-comparison/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                                <li class="complete"><a href="{{url('fireperils/quot-amendment/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>
                                <li class="current"><a href="{{url('fireperils/approved-quot/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Approved E Quote</em></a></li>
                                {{--<li><em>Issuance</em></li>--}}
                            @elseif($pipeline_details['status']['status'] == 'Quote Amendment-E-comparison' || $pipeline_details['status']['status'] == 'Quote Amendment-E-quotation' || $pipeline_details['status']['status'] == 'Quote Amendment-E-slip')
                                <li class="active_arrow"><a href="{{url('fireperils/e-quotation/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                                <li class="complete"><a href="{{url('fireperils/e-comparison/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                                <li class="current"><a href="{{url('fireperils/quot-amendment/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>
                                <li><em>Approved E Quote</em></li>
                                {{--@elseif($pipeline_details['status']['status'] == 'Issuance')--}}
                                {{--<li class="complete"><a href="{{url('e-quotation/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>--}}
                                {{--<li class="complete"><a href="{{url('e-comparison/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>--}}
                                {{--<li class="complete"><a href="{{url('quot-amendment/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>--}}
                                {{--<li class="complete"><a href="{{url('approved-quot/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Approved E Quote</em></a></li>--}}
                                {{--<li class="current"><a href="{{url('issuance/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Issuance</em></a></li>--}}
                            @else
                                <li class="current"><a href="{{url('fireperils/e-quotation/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
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
                                               
                                              
                                                @if($pipeline_details['formData']['saleClause'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Sale of interest clause</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['fireBrigade'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Fire brigade and extinguishing clause</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['clauseWording'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">72 Hours clause-wording modified- the 72 hours will stretch beyond the expiration of the policy period provided
                                                                    the first earthquake/flood/storm occurred prior to the expiry time of the policy</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['automaticReinstatement'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Automatic reinstatement of sum insured at pro-rata additional premium</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['capitalClause'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Capital addition clause</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['mainClause'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Workmen???s Maintenance clause</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['repairCost'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Repair investigation costs</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['debris'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Removal of debris</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['reinstatementValClass'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Reinstatement Value  clause (85% condition of  average)</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['waiver'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Waiver  of subrogation (against affiliates and subsidiaries)</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['trace'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Trace and Access Clause</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['publicClause'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Public authorities clause</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['contentsClause'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">All other contents clause</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif
                                                  
                                                @if($pipeline_details['formData']['errorOmission'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Errors & Omissions</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['alterationClause'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Alteration and use  clause</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['tempRemovalClause'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Temporary removal clause</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['proFee'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Professional fees clause</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['expenseClause'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Expediting expense clause</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['desigClause'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Designation of property clause</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['buildingInclude'] == true && $pipeline_details['formData']['buildingInclude']!='')
                                                     <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Adjoining building clause</label></div></td>
                                                        <td class="main_answer"><div class="ans">{{$pipeline_details['formData']['buildingInclude']}}</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['cancelThirtyClause'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Cancellation clause-30 days either party subject to pro-rata refund of premium in either case unless a claim attached</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['primaryInsuranceClause'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Primary insurance clause</label></div></td>
                                                         <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['paymentAccountClause'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Payment on account clause</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['nonInvalidClause'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Non-invalidation clause</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif


                                                @if($pipeline_details['formData']['warrantyConditionClause'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Breach of warranty or condition clause</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['escalationClause'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Escalation clause</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['addInterestClause'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Additional Interest Clause</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                 @if(isset($pipeline_details['formData']['stock']) && $pipeline_details['formData']['stock']!='')

                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Stock Declaration clause</label></div></td>
                                                        <td class="main_answer"><div class="ans">{{$pipeline_details['formData']['stock']}}</div></td>
                                                    </tr>
                                                @endif

            

                                                @if($pipeline_details['formData']['improvementClause'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Improvement and betterment clause</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['automaticClause'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Automatic Addition deletion clause to be notified within 30 days period</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['reduseLoseClause'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Expense to reduce the loss clause</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['buildingInclude']!='' && $pipeline_details['formData']['demolitionClause'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Demolition clause</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['noControlClause'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">No control clause</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['preparationCostClause'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Claims preparation cost clause</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['coverPropertyCon'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Cover for property lying in the premises in containers</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['personalEffectsEmployee'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Personal effects of employee</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['incidentLandTransit'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Incidental Land Transit </label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['lossOrDamage'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Including loss or damage due to subsidence, ground heave or landslip</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['nominatedLossAdjusterClause'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Nominated Loss Adjuster clause-Insured can select the loss surveyor out of a panel ??? John Kidd LA, Cunningham Lindsey, & Miller International</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['sprinkerLeakage'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Sprinkler leakage clause</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['minLossClause'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Minimization of loss clause</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['costConstruction'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Increased cost of construction</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['annualRent'] && $pipeline_details['formData']['annualRent'] != '')
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Loss of rent</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['propertyValuationClause'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Property Valuation clause</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['accidentalDamage'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Including accidental damage to plate glass, interior and exterior signs</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['auditorsFee'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Auditor???s fee</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['smokeSoot'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Smoke and Soot damage extension</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['boilerExplosion'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Boiler explosion extension</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['chargeAirfreight'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Extra charges for airfreight</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['tempRemoval'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Temporary repair clause</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['strikeRiot'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Strike riot and civil commotion clause</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['coverMechanical'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Cover for  mechanical, electrical and electronic breakdown  for fixed non-mobile plant and machinery</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['coverExtWork'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Cover for external works including sign boards,  landscaping  including trees in building</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['misdescriptionClause'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Misdescription Clause</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['otherInsuranceClause'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Other insurance allowed clause</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['automaticAcqClause'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Automatic acquisition clause</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if(@$pipeline_details['formData']['occupancy']['type']=='Residence' || @$pipeline_details['formData']['occupancy']['type']=='Labour Camp')
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Cover for alternative accomodation</label></div></td>
                                                    <td class="main_answer"><div class="ans">{{@$pipeline_details['formData']['occupancy']['type']}}</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['businessType'])
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Cover for exhibition risks</label></div></td>
                                                        <td class="main_answer"><div class="ans">{{$pipeline_details['formData']['businessType']}}</div></td>
                                                    </tr>
                                                @endif

                                                @if(@$pipeline_details['formData']['occupancy']['type']=='Warehouse'
                                                    ||  @$pipeline_details['formData']['occupancy']['type']=='Factory'
                                                    ||  @$pipeline_details['formData']['occupancy']['type']=='Others')
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Cover for property in the open</label></div></td>
                                                        <td class="main_answer"><div class="ans">{{$pipeline_details['formData']['occupancy']['type']}}</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['otherItems']!='')
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Including property in the care, custody & control of the insured</label></div></td>
                                                        <td class="main_answer"><div class="ans">{{$pipeline_details['formData']['otherItems']}}</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['minorWorkExt'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Minor works extension</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['saleInterestClause'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Sale of Interest Clause                                                        </label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['sueLabourClause'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Sue and labour clause</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['bankPolicy'] ['bankPolicy'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Loss payee clause</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['electricalClause'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Electrical clause waiver- Loss or damage by fire to electrical or electronic appliances ,
                                                                    installations and wiring insured by this policy arising from or occasioned by over running, overheating excessive current, short circuiting,
                                                                    arcing, self-heating or leakage of electricity from whatever cause (lightning included) is covered</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['contractPriceClause'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Contract price clause</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['sprinklerUpgradationClause'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Sprinkler upgradation clause</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['accidentalFixClass'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Accidental damage to fixed glass, glass (other than fixed glass)</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['electronicInstallation'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Electronic installation, computers, data processing, equipment and other fragile or brittle object</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['businessType']=="Art galleries/ fine arts collection"
                                                        || $pipeline_details['formData']['businessType']=="Colleges/ Universities/ schools & educational institute"
                                                        || $pipeline_details['formData']['businessType']=="Hotels/ boarding houses/ motels/ service apartments"
                                                        || $pipeline_details['formData']['businessType']=="Hotel multiple cover"
                                                        || $pipeline_details['formData']['businessType']=="Museum/ heritage sites"
                                                        )

                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Cover for curios and work of art</label></div></td>
                                                        <td class="main_answer"><div class="ans">{{$pipeline_details['formData']['businessType']}}</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['brandTrademark'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Brand and trademark</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['ownerPrinciple']==true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Indemnity to owners and principals</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['conductClause'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Conduct of business clause</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['lossNotification'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Loss Notification ??? ???as soon as reasonably practicable</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['brockersClaimClause'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Brokers Claim Handling Clause :
                                                                    A loss notification received by the Insurance Broker will be deemed as a loss notification to Insurer.
                                                                    All communications flowing between the Insurer, Insured and the appointed Loss Surveyor should be channelized through the Broker,
                                                                    unless there is any unavoidable reasons compelling direct communications between the parties</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['businessInterruption']['business_interruption'] ==true )
                                                    @if($pipeline_details['formData']['addCostWorking'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Additional increase in cost of working</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['claimPreparationClause'] == true)
                                                            <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Claims preparation clause</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['suppliersExtension'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Suppliers extension/customer extension</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['accountantsClause'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Accountants clause</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['accountPayment'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Payment on account</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['preventionDenialClause'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Prevention/denial of access</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['premiumAdjClause'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Premium adjustment clause</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['publicUtilityClause'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Public utilities clause</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['brockersClaimHandlingClause'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Brokers Claim Handling Clause : A loss notification received by the
                                                                        Insurance Broker will be deemed as a loss notification to Insurer. All communications flowing between the Insurer, Insured and
                                                                        the appointed Loss Surveyor should be channelized through the Broker,
                                                                        unless there is any unavoidable reasons compelling direct communications between the parties</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['accountsRecievable'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Accounts recievable / Loss of booked debts</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['interDependency'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Interdependany clause</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['extraExpense'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Extra expense</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['contaminatedWater'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Contaminated water</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['auditorsFeeCheck'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Auditors fees</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['expenseReduceLoss'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Expense to reduce the loss</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['nominatedLossAdjuster'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Nominated loss adjuster</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['outbreakDiscease'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Outbreak of discease</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['nonPublicFailure'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Failure of non public power supply</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['premisesDetails'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Murder, Suicide or outbreak of discease on the premises</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['bombscare'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Bombscare and unexploded devices on the premises</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['DenialClause'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Denial of access</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['bookDebits'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Book of Debts</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['publicFailure'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Failure of public utility</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif

                                                    @if(isset($pipeline_details['formData']['businessInterruption']['noLocations']) && $pipeline_details['formData']['businessInterruption']['noLocations']>1)

                                                        @if($pipeline_details['formData']['departmentalClause'] == true)
                                                            <tr>
                                                                <td><div class="main_question"><label class="form_label bold">Departmental clause</label></div></td>
                                                                <td class="main_answer"><div class="ans">Yes</div></td>
                                                            </tr>
                                                        @endif
                                                        @if($pipeline_details['formData']['rentLease'] == true)
                                                            <tr>
                                                                <td><div class="main_question"><label class="form_label bold">Rent & Lease hold interest</label></div></td>
                                                                <td class="main_answer"><div class="ans">Yes</div></td>
                                                            </tr>
                                                        @endif
                                                    @endif


                                                    @if($pipeline_details['formData']['CoverAccomodation']['coverAccomodation'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Cover for alternate accomodation</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['demolitionCost'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Demolition and increased cost of construction</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['contingentBusiness'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Contingent business inetruption and contingent extra expense</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['nonOwnedProperties'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Non Owned property in vicinity interuption</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['royalties'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Royalties</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif

                                                @endif



                                                    @if(isset($pipeline_details['formData']['cliamPremium']) &&
                                                        $pipeline_details['formData']['cliamPremium'] =='combined_data')

                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Deductible for Property</label></div></td>
                                                            <td class="main_answer"><div class="ans">{{number_format($pipeline_details['formData']['claimPremiyumDetails']['deductableProperty'],2)}}</div></td>
                                                        </tr>
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Deductible for Business Interruption</label></div></td>
                                                            <td class="main_answer"><div class="ans">{{number_format($pipeline_details['formData']['claimPremiyumDetails']['deductableBusiness'],2)}}</div></td>
                                                        </tr>
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Rate required (combined)</label></div></td>
                                                            <td class="main_answer"><div class="ans">{{number_format($pipeline_details['formData']['claimPremiyumDetails']['rateCombined'],2)}}</div></td>
                                                        </tr>
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Premium required (combined)</label></div></td>
                                                            <td class="main_answer"><div class="ans">{{number_format($pipeline_details['formData']['claimPremiyumDetails']['premiumCombined'],2)}}</div></td>
                                                        </tr>
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Brokerage (combined)</label></div></td>
                                                            <td class="main_answer"><div class="ans">{{number_format($pipeline_details['formData']['claimPremiyumDetails']['brokerage'],2)}}</div></td>
                                                        </tr>
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Warranty (Property)</label></div></td>
                                                            <td class="main_answer"><div class="ans">{{$pipeline_details['formData']['claimPremiyumDetails']['warrantyProperty']}}</div></td>
                                                        </tr>
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Warranty (Business Interruption)</label></div></td>
                                                            <td class="main_answer"><div class="ans">{{$pipeline_details['formData']['claimPremiyumDetails']['warrantyBusiness']}}</div></td>
                                                        </tr>
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Exclusion (Property)</label></div></td>
                                                            <td class="main_answer"><div class="ans">{{$pipeline_details['formData']['claimPremiyumDetails']['exclusionProperty']}}</div></td>
                                                        </tr>
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Exclusion (Business Interruption)</label></div></td>
                                                            <td class="main_answer"><div class="ans">{{$pipeline_details['formData']['claimPremiyumDetails']['exclusionBusiness']}}</div></td>
                                                        </tr>
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Special Condition (Property)</label></div></td>
                                                            <td class="main_answer"><div class="ans">{{$pipeline_details['formData']['claimPremiyumDetails']['specialProperty']}}</div></td>
                                                        </tr>
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Special Condition (Business Interruption)</label></div></td>
                                                            <td class="main_answer"><div class="ans">{{$pipeline_details['formData']['claimPremiyumDetails']['specialBusiness']}}</div></td>
                                                        </tr>


                                                    @endif

                                                    @if(isset($pipeline_details['formData']['cliamPremium']) &&
                                                        $pipeline_details['formData']['cliamPremium'] =='only_fire')

                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Deductible</label></div></td>
                                                            <td class="main_answer"><div class="ans">{{number_format($pipeline_details['formData']['claimPremiyumDetails']['deductableProperty'],2)}}</div></td>
                                                        </tr>

                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Rate required </label></div></td>
                                                            <td class="main_answer"><div class="ans">{{number_format($pipeline_details['formData']['claimPremiyumDetails']['propertyRate'],2)}}</div></td>
                                                        </tr>
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Premium required </label></div></td>
                                                            <td class="main_answer"><div class="ans">{{number_format($pipeline_details['formData']['claimPremiyumDetails']['propertyPremium'],2)}}</div></td>
                                                        </tr>
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Brokerage </label></div></td>
                                                            <td class="main_answer"><div class="ans">{{number_format($pipeline_details['formData']['claimPremiyumDetails']['propertyBrockerage'],2)}}</div></td>
                                                        </tr>
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Warranty </label></div></td>
                                                            <td class="main_answer"><div class="ans">{{$pipeline_details['formData']['claimPremiyumDetails']['propertyWarranty']}}</div></td>
                                                        </tr>

                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Exclusion </label></div></td>
                                                            <td class="main_answer"><div class="ans">{{$pipeline_details['formData']['claimPremiyumDetails']['propertyExclusion']}}</div></td>
                                                        </tr>
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Special Condition</label></div></td>
                                                            <td class="main_answer"><div class="ans">{{$pipeline_details['formData']['claimPremiyumDetails']['propertySpecial']}}</div></td>
                                                        </tr>


                                                    @endif

                                                    @if(isset($pipeline_details['formData']['cliamPremium']) &&
                                                        $pipeline_details['formData']['cliamPremium'] =='separate_fire')

                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Deductible for Property</label></div></td>
                                                            <td class="main_answer"><div class="ans">{{number_format($pipeline_details['formData']['claimPremiyumDetails']['propertySeparateDeductable'],2)}}</div></td>
                                                        </tr>

                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Rate required (Property)</label></div></td>
                                                            <td class="main_answer"><div class="ans">{{number_format($pipeline_details['formData']['claimPremiyumDetails']['propertySeparateRate'],2)}}</div></td>
                                                        </tr>
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Premium required (Property)</label></div></td>
                                                            <td class="main_answer"><div class="ans">{{number_format($pipeline_details['formData']['claimPremiyumDetails']['propertySeparatePremium'],2)}}</div></td>
                                                        </tr>
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Brokerage (Property)</label></div></td>
                                                            <td class="main_answer"><div class="ans">{{number_format($pipeline_details['formData']['claimPremiyumDetails']['propertySeparateBrokerage'],2)}}</div></td>
                                                        </tr>
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Warranty (Property)</label></div></td>
                                                            <td class="main_answer"><div class="ans">{{$pipeline_details['formData']['claimPremiyumDetails']['propertySeparateWarranty']}}</div></td>
                                                        </tr>
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Exclusion (Property)</label></div></td>
                                                            <td class="main_answer"><div class="ans">{{$pipeline_details['formData']['claimPremiyumDetails']['propertySeparateExclusion']}}</div></td>
                                                        </tr>
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Special Condition (Property)</label></div></td>
                                                            <td class="main_answer"><div class="ans">{{$pipeline_details['formData']['claimPremiyumDetails']['propertySeparateSpecial']}}</div></td>
                                                        </tr>

                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Deductible for Business Interruption</label></div></td>
                                                            <td class="main_answer"><div class="ans">{{number_format($pipeline_details['formData']['claimPremiyumDetails']['businessSeparateDeductable'],2)}}</div></td>
                                                        </tr>

                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Rate required (Business Interruption)</label></div></td>
                                                            <td class="main_answer"><div class="ans">{{number_format($pipeline_details['formData']['claimPremiyumDetails']['businessSeparateRate'],2)}}</div></td>
                                                        </tr>
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Premium required (Business Interruption)</label></div></td>
                                                            <td class="main_answer"><div class="ans">{{number_format($pipeline_details['formData']['claimPremiyumDetails']['businessSeparatePremium'],2)}}</div></td>
                                                        </tr>
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Brokerage (Business Interruption)</label></div></td>
                                                            <td class="main_answer"><div class="ans">{{number_format($pipeline_details['formData']['claimPremiyumDetails']['businessSeparateBrokerage'],2)}}</div></td>
                                                        </tr>
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Warranty (Business Interruption)</label></div></td>
                                                            <td class="main_answer"><div class="ans">{{$pipeline_details['formData']['claimPremiyumDetails']['businessSeparateWarranty']}}</div></td>
                                                        </tr>
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Exclusion (Business Interruption)</label></div></td>
                                                            <td class="main_answer"><div class="ans">{{$pipeline_details['formData']['claimPremiyumDetails']['businessSeparateExclusion']}}</div></td>
                                                        </tr>
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Special Condition (Business Interruption)</label></div></td>
                                                            <td class="main_answer"><div class="ans">{{$pipeline_details['formData']['claimPremiyumDetails']['businessSeparateSpecial']}}</div></td>
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
                                                    {{-- <tr>
                                                        @if($insure_count==0)
                                                            @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                <td>  <div class="ans">--</div></td>
                                                            @endfor
                                                        @else
                                                            @for ($i = 0; $i < $total_insure_count; $i++)
                                                                @if(array_key_exists($i,$insures_details))
                                                                    <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                        <div class="ans">
                                                                            <span id='div_adjClause_{{$insures_details[$i]['uniqueToken']}}'
                                                                                data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
                                                                            <input id='adjBusinessClause_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['adjBusinessClause']?:'--'}}' required>
                                                                            <label class='error' id='adjBusinessClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='adjBusinessClause' onclick='fun(this)'>Update</button>
                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='adjBusinessClause' onclick='cancel(this)'>
                                                                            <i class='material-icons'>close</i></button>"
                                                                                data-container="body">{{$insures_details[$i]['adjBusinessClause']?:'--'}}
                                                                            </span>
                                                                        </div>
                                                                    </td>
                                                                @else
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr> --}}
    
                                                    @if(isset($pipeline_details['formData']['saleClause']) && $pipeline_details['formData']['saleClause'] == true)    
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
                                                                                <span id='div_saleClause_{{$insures_details[$i]['uniqueToken']}}'
                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
                                                                                    <input id='saleClause_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['saleClause']?:'--'}}' required>
                                                                                    <label class='error' id='saleClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='saleClause' onclick='fun(this)'>Update</button>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='saleClause' onclick='cancel(this)'>
                                                                                    <i class='material-icons'>close</i></button>"
                                                                                    data-container="body">{{$insures_details[$i]['saleClause']?:'--'}}
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
    
                                                    @if(isset($pipeline_details['formData']['fireBrigade']) && $pipeline_details['formData']['fireBrigade'] == true)
                                                        <tr>
                                                            <?php $insure_count=count(@$insures_details);?>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
                                                                        @if(isset($insures_details[$i]['fireBrigade']['isAgree']))
                                                                            @if(@$insures_details[$i]['fireBrigade']['comment']!="")
                                                                                <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                    <div class="ans">
                                                                                        <span id="div_fireBrigade_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                            data-content="<input id='fireBrigade_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['fireBrigade']['isAgree']}}'>
                                                                                            <label class='error' id='fireBrigade_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='fireBrigade' onclick='fun(this)'>Update</button>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='fireBrigade' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                            data-container="body">{{@$insures_details[$i]['fireBrigade']['isAgree']}}
                                                                                        </span>
                                                                                    
                                                                                        <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details[$i]['fireBrigade']['comment']}}</span>        
                                                                                                    </div>
                                                                                                    <div class="media-right">
                                                                                                        <span id="cancel_fireBrigade_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                        data-content="<input id='fireBrigade_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['fireBrigade']['comment']}}'>
                                                                                                    <label class='error' id='fireBrigade_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                    </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='fireBrigade' onclick='commentEdit(this)'>Update</button>
                                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='fireBrigade' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
                                                                                                                                                                                            data-container="body">
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
                                                                                    <span id="div_fireBrigade_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                        title="Edit existing value" data-html="true" data-content="<input id='fireBrigade_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['fireBrigade']['isAgree']}}'>
                                                                                    <label class='error' id='fireBrigade_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='fireBrigade' onclick='fun(this)'>Update</button>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='fireBrigade' onclick='cancel(this)'>
                                                                                    <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['fireBrigade']['isAgree']}}</span></div></td>
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
    
                                                    @if(isset($pipeline_details['formData']['clauseWording']) && $pipeline_details['formData']['clauseWording'] == true)    
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
                                                                                <span id='div_clauseWording_{{$insures_details[$i]['uniqueToken']}}'
                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
                                                                                    <input id='clauseWording_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['clauseWording']?:'--'}}' required>
                                                                                    <label class='error' id='clauseWording_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='clauseWording' onclick='fun(this)'>Update</button>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='clauseWording' onclick='cancel(this)'>
                                                                                    <i class='material-icons'>close</i></button>"
                                                                                    data-container="body">{{$insures_details[$i]['clauseWording']?:'--'}}
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
    
                                                    @if(isset($pipeline_details['formData']['automaticReinstatement']) && $pipeline_details['formData']['automaticReinstatement'] == true)
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['automaticReinstatement']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_automaticReinstatement_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='automaticReinstatement_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                        value='{{$insures_details[$i]['automaticReinstatement']}}' required><label class='error'
                                                                        id='automaticReinstatement_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='automaticReinstatement'
                                                                        onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                        value='automaticReinstatement' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{$insures_details[$i]['automaticReinstatement']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
    
                                                    @if(isset($pipeline_details['formData']['capitalClause']) && $pipeline_details['formData']['capitalClause'] == true)
                                                        <tr>
                                                            <?php $insure_count=count(@$insures_details);?>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['capitalClause']['isAgree']))
                                                                            @if(@$insures_details[$i]['capitalClause']['comment']!="")
                                                                                <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                    <div class="ans">
                                                                                        <span id="div_capitalClause_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                            data-content="<input id='capitalClause_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['capitalClause']['isAgree']}}'>
                                                                                            <label class='error' id='capitalClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='capitalClause' onclick='fun(this)'>Update</button>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='capitalClause' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                            data-container="body">{{@$insures_details[$i]['capitalClause']['isAgree']}}
                                                                                        </span>
                                                                                        
                                                                                        <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details[$i]['capitalClause']['comment']}}</span>        
                                                                                                    </div>
                                                                                                    <div class="media-right">
                                                                                                        <span id="cancel_capitalClause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                        data-content="<input id='capitalClause_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['capitalClause']['comment']}}'>
                                                                                                        <label class='error' id='capitalClause_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                        </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='capitalClause' onclick='commentEdit(this)'>Update</button>
                                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='capitalClause' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
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
                                                                                        <span id="div_capitalClause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                        title="Edit existing value" data-html="true" data-content="<input id='capitalClause_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['capitalClause']['isAgree']}}'>
                                                                                        <label class='error' id='capitalClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='capitalClause' onclick='fun(this)'>Update</button>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='capitalClause' onclick='cancel(this)'>
                                                                                        <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['capitalClause']['isAgree']}}</span></div></td>
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
    
                                                    @if(isset($pipeline_details['formData']['mainClause']) && $pipeline_details['formData']['mainClause'] == true)
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['mainClause']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_mainClause_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='mainClause_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                            value='{{$insures_details[$i]['mainClause']}}' required><label class='error'
                                                                            id='mainClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='mainClause'
                                                                            onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                            value='mainClause' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{$insures_details[$i]['mainClause']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
    
                                                    @if(isset($pipeline_details['formData']['repairCost']) && $pipeline_details['formData']['repairCost'] == true)
                                                        <tr>
                                                            <?php $insure_count=count(@$insures_details);?>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['repairCost']['isAgree']))
                                                                            @if(@$insures_details[$i]['repairCost']['comment']!="")
                                                                                <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                    <div class="ans">
                                                                                        <span id="div_repairCost_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                        data-content="<input id='repairCost_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['repairCost']['isAgree']}}'>
                                                                                        <label class='error' id='repairCost_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='repairCost' onclick='fun(this)'>Update</button>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='repairCost' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                        data-container="body">{{@$insures_details[$i]['repairCost']['isAgree']}}
                                                                                    </span>
                                                                                       
                                                                                            <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['repairCost']['comment']}}</span>        
                                                                                                        </div>
                                                                                                        <div class="media-right">
                                                                                                            <span id="cancel_repairCost_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                            data-content="<input id='repairCost_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['repairCost']['comment']}}'>
                                                                                            <label class='error' id='repairCost_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                            </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='repairCost' onclick='commentEdit(this)'>Update</button>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='repairCost' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
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
                                                                                    <span id="div_repairCost_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                    title="Edit existing value" data-html="true" data-content="<input id='repairCost_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['repairCost']['isAgree']}}'>
                                                                                    <label class='error' id='repairCost_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='repairCost' onclick='fun(this)'>Update</button>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='repairCost' onclick='cancel(this)'>
                                                                                    <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['repairCost']['isAgree']}}</span></div></td>
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
    
                                                    @if(isset($pipeline_details['formData']['reinstatementValClass']) && $pipeline_details['formData']['reinstatementValClass'] == true)
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['reinstatementValClass']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_reinstatementValClass_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='reinstatementValClass_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                            value='{{$insures_details[$i]['reinstatementValClass']}}' required><label class='error'
                                                                            id='reinstatementValClass_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='reinstatementValClass'
                                                                            onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                            value='reinstatementValClass' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{$insures_details[$i]['reinstatementValClass']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
    
    
                                                    @if(isset($pipeline_details['formData']['waiver']) && $pipeline_details['formData']['waiver'] == true)
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['waiver']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_waiver_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='waiver_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                            value='{{$insures_details[$i]['waiver']}}' required><label class='error'
                                                                            id='waiver_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='waiver'
                                                                            onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                            value='waiver' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{$insures_details[$i]['waiver']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
    
                                                    @if(isset($pipeline_details['formData']['trace']) && $pipeline_details['formData']['trace'] == true)
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['trace']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">
                                                                                <span id="div_trace_{{$insures_details[$i]['uniqueToken']}}"
                                                                                data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                data-content="<input id='trace_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                            value='{{$insures_details[$i]['trace']}}' required><label class='error'
                                                                            id='trace_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='trace'
                                                                            onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                            value='trace' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                data-container="body">{{$insures_details[$i]['trace']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
    
                                                    @if(isset($pipeline_details['formData']['publicClause']) && $pipeline_details['formData']['publicClause'] == true)
                                                        <tr>
                                                            <?php $insure_count=count(@$insures_details);?>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['publicClause']['isAgree']))
                                                                            @if(@$insures_details[$i]['publicClause']['comment']!="")
                                                                                <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                    <div class="ans">
                                                                                        <span id="div_publicClause_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                        data-content="<input id='publicClause_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['publicClause']['isAgree']}}'>
                                                                                        <label class='error' id='publicClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='publicClause' onclick='fun(this)'>Update</button>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='publicClause' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                        data-container="body">{{@$insures_details[$i]['publicClause']['isAgree']}}</span>
                                                                                        
                                                                                            <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['publicClause']['comment']}}</span>        
                                                                                                        </div>
                                                                                                        <div class="media-right">
                                                                                                            <span id="cancel_publicClause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                            data-content="<input id='publicClause_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['publicClause']['comment']}}'>
                                                                                                                <label class='error' id='publicClause_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                                </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='publicClause' onclick='commentEdit(this)'>Update</button>
                                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='publicClause' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
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
                                                                                    <span id="div_publicClause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                    title="Edit existing value" data-html="true" data-content="<input id='publicClause_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['publicClause']['isAgree']}}'>
                                                                                    <label class='error' id='publicClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='publicClause' onclick='fun(this)'>Update</button>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='publicClause' onclick='cancel(this)'>
                                                                                    <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['publicClause']['isAgree']}}</span></div></td>
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
    
                                                    @if(isset($pipeline_details['formData']['contentsClause']) && $pipeline_details['formData']['contentsClause'] == true)
                                                        <tr>
                                                            <?php $insure_count=count(@$insures_details);?>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['contentsClause']['isAgree']))
                                                                            @if(@$insures_details[$i]['contentsClause']['comment']!="")
                                                                                <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                    <div class="ans">
                                                                                        <span id="div_contentsClause_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                        data-content="<input id='contentsClause_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['contentsClause']['isAgree']}}'>
                                                                                        <label class='error' id='contentsClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='contentsClause' onclick='fun(this)'>Update</button>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='contentsClause' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                        data-container="body">{{@$insures_details[$i]['contentsClause']['isAgree']}}
                                                                                    </span>
                                                                                      
                                                                                            <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['contentsClause']['comment']}}</span>        
                                                                                                        </div>
                                                                                                        <div class="media-right">
                                                                                                            <span id="cancel_contentsClause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                            data-content="<input id='contentsClause_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['contentsClause']['comment']}}'>
                                                                                                                <label class='error' id='contentsClause_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                                </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='contentsClause' onclick='commentEdit(this)'>Update</button>
                                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='contentsClause' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
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
                                                                                    <span id="div_contentsClause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                    title="Edit existing value" data-html="true" data-content="<input id='contentsClause_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['contentsClause']['isAgree']}}'>
                                                                                    <label class='error' id='contentsClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='contentsClause' onclick='fun(this)'>Update</button>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='contentsClause' onclick='cancel(this)'>
                                                                                    <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['contentsClause']['isAgree']}}</span></div></td>
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
    
                                                    @if(isset($pipeline_details['formData']['errorOmission']) && $pipeline_details['formData']['errorOmission'] == true)
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['errorOmission']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_errorOmission_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='errorOmission_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                            value='{{$insures_details[$i]['errorOmission']}}' required><label class='error'
                                                                            id='errorOmission_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='errorOmission'
                                                                            onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                            value='errorOmission' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{$insures_details[$i]['errorOmission']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
    
                                                    @if(isset($pipeline_details['formData']['alterationClause']) && $pipeline_details['formData']['alterationClause'] == true)
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['alterationClause']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_alterationClause_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='alterationClause_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                            value='{{$insures_details[$i]['alterationClause']}}' required><label class='error'
                                                                            id='alterationClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='alterationClause'
                                                                            onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                            value='alterationClause' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{$insures_details[$i]['alterationClause']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
    
                                                    @if(isset($pipeline_details['formData']['tempRemovalClause']) && $pipeline_details['formData']['tempRemovalClause'] == true)
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['tempRemovalClause']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_tempRemovalClause_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='tempRemovalClause_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                            value='{{$insures_details[$i]['tempRemovalClause']}}' required><label class='error'
                                                                            id='tempRemovalClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='tempRemovalClause'
                                                                            onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                            value='tempRemovalClause' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{$insures_details[$i]['tempRemovalClause']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
    
                                                    @if(isset($pipeline_details['formData']['proFee']) && $pipeline_details['formData']['proFee'] == true)
                                                        <tr>
                                                            <?php $insure_count=count(@$insures_details);?>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['proFee']['isAgree']))
                                                                            @if(@$insures_details[$i]['proFee']['comment']!="")
                                                                                <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                    <div class="ans">
                                                                                        <span id="div_proFee_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                        data-content="<input id='proFee_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['proFee']['isAgree']}}'>
                                                                                        <label class='error' id='proFee_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='proFee' onclick='fun(this)'>Update</button>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='proFee' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                        data-container="body">{{@$insures_details[$i]['proFee']['isAgree']}}
                                                                                    </span>
                                                                                        
                                                                                            <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['proFee']['comment']}}</span>        
                                                                                                        </div>
                                                                                                        <div class="media-right">
                                                                                                            <span id="cancel_proFee_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                            data-content="<input id='proFee_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['proFee']['comment']}}'>
                                                                                            <label class='error' id='proFee_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                            </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='proFee' onclick='commentEdit(this)'>Update</button>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='proFee' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
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
                                                                                    <span id="div_proFee_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                    title="Edit existing value" data-html="true" data-content="<input id='proFee_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['proFee']['isAgree']}}'>
                                                                                    <label class='error' id='proFee_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='proFee' onclick='fun(this)'>Update</button>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='proFee' onclick='cancel(this)'>
                                                                                    <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['proFee']['isAgree']}}</span></div></td>
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
    
    
                                                    @if(isset($pipeline_details['formData']['expenseClause']) && $pipeline_details['formData']['expenseClause'] == true)
                                                        <tr>
                                                            <?php $insure_count=count(@$insures_details);?>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['expenseClause']['isAgree']))
                                                                            @if(@$insures_details[$i]['expenseClause']['comment']!="")
                                                                                <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                    <div class="ans">
                                                                                        <span id="div_expenseClause_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                            data-content="<input id='expenseClause_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['expenseClause']['isAgree']}}'>
                                                                                        <label class='error' id='expenseClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='expenseClause' onclick='fun(this)'>Update</button>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='expenseClause' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                            data-container="body">{{@$insures_details[$i]['expenseClause']['isAgree']}}
                                                                                        </span>
                                                                                        
                                                                                              <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['expenseClause']['comment']}}</span>        
                                                                                                        </div>
                                                                                                        <div class="media-right">
                                                                                                            <span id="cancel_expenseClause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                            data-content="<input id='expenseClause_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['expenseClause']['comment']}}'>
                                                                                                              <label class='error' id='expenseClause_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                              </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='expenseClause' onclick='commentEdit(this)'>Update</button>
                                                                                                              <button name='{{$insures_details[$i]['uniqueToken']}}' value='expenseClause' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
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
                                                                                    <span id="div_expenseClause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                        title="Edit existing value" data-html="true" data-content="<input id='expenseClause_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['expenseClause']['isAgree']}}'>
                                                                                    <label class='error' id='expenseClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='expenseClause' onclick='fun(this)'>Update</button>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='expenseClause' onclick='cancel(this)'>
                                                                                    <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['expenseClause']['isAgree']}}</span></div></td>
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
    
                                                    @if(isset($pipeline_details['formData']['desigClause']) && $pipeline_details['formData']['desigClause'] == true)
                                                        <tr>
                                                            <?php $insure_count=count(@$insures_details);?>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['desigClause']['isAgree']))
                                                                            @if(@$insures_details[$i]['desigClause']['comment']!="")
                                                                                <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                    <div class="ans">
                                                                                    <span id="div_desigClause_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                    data-content="<input id='desigClause_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['desigClause']['isAgree']}}'>
                                                                                    <label class='error' id='desigClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='desigClause' onclick='fun(this)'>Update</button>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='desigClause' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                    data-container="body">{{@$insures_details[$i]['desigClause']['isAgree']}}
                                                                                </span>
                                                                                      
                                                                                            <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['desigClause']['comment']}}</span>        
                                                                                                        </div>
                                                                                                        <div class="media-right">
                                                                                                            <span id="cancel_desigClause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                            data-content="<input id='desigClause_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['desigClause']['comment']}}'>
                                                                                                            <label class='error' id='desigClause_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                            </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='desigClause' onclick='commentEdit(this)'>Update</button>
                                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='desigClause' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
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
                                                                                    <span id="div_desigClause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                    title="Edit existing value" data-html="true" data-content="<input id='desigClause_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['desigClause']['isAgree']}}'>
                                                                                    <label class='error' id='desigClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='desigClause' onclick='fun(this)'>Update</button>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='desigClause' onclick='cancel(this)'>
                                                                                    <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['desigClause']['isAgree']}}</span></div></td>
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
    
                                                    @if(isset($pipeline_details['formData']['buildingInclude']) && $pipeline_details['formData']['buildingInclude'] == true)    
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
                                                                                <span id='div_adjBusinessClause_{{$insures_details[$i]['uniqueToken']}}'
                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
                                                                                    <input id='adjBusinessClause_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['adjBusinessClause']?:'--'}}' required>
                                                                                    <label class='error' id='adjBusinessClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='adjBusinessClause' onclick='fun(this)'>Update</button>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='adjBusinessClause' onclick='cancel(this)'>
                                                                                    <i class='material-icons'>close</i></button>"
                                                                                    data-container="body">{{$insures_details[$i]['adjBusinessClause']?:'--'}}
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
    
                                                    @if(isset($pipeline_details['formData']['cancelThirtyClause']) && $pipeline_details['formData']['cancelThirtyClause'] == true)
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['cancelThirtyClause']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_cancelThirtyClause_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='cancelThirtyClause_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                            value='{{$insures_details[$i]['cancelThirtyClause']}}' required><label class='error'
                                                                            id='cancelThirtyClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='cancelThirtyClause'
                                                                            onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                            value='cancelThirtyClause' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{$insures_details[$i]['cancelThirtyClause']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
    
                                                    @if(isset($pipeline_details['formData']['primaryInsuranceClause']) && $pipeline_details['formData']['primaryInsuranceClause'] == true)
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['primaryInsuranceClause']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_primaryInsuranceClause_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='primaryInsuranceClause_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                                value='{{$insures_details[$i]['primaryInsuranceClause']}}' required><label class='error'
                                                                                id='primaryInsuranceClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='primaryInsuranceClause'
                                                                                onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                                value='primaryInsuranceClause' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{$insures_details[$i]['primaryInsuranceClause']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
    
                                                    @if(isset($pipeline_details['formData']['paymentAccountClause']) && $pipeline_details['formData']['paymentAccountClause'] == true)
                                                        <tr>
                                                            <?php $insure_count=count(@$insures_details);?>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['paymentAccountClause']['isAgree']))
                                                                            @if(@$insures_details[$i]['paymentAccountClause']['comment']!="")
                                                                                <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                    <div class="ans">
                                                                                        <span id="div_paymentAccountClause_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                            data-content="<input id='paymentAccountClause_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['paymentAccountClause']['isAgree']}}'>
                                                                                        <label class='error' id='paymentAccountClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='paymentAccountClause' onclick='fun(this)'>Update</button>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='paymentAccountClause' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                            data-container="body">{{@$insures_details[$i]['paymentAccountClause']['isAgree']}}
                                                                                        </span>
                                                                                      
                                                                                              <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['paymentAccountClause']['comment']}}</span>        
                                                                                                        </div>
                                                                                                        <div class="media-right">
                                                                                                            <span id="cancel_paymentAccountClause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                              data-content="<input id='paymentAccountClause_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['paymentAccountClause']['comment']}}'>
                                                                                                <label class='error' id='paymentAccountClause_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='paymentAccountClause' onclick='commentEdit(this)'>Update</button>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='paymentAccountClause' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
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
                                                                                    <span id="div_paymentAccountClause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                        title="Edit existing value" data-html="true" data-content="<input id='paymentAccountClause_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['paymentAccountClause']['isAgree']}}'>
                                                                                    <label class='error' id='paymentAccountClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='paymentAccountClause' onclick='fun(this)'>Update</button>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='paymentAccountClause' onclick='cancel(this)'>
                                                                                    <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['paymentAccountClause']['isAgree']}}</span></div></td>
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
    
                                                     
                                                    @if(isset($pipeline_details['formData']['nonInvalidClause']) && $pipeline_details['formData']['nonInvalidClause'] == true)
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['nonInvalidClause']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_nonInvalidClause_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='nonInvalidClause_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                                value='{{$insures_details[$i]['nonInvalidClause']}}' required><label class='error'
                                                                                id='nonInvalidClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='nonInvalidClause'
                                                                                onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                                value='nonInvalidClause' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{$insures_details[$i]['nonInvalidClause']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
    
                                                    @if(isset($pipeline_details['formData']['warrantyConditionClause']) && $pipeline_details['formData']['warrantyConditionClause'] == true)
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['warrantyConditionClause']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_warrantyConditionClause_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='warrantyConditionClause_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                                value='{{$insures_details[$i]['warrantyConditionClause']}}' required><label class='error'
                                                                                id='warrantyConditionClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='warrantyConditionClause'
                                                                                onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                                value='warrantyConditionClause' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{$insures_details[$i]['warrantyConditionClause']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
    
    
                                                    @if(isset($pipeline_details['formData']['escalationClause']) && $pipeline_details['formData']['escalationClause'] == true)
                                                        <tr>
                                                            <?php $insure_count=count(@$insures_details);?>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['escalationClause']['isAgree']))
                                                                            @if(@$insures_details[$i]['escalationClause']['comment']!="")
                                                                                <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                    <div class="ans">
                                                                                    <span id="div_escalationClause_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                        data-content="<input id='escalationClause_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['escalationClause']['isAgree']}}'>
                                                                                    <label class='error' id='escalationClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='escalationClause' onclick='fun(this)'>Update</button>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='escalationClause' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                        data-container="body">{{@$insures_details[$i]['escalationClause']['isAgree']}}
                                                                                    </span>
                                                                                     
                                                                                              <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['escalationClause']['comment']}}</span>        
                                                                                                        </div>
                                                                                                        <div class="media-right">
                                                                                                            <span id="cancel_escalationClause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                            data-content="<input id='escalationClause_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['escalationClause']['comment']}}'>
                                                                                                              <label class='error' id='escalationClause_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                              </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='escalationClause' onclick='commentEdit(this)'>Update</button>
                                                                                                              <button name='{{$insures_details[$i]['uniqueToken']}}' value='escalationClause' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
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
                                                                                    <span id="div_escalationClause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                        title="Edit existing value" data-html="true" data-content="<input id='escalationClause_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['escalationClause']['isAgree']}}'>
                                                                                    <label class='error' id='escalationClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='escalationClause' onclick='fun(this)'>Update</button>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='escalationClause' onclick='cancel(this)'>
                                                                                    <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['escalationClause']['isAgree']}}</span></div></td>
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
    
                                                    @if(isset($pipeline_details['formData']['addInterestClause']) && $pipeline_details['formData']['addInterestClause'] == true)
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['addInterestClause']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_addInterestClause_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='addInterestClause_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                                value='{{$insures_details[$i]['addInterestClause']}}' required><label class='error'
                                                                                id='addInterestClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='addInterestClause'
                                                                                onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                                value='addInterestClause' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{$insures_details[$i]['addInterestClause']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
    
    
    
                                                    @if(isset($pipeline_details['formData']['stock']) && $pipeline_details['formData']['stock']!='')
                                                        <tr>
                                                            <?php $insure_count=count(@$insures_details);?>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
                                                                        @if(isset($insures_details[$i]['stockDeclaration']['isAgree']))
                                                                            @if(@$insures_details[$i]['stockDeclaration']['comment']!="")
                                                                                <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                    <div class="ans">
                                                                                            <span id="div_stockDeclaration_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                            data-content="<input id='stockDeclaration_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['stockDeclaration']['isAgree']}}'>
                                                                                            <label class='error' id='stockDeclaration_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='stockDeclaration' onclick='fun(this)'>Update</button>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='stockDeclaration' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                            data-container="body">{{@$insures_details[$i]['stockDeclaration']['isAgree']}}
                                                                                        </span>
                                                                                        
                                                                                            <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['stockDeclaration']['comment']}}</span>        
                                                                                                        </div>
                                                                                                        <div class="media-right">
                                                                                                            <span id="cancel_stockDeclaration_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                            data-content="<input id='stockDeclaration_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['stockDeclaration']['comment']}}'>
                                                                                                                <label class='error' id='stockDeclaration_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                                </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='stockDeclaration' onclick='commentEdit(this)'>Update</button>
                                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='stockDeclaration' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
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
                                                                                    <span id="div_stockDeclaration_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                    title="Edit existing value" data-html="true" data-content="<input id='stockDeclaration_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['stockDeclaration']['isAgree']}}'>
                                                                                    <label class='error' id='stockDeclaration_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='stockDeclaration' onclick='fun(this)'>Update</button>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='stockDeclaration' onclick='cancel(this)'>
                                                                                    <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['stockDeclaration']['isAgree']}}</span></div></td>
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
    
    
                                                    @if(isset($pipeline_details['formData']['improvementClause']) && $pipeline_details['formData']['improvementClause'] == true)
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['improvementClause']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_improvementClause_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='improvementClause_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                                value='{{$insures_details[$i]['improvementClause']}}' required><label class='error'
                                                                                id='improvementClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='improvementClause'
                                                                                onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                                value='improvementClause' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{$insures_details[$i]['improvementClause']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
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
    
                                                    @if(isset($pipeline_details['formData']['reduseLoseClause']) && $pipeline_details['formData']['reduseLoseClause'] == true)
                                                        <tr>
                                                            <?php $insure_count=count(@$insures_details);?>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['reduseLoseClause']['isAgree']))
                                                                            @if(@$insures_details[$i]['reduseLoseClause']['comment']!="")
                                                                                <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                    <div class="ans">
                                                                                    <span id="div_reduseLoseClause_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                        data-content="<input id='reduseLoseClause_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['reduseLoseClause']['isAgree']}}'>
                                                                                    <label class='error' id='reduseLoseClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='reduseLoseClause' onclick='fun(this)'>Update</button>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='reduseLoseClause' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                        data-container="body">{{@$insures_details[$i]['reduseLoseClause']['isAgree']}}
                                                                                    </span>
                                                                                      
                                                                                              <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['reduseLoseClause']['comment']}}</span>        
                                                                                                        </div>
                                                                                                        <div class="media-right">
                                                                                                            <span id="cancel_reduseLoseClause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                            data-content="<input id='reduseLoseClause_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['reduseLoseClause']['comment']}}'>
                                                                                                              <label class='error' id='reduseLoseClause_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                              </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='reduseLoseClause' onclick='commentEdit(this)'>Update</button>
                                                                                                              <button name='{{$insures_details[$i]['uniqueToken']}}' value='reduseLoseClause' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
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
                                                                                    <span id="div_reduseLoseClause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                        title="Edit existing value" data-html="true" data-content="<input id='reduseLoseClause_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['reduseLoseClause']['isAgree']}}'>
                                                                                    <label class='error' id='reduseLoseClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='reduseLoseClause' onclick='fun(this)'>Update</button>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='reduseLoseClause' onclick='cancel(this)'>
                                                                                    <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['reduseLoseClause']['isAgree']}}</span></div></td>
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
                                                    
                                                    @if(isset($pipeline_details['formData']['buildingInclude']) && $pipeline_details['formData']['demolitionClause'] == true)    
                                                    <tr>
                                                            <?php $insure_count=count(@$insures_details);?>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['demolitionClause']['isAgree']))
                                                                            @if(@$insures_details[$i]['demolitionClause']['comment']!="")
                                                                                <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                    <div class="ans">
                                                                                    <span id="div_demolitionClause_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                        data-content="<input id='demolitionClause_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['demolitionClause']['isAgree']}}'>
                                                                                    <label class='error' id='demolitionClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='demolitionClause' onclick='fun(this)'>Update</button>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='demolitionClause' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                        data-container="body">{{@$insures_details[$i]['demolitionClause']['isAgree']}}
                                                                                    </span>
                                                                                       
                                                                                              <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['demolitionClause']['comment']}}</span>        
                                                                                                        </div>
                                                                                                        <div class="media-right">
                                                                                                            <span id="cancel_demolitionClause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                              data-content="<input id='demolitionClause_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['demolitionClause']['comment']}}'>
                                                                                                <label class='error' id='demolitionClause_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='demolitionClause' onclick='commentEdit(this)'>Update</button>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='demolitionClause' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
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
                                                                                    <span id="div_demolitionClause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                        title="Edit existing value" data-html="true" data-content="<input id='demolitionClause{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['demolitionClause']['isAgree']}}'>
                                                                                    <label class='error' id='demolitionClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='demolitionClause' onclick='fun(this)'>Update</button>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='demolitionClause' onclick='cancel(this)'>
                                                                                    <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['demolitionClause']['isAgree']}}</span></div></td>
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
    
                                                    @if(isset($pipeline_details['formData']['noControlClause']) && $pipeline_details['formData']['noControlClause'] == true)
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['noControlClause']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_noControlClause_{{$insures_details[$i]['uniqueToken']}}"
                                                                            data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                            data-content="<input id='noControlClause_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                            value='{{$insures_details[$i]['noControlClause']}}' required><label class='error'
                                                                            id='noControlClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='noControlClause'
                                                                            onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                            value='noControlClause' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{$insures_details[$i]['noControlClause']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
    
                                                    @if(isset($pipeline_details['formData']['preparationCostClause']) && $pipeline_details['formData']['preparationCostClause'] == true)
                                                        <tr>
                                                            <?php $insure_count=count(@$insures_details);?>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['preparationCostClause']['isAgree']))
                                                                            @if(@$insures_details[$i]['preparationCostClause']['comment']!="")
                                                                                <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                    <div class="ans">
                                                                                        <span id="div_preparationCostClause_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                            data-content="<input id='preparationCostClause_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['preparationCostClause']['isAgree']}}'>
                                                                                        <label class='error' id='preparationCostClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='preparationCostClause' onclick='fun(this)'>Update</button>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='preparationCostClause' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                            data-container="body">{{@$insures_details[$i]['preparationCostClause']['isAgree']}}
                                                                                        </span>
                                                                                       
                                                                                              <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['preparationCostClause']['comment']}}</span>        
                                                                                                        </div>
                                                                                                        <div class="media-right">
                                                                                                            <span id="cancel_preparationCostClause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                              data-content="<input id='preparationCostClause_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['preparationCostClause']['comment']}}'>
                                                                                                <label class='error' id='preparationCostClause_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='preparationCostClause' onclick='commentEdit(this)'>Update</button>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='preparationCostClause' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
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
                                                                                        <span id="div_preparationCostClause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                            title="Edit existing value" data-html="true" data-content="<input id='preparationCostClause_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['preparationCostClause']['isAgree']}}'>
                                                                                        <label class='error' id='preparationCostClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='preparationCostClause' onclick='fun(this)'>Update</button>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='preparationCostClause' onclick='cancel(this)'>
                                                                                        <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['preparationCostClause']['isAgree']}}</span></div></td>
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
    
                                                    @if($pipeline_details['formData']['coverPropertyCon'] == true)
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['coverPropertyCon']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_coverPropertyCon_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='coverPropertyCon_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                        value='{{$insures_details[$i]['coverPropertyCon']}}' required><label class='error'
                                                                        id='coverPropertyCon_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='coverPropertyCon'
                                                                        onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                        value='coverPropertyCon' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{$insures_details[$i]['coverPropertyCon']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
    
                                                    @if($pipeline_details['formData']['personalEffectsEmployee'] == true)
                                                        <tr>
                                                            <?php $insure_count=count(@$insures_details);?>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['personalEffectsEmployee']['isAgree']))
                                                                            @if(@$insures_details[$i]['personalEffectsEmployee']['comment']!="")
                                                                                <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                    <div class="ans">
                                                                                        <span id="div_personalEffectsEmployee_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                        data-content="<input id='personalEffectsEmployee_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['personalEffectsEmployee']['isAgree']}}'>
                                                                                        <label class='error' id='personalEffectsEmployee_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='personalEffectsEmployee' onclick='fun(this)'>Update</button>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='personalEffectsEmployee' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                        data-container="body">{{@$insures_details[$i]['personalEffectsEmployee']['isAgree']}}
                                                                                    </span>
                                                                                      
                                                                                            <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['personalEffectsEmployee']['comment']}}</span>        
                                                                                                        </div>
                                                                                                        <div class="media-right">
                                                                                                            <span id="cancel_personalEffectsEmployee_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                            data-content="<input id='personalEffectsEmployee_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['personalEffectsEmployee']['comment']}}'>
                                                                                                                <label class='error' id='personalEffectsEmployee_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                                </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='personalEffectsEmployee' onclick='commentEdit(this)'>Update</button>
                                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='personalEffectsEmployee' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
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
                                                                                    <span id="div_personalEffectsEmployee_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                    title="Edit existing value" data-html="true" data-content="<input id='personalEffectsEmployee_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['personalEffectsEmployee']['isAgree']}}'>
                                                                                    <label class='error' id='personalEffectsEmployee_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='personalEffectsEmployee' onclick='fun(this)'>Update</button>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='personalEffectsEmployee' onclick='cancel(this)'>
                                                                                    <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['personalEffectsEmployee']['isAgree']}}</span></div></td>
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
    
                                                    @if($pipeline_details['formData']['incidentLandTransit'] == true)
                                                        <tr>
                                                            <?php $insure_count=count(@$insures_details);?>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['incidentLandTransit']['isAgree']))
                                                                            @if(@$insures_details[$i]['incidentLandTransit']['comment']!="")
                                                                                <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                    <div class="ans">
                                                                                        <span id="div_incidentLandTransit_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                            data-content="<input id='incidentLandTransit_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['incidentLandTransit']['isAgree']}}'>
                                                                                        <label class='error' id='incidentLandTransit_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='incidentLandTransit' onclick='fun(this)'>Update</button>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='incidentLandTransit' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                            data-container="body">{{@$insures_details[$i]['incidentLandTransit']['isAgree']}}
                                                                                        </span>
                                                                                        
                                                                                              <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['incidentLandTransit']['comment']}}</span>        
                                                                                                        </div>
                                                                                                        <div class="media-right">
                                                                                                            <span id="cancel_incidentLandTransit_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                            data-content="<input id='incidentLandTransit_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['incidentLandTransit']['comment']}}'>
                                                                                                              <label class='error' id='incidentLandTransit_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                              </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='incidentLandTransit' onclick='commentEdit(this)'>Update</button>
                                                                                                              <button name='{{$insures_details[$i]['uniqueToken']}}' value='incidentLandTransit' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
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
                                                                                        <span id="div_incidentLandTransit_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                            title="Edit existing value" data-html="true" data-content="<input id='incidentLandTransit_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['incidentLandTransit']['isAgree']}}'>
                                                                                        <label class='error' id='incidentLandTransit_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='incidentLandTransit' onclick='fun(this)'>Update</button>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='incidentLandTransit' onclick='cancel(this)'>
                                                                                        <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['incidentLandTransit']['isAgree']}}</span></div></td>
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
    
                                                    @if($pipeline_details['formData']['lossOrDamage'] == true)
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['lossOrDamage']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_lossOrDamage_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='lossOrDamage_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                            value='{{$insures_details[$i]['lossOrDamage']}}' required><label class='error'
                                                                            id='lossOrDamage_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='lossOrDamage'
                                                                            onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                            value='lossOrDamage' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{$insures_details[$i]['lossOrDamage']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
    
                                                    @if($pipeline_details['formData']['nominatedLossAdjusterClause'] == true)
                                                        <tr>
                                                            <?php $insure_count=count(@$insures_details);?>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['nominatedLossAdjusterClause']['isAgree']))
                                                                            @if(@$insures_details[$i]['nominatedLossAdjusterClause']['comment']!="")
                                                                                <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                    <div class="ans">
                                                                                        <span id="div_nominatedLossAdjusterClause_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                        data-content="<input id='nominatedLossAdjusterClause_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['nominatedLossAdjusterClause']['isAgree']}}'>
                                                                                        <label class='error' id='nominatedLossAdjusterClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='nominatedLossAdjusterClause' onclick='fun(this)'>Update</button>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='nominatedLossAdjusterClause' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                        data-container="body">{{@$insures_details[$i]['nominatedLossAdjusterClause']['isAgree']}}
                                                                                    </span>
                                                                                      
                                                                                            <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['nominatedLossAdjusterClause']['comment']}}</span>        
                                                                                                        </div>
                                                                                                        <div class="media-right">
                                                                                                            <span id="cancel_nominatedLossAdjusterClause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                            data-content="<input id='nominatedLossAdjusterClause_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['nominatedLossAdjusterClause']['comment']}}'>
                                                                                                            <label class='error' id='nominatedLossAdjusterClause_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                            </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='nominatedLossAdjusterClause' onclick='commentEdit(this)'>Update</button>
                                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='nominatedLossAdjusterClause' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
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
                                                                                    <span id="div_nominatedLossAdjusterClause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                    title="Edit existing value" data-html="true" data-content="<input id='nominatedLossAdjusterClause_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['nominatedLossAdjusterClause']['isAgree']}}'>
                                                                                    <label class='error' id='nominatedLossAdjusterClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='nominatedLossAdjusterClause' onclick='fun(this)'>Update</button>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='nominatedLossAdjusterClause' onclick='cancel(this)'>
                                                                                    <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['nominatedLossAdjusterClause']['isAgree']}}</span></div></td>
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
    
                                                    @if($pipeline_details['formData']['sprinkerLeakage'] == true)
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['sprinkerLeakage']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_sprinkerLeakage_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='sprinkerLeakage_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                            value='{{$insures_details[$i]['sprinkerLeakage']}}' required><label class='error'
                                                                            id='sprinkerLeakage_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='sprinkerLeakage'
                                                                            onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                            value='sprinkerLeakage' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{$insures_details[$i]['sprinkerLeakage']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
    
                                                    @if($pipeline_details['formData']['minLossClause'] == true)
                                                        <tr>
                                                            <?php $insure_count=count(@$insures_details);?>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['minLossClause']['isAgree']))
                                                                            @if(@$insures_details[$i]['minLossClause']['comment']!="")
                                                                                <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                    <div class="ans">
                                                                                        <span id="div_minLossClause_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                        data-content="<input id='minLossClause_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['minLossClause']['isAgree']}}'>
                                                                                        <label class='error' id='minLossClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='minLossClause' onclick='fun(this)'>Update</button>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='minLossClause' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                        data-container="body">{{@$insures_details[$i]['minLossClause']['isAgree']}}
                                                                                    </span>
                                                                                       
                                                                                            <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['minLossClause']['comment']}}</span>        
                                                                                                        </div>
                                                                                                        <div class="media-right">
                                                                                                            <span id="cancel_minLossClause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                            data-content="<input id='minLossClause_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['minLossClause']['comment']}}'>
                                                                                            <label class='error' id='minLossClause_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                            </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='minLossClause' onclick='commentEdit(this)'>Update</button>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='minLossClause' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
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
                                                                                    <span id="div_minLossClause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                    title="Edit existing value" data-html="true" data-content="<input id='minLossClause_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['minLossClause']['isAgree']}}'>
                                                                                    <label class='error' id='minLossClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='minLossClause' onclick='fun(this)'>Update</button>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='minLossClause' onclick='cancel(this)'>
                                                                                    <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['minLossClause']['isAgree']}}</span></div></td>
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
    
                                                    @if($pipeline_details['formData']['costConstruction'] == true)
                                                        <tr>
                                                            <?php $insure_count=count(@$insures_details);?>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['costConstruction']['isAgree']))
                                                                            @if(@$insures_details[$i]['costConstruction']['comment']!="")
                                                                                <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                    <div class="ans">
                                                                                        <span id="div_costConstruction_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                        data-content="<input id='costConstruction_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['costConstruction']['isAgree']}}'>
                                                                                        <label class='error' id='costConstruction_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='costConstruction' onclick='fun(this)'>Update</button>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='costConstruction' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                        data-container="body">{{@$insures_details[$i]['costConstruction']['isAgree']}}
                                                                                    </span>
                                                                                       
                                                                                            <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['costConstruction']['comment']}}</span>        
                                                                                                        </div>
                                                                                                        <div class="media-right">
                                                                                                            <span id="cancel_costConstruction_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                            data-content="<input id='costConstruction_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['costConstruction']['comment']}}'>
                                                                                                            <label class='error' id='costConstruction_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                            </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='costConstruction' onclick='commentEdit(this)'>Update</button>
                                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='costConstruction' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
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
                                                                                <span id="div_costConstruction_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                title="Edit existing value" data-html="true" data-content="<input id='costConstruction_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['costConstruction']['isAgree']}}'>
                                                                                <label class='error' id='costConstruction_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='costConstruction' onclick='fun(this)'>Update</button>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='costConstruction' onclick='cancel(this)'>
                                                                                <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['costConstruction']['isAgree']}}</span></div></td>
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
    
                                                    @if(isset($pipeline_details['formData']['annualRent']) && $pipeline_details['formData']['annualRent']!='')
                                                        
                                                        <tr>
                                                            <?php $insure_count=count(@$insures_details);?>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
                                                                        @if(isset($insures_details[$i]['lossRent']['isAgree']))
                                                                            @if(@$insures_details[$i]['lossRent']['comment']!="")
                                                                                <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                    <div class="ans">
                                                                                        <span id="div_lossRent_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                        data-content="<input id='lossRent_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['lossRent']['isAgree']}}'>
                                                                                        <label class='error' id='lossRent_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='lossRent' onclick='fun(this)'>Update</button>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='lossRent' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                        data-container="body">{{@$insures_details[$i]['lossRent']['isAgree']}}
                                                                                    </span>
                                                                                       
                                                                                            <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['lossRent']['comment']}}</span>        
                                                                                                        </div>
                                                                                                        <div class="media-right">
                                                                                                            <span id="cancel_lossRent_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                            data-content="<input id='lossRent_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['lossRent']['comment']}}'>
                                                                                                <label class='error' id='lossRent_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='lossRent' onclick='commentEdit(this)'>Update</button>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='lossRent' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
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
                                                                                    <span id="div_lossRent_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                    title="Edit existing value" data-html="true" data-content="<input id='lossRent_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['lossRent']['isAgree']}}'>
                                                                                    <label class='error' id='lossRent_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='lossRent' onclick='fun(this)'>Update</button>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='lossRent' onclick='cancel(this)'>
                                                                                    <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['lossRent']['isAgree']}}</span></div></td>
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
    
                                                    @if($pipeline_details['formData']['propertyValuationClause'] == true)
                                                        <tr>
                                                            <?php $insure_count=count(@$insures_details);?>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['propertyValuationClause']['isAgree']))
                                                                            @if(@$insures_details[$i]['propertyValuationClause']['comment']!="")
                                                                                <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                    <div class="ans">
                                                                                        <span id="div_propertyValuationClause_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                            data-content="<input id='propertyValuationClause_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['propertyValuationClause']['isAgree']}}'>
                                                                                        <label class='error' id='propertyValuationClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='propertyValuationClause' onclick='fun(this)'>Update</button>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='propertyValuationClause' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                            data-container="body">{{@$insures_details[$i]['propertyValuationClause']['isAgree']}}
                                                                                        </span>
                                                                                       
                                                                                              <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['propertyValuationClause']['comment']}}</span>        
                                                                                                        </div>
                                                                                                        <div class="media-right">
                                                                                                            <span id="cancel_propertyValuationClause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                              data-content="<input id='propertyValuationClause_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['propertyValuationClause']['comment']}}'>
                                                                                                <label class='error' id='propertyValuationClause_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='propertyValuationClause' onclick='commentEdit(this)'>Update</button>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='propertyValuationClause' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
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
                                                                                <span id="div_propertyValuationClause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                    title="Edit existing value" data-html="true" data-content="<input id='propertyValuationClause_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['propertyValuationClause']['isAgree']}}'>
                                                                                <label class='error' id='propertyValuationClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='propertyValuationClause' onclick='fun(this)'>Update</button>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='propertyValuationClause' onclick='cancel(this)'>
                                                                                <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['propertyValuationClause']['isAgree']}}</span></div></td>
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
    
                                                     
                                                    @if($pipeline_details['formData']['accidentalDamage'] == true)
                                                        <tr>
                                                            <?php $insure_count=count(@$insures_details);?>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['accidentalDamage']['isAgree']))
                                                                            @if(@$insures_details[$i]['accidentalDamage']['comment']!="")
                                                                                <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                    <div class="ans">
                                                                                        <span id="div_accidentalDamage_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                            data-content="<input id='accidentalDamage_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['accidentalDamage']['isAgree']}}'>
                                                                                        <label class='error' id='accidentalDamage_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='accidentalDamage' onclick='fun(this)'>Update</button>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='accidentalDamage' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                            data-container="body">{{@$insures_details[$i]['accidentalDamage']['isAgree']}}
                                                                                        </span>
                                                                                  
                                                                                              <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['accidentalDamage']['comment']}}</span>        
                                                                                                        </div>
                                                                                                        <div class="media-right">
                                                                                                            <span id="cancel_accidentalDamage_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                            data-content="<input id='accidentalDamage_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['accidentalDamage']['comment']}}'>
                                                                                                              <label class='error' id='accidentalDamage_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                              </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='accidentalDamage' onclick='commentEdit(this)'>Update</button>
                                                                                                              <button name='{{$insures_details[$i]['uniqueToken']}}' value='accidentalDamage' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
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
                                                                                    <span id="div_accidentalDamage_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                        title="Edit existing value" data-html="true" data-content="<input id='accidentalDamage_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['accidentalDamage']['isAgree']}}'>
                                                                                    <label class='error' id='accidentalDamage_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='accidentalDamage' onclick='fun(this)'>Update</button>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='accidentalDamage' onclick='cancel(this)'>
                                                                                    <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['accidentalDamage']['isAgree']}}</span></div></td>
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
    
                                                    @if($pipeline_details['formData']['auditorsFee'] == true)
                                                        <tr>
                                                            <?php $insure_count=count(@$insures_details);?>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['auditorsFee']['isAgree']))
                                                                            @if(@$insures_details[$i]['auditorsFee']['comment']!="")
                                                                                <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                    <div class="ans">
                                                                                        <span id="div_auditorsFee_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                            data-content="<input id='auditorsFee_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['auditorsFee']['isAgree']}}'>
                                                                                        <label class='error' id='auditorsFee_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='auditorsFee' onclick='fun(this)'>Update</button>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='auditorsFee' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                            data-container="body">{{@$insures_details[$i]['auditorsFee']['isAgree']}}
                                                                                        </span>
                                                                                    
                                                                                              <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['auditorsFee']['comment']}}</span>        
                                                                                                        </div>
                                                                                                        <div class="media-right">
                                                                                                            <span id="cancel_auditorsFee_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                            data-content="<input id='auditorsFee_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['auditorsFee']['comment']}}'>
                                                                                                      <label class='error' id='auditorsFee_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                      </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='auditorsFee' onclick='commentEdit(this)'>Update</button>
                                                                                                      <button name='{{$insures_details[$i]['uniqueToken']}}' value='auditorsFee' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
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
                                                                                <span id="div_auditorsFee_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                    title="Edit existing value" data-html="true" data-content="<input id='auditorsFee_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['auditorsFee']['isAgree']}}'>
                                                                                <label class='error' id='auditorsFee_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='auditorsFee' onclick='fun(this)'>Update</button>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='auditorsFee' onclick='cancel(this)'>
                                                                                <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['auditorsFee']['isAgree']}}</span></div></td>
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
    
                                                    @if($pipeline_details['formData']['smokeSoot'] == true)
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['smokeSoot']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_smokeSoot_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='smokeSoot_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                            value='{{$insures_details[$i]['smokeSoot']}}' required><label class='error'
                                                                            id='smokeSoot_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='smokeSoot'
                                                                            onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                            value='smokeSoot' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{$insures_details[$i]['smokeSoot']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
    
    
                                                    @if($pipeline_details['formData']['boilerExplosion'] == true)
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['boilerExplosion']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_boilerExplosion_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='boilerExplosion_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                            value='{{$insures_details[$i]['boilerExplosion']}}' required><label class='error'
                                                                            id='boilerExplosion_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='boilerExplosion'
                                                                            onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                            value='boilerExplosion' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{$insures_details[$i]['boilerExplosion']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
    
                                                    @if($pipeline_details['formData']['chargeAirfreight'] == true)
                                                        <tr>
                                                            <?php $insure_count=count(@$insures_details);?>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['chargeAirfreight']['isAgree']))
                                                                            @if(@$insures_details[$i]['chargeAirfreight']['comment']!="")
                                                                                <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                    <div class="ans">
                                                                                        <span id="div_chargeAirfreight_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                            data-content="<input id='chargeAirfreight_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['chargeAirfreight']['isAgree']}}'>
                                                                                        <label class='error' id='chargeAirfreight_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='chargeAirfreight' onclick='fun(this)'>Update</button>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='chargeAirfreight' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                            data-container="body">{{@$insures_details[$i]['chargeAirfreight']['isAgree']}}
                                                                                        </span>
                                                                                       
                                                                                              <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['chargeAirfreight']['comment']}}</span>        
                                                                                                        </div>
                                                                                                        <div class="media-right">
                                                                                                            <span id="cancel_chargeAirfreight_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                            data-content="<input id='chargeAirfreight_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['chargeAirfreight']['comment']}}'>
                                                                                                          <label class='error' id='chargeAirfreight_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                          </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='chargeAirfreight' onclick='commentEdit(this)'>Update</button>
                                                                                                          <button name='{{$insures_details[$i]['uniqueToken']}}' value='chargeAirfreight' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
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
                                                                                    <span id="div_chargeAirfreight_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                        title="Edit existing value" data-html="true" data-content="<input id='chargeAirfreight_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['chargeAirfreight']['isAgree']}}'>
                                                                                    <label class='error' id='chargeAirfreight_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='chargeAirfreight' onclick='fun(this)'>Update</button>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='chargeAirfreight' onclick='cancel(this)'>
                                                                                    <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['chargeAirfreight']['isAgree']}}</span></div></td>
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
    
                                                    @if($pipeline_details['formData']['tempRemoval'] == true)
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['tempRemoval']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_tempRemoval_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='tempRemoval_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                            value='{{$insures_details[$i]['tempRemoval']}}' required><label class='error'
                                                                            id='tempRemoval_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='tempRemoval'
                                                                            onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                            value='tempRemoval' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{$insures_details[$i]['tempRemoval']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
    
    
                                                    @if($pipeline_details['formData']['strikeRiot'] == true)
                                                        <tr>
                                                            <?php $insure_count=count(@$insures_details);?>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['strikeRiot']['isAgree']))
                                                                            @if(@$insures_details[$i]['strikeRiot']['comment']!="")
                                                                                <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                    <div class="ans">
                                                                                        <span id="div_strikeRiot_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                        data-content="<input id='strikeRiot_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['strikeRiot']['isAgree']}}'>
                                                                                        <label class='error' id='strikeRiot_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='strikeRiot' onclick='fun(this)'>Update</button>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='strikeRiot' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                        data-container="body">{{@$insures_details[$i]['strikeRiot']['isAgree']}}
                                                                                    </span>
                                                                                      
                                                                                            <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['strikeRiot']['comment']}}</span>        
                                                                                                        </div>
                                                                                                        <div class="media-right">
                                                                                                            <span id="cancel_strikeRiot_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                            data-content="<input id='strikeRiot_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['strikeRiot']['comment']}}'>
                                                                                                            <label class='error' id='strikeRiot_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                            </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='strikeRiot' onclick='commentEdit(this)'>Update</button>
                                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='strikeRiot' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
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
                                                                                        <span id="div_strikeRiot_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                        title="Edit existing value" data-html="true" data-content="<input id='strikeRiot_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['strikeRiot']['isAgree']}}'>
                                                                                        <label class='error' id='strikeRiot_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='strikeRiot' onclick='fun(this)'>Update</button>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='strikeRiot' onclick='cancel(this)'>
                                                                                        <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['strikeRiot']['isAgree']}}</span></div></td>
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
    
                                                    @if($pipeline_details['formData']['coverMechanical'] == true)
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['coverMechanical']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_coverMechanical_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='coverMechanical_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                        value='{{$insures_details[$i]['coverMechanical']}}' required><label class='error'
                                                                        id='coverMechanical_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='coverMechanical'
                                                                        onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                        value='coverMechanical' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{$insures_details[$i]['coverMechanical']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
    
                                                    @if($pipeline_details['formData']['coverExtWork'] == true)
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['coverExtWork']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_coverExtWork_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='coverExtWork_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                                value='{{$insures_details[$i]['coverExtWork']}}' required><label class='error'
                                                                                id='coverExtWork_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='coverExtWork'
                                                                                onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                                value='coverExtWork' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{$insures_details[$i]['coverExtWork']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
    
                                                    @if($pipeline_details['formData']['misdescriptionClause'] == true)
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['misdescriptionClause']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_misdescriptionClause_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='misdescriptionClause_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                            value='{{$insures_details[$i]['misdescriptionClause']}}' required><label class='error'
                                                                            id='misdescriptionClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='misdescriptionClause'
                                                                            onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                            value='misdescriptionClause' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{$insures_details[$i]['misdescriptionClause']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
    
                                                    @if($pipeline_details['formData']['otherInsuranceClause'] == true)
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['otherInsuranceClause']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_otherInsuranceClause_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='otherInsuranceClause_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                            value='{{$insures_details[$i]['otherInsuranceClause']}}' required><label class='error'
                                                                            id='otherInsuranceClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='otherInsuranceClause'
                                                                            onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                            value='otherInsuranceClause' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{$insures_details[$i]['otherInsuranceClause']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
    
                                                      
                                                    @if($pipeline_details['formData']['automaticAcqClause'] == true)
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['automaticAcqClause']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_automaticAcqClause_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='automaticAcqClause_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                            value='{{$insures_details[$i]['automaticAcqClause']}}' required><label class='error'
                                                                            id='automaticAcqClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='automaticAcqClause'
                                                                            onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                            value='automaticAcqClause' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{$insures_details[$i]['automaticAcqClause']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
                                                    
                                                    @if(@$pipeline_details['formData']['occupancy']['type']=='Residence' || @$pipeline_details['formData']['occupancy']['type']=='Labour Camp')
                                                        <tr>
                                                            <?php $insure_count=count(@$insures_details);?>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['coverAlternative']['isAgree']))
                                                                            @if(@$insures_details[$i]['coverAlternative']['comment']!="")
                                                                                <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                    <div class="ans">
                                                                                        <span id="div_coverAlternative_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                            data-content="<input id='coverAlternative{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['coverAlternative']['isAgree']}}'>
                                                                                            <label class='error' id='coverAlternative_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='coverAlternative' onclick='fun(this)'>Update</button>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='coverAlternative' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                            data-container="body">{{@$insures_details[$i]['coverAlternative']['isAgree']}}
                                                                                        </span>
                                                                               
                                                                                        <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details[$i]['coverAlternative']['comment']}}</span>        
                                                                                                    </div>
                                                                                                    <div class="media-right">
                                                                                                        <span id="cancel_coverAlternative_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                        data-content="<input id='coverAlternative_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['coverAlternative']['comment']}}'>
                                                                                                        <label class='error' id='coverAlternative_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                        </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='coverAlternative' onclick='commentEdit(this)'>Update</button>
                                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='coverAlternative' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
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
                                                                                        <span id="div_alternateAcco_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                        title="Edit existing value" data-html="true" data-content="<input id='coverAlternative_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['coverAlternative']['isAgree']}}'>
                                                                                        <label class='error' id='alternateAcco_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='coverAlternative' onclick='fun(this)'>Update</button>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='coverAlternative' onclick='cancel(this)'>
                                                                                        <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['coverAlternative']['isAgree']}}</span></div></td>
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
    
                                                    @if($pipeline_details['formData']['businessType'])
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['coverExihibition']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_coverExihibition_{{$insures_details[$i]['uniqueToken']}}"
                                                                            data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                            data-content="<input id='coverExihibition_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                            value='{{$insures_details[$i]['coverExihibition']}}' required><label class='error'
                                                                            id='coverExihibition_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='coverExihibition'
                                                                            onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                            value='coverExihibition' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                            data-container="body">{{$insures_details[$i]['coverExihibition']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
                                              
                                                    @if(@$pipeline_details['formData']['occupancy']['type']=='Warehouse'
                                                        ||  @$pipeline_details['formData']['occupancy']['type']=='Factory'
                                                        ||  @$pipeline_details['formData']['occupancy']['type']=='Others')
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['coverProperty']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_coverProperty_{{$insures_details[$i]['uniqueToken']}}"
                                                                            data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                            data-content="<input id='coverProperty_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                            value='{{$insures_details[$i]['coverProperty']}}' required><label class='error'
                                                                            id='coverProperty_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='coverProperty'
                                                                            onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                            value='coverProperty' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                            data-container="body">{{$insures_details[$i]['coverProperty']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
    
                                                    @if($pipeline_details['formData']['otherItems']!='')
                                                        <tr>
                                                            <?php $insure_count=count(@$insures_details);?>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['propertyCare']['isAgree']))
                                                                            @if(@$insures_details[$i]['propertyCare']['comment']!="")
                                                                                <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                    <div class="ans">
                                                                                        <span id="div_propertyCare_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                        data-content="<input id='propertyCare_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['propertyCare']['isAgree']}}'>
                                                                                        <label class='error' id='propertyCare_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='propertyCare' onclick='fun(this)'>Update</button>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='propertyCare' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                        data-container="body">{{@$insures_details[$i]['propertyCare']['isAgree']}}
                                                                                    </span>
                                                                                      
                                                                                            <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['propertyCare']['comment']}}</span>        
                                                                                                        </div>
                                                                                                        <div class="media-right">
                                                                                                            <span id="cancel_propertyCare_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                            data-content="<input id='propertyCare_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['propertyCare']['comment']}}'>
                                                                                                            <label class='error' id='propertyCare_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                            </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='propertyCare' onclick='commentEdit(this)'>Update</button>
                                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='propertyCare' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
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
                                                                                    <span id="div_propertyCare_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                    title="Edit existing value" data-html="true" data-content="<input id='propertyCare_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['propertyCare']['isAgree']}}'>
                                                                                    <label class='error' id='propertyCare_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='propertyCare' onclick='fun(this)'>Update</button>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='propertyCare' onclick='cancel(this)'>
                                                                                    <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['propertyCare']['isAgree']}}</span></div></td>
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
    
                                                    @if($pipeline_details['formData']['minorWorkExt'] == true)
                                                        <tr>
                                                            <?php $insure_count=count(@$insures_details);?>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['minorWorkExt']['isAgree']))
                                                                            @if(@$insures_details[$i]['minorWorkExt']['comment']!="")
                                                                                <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                    <div class="ans">
                                                                                        <span id="div_minorWorkExt_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                        data-content="<input id='minorWorkExt_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['minorWorkExt']['isAgree']}}'>
                                                                                        <label class='error' id='minorWorkExt_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='minorWorkExt' onclick='fun(this)'>Update</button>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='minorWorkExt' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                        data-container="body">{{@$insures_details[$i]['minorWorkExt']['isAgree']}}
                                                                                    </span>
                                                                                      
                                                                                            <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['minorWorkExt']['comment']}}</span>        
                                                                                                        </div>
                                                                                                        <div class="media-right">
                                                                                                            <span id="cancel_minorWorkExt_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                            data-content="<input id='minorWorkExt_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['minorWorkExt']['comment']}}'>
                                                                                                            <label class='error' id='minorWorkExt_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                            </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='minorWorkExt' onclick='commentEdit(this)'>Update</button>
                                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='minorWorkExt' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
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
                                                                                    <span id="div_minorWorkExt_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                    title="Edit existing value" data-html="true" data-content="<input id='minorWorkExt_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['minorWorkExt']['isAgree']}}'>
                                                                                    <label class='error' id='minorWorkExt_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='minorWorkExt' onclick='fun(this)'>Update</button>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='minorWorkExt' onclick='cancel(this)'>
                                                                                    <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['minorWorkExt']['isAgree']}}</span></div></td>
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
    
                                                    @if($pipeline_details['formData']['saleInterestClause'] == true)
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['saleInterestClause']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_saleInterestClause_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='saleInterestClause_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                            value='{{$insures_details[$i]['saleInterestClause']}}' required><label class='error'
                                                                            id='saleInterestClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='saleInterestClause'
                                                                            onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                            value='saleInterestClause' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{$insures_details[$i]['saleInterestClause']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
    
    
    
                                                    @if($pipeline_details['formData']['sueLabourClause'] == true)
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['sueLabourClause']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_sueLabourClause_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='sueLabourClause_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                            value='{{$insures_details[$i]['sueLabourClause']}}' required><label class='error'
                                                                            id='sueLabourClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='sueLabourClause'
                                                                            onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                            value='sueLabourClause' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{$insures_details[$i]['sueLabourClause']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
    
                                                    @if($pipeline_details['formData']['bankPolicy']['bankPolicy'] == true)
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
                                                                            <span id='div_lossPayee_{{$insures_details[$i]['uniqueToken']}}'
                                                                                data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
                                                                            <input id='lossPayee_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['lossPayee']?:'--'}}' required>
                                                                            <label class='error' id='lossPayee_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='lossPayee' onclick='fun(this)'>Update</button>
                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='lossPayee' onclick='cancel(this)'>
                                                                            <i class='material-icons'>close</i></button>"
                                                                                data-container="body">{{$insures_details[$i]['lossPayee']?:'--'}}
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
    
                                                    @if($pipeline_details['formData']['electricalClause'] == true)
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['electricalClause']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_electricalClause_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='electricalClause_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                            value='{{$insures_details[$i]['electricalClause']}}' required><label class='error'
                                                                            id='electricalClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='electricalClause'
                                                                            onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                            value='electricalClause' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{$insures_details[$i]['electricalClause']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
    
                                                    @if($pipeline_details['formData']['contractPriceClause'] == true)
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['contractPriceClause']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_contractPriceClause_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='contractPriceClause_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                            value='{{$insures_details[$i]['contractPriceClause']}}' required><label class='error'
                                                                            id='contractPriceClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='contractPriceClause'
                                                                            onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                            value='contractPriceClause' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{$insures_details[$i]['contractPriceClause']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
    
                                                    @if($pipeline_details['formData']['sprinklerUpgradationClause'] == true)
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['sprinklerUpgradationClause']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_sprinklerUpgradationClause_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='sprinklerUpgradationClause_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                            value='{{$insures_details[$i]['sprinklerUpgradationClause']}}' required><label class='error'
                                                                            id='sprinklerUpgradationClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='sprinklerUpgradationClause'
                                                                            onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                            value='sprinklerUpgradationClause' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{$insures_details[$i]['sprinklerUpgradationClause']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
    
                                                    @if($pipeline_details['formData']['accidentalFixClass'] == true)
                                                        <tr>
                                                            <?php $insure_count=count(@$insures_details);?>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['accidentalFixClass']['isAgree']))
                                                                            @if(@$insures_details[$i]['accidentalFixClass']['comment']!="")
                                                                                <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                    <div class="ans">
                                                                                        <span id="div_accidentalFixClass_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                            data-content="<input id='accidentalFixClass_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['accidentalFixClass']['isAgree']}}'>
                                                                                        <label class='error' id='accidentalFixClass_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='accidentalFixClass' onclick='fun(this)'>Update</button>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='accidentalFixClass' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                            data-container="body">{{@$insures_details[$i]['accidentalFixClass']['isAgree']}}</span>
                                                                                        
                                                                                              <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['accidentalFixClass']['comment']}}</span>        
                                                                                                        </div>
                                                                                                        <div class="media-right">
                                                                                                            <span id="cancel_accidentalFixClass_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                            data-content="<input id='accidentalFixClass_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['accidentalFixClass']['comment']}}'>
                                                                                                          <label class='error' id='accidentalFixClass_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                          </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='accidentalFixClass' onclick='commentEdit(this)'>Update</button>
                                                                                                          <button name='{{$insures_details[$i]['uniqueToken']}}' value='accidentalFixClass' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
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
                                                                                <span id="div_accidentalFixClass_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                    title="Edit existing value" data-html="true" data-content="<input id='accidentalFixClass_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['accidentalFixClass']['isAgree']}}'>
                                                                                <label class='error' id='accidentalFixClass_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='accidentalFixClass' onclick='fun(this)'>Update</button>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='accidentalFixClass' onclick='cancel(this)'>
                                                                                <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['accidentalFixClass']['isAgree']}}</span></div></td>
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
    
                                                    @if($pipeline_details['formData']['electronicInstallation'] == true)
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['electronicInstallation']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_electronicInstallation_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='electronicInstallation_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                            value='{{$insures_details[$i]['electronicInstallation']}}' required><label class='error'
                                                                            id='electronicInstallation_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='electronicInstallation'
                                                                            onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                            value='electronicInstallation' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{$insures_details[$i]['electronicInstallation']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
    
                                                    @if($pipeline_details['formData']['businessType']=="Art galleries/ fine arts collection"
                                                            || $pipeline_details['formData']['businessType']=="Colleges/ Universities/ schools & educational institute"
                                                            || $pipeline_details['formData']['businessType']=="Hotels/ boarding houses/ motels/ service apartments"
                                                            || $pipeline_details['formData']['businessType']=="Hotel multiple cover"
                                                            || $pipeline_details['formData']['businessType']=="Museum/ heritage sites"
                                                            )
    
                                                            <tr>
                                                                @if($insure_count==0)
                                                                    @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                        <td><div class="ans">--</div></td>
                                                                    @endfor
                                                                @else
                                                                    @for ($i = 0; $i < $total_insure_count; $i++)
                                                                        @if(array_key_exists($i,$insures_details))
    
                                                                            @if(isset($insures_details[$i]['coverCurios']))
                                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_coverCurios_{{$insures_details[$i]['uniqueToken']}}"
                                                                                  data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                  data-content="<input id='coverCurios_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                                value='{{$insures_details[$i]['coverCurios']}}' required><label class='error'
                                                                                id='coverCurios_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='coverCurios'
                                                                                onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                                value='coverCurios' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                data-container="body">{{$insures_details[$i]['coverCurios']}}</span></div></td>
                                                                            @else
                                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                            @endif
    
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @endfor 
                                                                @endif
                                                            </tr>
    
                                                    @endif
    
                                                    @if($pipeline_details['formData']['brandTrademark'] == true)
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['brandTrademark']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_brandTrademark_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='brandTrademark_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                            value='{{$insures_details[$i]['brandTrademark']}}' required><label class='error'
                                                                            id='brandTrademark_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='brandTrademark'
                                                                            onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                            value='brandTrademark' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{$insures_details[$i]['brandTrademark']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
    
                                                    @if($pipeline_details['formData']['ownerPrinciple']==true)
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['ownerPrinciple']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_ownerPrinciple_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='ownerPrinciple_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                        value='{{$insures_details[$i]['ownerPrinciple']}}' required><label class='error'
                                                                        id='ownerPrinciple_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='ownerPrinciple'
                                                                        onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                        value='ownerPrinciple' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{$insures_details[$i]['ownerPrinciple']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
    
                                                    @if($pipeline_details['formData']['conductClause'] == true)
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['conductClause']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_conductClause_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='conductClause_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                            value='{{$insures_details[$i]['conductClause']}}' required><label class='error'
                                                                            id='conductClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='conductClause'
                                                                            onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                            value='conductClause' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{$insures_details[$i]['conductClause']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
    
                                                    @if($pipeline_details['formData']['lossNotification'] == true)
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['lossNotification']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_lossNotification_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='lossNotification_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                        value='{{$insures_details[$i]['lossNotification']}}' required><label class='error'
                                                                        id='lossNotification_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='lossNotification'
                                                                        onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                        value='lossNotification' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{$insures_details[$i]['lossNotification']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
    
                                                      
                                                    @if($pipeline_details['formData']['brockersClaimClause'] == true)
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['brockersClaimClause']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_brockersClaimClause_{{$insures_details[$i]['uniqueToken']}}"
                                                                            data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                            data-content="<input id='brockersClaimClause_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                            value='{{$insures_details[$i]['brockersClaimClause']}}' required><label class='error'
                                                                            id='brockersClaimClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='brockersClaimClause'
                                                                            onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                            value='brockersClaimClause' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                            data-container="body">{{$insures_details[$i]['brockersClaimClause']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
    
                                                    @if($pipeline_details['formData']['businessInterruption']['business_interruption'] ==true )
                                                       
                                                        @if($pipeline_details['formData']['addCostWorking'] == true)
                                                            <tr>
                                                                @if($insure_count==0)
                                                                    @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                        <td><div class="ans">--</div></td>
                                                                    @endfor
                                                                @else
                                                                    @for ($i = 0; $i < $total_insure_count; $i++)
                                                                        @if(array_key_exists($i,$insures_details))
    
                                                                            @if(isset($insures_details[$i]['addCostWorking']))
                                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_addCostWorking_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                        data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                        data-content="<input id='addCostWorking_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                                value='{{$insures_details[$i]['addCostWorking']}}' required><label class='error'
                                                                                id='addCostWorking_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='addCostWorking'
                                                                                onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                                value='addCostWorking' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                        data-container="body">{{$insures_details[$i]['addCostWorking']}}</span></div></td>
                                                                            @else
                                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                            @endif
    
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @endfor
                                                                @endif
                                                            </tr>
                                                        @endif
    
                                                        @if($pipeline_details['formData']['claimPreparationClause'] == true)
                                                            <tr>
                                                                <?php $insure_count=count(@$insures_details);?>
                                                                @if($insure_count==0)
                                                                    @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                        <td>  <div class="ans">--</div></td>
                                                                    @endfor
                                                                @else
                                                                    @for ($i = 0; $i < $total_insure_count; $i++)
                                                                        @if(array_key_exists($i,$insures_details))
    
                                                                            @if(isset($insures_details[$i]['claimPreparationClause']['isAgree']))
                                                                                @if(@$insures_details[$i]['claimPreparationClause']['comment']!="")
                                                                                    <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                        <div class="ans">
                                                                                            <span id="div_claimPreparationClause_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                            data-content="<input id='claimPreparationClause_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['claimPreparationClause']['isAgree']}}'>
                                                                                            <label class='error' id='claimPreparationClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='claimPreparationClause' onclick='fun(this)'>Update</button>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='claimPreparationClause' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                            data-container="body">{{@$insures_details[$i]['claimPreparationClause']['isAgree']}}
                                                                                        </span>
                                                                                         
                                                                                                <div class="post_comments">
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <div class="media">
                                                                                                            <div class="media-body">
                                                                                                                <span  class="comment_txt">{{$insures_details[$i]['claimPreparationClause']['comment']}}</span>        
                                                                                                            </div>
                                                                                                            <div class="media-right">
                                                                                                                <span id="cancel_claimPreparationClause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                                data-content="<input id='claimPreparationClause_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['claimPreparationClause']['comment']}}'>
                                                                                                                    <label class='error' id='claimPreparationClause_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                                    </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='claimPreparationClause' onclick='commentEdit(this)'>Update</button>
                                                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='claimPreparationClause' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
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
                                                                                            <span id="div_claimPreparationClause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                            title="Edit existing value" data-html="true" data-content="<input id='claimPreparationClause_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['claimPreparationClause']['isAgree']}}'>
                                                                                            <label class='error' id='claimPreparationClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='claimPreparationClause' onclick='fun(this)'>Update</button>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='claimPreparationClause' onclick='cancel(this)'>
                                                                                            <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['claimPreparationClause']['isAgree']}}</span></div></td>
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
    
    
                                                        @if($pipeline_details['formData']['suppliersExtension'] == true)
                                                            <tr>
                                                                <?php $insure_count=count(@$insures_details);?>
                                                                @if($insure_count==0)
                                                                    @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                        <td>  <div class="ans">--</div></td>
                                                                    @endfor
                                                                @else
                                                                    @for ($i = 0; $i < $total_insure_count; $i++)
                                                                        @if(array_key_exists($i,$insures_details))
    
                                                                            @if(isset($insures_details[$i]['suppliersExtension']['isAgree']))
                                                                                @if(@$insures_details[$i]['suppliersExtension']['comment']!="")
                                                                                    <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                        <div class="ans">
                                                                                            <span id="div_suppliersExtension_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                data-content="<input id='suppliersExtension_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['suppliersExtension']['isAgree']}}'>
                                                                                            <label class='error' id='suppliersExtension_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='suppliersExtension' onclick='fun(this)'>Update</button>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='suppliersExtension' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                data-container="body">{{@$insures_details[$i]['suppliersExtension']['isAgree']}}
                                                                                            </span>
                                                                                           
                                                                                                  <div class="post_comments">
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <div class="media">
                                                                                                            <div class="media-body">
                                                                                                                <span  class="comment_txt">{{$insures_details[$i]['suppliersExtension']['comment']}}</span>        
                                                                                                            </div>
                                                                                                            <div class="media-right">
                                                                                                                <span id="cancel_suppliersExtension_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                  data-content="<input id='suppliersExtension_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['suppliersExtension']['comment']}}'>
                                                                                                <label class='error' id='suppliersExtension_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='suppliersExtension' onclick='commentEdit(this)'>Update</button>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='suppliersExtension' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
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
                                                                                        <span id="div_suppliersExtension_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                            title="Edit existing value" data-html="true" data-content="<input id='suppliersExtension_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['suppliersExtension']['isAgree']}}'>
                                                                                        <label class='error' id='suppliersExtension_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='suppliersExtension' onclick='fun(this)'>Update</button>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='suppliersExtension' onclick='cancel(this)'>
                                                                                        <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['suppliersExtension']['isAgree']}}</span></div></td>
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
    
                                                        @if($pipeline_details['formData']['accountantsClause'] == true)
                                                            <tr>
                                                                <?php $insure_count=count(@$insures_details);?>
                                                                @if($insure_count==0)
                                                                    @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                        <td>  <div class="ans">--</div></td>
                                                                    @endfor
                                                                @else
                                                                    @for ($i = 0; $i < $total_insure_count; $i++)
                                                                        @if(array_key_exists($i,$insures_details))
    
                                                                            @if(isset($insures_details[$i]['accountantsClause']['isAgree']))
                                                                                @if(@$insures_details[$i]['accountantsClause']['comment']!="")
                                                                                    <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                        <div class="ans">
                                                                                            <span id="div_accountantsClause_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                            data-content="<input id='accountantsClause_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['accountantsClause']['isAgree']}}'>
                                                                                            <label class='error' id='accountantsClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='accountantsClause' onclick='fun(this)'>Update</button>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='accountantsClause' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                            data-container="body">{{@$insures_details[$i]['accountantsClause']['isAgree']}}
                                                                                        </span>
                                                                                          
                                                                                                <div class="post_comments">
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <div class="media">
                                                                                                            <div class="media-body">
                                                                                                                <span  class="comment_txt">{{$insures_details[$i]['accountantsClause']['comment']}}</span>        
                                                                                                            </div>
                                                                                                            <div class="media-right">
                                                                                                                <span id="cancel_accountantsClause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                                data-content="<input id='accountantsClause_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['accountantsClause']['comment']}}'>
                                                                                                                    <label class='error' id='accountantsClause_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                                    </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='accountantsClause' onclick='commentEdit(this)'>Update</button>
                                                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='accountantsClause' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
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
                                                                                        <span id="div_accountantsClause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                        title="Edit existing value" data-html="true" data-content="<input id='accountantsClause_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['accountantsClause']['isAgree']}}'>
                                                                                        <label class='error' id='accountantsClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='accountantsClause' onclick='fun(this)'>Update</button>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='accountantsClause' onclick='cancel(this)'>
                                                                                        <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['accountantsClause']['isAgree']}}</span></div></td>
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
    
                                                        @if($pipeline_details['formData']['accountPayment'] == true)
                                                            <tr>
                                                                <?php $insure_count=count(@$insures_details);?>
                                                                @if($insure_count==0)
                                                                    @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                        <td>  <div class="ans">--</div></td>
                                                                    @endfor
                                                                @else
                                                                    @for ($i = 0; $i < $total_insure_count; $i++)
                                                                        @if(array_key_exists($i,$insures_details))
    
                                                                            @if(isset($insures_details[$i]['accountPayment']['isAgree']))
                                                                                @if(@$insures_details[$i]['accountPayment']['comment']!="")
                                                                                    <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                        <div class="ans">
                                                                                            <span id="div_accountPayment_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                            data-content="<input id='accountPayment_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['accountPayment']['isAgree']}}'>
                                                                                            <label class='error' id='accountPayment_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='accountPayment' onclick='fun(this)'>Update</button>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='accountPayment' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                            data-container="body">{{@$insures_details[$i]['accountPayment']['isAgree']}}
                                                                                        </span>
                                                                                          
                                                                                                <div class="post_comments">
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <div class="media">
                                                                                                            <div class="media-body">
                                                                                                                <span  class="comment_txt">{{$insures_details[$i]['accountPayment']['comment']}}</span>        
                                                                                                            </div>
                                                                                                            <div class="media-right">
                                                                                                                <span id="cancel_accountPayment_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                                data-content="<input id='accountPayment_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['accountPayment']['comment']}}'>
                                                                                                                <label class='error' id='accountPayment_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                                </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='accountPayment' onclick='commentEdit(this)'>Update</button>
                                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='accountPayment' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
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
                                                                                        <span id="div_accountPayment_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                        title="Edit existing value" data-html="true" data-content="<input id='accountPayment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['accountPayment']['isAgree']}}'>
                                                                                        <label class='error' id='accountPayment_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='accountPayment' onclick='fun(this)'>Update</button>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='accountPayment' onclick='cancel(this)'>
                                                                                        <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['accountPayment']['isAgree']}}</span></div></td>
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
    
                                                        @if($pipeline_details['formData']['preventionDenialClause'] == true)
                                                            <tr>
                                                                <?php $insure_count=count(@$insures_details);?>
                                                                @if($insure_count==0)
                                                                    @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                        <td>  <div class="ans">--</div></td>
                                                                    @endfor
                                                                @else
                                                                    @for ($i = 0; $i < $total_insure_count; $i++)
                                                                        @if(array_key_exists($i,$insures_details))
    
                                                                            @if(isset($insures_details[$i]['preventionDenialClause']['isAgree']))
                                                                                @if(@$insures_details[$i]['preventionDenialClause']['comment']!="")
                                                                                    <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                        <div class="ans">
                                                                                            <span id="div_preventionDenialClause_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                            data-content="<input id='preventionDenialClause_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['preventionDenialClause']['isAgree']}}'>
                                                                                            <label class='error' id='preventionDenialClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='preventionDenialClause' onclick='fun(this)'>Update</button>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='preventionDenialClause' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                            data-container="body">{{@$insures_details[$i]['preventionDenialClause']['isAgree']}}
                                                                                        </span>
                                                                                          
                                                                                                <div class="post_comments">
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <div class="media">
                                                                                                            <div class="media-body">
                                                                                                                <span  class="comment_txt">{{$insures_details[$i]['preventionDenialClause']['comment']}}</span>        
                                                                                                            </div>
                                                                                                            <div class="media-right">
                                                                                                                <span id="cancel_preventionDenialClause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                data-content="<input id='preventionDenialClause_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['preventionDenialClause']['comment']}}'>
                                                                                                <label class='error' id='preventionDenialClause_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='preventionDenialClause' onclick='commentEdit(this)'>Update</button>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='preventionDenialClause' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
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
                                                                                    <span id="div_preventionDenialClause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                    title="Edit existing value" data-html="true" data-content="<input id='preventionDenialClause_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['preventionDenialClause']['isAgree']}}'>
                                                                                    <label class='error' id='preventionDenialClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='preventionDenialClause' onclick='fun(this)'>Update</button>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='preventionDenialClause' onclick='cancel(this)'>
                                                                                    <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['preventionDenialClause']['isAgree']}}</span></div></td>
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
    
                                                        @if($pipeline_details['formData']['premiumAdjClause'] == true)
                                                            <tr>
                                                                <?php $insure_count=count(@$insures_details);?>
                                                                @if($insure_count==0)
                                                                    @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                        <td>  <div class="ans">--</div></td>
                                                                    @endfor
                                                                @else
                                                                    @for ($i = 0; $i < $total_insure_count; $i++)
                                                                        @if(array_key_exists($i,$insures_details))
    
                                                                            @if(isset($insures_details[$i]['premiumAdjClause']['isAgree']))
                                                                                @if(@$insures_details[$i]['premiumAdjClause']['comment']!="")
                                                                                    <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                        <div class="ans">
                                                                                <span id="div_premiumAdjClause_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                data-content="<input id='premiumAdjClause_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['premiumAdjClause']['isAgree']}}'>
                                                                                <label class='error' id='premiumAdjClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='premiumAdjClause' onclick='fun(this)'>Update</button>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='premiumAdjClause' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                data-container="body">{{@$insures_details[$i]['premiumAdjClause']['isAgree']}}
                                                                            </span>
                                                                                            
                                                                                                <div class="post_comments">
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <div class="media">
                                                                                                            <div class="media-body">
                                                                                                                <span  class="comment_txt">{{$insures_details[$i]['premiumAdjClause']['comment']}}</span>        
                                                                                                            </div>
                                                                                                            <div class="media-right">
                                                                                                                <span id="cancel_premiumAdjClause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                data-content="<input id='premiumAdjClause_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['premiumAdjClause']['comment']}}'>
                                                                                                <label class='error' id='premiumAdjClause_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='premiumAdjClause' onclick='commentEdit(this)'>Update</button>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='premiumAdjClause' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
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
                                                                                    <span id="div_premiumAdjClause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                    title="Edit existing value" data-html="true" data-content="<input id='premiumAdjClause_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['premiumAdjClause']['isAgree']}}'>
                                                                                    <label class='error' id='premiumAdjClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='premiumAdjClause' onclick='fun(this)'>Update</button>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='premiumAdjClause' onclick='cancel(this)'>
                                                                                    <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['premiumAdjClause']['isAgree']}}</span></div></td>
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
    
                                                        @if($pipeline_details['formData']['publicUtilityClause'] == true)
                                                            <tr>
                                                                <?php $insure_count=count(@$insures_details);?>
                                                                @if($insure_count==0)
                                                                    @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                        <td>  <div class="ans">--</div></td>
                                                                    @endfor
                                                                @else
                                                                    @for ($i = 0; $i < $total_insure_count; $i++)
                                                                        @if(array_key_exists($i,$insures_details))
    
                                                                            @if(isset($insures_details[$i]['publicUtilityClause']['isAgree']))
                                                                                @if(@$insures_details[$i]['publicUtilityClause']['comment']!="")
                                                                                    <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                        <div class="ans">
                                                                                            <span id="div_publicUtilityClause_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                            data-content="<input id='publicUtilityClause_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['publicUtilityClause']['isAgree']}}'>
                                                                                            <label class='error' id='publicUtilityClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='publicUtilityClause' onclick='fun(this)'>Update</button>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='publicUtilityClause' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                            data-container="body">{{@$insures_details[$i]['publicUtilityClause']['isAgree']}}
                                                                                        </span>
                                                                                          
                                                                                                <div class="post_comments">
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <div class="media">
                                                                                                            <div class="media-body">
                                                                                                                <span  class="comment_txt">{{$insures_details[$i]['publicUtilityClause']['comment']}}</span>        
                                                                                                            </div>
                                                                                                            <div class="media-right">
                                                                                                                <span id="cancel_publicUtilityClause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                                data-content="<input id='publicUtilityClause_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['publicUtilityClause']['comment']}}'>
                                                                                                            <label class='error' id='publicUtilityClause_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                            </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='publicUtilityClause' onclick='commentEdit(this)'>Update</button>
                                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='publicUtilityClause' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
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
                                                                                <span id="div_publicUtilityClause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                title="Edit existing value" data-html="true" data-content="<input id='publicUtilityClause_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['publicUtilityClause']['isAgree']}}'>
                                                                                <label class='error' id='publicUtilityClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='publicUtilityClause' onclick='fun(this)'>Update</button>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='publicUtilityClause' onclick='cancel(this)'>
                                                                                <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['publicUtilityClause']['isAgree']}}</span></div></td>
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
    
                                                        @if($pipeline_details['formData']['brockersClaimHandlingClause'] == true)
                                                            <tr>
                                                                @if($insure_count==0)
                                                                    @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                        <td><div class="ans">--</div></td>
                                                                    @endfor
                                                                @else
                                                                    @for ($i = 0; $i < $total_insure_count; $i++)
                                                                        @if(array_key_exists($i,$insures_details))
    
                                                                            @if(isset($insures_details[$i]['brockersClaimHandlingClause']))
                                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_brockersClaimHandlingClause_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                        data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                        data-content="<input id='brockersClaimHandlingClause_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                                    value='{{$insures_details[$i]['brockersClaimHandlingClause']}}' required><label class='error'
                                                                                    id='brockersClaimHandlingClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='brockersClaimHandlingClause'
                                                                                    onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                                    value='brockersClaimHandlingClause' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                        data-container="body">{{$insures_details[$i]['brockersClaimHandlingClause']}}</span></div></td>
                                                                            @else
                                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                            @endif
    
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @endfor
                                                                @endif
                                                            </tr>
                                                        @endif
    
                                                        @if($pipeline_details['formData']['accountsRecievable'] == true)
                                                            <tr>
                                                                <?php $insure_count=count(@$insures_details);?>
                                                                @if($insure_count==0)
                                                                    @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                        <td>  <div class="ans">--</div></td>
                                                                    @endfor
                                                                @else
                                                                    @for ($i = 0; $i < $total_insure_count; $i++)
                                                                        @if(array_key_exists($i,$insures_details))
    
                                                                            @if(isset($insures_details[$i]['accountsRecievable']['isAgree']))
                                                                                @if(@$insures_details[$i]['accountsRecievable']['comment']!="")
                                                                                    <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                        <div class="ans">
                                                                                            <span id="div_accountsRecievable_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                            data-content="<input id='accountsRecievable_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['accountsRecievable']['isAgree']}}'>
                                                                                            <label class='error' id='accountsRecievable_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='accountsRecievable' onclick='fun(this)'>Update</button>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='accountsRecievable' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                            data-container="body">{{@$insures_details[$i]['accountsRecievable']['isAgree']}}
                                                                                        </span>
                                                                                          
                                                                                                <div class="post_comments">
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <div class="media">
                                                                                                            <div class="media-body">
                                                                                                                <span  class="comment_txt">{{$insures_details[$i]['accountsRecievable']['comment']}}</span>        
                                                                                                            </div>
                                                                                                            <div class="media-right">
                                                                                                                <span id="cancel_accountsRecievable_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                                data-content="<input id='accountsRecievable_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['accountsRecievable']['comment']}}'>
                                                                                                                <label class='error' id='accountsRecievable_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                                </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='accountsRecievable' onclick='commentEdit(this)'>Update</button>
                                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='accountsRecievable' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
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
                                                                                <span id="div_accountsRecievable_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                title="Edit existing value" data-html="true" data-content="<input id='accountsRecievable_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['accountsRecievable']['isAgree']}}'>
                                                                                <label class='error' id='accountsRecievable_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='accountsRecievable' onclick='fun(this)'>Update</button>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='accountsRecievable' onclick='cancel(this)'>
                                                                                <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['accountsRecievable']['isAgree']}}</span></div></td>
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
    
                                                        @if($pipeline_details['formData']['interDependency'] == true)
                                                            <tr>
                                                                @if($insure_count==0)
                                                                    @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                        <td><div class="ans">--</div></td>
                                                                    @endfor
                                                                @else
                                                                    @for ($i = 0; $i < $total_insure_count; $i++)
                                                                        @if(array_key_exists($i,$insures_details))
    
                                                                            @if(isset($insures_details[$i]['interDependency']))
                                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_interDependency_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                        data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                        data-content="<input id='interDependency_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                            value='{{$insures_details[$i]['interDependency']}}' required><label class='error'
                                                                            id='interDependency_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='interDependency'
                                                                            onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                            value='interDependency' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                        data-container="body">{{$insures_details[$i]['interDependency']}}</span></div></td>
                                                                            @else
                                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                            @endif
    
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @endfor
                                                                @endif
                                                            </tr>
                                                        @endif
    
                                                        @if($pipeline_details['formData']['extraExpense'] == true)
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
    
                                                        @if($pipeline_details['formData']['contaminatedWater'] == true)
                                                            <tr>
                                                                @if($insure_count==0)
                                                                    @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                        <td><div class="ans">--</div></td>
                                                                    @endfor
                                                                @else
                                                                    @for ($i = 0; $i < $total_insure_count; $i++)
                                                                        @if(array_key_exists($i,$insures_details))
    
                                                                            @if(isset($insures_details[$i]['contaminatedWater']))
                                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_contaminatedWater_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                        data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                        data-content="<input id='contaminatedWater_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                                    value='{{$insures_details[$i]['contaminatedWater']}}' required><label class='error'
                                                                                    id='contaminatedWater_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='contaminatedWater'
                                                                                    onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                                    value='contaminatedWater' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                        data-container="body">{{$insures_details[$i]['contaminatedWater']}}</span></div></td>
                                                                            @else
                                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                            @endif
    
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @endfor
                                                                @endif
                                                            </tr>
                                                        @endif
    
                                                        @if($pipeline_details['formData']['auditorsFeeCheck'] == true)
                                                            <tr>
                                                                <?php $insure_count=count(@$insures_details);?>
                                                                @if($insure_count==0)
                                                                    @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                        <td>  <div class="ans">--</div></td>
                                                                    @endfor
                                                                @else
                                                                    @for ($i = 0; $i < $total_insure_count; $i++)
                                                                        @if(array_key_exists($i,$insures_details))
    
                                                                            @if(isset($insures_details[$i]['auditorsFeeCheck']['isAgree']))
                                                                                @if(@$insures_details[$i]['auditorsFeeCheck']['comment']!="")
                                                                                    <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                        <div class="ans">
                                                                                            <span id="div_auditorsFeeCheck_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                data-content="<input id='auditorsFeeCheck_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['auditorsFeeCheck']['isAgree']}}'>
                                                                                            <label class='error' id='auditorsFeeCheck_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='auditorsFeeCheck' onclick='fun(this)'>Update</button>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='auditorsFeeCheck' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                            data-container="body">{{@$insures_details[$i]['auditorsFeeCheck']['isAgree']}}
                                                                                        </span>
                                                                                           
                                                                                                  <div class="post_comments">
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <div class="media">
                                                                                                            <div class="media-body">
                                                                                                                <span  class="comment_txt">{{$insures_details[$i]['extraExpense']['comment']}}</span>        
                                                                                                            </div>
                                                                                                            <div class="media-right">
                                                                                                                <span id="cancel_auditorsFeeCheck_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                                data-content="<input id='auditorsFeeCheck_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['auditorsFeeCheck']['comment']}}'>
                                                                                                              <label class='error' id='auditorsFeeCheck_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                              </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='auditorsFeeCheck' onclick='commentEdit(this)'>Update</button>
                                                                                                              <button name='{{$insures_details[$i]['uniqueToken']}}' value='auditorsFeeCheck' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
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
                                                                                <span id="div_auditorsFeeCheck_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                    title="Edit existing value" data-html="true" data-content="<input id='auditorsFeeCheck_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['auditorsFeeCheck']['isAgree']}}'>
                                                                                <label class='error' id='auditorsFeeCheck_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='auditorsFeeCheck' onclick='fun(this)'>Update</button>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='auditorsFeeCheck' onclick='cancel(this)'>
                                                                                <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['auditorsFeeCheck']['isAgree']}}</span></div></td>
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
                                                        @if($pipeline_details['formData']['expenseReduceLoss'] == true)
                                                            <tr>
                                                                <?php $insure_count=count(@$insures_details);?>
                                                                @if($insure_count==0)
                                                                    @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                        <td>  <div class="ans">--</div></td>
                                                                    @endfor
                                                                @else
                                                                    @for ($i = 0; $i < $total_insure_count; $i++)
                                                                        @if(array_key_exists($i,$insures_details))
    
                                                                            @if(isset($insures_details[$i]['expenseReduceLoss']['isAgree']))
                                                                                @if(@$insures_details[$i]['expenseReduceLoss']['comment']!="")
                                                                                    <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                        <div class="ans">
                                                                                            <span id="div_expenseReduceLoss_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                data-content="<input id='expenseReduceLoss_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['expenseReduceLoss']['isAgree']}}'>
                                                                                            <label class='error' id='expenseReduceLoss_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='expenseReduceLoss' onclick='fun(this)'>Update</button>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='expenseReduceLoss' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                            data-container="body">{{@$insures_details[$i]['expenseReduceLoss']['isAgree']}}
                                                                                        </span>
                                                                                          
                                                                                                  <div class="post_comments">
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <div class="media">
                                                                                                            <div class="media-body">
                                                                                                                <span  class="comment_txt">{{$insures_details[$i]['expenseReduceLoss']['comment']}}</span>        
                                                                                                            </div>
                                                                                                            <div class="media-right">
                                                                                                                <span id="cancel_expenseReduceLoss_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                  data-content="<input id='expenseReduceLoss_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['expenseReduceLoss']['comment']}}'>
                                                                                                <label class='error' id='expenseReduceLoss_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='expenseReduceLoss' onclick='commentEdit(this)'>Update</button>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='expenseReduceLoss' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
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
                                                                                <span id="div_expenseReduceLoss_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                    title="Edit existing value" data-html="true" data-content="<input id='expenseReduceLoss_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['expenseReduceLoss']['isAgree']}}'>
                                                                                <label class='error' id='expenseReduceLoss_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='expenseReduceLoss' onclick='fun(this)'>Update</button>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='expenseReduceLoss' onclick='cancel(this)'>
                                                                                <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['expenseReduceLoss']['isAgree']}}</span></div></td>
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
    
                                                        @if($pipeline_details['formData']['nominatedLossAdjuster'] == true)
                                                            <tr>
                                                                <?php $insure_count=count(@$insures_details);?>
                                                                @if($insure_count==0)
                                                                    @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                        <td>  <div class="ans">--</div></td>
                                                                    @endfor
                                                                @else
                                                                    @for ($i = 0; $i < $total_insure_count; $i++)
                                                                        @if(array_key_exists($i,$insures_details))
    
                                                                            @if(isset($insures_details[$i]['nominatedLossAdjuster']['isAgree']))
                                                                                @if(@$insures_details[$i]['nominatedLossAdjuster']['comment']!="")
                                                                                    <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                        <div class="ans">
                                                                                        <span id="div_nominatedLossAdjuster_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                            data-content="<input id='nominatedLossAdjuster_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['nominatedLossAdjuster']['isAgree']}}'>
                                                                                        <label class='error' id='nominatedLossAdjuster_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='nominatedLossAdjuster' onclick='fun(this)'>Update</button>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='nominatedLossAdjuster' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                            data-container="body">{{@$insures_details[$i]['nominatedLossAdjuster']['isAgree']}}
                                                                                        </span>
                                                                                          
                                                                                                  <div class="post_comments">
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <div class="media">
                                                                                                            <div class="media-body">
                                                                                                                <span  class="comment_txt">{{$insures_details[$i]['nominatedLossAdjuster']['comment']}}</span>        
                                                                                                            </div>
                                                                                                            <div class="media-right">
                                                                                                                <span id="cancel_nominatedLossAdjuster_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                  data-content="<input id='nominatedLossAdjuster_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['nominatedLossAdjuster']['comment']}}'>
                                                                                                        <label class='error' id='nominatedLossAdjuster_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                        </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='nominatedLossAdjuster' onclick='commentEdit(this)'>Update</button>
                                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='nominatedLossAdjuster' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
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
                                                                                            <span id="div_nominatedLossAdjuster_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                                title="Edit existing value" data-html="true" data-content="<input id='nominatedLossAdjuster_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['nominatedLossAdjuster']['isAgree']}}'>
                                                                                            <label class='error' id='nominatedLossAdjuster_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='nominatedLossAdjuster' onclick='fun(this)'>Update</button>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='nominatedLossAdjuster' onclick='cancel(this)'>
                                                                                            <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['nominatedLossAdjuster']['isAgree']}}</span></div></td>
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
    
                                                        @if($pipeline_details['formData']['outbreakDiscease'] == true)
                                                            <tr>
                                                                <?php $insure_count=count(@$insures_details);?>
                                                                @if($insure_count==0)
                                                                    @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                        <td>  <div class="ans">--</div></td>
                                                                    @endfor
                                                                @else
                                                                    @for ($i = 0; $i < $total_insure_count; $i++)
                                                                        @if(array_key_exists($i,$insures_details))
    
                                                                            @if(isset($insures_details[$i]['outbreakDiscease']['isAgree']))
                                                                                @if(@$insures_details[$i]['outbreakDiscease']['comment']!="")
                                                                                    <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                        <div class="ans">
                                                                                            <span id="div_outbreakDiscease_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                            data-content="<input id='outbreakDiscease_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['outbreakDiscease']['isAgree']}}'>
                                                                                            <label class='error' id='outbreakDiscease_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='outbreakDiscease' onclick='fun(this)'>Update</button>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='outbreakDiscease' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                            data-container="body">{{@$insures_details[$i]['outbreakDiscease']['isAgree']}}
                                                                                        </span>
                                                                                         
                                                                                                        <div class="post_comments">
                                                                                                            <div class="post_comments_main clearfix">
                                                                                                                <div class="media">
                                                                                                                    <div class="media-body">
                                                                                                                        <span  class="comment_txt">{{$insures_details[$i]['outbreakDiscease']['comment']}}</span>        
                                                                                                                    </div>
                                                                                                                    <div class="media-right">
                                                                                                                        <span id="cancel_outbreakDiscease_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                                        data-content="<input id='outbreakDiscease_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['outbreakDiscease']['comment']}}'>
                                                                                                                <label class='error' id='outbreakDiscease_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                                </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='outbreakDiscease' onclick='commentEdit(this)'>Update</button>
                                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='outbreakDiscease' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
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
                                                                                        <span id="div_outbreakDiscease_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                        title="Edit existing value" data-html="true" data-content="<input id='outbreakDiscease_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['outbreakDiscease']['isAgree']}}'>
                                                                                        <label class='error' id='outbreakDiscease_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='outbreakDiscease' onclick='fun(this)'>Update</button>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='outbreakDiscease' onclick='cancel(this)'>
                                                                                        <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['outbreakDiscease']['isAgree']}}</span></div></td>
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
    
                                                        @if($pipeline_details['formData']['nonPublicFailure'] == true)
                                                            <tr>
                                                                <?php $insure_count=count(@$insures_details);?>
                                                                @if($insure_count==0)
                                                                    @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                        <td>  <div class="ans">--</div></td>
                                                                    @endfor
                                                                @else
                                                                    @for ($i = 0; $i < $total_insure_count; $i++)
                                                                        @if(array_key_exists($i,$insures_details))
    
                                                                            @if(isset($insures_details[$i]['nonPublicFailure']['isAgree']))
                                                                                @if(@$insures_details[$i]['nonPublicFailure']['comment']!="")
                                                                                    <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                        <div class="ans">
                                                                                            <span id="div_nonPublicFailure_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                            data-content="<input id='nonPublicFailure_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['nonPublicFailure']['isAgree']}}'>
                                                                                            <label class='error' id='nonPublicFailure_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='nonPublicFailure' onclick='fun(this)'>Update</button>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='nonPublicFailure' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                            data-container="body">{{@$insures_details[$i]['nonPublicFailure']['isAgree']}}
                                                                                        </span>
                                                                                           
                                                                                                <div class="post_comments">
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <div class="media">
                                                                                                            <div class="media-body">
                                                                                                                <span  class="comment_txt">{{$insures_details[$i]['nonPublicFailure']['comment']}}</span>        
                                                                                                            </div>
                                                                                                            <div class="media-right">
                                                                                                                <span id="cancel_nonPublicFailure_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                                data-content="<input id='nonPublicFailure_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['nonPublicFailure']['comment']}}'>
                                                                                                            <label class='error' id='nonPublicFailure_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                            </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='nonPublicFailure' onclick='commentEdit(this)'>Update</button>
                                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='nonPublicFailure' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
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
                                                                                <span id="div_nonPublicFailure_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                title="Edit existing value" data-html="true" data-content="<input id='nonPublicFailure_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['nonPublicFailure']['isAgree']}}'>
                                                                                <label class='error' id='nonPublicFailure_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='nonPublicFailure' onclick='fun(this)'>Update</button>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='nonPublicFailure' onclick='cancel(this)'>
                                                                                <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['nonPublicFailure']['isAgree']}}</span></div></td>
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
    
                                                        @if($pipeline_details['formData']['premisesDetails'] == true)
                                                            <tr>
                                                                <?php $insure_count=count(@$insures_details);?>
                                                                @if($insure_count==0)
                                                                    @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                        <td>  <div class="ans">--</div></td>
                                                                    @endfor
                                                                @else
                                                                    @for ($i = 0; $i < $total_insure_count; $i++)
                                                                        @if(array_key_exists($i,$insures_details))
    
                                                                            @if(isset($insures_details[$i]['premisesDetails']['isAgree']))
                                                                                @if(@$insures_details[$i]['premisesDetails']['comment']!="")
                                                                                    <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                        <div class="ans">
                                                                                        <span id="div_premisesDetails_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                        data-content="<input id='premisesDetails_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['premisesDetails']['isAgree']}}'>
                                                                                        <label class='error' id='premisesDetails_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='premisesDetails' onclick='fun(this)'>Update</button>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='premisesDetails' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                        data-container="body">{{@$insures_details[$i]['premisesDetails']['isAgree']}}
                                                                                    </span>
                                                                                          
                                                                                                <div class="post_comments">
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <div class="media">
                                                                                                            <div class="media-body">
                                                                                                                <span  class="comment_txt">{{$insures_details[$i]['premisesDetails']['comment']}}</span>        
                                                                                                            </div>
                                                                                                            <div class="media-right">
                                                                                                                <span id="cancel_premisesDetails_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                data-content="<input id='premisesDetails_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['premisesDetails']['comment']}}'>
                                                                                            <label class='error' id='premisesDetails_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                            </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='premisesDetails' onclick='commentEdit(this)'>Update</button>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='premisesDetails' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
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
                                                                                <span id="div_premisesDetails_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                title="Edit existing value" data-html="true" data-content="<input id='premisesDetails_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['premisesDetails']['isAgree']}}'>
                                                                                <label class='error' id='premisesDetails_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='premisesDetails' onclick='fun(this)'>Update</button>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='premisesDetails' onclick='cancel(this)'>
                                                                                <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['premisesDetails']['isAgree']}}</span></div></td>
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
    
                                                        @if($pipeline_details['formData']['bombscare'] == true)
                                                            <tr>
                                                                <?php $insure_count=count(@$insures_details);?>
                                                                @if($insure_count==0)
                                                                    @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                        <td>  <div class="ans">--</div></td>
                                                                    @endfor
                                                                @else
                                                                    @for ($i = 0; $i < $total_insure_count; $i++)
                                                                        @if(array_key_exists($i,$insures_details))
    
                                                                            @if(isset($insures_details[$i]['bombscare']['isAgree']))
                                                                                @if(@$insures_details[$i]['bombscare']['comment']!="")
                                                                                    <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                        <div class="ans">
                                                                                        <span id="div_bombscare_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                        data-content="<input id='bombscare_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['bombscare']['isAgree']}}'>
                                                                                        <label class='error' id='bombscare_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='bombscare' onclick='fun(this)'>Update</button>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='bombscare' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                        data-container="body">{{@$insures_details[$i]['bombscare']['isAgree']}}
                                                                                    </span>
                                                                                          
                                                                                                <div class="post_comments">
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <div class="media">
                                                                                                            <div class="media-body">
                                                                                                                <span  class="comment_txt">{{$insures_details[$i]['bombscare']['comment']}}</span>        
                                                                                                            </div>
                                                                                                            <div class="media-right">
                                                                                                                <span id="cancel_bombscare_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                                data-content="<input id='bombscare_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['bombscare']['comment']}}'>
                                                                                                                <label class='error' id='bombscare_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                                </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='bombscare' onclick='commentEdit(this)'>Update</button>
                                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='bombscare' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
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
                                                                                        <span id="div_bombscare_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                        title="Edit existing value" data-html="true" data-content="<input id='bombscare_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['bombscare']['isAgree']}}'>
                                                                                        <label class='error' id='bombscare_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='bombscare' onclick='fun(this)'>Update</button>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='bombscare' onclick='cancel(this)'>
                                                                                        <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['bombscare']['isAgree']}}</span></div></td>
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
    
                                                        @if($pipeline_details['formData']['DenialClause'] == true)
                                                            <tr>
                                                                <?php $insure_count=count(@$insures_details);?>
                                                                @if($insure_count==0)
                                                                    @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                        <td>  <div class="ans">--</div></td>
                                                                    @endfor
                                                                @else
                                                                    @for ($i = 0; $i < $total_insure_count; $i++)
                                                                        @if(array_key_exists($i,$insures_details))
    
                                                                            @if(isset($insures_details[$i]['DenialClause']['isAgree']))
                                                                                @if(@$insures_details[$i]['DenialClause']['comment']!="")
                                                                                    <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                        <div class="ans">
                                                                                        <span id="div_DenialClause_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                        data-content="<input id='DenialClause_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['DenialClause']['isAgree']}}'>
                                                                                        <label class='error' id='DenialClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='DenialClause' onclick='fun(this)'>Update</button>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='DenialClause' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                        data-container="body">{{@$insures_details[$i]['DenialClause']['isAgree']}}
                                                                                    </span>
                                                                                         
                                                                                                <div class="post_comments">
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <div class="media">
                                                                                                            <div class="media-body">
                                                                                                                <span  class="comment_txt">{{$insures_details[$i]['DenialClause']['comment']}}</span>        
                                                                                                            </div>
                                                                                                            <div class="media-right">
                                                                                                                <span id="cancel_DenialClause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                                data-content="<input id='DenialClause_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['DenialClause']['comment']}}'>
                                                                                                                <label class='error' id='DenialClause_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                                </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='DenialClause' onclick='commentEdit(this)'>Update</button>
                                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='DenialClause' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
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
                                                                                        <span id="div_DenialClause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                        title="Edit existing value" data-html="true" data-content="<input id='DenialClause_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['DenialClause']['isAgree']}}'>
                                                                                        <label class='error' id='DenialClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='DenialClause' onclick='fun(this)'>Update</button>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='DenialClause' onclick='cancel(this)'>
                                                                                        <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['DenialClause']['isAgree']}}</span></div></td>
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
    
                                                        @if($pipeline_details['formData']['bookDebits'] == true)
                                                            <tr>
                                                                <?php $insure_count=count(@$insures_details);?>
                                                                @if($insure_count==0)
                                                                    @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                        <td>  <div class="ans">--</div></td>
                                                                    @endfor
                                                                @else
                                                                    @for ($i = 0; $i < $total_insure_count; $i++)
                                                                        @if(array_key_exists($i,$insures_details))
    
                                                                            @if(isset($insures_details[$i]['bookDebits']['isAgree']))
                                                                                @if(@$insures_details[$i]['bookDebits']['comment']!="")
                                                                                    <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                        <div class="ans">
                                                                                        <span id="div_bookDebits_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                        data-content="<input id='bookDebits_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['bookDebits']['isAgree']}}'>
                                                                                        <label class='error' id='bookDebits_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='bookDebits' onclick='fun(this)'>Update</button>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='bookDebits' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                        data-container="body">{{@$insures_details[$i]['bookDebits']['isAgree']}}
                                                                                    </span>
                                                                                          
                                                                                                <div class="post_comments">
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <div class="media">
                                                                                                            <div class="media-body">
                                                                                                                <span  class="comment_txt">{{$insures_details[$i]['bookDebits']['comment']}}</span>        
                                                                                                            </div>
                                                                                                            <div class="media-right">
                                                                                                                <span id="cancel_bookDebits_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                                data-content="<input id='bookDebits_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['bookDebits']['comment']}}'>
                                                                                                            <label class='error' id='bookDebits_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                            </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='bookDebits' onclick='commentEdit(this)'>Update</button>
                                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='bookDebits' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
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
                                                                                    <span id="div_bookDebits_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                    title="Edit existing value" data-html="true" data-content="<input id='bookDebits_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['bookDebits']['isAgree']}}'>
                                                                                    <label class='error' id='bookDebits_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='bookDebits' onclick='fun(this)'>Update</button>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='bookDebits' onclick='cancel(this)'>
                                                                                    <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['bookDebits']['isAgree']}}</span></div></td>
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
    
                                                        @if($pipeline_details['formData']['publicFailure'] == true)
                                                            <tr>
                                                                <?php $insure_count=count(@$insures_details);?>
                                                                @if($insure_count==0)
                                                                    @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                        <td>  <div class="ans">--</div></td>
                                                                    @endfor
                                                                @else
                                                                    @for ($i = 0; $i < $total_insure_count; $i++)
                                                                        @if(array_key_exists($i,$insures_details))
    
                                                                            @if(isset($insures_details[$i]['publicFailure']['isAgree']))
                                                                                @if(@$insures_details[$i]['publicFailure']['comment']!="")
                                                                                    <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                        <div class="ans">
                                                                                            <span id="div_publicFailure_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                            data-content="<input id='publicFailure_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['publicFailure']['isAgree']}}'>
                                                                                            <label class='error' id='publicFailure_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='publicFailure' onclick='fun(this)'>Update</button>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='publicFailure' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                            data-container="body">{{@$insures_details[$i]['publicFailure']['isAgree']}}
                                                                                        </span>
                                                                                           
                                                                                                <div class="post_comments">
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <div class="media">
                                                                                                            <div class="media-body">
                                                                                                                <span  class="comment_txt">{{$insures_details[$i]['publicFailure']['comment']}}</span>        
                                                                                                            </div>
                                                                                                            <div class="media-right">
                                                                                                                <span id="cancel_publicFailure_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                                data-content="<input id='publicFailure_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['publicFailure']['comment']}}'>
                                                                                                            <label class='error' id='publicFailure_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                            </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='publicFailure' onclick='commentEdit(this)'>Update</button>
                                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='publicFailure' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
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
                                                                                    <span id="div_publicFailure_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                    title="Edit existing value" data-html="true" data-content="<input id='publicFailure_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['publicFailure']['isAgree']}}'>
                                                                                    <label class='error' id='publicFailure_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='publicFailure' onclick='fun(this)'>Update</button>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='publicFailure' onclick='cancel(this)'>
                                                                                    <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['publicFailure']['isAgree']}}</span></div></td>
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
    
                                                        @if(isset($pipeline_details['formData']['businessInterruption']['noLocations']) && $pipeline_details['formData']['businessInterruption']['noLocations']>1)
                                                            @if($pipeline_details['formData']['departmentalClause'] == true)
                                                                <tr>
                                                                    @if($insure_count==0)
                                                                        @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                            <td><div class="ans">--</div></td>
                                                                        @endfor
                                                                    @else
                                                                        @for ($i = 0; $i < $total_insure_count; $i++)
                                                                            @if(array_key_exists($i,$insures_details))
    
                                                                                @if(isset($insures_details[$i]['departmentalClause']))
                                                                                    <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_departmentalClause_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                            data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                            data-content="<input id='departmentalClause_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                                    value='{{$insures_details[$i]['departmentalClause']}}' required><label class='error'
                                                                                    id='departmentalClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='departmentalClause'
                                                                                    onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                                    value='departmentalClause' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                            data-container="body">{{$insures_details[$i]['departmentalClause']}}</span></div></td>
                                                                                @else
                                                                                    <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                                @endif
    
                                                                            @else
                                                                                <td><div class="ans">--</div></td>
                                                                            @endif
    
                                                                        @endfor
                                                                    @endif
                                                                </tr>
                                                            @endif
                                                            @if($pipeline_details['formData']['rentLease'] == true)
                                                                <tr>
                                                                    <?php $insure_count=count(@$insures_details);?>
                                                                    @if($insure_count==0)
                                                                        @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                            <td>  <div class="ans">--</div></td>
                                                                        @endfor
                                                                    @else
                                                                        @for ($i = 0; $i < $total_insure_count; $i++)
                                                                            @if(array_key_exists($i,$insures_details))
    
                                                                                @if(isset($insures_details[$i]['rentLease']['isAgree']))
                                                                                    @if(@$insures_details[$i]['rentLease']['comment']!="")
                                                                                        <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                            <div class="ans">
                                                                                                <span id="div_rentLease_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                data-content="<input id='rentLease_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['rentLease']['isAgree']}}'>
                                                                                                <label class='error' id='rentLease_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='rentLease' onclick='fun(this)'>Update</button>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='rentLease' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                data-container="body">{{@$insures_details[$i]['rentLease']['isAgree']}}
                                                                                            </span>
                                                                                              
                                                                                                    <div class="post_comments">
                                                                                                        <div class="post_comments_main clearfix">
                                                                                                            <div class="media">
                                                                                                                <div class="media-body">
                                                                                                                    <span  class="comment_txt">{{$insures_details[$i]['rentLease']['comment']}}</span>        
                                                                                                                </div>
                                                                                                                <div class="media-right">
                                                                                                                    <span id="cancel_rentLease_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                                    data-content="<input id='rentLease_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['rentLease']['comment']}}'>
                                                                                                                        <label class='error' id='rentLease_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                                        </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='rentLease' onclick='commentEdit(this)'>Update</button>
                                                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='rentLease' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
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
                                                                                            <span id="div_rentLease_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                            title="Edit existing value" data-html="true" data-content="<input id='rentLease_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['rentLease']['isAgree']}}'>
                                                                                            <label class='error' id='rentLease_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='rentLease' onclick='fun(this)'>Update</button>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='rentLease' onclick='cancel(this)'>
                                                                                            <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['rentLease']['isAgree']}}</span></div></td>
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
                                                        @endif
    
                                                        @if($pipeline_details['formData']['CoverAccomodation']['coverAccomodation'] == true)
                                                            <tr>
                                                                <?php $insure_count=count(@$insures_details);?>
                                                                @if($insure_count==0)
                                                                    @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                        <td>  <div class="ans">--</div></td>
                                                                    @endfor
                                                                @else
                                                                    @for ($i = 0; $i < $total_insure_count; $i++)
                                                                        @if(array_key_exists($i,$insures_details))
    
                                                                            @if(isset($insures_details[$i]['coverAccomodation']['isAgree']))
                                                                                @if(@$insures_details[$i]['coverAccomodation']['comment']!="")
                                                                                    <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                        <div class="ans">
                                                                                        <span id="div_coverAccomodation_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                        data-content="<input id='coverAccomodation_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['coverAccomodation']['isAgree']}}'>
                                                                                        <label class='error' id='coverAccomodation_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='coverAccomodation' onclick='fun(this)'>Update</button>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='coverAccomodation' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                        data-container="body">{{@$insures_details[$i]['coverAccomodation']['isAgree']}}
                                                                                    </span>
                                                                                        
                                                                                                <div class="post_comments">
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <div class="media">
                                                                                                            <div class="media-body">
                                                                                                                <span  class="comment_txt">{{$insures_details[$i]['coverAccomodation']['comment']}}</span>        
                                                                                                            </div>
                                                                                                            <div class="media-right">
                                                                                                                <span id="cancel_coverAccomodation_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                                data-content="<input id='coverAccomodation_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['coverAccomodation']['comment']}}'>
                                                                                                        <label class='error' id='coverAccomodation_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                        </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='coverAccomodation' onclick='commentEdit(this)'>Update</button>
                                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='coverAccomodation' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
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
                                                                                    <span id="div_coverAccomodation_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                    title="Edit existing value" data-html="true" data-content="<input id='coverAccomodation_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['coverAccomodation']['isAgree']}}'>
                                                                                    <label class='error' id='coverAccomodation_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='coverAccomodation' onclick='fun(this)'>Update</button>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='coverAccomodation' onclick='cancel(this)'>
                                                                                    <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['coverAccomodation']['isAgree']}}</span></div></td>
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
    
                                                        @if($pipeline_details['formData']['demolitionCost'] == true)
                                                            <tr>
                                                                <?php $insure_count=count(@$insures_details);?>
                                                                @if($insure_count==0)
                                                                    @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                        <td>  <div class="ans">--</div></td>
                                                                    @endfor
                                                                @else
                                                                    @for ($i = 0; $i < $total_insure_count; $i++)
                                                                        @if(array_key_exists($i,$insures_details))
    
                                                                            @if(isset($insures_details[$i]['demolitionCost']['isAgree']))
                                                                                @if(@$insures_details[$i]['demolitionCost']['comment']!="")
                                                                                    <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                        <div class="ans">
                                                                                            <span id="div_demolitionCost_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                            data-content="<input id='demolitionCost_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['demolitionCost']['isAgree']}}'>
                                                                                            <label class='error' id='demolitionCost_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='demolitionCost' onclick='fun(this)'>Update</button>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='demolitionCost' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                            data-container="body">{{@$insures_details[$i]['demolitionCost']['isAgree']}}
                                                                                        </span>
                                                                                          
                                                                                                <div class="post_comments">
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <div class="media">
                                                                                                            <div class="media-body">
                                                                                                                <span  class="comment_txt">{{$insures_details[$i]['demolitionCost']['comment']}}</span>        
                                                                                                            </div>
                                                                                                            <div class="media-right">
                                                                                                                <span id="cancel_demolitionCost_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                data-content="<input id='demolitionCost_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['demolitionCost']['comment']}}'>
                                                                                            <label class='error' id='demolitionCost_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                            </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='demolitionCost' onclick='commentEdit(this)'>Update</button>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='demolitionCost' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
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
                                                                                    <span id="div_demolitionCost_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                    title="Edit existing value" data-html="true" data-content="<input id='demolitionCost{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['demolitionCost']['isAgree']}}'>
                                                                                    <label class='error' id='demolitionCost_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='demolitionCost' onclick='fun(this)'>Update</button>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='demolitionCost' onclick='cancel(this)'>
                                                                                    <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['demolitionCost']['isAgree']}}</span></div></td>
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
    
                                                        @if($pipeline_details['formData']['contingentBusiness'] == true)
                                                            <tr>
                                                                <?php $insure_count=count(@$insures_details);?>
                                                                @if($insure_count==0)
                                                                    @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                        <td>  <div class="ans">--</div></td>
                                                                    @endfor
                                                                @else
                                                                    @for ($i = 0; $i < $total_insure_count; $i++)
                                                                        @if(array_key_exists($i,$insures_details))
    
                                                                            @if(isset($insures_details[$i]['contingentBusiness']['isAgree']))
                                                                                @if(@$insures_details[$i]['contingentBusiness']['comment']!="")
                                                                                    <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                        <div class="ans">
                                                                                            <span id="div_contingentBusiness_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                            data-content="<input id='contingentBusiness_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['contingentBusiness']['isAgree']}}'>
                                                                                            <label class='error' id='contingentBusiness_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='contingentBusiness' onclick='fun(this)'>Update</button>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='contingentBusiness' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                            data-container="body">{{@$insures_details[$i]['contingentBusiness']['isAgree']}}
                                                                                        </span>
                                                                                           
                                                                                                <div class="post_comments">
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <div class="media">
                                                                                                            <div class="media-body">
                                                                                                                <span  class="comment_txt">{{$insures_details[$i]['contingentBusiness']['comment']}}</span>        
                                                                                                            </div>
                                                                                                            <div class="media-right">
                                                                                                                <span id="cancel_contingentBusiness_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                                data-content="<input id='contingentBusiness_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['contingentBusiness']['comment']}}'>
                                                                                                                <label class='error' id='contingentBusiness_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                                </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='contingentBusiness' onclick='commentEdit(this)'>Update</button>
                                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='contingentBusiness' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
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
                                                                                <span id="div_contingentBusiness_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                title="Edit existing value" data-html="true" data-content="<input id='contingentBusiness_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['contingentBusiness']['isAgree']}}'>
                                                                                <label class='error' id='contingentBusiness_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='contingentBusiness' onclick='fun(this)'>Update</button>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='contingentBusiness' onclick='cancel(this)'>
                                                                                <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['contingentBusiness']['isAgree']}}</span></div></td>
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
                                                        @if($pipeline_details['formData']['nonOwnedProperties'] == true)
                                                            <tr>
                                                                <?php $insure_count=count(@$insures_details);?>
                                                                @if($insure_count==0)
                                                                    @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                        <td>  <div class="ans">--</div></td>
                                                                    @endfor
                                                                @else
                                                                    @for ($i = 0; $i < $total_insure_count; $i++)
                                                                        @if(array_key_exists($i,$insures_details))
    
                                                                            @if(isset($insures_details[$i]['nonOwnedProperties']['isAgree']))
                                                                                @if(@$insures_details[$i]['nonOwnedProperties']['comment']!="")
                                                                                    <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                        <div class="ans">
                                                                                                <span id="div_nonOwnedProperties_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                data-content="<input id='nonOwnedProperties_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['nonOwnedProperties']['isAgree']}}'>
                                                                                                <label class='error' id='nonOwnedProperties_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='nonOwnedProperties' onclick='fun(this)'>Update</button>
                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='nonOwnedProperties' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                data-container="body">{{@$insures_details[$i]['nonOwnedProperties']['isAgree']}}
                                                                                            </span>
                                                                                          
                                                                                                <div class="post_comments">
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <div class="media">
                                                                                                            <div class="media-body">
                                                                                                                <span  class="comment_txt">{{$insures_details[$i]['nonOwnedProperties']['comment']}}</span>        
                                                                                                            </div>
                                                                                                            <div class="media-right">
                                                                                                                <span id="cancel_nonOwnedProperties_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                                data-content="<input id='nonOwnedProperties_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['nonOwnedProperties']['comment']}}'>
                                                                                                                <label class='error' id='nonOwnedProperties_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                                </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='nonOwnedProperties' onclick='commentEdit(this)'>Update</button>
                                                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='nonOwnedProperties' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
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
                                                                                        <span id="div_nonOwnedProperties_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                                        title="Edit existing value" data-html="true" data-content="<input id='nonOwnedProperties_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['nonOwnedProperties']['isAgree']}}'>
                                                                                        <label class='error' id='nonOwnedProperties_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='nonOwnedProperties' onclick='fun(this)'>Update</button>
                                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='nonOwnedProperties' onclick='cancel(this)'>
                                                                                        <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['nonOwnedProperties']['isAgree']}}</span></div></td>
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
                                                        @if($pipeline_details['formData']['royalties'] == true)
                                                            <tr>
                                                                @if($insure_count==0)
                                                                    @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                        <td><div class="ans">--</div></td>
                                                                    @endfor
                                                                @else
                                                                    @for ($i = 0; $i < $total_insure_count; $i++)
                                                                        @if(array_key_exists($i,$insures_details))
    
                                                                            @if(isset($insures_details[$i]['royalties']))
                                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_royalties_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                        data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                        data-content="<input id='royalties_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                            value='{{$insures_details[$i]['royalties']}}' required><label class='error'
                                                                            id='royalties_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='royalties'
                                                                            onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                            value='royalties' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                        data-container="body">{{$insures_details[$i]['royalties']}}</span></div></td>
                                                                            @else
                                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                            @endif
    
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @endfor
                                                                @endif
                                                            </tr>
                                                        @endif
                                                    @endif
    
                                                    {{-- @endif --}}
    
                                                    @if(isset($pipeline_details['formData']['cliamPremium']) &&
                                                    $pipeline_details['formData']['cliamPremium'] =='combined_data')
    
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['claimPremiyumDetails']['deductableProperty']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_claimPremiyumDetails_deductableProperty_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='claimPremiyumDetails_deductableProperty_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                            value='{{number_format(trim($insures_details[$i]['claimPremiyumDetails']['deductableProperty']),2)}}' required><label class='error'
                                                                            id='claimPremiyumDetails_deductableProperty_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='claimPremiyumDetails_deductableProperty'
                                                                            onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                            value='claimPremiyumDetails_deductableProperty' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{number_format(trim($insures_details[$i]['claimPremiyumDetails']['deductableProperty']),2)}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['claimPremiyumDetails']['deductableBusiness']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_claimPremiyumDetails_deductableBusiness_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='claimPremiyumDetails_deductableBusiness_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                            value='{{number_format(trim($insures_details[$i]['claimPremiyumDetails']['deductableBusiness']),2)}}' required><label class='error'
                                                                            id='claimPremiyumDetails_deductableBusiness_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='claimPremiyumDetails_deductableBusiness'
                                                                            onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                            value='claimPremiyumDetails_deductableBusiness' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{number_format(trim($insures_details[$i]['claimPremiyumDetails']['deductableBusiness']),2)}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['claimPremiyumDetails']['rateCombined']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_claimPremiyumDetails_rateCombined_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='claimPremiyumDetails_rateCombined_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                                value='{{number_format(trim($insures_details[$i]['claimPremiyumDetails']['rateCombined']),2)}}' required><label class='error'
                                                                                id='claimPremiyumDetails_rateCombined_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='claimPremiyumDetails_rateCombined'
                                                                                onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                                value='claimPremiyumDetails_rateCombined' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{number_format(trim($insures_details[$i]['claimPremiyumDetails']['rateCombined']),2)}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['claimPremiyumDetails']['premiumCombined']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_claimPremiyumDetails_premiumCombined_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='claimPremiyumDetails_premiumCombined_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                            value='{{number_format(trim($insures_details[$i]['claimPremiyumDetails']['premiumCombined']),2)}}' required><label class='error'
                                                                            id='claimPremiyumDetails_premiumCombined_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='claimPremiyumDetails_premiumCombined'
                                                                            onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                            value='claimPremiyumDetails_premiumCombined' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{number_format(trim($insures_details[$i]['claimPremiyumDetails']['premiumCombined']),2)}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['claimPremiyumDetails']['brokerage']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_claimPremiyumDetails_brokerage_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='claimPremiyumDetails_brokerage_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                                value='{{number_format(trim($insures_details[$i]['claimPremiyumDetails']['brokerage']),2)}}' required><label class='error'
                                                                                id='claimPremiyumDetails_brokerage_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='claimPremiyumDetails_brokerage'
                                                                                onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                                value='claimPremiyumDetails_brokerage' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{number_format(trim($insures_details[$i]['claimPremiyumDetails']['brokerage']),2)}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['claimPremiyumDetails']['warrantyProperty']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_claimPremiyumDetails_warrantyProperty_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='claimPremiyumDetails_warrantyProperty_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                                    value='{{$insures_details[$i]['claimPremiyumDetails']['warrantyProperty']}}' required><label class='error'
                                                                                    id='claimPremiyumDetails_warrantyProperty_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='claimPremiyumDetails_warrantyProperty'
                                                                                    onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                                    value='claimPremiyumDetails_warrantyProperty' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{$insures_details[$i]['claimPremiyumDetails']['warrantyProperty']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['claimPremiyumDetails']['warrantyBusiness']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_claimPremiyumDetails_warrantyBusiness_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='claimPremiyumDetails_warrantyBusiness_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                        value='{{$insures_details[$i]['claimPremiyumDetails']['warrantyBusiness']}}' required><label class='error'
                                                                        id='claimPremiyumDetails_warrantyBusiness_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='claimPremiyumDetails_warrantyBusiness'
                                                                        onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                        value='claimPremiyumDetails_warrantyBusiness' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{$insures_details[$i]['claimPremiyumDetails']['warrantyBusiness']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['claimPremiyumDetails']['exclusionProperty']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_claimPremiyumDetails_exclusionProperty_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='claimPremiyumDetails_exclusionProperty_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                        value='{{$insures_details[$i]['claimPremiyumDetails']['exclusionProperty']}}' required><label class='error'
                                                                        id='claimPremiyumDetails_exclusionProperty_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='claimPremiyumDetails_exclusionProperty'
                                                                        onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                        value='claimPremiyumDetails_exclusionProperty' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{$insures_details[$i]['claimPremiyumDetails']['exclusionProperty']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['claimPremiyumDetails']['exclusionBusiness']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_claimPremiyumDetails_exclusionBusiness_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='claimPremiyumDetails_exclusionBusiness_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                value='{{$insures_details[$i]['claimPremiyumDetails']['exclusionBusiness']}}' required><label class='error'
                                                                id='claimPremiyumDetails_exclusionBusiness_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='claimPremiyumDetails_exclusionBusiness'
                                                                onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                value='claimPremiyumDetails_exclusionBusiness' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{$insures_details[$i]['claimPremiyumDetails']['exclusionBusiness']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['claimPremiyumDetails']['specialProperty']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_claimPremiyumDetails_specialProperty_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='claimPremiyumDetails_specialProperty_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                    value='{{$insures_details[$i]['claimPremiyumDetails']['specialProperty']}}' required><label class='error'
                                                                    id='claimPremiyumDetails_specialProperty_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='claimPremiyumDetails_specialProperty'
                                                                    onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                    value='claimPremiyumDetails_specialProperty' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{$insures_details[$i]['claimPremiyumDetails']['specialProperty']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['claimPremiyumDetails']['specialBusiness']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_claimPremiyumDetails_specialBusiness_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='claimPremiyumDetails_specialBusiness_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                            value='{{$insures_details[$i]['claimPremiyumDetails']['specialBusiness']}}' required><label class='error'
                                                                            id='claimPremiyumDetails_specialBusiness_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='claimPremiyumDetails_specialBusiness'
                                                                            onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                            value='claimPremiyumDetails_specialBusiness' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{$insures_details[$i]['claimPremiyumDetails']['specialBusiness']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
    
    
                                                    @if(isset($pipeline_details['formData']['cliamPremium']) &&
                                                    $pipeline_details['formData']['cliamPremium'] =='only_fire')
                                                    
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['claimPremiyumDetails']['deductableProperty']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_claimPremiyumDetails_onlydeductableProperty_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                                                                    data-content="<input id='claimPremiyumDetails_onlydeductableProperty_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                                            value='{{number_format(trim($insures_details[$i]['claimPremiyumDetails']['deductableProperty']),2)}}' required><label class='error'
                                                                                            id='claimPremiyumDetails_onlydeductableProperty_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='claimPremiyumDetails_deductableProperty'
                                                                                            onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                                            value='claimPremiyumDetails_claimPremiyumDetails_deductableProperty' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                 data-container="body">{{number_format(trim($insures_details[$i]['claimPremiyumDetails']['deductableProperty']),2)}}</span></div></td>
                                                                            @else
                                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                            @endif
        
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
        
                                                                    @endfor
                                                            @endif
                                                        </tr>
                                                    
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['claimPremiyumDetails']['propertyRate']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_claimPremiyumDetails_propertyRate_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='claimPremiyumDetails_propertyRate_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                            value='{{number_format(trim($insures_details[$i]['claimPremiyumDetails']['propertyRate']),2)}}' required><label class='error'
                                                                            id='claimPremiyumDetails_propertyRate_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='claimPremiyumDetails_propertyRate'
                                                                            onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                            value='claimPremiyumDetails_propertyRate' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{number_format(trim($insures_details[$i]['claimPremiyumDetails']['propertyRate']),2)}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['claimPremiyumDetails']['propertyPremium']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_claimPremiyumDetails_propertyPremium_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='claimPremiyumDetails_propertyPremium_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                            value='{{number_format(trim($insures_details[$i]['claimPremiyumDetails']['propertyPremium']),2)}}' required><label class='error'
                                                                            id='claimPremiyumDetails_propertyPremium_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='claimPremiyumDetails_propertyPremium'
                                                                            onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                            value='claimPremiyumDetails_propertyPremium' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{number_format(trim($insures_details[$i]['claimPremiyumDetails']['propertyPremium']),2)}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['claimPremiyumDetails']['propertyBrockerage']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_claimPremiyumDetails_propertyBrockerage_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='claimPremiyumDetails_propertyBrockerage_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                    value='{{number_format(trim($insures_details[$i]['claimPremiyumDetails']['propertyBrockerage']),2)}}' required><label class='error'
                                                                    id='claimPremiyumDetails_propertyBrockerage_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='claimPremiyumDetails_propertyBrockerage'
                                                                    onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                    value='claimPremiyumDetails_propertyBrockerage' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{number_format(trim($insures_details[$i]['claimPremiyumDetails']['propertyBrockerage']),2)}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['claimPremiyumDetails']['propertyWarranty']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_claimPremiyumDetails_propertyWarranty_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='claimPremiyumDetails_propertyWarranty_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                        value='{{$insures_details[$i]['claimPremiyumDetails']['propertyWarranty']}}' required><label class='error'
                                                                        id='claimPremiyumDetails_propertyWarranty_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='claimPremiyumDetails_propertyWarranty'
                                                                        onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                        value='claimPremiyumDetails_propertyWarranty' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{$insures_details[$i]['claimPremiyumDetails']['propertyWarranty']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['claimPremiyumDetails']['propertyExclusion']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_claimPremiyumDetails_propertyExclusion_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='claimPremiyumDetails_propertyExclusion_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                        value='{{$insures_details[$i]['claimPremiyumDetails']['propertyExclusion']}}' required><label class='error'
                                                                        id='claimPremiyumDetails_propertyExclusion_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='claimPremiyumDetails_propertyExclusion'
                                                                        onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                        value='claimPremiyumDetails_propertyExclusion' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{$insures_details[$i]['claimPremiyumDetails']['propertyExclusion']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['claimPremiyumDetails']['propertySpecial']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_claimPremiyumDetails_propertySpecial_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='claimPremiyumDetails_propertySpecial_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                        value='{{$insures_details[$i]['claimPremiyumDetails']['propertySpecial']}}' required><label class='error'
                                                                        id='claimPremiyumDetails_propertySpecial_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='claimPremiyumDetails_propertySpecial'
                                                                        onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                        value='claimPremiyumDetails_propertySpecial' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{$insures_details[$i]['claimPremiyumDetails']['propertySpecial']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
    
                                                    @if(isset($pipeline_details['formData']['cliamPremium']) &&
                                                        $pipeline_details['formData']['cliamPremium'] =='separate_fire')
    
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['claimPremiyumDetails']['propertySeparateDeductable']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_claimPremiyumDetails_propertySeparateDeductable_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='claimPremiyumDetails_propertySeparateDeductable_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                        value='{{number_format(trim($insures_details[$i]['claimPremiyumDetails']['propertySeparateDeductable']),2)}}' required><label class='error'
                                                                        id='claimPremiyumDetails_propertySeparateDeductable_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='claimPremiyumDetails_propertySeparateDeductable'
                                                                        onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                        value='claimPremiyumDetails_propertySeparateDeductable' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{number_format(trim($insures_details[$i]['claimPremiyumDetails']['propertySeparateDeductable']),2)}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
    
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['claimPremiyumDetails']['propertySeparateRate']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_claimPremiyumDetails_propertySeparateRate_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='claimPremiyumDetails_propertySeparateRate_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                        value='{{number_format(trim($insures_details[$i]['claimPremiyumDetails']['propertySeparateRate']),2)}}' required><label class='error'
                                                                        id='claimPremiyumDetails_propertySeparateRate_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='claimPremiyumDetails_propertySeparateRate'
                                                                        onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                        value='claimPremiyumDetails_propertySeparateRate' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{number_format(trim($insures_details[$i]['claimPremiyumDetails']['propertySeparateRate']),2)}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['claimPremiyumDetails']['propertySeparatePremium']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_claimPremiyumDetails_propertySeparatePremium_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='claimPremiyumDetails_propertySeparatePremium_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                    value='{{number_format(trim($insures_details[$i]['claimPremiyumDetails']['propertySeparatePremium']),2)}}' required><label class='error'
                                                                    id='claimPremiyumDetails_propertySeparatePremium_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='claimPremiyumDetails_propertySeparatePremium'
                                                                    onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                    value='claimPremiyumDetails_propertySeparatePremium' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{number_format(trim($insures_details[$i]['claimPremiyumDetails']['propertySeparatePremium']),2)}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['claimPremiyumDetails']['propertySeparateBrokerage']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_claimPremiyumDetails_propertySeparateBrokerage_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='claimPremiyumDetails_propertySeparateBrokerage_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                        value='{{number_format(trim($insures_details[$i]['claimPremiyumDetails']['propertySeparateBrokerage']),2)}}' required><label class='error'
                                                                        id='claimPremiyumDetails_propertySeparateBrokerage_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='claimPremiyumDetails_propertySeparateBrokerage'
                                                                        onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                        value='claimPremiyumDetails_propertySeparateBrokerage' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{number_format(trim($insures_details[$i]['claimPremiyumDetails']['propertySeparateBrokerage']),2)}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['claimPremiyumDetails']['propertySeparateWarranty']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_claimPremiyumDetails_propertySeparateWarranty_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='claimPremiyumDetails_propertySeparateWarranty_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                        value='{{$insures_details[$i]['claimPremiyumDetails']['propertySeparateWarranty']}}' required><label class='error'
                                                                        id='claimPremiyumDetails_propertySeparateWarranty_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='claimPremiyumDetails_propertySeparateWarranty'
                                                                        onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                        value='claimPremiyumDetails_propertySeparateWarranty' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{$insures_details[$i]['claimPremiyumDetails']['propertySeparateWarranty']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
    
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['claimPremiyumDetails']['propertySeparateExclusion']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_claimPremiyumDetails_propertySeparateExclusion_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='claimPremiyumDetails_propertySeparateExclusion_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                        value='{{$insures_details[$i]['claimPremiyumDetails']['propertySeparateExclusion']}}' required><label class='error'
                                                                        id='claimPremiyumDetails_propertySeparateExclusion_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='claimPremiyumDetails_propertySeparateExclusion'
                                                                        onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                        value='claimPremiyumDetails_propertySeparateExclusion' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{$insures_details[$i]['claimPremiyumDetails']['propertySeparateExclusion']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
    
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['claimPremiyumDetails']['propertySeparateSpecial']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_claimPremiyumDetails_propertySeparateSpecial_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='claimPremiyumDetails_propertySeparateSpecial_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                        value='{{$insures_details[$i]['claimPremiyumDetails']['propertySeparateSpecial']}}' required><label class='error'
                                                                        id='claimPremiyumDetails_propertySeparateSpecial_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='claimPremiyumDetails_propertySeparateSpecial'
                                                                        onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                        value='claimPremiyumDetails_propertySeparateSpecial' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{$insures_details[$i]['claimPremiyumDetails']['propertySeparateSpecial']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['claimPremiyumDetails']['businessSeparateDeductable']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_claimPremiyumDetails_businessSeparateDeductable_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='claimPremiyumDetails_businessSeparateDeductable_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                        value='{{$insures_details[$i]['claimPremiyumDetails']['businessSeparateDeductable']}}' required><label class='error'
                                                                        id='claimPremiyumDetails_businessSeparateDeductable_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='claimPremiyumDetails_businessSeparateDeductable'
                                                                        onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                        value='claimPremiyumDetails_businessSeparateDeductable' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{$insures_details[$i]['claimPremiyumDetails']['businessSeparateDeductable']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
    
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['claimPremiyumDetails']['businessSeparateRate']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_claimPremiyumDetails_businessSeparateRate_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='claimPremiyumDetails_businessSeparateRate_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                        value='{{$insures_details[$i]['claimPremiyumDetails']['businessSeparateRate']}}' required><label class='error'
                                                                        id='claimPremiyumDetails_businessSeparateRate_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='claimPremiyumDetails_businessSeparateRate'
                                                                        onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                        value='claimPremiyumDetails_businessSeparateRate' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{$insures_details[$i]['claimPremiyumDetails']['businessSeparateRate']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['claimPremiyumDetails']['businessSeparatePremium']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_claimPremiyumDetails_businessSeparatePremium_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='claimPremiyumDetails_businessSeparatePremium_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                        value='{{$insures_details[$i]['claimPremiyumDetails']['businessSeparatePremium']}}' required><label class='error'
                                                                        id='claimPremiyumDetails_businessSeparatePremium_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='claimPremiyumDetails_businessSeparatePremium'
                                                                        onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                        value='claimPremiyumDetails_businessSeparatePremium' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{$insures_details[$i]['claimPremiyumDetails']['businessSeparatePremium']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['claimPremiyumDetails']['businessSeparateBrokerage']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_claimPremiyumDetails_businessSeparateBrokerage_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='claimPremiyumDetails_businessSeparateBrokerage_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                            value='{{$insures_details[$i]['claimPremiyumDetails']['businessSeparateBrokerage']}}' required><label class='error'
                                                                            id='claimPremiyumDetails_businessSeparateBrokerage_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='claimPremiyumDetails_businessSeparateBrokerage'
                                                                            onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                            value='claimPremiyumDetails_businessSeparateBrokerage' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{$insures_details[$i]['claimPremiyumDetails']['businessSeparateBrokerage']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['claimPremiyumDetails']['businessSeparateWarranty']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_claimPremiyumDetails_businessSeparateWarranty_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='claimPremiyumDetails_businessSeparateWarranty_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                        value='{{$insures_details[$i]['claimPremiyumDetails']['businessSeparateWarranty']}}' required><label class='error'
                                                                        id='claimPremiyumDetails_businessSeparateWarranty_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='claimPremiyumDetails_businessSeparateWarranty'
                                                                        onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                        value='claimPremiyumDetails_businessSeparateWarranty' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{$insures_details[$i]['claimPremiyumDetails']['businessSeparateWarranty']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
    
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['claimPremiyumDetails']['businessSeparateExclusion']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_claimPremiyumDetails_businessSeparateExclusion_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='claimPremiyumDetails_businessSeparateExclusion_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                            value='{{$insures_details[$i]['claimPremiyumDetails']['businessSeparateExclusion']}}' required><label class='error'
                                                                            id='claimPremiyumDetails_businessSeparateExclusion_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                            <button name='{{$insures_details[$i]['uniqueToken']}}' value='claimPremiyumDetails_businessSeparateExclusion'
                                                                            onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                            value='claimPremiyumDetails_businessSeparateExclusion' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{$insures_details[$i]['claimPremiyumDetails']['businessSeparateExclusion']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
    
                                                        <tr>
                                                            @if($insure_count==0)
                                                                @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i < $total_insure_count; $i++)
                                                                    @if(array_key_exists($i,$insures_details))
    
                                                                        @if(isset($insures_details[$i]['claimPremiyumDetails']['businessSeparateSpecial']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_claimPremiyumDetails_businessSeparateSpecial_{{$insures_details[$i]['uniqueToken']}}"
                                                                                                                                                                    data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                                                                                                    data-content="<input id='claimPremiyumDetails_businessSeparateSpecial_{{$insures_details[$i]['uniqueToken']}}' type='text'
                                                                        value='{{$insures_details[$i]['claimPremiyumDetails']['businessSeparateSpecial']}}' required><label class='error'
                                                                        id='claimPremiyumDetails_businessSeparateSpecial_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='claimPremiyumDetails_businessSeparateSpecial'
                                                                        onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}'
                                                                        value='claimPremiyumDetails_businessSeparateSpecial' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                                                                                                    data-container="body">{{$insures_details[$i]['claimPremiyumDetails']['businessSeparateSpecial']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
    
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
    
                                                                @endfor
                                                            @endif
                                                        </tr>
    
                                                    @endif
    
    
                                                    @if($pipeline_details['status']['status'] == 'E-slip' || $pipeline_details['status']['status']=='E-quotation' || $pipeline_details['status']['status']=='E-comparison' || $pipeline_details['status']['status']=='Quote Amendment'|| $pipeline_details['status']['status']=='Quote Amendment-E-quotation')
    
                                                        <tr>
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
                            window.location.href = "{{url('fireperils/imported-list')}}";
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
                    url: '{{url('save-selected-insurers')}}',
                    data: form_data,
                    cache : false,
                    contentType: false,
                    processData: false,
                    success: function (result) {
                        if (result== 'success') {
                            window.location.href = '{{url('fireperils/e-comparison/'.$pipeline_details->_id)}}';
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
                    url: '{{url('fireperils/quot-amend')}}',
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
                        else{
                            $('#preLoader').hide();
                            $('#'+field+'_'+token+'-error').html('Please enter numerical value');
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
                    url: '{{url('fireperils/quot-amend')}}',
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
            var form_data = new FormData($("#e_quat_form")[0]);
            form_data.append('_token', '{{csrf_token()}}');
            form_data.append('is_save','true');
            $.ajax({
                method: 'post',
                url: '{{url('save-selected-insurers')}}',
                data: form_data,
                cache : false,
                contentType: false,
                processData: false,
                success: function (result) {
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
