
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
    @if (session('status'))
        <div class="alert alert-success alert-dismissible" role="alert" id="success_div">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            {{ session('status') }}
        </div>
    @endif
    <div class="section_details">
        <div class="card_header clearfix">
            <h3 class="title" style="margin-bottom: 8px;">Fire and Perils</h3>
        </div>
        <div class="card_content">
            <div class="edit_sec clearfix">
                <!-- Steps -->
                <section>
                    <nav>
                        <ol class="cd-breadcrumb triangle">
                            <li class="complete"><em><a href="{{ url('fireperils/e-questionnaire/'.$pipeline_details->_id) }}">E-Questionnaire</a></em></li>
                            <li class="complete"><em><a href="{{ url('fireperils/e-slip/'.$pipeline_details->_id) }}">E-Slip</a></em></li>
                            <li class="complete"><em><a href="{{ url('fireperils/e-quotation/'.$pipeline_details->_id) }}">E-Quotation</a></em></li>
                            <li class="complete"><a href="{{url('fireperils/e-comparison/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Comparision</em></a></li>
                            @if($pipeline_details['status']['status'] == 'Approved E Quote')
                                <li class = active_arrow><a href="{{url('fireperils/quot-amendment/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>
                                <li class = "current"><a href="{{url('fireperils/approved-quot/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Approved E Quote</em></a></li>
                                {{--<li><em>Issuance</em></li>--}}
                            {{--@elseif($pipeline_details['status']['status'] == 'Issuance')--}}
                                {{--<li class = complete><a href="{{url('quot-amendment/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>--}}
                                {{--<li class = "complete"><a href="{{url('approved-quot/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Approved E Quote</em></a></li>--}}
                                {{--<li class = "current"><a href="{{url('issuance/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Issuance</em></a></li>--}}
                            @else
                                <li class = current><a href="{{url('fireperils/quot-amendment/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>
                                <li><em>Approved E Quote</em></li>
                                {{--<li><em>Issuance</em></li>--}}
                            @endif
                        </ol>
                    </nav>
                    <input type="hidden" id="pipeline_id" name="pipeline_id" value="{{$pipeline_details->_id}}">
                </section>
                <div class="data_table compare_sec">
                    <div id="admin">
                        <div class="material-table table-responsive">
                            <div class="table-header">
                                <span class="table-title">Quote Amendments</span>
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
                                                            <td><div class="main_question"><label class="form_label bold">Workmen’s Maintenance clause</label></div></td>
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
                                                            <td><div class="main_question"><label class="form_label bold">Nominated Loss Adjuster clause-Insured can select the loss surveyor out of a panel – John Kidd LA, Cunningham Lindsey, & Miller International</label></div></td>
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
                                                            <td><div class="main_question"><label class="form_label bold">Auditor’s fee</label></div></td>
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
    
                                                    @if($pipeline_details['formData']['bankPolicy']['bankPolicy'] == true)
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
                                                            <td><div class="main_question"><label class="form_label bold">Loss Notification – ‘as soon as reasonably practicable</label></div></td>
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
                                                                <td><div class="main_question"><label class="form_label bold">Rate (combined)</label></div></td>
                                                                <td class="main_answer"><div class="ans">{{number_format($pipeline_details['formData']['claimPremiyumDetails']['rateCombined'],2)}}</div></td>
                                                            </tr>
                                                            <tr>
                                                                <td><div class="main_question"><label class="form_label bold">Premium (combined)</label></div></td>
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
                                                                <td><div class="main_question"><label class="form_label bold">Rate </label></div></td>
                                                                <td class="main_answer"><div class="ans">{{number_format($pipeline_details['formData']['claimPremiyumDetails']['propertyRate'],2)}}</div></td>
                                                            </tr>
                                                            <tr>
                                                                <td><div class="main_question"><label class="form_label bold">Premium </label></div></td>
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
                                                                <td><div class="main_question"><label class="form_label bold">Rate (Property)</label></div></td>
                                                                <td class="main_answer"><div class="ans">{{number_format($pipeline_details['formData']['claimPremiyumDetails']['propertySeparateRate'],2)}}</div></td>
                                                            </tr>
                                                            <tr>
                                                                <td><div class="main_question"><label class="form_label bold">Premium (Property)</label></div></td>
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
                                                                <td><div class="main_question"><label class="form_label bold">Rate (Business Interruption)</label></div></td>
                                                                <td class="main_answer"><div class="ans">{{number_format($pipeline_details['formData']['claimPremiyumDetails']['businessSeparateRate'],2)}}</div></td>
                                                            </tr>
                                                            <tr>
                                                                <td><div class="main_question"><label class="form_label bold">Premium (Business Interruption)</label></div></td>
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
    
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">CUSTOMER DECISION</label></div></td>
                                                <td class="main_answer"><div class="ans"></div></td>
                                            </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="table_sep_pen">
                                    <div class="material-table table-responsive">
                                        <table class="table comparison table-bordered" style="table-layout: auto">
                                            <thead>
                                            <tr>

												<?php $selected_insures_count=count(@$selectedId);?>
												<?php $insure_count=count(@$insures_details);?>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))  <th>


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
                                                            <div class="ans">  <span data-toggle="tooltip" data-placement="right" title="{{$insures_details[$i]['insurerDetails']['insurerName']}}" data-container="body">{{substr(ucfirst($insures_details[$i]['insurerDetails']['insurerName']), 0, 32).$dot}}</span></div>
                                                        @else
                                                            <div class="ans">   <span>{{$insures_details[$i]['insurerDetails']['insurerName']}}</span></div>
                                                        @endif

                                                    </th> @endif
                                                @endfor
                                            </tr>
                                            </thead>
                                            <tbody class="syncscroll"  name="myElements">

                                                    @if($pipeline_details['formData']['saleClause'] == true)
                                                    <tr>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                <td><div class="ans">{{$insures_details[$i]['saleClause']}}</div></td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                   
                                                @endif

                                                @if($pipeline_details['formData']['fireBrigade']==true)
                                                    <tr>
                                                        @if(isset($pipeline_details['formData']['fireBrigade']))
                                                            @for ($i = 0; $i < $insure_count; $i++)
                                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                    @if(isset($insures_details[$i]['fireBrigade']['comment']))
                                                                        @if($insures_details[$i]['fireBrigade']['comment']!="")
                                                                            <td class="tooltip_sec"><div class="ans">
                                                                                    <span>{{$insures_details[$i]['fireBrigade']['isAgree']}}</span>
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details[$i]['fireBrigade']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title=""
                                                                                    data-container="body" data-original-title="{{$insures_details[$i]['fireBrigade']['comment']}}"></i> --}}
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td><div class="ans">{{$insures_details[$i]['fireBrigade']['isAgree']}}</div></td>
                                                                        @endif
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['clauseWording']==true) 
                                                    <tr>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                <td><div class="ans">{{$insures_details[$i]['clauseWording']}}</div></td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['automaticReinstatement']==true) 
                                                    <tr>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                <td><div class="ans">{{$insures_details[$i]['automaticReinstatement']}}</div></td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['capitalClause']==true)
                                                    <tr>
                                                        @if(isset($pipeline_details['formData']['capitalClause']))
                                                            @for ($i = 0; $i < $insure_count; $i++)
                                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                    @if(isset($insures_details[$i]['capitalClause']['comment']))
                                                                        @if($insures_details[$i]['capitalClause']['comment']!="")
                                                                            <td class="tooltip_sec"><div class="ans">
                                                                                    <span>{{$insures_details[$i]['capitalClause']['isAgree']}}</span>
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details[$i]['capitalClause']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title=""
                                                                                    data-container="body" data-original-title="{{$insures_details[$i]['capitalClause']['comment']}}"></i> --}}
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td><div class="ans">{{$insures_details[$i]['capitalClause']['isAgree']}}</div></td>
                                                                        @endif
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif
                                                 
                                                @if($pipeline_details['formData']['mainClause']==true) 
                                                    <tr>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                <td><div class="ans">{{$insures_details[$i]['mainClause']}}</div></td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['repairCost']==true)
                                                    <tr>
                                                        @if(isset($pipeline_details['formData']['repairCost']))
                                                            @for ($i = 0; $i < $insure_count; $i++)
                                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                    @if(isset($insures_details[$i]['repairCost']['comment']))
                                                                        @if($insures_details[$i]['repairCost']['comment']!="")
                                                                            <td class="tooltip_sec"><div class="ans">
                                                                                    <span>{{$insures_details[$i]['repairCost']['isAgree']}}</span>
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details[$i]['repairCost']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title=""
                                                                                    data-container="body" data-original-title="{{$insures_details[$i]['repairCost']['comment']}}"></i> --}}
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td><div class="ans">{{$insures_details[$i]['repairCost']['isAgree']}}</div></td>
                                                                        @endif
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['debris']==true)
                                                    <tr>
                                                        @if(isset($pipeline_details['formData']['debris']))
                                                            @for ($i = 0; $i < $insure_count; $i++)
                                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                    @if(isset($insures_details[$i]['debris']['comment']))
                                                                        @if($insures_details[$i]['debris']['comment']!="")
                                                                            <td class="tooltip_sec"><div class="ans">
                                                                                    <span>{{$insures_details[$i]['debris']['isAgree']}}</span>
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details[$i]['debris']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title=""
                                                                                    data-container="body" data-original-title="{{$insures_details[$i]['debris']['comment']}}"></i> --}}
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td><div class="ans">{{$insures_details[$i]['debris']['isAgree']}}</div></td>
                                                                        @endif
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['reinstatementValClass']==true) 
                                                    <tr>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                <td><div class="ans">{{$insures_details[$i]['reinstatementValClass']}}</div></td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['waiver']==true) 
                                                    <tr>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                <td><div class="ans">{{$insures_details[$i]['waiver']}}</div></td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['trace']==true) 
                                                    <tr>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                <td><div class="ans">{{$insures_details[$i]['trace']}}</div></td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['publicClause']==true)
                                                    <tr>
                                                        @if(isset($pipeline_details['formData']['publicClause']))
                                                            @for ($i = 0; $i < $insure_count; $i++)
                                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                    @if(isset($insures_details[$i]['publicClause']['comment']))
                                                                        @if($insures_details[$i]['publicClause']['comment']!="")
                                                                            <td class="tooltip_sec"><div class="ans">
                                                                                    <span>{{$insures_details[$i]['publicClause']['isAgree']}}</span>
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details[$i]['publicClause']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title=""
                                                                                    data-container="body" data-original-title="{{$insures_details[$i]['publicClause']['comment']}}"></i> --}}
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td><div class="ans">{{$insures_details[$i]['publicClause']['isAgree']}}</div></td>
                                                                        @endif
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['contentsClause']==true)
                                                    <tr>
                                                        @if(isset($pipeline_details['formData']['contentsClause']))
                                                            @for ($i = 0; $i < $insure_count; $i++)
                                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                    @if(isset($insures_details[$i]['contentsClause']['comment']))
                                                                        @if($insures_details[$i]['contentsClause']['comment']!="")
                                                                            <td class="tooltip_sec"><div class="ans">
                                                                                    <span>{{$insures_details[$i]['contentsClause']['isAgree']}}</span>
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details[$i]['contentsClause']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title=""
                                                                                    data-container="body" data-original-title="{{$insures_details[$i]['contentsClause']['comment']}}"></i> --}}
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td><div class="ans">{{$insures_details[$i]['contentsClause']['isAgree']}}</div></td>
                                                                        @endif
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['errorOmission']==true) 
                                                    <tr>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                <td><div class="ans">{{$insures_details[$i]['errorOmission']}}</div></td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['alterationClause']==true) 
                                                    <tr>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                <td><div class="ans">{{$insures_details[$i]['alterationClause']}}</div></td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['tempRemovalClause'] == true)
                                                    <tr>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                <td><div class="ans">{{$insures_details[$i]['tempRemovalClause']}}</div></td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @endif

                                               

                                                @if($pipeline_details['formData']['proFee']==true)
                                                    <tr>
                                                        @if(isset($pipeline_details['formData']['proFee']))
                                                            @for ($i = 0; $i < $insure_count; $i++)
                                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                    @if(isset($insures_details[$i]['proFee']['comment']))
                                                                        @if($insures_details[$i]['proFee']['comment']!="")
                                                                            <td class="tooltip_sec"><div class="ans">
                                                                                    <span>{{$insures_details[$i]['proFee']['isAgree']}}</span>
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details[$i]['proFee']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title=""
                                                                                    data-container="body" data-original-title="{{$insures_details[$i]['proFee']['comment']}}"></i> --}}
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td><div class="ans">{{$insures_details[$i]['proFee']['isAgree']}}</div></td>
                                                                        @endif
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif
                                                
                                                @if($pipeline_details['formData']['expenseClause']==true)
                                                    <tr>
                                                        @if(isset($pipeline_details['formData']['expenseClause']))
                                                            @for ($i = 0; $i < $insure_count; $i++)
                                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                    @if(isset($insures_details[$i]['expenseClause']['comment']))
                                                                        @if($insures_details[$i]['expenseClause']['comment']!="")
                                                                            <td class="tooltip_sec"><div class="ans">
                                                                                    <span>{{$insures_details[$i]['expenseClause']['isAgree']}}</span>
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details[$i]['expenseClause']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title=""
                                                                                    data-container="body" data-original-title="{{$insures_details[$i]['expenseClause']['comment']}}"></i> --}}
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td><div class="ans">{{$insures_details[$i]['expenseClause']['isAgree']}}</div></td>
                                                                        @endif
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['desigClause']==true)
                                                    <tr>
                                                        @if(isset($pipeline_details['formData']['desigClause']))
                                                            @for ($i = 0; $i < $insure_count; $i++)
                                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                    @if(isset($insures_details[$i]['desigClause']['comment']))
                                                                        @if($insures_details[$i]['desigClause']['comment']!="")
                                                                            <td class="tooltip_sec"><div class="ans">
                                                                                    <span>{{$insures_details[$i]['desigClause']['isAgree']}}</span>
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details[$i]['desigClause']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title=""
                                                                                    data-container="body" data-original-title="{{$insures_details[$i]['desigClause']['comment']}}"></i> --}}
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td><div class="ans">{{$insures_details[$i]['desigClause']['isAgree']}}</div></td>
                                                                        @endif
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif

                                                @if(isset($pipeline_details['formData']['buildingInclude']) && $pipeline_details['formData']['buildingInclude'] == true)    
                                                    <tr>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                <td><div class="ans">{{$insures_details[$i]['adjBusinessClause']}}</div></td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['cancelThirtyClause']==true) 
                                                    <tr>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                <td><div class="ans">{{$insures_details[$i]['cancelThirtyClause']}}</div></td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['primaryInsuranceClause']==true) 
                                                    <tr>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                <td><div class="ans">{{$insures_details[$i]['primaryInsuranceClause']}}</div></td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['paymentAccountClause']==true)
                                                    <tr>
                                                        @if(isset($pipeline_details['formData']['paymentAccountClause']))
                                                            @for ($i = 0; $i < $insure_count; $i++)
                                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                    @if(isset($insures_details[$i]['paymentAccountClause']['comment']))
                                                                        @if($insures_details[$i]['paymentAccountClause']['comment']!="")
                                                                            <td class="tooltip_sec"><div class="ans">
                                                                                    <span>{{$insures_details[$i]['paymentAccountClause']['isAgree']}}</span>
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details[$i]['paymentAccountClause']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title=""
                                                                                    data-container="body" data-original-title="{{$insures_details[$i]['paymentAccountClause']['comment']}}"></i> --}}
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td><div class="ans">{{$insures_details[$i]['paymentAccountClause']['isAgree']}}</div></td>
                                                                        @endif
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['nonInvalidClause']==true) 
                                                    <tr>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                <td><div class="ans">{{$insures_details[$i]['nonInvalidClause']}}</div></td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['warrantyConditionClause']==true) 
                                                    <tr>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                <td><div class="ans">{{$insures_details[$i]['warrantyConditionClause']}}</div></td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['escalationClause']==true)
                                                    <tr>
                                                        @if(isset($pipeline_details['formData']['escalationClause']))
                                                            @for ($i = 0; $i < $insure_count; $i++)
                                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                    @if(isset($insures_details[$i]['escalationClause']['comment']))
                                                                        @if($insures_details[$i]['escalationClause']['comment']!="")
                                                                            <td class="tooltip_sec"><div class="ans">
                                                                                    <span>{{$insures_details[$i]['escalationClause']['isAgree']}}</span>
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details[$i]['escalationClause']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title=""
                                                                                    data-container="body" data-original-title="{{$insures_details[$i]['escalationClause']['comment']}}"></i> --}}
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td><div class="ans">{{$insures_details[$i]['escalationClause']['isAgree']}}</div></td>
                                                                        @endif
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['addInterestClause']==true) 
                                                    <tr>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                <td><div class="ans">{{$insures_details[$i]['addInterestClause']}}</div></td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @endif

                                                @if(isset($pipeline_details['formData']['stock']) && $pipeline_details['formData']['stock']!='')
                                                    <tr>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['stockDeclaration']['comment']))
                                                                    @if($insures_details[$i]['stockDeclaration']['comment']!="")
                                                                        <td class="tooltip_sec"><div class="ans">
                                                                                <span>{{$insures_details[$i]['stockDeclaration']['isAgree']}}</span>
                                                                                <div class="post_comments">
                                                                                        <div class="post_comments_main clearfix">
                                                                                            <div class="media">
                                                                                                <div class="media-body">
                                                                                                    <span  class="comment_txt">{{$insures_details[$i]['stockDeclaration']['comment']}}</span>        
                                                                                                </div>
                                                                                              
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['stockDeclaration']['comment']}}"></i> --}}
                                                                            </div>
                                                                        </td>
                                                                    @else
                                                                        <td><div class="ans">{{$insures_details[$i]['stockDeclaration']['isAgree']}}</div></td>
                                                                    @endif
                                                                @else
                                                                    <td><div class="ans">--</div></td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['improvementClause']==true) 
                                                    <tr>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                <td><div class="ans">{{$insures_details[$i]['improvementClause']}}</div></td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['automaticClause']==true)
                                                    <tr>
                                                        @if(isset($pipeline_details['formData']['automaticClause']))
                                                            @for ($i = 0; $i < $insure_count; $i++)
                                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                    @if(isset($insures_details[$i]['automaticClause']['comment']))
                                                                        @if($insures_details[$i]['automaticClause']['comment']!="")
                                                                            <td class="tooltip_sec"><div class="ans">
                                                                                    <span>{{$insures_details[$i]['automaticClause']['isAgree']}}</span>
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details[$i]['automaticClause']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title=""
                                                                                    data-container="body" data-original-title="{{$insures_details[$i]['automaticClause']['comment']}}"></i> --}}
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td><div class="ans">{{$insures_details[$i]['automaticClause']['isAgree']}}</div></td>
                                                                        @endif
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif
                                                 @if( $pipeline_details['formData']['reduseLoseClause']==true)
                                                    <tr>
                                                        @if(isset($pipeline_details['formData']['reduseLoseClause']))
                                                            @for ($i = 0; $i < $insure_count; $i++)
                                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                    @if(isset($insures_details[$i]['reduseLoseClause']['comment']))
                                                                        @if($insures_details[$i]['reduseLoseClause']['comment']!="")
                                                                            <td class="tooltip_sec"><div class="ans">
                                                                                    <span>{{$insures_details[$i]['reduseLoseClause']['isAgree']}}</span>
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details[$i]['reduseLoseClause']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title=""
                                                                                    data-container="body" data-original-title="{{$insures_details[$i]['reduseLoseClause']['comment']}}"></i> --}}
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td><div class="ans">{{$insures_details[$i]['reduseLoseClause']['isAgree']}}</div></td>
                                                                        @endif
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif

                                               

                                                @if($pipeline_details['formData']['buildingInclude']!='')

                                                    <tr>
                                                        @if(isset($pipeline_details['formData']['demolitionClause']))
                                                            @for ($i = 0; $i < $insure_count; $i++)
                                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                    @if(isset($insures_details[$i]['demolitionClause']['comment']))
                                                                        @if($insures_details[$i]['demolitionClause']['comment']!="")
                                                                            <td class="tooltip_sec"><div class="ans">
                                                                                    <span>{{$insures_details[$i]['demolitionClause']['isAgree']}}</span>
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details[$i]['demolitionClause']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title=""
                                                                                    data-container="body" data-original-title="{{$insures_details[$i]['demolitionClause']['comment']}}"></i> --}}
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td><div class="ans">{{$insures_details[$i]['demolitionClause']['isAgree']}}</div></td>
                                                                        @endif
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                 
                                                @endif

                                                @if($pipeline_details['formData']['noControlClause']==true) 
                                                    <tr>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                <td><div class="ans">{{$insures_details[$i]['noControlClause']}}</div></td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['preparationCostClause'] == true)
                                                    <tr>
                                                        @if(isset($pipeline_details['formData']['preparationCostClause']))
                                                            @for ($i = 0; $i < $insure_count; $i++)
                                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                    @if(isset($insures_details[$i]['preparationCostClause']['comment']))
                                                                        @if($insures_details[$i]['preparationCostClause']['comment']!="")
                                                                            <td class="tooltip_sec"><div class="ans">
                                                                                    <span>{{$insures_details[$i]['preparationCostClause']['isAgree']}}</span>
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details[$i]['preparationCostClause']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title=""
                                                                                    data-container="body" data-original-title="{{$insures_details[$i]['preparationCostClause']['comment']}}"></i> --}}
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td><div class="ans">{{$insures_details[$i]['preparationCostClause']['isAgree']}}</div></td>
                                                                        @endif
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['coverPropertyCon']==true) 
                                                    <tr>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                <td><div class="ans">{{$insures_details[$i]['coverPropertyCon']}}</div></td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['personalEffectsEmployee'] == true)
                                                    <tr>
                                                        @if(isset($pipeline_details['formData']['personalEffectsEmployee']))
                                                            @for ($i = 0; $i < $insure_count; $i++)
                                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                    @if(isset($insures_details[$i]['personalEffectsEmployee']['comment']))
                                                                        @if($insures_details[$i]['personalEffectsEmployee']['comment']!="")
                                                                            <td class="tooltip_sec"><div class="ans">
                                                                                    <span>{{$insures_details[$i]['personalEffectsEmployee']['isAgree']}}</span>
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details[$i]['personalEffectsEmployee']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title=""
                                                                                    data-container="body" data-original-title="{{$insures_details[$i]['personalEffectsEmployee']['comment']}}"></i> --}}
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td><div class="ans">{{$insures_details[$i]['personalEffectsEmployee']['isAgree']}}</div></td>
                                                                        @endif
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['incidentLandTransit'] == true)
                                                    <tr>
                                                        @if(isset($pipeline_details['formData']['incidentLandTransit']))
                                                            @for ($i = 0; $i < $insure_count; $i++)
                                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                    @if(isset($insures_details[$i]['incidentLandTransit']['comment']))
                                                                        @if($insures_details[$i]['incidentLandTransit']['comment']!="")
                                                                            <td class="tooltip_sec"><div class="ans">
                                                                                    <span>{{$insures_details[$i]['incidentLandTransit']['isAgree']}}</span>
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details[$i]['incidentLandTransit']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title=""
                                                                                    data-container="body" data-original-title="{{$insures_details[$i]['incidentLandTransit']['comment']}}"></i> --}}
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td><div class="ans">{{$insures_details[$i]['incidentLandTransit']['isAgree']}}</div></td>
                                                                        @endif
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['lossOrDamage']==true) 
                                                    <tr>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                <td><div class="ans">{{$insures_details[$i]['lossOrDamage']}}</div></td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['nominatedLossAdjusterClause'] == true)
                                                    <tr>
                                                        @if(isset($pipeline_details['formData']['nominatedLossAdjusterClause']))
                                                            @for ($i = 0; $i < $insure_count; $i++)
                                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                    @if(isset($insures_details[$i]['nominatedLossAdjusterClause']['comment']))
                                                                        @if($insures_details[$i]['nominatedLossAdjusterClause']['comment']!="")
                                                                            <td class="tooltip_sec"><div class="ans">
                                                                                    <span>{{$insures_details[$i]['nominatedLossAdjusterClause']['isAgree']}}</span>
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details[$i]['nominatedLossAdjusterClause']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title=""
                                                                                    data-container="body" data-original-title="{{$insures_details[$i]['nominatedLossAdjusterClause']['comment']}}"></i> --}}
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td><div class="ans">{{$insures_details[$i]['nominatedLossAdjusterClause']['isAgree']}}</div></td>
                                                                        @endif
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['sprinkerLeakage']==true) 
                                                    <tr>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                <td><div class="ans">{{$insures_details[$i]['sprinkerLeakage']}}</div></td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['minLossClause'] == true)
                                                    <tr>
                                                        @if(isset($pipeline_details['formData']['minLossClause']))
                                                            @for ($i = 0; $i < $insure_count; $i++)
                                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                    @if(isset($insures_details[$i]['minLossClause']['comment']))
                                                                        @if($insures_details[$i]['minLossClause']['comment']!="")
                                                                            <td class="tooltip_sec"><div class="ans">
                                                                                    <span>{{$insures_details[$i]['minLossClause']['isAgree']}}</span>
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details[$i]['minLossClause']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title=""
                                                                                    data-container="body" data-original-title="{{$insures_details[$i]['minLossClause']['comment']}}"></i> --}}
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td><div class="ans">{{$insures_details[$i]['minLossClause']['isAgree']}}</div></td>
                                                                        @endif
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['costConstruction'] == true)
                                                    <tr>
                                                        @if(isset($pipeline_details['formData']['costConstruction']))
                                                            @for ($i = 0; $i < $insure_count; $i++)
                                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                    @if(isset($insures_details[$i]['costConstruction']['comment']))
                                                                        @if($insures_details[$i]['costConstruction']['comment']!="")
                                                                            <td class="tooltip_sec"><div class="ans">
                                                                                    <span>{{$insures_details[$i]['costConstruction']['isAgree']}}</span>
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details[$i]['costConstruction']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title=""
                                                                                    data-container="body" data-original-title="{{$insures_details[$i]['costConstruction']['comment']}}"></i> --}}
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td><div class="ans">{{$insures_details[$i]['costConstruction']['isAgree']}}</div></td>
                                                                        @endif
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['annualRent'] && $pipeline_details['formData']['annualRent'] != '')
                                                    <tr>
                                                        @if(isset($pipeline_details['formData']['lossRent']))
                                                            @for ($i = 0; $i < $insure_count; $i++)
                                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                    @if(isset($insures_details[$i]['lossRent']['comment']))
                                                                        @if($insures_details[$i]['lossRent']['comment']!="")
                                                                            <td class="tooltip_sec"><div class="ans">
                                                                                    <span>{{$insures_details[$i]['lossRent']['isAgree']}}</span>
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details[$i]['lossRent']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title=""
                                                                                    data-container="body" data-original-title="{{$insures_details[$i]['lossRent']['comment']}}"></i> --}}
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td><div class="ans">{{$insures_details[$i]['lossRent']['isAgree']}}</div></td>
                                                                        @endif
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr> 
                                                @endif

                                                @if($pipeline_details['formData']['propertyValuationClause'] == true)
                                                    <tr>
                                                        @if(isset($pipeline_details['formData']['propertyValuationClause']))
                                                            @for ($i = 0; $i < $insure_count; $i++)
                                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                    @if(isset($insures_details[$i]['propertyValuationClause']['comment']))
                                                                        @if($insures_details[$i]['propertyValuationClause']['comment']!="")
                                                                            <td class="tooltip_sec"><div class="ans">
                                                                                    <span>{{$insures_details[$i]['propertyValuationClause']['isAgree']}}</span>
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details[$i]['propertyValuationClause']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title=""
                                                                                    data-container="body" data-original-title="{{$insures_details[$i]['propertyValuationClause']['comment']}}"></i> --}}
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td><div class="ans">{{$insures_details[$i]['propertyValuationClause']['isAgree']}}</div></td>
                                                                        @endif
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['accidentalDamage'] == true)
                                                    <tr>
                                                        @if(isset($pipeline_details['formData']['accidentalDamage']))
                                                            @for ($i = 0; $i < $insure_count; $i++)
                                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                    @if(isset($insures_details[$i]['accidentalDamage']['comment']))
                                                                        @if($insures_details[$i]['accidentalDamage']['comment']!="")
                                                                            <td class="tooltip_sec"><div class="ans">
                                                                                    <span>{{$insures_details[$i]['accidentalDamage']['isAgree']}}</span>
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details[$i]['accidentalDamage']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title=""
                                                                                    data-container="body" data-original-title="{{$insures_details[$i]['accidentalDamage']['comment']}}"></i> --}}
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td><div class="ans">{{$insures_details[$i]['accidentalDamage']['isAgree']}}</div></td>
                                                                        @endif
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['auditorsFee'] == true)
                                                    <tr>
                                                        @if(isset($pipeline_details['formData']['auditorsFee']))
                                                            @for ($i = 0; $i < $insure_count; $i++)
                                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                    @if(isset($insures_details[$i]['auditorsFee']['comment']))
                                                                        @if($insures_details[$i]['auditorsFee']['comment']!="")
                                                                            <td class="tooltip_sec"><div class="ans">
                                                                                    <span>{{$insures_details[$i]['auditorsFee']['isAgree']}}</span>
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details[$i]['auditorsFee']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title=""
                                                                                    data-container="body" data-original-title="{{$insures_details[$i]['auditorsFee']['comment']}}"></i> --}}
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td><div class="ans">{{$insures_details[$i]['auditorsFee']['isAgree']}}</div></td>
                                                                        @endif
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['smokeSoot']==true) 
                                                    <tr>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                <td><div class="ans">{{$insures_details[$i]['smokeSoot']}}</div></td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['boilerExplosion']==true) 
                                                    <tr>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                <td><div class="ans">{{$insures_details[$i]['boilerExplosion']}}</div></td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['chargeAirfreight'] == true)
                                                    <tr>
                                                        @if(isset($pipeline_details['formData']['chargeAirfreight']))
                                                            @for ($i = 0; $i < $insure_count; $i++)
                                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                    @if(isset($insures_details[$i]['chargeAirfreight']['comment']))
                                                                        @if($insures_details[$i]['chargeAirfreight']['comment']!="")
                                                                            <td class="tooltip_sec"><div class="ans">
                                                                                    <span>{{$insures_details[$i]['chargeAirfreight']['isAgree']}}</span>
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details[$i]['chargeAirfreight']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title=""
                                                                                    data-container="body" data-original-title="{{$insures_details[$i]['chargeAirfreight']['comment']}}"></i> --}}
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td><div class="ans">{{$insures_details[$i]['chargeAirfreight']['isAgree']}}</div></td>
                                                                        @endif
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['tempRemoval']==true) 
                                                    <tr>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                <td><div class="ans">{{$insures_details[$i]['tempRemoval']}}</div></td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @endif
                                             
                                                @if($pipeline_details['formData']['strikeRiot'] == true)
                                                    <tr>
                                                        @if(isset($pipeline_details['formData']['strikeRiot']))
                                                            @for ($i = 0; $i < $insure_count; $i++)
                                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                    @if(isset($insures_details[$i]['strikeRiot']['comment']))
                                                                        @if($insures_details[$i]['strikeRiot']['comment']!="")
                                                                            <td class="tooltip_sec"><div class="ans">
                                                                                    <span>{{$insures_details[$i]['strikeRiot']['isAgree']}}</span>
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details[$i]['strikeRiot']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title=""
                                                                                    data-container="body" data-original-title="{{$insures_details[$i]['strikeRiot']['comment']}}"></i> --}}
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td><div class="ans">{{$insures_details[$i]['strikeRiot']['isAgree']}}</div></td>
                                                                        @endif
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['coverMechanical'] == true)
                                                    <tr>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                <td><div class="ans">{{$insures_details[$i]['coverMechanical']}}</div></td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['coverExtWork'] == true)
                                                    <tr>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                <td><div class="ans">{{$insures_details[$i]['coverExtWork']}}</div></td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['misdescriptionClause'] == true)
                                                    <tr>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                <td><div class="ans">{{$insures_details[$i]['misdescriptionClause']}}</div></td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @endif

                                               
                                            
                                                @if($pipeline_details['formData']['otherInsuranceClause'] == true)
                                                    <tr>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                <td><div class="ans">{{$insures_details[$i]['otherInsuranceClause']}}</div></td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['automaticAcqClause'] == true)
                                                    <tr>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                <td><div class="ans">{{$insures_details[$i]['automaticAcqClause']}}</div></td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @endif

                                                @if(@$pipeline_details['formData']['occupancy']['type']=='Residence' || @$pipeline_details['formData']['occupancy']['type']=='Labour Camp')
                                                    <tr>
                                                        @if(@$pipeline_details['formData']['occupancy']['type']=='Residence' || @$pipeline_details['formData']['occupancy']['type']=='Labour Camp')
                                                            @for ($i = 0; $i < $insure_count; $i++)
                                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                    @if(isset($insures_details[$i]['coverAlternative']['comment']))
                                                                        @if($insures_details[$i]['coverAlternative']['comment']!="")
                                                                            <td class="tooltip_sec"><div class="ans">
                                                                                    <span>{{$insures_details[$i]['coverAlternative']['isAgree']}}</span>
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details[$i]['coverAlternative']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title=""
                                                                                     data-container="body" data-original-title="{{$insures_details[$i]['coverAlternative']['comment']}}"></i> --}}
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td><div class="ans">{{$insures_details[$i]['coverAlternative']['isAgree']}}</div></td>
                                                                        @endif
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['businessType'])
                                                    <tr>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                <td><div class="ans">{{$insures_details[$i]['coverExihibition']}}</div></td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @endif


                                                @if(@$pipeline_details['formData']['occupancy']['type']=='Warehouse'
                                                ||  @$pipeline_details['formData']['occupancy']['type']=='Factory'
                                                ||  @$pipeline_details['formData']['occupancy']['type']=='Others')
                                                  <tr>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                <td><div class="ans">{{$insures_details[$i]['coverProperty']}}</div></td>
                                                            @endif
                                                        @endfor
                                                    </tr>  
                                                @endif

                                                @if(isset($pipeline_details['formData']['otherItems']) && $pipeline_details['formData']['otherItems']!='')
                                                     <tr>
                                                        @if(isset($pipeline_details['formData']['otherItems']) && $pipeline_details['formData']['otherItems']!='')
                                                            @for ($i = 0; $i < $insure_count; $i++)
                                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                    @if(isset($insures_details[$i]['propertyCare']['comment']))
                                                                        @if($insures_details[$i]['propertyCare']['comment']!="")
                                                                            <td class="tooltip_sec"><div class="ans">
                                                                                    <span>{{$insures_details[$i]['propertyCare']['isAgree']}}</span>
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details[$i]['propertyCare']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title=""
                                                                                     data-container="body" data-original-title="{{$insures_details[$i]['propertyCare']['comment']}}"></i> --}}
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td><div class="ans">{{$insures_details[$i]['propertyCare']['isAgree']}}</div></td>
                                                                        @endif
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif


                                                @if($pipeline_details['formData']['minorWorkExt'] == true)
                                                    <tr>
                                                        @if(isset($pipeline_details['formData']['minorWorkExt']))
                                                            @for ($i = 0; $i < $insure_count; $i++)
                                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                    @if(isset($insures_details[$i]['minorWorkExt']['comment']))
                                                                        @if($insures_details[$i]['minorWorkExt']['comment']!="")
                                                                            <td class="tooltip_sec"><div class="ans">
                                                                                    <span>{{$insures_details[$i]['minorWorkExt']['isAgree']}}</span>
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details[$i]['minorWorkExt']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title=""
                                                                                    data-container="body" data-original-title="{{$insures_details[$i]['minorWorkExt']['comment']}}"></i> --}}
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td><div class="ans">{{$insures_details[$i]['minorWorkExt']['isAgree']}}</div></td>
                                                                        @endif
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['saleInterestClause'] == true)
                                                    <tr>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                <td><div class="ans">{{$insures_details[$i]['saleInterestClause']}}</div></td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @endif


                                                @if($pipeline_details['formData']['sueLabourClause'] == true)
                                                    <tr>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                <td><div class="ans">{{$insures_details[$i]['sueLabourClause']}}</div></td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['bankPolicy']['bankPolicy'] == true)
                                                    <tr>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                <td><div class="ans">{{$insures_details[$i]['lossPayee']}}</div></td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @endif


                                                @if($pipeline_details['formData']['electricalClause'] == true)
                                                    <tr>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                <td><div class="ans">{{$insures_details[$i]['electricalClause']}}</div></td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['contractPriceClause'] == true)
                                                    <tr>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                <td><div class="ans">{{$insures_details[$i]['contractPriceClause']}}</div></td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['sprinklerUpgradationClause'] == true)
                                                    <tr>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                <td><div class="ans">{{$insures_details[$i]['sprinklerUpgradationClause']}}</div></td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['accidentalFixClass'] == true)
                                                    <tr>
                                                        @if(isset($pipeline_details['formData']['accidentalFixClass']))
                                                            @for ($i = 0; $i < $insure_count; $i++)
                                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                    @if(isset($insures_details[$i]['accidentalFixClass']['comment']))
                                                                        @if($insures_details[$i]['accidentalFixClass']['comment']!="")
                                                                            <td class="tooltip_sec"><div class="ans">
                                                                                    <span>{{$insures_details[$i]['accidentalFixClass']['isAgree']}}</span>
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details[$i]['accidentalFixClass']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title=""
                                                                                    data-container="body" data-original-title="{{$insures_details[$i]['accidentalFixClass']['comment']}}"></i> --}}
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td><div class="ans">{{$insures_details[$i]['accidentalFixClass']['isAgree']}}</div></td>
                                                                        @endif
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['electronicInstallation'] == true)
                                                    <tr>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                <td><div class="ans">{{$insures_details[$i]['electronicInstallation']}}</div></td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['businessType']=="Art galleries/ fine arts collection"
                                                || $pipeline_details['formData']['businessType']=="Colleges/ Universities/ schools & educational institute"
                                                || $pipeline_details['formData']['businessType']=="Hotels/ boarding houses/ motels/ service apartments"
                                                || $pipeline_details['formData']['businessType']=="Hotel multiple cover"
                                                || $pipeline_details['formData']['businessType']=="Museum/ heritage sites"
                                                )

                                                    <tr>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                <td><div class="ans">{{$insures_details[$i]['coverCurios']}}</div></td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['brandTrademark'] == true)
                                                    <tr>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                <td><div class="ans">{{$insures_details[$i]['brandTrademark']}}</div></td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['ownerPrinciple']==true) 
                                                    <tr>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                <td><div class="ans">{{$insures_details[$i]['ownerPrinciple']}}</div></td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['conductClause']==true) 
                                                    <tr>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                <td><div class="ans">{{$insures_details[$i]['conductClause']}}</div></td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['lossNotification'] == true)
                                                    <tr>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                <td><div class="ans">{{$insures_details[$i]['lossNotification']}}</div></td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['brockersClaimClause'] == true)
                                                    <tr>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                <td><div class="ans">{{$insures_details[$i]['brockersClaimClause']}}</div></td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['businessInterruption']['business_interruption'] ==true &&
                                                    $pipeline_details['formData']['addCostWorking'] == true)
                                                    <tr>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                <td><div class="ans">{{$insures_details[$i]['addCostWorking']}}</div></td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @endif 

                                                @if($pipeline_details['formData']['businessInterruption']['business_interruption'] ==true &&
                                                $pipeline_details['formData']['claimPreparationClause'] == true)
                                                    <tr>
                                                        @if(isset($pipeline_details['formData']['claimPreparationClause']))
                                                            @for ($i = 0; $i < $insure_count; $i++)
                                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                    @if(isset($insures_details[$i]['claimPreparationClause']['comment']))
                                                                        @if($insures_details[$i]['claimPreparationClause']['comment']!="")
                                                                            <td class="tooltip_sec"><div class="ans">
                                                                                    <span>{{$insures_details[$i]['claimPreparationClause']['isAgree']}}</span>
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details[$i]['claimPreparationClause']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title=""
                                                                                    data-container="body" data-original-title="{{$insures_details[$i]['claimPreparationClause']['comment']}}"></i> --}}
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td><div class="ans">{{$insures_details[$i]['claimPreparationClause']['isAgree']}}</div></td>
                                                                        @endif
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                 @endif   
                                             
                                             
                                             
                                             
                                                @if($pipeline_details['formData']['businessInterruption']['business_interruption'] ==true &&
                                                    $pipeline_details['formData']['suppliersExtension'] == true)
                                                    <tr>
                                                        @if(isset($pipeline_details['formData']['suppliersExtension']))
                                                            @for ($i = 0; $i < $insure_count; $i++)
                                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                    @if(isset($insures_details[$i]['suppliersExtension']['comment']))
                                                                        @if($insures_details[$i]['suppliersExtension']['comment']!="")
                                                                            <td class="tooltip_sec"><div class="ans">
                                                                                    <span>{{$insures_details[$i]['suppliersExtension']['isAgree']}}</span>
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details[$i]['suppliersExtension']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title=""
                                                                                    data-container="body" data-original-title="{{$insures_details[$i]['suppliersExtension']['comment']}}"></i> --}}
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td><div class="ans">{{$insures_details[$i]['suppliersExtension']['isAgree']}}</div></td>
                                                                        @endif
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif  

                                                @if($pipeline_details['formData']['businessInterruption']['business_interruption'] ==true &&
                                                    $pipeline_details['formData']['accountantsClause'] == true)
                                                    <tr>
                                                        @if(isset($pipeline_details['formData']['accountantsClause']))
                                                            @for ($i = 0; $i < $insure_count; $i++)
                                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                    @if(isset($insures_details[$i]['accountantsClause']['comment']))
                                                                        @if($insures_details[$i]['accountantsClause']['comment']!="")
                                                                            <td class="tooltip_sec"><div class="ans">
                                                                                    <span>{{$insures_details[$i]['accountantsClause']['isAgree']}}</span>
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details[$i]['accountantsClause']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title=""
                                                                                    data-container="body" data-original-title="{{$insures_details[$i]['accountantsClause']['comment']}}"></i> --}}
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td><div class="ans">{{$insures_details[$i]['accountantsClause']['isAgree']}}</div></td>
                                                                        @endif
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif 

                                                @if($pipeline_details['formData']['businessInterruption']['business_interruption'] ==true &&
                                                $pipeline_details['formData']['accountPayment'] == true)
                                                    <tr>
                                                        @if(isset($pipeline_details['formData']['accountPayment']))
                                                            @for ($i = 0; $i < $insure_count; $i++)
                                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                    @if(isset($insures_details[$i]['accountPayment']['comment']))
                                                                        @if($insures_details[$i]['accountPayment']['comment']!="")
                                                                            <td class="tooltip_sec"><div class="ans">
                                                                                    <span>{{$insures_details[$i]['accountPayment']['isAgree']}}</span>
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details[$i]['accountPayment']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title=""
                                                                                    data-container="body" data-original-title="{{$insures_details[$i]['accountPayment']['comment']}}"></i> --}}
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td><div class="ans">{{$insures_details[$i]['accountPayment']['isAgree']}}</div></td>
                                                                        @endif
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif 

                                                @if($pipeline_details['formData']['businessInterruption']['business_interruption'] ==true &&
                                                $pipeline_details['formData']['preventionDenialClause'] == true)
                                                    <tr>
                                                        @if(isset($pipeline_details['formData']['preventionDenialClause']))
                                                            @for ($i = 0; $i < $insure_count; $i++)
                                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                    @if(isset($insures_details[$i]['preventionDenialClause']['comment']))
                                                                        @if($insures_details[$i]['preventionDenialClause']['comment']!="")
                                                                            <td class="tooltip_sec"><div class="ans">
                                                                                    <span>{{$insures_details[$i]['preventionDenialClause']['isAgree']}}</span>
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details[$i]['preventionDenialClause']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title=""
                                                                                    data-container="body" data-original-title="{{$insures_details[$i]['preventionDenialClause']['comment']}}"></i> --}}
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td><div class="ans">{{$insures_details[$i]['preventionDenialClause']['isAgree']}}</div></td>
                                                                        @endif
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif  

                                                @if($pipeline_details['formData']['businessInterruption']['business_interruption'] ==true &&
                                                $pipeline_details['formData']['premiumAdjClause'] == true)
                                                    <tr>
                                                        @if(isset($pipeline_details['formData']['premiumAdjClause']))
                                                            @for ($i = 0; $i < $insure_count; $i++)
                                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                    @if(isset($insures_details[$i]['premiumAdjClause']['comment']))
                                                                        @if($insures_details[$i]['premiumAdjClause']['comment']!="")
                                                                            <td class="tooltip_sec"><div class="ans">
                                                                                    <span>{{$insures_details[$i]['premiumAdjClause']['isAgree']}}</span>
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details[$i]['premiumAdjClause']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title=""
                                                                                    data-container="body" data-original-title="{{$insures_details[$i]['premiumAdjClause']['comment']}}"></i> --}}
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td><div class="ans">{{$insures_details[$i]['premiumAdjClause']['isAgree']}}</div></td>
                                                                        @endif
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif   

                                                @if($pipeline_details['formData']['businessInterruption']['business_interruption'] ==true &&
                                                $pipeline_details['formData']['publicUtilityClause'] == true)
                                                    <tr>
                                                        @if(isset($pipeline_details['formData']['publicUtilityClause']))
                                                            @for ($i = 0; $i < $insure_count; $i++)
                                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                    @if(isset($insures_details[$i]['publicUtilityClause']['comment']))
                                                                        @if($insures_details[$i]['publicUtilityClause']['comment']!="")
                                                                            <td class="tooltip_sec"><div class="ans">
                                                                                    <span>{{$insures_details[$i]['publicUtilityClause']['isAgree']}}</span>
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details[$i]['publicUtilityClause']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title=""
                                                                                        data-container="body" data-original-title="{{$insures_details[$i]['publicUtilityClause']['comment']}}"></i> --}}
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td><div class="ans">{{$insures_details[$i]['publicUtilityClause']['isAgree']}}</div></td>
                                                                        @endif
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['businessInterruption']['business_interruption'] ==true && 
                                                        $pipeline_details['formData']['brockersClaimHandlingClause'] == true)
                                                        <tr>
                                                            @for ($i = 0; $i < $insure_count; $i++)
                                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                    <td><div class="ans">{{$insures_details[$i]['brockersClaimHandlingClause']}}</div></td>
                                                                @endif
                                                            @endfor
                                                        </tr>
                                                @endif 

                                                @if($pipeline_details['formData']['businessInterruption']['business_interruption'] ==true &&
                                                $pipeline_details['formData']['accountsRecievable'] == true)
                                                    <tr>
                                                        @if(isset($pipeline_details['formData']['accountsRecievable']))
                                                            @for ($i = 0; $i < $insure_count; $i++)
                                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                    @if(isset($insures_details[$i]['accountsRecievable']['comment']))
                                                                        @if($insures_details[$i]['accountsRecievable']['comment']!="")
                                                                            <td class="tooltip_sec"><div class="ans">
                                                                                    <span>{{$insures_details[$i]['accountsRecievable']['isAgree']}}</span>
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details[$i]['accountsRecievable']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title=""
                                                                                        data-container="body" data-original-title="{{$insures_details[$i]['accountsRecievable']['comment']}}"></i>
                                                                                 --}}
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td><div class="ans">{{$insures_details[$i]['accountsRecievable']['isAgree']}}</div></td>
                                                                        @endif
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['businessInterruption']['business_interruption'] ==true && 
                                                $pipeline_details['formData']['interDependency'] == true)
                                                    <tr>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                <td><div class="ans">{{$insures_details[$i]['interDependency']}}</div></td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @endif
                                                
                                                @if($pipeline_details['formData']['businessInterruption']['business_interruption'] ==true &&
                                                    $pipeline_details['formData']['extraExpense'] == true)
                                                    <tr>
                                                        @if(isset($pipeline_details['formData']['extraExpense']))
                                                            @for ($i = 0; $i < $insure_count; $i++)
                                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                    @if(isset($insures_details[$i]['extraExpense']['comment']))
                                                                        @if($insures_details[$i]['extraExpense']['comment']!="")
                                                                            <td class="tooltip_sec"><div class="ans">
                                                                                    <span>{{$insures_details[$i]['extraExpense']['isAgree']}}</span>
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details[$i]['extraExpense']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title=""
                                                                                    data-container="body" data-original-title="{{$insures_details[$i]['extraExpense']['comment']}}"></i> --}}
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td><div class="ans">{{$insures_details[$i]['extraExpense']['isAgree']}}</div></td>
                                                                        @endif
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif 

                                                @if($pipeline_details['formData']['businessInterruption']['business_interruption'] ==true && 
                                                    $pipeline_details['formData']['contaminatedWater'] == true)
                                                    <tr>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                <td><div class="ans">{{$insures_details[$i]['contaminatedWater']}}</div></td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @endif 

                                                @if( $pipeline_details['formData']['businessInterruption']['business_interruption'] ==true &&  $pipeline_details['formData']['expenseReduceLoss']==true)
                                                    <tr>
                                                        @if(isset($pipeline_details['formData']['expenseReduceLoss']))
                                                            @for ($i = 0; $i < $insure_count; $i++)
                                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                    @if(isset($insures_details[$i]['expenseReduceLoss']['comment']))
                                                                        @if($insures_details[$i]['expenseReduceLoss']['comment']!="")
                                                                            <td class="tooltip_sec"><div class="ans">
                                                                                    <span>{{$insures_details[$i]['expenseReduceLoss']['isAgree']}}</span>
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details[$i]['expenseReduceLoss']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title=""
                                                                                    data-container="body" data-original-title="{{$insures_details[$i]['expenseReduceLoss']['comment']}}"></i> --}}
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td><div class="ans">{{$insures_details[$i]['expenseReduceLoss']['isAgree']}}</div></td>
                                                                        @endif
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['businessInterruption']['business_interruption'] ==true &&
                                                    $pipeline_details['formData']['auditorsFeeCheck'] == true)
                                                    <tr>
                                                        @if(isset($pipeline_details['formData']['auditorsFeeCheck']))
                                                            @for ($i = 0; $i < $insure_count; $i++)
                                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                    @if(isset($insures_details[$i]['auditorsFeeCheck']['comment']))
                                                                        @if($insures_details[$i]['auditorsFeeCheck']['comment']!="")
                                                                            <td class="tooltip_sec"><div class="ans">
                                                                                    <span>{{$insures_details[$i]['auditorsFeeCheck']['isAgree']}}</span>
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details[$i]['auditorsFeeCheck']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title=""
                                                                                        data-container="body" data-original-title="{{$insures_details[$i]['auditorsFeeCheck']['comment']}}"></i> --}}
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td><div class="ans">{{$insures_details[$i]['auditorsFeeCheck']['isAgree']}}</div></td>
                                                                        @endif
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif

                                                

                                                @if($pipeline_details['formData']['businessInterruption']['business_interruption'] ==true &&
                                                        $pipeline_details['formData']['nominatedLossAdjuster'] == true)
                                                        <tr>
                                                            @if(isset($pipeline_details['formData']['nominatedLossAdjuster']))
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['nominatedLossAdjuster']['comment']))
                                                                            @if($insures_details[$i]['nominatedLossAdjuster']['comment']!="")
                                                                                <td class="tooltip_sec"><div class="ans">
                                                                                        <span>{{$insures_details[$i]['nominatedLossAdjuster']['isAgree']}}</span>
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['nominatedLossAdjuster']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title=""
                                                                                            data-container="body" data-original-title="{{$insures_details[$i]['nominatedLossAdjuster']['comment']}}"></i> --}}
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['nominatedLossAdjuster']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                @endif

                                                @if($pipeline_details['formData']['businessInterruption']['business_interruption'] ==true &&
                                                    $pipeline_details['formData']['outbreakDiscease'] == true)
                                                    <tr>
                                                        @if(isset($pipeline_details['formData']['outbreakDiscease']))
                                                            @for ($i = 0; $i < $insure_count; $i++)
                                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                    @if(isset($insures_details[$i]['outbreakDiscease']['comment']))
                                                                        @if($insures_details[$i]['outbreakDiscease']['comment']!="")
                                                                            <td class="tooltip_sec"><div class="ans">
                                                                                    <span>{{$insures_details[$i]['outbreakDiscease']['isAgree']}}</span>
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details[$i]['outbreakDiscease']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title=""
                                                                                    data-container="body" data-original-title="{{$insures_details[$i]['outbreakDiscease']['comment']}}"></i> --}}
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td><div class="ans">{{$insures_details[$i]['outbreakDiscease']['isAgree']}}</div></td>
                                                                        @endif
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['businessInterruption']['business_interruption'] ==true &&
                                                    $pipeline_details['formData']['nonPublicFailure'] == true)
                                                    <tr>
                                                        @if(isset($pipeline_details['formData']['nonPublicFailure']))
                                                            @for ($i = 0; $i < $insure_count; $i++)
                                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                    @if(isset($insures_details[$i]['nonPublicFailure']['comment']))
                                                                        @if($insures_details[$i]['nonPublicFailure']['comment']!="")
                                                                            <td class="tooltip_sec"><div class="ans">
                                                                                    <span>{{$insures_details[$i]['nonPublicFailure']['isAgree']}}</span>
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details[$i]['nonPublicFailure']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title=""
                                                                                        data-container="body" data-original-title="{{$insures_details[$i]['nonPublicFailure']['comment']}}"></i> --}}
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td><div class="ans">{{$insures_details[$i]['nonPublicFailure']['isAgree']}}</div></td>
                                                                        @endif
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['businessInterruption']['business_interruption'] ==true &&
                                                    $pipeline_details['formData']['premisesDetails'] == true)
                                                    <tr>
                                                        @if(isset($pipeline_details['formData']['premisesDetails']))
                                                            @for ($i = 0; $i < $insure_count; $i++)
                                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                    @if(isset($insures_details[$i]['premisesDetails']['comment']))
                                                                        @if($insures_details[$i]['premisesDetails']['comment']!="")
                                                                            <td class="tooltip_sec"><div class="ans">
                                                                                    <span>{{$insures_details[$i]['premisesDetails']['isAgree']}}</span>
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details[$i]['premisesDetails']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title=""
                                                                                    data-container="body" data-original-title="{{$insures_details[$i]['premisesDetails']['comment']}}"></i> --}}
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td><div class="ans">{{$insures_details[$i]['premisesDetails']['isAgree']}}</div></td>
                                                                        @endif
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['businessInterruption']['business_interruption'] ==true &&
                                                    $pipeline_details['formData']['bombscare'] == true)
                                                    <tr>
                                                        @if(isset($pipeline_details['formData']['bombscare']))
                                                            @for ($i = 0; $i < $insure_count; $i++)
                                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                    @if(isset($insures_details[$i]['bombscare']['comment']))
                                                                        @if($insures_details[$i]['bombscare']['comment']!="")
                                                                            <td class="tooltip_sec"><div class="ans">
                                                                                    <span>{{$insures_details[$i]['bombscare']['isAgree']}}</span>
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details[$i]['bombscare']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title=""
                                                                                        data-container="body" data-original-title="{{$insures_details[$i]['bombscare']['comment']}}"></i> --}}
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td><div class="ans">{{$insures_details[$i]['bombscare']['isAgree']}}</div></td>
                                                                        @endif
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['businessInterruption']['business_interruption'] ==true &&
                                                    $pipeline_details['formData']['DenialClause'] == true)
                                                    <tr>
                                                        @if(isset($pipeline_details['formData']['DenialClause']))
                                                            @for ($i = 0; $i < $insure_count; $i++)
                                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                    @if(isset($insures_details[$i]['DenialClause']['comment']))
                                                                        @if($insures_details[$i]['DenialClause']['comment']!="")
                                                                            <td class="tooltip_sec"><div class="ans">
                                                                                    <span>{{$insures_details[$i]['DenialClause']['isAgree']}}</span>
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details[$i]['DenialClause']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title=""
                                                                                        data-container="body" data-original-title="{{$insures_details[$i]['bombscare']['comment']}}"></i> --}}
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td><div class="ans">{{$insures_details[$i]['DenialClause']['isAgree']}}</div></td>
                                                                        @endif
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif
         
                                                @if($pipeline_details['formData']['businessInterruption']['business_interruption'] ==true &&
                                                    $pipeline_details['formData']['bookDebits'] == true)
                                                    <tr>
                                                        @if(isset($pipeline_details['formData']['bookDebits']))
                                                            @for ($i = 0; $i < $insure_count; $i++)
                                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                    @if(isset($insures_details[$i]['bookDebits']['comment']))
                                                                        @if($insures_details[$i]['bookDebits']['comment']!="")
                                                                            <td class="tooltip_sec"><div class="ans">
                                                                                    <span>{{$insures_details[$i]['bookDebits']['isAgree']}}</span>
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details[$i]['bookDebits']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title=""
                                                                                    data-container="body" data-original-title="{{$insures_details[$i]['bookDebits']['comment']}}"></i> --}}
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td><div class="ans">{{$insures_details[$i]['bookDebits']['isAgree']}}</div></td>
                                                                        @endif
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['businessInterruption']['business_interruption'] ==true &&
                                                                $pipeline_details['formData']['publicFailure'] == true)
                                                        <tr>
                                                            @if(isset($pipeline_details['formData']['publicFailure']))
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['publicFailure']['comment']))
                                                                            @if($insures_details[$i]['publicFailure']['comment']!="")
                                                                                <td class="tooltip_sec"><div class="ans">
                                                                                        <span>{{$insures_details[$i]['publicFailure']['isAgree']}}</span>
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['publicFailure']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title=""
                                                                                        data-container="body" data-original-title="{{$insures_details[$i]['publicFailure']['comment']}}"></i> --}}
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['publicFailure']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                @endif

                                                @if($pipeline_details['formData']['businessInterruption']['business_interruption'] ==true &&
                                                $pipeline_details['formData']['businessInterruption']['noLocations']>1 && 
                                                $pipeline_details['formData']['departmentalClause'] == true)
                                                    <tr>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                <td><div class="ans">{{$insures_details[$i]['departmentalClause']}}</div></td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @endif

                                                @if($pipeline_details['formData']['businessInterruption']['business_interruption'] ==true &&
                                                    $pipeline_details['formData']['businessInterruption']['noLocations']>1 &&
                                                    $pipeline_details['formData']['rentLease'] == true)
                                                    <tr>
                                                        @if(isset($pipeline_details['formData']['rentLease']))
                                                            @for ($i = 0; $i < $insure_count; $i++)
                                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                    @if(isset($insures_details[$i]['rentLease']['comment']))
                                                                        @if($insures_details[$i]['rentLease']['comment']!="")
                                                                            <td class="tooltip_sec"><div class="ans">
                                                                                    <span>{{$insures_details[$i]['rentLease']['isAgree']}}</span>
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details[$i]['rentLease']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title=""
                                                                                    data-container="body" data-original-title="{{$insures_details[$i]['rentLease']['comment']}}"></i> --}}
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td><div class="ans">{{$insures_details[$i]['rentLease']['isAgree']}}</div></td>
                                                                        @endif
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif 

                                            
                                                @if($pipeline_details['formData']['businessInterruption']['business_interruption'] ==true &&
                                                    $pipeline_details['formData']['businessInterruption']['noLocations']>1 &&
                                                    $pipeline_details['formData']['CoverAccomodation']['coverAccomodation'] == true)
                                                    <tr>
                                                            @if($pipeline_details['formData']['CoverAccomodation']['coverAccomodation'] == true)
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['coverAccomodation']['comment']))
                                                                            @if($insures_details[$i]['coverAccomodation']['comment']!="")
                                                                                <td class="tooltip_sec"><div class="ans">
                                                                                        <span>{{$insures_details[$i]['coverAccomodation']['isAgree']}}</span>
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['coverAccomodation']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title=""
                                                                                        data-container="body" data-original-title="{{$insures_details[$i]['coverAccomodation']['comment']}}"></i> --}}
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['coverAccomodation']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                @endif 

                                            

     @if($pipeline_details['formData']['businessInterruption']['business_interruption'] ==true && $pipeline_details['formData']['demolitionCost'] == true)
         <tr>
             @if(isset($pipeline_details['formData']['demolitionCost']))
                 @for ($i = 0; $i < $insure_count; $i++)
                     @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                         @if(isset($insures_details[$i]['demolitionCost']['comment']))
                             @if($insures_details[$i]['demolitionCost']['comment']!="")
                                 <td class="tooltip_sec"><div class="ans">
                                         <span>{{$insures_details[$i]['demolitionCost']['isAgree']}}</span>
                                         <div class="post_comments">
                                            <div class="post_comments_main clearfix">
                                                <div class="media">
                                                    <div class="media-body">
                                                        <span  class="comment_txt">{{$insures_details[$i]['demolitionCost']['comment']}}</span>        
                                                    </div>
                                                  
                                                </div>
                                            </div>
                                        </div>
                                         {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title=""
                                          data-container="body" data-original-title="{{$insures_details[$i]['demolitionCost']['comment']}}"></i> --}}
                                     </div>
                                 </td>
                             @else
                                 <td><div class="ans">{{$insures_details[$i]['demolitionCost']['isAgree']}}</div></td>
                             @endif
                         @else
                             <td><div class="ans">--</div></td>
                         @endif
                     @endif
                 @endfor
             @endif
         </tr>
     @endif  
              
     @if($pipeline_details['formData']['businessInterruption']['business_interruption'] ==true && $pipeline_details['formData']['contingentBusiness'] == true)
         <tr>
             @if(isset($pipeline_details['formData']['contingentBusiness']))
                 @for ($i = 0; $i < $insure_count; $i++)
                     @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                         @if(isset($insures_details[$i]['contingentBusiness']['comment']))
                             @if($insures_details[$i]['contingentBusiness']['comment']!="")
                                 <td class="tooltip_sec"><div class="ans">
                                         <span>{{$insures_details[$i]['contingentBusiness']['isAgree']}}</span>
                                         <div class="post_comments">
                                                <div class="post_comments_main clearfix">
                                                    <div class="media">
                                                        <div class="media-body">
                                                            <span  class="comment_txt">{{$insures_details[$i]['contingentBusiness']['comment']}}</span>        
                                                        </div>
                                                      
                                                    </div>
                                                </div>
                                            </div>
                                         {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title=""
                                          data-container="body" data-original-title="{{$insures_details[$i]['contingentBusiness']['comment']}}"></i> --}}
                                     </div>
                                 </td>
                             @else
                                 <td><div class="ans">{{$insures_details[$i]['contingentBusiness']['isAgree']}}</div></td>
                             @endif
                         @else
                             <td><div class="ans">--</div></td>
                         @endif
                     @endif
                 @endfor
             @endif
         </tr>
     @endif  
                                   
     @if($pipeline_details['formData']['businessInterruption']['business_interruption'] ==true && $pipeline_details['formData']['nonOwnedProperties'] == true)
     <tr>
         @if(isset($pipeline_details['formData']['nonOwnedProperties']))
             @for ($i = 0; $i < $insure_count; $i++)
                 @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                     @if(isset($insures_details[$i]['nonOwnedProperties']['comment']))
                         @if($insures_details[$i]['nonOwnedProperties']['comment']!="")
                             <td class="tooltip_sec"><div class="ans">
                                     <span>{{$insures_details[$i]['nonOwnedProperties']['isAgree']}}</span>
                                     <div class="post_comments">
                                            <div class="post_comments_main clearfix">
                                                <div class="media">
                                                    <div class="media-body">
                                                        <span  class="comment_txt">{{$insures_details[$i]['nonOwnedProperties']['comment']}}</span>        
                                                    </div>
                                                  
                                                </div>
                                            </div>
                                        </div>
                                     {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title=""
                                      data-container="body" data-original-title="{{$insures_details[$i]['nonOwnedProperties']['comment']}}"></i> --}}
                                 </div>
                             </td>
                         @else
                             <td><div class="ans">{{$insures_details[$i]['nonOwnedProperties']['isAgree']}}</div></td>
                         @endif
                     @else
                         <td><div class="ans">--</div></td>
                     @endif
                 @endif
             @endfor
         @endif
     </tr>
 @endif  
  @if($pipeline_details['formData']['businessInterruption']['business_interruption'] ==true && $pipeline_details['formData']['royalties'] == true)
     <tr>
         @for ($i = 0; $i < $insure_count; $i++)
             @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                 <td><div class="ans">{{$insures_details[$i]['royalties']}}</div></td>
             @endif
         @endfor
     </tr>
 @endif 
 @if(isset($pipeline_details['formData']['cliamPremium']) && $pipeline_details['formData']['cliamPremium'] =='combined_data') 
 <tr>
     @for ($i = 0; $i < $insure_count; $i++)
         @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
             <td><div class="ans">{{number_format($insures_details[$i]['claimPremiyumDetails']['deductableProperty'],2)}}</div></td>
         @endif
     @endfor
 </tr> 
@endif
@if(isset($pipeline_details['formData']['cliamPremium']) && $pipeline_details['formData']['cliamPremium'] =='combined_data') 
 <tr>
     @for ($i = 0; $i < $insure_count; $i++)
         @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
             <td><div class="ans">{{number_format($insures_details[$i]['claimPremiyumDetails']['deductableBusiness'],2)}}</div></td>
         @endif
     @endfor
 </tr> 
@endif
@if(isset($pipeline_details['formData']['cliamPremium']) && $pipeline_details['formData']['cliamPremium'] =='combined_data') 
 <tr>
     @for ($i = 0; $i < $insure_count; $i++)
         @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
             <td><div class="ans">{{number_format($insures_details[$i]['claimPremiyumDetails']['rateCombined'],2)}}</div></td>
         @endif
     @endfor
 </tr> 
@endif
@if(isset($pipeline_details['formData']['cliamPremium']) && $pipeline_details['formData']['cliamPremium'] =='combined_data') 
 <tr>
     @for ($i = 0; $i < $insure_count; $i++)
         @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
             <td><div class="ans">{{number_format($insures_details[$i]['claimPremiyumDetails']['premiumCombined'],2)}}</div></td>
         @endif
     @endfor
 </tr> 
@endif
@if(isset($pipeline_details['formData']['cliamPremium']) && $pipeline_details['formData']['cliamPremium'] =='combined_data') 
 <tr>
     @for ($i = 0; $i < $insure_count; $i++)
         @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
             <td><div class="ans">{{number_format($insures_details[$i]['claimPremiyumDetails']['brokerage'],2)}}</div></td>
         @endif
     @endfor
 </tr> 
@endif
@if(isset($pipeline_details['formData']['cliamPremium']) && $pipeline_details['formData']['cliamPremium'] =='combined_data') 
 <tr>
     @for ($i = 0; $i < $insure_count; $i++)
         @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
             <td><div class="ans">{{$insures_details[$i]['claimPremiyumDetails']['warrantyProperty']}}</div></td>
         @endif
     @endfor
 </tr> 
@endif
@if(isset($pipeline_details['formData']['cliamPremium']) && $pipeline_details['formData']['cliamPremium'] =='combined_data') 
 <tr>
     @for ($i = 0; $i < $insure_count; $i++)
         @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
             <td><div class="ans">{{$insures_details[$i]['claimPremiyumDetails']['warrantyBusiness']}}</div></td>
         @endif
     @endfor
 </tr> 
@endif
@if(isset($pipeline_details['formData']['cliamPremium']) && $pipeline_details['formData']['cliamPremium'] =='combined_data') 
 <tr>
     @for ($i = 0; $i < $insure_count; $i++)
         @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
             <td><div class="ans">{{$insures_details[$i]['claimPremiyumDetails']['exclusionProperty']}}</div></td>
         @endif
     @endfor
 </tr> 
@endif
@if(isset($pipeline_details['formData']['cliamPremium']) && $pipeline_details['formData']['cliamPremium'] =='combined_data') 
 <tr>
     @for ($i = 0; $i < $insure_count; $i++)
         @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
             <td><div class="ans">{{$insures_details[$i]['claimPremiyumDetails']['exclusionBusiness']}}</div></td>
         @endif
     @endfor
 </tr> 
@endif
@if(isset($pipeline_details['formData']['cliamPremium']) && $pipeline_details['formData']['cliamPremium'] =='combined_data') 
 <tr>
     @for ($i = 0; $i < $insure_count; $i++)
         @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
             <td><div class="ans">{{$insures_details[$i]['claimPremiyumDetails']['specialProperty']}}</div></td>
         @endif
     @endfor
 </tr> 
@endif
@if(isset($pipeline_details['formData']['cliamPremium']) && $pipeline_details['formData']['cliamPremium'] =='combined_data') 
 <tr>
     @for ($i = 0; $i < $insure_count; $i++)
         @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
             <td><div class="ans">{{$insures_details[$i]['claimPremiyumDetails']['specialBusiness']}}</div></td>
         @endif
     @endfor
 </tr> 
@endif
@if(isset($pipeline_details['formData']['cliamPremium']) && $pipeline_details['formData']['cliamPremium'] =='only_fire') 
 <tr>
     @for ($i = 0; $i < $insure_count; $i++)
         @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
             <td><div class="ans">{{number_format($insures_details[$i]['claimPremiyumDetails']['deductableProperty'],2)}}</div></td>
         @endif
     @endfor
 </tr> 
@endif
@if(isset($pipeline_details['formData']['cliamPremium']) && $pipeline_details['formData']['cliamPremium'] =='only_fire') 
 <tr>
     @for ($i = 0; $i < $insure_count; $i++)
         @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
             <td><div class="ans">{{number_format($insures_details[$i]['claimPremiyumDetails']['propertyRate'],2)}}</div></td>
         @endif
     @endfor
 </tr> 
@endif
@if(isset($pipeline_details['formData']['cliamPremium']) && $pipeline_details['formData']['cliamPremium'] =='only_fire') 
 <tr>
     @for ($i = 0; $i < $insure_count; $i++)
         @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
             <td><div class="ans">{{number_format($insures_details[$i]['claimPremiyumDetails']['propertyPremium'],2)}}</div></td>
         @endif
     @endfor
 </tr> 
@endif
@if(isset($pipeline_details['formData']['cliamPremium']) && $pipeline_details['formData']['cliamPremium'] =='only_fire') 
 <tr>
     @for ($i = 0; $i < $insure_count; $i++)
         @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
             <td><div class="ans">{{number_format($insures_details[$i]['claimPremiyumDetails']['propertyBrockerage'],2)}}</div></td>
         @endif
     @endfor
 </tr> 
@endif
@if(isset($pipeline_details['formData']['cliamPremium']) && $pipeline_details['formData']['cliamPremium'] =='only_fire') 
 <tr>
     @for ($i = 0; $i < $insure_count; $i++)
         @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
             <td><div class="ans">{{$insures_details[$i]['claimPremiyumDetails']['propertyWarranty']}}</div></td>
         @endif
     @endfor
 </tr> 
@endif
@if(isset($pipeline_details['formData']['cliamPremium']) && $pipeline_details['formData']['cliamPremium'] =='only_fire') 
 <tr>
     @for ($i = 0; $i < $insure_count; $i++)
         @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
             <td><div class="ans">{{$insures_details[$i]['claimPremiyumDetails']['propertyExclusion']}}</div></td>
         @endif
     @endfor
 </tr> 
@endif
@if(isset($pipeline_details['formData']['cliamPremium']) && $pipeline_details['formData']['cliamPremium'] =='only_fire') 
 <tr>
     @for ($i = 0; $i < $insure_count; $i++)
         @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
             <td><div class="ans">{{$insures_details[$i]['claimPremiyumDetails']['propertySpecial']}}</div></td>
         @endif
     @endfor
 </tr> 
@endif
@if(isset($pipeline_details['formData']['cliamPremium']) && $pipeline_details['formData']['cliamPremium'] =='separate_fire') 
 <tr>
     @for ($i = 0; $i < $insure_count; $i++)
         @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
             <td><div class="ans">{{number_format($insures_details[$i]['claimPremiyumDetails']['propertySeparateDeductable'],2)}}</div></td>
         @endif
     @endfor
 </tr> 
@endif
@if(isset($pipeline_details['formData']['cliamPremium']) && $pipeline_details['formData']['cliamPremium'] =='separate_fire') 
 <tr>
     @for ($i = 0; $i < $insure_count; $i++)
         @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
             <td><div class="ans">{{number_format($insures_details[$i]['claimPremiyumDetails']['propertySeparateRate'],2)}}</div></td>
         @endif
     @endfor
 </tr> 
@endif
@if(isset($pipeline_details['formData']['cliamPremium']) && $pipeline_details['formData']['cliamPremium'] =='separate_fire') 
 <tr>
     @for ($i = 0; $i < $insure_count; $i++)
         @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
             <td><div class="ans">{{number_format($insures_details[$i]['claimPremiyumDetails']['propertySeparatePremium'],2)}}</div></td>
         @endif
     @endfor
 </tr> 
@endif
@if(isset($pipeline_details['formData']['cliamPremium']) && $pipeline_details['formData']['cliamPremium'] =='separate_fire') 
 <tr>
     @for ($i = 0; $i < $insure_count; $i++)
         @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
             <td><div class="ans">{{number_format($insures_details[$i]['claimPremiyumDetails']['propertySeparateBrokerage'],2)}}</div></td>
         @endif
     @endfor
 </tr> 
@endif
@if(isset($pipeline_details['formData']['cliamPremium']) && $pipeline_details['formData']['cliamPremium'] =='separate_fire') 
 <tr>
     @for ($i = 0; $i < $insure_count; $i++)
         @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
             <td><div class="ans">{{$insures_details[$i]['claimPremiyumDetails']['propertySeparateWarranty']}}</div></td>
         @endif
     @endfor
 </tr> 
@endif
@if(isset($pipeline_details['formData']['cliamPremium']) && $pipeline_details['formData']['cliamPremium'] =='separate_fire') 
 <tr>
     @for ($i = 0; $i < $insure_count; $i++)
         @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
             <td><div class="ans">{{$insures_details[$i]['claimPremiyumDetails']['propertySeparateExclusion']}}</div></td>
         @endif
     @endfor
 </tr> 
@endif
@if(isset($pipeline_details['formData']['cliamPremium']) && $pipeline_details['formData']['cliamPremium'] =='separate_fire') 
 <tr>
     @for ($i = 0; $i < $insure_count; $i++)
         @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
             <td><div class="ans">{{$insures_details[$i]['claimPremiyumDetails']['propertySeparateSpecial']}}</div></td>
         @endif
     @endfor
 </tr> 
@endif
@if(isset($pipeline_details['formData']['cliamPremium']) && $pipeline_details['formData']['cliamPremium'] =='separate_fire') 
<tr>
    @for ($i = 0; $i < $insure_count; $i++)
        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
            <td><div class="ans">{{number_format($insures_details[$i]['claimPremiyumDetails']['businessSeparateDeductable'],2)}}</div></td>
        @endif
    @endfor
</tr> 
@endif
@if(isset($pipeline_details['formData']['cliamPremium']) && $pipeline_details['formData']['cliamPremium'] =='separate_fire') 
<tr>
    @for ($i = 0; $i < $insure_count; $i++)
        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
            <td><div class="ans">{{number_format($insures_details[$i]['claimPremiyumDetails']['businessSeparateRate'],2)}}</div></td>
        @endif
    @endfor
</tr> 
@endif
@if(isset($pipeline_details['formData']['cliamPremium']) && $pipeline_details['formData']['cliamPremium'] =='separate_fire') 
<tr>
    @for ($i = 0; $i < $insure_count; $i++)
        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
            <td><div class="ans">{{number_format($insures_details[$i]['claimPremiyumDetails']['businessSeparatePremium'],2)}}</div></td>
        @endif
    @endfor
</tr> 
@endif
@if(isset($pipeline_details['formData']['cliamPremium']) && $pipeline_details['formData']['cliamPremium'] =='separate_fire') 
<tr>
    @for ($i = 0; $i < $insure_count; $i++)
        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
            <td><div class="ans">{{number_format($insures_details[$i]['claimPremiyumDetails']['businessSeparateBrokerage'],2)}}</div></td>
        @endif
    @endfor
</tr> 
@endif
@if(isset($pipeline_details['formData']['cliamPremium']) && $pipeline_details['formData']['cliamPremium'] =='separate_fire') 
<tr>
    @for ($i = 0; $i < $insure_count; $i++)
        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
            <td><div class="ans">{{$insures_details[$i]['claimPremiyumDetails']['businessSeparateWarranty']}}</div></td>
        @endif
    @endfor
</tr> 
@endif
@if(isset($pipeline_details['formData']['cliamPremium']) && $pipeline_details['formData']['cliamPremium'] =='separate_fire') 
<tr>
    @for ($i = 0; $i < $insure_count; $i++)
        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
            <td><div class="ans">{{$insures_details[$i]['claimPremiyumDetails']['businessSeparateExclusion']}}</div></td>
        @endif
    @endfor
</tr> 
@endif
@if(isset($pipeline_details['formData']['cliamPremium']) && $pipeline_details['formData']['cliamPremium'] =='separate_fire') 
<tr>
    @for ($i = 0; $i < $insure_count; $i++)
        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
            <td><div class="ans">{{$insures_details[$i]['claimPremiyumDetails']['businessSeparateSpecial']}}</div></td>
        @endif
    @endfor
</tr> 
@endif

                                                <tr>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['customerDecision']))
                                                                <td><div class="ans">
                                                                        {{@$insures_details[$i]['customerDecision']['decision']}}
                                                                        @if(isset($insures_details[$i]['customerDecision']['rejctReason']) && $insures_details[$i]['customerDecision']['rejctReason']!='') 
                                                                        ( Reason:{{@$insures_details[$i]['customerDecision']['rejctReason']}})
                                                                      @endif 
                                                                        @if(@$insures_details[$i]['customerDecision']['comment'] != "")
                                                                            <br> Comment : {{@$insures_details[$i]['customerDecision']['comment']}}
                                                                        @endif
                                                                    </div> </td>
                                                            @else
                                                                <td><div class="ans">NA</div></td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(isset($pipeline_details['status']['status']) && 
                        ($pipeline_details['status']['status']=='Quote Amendment' || $pipeline_details['status']['status']=='Quote Amendment-E-slip' ||
                        $pipeline_details['status']['status']=='Quote Amendment-E-quotation' || $pipeline_details['status']['status']=='Quote Amendment-E-comparison'))
                        <button class="btn btn-primary btn_action pull-right" id="button_submit" onclick="closeCase()" type="button">Close the case</button>
                      @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .section_details{
            max-width: 100%;
        }

        .height_fix tbody {
            height: calc(100vh - 400px);
        }
    </style>
    @include('includes.chat')
@endsection
@push('scripts')
    <script>
          function closeCase()
        {
                var id = $('#pipeline_id').val();
                $('#preLoader').show();
                $.ajax({
                    method: 'post',
                    url: '{{url('close-pipeline')}}',
                    data: {
                        id:id,
                        _token: '{{csrf_token()}}'
                    },
                    success:function(data){
                        if(data == 'success')
                        {
                            location.href = "{{url('closed-pipelines')}}"; 
                        }
                    }
                });
        }
        $(document).ready(function(){
            setTimeout(function() {
                $('#success_div').fadeOut('fast');
            }, 5000);
        });
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
    </script>

    <script src="{{URL::asset('js/syncscroll.js')}}"></script>
@endpush
